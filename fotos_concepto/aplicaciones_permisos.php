<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap06"; //ap06=Permisos de Aplicacion

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	xd_update('ap06',$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion, para dar permisos de acceso a las aplicaciones de la plataforma [ap06]");
	echo "<h5>".app_detalle($id_aplicacion)."</h5>";	

	echo "<form action='aplicaciones_permisos_valida.php' method='POST'>";
	echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";
	echo "<span>";
	echo "<label for='empleado'>Seleccione a quien le ortorgara permiso:";
	echo "<select name='empleado'>";
	
		$sql = "SELECT * FROM empleados ORDER by nombre ASC";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				echo "<option value='".$f['nitavu']."'>".$f['nombre']. " (".$f['puesto']." de ".$f['departamento'].")</option>";
			}
	
	echo "</select>";
	echo "</label>";
	echo "</span>";

	

	echo "<div>";
	echo "<label for='aplicacion'>Seleccione la Applicacion a conceder acceso:";
	echo "<select name='aplicacion'>";
	
		$sql = "SELECT * FROM aplicaciones ORDER by idapp ASC";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				echo "<option value='".$f['idapp']."'>".$f['idapp']." | ".$f['nombre']. " (".$f['admin_comentario'].	") </option>";
			}
	
	echo "</select>";
	echo "</label>";
	echo "</div>";


	echo "<div>";
	echo "<label for='aplicacion_nivel'>Seleccione el nivel de Permiso:";
	echo "<select name='aplicacion_nivel'>";
	
		$sql = "SELECT * FROM aplicaciones_nivelusuario ORDER by id ASC";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				echo "<option value='".$f['id']."'>[".$f['id']."] ".$f['modo']. " </option>";
			}
				echo "<option  value='0'>Elminar permiso de uso </option>";
	
	echo "</select>";
	echo "</label>";
	echo "</div>";


	echo "<span>";
	echo "<label for='justificacion'>Describa la justificacion:<br>";
	echo "<textarea name='justificacion'></textarea>";
	echo "</label>";
	echo "</span>";


	echo "<span><div>";
	echo "<input type='submit' value='Otorgar Permiso' class='btn btn-default'>";
	echo "</div></span>";


	echo "</form>";



}
else{echo "No tiene acceso a ".$id_aplicacion;}











?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./unica/body_footer.php");
?>