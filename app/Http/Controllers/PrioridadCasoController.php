<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrioridadCaso;

class PrioridadCasoController extends Controller
{
    public function apiObtenerPrioridadesCaso(Request $request)
    {
        $prioridadesCasos = PrioridadCaso::orderBy('id')->get();
        return response()->json($prioridadesCasos);
    }
}
