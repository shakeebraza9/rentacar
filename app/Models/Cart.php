<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;

class Cart 
{
    
    public static function get_cart_details(){
    
        $total = 0;
        $cart_items = [];   
        $cart = session()->get('cart', []);

        foreach ($cart as $key => $c) {
            
            $products = Variation::select([
                'products.id',
                'products.title',
                'products.slug',
                'variations.id as variation_id',
                'variations.sku as sku',
                'filemanager.path as image',
                'variations.quantity as quantity',
                'variations.price'
            ])
            ->join('products','products.id','=','variations.product_id')
            ->join('filemanager','filemanager.id','=','variations.image')
            ->where('variations.id',$c['sku'])
            ->first()
            ->toArray();

            $attributes = [];
           if($c['attributes']){
                $attributes = Value::select([
                    'attributes.title as attribute_title',
                    'attributes.id as attribute_id',
                    'values.id as values_id',
                    'values.title as values_title',
                ])
                ->join('attributes','attributes.id','=','values.attribute_id')
                ->whereIn('values.id',array_values($c['attributes']))
                ->get()
                ->toArray();
           }

           
           $total += $products['price'] * $c['quantity']; 

           array_push($cart_items,[
              "id" => Crypt::encryptString($products['id']),
              "title" => $products['title'],
              "sku" => $products['sku'],
              "slug" => $products['slug'],
              "variation_id" => $products['variation_id'],
              "image" => asset($products['image']),
              "quantity" => $products['quantity'],
              "price" => $products['price'],
              "total" => $products['price'] * $c['quantity'],
              "cart_qty" => $c['quantity'],
              "link" => URL::to('/products').'/'.$products['slug'],
              "remove" => URL::to('/cart/remove/').'/'.$products['variation_id'],
              "attributes" => $attributes,
           ]);

        }

        
        return [
            'currency' => 'PKR',
            'total' => $total,
            'cart_items' => $cart_items
        ];
        
        
    }

   


}
