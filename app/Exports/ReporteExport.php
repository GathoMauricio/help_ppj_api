<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Caso;

class ReporteExport implements FromView
{
    private $inicio;
    private $final;

    public function __construct($inicio, $final)
    {
        $this->inicio = $inicio;
        $this->final = $final;
    }

    public function view(): View
    {
        $casos = Caso::whereBetween('created_at', [$this->inicio . " 00:00:00", $this->final . " 23:59:59"])->get();
        return view('exports.reporte', ['casos' => $casos]);
    }
}
