<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);
// Route::get('/', function () {
//     if (Auth::check()) {
//         return App\Http\Controllers\HomeController::index();
//     }
//     return view('auth.login');
// });
// Route::any('/', function () {
//     if (Auth::check()) {
//         return App\Http\Controllers\HomeController::index();
//     }
//     return view('auth.login');
// })->name('/');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('generar_password/{token}', [\App\Http\Controllers\UserController::class, 'generarPassword']);
Route::get('show_caso/{}', [App\Http\Controllers\CasoController::class, 'show']);
Route::get('create_caso', [App\Http\Controllers\CasoController::class, 'create']);
Route::post('store_caso', [App\Http\Controllers\CasoController::class, 'store']);
Route::get('edit_caso/{id}', [App\Http\Controllers\CasoController::class, 'edit']);
Route::put('update_caso/{id}', [App\Http\Controllers\CasoController::class, 'update']);
Route::delete('delete_caso', [App\Http\Controllers\CasoController::class, 'delete']);
Route::get('cargar_seguimientos', [App\Http\Controllers\CasoController::class, 'cargarSeguimientos']);
Route::post('store_seguimiento', [App\Http\Controllers\CasoController::class, 'storeSeguimiento']);
Route::get('cargar_adjuntos', [App\Http\Controllers\CasoController::class, 'cargarAdjuntos']);
Route::post('store_adjunto', [App\Http\Controllers\CasoController::class, 'storeAdjunto']);

Route::get('api-obtener-tipos-servicio', [\App\Http\Controllers\TipoServicioController::class, 'apiObtenerTiposServicio']);

Route::get('index_usuarios', [App\Http\Controllers\UserController::class, 'index'])->name('index_usuarios')->middleware(App\Http\Middleware\IsAdminMiddleware::class);
Route::get('create_usuarios', [App\Http\Controllers\UserController::class, 'create'])->middleware(App\Http\Middleware\IsAdminMiddleware::class);
Route::post('store_usuarios', [App\Http\Controllers\UserController::class, 'store'])->middleware(App\Http\Middleware\IsAdminMiddleware::class);
Route::get('edit_usuarios/{id}', [App\Http\Controllers\UserController::class, 'edit'])->middleware(App\Http\Middleware\IsAdminMiddleware::class);
Route::put('update_usuarios/{id}', [App\Http\Controllers\UserController::class, 'update'])->middleware(App\Http\Middleware\IsAdminMiddleware::class);
Route::delete('delete_usuarios', [App\Http\Controllers\UserController::class, 'delete'])->middleware(App\Http\Middleware\IsAdminMiddleware::class);

Route::get('edit_password_usuarios/{id}', [App\Http\Controllers\UserController::class, 'editPassword'])->middleware(App\Http\Middleware\IsAdminMiddleware::class);
Route::put('update_password_usuarios/{id}', [App\Http\Controllers\UserController::class, 'updatePassword'])->middleware(App\Http\Middleware\IsAdminMiddleware::class);

Route::any('/', function () {
})->name('/');
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('home');
    }
    return view('auth.login');
})->name('/');
