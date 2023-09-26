<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoServicio;

class TipoServicioController extends Controller
{
    public function apiObtenerTiposServicio(Request $request)
    {
        $tiposServicio = TipoServicio::where('service_area_id', $request->service_area_id)->orderBy('name')->get();
        return response()->json($tiposServicio);
    }
}
