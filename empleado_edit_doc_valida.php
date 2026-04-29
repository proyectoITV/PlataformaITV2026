<?php
include ("./lib/body_head.php");
?>

<?php
$no = $_POST['no'];
if (isset($no)) {

$quien = $_POST['quien'];


		$msg="";

		$archivo = 'docs/'.$no.'_curp';
		$msg= $msg.subir('curp', $archivo, 'jpg');
		
		$archivo = 'docs/'.$no.'_acta';
		$msg= $msg.subir('acta', $archivo, 'jpg');
		

		$archivo = 'docs/'.$no.'_ife';
		$msg= $msg.subir('ife', $archivo, 'jpg');
		
	
		$archivo = ''.$no.'_cv';
		$msg= $msg.subirpdf2('cv', $archivo);
		
		historia($quien,'Acutalizo documentos de '.$no);
		
		$msg = $msg."Se ha Actualizado con exito con exito.";
		mensaje($msg,'');
		//header('location:../index.php');	

		
}
else {
	echo "algo anda mal";
}
?>