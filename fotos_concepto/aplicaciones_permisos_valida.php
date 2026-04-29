<?php
include ("./unica/body_head.php");
?>
<?php
$nitavu_quien = $_POST['empleado'];
$idapp = $_POST['aplicacion'];
$nivel = $_POST['aplicacion_nivel'];
$justificacion = $_POST['justificacion'];
$quien_autorizo = $_POST['nitavu_'];

if ($nivel==0) {// eliminar el permiso
	
	$sql = "DELETE FROM aplicaciones_permisos WHERE (nitavu='".$nitavu_quien."' AND idapp='".$idapp."')";
	$rc= $conexion -> query($sql);
	//echo $sql;
	
		mensaje("Se eliminaron los permisos de ".$idapp,'');
	

}
else
{
$sql = "SELECT * FROM aplicaciones_permisos WHERE (nitavu='".$nitavu_quien."' AND idapp='".$idapp."')";
$rc= $conexion -> query($sql);
//echo $sql;
if($f = $rc -> fetch_array()){ // SE ENCONTRARON PERMISOS Y SE ACTUALIZARON

$sql="UPDATE aplicaciones_permisos SET nitavu='$nitavu_quien', idapp='$idapp', nivel='$nivel', quien_autorizo='$quien_autorizo', fecha_autorizacion='$fecha', descripcion='$justificacion' WHERE (nitavu='$nitavu_quien' AND idapp='$idapp')";
if ($conexion->query($sql) == TRUE)
		{
		$msg="";
		$asunto ="Permisos de aplicacion";
		$contenido = "<p>
		Por medio de la presente se le comunica que se le han Actualizado los permisos de nivel ".$nivel." para la aplicacion ".app_nombre($idapp)." </p><p>
		
		Le exhortamos a hacer buen uso de estas herramientas y aproveche esta oportunidad para desempeñarse mejor, quedamos en el departamento a sus ordenes para cualquier duda o soporte de la aplicacion.<br><br>
</p>
		";
		if (notificacion_add ($nitavu_quien, $asunto, $fecha, $quien_autorizo, $contenido)==TRUE){
		$msg = $msg = "Se notifico y ";
		}
		$msg = $msg."Se ha otorgado permiso para usar la app ".$idapp." para ".$nitavu_quien.".";
		mensaje($msg,'');
		}
	else
		{
		$msg="Error inesperado ".$sql; //<-- Descripcion de error
		//creamos un historial de error extraordinario
			header("location:../unica/error.php?er=".$msg);
		}
		
	
}
else {// NO TIENE PERMISOS Y LE AGREGAMOS
$sql = "INSERT INTO aplicaciones_permisos(nitavu, idapp, nivel, quien_autorizo, fecha_autorizacion, descripcion)
VALUES ('$nitavu_quien', '$idapp', '$nivel', '$quien_autorizo','$fecha', '$justificacion')";
//$sql="UPDATE empleados SET nip='".$nip_new."' WHERE nitavu='".$nitavu."'";
//echo $sql;
//$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE)
		{
		$msg="";
		$asunto ="Permisos de aplicacion";
		$contenido = "
		<p>Por este medio y de manera automatizada, se le comunica que se le ha otorgado acceso para la aplicacion ".app_nombre($idapp). ". Para ".app_descripcion($idapp) ." con Nivel ".$nivel."</p>

		<p>
		Se hace de su conocimiento que es usted patrimonialmente responsable, y responderá
		civilmente por los daños y perjuicios ocasionados en caso de que exista un uso indebido
		de las facultades otorgadas por el ITAVU, ya sea por omisión, dolo o negligencia, y se le
		apercibe de que será sancionado con el rigor de las penas establecidas en la Ley de
		Responsabilidad de los Servidores Públicos del Estado y en la legislación Penal vigente.
		</p>


		<p>
		 Al ser usuario del sistema se le hacen las siguientes recomendaciones y aclaraciones:
		<lu>
		<li>El acceso y contraseña que le será otorgado son exclusivos para su uso personal. <li>
		<li> No deberá proporcionar estos datos a ninguna otra persona.</li>
		<li> En caso de uso indebido del sistema, usted responderá a los movimientos realizados con su usuario, ya
		que se registran sus datos durante la operación del mismo.</li>
		<li>Cada vez que deje de utilizar el sistema se recomienda asegurarse cerrar su sesión, ya que en caso de
		dejarla abierta, cualquier persona podrá hacer uso de él con su cuenta.</li>
		<lu>
		</p>
		";
		echo notificacion_add($nitavu_quien, $asunto, $fecha, $quien_autorizo, $contenido);
		$msg = $msg."Se haN creado permiso para usar la app ".$idapp." para ".$nitavu_quien.".";
		$destino = "./index.php";
		mensaje($msg,'aplicaciones_permisos.php');
			//header('location:../index.php');
	}
	else
		{
		$msg="Error inesperado ".$sql; //<-- Descripcion de error
		//creamos un historial de error extraordinario
			header("location:../unica/error.php?er=".$msg);
		}
		
}
}
	
	//header("location:../index.php");
?>