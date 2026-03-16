<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Illuminate\View\View;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'tc_no' => ['nullable', 'string', 'digits:11', 'unique:members,tc_no,NULL,id,deleted_at,NULL'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        $smsCode = random_int(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'sms_code' => $smsCode,
            'role' => 'member',
            'is_verified' => false,
            'is_active' => true,
        ]);
        $nameParts = explode(' ', $user->name, 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';
        Member::create([
            'user_id' => $user->id,
            'tc_no' => $request->tc_no, // Formdan gelen gerçek TC no
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $request->phone,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            // Geçici varsayılan değerler
            'club_id' => 1,
            'consultant_id' => 1,
        ]);

        $this->sendVerificationSms($user->phone, $smsCode);

        event(new Registered($user));
        $request->session()->put('user_id_for_verification', $user->id);

        return redirect()->route('sms.verify.show');
    }

    // app/Http/Controllers/Auth/RegisteredUserController.php

    protected function sendVerificationSms(string $phoneNumber, string $code)
    {
        // 1. Ayarları config dosyasından al
        $usercode = config('services.netgsm.usercode');
        $password = config('services.netgsm.password');
        $header   = config('services.netgsm.header');
        $appkey   = config('services.netgsm.appkey'); // appkey'in .env ve services.php'de olduğundan emin olun
        $message  = "FitCity uygulamasina hos geldiniz! Dogrulama kodunuz: {$code}";

        // 2. Telefon numarasını dökümanın istediği formata (5XXXXXXXXX) getir
        $preparedPhoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        if (strlen($preparedPhoneNumber) > 10) {
            $preparedPhoneNumber = substr($preparedPhoneNumber, -10);
        }
        // Sonuç 5XXXXXXXXX formatında olmalı

        // 3. Gönderilecek XML verisini oluştur
        $xmlData = <<<XML
    <mainbody>
        <header>
            <usercode>{$usercode}</usercode>
            <password>{$password}</password>
            <msgheader>{$header}</msgheader>
            <appkey>{$appkey}</appkey>
        </header>
        <body>
            <msg><![CDATA[{$message}]]></msg>
            <no>{$preparedPhoneNumber}</no>
        </body>
    </mainbody>
    XML;

        try {
            // 4. Laravel HTTP Client ile POST isteği gönder
            $response = Http::withHeaders([
                'Content-Type' => 'text/xml; charset=utf-8'
            ])->withBody($xmlData, 'text/xml')
                ->post('https://api.netgsm.com.tr/sms/send/otp');

            Log::info('Netgsm XML OTP API Cevabı:', [
                'status_code' => $response->status(),
                'body' => $response->body(),
                'successful' => $response->successful(),
            ]);

        } catch (\Exception $e) {
            Log::error('Netgsm XML OTP SMS gönderme sırasında Exception oluştu: ' ->getMessage());
        }
    }

}
