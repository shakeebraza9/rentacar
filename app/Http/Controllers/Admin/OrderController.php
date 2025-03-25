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

use mPDF;
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

                $deposit_status_label = $value->deposit_status == 1
                    ? '<span style="color: green; font-weight: bold;">Paid</span>'
                    : '<span style="color: red; font-weight: bold;">Unpaid</span>';

                $data[] = [
                    'id' => '
                        <a href="'.URL::to('admin/orders/edit/'.Crypt::encryptString($value->id)).'" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <button class="btn btn-sm btn-danger delete-order" data-id="'.Crypt::encryptString($value->id).'">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                   <button  class="btn btn-sm btn-info download-invoice" data-id="'.Crypt::encryptString($value->id).'">
                        <i class="bi bi-file-earmark-pdf"></i> Download Invoice
                    </button>

                    ', // ID (Action)
                    'buyer_name' => $value->buyer_name,
                    'buyer_email' => $value->buyer_email,
                    'buyer_phone_number' => $value->buyer_phone_number,
                    'to_date' => date('d-m-Y h:i A', strtotime($value->to_date)),   // Format To Date
                    'from_date' => date('d-m-Y h:i A', strtotime($value->from_date)), // Format From Date
                    'payment_status' => $payment_status_label,
                    'deposit_status' => $deposit_status_label,
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



    public function downloadInvoice($id)
    {
        $order = Order::findOrFail(Crypt::decryptString($id));
        $product = $order->product;


        $imagePath = public_path($product->get_thumbnail ? $product->get_thumbnail->path : '');
        $imageData = file_get_contents($imagePath);
        $base64Image = base64_encode($imageData);
        $imageSrc = 'data:image/jpeg;base64,' . $base64Image;


        $data = [
            'order' => $order,
            'product' => $product,
            'payment_status' => $order->payment_status == 1 ? 'Paid' : 'Unpaid',
            'deposit_status' => $order->deposit_status == 1 ? 'Paid' : 'Unpaid',
            'image' => $imageSrc,
        ];

        $html = view('admin.orders.invoice', $data)->render();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);

        return response()->stream(
            function () use ($mpdf) {
                $mpdf->Output();
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="invoice.pdf"',
            ]
        );
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
    $order = Order::find($id);

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


public function destroy($id)
{
    try {
        $orderId = Crypt::decryptString($id);
        $order = Order::findOrFail($orderId);
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Order deletion failed.'], 500);
    }
}






}