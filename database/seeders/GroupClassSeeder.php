<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GroupClass;
use App\Models\User;
use Carbon\Carbon;

class GroupClassSeeder extends Seeder
{
    public function run(): void
    {
        // Örnek bir eğitmen kullanıcısı bul veya oluştur
        $trainer = User::firstOrCreate(
            ['email' => 'trainer@fitcity.com'],
            ['name' => 'Cihan Önal', 'password' => bcrypt('password'), 'role' => 'trainer']
        );

        GroupClass::create([
            'name' => 'Koşu Bandı Grup Dersi',
            'trainer_id' => $trainer->id,
            'type' => 'cardio',
            'level' => 'all_levels',
            'capacity' => 20,
            'duration_minutes' => 45,
            'class_date' => Carbon::parse('next tuesday')->toDateString(),
            'start_time' => '10:00:00',
            'end_time' => '10:45:00',
        ]);

        GroupClass::create([
            'name' => 'Fonksiyonel Antrenman',
            'trainer_id' => $trainer->id,
            'type' => 'strength',
            'level' => 'intermediate',
            'capacity' => 15,
            'duration_minutes' => 60,
            'class_date' => Carbon::parse('next wednesday')->toDateString(),
            'start_time' => '19:00:00',
            'end_time' => '20:00:00',
        ]);
    }
}
