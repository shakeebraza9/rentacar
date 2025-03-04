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

        // Find ticket
        $ticket = Ticket::find($ticketId);
        if (!$ticket) {
            return response()->json(['status' => 'error', 'message' => 'Ticket not found.']);
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

        // Separate adult and child variations
        $adultVariation = $variations->where('type', 'adult')->first();
        $childVariation = $variations->where('type', 'child')->first();

        // Check if adult tickets are available
        if ($adultVariation && $adultQuantity > $adultVariation->quantity) {
            return response()->json(['status' => 'error', 'message' => 'Not enough adult tickets available.']);
        }

        // Check if child tickets are available
        if ($childVariation && $childQuantity > $childVariation->quantity) {
            return response()->json(['status' => 'error', 'message' => 'Not enough child tickets available.']);
        }

        return response()->json(['status' => 'success', 'message' => 'Tickets available!']);
    }
}