<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>


<section id="alertas">
<!-- 	La funcion escribe los article segun las alertas que existan -->

		<?php
			$alertas = user_alertas($_SESSION['nitavu']);
			echo $alertas;

		?>
		


</section>




<?php

$nitavu_msg=$_GET['nitavup'];

if ($nitavu_msg==""){ // si no es especifica el usuario poner todos
$sql = "SELECT * FROM mensajeria WHERE nitavu='".$nitavu."' ORDER by nitavu_para ASC";
$r2 = $conexion -> query($sql);
while($msg = $r2 -> fetch_array())
	{//Acceso a todos los mensajes
	echo "<section id='mensajeria'>";
	echo "<div>";
	echo "<div id='AppDetalle'>".$msg['nitavu_para']."</div>";
	echo "<span>";
	if ($msg['visto']==TRUE) {$vistazo="".$msg['visto_fecha']." - ".$visto['visto_hora'];} else {$vistazo="";}
	echo "<label>".$msg['fecha']." - ".$msg['hora']." Visto: ".$vistazo;
	echo "<p>".$msg['contenido']."</p>";
	echo "</span>";
	echo "</div>";

	echo "</section>";
	}

}


?>



<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>