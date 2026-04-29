<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap49.5"; //ap06=Permisos de Aplicacion

echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	xd_update($id_aplicacion,$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion, para dar permisos de acceso a Requisiciones");

	
	echo "<div style='margin-top: 50px;' ></div> ";

	echo "<div id='req_mod' >";
	// echo "<div id='AppDetalle'><b>Otorgar permiso para usar Requisiciones</b></h>";

	echo "<form action='req_permisos.php' method='POST'>";
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
	echo "<input type='submit' value='Dar permiso' class='Mbtn btn-default' name='submit_todos'>";
	echo "</div>";
	echo "</form>";
	echo "</div>";

	echo "<div id='req_mod'>";//----------------------------------
	// echo "<div id='AppDetalle'><b>Otorgar permiso para Titulares de Dpto</b></div>";

	echo "<form action='req_permisos.php' method='POST'>";
	echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";
	echo "<span>";
	echo "<label for='empleado'>Seleccione a quien le ortorgara permiso:";
	echo "<select name='empleado'>";
	
	$sql = "SELECT * from cat_gerarquia WHERE titular<>''";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				echo "<option value='".$f['titular']."'>".nitavu_nombre($f['titular']). " (".nitavu_puesto($f['titular'])." de ".nitavu_dpto_nombre($f['titular']).")</option>";
			}
	
	echo "</select>";
	echo "</label>";
	echo "</span>";

	echo "<div>";
	echo "<input type='submit' value='Dar permiso' class='Mbtn btn-default' name='submit_titulares'>";
	echo "</div>";
	echo "</form>";
	echo "</div>";

	


	echo "<div style='width:100%;'>";
	echo "<h1>Los siguientes empleados actualmente tienen acceso a la Aplicacion de Requisiciones:</h1>";

	echo "<table class=tabla>";
	echo "<th>Empleado: </th><th>Dpto</th><th>Quien Autorizo</th><th></th>";
	$sql = "SELECT * FROM aplicaciones_permisos where idapp='ap49'";
	$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
	{
		echo "<tr>";
		echo "<td>".nitavu_nombre($f['nitavu'])."</td>";
		//echo "<td>".$f['nivel']."</td>";
		echo "<td>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</td>";
		echo "<td>".nitavu_nombre($f['quien_autorizo'])." el ".$f['fecha_autorizacion']."</td>";
		echo "<td width=20px><a href='?eliminar=".$f['nitavu']."'><img src='icon/x.png' style='width:18px; height:18px;'></a>"."</td>";

		echo "</tr>";

	}
	echo "</table>";
	echo "<label>* Para quitar el acceso de clic en el icono Eliminar</label>";
	echo "</div>";
	$reso = "	<p>
		Se hace de su conocimiento que es usted patrimonialmente responsable, y responderá
		civilmente por los daños y perjuicios ocasionados en caso de que exista un uso indebido
		de las facultades otorgadas por el ITAVU, ya sea por omisión, dolo o negligencia, y se le
		apercibe de que será sancionado con el rigor de las penas establecidas en la Ley de
		Responsabilidad de los Servidores Públicos del Estado y en la legislación Penal vigente.
		</p>


		<p>
		 Al ser usuario del sistema se le hacen las siguientes recomendaciones y aclaraciones:
		<lu>
		<li>El acceso y contraseña que le será otorgado son exclusivos para su uso personal. <li>
		<li> No deberá proporcionar estos datos a ninguna otra persona.</li>
		<li> En caso de uso indebido del sistema, usted responderá a los movimientos realizados con su usuario, ya
		que se registran sus datos durante la operación del mismo.</li>
		<li>Cada vez que deje de utilizar el sistema se recomienda asegurarse cerrar su sesión, ya que en caso de
		dejarla abierta, cualquier persona podrá hacer uso de él con su cuenta.</li>
		<lu>
		</p>";
			

	if (isset($_POST['submit_todos'])){
		$sql = "INSERT INTO aplicaciones_permisos (nitavu, idapp, nivel, quien_autorizo, fecha_autorizacion) VALUES ('".$_POST['empleado']."', 'ap49', '3', '".$nitavu."', '".$fecha."')";
		if ($conexion->query($sql) == TRUE)
			{	historia($nitavu, "Dio permiso para usar requisicones a ".$_POST['empleado'].", ".nitavu_nombre($_POST['empleado']));
				notificacion_add ($_POST['empleado'], 'Acceso a Requisicones', $fecha, $nitavu, "Le he ortorgado permiso para usar el modulo de Requisiciones de la Plataforma ITAVU".$reso);
				mensaje("Permiso creado correctamente ",'req_permisos.php');
			}
		else {
			historia($nitavu, "ERROR al dar permiso de requisciones (req_permisos) ".$sql);
			mensaje("Ha ocurrido un error al otorgar permiso ",'req_permisos.php');
		}
		


	}

	if (isset($_POST['submit_titulares'])){
		$sql = "INSERT INTO aplicaciones_permisos (nitavu, idapp, nivel, quien_autorizo, fecha_autorizacion) VALUES ('".$_POST['empleado']."', 'ap49', '3', '".$nitavu."', '".$fecha."')";
		if ($conexion->query($sql) == TRUE)
			{	historia($nitavu, "Dio permiso para usar requisicones a ".$_POST['empleado'].", ".nitavu_nombre($_POST['empleado'])." titular de ".nitavu_dpto(soytitular($_POST['empleado'])));
				notificacion_add ($_POST['empleado'], 'Acceso a Requisicones', $fecha, $nitavu, "Le he ortorgado permiso para usar el modulo de Requisiciones de la Plataforma ITAVU".$reso);
				mensaje("Permiso creado correctamente ",'req_permisos.php');
			}
		else {
			historia($nitavu, "ERROR al dar permiso de requisciones titulares (req_permisos) ".$sql);
			mensaje("Ha ocurrido un error al otorgar permiso ",'req_permisos.php');
		}

	}

	if (isset($_GET['eliminar'])){
		$sql = "DELETE FROM aplicaciones_permisos WHERE nitavu='".$_GET['eliminar']."' and idapp='ap49'";
		if ($conexion->query($sql) == TRUE)
			{	historia($nitavu, "REVOCO el permiso para usar requisiciones a ".$_GET['eliminar'].", ".nitavu_nombre($_GET['eliminar'])."");
				notificacion_add ($_GET['eliminar'], 'Se le ha REVOCADO el acceso a Requisicones', $fecha, $nitavu, "Le he REVOCADO el permiso para usar el modulo de Requisiciones de la Plataforma ITAVU");
				mensaje("Permiso REVOCADO creado correctamente ",'req_permisos.php');
			}
		else {
			historia($nitavu, "ERROR al REVOCAR permiso de requisciones titulares (req_permisos) ".$sql);
			mensaje("Ha ocurrido un error al REVOCAR  permiso ",'req_permisos.php');
		}
	}
}
else{mensaje("No tiene acceso a ".$id_aplicacion,'');}











?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>