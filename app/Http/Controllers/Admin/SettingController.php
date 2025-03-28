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
use Illuminate\Support\Facades\Artisan;

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
                $allowedTypes = ['text', 'textarea', 'keywords', 'image', 'date', 'time', 'enable', 'code'];

                // Allowed fields to update in .env
                $allowedEnvFields = [
                    'MAIL_MAILER', 'MAIL_HOST', 'MAIL_PORT', 'MAIL_USERNAME',
                    'MAIL_PASSWORD', 'MAIL_ENCRYPTION', 'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME',
                    'TOYYIBPAY_USER_ID', 'TOYYIBPAY_SECRET',
                    'PAYPAL_CLIENT_ID', 'PAYPAL_SECRET', 'PAYPAL_MODE', 'PAYPAL_CURRENCY',
                    'STRIPE_KEY', 'STRIPE_SECRET'
                ];

                if (in_array($value['type'], $allowedTypes) || in_array($key, $allowedEnvFields)) {
                    $updatedValue = $value['value'];

                    // Convert time fields to 12-hour format with AM/PM
                    if ($value['type'] == 'time') {
                        $updatedValue = date("h:i A", strtotime($value['value']));
                    }

                    Setting::where('field', $key)->update(["value" => $updatedValue]);

                    // Update .env file for allowed fields
                    if (in_array($key, $allowedEnvFields)) {
                        $this->updateEnv($key, $updatedValue);
                    }
                }
            }
        }

        return back()->with('success', 'Settings Updated Successfully!');
    }


    /**
     * Update .env file dynamically
     */
    private function updateEnv($key, $value)
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        // Password یا Secret فیلڈز کے لیے quotes لگانا ضروری ہے
        $secureKeys = ['MAIL_PASSWORD', 'TOYYIBPAY_SECRET', 'PAYPAL_SECRET', 'STRIPE_SECRET'];
        if (in_array($key, $secureKeys)) {
            $value = '"' . addslashes($value) . '"';
        }

        // Check if key exists in .env
        if (preg_match("/^$key=/m", $envContent)) {
            // Key exists, update it
            $envContent = preg_replace("/^$key=.*/m", "$key=$value", $envContent);
        } else {
            // Key does not exist, add it at the end
            $envContent .= "\n$key=$value";
        }

        file_put_contents($envPath, $envContent);
    }




}
