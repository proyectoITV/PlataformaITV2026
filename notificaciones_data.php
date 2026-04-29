<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("vehiculos_fun.php");
require_once("lib/flor_funciones.php");


$IdNotificacion  = VarClean($_POST['IdNotificacion']);
$sql = "update notificaciones set visto=1 where id='".$IdNotificacion."'";
echo $sql;
if ($conexion->query($sql) == TRUE){   
    echo "<script>
    $('#".$IdNotificacion."').css('background-color','white');
    $('#btn_".$IdNotificacion."').hide();
    </script>
    ";
}


?>