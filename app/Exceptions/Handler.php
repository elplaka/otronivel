<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // Interceptamos específicamente la excepción de "Página no encontrada"
        $this->renderable(function (NotFoundHttpException $e, $request) {

            // Verificamos si la petición viene de un entorno que espera JSON (como una API)
            // para no romper la respuesta si no es una navegación web
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Recurso no encontrado.'
                ], 404);
            }

            return response()->view('page_not_found', [], 404);
        });       
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TokenMismatchException) {
            // Opción A: Mostrar la vista personalizada directamente
            return response()->view('page_expired', [], 419);
            
            /* Nota: Si prefieres que el usuario vuelva al formulario automáticamente 
            pero con una alerta, usa el código que te funcionó antes. 
            Si prefieres que vea la pantalla institucional de "Sesión Expirada", usa la línea de arriba.
            */
        }

        return parent::render($request, $exception);
    }
}
