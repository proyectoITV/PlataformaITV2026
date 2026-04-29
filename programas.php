<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
?>
<?php
$id_aplicacion ="ap107"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos
//Niveles
// 1 = Crear y Editar
// 2 = Consulta

//Ajusta esta variable para ver el comportamiento
$nivel=1;

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
echo "<div style='margin-top:80px' class='movil'></div>";
    echo "<section id='v001' style='background-color: #f9f3f0; width: 100%; height: 100%; '>";
        echo "<div style='
                background-color: #cacaca;
                width: 100%;
                padding-top: 13px;
                padding-bottom: 13px;
                margin-top: -7px;
        
        '>
                <table  width=100%><tr><td width=90%>
                        <input style='background-color: #d1f9bb; height: 65px;border-radius: 5px;font-size: 23pt;font-family: Light; margin-left: 12px; padding: 10px; margin-right: 20px;'
                        type='text' placeholder='Nombre del Programa' id='txtPrograma'></td>
                        
                        <td>
        
                        <button class='btn btn-success' id='indicaciones2' 
                        style='font-size: 8pt;width: 100%;height: 60px;margin-top: 0px;' 
                        onclick='ProgramasData();'>
                                <img src='icon/buscar2.png' style='width:40px;'>
                        </button></td>


                        <td>
                        ";
                        if ($nivel == 1){ //Si es Administrador
                        echo "<a href='programas_alta.php' class='btn btn-primary' title='Crear Programa nuevo'
                                style='font-size: 8pt;  margin-top: 0px; margin-left: 5px; margin-right: 6px;
                                height: 59px;
                                ' 
                        >
                                <img src='icon/mas2.png' style='width:37px;'></a>";        
                        
                        
                        
                        }
        echo "</td>
                        
                        
                        </tr>
                </table>
        </div>";
        echo "<div id='Resultado'    style='width: 100%; padding-top: 13px;padding-bottom: 13px;  '>";        
        echo "</div>";  
    echo "</section>";
    echo "</div>";


    //DIV para Programas Nuevos
    //class='MyModal'
/*  echo "<div id='ProgramaNuevo' class='MyModal' >";    
    echo "<h1>Crear un Programa Nuevo</h1>";
    echo "<form action='programas.php' method='POST'>";
    echo "<input type='hidden' name='NuevoProg'";      
        //echo "<span><label>Verifique los datos</label><input type='submit' value='Guardar' name='GuardarPrograma' class='Mbtn btn-Primary'></span>";
        echo "<span><button onclick='GuardaPrograma();' class='btn btn-primary btn-lg'>Guardar</button></span>";        
    echo "</form>";
    echo "</div>";
        */ 
    /* if (isset($_POST['GuardarPrograma'])){
            //El usuario le dio guardar al formulario
            echo "Presiono guardar programa";    
    } */

        //echo "<div ><input type='text'  id='arr' name='arr' ></div>";
       
        

    if (isset($_GET['IdPrograma'])){
            //El usuario selecciono un programa
            
            echo "<script>$('#v001').hide();</script>";
            $IdPrograma = $_GET['IdPrograma']; if (ValidaVAR($IdPrograma)==TRUE){$IdPrograma = LimpiarVAR($IdPrograma);} else {$IdPrograma = "";}
            $sql="Select * from programa where IdPrograma=".$IdPrograma;
            $r= $Vivienda -> query($sql);
            $f = $r -> fetch_array();

            echo "<div ><input type='hidden'  id='arr' name='arr' value='".$f['ListaIdPaqueteMat']."'></div>";
            echo "<div ><input type='hidden'  id='listapaqorig' name='listapaqorig' value='".$f['ListaIdPaqueteMat']."'></div>";
            echo "<div ><input type='hidden'  id='areaaplicacionorig' name='areaaplicacionorig' value='".$f['AreaAplicacion']."'></div>";

            if ($nivel == 1){
               //echo "nivel modificar";
                echo ".";
                echo "<div >";
                echo " <h2 style='color: cornflowerblue;'>".$f['ProgramaGral']."</h2>";
                echo " <h2 style='color: cornflowerblue;'>".$f['Programa']."</h2>";
                echo "</div>";                    
                echo "<div>";
                echo "<table class='tabla' >";
                //echo "<caption>".$f['IdPrograma']."</caption>";
                echo "<tr>";
                echo "<th scope='row;' width=50%;  style='font-size: 12pt;
                //display: inline-block;
                margin: 20px;         
                border-radius: 5px;
                padding: 10px 25px ; '>Datos del programa</th>";    
                echo " <th ></th>";    
                echo "</tr>";
                echo "<tr>";    
                echo " <td>Clave :</td><td>".$f['IdPrograma']." </td>";    
                echo " </tr>";  
                echo "<tr>";    
                echo " <td>Fecha de Captura:</td><td>".$f['FechaCaptura']."</td>";    
                echo " </tr>";              
                echo "<tr>";    
                echo " <td>Nombre General del Programa:</td><td><input id='ProgramaGral' type='text' class='form-control' value='".$f['ProgramaGral']."'></td>";    
                echo " </tr>";
                echo "<tr>";    
                echo " <td>Nombre del Subprograma:</td><td><input id='Programa' type='text' class='form-control' value='".$f['Programa']."' ></td>";    
                echo " </tr>";
                echo "<tr>";    
                echo " <td>Año de Presupuesto:</td><td><input id='Ejercicio' type'=text' class='form-control' value='".$f['Ejercicio']."'></td>";    
                echo " </tr>";                
                echo "<tr>";   
                echo " <td>";
                //echo "<div id:'tipocredito'><label>Tipo de programa</label><select name='tipoprograma' id='tipoprograma'  onchange='ShowSelected()'; >
                echo "Tipo de programa</td><td>";                                
                echo "<select name='IdTipoPrograma' class='custom-select' id='IdTipoPrograma' >";
                $sql = "SELECT * FROM cattipoprograma  ORDER by IdTipoPrograma ASC";
                $v = $Vivienda -> query($sql);
                while($vv = $v -> fetch_array())
                { // resultado de la busqueda.................
                    echo "<option value='".$vv['IdTipoPrograma']."' >".$vv['TipoPrograma']. "</option>";                   
                }
                     echo "<option value='".$f['IdTipoPrograma']."' selected>".buscaidconcepto('TipoPrograma', 'cattipoprograma','IdTipoPrograma', $f['IdTipoPrograma'] ? $f['IdTipoPrograma']  : '0' )."</option>";                                   
                echo "</select>  ";    
                echo " </td>";
                ///echo " <td>Tipo de Programa:</td><td> ".buscaidconcepto("TipoTramite", "cattipotramite","IdTipoTramite",$f['IdTipoPrograma'])."</td>";   
                // echo " <td>Tipo de Programa:</td><td> ".$f['IdTipoPrograma']."</td>";    
                echo " </tr>";
                
                echo "<tr>";    
                Echo " <td>Dias de Pago:</td><td><input id='DiasdePago' type='text'  class='form-control' value='".$f['DiasdePago']."'></td>";    
                echo " </tr>";
                echo "<tr> <td>Subsidiado al 100%:</td><td>";  
                //class='form-control'
                        echo "<select name='Subsidiado' id='Subsidiado' class='custom-select'  >
                        <option value='1'>Si</option>
                        <option value='0'>No</option>";                     
                        if ($f['Subsidiado']=='1'){                        
                        echo "<option value='".$f['Subsidiado']."' selected>Si</option>";
                    }else{
                        echo "<option value='".$f['Subsidiado']."' selected>No</option>";
                    }
                    echo "</select>";                
                echo "</td> </tr>";
                //cattipovale    
                        echo "<tr><td>Tipo de vale:</td>";
                        echo "<td>";
                                echo "<select name='TipoImpVale' class='custom-select' id='TipoImpVale' >";
                                $sql = "SELECT * FROM cattipovale  ORDER by Id ASC";
                                $v = $Vivienda -> query($sql);
                                while($vv = $v -> fetch_array())
                                { // resultado de la busqueda.................
                                    echo "<option value='".$vv['Id']."' >".$vv['TipoVale']. "</option>";
                                }
                                     echo "<option value='".$f['TipoImpVale']."' selected>".buscaidconcepto('TipoVale', 'cattipovale','Id', $f['TipoImpVale'] ? $f['TipoImpVale']  : '3' )."</option>";                                   
                            echo "</select>  ";                            
                        echo "</td>";   
                        echo " </tr>";   
                    //area de aplicación    
                        echo "<tr>";
                        echo "<td>";
                        echo "<div><label>Area de aplicación de los paquetes:</label></td><td><select name='AreaAplicacion' Id='AreaAplicacion' class='custom-select'>";
                        //<select id="prioridadForm" name="prioridadForm">
                                echo "<option value='T' >Igual para todas las delegaciones</option>";
                                echo "<option value='D' >Aplicación por Delegación</option>";
                                echo "<option value='M' >Aplicación por Municipio</option>";
                                echo "<option value='' >Sin Especificar</option>";
                        if($f['AreaAplicacion']=='T'){
                                echo "<option value='T' selected>Igual para todas las delegaciones y municipios</option>";
                        }                       
                        if($f['AreaAplicacion']=='D'){
                                echo "<option value='D' selected >Aplicación por Delegación</option>";                               
                          }
                          if($f['AreaAplicacion']=='M'){
                                echo "<option value='M' selected >Aplicación por municipio</option>";
                          } elseif($f['AreaAplicacion']==''){
                                echo "<option value='' selected >Sin Especificar</option>";
                          } 

                             
                        echo "</select></div>";     
                        //echo "<option value='".$f['AreaAplicacion']."' selected></option>";  
                        
                        echo "</td>";   
                        echo " </tr>";                      
                        
                //paquetes de material                        
                if ($f['ListaIdPaqueteMat']!=""){        
                $sql="";
                $sql="SELECT GROUP_CONCAT(PaqueteMaterial) as listapaquetes FROM paquetematerial where IdPaqueteMaterial in(".$f['ListaIdPaqueteMat'].")";
                $paqs=$Vivienda->query($sql);
                $paqs2 = $paqs -> fetch_array();                
                        echo "<tr>";   
                        echo " <td>Paquete de Material:</td><td> ".$paqs2['listapaquetes']."</td>";    
                        echo " </tr>";
                }else{
                        echo "<tr>";   
                        echo " <td>Paquete de Material:</td><td> Sin registro </td>";    
                        echo " </tr>";               
                }

                //aqui inicia acordeon
                echo "<tr>";   
                echo " <td></td><td>";                 
                echo "<div class='accordionProg' id='accordionExample'>";
                        echo "<div class='card'>";
                        echo "<div class='card-header' id='headingOne'>";
                        echo "<h2 class='mb-0'>";
                        //echo "<button class='btn btn-link btn-block text-left collapsed' type='button' data-toggle='collapse' data-target='#collapseOne' aria-expanded='false' aria-controls='collapseOne'>";
                        echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">';
                        echo "Cambiar la lista de Material";
                        echo "</button>";
                        echo "</h2>";
                        echo "</div>";
                        echo "<div id='collapseOne' class='collapse' aria-labelledby='headingOne' data-parent='#accordionExample'>";
                        echo "<div class='card-body'>";
                        
                        echo "<div class='container' >";
                                echo "<div class='row row-cols-3' >";    
                                // MARCA CHECKS
                                //$mysqli = new mysqli("localhost","root","","lawliet");
                                $sql = "SELECT IdPaqueteMaterial,PaqueteMaterial FROM paquetematerial ORDER BY IdPaqueteMaterial";
                                $result = $Vivienda->query($sql);
                                $paquetes = [];
                                while ($paquete = $result->fetch_assoc()) {
                                array_push($paquetes, ["IdPaqueteMaterial" => $paquete["IdPaqueteMaterial"],"PaqueteMaterial" => $paquete["PaqueteMaterial"]]);
                            }     
                                $paqueteselegidos = explode(",", $f['ListaIdPaqueteMat']);
                                while ($paquete = $result->fetch_assoc()) {
                                array_push($paqueteselegidos, $paquete["IdPaqueteMaterial"]);
                            }                         
                                $existepaq = False;
                                foreach($paquetes as $i => $paquete) {
                                        foreach($paqueteselegidos as $i => $paqueteseleccionado) {
                                                if($paquete["IdPaqueteMaterial"] == $paqueteseleccionado) {
                                                        $existepaq = True;
                                                        break;
                                                } else {
                                                        $existepaq = False;
                                                }
                                        }                         
                                        if($existepaq) {
                                                echo "<div><input type='checkbox'  name='paquetematerial[]' value='".$paquete["IdPaqueteMaterial"]."' checked/><label>".$paquete["PaqueteMaterial"]."</label></div>";
                                        } else {
                                                echo "<div><input type='checkbox'  name='paquetematerial[]' value='".$paquete["IdPaqueteMaterial"]."'/><label>".$paquete["PaqueteMaterial"]."</label></div>";
                                        }
                                }
                                //HASTA AQUI   

                                        /* $sql = "SELECT * FROM paquetematerial  ORDER by IdPaqueteMaterial ASC";
                                        $v = $Vivienda -> query($sql);                                        
                                        while($vv = $v -> fetch_array())
                                        {                                 
                                        echo "<div class='col'><input type='checkbox' class='form-check-input' name='paquetematerial[]' id='paquetematerial[]' value='".$vv['IdPaqueteMaterial']."' >".$vv['PaqueteMaterial']."</div>";                                                                        
                                        }      */                                                                   
                                echo "</div>";                               
                        echo "</div> ";                          
                        echo "</div>";
                        echo "</div>";                        
                echo "</div> ";                  
            echo "</div> ";            
            echo "</td></tr>" ;     
            //acaba acordeon               
                echo "<tr>";    
                echo " <td>Configuración de metas:</td><td> ";
                    echo "<select name='IdTipoTramite' id='IdTipoTramite' class='custom-select'>";
                    $sql = "SELECT * FROM cattipotramite where IdTipoTramite in (1,2,3,4,5) ORDER by IdTipoTramite ASC";
                    $v = $Vivienda -> query($sql);
                    while($vv = $v -> fetch_array())
                    { // resultado de la busqueda.................
                        echo "<option value='".$vv['IdTipoTramite']."' >".$vv['TipoTramite']. "</option>";
                    }
                        echo "<option value='".$f['IdTipoTramite']."' selected>".buscaidconcepto('TipoTramite', 'cattipotramite','IdTipoTramite', $f['IdTipoTramite'] ? $f['IdTipoTramite']  : '0' )."</option>";
                    echo "</select>  ";       
                //.buscaidconcepto("TipoTramite", "cattipotramite","IdTipoTramite",$f['IdTipoTramite']).
                echo "</td>";
                echo " </tr>";
                echo "<tr><td>Estatus:</td><td>";
                echo "<select name='Activo' id='Activo' class='custom-select'  >
                     <option value='1'>Activo</option>
                     <option value='0'>Inactivo</option>";                     
                     if ($f['Activo']=='1'){                        
                        echo "<option value='".$f['Activo']."' selected>Activo</option>";
                    }else{
                        echo "<option value='".$f['Activo']."' selected>Inactivo</option>";
                    }
                    echo "</select>"; 
                echo "</td></tr>";    
                
                echo "<tr><td>Tipo de Asignación:</td><td>";
                echo "<select name='TipoAsignacion' Id='TipoAsignacion' class='custom-select'>";
                echo "<option value='0' >Asignación Directa</option>";
                echo "<option value='1' >Asignación Abierta</option>";
                echo "<option value='2' >Asignación Semi-Directa</option>";
                echo "</select></td></tr>";  
                
                echo "<tr><td>";
                echo " <div><label>Concepto de pago:</label> <input type='text'  id='ejemplo' name='ejemplo' ></td><td> ";
                echo "<select name='idTipoMov' id='idTipoMov' class='custom-select'>";
                $sql = "SELECT * FROM descripcionmovimiento where IdTipoCuenta=3  ORDER by DescripcionMovimiento ASC";
                $v = $Vivienda -> query($sql);
                while($vv = $v -> fetch_array())
                { // resultado de la busqueda.................
                        echo "<option value='".$vv['idTipoMov']."' >".$vv['DescripcionMovimiento']. "</option>";
                }                
                echo "</select></div>";     
                echo "</td></tr>";

                echo "<tr>";    
                echo " <td>Observación 1:</td><td><input type='text' id='Informacion1' class='form-control' value='".$f['Informacion1']."'></td>";    
                echo " </tr>";
                echo "<tr>";    
                echo " <td>Observación 2:</td><td><input type='text' id='Informacion2' class='form-control' value='".$f['Informacion2']."'></td>";    
                echo " </tr>";   
                echo "<tr>";    
                echo "<td>Breve descripción del programa : </td><td><textarea name='Descripcion' class='form-control' id='Descripcion'  rows='3' style='resize:none'  maxlength='300'  >".$f['Descripcion']."</textarea></td>";
                echo " </tr>";  
                       
                 
                echo "<tr><td> </td> <td> <button onclick='GuardaModPrograma(".$f['IdPrograma'].");' class='btn btn-primary btn-lg'>Guardar</button></td> </tr> ";
                echo "  </table>";
                echo "<div id='resultado'></div>";
                echo "  </div>";                
            }else {
                //solo consulta
                echo "<div >";
                echo " <h2 style='color: cornflowerblue;'>".$f['ProgramaGral']."</h2>";
                echo " <h2 style='color: cornflowerblue;'>".$f['Programa']."</h2>";
                echo "</div>";                    
                echo "<div >";
                        echo "<table class='tabla' >";                
                        echo "<tr>";
                        echo "<th scope='row;' width=35%;  style='font-size: 12pt;
                        //display: inline-block;
                        margin: 20px;         
                        border-radius: 5px;
                        padding: 3px; '>Datos del programa</th>";    
                        echo " <th></th>";                    
                        echo "</tr>";
                        echo "<tr>";    
                        echo " <td>Clave :</td><td>".$f['IdPrograma']." </td>";    
                        echo " </tr>";   
                        echo "<tr>";    
                        echo " <td>Fecha de Captura:</td><td> ".$f['FechaCaptura']."</td>";    
                        echo " </tr>";             
                        echo "<tr>";    
                        echo " <td>Nombre General del Programa:</td><td>".$f['ProgramaGral']."</td>";    
                        echo " </tr>";
                        echo "<tr>";    
                        echo " <td>Nombre del Subprograma:</td><td>".$f['Programa']."</td>";    
                        echo " </tr>";
                        echo "<tr>";    
                        echo " <td>Año de Presupuesto:</td><td> ".$f['Ejercicio']."</td>";    
                        echo " </tr>";                
                        echo "<tr>";   
                        echo " <td>Configuración de metas:</td><td> ".buscaidconcepto("TipoTramite", "cattipotramite","IdTipoTramite",$f['IdTipoPrograma'])."</td>";   
                        // echo " <td>Tipo de Programa:</td><td> ".$f['IdTipoPrograma']."</td>";    
                        echo " </tr>";               
                        echo "<tr>";    
                        Echo " <td>Dias de Pago:</td><td> ".$f['DiasdePago']."</td>";    
                        echo " </tr>";
                        echo "<tr>";    
                        if ($f['Subsidiado']==1 ) {         
                                echo " <td>Subsidiado al 100%:</td><td> Si</td>"; 
                        }   
                        else{
                                echo " <td>Subsidiado al 100%:</td><td> No</td>";        
                        }
                        echo " </tr>";
                        //cattipovale                            
                        if ($f['TipoImpVale']!=0 && $f['TipoImpVale']!='null' ) {
                                echo "<tr>";    
                                echo " <td>Tipo de vale:</td><td> ".buscaidconcepto("TipoVale", "cattipovale","Id",$f['TipoImpVale'])."</td>";   
                                echo " </tr>";
                        }else{
                                echo "<tr>";    
                                echo " <td>Tipo de vale:</td><td> Sin Vale</td>";    
                                echo " </tr>";
                        }      

                        //area de aplicación    
                        echo "<tr><td>Aplicación de los paquetes:</td>";
                        //echo "<td>";
                        if ($f['AreaAplicacion']=="T" ) {
                                echo " <td>Igual para todas las delegaciones</td>"; 
                        } elseif ($f['AreaAplicacion']=="D" ){
                                echo " <td>Aplicación por Delegación</td>"; 
                        } elseif  ($f['AreaAplicacion']=='M' ) {
                                echo " <td>Aplicación por municipio</td>"; 
                        }  elseif  ($f['AreaAplicacion']=='' ) {
                                echo " <td>Sin Especificar</td>"; 
                        }                                             
                        //echo "</td>";   
                        echo " </tr>";                      

                        if ($f['ListaIdPaqueteMat']!=""){    

                                $sql="";
                                $sql="SELECT GROUP_CONCAT(PaqueteMaterial) as listapaquetes FROM paquetematerial where IdPaqueteMaterial in(".$f['ListaIdPaqueteMat'].")";
                                $paqs=$Vivienda->query($sql);
                                $paqs2 = $paqs -> fetch_array();                
                                        echo "<tr>";   
                                        echo " <td>Paquete de Material:</td><td> ".$paqs2['listapaquetes']."</td>";    
                                        echo " </tr>";


                                        
                                }else{
                                        echo "<tr>";   
                                        echo " <td>Paquete de Material:</td><td> Sin registro </td>";    
                                        echo " </tr>";               
                                }          
                        
                        echo "<tr>";    
                        echo " <td>Tipo de trámite, define la evaluación:</td><td> ".buscaidconcepto("TipoTramite", "cattipotramite","IdTipoTramite",$f['IdTipoTramite'])."</td>";
                        echo " </tr>";
                        echo "<tr>";              
                        if ($f['Activo']==1 ) {         
                                echo " <td>Estatus</td><td>Activo</td>"; 
                        }   
                        else{
                                echo " <td>Estatus</td><td>Inactivo</td>";        
                        }
                        echo " </tr>";                
                        echo "</td></tr>";    

                        echo "<tr><td>Tipo de Asignación:</td>";
                        
                        if ($f['TipoAsignacion']==0 ) {
                                echo " <td>Asignación Directa</td>"; 
                        } elseif ($f['TipoAsignacion']==1 ){
                                echo " <td>Asignacion Abierta</td>"; 
                        } elseif  ($f['TipoAsignacion']==2 ) {
                                echo " <td>Asignacion Semi-Directa</td>"; 
                        } else {
                        
                                return 0;
                        }                   
                        echo "</td></tr>";
                        
                        
                        if ($f['ConceptoParaPago']!=0 && $f['ConceptoParaPago']!='null' ) {
                                echo "<tr>";    
                                echo " <td>Concepto del Pago:</td><td> ".buscaidconcepto("DescripcionMovimiento", "DescripcionMovimiento","idTipoMov",$f['ConceptoParaPago'])."</td>";   
                                echo " </tr>";
                        }else{
                                echo "<tr>";    
                                echo " <td>Tipo de vale:</td><td> Sin registrar</td>";    
                                echo " </tr>";
                        }                      



                        //** */       



                        echo "<tr>";    
                        echo " <td>Observación 1:</td><td> ".$f['Informacion1']."</td>";    
                        echo " </tr>";
                        echo "<tr>";    
                        echo " <td>Observación 2:</td><td> ".$f['Informacion2']."</td>";    
                        echo " </tr>";      
                        echo "<tr>";                        
                        echo "<td>Breve descripción del programa : </td><td><textarea disabled name='Descripcion' class='form-control' id='Descripcion' rows='3' style='resize:none'  maxlength='300' >".$f['Descripcion']."</textarea></td>";
                        echo " </tr>";          
                        //echo "<tr><td> </td> <td> <button onclick='GuardaPrograma(".$f['IdPrograma'].");'>Guardar</button></td> </tr> ";
                echo "  </table>";
                echo "<div id='resultado'></div>";
                echo "  </div>"; 
            }    
 }
}
else {mensaje("No tiene permiso para ver esta aplicacion",'');}	 


?>



<script>


function ShowSelected(){
        //alert ('entro');
        var valor = document.getElementById("tipoprograma").value;
        
        switch (valor) {
                case '1':
                        $("#material").css({'display':'inline-block'});
                        $("#lotes").css({'display':'none'});
                        $("#edificacion").css({'display':'none'});
                        $("#lotevivienda").css({'display':'none'});
                        $("#vivusada").css({'display':'none'});
                        break;
                case '2':
                        $("#material").css({'display':'none'});
                        $("#lotes").css({'display':'inline-block'});
                        $("#edificacion").css({'display':'none'});
                        $("#lotevivienda").css({'display':'none'});
                        $("#vivusada").css({'display':'none'});
                        break;        
                case '3':
                        $("#material").css({'display':'none'});
                        $("#lotes").css({'display':'none'});
                        $("#edificacion").css({'display':'inline-block'});
                        $("#lotevivienda").css({'display':'none'});
                        $("#vivusada").css({'display':'none'});
                        break;
                case '4':
                        $("#material").css({'display':'none'});
                        $("#lotes").css({'display':'none'});
                        $("#edificacion").css({'display':'none'});
                        $("#lotevivienda").css({'display':'inline-block'});
                        $("#vivusada").css({'display':'none'});
                        break;                
                case '5':
                        $("#material").css({'display':'none'});
                        $("#lotes").css({'display':'none'});
                        $("#edificacion").css({'display':'none'});
                        $("#lotevivienda").css({'display':'none'});
                        $("#vivusada").css({'display':'inline-block'});        
                default:
                        break;
        }


        /* if(valor==1)
        {  
                 alert(valor);       
                $("#material").css({'display':'inline-block'});
                $("#lotes").css({'display':'none'});
               // $("#edificacion").css({'display':'none'});        
        }
        else {
                if (valor==2){
                alert(valor);
                $("#material").css({'display':'none'});
                $("#lotes").css({'display':'inline-block'});  
               // $("#edificacion").css({'display':'inline-block'});      
                }
        } */
}

$(document).ready(function() {

$('[name="paquetematerial[]"]').click(function() {
    
  var arr = $('[name="paquetematerial[]"]:checked').map(function(){
    return this.value;
  }).get();
  
  var str = arr.join(',');
  
  //$('#arr').text(JSON.stringify(arr));
  
  //$('#arr').text(str);
  $('#arr').val(str);

});

});
function GuardaModPrograma(IdPrograma){

        alert('entro modprogr');
    Programa=$('#Programa').val();
    ProgramaGral=$('#ProgramaGral').val();
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
    AreaAplicacion=$('#AreaAplicacion').val();
    areaaplicacionorig=$('#areaaplicacionorig').val();  
    listapaqorig=$('#listapaqorig').val();  
    
    if (areaaplicacionorig!=AreaAplicacion ){
        alert("esta cambiando un dato")
        var mensaje;
        var opcion = confirm("esta cambiando un dato importante, esto podria afectar las corridas financieras, Desea continuar?" );
        if (opcion == true) {
                 mensaje = "Has clickado OK";
                 alert("Has clickado OK");

                 $('#preloader').show();
				$.ajax({
					url: 'data_programas.php',
                                        type: 'post',			
                                        data: {IdPrograma: IdPrograma, Programa:Programa, ProgramaGral:ProgramaGral,
                                                FechaCaptura:FechaCaptura,        
                                                Ejercicio:Ejercicio, IdTipoPrograma:IdTipoPrograma,Descripcion:Descripcion,
                                                DiasdePago:DiasdePago,Subsidiado:Subsidiado,IdTipoTramite:IdTipoTramite,
                                                Informacion1:Informacion1,Informacion2:Informacion2,
	                                        TipoImpVale:TipoImpVale,Activo:Activo,ListaIdPaqueteMat:ListaIdPaqueteMat,TipoAsignacion:TipoAsignacion,
                                                AreaAplicacion:AreaAplicacion},
					success: function(data){
					$('#resultado').html(data);
					$('#preloader').hide();
					}
				});
	} else {
	         mensaje = "Has clickado Cancelar";
                 alert("Operación cancelada");
	}
	document.getElementById("ejemplo").value = mensaje;

    }
  
 // alert(ListaIdPaqueteMat);
    //console.log(IdTipoPrograma);

    //console.log(IdPrograma);
   /*  $('#preloader').show();
				$.ajax({
					url: 'data_programas.php',
                                        type: 'post',			
                                        data: {IdPrograma: IdPrograma, Programa:Programa, ProgramaGral:ProgramaGral,
                                                FechaCaptura:FechaCaptura,        
                                                Ejercicio:Ejercicio, IdTipoPrograma:IdTipoPrograma,Descripcion:Descripcion,
                                                DiasdePago:DiasdePago,Subsidiado:Subsidiado,IdTipoTramite:IdTipoTramite,
                                                Informacion1:Informacion1,Informacion2:Informacion2,
	                                        TipoImpVale:TipoImpVale,Activo:Activo,ListaIdPaqueteMat:ListaIdPaqueteMat,TipoAsignacion:TipoAsignacion,
                                                AreaAplicacion:AreaAplicacion},
					success: function(data){
					$('#resultado').html(data);
					$('#preloader').hide();
					}
				}); */
				

}

/* function GuardaPrograma(){
        alert ('entro guarda programa xxx');
                var selected = '';    
                //$('#formid input[type=checkbox]').each(function(){
                $('#formid input[type=checkbox]').each(function(){
                        
                        if (this.checked) {
                                selected += $(this).val()+', ';
                        }
                        }); 

                        if (selected != '') 
                        alert('Has seleccionado: '+selected);  
                        else
                        alert('Debes seleccionar al menos una opción.');

                        return false; 
                      });         
} */

function Check(){   
   
   $("#preloader").show();

   $("#Pase_"+IdPase).css({'display':'none','color':'gray'});
   $.ajax({
           url: "auscencia_temporal_autoriza_ok.php",
      type: "post",
   //    data: "id="+IdPase, "nitavu=" + Nitavu
      data: {id: IdPase, nitavu: Nitavu },
      success: function(data){
           
           $('#R').html(data+"\n");
           $("#preloader").hide();
   
      }
   });
   
}

function ProgramasData(){   
      //  console.log('Hola');        
        var Len = $("#txtPrograma").val().length;    
        var txtBeneficiaro = $("#txtPrograma").val();

        var nitavu = "<?php echo $nitavu;?>";
        if (Len >= 0){
        $("#indicaciones").html("<a href='' style='display:block;'>Iniciar nueva busqueda</a>");
        

        $("#preloader").show()
        $("#Resultado").html("");
        search = $('#txtPrograma').val();
        $.ajax({
                url: "programas_data.php",
                type: "get",   
                data: {nitavu: nitavu, search: search },
                success: function(data){
                $('#Resultado').html(data+"\n");
                $("#preloader").hide()
                }
                });
        } else {
        var faltan = 10- Len;
        $.toast({
        heading: 'Warning',
        text: "Escriba <b>"+faltan+"</b> caracteres, para poder iniciar la busqueda.",
        showHideTransition: 'plain',
        icon: 'warning'
        })
        } 

}


</script>






<!-- Hacer algo de espacio para testear -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>