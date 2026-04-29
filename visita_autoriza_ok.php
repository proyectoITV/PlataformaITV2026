<?php
include ("./lib/body_head.php");
?>
<?php
$id = $_GET['id'];



$id_aplicacion ="ap15"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){

	$sql="UPDATE visitas SET autorizo_nitavu='$nitavu', autorizo_fecha='$fecha', autorizo_hora='$hora' WHERE (id='$id')";
	if ($conexion->query($sql) == TRUE)
			{
			//historia($nitavu, "Aprobo entrada de ".nitavu_nombre($id));				
			mensaje ("Aprobado Correctamente",'visitas.php');

			}
		else
			{
			$msg="Error inesperado ".$sql; //<-- Descripcion de error
			//creamos un historial de error extraordinario
				header("location:../lib/error.php?er=".$msg);
			}
			
	
}
else {// NO TIENE PERMISOS Y LE AGREGAMOS

	mensaje("No tiene permiso para usar esta aplicacion",'');
}
	
	//header("location:../index.php");
?>