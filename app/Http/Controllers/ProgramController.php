<?php

namespace App\Http\Controllers;

use App\Models\TrainingProgram;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    /**
     * Kullanıcıya atanan antrenman programını gösterir.
     */
    public function show(TrainingProgram $program)
    {
        // Güvenlik kontrolü
        if ($program->member->user_id !== Auth::id()) {
            abort(403, 'Bu sayfayı görüntüleme yetkiniz yok.');
        }

        // --- YENİ BÖLÜM: Egzersizlere Video Bilgisini Ekleme ---

        // 1. Programdaki tüm egzersizlerin workout_id'lerini bir diziye topla
        $workoutIds = collect($program->exercises)->pluck('workout_id')->unique();

        // 2. Bu ID'lere ait tüm Workout modellerini tek bir sorguyla veritabanından al
        $workouts = Workout::findMany($workoutIds)->keyBy('id');

        // 3. Programdaki egzersiz listesini, tam Workout bilgileriyle birleştir
        $hydratedExercises = collect($program->exercises)->map(function ($exercise) use ($workouts) {
            $workout = $workouts->get($exercise['workout_id']);
            if ($workout) {
                // Her egzersize video_url ve muscle_group_image_url bilgilerini ekle
                $exercise['video_url'] = $workout->video_url;
                $exercise['muscle_group_image_url'] = $workout->muscle_group_image_url;
            }
            return $exercise;
        });

        // 4. Egzersizleri günlere göre grupla
        $weeklySchedule = $hydratedExercises->groupBy('day');

        // --- YENİ BÖLÜMÜN SONU ---


        return view('program.show', [
            'program' => $program,
            'weeklySchedule' => $weeklySchedule
        ]);
    }
}
