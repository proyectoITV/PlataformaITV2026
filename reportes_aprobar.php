<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php");  ?>
<?php
require("config.php");
$id_aplicacion = 'ap50';
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap50"; //ap07=Permisos de Aplicacion
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (soytitular($nitavu) <> 'FALSE'){

  $idReporte = $_GET['id'];
  $solicita = $_GET['solicita'];
    
  echo "<div>";
  // echo "<h3> Visualización del Reporte </h3>";
  echo "<table style='width:100%; height: 100%;'>";
  echo "<td valign=top >";
  echo "<iframe id='frame' name='frame' src='reporte.php?id=".$idReporte."&nitavu=".$nitavu."&previsualizar='1'' style='width:100%;height:97%;border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
  echo "</td>";
  echo "<td style='vertical-align: top;' width=30px>";
  echo "<form action='reporteador.php' method='POST'>";
  echo "<input type='hidden' value='".$idReporte."' name='ap1'>";
  echo "<input type='hidden' value='".$solicita."' name='solicita'>";
  echo "<br>";
  echo "<button type='submit' style='margin-top:0%;' class='Mbtn btn-default' title='Otorgar permiso de publicar el reporte'> <img src='icon/permiso.png' style='width:30px; '> </button>"; 
  echo "</form>";
  echo "<form action='reporteador.php' method='POST'>";
  echo "<input type='hidden' value='".$idReporte."' name='ap2'>";
  echo "<input type='hidden' value='".$solicita."' name='solicita'>";
  echo "<br>";
  echo "<button type='submit' style='margin-top:0%;' class='Mbtn btn-default' title='Declinar permiso de publicar el reporte'> <img src='icon/eliminar.png' style='width:30px; '> </button>"; 
  echo "</form>";

  $archivo = "fotos/".$solicita.".jpg";
  echo "<span style='font-size:10pt;'><br><br> Solicitante: <br> ".ponerfoto($archivo,'imagenPermiso')."<p style='font-size:10px'><b>".nitavu_nombre($solicita)."</b> de ".nitavu_dpto_nombre($solicita);
  echo "<br><br>Ext. <b>".nitavu_tel_ext($solicita)."</b>";
  echo "</span>";


  echo "</td>";
  echo "</table>";
  echo "</div>";

}else{
  mensaje('ERROR: No tiene permiso', 'index.php');
}
?>

<?php include ("./lib/body_footer.php"); ?>