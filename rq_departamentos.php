<?php
require ("config.php");
if(isset($_GET['id'])){
$id = $_GET['id'];

if (!empty($_GET['id'])) {
    

if($id==19)
{
    $sql = "select * from cat_gerarquia where dependencia in(
        select id from cat_gerarquia where id in 
        (select id  from cat_gerarquia as cgg where (cgg.id in(select cat_gerarquia.id from cat_gerarquia where dependencia=" .$id." or id=".$id.")))) 
        union select * from cat_gerarquia where (id =".$id."  or dependencia=21 )order by nombre ";  
}else{


$sql = "select * from cat_gerarquia where dependencia in(
        select id from cat_gerarquia where id in 
        (select id  from cat_gerarquia as cgg where (cgg.id in(select cat_gerarquia.id from cat_gerarquia where dependencia=" .$id." or id=".$id.")))) 
        union select * from cat_gerarquia where id =".$id." order by nombre ";     
}  
$r = $conexion -> query($sql);
echo "<div>";

echo "<label for='colonia'>";
    echo "<select id='iddepartamento' name='iddepartamento' >";
    echo "<option value='' selected>Seleccione un departamento...</option>";
        
        while($f = $r -> fetch_array()){ // resultado de la busqueda.................
           
            echo "<option value='".$f['id']."'>".$f['nombre']."</option>";
        }
    
    echo "</select>";
echo "</label>";
echo "</div>";
    }
}

?>





