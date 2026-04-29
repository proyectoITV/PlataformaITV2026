<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$IdGasto = VarClean($_POST['IdGasto']);
$IdViatico = VarClean($_POST['IdViatico']);

    $sql="
    DELETE FROM viaticosgastosextras
    WHERE IdGastoExtra='".$IdGasto."'

    
    ";
    
    if ($conexion->query($sql) == TRUE) {
        Toast("Se cancelo correctamente el Gasto ExtraViatico ".$IdViatico,4,"");
        // MsgBox_Lite("Gasto Extra ".$IdGasto." eliminado Correctamente ","viaticos.php?IdViatico=".$IdViatico."");
        historia($nitavu,"Cancelo Gasto extra para el Viatico ".$IdViatico." - ".$IdGasto);
    } else {
        Toast("Error al guardar".$sql,2,"");
    }
     
?>
<script> viaticosResumen();</script>