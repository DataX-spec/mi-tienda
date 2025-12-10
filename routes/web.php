<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

// Página principal
Route::get('/', [ProductoController::class, 'home'])->name('home');

// Ruta de búsqueda de productos
Route::get('/productos/buscar', [ProductoController::class, 'search'])->name('productos.search');

// Rutas CRUD para productos
Route::resource('productos', ProductoController::class);

// Página de contacto
Route::view('/contacto', 'contacto')->name('contacto');
