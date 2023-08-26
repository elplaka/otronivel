<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

     protected function getCiclo()
     {
         $configFilePath = config_path('ciclo_actual.ini');
         $config = parse_ini_file($configFilePath, true);
 
         $cicloActual = $config['Ciclo']['CicloActual'];
         return $cicloActual;
     }

    protected function redirectTo($request)
    {
        $ciclo = $this->getCiclo();
        $request->session()->put('ciclo', $ciclo);

        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
