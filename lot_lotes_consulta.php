<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>



<?php
$id_aplicacion ="ap89"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$nivel= 1;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
   //xd_update('ap89',$nitavu);//guarda la experiencia del usuario
   //historia($nitavu, "Entro a la aplicacion [ap89], para consultar las colonias");


// en $_GET['m'] almacena municipio seleccionado y $_GET['mm'] si es mas de uno
echo "<script>
$('#grancontenido').css('background-image', 'url(img/colonias.jpg)');
$('#grancontenido').css('width', '100%');
$('#grancontenido').css('margin', '0px');

</script>";

   
echo "<div id='indicadores2' style='border: 0px;'>";
echo "<center>";

$sql = "SELECT * FROM lotes where idLote=".$_GET['id'];
$tmp="";
$l = $Vivienda -> query($sql);
while($valor = $l -> fetch_array())
   {
/* ****************************LOCALIZACION DEL LOTE ***************************** */
echo "<div class='sombra' style='width: 95%;'><br><h1>Localización del lote</h1><br>";
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
echo "<div";


echo "</td>";
echo "</tr>";  
    
echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Seccion</b>";
echo "<td valign='middle' >";
echo "<span class='tenue'>".$valor['seccion']."</span>";
//echo "<input type='text' name='Seccion' id='Seccion' value=".$valor['seccion']." >" ; 
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
echo "<span class='tenue'>".$valor['manzana']."</span>";
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
echo "<div class='sombra' style='width: 95%;'><br><h1>Medidas y colindancias</h1><br>";
echo "<table style='width: 90%;' >";

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n' >Calle:</b></td>";
echo "<td valign='middle'  colspan='3' >";
echo "<span class='tenue' >".$valor['calle']."</span>";											
echo "</td>";
echo "</tr>";

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n' >Superficie:</b></td>";
echo "<td valign='middle' colspan='3' >";
echo "<span class='tenue' >".$valor['superficie']."</span>";	
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
echo "<td valign='middle'  align='center'>";
echo "<span class='tenue' >".$valor['colin1']."</span>";
echo "</td>";
echo "<td valign='middle' colspan='3'>";
echo "<span class='tenue' >".$valor['con_quien1']."</span>";
echo "</td>";
echo "</tr>";  


echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Colindancia 2:</b>";
echo "<td valign='middle' align='center'>";
echo "<span class='tenue' >".$valor['colin2']."</span>";
echo "</td>";
echo "<td valign='middle'  colspan='3'>";
echo "<span class='tenue' >".$valor['con_quien2']."</span>";
echo "</td>";
echo "</tr>";  


echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Colindancia 3:</b>";
echo "<td valign='middle'  align='center'>";
echo "<span class='tenue' >".$valor['colin3']."</span>";
echo "</td>";
echo "<td valign='middle'  colspan='3'>";
echo "<span class='tenue' >".$valor['con_quien3']."</span>";
echo "</td>";
echo "</tr>";  


echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Colindancia 4:</b>";
echo "<td valign='middle' align='center' >";
echo "<span class='tenue' >".$valor['colin4']."</span>";
echo "</td>";
echo "<td valign='middle'  colspan='3'>";
echo "<span class='tenue' >".$valor['con_quien4']."</span>";
echo "</td>";
echo "</tr>";  


echo "<tr>";    
echo "<td valign='middle'><b class='normal menu_font_n'>Finca:</b>";
echo "<td valign='middle' align='center'>";
echo "<span class='tenue' >".$valor['FINCA']."</span>";
echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>Clave Catastral:</b>";
echo "<td valign='middle' align='center' >";
echo "<span class='tenue' >".$valor['CVE_CATASTRAL']."</span>";
echo "</td>";
echo "</tr>";

echo "</table> "; 
echo "<br>";
echo "</div>"; //cierra el div de medidas y colindancias
echo "<br>";
echo "<br>";

/* **************************** OTROS ***************************** */
echo "<div class='sombra' style='width: 95%;'><br><h1>Otros</h1><br>";
echo "<table   >";

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Estatus:</b>";
echo "<td valign='middle'   colspan='3'>";
echo "<span class='tenue' >".EstatusLote($valor['IdEstatus'])."</span>";
echo "</td>";
echo "</tr>"; 

echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Identificación del lote:</b>";
echo "<td valign='middle'   colspan='3'>";
echo "<span class='tenue' >".IdentificacionLote($valor['IdTipoLote'])."</span>";
echo "</td>";
echo "</tr>"; 
echo "<tr>";  
echo "<td>";
echo "<br>";
echo "</td>";
echo "</tr>";
/*
echo "<tr>";      
echo "<td valign='middle'><b class='normal menu_font_n'>Costo:</b>";
echo "<td valign='middle' align='center' ></td>";
echo "</tr>";

echo "<tr>";      
echo "<td></td>";
echo "<td valign='middle' colspan='2'  style='font-size: 12px;'>";
   echo "<div class='elemento'>";                          
      echo "<label>";                            
         
         if($valor['ExigirSaldoTerreno']== '0'  &&  $valor['precio']>0)
         {
         echo "<input  type='radio' name='ExigirSaldoTerreno' id='ExigirSaldoTerreno' onclick='checkRadio(name)' checked >Establecer PRECIO DEL LOTE";
         }
         else
         {
            echo "<input  type='radio' name='ExigirSaldoTerreno' id='ExigirSaldoTerreno' onclick='checkRadio(name)' >Establecer PRECIO DEL LOTE";
         }                          
         echo "</label>";
         echo "</div>";
   echo "</td>";
echo "</tr>";

echo "<tr>";      
echo "<td></td>";
echo "<td>";
echo "<div class='elemento'>";                          
echo "<label>";                            
 //  $dato= $valor['ExigirCostoEscritura'];
   if($valor['ExigirSaldoTerreno'] == '1'  &&  $valor['precio']==0)
  
   {
   echo "<input  type='radio' name='ExigirCostoEscritura' id='ExigirCostoEscritura' onclick='checkRadio(name)' checked >Especificar que  \"SOLO ES ESCRITURACIÓN\"";
   }
   else
   {
      echo "<input  type='radio' name='ExigirCostoEscritura' id='ExigirCostoEscritura' onclick='checkRadio(name)' >Especificar que  \"SOLO ES ESCRITURACIÓN\"";
   }                          
   echo "</label>";
   echo "</div>";
echo "</td>";
//echo "<td valign='middle' colspan='2'  style='font-size: 12px;'><input  type='radio' name='ExigirCostoEscritura' id='ExigirCostoEscritura' onclick='checkRadio(name)'  Value='2'>Especificar que  \"SOLO ES ESCRITURACIÓN\"";
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
echo "<div  ><table width=100%><tr><td >";
echo "<tr><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\")'   mayus(this);'  name='precio' id='precio' value='".$valor['precio']."'></td>";
echo "<td width=13px><div style='display:none;' id='Loaderprecio'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='Rprecio'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "<td valign='middle'><br><b class='normal menu_font_n'>Tasa de Financiamiento Anual</b>";
echo "<td valign='middle' align='center' ><br>";
//echo "<input type='text' name='Financiamiento' id='Financiamiento'  value=".$valor['TasaAnualFin'].">" ; 
echo "<div  ><table width=100%><tr><td >";
echo "<tr><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\")'   mayus(this);'  name='TasaAnualFin' id='TasaAnualFin' value='".$valor['TasaAnualFin']."'></td>";
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
echo "<div  ><table width=100%><tr><td >";
echo "<tr><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\")'   mayus(this);'  name='MontoPagoInicial' id='MontoPagoInicial' value='".$valor['MontoPagoInicial']."'></td>";
echo "<td width=13px><div style='display:none;' id='LoaderMontoPagoInicial'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RMontoPagoInicial'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>Tasa de Intereses Moratorio</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='InteresesMoratorios' id='InteresesMoratorios' value=".$valor['TasaIntMora'].">" ; 
echo "<div  ><table width=100%><tr><td >";
echo "<tr><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\")'   mayus(this);'  name='TasaIntMora' id='TasaIntMora' value='".$valor['TasaIntMora']."'></td>";
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
echo "<div  ><table width=100%><tr><td >";
echo "<tr><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\")'   mayus(this);'  name='SubsidioEstatal' id='SubsidioEstatal' value='".$valor['SubsidioEstatal']."'></td>";
echo "<td width=13px><div style='display:none;' id='loadersubsidioEstatal'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RSubsidioEstatal'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>Número de Meses</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='Meses' id='Meses' value=".$valor['TotalPagos']." >" ; 
echo "<div  ><table width=100%><tr><td >";
echo "<tr><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\")'   mayus(this);'  name='TotalPagos' id='TotalPagos' value='".$valor['TotalPagos']."'></td>";
echo "<td width=13px><div style='display:none;' id='LoaderTotalPagos'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RTotalPagos'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "</tr>";

echo "<tr>";    
echo "<td valign='middle'><b class='normal menu_font_n'>Subsidio Federal</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='SubsidioFederal' id='SubsidioFederal' value=".$valor['SubsidioFederal'].">" ; 
echo "<div  ><table width=100%><tr><td >";
echo "<tr><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\")'   mayus(this);'  name='SubsidioFederal' id='SubsidioFederal' value='".$valor['SubsidioFederal']."'></td>";
echo "<td width=13px><div style='display:none;' id='loadersubsidioFederal'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RSubsidioFederal'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>Mensualidades: $</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='Mensualidades' id='Mensualidades' value=".$valor['MontoPago'].">" ; 
echo "<div  ><table width=100%><tr><td >";
echo "<tr><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\")'   mayus(this);'  name='MontoPago' id='MontoPago' value='".$valor['MontoPago']."'></td>";
echo "<td width=13px><div style='display:none;' id='LoaderMontoPago'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RMontoPago'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "</tr>";

echo "<tr>";    
echo "<td valign='middle'><b class='normal menu_font_n'>Monto a Financiar</b>";
echo "<td valign='middle' align='center' >";
$monto=calcularMontoAFinanciar($valor['idLote']);
//echo "<input type='text' name='MontoFinanciar' id='MontoFinanciar' value=".$monto." disabled>" ; 
echo "<div  ><table width=100%><tr><td >";
echo "<tr><td><input  type='text'   mayus(this);'  name='MontoFinanciar' id='MontoFinanciar' value=".$monto." disabled></td>";
echo "<td width=13px><div style='display:none;' id='LoaderMontoPago'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RMontoPago'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 

echo "</td>";
echo "<td valign='middle'><b class='normal menu_font_n'>Ultimo Pago:$</b>";
echo "<td valign='middle' align='center' >";
//echo "<input type='text' name='UltimoPago' id='UltimoPago' value=".$valor['MontoUltimoPago'].">" ; 
echo "<div  ><table width=100%><tr><td >";
echo "<tr><td><input  type='text' onkeyup='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\")'   mayus(this);'  name='MontoUltimoPago' id='MontoUltimoPago' value='".$valor['MontoUltimoPago']."'></td>";
echo "<td width=13px><div style='display:none;' id='LoaderMontoUltimoPago'><img src='img/loader_bar.gif' style='width:13px;'></div>";
echo "<div style='display:none;' id='RMontoUltimoPago'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>"; 
echo "</td>";
echo "</tr>";


echo "<tr>";    
echo "<td valign='middle'><b class='normal menu_font_n'>Tipo de cargo</b>";
echo "<td valign='middle' align='center' >";
echo "<div'><table width=100%><tr><td>";
echo "<select  id='IdConceptoCargo' onchange='GuardarDato(".$valor['idLote'].", this.id,\"".$nitavu."\")'  name='IdConceptoCargo'  style='margin-left:0px;'>";

    $sql2="SELECT* FROM descripcionmovimiento WHERE idTipoMov IN (35 , 37)";
   $r2 = $Vivienda -> query($sql2);
   echo "<option value='0'>SELECCIONE UNA OPCION...</option>";
   while($f = $r2 -> fetch_array())
      {
         if ($valor['IdConceptoCargo'] ==$f['idTipoMov'])
         {         
            echo "<option value='".$f['idTipoMov']."' selected>".$f['DescripcionMovimiento']."</option>";
            }
            else
            {
               echo "<option value='".$f['idTipoMov']."'>".$f['DescripcionMovimiento']."</option>";
               
            }	
      
      } 
echo "</select></td><td width=13px><div style='display:none;' id='LoaderIdEstatus'><img src='img/loader_bar.gif' style='width:13px;'></div>
<div style='display:none;' id='LoaderOKIdEstatus'> <img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
echo "</div>";

echo "</td>";
echo "<td valign='middle'>";
echo "<td valign='middle' align='center' >";

echo "</td>";
echo "</tr>";
*/
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
echo "</div>";


echo "</center>";
echo "<br>";

   }
   
echo "</center>";
echo "</div>"; //cierra div de indicadores




} else {mensaje("No tiene acceso a esta aplicacion",'');}

?>






<br><br>








<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>










<br>
<?php
include ("./lib/body_footer.php");
?>