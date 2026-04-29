<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php"); include ("./lib/body_menu.php");


?>
<?php
$id_aplicacion ="ap89"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$txtIdMunicipio = $_GET['m']; if (ValidaVAR($txtIdMunicipio)==TRUE){$txtIdMunicipio = LimpiarVAR($txtIdMunicipio);} else {$txtIdMunicipio = "";}
//$nivel= 3;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
   xd_update('ap89',$nitavu);//guarda la experiencia del usuario
   historia($nitavu, "Entro a la aplicacion [ap89], para consultar las colonias");


// en $txtIdMunicipio almacena municipio seleccionado y $_GET['mm'] si es mas de uno
echo "<script>
$('#grancontenido').css('background-image', 'url(img/colonias.jpg)');
$('#grancontenido').css('width', '100%');
$('#grancontenido').css('margin', '0px');

</script>";
if (isset($txtIdMunicipio)){
   if ($txtIdMunicipio=="") {//sino se especifica mostrar estadistica de todos
   echo "<div id='indicadores'>";
      echo "<div id='Busqueda'>";
      echo "<table border=0 width=100%><tr><td valing=middle >";
      echo "<input style='
      height:52px; font-size:18pt;
      'type='text' placeholder='Nombre de la Colonia' value='' id='txtBusqueda' ></td><td width=50px valign=middle >";
      echo "<button class='Mbtn btn-Primary' onclick='BuscaColonias();'><img src='icon/buscar.png' style='width:28px;'></button></td></tr></table>";
      echo "<input type='hidden' placeholder='Nombre de la Colonia' value='".$txtIdMunicipio."' id='txtIdMunicipio'>";
      echo "</div>";
      echo "<div id='Resultado' style='border: 0px;'>";
      echo "</div>";
   
   echo "</div>";



   }
   else { /// si selecciono un municipio
      
      echo "<div id='indicadores'>";
      echo "<div id='Busqueda'>";
      echo "<table border=0 width=100%><tr><td valing=middle >";
      echo "<input style='
      height:52px; font-size:18pt;
      'type='text' placeholder='Nombre de la Colonia (".municipio_nombre($txtIdMunicipio).")' value='' id='txtBusqueda' ></td><td width=50px valign=middle >";
      echo "<button class='Mbtn btn-Primary' onclick='BuscaColonias();'><img src='icon/buscar.png' style='width:28px;'></button></td></tr></table>";
      echo "<input type='hidden' placeholder='Nombre de la Colonia' value='".$txtIdMunicipio."' id='txtIdMunicipio'>";
      echo "</div>";
      echo "<div id='Resultado' style='border: 0px;'>";
      echo "</div>";

      echo "<script>BuscaColonias();</script>";
   
   echo "</div>";



   
   }

} else {   mensaje("Bienvenido a Colonias Detectadas",'colonias.php?m=');}





} else {mensaje("No tiene acceso a esta aplicacion",'');}




?>

<script>
function BuscaColonias(){

   txtBusqueda = $('#txtBusqueda').val();
   txtIdMunicipio = $('#txtIdMunicipio').val();

   $("#preloader").show();
   $.ajax({
         url: "colonias_dat1.php",
         type: "post",        
         data: {nitavu: <?php echo $nitavu; ?>, txtBusqueda: txtBusqueda, txtIdMunicipio:txtIdMunicipio},
         success: function(data){
            $('#Resultado').html(data+"\n");
            $("#preloader").hide();
         }
   });
   
    
    
}
</script>







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



      if (isset($txtIdMunicipio)){ // si hay seleccionado un municipio
         if ($txtIdMunicipio==$df['IdMunicipio']){   
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





      if (isset($txtIdMunicipio)){ // si hay un municipio seleccionado

      if ("m".$txtIdMunicipio=="m".$df['IdMunicipio']) {echo 'class="municipios_resalta"';} else {echo 'class="municipios_mapa"';}
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