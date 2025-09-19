<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
});

Route::get('/tienda', function () {
    return view('tienda');
})->name('tienda');

Route::get('/noticias', function () {
    return view('noticias');
})->name('noticias');

Route::get('/galeria', function () {
    return view('galeria');
})->name('galeria');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/musica', function () {
    return view('musica');
})->name('musica');

Route::get('/producto', function () {
    return view('producto');
})->name('producto');

Route::get('/dashboard', function (Request $request) { if (!$request->session()->has('user')) { return redirect('/login'); } return view('dashboard'); })->name('dashboard');

Route::post('/login', function(Request $request) { $user = \App\Models\Usuario::where('email', $request->input('email'))->first(); if ($user && $user->estado && \Hash::check($request->input('password'), $user->password)) { $request->session()->put('user', $user->nombre); return redirect('/dashboard'); } return back()->with('error', 'Credenciales incorrectas'); })->name('login.custom');