<?php
include ("lib/body_head.php");
?>
<?php
    
$id_aplicacion ="ap119"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
    xd_update($id_aplicacion,$nitavu); historia($nitavu, $id_aplicacion." | Entro a contratación de un credito");
    echo "<br><br>";


    //LO PRIMERO SERIA ESCOGER DELEGACION, PROGRAMA SOCIAL, NUMERO DE FOLIO
    echo "<center>";
        echo "<div style='width:80%; padding-top: 30px;  padding-bottom: 30px;'>";
        echo "<form id='formularioContrato' action='vales.php' method='GET' style='border: 1px #C0C5BE solid; padding-top: 20px;
        padding-right: 10px;
        padding-bottom: 20px;
        padding-left: 10px;'>";
        echo "<center><table style='width:100%;'><tr><td style='width:20%;'>";
        
        echo "<center><label for='delegaciones'>Seleccione una delegación:";
        echo "<select name='delegaciones' id='delegaciones' required>";
            $sql = "SELECT * FROM delegaciones where Tipo = 0 ORDER by Delegacion ASC";
            echo "<option value=''>Seleccione una opción</option>";
            $r = $Vivienda -> query($sql);
            while($f = $r -> fetch_array())
            { // resultado de la busqueda.................
                echo "<option value='".$f['IdDelegacion']."'>".$f['Delegacion']. "</option>";
            }
        echo "</select></center>";
        echo "</td>";
        echo "<td style='width:50%;'>";
        echo "<center><label for='programa'>Seleccione un programa:";
        echo "<select name='programa' id='programa'  required>";
        echo "<option value=''>Seleccione una opción</option>";
        //id='programas'
        $sql = "SELECT * FROM programa WHERE Activo=1 ORDER by Programa ASC";
            $r = $Vivienda -> query($sql);
            while($f = $r -> fetch_array())
            { // resultado de la busqueda.................
                echo "<option value='".$f['IdPrograma']."'>".$f['Programa']. "</option>";
            }

        echo "</select></center>";  
        echo "</td>";
        
        echo "<td style='width:20%;'>";
        echo "<center><label for='_folio'>Folio";
        echo "<input id='_folio' name='_folio' value=''   placeholder='Folio del solicitante' required>";
        echo "</center></td></tr>";
        echo "<tr><td colspan=3 style='width:30%;'><center>";    
        echo "<button type='submit'  class='btn btn-info' title='Buscar' > <center>
        <table><tr><td valign='middle' align='center'>
        <img src='icon/buscar2.png'> 
        </td>
        <td valign='middle' align='center' style='color:white;' >
        Buscar
        </td></tr></table>  </center> 
        </button>";  

        echo "</center></td></tr></table></center>";
        echo "</form>";   
        echo "</div>";
    echo "</center>";

    //eliminar un registro de vale
    if(isset($_POST['IdEliminar'])){
        $NumMinistracion = $_POST['IdEliminar'];
        $NumContrato = $_POST['NumContrato'];
        $IdDelegacion = $_POST['del'];
        $IdPrograma = $_POST['prog'];
        $Folio = $_POST['Folio'];
        
        $sql = "UPDATE ministracioncredito SET Cancelado = 1 WHERE NumContrato = ".$NumContrato." and NumMinistracion=".$NumMinistracion."";
        //echo $sql;
        if($Vivienda->query($sql)==TRUE){  
            mensaje('Se elimino con éxito el vale.', "vales.php?delegaciones=".$IdDelegacion."&programa=".$IdPrograma."&_folio=".$Folio."");
        }else{
            mensaje('ERROR: Hubo un problema al eliminar el vale, favor de intentarlo nuevamente.', "vales.php?delegaciones=".$IdDelegacion."&programa=".$IdPrograma."&_folio=".$Folio."");

        }
    }


    if(isset($_GET['delegaciones']) and isset($_GET['programa']) and isset($_GET['_folio'])){
        $IdDelegacion = $_GET['delegaciones'];
        $IdPrograma = $_GET['programa'];
        $Folio = $_GET['_folio'];
        $fechaActual= date('Y-m-d');   
       

        //TRAER LOS DATOS DEL CONTRATO DE ESTE FOLIO 
        $sql = "SELECT * from contratos WHERE IdDelegacion = ".$IdDelegacion." and IdPrograma = ".$IdPrograma." and Folio=".$Folio."";
        $r = $Vivienda -> query($sql); 
        while($f = $r -> fetch_array()){
            $NumContrato = $f['NumContrato'];
             //DIBUJAMOS LOS DATOS DEL BENEFICIARIO EN PANTALLA
            $IdSolicitante = buscarIdSolicitante($IdPrograma, $IdDelegacion, $Folio);
            echo "<br>";
            echo "<center>";
                datosBeneficiarioenFormatoCorto($IdPrograma, $IdDelegacion, $Folio, $NumContrato);
            echo "</center>";
            echo '<br>';   
            echo '<center>';

            //MOSTRAR LOS VALES CAPTURADOS POR ESTE FOLIO
            $sql1 = "SELECT * FROM ministracioncredito WHERE NumContrato = ".$NumContrato." and Cancelado = 0";
            $r1 = $Vivienda -> query($sql1); 
            echo "<center><h1>Historial de vales</h1><table class='tabla' style='width:80%;'>";
            echo "<tr>";
                echo "<th>NumContrato</th>";
                echo "<th>Ministracion</th>";
                echo "<th>Casa Comercial</th>";
                echo "<th>Monto</th>";
                echo "<th>Fecha</th>";
                echo "<th>Eliminar</th>";
            echo "</tr>";
            while($f1 = $r1 -> fetch_array())
            {
               
                echo "<tr>";
                    echo "<td>".$f1['NumContrato']."</td>";
                    echo "<td>".$f1['NumMinistracion']."</td>";
                    echo "<td>".$f1['CasaComercial']."</td>";
                    echo "<td>".$f1['Monto']."</td>";
                    echo "<td>".$f1['FechaEmision']."</td>";
                    echo '<td>';
                    //?ideliminar=".$f1['NumMinistracion']."&NumContrato=".$f1['NumContrato']."&del=".$IdDelegacion."&prog=".$IdPrograma."&Folio=".$Folio."
                        echo "<form action='vales.php' method='POST'>";
                            echo "<input type='hidden' id='IdEliminar' name='IdEliminar' value=".$f1['NumMinistracion'].">";
                            echo "<input type='hidden' id='NumContrato' name='NumContrato' value=".$f1['NumContrato'].">";
                            echo "<input type='hidden' id='del' name='del' value=".$IdDelegacion.">";
                            echo "<input type='hidden' id='prog' name='prog' value=".$IdPrograma.">";
                            echo "<input type='hidden' id='Folio' name='Folio' value=".$Folio.">";       
                            echo '<button type="submit"  class="Mbtn btn-default"  title="Clic para ver el reporte">';
                           // echo "<table  width='100%'><tr><td valign='middle' align='center'>";
                            echo '<img src="./icon/x.png" height="20" width="20">';
                          //  echo "</td>";
                            //echo "</td></tr></table></button>";
                            echo "</button>";
                        echo "</form>";
                    echo '</td>';
                echo "</tr>";
               
            }
            echo "</table></center>";

            echo "<form action='vales.php' method='GET' >";
            
            echo "<input type='hidden' name='NumContrato' value='".$NumContrato."'>";
            echo "<input type='hidden' name='IdDelegacion' value='".$f['IdDelegacion']."'>";
            echo "<input type='hidden' name='IdPrograma' value='".$f['IdPrograma']."'>";
            echo "<input type='hidden' name='Folio' value='".$f['Folio']."'>";
   
            $MontoCredito = $f['MontoCredito'];
            
            
            echo "<center>";
            echo '<div class="card " style="text-align: justify; width: 90%;">';
            echo '<h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;">REGISTRAR VALE</h1>'; 

            echo "<br>";
            echo "<table style='width:80%; margin-left: 20px; font-size: 10pt;' >";
            echo "<tr>";  
            echo '<td colspan="2" align="center"><div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="NomProveedor" name="NomProveedor">
                <label class="form-check-label" for="NomProveedor">
                Incluir nombre del proveedor en el formato del vale
                </label>
            </div></td>
            <td colspan="2" align="center"><div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="firmaDirector" name="firmaDirector">
                <label class="form-check-label" for="firmaDirector">
                Incluir firma del director en el vale
                </label>
            </div></td>';
            echo "</tr>
            </table>"; 
            
            echo "<table style='width:80%; margin-left: 20px; font-size: 10pt;' >";
            echo "<tr>";                       
            echo "<td><span class='normal'>Casa comercial</span></td>";                           
                echo" <td colspan='3'>";                           
                echo "<select  id='CasaComercial'  name='CasaComercial' >";
                $IdMunicipio = IdCiudadVivienda($IdDelegacion,$IdPrograma,$Folio);
                // $sql2="select * from  casascomerciales where Cancelado=0"; 
                $sql2="SELECT casascomerciales.IdComercial, casascomerciales.CasaComercial 
                from catccmun INNER JOIN casascomerciales ON catccmun.idreemplazo = casascomerciales.IDcomercial  
                WHERE (catccmun.IdMunicipioSurte =".$IdMunicipio." OR casascomerciales.IDCOMERCIAL=0 ) AND (casascomerciales.CANCELADO<>1) 
                ORDER BY casascomerciales.CASACOMERCIAL"; 
                echo $sql2;

                $r2 = $Vivienda -> query($sql2); 
                while($valor = $r2 -> fetch_array())
                {
                    if ($idcasacomercial==$valor['IdComercial'])
                    {
                    echo "<option value='".$valor['IdComercial']."' selected>".$valor['CasaComercial']."</option>";
                    }
                    else
                    {
                        echo "<option value='".$valor['IdComercial']."'>".$valor['CasaComercial']."</option>";
                    }
                }                           
                echo "</select>";
                echo "</td>";
            echo "</tr>";  

                echo "<tr>";
                        echo "<td><span class='normal'>Importe</span></td>";                           
                        echo" <td colspan='3'><input  type='text'    name='ImporteVale'    id='ImporteVale' ></td>";                          
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><span class='normal'>Monto tope del beneficio</span></td>";                           
                    echo" <td colspan='3'><input  type='text'    name='MontoTope'    id='MontoTope' value=".$MontoCredito." readonly></td>";                          
                echo "</tr>"; 

                echo "<tr>";
                        echo "<td><span class='normal'>Fecha Emision</span></td>";                           
                        echo" <td colspan='3'><input  type='date'  name='FechaEmision' id='FechaEmision' value='".$fechaActual."'></td>";                                                    
                echo "</tr>"; 

                echo "<tr>";                       
                    echo "<td><span class='normal'>Bloquera para producir</span></td>";                           
                    echo" <td colspan='3'>";                           
                    echo "<select  id='Bloquera'  name='Bloquera' >";
                    $sql2="Select idbloquera, iddelegacion, CONCAT(nombre,' - ',Ubicacion,' - ' ,TipoCPA) as descripcion from catbloqueras 
                    where iddelegacion=".$IdDelegacion." and (cancelada=0 or Cancelada is null)"; 
                    $r2 = $Vivienda -> query($sql2); 
                    while($valor = $r2 -> fetch_array())
                    {
                        if ($idbloquera==$valor['idbloquera'])
                        {
                        echo "<option value='".$valor['idbloquera']."' selected>".$valor['descripcion']."</option>";
                        }
                        else
                        {
                            echo "<option value='".$valor['idbloquera']."'>".$valor['descripcion']."</option>";
                        }
                    }                           
                    echo "</select>";
                    echo "</td>";
                echo "</tr>";                                           
                echo "</table>";  
                echo "<br>"; 
                echo "<button type='submit'  class='btn btn-primary' title='Buscar' > 
                Guardar
       
                </button>";  
            echo '</div>';
            echo "</center>";
            echo "</form>";

        }
        
    }

    //GUARDAR EL VALE
    if(isset($_GET['NumContrato'])){
        $NumContrato = $_GET['NumContrato'];
        $ImporteVale = $_GET['ImporteVale'];
        $IdDelegacion = $_GET['IdDelegacion'];
        $IdPrograma = $_GET['IdPrograma'];
        $Folio = $_GET['Folio'];
        $FechaEmision = $_GET['FechaEmision'];
        $Bloquera = $_GET['Bloquera'];
        $CasaComercial = $_GET['CasaComercial'];
        $Beneficio = $_GET['MontoTope'];
        if(isset($_GET['NomProveedor'])){
            $NomProvedor = 1;
        }else{
            $NomProvedor = 0;
        }
       
        if(isset($_GET['firmaDirector'])){
            $firmaDirector = 1;
        }else{
            $firmaDirector = 0;
        }
        
        $Monto = guardarVale($NumContrato, $IdDelegacion, $IdPrograma, $Folio, $FechaEmision, $Bloquera, $ImporteVale, $CasaComercial, $Beneficio, $nitavu);


        $TipoImpVale = TipoImpVale($IdPrograma);
        //PARA IMPRIMIR UN VALE EXXISTEN DOS FUNCIONES QUE SE CONDICIONAN POR EL TIPOIMPRIME VALE DEL PROGRAMA
        if($TipoImpVale == 0 or $TipoImpVale == 2 or $TipoImpVale == 4){
            //MsgBox "Falta configurar programa TipoImpVale=1, notifique al administrador...", vbOKOnly + vbInformation, "Aviso..."
            //cuando es necesario que salga 2 vales beneficiario y proveedor o que salgan 3 vales beneficiario, proveedor y delegacion.
            ImpVale2($IdDelegacion,$IdPrograma,$Folio, $Bloquera, $Monto, $NumContrato, $NomProvedor, $firmaDirector);
        // $IdPrograma = 250;//$_GET['IdPrograma'];

        
        }else{
            //solo cuando es tipo 1 sale solo un vale de beneficiario
            
            ImpVale($IdDelegacion,$IdPrograma,$Folio, $Bloquera, $Monto, $NumContrato, $NomProvedor, $firmaDirector);
            
        }
    }
}else{
    mensaje("ERROR: no tienes acceso a este modulo","");
}


?>

<?php include ("lib/body_footer.php"); ?>