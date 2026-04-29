<?php include ("./unica/body_head.php"); include ("./unica/body_menu.php"); ?>


<?php
$id_aplicacion ="ap60";
if (sanpedro($id_aplicacion, $nitavu)==TRUE){echo "<h5>".app_detalle($id_aplicacion)."</h5>";

    

    echo "<div id='indicadores'>";
    //$sql = "select * from empleados where date_format (fecha_nacimiento, '%m') = date_format (now(), '%m')";
    $sql = "select * from cat_delegaciones";
    $a ="['Fecha', ";
    $r = $conexion -> query($sql);while($f = $r -> fetch_array())
    {$a=$a."'".$f['nombre']."', "; }
    $a = substr($a, 0, -2);//quitar la coma
    $a=$a."]";

    $sql = "select DISTINCT(fecha) from ingresos_vivienda"; //recorremos las fechas    
    $r = $conexion -> query($sql);while($f = $r -> fetch_array())
    {
        $a=$a."['".$f['fecha']."', ";

        $sql = "select * from cat_delegaciones";        
        $r2 = $conexion -> query($sql);while($f2 = $r2 -> fetch_array())
        {$a=$a."".ingresos_totales($f2['id'],$f['fecha']).", "; }
        $a = substr($a, 0, -2);//quitar la coma
        $a=$a."]";
    
    }
    //echo $a;
    
$grafica2 = "<script type='text/javascript'>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      
      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
        ".$a."
      ]);

        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div3'));
        chart.draw(data, options);
  }
    </script>

    <div id='chart_div3' style='width: 100%; height: 400px; background-color:white;'></div>

";
echo '<script type="text/javascript" src="unica/gstatic_loader.js"></script>';
    
echo $grafica2;

    echo "</div>";


    echo "<div id='indicadores'>";
    //$sql = "select * from empleados where date_format (fecha_nacimiento, '%m') = date_format (now(), '%m')";
    $sql = "select 
	*,
	IdDelegacion as del,
	(select nombre from cat_delegaciones where cat_delegaciones.id = del) as nombredelegacion,
	IdPrograma as prog,
	(select Programa from cat_programa where cat_programa.IdPrograma = prog) as nombreprograma
    FROM	
    ingresos_vivienda
    WHERE date_format (fecha, '%m') = date_format (now(), '%m')
    ";
    echo "<b>Ingresos de este mes</b>";
    echo "<table class=tabla width=100%>";
    $ingt=0;
    $r = $conexion -> query($sql);while($f = $r -> fetch_array())
    {
        echo "<tr>";
        echo "<td>".$f['nombredelegacion']."</td>";
        echo "<td>".$f['nombreprograma']."(".$f['tipo'].")</td>";
        echo "<td>".$f['fecha']."</td>";
        echo "<td>".$f['ingresos']."</td>";
        $ingt = $ingt + $f['ingresos'];
        echo "</tr>";
    }
    echo "<tr><td></td><td></td><td></td><td><b>$ ".$ingt."</b></td></tr>";
    echo "</table>";
    echo "</div>";
}
else {mensaje("No tiene permiso para ver esta aplicacion",'');}	 
?>






















<!-- Hacer algo de espacio para testear -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./unica/body_footer.php"); ?>