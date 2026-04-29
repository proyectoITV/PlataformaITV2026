<?php include ("./lib/body_head.php");
include ("./lib/body_menu.php"); ?>
<?php

$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap87";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

$CURP="CABO670303MTSRLL01";
$IdPrograma = 0;
HistoriaTramite($CURP, $IdPrograma);




?>
</script>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php include ("./lib/body_footer.php"); ?>
