<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        if (!$usuario->estado) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario inactivo. Contacta al administrador.'
            ], 403);
        }

        // Crear token
        $token = $usuario->createToken('auth_token')->plainTextToken;

        \Log::info('=== LOGIN EXITOSO ===', [
            'user_id' => $usuario->id,
            'token' => substr($token, 0, 20) . '...',
            'estableciendo_cookie' => true
        ]);

        // Quitar la cookie y solo retornar JSON normal:
        return response()->json([
            'success' => true,
            'message' => 'Inicio de sesión exitoso',
            'user' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'rol' => $usuario->rol
            ],
            'token' => $token,
            'redirect_url' => $usuario->rol === 1 ? '/dashboard' : '/'
]);
    }

    public function logout(Request $request)
    {
        // Revocar el token actual
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada exitosamente'
        ], 200);
    }
}
