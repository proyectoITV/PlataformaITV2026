<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap93"; //ap06=Permisos de Aplicacion
// $nivel = 2;
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);	//Nivel 1 = todos, otro nivel solo los que dependen de el

$MiDpto = nitavu_dpto($nitavu);
$MisDptos = MisDptosIn($nitavu);
  
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	docdigital_no(FALSE, 2);//aumenta 2 al contador de papel
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    
    // echo "Mis Departamentos in: ".$MisDptos;
    if ($nivel == 1){
        $sql="
      SELECT
    id AS CPIdDto,
    ( SELECT nombre FROM cat_gerarquia WHERE id = CPIdDto ) AS Departamento,
    ( SELECT count(*) FROM cp_nuevosdocumentos WHERE idDptoCrea = CPIdDto ) AS Tickets,
    ( SELECT count(*) FROM cp_nuevosdocumentos WHERE (idDptoCrea = CPIdDto OR turnadoa = CPIdDto) AND estado = 0 ) AS CasosAbiertos,
    ( SELECT count(*) FROM cp_nuevosdocumentos WHERE turnadoa = CPIdDto AND estado = 0 ) AS CasosTurnados,
    ( SELECT count(*) FROM aplicacionespermisos WHERE NIdApp = 'ap66' and IdDpto=CPIdDto) as Permisos
    
      FROM
          cat_gerarquia 
      WHERE 
        id <> 0
        
      ORDER BY
          CasosTurnados DESC
          
      ";
      echo "<table class='tabla'>
          <th>IdDpto</th>
          <th>Departamento</th>
          <th>tickets Creados</th>
          <th>Casos Abiertos</th>
          <th>Casos Turnados</th>
          <th>Permisos</th>
          <th rowspan='62' width=50% style='background-color:white;' valign=top align=center>
          <div id='GraficaTicketsTotal' style='width:100%; height:500px; padding:5px;'></div><hr>
          <div id='GraficaTicketsCreados' style='width:40%; height:300px; padding:5px; display:inline-block;'></div>
          <div id='GraficaTicketsAbiertos' style='width:40%; height:300px; padding:5px;display:inline-block;'></div>
          
          
          </th>
          
      ";
    } 
    if ($nivel <> 1 ){
      //Cualquier otro nivel del 1, solo puede ver lo que depende de el

      $sql="
      SELECT
    id AS CPIdDto,
    ( SELECT nombre FROM cat_gerarquia WHERE id = CPIdDto ) AS Departamento,
    ( SELECT count(*) FROM cp_nuevosdocumentos WHERE idDptoCrea = CPIdDto ) AS Tickets,
    ( SELECT count(*) FROM cp_nuevosdocumentos WHERE (idDptoCrea = CPIdDto OR turnadoa = CPIdDto) AND estado = 0 ) AS CasosAbiertos,
    ( SELECT count(*) FROM cp_nuevosdocumentos WHERE turnadoa = CPIdDto AND estado = 0 ) AS CasosTurnados,
    ( SELECT count(*) FROM aplicacionespermisos WHERE NIdApp = 'ap66' and IdDpto=CPIdDto) as Permisos
    
      FROM
          cat_gerarquia 
      WHERE 
        id <> 0 and id in(".$MisDptos.")
        
      ORDER BY
          CasosTurnados DESC
          
      ";
       

        echo "<table class='tabla'>
            <th>IdDpto</th>
            <th>Departamento</th>
            <th>tickets Creados</th>
            <th>Casos Abiertos</th>
            <th>Casos Turnados</th>
            <th>Permisos</th>
            <th rowspan='62' width=50% style='background-color:white;' valign=top align=center>";
          

        if ($nivel <> 1 ){
          echo "
          <div id='GraficaTicketsAbiertos' style='width:100%; height:500px; padding:5px;display:inline-block;'></div>
          
          
          </th>
          
      ";
        } else {
          echo "<div id='GraficaTicketsTotal' style='width:100%; height:500px; padding:5px;'></div><hr>
          <div id='GraficaTicketsCreados' style='width:40%; height:300px; padding:5px; display:inline-block;'></div>";
          echo "
          <div id='GraficaTicketsAbiertos' style='width:40%; height:300px; padding:5px;display:inline-block;'></div>
          
          
          </th>
          
      ";
        }
    }
    // echo $sql;
    $strT=""; $strC=""; $strA=""; $TotalTickets=0; $TotalAbiertos=0;
    $r= $conexion -> query($sql);
    while($f = $r -> fetch_array()) {

        echo "<tr>";

        echo "<td>".$f['CPIdDto']."</td>"; $IdDpto = $f['CPIdDto'];

        echo "<td>".$f['Departamento']."</td>";
        echo "<td><a href='#Tickets".$IdDpto."' rel='MyModal:open' title='Ver tickets'>".$f['Tickets']."</a>";
        $sqlT = "
        
        SELECT
        Departamento,
        IdTicket,
        fecha,
        asunto, oficioNumero
        FROM
            ticketlista_html
        WHERE	
            idDptoCrea = ".$f['CPIdDto'];

        // echo $sqlT;
        TablaDinamica_MySQL("",$sqlT, "Tickets".$IdDpto, "TablaTicket".$IdDpto, "modal", 0);
        $strC = $strC."['".$f['Departamento']."',     ".$f['Tickets']."],";
        $TotalTickets = $TotalTickets + $f['Tickets'];
        echo "</td>";

        
        echo "<td><a href='#TicketsAbiertos".$IdDpto."' rel='MyModal:open' title='Ver tickets Abiertos'>".$f['CasosAbiertos']."</a>";
        $sqlTAb = "
        
          
        SELECT
        Departamento,
        IdTicket,
        fecha,
        asunto, oficioNumero
        FROM
            ticketlista_html
        WHERE	
            (idDptoCrea = ".$f['CPIdDto']."    or turnadoa = ".$f['CPIdDto']."         ) and Estado = 'ABIERTO (0)'";
        
        
        
        // echo $sqlTAb;
        TablaDinamica_MySQL("",$sqlTAb, "TicketsAbiertos".$IdDpto, "TablaTicketAbiertos".$IdDpto, "modal", 0);
        $strA = $strA."['".$f['Departamento']."',     ".$f['CasosAbiertos']."],";
        $TotalAbiertos = $TotalAbiertos + $f['CasosAbiertos'];
        echo "</td>";

        echo "<td><a href='#TicketsTurnados".$IdDpto."' rel='MyModal:open' title='Ver tickets Abiertos'>".$f['CasosTurnados']."</a>";
        $sqlTA = "
                
          
        SELECT
        Departamento,
        IdTicket,
        fecha,
        asunto, oficioNumero
        FROM
            ticketlista_html
        WHERE	
            turnadoa = ".$f['CPIdDto']." ";
        
        
        
        TablaDinamica_MySQL("",$sqlTA, "TicketsTurnados".$IdDpto, "TablaTicketTurnados".$IdDpto, "modal", 0);
        echo "</td>";


        echo "<td><a href='#Permisos".$IdDpto."' rel='MyModal:open' title='Ver tickets Abiertos'>".$f['Permisos']."</a>";
        $sqlP = "
         SELECT * FROM aplicacionespermisos WHERE NIdApp = 'ap66' and IdDpto=".$IdDpto."
        ";
        TablaDinamica_MySQL("",$sqlP, "Permisos".$IdDpto, "TablaPermisos".$IdDpto, "modal", 0);
        echo "</td>";

       

        echo "</tr>";
    }
    $strT = substr($strT, 0, -1); //quita la ultima coma.
    echo "</table>";
if ($nivel <> 1 ){
  echo "
      <script>
      function GraficaTicketsAbiertos(){
          google.charts.load('current', {packages:['corechart']});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Delegacion', 'Tickets'],
              ".$strA."       
            ]);

            var options = {
              title: 'tickets actualmente Abiertos',
              pieHole: 0.4,
              legend: {position: 'bottom',textStyle: {color: 'gray', fontSize: 8}}
            };

            var chart = new google.visualization.PieChart(document.getElementById('GraficaTicketsAbiertos'));
            chart.draw(data, options);
          }
      }
      GraficaTicketsAbiertos();


    </script>";
}
else {
        echo "<script>
        GraficaTicketsTotal();
        GraficaTicketsCreados();
        GraficaTicketsAbiertos();

        function GraficaTicketsTotal(){
            google.charts.load('current', {packages:['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
              var data = google.visualization.arrayToDataTable([
                ['Delegacion', 'Tickets'],
                ['Cerrados', ".TickesCerrados()."],
                ['Abiertos', ".TickesAbiertos()."]
                    
              ]);

              var options = {
                title: 'Total de Tickets',
                pieHole: 0.4,
                
                legend: {position: 'bottom',textStyle: {color: 'gray', fontSize: 8}}
              };

              var chart = new google.visualization.PieChart(document.getElementById('GraficaTicketsTotal'));
              chart.draw(data, options);
            }
        }


        function GraficaTicketsCreados(){
            google.charts.load('current', {packages:['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
              var data = google.visualization.arrayToDataTable([
                ['Delegacion', 'Tickets'],
                ".$strC."       
              ]);

              var options = {
                title: 'tickets Creados',
                pieHole: 0.4,
                legend: {position: 'bottom',textStyle: {color: 'gray', fontSize: 8}}
              };

              var chart = new google.visualization.PieChart(document.getElementById('GraficaTicketsCreados'));
              chart.draw(data, options);
            }
        }


        function GraficaTicketsAbiertos(){
            google.charts.load('current', {packages:['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
              var data = google.visualization.arrayToDataTable([
                ['Delegacion', 'Tickets'],
                ".$strA."       
              ]);

              var options = {
                title: 'tickets actualmente Abiertos',
                pieHole: 0.4,
                legend: {position: 'bottom',textStyle: {color: 'gray', fontSize: 8}}
              };

              var chart = new google.visualization.PieChart(document.getElementById('GraficaTicketsAbiertos'));
              chart.draw(data, options);
            }
        }



    </script>
    ";

  } 
}
else{echo "No tiene acceso a ".$id_aplicacion;}










?>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>