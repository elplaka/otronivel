<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoletosPaquete;
use App\Models\BoletosRemesa;
use App\Models\BoletosTanto;
use App\Models\BoletoAsignado;
use App\Models\Estudiante;
use App\Models\Escuela;
use Illuminate\Support\Facades\DB;
use PDF;
use Dompdf\Dompdf;  
use DOMDocument;

class BoletoController extends Controller
{
    public function asignacion_borra(Request $request, $id_remesa, $id_estudiante)
    {

        $ciclo = $request->session()->get('ciclo');
        $asignados = BoletoAsignado::where('id_remesa', $id_remesa)
        ->where('id_ciclo', $ciclo)
        ->where('id_estudiante', $id_estudiante);

        $reasignados = $asignados->get();

        DB::beginTransaction();
        try
        {
            foreach ($reasignados as $reasignado)
            {
                $total_folios = $reasignado->folio_final - $reasignado->folio_inicial + 1;
                BoletosPaquete::create([
                    'id_ciclo' => $request->session()->get('ciclo'),
                    'folio_inicial' => $reasignado->folio_inicial,
                    'folio_final' => $reasignado->folio_final,
                    'ult_folio_asignado' => 0,
                    'folios_disponibles' => $total_folios
                ]);
            }
        
        $asignados->delete();
        DB::commit();

        return redirect()->back()->with('message', 'Boletos asignados BORRADOS con éxito!')->with('tipo_msg', 'success');
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
    }

    public function asignacion_nueva(Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $id_remesa = $request->id_remesa;
        if (!isset($id_remesa)) $id_remesa = 0;
        $remesas = BoletosRemesa::where('id_ciclo', $ciclo)->get();

        $estudiantes = Estudiante::select('estudiantes.id as id', 'estudiantes.nombre as nombre', 'estudiantes.primer_apellido as primer_apellido', 'estudiantes.segundo_apellido', 'estudiantes.cve_ciudad_escuela as cve_ciudad_escuela', 'estudiantes.carrera as carrera', 'estudiantes.cve_status as cve_status', 'boletos_tantos.id_remesa as id_remesa', 'escuelas.escuela_abreviatura as escuela_abreviatura', 'boletos_tantos.cantidad_folios as cantidad_folios')
                //->leftjoin('boletos_asignados', 'estudiantes.id', '=', 'boletos_asignados.id_estudiante')
                ->leftjoin('escuelas', 'estudiantes.cve_escuela', '=', 'escuelas.cve_escuela' )
                ->leftjoin('boletos_tantos', 'estudiantes.cve_escuela', '=', 'boletos_tantos.cve_escuela')
                ->where('id_remesa', $id_remesa)
                ->where('cve_ciudad_escuela', 1)->where('cve_status', 6)
                ->orderBy('estudiantes.primer_apellido')
                ->orderBy('estudiantes.segundo_apellido')
                ->orderBy('estudiantes.nombre');
                

        $ids_estudiantes = $estudiantes->pluck('id');
        $ids_asignar = $ids_estudiantes->toArray();
        $request->session()->put('ids_asignar', $ids_asignar);

        $cant_folios = $estudiantes->pluck('cantidad_folios');
        $cantidad_folios = $cant_folios->toArray();
        $request->session()->put('cantidad_folios', $cantidad_folios);

        $estudiantes = $estudiantes->paginate(25)->withQueryString();

        return view('boletos.asignacion-nueva', compact('remesas', 'estudiantes', 'id_remesa', 'ciclo'));
    }

    private function regresa_paquetes_requeridos($ciclo, $cantidad_folios)
    {
        //Necesito saber los folios disponibles de cada paquete
       $paquetes = BoletosPaquete::where('id_ciclo', $ciclo)->where('folios_disponibles', '>', 0)->orderBy('folio_inicial')->orderBy('folio_final')->get();

       $j = 0; //Controla el índice del array que contiene los paquetes requeridos
       $sigue = true; 
       while($j < $paquetes->count() && $sigue) 
       //Recorro todos los paquetes mientras NO SE COMPLETEN los folios p/cada estudiante
       {
            $folios_disponibles = $paquetes->get($j)->folios_disponibles;
            $ult_folio_asignado = $paquetes->get($j)->ult_folio_asignado;
            $folio_inicial = $paquetes->get($j)->folio_inicial;

            $paquetes_req[$j][0] = $paquetes->get($j)->id_paquete;
            if ($folios_disponibles >= $cantidad_folios) //Sí alcanzan los folios del paquete para el estudiante
            {
                if ($ult_folio_asignado == 0) $folio_inicial_asignado = $folio_inicial;  //NUEVO paquete
                else $folio_inicial_asignado = $paquetes->get($j)->ult_folio_asignado + 1;
                
                $paquetes_req[$j][1] = $folio_inicial_asignado;

                $folio_final_asignado = $folio_inicial_asignado + $cantidad_folios - 1;
                $paquetes_req[$j][2] = $folio_final_asignado;

                $ult_folio_asignado = $folio_final_asignado; 

                $folios_disponibles = $paquetes->get($j)->folio_final - $ult_folio_asignado;

                $paquetesU = BoletosPaquete::where('id_paquete', $paquetes->get($j)->id_paquete)->where('id_ciclo', $ciclo);
                $paquetesU->update(['ult_folio_asignado' => $ult_folio_asignado, 'folios_disponibles' => $folios_disponibles]);

                $sigue = false;

            }
            else  //Si no alcanzan los folios busca en el siguiente paquete
            {
                if ($ult_folio_asignado == 0) $folio_inicial_asignado = $paquetes->get($j)->folio_inicial;
                else $folio_inicial_asignado = $paquetes->get($j)->ult_folio_asignado + 1;

                $paquetes_req[$j][1] = $folio_inicial_asignado;

                $folio_final_asignado = $paquetes->get($j)->folio_final; 
                $paquetes_req[$j][2] = $folio_final_asignado;

                $ult_folio_asignado = $paquetes->get($j)->folio_final;

                $paquetesU = BoletosPaquete::where('id_paquete', $paquetes->get($j)->id_paquete)->where('id_ciclo', $ciclo);
                $paquetesU->update(['ult_folio_asignado' => $ult_folio_asignado, 'folios_disponibles' => 0]);

                $cantidad_folios = $cantidad_folios - ($folio_final_asignado - $folio_inicial_asignado) - 1;

                //if ($cantidad_folios == 0) $sigue = false; //ESTO LO PUSE PARA PROBARd

                $j++;

            } 
       }
       return $paquetes_req;
    }

    private function se_ha_asignado($id_remesa, $ciclo, $id_estudiante)
    {
        $boletos_asignados = BoletoAsignado::where('id_remesa', $id_remesa)
        ->where('id_ciclo', $ciclo)
        ->where('id_estudiante', $id_estudiante)->get();

        return $boletos_asignados->count() > 0 ? true : false;
    }

    public function asignacion_pdf(Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $ids_asignar = $request->session()->get('ids_asignar');
        $tituloReporte = $request->tituloReporte;
        $id_remesa = $request->idRemesa;
        $letra_inicial = $request->letraInicial;
        $letra_final = $request->letraFinal;

        $remesa = BoletosRemesa::where('id_remesa', $id_remesa)
        ->where('id_ciclo', $ciclo)->first();

        if (!isset($letra_inicial)) $letra_inicial = 65;
        if (!isset($letra_final)) $letra_final = 90;

        if ($letra_inicial > $letra_final) 
        {
            $letra_aux = $letra_inicial;
            $letra_inicial = $letra_final;
            $letra_final = $letra_aux;
        }

        $incluyeEnie = false;   //Incluye la Ñ en la búsquedad por primera letra del apellido
        if ($letra_inicial <= 78 && $letra_final >= 79) $incluyeEnie = true;

        if ($incluyeEnie)
        {
            $estudiantes_reporte = Estudiante::select('estudiantes.id as id', 'estudiantes.nombre as nombre', 'estudiantes.primer_apellido as primer_apellido', 'estudiantes.segundo_apellido', 'estudiantes.cve_ciudad_escuela as cve_ciudad_escuela', 'estudiantes.carrera as carrera', 'boletos_tantos.id_remesa as id_remesa', 'escuelas.escuela_abreviatura as escuela_abreviatura', 'boletos_tantos.cantidad_folios as cantidad_folios')
            ->leftjoin('escuelas', 'estudiantes.cve_escuela', '=', 'escuelas.cve_escuela' )
            ->leftjoin('boletos_tantos', 'estudiantes.cve_escuela', '=', 'boletos_tantos.cve_escuela')
            ->whereIn('estudiantes.id', $ids_asignar)
            ->where('id_remesa', $id_remesa)
            ->where('estudiantes.id_ciclo', $ciclo)
            ->where(\DB::raw('substr(estudiantes.primer_apellido, 1, 1)'), '>=', chr($letra_inicial))
            ->where(\DB::raw('substr(estudiantes.primer_apellido, 1, 1)'), '<=', chr($letra_final))
            ->orWhere(\DB::raw('substr(estudiantes.primer_apellido, 1, 1)'), '=', chr(165))
            ->orderBy('estudiantes.primer_apellido')
            ->orderBy('estudiantes.segundo_apellido')
            ->orderBy('estudiantes.nombre'); 
        }
        else
        {
            $estudiantes_reporte = Estudiante::select('estudiantes.id as id', 'estudiantes.nombre as nombre', 'estudiantes.primer_apellido as primer_apellido', 'estudiantes.segundo_apellido', 'estudiantes.cve_ciudad_escuela as cve_ciudad_escuela', 'estudiantes.carrera as carrera', 'boletos_tantos.id_remesa as id_remesa', 'escuelas.escuela_abreviatura as escuela_abreviatura', 'boletos_tantos.cantidad_folios as cantidad_folios')
            ->leftjoin('escuelas', 'estudiantes.cve_escuela', '=', 'escuelas.cve_escuela' )
            ->leftjoin('boletos_tantos', 'estudiantes.cve_escuela', '=', 'boletos_tantos.cve_escuela')
            ->whereIn('estudiantes.id', $ids_asignar)
            ->where('id_remesa', $id_remesa)
            ->where('estudiantes.id_ciclo', $ciclo)
            ->where(\DB::raw('substr(estudiantes.primer_apellido, 1, 1)'), '>=', chr($letra_inicial))
            ->where(\DB::raw('substr(estudiantes.primer_apellido, 1, 1)'), '<=', chr($letra_final))
            ->orderBy('estudiantes.primer_apellido')
            ->orderBy('estudiantes.segundo_apellido')
            ->orderBy('estudiantes.nombre'); 
        }

        $pdf = PDF::loadView('boletos.asignacion-pdf',['estudiantes_reporte'=>$estudiantes_reporte->get(), 'tituloReporte'=>$tituloReporte, 'remesa'=>$remesa->descripcion]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    public function asignacion_crea($id_remesa, Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $ids_asignar = $request->session()->get('ids_asignar');
        $cantidad_folios = $request->session()->get('cantidad_folios');
        $i = 0;
        $estudiantes_asignacion = 0;
        $folios_requeridos = array_sum($cantidad_folios);   //Cantidad de folios que se ocuparán para asignar
        $folios_disponibles = BoletosPaquete::where('folios_disponibles', '>', 0)->sum('folios_disponibles');

        if ($folios_disponibles < $folios_requeridos)  return redirect()->back()->with('message', 'La cantidad de FOLIOS DISPONIBLES no es suficiente para la ASIGNACIÓN solicitada!')->with('tipo_msg', 'danger');

        DB::beginTransaction();
        try
        {
            foreach($ids_asignar as $id_estudiante)  //Recorre todos los estudiantes
            {
                if (!$this->se_ha_asignado($id_remesa, $ciclo, $id_estudiante))
                {
                    $paquetes_requeridos = $this->regresa_paquetes_requeridos($ciclo, $cantidad_folios[$i]);
                    foreach($paquetes_requeridos as $id_paq)  //Recorre los paquetes requeridos para la asignación
                    {     
                        BoletoAsignado::create([
                        'id_remesa' => $id_remesa,
                        'id_paquete' => $id_paq[0],
                        'id_ciclo' => $request->session()->get('ciclo'),
                        'id_estudiante' => $id_estudiante,
                        'folio_inicial' => $id_paq[1],
                        'folio_final' => $id_paq[2],
                        'entregados' => 0,
                        ]);
                    }
                    $estudiantes_asignacion++;
                }
                $i++;
            }

            // $remesaU = BoletosRemesa::where('id_remesa', $id_remesa)->where('id_ciclo', $ciclo);
            // $remesaU->update(['realizada' => 1]);  //Pone como REALIZADA la remesa

            DB::commit();
            if ($estudiantes_asignacion == 0)   //No hubo ningún estudiante con asignación porque ya tenía una
                return redirect()->route('boletos.asignacion-nueva')->with('message', 'No se realizó NINGUNA ASIGNACIÓN.')->with('tipo_msg', 'danger');

            return redirect()->route('boletos.asignacion-nueva')->with('message', 'Asignación REALIZADA con éxito!')->with('tipo_msg', 'success');
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
    }

    public function tantos_index(Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $id_remesa = $request->id_remesa;
        if (!isset($id_remesa)) $id_remesa = 0;
        $remesas = BoletosRemesa::where('id_ciclo', $ciclo)->get();

        $tantos = Estudiante::select('bt.id_remesa','br.descripcion', 'es.escuela_abreviatura', 'estudiantes.cve_escuela', 'bt.cantidad_folios')->distinct()
        ->leftjoin('boletos_tantos as bt', 'estudiantes.cve_escuela', '=', 'bt.cve_escuela' )
        ->leftjoin('boletos_remesas as br', 'bt.id_remesa', '=', 'br.id_remesa')
        ->leftjoin('escuelas as es', 'estudiantes.cve_escuela', '=', 'es.cve_escuela')
        ->where('estudiantes.id_ciclo', $ciclo)
        ->where('estudiantes.cve_ciudad_escuela', 1)->where('estudiantes.cve_status', 6)
        ->where('br.id_remesa', $id_remesa)
        ->get();
        // ->orderBy('estudiantes.primer_apellido')
        // ->orderBy('estudiantes.segundo_apellido')
        // ->orderBy('estudiantes.nombre');

        return view('boletos.tantos-index', compact('tantos', 'id_remesa', 'remesas'));
    }

    public function tantos_nuevo_uno(Request $request, $cve_escuela)
    {
        $ciclo = $request->session()->get('ciclo');
        $escuela = Escuela::where('cve_escuela', $cve_escuela)->first();
        // $tanto = BoletosTanto::where('id_remesa',$id_remesa)->where('id_ciclo', $ciclo)->where('cve_escuela', $cve_escuela)->first();
        $remesas = BoletosRemesa::where('id_ciclo', $ciclo)->get();

        return view('boletos.tantos-nuevo-uno', compact('remesas', 'escuela'));
    }

    public function tantos_nuevos(Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $remesas = BoletosRemesa::where('id_ciclo', $ciclo)
        ->where('realizada', 0)->get();
        return view('boletos.tantos-nuevos', compact('remesas'));
    }

    public function tantos_crea_uno(Request $request)
    {
        $validatedData = $request->validate([
            'id_remesa' => ['required'],
            'cantidad_folios' => ['required', 'max:4'],
        ]);

        $tantos = BoletosTanto::where('id_remesa', $request->id_remesa)
        ->where('id_ciclo', $request->session()->get('ciclo'))
        ->where('cve_escuela', $request->cve_escuela)
        ->get();

        if ($tantos->count() > 0) return redirect()->back()->with('message', 'Tantos ya existen en la REMESA seleccionada. Intenta con otra remesa. ')->with('tipo_msg', 'danger');

        DB::beginTransaction();
        try
        {
            BoletosTanto::create([
                'id_remesa' => $request->id_remesa,
                'id_ciclo' => $request->session()->get('ciclo'),
                'cve_escuela' => $request->cve_escuela,
                'cantidad_folios' => $request->cantidad_folios,
            ]);

            DB::commit();
            return redirect()->route('boletos.tantos-index')->with('message', 'Tantos GUARDADOS con éxito!')->with('tipo_msg', 'success');
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
    }

    public function tantos_crea(Request $request)
    {
        $validatedData = $request->validate([
            'id_remesa' => ['required'],
            'cantidad_folios_uas' => ['required', 'max:4'],
            'cantidad_folios' => ['required', 'max:4'],
        ]);

        DB::beginTransaction();
        try
        {
            //Tantos de boletos de la UAS
            BoletosTanto::create([
                'id_remesa' => $request->id_remesa,
                'id_ciclo' => $request->session()->get('ciclo'),
                'cve_escuela' => 1,
                'cantidad_folios' => $request->cantidad_folios_uas,
            ]);

            $cves_escuelas = Escuela::whereIn('cve_escuela', function($query){
                $query->select('cve_escuela')
                ->from(with(new Estudiante)->getTable())
                ->where('cve_status', 6)
                ->where('cve_ciudad_escuela', 1)
                ->where('cve_escuela', '!=', 1);
            })->get();
            
            //Tantos de boletos NO UAS
            foreach ($cves_escuelas as $cve_escuela)
            {
                BoletosTanto::create([
                    'id_remesa' => $request->id_remesa,
                    'id_ciclo' => $request->session()->get('ciclo'),
                    'cve_escuela' => $cve_escuela->cve_escuela,
                    'cantidad_folios' => $request->cantidad_folios,
                ]);
            }

            BoletosRemesa::where('id_remesa',$request->id_remesa)
            ->where('id_ciclo', $request->session()->get('ciclo'))->update(['con_tantos' => 1]);

            DB::commit();
            return redirect()->route('boletos.tantos-index')->with('message', 'Tantos GUARDADOS con éxito!')->with('tipo_msg', 'success');
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
    }

    public function tantos_editar($id_remesa, $cve_escuela, Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $tanto = BoletosTanto::where('id_remesa',$id_remesa)->where('id_ciclo', $ciclo)->where('cve_escuela', $cve_escuela)->first();
        $remesas = BoletosRemesa::all();

        return view('boletos.tantos-editar', compact('tanto', 'remesas'));
    }

    public function tantos_actualizar(Request $request, $id_remesa, $cve_escuela)
    {
        $ciclo = $request->session()->get('ciclo');
        $tanto = BoletosTanto::where('id_remesa',$id_remesa)->where('id_ciclo', $ciclo)->where('cve_escuela', $cve_escuela)->update(['cantidad_folios' => $request->cantidad_folios]);

        return redirect()->route('boletos.tantos-index')->with('message', 'Tantos ACTUALIZADOS con éxito!')->with('tipo_msg', 'success');
    }

    public function remesas_index()
    {
        $remesas = BoletosRemesa::all();
        return view('boletos.remesas-index', compact('remesas'));
    }

    public function remesas_nuevo()
    {
        return view('boletos.remesas-nuevo');
    }
    
    public function remesas_crea(Request $request)
    {
        $validatedData = $request->validate([
            'fecha' => ['required', 'max:10'],
            'descripcion' => ['required', 'max:50'],
        ]);

        BoletosRemesa::create([
            'id_ciclo' => $request->session()->get('ciclo'),
            'fecha' => $request->fecha,
            'descripcion' => trim(mb_strtoupper($request->descripcion)),
        ]);

        return redirect()->route('boletos.remesas-index')->with('message', 'Remesa GUARDADA con éxito!')->with('tipo_msg', 'success');
    }

    public function remesas_editar($id, Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $remesa = BoletosRemesa::where('id_remesa',$id)->where('id_ciclo', $ciclo)->first();

        return view('boletos.remesas-editar', compact('remesa'));
    }

    public function remesas_actualizar(Request $request, $id)
    {
        $ciclo = $request->session()->get('ciclo');
        $remesa = BoletosRemesa::where('id_remesa',$id)->where('id_ciclo', $ciclo)->first();

        $remesa->update([
            'fecha' => $request->fecha,
            'descripcion' => trim(mb_strtoupper($request->descripcion)),
            'realizada' => $request->realizada
        ]);

        return redirect()->route('boletos.remesas-index')->with('message', 'Remesa ACTUALIZADA con éxito!')->with('tipo_msg', 'success');
    }

    public function paquetes_index()
    {
        $paquetes = BoletosPaquete::all();
        return view('boletos.paquetes-index', compact('paquetes'));
    }

    public function paquetes_nuevo()
    {
        return view('boletos.paquetes-nuevo');
    }

    public function paquetes_editar($id, Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $paquete = BoletosPaquete::where('id_paquete',$id)->where('id_ciclo', $ciclo)->first();

        return view('boletos.paquetes-editar', compact('paquete'));
    }

    public function se_traslapan($ciclo, $folio_inicial, $folio_final)
    {
        $paquetes = BoletosPaquete::where(function($query) use ($ciclo, $folio_inicial, $folio_final)
        {
            $query->where('id_ciclo', $ciclo);
            $query->where('folio_inicial', '<=', $folio_inicial);
            $query->where('folio_final', '>=', $folio_inicial);
        })
        ->orWhere(function($query) use($ciclo, $folio_inicial, $folio_final)
        {
            $query->where('id_ciclo', $ciclo);
            $query->where('folio_inicial', '<=', $folio_final);
            $query->where('folio_final', '>=', $folio_final);
        })
        ->orWhere(function($query) use($ciclo, $folio_inicial, $folio_final)
        {
            $query->where('id_ciclo', $ciclo);
            $query->where('folio_inicial', '>=', $folio_inicial);
            $query->where('folio_final', '<=', $folio_final);
        });

        return $paquetes->count() > 0 ? true : false; 
    }

    public function se_traslapan_al_actualizar($id, $ciclo, $folio_inicial, $folio_final)
    {
        $paquetes = BoletosPaquete::where(function($query) use ($id, $ciclo, $folio_inicial, $folio_final)
        {
            $query->where('id_paquete', '!=' , $id);
            $query->where('id_ciclo', $ciclo);
            $query->where('folio_inicial', '<=', $folio_inicial);
            $query->where('folio_final', '>=', $folio_inicial);
        })
        ->orWhere(function($query) use($id, $ciclo, $folio_inicial, $folio_final)
        {
            $query->where('id_paquete', '!=' , $id);
            $query->where('id_ciclo', $ciclo);
            $query->where('folio_inicial', '<=', $folio_final);
            $query->where('folio_final', '>=', $folio_final);
        })
        ->orWhere(function($query) use($id, $ciclo, $folio_inicial, $folio_final)
        {
            $query->where('id_paquete', '!=' , $id);
            $query->where('id_ciclo', $ciclo);
            $query->where('folio_inicial', '>=', $folio_inicial);
            $query->where('folio_final', '<=', $folio_final);
        });

        return $paquetes->count() > 0 ? true : false; 
    }

    public function paquetes_crea(Request $request)
    {
        $validatedData = $request->validate([
            'folio_inicial' => ['required', 'max:10'],
            'folio_final' => ['required', 'max:10', 'gte:folio_inicial'],
        ]);

        $ciclo = $request->session()->get('ciclo');
        $folio_inicial = $request->folio_inicial;
        $folio_final = $request->folio_final;

        if ($this->se_traslapan($ciclo, $folio_inicial, $folio_final))
        {
            return redirect()->back()->with('message', 'Los FOLIOS del paquete se TRASLAPAN. Intenta con otro rango de FOLIOS.')->with('tipo_msg', 'danger');
        }

        BoletosPaquete::create([
            'id_ciclo' => $request->session()->get('ciclo'),
            'folio_inicial' => $request->folio_inicial,
            'folio_final' => $request->folio_final,
            'ult_folio_asignado' => 0,
            'folios_disponibles' => $request->total_folios
        ]);

        return redirect()->route('boletos.paquetes-index')->with('message', 'Paquete GUARDADO con éxito!')->with('tipo_msg', 'success');
    }

    public function paquetes_actualizar(Request $request, $id)
    {
        $validatedData = $request->validate([
            'folio_inicial' => ['required', 'max:10'],
            'folio_final' => ['required', 'max:10', 'gte:folio_inicial'],
        ]);

        $ciclo = $request->session()->get('ciclo');
        $folio_inicial = $request->folio_inicial;
        $folio_final = $request->folio_final;
      

        if ($this->se_traslapan_al_actualizar($id, $ciclo, $folio_inicial, $folio_final))
        {
            return redirect()->back()->with('message', 'Los FOLIOS del paquete se TRASLAPAN. Intenta con otro rango de FOLIOS.')->with('tipo_msg', 'danger');
        }

        $paquete = BoletosPaquete::where('id_paquete',$id)->where('id_ciclo', $ciclo)->first();

        $paquete->update([
            'folio_inicial' => $request->folio_inicial,
            'folio_final' => $request->folio_final,
            'ult_folio_asignado' => 0,
            'folios_disponibles' => $request->total_folios
        ]);

        return redirect()->route('boletos.paquetes-index')->with('message', 'Paquete ACTUALIZADO con éxito!')->with('tipo_msg', 'success');
    }



}
