<?php

require("rintera-config.php");
require("components.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login by Rintera</title>


    <script src="lib/jquery-3.3.1.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">


    <?php
    $dir = "";
    echo '
             

        <script src="lib/jquery-3.3.1.js"></script> 
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">

        <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="lib/jquery.toast.min.css">
        <script type="text/javascript" src="lib/jquery.toast.min.js"></script>
        <link rel="stylesheet" type="text/css" href="lib/datatables.min.css"/> 
        <script type="text/javascript" src="lib/datatables.min.js"></script>
        <script src="lib/jquery.modalpdz.js"></script> 
        <link rel="stylesheet" href="lib/jquery.modalcsspdz.css" />
        <link rel="stylesheet" href="src/default.css" />
    ';


    ?>

    <style>
        body {
            background-image: url('img/fondo3.jpg');
            background-size: 200%;
            /* background-color: #919191;
            background-blend-mode: screen; */

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

            -webkit-box-shadow: 1px 7px 13px 1px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 1px 7px 13px 1px rgba(0, 0, 0, 0.75);
            box-shadow: 1px 7px 13px 1px rgba(0, 0, 0, 0.75);
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
    
    //Variables de entrada
    if (isset($_GET['IdUser'])){
        $IdUser = VarClean($_GET['IdUser']);
    } else {$IdUser = "";}
    if (isset($_GET['id_rep'])){
        $id_rep = VarClean($_GET['id_rep']);
    } else {$id_rep = "";}

    if ($Error == ''){
        if ($IdUser <> ''){
            echo '
                <div id="Login">

                <form class="form-signin" style="text-align:center;" method="POST" action="">

                    <h5>Procimart '.UserName($IdUser).'</h5>
                    <label for="txtIdUser" class="sr-only">IdUser </label>
                    <input type="text" id="txtIdUser" name="txtIdUser" class="form-control" placeholder="IdUser" value="'.$IdUser.'" required >
                    <label for="txtNIP" class="sr-only">Password</label><br>
                    <input type="password" id="txtNIP" name="txtNIP" class="form-control" placeholder="Password" required>
                    <br>
                    <input name="FormLogin" type="submit" class="btn btn-lg btn-primary btn-block" Value="Entrar">
                    <br><br>
                </form>

            </div>';
            

        } else {
            echo '
            <div id="Login">
    
    
            <form class="form-signin" style="text-align:center;" method="POST" action="">
    
                <img src="img/Logo_large.png" style="width:50%;"><br>
                
                <b><b>Identificate</b>
                
                <label for="txtIdUser" class="sr-only">IdUser</label>
                <input type="text" id="txtIdUser" name="txtIdUser" class="form-control" placeholder="IdUser" required autofocus>
                <label for="txtNIP" class="sr-only">Password</label><br>
                <input type="password" id="txtNIP" name="txtNIP" class="form-control" placeholder="Password" required>
                <br>
                <input name="FormLogin" type="submit" class="btn btn-lg btn-primary btn-block" Value="Entrar">
                <br><br>
            </form>
    
            </div>';
        }
    }
    
    

    ?>
    <?php


    if (isset($_POST['FormLogin'])) {
        error_reporting(E_ALL);
        $txtIdUser = VarClean($_POST['txtIdUser']);
        $txtNIP = VarClean($_POST['txtNIP']);

        //Prearamos el Query
       
            $sql = "select * from users WHERE IdUser ='" . $txtIdUser . "'";
       
        // echo $sql;
        // var_dump($sql);
        $rc = $dbUser->query($sql);
        
        // echo $sql;
        if ($dbUser->query($sql) == TRUE){
            // echo "OK";
        
                if ($f = $rc->fetch_array()) {
                    // var_dump($f);

                    if ($f['NIP'] == $txtNIP) {

                        $IdUser = $f['IdUser'];    // variable de entorno    
                        // echo "OK";
                            
                        error_reporting(E_ALL);  
                        // ob_end_clean();  
                        // var_dump($session_auto_start);
                        if ($session_auto_start == 0){
                            session_name($SesionName);
                            session_start();
                        }
                        
                        
                        session_regenerate_id();    
                        // echo "Id: ".session_id();            

                        // $cookieParams = session_get_cookie_params();
                        // $cookieParams['samesite'] = "Lax";
                        // session_set_cookie_params($cookieParams);
                        
                        $_SESSION['nitavu'] = $f['IdUser']; //session		
                        $_SESSION['nitavuName'] = $f['UserName']; //session		
                        $nitavu = $f['IdUser'];
                        // global $nitavu; //generalize     
                        
                        // echo "Sesion=".$_SESSION['nitavu']." username=".$_SESSION['nitavuName'];

                        // historia_rintera($nitavu, 'RinteraLogin', 'Acceso Rintera' . InfoEquipo() . '');
                        // SESSION_init(session_id(), $nitavu, $SesionName, InfoEquipo(), "");



                        if ($id_rep <> ''){
                            echo '<script>window.location.replace("r.php?id='.$id_rep.'")</script>'; 
                        } else {
                            echo '<script>window.location.replace("index.php?home=")</script>'; 
                        }

                        

                    } else {
                        Toast("Password  Incorrecto", 2, "");
                    }
                } else {
                    Toast("Usuario  Incorrecto", 2, "");
                }
            } else {
                Error("Error al obtener la consulta de los usuarios");
            }
        }
       

    ?>



    <?php
    echo '

<script src="lib/popper.min.js"></script>
<script src="lib/jquery-3.5.1.slim.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>';

    ?>



<?php

?>
</body>

</html>