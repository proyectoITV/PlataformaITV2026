<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion
// $q = $_POST['q']; if (ValidaVAR($q)==TRUE){$q = LimpiarVAR($q);} else {$q = "";}
$UsuarioSeleccionado = $_POST['nitavu']; if (ValidaVAR($UsuarioSeleccionado)==TRUE){$UsuarioSeleccionado = LimpiarVAR($UsuarioSeleccionado);} else {$UsuarioSeleccionado = "";}


echo "
			
            ";
            
$sql="
			select 
				a.icono,
				a.idapp as IdApp,
				a.nombre as App,
				a.descripcion as AppDescripcion,
				ifnull((select nivel from aplicaciones_permisos where idapp = a.idapp and nitavu='".$UsuarioSeleccionado."'),'0') as NivelDeAcceso

			from aplicaciones a where estado = 0 order by nombre
			";
			
			$r = $conexion -> query($sql);
			echo "
			
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
				}else {//Sin Acceso
					
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
			
			";

?>