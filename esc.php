<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php"); include ("./lib/body_menu.php");

?>
<?php
$id_aplicacion ="ap109"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);


if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
   xd_update('ap123',$nitavu);//guarda la experiencia del usuario
   historia($nitavu, "Entro a la aplicacion [ap123], para capturar un tramite de escritura.");

 /******************BUSCAR CONTRATO AL CUAL SELE VA INICIAR UN TRAMITE DE ESCRITURACION ************************************************/
 //codigo de la busqueda
 echo "<div id='divBusqueda' style='   
 background-color: rgba(53, 170, 11, 0.53);
 padding: 11px;
 margin: 10px;
   margin-right: 10px;
 border-radius: 5px;
 margin-right: -7px;
 position:fixed;
 width:800px;
 right:-750px;
 top:40px;'>";

 echo "<table width=100% border=0><tr><td width=30px>";
 echo "<img onclick='btnBuscar();'  src='icon/txtbuscar.png' style='width:30px; cursor:pointer;'></td><td>";
 echo "<input type='hidden' id='nitavu' name='nitavu' value='".$nitavu."'>";
 echo "<div style='
 width: 100%; padding-top: 0px; padding-bottom: 13px; margin-top: 7px;'>
 <table width=100%><tr><td width=90%>";
 echo "<input style=' height: 65px; border-radius: 5px; font-size: 18pt; font-family: Light; margin-left: 12px; padding: 10px; margin-right: 20px;
 'type='text' name='search' id='search' placeholder='Ingrese nombre del beneficiario o número de contrato'>";
 echo "</td><td>
 <button type='submit' onclick='BuscaContrato();' class='Mbtn btn-primary' id='indicaciones2' style='font-size: 8pt;  height: 60px; margin-top: -3px;
 margin-left: 5px;' onclick='v001.php'> <img src='icon/buscar2.png' style='width:40px;'>
 </button></td></tr></table></td>
 </div>"; 

 echo "<tr><td></td><td>";
 
 echo "<div id='BusquedaPreLoader' style='display:none;
 background-color: #ff8f00;
 padding: 10px;
 border-radius: 4px;
 text-align: center;
 color: white;'> Buscando <img src='img/loader_bar.gif'></div>";
 echo "<div class='' id='RespuestaCaja' style='overflow: auto;
 height: 500;'></div>";

 echo "</div></td></tr></table></div>";





 /******************BUSCAR TRAMITE DE ESCRITURA************************************************/
echo "<div id='BuscarUnTramite' style=' padding: 6px; background-color: #eeece6;
margin-top: 20px; margin-left: 0px; border-radius: 5px; border: 1px solid #f0e1c5; margin-right: -10px; '>";
echo '<div id="beta_buscar" style=" ">';
echo '<form action="" method="get">'; 
    echo '<input type="hidden" name="" id="brig" value="">';

    echo '<table broder="1" width="100%"><tr>';
        echo '<td> <input required="required" type="text" id="beta_buscar_input" name="NumContrato" placeholder="" /></td>';
        echo '<td align="right" width="15px">                    
        <button id="beta_buscar_boton">
        <img  src="icon/buscar.png"></button>
        </td>';
    echo '</tr></table>';
echo '</form>';
echo '</div>';



           if (isset($_GET['NumContrato'])){
             $NumContrato = $_GET['NumContrato'];

            //VARIABLES
            
            if (isset($_GET['Folio'])){
                $Folio = $_GET['Folio'];
              } else {
                $Folio = FolioNumContrato($NumContrato);
              }

            if (isset($_GET['IdPrograma'])){
                $IdPrograma = $_GET['IdPrograma'];
              } else {
                $IdPrograma = IdProgramaNumContrato($NumContrato);
              }

            if (isset($_GET['OriginData'])){
                $IdDelegacion = $_GET['OriginData'];
              } else {
                $IdDelegacion = IdDelegacionNumContrato($NumContrato);
              }

              /*********************************************************************************/              
               // VARIABLES
              $Idlote = numContratoLote($NumContrato);
             $costoEscritura=0;
             $causahabiente="";
             $causahabientemenor="";
             $observaciones="";
             $tipoCobro="tipoCobro";
             $saldoEscritura=0;
             $descuentoEscritura=0;
             $nombrecolonia="";
             $clavecatastral="";
             $SuperficieLote= ObtenerSuperficeLotes($Idlote);            
             $SuperficieLote=$SuperficieLote.str_ireplace(",","",$SuperficieLote);
             $idcolonia=coloniaLote($Idlote);
             $idmunicipio=coloniaLote($Idlote);     
             $idestatuscuenta = ObtenerIdEstatusCuenta($NumContrato);    
             $estatuscuenta=EstatusCuenta($NumContrato);
             $fechaemision=fechaEmisionContrato($NumContrato);
             $numescritura= ObtenerNumEscrituraConContrato($NumContrato);
             $nombrecolonia=nombreOficialColonia($idmunicipio, $idcolonia);
             $clavecatastral=ObtenerClaveCatastaral($Idlote);
             

             //echo 'ecoos'.CalculaMaximo("seguimiento", "IdConsecutivo", " And IdElemento = '" .$numescritura. "'", "", "");
              /*********************************************************************************/
              /*VALIDACIONES PREVIAS*/
              /* validacion nueva regla no se pueden escriturar lotes de superficie menor a cierto valor    */
               /*********************************************************************************/


             if(intval( $SuperficieLote)<1)
             {  /* excepcion a la regla unicamente para lotes comerciales de Tianguis Reynosa*/
              if (($idmunicipio == 32 And $idcolonia == 100) Or ($idmunicipio == 32 And $idcolonia == 24)) 
              {

              }
              else
              {
                  mensaje("Imposible continuar con el proceso de almacenamiento del lote, no cumple con LA SUPERFICIE SUFICIENTE (> 0) para realizar este tramite", 'escp.php');
              }
            }
              /*Validar que tenga un estatus cuenta*/
              if($idestatuscuenta!='')
              {
                if($idestatuscuenta<>1 and $idestatuscuenta<>2 and $idestatuscuenta<>3 and $idestatuscuenta<>9)
                {
                  mensaje( "La cuenta presenta un estatus (" .$estatuscuenta. ") en control contratos que no permite se pueda continuar con el tramite...","escp.php");
                }
              }
              else
              {
                mensaje( "El estatus de la cuenta asociada al contrato no esta definido favor de verificar la informacion, no se puede continuar","esc.php");
              }
             
             
              /* se verifica que se cuente con una fecha de asignacion - emision del contrato en el registro del contrato asociado al lote*/
              if($fechaemision=="" or $fechaemision==='0000-00-00')
              {
                mensaje("La fecha de emision registrada en el contrato esta vacia ,  y no permite se pueda continuar con el tramite.","esc.php");
              }
             
              /*  se verifica que el lote no tenga un tramite de escritura ya iniciado*/

             $idestatuslote= IdEstatusLote($Idlote);
              if($idestatuslote!="")
              {
                if($idestatuslote!=2)
                {
                  mensaje( "El lote presenta un estatus que no permite se pueda continuar con el tramite...","esc.php");
                }

              }else
              {
                mensaje( "El estatus del lote asociado al contrato no esta definido favor de verificar la informacion, no se puede continuar","esc.php");
              }
              if($numescritura=="")
              { 
                $observaciones="Modo y forma de asignación :";
                if(ValidarTramiteSoloEscritura($Idlote)=="FALSE")            
                {
                  $exigirSaldoTerreno=ExigirSaldoTerreno($Idlote);
                  if($exigirSaldoTerreno==0)
                  { 
                    $tipoCobro="Cobro en caja";
                    $observaciones=$observaciones."- Exigir saldo cero en terreno";
                    $saldoContrato=SaldoDeUnContrato($NumContrato);
                    if($saldoContrato<=1)
                    {
                    //   if($tipoCobro!="Sin cobro")
                      {                 
                        
                        }
                    }else{
                      mensaje( "Imposible iniciar con la solicitud de escrituración ya que tiene un saldo de $" .$saldoContrato. " hasta no ser cubierto se podra llenar la solicitud","esc.php");
                    }
                  }else
                  {
                    $tipoCobro="Sin cobro";
                    $observaciones=$observaciones."- No se necesita cubir el monto del terreno";
                  }

                  $exigircostoEscritura=ExigirCostoEscritura($Idlote);
                  if($exigircostoEscritura==0)
                  {
                    $observaciones=$observaciones."- Exigir pague monto de la escrituración";
                  }else
                  {
                    $observaciones=$observaciones."- No se necesita cubrir el monto de la escrituración";
                  }
                  
                  $idusodesuelo=6;                  
                  $datos=CostoDeLaEscritura($idusodesuelo);
                  $datosEscritura = explode("|", $datos);
                  $costoEscritura=$datosEscritura[0]; 
                  $descuentoEscritura=$datosEscritura[1]; 
                  $saldoEscritura= (float) $costoEscritura-(float) $descuentoEscritura;//$datosEscritura[2]; 

                }
              
              }else 
              {                
                if (!isset($_GET['NumEscritura'])){                
                  mensaje( "El lote referido ya tiene inscrito un proceso de escrituracion, no se puede registrar una nueva solicitud de escritura sobre este lote...".$numescritura,"esc.php?NumContrato=".$NumContrato."&NumEscritura=".$numescritura);
                 } }

              
          
               
                 if (isset($_GET['NumEscritura'])){
                 $sql="Select * from movescrituras where numescritura='".$numescritura."'";
                 $rc= $Vivienda -> query($sql);
                 $row_cnt = $rc->num_rows;
                     ECHO "<SCRIPT>Console.log('entro')</SCRIPT>";
                     if($row_cnt>0)
                     {
                       while($datos = $rc -> fetch_array())
                       {
                         $costoEscritura=$datos['MontoEscrituracion'];
                         $causahabiente=$datos['Persona1'];
                         $causahabientemenor=$datos['Persona2'];
                         $observaciones=$datos['Observaciones'];
                         $saldoEscritura=$datos['MontoEscrituracion'];
                     }
                       if($costoEscritura>0)
                     {
                       $tipoCobro="Cobro en caja";
                     }else
                     {
                       $tipoCobro="Sin cobro";    
                     }
                     $idusodesuelo=IdUsoDeSueloLote($Idlote);
                   }
                 }
       


     //OPCIONES DE ACCION
     echo "<center><div>";
     datosBeneficiarioenFormatoCorto($IdPrograma, $IdDelegacion, $Folio, $NumContrato);
     echo "<script> $('#beta_buscar_input').val('".$NumContrato."');</script>";
    echo "<div>";
    $Idlote = numContratoLote($NumContrato);
    
     // MUESTRA LOS DATOS
     echo '<br>';
     //*********************** DIV DEL TERRENO ************************************** 
     echo "<div style='width:80%' id=divTerreno>";
         echo '<div class="card" style="text-align: justify">
                 <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Datos del Terreno</h1>';
                 echo '<div class="card-body" style="font-size: 10pt">';                                                 
                 
                     if(($Idlote !='' and  $Idlote !='0' ) OR ($NumContrato !='' AND $NumContrato !=NULL)) 
                     {   //$Idlote = numContratoLote($NumContrato);                                                     
                         echo MuestraUbicacionLote($Idlote,'width: 90%;font-size: 10pt;');
                        
                         
                     } else
                     {
                       echo '<h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">No se encontro informacion</h1>';
                     }             
                 echo '</div>';
         echo '</div>';
     echo '</div>';           
     echo '<br>';  
     
        //*********************** DIV OTROS DATOS **************************************       
        echo "<div style='width:80%' id=divDatos>";
        echo '<div class="card" style="text-align: justify; width: 100%;">
                <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Medidas y Colindancias</h1>';
                echo '<div class="card-body" style="font-size: 10pt; width: 100%;">'; 
                     /* **************************** MEDIDAS Y COLINDANCIAS ***************************** */
                     echo MuestraMedidaColindanciasLote($Idlote,'width: 90%;font-size: 10pt;');        
                echo '</div>';
        echo '</div>';
    echo '</div>'; 
    echo '<br>';  

      //*********************** ESPECIFICACIONES DE ADJUDICACION **************************************       
      echo "<form id='formdatos' action='guardar_solicitud_esc.php?NumContrato=".$NumContrato."' method='POST'>";
     echo "<div style='width:80%' id=divDatos>";
     echo '<div class="card" style="text-align: justify; width: 100%;">
             <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Especificaciones de Adjudicación</h1>';
               echo '<div class="card-body" style="font-size: 10pt; width: 100%;">'; 
               echo '<div class="row" style="width:98%;margin:0px;">';                                    
               echo '<div class="col-md-4" style="text-align: center; padding: 2px; margin-right: 0px; padding: 10px;">';                 
               echo  "<span class='normal'>Tipo uso de suelo</span></td>";                           
               echo "<select  id='usodesuelo'  name='usodesuelo'  >";
               $sql2="select idusodesuelo, descripcion From catalogodeusodesuelo Where Cancelado = 0 Order By Descripcion"; 
             //echo $sql2;
             $r2 = $Vivienda -> query($sql2); 
             while($valor = $r2 -> fetch_array())
             {
                 
                echo $idusodesuelo;
                 if ($idusodesuelo==$valor['idusodesuelo'])
                 {echo "enro";
                 echo "<option value='".$valor['idusodesuelo']."' selected>".$valor['descripcion']."</option>";
                 }
                 else
                 {
                     echo "<option value='".$valor['idusodesuelo']."'>".$valor['descripcion']."</option>";
                 }
             }                           
             echo "</select>";                        
               echo '</div>';
            
               echo '<div id="divtipoCobro" name="divtipoCobro" class="col-md-2" style="text-align: center; padding: 2px; margin-right: 0px; padding: 10px;">';                 
               echo  "<span class='normal'>Tipo de cobro</span></td>";                           
               echo "<input  type='text'    name='tipocobro'  id='tipocobro' value='".$tipoCobro."'> ";
               echo '</div>';
               echo '<div id="divtipo" name="divtipo"  class="col-md-2" style="text-align: center; padding: 2px; margin-right: 0px; padding: 10px; display:none;">';                 
               echo  "<span class='normal'>Tipo uso de suelo</span></td>"; 
               echo "<select  id='usodesuelo2'  name='usodesuelo2'  >";
               echo "<option value=''>Baldio</option>";
               echo "<option value=''>Habitado</option>";
               echo '</select>';
               echo '</div>';
               echo '<div class="col-md-2" style="text-align: center; padding: 2px; margin-right: 0px; padding: 10px;">';                
               echo  "<span class='normal'>Costo de escritura </span></td>";                           
               echo "<input  type='text'  readonly  name='costoescritura'  id='costoescritura' value='".$costoEscritura."'  onchange='MASK(this,this.value,\"##,###,##0.00\",1);'> ";
               echo '</div>';    
               echo '<div class="col-md-2" style="text-align: center; padding: 2px; margin-right: 0px; padding: 10px;">';                
               echo  "<span class='normal'>Descueto de escritura </span></td>";                           
               echo "<input  type='text'  readonly   name='descuentoescritura'  id='descuentoescritura' value='".$descuentoEscritura."'> ";
               echo '</div>';  
               echo '<div class="col-md-2" style="text-align: center; padding: 2px; margin-right: 0px; padding: 10px;">';                
               echo  "<span class='normal'>Saldo de escritura </span></td>";                           
               echo "<input  type='text'  readonly  name='saldoescritura'  id='saldoescritura' value='".$saldoEscritura."'> ";
               echo '</div>';  
               // echo '<div class="col-md-2" style="text-align: center; padding: 2px; margin-right: 0px; padding: 10px;">';                
               // echo  "<span class='normal'>Clave Catastreal </span></td>";                           
               // echo "<input  type='text'    name='TelCasaAval'  id='TelCasaAval' value=''> ";
               // echo '</div>';  
             echo '</div>';
     echo '</div>';
   echo '</div>'; 



 //*********************** clave catastral **************************************
   echo '<br>'; 
   echo "<div style='width:100%' id=divDatos>";
   echo '<div class="card" style="text-align: justify; width: 100%;">
           <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">Informacion Adicional</h1>';
             echo '<div class="card-body" style="font-size: 10pt; width: 100%;">'; 
             echo '<div class="row" style="width:98%;margin:0px;">';                                    
           
             echo '<div class="col-md-6" style="text-align: center; padding: 2px; margin-right: 0px; padding: 10px;">';                
             echo  "<span class='normal'>Nombre de oficial de la colonia</span></td>";                           
             echo "<input  type='text'    name='nomcolonia'  id='nomcolonia' value='".$nombrecolonia."'> ";
             echo '</div>';  
             echo '<div class="col-md-6" style="text-align: center; padding: 2px; margin-right: 0px; padding: 10px;">';                
             echo  "<span class='normal'>Clave catastral</span></td>";                           
             echo "<input  type='text'    name='cvecastral'  id='cvecastral' value='$clavecatastral'> ";
             echo '</div>';   

             echo '<div class="col-md-6" style="text-align: center; padding: 2px; margin-right: 0px; padding: 10px;">';                
             echo  "<span class='normal'>Causa-Habiente, Para los casos de interdicion o muerte</span></td>";                           
             echo "<input  type='text'    name='causahabiente'  id='causahabiente' value='".$causahabiente."'> ";
             echo '</div>';  
             echo '<div class="col-md-6" style="text-align: center; padding: 2px; margin-right: 0px; padding: 10px;">';                
             echo  "<span class='normal'>En caso de que el Causa-Habiente sea menor de edad</span></td>";                           
             echo "<input  type='text'    name='causahabientemenor'  id='causahabientemenor' value='".$causahabientemenor."'> ";
             echo '</div>';
           echo '</div>';
           echo '<div class="col-md-12" style="text-align: center; padding: 2px; margin-right: 0px; padding: 10px;">';                
           echo  "<span class='normal'>Observaciones</span></td>";                           
           echo "<input  type='text'    name='observaciones'  id='observaciones' value='".$observaciones."'> ";
           echo '</div>';   
         echo '</div>';
   echo '</div>';
 echo '</div>'; 
     
echo "<br>";
if (!isset($_GET['NumEscritura'])){
echo '<div id="contenedor">
<div class="A">';
echo "<center><a href='formatoSolicitudEscritura.php?NumContrato=".$NumContrato."&vista' class='Mbtn btn-default'> Vista Preliminar
                </a></center></div>";
               


                
echo '<div class="B">';
echo "<button type='submit' class='Mbtn btn-default'  title='Grabar Solicitud' id='grabar'name='grabar'> <center>
                <table><tr><td valign='middle' align='center'>               
                </td>
                <td valign='middle' align='center' style='color:white;text-decoration: underline;' >
                Grabar Solicitud
                </td></tr></table>  </center> 
                </button>";
echo '</div>
</div>';
}


echo "</form>";
 //echo "<a href='formatoSolicitudEscritura.php?NumContrato=".$NumContrato ."&idusos=".."' class='Mbtn btn-default'> Vista Preliminar </a>"; 

     echo "</center>";       
             
             
             

 }

 



} else {mensaje("No tiene acceso a esta aplicacion",'');}

?>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>


<script>

function BuscaContrato(){
  //alert('entro');
  var search = $('#search').val();
  var nitavu = '<?php echo $nitavu; ?>';
  var mode = 1;

  $('#BusquedaPreLoader').show();
  $.ajax({
    url: "v001_data.php",
    type: "get",
    data: {search:search, nitavu:nitavu, mode:mode},
    success: function(data){    
       // console.log(data);           
      $("#RespuestaCaja").html(data+"\n");  
      $('#BusquedaPreLoader').hide();    
          
    }
  
  });
  
 
}

function btnBuscar(){
    valor  = $('#divBusqueda').css('right');
    if (valor == '0px') {
        $('#divBusqueda').css('right','-750');
    } 
    
    if (valor == '-750px') {
        $('#divBusqueda').css('right','0');
    }
}



function Seleccion(NumContrato, OriginData, IdDelegacion, IdPrograma, Folio){
   $('#beta_buscar_input').val(NumContrato); 
 
  
    var nc=parametroURL('NumContrato');
    if(nc!=null)
    {
      var url = location.hostname; 
      console.log(url);
      window.location.assign("ContratarCredito.php??NumContrato="+NumContrato+"&Folio="+Folio+"&IdPrograma="+IdPrograma+"&OriginData="+IdDelegacion); 
      //window.location.href =  "?NumContrato="+NumContrato+"&Folio="+Folio+"&IdPrograma="+IdPrograma+"&OriginData="+IdDelegacion; 
    }else{
      window.location.href = window.location.href + "?NumContrato="+NumContrato+"&Folio="+Folio+"&IdPrograma="+IdPrograma+"&OriginData="+IdDelegacion; 
    }

    
    btnBuscar();
}

function parametroURL(_par) {
  var _p = null;
  if (location.search) location.search.substr(1).split("&").forEach(function(pllv) {
    var s = pllv.split("="), //separamos llave/valor
      ll = s[0],
      v = s[1] && decodeURIComponent(s[1]); //valor hacemos encode para prevenir url encode
    if (ll == _par) { //solo nos interesa si es el nombre del parametro a buscar
      if(_p==null){
      _p=v; //si es nula, quiere decir que no tiene valor, solo textual
      }else if(Array.isArray(_p)){
      _p.push(v); //si ya es arreglo, agregamos este valor
      }else{
      _p=[_p,v]; //si no es arreglo, lo convertimos y agregamos este valor
      }
    }
  });
  return _p;
}


$( "#usodesuelo" ).change(function() {
  if(
  $( "#usodesuelo" ).val()==99)
  {  
   
    $('#divtipoCobro').css('display', 'none');
    $('#divtipo').css('display', 'inline-block');
    $( "#descuentoescritura" ).val("0.00");    
    $('#costoescritura').val("0.00");
    $( "#saldoescritura" ).val("0.00");
    $('#costoescritura').removeAttr("readonly");
    $('#costoescritura').focus();
  }
  else
  {
    $('#divtipoCobro').css('display', 'inline-block');
    $('#divtipo').css('display', 'none');
    idusodesuelo=$( "#usodesuelo" ).val();
    action="usodesuelo";
    $.ajax({
    url: 'valores_esc.php',
    type: "POST",
    async: true,
    data: {action:action,idusodesuelo:idusodesuelo},
    success: function(response)
     {     
        var data = $.parseJSON(response);
        console.log(data);
        $('#descuentoescritura').val(MASK('',data.Descuento,'##,###,##0.00',1));            
        $('#costoescritura').val(MASK('',data.Precio,'##,###,##0.00',1));
        var saldoesc=parseFloat(data.Precio)-(data.Descuento);
        $('#saldoescritura').val(MASK('',saldoesc,'##,###,##0.00',1)); // falta checar de donde viene       
      
      }

      });
  }
});


$( document ).ready(function() {
// $( "#usodesuelo" ).val(6);
 // $( "#usodesuelo" ).change();
});


  $("#costoescritura").keyup(function () {
      var value = $(this).val();
      $("#saldoescritura").val(MASK('',value,'##,###,##0.00',1));
  });

function MASK(form, n, mask, format) {
  if (format == "undefined") format = false;
  if (format || NUM(n)) {
    dec = 0, point = 0;
    x = mask.indexOf(".")+1;
    if (x) { dec = mask.length - x; }

    if (dec) {
      n = NUM(n, dec)+"";
      x = n.indexOf(".")+1;
      if (x) { point = n.length - x; } else { n += "."; }
    } else {
      n = NUM(n, 0)+"";
    } 
    for (var x = point; x < dec ; x++) {
      n += "0";
    }
    x = n.length, y = mask.length, XMASK = "";
    while ( x || y ) {
      if ( x ) {
        while ( y && "#0.".indexOf(mask.charAt(y-1)) == -1 ) {
          if ( n.charAt(x-1) != "-")
            XMASK = mask.charAt(y-1) + XMASK;
          y--;
        }
        XMASK = n.charAt(x-1) + XMASK, x--;
      } else if ( y && "$0".indexOf(mask.charAt(y-1))+1 ) {
        XMASK = mask.charAt(y-1) + XMASK;
      }
      if ( y ) { y-- }
    }
  } else {
     XMASK="";
  }
  if (form) { 
    form.value = XMASK;
    if (NUM(n)<0) {
      form.style.color="#FF0000";
    } else {
      form.style.color="#000000";
    }
  }
  return XMASK;
}
function NUM(s, dec) {
  for (var s = s+"", num = "", x = 0 ; x < s.length ; x++) {
    c = s.charAt(x);
    if (".-+/*".indexOf(c)+1 || c != " " && !isNaN(c)) { num+=c; }
  }
  if (isNaN(num)) { num = eval(num); }
  if (num == "")  { num=0; } else { num = parseFloat(num); }
  if (dec != undefined) {
    r=.5; if (num<0) r=-r;
    e=Math.pow(10, (dec>0) ? dec : 0 );
    return parseInt(num*e+r) / e;
  } else {
    return num;
  }
}

</script>