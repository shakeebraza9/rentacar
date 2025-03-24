<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeakSeason extends Model
{
    use HasFactory;

    protected $table = 'peak_seasons';

    protected $fillable = [
        'title',
        'value',
        'start_date',
        'end_date',
        'enable',
    ];

    protected $casts = [
        'value' => 'array', // Automatically casts JSON field to an array
        'start_date' => 'date',
        'end_date' => 'date',
        'enable' => 'boolean',
    ];
}