<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");
  

    $Origen = VarClean($_POST['Origen']);
    $Destino = VarClean($_POST['Destino']);
    $sql = "select * from viaticosrecorridos WHERE Origen='".$Origen."' and Destino='".$Destino."' order by fecha DESC limit 1";	
	
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
        echo "<script>
        
        
            $('#Distancia').val(".$f['Distancia'].");
            </script>
        ";
        Toast("Se encontro un recorrido ".$Origen." ~ ".$Destino." usado el ".$f['fecha']." en el Viatico ".$f['IdViatico'],5,"");
		
	}  else {
                Toast("No se encontro distancia guardada de ".$Origen." ~ ".$Destino,1,"");
    }

?>