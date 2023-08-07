<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ALIVIAN4TE :: Información de Registro </title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<?php 
    //require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/include/funciones.php');

    // use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Support\Facades\URL;

    $path = getcwd() . '/img/alivianate.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_aliviane = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $path = getcwd() . '/img/Logo_y_Escudo.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_admon = 'data:image/' . $type . ';base64,' . base64_encode($data);

    // $qrcode = base64_encode(\QrCode::size(1000)->errorCorrection('H')->encoding('UTF-8')->format('png')->generate(URL::to("/") . '/registro' . '/' . $estudiante->id_hex));
    // Genera el código QR y guarda la imagen en la carpeta pública
    // \QrCode::size(1000)->errorCorrection('H')->encoding('UTF-8')->format('png')->generate(URL::to("/") . '/registro' . '/' . $estudiante->id_hex, public_path('img/qrcodes/codigo_qr.png'));

?>

<style>
        @page {
            margin: 1.5cm 1.5cm 1.5cm 1.5cm !important;                   /*arriba, derecha, abajo, izquierda*/
        }

th, td {
        font-size: 12px;
      font-family: 'Montserrat', serif;
      padding-left:5px 
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
    font-size: 20px;
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
{{-- <body style="font-family: 'Montserrat';  -webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;"> --}}
    <body>
     <header>
        <div style="text-align:center;">
            <img src="https://alivianate.concordia.gob.mx/img/logo_escudo.jpg" style="width:75%">
        </div>
        <br> 
        <div id="logo_aliviane" style="text-align:center;">
            <img src="https://alivianate.concordia.gob.mx/img/logo_alivianate.jpg" style="width:50%;"> &nbsp;
        </div>
    </header>
     <br>
    <div style="text-align:center;"> <h1> DATOS DE REGISTRO <h1> </div>
    <div style="text-align:center;">
       <a href="{{ url('/registro/' . $estudiante->id_hex) }}">Ver Hoja de Registro</a>
    </div>
    <div style="text-align:center;"> <h2> INFORMACIÓN PERSONAL </h2> </div>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="30%" style="text-align:right;"> Nombre: </td> <td class="celdagris" width="70%"> <b> {{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }} </b> </td>
        </tr>
    </table>  
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="30%" style="text-align:right;"> CURP:  </td> <td class="celdagris" width="70%"> <b> {{ $estudiante->curp }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">       
            <td width="30%" style="text-align:right;"> Fecha Nac:  </td> <td class="celdagris" width="70%"> <b> {{ date('d', strtotime($estudiante->fecha_nac)) . '-' . date('m', strtotime($estudiante->fecha_nac)) . '-' . date('Y', strtotime($estudiante->fecha_nac)) }}  </b> </td>
        </tr>
     </table>
     <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px"> 
            <td width="30%" style="text-align:right;"> Celular: </td> <td class="celdagris" width="70%"> <b> {{ $estudiante->celular }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
          <td width="30%" style="text-align:right;"> E-mail:  </td> <td class="celdagris" width="70%"> <b> {{ $estudiante->email }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="30%" style="text-align:right;"> Lugar Origen: </td> <td class="celdagris" width="70%">  <b> {{ $estudiante->localidad_origen->localidad }} </b> </td> 
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="30%" style="text-align:right;"> Lugar Transporte: </td> <td class="celdagris" width="70%"> <b> {{ $estudiante->localidad_actual->localidad }} </b> </td>
        </tr>
    </table>
    <br>
    <div style="text-align:center;"> <h2> INFORMACIÓN ESCOLAR </h2> </div>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="30%" style="text-align:right;"> Institución Educativa: </td> <td class="celdagris" width="70%">  <b> {{ $estudiante->escuela->escuela }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="30%" style="text-align:right;"> Carrera: </td> <td class="celdagris" width="70%"> <b> {{ $estudiante->carrera }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="30%" style="text-align:right;"> Ciudad Escuela: </td> <td class="celdagris" width="70%"> <b> {{ $estudiante->ciudad->ciudad }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="30%" style="text-align:right;"> Turno Escuela: </td> <td class="celdagris" width="70%"> <b> {{ $estudiante->turno->turno }} </b> </td>
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
            <td width="30%" style="text-align:right;"> Año Escolar: </td> <td class="celdagris" width="70%"> <b> {{ $ano_escolar }} </b> </td>
        </tr>
    </table> 
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="30%" style="text-align:right;"> Promedio Actual: </td> <td class="celdagris" width="70%"> <b> {{ $estudiante->promedio }} </b> </td>
        </tr>
    </table> 
    <br>
    <div style="text-align:center;"> <h2> INFORMACIÓN SOCIOECONÓMICA </h2> </div>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="55%" style="text-align:right;"> ¿De qué material es el techo de tu vivienda?  </td> <td class="celdagris" width="45%">  <b> {{ $estudiante->socioeconomico->techo->techo }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="55%" style="text-align:right;"> ¿Cuántos cuartos y baños disponen en tu vivienda? </td> <td class="celdagris" width="45%"> <b> {{ $estudiante->socioeconomico->cuartos_vivienda }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="55%" style="text-align:right;"> ¿Cuántas personas viven normalmente en tu vivienda? </td> <td class="celdagris" width="45%"> <b> {{ $estudiante->socioeconomico->personas_vivienda }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="55%" style="text-align:right;"> ¿Cuál es el monto mensual que entra a tu hogar?  </td> <td class="celdagris" width="45%"> <b> {{ $estudiante->socioeconomico->monto_mensual->monto }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="55%" style="text-align:right;"> ¿Recibes alguna beca para apoyar tus estudios? </td> <td class="celdagris" width="45%"> <b> {{ $estudiante->socioeconomico->beca_estudios == 1 ? 'SÍ' : 'NO' }} </b> </td>
        </tr>
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="55%" style="text-align:right;"> ¿Recibes algún tipo de ayuda económica del gobierno?? </td> <td class="celdagris" width="545%"> <b> {{ $estudiante->socioeconomico->ayuda_gobierno == 1 ? 'SÍ' : 'NO' }} </b> </td>
        </tr>
    </table>
    <?php  
        $empleo = false;
        if (strlen($estudiante->socioeconomico->empleo) > 0) $empleo = true;
    ?>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            @if ($empleo)
            <td width="55%" style="text-align:right;">  ¿Tienes algún empleo? </td> <td class="celdagris" width="5%"> <b> {{ $empleo ? 'SÍ' : 'NO' }} </b> </td>
            <td width="11%"style="text-align:right;">Especifica: </td> <td width="29%" class="celdagris"> <b> {{ $estudiante->socioeconomico->empleo }} </b> </td>
            @else
            <td width="55%" style="text-align:right;">  ¿Tienes algún empleo? </td> <td class="celdagris" width="45%"> <b> {{ $empleo ? 'SÍ' : 'NO' }} </b> </td>
            @endif
        </tr>   
    </table>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="55%" style="text-align:right;"> ¿Cuánto gastas en transporte diario a la escuela? </td> <td class="celdagris" width="45%"> <b> {{ '$ ' .  number_format($estudiante->socioeconomico->gasto_transporte) . '.00' }} </b> </td>
        </tr>
    </table>
</body>
</html>