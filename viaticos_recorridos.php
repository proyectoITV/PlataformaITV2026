<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
?>
<?php
$id_aplicacion ="viaticos"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos
//Niveles
// 1 = Crear y Editar
// 2 = Consulta

//Ajusta esta variable para ver el comportamiento


if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    viaticosMenu();
    if ($nivel == 1){
   

    }


    echo "<div id='Resultado' style='margin-top:60px; z-index: 10;'>";

    echo "</div>";
    

}
else {mensaje("No tiene permiso para ver esta aplicacion",'');}	 


?>



<script>
 function BuscarEmpleado(){
		txtq = $("#SearchEmpleado").val();
        
        console.log("buscando " + txtq);
        $('#preloader').show();

            $.ajax({
                url: "viaticos_buscarempleado.php",
            type: "get",        
            data: {q: txtq},
            success: function(data){
                $("#Resultado").html(data+"\n");            
                $('#preloader').hide();
            }
            });
	}

function Distance(){
		
        Origen = $('#LugarOrigen').val();
        Destino = $('#LugarDestino').val();
        
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_dat_distance.php",
            type: "get",        
            data: {Origen:Origen,Destino:Destino},
            success: function(data){
                $("#Distancia").val(data+"");                            
                // $("#Resultado").html(data+"");                            
                $('#progressbar').hide();
            }
            });

           
	}




    function Lats(){
		
        Origen = $('#LugarOrigen').val();
        Destino = $('#LugarDestino').val();
        
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_dat_lats.php",
            type: "get",        
            data: {Origen:Origen,Destino:Destino},
            success: function(data){
                
                $("#R").html(data+"");       
                Maping();                     
                $('#progressbar').hide();
            }
            });

            Maping();
	}

    
function Maping() {
    var map = new google.maps.Map(document.getElementById('gmap'), {	
        zoom: 5,
        center: {lat: 41.876, lng: -87.624
        }
    });


    
    OrigenLat = $('#OrigenLat').val();
    OrigenLon = $('#OrigenLon').val();
    DestinoLat = $('#DestinoLat').val();
    DestinoLon = $('#DestinoLon').val();
    
    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer();
    directionsRenderer.setMap(map);
    const request = {
       origin: new google.maps.LatLng(OrigenLat, OrigenLon),
       destination: new google.maps.LatLng(DestinoLat, DestinoLon),
       travelMode: 'DRIVING'
    };

    directionsService.route(request, response => {
       directionsRenderer.setDirections(response);
    });
    


}

</script>





<script src="lib/fluid/responsive_waterfall.js"></script>
<script src="lib/fluid/app.js"></script>


<!-- Hacer algo de espacio para testear -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>