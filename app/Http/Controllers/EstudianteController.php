<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Localidad;
use App\Models\Escuela;
use App\Models\Ciudad;
use App\Models\Turno;
use App\Models\Techo;
use App\Models\MontoMensual;
use App\Models\DatoSocioeconomico;
use App\Models\StatusEstudiante;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PDF;
use Dompdf\Dompdf;  
use DOMDocument;
use App\Http\Requests\EstudianteUpdateRequest;


class EstudianteController extends Controller
{
    private function calcula_ano($ano_2dig)
    {
        $ano_abs = abs($ano_2dig);

        if ($ano_abs < 50) $ano = "20" . $ano_2dig;    //Nacieron en los 2000's
        else $ano = "19" . $ano_2dig;  //Nacieron en los 1900's

        return $ano;
    }

    private function esCURP($rfc)
    {
        $chars = str_split($rfc);

        if (ctype_upper($chars[0]) && ctype_upper($chars[1]) && ctype_upper($chars[2]) && ctype_upper($chars[3]))
        {
            if (is_numeric($chars[4]) && is_numeric($chars[5]) && is_numeric($chars[6]) && is_numeric($chars[7]) && is_numeric($chars[8]) && is_numeric($chars[9])) return true;
            else return false;
        }
        else return false;
    }

    private function generaRfcAleatorio($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function sacaRFC($img_curp)
    {
        $nomArchivo = '_' . $this->generaRfcAleatorio(9);
        $archivo = $nomArchivo . '.' . $img_curp->getClientOriginalExtension();
        $img_curp->move('img/tmp', $archivo);
        $bandera = "#curp#";

        //Lee el archivo PDF y separa por párrafos
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile('img/tmp/' . $archivo);
        $text = $pdf->getText();
        $parr = explode("\n", $text);

        $max_key = array_key_last($parr);  //Obtiene la última clave de un array

        if ($max_key < 11)  //Si no hubo 11 párrafos entonces no es un pdf de curp de los recientes
        {
            $rfc = $nomArchivo;
            rename('img/tmp/' . $archivo, 'img/curps/' . 'CU_' . $rfc . '.pdf');
            return $rfc;
        }
        else
        {
            $curp = $parr[11];
            $rfc = substr($curp, 0, 10);
            if ($this->esCURP($rfc)) 
            {
                rename('img/tmp/' . $archivo, 'img/curps/' . 'CU_' . $rfc . '.pdf');
                return $rfc;
            }
            else
            {
                $rfc = $nomArchivo;
                rename('img/tmp/' . $archivo, 'img/curps/' . 'CU_' . $rfc . '.pdf');
                return $rfc;
            }
        }
    }

    private function esValidoArchivoCURP($img_curp, &$rfc, $fileCurp)
    {
        if ($fileCurp) $rfc = $this->sacaRFC($img_curp); //Si se cargó el archivo en el input copia pdf y saca rfc
        else return false;

        $primer_car = substr($rfc,0,1);
        if (!isset($rfc) ||  $primer_car == '_') return false;
        else return true;
    }

    public function forget(Request $request)
    {
        $request->session()->forget('estudiante');
        $request->session()->forget('socioeconomico');
        $request->session()->forget('f1');
        $request->session()->forget('f2');
        $request->session()->forget('f3');
        $request->session()->forget('f4');
        $request->session()->forget('fin');

        $request->session()->put('f1', true);

        return redirect()->route('estudiantes.formulario1');
    }
     /**
     * Show the step One Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function formulario1(Request $request)
    {
        $request->session()->put('f2', false);
        $request->session()->put('f3', false);
        $request->session()->put('f4', false);
        $request->session()->put('fin', false);

        $f1 = $request->session()->get('f1');

        if ($f1)
        {
            $estudiante = $request->session()->get('estudiante');
            return view('estudiantes/formulario1',compact('estudiante'));
        }
        else return view('estudiantes/operacion_invalida');
    }
  
    /**  
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function formulario1Post(Request $request)
    {
        $validatedData = $request->validate([
            'img_curp' => ['required_with:alpha_dash', 'max:2000'],
            'img_acta_nac' => ['required_with:alpha_dash', 'max:2000'],
            'img_comprobante_dom' => ['required_with:alpha_dash', 'max:2000'],
            'img_identificacion' => ['required_with:alpha_dash', 'max:2000'],
            'img_kardex' => ['required_with:alpha_dash', 'max:2000'],
            'img_constancia' => ['required_with:alpha_dash', 'max:2000'],
        ]);

        $actaCargada = false;
        $comprobanteCargado = false;
        $identificacionCargada = false;
        $kardexCargado = false;
        $constanciaCargada = false;

        $extCurp = "ext";

        $estudiante = $request->session()->get('estudiante');

        //if ($actaCargada) $extActa = $request->img_acta_nac->getClientOriginalExtension();

        if (isset($request->img_acta_nac) || (isset($estudiante) && $estudiante->img_acta_nac == "ACTA_OK.pdf")) $actaCargada = true;
        if (isset($request->img_comprobante_dom) || (isset($estudiante) && $estudiante->img_comprobante_dom == "COMPROBANTE_OK.pdf")) $comprobanteCargado = true;
        if (isset($request->img_identificacion) || (isset($estudiante) && $estudiante->img_identificacion == "ID_OK.pdf")) $identificacionCargada = true;
        if (isset($request->img_kardex) || (isset($estudiante) && $estudiante->img_kardex == "KARDEX_OK.pdf")) $kardexCargado = true;
        // if (isset($request->img_constancia) || (isset($estudiante) && $estudiante->img_constancia == "CONSTANCIA_OK.pdf")) $constanciaCargada = true;

        if (isset($request->img_curp)) 
        {
            $fileCurp = true;
            $extCurp = strtoupper($request->img_curp->getClientOriginalExtension());
        }
        else 
        {
            $fileCurp = false;
            $extCurp = strtoupper(substr(strrchr($request->curp_hidden, "."), 1));
        }

        //dd($extCurp);
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
        $errorCurp = false;
        $errorActa = false;
        $errorComprobante = false;
        $errorIdentificacion = false;
        $errorKardex = false;
        $errorConstancia = false;

        //+++++++++++++++++++++++ VALIDACIÓN DE ARCHIVOS PDF ++++++++++++++++++++++++++++++
        if ($extCurp != "PDF")
        {
            //$message = $message . "<li>El archivo del <b>CURP</b> debe ser PDF.</li>";
            $errorCurp = true;
        }
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

        // if ($errorCurp || $errorActa || $errorComprobante || $errorIdentificacion || $errorKardex || $errorConstancia)
        // {
        //     return redirect()->back()->with('message', $message);
        // }

        //++++++++++++++++++++ VALIDACIÓN DE CAMPOS OBLIGATORIOS +++++++++++++++++++++
        if (!$actaCargada && $request->acta_hidden == "#acta#")
        {
            $message = $message . "<li>El <b>ACTA DE NACIMIENTO</b> es obligatoria.</li>";
            $errorActa = true;
        }
        if (!$comprobanteCargado && $request->comprobante_hidden == "#comprobante#")
        {
            $message = $message . "<li>El <b>COMPROBANTE DE DOMICILIO</b> es obligatorio.</li>";
            $errorComprobante = true;
        }
        if (!$identificacionCargada && $request->identificacion_hidden == "#identificacion#")
        {
            $message = $message . "<li>La <b>IDENTIFICACIÓN OFICIAL</b> es obligatoria.</li>";
            $errorIdentificacion = true;
        }
        if (!$kardexCargado && $request->kardex_hidden == "#kardex#")
        {
            $message = $message . "<li>El <b>KARDEX</b> es obligatorio.</li>";
            $errorKardex = true;
        }
        // if (!$constanciaCargada && $request->constancia_hidden == "#constancia#")
        // {
        //     $message = $message . "<li>La <b>CONSTANCIA</b> es obligatoria.</li>";
        //     $errorConstancia = true;
        // }

        $message = $message . "</ul>";

        if ($errorCurp)
        {
            $message = '<b>ERROR(ES) EN LA INFORMACIÓN: </b> <ul>';
            $message = $message . "<li>El archivo del <b>CURP</b> debe ser PDF.</li>";
            $message = $message . "</ul>";
            $message = $message . "NOTA: Todos los campos son <b>obligatorios</b> y debes subir <b>archivos PDF</b>.";
            return redirect()->back()->with('message', $message);
        }

        if ($this->esValidoArchivoCURP($request->img_curp, $rfc, $fileCurp)) //Valida que el PDF cargado sea el esperado
        {
            if(empty($request->session()->get('estudiante')))
            {
                $estudiante = new Estudiante();
                $estudiante->img_curp = "CURP_OK.pdf";
                if (!$errorActa) $estudiante->img_acta_nac = "ACTA_OK." . $extActa;
                if (!$errorComprobante) $estudiante->img_comprobante_dom = "COMPROBANTE_OK." . $extComprobante;
                if (!$errorIdentificacion) $estudiante->img_identificacion = 'ID_OK.' . $extIdentificacion;
                if (!$errorKardex) $estudiante->img_kardex = "KARDEX_OK." . $extKardex;
                // if (!$errorConstancia) $estudiante->img_constancia = "CONSTANCIA_OK." . $extConstancia;
                $estudiante->rfc = $rfc;
                $estudiante->cve_localidad_origen = 1;
                $estudiante->cve_localidad_actual = 1;
                $request->session()->put('estudiante', $estudiante);
            }
            else
            {
                $estudiante = $request->session()->get('estudiante');
                $estudiante->img_curp = "CURP_OK.pdf";
                if (!$errorActa) $estudiante->img_acta_nac = "ACTA_OK." . $extActa;
                if (!$errorComprobante) $estudiante->img_comprobante_dom = "COMPROBANTE_OK." . $extComprobante;
                if (!$errorIdentificacion) $estudiante->img_identificacion = 'ID_OK.' . $extIdentificacion;
                if (!$errorKardex) $estudiante->img_kardex = "KARDEX_OK." . $extKardex;
                // if (!$errorConstancia) $estudiante->img_constancia = "CONSTANCIA_OK." . $extConstancia;
                if ($fileCurp) $estudiante->rfc = $rfc;
                $rfc = $estudiante->rfc;
                $request->session()->put('estudiante', $estudiante);
            }
            $parser = new \Smalot\PdfParser\Parser();
            
            $pdf = $parser->parseFile('img/curps/CU_'. $rfc . ".pdf");
            $text = $pdf->getText();
            $parr = explode("\n", $text);

            $nombre_completo = explode(" ", $parr[12]);
            $max_key = array_key_last($nombre_completo);
            $nombre = '';
            for ($i=0; $i<=$max_key-2; $i++)
            {
                $nombre = $nombre . ' ' . $nombre_completo[$i];
            }
            $estudiante->nombre = trim($nombre);
            $estudiante->primer_apellido = trim($nombre_completo[$max_key-1]);
            $estudiante->segundo_apellido = trim($nombre_completo[$max_key]);

            $curp = $parr[11];
            $estudiante->curp = $curp;
            $dia_nac = substr($curp, 8, 2);
            $mes_nac = substr($curp, 6, 2);
            $ano_nac = $this->calcula_ano(substr($curp, 4, 2));

            $estudiante->fecha_nac = $ano_nac . '-' . $mes_nac . '-' . $dia_nac;

            //Sólo se copiarán los archivos únicamente cuando estén cargados en el input
            if ($actaCargada) 
            {
                $archivo = 'AC_' . $rfc . '.' . $extActa;
                $request->img_acta_nac->move('img/actas', $archivo);
            }  
            if ($comprobanteCargado)
            {
                $archivo = 'CO_' . $rfc . '.' . $extComprobante;
                $request->img_comprobante_dom->move('img/comprobantes', $archivo);
            }
            if ($identificacionCargada)
            {
                $archivo = 'ID_' . $rfc . '.' . $extIdentificacion;
                $request->img_identificacion->move('img/identificaciones', $archivo);
            }
            if ($kardexCargado)
            {
                $archivo = 'KX_' . $rfc . '.' . $extKardex;
                $request->img_kardex->move('img/kardex', $archivo);
            }
            // if ($constanciaCargada)
            // {
            //     $archivo = 'CN_' . $rfc . '.' . $extConstancia;
            //     $request->img_constancia->move('img/constancias', $archivo);
            // }
            if ($errorCurp || $errorActa || $errorComprobante || $errorIdentificacion || $errorKardex || $errorConstancia) return redirect()->back()->with('message', $message);

            $request->session()->put('f1', false);
            $request->session()->put('f2', true);
            return redirect()->route('estudiantes.formulario2');
        }
        else //Si no es válido el archivo PDF del CURP
        {
            if($fileCurp)  //Si se cargó el pdf en el input del CURP 
            {
                $estudiante = new Estudiante();
               
                //Sólo se copiarán los archivos únicamente cuando estén cargados en el input
                if ($actaCargada) 
                {
                    if ($estudiante->img_acta_nac != "ACTA_OK.PDF")  //Si no se había subido el archivo previamente
                    {
                        $archivo = 'AC_' . $rfc . '.' . $extActa;
                        $request->img_acta_nac->move('img/actas', $archivo);
                    }
                }  
                if ($comprobanteCargado)
                {
                    if ($estudiante->img_comprobante_dom != "COMPROBANTE_OK.PDF")  //Si no se había subido el archivo previamente
                    {
                        $archivo = 'CO_' . $rfc . '.' . $extComprobante;
                        $request->img_comprobante_dom->move('img/comprobantes', $archivo);
                    }
                }
                if ($identificacionCargada)
                {
                    if ($estudiante->img_identificacion != "ID_OK.PDF")  //Si no se había subido el archivo previamente
                    {
                        $archivo = 'ID_' . $rfc . '.' . $extIdentificacion;
                        $request->img_identificacion->move('img/identificaciones', $archivo);
                    }
                }
                if ($kardexCargado)
                {
                    if ($estudiante->img_kardex != "KARDEX_OK.PDF")  //Si no se había subido el archivo previamente
                    {
                        $archivo = 'KX_' . $rfc . '.' . $extKardex;
                        $request->img_kardex->move('img/kardex', $archivo);
                    }
                }
                // if ($constanciaCargada)
                // {
                //     if ($estudiante->img_constancia != "CONSTANCIA_OK.pdf")  //Si no se había subido el archivo previamente
                //     {
                //         $archivo = 'CN_' . $rfc . '.' . $extConstancia;
                //         $request->img_constancia->move('img/constancias', $archivo);
                //     }
                // }

                $estudiante = $request->session()->get('estudiante');
                if (!isset($estudiante)) $estudiante = new Estudiante();
                $estudiante->img_curp = "CURP_OK.pdf";
                if (!$errorActa) $estudiante->img_acta_nac = "ACTA_OK." . $extActa;
                if (!$errorComprobante) $estudiante->img_comprobante_dom = "COMPROBANTE_OK." . $extComprobante;
                if (!$errorIdentificacion) $estudiante->img_identificacion = 'ID_OK.' . $extIdentificacion;
                if (!$errorKardex) $estudiante->img_kardex = "KARDEX_OK." . $extKardex;
                // if (!$errorConstancia) $estudiante->img_constancia = "CONSTANCIA_OK." . $extConstancia;
                $estudiante->rfc = $rfc;
                $estudiante->cve_localidad_origen = 1;
                $estudiante->cve_localidad_actual = 1;
                $request->session()->put('estudiante', $estudiante);

                if ($errorActa || $errorComprobante || $errorIdentificacion || $errorKardex || $errorConstancia) return redirect()->back()->with('message', $message);

                $request->session()->put('f1', false);
                $request->session()->put('f2', true);
                return redirect()->route('estudiantes.formulario2');                  
            }
            else  //Indica que en esta ocasión no se cargó el CURP en el input el archivo pero...
            {
                if (isset($estudiante) && strlen($estudiante->rfc) == 10) $rfc = $estudiante->rfc;  //Si ya se extrajo el rfc del pdf
                else $rfc = "probando123"; //Si no es un archivo de curp pdf válido va a tomar otro rfc
                
                if (isset($estudiante) && $estudiante->img_curp == 'CURP_OK.pdf')  //Significa que ya se había cargado el archivo del CURP previamente
                {
                    //Sólo se copiarán los archivos únicamente cuando estén cargados en el input
                    if ($actaCargada) 
                    {
                        if ($estudiante->img_acta_nac != "ACTA_OK.pdf")  //Si no se había subido el archivo previamente
                        {
                            $archivo = 'AC_' . $rfc . '.' . $extActa;
                            $request->img_acta_nac->move('img/actas', $archivo);
                        }
                    }  
                    if ($comprobanteCargado)
                    {
                        if ($estudiante->img_comprobante_dom != "COMPROBANTE_OK.pdf")  //Si no se había subido el archivo previamente
                        {
                            $archivo = 'CO_' . $rfc . '.' . $extComprobante;
                            $request->img_comprobante_dom->move('img/comprobantes', $archivo);
                        }
                    }
                    if ($identificacionCargada)
                    {
                        if ($estudiante->img_identificacion != "ID_OK.pdf")  //Si no se había subido el archivo previamente
                        {
                            $archivo = 'ID_' . $rfc . '.' . $extIdentificacion;
                            $request->img_identificacion->move('img/identificaciones', $archivo);
                        }
                    }
                    if ($kardexCargado)
                    {
                        if ($estudiante->img_kardex != "KARDEX_OK.pdf")  //Si no se había subido el archivo previamente
                        {
                            $archivo = 'KX_' . $rfc . '.' . $extKardex;
                            $request->img_kardex->move('img/kardex', $archivo);
                        }
                    }
                    // if ($constanciaCargada)
                    // {
                    //     if ($estudiante->img_constancia != "CONSTANCIA_OK.pdf")  //Si no se había subido el archivo previamente
                    //     {
                    //         $archivo = 'CN_' . $rfc . '.' . $extConstancia;
                    //         $request->img_constancia->move('img/constancias', $archivo);
                    //     }
                    // }

                    // if(empty($request->session()->get('estudiante')))
                    // {
                    //     $estudiante = new Estudiante();
                    //     if (!$errorActa) $estudiante->img_acta_nac = "ACTA_OK." . $extActa;
                    //     if (!$errorComprobante) $estudiante->img_comprobante_dom = "COMPROBANTE_OK." . $extComprobante;
                    //     if (!$errorIdentificacion) $estudiante->img_identificacion = 'ID_OK.' . $extIdentificacion;
                    //     if (!$errorKardex) $estudiante->img_kardex = "KARDEX_OK." . $extKardex;
                    //     // if (!$errorConstancia) $estudiante->img_constancia = "CONSTANCIA_OK." . $extConstancia;
                    //     $request->session()->put('estudiante', $estudiante);
                    // }
                    // else
                    // {
                        $estudiante = $request->session()->get('estudiante');
                        if (!$errorActa) $estudiante->img_acta_nac = "ACTA_OK." . $extActa;
                        if (!$errorComprobante) $estudiante->img_comprobante_dom = "COMPROBANTE_OK." . $extComprobante;
                        if (!$errorIdentificacion) $estudiante->img_identificacion = 'ID_OK.' . $extIdentificacion;
                        if (!$errorKardex) $estudiante->img_kardex = "KARDEX_OK." . $extKardex;
                        // if (!$errorConstancia) $estudiante->img_constancia = "CONSTANCIA_OK." . $extConstancia;
                        $request->session()->put('estudiante', $estudiante);
                    // }

                    if ($errorActa || $errorComprobante || $errorIdentificacion || $errorKardex || $errorConstancia) return redirect()->back()->with('message', $message);

                    $request->session()->put('f2', true);
                    return redirect()->route('estudiantes.formulario2');  
                }
                else return redirect()->back()->with('message', '¡ERROR! :: Primeramente selecciona el <b>archivo PDF del CURP</b>');
            }
            // if ($fileCurp) return redirect()->back()->with('message', 'Error en el archivo PDF del CURP. Intente subiendo otro archivo.');
            // else return redirect()->back()->with('message', '¡ERROR! :: Selecciona el <b>archivo PDF del CURP</b>');
        }
    }

    public function formulario2(Request $request)
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
        $validatedData = $request->validate([
            'nombre' => ['required', 'max:20'],
            'primer_apellido' => ['required', 'max:20'],
            'segundo_apellido' => ['required', 'max:20'],
            'curp' => ['required', 'unique:estudiantes', 'min:18', 'max:18'],
            'fecha_nac' => ['required'],
            'celular' => ['required', 'digits:10'],
            'email' => ['required', 'max:40'],
            'cve_localidad_origen' => ['required'],
            'cve_localidad_actual' => ['required'],
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


    public function formulario3(Request $request)
    {
        $f3 = $request->session()->get('f3');

        if ($f3)
        {
            // $escuelas = Escuela::orderBy('escuela', 'ASC')->get();
            $escuelas = Escuela::where('cve_escuela', '!=', '999')->orderBy('escuela', 'ASC')->get();
            $ciudades = Ciudad::all();
            $turnos = Turno::all();
            $estudiante = $request->session()->get('estudiante');
            return view('estudiantes/formulario3', compact('estudiante', 'escuelas', 'ciudades', 'turnos'));
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

        $request->session()->put('estudiante', $estudiante);
        $request->session()->put('f4', true);
        return redirect()->route('estudiantes.formulario4');
    }

    public function formulario4(Request $request)
    {
        $f4 = $request->session()->get('f4');

        $socioeconomico = $request->session()->get('socioeconomico');
        $techos = Techo::all();
        $montos = MontoMensual::all(); 
        if ($f4) return view('estudiantes/formulario4', compact('socioeconomico','techos', 'montos'));
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
        $empleo = trim(mb_strtoupper($request->empleo));

        $estudiante = $request->session()->get('estudiante');
        $rfc = $estudiante->rfc;
        $estudiante->img_curp =             'CU_' . $rfc . '.pdf';
        $estudiante->img_acta_nac =         'AC_' . $rfc . '.pdf';
        $estudiante->img_comprobante_dom =  'CO_' . $rfc . '.pdf';
        $estudiante->img_identificacion =   'ID_' . $rfc . '.pdf';
        $estudiante->img_kardex =           'KX_' . $rfc . '.pdf';
        //$estudiante->img_constancia =       'CN_' . $rfc . '.pdf';

        $time_int = time() * 999;
        $time_str = strval($time_int);
        $time_hex = dechex($time_str);
        $estudiante->id_hex = $time_hex;

        $request->session()->put('estudiante', $estudiante);
        DB::beginTransaction();
        try
        {
            $estudiante->save();

            $id_estudiante = DB::getPdo()->lastInsertId();   //Obtiene el ID recién guardado 
            if(empty($request->session()->get('socioeconomico')))
            {
                $socioeconomico = new DatoSocioeconomico;
                $socioeconomico->fill($validatedData);
                $socioeconomico->id_estudiante = $id_estudiante;
            }
            else
            {
                $socioeconomico = $request->session()->get('socioeconomico');
                $socioeconomico->fill($validatedData);
            }

            $socioeconomico->empleo = $empleo;
            $request->session()->put('socioeconomico', $socioeconomico);
            $socioeconomico->save();

            DB::commit();

            $request->session()->put('fin', true);
            return redirect()->route('estudiantes.mail_confirmacion', $estudiante->id);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
    }

    public function formulario_enviado(Request $request)
    {
        $fin = $request->session()->get('fin');

        //// $request->session()->forget('estudiante');
        //// $request->session()->forget('socioeconomico');

        $request->session()->forget('f1');
        $request->session()->forget('f2');
        $request->session()->forget('f3');
        $request->session()->forget('f4');
        //// $request->session()->forget('fin');

        if ($fin) return view('estudiantes/formulario_enviado');
        else return view('estudiantes/operacion_invalida');
    }

    public function registro_pdf(Request $request)
    {
        $estudiante = $request->session()->get('estudiante');
        $id_estudiante = $estudiante->id;

        $estudiante = Estudiante::where('id', $id_estudiante)->first();
        $socioeconomico = DatoSocioeconomico::where('id_estudiante', $id_estudiante)->first();
        $pdf = PDF::loadView('estudiantes.registro_pdf',['estudiante'=>$estudiante, 'socioeconomico'=>$socioeconomico]);
        $pdf->setPaper("Letter", "portrait");
        return $pdf->stream('alivianate.pdf');

        return view('estudiantes.registro_pdf');
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

    public function registro($id_hex)
    {
        $estudiante = Estudiante::where('id_hex', $id_hex)->first();
        if (isset($estudiante))
        {
            $id_estudiante = $estudiante->id;
            $socioeconomico = DatoSocioeconomico::where('id_estudiante', $id_estudiante)->first();
            return view('estudiantes.registro', compact('estudiante', 'socioeconomico'));
        }
        else return view('estudiantes/operacion_invalida'); 
    }

    public function index(Request $request)
    {
        $estudiantes = Estudiante::all();
        $searchR = "";

        if ($request->has('search'))
        {
            $estudiantes = Estudiante::where('nombre','like',"%{$request->search}%")->orWhere('primer_apellido', 'like',"%{$request->search}%")->orWhere('segundo_apellido', 'like',"%{$request->search}%")->get(); 
            $searchR = mb_strtoupper($request->search); 
        } 

        return view('estudiantes.index', compact('estudiantes', 'searchR'));
    }

    public function edit($id)
    {
        $estudiante = Estudiante::where('id', $id)->first();
        $localidades = Localidad::orderBy('localidad', 'ASC')->get();
        $escuelas = Escuela::where('cve_escuela', '!=', '999')->orderBy('escuela_abreviatura', 'ASC')->get();
        $ciudades = Ciudad::all();
        $turnos = Turno::all();
        return view('estudiantes.edit', compact('estudiante', 'localidades', 'escuelas', 'ciudades', 'turnos'));
    }

    public function update(EstudianteUpdateRequest $request, $id)
    {
        $estudiante = Estudiante::findorfail($id);

        $rfc = substr($request->curp, 0, 10);

        $archivoCurp = $request->curp_hidden;
        $archivoActa = $request->acta_hidden;
        $archivoComprobante = $request->comprobante_hidden;
        $archivoIdentificacion = $request->identificacion_hidden;
        $archivoKardex = $request->kardex_hidden;
        $archivoConstancia = $request->constancia_hidden;

        //Sólo se copiarán los archivos únicamente cuando estén cargados en el input
        if (isset($request->img_curp)) 
        {
            $extCurp = $request->img_curp->getClientOriginalExtension();
            $archivoCurp = 'CU_' . $rfc . '.' . $extCurp;
            $request->img_curp->move('img/curps', $archivoCurp);
        }
        if (isset($request->img_acta_nac)) 
        {
            $extActa = strtoupper($request->img_acta_nac->getClientOriginalExtension());
            $archivoActa = 'AC_' . $rfc . '.' . $extActa;
            $request->img_acta_nac->move('img/actas', $archivoActa);
        } 
        if (isset($request->img_comprobante_dom)) 
        {
            $extComprobante = strtoupper($request->img_comprobante_dom->getClientOriginalExtension());
            $archivoComprobante = 'CO_' . $rfc . '.' . $extComprobante;
            $request->img_comprobante_dom->move('img/comprobantes', $archivoComprobante);
        }
        if (isset($request->img_identificacion)) 
        {
            $extIdentificacion = strtoupper($request->img_identificacion->getClientOriginalExtension());
            $archivoIdentificacion = 'ID_' . $rfc . '.' . $extIdentificacion;
            $request->img_identificacion->move('img/identificaciones', $archivoIdentificacion);
        }
        if (isset($request->img_kardex)) 
        {
            $extKardex = strtoupper($request->img_kardex->getClientOriginalExtension());
            $archivoKardex = 'ID_' . $rfc . '.' . $extKardex;
            $request->img_kardex->move('img/kardex', $archivoKardex);
        } 
        if (isset($request->img_constancia)) 
        {
            $extConstancia = strtoupper($request->img_constancia->getClientOriginalExtension());
            $archivoConstancia = 'CN_' . $rfc . '.' . $extConstancia;
            $request->img_constancia->move('img/constancias', $archivoConstancia);
        } 

        $estudiante->update([
            'nombre' => trim(mb_strtoupper($request->nombre)),
            'primer_apellido' => trim(mb_strtoupper($request->primer_apellido)),
            'segundo_apellido' => trim(mb_strtoupper($request->segundo_apellido)),
            'curp' => trim(mb_strtoupper($request->curp)),
            'rfc' => $rfc,
            'fecha_nac' => $request->fecha_nac,
            'celular' => $request->celular,
            'email' => trim(mb_strtolower($request->email)),
            'cve_localidad_origen' => $request->cve_localidad_origen,
            'cve_localidad_actual' => $request->cve_localidad_actual,
            'cve_ciudad_escuela' => $request->cve_ciudad_escuela,
            'cve_escuela' => $request->cve_escuela,
            'cve_turno_escuela' => $request->cve_turno_escuela,
            'carrera' => trim(mb_strtoupper($request->carrera)),
            'ano_escolar' => $request->ano_escolar,
            'promedio' => $request->promedio,
            'img_curp' => $archivoCurp,
            'img_acta_nac' => $archivoActa,
            'img_comprobante_dom' => $archivoComprobante,
            'img_identificacion' => $archivoIdentificacion,
            'img_kardex' => $archivoKardex,
            'img_constancia' => $archivoConstancia,
        ]);

        //return redirect()->back()->with('message', 'Información ACTUALIZADA con éxito!')->with('msg_type', 'success');
        return redirect()->route('estudiantes.index')->with('message', 'Estudiante ACTUALIZADO con éxito!')->with('msg_type', 'success');
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
        // dd($request);
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
 }
