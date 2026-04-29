<?php
/*FUNCIONES PERSONALIZADAS */


/*eJEMPLO */
function mifuncionx($variable){
require("config.php"); /*No mover*/

$sql = "SELECT * FROM empleados WHERE nitavu='".$variable."'";
$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['nombre'];
							
	}
	else
	{
		return FALSE;
	}
/* Return regresa el valor a la funcion*/	
}
