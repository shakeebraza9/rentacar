<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
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

public function index($slug)
{
    // Fetch booking data using the slug (adjust query based on your database structure)
    $booking = Product::where('slug', $slug)->firstOrFail();

    // Pass the booking data to the view
    return view('theme.order', compact('booking'));
}



}