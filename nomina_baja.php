<?php
require("seguridad.php");
require("components.php");
require_once("config.php");
require_once("lib/funciones.php");

// error_reporting(0); //<-- para simular produccion


$IdEmpleado = VarClean($_POST['IdEmpleado']);


$sql="UPDATE empleados SET estado='Baja por ".$nitavu."' WHERE nitavu='".$IdEmpleado."'";

//echo $sql;
//$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE) 
		{

		
		historia($nitavu,'Dio de baja al empleado '.$IdEmpleado.' desde el modulo de dispersion de nomina');		
		Toast("Empleado ".$IdEmpleado." dado de baja",0,"");

		//header('location:../index.php');	
		} 
	else 
		{
            Toast("Error al dar de baja al empleado  ".$IdEmpleado."",2,"");
		
		} 

echo "<script> ReloadContenido(); </script>";   


?>