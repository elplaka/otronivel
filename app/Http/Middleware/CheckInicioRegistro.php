<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckInicioRegistro
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si la ruta '/2023-2024' ha sido visitada previamente
        if ($request->session()->has('visited_2023_2024')) {
            return $next($request);
        }

        // Verificar si la ruta actual es '/estudiantes/formulario-curp'
        if ($request->is('estudiantes/formulario-curp')) {
            // Si la ruta actual es '/estudiantes/formulario-curp', permitir la solicitud sin redirección
            return $next($request);
        }

        // Si no se ha visitado '/2023-2024' y la ruta actual no es '/estudiantes/formulario-curp',
        // redirigir al usuario a la ruta '/2023-2024'
        return redirect()->route('estudiantes.forget');
    }
}
