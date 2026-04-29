<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ERROR</title>
	<link rel="stylesheet" href="error.css">
	<meta name="viewport" content="width=device-width">
</head>
<body>

<?php
$error_des = $_GET['er'];
?>	

<div class="centrar_padre"><div class="centrar_hijo">

<div id="error">
<h1>ERROR:</h1>

	<strong id="error_descripcion">
	<?php echo $error_des; ?>
	</strong><br>
	
	
	
		<a href="../login/logout.php" class="Mbtn btn-default">Regresar</a>
	
</div>

</div></div>


</body>
</html>