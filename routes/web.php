<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\NewsController as PublicNewsController;
use App\Http\Controllers\Frontend\GaleriaController as PublicGaleriaController;
use App\Http\Controllers\Frontend\ProductoController as PublicProductoController;

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
Route::get('/galeria', [PublicGaleriaController::class, 'index'])->name('galeria');
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
Route::get('/perfil', fn() => view('perfil-cliente'))->name('perfil');

// ===================== DASHBOARD =====================
Route::get('/dashboard', function (Request $request) {
    if (!$request->session()->has('user')) {
        return redirect('/login');
    }
    return view('dashboard');
})->name('dashboard');

// ===================== LOGIN PERSONALIZADO =====================
Route::post('/login', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    // Intentar con administrador
    $usuario = \App\Models\Usuario::where('email', $email)->first();
    if ($usuario && $usuario->estado && \Hash::check($password, $usuario->password)) {
        $request->session()->put('user', $usuario->nombre);
        $request->session()->put('user_type', 'admin');
        $request->session()->put('user_id', $usuario->id);
        return redirect('/dashboard');
    }

    // Intentar con cliente
    $cliente = \App\Models\Cliente::where('email', $email)->first();
    if ($cliente && $cliente->estado && \Hash::check($password, $cliente->password)) {
        $request->session()->put('user', $cliente->nombre);
        $request->session()->put('user_type', 'cliente');
        $request->session()->put('user_id', $cliente->id);

        // Guardar info para navbar (flash)
        return redirect('/')->with('cliente_login', [
            'id' => $cliente->id,
            'nombre' => $cliente->nombre,
            'email' => $cliente->email
        ]);
    }

    return back()->with('error', 'Credenciales incorrectas o cuenta desactivada');
})->name('login.custom');

// ===================== LOGOUT UNIVERSAL =====================
Route::post('/logout', function (Request $request) {
    $userType = $request->session()->get('user_type');

    // Limpiar sesión
    $request->session()->flush();

    // Redirigir según tipo de usuario - ADMINS VAN AL HOME
    if ($userType === 'admin') {
        return redirect('/')->with('success', 'Sesión cerrada correctamente');
    } else {
        return redirect('/')->with('logout_cliente', true);
    }
})->name('logout');
