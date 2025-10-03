<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Playlist;

class PlaylistController extends Controller{
  public function Partial($id) {
        $playlist = Playlist::with('songs')->findOrFail($id);

        $playlistData = [
            'id' => $playlist->id,
            'nombre' => $playlist->title,
            'descripcion' => $playlist->description,
            'cover' => $playlist->cover_image_url
                ?: 'https://via.placeholder.com/400x300/232323/e7452e?text=Sin+Portada',
            'items' => $playlist->songs->count(),
            'canciones' => $playlist->songs->map(function ($song) {
                return [
                    'id' => $song->id,
                    'titulo' => $song->title,
                    'artista' => $song->artist,
                    'duracion' => $song->formatted_duration,
                    'src' => $song->file_url,
                ];
            }),
        ];


        return view('partials.playlistContenido', compact('playlistData'));
    }
}