<?php
	include ("./lib/body_head.php");
	include ("./lib/body_menu.php"); 

	$id_aplicacion ="ap117";
	//historia($nitavu, "[ap117] Entro a la app de patrimonio");

	$nivel = aplicacion_nivel($id_aplicacion, $nitavu);	//Nivel 1 = todos, otro nivel solo los que dependen de el

	if (sanpedro($id_aplicacion, $nitavu)==TRUE)
		{
			echo "<div id='AppDetalle'>".app_detalle($id_aplicacion)."</div>";	
			
			echo "<nav class='navbar navbar-expand-sm bg-dark navbar-dark'>";
				echo "<ul class='navbar-nav'>";

                echo "
                <li class='nav-item'>
                <a class='nav-link' href='Desarrolladores_altaCat.php'>Catálogo de Desarrolladores</a>
                </li>";


                echo "
                <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                   Convenios
                </a>
                <ul class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>
                    <li><a class='dropdown-item' href='Desarrolladores_Convenios.php'>Convenios</a></li>
                    <li><a class='dropdown-item' href='#'>Addendum</a></li>
                    <li><a class='dropdown-item' href='#'>Something else here</a></li>
                </ul>
                </li>";

                // echo "
                // <li class='nav-item'>
                // <a class='nav-link' href='#'>Pricing</a>
                // </li>";

                echo "
                <li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                    Informes
                </a>
                <ul class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>
                    <li><a class='dropdown-item' href='#'>Listado de Convenios</a></li>
                    <li><a class='dropdown-item' href='#'>Another action</a></li>
                    <li><a class='dropdown-item' href='#'>Something else here</a></li>
                </ul>
                </li>";

                echo "
                <li class='nav-item'>
                <a class='nav-link' href='desarroll_cobranza.php'>Cobranza de Desarrolladores</a>
                </li>";
					
              
					// if ($nitavu == 1733 )
					// 	{
					// 		echo "<li class='nav-item'>"; echo "<a class='nav-link' href='#'>Construtor BD</a>"; echo "</li>";
					// 	}

				echo "</ul>";
			echo "</nav>";
		}
	else
		{
			mensaje("ERROR: no tienes acceso a esta aplicacion",'');
		}

	include("lib/body_footer.php");
?>