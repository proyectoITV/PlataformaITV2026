<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");




 if(isset($_POST['idTipoSolicitud']) ){
    $NumContrato = $_POST['NumContrato'];

    $opcion = $_POST['idTipoSolicitud'];

    if ($opcion==1)
    {
     
    $sql="
    select * from vivienda_datosgenerales where NumContrato like '%".$NumContrato."%' and IdSolicitante=( select   IdSolicitante       from      vivienda_tramitesdeescritura    WHERE   NumContrato like '%".$NumContrato."%')";
    //echo $sql;  
    $l = $Vivienda -> query($sql);

   //*********************** DIV DATOS DEL SOLICITANTE ************************************** 
    echo '<center>';
    echo '<div class="card" style="text-align: justify" width:100%>  ';
    
    // echo "<table  width='100%'>
    // <tr>     
    // <td valign='middle'  width='90%'><h1 class='card-header h5' style='text-transform: uppercase;font-size: 10pt;'>Datos del Solicitante</h1></td>
 
    // </tr>
    // </table>";
    echo '<div id="parent"  class="card-header">
    <div id="wide" style="float: right;"   >';
    echo "<a href='#modalSolicitante' rel='MyModal:open' title='Clic editar la informacion del solicitante'><img src='icon/edit.png' style='width:16px; height:18px;'></a>";
    echo"</div>";
    echo '<div id="narrow" style="float: left;width: 90% ">';
    echo "<h1  style='text-transform: uppercase;font-size: 10pt;'>Datos del Solicitante</h1>";
    echo '</div>
  </div> '; 
    
 echo '<div class="card-body" style="font-size: 10pt">';                                           
  
    echo "<div style='width:90%' id='divSolicitud'>";
       
          while($valor = $l -> fetch_array())
            {                                             
            echo "<table  width='100%'>
            <tr>     
            <td valign='middle'  width='15%'><span class='normal' >Nombre del Beneficiario:</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['Nombre'] ."</span></td>
            </tr>
            <tr>
            <td valign='middle'  width='15%'><span class='normal' >Fecha Nacimiento</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".date('d-m-Y',strtotime($valor["FNacimiento"]))."</span></td>
            <td valign='middle'  width='15%'><span class='normal' >Lugar de Nacimiento</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['LugarNacSol']."</span></td>
            <td valign='middle'  width='15%'><span class='normal' >Estado de Nacimiento</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['Estado']."</span></td>
            </tr>
          
            <tr>
            <td valign='middle'  width='15%'><span class='normal' >Sexo</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['sexo']."</span></td>
            <td valign='middle'  width='15%'><span class='normal' >Nacionalidad</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['NacionalidadSol']."</span></td>
            <td valign='middle'  width='15%'><span class='normal' >Ocupación</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['Ocupacion']."</span></td>
            </tr>              
            
            <tr>
            <td valign='middle'  width='15%'><span class='normal' >Estado Civil</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['estadocivil']."</span></td>
            <td valign='middle'  width='15%'><span class='normal' >Regimen de Matrimonio</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['RegimenMatrimonio']."</span></td>
            <td valign='middle'  width='15%'><span class='normal' >Telefono</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['Telefono']."</span></td>
            </tr>

            <tr>
            <td valign='middle'  width='15%'><span class='normal' >Identificacion Oficial</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['NCElector']."</span></td>
            <td valign='middle'  width='15%'><span class='normal' >Curp</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['Curp']."</span></td>
            <td valign='middle'  width='15%'><span class='normal' >Número de Acta</span></td>
            <td valign='middle'  width='15%'><span class='tenue' >".$valor['NumeroActa']."</span></td>
            </tr>
            </table>";  
             }
     echo '</div>';
    echo '</div>';
    echo '</div>';    
   echo '</center>';         
   echo '<br>';  
   
 }
 else if ($opcion==2)
 {  

 //*********************** DIV DATOS DEL MENOR DE EDAD ************************************** 
  echo '<center>';
  echo '<div class="card" style="text-align: justify" width:100%>  ';
  echo '<div id="parent"  class="card-header">
  <div id="wide" style="float: right;"   >';
 
  echo"</div>";
  echo '<div id="narrow" style="float: left;width: 90% ">';
  echo "<h1  style='text-transform: uppercase;font-size: 10pt;'>Datos de Menor</h1>";
  echo '</div>
  </div> ';    
  echo '<div class="card-body" style="font-size: 10pt">';                                           
  echo "<div style='' id='divSolicitud'>";  
  echo'<center>';
  echo '<div class="container">
 
  <div class="row">
    <div class="col">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Ratón</td>
            <td>15</td>
            <td>100</td>
          </tr>
          <tr>
            <td>Teclado</td>
            <td>34</td>
            <td>340</td>
          </tr>
          <tr>
            <td>Pantalla</td>
            <td>10</td>
            <td>400</td>
          </tr>
        </tbody>
      </table>
    </div>
   
  </div>';
  echo '</center>';


  echo '</div>';
  echo '</div>';
  echo '</div>';    
  echo '</center>';         
  echo '<br>'; 

 }
 else if ($opcion==3)
 {  

 //*********************** DIV DATOS DEL COPROPIETARIOS ************************************** 
  echo '<center>';
  echo '<div class="card" style="text-align: justify" width:100%>  ';
  echo '<div id="parent"  class="card-header">
  <div id="wide" style="float: right;">';

  echo"</div>";
  echo '<div id="narrow" style="float: left;width: 90% ">';
  echo "<h1  style='text-transform: uppercase;font-size: 10pt;'>Datos de los copropietrarios</h1>";
  echo '</div>
  </div> ';    
  echo '<div class="card-body" style="font-size: 10pt">';                                           
  echo "<div style='width:90%' id='divSolicitud'>";           
  echo '</div>';
  echo '</div>';
  echo '</div>';    
  echo '</center>';         
  echo '<br>'; 

 }
   

}else{
    echo 'ERROR: al recibir la información, favor de intentarlo de nuevo.';
}

    ?>
<script>

function EditarSolicitante()
{
  // Obtenemos el modal 
  modal = document.getElementById("myModavlaAgregar"); 
      
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
    
}

   </script>