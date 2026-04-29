<?php  
require ("config.php");
require_once("lib/laura_funciones.php");

$montofinanciar=$_POST['montofinanciar']; 
//$pagoinicial=$_POST['pagoinicial'];
$totalpagos=$_POST['totalpagos'];
$tasafin=$_POST['tasafin'];
//echo 'entre'.$montofinanciar.' ,'.$totalpagos.' ,'.$tasafin;
$resultado=determinaCorrida($montofinanciar,$totalpagos,$tasafin);
//$resultado=determinaCorrida($montototal,$pagoinicial,$totalpagos,$tasafin);


//var_dump($resultado);

$montopago=$resultado[0];
$montoultimopago=$resultado[1];
$minimo=$resultado[2];
$totpagos=$resultado[3];
//echo $montopago.','.$montoultimopago;
echo $montopago.','.$montoultimopago.','.$minimo.','.$totpagos;

?>