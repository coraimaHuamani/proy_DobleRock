<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        'title',
        'artist',
        'genre',
        'duration',
        'file_path',
        'album_id'
    ];

    public function album(){
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function getFormattedDurationAttribute(){
        $minutes = floor($this->duration /60);
        $seconds = $this->duration%60;
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function playlists(){
        return $this->belongsToMany(Playlist::class, 'playlist_song')
                    ->withTimestamps();
    }



}
