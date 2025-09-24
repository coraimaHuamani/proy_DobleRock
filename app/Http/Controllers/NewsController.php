<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();
        return response()->json($news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string|min:10|max:150',
            'category' => ['required', 'string', Rule::in(array_keys(News::CATEGORIES))],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'source_url' => 'url:http,https',
        ]);

         if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '-' . Str::slug($request->input('title')) . '.' . $image->getClientOriginalExtension();

            $path = $image->storeAs('news_images', $filename, 'public');
            $validated['image'] = $path;
        }

        $new = News::create($validated);

        return response()->json($new, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $new = News::findOrFail($id);
        return response()->json($new);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $new = News::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string|min:10|max:150',
            'category' => ['required', 'string', Rule::in(array_keys(News::CATEGORIES))],
            'source_url' => 'nullable|url:http,https',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($new->image && Storage::disk('public')->exists($new->image)) {
                Storage::disk('public')->delete($new->image);
            }

            $image = $request->file('image');
            $filename = time() . '-' . Str::slug($request->input('title')) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('news_images', $filename, 'public');
            $validated['image'] = $path;
        }

        $new->update($validated);
        return response()->json($new);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $new = News::findOrFail($id);
        $new->delete();

        return response()->json(status: 204);
    }
}
