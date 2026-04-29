<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");

$NipActual = VarClean($_POST['NipActual']);
$NipNuevo1 = Varclean($_POST['NipNuevo1']);
$NipNuevo2 = Varclean($_POST['NipNuevo2']);

//Validaciones:
// 1 Validar NIP actual
if ( PasswordCheck($nitavu, $NipActual) == TRUE){

    // 2 Comparar NipNuevo1 y 2
    if ($NipNuevo1 == $NipNuevo2){
        // 3 Actualizar NIp con hash
        if (PasswordHash_create($nitavu, $NipNuevo1)==TRUE){
            Toast("NIP actualziado correctamente",4,"");
            mensaje("NIP actualziado correctamente", 'nip_update_dat_save.php');
            $Correo = CorreoForce($nitavu);
            $Asunto = "Actualizaste tu NIP en la Plataforma ITAVU";
            $Contenido = "
            <p>Buen dia ".nitavu_nombre($nitavu)."</b><br>
            <p> Se ha cambiado con éxito tu NIP en la Plataforma de Informatica de ITAVU</p>
            <p>Nuevo NIP: ".$NipNuevo1."</p>

            <p>Recuerda no proporcionarle este NIP a nadie, ya que eres responsable de las acciones realizadas en los sistemas con tu usuario y NIP.</p>
            ";
            $CorreoDestino = $Correo;
            $DestinoName = nitavu_nombre($nitavu);
            if (EnviarCorreo($Asunto, $Contenido, $CorreoDestino, $DestinoName,"","",$nitavu) == TRUE){
                Toast("Se ha enviado un correo a ".$CorreoDestino." con la confirmacion de este cambio",5,"");
            } else {
                Toast("ERROR al enviar un corre a ".$CorreoDestino." con la confirmacion de cambio de NIP",2,"");
            }
        } else {
            Toast("Error, Hubo un problema al actualizar el NIP",2,"");
        }

    }else {
        Toast("Error: el NipNuevo no corresponde en repeticion de confiramción",2,"");
    }
} else {
    Toast("Error, el NIP no corresponde al NIP en la plataforma",2,"");
}






// Enviarle correo electronico de Confiramcion

?>