<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/curp_fun.php");
require("lib/graficas_fun.php");

echo "Consultados: <b>".VCurps_checks()."</b><br>";
?>
 