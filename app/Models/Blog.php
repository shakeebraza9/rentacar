<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs'; 


    protected $fillable = [
        'title',
        'description',
        'short_description',
        'user_id',
        'location',
        'image_id',
    ];


    public $timestamps = true;  

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function image()
    {
        return $this->belongsTo(Filemanager::class, 'image_id');
    }


}

