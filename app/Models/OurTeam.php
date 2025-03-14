<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurTeam extends Model
{
    use HasFactory;

    protected $table = 'ourteam';

    protected $fillable = ['image_id', 'name', 'position'];

    public function image(){
        return $this->belongsTo(FileManager::class, 'image_id');
    }
}