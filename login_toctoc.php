<?php
require("config.php");
// require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
//require("vehiculos_fun.php");
//require_once("lib/password_fun.php");

$IdEmpleado = VarClean($_POST['Usuario']);
$Password = VarClean($_POST['NIP']);
$msg = "";
if ($IdEmpleado == ""){
    $msg.="Escribe el Numero de Empleado";
    Toast("Escribe el Numero de Empleado", 2,"");
    echo "<script>$('#NEmpleado').css('border-color','orange');</script>";
} else {
    echo "<script>$('#NEmpleado').css('border-color','white');</script>";
}

if ($Password == ""){
    $msg.=", Escribe un NIP";
    Toast("Escribe un NIP", 2,"");
    echo "<script>$('#EmpleadoNIP').css('border-color','orange');</script>";
} else {
    echo "<script>$('#EmpleadoNIP').css('border-color','white');</script>";
}



$LimiteDeIntentos=8;
$AlertaDeIntentos = 3;

// Toast("IdEmpleado = ".$IdEmpleado,5,"");
// Toast("Password = ".$Password,5,"");

if ($msg ==""){
    
    
    if (bloqueomaestro($IdEmpleado)==TRUE){
        echo "<script>$('#Intentos').html('<b style=color:red>Cuenta Bloqueada</b>')</script>";
        // Toast("Favor de Comunicarse con el Dpto. de Informática",5,"");
    } else {
            $Intentos =  problemas($IdEmpleado, "LOGIN") + 1; //Intentos Fallidos de Hoy
            if ($Intentos <= $LimiteDeIntentos){
                if (PasswordNIP_verify($IdEmpleado, $Password) == TRUE){
                    Toast("Acceso concedido",4,"");
                    session_start();
                    $_SESSION['nitavu'] = $IdEmpleado; //session		                     
                    $nitavu = $f['nitavu'];

                    if ($_SESSION['nitavu'] == $IdEmpleado){
                        LocationFull("index.php");
                    } else {
                        echo "<script>$('#R_login').html('Hubo un Problema');</script>";
                        // Toast("Hubo un problema",2,"");
                        mensaje("ERROR: Hubo un problema","login.php");    
                        Alert("ERROR: Hubo un problema");
                    }
                    



                } else {
                    echo "<script>$('#R_login').html('Contraseña incorrecta');</script>";
                    Problema_create("LOGIN", "Intento Fallido de Login con <b>".$Password."</b>", $IdEmpleado);
                    // Toast("ERROR: no coincide tu NIP con tu cuenta   ",2,"");   
                    // echo "<script>alert('"."ERROR: no coincide tu NIP con tu la cuenta"."');</script>";
                    // mensaje("ERROR: no coincide tu NIP con tu la cuenta","login.php");                 
                }
                if ($Intentos > $AlertaDeIntentos ){
                    echo "<script>$('#Intentos').html('<p style=font-size:9pt><b>CUIDADO</b> Tu cuenta se bloqueara a los ".$LimiteDeIntentos." intentos fallidos. </p>Llevas ".$Intentos." Intentos fallidos');</script>";
                } else {
                    // echo "<script>$('#Intentos').html('".$Intentos." Intentos fallidos');</script>";
                }
                
                unset($IdEmpleado, $Password);
            } else {
                
                    echo "<script>$('#R_login').html('Tu cuenta esta bloqueada');</script>";                
                    // Toast("Tu cuenta ha sido bloqueada por seguridad",2,"");    

                    Alert("Tu cuenta ha sido bloqueada por seguridad");
                    Toast("Comunicate al Dpto. de Informatica para solicitar el desbloqueo",5,"");
                    echo "<script>$('#Intentos').html('<b style=color:red>Cuenta Bloqueada</b>.<br>".$Intentos." Intentos fallidos');</script>";
                

                
                
            }
        }
}





?>

