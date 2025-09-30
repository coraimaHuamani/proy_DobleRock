<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Playlist extends Model
{
    protected $fillable = [
        'title',
        'description',
        'cover_image_path',
    ];

    protected $appends = ['cover_image_url'];

    public function songs(){
        return $this->belongsToMany(Song::class, 'playlist_song')
                    ->withTimestamps();
    }

    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image_path
            ? Storage::disk('public')->url($this->cover_image_path)
            : null;
    }
}
