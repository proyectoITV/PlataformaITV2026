<?php
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
?>

<?php
$id_aplicacion ="ap71"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    // xd_update($id_aplicacion,$nitavu);//guarda la experiencia del usuario
    // historia($nitavu, "Entro a la aplicacion, para dar permisos de nivel 2 de la aplicacion Control Correspondencia");
    docdigital_no(FALSE, 1); //ahorra 1 hoja

echo "<div>";
echo "<h1>Asignar permisos a:</h1>";
echo "</div>";
echo "<div id='req_mod' style='width:80%; padding 5px;' >";
echo "<form action='mt_permisos.php' method='POST' style='width:97%;'>";
echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";
echo "<span>";
echo "<label for='empleado'>Seleccione a quien le ortorgara permiso:";
echo "<select name='empleado'>";

	$sql = "SELECT *  FROM empleados where nitavu not in (SELECT nitavu from aplicaciones_permisos where idapp='ap71') and empleados.nitavu<>".$nitavu." and empleados.dpto = ".nitavu_dpto($nitavu)." ORDER BY nombre ASC";
	//$sql = "SELECT * FROM empleados WHERE dpto = ".nitavu_dpto($nitavu)." ORDER by nombre ASC";
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
echo "<option value=1>Administrador (1) Mismas permisos que tu</option>";
echo "<option value=2>Para Consultas (2)</option>";

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

$sql = "SELECT nitavu as Usuario, 
(select dpto from empleados where nitavu=Usuario) as Dpto,
aplicaciones_permisos.* FROM aplicaciones_permisos where idapp='".$id_aplicacion."'";
// echo $sql;
$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
{
	if(nitavu_dpto($nitavu)== nitavu_dpto($f['nitavu'])){
        if ($f['Dpto']==nitavu_dpto($nitavu)){        
            echo "<tr>";
            echo "<td>".nitavu_nombre($f['nitavu'])."</td>";
            echo "<td>".$f['nivel']."</td>";
            echo "<td>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</td>";
            echo "<td>".nitavu_nombre($f['quien_autorizo'])." el ".$f['fecha_autorizacion']."</td>";
            echo "<td width=20px><a href='?eliminar=".$f['nitavu']."'><img src='icon/x.png' style='width:18px; height:18px;'></a>"."</td>";
            echo "</tr>";
        }
	}
	

}
echo "</table>";
echo "<label>* Para quitar el acceso de clic en el icono Eliminar</label>";
echo "</div>";
			

if (isset($_POST['submit_todos'])){
	$sql = "INSERT INTO aplicaciones_permisos (nitavu, idapp, nivel, quien_autorizo, fecha_autorizacion) VALUES ('".$_POST['empleado']."', '".$id_aplicacion."', ".$_POST['nivel'].", '".$nitavu."', '".$fecha."')";
	if ($conexion->query($sql) == TRUE)
		{	historia($nitavu, "Dio permiso de nivel 2 a GeoDigitalizacion ".$_POST['empleado'].", ".nitavu_nombre($_POST['empleado']));
			notificacion_add ($_POST['empleado'], 'Acceso de nivel 2 a GeoDigitalizacion', $fecha, $nitavu, "Le he ortorgado permisos de nivel 2 en la aplicacion control correspondenia para que usted pueda turnar peticiones y finalizarlas.");
			mensaje("Permiso creado correctamente ",'mt_permisos.php');
		}
	else {
		historia($nitavu, "ERROR al dar permiso de nivel 2 a GeoDigitalizacion".$sql);
		mensaje("Ha ocurrido un error al otorgar permiso ",'mt_permisos.php');
	}
}

if (isset($_GET['eliminar'])){
	$sql = "DELETE FROM aplicaciones_permisos WHERE nitavu='".$_GET['eliminar']."' and idapp='".$id_aplicacion."'";
	if ($conexion->query($sql) == TRUE)
		{	historia($nitavu, "REVOCO el permiso de nivel 2 a ".$_GET['eliminar'].", ".nitavu_nombre($_GET['eliminar'])." de GeoDigitalizacion.");
			notificacion_add ($_GET['eliminar'], 'Se le ha REVOCADO el permiso de nivel 2', $fecha, $nitavu, "Le he REVOCADO el permiso de nivel 2 para usar el modulo de GeoDigitalizacion de la Plataforma ITAVU");
			mensaje("Permiso REVOCADO creado correctamente ",'mt_permisos.php');
		}
	else {
		historia($nitavu, "ERROR al REVOCAR permiso de GeoDigitalizacion ".$sql);
		mensaje("Ha ocurrido un error al REVOCAR  permiso ",'mt_permisos.php');
	}
}

} else {
    mensaje("ERROR: no tiene acceso a esta aplicacion",'');
}

?>




<br><br>
<?php
include ("./lib/body_footer.php");
?>