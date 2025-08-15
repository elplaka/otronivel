<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstudianteUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nombre' => ['required', 'max:20'],
            'primer_apellido' => ['required', 'max:20'],
            'segundo_apellido' => ['required', 'max:20'],
            'curp' => ['required', 'min:18', 'max:18'],
            'fecha_nac' => ['required'],
            'celular' => ['required', 'digits:10'],
            'email' => ['required', 'max:40'],
            'cve_localidad_origen' => ['required'],
            // 'cve_localidad_actual' => ['required'],
            'cve_ciudad_escuela' => ['required'], 
            'cve_escuela' => ['required'],        
            'cve_turno_escuela' => ['required'],  
            'carrera' => ['required', 'max:30'] ,             
            'ano_escolar' => ['required'],         
            'promedio' => ['required', 'numeric', 'between:0,10.0'],  
            'curp_hidden' => ['required', 'max:25'],
            'acta_hidden' => ['required_with:alpha_dash', 'max:25'],
            'comprobante_hidden' => ['required', 'max:25'],
            'identificacion_hidden' => ['required', 'max:25'],
            'kardex_hidden' => ['required', 'max:25'],
            'constancia_hidden' => ['required', 'max:25'],
            // 'img_curp' => ['max:2000']
            'observaciones_estudiante' => ['max:50'],
            'observaciones_admin' => ['max:50'],
        ];
    }
}
