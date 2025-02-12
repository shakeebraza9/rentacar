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
class ProductController extends Controller
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
     */
    public function index(Request $request)
    {

        $categoryDropdown = Category::get_category_dropdown();


        if($request->ajax()){

            $query = Product::Query();


            if($request->title){
                $query->where('title','like','%'.$request->title.'%');
            }

            if($request->slug){
                $query->where('slug','like','%'.$request->slug.'%');
            }

            if($request->price){
                $query->where('price',$request->price);
            }

            if($request->has('category_id') && $request->category_id != '' ){
                $query->where('category_id',$request->category_id);
            }

            if($request->has('is_enable') && $request->is_enable != ''){
                $query->where('is_enable',$request->is_enable);
            }

            if($request->has('is_featured') &&  $request->is_featured != ''){
                $query->where('is_featured',$request->is_featured);
            }



            $count = $query->get();

            $records = $query->skip($request->start)
            ->take($request->length)->orderBy('id','desc')
            ->get();

            $data = [];
            foreach ($records as $key => $value) {

                $is_enable = $value->is_enable ? 'checked' : '';
                $is_featured = $value->is_featured ? 'checked' : '';

                $action = '<div class="btn-group">';

                $action .= '<a class="btn btn-info" href="'.URL::to('admin/products/edit/'.Crypt::encryptString($value->id)).'">Edit</a>';
                $action .= '<a class="btn btn-danger" href="'.URL::to('admin/products/delete/'.Crypt::encryptString($value->id)).'">Delete</a>';

                $action .= '</div>';

                $thumb_path = $value->get_thumbnail ? 'public/'.$value->get_thumbnail->path : '';
                $img = '<img  style="width:100px;height:50px" src="'.asset($thumb_path).'" />';

                array_push($data,[
                    $action,
                    $value->id,

                    $value->get_category() ? $value->get_category()->title : '-',
                    $img,
                    $value->title,
                    $value->slug,
                    $value->price,

                    '<div class="switchery-demo m-b-30">
                    <input data-id="'.Crypt::encryptString($value->id).'" '.$is_enable.' type="checkbox"  class="is_enable js-switch" data-color="#009efb"/></div>',
                    '<div class="switchery-demo m-b-30">
                    <input data-id="'.Crypt::encryptString($value->id).'" '.$is_featured.' type="checkbox"  class="is_featured js-switch" data-color="#009efb"/></div>',

                 ]
                );

            }


            return response()->json([
                "draw" => $request->draw,
                "recordsTotal" => count($count),
                "recordsFiltered" => count($count),
                'data'=> $data,
            ]);
        }


        $categories = Category::all();


        return view('admin.products.index',compact('categories','categoryDropdown'));
    }




    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function create()
    {

        $categories = Category::all();

        return view('admin.products.create',compact('categories'));
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

        $product = Product::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'is_enable' => 0,
        ]);

        return redirect('/admin/products/edit/'.Crypt::encryptString($product->id))->with('success','Record Created Success');
    }



     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function edit(Request $request,$id)
    {

        $id = Crypt::decryptString($id);
        $product = Product::find($id);
        if($product == false){
            return back()->with('error','Record Not Found');
         }
         $categories = Category::all();
         $Subcategory = Subcategory::all();
         $location = Setting::whereIn('field', ['location'])
            ->pluck('value', 'field');

         $brands = Brand::all();
         $attributes = Attribute::with('values')->get();
         $collections = Collection::where('is_enable',1)->get();
         $product_details = DB::table('product_details')->where('proid', '=', $id)->get();
         //  dd($product->collection);
         $filemanager = Filemanager::where('is_enable',1)->get();


        return view('admin.products.edit',compact('product','categories','brands','location','attributes','collections','product_details','filemanager','Subcategory'));
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


     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update(Request $request,$id)
    {

        // dd($request->all());


        $id = Crypt::decryptString($id);
        $validator = Validator::make($request->all(), [
            "title" => 'required|max:255',
            "details" => 'max:500',
            "description" => 'max:9000',
            "category_id" => 'integer',
            'meta_title' => 'max:255',
            'meta_description' => 'max:255',
            'meta_keywords' => 'max:255',
            'slug' => [
                'required',
                'max:255',
                Rule::unique('products')->ignore($id),
            ],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::find($id);
        if($product == false){
           return back()->with('error','Record Not Found');
        }

        // dd($request->variation);

        if($request->has('variation')){
            foreach ($request->variation as $v) {
                Variation::where('id',$v['id'])->update([
                    "sku" => $v['sku'],
                    "quantity" => $v['quantity'],
                    "price" => $v['price'],
                    "image" => $v['thumbnail'],
                ]);
            }
        }

        ProductCollection::where('product_id',$product->id)->delete();
        if($request->has('collections')){
            foreach ($request->collections as $collect) {

                ProductCollection::create([
                    'product_id' =>    $product->id,
                    'collection_id' => $collect,
                ]);

            }
        }


        if($request->has('gallery')){
            $images = explode(',',$product->images);
            $new_images = $request->gallery;
            $merged_images = array_merge($images,$new_images);
            $product->images = implode(',',$merged_images);
        }
        if ($request->has('passenger_number')) {
            $productDetails['passenger_number'] = $request->input('passenger_number');
        }
        if ($request->has('baggage_number')) {
            $productDetails['baggage_number'] = $request->input('baggage_number');
        }
        if ($request->has('door_number')) {
            $productDetails['door_number'] = $request->input('door_number');
        }
        if ($request->has('aircond')) {
            $productDetails['aircond'] = $request->input('aircond');
        }
        if ($request->has('transmission')) {
            $productDetails['transmission'] = $request->input('transmission');
        }
        if ($request->has('oil_type')) {
            $productDetails['oil_type'] = $request->input('oil_type');
        }
        if ($request->has('oil_type')) {
            $productDetails['oil_type'] = $request->input('oil_type');
        }

        foreach ($productDetails as $key => $value) {
            DB::table('product_details')->updateOrInsert(
                [
                    'proid' => $id,
                    'key_title' => $key,
                ],
                [
                    'value' => $value,
                    'updated_at' => now(),
                ]
            );
        }
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->details = $request->details;
        $product->description = $request->description;

        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->sub_category;

        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keywords = $request->meta_keywords;

        $product->image = $request->image;
        $product->hover_image = $request->hover_image;

        $product->selling_price = $request->selling_price;
        $product->price = $request->price;

        $product->sku = $request->sku;
        $product->tags = $request->tags;
        $product->type = $request->car_type;
        $product->discount_text = $request->rms_text ?? NULL;
        $product->stock = $request->unit ?? 1;
        $product->type = $request->car_type;
        $product->dropoff_location = $request->dropoff_location;
        $product->pickup_location = $request->pickup_location;
        $product->save();

        return back()->with('success','Record Updated');

    }


     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function delete($id)
    {
        $product = Product::find(Crypt::decryptString($id));

        if($product == false){
            return back()->with('warning','Record Not Found');
        }else{
            ProductCollection::where('product_id',$product->id)->delete();
            $product->delete();
            return redirect('/admin/products/index')->with('success','Record Deleted Success');
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