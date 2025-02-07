<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Role extends Model
{
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'created_date',
        'updated_date',
        'created_by',
        'updated_by',
    ];


}
