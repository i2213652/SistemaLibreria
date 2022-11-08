<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mantenimiento\Inventario\CategoriaController as InventarioCategoriaController;
use App\Http\Controllers\Mantenimiento\Inventario\MarcaController as InventarioMarcaController;

// ---------------------------------------------------------------------

Route::GET('/inv/categorias/{solo_habilitado?}', [InventarioCategoriaController::class, 'get']);
Route::POST('/inv/categorias', [InventarioCategoriaController::class, 'store']);
Route::PUT('/inv/categorias/{id}', [InventarioCategoriaController::class, 'update']);

Route::GET('/inv/marcas/{solo_habilitado?}', [InventarioMarcaController::class, 'get']);
Route::POST('/inv/marcas', [InventarioMarcaController::class, 'store']);
Route::PUT('/inv/marcas/{id}', [InventarioMarcaController::class, 'update']);
