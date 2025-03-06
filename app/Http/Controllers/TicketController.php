<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Variation;
use Carbon\Carbon;
use App\Models\OrderTicket;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
class TicketController extends Controller
{
    public function checkAvailability(Request $request)
    {


        $ticketId = $request->ticket_id;
        $selectedDate = Carbon::parse($request->date);
        $adultQuantity = $request->adult_quantity;
        $childQuantity = $request->child_quantity;

        $ticket = Ticket::find($ticketId);
        if (!$ticket) {
            return response()->json(['status' => 'error', 'message' => 'Ticket not found.']);
        }
        if ($adultQuantity <= 0 && $childQuantity <= 0) {
            return response()->json(["status" => 'error', 'message' => 'Select at least one ticket.']);
        }


        $variations = Variation::where('ticket_id', $ticketId)
            ->where(function ($query) use ($selectedDate) {
                $query->whereRaw('GREATEST(from_date, to_date) >= ?', [$selectedDate])
                      ->whereRaw('LEAST(from_date, to_date) <= ?', [$selectedDate]);
            })
            ->orderBy('from_date', 'asc')
            ->get();

        if ($variations->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No tickets available for this date.']);
        }


        $adultVariation = $variations->where('type', 'adult')->first();
        $childVariation = $variations->where('type', 'child')->first();


        if ($adultVariation && $adultQuantity > $adultVariation->quantity) {
            return response()->json(['status' => 'error', 'message' => 'Not enough adult tickets available.']);
        }

        if ($childVariation && $childQuantity > $childVariation->quantity) {
            return response()->json(['status' => 'error', 'message' => 'Not enough child tickets available.']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tickets available!',
            'redirect_url' => route('book.ticket', [
                'ticket_id' => $ticketId,
                'date' => $selectedDate->format('Y-m-d'),
                'adult_quantity' => $adultQuantity,
                'child_quantity' => $childQuantity
            ])
        ]);
    }



    public function bookTicket(Request $request)
    {
        $ticketId = $request->query('ticket_id');
        $selectedDate = Carbon::parse($request->query('date'));
        $adultQuantity = (int) $request->query('adult_quantity');
        $childQuantity = (int) $request->query('child_quantity');

        $ticket = Ticket::find($ticketId);
        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket not found.');
        }

        if ($adultQuantity <= 0 && $childQuantity <= 0) {
            return redirect()->back()->with('error', 'Select at least one ticket.');
        }

        $variations = Variation::where('ticket_id', $ticketId)
            ->where(function ($query) use ($selectedDate) {
                $query->whereRaw('GREATEST(from_date, to_date) >= ?', [$selectedDate])
                      ->whereRaw('LEAST(from_date, to_date) <= ?', [$selectedDate]);
            })
            ->orderBy('from_date', 'asc')
            ->get();

        if ($variations->isEmpty()) {
            return redirect()->back()->with('error', 'No tickets available for this date.');
        }

        $adultVariation = $variations->where('type', 'adult')->first();
        $childVariation = $variations->where('type', 'child')->first();

        if ($adultVariation && $adultQuantity > $adultVariation->quantity) {
            return redirect()->back()->with('error', 'Not enough adult tickets available.');
        }

        if ($childVariation && $childQuantity > $childVariation->quantity) {
            return redirect()->back()->with('error', 'Not enough child tickets available.');
        }


        $adultTotal = $adultVariation ? $adultVariation->price * $adultQuantity : 0;
        $childTotal = $childVariation ? $childVariation->price * $childQuantity : 0;
        $grandTotal = $adultTotal + $childTotal;

        return view('theme.attractions.booking', [
            'ticket' => $ticket,
            'selectedDate' => $selectedDate->format('Y-m-d'),
            'adultQuantity' => $adultQuantity,
            'childQuantity' => $childQuantity,
            'adultPrice' => $adultVariation ? $adultVariation->price : null,
            'childPrice' => $childVariation ? $childVariation->price : null,
            'adultTotal' => $adultTotal,
            'childTotal' => $childTotal,
            'grandTotal' => $grandTotal
        ]);
    }

    public function placeOrder(Request $request)
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
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        // **Addons total calculate karo**
        $addonsTotal = 0;
        if (!empty($request->addons) && is_array($request->addons)) {
            foreach ($request->addons as $addon) {
                if (isset($addon['price'])) {
                    $addonsTotal += $addon['price'];
                }
            }
        }

        // **Final Amount = Ticket Total + Addons Total**
        $finalAmount = $request->total_amount + $addonsTotal;

        $order = OrderTicket::create([
            'ticket_id' => $request->ticket_id,
            'userid' => $userId,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->country_code . "-" . $request->phone_number,
            'country' => $request->country,
            'adult_quantity' => $request->adult_quantity,
            'child_quantity' => $request->child_quantity,
            'promo_code' => $request->promo_code,
            'amount' => $finalAmount, // **Final Amount Including Addons**
            'date' => Carbon::parse($request->ticket_date)->format('Y-m-d'),
            'addons' => json_encode($request->addons)
        ]);

        return response()->json(['status' => 'success', 'order_id' => Crypt::encryptString($order->id)]);
    }


        public function checkoutPage($order_id)
        {

            $order = OrderTicket::find(Crypt::decryptString($order_id));

            if (!$order) {
                return redirect()->route('home')->with('error', 'Order not found!');
            }
            return view('theme.attractions.checkout', compact('order'));
        }


}