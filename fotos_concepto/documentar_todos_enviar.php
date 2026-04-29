<?php
include ("./unica/body_head.php");
?>
<?php
$contenido = $_POST['contenido'];
$autor = $_POST['nitavu_'];
$asunto = $_POST['asunto'];
$entregar_fecha = $_POST['entregar_fecha'];
if (valida_fecha($entregar_fecha)==TRUE) {
$sql="";
$msg2="";
$copias= 0;
$no = docdigital_no(TRUE, $copias);
$contenido = str_replace('"',"",$contenido); //extrae las " del contenido, y gracias al html5 no son necesarias en <a href=viculo o en src=archivo
	$sql = "SELECT * FROM empleados ORDER by nombre ASC";
	$r = $conexion -> query($sql);
	$r_count = $r -> num_rows;
	$no = docdigital_no(FALSE, $r_count * 2);
	$c = 0;
	$err = "";
			while($f = $r -> fetch_array())
				{ // resultado de la busqueda.................
					$nitavu=$f['nitavu'];
				
					$sql = "INSERT INTO notificaciones(nitavu, asunto, entregar_fecha, contenido, nitavu_manda, no_oficio) VALUES ('$nitavu', '$asunto', '$entregar_fecha', '$contenido', '$autor', '$no')";
					if ($conexion->query($sql) == TRUE) {$c = $c +1;}
					else {$err = $err."error: ".$sql."<br>";}
				}
			mensaje ("Se han entregado con exito ".$c." Documentos electronicos de ".$r_count.", con no. de oficio ".$no,'');
	}
else
	{
			mensaje("Fecha introducida incorrectamente",'');
	}
	?>