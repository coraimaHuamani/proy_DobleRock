<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        return response()->json(Producto::with('categoria')->get(), 200);
    }

    public function store(Request $request)
    {
        \Log::info('=== CREANDO PRODUCTO ===');
        \Log::info('Datos recibidos:', $request->all());
        \Log::info('Archivos recibidos:', $request->allFiles());

        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $data = $request->only(['nombre', 'descripcion', 'precio', 'categoria_id', 'stock']);

        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            
            \Log::info('Procesando imagen:', [
                'original_name' => $imagen->getClientOriginalName(),
                'size' => $imagen->getSize(),
                'mime_type' => $imagen->getMimeType(),
                'is_valid' => $imagen->isValid()
            ]);

            if ($imagen->isValid()) {
                // Generar nombre único
                $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
                $imagenPath = $imagen->storeAs('productos', $nombreArchivo, 'public');
                
                \Log::info('Imagen guardada:', [
                    'path' => $imagenPath,
                    'full_path' => storage_path('app/public/' . $imagenPath),
                    'exists' => file_exists(storage_path('app/public/' . $imagenPath))
                ]);
                
                $data['imagen'] = $imagenPath;
            } else {
                \Log::error('Imagen no es válida');
                return response()->json([
                    'success' => false,
                    'message' => 'La imagen no es válida'
                ], 400);
            }
        } else {
            \Log::info('No se recibió imagen');
        }

        $producto = Producto::create($data);
        
        \Log::info('Producto creado:', [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'imagen' => $producto->imagen
        ]);

        return response()->json($producto->load('categoria'), 201);
    }

    public function show($id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);
        return response()->json($producto, 200);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        // Manejar la subida de nueva imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $imagen = $request->file('imagen');
            $filename = time() . '-' . Str::slug($request->input('nombre')) . '.' . $imagen->getClientOriginalExtension();
            $path = $imagen->storeAs('productos', $filename, 'public');
            $validated['imagen'] = $path;
        }

        $producto->update($validated);

        return response()->json($producto, 200);
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        // Eliminar imagen asociada
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }
}