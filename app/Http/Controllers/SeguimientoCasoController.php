<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeguimientoCaso;
use App\Http\Controllers\NotificacionController;

class SeguimientoCasoController extends Controller
{
    public function apiGuardarSeguimiento(Request $request)
    {
        $seguimiento = SeguimientoCaso::create([
            'case_id' => $request->ticketId,
            'author_id' => auth()->user()->id,
            'body' => $request->texto,
        ]);

        if ($seguimiento) {
            $data = [
                'case_id' => $seguimiento->caso->case_id,
                'num_case' => $seguimiento->caso->num_case,
                'body' => $seguimiento->body,
                'user_contact_id' => $seguimiento->caso->user_contact_id,
            ];
            NotificacionController::notificacionNuevoSeguimiento($data);
            return response()->json([
                'estatus' => 1,
                'mensaje' => "Seguimiento almacenado en el folio " . $seguimiento->caso->num_case
            ]);
        } else {
            return response()->json([
                'estatus' => 0,
                'mensaje' => "Error al crear el registro"
            ]);
        }
    }
}
