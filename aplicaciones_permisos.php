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

			echo "
			<script>
			function ActApps(){   
			$('#preloader').show();
			$.ajax({
				url: 'data_appspermisos1.php',
				type: 'post',			
				data: {nitavu: '".$UsuarioSeleccionado."'},
				success: function(data){
				$('#UserApps').html(data);
				$('#preloader').hide();
				}
			});
			
			}


			function Permiso(IdApp,Nivel){   
				$('#preloader').show();
				$.ajax({
					url: 'data_appspermisos2.php',
					type: 'post',			
					data: {nitavu: '".$UsuarioSeleccionado."',IdApp:IdApp, Nivel:Nivel},
					success: function(data){
					$('#UserApps').html(data);
					$('#preloader').hide();
					}
				});
				
				}
			</script>
			";
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
			echo "
			<div class='' id='UserApps'>
			<h3>Aplicaciones de la Plataforma</h3>
			<h4>".nitavu_nombre($UsuarioSeleccionado)."</h4>
			
			
			<table class='tabla ' >";
			while($f = $r -> fetch_array()){
				if ($f['NivelDeAcceso']>0){ //Tiene Acceso
					echo "<tr style='background-color:green;'>";
				} else {
					echo "<tr style=''>";
				}
				
				echo "<td><img title='IdApp=".$f['IdApp']."' src='icon/".$f['icono']."' style='width:40px;'></td>";
				echo "<td><b style='font-size:12pt;'>".$f['App']."</b><br><cite>".$f['AppDescripcion']."<br>Nivel:".$f['NivelDeAcceso']."</cite></td>";
				echo "<td valign=middle align=right >";
				if ($f['NivelDeAcceso']>0){ //Tiene Acceso
					


					echo "<img src='icon/NotAccess.png'
					title='Haga click aquí para retirar el acceso a esta aplicacion'
					style='cursor:pointer;width:40px;'
					onclick='Script_".$f['IdApp']."();'
					
					>";


					//Script especial de borrado Script_IdApp
					echo "<script>
					function Script_".$f['IdApp']."(){   
						$('#preloader').show();
						$.ajax({
							url: 'data_appspermisos2.php',
							type: 'post',			
							data: {IdUser: '".$UsuarioSeleccionado."',IdApp:'".$f['IdApp']."', Nivel:0, nitavu:'".$nitavu."'},
							success: function(data){
							$('#R').html(data);
							$('#preloader').hide();
							}
						});
						
						}
					
					</script>
					";

					echo "<br><cite style='color:gray;'>".$f['admin_comentario']."</cite>";
				}



				else {//Sin Acceso
					
					echo "<div id='Nivel_".$f['IdApp']."_Value' style='
					color: #397cb0;
					
					font-size:11pt;
					width: 68px;
					border-radius: 5px;
					text-align: left;
					' title='Nivel Seleccionado'>0</div>";
					echo "<input title='Seleccione un nivel' value='1' type='range'  min='1' max='4' list='tickmarks' id='Nivel_".$f['IdApp']."' placeholder='Nivel' 
						style='width:50px; height:40px;'
						oninput='Niv".$f['IdApp']."();'>";

					

					echo "<img src='icon/Access.png' style='
					width:40px;
					cursor:pointer;
					' title='Haga clic aquí para otorgar acceso, No olvide seleccionar el nivel!'
					onclick='Script_A_".$f['IdApp']."();'
					>";
					echo "<br><cite style='color:gray;'>".$f['admin_comentario']."</cite>";


					echo '
					<script>
					function Niv'.$f['IdApp'].'(){
						var slider = document.getElementById("Nivel_'.$f['IdApp'].'");
						var output = document.getElementById("Nivel_'.$f['IdApp'].'_Value");
						
						$("#Nivel_'.$f['IdApp'].'_Value").html($("#Nivel_'.$f['IdApp'].'").val());
						console.log("clickme =  " + $("#Nivel_'.$f['IdApp'].'").val());
					}
					</script>';

					echo "
					<script>
					function Script_A_".$f['IdApp']."(){   
						var Nivel = $('#Nivel_".$f['IdApp']."').val();

						$('#preloader').show();
						$.ajax({
							url: 'data_appspermisos2.php',
							type: 'post',			
							data: {IdUser: '".$UsuarioSeleccionado."',IdApp:'".$f['IdApp']."', Nivel:Nivel, nitavu:'".$nitavu."'},
							success: function(data){
							$('#R').html(data);
							$('#preloader').hide();
							}
						});
						
						}
					
					
					</script>
										
					
					";
				}
				echo "</td>";
				
				echo "</tr>";

			}
			echo "</table>
			</div>
			";
	

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