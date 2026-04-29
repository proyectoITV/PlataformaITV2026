<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>
<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap26"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){

	xd_update('ap26',$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion para Configurar la asistencia y ver el reporte [ap26]");
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	
	echo "<form action='asistencia.php' method='post' class='cuadro' style='height: auto;'>";
	echo "<label for='empleado'>Selecciona a los empleados que se manejaran con asistencia</label>";

	echo "<div>";
	echo "<select name='empleado'>";
	$sql = "SELECT * FROM empleados WHERE control_asistencia='' ORDER by nombre ASC";
	$r = $conexion -> query($sql);
	while($f = $r -> fetch_array())
	{ echo "<option value='".$f['nitavu']."'>".$f['nombre']." (".$f['puesto']." de ".$f['departamento'].")</option>";}							
	echo "</select>";
	echo "</div>";


	echo "<div>";
	echo "<input type='submit' value='Agregar empleado a control de asistencia' class='Mbtn btn-danger'>";
	echo "</div>";


	echo "<div><table class='tabla'>";
	echo "<tr class='tabla_tr titutlo'>";
	echo "<td>No. de ITAVU</td>";
	echo "<td>Nombre</td>";
	echo "<td></td>";
	echo "</tr>";
	$sql = "SELECT * FROM empleados WHERE control_asistencia='TRUE' ORDER by nombre ASC";
	$r = $conexion -> query($sql);
	while($f = $r -> fetch_array())
	{ 
		echo "<tr class='tabla_tr'><td>".$f['nitavu']."</td><td>".$f['nombre']."</td><td><a href='asistencia_x.php?n=".$f['nitavu']."'>Elminar</a></td></tr>";
	}							
	echo "</table></div>";

	

echo "</form>";

if (isset($_POST['empleado'])){
	$sql="UPDATE empleados SET control_asistencia='TRUE' WHERE (nitavu='".$_POST['empleado']."')";
			$resultado = $conexion -> query($sql);
			if ($conexion->query($sql) == TRUE)
				{
				mensaje ("A partir de ahora aparecera en el modulo de vigilancia para llevar su control",'asistencia.php');
				}
			else {mensaje ("Error ".$sql);}
}








	echo "<form action='asistencia.php' method='GET' class='cuadro'>";
	echo "<span class='tenue grande'>REPORTE DE ASISTENCIA</span>";
	echo "<div>";
				echo "<div>";
				echo "<label>Desde:</label>";
				echo "<input type='date' name='desde' value='".$fecha."'>";
				echo "</div>";


				echo "<div>";
				echo "<label>Hasta:</label>";
				echo "<input type='date' name='hasta' value='".$fecha."'>";
				echo "</div>";	
		echo "</div>";
		echo "<div>";
		//echo "<label>Haga clic aqui</label>";
		echo "<input type='submit' name='' value='Consultar' class='Mbtn btn-danger'>";
		echo "</div>";	

	
	echo "</form>";


if (isset($_GET['desde'])){
	echo "<div><table class='tabla'>";
	echo "<tr class='tabla_tr titutlo'>";
	echo "<td>Nombre</td>";
	echo "<td>Entrada</td>";
	echo "<td>Salida</td>";
	echo "<td>Tiempo</td>";
	echo "<td>Fecha</td>";
	echo "</tr>";
	$sql = "SELECT * FROM asistencia WHERE (fecha>='".$_GET['desde']."' AND fecha<='".$_GET['hasta']."') ORDER by fecha, entrada ASC";
	//echo $sql;
	echo "<b class='grande'>Lista de asistencia desde ".fecha_larga($_GET['desde'])." hasta ".fecha_larga($_GET['hasta']).":</b>";
	$r = $conexion -> query($sql);
	while($f = $r -> fetch_array())
	{ 
		$t =  tiempo_restar_hr($f['entrada'],$f['salida']);
		echo "<tr class='tabla_tr'><td>".nitavu_nombre($f['nitavu'])."</td><td>".$f['entrada']."</td><td>".$f['salida']."</td><td>".$t."</td><td>".$f['fecha']."</td></tr>";
	}							
	echo "</table></div>";
	historia ($nitavu,"Vio la lista de asistencia");
}


}
else
{
	mensaje ("No tiene acceso",'');
}


?>

<br><br>


<?php
include ("./lib/body_footer.php");
?>