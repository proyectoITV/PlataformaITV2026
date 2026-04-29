l<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
include_once ("./lib/flor_funciones.php");
// contenido:
?>



<?php
$id_aplicacion ="ap104"; //Id de la aplicacion a cargar ( edicion de lotes)
$id_aplicacion2 ="ap109"; //Id de la aplicacion a cargar ( medidas)
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$nivel2 = aplicacion_nivel($id_aplicacion2, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE || sanpedro($id_aplicacion2, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
   //xd_update('ap89',$nitavu);//guarda la experiencia del usuario
   //historia($nitavu, "Entro a la aplicacion [ap89], para consultar las colonias");


// en $_GET['m'] almacena municipio seleccionado y $_GET['mm'] si es mas de uno
echo "<script>

$('#grancontenido').css('width', '100%');
$('#grancontenido').css('margin', '0px');


</script>";


   if($nivel==1 || $nivel2==1)
   {
echo "<div  style='border: 0px;'>";
echo "<center>";

$sql = "SELECT * FROM lotes where idLote=".$_GET['id'];
$tmp="";
$l = $Vivienda -> query($sql);
while($valor = $l -> fetch_array())
   {

      if(ValidarLoteCompleto($_GET['id'])=='TRUE')
   {
      echo "<div id='msgdatosrequeridos' class='sombra' style='display:none; width: 95%; color:red; background:#F8E0E0; font-size: small;'  ><span><br>** Faltan algunos datos requeridos **<br></span><br></div><br>";
   }else {
      echo "<div id='msgdatosrequeridos' class='sombra' style='display:inline-block; width: 95%; color:red; background:#F8E0E0; font-size: small;' ><span><br>** Faltan algunos datos requeridos **<br></span><br></div><br>";
   }
     
      


/* ****************************LOCALIZACION DEL LOTE ***************************** */
echo "<div class='sombra' style='width: 95%; background-color:white;'>";


echo "<br><h1>Localización del lote</h1><br>";

echo "<table style='width: 90%;'  >";
echo "<tr style='display:none'>";      
echo "<td valign='middle'><b class='normal menu_font_n'>IdLote:</b></td>";
echo "<td valign='middle' align='center'>";
echo "<input type='hiiden' name='idlote' id='idlote' value=".$valor['idLote']." disabled>" ; 
echo "</td>";
echo "<td valign='middle' align='center' ></td>";
echo "<td valign='middle' align='center' ></td>"; 
echo "</tr>";

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Municipio</b></td>";
echo "<td valign='middle'  colspan='3'>";
echo "<span class='tenue' >".NombreMunicipioVivienda($valor['IdMunicipio'])."</span>";
echo "</td>";
echo "</tr>";

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Colonia</b>";
echo "<td valign='middle' colspan='3'>";
echo "<input type='hidden' name='IdColonia1' id='IdColonia1' value=".$valor['IdColonia'].">" ;
echo "<span class='tenue' >".NombreColoniaVivienda($valor['IdMunicipio'],$valor['IdColonia'])."</span>";
// echo "<div id='colonia' name='colonia' style='width:100%;' disabled>";
// echo "<select id='IdColonia' name='IdColonia'  style='margin-left: 0px;' disabled >";
// echo "</select>";
echo "<div";


echo "</td>";
echo "</tr>";  
    
echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Seccion</b>";
echo "<td valign='middle' >";
echo "<span class='tenue'>".trim($valor['seccion'])."</span>";
//echo "<input type='text' name='Seccion' id='Seccion' value=".trim($valor['seccion'])." >" ; 
echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>Fila</b>";
echo "<td valign='middle'>";
echo "<span class='tenue'>".$valor['fila']."</span>";
//echo "<input type='text' name='fila' id='fila' value=".$valor['fila']." >" ; 
echo "</td>";
echo "</tr>";  

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Manzana</b>";
echo "<td valign='middle'>";
echo "<span class='tenue'>".trim($valor['manzana'])."</span>";
//echo "<input type='text' name='Manzana' id='Manzana' value=".$valor['manzana']." disabled>" ; 
echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>Lote</b>";
echo "<td valign='middle'>";
echo "<span class='tenue'>".$valor['lote']."</span>";
//echo "<input type='text' name='Lote' id='Lote' value=".$valor['lote']." disabled>" ; 
echo "</td>";
echo "</tr>";

echo "</table> "; 
echo "<br>";
echo "</div>"; //cierrra div de localizacion del lote
echo "<br>";
echo "<br>";
/* **************************** MEDIDAS Y COLINDANCIAS ***************************** */
echo "<div class='sombra' style='width: 95%; background-color: antiquewhite;'><br><h1>Medidas y colindancias</h1><br>";
echo "<table style='width: 90%;' >";

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n' >Calle: </b></td>";
echo "<td valign='middle' align='center' colspan='3' >";
// echo "<input type='text' name='Calle' id='Calle' value=".$valor['calle']."'>" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='calle' id='calle' value='".trim($valor['calle'])."'></td>";
echo "<td width=13px><div style='display:none;' id='Loadercalle'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='Rcalle'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";												
echo "</td>";
echo "</tr>";

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n' >Superficie: *</b></td>";
echo "<td valign='middle' align='center' colspan='3' >";
//echo "<input type='text' name='Superficie' id='Superficie' value=".$valor['superficie'].">" ; 
echo "<div ><table width=100%><tr><td >";
echo "<tr><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='superficie' id='superficie' value='".trim($valor['superficie'])."'></td>";
echo "<td width=13px><div style='display:none;' id='loadersuperficie'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='Rsuperficie'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
echo "</td>";
echo "</tr>";

echo "<tr>";      
echo "<td valign='middle' >";
echo "</td>";
echo "<td valign='middle' align='center'><b class='normal menu_font_n'><br>Punto Cardinal</b>";
echo "</td>";
echo "<td valign='middle' colspan='2' align='center'><b class='normal menu_font_n'><br>Colindancia</b>";
echo "</td>";
echo "</tr>";  
echo "<tr>";
echo "<td valign='middle'>";
echo "</td>";   
echo "<td valign='middle'>";
echo "</td>";  
echo "<td valign='middle' colspan='2'>";
echo "</td>";   
echo "</tr>";

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Colindancia 1:</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='PuntoCardinal1' id='PuntoCardinal1' value=".$valor['colin1'].">" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='colin1' id='colin1' value='".trim($valor['colin1'])."'></td>";
echo "<td width=13px><div style='display:none;' id='Loadercolin1'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='Rcolin1'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";

echo "</td>";
echo "<td valign='middle' align='center' colspan='3'>";
//echo "<input type='text' name='Colindancia1' id='Colindancia1' value=".$valor['con_quien1']." >" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='con_quien1' id='con_quien1' value='".trim($valor['con_quien1'])."'></td>";
echo "<td width=13px><div style='display:none;' id='Loadercon_quien1'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='Rcon_quien1'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
echo "</td>";
echo "</tr>";  


echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Colindancia 2:</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='PuntoCardinal2' id='PuntoCardinal2' value=".$valor['colin2'].">" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='colin2' id='colin2' value='".trim($valor['colin2'])."'></td>";
echo "<td width=13px><div style='display:none;' id='Loadercolin1'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='Rcolin1'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";

echo "</td>";
echo "<td valign='middle' align='center' colspan='3'>";
//echo "<input type='text' name='Colindancia2' id='Colindancia2' value=".$valor['con_quien2']." >" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='con_quien2' id='con_quien2' value='".trim($valor['con_quien2'])."'></td>";
echo "<td width=13px><div style='display:none;' id='Loadercon_quien2'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='Rcon_quien2'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
echo "</td>";
echo "</tr>";  


echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Colindancia 3:</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='PuntoCardinal3' id='PuntoCardinal3' value=".$valor['colin3'].">" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='colin3' id='colin3' value='".trim($valor['colin3'])."'></td>";
echo "<td width=13px><div style='display:none;' id='Loadercolin1'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='Rcolin1'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";

echo "</td>";
echo "<td valign='middle' align='center' colspan='3'>";
//echo "<input type='text' name='Colindancia3' id='Colindancia3' value=".$valor['con_quien3']." >" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='con_quien3' id='con_quien3' value='".trim($valor['con_quien3'])."'></td>";
echo "<td width=13px><div style='display:none;' id='Loadercon_quien3'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='Rcon_quien3'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
echo "</td>";
echo "</tr>";  


echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Colindancia 4:</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='PuntoCardinal3' id='PuntoCardinal3' value=".$valor['colin3'].">" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='colin4' id='colin4' value='".trim($valor['colin4'])."'></td>";
echo "<td width=13px><div style='display:none;' id='Loadercolin4'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='Rcolin4'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
echo "</td>";
echo "<td valign='middle' align='center' colspan='3'>";
//echo "<input type='text' name='Colindancia3' id='Colindancia3' value=".$valor['con_quien3']." >" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='con_quien4' id='con_quien4' value='".trim($valor['con_quien4'])."'></td>";
echo "<td width=13px><div style='display:none;' id='Loadercon_quien4'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='Rcon_quien4'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
echo "</td>";
echo "</tr>";  


echo "<tr>";    
echo "<td valign='middle'><b class='normal menu_font_n'>Finca:</b>";
echo "<td valign='middle' align='center'>";
//echo "<input type='text' name='Finca' id='Finca' >" ; 
echo "<div  ><table width=100%><tr><td >";
echo "<tr><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='FINCA' id='FINCA' value='".trim($valor['FINCA'])."'></td>";
echo "<td width=13px><div style='display:none;' id='LoaderFINCA'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RFINCA'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>Clave Catastral:</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='ClaveCatastral' id='ClaveCatastral' value=".$valor['CVE_CATASTRAL'].">" ; 
echo "<div  ><table width=100%><tr><td >";
echo "<tr><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='CVE_CATASTRAL' id='CVE_CATASTRAL' value='".trim($valor['CVE_CATASTRAL'])."'></td>";
echo "<td width=13px><div style='display:none;' id='LoaderCVE_CATASTRAL'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RCVE_CATASTRAL'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
echo "</td>";
echo "</tr>";

echo "</table> "; 
echo "<br>";
echo "</div>"; //cierra el div de medidas y colindancias
echo "<br>";
echo "<br>";

/* **************************** OTROS ***************************** */
echo "<div class='sombra' style='width: 95%; background-color: #cde6d8;'><br><h1>Otros</h1><br>";
echo "<table   >";

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Estatus: *</b>";
echo "<td valign='middle' align='center'  colspan='3'>";
echo "<div'><table width=100%><tr><td>";
echo "<select  id='IdEstatus' onchange='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'  name='IdEstatus' >";
    $r2x = $conexion -> query($sql);
    $sql2="select * from catcstatuslote";
   $r2 = $Vivienda -> query($sql2);
   //echo '<option value="100">SELECCIONE UNA OPCION...</option>';
   while($f = $r2 -> fetch_array())
      {
         if ($valor['IdEstatus'] ==$f['IdEstatus'])
         {         
            echo "<option value='".$f['IdEstatus']."' selected>".$f['EstatusLote']."</option>";
            }
            else
            {
               echo "<option value='".$f['IdEstatus']."'>".$f['EstatusLote']."</option>";
               
            }	
      
      } 
echo "</select></td><td width=13px><div style='display:none;' id='LoaderIdEstatus'><img src='img/loader_bar.gif' style='width:13px;'></div>
<div style='display:none;' id='LoaderOKIdEstatus'> <img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
echo "</div>";
echo "</td>";
echo "</tr>"; 

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Identificación del lote: *</b>";
echo "<td valign='middle' align='center'  colspan='3'>";

echo "<div'><table width=100%><tr><td>";
echo "<select  id='IdTipoLote' onchange='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'  name='IdTipoLote' >";
    $r2x = $conexion -> query($sql);
    $sql2="select * from cattipolote";
   $r2 = $Vivienda -> query($sql2);
   while($f = $r2 -> fetch_array())
      {
         if ($valor['IdTipoLote'] ==$f['IdTipoLote'])
         {         
            echo "<option value='".$f['IdTipoLote']."' selected>".$f['TipoLote']."</option>";
            }
            else
            {
               echo "<option value='".$f['IdTipoLote']."'>".$f['TipoLote']."</option>";
               
            }	
      
      } 
echo "</select></td><td width=13px><div style='display:none;' id='LoaderIdTipoLote'><img src='img/loader_bar.gif' style='width:13px;'></div>
<div style='display:none;' id='LoaderOKIdTipoLote'> <img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
echo "</div>";
echo "</td>";
echo "</tr>"; 

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Costo: *</b>";
echo "<td valign='middle' align='center' ></td>";
echo "</tr>";

echo "<tr>";      
echo "<td></td>";
echo "<td valign='middle' colspan='2'  style='font-size: 12px;'>";
   echo "<div class='elemento' id ='divEstablecerPrecio'>";                          
      echo "<label>";                            
         
         if($valor['ExigirSaldoTerreno']== '0'  &&  $valor['precio']>0)
         {
         echo "<input  type='radio' name='EstablecerPrecio' id='EstablecerPrecio' onclick='checkRadio(name)' checked >Establecer PRECIO DEL LOTE";
         }
         else
         {
            echo "<input  type='radio' name='EstablecerPrecio' id='EstablecerPrecio' onclick='checkRadio(name)' >Establecer PRECIO DEL LOTE";
         }                          
         echo "</label>";
         echo "</div>";
   echo "</td>";
echo "</tr>";

echo "<tr>";      
echo "<td></td>";
echo "<td>";
echo "<div class='elemento' id='divSoloEscritura'>";                          
echo "<label>";                            
 //  $dato= $valor['SoloEscritura'];
   if($valor['ExigirSaldoTerreno'] == '1'  &&  $valor['precio']==0)
  
   {
   echo "<input  type='radio' name='SoloEscritura' id='SoloEscritura' onclick='checkRadio(name)' checked >Especificar que  \"SOLO ES ESCRITURACIÓN\"";
   }
   else
   {
      echo "<input  type='radio' name='SoloEscritura' id='SoloEscritura' onclick='checkRadio(name)' >Especificar que  \"SOLO ES ESCRITURACIÓN\"";
   }                          
   echo "</label>";
   echo "</div>";
echo "</td>";
//echo "<td valign='middle' colspan='2'  style='font-size: 12px;'><input  type='radio' name='SoloEscritura' id='SoloEscritura' onclick='checkRadio(name)'  Value='2'>Especificar que  \"SOLO ES ESCRITURACIÓN\"";
echo "</td>";
echo "</tr>";


echo "<tr>";    
echo "<td colspan='4' align='center'>";
echo "<br>";
echo "<div style='background: mintcream; width:95%; display:none' class='sombra' id='OpcionesCosto' name='OpcionesCosto' >";
echo "<center>";
echo "<table>";   
echo "<tr>"; 
echo "<td valign='middle'><br><b class='normal menu_font_n'>Costo del Terreno</b>";
echo "<td valign='middle' align='center' ><br>";
// echo "<input type='text' name='CostoTerreno' id='CostoTerreno' value=".$valor['precio'].">" ;
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='precio' id='precio' value='".trim($valor['precio'])."'></td>";
echo "<td width=13px><div style='display:none;' id='Loaderprecio'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='Rprecio'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "<td valign='middle'><br><b class='normal menu_font_n'>Tasa de Financiamiento Anual</b>";
echo "<td valign='middle' align='center' ><br>";
//echo "<input type='text' name='Financiamiento' id='Financiamiento'  value=".$valor['TasaAnualFin'].">" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='TasaAnualFin' id='TasaAnualFin' value='".trim($valor['TasaAnualFin'])."'></td>";
echo "<td width=13px><div style='display:none;' id='LoaderTasaAnualFin'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RTasaAnualFin'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "<td valign='middle'><br><b class='normal menu_font_n'>%</b>"; 
echo "</td>";
echo "</tr>";


echo "<tr>";    
echo "<td valign='middle'><b class='normal menu_font_n'>Enganche/Pago Inicial</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='Enganche' id='Enganche' value=".$valor['MontoPagoInicial'].">" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='MontoPagoInicial' id='MontoPagoInicial' value='".trim($valor['MontoPagoInicial'])."'></td>";
echo "<td width=13px><div style='display:none;' id='LoaderMontoPagoInicial'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RMontoPagoInicial'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>Tasa de Intereses Moratorio</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='InteresesMoratorios' id='InteresesMoratorios' value=".$valor['TasaIntMora'].">" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='TasaIntMora' id='TasaIntMora' value='".trim($valor['TasaIntMora'])."'></td>";
echo "<td width=13px><div style='display:none;' id='LoaderTasaIntMora'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RTasaIntMora'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>%</b>"; 
echo "</td>";
echo "</tr>";

echo "</tr>";  
echo "<tr>";

echo "<tr>";    
echo "<td valign='middle'><b class='normal menu_font_n'>Subsidio Estatal</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='SubsidioEstatal' id='SubsidioEstatal' value=".$valor['SubsidioEstatal'].">" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='SubsidioEstatal' id='SubsidioEstatal' value='".trim($valor['SubsidioEstatal'])."'></td>";
echo "<td width=13px><div style='display:none;' id='loadersubsidioEstatal'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RSubsidioEstatal'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>Número de Meses</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='Meses' id='Meses' value=".$valor['TotalPagos']." >" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='TotalPagos' id='TotalPagos' value='".trim($valor['TotalPagos'])."'></td>";
echo "<td width=13px><div style='display:none;' id='LoaderTotalPagos'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RTotalPagos'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "</tr>";

echo "<tr>";    
echo "<td valign='middle'><b class='normal menu_font_n'>Subsidio Federal</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='SubsidioFederal' id='SubsidioFederal' value=".$valor['SubsidioFederal'].">" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='SubsidioFederal' id='SubsidioFederal' value='".trim($valor['SubsidioFederal'])."'></td>";
echo "<td width=13px><div style='display:none;' id='loadersubsidioFederal'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RSubsidioFederal'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>Mensualidades: $</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='Mensualidades' id='Mensualidades' value=".$valor['MontoPago'].">" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='MontoPago' id='MontoPago' value='".trim($valor['MontoPago'])."'></td>";
echo "<td width=13px><div style='display:none;' id='LoaderMontoPago'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RMontoPago'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "</tr>";

echo "<tr>";    
echo "<td valign='middle'><b class='normal menu_font_n'>Monto a Financiar</b>";
echo "<td valign='middle' align='center' >";
//$monto=calcularMontoAFinanciar($valor['idLote']);
//echo "<input type='text' name='MontoFinanciar' id='MontoFinanciar' value=".$monto." disabled>" ; 
echo "<div><table width=100%><tr><td >";
echo "<tr><td><b class='normal menu_font_n' style='visibility: hidden;'>*</b></td><td><input  type='text'   mayus(this);'  name='MontoFinanciar' id='MontoFinanciar'  disabled  ></td>";
echo "<td width=13px><div style='display:none;' id='LoaderMontoPago'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RMontoPago'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 

echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>Ultimo Pago:$</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='UltimoPago' id='UltimoPago' value=".$valor['MontoUltimoPago'].">" ; 
// echo "<div><table width=100%><tr><td >";
// echo "<tr><td><b class='normal menu_font_n'>*</b></td><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='MontoUltimoPago' id='MontoUltimoPago' value='".trim($valor['MontoUltimoPago'])."'></td>";
// echo "<td width=13px><div style='display:none;' id='LoaderMontoUltimoPago'><img src='img/loader_bar.gif' style='width:13px;'></div>";
// echo "<div style='display:none;' id='RMontoUltimoPago'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "</tr>";


echo "<tr>";    
echo "<td valign='middle'><b class='normal menu_font_n'>Tipo de cargo</b>";
echo "<td valign='middle' align='center' >";
echo "<div'><table width=100%><tr><td><b class='normal menu_font_n'>*</b></td><td>";
echo "<select  id='IdConceptoCargo' onchange='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'  name='IdConceptoCargo'  style='margin-left:0px;'>";

    $sql2="SELECT* FROM descripcionmovimiento WHERE idTipoMov IN (35 , 37)";
   $r2 = $Vivienda -> query($sql2);
   echo "<option value='0'>SELECCIONE UNA OPCION...</option>";
   while($f = $r2 -> fetch_array())
      {
         if ($valor['IdConceptoCargo'] ==$f['idTipoMov'])
         {         
            echo "<option value='".$f['idTipoMov']."' selected>".strtoupper ($f['DescripcionMovimiento'])."</option>";
            }
            else
            {
               echo "<option value='".$f['idTipoMov']."'>".strtoupper ($f['DescripcionMovimiento'])."</option>";
               
            }	
      
      } 
echo "</select></td><td width=13px><div style='display:none;' id='LoaderOKIdCargo'><img src='img/loader_bar.gif' style='width:13px;'></div>
<div style='display:none;' id='LoaderOKIdCargo'> <img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
echo "</div>";

echo "</td>";
echo "<td valign='middle' colspan='2'>";
echo "<div class='elemento'>";

echo "<b class='normal menu_font_n'>";

    if($valor['ImprimeCarta'] == '1' ){
      echo "<input type='checkbox' name='ImprimeCarta' id='ImprimeCarta'   onchange='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)' checked> Imprime Carta de Asignación<br>";

    }else{
        echo "<input type='checkbox' name='ImprimeCarta' id='ImprimeCarta'  onchange='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'> Imprime Carta de Asignación<br>";

    }

echo "</b>";
echo "</div>";
echo "</td>";

echo "</tr>";
echo "<tr>";
echo "<td valign='middle'><b class='normal menu_font_n'>Nombre de la plantilla para generar el contrato</b></td>";
echo "<td valign='middle' align='center' colspan='3'>";
echo "<div'><table width=100%><tr><td style='visibility: hidden;''><b class='normal menu_font_n'>*</b></td><td>";
$idplantilla=idPlantillaContrato($valor['ContratoMaestro']);
echo "<select  id='ContratoMaestro'   name='ContratoMaestro'  style='margin-left:0px;' onchange='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\",this.value)'>";

    $sql2="SELECT* FROM cat_plantillas where IdTipoTramite=2";
   $r2 = $Vivienda -> query($sql2);
   echo "<option value='0'>SELECCIONE UNA OPCION...</option>";
   while($f = $r2 -> fetch_array())
      {
         if ($idplantilla ==$f['Id'])
         {         
            echo "<option value='".$f['Id']."' selected>".strtoupper ($f['Archivo'])."</option>";
            }
            else
            {
               echo "<option value='".$f['Id']."'>".strtoupper ($f['Archivo'])."</option>";
               
            }	
      
      } 
echo "</select></td><td width=13px><div style='display:none;' id='LoaderOKContratoMaestro'><img src='img/loader_bar.gif' style='width:13px;'></div>
<div style='display:none;' id='LoaderOKContratoMaestro'> <img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
echo "</div>";


 echo "<div id='DescripcionPlantilla'>";
echo "<b class='normal menu_font_n'><label id='DescripcionPlantillla'>".DescripcionPlantillaContrato($idplantilla)."</label></b>";
echo "</div>";
echo "<br>";

echo "</td>";
echo "</tr>";
echo "</table> "; 
echo "</center>";
echo "</div>";
echo "<br>";
echo "<br>";
echo "</td>";
echo "</tr>";

echo "</table> "; 
echo "<br>";
echo "</div>";
echo "</table> "; 

echo "<br>";

// /* ****************************DATOS EXTRAS DEL LOTE ***************************** */
// echo "<div class='sombra' style='width: 95%;'>";


// echo "<br><h1>DATOS EXTRAS DEL LOTE</h1><br>";

// echo "<table style='width: 90%;' >";
// echo "<tr >";      
// echo "<td valign='middle'><b class='normal menu_font_n'>*</b></td>";
// echo "<td valign='middle' align='center'>";
// echo "<tr >";      
// echo "<td valign='middle'><b class='normal menu_font_n'>CONTRATO: </b></td>";
// echo "<td valign='middle'><span>";
// echo $valor['NumContrato'];
// echo "</span</td>";

// echo "</tr>";
// echo "<tr >";      
// echo "<td valign='middle'><b class='normal menu_font_n'>TITULAR: </b></td>";
// echo "<td valign='middle'><span>";
// echo nombreBeneficiarioVivienda(buscarIdSolicitante($valor['IdPrograma'],$valor['IdDelegacion'],$valor['Folio']));
// echo "</span</td>";

// echo "</tr>";
// echo "<tr>";
// echo "<td valign='middle'><b class='normal menu_font_n'>*</b></td>";
// echo "<td valign='middle' align='center'>";
// echo  'valor'.$valor['NumEscritura'];

//        if( $valor['NumEscritura']>0)
//        {
//           if (  VerificaSiLoteEstaEscriturado($valor['idLote'])!='1')
//           {
//             echo "<BR><BR><span>EL LOTE SE ENCUENTRA ESCRITURADO</span>";
//           }else
//           {
//             echo "<BR><BR><span>EL LOTE SE ENCUENTRA EN PROCESO ESCRITURACIÓN</span>";

//           }
//          }else
//          {
//             echo strlen($valor['NumEscritura']);
//          }
// echo "</td>";
 
// echo "</tr>";

// echo "</table> "; 
// echo "<br>";
// echo "</div>"; //cierrra div de datos EXTRAS
echo "<br>";
echo "<br>";
echo "</div>";






echo "</center>";
echo "<br>";

   }
   
echo "</center>";
echo "</div>"; //cierra div de indicadores

   }else
   {
      mensaje("No tiene acceso a esta aplicacion",'');

   }


} else {mensaje("No tiene acceso a esta aplicacion",'');}

?>


<br><br>


<script>

 // ******************************************************************** */
 //Cosas a conciderar al cargar la pagina
$(document).ready(function(){ 

   //validar que los radiobutton esten selecionados
   if((document.getElementById("EstablecerPrecio").checked !== true ) &&( document.getElementById("SoloEscritura").checked!==true))
      {
         console.log(  'entro2');
         $("#divEstablecerPrecio").css({"border-color": "red", "border-style":"solid","border-width": "thin"});
         $("#divSoloEscritura").css({"border-color": "red", "border-style":"solid","border-width": "thin"});       
      }      
      else   
      { 
        
         $("#divEstablecerPrecio").css({"border-color": "#CCCCCC", "border-style":"solid","border-width": "0"});
         $("#divSoloEscritura").css({"border-color": "#CCCCCC", "border-style":"solid","border-width": "0"});   
         

 
         // Revisa cual radio button esta seleccionado
         if(document.getElementById("EstablecerPrecio").checked == true)
         {
            document.getElementById("EstablecerPrecio").checked = true;
            document.getElementById("SoloEscritura").checked = false;
            $("#OpcionesCosto").css({'display':'inline-block'}); 
            $("#SoloEscritura").css("border-color", "#CCCCCC");

         }else  if(document.getElementById("SoloEscritura").checked == true)
         {
            document.getElementById("SoloEscritura").checked = true;
            document.getElementById("EstablecerPrecio").checked = false;
            $("#OpcionesCosto").css({'display':'none'});
            $("#EstablecerPrecio").css("border-color", "#CCCCCC");
         }
              
      }
      
      var idlote=document.getElementById("idlote").value;  
  
      

   //validar inputs
 
   var inputs, index, len,campo; 
   inputs = document.getElementsByTagName('input');
   len = inputs.length;
   for (index = 0; index < len; ++index) {        
   campo=inputs[index].name;   
   $.ajax({
   ajaxcampo: campo,
   url: "lot_bd2.php",
   type: "post",        
   data: {Idlote:idlote, Campo:campo,Funcion:'Validar'},
    success: function(data){ 
         campo1 = this.ajaxcampo;                             
        $("#" + campo1).html(data+"\n");    
         if(data.includes('FALSE')==true)                            
            {    
                console.log(data);                 
               $("#" + campo1).css("border-color", "red");              
               $("#msgdatosrequeridos").css({'display':'inline-block'});  
            }
            else
            { 
               $("#" + campo1).css("border-color", "#CCCCCC");
               $("#msgdatosrequeridos").css({'display':'none'});
            }
         
    }
    });
   
   }

   //validar select
   var selects, index2, len2,campo2; 
   selects = document.getElementsByTagName('select');    
   len2 = selects.length;

   for (index2 = 0; index2 < len2; ++index2) {  
   campo2=selects[index2].name;    
   $.ajax({
   ajaxcampo2: campo2,
   url: "lot_bd2.php",
   type: "post",        
   data: {Idlote:idlote, Campo:campo2,Funcion:'Validar'},
    success: function(data){ 
         campo2 = this.ajaxcampo2;                             
        //$("#" + campo2).html(data+"\n");     
        console.log(campo2);
         if(data.includes('FALSE')==true)                            
            {                          
               $("#" + campo2).css("border-color", "red");              
               $("#msgdatosrequeridos").css({'display':'inline-block'});  
            }
            else
            { 
               $("#" + campo2).css("border-color", "#CCCCCC");
               $("#msgdatosrequeridos").css({'display':'none'});
            }         
    }
    });
   }





   calcularMonto();
  
}); 

 // ******************************************************************** */
function LimpiarDatos()
 {
   document.getElementById("MontoPagoInicial").value =0;
   document.getElementById("SubsidioFederal").value =0;
   document.getElementById("SubsidioEstatal").value =0;
   document.getElementById("MontoPago").value =0;
   document.getElementById("precio").value =0;
   document.getElementById("MontoUltimoPago").value =0;
   document.getElementById("TasaAnualFin").value =0;
   document.getElementById("TasaIntMora").value =0;
   document.getElementById("TotalPagos").value =0;
   document.getElementById("MontoFinanciar").value =0; 
   document.getElementById("ContratoMaestro").value =0;
   document.getElementById("ImprimeCarta").checked =false;
   
   $("#DescripcionPlantilla").html('')
}
 // ******************************************************************** */
function calcularMonto()
{
  
   var precio=document.getElementById("precio").value;  
   var enganche=document.getElementById("MontoPagoInicial").value; 
   var SubsidioEstatal=document.getElementById("SubsidioEstatal").value; 
   var SubsidioFederal=document.getElementById("SubsidioFederal").value; 
   var monto=precio-enganche-SubsidioEstatal-SubsidioFederal;
   document.getElementById("MontoFinanciar").value =monto;
  
}

 // ******************************************************************** */
function checkRadio(name) {
    
    if(name == "EstablecerPrecio"){
      
        document.getElementById("EstablecerPrecio").checked = true;
        document.getElementById("SoloEscritura").checked = false;
        $("#OpcionesCosto").css({'display':'inline-block'});  
        
        $("#divEstablecerPrecio").css({"border-color": "red", "border-style":"solid","border-width": "inherit"});
         $("#divSoloEscritura").css({"border-color": "red", "border-style":"solid","border-width": "inherit"});       
      
         
        var idlote=document.getElementById("idlote").value;    
        var nitavu=<?php echo $nitavu; ?>;
        GuardarDato(idlote, 'ExigirSaldoTerreno', nitavu, 0)
          GuardarDato(idlote, 'localiza', nitavu, 1);
        //GuardarDato2(idlote, 'ExigirCostoEscritura', nitavu, 1)

    } else if (name == "SoloEscritura"){
        
        document.getElementById("SoloEscritura").checked = true;
        document.getElementById("EstablecerPrecio").checked = false;
        
         $("#divEstablecerPrecio").css({"border-color": "red", "border-style":"solid","border-width": "inherit"});
         $("#divSoloEscritura").css({"border-color": "red", "border-style":"solid","border-width": "inherit"});     
         $("#OpcionesCosto").css({'display':'none'});

        var idlote=document.getElementById("idlote").value;    
        var nitavu=<?php echo $nitavu; ?>;
        LimpiarDatos(); 
      
        GuardarDato(idlote, 'SubsidioFederal', nitavu, 0);
        GuardarDato(idlote, 'SubsidioEstatal', nitavu, 0);
        GuardarDato(idlote, 'MontoPago', nitavu, 0);
        GuardarDato(idlote, 'precio', nitavu, 0);
        GuardarDato(idlote, 'MontoPagoInicial', nitavu, 0);
        GuardarDato(idlote, 'MontoUltimoPago', nitavu, 0);
        GuardarDato(idlote, 'TasaAnualFin', nitavu, 0);
        GuardarDato(idlote, 'TasaIntMora', nitavu, 0);
        GuardarDato(idlote, 'TotalPagos', nitavu, 0) ;    
        GuardarDato(idlote, 'plazos', nitavu, 1);
        GuardarDato(idlote, 'localiza', nitavu, 1);
        GuardarDato(idlote, 'TipoPago', nitavu, 3);
        GuardarDato(idlote, 'ExigirSaldoTerreno', nitavu, 1);
        GuardarDato(idlote, 'ExigirCostoEscritura', nitavu, 0);
        GuardarDato(idlote, 'IdConceptoCargo', nitavu, 35);
        GuardarDato(idlote, 'ImprimeCarta', nitavu, 0);
        GuardarDato(idlote, 'ContratoMaestro', nitavu, 0)
       
      
     
        
    }

          //validar lote completo 
   var idlote = $("#idlote").val();
   var campo='DescripcionPlantilla';     
   $.ajax({
   ajaxcampo: campo,
   url: "lot_bd2.php",
   type: "post",        
   data: {Idlote:idlote, Campo:campo,Funcion:'Lote'},
    success: function(data){ 
      console.log(data); 
      if(data.includes('FALSE')==true)                            
            {                         
                 console.log('incompleto');          
               $("#msgdatosrequeridos").css({'display':'inline-block'});  
            }
            else
            { console.log('completo');
               $("#msgdatosrequeridos").css({'display':'none'});
            }    

    }
    });
}

 

 // ******************************************************************** */
function LlenarColonias()
{
   var idcol = document.getElementById("IdColonia1").value;
var id = document.getElementById("IdMunicipio").value;
        $.ajax({
            url: "lot_cboxcolonias.php",
            type: "get",
            data: {id: id},idcol:idcol,
            success: function(data){              
                $('#colonia').html(data+"\n");
            }
        });

       
}
 // ******************************************************************** */

function GuardarDato(idlote, campo, nitavu,valor){       
   //var valor = $("#" + campo).val();  
   if( (campo=="MontoPagoInicial"|| campo=="precio")) {  
          calcularMonto();
   } 
   
   if(campo=="ContratoMaestro")
   {
      
      var select = document.getElementById("ContratoMaestro"); //El <select>
     // valor = select.options[select.selectedIndex].innerText; 
      if (valor=='0') {
         valor='NULL';
         
      }else{
         valor = select.options[select.selectedIndex].innerText; 
      }
      
   } 
  if(campo=='ImprimeCarta')
  {if(   document.getElementById("ImprimeCarta").checked == true)
   {valor=1;}
   else
   {valor=0;}
  } 
    
       
   $("#Loader" + campo ).show();
    $.ajax({
    url: "lot_bd.php",
    type: "post",        
    data: {Idlote:idlote, Campo:campo, Valor:valor, NitavuMod:nitavu},
    success: function(data){                              
        $("#" + campo).html(data+"\n");  
          if(data.includes('FALSE')==true)                            
            {             
               $("#" + campo).css("border-color", "red");              
               $("#msgdatosrequeridos").css({'display':'inline-block'});  
            }
            else
            { 
               $("#" + campo).css("border-color", "#CCCCCC");
               $("#msgdatosrequeridos").css({'display':'none'});
            }
        // console.log("Guardando " + IdRequisito + "_" + IdCategoria + ":" + data);
        $("#Loader" + campo).hide();  
    }
    });

}

//******************************************************************** */
//Detecta su hubo un cambio en el cobo de plantilla y lo muesta la descripcion de la plantilla

var select = document.getElementById('ContratoMaestro');
select.addEventListener('change',
function(){
 var selectedOption = this.options[select.selectedIndex];

// Muestra la descripcion de la plantilla selecionada
var idlote =selectedOption.value;
var campo='DescripcionPlantilla';     
   $.ajax({
   ajaxcampo: campo,
   url: "lot_bd2.php",
   type: "post",        
   data: {Idlote:idlote, Campo:campo,Funcion:'Plantilla'},
    success: function(data){ 
         campo1 = this.ajaxcampo;                             
        $("#" + campo1).html(data+"\n");    
        $("#" + campo1).css({'font-size':'10pt','font-family':'Light','margin-top':'10px','color': '#666666','font-weight': 'bold'});  
            

    }
    })  
  });














//******************************************************************** */
//Guarda la información del campo
// function GuardarDato2(idlote, campo, nitavu, valor){       
//    $("#Loader" + campo ).show();
//     $.ajax({
//     url: "lot_bd.php",
//     type: "post",        
//     data: {Idlote:idlote, Campo:campo, Valor:valor, NitavuMod:nitavu},
//     success: function(data){                                
//         $("#" + campo).html(data+"\n");    
//          console.log(data);
//         // console.log("Guardando " + IdRequisito + "_" + IdCategoria + ":" + data);
//         $("#Loader" + campo).hide();  
//     }
//     });

// }

//******************************************************************** */
//Detecta su hubo un cambio en el cobo de plantilla y lo muesta en el txt 

// var select = document.getElementById('ContratoMaestro1');
// select.addEventListener('change',
//   function(){
//     var selectedOption = this.options[select.selectedIndex];
  
// document.getElementById("ContratoMaestro").value =selectedOption.text;
// var idlote=document.getElementById("idlote").value;   
// var valor=document.getElementById("ContratoMaestro").value;   
// var nitavu=<?php echo $nitavu; ?>;
// console.log('valo111r'+valor);
// GuardarDato(idlote, 'ContratoMaestro', nitavu, valor)

 
   //******************************************************************** */
//valida que el campo de plantilla este seleccionado
// var idlote = $("#idlote").val();
// var campo='ContratoMaestro';     
//    console.log(campo);  
//    $.ajax({
//    ajaxcampo: campo,
//    url: "lot_bd2.php",
//    type: "post",        
//    data: {Idlote:idlote, Campo:campo},
//     success: function(data){ 
//          campo1 = this.ajaxcampo;                             
//         $("#" + campo1).html(data+"\n");    
//          if(data.includes('FALSE')==true)                            
//             {    
                                 
//                $("#" + campo1).css("border-color", "red");              
//                $("#msgdatosrequeridos").css({'display':'inline-block'});  
//             }
//             else
//             { 
//                $("#" + campo1).css("border-color", "#CCCCCC");
//                $("#msgdatosrequeridos").css({'display':'none'});
//             }
         
//     }
//     });
//   });


  


 
</script>










<?php include ("./lib/body_footer.php"); ?>










<br>
<?php
include ("./lib/body_footer.php");
?>