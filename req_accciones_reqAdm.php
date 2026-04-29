<?php
include ("./lib/body_head.php");

?>
<?php
$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{

 $idRequisicion = $_POST['idRequisicion']; 
 

  
	     if (isset($_POST['btnCotizar'])) 
	     {

	    mensaje1("¿Esta seguro que desea marcar que  la requisción número ".$idRequisicion." iniciará el proceso de cotización?","req_detalles.php?d=".$idRequisicion,$idRequisicion);
				
	     } 
	    else if (isset($_POST['btnVoBo'])) 
	     {

	    mensaje1("¿Esta seguro que desea marcar como autorizada la requisción número ".$idRequisicion."?","req_detalles.php?d=".$idRequisicion,$idRequisicion);
				
	     } 
 		
	    else if (isset($_POST['btnArmado'])) 
	     {

	    mensaje1("¿Esta seguro que desea marcar que  la requisción número ".$idRequisicion." iniciará el proceso de armado?","req_detalles.php?d=".$idRequisicion,$idRequisicion);
				
	     } 	
	     
      elseif (isset($_POST['btnDetener'])) 
	     {
			mensaje2 ("Por favor introduzca una observación por la cual la requisición será detenida.","req_detalles.php?d=".$idRequisicion,$idRequisicion);
				
	     } 

     else if (isset($_POST['btnRechazar'])) 
	     {
 			mensaje2 ("Por favor introduzca una observación por la cual la requisición será rechazada.","req_detalles.php?d=".$idRequisicion,$idRequisicion);
		
	     } 

     else if (isset($_POST['btnEntregar'])) 
	     {
	      
       	 mensaje2 ("Por favor introduzca el número de guía u oficio con la que será entregada la requisición.","req_detalles.php?d=".$idRequisicion,$idRequisicion);

				
		 } 
		 if (isset($_POST['btnReactivar'])) 
	     {

	    mensaje1("¿Esta seguro que desea reactivar la requisición número ".$idRequisicion." ?","req_detalles.php?d=".$idRequisicion,$idRequisicion);
				
	     } 
	     else if (isset($_POST['btnImprimir'])) 
	     { 
	//      	$justificacion="";
	//      	$sql = " -- req 
	// 	SELECT * FROM req_requisiciones WHERE IdRequisicion='".$idRequisicion."'";
	// 	$rc= $conexion -> query($sql);
	// 	if($f = $rc -> fetch_array())
	// 	{
	// 		 $justificacion=$f['Justificacion'];	

	echo "<script type='text/javascript'> window.location.assign('./req_formato2.php?n=".$idRequisicion."');</script>";			
		
	// 	if (empty($justificacion)) 
	// {
    // 	//echo 'La variable SÍ está vacía, su contenido es: '. $justificacion;
    // 			mensaje2 ("Por favor introduzca la justificación que será incluida en la requisición.","req_detalles.php?d=".$idRequisicion,$idRequisicion);
	// }
	// else{
	// 	//echo 'La variable NO está vacía, su contenido es: '. $justificacion;
	// 	echo "<script type='text/javascript'> window.location.assign('./req_formato2.php?n=".$idRequisicion."');</script>";	
	// }
       			
	      
	}

				
	
	  
	     
	}
else{echo "	<br><br>";
	echo "No tiene acceso a ".$id_aplicacion;}
?>
