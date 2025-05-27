<?php
namespace App\Traits;

use App\Models\Payment;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Http;

trait StripeTrait
{
    protected function initiateStripe(Payment $payment)
    {
        try {
            $response = Http::withToken(config('services.stripe.secret'))
                ->post('https://api.stripe.com/v1/payment_intents', [
                    'amount' => $payment->amount * 100, // Convert to cents
                    'currency' => strtolower($payment->currency),
                    'payment_method_types' => ['card'],
                    'metadata' => [
                        'payment_id' => $payment->id,
                        'reference' => $payment->reference
                    ]
                ]);

            if ($response->successful()) {
                $payment->update([
                    'provider_reference' => $response['id'],
                    'status' => 'pending'
                ]);

                return [
                    'status' => true,
                    'client_secret' => $response['client_secret'],
                    'publishable_key' => config('services.stripe.key')
                ];
            }

            \Log::error('Stripe Error: ', $response->json());
            return false;
        } catch (\Exception $e) {
            \Log::error('Stripe Exception: ' . $e->getMessage());
            return false;
        }
    }

    protected function verifyStripePayment(Payment $payment)
    {
        try {
            $response = Http::withToken(config('services.stripe.secret'))
                ->get("https://api.stripe.com/v1/payment_intents/{$payment->provider_reference}");

            if ($response->successful() && $response['status'] === 'succeeded') {
                $payment->update(['status' => 'success']);
                return true;
            }

            $payment->update(['status' => 'failed']);
            return false;
        } catch (\Exception $e) {
            \Log::error('Stripe Verification Error: ' . $e->getMessage());
            return false;
        }
    }

    protected function refundStripe(Payment $payment)
    {
        try {
            $response = Http::withToken(config('services.stripe.secret'))
                ->post('https://api.stripe.com/v1/refunds', [
                    'payment_intent' => $payment->provider_reference
                ]);

            return $response->successful();
        } catch (\Exception $e) {
            \Log::error('Stripe Refund Error: ' . $e->getMessage());
            return false;
        }
    }
}