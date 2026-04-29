<?php

//WIDGET PROTOTIPO

// $nitavu = $_GET['nitavu'];
$Widget_nombre="Control de Turnos";
$Widget_contenido="";

require_once("unica/config.php");
require_once("unica/funciones.php");

$IdDelegacion_dpto = nitavu_dpto($nitavu);

$wc = "<table width=100%><tr><td width=15%>";
$wc = $wc."<span style='font-size:7pt;color:gray;'>Mis Modulos:</span><div id='MisTurnos' >"."</div></td>";
$wc = $wc."<td>";
$wc = $wc. "<table width=100%>";
        $wc = $wc."<tr><td><div id='MiTurnoActual'></div></td></tr>";
        $wc = $wc."<tr><td align=center valign=bottom>
            <div id='MiTurnoBtn' class='btn-azulTam btn'> Tomar</div>
            <div id='MiTurnoBtn2' class='btn-celesteTam btn'>Finalizar</div>
            <div id='MiTurnoBtn3' class='btn-cancel btn'>Auscencia</div>
        
        </td></tr>";
    $wc = $wc."</table>";
    
$wc = $wc."</td></tr>";
$wc = $wc."</table>";
    


$tmp="";
$tmp = $tmp."<section id='aplicaciones' class='widget'>";
$tmp = $tmp. "<label>".$Widget_nombre."</label>";
$tmp = $tmp."<article >";
//$tmp = $tmp. "<a href=''>";
$tmp = $tmp. "<table border='0' width=100%><tr><td>";
$tmp = $tmp.$wc;
$tmp = $tmp. "</td></tr></table></article>";

echo $tmp."</section>";
//echo $tmp."</section>";
?>

<script>
function ShowMisTurnos(str) {
  if (str=="") {
    document.getElementById("MisTurnos").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("MisTurnos").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","atencion_widget_dat1.php?nitavu="+str,true);
  xmlhttp.send();
  ShowMisTurnoActual(str);

}


function ShowMisTurnoActual(str) {
  if (str=="") {
    document.getElementById("MiTurnoActual").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("MiTurnoActual").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","atencion_widget_dat2.php?nitavu="+str,true);
  xmlhttp.send();
}



<?php
echo "setInterval('ShowMisTurnos(".$nitavu.")',1000)";


?>

$( "#MiTurnoBtn" ).click(function() {
  TomarTurno("<?php echo $nitavu; ?>")
});

$( "#MiTurnoBtn2" ).click(function() {
  FinalizarTurno("<?php echo $nitavu; ?>")
});

$( "#MiTurnoBtn3" ).click(function() {
  FinalizarTurnoAuscente("<?php echo $nitavu; ?>")
});

function TomarTurno(Nitavu){   
   $("#preloader").css({'display':'inline-block'});
   $.ajax({
       url: "atencion_widget_dat3.php",
      type: "post",
   //    data: "id="+IdPase, "nitavu=" + Nitavu
      data: {nitavu: Nitavu },
      success: function(data){
       $('#MiTurnoActual').html(data+"\n");
       $("#preloader").css({'display':'none'});
      }
   });
   
}

function FinalizarTurno(Nitavu){   
   $("#preloader").css({'display':'inline-block'});
   $.ajax({
       url: "atencion_widget_dat4.php",
      type: "post",
   //    data: "id="+IdPase, "nitavu=" + Nitavu
      data: {nitavu: Nitavu },
      success: function(data){
       $('#MiTurnoActual').html(data+"\n");
       $("#preloader").css({'display':'none'});
      }
   });
   
}



function FinalizarTurnoAuscente(Nitavu){   
   $("#preloader").css({'display':'inline-block'});
   $.ajax({
       url: "atencion_widget_dat5.php",
      type: "post",
   //    data: "id="+IdPase, "nitavu=" + Nitavu
      data: {nitavu: Nitavu },
      success: function(data){
       $('#MiTurnoActual').html(data+"\n");
       $("#preloader").css({'display':'none'});
      }
   });
   
}

</script>