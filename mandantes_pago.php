<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>

<script>


    
    $(document).on("change", "#municipio", function(event) {
       $("#req_menu").css({'display':'none',});
        $("#registroPago").css({'display':'none',});
        $("#tablaRegistros").css({'display':'none',});
        
        $('#Mandantes').html('');
        $('#Apoderado').html('');
	    mostrarColonias($("#municipio option:selected").val());
        
        
    });              
    function mostrarColonias(id){
        $("#preloader").css({'display':'inline-block',});
        $("#req_menu").css({'display':'none',});
        $("#registroPago").css({'display':'none',});
        $("#tablaRegistros").css({'display':'none',});
        $('#Mandantes').html('');
        $('#Apoderado').html('');

        $.ajax({
            url: "md_colonias.php",
            type: "get",
            data: {id: id},
            success: function(data){
                $("#preloader").css({'display':'none',});
                $('#colonia').html(data+"\n");
            }
        });

        document.getElementById("idmunicipio").value=id;        
    }

    //mostrar mandantes     
    function mostrarMandantes(){
        $("#req_menu").css({'display':'none',});
        $("#registroPago").css({'display':'none',});
        $("#tablaRegistros").css({'display':'none',});
        $("#preloader").css({'display':'inline-block',});
        var id = $("#colonia option:selected").val();
        var idmunicipio = $("#municipio option:selected").val();
        
        $('#Apoderado').html('');
        $.ajax({
            url: "md_mandantes.php",
            type: "get",
            data: {id: id, idmunicipio: idmunicipio },
            success: function(data){
                $("#preloader").css({'display':'none',});
                $('#Mandantes').html(data+"\n");
            }
        });

        document.getElementById("idcolonia").value=id;
    }

    function mostrarApoderado(){
         $("#req_menu").css({'display':'none',});
        $("#registroPago").css({'display':'none',});
        $("#tablaRegistros").css({'display':'none',});
        $("#preloader").css({'display':'inline-block',});
        var id = $("#colonia option:selected").val();
        var idmunicipio = $("#municipio option:selected").val();
        var idmandante = $("#mandantes option:selected").val();

        $.ajax({
            url: "md_apoderado.php",
            type: "get",
            data: {id: id, idmunicipio: idmunicipio, idmandante: idmandante },
            success: function(data){
                $("#preloader").css({'display':'none',});
                $('#Apoderado').html(data+"\n");
            }
        });
        document.getElementById("idmandante").value=idmandante;
    }

  
    function mostrarOpciones(){
        //alert('entroActualizar');
        $("#req_menu").css({'display':'inline-block',});
        $("#tablaRegistros").css({'display':'inline-block',});
        
        var id = $("#mandantes option:selected").val();
        //alert($("#mandantes option:selected").val());
        idcolonia = document.getElementById("idcolonia").value;
        idmunicipio = document.getElementById("idmunicipio").value;
        nitavu = document.getElementById('nitavu').value;

        var URLactual = window.location;    
       
        document.getElementById('url').value = URLactual;
      
        //alert(id+','+idcolonia+','+idmunicipio);
        //history.pushState(null, "", 'mandantes_pago.php?idmandante='+id+'&idcolonia='+idcolonia+'&idmunicipio='+idmunicipio');
       //console.log('idmandante:'+id+'idcolonia'+idcolonia+'idmunicipio'+idmunicipio);
        $.ajax({
            
            url: "md_registrosMandante.php",
            type: "get",
            data: {id: id, idcolonia: idcolonia, idmunicipio: idmunicipio, nitavu: nitavu },
            success: function(data){
                $("#preloader").css({'display':'none',});
                //document.getElementById("reporteMandante").href = "md_reporte.php?id="+id+"&idcolonia="+idcolonia+"&idmunicipio="+idmunicipio;
                document.forms['reporteMandante'].action = "md_reporte.php?id="+id+"&idcolonia="+idcolonia+"&idmunicipio="+idmunicipio;
                document.getElementById("nuevoCargo").href = "md_nuevoCargo.php?id="+id+"&idcolonia="+idcolonia+"&idmunicipio="+idmunicipio;
                document.getElementById("mddocumentos").href = "md_documentos.php?id="+id+"&idcolonia="+idcolonia+"&idmunicipio="+idmunicipio;
                             
                //alert(data);
                $('#tablaRegistros').html(data+"\n");
                //document.getElementById('url1').value = URLactual;
                $('.url1').val(URLactual);   
                $('url').val(URLactual); 
                
                //console.log('puso los registros');
            }
        });
        document.getElementById("idmandante").value=id;
        
    }

    function enviarDatos(){
        //idmandante = document.formulario.idmandante.value;
        //idcolonia = document.formulario.idcolonia.value;
        //idmunicipio = document.formulario.idmunicipio.value;

        idmandante = document.getElementById("idmandante").value;
        idcolonia = document.getElementById("idcolonia").value;
        idmunicipio = document.getElementById("idmunicipio").value;

        fecha = document.formulario.fecha.value;
        periodo2 = document.formulario.periodo2.value;
        recu = document.formulario.recuperacion.value;
        pgastos = document.formulario.pgastos.value;
        gastos = document.formulario.gastos.value;
        montopagar = document.formulario.montopagar.value;
        //pdevols = document.formulario.pdevols.value;
        pdevols = 0;
        devols = document.formulario.devols.value;
        otrosdesc = document.formulario.otrosdesc.value;
        pamorAnt = document.formulario.pamorAnt.value;
        amorAnticipo = document.formulario.amorAnticipo.value;
        montoPagado = document.formulario.montoPagado.value;
        montoAcumulado = document.formulario.montoAcumulado.value;
        saldo = document.formulario.saldo.value;
        sistema = document.formulario.sistema.value;
        //engancheTraspaso = document.formulario.engancheTraspaso.value;
        var signo1 = $("#mas_menos1 option:selected").val();
        desNomina = document.formulario.desNomina.value;
        var signo2 = $("#mas_menos2 option:selected").val();
        engancheAhorro = document.formulario.engancheAhorro.value;
        var signo3 = $("#mas_menos3 option:selected").val();
        transferencia = document.formulario.transferencia.value;
        var signo4 = $("#mas_menos4 option:selected").val();
        pagosUniversales = document.formulario.pagosUniversales.value;
        var signo5 = $("#mas_menos5 option:selected").val();
        escritura = document.formulario.escritura.value;
        var signo6 = $("#mas_menos6 option:selected").val();
        derechos = document.formulario.derechos.value;
        var signo7 = $("#mas_menos7 option:selected").val();
        pagoDerechos = document.formulario.pagoDerechos.value;
        var signo8 = $("#mas_menos8 option:selected").val();
        var signo9 = $("#mas_menos9 option:selected").val();
        pagooxxo = document.formulario.pagooxxo.value;
        pagootros = document.formulario.pagootros.value;
        //centavo = document.formulario.centavo.value;
        centavo = 0;
        comentario = document.formulario.comentario.value;
        observacionPago = document.formulario.observacionPago.value;
        datosbancarios = document.formulario.datosBancarios.value;


        pgastosesc = document.formulario.pgastosesc.value;
        gastosesc = document.formulario.gastosesc.value;
        //alert(signo1+','+signo2+','+signo3+','+signo3);
        
       
        var idTipoMov = $("#tipo_mov option:selected").val();
        //window.open("md_ordenpago.php?idmandante="+idmandante+"&idcolonia="+idcolonia+"&idmunicipio="+idmunicipio);
        $.ajax({
            url: "md_ingresardatosBD.php",
            type: "post",
            data: {idmandante: idmandante, idcolonia: idcolonia, idmunicipio: idmunicipio, fecha:fecha, periodo2: periodo2, recuperacion:recu, pgastos: pgastos, gastos: gastos, 
            montopagar: montopagar, pdevols: pdevols, devols:devols, pamorAnt: pamorAnt, amorAnticipo:amorAnticipo, montoPagado: montoPagado, montoAcumulado: montoAcumulado, saldo: saldo, sistema: sistema, signo1: signo1, desNomina: desNomina,
            signo2: signo2, engancheAhorro:engancheAhorro, signo3: signo3, transferencia:transferencia, signo4:signo4, pagosUniversales: pagosUniversales, signo5: signo5, escritura: escritura, signo6:signo6,
            derechos: derechos, signo7: signo7, pagoDerechos: pagoDerechos, signo8: signo8, pagooxxo: pagooxxo, centavo: centavo, comentario: comentario, observacionPago:observacionPago, idTipoMov:idTipoMov, datosbancarios:datosbancarios,signo9: signo9, pagootros: pagootros, pgastosesc: pgastosesc, gastosesc: gastosesc , otrosdesc:otrosdesc, nitavu1: <?php echo $nitavu; ?>},
            success: function(data){
                console.log(data);
              
                 $('#mensajeConfirmacion').html(data+"\n");
                $("#mensajeConfirmacion").css({'display':'inline-block',}).slideUp(4000).delay(10000).fadeOut(4000);
                document.formulario.fecha.value = "";
                document.formulario.periodo2.value="";
                document.formulario.recuperacion.value = "";
                document.formulario.pgastos.value = "";
                document.formulario.gastos.value = "";
                document.formulario.montopagar.value = "";
                //document.formulario.pdevols.value = "";
                document.formulario.devols.value = "";
                document.formulario.otrosdesc.value = "";
                document.formulario.pamorAnt.value = "";
                document.formulario.amorAnticipo.value = "";
                document.formulario.montoPagado.value = "";
                document.formulario.montoAcumulado.value = "";
                document.formulario.saldo.value = "";
                document.formulario.sistema.value="";
                //document.formulario.engancheTraspaso.value="";
                document.formulario.desNomina.value = "";
                document.formulario.engancheAhorro.value = "";
                document.formulario.transferencia.value = "";
                document.formulario.pagosUniversales.value = "";
                document.formulario.escritura.value = "";
                document.formulario.derechos.value = "";
                document.formulario.pagoDerechos.value = "";
                document.formulario.pagooxxo.value = "";
                document.formulario.pagootros.value = "";
                document.formulario.gastosesc.value="";
                //document.formulario.centavo.value="";
                document.formulario.comentario.value = "";
                document.formulario.observacionPago.value = "";
                document.formulario.datosBancarios.value = "";
                mostrarOpciones();
            }
        });

    }

    function enviarDatos2(){
        //alert('entro2');
        
        idmandante = document.getElementById("idmandante").value;
        idcolonia = document.getElementById("idcolonia").value;
        idmunicipio = document.getElementById("idmunicipio").value;

        fecha2 = document.formulario1.fecha2.value;
        montoPagado2 = document.formulario1.montoPagado2.value;
        montoAcumulado2 = document.formulario1.montoAcumulado2.value;
        saldo2 = document.formulario1.saldo2.value;
        comentario = document.formulario1.comentario.value;
        datosbancarios=document.formulario1.datosBancarios1.value;
        
        var idTipoMov = $("#tipo_mov option:selected").val();
        //window.open("md_ordenpago.php?idmandante="+idmandante+"&idcolonia="+idcolonia+"&idmunicipio="+idmunicipio);
        $.ajax({
            url: "md_ingresardatosBD.php",
            type: "post",
            data: {idmandante: idmandante, idcolonia: idcolonia, idmunicipio: idmunicipio, fecha2:fecha2, montoPagado2: montoPagado2,montoAcumulado2: montoAcumulado2, saldo2: saldo2, comentario: comentario, idTipoMov:idTipoMov ,datosbancarios:datosbancarios,nitavu1: <?php echo $nitavu; ?>},
            success: function(data){
                console.log(data);
                $('#mensajeConfirmacion').html(data+"\n");
                $("#mensajeConfirmacion").css({'display':'inline-block',}).slideUp(4000).delay(10000).fadeOut(4000);
                document.formulario1.fecha2.value = "";
                document.formulario1.montoPagado2.value = "";
                document.formulario1.montoAcumulado2.value = "";
                document.formulario1.saldo2.value = "";
                document.formulario1.comentario.value="";
            
                mostrarOpciones();
            }
        });
    }

    function pasarId(vuelta){
        
        idComprobante = document.getElementById('idComprobante'+vuelta).value;
        idmandante = document.getElementById('idmandante1').value;
        idcolonia = document.getElementById('idcolonia1').value;
        idmunicipio = document.getElementById('idmunicipio1').value;
        document.getElementById('comprobante').value = idComprobante;
        document.getElementById('idmandante2').value = idmandante;
        document.getElementById('idcolonia2').value = idcolonia;
        document.getElementById('idmunicipio2').value = idmunicipio;
    }

   function seleccionarQueDivMostrar(){
       var id = $("#tipo_mov option:selected").val();
       //alert(id);
       if(id == 3){
          
        

        buscarGastosAdmin();
        buscarGastosEsc();
        buscarAmortizacionAnt();
       
           $("#formulario").css({'display':'inline-block',});
           $("#formulario1").css({'display':'none',});

           

       }else{
            $("#formulario1").css({'display':'inline-block',});
            $("#formulario").css({'display':'none',});
       }
       
      
   }

   function recalcular(){
        idmandante = document.getElementById("idmandante").value;
        idcolonia = document.getElementById("idcolonia").value;
        idmunicipio = document.getElementById("idmunicipio").value;
        nitavu = document.getElementById('nitavu').value;

        $.ajax({
            url: "md_recalcular.php",
            type: "post",
            data: {idmandante: idmandante, idcolonia: idcolonia, idmunicipio: idmunicipio, nitavu:nitavu},
            success: function(data){
                console.log(data);
                $('#respuesta').html(data+"\n");
            }
        });
   }
   

</script>


<?php
require("config.php");
$id_aplicacion = 'ap70';
xd_update('ap70',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
echo "<input type='hidden' id='nitavu' name='nitavu' value='".$nitavu."'>";

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    
    historia($nitavu, 'Entre al módulo de pago a mandantes');
    if(isset($_GET['idmandante']) and isset($_GET['idcolonia']) and isset($_GET['idmunicipio'])  ){
        $idmandante = $_GET['idmandante'];
        $idcolonia = $_GET['idcolonia'];
        $idmunicipio = $_GET['idmunicipio'];
       /* if(isset($_POST['numoficio'])){
            echo $id = $_POST['idabono'];
            echo $num = strtoupper($_POST['numoficio']);

            if(ingresarNumerodeOficio($id,$num) == TRUE){
                historia($nitavu, 'Agregue el número de oficio al pago con id: '.$id.' con el cual salio la orden de pago para el mandante id: '.$idmandante.' .');
                mensaje('Se ha guardado la información con éxito.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');  
            }else{
                mensaje('Hubo un error al momento de guardar la información.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');  
            }

        }*/

        

        //EDITAR UN CARGO 
        if(isset($_POST['fechaMan'])  and isset($_POST['superficie']) and isset($_POST['costoLotes']) and isset($_POST['editar'])){
            $id = $_POST['id'];
            $fechaman = $_POST['fechaMan'];
            //$fechatri = $_POST['fechaTri'];
            $fechaAdendum = "";
            $fechaAdendumFiniquito = "";
            $plazoCredito = $_POST['plazoCredito'];
            $costoLotes = $_POST['costoLotes'];
            $LoteM2 = $_POST['LoteM2'];
            $superficie = $_POST['superficie'];
            $supComercializar = $_POST['supComercializar'];
            //$lotescol = $_POST['lotescol'];
            //$lotesareav = $_POST['lotesareav'];
            //$loteq = $_POST['loteq'];
            $porMan = $_POST['porMan'];
            $porItavu = $_POST['porItavu'];
            $monpagar = $_POST['monpagar'];
            $porEsc = $_POST['porEsc'];
            $monpagarComer = $_POST['monpagarComer'];

            
            //$pagoInicial = $_POST['pagoInicial'];
            $totLotesL = $_POST['totLotesL'];
            $lotesXComercialzarL = $_POST['lotesXComercialzarL'];
            $lotesConL = $_POST['lotesConL'];
            $lotesSinConL = $_POST['lotesSinConL'];
            $totLotesS = $_POST['totLotesS'];
            $lotesXComercialzarS = $_POST['lotesXComercialzarS'];
            $lotesConS = $_POST['lotesConS'];
            $lotesSinConS = $_POST['lotesSinConS'];
            $lotesdonacion = $_POST['lotesdonacion'];
            $lotesareav = $_POST['lotesareav'];
            $loteseq = $_POST['loteseq'];
            $reserva = $_POST['lotesreserva'];
            $observaciones = $_POST['observaciones'];
            $porAmorAnt=$_POST['porAmorAnt'];


            
            $nuevo = modificarNuevoCargo($id,$idmandante, $idcolonia, $idmunicipio, $fechaman, 
            $fechaAdendum, $fechaAdendumFiniquito, $plazoCredito, $costoLotes, $LoteM2, $superficie,
            $supComercializar, $porMan, $porItavu, $monpagar, $monpagarComer,
            $totLotesL, $lotesConL, $lotesSinConL, $totLotesS, $lotesConS, $lotesSinConS, 1,$lotesareav, $loteseq, $reserva, $observaciones,$lotesXComercialzarL,$lotesXComercialzarS,$lotesdonacion,$porEsc,$porAmorAnt);
            
            if($nuevo == TRUE){
                historia($nitavu, 'Modifique un nuevo cargo al mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio: '.$idmunicipio.'');
                mensaje('Se ha modificado con éxito el nuevo cargo.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }else{
                historia($nitavu, 'No se modifico el nuevo cargo con éxito al mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio: '.$idmunicipio.'');
                mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }
        }

        if(isset($_POST['fechaAdendum']) and isset($_POST['fechaAdendumFiniquito']) and isset($_POST['editar'])){
            $id = $_POST['id'];
            $fechaman = "";
            //$fechatri = $_POST['fechaTri'];
            $fechaAdendum = $_POST['fechaAdendum'];
            $fechaAdendumFiniquito = $_POST['fechaAdendumFiniquito'];
            $plazoCredito = $_POST['plazoCredito'];
            $costoLotes = $_POST['costoLotes'];
            $LoteM2 = $_POST['LoteM2'];
            $superficie = $_POST['superficie'];
            $supComercializar = $_POST['supComercializar'];
            //$lotescol = $_POST['lotescol'];
            //$lotesareav = $_POST['lotesareav'];
            //$loteq = $_POST['loteq'];
            $porMan = $_POST['porMan'];
            $porItavu = $_POST['porItavu'];
            $porEsc = $_POST['porEsc'];
            $monpagar = $_POST['monpagar'];
            $monpagarComer = $_POST['monpagarComer'];
            //$pagoInicial = $_POST['pagoInicial'];
            
            $lotesXComercialzarL = $_POST['lotesXComercialzarL'];
            $lotesXComercialzarS = $_POST['lotesXComercialzarS'];
            $totLotesL = $_POST['totLotesL'];
            $lotesConL = $_POST['lotesConL'];
            $lotesSinConL = $_POST['lotesSinConL'];
            $totLotesS = $_POST['totLotesS'];
            $lotesConS = $_POST['lotesConS'];
            $lotesSinConS = $_POST['lotesSinConS'];

            $lotesdonacion = $_POST['lotesdonacion'];
            $lotesareav = $_POST['lotesareav'];
            $loteseq = $_POST['loteseq'];
            $reserva = $_POST['lotesreserva'];
            $observaciones = $_POST['observaciones'];
            $porAmorAnt=$_POST['porAmorAnt'];

            $nuevo = modificarNuevoCargo($id,$idmandante, $idcolonia, $idmunicipio, $fechaman, 
            $fechaAdendum, $fechaAdendumFiniquito, $plazoCredito, $costoLotes, $LoteM2, $superficie,
            $supComercializar, $porMan, $porItavu, $monpagar, $monpagarComer, 
            $totLotesL, $lotesConL, $lotesSinConL, $totLotesS, $lotesConS, $lotesSinConS,2,$lotesareav, $loteseq, $reserva, $observaciones,$lotesXComercialzarL,$lotesXComercialzarS,$lotesdonacion, $porEsc,$porAmorAnt);
            
            if($nuevo == TRUE){
                historia($nitavu, 'Modifique un nuevo cargo al mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio: '.$idmunicipio.'');
                mensaje('Se ha modificado con éxito el nuevo cargo.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }else{
                historia($nitavu, 'No se modifico el nuevo cargo con éxito al mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio: '.$idmunicipio.'');
                mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }
        }

        //AGREGAR UN CARGO NUEVO 
        if(isset($_POST['fechaMan'])  and isset($_POST['superficie']) and isset($_POST['costoLotes']) and isset($_POST['guardar'])){
            
            $fechaman = $_POST['fechaMan'];
            //$fechatri = $_POST['fechaTri'];
            $fechaAdendum = "";
            $fechaAdendumFiniquito = "";
            $plazoCredito = $_POST['plazoCredito'];
            $costoLotes = $_POST['costoLotes'];
            $LoteM2 = $_POST['LoteM2'];
            $superficie = $_POST['superficie'];
            $supComercializar = $_POST['supComercializar'];
            //$lotescol = $_POST['lotescol'];
            //$lotesareav = $_POST['lotesareav'];
            //$loteq = $_POST['loteq'];
            $porMan = $_POST['porMan'];
            $porItavu = $_POST['porItavu'];
            $monpagar = $_POST['monpagar'];
            $monpagarComer = $_POST['monpagarComer'];

            
            //$pagoInicial = $_POST['pagoInicial'];
            $totLotesL = $_POST['totLotesL'];
            $lotesConL = $_POST['lotesConL'];
            $lotesSinConL = $_POST['lotesSinConL'];
            $totLotesS = $_POST['totLotesS'];
            $lotesConS = $_POST['lotesConS'];
            $lotesSinConS = $_POST['lotesSinConS'];

            $lotesdonacion = $_POST['lotesdonacion'];
            $lotesareav = $_POST['lotesareav'];
            $loteseq = $_POST['loteseq'];
            $reserva = $_POST['lotesreserva'];
            $observaciones = $_POST['observaciones'];

            
            $lotesXComercialzarL = $_POST['lotesXComercialzarL'];
            $lotesXComercialzarS = $_POST['lotesXComercialzarS'];
            $porEsc = $_POST['porEsc'];
            $porAmorAnt=$_POST['porAmorAnt'];

            $nuevo = agregarNuevoCargo($idmandante, $idcolonia, $idmunicipio, $fechaman, 
            $fechaAdendum, $fechaAdendumFiniquito, $plazoCredito, $costoLotes, $LoteM2, $superficie,
            $supComercializar, $porMan, $porItavu, $monpagar, $monpagarComer,
            $totLotesL, $lotesConL, $lotesSinConL, $totLotesS, $lotesConS, $lotesSinConS, 1,$lotesareav, $loteseq, $reserva, $observaciones,$lotesXComercialzarL,$lotesXComercialzarS,$lotesdonacion,$porEsc,$porAmorAnt);
            
            if($nuevo == TRUE){
                historia($nitavu, 'Agregue un nuevo cargo al mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio: '.$idmunicipio.'');
                mensaje('Se ha registrado con éxito el nuevo cargo.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }else{
                historia($nitavu, 'No se agrego el nuevo cargo con éxito al mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio: '.$idmunicipio.'');
                mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }
        }

        if(isset($_POST['fechaAdendum']) and isset($_POST['fechaAdendumFiniquito']) and isset($_POST['guardar'])){
            $fechaman = "";
            //$fechatri = $_POST['fechaTri'];
            $fechaAdendum = $_POST['fechaAdendum'];
            $fechaAdendumFiniquito = $_POST['fechaAdendumFiniquito'];
            $plazoCredito = $_POST['plazoCredito'];
            $costoLotes = $_POST['costoLotes'];
            $LoteM2 = $_POST['LoteM2'];
            $superficie = $_POST['superficie'];
            $supComercializar = $_POST['supComercializar'];
            //$lotescol = $_POST['lotescol'];
            //$lotesareav = $_POST['lotesareav'];
            //$loteq = $_POST['loteq'];
            $porMan = $_POST['porMan'];
            $porItavu = $_POST['porItavu'];
            $monpagar = $_POST['monpagar'];
            $monpagarComer = $_POST['monpagarComer'];
            //$pagoInicial = $_POST['pagoInicial'];
            $totLotesL = $_POST['totLotesL'];
            $lotesConL = $_POST['lotesConL'];
            $lotesSinConL = $_POST['lotesSinConL'];
            $totLotesS = $_POST['totLotesS'];
            $lotesConS = $_POST['lotesConS'];
            $lotesSinConS = $_POST['lotesSinConS'];

            $lotesdonacion = $_POST['lotesdoancion'];
            $lotesareav = $_POST['lotesareav'];
            $loteseq = $_POST['loteseq'];
            $reserva = $_POST['lotesreserva'];
            $observaciones = $_POST['observaciones'];
            

            $lotesXComercialzarL = $_POST['lotesXComercialzarL'];
            $lotesXComercialzarS = $_POST['lotesXComercialzarS'];
            $porEsc = $_POST['porEsc'];
            $porAmorAnt=$_POST['porAmorAnt'];
            $nuevo = agregarNuevoCargo($idmandante, $idcolonia, $idmunicipio, $fechaman, 
            $fechaAdendum, $fechaAdendumFiniquito, $plazoCredito, $costoLotes, $LoteM2, $superficie,
            $supComercializar, $porMan, $porItavu, $monpagar, $monpagarComer, 
            $totLotesL, $lotesConL, $lotesSinConL, $totLotesS, $lotesConS, $lotesSinConS,2,$lotesareav, $loteseq, $reserva, $observaciones,$lotesXComercialzarL,$lotesXComercialzarS,$lotesdonacion,$porEsc,$porAmorAnt);
            
            if($nuevo == TRUE){
                historia($nitavu, 'Agregue un nuevo cargo al mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio: '.$idmunicipio.'');
                mensaje('Se ha registrado con éxito el nuevo cargo.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }else{
                historia($nitavu, 'No se agrego el nuevo cargo con éxito al mandante: idmandante: '.$idmandante.' idcolonia: '.$idcolonia.' idmunicipio: '.$idmunicipio.'');
                mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }
        }

        //GUARDAR EN LA BD LOS DATOS MODIFICADOS DE UN PAGO
        if(isset($_GET['idpago'])){
            $id=$_GET['idpago'];

            if(isset($_POST['fecha2'])){
                $fecha1 = $_POST['fecha2'];
                $fecha2 = $fecha1;
                $recu = 0;
                $pgastos = 0;
                $gastos = 0;
                $montopagar= 0;
                $pdevols = 0;
                $devols = 0;
                $pamorAnt = 0;
                $amorAnticipo = 0;
                $montoPagado = $_POST['montoPagado2'];
                $montoAcumulado = $_POST['montoAcumulado2'];
                $saldo = $_POST['saldo2'];
                $sistema = 0;
               // $engancheTraspaso = 0;
                $mas_menos1 = "";
                $desNomina = 0;
                $mas_menos2 = "";
                $engancheAhorro = 0;
                $mas_menos3 = "";
                $transferencia = 0;
                $mas_menos4  = "";
                $pagosUniversales = 0;
                $mas_menos5 = "";
                $escritura = 0;
                $mas_menos6  = "";
                $derechos = 0;
                $mas_menos7  = "";
                $pagoDerechos = 0;
                $mas_menos8  = "";
                $pagooxxo = 0;
                $centavo = 0;
                $comentario = $_POST['comentario'];
                $observacionPago = '';
                $datosbancarios = $_POST['datos_bancarios'];
                $pgastosesc = 0;
                $gastosesc = 0;
            }else{
                $fecha1 = $_POST['fecha'];
                $fecha2 = $_POST['periodo2'];
                if($fecha2 == ""){
                    $fecha2=$fecha1; 
                }
                $recu = $_POST['recuperacion'];
                $pgastos = $_POST['pgastos'];
                $gastos = $_POST['gastos'];
                $montopagar= $_POST['montopagar'];
                //$pdevols = $_POST['pdevols'];
                $pdevols = 0;
                $devols = $_POST['devols'];
                $otrosdesc = $_POST['otrosdesc'];
                $pamorAnt = $_POST['pamorAnt'];
                $amorAnticipo = $_POST['amorAnticipo'];
                $montoPagado = $_POST['montoPagado'];
                $montoAcumulado = $_POST['montoAcumulado'];
                $saldo = $_POST['saldo'];
                $sistema = $_POST['sistema'];
                //$engancheTraspaso = $_POST['engancheTraspaso'];
                $mas_menos1 = $_POST['mas_menos1'];
                $desNomina = $_POST['desNomina'];
                $mas_menos2 = $_POST['mas_menos2'];
                $engancheAhorro = $_POST['engancheAhorro'];
                $mas_menos3 = $_POST['mas_menos3'];
                $transferencia = $_POST['transferencia'];
                $mas_menos4  = $_POST['mas_menos4'];
                $pagosUniversales = $_POST['pagosUniversales'];
                $mas_menos5 = $_POST['mas_menos5'];
                $escritura = $_POST['escritura'];
                $mas_menos6  = $_POST['mas_menos6'];
                $derechos = $_POST['derechos'];
                $mas_menos7  = $_POST['mas_menos7'];
                $pagoDerechos = $_POST['pagoDerechos'];
                $mas_menos8  = $_POST['mas_menos8'];
                $pagooxxo = $_POST['pagooxxo'];
                //$centavo = $_POST['centavo'];
                $mas_menos9 = $_POST['mas_menos9'];
                $pagootros = $_POST['pagootros'];
                $centavo = 0;
                $comentario = $_POST['comentario'];
                $observacionPago = $_POST['observacionPago'];
                $datosbancarios = $_POST['datos_bancarios'];
                $pgastosesc = $_POST['pgastosesc'];
            $gastosesc = $_POST['gastosesc'];
            }  
            
           

            $res = actualizarPago($id, $fecha1, $fecha2, $recu, $pgastos,
            $gastos,$montopagar, $pdevols,$devols, $pamorAnt, $amorAnticipo, $montoPagado,
            $montoAcumulado, $saldo, $sistema, $mas_menos1, $desNomina, $mas_menos2, 
            $engancheAhorro, $mas_menos3,$transferencia, $mas_menos4, $pagosUniversales,
            $mas_menos5,$escritura, $mas_menos6,$derechos,$mas_menos7,$pagoDerechos,$mas_menos8, $pagooxxo, $centavo, $comentario, $observacionPago, $nitavu,$datosbancarios,$pgastosesc,$gastosesc,$mas_menos9, $pagootros,$otrosdesc);

            if($res == TRUE){
                historia($nitavu, 'Modifique el pago, idpago: '.$id.'');
                mensaje('Se ha modificado con éxito el pago.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }else{
                historia($nitavu, 'Ocurrio un error al momento de modificar el pago, id pago: '.$id.' ');
                mensaje('Ocurrio un error al momento de guardar la información, por favor vuelva a intentarlo.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }
        }
         
        //ELIMINAR UN REGISTRO 
        if(isset($_GET['ideliminar']))
        {
            $id = $_GET['ideliminar'];
            $res = eliminarRegistroPago($id,$nitavu);
            if($res==TRUE){
                historia($nitavu, 'Elimine el pago, idpago: '.$id.'');
                mensaje('Se ha eliminado con éxito el pago.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }else{
                historia($nitavu, 'Ocurrio un error al momento de eliminar el pago, idpago: '.$id.'');
                mensaje('Ocurrio un problema al momento de eliminar el pago, favor de volver a intentarlo.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }
        }

        
        echo "<center><div>"; 
            echo "<a style='right: 0px; position: absolute; top: 50px;' href='md_lista.php' title='Clic para ver lista de mandantes' class='btn btn-link'>";
            echo "Lista Mandantes</a>";
            echo "<a style='right: 150px; position: absolute; top: 50px;' href='md_pagomandantes.php' title='Clic para crear el oficio de pago a mandantes' class='btn btn-link'>";
            echo "Pago Mandantes</a>";
        echo "</div></center>";

        echo '<br><br><br>';
        echo "<h3>Registar pago a mandantes</h3>";
        //echo "<form action='mandantes_pago.php' method='POST'>";
        echo '<div class="container" style="background:#E9ECED;">';
        echo "<center>";
        echo "<div>";
            echo "<label for='municipio'>Seleccione un municipio:";
            echo "<select id='municipio' name='municipio'>";

            $sql1 = "SELECT * FROM cat_municipios";
                $r = $conexion -> query($sql1);
                while($f = $r -> fetch_array()){ // resultado de la busqueda.................
                    if ($idmunicipio==$f['IdMunicipio']){
                         echo "<option value='".$f['IdMunicipio']."' selected>".$f['municipio']."</option>";
                    }else{
                        echo "<option value='".$f['IdMunicipio']."'>".$f['municipio']."</option>";
                    } 
                }
            
            echo "</select>";
            echo "</label>";
        echo "</div>";

        echo "<div name='colonia' id='colonia'>";
            $sql2 = "SELECT * FROM cat_colonias WHERE IdMunicipio = ".$idmunicipio."";
            $r = $conexion -> query($sql2);

            echo "<label for='colonia'>Seleccione una colonia:";
                echo "<select id='colonia' name='colonia' onchange='mostrarMandantes()'>";
                   
                    while($f = $r -> fetch_array()){ // resultado de la busqueda.................
                        if ($idcolonia==$f['idcolonia']){
                            echo "<option value='".$f['idcolonia']."' selected>".$f['colonia']."</option>";
                        }else{
                            echo "<option value='".$f['idcolonia']."'>".$f['colonia']."</option>";
                        }
                        
                    }
                
                echo "</select>";
            echo "</label>";
        echo "</div>";


        echo "<div name='Mandantes' id='Mandantes'>";
            $sql3 = "SELECT * FROM cat_mandantes WHERE IdColonia = ".$idcolonia." and IdMunicipio=".$idmunicipio." and Cancelado = 0";
            $r = $conexion -> query($sql3);

            echo "<label for='mandantes'>Seleccione un mandante:";
                echo "<select id='mandantes' name='mandantes' onchange='mostrarApoderado()'>";
                   
                    while($f = $r -> fetch_array()){ // resultado de la busqueda.................
                        if ($idmandante==$f['IdMandante']){
                            echo "<option value='".$f['IdMandante']."' selected>".$f['Propietarios']."</option>";
                        }else{
                            echo "<option value='".$f['IdMandante']."'>".$f['Propietarios']."</option>";
                        }
                    }
                
                echo "</select>";
            echo "</label>";
        echo "</div>";

        echo "<div name='Apoderado' id='Apoderado'>";
            $sql4 = "SELECT Mandante FROM cat_mandantes WHERE IdColonia = ".$idcolonia." and IdMunicipio=".$idmunicipio."  and IdMandante=".$idmandante." and Cancelado = 0 ORDER BY Mandante ASC";
            $r = $conexion -> query($sql4);
            echo "<label for='mandantes'>Seleccione un apoderado:";
                echo "<select id='mandantes' name='mandantes' onchange='mostrarOpciones()'>";
                echo "<option>Seleccione un apoderado...</option>";
                    
                    while($f = $r -> fetch_array()){ // resultado de la busqueda.................
                      
                            echo "<option value='".$f['IdMandante']."' selected>".$f['Mandante']."</option>";
                        
                        
                    }
                
                echo "</select>";
            echo "</label>";
        echo "</div>";
        echo "</center>";
        echo "</div>";//cierra contenedor
        //OPCIONES
        
        //BOTONES MENU
        echo "<br><br><br>";
        echo "<center>";
        echo "<div id='req_menu' style='display:inline-block;'>"; 
            echo "<a href='#registroPago' rel='MyModal:open' class='Mbtn btn-danger' title='Clic para registrar un nuevo pago'>";
          
            echo "<table  width='100%'><tr><td valign='middle' align='center'>";
            echo "<img src='icon/pago.png' style='width:30px; height:30px;'>";
            echo "</td>";
            echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
            echo "Registar Pago";
            echo "</td></tr></table>";
            
            echo "</a>";	
            
            //?id=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."
            MiToken_Init($nitavu, 'PAGO A MANDANTES-ORDEN DE PAGO'); // inicializamos seguridad del Token (no necesitamos saberlo)
            echo "<a style='vertical-align: text-bottom;'>";
            echo "<form id='reporteMandante' action='md_reporte.php?id=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST'>";
           //href="md_reporte.php"
            echo '<button type="submit"  class="Mbtn btn-danger"  title="Clic para ver el reporte">';
            echo "<input type='hidden' id='url' name='url'>";
            echo "<table  width='100%'><tr><td valign='middle' align='center'>";
            echo "<img src='icon/pdf.png' style='width:30px; height:30px;'>";
            echo "</td>";
            echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
            echo "Crear Reporte";
            echo "</td></tr></table></button>";
            echo "</form>";
            echo "</a>";
            
            echo "<a id='nuevoCargo' href='md_nuevoCargo.php?id=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' class='Mbtn btn-danger' title='Clic para capturar un cargo'>";
            
            echo "<table  width='100%'><tr><td valign='middle' align='center'>";
            echo "<img src='icon/cargo.png' style='width:30px; height:30px;'>";
            echo "</td>";
            echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
            echo "Registrar Cargo";
            echo "</td></tr></table>";
            echo "</a>";

            echo "<a id='mddocumentos' href='md_documentos.php?id=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' class='Mbtn btn-danger' title='Clic para agregar documentos al mandante'>";
            echo "<table  width='100%'><tr><td valign='middle' align='center'>";
            echo "<img src='icon/folio.png' style='width:30px; height:30px;'>";
            echo "</td>";
            echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
            echo "Documentos";
            echo "</td></tr></table>";
            echo "</a>";

            //SOLO INFORMATICA VA A TENER ACCESO A ESTE BOTÓN, ES PARA CORREGIR CUENTAS 
            //if (pertenecesaInformatica($nitavu)== true){
                echo "<a id='recalculo' onclick='recalcular()' class='Mbtn btn-danger' title='Clic para recaulcular los saldos del mandante'>";
                
                echo "<table  width='100%'><tr><td valign='middle' align='center'>";
                echo "<img src='icon/recalcular.png' style='width:20px; height:30px;'>";
                echo "</td>";
                echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
                echo "Recalcular Saldos";
                echo "</td></tr></table>";
                
                echo "</a>";
            //}
            
        echo "</div>";
        echo "</center>";

        echo '<div name="respuesta" id="respuesta"></div>'; 

       //Ingresar datos
        echo "<center>";
        echo "<div id='registroPago' class='MyModal' style='width:70%; display:none;'>";
            echo "<h1>Ingresa los datos que se solicitan</h1>";
            
            $sql4 = "SELECT * FROM cat_mov_mandante";
            $r4 = $conexion -> query($sql4);
            
            echo "<center><div style='width:100%'>";
            echo "<label for='tipo_mov'>Seleccione un tipo de pago:";
                echo "<select id='tipo_mov' name='tipo_mov' onchange='seleccionarQueDivMostrar()'>";
                    echo "<option>Seleccione una opcion...</option>";
                    while($f4 = $r4 -> fetch_array()){ // resultado de la busqueda.................
                        
                        echo "<option value='".$f4['id']."'>".$f4['nombre']."</option>";
                        
                    }
                
                echo "</select>";
            echo "</label>"; 
            echo "</div></center>";

            echo "<input type='hidden' name='idmandante' id='idmandante' value=".$idmandante." readonly>";
            echo "<input type='hidden' name='idcolonia' id='idcolonia' value=".$idcolonia." readonly>";
            echo "<input type='hidden' name='idmunicipio' id='idmunicipio' value=".$idmunicipio." readonly>";
            echo "<input type='hidden' name='nitavu' id='nitavu' value='".$nitavu."' readonly>";

           echo "<form name='formulario' id='formulario' style='display:none' action=''  onSubmit='enviarDatos(); return false'>";
           //  echo '<form name="formulario" onSubmit="enviarDatos();" >';
           
                 echo '<label><input type="checkbox" id="peri2" name="peri2" value="periodo2" onClick="mostrarFecha2()">Periodo</label>';
                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                        echo "<label>Fecha 1</label>";
                        echo "<input type='date' name='fecha' id='fecha' required>";
                        echo "</td>";
                        echo "<td id='fech2' style='display:none;'>";
                        echo "<label>Fecha 2</label>";
                        echo "<input type='date' name='periodo2' id='periodo2'>";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                echo "<div>";
                    echo "<label>Recuperación</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' onkeyup='todas();' name='recuperacion' id='recuperacion' required>";
                echo "</div>";


                echo "<div>";
                echo "<table style='width:100%;'>";
                    echo "<td>";
                        echo "<label style='text-align:center;'>%</label>";
                        echo "<input type='number' step='any' placeholder='%' onkeyup='calcularAmortizacion();' name='pamorAnt' id='pamorAnt' required>";
                    echo "</td>";
                    echo "<td>";
                        echo "<label>Amortización de anticipo</label>";
                        echo "<input type='number' step='any' placeholder='$0.00' name='amorAnticipo' id='amorAnticipo' required>";
                    echo "</td>";
                echo "</table>";
            echo "</div>";  

                 
            echo "<div>";
            echo "<label>Monto por pagar</label>";
            echo "<input type='number' step='any' placeholder='$0.00' name='montopagar' id='montopagar' required>";
        echo "</div>";
                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>%</label>";
                            echo "<input type='number' step='any' placeholder='%' name='pgastos' id='pgastos' value='".GastosAdminMandante($idmandante,$idcolonia,$idmunicipio)."' required>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label>Gastos de admon.</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='gastos' id='gastos' required>";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";

                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>%</label>";//value='".GastosAdminMandante($idmandante,$idcolonia,$idmunicipio)."'
                            echo "<input type='number' step='any' placeholder='%' name='pgastosesc' id='pgastosesc'  value='".GastosEscMandante($idmandante,$idcolonia,$idmunicipio)."'  required>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label>Gastos de escrituracion</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='gastosesc' id='gastosesc' required>";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                
               echo "<div>";
                    /*echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>%</label>";
                            echo "<input type='number' step='any' placeholder='%' onkeypress='calcularDevoluciones();' name='pdevols' id='pdevols' required>";
                        echo "</td>";
                        echo "<td>";*/
                            echo "<label>Devoluciones</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='devols' id='devols' onkeyup='calcularDevoluciones();' value='0'>";
                       /* echo "</td>";
                    echo "</table>";*/
                echo "</div>";
                
                echo "<div>";            
                        echo "<label>Otros Descuentos</label>";
                        echo "<input type='number' step='any' placeholder='$0.00' name='otrosdesc' id='otrosdesc'   onkeyup='calcularDevoluciones();' value='0'>";
                 echo "</div>";
             

                echo "<div>";
                    echo "<label>Monto pagado</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' onkeyup='operaciones(1);' name='montoPagado' id='montoPagado' required>";
                echo "</div>";
            echo "<div id='calculados' name='calculados'>";
                echo "<div>";
                    echo "<label>Monto acumulado</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='montoAcumulado' id='montoAcumulado' required>";
                echo "</div>";
                echo "<div>";
                    echo "<label>Saldo</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='saldo' id='saldo' required>";
                echo "</div>";
            echo "</div>";
                echo "<div>";
                    echo "<label>Recuperación emitida por el sistema</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='sistema' id='sistema' >";
                echo "</div>";
                
               /* echo "<div>";
                    echo "<label>Enganche ahorro por identificar y traspasar</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='engancheTraspaso' id='engancheTraspaso'>";
                echo "</div>";*/


                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos2' name='mas_menos2'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Enganche ahorro por identificar y traspasar</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='engancheAhorro' id='engancheAhorro' >";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";


                 echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos1' name='mas_menos1'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>Descuento por nómina</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='desNomina' id='desNomina' >";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                
                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos3' name='mas_menos3'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Por transferencia</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='transferencia' id='transferencia' >";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
              echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos4' name='mas_menos4'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Por pagos universales</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='pagosUniversales' id='pagosUniversales' >";
                        echo "</td>";
                    echo "</table>";
                
                echo "</div>";
                echo "<div>";

                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos5' name='mas_menos5'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Por concepto de escritura</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='escritura' id='escritura' >";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos6' name='mas_menos6'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Por cesión de derechos</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='derechos' id='derechos'>";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos7' name='mas_menos7'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Por pago de derechos</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='pagoDerechos' id='pagoDerechos'>";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos8' name='mas_menos8'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Por pago en oxxo</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='pagooxxo' id='pagooxxo'>";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
               /* echo "<div>";
                    echo "<label>Ajuste al centavo</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='centavo' id='centavo' required>";
                echo "</div>";*/

                //echo "<div>";
               


                echo "<div>";
                echo "<table style='width:100%;'>";
                    echo "<td>";
                        echo "<label style='text-align:center;'>(+/-)</label>";
                        echo "<select id='mas_menos9' name='mas_menos9'>";
                            echo "<option value='1'>más</option>";
                            echo "<option value='2'>menos</option>";
                        echo "</select>";
                    echo "</td>";
                    echo "<td>";
                        echo "<label  style='text-align:center;'>Otros pagos</label>";
                        echo "<input type='number' step='any' placeholder='$0.00' name='pagootros' id='pagootros'>";
                    echo "</td>";
                echo "</table>";
            echo "</div>";

             echo "<div>";
            //echo "<table>";
             //   echo "<td>";
                    echo "<label>Comentario</label>";
                    echo "<input type='text'  placeholder='comentario' name='comentario' id='comentario' required>";
               // echo "</td>";
                //echo "<td>";
        echo "</div>";
           /* echo "<div>";
                echo "<label>Ajuste al centavo</label>";
                echo "<input type='number' step='any' placeholder='$0.00' name='centavo' id='centavo' required>";
            echo "</div>";*/

            //echo "<div>";
           

                echo "<div>";
                            echo "<label>Observacion para Pago</label>";
                            echo "<input type='text'  placeholder='Observación para el pago' name='observacionPago' id='observacionPago'>";
                        //echo "</td>";
                    //echo "</table>";
             echo "</div>"; 
            //     echo "<div>";
            //     echo "<label>Observacion para Pago2</label>";
            //     echo "<input type='text'  placeholder='Observación para el pago' name='observacionPago2' id='observacionPago2'>";
            // echo "</div>"; 
            

            echo "<div>";
            echo "<label>Datos Bancarios</label>";
            echo "<input type='text'  placeholder='Datos bancarios' name='datosBancarios' id='datosBancarios'>";
             echo "</div>"; 
                //echo "</div>";
                echo "<div>";
                    echo "<input class='Mbtn btn-danger' type='submit' id='guardar' value='Guardar' >";
                echo "</div>";
                
            echo "</form>";


            echo "<form name='formulario1' id='formulario1' style='display:none; width:100%;' action=''  onSubmit='enviarDatos2(); return false'>";
           //  echo '<form name="formulario" onSubmit="enviarDatos();" >';
                echo "<div>";
                    echo "<label>Fecha de pago</label>";
                    echo "<input type='date' name='fecha2' id='fecha2' required>";
                echo "</div>"; 
                echo "<div>";
                    echo "<label>Monto pagado</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' onkeyup='operaciones();' name='montoPagado' id='montoPagado' required>";
                echo "</div>";  
            echo "<div id='calculados' name='calculados' style='width:100%;'>";
                echo "<div>";
                    echo "<label>Monto acumulado</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='montoAcumulado' id='montoAcumulado' required>";
                echo "</div>";
                echo "<div>";
                    echo "<label>Saldo</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='saldo' id='saldo' required>";
                echo "</div>";
            echo "</div>";
            echo "<br>";
                echo "<label>Comentario</label>";
                echo "<input type='text'  placeholder='comentario' name='comentario' id='comentario' required>";
              
                echo "<div>";
                    echo "<input class='Mbtn btn-danger' type='submit' id='guardar' value='Guardar' >";
                echo "</div>";

            echo "</form>";
        echo "</div>";
    echo "</center>";
    

    //Aqui se dibuja la notificacion 
    echo '<div name="mensajeConfirmacion" id="mensajeConfirmacion"></div>'; 
    
    //Tabla de registros
    echo "<div id='tablaRegistros' style='display:inline-block;'>";
    $vuelta = 0;
    $sql = "SELECT * FROM mandantes_abonos WHERE idmandante = ".$idmandante." and idcolonia = ".$idcolonia." and idmunicipio = ".$idmunicipio." and cancelado=0 ORDER BY id DESC";
    $rc = $conexion -> query($sql);
    if ($rc->num_rows>0){
        echo "<br><br><br>";
        echo "<h1>Desglose de pagos a mandante:</h1>";
        echo "<center>";
        echo "<table id='registros' class='tabla' style='text-align: right; width:90%;'>";
        echo "<th align='center'>ID</th>";
        echo "<th align='center'>Periodo Pago</th>";
        echo "<th align='center'>Recuperación</th>";
        echo "<th align='center'>Gastos</th>";
        echo "<th align='center'>Gastos Esc</th>";
        echo "<th align='center'>Monto pagar</th>";
        echo "<th align='center'>Devols.</th>";
        echo "<th align='center'>Otros Desc.</th>";
        echo "<th align='center'>Amortización anticipo</th>";
        echo "<th align='center'>Monto pagado</th>";
        echo "<th align='center'>Monto Acumulado</th>";
        echo "<th align='center'>Saldo</th>";
        //echo "<th style='width:15%;'>N. de oficio</th>";
        echo "<th align='center'>Documentos</th>";
        echo "<th align='center'>Orden Pago</th>";
        echo "<th align='center'>maS</th>";
        echo "<th align='center'>Editar</th>";
        echo "<th align='center'>Eliminar</th>";
 
        while($r = $rc -> fetch_array()){
            $vuelta +=1;
            echo "<tr>";
            echo "<td align='center'>".$r['id']."</td>";
            echo "<td align='left'>";
            if($r['periodopago']==$r['periodopago2']){
                
                
                
                echo fechaesp($r['periodopago']);

            }else{
                //$fech = strtotime($r['periodopago']);
                //$fech2 = strtotime($r['periodopago2']);
                //echo date("M",$fech).'-'.date("y",$fech)." A ".date("M",$fech2).'-'.date("y",$fech2); 
                echo fechaesp($r['periodopago'])." A ".fechaesp($r['periodopago2']);
            } 
            echo "</td>";
            echo "<td>$".$r['recuperacion']."</td>";
            echo "<td>$".$r['gastos']."</td>";
            echo "<td>$".$r['gastosesc']."</td>";
            echo "<td>$".$r['montopagar']."</td>";
            echo "<td>$".$r['devols']."</td>";
            echo "<td>$".$r['otrosdesc']."</td>";
            echo "<td>$".$r['amortizacion_anticipo']."</td>";
            echo "<td>$".$r['monto_pagado']."</td>";
            echo "<td>$".$r['monto_acumulado']."</td>";
            echo "<td>$".$r['saldo']."</td>";
            echo "<td>";
            //onclick='seleccionarMODAL('subirAdjuntos1".$vuelta."')'
                //echo "<a href='#subirAdjuntos' rel='MyModal:open' onclick='pasarIdConsulta(".$r['id'].','.$idmandante.','.$idcolonia.','.$idmunicipio.")' title='Haga click aqui para subir archivos'>Adjuntos_".$r['id']."</a>";
                //echo '<a href="#subirAdjuntos" rel="modal:open" id="'.$r['id'].'" data-id="row.id" data-toggle="modal" data-target="#subirAdjuntos">Adjuntos_'.$r['id'].'</a>';
                echo "<a href='#subirAdjuntos1".$vuelta."' rel='MyModal:open'  title='Haga click aqui para subir archivos'>Adjuntos</a>";
                //echo '<a href="#subirAdjuntos" rel="modal:open" id="'.$r['id'].'" data-id="row.id" data-toggle="modal" data-target="#subirAdjuntos">Adjuntos_'.$r['id'].'</a>';
                echo "<div id='subirAdjuntos1".$vuelta."' class='MyModal'>";
                    echo "<div id='subirAdjuntos' >";
                        echo "<div>";
                            $adj = "SELECT idpago, ndocumento, nombre FROM documentos, mandantes_documentos WHERE mandantes_documentos.n_archivo=documentos.ndocumento and mandantes_documentos.idpago = ".$r['id']."";
                            //echo $adj;
                            $rc1 = $conexion -> query($adj);
                            if ($rc1->num_rows>0){
                                echo "<table class='tabla'>";
                                    echo "<th>Nombre de archivo</th>";
                                    while($r1 = $rc1 -> fetch_array()){
                                        echo "<tr>";
                                            echo "<td>";
                                            $archivo = "docs_mandantes/".$r1['idpago'].'_'.$r1['ndocumento'].'_'.$r1['nombre']; 
                                            $link = "<a id=".$r1['idpago']." name='$archivo' href='md_descargar.php?nombre=".$archivo."' target='_self' onclick =''  title='Haga click aqui para descargar'>".$r1['nombre']."</a>";
                                            echo $link;//archivo
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                echo "</table>";
                            }
                        echo "</div>";

                        echo "<form action='mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST' enctype='multipart/form-data'>";
                            echo "<label>Seleccione los archivos que se van a agregar como anexos</label>";
                            echo '<input type="hidden" name="comprobante" id="comprobante" value='.$r['id'].'>';
                            echo "<input type='hidden' name='idmandante2' id='idmandante2' value=".$idmandante.">";
                            echo "<input type='hidden' name='idcolonia2' id='idcolonia2' value=".$idcolonia.">";
                            echo "<input type='hidden' name='idmunicipio2' id='idmunicipio2' value=".$idmunicipio.">";
                            echo '<input id="archivo[]" name="archivo[]" type="file" accept=".pdf" multiple="" required>';
                            echo "<button type='submit' class='Mbtn btn-danger' title='Haga clic para subir el archivo'> Subir archivos </button>";
                        echo "</form>"; 

                        

                        echo "</div>";
                echo "</div>";
            echo "</td>";
            echo "<td>";
                MiToken_Init($nitavu, 'PAGO A MANDANTES-ORDEN DE PAGO'); // inicializamos seguridad del Token (no necesitamos saberlo)          
                echo '<form action="md_ordenpago.php?id='.$r['id'].'&idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'&fecha='.$r['periodopago'].'" method="POST">';
                    echo "<input type='hidden' class='url1' name='url1'>";
                    echo "<button  type='submit' title='Clic para ver la orden de pago'>";
                        echo '<img src="./icon/pdf.png" height="42" width="42">';
                    echo "</button>";	
                echo "</form>";
            echo "</td>";
            echo "<td align='center'>";
            echo '<a href="#masAbonos'.$r['id'].'" rel="MyModal:open"  title="Haga click aqui para subir archivos" ><img src="./icon/mas3.png" height="20" width="15">';
            echo "<div id='masAbonos".$r['id']."' class='MyModal' style='width:500px'>";    
                    echo "<div>";
                    echo '<form action="md_ingresa_abonoextra.php" method="POST">';
                    echo "<table style='border-collapse: separate;'>";
                    echo "<tr>";
                    
                        echo "<td>
                        <input name='nitavu1'  type='hidden' class='form-select'   id='nitavu1' value='".$nitavu."'  /> 
                      <input name='idabono'  type='hidden' class='form-select'   id='idabono' value='".$r['id']."'  />
                        <label style='font-size: 12; font-weight:bold;'>Signo</label><td>";
                        echo "<td><select id='mas_menos' name='mas_menos' class='form-select'  style='font-size: 12; '>";
                            echo "<option value='1'>Más(+)</option>";
                            echo "<option value='2'>Menos(-)</option>";
                        echo "</select></td>"; 
                        echo "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td><label style='font-size: 12; font-weight:bold;'>Concepto</label><td>";
                        echo "<td> <select name='idconcepto'  class='form-select'    id='idconcepto'  style='font-size: 12;'  >"; 
                        $sql = "SELECT * FROM cat_conceptos_mandabonos where Activo=1 ";
                   
                        $rr = $conexion -> query($sql);
                        while($f = $rr -> fetch_array())
                        { // resultado de la busqueda.................
                            echo "<option  style='font-size: 12;' value='".$f['Id']."'>".$f['Concepto']. "</option>";
                        }
                         echo "</select>";

                        echo "</td>";
                    echo "</tr>";                    
                    echo "<tr>";
                        echo "<td><label style='font-size: 12; font-weight:bold;'>Importe</label><td>";
                        echo "<td> <input name='importe'     id='importe'   style='font-size: 12;' /></td>";
                    echo "</tr>";

                    echo "<tr>";
                    
                    echo "<td colspan='2'>";
                    echo "<td colspan='2'><center><input class='Mbtn btn-danger' type='submit' id='guardar' value='Guardar' ></center></td>";
                    echo "</td>";
                echo "</tr>";
                    echo "</table >";
                    echo "</form>";
                    echo "</div>";
                echo "</div>";
                echo "</a>";

            echo "</td>";

            echo "<td align='center'>";
                echo '<a  href="md_modificarRegistro.php?id='.$r['id'].'&idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'"><img src="./icon/edit.png" height="20" width="15"></a>';
            echo "</td>";
            echo "<td align='center'>";
                echo '<a  href="mandantes_pago.php?ideliminar='.$r['id'].'&idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'"><img src="./icon/x.png" height="20" width="15"></a>';
            echo "</td>";
            
        }
        echo "</tr>";
        echo "</table>";
        echo "</center>";
        }
    echo "</div>";
 
            //SUBIR ANEXOS
    if(isset($_POST['comprobante'])){
        $id = $_POST['comprobante']; 
        $idmandante = $_POST['idmandante2']; 
        $idcolonia = $_POST['idcolonia2']; 
        $idmunicipio = $_POST['idmunicipio2']; 
        //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
        foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name){
            //Validamos que el archivo exista
            if($_FILES["archivo"]["name"][$key]){
            $doc = $_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo
            $tmp = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
            $num = ndocumento(TRUE);
            //$directorio = 'docs/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
            $archivo = "docs_mandantes/".$id.'_'.$num.'_'.$doc."";
            $subida = FTP_subir($tmp,$archivo);
            //$nombrearchivo = $num.'_'.$doc;
                if ($subida == "TRUE"){
                    documento_add($num, $doc, $nitavu,$id_aplicacion);
                    $sql = "INSERT INTO mandantes_documentos (idmunicipio, idcolonia, idmandante, n_archivo, idpago) VALUES  ('$idmunicipio','$idcolonia','$idmandante','$num', '$id')";
                    if ($conexion->query($sql) == TRUE){ 
                        ndocumento(FALSE);
                        historia($nitavu,'md_Subi un documento al mandante: '.$idmandante .' archivo: '.$doc);
                        mensaje('Se ha subido el archivo con éxito.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');  
                    }else{
                        historia($nitavu,'No se pudo guardar la informacion del archivo: '.$doc.' en la base de datos del mamdante: idmandante: '.$idmandnte.' idcolonia: '.$idcolonia.' idmunicipio:'.$idmunicipio.'');
                        mensaje('Hubo un error al momento de subir los archivos, por favor vuelva a intentarlo.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
                    }      
                }else{
                    historia($nitavu,'No se pudo guardar el documento en el servidor FTP, archivo: '.$doc.' del mamdante: idmandante: '.$idmandnte.' idcolonia: '.$idcolonia.' idmunicipio:'.$idmunicipio.'');                                                                                                                             
                    mensaje('Hubo un error al momento de subir el archivo, por favor vuelva a intentarlo.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
                }
            }
            
        }
        
        }
/*-------------------------------------------------------------------------------------------------------------------------*/
    }else{
        
       
         echo "<center><div>"; 
            echo "<a style='right: 0px; position: absolute; top: 50px;' href='md_lista.php' title='Clic para ver lista de mandantes' class='btn btn-link'>";
            echo "Lista Mandantes</a>";
            echo "<a style='right: 150px; position: absolute; top: 50px;' href='md_pagomandantes.php' title='Clic para crear el oficio de pago a mandantes' class='btn btn-link'>";
            echo "Pago Mandantes</a>";
        echo "</div></center>";


        echo '<br><br><br>';
        echo "<h3>Registar pago a mandantes</h3>";
        //echo "<form action='mandantes_pago.php' method='POST'>";
        echo '<div class="container" style="background:#E9ECED;">';
        echo "<center>";
        echo "<div>";
            echo "<label for='municipio'>Seleccione un municipio:";
            echo "<select id='municipio' name='municipio'>";
            echo "<option>Seleccione un municipio...</option>";
            $sql = "SELECT * FROM cat_municipios";
                $r = $conexion -> query($sql);
                while($f = $r -> fetch_array()){ // resultado de la busqueda.................
                    echo "<option value='".$f['IdMunicipio']."'>".$f['municipio']."</option>";
                    
                }
            
            echo "</select>";
            echo "</label>";
        echo "</div>";
        
        echo "<div name='colonia' id='colonia'></div>";
        
        echo "<div name='Mandantes' id='Mandantes'></div>";

        echo "<div name='Apoderado' id='Apoderado'></div>";
        echo "</center>";
        echo "</div>";

        //echo mostrarApoderadoMandante($idmunicipio, $idcolonia, $idmandante);
        
        //OPCIONES
        //BOTONES MENU
        echo "<br><br><br>";
        echo "<center>";
        echo "<div id='req_menu' style='display:none;'>"; 
            echo "<a href='#registroPago' rel='MyModal:open' class='Mbtn btn-danger' title='Clic para registar pago'>";
            
            echo "<table  width='100%'><tr><td valign='middle' align='center'>";
            echo "<img src='icon/pago.png' style='width:30px; height:30px;'>";
            echo "</td>";
            echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
            echo "Registar Pago";
            echo "</td></tr></table>";
            
            echo "</a>";	
                //target="_blank"
            MiToken_Init($nitavu, 'PAGO A MANDANTES-ORDEN DE PAGO'); // inicializamos seguridad del Token (no necesitamos saberlo)
            /*echo '<a id="reporteMandante" href="md_reporte.php"  class="Mbtn btn-danger"  title="Clic para ver el reporte">';
            echo "<table  width='100%'><tr><td valign='middle' align='center'>";
            echo "<img src='icon/pdf.png' style='width:30px; height:30px;'>";
            echo "</td>";
            echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
            echo "Crear Reporte";
            echo "</td></tr></table>";
            echo "</a>";*/

            //echo '<a id="reporteMandante" href="md_reporte.php?id='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'" class="Mbtn btn-danger" onclick="ObtenerURL();" title="Clic para ver el reporte">';
           echo "<a style='vertical-align: text-bottom;'>";
            echo "<form id='reporteMandante' action='md_reporte.php' method='POST'>";
           //href="md_reporte.php"
           echo '<button type="submit"  class="Mbtn btn-danger"  title="Clic para ver el reporte">';
           echo "<input type='hidden' id='url' name='url'>";
            echo "<table  width='100%'><tr><td valign='middle' align='center'>";
            echo "<img src='icon/pdf.png' style='width:30px; height:30px;'>";
            echo "</td>";
            echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
            
            echo "Crear Reporte";
            echo "</td></tr></table></button>";
            echo "</form>";
            echo "</a>";
            
            echo "<a id='nuevoCargo' href='md_nuevoCargo.php' class='Mbtn btn-danger' title='Clic para registrar cargo'>";
         
            echo "<table  width='100%'><tr><td valign='middle' align='center'>";
            echo "<img src='icon/cargo.png' style='width:30px; height:30px;'>";
            echo "</td>";
            echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
            echo "Registrar Cargo";
            echo "</td></tr></table>";
            
            echo "</a>";

            echo "<a id='mddocumentos' href='md_documentos.php' class='Mbtn btn-danger' title='Clic para agregar documentos al mandante'>";
            
            echo "<table  width='100%'><tr><td valign='middle' align='center'>";
            echo "<img src='icon/folio.png' style='width:30px; height:30px;'>";
            echo "</td>";
            echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
            echo "Documentos";
            echo "</td></tr></table>";
            
            echo "</a>";

            //SOLO INFORMATICA VA A TENER ACCESO A ESTE BOTÓN, ES PARA CORREGIR CUENTAS 
            //if (pertenecesaInformatica($nitavu) == true){
                echo "<a id='recalculo' onclick='recalcular()' class='Mbtn btn-danger' title='Clic para recaulcular los saldos del mandante'>";
                
                echo "<table  width='100%'><tr><td valign='middle' align='center'>";
                echo "<img src='icon/recalcular.png' style='width:20px; height:30px;'>";
                echo "</td>";
                echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
                echo "Recalcular Saldos";
                echo "</td></tr></table>";
                
                echo "</a>";
            //}

        echo "</div>";
        echo "</center>";

        echo '<div name="respuesta" id="respuesta"></div>'; 

           //Ingresar datos
        echo "<center>";
        echo "<div id='registroPago' class='MyModal' style='width:70%; display:none;'>";
            echo "<h1>Ingresa los datos que se solicitan</h1>";
            
            $sql4 = "SELECT * FROM cat_mov_mandante";
            $r4 = $conexion -> query($sql4);
            
            echo "<center><div style='width:100%'>";
            echo "<label for='tipo_mov'>Seleccione un tipo de pago:";
                echo "<select id='tipo_mov' name='tipo_mov' onchange='seleccionarQueDivMostrar()'>";
                    echo "<option>Seleccione una opcion...</option>";
                    while($f4 = $r4 -> fetch_array()){ // resultado de la busqueda.................
                        
                        echo "<option value='".$f4['id']."'>".$f4['nombre']."</option>";
                        
                    }
                
                echo "</select>";
            echo "</label>"; 
            echo "</div></center>";

            echo "<input type='hidden' name='idmandante' id='idmandante' readonly>";
            echo "<input type='hidden' name='idcolonia' id='idcolonia' readonly>";
            echo "<input type='hidden' name='idmunicipio' id='idmunicipio' readonly>";
             echo "<input type='hidden' name='nitavu' id='nitavu' value='".$nitavu."' readonly>";       
           echo "<form name='formulario' id='formulario' style='display:none' action=''  onSubmit='enviarDatos(); return false'>";
           //  echo '<form name="formulario" onSubmit="enviarDatos();" >';
                echo '<label><input type="checkbox" id="peri2" name="peri2" value="periodo2" onClick="mostrarFecha2()">Periodo</label>';
                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                        echo "<label>Fecha 1</label>";
                        echo "<input type='date' name='fecha' id='fecha' required>";
                        echo "</td>";
                        echo "<td id='fech2' style='display:none;'>";
                        echo "<label>Fecha 2</label>";
                        echo "<input type='date' name='periodo2' id='periodo2'>";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                echo "<div>";
                    echo "<label>Recuperación</label>";
                    
                    echo "<input type='number' step='any' placeholder='$0.00' onkeyup='todas();' name='recuperacion' id='recuperacion' required>";
                echo "</div>";


                echo "<div>";
                echo "<table style='width:100%;'>";
                    echo "<td>";
                        echo "<label style='text-align:center;'>%</label>";
                        echo "<input type='number' step='any' placeholder='%' onkeyup='calcularAmortizacion();' name='pamorAnt' id='pamorAnt' required>";
                    echo "</td>";
                    echo "<td>";
                        echo "<label>Amortización de anticipo</label>";
                        echo "<input type='number' step='any' placeholder='$0.00' name='amorAnticipo' id='amorAnticipo' required>";
                    echo "</td>";
                echo "</table>";
            echo "</div>";    


                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>%</label>";
                            echo "<input type='number' step='any' placeholder='%' name='pgastos' id='pgastos'   required>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label>Gastos de admon.</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='gastos' id='gastos' required>";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>%</label>";
                            echo "<input type='number' step='any' placeholder='%' name='pgastosesc' id='pgastosesc' value='' required>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label>Gastos de escrituracion</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='gastosesc' id='gastosesc' required>";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                echo "<div>";
                    echo "<label>Monto por pagar</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='montopagar' id='montopagar' required>";
                echo "</div>";
                echo "<div>";
                    /*echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>%</label>";
                            echo "<input type='number' step='any' placeholder='%' onkeypress='calcularDevoluciones();' name='pdevols' id='pdevols' required>";
                        echo "</td>";
                        echo "<td>";*/
                            echo "<label>Devoluciones</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='devols' id='devols' onkeyup='calcularDevoluciones();'  value='0'>";
                        /*echo "</td>";
                    echo "</table>";*/
                echo "</div>";
                
                echo "<div>";            
                    echo "<label>Otros Descuentos</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='otrosdesc' id='otrosdesc'  value='0'  onkeyup='calcularDevoluciones();'>";
                 echo "</div>";
                          

                echo "<div>";
                    echo "<label>Monto pagado</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' onkeyup='operaciones();' name='montoPagado' id='montoPagado' required>";
                echo "</div>";
            echo "<div id='calculados' name='calculados'>";
                echo "<div>";
                    echo "<label>Monto acumulado</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='montoAcumulado' id='montoAcumulado' required>";
                echo "</div>";
                echo "<div>";
                    echo "<label>Saldo</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='saldo' id='saldo' required>";
                echo "</div>";
            echo "</div>";
                echo "<div>";
                    echo "<label>Recuperación emitida por el sistema</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='sistema' id='sistema' >";
                echo "</div>";


                /*echo "<div>";
                    echo "<label>Enganche ahorro por identificar y traspasar</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='engancheTraspaso' id='engancheTraspaso'>";
                echo "</div>";*/

                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos2' name='mas_menos2'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Enganche ahorro por identificar y traspasar</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='engancheAhorro' id='engancheAhorro' >";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";

               echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos1' name='mas_menos1'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>Descuento por nómina</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='desNomina' id='desNomina' >";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                
                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos3' name='mas_menos3'>";
                               echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Por transferencia</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='transferencia' id='transferencia' >";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
              echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos4' name='mas_menos4'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Por pagos universales</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='pagosUniversales' id='pagosUniversales' >";
                        echo "</td>";
                    echo "</table>";
                
                echo "</div>";
                echo "<div>";

                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos5' name='mas_menos5'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Por concepto de escritura</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='escritura' id='escritura' >";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos6' name='mas_menos6'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Por cesión de derechos</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='derechos' id='derechos'>";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos7' name='mas_menos7'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Por pago de derechos</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='pagoDerechos' id='pagoDerechos'>";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                echo "<div>";
                    echo "<table style='width:100%;'>";
                        echo "<td>";
                            echo "<label style='text-align:center;'>(+/-)</label>";
                            echo "<select id='mas_menos8' name='mas_menos8'>";
                                echo "<option value='1'>más</option>";
                                echo "<option value='2'>menos</option>";
                            echo "</select>";
                        echo "</td>";
                        echo "<td>";
                            echo "<label  style='text-align:center;'>Por pago en oxxo</label>";
                            echo "<input type='number' step='any' placeholder='$0.00' name='pagooxxo' id='pagooxxo'>";
                        echo "</td>";
                    echo "</table>";
                echo "</div>";
                echo "<div>";
                echo "<table style='width:100%;'>";
                    echo "<td>";
                        echo "<label style='text-align:center;'>(+/-)</label>";
                        echo "<select id='mas_menos9' name='mas_menos9'>";
                            echo "<option value='1'>más</option>";
                            echo "<option value='2'>menos</option>";
                        echo "</select>";
                    echo "</td>";
                    echo "<td>";
                        echo "<label  style='text-align:center;'>Otros Pagos</label>";
                        echo "<input type='number' step='any' placeholder='$0.00' name='pagootros' id='pagootros'>";
                    echo "</td>";
                echo "</table>";
            echo "</div>";
                /*echo "<div>";
                    echo "<label>Ajuste al centavo</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='centavo' id='centavo' required>";
                echo "</div>";*/
                //echo "<div>";
                echo "<div>";
                    //echo "<table>";
                     //   echo "<td>";
                            echo "<label>Comentario</label>";
                            echo "<input type='text'  placeholder='comentario' name='comentario' id='comentario' required>";
                       // echo "</td>";
                        //echo "<td>";
                echo "</div>";
                echo "<div>";
                            echo "<label>Observacion para Pago</label>";
                            echo "<input type='text'  placeholder='Observación para el pago' name='observacionPago' id='observacionPago'>";
                        //echo "</td>";
                    //echo "</table>";
            echo "</div>"; 
            echo "<div>";
            echo "<label>Datos Bancarios</label>";
            echo "<input type='text'  placeholder='Datos bancarios' name='datosBancarios' id='datosBancarios'>";
             echo "</div>"; 
                //echo "</div>";
                echo "<div>";
                    echo "<input class='Mbtn btn-danger' type='submit' id='guardar' value='Guardar' >";
                echo "</div>";
                
            echo "</form>";


            echo "<form name='formulario1' id='formulario1' style='display:none; width:100%;' action=''  onSubmit='enviarDatos2(); return false'>";
           //  echo '<form name="formulario" onSubmit="enviarDatos();" >';
                echo "<div>";
                    echo "<label>Fecha de pago</label>";
                    echo "<input type='date' name='fecha2' id='fecha2' required>";
                echo "</div>"; 
                echo "<div>";
                    echo "<label>Monto pagado</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' onkeyup='operaciones(2);' name='montoPagado2' id='montoPagado2' required>";
                echo "</div>"; 
            echo "<div id='calculados2' name='calculados2' style='width:100%;'>";
                echo "<div>";
                    echo "<label>Monto acumulado</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='montoAcumulado2' id='montoAcumulado2' required>";
                echo "</div>";
                echo "<div>";
                    echo "<label>Saldo</label>";
                    echo "<input type='number' step='any' placeholder='$0.00' name='saldo2' id='saldo2' required>";
                echo "</div>";
            echo "</div>";

            echo "<div id='calculados2' name='calculados2' style='width:100%;'>";
            echo "<div>";
                 echo "<label>Comentario</label>";
                 echo "<input type='text'  placeholder='comentario' name='comentario' id='comentario' required>";
                
            echo "</div>";
            echo "<div>";
                echo "<label>Datos Bancarios</label>";
                 echo "<input type='text'  placeholder='Datos bancarios' name='datosBancarios1' id='datosBancarios1'>";
            echo "</div>";
        echo "</div>";
           


                echo "<div>";
                    echo "<input class='Mbtn btn-danger' type='submit' id='guardar' value='Guardar' >";
                echo "</div>";

            echo "</form>";
        echo "</div>";
    echo "</center>";


    //Aqui se dibuja la notificacion 
    echo '<div name="mensajeConfirmacion" id="mensajeConfirmacion"></div>'; 
    
    //Tabla de registros
    echo "<div id='tablaRegistros' style='display:none;'></div>";
  

    }

   

}
else{
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}

?>
<script>
function mostrarFecha2(){
    if (peri2.checked == true){
        $("#fech2").css({'display':'inline-block',});
    }else{
        $("#fech2").css({'display':'none',});
    }

}

function mostrarDecimales(){    
    this.value = parseFloat(this.value.replace(/,/g, ""))
                    .toFixed(2)
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    
    document.getElementById("display").value = this.value.replace(/,/g, "")
    
}

function operaciones(){
    //alert('entro');
    var idmunicipio = $("#municipio option:selected").val();
    var idmandante =  $("#mandantes option:selected").val();
    var idcolonia =  $("#colonia option:selected").val();
    
    var pago = document.getElementById("montoPagado").value;
    pago = $('#montopagar').val() - $('#devols').val()-$('#gastos').val()-$('#gastosesc').val()-$("#otrosdesc").val();


   // pago = pago - $('#amorAnticipo').val();
    
    $('#montoPagado').val(pago);

    $.ajax({
       url: "md_operaciones.php",
      type: "post",
      data: {idmandante:idmandante, idcolonia:idcolonia, idmunicipio:idmunicipio, pago:pago},
      success: function(data){
         // console.log(data);
          //if(num==2){
            //$('#calculados2').html(data+"\n");
          //}else{
            $('#calculados').html(data+"\n");
          //}
       
     
       //montoAcumulado
       //saldo
      }
   });
}

function todas(){
  
    calcularAmortizacion();
     
    calcularMontoPorPagar()
    buscarGastosEsc();
    calcularGastosEsc();
    buscarGastosAdmin();
    calcularGastosAdmin();
    calcularDevoluciones();
}
function buscarGastosAdmin(){
   // alert('entro');
    var idmunicipio = $("#municipio option:selected").val();
    var idmandante =  $("#mandantes option:selected").val();
    var idcolonia =  $("#colonia option:selected").val();

    $.ajax({
       url: "md_gastosAdmin.php",
      type: "post",
      data: {idmandante:idmandante, idcolonia:idcolonia, idmunicipio:idmunicipio},
      success: function(data){
        //  console.log(data);
          $('#pgastos').val(data);
      }
   });

}

function buscarGastosEsc(){
   // alert('entro');
    var idmunicipio = $("#municipio option:selected").val();
    var idmandante =  $("#mandantes option:selected").val();
    var idcolonia =  $("#colonia option:selected").val();

    $.ajax({
       url: "md_gastosEsc.php",
      type: "post",
      data: {idmandante:idmandante, idcolonia:idcolonia, idmunicipio:idmunicipio},
      success: function(data){
          //console.log(data);
          $('#pgastosesc').val(data);
      }
   });

}
function buscarAmortizacionAnt(){
   // alert('entro');
    var idmunicipio = $("#municipio option:selected").val();
    var idmandante =  $("#mandantes option:selected").val();
    var idcolonia =  $("#colonia option:selected").val();

    $.ajax({
       url: "md_amortizacionAnt.php",
      type: "post",
      data: {idmandante:idmandante, idcolonia:idcolonia, idmunicipio:idmunicipio},
      success: function(data){
         // console.log(data);
          $('#pamorAnt').val(data);
      }
   });

}
function calcularGastosAdmin(){
    
   // var pago = $('#recuperacion').val();//antes
    var pago = $('#montopagar').val();
    var porcentaje = $('#pgastos').val();
    var res = (pago * porcentaje) / 100;
    res = Math.round(res)
    $('#gastos').val(res);
    //calcularMontoPorPagar();
}

function calcularGastosEsc(){
    
    ///var pago = $('#recuperacion').val();
    
    var pago = $('#montopagar').val();
    //console.log(pago);
    var porcentaje = $('#pgastosesc').val();
    var res = (pago * porcentaje) / 100;
    res = Math.round(res)
    $('#gastosesc').val(res);
   // calcularMontoPorPagar();
}
function calcularMontoPorPagar(){
    
    var pago = $('#recuperacion').val();
     //var gastos = $('#gastos').val();
     var amor_ant = $('#amorAnticipo').val();
    //antes
    //var pago = $('#recuperacion').val();
    // var gastos = $('#gastos').val();
    // var gastos = $('#gastosesc').val();
    var res = pago - amor_ant;
    $('#montopagar').val(res);
    
}

function calcularDevoluciones(){
    //var pago = $('#montopagar').val();
   // var porcentaje = $('#pdevols').val(); 
   // var res = (pago * porcentaje) / 100;
   // $('#devols').val(res);
    operaciones();
}

function calcularAmortizacion(){
   // var pago = $('#montopagar').val(); 
  var pago = $('#recuperacion').val();
  var porcentaje = $('#pamorAnt').val(); 
  var res = (pago * porcentaje) / 100;
  res = Math.round(res)
    //console.log(porcentaje);
   // console.log(res);
    $('#amorAnticipo').val(res);
    //operaciones();

}

$(document).ready(function() {
   // debugger;
    var URLactual = window.location;    
    document.getElementById('url').value = URLactual;
    $('.url1').val(URLactual);
});






</script>
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