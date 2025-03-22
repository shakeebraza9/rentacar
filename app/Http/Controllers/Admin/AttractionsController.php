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
class AttractionsController extends Controller
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
     */public function index(Request $request)
{
    $categoryDropdown = Category::get_category_dropdown();

    if ($request->ajax()) {
        $query = Attraction::query();

        // Filters
        if ($request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->slug) {
            $query->where('slug', 'like', '%' . $request->slug . '%');
        }

        if ($request->selling_price) {
            $query->where('selling_price', $request->selling_price);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Fetch total and filtered records
        $totalRecords = $query->count();
        $filteredRecords = $query->count();

        $records = $query->skip($request->start)
            ->take($request->length)
            ->orderBy('id', 'desc')
            ->get();

        // Format data for DataTables
        $data = [];
        foreach ($records as $value) {
            $is_enable = $value->is_enable ? 'checked' : '';
            $is_featured = $value->is_featured ? 'checked' : '';

            $action = '<div class="btn-group">
                           <a class="btn btn-info" href="' . route('attractions.edit', Crypt::encryptString($value->id)) . '">Edit</a>
                           <a class="btn btn-danger" href="' . route('attractions.delete', Crypt::encryptString($value->id)) . '">Delete</a>
                       </div>';

            $thumbnail_path = $value->get_thumbnail ? asset('public/' . $value->get_thumbnail->path) : null;
            $thumbnail = $thumbnail_path
                ? '<img style="width:100px;height:50px" src="' . $thumbnail_path . '" />'
                : 'No Image';

            $status = '<div class="switchery-demo">
                           <input data-id="' . Crypt::encryptString($value->id) . '" ' . $is_enable . ' type="checkbox" class="is_enable js-switch" data-color="#009efb"/>
                       </div>';



            $data[] = [
                $action,
                $value->id,
                $thumbnail,
                $value->title,
                $value->slug,
                $value->selling_price,
                $status,

            ];
        }

        return response()->json([
            "draw" => $request->draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            'data' => $data,
        ]);
    }

    return view('admin.attraction.index', compact('categoryDropdown'));
}








    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function create()
    {


        return view('admin.attraction.create');
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title" => 'required|max:255',
            'slug' => [ 'required','max:255',Rule::unique('products'),
            ],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = Attraction::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'status' => 1,
        ]);

        return redirect('/admin/attraction/edit/'.Crypt::encryptString($product->id))->with('success','Record Created Success');
    }



     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function edit(Request $request,$id)
    {

        $id = Crypt::decryptString($id);
        $product = Attraction::find($id);
        if($product == false){
            return back()->with('error','Record Not Found');
         }

         $filemanager = Filemanager::where('is_enable',1)->get();


        return view('admin.attraction.edit',compact('product','filemanager'));
    }

    function generateAttributeCombinations($attributes) {
        $result = [[]]; // Initialize with an empty combination

        foreach ($attributes as $attribute) {
            $currentResult = [];

            foreach ($result as $item) {
                foreach ($attribute['values'] as $value) {
                    $currentResult[] = array_merge($item, [ $value]);
                }
            }

            $result = $currentResult;
        }

        return $result;
    }


    public function removeGalleryImage(Request $request)
    {

        $productId = $request->input('product_id');
        $imageId = $request->input('image_id');

        $product = Attraction::find($productId);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }

        if (empty($product->gallery_id)) {
            return response()->json(['success' => false, 'message' => 'No gallery images found']);
        }

        $galleryArray = explode(',', $product->gallery_id);
        $updatedGallery = array_filter($galleryArray, function ($id) use ($imageId) {
            return trim($id) != trim($imageId);
        });

        $product->gallery_id = implode(',', $updatedGallery);
        $product->save();

        return response()->json(['success' => true]);
    }




     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decryptString($id);

        $validator = Validator::make($request->all(), [
            "title" => 'required|max:255',
            "description" => 'nullable|max:9000',
            "slug" => [
                'required',
                'max:255',
                Rule::unique('attractions', 'slug')->ignore($id),
            ],

        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Find the product
        $product = Attraction::find($id);
        if (!$product) {
            return back()->with('error', 'Record Not Found');
        }

        // Update product fields
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->selling_price = $request->selling_price;
        $product->discount_price = $request->price;

        // Update thumbnail
        if ($request->has('image')) {
            $product->image_id = $request->image;
        }

        // Update gallery images
        if ($request->has('gallery')) {
            $product->gallery_id = implode(',', $request->gallery); // Save as a comma-separated string
        }

        // Save the product
        $product->save();

        return back()->with('success', 'Record Updated Successfully');
    }



     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function delete($id)
    {
        $product = Attraction::find(Crypt::decryptString($id));

        if($product == false){
            return back()->with('warning','Record Not Found');
        }else{
            $product->delete();
            return redirect('/admin/attractions/index')->with('success','Record Deleted Success');
        }

    }



        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function remove_image(Request $request,$id)
    {
        $id = Crypt::decryptString($id);
        $product = Product::find($id);
        if($product == false){
           return back()->with('error','Record Not Found');
        }

         $images = explode(',',$product->images);
         $array_without_strawberries = array_diff($images, array($request->image));
         $product->images = implode(',',$array_without_strawberries);
         $product->save();
        return back()->with('success','Record Removed Success');

    }



    /**
     * Create a new controller instance.
     * @return void
     */
    public function variations(Request $request,$id)
    {

        $id = Crypt::decryptString($id);
        $product = Product::find($id);
        Variation::where('product_id',$id)->delete();
        $values = $product->generateAttributeCombinations($request->attr);

        foreach ($values as $values) {

            $sku = [];
            foreach ($values as $item) {
                array_push($sku,$item['title']);
            }

            $ProductVariation = Variation::create([
                "product_id"=> $id,
                "title" => implode('-',$sku),
                "sku" => implode('-',$sku),
                "value" => implode('-',$sku)
            ]);

            foreach ($values as $item) {
                VariationAttribute::create([
                    "variation_id" => $ProductVariation->id,
                    "attribute_id" => $item['attribute_id'],
                    "value_id" => $item['id'],
                    "value" => $item['title'],
                ]);
            }
        }

        return back()->with('success','Variation Generated Successfully');
    }


    /**
     * Create a new controller instance.
     * @return void
     */
    public function remove_variation(Request $request,$id)
    {
        Variation::where('id',$id)->delete();
        return back()->with('success','Remove Variation Successfully');
    }


}