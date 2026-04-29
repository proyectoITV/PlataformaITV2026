<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>

<?php
$id_aplicacion ="ap12"; $nivel =aplicacion_nivel($id_aplicacion, $nitavu);
//$nivel=2;
//mensaje_mantenimiento($nitavu, 'index.php');
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<h5>".app_detalle($id_aplicacion)."</h5>";echo "<div id='r' style='margin-top:-30px;'>";
		if ($nivel == 1) {// 1 = Administrador// PODRA APROBAR CUALQUIER PERMISO DE SALIDA
		historia ($nitavu,"Entro a autorizacion de pases en modo Super Administrador (Puede aprobar cualquier pase)");			
		echo "<div  class='pc'><table border=0 width=50% style='display:inline-block;'><tr><td><img src='icon/nivel_1.png' style='width:23px; height:20px;'></td><td><span class='tenue' style='font-size:8pt;'>Puedes aprobar cualquier solicitud de salida con fecha actual o superior.</span></td></tr></table></div>";
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."') order by fecha";		
		//echo $sql;
		$rc= $conexion -> query($sql);while($f = $rc -> fetch_array()) 
		{
			if ($f['fecha']==$fecha){
			echo "<div id='resultado_elemento' style='
				border: 1px solid pink;   
				'>"; echo "<table border='0'><tr>"; 
			}else
			{
			echo "<div id='resultado_elemento'>"; echo "<table border='0'><tr>"; 
			}
				echo "<span class='pc'>";echo "<td width='1px'>";echo ponerfoto("fotos/".$f['nitavu'].".jpg",'vigi_foto2');echo "</td>";echo "</span>";				
				echo "<td class='tipo_nombre pc' valing='top' align='left' width=200px>".nitavu_nombre($f['nitavu'])."<label style='font-size:8pt; margin: 0px;'>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</label></td>";
				echo "<td class='normal' style='font-size:10pt;'>Para el ".fecha_larga($f['solicito_fecha'])." a las ".hora12($f['solicito_hora']);
					echo "<br><span class='movil' style='color:gray;'>".$f['asunto']."</span>";
				echo "</td>";
				echo "<td rowspan='2' width='30px' align='right' class='tipo_menu'> ";
						echo "<button class='btn btn-default' onclick=location.href='auscencia_temporal_autoriza_ok.php?id=".$f['id']."'>";
								echo "<img src='icon/ok.png' class='mini_icono'>"; 							
						echo "</button><br><br>";
						echo "<button class='btn btn-cancel' onclick=location.href='auscencia_temporal_autoriza_x.php?id=".$f['id']."'>";
								echo "<img src='icon/cancel.png' class='mini_icono'>"; 							
						echo "</button>";
					echo "</td>";					
					echo "</tr><tr><td colspan='4'><span class='pc tchico '>(".$f['id']."). Asunto:<b class='normal'> ".$f['asunto']."</b>: ".$f['justificacion']."</span></td>";
			echo "</tr></table>";
			echo "</div>";

		}//while
			
	}//fin nivel 1


	//SI ES NIVEL 2, SOLO podra aprobar a los titulares de los dptos, que tenga a su cargo. Segun el organigrama de la plataforma
	if ($nivel == 2) {// 1 = Administrador// PODRA APROBAR CUALQUIER PERMISO DE SALIDA
	echo "<div  class='pc'><table border=0 width=50% style='display:inline-block;'><tr><td><img src='icon/nivel_2.png' style='width:23px; height:20px;'></td><td><span class='tenue' style='font-size:8pt;'>Puedes aprobar titulares que dependan de ti, con fecha actual o superior.</span></td></tr></table></div>";

	//PASO 1: Conocer el id de cat_gerarquia
	$sqlx = "SELECT * FROM cat_gerarquia WHERE dependencia='".soytitular($nitavu)."'";
	$r= $conexion -> query($sqlx);	while($f2 = $r -> fetch_array())
	{
		//echo nitavu_nombre($f2['titular'])." - ".$f2['nombre']."<br>";

		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' and  nitavu='".$f2['titular']."')";		
		//echo $sql;
		$rc= $conexion -> query($sql);while($f = $rc -> fetch_array()) 
		{
			if ($f['fecha']==$fecha){
			echo "<div id='resultado_elemento' style='
				border: 1px solid pink;   
				'>"; echo "<table border='0'><tr>"; 
			}else
			{
			echo "<div id='resultado_elemento'>"; echo "<table border='0'><tr>"; 
			}
			
				echo "<span class='pc'>";echo "<td width='1px'>";echo ponerfoto("fotos/".$f['nitavu'].".jpg",'vigi_foto2');echo "</td>";echo "</span>";				
				echo "<td class='tipo_nombre pc' valing='top' align='left' width=200px>".nitavu_nombre($f['nitavu'])."<label style='font-size:8pt; margin: 0px;'>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</label></td>";
				echo "<td class='normal' style='font-size:10pt;'>Para el ".fecha_larga($f['fecha'])." a las ".hora12($f['solicito_hora']);
					echo "<br><span class='movil' style='color:gray;'>".$f['asunto']."</span>";
				echo "</td>";
				echo "<td rowspan='2' width='30px' align='right' class='tipo_menu'> ";
						echo "<button class='btn btn-default' onclick=location.href='auscencia_temporal_autoriza_ok.php?id=".$f['id']."'>";
								echo "<img src='icon/ok.png' class='mini_icono'>"; 							
						echo "</button><br><br>";
						echo "<button class='btn btn-cancel' onclick=location.href='auscencia_temporal_autoriza_x.php?id=".$f['id']."'>";
								echo "<img src='icon/cancel.png' class='mini_icono'>"; 							
						echo "</button>";
					echo "</td>";					
					echo "</tr><tr><td colspan='4'><span class='pc tchico '>(".$f['id']."). Asunto:<b class='normal'> ".$f['asunto']."</b>: ".$f['justificacion']."</span></td>";
			echo "</tr></table>";
			echo "</div>";

		}
	}
	//PASO 2: Consultar dependencia = id, de cat_gerarquia
		
	}
	//fin nivel 2




//SI ES NIVEL 4, Podra aprobar los Dptos que esten autorizados, en la tabla empleados_salidas_autoriza_excepcion
	if ($nivel == 4) {
	echo "<div  class='pc'><table border=0 width=50% style='display:inline-block;'><tr><td><img src='icon/nivel_3.png' style='width:23px; 	height:20px;'></td><td><span class='tenue' style='font-size:8pt;'>Puedes aprobar en los departamentos asignados: ";
	$r= $conexion -> query("SELECT * from empleados_salidas_autoriza_excepcion where nitavu='".$nitavu."'");	
	while($da = $r -> fetch_array())
		{ echo dpto_id($da['dpto']).", "; }

	echo " </span></td></tr></table></div>";

	//PASO 1: Conocer el id de cat_gerarquia
	$r= $conexion -> query("SELECT * from empleados_salidas_autoriza_excepcion where nitavu='".$nitavu."'");	
	while($da2 = $r -> fetch_array())
		{//TODOS LOS QUE DEPENDEN DE MI, EN EL DPTO
		//echo nitavu_nombre($f2['nitavu'])." - ".$f2['nombre']."<br>";
		echo "<br><h5>".dpto_id($da2['dpto'])."</h5>";			
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' and  dpto='".$da2['dpto']."')";
		//echo $sql;
		$rc= $conexion -> query($sql);while($f = $rc -> fetch_array()) 
		{
		
			if ($f['fecha']==$fecha){
			echo "<div id='resultado_elemento' style='
				border: 1px solid pink;   
				'>"; echo "<table border='0'><tr>"; 
			}else
			{
			echo "<div id='resultado_elemento'>"; echo "<table border='0'><tr>"; 
			}
			
				echo "<span class='pc'>";echo "<td width='1px'>";echo ponerfoto("fotos/".$f['nitavu'].".jpg",'vigi_foto2');echo "</td>";echo "</span>";				
				echo "<td class='tipo_nombre pc' valing='top' align='left' width=200px>".nitavu_nombre($f['nitavu'])."<label style='font-size:8pt; margin: 0px;'>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</label></td>";
				echo "<td class='normal' style='font-size:10pt;'>Para el ".fecha_larga($f['fecha'])." a las ".hora12($f['solicito_hora']);
					echo "<br><span class='movil' style='color:gray;'>".$f['asunto']."</span>";
				echo "</td>";
				echo "<td rowspan='2' width='30px' align='right' class='tipo_menu'> ";
						echo "<button class='btn btn-default' onclick=location.href='auscencia_temporal_autoriza_ok.php?id=".$f['id']."'>";
								echo "<img src='icon/ok.png' class='mini_icono'>"; 							
						echo "</button><br><br>";
						echo "<button class='btn btn-cancel' onclick=location.href='auscencia_temporal_autoriza_x.php?id=".$f['id']."'>";
								echo "<img src='icon/cancel.png' class='mini_icono'>"; 							
						echo "</button>";
					echo "</td>";					
					echo "</tr><tr><td colspan='4'><span class='pc tchico '>(".$f['id']."). Asunto:<b class='normal'> ".$f['asunto']."</b>: ".$f['justificacion']."</span></td>";
			echo "</tr></table>";
			echo "</div>";

		}
	}
	//PASO 2: Consultar dependencia = id, de cat_gerarquia


	}






	//SOLO TITULARES
	if ($nivel == 3) {
	echo "<div  class='pc'><table border=0 width=50% style='display:inline-block;'><tr><td><img src='icon/nivel_3.png' style='width:23px; 	height:20px;'></td><td><span class='tenue' style='font-size:8pt;'>Puedes aprobar en tu departamento </span></td></tr></table></div>";

	//PASO 1: Conocer el id de cat_gerarquia
	$sqlx = "SELECT * from empleados where dpto='".soytitular($nitavu)."' and nitavu<>'".$nitavu."'";
	$r= $conexion -> query($sqlx);	while($f2 = $r -> fetch_array())
	{//TODOS LOS QUE DEPENDEN DE MI, EN EL DPTO
		//echo nitavu_nombre($f2['nitavu'])." - ".$f2['nombre']."<br>";

		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' and  nitavu='".$f2['nitavu']."')";
		//echo $sql;
		$rc= $conexion -> query($sql);while($f = $rc -> fetch_array()) 
		{
			if ($f['fecha']==$fecha){
			echo "<div id='resultado_elemento' style='
				border: 1px solid pink;   
				'>"; echo "<table border='0'><tr>"; 
			}else
			{
			echo "<div id='resultado_elemento'>"; echo "<table border='0'><tr>"; 
			}
			
				echo "<span class='pc'>";echo "<td width='1px'>";echo ponerfoto("fotos/".$f['nitavu'].".jpg",'vigi_foto2');echo "</td>";echo "</span>";				
				echo "<td class='tipo_nombre pc' valing='top' align='left' width=200px>".nitavu_nombre($f['nitavu'])."<label style='font-size:8pt; margin: 0px;'>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</label></td>";
				echo "<td class='normal' style='font-size:10pt;'>Para el ".fecha_larga($f['fecha'])." a las ".hora12($f['solicito_hora']);
					echo "<br><span class='movil' style='color:gray;'>".$f['asunto']."</span>";
				echo "</td>";
				echo "<td rowspan='2' width='30px' align='right' class='tipo_menu'> ";
						echo "<button class='btn btn-default' onclick=location.href='auscencia_temporal_autoriza_ok.php?id=".$f['id']."'>";
								echo "<img src='icon/ok.png' class='mini_icono'>"; 							
						echo "</button><br><br>";
						echo "<button class='btn btn-cancel' onclick=location.href='auscencia_temporal_autoriza_x.php?id=".$f['id']."'>";
								echo "<img src='icon/cancel.png' class='mini_icono'>"; 							
						echo "</button>";
					echo "</td>";					
					echo "</tr><tr><td colspan='4'><span class='pc tchico '>(".$f['id']."). Asunto:<b class='normal'> ".$f['asunto']."</b>: ".$f['justificacion']."</span></td>";
			echo "</tr></table>";
			echo "</div>";

		}
	}
	//PASO 2: Consultar dependencia = id, de cat_gerarquia


	}








echo "</div>";//div r2 
}
else{
//SINO TIENE ACCESO, SOLO PODRA APROBAR LOS QUE DEPENDAN DE EL, SEGUN LA GERARQUIA
//* Tiene que ser titular de un dpto o dir.
//* si es una direccion, 	

mensaje("No tiene acceso a ".$id_aplicacion,'');

}











?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./unica/body_footer.php");
?>