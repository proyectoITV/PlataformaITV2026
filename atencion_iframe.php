<?php

$data = $_GET['data'];	
$fecha = date('Y-m-d');
$hora =  date ("H:i:s");

echo "<span style=' font-size:8pt;
'><b>I T A V U</SPAN></b><BR>";
echo "<span style='font-size:9pt;
'>Tu Turno es :</SPAN><BR>";
echo "<span style='font-size:20pt;
'><B>".$data."</B></SPAN><BR>";
echo "<span style='font-size:6pt;
'><br><br>".$fecha." - ".$hora."</SPAN><BR><br><br>";
echo "<script>  window.print(); </script>";
?>