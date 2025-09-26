<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class SongController extends Controller
{
    /**
     * List all songs with album.
     */
    public function index()
    {
         return response()->json(
            Song::with('album')->get()
        );
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'=> 'required|string|max:50',
            'artist'=> 'required|string|max:50',
            'genre'=> 'required|string|max:50',
            'duration'=> 'required|integer',
            'file' => 'required|mimes:mp3,wav|max:20000',
            'album_id'=> 'nullable|exists:albums,id',

        ]);

       
        if ($request->hasFile('file')) {
            $songFile = $request->file('file');
            $filename = time() . '-' . Str::slug($request->input('title')) . '.' . $songFile->getClientOriginalExtension();
            $path = $songFile->storeAs('songs', $filename, 'public');
            $validated['file_path'] = $path;
        }

        $song = Song::create($validated);

        return response()->json($song, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Song $song)
    {
        return response()->json($song->load('album'));
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Song $song)
    {
        $validated = $request->validate([
            'title'=> 'required|string|max:50',
            'artist'=> 'required|string|max:50',
            'genre'=> 'required|string|max:50',
            'duration'=> 'required|integer',
            'file'=> 'nullable|mimes:mp3,wav',
            'album_id'=> 'nullable|exists:albums,id',
        ]);

        if ($request->hasFile('file')) {
            if ($song->file_path && Storage::disk('public')->exists($song->file_path)) {
                Storage::disk('public')->delete($song->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '-' . Str::slug($request->input('title', $song->title)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('songs', $filename, 'public');
            $validated['file_path'] = $path;
        }

        $song->update($validated);

        return response()->json($song);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Song $song)
    {
        $song->delete();

        return response()->json(['message' => 'Song deleted'], 204);
    }
}
