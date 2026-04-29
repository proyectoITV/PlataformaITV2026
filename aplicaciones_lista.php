<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>


<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap10"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";


	//$n=$_GET['n'];//var con la que nos manda la busqueda y nos indica que numero de itavu tiene
	$sql = "SELECT * FROM aplicaciones ORDER by idapp ASC";
	$r_count = $r -> num_rows;
	

	$r = $conexion -> query($sql);
	echo "<table border='0'>";
	echo "<tr><td> ID </td>";
	echo "<td> NOMBRE </td>";
	echo "<td> DESCRIPCION </td>";
	echo "<td> VERSION </td>";
	echo "</tr>";

	while($f = $r -> fetch_array())
		{ // resultado de la busqueda.................

			echo "<tr><td>".$f['idapp']."</td>";
			echo "<td> ".$f['nombre']." </td>";
			echo "<td> ".$f['descripcion']."</td>";
			echo "<td> ".$f['version']."</td>";
			echo "</tr>";
			
		}
	echo"</table>";
	historia ($nitavu,"Vio la Lista de Aplicaciones disponibles");

}
else{
	mensaje("No tiene acceso a esta aplicacion","");
}











?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>