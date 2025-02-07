<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filemanager extends Model
{
    use HasFactory;
    protected $table = "filemanager";
    protected $fillable = [
        'id',
        'title',
        'description',
        'filename',
        'size',
        'extension',
        'preview',
        'type',
        'grouping',
        'path',
        'created_by',
        'created_at',
        'is_enable',
        'updated_at',
    ];
}