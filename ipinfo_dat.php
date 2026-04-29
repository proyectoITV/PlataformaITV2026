<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("vehiculos_fun.php");
// require_once("lib/flor_funciones.php");

$sql="select * from equipos_token_html";


    TablaDinamica_MySQL("",$sql, "DivIP", "IpTabla", "", 2,"",""); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
    

?>