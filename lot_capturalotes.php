<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php"); include ("./lib/body_menu.php");


?>
<?php
$id_aplicacion ="ap104"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);


if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
   xd_update('ap104',$nitavu);//guarda la experiencia del usuario
   historia($nitavu, "Entro a la aplicacion [ap104], para consultar los lotes del instituto.");

echo "<script>
$('#grancontenido').css('background-image', 'url(img/colonias.jpg)');
$('#grancontenido').css('width', '100%');
$('#grancontenido').css('margin', '0px');

</script>";
if (isset($_GET['m'])){
   if ($_GET['m']=="") {//sino se especifica mostrar estadistica de todos
   
  echo "<div id='indicadores' style='border: 0px; width: 60%;'>";   
   echo "<p>Para buscar colonias debes seleccionar primero un municipio y  obtendras los resultados indicados</p>";
   echo "</div>";

   }
   else { /// si selecciono un municipio

    echo "<div id='indicadores' style='border: 0px; width: 60%;'>"; 
    echo '		
    <form id="myForm" >
       <center>
       <table>
          <tr>
             <th colspan="3"><p>Búsqueda por:</p></th>
          </tr>
          <tr>
             <td>
                <label for="todosloslotes"><input type="radio" id="todosloslotes" name="opciones" value="todosloslotes">
                Todos los de una colonia</label>
             </td>
             <td>
                <label for="loteespecifico"><input type="radio" id="loteespecifico" name="opciones" value="loteespecifico">
               Un Lote en especifico</label>
             </td>
          </tr>
       </table>
       </center>
    </form>';
    

   //  if (!empty($_GET['m']))
   //   { // <= false

   //    $IdDelegacionSeleccionada = DelegacionDelMunicipio($_GET['m']);
  
   //  }else
   //  {
   //       $IdDelegacionSeleccionada=0;
   //  }
        echo "<center>";
        echo "<div id='Todosloslotesdeunacolonia' style='border: 0px; display:none; width: 80%;'>";       
        echo "<table width=100% border=0 ><tr>";
        echo "<td valing=top  ><input type='text' name='QueColonia' id='QueColonia' value=''
         placeholder='Escribe la colonia a buscar' style='height: 50px; border-radius: 5px; vertical-align: top;'></td> ";

        echo "<td style='text-align:center'>";
        echo "<img id='buscacolonias' src='icon/buscar.png' style='width:42px; cursor:pointer;' onclick='BuscaColonias(".$_GET['m'].",0);'>";
        echo "</td>      
       </tr>";
        echo "</table><br>";
        echo "</div>";
        echo "</center>";
   //      echo "<div id='Colonias' style='width:92%; border: 0px;'>";
   //          echo "<div id='preloader_col' style='display:none; border: 0px solid white;'><img src='img/loader_bar.gif' style=''>"."</div>";
   //          echo "<div id='ColoniasDetectadas' style='border: 0px solid white;'>";
   //          echo "</div>";
   //      echo "</div>";
   //      echo "</div>"; 
   //  echo "</div>";


    echo "<div id='buscarPorLote' style='border: 0px; display:none; width: 100%;'>";
    echo "<center>";
    echo "<table >";
    echo "<tr>";
      echo "<td colspan='4'>";
      
      echo "<label for='Colonia' style='width: 100%;'>Colonia:";
         echo "<select id='Colonia' name='Colonia'  style='margin-left: 0px;'>";
         $sql2="SELECT * from catcolonia  where IdMunicipio=".$_GET['m']." order by Colonia  ASC";
         echo  $sql2;
         $r2 = $Vivienda -> query($sql2);
            while($f = $r2 -> fetch_array())
            {
               echo "<option value='".$f['IdColonia']."'>".$f['Colonia']."</option>";
            }
         echo "</select>";
      echo "</label></td>"; 
      echo "</tr>";    
      echo "<tr>";    
         echo "<td>";      
               echo "<div id='DivSeccion' style=' width:100%;'>";
                  echo "<label for='txtSeccion'>Seccion:";
                        echo "<input type='text' name='txtSeccion' id='txtSeccion'>" ;        
               echo "</div>";
         echo "</td>";

         echo "<td>";      
               echo "<div id='DivFila' style=' width:100%;'>";
                  echo "<label for='txtFila'>Fila:";
                        echo "<input type='text' name='txtFila' id='txtFila' >" ;        
               echo "</div>";
         echo "</td>";
            
         echo "<td>";      
               echo "<div id='DivManzana' style=' width:100%;'>";
                  echo "<label for='txtManzana'>Manzana:";
                        echo "<input type='text' name='txtManzana' id='txtManzana'>" ;        
               echo "</div>";
         echo "</td>";
            
         echo "<td>";
               echo "<div id='DivLote' style=' width:100%;'>";            
                        echo "<label for='txtLote'>Lote:";
                        echo "<input type='text' name='txtLote' id='txtLote'  >" ;
               echo "</div>";
         echo "</td>";
      echo "</tr>";

      echo "<tr>";
         echo "<td colspan='4'>";   
            echo "<div id='BtnBuscar' style=' width:100%;'>";          
            echo "<button id='btnbuscar' class='Mbtn btn-AzulTam' onclick='BuscaLote(".$_GET['m'].",1);' style='
            height: 48px;   
            margin:0px;
            border-radius: 5px;        
            vertical-align: top;
            '> Buscar </button>";
            echo "</div>"; 
         echo "</td>";     
   echo "</tr>";  
 echo "</table>"; 
 echo "</center>";
 echo "</div>"; 
 echo "<br>";
 
 echo "<div id='Colonias' style='width:92%; border: 0px;'>";
            echo "<div id='preloader_col' style='display:none; border: 0px solid white;'><img src='img/loader_bar.gif' style=''>"."</div>";
            echo "<div id='ColoniasDetectadas' style='border: 0px solid white;'>";
            echo "</div>";
        echo "</div>";
        
    echo "</div>";

   }

} else {   mensaje("Bienvenido a Lotes del ITAVU",'lot_capturalotes.php?m=');}

} else {mensaje("No tiene acceso a esta aplicacion",'');}

?>


<?php
 //********************************** Modal CAPTURA NUEVO LOTE
echo "<div id='nuevoLote' name='nuevoLote' class='MyModal'>";
echo "<center>";
echo "<h1>DAR DE ALTA NUEVO LOTE</h1>"; 

echo "<div id='msgdatosrequeridosNuevo' class='sombra' style=' display:none; width: 95%; color:red; background:#F8E0E0; font-size: small;'><span><br>** Faltan algunos datos requeridos **<br></span><br></div><br>";
echo "<br>";
echo "<br>";
/* ****************************LOCALIZACION DEL LOTE ***************************** */
echo "<div  style='width: 70%;'>";//
echo "<form action='lot_lotes_db2.php?agregar' method='POST' id='formAgregarLote' name='formAgregarLote' >";
echo "<h1 style='background:white; border-bottom-color:white; color:#C3C3C3; text-align: center;' >LOCALICACIÓN DEL LOTE</h1>";
echo "<table style='width: 90%;'>";
$m=0;
 if (isset($_GET['m']))
{
  if(strlen ($_GET['m'] )>0)
  {
   $m= $_GET['m'];
  }
}
echo "<tr style='visibility:hidden;'>";      
echo "<td valign='middle'><b class='normal menu_font_n'>IdLote:</b></td>";
echo "<td valign='middle' align='center'>";
echo "<input type='text' name='m' id='m' value=".$m.">" ; 
echo "</td>";
echo "<td valign='middle' align='center' ></td>";
echo "<td valign='middle' align='center' ></td>"; 
echo "</tr>";

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Municipio</b></td>";
echo "<td valign='middle' align='center' colspan='3'>";

 if (isset($_GET['m']))
{
  if(strlen ($_GET['m'] )>0)
  { 
     echo "<select id='IdMunicipio' name='IdMunicipio' style='margin-left: 0px; '  onchange='LlenarColonias(0)'>";
               // echo "<option>Seleccione un apoderado...</option>";
                $sql = "SELECT * FROM municipios ";
                $tmp="";
                $r2 = $Vivienda -> query($sql);
                    while($f = $r2 -> fetch_array()){ // resultado de la busqueda.................
                     if ($_GET['m'] ==$f['IdMunicipio']){
                        echo '<option value="'.$f['IdMunicipio'].'" selected="selected">'.$f['Municipio'].'</option>';
                        }
                        else
                        {
                           echo '<option value="'.$f['IdMunicipio'].'">'.$f['Municipio'].'</option>';
                        }	
                        
                    }
                
      echo "</select>";

       }
       else{   
         echo "<select id='IdMunicipio' name='IdMunicipio' style='margin-left: 0px;'  onchange='LlenarColonias(0)'>";
                $sql = "SELECT * FROM municipios ";
                $tmp="";
                $r3 = $Vivienda -> query($sql);
                    while($f = $r3 -> fetch_array()){ // resultado de la busqueda.................
                         echo '<option value="'.$f['IdMunicipio'].'">'.$f['Municipio'].'</option>';   
                    }
                
      echo "</select>";
    
         }
 }

echo "</td>";
echo "</tr>";  

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Colonia</b>";
echo "<td valign='middle' align='center'  colspan='3'>";
echo "<div id='colonia' name='colonia' style='width:100%;'>";
echo "<select id='IdColonia2' name='IdColonia2'  style='margin-left: 10px;'  onchange='validarCampos()'>";
echo "</select>";
echo "<div";
echo "</td>";
echo "</tr>"; 
    
echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Seccion</b>";
echo "<td valign='middle' align='center' >";
echo "<input type='text' name='Seccion' id='Seccion'  >" ; 
echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n' >Fila</b>";
echo "<td valign='middle' align='center' >";
echo "<input type='text' name='Fila' id='Fila'>" ; 
echo "</td>";
echo "</tr>";  

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Manzana</b>";
echo "<td valign='middle' align='center' >";
echo "<input type='text' name='Manzana' id='Manzana' value='' onkeyup='validarCampos()'>" ; 
echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>Lote</b>";
echo "<td valign='middle' align='center' >";
echo "<input type='text' name='Lote' id='Lote' value='' onkeyup='validarCampos()'>" ; 
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td valign='middle' style='text-align: center;'  colspan='4'>";

echo "</td>";

echo "</tr>";

echo "</table> "; 
echo "<br>";
echo "</form>";
echo "<button id='btnAgregar'  class='btn btn-primary'  onclick='sendForm();'>"; 
echo "<table  width='100%'><tr><td valign='middle' align='center'>";
   echo "<img src='icon/ok2.png'> ";
   echo "</td>";
   echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
   echo "Guardar";
   echo "</td></tr></table></button>"; 
echo "</div>"; //cierrra div de localizacion del lote
echo "<br>";
echo "<br>";

   echo "<BR>"; 
 echo "</center>";
 echo "</div>";

 //**********************************
  
 //CANCELAR EL REGISTRO DE UNA COLONIA
 if (isset($_GET['mensaje'])){

   //$idl=explode("_", $_GET['mensaje']);
   $idl=$_GET['idlote'];
   $anterior= $_SERVER['HTTP_REFERER'];
   mensajeAdvertencia('¿Esta seguro de querer dar de baja el lote, al cancelarlo ya no será visible y no podrá consultarlo.?',$anterior.'&cancelar='.$idl,$anterior,'');

}


 
 //**********************************

 
 //DAR DE BAJA EL REGISTRO DE UNA LOTE
 if (isset($_GET['cancelar'])){

//   $variables=explode("_", $_GET['id']);
$anterior= $_SERVER['HTTP_REFERER'];
   $sql = "Update lotes set Cancelado=1 WHERE idLote='".$_GET['cancelar']."'";
     // echo $sql; //comprobamos la sintaxis query
      if ($Vivienda->query($sql) == TRUE){
         historia($nitavu, "Dio de baja la lote con id: ".$_GET['cancelar']);
  
        
         
      } else{ 
         historia($nitavu, "ERROR al querer dar de baja el lote con id: ".$_GET['id'].", SQL: ".$sql);
         
      }
      mensaje("Se dio de bajo el lote con exito","lot_capturalotes.php?m=".$_GET['m']);
}


 ?>
<script>

$(document).ready(function(){
   
//Aqui se identifica si existe una varibale en la url

    var quecolonia=parametroURL('colonia');
    var m=parametroURL('m');
    var all=0;

      if(quecolonia!=null && m!=null)
      {   console.log('entro'+m);  
         document.getElementById("todosloslotes").checked =true;   
         console.log(quecolonia+'__okokoko'); 
         document.getElementById('QueColonia').value=quecolonia;
         if(document.getElementById("todosloslotes").checked == true)
         {
            $("#Todosloslotesdeunacolonia").css({'display':'inline-block'});
	    	   $("#buscarPorLote").css({'display':'none',});

         }
         BuscaColonias(m, all);
       
      }else if(quecolonia!=null && m==null)
      {  console.log('entro2'+m);  
         
      }
               
      

//**********************************


var id = document.getElementById("IdMunicipio").value;

        $.ajax({
            url: "lot_cboxcolonias.php",
            type: "get",
            data: {id: id,idcol:0},
            success: function(data){
               // $("#preloader").css({'display':'none',});
                $('#colonia').html(data+"\n");
            }
        });

        
        
      if(document.getElementById("loteespecifico").checked == true)
      {
         $("#buscarPorLote").css({'display':'inline-block'});
         $("#Todosloslotesdeunacolonia").css({'display':'none'});  

         if ($("#Colonia").val() > 0 && $("#txtManzana").val().length  > 0 &&   $("#txtLote").val().length  > 0) {
         BuscaLote(m, 1);
          }else{console.log('entro donde no queri');}
      
      }
      else if(document.getElementById("todosloslotes").checked == true)
      {
        
         $("#Todosloslotesdeunacolonia").css({'display':'inline-block'});
		   $("#buscarPorLote").css({'display':'none',});

         if ( $("#QueColonia").val().length  > 5) {
         BuscaColonias(m, all);
          }
   
      }

        
});

//El combo recibe opcion que nos permite distinguir si el combo se utlizará al crear un nuevo lote
//o al editar un lote
function LlenarColonias(idcol)
{
  
var id = document.getElementById("IdMunicipio").value;
        $.ajax({
            url: "lot_cboxcolonias.php",
            type: "get",
            data: {id: id, idcol:idcol},
            success: function(data){              
                $('#colonia').html(data+"\n");
            }
        });

        validarCampos();      
}

//**********************************
function BuscaColonias(m, all){
     console.log('all '+all + '|' + $("#QueColonia").val().length );
   document.getElementById("ColoniasDetectadas").innerHTML = "";
   var loteespecifico=0;

    if (all == 0){

      $.toast({
            heading: 'Informativo',
            text: 'Este proceso puede tardar unos minutos...',
            showHideTransition: 'slide',
            icon: 'info'
        })
        

        if ( $("#QueColonia").val().length  > 5) {
         
            var QueBusco = $("#QueColonia").val();
            document.cookie = "quecolonia="+encodeURIComponent(QueBusco);
            var m = $("#m").val();
            console.log('Buscando lotes cuyo nombre de colonia colonia coincida con:  \"' + QueBusco + '"\ en el municipio con id: ' + m);
            $("#preloader_col").show();
            $.ajax({            
                url: "lot_lotes_db.php",
                type: "post",        
                data: {nitavu: <?php echo $nitavu; ?>, QueColonia: QueBusco,  all:all, m:m },
                success: function(data)                
                  {
                    $('#ColoniasDetectadas').html(data+"\n");
                    $("#preloader_col").hide();
                }
            });
            
        } else {
           
            alert('Escribe un poco mas el nombre de la Colonia');
        }
        
    }
   
}

//**********************************

function BuscaLote(m, all){

      var idColonia =   document.getElementById("Colonia").value;
      var seccion = document.getElementById('txtSeccion').value; ;
      var fila =  document.getElementById('txtFila').value; 
      var manzana=  document.getElementById('txtManzana').value;    
      var lote= document.getElementById('txtLote').value;
      var loteespecifico=1;   
        
      var m = $("#m").val();
        console.log('Buscando  lotes con IdMunicipio ' +m+' IdColonia ' + idColonia + ' Seccion '+seccion+' Fila '+fila+' Manzana '+ manzana+' Lote '+lote );

        $("#preloader_col").show();
            $.ajax({
                url: "lot_lotes_db.php",
                type: "post",        
                data: {nitavu: <?php echo $nitavu; ?>,   all:all, m: m,IdColonia: idColonia, Seccion: seccion,Fila: fila,Manzana: manzana,Lote: lote, },
                success: function(data)                
                  {
                     
                    $('#ColoniasDetectadas').html(data+"\n");
                    $("#preloader_col").hide();
                }
            });
 }



//Valida el radioButton Seleccionado
$('#myForm input').on('change', function() {
 
//  //-- Limpiar Datos
  document.getElementById("ColoniasDetectadas").innerHTML = "";
  document.getElementById("QueColonia").value = "";
  document.getElementById('Colonia').value="";
  
  document.getElementById("txtSeccion").value = "";
  document.getElementById("txtFila").value = "";
  document.getElementById("txtManzana").value = "";
  document.getElementById("txtLote").value = "";
	if(($('input:radio[name=opciones]:checked').val()=='todosloslotes')){
		$("#Todosloslotesdeunacolonia").css({'display':'inline-block'});
		 $("#buscarPorLote").css({'display':'none',});
       
	}
   else{       
       $("#buscarPorLote").css({'display':'inline-block'});
       $("#Todosloslotesdeunacolonia").css({'display':'none'});
	
	}
});


//**********************************

function validarCampos()
{
   
   idmunicipio = document.getElementById("IdMunicipio").value;
   idcolonia = document.getElementById("IdColonia").value;
   manzana = document.getElementById("Manzana").value;
   lote = document.getElementById("Lote").value;

var validacion=true;


if( idmunicipio == "0" )  {
      $("#IdMunicipio").css("border-color", "red");
   validacion= false;
 }
 else{
   $("#IdMunicipio").css("border-color", "#CCCCCC");
 }
   
   if( idcolonia == "0" )  {
      console.log("entor");
      $("#IdColonia").css("border-color", "red");
   validacion= false;
   }
   else{
      console.log("ento45");
   $("#IdColonia").css("border-color", "#CCCCCC");
 }

  if( manzana == null || manzana.length == 0 ) {
     $("#Manzana").css("border-color", "red");
     validacion= false;
  }
  else{
   $("#Manzana").css("border-color", "#CCCCCC");
 }
  if( lote == null || lote.length == 0 ) {
     $("#Lote").css("border-color", "red");
     validacion= false;
  }
  else{
   $("#Lote").css("border-color", "#CCCCCC");
 }
  
  if(validacion==true)
  { $("#msgdatosrequeridosNuevo").css({'display':'none'});

  }
   
     
   return validacion;
     
}

//**********************************



function sendForm() {
 
   valido = validarCampos(); //DEBERIAS REALIZAR LAS VALIDACIONES 
   console.log(valido)

   if (valido) {
   $("#msgdatosrequeridosNuevo").css({'display':'none'});
   
    document.getElementById("formAgregarLote").submit();
  } else {
   $("#msgdatosrequeridosNuevo").css({'display':'inline-block'});
    return false;
  } 
 
}
//**********************************

function parametroURL(_par) {
  var _p = null;
  if (location.search) location.search.substr(1).split("&").forEach(function(pllv) {
    var s = pllv.split("="), //separamos llave/valor
      ll = s[0],
      v = s[1] && decodeURIComponent(s[1]); //valor hacemos encode para prevenir url encode
    if (ll == _par) { //solo nos interesa si es el nombre del parametro a buscar
      if(_p==null){
      _p=v; //si es nula, quiere decir que no tiene valor, solo textual
      }else if(Array.isArray(_p)){
      _p.push(v); //si ya es arreglo, agregamos este valor
      }else{
      _p=[_p,v]; //si no es arreglo, lo convertimos y agregamos este valor
      }
    }
  });
  return _p;
}


</script>
<section id="municipios_seleccion">



<?php if($nivel==1)
{?>
<center>
<div id='municipios'> 

<a id='NuevoLote' href='#nuevoLote' rel='MyModal:open' class='btn btn-primary' title='Capturar nueva lote'> 
     <table  width='100%'><tr><td valign='middle' align='center'>
      <img src='icon/ok2.png'> 
       </td>
       <td valign='middle' align='center' style='color:white;' class='pc'>
       Nuevo Lote
      </td></tr></table>   
    </a>
    
    </div>
</center>
<?php 
}?>

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
         
      }
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