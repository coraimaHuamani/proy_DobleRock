<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\GaleriaController;
use App\Http\Middleware\JsonOnlyMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

Route::middleware(JsonOnlyMiddleware::class)->group(function () {
    // Rutas públicas
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [UsuarioController::class, 'store']); // <-- agregar ruta pública

    Route::apiResource('categorias', CategoriaController::class);

    // Rutas protegidas con Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::apiResource('usuarios', UsuarioController::class);
        Route::put('usuarios/{id}/toggle-estado', [UsuarioController::class, 'toggleEstado']);
        Route::get('usuarios/rol/administradores', [UsuarioController::class, 'administradores']);
        Route::apiResource('news', NewsController::class);
        Route::apiResource('galeria', GaleriaController::class);
        Route::apiResource('categorias', CategoriaController::class);
        Route::apiResource('productos', ProductoController::class);
    });
});
