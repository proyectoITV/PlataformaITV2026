<?php 
// require("seguridad.php");
require("config.php"); require("funciones.php"); 



session_start();
// echo "Tiempo de la session: ".SESSION_tiempo(session_id())." | ";
echo SESSION_tiempoRound(session_id());
//echo session_id();


?>