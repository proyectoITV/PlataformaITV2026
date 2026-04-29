<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>
<br><br><br><br>
<h1>REESTRUCTURA DE LA BASE DE DATOS</h1>
<p>
   Agregar IdSolicitante a la Tbl Contratos
</p>



<?php
echo "<label>Inicio del proceso: <b>".$fecha." | ".$hora."<br></label><hr>";
$sql="

-- Agregar CURP e idSolicitante a Contratos

SELECT
   contratos.foliop AS contratos_foliop,
   (
      SELECT
         solicitudes.foliop         
      FROM
         solicitudes
      WHERE
         solicitudes.foliop = contratos_foliop
   ) as solicitudes_foliop,

   (
      SELECT
         solicitudes.idsolicitante as solicitud_idsolicitante        
      FROM
         solicitudes
      WHERE
         solicitudes.foliop = contratos_foliop
   ) as solicitudes_idsolicitante,

   contratos.idsolicitante as Contrato_solicitante,
   (select solicitantes.curp from solicitantes where solicitantes.IdSolicitante = solicitudes_idsolicitante) as curp,
   contratos.NumContrato

FROM
   contratos,
   solicitudes


";

$reg= 0;
$totalderegistros = 768031;
//$totalderegistros = 1000;
$bloque = 100;


$file=fopen("sql/contratos_curpsysolicitantes_ver1.sql","w+") or die("Problemas");
$contenido ="";
while ($reg <= $totalderegistros){
   $sql2 = $sql." LIMIT ".$reg.", ".$bloque; 
   $r= $conexion_central -> query($sql2); 

      $c=0;
      $contenido = $contenido."-- bloque ".$reg." (".$hora.")\n";
      fputs($file,"-- bloque ".$reg." (".$hora.")\n");


      while($x = $r -> fetch_array())
      {  
         $hora =  date ("H:i:s");
               $sql_c="UPDATE contratos SET idsolicitante='".$x['solicitudes_idsolicitante']."', curp='".$x['curp']."' WHERE foliop='".$x['contratos_foliop']."'";
               
                 $contenido = $contenido.$sql_c.";\n";
                 fputs($file,"".$sql_c.";\n");

      }
      //echo "</table>";
        $contenido = $contenido. "\n -- COMPLETADO\n";
      $r->close();



$reg  = $reg + $bloque; // aumento del bloque
echo $reg."<br>";
}
mensaje("Completado",'');
fclose($file);
// $control = fopen("sql/miarchivo.txt","w+");
// if($control == false){
//   die("No se ha podido crear el archivo.");
// }


//   //vamos añadiendo el contenido
//   fputs($file,"primera linea");
//   fputs($file,"\n");
//   fputs($file,"segunda linea");
//   fputs($file,"\n");
//   fputs($file,"tercera linea");
//   fclose($file);

?>



<?php
include ("./unica/body_footer.php");
?>