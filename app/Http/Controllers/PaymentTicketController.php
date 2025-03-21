<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\OrderTicket;
use Illuminate\Support\Facades\Crypt;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentTicketController extends Controller
{
    public function processPayment(Request $request)
    {
        $order = OrderTicket::find($request->input('order_id'));

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
                                "currency_code" => config('paypal.currency'),
                                "value" => $order->amount
                            ]
                        ]
                    ],
                    "application_context" => [
                        "cancel_url" => route('payment.cancel'),
                        "return_url" => route('payment.success', ['order_id' => $order->id])
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
                'billName'               => 'Ticket Payment',
                'billDescription'        => 'Payment for ticket booking',
                'billPriceSetting'       => 1,
                'billPayorInfo'          => 1,
                'billAmount'             => $order->amount * 100,
                'billReturnUrl'          => route('payment.success', ['order_id' => $order->id]),
                'billCallbackUrl'        => route('payment.success', ['order_id' => $order->id]),
                'billExternalReferenceNo' => uniqid('ticket_'),
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

            return back()->with('error', 'Please fill all the fields correctly, including a valid mobile number.');
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
                                'name' => 'Ticket Payment',
                            ],
                            'unit_amount'  => $order->amount * 100, // Convert to cents
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => route('payment.success', ['order_id' => $order->id]),
                    'cancel_url' => route('payment.cancel'),
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
        $order = OrderTicket::find($request->input('order_id'));

        if (!$order) {
            return redirect()->route('checkout')->with('error', 'Order not found.');
        }

        $order->payment_status = 1;
        $order->save();

        return redirect()->route('dashboard')->with('success', 'Payment successful! Your ticket order is confirmed.');
    }

    /**
     * Handle payment cancellation.
     */
    public function cancel(Request $request)
    {
        return view('payment_cancel');
    }
}
