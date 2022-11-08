<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Inventario\ProductoController as InventarioProductoController;

// ---------------------------------------------------------------------

Route::GET('/productos', [InventarioProductoController::class, 'get']);
Route::POST('/productos', [InventarioProductoController::class, 'store']);
Route::PUT('/productos/{id}', [InventarioProductoController::class, 'update']);
Route::DELETE('/productos/{id}', [InventarioProductoController::class, 'delete']);
