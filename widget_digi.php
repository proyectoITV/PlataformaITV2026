<?php


//WIDGET PROTOTIPO


$Widget_nombre="AVANCE DE LAS DIGITALIZACIONES";
$Widget_contenido="";
$empleados_sindpto_quienes="";
//require("config.php");

$totales=0; $c=0; $c2=0; $c3=0;
  $digitalizados=0; $data2="";
  $data2= $data2."

        ['Delegaciones', 'Pendientes por Digitalizar'],";
      
  $data="['Delegaciones','Contratos','solicitudes','Digitalizados'],";      
  $sql="select DISTINCT del from cat_municipios order by del";$r= $conexion -> query($sql); while($del = $r -> fetch_array())
  {



    $sqlx3 = "select count(DISTINCT folio) as n  from digital_itavu  where delegacion='".$del['del']."'";
    $rc3= $conexion -> query($sqlx3); if($f3 = $rc3 -> fetch_array())
    { $c3= $f3['n']; $digitalizados = $digitalizados + $c3;
    $data2= $data2."             
          ['".delegacion_id($del['del'])."',     $c3],";
         

    } else {$c3=0;}    
    //$totales= $totales + $c3;
    


    
  }
  $data2 =   trim($data2, ',');



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
          hAxis: {title: 'Progreso de la Digitalizacion',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
          legend: {position: 'top', maxLines: 2},
         
          
        };
        var chart = new google.visualization.PieChart(document.getElementById('chart_top2'));

        
        chart.draw(data, options);

      }
    </script>
  <div id='chart_top2' style='width: 350px; height: 400px; background-color:white;'' ></div>";






$tmp="";
$tmp = $tmp."<section id='aplicaciones' class='widget'>";
$tmp = $tmp. "<label>".$Widget_nombre."</label>";
$tmp = $tmp."<article >";
//$tmp = $tmp. "<a href=''>";
$tmp = $tmp. "<table border='0'><tr><td>";
$tmp = $tmp.$Widget_contenido.$grafica2."<br><b class='normal tgrande'>".$digitalizados."</b>  <b class='tenue tgrande'> Digitalizaciones</b>";
$tmp = $tmp. "</td></tr></table></article>";

echo $tmp."</section>";
//echo $tmp."</section>";
?>

