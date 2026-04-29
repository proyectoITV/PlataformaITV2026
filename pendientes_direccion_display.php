<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
//include ("./lib/body_menu.php");

// contenido:
?>
<script>
function tiempo(){

var fecha= new Date();
var horas= fecha.getHours();
var minutos = fecha.getMinutes();
var segundos = fecha.getSeconds();


if (horas>12){
dn="PM";
horas=horas-12;
} else {
	dn = "AM";
}
document.getElementById('vigi_hora').innerHTML=horas;
document.getElementById('vigi_min').innerHTML=minutos;
document.getElementById('vigi_seg').innerHTML=segundos;
document.getElementById('vigi_dn').innerHTML=dn;

setTimeout('tiempo()',1);
}
setTimeout('tiempo()',10);

</script>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap54"; //ap06=Permisos de Aplicacion
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
//$nivel = 2;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	historia($nitavu, "Vio los pendientes (direccion)");

	// ---- BARRA SUPERIOR PARA DISPLAY ------
	$delegacion =  midelegacion($nitavu);
	echo "<div id='vigi_top'>";
	echo "<table border='0' width='100%' >";
	echo "<tr>";
			echo "<td align='center' width='30%' style='color: white;'>";
			echo "<span class='pc tchico'>".$pyme_name."</span><b > <br> ".$delegacion."</b>";			
			echo "</td>";			
			echo "<td width='40%' style='color:white; font-size:12pt;' align='center' >";			
				echo "<span class='pc tmediano' style='color:#474749;'>".fecha_lite($fecha)."</span>";
			echo "</td>";
			echo "<td width='30%' align='right'>";
			echo '<div>';
			echo "<table border='0' id='vigi_horas'>";
			echo "<tr>";
    		echo "<td rowspan='2' width='50%'><div id='vigi_hora'></div></td>";
    		echo "<td valign='bottom' align='justify' width='50%'><div id='vigi_min'></div></td>";
  			echo "</tr>";
  			echo "<tr>";
    		echo "<td valign='top' ><div id='vigi_seg'></div><div id='vigi_dn'></div></td>";
  			echo "</tr>";
			echo "</table>";
			echo "</div>";
			echo "</td>";			
	echo "</tr>";
	echo "</table>";
	echo "</div>";
	//---------------------------------

	
	
echo "<div id='pendientes_display'>";
echo "<div style='width:100%; height:85px;'></div>";
$sql="SELECT * FROM pendientes_direccion WHERE pendiente_select=1"; //SI ESTA SELECCIONADO
$rc= $conexion -> query($sql); if($f2 = $rc -> fetch_array())
{	
//PANTALLA COMPLETA CON TEMA
echo "<div id='pendientes_elementos_select_display'>";
				echo '<table width="100%" border="0">';
				echo '<tr>';
				echo '<td colspan="4" align="center" width=92%>';
				echo '<span style="font-size:24pt; color:white;">'.$f2['pendiente_nombre'].'</span>';
			
				

				//calculo de dias
				$date1 = new DateTime($f2['pendiente_fechafin']);
				$date2 = new DateTime($fecha);
				$diff = $date1->diff($date2);				
				$dias_faltantes =  $diff->days;


				$date1 = new DateTime($f2['pendiente_fecha']);
				$date2 = new DateTime($f2['pendiente_fechafin']);
				$diff = $date1->diff($date2);				
				$dias_desdealta =  $diff->days;



				echo '<p align=left><b style="font-size:10pt;" class=" ejecutandose"><img src="icon/user_blanco.png" style="width:14px; height:14px; "> '.nitavu_nombre($f2['pendiente_autor']).'</b>';

				echo '<b style="color:cyan; font-size:12pt;">  | <img src="icon/calendario_blanco.png" style="width:14px; height:14px"> '.fecha_larga($f2['pendiente_fechafin']).'';
				//echo $dias_desdealta."";
				if ($dias_faltantes>$dias_desdealta){
					$dias_pasados = $dias_faltantes - $dias_desdealta;
					echo " | <img src='icon/alerta_blanco.png' style='width:14px; height:14px'><b class='alerta'> VENCIDO</b><b> ".$dias_pasados." dias.";
				}
				else
					{echo " | <img src='icon/alerta2_blanco.png' style='width:14px; height:14px'> Faltan ".$dias_faltantes." dias";}

				echo '</b></p>';

//echo foto
				$archivo = "pendientes/". str_replace(' ', '', $f2['pendiente_nombre']).".jpg";	
				if (file_exists($archivo)){
					echo "<img src='".$archivo."' style='width:100%; height:400px; border-radius:5px;'>";
				}

				
				echo '<div id="comentarios_display" style="height:100%;" >';
				echo '<h2 style="font-size:10pt; color:pink;">COMENTARIOS</h2> '.$f2['pendiente_comentario']."</div>";
				echo '</td>';

				echo '<td colspan="2" width="30%" align=right valign=top>';

				 $sql="select * from aplicaciones_permisos where idapp='ap54' 			
			";
			
			
			$r2 = $conexion -> query($sql); while($lista = $r2 -> fetch_array())
			{
				//echo "<tr>";
				//echo "<td width='10%' class='pc'>";
					$archivo = "fotos/".$lista['nitavu'].".jpg";	
					if (file_exists($archivo)){

						if (pendiente_direccion_voto($f2['pendiente_nombre'], $lista['nitavu'])=='OK'){
							echo "<div style='background-color: green; width:70px; height:70px; border-radius:50%;vertical-align:center;
							margin-bottom:10px; padding: 5px; margin-right:20px;
							'>";
						}
						else {
							if (pendiente_direccion_voto($f2['pendiente_nombre'], $lista['nitavu'])=='X'){
								echo "<div style='background-color: red; width:70px; height:70px; border-radius:50%;vertical-align:center;
								margin-bottom:10px; padding: 5px; margin-right:20px;
								'>";

							}
							else {
								echo "<div style='background-color: white; width:70px; height:70px; border-radius:50%;vertical-align:center;
								margin-bottom:10px; padding: 5px; margin-right:20px;
								'>";		
							}
						}


						
						echo "<img src='".$archivo."' style='
						width:70px; height:70px; border-radius:50%; '>";

						echo "</div>";
					}
				// echo "</td>";
				// echo "<td>".nitavu_nombre($lista['nitavu'])."<label class='pc'>".nitavu_puesto($lista['nitavu'])." de ".nitavu_dpto_nombre($lista['nitavu'])."</label></td>";
				// // echo "<td>";
				// // echo nivel_que($lista['nivel']);
				// // echo "</td>";

				// echo "</tr>";
			}

				

				echo '</td>';
		  		echo '</tr>';
		  		echo ' <tr>';
		    	echo '<td colspan="4">';
		    	//echo "<hr>";

		    	//botones
		    	




echo "</div>";















}
else
{
	//LISTAR PENDIENTES
	
	echo "<div id='pendientes' style='text-align:center;' >";	

	$sqlx = "SELECT * FROM pendientes_direccion WHERE pendiente_estado=0 order by pendiente_fechafin ASC ";
	if (isset($_GET['q'])){
		if ($_GET['q']=='ok'){$sqlx = "SELECT * FROM pendientes_direccion WHERE pendiente_estado=1 order by pendiente_fechafin ASC ";}
		
		if ($_GET['q']=='x'){$sqlx = "SELECT * FROM pendientes_direccion WHERE pendiente_estado=2 order by pendiente_fechafin ASC ";}
		
	}

	if (isset($_GET['busqueda'])){
		$sqlx = "SELECT * FROM pendientes_direccion WHERE pendiente_nombre like'%".$_GET['busqueda']."%' order by pendiente_fechafin ASC ";
	}
	

	$contador=0;
	$r= $conexion -> query($sqlx);while($f2 = $r -> fetch_array())
	
	{



		
		if (isset($_GET['select'])){
			if ($f2['pendiente_nombre']==$_GET['select']){
				echo "<div id='pendientes_elementos_select'>";
				echo '<table width="100%" border="0">';
				echo '<tr>';
				echo '<td colspan="4" align="center">';
				echo '<span style="font-size:14pt; color:black;">'.$f2['pendiente_nombre'].'</span>';
				echo '</td>';
				echo '</tr>';
				echo '<tr>';


				//calculo de dias
				$date1 = new DateTime($f2['pendiente_fechafin']);
				$date2 = new DateTime($fecha);
				$diff = $date1->diff($date2);				
				$dias_faltantes =  $diff->days;


				$date1 = new DateTime($f2['pendiente_fecha']);
				$date2 = new DateTime($f2['pendiente_fechafin']);
				$diff = $date1->diff($date2);				
				$dias_desdealta =  $diff->days;



				echo '<td><label><img src="icon/user.png" style="width:14px; height:14px"> '.nitavu_nombre($f2['pendiente_autor']).'</label>';
				echo '<label><img src="icon/calendario.png" style="width:14px; height:14px"> '.fecha_larga($f2['pendiente_fechafin']).'';
				echo $dias_desdealta."|".$dias_faltantes;
				if ($dias_faltantes>$dias_desdealta){
					$dias_pasados = $dias_faltantes - $dias_desdealta;
					echo "<br><img src='icon/alerta.png' style='width:14px; height:14px'><b class='alerta'> VENCIDO</b><b> ".$dias_pasados." dias.";
				}
				else
					{echo "<br> <img src='icon/alerta2.png' style='width:14px; height:14px'> Faltan ".$dias_faltantes." dias";}

				echo '</label>';

				echo '<div id="comentarios"><h2>COMENTARIOS</h2> '.$f2['pendiente_comentario']."</div>";

				echo '</td>';

				echo '<td colspan="2" width="30%" align=center>';

				
				//echo foto
				$archivo = "pendientes/". str_replace(' ', '', $f2['pendiente_nombre']).".jpg";	
				if (file_exists($archivo)){
					echo "<a href='".$archivo."' title='Haga clic aqui para ver en grande' target=_blank><img src='".$archivo."' style='width:45px; height:45px; border-radius:5px;'></a>";
				}

				echo '</td>';
		  		echo '</tr>';
		  		echo ' <tr>';
		    	echo '<td colspan="4">';
		    	echo "<hr>";

		    	//botones
		    	echo "<table border='0' width='100%'>";
		    	echo "<tr>";
				echo "<td colspan='4'>";  
		    	echo "<form action='pendientes_direccion.php' method='POST' enctype='multipart/form-data'>";
		    	echo "<input type='hidden' name='pendiente_nombre' value='".$f2['pendiente_nombre']."'>";
		    	echo "<input type='hidden' name='select' value='".$_GET['select']."'>";

		    	//echo "<div style='width: 100%; height:500px; background-color:transparent; padding: 5px;'>";
		    	echo "<textarea name='comentario'  ></textarea>";
		    	//echo "</div>";

		    	echo "<input style='margin-top:10px; margin-bottom:10px;' type='submit'  name='pendiente_comentario_guardar' class='Mbtn btn-default' value='Agregar Comentario'>";

		    	if ($nivel==1 OR $nivel==2){
		    		echo "<label style='font-size: 8pt;'>* Eres Administrador; tu voto es decisivo. ";
		    		$fal = pendiente_direccion_participantes_faltan($_GET['select']);
		    		if ($fal>0){echo "<b class='alerta'>Faltan ".$fal." participantes por votar</b>";}
		    		echo "</label>";
		    	}
		    	echo "</form>";
		    	
		    	echo "</td></tr>";

		    	echo "<tr><td>";
		    	echo "</td>";





 	

	if (pendiente_direccion_voto($_GET['select'],$nitavu)=='FALSE' ){//Si no ha votado

	if ($nivel==1 or $nivel==2){
		echo "<td align='center' >"; //boton ok
    		echo "<a href='pendientes_direccion.php?select=".$_GET['select']."&voto=ok' class='Mbtn btn-default' >";
    		echo "<table  border=0><tr>";    			
    			echo "<td><img src='icon/ok.png' style='width:18px;'></td>";
    			$votos = pendiente_direccion_votos($_GET['select'],'OK');
    			if ($votos>0){echo "<td class='comentarios_votos'> ".$votos." </td>";}
    			//echo "<td class='comentarios_votos'> ".$votos." </td>";
    		echo "</tr></table>";
		echo "</a>";


		echo "<td align='center' >"; //boton x
    		echo "<a href='pendientes_direccion.php?select=".$_GET['select']."&voto=x' class='Mbtn btn-cancel'>";
    		echo "<table  border=0><tr>";    			
    			echo "<td><img src='icon/cancel.png' style='width:18px;'></td>";
    			$votosx = pendiente_direccion_votos($_GET['select'],'X');
    			if ($votosx>0){echo "<td class='comentarios_votos'> ".$votosx." </td>";}
    			//echo "<td class='comentarios_votos'> ".$votos." </td>";
    		echo "</tr></table>";
		echo "</a>";


	}
	else
	{
    	echo "<td align='center' >"; //boton ok
    		//echo "<a href='pendientes_direccion.php?select=".$_GET['select']."&voto=ok' class='Mbtn btn-default' >";
    		echo "<table  border=0><tr>";    			
    			echo "<td><img src='icon/megusta_blanco.png' style='width:18px;'></td>";
    			$votos = pendiente_direccion_votos($_GET['select'],'OK');
    			if ($votos>0){echo "<td class='comentarios_votos'> ".$votos." </td>";}
    			//echo "<td class='comentarios_votos'> ".$votos." </td>";
    		echo "</tr></table>";
		echo "</a>";


		echo "<td align='center' >"; //boton x
    		echo "<a href='pendientes_direccion.php?select=".$_GET['select']."&voto=x' class='Mbtn btn-cancel'>";
    		echo "<table  border=0><tr>";    			
    			echo "<td><img src='icon/nomegusta_blanco.png' style='width:18px;'></td>";
    			$votosx = pendiente_direccion_votos($_GET['select'],'X');
    			if ($votosx>0){echo "<td class='comentarios_votos'> ".$votosx." </td>";}
    			//echo "<td class='comentarios_votos'> ".$votos." </td>";
    		echo "</tr></table>";
		//echo "</a>";

	}
		if (isset($_GET['voto'])){//GUARDAR VOTO
			if ($_GET['voto']=='ok'){
				$sql = "
				INSERT INTO pendientes_direccion_votos
				(pendiente_nombre, voto, votador, fecha)
				VALUES
				('".$_GET['select']."', 'OK', '".$nitavu."', '".$fecha."')";

				if ($conexion->query($sql) == TRUE)
					{ 
					if ($nivel==1 or $nivel==2){}else{mensaje("Voto guardado con exito (OK)", 'pendientes_direccion.php');}			
					historia($nitavu, "Voto favorablemente por el tema ".$_GET['select']);
					}
				else
					{historia($nitavu, "ERROR: al guardar voto (".$sql.")");
				 	mensaje ("Ha habido un error al guardar ".$sql, 'pendientes_direccion.php');
					}
			} 


			if ($_GET['voto']=='x'){
				$sql = "
				INSERT INTO pendientes_direccion_votos
				(pendiente_nombre, voto, votador, fecha)
				VALUES
				('".$_GET['select']."', 'X', '".$nitavu."', '".$fecha."')";

				if ($conexion->query($sql) == TRUE)
					{ 
					if ($nivel==1 or $nivel==2){}else{mensaje("Voto guardado con exito (X)", 'pendientes_direccion.php');}			
					historia($nitavu, "Voto desfavorablemente por el tema ".$_GET['select']);
					}
				else
					{historia($nitavu, "ERROR: al guardar voto (".$sql.")");
				 	mensaje ("Ha habido un error al guardar ".$sql, 'pendientes_direccion.php');
					}
			} 

			//DECIDIR SOBRE EL TEMA, CAMBIAR EL ESTADO
			if ($nivel==1 or $nivel==2){
				//1 = OK, X = 2

				if ($_GET['voto']=='x'){$sql="UPDATE pendientes_direccion SET pendiente_estado=2 WHERE pendiente_nombre='".$_GET['select']."'";
					$resultado = $conexion -> query($sql);
					if ($conexion->query($sql) == TRUE) {
				
						$sql="UPDATE pendientes_direccion SET pendiente_select=0";
						$rx = $conexion -> query($sql);if ($conexion->query($sql) == TRUE) {}

						historia($nitavu,"<b class=alerta>Rechazo al pendiente ".$_POST['pendiente_nombre']."</b>");
						mensaje("Se RECHAZO con exito <b>".$_POST['pendiente_nombre'],'pendientes_direccion.php?select='.$_GET['select']);			
					}
					else {
						historia($nitavu,"ERROR al Guardar el pendiente ".$_GET['select']." (".$sql.")");
						mensaje("ERROR al Guardar el pendiente <b>".$_GET['select']."(".$sql.")",'pendientes_direccion.php');
						
					}
				}

				if ($_GET['voto']=='ok'){$sql="UPDATE pendientes_direccion SET pendiente_estado=1 WHERE pendiente_nombre='".$_GET['select']."'";
					$resultado = $conexion -> query($sql);
					if ($conexion->query($sql) == TRUE) {
						$sql="UPDATE pendientes_direccion SET pendiente_select=0";
						$rx = $conexion -> query($sql);if ($conexion->query($sql) == TRUE) {}

						historia($nitavu,"<b class=ejecutandose>APROBO </b> al pendiente ".$_POST['pendiente_nombre']."");
						mensaje("Se APROBO con exito <b>".$_GET['select'],'pendientes_direccion.php?select='.$_GET['select']);			
					}
					else {
						historia($nitavu,"ERROR al Guardar el pendiente ".$_GET['select']." (".$sql.")");
						mensaje("ERROR al Guardar el pendiente <b>".$_GET['select']."(".$sql.")",'pendientes_direccion.php');
						
					}
				}
		 		

			}


		} //fn guardar voto

	}
	else {
		//las dos col de los botones ok y x
		echo "<td align='center' >"; //boton ok
    		echo "<b href='pendientes_direccion.php?select=".$_GET['select']."&voto=ok' class='Mbtn btn-tercero'  >";
    		echo "<table  border=0><tr>";    			
    			echo "<td><img src='icon/megusta_azul.png' style='width:18px;'></td>";
    			$votos = pendiente_direccion_votos($_GET['select'],'OK');
    			if ($votos>0){echo "<td class='comentarios_votos'> ".$votos." </td>";}
    			//echo "<td class='comentarios_votos'> ".$votos." </td>";
    		echo "</tr></table>";
		echo "</b>";


		echo "<td align='center' >"; //boton x
    		echo "<b href='pendientes_direccion.php?select=".$_GET['select']."&voto=x' class='Mbtn btn-tercero' >";
    		echo "<table  border=0><tr>";    			
    			echo "<td><img src='icon/nomegusta_rojo.png' style='width:18px;'></td>";
    			$votos = pendiente_direccion_votos($_GET['select'],'X');
    			if ($votos>0){echo "<td class='comentarios_votos'> ".$votos." </td>";}
    			//echo "<td class='comentarios_votos'> ".$votos." </td>";
    		echo "</tr></table>";
		echo "</b>";

	}


	









		    	echo "<td align='center' >";
		    	//echo "<a href='pendientes_direccion.php?select=".$_GET['select']."&display=tv' class='Mbtn btn-tercero'><img src='icon/tv.png' style='width:32px;'></a> ";
		    	echo "</td>";
		    	echo "</tr></table>";

		    	echo "</td>";



		    	echo '</td>';
		    	echo '</tr></table>';		
				echo "</div>";
			}
			else
				{//ELEMENTOS DE PENTIENTES
				//dias transcurridos

				//calculo de dias
				$date1 = new DateTime($f2['pendiente_fechafin']);
				$date2 = new DateTime($fecha);
				$diff = $date1->diff($date2);				
				$dias_faltantes =  $diff->days;


				$date1 = new DateTime($f2['pendiente_fecha']);
				$date2 = new DateTime($f2['pendiente_fechafin']);
				$diff = $date1->diff($date2);				
				$dias_desdealta =  $diff->days;

				$porcentaje = 100/$dias_desdealta * $dias_faltantes;
				$porcentaje = 100 - $porcentaje;

				//echo '<a href="pendientes_direccion.php?select='.$f2['pendiente_nombre'].'">';
				echo "<div id='pendientes_elementos_tenues' ";

				
				//---------- SELECCION DE FONDO DE EL ELEMENTO ---------------------------
				if ($f2['pendiente_estado']=='1'){
					echo "style='   
												background: url(../img/wall2_verde.png);  

												background-size: 100%, 800px;
							    				background-repeat: no-repeat;
							    				background-color: white;
							    				
							    				'";

						
				} else 
				{	if ($f2['pendiente_estado']=='2'){
					echo "style='   
												background: url(../img/wall2_rojo.png);  

												background-size: 100%, 800px;
							    				background-repeat: no-repeat;
							    				background-color: white;
							    				
							    				'";
						
					} else {

							if ($porcentaje<0)	{//alerta naranja y titular
								echo "style='   
															background: url(../img/wall2_naranja.png);  

															background-size: 100%, 800px;
										    				background-repeat: no-repeat;
										    				background-color: white;
										    				
										    				'";

									
							}
							else {
								
								if ($porcentaje>=70){//alerta naranja
									echo "style='   
															background: url(../img/wall2_naranja.png);  

															background-size: ".$porcentaje."%, 800px;
										    				background-repeat: no-repeat;
										    				background-color: white;
										    				
										    				'";

									


								} else {
									echo "style='   
															background: url(../img/wall2.png);  

															background-size: ".$porcentaje."%, 800px;
										    				background-repeat: no-repeat;
										    				background-color: white;
										    				
										    				'";
								}
							}
									

							
								



					}			


				}//---------- F I N - - SELECCION DE FONDO DE EL ELEMENTO ---------------------------
			

				
				echo '<table width="100%" border="0">';
				echo '<tr>';
				echo '<td colspan="4">';



					echo "<table width=100% border=0><tr>";
					echo '<td width="80%"><span>'.$f2['pendiente_nombre'].' </span></td>';
					
					echo "<td>";
					$vt = pendiente_direccion_votos($f2['pendiente_nombre'], 'OK');
					if ($vt>0){
					echo "<span class='pendiente_ltlike'><img src='icon/megusta_lite.png' style='width:20px; height:20px;'>";
					echo "".$vt."</span>";
					}
					echo "</td>";
					

					echo "<td>";
					$vt = pendiente_direccion_votos($f2['pendiente_nombre'], 'X');
					if ($vt>0){
					echo "<span class='pendiente_ltlike'><img src='icon/nomegusta_lite.png' style='width:20px; height:20px;'>";
					echo "".$vt."</span>";
					}
					echo "</td>";
					

					echo "</tr></table>";



				//echo '<label style="font-size:7pt;">* Faltan '.$dias_faltantes.' dias.('.$dias_desdealta.')</label>';
				//echo $porcentaje."%";


				echo '</td>';
				echo '</tr>';
				echo '<tr>';
				//echo '<td><label>'.nitavu_nombre($f2['pendiente_autor']).'</label></td>';
				//echo '<td><label>'.fecha_larga($f2['pendiente_fechafin']).'</label></td>';
				// echo '<td colspan="2">';
				// //echo foto
				// $archivo = "pendientes/". str_replace(' ', '', $f2['pendiente_nombre']).".jpg";	
				// if (file_exists($archivo)){
				// 	echo "<img src='".$archivo."' style='width:100%;'>";
				// }

				// echo '</td>';
		  		echo '</tr>';
		  		echo ' <tr>';
		    	echo '<td colspan="4">';
		    	//botones
		    	echo '</td>';
		    	echo '</tr></table>';		
				echo "</div>";
				echo "</a>";

				}
		}
		else
		{//ELEMENTOS DE PENTIENTES
		$date1 = new DateTime($f2['pendiente_fechafin']);
		$date2 = new DateTime($fecha);
		$diff = $date1->diff($date2);				
		$dias_faltantes =  $diff->days;


		$date1 = new DateTime($f2['pendiente_fecha']);
		$date2 = new DateTime($f2['pendiente_fechafin']);
		$diff = $date1->diff($date2);				
		$dias_desdealta =  $diff->days;

		$porcentaje = 100/$dias_desdealta * $dias_faltantes;
		$porcentaje = 100 - $porcentaje;


		//echo '<a href="pendientes_direccion.php?select='.$f2['pendiente_nombre'].'">';
		echo "<div id='pendientes_elementos'";

					//---------- SELECCION DE FONDO DE EL ELEMENTO ---------------------------
				if ($f2['pendiente_estado']=='1'){
					echo "style='   
												background: url(../img/wall2_verde.png);  

												background-size: 100%, 800px;
							    				background-repeat: no-repeat;
							    				background-color: white;
							    				
							    				'";

						
				} else 
				{	if ($f2['pendiente_estado']=='2'){
					echo "style='   
												background: url(../img/wall2_rojo.png);  

												background-size: 100%, 800px;
							    				background-repeat: no-repeat;
							    				background-color: white;
							    				
							    				'";
						
					} else {

							if ($porcentaje<0)	{//alerta naranja y titular
								echo "style='   
															background: url(../img/wall2_naranja.png);  

															background-size: 100%, 800px;
										    				background-repeat: no-repeat;
										    				background-color: white;
										    				
										    				'";

									
							}
							else {
								
								if ($porcentaje>=70){//alerta naranja
									echo "style='   
															background: url(../img/wall2_naranja.png);  

															background-size: ".$porcentaje."%, 800px;
										    				background-repeat: no-repeat;
										    				background-color: white;
										    				
										    				'";

									


								} else {
									echo "style='   
															background: url(../img/wall2.png);  

															background-size: ".$porcentaje."%, 800px;
										    				background-repeat: no-repeat;
										    				background-color: white;
										    				
										    				'";
								}
							}
									

							
								



					}			


				}//---------- F I N - - SELECCION DE FONDO DE EL ELEMENTO ---------------------------
		echo ">";	
		echo '<table width="100%" border="0">';
		echo '<tr>';
		echo '<td colspan="4">';

		echo "<table width=100% border=0><tr>";
		echo '<td width="80%"><span>'.$f2['pendiente_nombre'].' </span></td>';
		
		echo "<td>";
		$vt = pendiente_direccion_votos($f2['pendiente_nombre'], 'OK');
		if ($vt>0){
		echo "<span class='pendiente_ltlike'><img src='icon/megusta_lite.png' style='width:20px; height:20px;'>";
		echo "".$vt."</span>";
		}
		echo "</td>";
		

		echo "<td>";
		$vt = pendiente_direccion_votos($f2['pendiente_nombre'], 'X');
		if ($vt>0){
		echo "<span class='pendiente_ltlike'><img src='icon/nomegusta_lite.png' style='width:20px; height:20px;'>";
		echo "".$vt."</span>";
		}
		echo "</td>";
		

		echo "</tr></table>";

		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		//echo '<td><label>'.nitavu_nombre($f2['pendiente_autor']).'</label></td>';
		//echo '<td><label>'.fecha_larga($f2['pendiente_fechafin']).'</label></td>';
		// echo '<td colspan="2">';
		// //echo foto
		// $archivo = "pendientes/". str_replace(' ', '', $f2['pendiente_nombre']).".jpg";	
		// if (file_exists($archivo)){
		// 	echo "<img src='".$archivo."' style='width:100%;'>";
		// }

		// echo '</td>';
  		echo '</tr>';
  		echo ' <tr>';
    	echo '<td colspan="4">';
    	//botones
    	echo '</td>';
    	echo '</tr></table>';		
		echo "</div>";
		}
		//echo "</a>";

		$contador = $contador + 1;
	}

	if ($contador == 0) {
		echo "<br><br><br>";
		sentimental("Sin pendientes activos",'');
	}
	//echo "</div>";






	//enviar a display
	if (isset($_GET['display'])){
		if($_GET['display']=='tv'){
			//borramos toda seleccion
			$sql="UPDATE pendientes_direccion SET pendiente_select=0";
			$r = $conexion -> query($sql);if ($conexion->query($sql) == TRUE) {}

			//crea seleccion
			$sql="UPDATE pendientes_direccion SET pendiente_select=1 WHERE pendiente_nombre='".$_GET['select']."'";
			$r = $conexion -> query($sql);if ($conexion->query($sql) == TRUE) {historia($nitavu, "Selecciono el tema ".$_GET['select']." para presentarlo");}
		}

		if($_GET['display']=='pausa'){
			//borramos toda seleccion
			$sql="UPDATE pendientes_direccion SET pendiente_select=0";
			$r = $conexion -> query($sql);if ($conexion->query($sql) == TRUE) {}

			//crea seleccion
			//$sql="UPDATE pendientes_direccion SET pendiente_select=1 WHERE pendiente_nombre='".$_GET['select']."'";
			//$r = $conexion -> query($sql);if ($conexion->query($sql) == TRUE) {historia($nitavu, "Selecciono el tema ".$_GET['select']." para presentarlo");}
		}

	}




	if (isset($_POST['pendiente_comentario_guardar'])){
	//GUARDAR COMENTARIO

		//PRIMERO OBTENER EL COMENTARIO ACTUAL
		$sql = "SELECT * FROM pendientes_direccion  WHERE pendiente_nombre='".$_POST['pendiente_nombre']."'";
		//echo $sql;
		$rc= $conexion -> query($sql);
		$comentario_actual="";
		if($f = $rc -> fetch_array())
		{
			$comentario_actual =  $f['pendiente_comentario'];
		}

		$comentario_form = $_POST['comentario'];
		//CONTACT EL ACTUAL, CON EL NUEVO Y HACER UPDATE
		if ($nivel==2  OR  $nivel==1){			
			$comentario_final = "<table style=background-color:#C3DACD><tr>";

		}else {
		$comentario_final = "<table  ><tr>";	
		}
		
		$comentario_final = $comentario_final."<td width=10%>";
		$comentario_final = $comentario_final."<a  title=".$nitavu."-".str_replace(' ', '_', nitavu_nombre($nitavu)).">";
		$comentario_final = $comentario_final."<img src=fotos/".$nitavu.".jpg class=fotocomentario></a>";
		$comentario_final = $comentario_final."</td><td>".$comentario_form."</td>";
		$comentario_final = $comentario_final."</tr></table>";
		$comentario_final = $comentario_final.$comentario_actual;
		//mensaje($comentario_form,'pendientes.php');
		 $sql="UPDATE pendientes_direccion SET pendiente_comentario='".$comentario_final."' WHERE pendiente_nombre='".$_POST['pendiente_nombre']."'";
		 //echo $sql;

		$resultado = $conexion -> query($sql);
		if ($conexion->query($sql) == TRUE) {
			historia($nitavu,"Agrego comentario al pendiente ".$_POST['pendiente_nombre']);
			mensaje("Comentario guardado con exito para <b>".$_POST['pendiente_nombre'],'pendientes_direccion.php?select='.$_POST['select']);
			
		}
		else {
			historia($nitavu,"ERROR al Guardar comentario al pendiente ".$_POST['pendiente_nombre']." (".$sql.")");
			mensaje("ERROR al guardar <b>".$_POST['pendiente_nombre']."(".$sql.")",'pendientes_direccion.php');
			
		}




	}



	if (isset($_POST['pendiente_guardar'])){
	//GUARDAR
	$pendiente_nombre = $_POST['pendiente_nombre'];
	$pendiente_fecha = $fecha;
	$pendiente_fechafin = $_POST['pendiente_fechafin'];
	$pendiente_autor = $nitavu;
	$pendiente_estado = 0;

	$sql = "
		INSERT INTO pendientes_direccion
		(pendiente_nombre, pendiente_fecha, pendiente_fechafin,  pendiente_autor, pendiente_estado)
		VALUES
		('$pendiente_nombre', '$pendiente_fecha', '$pendiente_fechafin', '$pendiente_autor', '$pendiente_estado')";

	if ($conexion->query($sql) == TRUE)
		{ 
	
		$archivo = "pendientes/". str_replace(' ', '', $pendiente_nombre);		
		subir('pendiente_foto', $archivo, 'jpg');

		historia($nitavu, nitavu_nombre($nitavu)." Agrego el pendiente <b>".$pendiente_nombre."</b>");
		
		//enviar a la lista de miembros, (permisos de usuario)
		//notificacion_add ($usuario, $asunto, $entregar_fecha, $itavu_manda, $contenido)

		mensaje("Pendiente guardado con exito", 'pendientes_direccion.php');
		}
	else
		{historia($nitavu, "ERROR: al guardar pendientes (".$sql.")");
		 mensaje ("Ha habido un error al guardar ".$sql, 'pendientes_direccion.php');
		}




	}



echo "</div>"; //div de pendientes

echo "<div id='pendientes_otros' style='margin-top:0px; background-color:#272822;'>";
//echo "<h1>Actividad de Temas:</h1>";



echo '
<section name="promos" id="promos_display" style="">
	<div id="slider_ecologico_display" style="width:100%;">';

		echo '
	    <div><h1><img src="icon/ok.png" style="width:17px;"> Aprobados este mes</h1>
	    ';

	    $sql="SELECT	* FROM	pendientes_direccion WHERE
			MONTH (pendiente_fecha) = MONTH (NOW())	AND 	YEAR (pendiente_fecha) = YEAR (NOW())
			AND pendiente_estado=1
			order by pendiente_fecha DESC
			";
		echo "<table class='tabla_display' widh='100%'>";
		
		$r2 = $conexion -> query($sql); while($lista = $r2 -> fetch_array())
		{
			echo "<tr>";
			echo "<td width='10%' class='pc'>";
				$archivo = "pendientes/". str_replace(' ', '', $lista['pendiente_nombre']).".jpg";	
				if (file_exists($archivo)){
					echo "<a href='".$archivo."' title='Haga clic aqui para ver en grande' target=_blank><img src='".$archivo."' style='width:45px; height:45px; border-radius:5px;'></a>";
				}
			echo "</td>";
			echo "<td>".$lista['pendiente_nombre']."</td>";
			echo "<td><b class='ejecutandose'>".pendiente_direccion_votos($lista['pendiente_nombre'],'OK')."</b>  <b class='alerta'>".pendiente_direccion_votos($lista['pendiente_nombre'], 'X')."</b> </td>";

			echo "</tr>";
		}
		echo "</table>";
	echo "</div>";


	echo '
	    <div><h1><img src="icon/x.png" style="width:17px;"> Rechazados este mes</h1>
	    ';

	    $sql="SELECT	* FROM	pendientes_direccion WHERE
			MONTH (pendiente_fecha) = MONTH (NOW())	AND 	YEAR (pendiente_fecha) = YEAR (NOW())
			AND pendiente_estado=2
			order by pendiente_fecha DESC
			";
		echo "<table class='tabla_display' widh='100%'>";
		
		$r2 = $conexion -> query($sql); while($lista = $r2 -> fetch_array())
		{
			echo "<tr>";
			echo "<td width='10%' class='pc'>";
				$archivo = "pendientes/". str_replace(' ', '', $lista['pendiente_nombre']).".jpg";	
				if (file_exists($archivo)){
					echo "<a href='".$archivo."' title='Haga clic aqui para ver en grande' target=_blank><img src='".$archivo."' style='width:45px; height:45px; border-radius:5px;'></a>";
				}
			echo "</td>";
			echo "<td>".$lista['pendiente_nombre']."</td>";
			echo "<td><b class='ejecutandose'>".pendiente_direccion_votos($lista['pendiente_nombre'],'OK')."</b> <b class='alerta'>".pendiente_direccion_votos($lista['pendiente_nombre'], 'X')."</b></td>";

			echo "</tr>";
		}
		echo "</table>";
	echo "</div>";



	//LISTA DE MIEMBROS 
	echo '
	    <div><h1><img src="icon/user.png" style="width:17px;"> Participantes</h1>
	    ';

	    $sql="select * from aplicaciones_permisos where idapp='ap54' 			
			";
		echo "<table class='tabla_display' widh='100%'>";
		
		$r2 = $conexion -> query($sql); while($lista = $r2 -> fetch_array())
		{
			echo "<tr>";
			echo "<td width='10%' class='pc'>";
				$archivo = "fotos/".$lista['nitavu'].".jpg";	
				if (file_exists($archivo)){
					echo "<a href='".$archivo."' title='Haga clic aqui para ver en grande'><img src='".$archivo."' style='
					width:45px; height:45px; border-radius:5px;'></a>";
				}
			echo "</td>";
			echo "<td>".nitavu_nombre($lista['nitavu'])."<label class='pc'>".nitavu_puesto($lista['nitavu'])." de ".nitavu_dpto_nombre($lista['nitavu'])."</label></td>";
			// echo "<td>";
			// echo nivel_que($lista['nivel']);
			// echo "</td>";

			echo "</tr>";
		}
		echo "</table>";
	echo "</div>";



	//LISTA DE MIEMBROS 
	echo '
	    <div><h1 style="color:red;"> Top Rechazadores</h1>
	    ';

	    $sql="
		SELECT
			*,
			nitavu as nitavu_,
			(select count(*) from pendientes_direccion_votos where votador=nitavu_ and voto='X') as rechazados,
			(select count(*) from pendientes_direccion_votos where votador=nitavu_ and voto='OK') as aprobados

		FROM
			aplicaciones_permisos
		WHERE
			idapp = 'ap54'
		order by rechazados desc 			
			";
		echo "<table class='tabla_display' widh='100%'>";
		
		$r2 = $conexion -> query($sql); while($lista = $r2 -> fetch_array())
		{
			echo "<tr>";
			echo "<td width='10%' class='pc'>";
				$archivo = "fotos/".$lista['nitavu'].".jpg";	
				if (file_exists($archivo)){
					echo "<a href='".$archivo."' title='Haga clic aqui para ver en grande'><img src='".$archivo."' style='width:45px; height:45px;  border-radius:5px;'></a>";
				}
			echo "</td>";
			echo "<td>".nitavu_nombre($lista['nitavu'])."<label class='pc'>".nitavu_puesto($lista['nitavu'])." de ".nitavu_dpto_nombre($lista['nitavu'])."</label></td>";
			echo "<td>";
			echo $lista['rechazados']."";
			echo "</td>";

			echo "</tr>";
		}
		echo "</table>";
	echo "</div>";


//LISTA DE MIEMBROS 
	echo '
	    <div><h1 style="color:green;">Top Aprobadores</h1>
	    ';

	    $sql="
		SELECT
			*,
			nitavu as nitavu_,
			(select count(*) from pendientes_direccion_votos where votador=nitavu_ and voto='X') as rechazados,
			(select count(*) from pendientes_direccion_votos where votador=nitavu_ and voto='OK') as aprobados

		FROM
			aplicaciones_permisos
		WHERE
			idapp = 'ap54'
		order by aprobados desc 			
			";
		echo "<table class='tabla_display' widh='100%'>";
		
		$r2 = $conexion -> query($sql); while($lista = $r2 -> fetch_array())
		{
			echo "<tr>";
			echo "<td width='10%' class='pc'>";
				$archivo = "fotos/".$lista['nitavu'].".jpg";	
				if (file_exists($archivo)){
					echo "<a href='".$archivo."' title='Haga clic aqui para ver en grande'><img src='".$archivo."' style='width:45px; height:45px; border-radius:5px;'></a>";
				}
			echo "</td>";
			echo "<td>".nitavu_nombre($lista['nitavu'])."<label class='pc'>".nitavu_puesto($lista['nitavu'])." de ".nitavu_dpto_nombre($lista['nitavu'])."</label></td>";
			echo "<td>";
			echo $lista['aprobados']."";
			echo "</td>";

			echo "</tr>";
		}
		echo "</table>";
	echo "</div>";


//LISTA DE abstinencia 
	echo '
	    <div><h1 style="color:green;"><img src="icon/user.png" style="width:17px;">Participantes sin actividad</h1>
	    ';
   		echo "<table class='tabla_display' widh='100%'>";
	    
	    $sql="SELECT *, nitavu AS nitavu_ FROM aplicaciones_permisos WHERE idapp = 'ap54'";
	    $r2 = $conexion -> query($sql); while($miembro = $r2 -> fetch_array())
		{
		$cuantas_abs=0; // clean x usuario
		$cuantos_temas = "";


		    $r2 = $conexion -> query("SELECT * from pendientes_direccion "); while($tema = $r2 -> fetch_array())
			{				

				$sql2="
					select count(*) as n from pendientes_direccion_votos where pendiente_nombre='".$tema['pendiente_nombre']."' and votador='".$miembro['nitavu_']."'
					";
				$rc= $conexion -> query($sql2); if($cero = $rc -> fetch_array())			    
				{
					if ($cero['n']==0){// no participaron
						$cuantas_abs = $cuantas_abs + 1;
						$cuantos_temas = $cuantos_temas." ".$tema['pendiente_nombre'].", ";


					}

				}

			}

			//resumen por usuario
			$usuario = $miembro['nitavu_'];
			$abstinencias = $cuantas_abs;
			$abstinencias_tema = $cuantos_temas;

			if ($abstinencias>=0){
				echo "<tr>";
				echo "<td width='10%' class='pc'>";
				$archivo = "fotos/".$miembro['nitavu_'].".jpg";	
				if (file_exists($archivo)){
					echo "<a href='".$archivo."' title='Haga clic aqui para ver en grande'><img src='".$archivo."' style='width:45px; height:45px; border-radius:5px;'></a>";
				}
				echo "</td>";
				echo "<td>".nitavu_nombre($miembro['nitavu_'])."<label class='pc'>".nitavu_puesto($miembro['nitavu_'])." de ".nitavu_dpto_nombre($miembro['nitavu_'])."</label></td>";
				echo "<td>".$abstinencias." temas no participo </td>";
				echo "<td>".$abstinencias_tema."</td>";

				echo "</tr>";
			}


		}
		echo "</table>";

	echo "</div>";


echo ' 	   
	    
	</div>

	
</section>

';


echo "<div style='width:100%; height:40%; display:inline-block;  '>";
$data =   "['Tema', '%'],
          ['Pendientes de Aprobar',     ".pendiente_direccion_sinaprobar()."],
          ['Aprobados',  ".pendiente_direccion_ok()."],
          ['Rechazados', ".pendiente_direccion_x()."]          
          ";

$grafica = '
 	 <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        '.$data.'
         
        ]);

        var options = {

          pieHole: 0.0, legend:"auto",          
          is3D: false
        };

        var chart = new google.visualization.PieChart(document.getElementById("donutchart"));
        chart.draw(data, options);
      }
    </script>
    <div id="donutchart" style="width: 100%; height:100%; background-color:#272822; border-radius:10px; "></div>';	
	echo $grafica;
echo "</div>";























echo "</div>";

}

// 	echo "<div id='pendientes_footer'>";
// 	echo "<form action='pendientes_direccion.php' method='POST' enctype='multipart/form-data'>";
// 	$hasta = strtotime ( '+10 day' , strtotime ( $fecha ) ) ;
// 	$hasta = date ( 'Y-m-j' , $hasta );

// 	echo '<table width="100%" border="0">
//   <tr>
//     <td colspan="2">';

// echo "<label>Pendiente:</label><input type='text' style='width:100%; ' name='pendiente_nombre' placeholder='Nombre del pendiente' required='required'>";

//     echo '</td>

//     <td width="13%" rowspan="2">';

//     echo "<label></label><input type='submit' name='pendiente_guardar' value='+' class='Mbtn btn-default' style='height:100%; font-size:28pt;'> ";

//     echo '</td>
//   </tr>

//   <tr>
//     <td width="62%">';

// 	echo "<label>Foto (opcional):</label><input type='file' name='pendiente_foto' >";

//     echo '</td>
//     <td width="25%">';

// 	echo "<label>Para cuando?:</label><input type='date' name='pendiente_fechafin' value='".$hasta."'>";

//     echo '</td>
// 	  </tr>
// 	</table>';

// 	echo "</form>";

// 	echo "</div>";
	


	
}
else{echo "No tiene acceso a ".$id_aplicacion;}
echo "</div>";
?>













<?php
//include ("./lib/body_footer.php");
?>