<?php
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
?>

<?php
$id_aplicacion ="ap66"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

xd_update($id_aplicacion,$nitavu);//guarda la experiencia del usuario
historia($nitavu, "Entro a la aplicacion, para dar permisos de nivel 2 de la aplicacion Control Correspondencia");

echo "<div>";
echo "<h1>Asignar permisos a:</h1>";
echo "</div>";
echo "<div id='req_mod' style='width:80%; padding 5px;' >";
echo "<form action='cp_permisos.php' method='POST' style='width:97%;'>";
echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";
echo "<span>";
echo "<label for='empleado'>Seleccione a quien le ortorgara permiso:";
echo "<select name='empleado'>";

	$sql = "SELECT *  FROM empleados where nitavu not in (SELECT nitavu from aplicaciones_permisos where idapp='ap66') and empleados.nitavu<>".$nitavu." and empleados.dpto = ".nitavu_dpto($nitavu)." 	AND empleados.estado ='' ORDER BY nombre ASC";
	//$sql = "SELECT * FROM empleados WHERE dpto = ".nitavu_dpto($nitavu)." ORDER by nombre ASC";
	echo $sql;
	$r = $conexion -> query($sql);
	while($f = $r -> fetch_array())
		{ // resultado de la busqueda.................
			if($nitavu != $f['nitavu'] ){
				echo "<option value='".$f['nitavu']."'>".$f['nombre']. " (".$f['puesto']." de ".$f['departamento'].")</option>";

			}
		}

echo "</select>";
echo "</label>";
echo "</span>";
echo "<div>";
echo "<select name='nivel'>";
echo "<option value=1>Super Usuario (1) Todos los permisos</option>";
echo "<option value=2>Colaborador (2) Comenta, Sube archivos y Anexa </option>";
echo "<option value=3>Administrador(3) Turna, Finaliza, Sube archivos/Anexa</option>";
echo "</select>";
echo "</div>";

echo "<div>";
echo "<input type='submit' value='Dar permiso' class='Mbtn btn-default' name='submit_todos'>";
echo "</div>";
echo "</form>";
echo "</div>";

echo "<div style='width:100%;'>";
echo "<h1>Los siguientes empleados actualmente tienen permiso de nivel 2 en la aplicación:</h1>";

echo "<table class=tabla>";
echo "<th>Empleado: </th><th>Nivel</th><th>Dpto</th><th>Quien Autorizo</th><th></th>";

$sql = "SELECT * FROM aplicaciones_permisos where idapp='ap66' ";
$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
{
	if(nitavu_dpto($nitavu)== nitavu_dpto($f['nitavu'])){
		echo "<tr>";
		echo "<td>".nitavu_nombre($f['nitavu'])."</td>";
		echo "<td>".$f['nivel']."</td>";
		echo "<td>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</td>";
		echo "<td>".nitavu_nombre($f['quien_autorizo'])." el ".$f['fecha_autorizacion']."</td>";
		echo "<td width=20px><a href='?eliminar=".$f['nitavu']."'><img src='icon/x.png' style='width:18px; height:18px;'></a>"."</td>";
		echo "</tr>";
	}
	

}
echo "</table>";
echo "<label>* Para quitar el acceso de clic en el icono Eliminar</label>";
echo "</div>";
			

if (isset($_POST['submit_todos'])){
	$sql = "INSERT INTO aplicaciones_permisos (nitavu, idapp, nivel, quien_autorizo, fecha_autorizacion) VALUES ('".$_POST['empleado']."', 'ap66', ".$_POST['nivel'].", '".$nitavu."', '".$fecha."')";
	if ($conexion->query($sql) == TRUE)
		{	historia($nitavu, "Dio permiso de nivel 2 a control correspondencia a ".$_POST['empleado'].", ".nitavu_nombre($_POST['empleado']));
			notificacion_add ($_POST['empleado'], 'Acceso de nivel 2 a Control correspondencia', $fecha, $nitavu, "Le he ortorgado permisos de nivel 2 en la aplicacion control correspondenia para que usted pueda turnar peticiones y finalizarlas.");
			mensaje("Permiso creado correctamente ",'cp_permisos.php');
		}
	else {
		historia($nitavu, "ERROR al dar permiso de nivel 2 a control correspondencia".$sql);
		mensaje("Ha ocurrido un error al otorgar permiso ",'cp_permisos.php');
	}
}

if (isset($_GET['eliminar'])){
	$sql = "DELETE FROM aplicaciones_permisos WHERE nitavu='".$_GET['eliminar']."' and idapp='ap66'";
	if ($conexion->query($sql) == TRUE)
		{	historia($nitavu, "REVOCO el permiso de nivel 2 a ".$_GET['eliminar'].", ".nitavu_nombre($_GET['eliminar'])." de control correspondencia.");
			notificacion_add ($_GET['eliminar'], 'Se le ha REVOCADO el permiso de nivel 2', $fecha, $nitavu, "Le he REVOCADO el permiso de nivel 2 para usar el modulo de Control correspondencia de la Plataforma ITAVU");
			mensaje("Permiso REVOCADO creado correctamente ",'cp_permisos.php');
		}
	else {
		historia($nitavu, "ERROR al REVOCAR permiso de requisciones titulares (req_permisos) ".$sql);
		mensaje("Ha ocurrido un error al REVOCAR  permiso ",'cp_permisos.php');
	}
}

} else {
	mensaje("ERROR no tiene permisos para usar esta aplicacion",'');
}

?>




<br><br>
<?php
include ("./lib/body_footer.php");
?>