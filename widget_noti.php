<?php


//WIDGET PROTOTIPO


$Widget_nombre="TOP DE NOTIFICADORES";
$Widget_contenido="";
$empleados_sindpto_quienes="";
//require("config.php");
$data_2 = "['Empleado','Notificaciones'],";
  $sql2x="SELECT DISTINCT notificador_nitavu  as empleado FROM notificadores_visitas where visitada='TRUE'";
      $r2x = $conexion -> query($sql2x); 
      
      while($f = $r2x -> fetch_array())
      {               
        $c=0;
        $sql = "SELECT COUNT(*) as n from notificadores_visitas where notificador_nitavu='".$f['empleado']."'";
        $rc= $conexion -> query($sql); if($f2 = $rc -> fetch_array()){$c = $f2['n'];}  

          $data_2 = $data_2."['".nitavu_nombre($f['empleado'])."', ".$c."],";
      }
$data_2= trim($data_2, ','); //quita la ultima coma
//$data_2 = $data_2."  ]);";

//echo $data_2;
$grafica2 = "<script type='text/javascript'>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
        ".$data_2."
      ]);

    var options = {
      title : 'Progreso de los notificadores:',

    
      seriesType: 'bars',
      
legend: {position: 'none'},
       animation: {
          duration: 4500,
          easing: 'out',
          startup: true
          },
          
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_divtop'));
    chart.draw(data, options);
  }
    </script>

    <div id='chart_divtop' style='width: 350px; height: 400px; background-color:white;'></div>

";








$tmp="";
$tmp = $tmp."<section id='aplicaciones' class='widget'>";
$tmp = $tmp. "<label>".$Widget_nombre."</label>";
$tmp = $tmp."<article >";
//$tmp = $tmp. "<a href=''>";
$tmp = $tmp. "<table border='0'><tr><td>";
$tmp = $tmp.$Widget_contenido.$grafica2;
$tmp = $tmp. "</td></tr></table></article>";

echo $tmp."</section>";
//echo $tmp."</section>";
?>

