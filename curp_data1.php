<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/curp_fun.php");
require("lib/graficas_fun.php");

$TotaldeCurps = VCurps_total();
$TotalChecado = VCurps_checks();

$Restantes = $TotaldeCurps - $TotalChecado;

$Labels="'Por Verificar','Verificados'";
$Datas="".$Restantes.",".$TotalChecado;

echo "<script> $('#Limites').html('Limite Actual ".$CURP_limite."/".CurpLimite()."'); </script>";

echo '<div style="width:200px; height:200px;" class="Graficas" >';    
GraficaPie($Labels, $Datas, "Concentracion");
echo '</div>';


?>
 