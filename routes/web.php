<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\NewsController as PublicNewsController;
use App\Http\Controllers\Frontend\GaleriaController as PublicGaleriaController;
use App\Http\Controllers\Frontend\ProductoController as PublicProductoController;


// Página principal
Route::get('/', function () {
    return view('home');
});


// ===================== NOTICIAS =====================
// Listado de noticias
Route::get('/noticias', [PublicNewsController::class, 'index'])->name('noticias');

// Detalle de una noticia
Route::get('/noticias/{id}', [PublicNewsController::class, 'show'])->name('noticias.show');

// ===================== GALERÍAS =====================
// Listado de galerías usando el Frontend controller
Route::get('/galeria', [PublicGaleriaController::class, 'index'])->name('galeria');

// Detalle de una galería
Route::get('/galerias/{id}', [PublicGaleriaController::class, 'show'])->name('galerias.show');

// ===================== PRODUCTOS =====================
// Listado de productos (tienda)
Route::get('/tienda', [PublicProductoController::class, 'index'])->name('tienda');

// Detalle de un producto
Route::get('/producto/{id}', [PublicProductoController::class, 'show'])->name('producto.show');

// Otras vistas fijas
Route::get('/login', fn() => view('login'))->name('login');
Route::get('/register', fn() => view('register'))->name('register');
Route::get('/musica', fn() => view('musica'))->name('musica');

// Dashboard con validación de sesión
Route::get('/dashboard', function (Request $request) {
    if (!$request->session()->has('user')) {
        return redirect('/login');
    }
    return view('dashboard');
})->name('dashboard');

// Login personalizado
Route::post('/login', function (Request $request) {
    $user = \App\Models\Usuario::where('email', $request->input('email'))->first();

    if ($user && $user->estado && \Hash::check($request->input('password'), $user->password)) {
        $request->session()->put('user', $user->nombre);
        return redirect('/dashboard');
    }

    return back()->with('error', 'Credenciales incorrectas');
})->name('login.custom');
