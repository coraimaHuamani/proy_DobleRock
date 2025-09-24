<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $noticias = News::latest()->get(['id', 'title', 'description', 'image', 'created_at', 'category']);
        return view('noticias', compact('noticias'));
    }

    public function show($id)
    {
        $noticia = News::findOrFail($id);
        return view('noticia', compact('noticia')); // si quieres un detalle, crea resources/views/noticia.blade.php
    }
}
