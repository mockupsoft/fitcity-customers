<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Models\Package;

class SubscriptionController extends Controller
{
    /**
     * Kullanıcının üyelik bilgilerini ve mevcut paketleri gösterir.
     */
    public function index()
    {
        $user = Auth::user();

        // Kullanıcının aktif aboneliğini al (ilişkili paket bilgisiyle birlikte)
        $activeSubscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->with('package')
            ->first();

        // Kampanyalı veya satın alınabilir diğer paketleri al
        // Örnek olarak 'CLASSIC' ve 'PLATINUM' isimli paketleri çekiyoruz
        $campaignPackages = Package::whereIn('name', ['CLASSIC', 'PLATINUM'])
            ->where('status', 1)
            ->get();

        return view('subscriptions.index', [
            'subscription' => $activeSubscription,
            'packages' => $campaignPackages,
        ]);
    }
}
