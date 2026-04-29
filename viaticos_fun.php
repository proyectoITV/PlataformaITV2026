<?php


function NIdViatico($consulta){
	require("config.php");
	$sql = "SELECT * FROM contadores WHERE id='0'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
					{
		if ($consulta==TRUE) {
						return $f['IdViatico'];
		}
		else
		{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
		// la diferencia entre ceropapel y este, es que cero papel se multiplica
		// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
		$docdigital = $f['IdViatico'];
		$docdigitalnew = $docdigital + 1;
		
		
		$sql="UPDATE contadores SET IdViatico='".$docdigitalnew."'  WHERE id='0'";
		$resultado = $conexion -> query($sql);
		if ($conexion->query($sql) == TRUE) {
			return $f['IdViatico'];
		}
		else {return  FALSE;}
					}
	}
	else
	{ return FALSE;}
}



function NIdReintegro($consulta){
	require("config.php");
	$sql = "SELECT * FROM contadores WHERE id='0'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
					{
		if ($consulta==TRUE) {
						return $f['IdReintegro'];
		}
		else
		{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
		// la diferencia entre ceropapel y este, es que cero papel se multiplica
		// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
		$docdigital = $f['IdReintegro'];
		$docdigitalnew = $docdigital + 1;
		
		
		$sql="UPDATE contadores SET IdReintegro='".$docdigitalnew."'  WHERE id='0'";
		$resultado = $conexion -> query($sql);
		if ($conexion->query($sql) == TRUE) {
			return $f['IdReintegro'];
		}
		else {return  FALSE;}
					}
	}
	else
	{ return FALSE;}
}



function viaticosMenu(){
	//$midir=quienEsmiDireccion(nitavu_dpto($nitavu));
	//echo'<div><p><h2>'. quienEsmiDireccion(nitavu_dpto($nitavu)).'</h2></p></div>	
	
	echo '<br>';
	echo '<br>';
	echo '<br>';
	/*
	echo '
	<nav class="navbar navbar-expand-lg navbar-light " style="
	position: fixed;
	width: 100%;
	margin-top: -11px;
	z-index: 1000;
	background-color:#ffffff4a;
	">
	<br>;
	<br>;
	<br>;
	<br>;
	<br>;
	<br>;	
	<br>
	
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>	
	
	<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0">                
		
			<li class="nav-item">
				<a class="nav-link" href="#"></a>
			</li>
		</ul>
		<div class="form-inline my-2 my-lg-0" style="
			background-color: #ECD39F;
			padding: 5px;
			border-radius: 6px;
			margin-right: -12px;
			width:70%;
			border: solid #54565a 1px;
		
		">
			<input class="form-control mr-sm-2" type="search" placeholder="" id="SearchEmpleado" >
			<small id="SearchEmpleado" class="form-text text-muted" style="font-size: 9pt;
            margin-top: -2px;">Busque el empleado para realizar trámite (Num. empleado, nombre)</small>
			<p align="right"><button class="btn btn-danger my-2 my-sm-0" onclick="BuscarEmpleado();"  >Buscar</button></p>
			
		</div>
	</div>
	</nav>
';*/
echo '<center><div class="form-inline my-2 my-lg-0" style="
background-color: #ffffffb0;
padding: 5px;
border-radius: 6px;
margin-right: -12px;
width:70%;
border: solid #c1c1c1 1px;
">
<input class="form-control mr-sm-2" type="search" placeholder="" id="SearchEmpleado" >
<small id="SearchEmpleado" class="form-text text-muted" style="font-size: 9pt;
margin-top: -2px;">Busque el empleado para realizar trámite (Num. empleado, nombre)</small>
<p align="right"><button class="btn btn-danger my-2 my-sm-0" onclick="BuscarEmpleado();"  >Buscar</button></p>

</div></center>';

}

function getDistance($addressFrom, $addressTo, $unit='K'){
	require("config.php");
    //Change address format
    $formattedAddrFrom = str_replace(' ','+',$addressFrom);
    $formattedAddrTo = str_replace(' ','+',$addressTo);


    //Send request and receive json data
    $geocodeFrom = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$key_directions);
    $outputFrom = json_decode($geocodeFrom);
    
	$geocodeTo = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$key_directions);
    $outputTo = json_decode($geocodeTo);
    

    
	$ErrorGoogle = $latitudeFrom = $outputFrom->error_message;
	// var_dump($ErrorGoogle);
	if ($ErrorGoogle == ''){

			// Get latitude and longitude from geo data
			$latitudeFrom = $outputFrom->results[0]->geometry->location->lat;
			$longitudeFrom = $outputFrom->results[0]->geometry->location->lng;
			$latitudeTo = $outputTo->results[0]->geometry->location->lat;
			$longitudeTo = $outputTo->results[0]->geometry->location->lng;
			
			//Calculate distance from latitude and longitude
			$theta = $longitudeFrom - $longitudeTo;
			$dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
			$dist = acos($dist);
			$dist = rad2deg($dist);
			$miles = $dist * 60 * 1.1515;
			$unit = strtoupper($unit);
			// if ($unit == "K") {
			//     return ($miles * 1.609344).' km';
			// } else if ($unit == "N") {
			//     return ($miles * 0.8684).' nm';
			// } else {
			//     return $miles.' mi';
			// }

			if ($unit == "K") {
				return ($miles * 1.609344).'';
			} else if ($unit == "N") {
				return ($miles * 0.8684).'';
			} else {
				return $miles.'';
			}
		} else {
			return "ERROR: ".$ErrorGoogle;
		}
    

// $addressFrom = 'Victoria, Tamaulipas';
// $addressTo = 'Tampico, Tamaulipas';
// $distance = getDistance($addressFrom, $addressTo, "K");
// echo "Distancia entre ".$addressFrom." a ".$addressTo." = ".$distance."km";
}




function getOrigenLat($addressFrom, $addressTo, $unit='K'){
	require("config.php");
    $formattedAddrFrom = str_replace(' ','+',$addressFrom);
    $formattedAddrTo = str_replace(' ','+',$addressTo);
    $geocodeFrom = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$key_directions);
    $outputFrom = json_decode($geocodeFrom);
    $geocodeTo = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$key_directions);
    $outputTo = json_decode($geocodeTo);
    

	
    
	$ErrorGoogle = $geocodeFrom = $outputFrom->error_message;
	// var_dump($ErrorGoogle);
	if ($ErrorGoogle == ''){

	
  
		$latitudeFrom = $outputFrom->results[0]->geometry->location->lat;
		return $latitudeFrom;
	} else {
		return "";
	}

    // $longitudeFrom = $outputFrom->results[0]->geometry->location->lng;
    // $latitudeTo = $outputTo->results[0]->geometry->location->lat;
    // $longitudeTo = $outputTo->results[0]->geometry->location->lng;
    
    
}


function getOrigenLon($addressFrom, $addressTo, $unit='K'){
	require("config.php");
    $formattedAddrFrom = str_replace(' ','+',$addressFrom);
    $formattedAddrTo = str_replace(' ','+',$addressTo);
    $geocodeFrom = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$key_directions);
    $outputFrom = json_decode($geocodeFrom);
    $geocodeTo = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$key_directions);
    $outputTo = json_decode($geocodeTo);

	
    
	$ErrorGoogle = $geocodeFrom = $outputFrom->error_message;
	// var_dump($ErrorGoogle);
	if ($ErrorGoogle == ''){

    
    $longitudeFrom = $outputFrom->results[0]->geometry->location->lng;
		return $longitudeFrom;
	} else {
		return "";
	}

    
    // $latitudeTo = $outputTo->results[0]->geometry->location->lat;
    // $longitudeTo = $outputTo->results[0]->geometry->location->lng;
    
    
}



function getDestinoLat($addressFrom, $addressTo, $unit='K'){
	require("config.php");
    $formattedAddrFrom = str_replace(' ','+',$addressFrom);
    $formattedAddrTo = str_replace(' ','+',$addressTo);
    $geocodeFrom = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$key_directions);
    $outputFrom = json_decode($geocodeFrom);
    $geocodeTo = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$key_directions);
    $outputTo = json_decode($geocodeTo);
    
    	
    
	$ErrorGoogle = $geocodeFrom = $outputFrom->error_message;
	// var_dump($ErrorGoogle);
	if ($ErrorGoogle == ''){
		
    	$latitudeTo = $outputTo->results[0]->geometry->location->lat;
    	// $longitudeTo = $outputTo->results[0]->geometry->location->lng;
    	return $latitudeTo;
	} else {return "";}
    
}


function getDestinoLon($addressFrom, $addressTo, $unit='K'){
	require("config.php");
    $formattedAddrFrom = str_replace(' ','+',$addressFrom);
    $formattedAddrTo = str_replace(' ','+',$addressTo);
    $geocodeFrom = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$key_directions);
    $outputFrom = json_decode($geocodeFrom);
    $geocodeTo = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$key_directions);
    $outputTo = json_decode($geocodeTo);
    
    
      
	$ErrorGoogle = $geocodeFrom = $outputFrom->error_message;
	// var_dump($ErrorGoogle);
	if ($ErrorGoogle == ''){
		$longitudeTo = $outputTo->results[0]->geometry->location->lng;
		return $longitudeTo;
	} else {
		return "";
	}
    
}

function DataLis_DelegacionesDomicilios(){
	require ("config.php");
    $sql = "
    select * from cat_delegaciones where domicilio <> ''
	";
	// var_dump($conexion);
    $r= $conexion -> query($sql);
    $IdColores = "";
	echo '<datalist id="DelegacionesDomicilios">';
	
	
    while($f = $r -> fetch_array()) {
		echo '<option value="'.$f['domicilio'].'">';

    }
	echo '</datalist>';
	$IdColores = substr($IdColores, 0, -1); //quita la ultima coma.
	return $IdColores;
}



function DataLis_Origenes(){
	require ("config.php");
    $sql = "
	select DISTINCT Origen as Lugar from viaticosrecorridos
	";
	// var_dump($conexion);
    $r= $conexion -> query($sql);
    $IdColores = "";
	echo '<datalist id="ListOrigenes">';
	
	
    while($f = $r -> fetch_array()) {
		echo '<option value="'.$f['Lugar'].'">';

    }
	echo '</datalist>';
	
}



function DataLis_Destinos(){
	require ("config.php");
    $sql = "
	select DISTINCT Destino as Lugar from viaticosrecorridos
	";
	// var_dump($conexion);
    $r= $conexion -> query($sql);
    $IdColores = "";
	echo '<datalist id="ListDestinos">';
	
	
    while($f = $r -> fetch_array()) {
		echo '<option value="'.$f['Lugar'].'">';

    }
	echo '</datalist>';
	
}


function viaticosIn($IdViatico, $NEmpleado, $nitavu){
	require("config.php");
	$dir=quienEsmiDireccion(nitavu_dpto($NEmpleado));

// // //7.- Se valida si esta dado de alta el presupuesto para esa direccion
//$iddireccion=quienEsmiDireccion(nitavu_dpto($NEmpleado));
EstaDadoAltaUnPresupuesto($dir);

if(EstaDadoAltaUnPresupuesto($dir)=="si")
{
    $Go = TRUE;
 }else
 {     $Go = FALSE;
   
//     $sql3="UPDATE viaticos SET estatus=8 WHERE IdViatico='".$IdViatico."'";
//     echo $sql3;

//     if ($conexion->query($sql3) == TRUE) {
      //  Toast("No Esta dado de alta un presupuesto para esa direccion ",5,"");
      echo "
                                                        <script>
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'ERROR',
                                                            text: 'No esta dado de alta un presupuesto para esa direccion',
                                                            timer: 7000,
                                                            footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
                                                        });
														location.href ='viaticos.php';
                                                        </script>
                                                        ";
        return;
//        // echo "No Existe Presupuesto ";
//     }

 }


// if(PuedeHacerMasViaticos($NEmpleado)!='' and PuedeHacerMasViaticos($NEmpleado)>0)
// {
// 	echo "
// 	<script>
// 	Swal.fire({
// 		icon: 'error',
// 		title: 'ERROR',
// 		text: 'Tiene un viatico ya en proceso',
// 		timer: 5000,
// 		footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
// 	});
// 	location.href ='viaticos.php';
// 	</script>
// 	";
// return;
// }

// if(PuedeHacerMasViaticos($NEmpleado)!='' and PuedeHacerMasViaticos($NEmpleado)>0)
// {
// 	echo "
// 	<script>
// 	Swal.fire({
// 		icon: 'error',
// 		title: 'ERROR',
// 		text: 'Tiene un viatico ya en proceso',
// 		timer: 5000,
// 		footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
// 	});
// 	location.href ='viaticos.php';
// 	</script>
// 	";
// return;
// }
if(viaticosnocomprobados($NEmpleado)!='' and viaticosnocomprobados($NEmpleado)>0)
{
	echo "
	<script>
	Swal.fire({
		icon: 'error',
		title: 'ERROR',
		text: 'NO puede realizar un nuevo viatico, tiene viaticos que al parecer no han sido comprobados',
		timer: 5000,
		footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
	});
	location.href ='viaticos.php';
	</script>
	";
return;
}


 $estatus=0;
	$oficio=generaroficio_viatico($dir,true);	
	if ( EstoyenDelegacion($nitavu) =='del'){
		$estatus=0;
	}
	$sql = "INSERT INTO viaticos(IdViatico, NEmpleado, CapturaFecha, CapturaNitavu, NOficio,estatus) 
            VALUES ('".$IdViatico."', '".$NEmpleado."', '".$fecha."','".$nitavu."','$oficio'".", '".$estatus."')";
     //echo $sql;

    if ($conexion->query($sql) == TRUE){ 

		$oficio=generaroficio_viatico($dir,false);	
		$sql2="INSERT INTO viaticosseguimiento(IdViatico,IdSegViatico,IdEstatus,FechaCrea,NitavuCrea,Observaciones)VALUES($IdViatico,1,$estatus,NOW(),$nitavu,'');";
		//echo $sql2;
		if ($conexion->query($sql2) == TRUE){ 
		
		echo "<script>console.log('".$sql2."');</script>"; 
		historia($nitavu,"[viaticos] = Registro un Viatico para el No. de Empleado ".$NEmpleado." con IdViatico=".$IdViatico);	
	    }




        return TRUE;
    } else {
        return FALSE;
    }
	
	
}

function generaroficio_viatico($id,$consulta){
	require("config.php");
	$sql = "SELECT * FROM viaticosadmin WHERE iddireccion='$id'";
	//echo $sql;
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		if ($consulta==TRUE) {
			$numero = $f['consecutivodir'];
			
			$numeroConCeros = str_pad($numero, 6, "0", STR_PAD_LEFT);
			
				return $f['siglas']."ITV".$numeroConCeros;
		}
		else
		{ // sino es consulta entonces aumentarle y aumentar el consecutivo
			
			$n2 = $f['consecutivodir'] + 1;
			//$n2 = $f['npase_idenficador'].$n2;
			$sql="UPDATE viaticosadmin SET consecutivodir='".$n2."' WHERE iddireccion='$id'";
			$resultado = $conexion -> query($sql);
			if ($conexion->query($sql) == TRUE) {
				return $n2 ;
			}else {return  FALSE;}
		}
	}
	else
	{ return FALSE;}
}

function viaticos_Oficio($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticosfull WHERE IdViatico='".$IdViatico."'";	
	 //echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['NOficio']."";
	}  else {
        return  "";
    }

}

function viaticos_Status($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticosfull WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['Activa']."";
	}  else {
        return  "";
    }

}

function viaticos_TipoTransporte($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticos WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['TipoTransporte']."";
	}  else {
        return  "";
    }

}
function viaticos_TipoTransporteR($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticos WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['TipoTransporteR']."";
	}  else {
        return  "";
    }

}
function viaticos_SalidaFecha($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticosfull WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['SalidaFecha']."";
	}  else {
        return  "";
    }

}


function viaticos_SalidaHora($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticosfull WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['SalidaHora']."";
	}  else {
        return  "";
    }

}


function viaticos_RegresoFecha($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticosfull WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['RegresoFecha']."";
	}  else {
        return  "";
    }
}


function viaticos_SalidaDiaFecha($IdViatico){
	require("config.php");
	
	$sql = "select SalidaFecha  from viaticosfull WHERE IdViatico='".$IdViatico."'";	
	//echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return date_format( date_create($f['SalidaFecha']), 'd');
	}  else {
        return  "";
    }

}

function viaticos_RegresoDiaFecha($IdViatico){
	require("config.php");
	
	$sql = "select RegresoFecha  from viaticosfull WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return date_format( date_create($f['RegresoFecha']), 'd');
	}  else {
        return  "";
    }

}

function viaticos_RegresoMesFecha($IdViatico){
	require("config.php");
	
	$sql = "select RegresoFecha  from viaticosfull WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{ 
		setlocale(LC_TIME, "spanish");
		$fecha = $f['RegresoFecha'];
		$fecha = str_replace("/", "-", $fecha); 
		$newDate = date("d-m-Y", strtotime($fecha)); 
		$mesDesc = strftime("%B", strtotime($newDate));
		return ucfirst($mesDesc);

	}  else {
        return  "";
    }

}
function viaticos_IdHospedaje($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticosfull WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['IdHospedaje']."";
	}  else {
        return  "";
    }

}

function viaticos_Valida($IdViatico,$NEmpleado){
	require("config.php");
	
	$sql = "select count(*) as Valida from viaticos WHERE IdViatico='".$IdViatico."' and NEmpleado='".$NEmpleado."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		if ($f['Valida']==0){
			return FALSE;
		} else {
			return TRUE;
		}
	}  else {
        return  FALSE;
    }

}




function viaticos_RegresoHora($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticosfull WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['RegresoHora']."";
	}  else {
        return  "";
    }

}




function viaticos_NDias($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticosfull WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['ViaticoDias']."";
	}  else {
        return  0;
    }

}

function viaticos_NoNoches($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticosfull WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['noNoches']."";
	}  else {
        return  0;
    }

}
function viaticos_KilometrosTotal($IdViatico){
	require("config.php");
	
	$sql = "select SUM(Distancia+RecorridoInterno) as Kilometros from viaticosrecorridos WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['Kilometros']."";
	}  else {
        return  "";
    }

}

function viaticos_IdTipoTransporte($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticos WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['IdTipoTransporte']."";
	}  else {
        return  "";
    }

}

function viaticos_IdTipoTransporteR($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticos WHERE IdViatico='".$IdViatico."'";	
	//echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['IdTipoTransporteR']."";
	}  else {
        return  "";
    }

}
function viaticos_Veh_Transporte($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticos WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['Veh_Transporte']."";
	}  else {
        return  "";
    }

}
function viaticos_Veh_TransporteR($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticos WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['Veh_TransporteR']."";
	}  else {
        return  "";
    }

}

function viaticos_NGastos($IdViatico){
	require("config.php");
	
	$sql = "select count(*) as n from viaticosgastos WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['n']."";
	}  else {
        return  "0";
    }

}


function viaticos_NReccorridos($IdViatico){
	require("config.php");
	
	$sql = "select count(*) as n from viaticosrecorridos WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['n']."";
	}  else {
        return  "0";
    }

}
function viaticos_Veh_TransporteGasto($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticos WHERE IdViatico='".$IdViatico."'";	
	//echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['Veh_TransporteGasto']."";
	}  else {
        return  "0";
    }

}function viaticos_Veh_TransporteGastoR($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticos WHERE IdViatico='".$IdViatico."'";	
	//echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['Veh_TransporteGastoR']."";
	}  else {
        return  "0";
    }

}
function viaticos_GastosReset($IdViatico){
	require("config.php");	
	$sql = "DELETE  FROM viaticosgastos WHERE IdViatico='".$IdViatico."'";
    // echo $sql;
    if ($conexion->query($sql) == TRUE){ 
        return TRUE;
    } else {
        return FALSE;
    }
	
	
}


function viaticos_CombustiblesReset($IdViatico){
	require("config.php");	
	$sql = "DELETE  FROM viaticoscombustible WHERE IdViatico='".$IdViatico."'";
    // echo $sql;
    if ($conexion->query($sql) == TRUE){ 
        return TRUE;
    } else {
        return FALSE;
    }
	
	
}

function viaticosGastosIn($IdViatico, $Fecha, $nitavu, $Almuerzo, $Comida, $Cena, $IdHospedaje){
	require("config.php");	
	$sql = "INSERT INTO viaticosgastos(IdViatico, Fecha, Almuerzo, Comida, Cena, IdHospedaje)
            VALUES ('".$IdViatico."', '".$Fecha."','".$Almuerzo."','".$Comida."','".$Cena."','".$IdHospedaje."')";
 //echo "<br>".$sql."<br>";
    if ($conexion->query($sql) == TRUE){ 
		historia($nitavu,"[viaticos] = Registro un dia ".$Fecha." en la tabla de Gastos del Viatico ".$IdViatico."");	

        return TRUE;
    } else {
        return FALSE;
    }
	
	
}

function viaticosCombustibleIn($IdViatico, $Fecha, $nitavu, $Cantidad,$Descripcion,$Cilindros){
	require("config.php");	
	$sql = "INSERT INTO viaticoscombustible(IdViatico, Fecha, Cantidad,Descripcion, Cilindros)
            VALUES ('".$IdViatico."', '".$Fecha."','".$Cantidad."','".$Descripcion."','".$Cilindros."')";
 echo "<br>".$sql."<br>";
    if ($conexion->query($sql) == TRUE){ 
		historia($nitavu,"[viaticos] = Registro un dia ".$Fecha." en la tabla de Combustible! ".$IdViatico."");	

        return TRUE;
    } else {
        return FALSE;
    }
	
	
}

function viaticos_IdAlmuerzo($nivel){
	require("config.php");	
	$sql = "select * from viaticosalimentacion 
	WHERE Descripcion='Almuerzo' and
	NivelMax >= '".$nivel."' and 
	NivelMin <= '".$nivel."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['IdAlimentacion']."";
	}  else {
        return  "";
    }

}


function viaticos_IdComida($nivel){
	require("config.php");	
	$sql = "select * from viaticosalimentacion 
	WHERE Descripcion='Comida' and
	NivelMax >= '".$nivel."' and 
	NivelMin <= '".$nivel."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['IdAlimentacion']."";
	}  else {
        return  "";
    }

}

function viaticos_IdCena($nivel){
	require("config.php");	
	$sql = "select * from viaticosalimentacion 
	WHERE Descripcion='Cena' and
	NivelMax >= '".$nivel."' and 
	NivelMin <= '".$nivel."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['IdAlimentacion']."";
	}  else {
        return  "";
    }

}




function viaticos_IdHospedajeDestino($nivel,$idrecorido){
	require("config.php");	
	$sql = "select* from viaticoshospedaje 
	WHERE 
	NivelMax >= '".$nivel."' and 
	NivelMin <= '".$nivel."'	
	and tipo=(select tipo from cat_recorridosviaticos where idrecorrido='".$idrecorido."')";
	//echo "<br>".$sql."<br>";
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['IdHospedaje']."";
	}  else {
        return  "";
    }

}




function viaticos_NEmpleado($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticos WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return $f['NEmpleado'];
	}  else {
        return  "";
    }

}
function viaticos_JefeInmediato($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticos WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return $f['JefeInmediato'];
	}  else {
        return  "";
    }

}

function viaticos_IdAlimentaciontoCantidad($IdAlimentacion){
	require("config.php");
	
	$sql = "select * from viaticosalimentacion WHERE IdAlimentacion='".$IdAlimentacion."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return $f['Cantidad'];
	}  else {
        return  "";
    }

}



function viaticos_IdHospedajeCantidad($IdHospedaje){
	require("config.php");
	
	$sql = "select * from viaticoshospedaje WHERE IdHospedaje='".$IdHospedaje."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return $f['Cantidad'];
	}  else {
        return  "";
    }

}



function viaticos_DelGastoAlmuerto($IdGasto, $IdViatico, $nitavu){
	require("config.php");	
	$sql = "UPDATE viaticosgastos SET
	Almuerzo='0'
	WHERE IdGasto='".$IdGasto."'";
    // echo $sql;
    if ($conexion->query($sql) == TRUE){ 
		historia($nitavu,"[viaticos] = Elimino el Gasto del Almuerto del Viatico con id=".$IdViatico);	
        return TRUE;
    } else {
        return FALSE;
    }
	
	
}


function viaticos_DelGastoComida($IdGasto, $IdViatico, $nitavu){
	require("config.php");	
	$sql = "UPDATE viaticosgastos SET
	Comida='0'
	WHERE IdGasto='".$IdGasto."'";
    // echo $sql;
    if ($conexion->query($sql) == TRUE){ 
		historia($nitavu,"[viaticos] = Elimino el Gasto del Comida del Viatico con id=".$IdViatico);	
        return TRUE;
    } else {
        return FALSE;
    }
	
	
}


function viaticos_DelGastoCena($IdGasto, $IdViatico, $nitavu){
	require("config.php");	
	$sql = "UPDATE viaticosgastos SET
	Cena='0'
	WHERE IdGasto='".$IdGasto."'";
    // echo $sql;
    if ($conexion->query($sql) == TRUE){ 
		historia($nitavu,"[viaticos] = Elimino el Gasto del Cena del Viatico con id=".$IdViatico);	
        return TRUE;
    } else {
        return FALSE;
    }
	
	
}


function viaticos_DelGastoHospedaje($IdGasto, $IdViatico, $nitavu){
	require("config.php");	
	$sql = "UPDATE viaticosgastos SET
	IdHospedaje='0'
	WHERE IdGasto='".$IdGasto."'";
    // echo $sql;
    if ($conexion->query($sql) == TRUE){ 
		historia($nitavu,"[viaticos] = Elimino el Hospedaje del Viatico con id=".$IdViatico);	
        return TRUE;
    } else {
        return FALSE;
    }
	
	
}

function viaticos_Comision($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticos WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return $f['Comision'];
	}  else {
        return  "";
    }

}

function viaticos_RecorridoExcedente($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticos WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return $f['Recorrido_Excedente'];
	}  else {
        return  "";
    }

}
function viaticos_Total($IdViatico){
	require("config.php");
	
	$sql = "select sum(Cantidad) as Total from viaticosgastosfull  WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return $f['Total'];
	}  else {
        return  0;
    }

}


function viaticosC_($IdGastoF){
	require("config.php");	
	$sql = "select count(*) as n from viaticoscomprobacion WHERE IdGastoF='".$IdGastoF."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		if ($f['n']==0){
			return FALSE;
		} else {
			return TRUE;
		}
		
	}  else {
        return FALSE;
    }

}



function LugarComision($IdViatico){
	require("config.php");
	
	$sql = "select * from viaticosfull WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return $f['LugarComision'];
	}  else {
        return  '';
    }

}

function viaticos_pdf($IdViatico){
	require("config.php");
	
	$sql = "select pdf from viaticos  WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return $f['pdf'];
	}  else {
        return  "";
    }

}

function viaticos_Comprobacion($IdViatico){
	require("config.php");
	
	$sql = "select Comprobacion from viaticosconsulta  WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return $f['Comprobacion'];
	}  else {
        return  "";
		// PENDIENTE DE COMPROBACION
    }

}

function viaticos_Editar($IdViatico){
	require("config.php");
	$EstadoComprobacion = viaticos_Comprobacion($IdViatico);
	if ($EstadoComprobacion == 'PENDIENTE DE COMPROBACION'){
		return TRUE;
	} else {
		return FALSE;
	}	
}


function formatoReciboReintegro($IdViatico, $CantidadRecibida){
	require_once('lib/flor_funciones.php');
	require('config.php');
	$IdSolicitante = buscarIdSolicitante($idprograma, $iddelegacion, $folio);
	$res= '<br><br><table   style="width:100%" border=1  id="'.$folioRecibo.'">
		<tr>
			<td style="width:65%" border=1><div>
				<table>
				<tr>
				<td><b>DATOS DE IDENTICACIÓN</b></td> 		
				</tr>
				<tr>
				<td></td>  
				</tr>
				<tr>
					<td><div>
					<table style="width:100%" border=1>
					<tr>
					<td><span style="font-weight: bold; font-size:13px;">'.nombreBeneficiarioVivienda($IdSolicitante).'</span></td>
					<td><span></span></td> 								 		
					</tr>
					<tr>
					<td style="width:20%"><span>programa:</span></td>
					<td style="width:80%"><span>'.nombreProgramaVivienda($idprograma).'</span></td> 				 		
					</tr>
					<tr>
					<td style="width:20%"><span>FOLIO:</span></td>
					<td style="width:80%"><span>'.$folio.'</span></td> 				 		
					</tr>';
					if($numcontrato !=='')
					{
						$res =$res. '<tr>
						<td style="width:20%"><span>CONTRATO:</span></td>
						<td style="width:80%"><span>'.$numcontrato.'</span></td> 				 		
						</tr>';
					}
					$res =$res.'</table></div>
					</td>								 
				</tr>
				</table>
			</div></td>
	
			<td  style="width:35%" border=1><div>
				<table boder=1>
				<tr>
				<td><b>DATOS TRANSACCIÓN</b></td>  
				</tr>
				<tr>
				<td></td>  
				</tr>
				<tr>			 
				<td><div>
					<table>
					<tr>
					<td><span>N° RECIBO:</span></td>
					<td><span>'.SerieDelegacion($iddelegacion).$folioRecibo.'</span></td> 								 		
					</tr>
					<tr>
					<td><span>FECHA:</span></td>
					<td><span>'.$fecharecibo.'</span></td> 				 		
					</tr>
					<tr>
					<td><span>DELEGACION:</span></td>
					<td><span>'.nombreDelegacionVivienda($iddelegacion).'</span></td> 				 		
					</tr>
					<tr>
					<td><span>FORMA DE PAGO:</span></td>
					<td><span>'.FormaDePago($idformapago).'</span></td> 				 		
					</tr>	
					<tr>
					<td><span>REFERENCIA:</span></td>
					<td><span>'.$referencia.'</span></td> 				 		
					</tr>	
					<tr>
					<td><span>OPERADOR:</span></td>
					<td><span>'.$nitavu.'</span></td> 				 		
					</tr>				
					</table></div>
					</td>					 
				</tr>
				</table></div>
			</td>    
		</tr>		
		<tr>    
		<td style="width:100%">	
		<div>	
			 
		</div>  
		</td>    
		</tr>
		<tr >
			<td style="width:60%"><div>
				<table>
				<tr>			  
				</tr>
				<tr>
					<td>
						<div>
							<table style="width:100%" border=1>
								<tr>';
									if($numcontrato =='')
									{
										$res=$res.'<th style="width:20%;"><b>N° PAGO</b></th>';
									}								
									$res=$res.'<th style="width:60%;"><b>CONCEPTO</b></th>
									<th style="width:20%;"><b>IMPORTE</b></th>';
									if($descuento>0)
									{
										$res=$res.'<th style="width:20%;"><b>DESCUENTO</b></th>';
									}
									$res=$res.'<th style="width:20%;"><b>TOTAL</b></th>
									
									</tr>				
								<tr>';
									if($numcontrato =='')
									{
										$res=$res.'<td style="width:20%;"><span>'.$numPago.'</span></td>';
									}								
									$res=$res.'<td style="width:60%;"><span>'.strtoupper( TipoPago_Concepto($idtipopago)).'</span></td>
									<td style="width:20%;"><span>$'.$cantidad.'</span></td>';
									(string)$total=(string)$cantidad;
									if($descuento>0)
									{
										$total=(string)$cantidad-(string)$descuento;
										$res=$res.'<td style="width:20%;"><span>$'.$descuento.'</span></td>';
									}
									$res=$res.'<td style="width:20%;"><span>$'.$total.'</span></td>
									
								</tr>
								
								<tr>
									<td colspan="4"><b><br><br>IMPORTE CON LETRA:</b> '. strtoupper(numtoletras($total)).'</td>	
								</tr>					
							</table>
						</div>
					</td>											 
				</tr>
				</table>
			</div></td>
			<td  style="width:40%; text-align:right;" border=1>
			<div>';	
			 //SE GENERA EL CODIGO QR
			//$codigoQR=GenerarQRrecibo($folioRecibo,$cantidad,$fecharecibo,$nitavu);
			$codesDir = "tmp/CodigosQR/"; //Carpeta donde se almacenaran los QR  
	
			$res=$res.'<img  src="'.$codesDir.$codigoQR.'" />
			</div>
			</td>    
		</tr>
		<tr>    
		<td style="width:100%">	
		<div>	
		<hr style="border-top: 5px solid"/> 	
		</div>  
		</td>    
		</tr>
		<tr><td style="width:100%"><b>AVISO IMPORTANTE:</b></td>
		</tr>	
		<tr><td style="width:100%">'.$notas.'</td>		
		</tr>
		
	  </table>';	
	return $res;
}

function viaticos_estatus($IdViatico){
	require("config.php");	
	$sql = "select * from viaticos
	WHERE IdViatico='".$IdViatico."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['estatus']."";
	}  else {
        return  "";
    }

}


function viaticosnocomprobados($empleado){
	require("config.php");	
	$sql = "select count(*) as NumViaticos from viaticos where estatus =11 and NEmpleado='".$empleado."'  group by NEmpleado";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['NumViaticos']."";
	}  else {
        return  "";
    }

}


function actualizarEstatusViatico($idviatico,$idestatus){
    require("config.php");
    $sql = "UPDATE viaticos SET estatus=".$idestatus." where IdViatico=".$idviatico;
    //echo $sql;
    if ($conexion->query($sql) == TRUE) {
      return TRUE;
    }else{
      return FALSE;
    }
}
function destinos_donde_dormira($idviatico){
    require("config.php");
 
    $sql2 = "SELECT * from viaticosrecorridos where  duerme_en_lugar=1 and idviatico=$idviatico";
 	$dest = '';

    $r = $conexion -> query($sql2);
    while($f = $r -> fetch_array())
    { // resultado de la busqueda.................
		
		for ($i = 1; $i <= $f['dias']; $i++) {
			$dest = $dest.'/'.$f['id'];
		}
      
		
    }
    $dest= trim($dest, '/');	
    $destinos = explode('/',$dest);
    
    return $destinos;	
}


function viaticosrecorridosNdias($IdViatico){
	require("config.php");	
	$sql = "select sum(dias) as ndias from viaticosrecorridos where  IdViatico='".$IdViatico."'  group by IdViatico";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{
		return   $f['ndias']."";
	}  else {
        return  "";
    }

}
?>