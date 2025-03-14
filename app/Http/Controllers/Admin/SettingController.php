<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\StoreCategory;
use App\Models\Filemanager;
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
        $fileManager=Filemanager::all();


        return view('admin.settings.edit',compact('data','group','fileManager'));
    }



     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            if (isset($value['value'])) {
                // Allowed field types
                $allowedTypes = ['text', 'textarea', 'keywords', 'image', 'date', 'time', 'enable','code'];

                if (in_array($value['type'], $allowedTypes)) {
                    $updatedValue = $value['value'];

                    // Convert time fields to 12-hour format with AM/PM
                    if ($value['type'] == 'time') {
                        $updatedValue = date("h:i A", strtotime($value['value'])); // Converts "13:00" to "01:00 PM"
                    }

                    Setting::where('field', $key)->update(["value" => $updatedValue]);
                }
            }
        }

        return back()->with('success', 'Settings Updated Successfully!');
    }



}