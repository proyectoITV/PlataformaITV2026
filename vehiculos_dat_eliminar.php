<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("vehiculos_fun.php");
require_once("lib/flor_funciones.php");


$IdVehiculo  = VarClean($_POST['IdVehiculo']);
$Bitacoras = BitcoraCount($IdVehiculo);
$VInfo = Vehiculo_Info($IdVehiculo);
if ($Bitacoras >0){
    Toast("Error, este vehiculo no puede ser eliminado, ya que tiene ".$Bitacoras." bitacoras registradas. Se recomienda en vez de eliminarlo ponerle en Inactivo.",2,"");
} else{
    $sql="DELETE FROM vehiculos 
    WHERE Num_economico='".$IdVehiculo."'";
    echo $sql;
    $resultado = $conexion -> query($sql);
    if ($conexion->query($sql) == TRUE) {
       
        // Toast("Eliminado Correctamente ".$IdVehiculo."",4,"");
        historia($nitavu,"[vehiculos] Elimino Vehiculo del Catalago ".$VInfo."sql=".addslashes($sql));
        MsgBox_Lite("Vehiculo ".$VInfo."-".$IdVehiculo." eliminado correctamente","vehiculos.php");


    }else {
        Toast("Error al Eliminar".$IdVehiculo."",2,"");
    }
    unset($sql,$resultado);
}

?>