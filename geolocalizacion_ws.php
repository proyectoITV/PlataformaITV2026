<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script  type="text/javascript" async="async">
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(mostrarUbicacion);
}

function mostrarUbicacion (ubicacion) {
  var long = ubicacion.coords.longitude;
  var lat = ubicacion.coords.latitude;
  var exa = ubicacion.coords.accuracy;

  console.log(`longitud: ${ long } | latitud: ${ lat } | exactitud: ${ exa }` );
  var cadena = '[{"Latitud":"'+lat+'","Longitud":"'+long+'","Exactitud":"'+exa+'"}]';

  enviarDatos(lat, long, exa);
  //document.write(cadena);
    //result = JSON.stringify(cadena);
    //document.write(result);
}

function enviarDatos(lat, long, exa){
  var id2 = '<?php echo $_GET['id']; ?>';
  $.ajax(
  {
    url : "receptor.php",
    type: "POST",
    data : {id: id2, lat: lat, long: long, exa: exa}
  })
  .done(function(data) {
    var d = data;
  //  $("#res").html(data);
    //var result = document.getElementById('respuesta').value;
    alert(data);
   
    
  });


}
</script>
<?php 
//echo "<div id='res' name='res'></div>";
require ("config.php");
if(isset($_GET['id'])){
 //ob_end_clean();
// header('Content-Type: application/json');
 $sql = "SELECT * FROM ws_geo where id=".$_GET['id'];
$r2 = $conexion -> query($sql);
$tmp="";
while($f = $r2 -> fetch_array())
	{//Categorias de Aplicaciones
		
    $Nodo = new stdClass;
    $Nodo ->Longitud = $f['longitud'];
    $Nodo ->Latitud = $f['latitud'];
    $Nodo ->Exactitud = $f['exactitud'];
    $elJSON = json_encode($Nodo);
    
    echo $elJSON;
		
	}

}


?>