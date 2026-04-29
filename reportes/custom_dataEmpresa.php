<?php
require ("rintera-config.php");
require ("components.php");
include("seguridad.php");   
// echo "=>". $_POST['Token']."|";


$ElToken = VarClean($_POST['Token']);
$IdUser = VarClean($_POST['IdUser']);

if (isset($_POST['RinteraName'])){$RinteraName = VarClean($_POST['RinteraName']);} else {$RinteraName="";}
if (isset($_POST['RinteraDescription'])){$RinteraDescription = VarClean($_POST['RinteraDescription']);} else {$RinteraDescription="";}



if (MiToken_valida($ElToken, $IdUser, "custom")==TRUE) { //Token Valido
    $Save = "";

    $Preference = "RinteraName"; $Value = $RinteraName; $GroupA = ""; $GroupB="";
    if (PreferenceEdit($Preference, $GroupA, $GroupB, $Value) == TRUE) { } else {
        $Save =  $Save. "No se guardo ".$Preference." el valor ".$Value.". <br>";
    }

    $Preference = "RinteraDescription"; $Value = $RinteraDescription; $GroupA = ""; $GroupB="";
    if (PreferenceEdit($Preference, $GroupA, $GroupB, $Value) == TRUE) { } else {
        $Save = $Save. "No se guardo ".$Preference." el valor ".$Value.". <br>";
    }

    
    // echo $NFile;
    if ( 0 < $_FILES['archivo']['error'] ) {
        echo 'Error: ' . $_FILES['archivo']['error'] . '<br>';
    }
    else {

        $ExtensionFile = strtolower(end(explode(".", $_FILES['archivo']['name'])));
        echo $ExtensionFile;
        
        // if ($ExtensionFile == 'png' || $ExtensionFile == 'jpg') {
        if ($ExtensionFile == 'png' ) {
            echo '<script>$("#ImgEmpresa").attr("src","img/loader.gif");</script>';
            // if ($ExtensionFile == 'png') {
                move_uploaded_file($_FILES['archivo']['tmp_name'], "img/Logo.png");
                //Actualizamos PNG
                $Preference = "LogoImagePNG"; $Value = "TRUE"; $GroupA = ""; $GroupB="";
                PreferenceEdit($Preference, $GroupA, $GroupB, $Value);
                echo '<script>$("#ImgEmpresa").attr("src","img/Logo.png");</script>';
            // } else {
            //     move_uploaded_file($_FILES['archivo']['tmp_name'], "img/Logo.jpg");
            //     $Preference = "LogoImagePNG"; $Value = "FALSE"; $GroupA = ""; $GroupB="";
            //     PreferenceEdit($Preference, $GroupA, $GroupB, $Value);
            //     echo '<script>$("#ImgEmpresa").attr("src","img/Logo.jpg");</script>';
            // }
        } else {
            $Save = $Save."Tipo de Archivo no Valido.<br>";
        }


    }


    if ($Save == ''){ //Se Guardo Correctamente
        Toast("Se ha guardo correctamente",1,"");
    } else {
        Toast("ERROR: ".$Save,2,"");
    }


} else {
    echo "Token Invalido";
}
