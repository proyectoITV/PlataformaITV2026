<?php
require ("config.php");
require ("lib/funciones.php");
require ("lib/flor_funciones.php");


    $idmandante = $_POST['idmandante'];
    $idcolonia = $_POST['idcolonia'];
    $idmunicipio = $_POST['idmunicipio'];
    $nitavu = $_POST['nitavu'];


    $sql = "CALL arreglarPagosMandante('$idmandante', '$idcolonia', '$idmunicipio')";
    //echo $sql;
    if ($conexion->query($sql) == TRUE){
        mensaje('Se ha actualizado con éxito la información.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
        historia($nitavu, 'Recalcule los montos de saldo y monto acumaldo para el mandante '.$idmandante.', con id colonia: '.$idcolonia.' y el id municipio: '.$idmunicipio.'.');
    }else{
        echo "<p>Ocurrio un problema, favor de intentarlo de nuevo.</p>";
    }


    
?>
