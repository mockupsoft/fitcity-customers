<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class TrainerSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Eğitmen
        $user1 = User::firstOrCreate(
            ['email' => 'mehmet.camli@fitcity.com'],
            ['name' => 'Mehmet Çamlı', 'password' => bcrypt('password'), 'role' => 'trainer', 'phone' => '05551112233']
        );
        $nameParts1 = explode(' ', $user1->name, 2);

        $user1->trainerDetails()->updateOrCreate(
            ['user_id' => $user1->id],
            [
                'first_name' => $nameParts1[0],
                'last_name' => $nameParts1[1] ?? '',
                'tc_no' => '11111111111', // Benzersiz geçici TC No eklendi
                'specialization' => 'Fitness & Vücut Geliştirme',
                'experience_years' => 5,
                'notes' => 'Yoga ve Pilates üzerine yoğunlaşmış, 8 yıllık deneyime sahip bir eğitmendir. Zihin ve beden bütünlüğüne inanır.',
                'certification' => json_encode(['Yoga Alliance 200 RYT', 'Balanced Body Pilates Instructor']),

            ]
        );

        // 2. Eğitmen
        $user2 = User::firstOrCreate(
            ['email' => 'ayse.yilmaz@fitcity.com'],
            ['name' => 'Ayşe Yılmaz', 'password' => bcrypt('password'), 'role' => 'trainer', 'phone' => '05551112244']
        );
        $nameParts2 = explode(' ', $user2->name, 2);

        $user2->trainerDetails()->updateOrCreate(
            ['user_id' => $user2->id],
            [
                'first_name' => $nameParts2[0],
                'last_name' => $nameParts2[1] ?? '',
                'tc_no' => '22222222222', // Benzersiz geçici TC No eklendi
                'specialization' => 'Pilates & Yoga',
                'experience_years' => 8,
                'notes' => '1500\'lerden beri endüstri standardı sahte metinler olarak kullanılmıştır. Beşyüz yıl boyunca varlığını sürdürmüştür.',
                'certification' => json_encode(['TVGFBF- 1. Kademe', 'Personal Trainer Certificate']),
            ]
        );
    }
}
