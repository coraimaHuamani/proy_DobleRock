<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PlaylistController extends Controller
{
    public function index()
    {
        return response()->json(Playlist::with('songs')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:100',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $filename = time() .'-'.Str::slug($request->input('title')). '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('playlist_images', $filename, 'public');
            $validated['cover_image_path'] = $path;
        }


        $playlist = Playlist::create($validated);

        return response()->json($playlist, 201);
    }

    public function show(Playlist $playlist)
    {
        return response()->json($playlist->load('songs'));
    }

    public function update(Request $request, Playlist $playlist)
    {
        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:100',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($playlist->cover_image_path && Storage::disk('public')->exists($playlist->cover_image_path)) {
                Storage::disk('public')->delete($playlist->cover_image_path);
            }

            $image = $request->file('cover_image');
            $filename = time() . '-' . Str::slug($request->input('title', $playlist->title)) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('playlist_images', $filename, 'public');
            $validated['cover_image_path'] = $path;
        }

        $playlist->update($validated);

        return response()->json($playlist);
    }

    public function destroy(Playlist $playlist)
    {
        $playlist->delete();
        return response()->json(['message' => 'Playlist eliminada correctamente']);
    }

    public function addSongs(Request $request, $id)
    {
        $playlist = Playlist::findOrFail($id);
    $songIds = $request->input('song_ids', []);

    $playlist->songs()->attach($songIds);

    return response()->json([
        'message' => 'Canciones agregadas',
        'songs'   => $playlist->songs
    ]);
    }

    public function removeSongs(Request $request, $id)
    {
        
        $playlist = Playlist::findOrFail($id);

        $validated = $request->validate([
            'song_ids'   => 'required|array',
            'song_ids.*' => 'exists:songs,id'
        ]);

        $playlist->songs()->detach($validated['song_ids']);

        return response()->json([
            'message' => 'Canciones eliminadas correctamente',
            'songs'   => $playlist->songs()->get()
        ]);
    }

    
}
