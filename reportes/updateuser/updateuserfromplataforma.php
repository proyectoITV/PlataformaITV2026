<?php
require ("../rintera-config.php");
require ("../components.php");
require ("../seguridad.php");

//Plataforma IdCon=1
//Rintera IdCon=3

//Paso 1 Preparar el INSERT desde la Plataforma
$QueryInsert = ""; $Info = "";
$Con_IdCon = 1; include("../con_init.php");
if ($Con_Val == TRUE){
    $sql = "
  
        select 
        a.IdEmpleado as IdUser, 
        (select nip from empleados where nitavu = a.IdEmpleado)as NIP, 
        a.Nombre as UserName, 
        nivel as RinteraLevel
        from AplicacionesPermisos a where NIdApp='rintera'
    
    ";    
    $c = 0;
    $r = $LaConeccion -> query($sql);    
    while($f = $r -> fetch_array()) {   
        if ($f['IdUser']<> $nitavu){
            $QueryInsert.= "INSERT INTO users(IdUser, NIP, UserName, RinteraLevel) VALUES('".$f['IdUser']."','".$f['NIP']."','".$f['UserName']."','".$f['RinteraLevel']."');";
        }

        $c= $c + 1;
    }
    
} else {
    echo "ERROR: ".$Con_Msg;
}
include("../con_close.php");
// echo "Query para Insert: <br>".$QueryInsert;



$Vaciada = FALSE;
//Paso 2 Vaciar tabla de users de rintera
$Con_IdCon = 3; include("../con_init.php");
if ($Con_Val == TRUE){
    $sql = "delete from users WHERE IdUser<>'".$nitavu."'";
    if ($LaConeccion->query($sql) == TRUE)
    {	
        $Vaciada = TRUE;
    }
        else
    {	
        $Vaciada = FALSE;
    }
    
} else {
    echo "ERROR: ".$Con_Msg;
}
include("../con_close.php");


//Paso 3, Actualizar la Tabla con $QueryInsert
if ($Vaciada == TRUE){
    //Paso 2 Vaciar tabla de users de rintera
    $Con_IdCon = 3; include("../con_init.php");
    if ($Con_Val == TRUE){
        // $sql = "delete from users";



        if (!$LaConeccion->multi_query($QueryInsert)) {
            echo "Falló la multiconsulta: (" . $LaConeccion->errno . ") " . $LaConeccion->error;
            echo "<p style='font-weight:bold; color:white; background-color:red;
            padding:10px; border-radius:10px;width:90%;
            '>Hubo un ERROR al actualizar los usuarios</p>";
            // var_dump($LaConeccion);
            // var_dump($QueryInsert);
            historia_rintera($nitavu, "ERROR","ERROR UPDATE USER al ejecutar los usuarios desde la plataforma. SQL=".$QueryInsert."");
        } else {
            echo "<p style='font-weight:bold; color:black; background-color:white;
            padding:10px; border-radius:10px;width:90%;
            '><img src='../icons/ok.png' style='width:32px;'>Se han actualizado correctamente ".$c." usuarios desde la Plataforma ITAVU.<br> <cite>
            Los NIP de acceso, son los mismos de la plataforma.<br>
            * Con Excepcion de tu usuario = ".$nitavu."
            </cite></p>";
            historia_rintera($nitavu, "UPDATE USER","Ejecuto los usuarios desde la plataforma. SQL=".$QueryInsert."");
        
        }
        
        do {
            if ($resultado = $LaConeccion->store_result()) {
                var_dump($resultado->fetch_all(MYSQLI_ASSOC));
                $resultado->free();
            }
        } while ($LaConeccion->more_results() && $LaConeccion->next_result());
        
    } else {
        echo "ERROR: ".$Con_Msg;
    }
    include("../con_close.php");


} else {
    echo "Ha ocurrido un error, revise la tabla usuarios no ha podido prepararse para recibir los usuarios de la plataforma.";
}



?>