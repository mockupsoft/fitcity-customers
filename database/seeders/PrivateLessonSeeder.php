<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\User;
use App\Models\PrivateLessonPackage;
use Carbon\Carbon;

class PrivateLessonSeeder extends Seeder
{
    public function run(): void
    {
        $member = Member::where('tc_no', '33333333333')->first();
        $trainer = User::where('role', 'trainer')->first();

        if ($member && $trainer) {
            PrivateLessonPackage::firstOrCreate(
                [
                    'member_id' => $member->user_id,
                    'trainer_id' => $trainer->id,
                ],
                [
                    'name' => '10 Derslik Özel Fitness Paketi', // EKLENDİ
                    'total_sessions' => 10,
                    'remaining_sessions' => 10,
                    'price_per_session' => 900,
                    'total_price' => 9000,
                    'start_date' => now(),
                    'end_date' => now()->addMonths(3),
                    'status' => 'active',
                ]
            );
        }
    }
}
