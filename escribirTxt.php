<?php 
    include ("lib/body_head.php");

    /*$IdDelegacion = $_GET['delegacion'];
    $IdPrograma = $_GET['programa'];
    $Folio = $_GET['folio'];
    $nitavu = $_GET['nitavu'];*/

    $IdDelegacion = 6;
    $IdPrograma = 78;
    $Folio = 15000;
    $NumContrato = '06784106415';
    $nitavu = 1733;

    $file = fopen("archivo.txt", "w");

        //--------------------- Tabla Contratos ---------------------\\
        fwrite($file, "#Tabla: Contratos" . PHP_EOL);
        $sql = "Select * from contratos Where numcontrato = '".$NumContrato."'";
        $r = $Vivienda -> query($sql);
        if ($r -> num_rows >0){
            while($f = $r -> fetch_array()){
                fwrite($file, "contratomaestro=".$f['ContratoMaestro']  . PHP_EOL);
                fwrite($file, "VC-01=".$f['NumContrato']  . PHP_EOL);

                //Se obtiene el numero de dia del su contratacion
                fwrite($file, "VC-04=".hora12($f['FechaEmision']) . PHP_EOL);

                //Se obtiene la hora de la contratacion
                fwrite($file, "VC-05=".date_format( date_create($f['FechaEmision']), 'd') . PHP_EOL);

                //Se obtiene el mes en que se contrato
                $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                fwrite($file, "VC-06=".$meses[intval(date_format( date_create($f['FechaEmision']), 'm'))] . PHP_EOL);

                //Se obtiene el año de la contratacion
                fwrite($file, "VC-07=".date_format( date_create($f['FechaEmision']), 'Y') . PHP_EOL);
            }
        }
        fwrite($file, " " . PHP_EOL);

        //--------------------- Tabla solicitudes ---------------------\\
        $sql = "SELECT     solicitudes.*, solicitantes.*
                FROM         solicitudes LEFT OUTER JOIN
                solicitantes ON solicitudes.IdSolicitante = solicitantes.IdSolicitante
                Where iddelegacion='".$IdDelegacion."' AND IdPrograma ='".$IdPrograma."' AND folio ='".$Folio."'";	
        fwrite($file, "#Tabla: solicitudes" . PHP_EOL);
        $r = $Vivienda -> query($sql);
        if ($r -> num_rows >0){
            while($f = $r -> fetch_array()){
                fwrite($file, "VC-02=".$f['Folio']  . PHP_EOL);
                fwrite($file, "VTAMS-006=".$f['NomReferencia']  . PHP_EOL);
                fwrite($file, "VTAMS-007=".$f['DomReferencia']  . PHP_EOL);
                fwrite($file, "VTAMS-008=".$f['ReferenciaDos']  . PHP_EOL);
                fwrite($file, "VTAMS-009=".$f['ReferenciaDosDom']  . PHP_EOL);
                fwrite($file, "VC-08=".$f['Nombre']." ".$f['Paterno']." ".$f['Materno'] . PHP_EOL);
                $vIdEdoCivil = intval($f['IdEstadoCivil']);
            }
        }
        fwrite($file, " " . PHP_EOL);

        //--------------------- Tabla DatosConyuge ---------------------\\
        $sql = "SELECT * from datosconyuge Where iddelegacion='".$IdDelegacion."' AND IdPrograma ='".$IdPrograma."' AND folio ='".$Folio."'";	
        fwrite($file, "#Tabla: DatosConyuge" . PHP_EOL);
        $r = $Vivienda -> query($sql);
        if ($r -> num_rows >0){
            while($f = $r -> fetch_array()){
                fwrite($file, "VC-09=".$f['Nombre']." ".$f['Paterno']." ".$f['Materno'] . PHP_EOL);
            }
        }
        fwrite($file, " " . PHP_EOL);

        //--------------------- Tabla Delegaciones ---------------------\\
        $sql = "select * from delegaciones Where iddelegacion='".$IdDelegacion."'";	
        fwrite($file, "#Tabla: Delegaciones" . PHP_EOL);
        $r = $Vivienda -> query($sql);
        if ($r -> num_rows >0){
            while($f = $r -> fetch_array()){
                fwrite($file, "VC-03=".$f['Delegacion']  . PHP_EOL);
            }
        }
        fwrite($file, " " . PHP_EOL);

        //--------------------- Tabla EstadoCivil ---------------------\\
        $sql = "select * from estadocivil where IdEstadoCivil =".$vIdEdoCivil;	
        fwrite($file, "#Tabla: EstadoCivil" . PHP_EOL);
        $r = $Vivienda -> query($sql);
        if ($r -> num_rows >0){
            while($f = $r -> fetch_array()){
                //Se obtiene el estado civil del beneficiario
                fwrite($file, "VC-10=".$f['EstadoCivil']  . PHP_EOL);
            }
        }
        fwrite($file, " " . PHP_EOL);

        //--------------------- Tabla DatosEmpleadoSol ---------------------\\
        $sql = "SELECT datosempleosol.*, ocupaciones.Ocupacion
                FROM datosempleosol LEFT OUTER JOIN
                ocupaciones ON datosempleosol.IdOcupacion = ocupaciones.IdOcupacion
                Where iddelegacion='".$IdDelegacion."' AND IdPrograma ='".$IdPrograma."' AND folio ='".$Folio."'";	
        fwrite($file, "#Tabla: DatosEmpleadoSol" . PHP_EOL);
        $r = $Vivienda -> query($sql);
        if ($r -> num_rows >0){
            while($f = $r -> fetch_array()){
                //Se obtiene la ocupacion laboral del beneficiario
                fwrite($file, "VC-11=".$f['Ocupacion'] . PHP_EOL);
            }
        }
        fwrite($file, " " . PHP_EOL);

        //--------------------- Tabla DatosDomicilio ---------------------\\
        $sql = "SELECT datosdomicilio.*, colonias.Colonia, municipios.Municipio
                FROM datosdomicilio LEFT OUTER JOIN
                      municipios ON datosdomicilio.IdMunicipio = municipios.IdMunicipio LEFT OUTER JOIN
                      colonias ON datosdomicilio.IdColonia = colonias.IdColonia
                Where iddelegacion='".$IdDelegacion."' AND IdPrograma ='".$IdPrograma."' AND folio ='".$Folio."'";	
        fwrite($file, "#Tabla: DatosDomicilio" . PHP_EOL);
        $r = $Vivienda -> query($sql);
        if ($r -> num_rows >0){
            while($f = $r -> fetch_array()){
                //Obtiene el domicilio donde vive la persona
                fwrite($file, "VC-12=".$f['CalleyNum'].", Colonia ".$f['Colonia'].", Municipio de ".$f['Municipio'] . PHP_EOL);
                //Obtiene el codigo postal del domicilio
                fwrite($file, "VC-95=".$f['CPDom'] . PHP_EOL);
                //Obtiene el numero exterior del domicilio
                fwrite($file, "VC-96=".$f['NumExterior'] . PHP_EOL);
                fwrite($file, "VC-97=".$f['Colonia'] . PHP_EOL);
                fwrite($file, "VC-13=".$f['CalleyNum'] . PHP_EOL);
            }
        }
        fwrite($file, " " . PHP_EOL);

        //--------------------- Tabla DatosConstruccion ---------------------\\
        $sql = "SELECT     Sol.IdDelegacion, Sol.IdPrograma, Sol.Folio, 
                (CASE WHEN LOCATE('REGISTRA', ColDomicilio.Colonia) = 0 THEN ColDomicilio.Colonia ELSE dDomicilio.OtraColonia END) AS ColDomicilio, 
                (CASE WHEN LOCATE('REGISTRA', ColConstruccion.Colonia) = 0 THEN ColConstruccion.Colonia ELSE dVivienda.OtraColonia END) AS ColConstruccion
                FROM         datosvivienda AS dVivienda LEFT OUTER JOIN
                                    colonias AS ColConstruccion ON dVivienda.IdColonia = ColConstruccion.IdColonia RIGHT OUTER JOIN
                                    solicitudes AS Sol ON dVivienda.IdDelegacion = Sol.IdDelegacion AND dVivienda.IdPrograma = Sol.IdPrograma AND dVivienda.Folio = Sol.Folio LEFT OUTER JOIN
                                    colonias AS ColDomicilio INNER JOIN
                                    datosdomicilio AS dDomicilio ON ColDomicilio.IdColonia = dDomicilio.IdColonia ON Sol.IdDelegacion = dDomicilio.IdDelegacion AND
                                    Sol.IdPrograma = dDomicilio.IdPrograma And Sol.Folio = dDomicilio.Folio
                                Where Sol.iddelegacion='".$IdDelegacion."' AND Sol.IdPrograma ='".$IdPrograma."' AND Sol.folio ='".$Folio."'";	
        fwrite($file, "#Tabla: DatosConstruccion" . PHP_EOL);
        $r = $Vivienda -> query($sql);
        if ($r -> num_rows >0){
            while($f = $r -> fetch_array()){
                fwrite($file, "VC-14=".$f['ColConstruccion'] . PHP_EOL);
            }
        }
        fwrite($file, " " . PHP_EOL);

        //--------------------- Tabla DatosVivienda ---------------------\\
        $sql = "Select * from datosvivienda Where Iddelegacion='".$IdDelegacion."' AND IdPrograma ='".$IdPrograma."' AND folio ='".$Folio."'";	
        fwrite($file, "#Tabla: DatosVivienda" . PHP_EOL);
        $r = $Vivienda -> query($sql);
        if ($r -> num_rows >0){
            while($f = $r -> fetch_array()){
                ///Se obtiene el campo Superficie, de la pestaña Datos de la propiedad en el objeto TXTSUPERFICIEV
                fwrite($file, "VC-15=".$f['Superficie'] . PHP_EOL);
                ///Se obtiene el dato Colindancia al NE, de la pestaña Datos de la propiedad en el objeto TXTSUPERFICIEV 
                fwrite($file, "VC-16=".$f['ColindaNE'] . PHP_EOL);
                ///Se obtiene el dato Colindancia al SE, de la pestaña Datos de la propiedad en el objeto txtColindaSEV 
                fwrite($file, "VC-17=".$f['ColindaSE'] . PHP_EOL);
                ///Se obtiene el dato Colindancia al SO, de la pestaña Datos de la propiedad en el objeto txtColindaSOV 
                fwrite($file, "VC-18=".$f['ColindaSO'] . PHP_EOL);
                ///Se obtiene el dato Colindancia al NO, de la pestaña Datos de la propiedad en el objeto txtColindaNOV 
                fwrite($file, "VC-19=".$f['ColindaNO'] . PHP_EOL);
                ///Se obtiene el dato Número, de la pestaña Datos de la propiedad en el objeto txtRPNumeroV 
                fwrite($file, "VC-20=".$f['RPNumero'] . PHP_EOL);
                ///Se obtiene el dato Legajo, de la pestaña Datos de la propiedad en el objeto txtRPLegajoV 
                fwrite($file, "VC-21=".$f['RPLegajo'] . PHP_EOL);
                ///Se obtiene el dato Sección, de la pestaña Datos de la propiedad en el objeto txtRPSeccionV 
                fwrite($file, "VC-22=".$f['RPSeccion'] . PHP_EOL);

            }
        }
        fwrite($file, " " . PHP_EOL);




        










        

























    fclose($file);

?>
<?php include ("lib/body_footer.php"); ?>