<?php 
	include ("./lib/body_head.php"); 
	include ("./lib/body_menu.php"); 
	// include ("./lib/funciones.php");

	// $id_aplicacion ="ap118"; 	//Id de la App
	// $nivel = 1; 				//1 Administrador

	// if (sanpedro($id_aplicacion, $nitavu)==TRUE){
		echo "<div class='container'>";
			include('patrimonio_menu.php');
			echo "<div class='row'>";
				echo "<div class='col-lg-12'>";
					echo "<div class='card card-default rounded-0 shadow'>";
						echo "<div class='card-header'>";
							echo "<div class='row'>";
								echo "<div class='col-lg-10 col-md-10 col-sm-8 col-xs-6'>";
									echo "<h3 class='card-title'>Resumen Patrimonial</h3>";
								echo "</div>";						
							echo "</div>";
						echo "</div>";
						echo "<div class='card-body'>";
							echo "<div class='row'><div class='col-sm-12 table-responsive'>";
								echo "<table id='inventoryDetails' class='table table-bordered table-striped'>";
									echo "<thead><tr>";
									echo "<th>#</th>";
									echo "<th>Dirección</th>";  
									echo "<th>Inventariables</th>";
									echo "<th>Controlables</th>";									
									echo "<th>Gasto</th>";
									echo "<th>Total</th>";
									echo "</tr></thead>";
								echo "</table>";
							echo "</div></div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	// }
?>

<?php include ("./lib/body_footer.php"); ?>