<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PendingPayment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    // app/Http/Controllers/PaymentController.php

    // app/Http/Controllers/PaymentController.php

    public function initiate(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'document' => 'sometimes|required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $package = Package::findOrFail($request->package_id);
        $user = Auth::user();

        $merchant_id    = config('services.paytr.merchant_id');
        $merchant_key   = config('services.paytr.merchant_key');
        $merchant_salt  = config('services.paytr.merchant_salt');

        $email = $user->email;
        $payment_amount = $package->price * 100;
        $merchant_oid = 'FITCITY' . Str::random(12);
        $user_name = $user->name;
        $user_address = "Adres bilgisi alınmadı";
        $user_phone = $user->phone;
        $user_ip = $request->ip();
        $documentPath = null;
        if ($request->hasFile('document')) {
            // Belgeyi storage/app/public/documents klasörüne kaydet
            $documentPath = $request->file('document')->store('documents', 'public');
        }
        $user_basket = base64_encode(json_encode([
            [$package->name, $package->price, 1],
        ]));

        $merchant_ok_url = route('dashboard');
        $merchant_fail_url = route('infos.subscription');

        // ---- HASH HESAPLAMASI İÇİN YENİ PARAMETRELER ----
        $no_installment = 1; // Taksit olmasın
        $max_installment = 0; // Maksimum taksit (taksit olmayacağı için 0)
        $currency = 'TL';
        $test_mode = 1; // Test modu aktif: 1, Canlı mod: 0

        // ---- GÜNCELLENMİŞ HASH HESAPLAMASI ----
        // PayTR dökümanlarına göre doğru sıra budur:
        $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket . $no_installment . $max_installment . $currency . $test_mode;
        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));

        // ---- TEKRARLAYAN ÖDEME PARAMETRELERİ ----
        // Bunlar hash'e dahil DEĞİLDİR, sadece isteğe eklenir.
        $rp_landing_page = 0;
        $rp_token_ay = $package->usage_time == 365 ? 12 : 1;
        $rp_gecikme_gun = 3;

        $post_vals = [
            'merchant_id' => $merchant_id,
            'user_ip' => $user_ip,
            'merchant_oid' => $merchant_oid,
            'email' => $email,
            'payment_amount' => $payment_amount,
            'paytr_token' => $paytr_token,
            'user_basket' => $user_basket,
            'debug_on' => $test_mode,
            'test_mode' => $test_mode,
            'no_installment' => $no_installment,
            'max_installment' => $max_installment,
            'currency' => $currency,
            'user_name' => $user_name,
            'user_address' => $user_address,
            'user_phone' => $user_phone,
            'merchant_ok_url' => $merchant_ok_url,
            'merchant_fail_url' => $merchant_fail_url,
            'rp_landing_page' => $rp_landing_page,
            'rp_token_ay' => $rp_token_ay,
            'rp_gecikme_gun' => $rp_gecikme_gun,
            'lang' => 'tr',
        ];
        PendingPayment::create([
            'merchant_oid' => $merchant_oid,
            'user_id'      => $user->id,
            'package_id'   => $package->id,
            'document_path'=> $documentPath, // YENİ EKLENDİ
        ]);
        $response = Http::asForm()->post('https://www.paytr.com/odeme/api/get-token', $post_vals);
        $result = $response->json();

        if ($result && $result['status'] == 'success') {
            $token = $result['token'];
            return redirect()->away("https://www.paytr.com/odeme/guvenli/{$token}");
        } else {
            $reason = $result['reason'] ?? 'Bilinmeyen bir hata oluştu.';
            Log::error('PayTR Token Alınamadı: ' . $reason);
            return redirect()->route('infos.subscription')->with('error', 'Ödeme başlatılamadı. Hata: ' . $reason);
        }
    }

    // app/Http/Controllers/PaymentController.php

    public function callback(Request $request)
    {
        Log::info('PAYTR CALLBACK BAŞLADI', $request->all()); // Gelen tüm veriyi logla

        $merchant_key   = config('services.paytr.merchant_key');
        $merchant_salt  = config('services.paytr.merchant_salt');

        $hash = base64_encode(hash_hmac('sha256', $request->merchant_oid . $merchant_salt . $request->status . $request->total_amount, $merchant_key, true));

        if ($hash != $request->hash) {
            Log::error('PAYTR GÜVENLİK UYARISI: HASH UYUŞMAZLIĞI');
            return response('PAYTR HASH UYUŞMAZLIĞI', 403);
        }
        Log::info('Hash doğrulaması başarılı.');

        // Geçici ödeme kaydını bul
        $pendingPayment = PendingPayment::where('merchant_oid', $request->merchant_oid)->first();
        if (!$pendingPayment) {
            Log::error('PAYTR UYARISI: Geçici ödeme bulunamadı.', ['merchant_oid' => $request->merchant_oid]);
            return response('OK');
        }
        Log::info('Geçici ödeme kaydı bulundu.', ['pending_id' => $pendingPayment->id]);

        if ($request->status == 'success') {
            Log::info('Ödeme durumu BAŞARILI. Abonelik oluşturma işlemi başlıyor.');

            $paytr_token = $request->rp_token;
            if (empty($paytr_token)) {
                Log::error('PAYTR UYARISI: rp_token (tekrarlayan ödeme token) boş geldi!');
                return response('OK');
            }

            $user = User::find($pendingPayment->user_id);
            $package = Package::find($pendingPayment->package_id);

            if (!$user) {
                Log::error('Abonelik oluşturulamadı: Kullanıcı bulunamadı.', ['user_id' => $pendingPayment->user_id]);
                return response('OK');
            }
            if (!$package) {
                Log::error('Abonelik oluşturulamadı: Paket bulunamadı.', ['package_id' => $pendingPayment->package_id]);
                return response('OK');
            }
            Log::info('Kullanıcı ve paket bulundu.', ['user_id' => $user->id, 'package_id' => $package->id]);

            try {
                // Aboneliği oluştur veya güncelle
                Subscription::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'package_id' => $package->id,
                        'paytr_token' => $paytr_token,
                        'status' => 'active',
                        'starts_at' => now(),
                        'next_billing_date' => \Carbon\Carbon::now()->addMonths($package->usage_time >= 365 ? 12 : 1),
                    ]
                );
                Log::info('Abonelik başarıyla oluşturuldu/güncellendi.', ['user_id' => $user->id]);

                // Geçici ödeme kaydını "tamamlandı" olarak işaretle
                $pendingPayment->update(['status' => 'completed']);
                Log::info('Geçici ödeme kaydı "completed" olarak güncellendi.');

            } catch (\Exception $e) {
                Log::error('Abonelik veritabanına kaydedilirken KRİTİK HATA oluştu: ' . $e->getMessage());
            }

        } else {
            // Ödeme Başarısız
            $pendingPayment->update(['status' => 'failed']);
            Log::warning('PayTR Ödemesi Başarısız', $request->all());
        }

        return response('OK');
    }
}
