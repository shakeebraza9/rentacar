<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    // Define the table name if it's not the default 'product_details'
    protected $table = 'product_details';

    // Fillable attributes to avoid mass-assignment exceptions
    protected $fillable = [
        'proid', // This is the foreign key linking to the products table
        'key_title', // The title for the detail
        'value', // The value of the detail
    ];

    // Define the inverse relationship to the `Product` model
    public function product()
    {
        return $this->belongsTo(Product::class, 'proid', 'id');
    }
}
