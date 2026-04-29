<?php

include ("lib/body_head.php");

$ok_delegacion = $_POST['ok_delegacion'];
$ok_programa = $_POST['ok_programa'];
$ok_folio = $_POST['ok_folio'];
$ok_curp = $_POST['ok_curp'];
$ok_idsolicitante = $_POST['ok_idsolicitante'];
$ok_beneficiario = $_POST['ok_beneficiario'];
$ok_contrato = $_POST['ok_contrato'];
$nitavu = $_POST['nitavu'];

			$msg="";//HISTORIA
			$malos ="";	
//echo $ok_contrato;
$sql = "SELECT * FROM cat_documentos WHERE tipo='ITAVU-LOTES' ORDER by nombre ASC";
$r = $conexion -> query($sql);	while($doc = $r -> fetch_array())
{

		$sql="select  * from digital_itavu 
		WHERE 
					(
					folio='".$ok_folio."' and 
					programa='".$ok_programa."' and 
					delegacion='".$ok_delegacion."' and 
					id_documento='".$doc['id']."'
					)";
		//echo $sql;

		$r2 = $conexion -> query($sql); 
		if($f = $r2 -> fetch_array()) {
			//ESTA, ACTUALIZAMOS
			//echo "esta";


			$archivo = "digitales/".$ok_delegacion."_".$ok_programa."_".$ok_folio."_".$doc['id'].".pdf";
			$historia = doc_historia($doc['id'], $ok_programa, $ok_folio, $ok_delegacion);			
			$historia2 = $historia."Act. por (".$nitavu.")".nitavu_nombre($nitavu)." el ".$fecha." a las ".$hora."<br>";

			//$subida =  subirpdf3($doc["id"], $archivo);
			$subida="";
			if (isset($_FILES[$doc['id']])){
				$subida = FTP_subir_post($doc['id'],$archivo);
			} else {
				//echo "No se detecto seleccionado para actualizar ".$doc['id']."<br>";
			}

			
			//echo $subida;
			if ($subida=="TRUE"){
				$msg=$msg." <b>".$doc['nombre']."</b> <span class='tenue invisible'>(Contrato: ".$ok_contrato.", Folio: ".$ok_folio.", Prog: ".$ok_programa.") </span>, ";
					
				$sql="UPDATE digital_itavu 
				SET 
					fecha='".$fecha."', 
					hora='".$hora."', 
					folio='".$ok_folio."', 
					programa='".$ok_programa."', 
					delegacion='".$ok_delegacion."', 
					curp='".$ok_curp."', 
					id_solicitante='".$ok_idsolicitante."', 
					beneficiario='".$ok_beneficiario."'
					contrato='".$ok_contrato."',
					historia='".$historia2."'
					

				WHERE 
					(
					folio='".$ok_folio."' and 
					programa='".$ok_programa."' and 
					delegacion='".$ok_delegacion."' and 
					id_documento='".$doc['id']."'
					)";

				//echo $sql;
				if ($conexion->query($sql) == TRUE)	{ 
					$msg = $msg." actualizo y registro ";
					docdigital_no(FALSE, 5);
				}
				else { 
					$malos = $malos." no se registro. "; 
				}

			} else 
				{//no subio
				 $malos=$malos."".$doc['nombre'].", ";
				}

			
			historia($nitavu," Digitalizo, actualizando  ".$msg." [ap40]");
			


		} else { //NO ESTA, AGREGAMOS--------------------------------------------------------------------------------------
			//echo "no esta";
			

			$archivo = "digitales/".$ok_delegacion."_".$ok_programa."_".$ok_folio."_".$doc['id'].".pdf";
			//$subida =  subirpdf3($doc["id"], $archivo);
			$subida="";
			if (isset($_FILES[$doc['id']])){				
				$subida = FTP_subir_post($doc['id'],$archivo);
			} else {
				//echo "No se detecto seleccionado para agregar ".$doc['id']."<br>";
			}

			//$subida = FTP_subir_post($doc['id'],$archivo);
			//echo $subida;
			$historia2 ="Act. por (".$nitavu.")".nitavu_nombre($nitavu)." el ".$fecha." a las ".$hora."<br>";
			if ($subida=="TRUE"){
				$msg=$msg." <b>".$doc['nombre']."</b> <span class='tenue invisible'>(Contrato: ".$ok_contrato.", Folio: ".$ok_folio.", Prog: ".$ok_programa."), </span> ";
				
				$sql = "INSERT INTO digital_itavu
				(fecha, hora, folio, programa, delegacion, curp, id_solicitante, beneficiario, id_documento, contrato, historia)
				VALUES
					(
					'".$fecha."', 
					'".$hora."',
					'".$ok_folio."',
					'".$ok_programa."', 
					'".$ok_delegacion."',
					'".$ok_curp."',
					'".$ok_idsolicitante."',
					'".$ok_beneficiario."',					
					'".$doc["id"]."',
					'".$ok_contrato."',
					'".$historia2."'

					)";

				//echo $sql;
				if ($conexion->query($sql) == TRUE)	{ 
					$msg = $msg.". ";
					docdigital_no(FALSE, 5);
				}
				else { 
					$malos = $malos." no se registro. "; 
				}

			} else 
				{//no subio
				 $malos=$malos."".$doc['nombre'].", ";
				}

			
			

	
				historia($nitavu,"Digitalizo y agrego ".$msg." [ap40]");
			

		}// if bd para ver si esta
}

if ($msg<>""){
			$msg = "<b>Digitalizado con exito</b>: ".$msg;
			

			historia($nitavu,"Uso Digitalizaon para ".$msg." [ap40]");
			mensaje($msg,'digital.php?pes=itavu&folio='.$ok_folio.'&del='.$ok_delegacion.'&prog='.$ok_programa);

			}// historia}


	?>