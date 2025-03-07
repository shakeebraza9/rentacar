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
use PDF;

use App\Mail\OrderConfirmationMail;


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



    public function downloadInvoice($id)
    {
        $order = OrderTicket::find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        $ticket = Ticket::find($order->ticket_id);
        $attraction = $ticket ? Attraction::find($ticket->attraction_id) : null;

        $addons = json_decode($order->addons, true);
        $totalAddons = collect($addons)->sum(function ($addon) {
            return $addon['price'] * $addon['quantity'];
        });

        $grandTotal = ($order->adult_quantity * $ticket->selling_price) +
                      ($order->child_quantity * $ticket->discount_price) +
                      $totalAddons - getset('discount_value_Ticket');

        $pdf = PDF::loadView('admin.ticketorders.invoice', compact('order', 'ticket', 'attraction', 'addons', 'totalAddons', 'grandTotal'));

        return $pdf->download('invoice_' . $order->id . '.pdf');
    }


    public function sendConfirmation($id)
    {
        // Get Order Details
        $order = OrderTicket::findOrFail($id);
        $ticket = Ticket::findOrFail($order->ticket_id);
        $attraction = $ticket->attraction;
        $addons = json_decode($order->addons, true);

        // Send Confirmation Email
        Mail::to($order->email)->send(new OrderConfirmationMail($order, $ticket, $attraction, $addons));

        return back()->with('success', 'Confirmation email sent successfully!');
    }
    public function delete($id)
    {
        try {
            $order = OrderTicket::findOrFail($id);
            $order->delete();

            return response()->json(['status' => 'success', 'message' => 'Order deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete order.']);
        }
    }


}