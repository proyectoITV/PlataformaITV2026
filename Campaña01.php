<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/yes_funciones.php");

$time = time();
$fechaRecibo=date("Y-m-d H:i:s", $time);

$BAplicoCamp = 0;

  //revisa cuanto se descuenta de capital si liquida
  $vNumMov = obtenerMaximoMovCuenta($NumContrato);
  $vUltimo =NumMov($NumContrato);

  $FolioRecibo = IdSiguienteFolioRecibo();

  $TipoPago_1Liq_2Desc_3MensFree=0;
  switch ($TipoPago_1Liq_2Desc_3MensFree) {
     case 0:
           if($Importe >= $MontoSaldarPesos)
           {
            $vMontoDescuentoMora = $DescuentoAutorizado;
            $LugarExpedicion =  $IdDelegacion;
            $IngresoVia = 6
            if($vMontoDescuentoMora > 0)
            {

            }
            else
            {

            }
           }
           break;
     case 1:
          
           break;
     case 2:
           
           break;
  }

   
?>