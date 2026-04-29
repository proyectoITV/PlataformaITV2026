<?php
include ("./lib/body_head.php");
?>

<?php
$id_aplicacion ="ap19"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	//echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

		$idapp = $_POST['idapp'];
		$fecha_lanzamiento = $_POST['fecha_lanzamiento'];
		$mejora = $_POST['mejora'];
		$descripcion_tec = $_POST['justificacion'];
		$descripcion_us = $_POST['justificacion2'];
		//$autor = $_POST['nitavu_'];

		$msgn = "De manera automatizada se envia esta notificacion por una actualizacion ";
		$msgn = $msgn." en la aplicacion ".app_descripcion($idapp)."(".$idapp.")";
		$msgn = $msgn." Cambios:<br><br>";
		

		$sql = "SELECT * FROM aplicaciones WHERE (idapp='".$idapp."')";
		$rc= $conexion -> query($sql);

		if($f = $rc -> fetch_array())
		{	$msg="";
			$version_old = $f['version'];
			$version_new = $version_old + $mejora;
			$msgn = $msgn."Version:".$version_new."<br>";
			$msgn = $msgn."".$descripcion_us."<br>";

			$archivo = "fotos/app_".$idapp."_".$version_new;
			$sql = "INSERT INTO aplicaciones_historia
				(version, version_old, autor, descripcion_tec, descripcion_us, fecha_lanzamiento, niveldeactualizacion, archivofoto, idapp)
				VALUES
				('$version_new', '$version_old', '$nitavu', '$descripcion_tec', '$descripcion_us','$fecha_lanzamiento','$mejora','$archivo','$idapp')";
			if ($conexion->query($sql) == TRUE)
			{// guardar la version
				subir('imagen_file', $archivo, 'jpg');
				$msg= $msg."Mejora guardada correctamente. <br>";

			$sql="UPDATE aplicaciones SET version='".$version_new."' WHERE (idapp='".$idapp."')";
			$resultado = $conexion -> query($sql);
			if ($conexion->query($sql) == TRUE){
				$msg= $msg."Actualizacion de la version. <br>";


				

				notifica_mejora($idapp, $msgn, $nitavu);
				mensaje($msg,'');
				

			}


				///$idapp=; //NOTIFICA A LOS QUE TIENEN PERMISOS PARA USAR ESTA APLICACION
				//notifica (titular('4'), "BAJA de Personal ".$no, date('Y-m-d'), $quien,$msg); //JAVIER
				
				
			}
			else{
					mensaje("Ha habido un error (".$sql.")",'');
			}





		}
		
		else
		{
			mensaje("Ha habido un error (".$sql.")",'');
		}

				


}// san pedro
else
{
	mensaje("no tiene acceso a esta aplicacion",'');
}

?>