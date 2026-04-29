<?php
include ("./lib/body_head.php");
?>

<?php
$id_aplicacion ="ap54"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	

$idsolicitante = $_POST['idsolicitante'];
//if (isset($no)) {
$quien = $nitavu;
 $nombre = $_POST['nombre'];
 $paterno = $_POST['paterno'];
 $materno = $_POST['materno'];
 $correoelectronico = $_POST['correoelectronico'];
 $telefono_movil = $_POST['telefono_movil'];
 $fecha_nacimiento = $_POST['fecha_nacimiento'];
 $lugar_nacimiento = $_POST['lugarNac'];
 

 $telefono2 = $_POST['telefono'];
 $rfc = $_POST['rfc'];
  $curp = $_POST['curp'];
 $facebook = $_POST['facebook'];
  $twitter = $_POST['twitter'];
/*$domicilio_calle = $_POST['domicilio_calle'];
$domicilio_num_int = $_POST['domicilio_num_int'];
$domicilio_num_ext = $_POST['domicilio_num_ext'];
$domicilio_entrecalles = $_POST['domicilio_entrecalles'];
$domicilio_colonia = $_POST['domicilio_colonia'];
$domicilio_cp = $_POST['domicilio_cp'];
$domicilio_ciudad = $_POST['domicilio_ciudad'];*/
$idestado_nac = $_POST['estadocivil'];


$reg = $_POST['reg'];
//$historia = user_historia($no).", Registró datos generales por ".user_legend($quien)." el ".$fecha;



if ($reg=='0')
{

$sql = " -- per 
	INSERT INTO personas( IdSolicitante, Nombre, Paterno,Materno,FNacimiento, LugarNacSol, IdEstadoNac,RFC,Curp, TelefonoFijo,TelefonoMovil, CorreoElectronico, Facebook, Twitter,Nitavu_Crea,FechaCrea) 
	VALUES ('$idsolicitante','$nombre','$paterno','$materno','$fecha_nacimiento','$lugar_nacimiento','$idestado_nac','$rfc','$curp','$telefono2','$telefono_movil','$correoelectronico','$facebook','$twitter','$quien',NOW())";
}else
{
	$sql = " -- per 
	UPDATE personas SET nombre='$nombre', Paterno='$paterno',Materno='$materno', LugarNacSol='$lugar_nacimiento', IdEstadoNac='$idestado_nac',RFC='$rfc', TelefonoFijo='$telefono2',TelefonoMovil='$telefono_movil', CorreoElectronico='$correoelectronico',Facebook='$facebook',Twitter='$twitter',FNacimiento='$fecha_nacimiento', FechaMod=NOW(), Nitavu_Mod='$quien' WHERE Curp='$curp'";
}

if ($conexion->query($sql) == TRUE) 
		{
			
		$msg="";

		$archivo = 'fotos_personas/'.$curp.'';
		$msg= $msg.subir('foto_file', $archivo, 'jpg');
		
		//$archivo = 'firmas/'.$no.'';
		//$msg= $msg.subir('firma_file', $archivo, 'jpg');
		
		historia($quien,'Per_Actualizó datos de '.$curp);
		
		$msg = $msg."Los datos se han actualizado con exito.";
		mensaje($msg,'per_personas.php?search=');
		//header('location:../index.php');	

		} 
	else 
		{
		$msg="Error inesperado ".$sql; //<-- Descripcion de error
		//echo $sql;
		//creamos un historial de error extraordinario
		///header("location:../lib/error.php?er=".$msg);	
		} 
		
//}
// else {
// 	echo "algo anda mal";
// }
		}else
{
echo "<br><br>";
	mensaje("No tiene acceso al modúlo de personas beneficiadas (".$id_aplicacion.")", "index.php");}
?>