<?php
include('/seguridad.php');
require('config.php');
require('lib/funciones.php');

define('FPDF_FONTPATH','fpdf/font');
require('fpdf/html2pdf.php');


$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE and $nivel==1)
{ 
    docdigital_no(FALSE,1);
$pdf = new PDF_HTML();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->SetFont('Helvetica','',7);

//ENCABEZADO
 $pdf->Image('img/logo_copia.png',10,6,80); 


// cargar los datos desde el no. de oficio solicitante _?\\|\zz
$idRequisicion = $_GET['n'];
$pdf->SetFont('Helvetica','',7);
$pdf->SetTextColor('0','0','0');

$sql = " -- req
SELECT rq.IdRequisicion -- UPPER(cgg.nombre) as Direccion
,UPPER(cg.nombre) as Departamento,cg.nivel, cgg.nivel,cgg.id,
CASE cg.nivel WHEN   UPPER('dir') THEN (select UPPER(nombre)from cat_gerarquia where id=  cg.id)
WHEN  '-'   THEN UPPER(cg.nombre)
ELSE 
  case cgg.nivel     
  when UPPER('dpto') then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id ))
  when  UPPER('sub') then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id )) 
  when  UPPER('CONSEJO') then UPPER(cg.nombre)  ELSE UPPER(cgg.nombre)
END END AS Direccion,
CASE  cg.nivel WHEN  UPPER('dir') THEN (CONCAT(ifnull(UPPER(emj.profesion_abr),''),' ',UPPER(emj.nombre)))
WHEN  '-'   THEN UPPER(cg.nombre)
ELSE 
  case cgg.nivel     
  when  UPPER('dpto') then   (select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.titular=(select titular from cat_gerarquia where  id= (select dependencia from cat_gerarquia where id=  cgg.id )))  when 'Sub.' then  (select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.titular=(select titular from cat_gerarquia where  id= (select dependencia from cat_gerarquia where id=  cgg.id ))) when 'CONSEJO.' then  (select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.titular=(select titular from cat_gerarquia where  id= (select dependencia from cat_gerarquia where id=  cgg.id )))
  when  UPPER('sub') then   (select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.titular=(select titular from cat_gerarquia where  id= (select dependencia from cat_gerarquia where id=  cgg.id )))  when 'Sub.' then  (select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.titular=(select titular from cat_gerarquia where  id= (select dependencia from cat_gerarquia where id=  cgg.id ))) when 'CONSEJO.' then  (select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.titular=(select titular from cat_gerarquia where  id= (select dependencia from cat_gerarquia where id=  cgg.id ))) 
  when  UPPER('CONSEJO') then CONCAT(ifnull(UPPER(em.profesion_abr),''),' ',UPPER(em.nombre))
            else   CONCAT(ifnull(UPPER(em.profesion_abr),''),' ',UPPER(em.nombre))
END END AS Titular
,tr.Requisicion, DATE_FORMAT(rq.FechaCrea, '%Y-%m-%d') AS FechaCrea 
,(select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre) )from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '%Adquicisiones%') as TitularAdquisiciones
,(select CONCAT(ifnull(UPPER(empleados.profesion_abr),''),' ', UPPER(empleados.nombre)) from cat_gerarquia INNER JOIN empleados on cat_gerarquia.titular=empleados.nitavu  where cat_gerarquia.nombre like '% Administracion y Finanzas%') as TitularFinanzas,
rq.Justificacion, cg.nivel,
CONCAT(ifnull(UPPER(emj.profesion_abr),''),' ',UPPER(emj.nombre)) AS TitularJefeDpto

FROM req_requisiciones AS rq
INNER JOIN req_detallerequisicion AS dr on rq.IdRequisicion=dr.IdRequisicion
INNER JOIN req_tiporequisicion tr ON tr.IdTipoRequisicion=rq.IdTipoRequisicion
INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento
LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia
LEFT JOIN empleados as em on cgg.titular=em.nitavu
LEFT JOIN empleados as emj on cg.titular=emj.nitavu
WHERE rq.IdRequisicion = ".$idRequisicion."  GROUP BY rq.IdRequisicion";


$rc= $conexion -> query($sql);
$msg="";

if($f = $rc -> fetch_array())
{

    $TitularAdquisiciones=$f['TitularAdquisiciones'];
    $TitularFinanzas=$f['TitularFinanzas'];
    $Departamento=$f['Departamento'];
    $Direccion=$f['Direccion'];
    $FechaCrea=$f['FechaCrea'];
    $TipoRequisicion=$f['Requisicion'];
    $Titular=$f['Titular'];// ERA JEFE DE DEPTO Y SE CAMBIO A DIRECTOR
    $Justificacion=$f['Justificacion'];
    $nivel=$f['nivel'];
    $TitularJ=$f['TitularJefeDpto'];
   
}
//  if(strpos($Departamento, 'DELEGACION') !== false ) 
//  {
//      $Direccion=$Departamento;
//  }
 if($nivel=='Dir.' or strpos($Departamento, 'COORDINACION') !== false) 
 {  
     $Direccion=$Departamento;
     $Titular=$TitularJ;
  }

  
///////////////////////////////ENCABEZADO///////////////////////////////////////////
  
    $pdf->SetXY(130,10);
    $pdf->Cell(0,0, utf8_decode("DIRECCIÓN DE ADMINISTRACION Y FINANZAS"),0,0,'C',0);
    $pdf->SetXY(130,14);
    $pdf->Cell(0,0, utf8_decode("DEPARTAMENTO DE ADQUISICIONES"),0,0,'C',0);
    $pdf->SetXY(130,18);
    $pdf->Cell(0,0, utf8_decode("REQUISICIÓN DE ".$TipoRequisicion),0,0,'C',0);



    $pdf->SetFont('Helvetica','B',8);
    $pdf->SetXY(10,40);
    $pdf->Cell(0,0, utf8_decode("AREA SOLICITANTE:"));
    $pdf->SetXY(10,44);
    $pdf->Cell(0,0, utf8_decode("PARA UTILIZARSE EN:"));
    $pdf->SetXY(10,48);
    $pdf->Cell(0,0, utf8_decode("CON CARGO A:"));
    $pdf->SetXY(10,52);
    $pdf->Cell(0,0, utf8_decode("FECHA DE ELABORACIÓN:"));

    $pdf->SetFont('Helvetica','',8);
    if($nivel=='Del.') 
    {       
       
     
    
    $pdf->SetXY(50,40);
    $pdf->Cell(0,0, utf8_decode($Departamento));
    $pdf->SetXY(50,44);
    $pdf->Cell(0,0, utf8_decode($Departamento));
    $pdf->SetXY(50,48);
    $pdf->Cell(0,0,utf8_decode($Departamento));
   
    }
    else {
    $pdf->SetXY(50,40);
    $pdf->Cell(0,0, utf8_decode($Direccion));
    $pdf->SetXY(50,44);
    $pdf->Cell(0,0, utf8_decode($Departamento));
    $pdf->SetXY(50,48);
    $pdf->Cell(0,0,utf8_decode($Direccion));
    }

    $pdf->SetXY(50,52);
    $pdf->Cell(0,0, utf8_decode($FechaCrea));

    $pdf->SetFont('Helvetica','B',12);
    $pdf->SetXY(140,37);
    $pdf->Cell(30,7, "FOLIO:",0,0,'C',0);
   // $pdf->SetXY(192,40);
    $pdf->Cell(30,7, utf8_decode($idRequisicion),0,0,'C',0);
    $pdf->SetFont('Helvetica','',8);
    $pdf->SetXY(140,49); 
    $pdf->Cell(30,7, utf8_decode("FECHA IMPRESIÓN:"),0,0,'L',0);      
    $pdf->Cell(30,7, $fecha, 0,0,'C',0);
    

    
/////////////////////////TABLA////////////////////////////////////////////////////////////////////////
    $pdf->Ln(15);
    //Creamos las celdas para los titulo de cada columna y le asignamos un fondo gris y el tipo de letra
    $pdf->SetFillColor(232,232,232); 
    $pdf->SetFont('Helvetica','B',8);
    $pdf->Cell(20,5,'N',0,0,'C',1);
    $pdf->Cell(25,5,'CANTIDAD',0,0,'C',1);
    $pdf->Cell(30,5,'UNIDAD',0,0,'C',1);
    $pdf->Cell(115,5,utf8_decode("DESCRIPCIÓN"),0,0,'C',1);
 

//Comienzo a crear las fiulas de productos según la consulta mysql
    $pdf->Ln(5);
            $sql = " -- req 
            SELECT req_detallerequisicion.IdDetalle,req_detallerequisicion.IdConcepto,SUM(req_detallerequisicion.Cantidad) AS Cantidad,
             req_unidades.Unidad , req_conceptos.Concepto FROM req_detallerequisicion inner join req_conceptos on req_detallerequisicion.IdConcepto=req_conceptos.IdConcepto
             inner join req_unidades on req_unidades.IdUnidad = req_detallerequisicion.IdUnidad where req_detallerequisicion.Cancelado=0  
             and req_detallerequisicion.IdRequisicion='".$idRequisicion."' 
             GROUP BY req_detallerequisicion.IdConcepto HAVING SUM(req_detallerequisicion.Cantidad) > 0 ";
     
    $rc= $conexion -> query($sql);               
    $cont=0;
           

        while($cat = $rc -> fetch_array())
 {

    $cont=$cont+1; 
    $cantidad = $cat['Cantidad'];
    $unidad = $cat['Unidad'];
    $concepto = $cat['Concepto'];   
   

   $pdf->SetFont('Helvetica','',8);
    $pdf->Cell(20,4,$cont,'',0,'C',0); 
    $pdf->Cell(25,4,$cantidad,'',0,'C',0);
    $pdf->Cell(30,4,$unidad,'',0,'C',0); 
    $pdf->Cell(115,4,utf8_decode($concepto),'',0,'L',0);
    $pdf->Ln(4);
}


//////////////////////////////////////JUSTIFICACIÓN////////////////////////////////////////////////////
    $pdf->SetFont('Arial','B',7);   
    $pdf->SetXY(10,228);
    $pdf->Cell(0,0,utf8_decode("JUSTIFICACIÓN"),0 ,0,'C',TRUE);

    $pdf->SetFont('Arial','',8);    
    $pdf->SetXY(10,230);   
    $y = $pdf->GetY();
     $pdf->MultiCell(0,4,$Justificacion,0,'C',TRUE);
    //$pdf->MultiCell(0,4,utf8_decode($Justificacion),0,1,'C'); 

   

    

//////////////////////////////////////PIE////////////////////////////////////////////////////

    $pdf->SetFont('Helvetica','',8);   
    $pdf->SetXY(10,246);
    $pdf->Cell(60,10,utf8_decode("COTIZÓ"),0 ,0,'C',0);

    $pdf->SetXY(10,256);
    $pdf->Cell(60,10,utf8_decode($TitularAdquisiciones), 0,0,'C',0);

    $pdf->SetXY(10,260);
    $pdf->Cell(60,10,utf8_decode("DPTO. DE ADQUISICIONES"), 0,0,'C',0);
    
    

    $pdf->SetXY(75,246);
    $pdf->Cell(60,10,utf8_decode("SOLICITANTE"), 0,0,'C',0);

    $pdf->SetXY(75,256);
    $pdf->Cell(60,10,utf8_decode($Titular), 0,0,'C',0);

    $pdf->SetXY(75,263);
    // $pdf->Cell(60,10,utf8_decode($Departamento), 1,0,'C',0);

    $y = $pdf->GetY();
    $pdf->MultiCell(60,4,utf8_decode($Direccion),0,'C'); 
    $pdf->SetXY(75,$y);




    
    $pdf->SetXY(140,246);
    $pdf->Cell(60,10,utf8_decode("AUTORIZACIÓN"), 0,0,'C',0);
    
    $pdf->SetXY(140,256);
    $pdf->Cell(60,10,utf8_decode($TitularFinanzas), 0,0,'C',0);

    $pdf->SetXY(140,260);
    $pdf->Cell(60,10,utf8_decode("DIR. DE ADMINISTRACIÓN Y FINANZAS"), 0,0,'C',0);


    /////////// Informacion de quien imprimio el formato
    $pdf->SetFont('Helvetica','',6);   
    $pdf->SetXY(10,275);
    $pdf-> SetTextColor(144,144,144);
    $pdf->Cell(30,1,'Nitavu:',0 ,0,'C',0);
    $pdf->SetXY(17,275);
    $pdf->Cell(30,1, utf8_decode($nitavu),0 ,0,'C',0);

    $pdf->Output();
    
        }
else{echo " <br><br>";echo "No tiene acceso a ".$id_aplicacion;}
?>