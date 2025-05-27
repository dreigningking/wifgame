<?php
namespace App\Traits;

use App\Models\Payment;
use App\Traits\StripeTrait;
use App\Traits\PaystackTrait;
use App\Traits\PaypalTrait;
use App\Traits\BinanceTrait;

trait PaymentTrait
{
    use StripeTrait, PaystackTrait, PaypalTrait, BinanceTrait;

    protected function initializePayment(Payment $payment){
        switch($payment->payment_gateway){
            case 'paystack': 
                return $this->initiatePaystack($payment);
            case 'paypal': 
                return $this->initiatePaypal($payment);
            case 'binance': 
                return $this->initiateBinance($payment);
            default: 
                return $this->initiateStripe($payment);
        }
    }

    protected function verifyPayment(Payment $payment){
        switch($payment->beneficiary->country->payment_gateway){
            case 'paystack': 
                return $this->verifyPaystackPayment($payment);
            case 'paypal': 
                return $this->verifyPaypalPayment($payment);
            case 'binance': 
                return $this->verifyBinancePayment($payment);
            default: 
                return $this->verifyStripePayment($payment);
        }
    }

    protected function initializeRefund(Payment $payment){
        switch($payment->beneficiary->country->payment_gateway){
            case 'paystack': 
                return $this->refundPaystack($payment);
            case 'paypal': 
                return $this->refundPaypal($payment);
            case 'binance': 
                return $this->refundBinance($payment);
            default: 
                return $this->refundStripe($payment);
        }
    }
}