<?php  
//session_start();
require_once ("config.php");
require_once ("preference_config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="4t.ico" />
    <title>Login</title>

	<?php
    include("body_head_libs.php");
    
    ?>
    
    <link rel="stylesheet" href="lib/login.css?d=<?php echo rand(); ?>">
</head>
<body>
<?php
     if (isset($_GET['id_rep'])){
        $id_rep = $_GET['id_rep'];
        echo $id_rep;
    } else {$id_rep = "";}
?>


<audio id="AudioBoop" style="display:none;">
    <source src="audios/boop.mp3">
</audio>

<div id='Logo'>
    <img src="img/logo_white.png" style="width:200px; margin-left:16px;"><br>
    <b style="">Plataforma de Sistemas ITAVU</b><br>



</div>
<?php
if 	($dbhost=="localhost") {
    echo '    
    <div class="alert alert-danger" role="alert">
      La conección a la base de datos de la platafoma (produccion_itavu) esta en localhost
    </div>

    ';
} else {
    
}


if 	($Vdbhost=="localhost") {
    echo '    
    <div class="alert alert-danger" role="alert">
      La conección a la base de datos de vivienda de la platafoma (produccion_vivienda) esta en localhost
    </div>

    ';
} else {
    

}

if ($Pdbhost == "localhost" ){
    echo '    
    <div class="alert alert-danger" role="alert">
      La conección a la base preference en (produccion_itavu) esta en localhost
    </div>

    ';
} else {

}


?>

<div id='InfoLogin' >


    <?php 
    echo "<div class=''>Con esta plataforma hemos ahorrado ".number_format(ceropapel())." hojas. <br>";
    
        echo InfoLogin();
    echo "<span>&#160;</span></div>";
    ?>



</div>

<div id="Login">


<center>
    <h3 id='LogoMovil'>Plataforma ITAVU</h3>
    <b>Login:</b></center>

<!-- <form> -->
    <div class="input-group form-group">
        <div class="input-group-prepend" style="height:30px; margin-bottom: 10px;">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
        </div>
        <input id="NEmpleado" type="text" class="form-control" placeholder="Numero de Empleado" style="height:30px; margin-bottom: 10px;">
        
    </div>
    <div class="input-group form-group">
        <div class="input-group-prepend" style="height:30px; margin-bottom: 10px;">
            <span class="input-group-text"><i class="fas fa-key"></i></span>
        </div>
        <input id="EmpleadoNIP" type="password" class="form-control" placeholder="NIP" style="height:30px; margin-bottom: 10px;">
        
    </div>
    
    <center style='margin-top:10px;'>
        <div id='R_login'></div>
        <div id='Intentos' style='color:orange;'></div>
    
    <buttom id="btnEntrar"  onclick="ValidarAcceso();" class="btn btn-success">
    <b id="btnEntrar_texto" >Entrar</b>
    
    <div id="btnEntrar_loader">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Validando...
    </div>
    </buttom>

    
    
    
    
    
    </center>
    
    <!-- <a class="btn-Link" onclick="RecoveryNIP();" style="cursor:pointer;" title="Haga clic aquí para recuperar su NIP">Olvide mi NIP</a> -->

<!-- </form> -->
</div>


<script>
function Test(){
    $.toast('Hola Mundo');
}
function btnBusy(BusyStatus){
    if (BusyStatus == 0) {
        $('#btnEntrar_texto').show();
        $('#btnEntrar_loader').hide();
    } else {
        $('#btnEntrar_texto').hide();
        $('#btnEntrar_loader').show();
    }
}
btnBusy(0);

function ValidarAcceso(){    
    Usuario = $('#NEmpleado').val();
    NIP = $('#EmpleadoNIP').val();
    btnBusy(1);
    $.ajax({
    url: "login_toctoc.php",
    type: "post",        
    data: {Usuario:Usuario, NIP:NIP},
    success: function(data){             
        $("#R").html(data+"\n");    
        btnBusy(0);
        
    }
    });
}


function RecoveryNIP(){    
    Usuario = $('#NEmpleado').val();
        
    btnBusy(1);
    $.ajax({
    url: "login_recovery.php",
    type: "post",        
    data: {Usuario:Usuario},
    success: function(data){             
        $("#R").html(data+"\n");    
        btnBusy(0);
        
    }
    });
}




// setInterval(RotorWall,3000);


</script>















<div id='R' style='display: none;'></div>
</body>

</html>