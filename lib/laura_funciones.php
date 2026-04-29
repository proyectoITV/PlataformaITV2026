<?php
/*FUNCIONES PERSONALIZADAS */


/*eJEMPLO */
function mifuncion($variable){
require("config.php"); /*No mover*/

$sql = "SELECT * FROM empleados WHERE nitavu='".$variable."'";
$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['nombre'];
							
	}
	else
	{
		return FALSE;
	}
/* Return regresa el valor a la funcion*/	
}

function IdNuevo($tabla,$campo){
    require("config.php"); /*No mover*/
    
    $sql = "SELECT max(".$campo."+1) as maximo FROM ".$tabla;
    $rc= $Vivienda -> query($sql);
        if($f = $rc -> fetch_array())
        {
            return $f['maximo'];                                
        }
        else
        {
            return 1;
        }
    /* Return regresa el valor a la funcion*/	
    }

function extraelista($campoObtener,$tabla,$campocompara,$datoiguala){
    require("config.php");
    $sql="";
    $sql="SELECT ".$campoObtener." as lista FROM ".$tabla." WHERE ".$campocompara."=".$datoiguala;
    //echo $sql;
    $rlista=$Vivienda->query($sql);
	if ($rrr=$rlista->fetch_array()){
		return $rrr['lista'];
		//return $sql;
	}else{
		return FALSE;
	}
}


function buscaidconcepto($campo, $tabla,$campoigual, $idconcepto){
	require("config.php");
	$sql="";
	$sql="select ".$campo." as descripcion from ".$tabla." where ".$campoigual."=".$idconcepto;
	//echo $sql;
	$rr=$Vivienda->query($sql);
	if ($rrr=$rr->fetch_array()){
		return $rrr['descripcion'];
		//return $sql;
	}else{
		return FALSE;
	}
}

function buscaidconceptocx($campo, $tabla,$campoigual, $idconcepto){
	require("config.php");
	$sql="";
	$sql="select ".$campo." as descripcion from ".$tabla." where ".$campoigual."=".$idconcepto;
	//echo $sql;
	$rr=$conexion->query($sql);
	if ($rrr=$rr->fetch_array()){
		return $rrr['descripcion'];
		//return $sql;
	}else{
		return FALSE;
	}
}

function buscaidconceptocxviv($campo, $tabla,$campoigual, $idconcepto){
	require("config.php");
	$sql="";
	$sql="select ".$campo." as descripcion from ".$tabla." where ".$campoigual."=".$idconcepto;
	//echo $sql;
	$rr=$Vivienda->query($sql);
	if ($rrx=$rr->fetch_array()){
		return $rrx['descripcion'];
		//return $sql;
	}else{
		return FALSE;
	}
}

function revisavacio($campo,$link,$textocampo){
    if ($campo==""){
        mensaje('No se puede registrar un '.$textocampo.' vacío. Por favor llene con información',$link);
        die();
    }

}


    function determinaCorrida($montoconvenio, $totpagos, $tasafin){
  
    
    if ($montoconvenio>0 ){
        //if ($montoconvenio>0 and $totpagos>0){    
         $ultimosaldo=0;
         $saldopago=0;
         $pago=0;
         $minimo=0;
         $limite=0;
         $montopago=0;
         $nuevodoc=0;

        $limite=120;

        if ($totpagos>$limite){
            $totpagos=120;
        }else{
            $limite=$totpagos;
        }

        if($tasafin==0){
            $minimo=$montoconvenio/$limite;
            $minimo=intval($minimo +(   intval($minimo)    /$minimo));  
        }else{
            $minimo=( ($montoconvenio * $tasafin) /1200)/(1-(1+($tasafin/1200))**(-$limite));
            $minimo=intval($minimo +(   intval($minimo)    /$minimo));           
        }

        if($montopago<$minimo){
            $montopago=$minimo;          
        }

        if ($montopago>$montoconvenio){
            $montopago=$montoconvenio;
            $montoultimopago=0;
            $totalpagos=1;    
            exit;
        }

        $montopago=$minimo;        
   
        if($tasafin==0){
            //$totpagos=intval($tasafin/$montopago);
            //if (($nuevodoc*$montopago)<$montoconvenio){
            if (($totpagos*$montopago)<$montoconvenio){    
                $totpagos=$totpagos+1;
            }
        }else{
            $totpagos=intval(Nper($tasafin, $montopago,$montoconvenio))+1;
        }

        $ultimosaldo=$montoconvenio;
        for ($i=1; $i<$totpagos ; $i++){
            if ($tasafin==0){
                $saldopago=$montopago;
            }else{
                $saldopago=($montopago)-(($ultimosaldo*$tasafin)/1200);
            }
            $ultimosaldo=$ultimosaldo-$saldopago;
        }

        if($tasafin==0){
            $montoultimopago=number_format($ultimosaldo, 2, '.', '');
        }else{
            $montoultimopago=$ultimosaldo+($ultimosaldo*($tasafin/1200));
            $montoultimopago=number_format($montoultimopago, 2, '.', '');
            
            
        }
        //$totpagos=$saldopago;
        //$minimo=$ultimosaldo;
        $montopago=number_format($montopago, 2, '.', '');
        return array($montopago,$montoultimopago,$minimo,$totpagos);


    } ;     


};

function Nper($interest, $payment, $loan){
    $interest = $interest / 1200;
    $nperC = Log10 ($payment/ ($payment- $loan * $interest)) / Log10(1 + $interest);

    return $nperC;
}

function RevisaArea(){
    
    
}
function RevisaPaquete($idpaquete,$idarea,$idprograma){
    require("config.php");
	$sql1="";
    $sql1="SELECT IdCredito from creditos WHERE IdPrograma=".$idprograma." AND FIND_IN_SET(".$idpaquete.", IdPaquetes) AND FIND_IN_SET(".$idarea.", ListaAplicacion) ";
	//$sql="select PaqueteMaterial  from paquetematerial where IdPaqueteMaterial=".$idpaquete;
	//echo $sql;
	$rr=$Vivienda->query($sql1);
	if ($rrr=$rr->fetch_array()){
        $corrida=$rrr['IdCredito'];		
		return $corrida;
        //return true;

	}else{
		return FALSE;
	}
}

function RevisaColenLista($NC,$idcol,$idprograma){
    require("config.php");
	$sqlcolonia="";
    $sqlcolonia="SELECT 1 as col, IdColonia FROM convdesarrollador WHERE IdPrograma=165 AND Folio=".$NC." AND FIND_IN_SET(".$idcol.", IdColonia)";	
	$rcol=$Vivienda->query($sqlcolonia);
	if ($rcol1=$rcol->fetch_array()){
        $col=$rcol1['col'];		
		return $col;
        //return true;

	}else{
		return FALSE;
	}
}




function RevisaHayCredito($idprograma){
    require("config.php");
	$sql="";
    $sql="Select IdCredito from creditos where IdPrograma=".$idprograma;
    $rr=$Vivienda->query($sql);
    if ($rrr=$rr->fetch_array()){     
	     return $rrr['IdCredito'];
	}else{
		 return false;
	}

}
function BuscaMun($IdM){
    require("config.php");
	$sql="";
    $sql="Select IdMunicipio from convdesarrollador where IdPrograma=".$IdM;
    $rr=$Vivienda->query($sql);
    if ($rrr=$rr->fetch_array()){     
	     return $rrr['IdM'];
	}else{
		 return false;
	}

}

// $calc = new CalculatorModel();
// $months = $calc->Nper($_POST['interest'], $_POST['payment'], $_POST['loan']);
// echo round($months,2);



//paquete material
         /* listapaq = cPrograma.ListaIdPaqueteMat
           Do While listapaq <> ""
                pos = InStr(1, listapaq, ",")
                If pos > 0 Then
                    idpaq = Mid(listapaq, 1, pos - 1)
                Else
                    idpaq = listapaq
                    listapaq = ""
                End If
                Dim numpaq As Integer
                numpaq = idpaq - 1
                If idpaq <> 0 Then LstPaquetes.Selected(numpaq) = True
                'marcar el valor id de la lista??
                listapaq = Mid(listapaq, pos + 1, Len(listapaq))
           Loop */

           
         /*   
         $mystring = $f['ListaIdPaqueteMat'];
         $findme   = ',';
         $listapaquetes="";
         $tablabusqueda="paquetematerial";
         //$pos = strpos($mystring, $findme);
           
         while ($mystring !=""){
            $pos = strpos($mystring, $findme);
           // Nótese el uso de ===. Puesto que == simple no funcionará como se espera
           // porque la posición de 'a' está en el 1° (primer) caracter.
           if ($pos === false) {
               //echo "La cadena '$findme' no fue encontrada en la cadena '$mystring'";
               $dato=$mystring;
               $listapaquetes=$mystring;
               $mystring="";
             
           } else {
               $dato=substr($mystring, 0, $pos-1);
               echo $dato;
               print_r $dato;
               //echo "La cadena '$findme' fue encontrada en la cadena '$mystring'";
               //echo " y existe en la posición $pos";
           }
           $sql="";
           $sql="select * from ".$tablabusqueda." where IdPaqueteMaterial=".$dato;
           echo $sql;
           //$pm= $Vivienda -> query($sql);
           //$r_count = $pm -> num_rows;
           //echo $r_count;
            //$paq = $pm -> fetch_array();
           $listapaquetes=$paq['PaqueteMaterial'].',';
           $mystring=substr($mystring,$pos+1,strlen($mystring));
        } */
        //guardaConfigProg($IdPrograma,$nitavu,$AreaAplicacion,$tablaconceptos,$fecha,$ListaAplicacion,$idcrediton)
        function guardaConfigProg($idprograma,$usuario,$areaap,$arraytabla,$fecha,$ListaAplicacion,$idcrediton){            
            require("config.php");
            //var_dump($arraytabla);     
              
           
            //$array=explode(',',$arraytabla); 
            
            $array= json_decode($arraytabla, true);    
            
            foreach ($array as $value) {   
              
        
                $idconcepto = $value['idConcepto'];
                $idtipoconcepto=$value['idTipoConcepto'];
                $monto= $value['precio'];
                $listapaquetes=$value['paqs'];
              
                $sql3="";
                $sql3="INSERT INTO programaconfig (IdPrograma,IdConcepto,IdTipoCuenta,Monto,Cancelado,IdempCrea,FechaCaptura,ListaIdPaqueteMat,AreaAplicacion,IdCredito) VALUES(".$idprograma.",".$idconcepto.","
                .$idtipoconcepto.",".$monto.",0,".$usuario.",'".$fecha."','".$listapaquetes."','".$areaap."',".$idcrediton.")";
             
               $resultado3 = $Vivienda -> query($sql3);    
                //  if ($Vivienda->query($sql3) == TRUE)
				//  				{
				//  					return TRUE;
				// // 						//header('location:../index.php');
				//  				}
				//  				else
				//  				{
				//  					return false;
				// // 					//echo $sql;
				//  				}


            }
            return 0;
            //echo "Entro a funcion tabla";
        }




        ////****D E S A R R O L L A D O R E S */

        function DatosDesarrollador($id){            
            require("config.php");
            $sql="";
            $sql="select *  from catdesarrolladores where IdDesarrollador=".$id;
            
           $resultado3 = $Vivienda -> query($sql);    
           
           echo $sql;
            return $resultado3;
        }    

        function muestraDatos(){
            echo "entre muestra";
            require("config.php");
            $sql="";
            $sql="select *  from catdesarrolladores where IdDesarrollador=".$id;
            
           $resultado3 = $Vivienda -> query($sql);    
           
           echo $sql;
            return $resultado3;
        }

        function Desarrollador_Info($IdDesarrollador){
            require("config.php");
            $sql = "select * from catdesarrolladoresv WHERE IdDesarrollador='".$IdDesarrollador."'";
           ////$sql = "select * from vehiculos_bitacora WHERE Clave_servicio='ARR22199' limit 1";
           //$sql = "select * from vehiculos_ WHERE Num_economico='ARR22199'";
    // echo $sql;
	    //$rc= $conexion -> query($sql);
    
           $rc= $Vivienda -> query($sql);

            if($f = $rc -> fetch_array())
            {
               // print_r($f);    
                return $f['Nombre'];
            } else {
                return "";
            }
        }

        function text_largo($Id,$etiqueta,$PlaceHolder,$type,$Value,$Nota,$Disabled){
            if ($Disabled=='True'){
                echo '
                <label for="'.$Id.'" style="font-size:8pt; margin-bottom: 6pt;">'.$etiqueta.'</label>
                <input title="'.$Value.'" style="font-size:9pt; margin-top:-7px; margin-bottom: -2; width: 91%;" type="'.$type.'" class="form-control" id="'.$Id.'" placeholder="'.$PlaceHolder.'" value="'.$Value.'" disabled>
                <small id="'.$Id.'_smalltext'.'" class="form-text text-muted" style="font-size: 7pt;
                margin-top: -2px;">'.$Nota.'</small>';    
            }else
            {
            echo '
            <label for="'.$Id.'" style="font-size:8pt; margin-bottom: 6pt;">'.$etiqueta.'</label>
            <input title="'.$Value.'" style="font-size:9pt; margin-top:-7px; margin-bottom: -2; width: 91%;" type="'.$type.'" class="form-control" id="'.$Id.'" placeholder="'.$PlaceHolder.'" value="'.$Value.'">
            <small id="'.$Id.'_smalltext'.'" class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;">'.$Nota.'</small>';
            }
        }

       
        //copia de funciones.php pero para conexion vivienda 30sep2021

        function TablaDinamica_MySQL2($tbCont, $sql, $IdDiv, $IdTabla, $Clase, $Tipo, $ClaseTabla='tabla', $titulo='',$orientacion='Portrait',$nombrearchivo='pdf'){
            require("config.php");
            
            if ($tbCont == '') {
                $r= $Vivienda -> query($sql);
                $tbCont = '<div id="'.$IdDiv.'" class="'.$Clase.'">
                <table id="'.$IdTabla.'" class="display" style="width:100%" class="'.$ClaseTabla.'" style="font-size:8pt;">';
            $tabla_titulos = ""; $cuantas_columnas = 0;
                $r2 = $Vivienda -> query($sql); while($finfo = $r2->fetch_field())
                {//OBTENER LAS COLUMNAS
        
                        /* obtener posición del puntero de campo */
                        $currentfield = $r2->current_field;       
                        $tabla_titulos=$tabla_titulos."<th style='text-transform:uppercase; font-size:9pt;'>".$finfo->name."</th>";
                        $cuantas_columnas = $cuantas_columnas + 1;        
                }
        
                $tbCont = $tbCont."  
                <thead>
                <tr>
                    ".$tabla_titulos."  
                </tr>
                </thead>"; //Encabezados
                $tbCont = $tbCont."<tbody class='".$ClaseTabla."'>";
                $cuantas_filas=0;
                $r = $Vivienda -> query($sql); while($f = $r-> fetch_row())
                {//LISTAR COLUMNAS
        
                    $tbCont = $tbCont."<tr>";        
                    for ($i = 1; $i <= $cuantas_columnas; $i++) {      
                        $tbCont = $tbCont."<td style='font-size:10pt;'>".$f[$i-1]."</td>";       
                        }
        
                    $tbCont = $tbCont."</tr>";
                    $cuantas_filas = $cuantas_filas + 1;        
                }
        
                $tbCont = $tbCont."</tbody>";
                $tbCont = $tbCont."</table></div>";
            } else {
                if ($tbCont == 'Vivienda'){
        
                    $r= $Vivienda -> query($sql);
                        $tbCont = '<div id="'.$IdDiv.'" class="'.$Clase.'">
                        <table id="'.$IdTabla.'" class="display" style="width:100%" class="tabla" 
                        style=""
                        >';
                    $tabla_titulos = ""; $cuantas_columnas = 0;
                        $r2 = $Vivienda -> query($sql); while($finfo = $r2->fetch_field())
                        {//OBTENER LAS COLUMNAS
        
                                /* obtener posición del puntero de campo */
                                $currentfield = $r2->current_field;       
                                $tabla_titulos=$tabla_titulos."<th style='text-transform:uppercase; font-size:9pt;'>".$finfo->name."</th>";
                                $cuantas_columnas = $cuantas_columnas + 1;        
                        }
        
                        $tbCont = $tbCont."  
                        <thead>
                        <tr>
                            ".$tabla_titulos."  
                        </tr>
                        </thead>"; //Encabezados
                        $tbCont = $tbCont."<tbody class='tabla'>";
                        $cuantas_filas=0;
                        $r = $Vivienda -> query($sql); while($f = $r-> fetch_row())
                        {//LISTAR COLUMNAS
        
                            $tbCont = $tbCont."<tr>";        
                            for ($i = 1; $i <= $cuantas_columnas; $i++) {      
                                $tbCont = $tbCont."<td style=''>".$f[$i-1]."</td>";       
                                }
        
                            $tbCont = $tbCont."</tr>";
                            $cuantas_filas = $cuantas_filas + 1;        
                        }
        
                        $tbCont = $tbCont."</tbody>";
                        $tbCont = $tbCont."</table></div>";
        
                } else {
        
                }
            }
            echo  $tbCont;
        
            $Botones = "
            dom: 'Bfrtip',
            buttons: [
                {
                    extend:    'copyHtml5',
                    text:      '<i class=\"fa fa-files-o\"></i>',
                    titleAttr: 'Copy'
                },
                {
                    extend:    'excelHtml5',
                    text:      '<i class=\"fa fa-file-excel-o\"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend:    'csvHtml5',
                    text:      '<i class=\"fa fa-file-text-o\"></i>',
                    titleAttr: 'CSV'
                },
                {
                    extend:    'pdfHtml5',
                    text:      '<i class=\"fa fa-file-pdf-o\"></i>',
                    titleAttr: 'PDF',
                    title: '".$titulo."',
                    messageBottom:'Fecha de Impresion: ".date_format( date_create($fecha), 'd-m-Y H:i:s') ."',
                    filename: '".$nombrearchivo."',
                    orientation: '".$orientacion."'
                }
            ]
            ";
                switch ($Tipo) {
                    case 1: //Scroll Vertical
                            echo '<script>
                            $(document).ready(function() {
                                $("#'.$IdTabla.'").DataTable( {
                                    "scrollY":        "200px",
                                    "scrollCollapse": true,
                                    "paging":         false,
                                    "language": {
                                        "decimal": ",",
                                        "thousands": "."
                                    }
                                } );
                            } );
                            </script>';
                        break;
        
                    case 2: //Scroll Horizontal
                            echo '<script>
                            $(document).ready(function() {
                                $("#'.$IdTabla.'").DataTable( {
                                    "scrollX": true,
                                    "scrollCollapse": true,
                                    "paging":         true,
                                    "language": {
                                        "decimal": ",",
                                        "thousands": "."
                                        
                                    },
                                    "order": [[ 1, "desc" ]]
                                    ,responsive: true
                                    ,'.$Botones.'
                                } );
                            } );
                            </script>';
                        break;
                    
                    default:
                        echo '<script>
                        $(document).ready(function() {
                            $("#'.$IdTabla.'").DataTable( {
                                "language": {
                                    "decimal": ",",
                                    "thousands": "."
                                }
                            } );
                        } );
                        </script>';
                }
               
        
        }
        
        function NumMov2($NumContrato){
            require("config.php");
            $sql = "select MAX(NumMov) as ultimo from historicopagos where NumContrato = '".$NumContrato."'";
        // echo $sql;
        
            $rc = $Vivienda -> query($sql);
            while($f = $rc -> fetch_array())
            {
                return $f['ultimo'];
            }
        }
        

function NumMovDes($folio){
    require("config.php");
    $sql = "select MAX(Numpago) as ultimo from pagosdesarrolladores where Folio ='".$folio."'";
        // echo $sql;
        
        $rc = $Vivienda -> query($sql);
        while($f = $rc -> fetch_array())
        {
                return $f['ultimo'];
        }
}

/*EsTa funcion nos ayuda a conocer el tipo de moneda con el que se pagará un credito, este dato es obtenido de datos evaluacion*/
function TipoMonedaContratos($numcontrato){
	require("config.php");
	
	$sql="Select IdTipoMoneda  from contratos where  NumContrato='".$numcontrato."'";
	//echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['IdTipoMoneda'];
    }else{
        return 'FALSE';
    }
}
    
function buscarDesarrollador($iddelegacion, $idprograma, $folio){
    require("config.php");
	
	$sql="SELECT Nombre FROM catdesarrolladores inner join convdesarrollador on 
    convdesarrollador.IdDesarrollador=catdesarrolladores.IdDesarrollador
    WHERE convdesarrollador.IdDelegacion=".$iddelegacion." and convdesarrollador.IdPrograma=".$idprograma." and convdesarrollador.Folio=".$folio;
	//echo $sql;
	$rc= $Vivienda -> query($sql);
    if($f = $rc -> fetch_array()){
        return $f['Nombre'];
    }else{
        return 'FALSE';
    }

}

//function recibodes($iddelegacion,$idprograma,$folio,$numcontrato,$cantidad,$formapago,$referencia,$fecharecibo,$nitavurecibo,$foliorecibo,$numpago,$tipopago,$notas,$codigoqr,$descuento){
  //  require_once('lib/flor_funciones.php');
    //require("config.php");
    //$Desarrollador = buscarDesarrollador($iddelegacion,$idprograma,  $folio);

    /* $sql="SELECT NumContrato,
    ( select colonia from catcolonia where catcolonia.IdColonia=contratos.IdColoniaL and catcolonia.IdMunicipio=contratos.IdMunicipioL
     ) as colonia, manzana, lote,                 	
     0 as pago 
     FROM `contratos` where IdPrograma=165 and folio=102"; */
   
   
    


   //echo "<tr id=".$lotes ['idLote']." value=".$lotes ['porpagar'].">";                      
   
   /* $html=$html.'<tr> <td>'.$lotes ['NumContrato'].' </td>';
   $html=$html."<td>".$lotes ['colonia']." </td>";
   $html=$html."<td>".$lotes ['manzana']." </td>";
   $html=$html."<td>".$lotes ['lote']." </td>";
   $html=$html."<td>".$lotes ['pago']." </td></tr>"; */
                           
 


    function recibodes($iddelegacion,$idprograma,$folio,$numcontrato,$cantidad,$idformapago,$referencia,$fecharecibo,$nitavu,$folioRecibo,$numPago,$idtipopago,$notas,$codigoQR,$descuento){
        require_once('lib/flor_funciones.php');
        require('config.php');
        $IdSolicitante = buscarIdSolicitante($idprograma, $iddelegacion, $folio);
        $Desarrollador = buscarDesarrollador($iddelegacion,$idprograma,  $folio);
             
            
        $res= '<br><br><table   style="width:100%" border=1  id="'.$folioRecibo.'">
            <tr>
                <td style="width:65%" border=1><div>
                    <table>
                    <tr>
                    <td><b>DATOS DE IDENTICACIÓN</b></td> 		
                    </tr>
                    <tr>
                    <td></td>  
                    </tr>
                    <tr>
                        <td><div>
                        <table style="width:100%" border=1>
                        <tr>
                        <td><span style="font-weight: bold; font-size:13px;">'.$Desarrollador.'</span></td>
                        <td><span></span></td> 								 		
                        </tr>
                        <tr>
                        <td style="width:20%"><span>PROGRAMA:</span></td>
                        <td style="width:80%"><span>'.nombreProgramaVivienda($idprograma).'</span></td> 				 		
                        </tr>
                        <tr>
                        <td style="width:20%"><span>CONVENIO:</span></td>
                        <td style="width:80%"><span>'.$folio.'</span></td> 				 		
                        </tr>';
                        
                        $res =$res.'</table></div>
                        </td>								 
                    </tr>
                    </table>
                </div></td>
        
                <td  style="width:35%" border=1><div>
                    <table boder=1>
                    <tr>
                    <td><b>DATOS TRANSACCIÓN</b></td>  
                    </tr>
                    <tr>
                    <td></td>  
                    </tr>
                    <tr>			 
                    <td><div>
                        <table>
                        <tr>
                        <td><span>N° RECIBO:</span></td>
                        <td><span>'.SerieDelegacion($iddelegacion).$folioRecibo.'</span></td> 								 		
                        </tr>
                        <tr>
                        <td><span>FECHA:</span></td>
                        <td><span>'.$fecharecibo.'</span></td> 				 		
                        </tr>
                        <tr>
                        <td><span>DELEGACION:</span></td>
                        <td><span>'.nombreDelegacionVivienda($iddelegacion).'</span></td> 				 		
                        </tr>
                        <tr>
                        <td><span>FORMA DE PAGO:</span></td>
                        <td><span>'.FormaDePago($idformapago).'</span></td> 				 		
                        </tr>	
                        <tr>
                        <td><span>REFERENCIA:</span></td>
                        <td><span>'.$referencia.'</span></td> 				 		
                        </tr>	
                        <tr>
                        <td><span>OPERADOR:</span></td>
                        <td><span>***'.$nitavu.'</span></td> 				 		
                        </tr>				
                        </table></div>
                        </td>					 
                    </tr>
                    </table></div>
                </td>    
            </tr>		
            <tr>    
            <td style="width:100%">	
            <div>	
                 
            </div>  
            </td>    
            </tr>
            
            <tr><td><b><label>DESGLOSE DE PAGO</label></b></td> </tr>           
            <tr>
                        
                <td style="width:100%"><div>

                <div id="tablalotes" >
                <table id="data_table" class="table table-striped" style="font-size: 10px;">
                <thead>
                <tr>                
                    <th><i>NumContrato</i></th>
                    <th colspan=2><i>Colonia</i></th>
                    <th><i>Manzana</i></th>
                    <th><i>Lote</i></th>
                    <th><i>Pago</i></th>                     
                </tr>
                </thead>
                <tbody>';

                $sql ="select pagosparciales.NumContrato,vivienda_informacioncontratos.ColoniaL as colonia,  vivienda_informacioncontratos.Manzana as manzana, vivienda_informacioncontratos.Lote as lote,
                 pagosparciales.ImporteEnPesos as pago FROM pagosparciales 
                left OUTER join vivienda_informacioncontratos ON pagosparciales.NumContrato=vivienda_informacioncontratos.NumContrato 
                where  pagosparciales.Cancelado=0 and  pagosparciales.FechaOperacion='".$fecharecibo."' and foliorecibo=".$folioRecibo." 
                 and vivienda_informacioncontratos.cancelado=0";


         /*        $sql="SELECT NumContrato,
                ( select colonia from catcolonia where catcolonia.IdColonia=contratos.IdColoniaL and catcolonia.IdMunicipio=contratos.IdMunicipioL
                ) as colonia, manzana, lote,                 	
                0 as pago 
                FROM `contratos` where IdPrograma=165 and folio=102";    */  
                $lotconv= $Vivienda -> query($sql);
                while($lotes = $lotconv -> fetch_array()){
                    $res =$res.'<tr> <td>'.$lotes ['NumContrato'].' </td>';
                    $res =$res."<td colspan=2 style='font-size: 6px;'>".$lotes ['colonia']." </td>";
                    $res =$res."<td>".$lotes ['manzana']." </td>";
                    $res =$res."<td>".$lotes ['lote']." </td>";
                    //$res =$res."<td> </td>";
                    $res =$res."<td>".$lotes ['pago']." </td></tr>";

                }


                $res=$res.' </tbody>    
                </table>
                </div>


                </div>
                </td>    
            </tr>


            <tr >
                <td style="width:60%"><div>
                    <table>
                    <tr>			  
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <table style="width:100%" border=1>
                                    <tr>';
                                        if($numcontrato =='')
                                        {
                                            $res=$res.'<th style="width:20%;"><b>N° PAGO</b></th>';
                                        }								
                                        $res=$res.'<th style="width:60%;"><b>CONCEPTO</b></th>
                                        <td></td><th style="width:20%;"><b>IMPORTE</b></th>';
                                        if($descuento>0)
                                        {
                                            $res=$res.'<th style="width:20%;"><b>DESCUENTO</b></th>';
                                        }
                                        $res=$res.'<th style="width:20%;"><b>TOTAL</b></th>
                                        
                                        </tr>				
                                    <tr>';
                                        if($numcontrato =='')
                                        {
                                            $res=$res.'<td style="width:20%;"><span>'.$numPago.'</span></td>';
                                        }								
                                        $res=$res.'<td style="width:60%;"><span>'.strtoupper( TipoPago_Concepto($idtipopago)).'</span></td>
                                        <td></td><td style="width:20%;"><span>$'.$cantidad.'</span></td>';
                                        (string)$total=(string)$cantidad;
                                        if($descuento>0)
                                        {
                                            $total=(string)$cantidad-(string)$descuento;
                                            $res=$res.'<td style="width:20%;"><span>$'.$descuento.'</span></td>';
                                        }
                                        $res=$res.'<td style="width:20%;"><span>$'.$total.'</span></td>
                                        
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="4"><b><br><br>IMPORTE CON LETRA:</b> '. strtoupper(numtoletras($total)).'</td>	
                                    </tr>					
                                </table>
                            </div>
                        </td>											 
                    </tr>
                    </table>
                </div></td>
                <td  style="width:40%; text-align:right;" border=1>
                <div>';	
                 //SE GENERA EL CODIGO QR
                //$codigoQR=GenerarQRrecibo($folioRecibo,$cantidad,$fecharecibo,$nitavu);
                $codesDir = "tmp/CodigosQR/"; //Carpeta donde se almacenaran los QR  
        
                $res=$res.'<img  src="'.$codesDir.$codigoQR.'" />
                </div>
                </td>    
            </tr>
            <tr>    
            <td style="width:100%">	
            <div>	
            <hr style="border-top: 5px solid"/> 	
            </div>  
            </td>    
            </tr>
            
            
          </table>';	
        return $res;
        }
       
function EliminaPagoDesarrolladores($NumRec, $folio, $FechaOperacion){
	require("config.php");	
	$sqldatosrec="select * from pagosdesarrolladores where FolioRecibo=".$NumRec." and folio=".$folio." and FechaPago='".$FechaOperacion."'" ;
	$borra = $Vivienda -> query($sqldatosrec);
    if ($rrr=$borra->fetch_array())	
	{   
            $contratos=$rrr['contratospagados'];
            $contratos=substr($contratos, 1);
            foreach(explode(",",$contratos) as $contrato){                
                // $borro=borraccontratodespp($contrato,$NumRec, $FechaOperacion);
                 //if ($borro=true){
                borraccontratodespp($contrato,$NumRec, $FechaOperacion);
                borraccontratodesph($contrato,$NumRec, $FechaOperacion);        
                
                 //}
            }
            //borrar el pago
            //$slqborraglobal='delete from pagosdesarrolladores WHERE FolioRecibo='.$NumRec.'and folio='.$folio.' and FechaOperacion="'.$FechaOperacion."'" ;
            borrapagodes($folio, $NumRec, $FechaOperacion);
            borradatosrecibodes($folio, $NumRec, $FechaOperacion);
			return 'FALSE';            
	}else{
        return false;
    }
};

function borraccontratodespp($contrato,$NumRec, $FechaOperacion){    
    require("config.php");	
	$sqlborraencontratos="delete from pagosparciales where Numcontrato='".$contrato."' and foliorecibo=".$NumRec." and FechaOperacion='".$FechaOperacion."'" ;    	
	$rc= $Vivienda -> query($sqlborraencontratos);
    
}

function borraccontratodesph($contrato,$NumRec, $FechaOperacion){    
    require("config.php");	
	$sqlborraencontratos="delete from historicopagos where Numcontrato='".$contrato."' and FechaOperacion='".$FechaOperacion."'" ;    
	$rc= $Vivienda -> query($sqlborraencontratos);
}

function borrapagodes($folio, $NumRec, $FechaOperacion){    
    require("config.php");	
	$sqlborra="delete from pagosdesarrolladores where IdPrograma=165 and Folio=".$folio." and FolioRecibo=".$NumRec." and FechaPago='".$FechaOperacion."'" ;    
	$rc= $Vivienda -> query($sqlborra);   
}


function borradatosrecibodes($folio, $NumRec, $FechaOperacion){    
    require("config.php");	
	$sqlborra="delete from datosrecibos where IdPrograma=165 and Folio=".$folio." and FolioRecibo=".$NumRec." and FechaRecibo='".$FechaOperacion."'" ;    
	$rc= $Vivienda -> query($sqlborra);
}

function updatehistorialconveniodes($iddelegacion,$idprograma, $folio){
    require("config.php");	
    //$sqlcont="Select * from contratos where IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma." and Folio=".$folio;
    //$guarda = $Vivienda -> query($sqlcont);   
    //while($guardadat = $guarda -> fetch_array()){    
	                 
               $sqlhistor="Update historialconvdesarrollador set Idprograma=165, Folio=".$folio.", NumContrato=".$contrato.", 
               Idlote=".$guardadat['IdLote'].", MontoCredito=".$guardadat['MontoCredito'].",Subsidio=".$guardadat['Subsidio'].",
               Incremento=".$incremento.", Estatus=".$estatus.",FechaCaptura=".$fecha.",IdEmpCrea=".$nitavu.", 
               PagadoAntesAd=".$pagado.", AlAddemdum=".$aladdemdun;

                
			
	  //   }
}

function inserthistorialconveniodes($iddelegacion,$idprograma, $folio){
    require("config.php");	
    $sqlcont="Select * from contratos where IdDelegacion=".$iddelegacion." and IdPrograma=".$idprograma." and Folio=".$folio;
    $guarda = $Vivienda -> query($sqlcont);   
    while($guardadat = $guarda -> fetch_array()){    
	                 
               $sqlhistor="Insert into historialconvdesarrollador( Idprograma,Folio,NumContrato,Idlote,,MontoCredito,Subsidio,Incremento,
               Estatus,FechaCaptura,IdEmpCrea,PagadoAntesAd,AlAddemdum,OriginData) 
               values(165,".$folio.", ".$contrato.", ".$guardadat['IdLote'].",".$guardadat['MontoCredito'].",".$guardadat['Subsidio'].",
               ".$incremento.",".$estatus.",".$fecha.",".$nitavu.", ".$pagado.",".$aladdemdun.",".$iddelegacion;

                
			
	     }
}
// function midireccionxx($nitavu){
//     require("config.php");	
//     $sql="Select depto from empleados where nitavu=".$nitavu;
//     $rc = $conexion -> query($sql);   
//     if($f = $rc -> fetch_array()){
//         if ($f['dpto']=1 || $f['dpto']=6 || $f['dpto']=10 || $f['dpto']=19 || $f['dpto']=46 || $f['dpto']=54){
//             return $f['dpto'];
//         }else{

//         } 

//     }else{
//         return 'FALSE';
//     }
// }