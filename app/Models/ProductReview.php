<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $table = 'product_reviews'; // Table name

    // Fillable fields for mass assignment
    protected $fillable = [
        'product_id',
        'user_id',
        'review',
        'star',
        'active',
        'title',
        'ip_address',
        'verified_purchase',
        'sort_order',
        'created_at',
        'updated_at'
    ];

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}