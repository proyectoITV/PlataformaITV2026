<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");

$IdEmpleado = VarClean($_POST['IdEmpleado']);
//$NIPNuevo = GenerateToken(6);
$NIPNuevo = $IdEmpleado;
if (PasswordHash_create($NIPNuevo, $NIPNuevo)==TRUE){
            Toast("NIP reseteado correctamente",4,"");
            historia($nitavu,"Reseteo el NIP de ".$IdEmpleado." quedo el Nuevo NIP: ".$NIPNuevo);
            
            $Correo = CorreoForce($IdEmpleado);
            $Asunto = "Actualizaste tu NIP en la Plataforma ITAVU";
            $Contenido = "
            <p>Buen dia ".nitavu_nombre($IdEmpleado)."</b><br>
            <p> Se ha cambiado con éxito tu NIP en la Plataforma de Informatica de ITAVU</p>
            <p>Nuevo NIP: ".$NIPNuevo."</p>

            <p>Recuerda no proporcionarle este NIP a nadie, ya que eres responsable de las acciones realizadas en los sistemas con tu usuario y NIP.</p>
            ";
            $CorreoDestino = $Correo;
            $DestinoName = nitavu_nombre($IdEmpleado);
            if (EnviarCorreo($Asunto, $Contenido, $CorreoDestino, $DestinoName,"","",$nitavu) == TRUE){
                Toast("Se ha enviado un correo a ".$CorreoDestino." con la confirmacion de este cambio",5,"");
            } else {
                Toast("ERROR al enviar un corre a ".$CorreoDestino." con la confirmacion de cambio de NIP",2,"");
            }



            $Correo = $CorreoDeLaPlataforma;
            $Asunto = "Actualizaste tu NIP en la Plataforma ITAVU";
            $Contenido = "
            <p>Buen dia ".nitavu_nombre($IdEmpleado)."</b><br>
            <p> Se ha cambiado con éxito tu NIP en la Plataforma de Informatica de ITAVU</p>
            <p>Nuevo NIP: ".$NIPNuevo."</p>

            <p>Recuerda no proporcionarle este NIP a nadie, ya que eres responsable de las acciones realizadas en los sistemas con tu usuario y NIP.</p>
            ";
            $CorreoDestino = $Correo;
            $DestinoName = nitavu_nombre($IdEmpleado);
            if (EnviarCorreo($Asunto, $Contenido, $CorreoDestino, $DestinoName,"","",$nitavu) == TRUE){
                Toast("Se ha enviado un correo a ".$CorreoDestino." con la confirmacion de este cambio",5,"");
            } else {
                Toast("ERROR al enviar un corre a ".$CorreoDestino." con la confirmacion de cambio de NIP",2,"");
            }
} else {
    Toast("Error, Hubo un problema al actualizar el NIP",2,"");
}

?>