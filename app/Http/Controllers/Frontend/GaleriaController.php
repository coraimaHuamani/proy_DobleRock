<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Galeria;

class GaleriaController extends Controller
{
    /**
     * Mostrar listado de galerías en la vista
     */
    public function index()
    {
        // Traer solo las galerías activas con columnas específicas
        $galerias = Galeria::where('estado', true)
                          ->orderBy('created_at', 'desc')
                          ->get(['id', 'titulo', 'descripcion', 'archivo', 'tipo', 'estado', 'created_at'])
                          ->map(function($item) {
                              return [
                                  'id' => $item->id,
                                  'titulo' => $item->titulo,
                                  'descripcion' => $item->descripcion,
                                  'tipo' => $item->tipo,
                                  'archivo_url' => $item->archivo ? asset('storage/' . $item->archivo) : null,
                                  'tipo_nombre' => $item->tipo === 'imagen' ? 'Foto' : 'Video'
                              ];
                          });

        return view('galeria', compact('galerias'));
    }

    /**
     * Mostrar una galería específica en la vista
     */
    public function show(string $id)
    {
        $galeria = Galeria::findOrFail($id);
        return view('frontend.galerias.show', compact('galeria'));
    }
}
