<?php
require ("config.php");
//require ("lib/funciones.php");
include ("./lib/body_head.php"); include ("./lib/body_menu.php");

if(isset($_POST['idabono']) and isset($_POST['idconcepto']) and isset($_POST['mas_menos'])and isset($_POST['importe'])){
    $idabono = $_POST['idabono'];
    $idconcepto = $_POST['idconcepto'];
    $mas_menos = $_POST['mas_menos'];
    $importe = $_POST['importe'];
    $nitavu = $_POST['nitavu1'];
    $anterior= $_SERVER['HTTP_REFERER'];  
    
    $sql = "INSERT INTO mandantes_abonosext(idabono, idconcepto, mas_menos, importe,nitavu_captura,cancelado)
    VALUES ('$idabono','$idconcepto', '$mas_menos', '$importe','$nitavu',0)";
    echo $sql;
    echo "<script>console.log(".$sql.")</script>";
    if ($conexion->query($sql) == TRUE){
       // echo '<p>Se ha registrado con éxito la información.</p>';
       // historia($nitavu, 'Ingrese un nuevo abono para el abono '.$idabono.', .');
        mensaje('Se ha registrado con éxito la información', $anterior);
    }else{
        echo "<p>Ocurrio un problema, favor de intentarlo de nuevo.</p>";
    }

}


    
?>
