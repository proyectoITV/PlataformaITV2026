<?php
include('/seguridad.php');
require('config.php');
require('lib/funciones.php');

define('FPDF_FONTPATH','fpdf/font');
//require_once('fpdf/fpdf.php');
require_once('fpdf/html2pdf.php');


$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
$pdf = new PDF_HTML();
//$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');
$pdf->SetFont('Helvetica','',8);

//ENCABEZADO
 $pdf->Image('img/logo_copia.png',10,6,80); 


// cargar los datos desde el no. de oficio solicitante _?\\|\zz

$search = $_GET['search'];
$pdf->SetFont('Helvetica','',8);
$pdf->SetTextColor('0','0','0');




///////////////////////////////ENCABEZADO///////////////////////////////////////////
  
    $pdf->SetXY(130,10);
    $pdf->Cell(0,0, utf8_decode("DIRECCIÓN DE ADMINISTRACION Y FINANZAS"),0,0,'C',0);
    $pdf->SetXY(130,14);
    $pdf->Cell(0,0, utf8_decode("DEPARTAMENTO DE ADQUISICIONES"),0,0,'C',0);

  
    $pdf->SetFont('Helvetica','B',7);
   
    $pdf->SetXY(8,42);
    $pdf->Cell(0,0, utf8_decode("FECHA DE IMPPRESIÓN:"));


    $pdf->SetFont('Helvetica','',7);
  
    $pdf->SetXY(40,42);
    $pdf->Cell(0,0, utf8_decode($fecha));



    /////////////////////////TABLA////////////////////////////////////////////////////////////////////////

    $pdf->Ln(5);
    //Creamos las celdas para los titulo de cada columna y le asignamos un fondo gris y el tipo de letra
    $pdf->SetFillColor(232,232,232); 
    $pdf->SetFont('Helvetica','B',7);
    $pdf->Cell(15,5,'#',0,0,'C',1);
    $pdf->Cell(15,5,'ID',0,0,'C',1);
    $pdf->Cell(75,5,utf8_decode('DIRECCIÓN'),0,0,'C',1);
    $pdf->Cell(75,5,utf8_decode('DEPARTAMENTO'),0,0,'C',1);
    $pdf->Cell(55,5,utf8_decode('TIPO DE REQUISICIÓN'),0,0,'C',1);
    $pdf->Cell(40,5,utf8_decode('ESTATUS'),0,1,'C',1);


      
 

//Comienzo a crear las fiulas de productos según la consulta mysql
    $pdf->Ln(5);
           //consulta sin LIMIT
if ($nivel == 1)
{
        $sql = " -- req 

        SELECT rq.IdRequisicion, 
        CASE cg.nivel WHEN  'Dir.' THEN (select UPPER(nombre)from cat_gerarquia where id=  cg.id)
        WHEN  '-'   THEN UPPER(cg.nombre)
        ELSE 
          case cgg.nivel     
          when'Dpto.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id ))
          when 'Sub.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id )) 
          when 'CONSEJO' then UPPER(cg.nombre)  ELSE UPPER(cgg.nombre)
        END END AS Direccion,

            
        UPPER(cg.nombre) as Departamento, 
        tr.Requisicion, er.DesEstatus, rq.FechaCrea FROM req_requisiciones AS rq 
        INNER JOIN req_detallerequisicion AS dr on rq.IdRequisicion=dr.IdRequisicion
        INNER JOIN req_estatusreq AS er ON rq.IdEstatus=er.IdEstatus

        INNER JOIN req_tiporequisicion tr ON tr.IdTipoRequisicion=rq.IdTipoRequisicion 
        INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento 
        LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia ";  
        $sql = $sql."WHERE ";
        $sql = $sql."rq.IdEstatus <> 6 AND ";
        $sql = $sql."((cg.nombre LIKE '%".$search."%') OR ";
       // $sql = $sql."(cgg.nombre LIKE '%".$search."%') OR ";
        $sql = $sql."(er.DesEstatus LIKE '%".$search."%') ) ";
        $sql = $sql."GROUP BY rq.IdRequisicion ORDER BY rq.IdRequisicion DESC";
}
else
{   $sql = " -- req 

        SELECT rq.IdRequisicion,
        CASE cg.nivel WHEN  'Dir.' THEN (select UPPER(nombre)from cat_gerarquia where id=  cg.id)
        WHEN  '-'   THEN UPPER(cg.nombre)
        ELSE 
          case cgg.nivel     
          when'Dpto.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id ))
          when 'Sub.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id )) 
          when 'CONSEJO' then UPPER(cg.nombre)  ELSE UPPER(cgg.nombre)
        END END AS Direccion,

            
        UPPER(cg.nombre) as Departamento, 
        tr.Requisicion, er.DesEstatus, rq.FechaCrea FROM req_requisiciones AS rq 
        INNER JOIN req_detallerequisicion AS dr on rq.IdRequisicion=dr.IdRequisicion
        INNER JOIN req_estatusreq AS er ON rq.IdEstatus=er.IdEstatus

        INNER JOIN req_tiporequisicion tr ON tr.IdTipoRequisicion=rq.IdTipoRequisicion 
        INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento 
        LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia ";  
        $sql = $sql."WHERE ";
        $sql = $sql."rq.IdEstatus <> 6 AND ";
        $sql = $sql."(((cg.nombre LIKE '%".$search."%') OR ";
        //$sql = $sql."(cgg.nombre LIKE '%".$search."%') OR ";
        $sql = $sql."(er.DesEstatus LIKE '%".$search."%') )AND  ";
        $sql = $sql."(rq.IdDepartamento=".nitavu_dpto ($nitavu).")) ";
        $sql = $sql."GROUP BY rq.IdRequisicion ORDER BY rq.IdRequisicion DESC";

}
     
    $rc= $conexion -> query($sql);               
    $cont=0;
           

        while($cat = $rc -> fetch_array())
 {
    $cont=$cont+1; 
    $id=$cat['IdRequisicion'];; 
    $direccion = $cat['Direccion'];
    $departamento = $cat['Departamento'];
    $tipoReq = $cat['Requisicion'];  
    $estatus = $cat['DesEstatus'];   
   

   $pdf->SetFont('Helvetica','',6);
    $pdf->Cell(15,3,$cont,0,0,'C',0); 
    $pdf->Cell(15,3,utf8_decode($id),0,0,'C',0); 
    $pdf->Cell(75,3,utf8_decode($direccion),0,0,'L',0);
    $pdf->Cell(75,3,utf8_decode($departamento),0,0,'l',0); 
    $pdf->Cell(55,3,utf8_decode($tipoReq),0,0,'C',0);
    $pdf->Cell(35,3,utf8_decode($estatus),0,0,'C',0);
    $pdf->Ln(4);
}
//////////////////////////////////////PIE////////////////////////////////////////////////////
    }
else{echo " <br><br>"; "No tiene acceso a ".$id_aplicacion;}

    $pdf->Output();
?>