<?php header('Content-Type: application/json');?>
<script>
// Set up global variable
var result='[{"lat":23.7412207,"lang":-99.1566962,"ac":4166}]';
 
     function showPosition(){    
     // If geolocation is available, try to get the visitor's position
        if(navigator.geolocation)
        {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
                            
        }
        else
        {
            alert("Sorry, your browser does not support HTML5 geolocation.");
        }
     };
            
    // Define callback function for successful attempt
    function successCallback(position){       
        var latitud = position.coords.latitude;
        var longitud = position.coords.longitude;        	
        var exactitud = position.coords.accuracy;	

      

    

        list = [];
        list.push({
            "lat": latitud,
            "lang": longitud,
            "ac":exactitud
        });
        list;
        result = JSON.stringify(list);
        
        document.write(result) ;
       console.log(result);
    }
    
    // Define callback function for failed attempt
    function errorCallback(error){
        
        if(error.code == 1){
            result = "You've decided not to share your position, but it's OK. We won't ask you again.";
        } else if(error.code == 2){
            result= "The network is down or the positioning service can't be reached.";
        } else if(error.code == 3){
            result = "The attempt timed out before it could get the location data.";
        } else{
            result = "Geolocation failed due to unknown error.";
        }
       
    }

    // window.onload = showPosition();  
    
</script>

<?php
ob_end_clean();
?>

<script>
    
</script>

