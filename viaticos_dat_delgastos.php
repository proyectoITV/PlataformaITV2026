<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$IdGasto = VarClean($_POST['IdGasto']);
$IdViatico = VarClean($_POST['IdViatico']);
$txtComida = VarClean($_POST['txtComida']);

if ($txtComida =='Almuerzo'){
    if (viaticos_DelGastoAlmuerto($IdGasto, $IdViatico, $nitavu) == TRUE){
        Toast("Se elimino correctamente Almuerzo",0,"");
    } else {
        Toast("Error al eliminar el gasto del almuerzo",2,"");
    }
} else {
    if ($txtComida =='Comida'){
        if (viaticos_DelGastoComida($IdGasto, $IdViatico, $nitavu) == TRUE){
            Toast("Se elimino correctamente la Comida",0,"");
        } else {
            Toast("Error al eliminar el gasto del Comida",2,"");
        }


    } else {
        if ($txtComida =='Cena'){ 
            if (viaticos_DelGastoCena($IdGasto, $IdViatico, $nitavu) == TRUE){
                Toast("Se elimino correctamente la Cena",0,"");
            } else {
                Toast("Error al eliminar el gasto del Cena",2,"");
            }
        } else { // Hospedaje
            if (viaticos_DelGastoHospedaje($IdGasto, $IdViatico, $nitavu) == TRUE){
                Toast("Se elimino correctamente el Hospedaje",0,"");
            } else {
                Toast("Error al eliminar el gasto del Hospedaje",2,"");
            }
        }

    }



}



?>