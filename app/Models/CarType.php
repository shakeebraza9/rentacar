<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    use HasFactory;

    protected $table = 'car_type'; // ٹیبل کا نام

    protected $fillable = [
        'title',
        'slug',
        'amount',
    ];

    public $timestamps = true; // `created_at` اور `updated_at` خود بخود ہینڈل ہوں گے
}
