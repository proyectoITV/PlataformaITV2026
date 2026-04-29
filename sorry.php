<?php
//include (".//seguridad.php"); 
//include ("./lib/body_head.php");
//include ("./lib/body_menu.php");

// contenido:
?>
<html>
<head>
	<link rel="stylesheet" href="../lib/css_estructura.css" /> 
	<link rel="stylesheet" href="../lib/css_color.css" /> 
</head>
<body>
<div id='div_errores'>

<?php


if (isset($_GET['e'])){
	if ($_GET['e']=='404'){	
		echo "<img src='../icon/404.png' class='carita'>";	
		echo "<span class='tgrande'><br>";
		echo "<b clasS='ejecutandose'>No se encuentra</b><br><b class='normal'> la pagina solicitada</b>";
		echo "</span>";
	}

	if ($_GET['e']=='500'){	
		echo "<img src='../icon/404.png' class='carita'>";	
		echo "<span class='tgrande'><br>";
		echo "<b clasS='ejecutandose'>Lo sentimos</b><br><b class='normal'>estamos experimentando algunos problemas, intentelo mas tarde</b>";
		echo "</span>";
	}


	if ($_GET['e']=='403' or 
		$_GET['e']=='401' 
		){		
		echo "<img src='../icon/stop.png' class='carita'>";
		echo "<span class='tgrande'><br>";
		echo "<b clasS='ejecutandose'>Acceso Prohibido </b><br><b class='normal'> a esta seccion</b>";
		echo "</span>";
	}


}

?>
<br><br><a href='index.php' title='Haga clic aqui para ir a la pagina principal' class='Mbtn btn-default'>Ir a la pagina principal</a>
</div>




</body>
</html>

<?php
//include ("./lib/body_footer.php");
?>