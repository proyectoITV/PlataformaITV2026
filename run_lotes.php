<?php
require("config.php");
require("lib/funciones.php");
 sleep(1);

$Mun = "";
$Col= "";
if (isset($_POST['Mun'])){$Mun = $_POST['Mun'];}
if (isset($_POST['Col'])){$Col = $_POST['Col'];}

	$sql = "select DISTINCT Manzana FROM lotes where lotes.IdMunicipio = '".$Mun."' and IdColonia = '".$Col."' order by Manzana";
    $r2 = $conexion -> query($sql);
    echo "<label>Selecciona la Manzana:</label>";
	echo "<select name='Manzana' >";
	while($f = $r2 -> fetch_array())
		{
			echo "<option value='".$f['Manzana']."'>".$f['Manzana']."</option>";
			
		}
	echo "</select>";
    
    // echo $sql;
?>