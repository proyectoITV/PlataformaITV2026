<?php 
//  session_start();

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

    
    $sql = "select * from empleados WHERE nitavu ='" . $txtIdUser . "' and estado=''";
    $rc = $conexion->query($sql);
    if ($conexion->query($sql) == TRUE){
        if ($f = $rc->fetch_array()) {
            if ($f['nip'] == $txtNIP) {
                $IdUser = $f['nitavu'];    // variable de entorno    
                        error_reporting(E_ALL);  
                        // if ($session_auto_start == 0){
                        //     session_name($SesionName);
                            
                        // }
                        
                        
                        // session_regenerate_id();    
                        session_start();
                        $_SESSION['nitavu'] = $f['nitavu']; //session		 
                        $_SESSION['nitavuName'] = $f['nombre']; //session		 
                        // http://localhost/Plataforma%20ITAVU/Desarrollo/reportes/r.php?id=11
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
        }  else {
            Toast("Usuario  Incorrecto", 2, "");
        }
    } else {
        Toast("ERROR", 2, "");
    }




}
?>

</div>
</body>
</html>