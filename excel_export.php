<?php
require_once("config.php");
ob_start();

//archivo para recibir 

$idreporte = $_GET['n'];
$rand=(random_int(1,50));
//$iddelegacion=midelegacion_id($nitavu);

//obtener datos del registro reportes
$sqldatosreg="Select * from reportes_exporta where id=".$idreporte;
$idreporte1=$conexion-> query($sqldatosreg);
if($fdr = $idreporte1 -> fetch_array())
	{
        $queryconcat=$fdr['queryx'].$fdr['dato1'].$fdr['dato2'];
        $nomTabla="vista_reporte".$idreporte.$rand;
        $nomBD=$fdr['basededatos'];

        //creo vista en la bd correspondiente
        $sqlvw="CREATE VIEW 
        ".$nomTabla." AS ".$fdr['queryx'];

        if ($nomBD=='produccion_itavu'){
            $r= $conexion -> query($sqlvw);		
           // return true;			
        }
        else{
            $r= $vivienda -> query($sqlvw);					
            //return true;
        }        
	} else {

		return 0;
	}
$sql="";
$sql="SELECT `COLUMN_NAME` 
FROM `INFORMATION_SCHEMA`.`COLUMNS` 
WHERE `TABLE_SCHEMA`='".$nomBD."' AND 
   `TABLE_NAME`='".$nomTabla."'";

$rc= $conexion -> query($sql);
$row_cnt = $rc->num_rows;
$cont=0;

if($row_cnt>0)
{		
    $salida = "";
    $salida .= "<table>"; 
    $salida .= "<tr colspan=10>".$fdr['nombrereporte']."<tr>"; 
    $salida .= "<tr colspan=10>".$fdr['subtituloreporte']." ".$fdr['dato1'] ."<tr>"; 
    $salida .= "<thead> <th style='background-color:gray;'>Num.</th>";
    //creo los encabezados
    
    while($cat = $rc -> fetch_array())
    { // resultado de la busqueda.................
     $salida .= " <th style='background-color:gray;'>".$cat[COLUMN_NAME]."</th>";    
	}
    $salida .="</thead>";
}


$sqldatos="SELECT * FROM ".$nomTabla;
$rcdat= $conexion -> query($sqldatos);

$row_cntdat = $rcdat->num_rows;
$contdat=0;

if($row_cntdat>0)
 {		
    $salida .="<tbody><tr>";
    while($catdat = $rcdat -> fetch_array())
            { // resultado de la busqueda.................
            
                $salida .= "<tr>";
               // mysql_data_seek ( $rc, 0);
                //mysql_data_seek ( $cat, 0);
                $salida .= "<td  >". $contdat=$contdat+1;  "</td>";		  
                //ciclo de columna

                $rc2= $conexion -> query($sql);
               
                while($cat2 = $rc2 -> fetch_array())
                    { // resultado de la busqueda.................
                    $salida .= " <td>".$catdat[$cat2[COLUMN_NAME]]."</td>";    
                    }

                $salida .= "</tr>";
                            
            }
     $salida .=" </tr> </tbody></table>";
}
 

//iso-8859-1
//ISO-8859-1
//utf-8
//WORD
//header('Content-type: application/vnd.ms-word');
// header("Content-Disposition: attachment; filename=archivo.doc");
// header("Pragma: no-cache");

//echo $salida ;
header("Content-type: application/vnd.ms-excel; charset=UTF-8");
//header("Content-type:   application/x-msexcel; charset=ISO-8859-1");
header("Content-Disposition: attachment; filename=ExportadoExcel".$hora.".xls");
header("Pragma: no-cache");
header("Expires: 0");
ob_end_clean();
echo $salida;

 $sql="";
$sql="drop view if exists ".$nomTabla;

        if ($nomBD=='produccion_itavu'){
            $r= $conexion -> query($sql);		
           // return true;			
        }
        else{
            $r= $vivienda -> query($sql);					
            //return true;
        }
 


?>