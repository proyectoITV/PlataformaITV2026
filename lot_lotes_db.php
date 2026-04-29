<?php
require("seguridad.php"); 
 require_once("config.php");
 require_once("lib/funciones.php");
 require_once("lib/yes_funciones.php");

///error_reporting(0); //<-- para simular produccion

//$IdDelegacion = $_POST['IdDelegacion'];
//$DelegacionNombre = delegacion_id($IdDelegacion);

$id_aplicacion ="ap103"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
// $InformacionDelServidor = DatosDeConeccion($IdDelegacion);
$nitavu = $_POST['nitavu'];
$all = $_POST['all'];
$m = $_POST['m'];





// $sqlx = "
// select* FROM lotes 
// inner join catcolonia on lotes.IdMunicipio=catcolonia.IdMunicipio
// and catcolonia.IdColonia
// WHERE
// catcolonia.IdMunicipio = ".$m."
// AND  catcolonia.Colonia like '%".$QueBusco."%'
// ORDER BY  
// catcolonia.IdColonia,
// catcolonia.IdMunicipio";

if ($all==0)
{
// **  BUSQUEDA POR EL NOMBRE DE LA COLONIA
$QueBusco = $_POST['QueColonia']; 

$ids=IdColoniasPorNombre($QueBusco,$m);
if($ids=='')
{
   echo sugerencia("No se han encontrado resultados");
   return;
}


echo "<div id='Colaboradores' style='width:100%;'>";
// echo" <div id='GraficaEstatus'></div>";
// $sql = "select IdEstatus,EstatusLote, count(IdEstatus) as Cantidad
// FROM vivienda_cartografia2 WHERE   
// IdMunicipio=".$m ." and IdColonia in (". $ids .")
// GROUP BY IdEstatus,EstatusLote";
//  //echo $sql;
// $r= $Vivienda -> query($sql);
// $data = "";
// while($f = $r -> fetch_array()) {
//    $data = $data."['".$f['EstatusLote']."',".$f['Cantidad']."],";

// }
// $data = substr($data, 0, -1); //quita la ultima coma.
// echo "<script>
// GraficaEstatus();


//    function GraficaEstatus(){
//       google.charts.load('current', {packages:['corechart']});
//       google.charts.setOnLoadCallback(drawChart);
//       function drawChart() {
//       var data = google.visualization.arrayToDataTable([
//          ['Estatus', 'Cantidad de Lotes'], ".$data."
         
            
//       ]);

//       var options = {
//          title: 'Estatus de los lotes',
         
//          is3D: true
         
         
//       };

//       var chart = new google.visualization.PieChart(document.getElementById('GraficaEstatus'));
//       chart.draw(data, options);
//       }
//    }
//    </script>   ";
//    echo "</div>";
 




if($nivel==1 )
{   
   //consulta a la vista
   // $sqlx = "select idLote, Municipio,Colonia,seccion, fila,manzana, lote, EstatusLote,
   // CONCAT(' <a  href=lot_lotes_edit.php?id=',idLote,'><center><img src=\"./icon/edit.png\" height=\"20\" width=\"15\" title=\"Editar lote\"><center></a>')
   // as '' from vivienda_cartografia2 WHERE IdMunicipio = ".$m." AND  IdColonia In (".$ids.") ";
   
    $sqlx = "select idLote, '".NombreMunicipioVivienda($m)."' as Municipio, Colonia as Colonia,seccion, fila,manzana, lote,
    CONCAT(' <a  href=lot_lotes_edit.php?id=',idLote,'><center><img src=\"./icon/edit.png\" height=\"20\" width=\"15\" title=\"Editar lote\"><center></a>')
 as '' ,  
CONCAT(' <a id=\"DarBajaLote\" href=\"?m=".$m."&mensaje&idlote=',idLote,'\"  title=\"Dar de baja Lote\"><center><img src=\"icon/eliminar.png\" style=\"width:20px;\"></center> </a>') AS ''
 FROM lotes WHERE IdMunicipio = ".$m." AND  IdColonia In (".$ids.")  and (Cancelado!=1)"; 
}
else
{
   $sqlx = "select idLote, '".NombreMunicipioVivienda($m)."' as Municipio, Colonia as Colonia,seccion, fila,manzana, lote,
   CONCAT(' <a  href=lot_lotes_consulta.php?id=',idLote,'><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar lote\"><center></a>')
   as '',   
CONCAT(' <a id=\"DarBajaLote\" href=\"?m=".$m."&mensaje&idlote=',idLote,'\"  title=\"Dar de baja Lote\"><center><img src=\"icon/eliminar.png\" style=\"width:20px;\"></center> </a>') AS ''
 FROM lotes WHERE IdMunicipio = ".$m." AND  IdColonia In (".$ids.")  and (Cancelado!=1)"; 
}


}
else
{
  // **  BUSQUEDA POR UN LOTE EN ESPECIFICO
   $m = $_POST['m'];
   $idcol = $_POST['IdColonia'];
   $sec = $_POST['Seccion'];
   $fila = $_POST['Fila'];
   $man = $_POST['Manzana'];
   $lote = $_POST['Lote'];
    
      if($nivel==1 )
      {

      $sqlx = "select idLote, '".NombreMunicipioVivienda($m)."' as Municipio, Colonia as Colonia,seccion, fila,manzana, lote,
      CONCAT(' <a  href=lot_lotes_edit.php?id=',idLote,'><center><img src=\"./icon/edit.png\" height=\"20\" width=\"15\" title=\"Editar lote\"><center></a>') AS ''
      ,CONCAT(' <a id=\"DarBajaLote\" href=\"?m=".$m."&mensaje&idlote=',idLote,'\"  title=\"Dar de baja Lote\"><center><img src=\"icon/eliminar.png\" style=\"width:20px;\"></center> </a>') AS ''
      FROM lotes
      WHERE
      IdMunicipio = ".$m."
      AND IdColonia = ".$idcol."
      AND IFNULL(seccion, '') = '".$sec."'
      AND  IFNULL(fila, '')  = '".$fila."'
      AND manzana = '".$man."'
      AND lote = '".$lote."' and (Cancelado!=1)";
      }
      else
      {
      $sqlx = "select idLote, '".NombreMunicipioVivienda($m)."' as Municipio, Colonia as Colonia,seccion, fila,manzana, lote,
      CONCAT(' <a  href=lot_lotes_consulta.php?id=',idLote,'><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar lote\"><center></a>') AS ''
      ,CONCAT(' <a id=\"DarBajaLote\" href=\"?m=".$m."=&mensaje&idlote=',idLote,'\"  title=\"Dar de baja Lote\"><center><img src=\"icon/eliminar.png\" style=\"width:20px;\"></center> </a>') AS ''
      FROM lotes
      WHERE
      IdMunicipio = ".$m."
      AND IdColonia = ".$idcol."
      AND IFNULL(seccion, '') = '".$sec."'
      AND  IFNULL(fila, '')  = '".$fila."'
      AND manzana = '".$man."'
      AND lote = '".$lote."'  and ( Cancelado!=1)"; 
      }
  


}

//echo   $sqlx ;
echo "<div id='ListaDeLotes' style='background-color:#EEEEEE; width:95%; display:inline-block;
border-radius:5px; padding:10px; margin-top:20px;'>";
echo "<h2>Lotes Encontrados</h2>";
TablaDinamica_MySQLVivienda("",$sqlx, "LotesDiv", "TablaLotes", "", 2); 
echo "</div>";


// $r= $Vivienda -> query($sqlx); 
// $r_count = $r -> num_rows;

// if ($r_count>0)
// { 
//     echo "<h4>Lotes detectados: ".$r_count ."</h4>";
//     echo "<table class='tabla'>";
//     echo "<th>IDOLOTE</th><th>COLONIA</th>
//     <th>SECCION</th><th>FILA</th><th>MANZANA</th><th>LOTE</th>
    
   
//     <th>ESTATUS </th>";
//    if($nivel==1)
//    {
//     echo "<th> </th>";
//    }
    
//           while($f = $r -> fetch_array())
//           { 
       
       
//         echo "<tr>";
//         echo "<td>".$f['idLote']."</td>";
//         // echo "<td>".$f['Municipio']."</td>";
//         echo "<td>".$f['Colonia']."</td>";
//         echo "<td>".$f['seccion']."</td>";
//         echo "<td>".$f['fila']."</td>";
//         echo "<td>".$f['manzana']."</td>";
//         echo "<td>".$f['lote']."</td>";
//         //echo "<td> ".ValidarLoteCompleto($f['idLote'])."</td>";
//         echo "<td>".$f['EstatusLote']."";

//         if(ValidarLoteCompleto($f['idLote'])=='FALSE')
//         {
//           echo "<BR><BR><span style='color:red;'>* A este lote, le faltan algunos datos requeridos.</span>";
//         }
//        if( $f['NumEscritura']!='')
//        {
//           if (  $f['IRPP']!='1')
//           {
//             echo "<BR><BR><span style='color:blue;'>ESCRITURADO</span>";
//           }else
//           {
//             echo "<BR><BR><span style='color:blue;'>EN PROCESO DE ESCRITURACIÓN</span>";

//           }

          
        

//        }
   
//         echo "</td>";
//         if($nivel==1 )
//         {
//          if($f['EstatusLote']<>"ASIGNADO" )
//          {
//          echo "<td>";
//          echo '<a  href="lot_lotes_edit.php?id='.$f['idLote'].'"><center><img src="./icon/edit.png" height="20" width="15" title="Editar lote"><center></a>';        
//          echo "</a>";
//          echo "</td>";
//          }
//          else 
//          {
//           echo "<td>";
//           echo '<a  href="lot_lotes_consulta.php?id='.$f['idLote'].'"><center><img src="./icon/ojo2.png" height="12" width="20" title="Editar lote"><center></a>';        
//           echo "</a>";
//           echo "</td>";
//           }
         


//          }
//         echo "</tr>";
//       }           
 
//           } else {
//               mensaje("ERROR: No hubo resultados en la busqueda",'lot_capturalotes.php?m=');
//           }
        
//         echo "</table><br><label style='font-size:8pt;'>* Este es el resultado de una busqueda en los lotes de ITAVU.</label>";





?>

