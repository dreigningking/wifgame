<?php
namespace App\Traits;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;

trait PaypalTrait
{
    protected function getPayPalAccessToken()
    {
        try {
            $credentials = base64_encode(config('services.paypal.client_id') . ':' . config('services.paypal.secret'));
            
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $credentials
            ])->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

            if ($response->successful()) {
                return $response['access_token'];
            }
            
            return null;
        } catch (\Exception $e) {
            \Log::error('PayPal Token Error: ' . $e->getMessage());
            return null;
        }
    }

    protected function initiatePaypal(Payment $payment)
    {
        try {
            $token = $this->getPayPalAccessToken();
            if (!$token) return false;

            $response = Http::withToken($token)
                ->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [[
                        'reference_id' => $payment->reference,
                        'amount' => [
                            'currency_code' => $payment->currency,
                            'value' => number_format($payment->amount, 2, '.', '')
                        ]
                    ]],
                    'application_context' => [
                        'return_url' => route('payment.paypal.success'),
                        'cancel_url' => route('payment.paypal.cancel')
                    ]
                ]);

            if ($response->successful()) {
                $payment->update([
                    'provider_reference' => $response['id'],
                    'status' => 'pending'
                ]);

                return [
                    'status' => true,
                    'approval_url' => collect($response['links'])
                        ->firstWhere('rel', 'approve')['href']
                ];
            }

            \Log::error('PayPal Error: ', $response->json());
            return false;
        } catch (\Exception $e) {
            \Log::error('PayPal Exception: ' . $e->getMessage());
            return false;
        }
    }

    protected function verifyPaypalPayment(Payment $payment)
    {
        try {
            $token = $this->getPayPalAccessToken();
            if (!$token) return false;

            $response = Http::withToken($token)
                ->get("https://api-m.sandbox.paypal.com/v2/checkout/orders/{$payment->provider_reference}");

            if ($response->successful() && $response['status'] === 'COMPLETED') {
                $payment->update(['status' => 'success']);
                return true;
            }

            $payment->update(['status' => 'failed']);
            return false;
        } catch (\Exception $e) {
            \Log::error('PayPal Verification Error: ' . $e->getMessage());
            return false;
        }
    }

    protected function refundPaypal(Payment $payment)
    {
        try {
            $token = $this->getPayPalAccessToken();
            if (!$token) return false;

            $response = Http::withToken($token)
                ->post("https://api-m.sandbox.paypal.com/v2/payments/captures/{$payment->provider_reference}/refund");

            return $response->successful();
        } catch (\Exception $e) {
            \Log::error('PayPal Refund Error: ' . $e->getMessage());
            return false;
        }
    }
}