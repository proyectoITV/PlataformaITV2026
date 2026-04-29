<?php 
require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");
?>

<?php
      
  if (isset($_GET['curp'])){
    $CURP = $_GET['curp']; if (ValidaVAR($CURP)==TRUE){$CURP = LimpiarVAR($CURP);} else {$CURP = "";}
    

    $Beneficiario = "";
    
    $ResultadoDelCURP = CURP($CURP, $nitavu); //<-- se entrega en formato JSON
    $DatosExtras="";
    $c = 1; $array = json_decode($ResultadoDelCURP, true);
    if(is_array($array)){        
        foreach ($array as $value) {
            if ($c==2){

            $Beneficiario = $value['nombres']." ".$value['apellido1']." ".$value['apellido2'];
            $FechaNacimiento = ConvertirFechaParaMySQL($value['fechNac']);
            $DatosExtras = $DatosExtras."
            Edad: <b>".CalcularEdad($FechaNacimiento)." años</b>, Fecha de Nacimiento: ".$value['fechNac']." <br>
            Nacionalidad: ".$value['nacionalidad'].", Nacio en <b> ".$value['nombreEntidadNac']."</b><br>
            Estatus del CURP: ".$value['statusCurp']."

            ";
            

            }
            $c= $c +1;
        }
    } else {
        echo "No es un array";
    }

    echo "<div id='DatosDelCurp'>";
    echo "<b style='font-size:18pt; font-weight:bold; color:#E04726;'>".$Beneficiario."</b><br>";
    echo "<span style='font-size:10pt; color:#999999;'>".$DatosExtras."</span>";

    echo "</div>";
    //Tabla Dinamica
        $sql="
        select 
        IdTramite, 
                CONCAT('Tramite ',NombreTramite, ' de ',Departamento, '. El ', Fecha, ' = ',EstadoDescripcion) as Info
                
               
        from 
        tramitesbusqueda_html a
        WHERE NombreBeneficiario like '%".$Beneficiario."%' OR Curp like '%".$CURP."%'";
        // echo $sql;
        echo "<hr><b style='font-size: 8pt; color:#3484BE;'>Informacion de tramites encontrados de está persona:</b>";
        TablaDinamica_MySQL("",$sql, "tramitesNuevo", "tramitesNuevoTabla", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
   

  } else {echo "Parametros incorrectos";}

?>
