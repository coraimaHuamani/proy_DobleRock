<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    /**
     * List all albums and its songs.
     */
    public function index()
    {
        return response()->json(
            Album::with('songs')->get()
        );
    }

    /**
     * Create an album.
     */    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'year'=> 'required|integer|max:' . date('Y'),
            'cover_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('cover_image_path')) {
            
            $image = $request->file('cover_image_path');
            // crea el nombre del archivo con timestamp + título del álbum
            $filename = time() . '-' . Str::slug($request->input('title')) . '.' . $image->getClientOriginalExtension();

            // se guarda en public/uploads/album_images
            $path = $image->storeAs('album_images', $filename, 'public');
            $validated['cover_image_path'] = $path;
        }


        $album = Album::create($validated);
        return response()->json($album, 201);
    }

    /**
     * Show specific album with its songs.
     */
    public function show(Album $album)
    {
        return response()->json(
            $album->load('songs')
        );
    }

    
    /**
     * Update an album.
     */
    public function update(Request $request, Album $album){
        $validated = $request->validate([
            'title'=> 'required|string|max:50',
            'year'=> 'required|integer|max:'. date('Y'),
            'cover_image_path'=> 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('cover_image_path')) {
            // borra la imagen anterior si existe
            if ($album->cover_image_path && Storage::disk('public')->exists($album->cover_image_path)) {
                Storage::disk('public')->delete($album->cover_image_path);
            }

            // genera nombre nuevo
            $coverImage = $request->file('cover_image_path');
            $filename = time() . '-' . Str::slug($request->input('title')) . '.' . $coverImage->getClientOriginalExtension();

            // se guarda en public/uploads/album_images
            $path = $coverImage->storeAs('album_images', $filename, 'public');
            $validated['cover_image_path'] = $path;
        }


        $album->update($validated);
        return response()->json($album);
    }

    /**
     * Delete an album and its songs.
     */
    public function destroy(Album $album){
        $album->delete();
        return response()->json(['message' => 'Album deleted'], 204);
    }
}
