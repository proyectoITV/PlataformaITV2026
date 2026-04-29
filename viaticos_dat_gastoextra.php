<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

// $IdGasto = VarClean($_POST['IdGasto']);
$IdViatico = VarClean($_POST['IdViatico']);

$sql="
select 
GastoExtra, Cantidad, Cancelar
from viaticosgastosextras_html
where IdViatico='".$IdViatico."'
";
TablaDinamica_MySQL("",$sql, "DivGastosExtras", "TablaGastosExtras", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
?>
