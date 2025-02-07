<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    /**
     * Show the checkout page.
     */
    public function checkout()
    {
        return view('checkout');
    }

    /**
     * Process the payment based on the chosen method.
     */
    public function processPayment(Request $request)
    {
        $paymentMethod = $request->input('payment_method');

        if ($paymentMethod === 'paypal') {
            // -------------------------------------------------
            // PAYPAL INTEGRATION (Using srmklive/paypal)
            // -------------------------------------------------
            // Make sure your config matches the library's needs:
            //     'paypal' => [
            //         'client_id' => env('PAYPAL_CLIENT_ID'),
            //         'secret'    => env('PAYPAL_SECRET'), // or 'client_secret'
            //         ...
            //     ],
            // in either config/services.php or config/paypal.php.
            // Then ensure your .env has:
            //     PAYPAL_CLIENT_ID=XXXX
            //     PAYPAL_SECRET=XXXX
            //     PAYPAL_MODE=sandbox
            // Clear config cache: php artisan config:clear && php artisan cache:clear
            // dd(config('services.paypal'));

            $provider = \PayPal::setProvider();
            \dd($provider);
            $provider->setApiCredentials(config('services.paypal')); 
            // or config('paypal') if that's your main config file

            $paypalToken = $provider->getAccessToken(); // <--- Where "missing client_id" might show up if config is wrong

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
                // Find the approval URL from the response links
                foreach ($order['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            return redirect()->route('checkout')->with('error', 'Error processing PayPal payment.');

        } elseif ($paymentMethod === 'toyyibpay') {
            // -------------------------------------------------
            // TOYYIBPAY INTEGRATION
            // -------------------------------------------------
            // Must send form data (not JSON) & pass correct fields.
            // Also, billAmount is in cents, so RM140 => 14000.
            // Make sure userSecretKey & categoryCode are correct.

            $toyyibpayUrl   = 'https://toyyibpay.com/index.php/api/createBill';

            $userSecretKey  = config('services.toyyibpay.secret');   // From your .env
            $categoryCode   = config('services.toyyibpay.user_id');  // "user_id" might actually be your categoryCode

            // Prepare your bill data (adjust according to Toyyibpay’s API docs)
            $billData = [
                'userSecretKey'          => $userSecretKey,
                'categoryCode'           => $categoryCode,
                'billName'               => 'Rental Payment',
                'billDescription'        => 'Payment for rental booking',
                'billPriceSetting'       => 1,
                'billPayorInfo'          => 1,
                // Amount in cents: RM140 => 14000
                'billAmount'             => 14000,
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

            // Use asForm() so it sends form-encoded data:
            $response = Http::asForm()->post($toyyibpayUrl, $billData);

            $result   = $response->json();

            // Example response on success:
            // [ "BillCode" => "xxxxxxx" ]
            // On error, might be: [ "status" => "error", "msg" => "..." ]
            if (is_array($result) && isset($result[0]['BillCode'])) {
                $billCode = $result[0]['BillCode'];
                return redirect()->away("https://toyyibpay.com/{$billCode}");
            }

            return redirect()->route('checkout')->with('error', 'Error processing Toyyibpay payment.');

        } else {
            return redirect()->route('checkout')->with('error', 'Please select a valid payment method.');
        }
    }

    /**
     * Handle payment success callback.
     */
    public function success(Request $request)
    {
        // Here you can verify the payment details, update order status, etc.
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
