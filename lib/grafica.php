<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="lib/gstatic_loader.js"></script>
    
  <script type='text/javascript'>
     google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([

            

        ['Delegaciones', 'Pendientes por Digitalizar'],             
          ['MATAMOROS',     0],             
          ['VALLE HERMOSO',     0],             
          ['ALDAMA',     0],             
          ['ABASOLO',     0],             
          ['MANTE',     0],             
          ['JIMENEZ',     0],             
          ['SOTO LA MARINA DELEG.',     0],             
          ['GONZALEZ DELEG.',     0],             
          ['LLERA DELEG.',     0],             
          ['CAMARGO DELEG.',     0],             
          ['NUEVO LAREDO',     0],             
          ['MADERO',     0],             
          ['ANTIGUO MORELOS PRES.',     0],             
          ['BURGOS PRES.',     0],             
          ['BUSTAMANTE PRES.',     0],             
          ['REYNOSA',     0],             
          ['CRUILLAS PRES.',     0],             
          ['SAN FERNANDO',     0],             
          ['TAMPICO',     0],             
          ['VICTORIA',     4],             
          ['XICOTENCATL',     0],             
          ['TULA',     0],             
          ['VILLA DE CASAS',     0],             
          ['DIAZ ORDAZ',     0],             
          ['JAUMAVE',     0],             
          ['ALTAMIRA',     1],             
          ['MIGUEL ALEMAN',     1],             
          ['RIO BRAVO',     1]
             
        
             ]);

       var options = {
          title: 'Progreso de la Meta',
          hAxis: {title: 'Progreso de la Digitalizacion',  titleTextStyle: {color: '#333'}},
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

  
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div><div id='chart_div2' ></div>

  </body>
</html>