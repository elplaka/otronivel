@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <script language="JavaScript" type="text/javascript">
        $(document).ready(function () {
            $('#btnNuevo').click(function(){
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
                
                f.action = "{{ route('estudiantes.pdf') }}";
            
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
                    <h5 class="modal-title" id="exampleModalLabel"><b> <i class="fas fa-ticket"></i> Agregar Boletos</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> &times; </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label"> <b> Periodo </b></label>
                        <input type="text" value="Reporte de Estudiantes" class="form-control" id="recipient-name">
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" id="btnAceptar" type="submit" class="btn btn-danger btn-sm action-complete-task">Generar</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row justify-content-end mb-2">
                        <a href="{{ route('estudiantes.index') }}" class="float-right"><b><i class="fas fa-angles-left"></i>&nbsp; Atrás &nbsp;&nbsp;&nbsp;&nbsp;</b></a>
                    </div> 
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center mb-0">
                                <h1 class="h3 mb-4 text-gray-800"> <b>{{ __('Asignación de Boletos') }} </b> </h1>
                            </div>
                            <?php  
                                if (session()->has('msg_type'))  $msg_type = session()->get('msg_type');
                                else $msg_type = "info";
                            ?>
                            <div>
                                @if (session()->has('message'))
                                <div class="alert alert-{{ $msg_type }} mb-0">                        
                                    <button type="button" class="close" data-dismiss="alert">
                                        &times;
                                    </button>                        
                                    {!! html_entity_decode(session()->get('message')) !!}
                                </div>
                                <br>
                                @endif 
                            </div>
                            <div class="card" style="background:#d6c3e1; color:#562b50">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">
                                        &times;
                                    </button> 
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <table class="table-striped table-sm">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:right">Nombre: </td>
                                            <td><b>{{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }} </b></td>
                                        </tr> 
                                        <tr>
                                            <td style="text-align:right">Escuela:</td>
                                            <td><b>{{ $estudiante->escuela->escuela }} </b></td>
                                        </tr> 
                                        <tr>
                                            <td style="text-align:right">Carrera:</td>
                                            <td><b>{{ $estudiante->carrera }} </b></td>
                                        </tr> 
                                        <tr>
                                            <td style="text-align:right">Ciudad Escuela:</td>
                                            <td><b>{{ $estudiante->ciudad->ciudad }} </b></td>
                                        </tr> 
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div>
                            <h4 class="h4 text-gray-800"> <b> Historial </b> <button id="btnNuevo" name="btnNuevo" type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#exampleModal" title="Agregar boletos..."> </i> <b> + </b> </button> </h4>
                            </div>
                            <div class="card">
                                <table class="table-striped table-sm">
                                    <tbody>
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="col-md-auto">Año</th>
                                                <th class="col-sm-4">Periodo</th>
                                                <th class="col-sm-2">Folios</th>
                                            </tr>
                                        </thead>
                                        @foreach ($boletos as $boleto)
                                        <tr>
                                            <td style="text-align:right">{{ $ano }} </td>
                                            <td> {{ $boleto->periodo }}</td>
                                            <td> {{ $boleto->folio }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection