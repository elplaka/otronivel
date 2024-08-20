<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\EstudianteXT;
use App\Models\Ciclo;
use App\Models\Localidad;
use App\Models\Escuela;
use App\Models\Ciudad;
use App\Models\Turno;
use App\Models\Techo;
use App\Models\MontoMensual;
use App\Models\DatoSocioeconomico;
use App\Models\StatusEstudiante;
use App\Models\BoletosRemesa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PDF;
use Dompdf\Dompdf;  
use DOMDocument;
use App\Http\Requests\EstudianteUpdateRequest;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class EstudianteController extends Controller
{
    private $archivoCurp, $cicloR;

    private function calcula_ano($ano_2dig)
    {
        $ano_abs = abs($ano_2dig);

        if ($ano_abs < 50) $ano = "20" . $ano_2dig;    //Nacieron en los 2000's
        else $ano = "19" . $ano_2dig;  //Nacieron en los 1900's

        return $ano;
    }

    private function esCURP($curp)
    {
        $patron = "/^[A-Z]{4}\d{6}[HM][A-Z]{2}[B-DF-HJ-NP-TV-Z]{3}[A-Z0-9][0-9]$/";

        return preg_match($patron, $curp) == 1;
    }

    public function forget(Request $request)
    {
        $request->session()->forget('ciclo');
        $request->session()->forget('estudiante');
        $request->session()->forget('socioeconomico');
        $request->session()->forget('existente');
        $request->session()->forget('fcurp');
        $request->session()->forget('fdocumentos');
        $request->session()->forget('f2');
        $request->session()->forget('f3');
        $request->session()->forget('f3OK');
        $request->session()->forget('f4');
        $request->session()->forget('fconstancia');
        $request->session()->forget('fin');

        $ciclo = $this->getCiclo();

        $request->session()->put('ciclo', $ciclo);
        $request->session()->put('fcurp', true);

        return redirect()->route('estudiantes.formulario-curp');
    }

    public function getEstudiante($img_curp)
    {
        //Lee el archivo PDF y separa por párrafos
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($img_curp);
        $text = $pdf->getText();
        $parr = explode("\n", $text);

        $max_key = array_key_last($parr);  //Obtiene la última clave de un array

        $curp = ""; 

        //Dependiendo del archivo PDF del CURP hay varios tipos y la localización de los datos varía 
        switch($max_key)
        {
            case 29:
                $curp = $parr[11];
                $nombre_pdf = $parr[12];
                break;
            case 32:
                $curp = $parr[10];
                $nombre_pdf = $parr[11];
                break;
            case 33:
                $curp = $parr[11];
                if ($this->esCURP($curp)) $nombre_pdf = $parr[12];
                else
                {
                    $curp = $parr[10];
                    $nombre_pdf = $parr[8];
                }
                break;
            case 34:
                $curp = $parr[11];
                $nombre_pdf = $parr[9];
                break;   
        }

        $this->rfc = substr($curp, 0, 10);
        
        if ($this->esCURP($curp)) 
        {
            $estudiante = Estudiante::where('curp', $curp)
                        ->orderByDesc('id_ciclo')
                        ->first();


            if (isset($estudiante))   //SI YA SE HABÍA INSCRITO EN CICLOS PASADOS
            {
                $estudiante->img_curp = null;
                $estudiante->img_acta_nac = null;
                $estudiante->img_comprobante_dom = null;
                $estudiante->img_identificacion = null;
                $estudiante->img_kardex = null;
                $estudiante->img_constancia = null;
                $estudiante->rfc = substr($curp, 0, 10);
                return $estudiante;
            }
            else 
            {
                $estudiante = new Estudiante();

                $nombre_completo = explode(" ", $nombre_pdf);
                $max_key = array_key_last($nombre_completo);
                $nombre = '';
                for ($i=0; $i<=$max_key-2; $i++)
                {
                    $nombre = $nombre . ' ' . $nombre_completo[$i];
                }
                $estudiante->nombre = trim($nombre);
                $estudiante->primer_apellido = trim($nombre_completo[$max_key-1]);
                $estudiante->segundo_apellido = trim($nombre_completo[$max_key]);
    
                $estudiante->curp = $curp;
                $estudiante->rfc = substr($curp, 0, 10);
                $dia_nac = substr($curp, 8, 2);
                $mes_nac = substr($curp, 6, 2);
                $ano_nac = $this->calcula_ano(substr($curp, 4, 2));        
                $estudiante->fecha_nac = $ano_nac . '-' . $mes_nac . '-' . $dia_nac;
                $estudiante->cve_localidad_origen = 1;
                return $estudiante;
            }
        }
        else return false;
    }

    public function getCiclo()
    {
        $configFilePath = config_path('ciclo_actual.ini');
        $config = parse_ini_file($configFilePath, true);

        $cicloActual = $config['Ciclo']['CicloActual'];
        return $cicloActual;
    }

    public function getCicloDescripcion($id_ciclo)
    {
        $ciclo = Ciclo::findOrFail($id_ciclo);

        return $ciclo->descripcion;
    }

    public function formulario_curp(Request $request)
    {
        $ciclo = $this->getCiclo();

        $request->session()->put('ciclo', $ciclo);

        $fcurp = $request->session()->get('fcurp');

        $convocatoria_abierta = $this->convocatoria_abierta($ciclo);

        if ($fcurp)
        {
            $estudiante = $request->session()->get('estudiante');
            return view('estudiantes/formulario-curp',compact('estudiante', 'convocatoria_abierta'));

        }
        else return view('estudiantes/operacion_invalida');
    }

    public function nuevo_xt(Request $request)
    {
        $ciclo = $request->session()->get('ciclo');

        $estudiantes_xt = EstudianteXT::where('id_ciclo', $ciclo)->get();

        return view('estudiantes/nuevo_xt', compact('estudiantes_xt'));
    }

    public function existe_xt($id_ciclo, $curp)
    {
        $estudiante_xt = EstudianteXT::where('id_ciclo', $id_ciclo)->where('curp',$curp)->exists();

        return $estudiante_xt;
    }

    public function crea_xt(Request $request)
    {
        $ciclo = $request->session()->get('ciclo');

        $validatedData = $request->validate([
            'curp' => 'required|string|size:18',
        ]);

        $curp = trim(strtoupper($request->curp));

        if ($this->esCURP($curp)) 
        {
            if ($this->existe_xt($ciclo, $curp))
            {
                return redirect()->back()->with('message', 'CURP ya existe en el ciclo actual.')->with('tipo_msg', 'danger');
            }
            else
            {
                $estudianteXT = EstudianteXT::create([
                    'id_ciclo' => $ciclo,
                    'curp' => $curp,
                ]);
                return redirect()->back()->with('message', 'CURP agregado con éxito a los estudiantes extemporáneos.')->with('tipo_msg', 'success');
            }
        }
        else 
        {
            return redirect()->back()->with('message', 'El CURP no es válido.')->with('tipo_msg', 'danger');
        }
    }

    public function convocatoria_abierta($id_ciclo)
    {
        $ciclo = Ciclo::where('id_ciclo', $id_ciclo)->first();

        return $ciclo->convocatoria_abierta;
    }

    public function formulario_curpPost(Request $request)
    {
        $message = '';

        $validatedData = $request->validate([
            'img_curp' => ['file', 'max:1024'], // Aquí 'file' se asegura de que sea un archivo válido
        ], [
            'img_curp.max' => 'El archivo del <b> CURP </b> no debe pesar más de 1 MB.',
        ]);

        $extCurp = "ext";

        if (isset($request->img_curp)) 
        {
            $fileCurp = true;
            $extCurp = strtoupper($request->img_curp->getClientOriginalExtension());
        }
        else 
        {
            $fileCurp = false;
            if ($request->curp_hidden) {
                $extCurp = strtoupper(substr(strrchr($request->curp_hidden, "."), 1));
            }
        }

        if (!$fileCurp)
        {
            $message = $message . "<li>El archivo del <b>CURP</b> es obligatorio.</li>";
            $message = $message . "</ul>";
            return redirect()->back()->with('message', $message);
        }

        $errorCurp = false;
        if ($extCurp != "PDF") $errorCurp = true;
        if ($errorCurp)
        {
            $message = $message . "<li>El archivo del <b>CURP</b> debe ser PDF.</li>";
            $message = $message . "</ul>";
            return redirect()->back()->with('message', $message);
        }

        $estudiante = $this->getEstudiante($request->img_curp);
        if (!$estudiante)
        {
            $message = $message . "<li>El archivo del <b>CURP</b> no es válido.</li>";
            $message = $message . "</ul>";
            return redirect()->back()->with('message', $message);
        }

        $this->archivoCurp = $request->img_curp;
        $ciclo = $request->session()->get('ciclo');
        $convocatoria_abierta = $this->convocatoria_abierta($ciclo);

        if ($ciclo == $estudiante->id_ciclo)   //YA EXISTE EN EL CICLO ACTUAL
        {
            if ($estudiante->cve_status == 1 || $estudiante->cve_status == 2 || $estudiante->cve_status == 3 || $estudiante->cve_status == 6 || $estudiante->cve_status == 7)
            {
            $request->session()->put('existente', true);
            return redirect()->route('estudiantes.existente', $estudiante->id_hex);
            }
            else return view('estudiantes.convocatoria-cerrada'); 
        }

        if ($convocatoria_abierta || $this->existe_xt($ciclo, $estudiante->curp))
        {
            $request->session()->put('fcurp', false);
            $request->session()->put('f2', true);

            // COPIAR ARCHIVO A STORAGE
            $fileExtension = $request->img_curp->getClientOriginalExtension();
            $newFileName = "CU_" . $estudiante->rfc . '.' . $fileExtension;
            Storage::putFileAs('tmp', $request->img_curp, $newFileName);

            $estudiante->img_curp = $newFileName;

            $request->session()->put('estudiante', $estudiante);         

            return redirect()->route('estudiantes.formulario2'); 
        }
        else
        {
            return view('estudiantes.convocatoria-cerrada'); 
        }
    }

    public function existente(Request $request, $id_hex)
    {
        $existente = $request->session()->get('existente');
        if ($existente)
        {
            $estudiante = Estudiante::where('id_hex', $id_hex)->first();
            if (isset($estudiante))  //EXISTE EL ESTUDIANTE EN EL CICLO ACTUAL
            {
                $ciclo = $this->getCicloDescripcion($request->session()->get('ciclo'));
                $prox_remesa = BoletosRemesa::where('id_ciclo', $request->session()->get('ciclo'))->orderBy('fecha', 'desc')->first();
                $request->session()->put('estudiante', $estudiante);
                $request->session()->put('fconstancia', true);
                return view('estudiantes/existente', compact('ciclo', 'estudiante', 'prox_remesa'));
            }
            else return view('estudiantes/operacion_invalida');
        }
        else return view('estudiantes/operacion_invalida');
    }

    public function formulario2(Request $request)  //INFORMACIÓN PERSONAL
    {
        $f2 = $request->session()->get('f2');

        if ($f2)
        {
            $localidades = Localidad::orderBy('localidad', 'ASC')->get();
            $estudiante = $request->session()->get('estudiante');
            return view('estudiantes/formulario2', compact('estudiante', 'localidades'));
        }
        else return view('estudiantes/operacion_invalida');
    }

    public function formulario2Post(Request $request)
    {
        $id_ciclo = $request->session()->get('ciclo');

        $curp = $request->input('curp');

        $id_hex = Estudiante::where('curp', $curp)
        ->where('id_ciclo', $id_ciclo)
        ->value('id_hex');

        $validatedData = $request->validate([
            'nombre' => ['required', 'max:20'],
            'primer_apellido' => ['required', 'max:20'],
            'segundo_apellido' => ['required', 'max:20'],
            'curp' => [
                'required',
                Rule::unique('estudiantes')->where(function ($query) use ($id_ciclo) {
                    return $query->where('id_ciclo', $id_ciclo);
                }),
                'min:18',
                'max:18'
            ],
            'fecha_nac' => ['required'],
            'celular' => ['required', 'digits:10'],
            'email' => ['required', 'max:40'],
            'cve_localidad_origen' => ['required'],
        ], [
            'curp.unique' => 'El CURP ya está en uso para este ciclo escolar. Puedes ver la hoja de registro <a href="' . route('estudiantes.registro_pdf', ['id_hex' => $id_hex]) . '"> aquí </a>',
        ]);

        $validatedData = $request->except(['nombre', 'primer_apellido', 'segundo_apellido', 'email']);  //Se exceptúan porque se van a cambiar a mayúsculas después
        $nombre = trim(mb_strtoupper($request->nombre));
        $primer_apellido = trim(mb_strtoupper($request->primer_apellido));
        $segundo_apellido = trim(mb_strtoupper($request->segundo_apellido));
        $email = trim(mb_strtolower($request->email));

        $estudiante = $request->session()->get('estudiante');
        $estudiante->fill($validatedData);
        $estudiante->nombre = $nombre;
        $estudiante->primer_apellido = $primer_apellido;
        $estudiante->segundo_apellido = $segundo_apellido;
        $estudiante->email = $email;
        $request->session()->put('estudiante', $estudiante);

        $request->session()->put('f3', true);
        return redirect()->route('estudiantes.formulario3');
    }

    public function getAnoSiguiente($ano)
    {
        if ($ano <= 6) 
        {
            $ano++;
            return $ano;
        }
        else return 6;
    }

    public function formulario3(Request $request)  //INFORMACIÓN ESCOLAR
    {
        $f3 = $request->session()->get('f3');

        if ($f3)
        {
            // $escuelas = Escuela::orderBy('escuela', 'ASC')->get();
            $escuelas = Escuela::where('cve_escuela', '!=', '999')->orderBy('escuela', 'ASC')->get();
            $ciudades = Ciudad::all();
            $turnos = Turno::all();
            $estudiante = $request->session()->get('estudiante');
            $f3OK = $request->session()->get('f3OK');    
            if (!$f3OK)  //Si es la primera vez que se carga el formulario 3
            {
                $estudiante->ano_escolar = $this->getAnoSiguiente($estudiante->ano_escolar);
                $estudiante->promedio = 0.00;
            }
            $request->session()->put('f3OK', true);  //Ya se cargó el formulario 3 por primera vez
            $id_ciclo = $request->session()->get('ciclo');
            $cicloDescripcion = $this->getCicloDescripcion($id_ciclo);
            return view('estudiantes/formulario3', compact('estudiante', 'cicloDescripcion', 'escuelas', 'ciudades', 'turnos'));
        }
        else return view('estudiantes/operacion_invalida');
    }

    public function formulario3Post(Request $request)
    {
        $validatedData = $request->validate([
            'cve_ciudad_escuela' => ['required'], 
            'cve_escuela' => ['required'],        
            'cve_turno_escuela' => ['required'],  
            'carrera' => ['required', 'max:30'] ,             
            'ano_escolar' => ['required'],         
            'promedio' => ['required', 'numeric', 'between:0,10.0'],            
        ]);

        $validatedData = $request->except('carrera');  //Se exceptúa CARRERA porque se va a cambiar a mayúsculas después
        $carrera = trim(mb_strtoupper($request->carrera));

        $estudiante = $request->session()->get('estudiante');
        $estudiante->fill($validatedData);  //Se llena ESTUDIANTE con todos los campos validados excepto CARRERA
        $estudiante->carrera = $carrera;

        if(isset($estudiante->id))   //SI YA ES ESTUDIANTE DEL CICLO PASADO
        { 
            $socioeconomico = DatoSocioEconomico::where('id_estudiante', $estudiante->id)->first();
            $request->session()->put('socioeconomico', $socioeconomico);
        }

        $request->session()->put('estudiante', $estudiante);
        $request->session()->put('f4', true);
        return redirect()->route('estudiantes.formulario4');
    }

    public function formulario4(Request $request)
    {
        $f4 = $request->session()->get('f4');

        $estudiante = $request->session()->get('estudiante');
        $socioeconomico = $request->session()->get('socioeconomico');

        $techos = Techo::all();
        $montos = MontoMensual::all(); 
        if ($f4) return view('estudiantes/formulario4', compact('estudiante','socioeconomico','techos', 'montos'));
        else return view('estudiantes/operacion_invalida');  
    }

    public function formulario4Post(Request $request)
    {
        $validatedData = $request->validate([
            'cve_techo_vivienda' => ['required'], 
            'cuartos_vivienda' => ['required', 'numeric', 'between:1,20'],        
            'personas_vivienda' => ['required', 'numeric', 'between:1,20'],
            'cve_monto_mensual' => ['required'] ,
            'beca_estudios' => ['required'] ,             
            'apoyo_gobierno' => ['required'],         
            'empleo' => ['nullable', 'max:30'], 
            'gasto_transporte' => ['required', 'numeric', 'between:0,1000'],             
        ]);

        $validatedData = $request->except('empleo');  //Se exceptúa EMPLEO porque se va a cambiar a mayúsculas después
        $empleo = $request->empleo ? trim(mb_strtoupper($request->empleo)) : null;

        if ($request->select_empleo == 0) $empleo = '';

        if(empty($request->session()->get('socioeconomico')))
        {
            $socioeconomico = new DatoSocioeconomico;
            $socioeconomico->fill($validatedData);
        }
        else
        {
            $socioeconomico = $request->session()->get('socioeconomico');
            $socioeconomico->fill($validatedData);
        }
        $socioeconomico->empleo = $empleo;
        $request->session()->put('socioeconomico', $socioeconomico);

        $request->session()->put('fdocumentos', true);
        return redirect()->route('estudiantes.formulario-documentos');
    }

    public function formulario_documentos(Request $request)
    {
        $fdocumentos = $request->session()->get('fdocumentos');

        $estudiante = $request->session()->get('estudiante');
        if ($fdocumentos) return view('estudiantes/formulario-documentos',compact('estudiante'));
        else return view('estudiantes/operacion_invalida');
    }
  
    /**  
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function formulario_documentosPost(Request $request)
    {
        $validatedData = $request->validate([
            'img_acta_nac' => ['required', 'file','max:1024'],
            'img_comprobante_dom' => ['required', 'file', 'max:1024'],
            'img_identificacion' => ['required', 'file', 'max:1024'],
            'img_kardex' => ['required', 'file', 'max:1024'],
            ], [
                'img_acta_nac.required' => 'El campo <b>ACTA DE NACIMIENTO</b> es obligatorio.',
                'img_comprobante_dom.required' => 'El campo <b>COMPROBANTE DE DOMICILIO</b> es obligatorio.',
                'img_identificacion.required' => 'El campo <b>IDENTIFICACIÓN</b> es obligatorio.',
                'img_kardex.required' => 'El campo <b>KARDEX</b> es obligatorio.',
                'img_acta_nac.max' => 'El archivo del <b> ACTA DE NACIMIENTO </b> no debe pesar más de 1 MB.',
                'img_comprobante_dom.max' => 'El archivo del <b> COMPROBANTE DE DOMICILIO </b> no debe pesar más de 1 MB.',
                'img_identificacion.max' => 'El archivo de la <b> IDENTIFICACIÓN </b> no debe pesar más de 1 MB.',
                'img_kardex.max' => 'El archivo del <b> KARDEX </b> no debe pesar más de 1 MB.',
            ]);


        $actaCargada = false;
        $comprobanteCargado = false;
        $identificacionCargada = false;
        $kardexCargado = false;
        $constanciaCargada = false;

        $estudiante = $request->session()->get('estudiante');
     
        if (isset($request->img_acta_nac) || (isset($estudiante) && $estudiante->img_acta_nac == "ACTA_OK.pdf")) $actaCargada = true;
        if (isset($request->img_comprobante_dom) || (isset($estudiante) && $estudiante->img_comprobante_dom == "COMPROBANTE_OK.pdf")) $comprobanteCargado = true;
        if (isset($request->img_identificacion) || (isset($estudiante) && $estudiante->img_identificacion == "ID_OK.pdf")) $identificacionCargada = true;
        if (isset($request->img_kardex) || (isset($estudiante) && $estudiante->img_kardex == "KARDEX_OK.pdf")) $kardexCargado = true;
  
        if ($actaCargada) $extActa = "pdf";
        else $extActa = substr(strrchr($request->acta_hidden, "."), 1);
        if ($comprobanteCargado) $extComprobante = "pdf";
        else $extComprobante = substr(strrchr($request->comprobante_hidden, "."), 1);
        if ($identificacionCargada) $extIdentificacion = "pdf";
        else $extIdentificacion = substr(strrchr($request->identificacion_hidden, "."), 1);
        if ($kardexCargado) $extKardex = "pdf";
        else $extKardex = substr(strrchr($request->kardex_hidden, "."), 1);
        // if ($constanciaCargada) $extConstancia = "pdf";
        // else $extConstancia = substr(strrchr($request->constancia_hidden, "."), 1);

        if (isset($request->img_acta_nac)) $extActa = strtoupper($request->img_acta_nac->getClientOriginalExtension());
        if (isset($request->img_comprobante_dom)) $extComprobante = strtoupper($request->img_comprobante_dom->getClientOriginalExtension());
        if (isset($request->img_identificacion)) $extIdentificacion = strtoupper($request->img_identificacion->getClientOriginalExtension());
        if (isset($request->img_kardex)) $extKardex = strtoupper($request->img_kardex->getClientOriginalExtension());
        // if (isset($request->img_constancia)) $extConstancia = strtoupper($request->img_constancia->getClientOriginalExtension());

        $message = '<b>ERROR(ES) EN LA INFORMACIÓN: </b> <ul>';
        $errorActa = false;
        $errorComprobante = false;
        $errorIdentificacion = false;
        $errorKardex = false;
        $errorConstancia = false;

        //++++++++++++++++++++ VALIDACIÓN DE CAMPOS OBLIGATORIOS +++++++++++++++++++++
        if (!$actaCargada && $estudiante->img_acta_nac === null)
        {
            $message = $message . "<li>El <b>ACTA DE NACIMIENTO</b> es obligatoria.</li>";
            $errorActa = true;
        }
        if (!$comprobanteCargado && $estudiante->img_comprobante_dom === null)
        {
            $message = $message . "<li>El <b>COMPROBANTE DE DOMICILIO</b> es obligatorio.</li>";
            $errorComprobante = true;
        }
        if (!$identificacionCargada && $estudiante->img_identificacion === null)
        {
            $message = $message . "<li>La <b>IDENTIFICACIÓN OFICIAL</b> es obligatoria.</li>";
            $errorIdentificacion = true;
        }
        if (!$kardexCargado && $estudiante->img_kardex === null)
        {
            $message = $message . "<li>El <b>KARDEX</b> es obligatorio.</li>";
            $errorKardex = true;
        }
        // if (!$constanciaCargada && $request->constancia_hidden == "#constancia#")
        // {
        //     $message = $message . "<li>La <b>CONSTANCIA</b> es obligatoria.</li>";
        //     $errorConstancia = true;
        // }


        if (!$errorActa) $estudiante->img_acta_nac = "ACTA_OK." . $extActa;
        if (!$errorComprobante) $estudiante->img_comprobante_dom = "COMPROBANTE_OK." . $extComprobante;
        if (!$errorIdentificacion) $estudiante->img_identificacion = 'ID_OK.' . $extIdentificacion;
        if (!$errorKardex) $estudiante->img_kardex = "KARDEX_OK." . $extKardex;
        // if (!$errorConstancia) $estudiante->img_constancia = "CONSTANCIA_OK." . $extConstancia;
        $rfc = $estudiante->rfc;
        $time_int = time() * 999;
        $time_str = strval($time_int);
        $time_hex = dechex($time_str);
        $estudiante->id_hex = $time_hex;

        $message = $message . "</ul>";

        if ($errorActa || $errorComprobante || $errorIdentificacion || $errorKardex || $errorConstancia)
        {
            return redirect()->back()->with('message', $message);
        }

        //+++++++++++++++++++++++ VALIDACIÓN DE ARCHIVOS PDF ++++++++++++++++++++++++++++++
        if ($extActa != "PDF")
        {
            $message = $message . "<li>El archivo del <b>ACTA DE NACIMIENTO</b> debe ser PDF.</li>";
            $errorActa = true;
        }
        if ($extComprobante != "PDF")
        {
            $message = $message . "<li>El archivo del <b>COMPROBANTE DE DOMICILIO</b> debe ser PDF.</li>";
            $errorComprobante = true;
        }
        if ($extIdentificacion != "PDF")
        {
            $message = $message . "<li>El archivo de la <b>IDENTIFICACIÓN OFICIAL</b> debe ser PDF.</li>";
            $errorIdentificacion = true;
        }
        if ($extKardex != "PDF")
        {
            $message = $message . "<li>El archivo del <b>KARDEX</b> debe ser PDF.</li>";
            $errorKardex = true;
        }
        // if ($extConstancia != "PDF")
        // {
        //     $message = $message . "<li>El archivo de la <b>CONSTANCIA DE ESTUDIOS</b> debe ser PDF.</li>";
        //     $errorConstancia = true;
        // }        

        if ($errorActa || $errorComprobante || $errorIdentificacion || $errorKardex || $errorConstancia)
        {
            return redirect()->back()->with('message', $message);
        }
        
        $ciclo = $request->session()->get('ciclo');

        $estudianteCurp = Estudiante::where('id_ciclo', $ciclo)
                              ->where('curp', $estudiante->curp)
                              ->first();

        if ($estudianteCurp)  //Valida que ya no se inserte dos veces un estudiante
        {
            $request->session()->put('existente', true);
            return redirect()->route('estudiantes.existente', $estudianteCurp->id_hex);
        } 

        //Sólo se copiarán los archivos únicamente cuando estén cargados en el input
        if ($actaCargada) 
        {
            $newFileName = "AC_" . $estudiante->rfc . '.' . $extActa;
            Storage::putFileAs('actas', $request->img_acta_nac, $newFileName);
            $estudiante->img_acta_nac = $newFileName;
        }  
        if ($comprobanteCargado)
        {
            $newFileName = "CO_" . $estudiante->rfc . '.' . $extComprobante;
            Storage::putFileAs('comprobantes', $request->img_comprobante_dom, $newFileName);
            $estudiante->img_comprobante_dom = $newFileName;
        }
        if ($identificacionCargada)
        {
            $newFileName = "ID_" . $estudiante->rfc . '.' . $extIdentificacion;
            Storage::putFileAs('identificaciones', $request->img_identificacion, $newFileName);
            $estudiante->img_identificacion = $newFileName;
        }
        if ($kardexCargado)
        {
            $newFileName = "KX_" . $estudiante->rfc . '.' . $extKardex;
            Storage::putFileAs('kardex', $request->img_kardex, $newFileName);
            $estudiante->img_kardex = $newFileName;
        }
        if ($constanciaCargada)
        {
            $archivo = 'CN_' . $rfc . '.' . $extConstancia;
            $request->img_constancia->move('img/constancias', $archivo);
        }

         // Obtener la ruta del archivo original
        $archivoOriginal = 'tmp/' . $estudiante->img_curp;
        // Definir la ruta de destino
        $rutaDestino = 'curps/' . basename($archivoOriginal);

        // Mover el archivo a la carpeta de destino
        Storage::move($archivoOriginal, $rutaDestino);

        try {
            DB::beginTransaction();
        
            $request->session()->put('estudiante', $estudiante);
            $estudiante = $request->session()->get('estudiante');
            $socioeconomico = $request->session()->get('socioeconomico');
                
            // Crear una nueva instancia del modelo Estudiante
            $estudianteBD = new Estudiante;
    
            // Asignar los valores individualmente
            $estudianteBD->id_ciclo = $ciclo;
            $estudianteBD->nombre = $estudiante['nombre'];
            $estudianteBD->primer_apellido = $estudiante['primer_apellido'];
            $estudianteBD->segundo_apellido = $estudiante['segundo_apellido'];
            $estudianteBD->curp = $estudiante['curp'] ;
            $estudianteBD->rfc = $estudiante['rfc'];
            $estudianteBD->fecha_nac = $estudiante['fecha_nac'];
            $estudianteBD->celular = $estudiante['celular'];
            $estudianteBD->email = $estudiante['email'];
            $estudianteBD->cve_localidad_origen = $estudiante['cve_localidad_origen'];
            $estudianteBD->cve_localidad_actual = 1;
            $estudianteBD->cve_ciudad_escuela = $estudiante['cve_ciudad_escuela'];
            $estudianteBD->cve_escuela = $estudiante['cve_escuela'];
            $estudianteBD->cve_turno_escuela = $estudiante['cve_turno_escuela'];
            $estudianteBD->carrera = $estudiante['carrera'];
            $estudianteBD->ano_escolar = $estudiante['ano_escolar'];
            $estudianteBD->promedio = $estudiante['promedio'];
            $estudianteBD->img_curp = $estudiante['img_curp'];
            $estudianteBD->img_acta_nac = $estudiante['img_acta_nac'];
            $estudianteBD->img_comprobante_dom = $estudiante['img_comprobante_dom'];
            $estudianteBD->img_identificacion = $estudiante['img_identificacion'];
            $estudianteBD->img_kardex = $estudiante['img_kardex'];
            $estudianteBD->img_constancia = "PENDIENTE";
            $estudianteBD->id_hex = $estudiante['id_hex'];  
        
            // Guardar el estudiante en la base de datos
            $estudianteBD->save();
        
            $id_estudiante = DB::getPdo()->lastInsertId();   //Obtiene el ID recién guardado 
            $estudiante->id = $id_estudiante;
        
            $request->session()->put('estudiante', $estudiante);
        
            $socioeconomicoBD = new DatoSocioeconomico;
            $socioeconomicoBD->id_estudiante = $id_estudiante;
            $socioeconomicoBD->cve_techo_vivienda = $socioeconomico['cve_techo_vivienda'];
            $socioeconomicoBD->cuartos_vivienda = $socioeconomico['cuartos_vivienda'];
            $socioeconomicoBD->personas_vivienda = $socioeconomico['personas_vivienda'];
            $socioeconomicoBD->cve_monto_mensual = $socioeconomico['cve_monto_mensual'];
            $socioeconomicoBD->beca_estudios = $socioeconomico['beca_estudios'];
            $socioeconomicoBD->apoyo_gobierno = $socioeconomico['apoyo_gobierno'];
            $socioeconomicoBD->empleo = $socioeconomico['empleo'];
            $socioeconomicoBD->gasto_transporte = $socioeconomico['gasto_transporte'];
            $socioeconomicoBD->observaciones = $socioeconomico['observaciones'];
        
            $socioeconomicoBD->save();
        
            $request->session()->put('fdocumentos', false);
            $request->session()->put('fin', true);
        
            DB::commit(); // Confirmar la transacción si todas las operaciones fueron exitosas

            return redirect()->route('estudiantes.mail_confirmacion', $estudiante->id);
        } catch (\Exception $e) {
            DB::rollBack(); // Deshacer todas las operaciones si ocurrió alguna excepción
            throw $e; // Relanzar la excepción para que puedas manejarla en otro lugar si es necesario
        }
    }

    public function formulario_constancia(Request $request, $id_hex)
    {
        $estudiante = Estudiante::where('id_hex', $id_hex)->first();
        $request->session()->put('estudiante', $estudiante);
        $fconstancia = $request->session()->get('fconstancia');
        if ($fconstancia) return view('estudiantes/formulario-constancia',compact('estudiante'));
        else return redirect()->route('estudiantes.forget');
        $request->session()->put('ff', true);
        $request->session()->put('fconstancia', false);
    }
    
    public function formulario_constancia_post(Request $request)
    {
        $validatedData = $request->validate([
            'img_constancia' => ['required_with:alpha_dash', 'max:1024'],
        ]);

        $constanciaCargada = false;

        $estudiante = $request->session()->get('estudiante');

        if (isset($request->img_constancia) || (isset($estudiante) && $estudiante->img_constancia != "PENDIENTE")) $constanciaCargada = true;

        if ($constanciaCargada) $extConstancia = "pdf";
        else $extConstancia = substr(strrchr($request->constancia_hidden, "."), 1);

        $extConstancia = strtoupper($extConstancia);

        if (isset($request->img_constancia)) $extConstancia = strtoupper($request->img_constancia->getClientOriginalExtension());

        $message = '<b>ERROR(ES) EN LA INFORMACIÓN: </b> <ul>';
        $errorConstancia = false;

        if (!$constanciaCargada && $request->constancia_hidden == "PENDIENTE")
        {
            $message = $message . "<li>La <b>CONSTANCIA</b> es obligatoria.</li>";
            $errorConstancia = true;
        }

        if ($extConstancia != "PDF")
        {
            $message = $message . "<li>El archivo de la <b>CONSTANCIA DE ESTUDIOS</b> debe ser PDF.</li>";
            $errorConstancia = true;
        }

        $message = $message . "</ul>";

        $rfc = $estudiante->rfc;

        if ($errorConstancia) return redirect()->back()->with('message', $message);

        if ($constanciaCargada)
        {
            $newFileName = "CN_" . $estudiante->rfc . '.' . $extConstancia;
            Storage::putFileAs('constancias', $request->img_constancia, $newFileName);
            $estudiante->img_constancia = $newFileName;
        }
        
        $estudiante->img_constancia = $newFileName;
        $estudiante->save();
        
        $request->session()->put('estudiante', $estudiante);

        return view('estudiantes.info_actualizada');
    }

    public function mail_folio()
    {
        return redirect()->route('estudiantes.mail_folio');
    }

    public function folios_enviados($folios)
    {
        return view('estudiantes/folios_enviados')->with('folios', $folios);
    }

    public function formulario_enviado(Request $request)
    {
        $fin = $request->session()->get('fin');

        $request->session()->forget('fdocumentos');
        $request->session()->forget('f2');
        $request->session()->forget('f3');
        $request->session()->forget('f4');

        if ($fin) return view('estudiantes/formulario_enviado');
        else return view('estudiantes/operacion_invalida');
    }

    public function registro_pdf(Request $request)
    {
        $estudiante = $request->session()->get('estudiante');
        if (isset($estudiante))
        {
            $id_estudiante = $estudiante->id;

            $estudiante = Estudiante::where('id', $id_estudiante)->first();
            $socioeconomico = DatoSocioeconomico::where('id_estudiante', $id_estudiante)->first();
            $pdf = PDF::loadView('estudiantes.registro_pdf',['estudiante'=>$estudiante, 'socioeconomico'=>$socioeconomico]);
            $pdf->setPaper("Letter", "portrait");
            return $pdf->stream('alivianate.pdf');

            return view('estudiantes.registro_pdf');
        }
        else return view('estudiantes/operacion_invalida');
    }

    public function registro_pdf_post($id_hex)
    {
        $estudiante = Estudiante::where('id_hex', $id_hex)->first();
        if (isset($estudiante))
        {
            $id_estudiante = $estudiante->id;
            $socioeconomico = DatoSocioeconomico::where('id_estudiante', $id_estudiante)->first();
            $pdf = PDF::loadView('estudiantes.registro_pdf',['estudiante'=>$estudiante, 'socioeconomico'=>$socioeconomico]);
            $pdf->setPaper("Letter", "portrait");
            return $pdf->stream('alivianate.pdf');
            return view('estudiantes.registro_pdf');
        }
        else return view('estudiantes/operacion_invalida');     
    }

    public function registro(Request $request, $id_hex)
    {
        $cicloR = $this->getCiclo();

        $estudiante = Estudiante::where('id_ciclo', $cicloR)->where('id_hex', $id_hex)->first();
        if (isset($estudiante))
        {
            $id_estudiante = $estudiante->id;
            $socioeconomico = DatoSocioeconomico::where('id_estudiante', $id_estudiante)->first();
            $request->session()->put('fconstancia', true);
            return view('estudiantes.registro', compact('estudiante', 'socioeconomico'));
        }
        else return view('estudiantes/operacion_invalida'); 
    }

    public function __construct()
    {
        // Código a ejecutar cuando la página se carga por primera vez
        $this->cicloR[0] = $this->getCiclo();
    }

    public function index(Request $request)
    {
        session(['busqueda_params' => $request->all()]);

        $status = StatusEstudiante::all();
        $escuelas = Escuela::where('cve_escuela', '!=', 999)->orderBy('escuela_abreviatura')->get();
        $ciudades = Ciudad::all();
        $localidades = Localidad::orderBy('localidad')->get();
        $turnos = Turno::all();
        $ciclos = Ciclo::all();

        $searchR = mb_strtoupper(isset($request->search) ? $request->search: "");
        $statusR = $request->selStatus;
        $cve_escuelaR = $request->selEscuela;
        $cve_ciudadR = $request->selCiudad;
        $carreraR = mb_strtoupper(isset($request->searchCarrera) ? $request->searchCarrera: "");
        $cve_localidadOR = $request->selLocalidadO;
        $cve_turnoR = $request->selTurno;
        $ano_escolarR = $request->selAnoEscolar;
        $promedioR = $request->selPromedio;
        $socioeconomicaR = $request->selSocioeconomica;
        $orderBy1R = $request->selOrderBy1;
        $documentacionR = $request->selDocumentacion;
        $observacionesAdminR = $request->observacionesAdmin;
        $cicloR = isset($request->selCiclo) ? $request->selCiclo : $this->cicloR;

        $totEstudiantes = Estudiante::select('id_ciclo', \DB::raw('count(*) as total_estudiantes'))
            ->whereIn('id_ciclo', $cicloR)
            ->groupBy('id_ciclo')
            ->get()
            ->pluck('total_estudiantes', 'id_ciclo')
            ->toArray();

        $estudiantes = Estudiante::where(function($query) use($request){
            if (isset($request->selCiclo))
            {
                $cicloR = $request->selCiclo;
                $query->whereIn('id_ciclo', $cicloR);
            }
            else
            {
                $cicloR = $this->cicloR;
                $query->whereIn('id_ciclo', $cicloR);
            }
            if (isset($request->selStatus))
            {
                $statusR = $request->selStatus;
                $query->whereIn('cve_status', $statusR); 
            }
            if (isset($request->selEscuela))
            {
                $cve_escuelaR = $request->selEscuela;
                $query->whereIn('cve_escuela', $cve_escuelaR); 
            }
            if (isset($request->selLocalidadO))
            {
                $cve_localidadOR = $request->selLocalidadO;
                $query->whereIn('cve_localidad_origen', $cve_localidadOR); 
            }
            if (isset($request->selTurno))
            {
                $cve_turnoR = $request->selTurno;
                $query->whereIn('cve_turno_escuela', $cve_turnoR); 
            }
            if (isset($request->selAnoEscolar))
            {
                $ano_escolarR = $request->selAnoEscolar;
                $query->whereIn('ano_escolar', $ano_escolarR); 
            }
            if (isset($request->selCiudad))
            {
                if (strlen($request->selCiudad) > 0)
                {
                    $cve_ciudadR = $request->selCiudad;
                    $query->where('cve_ciudad_escuela', $cve_ciudadR); 
                }
            }
            if (isset($request->searchCarrera))
            {
                $query->where('carrera','like',"%{$request->searchCarrera}%"); 
            }
            if (isset($request->selDocumentacion))
            {
                $selDocumentacion = $request->selDocumentacion;
                if ($selDocumentacion == 1)  $query->where('img_constancia', '!=', "PENDIENTE");
                elseif ($selDocumentacion == 2)  $query->where('img_constancia', 'PENDIENTE');
            }
            if (isset($request->observacionesAdmin))
            {
                $query->where('observaciones_admin','like',"%{$request->observacionesAdmin}%"); 
            }
         });

         if (isset($request->search))
         {
            $estudiantes = $estudiantes->where(function($query) use($request){
                $query->where('nombre','like',"%{$request->search}%")->orWhere('primer_apellido', 'like',"%{$request->search}%")->orWhere('segundo_apellido', 'like',"%{$request->search}%"); 
            });
        }


         if (isset($request->selPromedio))
         {
            $estudiantes = $estudiantes->where(function($query) use($request){
                $promedioR = $request->selPromedio;
                foreach($promedioR as $promR)
                {
                    switch ($promR)
                    {
                        case 1:
                            $query->whereBetween('promedio', [9, 10]);
                            break;
                        case 2:
                            $query->orwhereBetween('promedio', [8, 9]);
                            break;
                        case 3:
                            $query->orwhereBetween('promedio', [7, 8]);
                            break;
                        case 4:
                            $query->orwhereBetween('promedio', [6, 7]);
                            break;
                        case 5:
                            $query->orwhereBetween('promedio', [5, 6]);
                            break;
                        case 6:
                            $query->orwhereBetween('promedio', '<', 6);
                            break;
                    }
                }
            });
        }
        if (isset($request->selSocioeconomica))
        {
            if ($socioeconomicaR == 1)
            {
                $estudiantes->leftjoin('datos_socioeconomicos', function ($join)
                {
                    $join->on('estudiantes.id', 'datos_socioeconomicos.id_estudiante');
                })->whereRaw('TRIM(datos_socioeconomicos.observaciones) IS NULL');
            }
            elseif ($socioeconomicaR == 2)
            {
                $estudiantes->leftjoin('datos_socioeconomicos', function ($join)
                {
                    $join->on('estudiantes.id', 'datos_socioeconomicos.id_estudiante');
                })->whereRaw('datos_socioeconomicos.observaciones IS NOT NULL');
            }
        }
      
        //Obtiene los ids de la consulta para usarlos en el reporte PDF
        $ids_estudiantes = $estudiantes->get('id');
        $ids_reporte = $ids_estudiantes->toArray();
        $request->session()->put('ids_reporte', $ids_reporte);
        $request->session()->put('orderBy1', $orderBy1R);

        if (isset($request->selOrderBy1))
        {
            switch($orderBy1R)  
            {
                case 0: //NOMBRE
                    $estudiantes = $estudiantes->orderBy('nombre');
                    break;
                case 1:  //APELLIDOS
                    $estudiantes = $estudiantes->orderBy('primer_apellido')->orderBy('segundo_apellido');
                    break;
                case 2: //ESCUELA
                    $estudiantes = $estudiantes->orderBy('cve_escuela')->orderBy('cve_ciudad_escuela');
                    break;
                case 3:  //CARRERA
                    $estudiantes = $estudiantes->orderBy('carrera')->orderBy('cve_escuela')->orderBy('cve_ciudad_escuela');
                    break;
                case 4:  //CIUDAD ESCUELA
                    // Sirve para ordenar primero por la carrera y después por el nombre de la escuela. Está más fácil de armar el query pero no es tan óptimo
                    // $estudiantes = $estudiantes->orderBy('cve_ciudad_escuela')->orderBy(Escuela::select('escuela')->whereColumn('escuelas.cve_escuela', 'estudiantes.cve_escuela'));

                    // Sirve para ordenar primero por la carrera y después por el nombre de la escuela.
                    $estudiantes = $estudiantes->select(['estudiantes.*', 'escuelas.escuela as nombre_escuela'])
                                   ->join('escuelas', 'estudiantes.cve_escuela', '=', 'escuelas.cve_escuela')
                                   ->orderBy('estudiantes.cve_ciudad_escuela')->orderBy('nombre_escuela');
                    break;
                case 5:  //TURNO ESCUELA
                    $estudiantes = $estudiantes->orderBy('cve_turno_escuela')->orderBy('carrera');
                    break;
                case 6:  //AÑO ESCOLAR
                    $estudiantes = $estudiantes->orderBy('ano_escolar')->orderBy('carrera');
                    break;
                case 7:  //PROMEDIO
                    $estudiantes = $estudiantes->orderBy('promedio','desc')->orderBy('primer_apellido')->orderBy('segundo_apellido');
                    break;
                case 8:  //LUGAR ORIGEN
                    $estudiantes = $estudiantes->select(['estudiantes.*', 'localidades.localidad as nombre_localidad'])
                    ->join('localidades', 'estudiantes.cve_localidad_origen', '=', 'localidades.cve_localidad')
                    ->orderBy('nombre_localidad')->orderBy('primer_apellido')->orderBy('segundo_apellido');
                    break;
            }
        }

        $estudiantes = $estudiantes->paginate(25)->withQueryString();

        return view('estudiantes.index', compact(
            'estudiantes', 'totEstudiantes', 'searchR', 'status', 
            'statusR', 'escuelas', 'cve_escuelaR', 'ciudades',
            'cve_ciudadR', 'carreraR', 'localidades', 'cve_localidadOR', 
            'turnos', 'cve_turnoR', 'ano_escolarR', 'promedioR', 'socioeconomicaR', 'orderBy1R', 'documentacionR', 'ciclos', 'cicloR', 'observacionesAdminR'));
    }

    public function ver_constancia(Request $request)
    {
        $nombreArchivo = $request->input('archivo');
        $rutaArchivo = 'constancias/' . $nombreArchivo;
        $clave = $request->input('key');
    
        // Verificar si la clave es válida
        if ($clave !== hash('sha256', $nombreArchivo)) {
            // Clave no válida, devolver una respuesta de error o redireccionar a una página de error
            abort(403, 'Acceso no autorizado');
        }
    
        if (Storage::exists($rutaArchivo)) {
            $archivo = Storage::path($rutaArchivo);
    
            return response()->file($archivo);
        } else {
            // Archivo no encontrado, devolver una respuesta de error o redireccionar a una página de error
            abort(404, 'Archivo no encontrado');
        }
    }
      
    public function edit($id)
    {
        $estudiante = Estudiante::where('id', $id)->first();
        $localidades = Localidad::orderBy('localidad', 'ASC')->get();
        $escuelas = Escuela::where('cve_escuela', '!=', '999')->orderBy('escuela_abreviatura', 'ASC')->get();
        $ciudades = Ciudad::all();
        $turnos = Turno::all();
        $status = StatusEstudiante::all();
        return view('estudiantes.edit', compact('estudiante', 'localidades', 'escuelas', 'ciudades', 'turnos', 'status'));
    }

    public function update(EstudianteUpdateRequest $request, $id)
    {
        $estudiante = Estudiante::findorfail($id);

        $curpCargado = true;
        $actaCargada = false;
        $comprobanteCargado = false;
        $identificacionCargada = false;
        $kardexCargado = false;
        $constanciaCargada = false;


        $archivoConstancia = $estudiante->img_constancia;

        if (isset($request->img_acta_nac)) $actaCargada = true;
        if (isset($request->img_comprobante_dom)) $comprobanteCargado = true;
        if (isset($request->img_identificacion)) $identificacionCargada = true;
        if (isset($request->img_kardex)) $kardexCargado = true;
        if (isset($request->img_constancia)) $constanciaCargada = true;

        if ($actaCargada) 
        {
            $extActa = strtoupper($request->img_acta_nac->getClientOriginalExtension());
            $newFileName = "AC_" . $estudiante->rfc . '.' . $extActa;
            Storage::putFileAs('actas', $request->img_acta_nac, $newFileName);
            $estudiante->img_acta_nac = $newFileName;
            $archivoActa = $newFileName;
        }  
        if ($comprobanteCargado)
        {
            $extComprobante = strtoupper($request->img_comprobante_dom->getClientOriginalExtension());
            $newFileName = "CO_" . $estudiante->rfc . '.' . $extComprobante;
            Storage::putFileAs('comprobantes', $request->img_comprobante_dom, $newFileName);
            $estudiante->img_comprobante_dom = $newFileName;
            $archivoComprobante = $newFileName;
        }
        if ($identificacionCargada)
        {
            $extIdentificacion = strtoupper($request->img_identificacion->getClientOriginalExtension());
            $newFileName = "ID_" . $estudiante->rfc . '.' . $extIdentificacion;
            Storage::putFileAs('identificaciones', $request->img_identificacion, $newFileName);
            $estudiante->img_identificacion = $newFileName;
            $archivoIdentificacion = $newFileName;
            //cómo regresar una vista?
        }
        if ($kardexCargado)
        {
            $extKardex = strtoupper($request->img_kardex->getClientOriginalExtension());
            $newFileName = "KX_" . $estudiante->rfc . '.' . $extKardex;
            Storage::putFileAs('kardex', $request->img_kardex, $newFileName);
            $archivoKardex = $newFileName;
        }
        if ($constanciaCargada)
        {
            $extConstancia = strtoupper($request->img_constancia->getClientOriginalExtension());
            $newFileName = "CN_" . $estudiante->rfc . '.' . $extConstancia;
            Storage::putFileAs('constancias', $request->img_constancia, $newFileName);
            $archivoConstancia = $newFileName;
        }

        $observacionesEstudiante = $request->observaciones_estudiante ?? null;
        $observacionesAdmin = $request->observaciones_admin ?? null;

        if ($observacionesEstudiante !== null) {
            $observacionesEstudiante = strlen($observacionesEstudiante) ? trim(mb_strtoupper($observacionesEstudiante)) : null;
        }

        if ($observacionesAdmin !== null) {
            $observacionesAdmin = strlen($observacionesAdmin) ? trim(mb_strtoupper($observacionesAdmin)) : null;
        }

        $estudiante->update([
            'nombre' => trim(mb_strtoupper($request->nombre)),
            'primer_apellido' => trim(mb_strtoupper($request->primer_apellido)),
            'segundo_apellido' => trim(mb_strtoupper($request->segundo_apellido)),
            // 'curp' => trim(mb_strtoupper($request->curp)),
            // 'rfc' => $rfc,
            'fecha_nac' => $request->fecha_nac,
            'celular' => $request->celular,
            'email' => trim(mb_strtolower($request->email)),
            'cve_localidad_origen' => $request->cve_localidad_origen,
            'cve_localidad_actual' => 1,
            'cve_ciudad_escuela' => $request->cve_ciudad_escuela,
            'cve_escuela' => $request->cve_escuela,
            'cve_turno_escuela' => $request->cve_turno_escuela,
            'carrera' => trim(mb_strtoupper($request->carrera)),
            'ano_escolar' => $request->ano_escolar,
            'promedio' => $request->promedio,
            // 'img_curp' => $archivoCurp,
            // 'img_acta_nac' => $archivoActa,
            // 'img_comprobante_dom' => $archivoComprobante,
            // 'img_identificacion' => $archivoIdentificacion,
            // 'img_kardex' => $archivoKardex,
            'img_constancia' => $archivoConstancia,
            'observaciones_estudiante' => $observacionesEstudiante,
            'observaciones_admin' => $observacionesAdmin,
            'cve_status' => $request->cve_status
        ]);

        // return redirect()->route('estudiantes.index')->with('message', 'Estudiante ACTUALIZADO con éxito!')->with('msg_type', 'success');

        $busquedaParams = session('busqueda_params', []);

        // Redirige de vuelta a la página de lista con los parámetros de búsqueda
        return redirect()->route('estudiantes.index', $busquedaParams)
            ->with('message', 'Estudiante ACTUALIZADO con éxito!')
            ->with('msg_type', 'success');

    }

    public function getColorForOption($index) {
        $colors = ['#f2f2f2', '#ffd700', '#7fffd4', '#8a2be2', '#008000', '#ff4500'];
        
        // Asegúrate de que $index esté dentro del rango de colores disponibles
        $colorIndex = $index % count($colors);
        
        return $colors[$colorIndex];
    }

    public function edit_status($id)
    {
        $estudiante = Estudiante::where('id', $id)->first();
        $escuelas = Escuela::where('cve_escuela', '!=', '999')->orderBy('escuela_abreviatura', 'ASC')->get();
        $ciudades = Ciudad::all();
        $status = StatusEstudiante::all();
        return view('estudiantes.edit_status', compact('estudiante', 'escuelas', 'ciudades', 'status'));
    }

    public function update_status(Request $request, $id)
    {
        $estudiante = Estudiante::findorfail($id);

        $estudiante->update([
            'cve_status' => $request->cve_status
        ]);

        return redirect()->route('estudiantes.index')->with('message', 'Estatus ACTUALIZADO con éxito!')->with('msg_type', 'success');
    }

    public function edit_socioeconomicos($id)
    {
        $estudiante = Estudiante::where('id', $id)->first();
        $techos = Techo::all();
        $montos = MontoMensual::all(); 

        return view('estudiantes.edit_se', compact('estudiante', 'techos', 'montos'));
    }

    public function censar(Request $request, $id)
    {
        $validatedData = $request->validate([
            'observaciones' => ['max:255'], 
        ]);

        $observaciones = mb_strtoupper(trim($request->observaciones));

        
        $estudiante = Estudiante::where('id', $id)->first();
        if (isset($observaciones) && strlen(trim($observaciones)) > 0)  //Actualiza el campo de observaciones sólo cuando haya texto
        {
            $estudiante->socioeconomico->update([
                'observaciones' => $observaciones
            ]);
        }

        if ($estudiante->cve_status == 2)  //Si tiene estatus de REVISADO 
        {
            $estudiante->update([
                'cve_status' => 3  //Estatus de CENSADO
            ]);
        }

        return redirect()->route('estudiantes.index')->with('message', 'Estudiante CENSADO con éxito!')->with('msg_type', 'success');
    }

    public function pdf(Request $request)
    {
        $ids_reporte = $request->session()->get('ids_reporte');
        $orderBy1 = $request->session()->get('orderBy1');

        $tituloReporte = $request->tituloReporte;

        $estudiantes_reporte = Estudiante::whereIn('id', $ids_reporte); 

        if (isset($orderBy1))
        {
            switch($orderBy1)  
            {
                case 0: //NOMBRE
                    $estudiantes_reporte = $estudiantes_reporte->orderBy('nombre');
                    break;
                case 1:  //APELLIDOS
                    $estudiantes_reporte = $estudiantes_reporte->orderBy('primer_apellido')->orderBy('segundo_apellido');
                    break;
                case 2: //ESCUELA
                    $estudiantes_reporte = $estudiantes_reporte->orderBy('cve_escuela')->orderBy('cve_ciudad_escuela');
                    break;
                case 3:  //CARRERA
                    $estudiantes_reporte = $estudiantes_reporte->orderBy('carrera')->orderBy('cve_escuela')->orderBy('cve_ciudad_escuela');
                    break;
                case 4:  //CIUDAD ESCUELA
                    $estudiantes_reporte = $estudiantes_reporte->select(['estudiantes.*', 'escuelas.escuela as nombre_escuela'])
                                   ->join('escuelas', 'estudiantes.cve_escuela', '=', 'escuelas.cve_escuela')
                                   ->orderBy('estudiantes.cve_ciudad_escuela')->orderBy('nombre_escuela');
                    break;
                case 5:  //TURNO ESCUELA
                    $estudiantes_reporte = $estudiantes_reporte->orderBy('cve_turno_escuela')->orderBy('carrera');
                    break;
                case 6:  //AÑO ESCOLAR
                    $estudiantes_reporte = $estudiantes_reporte->orderBy('ano_escolar')->orderBy('carrera');
                    break;
                case 7:  //PROMEDIO
                    $estudiantes_reporte = $estudiantes_reporte->orderBy('promedio','desc')->orderBy('primer_apellido')->orderBy('segundo_apellido');
                    break;
                case 8:  //LUGAR ORIGEN
                    $estudiantes_reporte = $estudiantes_reporte->select(['estudiantes.*', 'localidades.localidad as nombre_localidad'])
                    ->join('localidades', 'estudiantes.cve_localidad_origen', '=', 'localidades.cve_localidad')
                    ->orderBy('nombre_localidad')->orderBy('primer_apellido')->orderBy('segundo_apellido');
                    break;
            }
        }

            // METER WHERE A LA CONSULTA DIRECTV
        // $estudiantes_reporte = Estudiante::select('*')
        // ->whereRaw('cve_localidad_origen <> cve_localidad_actual')
        // ->get();

        // return view('estudiantes.reporte_pdf', compact('estudiantes_reporte', 'tituloReporte'));


        $pdf = PDF::loadView('estudiantes.reporte_pdf',['estudiantes_reporte'=>$estudiantes_reporte->get(), 'tituloReporte'=>$tituloReporte]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    public function download_zip(Request $request, $id)
    {
        $zip = new ZipArchive;
        
        $estudiante = Estudiante::findOrFail($id);
    
        $fileName = $estudiante->primer_apellido . '_' . $estudiante->segundo_apellido . '_' .$estudiante->nombre . '_docs_' . $id . '.zip';
    
        $zipFilePath = public_path($fileName);
    
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE)
        {
            $files = [
                'curps/' . $estudiante->img_curp,
                'actas/' . substr($estudiante->img_acta_nac, 0, -3) . strtoupper(substr($estudiante->img_acta_nac, -3)),
                'comprobantes/' . substr($estudiante->img_comprobante_dom, 0, -3) . strtoupper(substr($estudiante->img_comprobante_dom, -3)),
                'identificaciones/' . substr($estudiante->img_identificacion, 0, -3) . strtoupper(substr($estudiante->img_identificacion, -3)),
                'kardex/' . substr($estudiante->img_kardex, 0, -3) . strtoupper(substr($estudiante->img_kardex, -3)),
            ];
    
            if ($estudiante->img_constancia != "PENDIENTE") {
                $files[] = 'constancias/' . $estudiante->img_constancia;
            }
    
            foreach ($files as $file) {
                    // Obtén el contenido del archivo desde el disco local
                    $fileContents = Storage::disk('local')->get($file);

                    // Si el archivo tiene contenido, agrégalo al archivo ZIP
                    if (!empty($fileContents)) {
                        $relativeNameInZipFile = basename($file);
                        $zip->addFromString($relativeNameInZipFile, $fileContents);
                    }
            }
    
            $zip->close();
        }
    
        return response()->download($zipFilePath)->deleteFileAfterSend(true);;
    }

    public function padron()
    {
        return view('estudiantes.padron');
    }

    public function padron_pdf(Request $request)
    {

        $id_ciclo = $request->id_ciclo;
        $todos = $request->chkTodos;

        if ($id_ciclo == 1)
        {
            $remesas = [1, 2, 3, 4];
            $ciclo = '2223';
        }
        elseif ($id_ciclo == 2)
        {
            $remesas = [5, 6, 7, 8];
            $ciclo = '2223';
        }
        elseif ($id_ciclo == 3)
        {
            $remesas = [11, 12];
            $ciclo = '2324';
        }

        if ($id_ciclo == -1)
        {
            $ciclo = '2223';
            $cicloEscolar = "2022-2023";

            $estudiantes_reporte = Estudiante::where('id_ciclo', $ciclo)
            // ->where(function ($query) {
            //     $query->has('boletosAsignados')
            //         ->orWhereHas('apoyosAsignados');
            // })
            ->whereIn('cve_status', [1, 2, 3])
            ->orderBy('primer_apellido')
            ->orderBy('segundo_apellido')
            ->orderBy('nombre')
            ->get();
        }

        if ($id_ciclo == -2)
        {
            $ciclo = '2324';
            $cicloEscolar = "2023-2024";

            if ($todos)
            {
                $estudiantes_reporte = Estudiante::where('id_ciclo', $ciclo)
                ->where(function ($query) {
                    $query->has('boletosAsignados')
                        ->orWhereHas('apoyosAsignados');
                })
                ->orderBy('primer_apellido')
                ->orderBy('segundo_apellido')
                ->orderBy('nombre')
                ->get();
            }
            else
            {
                $estudiantes_reporte = Estudiante::where('id_ciclo', $ciclo)
                ->where(function ($query) {
                    $query->has('boletosAsignados')
                        ->orWhereHas('apoyosAsignados');
                })
                ->where('cve_escuela', '!=', 999)
                ->orderBy('primer_apellido')
                ->orderBy('segundo_apellido')
                ->orderBy('nombre')
                ->get();
            }
        }

        $tituloReporte = "Padrón de beneficiarios del Ciclo Escolar " . $cicloEscolar;

        $pdf = PDF::loadView('estudiantes.padron_pdf',['estudiantes_reporte'=>$estudiantes_reporte, 'tituloReporte'=>$tituloReporte]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();

    }
}  
