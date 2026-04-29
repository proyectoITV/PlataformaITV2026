<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap12"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	echo "<div id='r'>";

if (aplicacion_nivel($id_aplicacion,$nitavu) == 1) {// 1 = Administrador
	// PODRA APROBAR CUALQUIER PERMISO DE SALIDA
	echo "<p><b>Bienvenido Administrador: </b>Puedes aprobar cualquier solicitud de salida con fecha actual o superior</p>";
	//echo "<cite>En color celeste resaltan las que debe aprobar Rec. Humanos, en rojo las que se pasaron y no aprobaron (puede rechazarlas para que ya no aparezcan)</cite>";
	

	$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' )";
	
	echo $sql;
	$rc= $conexion -> query($sql);
	while($f = $rc -> fetch_array()) {
		if ($f['solicito_fecha']>$fecha){
			echo "<div id='resultado_alerta'>";
		}
		else{
			if ($f['asunto']=="personal"){
				echo "<div id='resultado_p'>";		
			}
			else {
				echo "<div id='resultado_elemento'>";	
			}
			
		}
			echo "<table border='0'><tr>";

					echo "<span class='pc'>";
						echo "<td width='1px'>";
						echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono pc');
					echo "</td>";	
					echo "</span>";

					echo "<td width='10px'>";
					//function archivo_pases($nitavu, $fecha_, $hr_salida){
						$archivo = archivo_pases($f['nitavu'],$f['fecha'],$f['hora_desde']);
						//echo $archivo;
						echo ponerfoto($archivo.".jpg",'icono pc');
					echo "</td>";	

					echo "<td class='tipo_nombre' valing='top' align='left'>".nitavu_nombre($f['nitavu'])."<label>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto($f['nitavu'])."</label></td>";		
					$tmp="";
					if ($f['solicito_fecha']==$fecha)//si la fecha no es la misma y ya sabes que esta en las no aprobadas osea que es menor que hoy
					{
						$tmp="hoy"; // entonces, calculamos hace cuanto tiempo
						$tiempo = tiempo_restar_hr($f['solicito_hora'], $hora);
						$tmp = $tmp." hace ".$tiempo."min ";

					} 
					else{
						$dias = tiempo_restar_fecha($fecha, $f['solicito_fecha']);
						$tmp = " hace ".$dias." dias";
					}

					$lapso = tiempo_restar_hr($f['hora_desde'], $f['hora_hasta']);



					echo "<td class='normal'><strong>".$lapso."min </strong> <br> de ".$f['hora_desde']." a ".$f['hora_hasta']." para el ".$f['fecha']."<br> solicitado ".$tmp."</td>";

					echo "<td rowspan='2' width='10px' align='right' class='tipo_menu'> ";
						
					echo "<button class='Mbtn btn-default' onclick=location.href='auscencia_temporal_autoriza_ok.php?id=".$f['id']."'>";
							echo "<img src='icon/ok.png' class='mini_icono'>"; 							
					echo "</button>";


					echo "<br><br>";

					echo "<button class='Mbtn btn-cancel' onclick=location.href='auscencia_temporal_autoriza_x.php?id=".$f['id']."'>";
							echo "<img src='icon/cancel.png' class='mini_icono'>"; 							
					echo "</button>";
				
					

					echo "</td>";
					
					echo "</tr><tr><td colspan='4'><span class='pc'>ID: ".$f['id'].", Asunto: ".$f['asunto'].": ".$f['justificacion']."</span></td>";

			
			echo "</tr></table>";
			echo "</div>";


	}
			


//
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

if (aplicacion_nivel($id_aplicacion,$nitavu) == 2) {// 2 = Administrador (titulares)
	// PODRA APROBAR CUALQUIER PERMISO DE SALIDA
	echo "<p><b>Bienvenido Administrador: </b>Puedes aprobar titulares que dependan de ti</p>";
	//echo "<cite>En color celeste resaltan las que debe aprobar Rec. Humanos, en rojo las que se pasaron y no aprobaron (puede rechazarlas para que ya no aparezcan)</cite>";
	



			


//

}



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

if (aplicacion_nivel($id_aplicacion,$nitavu) == 3) {// 2 = Los que dependan de 

	{ // sino es administrador, solamente podra aprobar los de su departamento
	echo "<p><b>Bienvenido: </b>Puedes aprobar las solicitudes de salida de tu departamento con fecha actual o superior</p>";





	$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND dpto='".nitavu_dpto($nitavu)."' AND fecha>='".$fecha."')";
	//echo $sql;
	$rc= $conexion -> query($sql);
	while($f = $rc -> fetch_array()) {
		echo "<div id='resultado_elemento'>";
			echo "<table border='0'><tr>";

					echo "<span class='pc'>";
						echo "<td width='1px'>";
						echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono pc');
					echo "</td>";	
					echo "</span>";

					echo "<td width='10px'>";
					//function archivo_pases($nitavu, $fecha_, $hr_salida){
						$archivo = archivo_pases($f['nitavu'],$f['fecha'],$f['hora_desde']);
						//echo $archivo;
						echo ponerfoto($archivo.".jpg",'icono pc');
					echo "</td>";	

					echo "<td class='tipo_nombre' valing='top' align='left'>".nitavu_nombre($f['nitavu'])."<label>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto($f['nitavu'])."</label></td>";		
					$tmp="";
					if ($f['solicito_fecha']==$fecha)//si la fecha no es la misma y ya sabes que esta en las no aprobadas osea que es menor que hoy
					{
						$tmp="hoy"; // entonces, calculamos hace cuanto tiempo
						$tiempo = tiempo_restar_hr($f['solicito_hora'], $hora);
						$tmp = $tmp." hace ".$tiempo."min ";

					} 
					else{
						$dias = tiempo_restar_fecha($fecha, $f['solicito_fecha']);
						$tmp = " hace ".$dias." dias";
					}

					$lapso = tiempo_restar_hr($f['hora_desde'], $f['hora_hasta']);



					echo "<td><strong>".$lapso."min </strong> <br> de ".$f['hora_desde']." a ".$f['hora_hasta']." para el ".$f['fecha']."<br> solicitado ".$tmp."</td>";

					echo "<td rowspan='2' width='10px' align='right' class='tipo_menu'> ";
						
					echo "<button class='Mbtn btn-default' onclick=location.href='auscencia_temporal_autoriza_ok.php?id=".$f['id']."'>";
							echo "<img src='icon/ok.png' class='mini_icono'>"; 							
					echo "</button>";


					echo "<br><br>";

					echo "<button class='Mbtn btn-cancel' onclick=location.href='auscencia_temporal_autoriza_x.php?id=".$f['id']."'>";
							echo "<img src='icon/cancel.png' class='mini_icono'>"; 							
					echo "</button>";
				
					

					echo "</td>";
					
					echo "</tr><tr><td colspan='4'><span class='pc normal'>ID: ".$f['id'].", Asunto: ".$f['asunto'].": ".$f['justificacion']."</span></td>";

			
			echo "</tr></table>";
			echo "</div>";

}


































	


	echo "</div>";
}
else{echo "No tiene acceso a ".$id_aplicacion;}











?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>