<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>



<?php require("unica/funciones.php");?>

<form action='imagenes.php' method='post' enctype="multipart/form-data">
	<?php 
		echo "<div id='imagen_ejemplo'>";
		
		if (isset($_GET['img'])){$busqueda=$_GET['img'];} else {$busqueda="";}

		$src= Google_images($busqueda,'','FALSE'); //esto dara el src
		echo "<img src='$src'>";
		echo "</div>";
	?>
	<input type="text" readonly="readonly" value='<?php echo $src; ?>' name='imagen_ejemplo'>
	<input type="file" value='<?php echo $src; ?>' name='archivo'>
	<?php
	if (isset($_GET['img'])){
		echo '<input type="text" value="'.$busqueda.'" id="nombre" onchange="test_carga();">';
	}else {
		echo '<input type="text" value="" id="nombre" onchange="test_carga();" >';
	}
	?>
	<input type="submit" value="Guardar" name='submit'>
</form>


<?php
if (isset($_POST['submit'])){
if ($_POST['archivo']){ //subir de forma normal }

} else {
	//sino se selecciona un archivo
	$ok= copiar_img($_POST['imagen_ejemplo'], 'fotos/perro.jpg'); //copiar_img(origen,destino), recuerda en destino manipular el directorio a donde se va a ir
	if ($ok=='TRUE') {
		mensaje("Guardado correctamente la imagen ejemplo",'');
	} else {
		mensaje("no se ha podido guardar",'');
	}
}
}
?>



<script>
function test_carga(){
var yourSelect = document.getElementById( "nombre" );

window.location="imagenes2.php?img="+ yourSelect.value ;
}
</script>

</body>
</html>


