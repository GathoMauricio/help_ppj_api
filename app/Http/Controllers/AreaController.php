<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    public function apiObtenerAreas()
    {
        $areas = Area::orderBy('name')->get();
        return response()->json($areas);
    }
}
