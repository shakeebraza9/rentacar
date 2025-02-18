<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Laravel\Ui\Presets\React;
use Illuminate\Contracts\Encryption\DecryptException;
class CategoryController extends Controller
{

    public function index(Request $request)
    {

        if($request->ajax()){

            $query = Category::Query();

            //Search
            $search = $request->get('search')['value'];
            if($search != ""){
               $query = $query->where(function ($s) use($search) {
                   $s->where('product_categories.title','like','%'.$search.'%')
                   ->orwhere('product_categories.slug','like','%'.$search.'%');
               });
            }


            $count = $query->get();

            $records = $query->skip($request->start)
            ->take($request->length)
            ->get();

            $data = [];

            foreach ($records as $key => $value) {

                $is_enable = $value->is_enable ? 'checked' : '';
                $is_featured = $value->is_featured ? 'checked' : '';

                if($value->parent_id != 0){
                  $category = Category::where('id',$value->parent_id)->first();
                  if($category){
                    $category = $category->title;
                  }else{
                    $category = "None";
                  }
                }else{
                    $category = "None";
                }

                $action = '<div class="btn-group" role="group" aria-label="Category Actions">';

                // $action .= '<a class="btn btn-info me-2" href="'.URL::to('admin/categories/edit/'.Crypt::encryptString($value->id)).'">Edit</a>';
                $action .= '<a class="btn btn-primary me-2" href="'.URL::to('admin/categories/subcategories/'.Crypt::encryptString($value->id)).'">Add Subcategories</a>';
                // $action .= '<a class="btn btn-danger" href="'.URL::to('admin/categories/delete/'.Crypt::encryptString($value->id)).'">Delete</a>';

                $action .= '</div>';

                // $img = $value->image ? asset('public/'.$value->image->path) : '';
                $img = $value->image ? asset($value->image->path) : '';

                array_push($data,[
                    $value->id,
                   "<img style='width:50px;' src='".$img."' />",
                    $value->title,
                    $value->slug,
                    $category,
                    '<div class="switchery-demo m-b-30">
                    <input data-id="'.Crypt::encryptString($value->id).'" '.$is_enable.' type="checkbox"  class="is_enable js-switch" data-color="#009efb"/></div>',
                    '<div class="switchery-demo m-b-30">
                    <input data-id="'.Crypt::encryptString($value->id).'" '.$is_featured.' type="checkbox"  class="is_featured js-switch" data-color="#009efb"/></div>',
                    $action,
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

        return view('admin.categories.index');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function sort(Request $request)
    {

        if($request->ajax()){



            if($request->has('data')){
                foreach ($request->data as $key => $category) {

                    Category::where('id',$category['id'])->update([
                        "sort" => $key,
                        "parent_id" => null,
                    ]);


                    if(isset($category['children'])){
                        foreach ($category['children'] as $subkey => $subCategory) {
                            Category::where('id',$subCategory['id'])->update([
                                "sort" => $subkey,
                                "parent_id" => $category['id'],
                            ]);

                            if(isset($subCategory['children'])){
                                foreach ($subCategory['children'] as $childkey => $childCategory) {
                                    Category::where('id',$childCategory['id'])->update([
                                        "sort" => $childkey,
                                        "parent_id" => $subCategory['id'],
                                    ]);

                                }
                            }

                        }

                    }

                }

            }

            return response()->json($request->all());
        }

        $categories = Category::
        where('parent_id',null)
        ->orderby('sort')
        ->get();

        return view('admin.categories.sort',compact('categories'));
    }



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function create()
    {
        $categories = Category::where('parent_id',null)->orderby('sort')->get();
        return view('admin.categories.create',compact('categories'));
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(),[
            "title" => 'required|max:255',
            'slug' => [
              'required',
              'max:255',
              Rule::unique('categories'),
            ],
            "parent_id" => 'max:255',
            "details" => 'max:500',
            'meta_title' => 'max:255',
            'meta_description' => 'max:255',
            'meta_keywords' => 'max:255',
        ]);

        if($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $level = 1;
        $parent_id = null;

        if($request->parent_id == null && $request->parent_id == ''){
            $level = 1;
            $parent_id = null;
        }else{
            $explode =  explode('-',$request->parent_id);
            $level = $explode[1];
            $parent_id = $explode[0];
        }

        $ProductCategory = Category::create([
            'title' => $request->title,
            "slug" => $request->slug,
            "image_id" => $request->image,
            "sort" => $request->sort,
            "level" => $level,
            "parent_id" => $parent_id,
            "details" => $request->details,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect('/admin/categories/index')->with('success','Record Created Success');

    }



     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function edit(Request $request,$id)
    {

        $id = Crypt::decryptString($id);
        $model = Category::find($id);
        if($model == false){
            return back()->with('error','Record Not Found');
         }

        //  dd($id);

         $categories = Category::where('parent_id',null)
         ->orderby('sort')
         ->get();

        return view('admin.categories.edit',compact('categories','model'));
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
            'slug' => [
                'required',
                'max:255',
                Rule::unique('categories')->ignore($id),
            ],
            "details" => 'max:500',
            "description" => 'max:9000',
            "image_id" => 'required',
            'meta_title' => 'max:255',
            'meta_description' => 'max:255',
            'meta_keywords' => 'max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $category = Category::find($id);
        if($category == false){
           return back()->with('error','Record Not Found');
        }


        $category->title = $request->title;
        $category->slug = $request->slug;
        $category->details = $request->details;
        $category->image_id = $request->image_id;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords = $request->meta_keywords;
        $category->save();


        return back()->with('success','Record Updated');

    }


     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function delete($id)
    {
        $data = Category::find(Crypt::decryptString($id));
        if($data == false){
            return back()->with('warning','Record Not Found');
        }else{

            $category = Category::where('parent_id',$data->id)->get();
            if(count($category) > 0){
                return back()->with('warning','This Category Used As Parent Category');
            }

            $product = Product::where('category_id',$data->id)->get();
            if(count($product) > 0){
                return back()->with('warning','This Category Used In Products');
            }


            $data->delete();
            return redirect('/admin/categories/index')->with('success','Record Deleted Success');
        }

    }




    public function showSubcategories($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);


            $category = Category::findOrFail($id);


            $subcategories = Subcategory::where('category_id', $category->id)->get();


            return view('admin.categories.subcat', compact('category', 'subcategories'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }


    public function storesubcat(Request $request)
    {
        // Validation with optional fields
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'cateid' => 'required|string|max:255',
            'image' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'details' => 'nullable|string',
        ]);


        $subcategory = new Subcategory();
        $subcategory->title = $request->title;
        $subcategory->slug = $request->slug;
        $subcategory->category_id = $request->cateid;
        $subcategory->image_id = $request->image;
        $subcategory->meta_title = $request->meta_title;
        $subcategory->meta_description = $request->meta_description;
        $subcategory->meta_keywords = $request->meta_keywords;
        $subcategory->details = $request->details;
        $subcategory->save();

        // Redirect or return response
        return redirect()->route('categories.index');
    }



    public function editSubcategories($id)
    {
        try {
            $ids = Crypt::decryptString($id); // Decrypt the ID safely
            $subcategory = Subcategory::findOrFail($ids);
            $categories = Category::all();

            return view('admin.categories.subedit', compact('subcategory', 'categories'));
        } catch (DecryptException $e) {
            return back()->with('error', 'Invalid or expired link.');
        }
    }



    public function updateSubcategory(Request $request, $id)
    {
        try {
            $ids = Crypt::decryptString($id);
            $subcategory = Subcategory::findOrFail($ids);

            // Form validation
            $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:subcategories,slug,' . $id,
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
                'details' => 'nullable|string',
            ]);

            // Update subcategory fields
            $subcategory->title = $request->title;
            $subcategory->slug = $request->slug;
            $subcategory->meta_title = $request->meta_title;
            $subcategory->meta_description = $request->meta_description;
            $subcategory->meta_keywords = $request->meta_keywords;
            $subcategory->details = $request->details;

            // Save to database
            $subcategory->save();

            return redirect()->back()->with('success', 'Subcategory updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function destroySubcategory($id)
    {
 
            // ID ko decrypt karo
            $decryptedId = Crypt::decryptString($id);

            // Subcategory find karo
            $subcategory = Subcategory::findOrFail($decryptedId);

            // Delete the record
            $subcategory->delete();

            return redirect()->back()->with('success', 'Subcategory deleted successfully!');
      
    }
}