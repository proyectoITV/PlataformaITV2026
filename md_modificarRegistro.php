<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>
<script>
function mostrarFechados(){
    
    if (fechados.checked == true){
       
        $("#fech2").css({'display':'inline-block',});
        periodo2.value="";
        
    }else{
        
        $("#fech2").css({'display':'none',});
    }

}

function quitarFechados(){
    
    if (quitardos.checked == true){
        $("#quit2").css({'display':'none',});
        periodo2.value="";
        
        
    }else{
        $("#quit2").css({'display':'inline-block',});
        
    }

}


</script>

<?php
require("./config.php");
$id_aplicacion = 'ap70';
xd_update('ap70',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);



if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    
    historia($nitavu, 'Entre a modificar la información de un pago');
    echo "<br><br>";
    if(isset($_GET['id']) ){
        
        $idpago = $_GET['id'];
        $idmandante = $_GET['idmandante'];
        $idcolonia = $_GET['idcolonia'];
        $idmunicipio = $_GET['idmunicipio'];

        echo '<a id="regCargo" href="mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'" title="Clic para regresar a la página anterior"><ins>Regresar</ins></a>';
        //$nitavu = $_GET['nitavu'];
        //Tabla de registros
        echo "<div>";
        echo "<h1>Modificar Registro</h1>";
        //echo '<a id="regCargo" href="mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'" title="Clic para regresar a la página anterior"><ins>Regresar</ins></a>';
        $sql = "SELECT * FROM mandantes_abonos WHERE id= ".$idpago."";
       // echo $sql;
        $rc = $conexion -> query($sql);
        if ($rc->num_rows>0){
            while($r = $rc -> fetch_array()){

                if($r['tipoMov']==3){
                    echo "<div>";
                        echo "<form name='formulario' id='formulario' method='post' action='mandantes_pago.php?idmandante=".$r["idmandante"]."&idcolonia=".$r['idcolonia']."&idmunicipio=".$r['idmunicipio']."&idpago=".$r['id']."'>";
                            //echo '<label><input type="checkbox" id="peri2" name="peri2" value="periodo2" onClick="mostrarFecha2()">Periodo</label>';
                            echo "<div>";
                                echo "<table style='width:100%;'>";
                                //echo $r['periodopago'];
                                //echo $r['periodopago2'];
                                if($r['periodopago']==$r['periodopago2']){

                                    echo "<td>";
                                    echo '<label><input type="checkbox" id="fechados" name="fechados" onClick="mostrarFechados()">Periodo</label>';
                                    echo "</td><td>";
                                    echo "<label>Fecha 1</label>";
                                    echo "<input type='date' name='fecha' id='fecha' value='".$r['periodopago']."' required>";
                                    echo "</td>";
                                    echo "<td id='fech2' style='display:none;'>";
                                    echo "<label>Fecha 2</label>";
                                    echo "<input type='date' name='periodo2' id='periodo2' value='".$r['periodopago2']."'>";
                                    echo "</td>";
                                }else{
                                    echo "<td>";
                                    echo '<label><input type="checkbox" id="quitardos" name="quitardos" onClick="quitarFechados()">Periodo</label>';
                                    echo "</td>";
                                    echo "<td>";
                                    echo "<label>Fecha 1</label>";
                                    echo "<input type='date' name='fecha' id='fecha' value='".$r['periodopago']."' required>";
                                    echo "</td>";
                                    echo "<td id='quit2'>";
                                    echo "<label>Fecha 2</label>";
                                    echo "<input type='date' name='periodo2' id='periodo2' value='".$r['periodopago2']."'>";
                                    echo "</td>";
                                } 
                                echo "</table>";
                            echo "</div>";
                            echo "<div>";
                                echo "<label>Recuperación</label>";
                                echo "<input type='number' step='any' placeholder='$0.00' onblur='mostrarDecimales()' value='".$r['recuperacion']."' name='recuperacion' id='recuperacion' required>";
                            echo "</div>";


                            echo "<div>";
                                echo "<table style='width:100%;'>";
                                    echo "<td>";
                                        echo "<label style='text-align:center;'>%</label>";
                                        echo "<input type='number' step='any' placeholder='%' name='pamorAnt' id='pamorAnt' value='".$r['pamorAnt']."' required>";
                                    echo "</td>";
                                    echo "<td>";
                                        echo "<label>Amortización de anticipo</label>";
                                        echo "<input type='number' step='any' placeholder='$0.00' name='amorAnticipo' id='amorAnticipo' value='".$r['amortizacion_anticipo']."' required>";
                                    echo "</td>";
                                echo "</table>";
                            echo "</div>";  
                            
                            echo "<div>";
                                echo "<label>Monto por pagar</label>";
                                echo "<input type='number' step='any' placeholder='$0.00' name='montopagar' id='montopagar' value='".$r['montopagar']."' required>";
                            echo "</div>";
                            echo "<div>";
                                echo "<table style='width:100%;'>";
                                    echo "<td>";
                                        echo "<label style='text-align:center;'>%</label>";
                                        echo "<input type='number' step='any' placeholder='%' name='pgastos' id='pgastos' value='".$r['pgastos']."' required>";
                                    echo "</td>";
                                    echo "<td>";
                                        echo "<label>Gastos de admon.</label>";
                                        echo "<input type='number' step='any' placeholder='$0.00' name='gastos' id='gastos'  value='".$r['gastos']."' required>";
                                    echo "</td>";
                                echo "</table>";
                            echo "</div>";
                            echo "<div>";
                            echo "<table style='width:100%;'>";
                                echo "<td>";
                                    echo "<label style='text-align:center;'>%</label>";
                                    echo "<input type='number' step='any' placeholder='%' name='pgastosesc' id='pgastosesc'  value='".$r['pgastosesc']."' required>";
                                echo "</td>";
                                echo "<td>";
                                    echo "<label>Gastos de escrituracion</label>";
                                    echo "<input type='number' step='any' placeholder='$0.00' name='gastosesc' id='gastosesc'  value='".$r['gastosesc']."' required>";
                                echo "</td>";
                            echo "</table>";
                        echo "</div>";
                            
                            echo "<div>";
                               /* echo "<table style='width:100%;'>";
                                    echo "<td>";
                                        echo "<label style='text-align:center;'>%</label>";
                                        echo "<input type='number' step='any' placeholder='%' name='pdevols' id='pdevols' value='".$r['pdevols']."' required>";
                                    echo "</td>";
                                    echo "<td>";*/
                                        echo "<label>Devoluciones</label>";
                                        echo "<input type='number' step='any' placeholder='$0.00' name='devols' id='devols' value='".$r['devols']."'>";
                                    /*echo "</td>";
                                echo "</table>";*/
                            echo "</div>";
                            
                            echo "<div>";
                            
                                     echo "<label>Otros Descuentos</label>";
                                     echo "<input type='number' step='any' placeholder='$0.00' name='otrosdesc' id='otrosdesc' value='".$r['otrosdesc']."'>";
                               
                         echo "</div>";       

                            echo "<div>";
                                echo "<label>Monto pagado</label>";
                                echo "<input type='number' step='any' placeholder='$0.00' name='montoPagado' id='montoPagado' value='".$r['monto_pagado']."' required>";
                            echo "</div>";
                            echo "<div>";
                                echo "<label>Monto acumulado</label>";
                                echo "<input type='number' step='any' placeholder='$0.00' name='montoAcumulado' id='montoAcumulado' value='".$r['monto_acumulado']."' required>";
                            echo "</div>";
                            echo "<div>";
                                echo "<label>Saldo</label>";
                                echo "<input type='number' step='any' placeholder='$0.00' name='saldo' id='saldo' value='".$r['saldo']."' required>";
                            echo "</div>";
                            echo "<div>";
                                echo "<label>Recuperación emitida por el sistema</label>";
                                echo "<input type='number' step='any' placeholder='$0.00' name='sistema' id='sistema' value='".$r['recuperacion_sistema']."' required>";
                            echo "</div>";
                           
                           /* echo "<div>";
                                echo "<label>Enganche ahorro por identificar y traspasar</label>";
                                echo "<input type='number' step='any' placeholder='$0.00' name='engancheTraspaso' id='engancheTraspaso' value='".$r['ahorroTraspaso']."'>";
                            echo "</div>";*/


                            echo "<div>";
                                echo "<table style='width:100%;'>";
                                    echo "<td>";
                                        echo "<label style='text-align:center;'>(+/-)</label>";
                                        echo "<select id='mas_menos2' name='mas_menos2'>";
                                        if ('1'==$r['signo2']){
                                            echo "<option value='1' selected> más</option>";
                                            echo "<option value='2'>menos</option>";
                                        }else{
                                            echo "<option value='2' selected>menos</option>";
                                            echo "<option value='1'> más</option>";
                                            
                                            
                                        }
                                            //echo "<option value='1'>más</option>";
                                            //echo "<option value='2'>menos</option>";
                                        echo "</select>";
                                    echo "</td>";
                                    echo "<td>";
                                        echo "<label  style='text-align:center;'>Enganche ahorro por identificar y traspasar</label>";
                                        echo "<input type='number' step='any' placeholder='$0.00' name='engancheAhorro' id='engancheAhorro' value='".$r['enganche_ahorro']."'>";
                                    echo "</td>";
                                echo "</table>";
                            echo "</div>";

                            echo "<div>";
                            echo "<table style='width:100%;'>";
                                echo "<td>";
                                    echo "<label style='text-align:center;'>(+/-)</label>";
                                    echo "<select id='mas_menos1' name='mas_menos1'>";
                                    if ('1'==$r['signo1']){
                                        echo "<option value='1' selected> más</option>";
                                        echo "<option value='2'>menos</option>";
                                    }else{
                                        echo "<option value='2' selected>menos</option>";
                                        echo "<option value='1'> más</option>";
                                        
                                        
                                    }
                                    echo "</select>";
                                echo "</td>";
                                echo "<td>";
                                    echo "<label style='text-align:center;'>Descuento por nómina</label>";
                                    echo "<input type='number' step='any' placeholder='$0.00' name='desNomina' id='desNomina' value='".$r['descuento_nomina']."' >";
                                echo "</td>";
                            echo "</table>";
                        echo "</div>";
                            echo "<div>";
                                echo "<table style='width:100%;'>";
                                    echo "<td>";
                                        echo "<label style='text-align:center;'>(+/-)</label>";
                                        echo "<select id='mas_menos3' name='mas_menos3'>";
                                        if ('1'==$r['signo3']){
                                            echo "<option value='1' selected> más</option>";
                                            echo "<option value='2'>menos</option>";
                                        }else{
                                            echo "<option value='2' selected>menos</option>";
                                            echo "<option value='1'> más</option>";
                                            
                                            
                                        }
                                            //echo "<option value='1'>más</option>";
                                            //echo "<option value='2'>menos</option>";
                                        echo "</select>";
                                    echo "</td>";
                                    echo "<td>";
                                        echo "<label  style='text-align:center;'>Por transferencia</label>";
                                        echo "<input type='number' step='any' placeholder='$0.00' name='transferencia' id='transferencia' value='".$r['transferencia']."'>";
                                    echo "</td>";
                                echo "</table>";
                            echo "</div>";
                            echo "<div>";
                                echo "<table style='width:100%;'>";
                                    echo "<td>";
                                        echo "<label style='text-align:center;'>(+/-)</label>";
                                        echo "<select id='mas_menos4' name='mas_menos4'>";
                                        if ('1'==$r['signo4']){
                                            echo "<option value='1' selected> más</option>";
                                            echo "<option value='2'>menos</option>";
                                        }else{
                                            echo "<option value='2' selected>menos</option>";
                                            echo "<option value='1'> más</option>";
                                            
                                            
                                        }
                                            //echo "<option value='1'>más</option>";
                                            // echo "<option value='2'>menos</option>";
                                        echo "</select>";
                                    echo "</td>";
                                    echo "<td>";
                                        echo "<label  style='text-align:center;'>Por pagos universales</label>";
                                        echo "<input type='number' step='any' placeholder='$0.00' name='pagosUniversales' id='pagosUniversales' value='".$r['pagos_universales']."' >";
                                    echo "</td>";
                                echo "</table>";
                            
                            echo "</div>";
                            echo "<div>";

                                echo "<table style='width:100%;'>";
                                    echo "<td>";
                                        echo "<label style='text-align:center;'>(+/-)</label>";
                                        echo "<select id='mas_menos5' name='mas_menos5'>";
                                        if ('1'==$r['signo5']){
                                            echo "<option value='1' selected> más</option>";
                                            echo "<option value='2'>menos</option>";
                                        }else{
                                            echo "<option value='2' selected>menos</option>";
                                            echo "<option value='1'> más</option>";
                                            
                                            
                                        }
                                            //echo "<option value='1'>más</option>";
                                            //echo "<option value='2'>menos</option>";
                                        echo "</select>";
                                    echo "</td>";
                                    echo "<td>";
                                        echo "<label  style='text-align:center;'>Por concepto de escritura</label>";
                                        echo "<input type='number' step='any' placeholder='$0.00' name='escritura' id='escritura' value='".$r['escritura']."' >";
                                    echo "</td>";
                                echo "</table>";
                            echo "</div>";
                            echo "<div>";
                                echo "<table style='width:100%;'>";
                                    echo "<td>";
                                        echo "<label style='text-align:center;'>(+/-)</label>";
                                        echo "<select id='mas_menos6' name='mas_menos6'>";
                                        if ('1'==$r['signo6']){
                                            echo "<option value='1' selected> más</option>";
                                            echo "<option value='2'>menos</option>";
                                        }else{
                                            echo "<option value='2' selected>menos</option>";
                                            echo "<option value='1'> más</option>";  
                                        }
                                            //echo "<option value='1'>más</option>";
                                            //echo "<option value='2'>menos</option>";
                                        echo "</select>";
                                    echo "</td>";
                                    echo "<td>";
                                        echo "<label  style='text-align:center;'>Por cesión de derechos</label>";
                                        echo "<input type='number' step='any' placeholder='$0.00' name='derechos' id='derechos' value='".$r['derechos']."'>";
                                    echo "</td>";
                                echo "</table>";
                            echo "</div>";
                            echo "<div>";
                                echo "<table style='width:100%;'>";
                                    echo "<td>";
                                        echo "<label style='text-align:center;'>(+/-)</label>";
                                        echo "<select id='mas_menos7' name='mas_menos7'>";
                                        if ('1'==$r['signo7']){
                                            echo "<option value='1' selected> más</option>";
                                            echo "<option value='2'>menos</option>";
                                        }else{
                                            echo "<option value='2' selected>menos</option>";
                                            echo "<option value='1'> más</option>";
                                            
                                            
                                        }
                                            //echo "<option value='1'>más</option>";
                                            //echo "<option value='2'>menos</option>";
                                        echo "</select>";
                                    echo "</td>";
                                    echo "<td>";
                                        echo "<label  style='text-align:center;'>Por pago de derechos</label>";
                                        echo "<input type='number' step='any' placeholder='$0.00' name='pagoDerechos' id='pagoDerechos' value='".$r['pago_derechos']."'>";
                                    echo "</td>";
                                echo "</table>";
                            echo "</div>";
                            echo "<div>";
                                echo "<table style='width:100%;'>";
                                    echo "<td>";
                                        echo "<label style='text-align:center;'>(+/-)</label>";
                                        echo "<select id='mas_menos8' name='mas_menos8'>";
                                        if ('1'==$r['signo8']){
                                            echo "<option value='1' selected> más</option>";
                                            echo "<option value='2'>menos</option>";
                                        }else{
                                            echo "<option value='2' selected>menos</option>";
                                            echo "<option value='1'> más</option>";
                                            
                                            
                                        }
                                            //echo "<option value='1'>más</option>";
                                            //echo "<option value='2'>menos</option>";
                                        echo "</select>";
                                    echo "</td>";
                                    echo "<td>";
                                        echo "<label  style='text-align:center;'>Por pago en oxxo</label>";
                                        echo "<input type='number' step='any' placeholder='$0.00' name='pagooxxo' id='pagooxxo' value='".$r['oxxo']."'>";
                                    echo "</td>";
                                echo "</table>";
                            echo "</div>";

                            echo "<div>";
                            echo "<table style='width:100%;'>";
                                echo "<td>";
                                    echo "<label style='text-align:center;'>(+/-)</label>";
                                    echo "<select id='mas_menos9' name='mas_menos9'>";
                                    if ('1'==$r['signo9']){
                                        echo "<option value='1' selected> más</option>";
                                        echo "<option value='2'>menos</option>";
                                    }else{
                                        echo "<option value='2' selected>menos</option>";
                                        echo "<option value='1'> más</option>";
                                        
                                        
                                    }
                                    echo "</select>";
                                echo "</td>";
                                echo "<td>";
                                    echo "<label  style='text-align:center;'>Otros pagos</label>";
                                    echo "<input type='number' step='any' placeholder='$0.00' name='pagootros' id='pagootros' value='".$r['pagootros']."'>";
                                echo "</td>";
                            echo "</table>";
                        echo "</div>";

                           // echo "<div>";
                           echo "<br>";
                                echo "<label>Datos Bancarios</label><br>";
                               echo "<input type='text' step='any' placeholder='datos bancarios' name='datos_bancarios' id='datos_banarios' value='".$r['datos_bancarios']."'  style='width:80%;'>";
                           //echo "</div>";
                            echo "<div>";
                                echo "<label>Comentario</label>";
                                echo "<textarea name='comentario' id='comentario'>".$r['numero_oficio']."</textarea>";
                                
                            echo "</div>";
                            echo "<div>";
                                echo "<label>Observación para pago</label>";
                                echo "<textarea name='observacionPago' id='observacionPago'>".$r['observacionPago']."</textarea>";
                                
                            echo "</div>";
                            echo "<div>";
                                echo "<input class='Mbtn btn-danger' type='submit' id='guardar' value='Guardar' >";
                            echo "</div>";   
                        echo "</form>";
                    echo "</div>";
                }else{
                    echo "<div>";
                    echo "<form name='formulario' id='formulario' method='post' action='mandantes_pago.php?idmandante=".$r["idmandante"]."&idcolonia=".$r['idcolonia']."&idmunicipio=".$r['idmunicipio']."&idpago=".$r['id']."'>";
                            echo "<div>";
                                echo "<label>Fecha de pago</label>";
                                echo "<input type='date' name='fecha2' id='fecha2' value='".$r['periodopago']."' required>";
                            echo "</div>"; 
                            echo "<div>";
                                echo "<label>Monto pagado</label>";
                                echo "<input type='number' step='any' placeholder='$0.00' name='montoPagado2' id='montoPagado2' value='".$r['monto_pagado']."' required>";
                            echo "</div>";  
                            echo "<div>";
                                echo "<label>Monto acumulado</label>";
                                echo "<input type='number' step='any' placeholder='$0.00' name='montoAcumulado2' id='montoAcumulado2' value='".$r['monto_acumulado']."' required>";
                            echo "</div>";
                            echo "<div>";
                                echo "<label>Saldo</label>";
                                echo "<input type='number' step='any' placeholder='$0.00' name='saldo2' id='saldo2' value='".$r['saldo']."' required>";
                            echo "</div>";
                            // echo "<br>";
                            // echo "<label>Comentario</label>";   echo "<br>";
                            // echo "<input type='text'  placeholder='comentario' name='comentario' id='comentario' value='".$r['numero_oficio']."' required>";
                            echo "<div>";
                            echo "<label>Comentario</label>";
                            echo "<input type='text'  placeholder='comentario' name='comentario' id='comentario' value='".$r['numero_oficio']."' required>";
                        echo "</div>";
                        echo "<div>";
                            echo "<label>Datos Bancarios</label>";
                            echo "<input type='text'  placeholder='Datos Bancarios' name='datos_bancarios' id='datos_bancarios' value='".$r['datos_bancarios']."' required>";
                        echo "</div>";
                            echo "<div>";
                                echo "<input class='Mbtn btn-danger' type='submit' id='guardar' value='Guardar' >";
                            echo "</div>";

                        echo "</form>";
                    echo "</div>";

                }
            }
        }
    }
}

echo "</div>";

?>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<?php include ("./lib/body_footer.php"); ?>