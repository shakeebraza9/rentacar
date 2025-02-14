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
        'status',
    ];

    public $timestamps = true;

    public function attraction()
    {
        return $this->belongsTo(Attraction::class, 'attraction_id');
    }
}