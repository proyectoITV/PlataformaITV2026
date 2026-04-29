<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>


<section id="sistema_alertas">
<!-- 	La funcion escribe los article segun las alertas que existan -->

<?php	

$sql = "SELECT * FROM empleados_geo WHERE (lat='') ORDER by nitavu";
$r2 = $conexion -> query($sql);
$tmp="";
while($f = $r2 -> fetch_array())
	{//Categorias de Aplicaciones
		echo "<article>";
			$archivo = "fotos/".$f['nitavu'].".jpg";
			echo "<div>".ponerfoto($archivo,'foto_redonda')."<br>";
			echo "".user_legend($f['nitavu'])."<br>".nitavu_tel($f['nitavu'])." ext ".nitavu_tel_ext($f['nitavu'])."</div>";
			
			echo "<div><b>No se pudo detectar Ubicacion</b> durante el inicio de sesion el ".fecha_larga($f['fecha'])." a las ".$f['hora']."<br>";

		//echo "<a class='Mbtn btn-default' href='alertas_sistema_omitir.php?id=".$f['id']."'> Omitir </a></div>";
		echo "</article>";
	
	}

		
?>

</section>


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>