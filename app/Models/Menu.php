<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class Menu extends Model
{
    protected $table = 'menus';

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    
    protected $fillable = [
        'id',
        'title',
        'slug',
        'details',
        'is_enable',
        'created_at',
        'updated_at',
    ];

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'menu_id')->orderBy('sort');
    }



   
}
