<?php 
require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");
?>
<?php
$idTramite = $_POST['Folio'];
$nitavu = $_POST['nitavu'];
$obs = $_POST['obs'];
$idTipo = $_POST['idTipo'];
    $midpto = nitavu_dpto($nitavu);
    $vobo = cualVistoBuenoSoy($midpto, $idTipo);

    if($vobo <> 'FALSE'){
        $sql = "UPDATE tramites SET ".$vobo." = ".$nitavu." WHERE IdTramite=".$idTramite ."";
        //echo $sql;
        if ($conexion->query($sql) == TRUE) {
            $sql1 = "INSERT INTO tramitesObservaciones(Id, IdTramite, Fecha, Hora, NitavuCaptura, Observacion, Cancelado,Estado) 
            VALUES ( '', '$idTramite', '$fecha','$hora','$nitavu','$obs', 0,1)";
            if ($conexion->query($sql1) == TRUE){
                historia($nitavu, "Marque con visto bueno (".$vobo.") al tramite ".$idTramite." y puse esta observación ".$obs."");
                echo 'TRUE';  
            }else{
                echo 'FALSE';
            }
            
        }else {
            echo 'FALSE';
        }
    }
    

?>