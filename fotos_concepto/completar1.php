<?php
//include ("./unica/seguridad.php"); 
//include ("./unica/body_head.php");
//include ("./unica/body_menu.php");

// contenido:
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="unica/css_estructura.css" /> 
	<link rel="stylesheet" href="unica/css_color.css" /> 
	<link rel="stylesheet" href="unica/slider.css">
	<link rel="stylesheet" href="unica/buscar.css">
</head>
<body>



<?php 	require("unica/funciones.php"); ?>
<?php 	require("unica/config.php"); ?>

<?php
echo '<form action="completar1_valida.php" method="post">';


$sql = "SELECT * FROM empleados WHERE (nitavu='".$_GET['id']."')";
$rc= $conexion -> query($sql);
if($f2 = $rc -> fetch_array())
{
				
echo '<h5>El Dpto. de recursos humanos requiere los siguientes datos con <b>fecha limite '.fecha_larga($completar1_fecha).'</b> </h5>';
echo sugerencia(completar1($_GET['id']));

echo '<input type="hidden" id="id" name="id" value="'.$_GET['id'].'">';
echo '

<div>
<label> Estado Civil </label>
<select name="estadocivil" id="estadocivil">';
$sql = "SELECT * FROM cat_edocivil ";
$tmp="";
$r2 = $conexion -> query($sql);
while($f = $r2 -> fetch_array())
	{//Categorias de Aplicaciones
	
	echo '<option value="'.$f['IdEstadoCivil'].'">'.$f['EstadoCivil'].'</option>';
	if ($f2['estadocivil']==$f['IdEstadoCivil']){$tmp=$f['EstadoCivil'];}
	}

	if ($tmp==''){
	echo '<option value="0" selected="selected">NINGUNO</option>';	
	}
	else
	{
	echo '<option value="'.$f2['estadocivil'].'" selected="selected">'.$tmp.'</option>';	
	}


echo '
</select>
</div>

<div>
<label> <span class="ejecutandose">*</span> Correo Electronico </label>
<input name="correo" id="correo" type="text" value="'.$f2['correoelectronico'].'">
</div>

<div>
<label> <span class="ejecutandose">*</span>  Telefono de Casa  </label>
<input name="telefono2" id="telefono2" type="text" value="'.$f2['telefono2'].'">
</div>

<div>
<label> Telefono Celular </label>
<input name="telefono_movil" id="telefono_movil" type="text" required="required" value="'.$f2['telefono_movil'].'">
</div>
<span class="cuadro_ fondo_tenue_map">
<h5 class="">DOMICILIO</h5>
<div>
<label> Calle </label>
<input name="domicilio_calle" id="domicilio_calle" type="text" required="required" value="'.$f2['domicilio_calle'].'">
</div>

<div>
<label> Entre que calles: </label>
<input name="domicilio_entrecalles" id="domicilio_entrecalles" type="text"  value="'.$f2['domicilio_entrecalles'].'">
</div>

<div>
<label><span class="ejecutandose">*</span>  Numero Interior </label>
<input name="domicilio_num_int" id="domicilio_num_int" type="text" value="'.$f2['domicilio_num_int'].'">
</div>

<div>
<label> Numero Exterior </label>
<input name="domicilio_num_ext" id="domicilio_num_ext" type="text" required="required" value="'.$f2['domicilio_num_ext'].'">
</div>

<div>
<label> Colonia </label>
<input name="domicilio_colonia" id="domicilio_colonia" type="text" required="required" value="'.$f2['domicilio_colonia'].'">
</div>

<div>
<label> Ciudad </label>
<input name="domicilio_ciudad" id="domicilio_ciudad" type="text" required="required" value="'.$f2['domicilio_ciudad'].'">
</div>

<div>
<label> Codigo Postal </label>
<input name="domicilio_cp" id="domicilio_cp" type="text" required="required" value="'.$f2['domicilio_cp'].'">
</div>
</span>
<span>
<div class="ejecutandose">(*) Pueden quedar en blanco si no se cuenta con este dato</div>
</span>


<div>
<input value="Guardar y Continuar" type="submit" class="btn btn-default">
</div>

</form>';
}
?>

<?php
//include ("./unica/body_footer.php");
?>
</body>
</html>