<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$IdViatico = VarClean($_POST['IdViatico']);
$VGextra_concepto = VarClean($_POST['VGextra_concepto']);
$VGextra_cantidad =  VarClean($_POST['VGextra_cantidad']);

    $sql="
    INSERT INTO viaticosgastosextras
    (GastoExtra_Descripcion, GastoExtra_Cantidad, IdViatico, act_fecha, act_user)
    VALUES (
        '".$VGextra_concepto."',
        '".$VGextra_cantidad."',
        '".$IdViatico."',
        '".$fecha."',
        '".$nitavu."'

    )

    
    ";
    echo $sql;
    
    if ($conexion->query($sql) == TRUE) {
        Toast("Se guardo correctamente el Gasto ExtraViatico ".$IdViatico,4,"");
        // MsgBox_Lite("Gasto Extra Agregado Correctamente ","viaticos.php?IdViatico=".$IdViatico."");
        historia($nitavu,"Agrego Gasto extra para el Viatico ".$IdViatico.", ".$VGextra_concepto.", ".$VGextra_cantidad);
    } else {
        Toast("Error al guardar".$sql,2,"");
    }
     
?>
<script> viaticosResumen();</script>