<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\StoreCategory;
use App\Models\Store;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;


class SettingController extends Controller
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
    public function edit(Request $request)
    {
        $group = $request->group;
        $data = Setting::where('grouping',$request->group)->orderBy('grouping')->get();
        $data = $data->groupBy('section');

        

        return view('admin.settings.edit',compact('data','group'));
    }



     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update(Request $request)
    {
        
        foreach ($request->all() as $key => $value) {
            if(isset($value['value'])){
                if(in_array($value['type'],['text','textarea','keywords','image'])){
                     Setting::where('field',$key)->update(["value" => $value['value']]);
                }       
            }
        }
        return back()->with('success','Record Updated');
        
    }
  
}