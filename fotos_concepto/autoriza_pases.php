<?php
//include ("./unica/seguridad.php");
include ("./unica/body_head.php");
include ("./unica/body_menu.php");
// contenido:
?>


<?php 

$id_aplicacion = 'ap57';
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);	
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<h5>".app_detalle($id_aplicacion)."</h5>";	
	buscar('autoriza_pases.php', 'Nombre, o numero de empleado. (Puede utilizar parte del mismo)', '');
	echo "<hr>";

	if (isset($_GET['busqueda'])){
	echo "<label>Seleccione dando un clic sobre el empleado</label>";
	echo "<table class='tabla'>";
	$sql = "select * from empleados where nitavu='".$_GET['busqueda']."' or nombre like '%".$_GET['busqueda']."%' and estado=''";
	//echo $sql;

	$rc= $conexion -> query($sql);while($f = $rc -> fetch_array()) 
	{	echo "<tr>";
		echo "<td class=pc>".$f['nitavu']."</td>"; echo "<td>";
		echo "<a style='display:block; color:black; ' href='autoriza_pases.php?id=".$f['nitavu']."'>";
		echo $f['nombre'];
		echo "</a></td>";
		echo "<td width=50px class=pc>";
		//accione
		echo "<a class='btn ' href='autoriza_pases.php?id=".$f['nitavu']."'><img src='icon/entrar.png'></a>";
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
	}

	if (isset($_GET['id'])){//el usuario selecciono un empleado
		echo "<form action='autoriza_pases.php' method='post'>";
		echo "<input type='hidden' name='empleado' value='".$_GET['id']."'>";


		echo "<div><table class='tabla3'><tr><td><label>¿Que dpto le asignara a ".nitavu_nombre($_GET['id'])."?:</label>";
		echo "<select name='dpto'>";
		$rc= $conexion -> query("select * from cat_gerarquia order by nombre");while($dptos = $rc -> fetch_array()) 
		{
			echo "<option value='".$dptos['id']."'>".$dptos['nombre']."</option>";
		}
			echo "<option value='' selected>Seleccione un departamento</option>";

		echo "</select></td><td width= 30%; valing=bottom align=center>";
		echo "<br><input type='submit' class='btn btn-default' name='submit_asignar' value='Asignar'></td><tr></table>";
		echo "</div>";

		echo "<div>
		<b>Puede autorizar pases de salida en los dptos: </b><br>";
		if (isset($_GET['id'])){
			$rc= $conexion -> query("select * from empleados_salidas_autoriza_excepcion where nitavu='".$_GET['id']."'");
			echo "<table class='tbl_dir'>";
			while($dp = $rc -> fetch_array()) 
			{
				echo "<tr>";
				echo "<td>".dpto_id($dp['dpto'])."</td>";
				echo "<td class='tchico'>"."Autoizado el ".$dp['fecha']." a las ".$dp['hora']."</td>";
				echo "<td><a href='autoriza_pases.php?id=".$_GET['id']."&x=".$dp['dpto']."' class='btn btn-cancel'>X</a>";
				echo "</tr>";
			}	
			echo "</table>";
		}
		else {
			echo "<label>Seleccione un empleado para ver los departamentos asignador para aprobar los pases";
		}

		

		echo "</div>";
		
		echo "</form>";

	}
	



}
else {
	mensaje("No autorizado",'');
}

	



?>


<?php


//GUARDAR----

if (isset($_POST['submit_asignar'])){
//GUARDAR solicitud de salida oficial

$empleado = $_POST['empleado']; $dpto = $_POST['dpto'];
$sql = "INSERT INTO empleados_salidas_autoriza_excepcion
		(nitavu, dpto, autorizo, fecha, hora)
		VALUES
		('$empleado','$dpto', '$nitavu',  '$fecha', '$hora');";

if ($conexion->query($sql) == TRUE)
	{

		historia($nitavu, "Asigno a [".$empleado."] ".nitavu_nombre($empleado)." para aprobar pases de salida en el departamento [".$dpto."] ".dpto_id($dpto).".");
		mensaje("Departamento asignado correctamente",'autoriza_pases.php');

	}
else
	{
			
			historia("ERROR | (".$sql.") al intentar asignar empleado para autorizar pases");
			mensaje ("Error :".$sql,'');
	}



}/// fin de guardar oficial




if (isset($_GET['x'])){
//GUARDAR solicitud de salida oficial
//$empleado = $_POST['empleado']; $dpto = $_POST['dpto'];

$sql = "DELETE from empleados_salidas_autoriza_excepcion WHERe dpto='".$_GET['x']."' and nitavu='".$_GET['id']."'";
if ($conexion->query($sql) == TRUE)
	{

		historia($nitavu, "Retiro Asignacion  a [".$empleado."] ".nitavu_nombre($_GET['x'])." para aprobar pases de salida en el departamento [".$_GET['x']."] ".dpto_id($_GET['x']).".");
		mensaje("Asignacion retirada correctamente",'autoriza_pases.php');

	}
else
	{
			
			historia("ERROR | (".$sql.") al intentar asignar empleado para autorizar pases");
			mensaje ("Error :".$sql,'');
	}



}/// fin de guardar oficial




?>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./unica/body_footer.php");
?>