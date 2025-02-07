<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Collection;
use App\Models\Order;
use App\Models\ProductCollection;
use App\Models\Variation;
use App\Models\VariationAttribute;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Collator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Laravel\Ui\Presets\React;

class ReportsController extends Controller
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
    public function clientIndex(Request $request)
    {

    
        if($request->ajax()){

            $query = Order::Query();
            if($request->name){
                $query->where('customer_name','like','%'.$request->name.'%');
            }
            if($request->email){
                $query->where('customer_email',$request->email);
            }
            if($request->phone){
                $query->where('customer_phone','like','%'.$request->phone.'%');
            }
            if($request->address){
                $query->where('address','like','%'.$request->address.'%');
            }
            if($request->orderNumber){
                $query->where('tracking_id',$request->orderNumber);
            }
            if($request->totalAmount ){
                $query->where('grand_total',$request->totalAmount);
            }
            if ($request->startDate && $request->endDate) {
                $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
            }
            
            // if ($request->paymentMethod) {
            //     $query->where('payment_method', 'like', '%' . $request->paymentMethod . '%');
            // }
            // // if($request->orderStatus){
            //     $query->where('order_status',$request->orderStatus);
            // }
            // if($request->paymentStatus){
            //     $query->where('payment_status',$request->paymentStatus);
            // }

            $query = $query->orderBy('id', 'desc');
            $count = $query->get();
            
            $records = $query->skip($request->start)
            ->take($request->length)
            ->get();
            
            $data = [];
            foreach ($records as $key => $value) {
                
                $track = '<a class="" target="_blank" href="'.URL::to('/order-confirmaton/'.$value->tracking_id).'">'.$value->tracking_id.'</a>';


                $action = '<a class="" href="'.URL::to('admin/orders/edit/'.Crypt::encryptString($value->id)).'">#'.$value->id.'</a>';

                array_push($data,[
                    $action,
                    $value->created_at->format('Y-m-d'),
                    $value->customer_name,
                    $value->customer_email,
                    $value->customer_phone,
                    $value->address,
                    // $track,  
                    // $action,
                    $value->order_status,
                    str_replace('_', ' ',$value->payment_method),
                    $value->payment_status,  
                    'PKR '.$value->grandtotal,                          
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
        
        $category = Category::all();    
        return view('admin.reports.clients.index',compact('category'));
    }

    
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function edit(Request $request,$id)
    {
        
        $id = Crypt::decryptString($id);
        $data = Order::find($id);
        if($data == false){  
            return back()->with('error','Record Not Found');
         }

        return view('admin.orders.edit',compact('data'));
    }



     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update(Request $request,$id)
    {

        // dd($request->all());

        
        // $id = Crypt::decryptString($id);

        $validator = Validator::make($request->all(), [
            "customer_name" => "required",
            "customer_phone" => "required",
            // "customer_email" => "required",
            "country" => "required",
            "city" => "required",
            // "address" => "required",
            "tracking_id" => "required",
            "order_status" => "required",
            "payment_method" => "required",
            "payment_status" => "required",
            // "order_notes" => "required",
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $model = Order::find($id);
        if($model == false){  
           return back()->with('error','Record Not Found');
        }

        $model->customer_name = $request->customer_name;
        $model->customer_phone = $request->customer_phone;
        $model->customer_email = $request->customer_email;
        $model->country = $request->country;
        $model->city = $request->city;
        $model->address = $request->address;
        $model->tracking_id = $request->tracking_id;
        $model->order_status = $request->order_status;
        $model->payment_method = $request->payment_method;
        $model->payment_status = $request->payment_status;
        $model->order_notes = $request->order_notes;
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
        $product = Product::find(Crypt::decryptString($id));

        if($product == false){
            return back()->with('warning','Record Not Found');
        }else{
            ProductCollection::where('product_id',$product->id)->delete();
            $product->delete();
            return redirect('/admin/products/index')->with('success','Record Deleted Success'); 
        }

    }

    



 

    
    
}
