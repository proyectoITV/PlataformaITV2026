<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php"); include ("./lib/body_menu.php");


?>
<?php
$id_aplicacion ="ap47"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
// $nivel= 3;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

$munis='TRUE';
if (isset($_GET['m'])) {} else { $munis='FALSE';}
if ($_GET['m']=='') {$munis='FALSE';}
//echo $munis;

if ($munis=='FALSE')
{
  historia($nitavu,"Vio Resumen Global de la aplicacion sobre las notificaciones que no entregaron (".$id_aplicacion.")");
   echo "<div id='indicadores'>";
   echo "<h3>RESUMEN GLOBAL</h3>";

//grafica transpaso

               echo "<div id='colonias'>";
               $sql = "
             SELECT
               count(*) as visitadas,
               
               (select count(*) from notificadores_visitas where visitada='TRUE' and vobo<>'') as total
             
            FROM  
               notificadores_visitas

            WHERE 
               visitada='TRUE' 
               AND entregada='FALSE'
               AND vobo <>''
               AND id_estado_lote <>'1'
               AND id_estado_lote <>'6'
               
               ";
               //echo $sql;
                $r= $conexion -> query($sql);   
               //  ['Task', 'Hours per Day'],
           //         ['Work',     11],
           //         ['Eat',      2],
           //         ['Commute',  2],
           //         ['Watch TV', 2],
           //         ['Sleep',    7]
               $data ="['Entrevista','Total'],";

               echo "<h3>NOTIFICACION QUE NO ENTREGARON</h3>";
                  echo "<table class='tabla3' width='100%'>";                 
                  echo "<th>Total Visitadas</th>";
                  echo "<th>Sin entregar</th>";
                 // echo "<th>Porcentaje</th>";           
                 
                  


               while($t = $r -> fetch_array())     
               {  
                  echo "<tr>";
                  echo "<td>".$t['total']."</td>";
                  echo "<td>".$t['visitadas']."</td>";
                 // echo "<td>".$t['porcentaje']."%</td>";

                        
                  echo "</tr>";

                  $data = $data."['total', ".$t['total']."],";
                  $data = $data."['visitadas' ,".$t['visitadas']."],";
                 
                  
               

               }
               echo "</table>";

               //echo $data;
               $grafica8 = "
               <script type='text/javascript'>
               google.charts.load('current', {packages:['corechart']});
                  google.charts.setOnLoadCallback(drawChart);
                  function drawChart() {
                  var data = google.visualization.arrayToDataTable([
                 ".$data."
               ]);

               var options = {
                     title: 'Transpasos',
                     pieHole: 0,
                  };

               var chart = new google.visualization.PieChart(document.getElementById('chart_top8'));
               chart.draw(data, options);
                  }
                  </script>
                 <div id='chart_top8' style='width: 100%; background-color:white;' ></div>";
                echo $grafica8;
                echo "</div>";





               // grafica por estado
               echo "<div id='colonias'>";
               $sql = "
               SELECT
                  DISTINCT (notificadores_visitas.id_estado_lote) as noti_id_estado_lote,
                  (select cat_estado_lotes.nombre from cat_estado_lotes where cat_estado_lotes.id = noti_id_estado_lote) as Estado,
                  (select count(*) from notificadores_visitas where 
                           visitada='TRUE' 
                           AND entregada='FALSE'
                           AND vobo <>''
                           AND id_estado_lote <>'1'
                           AND id_estado_lote <>'6'
                           AND notificadores_visitas.id_estado_lote = noti_id_estado_lote) as incidencia

                  
                  
                  
               FROM  
                  notificadores_visitas

               WHERE 
                  visitada='TRUE' 
                  AND entregada='FALSE'
                  AND vobo <>''
                  AND id_estado_lote <>'1'
                  AND id_estado_lote <>'6'

               
               ";
               //echo $sql;
                $r= $conexion -> query($sql);   
               $datai2 ="['Entrevista','Total'],";

                  echo "<h3>No se entregaron segun Estado del Lote</h3>";
                  echo "<table class='tabla3' width='100%'>";                 
                  echo "<th>ESTADO</th>";
                  echo "<th>incidencia</th>";
                 // echo "<th>Porcentaje</th>";           
                 
                  


               while($t = $r -> fetch_array())     
               {  
                  echo "<tr>";
                  echo "<td>".$t['Estado']."</td>";
                  echo "<td>".$t['incidencia']."</td>";
                 // echo "<td>".$t['porcentaje']."%</td>";

                        
                  echo "</tr>";

                   $datai2 = $datai2."['".$t['Estado']."', ".$t['incidencia']."],";
                  
                 
                  
               

               }
               echo "</table>";

               //echo $data;
               $grafica_e = "
               <script type='text/javascript'>
               google.charts.load('current', {packages:['corechart']});
                  google.charts.setOnLoadCallback(drawChart);
                  function drawChart() {
                  var data = google.visualization.arrayToDataTable([
                 ".$datai2."
               ]);

               var options = {
                     title: 'Transpasos',
                     pieHole: 0,
                  };

               var chart = new google.visualization.PieChart(document.getElementById('chart_i2'));
               chart.draw(data, options);
                  }
                  </script>
                 <div id='chart_i2' style='width: 100%; background-color:white;' ></div>";
                echo $grafica_e;
                echo "</div>";




                  //grafica incidencias


               echo sugerencia("La informacion que aparece aqui, es la que esta verificada por la delegacion, y no se contempla el estado Baldio y Deshabitado");


               //LISTA
               echo "<br><br>";
               $sql = "
select 
    CONCAT('<b>',notificadores_visitas.nombre, ' </b>',notificadores_visitas.paterno, ' ',notificadores_visitas.materno) as nombre,
    notificadores_visitas.contrato,
    notificadores_visitas.id_colonia as t_id_colonia,
    notificadores_visitas.id_municipio as t_id_municipio,
    (select cat_colonias.Colonia from cat_colonias where cat_colonias.IdColonia = t_id_colonia and cat_colonias.IdMunicipio = t_id_municipio) as Colonia,
    (select cat_municipios.nombre from cat_municipios where cat_municipios.IdMunicipio = t_id_municipio) as Municipio,
      notificadores_visitas.id_estado_lote as id_estado,
   ( select cat_estado_lotes.nombre from cat_estado_lotes where cat_estado_lotes.id = id_estado) as Estado,
   
      notificadores_visitas.*

FROM  
    notificadores_visitas
WHERE
   visitada='TRUE' 
   AND entregada='FALSE'
   AND vobo <>''
   AND id_estado_lote <>'1'
   AND id_estado_lote <>'6'


   
               ";
               //echo $sql;
                $r2= $conexion -> query($sql);   
               //  ['Task', 'Hours per Day'],
           //         ['Work',     11],
           //         ['Eat',      2],
           //         ['Commute',  2],
           //         ['Watch TV', 2],
           //         ['Sleep',    7]
               $data ="['Entrevista','Total'],";

               echo "<h3>LISTA DE NOTIFICACIONES NO ENTREGADAS</h3>";
                  echo "<table class='tabla' width='100%'>";                 
                  echo "<th class='pc'>Nombre</th>";
                  //echo "<th class='pc'>Contrato</th>";
                  //echo "<th class='pc'>Manzana, Lote y Col.</th>";           
                  echo "<th>Informacion</th>";    
                  echo "<th></th>";      
                  echo "<th></th>";      

               while($f = $r2 -> fetch_array())     
               {  
                  echo "<tr>";
                  echo "<td class='pc'><b>".$f['nombre']."</b> <b class='tenue'> ".$f['paterno']." ".$f['materno']."</b></td>";
                  //echo "<td class='pc'>".$f['contrato']."</td>";
                  $dom="M".$f['manzana']." L".$f['lote'].", Col. ".$f['Colonia'].", ".$f['Municipio'];
                  //echo "<td class='pc'>".$dom."</td>";
                  echo "<td>";
                  echo "<span class='movil'>";
                  echo "Contrato: ".$f['contrato']."<br>";
                  echo "<b class='tenue tchico'>".$dom."</b>";
                  if ($f['Estado']==''){
                     echo "<br><b class='seleccionada titilar'>NO SE CAPTURO EL ESTADO DE EL LOTE ".$f['Estado']."</b><br>";
                  }else
                  {
                     echo "<br><b class='normal'>Estado ".$f['Estado']."</b><br>";

                  }
                  
                  echo "</span>";
                  echo $f['visita_comentarios'];
                  echo "</td>";

                  echo "<td>";
                     $archivo_foto = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_lote.jpg';       
                     $title= "Manzana ".$f['manzana']." Lote ".$f['lote'];
                     $des = "Beneficiario: ".$f['nombre']." ".$f['paterno']." ".$f['materno']."<br>";
                     $des = $des." Col. ".colonia_nombre($f['id_colonia'], $f['id_municipio'])."<br>";
                     $des = $des."Contrato: ".$f['contrato']."";
                     $des = $des."<br><br>Visita hecha por <b>".nitavu_nombre($f['notificador_nitavu'])."</b> a las ".$f['visita_hora']." de ".$f['visita_fecha']." y Verificada (Vo.Bo.) Vo.Bo. por <b> ".nitavu_nombre($f['vobo'])."</b>";

                     $div = "<h1>".$title."</h1><div>".$des."<div>"."<img width=400px src=".$archivo_foto."><br> Clasificada como ".id_estado_lote_nombre($f['id_estado_lote']);

                     echo " <a class='Mbtn btn-tercero ' href='
                     geomapa.php?lat=".$f['visita_lat']."&lon=".$f['visita_lon']."&title=".$title."&div=".$div."'>";

                     echo "<img src='icon/mapa.png' >";

                     echo "</a>";


                  echo "</td>";
                
                  echo "<td>";                
                     echo " <a href='notificadores_visita2.php?brig=".$f['brigada_id']."&col=".$f['id_colonia']."&mun=".$f['id_municipio']."&m=".$f['manzana']."     &l=".$f['lote']."'";
                     echo "class='Mbtn btn-tercero'>";
                     echo "<img src='icon\mas.png'>"; 
                     echo "</a>";
                           
                  echo "</td>";
                  echo "</tr>";

                 
                  
               

               }
               echo "</table>";
               







         echo sugerencia("<p class='tchico'>Para ver por municipio, de un clic sobre el que corresponda. La información contenida aqui, aparece hasta que delegación da el Vo.Bo. de la Visita </p>");
   echo "</div>";
} else { /// si selecciono un municipio, listar las delegaciones://////////////////////////////////////////////
   echo "<div id='indicadores'>";
   echo "<h3>RESUMEN DE ".municipio_nombre($_GET['m'])."</h3>";
   historia($nitavu,"Vio Resumen de ".municipio_nombre($_GET['m'])." de la aplicacion sobre las notificaciones que no entregaron (".$id_aplicacion.")");

//grafica transpaso

               echo "<div id='colonias'>";
               $sql = "
             SELECT
               count(*) as visitadas,
               
               (select count(*) from notificadores_visitas where visitada='TRUE' and vobo<>'' and notificadores_visitas.id_municipio='".$_GET['m']."') as total
             
            FROM  
               notificadores_visitas

            WHERE 
               visitada='TRUE' 
               AND entregada='FALSE'
               AND vobo <>''
               AND id_estado_lote <>'1'
               AND id_estado_lote <>'6'
               AND id_municipio = '".$_GET['m']."'
               
               ";
               //echo $sql;
                $r= $conexion -> query($sql);   
               //  ['Task', 'Hours per Day'],
           //         ['Work',     11],
           //         ['Eat',      2],
           //         ['Commute',  2],
           //         ['Watch TV', 2],
           //         ['Sleep',    7]
               $data ="['Entrevista','Total'],";

               echo "<h3>NOTIFICACION QUE NO ENTREGARON</h3>";
                  echo "<table class='tabla3' width='100%'>";                 
                  echo "<th>Total Visitadas</th>";
                  echo "<th>Sin entregar</th>";
                 // echo "<th>Porcentaje</th>";           
                 
                  


               while($t = $r -> fetch_array())     
               {  
                  echo "<tr>";
                  echo "<td>".$t['total']."</td>";
                  echo "<td>".$t['visitadas']."</td>";
                 // echo "<td>".$t['porcentaje']."%</td>";

                        
                  echo "</tr>";

                  $data = $data."['total', ".$t['total']."],";
                  $data = $data."['visitadas' ,".$t['visitadas']."],";
                 
                  
               

               }
               echo "</table>";

               //echo $data;
               $grafica8 = "
               <script type='text/javascript'>
               google.charts.load('current', {packages:['corechart']});
                  google.charts.setOnLoadCallback(drawChart);
                  function drawChart() {
                  var data = google.visualization.arrayToDataTable([
                 ".$data."
               ]);

               var options = {
                     title: 'Transpasos',
                     pieHole: 0,
                  };

               var chart = new google.visualization.PieChart(document.getElementById('chart_top8'));
               chart.draw(data, options);
                  }
                  </script>
                 <div id='chart_top8' style='width: 100%; background-color:white;' ></div>";
                echo $grafica8;
                echo "</div>";





               // grafica por estado
               echo "<div id='colonias'>";
               $sql = "
               SELECT
                  DISTINCT (notificadores_visitas.id_estado_lote) as noti_id_estado_lote,
                  (select cat_estado_lotes.nombre from cat_estado_lotes where cat_estado_lotes.id = noti_id_estado_lote ) as Estado,
                  (select count(*) from notificadores_visitas where 
                           visitada='TRUE' 
                           AND entregada='FALSE'
                           AND vobo <>''
                           AND id_estado_lote <>'1'
                           AND id_estado_lote <>'6'
                           AND id_municipio = '".$_GET['m']."'
                           AND notificadores_visitas.id_estado_lote = noti_id_estado_lote) as incidencia

                  
                  
                  
               FROM  
                  notificadores_visitas

               WHERE 
                  visitada='TRUE' 
                  AND entregada='FALSE'
                  AND vobo <>''
                  AND id_estado_lote <>'1'
                  AND id_estado_lote <>'6'
                  AND id_municipio = '".$_GET['m']."'

               
               ";
               //echo $sql;
                $r= $conexion -> query($sql);   
               $datai2 ="['Entrevista','Total'],";

                  echo "<h3>No se entregaron segun Estado del Lote</h3>";
                  echo "<table class='tabla3' width='100%'>";                 
                  echo "<th>ESTADO</th>";
                  echo "<th>incidencia</th>";
                 // echo "<th>Porcentaje</th>";           
                 
                  


               while($t = $r -> fetch_array())     
               {  
                  echo "<tr>";
                  echo "<td>".$t['Estado']."</td>";
                  echo "<td>".$t['incidencia']."</td>";
                 // echo "<td>".$t['porcentaje']."%</td>";

                        
                  echo "</tr>";

                   $datai2 = $datai2."['".$t['Estado']."', ".$t['incidencia']."],";
                  
                 
                  
               

               }
               echo "</table>";

               //echo $data;
               $grafica_e = "
               <script type='text/javascript'>
               google.charts.load('current', {packages:['corechart']});
                  google.charts.setOnLoadCallback(drawChart);
                  function drawChart() {
                  var data = google.visualization.arrayToDataTable([
                 ".$datai2."
               ]);

               var options = {
                     title: 'Transpasos',
                     pieHole: 0,
                  };

               var chart = new google.visualization.PieChart(document.getElementById('chart_i2'));
               chart.draw(data, options);
                  }
                  </script>
                 <div id='chart_i2' style='width: 100%; background-color:white;' ></div>";
                echo $grafica_e;
                echo "</div>";




               echo sugerencia("La informacion que aparece aqui, es la que esta verificada por la delegacion, y no se contempla el estado Baldio y Deshabitado");


               //LISTA
               echo "<br><br>";
               $sql = "
select 
    CONCAT('<b>',notificadores_visitas.nombre, ' </b>',notificadores_visitas.paterno, ' ',notificadores_visitas.materno) as nombre,
    notificadores_visitas.contrato,
    notificadores_visitas.id_colonia as t_id_colonia,
    notificadores_visitas.id_municipio as t_id_municipio,
    (select cat_colonias.Colonia from cat_colonias where cat_colonias.IdColonia = t_id_colonia and cat_colonias.IdMunicipio = t_id_municipio) as Colonia,
    (select cat_municipios.nombre from cat_municipios where cat_municipios.IdMunicipio = t_id_municipio) as Municipio,
      notificadores_visitas.id_estado_lote as id_estado,
   ( select cat_estado_lotes.nombre from cat_estado_lotes where cat_estado_lotes.id = id_estado) as Estado,
   
      notificadores_visitas.*

FROM  
    notificadores_visitas
WHERE
   visitada='TRUE' 
   AND entregada='FALSE'
   AND vobo <>''
   AND id_estado_lote <>'1'
   AND id_estado_lote <>'6'
   AND id_municipio = '".$_GET['m']."'


   
               ";
               //echo $sql;
                $r2= $conexion -> query($sql);   
               //  ['Task', 'Hours per Day'],
           //         ['Work',     11],
           //         ['Eat',      2],
           //         ['Commute',  2],
           //         ['Watch TV', 2],
           //         ['Sleep',    7]
               $data ="['Entrevista','Total'],";

               echo "<h3>LISTA DE NOTIFICACIONES NO ENTREGADAS</h3>";
                  echo "<table class='tabla' width='100%'>";                 
                  echo "<th class='pc'>Nombre</th>";
                  //echo "<th class='pc'>Contrato</th>";
                  //echo "<th class='pc'>Manzana, Lote y Col.</th>";           
                  echo "<th>Informacion</th>";    
                  echo "<th></th>";      
                  echo "<th></th>";      

               while($f = $r2 -> fetch_array())     
               {  
                  echo "<tr>";
                  echo "<td class='pc'><b>".$f['nombre']."</b> <b class='tenue'> ".$f['paterno']." ".$f['materno']."</b></td>";
                  //echo "<td class='pc'>".$f['contrato']."</td>";
                  $dom="M".$f['manzana']." L".$f['lote'].", Col. ".$f['Colonia'].", ".$f['Municipio'];
                  //echo "<td class='pc'>".$dom."</td>";
                  echo "<td>";
                  echo "<span class='movil'>";
                  echo "Contrato: ".$f['contrato']."<br>";
                  echo "<b class='tenue tchico'>".$dom."</b>";
                  if ($f['Estado']==''){
                     echo "<br><b class='seleccionada titilar'>NO SE CAPTURO EL ESTADO DE EL LOTE ".$f['Estado']."</b><br>";
                  }else
                  {
                     echo "<br><b class='normal'>Estado ".$f['Estado']."</b><br>";

                  }
                  
                  echo "</span>";
                  echo $f['visita_comentarios'];
                  echo "</td>";

                  echo "<td>";
                     $archivo_foto = 'notificadores/'.$f['contrato'].'_'.$f['visita_fecha'].'_lote.jpg';       
                     $title= "Manzana ".$f['manzana']." Lote ".$f['lote'];
                     $des = "Beneficiario: ".$f['nombre']." ".$f['paterno']." ".$f['materno']."<br>";
                     $des = $des." Col. ".colonia_nombre($f['id_colonia'], $f['id_municipio'])."<br>";
                     $des = $des."Contrato: ".$f['contrato']."";
                     $des = $des."<br><br>Visita hecha por <b>".nitavu_nombre($f['notificador_nitavu'])."</b> a las ".$f['visita_hora']." de ".$f['visita_fecha']." y Verificada (Vo.Bo.) Vo.Bo. por <b> ".nitavu_nombre($f['vobo'])."</b>";

                     $div = "<h1>".$title."</h1><div>".$des."<div>"."<img width=400px src=".$archivo_foto."><br> Clasificada como ".id_estado_lote_nombre($f['id_estado_lote']);

                     echo " <a class='Mbtn btn-tercero ' href='
                     geomapa.php?lat=".$f['visita_lat']."&lon=".$f['visita_lon']."&title=".$title."&div=".$div."'>";

                     echo "<img src='icon/mapa.png' >";

                     echo "</a>";


                  echo "</td>";
                
                  echo "<td>";                
                     echo " <a href='notificadores_visita2.php?brig=".$f['brigada_id']."&col=".$f['id_colonia']."&mun=".$f['id_municipio']."&m=".$f['manzana']."     &l=".$f['lote']."'";
                     echo "class='Mbtn btn-tercero'>";
                     echo "<img src='icon\mas.png'>"; 
                     echo "</a>";
                           
                  echo "</td>";
                  echo "</tr>";

                 
                  
               

               }
               echo "</table>";
               







         echo sugerencia("<p class='tchico'>Para ver por municipio, de un clic sobre el que corresponda. La información contenida aqui, aparece hasta que delegación da el Vo.Bo. de la Visita </p>");
         echo "<br><a href='notificadores_sinentregar.php?m=' class='Mbtn btn-tercero'>Ver Resumen Global</a>";
   echo "</div>";

}   


          


















} else {mensaje("No tiene acceso a esta aplicacion",'');}




?>









<!-- inicio  ////////////// ESTA PARTE CONSTRUYE EL MAPA CON LA SELECCION\\\\\\\\\\\\\\\\\\\\\ -->
<section id="municipios_seleccion">
<div id='municipios'> 
<h4>Municipios: </h4>
<?php //LISTA DE MUNICIPIOS

$sql2="SELECT * FROM cat_municipios order by Municipio ASC";
$r2 = $conexion -> query($sql2);
$seleccionados="";

   if (isset($_GET['mm'])){ // si hay seleccionado un MULTIPLE municipio
         $municipios_select = explode(",", $_GET['mm']);
         $municipios_n = count($municipios_select);
         //echo "Cuantos: " . $municipios_n."<br>";      
         $municipios_n2 = $municipios_n -1;
   }
   while($df = $r2 -> fetch_array())
   {//$df recorre la lista de las delegaciones
      echo "<div>";
      
      if (isset($_GET['mm'])){ // si hay seleccionado un MULTIPLE municipio
      for ($i = 0; $i <= $municipios_n2; $i++) {         
         if ($municipios_select[$i]==$df['IdMunicipio']){   
               echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipio_resaltado'>".$df['nombre']."</a>"; 
               $seleccionados = $df['IdMunicipio'].",";
               //break;
         }
      }//for

      $seleccionados_ = explode(",", $seleccionados);$seleccionados_n = count($seleccionados_);       
      $seleccionados_n2 = $seleccionados_n -1;     
      for ($i = 0; $i <= $seleccionados_n2; $i++) {         
         {
            if ($seleccionados_[$i]==$df['IdMunicipio']){
               //echo "=";
               break;
            }
            else {
               echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipios'>".$df['nombre']."</a>"; 
               break;

            }
         }

         //echo $i;
         //echo $municipios_select[$i]."-".$df['IdMunicipio']."|";
         // $i = $i +1;             
         
      }//for
          

         


      //}
      echo "</div>";

   }



      if (isset($_GET['m'])){ // si hay seleccionado un municipio
         if ($_GET['m']==$df['IdMunicipio']){   
            echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipio_resaltado'>".$df['nombre']."</a></div>"; 
         }
         else {
            echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipios'>".$df['nombre']."</a></div>"; 
         }

      }


   }
?>
</div>


<div id='mapa_tamaulipas'>
<svg version="1.1" id="Layer_1" data-municipio="Layer_1"  x="0px" y="0px" viewBox="0 0 325.656 665.291" enable-background="new 0 0 325.656 665.291" xml:space="preserve">
<?php //MAPA INTERACTIVO
$sql2="SELECT * FROM cat_municipios order by Municipio ASC";
$r2 = $conexion -> query($sql2);
   while($df = $r2 -> fetch_array())
   {//$df recorre la lista de las delegaciones
      echo "<a href='?m=".$df['IdMunicipio']."'>";
      echo "<path ";
      $id= "m".$df['IdMunicipio']."";

      echo  "onmouseover=".chr(34)."javascript:document.getElementById('$id').className='municipio_resaltado'".chr(34)."; "; 
      echo  "onmouseout=".chr(34)."javascript:document.getElementById('$id').className='municipios'".chr(34).";";    

      echo "id='map".$df['IdMunicipio']."' ";


   
      if (isset($_GET['mm'])){ // si hay seleccionado un MULTIPLE municipio
      for ($i = 0; $i <= $municipios_n2; $i++) {         
         if ($municipios_select[$i]==$df['IdMunicipio']){   
            echo 'class="municipios_resalta"';

            // echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipio_resaltado'>".$df['nombre']."</a>"; 
               $seleccionados = $df['IdMunicipio'].",";
               //break;
         }
      }//for

      $seleccionados_ = explode(",", $seleccionados);$seleccionados_n = count($seleccionados_);       
      $seleccionados_n2 = $seleccionados_n -1;     
      for ($i = 0; $i <= $seleccionados_n2; $i++) {// si ya esta seleccionado poner sin seleccion     
         
            if ($seleccionados_[$i]==$df['IdMunicipio']){
               //echo "=";
               break;
            }
            else {
               echo 'class="municipios_mapa"';
               //echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipios'>".$df['nombre']."</a>";  
               break;

            }
         }//for
      }//getmm





      if (isset($_GET['m'])){ // si hay un municipio seleccionado

      if ("m".$_GET['m']=="m".$df['IdMunicipio']) {echo 'class="municipios_resalta"';} else {echo 'class="municipios_mapa"';}
      } else {echo 'class="municipios_mapa"';}{echo 'class="municipios_mapa"';}

      echo " d='".$df['data']."'>";
      echo $df['nombre'];
      echo "</path>";
      echo "</a>";
      

   }
?>
</div>


<br><br>


<script language="javascript">

function cambia(id_del_objeto,nueva_clase){
   var objeto = getElementById(id_del_objeto);
   objeto.className = nueva_clase;
   alert();
   
   //document.getElementById("divDatos").className = "nombreDeClase";
}

function notify(evt){
    var url = Aldama.target.getAttribute('data-url');
    window.open(url);
}
</script>
<!-- FIN  ////////////// ESTA PARTE CONSTRUYE EL MAPA CON LA SELECCION\\\\\\\\\\\\\\\\\\\\\ -->







<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>