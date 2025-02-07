<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Product extends Model
{

    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "id",
        "title",
        "slug",
        "price",
        "selling_price",
        "sku",
        "category_id",
        "subcategory_id",
        "subchildcategory_id",
        "image",
        "images",
        "type",
        "hover_image",
        "is_featured",
        "is_popular",
        "details",
        "description",
        "meta_title",
        "meta_description",
        "meta_keywords",
        "is_enable",
        "created_at",
        "updated_at",
    ];


    // Relationship to itself for parent-child relationship
    public function variations()
    {
        return $this->hasMany(Variation::class, 'product_id');
    }

     // Relationship to itself for parent-child relationship
     public function collection()
     {
         return $this->hasMany(ProductCollection::class, 'product_id');
     }
     public function productDetails()
     {
         return $this->hasMany(ProductDetail::class, 'proid', 'id');
     }
    function generateAttributeCombinations($atts) {


        $attributes = [];
        foreach ($atts as $key => $value) {
            $patr = Attribute::where('id',$key)->first();
            $pval = Value::whereIn('id',$value)->get()->toArray();
            if($patr){
                $patr = $patr->toArray();
                $patr['values'] = $pval;
                array_push($attributes,$patr);
            }
        }

        $result = [[]]; // Initialize with an empty combination
        
        foreach ($attributes as $attribute) {
            $currentResult = [];
    
            foreach ($result as $item) {
                foreach ($attribute['values'] as $value) {
                    $currentResult[] = array_merge($item, [ $value]);
                }
            }
    
            $result = $currentResult;
        }
    
        return $result;
    }

    public function get_images()
    {  
        return Filemanager::whereIn('id',array_map('intval', explode(',',$this->images)))->get();
    }

    public function get_gallery()
    {  

        $img = explode(',',$this->images);
        array_push($img,$this->image);
        array_push($img,$this->hover_image);

        foreach ($this->variations->pluck('image')->toArray() as $val) {
            array_push($img,$val);
        }

        return Filemanager::whereIn('id',array_map('intval',$img))->get();
    }

    public function get_thumbnail()
    {   
        return $this->belongsTo(Filemanager::class, 'image');
    }

    public function get_hover_image()
    {
        return $this->belongsTo(Filemanager::class, 'hover_image');
    }

    public function get_category()
    {
        return Category::where('id',$this->category_id)->first();
        
    }




   
}
