<?php
require("config.php");
// require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("vehiculos_fun.php");
require_once("lib/password_fun.php");

$IdEmpleado = VarClean($_POST['Usuario']);
//$Password = VarClean($_POST['NIP']);
$msg = "";
if ($IdEmpleado == ""){
    $msg.="Escribe el Numero de Empleado";
    Toast("Escribe el Numero de Empleado", 2,"");
    echo "<script>$('#NEmpleado').css('border-color','orange');</script>";
} else {
    echo "<script>$('#NEmpleado').css('border-color','white');</script>";
}

if (nitavu_valida($IdEmpleado) == TRUE){
    $Correo = CorreoForce($IdEmpleado);
    $NipNuevo = GenerateToken(4);
    if (PasswordHash_create($IdEmpleado, $NipNuevo)== TRUE){
        Toast("NIP Generado con exito",4);
        historia($IdEmpleado,"actualizo su NIP");
        $Asunto = "Recuperacion de NIP de la Plataforma";
        $Contenido = "
        <h1>La Recuperación de tu NIP ha sido existosa:</h1>
        <p>
            No. de Empleado: <b>".$IdEmpleado."</b><br>
            Empleado: <b>".nitavu_nombre($IdEmpleado)."</b><br>        
            NIP nuevo: <b>".$NipNuevo."</b><br>                

            <br>Puedes cambiar tu NIP, en cualquier momento desde la app NIP, en la plataforma<br>
            <br><br>
            
        <p>* Recuerda no proporcionarle este NIP a nadie, ya que eres responsable de las acciones realizadas en los sistemas con tu usuario y NIP.</p>
        ";
        $CorreoDestino = $Correo;
        $DestinoName = nitavu_nombre($IdEmpleado);
        if (EnviarCorreo($Asunto, $Contenido, $CorreoDestino, $DestinoName) == TRUE){
            Toast("Se ha enviado a tu  correo ".$CorreoDestino." la información de tu nuevo Nip ",5);
        } else {
            Toast("ERROR al enviar un corre a ".$CorreoDestino." con el envio del nuevo NIP",2);
        }


    } else {
        Toast("Error al Generar NIP de ".$IdEmpleado,2);
    }

           

} else {
    Toast("LoginRecovery: No. de empleado ".$IdEmpleado." no valido",2);
}

?>
