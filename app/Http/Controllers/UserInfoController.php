<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\MemberPersonalInfo;
use Carbon\Carbon;

class UserInfoController extends Controller
{
    /**
     * Cinsiyet seçimi sayfasını gösterir.
     */
    public function showGenderForm()
    {
        return view('infos.gender');
    }

    /**
     * Seçilen cinsiyet bilgisini veritabanına kaydeder.
     */
    public function storeGender(Request $request)
    {
        $request->validate([
            'gender' => ['required', 'string', 'in:female,male,other'],
        ]);

        try {
            // Giriş yapmış kullanıcının üye kaydını bul ve sadece gender alanını güncelle
            Auth::user()->member()->update([
                'gender' => $request->gender
            ]);
        } catch (\Exception $e) {
            Log::error("Cinsiyet güncellenirken hata oluştu: " . $e->getMessage());
            return back()->with('error', 'Bir hata oluştu, lütfen tekrar deneyin.');
        }

        // Bir sonraki adıma yönlendir
        return redirect()->route('infos.interests');
    }

    public function showInterestForm()
    {
        $savedInterests = Auth::user()->member?->personal?->hobbies ?? [];

        return view('infos.interests', [
            'savedInterests' => $savedInterests
        ]);
    }

    /**
     * YENİ: Seçilen ilgi alanlarını kaydeder.
     */
    public function storeInterests(Request $request)
    {
        // 1. Gelen veriyi doğrula. 'interests' bir dizi olmalı.
        $request->validate([
            'interests' => 'required|array|min:1',
            'interests.*' => 'string', // Dizinin her elemanının metin olduğunu doğrula
        ]);

        try {
            // 2. Giriş yapmış kullanıcının üye kaydını bul
            $member = Auth::user()->member;

            if (!$member) {
                // Eğer bir şekilde üye kaydı bulunamazsa, kullanıcıyı ilk adıma geri yönlendir
                return redirect()->route('infos.gender')->with('error', 'Lütfen önce cinsiyet seçiminizi yapınız.');
            }

            // 3. MemberPersonalInfo tablosunda kayıt oluştur veya güncelle
            MemberPersonalInfo::updateOrCreate(
                ['member_id' => $member->id],
                [
                    // Gelen ilgi alanları dizisini JSON formatında kaydet
                    'hobbies' => $request->interests,
                ]
            );

        } catch (\Exception $e) {
            Log::error("İlgi alanları kaydedilirken hata oluştu: " . $e->getMessage());
            return back()->with('error', 'Bir hata oluştu, lütfen tekrar deneyin.');
        }

        // 4. Bir sonraki adıma yönlendir (Örn: Hedefler sayfası)
        // return redirect()->route('infos.goals');
        return redirect()->route('infos.body-type');
    }
    public function showBodyTypeForm()
    {
        // Kullanıcının daha önce kaydettiği vücut tipini al
        $savedBodyType = Auth::user()->member?->personal?->body_size ?? '';

        return view('infos.body-type', [
            'savedBodyType' => $savedBodyType
        ]);
    }

    /**
     * YENİ: Seçilen vücut tipini kaydeder.
     */
    public function storeBodyType(Request $request)
    {
        // 1. Gelen veriyi doğrula
        $request->validate([
            'body_type' => ['required', 'string', 'in:Skinny,Regular,Extra,Overweight,Obese'],
        ]);

        try {
            // 2. Giriş yapmış kullanıcının üye kaydını bul
            $member = Auth::user()->member;

            if (!$member) {
                return redirect()->route('infos.gender')->with('error', 'Lütfen adımları sırayla tamamlayınız.');
            }

            // 3. MemberPersonalInfo tablosunda kayıt oluştur veya body_size'ı güncelle
            MemberPersonalInfo::updateOrCreate(
                ['member_id' => $member->id],
                ['body_size' => $request->body_type]
            );

        } catch (\Exception $e) {
            Log::error("Vücut tipi kaydedilirken hata oluştu: " . $e->getMessage());
            return back()->with('error', 'Bir hata oluştu, lütfen tekrar deneyin.');
        }

        return redirect()->route('infos.focus');
    }

    public function showFocusForm()
    {
        // Kullanıcının daha önce kaydettiği odak alanlarını al (special_condition alanından)
        $savedFocusAreas = Auth::user()->member?->personal?->special_condition ?? [];

        return view('infos.focus', [
            'savedFocusAreas' => $savedFocusAreas
        ]);
    }

    /**
     * YENİ: Seçilen odak alanlarını kaydeder ve süreci tamamlar.
     */
    public function storeFocus(Request $request)
    {
        $request->validate([
            'focus_areas' => 'required|array|min:1',
            'focus_areas.*' => 'string',
        ]);

        try {
            $member = Auth::user()->member;

            if (!$member) {
                return redirect()->route('infos.gender')->with('error', 'Lütfen adımları sırayla tamamlayınız.');
            }

            // MemberPersonalInfo tablosunda kayıt oluştur veya special_condition'ı güncelle
            MemberPersonalInfo::updateOrCreate(
                ['member_id' => $member->id],
                ['special_condition' => $request->focus_areas]
            );

        } catch (\Exception $e) {
            Log::error("Odak alanları kaydedilirken hata oluştu: " . $e->getMessage());
            return back()->with('error', 'Bir hata oluştu, lütfen tekrar deneyin.');
        }

        // BİLGİ TOPLAMA BİTTİ, ANA PANELE YÖNLENDİR
        return redirect()->route('infos.step-goal');
    }
    public function showStepGoalForm()
    {
        $savedStepGoal = Auth::user()->member?->personal?->step_goal ?? 10000;

        return view('infos.step-goal', [
            'savedStepGoal' => $savedStepGoal
        ]);
    }

    /**
     * YENİ: Adım hedefini kaydeder ve süreci tamamlar.
     */
    public function storeStepGoal(Request $request)
    {
        $request->validate([
            'step_goal' => 'required|integer|min:1000',
        ]);

        try {
            $member = Auth::user()->member;
            if (!$member) {
                return redirect()->route('infos.gender')->with('error', 'Lütfen adımları sırayla tamamlayınız.');
            }

            MemberPersonalInfo::updateOrCreate(
                ['member_id' => $member->id],
                ['step_goal' => $request->step_goal]
            );

        } catch (\Exception $e) {
            Log::error("Adım hedefi kaydedilirken hata oluştu: " . $e->getMessage());
            return back()->with('error', 'Bir hata oluştu, lütfen tekrar deneyin.');
        }

        // BİLGİ TOPLAMA BİTTİ, ANA PANELE YÖNLENDİR
        return redirect()->route('infos.habits');
    }
    public function showHabitForm()
    {
        // Kullanıcının daha önce kaydettiği alışkanlıkları al
        $savedHabits = Auth::user()->member?->personal?->other_personal_info ?? [];

        return view('infos.habits', [
            'savedHabits' => $savedHabits
        ]);
    }

    /**
     * YENİ: Seçilen kötü alışkanlıkları kaydeder ve süreci tamamlar.
     */
    public function storeHabits(Request $request)
    {
        $request->validate([
            'bad_habits' => 'required|array|min:1',
            'bad_habits.*' => 'string',
        ]);

        try {
            $member = Auth::user()->member;
            if (!$member) {
                return redirect()->route('infos.gender')->with('error', 'Lütfen adımları sırayla tamamlayınız.');
            }

            // MemberPersonalInfo tablosunda kayıt oluştur veya other_personal_info'yu güncelle
            MemberPersonalInfo::updateOrCreate(
                ['member_id' => $member->id],
                ['other_personal_info' => $request->bad_habits]
            );

        } catch (\Exception $e) {
            Log::error("Kötü alışkanlıklar kaydedilirken hata oluştu: " . $e->getMessage());
            return back()->with('error', 'Bir hata oluştu, lütfen tekrar deneyin.');
        }

        // BİLGİ TOPLAMA BİTTİ, ANA PANELE YÖNLENDİR
        return redirect()->route('infos.habit-info');
    }
    public function showHabitInfoPage()
    {
        return view('infos.habit-info');
    }
    public function showTargetAreaForm()
    {
        $savedTargetAreas = Auth::user()->member?->personal?->target_areas ?? [];

        return view('infos.target-areas', [
            'savedTargetAreas' => $savedTargetAreas
        ]);
    }

    /**
     * YENİ: Seçilen hedef bölgeleri kaydeder ve süreci tamamlar.
     */
    public function storeTargetAreas(Request $request)
    {
        $request->validate([
            'target_areas' => 'required|array|min:1',
            'target_areas.*' => 'string',
        ]);

        try {
            $member = Auth::user()->member;
            if (!$member) {
                return redirect()->route('infos.gender')->with('error', 'Lütfen adımları sırayla tamamlayınız.');
            }

            MemberPersonalInfo::updateOrCreate(
                ['member_id' => $member->id],
                ['target_areas' => $request->target_areas]
            );

        } catch (\Exception $e) {
            Log::error("Hedef bölgeler kaydedilirken hata oluştu: " . $e->getMessage());
            return back()->with('error', 'Bir hata oluştu, lütfen tekrar deneyin.');
        }

        // BİLGİ TOPLAMA BİTTİ, ANA PANELE YÖNLENDİR
        return redirect()->route('infos.body-metrics');
    }
    public function showBodyMetricsForm()
    {
        $personalInfo = Auth::user()->member?->personal;
        return view('infos.body-metrics', [
            'height' => $personalInfo?->height,
            'weight' => $personalInfo?->weight,
        ]);
    }

    /**
     * YENİ: Girilen boy ve kilo bilgilerini kaydeder.
     */
    public function storeBodyMetrics(Request $request)
    {
        $validated = $request->validate([
            'height' => 'required|integer|min:100|max:250',
            'weight' => 'required|numeric|min:30|max:250',
        ]);

        $member = Auth::user()->member;

        // MemberPersonalInfo kaydı varsa güncelle, yoksa oluştur.
        $member->personal()->updateOrCreate(
            ['member_id' => $member->id],
            [
                'height' => $validated['height'],
                'weight' => $validated['weight'],
            ]
        );

        // Bir sonraki adıma, yani özet sayfasına yönlendir
        return redirect()->route('infos.fitness-summary');
    }
    public function showFitnessSummary()
    {
        $user = Auth::user();
        $member = $user->member;
        $personalInfo = $member?->personal;

        // --- Veri Çekme ve İşleme ---

        // 1. BMI Hesaplaması (Boy ve kilo bilgisi varsa)
        $heightCm = $personalInfo?->height;
        $weightKg = $personalInfo?->weight;
        $bmiValue = 0;
        $bmiCategory = 'Bilinmiyor';

        if ($heightCm > 0 && $weightKg > 0) {
            $heightM = $heightCm / 100;
            $bmiValue = round($weightKg / ($heightM * $heightM), 1);

            if ($bmiValue < 18.5) {
                $bmiCategory = 'Zayıf';
            } elseif ($bmiValue < 25) {
                $bmiCategory = 'Normal';
            } elseif ($bmiValue < 30) {
                $bmiCategory = 'Kilolu';
            } else {
                $bmiCategory = 'Obez';
            }
        }

        // 2. Yaşam Tarzı ve Egzersiz Tercihini Belirleme
        // Kullanıcının seçtiği "odak alanlarına" göre bir çıkarım yapalım.
        $focusAreas = $personalInfo?->special_condition ?? [];
        $lifestyle = 'Orta Aktif'; // Varsayılan
        if (in_array('Enerji Artışı', $focusAreas) || in_array('Kas Kazancı', $focusAreas)) {
            $lifestyle = 'Aktif';
        } elseif (in_array('Hareketlilik', $focusAreas)) {
            $lifestyle = 'Hareketsiz';
        }

        // Kullanıcının ilk ilgi alanını egzersiz tercihi olarak alalım.
        $exercisePreference = $personalInfo?->hobbies[0] ?? 'Belirtilmedi';

        return view('infos.fitness-summary', [
            'bmiValue' => $bmiValue > 0 ? $bmiValue : '--',
            'bmiCategory' => $bmiCategory,
            'lifestyle' => $lifestyle,
            'exercisePreference' => $exercisePreference,
        ]);
    }
    public function showPlanSummary()
    {
        $user = Auth::user();
        $personalInfo = $user->member?->personal;

        // --- GEÇİCİ HESAPLAMA (BOY VE KİLO ALINDIKTAN SONRA GÜNCELLENECEK) ---
        $currentWeight = $personalInfo?->weight ?? 85; // Varsayılan 85 kg
        $heightCm = $personalInfo?->height ?? 180; // Varsayılan 180 cm

        // Hedef Kilo Hesaplaması (Sağlıklı BMI = 22 varsayalım)
        $targetWeight = 0;
        if($heightCm > 0) {
            $heightM = $heightCm / 100;
            $targetWeight = round(22 * ($heightM * $heightM));
        }

        // Hedef Tarih Hesaplaması (Haftada 0.5 kg kayıp varsayalım)
        $weightToLose = $currentWeight - $targetWeight;
        $weeksNeeded = ($weightToLose > 0) ? $weightToLose / 0.5 : 0;
        $targetDate = Carbon::now()->addWeeks($weeksNeeded);
        // --- GEÇİCİ HESAPLAMANIN SONU ---

        return view('infos.plan-summary', [
            'targetWeight' => $targetWeight,
            'targetDate' => $targetDate
        ]);
    }
    public function showSubscriptionPage()
    {
        $user = Auth::user()->load('member');
        $gender = $user->member->gender ?? null;

        // 1. Ana (öne çıkan) paketleri al
        $mainPackages = Package::whereIn('name', [
            '1 Ay Bireysel Üyelik',
            '12 Ay Bireysel Üyelik'
        ])->where('status', 1)
            ->orderBy('usage_time', 'asc')
            ->get();

        // 2. Diğer paketleri al
        $otherPackagesQuery = Package::whereNotIn('name', [
            '1 Ay Bireysel Üyelik',
            '12 Ay Bireysel Üyelik'
        ])->where('status', 1);

        // 3. Cinsiyet kontrolü: Eğer kullanıcı erkekse, 'Kadın' paketini gösterme
        if ($gender === 'male') {
            $otherPackagesQuery->where('name', '!=', '12 Ay Kadın Üyelik');
        }

        $otherPackages = $otherPackagesQuery->orderBy('usage_time', 'asc')->get();

        return view('infos.subscription', [
            'mainPackages' => $mainPackages,
            'otherPackages' => $otherPackages,
        ]);
    }

}
