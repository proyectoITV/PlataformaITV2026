<?php
ob_start();
require("config.php");
require_once('seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');

//VARIABLES QUE RECIBE
$oficio = 'DGITV000676';
$direccion = 'DIRECCION GENERAL';
$departamento = 'DEPARTAMENTO DE SOPORTE TECNICO';
$clavedepto = "500 01 003 02 901";
$adscripcion = "CD. VICTORIA";
$secretaria = "INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO";
$cheque = "";
$defecha = "";
$cantidad = "1951";
$letracantidad = "UN MIL NOVECIENTOS CIENTUENTA Y UN PESOS 00/100 M.N.";
$cargobanco = "";
$nombre = "ANGEL ISRAEL ROSAS MORALES";
$numempleado = "2860";
$rfc = "ROMA840311368";
$nivel = "14";
$fechaSalida = "03/06/2021 06:00 am";
$fechaRetorno = "04/06/2021 09:00 pm";
$lugarComision = "De Victoria a Reynosa";
$especifiqueComision = "Revisión de equipos de cómputo en la Delegacion ITAVU";

/*
$oficio = $_POST['oficio'];
$direccion = $_POST['direccion'];
$departamento = $_POST['departamento'];
$clavedepto = $_POST['clavedepto'];
$adscripcion = $_POST['adscripcion'];
$secretaria = $_POST['secretaria'];
$cheque = $_POST['cheque'];
$defecha = $_POST['defecha'];
$cantidad = $_POST['cantidad'];
$letracantidad = $_POST['letracantidad'];
$cargobanco = $_POST['cargobanco'];
$nombre = $_POST['nombre'];
$numempleado = $_POST['numempleado'];
$rfc = $_POST['rfc'];
$nivel = $_POST['nivel'];
$fechaSalida = $_POST['fechaSalida'];
$fechaRetorno = $_POST['fechaRetorno'];
$lugarComision = $_POST['lugarComision'];
$especifiqueComision = $_POST['especifiqueComision'];*/

$Himporte1=0;
$Himporte2=530;
$Himporte3=0;
$Hsubtotal=530;

//alimentacion
$Aimporte1=0;
$Aimporte2=460;
$Aimporte3=0;
$Asubtotal=460;

//dias
$dias1=0;
$dias2=2;
$dias3=0;

//totales
$totales1=0;
$totales2=990;
$totales3=0;
$totalesFinal=990;

//transportacion
$transportacion='1';



//datosvehiculo
$nvehiculo='';
$autobus='X';
$particular='';
$marca='';
$modelo='';


$tipo='';
$placas='';
$cilindraje='0';

$kmsrecorridos='646';
$kmsrecorridointerno='0';
$kms='646';

$cuota='A';


$totalRecorrido='';

$preciocombustible='0';

$autobuspeaje='961.00';

$xpu='0';

$cil='9';
$totalTransportacion='961.00';

$empleado='ANGEL ISRAEL ROSAS MORALES';
$fechaletra='3 DE JUNIO DEL 2021';


$director='SALVADOR GONZALEZ GARZA';
$dirAdmon='EDGAR ELIUD ACEVEDO MEDRANO';
$organoControl='ESTANISLAO HERVERT BAUTISTA';

$t1 = '';$t2 = '';$t3 = '';$t4 = '';

$t1 = $t1. '<table>
<tr>
    <td width="50%">
        <img src="img/logotam.jpg" alt="test alt attribute" border="0" width="150px" height="50px"/>
    </td>
    <td width="50%">
        <table>
            <tr><td width="80px"></td><td colspan="2" width="230px" style="font-size:14px;" align="right"><B>RECIBO DE PAGO DE VIÁTICOS</B></td></tr>
            <tr><td width="80px" align="right" style="padding:1px;">FOLIO</td><td width="3px"></td><td border="1" width="230px" align="right"> <b>No.</b> '.$oficio.'  </td></tr>
            <tr><td width="80px"></td><td colspan="2" width="230px"></td></tr>
        </table>
    </td>
</tr>
</table><br><br>';
//border="0.2" style="padding:5px;"
$t2 = $t2. '<table border="0.2" style="padding:7px;" ><tr><td>
    <table style="padding:1px;">
        <tr>
            <td width="108px;">OFICIO, COMISION</td>
            <td width="110px;" style="border-bottom: 0.3px solid #000;"><b>'.$oficio.'</b></td>
            <td width="74px;">DIRECCION</td>
            <td width="354px;" style="border-bottom: 0.3px solid #000;"><b>'.$direccion.'</b></td>
        </tr>
        <tr>
            <td width="108px;">DEPARTAMENTO</td>
            <td width="250px;" style="border-bottom: 0.3px solid #000;"><b>'.$departamento.'</b></td>
            <td width="150px;">CLAVE DEPARTAMENTAL</td>
            <td width="138px;" style="border-bottom: 0.3px solid #000;"><b>'.$clavedepto.'</b></td>
        </tr>
        <tr>
            <td colspan="2" width="150px;">LUGAR DE ADSCRIPCION</td>
            <td colspan="2" width="495px;" style="border-bottom: 0.3px solid #000;"><b>'.$adscripcion.'</b></td>
        </tr>
    </table>
</td></tr></table><br><br>';
//border="0.2" style="padding:5px;"
$t3 = $t3. '<table style="border: 0.3px solid black; padding:7px;" ><tr><td>
    <table style="padding:1px;">
        <tr>
            <td width="170px;">RECIBI DE LA SECRETARIA DE</td>
            <td width="312px;" style="border-bottom: 0.3px solid #000;"><b>'.$secretaria.'</b></td>
            <td width="70px;">CHEQUE N°</td>
            <td width="94px;" style="border-bottom: 0.3px solid #000;"><b>'.$cheque.'</b></td>
        </tr>
        <tr>
            <td width="70px;">DE FECHA</td>
            <td width="282px;" style="border-bottom: 0.3px solid #000;"><b>'.$fecha.'</b></td>
            <td width="150px;">POR LA CANTIDAD DE $</td>
            <td width="144px;" style="border-bottom: 0.3px solid #000;"><b>'.$cantidad.'</b></td>
        </tr>
        <tr>
            <td colspan="2" width="70px;">LETRA</td>
            <td colspan="2" width="576px;" style="border-bottom: 0.3px solid #000;"><b>'.$letracantidad.'</b></td>
        </tr>
        <tr>
            <td colspan="2" width="200px;">A MI FAVOR Y CARGO DEL BANCO</td>
            <td colspan="2" width="446px;" style="border-bottom: 0.3px solid #000;"><b>'.$cargobanco.'</b></td>
        </tr>
    </table>
</td></tr></table><br><br>';
//border="0.2" style="padding:5px;"
$t4 = $t4. '<table  style="border: 0.3px solid black; padding:7px;"><tr><td>
    <table style="padding:1px;">
        <tr>
            <td width="70px;">NOMBRE</td>
            <td width="332px;" style="border-bottom: 0.3px solid #000;"><b>'.$nombre.'</b></td>
            <td width="100px;">NUM. EMPLEADO</td>
            <td width="144px;" style="border-bottom: 0.3px solid #000;"><b>'.$numempleado.'</b></td>
        </tr>
        <tr>
            <td width="50px;">R.F.C</td>
            <td width="200px;" style="border-bottom: 0.3px solid #000;"><b>'.$rfc.'</b></td>
            <td width="200px;">NIVEL DEL SERVIDOR PUBLICO</td>
            <td width="194px;" style="border-bottom: 0.3px solid #000;"><b>'.$nivel.'</b></td>
        </tr>
        <tr>
            <td width="150px;">FECHA Y HORA DE SALIDA</td>
            <td width="176px;" style="border-bottom: 0.3px solid #000;"><b>'.$fechaSalida.'</b></td>
            <td width="180px;">FECHA Y HORA DE RETORNO</td>
            <td width="140px;" style="border-bottom: 0.3px solid #000;"><b>'.$fechaRetorno.'</b></td>
        </tr>
        <tr>
            <td colspan="2" width="150px;">LUGAR DE LA COMISION</td>
            <td colspan="2" width="496px;" style="border-bottom: 0.3px solid #000;"><b>'.$lugarComision.'</b></td>
        </tr>
        <tr>
            <td colspan="2" width="150px;">ESPECIFIQUE COMISION</td>
            <td colspan="2" width="496px;" style="border-bottom: 0.3px solid #000;"><b>'.$especifiqueComision.'</b></td>
        </tr>
    </table>
</td></tr></table><br><br>';

$tablaviaticos='
<table style="border: 0.3px solid black;">
<table style="padding:1px;">
    <tr  style="font-weight:bold;">
        <td style="width:11%; text-align:center;  text-align: center;">VIATICOS</td>
        <td style="width:15%; vertical-align:middle;  text-align: center;">HOSPEDAJE</td>
        <td style="width:11%; vertical-align:middle;  text-align: center;">IMPORTE</td>
        <td style="width:15%; vertical-align:middle;  text-align: center;">ALIMENTACION</td>
        <td style="width:11%; vertical-align:middle;  text-align: center;">IMPORTE</td>
        <td style="width:15%; vertical-align:middle;  text-align: center;">DIAS</td>
        <td style="width:11%; vertical-align:middle;  text-align: center;"></td>
        <td style="width:11%; vertical-align:middle;  text-align: center;">TOTALES</td>    
    </tr>
    <tr>
        <td style="width:11%; text-align: center;">Sencillo</td>
        <td style="width:16%; text-align: center; vertical-align:middle; ">CUOTA DIARIA(I) $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$Himporte1.'</td>       
        <td style="width:16%; text-align: center; vertical-align:middle; ">CUOTA DIARIA(I) $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$Aimporte1.'</td>   
        <td style="width:16%; text-align: center; vertical-align:middle;">NUMERO DE DIAS</td>
        <td style="width:10%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$dias1.'</td>  
        <td style="width:1%;  text-align: center; vertical-align:middle;" ></td> 
        <td style="width:8%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$totales1.'</td>   
    </tr>
    <tr>
        <td style="width:11%; text-align: center;"></td>
        <td style="width:16%; text-align: center; vertical-align:middle;">CUOTA DIARIA(II) $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$Himporte2.'</td>  
        <td style="width:16%; text-align: center; vertical-align:middle;">CUOTA DIARIA(II) $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$Aimporte2.'</td>
        <td style="width:16%; text-align: center; vertical-align:middle;">NUMERO DE DIAS</td>
        <td style="width:10%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$dias2.'</td> 
        <td style="width:1%;  text-align: center; vertical-align:middle;"></td>
        <td style="width:8%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$totales2.'</td>   
    </tr>
    <tr>
        <td style="width:11%; text-align: center;"></td>
        <td style="width:16%; text-align: center; vertical-align:middle;">CUOTA DIARIA(III) $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$Himporte3.'</td> 
        <td style="width:16%; text-align: center; vertical-align:middle;">CUOTA DIARIA(III) $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$Aimporte3.'</td>
        <td style="width:16%; text-align: center; vertical-align:middle;">NUMERO DE DIAS</td>
        <td style="width:10%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$dias3.'</td>  
        <td style="width:1%;  text-align: center; vertical-align:middle;"></td> 
        <td style="width:8%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$totales3.'</td>  
    </tr>
    <tr>
        <td style="width:11%; text-align: center;"></td>
        <td style="width:15%; text-align: center; vertical-align:middle;">SUBTOTAL $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$Hsubtotal.'</td> 
        <td style="width:15%; text-align: center; vertical-align:middle;">SUBTOTAL $</td>
        <td style="width:11%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$Asubtotal.'</td> 
        <td style="width:15%; text-align: center; vertical-align:middle;"></td>
        <td style="width:10%; text-align: center; vertical-align:middle;">TOTAL</td>  
        <td style="width:1%;  text-align: center; vertical-align:middle;"></td>
        <td style="width:8%; text-align: center; vertical-align:middle; vertical-align:middle; border-bottom:  0.3px solid black; ">'.$totalesFinal.'</td>   
    </tr>
  
    <tr>
    <td style="width:0.5%;">   
    </td>
    <td Colspan="2" style="vertical-align:middle;">TRANSPORTACION</td>';
    if($transportacion==1)
    {  
           
        $tablaviaticos=$tablaviaticos.'<td Colspan="2" style="vertical-align:middle;">TERRESTRE ( <b>X</b> )</td>
        <td Colspan="2" style="vertical-align:middle;">CON RECORRIDO (  )</td>
        <td Colspan="2" style="vertical-align:middle;">AREA ( )</td>'; 

    }else if ($transportacion==2)
    {    
        $tablaviaticos=$tablaviaticos.'<td Colspan="2" style="vertical-align:middle;">TERRESTRE (  )</td>
        <td Colspan="2" style="vertical-align:middle;">CON RECORRIDO ( <b>X</b> )</td>
        <td Colspan="2" style="vertical-align:middle;">AREA ( )</td>'; 

    }
    else if ($transportacion==3)
    {    
        $tablaviaticos=$tablaviaticos.'<td Colspan="2" style="vertical-align:middle;">TERRESTRE (  )</td>
        <td Colspan="2" style="vertical-align:middle;">CON RECORRIDO (  )</td>
        <td Colspan="2" style="vertical-align:middle;">AREA ( <b>X</b> )</td>'; 

    }
       
    $tablaviaticos=$tablaviaticos.' </tr>
<tr>
<td style="width:0.5%;"></td>
    <td Colspan="3" style="vertical-align:middle;">ESPECIFIQUE RECORRIDO INTERNO</td>   
    <td Colspan="4" style=" width:57%; vertical-align:middle; border-bottom:  0.3px solid black;"></td>    
</tr>
<tr>  
<td Colspan="8">   
</td>   
</tr>   
</table></table><br><br>';


$tVehiculo='
<table style="border: 0.3px solid black;">
<table style="padding:1px;">
    <tr>
        <td style="width:0.5%;"></td>  
        <td style="width:20%">VEHICULO OFICIAL N°</td>
        <td style="width:7% vertical-align:middle;  text-align: center; border-bottom:  0.3px solid black;  font-weight: bold;">'.$nvehiculo.'</td>
        <td style="width:9% vertical-align:middle;  text-align: center;">AUTOBUS</td>
        <td style="width:7% vertical-align:middle;  text-align: center;  border-bottom:  0.3px solid black;  font-weight: bold;">'.$autobus.'</td>
        <td style="width:12% vertical-align:middle;  text-align: center;">PARTICULAR</td>
        <td style="width:9% vertical-align:middle;  text-align: center;  border-bottom:  0.3px solid black;  font-weight: bold;">'.$particular.'</td>
        <td style="width:9% vertical-align:middle;  text-align: center;">MARCA</td>
        <td style="width:9% vertical-align:middle;  text-align: center;  border-bottom:  0.3px solid black;  font-weight: bold;">'.$marca.'</td>
        <td style="width:9% vertical-align:middle;  text-align: center;">MODELO</td>
        <td style="width:8% vertical-align:middle;  text-align: center;  border-bottom:  0.3px solid black;  font-weight: bold;">'.$modelo.'</td>
        <td></td>   
    </tr>
    <tr>
        <td></td> 
        <td colspan="2" style="width:17%;  vertical-align:middle;">TIPO</td>
        <td style="width:17%; text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$tipo.'</td>
        <td colspan="2" style="width:17%;  text-align: center; vertical-align:middle; ">PLACAS</td>
        <td style="width:16%;  text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$placas.'</td>
        <td colspan="2" style=" width:17%;  text-align: center; vertical-align:middle;">CILINDRAJE</td>
        <td style="width:15%; text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$cilindraje.'</td>       
        <td></td> 
    </tr>
    
    <tr>
        <td></td> 
        <td colspan="2" style=" width:17%;  vertical-align:middle;">KMS. RECORRIDOS</td>
        <td style="width:17%; text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$kmsrecorridos.'</td>
        <td style="width:10%; text-align: center;  vertical-align:middle;">CUOTA</td>';
        if($cuota=='A')
        {
            $tVehiculo=$tVehiculo.'<td colspan="2"  style="  width:17%;text-align: center; vertical-align:middle;">(  <b>X</b>  ) A (  ) B (  ) C (  ) D</td>';
        }
        else if($cuota=='B')
        {
            $tVehiculo=$tVehiculo.'<td colspan="2"  style="  width:17%;text-align: center; vertical-align:middle;">( ) A ( <b>X</b>   ) B (  ) C (  ) D</td>';
        }
        else if($cuota=='C')
        {
            $tVehiculo=$tVehiculo.'<td colspan="2"  style="  width:17%;text-align: center; vertical-align:middle;">(  ) A (  ) B ( <b>X</b>  ) C (  )D</td>';
        }
        else 
        {
            $tVehiculo=$tVehiculo.'<td colspan="2"  style="  width:17%;text-align: center; vertical-align:middle;">(  ) A (  ) B (  ) C (  <b>X</b>  ) D</td>';
        }
          
          $tVehiculo=$tVehiculo.'<td colspan="2" style=" width:23%; text-align: center; vertical-align:middle;">TOTAL DE RECORRIDO</td>
        <td style="  width:15%;text-align: center; vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$kms.'</td>          
        <td></td> 
    </tr>
    <tr>
        <td></td> 
        <td colspan="2" style="width:25%; vertical-align:middle; " >KMS. RECORRIDO INTERNO</td>
        <td style="width:13%; text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$kmsrecorridointerno.'</td>
        <td colspan="2" style="width:20%; text-align: center; vertical-align:middle;">PRECIO COMBUSTIBE</td>
        <td style="width:13%; text-align: center;vertical-align:middle; border-bottom:  0.3px solid black; font-weight: bold;">'.$preciocombustible.'</td>
        <td colspan="2" style="width:20% text-align: center; vertical-align:middle;">AUTOBUS/PEAJE/TAXI</td>
        <td style="width:8%;  text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$autobuspeaje.'</td>
        <td></td>        
    </tr>
    <tr> 
        <td></td>      
        <td style="width:10%;">KMS.</td>      
        <td style="width:10%;text-align: center;vertical-align:middle; border-bottom:  0.3px solid black; font-weight: bold;">'.$kms.'</td>  
        <td style="width:10%; text-align: center; ">(X) P/U</td>      
        <td style="width:10%;text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$xpu.'</td> 
        <td style="width:10%; text-align: center; ">(/)CIL</td>      
        <td style="width:10%;text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$cil.'</td>   
        <td colspan="2" style="width:30%; text-align: center; ">TOTAL DE TRANSPORTACION</td>      
        <td style="width:9%; text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$totalTransportacion.'</td>
        <td></td>       
    </tr>
    <tr>
        <td></td> 
        <td Colspan="4" style="text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$empleado.'</td> 
        <td  style="whidth:2%"></td>    
        <td Colspan="4" style="text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;  font-weight: bold;">'.$fechaletra.'</td>  
        <td></td>   
    </tr>
    <tr>
        <td></td> 
        <td Colspan="4" style="text-align: center;vertical-align:middle;">COMISIONADO</td> 
        <td  style="whidth:2%"></td>    
        <td Colspan="4" style="text-align: center;vertical-align:middle;"></td>    
        <td></td> 
    </tr>
</table></table><br><br>';


$tFirmas='
<table style="border: 0.3px solid black;">
<table style="padding:2px;">   
    <tr>
    <td colspan="11" style="height:50px;"></td> 
    </tr>
    <tr>  
    <td></td> 
    <td colspan="4" style="text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;"></td> 
    <td style="whidth:2%"></td>    
    <td colspan="4" style="text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;"></td>  
    <td></td>  
    </tr>
    <tr>
        <td></td> 
        <td colspan="4" style="text-align: center;vertical-align:middle; font-weight: bold;">'.$director.'</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle; font-weight: bold;">'.$organoControl.'</td>  
        <td></td>  
    </tr>
    <tr>
        <td></td>  
        <td colspan="4" style="text-align: center;vertical-align:middle;">DIRECTOR GENERAL</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle;">ORGANO DE CONTROL</td> 
        <td></td>            
    </tr>
    <tr>
        <td></td>  
        <td colspan="4" style="text-align: center;vertical-align:middle; ">(NOMBRE Y FIRMA)</td> 
        <td cstyle="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle; ">(NOMBRE Y FIRMA)</td> 
        <td></td>           
    </tr>
    

    <tr>
    <td colspan="11" style="height:50px;"></td> 
    </tr>

    <tr>  
    <td></td> 
    <td colspan="4" style="text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;"></td> 
    <td style="whidth:2%"></td>    
    <td colspan="4" style="text-align: center;vertical-align:middle; border-bottom:  0.3px solid black;"></td>  
    <td></td>  
    </tr>
    <tr>
        <td></td>  
        <td colspan="4" style="text-align: center;vertical-align:middle; font-weight: bold;">'.$dirAdmon.'</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle; font-weight: bold;">'.$empleado.'</td>    
        <td></td>  
    </tr>
    <tr>
        <td></td>  
        <td colspan="4" style="text-align: center;vertical-align:middle; ">DIRECTOR ADMINISTRATIVO</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle;" >RECIBE Y CHEQUE</td>  
        <td></td>           
    </tr>
    <tr>
        <td></td>  
        <td colspan="4" style="text-align: center;vertical-align:middle; ">(NOMBRE Y FIRMA)</td> 
        <td style="whidth:2%"></td>    
        <td colspan="4" style="text-align: center;vertical-align:middle; ">(NOMBRE Y FIRMA)</td> 
        <td></td>           
    </tr>
    
</table></table> <br><br>';

$tabla=$t1.$t2.$t3.$t4.$tablaviaticos.$tVehiculo.$tFirmas;
//echo $tabla;

$orientacion='P';
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetKeywords('Reporte ITAVU');
//$pdf->SetHeaderData('pdf_logo.jpg', '40','', '');

//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//$pdf->SetFooterData("Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu),array(0, 64, 0),array(0, 64, 128));
$pdf->SetFooterData('c', 0, 'xd', 'hola');
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
	require_once(dirname(__FILE__).'pdf/lang/eng.php');
	$pdf->setLanguageArray($l);
}
// set font
$pdf->SetFont('helvetica', '', 9);
// add a page
$pdf->AddPage('P', 'LETTER');
//$pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');
//$pdf->AddPage($orientacion); //en la tabla de reporte L o P
$html = $tabla;
//echo $html; aqui escribe el contenido de la consulta
    
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
//Close and output PDF document}
ob_end_clean();
$pdf->Output('reporte.pdf', 'I');

?>