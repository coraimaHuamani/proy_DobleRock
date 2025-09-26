<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Album extends Model
{
    protected $table = "albums";
    protected $fillable = [
        'title',
        'year',
        'cover_image_path',
    ];

    public function songs(){
        return $this->hasMany(Song::class, 'album_id');
    }
}
