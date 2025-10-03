<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Playlist;
use App\Models\Song;

class MusicaController extends Controller
{
    public function index(){
        $songs = Song::with('album')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($song) {
                return [
                    'id' => $song->id,
                    'titulo' => $song->title,
                    'artista' => $song->artist,
                    'genero' => $song->genre,
                    'duracion' => $song->formatted_duration,
                    'src' => $song->file_url,
                    'album' => $song->album?->title ?? 'Sin álbum',
                ];
            });

       $albums = Album::with('songs')
            ->orderBy('year', 'desc')
            ->get()
            ->map(function ($album) {
                return [
                    'id' => $album->id,
                    'nombre' => $album->title,
                    'anio' => $album->year,
                    'cover' => $album->cover_image_url
                        ?: 'https://via.placeholder.com/400x300/232323/e7452e?text=Sin+Portada',
                    'pistas' => $album->songs->count(),
                    'artista' => $album->songs->first()?->artist ?? 'Varios',
                    'sample' => $album->songs->first()?->file_url,
                ];
            });

        $playlists = Playlist::with('songs')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($playlist) {
            return [
                'id' => $playlist->id,
                'nombre' => $playlist->title,
                'descripcion' => $playlist->description,
                'cover' => $playlist->cover_image_url
                    ?: 'https://via.placeholder.com/400x300/232323/e7452e?text=Sin+Portada',
                'items' => $playlist->songs->count(),
                'artista' => $playlist->songs->first()?->artist ?? 'Varios',
                'sample' => $playlist->songs->first()?->file_url,
            ];
        });

        return view('musica', compact('songs', 'albums', 'playlists'));
    }


}