<?php
require_once ("unica/config.php");
require_once ("unica/flor_funciones.php");


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
        echo "<th align='center'>Amortización anticipo</th>";
        echo "<th align='center'>Monto pagado</th>";
        echo "<th align='center'>Monto Acumulado</th>";
        echo "<th align='center'>Saldo</th>";
        //echo "<th style='width:15%;'>N. de oficio</th>";
        echo "<th align='center'>Documentos</th>";
        echo "<th align='center'>Orden Pago</th>";
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
            echo "<td>$".$r['amortizacion_anticipo']."</td>";
            echo "<td>$".$r['monto_pagado']."</td>";
            echo "<td>$".$r['monto_acumulado']."</td>";
            echo "<td>$".$r['saldo']."</td>";
            echo "<td>";
                echo "<a href='#subirAdjuntos1".$vuelta."' rel='modal:open'  title='Haga click aqui para subir archivos'>Adjuntos</a>";
                    echo "<div id='subirAdjuntos1".$vuelta."' class='modal'>";
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
                            echo "<button type='submit' class='btn btn-default' title='Haga clic para subir el archivo'> Subir archivos </button>";
                        echo "</form>"; 

                        

                        echo "</div>";
                echo "</div>";
            echo "</td>";
            echo "<td>";
                MiToken_Init($nitavu, 'PAGO A MANDANTES-ORDEN DE PAGO'); // inicializamos seguridad del Token (no necesitamos saberlo)
                echo '<a href="md_ordenpago.php?id='.$r['id'].'&idmandante='.$idmandante.'&idcolonia='.$idcolonia.'&idmunicipio='.$idmunicipio.'&fecha='.$r['periodopago'].'" ><img src="./icon/pdf.png" height="42" width="42"></a>';
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

