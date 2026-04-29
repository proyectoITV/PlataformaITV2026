<?php
require_once("config.php");
ob_start();
$salida = "";
$salida .= "<table>";
$salida .= "<thead> <th>ID</th> <th>Nombre</th><th>Email</th></thead>";
// foreach($usuario->buscar() as $r){
// 	$salida .= "<tr> <td>".$r->id."</td> <td>".$r->nombre."</td><td>".$r->email."</td></tr>";
// }

$idRequisicion = $_GET['n'];
$sql = " -- req 
SELECT req_detallerequisicion.IdDetalle,req_detallerequisicion.IdConcepto,
 req_detallerequisicion.IdDepartamento,req_conceptos.Concepto,req_detallerequisicion.Cantidad,
  req_detallerequisicion.Justificacion FROM req_detallerequisicion inner join 
  req_conceptos on req_detallerequisicion.IdConcepto=req_conceptos.IdConcepto  
  where req_detallerequisicion.Cancelado=0  and req_detallerequisicion.IdRequisicion='".$idRequisicion."' GROUP BY req_detallerequisicion.IdConcepto";
//echo $sql;
    $rc= $conexion -> query($sql);
     $row_cnt = $rc->num_rows;
     $cont=0;

 if($row_cnt>0)
 {			
     
    
    $salida ="<table >";
    $salida .="<thead>
    <tr>
    <th class='pc'>#</th>        
    <th>CONCEPTO</th>
    <th>CANTIDAD</th>
    <th class='pc'>JUSTIFICACIÓN</th>
    </tr>
    </thead>
    <tbody><tr>";
    while($cat = $rc -> fetch_array())
            { // resultado de la busqueda.................
            
                $salida .= "<tr>";
                $salida .= "<td  >". $cont=$cont+1;  "</td>";		
                

                
                $salida .= "<td > ".$cat['Concepto']." </td>";						
                $salida .="<td >". $cat['Cantidad']."</td>";
                $salida .="<td >" .$cat['Justificacion']."</td>";	
                $salida .= "</tr>";
                            
            }
            $salida .=" </tr> </tbody></table>";

$salida .= "</table>";
}


//echo $salida ;
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=requisicion_".$idRequisicion.".xls");
header("Pragma: no-cache");
header("Expires: 0");
ob_end_clean();
echo $salida;

?>