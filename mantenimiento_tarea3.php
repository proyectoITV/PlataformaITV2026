<?php


    require("config.php");
    require_once("lib/funciones.php");
    $msg = "";
    $c=0; $x=0; $tmp="";
    $nitavu = 0;
    



    $sql="update sessiones set cierre_fecha=curdate() 
    where fecha=curdate() and cierre_fecha=''";
    $resultado = $conexion -> query($sql);
    if ($conexion->query($sql) == TRUE) {       
        echo "Se cerraron sessiones activas";
        historia("0", "Tarea de mantenimiento, cierre de sessiones activas");
    }else {
        echo "Error al intentar sessiones activas";
    }
            


// notificacion_add("0", 'chat', $fecha, "", "Tarea de mantenimiento de reenvio de correos pendientes: (".fecha_larga($fecha)." - ".hora12($hora)."".$c." y fallos:".$x);





echo "<img src='icon/ok.png' style='width:18px;'>";
?>