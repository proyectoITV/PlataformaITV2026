<?php
require_once("config.php");
require_once("lib/funciones.php");



error_reporting(0); //<-- para simular produccion
// $q = $_POST['q']; if (ValidaVAR($q)==TRUE){$q = LimpiarVAR($q);} else {$q = "";}
//var_dump($_POST);
$Programa = filter_var($_POST['Programa'],FILTER_SANITIZE_STRING); 
$ProgramaGral = filter_var($_POST['ProgramaGral'],FILTER_SANITIZE_STRING); 
 $IdPrograma = $_POST['IdPrograma']; if (ValidaVAR($IdPrograma)==TRUE){$IdPrograma = LimpiarVAR($IdPrograma);} else {$IdPrograma = "";}
 //echo "el id es ".$idprograma."este";
$Ejercicio = $_POST['Ejercicio']; if (ValidaVAR($Ejercicio)==TRUE){$Ejercicio = LimpiarVAR($Ejercicio);} else {$Ejercicio = "";}
$IdTipoPrograma = $_POST['IdTipoPrograma']; if (ValidaVAR($IdTipoPrograma)==TRUE){$IdTipoPrograma = LimpiarVAR($IdTipoPrograma);} else {$IdTipoPrograma = "";}
$Descripcion = $_POST['Descripcion']; if (ValidaVAR($Descripcion)==TRUE){$Descripcion = LimpiarVAR($Descripcion);} else {$Descripcion = "";}
//echo $Descripcion;
$DiasdePago = $_POST['DiasdePago']; if (ValidaVAR($DiasdePago)==TRUE){$DiasdePago = LimpiarVAR($DiasdePago);} else {$DiasdePago = "";}
$Subsidiado = $_POST['Subsidiado']; if (ValidaVAR($Subsidiado)==TRUE){$Subsidiado = LimpiarVAR($Subsidiado);} else {$Subsidiado = "";}
$TipoImpVale = $_POST['TipoImpVale']; if (ValidaVAR($TipoImpVale)==TRUE){$TipoImpVale = LimpiarVAR($TipoImpVale);} else {$TipoImpVale = "";}
$IdTipoTramite = $_POST['IdTipoTramite']; if (ValidaVAR($IdTipoTramite)==TRUE){$IdTipoTramite = LimpiarVAR($IdTipoTramite);} else {$IdTipoTramite = "";}
$Informacion1 = $_POST['Informacion1']; if (ValidaVAR($Informacion1)==TRUE){$Informacion1 = LimpiarVAR($Informacion1);} else {$Informacion1 = "";}
$Informacion2 = $_POST['Informacion2']; if (ValidaVAR($Informacion2)==TRUE){$Informacion2 = LimpiarVAR($Informacion2);} else {$Informacion2 = "";}
$Activo = $_POST['Activo']; if (ValidaVAR($Activo)==TRUE){$Activo = LimpiarVAR($Activo);} else {$Activo = "";} 
$ListaIdPaqueteMat = $_POST['ListaIdPaqueteMat']; if (ValidaVAR($ListaIdPaqueteMat)==TRUE){$ListaIdPaqueteMat = LimpiarVAR($ListaIdPaqueteMat);} else {$ListaIdPaqueteMat = "";}
$TipoAsignacion= $_POST['TipoAsignacion']; if (ValidaVAR($TipoAsignacion)==TRUE){$TipoAsignacion = LimpiarVAR($TipoAsignacion);} else {$TipoAsignacion = "";}
$AreaAplicacion=$_POST['AreaAplicacion']; if (ValidaVAR($AreaAplicacion)==TRUE){$AreaAplicacion = LimpiarVAR($AreaAplicacion);} else {$AreaAplicacion = "";}

if (isset($_POST['NuevoProg'])){
	
	// $sql="";
	//$sql="SELECT Max(IdPrograma)+1 as maxprograma from  programa";
	//$sql=" INSERT INTO programa(IdPrograma) values(508)";
	//$resultado = $Vivienda -> query($sql);
	//echo $sql;
}else{
		

		//echo "letrero".$ListaIdPaqueteMat;

		
		$sql="";
		$sql="UPDATE programa SET Programa='".$Programa."', ProgramaGral='".$ProgramaGral."', Ejercicio='".$Ejercicio."',										
								IdTipoPrograma='".$IdTipoPrograma."',
								Descripcion='".$Descripcion."',
								DiasdePago='".$DiasdePago."' ,
								Subsidiado='".$Subsidiado."',
								TipoImpVale='".$TipoImpVale."', 
								IdTipoTramite='".$IdTipoTramite."',
								Informacion1='".$Informacion1."' ,
								Informacion2='".$Informacion2."',  
								Activo='".$Activo."',
								ListaIdPaqueteMat='".$ListaIdPaqueteMat."',
								AreaAplicacion='".$AreaAplicacion."',
								TipoAsignacion='".$TipoAsignacion."'
								WHERE (IdPrograma='".$IdPrograma."')";
		echo $sql;
					$resultado = $Vivienda -> query($sql);
					if ($Vivienda->query($sql) == TRUE)
						{
						Toast("Se guardó correctamente",1,"");
						}
					else {                
						Toast("Ocurrio un error",1,"");
					}
	
}
?>