<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caso;
use App\Models\User;
use App\Models\Area;
use App\Models\EstatusCaso;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($selected_area = null)
    {
        $casos = Caso::where('status_id', '<', 3);
        if ($selected_area) {
            $casos = $casos->where('area_id', $selected_area);
        }
        $tecnicos = User::where('user_rol_id', 2)->get();
        if (auth()->user()->user_rol_id == 3) {
            $casos = $casos->where('user_contact_id', auth()->user()->id)->orderBy('id', 'DESC');
        } else {
            $casos = $casos->orderBy('id', 'DESC');
        }
        $casos = $casos->paginate(10);
        $areas = Area::orderBy('name')->get();
        $estatuses = EstatusCaso::all();
        return view('home', compact('casos', 'tecnicos', 'areas', 'selected_area', 'estatuses'));
    }
}
