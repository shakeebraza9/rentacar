<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Order;
use Illuminate\Support\Facades\Crypt;

class PaymentController extends Controller
{

    public function checkout($encrypted_order_id)
    {
        try {
            // Order ID decrypt karein
            $order_id = Crypt::decryptString($encrypted_order_id);

            // Order fetch karein
            $order = Order::with('product')->findOrFail($order_id);

            return view('checkout', compact('order'));
        } catch (\Exception $e) {
            return abort(404, 'Invalid Order ID.');
        }
    }



    public function processPayment(Request $request)
{
    $order = Order::find($request->input('order_id'));

    if (!$order) {
        return back()->with('error', 'Order not found.');
    }

    $paymentMethod = $request->input('payment_method');

    if ($paymentMethod === 'paypal') {

        try {
            $provider = new \Srmklive\PayPal\Services\PayPal;
            $provider->setApiCredentials(config('services.paypal'));
            $paypalToken = $provider->getAccessToken();

            $orderData = [
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "MYR",
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
            'billAmount'             => $order->amount * 100,
            'billReturnUrl'          => route('payment.success', ['order_id' => $order->id]),
            'billCallbackUrl'        => route('payment.success', ['order_id' => $order->id]),
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

        return back()->with('error', 'fill all the feild valid your mobile number also.');
    }

    return back()->with('error', 'Please select a valid payment method.');
}



    public function paymentSuccess(Request $request)
    {
        $order = Order::find($request->input('order_id'));

        if (!$order) {
            return redirect()->route('checkout')->with('error', 'Order not found.');
        }

        $order->payment_status = 1;
        $order->save();

        return redirect()->route('dashboard')->with('success', 'Payment successful! Your order is confirmed.');
    }


    /**
     * Handle payment cancellation.
     */
    public function cancel(Request $request)
    {
        return view('payment_cancel');
    }
}