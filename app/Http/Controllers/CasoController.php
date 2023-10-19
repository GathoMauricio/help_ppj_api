<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caso;
use App\Models\SeguimientoCaso;
use App\Models\ArchivoCaso;
use App\Http\Controllers\NotificacionController;
use App\Models\TipoServicio;

class CasoController extends Controller
{
    public function apiObtenerCasosUsuario(Request $request)
    {
        $casos = Caso::where('status_id', '<', 3);
        $areas = explode(',', $request->selected_areas);
        $areas = array_diff($areas, array("", 0, null));
        //return $areas;
        if (count($areas) > 0) {
            $casos = $casos->where(function ($q) use ($areas) {
                foreach ($areas as $area) {
                    $q->orWhere('area_id', $area);
                }
            });
        }
        if (auth()->user()->user_rol_id == 3) {
            $casos = $casos->where('user_contact_id', auth()->user()->id)->orderBy('id', 'DESC');
        } else {
            $casos = $casos->orderBy('id', 'DESC');
        }
        // $casos = $casos->toSql();
        // return $casos;
        $casos = $casos->get();

        $datos = [];
        foreach ($casos as $caso) {
            $tipoServicio = TipoServicio::find($caso->service_id);
            $caso->area_id = $tipoServicio->area->id;
            if ($caso->status_id == null) {
                $caso->status_id = 1;
            }
            $caso->save();
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
                'created_at' => $caso->created_at,
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
            'created_at' => $caso->created_at,
            'seguimientos' => $seguimientos_datos,
            'archivos' => $archivos_datos,
        ]);
    }

    public function apiGuardarCaso(Request $request)
    {
        $tipoServicio = TipoServicio::find($request->tipoServicioId);
        $caso = Caso::create([
            'area_id' => $tipoServicio->area->id,
            'num_case' => $this->generaFolio(),
            'status_id' => 1,
            'service_id' => $request->tipoServicioId,
            'user_contact_id' => auth()->user()->id,
            'priority_case_id' => $this->prioridadToId($request->prioridad),
            'description' => $request->descripcion,
        ]);
        if ($caso) {
            $data = [
                'case_id' => $caso->id,
                'num_case' => $caso->num_case,
                'description' => $caso->description,
            ];
            NotificacionController::notificacionNuevoCaso($data);
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
    public function apiActualizarEstatusTicket(Request $request)
    {
        $caso = Caso::find($request->case_id);
        $caso->status_id = $this->estatusToId($request->estatus);
        if ($caso->save()) {
            $data = [
                'case_id' => $caso->case_id,
                'num_case' => $caso->num_case,
                'estatus' => $request->estatus,
                'user_contact_id' => $caso->user_contact_id
            ];
            NotificacionController::notificacionCambioEstatuso($data);
            return response()->json([
                'estatus' => 1,
                'mensaje' => 'El estatus se actualizó correctamente ' . $caso->num_case,
                'ticket' => $caso
            ]);
        } else {
            return response()->json([
                'estatus' => 0,
                'mensaje' => 'Fallo al actualizar el registro'
            ]);
        }
        return $request;
    }

    private function estatusToId($estatus)
    {
        switch ($estatus) {
            case 'Pendiente':
                return 1;
                break;
            case 'En progreso':
                return 2;
                break;
            case 'Cerrada':
                return 3;
                break;
        }
    }
}
