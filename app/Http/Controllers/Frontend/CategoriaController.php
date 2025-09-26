<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Listar categorías públicas (nombre + descripción)
     */
    public function index()
    {
        $categorias = Categoria::where('estado', true)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'descripcion', 'created_at'])
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'nombre' => $c->nombre,
                    'descripcion' => $c->descripcion,
                    'created_at' => $c->created_at,
                ];
            });

        return view('frontend.categorias.index', compact('categorias'));
    }

    /**
     * Mostrar una categoría y sus productos públicos (opcional)
     */
    public function show($id)
    {
        $categoria = Categoria::with(['productos' => function ($q) {
            $q->where('estado', true)->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('frontend.categorias.show', [
            'categoria' => $categoria,
            'productos' => $categoria->productos,
        ]);
    }
}
