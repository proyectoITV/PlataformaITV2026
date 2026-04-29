<?php
	include ("./lib/body_head.php");
	include ("./lib/body_menu.php"); 

	$id_aplicacion ="ap117";
	//historia($nitavu, "[ap117] Entro a la app de desarrolladores");

	$nivel = aplicacion_nivel($id_aplicacion, $nitavu);	//Nivel 1 = todos, otro nivel solo los que dependen de el

	if (sanpedro($id_aplicacion, $nitavu)==TRUE)
		{
			echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
			
			echo "<nav class='navbar navbar-expand-sm bg-dark navbar-dark'>";
				echo "<ul class='navbar-nav'>";
					
					echo "<li class='nav-item dropdown'>"; echo "<a class='nav-link dropdown-toggle' href='#' id='navbardrop' data-toggle='dropdown'>"; echo "Catálogos auxiliares"; echo "</a>";
						echo "<div class='dropdown-menu'>";
							echo "<a class='dropdown-item' href='patrimonio_catmarcas.php'>Catálogo de marcas</a>";
							echo "<a class='dropdown-item' href='#'>Catálogo de proveedores</a>";
							echo "<a class='dropdown-item' href='#'>Clasificación de bienes</a>";
						echo "</div>";
					echo "</li>";
		
					echo "<li class='nav-item'>"; echo "<a class='nav-link' href='desarrolladores_altaCat.php'>Artículos del instituto</a>"; echo "</li>";
					echo "<li class='nav-item'>"; echo "<a class='nav-link' href='#'>Asignar un bien</a>"; echo "</li>";
					echo "<li class='nav-item'>"; echo "<a class='nav-link' href='#'>Movimientos internos</a>"; echo "</li>";
					echo "<li class='nav-item'>"; echo "<a class='nav-link' href='#'>Entregar departamento</a>"; echo "</li>";
					echo "<li class='nav-item'>"; echo "<a class='nav-link' href='#'>Garantías</a>"; echo "</li>";

					echo "<li class='nav-item dropdown'>"; echo "<a class='nav-link dropdown-toggle' href='#' id='navbardrop' data-toggle='dropdown'>"; echo "Reportes"; echo "</a>";
						echo "<div class='dropdown-menu'>";
							echo "<a class='dropdown-item' href='#'>Estadisticas de bienes</a>";
							echo "<a class='dropdown-item' href='#'>Informe de movimientos por año</a>";
							echo "<a class='dropdown-item' href='#'>Informe de facturas distribuidas por mes</a>";
							echo "<a class='dropdown-item' href='#'>Gráfica de distribución de bienes</a>";
							echo "<a class='dropdown-item' href='#'>Informe  de movimientos internos de bienes</a>";
							echo "<a class='dropdown-item' href='#'>Formato de asignación de bienes por Dirección</a>";
							echo "<a class='dropdown-item' href='#'>Informe por año de compras de bienes</a>";
							echo "<a class='dropdown-item' href='#'>Imprime etiquetas</a>";
						echo "</div>";
					echo "</li>";

					if ($nitavu == 1733 )
						{
							echo "<li class='nav-item'>"; echo "<a class='nav-link' href='#'>Construtor BD</a>"; echo "</li>";
						}

				echo "</ul>";
			echo "</nav>";
		}
	else
		{
			mensaje("ERROR: no tienes acceso a esta aplicacion",'');
		}

	include("lib/body_footer.php");
?>