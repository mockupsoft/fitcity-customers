<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\StudioCheckIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckInController extends Controller
{
    public function processStudioCheckIn(Request $request)
    {
        $validated = $request->validate([
            'group_class_id' => 'required|integer|exists:group_classes,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Giriş yapmış kullanıcı bulunamadı.'], 403);
        }

        // Kullanıcının üye kaydı var mı?
        // Eğer sistemde User -> Member ilişkisi varsa:
        $member = $user->member;
        // Veya doğrudan User üzerinden işlem yapıyorsanız $user->id kullanabilirsiniz.

        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Üye kaydı bulunamadı.'], 403);
        }

        // İlgili dersi bul
        $groupClass = \App\Models\GroupClass::with('trainer.club')->find($validated['group_class_id']);

        // Kulüp konumunu al (Eğitmenin bağlı olduğu kulüp veya dersin yapıldığı kulüp)
        // Burada GroupClass modelinde 'club_id' varsa onu, yoksa eğitmenin kulübünü kullanıyoruz.
        // Senin GroupClass modelinde club_id yok, trainer_id var. Trainer'ın club_id'sini alalım.
        $club = $groupClass->trainer->club;

        if (!$club) {
            return response()->json(['success' => false, 'message' => 'Dersin bağlı olduğu kulüp bulunamadı.'], 404);
        }

        // Mesafe Kontrolü (100 metre tolerans - stüdyo içi)
        // Not: Kulüp modelinde latitude ve longitude sütunları olmalı.
        // Eğer yoksa bu kontrolü geçici olarak devre dışı bırakabilirsin veya dummy veri kullanabilirsin.
        if ($club->latitude && $club->longitude) {
            $distance = $this->calculateDistance(
                $validated['latitude'],
                $validated['longitude'],
                $club->latitude,
                $club->longitude
            );

            if ($distance > 0.1) { // 0.1 km = 100 metre
                return response()->json([
                    'success' => false,
                    'message' => 'Stüdyo konumunda değilsiniz. Uzaklık: ' . round($distance * 1000) . ' metre.'
                ], 400);
            }
        }

        // Derse kayıtlı mı kontrolü
        $isRegistered = \App\Models\GroupClassParticipant::where('group_class_id', $groupClass->id)
            ->where('member_id', $user->id) // Tablonda member_id user_id tutuyorsa
            ->exists();

        if (!$isRegistered) {
            // Kayıtlı değilse otomatik kayıt et (Opsiyonel: Veya hata dön)
            // Hata dönmek daha güvenli:
            // return response()->json(['success' => false, 'message' => 'Bu derse kaydınız bulunmamaktadır.'], 400);

            // Otomatik kayıt için:
            \App\Models\GroupClassParticipant::create([
                'group_class_id' => $groupClass->id,
                'member_id' => $user->id,
                'status' => 'attended' // Katıldı olarak işaretle
            ]);
            $groupClass->increment('current_participants');
        } else {
            // Zaten kayıtlıysa durumunu 'attended' (katıldı) yap
            \App\Models\GroupClassParticipant::where('group_class_id', $groupClass->id)
                ->where('member_id', $user->id)
                ->update(['status' => 'attended']);
        }

        // Check-in kaydı oluştur (Opsiyonel, eğer ayrıca log tutmak istersen)
        // StudioCheckIn::create([...]);

        return response()->json([
            'success' => true,
            'message' => $groupClass->name . ' dersine girişiniz başarıyla yapıldı!'
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            return ($miles * 1.609344);
        }
    }
}
