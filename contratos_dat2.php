<?php
require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion


 //Parametros
 if ( isset($_GET['IdDelegacion']) and isset($_GET['IdPrograma']) ){
    $IdDelegacion = $_GET['IdDelegacion'];
    $IdPrograma = $_GET['IdPrograma'];
    $MSSQL = "
    SELECT DISTINCT
	ISNULL(Colonia, ' ') AS GColonia,
	(
	SELECT ISNULL(SUM( Saldo ),0)
	FROM
		(
		SELECT
			busqueda_vivienda_informacionfinanciera.*,
			( SELECT NombreCompleto FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS NombreCompleto,
			( SELECT EstadoCivil FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS EstadoCivil,
			( SELECT NCElector FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS NElector,
			( SELECT Colonia FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS Colonia,
			( SELECT Telefono FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS Telefono,
			( SELECT Curp FROM vivienda_datosgenerales WHERE Folio = busqueda_vivienda_informacionfinanciera.Folio AND IdDelegacion = busqueda_vivienda_informacionfinanciera.IdDelegacion AND IdPrograma = busqueda_vivienda_informacionfinanciera.IdPrograma ) AS CURP 
		FROM
			busqueda_vivienda_informacionfinanciera 
		WHERE
			saldo > 0 
			AND IdPrograma = ".$IdPrograma." 
			AND IdDelegacion = ".$IdDelegacion." 
		) b 
	WHERE
		b.Colonia = a.Colonia 
	) AS GSaldo,
	(
	SELECT COUNT
		( * ) 
	FROM
		(
		SELECT
			busqueda_vivienda_informacionfinanciera.*,
			( SELECT NombreCompleto FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS NombreCompleto,
			( SELECT EstadoCivil FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS EstadoCivil,
			( SELECT NCElector FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS NElector,
			( SELECT Colonia FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS Colonia,
			( SELECT Telefono FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS Telefono,
			( SELECT Curp FROM vivienda_datosgenerales WHERE Folio = busqueda_vivienda_informacionfinanciera.Folio AND IdDelegacion = busqueda_vivienda_informacionfinanciera.IdDelegacion AND IdPrograma = busqueda_vivienda_informacionfinanciera.IdPrograma ) AS CURP 
		FROM
			busqueda_vivienda_informacionfinanciera 
		WHERE
			saldo > 0 
			AND IdPrograma = ".$IdPrograma." 
			AND IdDelegacion = ".$IdDelegacion." 
		) c 
	WHERE
		a.Colonia = c.Colonia 
		AND c.Saldo > 0 
	) AS ContratosConSaldo,
	(
	SELECT COUNT
		( * ) 
	FROM
		(
		SELECT
			busqueda_vivienda_informacionfinanciera.*,
			( SELECT NombreCompleto FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS NombreCompleto,
			( SELECT EstadoCivil FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS EstadoCivil,
			( SELECT NCElector FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS NElector,
			( SELECT Colonia FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS Colonia,
			( SELECT Telefono FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS Telefono,
			( SELECT Curp FROM vivienda_datosgenerales WHERE Folio = busqueda_vivienda_informacionfinanciera.Folio AND IdDelegacion = busqueda_vivienda_informacionfinanciera.IdDelegacion AND IdPrograma = busqueda_vivienda_informacionfinanciera.IdPrograma ) AS CURP 
		FROM
			busqueda_vivienda_informacionfinanciera 
		WHERE
			saldo > 0 
			AND IdPrograma = ".$IdPrograma." 
			AND IdDelegacion = ".$IdDelegacion." 
		) d 
	WHERE
		a.Colonia = d.Colonia 
		AND d.Saldo_Moratorio > 0 
	) AS ContratosConMoratorio,
	(
	SELECT ISNULL(SUM(Saldo_Moratorio),0)
	FROM
		(
		SELECT
			busqueda_vivienda_informacionfinanciera.*,
			( SELECT NombreCompleto FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS NombreCompleto,
			( SELECT EstadoCivil FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS EstadoCivil,
			( SELECT NCElector FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS NElector,
			( SELECT Colonia FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS Colonia,
			( SELECT Telefono FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS Telefono,
			( SELECT Curp FROM vivienda_datosgenerales WHERE Folio = busqueda_vivienda_informacionfinanciera.Folio AND IdDelegacion = busqueda_vivienda_informacionfinanciera.IdDelegacion AND IdPrograma = busqueda_vivienda_informacionfinanciera.IdPrograma ) AS CURP 
		FROM
			busqueda_vivienda_informacionfinanciera 
		WHERE
			saldo > 0 
			AND IdPrograma = ".$IdPrograma." 
			AND IdDelegacion = ".$IdDelegacion." 
		) d 
	WHERE
		a.Colonia = d.Colonia 
		AND d.Saldo_Moratorio > 0 
	) AS Moratorio 
FROM
	(
	SELECT
		busqueda_vivienda_informacionfinanciera.*,
		( SELECT NombreCompleto FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS NombreCompleto,
		( SELECT EstadoCivil FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS EstadoCivil,
		( SELECT NCElector FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS NElector,
		( SELECT Colonia FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS Colonia,
		( SELECT Telefono FROM busqueda_vivienda_informacioncontratos WHERE NumContrato = busqueda_vivienda_informacionfinanciera.NumContrato ) AS Telefono,
		( SELECT Curp FROM vivienda_datosgenerales WHERE Folio = busqueda_vivienda_informacionfinanciera.Folio AND IdDelegacion = busqueda_vivienda_informacionfinanciera.IdDelegacion AND IdPrograma = busqueda_vivienda_informacionfinanciera.IdPrograma ) AS CURP 
	FROM
		busqueda_vivienda_informacionfinanciera 
	WHERE
		saldo > 0 
        AND IdPrograma = ".$IdPrograma." 
        AND IdDelegacion = ".$IdDelegacion." 
        
	) a Order by GColonia
    
    
    ";
    
	// echo $MSSQL;
	// $MSSQL = "SELECT @@VERSION";
    $tb = $tb. "<h3>Colonias Detectadas:</h3><table class='tabla'>";
    $tb = $tb."<th>Colonia</th><th>
    <a href='contratos.php?IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Saldo=1&Moratorios=0&Fora=0' title='Haga clic aqui para ver Todos los Contratos con Saldo'>Saldo</a>
    </th><th>
    <a href='contratos.php?IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Saldo=1&Moratorios=1&Fora=0' title='Haga clic aqui para ver Todos los Contratos con Saldo Moratorio'>Moratorio</a>
	</th>";
	// echo $tb;
    $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $MSSQL);
    $array = json_decode($ConsultaDATA, true);
    $error = 0;
    
    $GLabels = "";
    $GValores = "";
    $GValores2 = "";
	
	$data = "['Colonias', 'Saldo', 'Moratorio'],";
	// echo var_dump($ConsultaDATA)."<hr>";

    $TotalSaldo = 0; $TotalMoratorio=0;
    if(is_array($array)){            
        foreach ($array as $value) {
            if (isset($value['r'])){// si hay un error
                echo "*Error: ".$value['r'];
                $error = $value['r'];
            } else {//si no hay errores escribimos
                $tb = $tb."<tr>";
                $tb = $tb."<td>".$value['GColonia']."</td>";
                $tb = $tb."<td title='".$value['ContratosConSaldo']." contratos con saldo, Saldo = $ ".$value['GSaldo']."'>";
                $tb = $tb."<a href='contratos.php?IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Saldo=1&Moratorios=0&Fora=0&Col=".$value['GColonia']."' title='Haga clic aqui para ver Todos los Contratos con Saldo de esta Colonia'>";
                $tb = $tb. "$ ".number_format($value['GSaldo'],2,'.',',');
                $tb = $tb. "</a></td>";
                $tb = $tb."<td title='".$value['ContratosConMoratorio']." contratos con moratorio, Moratorio = $ ".$value['Moratorio']."'>";
                $tb = $tb."<a href='contratos.php?IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Saldo=1&Moratorios=1&Fora=0&Col=".$value['GColonia']."' title='Haga clic aqui para ver Todos los Contratos con Saldo de esta Colonia'>";
                $tb = $tb."$ ".number_format($value['Moratorio'],2,'.',',')."</a></td>";
                $tb = $tb."</tr>";

                $TotalSaldo = $TotalSaldo + $value['GSaldo'];
                $TotalMoratorio = $TotalMoratorio + $value['Moratorio'];

                //almacenamos
                $GLabels = $GLabels."'".$value['GColonia']."',";
                $GValores = $GValores."'".$value['GSaldo']."',";
				$GValores2 = $GValores2."'".$value['Moratorio']."',";
				
				$data = $data."['".$value['GColonia']."',".$value['GSaldo'].", ".$value['Moratorio']."],";

            }


            
        }
        //agremaos totales
        $tb = $tb."<tr style='background-color:black;color:black;font-size:12pt;'>";
        $tb = $tb."<td>TOTAL</td>";
        $tb = $tb."<td style='background-color:#E3D79F; opacity:1;' title='".$TotalSaldo."'>$ ".number_format($TotalSaldo,2,'.',',')."</td>";
        $tb = $tb."<td style='background-color:#484848; opacity:1; color:white;' title='".$TotalMoratorio."'>$ ".number_format($TotalMoratorio,2,'.',',')."</td>";
        $tb = $tb."</tr>";

        //quitamos la ultima coma
        $GLabels = substr($GLabels, 0, -1);
        $GValores = substr($GValores, 0, -1);
		$GValores2 = substr($GValores2, 0, -1);
		$data = substr($data, 0, -1);


        //escribimos la grafica
        // echo "
        // <script>
        // new Chartist.Bar('#ContratosResumenGrafica', {
        //     labels: [".$GLabels."],
        //     series: [
        //       [".$GValores."],
        //       [".$GValores2."]
              
        //     ]
        //   }, {
        //     stackBars: true,
        //     axisY: {
        //       labelInterpolationFnc: function(value) {
        //         return (value / 1000) + 'k';
        //       }
        //     }
        //   }).on('draw', function(data) {
        //     if(data.type === 'bar') {
        //       data.element.attr({
        //         style: 'stroke-width: 30px'
        //       });
        //     }
        //   });
        //   </script>
		// ";
		
		echo "

			<script type='text/javascript'>
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);

			function drawChart() {
				var data = google.visualization.arrayToDataTable([
					".$data."
				]);

				var options = {
				title: 'Resumen de colonias',
				hAxis: {title: 'Año',  titleTextStyle: {color: '#333'}},
				vAxis: {minValue: 0}, legend:'none',
				};

				var chart = new google.visualization.AreaChart(document.getElementById('ContratosResumenGrafica'));
				chart.draw(data, options);
			}
			</script>

		";
        $tb = $tb."</table>";
        echo $tb;
        
    } else {
        echo "ERROR; no se ha sido posible construir este Resumen o Grafico<br>";
    }



    //Contruccion 


} else {
    echo "ERROR: faltan parametros!";
}
















?>

