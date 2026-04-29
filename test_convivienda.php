<?php
include ("./lib/body_head.php");
include ("./lib/body_menu.php"); 


echo "<hr>";

$sql = "select count(*) as n from Vivienda_Solicitudes ";

echo $sql;
$rc= $Vivienda -> query($sql);
if($f = $rc -> fetch_array())
{
    echo "".$f['n']." Lotes detectados en la tabla lotes<br>";
} else {
    echo "0";
}


// // $sql = "SELECT IdDelegacion, IdPrograma, Folio, IdLote from lotes limit 100";
// // TablaDinamica_Vivienda("",$sql, "MiIdDivTabla2", "IdTabla2", "Modulo", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal



include ("./lib/body_footer.php");
?>