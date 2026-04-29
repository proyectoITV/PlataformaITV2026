
<?php

if ( isset($_GET['token']) ) {
    if ($_GET['token'] <> 'AKYN4T0M'){
        header("Refresh: 0; URL='index.php'");
    } else {
        // header("Refresh: 600; URL='mantenimientoprogramado.php?unlimited=1&r=60'");
    }
} else {
    header("Refresh: 0; URL='index.php'");
}

require("config.php");
require("lib/funciones.php");
require("lib/flor_funciones.php");
ini_set('max_execution_time', 0);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="1200"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento</title>
    <!-- <script src="lib/jquery-3.3.1.min.js"></script>  -->
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.js"></script> 
    
    <style>
    @font-face{font-family:"Regular";src:url("lib/HelveticaNeueLTStd-Lt.otf") format("truetype")}
    @font-face{font-family:"Light";src:url("lib/OpenSans-Light.ttf") format("truetype")}
    @font-face{font-family:"ExtraBold";src:url("lib/HelveticaNeueLTStd-Bd.otf") format("truetype")}
    @font-face{font-family:"Compacta";src:url("lib/Abel-Regular.ttf") format("truetype")}
    @font-face{font-family:"Garigoleada";src:url("lib/Windsong.ttf") format("truetype")}
    @font-face{font-family:"Pizarra";src:url("lib/CFCrayons-Regular.ttf") format("truetype")}
    @font-face{font-family:"Bold";src:url("lib/OpenSans-ExtraBold.ttf") format("truetype")}
    body {
        background-color: black;
        color: aqua;
        font-family:"Light";
        margin:0px;
    }
    h1{
        background-color:
        #323532;
        color:
        white;
        margin: 0px;
        text-align: center;
        text-transform: uppercase;
        font-size: 17pt;
        padding: 4px;
    }
    section{
        width:100%;
    }

    article{
        width: 33%;
        background-color:
        rgba(255, 255, 255, 0.1);
        margin: 5px;
        display: inline-block;
        border-style: dashed;
        border-width: 1px;
        border-color:
        #353333;
        color:
        #65a83f;
        vertical-align:top;
            }
            h2{
                font-size: 13pt;
        color:
        orange;
        text-transform: uppercase;
        text-align: center;
        margin: 0px;
            }
            .modulo{
                width:100%;
                padding:0px;
                margin:0px;
            }
            .Loader{
                width:100%;
                text-aling:center;
                padding:10px;
                color:purple;
                
            }
    </style>
</head>
<body>
<script>
function Tarea1(){   
   $("#Loader1").show();
   $.ajax({
       url: "mantenimiento_tarea1.php",
      type: "post",   
      data: {},
      success: function(data){
       $('#Tarea1').html(data+"\n");
       $("#Loader1").hide();
      }
   });
   
}


function Tarea2(){   
   $("#Loader2").show();
   $.ajax({
       url: "mantenimiento_tarea2.php",
      type: "post",   
      data: {},
      success: function(data){
       $('#Tarea2').html(data+"\n");
       $("#Loader2").hide();
      }
   });
   
}



function Tarea3(){   
   $("#Loader2").show();
   $.ajax({
       url: "mantenimiento_tarea3.php",
      type: "post",   
      data: {},
      success: function(data){
       $('#Tarea3').html(data+"\n");
       $("#Loader3").hide();
      }
   });
   
}


// function Tarea4(){   
//    $("#Loader2").show();
//    $.ajax({
//        url: "mantenimiento_tarea4.php",
//       type: "post",   
//       data: {},
//       success: function(data){
//        $('#Tarea4').html(data+"\n");
//        $("#Loader4").hide();
//       }
//    });
   
// }



// function Tarea5(){   
//    $("#Loader2").show();
//    $.ajax({
//        url: "mantenimiento_tarea5.php",
//       type: "post",   
//       data: {},
//       success: function(data){
//        $('#Tarea5').html(data+"\n");
//        $("#Loader5").hide();
//       }
//    });
   
}
Tarea1();
Tarea2();
Tarea3();

//Inahibilidas por ahora
// Tarea4();
// Tarea5();


</script>
    
<h1>Mantenimiento Programado de la Plataforma</h1>
    <section>
        <article>
            <h2>Notificaciones de tickets </h2>        
            <div id='Loader1' class='Loader'> Cargando...   </div>
            <div id='Tarea1' class='modulo'>

            </div>
            
        
        </article>


        <article>
            <h2>Reenvio de</h2>        
            <div id='Loader2' class='Loader'> Cargando...   </div>
            <div id='Tarea2' class='modulo'>

            </div>
            
        
        </article>

        <article>
            <h2>Mantenimiento de Sessiones</h2>        
            <div id='Loader3' class='Loader'> Cargando...   </div>
            <div id='Tarea3' class='modulo'>

            </div>
            
        
        </article>
<!-- 

        <article>
            <h2>Recalcular Estadistica de Programas Diario</h2>        
            <div id='Loader4' class='Loader'> Cargando...   </div>
            <div id='Tarea4' class='modulo'>

            </div>
            
        
        </article> -->



<!--         
        <article>
            <h2>Resumen de Ticket por la Tarde (5.10 a 7.00pm) </h2>        
            <div id='Loader5' class='Loader'> Cargando...   </div>
            <div id='Tarea5' class='modulo'>

            </div>
            
        
        </article> -->
        
    </section>
    
</body>
</html>
