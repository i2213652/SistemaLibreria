<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mantenimiento\Inventario\CategoriaController as InventarioCategoriaController;
use App\Http\Controllers\Mantenimiento\Inventario\MarcaController as InventarioMarcaController;

// ---------------------------------------------------------------------

Route::GET('/inv/categorias', [InventarioCategoriaController::class, 'categorias'])
    ->name('man.inv.categorias');

Route::GET('/inv/marcas', [InventarioMarcaController::class, 'marcas'])
    ->name('man.inv.marcas');
