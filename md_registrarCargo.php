<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>
<script>
//mostrar colonias
    $(document).on("change", "#cargo", function(event) {

        if($("#cargo").val()==1){
            $("#mandato").css({'display':'inline-block'});
            $("#adendum").css({'display':'none'});
            /*$("#fechaMan").css({'display':'inline-block',});
            $("#fechaAdendum").css({'display':'none',});
            $("#fechaFiniquito").css({'display':'none',});
            $("#pcredito").css({'display':'inline-block',});
            $("#costoLotes").css({'display':'inline-block',});
            $("#costom2").css({'display':'inline-block',});
            $("#suptotal").css({'display':'inline-block',});
            $("#supcomer").css({'display':'inline-block',});
            $("#pmandante").css({'display':'inline-block',});
            $("#pitavu").css({'display':'inline-block',});
            $("#paTotal").css({'display':'inline-block',});
            $("#paComer").css({'display':'inline-block',});
            $("#programaLotes").css({'display':'inline-block',});
            $("#programaSuelo").css({'display':'inline-block',});
            $("#guardar").css({'display':'inline-block',});
            $("#relleno").css({'display':'none',});*/
        }else{
            $("#adendum").css({'display':'inline-block'});
            $("#mandato").css({'display':'none'});
            /*$("#fechaMan").css({'display':'none',});
            $("#fechaAdendum").css({'display':'inline-block',});
            $("#fechaFiniquito").css({'display':'inline-block',});
            $("#pcredito").css({'display':'inline-block',});
            $("#costoLotes").css({'display':'inline-block',});
            $("#costom2").css({'display':'inline-block',});
            $("#suptotal").css({'display':'inline-block',});
            $("#supcomer").css({'display':'inline-block',});
            $("#pmandante").css({'display':'inline-block',});
            $("#pitavu").css({'display':'inline-block',});
            $("#paTotal").css({'display':'inline-block',});
            $("#paComer").css({'display':'inline-block',});
            $("#programaLotes").css({'display':'inline-block',});
            $("#programaSuelo").css({'display':'inline-block',});
            $("#guardar").css({'display':'inline-block',});
            $("#relleno").css({'display':'inline-block',});*/
        }
       
        
        
    });
</script>
<?php
require("config.php");
$id_aplicacion = 'ap70';
xd_update('ap70',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){

    if(isset($_GET['id']) and isset($_GET['idcolonia']) and isset($_GET['idmunicipio'])){
        $idmandante = $_GET['id'];
        $idcolonia =  $_GET['idcolonia'];
        $idmunicipio = $_GET['idmunicipio'];

        historia($nitavu,'Entre a capturar un nuevo cargo para el mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio:'.$idmunicipio.'');
   
        echo "<br><br>";
        echo '<a id="regCargo" href="mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'" title="Clic para regresar a la página anterior"><ins>Regresar</ins></a>';

        echo "<div id='registroCargo' >";
            echo "<h1>Ingresa los datos del nuevo Mandato</h1>";
           
            echo "<label>MUNICIPIO: <b>".strtoupper(nombreMunicipio($idmunicipio))."</b></label>";
            echo "<label>COLONIA: <b>".strtoupper(nombreColonia($idmunicipio,$idcolonia))."</b></label>";
            echo "<label>MANDANTE: <b>".strtoupper(nombreMandante($idmunicipio,$idcolonia,$idmandante))."</b></label>";
            echo "<center>";
    
            echo "<label>Tipo de cargo:";
                echo "<select id='cargo' name='cargo' >";
                    echo "<option >Seleccione una opción...</option>";
                    echo "<option value='1'>MANDATO</option>";
                    echo "<option value='2'>ADENDUM</option>";
                echo "</select>";
            echo "</label>";

            echo "<form id='mandato' style='display:none;' action='mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST' class='nuevoCargo'>";
                   
                    echo "<div id='fechaMan' > ";
                        echo "<label>Fecha del mandato</label>";
                        echo "<input type='date' name='fechaMan' id='fechaMan' required>";
                    echo "</div>";
                    /*echo "<div>";
                        echo "<label>Fecha del convenio tripartita</label>";
                        echo "<input type='date' name='fechaTri' id='fechaTri' required>";
                    echo "</div>";*/
                    
                    echo "<div id='pcredito' >";
                        echo "<label>Plazo de crédito</label>";
                        echo "<input type='text' placeholder='mensualidades' name='plazoCredito' id='plazoCredito' required>";
                    echo "</div>";
                    echo "<div id='costoLotes' >";
                        echo "<label>Costo lotes</label>";
                        echo "<input type='number' step='any' placeholder='costo lotes $' name='costoLotes' id='costoLotes' required>";
                    echo "</div>";
                    echo "<div id='costom2' >";
                        echo "<label>Costo lote por metro cuadrado</label>";
                        echo "<input type='number' step='any' placeholder='costo lotes X metro cuadrado' name='LoteM2' id='LoteM2' required>";
                    echo "</div>";
                    echo "<div id='suptotal' >";
                        echo "<label>Superficie total</label>";
                        echo "<input type='text' placeholder='MTS' name='superficie' id='superficie' required>";
                    echo "</div>";
                    echo "<div id='supcomer' >";
                        echo "<label>Superficie para comercializar</label>";
                        echo "<input type='text' placeholder='MTS' name='supComercializar' id='supComercializar' required>";
                    echo "</div>";
                   
                    echo "<div id='pmandante' >";
                        echo "<label>Porcentaje Mandante</label>";
                        echo "<input type='number' step='any' placeholder='%' name='porMan' id='porMan' required>";
                    echo "</div>";
                    echo "<div id='pitavu' >";
                        echo "<label>Porcentaje ITAVU</label>";
                        echo "<input type='number' step='any' placeholder='%' name='porItavu' id='porItavu' required>";
                    echo "</div>";
                    echo "<div id='paTotal' >";
                        echo "<label>Pago total al mandante de acuerdo al contrato</label>";
                        echo "<input type='number' step='any' placeholder='$0.00' name='monpagar' id='monpagar' required>";
                    echo "</div>";
                    echo "<div id='paComer' >";
                        echo "<label>Recuperación total de acuerdo a la tabla de comercialización</label>";
                        echo "<input type='number' step='any' placeholder='$0.00' name='monpagarComer' id='monpagarComer' required>";
                    echo "</div>";
                     
                                        
                    //echo "<div>";
                        echo "<center><table style='width:80%;'>";
                        echo "<td>";
                            echo "<label>Lotes de área verde</label>";
                            echo "<input type='number' step='any' placeholder='lotes área verde' name='lotesareav' id='lotesareav'>";
                        echo "</td>";
                    //echo "</div>";
                    //echo "<div>";
                        echo "<td>";
                            echo "<label>Lotes equipamiento urbano</label>";
                            echo "<input type='number' step='any' placeholder='lotes eq. urbano' name='loteseq' id='loteseq'>";
                        echo "</td>";
                            //echo "</div>";
                    // echo "<div>";
                        echo "<td>";  
                            echo "<label>Lotes Reserva del Mandante</label>";
                            echo "<input type='number' step='any' placeholder='lotes de reserva del mandante' name='lotesreserva' id='lotesreserva'>";
                        echo "</td>";
                    echo "</table></center>";
                    //echo "</div>";

                    //--------------------------------------
                    echo "<div id='programaLotes' >";
                        echo "<label>Programa Lotes</label>";
                        echo "<div>";
                            echo "<label>Total lotes</label>";
                            echo "<input type='number' step='any' placeholder='' name='totLotesL' id='totLotesL'>";
                        echo "</div>";
                        echo "<div>";
                            echo "<label>Lotes contratados</label>";
                            echo "<input type='number' step='any' placeholder='' name='lotesConL' id='lotesConL'>";
                        echo "</div>";
                        echo "<div>";
                            echo "<label>Lotes sin contrato</label>";
                            echo "<input type='number' step='any' placeholder='' name='lotesSinConL' id='lotesSinConL'>";
                        echo "</div>";
                    echo "</div>";
                       
                    //-------------------------------------------
                    echo "<div id='programaSuelo' >";
                        echo "<label>Programa Suelo Legal</label>";
                        echo "<div>";
                            echo "<label>Total lotes</label>";
                            echo "<input type='number' step='any' placeholder='' name='totLotesS' id='totLotesS'>";
                        echo "</div>";
                        echo "<div>";
                            echo "<label>Lotes contratados</label>";
                            echo "<input type='number' step='any' placeholder='' name='lotesConS' id='lotesConS'>";
                        echo "</div>";
                        echo "<div>";
                            echo "<label>Lotes sin contrato</label>";
                            echo "<input type='number' step='any' placeholder='' name='lotesSinConS' id='lotesSinConS'>";
                        echo "</div>";
                        
                    echo "</div>";

                    //echo "<div>";
                        echo "<label>Observaciones: </label>";
                        echo "<textarea name='observaciones' id='observaciones'></textarea>";
                    //echo "</div>";
                    

                    echo "<div id='guardar' >";
                        echo "<input class='Mbtn btn-default' type='submit' id='guardar' value='Guardar' style='width:50%;'>";
                    echo "</div>";
                echo "<br><br>";
                
            echo "</form>";

            echo "<form id='adendum' style='display:none;' action='mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST' class='nuevoCargo'>";
                   
                    /*echo "<div>";
                        echo "<label>Fecha del convenio tripartita</label>";
                        echo "<input type='date' name='fechaTri' id='fechaTri' required>";
                    echo "</div>";*/
                    echo "<div id='fechaAdendum' >";
                        echo "<label>Fecha adendum</label>";
                        echo "<input type='date' name='fechaAdendum' id='fechaAdendum' required>";
                    echo "</div>";
                    echo "<div id='fechaFiniquito' >";
                        echo "<label>Fecha adendum finiquito</label>";
                        echo "<input type='date' name='fechaAdendumFiniquito' id='fechaAdendumFiniquito' required>";
                    echo "</div>";
                    echo "<div id='pcredito' >";
                        echo "<label>Plazo de crédito</label>";
                        echo "<input type='text' placeholder='mensualidades' name='plazoCredito' id='plazoCredito' required>";
                    echo "</div>";
                    echo "<div id='costoLotes' >";
                        echo "<label>Costo lotes</label>";
                        echo "<input type='number' step='any' placeholder='costo lotes $' name='costoLotes' id='costoLotes' required>";
                    echo "</div>";
                    echo "<div id='costom2' >";
                        echo "<label>Costo lote por metro cuadrado</label>";
                        echo "<input type='number' step='any' placeholder='costo lotes X metro cuadrado' name='LoteM2' id='LoteM2' required>";
                    echo "</div>";
                    echo "<div id='suptotal' >";
                        echo "<label>Superficie total</label>";
                        echo "<input type='text' placeholder='MTS' name='superficie' id='superficie' required>";
                    echo "</div>";
                    echo "<div id='supcomer' >";
                        echo "<label>Superficie para comercializar</label>";
                        echo "<input type='text' placeholder='MTS' name='supComercializar' id='supComercializar' required>";
                    echo "</div>";
                    
                    echo "<div id='pmandante' >";
                        echo "<label>Porcentaje Mandante</label>";
                        echo "<input type='number' step='any' placeholder='%' name='porMan' id='porMan' required>";
                    echo "</div>";
                    echo "<div id='pitavu' >";
                        echo "<label>Porcentaje ITAVU</label>";
                        echo "<input type='number' step='any' placeholder='%' name='porItavu' id='porItavu' required>";
                    echo "</div>";
                    echo "<div id='paTotal' >";
                        echo "<label>Pago total al mandante de acuerdo al contrato</label>";
                        echo "<input type='number' step='any' placeholder='$0.00' name='monpagar' id='monpagar' required>";
                    echo "</div>";
                    echo "<div id='paComer' >";
                        echo "<label>Recuperación total de acuerdo a la tabla de comercialización</label>";
                        echo "<input type='number' step='any' placeholder='$0.00' name='monpagarComer' id='monpagarComer' required>";
                    echo "</div>";
                    echo "<div id='relleno'>";
                        //echo "<label>Relleno</label>";
                        //echo "<input type='number' step='any' placeholder='$0.00' name='relleno' id='relleno' required>";
                    echo "</div>";
                     //echo "<div>";
                        echo "<center><table style='width:80%;'>";
                        echo "<td>";
                            echo "<label>Lotes de área verde</label>";
                            echo "<input type='number' step='any' placeholder='lotes área verde' name='lotesareav' id='lotesareav'>";
                        echo "</td>";
                    //echo "</div>";
                    //echo "<div>";
                        echo "<td>";
                            echo "<label>Lotes equipamiento urbano</label>";
                            echo "<input type='number' step='any' placeholder='lotes eq. urbano' name='loteseq' id='loteseq'>";
                        echo "</td>";
                            //echo "</div>";
                    // echo "<div>";
                        echo "<td>";  
                            echo "<label>Lotes Reserva del Mandante</label>";
                            echo "<input type='number' step='any' placeholder='lotes de reserva del mandante' name='lotesreserva' id='lotesreserva'>";
                        echo "</td>";
                    echo "</table></center>";
                    //echo "</div>";

                    
                    
                    //--------------------------------------
                    echo "<div id='programaLotes' >";
                        echo "<label>Programa Lotes</label>";
                        echo "<div>";
                            echo "<label>Total lotes</label>";
                            echo "<input type='number' step='any' placeholder='' name='totLotesL' id='totLotesL'>";
                        echo "</div>";
                        echo "<div>";
                            echo "<label>Lotes contratados</label>";
                            echo "<input type='number' step='any' placeholder='' name='lotesConL' id='lotesConL'>";
                        echo "</div>";
                        echo "<div>";
                            echo "<label>Lotes sin contrato</label>";
                            echo "<input type='number' step='any' placeholder='' name='lotesSinConL' id='lotesSinConL'>";
                        echo "</div>";
                    echo "</div>";
                    //-------------------------------------------
                    echo "<div id='programaSuelo'>";
                        echo "<label>Programa Suelo Legal</label>";
                        echo "<div>";
                            echo "<label>Total lotes</label>";
                            echo "<input type='number' step='any' placeholder='' name='totLotesS' id='totLotesS'>";
                        echo "</div>";
                        echo "<div>";
                            echo "<label>Lotes contratados</label>";
                            echo "<input type='number' step='any' placeholder='' name='lotesConS' id='lotesConS'>";
                        echo "</div>";
                        echo "<div>";
                            echo "<label>Lotes sin contrato</label>";
                            echo "<input type='number' step='any' placeholder='' name='lotesSinConS' id='lotesSinConS'>";
                        echo "</div>";
                    echo "</div>";
                    
                    //echo "<div>";
                        echo "<label>Observaciones: </label>";
                        echo "<textarea name='observaciones' id='observaciones'></textarea>";
                    //echo "</div>";

                    echo "<div id='guardar' >";
                        echo "<input class='Mbtn btn-default' type='submit' id='guardar' value='Guardar' style='width:50%;'>";
                    echo "</div>";
                echo "<br><br>";
                
            echo "</form>";
            echo "</center>";
        echo "</div>";

        

    }

    
    
   




}
else{
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}

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