<?php
//include ("./lib/body_head.php");
require("config.php");
require("lib/funciones.php");

?>
<?php
$id = $_POST['id'];
$idapp = 'ap12';



//echo $dpto;
$nitavu=$_POST['nitavu'];
$id_aplicacion ="ap12"; $nivel =aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){

$sql = "SELECT * FROM aplicaciones_permisos WHERE (nitavu='".$nitavu."' AND idapp='".$idapp."')";
$rc= $conexion -> query($sql);
//echo $sql;
	if($f = $rc -> fetch_array()){ // SE ENCONTRARON PERMISOS Y SE ACTUALIZARON

	$sql="UPDATE empleados_salidas_temporal SET autorizo_nitavu='$nitavu', autorizo_fecha='$fecha', autorizo_hora='$hora', rechazada='TRUE' WHERE (id='$id')";
	// echo $sql;
	if ($conexion->query($sql) == TRUE)
			{
				$msg ="<br><br> Por medio de la presente se le informa que su Pase de salida ".pases_detalles($id)." fue <b>RECHAZADA</b>.<br><br>
				
				Cualquier aclaracion debera hacer al departamento de recursos humanos.

				<br><br>

	
			";
			notificacion_add (pases_quien($id), "Pase de salida ".$id, date('Y-m-d'), $nitavu,$msg);	
			//mensaje ("Rechazado correctamente",'auscencia_temporal_autoriza3.php');
			historia ($nitavu,"Rechazo pase de  ".pase_id_nombre($id)." con id ".$id);
			echo "Pase rechazado correctamente: ".$id;
			// header("location:../auscencia_temporal_autoriza3.php");
			}
		else
			{
			$msg="Error inesperado ".$sql; //<-- Descripcion de error
			echo "Hubo un error al rechazar el pase ".$id;
			InformaticosGo("Error al aprobar el pase ".$_POST['id'],$msg, $nitavu);
			//creamos un historial de error extraordinario
				//header("location:../lib/error.php?er=".$msg);
			}
	}
	
}
else {// NO TIENE PERMISOS Y LE AGREGAMOS

	mensaje("No tiene permiso para usar esta aplicacion",'');
}
	
	//header("location:../index.php");
?>