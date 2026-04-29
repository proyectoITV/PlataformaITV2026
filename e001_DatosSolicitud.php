<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");




 if(isset($_POST['NumContrato']) 
 ){


   $NumContrato = $_POST['NumContrato'];
    $sql="select     NumContrato,NumEscritura,Folio,FechaCaptura    
    from      vivienda_tramitesdeescritura
    WHERE NumContrato like '%".$NumContrato."%'";
    //echo $sql;  
    $l = $Vivienda -> query($sql);
    $r_count2 = $l -> num_rows;
    if($r_count2>0){
   //*********************** DIV DATOS DEL SOLICITANTE ************************************** 
    echo '<center>';
    echo "<div style='width:90%' id=divSolicitud>";
       echo '<div class="card" style="text-align: justify">
          <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Datos del Solicitud</h1>';
          echo '<div class="card-body" style="font-size: 10pt">';    
          while($valor = $l -> fetch_array())
   {                                             
            echo "<table  width='100%'>
            <tr>     
            <td valign='middle'  width='15%'><span class='normal' >Número de Contrato:</span></td>            
            <td valign='middle'  width='15%'><input type='hidden' id='NumContrato' value='".$NumContrato."'/><span class='tenue' >".$NumContrato ."</span></td>
            <td valign='middle'  width='15%'><span class='normal' >Folio de la solicitud:</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['Folio']."</span></td>
            <td valign='middle'  width='15%'><span class='normal' >Tipo de Trámite:</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >";
            echo "<select name='tipotramite' id='tipotramite' onchange='MostrarDatos();'>";
            echo "<option value=1>NORMAL</option>";
            echo "<option value=2>MENOR DE EDAD </option>";
            echo "<option value=3>COOPROPIETARIOS</option>";
            echo "</select></td>
            </tr>
            <tr> 
            <td valign='middle'  width='15%'><span class='normal' >Número de Escritura:</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['NumEscritura'] ."</span></td>
            <td valign='middle'  width='15%'><span class='normal' >Fecha de Escritura:</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".date_format( date_create($valor['FechaCaptura']), 'd/m/Y') ."</span></td>
            <td valign='middle'  width='15%'><span class='normal' >Estatus de Trámite</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >PENDIENTE</span></td>";          
            echo"</tr>                         
               </table>";  
             }
                                               
          echo '</div>';
       echo '</div>';
    echo '</div>';  
   echo '</center>';         
   echo '<br>';  
   
 //*********************** DIV DATOS DEL SOLICITANTE ************************************** 
 echo '<center>';
 echo "<div style='width:90%' id=muestraDatos>";
    echo '<div class="card" style="text-align: justify">';
  
      
    echo '</div>';
 echo '</div>';  
echo '</center>';         
echo '<br>';  
  
   //*********************** DIV DEL TERRENO ************************************** 
   echo '<center>';
         echo "<div style='width:90%' id=divTerreno>";
            echo '<div class="card" style="text-align: justify">
               <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Datos del Terreno</h1>';
               echo '<div class="card-body" style="font-size: 10pt">';                                            
               $Idlote = numContratoLote($NumContrato);
                   if(($Idlote !='' and  $Idlote !='0' ) OR ($NumContrato !='' AND $NumContrato !=NULL)) 
                   {   //$Idlote = numContratoLote($NumContrato);                                                     
                       echo MuestraUbicacionLote($Idlote,'width: 90%;font-size: 10pt;');

                   }                                            
               echo '</div>';
            echo '</div>';
         echo '</div>';  

         echo '<br>';  
     /* **************************** MEDIDAS Y COLINDANCIAS ***************************** */
         echo "<div style='width:90%' id=divDatos>";
         echo '<div class="card" style="text-align: justify; width: 100%;">
                 <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Medidas y Colindancias</h1>';
                 echo '<div class="card-body" style="font-size: 10pt; width: 100%;">';                  
                      echo MuestraMedidaColindanciasLote($Idlote,'width: 90%;font-size: 10pt;');        
                 echo '</div>';
         echo '</div>';

      echo '</center>';         
   echo '<br>'; 
   }else
   {
      //echo 'No se encontró información con los datos ingresados, favor de intentarlo de nuevo.';
      mensaje("No se encontró información con los datos ingresados, favor de intentarlo de nuevo.","e001.php");
  
   }  

}else{
    echo 'ERROR: al recibir la información, favor de intentarlo de nuevo.';
}

    ?>
<script>

$( document ).ready(function() { 
   MostrarDatos();
});

function MostrarDatos()
{
var id = document.getElementById("tipotramite").value;
var NumContrato = document.getElementById("NumContrato").value;
        $.ajax({
            url: "e001_MuestraDatos.php",
            type: "post",
            data: {idTipoSolicitud: id, NumContrato: NumContrato},
            success: function(data){         
                   
                $('#muestraDatos').html(data+"\n");
            }
        });       
}


     // Obtenemos el modal 
     modal = document.getElementById("myModalaAgregar"); 
      
      //Agregamos al divconetenedor el un input que almacena el Id que seleccionó
    // document.getElementById("contenedor").innerHTML = ["<input type=hidden id=idconcepto   name=idconcepto value="+id+">"]; 
      
     // Get the <span> element that closes the modal  
      span = document.getElementsByClassName("close")[0];        
     
    
     //Hacer visible el modal
      modal.style.display = "block";
     
     // When the user clicks on <span> (x), close the modal
     span.onclick = function() 
     {
      
       modal.style.display = "none";
     }
   </script>