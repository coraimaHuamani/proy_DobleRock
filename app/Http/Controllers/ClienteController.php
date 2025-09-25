<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index()
    {
        return response()->json(Cliente::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'email' => 'required|email|unique:clientes,email',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'estado' => 'boolean',
        ]);

        Cliente::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'estado' => $request->estado ?? true,
        ]);

        return response()->json(['message' => 'Cliente creado correctamente'], 201);
    }

    public function show($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }
        return response()->json($cliente, 200);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:150',
            'email' => ['sometimes','required','email', Rule::unique('clientes')->ignore($cliente->id)],
            'password' => 'sometimes|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'estado' => 'boolean',
        ]);

        $cliente->nombre = $request->nombre ?? $cliente->nombre;
        $cliente->email = $request->email ?? $cliente->email;
        if ($request->password) {
            $cliente->password = Hash::make($request->password);
        }
        $cliente->telefono = $request->telefono ?? $cliente->telefono;
        $cliente->direccion = $request->direccion ?? $cliente->direccion;
        $cliente->estado = $request->estado ?? $cliente->estado;

        $cliente->save();

        return response()->json(['message' => 'Cliente actualizado correctamente'], 200);
    }

    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $cliente->delete();
        return response()->json(['message' => 'Cliente eliminado correctamente'], 200);
    }
}
