<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php"); include ("./lib/body_menu.php");


?>
<?php
$id_aplicacion ="ap103"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
   xd_update('ap103',$nitavu);//guarda la experiencia del usuario
   historia($nitavu, "Entro a la aplicacion [ap103], para consultar las colonias");


  echo "<br><br>";


// en $_GET['m'] almacena municipio seleccionado y $_GET['mm'] si es mas de uno
if (isset($_GET['m'])){
   if ($_GET['m']=="") {//sino se especifica mostrar estadistica de todos

   echo "<div id='indicadores'>";
   echo "<br><br><p> Selecciona un municipio para ver las Colonias </p>";
   echo "<br><br><p> Esta informacion ha sido obtenida de la base de datos actual; Debido a que estamos construyendo esta plataforma pudieran darse algunos errores de se asi favor de comlibrlo al Dpto. de Informatica </p>";

   /* echo "<form action='cat_colonias.php?m=' action='GET'>";
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
   echo "</form>"; */
   echo "</div>";
   }
   else 
   { /// si selecciono un municipio

if($nivel==1)
{
$sqlx = "SELECT  
-- CONCAT('[',DELEGACIONES.IdDelegacion,']', ' ', DELEGACIONES.Delegacion) As Delegacion,
CONCAT('[',catcolonia.IdMunicipio,']', ' ', municipios.Municipio) As Municipio,
CONCAT('[',catcolonia.IdColonia, ']',' ', catcolonia.Colonia) As Colonia,
catcolonia.NOMBRE_OFICIAL,
CONCAT('<a id=\"editarcolonia\"  href=\"lot_coloniasEdit.php?idm=',catcolonia.IdMunicipio,'&idc=',catcolonia.IdColonia,'\"   title=\"Editar colonia\"><center>
<img src=\"./icon/edit.png\" height=\"20\" width=\"20\" title=\"Editar colonia\"><center></a>') AS '',
CONCAT(' <a id=\"DarBajacolonia\" href=\"?mensaje=',catcolonia.IdMunicipio,'_',catcolonia.IdColonia,'\"  title=\"Dar de baja la colonia\"><center><img src=\"icon/eliminar.png\" style=\"width:20px;\"></center> </a>') AS ''
FROM catcolonia  
JOIN municipios ON catcolonia.IdMunicipio=municipios.IdMunicipio
WHERE catcolonia.IdMunicipio>0 AND catcolonia.colonia is not null AND catcolonia.IdMunicipio = municipios.IdMunicipio 
AND  catcolonia.IdMunicipio = ".$_GET['m']."
AND catcolonia.Cancelado=0
ORDER BY catcolonia.colonia, catcolonia.IdColonia, catcolonia.IdMunicipio";

}else{

   $sqlx = "SELECT  
-- CONCAT('[',DELEGACIONES.IdDelegacion,']', ' ', DELEGACIONES.Delegacion) As Delegacion,
CONCAT('[',catcolonia.IdMunicipio,']', ' ', municipios.Municipio) As Municipio,
CONCAT('[',catcolonia.IdColonia, ']',' ', catcolonia.Colonia) As Colonia,
catcolonia.NOMBRE_OFICIAL,
CONCAT('<a id=\"editarcolonia\" href=\"lot_coloniasEdit.php?c&idm=',catcolonia.IdMunicipio,'&idc=',catcolonia.IdColonia,'\"  title=\"Consultar colonia\"><center>
<img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar colonia\"><center></a>') AS ''
FROM catcolonia  
JOIN municipios ON catcolonia.IdMunicipio=municipios.IdMunicipio
WHERE catcolonia.IdMunicipio>0 AND catcolonia.colonia is not null AND catcolonia.IdMunicipio = municipios.IdMunicipio 
AND  catcolonia.IdMunicipio = ".$_GET['m']."

AND catcolonia.Cancelado=0
ORDER BY catcolonia.colonia, catcolonia.IdColonia, catcolonia.IdMunicipio";
   
}
   echo "<div id='indicadores' style='width:60%;'>";

echo "<div id='ListaColonias' style='background-color:#EEEEEE; width:95%; display:inline-block;
border-radius:5px; padding:10px; margin-top:20px;'>";
echo "<h2>Colonias Encontradas</h2>";
TablaDinamica_MySQLVivienda("",$sqlx, "ColoniasDiv", "TablaColonias", "", 2); 
echo "</div>";
/*
   echo "<table class='tabla' width='100%'>";
   echo "<th>DELEGACION</th><th>MUNICIPIO</th><th>COLONIA</th>";
   
   if ($nivel==1){
      echo "<th></th><th></th>";
      
   }

   $c=0;
   
   $r= $Vivienda -> query($sqlx);

   if ($r) 
   { 

      while($f = $r -> fetch_array())
      {
         echo "<tr>";
         echo "<td> [".$f['iddel']."] ".$f['delegacion']."</td>";
         echo "<td style='display: none;'>".$f['IdMunicipio']."</td>";
         echo "<td>".$f['Municipio']."</td>";     
         echo "<td> [".$f['IdColonia']."] ".$f['Colonia']."</td>";  
         if ($nivel==1){
          
         echo "<td>";  
         echo "<a id='editarcolonia' href='#editarColonia".$f['IdMunicipio']."_".$f['IdColonia']."'  rel='MyModal:open'  title='Editar colonia'> ";
         echo "<center><img src='icon/editar.png' style='width:20px;'></center>";

         //********************************** Modal EDITA COLONIA



        echo "<div id='editarColonia".$f['IdMunicipio']."_".$f['IdColonia']."' class='MyModal'>";
        echo "<center>";
        echo "<h1>Editar Colonia</h1>"; 
        echo "<div id='msgdatosrequeridos".$f['IdMunicipio']."_".$f['IdColonia']."' class='sombra' style=' display:none; width: 95%; color:red; background:#F8E0E0; font-size: small;'><span><br>** Faltan algunos datos requeridos **<br></span><br></div><br>";
        echo  "<br>";
        echo "<form id='formEditar".$f["IdMunicipio"].'_'.$f["IdColonia"]."' name='formEditar".$f["IdMunicipio"].'_'.$f["IdColonia"]."' action='lot_colonia_db.php?editar' method='POST'>";
        
        $sql2 = "SELECT * from catcolonia where idmunicipio= ".$f['IdMunicipio']." and idcolonia=" .$f['IdColonia'];
       // echo $sql2;
       $r2 = $Vivienda -> query($sql2);
        while($f1 = $r2 -> fetch_array())
           {
              
              echo "<div>"; 
             
                 echo '<label>Municipio</label>';
                 echo "<span class='tenue' >".NombreMuncipio($f['IdMunicipio'])."</span>";
                 echo "<input type='hidden' id='IdMunicipioEdit' name='IdMunicipioEdit' value='".$f['IdMunicipio']."'>";
               //   echo "<select name='IdMunicipio'   'id='IdMunicipio' style='margin-left: 0px;' >";
               //      $sql = "SELECT * FROM cat_municipios ";
               //      $tmp="";
               //      $r2 = $conexion -> query($sql);
               //      while($fx = $r2 -> fetch_array())
               //         {
               //          if ($f1['IdMunicipio']==$fx['IdMunicipio'])
               //          {
                       
               //             echo '<option value="'.$f['IdMunicipio'].'" selected="selected">'.$fx['municipio'].'</option>';							
               //          }
               //          else
               //          {
               //             echo '<option value="'.$fx['IdMunicipio'].'">'.$fx['municipio'].'</option>';		
               //          }		
                     	
               //         }
        
               //   echo "</select>";
              echo "</div>";
           
        
        
        echo "<div>";
        echo '<label>Colonia</label>';
        echo "<input type='hidden' id='IdColoniaEdit' name='IdColoniaEdit' value='".$f['IdColonia']."'>";
        echo "<input type='text' id='ColoniaEdit".$f['IdMunicipio']."_".$f['IdColonia']."' name='ColoniaEdit".$f['IdMunicipio']."_".$f['IdColonia']."' value='".$f1['Colonia']."' required>";
        echo "</div>";
        
        echo "<div>";
        echo '<label>Nombre Oficial</label>';
        echo "<input type='text' id='NombreOficialEdit".$f['IdMunicipio']."_".$f['IdColonia']."' name='NombreOficialEdit".$f['IdMunicipio']."_".$f['IdColonia']."' value='".$f1['NOMBRE_OFICIAL']."''>";
        echo "</div>";       
       
        echo "<div>";
        echo '<label>Adquisición</label>';
            echo "<select name='IdTipoAdquisicionEdit".$f['IdMunicipio']."_".$f['IdColonia']."' id='IdTipoAdquisicionEdit".$f['IdMunicipio']."_".$f['IdColonia']."' style='margin-left: 0px;' required>";
            $sql = "SELECT * FROM tipoadquisicioncol ";
            $tmp="";
            $r2 = $Vivienda -> query($sql);
            while($fx = $r2 -> fetch_array())
                {
                  if ($f1['Idtipoadquisicioncol']==$fx['Idtipoadquisicioncol'])
                  {
                 
                     echo '<option value="'.$fx['Idtipoadquisicioncol'].'" selected="selected">'.$fx['tipoadquisicioncol'].'</option>';				
                  }else
                  {
                     echo '<option value="'.$fx['Idtipoadquisicioncol'].'">'.$fx['tipoadquisicioncol'].'</option>';		
                  }

                }
        
            echo "</select>";
        echo "</div>";

 
        echo "<div>";
       
        echo '<label>Solo Escrituracion</label>';
        if ($f1['Solo_Escrituracion']==0)
        {
        echo "<input type='checkbox' id='Solo_EscrituracionEdit".$f['IdMunicipio']."_".$f['IdColonia']."' name='Solo_EscrituracionEdit".$f['IdMunicipio']."_".$f['IdColonia']."' value=0>";
        }
        else
        {echo "<input type='checkbox' id='Solo_EscrituracionEdit".$f['IdMunicipio']."_".$f['IdColonia']."' name='Solo_EscrituracionEdit".$f['IdMunicipio']."_".$f['IdColonia']."' value=1  checked='checked'>";}
         echo "</div>";
      
        
      //   echo "<div>";
      //   echo '<label>Ahorro previo/pago inicial</label>';
      //   echo "<input type='text' id='MontoAhorroEdit".$f['IdMunicipio']."_".$f['IdColonia']."' name='MontoAhorroEdit".$f['IdMunicipio']."_".$f['IdColonia']."' value='".$f1['MontoAhorro']."'>";
      //   echo "</div>";

      //   echo "<div>";
      //   echo '<label>Convenio ahorro previo</label>';
      //   echo "<input type='text' id='PlantillaDeAhorroEdit".$f['IdMunicipio']."_".$f['IdColonia']."' name='PlantillaDeAhorroEdit".$f['IdMunicipio']."_".$f['IdColonia']."' value='".$f1['PlantillaDeAhorro']."'>";
      //   echo "</div>";

      //   echo "<div>";
      //   echo '<label>Plantilla Contrato</label>';
      //   echo "<input type='text' id='ContratoMaestroEdit".$f['IdMunicipio']."_".$f['IdColonia']."' name='ContratoMaestroEdit".$f['IdMunicipio']."_".$f['IdColonia']."' value='".$f1['ContratoMaestro']."'>";
      //   echo "</div>";
  

        echo "<div>";
        echo "<label for='Observaciones'>Observaciones</b>:";
        echo "<textarea name='ObservacionesEdit".$f['IdMunicipio']."_".$f['IdColonia']."' id='ObservacionesEdit".$f['IdMunicipio']."_".$f['IdColonia']."' style='border-width:1px; height:20%' >".$f1['Observaciones']."</textarea>";
        echo "</div>";
        
        echo "<BR>";
       
        }
        echo "</form>";
        echo "<button id='btneditar' name='btneditar'  class='Mbtn btn-default'  onclick='sendForm2(\"editar\",". $f['IdMunicipio'].",".$f['IdColonia'].");' >"; 
        echo "<table  width='100%'><tr><td valign='middle' align='center'>";
           echo "<img src='icon/ok2.png'> ";
           echo "</td>";
           echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
           echo "Guardar";
           echo "</td></tr></table></button>"; 
        echo "</center>";
        echo "</div>";
        
        //**********************************
         echo " </a>";

        
        


         echo "</td>";        
         echo "<td>";      
         // x  
         echo "<a id='DarBajacolonia' href='?mensaje=".$f['IdMunicipio']."_".$f['IdColonia']."'  title='Dar de baja la colonia'> ";
 
         echo "<center><img src='icon/eliminar.png' style='width:20px;'></center>";
         echo "</a></td>";
      }
         echo "</tr>";
         $c= $c +1;
      }
   }
   echo "</table>";*/
   echo "</div>";
   }

} 
else
{ 
   mensaje("Bienvenido al Catalago de Colonias de ITAVU",'lot_capturacolonias.php?m=');
}

} 
else
{
    mensaje("No tiene acceso a esta aplicacion",'');
}

?>
<?php
 //********************************** Modal CAPTURA NUEVA COLONIA
echo "<div id='nuevaColonia' class='MyModal'>";
echo "<center>";
echo "<h1>Captura Nueva Colonia</h1>"; 

echo "<div id='msgdatosrequeridos' class='sombra' style=' display:none; width: 95%; color:red; background:#F8E0E0; font-size: small;'><span><br>** Faltan algunos datos requeridos **<br></span><br></div><br>";
echo  "<br>";
echo "<form action='lot_colonia_db.php?agregar' method='POST' id='formAgregar' name='formAgregar'>";
 if (isset($_GET['m']))
 {
   if(strlen ($_GET['m'] )>0)
   {     
   echo "<div>";
      echo '<label>Municipios</label>';
      echo "<select name='IdMunicipioNva' id='IdMunicipioNva' style='margin-left: 0px;' required>";
      $sql = "SELECT * FROM cat_municipios ";
      $tmp="";
      $r2 = $conexion -> query($sql);
      while($fx = $r2 -> fetch_array())
         {        
            if ($_GET['m'] ==$fx['IdMunicipio']){
               echo '<option value="'.$fx['IdMunicipio'].'" selected="selected">'.$fx['municipio'].'</option>';
               }
               else
               {
                  echo '<option value="'.$fx['IdMunicipio'].'">'.$fx['municipio'].'</option>';
               }	
         }

      echo "</select>";  
   echo "</div>";
        }
        else{
     echo "<div>";
         echo '<label>Municipio</label>';
         echo "<select name='IdMunicipioNva' id='IdMunicipioNva'  style='margin-left: 0px;'>";
            $sql = "SELECT * FROM cat_municipios ";
            $tmp="";
            $r2 = $conexion -> query($sql);
            while($fx = $r2 -> fetch_array())
               {
               echo '<option value="'.$fx['IdMunicipio'].'">'.$fx['municipio'].'</option>';	
               }

         echo "</select>";
      echo "</div>";
   }
}

echo "<div>";
echo '<label>Colonia</label>';
echo "<input type='text' id='ColoniaNva' name='ColoniaNva' value='' required>";
echo "</div>";

echo "<div>";
echo '<label>Adquisición</label>';
    echo "<select name='IdTipoAdquisicionNva' id='IdTipoAdquisicionNva' style='margin-left: 0px;'  required>";
    $sql = "SELECT * FROM tipoadquisicioncol  ";
    $tmp="";
    $r2 = $Vivienda -> query($sql);
    while($fx = $r2 -> fetch_array())
        {
        echo '<option value="'.$fx['IdTipoAdquisicionCol'].'">'.$fx['TipoAdquisicionCol'].'</option>';	
        }

    echo "</select>";
echo "</div>";


echo "<div>";
echo '<label>Solo Escrituracion</label>';
echo "<input id='Solo_EscrituracionNva' name='Solo_EscrituracionNva' type='checkbox'  value='0'>";
echo "</div>";


// echo "<div>";
// echo '<label>Ahorro previo/pago inicial</label>';
// echo "<input type='text' id='MontoAhorroNva' name='MontoAhorroNva'>";
// echo "</div>";

// echo "<div>";
// echo '<label>Convenio ahorro previo</label>';
// echo "<input type='text' id='PlantillaDeAhorroNva' name='PlantillaDeAhorroNva'>";
// echo "</div>";

// echo "<div>";
// echo '<label>Plantilla Contrato</label>';
// echo "<input type='text' id='ContratoMaestroNva' name='ContratoMaestroNva' >";
// echo "</div>";


echo "<div>";
echo "<label for='Observaciones'>Observaciones</b>:";
echo "<textarea id='ObservacionesNva' name='ObservacionesNva'style='border-width:1px; height:20%' ></textarea>";
echo "</div>";

echo "<BR>";


 echo "</form>";
 echo "<button id='btnAgregar'  class='btn btn-primary' onclick='sendForm(\"agregar\");'>"; 
echo "<table  width='100%'><tr><td valign='middle' align='center'>";
   echo "<img src='icon/ok2.png'> ";
   echo "</td>";
   echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
   echo "Guardar";
   echo "</td></tr></table></button>"; 
 echo "</center>";
 echo "</div>";

 //**********************************

 
 //CANCELAR EL REGISTRO DE UNA COLONIA
 if (isset($_GET['mensaje'])){

   $variables=explode("_", $_GET['mensaje']);

   $totalLotes=CantidadLotesPorColonia($variables[0],$variables[1]);
   
   mensajeAdvertencia('¿Esta seguro de querer dar de baja la colonia <b>'.NombreColoniaVivienda($variables[0],$variables[1]).'</b> del Municipio de <b>'.strtoupper(NombreMunicipio($variables[0])).'</b>, podrían verse lotes afectados.? <BR> <BR> <b>
   N° de Lotes Afectados: '.$totalLotes.'</b><br> ','lot_capturacolonias.php?cancelar='.$variables[0].'_'.$variables[1],'lot_capturacolonias.php?m='.$variables[0],'');

}




//**********************************

 
 //CANCELAR EL REGISTRO DE UNA COLONIA
 if (isset($_GET['cancelar'])){

   $variables2=explode("_", $_GET['cancelar']);

   

   $sql = "Update catcolonia set Cancelado=1 WHERE IdMunicipio='".$variables2[0]."' and IdColonia='".$variables2[1]."'";
      echo $sql; //comprobamos la sintaxis query
      if ($Vivienda->query($sql) == TRUE){
         historia($nitavu, "Dio de baja la colonia  a ".$variables2[1]." del muncipio ".$variables2[0]);
  
         mensaje("Se dio de baja con exito a la colonia","lot_capturacolonias.php?m=".$variables2[0]);
         
      } else{ 
         historia($nitavu, "ERROR al querer dar de baja a la colonia ".$variables2[1]." del muncipio ".$variables2[0].", SQL: ".$sql);
         
      }
      
}

?>



<!-- inicio  ////////////// ESTA PARTE CONSTRUYE EL MAPA CON LA SELECCION\\\\\\\\\\\\\\\\\\\\\ -->
<section id="municipios_seleccion">
<?php if($nivel==1)
{?>
<center>
<div id='municipios'> 

<a id='nuevacolonia' href='#nuevaColonia' rel='MyModal:open' class='btn btn-primary'  title='Capturar nueva colonia'> 
     <table  width='100%'><tr><td valign='middle' align='center'>
      <img src='icon/ok2.png'> 
       </td>
       <td valign='middle' align='center' style='color:white;' class='pc'>
       Nueva Colonia
      </td></tr></table>   
    </a>
    
    </div>
</center>
<?php 
}?>
<div id='municipios'> 
<h4>Municipios: </h4>
<?php //LISTA DE MUNICIPIOS

$sql2="SELECT * FROM cat_municipios order by Municipio ASC";
$r2 = $conexion -> query($sql2);
$seleccionados="";

   if (isset($_GET['mm'])){ // si hay seleccionado un MULTIPLE municipio
         $municipios_select = explode(",", $_GET['mm']);
         $municipios_n = count($municipios_select);            
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
         }
      }

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
              $seleccionados = $df['IdMunicipio'].",";              
         }
      }

      $seleccionados_ = explode(",", $seleccionados);$seleccionados_n = count($seleccionados_);       
      $seleccionados_n2 = $seleccionados_n -1;     
      for ($i = 0; $i <= $seleccionados_n2; $i++) {// si ya esta seleccionado poner sin seleccion     
         
            if ($seleccionados_[$i]==$df['IdMunicipio']){
               break;
            }
            else {
               echo 'class="municipios_mapa"';               
               break;

            }
         }
      }





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



$("#linkcancelar").on('click', function(event) {
   console.log('entro al link');
 
  // document.getElementById("req_captura").css({'display':'none'});
});

function validarCampos()
{
   coloniaNva = document.getElementById("ColoniaNva").value;
   idaquisicionNva = document.getElementById("IdTipoAdquisicionNva").value;

var validacion=true;
  if( coloniaNva == null || coloniaNva.length == 0 ) {
     $("#ColoniaNva").css("border-color", "red");
     validacion= false;
  }
  

   if( idaquisicionNva == "0" )  {
      $("#IdTipoAdquisicionNva").css("border-color", "red");
   validacion= false;
   }
   
     
   return validacion;
     
}

function validarCampos2(idmun,idcol)
{
   var validacion=true;
   coloniaEdit = document.getElementById("ColoniaEdit"+idmun+"_"+idcol).value;
   idaquisicionEdit = document.getElementById("IdTipoAdquisicionEdit"+idmun+"_"+idcol).value;

   if( coloniaEdit == null || coloniaEdit.length == 0 ) {
     $("#ColoniaEdit"+idmun+"_"+idcol).css("border-color", "red");
      validacion= false;
   }
   

   if( idaquisicionEdit == "0" )  {
      $("#IdTipoAdquisicionEdit"+idmun+"_"+idcol).css("border-color", "red");
      validacion=false;
   
   }
     return validacion;

}



function sendForm2(modal,idmun,idcol) {
   var formu;
   var idmun1=idmun;
   var idcol1=idcol;
   valido = validarCampos2(idmun1,idcol1);
   formu="formEditar";
  
  if (valido) {
   console.log('IDMUN'+idmun1);
   $("#msgdatosrequeridos"+idmun1+"_"+idcol1).css({'display':'none'});
    document.getElementById(formu+idmun1+"_"+idcol1).submit();
  } else {
   $("#msgdatosrequeridos"+idmun1+"_"+idcol1).css({'display':'inline-block'});
    return false;
  }
}


function sendForm(modal) {
   var formu;
   if(modal=="agregar")
{
   valido = validarCampos(); //DEBERIAS REALIZAR LAS VALIDACIONES
   formu="formAgregar";
   }else{
      valido = validarCampos2();
      formu="formEditar";
   }


  if (valido) {
   $("#msgdatosrequeridos").css({'display':'none'});
    document.getElementById(formu).submit();
  } else {
   $("#msgdatosrequeridos").css({'display':'inline-block'});
    return false;
  }
}
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