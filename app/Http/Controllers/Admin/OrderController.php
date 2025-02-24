<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Collection;
use App\Models\Order;
use App\Models\ProductCollection;
use App\Models\Variation;
use App\Models\VariationAttribute;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Collator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Laravel\Ui\Presets\React;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request)
{
    if ($request->ajax()) {
        $query = Order::query();

        if ($request->id) {
            $query->where('id', $request->id);
        }
        if ($request->buyer_name) {
            $query->where('buyer_name', 'like', '%' . $request->buyer_name . '%');
        }
        if ($request->buyer_email) {
            $query->where('buyer_email', 'like', '%' . $request->buyer_email . '%');
        }
        if ($request->buyer_phone_number) {
            $query->where('buyer_phone_number', 'like', '%' . $request->buyer_phone_number . '%');
        }
        if ($request->from_date) {
            $query->whereDate('from_date', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('to_date', '<=', $request->to_date);
        }
        if ($request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $count = $query->count();
        $records = $query->skip($request->start)
            ->take($request->length)
            ->orderBy('id', 'desc')
            ->get();


        $data = [];
        foreach ($records as $key => $value) {
            $payment_status_label = $value->payment_status == 1
                ? '<span style="color: green; font-weight: bold;">Paid</span>'
                : '<span style="color: red; font-weight: bold;">Unpaid</span>';

            $data[] = [
                'id' => '<a href="'.URL::to('admin/orders/edit/'.Crypt::encryptString($value->id)).'">#'.$value->id.'</a>', // ID (Action)
                'buyer_name' => $value->buyer_name,
                'buyer_email' => $value->buyer_email,
                'buyer_phone_number' => $value->buyer_phone_number,
                'to_date' => date('d-m-Y h:i A', strtotime($value->to_date)),   // Format To Date
                'from_date' => date('d-m-Y h:i A', strtotime($value->from_date)), // Format From Date
                'payment_status' => $payment_status_label,
                'amount' => 'RM ' . $value->amount,
                'status' => $value->status,
            ];
        }




        return response()->json([
            "draw" => $request->draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            'data' => $data,
        ]);
    }

    $category = Category::all();
    return view('admin.orders.index', compact('category'));
}


     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function edit(Request $request,$id)
    {

        $id = Crypt::decryptString($id);
        $data = Order::find($id);
        if($data == false){
            return back()->with('error','Record Not Found');
         }

        return view('admin.orders.edit',compact('data'));
    }



     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update(Request $request, $id)
{

    $id = Crypt::decryptString($id);

    $order = Order::find($id);

    if (!$order) {
        return redirect()->back()->with('error', 'Order not found.');
    }





    $status = $request->input('status') === 'approve' ? 'approved' : $request->input('status');

    $order->update(array_merge($request->only([
        'buyer_name',
        'buyer_email',
        'passport',
        'license',
        'buyer_phone_number',
        'buyer_country_of_origin',
        'buyer_sec_name',
        'buyer_sec_phone_number',
        'driver_name',
        'driver_license_number',
        'from_date',
        'to_date',
        'payment_status',
        'amount',
        'flight_no'
    ]), ['status' => $status]));

    return back()->with('warning', 'Order updated successfully.');
}


public function updatePickupDeliver(Request $request, $id)
{
    $id = Crypt::decryptString($id);
    $order = Order::find($id);

    if (!$order) {
        return response()->json(['error' => 'Order not found.'], 404);
    }

    $field = $request->input('field');
    $value = $request->input('value');

    if (!in_array($field, ['pickup_car_date', 'deliver_car_date'])) {
        return response()->json(['error' => 'Invalid field.'], 400);
    }

    $order->$field = Carbon::now(); // Save Current Date & Time
    $order->save();

    return response()->json(['success' => true]);
}



public function getTotalTime($id)
{
    $id = Crypt::decryptString($id);
    $order = Order::find($id);

    if (!$order || !$order->pickup_car_date || !$order->deliver_car_date) {
        return response()->json(['total_time' => 'Not Available']);
    }

    $pickupDate = Carbon::parse($order->pickup_car_date);
    $deliverDate = Carbon::parse($order->deliver_car_date);

    $diffInDays = $pickupDate->diffInDays($deliverDate);
    $diffInHours = $pickupDate->diffInHours($deliverDate) % 24;

    return response()->json(['total_time' => "$diffInDays days, $diffInHours hours"]);
}



    public function delete($id)
    {
        $product = Product::find(Crypt::decryptString($id));

        if($product == false){
            return back()->with('warning','Record Not Found');
        }else{
            ProductCollection::where('product_id',$product->id)->delete();
            $product->delete();
            return redirect('/admin/products/index')->with('success','Record Deleted Success');
        }

    }

    public function sendExtraPaymentEmail($id)
    {
        // Order find karein
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found!'], 404);
        }

        // Dates ko Carbon object mein convert karein
        $fromDate = Carbon::parse($order->from_date);
        $toDate = Carbon::parse($order->to_date);
        $pickupDate = $order->pickup_car_date ? Carbon::parse($order->pickup_car_date) : null;
        $deliverDate = $order->deliver_car_date ? Carbon::parse($order->deliver_car_date) : null;

        // Day aur Hours ka Difference nikalein
        $bookingDurationHours = $fromDate->diffInHours($toDate);
        $pickupDelayHours = $pickupDate ? $fromDate->diffInHours($pickupDate) : 0;
        $deliverDelayHours = $deliverDate ? $toDate->diffInHours($deliverDate) : 0;

        // Delay jitna bhi ho, uska penalty calculate karein
        $totalAmount = (float) $order->amount;
        $totalPenalty = 0;

        $totalDelayHours = $pickupDelayHours + $deliverDelayHours;

        if ($totalDelayHours > 0) {
            // 1 hour = 10% penalty
            $penaltyPercentage = min($totalDelayHours * 10, 100); // Max penalty 100%
            $totalPenalty = ($totalAmount * $penaltyPercentage) / 100;
        }

        // Email send karein
        $email = $order->buyer_email; // Buyer ka email lein

        // Mail::raw("Dear {$order->buyer_name},\n\nYour rental return was delayed by {$totalDelayHours} hours. A penalty of {$penaltyPercentage}% has been applied.\nTotal Penalty Amount: $totalPenalty\n\nThank you!", function ($message) use ($email) {
        //     $message->to($email)
        //         ->subject('Extra Payment Notification');
        // });

        // Extra amount update karein
        $order->extra_amount = $totalPenalty;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Email sent successfully!', 'penalty' => $totalPenalty]);
    }







}
