<?php
include ("./lib/body_head.php");
?>

<?php
$no = $_POST['no'];
if (isset($no)) {

 $sap= $_POST['sap'];
 $secc = $_POST['secc'];
 $direccion = $_POST['direccion'];
// $nombre = $_POST['nombre'];
//$depa = $_POST['depa'];
$puesto = $_POST['puesto'];
$nivel = $_POST['nivel'];
//$correoelectronico = $_POST['correoelectronico'];
$telefono = $_POST['telefono'];
// $telefono_movil = $_POST['telefono_movil'];
 //$fecha_nacimiento = $_POST['fecha_nacimiento'];

 $quien = $_POST['quien']; // se requiere ya no esta disponible $nitavu

 //$telefono2 = $_POST['telefono2'];
$telefono_extension = $_POST['telefono_extension'];
$profesion = $_POST['profesion'];
$profesion_abr = $_POST['profesion_abr'];

//$historia = user_historia($no).", Actualizo datos laborales por ".user_legend($quien)." el ".$fecha;
$historia="";

$dpto = $_POST['dpto'];
$dpto_old = nitavu_dpto($no);

echo $dpto."=".$dpto_old."<br>";

$titular = $_POST['titular'];
// if ($titular == 0 or $titular =''){$titular = '';}

$estado = $_POST['estado'];
//echo $_POST['depa'];
$depa = dpto_id($dpto);

$comida = $_POST['comida'];
$horario_entrada=$_POST['horario_entrada'];
$horario_salida=$_POST['horario_salida'];
$sueldo = $_POST['sueldo'];
$compe = $_POST['compe'];


$sql ="UPDATE empleados SET secc='$secc', puesto='$puesto', sap='$sap', nivel='$nivel', telefono='$telefono', historia='$historia', telefono_extension='$telefono_extension', profesion='$profesion', profesion_abr='$profesion_abr', direccion='$direccion', departamento='$depa', dpto ='$dpto' , estado='$estado'
, comida='$comida', horario_entrada='$horario_entrada', horario_salida='$horario_salida', sueldo='$sueldo' WHERE nitavu='$no'";
echo $sql;
//$sql ="UPDATE empleados SET nombre='$nombre', correoelectronico='$correoelectronico', telefono_movil='$telefono_movil', fecha_nacimiento='$fecha_nacimiento',historia='$historia', telefono2='$telefono2' WHERE nitavu='$no'";
//echo $sql;
if ($conexion->query($sql) == TRUE) 
		{
		$msg="";
		$archivo = 'firmas/'.$no.'';
		$msg= $msg.subir('firma_file', $archivo, 'jpg');
		//addslashes() Para escapar comillas simples, dombles y \
		historia($quien,"(".addslashes($sql).') Actualizo datos laborales de '.$no);


			if ($dpto<>$dpto_old)
			{// SI HAY EXT, NOTIFICAR AL DPTO DE SOPORTE AL TITULAR Y QUIENES TENGAN ACCESO A ACTUALIZAR EL DATO
				$msg="Por medio de la Plataforma de Sistemas de ITAVU y de manera automatizada se envia este documento";
				$msg = $msg."electronico.<br><br>";
				$msg = $msg."Se ha detectado un cambio de departamento (de ".dpto_id($dpto_old)." a ".dpto_id($dpto).
				") del empleado ".nitavu_nombre($no)."<br>";

				$msg = $msg."con Numero de Control de ITAVU <b>".$no."</b>, del departamento de ".$dpto."<br>";
				$msg = $msg."<br><br>Servicios para actualizar:<br><lu>";

				$tel_ext = nitavu_tel_ext($no); $msg = $msg."<li>Ext. Telefonica: ".$tel_ext."<br></li>";

				historia($quien,'Cambio de Dpto a '.nitavu_nombre($no).' de '.dpto_id($dpto_old).' a '.dpto_id($dpto));

				$idapp="ap17"; 
				//notifica (titular('4'), "BAJA de Personal ".$no, date('Y-m-d'), $quien,$msg); //JAVIER
				$sql = "SELECT * FROM aplicaciones_permisos WHERE (idapp='".$idapp."' )";
				$rc= $conexion -> query($sql);	while($f = $rc -> fetch_array())
				{
				echo notifica ($f['nitavu'], "Actualizar Extension Telefonica por cambio de DPTO ".$tel_ext, date('Y-m-d'), $quien,$msg); //SU personal
				}

			}



		if ($estado<>''){
			historia($quien,'Cambio el estado laboral de '.nitavu_nombre($no)." (".$no.") ".' a '.$estado);

			// ENVIAR NOTIFICACION A QUIEN SE DEBA   **** posibilidad si tiene algo mas
			//Titular de Informatica id=55
			//Titular de Rec. Humanos id=58
			//Administrativo id=54
			//General id=1
			//Titular de Soporte id=4
			//notifica ($usuario, $asunto, $entregar_fecha, $itavu_manda, $contenido)
				$msg="Por medio de la Plataforma de Sistemas de ITAVU y de manera automatizada se envia este documento";
				$msg = $msg."electronico.<br><br>";
				$msg = $msg."Se ha detectado un cambio de estado laboral (".$estado.") del empleado ".nitavu_nombre($no)."<br>";
				$msg = $msg."con Numero de Control de ITAVU <b>".$no."</b>, del departamento de ".$dpto."<br>";
				$msg = $msg."<br><br>Servicios para actualizar:<br><lu>";

				$tel_ext = nitavu_tel_ext($no); $msg = $msg."<li>Ext. Telefonica: ".$tel_ext."<br></li>";
				$correo = nitavu_correo($no); $msg = $msg."<li> Correo: ".$correo."<br></li>";
				
				$msg = $msg."</lu><br>Se le ha notificado debido a la aplicacion y permisos que maneja. ";

		
			// notifica (titular('55'), "BAJA de Personal ".$no, date('Y-m-d'), $quien,$msg);
			// notifica (titular('1'), "BAJA de Personal ".$no, date('Y-m-d'), $quien,$msg); //dir. gral
			// notifica (titular('54'), "BAJA de Personal ".$no, date('Y-m-d'), $quien,$msg); //administrativo


			// if ($tel_ext<>'')
			// {// SI HAY EXT, NOTIFICAR AL DPTO DE SOPORTE AL TITULAR Y QUIENES TENGAN ACCESO A ACTUALIZAR EL DATO
			// 	$idapp="ap17"; 
			// 	//notifica (titular('4'), "BAJA de Personal ".$no, date('Y-m-d'), $quien,$msg); //JAVIER
			// 	$sql = "SELECT * FROM aplicaciones_permisos WHERE (idapp='".$idapp."' )";
			// 	$rc= $conexion -> query($sql);	while($f = $rc -> fetch_array())
			// 	{notifica ($f['nitavu'], "Actualizar Extencion Telefonica ".$tel_ext, date('Y-m-d'), $quien,$msg); //SU personal
			// 	}

			// }



			// if ($correo<>'')
			// {// SI HAY EXT, NOTIFICAR AL DPTO DE SOPORTE AL TITULAR Y QUIENES TENGAN ACCESO A ACTUALIZAR EL DATO
			// 	$idapp="ap02"; 
			// 	//notifica (titular('55'), "BAJA de Personal ".$no, date('Y-m-d'), $quien,$msg); //JAVIER
			// 	$sql = "SELECT * FROM aplicaciones_permisos WHERE (idapp='".$idapp."' )";
			// 	$rc= $conexion -> query($sql);	while($f = $rc -> fetch_array())
			// 	{notifica ($f['nitavu'], "Actualizar correo electronico ".$correo, date('Y-m-d'), $quien,$msg); //SU personal
			// 	}

			// }




		}




		
		$msg = "Se ha Actualizado con exito con exito.";
		// ACTUALIZAR LA TITULARIDAD Y BORRARLO DE CUALQUIER OTRA QUE TENGA PRIMERO
		// if ($titular==''){// la titularidad se quita, borrarla de todos

			//PRIMERO LIMPIAMOS EL QUE YA ESTA
			$sql ="UPDATE cat_gerarquia SET titular='' WHERE titular='$no'";			
			echo $sql;
			if ($conexion->query($sql) == TRUE) {
				$msg = $msg."<br>:Se limpio la titularidad de dpto. ".$titular." del empleado ".$no.", ";
			}		
			if ($titular == ''){
				//si el titular esta '' ya no se asgina titularidad porque es operativo
				// $sql ="UPDATE cat_gerarquia SET titular='".$no."' WHERE id=''";			
			} else {
				$sql ="UPDATE cat_gerarquia SET titular='".$no."' WHERE id='$titular'";			
			}
			
			echo $sql;
			if ($conexion->query($sql) == TRUE) {
				$msg = $msg.", se Actualizo la titularidad de dpto. ".$titular.",".$no.", ".$puesto;
			}		

		// } 
		// else {

		// 	//SI TIENE TITULARIDAD
		// 	// se reemplaza la que tiene el dpto.
		// 	$sql ="UPDATE cat_gerarquia SET titular='$no' WHERE id='$titular'";
			
		// 	echo $sql;
		// 	if ($conexion->query($sql) == TRUE) {
		// 		$msg = $msg.", se asigno la titularidad de ".dpto_id($titular)." a ".nitavu_nombre($no)."($no).";
		// 	}		
		// }

		//http://localhost/empleados_edit.php?pes=lab&n=119460
		historia($nitavu, $msg);
		mensaje("Actualizado correctamente, ".$msg,'empleados_edit.php?pes=lab&n='.$no);
		//header('location:../index.php');	

		} 
	else 
		{
		$msg="Error inesperado ".$sql; //<-- Descripcion de error
		//echo $sql;
		//creamos un historial de error extraordinario
		ob_end_clean();
		header("location:lib/error.php?er=".$msg);	
		} 
		
}
else {
	echo "algo anda mal";
}
?>