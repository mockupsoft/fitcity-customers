<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Models\HealthScreening;
use Illuminate\Http\RedirectResponse;

trait HealthChecks
{
    /**
     * Kullanıcının sağlık taraması durumunu kontrol eder.
     * Sorun varsa yönlendirme (RedirectResponse) döner, yoksa null döner.
     */
    public function checkHealthStatus(): ?RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $screening = HealthScreening::where('user_id', $user->id)
            ->latest()
            ->first();

        // 1. Test hiç yapılmamışsa veya süresi dolmuşsa
        if (!$screening || $screening->expires_at < now()) {
            return redirect()->route('health-screening.start');
        }

        // 2. PAR-Q testinden geçememişse (Sağlık engeli varsa)
        if (!$screening->parq_passed) {
            return redirect()->route('health-screening.failed');
        }

        // Her şey yolunda
        return null;
    }
}
