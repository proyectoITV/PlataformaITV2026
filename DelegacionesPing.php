<?php include ("lib/body_head.php");

echo "<div id='contenedor' style='
background-image: url(https://source.unsplash.com/random/1920x1080/?nature,trees,green);
widh:100%; height:100%;
margin:0px;
padding:10px;

'>";
$sql="select * from delegacionesipprivada ";
$r= $conexion -> query($sql);
echo "<table class='tabla Lite' style=' width:50%;' ><th>Delegacion</th><th>Telefono</th><th>Info</th>";
while($f = $r -> fetch_array()) {
    $Ping = DbPing($f['IdDelegacion']);
    if   ($Ping == TRUE){
        echo "<tr>";
    } else {
        echo "<tr style='background-color:red;'>";

    }
    
    echo "<td style='font-size:12pt;'>".$f['Delegacion']."</td>";
    echo "<td>".$f['Telefono']."</td>";
    echo "<td>";

    if ($Ping ==TRUE){
        echo "<img src='icon/ok.png' style='width:15px;'>";
    } else {
        echo "<img src='icon/x.png' style='width:15px;'>";
    }
    echo hora12($hora);
            
            
           
   
    echo "</td>";
    
    echo "</tr>";



}

echo "<tr><td><a href='index.php?home=' style='color:white;' class='Mbtn btn-AzulTam'>Regresar</a></td><td></td><td></td></tr>";

echo "</table>";
echo "</div>";

include ("lib/body_footer.php");
?>
