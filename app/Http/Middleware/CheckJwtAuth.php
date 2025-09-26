<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckJwtAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Si la petición viene con el parámetro de bypass, permitir
        if ($request->has('verified') && $request->get('verified') === 'true') {
            return $next($request);
        }

        // Mostrar página de verificación de JavaScript
        return response()->view('auth.js-auth-check', [
            'required_role' => $role,
            'target_url' => $request->url()
        ]);
    }
}
