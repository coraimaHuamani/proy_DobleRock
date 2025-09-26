<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = [
        'title',
        'description',
        'cover_image_path',
    ];

    public function songs(){
        return $this->belongsToMany(Song::class, 'playlist_song')
                    ->withTimestamps();
    }
}
