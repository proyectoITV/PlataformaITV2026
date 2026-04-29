<?php
include ("unica/validas_raiz.php");
?>
<?php

if ($_POST['estadocivil']=='0') {

	mensaje ("DEBE SELECCIONAR UN ESTADO CIVIL","completar1.php?id=".$_POST['id']);

}
else{


$domicilio_calle = $_POST['domicilio_calle'];
$domicilio_num_ext = $_POST['domicilio_num_ext'];
$domicilio_num_int = $_POST['domicilio_num_int'];
$domicilio_entrecalles = $_POST['domicilio_entrecalles'];
$domicilio_ciudad = $_POST['domicilio_ciudad'];
$domicilio_colonia = $_POST['domicilio_colonia'];
$domicilio_calle = $_POST['domicilio_calle'];
$domicilio_cp = $_POST['domicilio_cp'];
$estadocivil = $_POST['estadocivil'];
$correoelectronico = $_POST['correo'];
$telefono2 = $_POST['telefono2'];
$telefono_movil = $_POST['telefono_movil'];
$id = $_POST['id'];



$sql="UPDATE empleados SET domicilio_calle='$domicilio_calle', domicilio_num_int='$domicilio_num_int', domicilio_num_ext='$domicilio_num_ext', domicilio_entrecalles='$domicilio_entrecalles', domicilio_ciudad='$domicilio_ciudad', domicilio_colonia='$domicilio_colonia', domicilio_cp='$domicilio_cp', estadocivil='$estadocivil', correoelectronico='$correoelectronico', telefono2='$telefono2', telefono_movil='$telefono_movil'  WHERE (nitavu='$id')";
//echo $sql;
if ($conexion->query($sql) == TRUE)
{
			mensaje ("GUARDADO CORRECTAMENTE","index.php");

}
else
{
			$msg="Error inesperado ".$sql; //<-- Descripcion de error
			//creamos un historial de error extraordinario
				//header("location:../unica/error.php?er=".$msg);
}

}

?>