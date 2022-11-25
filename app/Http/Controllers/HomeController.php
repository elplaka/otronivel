<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    public function index(Request $request)
    {
        //$archivo = "/sistemas/alivianate/resources/views/globales.ini";
        //$contenido = parse_ini_file($archivo, true);
        //$ciclo = $contenido["Ciclo Escolar"]["CicloActivo"];
        $ciclo = "2223";
        $request->session()->put('ciclo', $ciclo); 

        return view('home');
    }
}
