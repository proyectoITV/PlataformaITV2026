<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>




<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap34"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";




if (isset($_GET['m'])){
	if ($_GET['m']<>"")	{
	echo '<div id="indicadores_suelo_tabla"></h1>';

	echo "<h3>Resumen de ".municipio_nombre($_GET['m'])."</h3>";


	echo "<br>";
	echo "<a href='tinacos.php?m=' class='Mbtn btn-default'>Ver Resumen Global</a>";

	echo '</div>';
	}
	else {
	echo '<div id="indicadores_suelo_tabla"></h1>';
	echo "<h3>Resumen de GLOBAL </h3>";

	$sql = "SELECT * FROM cuantificaciondelcredito";
	$r2 = $conexion -> query($sql);
	echo "<table class='tabla' >";
	echo "<th>Municipio</th>";
	echo "<th class='pc'>Programa</th>";
	echo "<th>Techo Financiero</th>";
	echo "<th>Acciones Autorizadas</th>";
 echo "<th>Total de Contratos</th>";
	// echo "<th>Monto Comprometido</th>";
	// echo "<th>Acciones Comprometidas</th>";
	// echo "<th>Monto Contratos</th>";
	
	// echo "<th>Monto Impresos</th>";
	// echo "<th>Vales Impresos</th>";
	 $acciones_aut=0;
	$total_contratos=0;
	$vales=0;
	while($f = $r2 -> fetch_array())
	{//Categorias de Aplicaciones
		echo "<tr>";
			echo "<td>".municipio_nombre($f['idmunicipio'])."</td>";
			//echo "<td>".$f['nombredelprograma']."</td>";
			echo "<td class='pc'>Tinacos 2017</td>";
			echo "<td>".$f['techofinanciero']."</td>";
			echo "<td>".$f['AccionesAutorizadas']."</td>";
			echo "<td>".$f['totalcontratos']."</td>";

			// echo "<td>".$f['montocomprometido']."</td>";
			// echo "<td>".$f['accionescomprometidas']."</td>";
			// echo "<td>".$f['montocontratos']."</td>";
			
			// echo "<td>".$f['montoimpresos']."</td>";
			// echo "<td>".$f['valesimpresos']."</td>";
		echo "</tr>";

		$acciones_aut = $acciones_aut + $f['AccionesAutorizadas'];
		$total_contratos = $total_contratos + $f['totalcontratos'];
		$vales = $vales + $f['valesimpresos'];

	}
	echo "</table>";


	echo "<hr>";
	echo "<table style='width:40%; display:inline-block' border='0'><tr>";
	echo "<td><img src='img/tinaco.png' style='width:200px; display:inline-block;'></td>";
	echo "<td>";
	echo "<label>Accciones Autorizadas</label>";
	echo "<b class='ejecutandose tgrande' >".$acciones_aut." </b><br>";

	echo "<br>";
	echo "<label>Contratos</label>";
	echo "<b class='normal tgrande' >".$total_contratos." </b>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";




	//echo '</div>';
}

}





}
else
{
	mensaje("No tiene acceso a esta aplicacion",'');
}

?>

   


    <script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([

          ['Acciones Aut.', <?php echo $acciones_aut; ?>],
          ['Vales Impresos', <?php echo $vales; ?>]
          
        ]);

        // Set chart options
        var options = {'title':'Vales impresos',
                       
                       is3D: false,
                       'animation': {duration: 1500,easing: 'out',startup: true}
                   };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
	<div id="grafica"><div id="chart_div"></div></div>
</div>

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