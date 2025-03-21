<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;

    protected $table = 'variations';

    protected $fillable = [
        "ticket_id",
        "quantity",
        "price",
        "type",
        "to_date",
        "from_date",
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}