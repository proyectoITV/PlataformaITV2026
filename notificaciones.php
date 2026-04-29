<?php
include ("lib/body_head.php");// Estructura de Plataforma
include ("lib/body_menu.php"); //interfaz de menus



$id_aplicacion ="ap27"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";      

$sql = "select * from notificaciones  where nitavu='".$nitavu."' order by entregar_fecha, id DESC limit 1000";
// echo "<h2>Ultimas mil notificaciones</h2>";

echo "<table class='tabla' style='font-size:10pt;'>";
echo "<th>id</th>";
echo "<th>Fecha</th>";
echo "<th>Notificacion</th>";
echo "<th width=30px align=right>Leida</th>";

$r= $conexion -> query($sql);
while($f = $r -> fetch_array()) {
    if ($f['visto']==1){
        echo "<tr id='".$f['id']."'>";
    } else {
    echo "<tr id='".$f['id']."' style='background-color:yellow;'>";
    }
    
    echo "<td style='font-size:8pt;' width=50px>".$f['id']."</td>";
    echo "<td style='font-size:8pt;' width=50px>".$f['entregar_fecha']."</td>";
    echo "<td><b>".$f['asunto']."</b><br>";
    echo "".$f['contenido']."</td>";
    if ($f['visto']==0){
        echo "<td><button id='btn_".$f['id']."' onclick='Visto(".$f['id'].")'class='btn btn-secondary'><img src='icon/ok.png' style='width:18px;'></button></td>";
    } else {
        echo "<td>"."</td>";
    }
    echo "</tr>";
}

echo "</table>";

// EnviarNotificacion($nitavu,"Test","Contenido de ".$fecha);
?>
<script>
function Visto(IdNotificacion){         
   $("#preloader").show();
   $.ajax({
       url: "notificaciones_data.php",
      type: "post",   
      data: {IdNotificacion:IdNotificacion},
      success: function(data){      
       $('#R').html(data+"\n");
       $("#preloader").hide();
      }
   });
   
}
</script>

<?php
include ("./lib/body_footer.php"); //Cierre de Estructura de la Plaforma
?>