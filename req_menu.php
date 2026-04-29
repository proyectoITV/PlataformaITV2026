<?php

$idDepartamento=nitavu_dpto($nitavu);
$nproductos=numProductosReq2($idDepartamento); //1 Administrador | 2 Operador
echo "<div id='req_menu'>"; // MENU
		echo "<a href='req.php' class='Mbtn btn-tercero' title='Regresar al Inicio'>";
			echo "<table  width='100%'><tr><td valign='middle' align='center'>";
			echo "<img src='icon/req_home.png' style='width: 30px; height: 30px;'>";
			echo "</td><tr></tr>";
			echo "</tr></table>";
		echo "</a>";	


		echo "<a href='req.php?m=' class='Mbtn btn-danger' title='Aqui puede ver los articulos Seleccionados'>";
			echo "<table  width='100%'><tr><td valign='middle' align='center'>";
			echo "<img src='icon/req1.png' style='width: 30px; height: 30px;'>";
			echo "</td>";
			echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
			echo "Mi Requisicion  <b style='color: orange;'> (".$nproductos.")</b>";
			echo "</td></tr></table>";
		echo "</a>";	


		echo "<a href='./req_requisiciones.php?m=' class='Mbtn btn-danger' title='Ver el historial de requisiciones ' >";
			echo "<table  width='100%'><tr><td valign='middle' align='center'>";
			echo "<img src='icon/req2.png' style='width: 30px; height: 30px;'>";
			echo "</td>";
			echo "<td valign='middle' align='center' style='color:white;' class='pc'>";

			echo "Historial";

			echo "</td></tr></table>";
		echo "</a>";		


	


	if ($nivel==1)
	{
			echo "<a href='./req_concepto_nuevo.php' class='Mbtn btn-tercero' title='Agregar un nuevo articulo (concepto) '>";
			echo "<table  width='100%'><tr><td valign='middle' align='center'>";
			echo "<img src='icon/req3.png' style='width: 30px; height: 30px;'>";
			echo "</td>";
			echo "<td valign='middle' align='center' style='color:gray;' class='pc'>";

			echo "Nuevo Concepto";

			echo "</td></tr></table>";
			echo "</a>";	

			

			echo "<a href='./req_solicitar_req.php' class='Mbtn btn-tercero' title='Cierra en una requisición los articulos seleccionados por el usuario'>";
			echo "<table  width='100%'><tr><td valign='middle' align='center'>";
			echo "<img src='icon/req4.png' style='width: 30px; height: 30px;'>";
			echo "</td>";
			echo "<td valign='middle' align='center' style='color:gray;' class='pc'>";

			echo "Solicitar Requisiciones";

			echo "</td></tr></table>";
			echo "</a>";

			// echo "<a href='./req_reporte_requisiciones2.php' class='Mbtn btn-secundario' title='Reporte'>";
			// echo "<table  width='100%'><tr><td valign='middle' align='center'>";
			// echo "<img src='icon/req1.png'>";
			// echo "</td>";
			// echo "<td valign='middle' align='center' style='color:gray;' class='pc'>";

			// echo "Reporte";

			// echo "</td></tr></table>";
			// echo "</a>";


	}
	echo "<a href='./req.php?env=' class='Mbtn btn-tercero' title='Enviar' style='display:none' id='enviar'>";
			echo "<table  width='100%'><tr><td valign='middle' align='center'>";
			echo "<img src='icon/correcto.png' style='width: 30px; height: 30px;'>";
			echo "</td>";
			echo "<td valign='middle' align='center' style='color:white;' class='pc'>";

			echo "Enviar";

			echo "</td></tr></table>";
	echo "</a>";

echo "</div>";

?>	