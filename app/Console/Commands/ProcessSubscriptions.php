<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProcessSubscriptions extends Command
{
    protected $signature = 'subscriptions:process';
    protected $description = 'Vadesi gelen abonelikler için PayTR\'dan otomatik ödeme alır.';

    public function handle()
    {
        $this->info('Vadesi gelen abonelikler işleniyor...');

        $subscriptions = Subscription::with('user', 'package') // İlişkili verileri de al
        ->where('status', 'active')
            ->whereDate('next_billing_date', '<=', today())
            ->get();

        if ($subscriptions->isEmpty()) {
            $this->info('İşlenecek abonelik bulunamadı.');
            return;
        }

        foreach ($subscriptions as $sub) {
            $this->line("İşleniyor: User ID {$sub->user_id} - Subscription ID {$sub->id}");

            $merchant_id    = config('services.paytr.merchant_id');
            $merchant_key   = config('services.paytr.merchant_key');
            $merchant_salt  = config('services.paytr.merchant_salt');

            $payment_amount = $sub->package->price * 100;
            $rp_token = $sub->paytr_token;

            $hash_str = $merchant_id . $rp_token . $payment_amount;
            $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));

            $response = Http::asForm()->post('https://www.paytr.com/odeme/api/tekrarlanan', [
                'merchant_id' => $merchant_id,
                'rp_token' => $rp_token,
                'tutar' => $payment_amount,
                'paytr_token' => $paytr_token,
            ]);

            $result = $response->json();

            if (isset($result['status']) && $result['status'] == 'success') {
                // Ödeme Başarılı
                $next_billing_date = Carbon::parse($sub->next_billing_date)
                    ->addMonths($sub->package->usage_time == 365 ? 12 : 1);

                $sub->update(['next_billing_date' => $next_billing_date]);

                Log::info('Tekrarlayan ödeme başarılı.', ['subscription_id' => $sub->id]);
                $this->info(" -> Başarılı: Subscription ID {$sub->id}");
            } else {
                // Ödeme Başarısız
                $sub->update(['status' => 'failed']);

                $errorMessage = $result['err_msg'] ?? 'Bilinmeyen Hata';
                Log::error('Tekrarlayan ödeme başarısız.', ['subscription_id' => $sub->id, 'reason' => $errorMessage]);
                $this->error(" -> Başarısız: Subscription ID {$sub->id} - Hata: {$errorMessage}");

                // TODO: Kullanıcıya e-posta veya bildirim gönder.
            }
        }
        $this->info('Tüm abonelikler işlendi.');
    }
}
