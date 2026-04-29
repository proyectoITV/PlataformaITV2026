<?php include ("lib/body_head.php");include ("./lib/body_menu.php");?>



<?php 
$id_aplicacion ="ap82";
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	

    xd_update($id_aplicacion,$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion, para dar permisos de acceso a Bloqueo Maestro");

	
	echo "<div style='margin-top: 50px;' ></div> ";

	echo "<div id='req_mod' style='width:97%;' >";
	// echo "<div id='AppDetalle'><b>Otorgar permiso para usar Requisiciones</b></h>";

	echo "<form action='stop.php' method='POST'>";
	echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";
	echo "<div>";
	echo "<label for='empleado'>Seleccione al empleado:";
	echo "<select name='empleado'>";
	
		$sql = "SELECT * FROM empleados where estado='' ORDER by nombre ASC";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				echo "<option value='".$f['nitavu']."'>".$f['nombre']. " (".$f['puesto']." de ".$f['departamento'].")</option>";
			}
	
	echo "</select>";
	echo "</label>";
	echo "</div>";

	echo "<div><label>* Seleccione con cuidado</label>";
	echo "<input type='submit' value='Bloquear Acceso' class='Mbtn btn-cancel' name='Bloquear'>";
	echo "</div>";
	echo "</form>";
	echo "</div>";




	echo "<div style='width:100%;'>";
	echo "<h1>Los siguientes empleados actualmente tienen un bloqueo y no pueden accesar a la Plataforma:</h1>";

	echo "<table class=tabla>";
	echo "<th>Empleado: </th><th>Dpto</th><th>Quien Autorizo</th><th></th>";
	$sql = "SELECT * FROM bloqueomaestro";
	$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
	{
		echo "<tr>";
		echo "<td>".nitavu_nombre($f['Nitavu'])."</td>";
		//echo "<td>".$f['nivel']."</td>";
		echo "<td>".nitavu_puesto($f['Nitavu'])." de ".nitavu_dpto_nombre($f['Nitavu'])."</td>";
		echo "<td>".nitavu_nombre($f['Autorizo'])." el ".fecha_larga($f['Fecha'])." a las ".hora12($f['Hora'])."</td>";
		echo "<td width=20px><a href='?eliminar=".$f['Nitavu']."'><img src='icon/x.png' style='width:18px; height:18px;'></a>"."</td>";

		echo "</tr>";

	}
	echo "</table>";
	echo "<label>* Para retirar el bloqueo de clic en el icono Eliminar</label>";
	echo "</div>";
    
    


			

	if (isset($_POST['Bloquear'])){
        $empleado = $_POST['empleado'];

		$sql = "INSERT INTO bloqueomaestro (Autorizo, Nitavu, Fecha, Hora, Comentario) VALUES('$nitavu','$empleado','$fecha','$hora','')";
		if ($conexion->query($sql) == TRUE)
			{	historia($nitavu, "Realizo un Bloqueo Maestro a ".$_POST['empleado'].", ".nitavu_nombre($_POST['empleado']));				
				mensaje("Bloqueo realizado creado correctamente. A partir de ahora y hasta que lo desbloque esta persona no puede acceder a la plataforma ",'stop.php');
			}
		else {
		
			mensaje("ERROR: Ha ocurrido un error al realizar un Bloqueo Maestro ".$sql,'');
		}
		


	}

	if (isset($_GET['eliminar'])){
		$sql = "DELETE FROM bloqueomaestro WHERE Nitavu='".$_GET['eliminar']."'";
		if ($conexion->query($sql) == TRUE)
			{	historia($nitavu, "RETIRO el Bloqueo de acceso a la plataforma a ".$_GET['eliminar'].", ".nitavu_nombre($_GET['eliminar'])."");
				
				mensaje("RETIRO el Bloqueo Maestro para acceder a la plataforma correctamente ",'stop.php');
			}
		else {
			
			mensaje("ERROR: Ha ocurrido un error al REVOCAR  permiso ".$sql,'stop.php');
		}
	}


} else {Mensaje("ERROR: no tienes acceso a esta aplicacion","");}







?>

<?php 
docdigital_no(FALSE, 1); //ahorra 1 hoja
include ("lib/body_footer.php"); ?>


