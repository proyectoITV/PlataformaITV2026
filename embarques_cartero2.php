
<?php
require ("config.php");
require ("lib/funciones.php");

if (isset($_GET['user']) and isset($_GET['dpto'])){

		echo "<select name='cartero2' >";
			$sql="select nitavu, nombre from empleados where estado='' and dpto='".$_GET['dpto']."'";
			$r2 = $conexion -> query($sql);
			echo "<option value=''>¿Quien mas entregara?</option>";
			while($f = $r2 -> fetch_array())		
            {
                if ($_GET['user']==$f['nitavu']){// si ya esta seleccionado, que lo recibimos por get user, ya no ponerlo en la lista

                } else {
                    echo "<option value='".$f['nitavu']."'>".$f['nombre']."</option>";	
                }
            
            }
			
			
		echo "</select>";	

}

// if ($n<=0)
//     {echo "<div id='misnotificaciones' class='notifi_cero'>".$n."</div>";}
// else
// 	{echo "<div id='misnotificaciones' class='notifi_activas'>".$n."</div>";}

?>

