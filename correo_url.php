
<?php 	//require("seguridad.php"); ?>
<?php 	require("lib/funciones.php"); ?>
<?php 	require("lib/cano_funciones.php"); ?>
<?php 	require("lib/laura_funciones.php"); ?>
<?php 	require("lib/yes_funciones.php"); ?>
<?php 	require("config.php"); ?>


<?php
//FUNCION PARA RECIBIR NOTIFICACIONES DESDE VB6 MEDIANTE URL
if (isset($_GET['destino']) and isset($_GET['contenido']) and isset($_GET['origen']) and isset($_GET['asunto'])){      
    $destino= $_GET['destino'];
    $origen = $_GET['origen'];
    $asunto = $_GET['asunto'];
    
    //$encabezado ="<img src=".$urlsite."/img/logo_copia.png>"



    $firma="<br><br><br><a href=https://plataformaitavu.tamaulipas.gob.mx><img width=40% src=".$urlsite."/icon/correo_firma.png></a><br>";
    $firma=$firma."<b>".nitavu_nombre($origen)."</b><br>".nitavu_puesto($origen)." de ".nitavu_dpto_nombre($origen);
    $firma=$firma."<br>Tel. ".nitavu_tel($origen)." Ext.".nitavu_tel_ext($origen);
    $contenido = $_GET['contenido']."".$firma;

    //correo(nitavu_correo($nitavu), nitavu_nombre($nitavu), $quien, $quien_nombre, $asunto, $contenido, $nitavu);
    notificacion_add ($destino, $asunto, $fecha, $origen, $contenido);


}

?>
