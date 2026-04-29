<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("vehiculos_fun.php");
// require_once("lib/flor_funciones.php");
$IdEquipo = VarClean($_POST['IdEquipo']);

if (GenToken_CheckEquipoEstatus($IdEquipo) == '1')    {
    if (GenToken_EquipoDesactivar($IdEquipo) == TRUE){
        Toast("Equipo Desactivado con Exito",4,"");
    } else {
        Toast("Error al desactivar el equipo",2,"");
    }
} else {
    if (GenToken_EquipoActivar($IdEquipo) == TRUE){
        Toast("Equipo Activado con Exito",4,"");
    } else {
        Toast("Error al activar el equipo",2,"");
    }
}

echo "<script>Reload();</script>";
?>