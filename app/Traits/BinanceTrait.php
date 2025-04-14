<?php
namespace App\Traits;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;

trait BinanceTrait
{
    protected function initiateBinance(Payment $payment)
    {
        try {
            $response = Http::withHeaders([
                'binancepay-key' => config('services.binance.key'),
                'binancepay-timestamp' => time() * 1000,
                'binancepay-nonce' => uniqid(),
                'binancepay-signature' => $this->generateBinanceSignature($payment)
            ])->post('https://api.binance.com/v1/order', [
                'merchant_id' => config('services.binance.merchant_id'),
                'merchant_trade_no' => $payment->reference,
                'currency' => $payment->currency,
                'amount' => $payment->amount,
                'return_url' => route('payment.binance.success'),
                'cancel_url' => route('payment.binance.cancel'),
                'notify_url' => route('payment.binance.webhook')
            ]);

            if ($response->successful()) {
                $payment->update([
                    'provider_reference' => $response->json('data.prepay_id'),
                    'status' => 'pending'
                ]);

                return [
                    'status' => true,
                    'checkout_url' => $response->json('data.checkout_url')
                ];
            }

            return false;
        } catch (\Exception $e) {
            \Log::error('Binance Payment Error: ' . $e->getMessage());
            return false;
        }
    }

    protected function verifyBinancePayment(Payment $payment)
    {
        try {
            $response = Http::withHeaders([
                'binancepay-key' => config('services.binance.key'),
                'binancepay-timestamp' => time() * 1000,
                'binancepay-nonce' => uniqid(),
                'binancepay-signature' => $this->generateBinanceSignature($payment)
            ])->get('https://api.binance.com/v1/order/' . $payment->provider_reference);

            if ($response->successful() && $response->json('data.status') === 'PAID') {
                $payment->update(['status' => 'success']);
                return true;
            }

            $payment->update(['status' => 'failed']);
            return false;
        } catch (\Exception $e) {
            \Log::error('Binance Verification Error: ' . $e->getMessage());
            return false;
        }
    }

    protected function refundBinance(Payment $payment)
    {
        try {
            $response = Http::withHeaders([
                'binancepay-key' => config('services.binance.key'),
                'binancepay-timestamp' => time() * 1000,
                'binancepay-nonce' => uniqid(),
                'binancepay-signature' => $this->generateBinanceSignature($payment)
            ])->post('https://api.binance.com/v1/order/refund', [
                'prepay_id' => $payment->provider_reference,
                'amount' => $payment->amount,
                'currency' => $payment->currency
            ]);

            return $response->successful() && $response->json('data.status') === 'REFUNDED';
        } catch (\Exception $e) {
            \Log::error('Binance Refund Error: ' . $e->getMessage());
            return false;
        }
    }

    private function generateBinanceSignature(Payment $payment)
    {
        // Implement Binance signature generation according to their documentation
        $timestamp = time() * 1000;
        $nonce = uniqid();
        $payload = $timestamp . "\n" . $nonce . "\n" . json_encode($payment) . "\n";
        return hash_hmac('sha512', $payload, config('services.binance.secret'));
    }
}