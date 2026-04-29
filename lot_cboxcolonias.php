<?php
require ("config.php");

if(isset($_GET['id'])){
$id = $_GET['id'];
$idcol = $_GET['idcol'];

$sql = "SELECT * from catcolonia WHERE IdMunicipio = ".$id." and Colonia is not null and Cancelado=0  ORDER BY Colonia ASC";



$r = $Vivienda -> query($sql);

    if($idcol==0)
    {
        echo "<select id='IdColonia' name='IdColonia' style='margin-left: 0px;'  onchange='validarCampos()' >"; 
        echo '<option value="0">SELECCIONE UNA OPCION...</option>';      
        while($f = $r -> fetch_array()){ 
            echo "<option value='".$f['IdColonia']."'>".$f['Colonia']."</option>";
        }
        echo "</select>";
    }
    else
    {
        //editar
        echo "<select id='IdColonia' name='IdColonia' style='margin-left: 0px;' disabled >"; 
          
        while($f = $r -> fetch_array()){   
            echo '<option value="0">SELECCIONE UNA OPCION...</option>';  
            if ($idcol==$f['IdColonia']){             
             echo "<option value='".$f['IdColonia']."' selected='selected' >".$f['Colonia']."</option>";
            }else
            {
                echo "<option value='".$f['IdColonia']."'>".$f['Colonia']."</option>";
            }
        }
        echo "</select>";

      

    }
    
  


}




?>