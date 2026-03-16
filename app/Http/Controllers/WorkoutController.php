<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use App\Models\WorkoutCategory;
use App\Models\WorkoutType;
use App\Traits\HealthChecks; // Trait'i dahil et
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    use HealthChecks; // Trait'i sınıf içinde kullan

    public function index(WorkoutCategory $category)
    {
        // --- SAĞLIK KONTROLÜ ---
        // Kullanıcı bir kategoriye tıkladığında sağlık kontrolü yap
        if ($redirect = $this->checkHealthStatus()) {
            return $redirect;
        }
        // -----------------------

        $workouts = $category->workouts()->where('status', 'published')->with('trainer')->latest()->get();

        return view('customer.workouts.index', [ // View yolunuza dikkat edin
            'category' => $category,
            'workouts' => $workouts,
        ]);
    }
    public function allWorkouts(Request $request)
    {
        if ($redirect = $this->checkHealthStatus()) {
            return $redirect;
        }
        $categories = WorkoutCategory::all();
        $types = WorkoutType::all(); // View'da göstermek için tipleri de alalım

        $activeCategorySlug = $request->query('category');
        $activeTypeSlug = $request->query('type'); // Yeni type filtresini al

        $workoutsQuery = Workout::where('status', 'published')->with('trainer');

        // Kategoriye göre filtrele
        if ($activeCategorySlug) {
            $workoutsQuery->whereHas('category', function ($query) use ($activeCategorySlug) {
                $query->where('slug', $activeCategorySlug);
            });
        }

        // YENİ: Antrenman tipine göre filtrele
        if ($activeTypeSlug) {
            $workoutsQuery->whereHas('type', function ($query) use ($activeTypeSlug) {
                $query->where('slug', $activeTypeSlug);
            });
        }

        $workouts = $workoutsQuery->latest()->paginate(10);

        return view('workouts.all', [
            'workouts' => $workouts,
            'categories' => $categories,
            'types' => $types,
            'activeCategorySlug' => $activeCategorySlug,
            'activeTypeSlug' => $activeTypeSlug,
        ]);
    }
    public function incrementViewCount(Workout $workout)
    {
        $workout->increment('view_count');

        return response()->json(['success' => true]);
    }
}
