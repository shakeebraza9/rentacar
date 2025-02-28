<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;



use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Setting;
use Carbon\Carbon;
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

        $pickupDateTime = Carbon::now()->format('Y-m-d H:i:s'); // Default: Current Date & Time
        $returnDateTime = Carbon::now()->addDay()->format('Y-m-d H:i:s'); // Default: Next Day Same Time

        if (!empty($pickupDate) && !empty($pickup_time)) {
            $pickupDateTime = Carbon::parse("$pickupDate $pickup_time")->format('Y-m-d H:i:s');
        }

        if (!empty($returnDate) && !empty($return_time)) {
            $returnDateTime = Carbon::parse("$returnDate $return_time")->format('Y-m-d H:i:s');
        }

        // dd($pickupDateTime, $returnDateTime);


    $pickupDate = $pickupDate ? \Carbon\Carbon::parse($pickupDate) : null;
    $returnDate = $returnDate ? \Carbon\Carbon::parse($returnDate) : null;

    $productsQuery = Product::leftJoin('orders', 'products.id', '=', 'orders.pro_id')
        ->select(
            'products.*',
            'orders.id as order_id',
            'orders.from_date',
            'orders.to_date'
        );

        if ($pickupLocation) {
            $productsQuery->whereRaw("LOWER(products.pickup_location) LIKE ?", ['%' . strtolower($pickupLocation) . '%']);
        }
        if ($returnLocation) {
            $productsQuery->where('products.dropoff_location', $returnLocation);
        }


    if ($pickupDate && $returnDate) {
        $productsQuery->where(function ($query) use ($pickupDate, $returnDate) {
            $query->whereNull('orders.id')
                  ->orWhere(function ($query) use ($pickupDate, $returnDate) {
                      $query->whereDate('orders.to_date', '<', $pickupDate)
                            ->orWhereDate('orders.from_date', '>', $returnDate);
                  });
        });
    }
    $numberOfRecords = $productsQuery->count();

    $allProducts = $productsQuery->take(4)->get();


    $availableProducts = $allProducts->take(1);
    $similarProducts = $allProducts->slice(1, 3);
    $product = $availableProducts->first();


    $isBooked = $productsQuery->whereNotNull('orders.id')->exists();

    return view('theme.bookingnew', compact('isBooked', 'product', 'availableProducts', 'similarProducts','numberOfRecords','pickupDateTime','returnDateTime'));
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

    return view('theme.order', compact('booking', 'slug', 'today', 'from'));
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

    $validatedData = $request->validate([
        'slug' => 'required|string|exists:products,slug',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'country_code' => 'required|string|max:10',
        'country' => 'required|string|max:100',
        'user_passport' => 'nullable|string|max:100',
        'user_license' => 'nullable|string|max:100',
        'from' => 'nullable|date|after_or_equal:today',
        'today' => 'nullable|date|after_or_equal:from_date',
    ]);

    $product = Product::where('slug', $validatedData['slug'])->firstOrFail();

    $fromDate = $validatedData['from'] ?? now()->format('Y-m-d H:i:s');
    $toDate = $validatedData['today'] ?? Carbon::parse($fromDate)->addDay()->format('Y-m-d H:i:s');


    $settings = Setting::whereIn('field', ['rental', 'extra_hour', 'pickup_fee', 'return_fee', 'add-ons', 'discount'])
        ->pluck('value', 'field');

    $rental = (float) ($settings['rental'] ?? 0);
    $extra_hour = (float) ($request->extracharge ?? 0);
    $pickup_fee = (float) ($settings['pickup_fee'] ?? 0);
    $return_fee = (float) ($settings['return_fee'] ?? 0);
    $addons = (float) ($settings['add-ons'] ?? 0);
    $discountPercent = (float) ($settings['discount'] ?? 0);
    $productPrice = (float) ($product->selling_price ?? 0);
    $selectedAddons = json_decode($request->selected_addons, true) ?? [];
    $addonsTotal = array_sum(array_column($selectedAddons, 'total'));

    $discountAmount = ($productPrice * $discountPercent) / 100;

    $totalBeforeDiscount = $rental + $extra_hour + $pickup_fee + $return_fee + $productPrice + $addonsTotal;
    $total = max(0, $totalBeforeDiscount - $discountAmount);

    $order = Order::create([
        'pro_id' => $product->id,
        'userid' => $userId,
        'buyer_name' => $validatedData['name'],
        'buyer_email' => $validatedData['email'],
        'buyer_phone_number' => $validatedData['country_code'] . $request->phone_number,
        'passport' => $request->user_passport,
        'license' => $request->user_license,
        'buyer_country_of_origin' => $validatedData['country'],
        'buyer_sec_name' => $request->invoice_name ?? null,
        'buyer_sec_phone_number' => $request->invoice_phone_number ?? null,
        'buyer_sec_invoice_address' => $request->invoice_address ?? null,
        'driver_name' => $request->driver_name ?? null,
        'driver_id_passport_number' => $request->driver_ic_number ?? null,
        'driver_license_number' => $request->driver_license_number ?? null,
        'driver_age' => $request->driver_age ?? null,
        'driver_mobile_number' => $request->driver_mobile_number ?? null,
        'note' => $request->note ?? null,
        'from_date' => $fromDate,
        'to_date' => $toDate,
        'status' => $request->status ?? 'pending',
        'payment_status' => $request->payment_status ?? 0,
        'amount' => $total,
        'selected_addons' => json_encode($selectedAddons),
    ]);

    return redirect()->route('checkout', [
        'order_id' => Crypt::encryptString($order->id),
    ])->with('success', 'Order placed successfully!');
}






}