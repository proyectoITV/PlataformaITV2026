<?php


$Con_IdCon = 1; include("con_init.php");


if ($Con_Val == TRUE){
    $sql = "select @@version as Version";
    $r = $LaConeccion -> query($sql);
    if($f = $r -> fetch_array()){
        var_dump($f);

    } else {
        echo "No se ha podido conectar";
    }
    
} else {
    echo "ERROR: ".$Con_Msg;
}



include("con_close.php");

?>