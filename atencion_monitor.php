<?php
include ("./lib/body_head.php");
// include ("./lib/body_menu.php");
$id_aplicacion ="atencionm"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
if (isset($_GET['admin'])){
    $Delegacion = CATgerarquia_nombre($_GET['admin']);
} else {
    $Delegacion = nitavu_dpto_nombre($nitavu);	//id de la delegacion de acuerdo con cat_gerarquia
}

echo "<div id='monitor'>";
    echo "<div id='monitor_turnos'>";
   
    echo "</div>";

    echo "<div id='monitor_slider' >";
        wowslider('atencionp','100%','100%');


        
        echo "<table border=0><tr>
        <td align=center valign=center>";
        echo "<div id='monitor_clima'>";
        if (isset($_GET['admin'])){
            echo "".ClimaDel($_GET['admin'])."";
        } else {
            echo "".ClimaDel(nitavu_dpto($nitavu))."";

        }
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
} else {
    mensaje("ERROR: no tiene acceso a esta aplicacion","");
}
?>

<script>
function CargarTurnos(Nitavu, Admin){   
   $("#preloader").css({'display':'inline-block'});
   $.ajax({
       url: "atencion_monitor_dat.php",
      type: "post",
   //    data: "id="+IdPase, "nitavu=" + Nitavu
      data: {nitavu: Nitavu, admin: Admin },
      success: function(data){
       $('#monitor_turnos').html(data+"\n");
       $("#preloader").css({'display':'none'});
      }
   });
   
}
<?php 
if (isset($_GET['admin'])){
    echo "setInterval(CargarTurnos(".$nitavu.",'".$_GET['admin']."'),1000)";
}else {
    echo "setInterval(CargarTurnos(".$nitavu.",''),1000)";
}
?>
</script>

<?php
include ("./lib/body_footer.php");
?>
