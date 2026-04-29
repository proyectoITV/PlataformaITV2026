<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/yes_funciones.php");
require("lib/flor_funciones.php");
require("lib/laura_funciones.php");


$NumContrato=VarClean($_POST['contrato']);
$Pago=VarClean($_POST['pago']);
//$FechaCorte=VarClean($_POST['FechaCorte']);
$FechaOperacion=VarClean($_POST['FechaOperacion']);
$NumRec=VarClean($_POST['numrecibo']);   
$TipoPago=VarClean($_POST['TipoPago']);
$Referencia=VarClean($_POST['Referencia']);
$Concepto=VarClean($_POST['Concepto']);
$folio=VarClean($_POST['folio']);

$distribuye_pago = distribuye_pago($NumContrato,$FechaOperacion,0,$Pago,$nitavu,63,1,0);
//function distribuye_pago($NumContrato,$fechaRecibo,$IdTipoMov,$ingresado_recibo,$nitavu,$CveCargo,$IdFormaPago,$OrigenDeEnvio)
       
/* if  ($distribuye_pago =='TRUE')
{     
    echo 'TRUE';    
    //$NumeroMovimiento = NumMov($NumContrato); 
} */

if  ($distribuye_pago =='TRUE')
			 	 {
				$NumeroMovimiento= NumMov2($NumContrato);  
				$NumeroCuentaAntes = $NumeroMovimiento;
        //function Registra_PagosParciales($varImporteConvertido , $varImporte,$NumContrato,$fecharecibo, $fechaAplicacion,
	      //$FolioRec,$LugarExpedicion,$NumeroMovimiento,$IngresoVia,$factormoneda,$nitavu,$contador_puntos)
        $IdTipoMonedaContrato=TipoMonedaContratos($NumContrato);
        $factorconversion=obtenerfactorconversion($IdTipoMonedaContrato, $fecha) ; 
		$IdPrograma=IdProgramaNumContrato($NumContrato);
		$IdDelegacion=IdDelegacionNumContrato($NumContrato);
		$Folio=FolioNumContrato($NumContrato);
		$LugarExpedicion=0;
		$IngresoVia=3;
		$contador_puntos=0;

				 $pagos_parciales=Registra_PagosParciales(($Pago/$factorconversion) ,$Pago,$NumContrato,$FechaOperacion,$fecha,$NumRec,$LugarExpedicion,$NumeroMovimiento,$IngresoVia,$IdTipoMonedaContrato,$nitavu,$contador_puntos);
                
				 if( $pagos_parciales=='TRUE')
				 {		
					$RES="TRUE";	 
					echo 'EXITO,'.$NumContrato;
					//function GuardaDatosRecibo($IdDelegacion ,$IdPrograma ,$Folio ,$NumContrato  ,$Cantidad ,$FormaPago ,$Referencia ,$FechaRecibo ,$Nitavu, $FolioRecibo ,$NumPago,$IdTipoPago  ,$Descuento)
					
					//el siguiente bloqe se comenta porque se pondra en el pago global
					/* $reciboG=GuardaDatosRecibo($IdDelegacion ,$IdPrograma ,$Folio ,$NumContrato  ,$Pago,$TipoPago ,$Referencia ,$FechaOperacion ,$nitavu, $NumRec ,$NumeroMovimiento,63  ,0);
					if ($reciboG="TRUE")					
					{	//$acumula_puntos = $acumula_puntos + $contador_puntos;
						historia($nitavu, "Pago de abono de desarrollador, al contrato='".$NumContrato."' Folio Recibo".$NumRec); 	
						actualizarFolioRecibo($NumRec);
						$RES="TRUE";
						echo 'TRUE';
						
					}else
					{
						$RES='FALSE';
						Destruye_HistoricoPagos($NumContrato,$NumeroCuentaAntes,1) ;  
						echo "Al parecer ha ocurrido un problema en el almacenamiento del recibo, marco error la sección de datosRecibo (Adelentar pagos)";  
					}				 */
					

				// }else 
				// {  
				// 	$RES='FALSE';
				// 	Destruye_HistoricoPagos($NumContrato,$NumeroCuentaAntes,1) ;  
				// 	echo "Al parecer ha ocurrido un problema en el almacenamiento del recibo, marco error la sección de PAGOSPARCIALES (Adelentar pagos)";    
				// }
			  }else
			  {  $RES="FALSE";
				echo "Al parecer ha ocurrido un problema en el almacenamiento del recibo, marco error la sección de HISTORICOPAGOS (Adelentar pagos)";

			  }	
}else{
	//echo 'FALSE,'.$NumContrato;	
	//eliminar pago global
	//sacar los datos de Pagosdesarrolladores
	 EliminaPagoDesarrolladores($NumRec, $folio, $FechaOperacion);
	 echo 'ERROR,'.$NumContrato;	
	
	/* $sqldatosrec='select * from pagosdesarrolladores where FolioRecibo='.$NumRec.'and folio='.$folio.' and FechaOperacion="'.$FechaOperacion."'" ;
	$borra = $Vivienda -> query($sqldatosrec);
	while($f = $borra -> fetch_array())
	{
			return $f['ultimo'];
	} */

	//
}
?>