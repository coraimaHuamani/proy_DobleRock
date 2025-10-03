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
            ->get(['id', 'titulo', 'descripcion', 'archivo', 'tipo', 'estado', 'created_at']);
                          

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
