<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
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

class MenuItemController extends Controller
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
    public function index(Request $request,$id)
    {

        $menu = Menu::find(Crypt::decryptString($id));
        if($menu == false){
            return back()->with('warning','Record Not Found');
        };

        $pageItems = MenuItem::where('menu_id',$menu->id)
        ->where('parent_id',NULL)
        ->orderBy('sort')
        ->get();

        $dropdowns = MenuItem::get_menu_drop_down($menu->id);

    
        return view('admin.menus.menu-items.index',compact('menu','pageItems','dropdowns')); 

    }

    


   /**
     * Create a new controller instance.
     * @return void
     */
    public function store(Request $request)
    {

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
        
        MenuItem::create([
            "menu_id" => $request->menu_id,
            "title" => $request->title,
            "subtitle" => $request->subtitle,
            "target" => $request->target,
            "link" => $request->link,
            "parent_id" => $parent_id,
            "level" => $level,
            "sort" => $request->sort,
        ]);

        return back()->with('success','Record Created Success');
    }


    /**
     * Create a new controller instance.
     * @return void
     */
    public function edit(Request $request,$id)
    {

        $id = Crypt::decryptString($id);
        $model = MenuItem::where('id',$id)->first();
        if($model == false){
            return back()->with('warning','Record Not Found');
        }

        // dd($model->menu);

        $dropdowns = MenuItem::get_menu_drop_down($model->menu_id,$model->parent_id,$id);
        return view('admin.menus.menu-items.edit',compact('model','dropdowns')); 

    }

     /**
     * Create a new controller instance.
     * @return void
     */
    public function sort(Request $request,$id)
    {

        $id = Crypt::decryptString($id);
        $model = Menu::where('id',$id)->first();
        if($model == false){
            return back()->with('warning','Record Not Found');
        }


        if($request->ajax()){

            if($request->has('data')){
                // dd($request->data);

                foreach ($request->data as $key => $category) {
                  
                    MenuItem::where('id',$category['id'])
                    ->where('menu_id',$id)
                    ->update([
                        "sort" => $key,
                        "parent_id" => null,
                        "level" => 1,
                    ]);
                    

                    if(isset($category['children'])){
                        foreach ($category['children'] as $subkey => $subCategory) {
                            MenuItem::where('id',$subCategory['id'])
                            ->where('menu_id',$id)
                            ->update([
                                "sort" => $subkey,
                                "parent_id" => $category['id'],
                                "level" => 2,
                            ]);

                            if(isset($subCategory['children'])){
                                foreach ($subCategory['children'] as $childkey => $childCategory) {
                                    MenuItem::where('id',$childCategory['id'])
                                    ->where('menu_id',$id)
                                    ->update([
                                        "sort" => $childkey,
                                        "parent_id" => $subCategory['id'],
                                        "level3" => 1,
                                    ]);

                                }
                            }

                        }

                    }

                }

            }

            return response()->json($request->all());
        }

     

        $data = MenuItem::where('menu_id',$id)->where('parent_id',NULL)->get();
        return view('admin.menus.menu-items.sort',compact('model','data')); 

    }


    

    /**
     * Create a new controller instance.
     * @return void
     */
    public function update(Request $request,$id)
    {

       $id = Crypt::decryptString($id); 
       $model = MenuItem::where('id',$id)->first();

       $model->update([
            "title" => $request->title,
            "subtitle" => $request->subtitle,
            "target" => $request->target,
            "link" => $request->link,
            // "parent_id" => $request->parent_id,
            "sort" => $request->sort,
            "level" => 1,
        ]);

    
        return redirect('/admin/menus_items/'.Crypt::encryptString($model->menu_id).'/index')
        ->with('success','Record Created Success'); 

      

    }



    /**
     * Create a new controller instance.
     * @return void
     */
    public function delete($id)
    {

        $data = MenuItem::find(Crypt::decryptString($id));
        if($data == false){
            return back()->with('warning','Record Not Found');
        }else{
            $data->delete();
            return back()->with('success','Record Deleted Success');
        }

    }

}
