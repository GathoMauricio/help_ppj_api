<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caso;
use App\Models\TipoServicio;

class AreaCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $casos = Caso::all();

        foreach ($casos as $caso) {
            dump($caso);
            if ($caso->service_id) {
                $tipoServicio = TipoServicio::find($caso->service_id);
                $caso->area_id = $tipoServicio->area->id;
                $caso->save();
            } else {
                $caso->service_id = 1;
                $caso->save();
            }
        }
    }
}
