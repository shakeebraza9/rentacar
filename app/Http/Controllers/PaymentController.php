<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{

    public function checkout()
    {
        return view('checkout');
    }


    public function processPayment(Request $request)
    {
        // dd(env('PAYPAL_CLIENT_ID'), env('PAYPAL_SECRET'), env('PAYPAL_MODE'),env('APP_NAME'));

        $paymentMethod = $request->input('payment_method');

        if ($paymentMethod === 'paypal') {


            // dd( config('services.paypal') );
            try {
                $provider = new PayPalClient;
                // $provider->setApiCredentials(config('services.paypal'));
                $provider->setApiCredentials([
                    'client_id' => 'AWh0IFZzNEnf_K3sQHmY4X-2IinJDO7bIEM4-LFpQ6aThAAOs5ac1ANt2TqkDO2-RmPz2q6zz7kKMslh',
                    'client_secret' => 'EAETb_i5fjqgsKcGeFswsGOQFWjTlfrBGHXxNGgU4xATl-HTk7zJB2X18Yshw0DupRcVEje3vsHPEJuE',
                    'settings' => [
                        'mode' => 'sandbox',
                        'http.ConnectionTimeOut' => 30,
                        'log.LogEnabled' => true,
                        'log.FileName' => storage_path('logs/paypal.log'),
                        'log.LogLevel' => 'ERROR',
                    ],
                ]);


                $paypalToken = $provider->getAccessToken();

                $orderData = [
                    "intent" => "CAPTURE",
                    "purchase_units" => [
                        [
                            "amount" => [
                                "currency_code" => "MYR",
                                "value" => "140.00"
                            ]
                        ]
                    ],
                    "application_context" => [
                        "cancel_url" => route('payment.cancel'),
                        "return_url" => route('payment.success')
                    ]
                ];

                $order = $provider->createOrder($orderData);

                if (isset($order['id'])) {
                    foreach ($order['links'] as $link) {
                        if ($link['rel'] === 'approve') {
                            return redirect()->away($link['href']);
                        }
                    }
                }

                return redirect()->route('checkout')->with('error', 'Error processing PayPal payment.');
            } catch (\Exception $e) {
                return redirect()->route('checkout')->with('error', 'PayPal Error: ' . $e->getMessage());
            }

        } elseif ($paymentMethod === 'toyyibpay') {

            $toyyibpayUrl   = 'https://toyyibpay.com/index.php/api/createBill';
            $userSecretKey  = config('services.toyyibpay.secret');
            $categoryCode   = config('services.toyyibpay.user_id');

            $billData = [
                'userSecretKey'          => $userSecretKey,
                'categoryCode'           => $categoryCode,
                'billName'               => 'Rental Payment',
                'billDescription'        => 'Payment for rental booking',
                'billPriceSetting'       => 1,
                'billPayorInfo'          => 1,
                'billAmount'             => 14000, // RM140 = 14000 cents
                'billReturnUrl'          => route('payment.success'),
                'billCallbackUrl'        => route('payment.success'),
                'billExternalReferenceNo' => uniqid('rental_'),
                'billTo'                 => $request->input('name'),
                'billEmail'              => $request->input('email'),
                'billPhone'              => $request->input('phone_number'),
                'billSplitPayment'       => 0,
                'billSplitPaymentArgs'   => '',
                'billPaymentChannel'     => '0',
            ];

            $response = Http::asForm()->post($toyyibpayUrl, $billData);
            $result   = $response->json();

            if (is_array($result) && isset($result[0]['BillCode'])) {
                $billCode = $result[0]['BillCode'];
                return redirect()->away("https://toyyibpay.com/{$billCode}");
            }

            return redirect()->route('checkout')->with('error', 'Error processing Toyyibpay payment.');
        }

        return redirect()->route('checkout')->with('error', 'Please select a valid payment method.');
    }

    /**
     * Handle payment success callback.
     */
    public function success(Request $request)
    {
        return view('payment_success');
    }

    /**
     * Handle payment cancellation.
     */
    public function cancel(Request $request)
    {
        return view('payment_cancel');
    }
}