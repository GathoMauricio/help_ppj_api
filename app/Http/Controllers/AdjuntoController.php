<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArchivoCaso;
use App\Http\Controllers\NotificacionController;

class AdjuntoController extends Controller
{
    public function apiAdjuntarArchivo(Request $request)
    {
        $archivo = $request->archivo;
        $archivo = str_replace('data:image/png;base64,', '', $archivo);
        $archivo = str_replace(' ', '+', $archivo);
        $ruta = '/app/public/case_files/';
        $archivoCaso = ArchivoCaso::create([
            'case_id' => $request->case_id,
            'author_id' => auth()->user()->id,
            'name' => 'pendiente',
            'route' => $ruta,
            'mime_type' => 'png',
        ]);
        if ($archivoCaso) {
            $nombreArchivo =  $request->case_id . '_' . $archivoCaso->id . '_' . '.png';
            $archivoCaso->name = $nombreArchivo;
            $archivoCaso->save();
            \File::put(storage_path($ruta . $nombreArchivo), base64_decode($archivo));
            $data = [
                'case_id' => $archivoCaso->caso->case_id,
                'num_case' => $archivoCaso->caso->num_case,
                'url_image' => 'http://' . env('SERVER_URL') . env('FILES_PATH') . $nombreArchivo,
                'user_contact_id' => $archivoCaso->caso->user_contact_id,
            ];
            NotificacionController::notificacionNuevoAdjunto($data);
            return response()->json([
                'estatus' => 1,
                'mensaje' => 'Archivo almacenado'
            ]);
        }
    }
}
