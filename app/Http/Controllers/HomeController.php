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
    
    public function getCiclo()
    {
        $configFilePath = config_path('ciclo_actual.ini');  //Carpeta CONFIG
        $config = parse_ini_file($configFilePath, true);

        $cicloActual = $config['Ciclo']['CicloActual'];
        return $cicloActual;
    }
             

    public function index(Request $request)
    {
     
        $ciclo = $this->getCiclo();
        $request->session()->put('ciclo', $ciclo); 

        return view('home');
    }
}
