<?php

$Widget_nombre="TOP (10) DE PRODUCTOS MÁS COMPRADOS";
$Widget_contenido="";

//require("config.php");
$data_2 = "['Producto','Cantidad'],";
  $sql2x=" -- req 
  SELECT dr.IdConcepto,rc.Concepto, COUNT(*) 
        FROM req_detallerequisicion AS dr RIGHT JOIN req_conceptos AS rc on dr.IdConcepto=rc.IdConcepto 
        LEFT JOIN req_requisiciones AS rq on rq.IdRequisicion=dr.IdRequisicion      
        where dr.Cancelado=0 and  (dr.IdRequisicion IS not NULL or dr.IdRequisicion!=0)
        and rq.IdEstatus in(3,4,5)
        GROUP BY dr.IdConcepto 
        order by COUNT(*) desc LIMIT 10
";
      $r2x = $conexion -> query($sql2x); 
      
      while($f = $r2x -> fetch_array())
      {               
        $c=0;
        $sql = " -- req 
        SELECT sum(dr.Cantidad) as n FROM req_detallerequisicion AS dr RIGHT JOIN req_conceptos AS rc on dr.IdConcepto=rc.IdConcepto 
        LEFT JOIN req_requisiciones AS rq on rq.IdRequisicion=dr.IdRequisicion      
        where dr.Cancelado=0 and  (dr.IdRequisicion IS not NULL or dr.IdRequisicion!=0)
        and rq.IdEstatus in(3,4,5) and dr.IdConcepto=".$f['IdConcepto'];
        $rc= $conexion -> query($sql); if($f2 = $rc -> fetch_array()){$c = $f2['n'];}  

          $data_2 = $data_2."['".$f['Concepto']."', ".$c."],";
      }
$data_2= trim($data_2, ','); //quita la ultima coma

/*$grafica2='<div id="piechart"></div>



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
        type:bar-vertical,
          title: "",
          is3D: true,
          legend: { textStyle: {fontSize: 9}},
          width:680, 
          height:400,
        };
     
      
  


  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById("piechart"));
  chart.draw(data, options);
}
</script>';*/



$grafica2 = "<script type='text/javascript'>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
        ".$data_2."
      ]);

    var options = 
    {
       title: 'TOP (10) DE PRODUCTOS MÁS COMPRADOS',
      seriesType: 'bars',      
      legend: {position: 'none'},
      animation: {
          duration: 4500,
          easing: 'out',
          startup: true
          },
      width: 400,
      height: 350,
     
    hAxis: {
      
      textStyle: {

        fontSize: 9,
      } // or the number you want}
    },        
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_divtop'));
    chart.draw(data, options);
  }
    </script>

    <div id='chart_divtop'  >

    </div>

";



echo $grafica2;


?>
