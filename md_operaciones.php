<?php
require ("config.php");
require ("lib/flor_funciones.php");


//$num = $_POST['num'];
$idmandante = $_POST['idmandante'];
$idcolonia = $_POST['idcolonia'];
$idmunicipio = $_POST['idmunicipio'];

$pago = $_POST['pago'];

if($pago==''){
    $pago = 0;
}
//OBTENER EL TOTAL QUE SE LE DEBE 
$total = totalAPagarContratoMandante($idmandante, $idcolonia, $idmunicipio);

//MONTO ACUMULADO ES LO QUE SE LE HA DADO MAS EL PAGO QUE ESTAN INTRODUCIENDO POR TECLADO
$montoacumulado = montoAcumuladoMandante($idmandante, $idcolonia, $idmunicipio);
$montoacumulado1 = $montoacumulado + $pago;
//SALDO ES EL TOTAL MENOS EL MONTO ACUMULADO

$saldo = $total - $montoacumulado1;

//if($num == 1){
    echo "<div>";
        echo "<label>Monto acumulado</label>";
        echo "<input type='number' step='any' placeholder='$0.00' name='montoAcumulado' id='montoAcumulado' value='".$montoacumulado1."'  readonly>";
    echo "</div>";
    echo "<div>";
        echo "<label>Saldo</label>";
        echo "<input type='number' step='any' placeholder='$0.00' name='saldo' id='saldo' value='".$saldo."'  readonly>";
    echo "</div>";
/*}else{
    echo "<div>";
        echo "<label>Monto acumulado</label>";
        echo "<input type='number' step='any' placeholder='$0.00' name='montoAcumulado2' id='montoAcumulado2'  value='".$montoacumulado1."' readonly>";
    echo "</div>";
    echo "<div>";
        echo "<label>Saldo</label>";
        echo "<input type='number' step='any' placeholder='$0.00'  name='saldo2' id='saldo2' value='".$saldo."' readonly>";
    echo "</div>";
}*/

?>