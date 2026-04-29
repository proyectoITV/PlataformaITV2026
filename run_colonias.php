<?php
require("config.php");
require("lib/funciones.php");
 sleep(1);

$mSel = "";
if (isset($_POST['mSel'])){$mSel = $_POST['mSel'];}
	$sql = "SELECT Colonia, IdMunicipio, IdColonia from catcolonia where IdMunicipio = '".$mSel."' order by Colonia
    ";
    $r2 = $conexion -> query($sql);
    echo "<label>Selecciona el Municipio:</label>";
	echo "<select id='colonia' name='colonia' onchange='CargaManzanas();' >";
	while($f = $r2 -> fetch_array())
		{
			echo "<option value='".$f['IdColonia']."'>".$f['Colonia']."</option>";
			
		}
	echo "</select>";

?>