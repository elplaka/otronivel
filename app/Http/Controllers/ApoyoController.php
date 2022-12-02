<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoletosRemesa;
use App\Models\ApoyosMonto;
use App\Models\ApoyoAsignado;
use App\Models\Estudiante;
use App\Models\Escuela;
use App\Models\Ciudad;
use Illuminate\Support\Facades\DB;
use PDF;
use Dompdf\Dompdf;  
use DOMDocument;

class ApoyoController extends Controller
{
    private function se_ha_asignado($id_remesa, $ciclo, $id_estudiante)
    {
        $apoyos_asignados = ApoyoAsignado::where('id_remesa', $id_remesa)
        ->where('id_ciclo', $ciclo)
        ->where('id_estudiante', $id_estudiante)->get();

        return $apoyos_asignados->count() > 0 ? true : false;
    }

    public function asignacion_pdf(Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $ids_asignar = $request->session()->get('ids_asignar');
        $tituloReporte = $request->tituloReporte;
        $id_remesa = $request->idRemesa;
        $cve_ciudad = $request->cveCiudad;

        $remesa = BoletosRemesa::where('id_remesa', $id_remesa)
        ->where('id_ciclo', $ciclo)->first();

        if ($cve_ciudad == 1)  //MAZATLÁN
        {
            $estudiantes_reporte = Estudiante::select('estudiantes.id as id', 'estudiantes.nombre as nombre', 'estudiantes.primer_apellido as primer_apellido', 'estudiantes.segundo_apellido', 'estudiantes.cve_ciudad_escuela as cve_ciudad_escuela', 'estudiantes.carrera as carrera', 'apoyos_montos.id_remesa as id_remesa', 'escuelas.escuela_abreviatura as escuela_abreviatura', 'apoyos_montos.monto as monto', 'localidades.localidad as lugar_origen')
            ->leftjoin('escuelas', 'estudiantes.cve_escuela', '=', 'escuelas.cve_escuela' )
            ->leftjoin('localidades', 'estudiantes.cve_localidad_origen', '=', 'localidades.cve_localidad' )
            ->leftJoin('apoyos_montos', function($join)
            {
                $join->on('estudiantes.cve_ciudad_escuela', '=', 'apoyos_montos.cve_ciudad_escuela');
                $join->on('estudiantes.cve_escuela', '=', 'apoyos_montos.cve_escuela');
            })
            ->whereIn('estudiantes.id', $ids_asignar)
            ->where('id_remesa', $id_remesa)
            ->where('estudiantes.id_ciclo', $ciclo)
            ->where('estudiantes.cve_ciudad_escuela', $cve_ciudad)->where('estudiantes.cve_status', 7)
            ->orderBy('estudiantes.primer_apellido')
            ->orderBy('estudiantes.segundo_apellido')
            ->orderBy('estudiantes.nombre'); 
        }
        elseif ($cve_ciudad == 2)  //CULIACÁN
        {
            $estudiantes_reporte = Estudiante::select('estudiantes.id as id', 'estudiantes.nombre as nombre', 'estudiantes.primer_apellido as primer_apellido', 'estudiantes.segundo_apellido', 'estudiantes.cve_ciudad_escuela as cve_ciudad_escuela', 'estudiantes.carrera as carrera', 'apoyos_montos.id_remesa as id_remesa', 'escuelas.escuela_abreviatura as escuela_abreviatura', 'apoyos_montos.monto as monto', 'localidades.localidad as lugar_origen')
            ->leftjoin('escuelas', 'estudiantes.cve_escuela', '=', 'escuelas.cve_escuela' )
            ->leftjoin('localidades', 'estudiantes.cve_localidad_origen', '=', 'localidades.cve_localidad' )
            ->leftJoin('apoyos_montos', function($join)
            {
                $join->on('estudiantes.cve_ciudad_escuela', '=', 'apoyos_montos.cve_ciudad_escuela');
                $join->on('estudiantes.cve_escuela', '=', 'apoyos_montos.cve_escuela');
            })
            ->whereIn('estudiantes.id', $ids_asignar)
            ->where('id_remesa', $id_remesa)
            ->where('estudiantes.id_ciclo', $ciclo)
            ->where('estudiantes.cve_ciudad_escuela', $cve_ciudad)->where('estudiantes.cve_status', 6)
            ->orderBy('estudiantes.primer_apellido')
            ->orderBy('estudiantes.segundo_apellido')
            ->orderBy('estudiantes.nombre'); 
        }


        $montos = $request->session()->get('montos');
        $suma_montos = array_sum($montos);

        $pdf = PDF::loadView('apoyos.asignacion-pdf',['estudiantes_reporte'=>$estudiantes_reporte->get(), 'tituloReporte'=>$tituloReporte, 'remesa'=>$remesa->descripcion, 'suma_montos'=>$suma_montos]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    public function asignacion_borra(Request $request, $id_remesa, $id_estudiante)
    {
        $ciclo = $request->session()->get('ciclo');
        $asignados = ApoyoAsignado::where('id_remesa', $id_remesa)
        ->where('id_ciclo', $ciclo)
        ->where('id_estudiante', $id_estudiante);

        DB::beginTransaction();
        try
        {        
            $asignados->delete();
            DB::commit();

            return redirect()->back()->with('message', 'Monto asignado BORRADO con éxito!')->with('tipo_msg', 'success');
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
    }

    public function asignacion_crea($id_remesa, Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $ids_asignar = $request->session()->get('ids_asignar');
        $montos = $request->session()->get('montos');
        $i = 0;
        $estudiantes_asignacion = 0;

        DB::beginTransaction();
        try
        {
            foreach($ids_asignar as $id_estudiante)  //Recorre todos los estudiantes
            {
                if (!$this->se_ha_asignado($id_remesa, $ciclo, $id_estudiante))
                {
                        ApoyoAsignado::create([
                        'id_remesa' => $id_remesa,
                        'id_ciclo' => $request->session()->get('ciclo'),
                        'id_estudiante' => $id_estudiante,
                        'monto' => $montos[$i],
                        'entregado' => 0,
                        ]);
                }
                $estudiantes_asignacion++;
                $i++;
            }

            DB::commit();
            if ($estudiantes_asignacion == 0)   //No hubo ningún estudiante con asignación porque ya tenía una
                return redirect()->route('apoyos.asignacion')->with('message', 'No se realizó NINGUNA ASIGNACIÓN.')->with('tipo_msg', 'danger');

            return redirect()->back()->with('message', 'Asignación REALIZADA con éxito!')->with('tipo_msg', 'success');
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
    }

    public function asignacion(Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $id_remesa = $request->id_remesa;
        if (!isset($id_remesa)) $id_remesa = 0;
        $cve_ciudad = $request->cve_ciudad;
        if (!isset($cve_ciudad)) $cve_ciudad = 0;

        $remesas = BoletosRemesa::where('id_ciclo', $ciclo)->get();
        $ciudades = Ciudad::all();

        if ($cve_ciudad == 1)  //MAZATLÁN ESPECIALES
        {
            $estudiantes = Estudiante::select('estudiantes.id as id', 'estudiantes.nombre as nombre', 'estudiantes.primer_apellido as primer_apellido', 'estudiantes.segundo_apellido', 'estudiantes.cve_ciudad_escuela as cve_ciudad_escuela', 'estudiantes.carrera as carrera', 'estudiantes.cve_status as cve_status', 'apoyos_montos.id_remesa as id_remesa', 'escuelas.escuela_abreviatura as escuela_abreviatura', 'apoyos_montos.monto as monto')
                    ->leftjoin('escuelas', 'estudiantes.cve_escuela', '=', 'escuelas.cve_escuela' )
                    ->leftJoin('apoyos_montos', function($join)
                    {
                        $join->on('estudiantes.cve_ciudad_escuela', '=', 'apoyos_montos.cve_ciudad_escuela');
                        $join->on('estudiantes.cve_escuela', '=', 'apoyos_montos.cve_escuela');
                    })
                    ->where('id_remesa', $id_remesa)
                    ->where('estudiantes.cve_ciudad_escuela', $cve_ciudad)->where('estudiantes.cve_status', 7)
                    ->orderBy('estudiantes.primer_apellido')
                    ->orderBy('estudiantes.segundo_apellido')
                    ->orderBy('estudiantes.nombre');
        }
        else
        {
            $estudiantes = Estudiante::select('estudiantes.id as id', 'estudiantes.nombre as nombre', 'estudiantes.primer_apellido as primer_apellido', 'estudiantes.segundo_apellido', 'estudiantes.cve_ciudad_escuela as cve_ciudad_escuela', 'estudiantes.carrera as carrera', 'estudiantes.cve_status as cve_status', 'apoyos_montos.id_remesa as id_remesa', 'escuelas.escuela_abreviatura as escuela_abreviatura', 'apoyos_montos.monto as monto')
                    ->leftjoin('escuelas', 'estudiantes.cve_escuela', '=', 'escuelas.cve_escuela' )
                    ->leftJoin('apoyos_montos', function($join)
                    {
                        $join->on('estudiantes.cve_ciudad_escuela', '=', 'apoyos_montos.cve_ciudad_escuela');
                        $join->on('estudiantes.cve_escuela', '=', 'apoyos_montos.cve_escuela');
                    })
                    ->where('id_remesa', $id_remesa)
                    ->where('estudiantes.cve_ciudad_escuela', $cve_ciudad)->where('estudiantes.cve_status', 6)
                    ->orderBy('estudiantes.primer_apellido')
                    ->orderBy('estudiantes.segundo_apellido')
                    ->orderBy('estudiantes.nombre');
        }
                

        $ids_estudiantes = $estudiantes->pluck('id');
        $ids_asignar = $ids_estudiantes->toArray();
        $request->session()->put('ids_asignar', $ids_asignar);

        $montos = $estudiantes->pluck('monto');
        $montos = $montos->toArray();
        $request->session()->put('montos', $montos);

        $estudiantes = $estudiantes->paginate(25)->withQueryString();

        return view('apoyos.asignacion', compact('remesas', 'ciudades', 'estudiantes', 'id_remesa', 'cve_ciudad', 'ciclo'));
    }

    public function montos_index(Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $id_remesa = $request->id_remesa;
        if (!isset($id_remesa)) $id_remesa = 0;
        $remesas = BoletosRemesa::where('id_ciclo', $ciclo)->get();

        $cve_ciudad = $request->cve_ciudad;
        if (!isset($cve_ciudad)) $cve_ciudad = 0;
        $ciudades = Ciudad::all();


        if ($cve_ciudad == 1)  //MAZATLAN ESPECIALES
        {
            $montos = Estudiante::select('br.id_remesa','br.descripcion', 'es.escuela_abreviatura', 'estudiantes.cve_escuela', 'estudiantes.cve_ciudad_escuela', 'am.monto')->distinct()
            //->leftjoin('apoyos_montos as am', 'estudiantes.cve_ciudad_escuela', '=', 'am.cve_ciudad_escuela')
            ->leftJoin('apoyos_montos as am', function($join)
            {
                $join->on('estudiantes.cve_ciudad_escuela', '=', 'am.cve_ciudad_escuela');
                $join->on('estudiantes.cve_escuela', '=', 'am.cve_escuela');
            })
            ->leftjoin('boletos_remesas as br', 'estudiantes.id_ciclo', '=', 'br.id_ciclo')
            ->leftjoin('escuelas as es', 'estudiantes.cve_escuela', '=', 'es.cve_escuela')
            ->where('estudiantes.id_ciclo', $ciclo)
            ->where('estudiantes.cve_ciudad_escuela', 1)->where('estudiantes.cve_status', 7)
            ->where('estudiantes.cve_ciudad_escuela', $cve_ciudad)
            ->where('br.id_remesa', $id_remesa)
            ->get();
        }
        else //CULIACÁN ACEPTADOS
        {
            $montos = Estudiante::select('br.id_remesa','br.descripcion', 'es.escuela_abreviatura', 'estudiantes.cve_escuela', 'estudiantes.cve_ciudad_escuela', 'am.monto')->distinct()
            ->leftJoin('apoyos_montos as am', function($join)
            {
                $join->on('estudiantes.cve_ciudad_escuela', '=', 'am.cve_ciudad_escuela');
                $join->on('estudiantes.cve_escuela', '=', 'am.cve_escuela');
            })
            ->leftjoin('boletos_remesas as br', 'estudiantes.id_ciclo', '=', 'br.id_ciclo')
            ->leftjoin('escuelas as es', 'estudiantes.cve_escuela', '=', 'es.cve_escuela')
            ->where('estudiantes.id_ciclo', $ciclo)
            ->where('estudiantes.cve_ciudad_escuela', 2)->where('estudiantes.cve_status', 6)
            ->where('estudiantes.cve_ciudad_escuela', $cve_ciudad)
            ->where('br.id_remesa', $id_remesa)
            ->get();
        }

        return view('apoyos.montos-index', compact('montos', 'id_remesa', 'remesas', 'ciudades', 'cve_ciudad'));
    }

    public function montos_nuevos(Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $remesas = BoletosRemesa::where('id_ciclo', $ciclo)
        ->where('realizada', 0)->get();

        $ciudades = Ciudad::all();
        return view('apoyos.montos-nuevos', compact('remesas', 'ciudades'));
    }

    public function montos_nuevo_uno(Request $request, $id_remesa, $cve_ciudad_escuela, $cve_escuela)
    {
        $ciclo = $request->session()->get('ciclo');
        $escuela = Escuela::where('cve_escuela', $cve_escuela)->first();
        $ciudad = Ciudad::where('cve_ciudad', $cve_ciudad_escuela)->first();
        $remesa = BoletosRemesa::where('id_remesa', $id_remesa)->first();

        return view('apoyos.montos-nuevo-uno', compact('remesa', 'ciudad', 'escuela'));
    }

    public function montos_crea(Request $request)
    {
        $validatedData = $request->validate([
            'id_remesa' => ['required'],
            'cve_ciudad' => ['required'],
            'monto' => ['required', 'max:4'],
        ]);

        DB::beginTransaction();
        try
        {
            if ($request->cve_ciudad == 1)   //MAZATLÁN ESPECIALES
            {
                $cves_escuelas = Escuela::whereIn('cve_escuela', function($query){
                    $query->select('cve_escuela')
                    ->from(with(new Estudiante)->getTable())
                    ->where('cve_status', 7)
                    ->where('cve_ciudad_escuela', 1);
                })->get();
            }
            else   //CULIACÁN ACEPTADOS
            {
                $cves_escuelas = Escuela::whereIn('cve_escuela', function($query){
                    $query->select('cve_escuela')
                    ->from(with(new Estudiante)->getTable())
                    ->where('cve_status', 6)
                    ->where('cve_ciudad_escuela', 2);
                })->get();
            }

            foreach ($cves_escuelas as $cve_escuela)
            {
                ApoyosMonto::create([
                    'id_remesa' => $request->id_remesa,
                    'id_ciclo' => $request->session()->get('ciclo'),
                    'cve_ciudad_escuela' => $request->cve_ciudad,
                    'cve_escuela' => $cve_escuela->cve_escuela,
                    'monto' => $request->monto,
                ]);
            }

            DB::commit();
            return redirect()->route('apoyos.montos-index')->with('message', 'Montos GUARDADOS con éxito!')->with('tipo_msg', 'success');
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
    }

    public function montos_crea_uno(Request $request)  
    {
        $validatedData = $request->validate([
            'monto' => ['required', 'max:4'],
        ]);

        $montos = ApoyosMonto::where('id_remesa', $request->id_remesa)
        ->where('id_ciclo', $request->session()->get('ciclo'))
        ->where('cve_ciudad_escuela', $request->cve_escuela)
        ->where('cve_escuela', $request->cve_escuela)
        ->get();

        if ($montos->count() > 0) return redirect()->back()->with('message', 'Monto ya existe en la REMESA seleccionada. Intenta con otra remesa. ')->with('tipo_msg', 'danger');

        DB::beginTransaction();
        try
        {
            ApoyosMonto::create([
                'id_remesa' => $request->id_remesa,
                'id_ciclo' => $request->session()->get('ciclo'),
                'cve_ciudad_escuela' => $request->cve_ciudad_escuela,
                'cve_escuela' => $request->cve_escuela,
                'monto' => $request->monto,
            ]);

            DB::commit();
            return redirect()->route('apoyos.montos-index')->with('message', 'Monto GUARDADO con éxito!')->with('tipo_msg', 'success');
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
    }

    public function monto_editar($id_remesa, $cve_ciudad, $cve_escuela, Request $request)
    {
        $ciclo = $request->session()->get('ciclo');
        $monto = ApoyosMonto::where('id_remesa',$id_remesa)->where('id_ciclo', $ciclo)->where('cve_ciudad_escuela', $cve_ciudad)->where('cve_escuela', $cve_escuela)->first();
        $remesas = BoletosRemesa::all();

        return view('apoyos.monto-editar', compact('monto', 'remesas'));
    }

    public function monto_actualizar(Request $request, $id_remesa, $cve_ciudad_escuela, $cve_escuela)
    {
        $ciclo = $request->session()->get('ciclo');
        $tanto = ApoyosMonto::where('id_remesa',$id_remesa)->where('id_ciclo', $ciclo)->where('cve_ciudad_escuela', $cve_ciudad_escuela)->where('cve_escuela', $cve_escuela)->update(['monto' => $request->monto]);

        return redirect()->route('apoyos.montos-index')->with('message', 'Monto ACTUALIZADO con éxito!')->with('tipo_msg', 'success');
    }
}
