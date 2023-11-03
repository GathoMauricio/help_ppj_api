<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caso;

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
    public function index()
    {
        $casos = Caso::where('status_id', '<', 3);
        if (auth()->user()->user_rol_id == 3) {
            $casos = $casos->where('user_contact_id', auth()->user()->id)->orderBy('id', 'DESC');
        } else {
            $casos = $casos->orderBy('id', 'DESC');
        }
        $casos = $casos->paginate(10);
        return view('home', compact('casos'));
    }
}
