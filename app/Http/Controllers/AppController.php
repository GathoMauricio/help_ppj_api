<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Download;

class AppController extends Controller
{
    public function apiUltimaVersionAndroid()
    {
        return response()->json([
            'estatus' => 1,
            'última_version' => '0_0_4',
            //'última_version' => env('ANDROID_VERSION'),
        ]);
    }

    public function descargarAndroidApp(Request $request)
    {
        //return response()->download(storage_path('app/public/android_app/mesa_ayuda_' . env('ANDROID_VERSION') . '.apk'));
        Download::create(['ip' => $request->ip(), 'version' => '0.0.4']);
        return response()->download(storage_path('app/public/android_app/mesa_ayuda_0_0_4.apk'));
    }
}
