<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ALIVIAN4TE :: Información de Registro </title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<?php 
    //require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/include/funciones.php');

    use SimpleSoftwareIO\QrCode\Facades\QrCode;

    $path = getcwd() . '/img/alivianate.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_aliviane = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $path = getcwd() . '/img/Logo_y_Escudo.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_admon = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $path = getcwd() . '/img/Pattern_Footer.svg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $footer = 'data:image/' . $type . ';base64,' . base64_encode($data);

    // $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate(URL::to("/") . '/registro' . '/' . $estudiante->id_hex));
    // $qrcode = QrCode::format('svg')->size(185)->errorCorrection('H')->generate(URL::to("/") . '/registro' . '/' . $estudiante->id_hex);
    $qrcode = base64_encode(QrCode::format('png')->size(300)->generate(URL::to("/") . '/registro' . '/' . $estudiante->id_hex));
?>

<style>
        @page {
            margin: 1.5cm 1.5cm 1.5cm 1.5cm !important;                   /*arriba, derecha, abajo, izquierda*/
        }

th, td {
        font-size: 12px;
      font-family: 'Montserrat', serif;
}

div {
    font-size: 13px;
    font-family: 'Montserrat', serif;
    padding-top: 0px;
    padding-right: 0px;
    padding-bottom: 0px;
    padding-left: 0px;
    margin-bottom: 0px;
}
    
p {
      font-size: 20px;
      font-family: 'Montserrat', serif;

  }

  h1{
    font-size: 36px;
    font-weight: bold;
    padding-top: 0px;
    padding-right: 0px;
    padding-bottom: 0px;
    padding-left: 0px;
    margin-bottom: 0px;
    margin-top: 0px;
  }

  h2{
      font-size: 16px;
      font-family: 'Montserrat', serif;
  }

  h3{
      font-size: 14px;
      font-family: 'Montserrat', serif;
  }

  footer {
  position: fixed;
  bottom: -3.5cm;
  width: 70%;
  left: 0;
  right: 0;
  padding: 10px 10px;
  /* z-index: 1000; */
}

  .ha1
  {
      font-size: 20px;
      font-family: 'Montserrat', serif;
  }
  .center {
    margin-left: auto;
    margin-right: auto;
    width: 100%;
     }


    .ha1{
        font-size: 18px;
        font-weight: bold;
    }

    .celdagris {
        text-align:left;
        margin-left:0px;
        background-color:#EEEEEE;
    }
    
    #logo_aliviane {
    padding: 0px;
}
</style>

</head>
<body style="font-family: 'Montserrat'; -webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
    <header>
        <div style="text-align:center;">
            <img src="{{ $logo_admon }}" alt="Por tiempos mejores" style="width:65%">
        </div>
    </header>
    <br>
    <div id="logo_aliviane" style="text-align:center;">
        <img src="{{ $logo_aliviane }}" style="width:30%;";>
    </div>
    <div style="text-align:center;"> <h2> CICLO ESCOLAR {{ $estudiante->ciclo->descripcion }} </h2> </div>        
  
    <table class="center" width="100%" style="border-spacing: 0px 0px;margin:0">
        <tr>
            <td width="85%" style="text-align:center;">  <h1> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DATOS DE REGISTRO <h1> </td>
            <td width="15%"> <img src="data:image/png;base64, {!! $qrcode !!}" style="width:95%;"> </td>
        </tr>
    </table> 
    <div style="text-align:center;"> <h2> INFORMACIÓN PERSONAL </h2> </div>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="20%" style="text-align:right;"> Nombre: &nbsp;  </td> <td class="celdagris" width="80%"> &nbsp; <b> {{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }} </b> </td>
        </tr>
    </table>  
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="20%" style="text-align:right;"> CURP: &nbsp;  </td> <td class="celdagris" width="25%"> &nbsp; <b> {{ $estudiante->curp }} </b> </td>
            <td width="20%" style="text-align:right;"> Fecha Nacimiento: &nbsp;  </td> <td class="celdagris" width="13%"> &nbsp; <b> {{ date('d', strtotime($estudiante->fecha_nac)) . '-' . date('m', strtotime($estudiante->fecha_nac)) . '-' . date('Y', strtotime($estudiante->fecha_nac)) }}  </b> </td>
            <td width="10%" style="text-align:right;"> Celular: &nbsp;  </td> <td class="celdagris" width="13%"> &nbsp; <b> {{ $estudiante->celular }} </b> </td>
     </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
          <td width="20%" style="text-align:right;"> E-mail: &nbsp;  </td> <td class="celdagris" width="80%"> &nbsp; <b> {{ $estudiante->email }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="20%" style="text-align:right;"> Lugar Origen: &nbsp;  </td> <td class="celdagris" width="80%"> &nbsp; <b> {{ $estudiante->localidad_origen->localidad }} </b> </td> 
            {{-- <td width="17%" style="text-align:right;"> Lugar Transporte: &nbsp; </td> <td class="celdagris" width="31%"> &nbsp; <b> {{ $estudiante->localidad_actual->localidad }} </b> </td> --}}
        </tr>
    </table>
    <div style="text-align:center;"> <h2> INFORMACIÓN ESCOLAR </h2> </div>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="26%" style="text-align:right;"> Institución Educativa: &nbsp;  </td> <td class="celdagris" width="74%"> &nbsp; <b> {{ $estudiante->escuela->escuela }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="26%" style="text-align:right;"> Carrera: &nbsp;  </td> <td class="celdagris" width="74%"> &nbsp; <b> {{ $estudiante->carrera }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="26%" style="text-align:right;"> Ciudad Escuela: &nbsp;  </td> <td class="celdagris" width="24%"> &nbsp; <b> {{ $estudiante->ciudad->ciudad }} </b> </td>
            <td width="26%" style="text-align:right;"> Turno Escuela: &nbsp;  </td> <td class="celdagris" width="24%"> &nbsp; <b> {{ $estudiante->turno->turno }} </b> </td>
        </tr>
    </table>
    <?php 
        switch ($estudiante->ano_escolar)
        {
            case 1:
                $ano_escolar = "PRIMERO";
                break;
            case 2:
                $ano_escolar = "SEGUNDO";
                break;
            case 3:
                $ano_escolar = "TERCERO";
                break;
            case 4:
                $ano_escolar = "CUARTO";
                break;
            case 5:
                $ano_escolar = "QUINTO";
                break;
            case 6:
                $ano_escolar = "SEXTO";
                break;      
        }

    ?>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="26%" style="text-align:right;"> Año Escolar: &nbsp;  </td> <td class="celdagris" width="24%"> &nbsp; <b> {{ $ano_escolar }} </b> </td>
            <td width="26%" style="text-align:right;"> Promedio Actual: &nbsp;  </td> <td class="celdagris" width="24%"> &nbsp; <b> {{ $estudiante->promedio }} </b> </td>
        </tr>
    </table> 
    <div style="text-align:center;"> <h2> INFORMACIÓN SOCIOECONÓMICA </h2> </div>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="50%" style="text-align:right;"> ¿De qué material es el techo de tu vivienda? &nbsp;  </td> <td class="celdagris" width="50%"> &nbsp; <b> {{ $estudiante->socioeconomico->techo->techo }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="50%" style="text-align:right;"> ¿Cuántos cuartos y baños disponen en tu vivienda? &nbsp;  </td> <td class="celdagris" width="50%"> &nbsp; <b> {{ $estudiante->socioeconomico->cuartos_vivienda }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="50%" style="text-align:right;"> ¿Cuántas personas viven normalmente en tu vivienda? &nbsp;  </td> <td class="celdagris" width="50%"> &nbsp; <b> {{ $estudiante->socioeconomico->personas_vivienda }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="50%" style="text-align:right;"> ¿Cuál es el monto mensual que entra a tu hogar? &nbsp;  </td> <td class="celdagris" width="50%"> &nbsp; <b> {{ $estudiante->socioeconomico->monto_mensual->monto }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="50%" style="text-align:right;"> ¿Recibes alguna beca para apoyar tus estudios? &nbsp;  </td> <td class="celdagris" width="50%"> &nbsp; <b> {{ $estudiante->socioeconomico->beca_estudios == 1 ? 'SÍ' : 'NO' }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="50%" style="text-align:right;"> ¿Recibes algún tipo de ayuda económica del gobierno?? &nbsp;  </td> <td class="celdagris" width="50%"> &nbsp; <b> {{ $estudiante->socioeconomico->ayuda_gobierno == 1 ? 'SÍ' : 'NO' }} </b> </td>
        </tr>
    </table>
    <?php  
        $empleo = false;
        if (strlen($estudiante->socioeconomico->empleo) > 0) $empleo = true;
    ?>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            @if ($empleo)
            <td width="50%" style="text-align:right;">  ¿Tienes algún empleo? &nbsp; </td> <td class="celdagris" width="5%"> &nbsp; <b> {{ $empleo ? 'SÍ' : 'NO' }} </b> </td>
            <td width="11%"style="text-align:right;">Especifica: &nbsp; </td> <td width="34%" class="celdagris"> &nbsp; <b> {{ $estudiante->socioeconomico->empleo }} </b> </td>
            @else
            <td width="50%" style="text-align:right;">  ¿Tienes algún empleo? &nbsp; </td> <td class="celdagris" width="50%"> &nbsp; <b> {{ $empleo ? 'SÍ' : 'NO' }} </b> </td>
            @endif
        </tr>   
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="50%" style="text-align:right;"> ¿Cuánto gastas en transporte diario a la escuela? &nbsp;  </td> <td class="celdagris" width="50%"> &nbsp; <b> {{ '$ ' .  number_format($estudiante->socioeconomico->gasto_transporte) . '.00' }} </b> </td>
        </tr>
    </table>
    <footer>
        <div style="text-align:center;">
            <img src="{{ $footer }}" alt="Por tiempos mejores" style="width:25cm">
        </div>
    </footer>
</body>
</html>
