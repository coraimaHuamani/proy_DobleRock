<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::select('id', 'nombre', 'email', 'rol', 'telefono', 'direccion', 'estado', 'created_at')
            ->orderBy('id', 'asc') // Cambiar a orden ascendente por ID
            ->get()
            ->map(function ($usuario) {
                return [
                    'id' => $usuario->id,
                    'nombre' => $usuario->nombre,
                    'email' => $usuario->email,
                    'rol' => $usuario->rol,
                    'rol_nombre' => $usuario->rol_nombre, // Usar el accessor
                    'telefono' => $usuario->telefono,
                    'direccion' => $usuario->direccion,
                    'estado' => $usuario->estado,
                    'created_at' => $usuario->created_at,
                ];
            });

        return response()->json($usuarios);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'rol' => 'required|integer|in:1,2', // 1=admin, 2=cliente
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'estado' => 'boolean',
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => $request->password, // El mutador se encarga del hash
            'rol' => $request->rol,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'estado' => $request->has('estado') ? $request->boolean('estado') : true,
        ]);

        return response()->json(
            [
                'success' => true,
                'message' => 'Usuario creado exitosamente',
                'usuario' => [
                    'id' => $usuario->id,
                    'nombre' => $usuario->nombre,
                    'email' => $usuario->email,
                    'rol' => $usuario->rol,
                    'rol_nombre' => $usuario->rol_nombre,
                    'telefono' => $usuario->telefono,
                    'direccion' => $usuario->direccion,
                    'estado' => $usuario->estado,
                ],
            ],
            201,
        );
    }

    public function show($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Usuario no encontrado',
                ],
                404,
            );
        }

        return response()->json([
            'success' => true,
            'usuario' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'rol' => $usuario->rol,
                'rol_nombre' => $usuario->rol_nombre,
                'telefono' => $usuario->telefono,
                'direccion' => $usuario->direccion,
                'estado' => $usuario->estado,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Usuario no encontrado',
                ],
                404,
            );
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('usuarios')->ignore($usuario->id)],
            'password' => 'nullable|string|min:6',
            'rol' => 'required|integer|in:1,2',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'estado' => 'boolean',
        ]);

        $updateData = [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'rol' => $request->rol,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'estado' => $request->has('estado') ? $request->boolean('estado') : $usuario->estado,
        ];

        // Solo actualizar password si se proporciona
        if ($request->filled('password')) {
            $updateData['password'] = $request->password; // El mutador se encarga del hash
        }

        $usuario->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado exitosamente',
            'usuario' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'rol' => $usuario->rol,
                'rol_nombre' => $usuario->rol_nombre,
                'telefono' => $usuario->telefono,
                'direccion' => $usuario->direccion,
                'estado' => $usuario->estado,
            ],
        ]);
    }

    public function destroy($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Usuario no encontrado',
                ],
                404,
            );
        }

        $usuario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado exitosamente',
        ]);
    }

    // Cambiar estado (activar/desactivar)
    public function toggleEstado($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Usuario no encontrado',
                ],
                404,
            );
        }

        $usuario->update(['estado' => !$usuario->estado]);

        return response()->json([
            'success' => true,
            'message' => $usuario->estado ? 'Usuario activado' : 'Usuario desactivado',
            'usuario' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'rol' => $usuario->rol,
                'rol_nombre' => $usuario->rol_nombre,
                'telefono' => $usuario->telefono,
                'direccion' => $usuario->direccion,
                'estado' => $usuario->estado,
            ],
        ]);
    }

    // Obtener solo clientes
    public function clientes()
    {
        $clientes = Usuario::clientes()->activos()->select('id', 'nombre', 'email', 'telefono', 'direccion', 'estado', 'created_at')->orderBy('created_at', 'desc')->get();

        return response()->json($clientes);
    }

    // Obtener solo administradores
    public function administradores()
    {
        $admins = Usuario::admins()->select('id', 'nombre', 'email', 'telefono', 'direccion', 'estado', 'created_at')->orderBy('created_at', 'desc')->get();

        return response()->json($admins);
    }
}
