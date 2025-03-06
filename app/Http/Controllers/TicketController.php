<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Variation;
use Carbon\Carbon;

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

    // Find the ticket
    $ticket = Ticket::find($ticketId);
    if (!$ticket) {
        return redirect()->back()->with('error', 'Ticket not found.');
    }

    // Check if at least one ticket is selected
    if ($adultQuantity <= 0 && $childQuantity <= 0) {
        return redirect()->back()->with('error', 'Select at least one ticket.');
    }

    // Find variations for the ticket within the date range
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

    // Get Adult & Child Variations
    $adultVariation = $variations->where('type', 'adult')->first();
    $childVariation = $variations->where('type', 'child')->first();

    // Check if there are enough adult tickets
    if ($adultVariation && $adultQuantity > $adultVariation->quantity) {
        return redirect()->back()->with('error', 'Not enough adult tickets available.');
    }

    // Check if there are enough child tickets
    if ($childVariation && $childQuantity > $childVariation->quantity) {
        return redirect()->back()->with('error', 'Not enough child tickets available.');
    }

    // Pass the data to the view
    return view('theme.attractions.booking', [
        'ticket' => $ticket,
        'selectedDate' => $selectedDate->format('Y-m-d'),
        'adultQuantity' => $adultQuantity,
        'childQuantity' => $childQuantity,
        'adultPrice' => $adultVariation ? $adultVariation->price : null,
        'childPrice' => $childVariation ? $childVariation->price : null
    ]);
}

}