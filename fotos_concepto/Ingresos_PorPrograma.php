<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

// contenido:
?>

<?php
//módulo muestra ingreso por programa

$fecha1=$_GET['fecha1'];
$IdDelegacion=$_GET['IdDelegacion'];
$Delegacion=$_GET['Delegacion'];

$sql="SELECT     IngresosDiarios.IdDelegacion, cat_programa.Programa,IngresosDiarios.IdPrograma, 
 ( select sum(monto) from IngresosDiarios as id1 where id1.idprograma=IngresosDiarios.idprograma 
 and (id1.fechacobranza=IngresosDiarios.FechaCobranza)
 and id1.iddelegacion=IngresosDiarios.iddelegacion
  and tipo in ('IC') and id1.tipopago in (3,78,79)  
group by id1.idprograma,id1.iddelegacion,id1.fechacobranza
) AS MensCorriente,
(select sum(monto) from IngresosDiarios as id2 where id2.idprograma=IngresosDiarios.idprograma 
 and (id2.fechacobranza=IngresosDiarios.FechaCobranza)
and id2.iddelegacion=IngresosDiarios.iddelegacion
and tipo in ('IV') and id2.tipopago in (3,78,79) 
 group by id2.idprograma,id2.iddelegacion
) AS MensVencido,
(select sum(monto) from IngresosDiarios as id3 where id3.idprograma=IngresosDiarios.idprograma 
and (id3.fechacobranza=IngresosDiarios.FechaCobranza)
and id3.iddelegacion=IngresosDiarios.iddelegacion
and tipo in ('XC') and id3.tipopago in (3,78,79) 
 group by id3.idprograma,id3.iddelegacion
) AS OxxoCorriente,
(select sum(monto) from IngresosDiarios as id3 where id3.idprograma=IngresosDiarios.idprograma 
and (id3.fechacobranza=IngresosDiarios.FechaCobranza)
and id3.iddelegacion=IngresosDiarios.iddelegacion
and tipo in ('XV') and id3.tipopago in (3,78,79)
group by id3.idprograma,id3.iddelegacion
) AS OxxoVencido,
(select sum(monto) from IngresosDiarios as id3 where id3.idprograma=IngresosDiarios.idprograma 
and (id3.fechacobranza=IngresosDiarios.FechaCobranza)
and id3.iddelegacion=IngresosDiarios.iddelegacion
and tipo in ('AH') and id3.tipopago in (13)
group by id3.idprograma,id3.iddelegacion
) AS AhorroSinCont,
(select sum(monto) from IngresosDiarios as id3 where id3.idprograma=IngresosDiarios.idprograma 
and (id3.fechacobranza=IngresosDiarios.FechaCobranza)
and id3.iddelegacion=IngresosDiarios.iddelegacion
and tipo in ('AC') and id3.tipopago in (13)
group by id3.idprograma,id3.iddelegacion
) AS AhorroConCont,
(select sum(monto) from IngresosDiarios as id3 where id3.idprograma=IngresosDiarios.idprograma 
and (id3.fechacobranza=IngresosDiarios.FechaCobranza)
and id3.iddelegacion=IngresosDiarios.iddelegacion
and tipo in ('IE') and id3.tipopago in (58) 
 group by id3.idprograma,id3.iddelegacion
) AS IngEspecialesEscrit,
(select sum(monto) from IngresosDiarios as id3 where id3.idprograma=IngresosDiarios.idprograma 
and (id3.fechacobranza=IngresosDiarios.FechaCobranza)
and id3.iddelegacion=IngresosDiarios.iddelegacion
and tipo in ('IE') and id3.tipopago in (67) 
 group by id3.idprograma,id3.iddelegacion
) AS IngEspecialesReint,
(select sum(monto) from IngresosDiarios as id3 where id3.idprograma=IngresosDiarios.idprograma 
and (id3.fechacobranza=IngresosDiarios.FechaCobranza)
and id3.iddelegacion=IngresosDiarios.iddelegacion
and tipo in ('IE') and id3.tipopago in (62) 
 group by id3.idprograma,id3.iddelegacion
) AS IngEspecialesCesion,
(select sum(monto) from IngresosDiarios as id3 where id3.idprograma=IngresosDiarios.idprograma 
and (id3.fechacobranza=IngresosDiarios.FechaCobranza)
and id3.iddelegacion=IngresosDiarios.iddelegacion
and tipo in ('IE') and id3.tipopago in (74) 
 group by id3.idprograma,id3.iddelegacion
) AS IngEspecialesAsig,
(select sum(monto) from IngresosDiarios as id3 where id3.idprograma=IngresosDiarios.idprograma 
and (id3.fechacobranza=IngresosDiarios.FechaCobranza)
and id3.iddelegacion=IngresosDiarios.iddelegacion
and tipo in ('IE') and id3.tipopago in (75) 
 group by id3.idprograma,id3.iddelegacion
) AS IngEspecialesGrav,
(select sum(monto) from IngresosDiarios as id3 where id3.idprograma=IngresosDiarios.idprograma 
and (id3.fechacobranza=IngresosDiarios.FechaCobranza)
and id3.iddelegacion=IngresosDiarios.iddelegacion
and tipo in ('IE') and id3.tipopago in (76) 
 group by id3.idprograma,id3.iddelegacion
) AS IngEspecialesTopo,
(select sum(monto) from IngresosDiarios as id3 where id3.idprograma=IngresosDiarios.idprograma 
and (id3.fechacobranza=IngresosDiarios.FechaCobranza)
and id3.iddelegacion=IngresosDiarios.iddelegacion
and tipo in ('IE') and id3.tipopago in (77) 
 group by id3.idprograma,id3.iddelegacion
) AS IngEspecialesBusD
FROM         IngresosDiarios INNER JOIN
 cat_programa ON IngresosDiarios.IdPrograma = cat_programa.IdPrograma
WHERE    IngresosDiarios.FechaCobranza ='$fecha1' 
 and IngresosDiarios.iddelegacion=$IdDelegacion
 and IngresosDiarios.IdPrograma<>0
group by IngresosDiarios.iddelegacion, IngresosDiarios.idprograma, cat_programa.Programa ,IngresosDiarios.FechaCobranza";

// echo $sql;

echo"<div id='TablaIngresosPorPrograma'>";

   // echo"<form action='Ingresos_PorPrograma.php?m=".$_GET['m']."' method='POST'>";
   echo"<form>";
   echo"<br><br><br><br>"; 
   echo"<h1>INFORMACION POR PROGRAMA DELEGACION $Delegacion</h1>";
   echo"<h1>Correspondiente al $fecha1</h1>";
    //echo"<div><input type='text' name='Delegacion' value='".$_GET['nombre']."'> </div>";
    //echo"<div><input type='text' name='Delegacion' value='".$Delegacion."'> </div>";
    
    echo"</form>"; 



echo"<table class='tabla'>";
    echo"<th>Programa</th>";
    echo"<th>Mens. al Corriente</th>";
    echo"<th>Mens. Vencidas</th>";
    echo"<th>Oxxo al Corriente</ht>";
    echo"<th>Oxxo Vencido</th>";
    echo"<th>Ahorro</th>";
    echo"<th>Ahorro Comprometido</th>";
    echo"<th>Escrituras</th>";
    echo"<th>Reintegros</th>";
    echo"<th>Cesiones</th>";
    echo"<th>Carta Asignación</th>";
    echo"<th>Liberación de Gravamen</th>";
    echo"<th>Levantamiento Topográfico</th>";
    echo"<th>Busqueda Documentos</th>";

    if ($conexion->query($sql) == TRUE){

    
    $r2= $conexion -> query($sql);while ($f = $r2 -> fetch_array())
     {
        echo"<tr>";
            echo"<td>".$f['Programa']."</td>";
            echo"<td>".$f['MensCorriente']."</td>";
            echo"<td>".$f['MensVencido']."</td>";
            echo"<td>".$f['OxxoCorriente']."</td>";
            echo"<td>".$f['OxxoVencido']."</td>";
            echo"<td>".$f['AhorroSinCont']."</td>";
            echo"<td>".$f['AhorroConCont']."</td>";
            echo"<td>".$f['IngEspecialesEscrit']."</td>";
            echo"<td>".$f['IngEspecialesReint']."</td>";
            echo"<td>".$f['IngEspecialesCesion']."</td>";
            echo"<td>".$f['IngEspecialesAsig']."</td>";
            echo"<td>".$f['IngEspecialesGrav']."</td>";
            echo"<td>".$f['IngEspecialesTopo']."</td>";
            echo"<td>".$f['IngEspecialesBusD']."</td>";
         echo"<tr>";   
    } 

}
else {
 //   mensaje('No se localizó Información para esa fecha',"ingresos.php");
}
    




echo"</table>";

echo"</div>";


?>



<?php
include ("./unica/body_footer.php");
?>