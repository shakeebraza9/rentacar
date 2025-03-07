<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Collection;
use App\Models\OrderTicket;
use App\Models\ProductCollection;
use App\Models\Variation;
use App\Models\Ticket;
use App\Models\Attraction;
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


class TicketOrderController extends Controller
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
            $query = OrderTicket::query();

            if ($request->id) {
                $query->where('id', $request->id);
            }
            if ($request->buyer_name) {
                $query->where('name', 'like', '%' . $request->buyer_name . '%');
            }
            if ($request->buyer_email) {
                $query->where('email', 'like', '%' . $request->buyer_email . '%');
            }
            if ($request->buyer_phone_number) {
                $query->where('phone', 'like', '%' . $request->buyer_phone_number . '%');
            }
            if ($request->payment_status) {
                $query->where('payment_status', $request->payment_status);
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

                // Encrypt ID for security
                $encryptedId = Crypt::encryptString($value->id);

                // Edit Button
                $editBtn = '<a href="'.URL::to('admin/ticketorders/edit/'.$encryptedId).'" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>';

                // Delete Button
                $deleteBtn = '<button class="btn btn-sm btn-danger delete-order" data-id="'.$value->id.'">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>';

                $data[] = [
                    'id' => $editBtn . ' ' . $deleteBtn,
                    'buyer_name' => $value->name,
                    'buyer_email' => $value->email,
                    'buyer_phone_number' => $value->phone,
                    'Date' => date('d-m-Y', strtotime($value->date)),
                    'payment_status' => $payment_status_label,
                    'adult_quantity' => $value->adult_quantity,
                    'child_quantity' => $value->child_quantity,
                    'amount' => 'RM ' . $value->amount,
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
        return view('admin.ticketorders.index', compact('category'));
    }



     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function edit(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        $order = OrderTicket::find($id);

        if (!$order) {
            return back()->with('error', 'Record Not Found');
        }

        $ticket = Ticket::find($order->ticket_id);
        $attraction = $ticket ? Attraction::find($ticket->attraction_id) : null;

        return view('admin.ticketorders.edit', compact('order', 'ticket', 'attraction'));
    }



     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        // Decrypt ID if encrypted
        $orderId = Crypt::decryptString($id);

        // Find the order
        $order = OrderTicket::find($orderId);

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        // Validate Request Data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'payment_status' => 'required|integer|in:0,1',
        ]);

        // Update Order Details
        $order->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->back()->with('success', 'Order updated successfully.');
    }


public function updatePickupDeliver(Request $request, $id)
{
    $id = Crypt::decryptString($id);
    $order = OrderTicket::find($id);

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
    $order = OrderTicket::find($id);

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
    $order = OrderTicket::find($id);

    if (!$order) {
        return response()->json(['success' => false, 'message' => 'Order not found!'], 404);
    }

    $fromDate    = Carbon::parse($order->from_date);
    $toDate      = Carbon::parse($order->to_date);
    $pickupDate  = $order->pickup_car_date ? Carbon::parse($order->pickup_car_date) : $fromDate;
    $deliverDate = $order->deliver_car_date ? Carbon::parse($order->deliver_car_date) : null;

    if (!$deliverDate) {
        return response()->json(['success' => false, 'message' => 'Delivery date not provided!'], 400);
    }
    $bookedHours = $fromDate->diffInHours($toDate);
    $actualHours = $pickupDate->diffInHours($deliverDate);
    $delayHours = $actualHours - $bookedHours;

    $totalAmount = (float) $order->amount;
    $totalPenalty = 0;
    $penaltyPercentage = 0;

    if ($delayHours > 0) {
        $penaltyPercentage = 10;
        if ($delayHours > 1) {
            $penaltyPercentage += ($delayHours - 1) * 5;
        }
        $penaltyPercentage = min($penaltyPercentage, 100);
        $totalPenalty = ($totalAmount * $penaltyPercentage) / 100;
    }


    $email = $order->buyer_email;
    Mail::raw("Dear {$order->buyer_name},\n\nYour rental return was delayed by {$delayHours} hour(s). A penalty of {$penaltyPercentage}% has been applied.\nTotal Penalty Amount: $totalPenalty\n\nThank you!", function ($message) use ($email) {
        $message->to($email)
                ->subject('Extra Payment Notification');
    });

    // Update the order with the penalty amount.
    $order->extra_amount = $totalPenalty;
    $order->extra_amount_status = 1;
    $order->save();

    return response()->json(['success' => true, 'message' => 'Email sent successfully!', 'penalty' => $totalPenalty]);
}








}