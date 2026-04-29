<?php
include("./lib/body_head.php");
include("./lib/body_menu.php"); 
?>
<div id='miip'></div>


<?php
$Token = MiToken_generate();
$url = "https://plataformaitavu.tamaulipas.gob.mx/ws/ws_ip.php?nitavu=".$nitavu."&token=".$Token."";
echo "<iframe src='".$url."' style='display:none;'></iframe>";

// Recuperar la IP
$ip = RecuperarIPLocal($nitavu);
echo "Tu ip es: ".$ip;
echo "<br>url=".$url;
?>




<?php
include ("./lib/body_footer.php"); ?>