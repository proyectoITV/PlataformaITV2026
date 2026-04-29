<?php include ("lib/body_head.php");?>
<?php
//este es para que cuando se actualice no cargue otro mas
$Turno = $_GET['data'];	
$Area = $_GET['area'];
echo "<div id='AtencionCiudadana'>";
echo "<div class='centrar_padre'>";
echo "<div class='centrar_hijo' 
style='
    background-color: white;
    width: 50%;
    padding: 10px;
    border-radius: 5px;                
    '
>";     


echo "<span>Tu Turno es: <br><b style='font-size:20pt;'>".$Turno."</b></span>";

echo "<br><hr><a href='atencion.php?app=atencion' class='Mbtn btn-default' title='Crear un Turno'>Volver</a>  ";
echo "</div></div>";
echo "</div>";

echo "<iframe src='atencion_iframe.php?data=".$Turno."' style='display:none;'></iframe>";
?>
<?php include ("lib/body_footer.php");?>