<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Album;   
use App\Models\Playlist;
use App\Models\Song;

class AlbumController extends Controller{
  public function Partial($id) {
        $album = Album::with('songs')->findOrFail($id);

        $albumData = [
            'id' => $album->id,
            'nombre' => $album->title,
            'anio' => $album->year,
            'cover' => $album->cover_image_url
                ?: 'https://via.placeholder.com/400x300/232323/e7452e?text=Sin+Portada',
            'pistas' => $album->songs->count(),
            'canciones' => $album->songs->map(fn($s) => [
                'id'=> $s->id,
                'titulo' => $s->title,
                'artista' => $s->artist,
                'src' => $s->file_url,
                'duracion' => $s->formatted_duration
            ]),
        ];

        return view('partials.albumContenido', compact('albumData'));
    }
}