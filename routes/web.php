<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\General\HomeController;

// ---------------------------------------------------------------------

Route::GET('/',  [HomeController::class, 'home'])
    ->name('home');

Route::GET('/home', [HomeController::class, 'home'])
    ->name('home');

Route::prefix('inventario')
    ->group(base_path('routes/modules/inventario.php'));

Route::prefix('mantenimiento')
    ->group(base_path('routes/modules/mantenimiento.php'));
