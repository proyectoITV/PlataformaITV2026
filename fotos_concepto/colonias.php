<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php"); include ("./unica/body_menu.php");


?>
<?php
$id_aplicacion ="ap89"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
//$nivel= 3;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<h5>".app_detalle($id_aplicacion)."</h5>";
   xd_update('ap89',$nitavu);//guarda la experiencia del usuario
   historia($nitavu, "Entro a la aplicacion [ap89], para consultar las colonias");


// en $_GET['m'] almacena municipio seleccionado y $_GET['mm'] si es mas de uno
echo "<script>
$('#grancontenido').css('background-image', 'url(img/colonias.jpg)');
$('#grancontenido').css('width', '100%');
$('#grancontenido').css('margin', '0px');

</script>";
if (isset($_GET['m'])){
   if ($_GET['m']=="") {//sino se especifica mostrar estadistica de todos
   
   echo "<div id='indicadores' style='border: 0px;'>";
   
   echo "<p>Para buscar colonias debes seleccionar primero un municipio y en funcion de la disponibilidad de conección con la delegación obtendras los resultados indicados</p>";
   echo "<p>Las colonias son el resultado de los datos capturados en el domicilio particular del beneficiario, así como en el domicilio donde se le otorgo el beneficio del Instituto</p>";
   
   

   
   echo "</div>";



   }
   else { /// si selecciono un municipio

    echo "<div id='indicadores'>";
        
        $IdDelegacionSeleccionada = DelegacionDelMunicipio($_GET['m']);
        echo "<table width=100% border=0><tr>";
        echo "<td valing=top><input type='text' name='QueColonia' id='QueColonia'  placeholder='Escribe la colonia a buscar' style='
        height: 50px;
        border-radius: 5px;        
        vertical-align: top;
        '></td> ";

        echo "<td>";
        echo "<img src='icon/buscar.png' style='width:42px; cursor:pointer;' onclick='BuscaColonias(".$IdDelegacionSeleccionada.",0);'>";
        echo "</td>";
        echo "<td style='    border-left-width: 1px;
        border-left-color: black;
        border-left-style: dashed;' width=50px valing=top><button class='btn btn-AzulTam' onclick='BuscaColonias(".$IdDelegacionSeleccionada.",1);' style='
        height: 48px;
    


        margin:0px;
        border-radius: 5px;        
        vertical-align: top;
        '> Todas </button></td></tr>";
        echo "</table><br>";
        
        echo "<div id='Colonias' style='width:92%; border: 0px;'>";
            echo "<div id='preloader_col' style='display:none; border: 0px solid white;'><img src='img/loader_bar.gif' style=''>"."</div>";
            echo "<div id='ColoniasDetectadas' style='border: 0px solid white;'>";
            echo "</div>";

            

        echo "</div>";

        
      
        


    echo "</div>";




   
   }

} else {   mensaje("Bienvenido a Colonias Detectadas",'colonias.php?m=');}





} else {mensaje("No tiene acceso a esta aplicacion",'');}




?>

<script>
function BuscaColonias(IdDelegacion, all){
    // $( "div" ).length;
    console.log('all '+all + '|' + $("#QueColonia").val().length );
    if (all == 0){
        if ( $("#QueColonia").val().length  > 4) {
            var QueBusco = $("#QueColonia").val();
            console.log('Buscando ' + QueBusco + ' en la Delegacion ' + IdDelegacion);


            $("#preloader_col").show();
            $.ajax({
                url: "colonias_dat1.php",
                type: "post",        
                data: {nitavu: <?php echo $nitavu; ?>, QueColonia: QueBusco, IdDelegacion:IdDelegacion, all:all, m: <?php echo $_GET['m']; ?> },
                success: function(data){
                    $('#ColoniasDetectadas').html(data+"\n");
                    $("#preloader_col").hide();
                }
            });
            
        } else {
            console.log( $("#QueColonia").val().length  );
            alert('Escribe un poco mas el nombre de la Colonia');
        }
    }
    else {
        
        $.toast({
            heading: 'Informativo',
            text: 'Este proceso puede tardar unos minutos...',
            showHideTransition: 'slide',
            icon: 'info'
        })

        $.toast({
            heading: 'Informativo',
            text: 'No se mostrara la cantidad de contratos por colonia, esto es solo cuando se listan todas',
            showHideTransition: 'slide',
            icon: 'info'
        })

        var QueBusco = $("#QueColonia").val();
            console.log('Buscando ' + QueBusco + ' en la Delegacion ' + IdDelegacion);


            $("#preloader_col").show();
            $.ajax({
                url: "colonias_dat1.php",
                type: "post",        
                data: {nitavu: <?php echo $nitavu; ?>, QueColonia: QueBusco, IdDelegacion:IdDelegacion, all:all },
                success: function(data){
                    $('#ColoniasDetectadas').html(data+"\n");
                    $("#preloader_col").hide();
                }
            });
    }
    
}
</script>







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