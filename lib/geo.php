<script type="text/javascript">
function pedirPosicion(pos) { 
   //document.write("¡Hola! Estas en : "+pos.coords.latitude+ ","+pos.coords.longitude); 
   //document.write(" Rango de localización de +/- "+pos.coords.accuracy+" metros"); 


   //escribe los valores en los input id
   document.getElementById('lat').value  =  pos.coords.latitude; 
   document.getElementById('lon').value  =  pos.coords.longitude;
   document.getElementById('acu').value  =  pos.coords.accuracy;


//var url = "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=400x400&maptype=roadmap&format=jpg&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:1%7C";
// var url = "maps.google.com";
// var lat = pos.coords.latitude; 
// var lon =  ",+"+pos.coords.longitude;
// var url_final = url.concat(lat, lon);

//document.getElementById('img_map').src = "hola";
//document.getElementById('img_map').src = url_final;
//document.getElementById('a_img_map').href = url_final;
   


   document.getElementById('etiqueta_ubicame').className = "visible";
   document.getElementById('formulario_geo').className = "visible";
   geo_label.innerHTML+="Geolocalizado";   
   document.getElementById('esperar').className = "invisible";

   

      
}

if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(pedirPosicion,showError);
} 

function showError(error){
//alert(error.code);
document.getElementById('etiqueta_ubicame').className = "visible";
document.getElementById('formulario_geo').className = "visible";
document.getElementById('esperar').className = "invisible";
  switch(error.code) {
    case error.PERMISSION_DENIED:
      geo_label.innerHTML+="No has otorgado el permiso para Geolocalizacion";
      document.getElementById('acu').value  = "No has otorgado el permiso para Geolocalizacion";

      break;
    case error.POSITION_UNAVAILABLE:
      geo_label.innerHTML+="La información de la localización no está disponible.";
        document.getElementById('acu').value  = "La información de la localización no está disponible.";
      break;
    case error.TIMEOUT:
      geo_label.innerHTML+="El tiempo de espera para buscar la localización ha expirado.";
      document.getElementById('acu').value  = "El tiempo de espera para buscar la localización ha expirado.";
      break;
    case error.UNKNOWN_ERROR:
      geo_label.innerHTML+="Ha ocurrido un error desconocido.";
      document.getElementById('acu').value  ="Ha ocurrido un error desconocido.";
      break;
    }   
}
 
 

 
</script>



			<!-- 	<input type="text" name="lat" id="lat" placeholder="Latitud" >
				<input type="text" name ="lon" id="lon" placeholder="Longitud" >
				<input type="text" name ="acu" id="acu" placeholder="Acurrancy" > -->