<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    // Table Name (Optional if follows Laravel convention)
    protected $table = 'faq';

    // Primary Key
    protected $primaryKey = 'id';

    // Mass Assignable Fields
    protected $fillable = [
        'name',
        'description',
        'type',
    ];

    // Automatically Cast Fields
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'type' => 'string', // Ensuring ENUM type is treated as a string
    ];

    // ENUM Type Values
    public static function getTypes()
    {
        return ['car', 'attraction'];
    }
}