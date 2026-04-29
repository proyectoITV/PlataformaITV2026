<?php


//WIDGET PROTOTIPO
$Widget_nombre="ACTIVIDAD DE USUARIOS";
$Widget_contenido="";
$empleados_sindpto_quienes="";
//require("config.php");

$us_total=0; $us_hora=0;
$sql = "SELECT COUNT(DISTINCT nitavu) AS n FROM historia WHERE (fecha='".$fecha."')"; 
$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){$us_total = $f['n'] + 14;}	
$Widget_contenido = $Widget_contenido. "<b>Accesos:</b> <b class='normal'>".$us_total."</b><span class='tenue'> | </span>";


// $h="";
// for ($x = 1; $x <= 24; $x++) {
    
//     if ($x<10){
//     	$h = "0".$x;
//     } else {$h= $x;}

// }

$h = substr($hora, 0, 2);
$sql = "SELECT COUNT(DISTINCT nitavu) AS n FROM historia WHERE (fecha='".$fecha."' and hora like'".$h."%')"; 
$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){$us_hora = $f['n'] ;}	
$Widget_contenido = $Widget_contenido. "<b>En la ultima hora</b> <span class='tenue'>[".$h."h ]</span>: <b class='normal'> ".$us_hora."</b>";


$us_win=0;
$sql = "SELECT COUNT(DISTINCT nitavu) AS n FROM historia WHERE (fecha='".$fecha."' and descripcion like'%Windows%')"; 
$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){$us_win = $f['n'];}	
$Widget_contenido = $Widget_contenido. "<br><span id='eti'><div><img src='icon/win.png' class='mini_icono_'> ".$us_win."</div>";

$us_linux=0;
$sql = "SELECT COUNT(DISTINCT nitavu) AS n FROM historia WHERE (fecha='".$fecha."'  and descripcion like'%SO: LIN%')"; 
$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){$us_linux = $f['n'];}	
$Widget_contenido = $Widget_contenido. "<div> <img src='icon/linux.png' class='mini_icono_'> ".$us_linux."</div>";


$us_apple=0;
$sql = "SELECT COUNT(DISTINCT nitavu) AS n FROM historia WHERE (fecha='".$fecha."'  and descripcion like'%SO: MAC%')"; 
$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){$us_apple = $f['n'];}	
$Widget_contenido = $Widget_contenido. "<div><img src='icon/mac.png' class='mini_icono_'>".$us_apple."</div>";


$us_android=0;
$sql = "SELECT COUNT(DISTINCT nitavu) AS n FROM historia WHERE (fecha='".$fecha."'  and descripcion like'%Android%')"; 
$rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){$us_android = $f['n'];}	
$Widget_contenido = $Widget_contenido. "<div><img src='icon/android.png' class='mini_icono_'> ".$us_android."</div></span>";



$data =   "['Task', 'Hours per Day'],
          ['Windows',     $us_win],
          ['Android',      $us_linux],
          ['Apple',  $us_apple],
          ['Andoid',  $us_android]
          ";

$grafica = '

 <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        '.$data.'
         
        ]);

        var options = {
          pieHole: 0.4, legend:"none",
          
          is3D: false

  

        };

        var chart = new google.visualization.PieChart(document.getElementById("donutchart"));
        chart.draw(data, options);
      }
    </script>
    <div id="donutchart" style="width: 350px; height: 400px; background-color:pink;"></div>

';








$tmp="";
$tmp = $tmp."<section id='aplicaciones' class='widget'>";
$tmp = $tmp. "<label>".$Widget_nombre."</label>";
$tmp = $tmp."<article >";
//$tmp = $tmp. "<a href=''>";
$tmp = $tmp. "<table border='0'><tr><td>";
$tmp = $tmp.$Widget_contenido.$grafica;
$tmp = $tmp. "</td></tr></table></article>";

echo $tmp."</section>";
//echo $tmp."</section>";
?>

