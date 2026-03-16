<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    /**
     * Tüm eğitmenleri listeler.
     */
    public function index()
    {
        // Rolü 'trainer' olan tüm kullanıcıları, eğitmen detaylarıyla birlikte getir.
        $trainers = User::where('role', 'trainer')->with('trainerDetails')->get();

        return view('trainers.index', [
            'trainers' => $trainers
        ]);
    }
    public function show(User $trainer)
    {
        // Route-Model Binding sayesinde $trainer objesi otomatik olarak gelir.
        // Gerekli ilişkileri önceden yüklüyoruz (Eager Loading)
        $trainer->load('trainerDetails', 'groupClasses');

        // Örnek Özel Ders Paketleri (Bu bölümü ileride veritabanından dinamik hale getirebilirsiniz)
        $privateLessonPackages = [
            ['name' => 'Personal Coaching 10 Ders', 'price' => '9000.00'],
            ['name' => 'Personal Coaching 5 Ders', 'price' => '5000.00'],
        ];

        return view('trainers.show', [
            'trainer' => $trainer,
            'privateLessonPackages' => $privateLessonPackages
        ]);
    }
}
