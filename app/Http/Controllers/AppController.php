<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function apiUltimaVersionAndroid()
    {
        return response()->json([
            'estatus' => 1,
            'última_version' => '0_0_2',
            //'última_version' => env('ANDROID_VERSION'),
        ]);
    }

    public function descargarAndroidApp()
    {
        //return response()->download(storage_path('app/public/android_app/mesa_ayuda_' . env('ANDROID_VERSION') . '.apk'));
        return response()->download(storage_path('app/public/android_app/mesa_ayuda_0_0_2.apk'));
    }
}
