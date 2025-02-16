<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Collection;
use App\Models\ProductCollection;
use App\Models\Variation;
use App\Models\Filemanager;
use App\Models\Ticket;
use App\Models\Attraction;
use App\Models\VariationAttribute;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Setting;
use Auth;
use Collator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Laravel\Ui\Presets\React;
use Illuminate\Support\Facades\DB;
class TicketController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        $query = Ticket::query()->with('attraction'); // Include related attraction

        // Filters
        if ($request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->description) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }

        if ($request->discount_price) {
            $query->where('discount_price', $request->discount_price);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Fetch total and filtered records
        $totalRecords = Ticket::count();
        $filteredRecords = $query->count();

        $records = $query->skip($request->start)
            ->take($request->length)
            ->orderBy('id', 'desc')
            ->get();

        // Format data for DataTables
        $data = [];
        foreach ($records as $value) {
            $is_enable = $value->status === 'active' ? 'checked' : '';

            $action = '<div class="btn-group">
                           <a class="btn btn-info" href="' . route('ticket.edit', Crypt::encryptString($value->id)) . '">Edit</a>
                           <a class="btn btn-danger delete-button" data-id="' . Crypt::encryptString( $value->id ). '">Delete</a>
                       </div>';



            $status = '<div class="switchery-demo">
                           <input data-id="' . Crypt::encryptString($value->id) . '" ' . $is_enable . ' type="checkbox" class="is_enable js-switch" data-color="#009efb"/>
                       </div>';

            $attraction = $value->attraction ? $value->attraction->title : 'N/A';

            $data[] = [
                'action' => $action,
                'id' => $value->id,
                'attraction' => $attraction,
                'title' => $value->title,
                'description' => $value->description,
                'discount_price' => $value->discount_price,
                'status' => $status,
            ];
        }

        return response()->json([
            "draw" => $request->draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            'data' => $data,
        ]);
    }

    return view('admin.ticket.index');
}


    public function create()
    {
        $attractions = Attraction::all(); // Fetch all attractions from the database
        return view('admin.ticket.create', compact('attractions'));
    }



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'attraction_id' => 'required|exists:attractions,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_price' => 'nullable|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'ticket_quantity' => 'required|integer|min:1',
        ]);

        // Insert the data into the tickets table
        Ticket::create([
            'attraction_id' => $request->input('attraction_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'discount_price' => $request->input('discount_price'),
            'selling_price' => $request->input('selling_price'),
            'ticket_quantity' => $request->input('ticket_quantity'),
            'status' => 'active', // Default status
        ]);

        // Redirect back with a success message
        return redirect()->route('ticket.index')->with('success', 'Ticket created successfully.');
    }




     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function edit($id)
    {
        try {
            // Decrypt the ID
            $ticketId = Crypt::decryptString($id);

            // Find the ticket
            $ticket = Ticket::findOrFail($ticketId);

            // Return the edit view with the ticket data
            return view('admin.ticket.edit', compact('ticket'));
        } catch (\Exception $e) {
            return redirect()->route('ticket.index')->with('error', 'Failed to load ticket for editing.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Decrypt the ID
            $ticketId = Crypt::decryptString($id);

            // Validate the request
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'discount_price' => 'nullable|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',
                'ticket_quantity' => 'required|integer|min:1',
                'status' => 'required|in:active,inactive',
            ]);

            // Find the ticket
            $ticket = Ticket::findOrFail($ticketId);

            // Update the ticket
            $ticket->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'discount_price' => $request->input('discount_price'),
                'selling_price' => $request->input('selling_price'),
                'ticket_quantity' => $request->input('ticket_quantity'),
                'status' => $request->input('status'),
            ]);

            return redirect()->route('ticket.index')->with('success', 'Ticket updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('ticket.index')->with('error', 'Failed to update the ticket.');
        }
    }

    public function delete($id)
{
    try {
        // Decrypt the ID
        $ticketId = Crypt::decryptString($id);

        // Find the ticket and delete it
        $ticket = Ticket::findOrFail($ticketId);
        $ticket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ticket deleted successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete the ticket. Please try again.'
        ], 500);
    }
}






}