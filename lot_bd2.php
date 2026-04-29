<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/yes_funciones.php");


$IdLote = $_POST['Idlote'];       
$Campo=$_POST['Campo'];
$Funcion=$_POST['Funcion'];
;
if($Funcion=='Plantilla' || $Campo=="DescriDescripcionPlantillapcionPlantilla" ){
    echo DescripcionPlantillaContrato($IdLote);
}
else if($Funcion=='Lote'){
    echo ValidarLoteCompleto($IdLote);
}
else{
    echo ValidarDatoActualLote($IdLote,$Campo);

}


    
?>