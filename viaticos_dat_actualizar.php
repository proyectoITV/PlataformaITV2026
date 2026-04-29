<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$Idrecorrido = VarClean($_POST['Idrecorrido']);
$Nodias = VarClean($_POST['Nodias']);
$op = VarClean($_POST['Operacion']);
$IdViatico = VarClean($_POST['IdViatico']);

// $NDias = viaticos_NDias($IdViatico); // Numero de dias calculado por las fechas
// $NDias2=viaticosrecorridosNdias($IdViatico,$Idrecorrido); // Numero de dias ingresados por el usuario





if($op=='dias')
{
    $sql=" Update viaticosrecorridos set dias=$Nodias where IdRecorrido='".$Idrecorrido."'";
}
else if ($op=='dormir')
{
    $sql=" Update viaticosrecorridos set duerme_en_lugar=$Nodias where IdRecorrido='".$Idrecorrido."'";
}
else if ($op=='combustible')
{
    $sql=" Update viaticosrecorridos set pagarcombustible=$Nodias where IdRecorrido='".$Idrecorrido."'";
}

// echo $Nodias;
// echo "==";
// echo (int)$NDias;

// if( (int)$NDias>=( (int)$NDias2+ (int)$Nodias))
// {
    

    
    if ($conexion->query($sql) == TRUE) {
         Toast("Se guardo correctamente",4,"");
           // echo "<script> console.log('".$NDias2. "dias')</script>";
            if($op=='combustible'  )
            {
                 echo "<script> CrearGastos();</script>";
                 viaticosResumen();
            }
       
        // // MsgBox_Lite("Gasto Extra Agregado Correctamente ","viaticos.php?IdViatico=".$IdViatico."");
        // historia($nitavu,"Agrego Gasto extra para el Viatico ".$IdViatico.", ".$VGextra_concepto.", ".$VGextra_cantidad);
    } else {
        Toast("Error al guardar".$sql,2,"");
    }

     
?>
<script> viaticosResumen();</script>