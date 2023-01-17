@extends('layouts.main')
@section('content')
    <!-- Page Heading -->
    <script language="JavaScript" type="text/javascript">
        $(document).ready(function () {
            $('#btnImprimir').click(function(){
             $("#exampleModal").modal("show");
            });
         });
     </script>

      <script language="JavaScript" type="text/javascript">
        $(document).ready(function(){
            $('#btnAceptar').click(function(){
                var databack = $("#exampleModal #recipient-name").val().trim();   //Nombre del Reporte
                $('#tituloReporte').val(databack);

                //Abre el formulario con el PDF
                var f = document.getElementById("formReport");
                
                f.action = "{{ route('apoyos.asignacion-pdf') }}";
                //f.method = "GET";
            
                f.submit();   

                $('#exampleModal').modal('hide');    //Cierra la ventana modal
            });
        });    
    </script>
    {{-- ***********************************  Ventana MODAL  ************************************************* --}}
    <div class="modal fade" id="exampleModal" name="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b> <i class="fas fa-print"></i> Opciones del Reporte</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> &times; </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label"> <b> PERIODO </b></label>
                        <input type="text" value="{{ "CORRESPONDIENTE MES DE " . $periodo }}" class="form-control" id="recipient-name"> 
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" id="btnAceptar" type="submit" class="btn btn-danger btn-sm action-complete-task">Generar</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<?php 

    use App\Models\ApoyoAsignado;

    function formato_fecha_espanol_corta($fecha)
    {
        $fecha2 = strtotime($fecha);
        $dia = date('d', $fecha2);
        $mes_numero = date('m', $fecha2);
        switch ($mes_numero)
        {
            case 1:
                $mes = "ENE";
                break;
            case 2:
                $mes = "FEB";
                break;
            case 3:
                $mes = "MAR";
                break;
            case 4:
                $mes = "ABR";
                break;
            case 5:
                $mes = "MAY";
                break;
            case 6:
                $mes = "JUN";
                break;
            case 7:
                $mes = "JUL";
                break;
            case 8:
                $mes = "AGO";
                break;
            case 9:
                $mes = "SEP";
                break;
            case 10:
                $mes = "OCT";
                break;
            case 11:
                $mes = "NOV";
                break;
            case 12:
                $mes = "DIC";
                break;
        }
        return $dia . '-' . $mes . '-' . date('Y', $fecha2);
    }

    function monto_asignado($id_remesa, $id_estudiante)
    {
        $monto_asignado = ApoyoAsignado::where('id_remesa', $id_remesa)->where('id_estudiante', $id_estudiante)->first();

        if (!isset($monto_asignado)) return "N/A";

        return '$ ' . $monto_asignado->monto;
    }

    if (isset(auth()->user()->usertype))
    {
        $usertype = auth()->user()->usertype;
    }
    else 
    {
        return redirect()->to('/');
    }

    $i = 1;
?>
<div class="container-fluid">
    <div class="card mx-auto">
        <div>
            @if (session()->has('message'))
                <?php 
                    $tipo_msg = session()->get('tipo_msg');
                ?>
                @if ($tipo_msg == "success")
                    <div class="alert alert-success">
                @elseif ($tipo_msg == "danger")
                    <div class="alert alert-danger">    
                @endif
                
                <button type="button" class="close" data-dismiss="alert">
                    x
                </button>    
                
                {{ session()->get('message') }}
                </div>                
            @endif
            
        </div>
        <div class="card-header">
             <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"> <b> Asignación de Apoyos Económicos </b></h1> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <a href="{{ route('home') }}" class="float-right"> Atrás</a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('apoyos.asignacion', [$id_remesa, $cve_ciudad]) }}">
                <div class="row">
                    <label for="id_remesa" class="col-md-2 col-form-label text-md-right">{{ __('Remesa') }} </label>
                    <div class="col-md-4">
                        <select id="id_remesa" name="id_remesa" class="form-control" @error('id_remesa') is-invalid @enderror aria-label="Default select example" onchange="this.form.submit()">
                            <option value=''>-- SELECCIONA REMESA --</option>
                            @foreach ($remesas as $remesa)
                                <option value="{{ $remesa->id_remesa }}" {{ $remesa->id_remesa == $id_remesa? 'selected' : '' }}>{{ $remesa->descripcion . ' :: ' . formato_fecha_espanol_corta($remesa->fecha) }}</option>
                            @endforeach
                        </select>
                        
                        @error('id_remesa')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
    
                    <label for="cve_ciudad" class="col-md-2 col-form-label text-md-right">{{ __('Ciudad Escuela') }} </label>
                    <div class="col-md-3">
                        <select id="cve_ciudad" name="cve_ciudad" class="form-control" @error('cve_ciudad') is-invalid @enderror aria-label="Default select example" onchange="this.form.submit()">
                            <option value=''>-- SELECCIONA CIUDAD --</option>
                            @foreach ($ciudades as $ciudad)
                                <option value="{{ $ciudad->cve_ciudad }}" {{ $ciudad->cve_ciudad == $cve_ciudad? 'selected' : '' }}>{{ $ciudad->ciudad }}</option>
                            @endforeach
                        </select>
                        
                        @error('cve_ciudad')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </form>
            {{-- <form>   --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th class="col-md-auto">#</th>
                                <th class="col-md-auto">ID</th>
                                <th class="col-md-auto">Nombre</th>
                                <th class="col-md-auto">Escuela - Ciudad</th>
                                <th class="col-md-auto">Carrera</th>
                                <th class="col-md-auto">Monto</th>
                                @if ($usertype == 1) <th class="col-md-auto"></th> @endif
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($estudiantes as $estudiante)
                                    <?php
                                        if ($estudiante->cve_ciudad_escuela == 1) $ciudadEscuela = "MZT";
                                        elseif ($estudiante->cve_ciudad_escuela == 2) $ciudadEscuela = "CLN";
                                        else $ciudadEscuela = "NULL";
                                        switch ($estudiante->cve_status)  // Se colorea el borde izquierdo de la celda de acuerdo al status del estudiante
                                        {
                                            case 1:   //RECIBIDO
                                                $color = "#9944d9"; 
                                                break;
                                            case 2:  //REVISADO
                                                $color = "#0071bc";
                                                break; 
                                            case 3: //CENSADO
                                                $color = "#7dc3f5";
                                                break; 
                                            case 4: //RECHAZADO
                                                $color = "#ff0000";
                                                break;
                                            case 5: //PENDIENTE
                                                $color = "#ffe26e";
                                                break; 
                                            case 6: //ACEPTADO
                                                $color = "#00ff00";
                                                break;
                                            case 7: //ESPECIAL
                                                $color = "#ff00ff";
                                                break; 
                                            case 8: //ACEPTADO 2.0
                                                $color = "#00a135";
                                                break;  
                                            case 9: //ESPECIAL 2.0
                                                $color = "#ff8000";
                                                break;  
                                        }
                                    ?>                
                                    <tr style="font-size:15px">
                                        <td scope="row" style="border-left: 4px solid {{ $color }}; vertical-align:middle">{{ $i++ }}</td>
                                        <td style="vertical-align:middle">{{ $estudiante->id }}</td>
                                        <td style="vertical-align:middle">{{ $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido . ' ' . $estudiante->nombre }} &nbsp;</td>
                                        <td style="vertical-align:middle">{{ $estudiante->escuela_abreviatura }} <i class="fas fa-map-marker-alt"></i> {{ $ciudadEscuela }} &nbsp;</td>
                                        <td style="vertical-align:middle">{{ $estudiante->carrera }} &nbsp;</td>
                                        <td style="vertical-align:middle">
                                        @if ($id_remesa != 0 && $cve_ciudad != 0)    
                                            {{ $monto_asignado = monto_asignado($estudiante->id_remesa, $estudiante->id) }}
                                        @endif
                                        &nbsp;</td>
                                        @if ($usertype == 1)
                                        <td style="vertical-align:middle">
                                            @if (isset($estudiante->monto))
                                            <form method="GET" action="{{ route('apoyos.asignacion-borra', [$id_remesa,$estudiante->id]) }}" >
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                                            </form>  
                                            @endif
                                        </td> 
                                        @endif                                  
                                    </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if (($id_remesa != 0  && $cve_ciudad != 0) && $i == 1)
                        <div class="col-md-6">
                            <label for="id_remesa" class="col-md-10 col-form-label text-md-right">{{ __('* Esta REMESA no tiene asignados los MONTOS.') }} </label>
                        </div>
                    @endif

                    @if ($id_remesa != 0 && $i > 1)
                        <div class="col-mx">
                            <label class="col-form-label float-left">
                                {{ $estudiantes->links('pagination::bootstrap-5') }} 
                            </label>
                            @if ($usertype == 1)
                            <form method="POST" action="{{ route('apoyos.asignacion-crea', $id_remesa) }}">
                                    @csrf
                                    <div class="col-md-0 float-right">
                                        <button id="btnAsignar" name="btnAsignar" type="submit" class="btn btn-primary btn-sm"> <i class="fas fa-hand-holding"></i> <b> &nbsp; Asignar </b> </button>
                                    </div>
                            </form>
                            @endif

                            <form method="GET" id="formReport" action="{{ route('apoyos.asignacion-pdf') }}">
                                <input id="tituloReporte" name="tituloReporte" type="hidden"  value="" class="form-control">
                                <input id="idRemesa" name="idRemesa" type="hidden"  value="{{ $id_remesa }}" class="form-control">
                                <input id="cveCiudad" name="cveCiudad" type="hidden"  value="{{ $cve_ciudad }}" class="form-control">
                                    <div class="col-md-2 float-right">
                                        <button id="btnImprimir" name="btnImprimir" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal"> <i class="fas fa-file-export"></i> <b> Lista de Raya </b> </button>
                                    </div>
                            </form>
                        </div>
                    @endif
                </div>
            {{-- </form> --}}
        </div>
    </div>
</div>
@endsection