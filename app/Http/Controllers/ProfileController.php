<?php

namespace App\Http\Controllers;

use App\Models\MeasurementReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Kullanıcının profil sayfasını gösterir.
     */
    public function show()
    {
        $user = Auth::user();

        $user->load('member.personal');
        $name = $user->name;
        $profilePhotoUrl = $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('img/sayfa27.png');
        $weight = $user->member?->personal?->weight ?? '--';
        $height = $user->member?->personal?->height ?? '--';
        $birthDate = $user->member?->birth_date;
        $age = $birthDate ? Carbon::parse($birthDate)->age : '--';

        return view('profile.show', [
            'name' => $name,
            'profilePhotoUrl' => $profilePhotoUrl,
            'weight' => $weight,
            'height' => $height,
            'age' => $age,
        ]);
    }
    public function edit()
    {
        $user = Auth::user()->load('member.personal');

        return view('profile.edit', compact('user'));
    }
    public function measurements()
    {
        $member = Auth::user()->member;

        // Üyeye ait, durumu 'approved' veya 'completed' olan tüm ölçüm rezervasyonlarını al
        $measurements = MeasurementReservation::where('member_id', $member->id)
            ->whereIn('status', ['approved', 'completed']) // Sadece onaylanmış veya tamamlanmış olanları göster
            ->orderBy('reservation_date', 'desc') // En yeniden eskiye doğru sırala
            ->paginate(10); // Sayfalama yap

        return view('profile.measurements', compact('measurements'));
    }
    /**
     * Kişisel bilgileri günceller.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $member = $user->member;
        $personalInfo = $member->personal;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'birth_date' => 'nullable|date|before:today',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
        ]);

        // User tablosunu güncelle
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Member tablosunu güncelle (ad ve e-posta tekrarı)
        if ($member) {
            $nameParts = explode(' ', $validated['name'], 2);
            $member->update([
                'first_name' => $nameParts[0],
                'last_name' => $nameParts[1] ?? '',
                'email' => $validated['email'],
                'birth_date' => $validated['birth_date'],
            ]);
        }

        // MemberPersonalInfo tablosunu güncelle
        if ($personalInfo) {
            $personalInfo->update([
                'weight' => $validated['weight'],
                'height' => $validated['height'],
                // doğum tarihi burada da olabilir, şemanıza bağlı
                // 'birth_date' => $validated['birth_date'],
            ]);
        } elseif ($member) { // Eğer personalInfo yoksa, oluştur
            $member->personal()->create([
                'weight' => $validated['weight'],
                'height' => $validated['height'],
            ]);
        }

        return redirect()->route('profile.edit')->with('success', 'Bilgileriniz başarıyla güncellendi.');
    }
    // app/Http/Controllers/ProfileController.php

    public function destroyAccount(Request $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($user) {
            // Kullanıcıya bağlı bir 'member' kaydı olup olmadığını kontrol et
            if ($member = $user->member) {
                // Önce Member'a bağlı kayıtları sil
                $member->personal()->delete();
                $member->measurementAssignments()->delete();
                $member->measurementReservations()->delete();
                $member->privateLessonRequests()->delete();
                $member->trainingPrograms()->delete();

                // Sonra Member kaydının kendisini sil
                $member->delete();
            }

            // User'a doğrudan bağlı kayıtları sil
            $user->subscriptions()->delete();
            $user->groupClassParticipations()->delete();
            $user->privateLessonPackages()->delete();

            // En son User kaydını sil
            $user->delete();
        });

        // Kullanıcının oturumunu sonlandır
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Hesabınız ve ilişkili tüm verileriniz başarıyla silinmiştir.');
    }
}
