<?php
require ("config.php");
require ("lib/flor_funciones.php");

$idmandante = $_POST['idmandante'];
$idcolonia = $_POST['idcolonia'];
$idmunicipio = $_POST['idmunicipio'];
$pago = $_POST['pago'];

if($pago==''){
    $pago = 0;
}
//PORCENTAJE
$porcentaje = GastosEscMandante($idmandante,$idcolonia,$idmunicipio);
$por = $pago * $porcentaje;
$pago = $pago - $por;
//total gastos
echo $pago;

?>