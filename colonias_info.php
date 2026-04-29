<?php
// include ("seguridad.php"); 
include ("lib/body_head.php");
include ("lib/body_menu.php");


$id_aplicacion ="ap89"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    

    //Parametros
    if ( isset($_GET['IdDelegacion']) and isset($_GET['Col']) ){

        $IdDelegacion = $_GET['IdDelegacion'];
        $Col = $_GET['Col']; 

        
        if (isset($_GET['sel'])){$Seleccion = $_GET['sel'];} else {$Seleccion = "";}
        if (isset($_GET['IdPrograma'])){$IdPrograma = $_GET['IdPrograma'];} else {$IdPrograma = "";}

        if (ValidaVAR($Col)==TRUE){$Col = LimpiarVAR($Col);} else {$Col = "";}
        $DelegacionSeleccionada = "".DelegacionNombre($IdDelegacion);

        echo "<h3>Informativo sobre la <b style='color:#B0CC26;'>Colonia ".$Col."</b> de la delegacion ".DelegacionNombre($IdDelegacion)."</h4>";
        // echo "<table width=100%><tr><td valign=top align=center>";
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
            RegPorPagina = 20
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
                    url: "colonias_info_dat1.php",
                type: "get",        
                data: {Desde:RowDesde, Hasta:RowHasta, IdDelegacion:'.$IdDelegacion.',Col:"'.$Col.'", m:'.$_GET['m'].', sel:"'.$Seleccion.'", IdPrograma:"'.$IdPrograma.'"';

                
                echo '},
                success: function(data){                    
                    RowDesde = $("#ContratosRow").val(RowHasta);
                    $("#Contratos").html(data+"\n");            
                }
                });



            }

            
            
            Contratos(1);


            </script>';
            
            
            
   



        // $DelegacionSeleccionada = "".DelegacionNombre($IdDelegacion);
        // echo "<div id='BuscarBeneficiario' style='
        // background-color: #f0f0f0;
        // padding: 10px;
        // border-radius: 5px;
        // margin-left: 5px;
        // border: 1px solid white;
        // margin-top: 23px;
        // '>";
        // echo "<h4>Buscar coincidencias de acuerdo al nombre: (".$DelegacionSeleccionada.")</h4>";
        // echo '<div id="beta_buscar">';		
        // echo "<form action='beneficiarios.php' method='GET'>";
		// echo '<table broder="1" width="100%"><tr>';
        //     echo '<td>';                        
        //     echo '<input style="border:  none; font-size:16pt; background: none;" required="required" type="text" name="search" id="search" value="" placeholder="Nombre del beneficiario"  />';
        //     if ($DelegacionSeleccionada == 'CENTRAL'){
        //         // echo "<input type='hidden' name='del' id='del' value='0'>";
        //     } else {
        //         echo "<input type='hidden' name='del' id='del' value='".$IdDelegacion."'>";
        //     }
            
        //     echo "</td>";
		// 	echo '<td align="right" width="15px">                    
		// 	<button id="beta_buscar_boton" >
		// 	<img  src="icon/buscar.png"></button>
		// 	</td>';
        // echo '</tr></table>';
        // echo "</form>";
        // echo ' </div>';


    } else {
        echo "ERROR: faltan parametros!";
    }

echo "</td><td class='pc' valign=top align=center>";
// echo "<div style='
// width:200px;
// height:80%;
// overflow: auto;
// background-color: bisque;
// border-radius: 5px;
// text-transform: uppercase;
// padding-right:15px;

// '>";
// echo "<h4 style='text-align: center;
// padding-top: 0px;
// margin-top: 12px;
// width: 100%;
// font-size: 10pt;
// color: orange;'>Programas:</h4>";
// $sql = 'select 
// IdPrograma,
// Programa,
// Ejercicio
// from cat_programa
// order by Ejercicio DESC';
// $r= $conexion -> query($sql);
// echo "<table class='tabla'>";
// while($f = $r -> fetch_array()) {
//     echo "<tr><td>";
//     echo "<a title='".$f['Ejercicio']."' style='
//     text-transform: uppercase;
//     color:gray;
//     ' href='?IdPrograma=".$f['IdPrograma']."&IdDelegacion=".$_GET['IdDelegacion']."&Saldo=1&Moratorios=0&Fora=0'>".$f['Programa']."</a>";
//     echo "</tr></td>";
// }
// echo "</table>";
// echo "</div>";
echo "</td></tr></table>";

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
// $DelegacionSeleccionada = DelegacionNombre($IdDelegacionSeleccionada);
if ($DelegacionSeleccionada == ''){
    echo "<label>* Buscar en todo todas las delegaciones; (este proceso puede tardar en relación a la disponibilidad de acceso a cada delegacion). <br> Puede seleccionar un municpio y buscar a partir de alli.</label>";
}else {
    echo "<label>* Buscar en ".$DelegacionSeleccionada."</label>";
}
echo '</div>';

 //]Prograamas de Colonias
 $tbProgramas = "<div id='Programas'><h4>Programas detectados esta Colonia (".$Col.")</h4><lu>";        
 $MSSQL_Programas = "
 SELECT DISTINCT
     IdPrograma, Programa
 FROM
     busqueda_vivienda_informacioncontratos 
 WHERE
     Colonia = '".$Col."' 	OR DomicilioColonia = '".$Col."'
     and IdDelegacion = ".$IdDelegacion."
     ORDER BY
     IdPrograma DESC
 ";
//  echo $MSSQL_Programas;
 $ConsultaProgramas = DatosViviendaLarge($IdDelegacion, $nitavu, "Colonias Programas", $MSSQL_Programas);
 // var_dump($ConsultaProgramas);
 $array3 = json_decode($ConsultaProgramas, true);
 // var_dump($array2);
 $error = 0;
 $URLActual = "colonias_info.php?IdDelegacion=".$_GET['IdDelegacion']."&Col=".$_GET['Col']."&m=".$_GET['m'];
 if(is_array($array3)){            
     foreach ($array3 as $vP) {
         if (isset($vP['r'])){// si hay un error
             echo "*Error: [Estadistica Programas] ".$vP['r'];
             $error = $value['r'];
         } else {//si no hay errores escribimos
            // $tbProgramas = $tbProgramas."<li>"."<a target=_blank title='haz clic aqui para ver informacion sobre este programa'  href='prg.php?IdPrg=".$vP['IdPrograma']."&CnT=0&AllDel=1&IdDelegacion=".$_GET['m']."'>".$vP['Programa']."</a></li>";
            $tbProgramas = $tbProgramas."<li>"."<a title='haz clic aqui para ver informacion sobre este programa'  href='".$URLActual."&sel=&IdPrograma=".$vP['IdPrograma']."'>".$vP['Programa']."</a></li>";
         }
     }
 } else {echo "ERROR: [Programas] ".$MSSQL_Programas.$ConsultaProgramas;}
 $tbProgramas = $tbProgramas."</lu></div>";
 echo $tbProgramas;


} else{mensaje("ERROR: no tiene acceso a esta aplicación","");}









include ("./lib/body_footer.php");
?>