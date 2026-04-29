<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");

?>
<script >
        function traex(){
            alert("en la funcion x");
            //console.log(document.getElementById('idprograma').value)
            idprograma=$('#idprograma').val();
            //var idprograma=document.getElementById('idprograma');
            alert("idprograma"+idprograma);
            console.log(document.getElementById('idprograma'))
        }  
</script>

<?php

$id_aplicacion ="ap107"; //tabla aplicaciones

if (isset($_POST['guardarFinal']) || isset($_POST['guardarFinalSinConc'])){
    //guardar tabla de corrida
        //$corrida=array();
   // $IdCredito =$_POST['IdCredito'];
  // echo "<script>traearray()</script>";
  // echo "<script>traex()</script>";
    $DiasdeGracia=0;
    $tablaconceptos=$_POST['tablacorrida'];
   // $IdDelegacion=$_POST['IdDelegacion'];
    $IdPagoInicial=$_POST['IdPagoInicial'];
    $IdPrograma=$_POST['idprograma'];
    $IdTipoMoneda=$_POST['TipoMoneda'];
    $IdTipoPago=$_POST['TipoPago'];
    $MontoCredito=$_POST['montocredito2'];
    $correcto=$_POST['correcto'];
    $idtipoprograma=$_POST['idtipoprograma'];
    $idtipotramite=$_POST['idtipotramite'];
    $gtsadmon=$_POST['GtsAdmon'];
    $segurovida=$_POST['SeguroVida'];
    $ch1=$_POST['ch1'];
    //$ch1=$_POST['ch3'];

    if (isset($_POST['guardarFinalSinConc'])){
        if ($ch1==1){
           $correcto=0;
        }else{
            $correcto=1;
            mensaje('Hubo un problema','programas_alta2.php?Id='.$IdPrograma);
        }
    } 
    
    //$IngresoIni=$_POST['IngresoIni'];
    //$IngresoIFin=$_POST['IngresoIFin'];
    if ($correcto==0){
            $TipoIntMoratorio=$_POST['TipoIntMoratorio'];
            $TasaAnualFin=$_POST['TasaAnualFin'];
            if ($TipoIntMoratorio==0){
                $MontoIntMora=$_POST['TasaAnualFin'];
            }else{
                $MontoIntMora=0;                
            }        
            $MontoPago=$_POST['MontoPago'];
            $MontoUltimoPago=$_POST['MontoUltimoPago'];
            $PeriodoMora=$_POST['PeriodoMora'];
            $TasaAnualFin=$_POST['TasaAnualFin'];

            if ($TipoIntMoratorio==1){
                $TasaIntMora=$_POST['TasaIntMora'];
            }else{
                $TasaIntMora=0;                    
            }           
            
            $Cancelado=0;
            $MontoMinAut=0;
            $MontoMaxAut=0;
            $IngresoIni=0;
            $IngresoIFin=0;
            $MontoPagoInicial=$_POST['montopagoinicial2'];
            $TotalPagos=$_POST['TotalPagos'];

            // if ($_POST['listapaq']==""){
                //     $IdPaquetes=$_POST['listaPaquetes'];
                // }else{

            $ListaAplicacion=$_POST['listaaplicaciongeo'];
            $AreaAplicacion=$_POST['areaaplicacion'];
            $IdPaquetes=$_POST['listapaq'];
            //if($idtipoprograma==1){
            //deberia preguntar con conceptos??    
            if($idtipotramite<>2){  
                // reviso si es la primera corrida del programa
               // $sql="";
                //$sql="Select * from creditos where IdPrograma=".$idprograma;
                //$rr=$Vivienda->query($sql);
                if (RevisaHayCredito($IdPrograma)){
                    
                    $bandera=0;
                    //  $sql="";
                    //  $sql="Select * from creditos where IdPrograma=".$idprograma;
                    //  $rr=$Vivienda->query($sql);
                    
                    //     while($f = $rr -> fetch_array())
                        //{
                            foreach(explode(",",$ListaAplicacion) as $areaRev)
                        {                            
                            foreach(explode(",",$IdPaquetes) as $paqRev){
                                if(RevisaPaquete($paqRev,$areaRev,$IdPrograma)){
                                    // $sql="";
                                    // $sql="Select IdPaquetes,ListaAplicacion  from creditos where IdCredito=".RevisaPaquete($paqRev,$areaRev,$IdPrograma);
                                    // $rr=$Vivienda->query($sql);
	                                // if ($rrr=$rr->fetch_array()){
                                    //     $paqcorr=$rrr['IdPaquetes'];
                                    //     $listcorr=$rrr['ListaAplicacion'];	                                            
                                                                                  
                                        //if ($paqcorr==$IdPaquetes && $listcorr==$ListaAplicacion && $bandera==1){
                                        //if ($paqcorr==$IdPaquetes && $listcorr==$ListaAplicacion ){    
                                                $bandera=1;
                                        //}
                                        // else{   
                                        //     mensaje('El paquete o alguno de los municipios ya se encuentra en una corrida financiera, verifique su información','programas_alta2.php?Id='.$IdPrograma);         
                                          
                                        // }
                                    //}
                                }                                   
                            }
                            
                         }   
                         if ($bandera==0){
                            $sql="";                            
                            $idcrediton=IdNuevo('CREDITOS','IdCredito');
                            $sql = "CALL sp_RegistraPrograma(".IdNuevo('CREDITOS','IdCredito').",".$DiasdeGracia.",0,".$IdPagoInicial.",".$IdPrograma.",".$IdTipoMoneda.","
                                .$IdTipoPago.",".$IngresoIFin.",".$IngresoIni.",".$MontoCredito.",".$MontoIntMora.",".$MontoPago.",".$MontoPagoInicial.",".$MontoUltimoPago.",".
                                $PeriodoMora.",1,".$TasaAnualFin.",". $TasaIntMora.",".$TipoIntMoratorio.",". $TotalPagos.",0,0,'".
                                $IdPaquetes."',".$Cancelado.",'".$ListaAplicacion."','".$AreaAplicacion."',0,".$gtsadmon.",".$segurovida.",'". $fecha."',".$nitavu.")";
                            if ($Vivienda->query($sql) == TRUE){
                                guardaConfigProg($IdPrograma,$nitavu,$AreaAplicacion,$tablaconceptos,$fecha,$ListaAplicacion,$idcrediton);                        
                                mensaje('Registrado con éxito','programas_alta2.php?Id='.$IdPrograma);  
                            }else{
                                mensaje('Error al guardar','programas_alta2.php?Id='.$IdPrograma);  
                            }
                            


                            // $sql = "CALL sp_RegistraPrograma(".IdNuevo('CREDITOS','IdCredito').",".$DiasdeGracia.",0,".$IdPagoInicial.",".$IdPrograma.",".$IdTipoMoneda.","
                            //     .$IdTipoPago.",".$IngresoIFin.",".$IngresoIni.",".$MontoCredito.",".$MontoIntMora.",".$MontoPago.",".$MontoPagoInicial.",".$MontoUltimoPago.",".
                            //     $PeriodoMora.",1,".$TasaAnualFin.",". $TasaIntMora.",".$TipoIntMoratorio.",". $TotalPagos.",0,0,'".
                            //     $IdPaquetes."',".$Cancelado.",'".$ListaAplicacion."','".$AreaAplicacion."',0,".$gtsadmon.",".$segurovida.",'". $fecha."',".$nitavu.")";
                            // if ($Vivienda->query($sql) == TRUE){
                            //     guardaConfigProg($IdPrograma,$nitavu,$AreaAplicacion,$tablaconceptos,$fecha,$ListaAplicacion);                        
                            //     mensaje('Registrado con éxito','programas_alta2.php?Id='.$IdPrograma);  
                            // }else{
                            //     mensaje('Error al guardar','programas_alta2.php?Id='.$IdPrograma);  
                            // }

                         }else{   
                            mensaje('El paquete o alguno de los municipios ya se encuentra en una corrida financiera, verifique su información','programas_alta2.php?Id='.$IdPrograma);         
                          
                        }

                       // } 

                   /*  foreach(explode(",",$ListaAplicacion) as $areaRev)
                        {                            
                            foreach(explode(",",$IdPaquetes) as $paqRev){
                                if(RevisaPaquete($paqRev,$areaRev,$IdPrograma)){
                                    $sql="";
                                    $sql="Select IdPaquetes,ListaAplicacion  from creditos where IdCredito=".RevisaPaquete($paqRev,$areaRev,$IdPrograma);
                                    $rr=$Vivienda->query($sql);
	                                if ($rrr=$rr->fetch_array()){
                                        $paqcorr=$rrr['IdPaquetes'];
                                        $listcorr=$rrr['ListaAplicacion'];	                                            
                                                                                  
                                        if ($paqcorr==$IdPaquetes && $listcorr==$ListaAplicacion && $bandera==1){
                                            //echo "<script >traearray()</script>";
                                            guardaConfigProg($IdPrograma,$nitavu,$AreaAplicacion,$tablaconceptos,$fecha);
                                            
                                        }else{   
                                            mensaje('El paquete o alguno de los municipios ya se encuentra en una corrida financiera, verifique su información','programas_alta2.php?Id='.$IdPrograma);         
                                          
                                        }
                                    }
                                } */
                                /* else{  
                                    $sql="";        
                                    $sql = "CALL sp_RegistraPrograma(".IdNuevo('CREDITOS','IdCredito').",".$DiasdeGracia.",0,".$IdPagoInicial.",".$IdPrograma.",".$IdTipoMoneda.","
                                    .$IdTipoPago.",".$IngresoIFin.",".$IngresoIni.",".$MontoCredito.",".$MontoIntMora.",".$MontoPago.",".$MontoPagoInicial.",".$MontoUltimoPago.",".
                                    $PeriodoMora.",1,".$TasaAnualFin.",". $TasaIntMora.",".$TipoIntMoratorio.",". $TotalPagos.",0,0,'".
                                    $IdPaquetes."',".$Cancelado.",'".$ListaAplicacion."','".$AreaAplicacion."',0,".$gtsadmon.",".$segurovida.",'". $fecha."',".$nitavu.")";
                                    $bandera=1;
                                    //echo $sql;
                                        if ($Vivienda->query($sql) == TRUE){

                                            guardaConfigProg($IdPrograma,$nitavu,$AreaAplicacion,$tablaconceptos,$fecha,$ListaAplicacion);

                                            //echo "<script type='text/javascript' src='lib/crudprogramas.js'>traearray()</script>";
                                            //echo "<script >traearray()</script>";
                                           // mensaje('Registrado array con éxito','');
                                            mensaje('Registrado con éxito','programas_alta2.php?Id='.$IdPrograma);  
                                        }
                                } */
                                                                    
                           /*  }
                            
                         } */

                }else{
                    $sql="";
                    $idcrediton=IdNuevo('CREDITOS','IdCredito');
                    $sql = "CALL sp_RegistraPrograma(".IdNuevo('CREDITOS','IdCredito').",".$DiasdeGracia.",0,".$IdPagoInicial.",".$IdPrograma.",".$IdTipoMoneda.","
                        .$IdTipoPago.",".$IngresoIFin.",".$IngresoIni.",".$MontoCredito.",".$MontoIntMora.",".$MontoPago.",".$MontoPagoInicial.",".$MontoUltimoPago.",".
                        $PeriodoMora.",1,".$TasaAnualFin.",". $TasaIntMora.",".$TipoIntMoratorio.",". $TotalPagos.",0,0,'".
                        $IdPaquetes."',".$Cancelado.",'".$ListaAplicacion."','".$AreaAplicacion."',0,".$gtsadmon.",".$segurovida.",'". $fecha."',".$nitavu.")";
                    if ($Vivienda->query($sql) == TRUE){                        
                        guardaConfigProg($IdPrograma,$nitavu,$AreaAplicacion,$tablaconceptos,$fecha,$ListaAplicacion,$idcrediton);                        
                        mensaje('Registrado con éxito','programas_alta2.php?Id='.$IdPrograma);  
                    }
                }         
                
            }else{
                $IdPaquetes="";
                $sql="";
        
                                    $sql = "CALL sp_RegistraPrograma(".IdNuevo('CREDITOS','IdCredito').",".$DiasdeGracia.",0,".$IdPagoInicial.",".$IdPrograma.",".$IdTipoMoneda.","
                                    .$IdTipoPago.",".$IngresoIFin.",".$IngresoIni.",".$MontoCredito.",".$MontoIntMora.",".$MontoPago.",".$MontoPagoInicial.",".$MontoUltimoPago.",".
                                    $PeriodoMora.",1,".$TasaAnualFin.",". $TasaIntMora.",".$TipoIntMoratorio.",". $TotalPagos.",0,0,'".
                                    $IdPaquetes."',".$Cancelado.",'".$ListaAplicacion."','".$AreaAplicacion."',0,".$gtsadmon.",".$segurovida.",'". $fecha."',".$nitavu.")";

                                    //echo $sql;
                                        if ($Vivienda->query($sql) == TRUE){
                                           mensaje('Registrado con éxito','programas_alta2.php?Id='.$IdPrograma);  
                                        }else{
                                            mensaje('Hubo un problema','programas_alta2.php?Id='.$IdPrograma);  
                                            //echo $sql;
                                        }     
                
            }    
            
            // $Cancelado=0;
            // $MontoMinAut=0;
            // $MontoMaxAut=0;
            // $IngresoIni=0;
            // $IngresoIFin=0;
            // $MontoPagoInicial=$_POST['montopagoinicial2'];

            // $sql="";
        
            // $sql = "CALL sp_RegistraPrograma(".IdNuevo('CREDITOS','IdCredito').",".$DiasdeGracia.",0,".$IdPagoInicial.",".$IdPrograma.",".$IdTipoMoneda.","
            // .$IdTipoPago.",".$IngresoIFin.",".$IngresoIni.",".$MontoCredito.",".$MontoIntMora.",".$MontoPago.",".$MontoPagoInicial.",".$MontoUltimoPago.",".
            // $PeriodoMora.",1,".$TasaAnualFin.",". $TasaIntMora.",".$TipoIntMoratorio.",". $TotalPagos.",0,0,'".
            // $IdPaquetes."',".$Cancelado.",'".$ListaAplicacion."','".$AreaAplicacion."',0,".$gtsadmon.",".$segurovida.",'". $fecha."',".$nitavu.")";

            //  //echo $sql;
            //     if ($Vivienda->query($sql) == TRUE){
            //         mensaje('Registrado con éxito','programas_alta2.php?Id='.$IdPrograma);  
            //     }else{
            //         mensaje('Hubo un problema','programas_alta2.php?Id='.$IdPrograma);  
            //         //echo $sql;
            //     }     
    }            
}else{    

//$Programa=$_GET['Pgr'];
//$TipoAsigacion=$_GET['TA'];
$IdPrograma=$_GET['Id'];
$sql="";
$sql="Select * from programa where IdPrograma=".$IdPrograma;
$datosprog=$Vivienda->query($sql);
// echo'<pre>';
// var_dump($datosprog);
//echo'<pre>';
if ($datosprog1=$datosprog->fetch_array()){
    //echo 'este es el idtipoprograma'.$datosprog1['IdTipoPrograma'];    
}else{
    echo 'Ocurrio un error al cargar los datos del programa';
}

echo "<form id='formgral' action='programas_alta2.php' method='POST' style:'width:80%' >";
echo "<div style='width:100%;'>";
echo "<h1 style='width:100%; color: black;'>Configuración geográfica y financiera del programa</h1>";
//echo "<h1 style='color: steelblue;'>".$Programa."</h1>";
echo "<h1 style='color: steelblue;'>".$datosprog1['ProgramaGral']."</h1>";
echo "<input type='text' id='idtipoprograma' name='idtipoprograma' value='".$datosprog1['IdTipoPrograma']."'>";
echo "<input type='text' id='idtipotramite' name='idtipotramite' value='".$datosprog1['IdTipoTramite']."'>";
echo "<input type='hidden' id='tipoasignacion' value='".$datosprog1['TipoAsignacion']."'>";
echo "<input type='hidden' name='idprograma' id='idprograma' value='".$IdPrograma."'>";
echo "<input type='text' name='listaaplicaciongeo' id='listaaplicaciongeo' >";
echo "<input type='text' name='areaaplicacion' id='areaaplicacion' >";
echo "<input type='text' name='areaaplicacionconfig' id='areaaplicacionconfig' value='".$datosprog1['AreaAplicacion']."' >";
echo "<input type='hidden' name='montocredito2' id='montocredito2' value=0>";
echo "<input type='text' name='listapaq' id='listapaq'  >";
//echo "<input type='text' name='area2' id='area2'  >";
echo "<input type='hidden' name='montopagoinicial2' id='montopagoinicial2' value=0 >";
echo "<input type='hidden' name='tablacorrida' id='tablacorrida'>";
echo "<input type='hidden' name='respuesta' id='respuesta'>";
echo "<input type='hidden' name='usuario' id='usuario' value='".$nitavu."'>";
echo "<input type='hidden' name='correcto' id='correcto' >";
echo "<input type='hidden' name='cargosiniciales' id='cargosiniciales' value='".$datosprog1['CargosIniciales']."' >";
echo "<input type='hidden' name='ch1' id='ch1' value=0 >";
//$noguardar=0;


echo "</div><br><br>";

//echo "<div name='resultado' id='resultado'></div>";

 $idtipoprog=$datosprog1['IdTipoPrograma'];
if ($datosprog1['IdTipoPrograma']==1  ){
    //Si es programa de material select con paquetes de material elegidos
    echo "<div id:'dlistapaquetes'><label style='font-size: 18;'>Paquetes seleccionados en el alta del programa</label>";
            echo "<select name='listaPaquetes' class='custom-select' id='listaPaquetes'  onchange='ShowSelected();'>"; 

           // $lixta=extraelista('ListaIdPaqueteMat','programa','IdPrograma',$IdPrograma);
            //$lixta=buscaidconcepto('ListaIdPaqueteMat','programa','IdPrograma',$IdPrograma);
            
            //$lixta=extraelista('ListaIdPaqueteMat','programa','IdPrograma',$IdPrograma);
              //  echo $lixta;
                 $sql="";
                 $sql = "SELECT * FROM paquetematerial WHERE IdPaqueteMaterial in (".extraelista('ListaIdPaqueteMat','programa','IdPrograma',$IdPrograma).")";
                //echo $sql;
                //echo "<div>".$sql."</div>";  
                $v = $Vivienda -> query($sql);
                 while($vv = $v -> fetch_array())
                { 
                    // resultado de la busqueda.................
                    echo "<option value='".$vv['IdPaqueteMaterial']."' >".$vv['PaqueteMaterial']. "</option>";
                }  
                //echo "<option value='".$vv['IdPaqueteMaterial']."' selected>".buscaidconcepto('PaqueteMaterial', 'paquetematerial','IdPaqueteMaterial', $f['IdPaqueteMaterial'] ? $f['IdPaqueteMaterial']  : '0' )."</option>";
                //.buscaidconcepto('TipoTramite', 'CatTipoTramite','IdTipoTramite', $f['IdTipoTramite'] ? $f['IdTipoTramite']  : '0' )."</option>";
             echo "</select>  ";                      
    echo "</div><br>";  
    echo "<div><span>";
           echo  "<input type='checkbox' id='todospaq' name='todospaq'>";    
           echo  "<label for='todospaq'> Todos los paquetes tendrán la misma corrida</label><br>";
           
    echo "</span></div>";
}else{
   // echo 'no es 1 es '.$idtipoprog;
   
}
            
// acordeon
echo "<div class='accordionProg' id='accordionExample' >";
                    //echo "<div class='accordionProg' id='accordionExample' style='color:#000000 background-color:white;  '>";
                            echo "<div class='card' style='width: 100%;'>";
                                    echo "<div class='card-header' id='headingOne' style='width: 100%;'>";
                                            echo "<h2 >";
                                            //class='mb-0'
                                            echo "<button id='acordgeo' class='btn btn-link btn-block text-left collapsed'  type='button' data-toggle='collapse' data-target='#collapseOne' aria-expanded='false' aria-controls='collapseOne' >";
                                            //style='  writing-mode: horizontal-tb; color:red;'
                                            echo "Seleccione la aplicación geográfica de este programa";
                                            echo "<img id='checkgeo' src='img/check.jpg' style='display:none ;float:right' >";                                            
                                            echo "</button>";
                                            echo "</h2>";
                                    echo "</div>";

                                    echo "<div id='collapseOne' class='collapse' aria-labelledby='headingOne' data-parent='#accordionExample' style=' width: 100%;  align-content: center;' >";
                                            //style=' transform: rotate(120deg);'
                                            echo "<div class='card-body'>";                        
                                                    echo "<div class='container' >";
                                                        echo "<div class='btn-group' role='group' aria-label='Basic example' style='width: 90%;'>";
                                                            echo "<button id='atodos' type='button' class='btn btn-secondary' style='background: dodgerblue;' style='background: dodgerblue; width: 20%;'>Todas las delegaciones y sus municipios</button>";
                                                            if ($datosprog1['AreaAplicacion']=='D' ){
                                                            echo "<button id='adelegaciones' type='button' class='btn btn-secondary' style='background: dodgerblue; width: 33%;'>Seleccionar delegaciones</button>";
                                                            }
                                                            if ($datosprog1['AreaAplicacion']=='M' ){
                                                            echo "<button id='amunicipios' type='button' class='btn btn-secondary' style='background: dodgerblue; '>Seleccionar municipios</button>";
                                                            }
                                                        echo "</div>";
                                                        //echo "<div id='geo1' style='display:none'>";
                                                        echo "<div id='geo1' style='display:none; background: lightskyblue;padding: 15px;'> ";
                                                            echo "<label>Este programa aplicará a todas las delegaciones y sus municipios</label>";                                                        
                                                            echo "<br><button id='btngeo1' type='button' class='btn btn-primary' 1ck='deseleccionar_municipios();deseleccionar_delegaciones();'>Aceptar</button>";
                                                        echo "</div>";
                                                        
                                                        //echo "<div class='row row-cols-3' id='geo2' style='display:none; width:800px; text-align:-webkit-left; font-size:13px; background-color: skyblue;padding: 15;'  >";     
                                                        echo "<div class='container'>";
                                                            echo "<div class='row' id='geo2' style='display:none; width:600px; text-align:-webkit-left; font-size:13px; background-color: skyblue;padding: 15;'  >";     
                                                                        $sql = "SELECT * FROM delegaciones WHERE IdDelegacion in(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,20,65,66,67,68,69)  ORDER by DELEGACION ASC";
                                                                        //$sql = "SELECT * FROM delegaciones WHERE Tipo=0  ORDER by DELEGACION ASC";
                                                                        $v = $Vivienda -> query($sql);                                                                
                                                                        while($vv = $v -> fetch_array())
                                                                        { 
                                                                        //echo "<div class='col'   ><input type='checkbox' class='form-check-input'   name='delegaciones[]' id='delegaciones[]' value='".$vv['IdDelegacion']."'>".$vv['Delegacion']."</div>";
                                                                        echo "<div class='col-sm-3'   ><input type='checkbox' class='form-check-input'   name='delegaciones[]' id='delegaciones[]' value='".$vv['IdDelegacion']."'>".$vv['Delegacion']."</div>";
                                                                        
                                                                        }
                                                                        echo "<br><button id='btngeo2' type='button' class='btn btn-primary'>Aceptar</button>";    
                                                            echo "</div>";                  
                                                        echo "</div>";   
                                                        echo "</div>";
                                                        echo "<div class='container'>"; 
                                                            echo "<div class='row' id='geo3' style='display:none; width:900px; text-align:-webkit-left; font-size:12px; background-color: powderblue;padding: 15;'  >";     
                                                                        $sql = "SELECT * FROM municipios  WHERE not IdMunicipio in (44) ORDER by Municipio ASC";
                                                                        $v = $Vivienda -> query($sql);                                                                
                                                                        while($vv = $v -> fetch_array())
                                                                        { 
                                                                        echo "<div class='col-sm-2'   ><input type='checkbox' class='form-check-input'   name='municipios[]' id='municipios[]' value='".$vv['IdMunicipio']."'>".$vv['Municipio']."</div>";                                                        
                                                                        }
                                                                        echo "<br><button id='btngeo3' type='button' class='btn btn-primary'>Aceptar</button>";
                                                            echo "</div> ";                          
                                                        echo "</div> "; 
                                                        
                                            echo "</div>";
                                              
                                    echo "</div>";
                            echo "</div> "; 
                            //segundo
                            //if ($datosprog1['IdTipoPrograma']==1) {
                            if ($datosprog1['CargosIniciales']==1 ){
                            echo "<div class='card' style='width: 100%;'>";
                                echo "<div class='card-header' id='headingTwo' style='width: 100%;'>";
                                            echo "<h2 >";
                                            echo "<button id='acordcorrida' class='btn btn-link btn-block text-left collapsed'  type='button' data-toggle='collapse' data-target='#collapseTwo' aria-expanded='false' aria-controls='collapseTwo' >";
                                            echo "Corrida Financiera";
                                            echo "<img id='checkgeo2' src='img/check.jpg' style='display:none ;float:right' >"; 
                                            echo "</button>";
                                            echo "</h2>";
                                echo "</div>";
                                echo "<div id='collapseTwo' class='collapse' aria-labelledby='headingTwo' data-parent='#accordionExample' style=' width: 100%;  align-content: center;' >";
                                        echo "<div class='card-body'>";                        
                                             echo "<div class='container' style='width: 100%; margin-left: auto; margin-right: auto;'>"; 

                                                            //echo "<section >  segunda seccion";
                                                    echo "<div class='centrarxx' style='width:80%; background: border-box;'><h3 style='font-size: 1.4rem;'>Registro de conceptos iniciales de cuenta</h3><br>";    
                                                       echo "<button  type='button' id='crearApertura' class='btn btn-success' >Iniciar</button>";
                                                    echo "</div>";
                                                    
                                                    //tabla
                                                    // echo "<table>";
                                                    // echo "<tr><td>";
                                                    echo "<div id='FormApertura' class='centrarxx' style='width: 80%;' >";        // style='width:50%; background: border-box;'
                                                            //display:block; margin-left: auto; margin-right: auto;
                                                                echo "<b><label for='ConceptoApertura' style='color: black;'>Concepto de apertura del programa</label></b>";       
                                                                echo "<select name='ConceptoApertura' class='custom-select' id='ConceptoApertura' style='height: 30px; font-size: 13px; width: 80%;' >";
                                                                //onchange='mostrarValor(this.options[this.selectedIndex].innerHTML, this.value)'
                                                                $sql = "SELECT * FROM descripcionmovimiento where IdTipoCuenta=1 ORDER by DescripcionMovimiento ASC";
                                                                $v = $Vivienda -> query($sql);
                                                                while($vv = $v -> fetch_array())
                                                                { // resultado de la busqueda.................
                                                                    echo "<option value='".$vv['idTipoMov']."' >".$vv['DescripcionMovimiento']. "</option>";
                                                                }            
                                                                echo "</select>  ";
                                                                
                                                                echo $vv['idTipoMov'];
                                                               
                                                                echo "<input type='text' id='precio' placeholder='Escriba el monto' style='display:inline-block; height: 30px; font-size: 13px; width: 286px;'>";
                                                                echo "<button  type='button' id='insertar' class='btn btn-success' style='height: 30px; font-size: 13px; top:-4;' >Agregar</button>";
                                                                echo "<button  type='button' id='modificar' class='btn btn-success' style='display:none;height: 30px; font-size: 13px; top:-4; ' >Modificar</button>";

                                                                //echo "<button  type='submit' id='insertar' class='btn btn-success' style='height: 30px; font-size: 13px; top:-4;' >Agregar</button>";
                                                                //echo "<button  type='submit' id='modificar' class='btn btn-success' style='display:none;height: 30px; font-size: 13px; top:-4; ' >Modificar</button>";
                                                                
                                                    echo "</div>"; //div formapertura
                                                        
                                                    echo "<div id='section2' class='centrarxx' style='width: 80%;' >"; //style='width:50%;'
                                                                echo "<b><label style='color: black;'>Seleccione los conceptos secundarios a aplicar (subsidios) </label><b><br>";
                                                                //echo "<label >Subsidios y más</label>";
                                                               
                                                                echo "<select name='ConceptoApertura2' class='custom-select controlesle' id='ConceptoApertura2' style='height: 30px; font-size: 13px; width: 80%;' >";
                                                                //style='height: 30px; font-size: 13px;'
                                                                $sql = "SELECT * FROM descripcionmovimiento where IdTipoCuenta=2 ORDER by DescripcionMovimiento ASC";
                                                                $v = $Vivienda -> query($sql);
                                                                while($vv = $v -> fetch_array())
                                                                { // resultado de la busqueda.................
                                                                    echo "<option value='".$vv['idTipoMov']."' >".$vv['DescripcionMovimiento']. "</option>";
                                                                }            
                                                                echo "</select>  ";   

                                                                echo "<input type='text' id='precio2' placeholder='Escriba el monto' style='display:inline-block; height: 30px; font-size: 13px; width: 286px;'>";
                                                                echo "<button  type='button' id='insertar2' class='btn btn-success' style='height: 30px; font-size: 13px; top:-4;' >Agregar</button>";
                                                                echo "<button  type='button' id='modificar2' class='btn btn-success' style='display:none; height: 30px; font-size: 13px; top:-4;' >Modificar</button>";
                                                                //echo "<button  type='submit' id='insertar2' class='btn btn-success' style='height: 30px; font-size: 13px; top:-4;' >Agregar</button>";
                                                                //echo "<button  type='submit' id='modificar2' class='btn btn-success' style='display:none; height: 30px; font-size: 13px; top:-4;' >Modificar</button>";

                                                    echo "</div>";    //section2  
                                                    
                                                    // echo "</td><td>";       
                                                    echo "<br>";        
                                                    echo "<br>";        
                                                    echo "<div id='section3' class='centrarxx' style='margin-left: initial;'>";    
                                                                 echo "<table id='listaProductos'  style='width:715px;  border-collapse: collapse;' border='1' class='table table-borderer' >";    
                                                                 echo "</table>"; 

                                                                 echo "<table style='width:600px'>";
                                                                    echo "<tr><td style='width:400px'>Monto inicial:</td><td name='cargoinicial'id='cargoinicial' style='width:300px; text-align:end;'>0.00</td></tr>";
                                                                    echo "<tr><td>Abonos Iniciales:</td><td id='subsidios' style='width:300px; text-align:end;'>0.00</td></tr>";
                                                                    echo "<tr><td>Por Pagar:</td><td id='porpagar' style='width:400px; text-align:end; font-weight:bold;'>0.00</td></tr>";
                                                                    echo "<tr>";
                                                                    echo "<td>";
                                                                    echo "<div class='centrarxx' style='width:50%; background: border-box; '><button  type='button' id='eliminarCorrida' class='btn btn-danger' style='font-size:13px;' >Eliminar Tabla</button></div>";                                                                    
                                                                    echo "</td><td>";
                                                                    echo "<div class='centrarxx' style='width:50%; background: border-box; '><button  type='button' id='guardarCorrida' class='btn btn-primary' style='font-size:13px;' >Guarda Conceptos</button></div>"; 
                                                                    echo "</td></tr>";               
                                                                 echo "</table>";                                                               
                                                                 
                                                    echo "</div>";                                                       
                                            echo "</div> ";    //div container                      
                                        echo "</div>"; //div card body                                              
                                echo "</div>"; //div collpse two
                            echo "</div> "; 
                        } //fin if
                            //fin segundo

                            //tercero                            
                            echo "<div class='card' style='width: 100%;'>";
                                echo "<div class='card-header' id='headingThree' style='width: 100%;'>";
                                    echo "<h2 >";                                           
                                    echo "<button id='acordfinan' class='btn btn-link btn-block text-left collapsed'  type='button' data-toggle='collapse' data-target='#collapseThree' aria-expanded='true' aria-controls='collapseThree' >";
                                            echo "Datos financieros del programa";
                                            echo "<img id='checkgeo3' src='img/check.jpg' style='display:none ;float:right' >"; 
                                    echo "</button>";
                                    echo "</h2>";
                                echo "</div>";                                
                                echo "<div id='collapseThree' class='collapse' aria-labelledby='headingThree' data-parent='#accordionExample' style='text-align: initial;  width: 100%;  align-content: center;' >";                                  
                                            echo "<div class='card-body' style='width: 100%;'>";                        
                                                    echo "<div class='container' style='width: 100%; margin-left: auto; margin-right: auto;' >";                                                           
                                                            //***
                                                            echo '<div class="card " style="text-align: justify; width: 100%;">
                                                            <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Datos del Crédito</h1>';     
                                                            echo '<center>';          
                                                            echo '<div class="row" style="width:98%; margin: 0px;">';  
                                                                //*** INTERESES  */     
                                                                echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; margin: 0px;">'; 
                                                                    echo '<br>';  
                                                                    echo '<h6 class="card-title">Tasa de Financiamiento</h6>';                               
                                                                    echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;' >";
                                                                    
                                                                    echo "<tr>";
                                                                        echo "<td style='width:50%'><span class='normal'>Tasa Anual</span></td>";                           
                                                                        echo "<td><span>
                                                                        <input  type='text' style='width:130px'  class='textfinanc' name='TasaAnualFin' id='TasaAnualFin' value='0'>%</span></td>";
                                                                    echo "</tr>";                   
                                                                        
                                                                    echo "</table>";
                                                                    echo "<br>";
                                    
                                                                    echo '<h6 class="card-title">Interes Moratorio</h6>';                               
                                                                    echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>
                                                                        <tr>
                                                                            <td><span class='normal'>Tipo de Interés Mensual</span></td>
                                                                            <td><span>
                                                                            <select name='TipoIntMoratorio' class='custom-select ' id='TipoIntMoratorio' onchange='seleccionasigTIM();' style='height: 30px;font-size: 13px;'  >
                                                                            <option value='1'>Tasa Interés %</option>
                                                                            <option value='0'>Monto Fijo $</option></select>
                                                                            </span>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><span class='normal' >Monto Interés Moratorio</span></td>
                                                                            <td><span></span>
                                                                            <input  type='text' class='textfinanc' name='TasaIntMora' id='TasaIntMora' value='0'></td>                                     
                                                                            </tr>";
                                                                    
                                                                    echo "<tr>
                                                                            <td><span hidden class='normal'>Periodo de Moratorio</span></td>
                                                                            <td><span></span>
                                                                            <input  type='hidden' class='textfinanc'  name='PeriodoMora' id='PeriodoMora' value='30'></td>
                                                                        </tr>";                                                        
                                                                    echo "</table>";
                                                                echo '</div>';                                            
                                                                //*** CREDITO */
                                                                echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; margin: 0px;">';
                                                                echo '<br>'; 
                                                                    echo '<h6 class="card-title">Crédito</h6>';                                
                                                                    echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>
                                                                    <tr>
                                                                        <td><span class='normal'>Tipo de Moneda</span></td>
                                                                        <td><span>
                                                                        <select name='TipoMoneda' class='custom-select ' id='TipoMoneda'  style='height: 30px;font-size: 13px;' >";
                                                                            $sql = "SELECT * FROM tipomoneda where IdTipoMoneda<>0 ";
                                                                            $v = $Vivienda -> query($sql);
                                                                            while($vv = $v -> fetch_array())
                                                                            { // resultado de la busqueda.................
                                                                                echo "<option value='".$vv['IdTipoMoneda']."' >".$vv['TipoMoneda']. "</option>";
                                                                            }            
                                                                            echo "</select>  ";
                                                                            
                                                                            echo $vv['IdTipoMoneda'];
                                                                        echo "</span>
                                                                        <input  type='hidden'   name='IdTipoMoneda' id='IdTipoMoneda' value=''></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class='normal'>Monto Total</span></td>
                                                                        <td><span>  
                                                                            <input type='text' name='montocredito' id='montocredito'  style='text-align:end;' class='textfinanc' value='0.00' disabled > 
                                                                            
                                                                        </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class='normal'>Tipo de Pago Inicial</span></td>
                                                                        <td><span>
                                                                        <select name='IdPagoInicial' class='custom-select ' id='IdPagoInicial' onchange='seleccionasigIDPI();'  style='height: 30px;font-size: 11px;'  >";
                                                                            $sql = "SELECT * FROM tipopagoinicial where not IdPagoInicial in(10) ";
                                                                            $v = $Vivienda -> query($sql);
                                                                            while($vv = $v -> fetch_array())
                                                                            { // resultado de la busqueda.................
                                                                                echo "<option value='".$vv['IdPagoInicial']."' >".$vv['PagoInicial']. "</option>";
                                                                            }            
                                                                            echo "</select>  ";
                                                                            
                                                                            echo $vv['IdPagoInicial'];
                                                                        
                                                                        echo "</span>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class='normal'>Monto Pago Inicial $</span></td>
                                                                        <td><span>  
                                                                        <input  type='text'   name='MontoPagoInicial' id='MontoPagoInicial' class='textfinanc' onblur='dejacampoMPI();' style='text-align:end;'  value='0.00' disabled>
                                                                        </span></td>
                                                                    </tr>";
                                                                    
                                                                    echo "<tr>";
                                                                        
                                                                        echo "<td><span class='normal'>Subsidio $</span></td>
                                                                        <td><span> 
                                                                            <input  type='text' name='TotSubs' id='TotSubs' class='textfinanc' value='0.00' style='text-align:end;' disabled>
                                                                        </span></td>
                                                                    </tr>";
                                                                    echo "<tr>
                                                                    <td><span class='normal'>Total a Financiar $</span></td>";                              
                                                                    
                                                                    echo "<td><span>
                                                                        <input  type='text' name='TotFinan' id='TotFinan' class='textfinanc'  value='0.00' style='text-align:end;' disabled>
                                                                    </span>
                                                                    </tr>";                                            
                                                                    echo "</table>";
                                                                echo '</div>';
                                    
                                                                 //*** FORMA DE PAGO */
                                                                echo ' <div class="col-xs-6 col-md-4" style="text-align: justify; margin: 0px;">'; 
                                                                echo '<br>';     
                                                                    echo '<h6 class="card-title">Forma de Pago</h6>';   
                                                                    echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;'>
                                                                        <tr>
                                                                            <td><span class='normal'>Tipo de Pago</span></td>
                                                                            <td><span>
                                                                                <select name='TipoPago' class='custom-select controlesle textfinanc' id='TipoPago' style='height: 30px;font-size: 13px;' >";
                                                                                $sql = "SELECT * FROM tipopago where not IdTipoPago in(0,1,2,4) ";
                                                                                $v = $Vivienda -> query($sql);
                                                                                while($vv = $v -> fetch_array())
                                                                                { // resultado de la busqueda.................
                                                                                    echo "<option value='".$vv['IdTipoPago']."' >".$vv['TipoPago']. "</option>";
                                                                                }            
                                                                                echo "</select>  ";
                                                                            echo "</span>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td><span class='normal'>N° de Pagos</span></td>
                                                                            <td><span></span>
                                                                            <input  type='text' class='textfinanc'   name='TotalPagos' id='TotalPagos' value='0' ><button  type='button' class='btn btn-primary btn-sm' id='calccorrida'>Calcula Corrida</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><span class='normal'>Monto de Pago $ </span></td>
                                                                            <td><span>
                                                                            <input  type='text' class='textfinanc'  name='MontoPago' id='MontoPago' value='0.00'  ></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><span class='normal'>Monto Ultimo Pago $</span></td>
                                                                            <td><span> 
                                                                            <input  type='text' class='textfinanc'  name='MontoUltimoPago' id='MontoUltimoPago' value='0.00'></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><span class='normal'>Gts.Administratios $</span></td>
                                                                            <td><span> 
                                                                            <input  type='text' class='textfinanc'  name='GtsAdmon' id='GtsAdmon' value='0.00'></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><span class='normal'>Seguro de vida $</span></td>
                                                                            <td><span> 
                                                                            <input  type='text' class='textfinanc'  name='SeguroVida' id='SeguroVida' value='0.00'></span></td>
                                                                        </tr>";                                                                    
                                                                         
                                                                                                               
                                                                    echo "</table>";

                                                                   /*  echo '<br>';  
                                                                    echo '<h6 class="card-title">Beneficiario</h6>';                               
                                                                    echo "<table style='width:90%; margin-left: 20px; font-size: 10pt;' >";
                                                                    
                                                                    echo "<tr>";
                                                                        echo "<td><span class='normal'>Aportación</span></td>";                           
                                                                        echo "<td><span>$ </span>
                                                                        <input  type='hidden'   name='TotalAbonado' id='TotalAbonado' value=''>
                                                                        </td>";
                                                                    echo "</tr>";             */       
                                                                        
                                                                    echo "</table>";                               
                                                                echo '</div>';
                                                             echo '</div>';
                                                             echo '</center>';  

                                                echo '</div>';    

                                                            //***
                                                            echo "<div  style='width:50%; background: border-box; display: block;  margin-left: auto;'><button  type='button' id='guardacredito'  class='btn btn-primary' style='font-size:13px;'>Guardar Datos de Crédito</button></div>";    
                                                            if ($datosprog1['CargosIniciales']==1 ){
                                                                echo "<div  style='width:50%; background: border-box; display: block;  margin-left: auto;'><button  type='submit' id='guardarFinal' name='guardarFinal'  class='btn btn-primary' style='font-size:13px;' disabled >Guardar Esquema Financiero</button></div>";    
                                                                //echo "<div  style='width:50%; background: border-box; display: block;  margin-left: auto;'><button  type='submit' id='guardarFinal' name='guardarFinal' onclick='traearray();' class='btn btn-primary' style='font-size:13px;' disabled >Guardar Esquema Financiero</button></div>";    
                                                            }else{
                                                                echo "<div  style='width:50%; background: border-box; display: block;  margin-left: auto;'><button  type='submit' id='guardarFinalSinConc' name='guardarFinalSinConc'  class='btn btn-primary' style='font-size:13px;' disabled >Guardar Esquema Financiero</button></div>";    
                                                            }    
                                                            //echo "<div  style='width:50%; background: border-box; display: block;  margin-left: auto;'><button  type='button' name='guardarFinal'  class='btn btn-primary' style='font-size:13px;'  >Guardar Corrida Financiera</button></div>";    
                                                            //onclick='GuardaCorrida()'                 
                                                    echo "</div> ";                          
                                            echo "</div>";                                        
                                echo "</div>";
                                //echo "</div> ";
                            echo "</div> "; 
                             //fin tercero

echo "</div>";

  

echo "</form>";   
}
?>



<!-- <script >



 var formul=document.querySelector("#FormApertura");
   
    formul.addEventListener('submit',() => {
            alert(' presiono RegistraApertura');

            var tabla = document.querySelector("#tablaconcepto");
            var concepto = document.querySelector("#ConceptoApertura").value;
            var nuevoconcepto = document.createElement('td');
            console.log(concepto);
            nuevoconcepto.append(concepto);
            tabla.append(nuevoconcepto);
        }); 

</script>    -->

<!-- $("#crearApertura").click(function(){
        
        alert('RegistraApertura');
        
    }); 
    -->


     <script type="text/javascript" src="lib/crudprogramas.js"></script> 

    <script>
        
    
       


    /* function GuardaCorrida(IdPrograma){
        alert('entre  a javascript');
        var prob=0;
    if (document.querySelector('#checkgeo').style.display=='none'){
        alert('No ha elegido la Aplicación Geográfica');
        prob=1;
    }
    if (document.querySelector('#checkgeo2').style.display=='none'){
        alert('No ha registrado los conceptos para la Corrida Financiera');
        prob=1;
    }
    if (prob==1){
        alert('COMPLETE EL REGISTRO ANTES DE GUARDAR');
    }else{
        IdPagoInicial=$('#IdPagoInicial').val();
        IdPrograma=$('#idprograma').val();
        IdTipoMoneda=$('#IdTipoMoneda').val();
        IdTipoPago=$('#IdTipoPago').val();
        MontoCredito=$('#cargoinicial').val();
        TipoIntMoratorio=$('#TipoIntMoratorio').val();
        if (TipoIntMoratorio==0){
                MontoIntMora=$('#TasaIntMora').val();
            }else{
                MontoIntMora=0;                
            }    
        MontoPago=$('#MontoPago').val();    
        MontoPagoInicial=$('#MontoPagoInicial').val();
        MontoUltimoPago=$('#MontoUltimoPago').val();
        PeriodoMora=30;
        TasaAnualFin=$('#TasaAnualFin').val();  
        if (TipoIntMoratorio==1){
            TasaIntMora=$('#TasaIntMora').val();    
        }else{
            TasaIntMora=0;                    
            }    
        TotalPagos=$('#TotalPagos').val();
        IngresoIni=$('#IngresoIni').val();
        IngresoIFin=$('#IngresoIFin').val();
        IdPaquetes=$('#listaPaquetes').val();
        console.log('paquete'+IdPaquetes);
        ListaAplicacion=$('#listaaplicaciongeo').val();
        AreaAplicacion=$('#areaaplicacion').val();
        console.log('area'+AreaAplicacion);
        console.log('listageo'+ListaAplicacion);
        //var idconcepto = document.getElementById('ConceptoApertura').value;
        console.log('el programa es:'+IdPrograma);

        $('#preloader').show();
				$.ajax({
					url: 'programasinsert.php',
                                        type: 'post',			
                                        data: {IdCredito: IdCredito, DiasdeGracia:DiasdeGracia, IdDelegacion:IdDelegacion,
                                                IdPagoInicial:IdPagoInicial,        
                                                IdPrograma:IdPrograma, IdTipoMoneda:IdTipoMoneda,IdTipoPago:IdTipoPago,
                                                IngresoIni:IngresoIni,IngresoIFin:IngresoIFin,MontoCredito:MontoCredito,
                                                MontoIntMora:MontoIntMora,MontoPago:MontoPago,MontoPagoInicial:MontoPagoInicial,
                                                MontoUltimoPago:MontoUltimoPago,PeriodoMora:PeriodoMora,TasaAnualFin:TasaAnualFin,
                                                TasaIntMora:TasaIntMora,TipoIntMoratorio:TipoIntMoratorio,TotalPagos:TotalPagos,
                                                IdPaquetes:IdPaquetes,ListaAplicacion:ListaAplicacion,AreaAplicacion:AreaAplicacion,
                                                Cancelado:Cancelado},
					success: function(data){
					$('#resultado').html(data);
					$('#preloader').hide();
					}
				}); 
        alert('entre a guardar corrida');
        alert('GUARDADO CON EXITO');
    } */

    
  /*   ProgramaGral=$('#ProgramaGral').val();
    Ejercicio=$('#Ejercicio').val();
    FechaCaptura=$('#FechaCaptura').val();
    IdTipoPrograma=$('#IdTipoPrograma').val();
    Descripcion=$('#Descripcion').val();
    DiasdePago=$('#DiasdePago').val();
    Subsidiado=$('#Subsidiado').val();
    TipoImpVale=$('#TipoImpVale').val();
    IdTipoTramite=$('#IdTipoTramite').val();
    Informacion1=$('#Informacion1').val();
    Informacion2=$('#Informacion2').val();
    Activo=$('#Activo').val();
    ListaIdPaqueteMat=$('#arr').val();  
    TipoAsignacion=$('#TipoAsignacion').val();  
  
  alert(ListaIdPaqueteMat);
    //console.log(IdTipoPrograma);

    //console.log(IdPrograma);
    $('#preloader').show();
				$.ajax({
					url: 'data_programas.php',
                                        type: 'post',			
                                        data: {IdPrograma: IdPrograma, Programa:Programa, ProgramaGral:ProgramaGral,
                                                FechaCaptura:FechaCaptura,        
                                                Ejercicio:Ejercicio, IdTipoPrograma:IdTipoPrograma,Descripcion:Descripcion,
                                                DiasdePago:DiasdePago,Subsidiado:Subsidiado,IdTipoTramite:IdTipoTramite,
                                                Informacion1:Informacion1,Informacion2:Informacion2,
	                                        TipoImpVale:TipoImpVale,Activo:Activo,ListaIdPaqueteMat:ListaIdPaqueteMat,TipoAsignacion:TipoAsignacion},
					success: function(data){
					$('#resultado').html(data);
					$('#preloader').hide();
					}
				}); 
				

}*/

</script>

<!-- <script>
$("#crear").click(function(){
        alert('Entre aqui mismo');
    });


</script> -->

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include ("./lib/body_footer.php"); ?>
