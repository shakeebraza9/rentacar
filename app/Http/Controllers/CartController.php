<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Cart;
use App\Models\Value;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Variation;
use App\Models\VariationAttribute;
use App\Models\Slider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;

class CartController extends Controller
{

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        

    }


      /**
     * Show the application dashboard.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cart()
    {

        $cart = session()->get('cart', []);

        if(count($cart) == 0){
            return redirect('/shop')->with('error','Cart Is Empty');
        }

     
        return view('theme.cart');
    }

     /**
     * Show the application dashboard.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function add_to_cart(Request $request)
    {

        $sku = $request->sku;
        $sku = Variation::where('id',$sku)->first();
        if(!$sku){
            return response()->json(["message" => "Sku Not Found Product"],400);
        }


        $action = $request->action;
        $quantity = $request->quantity ? intval($request->quantity) : 1;

        $cart = session()->get('cart', []);
            
        if(isset($cart[$sku->id])) {
        
                    $old_qty = $cart[$sku->id]['quantity'];
            
                    if($action == 'increament'){
                        $cart[$sku->id]['quantity'] = $old_qty + $quantity;
                    }elseif($action == 'decreament'){
                        $cart[$sku->id]['quantity'] = $old_qty - $quantity;
                    }else{
                        $cart[$sku->id]['quantity'] = $quantity;
                    }
                    
                    if($cart[$sku->id]['quantity'] <= 0){
                        unset($cart[$sku->id]);
                    }

        } else {

        
            $values = Value::whereIn('id',$request->attr)->get()->pluck('id')->toArray();
            if(count($values) == 0){
                return response()->json(["message" => "Attributes Not Found"],200);
            }
            $cart[$sku->id] = [
                "sku" => $sku->id,
                "quantity" => intval($quantity),
                "attributes" => $values,
            ];
           

        }


        session()->put('cart', $cart);

            return response()->json(["message" => "Product Added In Cart"],200);       
            
    }


    public function get_cart_details(Request $request){

        
        return response()->json(Cart::get_cart_details(),200);
    
    }


     /**
     * Show the application dashboard.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cart_remove(Request $request,$id)
    { 
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        if($request->ajax()){
            return response()->json(["message" => "Item Removed From Cart"],200);
        }else{
            return  back()->with('success',"Item Removed From Cart");
        }

    }

       /**
     * Show the application dashboard.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cart_clear()
    { 
        session()->put('cart', []);
        return back()->with('success','Cart Empty');

    }

    
}