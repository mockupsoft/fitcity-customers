<?php

namespace App\Http\Controllers;

use App\Models\GroupClass;
use Illuminate\Http\Request;
use App\Models\GroupClassParticipant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class GroupClassController extends Controller
{
    /**
     * Tüm grup derslerini listeler.
     */
    public function index()
    {
        // Eager loading ile eğitmen bilgisini de alıyoruz (N+1 problemini önler)
        $groupClasses = GroupClass::with('trainer')->where('status', 'scheduled')->get();

        return view('group-classes.index', [
            'groupClasses' => $groupClasses
        ]);
    }
    public function join(GroupClass $groupClass)
    {
        $member = Auth::user()->member;

        // Kontroller
        if ($groupClass->current_participants >= $groupClass->capacity) {
            return back()->with('error', 'Bu dersin kontenjanı dolu.');
        }
        $isAlreadyRegistered = GroupClassParticipant::where('group_class_id', $groupClass->id)
            ->where('member_id', $member->user_id) // DİKKAT: Tabloda member_id user_id'ye bağlı
            ->exists();
        if ($isAlreadyRegistered) {
            return back()->with('error', 'Bu derse zaten kayıtlısınız.');
        }

        DB::transaction(function () use ($groupClass, $member) {
            GroupClassParticipant::create([
                'group_class_id' => $groupClass->id,
                'member_id' => $member->user_id,
            ]);
            $groupClass->increment('current_participants');
        });

        return back()->with('success', 'Derse başarıyla kaydoldunuz!');
    }
}
