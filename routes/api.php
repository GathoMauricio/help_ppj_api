<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('api-login', [\App\Http\Controllers\UserController::class, 'apiLogin']);
Route::get('api-solicitar-password', [\App\Http\Controllers\UserController::class, 'apiSolicitarPassword']);
Route::get('api-ultima-version-android', [\App\Http\Controllers\AppController::class, 'apiUltimaVersionAndroid']);
Route::get('api-descargar-android-app', [\App\Http\Controllers\AppController::class, 'descargarAndroidApp']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('api-datos-usuario', [\App\Http\Controllers\UserController::class, 'apiDatosUsuario']);
    Route::get('api-logout', [\App\Http\Controllers\UserController::class, 'apiLogout']);
    Route::post('api-obtener-casos-usuario', [\App\Http\Controllers\CasoController::class, 'apiObtenerCasosUsuario']);
    Route::get('api-obtener-info-caso', [\App\Http\Controllers\CasoController::class, 'apiObtenerInfoCaso']);
    Route::post('api-ultima-version-android', [\App\Http\Controllers\AppController::class, 'apiUltimaVersionAndroid']);
    Route::get('api-obtener-areas', [\App\Http\Controllers\AreaController::class, 'apiObtenerAreas']);
    Route::get('api-obtener-tipos-servicio', [\App\Http\Controllers\TipoServicioController::class, 'apiObtenerTiposServicio']);
    Route::get('api-obtener-prioridades-caso', [\App\Http\Controllers\PrioridadCasoController::class, 'apiObtenerPrioridadesCaso']);
    Route::post('api-guardar-caso', [\App\Http\Controllers\CasoController::class, 'apiGuardarCaso']);
    Route::post('api-guardar-seguimiento', [\App\Http\Controllers\SeguimientoCasoController::class, 'apiGuardarSeguimiento']);
    Route::post('api-adjuntar-archivo', [\App\Http\Controllers\AdjuntoController::class, 'apiAdjuntarArchivo']);
    Route::post('api-actualizar-fcm', [\App\Http\Controllers\NotificacionController::class, 'apiActualizarFcm']);
    Route::post('api-actualizar-estatus-ticket', [\App\Http\Controllers\CasoController::class, 'apiActualizarEstatusTicket']);
    Route::post('api-actualizar-password', [\App\Http\Controllers\UserController::class, 'apiActualizarPassword']);
});
