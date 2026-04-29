<?php
include('/seguridad.php');
require('config.php');
require('lib/funciones.php');

define('FPDF_FONTPATH','fpdf/font');
require('fpdf/html2pdf.php');


 $id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

$pdf = new PDF_HTML();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->SetFont('Helvetica','',8);

//ENCABEZADO
 $pdf->Image('img/logo_copia.png',10,6,80); 


// cargar los datos desde el no. de oficio solicitante _?\\|\zz


$pdf->SetFont('Helvetica','',8);
$pdf->SetTextColor('0','0','0');




///////////////////////////////ENCABEZADO///////////////////////////////////////////
  
    $pdf->SetXY(130,10);
    $pdf->Cell(0,0, utf8_decode("DIRECCIÓN DE ADMINISTRACION Y FINANZAS"),0,0,'C',0);
    $pdf->SetXY(130,14);
    $pdf->Cell(0,0, utf8_decode("DEPARTAMENTO DE ADQUISICIONES"),0,0,'C',0);




 
    

    $pdf->SetFont('Helvetica','B',7);
   
    $pdf->SetXY(8,42);
    $pdf->Cell(0,0, utf8_decode("FECHA DE IMPPRESION:"));


    $pdf->SetFont('Helvetica','',7);
  
    $pdf->SetXY(40,42);
    $pdf->Cell(0,0, utf8_decode($fecha));

    /////////////////////////TABLA////////////////////////////////////////////////////////////////////////

    $pdf->Ln(5);
    //Creamos las celdas para los titulo de cada columna y le asignamos un fondo gris y el tipo de letra
    $pdf->SetFillColor(232,232,232); 
    $pdf->SetFont('Helvetica','B',7);   
    $y = $pdf->GetY();
    $pdf->SetXY(10,$y);
    $pdf->Cell(10,5,'#',0,0,'C',1);
    $pdf->Cell(30,5,utf8_decode('TIPO DE REQUISCION'),0,0,'C',1);
    $pdf->Cell(150,5,utf8_decode('PRODUCTO'),0,0,'C',1);
    $pdf->Ln(5);


          //VALIDA SI ES ADMINISTRADOR O NO
    if ($nivel==1) 
            {
              

            $sql = " -- req 
            SELECT req_conceptos.IdConcepto, req_conceptos.Concepto,req_tiporequisicion.Requisicion FROM req_conceptos 
                INNER JOIN req_tiporequisicion on req_conceptos.IdTipoRequisicion=req_tiporequisicion.IdTipoRequisicion WHERE   req_conceptos.Cancelado=0  ORDER BY  req_tiporequisicion.Requisicion, req_conceptos.Concepto asc";
            }
            else
            {
                //IDENTIFICA SI ES DE UNA DELEGACION O PERTENCE A OFICINAS CENTRALES
                if (midelegacion($nitavu)=='OFICINAS CENTRALES')
                        {       
                            $dpto=  nitavu_dpto($nitavu);
                             //DETERMINA  SI EL USUARIO ES DEL DEPARTAMENTO DE SOPORTE O DE INFORMATICA 
                            if ($dpto===4 || $dpto===55 )                       
                                {
                                    $sql = " -- req 
                                    SELECT req_conceptos.IdConcepto, req_conceptos.Concepto,req_tiporequisicion.Requisicion FROM req_conceptos INNER JOIN req_tiporequisicion on req_conceptos.IdTipoRequisicion=req_tiporequisicion.IdTipoRequisicion
                                    WHERE   req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (1,3) ORDER BY req_tiporequisicion.Requisicion, req_conceptos.Concepto asc";
                                }
                                  //DETERMINA  SI EL USUARIO ES DEL DEPARTAMENTO DE ADQUISICIONES Y O RECURSOS MATERIALES   
                                else if ($dpto===59 ||  $dpto===61 )                        
                                {
                                    $sql = " -- req 
                                    SELECT req_conceptos.IdConcepto, req_conceptos.Concepto,req_tiporequisicion.Requisicion FROM req_conceptos INNER JOIN req_tiporequisicion on req_conceptos.IdTipoRequisicion=req_tiporequisicion.IdTipoRequisicion
                                    WHERE  req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (1,2) ORDER BY req_tiporequisicion.Requisicion, req_conceptos.Concepto asc";
                                }
                                else
                                {   $sql = " -- req 
                                    SELECT req_conceptos.IdConcepto, req_conceptos.Concepto,req_tiporequisicion.Requisicion FROM req_conceptos INNER JOIN req_tiporequisicion on req_conceptos.IdTipoRequisicion=req_tiporequisicion.IdTipoRequisicion
                                    WHERE  req_conceptos.Cancelado=0 and req_conceptos.IdTipoRequisicion in (1) ORDER BY req_tiporequisicion.Requisicion, req_conceptos.Concepto asc";
                                    
                                }
                            
                        }
                        else
                        {
                            $sql = " -- req 
                            SELECT req_conceptos.IdConcepto, req_conceptos.Concepto,req_tiporequisicion.Requisicion FROM req_conceptos INNER JOIN req_tiporequisicion on req_conceptos.IdTipoRequisicion=req_tiporequisicion.IdTipoRequisicion
                            WHERE  req_conceptos.Cancelado=0  and req_conceptos.IdTipoRequisicion in (1,2)  ORDER BY req_tiporequisicion.Requisicion, req_conceptos.Concepto asc";
                        }

            }
 


    
    $rc= $conexion -> query($sql);               
    $cont=0;
           

        while($cat = $rc -> fetch_array())
    {
        $cont=$cont+1; 
        $concepto=$cat['Concepto'];   
        $tipoReq = $cat['Requisicion']; 
        $pdf->SetFont('Helvetica','',6);
        
        $y = $pdf->GetY();
        
        $pdf->SetXY(10,$y);
        $pdf->Cell(10,5,$cont,0,0,'C');
        $pdf->Cell(30,5,utf8_decode($tipoReq),0,0,'C');
        $pdf->MultiCell(150,5,utf8_decode($concepto),0,'L'); 
        $space = (isset($y2) ? $y2- $y : 0) + 2;  
    }
    //Fin del while




//////////////////////////////////////PIE////////////////////////////////////////////////////
    //}

  $pdf->Output();


?>