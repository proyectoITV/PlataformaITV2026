<?php 

require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");
?>

<?php
      
  if (isset($_GET['curp'])){
    $CURP = $_GET['curp']; if (ValidaVAR($CURP)==TRUE){$CURP = LimpiarVAR($CURP);} else {$CURP = "";}
    $nitavu = $_GET['nitavu']; if (ValidaVAR($nitavu)==TRUE){$nitavu = LimpiarVAR($nitavu);} else {$nitavu = "";}

    $CURP = strtoupper ($CURP);
    $Beneficiario = "";
    
    $ResultadoDelCURP = CURP($CURP, $nitavu); //<-- se entrega en formato JSON
    //echo $ResultadoDelCURP;
   //var_dump($ResultadoDelCURP);

    $DatosExtras="";
    $c = 1; $array = json_decode($ResultadoDelCURP, true);
    $exito = FALSE;
    if(is_array($array)){   
     
        foreach ($array as $value) {
          if ($c==1){
            if ($value==1){
              $exito = TRUE;
            }
          } else {
            if ($exito == TRUE){
           
              $Beneficiario = $value['nombres']." ".$value['apellido1']." ".$value['apellido2'];
              $FechaNacimiento = ConvertirFechaParaMySQL($value['fechNac']);
              $Edad = CalcularEdad($FechaNacimiento);
              $Sexo = $value['sexo'];
              $DatosExtras = $DatosExtras."
              Edad: <b>". $Edad ." años</b>, Fecha de Nacimiento: ".$value['fechNac']." <br>
              Nacionalidad: ".$value['nacionalidad'].", Nacio en <b> ".$value['nombreEntidadNac']."</b><br>
              Estatus del CURP: ".$value['statusCurp']."";

              echo "<div id='DatosDelCurp' style='width: 100%;'><center>";
              echo "<span style='font-size:16pt; color:#999999;'> Beneficiario : </span><b style='font-size:18pt; font-weight:bold; color:#990000;'>".$Beneficiario."</b><br>";
              echo "<span style='font-size:16pt; color:#999999;'>".$DatosExtras."</span>";
              echo "<input type='hidden' name='Nombre' id='Nombre' value='".$Beneficiario."'>";
              echo "<input type='hidden' name='CURP' id='CURP' value='".$CURP."'>";
              echo "<input type='hidden' name='Genero' id='Genero' value='".$Sexo."'>";
              echo "<input type='hidden' name='Edad' id='Edad' value='".$Edad."'>";
              echo "<input type='hidden' name='FechaNacimiento' id='FechaNacimiento' value='".$FechaNacimiento ."'>";
              echo "</center></div>";

            }else{ 
              echo "<div id='DatosDelCurp' style='width: 100%;'><center>";
              echo "<span style='font-size:14pt; color:#108FF3;''> No se ha encontrado información sobre esta persona, verifique los datos. </span>";
              echo "</center></div>";       
              
            }
            
          }
          $c= $c +1;   
        
      }
    } else {

              /*Nota: Se comento el siguiente codigo para cuando no trae respuesta el webservice*/
              // echo "No se ha encontrado información sobre esta persona, verifique los datos.";


              /*Codigo para llenar manualmente los datos del curp.*/
              echo "<div id='DatosDelCurp' style='width: 100%;'><center>";            
              echo "<br>"; 
              echo "<span style='font-size:12pt; color:gray; font-weight:bold'> Favor de llenar los siguientes datos: </span><br>";      
              echo "<label>Curp:<input type='text' name='CURP' id='CURP' value='".$CURP."'></label><br>";
              echo "<label>Nombre:<input style='width:98%; margin:0px; color:#484848; font-size:10pt; font-family:Regular' type='text' name='Nombre' id='Nombre' value=''></label>";
              echo "<label>Genero:<select name='Genero'>"; 
              echo "<option value='F'>Femenino</option>";
              echo " <option value='M'>Masuculino</option>";           
              echo "</select></label>";             
              echo "<label>Fecha Nacimiento:<input type='date' name='FechaNacimiento' id='FechaNacimiento' value=''></label>";
               echo "<label>Edad:<input type='number' name='Edad' id='Edad' value='' ></label>";
              echo "</center></div>";
              
    }

   
    
   

  } else {echo "Parametros incorrectos";}

?>

<script>

  /*FUNCION PARA CALCULAR LA FECHA DE NACIMIENTO*/
 $(function(){
            $('#FechaNacimiento').on('change', calcularEdad);
        });
        
        function calcularEdad() {
            
            fecha = $(this).val();
            var hoy = new Date();
            var fechanac = new Date(fecha);
            var edad = hoy.getFullYear() - fechanac.getFullYear();
            var m = hoy.getMonth() - fechanac.getMonth();

            if (m < 0 || (m === 0 && hoy.getDate() < fechanac.getDate())) {
                edad--;
            }
            $('#Edad').val(edad);
        }
  </script>