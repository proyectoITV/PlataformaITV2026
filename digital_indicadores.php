<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>




<?php
//mensaje_mantenimiento($nitavu, 'index.php');

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap41"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	xd_update('ap41',$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion [ap41], para ver indicadores sobre digitalizacion ");
	


echo "<div id='indicadores'>";


if (isset($_GET['m']))
{	
	if ($_GET['m']=="")	
	{
	
	$totales=0; $c=0; $c2=0; $c3=0;
	$digitalizados=0; $data2="";
	$data="['Delegaciones','Contratos','solicitudes','Digitalizados'],";			
	$sql="select DISTINCT del from cat_municipios order by del";$r= $conexion -> query($sql); while($del = $r -> fetch_array())
	{
		$delegacion_nombre = delegacion_id($del['del']);				
		$sqlx = "SELECT count(*) as n from contratos WHERE IdDelegacion='".$del['del']."'";
		$rc= $conexion -> query($sqlx);	if($f = $rc -> fetch_array())
		{ $c= $f['n']; } else {$c=0;}
		
		//$totales= $totales + $c;
		//$data=$data."['".$delegacion_nombre."', ".$c."],";


		$sqlx2 = "SELECT count(*) as n from solicitudes WHERE IdDelegacion='".$del['del']."'";
		$rc2= $conexion -> query($sqlx2);	if($f2 = $rc2 -> fetch_array())
		{ $c2= $f2['n']; } else {$c2=0;}
		
		$totales= $totales + $c2; //LA META TOTAL LA BASAMOS SOBRE SOLICITUDES
		//$data=$data."['".$delegacion_nombre."', ".$c.", ".$c2."],";



		$sqlx3 = "select count(DISTINCT folio) as n  from digital_itavu  where delegacion='".$del['del']."'";
		$rc3= $conexion -> query($sqlx3);	if($f3 = $rc3 -> fetch_array())
		{ $c3= $f3['n']; $digitalizados = $digitalizados + $c3;} else {$c3=0;}		
		//$totales= $totales + $c3;
		$data=$data."['".$delegacion_nombre."', ".$c.", ".$c2.", ".$c3."],";
		
		//select count(DISTINCT folio) as n  from digital_itavu  where delegacion=6



	}// while delegaciones

	}// fn m=""
	else {

	$totales=0; $c=0; $c2=0; $c3=0;
	$digitalizados=0; $data2="";
	$data="['Delegaciones','Contratos','solicitudes','Digitalizados'],";			
	$sql="select * from cat_municipios where IdMunicipio='".$_GET['m']."'";$r= $conexion -> query($sql); while($del = $r -> fetch_array())
	//echo $sql;	
	{
		$delegacion_nombre = delegacion_id($del['del']);				
		$sqlx = "SELECT count(*) as n from contratos WHERE IdDelegacion='".$del['del']."'";
		$rc= $conexion -> query($sqlx);	if($f = $rc -> fetch_array())
		{ $c= $f['n']; } else {$c=0;}
		
		//$totales= $totales + $c;
		//$data=$data."['".$delegacion_nombre."', ".$c."],";


		$sqlx2 = "SELECT count(*) as n from solicitudes WHERE IdDelegacion='".$del['del']."'";
		$rc2= $conexion -> query($sqlx2);	if($f2 = $rc2 -> fetch_array())
		{ $c2= $f2['n']; } else {$c2=0;}
		
		$totales= $totales + $c2; //LA META TOTAL LA BASAMOS SOBRE SOLICITUDES
		//$data=$data."['".$delegacion_nombre."', ".$c.", ".$c2."],";



		$sqlx3 = "select count(DISTINCT folio) as n  from digital_itavu  where delegacion='".$del['del']."'";
		$rc3= $conexion -> query($sqlx3);	if($f3 = $rc3 -> fetch_array())
		{ $c3= $f3['n']; $digitalizados = $digitalizados + $c3;} else {$c3=0;}		
		//$totales= $totales + $c3;
		$data=$data."['".$delegacion_nombre."', ".$c.", ".$c2.", ".$c3."],";
		
	}


	}
}// fin m


	$data =   trim($data, ',');
	//$data2 =   trim($data2, ',');
	$grafica = "
    <script type='text/javascript'>
     google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([

				    ".$data."
				     
				
				     ]);

       var options = {
          title: 'Progreso de los Documentos a Digitalizar ".municipio_nombre($_GET['m'])."',
          hAxis: {title: 'Delegaciones',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
         
          animation: {
          duration: 1500,
          easing: 'out',
          startup: true
      		}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);

      }
    </script>
	<div id='chart_div' ></div>

				";
	//style='width: 80%; height: 500px; padding:0px; margin:0px; display:inline-block;'

	$digifaltantes= $totales - $digitalizados;
	$data2= $data2."

	      ['Digitalizados', 'Pendientes por Digitalizar'],
          ['Digitalizados',     $digitalizados],
          ['Pendientes',      $digifaltantes]";
        

		 

	$grafica2 = "
    <script type='text/javascript'>
     google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([

				    ".$data2."
				     
				
				     ]);

       var options = {
          title: 'Progreso de la Meta',
          hAxis: {title: 'Progreso de la Digitalizacion ".municipio_nombre($_GET['m'])."',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
          legend: {position: 'top', maxLines: 2},
           animation: {
          duration: 1000,
          easing: 'out',
          startup: true
      		}


        };
        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));

        
        chart.draw(data, options);

      }
    </script>
	<div id='chart_div2' ></div>

				";

	echo  $grafica.$grafica2; //grafica top de visitas
	echo "<hr>";
	echo "<b class='tgrande normal'>".$totales." documentos por digitalizar. </b>";
	echo "<b class='tgrande ajecutandose'>".$digitalizados." documentos digitalizados</b>";


echo "</div>";

}else {mensaje("No tiene acceso a esta aplicacion",'');}


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