<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:

?>

<script>

 

function OK_pase(IdPase, Nitavu){   
   
	$("#preloader_"+IdPase).css({'display':'inline-block','color':'red'});
	$("#Pase_"+IdPase).css({'display':'none','color':'gray'});
	$.ajax({
		url: "auscencia_temporal_autoriza_ok.php",
	   type: "post",
	//    data: "id="+IdPase, "nitavu=" + Nitavu
	   data: {id: IdPase, nitavu: Nitavu },
	   success: function(data){
		$("#Pase_"+IdPase).css({'display':'inline-block','color':'#FFBF00','background-color':' #FFFFBF'});
		$('#Pase_'+IdPase).html(data+"\n");
		$("#preloader_"+IdPase).css({'display':'none','color':'gray'});
	   }
	});
	
}



function X_pase(IdPase, Nitavu){   
   
   $("#preloader_"+IdPase).css({'display':'inline-block','color':'red'});
   $("#Pase_"+IdPase).css({'display':'none','color':'gray'});
   $.ajax({
	   url: "auscencia_temporal_autoriza_x.php",
	  type: "post",
   //    data: "id="+IdPase, "nitavu=" + Nitavu
	  data: {id: IdPase, nitavu: Nitavu },
	  success: function(data){
	   $("#Pase_"+IdPase).css({'display':'inline-block','color':'red','background-color':' white'});
	   $('#Pase_'+IdPase).html(data+"\n");
	   $("#preloader_"+IdPase).css({'display':'none','color':'gray'});
	  }
   });
   
}
</script>


  
<?php
$id_aplicacion ="ap12"; //
$nivel = aplicacion_nivel($id_aplicacion,$nitavu);
// $nivel=2;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	// echo "<div id='noticias_pases'></div>";
	
	if($nivel == 1) {//ADMINISTRADOR GENERAL: Aprueba todo--------------
		echo "<h1>Puede aprobar cualquier pase en el Instituto:</h1>";
		echo "<div id='r'>";

		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' )";	
		// echo $sql;
		$rc= $conexion -> query($sql);
		while($f = $rc -> fetch_array()) {
			//-----
			echo "<div  class='pase_elementos'>";				
			echo "<div id='preloader_".$f['id']."' style='display:none;'><img src='img/cargando2.gif' style='width:50%;'></div>";

			echo "<div id='Pase_".$f['id']."'>";
			//---

			echo "<table border='0' class='tbl_dir'><tr>";

					echo "<span class='pc'>";
						echo "<td width='1px'>";
						echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono pc');
					echo "</td>";	
					echo "</span>";

					
					echo "<td class='tipo_nombre' valing='top' align='left'>".nitavu_nombre($f['nitavu'])."<label>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</label></td>";		
					$tmp="";
					
					
					echo "<td rowspan='2' width='10px' align='right' class='tipo_menu'> ";
						
					
					echo "<button class='Mbtn btn-default' onclick=OK_pase('".$f['id']."','".$nitavu."');>";
							echo "<img src='icon/ok.png' class='mini_icono'>"; 							
					echo "</button>";


					echo "<br><br>";

					echo "<button class='Mbtn btn-cancel' onclick=X_pase('".$f['id']."','".$nitavu."');>";
							echo "<img src='icon/cancel.png' class='mini_icono'>"; 							
					echo "</button>";
				
					

					echo "</td>";
					
					echo "</tr><tr><td colspan='4'><span class='pc tmediano'>".fecha_larga($f['fecha'])." a las ".hora12($f['hora_desde']).". ID: ".$f['id'].", Asunto: ".$f['asunto'].": ".$f['justificacion']."</span></td>";

			
			echo "</tr></table>";
			echo "</div>";
			echo "</div>";
			
		}//while
		echo "</div>";

	}//end admintrador genral: aprueba todo-----------------------------


	if($nivel == 2) {//ADMINISTRADOR; Aprueba todos los titulares que dependan de el --------------
		echo "<h1>Puede aprobar pases de los titulares que dependan de ud.:</h1>";
		echo "<div id='r'>";
		//TES PARA DEPENDIENTES TANTO COMO TIULARES COMO DEMAS..
		//$sql = "SELECT * FROM empleados WHERE (dpto in(".misdptos($nitavu).")) order by dpto"; //todos los empleados que dependan de el		
		// $sql = "SELECT * FROM cat_gerarquia WHERE (id in(".misdptos('2774').")) "; //todos los titulares que dependan de el		
		// if ($conexion->query($sql) == TRUE) {
		// $rc= $conexion -> query($sql); while($fn = $rc -> fetch_array()) 
		// {

		// 	echo user_legend($fn['titular']);
			
		// }
		// }else{echo "Sin Titulares que dependan de ti";}


		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' AND dpto in(".misdptos($nitavu).") )";	
		//echo $sql;
		$rc= $conexion -> query($sql);
		while($f = $rc -> fetch_array()) {
			$tit = soytitular($f['nitavu']);
			if ($tit=='FALSE'){}//filtra solo titulares
			else{
			//-----
			echo "<div  class='pase_elementos'>";				
			echo "<div id='preloader_".$f['id']."' style='display:none;'><img src='img/cargando2.gif' style='width:50%;'></div>";

			echo "<div id='Pase_".$f['id']."'>";
			//---
			
			
			echo "<table border='0' class='tbl_dir'><tr>";

					echo "<span class='pc'>";
						echo "<td width='1px'>";
						echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono pc');
					echo "</td>";	
					echo "</span>";

					
					echo "<td class='tipo_nombre' valing='top' align='left'>".nitavu_nombre($f['nitavu'])."<label>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</label></td>";		
					$tmp="";
					
					
					echo "<td rowspan='2' width='10px' align='right' class='tipo_menu'> ";
						
					echo "<button class='Mbtn btn-default' onclick=OK_pase('".$f['id']."','".$nitavu."');>";
							echo "<img src='icon/ok.png' class='mini_icono'>"; 							
					echo "</button>";


					echo "<br><br>";

					echo "<button class='Mbtn btn-cancel' onclick=X_pase('".$f['id']."','".$nitavu."');>";
							echo "<img src='icon/cancel.png' class='mini_icono'>"; 							
					echo "</button>";
		
					

					echo "</td>";
					
					echo "</tr><tr><td colspan='4'><span class='pc tmediano'>".fecha_larga($f['fecha'])." a las ".hora12($f['hora_desde']).". ID: ".$f['id'].", Asunto: ".$f['asunto'].": ".$f['justificacion']."</span></td>";

			
			echo "</tr></table>";
			echo "</div>";
			echo "</div>";
			}
			
		}//while
		echo "</div>";




		
		//para el resto del su personal
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' AND dpto in(".misdptos($nitavu).") )";	
		//echo $sql;
		$rc= $conexion -> query($sql);
		echo "<h1>Personal que dependende de ud:</h1>";
		while($f = $rc -> fetch_array()) {
			$tit = soytitular($f['nitavu']);
			if ($tit<>'FALSE'){}//filtra solo titulares
			else{
				//-----
				echo "<div  class='pase_elementos'>";				
				echo "<div id='preloader_".$f['id']."' style='display:none;'><img src='img/cargando2.gif' style='width:50%;'></div>";
	
				echo "<div id='Pase_".$f['id']."'>";
				//---
						
			echo "<table border='0' class='tbl_dir'><tr>";

					echo "<span class='pc'>";
						echo "<td width='1px'>";
						echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono pc');
					echo "</td>";	
					echo "</span>";

					
					echo "<td class='tipo_nombre' valing='top' align='left'>".nitavu_nombre($f['nitavu'])."<label>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</label></td>";		
					$tmp="";
					
					
					echo "<td rowspan='2' width='10px' align='right' class='tipo_menu'> ";
						
					echo "<button class='Mbtn btn-default' onclick=OK_pase('".$f['id']."','".$nitavu."');>";
							echo "<img src='icon/ok.png' class='mini_icono'>"; 							
					echo "</button>";


					echo "<br><br>";

					echo "<button class='Mbtn btn-cancel' onclick=X_pase('".$f['id']."','".$nitavu."');>";
							echo "<img src='icon/cancel.png' class='mini_icono'>"; 							
					echo "</button>";
						
					

					echo "</td>";
					
					echo "</tr><tr><td colspan='4'><span class='pc tmediano'>".fecha_larga($f['fecha'])." a las ".hora12($f['hora_desde']).". ID: ".$f['id'].", Asunto: ".$f['asunto'].": ".$f['justificacion']."</span></td>";

			
			echo "</tr></table>";
			echo "</div>";
			echo "</div>";
			}
			
		}//while
		echo "</div>";





	}//end admintrador: Aprueba todos los titulares que dependan de el ---------------------------



	if($nivel == 3) {//OPERADOR; Aprueba a los que dependen de el, a nivel dpto --------------
	echo "<h1>Puede aprobar solo a tu dpto.</h1>";
		echo "<div id='r'>";
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' AND dpto='".nitavu_dpto($nitavu)."')";	
		//echo $sql;
		$rc= $conexion -> query($sql);
		while($f = $rc -> fetch_array()) {
			echo "<div  class='pase_elementos'>";				
				echo "<div id='preloader_".$f['id']."' style='display:none;'><img src='img/cargando2.gif' style='width:50%;'></div>";

				echo "<div id='Pase_".$f['id']."'>";
				echo "<table border='0' class='tbl_dir'><tr>";
						echo "<span class='pc'>";
							echo "<td width='1px'>";
							echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono pc');
						echo "</td>";	
						echo "</span>";

						
						echo "<td class='tipo_nombre' valing='top' align='left'>".nitavu_nombre($f['nitavu'])."<label>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</label></td>";		
						$tmp="";
						
						
						echo "<td rowspan='2' width='10px' align='right' class='tipo_menu'> ";
						

						echo "<button class='Mbtn btn-default' onclick=OK_pase('".$f['id']."','".$nitavu."');>";
								echo "<img src='icon/ok.png' class='mini_icono'>"; 							
						echo "</button>";


						echo "<br><br>";

						echo "<button class='Mbtn btn-cancel' onclick=X_pase('".$f['id']."','".$nitavu."');>";
								echo "<img src='icon/cancel.png' class='mini_icono'>"; 							
						echo "</button>";
						
						

						echo "</td>";

						
						
						echo "</tr><tr><td colspan='4'><span class='pc tmediano'>".fecha_larga($f['fecha'])." a las ".hora12($f['hora_desde']).". ID: ".$f['id'].", Asunto: ".$f['asunto'].": ".$f['justificacion']."</span></td>";

				
				echo "</tr></table>";
				echo "</div>";
		echo "</div>";
			
		}//while
		echo "</div>";




		// SI TIENE DPTOS QUE DEPENDAN DE EL, TAMBIEN PODRA APROBARLOS TANTO A LOS JEFES COMO A TODOS LOS QUE DEPENDAN
	
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' AND dpto in(".misdptos_sinmi($nitavu).") )";	
		//echo $sql;
		$rc= $conexion -> query($sql);
		if ($conexion->query($sql) == TRUE) {
		echo "<HR><h1>Personal de los dptos que dependen ti: </h1>";
		echo "<div id='r'>";
		while($f = $rc -> fetch_array()) {
			$tit = soytitular($f['nitavu']);
			if ($tit=='FALSE'){}//filtra solo titulares
			else{
			}

			echo "<div  class='pase_elementos'>";				
				echo "<div id='preloader_".$f['id']."' style='display:none;'><img src='img/cargando2.gif' style='width:50%;'></div>";
	
				echo "<div id='Pase_".$f['id']."'>";		
							
			echo "<table border='0' class='tbl_dir'><tr>";

					echo "<span class='pc'>";
						echo "<td width='1px'>";
						echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono pc');
					echo "</td>";	
					echo "</span>";

					
					echo "<td class='tipo_nombre' valing='top' align='left'>".nitavu_nombre($f['nitavu'])."<label>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</label></td>";		
					$tmp="";
					
					
					echo "<td rowspan='2' width='10px' align='right' class='tipo_menu'> ";
						
					echo "<button class='Mbtn btn-default' onclick=OK_pase('".$f['id']."','".$nitavu."');>";
							echo "<img src='icon/ok.png' class='mini_icono'>"; 							
					echo "</button>";


					echo "<br><br>";

					echo "<button class='Mbtn btn-cancel' onclick=X_pase('".$f['id']."','".$nitavu."');>";
							echo "<img src='icon/cancel.png' class='mini_icono'>"; 							
					echo "</button>";
					
					

					echo "</td>";
					
					echo "</tr><tr><td colspan='4'><span class='pc tmediano'>".fecha_larga($f['fecha'])." a las ".hora12($f['hora_desde']).". ID: ".$f['id'].", Asunto: ".$f['asunto'].": ".$f['justificacion']."</span></td>";

			
			echo "</tr></table>";
			echo "</div>";echo "</div>";
			
			
		}//while
		}//true whiele
		echo "</div>";



		


		

	}//end //OPERADOR; Aprueba a los que dependen de el, a nivel dpto --------------



	//Alterarlo y ponerle si tienen dptos autorizados agregarlos aut	
	if (pases_dptosaut_n($nitavu)>0){
		echo "<hr><h1 style='font-size: 9pt;'>Aut. Extraordinaria para aprobar <b>".pases_dptosaut_nombre($nitavu)."</b></h1>";
		echo "<div id='r'>";
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' AND dpto in(".pases_dptosaut($nitavu).") and nitavu<>'".$nitavu."')";	
		//echo $sql;
		$xc=0;
		if ($conexion->query($sql) == TRUE) {
		$rc= $conexion -> query($sql);
		while($f = $rc -> fetch_array()) {
			echo "<div  class='pase_elementos'>";				
				echo "<div id='preloader_".$f['id']."' style='display:none;'><img src='img/cargando2.gif' style='width:50%;'></div>";
	
				echo "<div id='Pase_".$f['id']."'>";	
						
			echo "<table border='0' class='tbl_dir'><tr>";

					echo "<span class='pc'>";
						echo "<td width='1px'>";
						echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono pc');
					echo "</td>";	
					echo "</span>";

					
					echo "<td class='tipo_nombre' valing='top' align='left'>".nitavu_nombre($f['nitavu'])."<label>".nitavu_puesto($f['nitavu'])." de ".nitavu_dpto_nombre($f['nitavu'])."</label></td>";		
					$tmp="";
					
					
					echo "<td rowspan='2' width='10px' align='right' class='tipo_menu'> ";
						
					echo "<button class='Mbtn btn-default' onclick=OK_pase('".$f['id']."','".$nitavu."');>";
							echo "<img src='icon/ok.png' class='mini_icono'>"; 							
					echo "</button>";


					echo "<br><br>";

					echo "<button class='Mbtn btn-cancel' onclick=X_pase('".$f['id']."','".$nitavu."');>";
							echo "<img src='icon/cancel.png' class='mini_icono'>"; 							
					echo "</button>";
					

					echo "</td>";
					
					echo "</tr><tr><td colspan='4'><span class='pc tmediano'>".fecha_larga($f['fecha'])." a las ".hora12($f['hora_desde']).". ID: ".$f['id'].", Asunto: ".$f['asunto'].": ".$f['justificacion']."</span></td>";

			
			echo "</tr></table>";
			echo "</div>"; echo "</div>";
			$xc = $xc +1;
		}}//while
		if (pases_dptosaut($nitavu)==''){
			sentimental("Por el momento no tiene ningun departamento autorizado");
		}
		echo "</div>";

	}//end ESPECIAL; Aprueba SEGUN LISTA autorizada de dptos ---------------------




	



}
else{echo "No tiene acceso a ".$id_aplicacion;}











?>



<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>