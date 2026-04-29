<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>




<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap34"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";




$total=0;
$libres=0;
$contratados=0;
$desbloquear=0;
$otro=0;

if (isset($_GET['m'])){
if ($_GET['m']<>"")	{
	echo '<div id="indicadores_suelo_tabla"></h1>';
	$ti="";
	$delvictoria="";
	$ti = $ti."";
	if ($_GET['m']=='13' or $_GET['m']=='16' or $_GET['m']=='20' or $_GET['m']=='30' or $_GET['m']=='34' or $_GET['m']=='36' or $_GET['m']=='41' ){
		$delvictoria = "* Estos municipios estan dentro de la delegacion Victoria, (13, 16, 20, 30, 34, 36, 41).";
		$munis_delvictoria="13, 16, 20, 30, 34, 36, 41";
		$delvictoria = $delvictoria."<a href='indicadores_suelo.php?mm=".$munis_delvictoria."' class='normal'> Ver Delegacion Victoria </a>";
	}
		$ti = $ti."<h1>Municipio <b>".municipio_nombre($_GET['m'])."</b></h1>";
		historia($nitavu,'Vio Indicadores de Suelo de '.municipio_nombre($_GET['m']));
		docdigital_no(FALSE, 2);//aumenta 2 al contador de papel

		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdMunicipio IN(".$_GET['m'].") and IdEstatus=0)"; // Victoria:Libres	
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Libres</label>".number_format($f['n'])."</div>"; $libres= $libres + $f['n'];} 
		else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}


		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdMunicipio IN(".$_GET['m'].") and IdEstatus=2)"; // Victoria:CONTRATADOS
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Contratados</label>".number_format($f['n'])."</div>"; $contratados = $contratados+$f['n'];} else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}

		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdMunicipio IN(".$_GET['m'].") and IdEstatus=19)"; // Victoria:Desbloquear
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Desbloquear</label>".number_format($f['n'])."</div>"; $desbloquear = $desbloquear+$f['n'];} else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}


		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdMunicipio IN(".$_GET['m'].") and IdEstatus not in (0,2,19))"; // Victoria:otro
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Otro</label>".number_format($f['n'])."</div>"; $otro = $otro + $f['n'];} 
		else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}

		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdMunicipio IN(".$_GET['m'].") )"; // Victoria:Total
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Total</label>".number_format($f['n'])."";
		$total = $libres + $contratados + $desbloquear + $otro;
		if ($f['n']<> $total){echo "*";}
		} else {$ti = $ti."";}
		$ti = $ti."</div>";
		

	$ti = $ti."<label>".$delvictoria."</label>";
	echo $ti."<br><a class='normal' href='indicadores_suelo.php?m='>Ver Resumen de Todos</a><br>"."<label></label>"."<br>";

	//echo '</div>';
}
}// fin m


if (isset($_GET['mm'])){
echo '<div id="indicadores_suelo_tabla"><h1></h1>';
$ti="";
$delvictoria="";
$munis_delvictoria="13, 16, 20, 30, 34, 36, 41";
$ti = $ti."";
	if ($_GET['mm']==$munis_delvictoria){
		$delvictoria = "* Estos municipios estan dentro de la delegacion Victoria, (13, 16, 20, 30, 34, 36, 41).";		
		//$delvictoria = $delvictoria."<a href='indicadores_suelo.php?mm=".$munis_delvictoria."' class='normal'> Ver Delegacion Victoria </a>";
		$ti = $ti."<h1>Delegacion <b>Victoria</b></h1>";
	}
		historia($nitavu,'Vio Indicadores de Suelo de la Del. Victoria');
		docdigital_no(FALSE, 2);//aumenta 2 al contador de papel
		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdMunicipio IN(".$_GET['mm'].") and IdEstatus=0)"; // Victoria:Libres	
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Libres</label>".number_format($f['n'])."</div>"; $libres= $libres + $f['n'];} else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}


		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdMunicipio IN(".$_GET['mm'].") and IdEstatus=2)"; // Victoria:CONTRATADOS
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Contratados</label>".number_format($f['n'])."</div>"; $contratados = $contratados+$f['n'];} else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}

		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdMunicipio IN(".$_GET['mm'].") and IdEstatus=19)"; // Victoria:Desbloquear
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Desbloquear</label>".number_format($f['n'])."</div>"; $desbloquear = $desbloquear+$f['n'];} else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}


		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdMunicipio IN(".$_GET['mm'].") and IdEstatus not in (0,2,19))"; // Victoria:otro
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Otro</label>".number_format($f['n'])."</div>"; $otro = $otro + $f['n'];} 
		else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}

		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdMunicipio IN(".$_GET['mm'].") )"; // Victoria:Total
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Total</label>".number_format($f['n'])."";
		$total = $libres + $contratados + $desbloquear + $otro;
		if ($f['n']<> $total){echo "*";}
		} else {$ti = $ti."";}
		$ti = $ti."</div>";
		

	$ti = $ti."<label>".$delvictoria."</label>";
	echo $ti."<br><a class='normal' href='indicadores_suelo.php?m='>Ver Resumen de Todos</a><br>"."<label>* Ultima Actualizacion ".fecha_larga($cuandoseactualizo)."</label>"."<br>";

	//echo '</div>';
}// fin m


if (isset($_GET['m'])){
if ($_GET['m']=="") {//sino se especifica mostrar estadistica de todos
echo '<div id="indicadores_suelo_tabla"><h1>INDICADORES DE LOTES</h1>';
$ti="";
$delvictoria="";
$ti = $ti."";
		$ti = $ti."<h1>Todos los municipios</h1>";
		historia($nitavu,'Vio Indicadores de Suelo Resumen');
		docdigital_no(FALSE, 2);//aumenta 2 al contador de papel
		
		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdEstatus=0)"; // Victoria:Libres	
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Libres</label>".number_format($f['n'])."</div>"; $libres= $libres + $f['n'];} 
		else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}


		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdEstatus=2)"; // Victoria:CONTRATADOS
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Contratados</label>".number_format($f['n'])."</div>"; $contratados = $contratados+$f['n'];} else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}

		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdEstatus=19)"; // Victoria:Desbloquear
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Desbloquear</label>".number_format($f['n'])."</div>"; $desbloquear = $desbloquear+$f['n'];} else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}


		$sql = "SELECT  count(*) as n FROM lotes WHERE (IdEstatus not in (0,2,19))"; // Victoria:otro
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Otro</label>".number_format($f['n'])."</div>"; $otro = $otro + $f['n'];} 
		else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}

		$sql = "SELECT  count(*) as n FROM lotes"; // Victoria:Total
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
		$ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Total</label>".number_format($f['n'])."";
		$total = $libres + $contratados + $desbloquear + $otro;
		if ($f['n']<> $total){echo "*";}
		} else {$ti = $ti."";}
		$ti = $ti."</div>";
		

	//$ti = $ti."<label>".$delvictoria."</label>";
	echo $ti."<br><a class='normal' href='indicadores_suelo.php?m='>Ver Resumen de Todos</a><br>"."<label></label>"."<br>";





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

          ['Libres', <?php echo $libres; ?>],
          ['Contratados', <?php echo $contratados; ?>],
          ['Desbloquear', <?php echo $desbloquear; ?>],
          ['Otro', <?php echo $otro; ?>]
          
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