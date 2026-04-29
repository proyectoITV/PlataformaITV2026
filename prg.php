<?php
// include ("seguridad.php"); 
include ("lib/body_head.php");
include ("lib/body_menu.php");


$id_aplicacion ="prg"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos
xd_update('prg',$nitavu);//guarda la experiencia del usuario
historia($nitavu, "Entro a la aplicacion Explorador Financiero");

if (isset($_GET['m'])){
    if ($_GET['m']==''){
        $IdDelegacionSeleccionada = 0;
        $DelegacionSeleccionada = "CENTRAL";
    } else {
        $IdDelegacionSeleccionada = DelegacionDelMunicipio($_GET['m']);
        $DelegacionSeleccionada = "".DelegacionNombre($IdDelegacionSeleccionada);
        historia($nitavu, "Utilizando Explorador Financiero en ".$DelegacionSeleccionada);
    }

} else  {
    $IdDelegacionSeleccionada = 0;
    $DelegacionSeleccionada = "*CENTRAL";
}
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    // echo "Delegacion Seleccionada: ".$IdDelegacionSeleccionada." - ".$DelegacionSeleccionada;
    if ( isset($_GET['IdPrg']) and isset($_GET['CnT']) and isset( $_GET['AllDel'])  ){   
        $IdPrograma = $_GET['IdPrg'];
        if ( $_GET['AllDel'] == 1 ){ //consultamos a las delegaciones --------------
            echo "<section id='InfoDelegaciones' style='width:97%;' >";   
            echo "<div id='prgInfoDelegaciones".$IdPrograma."'  class='Modulo' style='background-color:#FFF4E6;' >";
            


                if (isset($_GET['IdDelegacion'])){
                    $IdDelegacion = DelegacionDelMunicipio($_GET['IdDelegacion']);
                    $sql="select * from cat_delegaciones WHERE dpto_id <> '' AND id='".$IdDelegacion."'order by nombre";
                    echo "<b>".DelegacionNombre($IdDelegacion)."</b> : ";
                } else {
                    $sql="select * from cat_delegaciones WHERE dpto_id <> '' order by nombre";
                }
                
                $r= $conexion -> query($sql);
                echo ProgramaInfo($IdPrograma);

                echo '
                    <table id="TablaInfoDelegaciones" name="InfoDelegaciones" class="tabla">
                    <tbody>
                        <tr><th>Delegacion</th><th class="pc">Contratosf<br> con Saldo</th><th class="pc">Contratos<br> Sin Saldo</th><th>Saldo</th><th>Morat</th><th class="pc" style="cursor:pointer;"
                        title="En ocaciones pueda haber contratos en otras delegaciones, como proceso de cobro foraneo de las delegaciones"
                        >Foraneos</th></tr>
                    </tbody>
                    </table>
                    <label>* información obtenida desde las delegaciones...</label>
                    ';

                    echo '
                        <script>
                        (function($) {  
                            $.get = function(key)   {  
                                key = key.replace(/[\[]/, "\\[");  
                                key = key.replace(/[\]]/, "\\]");  
                                var pattern = "[\\?&]" + key + "=([^&#]*)";  
                                var regex = new RegExp(pattern);  
                                var url = unescape(window.location.href);  
                                var results = regex.exec(url);  
                                if (results === null) {  
                                    return null;  
                                } else {  
                                    return results[1];  
                                }  
                            }  
                        })(jQuery); 


                        function ContratosResumenDelegaciones(IdDel0, Delegacion0, Tipo){
                            if (Tipo==1){
                                $("#prgInfoDelegacionesLoader").show();
                                //console.log("Consultando nuevamente..." + Delegacion0);
                            }

                            var TipoContrato2 = $.get("CnT");
                            //console.log("TipoContratoresumen "+TipoContrato2);
                            
                            //console.log("Cargando " + IdDel0 + "...");
                            $.ajax({
                                url: "prg_dat2del.php",
                            type: "get",        
                            data: {IdPrg: '.$IdPrograma.', ConSaldo: TipoContrato2, IdDel:IdDel0, Delegacion:Delegacion0, ReIntento:Tipo},
                            success: function(data){
                                //$("#prgInfoDelegaciones").html(data+"\n");            
                                
                                if (Tipo==1){
                                    $("#RowID" + Delegacion0 + "").html(data);

                                    
                                    $("#prgInfoDelegacionesLoader").hide();
                                    //console.log("Consultando nuevamente...>" + Delegacion0);
                                } else {
                                    $("#TablaInfoDelegaciones tr:last").after(data);
                                }
                                //console.log(data);

                            }
                            });
                        }

                        //Grafica
                        function Grafica(Dato1, Dato2){
                            var animals = ["("+Dato1+")","("+Dato2+")"];                            
                            var data = {                        
                                series: [Dato1,Dato2]                        
                            };
                            
                            var sum = function(a, b) { return a + b };                            

                            new Chartist.Pie("#GraficaDelegaciones", data, {
                            labelInterpolationFnc: function(value, idx) {
                                var percentage = Math.round(value / data.series.reduce(sum) * 100) + "%";
                                return animals[idx] + " " + percentage;
                            }
                            });
                        }

                        </script>

                        ';
                echo "<div id='prgInfoDelegacionesLoader' style='width:100%; font-size:8pt; color:gray;'>Leyendo bases de datos desde las delegaciones <img src='img/loader_bar.gif' style='20px'></div>";
                
                while($f = $r -> fetch_array()) {
                    $IdDelegacion = $f['id'];
                    echo "<script>ContratosResumenDelegaciones(".$IdDelegacion.", '".$f['nombre']."','');</script>";
                }
                $str_loader = "<img src='img/loader.gif' style='width:30px;'><br> <label style='font-size:7pt; color:gray;'>Leyendo BD desde Delegaciones...";
                echo "</div>";

                echo "<div id='prgInfoDelegacionesTotales".$IdPrograma."'  class='Modulo' style='padding-right:15px; background-color:#EEEEEE;' >";
                
                    echo "<div id='masinfo' style='padding-right: 20px; background-color:white; width:40%;display:inline-block; padding:5px; margin:5px; vertical-align:top; border-radius:5px;'>";
                        echo "<div id='GraficaDelegaciones' style='width:100%; height:200px; display:inline-block;'></div>";
                        echo "<table class='tabla' id='Totales' name='Totales'>";                
                        echo "<tr><td>Contratos sin Saldo</td><td><input type='hidden' readonly id='TotalNotSaldoProg".$IdPrograma."' value=0> <label id='LabelTotalNotSaldoProg".$IdPrograma."'></label></td></tr>";
                        echo "<tr><td>Contratos con Saldo</td><td><input type='hidden' readonly id='TotalNSaldoProg".$IdPrograma."' value=0> <label id='LabelTotalNSaldoProg".$IdPrograma."'></label></td></tr>";
                        echo "<tr><td>Saldo</td><td><input type='hidden' readonly id='TotalSaldoProg".$IdPrograma."' value=0> <label id='LabelTotalSaldoProg".$IdPrograma."'></label></td></tr>";
                        echo "<tr><td>Moratorio</td><td><input type='hidden' readonly id='TotalMoraSaldoProg".$IdPrograma."' value=0> <label id='LabelTotalMoraSaldoProg".$IdPrograma."'></label></td></tr>";
                        echo "<tr style='display:none;'><td>TOTAL</td><td><input type='hidden' readonly id='TotalProg".$IdPrograma."' value=0> <label id='LabelTotalProg".$IdPrograma."'></label></td></tr>";

                        echo   "</table>";
                        echo "<label>* información obtenida desde las delegaciones...</label>";

                    echo "</div>";

                
                

                //     echo "<div id='masinfo2' style='background-color:#f7f5e2; width:40%;display:inline-block; padding:5px; margin:5px;  vertical-align:top; border-radius:5px;'>
                //             <div id='prg".$IdPrograma."' style='background-color:white;'>";
                
                //             $str_loader = "<img src='img/loader5.gif' style='width:50px;'><br> <label style='font-size:7pt; color:orange;'>Leyendo Base de Datos Estatal...</label>";
                //             echo '
                //             <script>
                //             $("#prg'.$IdPrograma.'").html("'.$str_loader.'");
                //             $.ajax({
                //                 url: "prg_dat1.php",
                //             type: "get",        
                //             data: {IdPrg: '.$IdPrograma.', info:1, IdDelegacion:'.$IdDelegacion.'},
                //             success: function(data){
                //                 $("#prg'.$IdPrograma.'").html(data+"\n");            
                //             }
                //             });
                //             </script>
                //             ';
                //         echo "</div>
                //          <label>* información obtenida desde la BD Estatal...</label>
                // </div>

                // </div>";
                
               
                echo "<script>";
                echo "
                    function ActualizarTotal(NSinSaldo, NConSaldo, Saldo, Moratorio){
                        //console.log('Actualizando...');
                        
                        //Valores actuales
                        TotalNotSaldo = parseFloat($('#TotalNotSaldoProg".$IdPrograma."').val());
                        TotalNSaldo = parseFloat($('#TotalNSaldoProg".$IdPrograma."').val());
                        TotalSaldo = parseFloat($('#TotalSaldoProg".$IdPrograma."').val());
                        TotalMoratorios = parseFloat($('#TotalMoraSaldoProg".$IdPrograma."').val());
                        GranTotal = parseFloat($('#TotalProg".$IdPrograma."').val());

                        console.log('VALORES ACTUALES: ');
                        console.log('TotalNotSaldo = ' + TotalNotSaldo);
                        console.log('TotalNSaldo = ' + TotalNSaldo);
                        console.log('TotalSaldo = ' + TotalSaldo);
                        console.log('TotalMoratorios = ' + TotalMoratorios);
                        console.log('GranTotal = ' + GranTotal);
                        
                        
                        

                        //Actualizamos los valores
                        TotalNotSaldo = TotalNotSaldo + NSinSaldo;
                        TotalNSaldo = TotalNSaldo + NConSaldo;
                        TotalSaldo = TotalSaldo + Saldo;
                        TotalMoratorios = TotalMoratorios + Moratorio;
                        GranTotal = GranTotal + TotalSaldo + TotalMoratorios;

                        console.log('VALORES Actualizados: ');
                        console.log('TotalNotSaldo = ' + TotalNotSaldo);
                        console.log('TotalNSaldo = ' + TotalNSaldo);
                        console.log('TotalSaldo = ' + TotalSaldo);
                        console.log('TotalMoratorios = ' + TotalMoratorios);
                        console.log('GranTotal = ' + GranTotal);
                        
                        console.log('----------------------------');

                        //Actualizamos el data
                        $('#TotalNotSaldoProg".$IdPrograma."').val(TotalNotSaldo);
                        $('#TotalNSaldoProg".$IdPrograma."').val(TotalNSaldo);
                        $('#TotalSaldoProg".$IdPrograma."').val(TotalSaldo);
                        $('#TotalMoraSaldoProg".$IdPrograma."').val(TotalMoratorios);
                        $('#TotalProg".$IdPrograma."').val(GranTotal);


                        //actualizamos los Label
                        
                        $('#LabelTotalNotSaldoProg".$IdPrograma."').html('<b title=' + TotalNotSaldo + '>'+$.number(TotalNotSaldo,0) + '</b>');
                        $('#LabelTotalNSaldoProg".$IdPrograma."').html(' '+$.number(TotalNSaldo,0));
                        $('#LabelTotalSaldoProg".$IdPrograma."').html('<b title=' + TotalSaldo +'>$ '+$.number(TotalSaldo,2) + '</b>');
                        $('#LabelTotalMoraSaldoProg".$IdPrograma."').html('<b title=' + TotalMoratorios +'>$ '+$.number(TotalMoratorios,2) + '</b>' );
                        $('#LabelTotalProg".$IdPrograma."').html('<b title=' + GranTotal + '>$ '+$.number(GranTotal,2) + '</b>');

                        Grafica(TotalNotSaldo, TotalNSaldo);

                    }

                  
                ";
                echo "</script>";


        echo "</section>";

        
        } else { // consultamos de la estatal ---------------------
        $IdPrograma = $_GET['IdPrg'];
        //INFORMACION DE CONTRATOS DEL PROGRAMA DESDE LA BD ESTATAL
        // CnT=0 -> Contratos Saldados | CnT=1 -> Contratos con Saldo
        
            echo "";
            echo "";
            echo "<div class='Modulo'>";
            echo ProgramaInfo($IdPrograma);

            echo "<div id='prg".$IdPrograma."' style=''></div>";
            $str_loader = "<img src='img/loader5.gif' style='width:50px;'><br> <label style='font-size:7pt; color:orange;'>Leyendo Base de Datos Estatal...</label>";
            echo '
            <script>
            $("#prg'.$IdPrograma.'").html("'.$str_loader.'");
            $.ajax({
                url: "prg_dat1.php",
            type: "get",        
            data: {IdPrg: '.$IdPrograma.', info:1},
            success: function(data){
                $("#prg'.$IdPrograma.'").html(data+"\n");            
            }
            });
            </script>
            ';
            echo "</div>";

            echo "<div class='Modulo' >";   
            echo "<div id='prgInfo".$IdPrograma."' ></div>";
            $str_loader = "<img src='img/loader5.gif' style='width:50px;'><br> <label style='font-size:7pt; color:orange;'>Leyendo Base de Datos Estatal...</label>";
            echo '
            <script>
            (function($) {  
                $.get = function(key)   {  
                    key = key.replace(/[\[]/, "\\[");  
                    key = key.replace(/[\]]/, "\\]");  
                    var pattern = "[\\?&]" + key + "=([^&#]*)";  
                    var regex = new RegExp(pattern);  
                    var url = unescape(window.location.href);  
                    var results = regex.exec(url);  
                    if (results === null) {  
                        return null;  
                    } else {  
                        return results[1];  
                    }  
                }  
            })(jQuery); 



            var TipoContrato2 = $.get("CnT");
            //console.log("TipoContratoresumen "+TipoContrato2);
            $("#prgInfo'.$IdPrograma.'").html("'.$str_loader.'");
            $.ajax({
                url: "prg_dat2.php",
            type: "get",        
            data: {IdPrg: '.$IdPrograma.', ConSaldo: TipoContrato2},
            success: function(data){
                $("#prgInfo'.$IdPrograma.'").html(data+"\n");            
            }
            });
            </script>
            ';





            echo "</div>";


            echo "<div class='Modulo' style='width:95%;'>";  
            echo "<input type='hidden' name='ContratosRow' id='ContratosRow' value=0>";
            echo "<div id='prgCnT0".$IdPrograma."'></div>";
            $str_loader = "<img src='img/loader5.gif' style='width:50px;'><br> <label style='font-size:7pt; color:orange;'>Leyendo Base de Datos Estatal...</label>";
            echo '
            <script>
            (function($) {  
                $.get = function(key)   {  
                    key = key.replace(/[\[]/, "\\[");  
                    key = key.replace(/[\]]/, "\\]");  
                    var pattern = "[\\?&]" + key + "=([^&#]*)";  
                    var regex = new RegExp(pattern);  
                    var url = unescape(window.location.href);  
                    var results = regex.exec(url);  
                    if (results === null) {  
                        return null;  
                    } else {  
                        return results[1];  
                    }  
                }  
            })(jQuery); 


            function Contratos(){
                var ConSaldo = $.get("CnT");
                RegPorPagina = 10
                RowHasta = 0
                RowDesde = parseInt($("#ContratosRow").val())
                if (RowDesde == 0 ) {
                    RowHasta = RegPorPagina
                } else {
                    RowHasta = RowDesde + RegPorPagina
                }
                
                
                $("#prgCnT0'.$IdPrograma.'").html("'.$str_loader.'");
                $.ajax({
                    url: "prg_dat3.php",
                type: "get",        
                data: {IdPrg: '.$IdPrograma.', Desde:RowDesde, Hasta:RowHasta, ConSaldo},
                success: function(data){                    
                    RowDesde = $("#ContratosRow").val(RowHasta);
                    $("#prgCnT0'.$IdPrograma.'").html(data+"\n");            
                }
                });
            }

            
            var TipoContrato = $.get("CnT");
            //console.log("Tipo de contrato: " +TipoContrato);
            Contratos(TipoContrato);


            </script>';

            echo "<button onclick='Contratos();'>Siguiente</button>";
            echo "</div>";
            

        
        }

    }
    else {
        echo "<section id='prgs'>";
        
        echo "<table border=0 width=100%><tr><td valign=top align=center>";
        //grafica de programas
        if (isset($_GET['m'])){
            $str_loader = "<img src='img/loader110.gif' style='width:50px;'><br> <label style='font-size:7pt; color:gray;'>Leyendo Base de Datos desde la Delegacion...</label>";
        } else {
            $str_loader = "<img src='img/loader5.gif' style='width:50px;'><br> <label style='font-size:7pt; color:orange;'>Leyendo Base de Datos Estatal...</label>";
        }
        


        echo "<div id='GraficaPrgR' style='width:45%; height:600px; display:inline-block; margin: 4px;'></div>";
        echo '
        <script>
        $("#GraficaPrgR").html("'.$str_loader.'");
        $.ajax({
            url: "prg_dat4.php",
        type: "get",        
        data: {IdPrg: "", IdDelegacion:'.$IdDelegacionSeleccionada.',Delegacion:"'.$DelegacionSeleccionada.'"},
        success: function(data){
            $("#GraficaPrgR").html(data+"\n");            
        }
        });
        </script>
        ';
        

        echo "<div id='GraficaPrgR2' style='width:45%; height:600px; display:inline-block; margin: 4px; '></div>";
        echo '
        <script>
        $("#GraficaPrgR2").html("'.$str_loader.'");
        $.ajax({
            url: "prg_dat5.php",
        type: "get",        
        data: {IdPrg: "", IdDelegacion:'.$IdDelegacionSeleccionada.',Delegacion:"'.$DelegacionSeleccionada.'"},
        success: function(data){
            $("#GraficaPrgR2").html(data+"\n");            
        }
        });
        </script>
        ';
        if ($_GET['m'] <> ''){
        echo "<div class='Modulo' id='ContratosResumenGrafica' style='width:80%; heght:800px;'></div>";
        
        echo "<div class='Modulo' style='width:80%;' id='ContratosResumen' style='background-color:antiquewhite;'>";
        $str_loader = "<img src='img/loader110.gif' style='width:50px;'><br> <label style='font-size:7pt; color:orange;'>Leyendo Base de Datos desde las delegaciones...</label>";
        echo '
        <script>
        $("#ContratosResumen").html("'.$str_loader.'");
        $.ajax({
            url: "contratos_dat3.php",
        type: "get",        
        data: {IdPrograma: 0.0, IdDelegacion:'.$IdDelegacionSeleccionada.', Delegacion:"'.$DelegacionSeleccionada.'"},
        success: function(data){                                
            $("#ContratosResumen").html(data+"\n");            
        }
        });
        </script>
        ';
        echo "</div>";
        } else {
           
            echo "<div class='Modulo' id='ContratosResumenGrafica' style='width:80%;background-color:#ecf4ec;' ></div>";
            $str_loader = "<img src='img/loader110.gif' style='width:50px;'><br> <label style='font-size:7pt; color:gray;'>Leyendo Base de Datos desde las delegaciones...</label>";
            echo '
            <script>
            $("#ContratosResumenGrafica").html("'.$str_loader.'");
            $.ajax({
                url: "contratos_dat3.php",
            type: "get",        
            data: {IdPrograma: 0.0, IdDelegacion:0, Delegacion:0},
            success: function(data){                                
                $("#ContratosResumenGrafica").html(data+"\n");            
            }
            });
            </script>
            ';


            // echo "<div class='Modulo' id='CarteraVencidaPorProgramas' style='width:80%;background-color:#f2f2f2;' >
            // <h3>Saldo Moratorio en Todo en Estado</h3>
           
            // <div id='CarteraVencidaDatos' style='width: 700px; overflow:auto;'></div>

            // <button class='Mbtn btn-azulTam' onclick='SolicitarCarteraDelegaciones();'>Calcular</button>
            // <label> * Consulta desde las delegaciones, esta operación puede demorar.</label>
            // </div>";
            // $str_loader = "<img src='img/loader110.gif' style='width:50px;'><br> <label style='font-size:7pt; color:gray;'>Leyendo Base de Datos desde las delegaciones...</label>";
            // echo '
            // <script>

            // function SolicitarCarteraDelegaciones(){
            //     $("#CarteraVencidaDatos").html("'.$str_loader.'");
            //     $.ajax({
            //         url: "contratos_dat4.php",
            //     type: "get",        
            //     data: {},
            //     success: function(data){                                
            //         $("#CarteraVencidaDatos").html(data+"\n");            
            //     }
            //     });
            // }
            // </script>
            // ';
            
        }




        


        
        // echo "<div id='ProgramasInteractivo' style='width:100%; background-color:#EEE; text-align:center;'
        //      >";
        // if (isset($_GET['p'])){
        //     $npage = $_GET['p'] + 1;
        //     $previos = $_GET['p'] * 3;
        //     $proximos = 3;

        //     $sql="select * from cat_programa order by ejercicio DESC limit ".$previos.",".$proximos;
        // } else {
        //     if (isset($_GET['all'])){
        //         $sql="select * from cat_programa order by ejercicio DESC";
        //     } else {
        //         $sql="select * from cat_programa order by ejercicio DESC limit 3";
        //     }
        // }


        // $r= $conexion -> query($sql);
        // while($f = $r -> fetch_array()) {

        //     switch ($f['IdTipoPrograma']) {
        //         case 0:
        //             echo "<article class='prgTipo0'>";
        //             break;
        //         case 1:
        //             echo "<article class='prgTipo1'>";
        //             break;
        //         case 2:
        //             echo "<article class='prgTipo2'>";
        //             break;
        //         case 3:
        //             echo "<article class='prgTipo3'>";
        //             break;
        //         case 4:
        //             echo "<article class='prgTipo4'>";
        //             break;                
        //         default:
        //             echo "<article >";
        //     }
            
            
        //     echo "<table  width=100%><tr><td>";
        //     echo "<b style='font-size:9pt; font-family:Light'>".$f['Programa']."</b></td>";

        //     echo "<td width=10px valign=top align=right>"; 
        //     echo "<a  target=_blank title='Obtener información detallada; desde las delegaciones...' href='?IdPrg=".$f['IdPrograma']."&CnT=0&AllDel=1'><img src='icon/mas.png' style='width:20px;'></a>";
        //     echo "</td></tr>";
        //     echo "<tr><td>";
            
        //     echo "<label style='font-size:7pt;'>".$f['Descripcion']."</label>";
        //     echo "<div id='prg".$f['IdPrograma']."'></div>";
        //     $str_loader = "<img src='img/loader5.gif' style='width:50px;'><br> <label style='font-size:7pt; color:orange;'>Leyendo Base de Datos Estatal...</label>";
        //     echo '
        //     <script>
        //     $("#prg'.$f['IdPrograma'].'").html("'.$str_loader.'");
        //     $.ajax({
        //         url: "prg_dat1.php",
        //     type: "get",        
        //     data: {IdPrg: '.$f['IdPrograma'].'},
        //     success: function(data){
        //         $("#prg'.$f['IdPrograma'].'").html(data+"\n");            
        //     }
        //     });
        //     </script>
        //     ';
            
        //     echo "</td><td></td></tr></table>";

        //     echo "</article>";
        // }


        // echo "<article class='Mbtn btn-tercero' style='width:100px;'>";
        // if (isset($_GET['p'])){
        //     $npage = $_GET['p'];
        //     $npage = $npage + 1;
        // } else {
        //     $npage = 2;
        // }
        //     echo "<table width=100% height=100%><tr><td align=center valign=midle><a href='?p=".$npage."&m=".$_GET['m']."' style='display:block;'>
        //    <b style='font-size:60pt; color:white; font-family:ExtraBold; font-weight:bold;'> > </b><br>
        //     <label>Siguiente</label></a></td></tr></table>";


        

        // echo "</article>";

        // echo "</div>";

        
        echo "<div id='BuscarBeneficiario' style='
        background-color: #f0f0f0;
        padding: 10px;
        border-radius: 5px;
        margin-left: 5px;
        border: 1px solid white;
        margin-top: 23px;
        '>";
        echo "<h4>Buscar coincidencias de acuerdo al nombre:</h4>";
        echo '<div id="beta_buscar">';		
        echo "<form action='beneficiarios.php' method='GET'>";
		echo '<table broder="1" width="100%"><tr>';
            echo '<td>';                        
            echo '<input style="border:  none; font-size:16pt; background: none;" required="required" type="text" name="search" id="search" value="" placeholder="Nombre del beneficiario"  />';
            if ($DelegacionSeleccionada == 'CENTRAL'){
                // echo "<input type='hidden' name='del' id='del' value='0'>";
            } else {
                echo "<input type='hidden' name='del' id='del' value='".$IdDelegacionSeleccionada."'>";
            }
            
            echo "</td>";
			echo '<td align="right" width="15px">                    
			<button id="beta_buscar_boton" >
			<img  src="icon/buscar.png"></button>
			</td>';
        echo '</tr></table>';
        echo "</form>";
        echo ' </div>';
        // $DelegacionSeleccionada = DelegacionNombre($IdDelegacionSeleccionada);
        if ($DelegacionSeleccionada == ''){
            echo "<label>* Buscar en todo todas las delegaciones; (este proceso puede tardar en relación a la disponibilidad de acceso a cada delegacion). <br> Puede seleccionar un municpio y buscar a partir de alli.</label>";
        }else {
            echo "<label>* Buscar en ".$DelegacionSeleccionada."</label>";
        }
        echo '</div>';
        

        echo "</td><td class='pc' valign=top align=center style='width:262px;'>";
        
        insertar_mapa();

        echo "<div id='ProgramasTodos' style='width:100%;' >";
        $sql="select * from cat_programa order by ejercicio DESC limit 5";
        $r2= $conexion -> query($sql);
        echo "<h3>Programas: </h3>";
        echo "<table class='tabla' width=100% >";
        while($f2 = $r2 -> fetch_array()) {
            echo "<tr>";
            echo "<td title='Haga clic aqui para Ver mas información desde las delegaciones...'>";
            
            if ($_GET['m'] == ''){
                echo "
                <a style='display:block; color:black; font-size:9pt;' href='?IdPrg=".$f2['IdPrograma']."&CnT=0&AllDel=1'>
                <b>".ucfirst(strtolower($f2['Programa']))."</b></a>";
    
            } else {
                echo "
                <a style='display:block; color:black; font-size:9pt;' href='?IdPrg=".$f2['IdPrograma']."&CnT=0&AllDel=1&IdDelegacion=".$_GET['m']."'>
                <b>".ucfirst(strtolower($f2['Programa']))."</b></a>";

            }
            

            
            echo "</td>";
            echo "</tr>";

        }
        echo "</table>";
        
        echo "<a href='#ProgramasTodos2' rel='MyModal:open' style='font-size:10pt; padding:4px; display:block; color:black;' class='Mbtn btn-tercero'>Ver todos ...</a>";

        echo "</div>";

        
        echo "<div id='ProgramasTodos2' class='MyModal'>";
        $sql="select * from cat_programa order by ejercicio DESC";
        $r2= $conexion -> query($sql);
        echo "<table class='tabla' width=90%>";
        while($f2 = $r2 -> fetch_array()) {
            echo "<tr>";
            echo "<td style='background-color:#0581E4; color:white;' valign=middle align=center><b style='font-size:14pt;font-weight:bold;'>".$f2['Ejercicio']."</b></td>";
            echo "<td title='Haga clic aqui para Ver mas información desde las delegaciones...'>";
            if ($_GET['m'] == ''){
                echo "
                <a style='display:block; color:black; font-size:9pt;' href='?IdPrg=".$f2['IdPrograma']."&CnT=0&AllDel=1'>
                <b>".ucfirst(strtolower($f2['Programa']))."</b></a>";
                echo "<label>".strtolower($f2['Descripcion'])."</label>";
    
            } else {
                echo "
                <a style='display:block; color:black; font-size:9pt;' href='?IdPrg=".$f2['IdPrograma']."&CnT=0&AllDel=1&IdDelegacion=".$_GET['m']."'>
                <b>".ucfirst(strtolower($f2['Programa']))."</b></a>";
                echo "<label>".strtolower($f2['Descripcion'])."</label>";

            }
            
            echo "</td>";
            echo "</tr>";

        }
        echo "</table>";

        echo "</div>";
        echo "</div>";

        
        echo "</td></tr></table>";

        
        echo "</section>";


    }

    


} else{mensaje("ERROR: no tiene acceso a esta aplicación","");}









include ("./lib/body_footer.php");
?>