<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class Slider extends Model
{

    protected $table = 'sliders';

    /**
     * The attributes that are mass assignable
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'title',
        'slug',
        'details',
        'image_id',
        'alt',
        'sort',
        'is_enable',
        'button',
        'link',
        'alignment',
        'created_at',
        'updated_at',
    ];


    public function image()
    {
        return $this->belongsTo(Filemanager::class, 'image_id');
    }


     
}