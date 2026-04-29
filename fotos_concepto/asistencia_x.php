<?php
include ("./unica/body_head.php");
?>
<?php
$id = $_GET['n'];
$sql="UPDATE empleados SET control_asistencia='' WHERE nitavu='$id'";
//echo $sql;
	
			$resultado = $conexion -> query($sql);
			if ($conexion->query($sql) == TRUE)
			{
			historia ($nitavu,"Elimino de la lista de asistencia ".nitavu_nombre($id));				
			mensaje ("se ha quitado el control de asistencia a ".nitavu_nombre($_GET['n']),'asistencia.php');
			}
		else
			{
			$msg="Error inesperado ".$sql; //<-- Descripcion de error
			}
			
	
	//header("location:../index.php");
?>