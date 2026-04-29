<?php include ("./unica/body_head.php"); include ("./unica/body_menu.php"); ?>




<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap34"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<h5>".app_detalle($id_aplicacion)."</h5>";




$total=0;
$libres=0;
$contratados=0;
$desbloquear=0;
$otro=0;

if (isset($_GET['m'])){
if ($_GET['m']<>"")	{
	
	echo $ti."<br><a class='normal' href='indicadores_suelo.php?m='>Ver Resumen de Todos</a><br>"."<label></label>"."<br>";

	//echo '</div>';
}
}// fin m



if (isset($_GET['m'])){
if ($_GET['m']=="") {//sino se especifica mostrar estadistica de todos
echo '<div id="indicadores_suelo_tabla">
	<h3>Resumen Global</h3>';
$ti="";
$delvictoria="";

		historia($nitavu,'Vio Indicadores de Suelo Resumen');
		docdigital_no(FALSE, 2);//aumenta 2 al contador de papel



		//TABLA DE ESTADO DE LOTES
		$sql="
		SELECT DISTINCT
		lotes.IdEstatus as Lot_edo_id,
	(select cat_estado_lotes_vivienda.EstatusLote from cat_estado_lotes_vivienda WHERE cat_estado_lotes_vivienda.IdEstatus = Lot_edo_id) as Estado,
	(select count(*) from lotes WHERE lotes.IdEstatus = Lot_edo_id) as Cuantos

		FROM
			lotes
		WHERE
			lotes.IdEstatus >=0
		ORDER by IdEstatus
		";


		echo "<table class='tabla'>";
		echo "<th>Id</th>";
		echo "<th>Estado</th>";
		echo "<th>Cuantos</th>";
		echo "<th></th>";

		$r= $conexion -> query($sql);	
		$data="";
		while($l = $r -> fetch_array())
		{
			echo "<tr>";
			echo "<td>".$l['Lot_edo_id']."</td>";
			echo "<td>".$l['Estado']."</td>";
			echo "<td>".$l['Cuantos']."</td>";
			echo "<td>";
				echo "<a href='indicadores_suelo2.php?m=".$_GET['m']."&edo=".$l['Lot_edo_id']."' title='De clic aqui para ver la lista del estatus correspondiente. ATENCION: La Lista puede demorar, debido a la cantidad de registros'>";
				echo "<img src='icon/min_noti.png' class='icono3'>";
				echo "</a>";
			echo "</td>";

			echo "</tr>";

			$data= $data."['".$l['Estado']."', ".$l['Cuantos']."],";
		
		}
		$data =   trim($data, ',');
		echo "</table>";

		






















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

         <?php echo $data; ?>
          
        ]);

        // Set chart options
        var options = {'title':'Grafica de Lotes',
                       
                       is3D: false,
                       'animation': {duration: 1500,easing: 'out',startup: true}
                   };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
	<div id="grafica"><div id="chart_div"></div></div>

	<?php
		//LISTA DE DOCUMENTOS
		if (isset($_GET['edo']))
		{
		echo "<hr><h3>";

		$estado = cat_edo_vivienda($_GET['edo']);
		if ($_GET['m']==''){
			echo "LISTA DE LOTES CON EDO. <b class='normal'>".$estado."</b> DE TODO EL ESTADO.";

			//TABLA DE ESTADO DE LOTES
			$sql="
			SELECT DISTINCT
			lotes.IdEstatus as Lot_edo_id,
		(select cat_estado_lotes_vivienda.EstatusLote from cat_estado_lotes_vivienda WHERE cat_estado_lotes_vivienda.IdEstatus = Lot_edo_id) as Estado,
		(select count(*) from lotes WHERE lotes.IdEstatus = Lot_edo_id) as Cuantos

			FROM
				lotes
			WHERE
				lotes.IdEstatus >=0
			ORDER by IdEstatus
			";


			echo "<table class='tabla'>";
			echo "<th>Id</th>";
			echo "<th>Estado</th>";
			echo "<th>Cuantos</th>";
			echo "<th></th>";
			echo "<th>Rev</th>";

			$r= $conexion -> query($sql);	
			$data="";
			while($l = $r -> fetch_array())
			{
				echo "<tr>";
				echo "<td>".$l['Lot_edo_id']."</td>";
				echo "<td>".$l['Estado']."</td>";
				echo "<td>".$l['Cuantos']."</td>";
				echo "<td>";
					echo "<a href='indicadores_suelo2.php?m=".$_GET['m']."&edo=".$l['Lot_edo_id']."' title='De clic aqui para ver la lista del estatus correspondiente. ATENCION: La Lista puede demorar, debido a la cantidad de registros'>";
					echo "<img src='icon/min_noti.png' class='icono3'>";
					echo "</a>";
				echo "</td>";
				echo "<td>0%</td>";
				echo "</tr>";

				$data= $data."['".$l['Estado']."', ".$l['Cuantos']."],";
			
			}
			$data =   trim($data, ',');
			echo "</table>";


		}
		else {
			echo "LISTA DE LOTES CON EDO. <b class='normal'>".$estado."</b> DE ".municipio_nombre($_GET['m']);
		}

		echo "</h3>";
}

	?>  

</div> 



 

<section id="municipios_seleccion">
<div id='municipios'> 
<h1>Municipios: </h1>
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
<?php include ("./unica/body_footer.php"); ?>
</section>