<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap06"; //ap06=Permisos de Aplicacion

if (sanpedro('ap06', $nitavu)==TRUE){
	xd_update('ap06',$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion, para dar permisos de acceso a las aplicaciones de la plataforma [ap06]");
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
echo "<br>";
	echo '  <div id="beta_buscar">';		
	echo '<table border="0" width="100%"><tr>';
		echo '<td>';
		if (isset($_GET['q'])){
			$search = VarClean($_GET['q']);
		} else {
			$search = "";
		}

		echo ' <input style="border: none; background: none; font-size: 18pt;
		padding-left: 13px;" required="required" type="text" name="q" id="q" value="'.$search.'" >';
		
		echo '</td>';
		echo '<td align="right" width="15px">                    
		<button id="beta_buscar_boton" onclick="Buscar();" style="margin-top: 3;
		margin-right: 5;">
		<img  src="icon/buscar.png"></button>
		</td>';
	echo '</tr></table>';
echo ' </div>';


echo "<center>";
echo "<div id='Resultado' style='width:90%;'>";           
echo "</div>";
echo "</center>";

		if (isset($_GET['nitavu'])){
			//usuario seleccionado
			
			$UsuarioSeleccionado = $_GET['nitavu']; if (ValidaVAR($UsuarioSeleccionado)==TRUE){$UsuarioSeleccionado = LimpiarVAR($UsuarioSeleccionado);} else {$UsuarioSeleccionado = "";}

			// echo "
			// <script>
			// function ActApps(){   
			// $('#preloader').show();
			// $.ajax({
			// 	url: 'data_appspermisos1.php',
			// 	type: 'post',			
			// 	data: {nitavu: '".$UsuarioSeleccionado."'},
			// 	success: function(data){
			// 	$('#UserApps').html(data);
			// 	$('#preloader').hide();
			// 	}
			// });
			
			// }


			// function Permiso(IdApp,Nivel){   
			// 	$('#preloader').show();
			// 	$.ajax({
			// 		url: 'data_appspermisos2.php',
			// 		type: 'post',			
			// 		data: {nitavu: '".$UsuarioSeleccionado."',IdApp:IdApp, Nivel:Nivel},
			// 		success: function(data){
			// 		$('#UserApps').html(data);
			// 		$('#preloader').hide();
			// 		}
			// 	});
				
			// 	}
			// </script>
			// ";
			$sql="
			select 
				a.icono,
				a.idapp as IdApp,
				a.nombre as App,
				a.descripcion as AppDescripcion,
				ifnull((select nivel from aplicaciones_permisos where idapp = a.idapp and nitavu='".$UsuarioSeleccionado."' limit 1),'0') as NivelDeAcceso,
				a.*

			from aplicaciones a where estado = 0 order by nombre
			";
			
			$r = $conexion -> query($sql);
			//echo $sql;
			//<h3>Aplicaciones de la Plataforma</h3><br>
			echo "
			<div class='' id='UserApps'><br>
			
		

		<center><h4  style='text-transform: uppercase;'>".nitavu_nombre($UsuarioSeleccionado)."</h4></center>
			
			
			";
			// while($f = $r -> fetch_array()){
			// 	if ($f['NivelDeAcceso']>0){ //Tiene Acceso
			// 		echo "<tr style='background-color:green;'>";
			// 	} else {
			// 		echo "<tr style=''>";
			// 	}
				
			// 	echo "<td><img title='IdApp=".$f['IdApp']."' src='icon/".$f['icono']."' style='width:40px;'></td>";
			// 	echo "<td><b style='font-size:12pt;'>".$f['App']."</b><br><cite>".$f['AppDescripcion']."<br>Nivel:".$f['NivelDeAcceso']."</cite></td>";
			// 	echo "<td valign=middle align=right >";
			// 	if ($f['NivelDeAcceso']>0){ //Tiene Acceso
					


			// 		echo "<img src='icon/NotAccess.png'
			// 		title='Haga click aquí para retirar el acceso a esta aplicacion'
			// 		style='cursor:pointer;width:40px;'
			// 		onclick='Script_".$f['IdApp']."();'
					
			// 		>";


			// 		//Script especial de borrado Script_IdApp
			// 		echo "<script>
			// 		function Script_".$f['IdApp']."(){   
			// 			$('#preloader').show();
			// 			$.ajax({
			// 				url: 'data_appspermisos2.php',
			// 				type: 'post',			
			// 				data: {IdUser: '".$UsuarioSeleccionado."',IdApp:'".$f['IdApp']."', Nivel:0, nitavu:'".$nitavu."'},
			// 				success: function(data){
			// 				$('#R').html(data);
			// 				$('#preloader').hide();
			// 				}
			// 			});
						
			// 			}
					
			// 		</script>
			// 		";

			// 		echo "<br><cite style='color:gray;'>".$f['admin_comentario']."</cite>";
			// 	}



			// 	else {//Sin Acceso
					
			// 		echo "<div id='Nivel_".$f['IdApp']."_Value' style='
			// 		color: #397cb0;
					
			// 		font-size:11pt;
			// 		width: 68px;
			// 		border-radius: 5px;
			// 		text-align: left;
			// 		' title='Nivel Seleccionado'>0</div>";
			// 		echo "<input title='Seleccione un nivel' value='1' type='range'  min='1' max='4' list='tickmarks' id='Nivel_".$f['IdApp']."' placeholder='Nivel' 
			// 			style='width:50px; height:40px;'
			// 			oninput='Niv".$f['IdApp']."();'>";

					

			// 		echo "<img src='icon/Access.png' style='
			// 		width:40px;
			// 		cursor:pointer;
			// 		' title='Haga clic aquí para otorgar acceso, No olvide seleccionar el nivel!'
			// 		onclick='Script_A_".$f['IdApp']."();'
			// 		>";
			// 		echo "<br><cite style='color:gray;'>".$f['admin_comentario']."</cite>";


			// 		echo '
			// 		<script>
			// 		function Niv'.$f['IdApp'].'(){
			// 			var slider = document.getElementById("Nivel_'.$f['IdApp'].'");
			// 			var output = document.getElementById("Nivel_'.$f['IdApp'].'_Value");
						
			// 			$("#Nivel_'.$f['IdApp'].'_Value").html($("#Nivel_'.$f['IdApp'].'").val());
			// 			console.log("clickme =  " + $("#Nivel_'.$f['IdApp'].'").val());
			// 		}
			// 		</script>';

			// 		echo "
			// 		<script>
			// 		function Script_A_".$f['IdApp']."(){   
			// 			var Nivel = $('#Nivel_".$f['IdApp']."').val();

			// 			$('#preloader').show();
			// 			$.ajax({
			// 				url: 'data_appspermisos2.php',
			// 				type: 'post',			
			// 				data: {IdUser: '".$UsuarioSeleccionado."',IdApp:'".$f['IdApp']."', Nivel:Nivel, nitavu:'".$nitavu."'},
			// 				success: function(data){
			// 				$('#R').html(data);
			// 				$('#preloader').hide();
			// 				}
			// 			});
						
			// 			}
					
					
			// 		</script>
										
					
			// 		";
			// 	}
			// 	echo "</td>";
				
			// 	echo "</tr>";

			// }
			// echo "</table>






			echo "<br>";
			echo "<center>"; 
			echo "<div id='bloque' style='width: 80%;' >";   
			echo "<div style='display: inline-block;    width: 40%;     vertical-align: top;' >"; 
			 echo "<h4 style='font-size:12pt; color: #990000; font-weight: bold;'>APLICACIONES DE LA PLATAFORMA:</h4>";   
			echo "</div>";
			
			echo "<div style='display: inline-block;    width: 40%;     vertical-align: top;'  >"; 
			 echo "<h4 style='font-size:12pt; color: #990000; font-weight: bold;'>APLICACIONES A LAS QUE TIENE ACCESO:</h4>";   
			echo "</div>";  
			echo "</div>"; 
			echo "<div  id='preloaderbloque' name='preloaderbloque' class='custom-loader' style='display:none;' ></div>";
				echo "<div class='list' id='aplicaciones' style='height:auto;width: 30%;'>";     
						echo "<ul class='empleados'>";
					$query = "select 	 a.* from aplicaciones as a  where 
						a.idapp NOT IN
						(
							SELECT aplicaciones_permisos.idapp
							FROM aplicaciones_permisos
							WHERE nitavu = ".$UsuarioSeleccionado."
						) and a.estado=0 order by nombre asc ";

				//echo $query ;
						$r = $conexion -> query($query);
						while($f = $r -> fetch_array())
					{ // resultado de la busqueda.................   
						echo " <article>"; 
						echo "<li id='".$f['idapp']."_".$UsuarioSeleccionado."' onclick=AgregarPermiso('".$f['idapp']."','".$UsuarioSeleccionado."'); >";
						
						echo " <table style='width:100%'><tr><td style='width: 80%;'>
						<span class='tchico normal'>".strtoupper($f['nombre'])."</span><br>	";
						if (!empty($f['admin_comentario']))
						{

							//."_".$UsuarioSeleccionado
						echo "<p>
						<label style='font-size:8pt;' for='temp1'>Nivel:</label>
						<input type='range' id='nivel_".$f['idapp']."'  name='nivel_".$f['idapp']."' value='1'  list='values'  min='1' max='5' title='Seleccione un nivel' id='Nivel_".$f['idapp']."'  style='width:60px; Opacity:1; position:relative;'/>
						
						</p> 
					  <cite style='color:gray; font-size:8pt;'>".$f['admin_comentario']."</cite>
					<datalist id='values'>
					<option value='1' label='1'></option>
					<option value='2' label='2'></option>
					<option value='3' label='3'></option>
					<option value='4' label='4'></option>
					</datalist>";
					
					
						}
						
				echo "</td><td class='tchico' style='width: 20%; text-align: center;'>
						<img src='icon/entrar2.png' class='icono' title='Agregar a permiso' style='width: 30px; height:30px;'>
						
						</td></tr></table> </li></article>";
						// echo "<input title='Seleccione un nivel'  type='range'   list='tickmarks'  placeholder='Nivel' 
						// style='width:50px; height:40px;'
						// oninput='Niv".$f['idapp']."();'>";



	


					}        
						echo "</ul>";  
				echo "</div>";
			  
				
				  echo "<div class='list' id='aplicaciones' style='height:auto; width: 30%;'>";
					echo "<ul class='colaboradores'>";  
					  
					$query = "select * from aplicaciones  where 
						aplicaciones.idapp  IN
						(
							SELECT aplicaciones_permisos.idapp
							FROM aplicaciones_permisos
							WHERE nitavu = ".$UsuarioSeleccionado."
						) and aplicaciones.estado=0 order by nombre asc ";
						//echo $query ;
					   $r = $conexion -> query($query);
					 	while($f = $r -> fetch_array())
					 	{ // resultado de la busqueda.................      
					   
							echo " <article>"; 
							echo "<li id='".$f['idapp']."_".$UsuarioSeleccionado."' onclick=QuitarPermiso('".$f['idapp']."','".$UsuarioSeleccionado."'); >";
						   
							echo"<table style='width:100%'><tr><td class='tchico' style='width: 20%; text-align: center;'>
						   <img src='icon/atras2.png' class='icono' title='Quitar permisos' style='width: 30px; height:30px;'>
						   </td><td style='width: 80%;'>
						  <span class='tchico normal'>".strtoupper($f['nombre'])."</span>
						
						  </td></tr></table>";
					echo "</li></article>";
					 	}        
					echo "</ul>"; 
				echo "</div>";
				echo "<center>";

		}


}
else{ Mensaje("ERROR No tiene acceso a ".$id_aplicacion,"");}











?>

<script>

	
function Buscar(){   
	$('#preloader').show();
	search = $('#q').val();
	$.ajax({
	url: 'aplicaciones_permisos_dat.php',
	type: 'post',			
	data: {search:search},
	success: function(data){
	$('#Resultado').html(data);
	$('#preloader').hide();
	}
	});

}

function BuscarApp(){   
	$('#preloader').show();
	search = '<?php if (isset($_GET['idapp'])){echo $_GET['idapp'];} ?>';
	$.ajax({
	url: 'aplicaciones_permisos_dat2.php',
	type: 'post',			
	data: {search:search},
	success: function(data){
	$('#Resultado').html(data);
	$('#preloader').hide();
	}
	});

}

function AgregarPermiso(idapp,usuario){   
   $("#preloaderbloque").css({'display':'inline-block',});
   $("#bloque1").css({'display':'none'});
   nivel="1";
   variable = "nivel";
   variable=variable.concat("_", idapp);
   //nivel=document.getElementById(variable).value;
 

   if (document.getElementById(variable) !== null) {
    nivel=document.getElementById(variable).value;
   }
else {
	nivel="0";
}
   
  
	
  $.ajax({
    async:true,    
    cache:false,   
    dataType:"html",
    url: "permisos2.php",
    type: "post",   
    data: { idapp: idapp,nitavu: usuario ,nitavu1: <?php echo $nitavu; ?>,accion:"add",nivel:nivel},
    success: function(data){
//	alert(data);
	$("#preloaderbloque").css({'display':'none'});
     $("#bloque1").css({'display':'inline-block'});    
     $('#bloque1').html(data+"\n");

    
    location.reload();

      
    }
  });
}
function QuitarPermiso(idapp,usuario){   

	nivel="0";
 $("#preloaderbloque").css({'display':'inline-block',});
 $("#bloque1").css({'display':'none'});
$.ajax({
 
  url: "permisos2.php",
 type: "post", 

 data: { idapp: idapp,nitavu: usuario,nitavu1: <?php echo $nitavu; ?>,accion:"delete" ,nivel:nivel},
 success: function(data){
	//alert(data);
  console.log("entroquitae");
  $("#preloaderbloque").css({'display':'none'});
  $("#bloque1").css({'display':'inline-block'});
  $('#bloque1').html(data+"\n");
  location.reload();
  

 }
});}



<?php
if (isset($_GET['idapp'])){
		echo "BuscarApp();";
} else {
	if (isset($_GET['nitavu'])){

	} else {
	echo "Buscar();";
	}
}


?>

</script>



<?php
include ("./lib/body_footer.php");
?>








