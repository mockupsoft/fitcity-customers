<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HealthScreening;
use App\Services\FitnessCalculatorService; // Bu servisi daha önce oluşturmuştuk
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HealthScreeningController extends Controller
{
    protected $calculator;

    public function __construct(FitnessCalculatorService $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Adım 1: PAR-Q Formunu Göster
     * Route: health-screening.start
     */
    public function start()
    {
        // Eğer kullanıcı zaten testi geçmişse tekrar gösterme, antrenmanlara yönlendir
        $screening = HealthScreening::where('user_id', Auth::id())->latest()->first();
        if ($screening && $screening->expires_at > now() && $screening->parq_passed) {
            return redirect()->route('workouts.index');
        }

        return view('customer.health.parq');
    }

    /**
     * Adım 1 Sonucu: PAR-Q Cevaplarını Kaydet
     */
    public function storeParq(Request $request)
    {
        $answers = $request->input('answers');

        // Herhangi bir soruya "Evet" (yes) denildi mi?
        $hasYes = in_array('yes', $answers);

        if ($hasYes) {
            // Riskli durum: Kaydet ve uyarı sayfasına gönder
            HealthScreening::create([
                'user_id' => Auth::id(),
                'parq_passed' => false,
                'parq_answers' => $answers,
                'acsm_answers' => [], // Henüz yok
                'expires_at' => Carbon::now()->addMonths(3) // 3 ay sonra tekrar test
            ]);
            return redirect()->route('health-screening.failed');
        }

        // Başarılı: Cevapları geçici olarak Session'da tut ve ACSM'e yönlendir
        Session::put('parq_answers', $answers);
        return redirect()->route('health-screening.acsm');
    }

    /**
     * Adım 2: Başarısız/Uyarı Sayfası
     * Route: health-screening.failed
     */
    public function failed()
    {
        return view('customer.health.failed');
    }

    /**
     * Adım 3: ACSM Risk Analizi Formunu Göster
     * Route: health-screening.acsm
     */
    public function acsmForm()
    {
        // Session'da PAR-Q cevabı yoksa (doğrudan link ile gelindiyse) başa at
        if (!Session::has('parq_answers')) {
            return redirect()->route('health-screening.start');
        }
        return view('customer.health.acsm');
    }

    /**
     * Adım 3 Sonucu: ACSM Cevaplarını Kaydet ve Bitir
     */
    public function storeAcsm(Request $request)
    {
        $acsmAnswers = $request->except('_token');
        $member = Auth::user()->member;

        // Risk sınıfını hesapla (A1, A2, B vs.)
        $riskResult = $this->calculator->calculateAcsmRiskClass($member->age ?? 30, $member->gender ?? 'male', $acsmAnswers);

        // Tüm süreci veritabanına kaydet
        HealthScreening::create([
            'user_id' => Auth::id(),
            'parq_passed' => true,
            'parq_answers' => Session::get('parq_answers', []),
            'acsm_risk_class' => $riskResult['class'],
            'acsm_answers' => $acsmAnswers,
            'expires_at' => Carbon::now()->addMonths(3)
        ]);

        // Session'ı temizle
        Session::forget('parq_answers');

        // Antrenmanlara yönlendir
        return redirect()->route('workouts.all')->with('success', 'Sağlık taraması tamamlandı. İyi antrenmanlar!');
    }
}
