<?php
include("lib/body_head.php");
include("lib/body_menu.php");
$id_aplicacion ="monitor"; //Id de la aplicacion a cargar
docdigital_no(FALSE, 1); //ahorra 1 hoja
xd_update('monitor',$nitavu);//guarda la experiencia del usuario
// $nivel = aplicacion_nivel($id_aplicacion, $nitavu);	//Nivel 1 = todos, otro nivel solo los que dependen de el

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    // $MisDepartamentos = misdptos($nitavu);
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
$MiNombre = nombre_corto($nitavu,0). " ".nombre_corto($nitavu,1);
habla("Hola ".$MiNombre.",  empezare por realizar un check de las bases de datos del instituto; te ire informando de los resultados.");
?>
<div id="Monitor" style="width:100%; height:100%;">
    <section style="width:100%; height:100%; background-color:whitesmoke;">
            <div id='MonitorDelegaciones'>
            <input id='MonitorDelegacionesResumen' style='display:none;' value="" type="text">
            <input id='MonitorDelegacionesBKResumen' style='display:none;' value="" type="text">
            <input id='MonitorDelegacionesBK2Resumen' style='display:none;' value="" type="text">
            <?php
                $sql = 'select * from cat_delegaciones where cat_delegaciones.dpto_id <> "" order by nombre ';
                echo "<table class='tabla' border= 0><th>Delegacion</th><th title='Coneccion desde Oficinas Centrales'>BD</th><th title='Respaldo de los ultimos 7 dias'>BK7</th><th title='Respaldos de ayer'>BK1</th>";
                $r= $conexion -> query($sql); while($f = $r -> fetch_array()) {
                   echo "<tr>";
                        echo "<td>".$f['nombre']."</td>";
                        echo "<td>";
                            $IdDelegacion = $f['id'];
                            echo "<div id='DivBD". $IdDelegacion."'></div>";
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

                       
                       
                        echo "</td>";


                        echo "<td>";
                        $IdDelegacion = $f['id'];
                        echo "<div id='DivBK". $IdDelegacion."'></div>";
                       

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

                   
                   
                    echo "</td>";
                    

                    echo "<td>";
                    $IdDelegacion = $f['id'];
                    echo "<div id='DivBKX". $IdDelegacion."'></div>";
                   

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

               
               
                echo "</td>";
                            
                    
                   echo "</tr>";
                }

                //ESTATAL
                echo "<tr>";
                        echo "<td>ESTATAL</td>";
                        echo "<td>";
                            $IdDelegacion =0;
                            echo "<div id='DivBD". $IdDelegacion."'></div>";
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

                       
                       
                        echo "</td>";
                        
                        echo "<td>";
                        $IdDelegacion = 0;
                        
                        echo "<div id='DivBK". $IdDelegacion."'></div>";
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

                   
                   
                    echo "</td>";


                    echo "<td>";
                    $IdDelegacion = 0;
                    
                    echo "<div id='DivBKX". $IdDelegacion."'></div>";
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

               
               
                echo "</td>";
                            
                    
                   echo "</tr>";

                   echo "<tr>";
                   echo "<td>Reportes:</td>";
                   echo "<td>"."<a class='Mbtn btn-azulTam' href='reporteador.php?busqueda=ifc' title='Haga clic para ir a ver el reporte de Incidencia de Fallas de Conección' target=_blank>IFC</a></td>";
                   echo "<td>"."<a class='Mbtn btn-azulTam' href='reporteador.php?busqueda=ifr' title='Haga clic para ir a ver el reporte de Incidencias de Fallas de Respaldos' target=_blank>IFR</a></td>";
                   
                   
                   echo "</tr>";

                echo "</table>";
                
                
            } else {
                mensaje("No tiene acceso a esta aplicacion","");
            }
            ?>
            </div>
    
    
    
    
    </section>
    <section style="width:100%; height:100%; background-color:green;"> Test 2 </section>
      
</div>
	    
	

<?php


?>
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