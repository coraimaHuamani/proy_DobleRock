<?php

namespace App\Http\Controllers;

use App\Models\Galeria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galerias = Galeria::orderBy('created_at', 'desc')->get();
        return response()->json($galerias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:imagen,video',
            'archivo' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240', // 10MB max
            'estado' => 'boolean',
        ]);

        // Manejar la subida del archivo
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $rutaArchivo = $archivo->storeAs('galeria', $nombreArchivo, 'public');
            $validated['archivo'] = $rutaArchivo;
        }

        $validated['fecha_creacion'] = now();
        $validated['estado'] = $validated['estado'] ?? true;

        $galeria = Galeria::create($validated);

        return response()->json($galeria, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $galeria = Galeria::findOrFail($id);
        return response()->json($galeria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $galeria = Galeria::findOrFail($id);

        $validated = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'sometimes|required|in:imagen,video',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240',
            'estado' => 'boolean',
        ]);

        // Manejar la subida del nuevo archivo si se proporciona
        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior
            if ($galeria->archivo && Storage::disk('public')->exists($galeria->archivo)) {
                Storage::disk('public')->delete($galeria->archivo);
            }

            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $rutaArchivo = $archivo->storeAs('galeria', $nombreArchivo, 'public');
            $validated['archivo'] = $rutaArchivo;
        }

        $galeria->update($validated);

        return response()->json($galeria);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $galeria = Galeria::findOrFail($id);

        // Eliminar el archivo físico
        if ($galeria->archivo && Storage::disk('public')->exists($galeria->archivo)) {
            Storage::disk('public')->delete($galeria->archivo);
        }

        $galeria->delete();

        return response()->json(['message' => 'Item de galería eliminado exitosamente']);
    }

    /**
     * Cambiar el estado de un item de galería
     */
    public function toggleEstado(string $id)
    {
        $galeria = Galeria::findOrFail($id);
        $galeria->estado = !$galeria->estado;
        $galeria->save();

        return response()->json([
            'message' => 'Estado actualizado correctamente',
            'estado' => $galeria->estado
        ]);
    }

    /**
     * Obtener items por tipo
     */
    public function porTipo(string $tipo)
    {
        $validated = in_array($tipo, ['imagen', 'video']);
        
        if (!$validated) {
            return response()->json(['error' => 'Tipo no válido'], 400);
        }

        $galerias = Galeria::where('tipo', $tipo)
                          ->where('estado', true)
                          ->orderBy('created_at', 'desc')
                          ->get();

        return response()->json($galerias);
    }
}
