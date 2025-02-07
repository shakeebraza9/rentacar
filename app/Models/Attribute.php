<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{

    protected $table = 'attributes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "id",
        "title",
        "created_at",
        "updated_at"
    ];

    // Relationship to itself for parent-child relationship
    public function values()
    {
        return $this->hasMany(Value::class, 'attribute_id');
    }



   
}
