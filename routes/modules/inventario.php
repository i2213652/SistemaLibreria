<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Inventario\ProductoController as InventarioProductoController;

// ---------------------------------------------------------------------

Route::GET('/productos', [InventarioProductoController::class, 'productos'])
    ->name('inv.productos');

Route::GET('/categorias', [InventarioCategoriaController::class, 'categorias'])
    ->name('man.inv.categorias');
Route::GET('/marcas', [InventarioMarcaController::class, 'marcas'])
    ->name('man.inv.marcas');
