<?php
include('/seguridad.php');
require('config.php');
///require_once('lib/funciones.php');

define('FPDF_FONTPATH','fpdf/font');
require('fpdf/html2pdf.php');
AhorrePapel(FALSE,4);


$id_aplicacion ="ap58";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{


   
    
    $iddir = $_POST['iddireccion'];
    
    if (isset($_POST['departamento']) && !empty($_POST['departamento'])) {
   $iddpto = $_POST['departamento'];
}else {
   $iddpto=0;
}


    $search = $_POST['search'];  
    $idTipo = $_POST['idTipoRequisicion'];
    $fechaInicio = $_POST['fechaI'];
    $fechaFinal = $_POST['fechaF'];
    $nomdpto=strtoupper(dpto_id($iddpto));
    $nomdir=strtoupper(dpto_id($iddir));


    if($idTipo==0)
        {
            $msg='No ha especificado el filtro  que se utilizará para generar para el reporte';
        
            mensaje($msg,'req_reporte_requisiciones2.php');


        }
    else
    {
 if($idTipo!=4)
{
    $pdf = new PDF_HTML();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');
$pdf->SetFont('Helvetica','',8);

//ENCABEZADO
 $pdf->Image('img/logo_copia.png',10,6,80); 
$pdf->SetFont('Helvetica','',8);
$pdf->SetTextColor('0','0','0');

// cargar los datos desde el no. de oficio solicitante _?\\|\zz






///////////////////////////////ENCABEZADO///////////////////////////////////////////
  
    $pdf->SetXY(130,10);
    $pdf->Cell(0,0, utf8_decode("DIRECCIÓN DE ADMINISTRACION Y FINANZAS"),0,0,'C',0);
    $pdf->SetXY(130,14);
    $pdf->Cell(0,0, utf8_decode("DEPARTAMENTO DE ADQUISICIONES"),0,0,'C',0);


  
    

    $pdf->SetFont('Helvetica','B',7);   
    if($iddir!=$iddpto)
     {
    $pdf->SetXY(8,34);
    $pdf->Cell(0,0, utf8_decode($nomdir)); 
     }

    $pdf->SetFont('Helvetica','B',7);    
    $pdf->SetXY(8,37);
    $pdf->Cell(0,0, utf8_decode($nomdpto)); 
     


    $pdf->SetFont('Helvetica','B',7);   
    $pdf->SetXY(8,42);
    $pdf->Cell(0,0, utf8_decode("REQUISICIONES ENTREGADAS")); 

    $pdf->SetFont('Helvetica','B',7);
    $pdf->SetXY(200,42);
    $pdf->Cell(0,0, utf8_decode("RANGO DE FECHAS:"));

    $pdf->SetFont('Helvetica','',7);  
    $pdf->SetXY(240,42);
    $pdf->Cell(0,0,  date("Y-m-d",strtotime($fechaInicio)));
  
    $pdf->SetFont('Helvetica','B',7);
    $pdf->SetXY(260,42);
    $pdf->Cell(0,0, 'A ');

    $pdf->SetFont('Helvetica','',7);
    $pdf->SetXY(270,42);
    $pdf->Cell(0,0,  date("Y-m-d",strtotime($fechaFinal)));

        
    
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
    $pdf->Cell(40,5,utf8_decode('Fecha'),0,1,'C',1);


      
 

//Comienzo a crear las filas de productos según la consulta mysql
    $pdf->Ln(5);
           //consulta sin LIMIT

        //    when UPPER('dpto') then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id ))
        //    when  UPPER('sub') then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id )) 
        //    when  UPPER('CONSEJO') then UPPER(cg.nombre)  ELSE UPPER(cgg.nombre)
        //    END END AS Direccion,

        $sql = " -- req 

        SELECT rq.IdRequisicion,
        CASE cg.nivel WHEN   UPPER('dir') THEN (select UPPER(nombre)from cat_gerarquia where id=  cg.id)
        WHEN  '-'   THEN UPPER(cg.nombre)
        ELSE 
        CASE cgg.nivel     

        WHEN (UPPER('dpto') )  THEN  (
			CASE  cg.nivel when 'del' THEN		 
            (select UPPER(nombre)from cat_gerarquia where id=19 )
            else
            (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id ))
		    END
		)		 

        WHEN UPPER('sub') THEN (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id ))
        WHEN UPPER('CONSEJO') THEN UPPER(cg.nombre)
        END 
        END AS Direccion,
        
         UPPER(cg.nombre) as Departamento, 
        tr.Requisicion, er.DesEstatus,   rq.FechaMod FROM req_requisiciones AS rq 
        INNER JOIN req_detallerequisicion AS dr on rq.IdRequisicion=dr.IdRequisicion
        INNER JOIN req_estatusreq AS er ON rq.IdEstatus=er.IdEstatus

        INNER JOIN req_tiporequisicion tr ON tr.IdTipoRequisicion=rq.IdTipoRequisicion 
        INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento 
        LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia ";
          // sr.FechaCrea, INNER JOIN req_seguimiento AS sr ON sr.IdRequisicion=rq.IdRequisicion "; 
        $sql = $sql."WHERE ";
        $sql = $sql."(rq.IdEstatus <> 6 and rq.IdEstatus<> 2) ";
       
       
        if($iddir>0 && $iddir!=$iddpto)
        {
            //$sql = $sql." AND (cgg.id = ".$iddir.") ";
            //$sql = $sql." AND (cgg.id = ".$iddir.") ";
            if($iddir==19 && ($iddpto!=20 && $iddpto!=21))
            {
                $sql = $sql." AND (cgg.id in(select  cat_gerarquia.id from cat_gerarquia where dependencia= 21 or id= 21))";
            }else{
            $sql = $sql." AND (cgg.id in(select  cat_gerarquia.id from cat_gerarquia where dependencia= ".$iddir." or id= ".$iddir."))";
            }
            //$sql = $sql." AND (cgg.id in(select  cat_gerarquia.id from cat_gerarquia where dependencia= ".$iddir." or id= ".$iddir."))";
        }
        
        if($iddpto>0)
        {
            $sql = $sql." AND (cg.id = ".$iddpto.") ";
        }
       /// $sql = $sql."AND ((sr.FechaCrea>= '".$fechaInicio."' AND sr.FechaCrea<= '".$fechaFinal."' ) AND sr.IdEstatus=3) ";    // descomentar para requisiciones autorizadas
        $sql = $sql."AND ((rq.FechaMod>= '".$fechaInicio."' AND rq.FechaMod<  DATE_ADD('".$fechaFinal."', INTERVAL 1 DAY) ) AND rq.IdEstatus=5) "; 



        $sql = $sql." AND ((rq.idTipoRequisicion =".$idTipo.")) ";
        //$sql = $sql."GROUP BY rq.IdRequisicion ORDER BY sr.FechaCrea ASC"; // descomentar para requisiciones autorizadas
        $sql = $sql."GROUP BY rq.IdRequisicion ORDER BY rq.IdRequisicion ASC";

       $rc= $conexion -> query($sql); 

        $r_count = $rc -> num_rows;
            
        if ($r_count<=0)
            {   // en caso de haya resultados, hacer uno nuevo
                historia($nitavu,'Req_Busqueda fallida de '.$search.'-'.$fechaInicio.'-'.$fechaFinal);
               
                //mensaje($msg,"./req.php");
            }
    else
    {             
    $cont=0;         
    historia($nitavu,'Req_Busqueda exitosa de '.$search.'-'.$fechaInicio.'-'.$fechaFinal);
    while($cat = $rc -> fetch_array())
     {
        $cont=$cont+1; 
        $id=$cat['IdRequisicion'];; 
        $direccion = $cat['Direccion'];
        $departamento = $cat['Departamento'];
        $tipoReq = $cat['Requisicion'];  
         //$estatus = $cat['FechaCrea'];   
        $fechamod = $cat['FechaMod'];  
       

       $pdf->SetFont('Helvetica','',6);
        $pdf->Cell(15,3,$cont,0,0,'C',0); 
        $pdf->Cell(15,3,utf8_decode($id),0,0,'C',0); 
        $pdf->Cell(75,3,utf8_decode($direccion),0,0,'L',0);
        $pdf->Cell(75,3,utf8_decode($departamento),0,0,'l',0); 
        $pdf->Cell(55,3,utf8_decode($tipoReq),0,0,'C',0);
        $pdf->Cell(35,3,utf8_decode($fechamod),0,0,'C',0);
        $pdf->Ln(4);
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
    else
    {
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
          if($iddir!=$iddpto)
         { 
        $pdf->SetXY(8,34);
        $pdf->Cell(0,0, utf8_decode($nomdir)); 
        }
        $pdf->SetFont('Helvetica','B',7);   
        $pdf->SetXY(8,37);
        $pdf->Cell(0,0, utf8_decode($nomdpto)); 


        $pdf->SetFont('Helvetica','B',7);   
        $pdf->SetXY(8,42);
        $pdf->Cell(0,0, utf8_decode("PRODUCTOS ENTREGADOS")); 


        $pdf->SetFont('Helvetica','B',7);
        $pdf->SetXY(120,42);
        $pdf->Cell(0,0, utf8_decode("RANGO DE FECHAS:"));

        $pdf->SetFont('Helvetica','',7);  
        $pdf->SetXY(150,42);
        $pdf->Cell(0,0,  date("Y-m-d",strtotime($fechaInicio)));
      
        $pdf->SetFont('Helvetica','B',7);
        $pdf->SetXY(170,42);
        $pdf->Cell(0,0, 'A ');

        $pdf->SetFont('Helvetica','',7);
        $pdf->SetXY(180,42);
        $pdf->Cell(0,0,  date("Y-m-d",strtotime($fechaFinal)));

     
       
           
        
        

      /////////////////////////TABLA////////////////////////////////////////////////////////////////////////

       $pdf->Ln(5);
        //Creamos las celdas para los titulo de cada columna y le asignamos un fondo gris y el tipo de letra
        $pdf->SetFillColor(232,232,232); 
        $pdf->SetFont('Helvetica','B',7);   
        $y = $pdf->GetY();
        $pdf->SetXY(10,$y);
        $pdf->Cell(10,5,'#',0,0,'C',1);
        // $pdf->Cell(30,5,utf8_decode('TIPO DE REQUISCION'),0,0,'C',1);
         $pdf->Cell(50,5,utf8_decode('CANTIDAD'),0,0,'C',1);
        $pdf->Cell(130,5,utf8_decode('PRODUCTO'),0,0,'C',1);
       
        $pdf->Ln(5);
      
       


          
       

    //Comienzo a crear las fiulas de productos según la consulta mysql
            $pdf->Ln(5);
               //consulta sin LIMIT

               //-- INNER JOIN req_seguimiento AS sr ON sr.IdRequisicion=rq.IdRequisicion --  //descomentar para requisiciones autorizadas 
            $sql = " -- req 

            SELECT dr.IdConcepto,rc.Concepto, sum(dr.cantidad) as Cantidad ,rq.FechaMod,tr.Requisicion
            FROM req_detallerequisicion AS dr RIGHT JOIN req_conceptos AS rc ON dr.IdConcepto=rc.IdConcepto 
            LEFT JOIN req_requisiciones AS rq on rq.IdRequisicion=dr.IdRequisicion
             
            INNER JOIN req_tiporequisicion as tr on tr.IdTipoRequisicion=rc.IdTipoRequisicion   
            INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento 
            LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia 
            WHERE dr.Cancelado=0 AND  (dr.IdRequisicion IS NOT NULL or dr.IdRequisicion!=0)";
            ///$sql = $sql."AND sr.IdEstatus=3 ";  //descomentar para requisiciones autorizadas
           /// $sql = $sql."AND rq.IdEstatus in(3,4,5) ";//descomentar para requisiciones autorizadas
            $sql = $sql."AND (rc.Concepto LIKE '%".$search."%' ) ";
                
             if($iddir>0 && $iddir!=$iddpto )
        {
            //$sql = $sql." AND (cgg.id = ".$iddir.") ";
            if($iddir==19 && ($iddpto!=20 && $iddpto!=21))
            {
                $sql = $sql." AND (cgg.id in(select  cat_gerarquia.id from cat_gerarquia where dependencia= 21 or id= 21))";
            }else{
            $sql = $sql." AND (cgg.id in(select  cat_gerarquia.id from cat_gerarquia where dependencia= ".$iddir." or id= ".$iddir."))";
            }
        }
         
           
            if($iddpto>0)
            {
                $sql = $sql." AND (cg.id = ".$iddpto.") ";
            }
            //$sql = $sql."AND (sr.FechaCrea>= '".$fechaInicio."' AND sr.FechaCrea<= '".$fechaFinal."' ) ";    //descomentar para requisiciones autorizadas
            $sql = $sql."AND ((rq.FechaMod>= '".$fechaInicio."' AND rq.FechaMod<  DATE_ADD('".$fechaFinal."', INTERVAL 1 DAY) ) AND rq.IdEstatus=5) "; 
            $sql = $sql."GROUP BY dr.IdConcepto HAVING sum(dr.Cantidad)>0 order by rc.Concepto ";
        
            
      
            $rc= $conexion -> query($sql);    
            $r_count = $rc -> num_rows;
            
        if ($r_count<=0)
            {   // en caso de haya resultados, hacer uno nuevo
                historia($nitavu,'Req_Busqueda fallida de '.$search.'-'.$fechaInicio.'-'.$fechaFinal);
               
                //mensaje($msg,"./req.php");
            }else
            {           
            $cont=0;
            historia($nitavu,'Req_Busqueda exitosa de '.$search.'-'.$fechaInicio.'-'.$fechaFinal); 

            while($cat = $rc -> fetch_array())
            {
            $cont=$cont+1; 
            $concepto=$cat['Concepto'];
            $tipoReq = $cat['Requisicion']; 
            $cantidad = $cat['Cantidad'];
             
           

            $pdf->SetFont('Helvetica','',6);
            $pdf->SetFont('Helvetica','B',6);   
            $pdf->Cell(10,3,$cont,0,0,'C');
            $pdf->SetFont('Helvetica','',6);   
            // $pdf->Cell(50,5,utf8_decode($tipoReq),0,0,'C');
            $pdf->Cell(50,3,utf8_decode($cantidad),0,0,'C'); 
            $pdf->MultiCell(130,3,utf8_decode($concepto),0,'L'); 
           
         //   $space = (isset($y2) ? $y2- $y : 0) + 2; 
           
            $pdf->Ln(1);
        }
            }
    }
    echo $sql;
   $pdf->Output();


    }



//////////////////////////////////////PIE////////////////////////////////////////////////////
}
else
{
    echo " <br><br>"; "No tiene acceso a ".$id_aplicacion;
}
   
?>

