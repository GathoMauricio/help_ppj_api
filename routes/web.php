<?php

use Illuminate\Support\Facades\Route;

Route::get('login', function () {
    return response()->json([
        'error' => 401,
        'type' => 'Unauthorized'
    ]);
})->name('login');
Route::get('generar_password/{token}', [\App\Http\Controllers\UserController::class, 'generarPassword']);
