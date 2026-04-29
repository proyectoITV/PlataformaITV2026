<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>


<?php 

$id_aplicacion = 'ap05';
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);	

echo mensaje_mantenimiento($nitavu,'');
if (isset($_GET['id'])){//el usuario selecciono un empleado
	echo "<form action='documentar_enviar.php' method='POST'>";
	echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";
	echo "<div>";
	echo "<label>Destinatario:</label>";			
		echo "<input type='text' name='destinatario' readonly='readonly' value='".nitavu_nombre($_GET['id'])."'>";		
	echo "</div>";
	echo "<div>";
	echo "<label>Asunto:</label>";	
			if (isset($_GET['a'])){
				echo "<input type='text' name='asunto' required='required' value='".$_GET['a']."'>";	
			}else{			
				echo "<input type='text' name='asunto' required='required'>";
			}	
	echo "</div>";

	echo "<span>";
	echo "<table width=100% style='background-color:#DDDDDD; padding: 5px; '><tr><td>";
	//echo "<label>Contenido del Documento: (Debe escribir un contenido para que pueda enviarse)</label>";
	echo "<textarea name='contenido' ></textarea>";
	echo "</td></tr></table>";
	echo "</span>";

	echo "<div>";
		echo "<input type='submit' value='ENVIAR' class='Mbtn btn-default'>";
	echo "</div>";

	echo "<div>";
		echo "<a href='documentar.php' class='Mbtn btn-secundario'><img src='icon/home.png' style='width:21px; height:21px;'></a>";
	echo "</div>";

}
else {
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
	//echo "<hr>";
	if (isset($_GET['busqueda'])){
		echo "<label>Resultados de <b class='normal'>".$_GET['busqueda']."</b></label>";
		echo "<table class='tabla'>";
		$sql = "select * from empleados where nitavu='".$_GET['busqueda']."' or nombre like '%".$_GET['busqueda']."%' and estado=''";
		//echo $sql;

		$rc= $conexion -> query($sql);while($f = $rc -> fetch_array()) 
		{	echo "<tr>";
			echo "<td class=pc>".$f['nitavu']."</td>"; echo "<td>";
			echo "<a style='display:block; color:black; ' href='documentar.php?id=".$f['nitavu']."'>";
			echo $f['nombre']."<span class='tenue pc'> ".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</span>";
			echo "</a></td>";
			echo "<td width=50px class=pc>";
			//accione
			echo "<a class='btn ' href='documentar.php?id=".$f['nitavu']."'><img src='icon/entrar.png'></a>";
			echo "</td>";
			echo "</tr>";

		}
		echo "</table><br>";
		buscar('documentar.php', 'Busca nuevamente, por nombre o parte del mismo', '');
	
	}
	else {
		buscar('documentar.php', 'Nombre, o numero de empleado. (Puede utilizar parte del mismo)', '');
	
		
	}
	
}



	



?>


<?php


//GUARDAR----

if (isset($_POST['submit'])){
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
include ("./lib/body_footer.php");
?>