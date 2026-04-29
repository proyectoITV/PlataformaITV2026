<?php 
include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 

?>




<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap36"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
historia ($nitavu,"Entro a ver las Reservas Territoriales (app: ".$id_aplicacion.")");

	echo "<div id='kmz'>";
	//echo $nivel;

	if ($_GET['m']=="") {// si no se ha seleccionado el municipio mostrar lista de actualizacion y png
		echo "<img src='img/reservat.png'>";
		echo "<div id='kmz_str'>";
		$sql2="SELECT * FROM cat_municipios";
		$r2 = $conexion -> query($sql2);
		$m_X=0;
		$m_t=0;
		$m_X_tmp="";
		while($m = $r2 -> fetch_array())
		{
		$archivo = "kmz/".$m['IdMunicipio'].".kmz";
			if (file_exists($archivo)){
			//	echo "<span class=''>[".$m['IdMunicipio']."]".$m['nombre']."</span><br>";
				$m_t = $m_t +1;
			}
			else 
			{
				$m_X_tmp= $m_X_tmp."<span class='alerta'>".$m['nombre']."</span>, ";
				$m_X= $m_X + 1;
			}
		}

		if ($m_X_tmp<>""){
			echo "Faltan ".$m_X." municipos sin reservas, o  por actualizar:<br>".$m_X_tmp;
		}
		echo "</div>";


		echo "
    <script type='text/javascript'>
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([

          ['Reservas',".$m_t."],
          ['Sin Reserva',".$m_X."]
          
          
          
        ]);

        // Set chart options
        var options = {'title':'Grafica de Reservas en Tamaulipas',
                       'width':350,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
	<div id='grafica'><div id='chart_div'></div></div>

		";



	}
	else {
		$intento="";
		$archivo = "kmz/".$_GET['m'].".kmz";		
		if (file_exists($archivo)){$intento="SI";}
		
		$archivo2 = "kmz/".$_GET['m'].".kml";		
		if (file_exists($archivo2)){$intento="SI"; $archivo = $archivo2;}

		if (isset($_GET['aeropuerto'])){
			$aero="var ctaLayer2 = new google.maps.KmlLayer({url:'https://plataformaitavu.tamaulipas.gob.mx/kmz/aeropuerto.kmz',map: map});";
		} else {
			$aero="var ctaLayer = new google.maps.KmlLayer({url:'https://plataformaitavu.tamaulipas.gob.mx/".$archivo."',map: map});";
		}

		if ($intento == "SI"){
			historia ($nitavu,"Entro a ver las Reservas Territoriales del municipio de ".municipio_nombre($_GET['m'])." (app: ".$id_aplicacion.")");

			echo "<div id='mapa_kmz'></div>";	
			echo "
			<script>
			function initMap() {
			var map = new google.maps.Map(document.getElementById('mapa_kmz'), {	
				zoom: 11,

				center: {lat: 41.876, lng: -87.624 }
			});
			
			".$aero."
			
			
			console.log(ctaLayer);
			}
			</script>

			

			<br><br>
			<a href='kmz.php?m=' class='Mbtn btn-default'>Regresar</a>
			<a href='kmz_reg.php?m=".$_GET['m']."' class='Mbtn btn-default'>Ver Regularizado</a>
			";

			echo "
			<script src='https://maps.googleapis.com/maps/api/js?key=".$key_mapkmz."&callback=initMap'
			async defer></script>";

			if (isset($_GET['aeropuerto'])){
				echo  "<a href='kmz.php?m=".$_GET['m']."' class='Mbtn btn-cancel'>Quitar Proyecto Aeropuerto</a>";
			} else {
				echo  "<a href='kmz.php?m=".$_GET['m']."&aeropuerto=' class='Mbtn btn-secundario' style='color:white;'>Ver Proyecto Aeropuerto</a>";
			}
			
			

			
		} else {
			historia ($nitavu,"Entro a ver las Reservas Territoriales del municipio de ".municipio_nombre($_GET['m'])." Sin encontrar resultados (app: ".$id_aplicacion.")");
			echo "<b class='alerta'>Aun no cuenta con reserva o no se ha actualizado la informacion</b>";
		}

		if ($nivel=='02'){
			//echo $nivel;
			echo '
			<div>
				<h1>CONFIGURACION KMZ</h1>
				<label class="normal"> Esta autorizado para importar el archivo .kmz a la plataforma, y asi actualizar los datos </label>
				<form action="kmz.php?m='.$_GET['m'].'" method="POST" enctype="multipart/form-data">
				<div>
					<label>ID del Municipio</label>			
					<input type="text" value="'.municipio_nombre($_GET['m']).'" readonly="readonly" name="id">
				</div>
				
				<div>
					<label>Tipo de Archivo</label>			
					<select name="tipo">
					<option value="kmz" selected="selected">.KMZ</option>
					<option value="kml">.KML</option>

					</select>
				</div>


				<div>
					<label>* Preste especial atencion al seleccionar el archivo correspondiente, ya que se reescribiran datos del municipio</label>			
					<input type="file" value="Importar" name="file_kmz" required="required"  accept=".kmz, .kml">
				
				</div>

				<div>
					<label>* Preste especial atencion al seleccionar el archivo correspondiente, ya que se reescribiran datos del municipio</label>			
					<input type="submit" name="submit_importar" value="Importar" class="Mbtn btn-default">
				
				</div>
				</form>

			</div>';

			if(isset($_POST['submit_importar'])){
				echo "<b class='ejecutandose'>Si no se ve, por favor vuelva a cargar la pagina</b>";
				if ($_POST['tipo']=="kmz"){
						$target_path = "kmz/".$_GET['m'].'.'.'kmz';
				} else {$target_path = "kmz/".$_GET['m'].'.'.'kml';}

				if(move_uploaded_file($_FILES['file_kmz']['tmp_name'], $target_path))
				{ 
					historia ($nitavu,"Actualizo el archivo KMZ de las Reservas Territoriales del municipio de ".municipio_nombre($_GET['m'])." (app: ".$id_aplicacion.")");
					mensaje ("Se ha importado correctamente el archivo KMZ de ".municipio_nombre($_GET['m'])."",'kmz.php?m=');
				} 
				else{
					historia ($nitavu,"Intento actualizar y marco un ERROR las Reservas Territoriales del municipio de ".municipio_nombre($_GET['m'])." (app: ".$id_aplicacion.")");
					mensaje ("Hubo un error al subir el archivo KMZ de ".municipio_nombre($_GET['m']).", por favor intentenlo nuevamente. Si persite el error, llame a Soporte.",'kmz.php?m=');
				}

			}
		}
		}

	echo "</div>";//kmz




}
else
{
	mensaje("No tiene acceso a esta aplicacion",'');
}

?>

   

<section id="municipios_seleccion">

<div id='municipios'> 
<h4>Municipios: </h4>
<?php //LISTA DE MUNICIPIOS

$sql2="SELECT * FROM cat_municipios order by Municipio ASC";
$r2 = $conexion -> query($sql2);
$seleccionados="";

	if (isset($_GET['mm'])){ // si hay seleccionado un MULTIPLE municipio
			$municipios_select = explode(",", $_GET['mm']);
			$municipios_n = count($municipios_select);
			//echo "Cuantos: " . $municipios_n."<br>";		
			$municipios_n2 = $municipios_n -1;
	}
	while($df = $r2 -> fetch_array())
	{//$df recorre la lista de las delegaciones
		echo "<div>";
		
		if (isset($_GET['mm'])){ // si hay seleccionado un MULTIPLE municipio
		for ($i = 0; $i <= $municipios_n2; $i++) {			
			if ($municipios_select[$i]==$df['IdMunicipio']){	
					echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipio_resaltado'>".$df['nombre']."</a>";	
					$seleccionados = $df['IdMunicipio'].",";
					//break;
			}
		}//for

		$seleccionados_ = explode(",", $seleccionados);$seleccionados_n = count($seleccionados_);			
		$seleccionados_n2 = $seleccionados_n -1;		
		for ($i = 0; $i <= $seleccionados_n2; $i++) {			
			{
				if ($seleccionados_[$i]==$df['IdMunicipio']){
					//echo "=";
					break;
				}
				else {
					echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipios'>".$df['nombre']."</a>";	
					break;

				}
			}

			//echo $i;
			//echo $municipios_select[$i]."-".$df['IdMunicipio']."|";
			//	$i = $i +1;					
			
		}//for
		    

		   


		//}
		echo "</div>";

	}



		if (isset($_GET['m'])){ // si hay seleccionado un municipio
			if ($_GET['m']==$df['IdMunicipio']){	
				echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipio_resaltado'>".$df['nombre']."</a></div>";	
			}
			else {
				echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipios'>".$df['nombre']."</a></div>";	
			}

		}


	}
?>
</div>


<div id='mapa_tamaulipas'>
<svg version="1.1" id="Layer_1" data-municipio="Layer_1"  x="0px" y="0px" viewBox="0 0 325.656 665.291" enable-background="new 0 0 325.656 665.291" xml:space="preserve">
<?php //MAPA INTERACTIVO
$sql2="SELECT * FROM cat_municipios order by Municipio ASC";
$r2 = $conexion -> query($sql2);
	while($df = $r2 -> fetch_array())
	{//$df recorre la lista de las delegaciones
		echo "<a href='?m=".$df['IdMunicipio']."'>";
		echo "<path ";
		$id= "m".$df['IdMunicipio']."";

		echo  "onmouseover=".chr(34)."javascript:document.getElementById('$id').className='municipio_resaltado'".chr(34)."; "; 
		echo  "onmouseout=".chr(34)."javascript:document.getElementById('$id').className='municipios'".chr(34).";";  	

		echo "id='map".$df['IdMunicipio']."' ";


	
		if (isset($_GET['mm'])){ // si hay seleccionado un MULTIPLE municipio
		for ($i = 0; $i <= $municipios_n2; $i++) {			
			if ($municipios_select[$i]==$df['IdMunicipio']){	
				echo 'class="municipios_resalta"';

				//	echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipio_resaltado'>".$df['nombre']."</a>";	
					$seleccionados = $df['IdMunicipio'].",";
					//break;
			}
		}//for

		$seleccionados_ = explode(",", $seleccionados);$seleccionados_n = count($seleccionados_);			
		$seleccionados_n2 = $seleccionados_n -1;		
		for ($i = 0; $i <= $seleccionados_n2; $i++) {// si ya esta seleccionado poner sin seleccion		
			
				if ($seleccionados_[$i]==$df['IdMunicipio']){
					//echo "=";
					break;
				}
				else {
					echo 'class="municipios_mapa"';
					//echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipios'>".$df['nombre']."</a>";	
					break;

				}
			}//for
		}//getmm





		if (isset($_GET['m'])){ // si hay un municipio seleccionado

		if ("m".$_GET['m']=="m".$df['IdMunicipio']) {echo 'class="municipios_resalta"';} else {echo 'class="municipios_mapa"';}
		} else {echo 'class="municipios_mapa"';}{echo 'class="municipios_mapa"';}

		echo " d='".$df['data']."'>";
		echo $df['nombre'];
		echo "</path>";
		echo "</a>";
		

	}
?>
</div>


<br><br>


<script language="javascript">

function cambia(id_del_objeto,nueva_clase){
	var objeto = getElementById(id_del_objeto);
	objeto.className = nueva_clase;
	alert();
	
	//document.getElementById("divDatos").className = "nombreDeClase";
}

function notify(evt){
    var url = Aldama.target.getAttribute('data-url');
    window.open(url);
}
</script>
<?php include ("./lib/body_footer.php"); ?>
</section>