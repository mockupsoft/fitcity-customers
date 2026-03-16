<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HealthScreening;
use Symfony\Component\HttpFoundation\Response;

class CheckHealthScreening
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            // Kullanıcı giriş yapmamışsa login'e yönlendir (Güvenlik önlemi)
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

        return $next($request);
    }
}
