<?php
namespace App\Traits;

use App\Models\Payout;
use App\Models\Payment;
use App\Models\Settlement;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;

trait PaystackTrait
{
    protected function initiatePaystack(Payment $payment)
    {
        try {
            $response = Http::withToken(config('services.paystack.secret'))
                ->post('https://api.paystack.co/transaction/initialize', [
                    'email' => $payment->user->email,
                    'amount' => $payment->amount * 100,
                    'currency' => $payment->currency,
                    'reference' => $payment->reference,
                    'callback_url' => route('payment.paystack.callback')
                ]);

            if ($response->successful() && $response->json('status')) {
                $payment->update([
                    'provider_reference' => $response->json('data.reference'),
                    'status' => 'pending'
                ]);

                return [
                    'status' => true,
                    'authorization_url' => $response->json('data.authorization_url')
                ];
            }

            return false;
        } catch (\Exception $e) {
            \Log::error('Paystack Payment Error: ' . $e->getMessage());
            return false;
        }
    }

    protected function verifyPaystackPayment(Payment $payment)
    {
        try {
            $response = Http::withToken(config('services.paystack.secret'))
                ->get('https://api.paystack.co/transaction/verify/' . $payment->reference);

            if ($response->successful() && 
                $response->json('status') && 
                $response->json('data.status') === 'success') {
                
                $payment->update(['status' => 'success']);
                return true;
            }

            $payment->update(['status' => 'failed']);
            return false;
        } catch (\Exception $e) {
            \Log::error('Paystack Verification Error: ' . $e->getMessage());
            return false;
        }
    }

    protected function refundPaystack(Payment $payment)
    {
        try {
            $response = Http::withToken(config('services.paystack.secret'))
                ->post('https://api.paystack.co/refund', [
                    'transaction' => $payment->reference,
                    'amount' => $payment->amount * 100
                ]);

            return $response->successful() && $response->json('status');
        } catch (\Exception $e) {
            \Log::error('Paystack Refund Error: ' . $e->getMessage());
            return false;
        }
    }
}