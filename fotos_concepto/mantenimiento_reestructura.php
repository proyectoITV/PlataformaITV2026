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


///historia($nitavu,"(MySQL Reestructura) BD-ITAVU: Iniciando Reestructura de Contratos, reestructurando tabla contratos (agregando curp e idsolicitantes)<label>* Esta BD aun no esta en produccion, estamos trabajando para mejorar la integridad de una nueva estructura");
while ($reg <= $totalderegistros){
   //echo "LIMIT ".$reg.", ".$bloque."<br>";
   $sql2 = $sql." LIMIT ".$reg.", ".$bloque; 

   //historia($nitavu,"(MySQL Reestructura) BD-ITAVU: Reestructura de Contratos [integracion de curp y idsolicitante] Iniciando ".$reg." a ".$bloque." de ".$totalderegistros."<label>".$sql2."</label>");
      $r= $conexion_central -> query($sql2); 
      //  echo "<h3>Bloque ".$reg."</h3><label>".$sql2."</label>";
      // echo "<table class='tabla'>";
      // echo "<th>Tiempo</th>";
      // echo "<th>Foliop (contrato)</th>";
      // echo "<th>Foliop (solicitud)</th>";
      // echo "<th>idsolicitante (solicitud)</th>";
      // echo "<th>CURP</th>";
      // echo "<th></th>";
      $c=0;
      echo "-- bloque ".$reg." (".$hora.")<br>";
      while($x = $r -> fetch_array())
      {  
         //echo "<tr>";
         $hora =  date ("H:i:s");

         // echo "<td>".$hora."</td>";
         // echo "<td>".$x['contratos_foliop']. "</td>";
         // echo "<td>".$x['solicitudes_foliop']."</td>";
         // echo "<td>".$x['solicitudes_idsolicitante']."</td>";
         // echo "<td>".$x['curp']."</td>";

         //echo "<td>";
               $sql_c="UPDATE contratos SET idsolicitante='".$x['solicitudes_idsolicitante']."', curp='".$x['curp']."' WHERE foliop='".$x['contratos_foliop']."'";
               
               echo $sql_c.";<br>";

               $c= $c + 1;


               // $resultado = $conexion_central -> query($sql_c);
               // if ($conexion_central->query($sql) == TRUE) {
               //    echo "<b class='ejecutandose'>OK</b><label>".$sql_c."</label>"; 
               //    //historia($nitavu,"BD-ITAVU: Agregando curp (".$x['curp'].") y idsolicitante (".$x['solicitudes_idsolicitante'].") al contrato ".$x['NumContrato']." con Folio de solicitud: ".$x['contratos_foliop']);
               // }
               // else 
               // {
               //    echo "<b class='alerta'>X</b><label>".$sql_c."</label>";                  
               //    historia($nitavu,"BD-ITAVU: <b class='alerta'>ERROR</b> Agregando curp (".$x['curp'].") y idsolicitante (".$x['solicitudes_idsolicitante'].") al contrato ".$x['NumContrato']." con Folio de solicitud: ".$x['contratos_foliop']."<br>".$sql_c);

               // }
               // $resultado->close();
               
         //echo "</td>";
         //update a contratos con pausa
         //sleep(5);
         //echo "<script>sleep(10);</script>";


         
         //echo "</tr>";

      }
      //echo "</table>";
      echo "<h1>COMPLETADO</H1>";
      $r->close();
historia($nitavu,"BD-ITAVU: Fin (MySQL Reestructura) BD-ITAVU: Reestructura de Contratos, reestructurando tabla contratos (agregando curps e idsolicitantes");





$reg  = $reg + $bloque; // aumento del bloque

}
      


?>



<?php
include ("./unica/body_footer.php");
?>