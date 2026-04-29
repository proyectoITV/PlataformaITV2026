<?php
include("./lib/body_head.php");
include("./lib/body_menu.php"); 
?>
<script>
function v001Data(){   
var Len = $("#beta_buscar_input").val().length;    
var NumContrato = $("#beta_buscar_input").val();
$('#buscando').html(NumContrato);


if (Len >= 3){
    $("#indicaciones").html("<a href='' style='display:block;'>Iniciar nueva busqueda</a>");
   

    $("#Loader2").show()
    $("#Data").html("");
    search = $('#beta_buscar_input').val();
    $.ajax({
        url: "e001_DatosSolicitud.php",
        type: "post",   
        data: {NumContrato: NumContrato },
        success: function(data){
         
        $('#Data').html(data+"\n");
        $("#Loader2").hide()
      }
   });
} else {
    var faltan = 3- Len;
    $.toast({
    heading: 'Warning',
    text: "Escriba <b>"+faltan+"</b> caracteres, para poder iniciar la busqueda.",
    showHideTransition: 'plain',
    icon: 'warning'
})
}

}
</script>
<?php
$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap108";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
// $nivel=1;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
    historia($nitavu,'['.$id_aplicacion.'] Iniciando'); 
    echo "<br>";
    echo "<center>";  

/***************** MODAL SOLICITANTE****************************/
echo "<div id='modalSolicitante' class='MyModal' >";  
echo '<form action="cp_numNuevoDocumento_db.php" method="POST">';			        
   echo "<h3>Editar Solicitante </h3>"; 		
   
//    echo "<div >";
//    echo "<label for='NombreSolicitante' class='label'>Nombre:";
//    echo "<select name='tipoDocumento'     style='margin-left: 0px;'>";	
//    echo '<option value="0" selected="selected">Seleccione</option>';		
//    $sql = "select * from cat_tipo_documento";			
//      $r = $conexion -> query($sql);		 
//      while($f = $r -> fetch_array())
//      { 
//        echo "<option value='".$f['IdTipoDocumento']."'>".$f['TipoDocumento']. " </option>";
//      }				
//    echo "</select>";
//    echo "</label>";
//  echo "</div>";
  
//  echo "<div>";			
//    echo "<label for='departamento' class='label'>Departamento:";
//    echo "<select name='departamento'   id='departamento'   style='margin-left: 0px;'>";	
//    echo '<option value="0" selected="selected">Seleccione </option>';		
//    echo '<option value="100" >Fuera del Instituto </option>';
//    $sql="SELECT	cat_gerarquia.id ,	cat_gerarquia.titular ,	cat_gerarquia.nombre,	cat_gerarquia.dependencia
//      FROM	cat_gerarquia where (id <>".nitavu_dpto($nitavu).") ORDER BY cat_gerarquia.nombre ";
//      echo $sql;
//      $r = $conexion -> query($sql);	
       
//      while($f = $r -> fetch_array())
//      { 
//        echo "<option value='".$f['id']."'>".$f['nombre']. " </option>";
//      }	
           
//    echo "</select>";
 
//    echo "</label>";
//  echo "</div>";

 echo "<div>";			
  echo "<label for='nombreSolicitante' class='label'>Nombre:";
	echo "<input type='text' id=nombreSolicitante' name='nombreSolicitante'    required>"; 
  echo "</label>";
 echo "</div>";

 echo "<div>";			
  echo "<label for='apellidoPaterno' class='label'>Apellido Paterno:";
	echo "<input type='text' id=apellidoPaterno' name='apellidoPaterno'  required>"; 
  echo "</label>";
 echo "</div>";

 echo "<div>";			
  echo "<label for='apellidoMaterno' class='label'>Apeliido Materno:";
	echo "<input type='text' id=apellidoMaterno' name='apellidoMaterno'    required>"; 
  echo "</label>";
 echo "</div>";

 echo "<div>";			
 echo "<label for='fechaNacimiento' class='label'>Fecha de Naciemiento:";
 echo "<input type='date' id=fechaNacimiento' name='fechaNacimiento'    required>"; 
 echo "</label>";
echo "</div>";

echo "<div>";			
echo "<label for='lugarNacimiento' class='label'>Lugar de Naciemiento:";
echo "<input type='text' id=lugarNacimiento' name='lugarNacimiento'    required>"; 
echo "</label>";
echo "</div>";

echo "<div>";			
echo "<label for='estados' class='label'>Estado:";
echo "<select name='estados'   id='estados'   style='margin-left: 0px;'>";	
echo '<option value="0" selected="selected">Seleccione </option>';	
$sql="SELECT	* from estados";
  echo $sql;
  $r = $Vivienda -> query($sql);	
  while($f = $r -> fetch_array())
  { 
    echo "<option value='".$f['IdEstado']."'>".$f['Estado']. " </option>";
  }	        
echo "</select>"; 
echo "</label>";
echo "</div>";

echo "<div>";			
echo "<label for='sexo' class='label'>Sexo:";
echo "<select name='sexo'   id='sexo'   style='margin-left: 0px;'>";	
$sql="SELECT	* from sexo";
  echo $sql;
  $r = $Vivienda -> query($sql);	
  while($f = $r -> fetch_array())
  { 
    echo "<option value='".$f['IdSexo']."'>".$f['Sexo']. " </option>";
  }	        
echo "</select>"; 
echo "</label>";
echo "</div>";


echo "<div>";			
echo "<label for='nacionalidad' class='label'>Nacionalidad:";
echo "<select name='nacionalidad'   id='nacionalidad'   style='margin-left: 0px;'>";	
echo '<option value="0" >Seleccione </option>';	
echo '<option value="1">MEXICANO(A) </option>';	
echo '<option value="2" >EXTRANJERO(a) </option>';	   
echo "</select>"; 
echo "</label>";
echo "</div>";
echo "<label for='observaciones'>Observaciones</b>:";
echo "<textarea name='observaciones'style='border-width:1px; height:20%' ></textarea>";
echo "<input type='submit' value='Solicitar' class='Mbtn btn-default btnAlta' name='btnSolicitar'>";



 echo "</form>";
echo " </div>";




   
    echo "<div style='margin-top:45px' class='movil'></div>";
      echo "<section id='v001' style='background-color: #f9f3f0;width:100%;'>";
         echo '<div  style=" padding: 6px; background-color: #eeece6;  id="beta_buscar_input"
         margin-top: 20px; margin-left: 0px; border-radius: 5px; border: 1px solid #f0e1c5; margin-right: -10px; ">';
         echo '<form>'; 
         echo ' <table width=100%><tr><td>';    
            if (isset($_GET['search'])) {
               $Search = $_GET['search']; if (ValidaVAR($Search)==TRUE){$Search = LimpiarVAR($Search);} else {$Search = "";}     
               echo '<input  required="required" type="text"  style="text-align: left; " id="beta_buscar_input"  value="'.$Search.'"  onkeyup = "if(event.keyCode == 13) v001Data();"  name="search" placeholder="Buscar Tramite de Escritura (Beneficiario, Número de Contrato, Numero de trámite)" />';
               echo "<script>v001Data();</script>";
            } else {
            
               echo '<input required="required" type="text"  style="text-align: left;" onkeyup = "if(event.keyCode == 13) v001Data();" id="beta_buscar_input" name="search" placeholder="Buscar Tramite de Escritura (Beneficiario, Número de Contrato, Numero de trámite)" />';
            }
            echo "</td>";
            // <td>
            
            // <button class='Mbtn btn-Success'  style='font-size: 8pt;width: 100%; height: 60px; margin-top: 0px;' onclick='v001Data();'>
            // <img src='icon/buscar2.png' style='width:40px;'>
            // </button></td>
            echo '<td align="right" width="15px">                    
            <button id="beta_buscar_boton" onclick="v001Data();">
            <img  src="icon/buscar.png"></button>
            </td>';
            echo "</tr></table>";
            echo '<form>'; 
            echo "</div>";         
      echo "</section>";  
        
        

         echo "<div id='Resultado' style=' width: 100%; padding-top: 13px; padding-bottom: 13px; '>";      
         echo "</div>";
         echo "<div id='Loader2' style='  width: 100%;padding-top: 13px; padding-bottom: 13px; text-align:center;  display:none; '>
               <label style='font-size:14pt; font-weight:bold; color:orange;'>Buscando <span id='buscando' style='color:#00468C; font-weight;bold;'>"."</span>, Espere por favor <img src='img/loader_bar.gif' ></label>
               </div>";
         echo "<div id='Data' style='width: 100%; padding-top: 13px;padding-bottom: 13px;text-align:center; '>";
         echo "</div>";
   echo "</div>";   
   echo "</center>";


  

    
} else {
    mensaje("ERROR: no tiene acceso a esta aplicacion. <br>
    <a href='organigrama.php'>Solicitelo al Departamento de Informática a traves de la Dirección General. </a> <br>
    ","");
}




?>

<?php

if (isset($_GET['search'])) {
    echo "
    <script>
        v001Data();
    
    </script>";
}
?>


<?php
include ("./lib/body_footer.php"); ?>