<?php
require("config.php");
require("lib/funciones.php");
sleep(1);

$mSel = "";
if (isset($_POST['mSel'])){$mSel = $_POST['mSel'];}
	$sql = "SELECT IdMunicipio, nombre FROM cat_municipios order by nombre";
	$r2 = $conexion -> query($sql);
	echo "<label>Selecciona el Municipio:</label>";
	echo "<select id ='municipio' name='municipio' onchange='CargaColonias();' >";
	while($f = $r2 -> fetch_array())
		{
			if ($f['IdMunicipio']== $mSel){
				echo "<option value='".$f['IdMunicipio']."' selected>".$f['nombre']."</option>";
			} else 
			{
				echo "<option value='".$f['IdMunicipio']."'>".$f['nombre']."</option>";
			}
		}
	echo "</select>";

?>