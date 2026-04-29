<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("vehiculos_fun.php");
// require_once("lib/flor_funciones.php");

$search = VarClean($_POST['search']);
$sql = "select 
IdVehiculo,	Vehiculo,Estado,	Adscripcion,	Propietario


from vehiculos_html WHERE
Placas like '%".$search."%' or
Tipo like '%".$search."%' or
Num_economico like '%".$search."%' or
Modelo like '%".$search."%' or
Serie like '%".$search."%' 


";
//echo $sql;
$r= $conexion -> query($sql);
while($f = $r -> fetch_array()) {
  // var_dump($f)  ;

}
// unset($r,$f,$sql);


//$sql="select * from vehiculos_html";
//TablaDinamica_MySQL("",$sql, "MiIdDivTabla2", "IdTabla2", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
TablaDinamica_MySQL("",$sql, "MiIdDivTabla2", "IdTabla2", "styled-table", 2,"",'LISTA DE VEHICULOS','Portrait','vehiculos'); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal

 //TablaDinamica_MySQL("",$sql,"MiIdDivTabla2","IdTabla2,","",2,);
?>