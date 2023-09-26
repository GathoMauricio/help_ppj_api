<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caso;
use App\Models\SeguimientoCaso;
use App\Models\ArchivoCaso;

class CasoController extends Controller
{
    public function apiObtenerCasosUsuario()
    {
        if (auth()->user()->user_rol_id == 3) {
            $casos = Caso::where('user_contact_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        } else {
            $casos = Caso::orderBy('id', 'DESC')->limit(50)->get();
        }


        $datos = [];
        foreach ($casos as $caso) {
            $seguimientos_datos = [];
            $seguimientos = SeguimientoCaso::where('case_id', $caso->id)->orderBy('id', 'DESC')->get();
            foreach ($seguimientos as $seguimiento) {
                $seguimientos_datos[] = [
                    'id' => $seguimiento->id,
                    'ticket_id' => $seguimiento->case_id,
                    'autor' => $seguimiento->autor->name . ' ' . $seguimiento->autor->middle_name . ' ' . $seguimiento->autor->last_name,
                    'texto' => $seguimiento->body,
                    'created_at' => $seguimiento->created_at,
                ];
            }
            $archivos = ArchivoCaso::where('case_id', $caso->id)->orderBy('id', 'DESC')->get();
            $archivos_datos = [];
            foreach ($archivos as $archivo) {
                $archivos_datos[] = [
                    'id' => $archivo->id,
                    'case_id' => $archivo->case_id,
                    'author' => $archivo->autor->name . ' ' . $archivo->autor->middle_name . ' ' . $archivo->autor->last_name,
                    'name' => $archivo->name,
                    'route' => $archivo->route,
                    'mime_type' => $archivo->mime_type,
                    'created_at' => $archivo->created_at,
                ];
            }
            $datos[] = [
                'id' => $caso->id,
                'estatus' => $caso->estatus->name,
                'area' => $caso->tipo_servicio->area->name,
                'tipo_servicio' => $caso->tipo_servicio->name,
                'categoria' => $caso->tipo_servicio->name,
                'sintoma' => 'N/A',
                'usuarioFinal' => $caso->contacto->name . ' ' . $caso->contacto->middle_name . ' ' . $caso->contacto->last_name,
                'folio' => $caso->num_case,
                'prioridad' => $caso->prioridad->name,
                'descripcion' => $caso->description,
                'seguimientos' => $seguimientos_datos,
                'archivos' => $archivos_datos,
            ];
        }
        return response()->json([
            "estatus" => 1,
            "mensaje" => "Datos obtenidos",
            "datos" => $datos
        ]);
    }

    public function apiObtenerInfoCaso(Request $request)
    {
        $caso = Caso::find($request->caso_id);
        $seguimientos = SeguimientoCaso::where('case_id', $caso->id)->orderBy('id', 'DESC')->get();
        $seguimientos_datos = [];
        foreach ($seguimientos as $seguimiento) {
            $seguimientos_datos[] = [
                'id' => $seguimiento->id,
                'ticket_id' => $seguimiento->case_id,
                'autor' => $seguimiento->autor->name . ' ' . $seguimiento->autor->middle_name . ' ' . $seguimiento->autor->last_name,
                'texto' => $seguimiento->body,
                'created_at' => $seguimiento->created_at,
            ];
        }
        $archivos = ArchivoCaso::where('case_id', $caso->id)->orderBy('id', 'DESC')->get();
        $archivos_datos = [];
        foreach ($archivos as $archivo) {
            $archivos_datos[] = [
                'id' => $archivo->id,
                'case_id' => $archivo->case_id,
                'author' => $archivo->autor->name . ' ' . $archivo->autor->middle_name . ' ' . $archivo->autor->last_name,
                'name' => $archivo->name,
                'route' => $archivo->route,
                'mime_type' => $archivo->mime_type,
                'created_at' => $archivo->created_at,
            ];
        }
        return response()->json([
            'id' => $caso->id,
            'estatus' => $caso->estatus->name,
            'area' => $caso->tipo_servicio->area->name,
            'tipo_servicio' => $caso->tipo_servicio->name,
            'categoria' => $caso->tipo_servicio->name,
            'sintoma' => 'N/A',
            'usuarioFinal' => $caso->contacto->name . ' ' . $caso->contacto->middle_name . ' ' . $caso->contacto->last_name,
            'folio' => $caso->num_case,
            'prioridad' => $caso->prioridad->name,
            'descripcion' => $caso->description,
            'seguimientos' => $seguimientos_datos,
            'archivos' => $archivos_datos,
        ]);
    }

    public function apiGuardarCaso(Request $request)
    {
        $caso = Caso::create([
            'num_case' => $this->generaFolio(),
            'status_id' => 1,
            'service_id' => $request->tipoServicioId,
            'user_contact_id' => auth()->user()->id,
            'priority_case_id' => $this->prioridadToId($request->prioridad),
            'description' => $request->descripcion,
        ]);
        if ($caso) {
            #TODO: Notificar via email a los usuarios correspondientes
            return response()->json([
                'estatus' => 1,
                'mensaje' => 'El caso se creo correctamente con el folio ' . $caso->num_case,
                'ticket' => $caso
            ]);
        } else {
            return response()->json([
                'estatus' => 0,
                'mensaje' => 'Error al intentar crear el registro por favor intente de nuevo.'
            ]);
        }
        return $this->generaFolio();
    }

    private function generaFolio()
    {
        $ultimo = Caso::orderBy('id', 'DESC')->first();
        return 'C-' . ($ultimo->id + 1);
    }

    private function prioridadToId($prioridad)
    {
        switch ($prioridad) {
            case 'Baja':
                return 1;
                break;
            case 'Media':
                return 2;
                break;
            case 'Alta':
                return 3;
                break;
            case 'Urgente':
                return 4;
                break;
            default:
                return 1;
                break;
        }
    }
}
