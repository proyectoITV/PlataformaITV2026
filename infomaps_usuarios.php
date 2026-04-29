<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>
<div id="documentar">

<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap05"; //Id de la aplicacion a cargar
//if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion)."</div>";
	// span ocupa 100% y Div 50%;

		$sql = "SELECT * FROM empleados_geo ORDER by nitavu ASC";
		$r = $conexion -> query($sql);
		$info="";
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				    //['Salamanca', 40.963, -5.669],
				$info = $info."['".$f['nitavu']."'],".$f['lat'].",".$f['lon'].",";
			}
		
		$info = substr($info, 0, -1);

		echo "<a href=test/mapa?info=".$info.">Ver </a>";
	

?>


</div>
<br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>