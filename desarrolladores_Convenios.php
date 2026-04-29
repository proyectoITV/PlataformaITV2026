<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
require_once('seguridad.php');
//require("lib/funciones.php");
//require("lib/yes_funciones.php");
//require("lib/flor_funciones.php");

?>



<?php
$id_aplicacion ="ap117"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos

//Niveles
// 1 = Crear y Editar
// 2 = Consulta

//Ajusta esta variable para ver el comportamiento
//$nivel=1;

echo "<script>$('body').css('background-color','rgb(108, 116, 119)');</script>";
// echo "<script>$('body').css('background-size','150%');</script>";

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    
    
    
    if (isset($_GET['id'])){
        $IdConvenio = VarClean($_GET['id']);
        $VInfo = Desarrollador_Info($IdConvenio);
        echo "<div style='
        background: rgb(33,116,166);
        background: linear-gradient(180deg, rgba(33,116,166,1) 0%, rgba(33,116,166,1) 14%, rgba(108,116,119,1) 71%); 
        margin-top:-8px;
        padding:10px;
        
        '
     
        >";
            echo "<table width=100%>";
            echo "<tr>";
            echo "<td style='text-align-last: left';><h3 style='color:white;'>Convenio Num.".$IdConvenio."</h3></td>";
            echo "<td align=right>";
            echo "<a  class='btn btn-primary' href='?='>Regresar</a>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
        echo "</div>";

        echo "<div id='Form' class='container' style='background-color: #fff;
        border-radius: 5px;
        padding: 15px;
        margin-top:20px;
        '>";
        
       // $sql="Select * from convdesarrollador where  Folio=".$IdConvenio;
       $sql="Select Folio, DATE_FORMAT(FechaConvenio, '%d-%m-%Y') as FechaConvenio, PlazoConvenio, TotalLotes, MontoConvenio,
       (select catdesarrolladores.Nombre from catdesarrolladores where catdesarrolladores.IdDesarrollador = convdesarrollador.IdDesarrollador) AS Nombre,
       AnticipoGlobal,SubsidioLote,case when Completo= 1 then 'Completo' else 'incompleto' end AS Completo
       from convdesarrollador where  Folio=".$IdConvenio." Order By Folio" ;
        
        //echo $sql;
        $rc= $Vivienda -> query($sql);
        if($f = $rc -> fetch_array())
            {

                echo "<table width=100%><tr>";               
                echo "<form method='POST' enctype='multipart/form-data' id='VForm'>";               
                echo "</form>"; 
                echo "<td valign=top >";
                               
                text_largo('VNombre','Desarrollador','Nombre del Desarrollador','text',$f['Nombre'],'','True');
                FormElement_input("Número de Convenio ",$f['Folio'],"", "","text","", TRUE);
                FormElement_input("Fecha del convenio",$f['FechaConvenio'],"", "","text","", TRUE);
                FormElement_input("Plazo Convenio",$f['PlazoConvenio'],"", "","number","", TRUE);
                FormElement_input("Monto del Convenio",Pesos($f['MontoConvenio']),"", "","text","", TRUE);        
                FormElement_input("Anticipo Global",Pesos($f['AnticipoGlobal']),"", "","text","", TRUE);        
                FormElement_input("Subsidio por Lote",Pesos($f['SubsidioLote']),"", "","text","", TRUE);
                FormElement_input("Total Lotes",$f['TotalLotes'],"", "","number","", TRUE);
                FormElement_input("Registro Completo",$f['Completo'],"", "","text","", TRUE);
                echo "</td></tr>";

               
                echo "<tr><td>";  
               
               echo "</td></tr>";
               echo "</td></tr></table>";

               /*  echo "<div id='Botones' style='text-align:center;'>";
                echo "<button class='btn btn-success' onclick='VEditar();' style='margin:10px;'>Editar</button>";
                echo "<button class='btn btn-success' onclick='VGuardar();' style='margin:10px;'>Guardar</button>";
               // echo "<button class='btn btn-danger' onclick='VEliminar();' style='margin:10px;'>Eliminar</button>";
                
                echo "</div>"; */
                
            }
        else {return FALSE;}
        unset($rc,$f);
        echo "</div>";


                
        /* if (isset($_GET['newb'])){

            echo "<div id='Form' class='container' style='background-color: #fafbde;
            border-radius: 5px;
            padding: 15px;
            margin-top:20px;
            '>";
            
            echo "<h3 style='
                font-size: 10pt;
                color: black;
                '>Bitacora <b>Nueva Bitacoraaaa para '.$VInfo.'</b></h3>";
                echo "<form method='POST' enctype='multipart/form-data' id='VFormB'>";
            
            FormElement_input("Fecha de Solicitud",$fecha,"", "","text","Fecha_solicitud");
            FormElement_input("Fecha de ejecucion",$fecha,"", "","date","Fecha_ejecucion");
            FormElement_input("Km_prog","","", "","text","Km_prog");
            FormElement_input("Km_real","","", "","text","Km_real");
            FormElement_input("Num. de solicitud","","", "","text","num_solicitud");
            FormElement_input("Num. de Factura","","", "","text","num_factura");
            FormElement_input("Km_real","","", "","number","Km_real");
            FormElement_input("Costo de mano de obra","","", "","number","Costo_mano_obra");
            FormElement_input("Costo de refaccion","","", "","number","Costo_refaccion");            
           
            echo '
            <div class="form-group" id="DivTipoServicio" style="margin: 4px;
            padding: 4px;
            border-radius: 5px;
            vertical-align: top;">';
            echo '<label for="clave_tipo_mant" style="font-size:8pt;">Tipo de Servicio</label>';
            echo "<select id='clave_tipo_mant' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
            $rx= $conexion -> query("select * from cat_tiposdemantenimiento");                
            while($fx = $rx -> fetch_array()) {    
                    echo "<option value='".$fx['clave_tipo_mant']."' selected>".$fx['Tipo_Mantenimiento']."</option>";
            }
                
            
            unset($rx, $fx);
            echo "</select>";
            echo '<small class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;"></small>';
            echo "</div>";
            
            
            echo '
            <div class="form-group" id="DivProveedor" style="margin: 4px;
            padding: 4px;
            border-radius: 5px;
            vertical-align: top;">';
            echo '<label for="clave_proveedor" style="font-size:8pt;">Proveedor</label>';
            echo "<select id='clave_proveedor' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
            $rx= $conexion -> query("select * from cat_proveedoresvehiculos");                
            while($fx = $rx -> fetch_array()) {    
                    echo "<option value='".$fx['clave_proveedor']."' selected>".$fx['Nombre_proveedor']."</option>";
            }
            unset($rx, $fx);
            echo "</select>";
            echo '<small class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;"></small>';
            echo "</div>";
            
            
            FormElement_textarea("Descripcion","","", "","text","Descripcion");
            
            echo '
            <div class="form-group" id="DivFiles" style="margin: 4px;
            padding: 4px;
            border-radius: 5px;
            vertical-align: top;">';
            echo '<label for="FileFoto" style="font-size:8pt;">Fotografia</label>';
            echo "<input type='file' id='FileFoto' name='FileFoto' class='form-control' style='font-size:9pt; margin-top:-7px;' Accept='.jpg'>";
            echo '<small class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;"></small>';
            echo "</div>";
            
            
            echo '
            <div class="form-group" id="DivFiles2" style="margin: 4px;
            padding: 4px;
            border-radius: 5px;
            vertical-align: top;">';
            echo '<label for="FileDoc" style="font-size:8pt;">Documento (pdf)</label>';
            echo "<input type='file' id='FileDoc' name='FileDoc' class='form-control' style='font-size:9pt; margin-top:-7px;' Accept='.pdf'>";
            echo '<small class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;"></small>';
            echo "</div>";
            echo "</form>";
            
            echo '<div class="form-group" id="DivProveedor" style="margin: 4px;
            padding: 4px; width:100%;
            border-radius: 5px; text-align:center;
            vertical-align: top;">';

            echo "<button class='btn btn-success' onclick='GuardarBit();'><img src='icon/aprobados.png' style='width:20px; margin-right:10px;'>Guardar Bitacora</button>";
            echo "</div>";

            echo "</div>";

            
        }
 */

        //lista de lotes en convenio
        echo "<div id='Form' class='container' style='background-color: #fff;
        border-radius: 5px;
        padding: 15px;
        margin-top:20px;
        '>";
        
        echo "<h3>Lotes registrados en convenio :  ".$IdConvenio." </h3>";
        //<img src='icon/loading.png' style='width:18px; cursor:pointer;' onclick='VBReload();'>
        echo "<div id='RBitacoras'>";
        //xx
            $sql3="Select Manzana, Lote,IdLote,Colonia, NumContrato, MontoCredito, IdDelegacion
            from contratos
            LEFT JOIN catcolonia on contratos.IdColoniaL=catcolonia.IdColonia and contratos.IdMunicipioL=catcolonia.IdMunicipio
            where contratos.cancelado=0 and idprograma=165 and folio=".$IdConvenio." order by numcontrato";
            $rc= $Vivienda -> query($sql3);
            $row_cnt = $rc->num_rows;
            $cont=0;
            $consec=0;
            if($row_cnt>0)
            {
                //<a class="btn btn-link" href="?id=11">11</a>
                echo "<table class='Tabla'><th>Num.</th><th>Manzana</th><th>Lote</th><th>Colonia</th><th>Numcontrato</th><th>Monto Credito</th><th>Clave Lote</th>";  
                //echo "<table class='Tabla'><th>Num.</th><th>Manzana</th><th>Lote</th><th>Colonia</th><th>Numcontrato</th><th>Monto Credito</th><th>Clave Lote</th>";  
                
                while($valor = $rc -> fetch_array())
                {   
                    $consec++;                
                    echo "<tr>";
               //     echo "<td>".$consec."</td><td>".$valor['Manzana']."</td><td>".$valor['Lote']."</td><td>".$valor['Colonia']."</td><td><a class='btn btn-link' style='font-size: 12;' href='estadodecuenta.php'>".$valor['NumContrato']."</a></td><td>".$valor['MontoCredito']."</td><td>".$valor['IdLote']."</td>";    
                
                echo "<td>".$consec."</td><td>".$valor['Manzana']."</td><td>".$valor['Lote']."</td><td>".$valor['Colonia']."</td><td><a target=_blank title='Haga clic para ver el contrato' href='EdoCuenta.php?contrato=".$valor['NumContrato']."&del=".$valor['IdDelegacion']."'>".$valor['NumContrato']."</a></td><td>".$valor['MontoCredito']."</td><td>".$valor['IdLote']."</td>";
               //echo "<td>".$consec."</td><td>".$valor['Manzana']."</td><td>".$valor['Lote']."</td><td>".$valor['Colonia']."</td><td><a target=_blank title='Haga clic para ver el contrato' href='edo_dat_analizacontrato.php?_NumContrato=".$valor['NumContrato']."&nitavu=1308'>".$valor['NumContrato']."</a></td><td>".$valor['MontoCredito']."</td><td>".$valor['IdLote']."</td>";

                // probando $tb = $tb."<a title='Haz clic aqui para ver el Estado de Cuenta' target=_blank href='estadodecuenta.php?contrato=".$value['NumContrato']."&del=".$IdDelegacion."'>";    


                //echo "<td>".$consec."</td><td>".$valor['Manzana']."</td><td>".$valor['Lote']."</td><td>".$valor['Colonia']."</td><td><a class='btn btn-link' href='estadodecuenta.php?contrato="+$valor['NumContrato']+"&del=5;'>".$valor['NumContrato']."</a></td><td>".$valor['MontoCredito']."</td><td>".$valor['IdLote']."</td>";
                //echo "<td>".$valor['Manzana']."</td><td>".$valor['Lote']."</td><td>".$valor['Colonia']."</td><td>".$valor['NumContrato']."</td><td>".$valor['MontoCredito']."</td><td>".$valor['IdLote']."</td>";
                ////<td>".$valor['Lote']."</td><td>".$valor['Numcontrato']."</td><td>".$valor['MontoCredito']."</td><td>".$valor['IdLote']."</td>
                echo "</tr>";

                    //echo "<li>".$manzana;
            //echo "Nombre<input name='nombre' value='".$valor['Nombre']."' class='form-control mr-sm-2' type='search' placeholder='' aria-label='first' style='width: 100%; height: 25;'>";   
            
                }  
                echo "</table>";
            } 

        //xx
        echo "</div>";
        echo "</div>";
    } else {

        if (isset($_GET['new'])){
            //Form para Nuevo
            echo "<div style='
            background: rgb(33,116,166);
            background: linear-gradient(180deg, rgba(33,116,166,1) 0%, rgba(33,116,166,1) 14%, rgba(108,116,119,1) 71%); 
            margin-top:-8px;
            padding:10px;
            
            '
         
            >";
                 echo "<table width=100%>";
                echo "<tr>";
                echo "<td align=center><h3 style='color:white;'></h3></td>";
                echo "<td align=right>";
                echo "<a  class='btn btn-primary' href='?='>Regresar</a>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
            echo "</div>";
            
            echo "<div id='Form' class='container' style='background-color: #fff;
                    border-radius: 5px;
                    padding: 15px;
                    margin-top:20px;
                    '>
                    <h3 style='color:rgb(70, 130, 180);'>NUEVO CONVENIO</h3>
                    ";


                echo "<table width=100%><tr><td width=40% valign=top>";
                    echo "<form method='POST' enctype='multipart/form-data' id='VForm'>";
                
                    echo "</form>";
                echo "</td></tr>";
                echo "<input type='hidden' id='idmun'>";
                echo "<input type='hidden' id='idconvenio'>";

                    
                echo "<tr><td></td><td valign=top align=right><div id=numconv>";
                    FormElement_input("Número de Convenio ","","", "El número se asignará automáticamente al guardar","text","VIdConv", TRUE);
                echo "</div></td></tr>";
                echo "<tr><td colspan=2>";  
                
                    echo '
                    <div  id="DivDesarrollador" style="margin: 4px;
                        width:91%;
                        padding: 4px;
                        border-radius: 5px;
                        vertical-align: top;">';
                        echo '<label for="Desarrollador" style="font-size:8pt; margin-bottom: 6pt; color:blue;">Desarrollador</label>';
                        echo "<select id='Desarrollador' class='form-control'  style='font-size:9pt; margin-top:-7px; '>";
                        // border-radius: 5px;
                        $rx= $Vivienda -> query("select * from catdesarrolladores ORDER BY Nombre");                
                        while($fx = $rx -> fetch_array()) {    
                            
                                echo "<option value='".$fx['IdDesarrollador']."' >".$fx['Nombre']."</option>";
                                //echo "<option value='".$fx['IdDesarrollador']."' selected>".$fx['Nombre']."</option>";
                        }
                        echo "<option>Seleccione una opcion...</option>";
                        
                        unset($rx, $fx);
                        echo "</select>";
                        echo '<small class="form-text text-muted" style="font-size: 7pt;
                        margin-top: -2px;"></small>';
                    echo "</div>";
                echo "</td></tr>";
                echo "<tr><td>";                  
                echo '
                <div class="row">
                <div class="col-md-16 form-group">     
                    <div  id="DivDelegacion" class="fomr-group" style="margin: 4px;
                    
                    padding: 4px;
                    border-radius: 5px;
                    vertical-align: top;">';
                   // echo '<label for="Delegacion" class="letraazul">Delegación</label>';
                    echo '<label for="Delegacion" style="font-size:8pt; margin-bottom: 6pt; color:blue;">Delegación</label>';
                    echo "<select id='Delegacion' class='form-control'  style='font-size:9pt; margin-top:-7px; '>";
                    // border-radius: 5px;
                    $rx= $Vivienda -> query("select * from delegaciones where Tipo=0 ORDER BY Delegacion");                
                    while($fx = $rx -> fetch_array()) {    
                          echo "<option value='".$fx['IdDelegacion']."' >".$fx['Delegacion']."</option>";
                    }                       
                    
                    unset($rx, $fx);
                    echo "</select>";
                    echo '<small class="form-text text-muted" style="font-size: 7pt;
                    margin-top: -2px;"></small>';
                //echo "</div>";
                echo "</div>";    
                
                    //------------
                    echo "</td>";
                    echo "<td>";
                    echo ' 
                <div class="col-md-10 form-group">';
                    echo '<label for="Municipio" style="font-size:8pt; margin-bottom: 6pt; color:blue;">Municipio</label>';
                    
                    //echo "<select id='Municipio' class='form-control' onchange='Pasar(this.value)' style='font-size:9pt; margin-top:-7px;'>";
                    echo "<select id='Municipio' class='form-control'  style='font-size:9pt; margin-top:-7px;'>";
                    
                    // border-radius: 5px;
                    $rx= $Vivienda -> query("select * from municipios  ORDER BY Municipio");                
                    while($fx = $rx -> fetch_array()) {    
                            echo "<option value='".$fx['IdMunicipio']."' >".$fx['Municipio']."</option>";
                            $IdMunicipio=$fx['IdMunicipio'];
                          //  $IdDelegacion = $f['IdDelegacion'];
                           // $Delegacion = "Delegacion";
                    }                       
                    
                    unset($rx, $fx);
                    echo "</select>";
                    echo '<small class="form-text text-muted" style="font-size: 7pt;
                    margin-top: -2px;"></small>';

                echo "</div>";
                echo "</div>";                        
                echo "</div></td>";                   
                echo "</tr></table>";
                echo "<table width=100%><tr><td width=40% valign=top>";    
               
                        FormElement_input("Fecha Convenio","$fecha","", "","date","VFecha", FALSE);
                        FormElement_input("Plazo Convenio (Meses)","0","", "Meses pactados","number","VPlazo", FALSE);
                        FormElement_input("Monto del Convenio","0.00","", "","text","VMonto", FALSE);     
                echo "</td></tr>";
                echo "<tr><td>";        
                    FormElement_input("Anticipo Global","0.00","", "","text","VAnticipo", FALSE);        
                    FormElement_input("Subsidio por Lote","0.00","", "","text","VSubsidio", FALSE);
                    FormElement_input("Total Lotes","0","", "","number","VTotalLotes", FALSE);
                    //FormElement_input("Registro Completo","","", "","text","", FALSE);
                echo "</td></tr>";           
                echo "<tr><td>";              
                    echo '
                        <div class="form-group" id="DivFiles2" style="margin: 4px;
                        padding: 4px;
                        border-radius: 5px;
                        vertical-align: top;">';
                        echo '<label for="FileDoc2" style="font-size:8pt; margin-bottom: 6pt;">Convenio en pdf</label>';
                        echo "<input type='file' id='FileDoc2' name='FileDoc2' class='form-control' style='font-size:9pt; margin-top:-7px;' Accept='.pdf'>";
                        echo '<small class="form-text text-muted" style="font-size: 7pt;
                        margin-top: -2px;"></small>';
                        echo "</div>";
            //echo "</form>";
            echo "</td></tr>";           
            echo "<tr><td>";                                  
                        echo "<div id='Botones' style='text-align:center;'>";

                        echo "<button id='GuardaConvenio' class='btn btn-success' onclick='VGuardarNuevo();' style='margin:10px;'>Guardar</button>";
                        //echo "<button id='reviso' class='btn btn-success' onclick='Imprime();' style='margin:10px;'>Guardarxx</button>";                     
                      //ultima bien echo "<a id='AgregaLotes' class='btn btn-success'  href='?AgregaLotes=&IdMunicipio=".$IdMunicipio."' style='visibility: hidden' >Agrega Lotes</a>";
                      echo "<a id='AgregaLotes' class='btn btn-success' onclick='Listo();'  style='visibility: hidden' >Agrega Lotes</a>";
                       // var miDato = localStorage.getItem("nombre");
            echo "</td></tr></table>";
                //echo ' <input size="16" type="text" class="form-control" id="datetime" readonly>';
                //<input type='date' name='dia0' value='".$fecha."'  class='form-control'>

            echo "</div>";           
            
            //echo "</div>";
        } else {
            if(isset($_GET['AgregaLotes'])){
                $MunRec=$_GET['IdMunicipio'];
                $NC=$_GET['nc'];
                echo "<div style='
                background: rgb(33,116,166);
                background: linear-gradient(180deg, rgba(33,116,166,1) 0%, rgba(33,116,166,1) 14%, rgba(108,116,119,1) 71%); 
                margin-top:-8px;
                padding:10px;                      
                '>";
                    echo "<table width=100%>";
                    echo "<tr>";
                    echo "<td align=center><h3 style='color:white;'></h3></td>";
                    echo "<td align=right>";
                    echo "<a  class='btn btn-primary' href='?='>Regresar</a>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                echo "</div>";

                $sqlconvenio="Select * from convdesarrollador where folio=".$NC;
                $rc3=$Vivienda->query($sqlconvenio) ;
                    if($h = $rc3 -> fetch_array()){
            
                    echo "<div id='Form' class='container' style='background-color: #fff;
                            border-radius: 5px;
                            padding: 15px;
                            margin-top:20px;
                            '>
                            <h3 style='color:rgb(70, 130, 180);'>REGISTRAR LOTES EN CONVENIO</h3>
                            ";

                            echo "<h2 style=align:'center;'>Convenio número: ".$NC."</h1>";
                            echo "<hr>";
                            echo "<table style=width:'100%;'>
                            <tr style=background-color: 'blanchedalmond;'>
                            <td style='width:51%;' >Fecha de Convenio:  ".date('d-m-Y', strtotime($h['FechaConvenio']))."</td><td  style='width:38%;'>Monto del Convenio :  ".number_format($h['MontoConvenio'],2)."</td><td style='width:33%;' right >Total de lotes : ".$h['TotalLotes']."</td>
                            </tr>                            
                            </table>
                            <br>    ";
                            echo "<hr>";

                                /* echo "<label>Fecha de convenio : ".$h['FechaConvenio']."</label>";
                                echo "<br>";
                                echo "<label>Monto de convenio : ".$h['MontoConvenio']."</label>";
                                echo "<br>";

                                echo "<label>Total de lotes : ".$h['TotalLotes']."</label>";
                                echo "<br>";
 */
                            echo "<table width=100%>";
                            echo "<tr><td>";
                            echo '
                            <div  id="DivColonia" style="margin: 4px;
                                width:91%;
                                padding: 4px;
                                border-radius: 5px;
                                vertical-align: top;">';
                                
                                echo '<label for="Colonia" style="font-size:8pt; margin-bottom: 6pt; color:blue;">Seleccione una Colonia</label>';
                                echo "<select id='Colonia' class='form-control'  style='font-size:9pt; margin-top:-7px; '>";
                                // border-radius: 5px;
                                $rx= $Vivienda -> query("select * from catcolonia where IdMunicipio=".$MunRec." ORDER BY Colonia");                
                                echo "select * from catcolonia where IdMunicipio=".$MunRec." AND Colonia <>'' AND not Colonia is null ORDER BY Colonia";
                                while($fx = $rx -> fetch_array()) {    
                                    
                                        echo "<option value='".$fx['IdColonia']."' >".$fx['Colonia']."</option>";                                
                                }
                                echo "<option>Seleccione una opcion...</option>";
                                
                                unset($rx, $fx);
                                echo "</select>";
                                echo '<small class="form-text text-muted" style="font-size: 7pt;
                                margin-top: -2px;"></small>';
                            echo "</div>";
                            echo "</td><td>";
                            echo "<button id='BuscarLotes' class='btn btn-success' onclick='BuscarLotes($MunRec,$NC);' style='margin:10px;'>BuscarLotes</button>";
                            echo "</td></tr>";
                            echo "</table>";    
                            echo "<div id='ListaLotes'>";
                            echo "</div>";
                            echo "<div id='LotesElegidos'>";
                            echo "</div>";

                    echo "</div>";       
                    }
                //AgregaLotes
            }else{


            //lista de convenios
            echo "<div style='
            background: rgb(33,116,166);
            background: linear-gradient(180deg, rgba(33,116,166,1) 0%, rgba(33,116,166,1) 14%, rgba(108,116,119,1) 71%); 
            margin-top:-8px;
            padding:10px;
            
            '>";
                echo "<table width=100%>";
                echo "<tr>";
                echo "<td align=center><h3 style='color:white;'></h3></td>";
                echo "<td align=right>";
                echo "<a  class='btn btn-primary' href='?new='>Nuevo</a>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
            
            echo "</div>";

            echo "<div id='Resultado' class='container' style='background-color: #fff;
            border-radius: 5px;
            padding: 15px;
            margin-top:20px;
            '></div>";
            
            }
        }
       

    }


    

}
else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 


?>

<!-- <script type="text/javascript">
$("#datetime").datetimepicker({
    format: 'yyyy-mm-dd hh:ii'
});
</script> -->

<SCRIPT>




/* function CancelarBitacora(Clave_servicio){		            
        // search = $('#search').val();
        // console.log($ClaveServicio);
        $('#progressbar').show();
            $.ajax({
                url: "vehiculos_dat_cancelarbit.php",
            type: "post",        
            data: {Clave_servicio:Clave_servicio},
            success: function(data){                
                $("#RV").html(data+"");                    
                $('#progressbar').hide();
            }
            });

            
} */

function VReload(){		            
        search = $('#search').val();
        $('#progressbar').show();
            $.ajax({
                url: "desarrconv_dat_buscar.php",
            type: "post",        
            data: {search:search},
            success: function(data){                
                $("#Resultado").html(data+"");                    
                $('#progressbar').hide();
            }
            });            
}

/* function VBReload(){		            
    IdConvenio = aqui van unas comillas dobles y un menor que ?php if (isset($IdConvenio)) {echo $IdConvenio;} else {}?>";        
        
        $('#progressbar').show();
            $.ajax({
                url: "desarrolladores_dat_convenios_b_uno.php",
            type: "post",        
            data: {IdConvenio:IdConvenio},
            beforeSend:function(){
               // $("#RBitacoras").html("<div style='width:100%; padding-left:50%; padding-top:50px;'><img src='img/loader.gif'></div>");                    
            },
            success: function(data){                
               // $("#RBitacoras").html(data+"");                    
                $('#progressbar').hide();
            }
            });

            
} */

//VBReload();

function VEliminar(){		        
        IdVehiculo = "<?php if (isset($IdVehiculo)) {echo $IdVehiculo;} else {}?>";            
        $('#progressbar').show();
            $.ajax({
                url: "vehiculos_dat_eliminar.php",
            type: "post",        
            data: {
                IdVehiculo: IdVehiculo                
            },
            success: function(data){
                
                $("#RV").html(data+"");    
                
                $('#progressbar').hide();
            }
            });            
}

function VEditar(){
    //alert('editar');
        //IdVehiculo = "
         //if (isset($id)) {echo $id;} else {}?>";  
         IdDesarrollador = "<?php if (isset($IdDesarrollador)) {echo $IdDesarrollador;} else {}?>";  
         $('#VNombre').prop('disabled', false);
         $('#VRepresentante').prop('disabled', false);
         $('#VCURP').prop('disabled', false);
         $('#VRFC').prop('disabled', false);
         $('#VTelefono').prop('disabled', false);
         $('#VDomicilio').prop('disabled', false);
         $('#VContacto').prop('disabled', false);
         $('#VCorreo').prop('disabled', false);
         $('#VTelContacto').prop('disabled', false);
         
        //VTipo = $('#VTipo').val();
        
        //VIdPropietario = $('#VIdPropietario').val();
}
function VGuardar(){
    IdDesarrollador = "<?php if (isset($IdDesarrollador)) {echo $IdDesarrollador;} else {}?>";
       // alert ('desarrollador'+IdDesarrollador);
        //IdVehiculo = "
        //</?php if (isset($IdVehiculo)) {echo $IdVehiculo;} else {}?>";  
         VIdDesarrollador=IdDesarrollador;
         VNombre=$('#VNombre').val();
         alert('nombre '+VNombre);
         VRepresentante=$('#VRepresentante').val();
         VCURP=$('#VCURP').val();
         alert(VCURP);
         VRFC=$('#VRFC').val();
         VTelefono=$('#VTelefono').val();
         VDomicilio=$('#VDomicilio').val();
         VContacto=$('#VContacto').val();
         VCorreo=$('#VCorreo').val();
         VTelContacto=$('#VTelContacto').val();

        
        //VIdPropietario = $('#VIdPropietario').val();

    $('#VFile').html($('#VFile').val());        
    var formData = new FormData(document.getElementById('VForm'));      
    //var formData = new FormData(VForm);      
        formData.append('VIdDesarrollador',  VIdDesarrollador);
        formData.append('VNombre',  VNombre);
        formData.append('VRepresentante',VRepresentante);
        formData.append('VCURP',VCURP);
        formData.append('VRFC',VRFC);
        formData.append('VTelefono', VTelefono);
        formData.append('VDomicilio', VDomicilio);
        formData.append('VContacto',  VContacto);
        formData.append('VCorreo', VCorreo);
        formData.append('VTelContacto', VTelContacto);       
      // alert('baje');
       // formData.append('VIdPropietario', VIdPropietario);

$('#progressbar').show();
$.ajax({
    url: 'desarrolladores_dat_guardar.php',
    type: 'post',
    dataType: 'html',
    data: formData,             
    cache: false,
    contentType: false,
    processData: false,
    beforeSend:function(){
        // console.log('Cargando..');
    },
    success:function(data){
        // console.log(data);
        $('#R').html(data);
        $('#progressbar').hide();
    }
});


}



function VGuardarNuevo(){        
                
         VIdDesarrollador=$('#Desarrollador').val();
         //alert('nombre '+VIdDesarrollador);
         VIdDelegacion=$('#Delegacion').val();
         VIdMunicipio=$('#Municipio').val();
         VFechaConvenio=$('#VFecha').val();
         VTotalLotes=$('#VTotalLotes').val();         
         VMontoConvenio=$('#VMonto').val();
         VPlazoConvenio=$('#VPlazo').val();
         VSubsidioLote=$('#VSubsidio').val();
         VAnticipoGlobal=$('#VAnticipo').val();
         VFileDoc2=$('#FileDoc2').val();
         
       

    //$('#VFile').html($('#VFile').val());     
    $('#FileDoc2').html($('#FileDoc2').val());     
    var formData = new FormData(document.getElementById('VForm'));      
        formData.append('VIdDesarrollador',  VIdDesarrollador);
        formData.append('VIdDelegacion',  VIdDelegacion);
        formData.append('VIdMunicipio',  VIdMunicipio);
        formData.append('VFechaConvenio',VFechaConvenio);
        formData.append('VTotalLotes',VTotalLotes);
        formData.append('VMontoConvenio',VMontoConvenio);
        formData.append('VPlazoConvenio', VPlazoConvenio);
        formData.append('VSubsidioLote', VSubsidioLote);
        formData.append('VAnticipoGlobal',  VAnticipoGlobal);
        formData.append('VFileDoc2',  VFileDoc2);

    
$('#progressbar').show();
$.ajax({
    url: 'desarrolladoresconv_guardar_nuevo.php',
    type: 'post',
    dataType: 'html',
    data: formData,             
    cache: false,
    contentType: false,
    processData: false,
    beforeSend:function(){
        // console.log('Cargando..');
    },
    success:function(data){                 
        //$('#VIdConv').val(data);
        $('#R').html(data);
        $('#progressbar').hide();
        //$('#AgregaLotes').prop('disabled', false);
        $('#AgregaLotes').css('visibility', 'visible');
        //style="visibility: hidden"
        $('#GuardaConvenio').prop('disabled', true);
        //GuardaConvenio
    }
});


}

VReload();

function ActualizaFoto(){
    d = new Date();
    
    IdVehiculo = "<?php if (isset($IdVehiculo)) {echo $IdVehiculo.'.jpg';} else { echo "icon/vnofoto.png";}?>";    
    src='fotos_vehiculos/'+IdVehiculo+'?';
    $("#foto").attr("src",src+d.getTime());
}


/* function GuardarBit(){		            
    IdVehiculo = AQIO VAN COMILLAS DOBLES Y UN MENOR QUE ?php if (isset($IdVehiculo)) {echo $IdVehiculo;} else {}?>";            
    VTipo = $('#VTipo').val();
    Clave_servicio = $('#Clave_servicio').val();
    Num_economico = $('#Num_economico').val();
    Fecha_solicitud = $('#Fecha_solicitud').val();
    Fecha_ejecucion = $('#Fecha_ejecucion').val();
    clave_tipo_mant = $('#clave_tipo_mant').val();
    Km_prog = $('#Km_prog').val();
    Km_real = $('#Km_real').val();
    num_solicitud = $('#num_solicitud').val();
    num_factura = $('#num_factura').val();
    clave_proveedor = $('#clave_proveedor').val();
    Descripcion = $('#Descripcion').val();
    Costo_mano_obra = $('#Costo_mano_obra').val();
    Costo_refaccion = $('#Costo_refaccion').val();

    var formData = new FormData(document.getElementById('VFormB'));        
        formData.append('IdVehiculo',  IdVehiculo);        
        formData.append('Clave_servicio', Clave_servicio);
        formData.append('Num_economico', Num_economico);
        formData.append('Fecha_solicitud', Fecha_solicitud);
        formData.append('Fecha_ejecucion', Fecha_ejecucion);
        formData.append('clave_tipo_mant', clave_tipo_mant);
        formData.append('Km_prog', Km_prog);
        formData.append('Km_real', Km_real);
        formData.append('num_solicitud', num_solicitud);
        formData.append('num_factura', num_factura);
        formData.append('clave_proveedor', clave_proveedor);
        formData.append('Descripcion', Descripcion);
        formData.append('Costo_mano_obra', Costo_mano_obra);
        formData.append('Costo_refaccion', Costo_refaccion);


        $('#progressbar').show();
            $.ajax({
                url: "vehiculos_dat_savebit.php",    
            type: 'post',
            dataType: 'html',
            data: formData,             
            cache: false,
            contentType: false,
            processData: false,
            beforeSend:function(){
                // $('#progressbar').show();        
            },
            success: function(data){                
                $("#RV").append(data+"");                                    
                $('#progressbar').hide();
            }
            });

            
} */

function GuardaMun(){


//    <script type="text/javascript">
    // guardar datos
   localStorage.setItem("mun", document.getElementById("Municipio").value);
   // alert('entre');
    // leer datos
  //  var miDato = localStorage.getItem("nombre");

};

function Pasar(valor){
    alert(valor);
    console.log(valor);
//document.location.href='mismapagina.php?place='+document.f1.pais.value;
//document.location.href='desarrolladores_Convenios.php?AgregaLotes='+document.f1.pais.value;
//document.location.href='mismapagina.php?place='+va lor;}
//document.location.href='desarrolladores_Convenios.php?AgregaLotes&='+valor;
document.location.href='desarrolladores_Convenios.php?AgregaLotes=&IdMunicipio='+valor;
}

function Listo(){
    //alert ('entre a imprime');    
    valor=$('#Municipio').val();
    numconv=$('#VIdConv').val();
    //alert(numconv);
    
    //console.log(valor);

document.location.href='desarrolladores_Convenios.php?AgregaLotes=&IdMunicipio='+valor+'&nc='+numconv;
//document.location.href='desarrolladores_Convenios.php?AgregaLotes=&IdMunicipio='+valor;
}

function BuscarLotes(MunRec,NC){          
        IdColonia=$('#Colonia').val();          
        $('#progressbar').show();
            $.ajax({
                url: "desarrolladores_addLotesConvenio.php",
            type: "post",        
            data: {IdColonia:IdColonia, MunRec:MunRec, NC:NC},
            beforeSend:function(){
                $("#ListaLotes").html("<div style='width:100%; padding-left:50%; padding-top:50px;'><img src='img/loader.gif'></div>");                    
            },
            success: function(data){                
                $("#ListaLotes").html(data+"");                    
                $('#progressbar').hide();
            }
            });


    /* echo "<div class='container'>"; 
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
                            } */
}

/* $(function(){  
    $("#Delegacion").change(function(){
        alert ('le di clik');

    })
}) */


</SCRIPT>
<?php include ("./lib/body_footer.php"); ?>