<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductReview;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
class ReviewController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {

        $query = ProductReview::leftJoin('users', 'product_reviews.user_id', '=', 'users.id')
            ->leftJoin('products', 'product_reviews.product_id', '=', 'products.id')
            ->leftJoin('filemanager', 'products.image', '=', 'filemanager.id')
            ->select(
                'product_reviews.*',
                'users.name as user_name',
                'users.email as user_email',
                'products.title as product_name',
                'filemanager.path as image_path'
            );

        // Apply search filter
        $search = $request->get('search')['value'];
        if ($search != "") {
            $query->where(function ($s) use ($search) {
                $s->where('products.title', 'like', '%' . $search . '%')
                    ->orWhere('users.name', 'like', '%' . $search . '%')
                    ->orWhere('product_reviews.review', 'like', '%' . $search . '%');
            });
        }

        // Fetch total and filtered records
        $count = $query->count();
        $records = $query->skip($request->start)
            ->take($request->length)
            ->get();

        // Prepare data for DataTables
        $data = [];
        foreach ($records as $value) {
            // $action = '<div class="btn-group" role="group" aria-label="Actions">';
            // $action .= '<a class="btn btn-info me-2" href="' . URL::to('admin/reviews/edit/' . $value->id) . '">Edit</a>';
            // $action .= '<a class="btn btn-danger" href="' . URL::to('admin/reviews/delete/' . $value->id) . '">Delete</a>';
            // $action .= '</div>';

            $data[] = [
                $value->id,
                "<img style='width:50px;' src='" . asset($value->image_path) . "' />",
                $value->product_name,
                $value->user_name,
                $value->user_email,
                $value->review,
                '<div class="switchery-demo">
                    <input type="checkbox" data-id="' . Crypt::encryptString($value->id) . '" class="is_enable js-switch" ' . ($value->active ? 'checked' : '') . ' data-color="#009efb"/>
                </div>',
                // $action,
            ];
        }

        return response()->json([
            "draw" => $request->draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            'data' => $data,
        ]);
    }

    return view('admin.review.index');
}

public function show($encryptedProductId)
{
    try {
        $product_id = Crypt::decryptString($encryptedProductId);
        $product = Product::findOrFail($product_id);

        return view('theme.reviewsadd', compact('product'));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Invalid product ID');
    }
}

public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'product_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        // Store review in database
        ProductReview::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(), // Assuming the user is logged in
            'review' => $request->review,
            'star' => $request->rating,
            'title' => $request->title ?? null,
            'ip_address' => $request->ip(),
            'verified_purchase' => 1, // You can modify this logic
            'active' => 1, // Default as active
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }

}