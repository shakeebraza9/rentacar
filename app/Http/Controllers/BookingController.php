<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Setting;
use Carbon\Carbon;
use App\Models\CarType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class BookingController extends Controller
{

        public function show($slug, Request $request)
        {
            $today = $request->query('today');
            $from = $request->query('from');

            $today = \Carbon\Carbon::parse($today);
            $from = \Carbon\Carbon::parse($from);

            $product = Product::where('slug', $slug)->firstOrFail();

            // Check if the product is already booked in the selected range
            $isBooked = Order::where('pro_id', $product->id)
                ->where(function ($query) use ($today, $from) {
                    $query->whereDate('from_date', '<=', $from)
                          ->whereDate('to_date', '>=', $today);
                })
                ->exists();

            // Fetch similar products that are NOT booked within the date range
            $similarProducts = Product::where('subcategory_id', $product->subcategory_id)
                ->where('id', '!=', $product->id)
                ->whereDoesntHave('orders', function ($query) use ($today, $from) {
                    $query->whereDate('from_date', '<=', $from)
                          ->whereDate('to_date', '>=', $today);
                })
                ->take(3)
                ->get();

            return view('theme.booking', compact('product', 'today', 'from', 'isBooked', 'similarProducts'));
        }


        public function show2($data)
        {
            $decodedData = json_decode(urldecode($data), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return abort(400, "Invalid booking data");
            }

            $pickupLocation = $decodedData['pickup_location'] ?? null;
            $returnLocation = $decodedData['return_location'] ?? null;
            $pickupDate = $decodedData['pickup_date'] ?? null;
            $returnDate = $decodedData['return_date'] ?? null;
            $pickup_time = $decodedData['pickup_time'] ?? null;
            $return_time = $decodedData['return_time'] ?? null;

            $pickupDateTime = Carbon::now()->format('Y-m-d H:i:s'); // Default now
            $returnDateTime = Carbon::now()->addDay()->format('Y-m-d H:i:s'); // Default next day

            if (!empty($pickupDate) && !empty($pickup_time)) {
                $pickupDateTime = Carbon::parse("$pickupDate $pickup_time")->format('Y-m-d H:i:s');
            }

            if (!empty($returnDate) && !empty($return_time)) {
                $returnDateTime = Carbon::parse("$returnDate $return_time")->format('Y-m-d H:i:s');
            }


            $pickupDate = $pickupDate ? Carbon::parse($pickupDate) : null;
            $returnDate = $returnDate ? Carbon::parse($returnDate) : null;

            $productsQuery = Product::whereNotExists(function ($query) use ($pickupDateTime, $returnDateTime) {
                $query->select(DB::raw(1))
                    ->from('orders')
                    ->whereRaw('orders.pro_id = products.id')
                    ->where(function ($q) use ($pickupDateTime, $returnDateTime) {
                        $q->whereRaw('DATE(orders.from_date) <= ?', [date('Y-m-d', strtotime($returnDateTime))])
                          ->whereRaw('DATE(orders.to_date) >= ?', [date('Y-m-d', strtotime($pickupDateTime))]);
                    });
            });


            $numberOfRecords = $productsQuery->count();

            $allProducts = $productsQuery->take(4)->get();

            $availableProducts = $allProducts->take(1);
            $similarProducts = $allProducts->slice(1, 3);

            $product = $availableProducts->first();

            return view('theme.bookingnew', compact('product', 'availableProducts', 'similarProducts', 'numberOfRecords', 'pickupDateTime', 'returnDateTime','pickupLocation','returnLocation'));
        }





        public function index($slug, Request $request)
        {
            $booking = Product::where('slug', $slug)->firstOrFail();
            $today = $request->query('today');
            $from = $request->query('from');

            if ($today) {
                $today = Carbon::parse($today)->setTimeFromTimeString($today);
            } else {
                $today = Carbon::now()->setTime(6, 0, 0);
            }

            if ($from) {
                $from = Carbon::parse($from)->setTimeFromTimeString($from);
            } else {
                $from = Carbon::now()->addDay()->setTime(6, 0, 0);
            }

            $carType = CarType::where('slug', strtolower($booking->type))->first();
            $price = $carType ? $carType->amount : 50.00;

            return view('theme.order', compact('booking', 'slug', 'today', 'from', 'price'));
        }






public function checkout(Request $request)
{


    if (!auth()->check()) {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $randomPassword = "mrholidays123";
            $user = User::create([
                'name' => $request->name ?? 'New User',
                'email' => $request->email,
                'created_by' => 1,
                'role_id' => 0,
                'password' => Hash::make($randomPassword),
            ]);

            Mail::send('emails.new_account', [
                'email' => $request->email,
                'password' => $randomPassword,
            ], function ($message) use ($request) {
                $message->to($request->email)->subject('Your New Account Details');
            });
        }

        Auth::login($user);
    }

    $userId = auth()->id();

    // $validatedData = $request->validate([
    //     'slug' => 'required|string|exists:products,slug',
    //     'name' => 'required|string|max:255',
    //     'country_code' => 'required|string|max:10',
    //     'country' => 'required|string|max:100',
    //     'user_passport' => 'nullable|string|max:100',
    //     'user_license' => 'nullable|string|max:100',
    //     'from' => 'nullable|date|after_or_equal:today',
    //     'today' => 'nullable|date|after_or_equal:from_date',
    // ]);


    $product = Product::where('slug', $request['slug'])->firstOrFail();

    $fromDate = $request['from'] ?? now()->format('Y-m-d H:i:s');
    $toDate = $request['today'] ?? Carbon::parse($fromDate)->addDay()->format('Y-m-d H:i:s');


    $settings = Setting::whereIn('field', ['rental', 'extra_hour', 'pickup_fee', 'return_fee', 'add-ons', 'discount'])
        ->pluck('value', 'field');

    $rental = 0;
    $extra_hour = (float) ($request->extracharge ?? 0);
    $pickup_fee = (float) ($settings['pickup_fee'] ?? 0);
    $return_fee = (float) ($settings['return_fee'] ?? 0);
    $addons = (float) ($settings['add-ons'] ?? 0);
    $discountPercent = (float) ($settings['discount'] ?? 0);
    $productPrice = (float) ($product->selling_price ?? 0);
    $selectedAddons = json_decode($request->selected_addons, true) ?? [];
    $addonsTotal = array_sum(array_column($selectedAddons, 'total'));

    // $session_extra_amount = $request->session_extra_amount ?? 0;
    $discountAmount = ($productPrice * $discountPercent) / 100;

    $totalBeforeDiscount = $rental + $extra_hour + $pickup_fee + $return_fee + $productPrice + $addonsTotal ;
    $total = max(0, $totalBeforeDiscount - $discountAmount);


    $paymentType = $request->input('payment_type');

    if ($paymentType === 'deposit') {
        $depositeamount = $request->input('depositeamount');

    } else {
        $depositeamount = 0 ;

    }


    $order = Order::create([
        'pro_id' => $product->id,
        'userid' => $userId,
        'buyer_name' => $request['name'],
        'buyer_email' => $request['email'],
        'buyer_phone_number' =>  $request->phone_number1,
        'passport' => $request->user_passport,
        'license' => $request->user_license,
        'buyer_country_of_origin' => $request['country'],
        'buyer_sec_name' => $request->invoice_name ?? null,
        'buyer_sec_phone_number' => $request->phone_number2 ?? null,
        'buyer_sec_invoice_address' => $request->invoice_address ?? null,
        'driver_name' => $request->driver_name ?? null,
        'driver_id_passport_number' => $request->driver_ic_number ?? null,
        'driver_license_number' => $request->driver_license_number ?? null,
        'driver_age' => $request->driver_age ?? null,
        'driver_mobile_number' => $request->driver_mobile_number ?? null,
        'note' => $request->note ?? null,
        'flight_no' => $request->flight_number ?? null,
        'from_date' => $fromDate,
        'to_date' => $toDate,
        'status' => $request->status ?? 'pending',
        'payment_status' => $request->payment_status ?? 0,
        'amount' => $total,
        'depositeamount' => $depositeamount,
        'selected_addons' => json_encode($selectedAddons),
    ]);

    if ($paymentType === 'deposit') {

        return redirect()->route('checkoutdeposit', [
            'order_id' => Crypt::encryptString($order->id),
        ])->with('success', 'Pay a deposit amount');

    } else {

    return redirect()->route('checkout', [
        'order_id' => Crypt::encryptString($order->id),
    ])->with('success', 'Pay a Full amount');

    }

}






}
