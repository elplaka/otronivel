@php
    use App\Utils\HelperFunctions;
    use App\Models\BoletoAsignado;
    use App\Models\BoletosRemesa;

    if (isset(auth()->user()->usertype))
    {
        $usertype = auth()->user()->usertype;
    }
    else 
    {
        return redirect()->to('/');
    }

    $i = 1;
    $estudiantes_sin_boletos = 0;
    $id_partida_select = $id_partida;
@endphp

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

                var lInicial = $("#exampleModal #letra_inicial").val();   //Letra Inicial
                $('#letraInicial').val(lInicial);

                var lFinal = $("#exampleModal #letra_final").val();   //Letra Final
                $('#letraFinal').val(lFinal);

                //Abre el formulario con el PDF
                var f = document.getElementById("formReport");
                
                f.action = "{{ route('boletos.asignacion-pdf') }}";
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
                        <label for="recipient-name" class="col-form-label"> <b> Título del Reporte </b></label>
                        <input type="text" value="Reporte de Boletos Asignados a Estudiantes" class="form-control" id="recipient-name">
                    </div>
                    <div class="row mb-3">
                        <label for="letra_inicial" class="col-md-4 col-form-label text-md-right"> <b> Letra Inicial </b> </label>    
                        <div class="col-md-3">
                            <select id="letra_inicial" name="letra_inicial" class="form-control" required>
                                <option value=''>-</option>
                                @for ($i = 65; $i <= 90; $i++)
                                    <option value="{{ $i }}">{{ chr($i) }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="letra_inicial" class="col-md-4 col-form-label text-md-right"> <b> Letra Final </b> </label>    
                        <div class="col-md-3">
                            <select id="letra_final" name="letra_final" class="form-control" required>
                                <option value=''>-</option>
                                @for ($i = 65; $i <= 90; $i++)
                                    <option value="{{ $i }}">{{ chr($i) }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" id="btnAceptar" type="submit" class="btn btn-danger btn-sm action-complete-task">Generar</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
<div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog" aria-labelledby="confirmarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarModalLabel">Confirmar Nueva Partida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Deseas crear una nueva partida?
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('boletos.asignacion-crea', ['id_remesa' => $id_remesa, 'tipo_partida' => 2]) }}">
                    @csrf
                    <button type="submit" class="btn btn-verde">Crear Nueva Partida</button>
                </form>
                <form method="POST" action="{{ route('boletos.asignacion-crea', ['id_remesa' => $id_remesa, 'tipo_partida' => 3]) }}">
                    @csrf
                    <button type="submit" class="btn btn-rojo">Con la misma partida</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
                <h1 class="h3 mb-0 text-gray-800"> <b> Asignación de Boletos </b></h1> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <a href="{{ route('home') }}" class="float-right"> Atrás</a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('boletos.asignacion-nueva', $id_remesa) }}">
                <div class="row">
                    <label for="id_remesa" class="col-md-2 col-form-label text-md-right">{{ __('Remesa') }} </label>
                    <div class="col-md-4">
                        <select id="id_remesa" name="id_remesa" class="form-control" @error('id_remesa') is-invalid @enderror aria-label="Default select example" onchange="this.form.submit()">
                            <option value=''>-- SELECCIONA REMESA --</option>
                            @foreach ($remesas as $remesa)
                                <option value="{{ $remesa->id_remesa }}" {{ $remesa->id_remesa == $id_remesa? 'selected' : '' }}>{{ $remesa->descripcion . ' :: ' . HelperFunctions::formato_fecha_espanol_corta($remesa->fecha) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <?php
                        $remesa = BoletosRemesa::where('id_remesa', $id_remesa)->first();
                        if(!isset($remesa)) $remesa_realizada = 0;
                        else $remesa_realizada = $remesa->realizada;
                        $i=1;
                    ?>
                    <div>
                        <table>
                            <tr>
                                <td style="background:rgb(240, 240, 240)">
                                    {{ $remesa_realizada ? "Realizada" : "No realizada" }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <label for="id_partida" class="col-md-2 col-form-label text-md-right">{{ __('Partida') }} </label>
                    <div class="col-md-2">
                        <select id="id_partida" name="id_partida" class="form-control" @error('id_partida') is-invalid @enderror aria-label="Default select example" onchange="this.form.submit()">
                            <option value='-1'>-- TODAS --</option>
                            @foreach ($partidas as $partida)
                                <option value="{{ $partida }}" {{ $id_partida == $partida ? 'selected' : '' }}>
                                    {{ $partida }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
            {{-- <form>   --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-bordered" style="font-size: 9pt;">
                            <thead class="thead-light">
                            <tr>
                                <th class="col-md-auto">#</th>
                                <th class="col-md-auto">ID</th>
                                <th class="col-md-auto">Nombre</th>
                                <th class="col-md-auto">Escuela - Ciudad</th>
                                <th class="col-md-auto">Carrera</th>
                                <th class="col-md-auto">Cant. Folios</th>
                                <th class="col-md-auto">Partida/Folios</th>
                                @if ($usertype == 1) <th class="col-md-auto"></th> @endif
                            </tr>
                            </thead>
                            @if ($remesa_realizada)
                                <tbody>
                                    @foreach ($boletos_asignados as $boletos)
                                        <?php
                                            if ($boletos->estudiante->cve_ciudad_escuela == 1) $ciudadEscuela = "MZT";
                                            elseif ($boletos->estudiante->cve_ciudad_escuela == 2) $ciudadEscuela = "CLN";
                                            else $ciudadEscuela = "NULL";
                                            switch ($boletos->estudiante->cve_status)  // Se colorea el borde izquierdo de la celda de acuerdo al status del estudiante
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

                                            $cantidad_folios = $boletos->folio_final - $boletos->folio_inicial + 1;
                                         ?>                
                                        <tr style="font-size:15px">
                                            <td scope="row" style="border-left: 4px solid {{ $color }}; vertical-align:middle">{{ $i++ }}</td>
                                            <td style="vertical-align:middle">{{ $boletos->estudiante->id }}</td>
                                            <td style="vertical-align:middle">{{ $boletos->estudiante->primer_apellido . ' ' . $boletos->estudiante->segundo_apellido . ' ' . $boletos->estudiante->nombre }} &nbsp;</td>
                                            <td style="vertical-align:middle">{{ $boletos->estudiante->escuela->escuela_abreviatura }} <i class="fas fa-map-marker-alt"></i> {{ $ciudadEscuela }} &nbsp;</td>
                                            <td style="vertical-align:middle">{{ $boletos->estudiante->carrera }} &nbsp;</td>
                                            <td style="vertical-align:middle">{{ $cantidad_folios }} &nbsp;</td>
                                            <td style="vertical-align:middle">
                                            @if ($id_remesa != 0)
                                                {{ $boletos->id_partida . ' :: ' . $folios_asignados = HelperFunctions::folios_asignados($boletos->id_remesa, $boletos->estudiante->id) }}
                                            @endif
                                            </td>
                                            @if ($usertype == 1)
                                            <td style="vertical-align:middle">
                                                @if ($folios_asignados != "N/A")
                                                <form method="GET" action="{{ route('boletos.asignacion-borra', [$id_remesa,$boletos->estudiante->id]) }}" >
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
                            @else
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
                                            <td style="vertical-align:middle">{{ $estudiante->escuela->escuela_abreviatura }} <i class="fas fa-map-marker-alt"></i> {{ $ciudadEscuela }} &nbsp;</td>
                                            <td style="vertical-align:middle">{{ $estudiante->carrera }} &nbsp;</td>
                                            <td style="vertical-align:middle">{{ $estudiante->boletosTantos->cantidad_folios }} &nbsp;</td>
                                            <td style="vertical-align:middle">
                                            @if ($id_remesa != 0)
                                                 @php
                                                    $boletos = $estudiante->boletosAsignados()
                                                                ->where('id_remesa', $id_remesa)
                                                                ->first();
                                                    $id_partida = is_null($boletos) ? '' : $boletos->id_partida . ' :: ';
                                                    $folios_asignados = HelperFunctions::folios_asignados($estudiante->boletosTantos->id_remesa, $estudiante->id);
                                                    
                                                    if ($folios_asignados == 'N/A') $estudiantes_sin_boletos++;
                                                 @endphp

                                                {{ $id_partida . $folios_asignados }}
                                            @endif
                                            </td>
                                            @if ($usertype == 1)
                                            <td style="vertical-align:middle">
                                                @if ($folios_asignados != "N/A")
                                                <form method="GET" action="{{ route('boletos.asignacion-borra', [$id_remesa,$estudiante->id]) }}" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-rojo btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                                                </form>  
                                                @endif
                                            </td> 
                                            @endif                                  
                                        </tr>  
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
                    </div>
                    @if ($id_remesa != 0 && $i == 1)
                        <div class="col-md-6">
                            <label for="id_remesa" class="col-md-10 col-form-label text-md-right">{{ __('* Esta REMESA no tiene asignados los TANTOS.') }} </label>
                        </div>
                    @endif
                    @if ($id_remesa != 0 && $i > 1)
                        <div class="col-mx">
                            @if ($remesa_realizada)
                                <label class="col-form-label float-left">
                                    {{ $boletos_asignados->links('pagination::bootstrap-5') }} 
                                </label>
                            @else
                                <label class="col-form-label float-left">
                                    {{ $estudiantes->links('pagination::bootstrap-5') }} 
                                </label>
                            @endif
                            @if ($usertype == 1)
                            <form method="POST" action="{{ route('boletos.asignacion-crea', ['id_remesa' => $id_remesa, 'tipo_partida' => 1]) }}">
                                    @csrf
                                    @if($id_partida_select == -1)
                                        @if ($estudiantes_sin_boletos == $i-1)
                                        <div class="col-md-0 float-right">
                                            <button id="btnAsignar" name="btnAsignar" type="submit" class="btn btn-verde btn-sm"> <i class="fas fa-hand-holding"></i> <b> &nbsp; Asignar </b> </button>
                                        </div>
                                        @else
                                        <div class="col-md-0 float-right">
                                            <button id="btnAbrirModal" type="button" class="btn btn-dorado btn-sm" data-toggle="modal" data-target="#confirmarModal"> <i class="fas fa-hand-holding"></i> <b> &nbsp; Asignar </b> </button>
                                        </div>
                                        @endif
                                    @endif
                            </form>
                            @endif
                            <form method="GET" id="formReport" action="{{ route('boletos.asignacion-pdf') }}">
                                <input id="tituloReporte" name="tituloReporte" type="hidden"  value="" class="form-control">
                                <input id="idRemesa" name="idRemesa" type="hidden"  value="{{ $id_remesa }}" class="form-control">
                                <input id="letraInicial" name="letraInicial" type="hidden"  value="" class="form-control">
                                <input id="letraFinal" name="letraFinal" type="hidden"  value="" class="form-control">
                                    <div class="col-md-1 float-right">
                                        <button id="btnImprimir" name="btnImprimir" type="button" class="btn btn-rojo btn-sm" data-toggle="modal" data-target="#exampleModal"> <i class="fas fa-file-export"></i> <b> PDF </b> </button> 
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