<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTicket extends Model
{
    use HasFactory;

    protected $table = 'order_ticket'; // Ensure the table name matches

    protected $fillable = [
        'ticket_id',
        'userid',
        'name',
        'email',
        'phone',
        'country',
        'adult_quantity',
        'child_quantity',
        'promo_code',
        'amount',
        'payment_status',
        'date',
        'addons'
    ];

    protected $casts = [
        'addons' => 'array', // Automatically convert JSON to array
    ];
}