<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class OrderItem extends Model
{

    protected $table = 'order_items';

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
            'id',
            'order_id',
            'variation_id',
            'title',
            'sku',
            'image_id',
            'quantity',
            'price',
            'attr',
            'total',
            'created_at',
            'updated_at'
    ];

 
    public function image()
    {   
        return $this->belongsTo(Filemanager::class, 'image_id');
    }

    public function variation()
    {   
        return $this->belongsTo(Variation::class, 'variation_id');
    }

    
}
