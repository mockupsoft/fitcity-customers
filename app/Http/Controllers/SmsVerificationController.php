<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SmsVerificationController extends Controller
{
    public function show(Request $request)
    {
        $userId = $request->session()->get('user_id_for_verification');
        if (!$userId || !($user = User::find($userId))) {
            return redirect()->route('register');
        }
        return view('auth.verify-sms', ['user' => $user]);
    }


    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $userId = $request->session()->get('user_id_for_verification');

        if (!$userId) {
            return redirect()->route('register')->withErrors(['code' => 'Doğrulama oturumu sona erdi.']);
        }

        $user = User::find($userId);

        if (!$user || $user->sms_code !== $request->code) {
            return back()->withErrors(['code' => 'Girilen doğrulama kodu hatalı.']);
        }

        $user->forceFill([
            'is_verified' => true,
            'sms_code' => null,
        ])->save();

        $request->session()->forget('user_id_for_verification');
        Auth::login($user);

        return redirect()->route('infos.gender');
    }
}
