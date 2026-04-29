<script type="text/javascript" charset="utf-8" >
if (typeof navigator.geolocation == 'object'){
    navigator.geolocation.getCurrentPosition(mostrar_ubicacion);
}

function mostrar_ubicacion(p)
{
    //alert('posición: '+p.coords.latitude+','+p.coords.longitude );
    global="lat="+p.coords.latitude+'&lon='+p.coords.longitude;
	var urlDestino = "geo_guarda.php?"+global;
	//alert(global);

	window.open(urlDestino, '_self');
}

     
</script>