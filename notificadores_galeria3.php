<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php"); include ("./lib/body_menu.php");


?>
<?php
$id_aplicacion ="ap39"; //Id de la aplicacion a cargar
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
   echo "<div id='indicadores'>";
   echo "<br><br><p> Selecciona un municipio para ver las Colonias </p>";
   echo "<br><br><p> Esta informacion ha sido obtenida de la base de datos actual; Debido a que estamos construyendo esta plataforma pudieran darse algunos errores de se asi favor de comlibrlo al Dpto. de Informatica </p>";
   echo "</div>";
} else { /// si selecciono un municipio, listar las delegaciones:
   $sqlx = "
   SELECT   cat_municipios.IdMunicipio, cat_municipios.nombre, cat_municipios.del, cat_delegaciones.id,cat_delegaciones.nombre 
   as 'delegacion'   FROM  cat_municipios, cat_delegaciones WHERE
   cat_municipios.IdMunicipio = '".$_GET['m']."' and cat_municipios.del = cat_delegaciones.id";

   echo "<div id='indicadores'>";   
   $r= $conexion -> query($sqlx);  while($f = $r -> fetch_array())
   {// despliega las delegaciones del municipio
      //echo "Municipio: (".$f['IdMunicipio'].") ".$f['nombre'].".Delegacion: (".$f['del'].") ".$f['delegacion']."<br>";
      echo "Municipio: <b>".$f['nombre']."</b>. Delegacion: <b>".$f['delegacion']."</b><br>";
      $sqlx2="
      SELECT DISTINCT
         notificadores_visitas.id_colonia AS x_id_colonia,
         notificadores_visitas.id_municipio AS x_id_municipio,
         (SELECT cat_colonias.Colonia FROM cat_colonias WHERE cat_colonias.IdColonia = x_id_colonia AND 
         cat_colonias.IdMunicipio = x_id_municipio) AS 'colonia'
      FROM notificadores_visitas WHERE notificadores_visitas.delegacion = '".$f['id']."'  ORDER BY x_id_colonia";
      
            echo "<form action='' method='GET'>";
            echo "<input type='hidden' name='m' value='".$_GET['m']."'>";
            echo "<div><label>Colonias disponibles:</label><select name='col' required='required'>";
            $r2= $conexion -> query($sqlx2);  while($col = $r2 -> fetch_array())            
            {  
               if (isset($_GET['col'])){
                  if ($col['x_id_colonia'] == $_GET['col']){
                  echo "<option value='".$col['x_id_colonia']."' selected='selected'>".$col['colonia']."</<option>";
                  } else {
                  echo "<option value='".$col['x_id_colonia']."'>".$col['colonia']."</<option>";
                  }
               } else {
                  echo "<option value='".$col['x_id_colonia']."'>".$col['colonia']."</<option>";
               }

            }
            echo "</select></div>";

          
            echo "<div><label>* </label><input class='Mbtn btn-default' type='submit' value='Seleccionar' name='submit_select'></div>";
            
            echo "</form>";
   }//lista fin mun




   if (isset($_GET['col'])){

     echo "<div id='indicadores_full'>";
      $sql="
      select * from notificadores_visitas where id_colonia='".$_GET['col']."' and id_municipio='".$_GET['m']."'
      ";
      $rx= $conexion -> query($sql);  while($re = $rx -> fetch_array())            
      { 
            echo "<div id='colonias'>";
            $archivo_foto = 'notificadores/'.$re['contrato'].'_'.$re['visita_fecha'].'_lote.jpg';       
            $ruta_deretorno='notificadores_galeria.php?m='.$_GET['m']."&col=".$_GET['col'];
           
            if (isset($_GET['full']) AND $_GET['full']==$re['id']){
               ltbox_foto($nitavu, $archivo_foto, $ruta_deretorno);
            } else {echo "<a href='".$ruta_deretorno."&full=".$re['id']."'><img src='$archivo_foto' class='foto_galeria'></a>";}
         
            // echo "<span class='tenue'>Col. <b class=''>".colonia_nombre($re['id_colonia'],$re['id_municipio'])."</b>".", M: <b>".$re['manzana']."</b>, L<b>:".$re['lote']."</b><br></span>";
            
            // echo "<p class='comentarios'>";
            // //echo "<b class='tchico tenue'>Comentarios de la visita</b> (brigada ".$re['brigada_id']."): <br>";
            // echo $re['visita_comentarios']."</p>";
            // //echo "<hr>";
            // echo "Estado del Lote: ".$re['id_estado_lote'];
            echo "</div>";
         

      }
   echo "</div>";
   

   }

















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