<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/laura_funciones.php");


$sql="select * from convdesarroll_html";
TablaDinamica_MySQL2("",$sql, "MiIdDivTabla2", "IdTabla2", "", 2,"",'CONVENIOS DE DESARROLLADORES','Portrait','Desarrolladores'); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal

?>