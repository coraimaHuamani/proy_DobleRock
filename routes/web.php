<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/about', function () {
    return view('about');
});

Route::get('/tienda', function () {
    return view('tienda'); // Cambiado de 'components.tienda' a 'tienda'
})->name('tienda');

