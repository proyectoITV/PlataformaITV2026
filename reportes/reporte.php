<?php
include ("head.php");


$id_rep = 16; $Tipo = 0; // $Tipo = 1; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
$ClaseDiv  = ""; $ClaseTabla = "stripe row-border order-column responsive nowrap";
$Data =  Reporte($id_rep, $Tipo, $ClaseDiv, $ClaseTabla, $nitavu );





include ("footer.php");
?>