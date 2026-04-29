<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>
<div id="documentar">

<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap08"; //Id de la aplicacion a cargar
//if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<h5>".app_detalle($id_aplicacion)."</h5>";
	// span ocupa 100% y Div 50%;
	xd_update('ap08',$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion [ap08], Para crear documento electronico a todos ");


	echo "<form action='documentar_todos_enviar.php' method='POST'>";
	echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";
	
	echo "<div>";
	echo "<label>Asunto:</label>";
	echo "<input type='text' name='asunto' >";
	echo "</div>";


	echo "<div>";
	echo "<label>Fecha de Entrega:</label>";
	echo "<input type='date (yyyy-mm-dd)' name='entregar_fecha' value='".$fecha."' placeholder='AAAA-MM-DD' required='required'>";
	echo "</div>";


	echo "<span>";
	echo "<label>Contenido del Documento:</label>";
	echo "<textarea name='contenido' ></textarea>";
	echo "</span>";

	echo "<div>";

		echo "<div><input type='submit' value='Enviar Doc. Electronico No. ".docdigital_no(TRUE, 0)."' class='btn btn-default'></div>";
	echo "</div>";

	echo '
		<div id="sugerencias">
		<table border="0"><tr>
		<td><img src="./icon/sugerencia.png" class="icono"></td>
		<td>
			<b>Tip:</b> En el apartado contenido, puedes copiar y pegar de otros programas tales como Microsoft Office Word, utiliza la barra de botones de estilo para adecuar tu texto lo mas apropiado que desees.
		</td></tr></table>
		</div>

	';
//}
//else{
//	mensaje("Sin autorizacion para este apartado",'');
//}



// 	echo "<div>";
// 	echo "<label for='direccion'>Enviar a todos la direccion:";
// 	echo "<select name='direccion'>";
	
// 		$sql = "SELECT * FROM direcciones ORDER by descripcion ASC";
// 		$r = $conexion -> query($sql);
// 		while($f = $r -> fetch_array())
// 			{ // resultado de la busqueda.................
// 				echo "<option value='".$f['iddir']."'>".$f['descripcion']. ")</option>";
// 			}
// 			echo "<option value='' selected='selected'>Ninguna</option>";
	
// 	echo "</select>";
// 	echo "</label>";
// 	echo "</div>";



// 	echo "<div>";
// 	echo "<label for='departamento'>Enviar a todo el departamento:";
// 	echo "<select name='departamento'>";
	
// 		$sql = "SELECT * FROM departamentos ORDER by descripcion ASC";
// 		$r = $conexion -> query($sql);
// 		while($f = $r -> fetch_array())
// 			{ // resultado de la busqueda.................
// 				echo "<option value='".$f['iddpto']."'>".$f['descripcion']. ")</option>";
// 			}
// 			echo "<option value='' selected='selected'>Ninguna</option>";
	
// 	echo "</select>";
// 	echo "</label>";
// 	echo "</div>";



// 	echo "<div>";
// 	echo "<table border='0'>";
// 	echo "<tr><td>";
// 			echo "<input type='checkbox' name='todos'>";
// 	echo "</td><td>";	
// 	echo "<B>Enviar a todo el personal.</B>";
// 	echo "</td></tr></table>";
// 	echo "</div>";


// 	echo '
// 		<div id="sugerencias">
// 		<table border="0"><tr>
// 		<td><img src="./icon/sugerencia.png" class="icono"></td>
// 		<td>
// 			Al Seleccionar que se envie a toda la direccion o todo un deparamento, incluso a todo el personal. No importa si se tiene seleccionado en la lista.


// 		</td>
// 		</tr>
// 		</table>

// 		</div>
// ';

?>


</div>
<br><br><br><br><br>
<?php
include ("./unica/body_footer.php");
?>