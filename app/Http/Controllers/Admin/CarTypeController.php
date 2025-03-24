<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarType;
use App\Models\PeakSeason;

use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\Slider;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Laravel\Ui\Presets\React;

class CarTypeController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CarType::query();

            // Search functionality
            $search = $request->get('search')['value'] ?? '';
            if (!empty($search)) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%');
            }

            // Get total records count before filtering
            $count = $query->count();

            // Apply pagination and sorting
            $records = $query->orderBy('id', 'desc')
                ->skip($request->start)
                ->take($request->length)
                ->get();

            $data = [];
            foreach ($records as $key => $value) {
                $action = '<div class="btn-group">
                    <a class="btn btn-sm btn-primary" href="' . URL::to('admin/cartype/edit/' . Crypt::encryptString($value->id)) . '">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <button class="btn btn-sm btn-danger delete-cartype" data-id="' . Crypt::encryptString($value->id) . '">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>';

                $data[] = [
                    'id' => $value->id,
                    'title' => $value->title,
                    'slug' => $value->slug,
                    'amount' => 'RM ' . number_format($value->amount, 2),
                    'action' => $action,
                ];
            }

            return response()->json([
                "draw" => $request->draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $data,
            ]);
        }

        return view('admin.cartype.index');
    }
    public function create()
{
    return view('admin.cartype.create');
}



public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|unique:car_type,slug|max:255',
        'amount' => 'required|numeric|min:0',
    ]);

    CarType::create([
        'title' => $request->title,
        'slug' => Str::slug($request->slug),
        'amount' => $request->amount,
    ]);

    return redirect()->route('admin.cartype.index')->with('success', 'Car Type created successfully.');
}



public function edit($id)
{
    $carType = CarType::findOrFail(Crypt::decryptString($id));

    return view('admin.cartype.edit', compact('carType'));
}

public function update(Request $request, $id)
{
    $carType = CarType::findOrFail(Crypt::decryptString($id));

    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:car_type,slug,' . $carType->id,
        'amount' => 'required|numeric|min:0',
    ]);

    $carType->update([
        'title' => $request->title,
        'slug' => Str::slug($request->slug),
        'amount' => $request->amount,
    ]);

    return redirect()->route('admin.cartype.index')->with('success', 'Car Type updated successfully.');
}


public function destroy($id)
{
    try {
        $cartypeId = Crypt::decryptString($id);
        $cartype = CarType::findOrFail($cartypeId);
        $cartype->delete();

        return response()->json(['message' => 'Car Type deleted successfully.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Car Type deletion failed.'], 500);
    }
}


public function peakseason()
{

    $cartypes = CarType::all();
    $seasons = PeakSeason::all();

    return view('admin.cartype.peakseason', compact('cartypes', 'seasons'));
}

public function getCarTypes()
{
    $cartypes = CarType::all();  // Fetch car types from database
    return response()->json(['cartypes' => $cartypes]);
}

public function peakseasonstore(Request $request)
{
    $request->validate([
        'seasons' => 'required|array',
        'seasons.*.season_name' => 'required|string|max:255',
        'seasons.*.season_start_date' => 'required|date',
        'seasons.*.season_end_date' => 'required|date',
        'seasons.*.prices' => 'required|array',
        'seasons.*.prices.*.price' => 'required|numeric|min:0',
    ]);

    foreach ($request->seasons as $season) {
        $seasonData = [
            'title' => $season['season_name'],
            'value' => json_encode($season['prices']),
            'start_date' => $season['season_start_date'],
            'end_date' => $season['season_end_date'],
            'enable' => 1,
        ];

        PeakSeason::create($seasonData);
    }

    // Return a JSON response indicating success
    return response()->json([
        'success' => true,
        'message' => 'Peak Season created successfully.',
    ]);
}


public function peakseasonupdatestatus(Request $request)
{
    $season = PeakSeason::findOrFail($request->id);
    $season->enable = $request->enable;
    $season->save();

    return response()->json(['success' => true]);
}

public function deleteSeason(Request $request)
{
    $season = PeakSeason::find($request->id);

    if ($season) {
        $season->delete();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Season not found']);
}


public function peakseasonedit($id)
{

    $season = PeakSeason::findOrFail($id);
    $carTypesWithPrices = json_decode($season->value, true);
    return view('admin.cartype.editpeakseason', compact('season', 'carTypesWithPrices'));
}



public function updateSeason(Request $request, $id)
{
    // Validate incoming data
    $request->validate([
        'peak_season_name' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'prices' => 'required|array',  // Ensure that prices is an array
        'prices.*' => 'required|numeric|min:0',  // Ensure that each price is numeric and greater than or equal to 0
    ]);

    // Find the season by ID
    $season = PeakSeason::findOrFail($id);

    // Prepare the updated data for the season
    $season->title = $request->peak_season_name;
    $season->start_date = $request->start_date;
    $season->end_date = $request->end_date;

    // Decode the current value field (JSON) to update the prices
    $currentValues = json_decode($season->value, true) ?? [];

    // Convert current values to an associative array for easy updating
    $pricesArray = [];
    foreach ($currentValues as $priceData) {
        $pricesArray[$priceData['car_type_slug']] = $priceData;
    }

    // Loop through submitted prices and update/add them
    foreach ($request->prices as $slug => $price) {
        if (isset($pricesArray[$slug])) {
            // Update existing slug price
            $pricesArray[$slug]['price'] = $price;
        } else {
            // Add new slug price
            $pricesArray[$slug] = [
                'car_type_slug' => $slug,
                'car_type_title' => ucfirst(str_replace('-', ' ', $slug)), // Auto generate title
                'price' => $price,
            ];
        }
    }

    // Save the updated JSON back into the value field
    $season->value = json_encode(array_values($pricesArray)); // Re-index the array
    $season->save();

    return redirect()->route('admin.peakseason.create')->with('success', 'Peak Season updated successfully.');
}



}