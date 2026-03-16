<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Package;
use Illuminate\Support\Str;

class DiscountCodeController extends Controller
{
    /**
     * Kod alma sayfasını ve uygun paketleri gösterir.
     */
    public function index()
    {
        $user = Auth::user()->load('member');
        $gender = $user->member->gender ?? null;

        $packagesQuery = Package::where('status', 1);

        // Eğer kullanıcı erkekse, 'Kadın' paketini gösterme
        if ($gender === 'male') {
            $packagesQuery->where('name', '!=', '12 Ay Kadın Üyelik');
        }

        $packages = $packagesQuery->orderBy('usage_time', 'asc')->get();

        return view('codes.index', [
            'packages' => $packages,
            'user' => $user
        ]);
    }
    public function generateAndStore(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id'
        ]);

        $user = Auth::user();
        $member = $user->member;
        $package = Package::find($request->package_id);

        if (!$member || !$package) {
            return response()->json(['error' => 'Geçersiz kullanıcı veya paket.'], 404);
        }

        // Paket adını URL'e uygun, güvenli bir formata çevir
        $safePackageName = Str::slug($package->name, '_'); // Örn: "12_Ay_Bireysel_Uyelik"

        // Kodu oluştur
        $generatedCode = 'FITCITY_' . strtoupper($safePackageName) . '_' . $user->id;

        // Kodu üyenin 'special_code' alanına kaydet
        $member->update(['special_code' => $generatedCode]);

        // Oluşturulan kodu JSON formatında geri döndür
        return response()->json(['code' => $generatedCode]);
    }
}
