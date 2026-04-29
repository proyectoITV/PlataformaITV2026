
<?php
	$host="plataformaitavu.tamaulipas.gob.mx";
	$port=2323;
	//$port=2323;
	$user="desarrollo";
	$password="jpedraza";
	$ruta="datasoft"; 


// establecer la conexión SSL básica
$conn_id = ftp_ssl_connect($host);

// iniciar sesión con nombre de usuario y contraseña
$login_result = ftp_login($conn_id, $user, $password);

echo ftp_pwd($conn_id); // /

// cerrar la conexión SSL
ftp_close($conn_id);
?>

