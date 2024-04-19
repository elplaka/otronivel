<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
    
        <title>Sistema ALIVIAN4TE :: Gobierno del Municipio de CONCORDIA</title>
    
        <!-- Custom styles for this template-->
        <link href="{{ public_path('css/sb-admin.min.pdf.css')}}" rel="stylesheet" type="text/css">  
        <style>
            /** Define the margins of your page **/
            /* @page {
                margin: 100px 25px;
            } */

                @page{
                margin-top: 100px;
                margin-bottom: 40px;
                }

            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
            }

            html body {
                padding-top: 20px;
            }

            table {
                border-collapse:collapse;
                border-spacing:0px 0px;
            }​​​​​​​​​​​​​

            th, td, div {
                font-size: 9px;
                font-family: 'Montserrat', serif;
                color:#424242;
                LINE-HEIGHT:0.125cm;
            }
        </style>  
</head>
<?php 
    $path = getcwd() . '/img/alivianate.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_aliviane = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $path = getcwd() . '/img/Logo_y_Escudo.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_admon = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>
<body>
    <header style="text-align:center;">
        {{-- <div class="row">
            <div class="col-md-4" style="text-align:center;">
                <img src="{{ $logo_admon }}" alt="Por tiempos mejores" style="width:25%">
            </div>
            <div class="col-md-4" style="padding:0px;margin:0px">
                <h2 class="h3 text-gray-800" style="text-align:center;padding:0px;margin:0px"> <b> {{ __('GOBIERNO DEL MUNICIPIO DE CONCORDIA 2021-2024') }} </b> </h1>
            </div>
            <div class="col-md-4">
                <h1 class="h3 text-gray-800"><b>{{ $tituloReporte }} </b></h1>
            </div>
        </div> --}}
        <table>
            <tr>
                <td style="width:8cm">
                    <img src="{{ $logo_admon }}" alt="Por tiempos mejores" style="width:100%">
                </td>
                <td style="width:12cm">
                    <h2 class="h3 text-gray-800" style="text-align:center;padding:0px;margin:0px"> <b> GOBIERNO DEL MUNICIPIO DE CONCORDIA <br> {{ $tituloReporte }} </b> </h1>
                </td>
                <td style="width:5cm"> 
                    <img src="{{ $logo_aliviane }}" alt="Por tiempos mejores" style="width:95%">
                </td>
            </tr>
        </table>
    </header>
    @php
        $i = 1
    @endphp 
    {{-- <div class="row" style="padding:0px;margin:0px">
        <div class="row card-body"> --}}
            <table class="table overflow-scroll table-striped table-bordered table-sm" >
                <thead class="thead-light">
                    <tr style="color:#424242;LINE-HEIGHT:0.25cm">
                        <th style="vertical-align:middle;">#</th>
                        {{-- <th style="vertical-align:middle;">ID</th> --}}
                        <th style="vertical-align:middle;">Nombre</th>
                        {{-- <th style="vertical-align:middle;">Celular</th> --}}
                        <th style="vertical-align:middle;">Escuela</th>
                        <th style="vertical-align:middle;">Carrera</th>
                        {{-- <th style="vertical-align:middle;">Ciudad Escuela</th> --}}
                        {{-- <th style="vertical-align:middle;">Turno</th> --}}
                        {{-- <th style="vertical-align:middle;">Año Escolar</th> --}}
                        {{-- <th style="vertical-align:middle;">Promedio</th> --}}
                        {{-- <th style="vertical-align:middle;">Lugar Origen</th> --}}
                    </tr>
                </thead>
                <?php 
                    $salto = false;
                ?>
                <tbody>
                    @foreach ($estudiantes_reporte as $estudiante)
                        <tr>
                            <td style="text-align:center">{{ $i++ }}</th>
                            {{-- <td style="text-align:center">{{ $estudiante->id }}</th> --}}
                            {{-- <td>{{ date('d-m-Y', strtotime($denuncia->created_at)) }}</td> --}}
                            <td>{{ $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido . ' ' . $estudiante->nombre }}</td>
                            {{-- <td>{{ $estudiante->celular }}</td> --}}
                            <td>{{ $estudiante->escuela->escuela }}</td>
                            <td>{{ $estudiante->carrera }}</td>
                            {{-- <td>{{ $estudiante->ciudad->ciudad }}</td> --}}
                            {{-- <td>{{ substr($estudiante->turno->turno, 0, 3) }}</td> --}}
                            {{-- <td style="text-align:center">{{ $estudiante->ano_escolar }}</td> --}}
                            {{-- <td style="text-align:center">{{ number_format($estudiante->promedio, 1) }}</td> --}}
                            {{-- <td>{{ $estudiante->localidad_origen->localidad }}</td> --}}
                         </tr>                     
                    @endforeach 
                </tbody>
            </table>  
            {{-- <div style="page-break-after:always">        
            </div>                --}}
        {{-- </div>                
    </div> --}}
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Montserrat, Helvetica, sans-serif", "light");
                $pdf->text(400, 560, "Página $PAGE_NUM de $PAGE_COUNT", $font, 7, array(66/255,66/255,66/255));                
            ');
        }
    </script>  
</body>