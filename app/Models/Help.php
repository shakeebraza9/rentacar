<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    use HasFactory;

    protected $table = 'help';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'status'
    ];

    /**
     * Define the relationship: Each Help entry belongs to a Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}