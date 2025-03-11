<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarType;

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

}
