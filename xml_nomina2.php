<?php
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

$id_aplicacion ="ap63"; //ap07=Permisos de Aplicacion
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$yo = $nitavu;

if (sanpedro($id_aplicacion, $nitavu)==TRUE){echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
historia($nitavu,"Entro al modulo para subir xml de nomina a la plataforma");
echo "<div id='indicadores'>";
echo '
<form name="form1" id="form1" method="post" action="xml_nomina2.php" enctype="multipart/form-data">						
						<h4 class="text-center">Cargar Archivos XML de la nomina a distribuir</h4>						
							<label class="col-sm-2 control-label">Archivos</label>
							<span class="col-sm-8">
								<input type="file" class="form-control" id="archivo[]" name="archivo[]" multiple="">
							</span>
							
                            <div><input type="submit" name="subirxmls" class="Mbtn btn-default" value="Cargar"></div>
                            <div><a href="xml_nomina2.php?xmlReset=" class="Mbtn btn-cancel">Reiniciar carga </a></div>
						
						
</form>';
if (isset($_GET['xmlReset'])){
    //borrar el contenido del directorio xml/nomina
    $files = glob('xml/nomina/*'); //obtenemos todos los nombres de los ficheros
    $eliminados=0;
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
        $eliminados = $eliminados +1;
    }
    historia($nitavu,"Reseteo la carga de archivos xml, preparados para la integración de la nomina a la plataforma");
    mensaje("Se han eliminado ".$eliminados." archivos elegidos para integrarse a la plataforma",'xml_nomina2.php' );
}
if (isset($_POST['subirxmls'])){
    $quienEnvia = titular('57'); //Titular de Contabilidad
    $mensaje = "<p> Este es un mensaje automatico: </p><p>Se ha detectado que estan subiendo la nomina a la plataforma</p>";
    notificacion_add($quienEnvia, 'Estoy subiendo nomina a la plataforma', $fecha, $nitavu, $mensaje);
    
    $quienEnvia = titular('58'); //Titular de Contabilidad
    $mensaje = "<p> Este es un mensaje automatico: </p><p>Se ha detectado que estan subiendo la nomina a la plataforma</p>";
    notificacion_add($quienEnvia, 'Estoy subiendo nomina a la plataforma', $fecha, $nitavu, $mensaje);
    

    $quienEnvia = titular('55'); //Titular de Contabilidad
    $mensaje = "<p> Este es un mensaje automatico: </p><p>Se ha detectado que estan subiendo la nomina a la plataforma</p>";
    notificacion_add($quienEnvia, 'Estoy subiendo nomina a la plataforma', $fecha, $nitavu, $mensaje);
    

    //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores

	foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
	{
		//Validamos que el archivo exista
		if($_FILES["archivo"]["name"][$key]) {
			$filename = $_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo
			$source = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
			
			$directorio = 'xml/nomina'; //Declaramos un  variable con la ruta donde guardaremos los archivos
			
			//Validamos si la ruta de destino existe, en caso de no existir la creamos
			// if(!file_exists($directorio)){
			// 	mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
			// }
			
			$dir=opendir($directorio); //Abrimos el directorio de destino
			$target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
			
			//Movemos y validamos que el archivo se haya cargado correctamente
			//El primer campo es el origen y el segundo el destino
			if(move_uploaded_file($source, $target_path)) {	
                historia($nitavu,"Subio al directorio xml|nomina, en el servidor de la plataforma el archivo ".$filename."");
				//echo "El archivo $filename se ha almacenado en forma exitosa.<br>";
				} else {	
				echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
			}
			closedir($dir); //Cerramos el directorio de destino
		}
    }
}
echo "</div>";

echo "<div id='indicadores'>";
echo "<a href='xml_nomina2.php?integrar=' class='Mbtn btn-default'>Integrar Nomina </a>";
echo "</div>";
$msg="REVISE la informacion que se le presenta antes de Integrar. Al dar clic en integrar, la plataforma enviara un correo electronico al empleado informandole que ya esta listo su recibo de nomina para que lo pueda descargar";
echo sugerencia($msg);


$directorio='xml/nomina';
if(is_dir($directorio)){ //comprueba que $carpeta sea un directorio					
    if($dir = opendir($directorio)){//abre el directrio		
        $c=0; $archivo_uso="";
        echo "<hr><div id='xmlLista'> <h1>Contenido XML listo para integrarse a la plataforma:</h1><table class='tabla' width=100%>";
        echo "<th>Foto</th>";
        echo "<th>Descripcion</th>";       
        echo "<th>Deducciones</th>";
        echo "<th>Percepciones</th>";
        echo "<th>Subtotales</th>";
        $x=0;
  
        while(($archivo = readdir($dir)) !== false){
            if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess')
				{
                    //echo $archivo."<br>";
                    $c=$c+1;
                    $archivo_uso = $archivo;
                    $archivo_xml = $directorio."/".$archivo_uso;
                    $x = XML_nomina($archivo_xml, $x, $nitavu); //Llenado de la Tabla y generacion de Variables
                    
                }
        
                
        }
    
        echo "</table>";
        echo "<h3>".$c." archivos XML encontrados</h3>";
        echo "</div>";
        if (isset($_GET['integrar'])){// si se integro, este es el final y borramos el directorio
            //borrar el contenido del directorio xml/nomina
            $files = glob('xml/nomina/*'); //obtenemos todos los nombres de los ficheros
            $eliminados=0;
            foreach($files as $file){
                if(is_file($file))
                unlink($file); //elimino el fichero
                $eliminados = $eliminados +1;
            }
            $quienEnvia = titular('57'); //Titular de Contabilidad

            $mensaje = "<p> Este es un mensaje automatico: </p><p><b>LA NOMINA SE HA INTEGRADO CORRECTAMENTE</b></p><p>
            Se ha notificado a cada empleado via notificacion de la plataforma, y correo a quienes tienen y esta activado.
            </p>";
            notificacion_add($quienEnvia, 'Nomina integrada con exito en la plataforma', $fecha, $nitavu, $mensaje);
            
            $quienEnvia = titular('58'); //Titular de Rec. Humanos
            notificacion_add($quienEnvia, 'Nomina integrada con exito en la plataforma', $fecha, $nitavu, $mensaje);

            $quienEnvia = titular('55'); //Titular de Informatica (Monitoreo)
            notificacion_add($quienEnvia, 'Nomina integrada con exito en la plataforma', $fecha, $nitavu, $mensaje);

            mensaje("Nominas integradas con exito.",'xml_nomina2.php');
            
        }
        
	
 }else { echo "<b class='alerta'>ERROR ".$directorio." no se ha podido abrir</b>";}

} else { echo "<b class='alerta'>ERROR ".$directorio." no es un directorio</b>";}

closedir($dir);


}
else {mensaje("ERROR: No tiene acceso a esta aplicación",'');}







function XML_nomina($archivo_xml, $x, $yo){    
        $xml = simplexml_load_file($archivo_xml); 
        $ns = $xml->getNamespaces(true);
        $xmlCont = file_get_contents($archivo_xml);
        //EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA 
            // $xml->registerXPathNamespace('c', $ns['cfdi']);
            // $xml->registerXPathNamespace('t', $ns['tfd']);               
            //$cfdiComprobante = $xml->xpath('//cfdi:Comprobante');
            //$Emisor = $xml->xpath('//cfdi:Comprobante//cfdi:Emisor');
        
    $RE_receptor_n='<.*?Receptor.*?Nombre="(.*?)"';
    $RE_receptor='<.*?Receptor.*?"(.*?)"';
    $RE_emisor_n='<.*?Emisor.*?Nombre="(.*?)"';
    $RE_emisor='<.*?Rfc.*?"(.*?)"';
    $RE_fecha='.*?((?:2|1)\d{3}(?:-|\/)(?:(?:0[1-9])|(?:1[0-2]))(?:-|\/)(?:(?:0[1-9])|(?:[1-2][0-9])|(?:3[0-1]))(?:T|\s)(?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9]))';
    $RE_concepto='<.*?Concepto.*?descripcion="(.*?)".*?>';

    $RE_fecha='.*?((?:2|1)\d{3}(?:-|\/)(?:(?:0[1-9])|(?:1[0-2]))(?:-|\/)(?:(?:0[1-9])|(?:[1-2][0-9])|(?:3[0-1]))(?:T|\s)(?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9]))';
    preg_match_all("/".$RE_fecha."/is",$xmlCont, $matches);
    $fechaxmlorig=$matches[1][0];
    unset($matches);
    
    //Extraer rfc del receptor
    preg_match_all('/'.$RE_receptor.'/is',$xmlCont, $matches);
    $rfcxmlre=$matches[1][0]; // RFC del receptor
    unset($matches);
    preg_match_all('/'.$RE_receptor_n.'/is',$xmlCont, $matches);
    $nombrexmlre=$matches[1][0]; // Nombre del receptor
    unset($matches);

    //Extraer datos  del emisor
    preg_match_all('/'.$RE_emisor_n.'/is',$xmlCont, $matches);
    $nombrexmlem=$matches[1][0]; //  Nombre del emisor
    unset($matches);
    preg_match_all('/'.$RE_emisor.'/is',$xmlCont, $matches);
    $rfcxmlem=$matches[1][0]; // RFC del receptor
    unset($matches);

    //Extraer descripcion
    preg_match_all('/'.$RE_concepto.'/is',$xmlCont, $matches);
    $desxml=implode(", ",$matches[1]); // Descripciones de los conceptos separadas por comas
    unset($matches);

    $RE_RFiscal='<.*?RegimenFiscal="(.*?)".*?>';
    preg_match_all('/'.$RE_RFiscal.'/is',$xmlCont, $matches);
    $RegimenFiscal=implode(", ",$matches[1]). " Personas Morales con Fines no Lucrativos"; //para otros, catalago de regimenes fiscales, ya que solo sa el ID en este caso 603
    unset($matches);

    $RE='<.*?LugarExpedicion="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $LugarExpedicion=implode(", ",$matches[1])." CIUDAD VICTORIA";//da el CP; para otros poner lista de CP
    unset($matches);

    $RE='<.*?Fecha="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaI=implode(", ",$matches[1])."";//Fecha del Movimiento
    $HoraI = substr($FechaI, 11, 9);
    $FechaI = substr($FechaI, 0, 10);
    unset($matches);

    $RE='<.*?NumEmpleado="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $NEmpleado=implode(", ",$matches[1])."";// Numero de empleado
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TotalOtrosPagos="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TotalOtrosPagos=implode(", ",$matches[1])."";// Numero de empleado
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?Curp="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Curp=implode(", ",$matches[1])."";// Numero de empleado
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?FechaPago="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaPago=implode(", ",$matches[1])."";// Numero de empleado
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?FechaInicialPago="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaInicialPago=implode(", ",$matches[1])."";// 
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?FechaFinalPago="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaFinalPago=implode(", ",$matches[1])."";// 
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoJornada="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TipoJornada=implode(", ",$matches[1])."";// Numero de empleado
    if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    
    $RE='<.*?PeriodicidadPago="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Periodicidad=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?NumDiasPagados="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $DiasdePago=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?Puesto="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Puesto=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?Departamento="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Departamento=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?CuentaBancaria="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $CuentaBancaria=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?Banco="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Banco=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?Sindicalizado="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Sindicalizado=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoRegimen="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Regimen=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);
    
    $RE='<.*?TotalSueldos="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Sueldo=implode(", ",$matches[1])."";// Numero de empleado
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoDeduccion="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoDeduccion);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoDeduccion.*?Clave="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoDeduccion_clave);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoDeduccion.*?Concepto="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoDeduccion_concepto);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    
    
    $RE='<.*?TipoDeduccion.*?Importe="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoDeduccion_importe);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);




    
    $RE='<.*?TipoPercepcion="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoPercepcion);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoPercepcion.*?Clave="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoPercepcion_clave);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TipoPercepcion.*?Concepto="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoPercepcion_concepto);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    
    $RE='<.*?TipoPercepcion.*?ImporteGravado="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoPercepcion_importe);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);


    $RE='<.*?TipoPercepcion.*?ImporteExento="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $TipoPercepcion_importe_excento);
    // $TipoDeduccion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);


    $RE='<.*?Descuento.*?Total="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $GranTotal=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TotalDeducciones="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TotalDeducciones=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?TotalPercepciones="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TotalPercepciones=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

     $RE='<.*?TotalImpuestosRetenidos="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $TotalImpuestosRetenidos=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);


     $RE='<.*?Sello="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $Sello=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

     $RE='<.*?SelloSAT="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $SelloSAT=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?UUID="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $UUID=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?FechaTimbrado="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $FechaTimbrado=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);


    //DATOS NECESARIOS PARA GENERAR EL LINK DE AUTENCIDAD
    
    $RE='<.*?TimbreFiscalDigitalv11.*?Version="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $LVersion=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?RfcProvCertif="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $RfcProvCertif=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);

    $RE='<.*?NoCertificadoSAT="(.*?)".*?>';
    preg_match_all('/'.$RE.'/is',$xmlCont, $matches);
    $NoCertificadoSAT=implode(", ",$matches[1])."";// Numero de empleado
    //var_dump($TipoDeduccion);
    //if ($TipoJornada=='01'){$TipoJornada_descripcion=$TipoJornada." Diurna";}
    //$HoraI = substr($FechaI, 11, 9);    
    unset($matches);
//imprimiendo resultados en tabla
//este bloque no se imprimira	

if (nitavu_nombre(Nitavu_real($NEmpleado)) ==''){
    echo "<tr style='background-color:red;'>";$x=$x+1;

    //echo "<hr>".$nombrexmlre.", No. de Empleado: ".$NEmpleado.", Curp:".$Curp.", Puesto: ".$Puesto.", Dpto: ".$Departamento.", Salario: ".$TotalPercepciones."<br><hr>";
    
}
    else {
    echo "<tr>";
    
    //integracion en la plataforma ------------------------------------------
    if (isset($_GET['integrar'])){
    //mensaje("integramos",'xml_nomina2.php');
    
    $Sexo = SexoNomina($NEmpleado);
    $EdoCivil = EdoCivilNomina($NEmpleado); 
    $Nitavu_real = Nitavu_real($NEmpleado);
    ActCurpSexoEstadoCivil($Nitavu_real, $Curp, $Sexo, $EdoCivil, '119460'); //actualizamos los datos
    $Enviados = 0; $NoEnviados = 0;
    

    if (NominaAdd($Nitavu_real, $xmlCont, $FechaInicialPago, $FechaFinalPago, NominaPeriodo($FechaInicialPago, $FechaFinalPago), $yo)==TRUE){
        $Enviados = $Enviados  + 1;
    } else {
        $NoEnviados = $NoEnviados + 1;
    }


    
    }
    // -------------------------------------------------------------------


}

echo "<td width=100px valign=top>";
echo ponerfoto("fotos/".Nitavu_real($NEmpleado).".jpg",'foto_footer');

echo $nombrexmlre."<br>";
//echo "Sexo:".$Sexo."<br>";
echo "NEmpleado: ".$NEmpleado."<br>";
echo "RFC: ".$rfcxmlre."<br>";
echo "Curp: ".$Curp."<br>";
echo "Joranda: ".$TipoJornada_descripcion."<br>";
//echo "Puesto: ".$Puesto."<br>";
//echo "Dpto: ".$Departamento."<br>";
echo "Puesto: ".nitavu_puesto(Nitavu_real($NEmpleado))." de ".nitavu_dpto_nombre(Nitavu_real($NEmpleado))."<br>";
echo "<label>(".$Puesto.",".$Departamento.")</label>";
echo "<br>";
echo "<a href='".$archivo_xml."' title='".$archivo_xml."'>Ver XML</a>";
echo "</td>";
echo "<td valign=top>";
//echo "Informacion Bancaria: ".$Banco." | ".$CuentaBancaria."<br>";
echo "Sindicalizado:<b> ".$Sindicalizado."</b><br>";
echo "Regimen:<b> ".$Regimen.", ".$RegimenFiscal."</b><br>";
//echo "</td>";

//echo "Cuenta Bancaria: ".$Banco." | ".$CuentaBancaria."<br />";		
//echo "<td>".$Banco." | ".$CuentaBancaria."</td>";

//echo "Sindicalizado: ".$Sindicalizado."<br>";
//echo "<td>".$Sindicalizado."</td>";

//echo "Tipo de Regimen: " .$Regimen."<br>";
//echo "<td>".$Regimen."</td>";

// echo "<hr>";

// echo "Nombre del emisor: ".$nombrexmlem."<br />";
//echo "<td>".$nombrexmlem."</td>";

// echo "RFC emisor es: ".$rfcxmlem."<br />";
//echo "<td>".$rfcxmlem."</td>";

// echo "Conceptos: ".$desxml."<br />";
//echo "<td>".$desxml."</td>";

// echo "Regimen Fiscal: ".$RegimenFiscal."<br />";
//echo "<td>".$RegimenFiscal."</td>";

// echo "Lugar de Expedicion: ".$LugarExpedicion."<br>";
//echo "<td>".$LugarExpedicion."</td>";

// echo "Fecha de Operacion: ".$FechaI."<br>";
//echo "<td>".$FechaI."</td>";

// echo "Hora de Operacion: ".$HoraI."<br>";
//echo "<td>".$HoraI."</td>";

// echo "Fecha de Pago: ".$FechaPago."<br>";
//echo "<td>".$FechaPago."</td>";

// echo "Periodo: ".$Periodicidad."<br />";
//echo "<td>".$Periodicidad."</td>";

// echo "Fecha Inicial de Pago: ".$FechaInicialPago."<br>";
//echo "<td>".$FechaInicialPago."</td>";

// echo "Fecha Final de Pago: ".$FechaFinalPago."<br>";
//echo "<td>".$FechaFinalPago."</td>";

// echo "Dias de Pago: ".$DiasdePago."<br>";
//echo "<td>".$DiasdePago."</td>";

//echo "<td valign=top>";
echo "Periodicidad: <b>".$Periodicidad."</b><br>";
echo "Periodo: <b>".NominaPeriodo($FechaInicialPago, $FechaFinalPago)."</b><br>";
echo "Desde : <b>".$FechaInicialPago."</b> a <b>".$FechaFinalPago."</b><br>";

echo "<br>Fecha de operacion: ".$FechaI.", ".$HoraI."";


echo "</td>";

// echo "<br>Nombre del receptor: ".$nombrexmlre."<br />";
//echo "<td>".$nombrexmlre."</td>";

// echo "Nitavu: ".$NEmpleado."<br />";
// echo "<td>".$NEmpleado."</td>";
// $NEmpleado_real = Nitavu_real($NEmpleado);
// echo "<td>".$NEmpleado_real." | ".nitavu_nombre($NEmpleado_real)."</td>";

// echo "RFC: ".$rfcxmlre."<br />";
//echo "<td>".$rfcxmlre."</td>";

// echo "Curp: ".$Curp."<br />";
//echo "<td>".$Curp."</td>";

// echo "Jornada: ".$TipoJornada_descripcion."<br />";
//echo "<td>".$TipoJornada_descripcion."</td>";

// echo "Puesto: ".$Puesto."<br />";
//echo "<td>".$Puesto."</td>";

// echo "Departamento: ".$Departamento."<br />";
//echo "<td>".$Departamento."</td>";



echo "<td valign=top>";

$indice=0;
reset($TipoDeduccion);  //Agrupado por el SAT
foreach ($TipoDeduccion[1] as $key => $value) 
    { 
        //echo strval($key)."=".strval($value)."<br>";
        $Deducciones[$indice][0] = $value;
        $indice = $indice +1;
    }

//echo "Con clave: <br>";
$indice= 0;
reset($TipoDeduccion_clave); //con CLAVE
foreach ($TipoDeduccion_clave[1] as $key => $value) 
    { 
       // echo strval($key)."=".strval($value)."<br>";
        $Deducciones[$indice][1] = $value;
        $indice = $indice +1;
    }    

//echo "Con concepto: <br>";
$indice = 0;
reset($TipoDeduccion_concepto); //con CLAVE
foreach ($TipoDeduccion_concepto[1] as $key => $value) 
    { 
        //echo strval($key)."=".strval($value)."<br>";
        $Deducciones[$indice][2] = $value;
        $indice = $indice +1;
    }    

$indice = 0;
reset($TipoDeduccion_importe); //con CLAVE
foreach ($TipoDeduccion_importe[1] as $key => $value) 
    { 
        //echo strval($key)."=".strval($value)."<br>";
        $Deducciones[$indice][3] = $value;
        $indice = $indice +1;
    }   
$TotalN_deducciones = $indice;
echo "<table class='tbl_dir' ><th>Agrup.SAT</th><th>No.</th><th>Concepto</th><th>importe</th>";
for ($i = 0; $i <= $TotalN_deducciones-1; $i++) {
    //echo $Deducciones[$i][0]."|".$Deducciones[$i][1]."|".$Deducciones[$i][2]."|".$Deducciones[$i][3]."<br>";
    echo "<tr>";
    echo "<td>".$Deducciones[$i][0]."</td>";
    echo "<td>".$Deducciones[$i][1]."</td>";
    echo "<td>".$Deducciones[$i][2]."</td>";
    echo "<td>".$Deducciones[$i][3]."</td>";
    echo "</tr>";
}
echo "</table>";

echo "<b class='Tmediano'>$".number_format($TotalDeducciones, 2, '.', ',')."</b>";


echo "</td>";



echo "<td valign=top>";

$indice=0;
reset($TipoPercepcion);  //Agrupado por el SAT
foreach ($TipoPercepcion[1] as $key => $value) 
    { 
        //echo strval($key)."=".strval($value)."<br>";
        $Percepciones[$indice][0] = $value;
        $indice = $indice +1;
    }

//echo "Con clave: <br>";
$indice= 0;
reset($TipoPercepcion_clave); //con CLAVE
foreach ($TipoPercepcion_clave[1] as $key => $value) 
    { 
       // echo strval($key)."=".strval($value)."<br>";
        $Percepciones[$indice][1] = $value;
        $indice = $indice +1;
    }    

//echo "Con concepto: <br>";
$indice = 0;
reset($TipoPercepcion_concepto); //con CLAVE
foreach ($TipoPercepcion_concepto[1] as $key => $value) 
    { 
        //echo strval($key)."=".strval($value)."<br>";
        $Percepciones[$indice][2] = $value;
        $indice = $indice +1;
    }    

$indice = 0;
reset($TipoPercepcion_importe); //con CLAVE
foreach ($TipoPercepcion_importe[1] as $key => $value) 
    { 
        //echo strval($key)."=".strval($value)."<br>";
        $Percepciones[$indice][3] = $value;
        $indice = $indice +1;
    }   

    
$indice = 0;
reset($TipoPercepcion_importe_excento); //con CLAVE
foreach ($TipoPercepcion_importe_excento[1] as $key => $value) 
    { 
        //echo strval($key)."=".strval($value)."<br>";
        $Percepciones[$indice][4] = $value;
        $indice = $indice +1;
    }   

$TotalN_percepciones = $indice;
echo "<table class='tbl_dir' ><th>Agrup.SAT</th><th>No.</th><th>Concepto</th><th>importe</th>";
for ($i = 0; $i <= $TotalN_percepciones-1; $i++) {
    $Percepcion_real = 0; 
    if ($Percepciones[$i][3]=='0.00'){
        $Percepcion_real = $Percepciones[$i][4];
    } else {
        $Percepcion_real = $Percepciones[$i][3];
    }
    //echo $Percepciones[$i][0]."|".$Percepciones[$i][1]."|".$Percepciones[$i][2]."|".$Percepcion_real."<br>";
    echo "<tr>";
     echo "<td>".$Percepciones[$i][0]."</td>";
     echo "<td>".$Percepciones[$i][1]."</td>";
     echo "<td>".$Percepciones[$i][2]."</td>";
     echo "<td>".$Percepcion_real."</td>";
    echo "</tr>";
}
echo "</table>";

echo "<b class='TChico'>Total Percepciones mas otros Pagos (".$TotalOtrosPagos.")<br>";
echo "<b class='Tmediano'>$".number_format($TotalPercepciones, 2, '.', ',')."</b>";


echo "</td>";


echo "<td valign=top>";
echo "<table class='tbl_dir'>";
echo "<tr>";
    echo "<td align=right>SUBTOTAL:</td><td align=left>"."<b class='TMediano'>$".number_format($TotalPercepciones, 2, '.', ',')."</b>";"</td>";    
echo "</tr>";

echo "<tr>";
    echo "<td align=right>DESCUENTOS:</td><td align=left>"."<b class='TMediano'>$".number_format($TotalDeducciones, 2, '.', ',')."</b>";"</td>";    
echo "</tr>";

echo "<tr>";
    echo "<td align=right>RETENCIONES:</td><td align=left>"."<b class='TMediano'>$".number_format($TotalImpuestosRetenidos, 2, '.', ',')."</b>";"</td>";    
echo "</tr>";

echo "<tr>";
    echo "<td align=right>TOTAL:</td><td align=left>"."<b class='TMediano'>$".number_format($GranTotal, 2, '.', ',')."</b>";"</td>";    
echo "</tr>";

echo "<tr>";
if (is_numeric($TotalOtrosPagos)){
    echo "<td align=right>Neto del recibo:</td><td align=left>"."<b class='TGrande'>$".number_format($GranTotal + $TotalOtrosPagos, 2, '.', ',')."</b>";"</td>";    
} else {
    echo "<td align=right>Neto del recibo:</td><td align=left>"."<b class='TGrande'>$".number_format($GranTotal , 2, '.', ',')."</b>";"</td>";    
}
    
echo "</tr>";

echo "</table>";
echo "<label>".numtoletras($GranTotal)."</label>";
echo "</td>";

echo "</tr>";
echo "<tr >";
echo "<td colspan=5 >";

// echo "Sello digital del CFDI: ".$Sello."<br>";
// //echo "Sello SAT: ".$SelloSAT."<br>";
// echo "Version: ".$LVersion."<br>";
// echo "UUID: ".$UUID."<br>";
// echo "Fecha Timbrado: ".$FechaTimbrado."<br>";
// echo "RfcProvCertif: ".$RfcProvCertif."<br>";
// echo "NoCertificadoSAT: ".$NoCertificadoSAT."<br>";

// $CadenaOrginal = "||".$LVersion."|".$UUID.$FechaTimbrado."|".$RfcProvCertif."|".$Sello."|".$NoCertificadoSAT;
// echo "Cadena Original del complemento del certifición digital del SAT: ".$CadenaOrginal."||";
// $rellono_izq= str_pad($GranTotal, 18, "0", STR_PAD_LEFT); 
// $GranTotal_vinculo = $rellono_izq."0000";
// $ultimos8Sello=  strtoupper(substr($Sello, -8));
// echo "<BR>Ultimos 4 dig del Sello: ".$ultimos8Sello."<br>";

// $QR_link = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=".$UUID."&re=".$rfcxmlem."&rr=".$rfcxmlre."&tt=".$GranTotal_vinculo."&fe=".$ultimos8Sello;
// echo "<a href='".$QR_link."' target=_blank> Validar </a>";

echo "</td>";


echo "</tr>";


return $x;


}







































echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";

include ("./lib/body_footer.php");
?>