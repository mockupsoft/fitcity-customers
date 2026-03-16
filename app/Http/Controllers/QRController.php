<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Studio;
use App\Models\GroupClass;
use App\Models\GroupClassParticipant;
use App\Models\Member;
use App\Models\StudioCheckIn;
use Carbon\Carbon;

class QRController extends Controller
{
    public function index()
    {
        return view('qr.index');
    }

    public function scanner()
    {
        return view('qr.scanner');
    }

    public function processStudioCheckIn($studio_id)
    {
        $user = Auth::guard('web')->user() ?? Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Lütfen sisteme giriş yapıp QR kodu tekrar okutun.'
            ], 401);
        }

        $now = Carbon::now();
        $currentTime = $now->format('H:i:s');
        $currentDate = $now->toDateString();

        $checkInWindowStart = $now->copy()->addMinutes(15)->format('H:i:s');

        $activeClass = GroupClass::where('studio_id', $studio_id)
            ->where('class_date', $currentDate)
            ->where('start_time', '<=', $checkInWindowStart)
            ->where('end_time', '>=', $currentTime)
            ->where('status', 'scheduled')
            ->first();

        if (!$activeClass) {
            return response()->json([
                'success' => false,
                'message' => 'Şu anda bu stüdyoda aktif veya başlamak üzere olan bir ders bulunmuyor.'
            ], 404);
        }

        $member = Member::where('user_id', $user->id)->first();

        $participant = GroupClassParticipant::where('group_class_id', $activeClass->id)
            ->where('member_id', $user->id)
            ->first();

        if ($participant) {
            $participant->update([
                'check_in_time' => Carbon::now(),
                'status' => 'attended'
            ]);
        } else {
            GroupClassParticipant::create([
                'group_class_id' => $activeClass->id,
                'member_id' => $user->id,
                'check_in_time' => Carbon::now(),
                'status' => 'attended'
            ]);

            $activeClass->increment('current_participants');
        }

        if ($member) {
            $studio = Studio::find($studio_id);
            $studioName = $studio ? $studio->name : 'Bilinmeyen Stüdyo';

            StudioCheckIn::create([
                'member_id' => $member->id,
                'club_id' => $user->club_id ?? $member->club_id,
                'studio_name' => $studioName,
                'check_in_time' => Carbon::now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $activeClass->name . ' dersine başarıyla giriş yaptınız. İyi antrenmanlar!'
        ], 200);
    }
}
