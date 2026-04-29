<?php


//limpiar variables

function VarClean($var){    
    if (ValidaVAR($var)==TRUE){
        $var = LimpiarVAR($var);
        return $var;
    } else {
        return "";
    }

}


?>