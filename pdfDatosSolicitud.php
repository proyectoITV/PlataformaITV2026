<?php
error_reporting(0);
require("config.php");
require_once('pdf/tcpdf.php');
require_once('seguridad.php');
require_once('lib/funciones.php');
require('lib/flor_funciones.php');


    if(isset($_GET['IdPrograma']) and isset($_GET['IdDelegacion']) and isset($_GET['Folio'])){

    $IdPrograma = $_GET['IdPrograma'];
    $IdDelegacion = $_GET['IdDelegacion'];
    $Folio = $_GET['Folio'];
    $OriginData = $_GET['OriginData'];
    // echo "nitavu=".$nitavu;
    
        // lo da en blanco cuando hubo algun problema, validarlo siempre
       
        
            if(buscaSolicitud($IdPrograma, $IdDelegacion, $Folio)==0){
                mensaje_html('No se encontra una solicitud con Folio '.$Folio.'. <b>Revise Por Favor</b>');
                Problema_create('PDF Solicitud', 'No encontro la solicitud Folio='.$Folio.', IdPrograma = '.$IdPrograma.', IdDelegacion='.$IdDelegacion.' y OriginData='.$OriginData, $nitavu, $IdApp = "v001");
                
            }else{

                $t = "";

                $IdSolicitante = buscarIdSolicitante($IdPrograma, $IdDelegacion, $Folio);
                
                echo "<br><br><br>";
                


                //FORMATO SOLICITUD- TARJETA DE PRESENTACION
                if(solicitudCancelada($IdPrograma, $IdDelegacion, $Folio)==1){
                    $t=$t.'<table class="tarjeta" style="font-family:Verdana;background-image: url(img/cancelado.png);
                    background-size: cover;">';
                    
                }else{
                    $t=$t.'<table class="tarjeta" style="font-family:Verdana;">';
                }
                
                    $t=$t.'<tr align="center" style="background-color:#9C9FA0;"><td colspan="4"><span style="font-size:15px; color:#fff;"><center>DATOS DE LA SOLICITUD</center></span></td></tr>';

                    $t=$t.'<tr style="border-bottom: 1px solid #ccc; font-size:15px;"><td colspan="4">
                    <span style="color:#9C9FA0;"> Programa: </span> <span style="color:#E3D79F;">'.nombreProgramaVivienda($IdPrograma).'</span>
                    <br><span style="color:#9C9FA0;"> Delegación: </span><span style="color:#E3D79F;">'.nombreDelegacionVivienda($IdDelegacion).'</span>
                    <br><span style="color:#9C9FA0;"> Folio: </span><span style="color:#E3D79F;">'.$Folio.'</span>
                    <br><span style="color:#9C9FA0;"> Beneficiario: </span> <span style="color:#E3D79F;">'.nombreBeneficiarioVivienda($IdSolicitante).'</span>
                    <br><span style="color:#9C9FA0; font-size:10px;"><b> DOI:'.$OriginData.'</b></span>';
                    $t=$t.'</td></tr>';
                    
                    
                    $t=$t.'<tr align="center" style="background-color:#9C9FA0;"><td colspan="4"><span style="font-size:15px; color:#fff;"><center>DATOS BENEFICIARIO</center></span></td></tr>';
                    $t=$t.'<tr><td>
                    <span style="font-size:12px; color:#9C9FA0;"> 
                        Sexo:<br>
                        Fecha de Nacimiento:<br>
                        Nacionalidad:<br>
                        Origrinario de:<br>
                        Ciudad de Nacimiento:<br>
                        Es jefe de Familia:<br>
                        Correo electrónico: <br>
                        Facebook: <br>
                        Twitter: <br>
                    </span>        
                    </td>
                    <td>
                    <span style="font-size:12px; color:#3E9CD1;"> 
                        '.sexoBeneficiarioVivienda($IdSolicitante).'<br>
                        '.date_format( date_create(fechaNacimientoBeneficiarioVivienda($IdSolicitante)), 'd/m/Y') .'<br>
                        '.nacionalidadBeneficiarioVivienda($IdSolicitante).'<br>
                        '.originarioDeBeneficiarioVivienda($IdSolicitante).'<br>
                        '.ciudadNacimientoBeneficiarioVivienda($IdSolicitante).'<br>
                        '.jefeFamiliaBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.emailBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.facebookBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.twitterBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                    </span>  
                    </td>
                    <td>
                    <span style="font-size:12px; color:#9C9FA0;"> 
                        Estado Civil:<br>
                        Regimen Conyugal:<br>
                        RFC:<br>
                        CURP:<br>
                        Tipo de Identificación:<br>
                        NIP:<br>
                        Grado/Nivel de Estudio:<br>
                        Oficio ó Tarjeta de autorización:<br>
                        Teléfono o celular:<br>
                        Teléfono familiar directo: 
                    </span>  
                    </td>
                    <td>
                    <span style="font-size:12px; color:#3E9CD1;"> 
                        '.estadoCivilBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.regimenConyugalBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.rfcBeneficiarioVivienda($IdSolicitante).'<br>
                        '.curpBeneficiarioVivienda($IdSolicitante).'<br>
                        '.tipoIdentificacionBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.$IdSolicitante.'<br>
                        '.gradoDeEstudioBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.oficioAutorizacionBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.telefonoBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.telefonoFamDirectoBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
            
                    </span>  
                    </td>
                    </tr>';
                    $t=$t.'<tr align="center" style="background-color:#9C9FA0;"><td colspan="4"><span style="font-size:15px; color:#fff;">DATOS LABORALES</span></td></tr>';
                    $t=$t.'<tr><td>
                    <span style="font-size:12px; color:#9C9FA0;"> 
                        Trabaja:<br>
                        Ocupación:<br>
                        Empresa:<br>
                        Número de empleado:<br>
                        Domicilio:<br>
                        Relación Laboral:<br>
                    </span>        
                    </td>
                    <td>
                    <span style="font-size:10px; color:#3E9CD1;"> 
                        '.trabajaBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.ocupacionBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.empresaBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.numEmpleadoBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.domicilioLaboralBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.relacionLaboralBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                    </span>  
                    </td>
                    <td>
                    <span style="font-size:12px; color:#9C9FA0;"> 
                        Puesto:<br>
                        Antiguedad:<br>
                        Ingreso Mensual:<br>
                        Teléfono:<br>
                        Prestación:<br>
                    </span>  
                    </td>
                    <td>
                    <span style="font-size:12px; color:#3E9CD1;"> 
                        '.puestoBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.antiguedadEmpleoBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        $'.number_format(ingresoMensualBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio),2,'.',',').'<br>
                        '.telefonoEmpleoBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                        '.prestacionEmpleoBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio).'<br>
                       </span>  
                    </td>
                    </tr>';
                 
            
                //SI TIENE CONYUGE
                if(idEstadoCivilBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio) == 1  || idEstadoCivilBeneficiarioVivienda($IdDelegacion,$IdPrograma,$Folio) == 5){

                    $t = $t. '<tr align="center" style="background-color:#9C9FA0;"><td colspan="4"><span style="font-size:15px; color:#fff;"><center>DATOS CÓNYUGE</center></span></td></tr>';
                    $t = $t. '<tr><td>
                    <table style="font-size:12px; color:#9C9FA0;">
                        <tr><td>Nombre:</td></tr>
                        <tr><td>Sexo:</td></tr>
                        <tr><td>Fecha de Nacimiento:</td></tr>
                        <tr><td>Origrinario de:</td></tr>
                    </table>     
                    </td>
                    <td>
                    <table style="font-size:12px; color:#3E9CD1;">
                        <tr><td style="font-size:9px;">'.nombreConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                        <tr><td>'.sexoConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                        <tr><td>'.date_format( date_create(fechaNacimientoConyugeVivienda($IdDelegacion,$IdPrograma,$Folio)), 'd/m/Y').'</td></tr>
                        <tr><td>'.originarioDeConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    </table>  
                    </td>
                    <td>
                    <table style="font-size:12px; color:#9C9FA0;"> 
                        <tr><td>RFC:</td></tr>
                        <tr><td>CURP:</td></tr>
                        <tr><td>Credencial de Elector:</td></tr>
                        <tr><td>NIP:</td></tr>
                    </table>  
                    </td>
                    <td>
                    <table style="font-size:12px; color:#3E9CD1;">
                        <tr><td>'.rfcConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                        <tr><td>'.curpConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                        <tr><td>'.credencialElectorConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                        <tr><td>'.nipConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    </table> 
                    </td>
                    </tr>';
                    $t = $t. '<tr align="center" style="background-color:#9C9FA0;"><td colspan="4"><span style="font-size:15px; color:#fff;"><center>DATOS LABORALES</center></span></td></tr>';
                    $t = $t. '<tr><td>
                    <table style="font-size:12px; color:#9C9FA0;">
                        <tr><td>Trabaja:</td></tr>
                        <tr><td>Ocupación:</td></tr>
                        <tr><td>Empresa:</td></tr>
                        <tr><td>Número de empleado:</td></tr>
                        <tr><td>Domicilio:</td></tr>
                        <tr><td>Relación Laboral:</td></tr>
                    </table>      
                    </td>
                    <td>
                    <table style="font-size:12px; color:#3E9CD1;">
                        <tr><td>'.trabajaConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                        <tr><td>'.ocupacionConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                        <tr><td>'.empresaConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                        <tr><td>'.numEmpleadoConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                        <tr><td>'.domicilioLaboralConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                        <tr><td>'.relacionLaboralConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    </table> 
                    </td>
                    <td>
                    <table style="font-size:12px; color:#9C9FA0;">
                        <tr><td>Puesto:</td></tr>
                        <tr><td>Antiguedad:</td></tr>
                        <tr><td>Ingreso Mensual:</td></tr>
                        <tr><td>Teléfono:</td></tr>
                        <tr><td>Prestación:</td></tr>
                    </table>   
                    </td>
                    <td>
                    <table style="font-size:12px; color:#3E9CD1;">
                        <tr><td>'.puestoConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                        <tr><td>'.antiguedadEmpleoConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                        <tr><td>$'.number_format(ingresoMensualConyugeVivienda($IdDelegacion,$IdPrograma,$Folio),2,'.',',').'</td></tr>
                        <tr><td>'.telefonoEmpleoConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                        <tr><td>'.prestacionEmpleoConyugeVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    </table>
                    </td>
                    </tr>';
                  
                  
                }
                

                $t = $t. '<tr align="center" style="background-color:#9C9FA0;"><td colspan="4"><span style="font-size:15px; color:#fff;"><center>DOMICILIO DONDE RESIDE</center></span></td></tr>';
                $t = $t. '<tr><td>
                <table style="font-size:12px; color:#9C9FA0;">
                    <tr><td>Domicilio (Segun INE):</td></tr>
                    <tr><td>Entre Calle:</td></tr>
                    <tr><td>Y Calle:</td></tr>
                    <tr><td>Ciudad:</td></tr>
                    <tr><td> Localidad: </td></tr>
                    <tr><td> Colonia: </td></tr>
                    <tr><td>Otra Colonia:</td></tr>
                </table>       
                </td>
                <td>
                <table style="font-size:12px; color:#3E9CD1;">
                    <tr><td style="font-size:10px;">'.domicilioINEVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td style="font-size:11px;">'.calle1Vivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td style="font-size:11px;">'.calle2Vivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td>'.ciudadVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td>'.localidadVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td>'.coloniaVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td>'.otraColoniaVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                </table>  
                </td>
                <td>
                <table style="font-size:12px; color:#9C9FA0;"> 
                    <tr><td>Número Exterior:</td></tr>
                    <tr><td>Número Interior:</td></tr>
                    <tr><td>Sector y Categoría:</td></tr>
                    <tr><td>Clave del certificado de NO propiedad:</td></tr>
                    <tr><td>Municipio donde se requiere el lote: </td></tr>
                    <tr><td>Personas que habitaran el lote: </td></tr>
                </table>    
                </td>
                <td>
                <table style="font-size:12px; color:#3E9CD1;">
                    <tr><td>'.numeroExteriorVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td>'.numeroInteriorVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td>'.sectoryCategoriaVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td>'.claveCertificadoVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td>'.municipioDondeQuiereLoteVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td>'.personasHabitaranLoteVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                </table> 
                </td>
                </tr>';
                $t = $t. '<tr>
                <td colspan="2" align="right">
                <table style="font-size:12px; color:#9C9FA0;">
                    <tr><td>Institución que otorga DICTAMEN DE RIESGO:</td></tr>
                    <tr><td>Fecha de emisión del DICTAMEN:</td></tr>
                    <tr><td>Número de folio del DICTAMEN de riesgo</td></tr>
                    
                </table>       
                </td>
                <td colspan="2">
                <table style="font-size:12px; color:#3E9CD1;">
                    <tr><td>'.institucionDictamenVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td>'.fechaEmisionDictamenVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td>'.folioDictamenVivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    
                </table>  
                </td>
                </tr>';

                $t = $t. '<tr align="center" style="background-color:#9C9FA0;"><td colspan="4"><span style="font-size:15px; color:#fff;"><center>DATOS REFERENCIAS</center></span></td></tr>';
                $t = $t. '<tr align="center" style="font-size:15px; color:#9C9FA0;"><th colspan="2">Referencia 1</th><th colspan="2"> Referencia 2</th></tr>';
                $t = $t. '<tr><td width="80px">
                <table style="font-size:10px; color:#9C9FA0;">
                    <tr><td >Nombre:</td></tr>
                    <tr><td >Domicilio:</td></tr>
                    <tr><td >Teléfono:</td></tr>
                </table>     
                </td>
                <td width="250px">
                <table style="font-size:12px; color:#3E9CD1;">
                    <tr><td align="left" style="font-size:10px;">'.nombreReferencia1Vivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td align="left" style="font-size:10px;">'.domicilioReferencia1Vivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                    <tr><td align="left" >'.telefonoReferencia1Vivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                </table>  
                </td>
                <td width="80px" >
                <table style="font-size:10px; color:#9C9FA0;"> 
                    <tr><td >Nombre:</td></tr>
                    <tr><td >Domicilio:</td></tr>
                    <tr><td >Teléfono:</td></tr>
                </table>  
                </td>
                <td width="250px" >
                <table style="font-size:12px; color:#3E9CD1;">
                <tr><td style="font-size:10px;">'.nombreReferencia2Vivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                <tr><td style="font-size:10px;">'.domicilioReferencia2Vivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                <tr><td >'.telefonoReferencia2Vivienda($IdDelegacion,$IdPrograma,$Folio).'</td></tr>
                </table> 
                </td>
                </tr>';


                if(tieneDependientes($IdDelegacion,$IdPrograma,$Folio) > 0){
                    $t = $t.'<tr align="center" style="background-color:#9C9FA0;"><td colspan="4"><span style="font-size:15px; color:#fff;"><center>DATOS DEPENDIENTES</center></span></td></tr>';
                    $sql = 'Select * from datosdependientes WHERE IdDelegacion ="'.$IdDelegacion.'" and IdPrograma="'.$IdPrograma.'" and Folio="'.$Folio.'"';
                    $r = $Vivienda -> query($sql);
                    if ($r -> num_rows >0)
                    {
                        $vuelta = 0;
                        while($f = $r -> fetch_array())
                        { // resultado de la busqueda.................
                            $vuelta += 1;
                            $edad = '';
                           /* if($f['DepFechaNac']<>'' OR $f['DepFechaNac']<>'0000-00-00 00:00:00'){
                                $fechaNac = $f['DepFechaNac'];
                                $edad = CalcularEdad($f['DepFechaNac']);
                            }else{
                                $fechaNac = 'NO CAPTURADO';
                                $edad = 'NO CAPTURADO';
                            }*/

                          /*  $fechaNac = $f['DepFechaNac'];
                            $edad = CalcularEdad($f['DepFechaNac']);*/

                            if($f['DepFechaNac']== '' OR $f['DepFechaNac']=='0000-00-00 00:00:00'){
                                $fechaNac = 'NO CAPTURADO';
                                $edad = 'NO CAPTURADO';
                                
                            }else{
                                $fechaNac = $f['DepFechaNac'];
                                $fechaNac = date_format( date_create($fechaNac), 'd/m/Y');
                                $edad = CalcularEdad($f['DepFechaNac']);
                            }


                            $trabaja = '';
                            if($f['DepTrabaja']==1){
                                $trabaja = 'SI';
                            }else{
                                $trabaja = 'NO';
                            }
                            $t = $t. '<tr style="font-size:12px; color:#9C9FA0;"><th colspan="4">Dependiente '.$vuelta.'</th></tr>';
                            $t = $t. '<tr><td width="150px;">
                            <table style="font-size:12px; color:#9C9FA0;">
                                <tr><td >Nombre:</td></tr>
                                <tr><td >Fecha Nacimiento:</td></tr>
                                <tr><td >Edad:</td></tr>
                            </table>     
                            </td>
                            <td width="150px;">
                            <table style="font-size:12px; color:#3E9CD1;">
                                <tr><td style="font-size:9px;">'.$f['DepNombre'].' '.$f['DepPaterno'].' '.$f['DepMaterno'].'</td></tr>
                                <tr><td>'.$fechaNac.'</td></tr>
                                <tr><td>'.$edad.'</td></tr>
                            </table>  
                            </td>
                            <td width="150px;">
                            <table style="font-size:12px; color:#9C9FA0;"> 
                                <tr><td>Sexo:</td></tr>
                                <tr><td>Trabaja:</td></tr>
                                <tr><td>Ingreso Mensual:</td></tr>
                            </table>  
                            </td>
                            <td width="150px;">
                            <table style="font-size:12px; color:#3E9CD1;">
                            <tr><td>'.sexoDependienteVivienda($f['DepIdSexo']).'</td></tr>
                            <tr><td>'.$trabaja.'</td></tr>
                            <tr><td>$'.number_format($f['DepIngreso'],2,'.',',').'</td></tr>
                            </table> 
                            </td>
                            </tr>';
                        }
                    }
                }

                $t = $t. '<tr align="center" style="background-color:#9C9FA0;"><td colspan="4"><span style="font-size:15px; color:#fff;"><center>INFORMACIÓN ECONÓMICA</center></span></td></tr>';
                $t = $t. '<tr><td>
                <table style="font-size:12px; color:#9C9FA0;">
                    <tr><td>Gasto alimentos:</td></tr>
                    <tr><td>Gasto agua:</td></tr>
                    <tr><td>Gasto luz:</td></tr>
                    <tr><td>Gasto Teléfono:</td></tr>
                    <tr><td> Ingreso Neto: </td></tr>
                   
                </table>       
                </td>
                <td>
                <table style="font-size:12px; color:#3E9CD1;">
                    <tr><td>$'.number_format(gastoAlimentosVivienda($IdDelegacion,$IdPrograma,$Folio),2,'.',',').'</td></tr>
                    <tr><td>$'.number_format(gastoAguaVivienda($IdDelegacion,$IdPrograma,$Folio),2,'.',',').'</td></tr>
                    <tr><td>$'.number_format(gastoLuzVivienda($IdDelegacion,$IdPrograma,$Folio),2,'.',',').'</td></tr>
                    <tr><td>$'.number_format(gastoTelefonoVivienda($IdDelegacion,$IdPrograma,$Folio),2,'.',',').'</td></tr>
                    <tr><td>$'.number_format(ingresoNetoVivienda($IdDelegacion,$IdPrograma,$Folio),2,'.',',').'</td></tr>
                   
                </table>  
                </td>
                <td>
                <table style="font-size:12px; color:#9C9FA0;"> 
                    <tr><td>Transporte:</td></tr>
                    <tr><td>Educación:</td></tr>
                    <tr><td>Otros gastos:</td></tr>
                    <tr><td>Egreso mensual:</td></tr>
                    <tr><td>Cantidad a pagar: </td></tr>
                   
                </table>    
                </td>
                <td>
                <table style="font-size:12px; color:#3E9CD1;">
                    <tr><td>$'.number_format(gastoTransporteVivienda($IdDelegacion,$IdPrograma,$Folio),2,'.',',').'</td></tr>
                    <tr><td>$'.number_format(gsatoEducacionVivienda($IdDelegacion,$IdPrograma,$Folio),2,'.',',').'</td></tr>
                    <tr><td>$'.number_format(otrosGastosVivienda($IdDelegacion,$IdPrograma,$Folio),2,'.',',').'</td></tr>
                    <tr><td>$'.number_format(egresoMensualVivienda($IdDelegacion,$IdPrograma,$Folio),2,'.',',').'</td></tr>
                    <tr><td>$'.number_format(cantidadaPagarVivienda($IdDelegacion,$IdPrograma,$Folio),2,'.',',').'</td></tr>
                   
                </table> 
                </td>
                </tr>';

                $t = $t. '</table>';
                $t = $t. "</div>";
                
                        
                //creacion del pdf
                $html=$t;
                //echo $tabla;


                $TAG = "Solicitud_".$OriginData."_".$IdDelegacion."_".$IdProrgama."_".$Folio;
                $DescripcionDelArchivo = " Solicitud ".$TAG;
                $PDF_Titulo = "DATOS DE LA SOLICITUD";
                $PDF_SubTitulo = "Folio:".$Folio.", IdPrograma = ".$IdPrograma.",IdDelegaicon=".$IdDelegacion.", OriginData=".$OriginData;
                // $PDF_SubTitulo = "";     
                $FechaDocumento = "".fecha_larga($fecha);
                $Persona = "";
                include("_print_header.php");
                //-------------------------


                            
                // $html = 'Empleado: ('.$f['NEmpleado'].')<b>'.$f['Empleado'].'</b> <br><cite style="font-size:10px;">'.nitavu_puesto($f['NEmpleado']).', '.nitavu_dpto_nombre($f['NEmpleado']).'</cite><br><br>';

             

                // echo $html;

                //Footer del Generador de PDF
                include("_print_footer.php");

                // $orientacion='P';
                // $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                // // set document information
                // $pdf->SetCreator(PDF_CREATOR);
                // $pdf->SetKeywords('Reporte ITAVU');
                // $pdf->SetHeaderData('pdf_logo.jpg', '40','', '');
                // //$link = "http://".$urlnueva[1]."/mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."";
                // //$link = "www.localhost:81\mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."";
                // //$img = file_get_contents('C:\pdz-server\htdocs\img\regreso.png');
                // $img = file_get_contents('img/regreso.png');
                // //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');
                // // set header and footer fonts
                // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                // // set default monospaced font
                // $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
                // // set margins
                // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                // $pdf->SetFooterData("Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu),array(0, 64, 0),array(0, 64, 128));
                // // $pdf->SetFooterData('c', 0, 'xd', 'hola');
                // // set auto page breaks
                // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                // // set image scale factor
                // $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                // // set some language-dependent strings (optional)
                // if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
                //     require_once(dirname(__FILE__).'pdf/lang/eng.php');
                //     $pdf->setLanguageArray($l);
                // }
                // // set font
                // $pdf->SetFont('helvetica', '', 9);
                // // add a page
                // $pdf->AddPage($orientacion, 'LETTER');
                // //$pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');
                // //$pdf->AddPage($orientacion); //en la tabla de reporte L o P
                // $html = $tabla;
                // //echo $html; aqui escribe el contenido de la consulta
                    
                // $pdf->writeHTML($html, true, false, true, false, '');

                // // reset pointer to the last page
                // $pdf->lastPage();
                // //Close and output PDF document}
                // ob_end_clean();
                // $pdf->Output('reporte.pdf', 'I');
                // MiToken_Close($nitavu, $HayToken); //Cierro el Token


            } 

           
           
           

        }



   


?>
