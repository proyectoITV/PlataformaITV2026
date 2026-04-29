<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>


<?php


echo "<br><br>";
$sql = "SELECT * FROM catformapago where IdFormaPago=1";
$rc= $conexion_central -> query($sql); //solo cambia $conexion_central por $conexion para itavu-lib
if($f = $rc -> fetch_array())
{
  echo $f['FormaPago'];
}



echo "<h2>Lista: </h2>";
$sql = "SELECT * FROM catformapago ";
$r= $conexion_central -> query($sql);  
while($f2 = $r -> fetch_array())
{ 
  echo $f2['FormaPago']."<br>";
}













?>






















<!-- Hacer algo de espacio para testear -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>