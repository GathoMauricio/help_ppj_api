<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kutia\Larafirebase\Facades\Larafirebase;
use App\Models\User;

class NotificacionController extends Controller
{
    private $deviceTokens = ['dMRvGwNpQQWjsFiy6scheR:APA91bFTbhaNHORH7LBKHdsbwlvFhtYUA9VLVzT-PxXbTKhc1GpPZSrN6Q6Mg6A37yx-CXOSIRMoc5d2PCHZyDq8jeVU324pQ4ITlrAP5VqOInjRBZGzXt4stcN1RM5tROudgVGNTe1R'];

    static function notificacionNuevoCaso(array $data)
    {
        #La notificación le llegará solo a los administradores y soporte técnico
        #que esten activos y su token fcm exista.
        $users = User::where('status', 'Activo')->whereNotNull('fcm_token')->where(function ($q) {
            $q->where('user_rol_id', 1);
            $q->orWhere('user_rol_id', 2);
        })->get();
        $tokens = $users->pluck('fcm_token');
        $array_tokens = [];
        foreach ($tokens as $token) {
            $array_tokens[] = $token;
        }
        $respuesta =  Larafirebase::withTitle('Nuevo Caso: ' . $data['num_case'])
            ->withBody($data['description'])
            ->withAdditionalData([
                'case_id' => $data['case_id'],
                'type' => 'Nuevo Caso: ' . $data['num_case'],
            ])
            ->sendNotification($array_tokens);
        \Log::debug($respuesta);
    }
    static function notificacionNuevoSeguimiento(array $data)
    {
        # La notificación le llegará a los usuarios activos, que su token no sea nulo,
        #que sea quien creo el caso o que sea admin o soporte
        $users = User::where('status', 'Activo')->whereNotNull('fcm_token')->where(function ($q) use ($data) {
            $q->where('user_rol_id', 1);
            $q->orWhere('user_rol_id', 2);
            $q->orWhere('id', $data['user_contact_id']);
        })->get();
        $tokens = $users->pluck('fcm_token');
        $array_tokens = [];
        foreach ($tokens as $token) {
            $array_tokens[] = $token;
        }
        return Larafirebase::withTitle('Nuevo seguimiento: ' . $data['num_case'])
            ->withBody($data['body'])
            ->withAdditionalData([
                'case_id' => $data['case_id'],
                'type' => 'Nuevo seguimiento: ' . $data['num_case'],
            ])
            ->sendNotification($array_tokens);
    }
    static function notificacionNuevoAdjunto(array $data)
    {
        # La notificación le llegará a los usuarios activos, que su token no sea nulo,
        #que sea quien creo el caso o que sea admin o soporte con la url de la imagen almacenada
        $users = User::where('status', 'Activo')->whereNotNull('fcm_token')->where(function ($q) use ($data) {
            $q->where('user_rol_id', 1);
            $q->orWhere('user_rol_id', 2);
            $q->orWhere('id', $data['user_contact_id']);
        })->get();
        $tokens = $users->pluck('fcm_token');
        $array_tokens = [];
        foreach ($tokens as $token) {
            $array_tokens[] = $token;
        }
        return Larafirebase::withTitle('Nuevo archivo adjunto: ' . $data['num_case'])
            ->withBody('Se agregó una foto nueva.')
            ->withImage($data['url_image'])
            ->withAdditionalData([
                'case_id' => $data['case_id'],
                'url' => $data['url_image'],
                'type' => 'Nuevo archivo adjunto: ' . $data['num_case'],
            ])
            ->sendNotification($array_tokens);
    }
    static function notificacionCambioEstatuso(array $data)
    {
        # La notificación le llegará a los usuarios activos, que su token no sea nulo,
        #que sea quien creo el caso o que sea admin o soporte con la url de la imagen almacenada
        $users = User::where('status', 'Activo')->whereNotNull('fcm_token')->where(function ($q) use ($data) {
            $q->where('user_rol_id', 1);
            $q->orWhere('user_rol_id', 2);
            $q->orWhere('id', $data['user_contact_id']);
        })->get();
        $tokens = $users->pluck('fcm_token');
        $array_tokens = [];
        foreach ($tokens as $token) {
            $array_tokens[] = $token;
        }
        return Larafirebase::withTitle('Se cambió el estatus del caso : ' . $data['num_case'])
            ->withBody('El caso se encuentra: ' . $data['estatus'])
            ->withAdditionalData([
                'case_id' => $data['case_id'],
                'type' => 'Se cambió el estatus del caso : ' . $data['num_case'],
            ])
            ->sendNotification($array_tokens);
    }
    public function apiActualizarFcm(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->fcm_token = $request->fcm_token;
        if ($user->save()) {
            return response()->json([
                'estatus' => 1,
                'mensaje' => 'FCM Actualizado',
                'new_token' => $request->fcm_token
            ]);
        } else {
            return response()->json([
                'estatus' => 2,
                'mensaje' => 'Error al actualizar FCM'
            ]);
        }
    }
}
