<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php"); include ("./unica/body_menu.php");


?>
<?php
$id_aplicacion ="ap45"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
//$nivel= 3;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<h5>".app_detalle($id_aplicacion)."</h5>";
   xd_update('ap45',$nitavu);//guarda la experiencia del usuario
   historia($nitavu, "Entro a la aplicacion [ap45], para consultar las colonias");


// en $_GET['m'] almacena municipio seleccionado y $_GET['mm'] si es mas de uno

if (isset($_GET['m'])){
   if ($_GET['m']=="") {//sino se especifica mostrar estadistica de todos

   echo "<div id='indicadores'>";
   echo "<br><br><p> Selecciona un municipio para ver las Colonias </p>";
   echo "<br><br><p> Esta informacion ha sido obtenida de la base de datos actual; Debido a que estamos construyendo esta plataforma pudieran darse algunos errores de se asi favor de comunicarlo al Dpto. de Informatica </p>";



   echo "<form action='cat_colonias.php?m=' action='GET'>";
   echo "<input name='m' type='hidden' value=''>";
   echo "<input  name='q' list='colonias' placeholder='Id de la Colonia'>";
   echo '';
     
      $sql ="
      SELECT
         colonia as colonia,
         IdMunicipio as IdMun,
         (select cat_municipios.nombre from cat_municipios WHERE cat_municipios.IdMunicipio = IdMun) as Municipio,
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


   echo "</div>";



   }
   else { /// si selecciono un municipio


   $sqlx = '
   SELECT
   cat_colonias.Colonia,
   cat_colonias.IdColonia,
   cat_colonias.IdMunicipio,
   cat_colonias.idcolp,
   cat_municipios.IdMunicipio,
   cat_municipios.Municipio,
   cat_municipios.del,
   cat_delegaciones.id AS "iddel",
   cat_delegaciones.nombre AS "delegacion",
   cat_colonias.Observaciones
   FROM
      cat_colonias,
      cat_municipios,
      cat_delegaciones
   WHERE
      cat_colonias.IdMunicipio = cat_municipios.IdMunicipio
      AND cat_municipios.del = cat_delegaciones.id
      AND cat_colonias.IdMunicipio = '.$_GET['m'].'

   ';
   echo "<div id='indicadores'>";
   echo "<table class='tabla' width='100%'>";
   echo "<th>COLONIA</th><th>MUNICIPIO</th><th>DELEGACION</th>";
   
   if ($nivel==2){
      echo "<th></th>";
   }

   $c=0; $r= $conexion -> query($sqlx);  while($f = $r -> fetch_array())
   {
      echo "<tr>";
      echo "<td>".$f['Colonia']."</td>";
      echo "<td>".$f['Municipio']."</td>";
      echo "<td> [".$f['iddel']."] ".$f['delegacion']."</td>";
      if ($nivel==2){
      echo "<td> idColonia=".$f['IdColonia'].", idcolp=".$f['idcolp']."<br><span class='tenue'>".$f['Observaciones']."</span></td>";
      
      }
      echo "<td>";
      // contratos.php?IdDelegacion=6&IdPrograma=221&Saldo=1&Moratorios=0&Fora=0&Col=
      echo "<a href='contratos.php?IdDelegacion=6&IdPrograma=&Saldo=1&Moratorios=0&Fora=0&Col=".$f['Colonia']."'> Contratos con Saldo</a>";
      echo "</td>";

      echo "</tr>";
      $c= $c +1;
   }

   echo "</table></div>";





   
   }

} else {   mensaje("Bienvenido al Catalago de Colonias de ITAVU",'cat_colonias.php?m=');}





} else {mensaje("No tiene acceso a esta aplicacion",'');}




?>









<!-- inicio  ////////////// ESTA PARTE CONSTRUYE EL MAPA CON LA SELECCION\\\\\\\\\\\\\\\\\\\\\ -->
<section id="municipios_seleccion">
<div id='municipios'> 
<h1>Municipios: </h1>
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


<?php include ("./unica/body_footer.php"); ?>