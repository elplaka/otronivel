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
                margin-top: 80px;
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
                LINE-HEIGHT:0.175cm;
            }

            h1 {
                font-size: 12px;
                text-transform: uppercase;
                font-weight: normal;
                line-height: normal;
                margin: 6px 0 0;  /* margin, but no line-height */
            }

            h2 {
                font-size: 10px;
                text-transform: uppercase;
                background-color: #424242;
                color: white;
                font-weight: normal;
                line-height: normal;
                margin: 6px 0 0;  /* margin, but no line-height */
            }
            
        </style>  
</head>
<?php 
    use App\Models\ApoyoAsignado;

    $path = getcwd() . '/img/alivianate.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_aliviane = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $path = getcwd() . '/img/Logo_y_Escudo.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_admon = 'data:image/' . $type . ';base64,' . base64_encode($data);

    function monto_asignado($id_remesa, $id_estudiante)
    {
        $monto_asignado = ApoyoAsignado::where('id_remesa', $id_remesa)->where('id_estudiante', $id_estudiante)->first();

        if (!isset($monto_asignado)) return "N/A";

        return '$ ' . number_format($monto_asignado->monto,2);
    }
 
?>
<body>
    <header style="text-align:center;">
        <table>
            <tr>
                <td style="width:7cm">
                    <table>
                        <tr>
                            <td>       
                                <img src="{{ $logo_admon }}" alt="Por tiempos mejores" style="width:100%">
                            </td>
                        </tr>
                        <tr> 
                            <td>
                                  <b>  MCS-810101-FK0 </b>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width:12cm;">
                    <table style="text-align:center; LINE-HEIGHT:0.25cm">
                        <tr> 
                            <td> 
                               <h1 style="LINE-HEIGHT:0.25cm"> <b> MUNICIPIO DE CONCORDIA, SINALOA </b> </h1>
                            </td>
                        </tr>
                        <tr > 
                            <td> 
                                <b> ADMINISTRACIÓN 2021-2024 </b>
                            </td> 
                        </tr> 
                        <tr> 
                            <td> 
                                <h1 style="LINE-HEIGHT:0.25cm"> <b> NÓMINA PARA PAGO DE BECAS CICLO ESCOLAR 2022-2023 </b> </h1>
                            </td> 
                        </tr>
                        <tr> 
                            <td> 
                                <b> PARTIDA 4104-442001 BECAS Y OTRAS AYUDAS PARA PROGRAMAS DE EDUCACIÓN </b>
                            </td> 
                        </tr>
                    </table>
                </td>
                <td style="width:8cm"> 
                    <table>
                        <tr>
                            <td>       
                                <b>  PERIODO: </b>
                            </td>
                        </tr>
                        <tr>  
                            <td>
                                  <b>  {{ $tituloReporte }} </b>
                            </td>
                        </tr>
                    </table>
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
                        <th style="vertical-align:middle;">Lugar Origen</th>
                        <th style="vertical-align:middle;">Escuela - Ciudad</th>
                        <th style="vertical-align:middle;">Carrera</th>
                        <th style="vertical-align:middle;">Importe</th>
                        <th style="vertical-align:middle;">Firma del Beneficiario</th>
                    </tr>
                </thead>
                <?php 
                    $salto = false;
                ?>
                <tbody>
                    @foreach ($estudiantes_reporte as $estudiante)
                        <?php
                                if ($estudiante->cve_ciudad_escuela == 1) $ciudadEscuela = "MZT";
                                elseif ($estudiante->cve_ciudad_escuela == 2) $ciudadEscuela = "CLN";
                        ?>
                        <tr>
                            <td style="text-align:center;width:0.15cm">{{ $i++ }}</th>
                            <td style="text-align:center;width:0.15cm">{{ $estudiante->id }}</th>
                            <td>{{ $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido . ' ' . $estudiante->nombre }}</td>
                            <td>{{ $estudiante->lugar_origen }}</td>
                            <td>{{ $estudiante->escuela_abreviatura . ' - ' . $ciudadEscuela }}</td>
                            <td>{{ $estudiante->carrera }}</td>
                            <td style="text-align:right">{{ monto_asignado($estudiante->id_remesa, $estudiante->id) }}</td>
                            <td style="width:6cm"></td>
                         </tr>                     
                    @endforeach 
                    <tr>
                            <td colspan="6" style="text-align:center"> <b> SUMAS : </b> </th>
                            <td style="text-align:right;width:1.75cm"><b>  {{ '$ ' . number_format($suma_montos,2) }} </b></td>
                            <td style="width:6cm"></td>
                    </tr>
                </tbody>
            </table>  
            
            <br>
            <table class="table overflow-scroll table-striped table-bordered table-sm"  >
                <tr style="background:white">
                    <td>
                        FORMULÓ: M.R.Z.M
                    </td>

                    <td>
                        REVISÓ: J.A.O.S.
                    </td>

                    <td>
                        AUTORIZÓ: R.D.B.
                    </td>
                </tr>
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
