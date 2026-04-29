<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>


<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap19"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<h5>".app_detalle($id_aplicacion)."</h5>";
	// span ocupa 100% y Div 50%;

	echo "<form action='mejoras_valida.php' method='POST' enctype='multipart/form-data'>";
	echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";
	
	
	echo "<span>";
	echo "<label for='idapp'>Seleccione la aplicacion que se mejoro:";
	echo "<select name='idapp'>";
	
		$sql = "SELECT * FROM aplicaciones ORDER by idapp ASC";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				echo "<option value='".$f['idapp']."'>".$f['idapp']." | ".$f['nombre']." ver.".$f['version']."</option>";
			}
	
	echo "</select>";
	echo "</label>";
	echo "</span>";


	echo "<div>";
	echo "<label>Nivel de mejora:</label>";
	echo "<select name='mejora'>";
		echo "<option value='0.01'>Correccion</option>";
		echo "<option value='0.10'>Mejora minima</option>";
		echo "<option value='0.20'>Mejora sustancial</option>";
		echo "<option value='1.0'>Actualizacion mayor</option>";
	echo "</select>";
	echo "</div>";

	echo "<div>";
	echo "<label>Fecha de Lanzamiento:</label>";
	echo "<input type='date' value='$fecha' name='fecha_lanzamiento'>";
	echo "</div>";


		echo "<div>";
				echo "<label>Descripcion Tecnica:</label>";
				echo "<textarea name='justificacion' ></textarea>";
		echo "</div>";

	echo "<div>";
	echo "<label>Descripcion para el Usuario de la actualizacion:</label>";
	echo "<textarea name='justificacion2' ></textarea>";
	echo "</div>";

	echo "<div>";
	echo "<label>Imagen Ilustrativa:</label>";
	echo "<input type='file'  name='imagen_file'>";
	echo "</div>";

	echo "<div>";
		//echo "<label></label>";
		echo "<div><input type='submit' value='Guardar' class='btn btn-default'></div>";
	echo "</div>";

	echo sugerencia("Se le notificara a los usuarios que usan esta aplicacion; sobre los cambios realizados.",'');

	echo "</form>";





}
else{
	mensaje("Sin autorizacion para este apartado",'');
}

?>



<br><br><br><br><br>
<?php
include ("./unica/body_footer.php");
?>