<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Order;
use Illuminate\Support\Facades\Crypt;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DepositePaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $order = Order::find($request->input('order_id'));

        if (!$order) {
            return back()->with('error', 'Order not found.');
        }

        $paymentMethod = $request->input('payment_method');

        // PayPal Payment Handling
        if ($paymentMethod === 'paypal') {

            try {
                $provider = new \Srmklive\PayPal\Services\PayPal;
                $provider->setApiCredentials(config('paypal'));
                $paypalToken = $provider->getAccessToken();

                $orderData = [
                    "intent" => "CAPTURE",
                    "purchase_units" => [
                        [
                            "amount" => [
                                "currency_code" => config('paypal.currency'), // USD, MYR, etc.
                                "value" => $order->depositeamount
                            ]
                        ]
                    ],
                    "application_context" => [
                        "cancel_url" => route('depositpayment.cancel'),
                        "return_url" => route('depositpayment.success', ['order_id' => $order->id])
                    ]
                ];

                $paypalOrder = $provider->createOrder($orderData);



                if (isset($paypalOrder['id'])) {
                    foreach ($paypalOrder['links'] as $link) {
                        if ($link['rel'] === 'approve') {
                            return redirect()->away($link['href']);
                        }
                    }
                }

                return back()->with('error', 'Error processing PayPal payment.');
            } catch (\Exception $e) {
                Log::error('PayPal Error: ' . $e->getMessage());
                return back()->with('error', 'PayPal Error: ' . $e->getMessage());
            }

        }

        // ToyyibPay Payment Handling
        elseif ($paymentMethod === 'toyyibpay') {
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
                'billAmount'             => $order->depositeamount * 100,
                'billReturnUrl'          => route('depositpayment.success', ['order_id' => $order->id]),
                'billCallbackUrl'        => route('depositpayment.success', ['order_id' => $order->id]),
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

            return back()->with('error', 'Please fill all fields correctly, including a valid mobile number.');
        }

        // Stripe Payment Handling
        elseif ($paymentMethod === 'stripe') {
            try {

                Stripe::setApiKey(config('services.stripe.secret'));


                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency'     => 'myr',
                            'product_data' => [
                                'name' => 'Rental Payment',
                            ],
                            'unit_amount'  => $order->depositeamount * 100, // Convert to cents
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => route('depositpayment.success', ['order_id' => $order->id]),
                    'cancel_url' => route('depositpayment.cancel'),
                ]);

                return redirect()->away($session->url);
            } catch (\Exception $e) {
                return back()->with('error', 'Stripe Error: ' . $e->getMessage());
            }
        }

        return back()->with('error', 'Please select a valid payment method.');
    }

    public function paymentSuccess(Request $request)
{
    $order = Order::find($request->input('order_id'));

    if (!$order) {
        return back()->with('error', 'Order not found.');
    }

    DB::transaction(function () use ($order) {
        // Deduct deposit amount from total amount
        $order->amount -= $order->depositeamount;
        $order->deposit_status = 1; // Mark deposit as paid
        $order->save();
    });

    return redirect()->route('home')->with('success', 'Payment successful and deposit deducted.');
}


    public function paymentCancel()
{
    return redirect()->route('home')->with('error', 'Payment was cancelled.');
}

}