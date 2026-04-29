<?php
include ("./lib/body_head.php");
?>

<?php
$id_aplicacion ="viaticos"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
/******************************************************/  
 /*GUARDAR RECORRIDO EN LA BASE DE DATOS*/

                
 $anterior= $_SERVER['HTTP_REFERER'];   
 
 
//  if (!isset($_POST['origen']) or !empty($_POST['origen'])){// 		mensaje('No ha especificado el origen.','viaticos_admonrecorridos.php');
// 		return;
//  }
        
 
 

// if (!isset($_POST['destino']) or !empty($_POST['destino'])) {	
// 	mensaje('No ha especificado el destino.','viaticos_admonrecorridos.php');
// 	return;

//  }
	   
 



// if (!isset($_POST['distanciakm']) or !empty($_POST['distanciakm'])) {	
// 	mensaje('No ha especificado la distancia del recorrido.','viaticos_admonrecorridos.php');
// 	return;
//  }
	



//  if (!isset($_POST['cboxtipotarifa']) or !empty($_POST['cboxtipotarifa'])){
// 	mensaje('No ha especificado el tipo de tarifa.','viaticos_admonrecorridos.php');
// 	return;
	
//  }

 $origen=$_POST['origen'];   
 $tipotarifa=$_POST['cboxtipotarifa']; 
 $distancia=$_POST['distanciakm']; 
 $destino=$_POST['destino'];     
 
$sql = "INSERT INTO cat_recorridosviaticos(origen,destino,distancia,nitavu,fecha,tipo)VALUES('".$origen."','"	.$destino."','".$distancia."','".$nitavu."',now(),'".$tipotarifa."');";
//echo $sql;
	
	if ($conexion->query($sql) == TRUE){ 	           
		mensaje('Recorrido registrado con éxito ',$anterior);                  
	}else{
		mensaje('Error al guardar '.$sql.'  , intente nuevamente por favor',$anterior);  
	}


}
else
{
echo "<br><br>";
	mensaje("No tiene acceso al modúlo de viaticos", "index.php");}
?>