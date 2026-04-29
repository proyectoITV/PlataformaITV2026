<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>
<?php
//modulo para ingresos

$id_aplicacion ="ap60"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
      echo "<h5>".app_detalle($id_aplicacion)."</h5>";
      
      if (isset($_POST['fechabuscada'])){
            $fecha1=$_POST['fechabuscada'];
      }
      else {
            $fecha1 = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
					$fecha1 = date('Y-m-d',$fecha1);
      }
            $sql = "SELECT     cat_delegaciones.id, cat_delegaciones.nombre,
            (
            (SELECT SUM(Monto) AS cobrado FROM IngresosDiarios AS ID WHERE (FechaCobranza = '$fecha1' ) AND
            (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IC')))
            +
            (SELECT SUM(Monto) AS cobrado FROM IngresosDiarios AS ID WHERE (FechaCobranza = '$fecha1')
            AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IV'))) 
            +
            IFNULL((SELECT SUM(Monto) AS cobrado FROM IngresosDiarios AS ID WHERE (FechaCobranza = '$fecha1')
            AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('AH'))),0) 
            +
            IFNULL((SELECT SUM(Monto) AS cobrado FROM IngresosDiarios AS ID WHERE (FechaCobranza = '$fecha1')
            AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('AC'))),0) 
            +
            IFNULL((SELECT SUM(Monto) AS cobrado FROM IngresosDiarios AS ID WHERE (FechaCobranza = '$fecha1')
            AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IE'))),0) 
            +
            IFNULL((SELECT SUM(Monto) AS cobrado FROM IngresosDiarios AS ID WHERE (FechaCobranza = '$fecha1')
            AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('XC'))),0) 
            +
            IFNULL((SELECT SUM(Monto) AS cobrado FROM IngresosDiarios AS ID WHERE (FechaCobranza = '$fecha1')
            AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('XV'))),0) 
            )as total,


            (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza =  '$fecha1') AND 
            (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IC'))) AS alcorriente, 
            (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza = '$fecha1')  
            AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IV'))) AS vencido,
            (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza = '$fecha1')   
            AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('XC'))) AS OxxoCorriente, 
            (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      
            (FechaCobranza =  '$fecha1')    AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('XV'))) AS OxxoVencido, 

            (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza = '$fecha1') 
            AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('AH'))) AS AhorroSinCont,
            (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza = '$fecha1')    
            AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('AC'))) AS AhorroConCont, 
            (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza =  '$fecha1')
                  AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IE'))) AS IngEspeciales,
            (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza = '$fecha1')
                  AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IE') and (TIPOPAGO=58) )) AS IngEspecialesEscrit,       
                        (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza =  '$fecha1')
                  AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IE') and (TIPOPAGO=66) )) AS IngEspecialesServ,
                  (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza =  '$fecha1')
                  AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IE') and (TIPOPAGO=67) )) AS IngEspecialesReint,
                  (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza =  '$fecha1')
                  AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IE') and (TIPOPAGO=62) )) AS IngEspecialesCesion,
                  (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza =  '$fecha1')
                  AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IE') and (TIPOPAGO=74) )) AS IngEspecialesAsig,
                  (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza =  '$fecha1')
                  AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IE') and (TIPOPAGO=75) )) AS IngEspecialesGrav,
                  (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza =  '$fecha1')
                  AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IE') and (TIPOPAGO=76) )) AS IngEspecialesTopo,
                  (SELECT     SUM(Monto) AS cobrado FROM          IngresosDiarios AS ID WHERE      (FechaCobranza =  '$fecha1')
                  AND (IdDelegacion = cat_delegaciones.id) AND (Tipo IN ('IE') and (TIPOPAGO=77) )) AS IngEspecialesBusD




            From cat_delegaciones WHERE     (cat_delegaciones.id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 17, 18, 19, 20, 65, 66, 67, 68,69)) 
            GROUP BY cat_delegaciones.id, cat_delegaciones.nombre
            ORDER BY cat_delegaciones.nombre";



            echo $sql;
            echo"<div id='TablaIngresos'>";
            //intento cambiar la fecha -1 con la flecha
            if (isset($_POST['fechabuscada'])){
                  $fechamenos=$_POST['fechabuscada'];
            }
            else {
                  $fechamenos = strtotime ( '-1 day' , strtotime ( $fecha1 ) ) ;
                                          $fechamenos = date('Y-m-d',$fechamenos);
            }


            echo "<form action='ingresos.php' method='POST'>";
            echo "<div><input type='date' name='fechabuscada' value='$fecha1'></div>";
            echo" <div><input type='submit' name='btbusca' value='Buscar' class='btn btn-default' ></div>";


            //<a href="https://developer.mozilla.org/"><img src="mdn-logo-sm.png" alt="MDN"></a>
            //echo"<td><a href='Ingresos_PorPrograma.php?fecha1=".$fecha1."&IdDelegacion=".$f['id']."&Delegacion=".$f['nombre']."'>".$f['nombre']."</a></td>";
            //original 
            echo "<a href='ingresos.php'><img src='img/flecha1.jpg' ></a>";
            // echo "<a href='ingresos.php?fecha1=".$fechamenos."><img src='img/flecha1.jpg' ></a>";


            echo "</form>";


            //<th> encabezados de columna
            //<td> campo
            echo "<table class='tabla'>";
            echo"<th>Delegacion</th>";
            echo"<th>Total Diario</th>";
            echo"<th class='pc'>Pagos al corriente</th>";
            echo"<th class='pc'>Pagos vencidos</th>";
            echo"<th class='pc'>Pagos oxxo al corriente</th>";
            echo"<th class='pc'>Pagos oxxo vencidos</th>";
            echo"<th class='pc'>Ahorros</th>";
            echo"<th class='pc'>Ahorros Comprom.</th>";
            echo"<th class='pc'>Escrituras</th>";
            echo"<th class='pc'>Reintegros</th>";
            echo"<th class='pc'>Cesiones</th>";
            echo"<th class='pc'>Carta Asignación</th>";
            echo"<th class='pc'>Liberación de Gravamen</th>";
            echo"<th class='pc'>Levantamientos Topográficos</th>";
            echo"<th class='pc'>Búsqueda de Documentos</th>";

            $r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
            {
            echo"<tr>";
            //echo"<td>".$f['nombre']."</td>";
            // echo"<td><a href=?m.$GET['m']".$f['nombre']."</a></td>";
            echo"<td><a href='Ingresos_PorPrograma.php?fecha1=".$fecha1."&IdDelegacion=".$f['id']."&Delegacion=".$f['nombre']."'>".$f['nombre']."</a></td>";
            //echo"<td><a href='Ingresos_PorPrograma.php?fecha1=".$fecha1."&IdDelegacion=".$f['id']."'>".$f['nombre']."</a></td>";
            echo"<td text-align: rigth>".$f['total']."</td>";
            echo"<td class='pc'>".$f['alcorriente']."</td>";
            echo"<td class='pc'>".$f['vencido']."</td>";    
            echo"<td class='pc'>".$f['OxxoCorriente']."</td>";    
            echo"<td class='pc'>".$f['OxxoVencido']."</td>";    
            echo"<td class='pc'>".$f['AhorroSinCont']."</td>";
            echo"<td class='pc'>".$f['AhorroConCont']."</td>";  
            echo"<td class='pc'>".$f['IngEspecialesEscrit']."</td>";
            echo"<td class='pc'>".$f['IngEspecialesReint']."</td>";
            echo"<td class='pc'>".$f['IngEspecialesCesion']."</td>";
            echo"<td class='pc'>".$f['IngEspecialesAsig']."</td>";
            echo"<td class='pc'>".$f['IngEspecialesGrav']."</td>";
            echo"<td class='pc'>".$f['IngEspecialesTopo']."</td>";
            echo"<td class='pc'>".$f['IngEspecialesBusD']."</td>";

            echo"</tr>";
      }
      echo "</table>";
      echo "</div>";
} else {
      mensaje("ERROR: no tienes acceso a esta aplicacion. Comunicate con el Dpto. de Informatica",'');
}
?>






<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php
include ("./unica/body_footer.php");
?>