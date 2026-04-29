<?php





function NIdVBitacora($consulta){
	require("config.php");
	$sql = "SELECT * FROM contadores WHERE id='0'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
					{
		if ($consulta==TRUE) {
						return $f['IdVBitacora'];
		}
		else
		{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
		// la diferencia entre ceropapel y este, es que cero papel se multiplica
		// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
		$docdigital = $f['IdVBitacora'];
		$docdigitalnew = $docdigital + 1;
		
		
		$sql="UPDATE contadores SET IdVBitacora='".$docdigitalnew."'  WHERE id='0'";
		$resultado = $conexion -> query($sql);
		if ($conexion->query($sql) == TRUE) {
			return $f['IdVBitacora'];
		}
		else {return  FALSE;}
					}
	}
	else
	{ return FALSE;}
}



function BitcoraCount($IdVehiculo){
	require("config.php");
	$sql = "select * from vehiculosbitacoras WHERE Num_economico='".$IdVehiculo."'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
    {
        return $f['Bitacoras'];
    } else {
        return 0;
    }
}

function Vehiculo_Info($IdVehiculo){
	require("config.php");
	$sql = "select * from vehiculos_ WHERE Num_economico='".$IdVehiculo."'";
    //echo $sql;
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
    {
        return $f['Vehiculo'];
    } else {
        return "";
    }
}


function Clave_servicio_to_IdVehiculo($Clave_servicio){
	require("config.php");
	$sql = "select * from vehiculos_bitacora WHERE Clave_servicio='".$Clave_servicio."' limit 1";
    // echo $sql;
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
    {
        return $f['Num_economico'];
    } else {
        return "";
    }
}


function IdResponsableVehiculo($IdVehiculo){
	require("config.php");
	$sql = "select * from vehiculos_  WHERE Num_economico='".$IdVehiculo."'";
    // echo $sql;
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
    {
        return $f['IdResponsable'];
    } else {
        return "";
    }
}

function Vehiculo_table($IdVehiculo){
	require("config.php");
	$sql = "select * from vehiculos_ WHERE Num_economico='".$IdVehiculo."'";
    //echo $sql;
	$rc= $conexion -> query($sql);

	if($f = $rc -> fetch_array())
    {
		$t='<table style="padding:1px; font-size:8px; font-weight: normal;">';
		$t.='<tr><td style="text-align:right; background-color:#E5E5E5;">Num. Economico:</td><td style="text-align:left; background-color:#E5E5E5;">'.$f['Num_economico'].'</td></tr>';		
		$t.='<tr><td style="text-align:right;">Tipo:</td><td style="text-align:left;">'.$f['Tipo'].' Mod.'.$f['Modelo'].'</td></tr>';
		$t.='<tr><td style="text-align:right; background-color:#E5E5E5;">Marca:</td><td style="text-align:left; background-color:#E5E5E5;">'.$f['Marca'].'</td></tr>';		
		$t.='<tr><td style="text-align:right;">Placas:</td><td style="text-align:left;">'.$f['Placas'].'</td></tr>';
		$t.='<tr><td style="text-align:right; background-color:#E5E5E5;">Serie:</td><td style="text-align:left; background-color:#E5E5E5;">'.$f['Serie'].'</td></tr>';
		$t.='<tr><td style="text-align:right;">Cilindraje:</td><td style="text-align:left;">'.$f['Cilindros'].'cil.</td></tr>';
		$t.='<tr><td style="text-align:right; background-color:#E5E5E5;">Color:</td><td style="text-align:left; background-color:#E5E5E5;">'.$f['Color'].'</td></tr>';
		$t.='<tr><td style="text-align:right;">Adscripcion	:</td><td style="text-align:left;">'.$f['Adscripcion'].'</td></tr>';
		$t.='<tr><td style="text-align:center;font-size:8px; font-weight:auto; background-color:#E5E5E5;" colspan="2">'.$f['Comentario'].'</td></tr>';
		$t.='<tr><td style="text-align:right;">Estado	:</td><td style="text-align:left;">'.$f['Estado'].'</td></tr>';
		$t.='</table>';
		
		return $t;


    } else {
        return "";
    }
	
	unset($f);
}
?>