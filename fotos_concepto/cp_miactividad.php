<?php include ("./unica/body_head.php");
include ("./unica/body_menu.php"); ?>
<?php
$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap66";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<h5>".app_detalle($id_aplicacion)."</h5>";
    echo "<div id='pesta_elementos'>";
    $mas="";
    if (isset($_GET['n'])){
            $mas="&n=";
    }
    if (isset($_GET['pes'])) {
            if ($_GET['pes']=='finalizados'){
                echo "<a class='seleccionada' href='?pes=finalizados".$mas."'>Finalizados</a>";	
                echo "<a class='sinseleccion' href='?pes=creados".$mas."'>Creados por mi</a>";				
                echo "<a class='sinseleccion' href='?pes=participe".$mas."'>Participe</a>";	
            }	
        }

    if (isset($_GET['pes'])) {
            if ($_GET['pes']=='creados'){
                echo "<a class='sinseleccion' href='?pes=finalizados".$mas."'>Finalizados</a>";	
                echo "<a class='seleccionada' href='?pes=creados".$mas."'>Creados por mi</a>";				
                echo "<a class='sinseleccion' href='?pes=participe".$mas."'>Participe</a>";	
            }	
        }


    if (isset($_GET['pes'])) {
            if ($_GET['pes']=='participe'){
                echo "<a class='sinseleccion' href='?pes=finalizados".$mas."'>Finalizados</a>";	
                echo "<a class='sinseleccion' href='?pes=creados".$mas."'>Creados por mi</a>";	
                echo "<a class='seleccionada' href='?pes=participe".$mas."'>Participe</a>";	
            }	
        }

    echo "</div>";

     //DIV CASOS FINALIZADOS
    if (isset($_GET['pes'])) {
        if ($_GET['pes']=='finalizados'){echo "<div id='pesta1' class='pesta visible' style='width:100%;'>";	}
        else
        {echo "<div id='pesta1' class='pesta invisible'>";}
    }
   
	echo "<div style='width:100%;'>";
    $dpto = nitavu_dpto($nitavu);
    
    echo "<div>";
	echo "<label for='dptos'>Filtrar por departamento (Quien los tiene):";
	echo "<select id='dptos' name='dptos' onchange='filtroDpto(".$nitavu.",1);'>";
    echo "<option value='1000'>Todos</option>";
        //$sql = "SELECT * FROM cat_gerarquia where id in (".misdptos($nitavu).")";
    $sql = "SELECT * FROM cat_gerarquia";
        //echo $sql;
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				echo "<option value='".$f['id']."'>".$f['nombre']. "</option>";
			}
	
	echo "</select>";
	echo "</label>";
	echo "</div>";
  
    if ($nivel==1 || soytitular($nitavu)!='FALSE'){
        $query = "SELECT DISTINCT * FROM cp_nuevosdocumentos 
    WHERE (nitavuCaptura = ".$nitavu." OR idDptoCrea = ".nitavu_dpto($nitavu)."  OR id IN (SELECT numcaso FROM cp_colaboradores WHERE nitavu=".$nitavu.") OR id IN (SELECT NumCaso FROM cp_historialdocumentos WHERE nitavuSube=".$nitavu.") OR turnadoa = ".nitavu_dpto($nitavu)." OR id IN (SELECT CasoId FROM cp_comentarios WHERE Nuser = ".$nitavu."))
    AND estado = 1";
    //echo $query;
    }else{
        $query = "SELECT DISTINCT * FROM cp_nuevosdocumentos 
    WHERE (nitavuCaptura = ".$nitavu." OR id IN (SELECT numcaso FROM cp_colaboradores WHERE nitavu=".$nitavu.") OR id IN (SELECT NumCaso FROM cp_historialdocumentos WHERE nitavuSube=".$nitavu.") OR id IN (SELECT CasoId FROM cp_comentarios WHERE Nuser = ".$nitavu."))
    AND estado = 1";
    //echo $query;
    }
    echo "<center>";
        echo "<h1>Casos Finalizados en los que participe:</h1>";
        echo "<div id='resconsulta'  style='width:100%;'></div>";
        echo "<div id='primeraFinalizados' style='width:100%;'><table class='tabla' style='width:100%;'>";
    $r= $conexion -> query($query); 
   
    $r_count = $r -> num_rows;

    if ($r_count>0){ 
        
    
         /// PARA PAGINAR
        //Comprueba si está seteado el GET de HTTP
        if (isset($_GET["p"])) {
            //Si el GET de HTTP SÍ es una string / cadena, procede
            if (is_string($_GET["p"])) {
                //Si la string es numérica, define la variable 'pagina'
                if (is_numeric($_GET["p"])) {
                    //Si la petición desde la paginación es la página uno
                    //en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
                        $pagina = $_GET["p"];
                    
                } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
                    header("Location: ./index.php");
                    die();
                };
            };
        } else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
            $pagina = 1;
        };
        //Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
        $empezar_desde = ($pagina-1) * $paginacion;
        //echo $paginacion;
        // agregamos limite a la consulta
        $query = $query." LIMIT ".$empezar_desde.", ".$paginacion;
        //echo $sql;
        $r = $conexion -> query($query);
        
        $paginas = ceil(($r_count / $paginacion));
        //historia($nitavu,'cp_Busqueda de '.$search);
        
        
        $cont=0;
        
        echo "<th width='10%' COLSPAN='2'>Fecha</th>"; 
        echo "<th width='70%'>Asunto</th>";
        echo "<th >Ver</th>";
        
        while($f = $r -> fetch_array()){
            
            
            echo "<tr>";
                echo "<td  style='text-align: center;'><span style='background-color:gray; color:white;padding:5px; border-radius:50%;font-size:10pt'>".$f['id']."</span></td>";
                echo "<td  style='text-align: center;'>".fecha_larga($f['fecha'])."</td>";              
                echo "<td><div style='width:100%;'><b>".$f['asunto']."</b><span style='font-size:7pt'><br>".$f['descripcion']."</span><br>
                <span style='color:blue;'>Creado por: ".nombreDepartamento($f['idDptoCrea'])."<br>";
                
                if(ultimoColaborador($f['id']) != 'FALSE'){
                    echo '<b style="color: #000; font-size:8pt;">Ultimo colaborador: '.nitavu_nombre(ultimoColaborador($f['id'])).'</b>';
                  }else{
                    if(personasConNivelUno($f['id']) != 'FALSE'){
                      echo '<b style="color: #000; font-size:8pt;">Ultimo colaborador: '.nitavu_nombre(personasConNivelUno($f['id'])).'</b>';
                    }else{
                      if(buscoalTitulardelCaso($f['id']) != 'FALSE'){
                        echo '<b style="color: #000; font-size:8pt;">Ultimo colaborador: '.nitavu_nombre(buscoalTitulardelCaso($f['id'])).'</b>';
                      }else{
                        echo '<b style="color: #000; font-size:8pt;">No definido</b>';
                      }
                    }
                  }
                
                
                
                echo "</span></div>";


                echo "</td>";
                echo "<td>";
                echo '<center><div id="cont2">
                    <div id="contenidos2">
                        <center>
                        <div id="colum1">';
                            echo "<form action='cp_nuevos_oficios.php' method='GET'>";
                            echo "<input type='hidden' value=".$f['id']." name='id'>";
                            echo "<input type='hidden' name='txtplus' value=1>";
                            echo "<input type='hidden' name='pv' value=1>";
                            echo "<button type='submit' class='btn btn-default' title='Haga clic para ver el historial del archivo' onclick=''> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </button>"; 
                            echo "</form>";
                        echo '</div>';
                    echo '</center>
                    </div>
                    </div>
                    </center>
                </td>';
            echo "</tr>";
           
        } 
        echo "</table>";
        
    }else{
        echo "<label>Nada por el momento....</label>";
    }


    if ($r_count >= $paginacion)
	{
	echo "<center><div id='barra_paginacion'>";
		echo "Páginas: ";
			//Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
			//Nota: X = $total_paginas
			for ($i=1; $i<=$paginas; $i++) {
				//En el bucle, muestra la paginación
				if ($pagina==$i){
					echo "<span id='pagina_actual'>".$pagina."</span>"; //para el CSS span = a pagina actual
				}else{
				//	echo "<span id='pagina_proxima'><a href='?search=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
					echo "<span id='pagina_proxima'><a href='?p=".$i."&pes=finalizados'>".$i."</a></span>"; //CSS span a = link a paginas
				}
			}
	echo "</div></center>";
    }
    
    echo "</div>";
    echo "</div>";
    echo "</div></center>";
    
    //DIV CASOS QUE YO CREE
    if (isset($_GET['pes'])) {
        if ($_GET['pes']=='creados'){echo "<div id='pesta1' class='pesta visible' style='width:100%;'>";	}
        else
        {echo "<div id='pesta1' class='pesta invisible'>";}
    }
	echo "<div style='width:100%;'>";
	$dpto = nitavu_dpto($nitavu);
    
    $pags=20;
    $query1 = "SELECT DISTINCT * FROM cp_nuevosdocumentos WHERE nitavuCaptura = ".$nitavu."";
    //echo $query;
    
    $r1= $conexion -> query($query1); 
    $r_count1 = $r1 -> num_rows;

  
    if ($r_count1>0){ 
         /// PARA PAGINAR
        //Comprueba si está seteado el GET de HTTP
        if (isset($_GET["p1"])) {
            //Si el GET de HTTP SÍ es una string / cadena, procede
            if (is_string($_GET["p1"])) {
                //Si la string es numérica, define la variable 'pagina'
                if (is_numeric($_GET["p1"])) {
                    //Si la petición desde la paginación es la página uno
                    //en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
                        $pagina1 = $_GET["p1"];
                    
                } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
                    header("Location: ./index.php");
                    die();
                };
            };
        } else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
            $pagina1 = 1;
        };
        //Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
       
      
        $empezar_desde1 = ($pagina1-1) * $pags;
        // agregamos limite a la consulta
        $query1 = $query1." LIMIT ".$empezar_desde1.", ".$pags;
        //echo $sql;
        $r1 = $conexion -> query($query1);
        //echo $r_count1;
        $paginas1 = ceil(($r_count1 / $pags));
        //echo $paginas1;
        //historia($nitavu,'cp_Busqueda de '.$search);
        
        
        $cont=0;
        echo "<center>";
        echo "<h1>Casos que registre:</h1>";
        echo "<div style='width:100%;'><table class='tabla' style='width:100%;'>";
        echo "<th width='10%' COLSPAN='2'>Fecha</th>"; 
        echo "<th width='70%'>Asunto</th>";
        echo "<th >Ver</th>";
        
        while($f1 = $r1 -> fetch_array()){
            
            
            echo "<tr>";
                echo "<td  style='text-align: center;'><span style='background-color:gray; color:white;padding:5px; border-radius:50%;font-size:10pt'>".$f1['id']."</span></td>";
                echo "<td  style='text-align: center;'>".fecha_larga($f1['fecha'])."</td>";              
                echo "<td><div style='width:100%;'><b>".$f1['asunto']."</b><span style='font-size:7pt'><br>".$f1['descripcion']."</span><br>
                <span style='color:blue;'>Creado por: ".nombreDepartamento($f1['idDptoCrea'])."<br>";
                
                if(ultimoColaborador($f1['id']) != 'FALSE'){
                    echo '<b style="color: #000; font-size:8pt;">Ultimo colaborador: '.nitavu_nombre(ultimoColaborador($f1['id'])).'</b>';
                  }else{
                    if(personasConNivelUno($f1['id']) != 'FALSE'){
                      echo '<b style="color: #000; font-size:8pt;">Ultimo colaborador: '.nitavu_nombre(personasConNivelUno($f1['id'])).'</b>';
                    }else{
                      if(buscoalTitulardelCaso($f1['id']) != 'FALSE'){
                        echo '<b style="color: #000; font-size:8pt;">Ultimo colaborador: '.nitavu_nombre(buscoalTitulardelCaso($f1['id'])).'</b>';
                      }else{
                        echo '<b style="color: #000; font-size:8pt;">No definido</b>';
                      }
                    }
                  }
                
                
                
                echo "</span></div>";
                echo "</td>";
                echo "<td>";
                echo '<center><div id="cont2">
                    <div id="contenidos2">
                        <center>
                        <div id="colum1">';
                            echo "<form action='cp_nuevos_oficios.php' method='GET'>";
                            echo "<input type='hidden' value=".$f1['id']." name='id'>";
                            echo "<input type='hidden' name='txtplus' value=1>";
                            echo "<input type='hidden' name='pv' value=1>";
                            echo "<button type='submit' class='btn btn-default' title='Haga clic para ver el historial del archivo' onclick=''> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </button>"; 
                            echo "</form>";
                        echo '</div>';
                    echo '</center>
                    </div>
                    </div>
                    </center>
                </td>';
            echo "</tr>";
           
        } 
        echo "</table>";
        echo "</div></center>";
    }


    if ($r_count1 >= $pags)
	{
	echo "<center><div id='barra_paginacion'>";
		echo "Paginas: ";
			//Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
			//Nota: X = $total_paginas
			for ($i1=1; $i1<=$paginas1; $i1++) {
				//En el bucle, muestra la paginación
				if ($pagina1==$i1){
					echo "<span id='pagina_actual'>".$pagina1."</span>"; //para el CSS span = a pagina actual
				}else{
				//	echo "<span id='pagina_proxima'><a href='?search=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
					echo "<span id='pagina_proxima'><a href='?p1=".$i1."&pes=creados'>".$i1."</a></span>"; //CSS span a = link a paginas
				}
			}
	echo "</div></center>";
    }
    
    echo "</div>";
    echo "</div>";

    //DIV EN LOS QUE PARTICIPE
    if (isset($_GET['pes'])) {
        if ($_GET['pes']=='participe'){echo "<div id='pesta1' class='pesta visible' style='width:100%;'> ";	}
        else
        {echo "<div id='pesta1' class='pesta invisible'>";}
    }

    echo "<div style='width:100%;'>";
    $dpto = nitavu_dpto($nitavu);
    
    echo "<div>";
	echo "<label for='dptos1'>Filtrar por departamento (Quien los tiene):";
	echo "<select id='dptos1' name='dptos1' onchange='filtroDpto1(".$nitavu.",2);'>";
	echo "<option value='1000'>Todos</option>";
    //$sql = "SELECT * FROM cat_gerarquia where id in (".misdptos($nitavu).")";
    $sql = "SELECT * FROM cat_gerarquia";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				echo "<option value='".$f['id']."'>".$f['nombre']. "</option>";
			}
	
	echo "</select>";
	echo "</label>";
	echo "</div>";
  
    if ($nivel==1 || soytitular($nitavu)!='FALSE'){
        $query = "SELECT DISTINCT * FROM cp_nuevosdocumentos 
    WHERE (nitavuCaptura = ".$nitavu." OR idDptoCrea = ".nitavu_dpto($nitavu)."  OR id IN (SELECT numcaso FROM cp_colaboradores WHERE nitavu=".$nitavu.") OR id IN (SELECT NumCaso FROM cp_historialdocumentos WHERE nitavuSube=".$nitavu.") OR turnadoa = ".nitavu_dpto($nitavu)." OR id IN (SELECT CasoId FROM cp_comentarios WHERE Nuser = ".$nitavu."))
    AND estado = 0";
  
    }else{
        $query = "SELECT DISTINCT * FROM cp_nuevosdocumentos 
    WHERE (nitavuCaptura = ".$nitavu." OR id IN (SELECT numcaso FROM cp_colaboradores WHERE nitavu=".$nitavu.") OR id IN (SELECT NumCaso FROM cp_historialdocumentos WHERE nitavuSube=".$nitavu.") OR id IN (SELECT CasoId FROM cp_comentarios WHERE Nuser = ".$nitavu."))
    AND estado = 0";
 
    }
   
    echo "<center>";
    echo "<h1>Casos en los que participe que aun no han finalizado:</h1>";
    echo "<div id='resconsulta1'  style='width:100%;'></div>";
    echo "<div id='primeraParticipe' style='width:100%;'><table class='tabla' style='width:100%;'>";
    
    $r= $conexion -> query($query); 
    $r_count = $r -> num_rows;

    if ($r_count>0){ 
         /// PARA PAGINAR
        //Comprueba si está seteado el GET de HTTP
        if (isset($_GET["p"])) {
            //Si el GET de HTTP SÍ es una string / cadena, procede
            if (is_string($_GET["p"])) {
                //Si la string es numérica, define la variable 'pagina'
                if (is_numeric($_GET["p"])) {
                    //Si la petición desde la paginación es la página uno
                    //en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
                        $pagina = $_GET["p"];
                    
                } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
                    header("Location: ./index.php");
                    die();
                };
            };
        } else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
            $pagina = 1;
        };
        //Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
        $empezar_desde = ($pagina-1) * $paginacion;
        //echo $paginacion;
        // agregamos limite a la consulta
        $query = $query." LIMIT ".$empezar_desde.", ".$paginacion;
        //echo $sql;
        $r = $conexion -> query($query);
        //echo $paginacion;
       
        $paginas = ceil(($r_count / $paginacion));
        //echo $paginas;
        //historia($nitavu,'cp_Busqueda de '.$search);
        
        
        $cont=0;
        
        echo "<th width='10%' COLSPAN='2'>Fecha</th>"; 
        echo "<th width='70%'>Asunto</th>";
        echo "<th >Ver</th>";
        
        while($f = $r -> fetch_array()){
            
            
            echo "<tr>";
                echo "<td  style='text-align: center;'><span style='background-color:gray; color:white;padding:5px; border-radius:50%;font-size:10pt'>".$f['id']."</span></td>";
                echo "<td  style='text-align: center;'>".fecha_larga($f['fecha'])."</td>";              
                echo "<td><div style='width:100%;'><b>".$f['asunto']."</b><span style='font-size:7pt'><br>".$f['descripcion']."</span><br>
                <span style='color:blue;'>Creado por: ".nombreDepartamento($f['idDptoCrea'])."<br>";
                
                if(ultimoColaborador($f['id']) != 'FALSE'){
                    echo '<b style="color: #000; font-size:8pt;">Ultimo colaborador: '.nitavu_nombre(ultimoColaborador($f['id'])).'</b>';
                  }else{
                    if(personasConNivelUno($f['id']) != 'FALSE'){
                      echo '<b style="color: #000; font-size:8pt;">Ultimo colaborador: '.nitavu_nombre(personasConNivelUno($f['id'])).'</b>';
                    }else{
                      if(buscoalTitulardelCaso($f['id']) != 'FALSE'){
                        echo '<b style="color: #000; font-size:8pt;">Ultimo colaborador: '.nitavu_nombre(buscoalTitulardelCaso($f['id'])).'</b>';
                      }else{
                        echo '<b style="color: #000; font-size:8pt;">No definido</b>';
                      }
                    }
                  }
                
                
                
                echo "</span></div>";
                echo "</td>";
                echo "<td>";
                echo '<center><div id="cont2">
                    <div id="contenidos2">
                        <center>
                        <div id="colum1">';
                            echo "<form action='cp_nuevos_oficios.php' method='GET'>";
                            echo "<input type='hidden' value=".$f['id']." name='id'>";
                            echo "<input type='hidden' name='txtplus' value=1>";
                            echo "<input type='hidden' name='pv' value=1>";
                            echo "<button type='submit' class='btn btn-default' title='Haga clic para ver el historial del archivo' onclick=''> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </button>"; 
                            echo "</form>";
                        echo '</div>';
                    echo '</center>
                    </div>
                    </div>
                    </center>
                </td>';
            echo "</tr>";
           
        } 
        echo "</table>";
        
    }else{
        echo "<label>Nada por el momento....</label>";
    }


    if ($r_count >= $paginacion)
	{
	echo "<center><div id='barra_paginacion'>";
		echo "Páginas: ";
			//Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
			//Nota: X = $total_paginas
			for ($i=1; $i<=$paginas; $i++) {
				//En el bucle, muestra la paginación
				if ($pagina==$i){
					echo "<span id='pagina_actual'>".$pagina."</span>"; //para el CSS span = a pagina actual
				}else{
				//	echo "<span id='pagina_proxima'><a href='?search=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
					echo "<span id='pagina_proxima'><a href='?p=".$i."&pes=participe'>".$i."</a></span>"; //CSS span a = link a paginas
				}
			}
	echo "</div></center>";
    }
    
    echo "</div>";
    echo "</div>";
    echo "</div></center>";
}
?>
<script>
    
function filtroDpto(nitavu,caso){
    var dpto = $("#dptos option:selected").val();
    if(dpto == 1000){
        $("#resconsulta").css({'display':'none',});
        $("#primeraFinalizados").css({'display':'inline-block',});
    }else{
        $("#preloader").css({'display':'inline-block',});
        $.ajax({
            url: "cp_consultapordpto.php",
            type: "get",
            data: {dpto: dpto, nitavu:nitavu, caso: caso},
            success: function(data){
                $("#preloader").css({'display':'none',});
                $("#primeraFinalizados").css({'display':'none',});
                $('#resconsulta').html(data+"\n");      
                $("#resconsulta").css({'display':'inline-block',});         
            }
        });

    }
}

function filtroDpto1(nitavu,caso){
    var dpto = $("#dptos1 option:selected").val();
    if(dpto == 1000){
        $("#resconsulta1").css({'display':'none',});
        $("#primeraParticipe").css({'display':'inline-block',});
    }else{
        $("#preloader").css({'display':'inline-block',});
        $.ajax({
            url: "cp_consultapordpto.php",
            type: "get",
            data: {dpto: dpto, nitavu:nitavu, caso: caso},
            success: function(data){
                $("#preloader").css({'display':'none',});
                $("#primeraParticipe").css({'display':'none',});
                
                $('#resconsulta1').html(data+"\n");     
                $("#resconsulta1").css({'display':'inline-block',});      
            }
        });

    }
}



</script>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include ("./unica/body_footer.php"); ?>