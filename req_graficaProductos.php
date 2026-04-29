<?php

$Widget_nombre="TOP (10) DE PRODUCTOS MÁS SOLICITADOS EN EL MES";
$Widget_contenido="";
$empleados_sindpto_quienes="";
//require("config.php");
$data_2 = "['Producto','solicitudes'],";
 /* $sql2x=" -- req 
  SELECT dr.IdConcepto,rc.Concepto, COUNT(*) 
        FROM req_detallerequisicion AS dr RIGHT JOIN req_conceptos AS rc on dr.IdConcepto=rc.IdConcepto 
        LEFT JOIN req_requisiciones AS rq on rq.IdRequisicion=dr.IdRequisicion      
        where dr.Cancelado=0 and  (dr.IdRequisicion IS not NULL or dr.IdRequisicion!=0)
        and rc.Cancelado=0 
        GROUP BY dr.IdConcepto 
        order by COUNT(*) desc LIMIT 10
";*/
 
$sql2x=" -- req 
SELECT dr.IdConcepto,rc.Concepto, COUNT(*) ,MONTH (dr.FechaCrea) ,MONTH(NOW())
        FROM req_detallerequisicion AS dr RIGHT JOIN req_conceptos AS rc on dr.IdConcepto=rc.IdConcepto 
        LEFT JOIN req_requisiciones AS rq on rq.IdRequisicion=dr.IdRequisicion      
        where dr.Cancelado=0 and  (dr.IdRequisicion IS not NULL or dr.IdRequisicion!=0)
         AND rq.IdEstatus in(3,4,5) and MONTH (dr.FechaCrea) =MONTH(NOW())
        GROUP BY dr.IdConcepto 
        order by COUNT(*) desc LIMIT 10";
      $r2x = $conexion -> query($sql2x); 
      
      while($f = $r2x -> fetch_array())
      {               
        $c=0;
        $sql = " -- req 
        SELECT COUNT(*) as n FROM req_detallerequisicion AS dr RIGHT JOIN req_conceptos AS rc on dr.IdConcepto=rc.IdConcepto 
        LEFT JOIN req_requisiciones AS rq on rq.IdRequisicion=dr.IdRequisicion      
        where dr.Cancelado=0 and  (dr.IdRequisicion IS not NULL or dr.IdRequisicion!=0)
        and rq.IdEstatus in(3,4,5) and MONTH (dr.FechaCrea) =MONTH(NOW())
        and dr.IdConcepto=".$f['IdConcepto'];
        $rc= $conexion -> query($sql); if($f2 = $rc -> fetch_array()){$c = $f2['n'];}  

          $data_2 = $data_2."['".$f['Concepto']."', ".$c."],";
      }
$data_2= trim($data_2, ','); //quita la ultima coma

$grafica2='<div id="piechart" style="width:90%;"></div>



<script type="text/javascript" src="lib/gstatic_loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
        

      


// Draw the chart and set the chart values
  function drawChart() {
        var data = google.visualization.arrayToDataTable([
        '.$data_2.'         
        ]);

      // Optional; add a title and set the width and height of the chart
      var options = {
           title: "TOP (10) DE PRODUCTOS MÁS SOLICITADOS EN EL MES",
          is3D: true,
          legend: { textStyle: {fontSize: 9,  }},
           width: 475,
           height: 350,
           fontSize:11,

              

        };

  


  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById("piechart"));
  chart.draw(data, options);
}
</script>';

$tmp="";
$tmp = $tmp."<section  >";
$tmp = $tmp. "<label>".$Widget_nombre."</label>";
$tmp = $tmp."<article >";
//$tmp = $tmp. "<a href=''>";
$tmp = $tmp. "<table border='0'><tr><td>";
$tmp = $tmp.$Widget_contenido.$grafica2;
$tmp = $tmp. "</td></tr></table></article>";

echo $grafica2;


?>
