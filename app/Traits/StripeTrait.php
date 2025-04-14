<?php
namespace App\Traits;

use App\Models\Payment;
use App\Models\Profile;
use App\Models\Settlement;
use Ixudra\Curl\Facades\Curl;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Refund;

trait StripeTrait
{
    protected function initiateStripe(Payment $payment)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $payment->amount * 100, // Amount in cents
                'currency' => strtolower($payment->currency),
                'payment_method_types' => ['card'],
                'metadata' => [
                    'payment_id' => $payment->id,
                    'reference' => $payment->reference
                ]
            ]);

            $payment->update([
                'provider_reference' => $paymentIntent->id,
                'status' => 'pending'
            ]);

            return [
                'status' => true,
                'client_secret' => $paymentIntent->client_secret,
                'publishable_key' => config('services.stripe.key')
            ];
        } catch (\Exception $e) {
            \Log::error('Stripe Payment Error: ' . $e->getMessage());
            return false;
        }
    }

    protected function verifyStripePayment(Payment $payment)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $paymentIntent = PaymentIntent::retrieve($payment->provider_reference);

            if ($paymentIntent->status === 'succeeded') {
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
            Stripe::setApiKey(config('services.stripe.secret'));
            
            $refund = Refund::create([
                'payment_intent' => $payment->provider_reference,
                'amount' => $payment->amount * 100
            ]);

            return $refund->status === 'succeeded';
        } catch (\Exception $e) {
            \Log::error('Stripe Refund Error: ' . $e->getMessage());
            return false;
        }
    }


}