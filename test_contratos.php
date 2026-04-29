<?php
// include ("lib/seguridad.php"); 
include ("lib/body_head.php");
include ("lib/body_menu.php");


$id_aplicacion ="fin"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion)."</div>";
    echo "<table width=100%><tr><td valign=top align=center>";
    //Parametros
    if ( isset($_GET['IdDelegacion']) and isset($_GET['IdPrograma']) and isset($_GET['Saldo']) and isset($_GET['Moratorios'])  and isset($_GET['Fora'])){
        $IdDelegacion = $_GET['IdDelegacion'];
        $IdPrograma = $_GET['IdPrograma'];
      
        $Saldo = $_GET['Saldo'];
        $Moratorios = $_GET['Moratorios'];
        $Foraneos = $_GET['Fora'];


        


        echo "<input type='hidden' id='ContratosRow' value='0'>";
        echo "<div id='Contratos'></div>";
        $str_loader = "<img src='img/loader110.gif' style='width:50px;'><br> <label style='font-size:7pt; color:orange;'>Leyendo Base de Datos desde las Delegaciones...</label>";
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


            function Contratos(av){                
            RegPorPagina = 10
            RowHasta = 0
            if (av == 1) { //right
                console.log("Right")
                RowDesde = parseInt($("#ContratosRow").val())
                if (RowDesde == 0 ) {
                    RowHasta = RegPorPagina
                } else {
                    RowHasta = RowDesde + RegPorPagina
                }
            } else {//==left

                if (av == 2) {
                    console.log("Left")
                    RowDesde = parseInt($("#ContratosRow").val())
                    if (RowDesde == 0 ) {
                        RowHasta = RegPorPagina
                    } else {

                        RowHasta = RowDesde - RegPorPagina 
                        RowDesde = RowDesde - RegPorPagina * 2

                    }
                    if (RowDesde <= 0 ){
                        $("#btnleft").hide()
                    } else {
                        $("#btnleft").show()
                    }
                } else {
                    console.log("todo")
                    RowDesde = 0;
                    RowHasta = 0;                    
                        $("#btnleft").hide()                    
                        $("#btnleft").hide()
                    

                }

                 
            }
                console.log("Avance= " + av +", Desde= "+RowDesde + ", Hasta="+RowHasta);

                $("#Contratos").html("'.$str_loader.'");
                $.ajax({
                    url: "contratos_dat.php",
                type: "get",        
                data: {IdPrograma: '.$IdPrograma.', Desde:RowDesde, Hasta:RowHasta, Saldo:'.$Saldo.', IdDelegacion:'.$IdDelegacion.',Moratorios:'.$Moratorios.', Fora:'.$Foraneos;
                if (isset($_GET['Col'])) {
                    echo ',Col:"'.$_GET['Col'].'"';
                } else {

                }
                
                echo '},
                success: function(data){                    
                    RowDesde = $("#ContratosRow").val(RowHasta);
                    $("#Contratos").html(data+"\n");            
                }
                });



            }

            
            
            Contratos(1);


            </script>';
            
            
            echo "<button title='Haga clic aqui para mostrar todos los contratos sin saldo' style = 'padding: 3px;
            height: 41px;
            vertical-align: top;
            font-weight: bold;
            color: white;
            font-family: ExtraBold;' class='Mbtn btn-tercero' id='btnSinSaldo'><a href='contratos.php?IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Saldo=0&Moratorios=0&Fora=1' title='Haga clic aqui para ver Todos los Contratos Foraneos'>Foraneos</a></button> ";
            echo "<button title='Haga clic aqui para mostrar todos los contratos sin saldo' style = 'padding: 3px;
            height: 41px;
            vertical-align: top;
            font-weight: bold;
            color: white;
            font-family: ExtraBold;' class='Mbtn btn-tercero' id='btnSinSaldo'><a href='contratos.php?IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Saldo=0&Moratorios=0&Fora=0' title='Haga clic aqui para ver Todos los Contratos sin Saldo'>Sin Saldo</a></button> ";
            echo "<button title='Haga clic aqui para mostrar todos los contratos sin saldo' style = 'padding: 3px;
            height: 41px;
            vertical-align: top;
            font-weight: bold;
            color: white;
            font-family: ExtraBold;' class='Mbtn btn-tercero' id='btnConSaldo'>";

            // if (isset($_GET['Col'])){
            //     echo "<a href='contratos.php?IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Saldo=1&Moratorios=0&Fora=0&Col=".$_GET['Col']."' title='Haga clic aqui para ver Todos los Contratos Foraneos'>Con Saldo</a></button> ";
            // } else {
                echo "<a href='contratos.php?IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Saldo=1&Moratorios=0&Fora=0' title='Haga clic aqui para ver Todos los Contratos Foraneos'>Con Saldo</a></button> ";
            // }
            
            
            echo "<button title='Haga clic aqui para mostrar todos los contratos' style = 'padding: 3px;' class='Mbtn btn-tercero' id='btntodos' onclick='Contratos(3);'><img src='icon/reportes.png' style='padding: 3px; width:30px; height:30px;'></button> ";
            echo "<button title='Haga clic aqui para regresar 10 contratos atras' style = 'padding: 3px;' class='Mbtn btn-secundario' id='btnleft' onclick='Contratos(2);'><img src='icon/btn_izquierda.png' style='padding: 3px; width:30px; height:30px;'></button> ";
            echo "<button title='Haga clic aqui para avanzar viendo los contratos' style = 'padding: 3px;' class='Mbtn btn-secundario' id='btnright' onclick='Contratos(1);'><img src='icon/btn_derecha.png' style='padding: 3px; width:30px;'height:30px;></button> ";
            echo "<hr style='border: 1px dashed; opacity:0.2;'>";
            echo "</div>";

            echo "<div class='Modulo' id='ContratosResumenGrafica' style='height:200px;'></div>";

            if ($_GET['IdPrograma']<> '0.0'){

            echo "<div class='Modulo' id='ContratosResumen' style='background-color:antiquewhite;'>";
            $str_loader = "<img src='img/loader110.gif' style='width:50px;'><br> <label style='font-size:7pt; color:orange;'>Leyendo Base de Datos desde las delegaciones...</label>";
            echo '
            <script>
            $("#ContratosResumen").html("'.$str_loader.'");
            $.ajax({
                url: "contratos_dat2.php",
            type: "get",        
            data: {IdPrograma: '.$IdPrograma.', IdDelegacion:'.$IdDelegacion.'},
            success: function(data){                                
                $("#ContratosResumen").html(data+"\n");            
            }
            });
            </script>
            ';
            echo "</div>";
        }
    

        //Contruccion 
        echo "<label>* Informacion obtenida desde la delegacion.</label>";



        $DelegacionSeleccionada = "".DelegacionNombre($IdDelegacion);
        echo "<div id='BuscarBeneficiario' style='
        background-color: #f0f0f0;
        padding: 10px;
        border-radius: 5px;
        margin-left: 5px;
        border: 1px solid white;
        margin-top: 23px;
        '>";
        echo "<h4>Buscar coincidencias de acuerdo al nombre: (".$DelegacionSeleccionada.")</h4>";
        echo '<div id="beta_buscar">';		
        echo "<form action='beneficiarios.php' method='GET'>";
		echo '<table broder="1" width="100%"><tr>';
            echo '<td>';                        
            echo '<input style="border:  none; font-size:16pt; background: none;" required="required" type="text" name="search" id="search" value="" placeholder="Nombre del beneficiario"  />';
            if ($DelegacionSeleccionada == 'CENTRAL'){
                // echo "<input type='hidden' name='del' id='del' value='0'>";
            } else {
                echo "<input type='hidden' name='del' id='del' value='".$IdDelegacion."'>";
            }
            
            echo "</td>";
			echo '<td align="right" width="15px">                    
			<button id="beta_buscar_boton" >
			<img  src="icon/buscar.png"></button>
			</td>';
        echo '</tr></table>';
        echo "</form>";
        echo ' </div>';


    } else {
        echo "ERROR: faltan parametros!";
    }
    
echo "</td><td class='pc' valign=top align=center>";
echo "<div style='
width:200px;
height:80%;
overflow: auto;
background-color: bisque;
border-radius: 5px;
text-transform: uppercase;
padding-right:15px;

'>";
echo "<h4 style='text-align: center;
padding-top: 0px;
margin-top: 12px;
width: 100%;
font-size: 10pt;
color: orange;'>Programas:</h4>";
$sql = 'select 
IdPrograma,
Programa,
Ejercicio
from cat_programa
order by Ejercicio DESC';
$r= $conexion -> query($sql);
echo "<table class='tabla'>";
while($f = $r -> fetch_array()) {
    echo "<tr><td>";
    echo "<a title='".$f['Ejercicio']."' style='
    text-transform: uppercase;
    color:gray;
    ' href='?IdPrograma=".$f['IdPrograma']."&IdDelegacion=".$_GET['IdDelegacion']."&Saldo=1&Moratorios=0&Fora=0'>".$f['Programa']."</a>";
    echo "</tr></td>";
}
echo "</table>";
echo "</div>";
echo "</td></tr></table>";




} else{mensaje("ERROR: no tiene acceso a esta aplicación","");}









include ("./lib/body_footer.php");
?>