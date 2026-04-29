<?php
// require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
// require_once("lib/flor_funciones.php");
// require("lib/curp_fun.php");
require("var_clean.php");
$id_aplicacion ="v002";
// error_reporting(0); //<-- para simular produccion

$OriginData = VarClean($_POST['OriginData']);
$NumContrato = VarClean($_POST['_NumContrato']);
$VoBo = VarClean($_POST['VoBo']);
$nitavu = VarClean($_POST['nitavu']);
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
// sleep(10);
// echo ProblemaName($IdProblema);
$ElVoBo = NumContrato_Vobo($NumContrato, $OriginData);
sleep(2);
if ($nivel==2){
    $sql = "UPDATE contratos SET VoBo_public ='".$VoBo."', VoBo='".$nitavu."', VoBo_fecha='".$fecha."'";	
	if ($Vivienda->query($sql) == TRUE){   
        if ($VoBo==1){
            historia($nitavu,"Le dio VoBo al contrato ".$NumContrato." OriginData=".$OriginData." como correcto. Estando ".$ElVoBo);                	
        } else {
            historia($nitavu,"Le quito el VoBo al contrato ".$NumContrato." OriginData=".$OriginData.", marcandolo como incorrecto. Estando ".$ElVoBo);                	
        }
        
		Toast("Estatus VoBo actualizado correctamente",4,"");
	} else {
		Toast("Error al actualizar el VoBo",2,"");
	}
}
?>

