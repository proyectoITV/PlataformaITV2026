<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
<script >
navigator.geolocation.getCurrentPosition(fn_ok, fn_error);

function fn_error(){
//alert('Error');
var lat = 0;
var lon = 0;

global="lat="+lat+'&lon='+lon;
//var urlDestino = "unica/error.php?er=2-Debe aceptar el permiso de compartir su ubicacion, para poder iniciar sesion.";
var urlDestino = "geo_guarda.php?"+global;
//alert(global);
window.open(urlDestino, '_self');
}

function fn_ok(respuesta){

//var n = getParameterByName('nitavu');


global="lat="+lat+'&lon='+lon;
var urlDestino = "geo_guarda.php?"+global;
//alert(global);

window.open(urlDestino, '_self');
}
</script>
</head>
<body>
	
</body>
</html>

