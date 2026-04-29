<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

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
$id_aplicacion ="ap13"; //ap06=Permisos de Aplicacion
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	$delegacion =  midelegacion($nitavu);
	
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	historia($nitavu,"usando la aplicacion [ap13], de vigilancia");	
	echo "<h3> ".$delegacion."</h3>";


	echo "<div id='vigi_sugerencias'>";
		echo "<h1 style='font-size:9pt'>Pases de comida:</h1>";

		if ($delegacion == "OFICINAS CENTRALES"){
			$sql = "
			SELECT	
				empleados_salidas_temporal.*,
				empleados_salidas_temporal.dpto as qdpto,
				(select cat_gerarquia.nombre from cat_gerarquia where id = qdpto) as qdpton,
				(select cat_gerarquia.nivel from cat_gerarquia where id = qdpto) as qnivel
	
			FROM
				empleados_salidas_temporal
			WHERE
				(
					fecha = '".$fecha."'
					AND registro_entrada = '00:00:00'
					AND asunto = 'COMIDA'
					AND autorizo_nitavu <> ''
				)
			ORDER BY
				registro_salida DESC
			";		
		} else {
			$sql = "
			SELECT	
				empleados_salidas_temporal.*,
				empleados_salidas_temporal.dpto as qdpto,
				(select cat_gerarquia.nombre from cat_gerarquia where id = qdpto) as qdpton,
				(select cat_gerarquia.nivel from cat_gerarquia where id = qdpto) as qnivel
	
			FROM
				empleados_salidas_temporal
			WHERE
				(
					fecha = '".$fecha."'
					AND registro_entrada = '00:00:00'
					AND asunto = 'COMIDA'
					AND autorizo_nitavu <> ''
					AND dpto = '".nitavu_dpto($nitavu)."'
				)
			ORDER BY
				registro_salida DESC
			";		
		}
		
		// echo $sql;
		$rc= $conexion -> query($sql); $cuantos = $rc -> num_rows;
		if ($cuantos<=0) {}
		else
		{// SI HAY PASES PENDIENTES:
		
		$midpto = nitavu_dpto($nitavu);
		while($f = $rc -> fetch_array()) 
		{
		if ($delegacion == "OFICINAS CENTRALES")
		{//si no soy de delegacion ===================================================================================================================
			
			if ($f['qdpto']=='45'){// INLCUIMOS LA DEL DE VICTORIA, PORQUE CHECA EN TARJETA
				if ($f['registro_salida']<>'00:00:00' AND $f['registro_entrada']<>'00:00:00')	{
					//el pase ya fue realizado y no mostramos nada
					}
					else{//pero sino, mostramos el pase		

						if ($f['registro_salida']=='00:00:00'){//aun no sale, doy url para q salga
							echo "<article >";	
							echo "<a style='color:gray;' href='vigilancia3.php?comida_sale=".$f['id']."&quien=".$f['nitavu']."' title='".$f['nitavu']." | ".nitavu_nombre($f['nitavu'])." | ".$f['asunto']."'>";
						} else {// si ya salio, le doy para entrada
							echo "<article  style='border-color:red;'>";	
							echo "<a style='color:gray;' href='vigilancia3.php?comida_entra=".$f['id']."&quien=".$f['nitavu']."' title='".$f['nitavu']." | ".nitavu_nombre($f['nitavu'])." | ".$f['asunto']."'>";
						}

							echo ponerfoto("fotos/".$f['nitavu'].".jpg",'vigi_foto')."<br>";							
							echo "<div >".$f['nitavu']."</div>";
							echo $f['asunto']."<br>";

						echo "</a></article>";
					}
					

					if (isset($_GET['comida_sale'])){
						if (comida_salio($_GET['comida_sale'], $nitavu, $_GET['quien'])==TRUE)
						{mensaje("Pase marcado para salida correctamente",'vigilancia3.php');}
					}

					if (isset($_GET['comida_entra'])){
						if (comida_entro($_GET['comida_entra'], $nitavu, $_GET['quien'])==TRUE)
						{mensaje("Pase marcado para salida correctamente",'vigilancia3.php');}
					}

			} else {
				if ($f['qnivel']<>'del' ){//todas las de oficinas centrales-----------------------
					if ($f['registro_salida']<>'00:00:00' AND $f['registro_entrada']<>'00:00:00')	{
						//el pase ya fue realizado y no mostramos nada
						}
						else{//pero sino, mostramos el pase		
	
							if ($f['registro_salida']=='00:00:00'){//aun no sale, doy url para q salga
								echo "<article >";	
								echo "<a style='color:gray;' href='vigilancia3.php?comida_sale=".$f['id']."&quien=".$f['nitavu']."' title='".$f['nitavu']." | ".nitavu_nombre($f['nitavu'])." | ".$f['asunto']."'>";
							} else {// si ya salio, le doy para entrada
								echo "<article  style='border-color:red;'>";	
								echo "<a style='color:gray;' href='vigilancia3.php?comida_entra=".$f['id']."&quien=".$f['nitavu']."' title='".$f['nitavu']." | ".nitavu_nombre($f['nitavu'])." | ".$f['asunto']."'>";
							}
	
								echo ponerfoto("fotos/".$f['nitavu'].".jpg",'vigi_foto')."<br>";							
								echo "<div >".$f['nitavu']."</div>";
								echo $f['asunto']."<br>";
	
							echo "</a></article>";
						}
						
	
						if (isset($_GET['comida_sale'])){
							if (comida_salio($_GET['comida_sale'], $nitavu, $_GET['quien'])==TRUE)
							{mensaje("Pase marcado para salida correctamente",'vigilancia3.php');}
						}
	
						if (isset($_GET['comida_entra'])){
							if (comida_entro($_GET['comida_entra'], $nitavu, $_GET['quien'])==TRUE)
							{mensaje("Pase marcado para salida correctamente",'vigilancia3.php');}
						}
	
				}
			}
			
			
							


		} else 
		{//si yo soy de una delegacion -------------------------------------------------				
			if ($f['qdpto']==$midpto){//filtra solo los de mi delegacion
				
								if ($f['registro_salida']<>'00:00:00' AND $f['registro_entrada']<>'00:00:00')	{
								//el pase ya fue realizado y no mostramos nada
								}
								else{//pero sino, mostramos el pase		

									if ($f['registro_salida']=='00:00:00'){//aun no sale, doy url para q salga
										echo "<article >";	
										echo "<a style='color:gray;' href='vigilancia3.php?comida_sale=".$f['id']."&quien=".$f['nitavu']."' title='".$f['nitavu']." | ".nitavu_nombre($f['nitavu'])." | ".$f['asunto']."'>";
									} else {// si ya salio, le doy para entrada
										echo "<article  style='border-color:red;'>";	
										echo "<a style='color:gray;' href='vigilancia3.php?comida_entra=".$f['id']."&quien=".$f['nitavu']."' title='".$f['nitavu']." | ".nitavu_nombre($f['nitavu'])." | ".$f['asunto']."'>";
									}

										echo ponerfoto("fotos/".$f['nitavu'].".jpg",'vigi_foto')."<br>";							
										echo "<div >".$f['nitavu']."</div>";
										echo $f['asunto']."<br>";

									echo "</a></article>";
								}
								

								if (isset($_GET['comida_sale'])){
									if (comida_salio($_GET['comida_sale'], $nitavu, $_GET['quien'])==TRUE)
									{mensaje("Pase marcado para salida correctamente",'vigilancia3.php');}
								}

								if (isset($_GET['comida_entra'])){
									if (comida_entro($_GET['comida_entra'], $nitavu, $_GET['quien'])==TRUE)
									{mensaje("Pase marcado para salida correctamente",'vigilancia3.php');}
								}

							
			}//filtro mi delegacion
		}//==================================================================================================================

		}//while
		}//cuantos


	echo "</div>";




	echo "<div id='vigi_sugerencias_oficial' style='opacity: 1;'>";
	echo "<h1 style='font-size:9pt'>Salidas oficiales y personales:</h1>";

	if ($delegacion == "OFICINAS CENTRALES"){$sql = "
		SELECT	
			empleados_salidas_temporal.*,
			empleados_salidas_temporal.dpto as qdpto,
			(select cat_gerarquia.nombre from cat_gerarquia where id = qdpto) as qdpton,
			(select cat_gerarquia.nivel from cat_gerarquia where id = qdpto) as qnivel

		FROM
			empleados_salidas_temporal
		WHERE
			(
				fecha = '".$fecha."'
				AND registro_entrada = '00:00:00'
				AND asunto <> 'COMIDA'
				AND autorizo_nitavu <> ''
			)
		ORDER BY
			registro_salida DESC
		";		

	} else {
		$sql = "
		SELECT	
			empleados_salidas_temporal.*,
			empleados_salidas_temporal.dpto as qdpto,
			(select cat_gerarquia.nombre from cat_gerarquia where id = qdpto) as qdpton,
			(select cat_gerarquia.nivel from cat_gerarquia where id = qdpto) as qnivel

		FROM
			empleados_salidas_temporal
		WHERE
			(
				fecha = '".$fecha."'
				AND registro_entrada = '00:00:00'
				AND asunto <> 'COMIDA'
				AND autorizo_nitavu <> ''
				AND dpto = '".nitavu_dpto($nitavu)."'
			)
		ORDER BY
			registro_salida DESC
		";		
	}
		
		// echo $sql;
		$rc= $conexion -> query($sql); $cuantos = $rc -> num_rows;
		if ($cuantos<=0) {}
		else
		{// SI HAY PASES PENDIENTES:
		
		$midpto = nitavu_dpto($nitavu);
		while($f = $rc -> fetch_array()) 
		{
		if ($delegacion == "OFICINAS CENTRALES")
		{//si no soy de delegacion ===================================================================================================================
			
			if ($f['qdpto']=='45'){// INLCUIMOS LA DEL DE VICTORIA, PORQUE CHECA EN TARJETA
				
				if ($f['registro_salida']<>'00:00:00' AND $f['registro_entrada']<>'00:00:00')	{
					//el pase ya fue realizado y no mostramos nada
					}
					else{//pero sino, mostramos el pase		

						if ($f['registro_salida']=='00:00:00'){//aun no sale, doy url para q salga
							echo "<article >";	
							echo "<a style='color:gray;' href='vigilancia3.php?nocomida_sale=".$f['id']."&quien=".$f['nitavu']."' title='".$f['nitavu']." | ".nitavu_nombre($f['nitavu'])." | ".$f['asunto']."'>";
						} else {// si ya salio, le doy para entrada
							echo "<article  style='border-color:red;'>";	
							echo "<a style='color:gray;' href='vigilancia3.php?nocomida_entra=".$f['id']."&quien=".$f['nitavu']."' title='".$f['nitavu']." | ".nitavu_nombre($f['nitavu'])." | ".$f['asunto']."'>";
						}

							echo ponerfoto("fotos/".$f['nitavu'].".jpg",'vigi_foto')."<br>";							
							echo "<div >".$f['nitavu']."</div>";
							echo $f['asunto']."<br>";

						echo "</a></article>";
					}
					

					if (isset($_GET['nocomida_sale'])){
						if (nocomida_salio($_GET['nocomida_sale'], $nitavu, $_GET['quien'])==TRUE)
						{mensaje("Pase marcado para salida correctamente",'vigilancia3.php');}
					}

					if (isset($_GET['nocomida_entra'])){
						if (nocomida_entro($_GET['nocomida_entra'], $nitavu, $_GET['quien'])==TRUE)
						{mensaje("Pase marcado para salida correctamente",'vigilancia3.php');}
					}

				
			} else {
				if ($f['qnivel']<>'del'){
					if ($f['registro_salida']<>'00:00:00' AND $f['registro_entrada']<>'00:00:00')	{
						//el pase ya fue realizado y no mostramos nada
						}
						else{//pero sino, mostramos el pase		
	
							if ($f['registro_salida']=='00:00:00'){//aun no sale, doy url para q salga
								echo "<article >";	
								echo "<a style='color:gray;' href='vigilancia3.php?nocomida_sale=".$f['id']."&quien=".$f['nitavu']."' title='".$f['nitavu']." | ".nitavu_nombre($f['nitavu'])." | ".$f['asunto']."'>";
							} else {// si ya salio, le doy para entrada
								echo "<article  style='border-color:red;'>";	
								echo "<a style='color:gray;' href='vigilancia3.php?nocomida_entra=".$f['id']."&quien=".$f['nitavu']."' title='".$f['nitavu']." | ".nitavu_nombre($f['nitavu'])." | ".$f['asunto']."'>";
							}
	
								echo ponerfoto("fotos/".$f['nitavu'].".jpg",'vigi_foto')."<br>";							
								echo "<div >".$f['nitavu']."</div>";
								echo $f['asunto']."<br>";
	
							echo "</a></article>";
						}
						
	
						if (isset($_GET['nocomida_sale'])){
							if (nocomida_salio($_GET['nocomida_sale'], $nitavu, $_GET['quien'])==TRUE)
							{mensaje("Pase marcado para salida correctamente",'vigilancia3.php');}
						}
	
						if (isset($_GET['nocomida_entra'])){
							if (nocomida_entro($_GET['nocomida_entra'], $nitavu, $_GET['quien'])==TRUE)
							{mensaje("Pase marcado para salida correctamente",'vigilancia3.php');}
						}
	
				}
				
			}

			


		} else 
		{//si yo soy de una delegacion -------------------------------------------------				
			
				
							if ($f['registro_salida']<>'00:00:00' AND $f['registro_entrada']<>'00:00:00')	{
							//el pase ya fue realizado y no mostramos nada
							}
							else{//pero sino, mostramos el pase		

								if ($f['registro_salida']=='00:00:00'){//aun no sale, doy url para q salga
									echo "<article >";	
									echo "<a style='color:gray;' href='vigilancia3.php?nocomida_sale=".$f['id']."&quien=".$f['nitavu']."' title='".$f['nitavu']." | ".nitavu_nombre($f['nitavu'])." | ".$f['asunto']."'>";
								} else {// si ya salio, le doy para entrada
									echo "<article  style='border-color:red;'>";	
									echo "<a style='color:gray;' href='vigilancia3.php?nocomida_entra=".$f['id']."&quien=".$f['nitavu']."' title='".$f['nitavu']." | ".nitavu_nombre($f['nitavu'])." | ".$f['asunto']."'>";
								}

									echo ponerfoto("fotos/".$f['nitavu'].".jpg",'vigi_foto')."<br>";							
									echo "<div >".$f['nitavu']."</div>";
									echo $f['asunto']."<br>";

								echo "</a></article>";
							}
							

							if (isset($_GET['nocomida_sale'])){
								if (nocomida_salio($_GET['nocomida_sale'], $nitavu, $_GET['quien'])==TRUE)
								{mensaje("Pase marcado para salida correctamente",'vigilancia3.php');}
							}

							if (isset($_GET['nocomida_entra'])){
								if (nocomida_entro($_GET['nocomida_entra'], $nitavu, $_GET['quien'])==TRUE)
								{mensaje("Pase marcado para salida correctamente",'vigilancia3.php');}
							}

		
							
		//filtro mi delegacion
		}//==================================================================================================================

		}//while
		}//cuantos


		
		
			
	echo "</div>";











	//CONTROL DE ASISTENCIA
	echo "<section id='asistencia'>";

	if ($delegacion == "OFICINAS CENTRALES"){

			$sql = "SELECT
			dpto AS Qdpto,
			( SELECT nivel FROM cat_gerarquia WHERE id = Qdpto ) AS qnivel,
			empleados.* 
		FROM
			empleados 
		WHERE
			( control_asistencia = 'TRUE' ) and estado not like '%BAJA%'";

	}else {
		
			$sql = "SELECT
			dpto AS Qdpto,
			( SELECT nivel FROM cat_gerarquia WHERE id = Qdpto ) AS qnivel,
			empleados.* 
		FROM
			empleados 
		WHERE
			 control_asistencia = 'TRUE' AND dpto='".nitavu_dpto($nitavu)."'";

	}

	


		//echo $sql;
		$rc= $conexion -> query($sql);
		$cuantosx = $rc -> num_rows;

		if ($cuantosx<=0) {
			$msgxx="<b>NO SE ENCONTRO ASISTENCIA EN EL RESULTADO DE LA BUSQUEDA</B><BR>

			Razones por las que no aparece:
			<lu>
			<li> No se ha activado el control de asistencia </li>
			<li> Cheque con el dpto de recursos humanos.</li>
			</lu>
			";
			//mensaje($msgxx,'vigilancia.php');
		}
		else
		{
			echo "<hr><span class='tenue' style='font-size:11pt;'>Hay ".$cuantosx." empleados con control de asistencia: <br> </span>";

			while($fa = $rc -> fetch_array()) {
				if ($delegacion == "OFICINAS CENTRALES")
				{

					if ($fa['dpto']=='45'){//INCLUIMOS A VICTORIA
						if (asistencia_salida($fa['nitavu'])==''){
							if (asistencia_entrada($fa['nitavu'])==''){
							echo "<a class='' href='asistencia_entro.php?id=".$fa['nitavu']."'><article style=''>";
							}
							else
							{									
								echo "<a class='' href='asistencia_salio.php?id=".$fa['nitavu']."'> <article style='background-color:#FF8A8A; border: 1px solid red;'>";
							}
						}
						else
						{
							if (asistencia_salida($fa['nitavu'])=='00:00:00'){
								echo "<a class='' href='asistencia_salio.php?id=".$fa['nitavu']."'><article style='background-color:#FF8A8A; border: 1px solid red;;'>";
							}
							else
							{
							echo "<article  style='opacity: 0; display:none;' >";						
							}
						}			
						
						echo "<table><tr><td align='center'>";
		
						echo ponerfoto("fotos/".$fa['nitavu'].".jpg",'');
						//echo "<div id='nombre_sombra' class=''>".nombre_corto($f['nitavu'])."</div>";
						echo "<div style='font-size:8pt;' >".nombre_corto($fa['nitavu'],0)."</div>";
						//echo "<div id='ide' class=''>".$fa['nitavu']."</div>";
						//echo "<div id='nombre_vertical' class='texto_vertical'>".nombre_corto($f['nitavu'],1)."</div>";
						
						echo "</td>";
						
						echo "<td align='center'>";		
						//echo "<span class='tchico'>".user_legend($fa['nitavu'])."</span><br><br>";
						
						echo "</td>";
						echo "</tr></table>";
						echo "</article></a>";
					}
					else{
						if ($fa['qnivel']<>'del'){ //solo de oficinas centrales					
							if (asistencia_salida($fa['nitavu'])==''){
							if (asistencia_entrada($fa['nitavu'])==''){
							echo "<a class='' href='asistencia_entro.php?id=".$fa['nitavu']."'><article style=''>";
							}
							else
							{									
								echo "<a class='' href='asistencia_salio.php?id=".$fa['nitavu']."'> <article style='background-color:#FF8A8A; border: 1px solid red;'>";
							}
						}
						else
						{
							if (asistencia_salida($fa['nitavu'])=='00:00:00'){
								echo "<a class='' href='asistencia_salio.php?id=".$fa['nitavu']."'><article style='background-color:#FF8A8A; border: 1px solid red;;'>";
							}
							else
							{
							echo "<article  style='opacity: 0; display:none;' >";						
							}
						}			
						
						echo "<table><tr><td align='center'>";
		
						echo ponerfoto("fotos/".$fa['nitavu'].".jpg",'');
						//echo "<div id='nombre_sombra' class=''>".nombre_corto($f['nitavu'])."</div>";
						echo "<div style='font-size:8pt;' >".nombre_corto($fa['nitavu'],0)."</div>";
						//echo "<div id='ide' class=''>".$fa['nitavu']."</div>";
						//echo "<div id='nombre_vertical' class='texto_vertical'>".nombre_corto($f['nitavu'],1)."</div>";
						
						echo "</td>";
						
						echo "<td align='center'>";		
						//echo "<span class='tchico'>".user_legend($fa['nitavu'])."</span><br><br>";
						
						echo "</td>";
						echo "</tr></table>";
						echo "</article></a>";

						}
					}
				}
				else{
					if (asistencia_salida($fa['nitavu'])==''){
						if (asistencia_entrada($fa['nitavu'])==''){
						echo "<a class='' href='asistencia_entro.php?id=".$fa['nitavu']."'><article style=''>";
						}
						else
						{									
							echo "<a class='' href='asistencia_salio.php?id=".$fa['nitavu']."'> <article style='background-color:#FF8A8A; border: 1px solid red;'>";
						}
					}
					else
					{
						if (asistencia_salida($fa['nitavu'])=='00:00:00'){
							echo "<a class='' href='asistencia_salio.php?id=".$fa['nitavu']."'><article style='background-color:#FF8A8A; border: 1px solid red;;'>";
						}
						else
						{
						echo "<article  style='opacity: 0; display:none;' >";						
						}
					}			
					
					echo "<table><tr><td align='center'>";
	
					echo ponerfoto("fotos/".$fa['nitavu'].".jpg",'');
					//echo "<div id='nombre_sombra' class=''>".nombre_corto($f['nitavu'])."</div>";
					echo "<div style='font-size:8pt;' >".nombre_corto($fa['nitavu'],0)."</div>";
					//echo "<div id='ide' class=''>".$fa['nitavu']."</div>";
					//echo "<div id='nombre_vertical' class='texto_vertical'>".nombre_corto($f['nitavu'],1)."</div>";
					
					echo "</td>";
					
					echo "<td align='center'>";		
					//echo "<span class='tchico'>".user_legend($fa['nitavu'])."</span><br><br>";
					
					echo "</td>";
					echo "</tr></table>";
					echo "</article></a>";

				}
				


				}

		echo "</section>";
	}









	


	
}
else{echo "No tiene acceso a ".$id_aplicacion;}

?>


<br><br><br><br><br><br><br><br>









<?php
include ("./lib/body_footer.php");
?>