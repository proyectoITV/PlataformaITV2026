<html>
<head> 
    <meta charset="UTF-8">
    <title>Prueba Leaflet</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
 	<style> 
  	#map {
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
	<script>
	var map = L.map('map', {
		center: [31.9655702,-102.147767],
		zoom: 4,
		});
 
	L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);
 
		// var geojson = [{
		// "type": "Feature",
		//  	"geometry": {
		//    		"type": "Polygon",
		//    		 "coordinates":[[
		// 	    	[-5.6659, 40.9641],
		// 			[-5.6664, 40.9669],
		// 			[-5.6616, 40.9660],
		// 			[-5.6611, 40.9637],
		// 			[-5.6659, 40.9641]
		// 		]]
		// 	       },
		// 	"properties": {
		//  		"name": "Mi Poligono",
		//  		 "title": "Plaza Mayor"
		// 		  }
		// 	}
		//  	      ];
 
 
		/* coords = []; 
		
			var puntos = L.geoJSON(datos, {
				pointToLayer: function (feature, latlng) {
						return L.marker(latlng);
					},	
				onEachFeature:  function (feature, layer) {
					console.log(feature.geometry.coordinates);
	            coords.push(feature.geometry.coordinates);
				}				
			});
		
		map.addLayer(puntos); */
	
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

	</script>
	</body>
</html>

