<?php

namespace App\Http\Controllers;

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



    $isBooked = Order::where('pro_id', $product->id)
        ->where(function ($query) use ($today, $from) {
            $query->whereDate('from_date', '<=', $from)
                  ->whereDate('to_date', '>=', $today);
        })
        ->exists();

    $similarProducts = Product::where('subcategory_id', $product->subcategory_id)
        ->where('id', '!=', $product->id)
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

    return view('theme.bookingnew', compact('isBooked', 'product', 'availableProducts', 'similarProducts','numberOfRecords'));
}




public function index($slug)
{
    // Fetch booking data using the slug (adjust query based on your database structure)
    $booking = Product::where('slug', $slug)->firstOrFail();

    // Pass the booking data to the view
    return view('theme.order', compact('booking','slug'));
}

public function checkout(Request $request)
{
    try {
        if (!auth()->check()) {
            return redirect()->route('weblogin')->with('error', 'Please log in to proceed with checkout.');
        }
        // Validate incoming request
        $validatedData = $request->validate([
            'slug' => 'required|string|exists:products,slug',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country_code' => 'required|string|max:10',
            'country' => 'required|string|max:100',
            'user_passport' => 'nullable|string|max:100',
            'user_license' => 'nullable|string|max:100',
            'from_date' => 'nullable|date|after_or_equal:today',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);

        // Fetch product using slug
        $product = Product::where('slug', $validatedData['slug'])->firstOrFail();

        // Handle rental duration dates
        $fromDate = $validatedData['from_date'] ?? now()->toDateString();
        $toDate = $validatedData['to_date'] ?? \Carbon\Carbon::parse($fromDate)->addDay()->toDateString();

        // Fetch settings
        $settings = Setting::whereIn('field', ['rental', 'extra_hour', 'pickup_fee', 'return_fee', 'add-ons', 'discount'])
            ->pluck('value', 'field');

        $rental = (float) ($settings['rental'] ?? 0);
        $extra_hour = (float) ($settings['extra_hour'] ?? 0);
        $pickup_fee = (float) ($settings['pickup_fee'] ?? 0);
        $return_fee = (float) ($settings['return_fee'] ?? 0);
        $addons = (float) ($settings['add-ons'] ?? 0);
        $discount = (float) ($settings['discount'] ?? 0);
        $productPrice = (float) ($product->selling_price ?? 0);

        // Calculate total price
        $totalBeforeDiscount = $rental + $extra_hour + $pickup_fee + $return_fee + $addons + $productPrice;
        $total = max(0, $totalBeforeDiscount - $discount); // Ensure total doesn't go negative

        // Create the order
        $order = Order::create([
            'pro_id' => $product->id,
            'userid' => auth()->id(),
            'buyer_name' => $validatedData['name'],
            'buyer_email' => $validatedData['email'],
            'buyer_phone_number' => $validatedData['country_code'] . $request->phone_number,
            'passport' =>  $request->user_passport,
            'license' =>  $request->user_license,
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
        ]);

        return redirect()->route('checkout', [
            'order_id' => Crypt::encryptString($order->id),
        ])->with('success', 'Order placed successfully!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation errors
        return response()->json([
            'error' => 'Validation Error',
            'details' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        // Handle general errors
        return response()->json([
            'error' => 'An error occurred while processing your order.',
            'message' => $e->getMessage(),
        ], 500);
    }
}




}