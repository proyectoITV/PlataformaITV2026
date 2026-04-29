<?php
require ("config.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT * FROM localidad WHERE IdMunicipio = ".$id." ORDER BY Nombre_Localidad ASC";
    $r = $Vivienda -> query($sql);
    
    echo '<datalist id="localidades">';
    while($f = $r -> fetch_array())
    { 
        echo "<option value='".$f['Nombre_Localidad']."'>";
    }
    echo '</datalist>';
   

}




?>