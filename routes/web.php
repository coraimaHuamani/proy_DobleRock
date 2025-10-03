<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\NewsController as PublicNewsController;
use App\Http\Controllers\Frontend\GaleriaController as PublicGaleriaController;
use App\Http\Controllers\Frontend\ProductoController as PublicProductoController;
use App\Http\Controllers\MercadoPagoController;

// ===================== PÁGINA PRINCIPAL =====================
Route::get('/', function () {
    return view('home');
});

// ===================== NOTICIAS =====================
// Listado de noticias
Route::get('/noticias', [PublicNewsController::class, 'index'])->name('noticias');
// Detalle de una noticia
Route::get('/noticias/{id}', [PublicNewsController::class, 'show'])->name('noticias.show');

// ===================== GALERÍAS =====================
// Listado de galerías
Route::get('/galerias', [PublicGaleriaController::class, 'index'])->name('galeria');
// Detalle de una galería
Route::get('/galerias/{id}', [PublicGaleriaController::class, 'show'])->name('galerias.show');

// ===================== PRODUCTOS =====================
// Listado de productos (tienda)
Route::get('/tienda', [PublicProductoController::class, 'index'])->name('tienda');
// Detalle de un producto
Route::get('/producto/{id}', [PublicProductoController::class, 'show'])->name('producto.show');

// ===================== VISTAS FIJAS =====================
Route::get('/login', fn() => view('login'))->name('login');
Route::get('/register', fn() => view('register'))->name('register');
Route::get('/musica', fn() => view('musica'))->name('musica');

// ===================== RUTAS PROTEGIDAS =====================
Route::middleware(\App\Http\Middleware\CheckJwtAuth::class . ':admin')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
});

Route::middleware(\App\Http\Middleware\CheckJwtAuth::class . ':cliente')->group(function () {
    Route::get('/perfil', fn() => view('perfil-cliente'))->name('perfil');
    Route::get('/checkout', fn() => view('checkout'))->name('checkout');
});

// ===================== RUTAS MERCADOPAGO =====================
Route::get('/mercadopago/success', [MercadoPagoController::class, 'success']);
Route::get('/mercadopago/failure', [MercadoPagoController::class, 'failure']);
Route::get('/mercadopago/pending', [MercadoPagoController::class, 'pending']);
