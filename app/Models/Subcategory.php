<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'subcategories';

    // The attributes that are mass assignable
    protected $fillable = [
        'title',
        'slug',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'details',
        'category_id'
    ];

   
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

   
}
