<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>

 <script type='text/javascript'>
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
				    ['VIIVIENDA COMPLETA','1'],['arena','1'],['VIVIENDA','1'],['block','2'],['LAMINA','1']
				     
				
				     ]);

        // Set chart options
        var options = {'title':'Grafica de Reservas en Tamaulipas',
                       'width':350,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
	<div id='chart_div'></div>

	
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>