<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>
<div id="infomaps">

<?php

$id_aplicacion ="notGeo"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
historia($nitavu,"notGeo: Esta usando la aplicacion");
xd_update('notGeo',$nitavu);//guarda la experiencia del usuario
//Vairables de Test
$Lat = "23.7462006";
$Lon = "-99.1103095";
$Titulo = "El Titulo";
$Div="<h1>titulo</h1>";
// $Div = "

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

    //para seleccionar colonia
    echo "<form action='notGeo.php' action='GET'>";
    echo "<input name='r' type='hidden' value='30'>";
    echo "<input  name='q' list='colonias' placeholder='Id de la Colonia'>";
    echo '';
      
       $sql ="
       SELECT
          colonia as colonia,
          IdMunicipio as IdMun,
          (select cat_municipios.nombre from cat_municipios WHERE cat_municipios.idmunicipio = IdMun) as Municipio,
          idcolp
       FROM
          cat_colonias
       WHERE  colonia not like '%ELIMIN%' order by colonia
       ";
       echo "<datalist id='colonias' style='display:none;'>";
 
       $r= $conexion -> query($sql);
       while($f = $r -> fetch_array()) {      
          echo '<option value="'.$f['idcolp'].'">'.$f['colonia'].', '.$f['Municipio'].'</option>';
                
          }
    echo "</datalist>";
    // echo "<input type='submit' value='ok'>";
    echo "</form>";

       //((((((encontrar el centrado))))))
       if (isset($_GET['q']) ){
        $IdColonia = COLIdColonia($_GET['q']); $IdMunicipio = COLIdMunicipio($_GET['q']);
        $sql = "select * from notificaciones_vivienda where latitud <> ''and longitud <> '' and idmunicipio='".$IdMunicipio."' and idcolonia='".$IdColonia."' order by latitud DESC limit 1 ";
    }else { $sql = "select * from notificaciones_vivienda where latitud <> ''and longitud <> '' order by latitud DESC limit 1 "; }
    // echo $sql;
    $CenterLat= 0; $v = 0; $rLat= $conexion -> query($sql); while($fLat = $rLat -> fetch_array()) 
    {
        $CenterLat = $CenterLat + $fLat['latitud']; $v = $v+1;
    }
    //$CenterLat = $CenterLat / $v -1 ;
   
  if($CenterLat <> 0){
        $CenterLat = $CenterLat / $v -1 ;
    }else{
        $CenterLat = $Lat;
    }
    

    if (isset($_GET['q']) ){
        $IdColonia = COLIdColonia($_GET['q']); $IdMunicipio = COLIdMunicipio($_GET['q']);
        $sql = "select * from notificaciones_vivienda where  <> ''and longitud <> '' and idmunicipio='".$IdMunicipio."' and idcolonia='".$IdColonia."' order by longitud ASC limit 1 ";
    }else { $sql = "select * from notificaciones_vivienda where latitud <> ''and longitud <> '' order by longitud ASC limit 1 "; }
    // echo $sql;
    $CenterLon= 0;  $v= 0; $rLon= $conexion -> query($sql); while($fLon = $rLon -> fetch_array()) {
        $CenterLon = $CenterLon + $fLon['longitud']; $v = $v +1;
    }
    //$CenterLon = $CenterLon / $v -1;
    
    if($CenterLon <> 0){
        $CenterLon = $CenterLon / $v -1;
    }else{
        $CenterLon=$Lon;
    }

    






        if (isset($_GET['q']) ){
            $IdColonia = COLIdColonia($_GET['q']);
            $IdMunicipio = COLIdMunicipio($_GET['q']);
            $sql = "select * from notificaciones_vivienda where latitud <> ''and longitud <> '' and idmunicipio='".$IdMunicipio."' and idcolonia='".$IdColonia."' order by fecha limit 100";
            
            $query = "select * from notificaciones_vivienda where idmunicipio='".$IdMunicipio."' and idcolonia='".$IdColonia."'";
            $r = $conexion -> query($query);
            $Total = $r -> num_rows;


           
            
            

           
            $query1 = "select * from notificaciones_vivienda where idmunicipio='".$IdMunicipio."' and idcolonia='".$IdColonia."' and realizada = 0";
            $r1 = $conexion -> query($query1);
            $faltantes = $r1 -> num_rows;
            $query2 = "select * from notificaciones_vivienda where idmunicipio='".$IdMunicipio."' and idcolonia='".$IdColonia."' and realizada = 1";
            $r2 = $conexion -> query($query2);
            $realizadas = $r2 -> num_rows;
            $query3 = "select * from notificaciones_vivienda where idmunicipio='".$IdMunicipio."' and idcolonia='".$IdColonia."' and nombreprop_actual <> ''";
            $r3 = $conexion -> query($query3);
            $traspasos = $r3 -> num_rows;
            //echo $query3;
            if($Total > 0){
                echo "<div   style='float: left; width: 50%;' id='mapax' ></div>";
                echo "<div style='float: right; width: 50%;' ><h1>Información de la colonia</h1>";
                echo '<center><div id="piechart" style="height:40%"></div>';
               
                echo '<div id="grafica_traspasos" style="height:40%"></div></center>';
                echo "</div>";
                echo "<script type='text/javascript'>
                    // Load google charts
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    
                    // Draw the chart and set the chart values
                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['hey', 'hey'],
                        ['Realizadas', ".$realizadas."],
                        ['Faltantes', ".$faltantes."],
                        
                        ]);
                        
                        // Optional; add a title and set the width and height of the chart
                        var options = {
                            'title':'Notificaciones entregadas en esta colonia',
                            'width':400,
                            'height':350
                        };
                        
                        // Display the chart inside the <div> element with id='piechart'
                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                        chart.draw(data, options);
                    }

                    google.charts.setOnLoadCallback(drawTrendlines);
            
                    function drawTrendlines() {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Traspasos');
                        data.addColumn('number', 'Total lotes traspasados');
                    
                        data.addRows([
                            ['Traspasos',".$traspasos."]
                        ]);
                    
                        var options = {
                            width: 400,
                            height: 350,
                            title: 'Traspasos',
                            hAxis: {
                            title: 'Traspaso de lotes',
                            },
                            vAxis: {
                            title: 'Rating'
                            },
                            colors: ['green'],
                            bar: { groupWidth: '20%' }
                        };
                    
                        var chart = new google.visualization.ColumnChart(document.getElementById('grafica_traspasos'));
                        chart.draw(data, options);
                    }
                 
                  
                </script>";

                
         
            
           
            }else{
                sentimental('Lo sentimos, no hay resultados para esta colonia.');
            }
            
            
            
        
        }else {
            echo "<div id='mapax'></div>";
            $sql = "select * from notificaciones_vivienda where latitud <> ''and longitud <> '' order by fecha limit 100";
        }
        // echo $sql;

            //(((((((((((((((())))))))))))))))
    echo "
    <script type='text/javascript'>
        function initMap() {

            var myLatlng = new google.maps.LatLng(".$CenterLat.", ".$CenterLon.");
            var map = new google.maps.Map(document.getElementById('mapax'), {
            zoom: 14,
            center: myLatlng,
            mapTypeId: 'satellite'
     	  
        });
        ";
//center, tomara la longitud mas alta y la longitud mas baja de la consulta para centrarse

            $r= $conexion -> query($sql);
            $c = 1;
            echo "
            var iconBaldio = 'https://plataformaitavu.tamaulipas.gob.mx/icon/marker_baldio.png';
            var iconComercio = 'https://plataformaitavu.tamaulipas.gob.mx/icon/marker_comercio.png';
            var iconHabitado = 'https://plataformaitavu.tamaulipas.gob.mx/icon/marker_habitado.png';
            var iconRentado = 'https://plataformaitavu.tamaulipas.gob.mx/icon/marker_rentado.png';
            var iconEnConstruccion = 'https://plataformaitavu.tamaulipas.gob.mx/icon/marker_enconstruccion.png';
            var iconDeshabitado = 'https://plataformaitavu.tamaulipas.gob.mx/icon/marker_deshabitado.png';
            var iconMixto = 'https://plataformaitavu.tamaulipas.gob.mx/icon/marker_mixto.png';
        ";
            while($f = $r -> fetch_array()) {
            $archivo=obtenerultimafotonot($f['numcontrato'],$f['campaña']);
             $info = '<div><h1>'.$f['nombre'].'</h1>Contrato: '.$f['numcontrato'].', IdLote: '.$f['idlote'].'<br>Delegacion: '.$f['delegacion'].'<br>Fecha de Entrega: '.$f['fecha_entrega'].'<br>Comentarios: '.$f['comentarios'].'<br><img id="mi_imagen" style="width:200px; height:200px;" src="img/sinfoto.jpg" ></img></div>';
            // $info = "Test";
            //Creamos los
           
           
            $Icono = "";
            $EstadoDelLote = $f['estado_lote'];
            echo $EstadoDelLote;
            switch ($EstadoDelLote) {
                case 0:
                    $Icono = "";
                    break;
                case 1:
                    $Icono = "iconBaldio";
                    break;
                case 2:
                    $Icono = "iconComercio";
                    break;
                case 3:
                    $Icono = "iconHabitado";
                    break;
                case 4:
                    $Icono = "iconRentado";
                    break;
                case 5:
                    $Icono = "iconEnConstruccion";
                    break;
                case 6:
                    $Icono = "iconDeshabitado";
                    break;

                case 7:
                    $Icon = "iconMixto";
                    break;
                default:
                    $Icon = "";                    
                    break;

            }
            
            echo "
                var marker".$c." = new google.maps.Marker({ position: new google.maps.LatLng(".$f['latitud'].", ".$f['longitud']."),                     
                map: map, animation: google.maps.Animation.DROP, ";
                if ($Icono <> ""){
                    echo "icon: ".$Icono."";
                }

                echo " });   
                var infowindow".$c." = new google.maps.InfoWindow({ content: '".$info."' });   
                google.maps.event.addListener(marker".$c.", 'click', function() {   

                    $.ajax({
            
                        url: 'descargamapa.php',
                        type: 'get',
                        data: {nombre: '".$archivo."' },
                        success: function(data){                        
                            console.log('puso los registros');
                            $('#mi_imagen').attr('src','tmp/'+data);

                        }
                    });

                infowindow".$c.".open(map, marker".$c."); 
            
            
            }); 
            
            ";

        


            $c = $c+1;
            }
            
           




        echo "}";



   echo "</script>";
}else {
    mensaje("ERROR: no tiene acceso a esta aplicacion","");
}
?>


    <?php 
    echo '
    <script src="https://maps.googleapis.com/maps/api/js?key='.$key_geo.'&callback=initMap"
    async defer></script>';


    ?>


<?php
    include ("./lib/body_footer.php");
?>


