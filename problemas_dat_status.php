<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");

$IdProblema = VarClean($_POST['IdProblema']);
$IdStatus = VarClean($_POST['IdStatus']);
$IdUsuario = $nitavu;

if (Problema_set_status($IdProblema, $IdUsuario, $IdStatus) == TRUE){
    Toast("Se actualizo correctamente el Status del Problema ".$IdProblema,4,"");
    echo "<script>problemasReload();</script>";
} else {
    Toast("Error al actualizar el Status del Problema= ".$IdProblema,2,"");
}


// unset($sql, $r, $f);

?>