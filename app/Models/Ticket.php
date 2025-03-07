<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'attraction_id',
        'title',
        'description',
        'discount_price',
        'selling_price',
        'ticket_quantity',
        'add_ons',
        'status',
    ];

    protected $casts = [
        'add_ons' => 'array', // Automatically decode JSON when retrieved
    ];

    public function attraction()
    {
        return $this->belongsTo(Attraction::class, 'attraction_id');
    }

    public function variations()
    {
        return $this->hasMany(Variation::class, 'ticket_id');
    }

    public function getVariationsByType()
    {
        return $this->variations->groupBy('type');
    }
}