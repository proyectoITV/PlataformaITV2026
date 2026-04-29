<html>
<head> 
    <meta charset="UTF-8">
    <title>Prueba Leaflet</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
 	<style> 
  	#map {
   	width: 1000px;
  	 height: 600px; }
       #map1 {
   	width: 1000px;
  	 height: 600px; }
	</style> 
</head>  
	<body>
	 	<script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
		<script src='https://npmcdn.com/@turf/turf/turf.min.js'></script>
		<script type="text/javascript" src="lib/prueba45.js"></script>
		<script src="https://code.jquery.com/jquery-1.8.0.min.js"></script>
		<div id ="map"> </div> 
        <h1>Aqui empieza mapa 2 con datos desde MARIADB</h1>
        <div id ="map1"> </div> 
        <div id ="respuesta"> </div> 
	<script>
	var map = L.map('map', {
		center: [31.9655702,-102.147767],
		zoom: 4,
		});
 
	L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);
 
	var geoJsonLayer = L.geoJson().addTo(map);

    L.geoJSON(datos, {
        style: function(feature) {
            switch (feature.properties.ESTADO) {
                case 'Tamaulipas': return {color: "#ff0000"};
                case 'Sonora':   return {color: "#FF8000"};
            }
        }
        ,onEachFeature:  function (feature, layer) {		 	
        layer.bindPopup(feature.properties.ESTADO); 
        }      
    }).addTo(map);

var map1 = L.map('map1').setView([31.9655702,-102.147767], 4); // Málaga

var osmBase = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap<\/a> contributors'
}).addTo(map1);


function stylePolygon(feature) {
  switch (feature.properties.ESTADO) {
                case 'Tamaulipas': return { fillColor: "green",fillOpacity: 1.0 ,  color: 'green'};
                case 'Sonora':   return { fillColor:  "green",fillOpacity: 1.0 ,  color: 'green'};
            
                default: return {
    weight: 1.3, // grosor de línea
    color: 'green', // color de línea
    opacity: 1.0, // tansparencia de línea
    fillColor: 'red', // color de relleno
    fillOpacity: 1.0 // transparencia de relleno
  };
};
};



function crearJSONPoligono(json,codigo, estado){

var arr = json.split("(");
var coords = [];
  for(var i = 1; i< arr.length; i ++){
    if(arr[i] == ''){
      //coords += "[";
      coords.push("["); 
    }else{
      //coords += "[";
      coords.push("[");
      var arr2 = arr[i].split(")");
      for( var j=0; j<arr2.length; j++){       
        if(arr2[j] == ''){
          //coords += ']';
          coords.push("]");
        }else if(arr2[j] == ','){
         // coords += '],';
          coords.push("],");
        }else{
          var arr3 = arr2[j].split(",");
          for(var k=0; k<arr3.length; k++){
            var coordenada = arr3[k].replace(' ',', ');
            
            //coords +=  '[ ' + coordenada + ' ],';
            if(k == (arr3.length-1)){
              coords.push('[ ' + coordenada + ' ]');
            }else{
              coords.push('[ ' + coordenada + ' ],');
            }
           
          }
        
          //coords = coords.substring(0, coords.length-1); //quita la ultima coma.
        }
      }
    }
  }

  var saltoLinea = "\n\r";
  var coordenadas = "";
  //coords = JSON.stringify(coords);
coords.forEach(function (contenido) {
	coordenadas += contenido + saltoLinea;
})

var array = JSON.parse( coordenadas );


//document.getElementById('respuesta').innerHTML=coordenadas;
//alert(coords);
var tipo = "";
if(arr[0] == 'MULTIPOLYGON'){
  tipo = "MultiPolygon";
}else if('POLYGON'){
  tipo = "Polygon";
}
   var geojsonFeaturePolygon = [
    {
      "type": "Feature",
      "properties": {
      "CODIGO": codigo,
      "ESTADO": estado
     },
     "geometry": {
     "type": tipo,
      "coordinates": array
      }
    }
  ];
 



 
 console.log(geojsonFeaturePolygon);
 
  var polygon = new L.geoJson(geojsonFeaturePolygon, {
    style: stylePolygon
    ,onEachFeature:  function (feature, layer) {		 	
        layer.bindPopup(feature.properties.ESTADO); 
        }  
  }).addTo(map1);


  var baseMaps = {
    "OSM": osmBases
  };

  var overlayMaps = {
    // "Línea": line,
    "Polígono": polygon
  };

  L.control.layers(baseMaps, overlayMaps,{
    position: 'topright', // 'topleft', 'bottomleft', 'bottomright'
    collapsed: false // true
  }).addTo(map1);


}




/*function creaJSONPoligono(string){

}*/
	</script>
	</body>
</html>


<?php


//Leer desde la bd los datos 
require('config.php');


    $sql = "select OGR_FID, AsText(SHAPE) AS poligono, codigo, estado from méxico_estados";
    $r = $conexion -> query($sql);
    while($f = $r -> fetch_array()){
        $id = $f['OGR_FID'];
       // $shape = $f['poligono'];
      // var_dump($shape);
        $codigo = $f['codigo'];
        $estado = $f['estado'];
        //$json = json_encode($shape);
        $geoJson = geoJSON($f['poligono'],$f['codigo'],$f['estado']);
        //echo $geoJson;
        //echo "<script>crearJSONPoligono('".$geoJson ."');</script>";
        echo "<script>crearJSONPoligono('".$f['poligono']."','".$f['codigo']."','".$f['estado']."');</script>";

    }    

    function geoJSON($json,$codigo, $estado) {
     
      $arr = explode("(", $json);
      $coords = "";
      $coords = ' {
        "type": "Feature",
        "properties": {
          "CODIGO": "'.$codigo.'",
          "ESTADO": "'.$estado.'"
        },';
      
    
      $coords =  $coords .' "geometry": {
        "type": "'.$arr[0].'",
        "coordinates": ';
      for($i = 1; $i< sizeof($arr); $i ++){
        //echo 'POS '.$i. 'Contenido '.$arr[$i].'<br>';
        if($arr[$i]==''){
          $coords = $coords. '[';
        }else{
          $coords = $coords. '[';
          $arr2 = explode(")", $arr[$i]);
          for($j=0; $j<sizeof($arr2); $j++){
            //echo 'POSJ '.$j. 'Contenido '.$arr2[$j].'<br>';
           
            if($arr2[$j]==''){
              $coords = $coords. ']';
            }else if($arr2[$j]==','){
              $coords = $coords. '],';
            }else{
              $arr3 = explode(",", $arr2[$j]);
              for($k=0; $k<sizeof($arr3); $k++){
                $coordenada = str_replace (' ',',',$arr3[$k]);
                
                $coords = $coords. '[' . $coordenada . '],';
              }
              $coords = substr($coords, 0, -1); //quita la ultima coma.
            }
          }
        }
      }
      
      $coords = $coords. '}
    }';


      //$string = str_replace (')','',$coords);
      return strval ( $coords );
      
    }
    

?>