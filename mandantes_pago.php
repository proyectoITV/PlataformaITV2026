<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>
<link rel="stylesheet" href="lib/laura.css" />
<link rel="stylesheet" href="lib/plataforma_modern.css" />
<?php
require("config.php");
$id_aplicacion = 'ap70';
xd_update('ap70',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
echo "<input type='hidden' id='nitavu' name='nitavu' value='".$nitavu."'>";

if (sanpedro($id_aplicacion, $nitavu) == TRUE){
    
    historia($nitavu, 'Entre al módulo de pago a mandantes');
    
    // Procesamiento de formularios y acciones cuando hay parámetros GET de selección
    if(isset($_GET['idmandante']) and isset($_GET['idcolonia']) and isset($_GET['idmunicipio'])  ){
        $idmandante = $_GET['idmandante'];
        $idcolonia = $_GET['idcolonia'];
        $idmunicipio = $_GET['idmunicipio'];

        // EDITAR UN CARGO 
        if(isset($_POST['fechaMan']) and isset($_POST['superficie']) and isset($_POST['costoLotes']) and isset($_POST['editar'])){
            $id = $_POST['id'];
            $fechaman = $_POST['fechaMan'];
            $fechaAdendum = "";
            $fechaAdendumFiniquito = "";
            $plazoCredito = $_POST['plazoCredito'];
            $costoLotes = $_POST['costoLotes'];
            $LoteM2 = $_POST['LoteM2'];
            $superficie = $_POST['superficie'];
            $supComercializar = $_POST['supComercializar'];
            $porMan = $_POST['porMan'];
            $porItavu = $_POST['porItavu'];
            $monpagar = $_POST['monpagar'];
            $porEsc = $_POST['porEsc'];
            $monpagarComer = $_POST['monpagarComer'];

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
            $porAmorAnt = $_POST['porAmorAnt'];

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
            $fechaAdendum = $_POST['fechaAdendum'];
            $fechaAdendumFiniquito = $_POST['fechaAdendumFiniquito'];
            $plazoCredito = $_POST['plazoCredito'];
            $costoLotes = $_POST['costoLotes'];
            $LoteM2 = $_POST['LoteM2'];
            $superficie = $_POST['superficie'];
            $supComercializar = $_POST['supComercializar'];
            $porMan = $_POST['porMan'];
            $porItavu = $_POST['porItavu'];
            $porEsc = $_POST['porEsc'];
            $monpagar = $_POST['monpagar'];
            $monpagarComer = $_POST['monpagarComer'];
            
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
            $porAmorAnt = $_POST['porAmorAnt'];

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

        // AGREGAR UN CARGO NUEVO 
        if(isset($_POST['fechaMan']) and isset($_POST['superficie']) and isset($_POST['costoLotes']) and isset($_POST['guardar'])){
            $fechaman = $_POST['fechaMan'];
            $fechaAdendum = "";
            $fechaAdendumFiniquito = "";
            $plazoCredito = $_POST['plazoCredito'];
            $costoLotes = $_POST['costoLotes'];
            $LoteM2 = $_POST['LoteM2'];
            $superficie = $_POST['superficie'];
            $supComercializar = $_POST['supComercializar'];
            $porMan = $_POST['porMan'];
            $porItavu = $_POST['porItavu'];
            $monpagar = $_POST['monpagar'];
            $monpagarComer = $_POST['monpagarComer'];

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
            $porAmorAnt = $_POST['porAmorAnt'];

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
            $fechaAdendum = $_POST['fechaAdendum'];
            $fechaAdendumFiniquito = $_POST['fechaAdendumFiniquito'];
            $plazoCredito = $_POST['plazoCredito'];
            $costoLotes = $_POST['costoLotes'];
            $LoteM2 = $_POST['LoteM2'];
            $superficie = $_POST['superficie'];
            $supComercializar = $_POST['supComercializar'];
            $porMan = $_POST['porMan'];
            $porItavu = $_POST['porItavu'];
            $monpagar = $_POST['monpagar'];
            $monpagarComer = $_POST['monpagarComer'];

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
            $porAmorAnt = $_POST['porAmorAnt'];
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

        // GUARDAR EN LA BD LOS DATOS MODIFICADOS DE UN PAGO
        if(isset($_GET['idpago'])){
            $id = $_GET['idpago'];

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
                    $fecha2 = $fecha1; 
                }
                $recu = $_POST['recuperacion'];
                $pgastos = $_POST['pgastos'];
                $gastos = $_POST['gastos'];
                $montopagar= $_POST['montopagar'];
                $pdevols = 0;
                $devols = $_POST['devols'];
                $otrosdesc = $_POST['otrosdesc'];
                $pamorAnt = $_POST['pamorAnt'];
                $amorAnticipo = $_POST['amorAnticipo'];
                $montoPagado = $_POST['montoPagado'];
                $montoAcumulado = $_POST['montoAcumulado'];
                $saldo = $_POST['saldo'];
                $sistema = $_POST['sistema'];
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
         
        // ELIMINAR UN REGISTRO 
        if(isset($_GET['ideliminar']))
        {
            $id = $_GET['ideliminar'];
            $res = eliminarRegistroPago($id,$nitavu);
            if($res == TRUE){
                historia($nitavu, 'Elimine el pago, idpago: '.$id.'');
                mensaje('Se ha eliminado con éxito el pago.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }else{
                historia($nitavu, 'Ocurrio un error al momento de eliminar el pago, idpago: '.$id.'');
                mensaje('Ocurrio un problema al momento de eliminar el pago, favor de volver a intentarlo.','mandantes_pago.php?idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'');
            }
        }

        // SUBIR ANEXOS
        if(isset($_POST['comprobante'])){
            $id = $_POST['comprobante']; 
            $idmandante_post = $_POST['idmandante2']; 
            $idcolonia_post = $_POST['idcolonia2']; 
            $idmunicipio_post = $_POST['idmunicipio2']; 
            foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name){
                if($_FILES["archivo"]["name"][$key]){
                    $doc = $_FILES["archivo"]["name"][$key];
                    $tmp = $_FILES["archivo"]["tmp_name"][$key];
                    $num = ndocumento(TRUE);
                    $archivo = "docs_mandantes/".$id.'_'.$num.'_'.$doc."";
                    $subida = FTP_subir($tmp,$archivo);
                    if ($subida == "TRUE"){
                        documento_add($num, $doc, $nitavu,$id_aplicacion);
                        $sql = "INSERT INTO mandantes_documentos (idmunicipio, idcolonia, idmandante, n_archivo, idpago) VALUES ('$idmunicipio_post','$idcolonia_post','$idmandante_post','$num', '$id')";
                        if ($conexion->query($sql) == TRUE){ 
                            ndocumento(FALSE);
                            historia($nitavu,'md_Subi un documento al mandante: '.$idmandante_post .' archivo: '.$doc);
                            mensaje('Se ha subido el archivo con éxito.','mandantes_pago.php?idmandante='.$idmandante_post.'&idcolonia='.$idcolonia_post.'&idmunicipio='.$idmunicipio_post.'');  
                        }else{
                            historia($nitavu,'No se pudo guardar la informacion del archivo: '.$doc.' en la base de datos del mandante');
                            mensaje('Hubo un error al momento de subir los archivos, por favor vuelva a intentarlo.','mandantes_pago.php?idmandante='.$idmandante_post.'&idcolonia='.$idcolonia_post.'&idmunicipio='.$idmunicipio_post.'');
                        }      
                    }else{
                        historia($nitavu,'No se pudo guardar el documento en el servidor FTP, archivo: '.$doc);
                        mensaje('Hubo un error al momento de subir el archivo, por favor vuelva a intentarlo.','mandantes_pago.php?idmandante='.$idmandante_post.'&idcolonia='.$idcolonia_post.'&idmunicipio='.$idmunicipio_post.'');
                    }
                }
            }
        }
    }
?>

<div class="cd-wrapper">
    <!-- Hero Banner institucional -->
    <div class="cd-hero">
        <div>
            <h1 class="cd-hero-title">
                <i class="fa-solid fa-hand-holding-dollar"></i> Control y Registro de Pago a Mandantes
            </h1>
            <div class="cd-hero-dept">
                <i class="fa-solid fa-building-columns"></i> Módulo Financiero ITAVU 2026
            </div>
        </div>
        <div class="cd-top-links">
            <a href="md_lista.php" class="cd-top-link-btn" title="Ver lista general de mandantes">
                <i class="fa-solid fa-list-check"></i> Lista Mandantes
            </a>
            <a href="md_pagomandantes.php" class="cd-top-link-btn" title="Oficio de pago a mandantes">
                <i class="fa-solid fa-file-signature"></i> Pago Mandantes
            </a>
        </div>
    </div>

    <!-- Card de Selección de Mandante / Filtros -->
    <div class="cd-card-section" style="margin-bottom: 20px;">
        <div class="cd-card-header cd-card-header-gold">
            <h3 class="cd-card-title">
                <i class="fa-solid fa-filter"></i> Selección de Mandante y Ubicación
            </h3>
        </div>
        <div class="cd-card-body">
            <div class="cd-form-grid-3">
                <div class="cd-form-group">
                    <label for="municipio" class="cd-form-label"><i class="fa-solid fa-city" style="color:var(--cd-primary);"></i> Seleccione un municipio:</label>
                    <select id="municipio" name="municipio" class="cd-form-control">
                        <option value="">Seleccione un municipio...</option>
                        <?php
                        $sql_mun = "SELECT * FROM cat_municipios ORDER BY municipio ASC";
                        $r_mun = $conexion->query($sql_mun);
                        while($f_mun = $r_mun->fetch_array()){
                            $selected = (isset($idmunicipio) && $idmunicipio == $f_mun['IdMunicipio']) ? 'selected' : '';
                            echo "<option value='".$f_mun['IdMunicipio']."' ".$selected.">".htmlspecialchars($f_mun['municipio'])."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="cd-form-group" id="colonia">
                    <?php if(isset($idcolonia) && isset($idmunicipio)): ?>
                        <label for="colonia_select" class="cd-form-label"><i class="fa-solid fa-map-location-dot" style="color:var(--cd-gold-dark);"></i> Seleccione una colonia:</label>
                        <select id="colonia_select" name="colonia" class="cd-form-control" onchange="mostrarMandantes()">
                            <?php
                            $sql_col = "SELECT * FROM cat_colonias WHERE IdMunicipio = ".$idmunicipio." ORDER BY colonia ASC";
                            $r_col = $conexion->query($sql_col);
                            while($f_col = $r_col->fetch_array()){
                                $sel = ($idcolonia == $f_col['idcolonia']) ? 'selected' : '';
                                echo "<option value='".$f_col['idcolonia']."' ".$sel.">".htmlspecialchars($f_col['colonia'])."</option>";
                            }
                            ?>
                        </select>
                    <?php endif; ?>
                </div>

                <div class="cd-form-group" id="Mandantes">
                    <?php if(isset($idmandante) && isset($idcolonia) && isset($idmunicipio)): ?>
                        <label for="mandantes" class="cd-form-label"><i class="fa-solid fa-user-tie" style="color:var(--cd-primary);"></i> Seleccione un mandante:</label>
                        <select id="mandantes" name="mandantes" class="cd-form-control" onchange="mostrarApoderado()">
                            <?php
                            $sql_man = "SELECT * FROM cat_mandantes WHERE IdColonia = ".$idcolonia." and IdMunicipio=".$idmunicipio." and Cancelado = 0 ORDER BY Mandante ASC";
                            $r_man = $conexion->query($sql_man);
                            while($f_man = $r_man->fetch_array()){
                                $sel = ($idmandante == $f_man['IdMandante']) ? 'selected' : '';
                                echo "<option value='".$f_man['IdMandante']."' ".$sel.">".htmlspecialchars($f_man['Propietarios'])."</option>";
                            }
                            ?>
                        </select>
                    <?php endif; ?>
                </div>
            </div>

            <div class="cd-form-grid" style="margin-top: 10px;">
                <div class="cd-form-group" id="Apoderado">
                    <?php if(isset($idmandante) && isset($idcolonia) && isset($idmunicipio)): ?>
                        <label for="apoderado_select" class="cd-form-label"><i class="fa-solid fa-user-shield" style="color:var(--cd-gold-dark);"></i> Seleccione un apoderado:</label>
                        <select id="mandantes" name="mandantes" class="cd-form-control" onchange="mostrarOpciones()">
                            <option value="">Seleccione un apoderado...</option>
                            <?php
                            $sql_apo = "SELECT RepresentanteLegal, IdMandante FROM cat_mandantes WHERE IdColonia = ".$idcolonia." and IdMunicipio=".$idmunicipio." and IdMandante=".$idmandante." and Cancelado = 0 ORDER BY Mandante ASC";
                            $r_apo = $conexion->query($sql_apo);
                            while($f_apo = $r_apo->fetch_array()){
                                echo "<option value='".$f_apo['IdMandante']."' selected>".htmlspecialchars($f_apo['RepresentanteLegal'])."</option>";
                            }
                            ?>
                        </select>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar de Acciones Principales -->
    <?php 
    $toolbar_display = (isset($idmandante) && isset($idcolonia) && isset($idmunicipio)) ? 'display:flex;' : 'display:none;';
    ?>
    <div class="cd-toolbar-card" id="req_menu" style="<?php echo $toolbar_display; ?>">
        <div class="cd-toolbar-group">
            <a href="#registroPago" rel="MyModal:open" class="cd-btn cd-btn-primary" title="Clic para registrar un nuevo pago">
                <i class="fa-solid fa-circle-plus"></i> Registrar Pago
            </a>
            
            <?php MiToken_Init($nitavu, 'PAGO A MANDANTES-ORDEN DE PAGO'); ?>
            <form id="reporteMandante" action="<?php echo isset($idmandante) ? 'md_reporte.php?id='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio : 'md_reporte.php'; ?>" method="POST" style="margin:0; display:inline-block;">
                <input type="hidden" id="url" name="url">
                <button type="submit" class="cd-btn cd-btn-gold" title="Clic para ver el reporte en PDF">
                    <i class="fa-solid fa-file-pdf"></i> Crear Reporte
                </button>
            </form>

            <a id="nuevoCargo" href="<?php echo isset($idmandante) ? 'md_nuevoCargo.php?id='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio : 'md_nuevoCargo.php'; ?>" class="cd-btn cd-btn-dark" title="Clic para capturar un cargo">
                <i class="fa-solid fa-file-invoice-dollar"></i> Registrar Cargo
            </a>

            <a id="mddocumentos" href="<?php echo isset($idmandante) ? 'md_documentos.php?id='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio : 'md_documentos.php'; ?>" class="cd-btn cd-btn-outline-gold" title="Clic para agregar documentos al mandante">
                <i class="fa-solid fa-folder-open"></i> Documentos
            </a>
        </div>

        <div class="cd-toolbar-group">
            <button type="button" id="recalculo" onclick="recalcular()" class="cd-btn cd-btn-light" title="Clic para recalcular los saldos del mandante">
                <i class="fa-solid fa-calculator"></i> Recalcular Saldos
            </button>
        </div>
    </div>

    <!-- Contenedor de Alertas y Notificaciones -->
    <div id="respuesta" style="margin-top:10px;"></div>
    <div id="mensajeConfirmacion" style="margin-top:10px;"></div>

    <!-- MODAL PRINCIPAL: REGISTRAR PAGO -->
    <div id="registroPago" class="MyModal">
        <h3><i class="fa-solid fa-cash-register"></i> Registrar Pago a Mandante</h3>
        
        <div class="cd-form-group full-width" style="margin-bottom:18px;">
            <label for="tipo_mov" class="cd-form-label"><i class="fa-solid fa-list-check" style="color:var(--cd-primary);"></i> Seleccione Tipo de Pago:</label>
            <select id="tipo_mov" name="tipo_mov" class="cd-form-control" onchange="seleccionarQueDivMostrar()">
                <option value="">Seleccione una opción...</option>
                <?php
                $sql4 = "SELECT * FROM cat_mov_mandante ORDER BY id ASC";
                $r4 = $conexion->query($sql4);
                while($f4 = $r4->fetch_array()){
                    echo "<option value='".$f4['id']."'>".htmlspecialchars($f4['nombre'])."</option>";
                }
                ?>
            </select>
        </div>

        <input type="hidden" name="idmandante" id="idmandante" value="<?php echo isset($idmandante) ? $idmandante : ''; ?>" readonly>
        <input type="hidden" name="idcolonia" id="idcolonia" value="<?php echo isset($idcolonia) ? $idcolonia : ''; ?>" readonly>
        <input type="hidden" name="idmunicipio" id="idmunicipio" value="<?php echo isset($idmunicipio) ? $idmunicipio : ''; ?>" readonly>
        <input type="hidden" name="nitavu" id="nitavu" value="<?php echo $nitavu; ?>" readonly>

        <!-- FORMULARIO 1: ABONO PRINCIPAL (TIPO 3) -->
        <form name="formulario" id="formulario" style="display:none;" action="" onSubmit="enviarDatos(); return false;">
            <div class="cd-card-section" style="padding:15px; margin-bottom:15px;">
                <div style="margin-bottom:10px;">
                    <label class="cd-form-label" style="font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="peri2" name="peri2" value="periodo2" onClick="mostrarFecha2()"> Habilitar Rango de Fechas (Periodo)
                    </label>
                </div>
                <div class="cd-form-grid">
                    <div class="cd-form-group">
                        <label class="cd-form-label"><i class="fa-regular fa-calendar"></i> Fecha Inicio / Pago</label>
                        <input type="date" name="fecha" id="fecha" class="cd-form-control" required>
                    </div>
                    <div class="cd-form-group" id="fech2" style="display:none;">
                        <label class="cd-form-label"><i class="fa-regular fa-calendar-check"></i> Fecha Término</label>
                        <input type="date" name="periodo2" id="periodo2" class="cd-form-control">
                    </div>
                </div>
            </div>

            <div class="cd-form-grid-3">
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-dollar-sign"></i> Recuperación</label>
                    <input type="number" step="any" placeholder="$0.00" onkeyup="todas();" name="recuperacion" id="recuperacion" class="cd-form-control" required>
                </div>
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Amort. Anticipo</label>
                    <input type="number" step="any" placeholder="%" onkeyup="calcularAmortizacion();" name="pamorAnt" id="pamorAnt" class="cd-form-control" required>
                </div>
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-hand-holding-dollar"></i> Amortización Anticipo</label>
                    <input type="number" step="any" placeholder="$0.00" name="amorAnticipo" id="amorAnticipo" class="cd-form-control" required>
                </div>
            </div>

            <div class="cd-form-grid-3">
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-money-bill-wave"></i> Monto por Pagar</label>
                    <input type="number" step="any" placeholder="$0.00" name="montopagar" id="montopagar" class="cd-form-control" required>
                </div>
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Gastos Admon</label>
                    <input type="number" step="any" placeholder="%" name="pgastos" id="pgastos" value="<?php echo isset($idmandante) ? GastosAdminMandante($idmandante,$idcolonia,$idmunicipio) : ''; ?>" class="cd-form-control" required>
                </div>
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-file-invoice"></i> Gastos de Admon.</label>
                    <input type="number" step="any" placeholder="$0.00" name="gastos" id="gastos" class="cd-form-control" required>
                </div>
            </div>

            <div class="cd-form-grid-3">
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-percent"></i> % Gastos Escrituraciones</label>
                    <input type="number" step="any" placeholder="%" name="pgastosesc" id="pgastosesc" value="<?php echo isset($idmandante) ? GastosEscMandante($idmandante,$idcolonia,$idmunicipio) : ''; ?>" class="cd-form-control" required>
                </div>
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-file-signature"></i> Gastos Escrituración</label>
                    <input type="number" step="any" placeholder="$0.00" name="gastosesc" id="gastosesc" class="cd-form-control" required>
                </div>
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-arrow-rotate-left"></i> Devoluciones</label>
                    <input type="number" step="any" placeholder="$0.00" name="devols" id="devols" onkeyup="calcularDevoluciones();" value="0" class="cd-form-control">
                </div>
            </div>

            <div class="cd-form-grid-3">
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-tags"></i> Otros Descuentos</label>
                    <input type="number" step="any" placeholder="$0.00" name="otrosdesc" id="otrosdesc" onkeyup="calcularDevoluciones();" value="0" class="cd-form-control">
                </div>
                <div class="cd-form-group">
                    <label class="cd-form-label" style="color:var(--cd-primary); font-weight:700;"><i class="fa-solid fa-circle-check"></i> Monto Pagado</label>
                    <input type="number" step="any" placeholder="$0.00" onkeyup="operaciones(1);" name="montoPagado" id="montoPagado" class="cd-form-control" style="border-color:var(--cd-primary); font-weight:700;" required>
                </div>
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-desktop"></i> Recup. por Sistema</label>
                    <input type="number" step="any" placeholder="$0.00" name="sistema" id="sistema" class="cd-form-control">
                </div>
            </div>

            <div id="calculados" name="calculados" class="cd-form-grid" style="background:#f8fafc; padding:12px; border-radius:var(--cd-radius-sm); margin-bottom:15px;">
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-layer-group"></i> Monto Acumulado</label>
                    <input type="number" step="any" placeholder="$0.00" name="montoAcumulado" id="montoAcumulado" class="cd-form-control" required>
                </div>
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-wallet"></i> Saldo Actual</label>
                    <input type="number" step="any" placeholder="$0.00" name="saldo" id="saldo" class="cd-form-control" required>
                </div>
            </div>

            <h4 style="font-size:0.95rem; font-weight:700; color:var(--cd-dark); margin:15px 0 10px 0; border-bottom:2px solid var(--cd-gold-light); padding-bottom:4px;">
                <i class="fa-solid fa-sliders"></i> Conceptos y Ajustes Adicionales (+/-)
            </h4>

            <div class="cd-form-grid">
                <div class="cd-form-group">
                    <label class="cd-form-label">Enganche ahorro por identificar y traspasar</label>
                    <div style="display:flex; gap:8px;">
                        <select id="mas_menos2" name="mas_menos2" class="cd-form-control" style="width:90px;">
                            <option value="1">más (+)</option>
                            <option value="2">menos (-)</option>
                        </select>
                        <input type="number" step="any" placeholder="$0.00" name="engancheAhorro" id="engancheAhorro" class="cd-form-control">
                    </div>
                </div>

                <div class="cd-form-group">
                    <label class="cd-form-label">Descuento por nómina</label>
                    <div style="display:flex; gap:8px;">
                        <select id="mas_menos1" name="mas_menos1" class="cd-form-control" style="width:90px;">
                            <option value="1">más (+)</option>
                            <option value="2">menos (-)</option>
                        </select>
                        <input type="number" step="any" placeholder="$0.00" name="desNomina" id="desNomina" class="cd-form-control">
                    </div>
                </div>
            </div>

            <div class="cd-form-grid">
                <div class="cd-form-group">
                    <label class="cd-form-label">Por transferencia</label>
                    <div style="display:flex; gap:8px;">
                        <select id="mas_menos3" name="mas_menos3" class="cd-form-control" style="width:90px;">
                            <option value="1">más (+)</option>
                            <option value="2">menos (-)</option>
                        </select>
                        <input type="number" step="any" placeholder="$0.00" name="transferencia" id="transferencia" class="cd-form-control">
                    </div>
                </div>

                <div class="cd-form-group">
                    <label class="cd-form-label">Por pagos universales</label>
                    <div style="display:flex; gap:8px;">
                        <select id="mas_menos4" name="mas_menos4" class="cd-form-control" style="width:90px;">
                            <option value="1">más (+)</option>
                            <option value="2">menos (-)</option>
                        </select>
                        <input type="number" step="any" placeholder="$0.00" name="pagosUniversales" id="pagosUniversales" class="cd-form-control">
                    </div>
                </div>
            </div>

            <div class="cd-form-grid">
                <div class="cd-form-group">
                    <label class="cd-form-label">Por concepto de escritura</label>
                    <div style="display:flex; gap:8px;">
                        <select id="mas_menos5" name="mas_menos5" class="cd-form-control" style="width:90px;">
                            <option value="1">más (+)</option>
                            <option value="2">menos (-)</option>
                        </select>
                        <input type="number" step="any" placeholder="$0.00" name="escritura" id="escritura" class="cd-form-control">
                    </div>
                </div>

                <div class="cd-form-group">
                    <label class="cd-form-label">Por cesión de derechos</label>
                    <div style="display:flex; gap:8px;">
                        <select id="mas_menos6" name="mas_menos6" class="cd-form-control" style="width:90px;">
                            <option value="1">más (+)</option>
                            <option value="2">menos (-)</option>
                        </select>
                        <input type="number" step="any" placeholder="$0.00" name="derechos" id="derechos" class="cd-form-control">
                    </div>
                </div>
            </div>

            <div class="cd-form-grid">
                <div class="cd-form-group">
                    <label class="cd-form-label">Por pago de derechos</label>
                    <div style="display:flex; gap:8px;">
                        <select id="mas_menos7" name="mas_menos7" class="cd-form-control" style="width:90px;">
                            <option value="1">más (+)</option>
                            <option value="2">menos (-)</option>
                        </select>
                        <input type="number" step="any" placeholder="$0.00" name="pagoDerechos" id="pagoDerechos" class="cd-form-control">
                    </div>
                </div>

                <div class="cd-form-group">
                    <label class="cd-form-label">Por pago en OXXO</label>
                    <div style="display:flex; gap:8px;">
                        <select id="mas_menos8" name="mas_menos8" class="cd-form-control" style="width:90px;">
                            <option value="1">más (+)</option>
                            <option value="2">menos (-)</option>
                        </select>
                        <input type="number" step="any" placeholder="$0.00" name="pagooxxo" id="pagooxxo" class="cd-form-control">
                    </div>
                </div>
            </div>

            <div class="cd-form-grid">
                <div class="cd-form-group">
                    <label class="cd-form-label">Otros Pagos</label>
                    <div style="display:flex; gap:8px;">
                        <select id="mas_menos9" name="mas_menos9" class="cd-form-control" style="width:90px;">
                            <option value="1">más (+)</option>
                            <option value="2">menos (-)</option>
                        </select>
                        <input type="number" step="any" placeholder="$0.00" name="pagootros" id="pagootros" class="cd-form-control">
                    </div>
                </div>

                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-comment-dots"></i> Comentario</label>
                    <input type="text" placeholder="Comentario general" name="comentario" id="comentario" class="cd-form-control" required>
                </div>
            </div>

            <div class="cd-form-grid">
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-pen-to-square"></i> Observación para el pago</label>
                    <input type="text" placeholder="Observación específica para el pago" name="observacionPago" id="observacionPago" class="cd-form-control">
                </div>
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-building-columns"></i> Datos Bancarios</label>
                    <input type="text" placeholder="Cuenta / Banco / Referencia" name="datosBancarios" id="datosBancarios" class="cd-form-control">
                </div>
            </div>

            <div style="margin-top:20px; text-align:right;">
                <button class="cd-btn cd-btn-primary" type="submit" id="guardar">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Pago
                </button>
            </div>
        </form>

        <!-- FORMULARIO 2: OTROS TIPOS DE PAGO -->
        <form name="formulario1" id="formulario1" style="display:none;" action="" onSubmit="enviarDatos2(); return false;">
            <div class="cd-form-grid">
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-regular fa-calendar"></i> Fecha de Pago</label>
                    <input type="date" name="fecha2" id="fecha2" class="cd-form-control" required>
                </div>
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-dollar-sign"></i> Monto Pagado</label>
                    <input type="number" step="any" placeholder="$0.00" onkeyup="operaciones(2);" name="montoPagado2" id="montoPagado2" class="cd-form-control" required>
                </div>
            </div>

            <div id="calculados2" name="calculados2" class="cd-form-grid" style="background:#f8fafc; padding:12px; border-radius:var(--cd-radius-sm); margin-bottom:15px;">
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-layer-group"></i> Monto Acumulado</label>
                    <input type="number" step="any" placeholder="$0.00" name="montoAcumulado2" id="montoAcumulado2" class="cd-form-control" required>
                </div>
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-wallet"></i> Saldo Actual</label>
                    <input type="number" step="any" placeholder="$0.00" name="saldo2" id="saldo2" class="cd-form-control" required>
                </div>
            </div>

            <div class="cd-form-grid">
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-comment-dots"></i> Comentario</label>
                    <input type="text" placeholder="Comentario..." name="comentario" id="comentario" class="cd-form-control" required>
                </div>
                <div class="cd-form-group">
                    <label class="cd-form-label"><i class="fa-solid fa-building-columns"></i> Datos Bancarios</label>
                    <input type="text" placeholder="Datos bancarios..." name="datosBancarios1" id="datosBancarios1" class="cd-form-control">
                </div>
            </div>

            <div style="margin-top:20px; text-align:right;">
                <button class="cd-btn cd-btn-primary" type="submit" id="guardar2">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Pago
                </button>
            </div>
        </form>
    </div>

    <!-- TABLA DE REGISTROS (RENDERIZADA DIRECTAMENTE O VIA AJAX) -->
    <div id="tablaRegistros" style="display:inline-block; width:100%;">
        <?php
        if (isset($idmandante) && isset($idcolonia) && isset($idmunicipio)){
            $sql_reg = "SELECT * FROM mandantes_abonos WHERE idmandante = ".$idmandante." and idcolonia = ".$idcolonia." and idmunicipio = ".$idmunicipio." and cancelado=0 ORDER BY id DESC";
            $rc = $conexion->query($sql_reg);
            $total_records = $rc ? $rc->num_rows : 0;
            if ($total_records > 0){
        ?>
                <div class="cd-card-section" style="margin-top:20px;">
                    <div class="cd-card-header cd-card-header-primary">
                        <h3 class="cd-card-title">
                            <i class="fa-solid fa-receipt"></i> Desglose de Pagos a Mandante
                        </h3>
                        <span class="cd-badge cd-badge-info"><?php echo $total_records; ?> Registros</span>
                    </div>
                    <div class="cd-card-body" style="padding:0;">
                        <div class="cd-table-container">
                            <table class="cd-table">
                                <thead>
                                    <tr>
                                        <th style="text-align:center; width:50px;">ID</th>
                                        <th>Periodo Pago</th>
                                        <th style="text-align:right;">Recuperación</th>
                                        <th style="text-align:right;">Gastos</th>
                                        <th style="text-align:right;">Gastos Esc</th>
                                        <th style="text-align:right;">Monto Pagar</th>
                                        <th style="text-align:right;">Devols.</th>
                                        <th style="text-align:right;">Otros Desc.</th>
                                        <th style="text-align:right;">Amort. Ant.</th>
                                        <th style="text-align:right;">Monto Pagado</th>
                                        <th style="text-align:right;">Acumulado</th>
                                        <th style="text-align:right;">Saldo</th>
                                        <th style="text-align:center; width:190px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $vuelta = 0;
                                while($r = $rc->fetch_array()){
                                    $vuelta += 1;
                                    echo "<tr>";
                                    echo "<td style='text-align:center;'><span class='cd-badge-id'>".$r['id']."</span></td>";
                                    echo "<td style='font-weight:600;'>";
                                    if($r['periodopago'] == $r['periodopago2']){
                                        echo fechaesp($r['periodopago']);
                                    } else {
                                        echo fechaesp($r['periodopago'])." A ".fechaesp($r['periodopago2']);
                                    }
                                    echo "</td>";
                                    echo "<td style='text-align:right;'>$".number_format((float)$r['recuperacion'], 2)."</td>";
                                    echo "<td style='text-align:right;'>$".number_format((float)$r['gastos'], 2)."</td>";
                                    echo "<td style='text-align:right;'>$".number_format((float)$r['gastosesc'], 2)."</td>";
                                    echo "<td style='text-align:right;'>$".number_format((float)$r['montopagar'], 2)."</td>";
                                    echo "<td style='text-align:right;'>$".number_format((float)$r['devols'], 2)."</td>";
                                    echo "<td style='text-align:right;'>$".number_format((float)$r['otrosdesc'], 2)."</td>";
                                    echo "<td style='text-align:right;'>$".number_format((float)$r['amortizacion_anticipo'], 2)."</td>";
                                    echo "<td style='text-align:right; font-weight:700; color:var(--cd-primary);'>$".number_format((float)$r['monto_pagado'], 2)."</td>";
                                    echo "<td style='text-align:right;'>$".number_format((float)$r['monto_acumulado'], 2)."</td>";
                                    echo "<td style='text-align:right; font-weight:700;'>$".number_format((float)$r['saldo'], 2)."</td>";

                                    // Column Acciones
                                    echo "<td style='text-align:center;'><div class='cd-action-group'>";

                                    // Adjuntos button & modal
                                    echo "<a href='#subirAdjuntos1".$vuelta."' rel='MyModal:open' class='cd-icon-btn view' title='Documentos Adjuntos'><i class='fa-solid fa-paperclip'></i></a>";
                                    
                                    // Orden de Pago Form
                                    MiToken_Init($nitavu, 'PAGO A MANDANTES-ORDEN DE PAGO');
                                    echo "<form action='md_ordenpago.php?id=".$r['id']."&idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."&fecha=".$r['periodopago']."' method='POST' style='margin:0; display:inline;'>";
                                    echo "<input type='hidden' class='url1' name='url1'>";
                                    echo "<button type='submit' class='cd-icon-btn view' title='Ver Orden de Pago PDF'><i class='fa-solid fa-file-pdf' style='color:#dc2626;'></i></button>";
                                    echo "</form>";

                                    // Abono Extra
                                    echo "<a href='#masAbonos".$r['id']."' rel='MyModal:open' class='cd-icon-btn edit' title='Registrar Abono Extra'><i class='fa-solid fa-circle-plus'></i></a>";

                                    // Editar
                                    echo "<a href='md_modificarRegistro.php?id=".$r['id']."&idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' class='cd-icon-btn edit' title='Modificar Registro'><i class='fa-solid fa-pen-to-square'></i></a>";

                                    // Eliminar
                                    echo "<a href='mandantes_pago.php?ideliminar=".$r['id']."&idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' onclick=\"return confirm('¿Está seguro de eliminar este pago?');\" class='cd-icon-btn delete' title='Eliminar Registro'><i class='fa-solid fa-trash-can'></i></a>";

                                    echo "</div>";

                                    // MODAL ADJUNTOS
                                    echo "<div id='subirAdjuntos1".$vuelta."' class='MyModal'>";
                                    echo "<h3><i class='fa-solid fa-paperclip'></i> Documentos Adjuntos del Pago #".$r['id']."</h3>";
                                    echo "<div>";
                                    $adj = "SELECT idpago, ndocumento, nombre FROM documentos, mandantes_documentos WHERE mandantes_documentos.n_archivo=documentos.ndocumento and mandantes_documentos.idpago = ".$r['id']."";
                                    $rc1 = $conexion->query($adj);
                                    if ($rc1 && $rc1->num_rows > 0){
                                        echo "<table class='cd-table' style='margin-bottom:15px;'>";
                                        echo "<thead><tr><th>Archivo</th><th style='width:120px; text-align:center;'>Acción</th></tr></thead><tbody>";
                                        while($r1 = $rc1->fetch_array()){
                                            $archivo = "docs_mandantes/".$r1['idpago'].'_'.$r1['ndocumento'].'_'.$r1['nombre'];
                                            echo "<tr><td><i class='fa-solid fa-file-pdf' style='color:#dc2626; margin-right:8px;'></i>".htmlspecialchars($r1['nombre'])."</td>";
                                            echo "<td style='text-align:center;'><a href='md_descargar.php?nombre=".$archivo."' target='_self' class='cd-btn cd-btn-light' style='padding:4px 10px; font-size:0.8rem;'><i class='fa-solid fa-download'></i> Descargar</a></td></tr>";
                                        }
                                        echo "</tbody></table>";
                                    } else {
                                        echo "<p style='color:var(--cd-gray-dark); margin-bottom:15px;'><i class='fa-solid fa-info-circle'></i> No hay archivos adjuntos en este pago.</p>";
                                    }
                                    echo "</div>";

                                    echo "<form action='mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST' enctype='multipart/form-data' class='cd-form-group'>";
                                    echo "<label class='cd-form-label'><i class='fa-solid fa-upload'></i> Seleccione archivos anexos (PDF):</label>";
                                    echo "<input type='hidden' name='comprobante' value='".$r['id']."'>";
                                    echo "<input type='hidden' name='idmandante2' value='".$idmandante."'>";
                                    echo "<input type='hidden' name='idcolonia2' value='".$idcolonia."'>";
                                    echo "<input type='hidden' name='idmunicipio2' value='".$idmunicipio."'>";
                                    echo "<input id='archivo[]' name='archivo[]' type='file' accept='.pdf' multiple class='cd-form-control' required style='margin-bottom:12px;'>";
                                    echo "<button type='submit' class='cd-btn cd-btn-primary'><i class='fa-solid fa-cloud-arrow-up'></i> Subir Archivos</button>";
                                    echo "</form>";
                                    echo "</div>";

                                    // MODAL MAS ABONOS
                                    echo "<div id='masAbonos".$r['id']."' class='MyModal'>";
                                    echo "<h3><i class='fa-solid fa-circle-plus'></i> Registrar Concepto Adicional - Pago #".$r['id']."</h3>";
                                    echo "<form action='md_ingresa_abonoextra.php' method='POST'>";
                                    echo "<input name='nitavu1' type='hidden' value='".$nitavu."'/>";
                                    echo "<input name='idabono' type='hidden' value='".$r['id']."'/>";
                                    echo "<div class='cd-form-grid'>";
                                    echo "<div class='cd-form-group'><label class='cd-form-label'><i class='fa-solid fa-plus-minus'></i> Tipo de Ajuste</label>";
                                    echo "<select id='mas_menos' name='mas_menos' class='cd-form-control'>";
                                    echo "<option value='1'>Más (+)</option><option value='2'>Menos (-)</option></select></div>";

                                    echo "<div class='cd-form-group'><label class='cd-form-label'><i class='fa-solid fa-list-check'></i> Concepto</label>";
                                    echo "<select name='idconcepto' class='cd-form-control' id='idconcepto'>";
                                    $sql_c = "SELECT * FROM cat_conceptos_mandabonos where Activo=1 ";
                                    $rr = $conexion->query($sql_c);
                                    while($f = $rr->fetch_array()){
                                        echo "<option value='".$f['Id']."'>".htmlspecialchars($f['Concepto'])."</option>";
                                    }
                                    echo "</select></div>";
                                    echo "</div>";

                                    echo "<div class='cd-form-group'><label class='cd-form-label'><i class='fa-solid fa-dollar-sign'></i> Importe</label>";
                                    echo "<input name='importe' id='importe' type='number' step='any' placeholder='$0.00' class='cd-form-control' required/></div>";

                                    echo "<div style='margin-top:15px; text-align:right;'>";
                                    echo "<button class='cd-btn cd-btn-primary' type='submit'><i class='fa-solid fa-floppy-disk'></i> Guardar Concepto</button>";
                                    echo "</div>";
                                    echo "</form>";
                                    echo "</div>";

                                    echo "</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>

<script>    
    $(document).on("change", "#municipio", function(event) {
        $("#req_menu").css({'display':'none'});
        $("#registroPago").css({'display':'none'});
        $("#tablaRegistros").css({'display':'none'});
        
        $('#Mandantes').html('');
        $('#Apoderado').html('');
        mostrarColonias($("#municipio option:selected").val());
    });              

    function mostrarColonias(id){
        $("#preloader").css({'display':'inline-block'});
        $("#req_menu").css({'display':'none'});
        $("#registroPago").css({'display':'none'});
        $("#tablaRegistros").css({'display':'none'});
        $('#Mandantes').html('');
        $('#Apoderado').html('');

        $.ajax({
            url: "md_colonias.php",
            type: "get",
            data: {id: id},
            success: function(data){
                $("#preloader").css({'display':'none'});
                $('#colonia').html(data+"\n");
            }
        });

        document.getElementById("idmunicipio").value = id;        
    }

    function mostrarMandantes(){
        $("#req_menu").css({'display':'none'});
        $("#registroPago").css({'display':'none'});
        $("#tablaRegistros").css({'display':'none'});
        $("#preloader").css({'display':'inline-block'});
        var id = $("#colonia option:selected").val();
        var idmunicipio = $("#municipio option:selected").val();
        
        $('#Apoderado').html('');
        $.ajax({
            url: "md_mandantes.php",
            type: "get",
            data: {id: id, idmunicipio: idmunicipio },
            success: function(data){
                $("#preloader").css({'display':'none'});
                $('#Mandantes').html(data+"\n");
            }
        });

        document.getElementById("idcolonia").value = id;
    }

    function mostrarApoderado(){
        $("#req_menu").css({'display':'none'});
        $("#registroPago").css({'display':'none'});
        $("#tablaRegistros").css({'display':'none'});
        $("#preloader").css({'display':'inline-block'});
        var id = $("#colonia option:selected").val();
        var idmunicipio = $("#municipio option:selected").val();
        var idmandante = $("#mandantes option:selected").val();

        $.ajax({
            url: "md_apoderado.php",
            type: "get",
            data: {id: id, idmunicipio: idmunicipio, idmandante: idmandante },
            success: function(data){
                $("#preloader").css({'display':'none'});
                $('#Apoderado').html(data+"\n");
            }
        });
        document.getElementById("idmandante").value = idmandante;
    }

    function mostrarOpciones(){
        $("#req_menu").css({'display':'flex'});
        $("#tablaRegistros").css({'display':'block'});
        
        var id = $("#mandantes option:selected").val();
        idcolonia = document.getElementById("idcolonia").value;
        idmunicipio = document.getElementById("idmunicipio").value;
        nitavu = document.getElementById('nitavu').value;

        var URLactual = window.location;    
        if(document.getElementById('url')) {
            document.getElementById('url').value = URLactual;
        }

        $.ajax({
            url: "md_registrosMandante.php",
            type: "get",
            data: {id: id, idcolonia: idcolonia, idmunicipio: idmunicipio, nitavu: nitavu },
            success: function(data){
                $("#preloader").css({'display':'none'});
                if(document.forms['reporteMandante']) {
                    document.forms['reporteMandante'].action = "md_reporte.php?id="+id+"&idcolonia="+idcolonia+"&idmunicipio="+idmunicipio;
                }
                if(document.getElementById("nuevoCargo")) {
                    document.getElementById("nuevoCargo").href = "md_nuevoCargo.php?id="+id+"&idcolonia="+idcolonia+"&idmunicipio="+idmunicipio;
                }
                if(document.getElementById("mddocumentos")) {
                    document.getElementById("mddocumentos").href = "md_documentos.php?id="+id+"&idcolonia="+idcolonia+"&idmunicipio="+idmunicipio;
                }
                             
                $('#tablaRegistros').html(data+"\n");
                $('.url1').val(URLactual);   
                $('#url').val(URLactual); 
            }
        });
        document.getElementById("idmandante").value = id;
    }

    function enviarDatos(){
        idmandante = document.getElementById("idmandante").value;
        idcolonia = document.getElementById("idcolonia").value;
        idmunicipio = document.getElementById("idmunicipio").value;

        fecha = document.formulario.fecha.value;
        periodo2 = document.formulario.periodo2.value;
        recu = document.formulario.recuperacion.value;
        pgastos = document.formulario.pgastos.value;
        gastos = document.formulario.gastos.value;
        montopagar = document.formulario.montopagar.value;
        pdevols = 0;
        devols = document.formulario.devols.value;
        otrosdesc = document.formulario.otrosdesc.value;
        pamorAnt = document.formulario.pamorAnt.value;
        amorAnticipo = document.formulario.amorAnticipo.value;
        montoPagado = document.formulario.montoPagado.value;
        montoAcumulado = document.formulario.montoAcumulado.value;
        saldo = document.formulario.saldo.value;
        sistema = document.formulario.sistema.value;

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
        centavo = 0;
        comentario = document.formulario.comentario.value;
        observacionPago = document.formulario.observacionPago.value;
        datosbancarios = document.formulario.datosBancarios.value;

        pgastosesc = document.formulario.pgastosesc.value;
        gastosesc = document.formulario.gastosesc.value;
       
        var idTipoMov = $("#tipo_mov option:selected").val();

        $.ajax({
            url: "md_ingresardatosBD.php",
            type: "post",
            data: {idmandante: idmandante, idcolonia: idcolonia, idmunicipio: idmunicipio, fecha:fecha, periodo2: periodo2, recuperacion:recu, pgastos: pgastos, gastos: gastos, 
            montopagar: montopagar, pdevols: pdevols, devols:devols, pamorAnt: pamorAnt, amorAnticipo:amorAnticipo, montoPagado: montoPagado, montoAcumulado: montoAcumulado, saldo: saldo, sistema: sistema, signo1: signo1, desNomina: desNomina,
            signo2: signo2, engancheAhorro:engancheAhorro, signo3: signo3, transferencia:transferencia, signo4:signo4, pagosUniversales: pagosUniversales, signo5: signo5, escritura: escritura, signo6:signo6,
            derechos: derechos, signo7: signo7, pagoDerechos: pagoDerechos, signo8: signo8, pagooxxo: pagooxxo, centavo: centavo, comentario: comentario, observacionPago:observacionPago, idTipoMov:idTipoMov, datosbancarios:datosbancarios,signo9: signo9, pagootros: pagootros, pgastosesc: pgastosesc, gastosesc: gastosesc , otrosdesc:otrosdesc, nitavu1: <?php echo $nitavu; ?>},
            success: function(data){
                $('#mensajeConfirmacion').html(data+"\n");
                $("#mensajeConfirmacion").css({'display':'inline-block'}).slideUp(4000).delay(10000).fadeOut(4000);
                document.formulario.fecha.value = "";
                document.formulario.periodo2.value = "";
                document.formulario.recuperacion.value = "";
                document.formulario.pgastos.value = "";
                document.formulario.gastos.value = "";
                document.formulario.montopagar.value = "";
                document.formulario.devols.value = "";
                document.formulario.otrosdesc.value = "";
                document.formulario.pamorAnt.value = "";
                document.formulario.amorAnticipo.value = "";
                document.formulario.montoPagado.value = "";
                document.formulario.montoAcumulado.value = "";
                document.formulario.saldo.value = "";
                document.formulario.sistema.value = "";
                document.formulario.desNomina.value = "";
                document.formulario.engancheAhorro.value = "";
                document.formulario.transferencia.value = "";
                document.formulario.pagosUniversales.value = "";
                document.formulario.escritura.value = "";
                document.formulario.derechos.value = "";
                document.formulario.pagoDerechos.value = "";
                document.formulario.pagooxxo.value = "";
                document.formulario.pagootros.value = "";
                document.formulario.gastosesc.value = "";
                document.formulario.comentario.value = "";
                document.formulario.observacionPago.value = "";
                document.formulario.datosBancarios.value = "";
                mostrarOpciones();
            }
        });
    }

    function enviarDatos2(){
        idmandante = document.getElementById("idmandante").value;
        idcolonia = document.getElementById("idcolonia").value;
        idmunicipio = document.getElementById("idmunicipio").value;

        fecha2 = document.formulario1.fecha2.value;
        montoPagado2 = document.formulario1.montoPagado2.value;
        montoAcumulado2 = document.formulario1.montoAcumulado2.value;
        saldo2 = document.formulario1.saldo2.value;
        comentario = document.formulario1.comentario.value;
        datosbancarios = document.formulario1.datosBancarios1.value;
        
        var idTipoMov = $("#tipo_mov option:selected").val();

        $.ajax({
            url: "md_ingresardatosBD.php",
            type: "post",
            data: {idmandante: idmandante, idcolonia: idcolonia, idmunicipio: idmunicipio, fecha2:fecha2, montoPagado2: montoPagado2,montoAcumulado2: montoAcumulado2, saldo2: saldo2, comentario: comentario, idTipoMov:idTipoMov ,datosbancarios:datosbancarios,nitavu1: <?php echo $nitavu; ?>},
            success: function(data){
                $('#mensajeConfirmacion').html(data+"\n");
                $("#mensajeConfirmacion").css({'display':'inline-block'}).slideUp(4000).delay(10000).fadeOut(4000);
                document.formulario1.fecha2.value = "";
                document.formulario1.montoPagado2.value = "";
                document.formulario1.montoAcumulado2.value = "";
                document.formulario1.saldo2.value = "";
                document.formulario1.comentario.value = "";
            
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
        if(id == 3){
            buscarGastosAdmin();
            buscarGastosEsc();
            buscarAmortizacionAnt();
            $("#formulario").css({'display':'block'});
            $("#formulario1").css({'display':'none'});
        } else {
            $("#formulario1").css({'display':'block'});
            $("#formulario").css({'display':'none'});
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

<script>
function mostrarFecha2(){
    if (peri2.checked == true){
        $("#fech2").css({'display':'flex'});
    } else {
        $("#fech2").css({'display':'none'});
    }
}

function mostrarDecimales(){    
    this.value = parseFloat(this.value.replace(/,/g, ""))
                    .toFixed(2)
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    document.getElementById("display").value = this.value.replace(/,/g, "");
}

function operaciones(){
    var idmunicipio = $("#municipio option:selected").val();
    var idmandante =  $("#mandantes option:selected").val();
    var idcolonia =  $("#colonia option:selected").val();
    
    var pago = document.getElementById("montoPagado").value;
    pago = $('#montopagar').val() - $('#devols').val() - $('#gastos').val() - $('#gastosesc').val() - $("#otrosdesc").val();
    $('#montoPagado').val(pago);

    $.ajax({
        url: "md_operaciones.php",
        type: "post",
        data: {idmandante:idmandante, idcolonia:idcolonia, idmunicipio:idmunicipio, pago:pago},
        success: function(data){
            $('#calculados').html(data+"\n");
        }
    });
}

function todas(){
    calcularAmortizacion();
    calcularMontoPorPagar();
    buscarGastosEsc();
    calcularGastosEsc();
    buscarGastosAdmin();
    calcularGastosAdmin();
    calcularDevoluciones();
}

function buscarGastosAdmin(){
    var idmunicipio = $("#municipio option:selected").val();
    var idmandante =  $("#mandantes option:selected").val();
    var idcolonia =  $("#colonia option:selected").val();

    $.ajax({
        url: "md_gastosAdmin.php",
        type: "post",
        data: {idmandante:idmandante, idcolonia:idcolonia, idmunicipio:idmunicipio},
        success: function(data){
            $('#pgastos').val(data);
        }
    });
}

function buscarGastosEsc(){
    var idmunicipio = $("#municipio option:selected").val();
    var idmandante =  $("#mandantes option:selected").val();
    var idcolonia =  $("#colonia option:selected").val();

    $.ajax({
        url: "md_gastosEsc.php",
        type: "post",
        data: {idmandante:idmandante, idcolonia:idcolonia, idmunicipio:idmunicipio},
        success: function(data){
            $('#pgastosesc').val(data);
        }
    });
}

function buscarAmortizacionAnt(){
    var idmunicipio = $("#municipio option:selected").val();
    var idmandante =  $("#mandantes option:selected").val();
    var idcolonia =  $("#colonia option:selected").val();

    $.ajax({
        url: "md_amortizacionAnt.php",
        type: "post",
        data: {idmandante:idmandante, idcolonia:idcolonia, idmunicipio:idmunicipio},
        success: function(data){
            $('#pamorAnt').val(data);
        }
    });
}

function calcularGastosAdmin(){
    var pago = $('#montopagar').val();
    var porcentaje = $('#pgastos').val();
    var res = (pago * porcentaje) / 100;
    res = Math.round(res);
    $('#gastos').val(res);
}

function calcularGastosEsc(){
    var pago = $('#montopagar').val();
    var porcentaje = $('#pgastosesc').val();
    var res = (pago * porcentaje) / 100;
    res = Math.round(res);
    $('#gastosesc').val(res);
}

function calcularMontoPorPagar(){
    var pago = $('#recuperacion').val();
    var amor_ant = $('#amorAnticipo').val();
    var res = pago - amor_ant;
    $('#montopagar').val(res);
}

function calcularDevoluciones(){
    operaciones();
}

function calcularAmortizacion(){
    var pago = $('#recuperacion').val();
    var porcentaje = $('#pamorAnt').val(); 
    var res = (pago * porcentaje) / 100;
    res = Math.round(res);
    $('#amorAnticipo').val(res);
}

$(document).ready(function() {
    var URLactual = window.location;    
    if(document.getElementById('url')) {
        document.getElementById('url').value = URLactual;
    }
    $('.url1').val(URLactual);
});
</script>

<?php 
} else {
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}
include ("./lib/body_footer.php"); 
?>