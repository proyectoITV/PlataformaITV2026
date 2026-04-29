<?php include ("./unica/body_head.php"); include ("./unica/body_menu.php"); ?>




<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap38"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<h5>".app_detalle($id_aplicacion)."</h5>";
mensaje_mantenimiento($nitavu,'');
$d="";

if (isset($_GET['del'])){
	if ($_GET['del']=="") {//sino se especifica mostrar estadistica de todos
	echo '<div id="indicadores">';

			$d= $d."<span class='tenue'>Hasta el momento se ha encontrado actividad en las delegaciones ";	
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				$d= $d."<a href='indicadores_notificaciones.php?del=".$del['del']."'>".delegacion_id($del['del'])."</a>, ";

			}
			$d= trim($d, ','); //quita la ultima coma
			$d= $d.", de las cuales se obtiene en tiempo real los siguientes indicadores: <br><br> * De clic sobre el nombre de la delegacion para mostrar los indicadores solamente de dicha delegacion, o <a href='indicadores_notificaciones.php?del='>aqui para mostrar Todos nuevamente</a>.</span>";
			echo $d;

	$ti="";
	$delvictoria="";
	$ti = $ti."";
			$ti = $ti."<h1>Todos los municipios</h1>";
			historia($nitavu,'Vio Indicadores de Notificaciones Resumen (app: '.$id_aplicacion);
			docdigital_no(FALSE, 2);//aumenta 2 al contador de papel
			
			// $sql = "SELECT  count(*) as n FROM Lotes WHERE (IdEstatus=0)"; // Victoria:Libres	
			// $rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
			// $ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Libres</label>".number_format($f['n'])."</div>"; $libres= $libres + $f['n'];} 
			// else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}
			

		//$ti = $ti."<label>".$delvictoria."</label>";
		$c=0;
		$tmp=""; $tmp2="";
			$tmp2= $tmp2."['Fecha',";	
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				$tmp2= $tmp2."'".delegacion_id($del['del'])."',";

			} 

				$sql2="SELECT DISTINCT visita_fecha  as fecha FROM notificadores_visitas";
				$r2 = $conexion -> query($sql2); 
				while($a = $r2 -> fetch_array())
					{
						$tmp= $tmp."['".$a['fecha']."',";

						$sqld="SELECT DISTINCT delegacion  as del FROM notificadores_visitas";
						$rd = $conexion -> query($sql2x); 
						while($delegacion = $rd -> fetch_array())
						{
							
							$sqlx = "SELECT COUNT(*) as n FROM notificadores_visitas where visita_fecha='".$a['fecha']."' AND delegacion='".$delegacion['del']."'";
//							echo $sqlx;
							$rc= $conexion -> query($sqlx);
							if($f = $rc -> fetch_array())
								{
									$c= $f['n'];
								} else {$c=0;}

							$tmp=$tmp.$c.",";


						} //delegaciones
				$tmp=$tmp."],";

				} //fechas


				$data =   trim($tmp2, ',')."],". trim($tmp, ',')."";
				$grafica = "
    <script type='text/javascript'>
     google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([

				    ".$data."
				     
				
				     ]);

       var options = {
          title: 'Que tan rapido hemos sido, en un dia: ',
          hAxis: {title: 'Fechas',  titleTextStyle: {color: '#333'}},
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

	echo  $grafica; //grafica top de visitas
//------------------------------------------------------------------------


		$c=0;
		$t_baldio=0; $t_habitado=0; $t_construc=0; $t_rentado=0; $ubv_habiado=0; $ubv_vaciabuenestado=0;  $ubv_vaciavandalizada=0;  $ubv_rentada=0;
		$tmp=""; $tmp2="";
			$tmp2= $tmp2."['Estado del Lote',";	
			$tmp=$tmp."['Baldios', ";

			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
					$sqlx = "SELECT COUNT(DISTINCT contrato) as n FROM notificadores_visitas where id_estado_lote='1' AND delegacion='".$del['del']."'";
				
					$rc= $conexion -> query($sqlx);
					if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
					$t_baldio = $t_baldio + $c;
					$tmp=$tmp.$c.",";
					//$tmp=$tmp."],";
			}
			$tmp = trim($tmp, ',');
			$tmp=$tmp."],";


			$tmp=$tmp."['Habitados', ";
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
					$sqlx = "SELECT COUNT(DISTINCT contrato) as n FROM notificadores_visitas where id_estado_lote='3' AND delegacion='".$del['del']."'";
				
					$rc= $conexion -> query($sqlx);
					if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
					$t_habitado = $t_habitado + $c;
					$tmp=$tmp.$c.",";
					//$tmp=$tmp."],";
			}
			$tmp = trim($tmp, ',');
			$tmp=$tmp."],";



			$tmp=$tmp."['En Construc.', ";
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
					$sqlx = "SELECT COUNT(DISTINCT contrato) as n FROM notificadores_visitas where id_estado_lote='5' AND delegacion='".$del['del']."'";
					
					$rc= $conexion -> query($sqlx);
					if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
					$t_construc = $t_construc + $c;
					$tmp=$tmp.$c.",";
					//$tmp=$tmp."],";
			}
			$tmp = trim($tmp, ',');
			$tmp=$tmp."],";



			$tmp=$tmp."['Rentado.', ";
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
					$sqlx = "SELECT COUNT(DISTINCT contrato) as n FROM notificadores_visitas where id_estado_lote='4' AND delegacion='".$del['del']."'";
				
					$rc= $conexion -> query($sqlx);
					if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
					$t_rentado = $t_rentado+$c;
					$tmp=$tmp.$c.",";
					//$tmp=$tmp."],";
			}
			$tmp = trim($tmp, ',');
			$tmp=$tmp."],";



			// $tmp=$tmp."['UBV Habitada.', ";
			// $sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas";
			// $r2x = $conexion -> query($sql2x); 
			// while($del = $r2x -> fetch_array())
			// {
			// 	//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
			// 		$sqlx = "SELECT COUNT(DISTINCT contrato) as n FROM notificadores_visitas where estado_ubvhabitada='1' AND delegacion='".$del['del']."'";
				
			// 		$rc= $conexion -> query($sqlx);
			// 		if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
			// 		$ubv_habiado = $ubv_habiado + $c;
			// 		$tmp=$tmp.$c.",";
			// 		//$tmp=$tmp."],";
			// }
			// $tmp = trim($tmp, ',');
			// $tmp=$tmp."],";


			// $tmp=$tmp."['UBV Vacia Buen Estado.', ";
			// $sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas";
			// $r2x = $conexion -> query($sql2x); 
			// while($del = $r2x -> fetch_array())
			// {
			// 	//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
			// 		$sqlx = "SELECT COUNT(*) as n FROM notificadores_visitas where estado_ubvvaciaenbuenestado='1' AND delegacion='".$del['del']."'";
				
			// 		$rc= $conexion -> query($sqlx);
			// 		if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
			// 		$ubv_vaciabuenestado = $ubv_vaciabuenestado + $c;
			// 		$tmp=$tmp.$c.",";
			// 		//$tmp=$tmp."],";
			// }
			// $tmp = trim($tmp, ',');
			// $tmp=$tmp."],";




			// $tmp=$tmp."['UBV Vacia Bandalizada', ";
			// $sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas";
			// $r2x = $conexion -> query($sql2x); 
			// while($del = $r2x -> fetch_array())
			// {
			// 	//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
			// 		$sqlx = "SELECT COUNT(DISTINCT contrato) as n FROM notificadores_visitas where estado_ubvvaciavandalizada='1' AND delegacion='".$del['del']."'";
				
			// 		$rc= $conexion -> query($sqlx);
			// 		if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
			// 		$ubv_vaciavandalizada = $ubv_vaciavandalizada + $c;
			// 		$tmp=$tmp.$c.",";
			// 		//$tmp=$tmp."],";
			// }
			// $tmp = trim($tmp, ',');
			// $tmp=$tmp."],";


			// $tmp=$tmp."['UBV Rentada', ";
			// $sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas";
			// $r2x = $conexion -> query($sql2x); 
			// while($del = $r2x -> fetch_array())
			// {
			// 	//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
			// 		$sqlx = "SELECT COUNT(DISTINCT contrato) as n FROM notificadores_visitas where estado_ubvrentada='1' AND delegacion='".$del['del']."'";
				
			// 		$rc= $conexion -> query($sqlx);
			// 		if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
			// 		$ubv_rentada = $ubv_rentada + $c;
			// 		$tmp=$tmp.$c.",";
			// 		//$tmp=$tmp."],";
			// }
			// $tmp = trim($tmp, ',');
			$tmp=$tmp."],";

			$data2 = "  
		  ['Estado', 'Cantidad'],
          ['Baldio',     $t_baldio],
          ['Habitado',      $t_habitado],
          ['Construc',  $t_construc],
          ['Rentado', $t_rentado],
          ['UBV habitada',    $ubv_habiado],
          ['UBV Vacia Bien', $ubv_vaciabuenestado],
          ['UBV Vacia Bandalizada', $ubv_vaciavandalizada],
          ['UBV rentado', $ubv_rentada]
		  ";

				$data =   trim($tmp2, ',')."],". trim($tmp, ',')."";
				$grafica = "
    <script type='text/javascript'>
     google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([

				    ".$data."
				     
				
				     ]);

       var options = {
          title: 'Situacion de los Lotes, segun las Visitas realizadas ',
          hAxis: {title: 'Estado de Lotes',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
          legend: {position: 'top', maxLines: 2},
           animation: {
          duration: 1000,
          easing: 'out',
          startup: true
      		}


        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
        chart.draw(data, options);

      }
    </script>
	<div id='chart_div2' ></div>

				";
	


	$grafica2 = "
    <script type='text/javascript'>
     google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([

				    ".$data2."
				     
				
				     ]);

       var options = {
          title: 'Situacion de los Lotes, segun las Visitas realizadas ',
          hAxis: {title: 'Estado de Lotes',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
          legend: {position: 'top', maxLines: 2},
           animation: {
          duration: 1000,
          easing: 'out',
          startup: true
      		}


        };
        var chart = new google.visualization.PieChart(document.getElementById('chart_div3'));

        
        chart.draw(data, options);

      }
    </script>
	<div id='chart_div3' ></div>

				";

	echo  $grafica.$grafica2; //grafica top de visitas

	echo "<table class='tabla'>
	  	  <th>Estado</th><th>Cantidad</th>
          <tr><td><a class='normal link' href='notificadores_galeria.php?brig=&busqueda=baldio&del=".$_GET['del']."' target='_blank'>Baldio</a></td><td>  $t_baldio</td><tr>
          <tr><td><a class='normal link' href='notificadores_galeria.php?brig=&busqueda=habitado&del=".$_GET['del']."' target='_blank'>Habitado</a></td><td>$t_habitado</td></tr>
          <tr><td><a class='normal link' href='notificadores_galeria.php?brig=&busqueda=construccion&del=".$_GET['del']."' target='_blank'>Construc</a></td><td> $t_construc</td></tr>
          <tr><td><a class='normal link' href='notificadores_galeria.php?brig=&busqueda=rentado&del=".$_GET['del']."' target='_blank'>Rentado</a></td><td>$t_rentado</td></tr>

          
          </table>
		  ";













	}
	else {// si selecciona delegacion







echo '<div id="indicadores">';

			$d= $d."<span class='tenue'>Hasta el momento se ha encontrado actividad en las delegaciones ";	
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				$d= $d."<a href='indicadores_notificaciones.php?del=".$del['del']."'>".delegacion_id($del['del'])."</a>, ";

			}
			$d= trim($d, ','); //quita la ultima coma
			$d= $d.", de las cuales se  obtiene en tiempo real los siguientes indicadores: <br><br> * De clic sobre el nombre de la delegacion para mostrar los indicadores solamente de dicha delegacion, o <a href='indicadores_notificaciones.php?del='>aqui para mostrar Todos nuevamente</a>.</span>";
			echo $d;

	$ti="";
	$delvictoria="";
	$ti = $ti."";
			$ti = $ti."<h1>Todos los municipios</h1>";
			historia($nitavu,'Vio Indicadores de Notificaciones Resumen (app: '.$id_aplicacion);
			docdigital_no(FALSE, 2);//aumenta 2 al contador de papel
			
			// $sql = "SELECT  count(*) as n FROM Lotes WHERE (IdEstatus=0)"; // Victoria:Libres	
			// $rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){
			// $ti = $ti."<div class='indicadores_suelo_tabla_mod'><label>Libres</label>".number_format($f['n'])."</div>"; $libres= $libres + $f['n'];} 
			// else {$ti = $ti."<div class='indicadores_suelo_tabla_mod'>0</div>";}
			

		//$ti = $ti."<label>".$delvictoria."</label>";
		$c=0;
		$tmp=""; $tmp2="";
			$tmp2= $tmp2."['Fecha',";	
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas where delegacion='".$_GET['del']."'";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				$tmp2= $tmp2."'".delegacion_id($del['del'])."',";

			} 

				$sql2="SELECT DISTINCT visita_fecha  as fecha FROM notificadores_visitas where delegacion='".$_GET['del']."'";
				$r2 = $conexion -> query($sql2); 
				while($a = $r2 -> fetch_array())
					{
						$tmp= $tmp."['".$a['fecha']."',";

						$sqld="SELECT DISTINCT delegacion  as del FROM notificadores_visitas where delegacion='".$_GET['del']."'";
						$rd = $conexion -> query($sql2x); 
						while($delegacion = $rd -> fetch_array())
						{
							
							$sqlx = "SELECT COUNT(*) as n FROM notificadores_visitas where visita_fecha='".$a['fecha']."' AND delegacion='".$delegacion['del']."'";
//							echo $sqlx;
							$rc= $conexion -> query($sqlx);
							if($f = $rc -> fetch_array())
								{
									$c= $f['n'];
								} else {$c=0;}

							$tmp=$tmp.$c.",";


						} //delegaciones
				$tmp=$tmp."],";

				} //fechas


				$data =   trim($tmp2, ',')."],". trim($tmp, ',')."";
				$grafica = "
    <script type='text/javascript'>
     google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([

				    ".$data."
				     
				
				     ]);

       var options = {
          title: 'Que tan rapido hemos sido, en un dia: ".delegacion_id($_GET['del'])."',
          hAxis: {title: 'Fechas',  titleTextStyle: {color: '#333'}},
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

	echo  $grafica; //grafica top de visitas
//------------------------------------------------------------------------


		$c=0;
		$t_baldio=0; $t_habitado=0; $t_construc=0; $t_rentado=0; $ubv_habiado=0; $ubv_vaciabuenestado=0;  $ubv_vaciavandalizada=0;  $ubv_rentada=0;
		$tmp=""; $tmp2="";
			$tmp2= $tmp2."['Estado del Lote',";	
			$tmp=$tmp."['Baldios', ";

			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas where delegacion='".$_GET['del']."'";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
					$sqlx = "SELECT COUNT(*) as n FROM notificadores_visitas where estado_lotebaldio='1' AND delegacion='".$del['del']."'";
				
					$rc= $conexion -> query($sqlx);
					if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
					$t_baldio = $t_baldio + $c;
					$tmp=$tmp.$c.",";
					//$tmp=$tmp."],";
			}
			$tmp = trim($tmp, ',');
			$tmp=$tmp."],";


			$tmp=$tmp."['Habitados', ";
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas  WHERE delegacion='".$_GET['del']."'";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
					$sqlx = "SELECT COUNT(*) as n FROM notificadores_visitas where estado_lotehabitado='1' AND delegacion='".$del['del']."'";
				
					$rc= $conexion -> query($sqlx);
					if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
					$t_habitado = $t_habitado + $c;
					$tmp=$tmp.$c.",";
					//$tmp=$tmp."],";
			}
			$tmp = trim($tmp, ',');
			$tmp=$tmp."],";



			$tmp=$tmp."['En Construc.', ";
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas where  delegacion='".$_GET['del']."'";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
					$sqlx = "SELECT COUNT(*) as n FROM notificadores_visitas where estado_loteenconstruccion='1' AND delegacion='".$del['del']."'";
					
					$rc= $conexion -> query($sqlx);
					if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
					$t_construc = $t_construc + $c;
					$tmp=$tmp.$c.",";
					//$tmp=$tmp."],";
			}
			$tmp = trim($tmp, ',');
			$tmp=$tmp."],";



			$tmp=$tmp."['Rentado.', ";
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas where  delegacion='".$_GET['del']."'";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
					$sqlx = "SELECT COUNT(*) as n FROM notificadores_visitas where estado_loterentado='1' AND delegacion='".$del['del']."'";
				
					$rc= $conexion -> query($sqlx);
					if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
					$t_rentado = $t_rentado+$c;
					$tmp=$tmp.$c.",";
					//$tmp=$tmp."],";
			}
			$tmp = trim($tmp, ',');
			$tmp=$tmp."],";



			$tmp=$tmp."['UBV Habitada.', ";
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas where  delegacion='".$_GET['del']."'";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
					$sqlx = "SELECT COUNT(*) as n FROM notificadores_visitas where estado_ubvhabitada='1' AND delegacion='".$del['del']."'";
				
					$rc= $conexion -> query($sqlx);
					if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
					$ubv_habiado = $ubv_habiado + $c;
					$tmp=$tmp.$c.",";
					//$tmp=$tmp."],";
			}
			$tmp = trim($tmp, ',');
			$tmp=$tmp."],";


			$tmp=$tmp."['UBV Vacia Buen Estado.', ";
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas where  delegacion='".$_GET['del']."'";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
					$sqlx = "SELECT COUNT(*) as n FROM notificadores_visitas where estado_ubvvaciaenbuenestado='1' AND delegacion='".$del['del']."'";
				
					$rc= $conexion -> query($sqlx);
					if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
					$ubv_vaciabuenestado = $ubv_vaciabuenestado + $c;
					$tmp=$tmp.$c.",";
					//$tmp=$tmp."],";
			}
			$tmp = trim($tmp, ',');
			$tmp=$tmp."],";




			$tmp=$tmp."['UBV Vacia Bandalizada', ";
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas where  delegacion='".$_GET['del']."'";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
					$sqlx = "SELECT COUNT(*) as n FROM notificadores_visitas where estado_ubvvaciavandalizada='1' AND delegacion='".$del['del']."'";
				
					$rc= $conexion -> query($sqlx);
					if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
					$ubv_vaciavandalizada = $ubv_vaciavandalizada + $c;
					$tmp=$tmp.$c.",";
					//$tmp=$tmp."],";
			}
			$tmp = trim($tmp, ',');
			$tmp=$tmp."],";


			$tmp=$tmp."['UBV Rentada', ";
			$sql2x="SELECT DISTINCT delegacion  as del FROM notificadores_visitas where  delegacion='".$_GET['del']."'";
			$r2x = $conexion -> query($sql2x); 
			while($del = $r2x -> fetch_array())
			{
				//$tmp2= $tmp2."'".delegacion_id($del['del'])."',";
	
					
					$sqlx = "SELECT COUNT(*) as n FROM notificadores_visitas where estado_ubvrentada='1' AND delegacion='".$del['del']."'";
				
					$rc= $conexion -> query($sqlx);
					if($f = $rc -> fetch_array()){$c= $f['n'];} else {$c=0;}
					$ubv_rentada = $ubv_rentada + $c;
					$tmp=$tmp.$c.",";
					//$tmp=$tmp."],";
			}
			$tmp = trim($tmp, ',');
			$tmp=$tmp."],";

			$data2 = "  
		  ['Estado', 'Cantidad'],
          ['Baldio',     $t_baldio],
          ['Habitado',      $t_habitado],
          ['Construc',  $t_construc],
          ['Rentado', $t_rentado],
          ['UBV habitada',    $ubv_habiado],
          ['UBV Vacia Bien', $ubv_vaciabuenestado],
          ['UBV Vacia Bandalizada', $ubv_vaciavandalizada],
          ['UBV rentado', $ubv_rentada]
		  ";

				$data =   trim($tmp2, ',')."],". trim($tmp, ',')."";
				$grafica = "
    <script type='text/javascript'>
     google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([

				    ".$data."
				     
				
				     ]);

       var options = {
          title: 'Situacion de los Lotes, segun las Visitas realizadas en ".delegacion_id($_GET['del'])."',
          hAxis: {title: 'Estado de Lotes',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
          legend: {position: 'top', maxLines: 2},
           animation: {
          duration: 1000,
          easing: 'out',
          startup: true
      		}


        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
        chart.draw(data, options);

      }
    </script>
	<div id='chart_div2' ></div>

				";
	


	$grafica2 = "
    <script type='text/javascript'>
     google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([

				    ".$data2."
				     
				
				     ]);

       var options = {
          title: 'Situacion de los Lotes, segun las Visitas realizadas en ".delegacion_id($_GET['del'])."',
          hAxis: {title: 'Estado de Lotes',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
          legend: {position: 'top', maxLines: 2},
           animation: {
          duration: 1000,
          easing: 'out',
          startup: true
      		}


        };
        var chart = new google.visualization.PieChart(document.getElementById('chart_div3'));

        
        chart.draw(data, options);

      }
    </script>
	<div id='chart_div3' ></div>

				";

	echo  $grafica.$grafica2; //grafica top de visitas





























	}


}

}
else
{
	mensaje("No tiene acceso a esta aplicacion",'');
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