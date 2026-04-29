<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");
include ("./unica/body_menu.php");

$id_aplicacion = 'ap81';
xd_update('ap81',$nitavu);//guarda la experiencia del usuario
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<h5>".app_detalle($id_aplicacion)."</h5>";
// contenido:
?>
<script>
function enganche(){
    enganche_requerido = $('#casa_valor').val() * .15;
    $('#casa_enganche').val(enganche_requerido);
    console.log('Eng. Requerido ' + enganche_requerido);
}

function prestar(){

    if (parseFloat($('#pago').val()) > parseFloat($('#casa_enganche').val())){

        $('#prestamo').val(0);
        abonocapital = ($('#pago').val() - $('#casa_enganche').val());
        $('#pagoacapital').val(abonocapital);

        $("#mensajeCorrida").css({'display':'none',});

        if ( $('#pago').val() == $('#casa_enganche').val()){
            $('#prestamo').val(0);
            $('#pagoacapital').val(0);
            $("#mensajeCorrida").css({'display':'none',});
        }
    }else {

        // le prestamos
        prestamo2 = $('#casa_enganche').val()  -  $('#pago').val();
        if((prestamo2 < 0) || (prestamo2 == 0)){
            $('#prestamo').val(0);
            $('#pagoacapital').val(0);
            $("#mensajeCorrida").css({'display':'none',});
        }else if((prestamo2 <= 24750) && (prestamo2 >0)){
            $('#prestamo').val(prestamo2);
            $('#pagoacapital').val(0);
            $("#mensajeCorrida").css({'display':'none',});
        }else{
            $('#prestamo').val(0);
            $('#pagoacapital').val(0);
            $("#mensajeCorrida").css({'display':'inline-block',});
        }
        
    }

   
}
</script>
<div id='mensajeCorrida'><p>TRÁMITE NO AUTORIZADO. <br>(La cantidad necesaria para cubrir el enganche, sobre pasa el límite de crédito). </p></div>
<div class='ventana'>
<form action='' method='post'>
<h1> Ingrese los valores </h1>
<table class='tabla3'>
<tr><td>Valor: </td><td><input type='number' style='background-color:orange; color:white;' value='' name='casa_valor' id='casa_valor' placerholder='Costo de la casa' onkeyup='enganche();' required></td></tr>
<tr><td>Enganche requerido (15%): </td><td><input type='number' value='' name='casa_enganche' id='casa_enganche' readonly></td></tr>
<tr><td>Pago en Caja: </td><td><input type='number' value='' name='pago' id='pago' onkeyup='prestar();' required></td></tr>
<tr><td>ITAVU te presta: </td><td><input style='background-color:orange; color:white;' type='number' value='' name='prestamo' id='prestamo' readonly></td></tr>
<tr><td>Pago a Capital: </td><td><input style='background-color:orange; color:white;' type='number' value='' name='pagoacapital' id='pagoacapital' readonly></td></tr>

</table> 
<input type='submit' value='Calcular' name='corrida' id='corrida' class='btn btn-default'>
</form>
</div>



<?php
if (isset($_POST['corrida'])){
    $costo = $_POST['casa_valor'];
    $enganche_requerido = $_POST['casa_enganche'];
    $pago = $_POST['pago'];
    $prestamo = $_POST['prestamo'];
    $capitalpago = $_POST['pagoacapital'];
    $capital = 0;
    
    echo "<h1> Corrida Financiera </h1>";
    if($pago > $enganche_requerido){
        $capital = $costo - $pago; 
    }else if($pago == $enganche_requerido){
        $capital = $costo - $enganche_requerido; 
    }else if(($pago+$prestamo) == $enganche_requerido){
        $capital = $costo - $enganche_requerido; 
    }else{
        $capital = 0;
    }
    
    echo "<center><table id='corridaFinanciera'>
        <td><p>Costo de la casa: $".number_format($costo,2,'.',',')."</p></td>
        <td><p>Enganche: $".number_format($enganche_requerido,2,'.',',')."</p></td>
        <td><p>Pago: $".number_format($pago,2,'.',',')."</p></td>
        <td><p>ITAVU Préstamo: $".number_format($prestamo,2,'.',',')."</p></td>
        <td><p>Pago a capital: $".number_format($capitalpago,2,'.',',')."</p></td>
        <td><p>Cápital a pagar: $".number_format($capital,2,'.',',')."</p></td>
    </table></center>";
    echo "<br>";
    
   

    echo "<center><table class='tabla' style='width:90%;'>";
    
    echo '<tr><th></th><th colspan="4">PRÉSTAMO INFONAVIT</th><th colspan="4">PRÉSTAMO ITAVU</th><th></th></tr>';
    echo "<tr><th>No. Pago</th> 
            <th>Pago Mensual</th> 
            <th>Interés</th> 
            <th>Cápital</th>
            <th>Saldo insoluto</th>
            <th>Pago Mensual</th> 
            <th>Interés</th> 
            <th>Cápital</th>
            <th>Saldo insoluto</th>
            <th>TOTAL</th></tr>";
    $capitalp = $prestamo;
    $pagomensual = 0; $interesmensual=0; $abonocapital = 0; 
    $pagomensualp = 0; $interesmensualp=0; $abonocapitalp = 0; 
    $pagoTotal = 0 ;
    $pagomensual = ((($capital) * (17/1200)) / (1 - pow((1 + (17/1200)),(-120))));
    $pagomensual = ceil ($pagomensual );
    $pagomensualp = ((($capitalp) * (17/1200)) / (1 - pow((1 + (17/1200)),(-120))));
    $pagomensualp = ceil ($pagomensualp );
    for ($i = 1; $i <= 120; $i++) {		 
        //(((TxtMontoConvenio.text) * (TxtTasaFin.text / 1200)) / (1 - (1 + (TxtTasaFin.text / 1200)) ^ (-txtNuevoDoc.text)))
        if($i==120){
            $interesmensual = (($capital *17 )/1200); 
            $pagomensual = $capital + $interesmensual;
            $abonocapital = $pagomensual - $interesmensual;
            $capital = $capital - $abonocapital;
            
            echo "<tr>";
            echo "<td>".$i."</td>";
            echo "<td>".number_format($pagomensual,2,'.',',')."</td>";
            echo "<td><b>".number_format($interesmensual,2,'.',',')."</b></td>";
            echo "<td>".number_format($abonocapital,2,'.',',')."</td>";
            echo "<td>".number_format($capital,2,'.',',')."</td>";

            $interesmensualp = (($capitalp *17 )/1200); 
            $pagomensualp = $capitalp + $interesmensualp;
            $abonocapitalp = $pagomensualp - $interesmensualp;
            $capitalp = $capitalp - $abonocapitalp;
            echo "<td>".number_format($pagomensualp,2,'.',',')."</td>";
            echo "<td><b>".number_format($interesmensualp,2,'.',',')."</b></td>";
            echo "<td>".number_format($abonocapitalp,2,'.',',')."</td>";
            echo "<td>".number_format($capitalp,2,'.',',')."</td>";
            $pagoTotal = $pagomensual + $pagomensualp;
            echo "<td> <b>".number_format($pagoTotal,2,'.',',')."</b> </td>";
            echo "</tr>";
        }else{
            $interesmensual = (($capital *17 )/1200); 
            $abonocapital = $pagomensual - $interesmensual;
            $capital = $capital - $abonocapital;
            echo "<tr>";
            echo "<td>".$i."</td>";
            echo "<td>".number_format($pagomensual,2,'.',',')."</td>";
            echo "<td><b>".number_format($interesmensual,2,'.',',')."</b></td>";
            echo "<td>".number_format($abonocapital,2,'.',',')."</td>";
            echo "<td>".number_format($capital,2,'.',',')."</td>";

            $interesmensualp = (($capitalp *17 )/1200); 
            $abonocapitalp = $pagomensualp - $interesmensualp;
            $capitalp = $capitalp - $abonocapitalp;
            echo "<td>".number_format($pagomensualp,2,'.',',')."</td>";
            echo "<td><b>".number_format($interesmensualp,2,'.',',')."</b></td>";
            echo "<td>".number_format($abonocapitalp,2,'.',',')."</td>";
            echo "<td>".number_format($capitalp,2,'.',',')."</td>";
            $pagoTotal = $pagomensual + $pagomensualp;
            echo "<td><b> ".number_format($pagoTotal,2,'.',',')."</b> </td>";
            echo "</tr>";
        }
        
        //$abonomensual = $capital / 120;
        //$capital = $capital -$abonomensual;
        //$interesanual = ($capital *.17); //interes anual
        //$interesanual = $interesanual * ((120 - $i) / 12); // interes por los años que me queden
        //$interesmensual = $interesanual / (120 - $i); //interes anual entre los meses que me queden
        //$abonoprestamo = $prestamo_capital / 120;
         //$prestamo_capital = $prestamo_capital - $abonoprestamo;
        /*$interesanualp = ($prestamo_capital *.17); //interes anual
        $interesanualp = $interesanualp * ((120 - $i) / 12); // interes por los años que me queden
        $interesmensualp = $interesanualp / (120 - $i); //interes anual entre los meses que me queden*/
        //$pagoTotal = $abonomensual + $interesmensual + $abonoprestamo + $interesmensualp;
        
    }
    echo "</table></center>";

}
}
else {
    mensaje("ERROR: no tiene acceso a esta aplicacion",'./index.php?home=');
}

?>



<?php
include ("./unica/body_footer.php");
?>



