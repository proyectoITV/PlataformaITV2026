<?php
include (".//seguridad.php");
require("config.php");
require("lib/funciones.php");


if (isset($_GET['id'])) {//id del registro xml
// forma simplificada
$resultado = xmlNomina($_GET['id']);
header('Content-Disposition: attachment; filename="nomina'.$_GET['id'].'.xml"');
$sql = "SELECT * FROM nominas WHERE id='".$_GET['id']."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	echo $f['xmlCont'];
}



}

?>