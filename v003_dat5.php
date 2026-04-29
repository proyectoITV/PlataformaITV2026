<?php
//require ("config.php");
//require ("lib/funciones.php");
//require ("lib/flor_funciones.php");
//require ("lib/yes_funciones.php");
$FolioTramite = $_POST['FolioTramite'];

$idsolicitante = ""; $curp = ""; $enviar = 1; $fechacaptura= "";  $fechaUltimaMod = ""; $fechaNacimiento = "";
$idEmpCrea = ""; $idEmpModifica= ""; $idOrigen=""; $sexo = "";  $aMaterno = ""; $NCElector = ""; $Nombre = ""; $aPaterno = "";
$rfc = ""; $nom = ""; $idpersona= ""; $nipnew=""; $nip =""; $personamoral=""; $nacionalidad = ""; $lugarNacimiento = "";
$nipAnterior=""; $numeroActa=""; $razonSocial=""; $numPermiso=""; $origenDeEnvio="";  $egresoMensual = "";
$estadoCivil = ""; $cantidadDestinable = ""; $otrasPropiedades = "";  $gastoAlimentos = "";  $gastoAgua = "";  $gastoLuz = "";
$gastoTel = ""; $gastoTransporte = "";  $gastoEducacion = ""; $otrosGastos = ""; $munDondeSeRequiereLote = ""; $ahorroPrevio = "";
$regConyugal = ""; $tipoIdentificacion= ""; $secYCat= ""; $correo = ""; $oficioTarjetaAut= ""; $telFamDirecto= ""; $nombreRef1= "";
$apaternoRef1= ""; $amaternoRef1= ""; $calleRef1= ""; $coloniaRef1= ""; $ninteriorRef1= ""; $nexteriorRef1= ""; $cpRef1= "";
$calle1Ref1= ""; $calle2Ref1= ""; $telRef1= ""; $nombreRef2= ""; $apaternoRef2= ""; $amaternoRef2= ""; $calleRef2= ""; $coloniaRef2= ""; $ninteriorRef2= "";
$nexteriorRef2= "";  $cpRef2= ""; $calle1Ref2= ""; $calle2Ref2= ""; $telRef2= ""; $domRef1=""; $domRef2 = ""; $facebook = ""; $twitter= "";
$nombreRef1= '';  $apaternoRef1= ''; $amaternoRef1= ''; $calleRef1= ""; $coloniaRef1= ""; $ninteriorRef1= ""; $nexteriorRef1= "";  $cpRef1= "";
$calle1Ref1= ""; $calle2Ref1= ""; $telRef1= ""; $nombreRef2= "";  $apaternoRef2= "";  $amaternoRef2= "";  $calleRef2= ""; $coloniaRef2= ""; $ninteriorRef2= "";
$nexteriorRef2= ""; $cpRef2= ""; $calle1Ref2= ""; $calle2Ref2= ""; $telRef2= ""; $curpConyuge = "";  $idOrigenConyuge = ""; $fechaNacConyuge = ""; $sexoConyugue = "";
$aMaternoConyuge = ""; $NCElectorConyuge = ""; $nombreConyuge = ""; $aPaternoConyuge = ""; $rfcConyuge = "";  $nacionalidadConyuge = ""; $lugarNacConyuge= "";
$domEmpleoConyuge= ""; $empresaConyuge= "";  $ocupacionConyuge= ""; $prestacionConyuge= 0; $ingresoMenConyuge= 0; $numEmpleadoConyuge= ""; $puestoConyuge= "";
$telEmpleoConyuge= ""; $trabajaConyuge= ""; $antiguedadConyuge= "";  $calle= ""; $colonia= ""; $numInt= "";
$numExt= "";  $cp= ""; $calle1= ""; $calle2= ""; $localidad= ""; $municipio= ""; $tipocasa= ""; $otracolonia = ""; $tiempoVivirahi = "";  $telefono = "";
$celular = ""; $instDictamen= ""; $fechaDictamen = ""; $folioDictamen = ""; $certNoPropiedad = ""; $domEmpleo= ""; $empresa= ""; $ocupacion= "";  $prestacion=0; $ingresoMen= 0;
$numEmpleado= "";  $puesto= ""; $telEmpleo= ""; $trabaja= ""; $antiguedad= ""; $jefeFamilia= ""; $nivelEstudio= ""; $totalHabVivienda= "";
$curpDep = ""; $trabajaDep=""; $fechaNacDep=""; $sexoDep =""; $amaternoDep =""; $apaternoDep=""; $nombreDep  =""; $ingresoDep =0; $parentescoDep="";
$idConyuge =""; $entidad =""; $entidadConyuge="";
$sql = "SELECT * from solicitudesinformacion WHERE IdSolicitud = ".$idTramite."";
//echo $sql;
$r = $conexion -> query($sql);

while($f = $r -> fetch_array()){ 
   ////=========DATOS BENEFICIARIO
    if($f['IdRequisito']==0 and $f['Clase']==1){
        $idsolicitante = $f['Dato'];
        $curp = $f['Dato'];
    }
    if($f['IdRequisito']==39  and $f['Clase']==1){
        $idOrigen = $f['Dato'];
    }
    if($f['IdRequisito']==5  and $f['Clase']==1){
        $fechaNacimiento = $f['Dato'];
    }
    if($f['IdRequisito']==4  and $f['Clase']==0){
        $sexo = $f['Dato'];
       
        if($sexo == 'M'){
            $sexo = 1;
        }else{
            $sexo = 2;
        }
    }
    if($f['IdRequisito']==3  and $f['Clase']==0){
        $aMaterno = $f['Dato'];
    }
    if($f['IdRequisito']==92  and $f['Clase']==0){
        $NCElector = $f['Dato'];
    }
    if($f['IdRequisito']==1  and $f['Clase']==0){
        $Nombre = $f['Dato'];
    }
    if($f['IdRequisito']==2  and $f['Clase']==0){
        $aPaterno = $f['Dato'];
    }
    if($f['IdRequisito']==43  and $f['Clase']==0){
        $rfc = $f['Dato'];
    }
    if($f['IdRequisito']==6  and $f['Clase']==0){
        $nacionalidad = $f['Dato'];
        $nacionalidad = TramiteDatoExtendida($idTramite, 6, 0);
    }
    if($f['IdRequisito']==40  and $f['Clase']==0){
        $lugarNacimiento = $f['Dato'];
    }

    ////=========SOLICITUDES
    if($f['IdRequisito']==85 and $f['Clase']==0){
        $egresoMensual = $f['Dato'];
    }
    if($f['IdRequisito']==36 and $f['Clase']==0){
        $estadoCivil = $f['Dato'];
    }
    if($f['IdRequisito']==87 and $f['Clase']==0){
        $cantidadDestinable = $f['Dato'];
    }
    if($f['IdRequisito']==89  and $f['Clase']==0){
        $otrasPropiedades = $f['Dato'];
    }
    if($f['IdRequisito']==78  and $f['Clase']==0){
        $gastoAlimentos = $f['Dato'];
    }
    if($f['IdRequisito']==79  and $f['Clase']==0){
        $gastoAgua = $f['Dato'];
    }
    if($f['IdRequisito']==80  and $f['Clase']==0){
        $gastoLuz = $f['Dato'];
    }
    if($f['IdRequisito']==81  and $f['Clase']==0){
        $gastoTel = $f['Dato'];
    }
    if($f['IdRequisito']==82  and $f['Clase']==0){
        $gastoTransporte = $f['Dato'];
    }
    if($f['IdRequisito']==83  and $f['Clase']==0){
        $gastoEducacion = $f['Dato'];
    }
    if($f['IdRequisito']==84  and $f['Clase']==0){
        $otrosGastos = $f['Dato'];
    }
    if($f['IdRequisito']==70  and $f['Clase']==0){
        $munDondeSeRequiereLote = $f['Dato'];
    }
    if($f['IdRequisito']==91  and $f['Clase']==0){
        $ahorroPrevio = $f['Dato'];
    }
    if($f['IdRequisito']==42  and $f['Clase']==0){
        $regConyugal = $f['Dato'];
    }
    if($f['IdRequisito']==44  and $f['Clase']==0){
        $tipoIdentificacion= $f['Dato'];
    }
    if($f['IdRequisito']==64  and $f['Clase']==0){
        $secYCat= $f['Dato'];
    }
    if($f['IdRequisito']==73  and $f['Clase']==0){
        $correo = $f['Dato'];
    }
    if($f['IdRequisito']==72  and $f['Clase']==0){
        $oficioTarjetaAut= $f['Dato'];
    }
    if($f['IdRequisito']==74  and $f['Clase']==0){
        $telFamDirecto= $f['Dato'];
    }
    if($f['IdRequisito']==75  and $f['Clase']==0){
        $facebook= $f['Dato'];
    }
    if($f['IdRequisito']==76  and $f['Clase']==0){
        $twitter= $f['Dato'];
    }
    //REFERENCIA PRIMARIA
    if($f['IdRequisito']==1 and $f['Clase']==1){
        $nombreRef1= $f['Dato'];
    }
    if($f['IdRequisito']==2 and $f['Clase']==1){
        $apaternoRef1= $f['Dato'];
    }
    if($f['IdRequisito']==3 and $f['Clase']==1){
        $amaternoRef1= $f['Dato'];
    }
    if($f['IdRequisito']==21 and $f['Clase']==1){
        $calleRef1= $f['Dato'];
    }
    if($f['IdRequisito']==22 and $f['Clase']==1){
        $coloniaRef1= $f['Dato'];
    }
    if($f['IdRequisito']==23 and $f['Clase']==1){
        $ninteriorRef1= $f['Dato'];
    }
    if($f['IdRequisito']==24 and $f['Clase']==1){
        $nexteriorRef1= $f['Dato'];
    }
    if($f['IdRequisito']==25 and $f['Clase']==1){
        $cpRef1= $f['Dato'];
    }
    if($f['IdRequisito']==26 and $f['Clase']==1){
        $calle1Ref1= $f['Dato'];
    }
    if($f['IdRequisito']==27 and $f['Clase']==1){
        $calle2Ref1= $f['Dato'];
    }
    if($f['IdRequisito']==18 and $f['Clase']==1){
        $telRef1= $f['Dato'];
    }

    //REFERENCIA SECUNDARIA
    if($f['IdRequisito']==1 and $f['Clase']==2){
        $nombreRef2= $f['Dato'];
    }
    if($f['IdRequisito']==2 and $f['Clase']==2){
        $apaternoRef2= $f['Dato'];
    }
    if($f['IdRequisito']==3 and $f['Clase']==2){
        $amaternoRef2= $f['Dato'];
    }
    if($f['IdRequisito']==21 and $f['Clase']==2){
        $calleRef2= $f['Dato'];
    }
    if($f['IdRequisito']==22 and $f['Clase']==2){
        $coloniaRef2= $f['Dato'];
    }
    if($f['IdRequisito']==23 and $f['Clase']==2){
        $ninteriorRef2= $f['Dato'];
    }
    if($f['IdRequisito']==24 and $f['Clase']==2){
        $nexteriorRef2= $f['Dato'];
    }
    if($f['IdRequisito']==25 and $f['Clase']==2){
        $cpRef2= $f['Dato'];
    }
    if($f['IdRequisito']==26 and $f['Clase']==2){
        $calle1Ref2= $f['Dato'];
    }
    if($f['IdRequisito']==27 and $f['Clase']==2){
        $calle2Ref2= $f['Dato'];
    }
    if($f['IdRequisito']==18 and $f['Clase']==2){
        $telRef2= $f['Dato'];
    }


    //=========DATOS CONYUGE
    if($f['IdRequisito']==0 and $f['Clase']==3){
        $curpConyuge = $f['Dato'];
    }
    if($f['IdRequisito']==39  and $f['Clase']==3){
        $idOrigenConyuge = $f['Dato'];
    }
    if($f['IdRequisito']==5  and $f['Clase']==3){
        $fechaNacConyuge = $f['Dato'];
    }
    if($f['IdRequisito']==4  and $f['Clase']==3){
        $sexoConyugue = $f['Dato'];
        if($curpConyuge <>''){
        }
        if($sexoConyugue == 'M'){
            $sexoConyugue = 1;
        }else{
            $sexoConyugue = 2;
        }
    }
    if($f['IdRequisito']==3  and $f['Clase']==3){
        $aMaternoConyuge = $f['Dato'];
    }
    if($f['IdRequisito']==92  and $f['Clase']==3){
        $NCElectorConyuge = $f['Dato'];
    }
    if($f['IdRequisito']==1  and $f['Clase']==3){
        $nombreConyuge = $f['Dato'];
    }
    if($f['IdRequisito']==2  and $f['Clase']==0){
        $aPaternoConyuge = $f['Dato'];
    }
    if($f['IdRequisito']==43  and $f['Clase']==3){
        $rfcConyuge = $f['Dato'];
    }
    if($f['IdRequisito']==6  and $f['Clase']==3){
        $nacionalidadConyuge = $f['Dato'];
        $nacionalidadConyuge = TramiteDatoExtendida($idTramite, 6, 3);
    }
    if($f['IdRequisito']==40  and $f['Clase']==3){
        $lugarNacConyuge= $f['Dato'];
    }

     // DATOS EMPLEO CONYUGE
     if($f['IdRequisito']==51  and $f['Clase']==3){
        $domEmpleoConyuge= $f['Dato'];
    }
    if($f['IdRequisito']==49  and $f['Clase']==3){
        $empresaConyuge= $f['Dato'];
    }
    if($f['IdRequisito']==48  and $f['Clase']==3){
        $ocupacionConyuge= $f['Dato'];
    }
    if($f['IdRequisito']==57  and $f['Clase']==3){
        $prestacionConyuge= $f['Dato'];
    }
    if($f['IdRequisito']==55  and $f['Clase']==3){
        $ingresoMenConyuge= $f['Dato'];
    }
    if($f['IdRequisito']==50  and $f['Clase']==3){
        $numEmpleadoConyuge= $f['Dato'];
    }
    if($f['IdRequisito']==53  and $f['Clase']==3){
        $puestoConyuge= $f['Dato'];
    }
    if($f['IdRequisito']==56  and $f['Clase']==3){
        $telEmpleoConyuge= $f['Dato'];
    }
    if($f['IdRequisito']==47  and $f['Clase']==3){
        $trabajaConyuge= $f['Dato'];
        if($trabajaConyuge == 1){
            $trabajaConyuge='True';
        }else{
            $trabajaConyuge='False';
        }
    }
    if($f['IdRequisito']==54 and $f['Clase']==3){
        $antiguedadConyuge= $f['Dato'];
    }

    //DATOS DOMICILIO
    if($f['IdRequisito']==21 and $f['Clase']==0){
        $calle= $f['Dato'];
    }
    if($f['IdRequisito']==62 and $f['Clase']==0){
        $colonia= $f['Dato'];
    }
    if($f['IdRequisito']==23 and $f['Clase']==0){
        $numInt= $f['Dato'];
    }
    if($f['IdRequisito']==24 and $f['Clase']==0){
        $numExt= $f['Dato'];
    }
    if($f['IdRequisito']==25 and $f['Clase']==0){
        $cp= $f['Dato'];
    }
    if($f['IdRequisito']==26 and $f['Clase']==0){
        $calle1= $f['Dato'];
    }
    if($f['IdRequisito']==27 and $f['Clase']==0){
        $calle2= $f['Dato'];
    }
    if($f['IdRequisito']==61 and $f['Clase']==0){
        $localidad= $f['Dato'];
    }
    if($f['IdRequisito']==60 and $f['Clase']==0){
        $municipio= $f['Dato'];
    }
    if($f['IdRequisito']==58 and $f['Clase']==0){
        $tipocasa= $f['Dato'];
    }
    if($f['IdRequisito']==63 and $f['Clase']==0){
        $otracolonia = $f['Dato'];
    }
    if($f['IdRequisito']==59 and $f['Clase']==0){
        $tiempoVivirahi = $f['Dato'];
    }
    if($f['IdRequisito']==18 and $f['Clase']==0){
        $telefono = $f['Dato'];
    }
    if($f['IdRequisito']==19 and $f['Clase']==0){
        $celular = $f['Dato'];
    }
    if($f['IdRequisito']==66 and $f['Clase']==0){
        $instDictamen= $f['Dato'];
    }
    if($f['IdRequisito']==67 and $f['Clase']==0){
        $fechaDictamen = $f['Dato'];
    }
    if($f['IdRequisito']==68 and $f['Clase']==0){
        $folioDictamen = $f['Dato'];
    }
    if($f['IdRequisito']==65 and $f['Clase']==0){
        $certNoPropiedad = $f['Dato'];
    }
    
    // DATOS EMPLEO SOLICITANTE
    if($f['IdRequisito']==51  and $f['Clase']==0){
        $domEmpleo= $f['Dato'];
    }
    if($f['IdRequisito']==49  and $f['Clase']==0){
        $empresa= $f['Dato'];
    }
    if($f['IdRequisito']==48  and $f['Clase']==0){
        $ocupacion= $f['Dato'];
    }
    if($f['IdRequisito']==57  and $f['Clase']==0){
        $prestacion= $f['Dato'];
    }
    if($f['IdRequisito']==55  and $f['Clase']==0){
        $ingresoMen= $f['Dato'];
    }
    if($f['IdRequisito']==50  and $f['Clase']==0){
        $numEmpleado= $f['Dato'];
    }
    if($f['IdRequisito']==53  and $f['Clase']==0){
        $puesto= $f['Dato'];
    }
    if($f['IdRequisito']==56  and $f['Clase']==0){
        $telEmpleo= $f['Dato'];
    }
    if($f['IdRequisito']==47  and $f['Clase']==0){
        $trabaja= $f['Dato'];
        if($trabaja == 1){
            $trabaja='True';
        }else{
            $trabaja='False';
        }
    }
    if($f['IdRequisito']==54 and $f['Clase']==0){
        $antiguedad= $f['Dato'];
    }

    //ESTADISTICA FONHAPO
    if($f['IdRequisito']==41  and $f['Clase']==0){
        $jefeFamilia= $f['Dato'];
        if($jefeFamilia == 1){
            $jefeFamilia='True';
        }else{
            $jefeFamilia='False';
        }
    }
    if($f['IdRequisito']==46 and $f['Clase']==0){
        $nivelEstudio= $f['Dato'];
    }
    if($f['IdRequisito']==71 and $f['Clase']==0){
        $totalHabVivienda= $f['Dato'];
    }


    


  }

$fechaCaptura = TramiteFechaCaptura($idTramite);
$empleadoCrea =  TramiteNitavuCaptura($idTramite);
$nom = $Nombre.' '.$aPaterno.' '.$aMaterno;
//echo 'Sexo: '.$sexo;
//echo $nipnew;

if($sexo == 1){
    $nipnew = crearIdSolicitante($aPaterno,$aMaterno,$Nombre, $fechaNacimiento, 'M', $idOrigen);
}else{
    $nipnew = crearIdSolicitante($aPaterno,$aMaterno,$Nombre, $fechaNacimiento, 'H', $idOrigen);
}

$IdDelegacionCrea = midelegacion_id($empleadoCrea);
//$IdDelegacionCrea = 6;
$IdTipoTramite = TramiteTipo($idTramite);
$IdPrograma = TramiteIdPrograma($IdTipoTramite);

if($curpConyuge <> ''){
    if($sexoConyugue == 1){
        $idConyuge = crearIdSolicitante($aPaternoConyuge,$aMaternoConyuge,$nombreConyuge, $fechaNacConyuge, 'M', $idOrigenConyuge);
    }else{
        $idConyuge = crearIdSolicitante($aPaternoConyuge,$aMaternoConyuge,$nombreConyuge, $fechaNacConyuge, 'H', $idOrigenConyuge);
    }
}


//echo 'Delegacion CREA '.$IdDelegacionCrea;
//$Folio = IdSiguienteFolio($IdDelegacionCrea, $IdPrograma);
//por default 6 para pruebas
$Folio = IdSiguienteFolio($IdDelegacionCrea, $IdPrograma);
if($fechaNacimiento<>''){
    $edad = CalcularEdad($fechaNacimiento);
}

$edadConyuge="";
if($fechaNacConyuge<>''){
    $edadConyuge = CalcularEdad($fechaNacConyuge);
}

$origenDeEnvio = $IdDelegacionCrea;
//Calle y número
$calleyNum="";
if($numInt <> ''){
    $calleyNum = $calle.' #'.$numExt.' N. int:'.$numInt;
}else{
    $calleyNum = $calle.' #'.$numExt;
}

$nomRef1 = $nombreRef1.' '.$apaternoRef1.' '.$amaternoRef1;
$nomRef2 = $nombreRef2.' '.$apaternoRef2.' '.$amaternoRef2;
//Domicilio referencia
if($ninteriorRef1 <> "" || $ninteriorRef2 <> ""){
    $domRef1 = 'CALLE '.$calleRef1.' NUM. '.$nexteriorRef1.'/'.$ninteriorRef1.'  COLONIA '.$coloniaRef1;
    $domRef2 = 'CALLE '.$calleRef2.' NUM. '.$nexteriorRef2.'/'.$ninteriorRef2.'  COLONIA '.$coloniaRef2;
}else{
    $domRef1 = 'CALLE '.$calleRef1.' NUM. '.$nexteriorRef1.' COLONIA '.$coloniaRef1;
    $domRef2 = 'CALLE '.$calleRef2.' NUM. '.$nexteriorRef2.' COLONIA '.$coloniaRef2;
}

$colonia = explode('_',$colonia);
$localidad = explode('_',$localidad);
$municipio = explode('_',$municipio);
//ECHO 'CALLE Y NUM: '.$calleyNum.'<BR>';
$idColonia = $colonia[0];
$idLocalidad = $localidad[0];
$idMunicipio = $municipio[0];

$dependientes="";

$vuelta = 1;
$sql1 = "SELECT Clase FROM tramitesinformacion WHERE IdTramite=".$idTramite." and Clase in (4,5,6,7,8,9,10,11,12,13) GROUP BY Clase";
$r1 = $conexion -> query($sql1);

if ($r1 -> num_rows >0){
		
    while($f1 = $r1 -> fetch_array()){

        $sql = "SELECT * FROM tramitesinformacion WHERE IdTramite=".$idTramite." and Clase = ".$f1['Clase']."";
        //echo $sql;
        $r = $conexion -> query($sql);

        while($f = $r -> fetch_array()){

            if($f['IdRequisito']==0){
                $curpDep= $f['Dato'];
            }
            if($f['IdRequisito']==47){
                $trabajaDep= $f['Dato'];
                if($trabajaDep == 1){
                    $trabajaDep=1;
                }else{
                    $trabajaDep=0;
                }
            }
            if($f['IdRequisito']==5){
                $fechaNacDep = $f['Dato'];
            }
            if($f['IdRequisito']==4){
                $sexoDep = $f['Dato'];
                if($sexoDep == 'M'){
                    $sexoDep  = 1;
                }else{
                    $sexoDep  = 2;
                }
            }
            if($f['IdRequisito']==3){
                $amaternoDep = $f['Dato'];
            }
            if($f['IdRequisito']==1){
                $nombreDep = $f['Dato'];
            }
            if($f['IdRequisito']==2){
                $apaternoDep = $f['Dato'];
            }
            if($f['IdRequisito']==55){
                $ingresoDep = $f['Dato'];
            }
            if($f['IdRequisito']==96){
                $parentescoDep = $f['Dato'];
            }
            if($fechaNacDep <> ""){
                $edadDep = CalcularEdad($fechaNacDep);
            }
        }


        $numDep = $vuelta;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
        $dependientes = $dependientes."$IdDelegacionCrea, $IdPrograma,$Folio,$numDep,$edadDep,$sexoDep,$ingresoDep, $amaternoDep, $nombreDep, $parentescoDep,$apaternoDep,$trabajaDep,1,$fechaCaptura, $empleadoCrea, 0, $fechaNacDep, $curpDep, 0, 0, 0, $origenDeEnvio, *";
        $vuelta = $vuelta + 1;
    }
}

//echo "'".$dependientes."'".'<br><br>';

//echo 'Folio-'.$Folio;

if(is_numeric($Folio)){
//if(is_numeric(IdSiguienteFolio($IdDelegacionCrea, $IdPrograma))){

    $consulta = "DECLARE @RESULTADO INT;
    exec registrarSolicitudDesdePlataforma '$idsolicitante','$origenDeEnvio', '$curp','$fechaCaptura','$fechaNacimiento', '$empleadoCrea',
    '$idOrigen','$sexo','$aMaterno', '$NCElector','$Nombre', '$aPaterno','$rfc','$nom','$nipnew','$nacionalidad',
    '$lugarNacimiento','$IdDelegacionCrea', '$IdPrograma','$Folio','$cantidadDestinable','$domRef1','$egresoMensual',
    '$estadoCivil','$nomRef1','$otrasPropiedades','$telRef1', '$gastoLuz','$gastoAgua', '$gastoTel',
    '$gastoAlimentos','$gastoTransporte','$otrosGastos', '$gastoEducacion', '$nomRef2', '$domRef2', '$telRef2',
    '$edad', '$munDondeSeRequiereLote','$ahorroPrevio','$regConyugal', '$tipoIdentificacion', '$secYCat', '$correo', '$oficioTarjetaAut', '$facebook', '$twitter', '$telFamDirecto','$curpConyuge','$fechaNacConyuge','$idConyuge','$idOrigenConyuge','$sexoConyugue','$aMaternoConyuge', '$NCElectorConyuge', '$nombreConyuge', '$aPaternoConyuge', '$rfcConyuge', '$nacionalidadConyuge', '$edadConyuge','$lugarNacConyuge', '$domEmpleoConyuge','$empresaConyuge','$ocupacionConyuge', '$prestacionConyuge', '$ingresoMenConyuge','$numEmpleadoConyuge', '$puestoConyuge','$telEmpleoConyuge','$antiguedadConyuge','$trabajaConyuge','$calle1','$calle2','$calleyNum','$idColonia','$idLocalidad','$idMunicipio','$tipocasa','$numExt','$numInt','$otracolonia', '$telefono', '$tiempoVivirahi', '$cp','$celular','$instDictamen','$fechaDictamen','$folioDictamen','$certNoPropiedad','$domEmpleo','$empresa','$ocupacion', '$prestacion','$ingresoMen','$numEmpleado', '$puesto','$telEmpleo','$antiguedad','$trabaja','$jefeFamilia','$nivelEstudio','$totalHabVivienda', '$dependientes', @RESULTADO output;
    SELECT @RESULTADO as Resultado;";
	$Usuario = $nitavu; // Usuario que la Ejecutara
	$DescripcionDeUso = "Test"; // en que programa o uso
    //echo $consulta;

   
   $ConsultaDATA = DatosViviendaLarge($IdDelegacionCrea, $Usuario, $DescripcionDeUso, $consulta);
   if ($ConsultaDATA == TRUE){
    //echo $ConsultaDATA;
    $array = json_decode($ConsultaDATA, true);
    if(is_array($array)){

        foreach ($array as $value) {
            if (isset($value['r'])){// si hay un error
                echo "Error: ".$value['r'];

            } else {
                //Se obtenien las variables $value['campo'] de acuerdo a la consulta
                //echo "SQL = ".$consulta."<br>";
                //echo "Respuesta:".$value['Resultado']."<br>";
                if($value['Resultado']==0){
                    historia($nitavu, "Guarde los datos en vivienda del tramite ".$idTramite."");
                    $sql = "UPDATE tramites SET FolioVivienda='$Folio', Estado = 1 WHERE IdTramite=".$idTramite ."";
                    if ($conexion->query($sql) == TRUE) {
                        historia($nitavu, "Actualice el folio de vivienda en el tramite ".$idTramite."");
                        echo 'Informacion guardada con éxito en vivienda.';  
                        echo 'Se ha enviado el tramite';  
                        $Continuo='TRUE';
                    }   
                    else {
                        historia($nitavu, "No se actualizo el folio de vievienda en el tramite ".$idTramite.", su folio es: ".$folio."");
                        echo 'ERROR: No se ha podido actulizar el folio en el trámite.';
                    }                                                                 
                    

                }else if($value['Resultado']==1){
                    echo 'ERROR: No se guardaron los datos del solicitante.';  
                    historia($nitavu, "No se guardaron los datos solicitante en el tramite ".$idTramite."-consulta: ".$consulta."");                                                                 
                    $Continuo='FALSE';
                }
                else if($value['Resultado']==2){
                    echo 'ERROR: No se guardaron los datos de la solicitud.';         
                    historia($nitavu, "No se guardaron los datos de la solicitud en el tramite ".$idTramite."-consulta: ".$consulta."");                                                                 
                                                          
                    $Continuo='FALSE';
                }else if($value['Resultado']==3){
                    echo 'ERROR: No se guardaron los datos del conyuge.'; 
                    historia($nitavu, "No se guardaron los datos del conyugeen el tramite ".$idTramite."-consulta: ".$consulta."");                                                                 
                                                                  
                    $Continuo='FALSE';
                }else if($value['Resultado']==4){
                    echo 'ERROR: No se guardaron los datos empleo conyuge.';
                    historia($nitavu, "No se guardaron los datos empleo conyuge en el tramite ".$idTramite."-consulta: ".$consulta."");                                                                 
                                                                   
                    $Continuo='FALSE';
                }else if($value['Resultado']==5){
                    echo 'ERROR: No se guardaron los datos del domicilio.';       
                    historia($nitavu, "No se guardaron los datos del domicilio en el tramite ".$idTramite."-consulta: ".$consulta."");                                                                 
                                                            
                    $Continuo='FALSE';
                }else if($value['Resultado']==6){
                    echo 'ERROR: No se guardaron los datos del empleo solicitante.';       
                    historia($nitavu, "No se guardaron los datos del empleo solicitante en el tramite ".$idTramite."-consulta: ".$consulta."");                                                                 
                                                            
                    $Continuo='FALSE';
                }else if($value['Resultado']==7){
                    echo 'ERROR: No se guardaron los datos de la vivienda.';  
                    historia($nitavu, "No se guardaron los datos de la vivienda en el tramite ".$idTramite."-consulta: ".$consulta."");                                                                 
                                                                 
                    $Continuo='FALSE';
                }else if($value['Resultado']==8){
                    echo 'ERROR: No se guardaron los datos estadistica fonhapo.';   
                    historia($nitavu, "No se guardaron los datos estadistica fonhapoen el tramite ".$idTramite."-consulta: ".$consulta."");                                                                 
                                                                
                    $Continuo='FALSE';
                }else if($value['Resultado']==9){
                    echo 'ERROR: No se guardaron los datos evualuación.';     
                    historia($nitavu, "No se guardaron los datos evualuaciónen el tramite ".$idTramite."-consulta: ".$consulta."");                                                                 
                                                              
                    $Continuo='FALSE';
                }else if($value['Resultado']==10){
                    echo 'ERROR: No se guardaron los datos de dependientes.'; 
                    historia($nitavu, "No se guardaron los datos de dependientes en el tramite ".$idTramite."-consulta: ".$consulta."");                                                                 
                                                                  
                    $Continuo='FALSE';
                }else if($value['Resultado']==11){
                    echo 'ERROR: Ya existe un registro con estos datos.';    
                    historia($nitavu, " Ya existe un registro con estos datos".$idTramite."-consulta: ".$consulta."");                                                                                                                                
                    $Continuo='FALSE';
                }
            

            }
            
        }
    } else {
        historia($nitavu, " ERROR: No es posible construir los datos:".$idTramite."-consulta: ".$ConsultaDATA."");                                                                                                                                
        echo "ERROR: No es posible construir los datos: ".$ConsultaDATA;
    }
   } else { //sin coneccion
    historia($nitavu, " ERROR: no hay conexión a esta Delegación:".$IdDelegacionCrea."");                                                                                                                                
    // que hacer aqui sino hay conexion;
    echo "ERROR: no hay conexión a esta Delegación";

   }
}else{
    historia($nitavu, " ERROR: No tengo folio para poder realizar el trámite:".$idTramite."");                                                                                                                                
    echo "ERROR: No tengo folio para poder realizar el trámite";
}


?>