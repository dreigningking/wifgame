<?php
namespace App\Http\Controllers\User;

use App\Models\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

// PayPal Checkout SDK v2 imports
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

use Stripe\Stripe;
use Stripe\Checkout\Session;


class DonationController extends Controller
{
    public function process(Request $request)
    {
        // Comprehensive validation
        $validated = $request->validate([
            'donation_amount' => ['required', function ($attribute, $value, $fail) use ($request) {
                if ($value === 'custom') {
                    if (!$request->filled('custom_amount')) {
                        $fail('Custom amount is required when custom option is selected.');
                    } elseif (!is_numeric($request->custom_amount) || $request->custom_amount <= 0) {
                        $fail('Custom amount must be a positive number.');
                    } elseif ($request->custom_amount > 10000) {
                        $fail('Donation amount cannot exceed $10,000.');
                    }
                } elseif (!is_numeric($value) || $value <= 0) {
                    $fail('Donation amount must be a positive number.');
                }
            }],
            'custom_amount' => 'nullable|numeric|min:1|max:10000',
            'payment_method' => ['required', Rule::in(['paypal', 'stripe', 'paystack', 'binance'])],
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => 'nullable|email|max:255',
        ]);

        $amount = $validated['donation_amount'] === 'custom' 
            ? $validated['custom_amount'] 
            : $validated['donation_amount'];

        try {
            // Save donation details
            $donation = Donation::create([
                'donor_name' => $validated['donor_name'] ?? 'Anonymous',
                'donor_email' => $validated['donor_email'] ?? null,
                'amount' => $amount,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
                'ip_address' => $request->ip(), // For security tracking
                'user_agent' => $request->userAgent(),
            ]);

            Log::info('Donation created', [
                'donation_id' => $donation->id,
                'amount' => $amount,
                'payment_method' => $validated['payment_method']
            ]);

            // Redirect to the appropriate payment gateway
            return $this->routeToPaymentGateway($donation);

        } catch (\Exception $e) {
            Log::error('Failed to create donation', [
                'error' => $e->getMessage(),
                'amount' => $amount,
                'payment_method' => $validated['payment_method']
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to process donation. Please try again.');
        }
    }

    private function routeToPaymentGateway(Donation $donation)
    {
        switch ($donation->payment_method) {
            case 'paypal':
                return $this->processPayPal($donation);
            case 'stripe':
                return $this->processStripe($donation);
            case 'paystack':
                return $this->processPaystack($donation);
            case 'binance':
                return $this->processBinance($donation);
            default:
                Log::error('Invalid payment method', [
                    'donation_id' => $donation->id,
                    'payment_method' => $donation->payment_method
                ]);
                return redirect()->back()->with('error', 'Invalid payment method selected.');
        }
    }

    private function processPayPal(Donation $donation)
    {
        try {
            // Validate PayPal credentials
            $clientId = config('services.paypal.client_id');
            $secret = config('services.paypal.secret');
            $mode = config('services.paypal.mode', 'sandbox');
            
            if (empty($clientId) || empty($secret)) {
                throw new \Exception('PayPal credentials not configured');
            }

            // Create PayPal environment
            if ($mode === 'live' || $mode === 'production') {
                $environment = new ProductionEnvironment($clientId, $secret);
            } else {
                $environment = new SandboxEnvironment($clientId, $secret);
            }

            // Create PayPal client
            $client = new PayPalHttpClient($environment);

            // Validate donation amount
            if (!is_numeric($donation->amount) || $donation->amount <= 0) {
                throw new \Exception('Invalid donation amount: ' . $donation->amount);
            }

            // Create order request
            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');
            
            $orderData = [
                'intent' => 'CAPTURE',
                'application_context' => [
                    'return_url' => route('paypal.success', ['donation_id' => $donation->id]),
                    'cancel_url' => route('paypal.cancel', ['donation_id' => $donation->id]),
                    'brand_name' => config('app.name', 'Our Site'),
                    'locale' => 'en-US',
                    'landing_page' => 'BILLING',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW'
                ],
                'purchase_units' => [
                    [
                        'reference_id' => 'DONATION-' . $donation->id,
                        'description' => 'Donation to ' . config('app.name', 'Our Site'),
                        'custom_id' => (string)$donation->id,
                        'soft_descriptor' => 'DONATION',
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => number_format((float)$donation->amount, 2, '.', '')
                        ]
                    ]
                ]
            ];

            $request->body = $orderData;

            Log::info('Creating PayPal order', [
                'donation_id' => $donation->id,
                'amount' => $donation->amount,
                'mode' => $mode
            ]);

            // Execute the request
            $response = $client->execute($request);

            if ($response->statusCode !== 201) {
                throw new \Exception('PayPal order creation failed with status: ' . $response->statusCode);
            }

            $order = $response->result;
            
            Log::info('PayPal order created successfully', [
                'donation_id' => $donation->id,
                'order_id' => $order->id,
                'status' => $order->status
            ]);

            // Find approval URL
            $approvalUrl = null;
            if (isset($order->links)) {
                foreach ($order->links as $link) {
                    if ($link->rel === 'approve') {
                        $approvalUrl = $link->href;
                        break;
                    }
                }
            }

            if ($approvalUrl) {
                // Update donation with PayPal order ID
                $donation->update([
                    'payment_gateway_id' => $order->id,
                    'status' => 'redirecting'
                ]);
                
                return redirect()->away($approvalUrl);
            }

            // If approval URL not found
            Log::error('PayPal approval URL not found', [
                'donation_id' => $donation->id,
                'order_id' => $order->id,
                'links' => $order->links ?? 'no links'
            ]);

            return redirect()->back()->with('error', 'Unable to redirect to PayPal. Please try again.');

        } catch (\PayPalHttp\HttpException $ex) {
            Log::error('PayPal HTTP error', [
                'donation_id' => $donation->id,
                'status_code' => $ex->statusCode,
                'message' => $ex->getMessage(),
                'details' => $ex->headers ?? []
            ]);
            
            return redirect()->back()->with('error', 'PayPal service error. Please try again later.');
            
        } catch (\Exception $ex) {
            Log::error('PayPal general error', [
                'donation_id' => $donation->id,
                'error' => $ex->getMessage(),
                'file' => $ex->getFile(),
                'line' => $ex->getLine()
            ]);
            
            return redirect()->back()->with('error', 'An error occurred while processing your PayPal payment. Please try again.');
        }
    }

    private function processStripe(Donation $donation)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));
    
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Donation to ' . config('app.name'),
                        ],
                        'unit_amount' => intval($donation->amount * 100), // amount in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('stripe.success', ['donation_id' => $donation->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.cancel', ['donation_id' => $donation->id]),
                'metadata' => [
                    'donation_id' => $donation->id,
                ],
            ]);
    
            // Update donation with Stripe session ID and status
            $donation->update([
                'payment_gateway_id' => $session->id,
                'status' => 'redirecting'
            ]);
    
            return redirect($session->url);
    
        } catch (\Exception $e) {
            Log::error('Stripe checkout error', [
                'donation_id' => $donation->id,
                'error' => $e->getMessage(),
            ]);
    
            return redirect()->back()->with('error', 'Unable to process Stripe payment.');
        }
    }

    private function processPaystack(Donation $donation)
    {
        try {
            $callback_url = route('paystack.callback', ['donation_id' => $donation->id]);
    
            $fields = [
                'email' => $donation->donor_email ?? 'anonymous@example.com',
                'amount' => $donation->amount * 100, // amount in kobo
                'callback_url' => $callback_url,
                'metadata' => json_encode([
                    'donation_id' => $donation->id,
                    'donor_name' => $donation->donor_name,
                ]),
            ];
    
            $response = Http::withToken(config('services.paystack.secret'))
                ->post(config('services.paystack.payment_url') . '/transaction/initialize', $fields);
    
            if ($response->successful() && isset($response['data']['authorization_url'])) {
                $donation->update([
                    'payment_gateway_id' => $response['data']['reference'],
                    'status' => 'redirecting',
                ]);
    
                return redirect()->away($response['data']['authorization_url']);
            }
    
            throw new \Exception('Unable to initialize Paystack payment: ' . $response->body());
    
        } catch (\Exception $e) {
            Log::error('Paystack initialization error', [
                'donation_id' => $donation->id,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Unable to process Paystack payment.');
        }
    }

    public function paystackCallback(Request $request, $donation_id)
{
    $donation = Donation::findOrFail($donation_id);

    try {
        $reference = $request->query('reference');

        $response = Http::withToken(config('services.paystack.secret'))
            ->get(config('services.paystack.payment_url') . '/transaction/verify/' . $reference);

        if ($response->successful() && $response['data']['status'] === 'success') {
            $donation->update([
                'status' => 'completed',
                'payment_gateway_id' => $response['data']['reference'],
            ]);

             return redirect()->back()->with('success', 'Thank you for your donation!');
        }

        $donation->update(['status' => 'failed']);

             return redirect()->back()->with('error', 'Donation verification failed.');

    } catch (\Exception $e) {
        Log::error('Paystack callback error', [
            'donation_id' => $donation->id,
            'error' => $e->getMessage()
        ]);

             return redirect()->back()->with('error', 'Unable to verify payment at this time.');
    }
}


    private function processBinance(Donation $donation)
    {
        try {
            $timestamp = round(microtime(true) * 1000);
            $payload = [
                'merchantId' => config('services.binance.merchant_id'),
                'prepayId' => uniqid('donation_', true),
                'currency' => 'USDT',
                'amount' => number_format((float) $donation->amount, 2, '.', ''),
                'goods' => [
                    'goodsType' => '02',
                    'goodsCategory' => '4000',
                    'referenceGoodsId' => 'donation_' . $donation->id,
                    'goodsName' => 'Donation to ' . config('app.name'),
                    'goodsDetail' => 'Online donation',
                ],
                'returnUrl' => route('binance.success', ['donation_id' => $donation->id]),
                'cancelUrl' => route('binance.cancel', ['donation_id' => $donation->id]),
                'timestamp' => $timestamp,
                'nonce' => bin2hex(random_bytes(16)),
                'bizType' => 'CRYPTO_PAYMENT'
            ];
    
            $jsonBody = json_encode($payload, JSON_UNESCAPED_SLASHES);
            $signature = hash_hmac('sha512', $jsonBody, config('services.binance.api_secret'));
    
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'BinancePay-Timestamp' => $timestamp,
                'BinancePay-Nonce' => $payload['nonce'],
                'BinancePay-Certificate-SN' => config('services.binance.api_key'),
                'BinancePay-Signature' => $signature,
            ])->post('https://bpay.binanceapi.com/binancepay/openapi/order', $payload);
    
            $data = $response->json();
    
            if ($data['status'] === 'SUCCESS') {
                $donation->update([
                    'payment_gateway_id' => $payload['prepayId'],
                    'status' => 'redirecting',
                ]);
    
                return redirect()->away($data['data']['checkoutUrl']);
            }
    
            Log::error('Binance Pay failed', [
                'response' => $data,
                'donation_id' => $donation->id,
            ]);
    
            return redirect()->back()->with('error', 'Unable to redirect to Binance Pay. Please try again.');
    
        } catch (\Exception $e) {
            Log::error('Binance Pay error', [
                'donation_id' => $donation->id,
                'error' => $e->getMessage(),
            ]);
    
            return redirect()->back()->with('error', 'Binance payment failed. Please try again.');
        }
    }

    /**
     * Handle PayPal success callback
     */
    public function paypalSuccess(Request $request)
    {
        try {
            $donationId = $request->route('donation_id');
            $token = $request->query('token');
            $payerId = $request->query('PayerID');

            if (!$donationId || !$token || !$payerId) {
                Log::error('PayPal success: Missing parameters', [
                    'donation_id' => $donationId,
                    'token' => $token,
                    'payer_id' => $payerId
                ]);
                return redirect()->route('donation.form')->with('error', 'Invalid PayPal response.');
            }

            $donation = Donation::findOrFail($donationId);

            // Validate PayPal credentials
            $clientId = config('services.paypal.client_id');
            $secret = config('services.paypal.secret');
            $mode = config('services.paypal.mode', 'sandbox');

            // Create PayPal environment and client
            if ($mode === 'live' || $mode === 'production') {
                $environment = new ProductionEnvironment($clientId, $secret);
            } else {
                $environment = new SandboxEnvironment($clientId, $secret);
            }
            $client = new PayPalHttpClient($environment);

            // Capture the order
            $request = new OrdersCaptureRequest($donation->payment_gateway_id);
            $request->prefer('return=representation');

            $response = $client->execute($request);

            if ($response->statusCode === 201) {
                $captureData = $response->result;
                
                // Update donation status
                $donation->update([
                    'status' => 'completed',
                    'payment_gateway_response' => json_encode($captureData),
                    'completed_at' => now()
                ]);

                Log::info('PayPal donation completed', [
                    'donation_id' => $donation->id,
                    'capture_id' => $captureData->id,
                    'amount' => $donation->amount
                ]);

                return redirect()->route('donation.success')->with('success', 'Thank you for your donation!');
            } else {
                throw new \Exception('PayPal capture failed with status: ' . $response->statusCode);
            }

        } catch (\Exception $ex) {
            Log::error('PayPal success callback error', [
                'donation_id' => $donationId ?? 'unknown',
                'error' => $ex->getMessage()
            ]);

            return redirect()->route('donation.form')->with('error', 'Payment verification failed. Please contact support.');
        }
    }

    /**
     * Handle PayPal cancel callback
     */
    public function paypalCancel(Request $request)
    {
        try {
            $donationId = $request->route('donation_id');
            
            if ($donationId) {
                $donation = Donation::find($donationId);
                if ($donation) {
                    $donation->update(['status' => 'cancelled']);
                    
                    Log::info('PayPal donation cancelled', [
                        'donation_id' => $donation->id
                    ]);
                }
            }

            return redirect()->route('donation.form')->with('info', 'Payment was cancelled. You can try again.');

        } catch (\Exception $ex) {
            Log::error('PayPal cancel callback error', [
                'donation_id' => $donationId ?? 'unknown',
                'error' => $ex->getMessage()
            ]);

            return redirect()->route('donation.form')->with('error', 'An error occurred. Please try again.');
        }
    }

    public function stripeSuccess(Request $request, $donation_id)
{
    try {
        // Retrieve the donation
        $donation = Donation::findOrFail($donation_id);

        // Update the donation status to completed
        $donation->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        Log::info('Stripe donation completed', [
            'donation_id' => $donation->id,
            'amount' => $donation->amount,
        ]);

        return redirect()->route('index')->with('success', 'Thank you for your donation!');
    } catch (\Exception $ex) {
        Log::error('Stripe success callback error', [
            'donation_id' => $donation_id ?? 'unknown',
            'error' => $ex->getMessage(),
        ]);

        return redirect()->route('index')->with('error', 'Payment verification failed. Please contact support.');
    }
}

public function binanceSuccess($donation_id)
{
    $donation = Donation::findOrFail($donation_id);
    $donation->update(['status' => 'completed']);

    return redirect()->route('donation.thankyou')->with('success', 'Thank you for your donation!');
}

public function binanceCancel($donation_id)
{
    $donation = Donation::findOrFail($donation_id);
    $donation->update(['status' => 'cancelled']);

    return redirect()->route('donation.form')->with('error', 'Donation was cancelled.');
}


    
}