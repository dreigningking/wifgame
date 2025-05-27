<?php

namespace App\Http\Controllers\User;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\PaymentTrait;
use Illuminate\Support\Facades\Validator;

 
class DonationController extends Controller
{
    use PaymentTrait;
    public function process(Request $request)
    {
        // Validate the request
        // try {
            $validator = Validator::make($request->all(), [  
                'email' => 'required|email',  
                'amount' => 'required_without:custom_amount',  
                'custom_amount' => 'required_if:amount,custom|min:0',  
                'currency' => 'required|string|size:3',  
                'payment_method' => 'required|in:paypal,stripe,binance,paystack',  
            ]);  
            
            if ($validator->fails()) {  
                return response()->json($validator->errors(), 422);  
            }  
            $amount = $request->amount === 'custom' 
                ? $request->custom_amount 
                : $request->amount;

            // Create a new payment record  
            $payment = Payment::create([  
                'user_id' => auth()->id(), // Assuming user authentication  
                'email' => $request->email,  
                'type' => 'donation',  
                'amount' => $amount,  
                'currency' => $request->currency,  
                'payment_gateway' => $request->payment_method,  
                'status' => 'pending', // Initial status  
                'metadata' => json_encode($request->all()), // Store request data for reference  
            ]);  

            // Initialize payment through the payment gateway  
            $paymentResponse = $this->initializePayment($payment);  
            dd($paymentResponse);
            // Check the response and perform actions accordingly  
            if ($paymentResponse['success']) {  
                // Optionally store any references or additional information  
                $payment->update([  
                    'provider_reference' => $paymentResponse['provider_reference'] ?? null,  
                    'status' => 'pending', // Status can be updated based on your gateway response  
                ]);  
            } else {  
                // Handle failure response, return any error messages  
                return response()->json([  
                    'success' => false,  
                    'message' => $paymentResponse['message'] ?? 'Payment initiation failed',  
                ], 422);  
            }  

            // Redirect the user if necessary (depends on the payment gateway response)  
            return response()->json([  
                'success' => true,  
                'message' => 'Redirecting to payment gateway',  
                'redirect_url' => $paymentResponse['redirect_url'], // Assuming this exists in the response  
            ]);     
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => $e->getMessage()
        //     ], 422);
        // }
    }
}
