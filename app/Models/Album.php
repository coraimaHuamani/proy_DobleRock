<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Album extends Model
{
    protected $table = "albums";
    protected $fillable = [
        'title',
        'year',
        'cover_image_path',
    ];
    protected $appends = ['cover_image_url'];

    public function songs(){
        return $this->hasMany(Song::class, 'album_id');
    }

    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image_path
            ? Storage::disk('public')->url($this->cover_image_path)
            : null;
    }
}
