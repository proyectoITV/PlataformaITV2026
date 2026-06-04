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
    // 1) Revisar bloqueo maestro sin re-incluir config en funciones auxiliares.
    $cuentaBloqueada = FALSE;
    $stmtBloqueo = $conexion->prepare("SELECT status FROM bloqueomaestro WHERE Nitavu = ? LIMIT 1");
    if ($stmtBloqueo) {
        $stmtBloqueo->bind_param("s", $IdEmpleado);
        if ($stmtBloqueo->execute()) {
            $resBloqueo = $stmtBloqueo->get_result();
            if ($rowBloqueo = $resBloqueo->fetch_assoc()) {
                $cuentaBloqueada = ($rowBloqueo['status'] != '0');
            }
        }
        $stmtBloqueo->close();
    }

    if ($cuentaBloqueada == TRUE){
        echo "<script>$('#Intentos').html('<b style=color:red>Cuenta Bloqueada</b>')</script>";
        // Toast("Favor de Comunicarse con el Dpto. de Informática",5,"");
    } else {
            // 2) Contar intentos fallidos de hoy (tag LOGIN, status abierto).
            $Intentos = 1;
            $stmtIntentos = $conexion->prepare("SELECT COUNT(*) AS n FROM problemas WHERE IdEmpleado = ? AND TAG = 'LOGIN' AND fecha = ? AND status = '0'");
            if ($stmtIntentos) {
                $stmtIntentos->bind_param("ss", $IdEmpleado, $fecha);
                if ($stmtIntentos->execute()) {
                    $resIntentos = $stmtIntentos->get_result();
                    if ($rowIntentos = $resIntentos->fetch_assoc()) {
                        $Intentos = ((int)$rowIntentos['n']) + 1;
                    }
                }
                $stmtIntentos->close();
            }

            if ($Intentos <= $LimiteDeIntentos){
                // 3) Validar NIP directamente contra empleados.
                $NIPValido = FALSE;
                $stmtNip = $conexion->prepare("SELECT nip FROM empleados WHERE nitavu = ? AND estado = '' LIMIT 1");
                if ($stmtNip) {
                    $stmtNip->bind_param("s", $IdEmpleado);
                    if ($stmtNip->execute()) {
                        $resNip = $stmtNip->get_result();
                        if ($rowNip = $resNip->fetch_assoc()) {
                            $NIPValido = ((string)$rowNip['nip'] === (string)$Password);
                        }
                    }
                    $stmtNip->close();
                }

                if ($NIPValido == TRUE){
                    Toast("Acceso concedido",4,"");
                    session_start();
                    $_SESSION['nitavu'] = $IdEmpleado; //session

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

