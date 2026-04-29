<?php
require ("unica/config.php");
if (isset($_GET['id'])){$n = $_GET['id'];}
$sql = " -- co 
SELECT  CONCAT(empleados.profesion_abr,'. ',empleados.nombre ) as nombre,CONCAT(cat_gerarquia.nombre )  as puesto 
FROM cat_gerarquia inner join empleados on cat_gerarquia.titular=empleados.nitavu

WHERE cat_gerarquia.Id=".$n;
  $rc= $conexion -> query($sql);
	 if($f = $rc -> fetch_array())
	 {          
            
        echo "<label for='destinatario'>Destinatario</label>";
        echo "<input type='text' id=destinatario'  name='destinatario' readonly required  value='".$f['nombre']."' >";
       

          
        echo "<label for='puesto'>Puesto</label>";
        echo "<input type='text' id=puesto'  name='puesto'  required  readonly value='".$f['puesto']."' >";
       

   }else
   {
    echo "<label for='destinatario'>Destinatario</label>";
    echo "<input type='text' id=destinatario'  name='destinatario'  required   placeholder='Nombre a quien va dirigido el documento' value='' >";
   

      
    echo "<label for='puesto'>Puesto</label>";
    echo "<input type='text' id=puesto'  name='puesto'  required   placeholder='Puesto de la persona a quien va dirigido el documento'   value='' >";
   }
 
  ?>