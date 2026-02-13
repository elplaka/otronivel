<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class PdfController extends Controller
{

    public function show($filename)
    {
        $rutaArchivo = $filename;
        $prefijo = substr($filename, 0, 2);
        if ($prefijo == 'CU') $rutaArchivo = 'curps/' . $filename;
        elseif ($prefijo == 'AC') $rutaArchivo = 'actas/' . $filename;
        elseif ($prefijo == 'CO') $rutaArchivo = 'comprobantes/' . $filename;
        elseif ($prefijo == 'ID') $rutaArchivo = 'identificaciones/' . $filename;
        elseif ($prefijo == 'KX') $rutaArchivo = 'kardex/' . $filename;
        elseif ($prefijo == 'CN') $rutaArchivo = 'constancias/' . $filename;

        if (Storage::exists($rutaArchivo)) {
            $archivo = Storage::path($rutaArchivo);
    
            // return response()->file($archivo);

            return response()->file($archivo, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'"'
            ]);
        } else {
            // Si el archivo NO existe, devolvemos el PDF de aviso
            $avisoPath = public_path('img/not_found.pdf');
            
            if (file_exists($avisoPath)) {
                return response()->file($avisoPath);
                
            }

            // Último recurso si ni el aviso existe
            abort(404);
                }
    }
}
