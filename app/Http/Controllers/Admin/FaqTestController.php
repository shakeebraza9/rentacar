<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductReview;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Faq;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
class FaqTestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Faq::query(); // ✅ Query builder (better for filtering)

            // ✅ Search filtering
            if (!empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($s) use ($search) {
                    $s->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('type', 'like', '%' . $search . '%');
                });
            }

            $count = $query->count(); // ✅ Total count before pagination

            // ✅ Pagination
            $records = $query->offset($request->start)
                ->limit($request->length)
                ->get();

            // ✅ Data formatting
            $data = [];
            foreach ($records as $faq) {
                $action = '<div class="btn-group" role="group" aria-label="Actions">
                                <a class="btn btn-info me-2" href="' . URL::to('admin/faq/edit/' . $faq->id) . '">Edit</a>
                                <a class="btn btn-danger delete-btn" data-id="' . $faq->id . '" href="javascript:void(0)">Delete</a>
                            </div>';

                $data[] = [
                    $faq->id,
                    $faq->name,
                    $faq->description,
                    ucfirst($faq->type), // Capitalize first letter (car → Car)
                    $action
                ];
            }

            return response()->json([
                "draw" => intval($request->draw),
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                'data' => $data,
            ]);
        }

        return view('admin.faq.index');
    }


    public function create()
{
    return view('admin.faq.create');
}

public function store(Request $request)
{
    // Validate the input
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|in:car,attraction',
    ]);

    // If validation fails, return JSON response with errors
    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    // Store FAQ
    Faq::create([
        'name' => $request->name,
        'description' => $request->description,
        'type' => $request->type,
    ]);

    return response()->json([
        'success' => 'FAQ Created Successfully!'
    ]);
}


public function edit($id)
{
    $faq = Faq::findOrFail($id);
    return view('admin.faq.edit', compact('faq'));
}

public function update(Request $request, $id)
{
    // Validate the input
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|in:car,attraction',
    ]);

    // If validation fails, return JSON response with errors
    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    // Update FAQ
    $faq = Faq::findOrFail($id);
    $faq->update([
        'name' => $request->name,
        'description' => $request->description,
        'type' => $request->type,
    ]);

    return response()->json([
        'success' => 'FAQ Updated Successfully!'
    ]);
}
public function destroy($id)
{
    $faq = Faq::findOrFail($id);
    $faq->delete();

    return response()->json([
        'success' => 'FAQ deleted successfully!'
    ]);
}



}
