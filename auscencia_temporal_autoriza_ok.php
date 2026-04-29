<?php
//include ("./lib/body_head.php");
require("config.php");
require("lib/funciones.php");
require("lib/flor_funciones.php");

?>
<?php
$id = $_POST['id'];
$idapp = 'ap12';


$id_aplicacion ="ap12"; //
$nitavu=$_POST['nitavu'];
$id_aplicacion ="ap12"; $nivel =aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){


	$sql = "SELECT * FROM aplicaciones_permisos WHERE (nitavu='".$nitavu."' AND idapp='".$idapp."')";
	$rc= $conexion -> query($sql);
	//echo $sql;
	if($f = $rc -> fetch_array()){ // SE ENCONTRARON PERMISOS Y SE ACTUALIZARON

		$sql="UPDATE empleados_salidas_temporal SET autorizo_nitavu='$nitavu', autorizo_fecha='$fecha', autorizo_hora='$hora' WHERE (id='$id')";
		if ($conexion->query($sql) == TRUE)
				{

				$msg ="<br><br> Por medio de la presente se le informa que su Pase de salida ".pases_detalles($id)." fue <b>APROBADO</b>.<br><br>
					
					Le recordamos que en caso de no ser un permiso para almuerzo y no haya adjuntado el documento justificante, debera pasar al departamento de recursos humanos para llevar dicho documento.

					<br><br>

		
				";
				// notificacion_add (pases_quien($id), "chat", $nitavu,"Ya aprobe tu pase de salida de hoy ".fecha_larga($fecha));	
				// notificacion_add (pases_quien($id), "Pase de salida ".$id, date('Y-m-d'), $nitavu,"Ya aprobe tu pase de salida de hoy ".fecha_larga($fecha));	
				historia ($nitavu,"Aprobo pase de salida de  ".pase_id_nombre($id).", con id ".$id);
				//mensaje ("Aprobado Correctamente",'auscencia_temporal_autoriza3.php');
				// header("location:../auscencia_temporal_autoriza3.php");
				
				echo "Pase autorizado con exito: ".$id;
				}
			else
				{
				$msg="Error inesperado ".$sql; //<-- Descripcion de error
				InformaticosGo("Error al aprobar el pase ".$_POST['id'],$msg, $nitavu);
				//creamos un historial de error extraordinario
					// header("location:../lib/error.php?er=".$msg);
					echo "Fallo al utorizadar: ".$id;
				}
		}	
	
}
else {// NO TIENE PERMISOS Y LE AGREGAMOS

	mensaje("No tiene permiso para usar esta aplicacion",'');
}
	
	//header("location:../index.php");
?>