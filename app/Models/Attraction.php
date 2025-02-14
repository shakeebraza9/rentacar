<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    use HasFactory;

    protected $table = 'attractions';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'note',
        'image_id',
        'gallery_id',
        'selling_price',
        'discount_price',
    ];

    public $timestamps = true;

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'attraction_id');
    }

    public function get_thumbnail()
    {
        return $this->belongsTo(Filemanager::class, 'image_id');
    }

    public function get_images()
    {
        return Filemanager::whereIn('id',array_map('intval', explode(',',$this->gallery_id)))->get();
    }
}