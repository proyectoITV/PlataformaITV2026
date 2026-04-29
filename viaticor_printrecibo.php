<?php
ob_start();
require("config.php");
require_once('seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');
require("var_clean.php");
require("viaticos_fun.php");

require_once("vehiculos_fun.php");// require_once("lib/flor_funciones.php");
if (isset($_GET['id'])){
    $IdReintegro = VarClean($_GET['id']);
} else {
    $IdReintegro = "";
}

$sql = "
select * from viaticosreintegrosfull WHERE IdReintegro='".$IdReintegro."'
";
//echo $sql;
$r= $conexion -> query($sql);					
if($f = $r -> fetch_array())
{
    //DATOS NECESARIOS PARA IDENTIFACION DEL PDF INSTITUCIONAL
    //Cabecera del PDF
    $TAG = "ReintegroViatico_".$f['IdReintegro'];
    $DescripcionDelArchivo = "IdViatico = ".$f['IdViatico'].", del Empleado ".$f['Empleado'].", Reintegro=$".$f['Reintegro'];
    $PDF_Titulo = "Reintegro de viaticos";
    $PDF_SubTitulo = "IdViatico: ".$f['IdViatico']."";     
    $FechaDocumento = "".fecha_larga($fecha);
    $Persona = "";
    include("_print_header.php");
    //-------------------------



    //$txtQR = $f['InputToken'];
    //pdf->write2DBarcode($txtQR, 'QRCODE,M', 168.5, 42, 32.5, 32.5, $styleqr, 'N'); 

    
    // $pdf->Cell(0, 0, 'CODE 128 C', 0, 1);
    // $pdf->write1DBarcode('0123456789', 'C128C', '', '', '', 18, 0.4, $stylebar, 'N');


    $html = 'Empleado: ('.$f['NEmpleado'].')<b>'.$f['Empleado'].'</b> <br><cite style="font-size:10px;">'.nitavu_puesto($f['NEmpleado']).', '.nitavu_dpto_nombre($f['NEmpleado']).'</cite><br><br>';

    $html.= '<b>IdViatico:</b> '.$f['IdViatico'].'. <b>Id. Recibo Reintegro:</b> '.$f['IdReintegro'].'<br>';
    $html.= 'Reintegro:<br> <b style="font-size:18px;">'.Pesos($f['Reintegro']).'</b><br>'.'<b style="font-size:7px;">'.numtoletras($f['Reintegro']).'</b><br><br>';
    $html.= '<b>Fecha del Reintegro</b>: '.$f['Fecha'].':'.$f['Hora'].'<br>';
    $html.= '<b>Cajero</b>: '.$f['Cajero'].':'.nitavu_nombre($f['Cajero']).'<br>';
    $html.= '<p style="font-size:9px;">Impreso: '.$fecha.':'.$hora.'-'.$nitavu.'</p>';
    $html.= '<span style="font-size:7px; text-align:center;">Secure:'.$f['InputToken'].'</span><br>';



    // echo $html;

    //Footer del Generador de PDF
    include("_print_footer.php");




}  else {
    echo "Recibo no encontrado";
}

?>

