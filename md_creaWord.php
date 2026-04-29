<?php
require("config.php");
require_once('lib/flor_funciones.php');
//require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');

$numoficio= $_GET['numoficio'];
$fechainicio = $_GET['fechainicio'];
$fechafin = $_GET['fechafin'];

header('Content-type: application/vnd.ms-word;charset=UTF-16');
header('Content-Disposition: attachment; filename=Midocumento.doc');
//echo $Contenido;

$anio = date("Y", strtotime($fechainicio));
$mes = date("m", strtotime($fechainicio));
$mesFin = date("m", strtotime($fechafin));

$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fechaComoEntero = date('d').' de '.$meses[date('n')-1].' del '.date('Y');
$fecha =$meses[$mes-1];
$fecha2 =$meses[$mesFin-1];

$Contenido="";
$Contenido = $Contenido.'<table>';
$Contenido = $Contenido.'<tr><td align="right">'.$numoficio.'.</td></tr>';
$Contenido = $Contenido.'<tr><td align="right">Ciudad Victoria, Tam., a '.$fechaComoEntero.'.</td></tr>';
$Contenido = $Contenido.'<tr><td ></td></tr></table>';

$Contenido = $Contenido.'<table><tr><td align="left"><b>C.P. DENNISE BETSABE REYES GARZA</b></td></tr><tr><td align="left">ENCARGADA DEL DEPARTAMENTO DE CONTABILIDAD</td></tr>';
$Contenido = $Contenido.'<tr><td align="left">Y CONTROL PRESUPUESTAL. </td></tr>';
$Contenido = $Contenido.'<tr><td align="left">PRESENTE.</td></tr>';
$Contenido = $Contenido.'<tr><td ></td></tr>';
$Contenido = $Contenido.'<tr><td ></td></tr>';
$Contenido = $Contenido."</table>";

$resta = $mesFin - $mes;

$Contenido = $Contenido.'<table align="justify"><tr><td>Anexo recuperaciones de ingresos por abono a lotes correspondiente';

if($resta == 0){
    $Contenido = $Contenido.' al mes de '.$fecha.' de '.$anio.' ';
}else if($resta == 1){
    $Contenido = $Contenido.' a los meses de '.$fecha.' y '.$fecha2.' de '.$anio.' ';
}else{
    $Contenido = $Contenido.' a los meses de '.$fecha.' a '.$fecha2.' de '.$anio.' ';
}

$Contenido = $Contenido.'relacionado a las colonias con contrato de mandato para su revisi&oacute;n, registro y tr&aacute;mite correspondiente. As&iacute como tambi&eacute;n para que identifique de la cuenta de ahorro previo y se traspase a la cuenta del mandante. <br>Es importante que una vez realizados los pagos, se informe al Dpto. de Cr&eacute;dito enviando reporte y oficio de transferencia correspondiente.</td></tr></table><br><br><br><br><br><br>';

$sql = 'SELECT * FROM mandantes_abonos WHERE periodopago BETWEEN "'.$fechainicio.'" AND "'.$fechafin.'" and cancelado = 0';

$r = $conexion -> query($sql); 
$r_count = $r -> num_rows;

$Contenido = $Contenido.'<div style="margin-bottom:0px;"><span><table align="center" cellpadding="5px" border = "1" style="font-size:11px; margin-bottom: 0;">';
$Contenido = $Contenido.'<tr bgcolor="#C0BDBD">';
$Contenido = $Contenido.'<td width = "70px;" style="font-size:9px;"><b>Delegaci&oacute;n</b></td>';
$Contenido = $Contenido.'<td style="font-size:9px;"><b>Colonia</b></td>';
$Contenido = $Contenido.'<td width = "80px;" style="font-size:9px;"><b>Mandante</b></td>';
$Contenido = $Contenido.'<td style="font-size:9px;"><b>Enganche de ahorro por identificar y traspasar</b></td>';
$Contenido = $Contenido.'<td width = "70px;" style="font-size:9px;"><b>Recuperaci&oacute;n</b></td>';
$Contenido = $Contenido.'<td width = "60px;" style="font-size:9px;"><b>Gts. de Adm&oacute;n.</b></td>';
$Contenido = $Contenido.'<td width = "55px;" style="font-size:9px;"><b>Amort. Anticipo</b></td>';
$Contenido = $Contenido.'<td width = "70px;" style="font-size:9px;"><b>Devoluciones</b></td>';
$Contenido = $Contenido.'<td width = "80px;" style="font-size:9px;"><b>Importe Neto</b></td>';
$Contenido = $Contenido.'<td width = "75px;" style="font-size:9px;"><b>Observaciones</b></td>';
$Contenido = $Contenido."</tr>";
$Contenido = $Contenido."</table></span></div>";

$Contenido = $Contenido.'<div><span><table align="center" cellpadding="5px" style="font-size:12px;">';

while($f = $r -> fetch_array()){

    $Contenido = $Contenido.'<tr border="1" >';
    $Contenido = $Contenido.'<td  border="1" width = "70px;" style="font-size:9px;" >'.strtoupper(nombreMunicipio($f['idmunicipio'])).'</td>';
    $Contenido = $Contenido.'<td border="1" style="font-size:9px;">'.nombreColonia($f['idmunicipio'], $f['idcolonia']).'</td>';
    $Contenido = $Contenido.'<td border="1" width = "80px;" style="font-size:9px;">'.nombreMandante($f['idmunicipio'], $f['idcolonia'], $f['idmandante']).'</td>';
    $Contenido = $Contenido.'<td border="1" style="font-size:9px;">$'.number_format($f['enganche_ahorro'], 2, '.', ',').'</td>';
    $Contenido = $Contenido.'<td border="1" width = "70px;" style="font-size:9px;">$'.number_format($f['recuperacion'], 2, '.', ',').'</td>';
    $Contenido = $Contenido.'<td border="1" width = "60px;" style="font-size:9px;">$'.number_format($f['gastos'], 2, '.', ',').'</td>';
    $Contenido = $Contenido.'<td border="1" width = "55px;" style="font-size:9px;">$'.number_format($f['amortizacion_anticipo'], 2, '.', ',').'</td>';
    $Contenido = $Contenido.'<td border="1" width = "70px;" style="font-size:9px;">$'.number_format($f['devols'], 2, '.', ',').'</td>';
    $Contenido = $Contenido.'<td border="1" width = "80px;" style="font-size:9px;">$'.number_format($f['monto_pagado'], 2, '.', ',').'</td>';
    $Contenido = $Contenido.'<td border="1" width = "75px;" style="font-size:9px;">'.$f['observacionPago'].'</td>';
    $Contenido = $Contenido."</tr>";

}
$Contenido = $Contenido."</table></span>";
$Contenido = $Contenido."<table><tr><td><br><br><br></td></tr></table></div>";

$Contenido = $Contenido.'<table align="center">';
$Contenido = $Contenido."<tr><td><p>Atentamente</p></td></tr>";
$Contenido = $Contenido.'<tr><td></td></tr>';
$Contenido = $Contenido.'<tr><td></td></tr></table>';

$Contenido = $Contenido."<table><tr><td><p><B>LIC. HUMBERTO ALEJANDRO APARICIO GALLEGOS</B></p></td></tr>";

$Contenido = $Contenido."<table><tr><td><p>Director de Administraci&oacute;n y Finanzas</p></td></tr>";
$Contenido = $Contenido."<tr><td></td></tr>";
$Contenido = $Contenido."<tr><td></td></tr>";
$Contenido = $Contenido.'<tr><td align="left" style="font-size:9px;">c.c.p.-Lic. Manuel Agui&ntilde;aga Alejo.-Jefe del Departamento de Recursos Financieros y Gestiones.</td></tr>';
$Contenido = $Contenido.'<tr><td align="left" style="font-size:9px;">c.c.p.-Lic. Perla Denisse Gonz&aacute;lez Robles.-Encargada del Departamento de Cr&eacute;dito del ITAVU.</td></tr>';
$Contenido = $Contenido.'<tr><td align="left" style="font-size:9px;">c.c.p.-Archivo.-</td></tr>';
$Contenido = $Contenido.'<tr><td align="left" style="font-size:9px;">c.c.p.-LIC.HAAG/LIC.PGR/mtbv.-</td></tr>';
$Contenido = $Contenido.'</table>';

echo $Contenido;

?>