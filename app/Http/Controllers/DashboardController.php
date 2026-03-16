<?php

namespace App\Http\Controllers;

use App\Models\GroupClassParticipant;
use App\Models\MeasurementReservation;
use App\Models\PrivateLesson;
use App\Models\TrainingProgram;
use App\Models\Workout;
use App\Models\WorkoutCategory;
use App\Models\WorkoutType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    /**
     * Kullanıcının ana panelini gösterir.
     */
    public function index()
    {
        $user = Auth::user();
        $member = $user->member;

        // 1. Selamlama için kullanıcının adını al
        $userFirstName = $member->first_name ?? 'Kullanıcı';
        $workoutCategories = WorkoutCategory::all();
        // 2. Haftanın günleri için tarih şeridi oluştur
        $startDate = Carbon::today();
        $endDate = $startDate->copy()->addDays(6);
        $activityDates = [];

        if ($member) {
            // 1. Grup Dersi Katılımlarını Al
            $groupClasses = GroupClassParticipant::where('member_id', $user->id)
                ->whereHas('groupClass', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('class_date', [$startDate, $endDate]);
                })
                ->with('groupClass:id,class_date') // Sadece tarih bilgisini al
                ->get();

            foreach ($groupClasses as $participant) {
                $activityDates[] = $participant->groupClass->class_date->toDateString();
            }

            // 2. Özel Dersleri Al
            $privateLessons = PrivateLesson::where('member_id', $user->id)
                ->whereBetween('lesson_date', [$startDate, $endDate])
                ->pluck('lesson_date') // Sadece tarihleri al
                ->map(fn($date) => $date->toDateString()); // Tarihleri string'e çevir

            // 3. Ölçüm Rezervasyonlarını Al
            $measurements = MeasurementReservation::where('member_id', $member->id)
                ->whereBetween('reservation_date', [$startDate, $endDate])
                ->pluck('reservation_date')
                ->map(fn($date) => Carbon::parse($date)->toDateString()); // Datetime'ı date string'ine çevir

            // Tüm tarihleri birleştir ve tekrarları kaldır
            $activityDates = collect($activityDates)
                ->merge($privateLessons)
                ->merge($measurements)
                ->unique()
                ->toArray();
        }
        // --- YENİ BÖLÜMÜN SONU ---

        // Haftanın günleri için tarih şeridi oluştur
        $period = CarbonPeriod::create($startDate, $endDate);
        $weekDates = [];
        foreach ($period as $date) {
            $weekDates[] = [
                'day_letter' => $date->translatedFormat('D'),
                'day_number' => $date->day,
                'is_today' => $date->isToday(),
                // YENİ: Bu gün için aktivite olup olmadığını kontrol et
                'has_activity' => in_array($date->toDateString(), $activityDates),
            ];
        }
        // 3. Hedef ve Seviye Bilgileri (Örnek veriler)
        // Bu verileri daha sonra gerçek hesaplamalarla doldurabilirsiniz.
        $userLevel = 'Orta';
        $completedGoals = 0;
        $totalGoals = count($member->personal->hobbies ?? []);

        // 4. Diğer bölümler için geçici (placeholder) veriler
        // Bu verileri kendi veritabanı tablolarınızdan çekerek dinamik hale getireceksiniz.
        $categories = WorkoutType::all();

        $featuredWorkouts = Workout::where('status', 'published')
            ->orderBy('view_count', 'desc') // İzlenme sayısına göre büyükten küçüğe sırala
            ->take(5) // Sadece ilk 5 tanesini al
            ->get();
        $activeProgram = null;
        if ($member) {
            $activeProgram = TrainingProgram::where('member_id', $member->id)
                ->where('status', 'active')
                ->first();
        }
        $featuredTrainers = [
            [
                'title' => 'Ayın Eğitmeni',
                'name' => 'Mehmet Çamlı',
                'image' => asset('img/sayfa22.png') // Örnek resim yolu
            ],
            [
                'title' => 'Ayın Grup Ders Eğitmeni',
                'name' => 'Ayşe Yılmaz',
                'image' => asset('img/sayfa22.png') // Örnek resim yolu
            ],
            [
                'title' => 'Ayın Özel Ders Eğitmeni',
                'name' => 'Cihan Önal',
                'image' => asset('img/sayfa22.png') // Örnek resim yolu
            ]
        ];
        // 5. Tüm verileri view'e gönder
        return view('dashboard', [
            'userFirstName' => $member->first_name ?? 'Kullanıcı',
            'weekDates' => $weekDates,
            'userLevel' => 'Orta',
            'completedGoals' => 0,
            'totalGoals' => count($member->personal->hobbies ?? []),
            'categories' => $categories,
            'featuredWorkouts' => $featuredWorkouts,
            'activeProgram' => $activeProgram,
            'featuredTrainers' => $featuredTrainers,
            'workoutCategories' => $workoutCategories,
        ]);
    }
}
