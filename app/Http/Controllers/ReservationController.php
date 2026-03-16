<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\PrivateLessonRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MeasurementAssignment;
use App\Models\MeasurementReservation;
use App\Models\PrivateLesson;
use App\Models\PrivateLessonPackage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Ölçüm rezervasyonu oluşturma formunu gösterir.
     */
    public function calendar()
    {
        $today = Carbon::today();
        $daysInMonth = $today->daysInMonth;
        $monthName = $today->translatedFormat('F Y');

        return view('booking.calendar', [
            'daysInMonth' => $daysInMonth,
            'monthName' => $monthName,
            'today' => $today->day,
        ]);
    }

    public function selectTrainerForMeasurement(Request $request)
    {

        $request->validate(['date' => 'required|date']);

        $trainers = User::where('role', 'trainer')->get();
        $selectedDate = $request->date;

        return view('reservations.measurement-select-trainer', [
            'trainers' => $trainers,
            'selectedDate' => $selectedDate,
        ]);
    }
    /**
     * Ölçüm rezervasyonunu veritabanına kaydeder.
     */
    public function storeMeasurement(Request $request)
    {
        $request->validate([
            'trainer_id' => 'required|exists:users,id',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required|date_format:H:i',
        ]);

        $member = Auth::user()->member;
        $dateTime = $request->reservation_date . ' ' . $request->reservation_time;

        try {
            DB::transaction(function () use ($request, $member, $dateTime) {
                $defaultMeasurement = Measurement::firstOrFail();

                // 1. Anlık "atama" oluştur
                $assignment = MeasurementAssignment::create([
                    'member_id' => $member->id,
                    'trainer_id' => $request->trainer_id,
                    'measurement_id' => $defaultMeasurement->id,
                    'status' => 'pending',

                    // DEĞİŞİKLİK BURADA: 'now()' yerine seçilen tarih ve saat kullanıldı
                    'assignment_date' => $dateTime,

                    'expiration_date' => now()->addYear(),
                ]);

                MeasurementReservation::create([
                    'measurement_assignment_id' => $assignment->id,
                    'member_id' => $member->id,
                    'trainer_id' => $request->trainer_id,
                    'reservation_date' => $dateTime,
                    'status' => 'pending',
                ]);
            });
        } catch(\Exception $e) {
            return redirect()->route('booking.calendar')->with('error', 'Rezervasyon oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }

        return redirect()->route('booking.calendar')->with('success', 'Ölçüm randevunuz başarıyla oluşturulmuştur.');
    }
    public function selectTrainerForPrivateLesson(Request $request)
    {
        $request->validate(['date' => 'required|date']);

        $trainers = User::where('role', 'trainer')->get();
        $selectedDate = $request->date;

        // Artık view'e paket bilgisi göndermiyoruz
        return view('reservations.private-lesson-select-trainer', [
            'trainers' => $trainers,
            'selectedDate' => $selectedDate,
        ]);
    }
    public function createPrivateLesson()
    {
        $member = Auth::user()->member;

        // Üyenin kalan ders hakkı olan aktif bir paketi var mı?
        $activePackage = PrivateLessonPackage::where('member_id', $member->user_id)
            ->where('status', 'active')
            ->where('remaining_sessions', '>', 0)
            ->where('end_date', '>=', now())
            ->first();

        if (!$activePackage) {
            return redirect()->route('booking.calendar')->with('error', 'Aktif bir özel ders paketiniz veya kalan ders hakkınız bulunmamaktadır.');
        }

        $trainers = User::where('role', 'trainer')->get();

        return view('reservations.private-lesson-create', [
            'package' => $activePackage,
            'trainers' => $trainers
        ]);
    }
    public function storePrivateLesson(Request $request)
    {
        $request->validate([
            'trainer_id' => 'required|exists:users,id',
            'lesson_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
        ]);

        $member = Auth::user()->member;
        $startTime = Carbon::parse($request->lesson_date . ' ' . $request->start_time);

        // Yeni bir özel ders talebi oluştur
        PrivateLessonRequest::create([
            'member_id' => $member->id,
            'trainer_id' => $request->trainer_id,
            'created_by' => Auth::id(), // Talebi oluşturan kullanıcı
            'status' => 'pending', // Portal'dan onay bekliyor
            'request_type' => 'member', // Talep üye tarafından oluşturuldu
            'lesson_date' => $request->lesson_date,
            'start_time' => $request->start_time,
            'end_time' => $startTime->addHour()->format('H:i:s'), // 1 saatlik ders varsayımı
            'scheduled_at' => $startTime,
        ]);

        return redirect()->route('booking.calendar')->with('success', 'Özel ders talebiniz başarıyla alınmıştır. Onay için bekleniyor.');
    }
}
