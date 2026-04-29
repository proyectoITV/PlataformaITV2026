<?php
include ("./lib/body_head.php");
// include ("./lib/body_menu.php");

$Delegacion = nitavu_dpto_nombre($nitavu);	//id de la delegacion de acuerdo con cat_gerarquia
echo "<div id='monitor'>";
    echo "<div id='monitor_turnos'>";
   
    echo "</div>";

    echo "<div id='monitor_slider' >";
        WOWSlider('atencionm','100%','100%');


        
        echo "<table border=0><tr>
        <td align=center valign=center>";
        echo "<div id='monitor_clima'>";
        echo "".ClimaDel(nitavu_dpto($nitavu))."";
        echo "</div>
        </td>";

        echo "<td align=center valign=center>
        <div id='monitor_logo' >";
            echo "<img src='img/logo_copia.png' style='width:90%;'>";
            echo "<br><b style='color: #6e6d6d;
            font-family: Light;
            font-size: 14pt;'>".$Delegacion."</b>";
        echo "</div>
        
        </td></tr></table>";

        

    echo "</div>";








echo "</div>";
?>

<script>
function CargarTurnos(Nitavu){   
   $("#preloader").css({'display':'inline-block'});
   $.ajax({
       url: "atencion_monitor_dat.php",
      type: "post",
   //    data: "id="+IdPase, "nitavu=" + Nitavu
      data: {nitavu: Nitavu },
      success: function(data){
       $('#monitor_turnos').html(data+"\n");
       $("#preloader").css({'display':'none'});
      }
   });
   
}
<?php 
echo "setInterval('CargarTurnos(".$nitavu.")',1000)";
?>
</script>

<?php
include ("./lib/body_footer.php");
?>
