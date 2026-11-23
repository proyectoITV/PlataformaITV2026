<?php
ob_start();
require_once("config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<?php
    include("body_head_libs.php");
    
    ?>
    
    <style>
        body {
          
            
            /* background-image: url('img/wall.png'); */
            /* background-size: 200%; */
            background-color: #026da2;
            /* background-blend-mode: screen; */ 

           
            

        }

        #Login,
        #Login2 {
            width: 40%;
            background-color: white;
            position: absolute;
            left: 29%;
            top: 25%;
            padding: 14px;
            border-radius: 10px;

           
        }

        @media only screen and (max-width:600px) {
            #Login {
                width:100%;
                left:0px;
                top:0px;
                border-radius:0px;
                height:100%;
            }
        }
    </style>
</head>
<body>
<?php
     if (isset($_GET['id_rep'])){
        $id_rep = $_GET['id_rep'];
        echo $id_rep;
    } else {$id_rep = "";}
?>
<div id="Login">
<form class="form-signin" style="text-align:center;" method="POST" action="">

    <h5>Plataforma ITAVU | Login:</h5>
    <label for="txtIdUser" class="sr-only">IdUser </label>
    <input type="text" id="txtIdUser" name="txtIdUser" class="form-control" placeholder="IdUser" value="" required >
    <label for="txtNIP" class="sr-only">Password</label><br>
    <input type="password" id="txtNIP" name="txtNIP" class="form-control" placeholder="NIP (Contraseña)" required>
    <br>
    <input name="FormLogin" type="submit" class="btn btn-lg btn-primary btn-block" Value="Entrar">
    <br><br>
</form>

<?php
if (isset($_POST['FormLogin'])){
    error_reporting(E_ALL);
    $txtIdUser = VarClean($_POST['txtIdUser']);
    $txtNIP = VarClean($_POST['txtNIP']);

    if (isset($EXIGIR_geo_ini) && $EXIGIR_geo_ini === TRUE) {
        echo '<div class="alert alert-danger" style="margin-top:10px;">Por seguridad debes ingresar desde <a href="login.php"><b>login.php</b></a> con verificación CAPTCHA y ubicación GPS obligatoria.</div>';
    } elseif (function_exists('itavu_en_horario_acceso') && !itavu_en_horario_acceso($txtIdUser)) {
        echo '<div class="alert alert-warning" style="margin-top:10px;">El acceso a la plataforma solo está disponible de 7:00 AM a 7:00 PM.</div>';
    } else {
    $stmtLogin2 = $conexion->prepare("SELECT nitavu, nombre, nip, estado FROM empleados WHERE nitavu = ? LIMIT 1");
    if ($stmtLogin2) {
        $stmtLogin2->bind_param("s", $txtIdUser);
        $stmtLogin2->execute();
        $rc = $stmtLogin2->get_result();
        if ($f = $rc->fetch_assoc()) {
            $estadoEmp = trim((string)($f['estado'] ?? ''));
            if (strcasecmp($estadoEmp, 'Baja permanente') === 0 || $estadoEmp !== '') {
                echo '<div class="alert alert-danger" style="margin-top:10px;">Acceso denegado: la cuenta no se encuentra activa.</div>';
            } elseif (hash_equals((string)$f['nip'], (string)$txtNIP)) {
                $IdUser = $f['nitavu'];    // variable de entorno    
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }
                        if (!headers_sent()) {
                            session_regenerate_id(true);
                        }
                        $_SESSION['nitavu'] = $f['nitavu']; //session		 
                        $_SESSION['nitavuName'] = $f['nombre']; //session		 
                        $_SESSION['ultima_actividad'] = time();
                        if (function_exists('itavu_sesion_registrar')) {
                            itavu_sesion_registrar($conexion, $f['nitavu']);
                        }
                        $nitavu = $f['nitavu'];

                        echo  $_SESSION['nitavu'];
                        if ($id_rep <> ''){
                            echo '<script>window.location.replace("reportes/r.php?id='.$id_rep.'")</script>'; 
                        } else {
                            echo '<script>window.location.replace("index.php?home=")</script>'; 
                        }


            } else {
                Toast("NIP incorrecto", 2, "");
            }
        } else {
            Toast("Usuario  Incorrecto", 2, "");
        }
        $stmtLogin2->close();
    } else {
        Toast("ERROR", 2, "");
    }
    }
}
?>

</div>
</body>
</html>