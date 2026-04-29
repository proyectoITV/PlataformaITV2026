
  <?php
//include ("./lib/seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>
<?php

//PROBANDO FUNCION

// echo MisDptosSQLcp('2773');
echo MisDptos2($nitavu);

$sqlx = "
			
	select @@version as Version
	";

	
	// echo $sql;
	$rx= $conexion -> query($sqlx);
	$strIn="";
    while($fx = $rx -> fetch_array()) {
		echo $fx['Version'];
	}
	$strIn = substr($strIn, 0, -1); //quita la ultima coma.



?>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php
include ("./lib/body_footer.php");
?>