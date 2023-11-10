<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ReporteExport;

class ReportesController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function generarReporte(Request $request)
    {
        return \Excel::download(new ReporteExport($request->inicio, $request->final), 'reporte_' . $request->inicio . '_' . $request->final . '.xlsx');
    }
}
