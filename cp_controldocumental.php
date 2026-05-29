<?php include ("./lib/body_head.php");
include ("./lib/body_menu.php"); 

// require ("./lib/flor_funciones.php");
?>
<link rel="stylesheet" href="lib/laura.css" />
<?php

$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap66";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	
	//PARA DAR ACCESO CUANDO ESTE REGISTRADA
	//historia($nitavu,'Req_ Entró a la aplicacion requisiciones'); 
	
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
 
	echo '
		<script>
		function myFunction(){
			var publico = document.getElementById("publico");
			var baja = document.getElementById("baja");
			var media = document.getElementById("media");
			var alta = document.getElementById("alta");
			if (publico.checked == true){
			 //delegacion.checked == false;
			 document.getElementById("ofnumero").value='.numeroOficioPublico(TRUE).';
			}else{
			 document.getElementById("ofnumero").value="";
			}
			if(baja.checked == true){
				media.checked = false;
				alta.checked = false;
			}else if(media.checked == true){
				baja.checked = false;
				alta.checked = false;
			}else if(alta.checked == true){
				baja.checked = false;
				media.checked = false;
			}
		}
		function deshabilitar(){
		}
		</script>
	';
	//Obtencion de datos para turnar caso.
	if(isset($_POST['idCaso']) and isset($_POST['numeroSeleccionado']) and isset($_POST['departamento'])){
		$idDocumento = $_POST['idCaso'];
		$compartir = $_POST['compartir'];
		historia($nitavu,'cp_Turno el caso número: '.$idDocumento);
		if($idDocumento != ""){
			$idDocumento = $_POST['idCaso'];
			$num = $_POST['numeroSeleccionado'];
			$dptoEnviar = $_POST['departamento'];
			if($dptoEnviar == 1000){
				mensaje("Favor de seleccionar un departamento a enviar", 'cp_controldocumental.php');
			}else{
				if(!empty($_FILES['contestacion']['name']) != null){
					$numDocumento = numdeDocumento(TRUE);
					$doc = $_FILES["contestacion"]["name"];
					$tmp =$_FILES["contestacion"]["tmp_name"];
					$fecha=$_POST['fechaOficio'];
					//Consulta para saber a quien se enviará
					//$dptoEnviar = departamentoEnviar($num);
					$midpto = nitavu_dpto($nitavu);
					$archivo1 = "peticiones/".$numDocumento.'_'.$idDocumento.'_'.$doc."";
					$subida1 = FTP_subir($tmp,$archivo1);
					if ($subida1 == "TRUE"){
						$sql = "INSERT INTO cp_historialdocumentos(idInc,idDoc, NumCaso, archivo, fecha, nitavuSube, dptoSube, dptoEnviar, numOficio,hora) 
						VALUES (NULL,'$numDocumento', '$idDocumento', '$doc', '$fecha', '$nitavu', '$midpto','$dptoEnviar','$num','$hora')";
						if ($conexion->query($sql) == TRUE){ 
							$sql2 = "UPDATE cp_nuevosdocumentos SET Turnadoa=".$dptoEnviar." WHERE id=".$idDocumento."";
							if ($conexion->query($sql2) == TRUE){ 
								//$sql3 = "UPDATE cp_controlcorrespondencia SET utilizado=1 WHERE numdocumento='".$num."'";
								//if ($conexion->query($sql3) == TRUE){
									numdeDocumento(FALSE);
									$turnara = aQuienSeTurnara($dptoEnviar,$idDocumento);
									for($i=0; $i < sizeof($turnara); $i++){
										if($turnara[$i]<>null || $turnara[$i]<>"" ){
											notificacion_add($turnara[$i],'Nuevo caso: '.$idDocumento.'', $fecha,$nitavu,'Buen día. <br> Turno esta petición '.$idDocumento.' con asunto:<b>'.asuntoCaso($idDocumento).'</b> a su departamento debido a que compete a su área el requerimiento.');
	
										}
									}
								
									if($nivel==3 || $nivel==1){		
										
											$sql = "UPDATE cp_colaboradores SET activo=1 WHERE nitavu=". $nitavu. " and numcaso=".$idDocumento;
											if ($conexion->query($sql) == TRUE){      
												historia($nitavu,'Cambio de estatus del colaborador en el caso: '.$idDocumento.' a '.nitavu_nombre($nitavu).'debido a que tengo nivel 3.');    
											}
																	
									}
									quitarVistoBueno($idDocumento);
									if (!isset($_POST['compartir'])){
										eliminarColaboraciones($idDocumento);
									}
									mensaje('Se ha turnado el caso con éxito.','cp_controldocumental.php'); 
									//agregarSeguimiento($idDocumento, $num, $numDocumento ,$dptoEnviar, $fecha);
								//}else{
								//mensaje('Hubo un error al momento de turnar el caso, por favor vuelva a intentarlo.','cp_nuevos_oficios.php?id='.$idDocumento.'');
								//}	 
							}else{
								mensaje('Hubo un error al momento de turnar el caso, por favor vuelva a intentarlo.','cp_nuevos_oficios.php?id='.$idDocumento.'');
							}     
						}else{
							mensaje('Hubo un error al momento de turnar el caso, por favor vuelva a intentarlo.','cp_nuevos_oficios.php?id='.$idDocumento.'');
						}
					}else{
						mensaje('Hubo un error al momento de intentar subir el archivo.','cp_nuevos_oficios.php?id='.$idDocumento.'');  
					}
				}else{
					//EN CASO DE QUE AL TURNAR NO HAYA SUBIDO UN ARCHIVO
					//Consulta para saber a quien se enviará
					//$dptoEnviar = departamentoEnviar($num);
					
					$midpto = nitavu_dpto($nitavu);
					$sql = "INSERT INTO cp_historialdocumentos(idInc,idDoc, NumCaso, archivo, fecha, nitavuSube, dptoSube, dptoEnviar, numOficio,hora) 
						VALUES (NULL,NULL, '$idDocumento', '', '$fecha', '$nitavu', '$midpto','$dptoEnviar','$num','$hora')";
						if ($conexion->query($sql) == TRUE){ 
							$sql2 = "UPDATE cp_nuevosdocumentos SET Turnadoa=".$dptoEnviar." WHERE id=".$idDocumento."";
							if ($conexion->query($sql2) == TRUE){ 
								//$sql3 = "UPDATE cp_controlcorrespondencia SET utilizado=1 WHERE numdocumento='".$num."'";
								//if ($conexion->query($sql3) == TRUE){
									numdeDocumento(FALSE);
									$turnara = aQuienSeTurnara($dptoEnviar,$idDocumento);
	
									for($i=0; $i < sizeof($turnara); $i++){
										if($turnara[$i]<>null || $turnara[$i]<>"" ){
											notificacion_add($turnara[$i],'Nuevo caso: '.$idDocumento.'', $fecha,$nitavu,'Buen día. <br> Turno esta petición '.$idDocumento.' con asunto:<b>'.asuntoCaso($idDocumento).'</b> a su departamento debido a que compete a su área el requerimiento.');
	
										}
									}
									if($nivel==3 || $nivel==1){
										
										 $sql = "UPDATE cp_colaboradores SET activo=1 WHERE nitavu=". $nitavu. " and numcaso=".$idDocumento;
											if ($conexion->query($sql) == TRUE){      
												historia($nitavu,'Cambio de estatus del colaborador en el caso: '.$idDocumento.' a '.nitavu_nombre($nitavu).'debido a que tengo nivel 3.');    
											}
										
									}
									quitarVistoBueno($idDocumento);
									if (!isset($_POST['compartir'])){
										eliminarColaboraciones($idDocumento);
									}
									mensaje('Se ha turnado el caso con éxito.','cp_controldocumental.php'); 
									//agregarSeguimiento($idDocumento, $num, $numDocumento ,$dptoEnviar, $fecha);
								//}else{
								//mensaje('Hubo un error al momento de turnar el caso, por favor vuelva a intentarlo.','cp_nuevos_oficios.php?id='.$idDocumento.'');
								//}	 	 
							}else{
								mensaje('Hubo un error al momento de turnar el caso, por favor vuelva a intentarlo.','cp_nuevos_oficios.php?id='.$idDocumento.'');
							}        
						}else{
							mensaje('Hubo un error al momento de turnar el caso, por favor vuelva a intentarlo.','cp_nuevos_oficios.php?id='.$idDocumento.'');
						}
					//mensaje('No ha seleccionado ningun archivo.','cp_nuevos_oficios.php?id='.$idDocumento.'');
				}	
			}
			
		}else{
			return mensaje('No ha seleccionado el número con el que se turnará','cp_controldocumental.php');
		}
		
	}
	//OBTENER DATOS PARA FINALIZAR EL CASO 
	if(isset($_POST['comSolucionar'])){
		$id = $_POST['id'];
		historia($nitavu,'cp_Finalizo el caso: '.$id.' quien: '.$nitavu);
		//$desc = $_POST['desc'];
		$nuevades = strtoupper($_POST['comSolucionar']);
		//$desJuntas = $desc.'. '.$nuevades;
		//$sql = "UPDATE cp_nuevosdocumentos SET descripcion='".$desJuntas."', estado=1 WHERE id=".$id."";

		//* se registra el comentario final como un nuevo comentario
			$sql="";
			//$sql = "INSERT INTO cp_comentarios (CasoId, Comentario,  Nuser, Fecha, Hora) 
            //    VALUES ('".$id."', '".$_POST['comentario']."', '".$nitavu."', '".$fecha."', '".$hora."')";
			$sql = "INSERT INTO cp_comentarios (CasoId, Comentario,  Nuser, Fecha, Hora) 
			VALUES ('".$id."', 'COMENTARIO FINAL-".$nuevades."', '".$nitavu."', '".$fecha."', '".$hora."')";

        if ($conexion->query($sql) == TRUE)
            {
            historia($nitavu,'cp_Comentar caso: '.$id.' Agrego el comentario: '.$nuevades.' ');
            notificarParticipantes($id,$nitavu,'Se agrego un nuevo comentario al caso '.$id.'','Nuevos comentarios al caso '.$id);
            // mensaje('Comentario Guardado correctamente','cp_nuevos_oficios.php?id="'.$_GET['id']);
            unset($_POST['comentario'], $_POST['Comentar']);

			//*	
				//el estado en 1 nos dice que el caso ha sido terminado 		
				//registro terminado el caso
				$sql = "UPDATE cp_nuevosdocumentos SET estado=1, fecha_termino='".$fecha."' WHERE id=".$id."";
				if ($conexion->query($sql) == TRUE) {
					$empleados = participantesDelCaso($id);
					for($i=0; $i < sizeof($empleados); $i++){
						if($empleados[$i]<>null || $empleados[$i]<>"" ){
							if($nitavu <> $empleados[$i] ){
								notificacion_add($empleados[$i],'Caso finalizado '.$id.'', $fecha,$nitavu,'Buen día. <br> Se le informa que la petición número '.$id.' ha finalizado. <br>De asunto:<b>'.asuntoCaso($id).'</b> <br>Para más información consultar en la aplicación Control Documental.');
							}

						}
					}
					return mensaje('Se ha guardado la información correctamente. El caso ha sido terminado.','cp_controldocumental.php');
				}else{
					return mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','cp_controldocumental.php');
				}


			//*	
            }
        else {
        	mensaje('ERROR al guardar el comentario final','cp_nuevos_oficios.php?id="'.$_GET['id']);
            }	
			
	}
	// echo"<h1>Control Documental De: <span style='color:#0064A7'>".nitavu_dpto_nombre($nitavu)." <span></h1>";
	// echo "<br>";
	//-----------------------------------------------------

	//Obtencion de datos para modificar informacion de un oficio 
	if(isset($_GET['editar'])){
		$numcaso = $_GET['editar'];
		$fechaoficio = $_POST['fechaOficio'];
		$fecha = $_POST['fecha'];
		$fechaTermino = $_POST['fechaTermino'];
		if(isset($_POST['fechaTermino'])){
			$fechaTermino = $_POST['fechaTermino'];
		}else{
			$fechaTermino ='';
		}
		$fechaTerminoSql = ($fechaTermino !== '') ? '"'.$fechaTermino.'"' : '"0000-00-00"';
		$ofnumero = $_POST['ofnumero'];
		//$prioridad = $_POST['prioridad'];
		$remite = $_POST['remite'];
		$puesto = $_POST['puesto'];
		$dependencia = $_POST['dependencia'];
		$asunto = $_POST['asunto'];
		$descripcion = $_POST['descripcion'];

		
		 $sql = 'UPDATE cp_nuevosdocumentos SET fechaOficio="'.$fechaoficio.'", fecha="'.$fecha.'", oficioNumero="'.$ofnumero.'",
		remite="'.$remite.'", puesto="'.$puesto.'", dependencia="'.$dependencia.'", asunto="'.$asunto.'", descripcion="'.$descripcion.'", fecha_termino = '.$fechaTerminoSql.'
		 WHERE id='. $numcaso.' ';
		//echo $sql;
		if ($conexion->query($sql) == TRUE){      
			historia($nitavu,'Modifico la información del caso: '.$numcaso.' sql_'.$sql);    
			mensaje('Se modifico la información correctamente.','cp_controldocumental.php');
		}else{
			mensaje('Ocurrio un error, favor de volver a intentarlo.','cp_controldocumental.php');

		}
	}
	

	//ELIMINAR UN CASO 
	if(isset($_POST['darBaja'])){
		$numcaso = $_POST['darBaja'];

		$sql = 'UPDATE cp_nuevosdocumentos SET baja=1 WHERE id='. $numcaso.'';
		//echo $sql;
		if ($conexion->query($sql) == TRUE){      
			historia($nitavu,'Se ha eliminado el caso: '.$numcaso.'');    
			mensaje('Se ha eliminado correctamente el caso.','cp_controldocumental.php');
		}else{
			mensaje('Ocurrio un error, favor de volver a intentarlo.','cp_controldocumental.php');
		}
	}

//BOTONES MENU


echo "<div id='req_menu'>"; 
$dpto = nitavu_dpto($nitavu);
if ($nivel==1 || soytitular($nitavu)!='FALSE'){
// echo "<a href='#documentoNew' rel='MyModal:open' class='Mbtn btn-default' title='Registrar Caso'>";
// 	echo "<table  width='100%'><tr><td valign='middle' align='center'>";
// 	echo "<img src='icon/docNuevo.png' >";
// 	echo "</td>";
// 	echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
// 	echo "Registrar Oficio";
// 	echo "</td></tr></table>";
// echo "</a>";


echo "<a href='#documentoNew' rel='MyModal:open' class=' btn-g' title='Registrar Caso'>";
	echo "<table  width='100%'><tr><td valign='middle' align='center'>";
	echo "<img src='icon/addRep.png' >";
	echo "</td>";
	echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
	// echo "Registrar Oficio";
	echo "</td></tr></table>";
echo "</a>";



}
$arr = revisarMisColaboraciones($nitavu);
$dibuje =0;
for ($i=0; $i < count($arr) ; $i++) { 
	if($nivel==1 || (soytitular($nitavu)!='FALSE'  and $dibuje==0) || ((soyColaborador($nitavu)=='TRUE') and (soyDptoturnado($arr[$i] ,$dpto)=='FALSE') and $dibuje==0) ){
		$dibuje=1;
		// echo "<a href='#myModalaAgregar' rel='MyModal:open' class='Mbtn btn-default' title='Nuevo Número'>";
		// 	echo "<table  width='100%'><tr><td valign='middle' align='center'>";
		// 	echo "<img src='icon/nuevoNumero.png' >";
		// 	echo "</td>";
		// 	echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
		// 	echo "Nuevo Número";
		// 	echo "</td></tr></table>";
		// echo "</a>";

		// echo "<a href='#myModalaAgregar' rel='MyModal:open' class='btn-g2' title='Nuevo Número'>";
		// 	echo "<table  width='100%'><tr><td valign='middle' align='center'>";
		// 	echo "<img src='icon/nuevoNumero.png' >";
		// 	echo "</td>";
		// 	echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
		// 	// echo "Nuevo Número";
		// 	echo "</td></tr></table>";
		// echo "</a>";


		// echo "<a href='#docuementosRecientes' rel='MyModal:open' class='Mbtn btn-tercero' title='Documentos Recientes' style='font-family: Compacta;'>";
		// 	echo "<table  width='100%'><tr><td valign='middle' align='center'>";
		// 	echo "<img src='icon/docRecientes.png' >";
		// 	echo "</td>";
		// 	echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
		// 	echo "Documentos Recientes";
		// 	echo "</td></tr></table>";
		// echo "</a>";	

		// echo "<a href='#docuementosRecientes' rel='MyModal:open' class='btn-g3' title='Documentos Recientes' style='font-family: Compacta;'>";
		// 	echo "<table  width='100%'><tr><td valign='middle' align='center'>";
		// 	echo "<img src='icon/docRecientes.png' >";
		// 	echo "</td>";
		// 	echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
		// 	// echo "Documentos Recientes";
		// 	echo "</td></tr></table>";
		// echo "</a>";	
	}
}



if ($nivel==1 || soytitular($nitavu)<>'FALSE' )//{}//filtra solo titulares
{
//Si soy titular 
// echo "<a href='cp_permisos.php' class='Mbtn btn-tercero' title='Asignar permisos' style='font-family: Compacta;'>";
// 	echo "<table  width='100%'><tr><td valign='middle' align='center'>";
// 	echo "<img src='icon/docRecientes.png' >";
// 	echo "</td>";
// 	echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
// 	echo "Asignar Permisos";
// 	echo "</td></tr></table>";
// echo "</a>";	
// echo "</div>";
// echo "<br><br>";


echo "<a href='cp_permisos.php' class='btn-g4' title='Asignar permisos' style='font-family: Compacta;'>";
	echo "<table  width='100%'><tr><td valign='middle' align='center'>";
	echo "<img src='icon/user_add.png' >";
	echo "</td>";
	echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
	// echo "Asignar Permisos";
	echo "</td></tr></table>";
echo "</a>";	
echo "</div>";


}
 
//BOTONES MENU
/* echo "<section id='submenu'  style='text-align: center;width: 90%;'>";
submenu_add2('#documentoNew','req2.png','',' NUEVO CASO');
submenu_add2('#myaAgregar','req2.png','',' GENERAR NÚMERO');
submenu_add2('#docuementosRecientes','req2.png','',' DOCUMENTOS RECIENTES');
echo "</section>";   */
	
//DIV BUSQUEDA
//--------------------------------------------------------- margin-left:90%;
echo "<div style='text-align: right;'>";
echo "<a href='cp_miactividad.php?pes=finalizados' style='font-size:11pt;  align:center;  margin: 20px;'>Historial</a>";
echo "</div>";
echo "<div style='text-align: right;'><a href='tickets.php' style='text-align-last: start;  margin: 20px;font-size: 15px; margin-left:80%; '>Colaboraciones activas</a></div>";
echo "</div>";

echo "<div  style='width=90%; margin-top:15px;'>";
		if (isset($_GET['busqueda']))
		{ 
			$search = $_GET['busqueda'];
		} 
		else 
		{
			// echo "<label></label>";
			// buscar("cp_controldocumental.php","Buscar documento",'');
		}
		if (isset($_GET['busqueda']))
		{ 
			
			// ,case WHEN (dptoSube=".nitavu_dpto($nitavu).") THEN
			// 1
			// ELSE
			// 0
			// END AS 	ver
			// $sql = " -- cp 
			// SELECT distinct 
			// hd.nitavuSube Usuario,
			// (select nombre from empleados where nitavu=Usuario) as Nombre,
			// hd.numOficio AS NumEntrante, nvdoc.remite as Remitente,nvdoc.asunto as EAsunto,nvdoc.descripcion, nvdoc.fechaOficio,hd.NumCaso
			// FROM cp_nuevosdocumentos as nvdoc inner join cp_historialdocumentos as hd on nvdoc.id=hd.NumCaso and nvdoc.baja = 0
			// WHERE (nvdoc.asunto like '%".$search."%' or nvdoc.descripcion like '%".$search."%'  or  hd.numOficio  like '%".$search."%' or hd.NumCaso like '%".$search."%') group by hd.NumCaso";

			$sql = "		
				select * from tickets 
				WHERE descripcion like '%".$search."%' or EAsunto like '%".$search."%' or NumCaso like '%".$search."%'
			";

			historia($nitavu,"Busco ".$search." en Control Documental o Ticket");
			// echo $sql;
// echo "<br><br>";

			$r = $conexion -> query($sql);
			$r_count = $r -> num_rows;
			if ($r_count<=0)
			{ 
				historia($nitavu,'cp_Busqueda fallida de '.$search);
				$msg="Lo sentimos no se han encontrado resultados sobre <b>".$search."</b>";
				$msg = $msg." Vuelva a intentarlo utilizando otras palabras de busqueda";
				mensaje($msg,"cp_controldocumental.php");
			}
			else
			{
				/// PARA PAGINAR
				//Comprueba si está seteado el GET de HTTP
				if (isset($_GET["p"])) {
					//Si el GET de HTTP SÍ es una string / cadena, procede
					if (is_string($_GET["p"])) {
						//Si la string es numérica, define la variable 'pagina'
						if (is_numeric($_GET["p"])) {
							//Si la petición desde la paginación es la página uno
							//en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
								$pagina = $_GET["p"];
							
						} else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
							header("Location: ./index.php");
							die();
						};
					};
				} else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
					$pagina = 1;
				};
				//Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
				$empezar_desde = ($pagina-1) * $paginacion;
				// agregamos limite a la consulta
				$sql = $sql." LIMIT ".$empezar_desde.", ".$paginacion;
				// echo $sql;
				$r = $conexion -> query($sql);
				echo "<h4>Resultados ".$r_count. " sobre <b>[ ".$search." ]</b>, agrupados de ".$paginacion." </h4>";
				$paginas = intval(($r_count / $paginacion));
				historia($nitavu,'cp_Busqueda de '.$search);
	
				echo "<center><div id='peticiones' style='border: 0px; width:90%;'>";
				$cont=0;
				while($f = $r -> fetch_array())
				{ // resultado de la busqueda.................
				$cont=$cont+1;
				echo "<div id='resultado_elemento'  >";			 
				echo "<table border='0'>";
				echo "<tr>";										
								
						// DATOS OFICIO ENTRANTE
							echo "<td style=' width:10px; text-align: left;' class='tipo_menu'>";
						echo	"".$f['NumCaso'];
							echo " </td>";
						echo "<td width='90%' class='tipo_nitavu'>";								
						echo "<table border='0'>";
						echo "<tr>";							
						echo "<td>";
						echo "<span class='normal tmediano'>".$f['NumEntrante']."</span> por ".$f['Nombre'];
						echo "<span class='pc tchico'><br>Remitente: ".$f['Remitente']."    ".date_format( date_create($f['fechaOficio']), 'd/m/Y')." </span>";
						echo "<span class='pc tchico'><br>Descripción: ".$f['descripcion']."</span>";
						
						echo "</td>";
						echo "</tr>";
						echo "</table>";
						
						echo "</td>";	
						echo "<td style='text-align: right; width='10px;'  class='tipo_menu'>";

						//$arr = participoenElCasoYNivelUno($f['NumCaso']);
						$participeCaso = participeEnElCaso($nitavu,$f['NumCaso']);
						$dptoParticipo = soyDeUnDepartamentoQueParticipo($nitavu, $f['NumCaso']);
						

						$flag=0;
						//for ($i=0; $i < count($arr) ; $i++) {
							//echo $arr[$i];
							//if(soyColaborador_caso($f['NumCaso'],$nitavu)!='FALSE' || $nivel==1 || soytitular($nitavu)!='FALSE' ){
							//if( ($par =='TRUE' and $flag == 0) || (yoLoInicie($f['NumCaso'])==$nitavu and $flag == 0) || (soyColaborador_caso($f['NumCaso'],$nitavu)!='FALSE' and $flag == 0 )|| ($nivel == 1 and estaTurnadoami($f['NumCaso'])==nitavu_dpto($nitavu) and $flag == 0) || ($arr[$i]!=null and $arr[$i]==$nitavu and $flag == 0)){
							if( ($dptoParticipo =='TRUE' and $flag == 0 and $nivel==1) || (yoLoInicie($f['NumCaso'])==$nitavu and $flag == 0) || (soyColaborador_caso($f['NumCaso'],$nitavu)!='FALSE' and $flag == 0 )|| ($nivel == 1 and estaTurnadoami($f['NumCaso'])==nitavu_dpto($nitavu) and $flag == 0) || ($participeCaso=='TRUE' and $flag == 0)){
							//if( ($dptoParticipo =='TRUE' and $flag == 0) ){

								//echo $f['NumCaso'];
								//echo estaTurnadoami($f['NumCaso']);
								$flag = 1;
								
								echo "<a href='cp_nuevos_oficios.php?id=".$f['NumCaso']."'><img src='icon/entrar.png' class='icono' title='Ver Historial'></a>";
								
								
							} 
								echo "<td style='text-align: right; width='10px;'  class='tipo_menu'>";	
									echo "<img src='img/regreso.png' class='icono'>";					
								echo " </td>";
								
							//}
						//}
						
						
						echo " </td>";			
				echo "</tr></table>";
				echo "</div>";				
				}
							
				echo "</div>";
	
	if ($r_count >= $paginacion)
	{
	echo "<div id='barra_paginacion'>";
		echo "Paginas: ";
			//Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
			//Nota: X = $total_paginas
			for ($i=1; $i<=$paginas+1; $i++) {
				//En el bucle, muestra la paginación
				if ($pagina==$i)
				{
					echo "<span id='pagina_actual'>".$pagina."</span>"; //para el CSS span = a pagina actual
				}
				else
				{
				//	echo "<span id='pagina_proxima'><a href='?search=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
					echo "<span id='pagina_proxima'><a href='?busqueda=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
				}
			}
	echo "</div></center>";
	}
	}
}
// echo "<br><br>";
	//***Agrego form de busqueda
	echo "<form action='cp_nuevos_oficios.php' method='GET' style='
        padding: 10px;
        
        background-color: #ddc9a3;
        margin: 10px;
        margin-top:20px;
        border-radius: 5px;
    '>";
    echo "Si conoces el número de correspondencia<br> ";
    echo "<input type='text' class='' name='id' id='id' placeholder='' onChange='this.value=validar_numeros(this.value)' style='width:15%; height:30px;' required>";
    echo "<input type='submit' class='btn-identidad-color1' value='Abrir' style='width:10%; margin-top: 2px; margin-left: 10px;
    vertical-align: top;'>";
	

    echo "</form>";

	echo "<br><br>";

	//---------------------------------------------------------
	//DIV DE PETICIONES PENDIENTES	

	echo "<div id='peticiones'>";
	
	$dpto = nitavu_dpto($nitavu);
	// echo "<br><br>";
	if (soytitular($nitavu)!='FALSE' || $nivel==1 ){
		// $query = "SELECT * FROM cp_nuevosdocumentos WHERE turnadoa=".$dpto." and estado=0 and baja=0 ORDER BY prioridad DESC";
		
		$query = "SELECT count(*) as n FROM cp_nuevosdocumentos WHERE turnadoa=".$dpto." and estado=0 and baja=0";
		//echo $query;
		$rc2= $conexion -> query($query); 
		//Notice: Trying to get property 'num_rows' of non-object 
		if($f = $rc2 -> fetch_array()){
			$count = $f['n'];
		}

		if ($count>0)		
		{

			//*************aqui empieza a mostrar el listado de pantalla
			// $query = "SELECT 
			// fecha as FechaDesde,
			//  (SELECT DATEDIFF(CURDATE(),FechaDesde)) as Retraso,
			//  cp_nuevosdocumentos.* 
			//  FROM cp_nuevosdocumentos WHERE turnadoa=".$dpto." and estado=0 and baja=0 ORDER BY id ASC";
			//  echo $query;	
			$sql = "SELECT 
			fecha as FechaDesde,
			 (SELECT DATEDIFF(CURDATE(),FechaDesde)) as Retraso,
			 cp_nuevosdocumentos.* 
			 FROM cp_nuevosdocumentos WHERE turnadoa=".$dpto." and estado=0 and baja=0 ORDER BY id ASC";
			//$rc= $conexion -> query($query);
			// Usamos el COUNT ya calculado para evitar una consulta completa extra sin LIMIT.
			$r_count = (int)$count;


// PARA PAGINAR
        //Comprueba si está seteado el GET de HTTP
        if (isset($_GET["p"])) {
            //Si el GET de HTTP SÍ es una string / cadena, procede
            if (is_string($_GET["p"])) {
                //Si la string es numérica, define la variable 'pagina'
                if (is_numeric($_GET["p"])) {
                    //Si la petición desde la paginación es la página uno
                    //en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
                        $pagina = $_GET["p"];
                    
                } 
                else
                { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
                    header("Location: ./index.php");
                    die();
                };
            };
        } else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
            $pagina = 1;
        };
        //Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
        $empezar_desde = ($pagina-1) * $paginacion;
        // agregamos limite a la consulta
        $sql = $sql." LIMIT ".$empezar_desde.", ".$paginacion;
       // echo $sql;
 
        $paginas = intval(($r_count / $paginacion))+1;
           	// echo $paginas;
			// echo $r_count;
		



			echo "<table width=100%><tr><td>";
			echo "<center>";
			echo "<h1 style='color: darkred; font-size: 18px;'>Casos Nuevos y Pendientes de mi departamento:</h1>";
			
			echo "<div><table class='tabla' style='width:100%; font-family: verdana;'>";
			echo "<th width='10%' COLSPAN='2' style='text-align: center;'>Fecha</th>";
			echo "<th width='10%'>Oficio</th>";
			
			echo "<th width='60%'>Asunto</th>";
			// echo "<th width='20%'>Descripcion</th>";
			echo "<th style='text-align: center;' >Ver</th>";
			
			if (soytitular($nitavu)!='FALSE'){//filtra solo titulares
				echo "<th>VoBo</th>";
				echo "<th>Actividad</th>";
			}
			$rc= $conexion -> query($sql); 
			while($r = $rc -> fetch_array())    
			{
				$marcado = casoCompartidoCon($r['id']);
				if ($marcado > 0){
					echo "<tr >";
				} else {
					
					echo "<tr style='background-color:#7400ff; '>";

				}
			//if($r['prioridad']==1){
				//style='background-color:#DAFA9D;'
				// echo "<tr >";
				
				//Si aun no lo turno
				if (casoIsTurnado($r['id'])==TRUE){
					echo "<td  style='text-align: center;'><span style='background-color:gray; color:white;padding:5px; border-radius:50%;font-size:10pt'>".$r['id']."</span></td>";
				} else {
					echo "<td  style='text-align: center;' title='Aun no se ha turnado a un departamento para resolverse'><span title='Aun no se ha turnado a un departamento para resolverse' style='background-color:red; color:white;padding:5px; border-radius:50%;font-size:10pt'>".$r['id']."</span></td>";
				}
				
				


				echo "<td  style='text-align: center;'>".fecha_larga($r['fecha'])."<br>";
				
				if ($r['Retraso']>=0){
					if ($r['Retraso']>=5 and $r['Retraso']<=30){
						echo " <span class='pc tenue' style='font-size:9pt;  '><img src='icon/alerta_amarilla.png' style='width:15px;'>".$r['Retraso']." dias de atraso</span>";
					}
					if ($r['Retraso']>=31){
						echo " <span class='pc tenue' style='font-size:9pt; '><img src='icon/alerta_roja.png' style='width:15px;'>".$r['Retraso']." dias de atraso</span>";
					}
				}
				echo "<td style='width:10%;'>".$r['oficioNumero']."</td>";
				echo "<td><div id='cont1' style='width:100%;'><div id='contenidos1' style='width:100%;'><div id='columna1' style='width:90%;'><b>".$r['asunto']."</b><span style='font-size:7pt'><br>".$r['descripcion']."</span><br>
				<span style='color:blue;'>Creado por: ".nombreDepartamento($r['idDptoCrea'])."</span>";
				// echo "<td>".$r['asunto']."</td>";
				// echo "<td>".$r['descripcion']."<br>";
				$fech = marcadaconVistoBueno($r['id'],$nitavu);
				$tit = titular(nitavu_dpto($nitavu));				
				$vo = miTitularDioVistobueno($r['id'],$tit);
				
				if( ($fech <> "" || $vo <> "") && $tit<>"" ){
					$quien = quienDioVistoBueno($r['id'],$tit);
					//<img src='icon/ok.png' style='width:18px;'>
					echo "<label style='font-size:8pt;'>VoBo por ".nitavu_nombre($quien).".</label>";
				}		

				$personas = casoCompartidoCon($r['id']);
				
				if($personas>0){
					echo "<label style='font-size:8pt;'>Compartido con:<br>";
					for($k=0; $k < sizeof($personas); $k++){
				
						if($personas[$k]<>""){
								echo nitavu_nombre($personas[$k]);
								if(subioArchivos($r['id'],$personas[$k])=='TRUE'){
									echo "<img src='icon/ok.png' style='width:10px;'>";
								}
								echo "<br>";
						}
					}
				} else {
					
				}
				
				echo "</label>";
				// if(esHoyElDiadeVencimiento($r['id'])=='TRUE'){
				// 	echo "<label style='font-size:8pt; color:white; background-color:red; font-family:verdana;'>HOY ES LA FECHA DE VENCIMIENTO DE ESTE CASO.</label>";
				// }else if(seVencioYnohaFinalizado($r['id'])=='TRUE'){
				// 	echo "<label style='font-size:8pt; color:white; background-color:red; font-family:verdana;'></label>";
				// }
				echo "</div>";

				// if(tieneFechaTermino($r['id'])<>'FALSE'){
				// 	echo '<div id="columna2" align="center" style="vertical-align: middle; padding-top: 8px;" title="Vence el '.FechaTermino($r['id']).'">';
				// 		$dias = diasFaltantesParaTermino($r['id']);
				// 		DiasFaltantes('g'.$r['id'],$dias);

				// 	echo "</div>";
				// }

				//PUEDO EDITAR SOLO SI YO CREE EL CASO
				if($r['nitavuCaptura']==$nitavu){
					echo "<div id='columna3' style='vertical-align: middle; width:5%;'><center><a href='#modalEditarCaso".$r['id']."' rel='MyModal:open'><img id='imgcentrada' src='./icon/edit.png' style='width:15px;'></a></center></div></div></div>"	;
				}
				//MODAL EDITAR INFORMACION---------------------------------------------------------------------- 
				echo "<div id='modalEditarCaso".$r['id']."' class='MyModal'><h3>Modificar información del oficio: </h3>";
				echo "<form action='cp_controldocumental.php?editar=".$r['id']."' method='POST'  enctype='multipart/form-data'>";
				 	//echo '<table><td><label><input type="checkbox" id="turnar" name="turnar" value="turnar" onClick="mostrarDepartamento()">Turnar</label></td><td></td><td></td></table>';

					$res4 = $r;
					if($res4['fecha_termino']!='0000-00-00'){
						echo '<center>
						<label><input type="checkbox" id="fechaTer'.$r['id'].'" name="fechaTer'.$r['id'].'" value="fechaTer'.$r['id'].'" onClick="quitarFechaTermino('.$r['id'].')">Fecha termino</label></center>';
						}else{
							echo '<center>
							<label><input type="checkbox" id="fechaTer'.$r['id'].'" name="fechaTer'.$r['id'].'" value="fechaTer'.$r['id'].'" onClick="mostrarFechaTerminoModal('.$r['id'].')">Fecha termino</label></center>';
								 
						}
						echo '<div><table style="width: 100%">
									<tr>
										<td align=right> <label>Fecha del Oficio (*)</label> <input type="date" id="fechaOficio" name="fechaOficio" value='.$res4['fechaOficio'].' required>  </td>
										<td align=left>     </td>
										<td align=right>  <label>Fecha actual (*) </label>  <input   style="background-color:#CCCCCC;" type="date" id="fecha" name="fecha" value='.$res4['fecha'].' required>  </td>
										<td align=left>  </td>
									</tr>
								</table></div>';
						if($res4['fecha_termino']!='0000-00-00'){
							echo "<div id='divfechaTermino".$r['id']."' style='display:inline-block;'>";
								echo "<label>Fecha término </label>  <input type='date' id='fechaTermino".$r['id']."' name='fechaTermino' value=".$res4['fecha_termino'].">";
							echo "</div>";
						}else{
							echo "<div id='divfechaTermino".$r['id']."' style='display:none;'>";
								echo "<label>Fecha término </label>  <input type='date' id='fechaTermino' name='fechaTermino' >";
							echo "</div>";
						}
				
						echo '<div><label>Referencia</label>';
						echo '<input style="background-color:#FF9933;" id="ofnumero" name="ofnumero"  value="'.$res4['oficioNumero'].'"  title="Numero consecutivo de oficios de atencion al publico"/></div>';
					/*	echo '<div><label>Prioridad</label>';
						echo '<select id="prioridad" name="prioridad" required>';
							//<option value="">Seleccione una prioridad</option>
							if($res4['prioridad']==1){
								echo "<option value='1' selected>Baja</option>";
								echo "<option value='2' >Media</option>";
								echo "<option value='3' >Alta</option>";
							}else if($res4['prioridad']==2){
								echo "<option value='1' >Baja</option>";
								echo "<option value='2' selected>Media</option>";
								echo "<option value='3' >Alta</option>";
							}else if($res4['prioridad']==3){
								echo "<option value='1'>Baja</option>";
								echo "<option value='2'>Media</option>";
								echo "<option value='3' selected>Alta</option>";
							
							}else{
								echo " <option value='1'>Baja</option>";
								echo " <option value='2'>Media</option>";
								echo " <option value='3' >Alta</option>";
							}
						echo "</select></div>";*/
						//echo '<div>';	
						echo '<div><label>Remite</label>';
						echo '<input placeholder="Remite" id="remite" name="remite" value="'.$res4['remite'].'"></div>';
						echo '<div><label>Puesto</label>';
						echo '<input placeholder="Puesto" id="puesto" name="puesto" value="'.$res4['puesto'].'"></div>';
						echo '<div><label>Dependencia</label>';
						echo '<input placeholder="Dependencia" id="dependencia" name="dependencia" value="'.$res4['dependencia'].'"></div>';
						echo '<div><label> Asunto (*)</label>';
						echo '<input placeholder="Asunto" name="asunto" value="'.$res4['asunto'].'" required></div>';		
						//echo '</div><br>'	
						echo '<div><span><label> Descripción </label>';
						echo '<textarea style="height:20%;" name="descripcion">'.$res4['descripcion'].'</textarea></span></div>';
						//   echo '<br><br>'; 
						echo '<div><input class="Mbtn btn-danger" id="boton" type="submit" value="Guardar"></div>';

					echo '</form>';
					echo "</div>";
			//---------------------------------------------------------------------------------------------------	


				echo "</td>";
				echo "<td>";
				echo '<center><div id="cont2">
				<div id="contenidos2">
					<center>
				  <div id="colum1">';
					echo "<form action='cp_nuevos_oficios.php' method='GET'>";
					echo "<input type='hidden' value=".$r['id']." name='id'>";
					echo "<input type='hidden' name='txtplus' value=1>";
					echo "<input type='hidden' name='pv' value=1>";
					echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para ver el historial del archivo' onclick=''> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </button>"; 
					echo "</form>";
				echo '</div>';
			
				if($r['nitavuCaptura']==$nitavu){
					echo '<div id="colum2">';
						echo "<form action='cp_controldocumental.php' method='POST'>";
						echo "<input type='hidden' value=".$r['id']." id='darBaja' name='darBaja'>";
						echo "<button type='submit' class='Mbtn btn-cancel' title='Haga clic para eliminar el caso' onclick=''> <img src='icon/delete.png' style='width:20px; height:20px;'> </button>"; 
						echo "</form>";
					echo '</div>';
				}
				echo '</center></div></div></center>';
				echo "</td>";
				if (soytitular($nitavu)!='FALSE'  && $fech==""){//filtra solo titulares
				echo "<td>";
				echo "<form action='cp_controldocumental.php' method='GET'>";
				echo "<input type='hidden' value=".$r['id']." name='vobo1'>";
				echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para dar el visto bueno' onclick=''> <img src='icon/ok.png' style='width:20px; height:20px;'> </button>"; 
				echo "</form>";
				echo "</td>";
				echo "<td>";
					
					echo "<center><p style='font-size:20pt; color:#6F7070; '>".actividaddelCaso($r['id'])."</p></center>";
				echo "</td>";
				}else if(soytitular($nitavu)!='FALSE'  && $fech<>""){
					echo "<td><center><img src='icon/ok.png' style='width:30px;'></center>";
					echo "</td>";
					echo "<td>";
					echo "<center><p style='font-size:20pt; color:#6F7070; '>".actividaddelCaso($r['id'])."</p></center>";
				echo "</td>";	
				}

				/*if(tieneFechaTermino($r['id'])<>'FALSE'){
					echo "<td>";
						$dias = diasFaltantesParaTermino($r['id']);
						DiasFaltantes('g'.$r['id'],$dias);

					echo "</td>";
				}*/
				
				
				echo "</tr>";
		/*	}else if($r['prioridad']==2){
				echo "<tr style='background-color:#FCDCBC;'>";
				// echo "<td  style='text-align: center;'>".$r['id']."</td>";
				echo "<td  style='text-align: center;'><span style='background-color:gray; color:white;padding:5px; border-radius:50%;font-size:10pt'>".$r['id']."</span></td>";
				echo "<td  style='text-align: center;'>".fecha_larga($r['fecha'])."<br>";
				
				if ($r['Retraso']>=0){
					if ($r['Retraso']>=5 and $r['Retraso']<=30){
						echo " <span class='pc tenue' style='font-size:9pt;  '><img src='icon/alerta_amarilla.png' style='width:15px;'>".$r['Retraso']." dias de atraso</span>";
					}
					if ($r['Retraso']>=31){
						echo " <span class='pc tenue' style='font-size:9pt; '><img src='icon/alerta_roja.png' style='width:15px;'>".$r['Retraso']." dias de atraso</span>";
					}
				}
				echo "</td>";
				
				echo "<td><table><td style='border-top-style:none;'><b>".$r['asunto']."</b><span style='font-size:7pt'><br>".$r['descripcion']."</span>";
				// echo "<td>".$r['descripcion']."<br>";
				$fech = marcadaconVistoBueno($r['id'],$nitavu);
				$tit = titular(nitavu_dpto($nitavu));
				$vo = miTitularDioVistobueno($r['id'],$tit);
				if( ($fech <> "" || $vo <> "") && $tit<>"" ){
					$quien = quienDioVistoBueno($r['id'],$tit);
					//<img src='icon/ok.png' style='width:18px;'>
					echo "<label style='font-size:8pt;'>VoBo por ".nitavu_nombre($quien).".</label>";
				}		
				
				$personas = casoCompartidoCon($r['id']);
				if($personas>0){
					echo "<label style='font-size:8pt;'>Compartido con:<br>";
					for($k=0; $k < sizeof($personas); $k++){
				
						if($personas[$k]<>""){
								
								echo nitavu_nombre($personas[$k]);
								if(subioArchivos($r['id'],$personas[$k])=='TRUE'){
									echo "<img src='icon/ok.png' style='width:10px;'>";
								}
								echo "<br>";
						}
					}
				}
				
				echo "</label>";
				// if(esHoyElDiadeVencimiento($r['id'])=='TRUE'){
				// 	echo "<label style='font-size:8pt; color:red;'><b>HOY es la fecha de vencimiento de este caso.</b></label>";
				// }else if(seVencioYnohaFinalizado($r['id'])=='TRUE'){
				// 	echo "<label style='font-size:8pt; color:red;'><b>Este caso esta vencido. Favor de finalizarlo.</b></label>";
				// }
				echo "</td>";
				echo "<td style='width:20px; border-top-style: none; '><center><a href='#modalEditarCaso".$r['id']."' rel='MyModal:open'><img src='./icon/edit.png' style='width:15px;'></center></a></td></table>"	;
			
			//MODAL EDITAR INFORMACION---------------------------------------------------------------------- 
				echo "<div id='modalEditarCaso".$r['id']."' class='MyModal'><h3>Modificar información del oficio: </h3>";
				echo "<form action='cp_controldocumental.php?editar=".$r['id']."' method='POST'>";
			 
					//	echo '<table><td><label><input type="checkbox" id="turnar" name="turnar" value="turnar" onClick="mostrarDepartamento()">Turnar</label></td><td></td><td></td></table>';

					$res5 = $r;
					if($res5['fecha_termino']!='0000-00-00'){
							echo '<center>
							<label><input type="checkbox" id="fechaTer'.$r['id'].'" name="fechaTer'.$r['id'].'" value="fechaTer'.$r['id'].'" onClick="quitarFechaTermino('.$r['id'].')">Fecha termino</label></center>';
							}else{
								echo '<center>
								<label><input type="checkbox" id="fechaTer'.$r['id'].'" name="fechaTer'.$r['id'].'" value="fechaTer'.$r['id'].'" onClick="mostrarFechaTerminoModal('.$r['id'].')">Fecha termino</label></center>';	 
							}
						echo '<div><table style="width: 100%">
						<tr>
						<td align=right> <label>Fecha del Oficio (*)</label> <input type="date" id="fechaOficio" name="fechaOficio" value='.$res5['fechaOficio'].' required>  </td>
						<td align=left>     </td>
						<td align=right>  <label>Fecha actual (*) </label>  <input   style="background-color:#CCCCCC;" type="date" id="fecha" name="fecha" value='.$res5['fecha'].' required>  </td>
						<td align=left>  </td>
						</tr>
			</table></div>';

			if($res5['fecha_termino']!='0000-00-00'){
				echo "<div id='divfechaTermino".$r['id']."' style='display:inline-block;'>";
					echo "<label>Fecha termino </label>  <input type='date' id='fechaTermino".$r['id']."' name='fechaTermino' value=".$res5['fecha_termino'].">";
				echo "</div>";
			}else{
				echo "<div id='divfechaTermino".$r['id']."' style='display:none;'>";
					echo "<label>Fecha termino </label>  <input type='date' id='fechaTermino' name='fechaTermino'>";
				echo "</div>";
			}
				
						echo '<div><label>Referencia</label>';
						echo '<input style="background-color:#FF9933;" id="ofnumero" name="ofnumero"  value="'.$res5['oficioNumero'].'"  title="Numero consecutivo de oficios de atencion al publico"/></div>';
						echo '<div><label>Prioridad</label>';
						echo '<select id="prioridad" name="prioridad" required>';
							//<option value="">Seleccione una prioridad</option>
							if($res5['prioridad']==1){
								echo "<option value='1' selected>Baja</option>";
								echo "<option value='2' >Media</option>";
								echo "<option value='3' >Alta</option>";
							}else if($res5['prioridad']==2){
								echo "<option value='1' >Baja</option>";
								echo "<option value='2' selected>Media</option>";
								echo "<option value='3' >Alta</option>";
							}else if($res5['prioridad']==3){
								echo "<option value='1'>Baja</option>";
								echo "<option value='2'>Media</option>";
								echo "<option value='3' selected>Alta</option>";
							
							}else{
								echo " <option value='1'>Baja</option>";
								echo " <option value='2'>Media</option>";
								echo " <option value='3' >Alta</option>";
							}
						echo "</select></div>";

						echo '<div><label>Remite</label>';
						echo '<input placeholder="Remite" id="remite" name="remite" value="'.$res5['remite'].'"></div>';
						echo '<div><label>Puesto</label>';
						echo '<input placeholder="Puesto" id="puesto" name="puesto" value="'.$res5['puesto'].'"></div>';
						echo '<div><label>Dependencia</label>';
						echo '<input placeholder="Dependencia" id="dependencia" name="dependencia" value="'.$res5['dependencia'].'"></div>';
						echo '<div><label> Asunto (*)</label>';
						echo '<input placeholder="Asunto" name="asunto" value="'.$res5['asunto'].'" required></div>';		
				
						echo '<span><label> Descripcion </label>';
						echo '<textarea style="height:20%;" name="descripcion">'.$res5['descripcion'].'</textarea></span>';
						//   echo '<br><br>'; 
						echo '<div><input class="Mbtn btn-default" id="boton" type="submit" value="Guardar"></div>';
					}
					echo '</form>';
					echo "</div>";
			//---------------------------------------------------------------------------------------------------	
						
				echo "<td>";
				echo "<table><td style=' border-top: none; '>";
				echo "<form action='cp_nuevos_oficios.php' method='GET'>";
				echo "<input type='hidden' value=".$r['id']." name='id'>";
				echo "<input type='hidden' name='txtplus' value=1>";
				echo "<input type='hidden' name='pv' value=1>";
				echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para ver el historial del archivo' onclick=''> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </button>"; 
				echo "</form>";
				echo "</td>";
				if($r['nitavuCaptura']==$nitavu){
					// style='width:40px;'
					echo "<td style=' border-top: none; '>";
						echo "<form action='cp_controldocumental.php' method='POST'>";
						echo "<input type='hidden' value=".$r['id']." id='darBaja' name='darBaja'>";
						echo "<button type='submit' class='Mbtn btn-cancel' title='Haga clic para eliminar el caso' onclick=''> <img src='icon/delete.png' style='width:20px; height:20px;'> </button>"; 
						echo "</form>";
					echo "</td>";
				}
				echo "</table>";
				echo "</td>";
				if (soytitular($nitavu)!='FALSE' && $fech==""){//filtra solo titulares
				echo "<td>";
				echo "<form action='cp_controldocumental.php' method='GET'>";
				echo "<input type='hidden' value=".$r['id']." name='vobo2'>";
				echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para dar el visto bueno' onclick=''> <img src='icon/ok.png' style='width:20px; height:20px;'> </button>"; 
				echo "</form>";
				echo "</td>";
				echo "<td>";
					echo "<center><p style='font-size:20pt; color:#6F7070; '>".actividaddelCaso($r['id'])."</p></center>";
				echo "</td>";
				}else if(soytitular($nitavu)!='FALSE'  && $fech<>""){
					echo "<td><center><img src='icon/ok.png' style='width:30px;'></center>";
					echo "</td>";	
					echo "<td>";
					echo "<center><p style='font-size:20pt; color:#6F7070; '>".actividaddelCaso($r['id'])."</p></center>";
				echo "</td>";
				}
			/*	if($r['nitavuCaptura']==$nitavu){
					echo "<td style='width:40px;'>";
						echo "<form action='cp_controldocumental.php' method='POST'>";
						echo "<input type='hidden' value=".$r['id']." id='darBaja' name='darBaja'>";
						echo "<button type='submit' class='Mbtn btn-cancel' title='Haga clic para eliminar el caso' onclick=''> <img src='icon/delete.png' style='width:20px; height:20px;'> </button>"; 
						echo "</form>";
					echo "</td>";
				}
				echo "</tr>";
			}else if($r['prioridad']==3){
				echo "<tr style='background-color:#FAC7C7;'>";
				// echo "<td  style='text-align: center;'>".$r['id']."</td>";
				echo "<td  style='text-align: center;'><span style='background-color:gray; color:white;padding:5px; border-radius:50%;font-size:10pt'>".$r['id']."</span></td>";
				echo "<td  style='text-align: center;'>".fecha_larga($r['fecha'])."<br>";
				
				// if ($r['Retraso']>=0){
				// 	if ($r['Retraso']>=5 and $r['Retraso']<=30){
				// 		echo " <span class='pc tenue' style='font-size:9pt;  '><img src='icon/alerta_amarilla.png' style='width:15px;'>".$r['Retraso']." dias de atraso</span>";
				// 	}
				// 	if ($r['Retraso']>=31){
				// 		echo " <span class='pc tenue' style='font-size:9pt; '><img src='icon/alerta_roja.png' style='width:15px;'>".$r['Retraso']." dias de atraso</span>";
				// 	}
				// }
				
				
				echo "<td><table><td style='border-top-style:none;'><b>".$r['asunto']."</b><span style='font-size:7pt'><br>".$r['descripcion']."</span>";
				// echo "<td>".$r['descripcion']."<br>";
				$fech = marcadaconVistoBueno($r['id'],$nitavu);
				$tit = titular(nitavu_dpto($nitavu));
				$vo = miTitularDioVistobueno($r['id'],$tit);
				if( ($fech <> "" || $vo <> "")&& $tit<>"" ){
					$quien = quienDioVistoBueno($r['id'],$tit);
					//<img src='icon/ok.png' style='width:18px;'>
					echo "<label style='font-size:8pt;'>VoBo por ".nitavu_nombre($quien).".</label>";
				}		

				$personas = casoCompartidoCon($r['id']);
				
				if($personas>0){
					echo "<label style='font-size:8pt;'>Compartido con:<br>";
					for($k=0; $k < sizeof($personas); $k++){
						if($personas[$k]<>""){
								
								echo nitavu_nombre($personas[$k]);
								if(subioArchivos($r['id'],$personas[$k])=='TRUE'){
									echo "<img src='icon/ok.png' style='width:10px;'>";
								}
								echo "<br>";
						}
						
					}
				}
				
				echo "</label>";
				if(esHoyElDiadeVencimiento($r['id'])=='TRUE'){
					echo "<label style='font-size:8pt; color:red;'><b>HOY es la fecha de vencimiento de este caso.</b></label>";
				}else if(seVencioYnohaFinalizado($r['id'])=='TRUE'){
					echo "<label style='font-size:8pt; color:red;'><b>Este caso esta vencido. Favor de finalizarlo.</b></label>";
				}
				echo "</td>";
				echo "<td style='width:20px; border-top-style: none; '><center><a href='#modalEditarCaso".$r['id']."' rel='MyModal:open'><img src='./icon/edit.png' style='width:15px;'></center></a></td></table>"	;
				

				//MODAL EDITAR INFORMACION---------------------------------------------------------------------- 
				echo "<div id='modalEditarCaso".$r['id']."' class='MyModal'><h3>Modificar información del oficio: </h3>";
				echo "<form action='cp_controldocumental.php?editar=".$r['id']."' method='POST'  enctype='multipart/form-data'>";
	
			//	echo '<table><td><label><input type="checkbox" id="turnar" name="turnar" value="turnar" onClick="mostrarDepartamento()">Turnar</label></td><td></td><td></td></table>';

					$res6 = $r;
					if($res6['fecha_termino']!='0000-00-00'){
							echo '<center>
							<label><input type="checkbox" id="fechaTer'.$r['id'].'" name="fechaTer'.$r['id'].'" value="fechaTer'.$r['id'].'" onClick="quitarFechaTermino('.$r['id'].')">Fecha termino</label></center>';
							}else{
								echo '<center>
								<label><input type="checkbox" id="fechaTer'.$r['id'].'" name="fechaTer'.$r['id'].'" value="fechaTer'.$r['id'].'" onClick="mostrarFechaTerminoModal('.$r['id'].')">Fecha termino</label></center>';	 
							}
						echo '<div><table style="width: 100%">
						<tr>
						<td align=right> <label>Fecha del Oficio (*)</label> <input type="date" id="fechaOficio" name="fechaOficio" value='.$res6['fechaOficio'].' required>  </td>
						<td align=left>     </td>
						<td align=right>  <label>Fecha actual (*) </label>  <input   style="background-color:#CCCCCC;" type="date" id="fecha" name="fecha" value='.$res6['fecha'].' required>  </td>
						<td align=left>  </td>
						</tr>
			</table></div>';
				
			if($res6['fecha_termino']!='0000-00-00'){
				echo "<div id='divfechaTermino".$r['id']."' style='display:inline-block;'>";
					echo "<label>Fecha termino </label>  <input type='date' id='fechaTermino".$r['id']."' name='fechaTermino' value=".$res6['fecha_termino'].">";
				echo "</div>";
			}else{
				echo "<div id='divfechaTermino".$r['id']."' style='display:none;'>";
					echo "<label>Fecha termino </label>  <input type='date' id='fechaTermino' name='fechaTermino' >";
				echo "</div>";
			}
						echo '<div><label>Referencia</label>';
						echo '<input style="background-color:#FF9933;" id="ofnumero" name="ofnumero"  value="'.$res6['oficioNumero'].'"  title="Numero consecutivo de oficios de atencion al publico"/></div>';
						echo '<div><label>Prioridad</label>';
						echo '<select id="prioridad" name="prioridad" required>';
							//<option value="">Seleccione una prioridad</option>
							if($res6['prioridad']==1){
								echo "<option value='1' selected>Baja</option>";
								echo "<option value='2' >Media</option>";
								echo "<option value='3' >Alta</option>";
							}else if($res6['prioridad']==2){
								echo "<option value='1' >Baja</option>";
								echo "<option value='2' selected>Media</option>";
								echo "<option value='3' >Alta</option>";
							}else if($res6['prioridad']==3){
								echo "<option value='1'>Baja</option>";
								echo "<option value='2'>Media</option>";
								echo "<option value='3' selected>Alta</option>";
							
							}else{
								echo " <option value='1'>Baja</option>";
								echo " <option value='2'>Media</option>";
								echo " <option value='3' >Alta</option>";
							}
						echo "</select></div>";

						echo '<div><label>Remite</label>';
						echo '<input placeholder="Remite" id="remite" name="remite" value="'.$res6['remite'].'"></div>';
						echo '<div><label>Puesto</label>';
						echo '<input placeholder="Puesto" id="puesto" name="puesto" value="'.$res6['puesto'].'"></div>';
						echo '<div><label>Dependencia</label>';
						echo '<input placeholder="Dependencia" id="dependencia" name="dependencia" value="'.$res6['dependencia'].'"></div>';
						echo '<div><label> Asunto (*)</label>';
						echo '<input placeholder="Asunto" name="asunto" value="'.$res6['asunto'].'" required></div>';		
				
						echo '<span><label> Descripcion </label>';
						echo '<textarea style="height:20%;" name="descripcion">'.$res6['descripcion'].'</textarea></span>';
						//   echo '<br><br>'; 
						echo '<div><input class="Mbtn btn-default" id="boton" type="submit" value="Guardar"></div>';

					echo '</form>';
					echo "</div>";
			//---------------------------------------------------------------------------------------------------	
						

				echo "</td>";
				echo "<td>";
				echo "<table><td style=' border-top: none; '>";
				echo "<form action='cp_nuevos_oficios.php' method='GET'>";
				echo "<input type='hidden' value=".$r['id']." name='id'>";
				echo "<input type='hidden' name='txtplus' value=1>";
				echo "<input type='hidden' name='pv' value=1>";
				echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para ver el historial del archivo' onclick=''> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </button>"; 
				echo "</form>";
				echo "</td>";
				if($r['nitavuCaptura']==$nitavu){
					echo "<td style=' border-top: none; '>";
						echo "<form action='cp_controldocumental.php' method='POST'>";
						echo "<input type='hidden' value=".$r['id']." id='darBaja' name='darBaja'>";
						echo "<button type='submit' class='Mbtn btn-cancel' title='Haga clic para eliminar el caso' onclick=''> <img src='icon/delete.png' style='width:20px; height:20px;'> </button>"; 
						echo "</form>";
					echo "</td>";
				}
				echo "</table>";
				echo "</td>";
				if (soytitular($nitavu)!='FALSE'  && $fech==""){//filtra solo titulares
				echo "<td>";
				echo "<form action='cp_controldocumental.php' method='GET'>";
				echo "<input type='hidden' value=".$r['id']." name='vobo3'>";
				echo "<button name='vobo' type='submit' class='Mbtn btn-default' title='Haga clic para dar el visto bueno' onclick='deshabilitar()'> <img src='icon/ok.png' style='width:20px; height:20px;'> </button>"; 
				echo "</form>";
				echo "</td>";
				echo "<td>";
					echo "<center><p style='font-size:20pt; color:#6F7070; '>".actividaddelCaso($r['id'])."</p></center>";
				echo "</td>";
				}else if(soytitular($nitavu)!='FALSE'  && $fech<>""){
					echo "<td><center><img src='icon/ok.png' style='width:30px;'></center>";
					echo "</td>";	
					echo "<td>";
					echo "<center><p style='font-size:20pt; color:#6F7070; '>".actividaddelCaso($r['id'])."</p></center>";
				echo "</td>";
				}
			/*	if($r['nitavuCaptura']==$nitavu){
					echo "<td style='width:40px;'>";
						echo "<form action='cp_controldocumental.php' method='POST'>";
						echo "<input type='hidden' value=".$r['id']." id='darBaja' name='darBaja'>";
						echo "<button type='submit' class='Mbtn btn-cancel' title='Haga clic para eliminar el caso' onclick=''> <img src='icon/delete.png' style='width:20px; height:20px;'> </button>"; 
						echo "</form>";
					echo "</td>";
				}
				echo "</tr>";
			}*/
		}
			echo "</table>";
			echo "</div></center></td>";


			echo "</tr></table>";

			if ($r_count >= $paginacion)
        {
            echo "<center><div id='barra_paginacion'>";
                echo "Paginas: ";
                    //Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
                    //Nota: X = $total_paginas
                    for ($i=1; $i<=$paginas; $i++) 
                    {
                        //En el bucle, muestra la paginación
                        if ($pagina==$i)
                        {
                            echo "<span id='pagina_actual'>".$pagina."</span>";
                        
                                 //para el CSS span = a pagina actual
                        }
                        else
                        {
                            echo "<span id='pagina_proxima'><a href='?p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
                        }
                    }
                
            echo "</div></center>";

        }
		
		/******empiezan los en proceso de atención*/
		

		echo "<h1 style='color: darkred; font-size: 18px;'>Casos en proceso de atención<h1>";

			
			$query = "SELECT 
			fecha as FechaDesde,
			 (SELECT DATEDIFF(CURDATE(),FechaDesde)) as Retraso,
			 cp_nuevosdocumentos.* 
			 FROM cp_nuevosdocumentos WHERE turnadoa=".$dpto." and estado=2 and baja=0 ORDER BY id ASC";
			//  echo $query;	
			$rca= $conexion -> query($query); 		
			echo "<table width=100%><tr><td>";
			echo "<center>";
			//echo "<h1 style='color: darkred;'>Casos Nuevos y Pendientes de mi departamento:</h1>";
			
			echo "<div><table class='tabla' style='width:100%; font-family: verdana;'>";
			echo "<th width='10%' COLSPAN='2' style='text-align: center;'>Fecha</th>";
			echo "<th width='10%'>Oficio</th>";

			echo "<th width='70%'>Asunto</th>";
			// echo "<th width='20%'>Descripcion</th>";
			echo "<th style='text-align: center;' >Ver</th>";
			
			if (soytitular($nitavu)!='FALSE'){//filtra solo titulares
				echo "<th>VoBo</th>";
				echo "<th>Actividad</th>";
			}
			while($ra = $rca -> fetch_array())    
			{
				$marcado = casoCompartidoCon($ra['id']);
				if ($marcado > 0){
					echo "<tr >";
				} else {
					
					echo "<tr style='background-color:#7400ff; '>";

				}
			
				//Si aun no lo turno
				if (casoIsTurnado($ra['id'])==TRUE){
					echo "<td  style='text-align: center;'><span style='background-color:gray; color:white;padding:5px; border-radius:50%;font-size:10pt'>".$ra['id']."</span></td>";
				} else {
					echo "<td  style='text-align: center;' title='Aun no se ha turnado a un departamento para resolverse'><span title='Aun no se ha turnado a un departamento para resolverse' style='background-color:red; color:white;padding:5px; border-radius:50%;font-size:10pt'>".$ra['id']."</span></td>";
				}
				
				


				echo "<td  style='text-align: center;'>".fecha_larga($ra['fecha'])."<br>";
				
				if ($ra['Retraso']>=0){
					if ($ra['Retraso']>=5 and $ra['Retraso']<=30){
						echo " <span class='pc tenue' style='font-size:9pt;  '><img src='icon/alerta_amarilla.png' style='width:15px;'>".$ra['Retraso']." dias de atraso</span>";
					}
					if ($ra['Retraso']>=31){
						echo " <span class='pc tenue' style='font-size:9pt; '><img src='icon/alerta_roja.png' style='width:15px;'>".$ra['Retraso']." dias de atraso</span>";
					}
				}
				echo "<td style='width:10%;'>".$ra['oficioNumero']."</td>";
				echo "<td><div id='cont1' style='width:100%;'><div id='contenidos1' style='width:100%;'><div id='columna1' style='width:90%;'><b>".$ra['asunto']."</b><span style='font-size:7pt'><br>".$ra['descripcion']."</span><br>
				<span style='color:blue;'>Creado por: ".nombreDepartamento($ra['idDptoCrea'])."</span>";
				
				$fech = marcadaconVistoBueno($ra['id'],$nitavu);
				$tit = titular(nitavu_dpto($nitavu));				
				$vo = miTitularDioVistobueno($ra['id'],$tit);
				
				if( ($fech <> "" || $vo <> "") && $tit<>"" ){
					$quien = quienDioVistoBueno($ra['id'],$tit);
					//<img src='icon/ok.png' style='width:18px;'>
					echo "<label style='font-size:8pt;'>VoBo por ".nitavu_nombre($quien).".</label>";
				}		

				$personas = casoCompartidoCon($ra['id']);
				
				if($personas>0){
					echo "<label style='font-size:8pt;'>Compartido con:<br>";
					for($k=0; $k < sizeof($personas); $k++){
				
						if($personas[$k]<>""){
								echo nitavu_nombre($personas[$k]);
								if(subioArchivos($ra['id'],$personas[$k])=='TRUE'){
									echo "<img src='icon/ok.png' style='width:10px;'>";
								}
								echo "<br>";
						}
					}
				} else {
					
				}				
				echo "</label>";				
				echo "</div>";				

				//PUEDO EDITAR SOLO SI YO CREE EL CASO
				if($ra['nitavuCaptura']==$nitavu){
					echo "<div id='columna3' style='vertical-align: middle; width:5%;'><center><a href='#modalEditarCaso".$ra['id']."' rel='MyModal:open'><img id='imgcentrada' src='./icon/edit.png' style='width:15px;'></a></center></div></div></div>"	;
				}
				//MODAL EDITAR INFORMACION---------------------------------------------------------------------- 
				echo "<div id='modalEditarCaso".$ra['id']."' class='MyModal'><h3>Modificar información del oficio: </h3>";
				echo "<form action='cp_controldocumental.php?editar=".$ra['id']."' method='POST'  enctype='multipart/form-data'>";
				 	//echo '<table><td><label><input type="checkbox" id="turnar" name="turnar" value="turnar" onClick="mostrarDepartamento()">Turnar</label></td><td></td><td></td></table>';

					$res4 = $ra;
					if($res4['fecha_termino']!='0000-00-00'){
						echo '<center>
						<label><input type="checkbox" id="fechaTer'.$ra['id'].'" name="fechaTer'.$ra['id'].'" value="fechaTer'.$ra['id'].'" onClick="quitarFechaTermino('.$ra['id'].')">Fecha termino</label></center>';
						}else{
							echo '<center>
							<label><input type="checkbox" id="fechaTer'.$ra['id'].'" name="fechaTer'.$ra['id'].'" value="fechaTer'.$ra['id'].'" onClick="mostrarFechaTerminoModal('.$ra['id'].')">Fecha termino</label></center>';
								 
						}
						echo '<div><table style="width: 100%">
									<tr>
										<td align=right> <label>Fecha del Oficio (*)</label> <input type="date" id="fechaOficio" name="fechaOficio" value='.$res4['fechaOficio'].' required>  </td>
										<td align=left>     </td>
										<td align=right>  <label>Fecha actual (*) </label>  <input   style="background-color:#CCCCCC;" type="date" id="fecha" name="fecha" value='.$res4['fecha'].' required>  </td>
										<td align=left>  </td>
									</tr>
								</table></div>';
						if($res4['fecha_termino']!='0000-00-00'){
							echo "<div id='divfechaTermino".$ra['id']."' style='display:inline-block;'>";
								echo "<label>Fecha término </label>  <input type='date' id='fechaTermino".$ra['id']."' name='fechaTermino' value=".$res4['fecha_termino'].">";
							echo "</div>";
						}else{
							echo "<div id='divfechaTermino".$ra['id']."' style='display:none;'>";
								echo "<label>Fecha término </label>  <input type='date' id='fechaTermino' name='fechaTermino' >";
							echo "</div>";
						}
				
						echo '<div><label>Referencia</label>';
						echo '<input style="background-color:#FF9933;" id="ofnumero" name="ofnumero"  value="'.$res4['oficioNumero'].'"  title="Numero consecutivo de oficios de atencion al publico"/></div>';

						echo '<div><label>Remite</label>';
						echo '<input placeholder="Remite" id="remite" name="remite" value="'.$res4['remite'].'"></div>';
						echo '<div><label>Puesto</label>';
						echo '<input placeholder="Puesto" id="puesto" name="puesto" value="'.$res4['puesto'].'"></div>';
						echo '<div><label>Dependencia</label>';
						echo '<input placeholder="Dependencia" id="dependencia" name="dependencia" value="'.$res4['dependencia'].'"></div>';
						echo '<div><label> Asunto (*)</label>';
						echo '<input placeholder="Asunto" name="asunto" value="'.$res4['asunto'].'" required></div>';		
						echo '<div><span><label> Descripción </label>';
						echo '<textarea style="height:20%;" name="descripcion">'.$res4['descripcion'].'</textarea></span></div>';
						echo '<div><input class="Mbtn btn-danger" id="boton" type="submit" value="Guardar"></div>';

					echo '</form>';
					echo "</div>";
			//---------------------------------------------------------------------------------------------------	


				echo "</td>";
				echo "<td>";
				echo '<center><div id="cont2">
				<div id="contenidos2">
					<center>
				  <div id="colum1">';
					echo "<form action='cp_nuevos_oficios.php' method='GET'>";
					echo "<input type='hidden' value=".$ra['id']." name='id'>";
					echo "<input type='hidden' name='txtplus' value=1>";
					echo "<input type='hidden' name='pv' value=1>";
					echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para ver el historial del archivo' onclick=''> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </button>"; 
					echo "</form>";
				echo '</div>';
			
				if($ra['nitavuCaptura']==$nitavu){
					echo '<div id="colum2">';
						echo "<form action='cp_controldocumental.php' method='POST'>";
						echo "<input type='hidden' value=".$ra['id']." id='darBaja' name='darBaja'>";
						echo "<button type='submit' class='Mbtn btn-cancel' title='Haga clic para eliminar el caso' onclick=''> <img src='icon/delete.png' style='width:20px; height:20px;'> </button>"; 
						echo "</form>";
					echo '</div>';
				}
				echo '</center></div></div></center>';
				echo "</td>";
				if (soytitular($nitavu)!='FALSE'  && $fech==""){//filtra solo titulares
				echo "<td>";
				echo "<form action='cp_controldocumental.php' method='GET'>";
				echo "<input type='hidden' value=".$ra['id']." name='vobo1'>";
				echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para dar el visto bueno' onclick=''> <img src='icon/ok.png' style='width:20px; height:20px;'> </button>"; 
				echo "</form>";
				echo "</td>";
				echo "<td>";
					
					echo "<center><p style='font-size:20pt; color:#6F7070; '>".actividaddelCaso($ra['id'])."</p></center>";
				echo "</td>";
				}else if(soytitular($nitavu)!='FALSE'  && $fech<>""){
					echo "<td><center><img src='icon/ok.png' style='width:30px;'></center>";
					echo "</td>";
					echo "<td>";
					echo "<center><p style='font-size:20pt; color:#6F7070; '>".actividaddelCaso($ra['id'])."</p></center>";
				echo "</td>";	
				}
				
				echo "</tr>";
		}
			echo "</table>";
			echo "</div></center></td>";

			



			echo "</tr></table>";
		 
		 /*en proceso de atencion */



	}
		 
	
	}    
	echo "</div>";
	  
	

//---------------------------------------------------
//DIV DE CASOS EN LOS QUE SOY COLABORADOR	
echo "<div id='colaboraciones' style='vertical-align:top;'>";
$dpto = nitavu_dpto($nitavu);
// echo "<br><br>";
//and cp_nuevosdocumentos.Turnadoa<>".nitavu_dpto($nitavu)."
$query = "SELECT 
cp_nuevosdocumentos.id,cp_nuevosdocumentos.fechaoficio,cp_nuevosdocumentos.fecha,cp_nuevosdocumentos.oficionumero,cp_nuevosdocumentos.asunto,cp_nuevosdocumentos.descripcion,
cp_nuevosdocumentos.prioridad
 FROM cp_nuevosdocumentos inner join cp_colaboradores on cp_colaboradores.numcaso=cp_nuevosdocumentos.id WHERE
 cp_nuevosdocumentos.estado=0 and cp_nuevosdocumentos.baja=0 and cp_colaboradores.activo=0 and cp_colaboradores.nitavu=".$nitavu."  ORDER BY prioridad DESC";

$query="SELECT 
cp_nuevosdocumentos.id,cp_nuevosdocumentos.fechaoficio,cp_nuevosdocumentos.fecha,cp_nuevosdocumentos.oficionumero,cp_nuevosdocumentos.asunto,cp_nuevosdocumentos.descripcion, cp_nuevosdocumentos.idDptoCrea
 FROM cp_nuevosdocumentos inner join cp_colaboradores on cp_colaboradores.numcaso=cp_nuevosdocumentos.id WHERE
 cp_nuevosdocumentos.estado=0 and cp_nuevosdocumentos.baja=0 and cp_colaboradores.activo=0 and cp_colaboradores.nitavu=".$nitavu."  ORDER BY id ASC";
// echo $query;
$rc= $conexion -> query($query); 
if ($rc->num_rows>0)
{
	
	echo "<table width=100%><tr><td>
	<center>";
	echo "<h1>COLABORACIONES</h1>";
	echo "<div id=''><table style = 'font-size: 13px;' class='tabla'>";
	echo "<th style = 'background-color: #990000;' width='10%' COLSPAN='2'>Fecha</th>";
	echo "<th style = 'background-color: #990000;' width='25%'>Asunto</th>";
	echo "<th style = 'background-color: #990000;' width='7%'>Ver</th>";
  while($r = $rc -> fetch_array())    
  {
	echo "<tr>";
		echo "<td>".$r['id']."</td>";
		echo "<td>".$r['fecha']."</td>";
		echo "<td><div id='columna1'>
		<b style = 'color: #990000;'>".$r['asunto']."</b><span style='font-size:8pt'><br>".$r['descripcion']."</span><br>
		<span style='color: #54565a;' center>Creado por: ".nombreDepartamento($r['idDptoCrea'])."</span>";
		if(esHoyElDiadeVencimiento($r['id'])=='TRUE'){
			echo "<label style='font-size:8pt; color:white; background-color:red; font-family:verdana;'>HOY ES LA FECHA DE VENCIMIENTO DE ESTE CASO.</label>";
		}else if(seVencioYnohaFinalizado($r['id'])=='TRUE'){
			echo "<label style='font-size:8pt; color:white; background-color:red; font-family:verdana;'></label>";
		}
		echo "</div>";

		if(tieneFechaTermino($r['id'])<>'FALSE'){
			echo '<div id="columna2" align="center" style="vertical-align: middle; padding-top: 8px;" title="Vence el '.FechaTermino($r['id']).'">';
				$dias = diasFaltantesParaTermino($r['id']);
				DiasFaltantes('g'.$r['id'],$dias);

			echo "</div>";
		}

		
		
		
		
		echo "</td>";
		
		echo "<td>";
		echo "<form action='cp_nuevos_oficios.php' method='GET'>";
		echo "<input type='hidden' value=".$r['id']." name='id'>";
		echo "<input type='hidden' name='txtplus' value=1>";
		echo "<input type='hidden' name='pv' value=1>";
		echo "<button type='submit' class='btn-identidad-color1' title='Haga clic para ver el historial del archivo' onclick=''> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </button>"; 
		echo "</form>";
		echo "</td>";
	echo "</tr>";
	/*if($r['prioridad']==1){
		echo "<tr style='background-color:#DAFA9D; '>";
		echo "<td>".$r['id']."</td>";
		echo "<td>".$r['fecha']."</td>";
		echo "<td>".$r['asunto']."</td>";
		echo "<td>".$r['descripcion']."</td>";
		echo "<td>";
		echo "<form action='cp_nuevos_oficios.php' method='GET'>";
		echo "<input type='hidden' value=".$r['id']." name='id'>";
		echo "<input type='hidden' name='txtplus' value=1>";
		echo "<input type='hidden' name='pv' value=1>";
		echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para ver el historial del archivo' onclick=''> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </button>"; 
		echo "</form>";
		echo "</td>";
		
		echo "</tr>";
	}else if($r['prioridad']==2){
		echo "<tr style='background-color:#FCDCBC;'>";
		echo "<td>".$r['id']."</td>";
		echo "<td>".$r['fecha']."</td>";
		echo "<td>".$r['asunto']."</td>";
		echo "<td>".$r['descripcion']."</td>";
		echo "<td>";
		echo "<form action='cp_nuevos_oficios.php' method='GET'>";
		echo "<input type='hidden' value=".$r['id']." name='id'>";
		echo "<input type='hidden' name='txtplus' value=1>";
		echo "<input type='hidden' name='pv' value=1>";
		echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para ver el historial del archivo' onclick=''> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </button>"; 
		echo "</form>";
		echo "</td>";
		
		echo "</tr>";
	}else if($r['prioridad']==3){
		echo "<tr style='background-color:#FAC7C7;'>";
		echo "<td>".$r['id']."</td>";
		echo "<td>".$r['fecha']."</td>";
		echo "<td>".$r['asunto']."</td>";
		echo "<td>".$r['descripcion']."</td>";
		echo "<td>";
		echo "<form action='cp_nuevos_oficios.php' method='GET'>";
		echo "<input type='hidden' value=".$r['id']." name='id'>";
		echo "<input type='hidden' name='txtplus' value=1>";
		echo "<input type='hidden' name='pv' value=1>";
		echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para ver el historial del archivo' onclick=''> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </button>"; 
		echo "</form>";
		echo "</td>";
		
		echo "</tr>";
	}*/
  }
	  echo "</table>";
	  echo "</div>";
	  echo "</td><td valign=top width=30% align=center>";
		  //graficas de colaboracion
		// echo "
		//   <div id='GraficaColaboradores5'></div>
		//   ";

		//   $sql = "
		//   SELECT
		// 	  DISTINCT idDptoCrea as IdDpto,
		// 	  (select nombre from cat_gerarquia where id = IdDpto) as Departamento,
		// 	  cp_colaboradores.nitavu as IdEmpleado,
		// 	  (select count(*) from cp_nuevosdocumentos 
		// 		  INNER JOIN cp_colaboradores ON cp_colaboradores.numcaso = cp_nuevosdocumentos.id 
		// 		  WHERE
		// 			  cp_nuevosdocumentos.estado = 0 
		// 			  AND cp_nuevosdocumentos.baja = 0 
		// 			  AND cp_colaboradores.activo = 0 
		// 			  AND cp_colaboradores.nitavu = IdEmpleado 
		// 			  AND cp_nuevosdocumentos.idDptoCrea = IdDpto
		// 		  ) as ColaboracionesAbiertas
		//   FROM
		// 	  cp_nuevosdocumentos 
		// 	  INNER JOIN cp_colaboradores ON cp_colaboradores.numcaso = cp_nuevosdocumentos.id 
		//   WHERE
		// 	  cp_nuevosdocumentos.estado = 0 
		// 	  AND cp_nuevosdocumentos.baja = 0 
		// 	  AND cp_colaboradores.activo = 0 
		// 	  AND cp_colaboradores.nitavu =".$nitavu;
		// // echo $sql;
		//   $r5= $conexion -> query($sql);
		//   $data = "";
		//   while($f5 = $r5 -> fetch_array()) {
		// 	  $data = $data."['".$f5['Departamento']."',".$f5['ColaboracionesAbiertas']."],";

		//   }
		//   $data = substr($data, 0, -1); //quita la ultima coma.
		//   echo "<script>
		// 	  GraficaColaboradores5();


		// 	  function GraficaColaboradores5(){
		// 		  google.charts.load('current', {packages:['corechart']});
		// 		  google.charts.setOnLoadCallback(drawChart);
		// 		  function drawChart() {
		// 		  var data = google.visualization.arrayToDataTable([
		// 			  ['Colaborador', 'Casos Abiertos'], ".$data."
					  
						  
		// 		  ]);

		// 		  var options = {
		// 			  title: 'Mis Colaboraciones Pendientes',
		// 			  pieHole: 0.4,
					  
		// 			  legend: {position: 'bottom',textStyle: {color: 'gray', fontSize: 8}}
		// 		  };

		// 		  var chart = new google.visualization.PieChart(document.getElementById('GraficaColaboradores5'));
		// 		  chart.draw(data, options);
		// 		  }
		// 	  }
		// 	  </script>
		// 	  ";

			  echo " <div id='GraficaColaboradores6'></div>
			  ";
  
			  $sql = "SELECT * from ticketcolaboradores WHERE IdDpto=".nitavu_dpto($nitavu);
			  $r6= $conexion -> query($sql);
			  $data = "";
			  while($f6 = $r6 -> fetch_array()) {
				  $data = $data."['".$f6['Nombre']."',".$f6['CasosActivos']."],";
  
			  }
			  $data = substr($data, 0, -1); //quita la ultima coma.
			  echo "<script>
				  GraficaColaboradores6();
  
  
				  function GraficaColaboradores6(){
					  google.charts.load('current', {packages:['corechart']});
					  google.charts.setOnLoadCallback(drawChart);
					  function drawChart() {
					  var data = google.visualization.arrayToDataTable([
						  ['Colaborador', 'Casos Abiertos'], ".$data."
						  
							  
					  ]);
  
					  var options = {
						  title: 'Actividad de Colaboracion (casos activos)',
						  pieHole: 0.4,
						  
						  legend: {position: 'bottom',textStyle: {color: 'gray', fontSize: 8}}
					  };
  
					  var chart = new google.visualization.PieChart(document.getElementById('GraficaColaboradores6'));
					  chart.draw(data, options);
					  }
				  }
				  </script>
				  ";


			$sql = "select DISTINCT a.nitavu,
			(select nombre from empleados where nitavu = a.nitavu) as Nombre,
			(select count(*) from ticketpendientes where nitavu = a.nitavu and estado = 0) as Pendientes
			from ticketpendientes a  where  dpto = ".nitavu_dpto($nitavu)." and estado=0";
			// echo $sql;
			$r= $conexion -> query($sql);
			// $data = "";
			$html_resume = "<h3>Colaboraciones activas</h3><table  class='tabla'>";
			while($f = $r -> fetch_array()) {
				// $data = $data."['".$f['Nombre']."',".$f['Pendientes']."],";
				$html_resume = $html_resume."<tr>";
				$html_resume = $html_resume."<td style = 'font-size: 12px;'>".$f['Nombre']."</td><td style = 'font-size: 12px;'><a href='#modal".$f['nitavu']."' rel='MyModal:open'>".$f['Pendientes']."</a></td>";
				$html_resume = $html_resume."</tr>";

				//Construimos el modal
				echo "<div id='modal".$f['nitavu']."' class='MyModal'><h3>Casos activos, atendidos por:".$f['Nombre']." </h3>";
				$sqlR = "
				SELECT 
				a.*,
				(select asunto from cp_nuevosdocumentos where id = a.numcaso) as Asunto,
				(select estado from cp_nuevosdocumentos where id = a.numcaso) as Estado

				FROM cp_colaboradores a WHERE nitavu = ".$f['nitavu']." and activo = 0
						";
				$rx= $conexion -> query($sqlR);
				echo  "<table class='tabla'>";
				while($fx = $rx -> fetch_array()) {
					if ($fx['Estado']==0) {
					echo "<tr>";
					echo "<td>
					<a href='cp_nuevos_oficios.php?id=".$fx['numcaso']."&txtplus=1&pv=1'>
					".$fx['numcaso']."</a></td><td>".$fx['Asunto']."</td>";
					
				
					}
				
				}
				echo "</table>";
				echo "</div>";
			}
			$html_resume = $html_resume."</table>";
			echo $html_resume;




				  echo "
			<div id='GraficaColaboradores2'></div>
			";

			$sql = "
			SELECT
				fecha as FechaDesde,
					(SELECT DATEDIFF(CURDATE(),FechaDesde)) as Retraso,	
					id, asunto
				FROM
					cp_nuevosdocumentos
				WHERE
					estado = 0 
					AND baja = 0 
					AND turnadoa = ".nitavu_dpto($nitavu)." order by fecha DESC";

			$ultimo="";

			$r2= $conexion -> query($sql);
			$data = "";
			while($f2 = $r2 -> fetch_array()) {
				$data = $data."[' - ".$f2['id']." - ".$f2['asunto']."',".$f2['Retraso']."],";
				$ultimo = "<div id='gc' style='
				margin-top: -142px;

				position: relative;
				
				width: 27%;
				
				
				'><b style='font-size:24pt; 
				width: 50%;' title='".$f2['asunto']."'>".$f2['Retraso']."</b><label style='font-size:7pt; width:100%;'>Dias de atraso en el caso ".$f2['id']."</label></div>";
			}
			echo $ultimo;
			$data = substr($data, 0, -1); //quita la ultima coma.
			echo "<script>
				GraficaColaboradores();


				function GraficaColaboradores(){
					google.charts.load('current', {packages:['corechart']});
					google.charts.setOnLoadCallback(drawChart);
					function drawChart() {
					var data = google.visualization.arrayToDataTable([
						['Caso', 'xxDias de Atraso'], ".$data."
						
							
					]);

					var options = {
						title: 'Actividad de Atraso en tu Departamento',
						pieHole: 0.9,
						
						legend: {position: 'bottom',textStyle: {color: 'gray', fontSize: 8}}
					};

					var chart = new google.visualization.PieChart(document.getElementById('GraficaColaboradores2'));
					chart.draw(data, options);
					}
				}
				</script>
				";

			echo "<br><br><br><br> <br><br><br>
			<div id='GraficaColaboradores3'></div>
			";

			$sql = "SELECT
			DISTINCT idDptoCrea,
			(select nombre from cat_gerarquia where id = a.IdDptoCrea) as Departamento,
			(select count(*) from  cp_nuevosdocumentos WHERE turnadoa=55 and estado=0 and baja = 0 and idDptoCrea = a.idDptoCrea) as Casos
			
			FROM
				cp_nuevosdocumentos a
			WHERE
				turnadoa =".nitavu_dpto($nitavu)."
				AND estado = 0 
				AND baja = 0 ";
			$r3= $conexion -> query($sql);
			$data = "";
			while($f3 = $r3 -> fetch_array()) {
				$data = $data."['".$f3['Departamento']."',".$f3['Casos']."],";

			}
			$data = substr($data, 0, -1); //quita la ultima coma.
			echo "<script>
				GraficaColaboradores3();


				function GraficaColaboradores3(){
					google.charts.load('current', {'packages':['corechart']});
					google.charts.setOnLoadCallback(drawChart);
			  
					function drawChart() {
					  var data = google.visualization.arrayToDataTable([
						['Departamento', 'Casos'],
						".$data."
					  ]);
			  
					  var options = {
						title: 'Casos abiertos de tu Departamento',
						hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
						vAxis: {minValue: 0}
					  };
			  
					  var chart = new google.visualization.AreaChart(document.getElementById('GraficaColaboradores3'));
					  chart.draw(data, options);
					}
				}
				</script>
				";
	  echo "</td></tr></table>";
	  echo "</center>";
} 
  echo "</div>";
  echo sugerencia("
  	<p style='color:white'>
  		Se le recomienda fundamentar el caso al subirlo, anexe expediente o documentacion ligada a lo que solicita. De esta manera el departamento que lo atiende tendra mejores elementos para encontrar la solución que busca.
		El uso de está herramienta <b>no sustitutye a la documentación oficial</b>; es un medio de apoyo para agilizar algunos procesos y tramites, según así lo considere dicha área.
		Se recomienda ponerse en contacto con el Departamento al que pretende enviar su Ticket, a fin de confirmar que será atendido por esta via.
	</p>
  ");




	//MODAL AGREGAR NUEVO DOCUMENTO-----------------------------------------------------------------------------------------------------------
	echo "<div id='documentoNew' class='MyModal'  ><h3 style='color: darkred; font-size: 18px;'>Agregar nuevo oficio: </h3>";
   
    
		
			echo "<table width=100%><tr><td><form action='cp_controldocumental.php' method='POST'  enctype='multipart/form-data'>";
			//echo "<label style='font-size:8pt;'> *Si agregas fecha termino la plataforma te enviará notificaciones hasta el día de su vencimiento</label>";
			//te enviará notificaciones y correos diarios hasta el día de su vencimiento.
		 	//style="display:none"	

				//echo '<center><table><td ><label><input type="checkbox" id="turnar" name="turnar" value="turnar" onClick="mostrarDepartamento()">Turnar</label></td>
				//<td style="width:40%"></td>';
				
				// deshabilitado para revisión de envío de correos
				/*echo '<center><table>';				
				echo '<td> <label style="font-size: 12px; display: flex;"><input type="checkbox" id="fechaTer" name="fechaTer" value="fechaTer" onClick="mostrarFechaTermino()">Fecha termino</label></td><td style="width:20px"></td>
				<td><label style="font-size:8pt;"> *Si agregas fecha termino la plataforma te enviará notificaciones hasta el día de su vencimiento</label></td>
				</table></center>';
				*/

		 		echo '<div style="width: 80%"><table style="width: 100%" >
				<tr>
				<td align=center>  <label  style="font-size: 12px;">Fecha actual</label>  <input   style="background-color:#CCCCCC;text-align: center;  font-size: 12px; height: 24px;" type="date" id="fecha" name="fecha" value='.$fecha.' required readonly>  </td>
				<td align=left>  </td>
				<td align=center> <label  style="font-size: 12px;">*Fecha del Oficio</label> <input style= "text-align: center; font-size: 12px; height: 24px;" type="date" id="fechaOficio" name="fechaOficio" required>  </td>
				<td align=left>     </td>		
				<td width=60%></td>	
				</tr>
				</table></div>';

			//-------------FILTRO DIRECCION JURIDICA
			/*$res = SoyDireccionJuridica($nitavu);

			for($i=0; $i<sizeof($res); $i++){
				//echo $res[$i];
        if(nitavu_dpto($nitavu) == $res[$i]){
					echo "<div>";
						echo "<label>Fecha termino</label> <input type='date' id='fechaTermino' name='fechaTermino' required>";
					echo "</div>";
				}
    	}*/
			echo "<div id='divfechaTermino' style='display:none;'>";
				echo "<label>Fecha termino</label> <input type='date' id='fechaTermino' name='fechaTermino' style='font-size: 12px; height: 24px;'>";
			echo "</div>";
		 	
			//tabla remitente
			echo "<table>";
				echo "<tr><td>";
					echo '<div style="width:60%"><label>Referencia/Número de oficio Ej.DG/DI/123 </label>';
					echo '<input id="ofnumero" name="ofnumero" class="inputestandar" style="width:25%px;" title="Número consecutivo de oficios de atención al público"/></div>';
		/*  echo '<div><label>Prioridad</label>';
		echo '<select id="prioridad" name="prioridad" required>
					<option value="">Seleccione una prioridad</option>
					<option value="1">Baja</option>
					<option value="2">Media</option>
					<option value="3">Alta</option>
				</select></div>';*/
				echo "</td><td>";
				echo '<div><label>Remite</label>';
				echo '<input  placeholder="Persona que envía" id="remite" name="remite" class="inputestandar"></div>';
				echo "</td></tr>";
		
				echo "<tr><td>";
				echo '<div><label>Puesto</label>';
				echo '<input placeholder="Puesto de quien envía" id="puesto" name="puesto" class="inputestandar"></div>';
				echo "</td><td>";
				echo '<div><label>Dependencia</label>';
				echo '<input   placeholder="Dirección, departamento, delegación" id="dependencia" name="dependencia" class="inputestandar"></div>';
				echo "</td></tr>";

				echo "<tr><td colspan=2 align='left'>";	
				echo '<div style="text-align:left;"><label>*Asunto</label>';
				echo '<input placeholder="*Descripción breve del caso" name="asunto" style="width:665px" class="inputestandar" required></div>';		
				echo "</td></tr>";

				//echo "<tr></td><td>";
				echo "<tr><td>";
				echo '<div style="width:60%"><span><label> Descripción extendida del caso </label>';
				echo '<textarea style="height:51px; font-size:8pt; width:300px " name="descripcion"></textarea></span></div>';
				echo "</td>";	
				
				echo "<td>";
				echo '<div><label>Archivo PDF</label>';
				echo '<input id="myFile" name="myFile" type="file" accept=".pdf" style=" width:300px"></div>';
				echo "</td></tr>";
				echo "<tr><td colspan=2><hr></hr></td></tr>";
				echo "<tr>";
				//style='display:none;'
				echo "<td><h2 style=' font-size: 19; color: darkred;'>  Turnar a: </h2></td>";
				echo "<td style='widt:197%'><div  id='turnarDpto' style='width:90%' >";			
					echo "<label  class='label'>Departamento:";
					echo "<select name='departamento'   id='departamento'   style='margin-left: 0px;' required>";	
					echo '<option value="0" selected="selected">Seleccione </option>';		
					echo '<option value="100" >Fuera del Instituto </option>';
					//$sql="SELECT	cat_gerarquia.id ,	cat_gerarquia.titular ,	cat_gerarquia.nombre,	cat_gerarquia.dependencia
					//	FROM	cat_gerarquia where (id <>".nitavu_dpto($nitavu).") ORDER BY cat_gerarquia.nombre ";
					$sql="SELECT	cat_gerarquia.id ,	cat_gerarquia.titular ,	cat_gerarquia.nombre,	cat_gerarquia.dependencia
						FROM	cat_gerarquia  ORDER BY cat_gerarquia.nombre ";
					$rDptos = $conexion->query($sql);
					while($f = $rDptos -> fetch_array())
						{ 
						echo "<option value='".$f['id']."'>".$f['nombre']. " </option>";
						}	
									
					echo "</select>";
				
					echo "</label>";
				echo "</div>";	
				// echo "</td><td>";				
				// //style="font-size:13"
				// echo '<div style="width:80%"><label>Empleado a quien se turna (opcional)</label>';
				// echo '<input   placeholder="" id="turnaempleado" name="turnaempleado" class="inputestandar"></div>';
				echo "</td></tr>";		
				// echo "<tr center><td colspan=2 >";				
				//echo '<div><input class="Mbtn btn-danger" id="boton" type="submit" value="Guardar"></div>';
				//echo "</td></tr>"; 
			echo "</table>";		
	 // echo '</form></td>';
	 // echo "</table>";				
	  //fin tabla remitente

	  echo "<td align=center valign=top width=30%>";
				echo "<table><tr><td>";				

				echo sugerencia("
				<p>Se le recomienda fundamentar el caso al subirlo, anexe expediente o documentacion ligada a lo que solicita. De esta manera el departamento que 
				lo atiende tendrá mejores elementos para encontrar la solución que busca.</p>

				<p>El uso de está herramienta no sustitutye a la documentación oficial; es un medio de apoyo para agilizar algunos procesos y trámites, según así lo
				considere dicha área.
				</p>

				<p>Es aconsejable hablar antes con el departamento al que pretenda enviar el Ticket, a fin de confirmar que le atenderan por está via.
				</p>
						
				");
				echo "</td></tr>";
				 echo "<tr style='height: 156px;'><td align=center><br>";
				 	echo '<div><input type="hidden" name="turnar" value="turnar"><input class="Mbtn btn-danger" id="boton" type="submit" style="width:250px" value="Guardar"></div>';
				 echo "</td></tr>";
				echo "</table>";


	  echo "</td>";
	  echo "</tr></table>";
		echo '</form></td>';
		echo "</div>";
	//Cuando se registra un nuevo caso

	if (isset($_POST['departamento']) && isset($_POST['turnar'])){

        
        if(empty($_POST['departamento']))
        {
            mensaje('Debe Seleccionar un departamento','cp_controldocumental.php');
        }else {
           
			if(isset($_POST['ofnumero']) and isset($_POST['asunto']) and isset($_POST['descripcion'])){
				//SI EXISTE UN DEPARTAMENTO AL CUAL TURNAR
				if(!empty($_FILES['myFile']['name']) != null){
					//$prioridad = $_POST['prioridad'];
					$fechaOficio = $_POST['fechaOficio'];
					$fecha = $_POST['fecha'];
					if(isset($_POST['fechaTermino'])){
						$fechaTermino = $_POST['fechaTermino'];
					}else{
						$fechaTermino = '';
					}
					$fechaTerminoSql = ($fechaTermino !== '') ? "'".$fechaTermino."'" : "'0000-00-00'";
					$ofnumero = $_POST['ofnumero'];
					//$remite = strtoupper($_POST['remite']);
					$remite = $_POST['remite'];
					$puesto = $_POST['puesto'];
					$dependencia = $_POST['dependencia'];
					$asunto = $_POST['asunto'];
					//$descripcion = strtoupper($_POST['descripcion']);
					$descripcion = $_POST['descripcion'];
					$myFile = $_FILES['myFile']['name'];
					$temp =$_FILES['myFile']['tmp_name'];
					$dpto = nitavu_dpto($nitavu);
					$dptoTurnar = $_POST['departamento'];
					$idDocumento = idDocumento(TRUE);
					$numDocumento = numdeDocumento(TRUE);
					$archivo = "peticiones/".$numDocumento.'_'.$idDocumento.'_'.$myFile."";
					$subida = FTP_subir($temp,$archivo);
					//$empleadoseturna=$_POST['empleadoseturna'];
					if ($subida == "TRUE"){
						$sql = "INSERT INTO cp_nuevosdocumentos(idauto, id, fechaoficio, fecha, oficionumero, remite, puesto, dependencia,asunto, descripcion, nitavucaptura, iddptocrea,turnadoa,estado,baja, vobo, fecha_termino) 
						VALUES ('', '$idDocumento','$fechaOficio', '$fecha', '$ofnumero', '$remite', '$puesto', '$dependencia','$asunto','$descripcion','$nitavu','$dpto','$dptoTurnar',0,0,'',$fechaTerminoSql)";
						if($conexion->query($sql) == TRUE){ 
							if($ofnumero==numeroOficioPublico(TRUE)){
								numeroOficioPublico(FALSE);
							}
							idDocumento(FALSE);
							$sql2 = "INSERT INTO cp_historialdocumentos(idinc, iddoc, numcaso, archivo, fecha, nitavusube, dptosube, dptoenviar, numoficio, activo, tipo,hora) 
							VALUES (NULL, '$numDocumento', '$idDocumento', '$myFile', '$fecha', '$nitavu', '$dpto','$dptoTurnar','$ofnumero',0,0,'$hora')";
							if ($conexion->query($sql2) == TRUE){  
								numdeDocumento(FALSE);
								historia($nitavu,'cp_Agregó un nuevo caso llamado: '.$ofnumero.' con Id: '.$idDocumento);
								historia($nitavu,'cp_Agregó un nuevo caso  Id: '.$idDocumento.' Archivo: '.$myFile);
								
								mensaje('1.Se ha registrado con éxito el nuevo documento.'.$idDocumento,'cp_controldocumental.php');
								//agregarSeguimiento($idDocumento, $ofnumero, $numDocumento, $dpto, $fecha);
							}else{
								mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.','cp_controldocumental.php');
							}	
						}else{
							mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.','cp_controldocumental.php');
						}
					}else{
						mensaje('No ha seleccionado ningun archivo.','cp_controldocumental.php');
					}
				}else{
					//$prioridad = $_POST['prioridad'];
					$fechaOficio = $_POST['fechaOficio'];
					$fecha = $_POST['fecha'];
					if(isset($_POST['fechaTermino'])){
						$fechaTermino = $_POST['fechaTermino'];
					}else{
						$fechaTermino = '';
					}
					$fechaTerminoSql = ($fechaTermino !== '') ? "'".$fechaTermino."'" : "'0000-00-00'";
					$ofnumero = $_POST['ofnumero'];
					$remite = $_POST['remite'];
					$puesto = $_POST['puesto'];
					$dependencia = $_POST['dependencia'];
					$asunto = $_POST['asunto'];
					//$descripcion = strtoupper($_POST['descripcion']);
					$descripcion = $_POST['descripcion'];
					$myFile = $_FILES['myFile']['name'];
					$dpto = nitavu_dpto($nitavu);
					$dptoTurnar = $_POST['departamento'];
					$idDocumento = idDocumento(TRUE);
					$numDocumento = numdeDocumento(TRUE);
					//$empleadoseturna=$_POST['empleadoseturna'];
						$sql = "INSERT INTO cp_nuevosdocumentos(idauto, id, fechaoficio, fecha, oficionumero, remite, puesto, dependencia,asunto, descripcion, nitavucaptura, iddptocrea, turnadoa, estado, baja, vobo, fecha_termino) 
						VALUES ('', '$idDocumento','$fechaOficio', '$fecha', '$ofnumero', '$remite', '$puesto', '$dependencia',
							'$asunto','$descripcion','$nitavu','$dpto','$dptoTurnar',0,0,'',$fechaTerminoSql)";
					
						if($conexion->query($sql) == TRUE){ 
							// if($ofnumero==numeroOficioPublico(TRUE)){
							// 	numeroOficioPublico(FALSE);
							// }
							idDocumento(FALSE);
							$sql2 = "INSERT INTO cp_historialdocumentos(idinc, iddoc, numcaso, archivo, fecha, nitavusube, dptosube, dptoenviar, numoficio, activo, tipo,hora) 
								VALUES (NULL, '$numDocumento', '$idDocumento', '$myFile', '$fecha', '$nitavu', '$dpto','$dptoTurnar','$ofnumero',0,0,'$hora')";
							if ($conexion->query($sql2) == TRUE){  
								numdeDocumento(FALSE);
								historia($nitavu,'cp_Agregó un nuevo caso llamado: '.$ofnumero.' con Id: '.$idDocumento.'Archivo: '.$myFile);						
								mensaje('2.Se ha registrado con éxito el nuevo documento. '.$idDocumento,'cp_controldocumental.php');
								//agregarSeguimiento($idDocumento, $ofnumero, $numDocumento, $dpto, $fecha);
							}else{
								mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.','cp_controldocumental.php');
							}	
						}else{
							mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.','cp_controldocumental.php');
						}
				}
			}
    	}
	}else{
	
		
		if(isset($_POST['ofnumero']) and isset($_POST['asunto']) and isset($_POST['descripcion']) and !isset($_GET['editar'])){
			if(!empty($_FILES['myFile']['name']) != null){
			
				//$prioridad = $_POST['prioridad'];
				$fechaOficio = $_POST['fechaOficio'];
				$fecha = $_POST['fecha'];
				if(isset($_POST['fechaTermino'])){
					$fechaTermino = $_POST['fechaTermino'];
				}else{
					$fechaTermino = '';
				}
				$fechaTerminoSql = ($fechaTermino !== '') ? "'".$fechaTermino."'" : "'0000-00-00'";
				$ofnumero = $_POST['ofnumero'];
				$remite = $_POST['remite'];
				$puesto = $_POST['puesto'];
				$dependencia = $_POST['dependencia'];
				$asunto = $_POST['asunto'];
				//$descripcion = strtoupper($_POST['descripcion']);
				$descripcion = $_POST['descripcion'];
				$myFile = $_FILES['myFile']['name'];
				$temp =$_FILES['myFile']['tmp_name'];
				$dpto = nitavu_dpto($nitavu);
				$idDocumento = idDocumento(TRUE);
				$numDocumento = numdeDocumento(TRUE);
				$archivo = "peticiones/".$numDocumento.'_'.$idDocumento.'_'.$myFile."";
				$subida = FTP_subir($temp,$archivo);
				$dptoTurnar = $_POST['departamento'];
				//$empleadoseturna=$_POST['empleadoseturna'];
				if ($subida == "TRUE"){
					$sql = "INSERT INTO cp_nuevosdocumentos(idauto, id, fechaoficio, fecha, oficionumero, remite, puesto, dependencia,asunto, descripcion, nitavucaptura, iddptocrea,turnadoa,estado,baja, vobo, fecha_termino) 
					VALUES ('', '$idDocumento','$fechaOficio', '$fecha', '$ofnumero', '$remite', '$puesto', '$dependencia','$asunto','$descripcion','$nitavu','$dpto','$dptoTurnar',0,0,'',$fechaTerminoSql)";
					if($conexion->query($sql) == TRUE){ 
						if($ofnumero==numeroOficioPublico(TRUE)){
							numeroOficioPublico(FALSE);
						}
						idDocumento(FALSE);
						$sql2 = "INSERT INTO cp_historialdocumentos(idinc, iddoc, numcaso, archivo, fecha, nitavusube, dptosube, dptoenviar, numoficio, activo, tipo,hora) 
						VALUES (NULL, '$numDocumento', '$idDocumento', '$myFile', '$fecha', '$nitavu', '$dpto','$dptoTurnar','$ofnumero',0,0,'$hora')";
						if ($conexion->query($sql2) == TRUE){  
							numdeDocumento(FALSE);
							historia($nitavu,'cp_Agregó un nuevo caso llamado: '.$ofnumero.' con Id: '.$idDocumento);
							historia($nitavu,'cp_Agregó un nuevo caso  Id: '.$idDocumento.' Archivo: '.$myFile);
							
							mensaje('3.Se ha registrado con éxito el nuevo documento. '.$idDocumento,'cp_controldocumental.php');
							//agregarSeguimiento($idDocumento, $ofnumero, $numDocumento, $dpto, $fecha);
						}else{
							mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.','cp_controldocumental.php');
						}	
					}else{
						mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.','cp_controldocumental.php');
					}
				}else{
					mensaje('No ha seleccionado ningun archivo.','cp_controldocumental.php');
				}
			}else{
				//$prioridad = $_POST['prioridad'];
				$fechaOficio = $_POST['fechaOficio'];
				$fecha = $_POST['fecha'];
				if(isset($_POST['fechaTermino'])){
					$fechaTermino = $_POST['fechaTermino'];
				}else{
					$fechaTermino = '';
				}
				$fechaTerminoSql = ($fechaTermino !== '') ? "'".$fechaTermino."'" : "'0000-00-00'";
				$ofnumero = $_POST['ofnumero'];
				$remite = $_POST['remite'];
				$puesto = $_POST['puesto'];
				$dependencia = $_POST['dependencia'];
				$asunto = $_POST['asunto'];
				//$descripcion = strtoupper($_POST['descripcion']);
				$descripcion = $_POST['descripcion'];
				$myFile = $_FILES['myFile']['name'];
				$dpto = nitavu_dpto($nitavu);
				$idDocumento = idDocumento(TRUE);
				$numDocumento = numdeDocumento(TRUE);
				$dptoTurnar = $_POST['departamento'];
				//$empleadoseturna= $_POST['empleadoseturna'];
					$sql = "INSERT INTO cp_nuevosdocumentos(idauto, id, fechaoficio, fecha, oficionumero, remite, puesto, dependencia,asunto, descripcion, nitavucaptura, iddptocrea, turnadoa, estado, baja, vobo, fecha_termino) 
					VALUES ('', '$idDocumento','$fechaOficio', '$fecha', '$ofnumero', '$remite', '$puesto', '$dependencia',
					'$asunto','$descripcion','$nitavu','$dpto','$dptoTurnar',0,0,'',$fechaTerminoSql)";
					if($conexion->query($sql) == TRUE){ 
						/*if($ofnumero==numeroOficioPublico(TRUE)){
							numeroOficioPublico(FALSE);
						}*/
						idDocumento(FALSE);
						$sql2 = "INSERT INTO cp_historialdocumentos(idinc, iddoc, numcaso, archivo, fecha, nitavusube, dptosube, dptoenviar, numoficio, activo, tipo,hora) 
						VALUES (NULL, '$numDocumento', '$idDocumento', '$myFile', '$fecha', '$nitavu', '$dpto','$dptoTurnar','$ofnumero',0,0,'$hora')";
						if ($conexion->query($sql2) == TRUE){  
							numdeDocumento(FALSE);
							historia($nitavu,'cp_Agregó un nuevo caso llamado: '.$ofnumero.' con Id: '.$idDocumento.'Archivo: '.$myFile);						
							mensaje('4. Se ha registrado con éxito el nuevo documento. '.$idDocumento,'cp_controldocumental.php');
							//agregarSeguimiento($idDocumento, $ofnumero, $numDocumento, $dpto, $fecha);
						}else{
							mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.','cp_controldocumental.php');
						}	
					}else{
						mensaje('Ocurrio un error al momento de guardar la información. Por favor vuelva a intentarlo.','cp_controldocumental.php');
					}
			}
		}
	}



	//Si le han dado clic a Visto Bueno
	if(isset($_GET['vobo1'])){
		$num = $_GET['vobo1'];
		if(actualizarVistoBueno($num,$nitavu)==TRUE){
			mensaje('Esta petición se ha marcado con Visto Bueno.','cp_controldocumental.php');
		}else{
			mensaje('Ocurrio un error, por favor intentelo nuevamente.','cp_controldocumental.php');
		}
	}
	if(isset($_GET['vobo2'])){
		$num = $_GET['vobo2'];
		if(actualizarVistoBueno($num,$nitavu)==TRUE){
			mensaje('Esta petición se ha marcado con Visto Bueno.','cp_controldocumental.php');
		}else{
			mensaje('Ocurrio un error, por favor intentelo nuevamente.','cp_controldocumental.php');
		}
	}
	if(isset($_GET['vobo3'])){
		$num = $_GET['vobo3'];
		if(actualizarVistoBueno($num,$nitavu)==TRUE){
			mensaje('Esta petición se ha marcado con Visto Bueno.','cp_controldocumental.php');
		}else{
			mensaje('Ocurrio un error, por favor intentelo nuevamente.','cp_controldocumental.php');
		}
	}
	//MODAL DE DOCUMENTOS RECIENTES
//--------------------------------------------------------- 
echo "<div id='docuementosRecientes' class='MyModal'><h3>Lista de documentos recientes: </h3>";
echo "<div style='overflow-y: auto; height:35%'>";		
echo "<table class='tabla' style='font-size: 9pt;'>";

echo "<th style='width:180px;'>Destinatario</th>
	<th class='pc'>Asunto</th>";
	$sql = " -- cp
	select cc.Numero,cc.Destinatario, IFNULL(cg.nombre,'Fuera del Instituto') as departamento,cc.Asunto,cc.Observaciones,cc.Autorizado,cc.FechaCrea, ct.TipoDocumento, cc.Id,cc.IdDptoCrea ,cgg.nombre as dptocrea,cc.NumDocumento
	,case WHEN  cc.NitavuCrea=".$nitavu." then 1 ELSE 0 END   AS 	cancelar
	,empleados.nombre
	from cp_controlcorrespondencia as cc left join cat_gerarquia as cg on cc.IdDptoEnvia=cg.id 
	inner join cat_gerarquia as cgg on cgg.id=cc.IdDptoCrea  
	inner join cat_tipo_documento as ct on 
	ct.IdTipoDocumento=cc.IdTipoDocumento
	inner join empleados on empleados.nitavu=cc.NitavuCrea
	where (cc.Utilizado=0 )	 and cc.IdDptoCrea= ".nitavu_dpto ($nitavu) ." order by cc.Id desc ";

	$rc= $conexion -> query($sql);
	$row_cnt = $rc->num_rows;
	echo "<th></th>";
	 while($co = $rc -> fetch_array())
	{	
		
		echo "<tr>";
		echo "<form  action='cp_acciones_bd.php' method='POST' >";
		echo "<td style='display:none'> <input type='hidden'  name='IdControl' value=".$co['Id']." ></td>";
		echo "<td style='display:none'> <input type='number'  name='IdDptoCrea' value=".$co['IdDptoCrea']." >  </td>"; 	
		
		echo "<td><span class='tmediano'><b>";
		echo $co['NumDocumento']."</b></span><br>";		  
		echo "<span class='tchico'><b>".$co['departamento']."</b></span><br>";		
		echo "<span class='tchico'>".date_format( date_create($co['FechaCrea']), 'd/m/Y')."</span></td>";

		echo "<td class='pc'>".$co['Asunto']."</td>";		
		echo "<td><span class='tmediano'><b>".$co['dptocrea']."</span><br>";
		echo "<span class='tchico'><b>".$co['nombre']."</b></span><br></td>";
		
			
			if ($co['cancelar']==1 &&   $co['Autorizado']!="0" )
			
			{
				
				echo "<td>";
				echo "<div style='width:100%;display:inline-block; text-align:center; padding:5px;' id='req_contenedor'>";			
				echo "<button type='submit' name='btnCancelar' id='btnCancelar' class='Mbtn btn-tercero' title='Cancelar' >";
				echo "<img src='icon/x.png' class='btn_cat_img' >";
				echo "</button>";
				echo "<a href='?DocId=".$co['Id']."'  title='Haz clic aqui para indicar que ya usaste este oficio' class='Mbtn btn-secundario' style='margin-left: 5px;'><img src='icon/reveri.png' style='width:25px;'></a>";
				echo "</div>";
				echo "</td>";
			
		  }

		//echo "<td><a href='?DocId=".$co['Id']."'  title='Haz clic aqui para indicar que ya usaste este oficio'class='Mbtn btn-secundario'><img src='icon/reveri.png' style='width:25px;'></a></td>";
		echo "</form>";	
		echo "</tr>";
	}
echo "</table>";
echo "</div>";
echo "<br>";
echo "<br>";
echo "<table border='0' style='width: 100%;'>";
echo"<tr>";
echo"<td>";			
echo "
<table>
<tr>		
<td><img src='icon/docs.png' class='icono' title='Plantilla Docs'>	</td>
<td class='normal tchico' style='width: 45%;'> <a href='cp_controldocumental.php?plantilla=".$nitavu."'>Solicitar Plantilla de Google Docs </a></td>
<td class=' tchico' >
<div style='
text-align: justify;
color: firebrick;'>
El número de oficio tiene como maximo 5 dias de uso, una vez pasado ese tiempo ya no podrá utilizarse. En caso de ser necesario, favor de generar un número nuevo.</div>";
echo" 
</td>
</tr>
</table>";

echo"</td>";
echo"<td style='text-align: right;'>";
echo"</td>";
echo"<tr>";
echo"</table>";
echo "<br>";
echo "</div>";


if (isset($_GET['DocId'])){
	$sql="UPDATE cp_controlcorrespondencia SET Utilizado='1' WHERE Id='".$_GET['DocId']."'";
		if ($conexion->query($sql) == TRUE)
		{
			historia($nitavu,"Marco el documento con Id ".$_GET['IdDoc']." como utilizado");
			mensaje("Documento marcado como utilizado",'cp_controldocumental.php');
		}
		else {mensaje("ERROR al intentar marcar el documento como utilizado ".$sql,"cp_controldocumental.php");}
}

if (isset($_GET['plantilla']))
	{ 
		$informatica = buscarInformatica();
      	$empl = explode('/',$informatica);
		  for($i=0; $i < sizeof($empl); $i++)
		  {
			
			$msgNoti='Buen día. <br> Necesito se me de acceso a la plantilla de oficios a '.nombreDepartamento(nitavu_dpto($nitavu));
			notificacion_add ($empl[$i], 'Solicitud de acceso a plantilla', date('Y-m-d'),$nitavu, $msgNoti);
			
		  }
	}
//----------------------
//MODAL SOLICITAR NUEVO NÚMERO
	echo "<div id='myModalaAgregar' class='MyModal' >";  
		 echo '<form action="cp_numNuevoDocumento_db.php" method="POST">';			        
			echo "<h3>Nuevo Número De Documento </h3>"; 		
			echo "<div >";
				echo "<label for='tipoDocumento' class='label'>Tipo del Documento:";
				echo "<select name='tipoDocumento'     style='margin-left: 0px;'>";	
				echo '<option value="0" selected="selected">Seleccione</option>';		
				$sql = "select * from cat_tipo_documento";			
				  $r = $conexion -> query($sql);		 
				  while($f = $r -> fetch_array())
					{ 
					  echo "<option value='".$f['IdTipoDocumento']."'>".$f['TipoDocumento']. " </option>";
					}				
				echo "</select>";
				echo "</label>";
			echo "</div>";
			 
			echo "<div>";			
				echo "<label for='departamento' class='label'>Departamento:";
				echo "<select name='departamento'   id='departamento'   style='margin-left: 0px;'>";	
				echo '<option value="0" selected="selected">Seleccione </option>';		
				echo '<option value="100" >Fuera del Instituto </option>';
				$sql="SELECT	cat_gerarquia.id ,	cat_gerarquia.titular ,	cat_gerarquia.nombre,	cat_gerarquia.dependencia
					FROM	cat_gerarquia where (id <>".nitavu_dpto($nitavu).") ORDER BY cat_gerarquia.nombre ";
				  $r = $conexion -> query($sql);	
				    
				  while($f = $r -> fetch_array())
					{ 
					  echo "<option value='".$f['id']."'>".$f['nombre']. " </option>";
					}	
								
				echo "</select>";
			
				echo "</label>";
			echo "</div>";
		
			echo "<span id='spanDestinatario' style='Width=100%'>";
 			 echo "<label for='destinatario'>Destinatario</label>";
			 echo "<input type='text' id=destinatario' name='destinatario' placeholder='Nombre a quien va dirigido el documento'   required>";
			 echo "<label for='puesto'>Puesto</label>";
			 echo "<input type='text' id=puesto' name='puesto' placeholder='Puesto de la persona a quien va dirigido el documento'   required>"; 
			echo "</span>";			
			
			echo "<label for='asunto'>Asunto</label>";
			echo "<input type='text' id=asunto' placeholder='Asunto'  name='asunto'  required  >";
				
			echo "<label for='observaciones'>Observaciones</b>:";
			echo "<textarea name='observaciones'style='border-width:1px; height:20%' ></textarea>";
			echo "<input type='submit' value='Solicitar' class='Mbtn btn-default btnAlta' name='btnSolicitar'>";
		
		  echo "</form>";
	   echo " </div>";    
	echo "</div>";

	
}	
else {
	mensaje("ERROR: no tiene acceso a esta aplicacion",'./index.php?home=');
}
		
?>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php include ("./lib/body_footer.php"); ?>


 <script>
 var id=0;
function ModalSolicitar()
{
     // Obtenemos el modal 
     modal = document.getElementById("myModalaAgregar"); 
      
      //Agregamos al divconetenedor el un input que almacena el Id que seleccionó
    // document.getElementById("contenedor").innerHTML = ["<input type=hidden id=idconcepto   name=idconcepto value="+id+">"]; 
      
     // Get the <span> element that closes the modal  
      span = document.getElementsByClassName("close")[0];        
     
    
     //Hacer visible el modal
      modal.style.display = "block";
     
     // When the user clicks on <span> (x), close the modal
     span.onclick = function() 
     {
      
       modal.style.display = "none";
     }
}
        $(document).on("change", "#departamento", function(event) {
     
		//alert($("#departamento option:selected").val());
		ShowDestinatario($("#departamento option:selected").val());
        });   

function ShowDestinatario(id) 
{
 
  if (id=="") {
    document.getElementById("spanDestinatario").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("spanDestinatario").innerHTML=this.responseText;
     
    }
  }
  xmlhttp.open("GET","cp_consultaDestinatario.php?id="+id,true);
  xmlhttp.send();
}

function mostrarDepartamento(){
	if (turnar.checked == true){
		$("#turnarDpto").css({'display':'inline-block',});
	}else{
		$("#turnarDpto").css({'display':'none',});
	}
  
}

function mostrarFechaTermino(){

	if (fechaTer.checked == true){
		$("#divfechaTermino").css({'display':'inline-block',});
	}else{
		$("#divfechaTermino").css({'display':'none',});
	}

}

function mostrarFechaTerminoModal(id){
	
	nom= document.getElementById('fechaTer'+id);
	if (nom.checked == true){
		$("#divfechaTermino"+id).css({'display':'inline-block',});
	}else{
		$("#divfechaTermino"+id).css({'display':'none',});
	}

}

function quitarFechaTermino(id){

nom= document.getElementById('fechaTer'+id);
if (nom.checked == true){
	
	$("#divfechaTermino"+id).css({'display':'none',});
	document.getElementById("fechaTermino"+id).value="";
	
}else{
	$("#divfechaTermino"+id).css({'display':'inline-block',});
}


}

//***aqui para validar campos */
function validar_numeros(string) {
    for (var i=0, output='', validos="1234567890"; i<string.length; i++)
       if (validos.indexOf(string.charAt(i)) != -1)
          output += string.charAt(i)
    return output;
} 

</script>