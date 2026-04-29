<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>



<?php

$id_aplicacion ="ap75"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    xd_update('ap75',$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a ver la Estadistica Temprana de ITAVU | Beneficios [ap75]");
    echo "<br>";
    buscar('beneficios.php', 'Escriba Nombre, Domicilio, Contrato, CURP, NEmpleado .. completo o parte', '');

    // Nitavu1 like '%".$_GET['busqueda']."%' OR
        
    // domicilioColonia like '%".$_GET['busqueda']."%' OR
    // NumContrato like '%".$_GET['busqueda']."%' OR
    // IdSolicitante like '%".$_GET['busqueda']."%' OR
    // CURP like '%".$_GET['busqueda']."%' OR
    // domicilioCalleNum like '%".$_GET['busqueda']."%' OR
    // domicilioLocalidad like '%".$_GET['busqueda']."%'
    echo "<a class='Mbtn btn-default' href='beneficios.php?busqueda=ITAVU'>Ver coincidencias entre Beneficiarios con empleados de ITAVU</a>";
    echo "<label>* La lista de empleados se basa el personal actual apartir de la creación de la Plataforma de ITAVU, no se tiene registro anterior<br></label>";
    echo "<label>* La información mostrada aquí esta actualizada hasta el 29/9/2018 y puede tener duplicados o errores en su captura debido a la situación de la base de datos y que estamos en el proceso de depuracion.</label><br>";
    echo "<label>* Esta aplicación se realizo con el fin ser solo de consulta, en esta primera etapa. Cuando terminen los procesos de depuracion de nuestros sistemas y base de datos
    estara en tiempo real<br></label>";
    echo "<label>* Las coincidencias en empleados se basan en el nombre ya que no todos los beneficiarios tienen capturado el CURP.<br></label>";

    if (isset($_GET['Beneficiario'])){
        historia($nitavu, "Entro a ver al <b> Beneficiario ".$_GET['Beneficiario']."</b> la Estadistica Temprana de ITAVU | Beneficios [ap75]");
        //busqueda a detalle
        echo "<div class='ventana' style='width:95%;'>";
        $sql = "
        select 
        -- DISTINCT NumContrato, 
        NombreCompleto as Beneficiario,
	
            Nitavu1 as QNitavu,
            IdEmpleadoN1 as IdEmpleado,
            (select estado from empleados where nitavu=QNitavu) as estado,
            (select dpto from empleados where nitavu=QNitavu) as IdDpto,
            (select nombre from cat_gerarquia where id=IdDpto) as Departamento,
            (select puesto from empleados where nitavu=QNitavu) as puesto,
            IdDelegacion1 as IdDel,
            (select nombre from cat_delegaciones where id = IdDel) as Delegacion,
            IdPrograma as IdProg,
            (select Descripcion from cat_programa where IdPrograma = IdProg) as Programa,
            CONCAT('Calle ',domicilioCalleNum,', entre las calles  ',domicilioEntre,' y ',domicilioEntreY,'. Col. ',domicilioColonia,' ',domicilioColOtra,'. ',domicilioLocalidad) as domicilio,
           
           
            
            HistoriaSolicitudes_EmpMod as SolicitudEmpMod,
            (select nombre from empleados where nitavu=SolicitudEmpMod limit 1) as SolicitudEmpMod_nombre,
            HistoriaSolicitudes_EmpCrea as SolicitudEmpCrea,
            (select nombre from empleados where nitavu=SolicitudEmpCrea limit 1) as SolicitudEmpCrea_nombre,
            
            HistoriaSolicitante_EmpCrea as SolicitanteEmpCrea,
            (select nombre from empleados where nitavu=SolicitanteEmpCrea limit 1) as SolicitanteEmpCrea_nombre,
            
            HistoriaSolicitante_EmpMod as SolicitanteEmpMod,
            (select nombre from empleados where nitavu=SolicitanteEmpMod limit 1) as SolicitanteEmpMod_nombre,
            
            HistoriaSolicitante_FechaCaptura,

            estadisticatemprana_conempleados.*
            
            
            
            
            
            
            

        from estadisticatemprana_conempleados
        where  
        NombreCompleto like '%".$_GET['Beneficiario']."%'
            
        
        ";
        // echo $sql;
        echo "<table class='tbl_dir'>";
        $r = $conexion -> query($sql);
        while($f = $r -> fetch_array()){
            if ($f['QNitavu']<>'' or $f['IdEmpleado']<>''){
                echo "<tr style='background-color:#D9FFD9; color:black;'>";
            } else{
                echo "<tr>";
            }

            if ($f['QNitavu']<>'' or $f['IdEmpleado']<>''){
                echo "<td>";
                echo ponerfoto("fotos/".$f['QNitavu'].".jpg",'foto_redonda2');
                echo "</td>";
            }

            echo "<td><b>".$f['Beneficiario']."</b><br>";
            echo "<span class=''>CURP: ".$f['CURP']."</span><br>";
            echo "<span class=''>Deleg: ".$f['Delegacion']."</span><br>";
            echo "<span class='tchico '>Domicilio: ".$f['domicilio']."</span><br>";
            echo "<span class=''>Tel: ".$f['Telefono'].". ".$f['TelCelular']."</span><br>";



            if ($f['QNitavu']<>'' or $f['IdEmpleado']<>''){
                echo "<br>De acuerdo al nombre es posible empleado de ITAVU.";
                if ($f['estado']==''){
                    echo "Estado Laboral: activo";
                } else {
                    echo ". Estado Laboral: ".$f['estado'];
                }
            }
            if ($f['QNitavu']<>''){                    
                echo "<label>".$f['puesto']." ".$f['Departamento']."</label>";
                echo "</label style='color:cyan;'>".$f['estado']."</label>";
            }

            echo "</td>";
            


            echo "<td>";
            if ($f['NumContrato']==''){
                echo "Sin contrato registrado<br>";
            } else {
            echo "<b>Contrato: ".$f['NumContrato']."</b>, Saldo: ".$f['Saldo']."<br>";
            }
            echo "IdDel: ".$f['IdDelegacion']." Prog: ".$f['IdPrograma']."(".$f['Programa'].") Folio: ".$f['Folio']."<br>";


            
            echo "</td>";
            

            echo "<td>";
            $historia = 'Movimiento creado el '.$f['HistoriaSolicitante_FechaCaptura'].'
            .SOLICITUD: Creacion por '.$f['SolicitudEmpCrea_nombre'].'('.$f['SolicitudEmpCrea'].')
            , Modificada por '.$f['SolicitudEmpMod_nombre'].'('.$f['SolicitudEmpMod'].') 
            y el SOLICITANTE fue creado por '.$f['SolicitanteEmpCrea_nombre'].'('.$f['SolicitanteEmpCrea'].')
             y modificado por '.$f['SolicitanteEmpMod_nombre'].' ('.$f['SolicitanteEmpMod'].')';
             
             echo "<span style='font-size:8pt;'>".$historia."</span>";
            //  echo "<a href='beneficios.php?Beneficiario=".$f['Beneficiario']."' class='Mbtn btn-default'> > </a>";
            echo "</td>";
            
            echo "</tr>";

        }
        
    
	echo "</table>";
    echo "</div>";

    }

    if (isset($_GET['busqueda'])){//buscamos
        echo "<div class='ventana' style='width:95%;'>";

        if ($_GET['busqueda']=="ITAVU"){
            historia($nitavu, "Vio la lista empleados con Beneficios ITAVU en la Estadistica Temprana de ITAVU | Beneficios [ap75]");
            $sql = "
            select DISTINCT NombreCompleto as Beneficiario,
        
                Nitavu1 as QNitavu,
                IdEmpleadoN1 as IdEmpleado,
                (select estado from empleados where nitavu=QNitavu) as estado,
                (select dpto from empleados where nitavu=QNitavu) as IdDpto,
                (select nombre from cat_gerarquia where id=IdDpto) as Departamento,
                (select puesto from empleados where nitavu=QNitavu) as puesto,
                (select count(DISTINCT NumContrato1 ) from estadisticatemprana_conempleados where NombreCompleto = Beneficiario and NumContrato1 <> '') as Contratos,
                (select count(DISTINCT NumContrato1 ) from estadisticatemprana_conempleados where NombreCompleto = Beneficiario and NumContrato1 <> '' and Saldo>0) as ContratosConSaldo,
                (select count(*) from estadisticatemprana_conempleados where NombreCompleto = Beneficiario and NumContrato1 = '') as SolicitudesSinContrato,
                IdDelegacion1 as IdDel,
                (select nombre from cat_delegaciones where id = IdDel) as Delegacion
                
    
    
            from estadisticatemprana_conempleados
            where  Nitavu1 <> '' or IdEmpleadoN1<>''
                
            
            ";
        } else{
        $sql = "
        select DISTINCT NombreCompleto as Beneficiario,
	
            Nitavu1 as QNitavu,
            IdEmpleadoN1 as IdEmpleado,
            (select estado from empleados where nitavu=QNitavu) as estado,
            (select dpto from empleados where nitavu=QNitavu) as IdDpto,
            (select nombre from cat_gerarquia where id=IdDpto) as Departamento,
            (select puesto from empleados where nitavu=QNitavu) as puesto,
            (select count(DISTINCT NumContrato1 ) from estadisticatemprana_conempleados where NombreCompleto = Beneficiario and NumContrato1 <> '') as Contratos,
            (select count(DISTINCT NumContrato1 ) from estadisticatemprana_conempleados where NombreCompleto = Beneficiario and NumContrato1 <> '' and Saldo>0) as ContratosConSaldo,
            (select count(*) from estadisticatemprana_conempleados where NombreCompleto = Beneficiario and NumContrato1 = '') as SolicitudesSinContrato,
            IdDelegacion1 as IdDel,
            (select nombre from cat_delegaciones where id = IdDel) as Delegacion
            


        from estadisticatemprana_conempleados
        where  
        NombreCompleto like '%".$_GET['busqueda']."%' OR
        Nitavu1 like '%".$_GET['busqueda']."%' OR
        
        domicilioColonia like '%".$_GET['busqueda']."%' OR
        NumContrato like '%".$_GET['busqueda']."%' OR
        IdSolicitante like '%".$_GET['busqueda']."%' OR
        CURP like '%".$_GET['busqueda']."%' OR
        domicilioCalleNum like '%".$_GET['busqueda']."%' OR
        domicilioLocalidad like '%".$_GET['busqueda']."%'

            
        
        ";}
        // echo $sql;
        historia($nitavu, "Busco <b>".$_GET['busqueda']."</b> en Beneficios ITAVU en la Estadistica Temprana de ITAVU | Beneficios [ap75]");
        echo "<table class='tbl_dir'>";
        $r = $conexion -> query($sql);
        while($f = $r -> fetch_array()){
            if ($f['QNitavu']<>'' or $f['IdEmpleado']<>''){
                echo "<tr style='background-color:#D9FFD9;'>";
            } else{
                echo "<tr>";
            }

            if ($f['QNitavu']<>'' or $f['IdEmpleado']<>''){
                echo "<td width=20px>";
                
                echo ponerfoto("fotos/".$f['QNitavu'].".jpg",'foto_redonda2');
                echo "</td>";
            }

            echo "<td><b>".$f['Beneficiario']."</b><br>";
            // echo "<span class='tenue'>".$f['CURP']."<br></span>";
            echo "<span class='tenue'>Deleg: ".$f['Delegacion']."</span>";


            if ($f['QNitavu']<>'' or $f['IdEmpleado']<>''){
                echo "<br>De acuerdo al nombre es posible empleado de ITAVU.";
                if ($f['estado']==''){
                    echo "<br>Estado Laboral: activo";
                } else {
                    echo ". Estado Laboral: ".$f['estado'];
                }
            }
            if ($f['QNitavu']<>''){                    
                echo "<label>".$f['puesto']." ".$f['Departamento']."</label>";
                echo "</label style='color:cyan;'>".$f['estado']."</label>";
            }

            echo "</td>";
            
            echo "<td>";
            echo "Contratos:</b>".$f['Contratos']."</b><br>
            Contratos con Saldo:  ".$f['ContratosConSaldo']."<br>
            solicitudes no Resueltas: ".$f['SolicitudesSinContrato']."<br>";
            
            echo "</td>";
            

            echo "<td width=30px>";
            echo "<a href='beneficios.php?Beneficiario=".$f['Beneficiario']."' class='Mbtn btn-default'> > </a>";
            echo "</td>";
            
            echo "</tr>";

        }
        
    
	echo "</table>";
    echo "</div>";

    }
    
    

    if (!isset($_GET['busqueda']) and !isset($_GET['Beneficiario'])){

        //GRAFICA   Beneficios / solicitudes por año de Tamaulipas
        // echo "<div class='ventana' style='overflow:auto; height:497px; vertical-align:top;'>";
        $sql = "select *
        from estadisticatemprana_beneficiosanio
        where 
        Anio >= 1999 and Anio <> 2019 
        order by Anio";
        $data2="";
        $data2= $data2."

        ['Año', 'SolicitudesNoResueltas','Beneficios'],";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
                $data2= $data2."['".$f['Anio']."', ".$f['SolicitudesNoResueltas'].", ".$f['Beneficios']."],";
                
                
			}        	 
        $data2 = substr($data2, 0, -1); //quita la ultima coma.
	    $grafica2 = "
        <script type='text/javascript' src='lib/gstatic_loader.js'></script>
        <script type='text/javascript'>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([

                        ".$data2."
                        
                    
                        ]);

        var options = {
            title: 'Beneficios / solicitudes por año de Tamaulipas',
            hAxis: {title: 'Beneficios y solicitudes por Año de Tamaulipas',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0},
            legend: {position: 'top', maxLines: 2},
            animation: {
            duration: 3000,
            easing: 'out',
            startup: true
                }


            };
            var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
            chart.draw(data, options);

            //var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));

            
            chart.draw(data, options);

        }
        </script>
        <div id='chart_div2'  class='ventana' ></div>";
        
         echo $grafica2;
        //  echo "</div>";













        //GRAFICA   Beneficios POR DELEGACION        
        $sql = "select *
        from estadisticatemprana_grafica_soldeleg
        
        order by nombre";
        $data2="";
        $data2= $data2."

        ['Delegacion', 'SolicitudesNoResueltas','Beneficios'],";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
                $data2= $data2."['".$f['nombre']."', ".$f['SolicitudesNoResueltas'].", ".$f['Beneficios']."],";
                
                
			}        	 
        $data2 = substr($data2, 0, -1); //quita la ultima coma.
	    $grafica2 = "
        <script type='text/javascript' src='lib/gstatic_loader.js'></script>
        <script type='text/javascript'>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([

                        ".$data2."
                        
                    
                        ]);

        var options = {
            title: 'Beneficios / solicitudes Delegacion',
            hAxis: {title: 'Beneficios y solicitudes por Delegacion',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0},
            legend: {position: 'top', maxLines: 2},
            animation: {
            duration: 3000,
            easing: 'out',
            startup: true
                }


            };
            var chart = new google.visualization.AreaChart(document.getElementById('chart_div3'));
            chart.draw(data, options);

            //var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));

            
            chart.draw(data, options);

        }
        </script>
        <div id='chart_div3'  class='ventana' ></div>";
        
         echo $grafica2;
        //  echo "</div>";








        //GRAFICA   Beneficios POR programa        
        $sql = "select 
            *
            
        from estadisticatemprana_graficaprogramas
        
        order by Beneficios limit 100 ";
        $data2="";
        $data2= $data2."

        ['Programa', 'SolicitudesNoResueltas','Beneficios'],";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
                $data2= $data2."['".$f['Programa']."', ".$f['SolicitudesNoResueltas'].", ".$f['Beneficios']."],";
                
                
			}        	 
        $data2 = substr($data2, 0, -1); //quita la ultima coma.
	    $grafica4 = "
        <script type='text/javascript' src='lib/gstatic_loader.js'></script>
        <script type='text/javascript'>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([

                        ".$data2."
                        
                    
                        ]);

        var options = {
            title: 'Beneficios / solicitudes Programa',
            hAxis: {title: 'Beneficios y solicitudes por Programa',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0},
            legend: {position: 'top', maxLines: 2},
            animation: {
            duration: 3000,
            easing: 'out',
            startup: true
                }


            };
            var chart = new google.visualization.AreaChart(document.getElementById('chart_div4'));
            chart.draw(data, options);

            //var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));

            
            chart.draw(data, options);

        }
        </script>
        <div id='chart_div4'  class='ventana' style='width:97%;' ></div>";
        // echo $data2;
         echo $grafica4;
        //  echo "</div>";



        
        //GRAFICA   Sexo        
        $sql = "select 
        (select count(*) from estadisticatemprana_gral where Sexo=1 and NumContrato<>'') as Mujeres_beneficios,
        (select count(*) from estadisticatemprana_gral where Sexo=2 and NumContrato<>'') as Hombres_beneficios
        ";
        $data2="";
        $data2= $data2."

        ['Sexo', 'Cantidad'],";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
                $data2= $data2."['Mujeres', ".$f['Mujeres_beneficios']."],";
                $data2= $data2."['Hombres', ".$f['Hombres_beneficios']."],";
                
                
                
			}        	 
        $data2 = substr($data2, 0, -1); //quita la ultima coma.
	    $grafica4 = "
        <script type='text/javascript' src='lib/gstatic_loader.js'></script>
        <script type='text/javascript'>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([

                        ".$data2."
                        
                    
                        ]);

        var options = {
            title: 'Beneficios ITAVU',
            hAxis: {title: 'Beneficios ITAVU',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0},
            legend: {position: 'top', maxLines: 2},
            animation: {
            duration: 3000,
            easing: 'out',
            startup: true
                }


            };
            //var chart = new google.visualization.AreaChart(document.getElementById('chart_div6'));
            //chart.draw(data, options);

            var chart = new google.visualization.PieChart(document.getElementById('chart_div6'));

            
            chart.draw(data, options);

        }
        </script>
        <div id='chart_div6'  class='ventana'  ></div>";
        // echo $data2;
         echo $grafica4;
        //  echo "</div>";


        
        
        //GRAFICA   Sexo        
        $sql = "select 
        (select count(*) from estadisticatemprana_gral where Sexo=1 and NumContrato='') as Mujeres_beneficios,
        (select count(*) from estadisticatemprana_gral where Sexo=2 and NumContrato='') as Hombres_beneficios
        ";
        $data2="";
        $data2= $data2."

        ['Sexo', 'Cantidad'],";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
                $data2= $data2."['Mujeres', ".$f['Mujeres_beneficios']."],";
                $data2= $data2."['Hombres', ".$f['Hombres_beneficios']."],";
                
                
                
			}        	 
        $data2 = substr($data2, 0, -1); //quita la ultima coma.
	    $grafica4 = "
        <script type='text/javascript' src='lib/gstatic_loader.js'></script>
        <script type='text/javascript'>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([

                        ".$data2."
                        
                    
                        ]);

        var options = {
            title: 'solicitudes No resueltas ITAVU',
            hAxis: {title: 'solicitudes ITAVU',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0},
            legend: {position: 'top', maxLines: 2},
            animation: {
            duration: 3000,
            easing: 'out',
            startup: true
                }


            };
            //var chart = new google.visualization.AreaChart(document.getElementById('chart_div6'));
            //chart.draw(data, options);

            var chart = new google.visualization.PieChart(document.getElementById('chart_div7'));

            
            chart.draw(data, options);

        }
        </script>
        <div id='chart_div7'  class='ventana'  ></div>";
        // echo $data2;
         echo $grafica4;
        //  echo "</div>";



        // echo sugerencia("
        // <p>La información mostrada aquí esta actualizada hasta el 29/9/2018 y puede tener duplicados o errores en su captura debido 
        // a la situación de la base de datos y que estamos en el proceso de depuracion.</p>

        // <p>Esta herramienta es creada como apoyo de consulta, una vez terminado el proyecto de la plataforma estos mismos datos seran presentados 
        // con mayor certeza y en tiempo real.
        // </p>
        
        // ");




    }




} else {
    mensaje("ERROR: no tiene acceso a esta aplicacion",'');
}

?>



<?php include ("./lib/body_footer.php"); ?>