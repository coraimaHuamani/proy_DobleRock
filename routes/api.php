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
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('news', NewsController::class);
    Route::apiResource('galeria', GaleriaController::class);
    Route::apiResource('categorias', CategoriaController::class);
    Route::apiResource('productos', ProductoController::class);
});
