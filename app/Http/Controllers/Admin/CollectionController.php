<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\Slider;
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

class CollectionController extends Controller
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
     * @return void
     */
    public function index(Request $request)
    {

        if($request->ajax()){

            $query = Collection::Query();
            //Search
            $search = $request->get('search')['value'];
            if($search != ""){
               $query = $query->where(function ($s) use($search) {
                   $s->where('collections.title','like','%'.$search.'%')
                   ->orwhere('collections.description','like','%'.$search.'%');
               });
            }

            $count = $query->get();

            $records = $query->skip($request->start)
            ->take($request->length)->orderBy('id','desc')
            ->get();
            
            $data = [];
            foreach ($records as $key => $value) {

                $action = '<div class="btn-group">';
                $action .= '<a class="btn btn-info" href="'.URL::to('admin/collections/edit/'.Crypt::encryptString($value->id)).'">Edit</a>';
                $action .= '<a class="btn btn-danger" href="'.URL::to('admin/collections/delete/'.Crypt::encryptString($value->id)).'">Delete</a>';

                $action .= '</div>';
                $img = $value->image ? asset('public/'.$value->image->path) : '';

                array_push($data,[
                    $value->id,
                    "<img style='width:50px;' src='".$img."' />",
                    $value->title,
                    $value->is_enable ? 'Approved' : 'Pending',
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
              
        return view('admin.collections.index');
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.collections.create');
    }


    /**
     * Create a new controller instance.
     * @return void
     */
    public function store(Request $request)
    {

        // dd($request->all());

        $validator = Validator::make($request->all(),[
            "title" => 'required|max:255',
            'slug' => [ 'required','max:255',Rule::unique('collections')],
            "details" => 'max:500',
            "image_id" => 'integer|required',
            "sort" => 'integer|required',
            "is_enable" => 'integer|required',
            "is_featured" => 'integer|required',
            "meta_title" => 'max:255',
            "meta_description" => 'max:255',
            "meta_keywords" => 'max:255',
        ]);

        if($validator->fails()){
            return back()
            ->withErrors($validator)
            ->withInput();
        }
        
        Collection::create([
            'title' => $request->title,
            "slug" => $request->slug,
            "details" => $request->details,
            "image_id" => $request->image_id,
            "sort" => $request->sort,
            "is_enable" => $request->is_enable,
            "is_featured" => $request->is_featured,
            "meta_title" => $request->meta_title,
            "meta_description" => $request->meta_description,
            "meta_keywords" => $request->meta_keywords,
        ]);

        return redirect('/admin/collections/index')->with('success','Record Created Success'); 

    }

   

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function edit(Request $request,$id)
    {
        
        $id = Crypt::decryptString($id);
        $model = Collection::find($id);
        if($model == false){  
            return back()->with('error','Record Not Found');
         }

        return view('admin.collections.edit',compact('model'));

    }


     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update(Request $request,$id)
    {    

        $id = Crypt::decryptString($id);
        $validator = Validator::make($request->all(),[
            "title" => 'required|max:255',
            'slug' => [ 'required','max:255',Rule::unique('collections')->ignore($id)],
            "details" => 'max:500',
            "image_id" => 'integer|required',
            "sort" => 'integer|required',
            "is_enable" => 'integer|required',
            "is_featured" => 'integer|required',
            "meta_title" => 'max:255',
            "meta_description" => 'max:255',
            "meta_keywords" => 'max:255',
        ]);

        if($validator->fails()){
            return back()
            ->withErrors($validator)
            ->withInput();
        }

        $model = Collection::find($id);
        if($model == false){  
           return back()->with('error','Record Not Found');
        }

        $model->title  = $request->title;
        $model->slug  = $request->slug;
        $model->details =   $request->details;
        $model->image_id  = $request->image_id;
        $model->sort  = $request->sort;
        $model->is_enable  = $request->is_enable;
        $model->is_featured  = $request->is_featured;

        $model->meta_title = $request->meta_title;
        $model->meta_description = $request->meta_description;
        $model->meta_keywords = $request->meta_keywords;

        $model->save();

        return redirect('/admin/collections/index')->with('success','Record Updated');

    }


     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function delete($id)
    {

        $data = Collection::find(Crypt::decryptString($id));
        ProductCollection::where('collection_id',$data->id)->delete();
        
        if($data == false){
            return back()->with('warning','Record Not Found');
        }else{
            $data->delete();
            return redirect('/admin/collections/index')->with('success','Record Deleted Success'); 
        }

    }


    
}
