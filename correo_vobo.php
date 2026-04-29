<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap59"; //ap06=Permisos de Aplicacion
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	xd_update($id_aplicacion,$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion, para ver el estado de los correos");

	buscar('correo_vobo.php', 'correo electronico o nombre','');



	if (isset($_GET['busqueda'])){
		$sql = "SELECT * FROM empleados where estado='' and correoelectronico<>'' and nombre like '%".$_GET['busqueda']."%' or correoelectronico like '%".$_GET['busqueda']."'";
		echo "<table class=tabla>";
		echo "<th>Nombre</th><th>correo</th><th></th><th></th>";
		$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
		{
			echo "<tr>";
			echo "<td>".$f['nombre']."</td>";
			echo "<td>".$f['correoelectronico']."</td>";
			if ($f['correo_vobo']=='0'){
				echo "<td>Sin verificar</td><td></td>";	
				
			} else {echo "<td><img src='icon/ok.png' width=20px></td>";
		echo "<td><a href='correo_vobo.php?&quitar=".$f['nitavu']."'><img src='icon/cancel.png' width=20px></a></td>";}

			
			

			echo "</tr>";

		}
		echo "</table>";
	} else {


		echo "<p>Actualmente hay ".cuanto_empleados()." empleados registrados, de los cuales tienen correo ".cuanto_empleados_correo()." y lo han verificado ".cuanto_empleados_correo_ok()."</p>";

		echo "<p>";
		echo "El limite actual es: ".correo_limite()." de ".$correo_limite." autorizado.";
		echo "</p>";


		echo "<div style='width:40%; display:inline-block;'>";
		echo "<h1>Uso del dia de hoy por asunto:</h1>";
		$sql = "SELECT 
			DISTINCT(asunto) as Qasunto,
			(select count(*) from correos where asunto=Qasunto and fecha=curdate()) as n
			FROM
				correos
			where 
				correos.fecha=curdate()

			";
		$r2 = $conexion -> query($sql);
		echo "<table class=tabla width=100%>";
		while($f = $r2 -> fetch_array())
		{//Categorias de Aplicaciones
			echo "<tr><td>".$f['Qasunto']."</td>";
			echo "<td>".$f['n']."</td></tr>";
		}
		echo "</table>";

		echo "</div>";


		echo "<div style='width:40%; display:inline-block;'>";
		echo "<h1>Uso del dia de hoy por usuarios:</h1>";
		$sql = "SELECT 
			DISTINCT(nuc) as Qnuc,
			(select count(*) from correos where nuc=Qnuc and fecha=curdate()) as n
			FROM
				correos
			where 
				correos.fecha=curdate()



			";
		$r2 = $conexion -> query($sql);
		echo "<table class=tabla width=100%>";
		while($f = $r2 -> fetch_array())
		{//Categorias de Aplicaciones
			echo "<tr><td>".nitavu_nombre($f['Qnuc'])."</td>";
			echo "<td>".$f['n']."</td></tr>";
		}



		echo "</table>";

		echo "</div>";
	

	}
	
	if (isset($_GET['quitar'])){		
		$sql="UPDATE empleados SET correo_vobo='0' WHERE nitavu='".$_GET['quitar']."'";
		$resultado = $conexion -> query($sql);
		if ($conexion->query($sql) == TRUE){
			historia($nitavu, "se ha retirado la verificacion del correoelectronico de ".nitavu_nombre($_GET['quitar']));
			mensaje("Se ha retirado la verificacion del correo, debera activarse nuevamente",'correo_vobo.php'); }
		else {
			historia($nitavu, "ERROR al tratar de  retirar la verificacion del correoelectronico de ".nitavu_nombre($_GET['quitar']));
			mensaje("ERROR al retirar la verificacion ".$sql,'correo_vobo.php'); }
	}
		

	
	

}
else{mensaje("No tiene acceso a ".$id_aplicacion,'');}











?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>