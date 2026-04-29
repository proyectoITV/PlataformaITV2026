

<?php

$montoconvenio = $_POST['montofinanciar'];
$montopago = $_POST['montopago'];
$tasafin = $_POST['tasafin'];
$totpagos = $_POST['totalpagos'];

var_dump($montoconvenio);
var_dump($montopago);
var_dump($tasafin);
var_dump($totpagos);
//print_r($montoconvenio);
//mensaje('Recibi'.$montoconvenio); 
$band='entre';
corridaPorMontoMensual($montoconvenio, $montopago,$tasafin,$totpagos);
//require_once("config.php");
//require_once("lib/funciones.php");

function corridaPorMontoMensual($montoconvenio, $montopago,$tasafin,$totpagos){
	//require("config.php");
    //var_dump($band);
    //function determinaCorrida($montoconvenio, $totpagos, $tasafin){
        
    
        //if ($montoconvenio>0 and $totpagos>0){
        if ($montoconvenio>0 ){    
             $ultimosaldo=0;
             $saldopago=0;
             $pago=0;
             $minimo=0;
             $limite=0;
             $montopago=0;
             $nuevodoc=0;
    
            $limite=120;
    
            if ($totpagos>$limite){
                $totpagos=120;
            }else{
                $limite=$totpagos;
            }
    

            /**aqui division por cero para cal totpagos*/
            if($tasafin==0){
                $minimo=$montoconvenio/$limite;
                $minimo=intval($minimo +(   intval($minimo)    /$minimo));  
            }else{
                $minimo=( ($montoconvenio * $tasafin) /1200)/(1-(1+($tasafin/1200))**(-$limite));
                $minimo=intval($minimo +(   intval($minimo)    /$minimo));           
            }
    
            if($montopago<$minimo){
                $montopago=$minimo;          
            }
    
            if ($montopago>$montoconvenio){
                $montopago=$montoconvenio;
                $montoultimopago=0;
                $totalpagos=1;    
                exit;
            }
    
            $montopago=$minimo;        
       
            if($tasafin==0){
                //$totpagos=intval($tasafin/$montopago);
                //if (($nuevodoc*$montopago)<$montoconvenio){
                if (($totpagos*$montopago)<$montoconvenio){    
                    $totpagos=$totpagos+1;
                }
            }else{
                $totpagos=intval(Nper($tasafin, $montopago,$montoconvenio))+1;
            }
    
            $ultimosaldo=$montoconvenio;
            for ($i=1; $i<$totpagos ; $i++){
                if ($tasafin==0){
                    $saldopago=$montopago;
                }else{
                    $saldopago=($montopago)-(($ultimosaldo*$tasafin)/1200);
                }
                $ultimosaldo=$ultimosaldo-$saldopago;
            }
    
            if($tasafin==0){
                $montoultimopago=number_format($ultimosaldo, 2, '.', '');
            }else{
                $montoultimopago=$ultimosaldo+($ultimosaldo*($tasafin/1200));
                $montoultimopago=number_format($montoultimopago, 2, '.', '');
                
                
            }
            //$totpagos=$saldopago;
            //$minimo=$ultimosaldo;
            $montopago=number_format($montopago, 2, '.', '');
           // mensaje('Rmontopago'.$montopago); 
           
    
            return array($montopago,$montoultimopago,$minimo,$totpagos);
            echo (array($montopago,$montoultimopago,$minimo,$totpagos));
        } ;     
    
    
    };
    
    function Nper($interest, $payment, $loan){
        $interest = $interest / 1200;
        $nperC = Log10 ($payment/ ($payment- $loan * $interest)) / Log10(1 + $interest);
    
        return $nperC;
    }
?>