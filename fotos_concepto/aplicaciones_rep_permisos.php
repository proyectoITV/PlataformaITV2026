<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>


<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap11"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){

	xd_update('ap11',$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion, ver reporte de permisos de aplicacion [ap11]");

	echo "<h5>".app_detalle($id_aplicacion)."</h5>";

	
	//$n=$_GET['n'];//var con la que nos manda la busqueda y nos indica que numero de itavu tiene
	$sql = "SELECT * FROM aplicaciones ORDER by idapp ASC";
	$r_count = $r -> num_rows;
	

	$r = $conexion -> query($sql);
	while($f = $r -> fetch_array())
	{ // resultado de la busqueda.................
	echo "<div id='aplicaciones'>";		
		echo "<h5>".$f['idapp']." - ".$f['nombre']."</h5><br>";

			
			$sql2 = "SELECT * FROM aplicaciones_permisos WHERE ( idapp='".$f['idapp']."') ORDER by idapp ASC";
			//echo $sql2;
			$r2 = $conexion -> query($sql2);
			$r_count2 = $r2 -> num_rows;

			echo "<cite> ".$r_count2." personas tienen acceso:</cite>";
			echo "<lu>";
			while($f2 = $r2 -> fetch_array()) {
					if ($f2['nitavu']<>'admin')
					{
					echo "<li><b>".nitavu_nombre($f2['nitavu'])."</b> <br> ".nitavu_puesto($f2['nitavu'])."  de ".nitavu_dpto($f2['nitavu'])." con nivel [".nivel_que($f2['nivel'])."]</li>";
					}
			}
			echo "</lu>";
			echo "<br><br>";
	


	echo "</div>";
	}


}
else{
	mensaje("No tiene acceso a esta aplicacion","");
}











?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./unica/body_footer.php");
?>