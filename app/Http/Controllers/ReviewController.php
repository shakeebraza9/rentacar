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
                // Action Buttons (Edit & Delete)
                $editUrl = route('admin.review.edit', $value->id);


                $deleteUrl = URL::to('admin/reviews/delete/' . $value->id);

                $action = '<div class="btn-group" role="group" aria-label="Actions">';
                $action .= '<a class="btn btn-sm btn-info me-2" href="' . $editUrl . '"><i class="fas fa-edit"></i> Edit</a>';
                $action .= '<button class="btn btn-sm btn-danger delete-review" data-id="' . Crypt::encryptString($value->id) . '">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>';

                $action .= '</div>';

                $data[] = [
                    $action, // Added Edit & Delete buttons
                    $value->id,
                    "<img style='width:50px;' src='" . asset($value->image_path) . "' />",
                    $value->product_name,
                    $value->user_name,
                    $value->user_email,
                    $value->review,
                    '<div class="switchery-demo">
                        <input type="checkbox" data-id="' . Crypt::encryptString($value->id) . '" class="is_enable js-switch" ' . ($value->active ? 'checked' : '') . ' data-color="#009efb"/>
                    </div>',
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

    public function sort()
    {
        $data = ProductReview::orderBy('sort_order', 'ASC')->get();


        return view('admin.review.sort', compact('data'));
    }

    /**
     * Save sorted order.
     */
    public function Managesort(Request $request)
    {
        $reviews = $request->input('data');

        if (!$reviews || !is_array($reviews)) {
            return response()->json(['success' => false, 'message' => 'Invalid data format!'], 400);
        }

        // ✅ Loop through and update sort_order
        foreach ($reviews as $index => $review) {
            ProductReview::where('id', $review['id'])->update([
                'sort_order' => $index + 1,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Sorting updated successfully!']);
    }

    public function createadmin()
    {
        $products = Product::select('id', 'title')->get();
        $users = User::select('id', 'name')->get();

        return view('admin.review.create', compact('products', 'users'));
    }


        public function submit(Request $request)
        {
            // Validate Input
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'user_id' => 'required|exists:users,id',
                'title' => 'nullable|string|max:255',
                'star' => 'required|integer|min:1|max:5',
                'review' => 'required|string',
            ]);

            // Get last sort_order
            $lastSortOrder = ProductReview::max('sort_order');
            $newSortOrder = $lastSortOrder + 1;

            // Create Review
            $review = ProductReview::create([
                'product_id' => $request->product_id,
                'user_id' => $request->user_id,
                'title' => $request->title,
                'star' => $request->star,
                'review' => $request->review,
                'ip_address' => $request->ip(), // Store user IP
                'sort_order' => $newSortOrder, // Push to last
                'active' => 1, // Default active
                'verified_purchase' => 1, // Default false
            ]);

            // Redirect with Success Message
            return redirect()->back()->with('success', 'Review added successfully!');
        }


        public function edit($id)
    {
        $review = ProductReview::findOrFail($id);
        $products = Product::all();
        $users = User::all();

        return view('admin.review.edit', compact('review', 'products', 'users'));
    }

    // Update Review
    public function update(Request $request, $id)
    {
        // Validate Input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'nullable|string|max:255',
            'star' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        // Find Review & Update
        $review = ProductReview::findOrFail($id);
        $review->update([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'title' => $request->title,
            'star' => $request->star,
            'review' => $request->review,
        ]);

        return redirect()->route('admin.review.edit', $id)->with('success', 'Review updated successfully!');
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


    public function destroy($id)
{
    try {
        $reviewId = Crypt::decryptString($id);
        $review = ProductReview::findOrFail($reviewId);
        $review->delete();

        return response()->json(['success' => true, 'message' => 'Review deleted successfully!']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Failed to delete review.']);
    }
}

}