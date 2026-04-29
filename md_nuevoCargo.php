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

        //ELIMINAR UN CARGO
        if(isset($_POST['eliminarCargo'])){
            $id = $_POST['eliminarCargo'];
            $sql = 'UPDATE mandantes_cargos SET Cancelado = 1 WHERE id = '.$id.'';
            //echo $sql;
            if($conexion->query($sql)==TRUE){  
                mensaje('Se elimino correctamente el registro.', 'md_nuevoCargo.php?id='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }else{
                mensaje('Hubo un error, favor de intentarlo nuevamente.', 'md_nuevoCargo.php?id='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');

            }
        }

        historia($nitavu,'Entre a capturar un nuevo cargo para el mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio:'.$idmunicipio.'');
   
        echo "<br><br>";

        echo '<a id="regCargo" href="mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'" title="Clic para regresar a la página anterior"><ins>Regresar</ins></a>';

        echo "<center><h4>INGRESA LOS DATOS DEL NUEVO MANDANDATO</h4>";
        
        echo "<label>MUNICIPIO: <b>".strtoupper(nombreMunicipio($idmunicipio))."</b></label>";
        echo "<br><label>COLONIA: <b>".strtoupper(nombreColonia($idmunicipio,$idcolonia))."</b></label>";
        echo "<br><label>MANDANTE: <b>".strtoupper(nombreMandante($idmunicipio,$idcolonia,$idmandante))."</b></label>";
       echo "<hr>";
        echo "<button class='Mbtn btn-danger' onclick=location.href='md_nuevoCargo.php?id=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."&nuevo=1' title='Clic para registrar nuevo cargo'>Registrar Nuevo</button></center>";
        
        //ANTERIORES
        echo "<form action='md_nuevoCargo.php?id=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST'>";
        $sql1 = "SELECT * FROM mandantes_cargos WHERE idmandante = ".$idmandante." and idcolonia =".$idcolonia." and idmunicipio=".$idmunicipio." and Cancelado = 0";
        //echo $sql1;
        $rc = $conexion -> query($sql1);

        if ($rc->num_rows>0){
        
            echo "<table class='tabla'>";
                echo "<th>Tipo</th>";
                echo "<th>Fecha Mandato</th>";
                echo "<th>Fecha Adendum</th>";
                echo "<th>Plazo Crédito</th>";
                echo "<th>Observaciones</th>";
                echo "<th>Modificar</th>";
                echo "<th>Eliminar</th>";
                while($r1 = $rc -> fetch_array()){
                    echo "<tr>";
                    
                        
                        if($r1['tipo']==1){
                            echo "<td>Mandato</td>";
                        }else{
                            echo "<td>Adendum</td>";
                        }
                        
                        echo "<td>".$r1['fecha_mandato']."</td>";
                        echo "<td>".$r1['fecha_adendum']."</td>";
                        echo "<td>".$r1['plazo_credito']."</td>";
                        echo "<td>".$r1['observaciones']."</td>";
                        echo "<td>";

                        echo "<button  type='submit' id='editar' name='editar'  class='Mbtn btn-danger' value='".$r1['id']."'  title='Clic para editar el registro'><img src='./icon/edit2.png' style='widht:30px; height:30px;'></button></td>";
                        echo "<td>";                       
                        echo "<button  type='submit' id='eliminarCargo' name='eliminarCargo' class='Mbtn btn-danger' value='".$r1['id']."' title='Clic para editar el registro'><img src='./icon/eliminar2.png' style='widht:30px; height:30px;'></button></td>";
                        echo "</tr>";
                }
            echo "</table>";
        }
        echo "</form>";
                
       
        if(isset($_POST['editar'])){
            $id =$_POST['editar'];

            echo "<div id='registroCargo' class='nuevoCargo'>";
            $sql = "SELECT * FROM mandantes_cargos WHERE id= ".$id." ";
            //echo $sql;
            $rc = $conexion -> query($sql);
            while($r = $rc -> fetch_array()){
                $tipo = $r['tipo'];
                echo "<center>";
            //and idmandante=".$idmandante." and idcolonia=".$idcolonia." and idmunicipio=".$idmunicipio."
                if($tipo == 1 ){
                    
                        echo "<form id='mandato' id='mandato' action='mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST' >";
                       
                            echo "<input type='hidden' name='id' id='id' value='".$r['id']."'>";
                            echo "<div id='fechaMan' name='fechaMan' > ";
                                echo "<label>Fecha del mandato</label>";
                                echo "<input type='date' name='fechaMan' id='fechaMan' value='".$r['fecha_mandato']."'>";
                            echo "</div>";
                            /*echo "<div>";
                                echo "<label>Fecha del convenio tripartita</label>";
                                echo "<input type='date' name='fechaTri' id='fechaTri' required>";
                            echo "</div>";*/
                            
                            echo "<div id='pcredito' >";
                                echo "<label>Plazo de crédito</label>";
                                echo "<input type='text' placeholder='mensualidades' name='plazoCredito' id='plazoCredito' value='".$r['plazo_credito']."'>";
                            echo "</div>";
                            echo "<div id='costoLotes' >";
                                echo "<label>Costo lotes</label>";
                                echo "<input type='number' step='any' placeholder='costo lotes $' name='costoLotes' id='costoLotes' value='".$r['costo_lotes']."'>";
                            echo "</div>";
                            echo "<div id='costom2' >";
                                echo "<label>Costo lote por metro cuadrado</label>";
                                echo "<input type='number' step='any' placeholder='costo lotes X metro cuadrado' name='LoteM2' id='LoteM2' value='".$r['costo_pormetro']."'>";
                            echo "</div>";
                            echo "<div id='suptotal' >";
                                echo "<label>Superficie total</label>";
                                echo "<input type='text' placeholder='MTS' name='superficie' id='superficie' value='".$r['superficie']."'>";
                            echo "</div>";
                            echo "<div id='supcomer' >";
                                echo "<label>Superficie para comercializar</label>";
                                echo "<input type='text' placeholder='MTS' name='supComercializar' id='supComercializar' value='".$r['superficie_comercializar']."'>";
                            echo "</div>";
                        
                            echo "<div id='porAmorAnt' >";
                            echo "<label>Amortización anticipio</label>";
                            echo "<input type='text'  name='porAmorAnt' id='porAmorAnt' value='".$r['amortizacion_anticipo']."'>";
                            echo "</div>";
                    

                            echo "<div id='pmandante' >";
                                echo "<label>Porcentaje Mandante</label>";
                                echo "<input type='number' step='any' placeholder='%' name='porMan' id='porMan' value='".$r['porcentaje_mandante']."'>";
                            echo "</div>";
                            echo "<div id='pitavu' >";
                                echo "<label>Porcentaje ITAVU</label>";
                                echo "<input type='number' step='any' placeholder='%' name='porItavu' id='porItavu' value='".$r['porcentaje_itavu']."'>";
                            echo "</div>";

                            echo "<div id='pesc' >";
                            echo "<label>Porcentaje Escrituracion</label>";// value='".$r['porcentaje_esc']."'
                            echo "<input type='number' step='any' placeholder='%' name='porEsc' id='porEsc'  value='".$r['porcentaje_escrituracion']."'>";
                            echo "</div>";

                            echo "<div id='paTotal' >";
                                echo "<label>Pago total al mandante de acuerdo al contrato</label>";
                                echo "<input type='number' step='any' placeholder='$0.00' name='monpagar' id='monpagar' value='".$r['monto_pagar']."'>";
                            echo "</div>";
                            echo "<div id='paComer' >";
                                echo "<label>Recuperación total de acuerdo a la tabla de comercialización</label>";
                                echo "<input type='number' step='any' placeholder='$0.00' name='monpagarComer' id='monpagarComer' value='".$r['monto_pagarcomercializacion']."'>";
                            echo "</div>";
                            
                                                
                            //echo "<div>";
                                echo "<center><table style='width:80%;'>";
                                echo "<td>";
                                    echo "<label>Lotes para donación</label>";
                                    echo "<input type='number' step='any' placeholder='lotes para donacion' name='lotesdonacion' id='lotesdonacion' value='".$r['donacion']."'>";
                                echo "</td>";
                                echo "<td>";
                                    echo "<label>Lotes de área verde</label>";
                                    echo "<input type='number' step='any' placeholder='lotes área verde' name='lotesareav' id='lotesareav' value='".$r['area_verde']."'>";
                                echo "</td>";
                            //echo "</div>";
                            //echo "<div>";
                                echo "<td>";
                                    echo "<label>Lotes equipamiento urbano</label>";
                                    echo "<input type='number' step='any' placeholder='lotes eq. urbano' name='loteseq' id='loteseq' value='".$r['equi_urbano']."'>";
                                echo "</td>";
                                    //echo "</div>";
                            // echo "<div>";
                                echo "<td>";  
                                    echo "<label>Lotes Reserva del Mandante</label>";
                                    echo "<input type='number' step='any' placeholder='lotes de reserva del mandante' name='lotesreserva' id='lotesreserva' value='".$r['reserva_mandante']."'>";
                                echo "</td>";
                            echo "</table></center>";
                            //echo "</div>";
        
                            //--------------------------------------
                            echo "<div id='programaLotes' >";
                                echo "<label><b>Programa Lotes</b></label><BR>";
                                echo "<div>";
                                    echo "<label>Total lotes</label>";
                                    echo "<input type='number' step='any' placeholder='' name='totLotesL' id='totLotesL' value='".$r['total_lotesLotes']."'>";
                                echo "</div>";
                                echo "<div>";
                                    echo "<label>Lotes para comercializar</label>";
                                    echo "<input type='number' step='any' placeholder='' name='lotesXComercialzarL' id='lotesXComercialzarL' value='".$r['lotes_porcomercializarLotes']."'>";
                                echo "</div>";
                                echo "<div>";
                                    echo "<label>Lotes contratados</label>";
                                    echo "<input type='number' step='any' placeholder='' name='lotesConL' id='lotesConL' value='".$r['lotes_contratadosLotes']."'>";
                                echo "</div>";
                                echo "<div>";
                                    echo "<label>Lotes sin contrato</label>";
                                    echo "<input type='number' step='any' placeholder='' name='lotesSinConL' id='lotesSinConL' value='".$r['lotes_sincontratoLotes']."'>";
                                echo "</div>";
                            echo "</div>";
                            
                            //-------------------------------------------
                            echo "<div id='programaSuelo' >";
                                echo "<label><b>Programa Suelo Legal</b></label><br>";
                                echo "<div>";
                                    echo "<label>Total lotes</label>";
                                    echo "<input type='number' step='any' placeholder='' name='totLotesS' id='totLotesS' value='".$r['total_lotesSuelo']."'>";
                                echo "</div>";                       
                                echo "<div>";
                                 echo "<label>Lotes para comercializar</label>";
                                    echo "<input type='number' step='any' placeholder='' name='lotesXComercialzarS' id='lotesXComercialzarS' value='".$r['lotes_porcomercializarSuelo']."'>";
                                echo "</div>";
                                echo "<div>";
                                    echo "<label>Lotes contratados</label>";
                                    echo "<input type='number' step='any' placeholder='' name='lotesConS' id='lotesConS' value='".$r['lotes_contratadosSuelo']."'>";
                                echo "</div>";
                                echo "<div>";
                                    echo "<label>Lotes sin contrato</label>";
                                    echo "<input type='number' step='any' placeholder='' name='lotesSinConS' id='lotesSinConS' value='".$r['lotes_sincontratoSuelo']."'>";
                                echo "</div>";
                                
                            echo "</div>";
                            echo "<br>";
                            echo "<div style='width:100%;'>";
                                echo "<label>Observaciones: </label>";
                                echo "<textarea name='observaciones' id='observaciones'>".$r['observaciones']."</textarea>";
                            echo "</div>";
                            
        
                            echo "<div id='guardar' >";
                                echo "<input class='Mbtn btn-danger' type='submit' id='editar' name='editar' value='Guardar' style='width:50%;'>";
                            echo "</div>";
                        echo "<br><br>";
                        
                        echo "</form>";
                    
                }else{
                    
                        echo "<form id='adendum' action='mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST' >";
                            
                                /*echo "<div>";
                                    echo "<label>Fecha del convenio tripartita</label>";
                                    echo "<input type='date' name='fechaTri' id='fechaTri' required>";
                                echo "</div>";*/
                                echo "<input type='hidden' name='id' id='id' value='".$r['id']."'>";
                                echo "<div id='fechaAdendum' >";
                                    echo "<label>Fecha adendum</label>";
                                    echo "<input type='date' name='fechaAdendum' id='fechaAdendum' value='".$r['fecha_adendum']."'>";
                                echo "</div>";
                                echo "<div id='fechaFiniquito' >";
                                    echo "<label>Fecha adendum finiquito</label>";
                                    
                                    echo "<input type='date' name='fechaAdendumFiniquito' id='fechaAdendumFiniquito' value='".$r['fecha_adendumfiniquito']."'>";
                                echo "</div>";
                                echo "<div id='pcredito' >";
                                    echo "<label>Plazo de crédito</label>";
                                    echo "<input type='text' placeholder='mensualidades' name='plazoCredito' id='plazoCredito' value='".$r['plazo_credito']."'>";
                                echo "</div>";
                                echo "<div id='costoLotes' >";
                                    echo "<label>Costo lotes</label>";
                                    echo "<input type='number' step='any' placeholder='costo lotes $' name='costoLotes' id='costoLotes' value='".$r['costo_lotes']."'>";
                                echo "</div>";
                                echo "<div id='costom2' >";
                                    echo "<label>Costo lote por metro cuadrado</label>";
                                    echo "<input type='number' step='any' placeholder='costo lotes X metro cuadrado' name='LoteM2' id='LoteM2' value='".$r['costo_pormetro']."'>";
                                echo "</div>";
                                echo "<div id='suptotal' >";
                                    echo "<label>Superficie total</label>";
                                    echo "<input type='text' placeholder='MTS' name='superficie' id='superficie' value='".$r['superficie']."'>";
                                echo "</div>";
                                echo "<div id='supcomer' >";
                                    echo "<label>Superficie para comercializar</label>";
                                    echo "<input type='text' placeholder='MTS' name='supComercializar' id='supComercializar' value='".$r['superficie_comercializar']."'>";
                                echo "</div>";
                                

                                echo "<div id='porAmorAnt' >";
                                echo "<label>Amortización anticipio</label>";
                                echo "<input type='text'  name='porAmorAnt' id='porAmorAnt' value='".$r['amortizacion_anticipo']."'>";
                                echo "</div>";

                                echo "<div id='pmandante' >";
                                    echo "<label>Porcentaje Mandante</label>";
                                    echo "<input type='number' step='any' placeholder='%' name='porMan' id='porMan' value='".$r['porcentaje_mandante']."'>";
                                echo "</div>";
                                echo "<div id='pitavu' >";
                                    echo "<label>Porcentaje ITAVU</label>";
                                    echo "<input type='number' step='any' placeholder='%' name='porItavu' id='porItavu' value='".$r['porcentaje_itavu']."'>";
                                echo "</div>";

                                echo "<div id='pesc' >";
                                echo "<label>Porcentaje Escrituracion</label>";// value='".$r['porcentaje_esc']."'
                                echo "<input type='number' step='any' placeholder='%' name='porEsc' id='porEsc' value='".$r['porcentaje_escrituracion']."'>";
                                echo "</div>";

                                echo "<div id='paTotal' >";
                                    echo "<label>Pago total al mandante de acuerdo al contrato</label>";
                                    echo "<input type='number' step='any' placeholder='$0.00' name='monpagar' id='monpagar' value='".$r['monto_pagar']."'>";
                                echo "</div>";
                                echo "<div id='paComer' >";
                                    echo "<label>Recuperación total de acuerdo a la tabla de comercialización</label>";
                                    echo "<input type='number' step='any' placeholder='$0.00' name='monpagarComer' id='monpagarComer' value='".$r['monto_pagarcomercializacion']."'>";
                                echo "</div>";
                                echo "<div id='relleno'>";
                                    //echo "<label>Relleno</label>";
                                    //echo "<input type='number' step='any' placeholder='$0.00' name='relleno' id='relleno' required>";
                                echo "</div>";
                                //echo "<div>";
                                    echo "<center><table style='width:80%;'>";
                                    echo "<td>";
                                    echo "<label>Lotes para donación</label>";
                                    echo "<input type='number' step='any' placeholder='lotes para donacion' name='lotesdonacion' id='lotesdonacion' value='".$r['donacion']."'>";
                                echo "</td>";
                                    echo "<td>";
                                        echo "<label>Lotes de área verde</label>";
                                        echo "<input type='number' step='any' placeholder='lotes área verde' name='lotesareav' id='lotesareav' value='".$r['area_verde']."'>";
                                    echo "</td>";
                                //echo "</div>";
                                //echo "<div>";
                                    echo "<td>";
                                        echo "<label>Lotes equipamiento urbano</label>";
                                        echo "<input type='number' step='any' placeholder='lotes eq. urbano' name='loteseq' id='loteseq' value='".$r['equi_urbano']."'>";
                                    echo "</td>";
                                        //echo "</div>";
                                // echo "<div>";
                                    echo "<td>";  
                                        echo "<label>Lotes Reserva del Mandante</label>";
                                        echo "<input type='number' step='any' placeholder='lotes de reserva del mandante' name='lotesreserva' id='lotesreserva' value='".$r['reserva_mandante']."'>";
                                    echo "</td>";
                                echo "</table></center>";
                                //echo "</div>";
            
                                
                                
                                //--------------------------------------
                                echo "<div id='programaLotes' >";
                                    echo "<label><b>Programa Lotes</b></label><br>";
                                    echo "<div>";
                                        echo "<label>Total lotes</label>";
                                        echo "<input type='number' step='any' placeholder='' name='totLotesL' id='totLotesL' value='".$r['total_lotesLotes']."'>";
                                    echo "</div>";
                                    echo "<div>";
                                    echo "<label>Lotes para comercializar</label>";
                                    echo "<input type='number' step='any' placeholder='' name='lotesXComercialzarL' id='lotesXComercialzarL' value='".$r['lotes_porcomercializarLotes']."'>";
                                echo "</div>";
                                    echo "<div>";
                                        echo "<label>Lotes contratados</label>";
                                        echo "<input type='number' step='any' placeholder='' name='lotesConL' id='lotesConL' value='".$r['lotes_contratadosLotes']."'>";
                                    echo "</div>";
                                    echo "<div>";
                                        echo "<label>Lotes sin contrato</label>";
                                        echo "<input type='number' step='any' placeholder='' name='lotesSinConL' id='lotesSinConL' value='".$r['lotes_sincontratoLotes']."'>";
                                    echo "</div>";
                                echo "</div>";
                                //-------------------------------------------
                                echo "<div id='programaSuelo'>";
                                    echo "<label><b>Programa Suelo Legal</b></label><br>";
                                    echo "<div>";
                                        echo "<label>Total lotes</label>";
                                        echo "<input type='number' step='any' placeholder='' name='totLotesS' id='totLotesS' value='".$r['total_lotesSuelo']."'>";
                                    echo "</div>";
                                    echo "<div>";
                                    echo "<label>Lotes para comercializar</label>";
                                    echo "<input type='number' step='any' placeholder='' name='lotesXComercialzarS' id='lotesXComercialzarS' value='".$r['lotes_porcomercializarSuelo']."'>";
                                echo "</div>";
                                    echo "<div>";
                                        echo "<label>Lotes contratados</label>";
                                        echo "<input type='number' step='any' placeholder='' name='lotesConS' id='lotesConS' value='".$r['lotes_contratadosSuelo']."'>";
                                    echo "</div>";
                                    echo "<div>";
                                        echo "<label>Lotes sin contrato</label>";
                                        echo "<input type='number' step='any' placeholder='' name='lotesSinConS' id='lotesSinConS' value='".$r['lotes_sincontratoSuelo']."'>";
                                    echo "</div>";
                                echo "</div>";
                                echo "<br>";
                                echo "<div style='width:100%;'>";
                                    echo "<label>Observaciones: </label>";
                                    echo "<textarea name='observaciones' id='observaciones'>".$r['observaciones']."</textarea>";
                                echo "</div>";
            
                                echo "<div id='guardar' >";
                                    echo "<input class='Mbtn btn-danger' type='submit' id='editar' name='editar' value='Guardar' style='width:50%;'>";
                                echo "</div>";
                            echo "<br><br>";
                            
                        echo "</form>";
                }
                echo "</center>";
            }  
            echo "</div>";
        }

        if(isset($_GET['nuevo'])){

            echo "<div id='registroCargo' class='nuevoCargo'>";
            echo "<center>";
                echo "<label>Tipo de cargo:";
                    echo "<select id='cargo' name='cargo' >";
                        echo "<option >Seleccione una opción...</option>";
                        echo "<option value='1'>MANDATO</option>";
                        echo "<option value='2'>ADENDUM</option>";
                    echo "</select>";
                echo "</label>";
    
               echo "<form id='mandato' style='display:none;' action='mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST'>";
                       
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

                        echo "<div id='porAmorAnt' >";
                        echo "<label>Amortización anticipio</label>";
                        echo "<input type='text'  name='porAmorAnt' id='porAmorAnt' required>";
                        echo "</div>";
                       
                        echo "<div id='pmandante' >";
                            echo "<label>Porcentaje Mandante</label>";
                            echo "<input type='number' step='any' placeholder='%' name='porMan' id='porMan' required>";
                        echo "</div>";
                        echo "<div id='pitavu' >";
                            echo "<label>Porcentaje ITAVU</label>";
                            echo "<input type='number' step='any' placeholder='%' name='porItavu' id='porItavu' required>";
                        echo "</div>";

                        echo "<div id='pesc' >";
                        echo "<label>Porcentaje Escrituracion</label>";
                        echo "<input type='number' step='any' placeholder='%' name='porEsc' id='porEsc' required>";
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
                            echo "<label>Lotes para donación</label>";
                            echo "<input type='number' step='any' placeholder='lotes para donacion' name='lotesdonacion' id='lotesdonacion' >";
                        echo "</td>";
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
                            echo "<label><b>Programa Lotes</b></label><br>";
                            echo "<div>";
                                echo "<label>Total lotes</label>";
                                echo "<input type='number' step='any' placeholder='' name='totLotesL' id='totLotesL'>";
                            echo "</div>";
                            echo "<div>";
                                    echo "<label>Lotes para comercializar</label>";
                                    echo "<input type='number' step='any' placeholder='' name='lotesXComercialzarL' id='lotesXComercialzarL' >";
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
                            echo "<label><b>Programa Suelo Legal</b></label><br>";
                            echo "<div>";
                                echo "<label>Total lotes</label>";
                                echo "<input type='number' step='any' placeholder='' name='totLotesS' id='totLotesS'>";
                            echo "</div>";
                            echo "<div>";
                                    echo "<label>Lotes para comercializar</label>";
                                    echo "<input type='number' step='any' placeholder='' name='lotesXComercialzarS' id='lotesXComercialzarS'>";
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
                        echo "<br>";
                        echo "<div style='width:100%;'>";
                            echo "<label>Observaciones: </label>";
                            echo "<textarea name='observaciones' id='observaciones'></textarea>";
                        echo "</div>";
                        
    
                        echo "<div id='guardar' >";
                            echo "<input class='Mbtn btn-danger' type='submit' id='guardar' name='guardar' value='Guardar' style='width:50%;'>";
                        echo "</div>";
                    echo "<br><br>";
                    
                echo "</form>";
    
                echo "<form id='adendum' style='display:none;' action='mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST' >";
                       
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
                            echo "<input type='date' name='fechaAdendumFiniquito' id='fechaAdendumFiniquito'>";
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
                        echo "<div id='pesc' >";
                        echo "<label>Porcentaje Escrituracion</label>";
                        echo "<input type='number' step='any' placeholder='%' name='porEsc' id='porEsc' required>";
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
                            echo "<label>Lotes para donación</label>";
                            echo "<input type='number' step='any' placeholder='lotes para donacion' name='lotesdonacion' id='lotesdonacion'>";
                        echo "</td>";
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
                            echo "<label><b>Programa Lotes</b></label><br>";
                            echo "<div>";
                                echo "<label>Total lotes</label>";
                                echo "<input type='number' step='any' placeholder='' name='totLotesL' id='totLotesL'>";
                            echo "</div>";
                            echo "<div>";
                                    echo "<label>Lotes para comercializar</label>";
                                    echo "<input type='number' step='any' placeholder='' name='lotesXComercialzarL' id='lotesXComercialzarL' >";
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
                            echo "<label><b>Programa Suelo Legal</b></label><br>";
                            echo "<div>";
                                echo "<label>Total lotes</label>";
                                echo "<input type='number' step='any' placeholder='' name='totLotesS' id='totLotesS'>";
                            echo "</div>";
                            echo "<div>";
                                    echo "<label>Lotes para comercializar</label>";
                                    echo "<input type='number' step='any' placeholder='' name='lotesXComercialzarS' id='lotesXComercialzarS' >";
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
                        echo "<br>";
                        echo "<div style='width:100%;'>";
                            echo "<label>Observaciones: </label>";
                            echo "<textarea name='observaciones' id='observaciones'></textarea>";
                        echo "</div>";
    
                        echo "<div id='guardar' >";
                            echo "<input class='Mbtn btn-danger' type='submit' id='guardar' name='guardar' value='Guardar' style='width:50%;'>";
                        echo "</div>";
                    echo "<br><br>";
                    
                echo "</form>";
                echo "</center>";
            echo "</div>";
        }
       

        

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