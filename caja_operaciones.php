<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/yes_funciones.php");



$Funcion=$_POST['Operacion'];
$NumContrato=$_POST['NumContrato'];
$nitavu=$_POST['nitavu'];
if($Funcion=='Descuento'){
    
    $datosdes = buscaDescuento($NumContrato,$nitavu);
                
    if($datosdes!='FALSE')
    {
        
      $datosdes = explode("_", $datosdes);     
      $montoDesc=$datosdes[0];
      $minimo=$datosdes[1];
      $descipcionMov=$datosdes[2];

       mensaje("El contrato tiene autorizado(a) un(a) :<b>".TipoMovimiento($descipcionMov)."</b>".
      "<br>*La cajera debera introducir : $ " .($montoDesc + $minimo). "<br>* El(la)" .TipoMovimiento($descipcionMov). " será de : $ ".$montoDesc.  "<br>* La persona pagara : $ " . $minimo. " <br>*** En caso de liquidación aún falta restar el descuento de capital.***",$_SERVER["REQUEST_URI"]."&m");
    }
}


    

    
?>