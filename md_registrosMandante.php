<?php
require_once ("config.php");
require_once ("lib/flor_funciones.php");
//include ("./lib/body_head.php"); include ("./lib/body_menu.php");

if(isset($_GET['id']) and isset($_GET['idcolonia']) and isset($_GET['idmunicipio'])  ){
 
    $idmandante = $_GET['id'];
    $idcolonia = $_GET['idcolonia'];
    $idmunicipio = $_GET['idmunicipio'];
    $nitavu = $_GET['nitavu'];
    
    //Tabla de registros
    echo "<div id='tablaRegistros' style='display:inline-block;'>";
       $vuelta = 0;
    $sql = "SELECT * FROM mandantes_abonos WHERE idmandante = ".$idmandante." and idcolonia = ".$idcolonia." and idmunicipio = ".$idmunicipio." and cancelado = 0 ORDER BY id DESC";
    $rc = $conexion -> query($sql);
    if ($rc->num_rows>0){
        echo "<br><br><br>";
        echo "<h1>Desglose de pagos a mandante:</h1>";
        echo "<center>";
        echo "<table id='registros' class='tabla' style='text-align: right; width:90%;'>";
        echo "<th align='center'>ID</th>";
        echo "<th align='center'>Periodo Pago</th>";
        echo "<th align='center'>Recuperación</th>";
        echo "<th align='center'>Gastos</th>";
        echo "<th align='center'>Monto pagar</th>";
        echo "<th align='center'>Devols.</th>";
        echo "<th align='center'>Otros Desc.</th>";
        echo "<th align='center'>Amortización anticipo</th>";
        echo "<th align='center'>Monto pagado</th>";
        echo "<th align='center'>Monto Acumulado</th>";
        echo "<th align='center'>Saldo</th>";
        //echo "<th style='width:15%;'>N. de oficio</th>";
        echo "<th align='center'>Documentos</th>";
        echo "<th align='center'>Orden Pago</th>";
        echo "<th align='center'>mas</th>";
        echo "<th align='center'>Editar</th>";
        echo "<th align='center'>Eliminar</th>";
        
 
        while($r = $rc -> fetch_array()){
            $vuelta +=1;
            echo "<tr>";
            echo "<td align='center'>".$r['id']."</td>";
            echo "<td align='left'>";
            if($r['periodopago']==$r['periodopago2']){
                
                
                
                echo fechaesp($r['periodopago']);

            }else{
                //$fech = strtotime($r['periodopago']);
                //$fech2 = strtotime($r['periodopago2']);
                //echo date("M",$fech).'-'.date("y",$fech)." A ".date("M",$fech2).'-'.date("y",$fech2); 
                echo fechaesp($r['periodopago'])." A ".fechaesp($r['periodopago2']);
            } 
            echo "</td>";
            echo "<td>$".$r['recuperacion']."</td>";
            echo "<td>$".$r['gastos']."</td>";
            echo "<td>$".$r['montopagar']."</td>";
            echo "<td>$".$r['devols']."</td>";
            echo "<td>$".$r['otrosdesc']."</td>";
            echo "<td>$".$r['amortizacion_anticipo']."</td>";
            echo "<td>$".$r['monto_pagado']."</td>";
            echo "<td>$".$r['monto_acumulado']."</td>";
            echo "<td>$".$r['saldo']."</td>";
            echo "<td>";
                echo "<a href='#subirAdjuntos1".$vuelta."' rel='MyModal:open'  title='Haga click aqui para subir archivos'>Adjuntos</a>";
                    echo "<div id='subirAdjuntos1".$vuelta."' class='MyModal'>";
                    echo "<div id='subirAdjuntos' >";
                        echo "<div>";
                            $adj = "SELECT idpago, ndocumento, nombre FROM documentos, mandantes_documentos WHERE mandantes_documentos.n_archivo=documentos.ndocumento and mandantes_documentos.idpago = ".$r['id']."";
                            //echo $adj;
                            $rc1 = $conexion -> query($adj);
                            if ($rc1->num_rows>0){
                                echo "<table class='tabla'>";
                                    echo "<th>Nombre de archivo</th>";
                                    while($r1 = $rc1 -> fetch_array()){
                                        echo "<tr>";
                                            echo "<td>";
                                            $archivo = "docs_mandantes/".$r1['idpago'].'_'.$r1['ndocumento'].'_'.$r1['nombre']; 
                                            $link = "<a id=".$r1['idpago']." name='$archivo' href='md_descargar.php?nombre=".$archivo."' target='_self' onclick =''  title='Haga click aqui para descargar'>".$r1['nombre']."</a>";
                                            echo $link;//archivo
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                echo "</table>";
                            }
                        echo "</div>";

                        echo "<form action='mandantes_pago.php?idmandante=".$idmandante."&idcolonia=".$idcolonia."&idmunicipio=".$idmunicipio."' method='POST' enctype='multipart/form-data'>";
                            echo "<label>Seleccione los archivos que se van a agregar como anexos</label>";
                            echo '<input type="hidden" name="comprobante" id="comprobante" value='.$r['id'].'>';
                            echo "<input type='hidden' name='idmandante2' id='idmandante2' value=".$idmandante.">";
                            echo "<input type='hidden' name='idcolonia2' id='idcolonia2' value=".$idcolonia.">";
                            echo "<input type='hidden' name='idmunicipio2' id='idmunicipio2' value=".$idmunicipio.">";
                            echo '<input id="archivo[]" name="archivo[]" type="file" accept=".pdf" multiple="" required>';
                            echo "<button type='submit' class='Mbtn btn-danger' title='Haga clic para subir el archivo'> Subir archivos </button>";
                        echo "</form>"; 

                        

                        echo "</div>";
                echo "</div>";
            echo "</td>";
            echo "<td>";
                MiToken_Init($nitavu, 'PAGO A MANDANTES-ORDEN DE PAGO'); // inicializamos seguridad del Token (no necesitamos saberlo)
                echo '<form action="md_ordenpago.php?id='.$r['id'].'&idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'&fecha='.$r['periodopago'].'" method="POST">';
                    echo "<input type='hidden' class='url1' name='url1'>";
                    echo "<button  type='submit' title='Clic para ver la orden de pago'>";
                        echo '<img src="./icon/pdf.png" height="42" width="42">';
                    echo "</button>";	
                echo "</form>";
                //echo '<a href="md_ordenpago.php?id='.$r['id'].'&idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'&fecha='.$r['periodopago'].'" ><img src="./icon/pdf.png" height="42" width="42"></a>';
            echo "</td>";

            echo "<td align='center'>";
            echo '<a href="#masAbonos'.$r['id'].'" rel="MyModal:open"  title="Haga click aqui para subir archivos" ><img src="./icon/mas3.png" height="20" width="15">';
            echo "<div id='masAbonos".$r['id']."' class='MyModal' style='width:500px'>";    
            echo "<div>";
            echo '<form action="md_ingresa_abonoextra.php" method="POST">';
            echo "<table style='border-collapse: separate;'>";
            echo "<tr>";
            
                echo "<td>
                <input name='nitavu1'  type='hidden' class='form-select'   id='nitavu1' value='".$nitavu."'  />
              <input name='idabono'  type='hidden' class='form-select'   id='idabono' value='".$r['id']."'  />
                <label style='font-size: 12; font-weight:bold;'>Signo</label><td>";
                echo "<td><select id='mas_menos' name='mas_menos' class='form-select'  style='font-size: 12; '>";
                    echo "<option value='1'>Más(+)</option>";
                    echo "<option value='2'>Menos(-)</option>";
                echo "</select></td>"; 
                echo "</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td><label style='font-size: 12; font-weight:bold;'>Concepto</label><td>";
                echo "<td> <select name='idconcepto'  class='form-select'    id='idconcepto'  style='font-size: 12;'  >"; 
                $sql = "SELECT * FROM cat_conceptos_mandabonos where Activo=1 ";
           
                $rr = $conexion -> query($sql);
                while($f = $rr -> fetch_array())
                { // resultado de la busqueda.................
                    echo "<option  style='font-size: 12;' value='".$f['Id']."'>".$f['Concepto']. "</option>";
                }
                 echo "</select>";

                echo "</td>";
            echo "</tr>";                    
            echo "<tr>";
                echo "<td><label style='font-size: 12; font-weight:bold;'>Importe</label><td>";
                echo "<td> <input name='importe'     id='importe'   style='font-size: 12;' /></td>";
            echo "</tr>";

            echo "<tr>";
            
            echo "<td colspan='2'>";
            echo "<td colspan='2'><center><input class='Mbtn btn-danger' type='submit' id='guardar' value='Guardar' ></center></td>";
            echo "</td>";
        echo "</tr>";
            echo "</table >";
            echo "</form>";
            echo "</div>";
        echo "</div>";
                echo "</a>";

            echo "</td>";

            
            echo "<td align='center'>";
                echo '<a  href="md_modificarRegistro.php?id='.$r['id'].'&idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'"><img src="./icon/edit.png" height="20" width="15"></a>';
            echo "</td>";


           
            echo "<td align='center'>";
                echo '<a  href="mandantes_pago.php?ideliminar='.$r['id'].'&idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'"><img src="./icon/x.png" height="20" width="15"></a>';
            echo "</td>";




        }
        echo "</tr>";
        echo "</table>";
        echo "</center>";
        }
    echo "</div>";

 
    
    
   
                


}


?>
<script>
$(document).ready(function() {
    
    var URLactual = window.location;    

    //document.getElementById('url1').value = URLactual;
    $('.url1').val(URLactual);

});
        
</script>
