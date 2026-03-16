<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Measurement;
use App\Models\MeasurementAssignment;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;

class MeasurementSeeder extends Seeder
{
    public function run(): void
    {
        // Ölçüm tiplerini oluştur
        $inbody = Measurement::firstOrCreate(['name' => 'InBody Vücut Analizi']);
        Measurement::firstOrCreate(['name' => 'Yağ Ölçümü']);

        // Test üyesini ve eğitmeni bul
        $member = Member::where('tc_no', '33333333333')->first();
        $trainer = User::where('role', 'trainer')->first();

        // Eğer test üyesi ve eğitmen varsa, üyeye bir ölçüm hakkı ata
        if ($member && $trainer) {
            MeasurementAssignment::firstOrCreate(
                [
                    'member_id' => $member->id,
                    'measurement_id' => $inbody->id,
                ],
                [
                    'trainer_id' => $trainer->id,
                    'quota' => 1,
                    'status' => 'pending',
                    'assignment_date' => Carbon::now(),
                    'expiration_date' => Carbon::now()->addMonth(),
                ]
            );
        }
    }
}
