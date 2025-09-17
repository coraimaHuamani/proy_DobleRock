<?php

use Illuminate\Support\Facades\Route;

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
