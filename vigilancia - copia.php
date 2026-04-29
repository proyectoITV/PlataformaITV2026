<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap13"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	echo "<b><br><center>PERMISOS AUTORIZADOS PARA ".$fecha.":</center></b>";
	echo "<section id='vigilancia'>";
	
	$sql = "SELECT * FROM empleados_salidas_temporal WHERE 
	(autorizo_nitavu<>'' AND fecha='".$fecha."' AND registro_entrada='00:00:00' AND rechazada='') ORDER by registro_salida DESC";
	//echo $sql;
	$rc= $conexion -> query($sql);
	while($f = $rc -> fetch_array()) {


	echo "<article>";
	echo "<table border='0'><tr>";
	echo "<td >";
		echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono pc');
	echo "</td>";	

	echo "<td class='tipo_nombre' valing='top' align='left'>".nitavu_nombre($f['nitavu']);
	echo "<br><strong class='normal grande'>".$f['nitavu']."</strong></td>";
	

	echo "<td>";
	$permiso = tiempo_restar_hr($f['hora_desde'], $f['hora_hasta']);


	if ($f['registro_salida']=='00:00:00') // sino ha sa
		{
		 echo "<strong class='normal grande'>".$permiso."min</strong>";
		}
	else
		 {
// necesitoo sumarle a la hora actual + permiso, y despues ir restandole la hora actual.
		$hora_depermiso = tiempo_sumar_hr($permiso, $f['registro_salida']);
		$tiempo_restante = tiempo_restar_hr($hora,$hora_depermiso);

		echo "(".$permiso.") desde ".$f['registro_salida']. " hasta las ".$hora_depermiso."<br>";
	
		if ($tiempo_restante>$permiso)
			{
				$sepaso= tiempo_restar_hr($tiempo_restante,$permiso);
				$sepaso =tiempo_restar_hr($permiso, $sepaso);
				echo "<strong class='alerta'>Retraso: ".$sepaso."min</strong>";
			}
		else
			{echo "<strong class='ejecutandose'>".$tiempo_restante."min</strong>";}

	 }

	$tmp ="<label>Autorizado de ".$f['hora_desde']." a ".$f['hora_hasta']." <label></td>";
	echo $tmp;

	echo "</td>";

	echo "<td width='10px' align='right' class='tipo_menu'> ";
				

					if ($f['registro_salida']=='00:00:00'){
					echo "<button class='Mbtn btn-default' onclick=location.href='vigilancia_salio.php?id=".$f['id']."'>";
							echo "Salio"; 							
					echo "</button>";
					}
					else
					{
						echo "<button class='Mbtn btn-cancel' onclick=location.href='vigilancia_entro.php?id=".$f['id']."'>";
							echo "Entro"; 							
						echo "</button>";
					
					}


				
				
					

					echo "</td>";

	echo "</tr></table>";
	echo "</article>";

	}









	// VISITAS::::::::::::::::::
	$sql = "SELECT * FROM visitas WHERE 
	(autorizo_nitavu<>'' AND fecha='".$fecha."' AND rechazado='' AND registro_hr_salida='00:00:00' )";
	//echo $sql;
	$rc= $conexion -> query($sql);
	
	while($f = $rc -> fetch_array()) {

			echo "<article>";
	echo "<table border='0'><tr>";
	

	echo "<td valing='top' align='left'><strong>".$f['nombre']."</strong><br>";


	

	
	
	echo "<cite>".$f['asunto']."</cite><br>";
	echo "Nos visita hoy a las ".$f['hora']."</td>";
	
	
	echo "<td> ";
	$tiempo_visita=0;
	if ($f['registro_hr_entrada']=='00:00:00') // sino ha sa
		{ // ESTA DENTRO

		}
	else
		{// AUN NO ENTRA
			$tiempo_visita = tiempo_restar_hr($f['registro_hr_entrada'], $hora);		
			echo "<label>Tiempo de la visita:</label>";
			echo "<strong class='normal grande'>".$tiempo_visita."</strong><br>";
		}
	echo "Visita a ".user_legend($f['nitavu_quienvisita'])."";
			
	echo "</td>";




	echo "<td width='10px' align='right' class='tipo_menu'> ";
				

					if ($f['registro_hr_entrada']=='00:00:00'){
					echo "<button class='Mbtn btn-default' onclick=location.href='visita_entro.php?id=".$f['id']."'>";
							echo "Entro";					
					echo "</button>";
					}
					else
					{
						echo "<button class='Mbtn btn-cancel' onclick=location.href='visita_salio.php?id=".$f['id']."'>";
							echo "Salio"; 							
						echo "</button>";
					
					}


				
				
					

					echo "</td>";

	echo "</tr></table>";
	echo "</article>";
	}
	
	














	$sql = "SELECT * FROM empleados_salidas_temporal WHERE 
	(autorizo_nitavu<>'' AND fecha='".$fecha."' AND registro_entrada='00:00:00' AND rechazada='TRUE')";
	//echo $sql;
	$rc= $conexion -> query($sql);
	$tmp="";
	while($f = $rc -> fetch_array()) {
		$nombre = nitavu_nombre($f['nitavu']);
		$tmp = $tmp = "<li>".$nombre." (".$f['hora_desde'].") rechazado por ".nitavu_nombre($f['autorizo_nitavu'])." a las ".$f['autorizo_hora']."</li>";
		
	}
	
	if ($tmp <>'') {
		echo "<article><P>";
		echo "PERMISOS RECHAZADOS PARA HOY: <BR><LU>";
		echo $tmp."</LU>";
		echo "</P>";
		echo "<cite>Para mayor informacion que acuda al dpto de recursos humanos</cite>";
		echo "</article>";
	}
	echo "</section>";


}
else{echo "No tiene acceso a ".$id_aplicacion;}











?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>