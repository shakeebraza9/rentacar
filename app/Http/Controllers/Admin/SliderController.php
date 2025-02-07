<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductVariation;
use App\Models\ProductVariationAttribute;
use App\Models\Role;
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

class SliderController extends Controller
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

            $query = Slider::Query();

            //Search
            $search = $request->get('search')['value'];
            if($search != ""){
               $query = $query->where(function ($s) use($search) {
                   $s->where('sliders.title','like','%'.$search.'%')
                   ->orwhere('sliders.description','like','%'.$search.'%');
               });
            }

            $count = $query->get();

            $records = $query->skip($request->start)
            ->take($request->length)->orderBy('id','desc')
            ->get();

            $data = [];
            foreach ($records as $key => $value) {

                $action = '<div class="btn-group">';
                $action .= '<a class="btn btn-info" href="'.URL::to('admin/sliders/edit/'.Crypt::encryptString($value->id)).'">Edit</a>';
                $action .= '<a class="btn btn-danger" href="'.URL::to('admin/sliders/delete/'.Crypt::encryptString($value->id)).'">Delete</a>';

                $action .= '</div>';
                $img = $value->image ? asset($value->image->path) : '';

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

        return view('admin.sliders.index');
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.sliders.create');
    }


    /**
     * Create a new controller instance.
     * @return void
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            "title" => 'required|max:255',
            "link" => 'max:255',
            "details" => 'max:500',
            "image_id" => 'integer|required',
            "sort" => 'integer|required',
            "is_enable" => 'integer|required',
            "alignment" => 'max:255|required',
            "button" => 'required|max:255',
        ]);


        if($validator->fails()){
            return back()
            ->withErrors($validator)
            ->withInput();
        }

        $product_category = Slider::create([
            'title' => $request->title,
            "details" => $request->details,
            "image_id" => $request->image_id,
            "sort" => $request->sort,
            "is_enable" => $request->is_enable,
            "alignment" => $request->alignment,
            "link" => $request->link,
            "button" => $request->button,
        ]);

        return redirect('/admin/sliders/index')->with('success','Record Created Success');

    }



     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function edit(Request $request,$id)
    {

        $id = Crypt::decryptString($id);
        $model = Slider::find($id);
        if($model == false){
            return back()->with('error','Record Not Found');
         }

        return view('admin.sliders.edit',compact('model'));

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
            "link" => 'max:255',
            "details" => 'max:500',
            "image_id" => 'integer|required',
            "sort" => 'integer|required',
            "is_enable" => 'integer|required',
            "alignment" => 'max:255|required',
            "button" => 'required|max:255',
        ]);

        if($validator->fails()){
            return back()
            ->withErrors($validator)
            ->withInput();
        }


        $model = Slider::find($id);
        if($model == false){
           return back()->with('error','Record Not Found');
        }

        $model->title  = $request->title;
        $model->link  = $request->link;
        $model->details =   $request->details;
        $model->image_id  = $request->image_id;
        $model->sort  = $request->sort;
        $model->is_enable  = $request->is_enable;
        $model->alignment = $request->alignment;
        $model->button = $request->button;
        $model->save();

        return back()->with('success','Record Updated');

    }


     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function delete($id)
    {
        $data = Slider::find(Crypt::decryptString($id));

        if($data == false){
            return back()->with('warning','Record Not Found');
        }else{

            $data->delete();
            return redirect('/admin/sliders/index')->with('success','Record Deleted Success');
        }

    }














}
