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
                LINE-HEIGHT:0.4cm;
            }
        </style>  
</head>
<?php 
    use App\Models\BoletoAsignado;

    $path = getcwd() . '/img/alivianate.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_aliviane = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $path = getcwd() . '/img/Logo_y_Escudo.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_admon = 'data:image/' . $type . ';base64,' . base64_encode($data);

    function folios_asignados($id_remesa, $id_estudiante)
    {
        $folios_asignados = "";
        $asignados = BoletoAsignado::where('id_remesa', $id_remesa)->where('id_estudiante', $id_estudiante)->get();

        if ($asignados->count() == 0) return "N/A";
        foreach($asignados as $asignado)
        {
            if ($asignado->folio_inicial == $asignado->folio_final) $folios_asignados = $folios_asignados . " [ " . $asignado->folio_inicial . " ] "; 
            else $folios_asignados = $folios_asignados . " [ " . $asignado->folio_inicial . " - " . $asignado->folio_final . " ] "; 
        }

        return $folios_asignados;
    }
?>
<body>
    <header style="text-align:center;">
        <table>
            <tr>
                <td style="width:8cm">
                    <img src="{{ $logo_admon }}" alt="Por tiempos mejores" style="width:100%">
                </td>
                <td style="width:12cm">
                    <h2 class="h3 text-gray-800" style="text-align:center;padding:0px;margin:0px"> <b> GOBIERNO DEL MUNICIPIO DE CONCORDIA <br> <b> {{ $tituloReporte }} </b> </h1>
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
                        <th style="vertical-align:middle;">ID</th>
                        <th style="vertical-align:middle;">Nombre</th>
                        <th style="vertical-align:middle;">Escuela - Ciudad</th>
                        <th style="vertical-align:middle;">Carrera</th>
                        <th style="vertical-align:middle;">Cant. Folios</th>
                        <th style="vertical-align:middle;">Folios</th>
                        {{-- <th style="vertical-align:middle;">Firma</th> --}}
                    </tr>
                </thead>
                <?php 
                    $salto = false;
                ?>
                <tbody>
                    @foreach ($boletos_asignados as $boletos)
                        <?php
                                if ($boletos->estudiante->cve_ciudad_escuela == 1) $ciudadEscuela = "MZT";
                                elseif ($boletos->estudiante->cve_ciudad_escuela == 2) $ciudadEscuela = "CLN";
                                $cantidad_folios = $boletos->folio_final - $boletos->folio_inicial + 1;
                        ?>
                        <tr>
                            <td style="text-align:center">{{ $i++ }}</th>
                            <td style="text-align:center">{{ $boletos->estudiante->id }}</th>
                            <td>{{ $boletos->estudiante->primer_apellido . ' ' . $boletos->estudiante->segundo_apellido . ' ' . $boletos->estudiante->nombre }}</td>
                            <td>{{ $boletos->estudiante->escuela->escuela_abreviatura . ' - ' . $ciudadEscuela }}</td>
                            <td>{{ $boletos->estudiante->carrera }}</td>
                            <td>{{ $cantidad_folios }}</td>
                            <td>{{ "[" . $boletos->folio_inicial . "-" . $boletos->folio_final . "]" }}</td>
                            {{-- <td style="width:8cm"></td> --}}
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
