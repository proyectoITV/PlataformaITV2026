<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/curp_fun.php");


$CurpSeleccionado = VCurps_get();
echo "Curp seleccionado: ".$CurpSeleccionado;
if ($CurpSeleccionado == ""){
    
    $CorreoDestino = $CorreoDeLaPlataforma;
    $Contenido = "Ya no hay CurpSeleccionados para la consulta".$CurpSeleccionado;
    // ($Asunto, $Contenido, $CorreoDestino, $DestinoName="Plataforma ITAVU", $ResponderCorreo = "", $Responder = "", $nitavu='')
    if (EnviarCorreo("Alerta Fin de Consulta Curp", $Contenido, $CorreoDestino, "Alerta de CURP ","","",$nitavu) == TRUE){
        Toast("Se ha enviado un corre a ".$CorreoDestino." Finalizo las Consultas de CURP",2,"");
    } else {
        Toast("ERROR al enviar un corre a ".$CorreoDestino." con Alerta de Limite de Curp",2,"");
    }
    LocationFull("index.php");
    

} else {
    $ResultadoDelCURP = CURP($CurpSeleccionado, $nitavu); 
    // var_dump($ResultadoDelCURP);

        
        // if (VCurps_savedata($Curp, $Data, $Status, $CurpNombre, $CurpFechaNacimiento)==TRUE){

        // } else {

        // }

    $c = 1;
    $exito = FALSE;
    $CurpJson = json_decode($ResultadoDelCURP, true);
    echo "Curp Exito: ".$CurpJson['exito'];
    if ($CurpJson['exito']== 1 ){
        echo "Entra al Exito";       
        foreach ($CurpJson as $value) {       
            $Nombre = "".$value['nombres']." ".$value['apellido1']." ".$value['apellido2'];
            $CurpFechaNacimiento = $value['fechNac'];
            $CurpStatus = $value['statusCurp'];
        }

        if (VCurps_savedata($CurpSeleccionado, $ResultadoDelCURP, $CurpStatus,$Nombre, $CurpFechaNacimiento)==TRUE){
            Toast("Se ha verificado el curp ".$CurpSeleccionado,4,"");
        } else {
            Toast("[_curp] Ha habido un Error al Guardar la verificacion del Curp ".$CurpSeleccionado,2);
        }
    } else {
        echo "Error: ".$ResultadoDelCURP."<br>";
        if (VCurps_savedata($CurpSeleccionado, $ResultadoDelCURP, "ERROR","", "")==TRUE){
            Toast("Se ha verificado el curp ".$CurpSeleccionado,4,"");
        } else {
            Toast("Ha habido un Error al Guardar la verificacion del Curp ".$CurpSeleccionado,2);
        }
        
    }

    // $array = json_decode($ResultadoDelCURP, true);
    // if(is_array($array)){    
    //         foreach ($array as $value) {
                
    //             if ($c==1){
    //                 if ($value['exito']==true){
    //                     $exito = TRUE;
    //                     echo "exitOK;";

    //                 } else {
    //                     echo "Error: ".$ResultadoDelCURP."<br>";
    //                     // if (VCurps_savedata($CurpSeleccionado, $ResultadoDelCURP, "ERROR","", "")==TRUE){
    //                     //     Toast("Se ha verificado el curp ".$CurpSeleccionado,4,"");
    //                     // } else {
    //                     //     Toast("Ha habido un Error al Guardar la verificacion del Curp ".$CurpSeleccionado,2);
    //                     // }

                        
    //                 }
    //             } else {
    //                 if ($exito == TRUE){     
    //                     echo "Entra al Exito";              
    //                     $Nombre = "".$value['nombres']." ".$value['apellido1']." ".$value['apellido2'];
                    
    //                     // if (VCurps_savedata($CurpSeleccionado, $ResultadoDelCURP, $value['statusCurp'],$Nombre, $value['fechNac'])==TRUE){
    //                     //     Toast("Se ha verificado el curp ".$CurpSeleccionado,4,"");
    //                     // } else {
    //                     //     Toast("[_curp] Ha habido un Error al Guardar la verificacion del Curp ".$CurpSeleccionado,2);
    //                     // }
    //                 }
                
    //             }   

    //         $c= $c +1;    
    //     }

    // } else {
    //     Toast("[_curp] Ha habido un Error al Consultar la verificacion del Curp ".$CurpSeleccionado,2);
    // }

        sleep(rand(1,3));



    echo "<script>Reload();</script>";
}
?>
 