<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traer productos activos con sus categorías agrupados por categoría
        $categorias = Categoria::with([
            'productos' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
        ])->get();

        // Mapear datos para la vista agrupados por categoría
        $productosPorCategoria = $categorias
            ->map(function ($categoria) {
                $productos = $categoria->productos->map(function ($producto) {
                    return [
                        'id' => $producto->id,
                        'nombre' => $producto->nombre,
                        'descripcion' => $producto->descripcion,
                        'precio' => $producto->precio,
                        'stock' => $producto->stock,
                        'imagen_url' => $producto->imagen ? asset('storage/' . $producto->imagen) : 'https://via.placeholder.com/400x300',
                    ];
                });

                return [
                    'categoria_id' => $categoria->id,
                    'categoria_nombre' => $categoria->nombre,
                    'productos' => $productos,
                ];
            })
            ->filter(function ($categoria) {
                return $categoria['productos']->count() > 0;
            });

        // También traer productos sin categoría
        $productosSinCategoria = Producto::whereNull('categoria_id')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($producto) {
                return [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'descripcion' => $producto->descripcion,
                    'precio' => $producto->precio,
                    'stock' => $producto->stock,
                    'imagen_url' => $producto->imagen ? asset('storage/' . $producto->imagen) : 'https://via.placeholder.com/400x300',
                ];
            });

        return view('tienda', compact('productosPorCategoria', 'productosSinCategoria'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);

        // Mapear datos para la vista
        $productoData = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'precio' => $producto->precio,
            'stock' => $producto->stock,
            'imagen_url' => $producto->imagen ? asset('storage/' . $producto->imagen) : 'https://via.placeholder.com/400x300',
            'categoria' => $producto->categoria ? $producto->categoria->nombre : 'Sin categoría',
        ];

        return view('producto', compact('productoData'));
    }

    /**
     * Show the form for creating a new resource.
     */
}
