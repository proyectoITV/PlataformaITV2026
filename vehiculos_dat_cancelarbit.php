<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("vehiculos_fun.php");
require_once("lib/flor_funciones.php");



// $NBitacora =  NIdVBitacora(FALSE);


$Clave_servicio = VarClean($_POST['Clave_servicio']);
$IdVehiculo  = Clave_servicio_to_IdVehiculo($Clave_servicio);
$VInfo = Vehiculo_Info($IdVehiculo);



    $sql="
        update vehiculos_bitacora
        SET Cancelada=1
        WHERE Clave_servicio='".$Clave_servicio."'
    ";
    // echo $sql;
    // $resultado = $conexion -> query($sql);
    if ($conexion->query($sql) == TRUE) {
       
        // Toast("Eliminado Correctamente ".$IdVehiculo."",4,"");
        historia($nitavu,"[vehiculos] Cancelo la  Bitacora ".$Clave_servicio." para el Vehiculo".$VInfo."sql=".addslashes($sql));
        // MsgBox_Lite("Bitacora ".$NBitacora." registrada correctamente para el Vehiculo ".$VInfo."-".$IdVehiculo."","vehiculos.php");
        Toast("Bitacora ".$Clave_servicio." cancelada correctamente para el Vehiculo ".$VInfo."-".$IdVehiculo."",3,"");
        echo "<script>VBReload();</script>";
         
       

    }else {
        Toast("Error al Cancelar ".$NBitacora."",2,"");
    }
    unset($sql,$resultado);


?>