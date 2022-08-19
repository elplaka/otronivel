<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ALIVIAN4TE :: Información de Registro </title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<?php 
    //require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/include/funciones.php');

    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Support\Facades\URL;

    $path = getcwd() . '/img/alivianate.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_aliviane = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $path = getcwd() . '/img/Logo_y_Escudo.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_admon = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $qrcode = base64_encode(\QrCode::size(1000)->errorCorrection('H')->encoding('UTF-8')->format('png')->generate(URL::to("/") . '/estudiantes/formulario-final' . '/' . $estudiante->id_hex));
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
<body style="font-family: 'Montserrat'; -webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
    <header>
        <div style="text-align:center;">
            <img src="{{ $logo_admon }}" style="width:85%">
        </div>
    </header>
    <br>
    <div id="logo_aliviane" style="text-align:center;">
        <img src="{{ $logo_aliviane }}" style="width:55%;">
    </div>
    <div style="text-align:center;"> <h2> ESTUDIANTE </h2> </div>
    <table class="center" width="100%" style="border-spacing: 0px 2px;">
        <tr style="padding-bottom:1px">
            <td width="30%" style="text-align:right;"> Nombre: </td> <td class="celdagris" width="70%"> <b> {{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }} </b> </td>
        </tr>
    </table>  
    <div style="text-align:center;"> <h2> CÓDIGO QR PARA LA ACTUALIZACIÓN DE LA INFORMACIÓN DE REGISTRO <h2> </div>
    <div id="logo_aliviane" style="text-align:center;">
        <img src="data:image/png;base64, {!! $qrcode !!}" style="width:20%;">
    </div>
     <br>
    <div style="text-align:center;"> <h2> LINK PARA LA ACTUALIZACIÓN DE LA INFORMACIÓN DE REGISTRO <h2> </div>
    <div> <a href="{{ URL::to("/") . "/estudiantes/formulario-final/" . $estudiante->id_hex }}"> Ir al formulario ...  </a> </div>
</body>
</html>