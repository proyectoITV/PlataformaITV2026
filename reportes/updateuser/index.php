<?php
require ("../rintera-config.php");
require ("../components.php");


include("../seguridad.php");   
MiToken_CloseALL($nitavu);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizacion de Usuarios desde la Plataforma</title>
    <link rel="stylesheet" href="../src/default.css">

    <!-- JQUERY -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</head>
<body style='
background-color: #0b4059;
color: white;
font-size: 14pt;
'>
    

<div id="PreLoader">
    <div id="Loader">
        <img src="../img/loader_classic.gif"><br>
    </div>
</div>

<div id='Resultado' style='width:100%;padding:20px;'>

</div>

<?php
echo "
<script>
function Update(){
        $('#PreLoader').show();                
        $.ajax({
            url: 'updateuserfromplataforma.php',
            type: 'post',        
            data: {IdUser:'" . $nitavu . "'                
            },
        success: function(data){
            $('#Resultado').html(data);
            $('#PreLoader').hide();
        }
        });
   


        
}
Update();
</script>";
?>

<?php



?>