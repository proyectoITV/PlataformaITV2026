<?php
if (session_status() === PHP_SESSION_NONE) {
    @ini_set('session.use_cookies', '1');
    @ini_set('session.use_only_cookies', '1');
    @ini_set('session.use_trans_sid', '0');
    session_start();
    if (!headers_sent() && !isset($_COOKIE[session_name()])) {
        setcookie(session_name(), session_id(), 0, '/');
    }
}
require("config.php");
?>
<?php 	
require("funciones.php");
require_once("password_fun.php");
 ?>
<!DOCTYPE html>
<html>
	<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Tranparencia Go | Login</title>
        <script src="lib/jquery-3.3.1.js"></script> 	
        <link rel="stylesheet" href="estilo.css" />
        <link rel="stylesheet" href="lib/jquery.toast.min.css">
	<script type="text/javascript" src="lib/jquery.toast.min.js"></script>

</head>


<body>
<h1 style='
color: #FFFFFF;

text-shadow: #474747 3px 5px 2px;
'> Identificate </h1>
<p style='
color: #FFFFFF;

text-shadow: #474747 3px 5px 2px;
'>El usuario y NIP, son los mismos que en la Plataforma ITAVU</p>

<form action='login.php' method='POST' >
	<label>Usuario: <input type='text' name='User'></label>
	<label>NIP: <input type='Password' name='Password'></label>
	<label><input type='submit' value='Entrar' class='btn btn-Primary' name='FormLogin'></label>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    require("config.php");
    $IdEmpleado = isset($_POST['User']) ? $_POST['User'] : "";
    if (ValidaVAR($IdEmpleado)==TRUE){$IdEmpleado = LimpiarVAR($IdEmpleado);} else {$IdEmpleado = "";}

    $Password = isset($_POST['Password']) ? $_POST['Password'] : "";
    if (ValidaVAR($Password)==TRUE){$Password = LimpiarVAR($Password);} else {$Password = "";}

	$sql = "select a.*,
    (select count(*) from aplicaciones_permisos where aplicaciones_permisos.nitavu = a.nitavu and aplicaciones_permisos.idapp = 'ap105') as ap105
    from empleados a where nitavu='".$IdEmpleado."' and estado=''";

    $rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{                
        // if ($f['nip']==$txtNIP){

        //     if ($f['ap105']==0){
        //         Toast("No tienes Permiso para Entrar, Solicitalo al Dpto. de Informática",2,"");
        //     } else {

        //         $nitavu = $f['nitavu'];	// variable de entorno      
        //         session_start();    
        //         session_regenerate_id();                
        //         global $nitavu; //generalize       

        //         $_SESSION['nitavu']=$f['nitavu']; //session		

                
        //         historia($nitavu,'Acceso TransparenciaGo'.InfoEquipo().'');			    
        //         SESSION_init(session_id(), $nitavu, session_name(), InfoEquipo(), "");    
        //         echo '<script>window.location.replace("index.php")</script>'; 
        //     }
            

        // } else {
        //     Toast("NIP Incorrecto",2,"");
        // }
    
       
    
        if (PasswordCheck($IdEmpleado, $Password) == TRUE){
            if (!headers_sent()) {
                session_regenerate_id(true);
            }
            $_SESSION['nitavu'] = $IdEmpleado; //session		                     
            $nitavu = $f['nitavu'];

            if ($_SESSION['nitavu'] == $IdEmpleado){
                if (!headers_sent()) {
                    header("Location: index.php");
                    exit;
                }
                LocationFull("index.php");
                exit;
            } else {
                Toast("Hubo un problema",2,"");
                // mensaje("ERROR: Hubo un problema","login.php");    
                
            }
            



        } else {
            
            Problema_create("LOGIN Transparencia", "Intento Fallido de Login de Transparenciacon <b>".$Password."</b>", $IdEmpleado);
            Toast("ERROR: no coincide tu NIP con tu la cuenta   ",2,"");   
            echo "<script>alert('"."ERROR: no coincide tu NIP con tu la cuenta"."');</script>";
            mensaje("ERROR: no coincide tu NIP con tu la cuenta","login.php");                 
        }
        
        
	} else {
        Toast("Usuario No Valido",2,"");
        
	}
}

?>

<div id='Informatica'>
    Cualquier Duda, Comunicate al Departamento de Informatica<br>
    <b>Ext. </b> 46543
</div>

</body>
</html>