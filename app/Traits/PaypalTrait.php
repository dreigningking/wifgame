<?php
namespace App\Traits;

use App\Models\Payment;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Payments\CapturesRefundRequest;

trait PaypalTrait
{
    protected function getPayPalClient()
    {
        $environment = config('app.env') === 'production'
            ? new ProductionEnvironment(config('services.paypal.client_id'), config('services.paypal.secret'))
            : new SandboxEnvironment(config('services.paypal.sandbox.client_id'), config('services.paypal.sandbox.secret'));

        return new PayPalHttpClient($environment);
    }

    protected function initiatePaypal(Payment $payment)
    {
        try {
            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');
            $request->body = [
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
            ];

            $response = $this->getPayPalClient()->execute($request);
            
            $payment->update([
                'provider_reference' => $response->result->id,
                'status' => 'pending'
            ]);

            return [
                'status' => true,
                'approval_url' => collect($response->result->links)
                    ->firstWhere('rel', 'approve')->href
            ];
        } catch (\Exception $e) {
            \Log::error('PayPal Payment Error: ' . $e->getMessage());
            return false;
        }
    }

    protected function verifyPaypalPayment(Payment $payment)
    {
        try {
            $request = new OrdersCaptureRequest($payment->provider_reference);
            $response = $this->getPayPalClient()->execute($request);

            if ($response->result->status === 'COMPLETED') {
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
            $request = new CapturesRefundRequest($payment->provider_reference);
            $request->body = [
                'amount' => [
                    'currency_code' => $payment->currency,
                    'value' => number_format($payment->amount, 2, '.', '')
                ]
            ];

            $response = $this->getPayPalClient()->execute($request);
            return $response->result->status === 'COMPLETED';
        } catch (\Exception $e) {
            \Log::error('PayPal Refund Error: ' . $e->getMessage());
            return false;
        }
    }
}