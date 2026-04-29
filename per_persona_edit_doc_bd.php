<?php
include ("./lib/body_head.php");
?>

<?php

//echo $_POST['curp'];
if (isset($_POST['curp']))
{

$anterior= $_SERVER['HTTP_REFERER'];
$curp = $_POST['curp'];

if(!empty($curp))
{

$salto = "<br>";
		//$msg="Fichero subido correctamente a:<br>";

		$archivo = 'docs_personas/'.$curp.'_curp';
		$msg= $msg.subir('curp', $archivo,'jpg');
		
		 $archivo = 'docs_personas/'.$curp.'_acta';
		 $msg= $msg.$salto .subir('acta', $archivo, 'jpg');
		

		 $archivo = 'docs_personas/'.$curp.'_ife';
		 $msg= $msg.$salto .subir('ife', $archivo, 'jpg');	
	
		
		
		historia($nitavu,'Acutalizó documentos de '.$curp);
		
	
		mensaje($msg,$anterior);
	//	header('location:../pre_persnas.ophp');	
}else
{
	mensaje('Favor de registrar los datos, antes de almacenar los documentos de la persona',$anterior);
}
		
}
else {
	
	echo "algo anda mal";
}
?>