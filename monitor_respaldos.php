<?php
include("lib/body_head.php");
include("lib/body_menu.php");
$id_aplicacion ="monitor_respaldos"; //Id de la aplicacion a cargar
docdigital_no(FALSE, 1); //ahorra 1 hoja
xd_update('monitor',$nitavu);//guarda la experiencia del usuario
// $nivel = aplicacion_nivel($id_aplicacion, $nitavu);	//Nivel 1 = todos, otro nivel solo los que dependen de el

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    // $MisDepartamentos = misdptos($nitavu);
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
$MiNombre = nombre_corto($nitavu,0). " ".nombre_corto($nitavu,1);
// habla("Hola ".$MiNombre.",  empezare por realizar un check de las bases de datos del instituto; te ire informando de los resultados.");
?>
<?php
    echo "<h1>Check del ".fecha_larga($fecha)." a las ".hora12($hora)."</h1>";
?>
    
<div id="Monitor" style="width:100%; height:100%;">
    <section style="width:100%; height:100%; background-color:whitesmoke;">
            <div id='MonitorDelegaciones'>
            <h4 style='    
            margin-bottom: 0px;
            font-size: 7pt;
            color: #979797;
       '>Servidores MSSQLServer</h4>
            <input id='MonitorDelegacionesResumen' style='display:none;' value="" type="text">
            <input id='MonitorDelegacionesBKResumen' style='display:none;' value="" type="text">
            <!-- <input id='MonitorDelegacionesBK2Resumen' style='display:none;' value="" type="text"> -->
            <?php
                $sql = 'select * from cat_delegaciones where cat_delegaciones.dpto_id <> "" order by nombre ';
                echo "<table class='tabla' border= 0><th>Delegacion</th><th title='Coneccion desde Oficinas Centrales'>Ping</th><th title='Estatus de la Base de Datos'><img  title='informacion de Respaldos desde MSSQL-SERVER' src='icon/mssql.png' style='width:20px;'></th><th title='Generar respaldos'>R</th><th title='Ver Carpeta de Respaldo en Google Drive de la Delegacion '>GD</th>";
                $r= $conexion -> query($sql); while($f = $r -> fetch_array()) {
                   echo "<tr>";
                        echo "<td><b title='Haz clic aqui para cargar solo esta delegacion' style='
                        color: #25638c; font-weight: bold;cursor:pointer;
                        'onclick='ChecarDel(".$f['id'].");'>".$f['nombre']."</b></td>";
                        echo "<td>";
                            $IdDelegacion = $f['id'];

                            echo "<div id='DivBD". $IdDelegacion."'></div>";
                            if (isset($_GET['all'])){
                                echo '<script>';
                                echo '
                                    $("#DivBD'.$IdDelegacion.'").html("<img src=img/loader_bar.gif  style=width:12px> "); ';
                                        
                                echo ' 
                                    
                                    $.ajax({
                                        url: "monitor_dat1.php",
                                        type: "post",                                
                                        data: {IdDel: "'.$IdDelegacion.'", Nitavu: "'.$nitavu.'"},
                                        success: function(data){                                    
                                        $("#DivBD'.$IdDelegacion.'").html(data);                                    
                                        }
                                    });';


                                        
                                echo '                              ';


                                echo "</script>";
                            }
                            
                            if (isset($_GET['IdDel'])){
                                $IdDelegacion = $_GET['IdDel'];
                                echo '<script>';
                                echo '
                                    $("#DivBD'.$IdDelegacion.'").html("<img src=img/loader_bar.gif  style=width:12px> "); ';
                                        
                                echo ' 
                                    
                                    $.ajax({
                                        url: "monitor_dat1.php",
                                        type: "post",                                
                                        data: {IdDel: "'.$IdDelegacion.'", Nitavu: "'.$nitavu.'"},
                                        success: function(data){                                    
                                        $("#DivBD'.$IdDelegacion.'").html(data);                                    
                                        }
                                    });';


                                        
                                echo '                              ';


                                echo "</script>";
                            }

                       
                       
                        echo "</td>";


                        echo "<td>";
                        $IdDelegacion = $f['id'];
                        echo "<div id='DivBK". $IdDelegacion."'></div>";
                       
                    if (isset($_GET['all'])){
                        echo '<script>';
                        echo '
                            $("#DivBK'.$IdDelegacion.'").html("<img src=img/loader_bar.gif  style=width:12px> "); ';
                                
                         echo ' 
                            
                            $.ajax({
                                url: "monitor_dat2.php",
                                type: "post",                                
                                data: {IdDel: "'.$IdDelegacion.'", Nitavu: "'.$nitavu.'"},
                                success: function(data){                                    
                                $("#DivBK'.$IdDelegacion.'").html(data);                                    

                                }
                            });';


                                  
                        echo '                              ';


                        echo "</script>";

                        }

                        if (isset($_GET['IdDel'])){
                            $IdDelegacion = $_GET['IdDel'];
        
                            echo '<script>';
                            echo '
                                $("#DivBK'.$IdDelegacion.'").html("<img src=img/loader_bar.gif  style=width:12px> "); ';
                                    
                             echo ' 
                                
                                $.ajax({
                                    url: "monitor_dat2.php",
                                    type: "post",                                
                                    data: {IdDel: "'.$IdDelegacion.'", Nitavu: "'.$nitavu.'"},
                                    success: function(data){                                    
                                    $("#DivBK'.$IdDelegacion.'").html(data);                                    
    
                                    }
                                });';
    
    
                                      
                            echo '                              ';
    
    
                            echo "</script>";
    
                            }
                   
                    echo "</td>";
                    

                //     echo "<td>";
                //     $IdDelegacion = $f['id'];
                //     echo "<div id='DivBKX". $IdDelegacion."'></div>";
                   
                //     if (isset($_GET['all'])){
                //         echo '<script>';
                //         echo '
                //             $("#DivBKX'.$IdDelegacion.'").html("<img src=img/loader_bar.gif  style=width:12px> "); ';
                                
                //         echo ' 
                            
                //             $.ajax({
                //                 url: "monitor_dat3.php",
                //                 type: "post",                                
                //                 data: {IdDel: "'.$IdDelegacion.'", Nitavu: "'.$nitavu.'"},
                //                 success: function(data){                                    
                //                 $("#DivBKX'.$IdDelegacion.'").html(data);                                    

                //                 }
                //             });';


                                
                //         echo '                              ';


                //         echo "</script>";
                //         }
               
                //         if (isset($_GET['IdDel'])){
                //             $IdDelegacion = $_GET['IdDel'];
                //             echo '<script>';
                //             echo '
                //                 $("#DivBKX'.$IdDelegacion.'").html("<img src=img/loader_bar.gif  style=width:12px> "); ';
                                    
                //             echo ' 
                                
                //                 $.ajax({
                //                     url: "monitor_dat3.php",
                //                     type: "post",                                
                //                     data: {IdDel: "'.$IdDelegacion.'", Nitavu: "'.$nitavu.'"},
                //                     success: function(data){                                    
                //                     $("#DivBKX'.$IdDelegacion.'").html(data);                                    
    
                //                     }
                //                 });';
    
    
                                    
                //             echo '                              ';
    
    
                //             echo "</script>";
                //             }
                   
               
                // echo "</td>";
                            
                echo "<td align=center valign=middle>";
                echo "<div id='DivDBbak".$IdDelegacion."' class='MyModal'></div>";
                if ($f['RutaRespaldo']<>''){                    
                    echo "<a title='Crear Respaldo' rel='MyModal:open' href='#DivDBbak".$IdDelegacion."'  onclick='RespaldarDel(".$IdDelegacion.");' class='' style='cursor:pointer; padding:2px;'><img src='icon/bak.png' style='width:15px;'></a>";
                    // onclick='RespaldarDel(".$IdDelegacion.");'
                }
                echo "</td>";


                
                echo "<td align=center valign=middle>";
                $GoogleDriveRuta = DelegacionRutaDrive($IdDelegacion);
                if ($GoogleDriveRuta <> ''){
                echo "<div id='DivDrive".$IdDelegacion."' class='MyModal'></div>";
                
                echo "<input type='hidden' id='DriveRuta".$IdDelegacion."' value='".$GoogleDriveRuta."'>";
                if ($f['RutaRespaldo']<>''){                    
                    echo "<a title='Ver archivos en Drive de esta Delegacion' rel='MyModal:open' href='#DivDrive".$IdDelegacion."'  onclick='DriveDel(".$IdDelegacion.");' class='' style='cursor:pointer; padding:2px;'><img src='icon/drive.png' style='width:15px;'></a>";
                    // onclick='RespaldarDel(".$IdDelegacion.");'
                }
                }
                echo "</td>";


                
                    
                   echo "</tr>";
                }

                //ESTATAL
                echo "<tr>";
                        echo "<td>ESTATAL</td>";
                        echo "<td>";
                            $IdDelegacion =0;
                            echo "<div id='DivBD". $IdDelegacion."'></div>";
                            if (isset($_GET['all'])){
                            echo '<script>';
                            echo '
                                $("#DivBD'.$IdDelegacion.'").html("<img src=img/loader_bar.gif  style=width:12px> "); ';
                                    
                             echo ' 
                                
                                $.ajax({
                                    url: "monitor_dat1.php",
                                    type: "post",                                
                                    data: {IdDel: "'.$IdDelegacion.'", Nitavu: "'.$nitavu.'"},
                                    success: function(data){                                    
                                    $("#DivBD'.$IdDelegacion.'").html(data);                                    
                                    }
                                });';


                                      
                            echo '                              ';


                            echo "</script>";
                            }

                            if (isset($_GET['IdDel'])){
                                $IdDelegacion = $_GET['IdDel'];
                                echo '<script>';
                                echo '
                                    $("#DivBD'.$IdDelegacion.'").html("<img src=img/loader_bar.gif  style=width:12px> "); ';
                                        
                                 echo ' 
                                    
                                    $.ajax({
                                        url: "monitor_dat1.php",
                                        type: "post",                                
                                        data: {IdDel: "'.$IdDelegacion.'", Nitavu: "'.$nitavu.'"},
                                        success: function(data){                                    
                                        $("#DivBD'.$IdDelegacion.'").html(data);                                    
                                        }
                                    });';
    
    
                                          
                                echo '                              ';
    
    
                                echo "</script>";
                                }

                       
                       
                        echo "</td>";
                        
                        echo "<td>";
                        $IdDelegacion = 0;
                        
                        echo "<div id='DivBK". $IdDelegacion."'></div>";
                        if (isset($_GET['all'])){
                        echo '<script>';
                        echo '
                            $("#DivBK'.$IdDelegacion.'").html("<img src=img/loader_bar.gif  style=width:12px> "); ';
                                
                         echo ' 
                            
                            $.ajax({
                                url: "monitor_dat2.php",
                                type: "post",                                
                                data: {IdDel: "'.$IdDelegacion.'", Nitavu: "'.$nitavu.'"},
                                success: function(data){                                    
                                $("#DivBK'.$IdDelegacion.'").html(data);                                    
                                }
                            });';


                                  
                        echo '                              ';


                        echo "</script>";
                        }

                        if (isset($_GET['IdDel'])){
                            $IdDelegacion = $_GET['IdDel'];
                            echo '<script>';
                            echo '
                                $("#DivBK'.$IdDelegacion.'").html("<img src=img/loader_bar.gif  style=width:12px> "); ';
                                    
                             echo ' 
                                
                                $.ajax({
                                    url: "monitor_dat2.php",
                                    type: "post",                                
                                    data: {IdDel: "'.$IdDelegacion.'", Nitavu: "'.$nitavu.'"},
                                    success: function(data){                                    
                                    $("#DivBK'.$IdDelegacion.'").html(data);                                    
                                    }
                                });';
    
    
                                      
                            echo '                              ';
    
    
                            echo "</script>";
                            }
                   
                   
                    echo "</td>";


                    echo "<td>";
                    $IdDelegacion = 0;
                    
                    echo "<div id='DivBKX". $IdDelegacion."'></div>";
                    if (isset($_GET['all'])){
                    echo '<script>';
                    echo '
                        $("#DivBKX'.$IdDelegacion.'").html("<img src=img/loader_bar.gif  style=width:12px> "); ';
                            
                     echo ' 
                        
                        $.ajax({
                            url: "monitor_dat3.php",
                            type: "post",                                
                            data: {IdDel: "'.$IdDelegacion.'", Nitavu: "'.$nitavu.'"},
                            success: function(data){                                    
                            $("#DivBKX'.$IdDelegacion.'").html(data);                                    
                            }
                        });';


                              
                    echo '                              ';


                    echo "</script>";
                    }

                    // if (isset($_GET['IdDel'])){
                    //     $IdDelegacion = $_GET['IdDel'];
                    //     echo '<script>';
                    //     echo '
                    //         $("#DivBKX'.$IdDelegacion.'").html("<img src=img/loader_bar.gif  style=width:12px> "); ';
                                
                    //      echo ' 
                            
                    //         $.ajax({
                    //             url: "monitor_dat3.php",
                    //             type: "post",                                
                    //             data: {IdDel: "'.$IdDelegacion.'", Nitavu: "'.$nitavu.'"},
                    //             success: function(data){                                    
                    //             $("#DivBKX'.$IdDelegacion.'").html(data);                                    
                    //             }
                    //         });';
    
    
                                  
                    //     echo '                              ';
    
    
                    //     echo "</script>";
                    //     }
    
               
               
                echo "</td>";
                            
                    
                   echo "</tr>";

                   echo "<tr>";
                   echo "<td align=center colspan=5><a href='?all' class='Mbtn btn-azulTam' style='color:white;'>Revisar Todas</a></td>";
                //    echo "<td>";
                // //    echo "<a class='Mbtn btn-azulTam' href='reporteador.php?busqueda=ifc' title='Haga clic para ir a ver el reporte de Incidencia de Fallas de Conección' target=_blank>IFC</a>";
                //     echo "</td>";
                   
                //     echo "<td>";
                //     // echo "<a class='Mbtn btn-azulTam' href='reporteador.php?busqueda=ifr' title='Haga clic para ir a ver el reporte de Incidencias de Fallas de Respaldos' target=_blank>IFR</a>";
                //     echo "</td>";

                //     echo "<td></td>";
                   
                   
                   echo "</tr>";

                echo "</table>";
                
                
            } else {
                mensaje("No tiene acceso a esta aplicacion","");
            }
            ?>
            </div>
    
    
    
    
    </section>
    <!-- <section style="width:100%; height:100%; background-color:green;"> Test 2 </section> -->
      
</div>


<script>
function ChecarDel(IdDelegacion){
    $("#DivBD" + IdDelegacion).html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "monitor_dat1.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                    
        $("#DivBD"+IdDelegacion+"").html(data);      
        console.log('ok '+ data);
        }
    });

    $("#DivBK" + IdDelegacion).html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "monitor_dat2.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                            
        $("#DivBK"+IdDelegacion+"").html(data);                                   
        }
    });

    $("#DivBKX" + IdDelegacion).html("<img src=img/loader_bar.gif  style=width:12px> ");
    $.ajax({
        url: "monitor_dat3.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                            
        $("#DivBKX"+IdDelegacion+"").html(data);                                   
        }
    });

}

function RespaldarDel(IdDelegacion){
    $("#DivDBbak" + IdDelegacion).html("<img src=img/loader_bar.gif  style=width:12px> ");
    console.log("Respaldando " + IdDelegacion);
    $.ajax({
        url: "monitor_dat4.php",
        type: "post",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>},
        success: function(data){                                    
        $("#DivDBbak"+IdDelegacion).html(data);                                    
        console.log("Respaldando " + data);
        NPush(data,'Servidor');
            
        }
    });

}

function DriveDel(IdDelegacion){
    $("#DivDrive" + IdDelegacion).html("<img src=img/loader_bar.gif  style=width:12px> ");
    var ruta = $("#DriveRuta"+IdDelegacion).val();
    console.log("Respaldando " + IdDelegacion);
    $.ajax({
        url: "<?php echo $URLwebserviceVivienda?>:82/GoogleDrive/GoogleDrive.php",
        type: "get",                                
        data: {IdDel: IdDelegacion, Nitavu: <?php echo $nitavu; ?>, ruta:ruta},
        success: function(data){                                    
        $("#DivDrive"+IdDelegacion).html(data);                                    
        console.log("Consultando Google Drive " + data);
        // NPush(data,'Servidor');
            
        }
    });

}

</script>

<?php
include("lib/body_footer.php");
?>

<!-- <script type="text/javascript">
		$(function(){
            $('#Monitor section:gt(0)').hide();
            
		    setInterval(function(){
		        $('#Monitor section:first-child').fadeOut(1000)
		         .next('section').fadeIn(1000)
                 .end().appendTo('#Monitor');
                }    
                , 50000);
		});
        
        
   
</script> -->