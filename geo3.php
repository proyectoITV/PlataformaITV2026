<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">

<script>
alert("Tu dispositivo soporta la geolocalización.");
if (navigator.geolocation){
   alert("Tu dispositivo soporta la geolocalización.");
   }
else {
   altert("<p>Lo sentimos, tu dispositivo no admite la geolocaización.");
   }
}

</script>


  </head>
  <body>




    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCwwoSmsFVZ7zLa5IjrUm_NlvVH3MKAyU&callback=initMap"
    async defer></script>
  </body>