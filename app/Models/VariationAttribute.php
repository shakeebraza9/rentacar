<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class VariationAttribute extends Model
{
    protected $table = 'variation_attributes';

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        "id",
        "variation_id",
        "attribute_id",
        "value_id",
        "value",
        "created_at",
        "updated_at"
    ];

      // Relationship to itself for parent-child relationship
      public function attribute()
      {
          return $this->belongsTo(Attribute::class, 'attribute_id');
      }

      public function values()
      {
          return $this->belongsTo(Value::class, 'value_id');
      }

     
}