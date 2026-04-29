<?php include ("./unica/body_head.php"); include ("./unica/body_menu.php");?>

<script>
  $(document).on("change", "#asunto", function(event) {
  //$("#numeroSeleccionado").val($("#asunto option:selected").text());
  $("#numeroSeleccionado").val($("#asunto option:selected").val());
  //document.getElementById("contenedor").innerHTML = ["<input type=hidden id=numeroOficio   name=numeroOficio value="+num+">"]; 
  });   
</script>

<?php
require("unica/config.php");
$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap66";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{ //PARA DAR ACCESO CUANDO ESTE REGISTRADA
  echo "<h5>".app_detalle($id_aplicacion)."</h5>";
 
  $id=$_GET['id'];

  //Verificar que puedes ver el Ticket
  $Permiso =  TicketTengoPermiso($nitavu, $id);  $Participacion = TicketParticipo($nitavu, $id);
  // echo "Permiso = ".$Permiso.", Participacion=".$Participacion;

  if ($Permiso == TRUE or $Participacion == TRUE){




          $finalizado = estaFinalizadoCaso($id); 
          $turnadoami = estaTurnadoami($id);
          $dpto = nitavu_dpto($nitavu);
          if (isset($_GET['pv'])){
            historia($nitavu,'cp_Entró a ver el historial del caso: '.$id);
          }
          

          
            //Modal para turnar
            echo "<div id='modalTurnar' class='modal'>";
            echo "<form action='cp_controldocumental.php' method='POST' enctype='multipart/form-data'>"; 
            echo "<h3 style='color:#575A5D'>Turnar caso</h3>";
              
              $dpto = nitavu_dpto($nitavu);
              /*echo "<label for='asunto'>Seleccione el número de documento con el que turnará el caso:</label>";
              echo "<table style='width:100%;'><td style='width:90%;'>";
              echo "<select id='asunto' name='asunto' onchange='traerDatos()' required>";
              echo "<option value='' disabled selected>Seleccione un asunto...</option>";
              $sql = "SELECT * FROM cp_controlcorrespondencia WHERE IdDptoCrea=".$dpto." and Utilizado = 0 and Numero != 0 and NumDocumento != '' ORDER BY FechaCrea ";
              
              $r = $conexion -> query($sql);
              while($f = $r -> fetch_array())
              { // resultado de la busqueda.................
                echo "<option value='".$f['NumDocumento']."'>".$f['Numero'].'-'.$f['Asunto']. "</option>";
              }
              echo "</select></td>";
                    echo "<td style='width:10%;'><a href='#myModalaAgregar' rel='modal:open' class='btn btn-default' title='Nuevo Número'>
                    <img src='icon/nuevoNumero.png'  style='width:15px; height:15px;'> </a></td>";
              echo "</table>";*/
              
              
              echo "<div>";
                echo "<label>Número de documento</label>";
                echo "<input type='text' id='numeroSeleccionado' name='numeroSeleccionado'>";
                echo "<input type='hidden' name='idCaso' value= ".$id.">";
              echo "</div>";
              echo "<div>";
                echo "<label>Fecha: </label>";
                echo '<input type="date" id="fechaOficio" name="fechaOficio" value='.$fecha.' required>';
                
              echo "</div>";
              echo "<div>";
                echo "<label for='departamento' class='label'>Departamento:";
                echo "<select name='departamento'   id='departamento'   style='margin-left: 0px;'>";	
                echo '<option value="1000" selected="selected">Seleccione </option>';		
                echo '<option value="100" >Fuera del Instituto </option>';
                $sql="SELECT	cat_gerarquia.id ,	cat_gerarquia.titular ,	cat_gerarquia.nombre,	cat_gerarquia.dependencia
                        FROM	cat_gerarquia where (id <>".nitavu_dpto($nitavu).") ORDER BY cat_gerarquia.nombre ";
                  $r = $conexion -> query($sql);		 
                  while($f = $r -> fetch_array())
                  { 
                    echo "<option value='".$f['id']."'>".$f['nombre']. " </option>";
                  }	
                        
                echo "</select>";
              
                echo "</label>";
              echo "</div>";
              
              echo '<input name="contestacion" type="file" accept=".pdf">';
              echo "<button type='submit' class='btn btn-default' title='Haga clic para subir el archivo'> Turnar caso </button>";
            echo "<br><br>";
            echo "</form>";
            echo "</div>";

            //PARA FINALIZAR EL CASO
            echo "<div id='modalFinalizar' class='modal'>";
              echo "<form action='cp_controldocumental.php' method='POST'>";
                echo "<h3 style='color:#575A5D'>Finalizar Caso</h3>";
                echo "<input type='hidden' name='id' value=".$id.">";
                echo "<label>Descripción del caso:</label>";
                echo "<textarea style='height:20%;' name='desc' readonly>".traerDescripcionCaso($id)."</textarea>";
                echo "<label>Agregar comentarios</label>";
                echo "<textarea style='height:20%;' name='comSolucionar' required></textarea>";
                echo "<br><br>";
                echo "<button type='submit' class='btn btn-default' title='Haga clic para terminar el caso'>Enviar</button>";
              echo "</form>";
            echo "</div>";

        //PARA COMPARTIR EL CASO
        echo "<div id='modalCompartir' class='modal'>";
        echo "<form action='cp_controldocumental.php' method='POST'>";
          echo "<h3 style='color:#575A5D'>Compartir Caso</h3>";
            echo "<div id='preloaderbloque' style='display: none; width:100%'>";
            echo "<img src='img/cargando2.gif' style='width: 50%; height:10%;' class='cargando_img'>";
            echo "</div>"; 
            echo "<div id='bloque1' style='width:100%'>"; 
            echo "<div id='bloque' style='height:15px;'>";   
            echo "<div style='display: inline-block;    width: 40%;     vertical-align: top;' >"; 
            echo "<h4>Titulares de las Areas:</h4>";   
            echo "</div>";
            
            echo "<div style='display: inline-block;    width: 40%;     vertical-align: top;'  >"; 
            echo "<h4>Colaboradores del Caso:</h4>";   
            echo "</div>";  
            echo "</div>";   
            echo "<div class='list' id='divEmpleados' >";     
                  echo "<ul class='empleados'>";
              
                  //-------------FILTRO DIRECCION JURIDICA
              $res = SoyDireccionJuridica($nitavu);
              $flag=0;
              for($i=0; $i<sizeof($res); $i++){
                //echo $res[$i];
                if(nitavu_dpto($nitavu) == $res[$i]){ 
                  $flag = 1;
                }
              }
              
              if($flag==1){
                /*$query="-- cp
                SELECT empleados.nombre, empleados.departamento, empleados.puesto, empleados.nitavu, cat_gerarquia.titular 
                FROM empleados 
              inner join cat_gerarquia on empleados.nitavu=cat_gerarquia.titular
              WHERE empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$id." and activo = 0)
              union 
              SELECT empleados.nombre, empleados.departamento, empleados.puesto, empleados.nitavu, empleados.dpto 
                FROM empleados 
                WHERE empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$id." and activo = 0)
                and empleados.nitavu not in(SELECT titular from cat_gerarquia)
              ORDER by nombre ASC";*/
              // echo $query;
              
              $query = "-- cp

              SELECT empleados.nombre, empleados.departamento, empleados.puesto, empleados.nitavu, cat_gerarquia.titular 
              FROM empleados 
              inner join cat_gerarquia on empleados.nitavu=cat_gerarquia.titular
              WHERE empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$id." and activo = 0)
              and empleados.dpto in (".misdptos(directorJuridico()).")
              and empleados.nitavu <> ".$nitavu."
        UNION
              SELECT empleados.nombre, empleados.departamento, empleados.puesto, empleados.nitavu, 'no'
              FROM empleados 
              WHERE empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$id." and activo = 0)
              and empleados.nitavu not in(SELECT titular from cat_gerarquia)  
              and empleados.dpto in (".misdptos(directorJuridico()).")
              and empleados.nitavu <> ".$nitavu."
                ORDER by nombre ASC";
                // echo $query;
              }else{
                if(strlen (titular(nitavu_dpto($nitavu)))>0)
                {
                $query="-- cp
                SELECT DISTINCT empleados.nombre, cat_gerarquia.nombre as departamento, empleados.puesto, empleados.nitavu, cat_gerarquia.titular FROM empleados 
                inner join cat_gerarquia on empleados.nitavu=cat_gerarquia.titular
                inner join aplicaciones_permisos as permisos on permisos.nitavu=empleados.nitavu
                and  empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$id.") 
                and  empleados.nitavu<>".$nitavu." and empleados.nitavu<>".titular(nitavu_dpto($nitavu))." and permisos.idapp='ap66' 
                union select empleados.nombre, empleados.departamento, empleados.puesto, empleados.nitavu, 'no'
                from empleados inner join aplicaciones_permisos as permisos on permisos.nitavu=empleados.nitavu
                where empleados.dpto=".nitavu_dpto($nitavu)." and empleados.nitavu<>".titular(nitavu_dpto($nitavu))."
                and  empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$id." and activo=0) 
                and  empleados.nitavu<>".$nitavu." and permisos.idapp='ap66' order by nombre asc";
                }else
                {$query="-- cp
                  SELECT DISTINCT empleados.nombre, cat_gerarquia.nombre as departamento, empleados.puesto, empleados.nitavu, cat_gerarquia.titular FROM empleados 
                  inner join cat_gerarquia on empleados.nitavu=cat_gerarquia.titular
                  inner join aplicaciones_permisos as permisos on permisos.nitavu=empleados.nitavu
                  and  empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$id.") 
                  and  empleados.nitavu<>".$nitavu." and permisos.idapp='ap66' 
                  union select empleados.nombre, empleados.departamento, empleados.puesto, empleados.nitavu, 'no'
                  from empleados inner join aplicaciones_permisos as permisos on permisos.nitavu=empleados.nitavu
                  where empleados.dpto=".nitavu_dpto($nitavu)."
                  and  empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$id." and activo=0) 
                  and  empleados.nitavu<>".$nitavu." and permisos.idapp='ap66' order by nombre asc";

                }
              }
              
                
                  $descripcion = '';
                  $r = $conexion -> query($query);

                  while($f = $r -> fetch_array())
                  { // resultado de la busqueda.................   
                
                    if($f['titular']=="no"){   
                      echo "<li id='".$f['nitavu']."_".$id."' onclick=AgregarColaboradores('".$id."','".$f['nitavu']."'); style='background: #BEBFBF;' >";
                  }else{
                      echo "<li id='".$f['nitavu']."_".$id."' onclick=AgregarColaboradores('".$id."','".$f['nitavu']."'); >";
                    }   
                
                  echo " <table width=100%><tr><td style='width: 80%;'>
                    <span class='tchico normal'>".$f['nombre']."</span>
                    <span class='tchico'><br>".$f['departamento']."</span>
                    </td><td class='tchico' style='width: 30px; text-align: right;'>
                    <img src='icon/entrar.png' class='icono' title='Agregar a colaboradores' style='width: 30px; height:30px;'>
                    </td></tr></table></li>";
                  } 
                  
                  echo "</ul>";  
              echo "</div>";
              
                
                  echo "<div class='list' id=divColaboradores >";
                    echo "<ul class='colaboradores'>";  
                    $query = "-- cp
                    SELECT empleados.nombre, cat_gerarquia.nombre as departamento, empleados.puesto, empleados.nitavu, ifnull(cat_gerarquia.titular,'no') as titular FROM cp_colaboradores inner join empleados
                    on cp_colaboradores.nitavu=empleados.nitavu left join cat_gerarquia on cat_gerarquia.titular=empleados.nitavu where  numcaso=".$id." and cp_colaboradores.activo=0 order by cp_colaboradores.id desc";



                  //echo $query;
                        $r = $conexion -> query($query);
                        while($f = $r -> fetch_array())
                        { // resultado de la busqueda.................      
                        
                            if($f['titular']=="no")
                            {   
                            echo "<li id='".$f['nitavu']."_".$id."' onclick=QuitarColaboradores('".$id."','".$f['nitavu']."'); style='background: #e6e6e1;' >";
                            }else
                            {
                            echo "<li id='".$f['nitavu']."_".$id."' onclick=QuitarColaboradores('".$id."','".$f['nitavu']."'); >";
                            }   
                            echo"<table><tr><td class='tchico' style='width: 20%; text-align: center;'>
                          <img src='icon/atras2.png' class='icono' title='Quitar de colaboradores' style='width: 30px; height:30px;'>
                          </td><td style='width: 80%;'>
                          <span class='tchico normal'>".$f['nombre']."</span>
                          <span class='tchico '><br>".$f['departamento']."</span>
                          </td></tr></table></li>";
                        }        
                    echo "</ul>"; 
                echo "</div>";
            echo "</div>";
          
            echo "<br>";
            echo "<br>";
        



            echo "</form>";
        echo "</div>";
                    

            //LA PRIMER PANTALLA QUE SALE
            echo "<div id='peticiones'>";  
              echo "<h1 style='font-family:ExtraBold; font-size:15pt;' class='normal'>Petición ".$id."-".asuntoCaso($id)."</h1>";
              if (estaFinalizadoCaso($_GET['id'])==0){
                // echo "no finalizo";
              } else {
                echo "<b style='color:red;'>Caso finalizado </b>";
                $query = "SELECT * FROM cp_nuevosdocumentos WHERE id=".$_GET['id']."";
                $descripcion = '';
                $rs = $conexion -> query($query);
                while($f = $rs -> fetch_array()){ // resultado de la busqueda.................
                    echo "Este caso solo puede reactivarlo ".nitavu_nombre($f['nitavuCaptura'])." quien fue quien lo inicio.";
                    if ($f['nitavuCaptura'] == $nitavu){
                      echo "<br><a href='?reactivar=".$_GET['id']."&id=".$_GET['id']."' class='btn btn-cancel'>Reactivar</a>";
                    }
                  if (isset($_GET['reactivar'])){
                    $sql="UPDATE cp_nuevosdocumentos SET Estado='0', Turnadoa=IdDptoCrea WHERE id='".$_GET['reactivar']."'";
                    if ($conexion->query($sql) == TRUE)
                    {
                      historia($nitavu, "Reactivo el caso ".$_GET['id']."");
                      mensaje("Caso reactivado con exito",'cp_nuevos_oficios.php?id='.$_GET['id']);
                    }
                    else {mensaje("ERROR al activar el caso. ".$sql,'cp_controldocumental.php');}

                  }
                }
              }
              $query = "SELECT * FROM cp_nuevosdocumentos WHERE id=".$id."";
              $descripcion = '';
              $r = $conexion -> query($query);
              while($f = $r -> fetch_array()){ // resultado de la busqueda.................
                  $descripcion = $f['descripcion'];
              }
              // echo "<label>Descripción</label>";
              echo "<div id='LaDescripcion' >";
              echo "<b style='font-size:7pt; margin:0px;'>DESCRIPCION Y COMENTARIOS:</b>";
              echo "<br>".$descripcion."<br><br>";


              //Comentarios:
              if (isset($_GET['comentall'])){
                $sqlc = "SELECT * FROM cp_comentarios where CasoId='".$id."' ORDER by fecha DESC";
              } else {$sqlc = "SELECT * FROM cp_comentarios where CasoId='".$id."' ORDER by fecha DESC limit 3";}
              
            
              $rco = $conexion -> query($sqlc);
              echo "<table class='tabla' style='background-color: #d2f2e7;
              padding: 5px; border-radius: 4px;'>";
              
              while($Cm = $rco -> fetch_array())
                { 
                  echo "<tr>";
                  echo "<td width=30px>";
                  echo "<span title='".nitavu_nombre($Cm['Nuser'])." de ".nitavu_dpto_nombre($Cm['Nuser'])."'>";
                  echo ponerfoto("fotos/".$Cm['Nuser'].".jpg",'FotoComentario');
                  echo "</span>";
                  echo "</td>";
                  echo "<td>";
                  echo "<span style='font-size:8pt;' >".$Cm['Comentario']."</span>";
                  echo "<br><span style='font-size:7pt;' >".fecha_larga($Cm['Fecha'])."|".hora12($Cm['Hora'])."</span>";
                // echo "<span style='font-size:8pt;' title='".fecha_larga($Cm['Fecha'])."|".hora12($Cm['Hora'])."'>".$Cm['Comentario']."</span>";
                  echo "</td>";
                  echo "</tr>";
                }
              echo "</table>";
              if (isset($_GET['comentall'])){
              } else {echo "<a href='?comentall=&id=".$_GET['id']."' class='btn btn-tercero' style='color:white;font-weight:bold;'>Ver todos los comentarios</a>";}

              if (estaFinalizadoCaso($_GET['id'])==0){
              echo "<table width=100%><tr><td align=right>";
              echo "<a href='#AgregarComentario' rel='modal:open' title='Agregar un comentario' class='btn-comentario'><img src='icon/bcomentario.png' style='width:40px;'></a>";
              echo "</td></tr></table>";
              }
              echo "</div>";
              

              echo "<div id='AgregarComentario' class='modal'>";
              echo "<form action='cp_nuevos_oficios.php?id=".$id."' method='POST'  enctype='multipart/form-data'>";
              echo "<label>Comentario al Caso Actual:</label>";      
              echo "<textarea name='comentario'></textarea>";      
              echo "<button type='submit' name='Comentar' class='btn btn-default' title='Haga clic aqui para comentar'> Comentar </button>";
              echo "</form>"; 
              echo "</div>";
              if (isset($_POST['Comentar'])){
                $sql = "INSERT INTO cp_comentarios (CasoId, Comentario,  Nuser, Fecha, Hora) 
                VALUES ('".$id."', '".$_POST['comentario']."', '".$nitavu."', '".$fecha."', '".$hora."')";
                if ($conexion->query($sql) == TRUE)
                    {
                      historia($nitavu,'cp_Comentar caso: '.$id.' Agrego el comentario: '.$_POST['comentario'].' ');
                      notificarParticipantes($id,$nitavu,'Se agrego un nuevo comentario al caso '.$id.'','Nuevos comentarios al caso '.$id);
                      // mensaje('Comentario Guardado correctamente','cp_nuevos_oficios.php?id="'.$_GET['id']);
                      unset($_POST['comentario'], $_POST['Comentar']);
                    }
                else {
                  mensaje('ERROR al guardar el comentario','cp_nuevos_oficios.php?id="'.$_GET['id']);
                }
              }
          
              // echo "<br><br>";
          echo "<div id='req_menu'>"; 
          if ($nivel==1 || soytitular($nitavu)!='FALSE' || ($nivel==3 and estaActivalaColaboracion($nitavu,$id)==0)){
            // echo $finalizado;
            echo "<b style='color:gray; font-size:10pt;'>* Actualmente lo tiene el Departamento ".dpto_id($turnadoami)."</b><br>";
          if($finalizado ==  0 and $turnadoami==$dpto){
              //BOTONES MENU
            
                echo "<a href='#modalTurnar' rel='modal:open' class='btn btn-default' title='Clic para turnar Caso'>";
                  echo "<table  width='100%'><tr ><td width=40px valign='middle' align='center'>";
                  echo "<img src='icon/turnar.png' style='width:30px; height:30px;'>";
                  echo "</td>";
                  echo "<td valign='middle'  align='center' style='color:white;' class=''>";
                  echo "Turnar Caso";
                  echo "</td></tr></table>";
                echo "</a>";	
                echo "<a href='#modalFinalizar' rel='modal:open' class='btn btn-secundario' title='Clic para finalizar el caso'>";
                  echo "<table  width='100%'><tr><td width=40px valign='middle' align='center'>";
                  echo "<img src='icon/correcto1.png' style='width:30px; height:30px;'>";
                  echo "</td>";
                  echo "<td valign='middle' align='center' style='color:white;' class=''>";
                  echo "Finalizar Caso";
                  echo "</td></tr></table>";
                echo "</a>";
                  
          
            }
          }   
        if ($nivel==1 || soytitular($nitavu)!='FALSE'){
          if($finalizado ==  0 and $turnadoami==$dpto){
          echo "<a href='#modalCompartir' rel='modal:open' class='btn btn-tercero' title='Clic para compartir el caso'>";
                  echo "<table  width='100%'><tr><td width=40px valign='middle' align='center'>";
                  echo "<img src='icon/compartir.png' style='width:30px; height:30px;'>";
                  echo "</td>";
                  echo "<td valign='middle' align='center' style='color:white;' class=''>";
                  echo "Compartir Caso";
                  echo "</td></tr></table>";
                echo "</a>";
            }
          } 
            echo "</div>";

        //MODAL PARA AGREGAR COLABORADORES
          echo "<div id='agregar_colaboradores' class='modal'>";
          echo "<form action='cp_nuevos_oficios.php?id=".$id."' method='POST'>";
          echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";
          echo "<span>";
          echo "<label for='empleado'>Seleccione con quien compartirá el caso:";
          echo "<select name='empleado'>";
          
            $sql = "SELECT * FROM empleados ORDER by nombre ASC";
            $r = $conexion -> query($sql);
            while($f = $r -> fetch_array())
              { // resultado de la busqueda.................
                echo "<option value='".$f['nitavu']."'>".$f['nombre']. " (".$f['puesto']." de ".$f['departamento'].")</option>";
              }
          
          echo "</select>";
          echo "</label>";
          echo "</span>";
          echo "<button type='submit' class='btn btn-default' title='Haga clic para subir el archivo'> Agregar </button>";
          echo "</form>"; 
          echo "</div>";


            //DIBUJAR GRÁFICA 
          echo "<br><br><br>";
          echo "<div id='peticiones'>";
            echo "<h1>Seguimiento de Documentos</h1>";
            $grafica = "SELECT count(*) as n from cp_historialdocumentos where numcaso = ".$id." and activo=0 ";
            // $grafica = "SELECT * from cp_historialdocumentos where numcaso = ".$id." and activo = 0 and tipo=0 ORDER BY idinc DESC";
            //echo $grafica;
            $fechas = fechas($id);
            $rc= $conexion -> query($grafica); 
            if($f = $rc -> fetch_array())
            { $count = $f['n'];} else {$count=0;}
            // echo $grafica;
            $tope = $count;
            if ($count>0){
                $grafica = "SELECT * from cp_historialdocumentos where NumCaso = ".$id." and activo=0  ORDER BY idinc DESC";
                //echo $grafica;
                $rc2= $conexion -> query($grafica); 
                // echo $grafica;
              //echo '<div class="grid-container" >';
              echo '<div class ="grid-container">';
                $vuelta = $tope;
                echo "<table>";
                echo "<tr>";
                while($r = $rc2 -> fetch_array())    
                {
                  //and ($vuelta!=3)
                  
                  if($vuelta == 1){

                      if($vuelta == $tope){
                        
                        //ULTIMO EN LA GRAFICA-INFORMACION DE QUIEN LO TIENE
                        echo '<th><div class ="grid-itemUltimo">
                        <div class="circulito" style="visibility:hidden;"> </div>';
                        echo '<div><b style="color: #fff; font-size: 8pt;">ACTUALMENTE EN</b><br>';
                        echo '<b style="color: #A2C30D">'.dpto_id($turnadoami).'</b><br>';
                        $sqlTiempo = "SELECT fecha as FechaDesde, 
                        (SELECT DATEDIFF(CURDATE(),FechaDesde)) as Retraso 
                        FROM cp_historialdocumentos WHERE NumCaso=".$id." order by idinc Desc limit 1";
                        $rc= $conexion -> query($sqlTiempo); 
                        //echo $sqlTiempo;
                        while($rT = $rc -> fetch_array()){
                          echo '<b style="color: #B1B1B1; font-size:6pt;">'.$rT['Retraso'].' días aquí.</b><br>';
                          
                        }	
                        if(ultimoColaborador($id) != 'FALSE'){
                          echo '<b style="color: #B1B1B1; font-size:6pt;">Ultimo colaborador: '.nitavu_nombre(ultimoColaborador($id)).'</b>';
                        }else{
                          if(personasConNivelUno($id) != 'FALSE'){
                            echo '<b style="color: #B1B1B1; font-size:6pt;">Ultimo colaborador: '.nitavu_nombre(personasConNivelUno($id)).'</b>';
                          }else{
                            if(buscoalTitulardelCaso($id) != 'FALSE'){
                              echo '<b style="color: #B1B1B1; font-size:6pt;">Ultimo colaborador: '.nitavu_nombre(buscoalTitulardelCaso($id)).'</b>';
                            }else{
                              echo '<b style="color: #B1B1B1; font-size:6pt;">No definido</b>';
                            }
                          }
                        }
                        
                        echo ' </div></div></th>';
                        echo '<th><div class ="grid-flecha"><img src="icon/flecha.png" style="width: 60px;" "></div></th>';
                      }
                    

                      //------------------------------------------

                    

                      echo '<th><div class ="grid-item1">
                      <div class="circulito">
                      '.$vuelta.'
                      </div>
                      <div><b style="color: #fff; font-size: 8pt;">'.$r['numOficio'].'</b><br>
                      <b style="color: #A2C30D">'.nombreDepartamento($r['dptoSube']).'</b><br>
                      <b style="color: #B1B1B1; font-size:6pt;">'.fecha_larga($r['fecha']).' <br>- por '.nitavu_nombre($r['nitavuSube']).'</b>
                      ';
                      
                      if ($r['activo']=='1'){
                        echo "<b style='color:#FFCCCC; font-size:7pt;'><br>* Se marco como eliminado un <a href='' style='text-decoration: none; color: chartreuse; 'title='".$r['archivo']."'>archivo "."</a></b> ";
                      }
                      echo ' </div></div></th>';

                  
                  
                    
                }else if($vuelta == $tope){
                    $dias = diastranscurridos($id);

                    //ULTIMO EN LA GRAFICA-INFORMACION DE QUIEN LO TIENE
                    echo '<th><div class ="grid-itemUltimo">
                    <div class="circulito" style="visibility:hidden;"> </div>';
                    echo '<div><b style="color: #fff; font-size: 8pt;">ACTUALMENTE EN</b><br>';
                    echo '<b style="color: #A2C30D">'.dpto_id($turnadoami).'</b><br>';
                    $sqlTiempo = "SELECT fecha as FechaDesde, 
                    (SELECT DATEDIFF(CURDATE(),FechaDesde)) as Retraso 
                    FROM cp_historialdocumentos WHERE NumCaso=".$id." order by idinc Desc limit 1";
                    $rc= $conexion -> query($sqlTiempo); 
                      while($rT1 = $rc -> fetch_array()){
                        echo '<b style="color: #B1B1B1; font-size:6pt;">'.$rT1['Retraso'].' días aquí.</b><br>';
                        
                      }	
                    if(ultimoColaborador($id) != 'FALSE'){
                      echo '<b style="color: #B1B1B1; font-size:6pt;">Ultimo colaborador: '.nitavu_nombre(ultimoColaborador($id)).'</b>';
                    }else{
                      if(personasConNivelUno($id) != 'FALSE'){
                        echo '<b style="color: #B1B1B1; font-size:6pt;">Ultimo colaborador: '.nitavu_nombre(personasConNivelUno($id)).'</b>';
                      }else{
                        if(buscoalTitulardelCaso($id) != 'FALSE'){
                          echo '<b style="color: #B1B1B1; font-size:6pt;">Ultimo colaborador: '.nitavu_nombre(buscoalTitulardelCaso($id)).'</b>';
                        }else{
                          echo '<b style="color: #B1B1B1; font-size:6pt;">No definido</b>';
                        }
                      }
                    }
                      
                    echo ' </div></div></th>';
                    echo '<th><div class ="grid-flecha"><img src="icon/flecha.png" style="width: 60px;" "></div></th>';


                  // echo '<th><div class ="grid-flecha"><img src="icon/flecha.png" style="width: 60px;" "></div></th>';
                  //--------------------------------------------------------------------
                  
                      echo '<th><div class ="grid-item1">
                      <div class="circulito">
                      '.$vuelta.'
                      </div>
                      <div><b style="color: #fff; font-size: 8pt;">'.$r['numOficio'].'</b><br>
                      <b style="color: #A2C30D">'.nombreDepartamento($r['dptoSube']).'</b><br>
                      <b style="color: #B1B1B1; font-size:6pt;">'.$r['fecha'].' <br>- por '.nitavu_nombre($r['nitavuSube']).'</b>
                      ';
                      
                      if ($r['activo']=='1'){
                        echo "<b style='color:#FFCCCC; font-size:7pt;'><br>* Se marco como eliminado un <a href='' style='text-decoration: none; color: chartreuse; 'title='".$r['archivo']."'>archivo "."</a></b> ";
                      }
                      echo '

                      </div>
                      </div></th>';
                      $datetime1 = new DateTime($fechas[$vuelta-1]);
                      $datetime2 = new DateTime($fechas[$vuelta-2]);
                      $interval = $datetime1->diff($datetime2);
                      echo '<th><div class ="grid-flecha"><img src="icon/flecha.png" style="width: 60px;" title="Transcurrio '.$interval->format('%d días').' de la última subida""></div></th>';
                    }else{
                      
                      echo '<th><div class ="grid-item1">
                      <div class="circulito">
                      '.$vuelta.'
                      </div>
                      <div><b style="color: #fff; font-size: 8pt;">'.$r['numOficio'].'</b><br>
                      <b style="color: #A2C30D">'.nombreDepartamento($r['dptoSube']).'</b><br>
                      <b style="color: #B1B1B1; font-size:6pt;">'.$r['fecha'].' <br>- por '.nitavu_nombre($r['nitavuSube']).'</b>
                      ';
                      
                      if ($r['activo']=='1'){
                        echo "<b style='color:#FFCCCC; font-size:7pt;'><br>* Se marco como eliminado un <a href='' style='text-decoration: none; color: chartreuse; 'title='".$r['archivo']."'>archivo "."</a></b> ";
                      }
                      echo '

                      </div>
                      </div></th>';
                      $datetime1 = new DateTime($fechas[$vuelta-1]);
                      $datetime2 = new DateTime($fechas[$vuelta-2]);
                      $interval = $datetime1->diff($datetime2);
                      echo '<th><div class ="grid-flecha"><img src="icon/flecha.png" style="width: 60px;" title="Transcurrio '.$interval->format('%d días').' de la última subida""></div></th>';
                    }

                  $vuelta --;
                }
              
                echo "</tr>";
                echo "</table>";
              }  
            echo "</div>"; 
          echo "</div>";

          //ESTRUCTURA DE DIVS
          // echo "<div id='bloque'>";   
          // echo "<div class='tituloHistorial'>";
          //   echo "<h1>Historial de Documentos</h1>";
          // echo "</div>";
          // echo "<div class='tituloHistoriaCaso'>";
          //  echo "<h1>Actividad del caso</h1>";
          // echo "</div>";
          // echo "</div>";

          
            echo "<div id='bloque'>";  
          echo "<div class='tablaHistorial' style='background-color: #f7ffdc;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            width: 101%;
            border: 1px solid #dae89d;'>";
          //Filtro de si soy colaborador y soy del departamento entonces solo puedo agregar anexos.
          



          $sql = "SELECT * FROM cp_historialdocumentos WHERE numcaso=".$id." and tipo=0";
          $rc= $conexion -> query($sql); 
          if ($rc->num_rows>0){
            echo "<h1>Historial de archivos</h1>";
            echo "<table id='historialTabla' class='tabla' >";
            echo "<th class='pc'>Oficio Número</th>";
            echo "<th >Nombre Archivo</th>";
            echo "<th class='pc'>Fecha</th><th class='pc'></th>";
            
            //echo "<th style='width:10%'></th>";
            while($r = $rc -> fetch_array())    
            {
              if ($r['activo']=='1') { // si esta inactivo
                echo "<tr style='background-color:red; '>";
              } else {
                echo "<tr>";
              }

              
              echo "<td class='pc'>".$r['numOficio'];
              if ($r['activo']=='1'){
                echo "<span style='font-size:7pt;'><br>* Este archivo ha sido marcado como eliminado</span>";
              }
              echo "</td>";
              $archivo = "peticiones/".$r['idDoc'].'_'.$r['NumCaso'].'_'.$r['archivo']."";
              //href='cp_descarga_archivo.php?ruta=".$archivo."'
              //echo $archivo; 
              $link = "<a id=".$r['idDoc']." name='$archivo' href='cp_descargar.php?nombre=".$archivo."' target='_self'  class='digitalizados_vinculos' onclick =''  title='Haga click aqui para descargar'>".$r['archivo']."</a>";
              echo "<td >".$link;
              //echo $archivo; 
              echo "<span style='font-size:7pt;'>por ".nitavu_nombre($r['nitavuSube'])." de ".nitavu_dpto_nombre($r['nitavuSube'])."</span>";
              echo "</td>";//archivo

              echo "<td class='pc' style='font-family:Compacta;font-size:12px;'>".$r['fecha']." | ".hora12($r['hora'])."</td>";

              if(($r['nitavuSube']==$nitavu) and (estaFinalizadoCaso($r['NumCaso'])==0) and $r['activo']<>'1' and $r['archivo']<>""){
                echo "<td class='pc'>";
                echo "<form action='cp_nuevos_oficios.php?id=".$id."' method='POST'>";
                echo '<input type="hidden" name="id" value='.$id.'>';
                echo '<input type="hidden" name="idDoc" value='.$r['idDoc'].'>';
                echo '<input type="hidden" name="numDoc" value='.$r['numOficio'].'>';
                echo "<button type='submit' class='btn btn-cancel' title='Haga clic para eliminar el archivo'> <img src='icon/delete.png' style='width:20px; '> </button>";
                echo "</form>";
                echo "</td>";
              }
            }
            
          }

        echo '</tr>';
        $arr = revisarMisColaboraciones($nitavu);
        $dibuje=0;
        for ($i=0; $i < count($arr) ; $i++) {
            if(($nivel==3 and estaActivalaColaboracion($nitavu,$id)==0 and $dibuje==0) || ((soyColaborador($nitavu)=='TRUE') and (soyDptoturnado($arr[$i] ,$dpto)=='FALSE') and $dibuje==0) 
            || (soyDptoturnado($id,$dpto)=='TRUE') and $dibuje==0 ){

            //if( ($nivel==1 and $dibuje==0) || ($nivel==2 and $dibuje==0) || ($nivel==3 and estaActivalaColaboracion($nitavu,$id)==0 and $dibuje==0)|| (soytitular($nitavu)!='FALSE'  and $dibuje==0) || ((soyColaborador($nitavu)=='TRUE') and (soyDptoturnado($arr[$i] ,$dpto)=='FALSE') and $dibuje==0) ){
              if($finalizado ==0){
                $dibuje=1;
                echo '<tr class="pc">';
                echo "<form action='cp_nuevos_oficios.php?id=".$id."' method='POST' enctype='multipart/form-data'>"; 
                echo '<input type="hidden" name="id" value='.$id.'>';
                echo '<input type="hidden" name="subirHistorial" value="1">';
                echo '<td>';
                  
                  echo "<input type='text' id='oficioNombre' name='oficioNombre'>";
                  echo "<input type='hidden' name='idCaso' value= ".$id.">";
                /*echo "<table>";
                echo "<tr>";
                echo "<td>";
                //echo '<input name="oficioNombre" type="text" required>';
                $dpto = nitavu_dpto($nitavu);
                echo "<select id='oficioNombre' name='oficioNombre' required>";
                echo "<option value='' disabled selected>Seleccione un asunto...</option>";
                $sql = "SELECT * FROM cp_controlcorrespondencia WHERE IdDptoCrea=".$dpto." and Utilizado = 0 and NumDocumento <> '' ORDER BY FechaCrea ";
                // echo $sql;
                $r = $conexion -> query($sql);
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................
                  echo "<option value='".$f['NumDocumento']."'>".$f['NumDocumento']. "</option>";
                }
                echo "</select>";
                echo "</td>";
                echo "<td>";
                echo "<a href='#myModalaAgregar' rel='modal:open' class='btn btn-default' title='Nuevo Número'> <img src='icon/nuevoNumero.png'  style='width:20px; '> </a>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";*/
                echo '</td>';
                echo '<td>';
                  echo '<input name="nuevoDoc" type="file" accept=".pdf">';
                echo '</td>';
                echo '<td>';
                  echo '<input type="date" id="fechaOficio" name="fechaOficio" value='.$fecha.' required>';
                //echo '<input type="hidden" id="fechaOficio" name="fechaOficio" value='.$fecha.' required>';
                echo '</td>';
                echo "<td><button type='submit' class='btn btn-default' title='Haga clic para subir el archivo'> <img src='icon/subirDoc.png' style='width:20px; '> </button></td>";
                echo "</form>";
                echo '</tr>';    
              }
            }
          
            
          
        }
        echo "</table>";
        echo "</div>";
        echo "<br><br>";
        

        echo "<div id='anexos'>";
                                                                                                                                                                                                                                                                  
        $anexos = "SELECT * FROM cp_historialdocumentos WHERE numcaso=".$id." and tipo=1";
        $rc= $conexion -> query($anexos); 
        if ($rc->num_rows>0){
          echo "<center>";
          echo "<div style='width:100%;' id='divAnexos'>";
          echo "<h1>Anexos</h1>";
          echo "<table id='historialTabla' class='tabla' style=''>";
          echo "<th>Nombre Archivo</th>";
          echo "<th>Fecha</th>";
          
          //echo "<th style='width:10%'></th>";
          while($r = $rc -> fetch_array())    
          {
            if ($r['activo']=='1') { // si esta inactivo
                echo "<tr style='background-color:red; '>";
              } else {
                echo "<tr>";
              }
              
                $archivo = "peticiones/".$r['idDoc'].'_'.$r['NumCaso'].'_'.$r['archivo']."";
                //href='cp_descarga_archivo.php?ruta=".$archivo."' 
                $link = "<a id=".$r['idDoc']." name='$archivo' href='cp_descargar.php?nombre=".$archivo."' target='_self'  class='digitalizados_vinculos' onclick =''  title='Haga click aqui para descargar'>".$r['archivo']."</a>";
                echo "<td>".$link;
                echo "<span style='font-size:7pt;'>por ".nitavu_nombre($r['nitavuSube'])." de ".nitavu_dpto_nombre($r['nitavuSube'])."</span>";
                echo "</td>";//archivo
              
            
            echo "<td style='font-family:Compacta;font-size:15px;'>".$r['fecha']."</td>";
            
            // if(($r['nitavuSube']==$nitavu) and (estaFinalizadoCaso($r['NumCaso'])==0 and $r['activo']<>'1')){
            //  echo "<td>";
            //   echo "<form action='cp_nuevos_oficios.php?id=".$id."' method='POST' enctype='multipart/form-data'>";
            //   echo '<input type="hidden" name="id" value='.$id.'>';
            //   echo '<input type="hidden" name="idDoc" value='.$r['idDoc'].'>';
            //   echo '<input type="hidden" name="numDoc" value='.$r['numOficio'].'>';
            //   echo "<button type='submit' class='btn btn-cancel' title='Haga clic para eliminar el archivo'> <img src='icon/delete.png' style='width:20px; '> </button>";
            //   echo "</form>";
            //   echo "</td>";
            // }
            if(($r['nitavuSube']==$nitavu) and (estaFinalizadoCaso($r['NumCaso'])==0) and $r['activo']<>'1' and $r['archivo']<>""){

                echo "<td class='pc'>";
                echo "<form action='cp_nuevos_oficios.php?id=".$id."' method='POST'>";
                echo '<input type="hidden" name="id" value='.$id.'>';
                echo '<input type="hidden" name="idDoc" value='.$r['idDoc'].'>';
                echo '<input type="hidden" name="numDoc" value='.$r['numOficio'].'>';
                echo "<button type='submit' class='btn btn-cancel' title='Haga clic para eliminar el archivo'> <img src='icon/delete.png' style='width:20px; '> </button>";
                echo "</form>";
                echo "</td>";
              }
            echo "</tr>";
          }
        echo "</table>";

        echo "</div>";
        echo "</center>";
        }

        if (estaFinalizadoCaso($_GET['id'])==0){
        //if (($nivel==1 and $finalizado==0) || (soytitular($nitavu)!='FALSE' and $finalizado==0) || (soyColaborador_caso($id,$nitavu) and soyDptoturnado($id,$dpto))){
          
          if(($nivel==3 and estaActivalaColaboracion($nitavu,$id)==0 ) || ((soyColaborador($nitavu)=='TRUE') and (soyDptoturnado($id,$dpto)=='FALSE')) 
          || (soyDptoturnado($id,$dpto)=='TRUE') ){
          
          echo "<a href='#agregar_anexos' style='width:150px;' rel='modal:open' class='digitalizados_vinculos btn btn-tercero' title='Clic para agregar anexos' >";
          echo "Agregar anexos";
          echo "</a><br><br>";  
        }}
        echo "</div>";
                
            echo "</div>"; //cierra div historia caso


              echo "<div class='historiaCaso'>";
              echo "<h1>Historia del Caso:</h1>";
              // $sql = "SELECT empleados.nombre,historia.fecha, historia.hora, 'Entró a ver el historial del caso' as actividad
              // from historia
              // right join empleados on empleados.nitavu=historia.nitavu WHERE
              // historia.descripcion like  '%Entró a ver el historial del caso: ".$id."%'  
              // UNION  
              
              // select empleados.nombre, cp_historialdocumentos.fecha,cp_historialdocumentos.hora, 
              // CONCAT('Agregó el archivo: \"',cp_historialdocumentos.archivo,'\".')  as actividad
              // from cp_historialdocumentos 
              // inner join empleados   on empleados.nitavu=cp_historialdocumentos.nitavusube 
              // where cp_historialdocumentos.numcaso = ".$id." order by  hora desc";
              if (isset($_GET['histoall'])){
                $sql = "
                select 
                nitavu as Nuser,
                (select nombre from empleados where nitavu=Nuser) as nombre,
                descripcion as actividad,
                
                historia.* from historia
          
                where
                
                descripcion like 'cp%' and 
                descripcion like '%caso: ".$id."%' 
                ";
              } else {
                $sql = "
              select 
              nitavu as Nuser,
              (select nombre from empleados where nitavu=Nuser) as nombre,
              descripcion as actividad,
              
              historia.* from historia

              where
              
              descripcion like 'cp%' and 
              descripcion like '%caso: ".$id."%' 
              limit 10
              ";
              }
              


              // echo $sql;
                
              $r = $conexion -> query($sql);
              echo "<div id='r' style='border: 0px; '>";
                $cont=0;
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................
              
              
                echo "<div id='resultado_elemento'  style='margin-left:-5px;'>";			 
                echo "<table border='0'>";
                echo "<tr>";										
                        
                    // DATOS OFICIO ENTRANTE
                    echo "<td width='90%' class='tipo_nitavu'>";								
                    echo "<table border='0'>";
                    echo "<tr>";							
                    echo "<td>";
                    echo "<span class='normal tchico'>".$f['nombre']."</span>";
                    echo "<span class='tchico'><br>".fecha_larga(date_format( date_create($f['fecha']), 'Y-m-d'))." </span>";
                    echo "<span class='tchico tenue'><br>".$f['actividad']."</span>";
                    
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";						
                    echo "</td>";							  
                echo "</tr></table>";
                echo "</div>";				
                }
                echo "</div>";	
            echo "</div>"; 

            if (isset($_GET['histoall'])){
            } else {echo "<a class='btn btn-tercero' style='color:white; font-weight:bold;' href='?histoall=&id=".$_GET['id']."'>Ver el historial completo...</a>";}

        //cierra div bloque.
        echo "</div>";

          //MODAL PARA AGREGAR ANEXOS
          echo "<div id='agregar_anexos' class='modal'>";
          echo "<form action='cp_nuevos_oficios.php?id=".$id."' method='POST'  enctype='multipart/form-data'>";
          echo "<label>Seleccione los archivos que se van a agregar como anexos</label>";
          echo '<input type="hidden" name="Newanexos" value="1">';
          echo '<input id="archivo[]" name="archivo[]" type="file" accept=".pdf" multiple="" required>';
          echo "<button type='submit' class='btn btn-default' title='Haga clic para subir el archivo'> Subir archivos </button>";
          echo "</form>"; 
          echo "</div>";
          
            //Subir archivo en el historial
          if(isset($_POST['subirHistorial'])  and isset($_POST['id'])){
            $id=$_POST['id'];
            if(!empty($_FILES['nuevoDoc']['name']) != null){
              $nombreOficio = $_POST['oficioNombre'];
              $idDocumento = $_POST['id'];
              $numDocumento = numdeDocumento(TRUE);
              $doc = $_FILES["nuevoDoc"]["name"];
              $tmp =$_FILES["nuevoDoc"]["tmp_name"];
              $fecha=$_POST['fechaOficio'];
              $midpto = nitavu_dpto($nitavu);
              $archivo1 = "peticiones/".$numDocumento.'_'.$idDocumento.'_'.$doc."";
              $subida1 = FTP_subir($tmp,$archivo1);
              if ($subida1 == "TRUE"){
                $sql = "INSERT INTO cp_historialdocumentos(idInc, idDoc, NumCaso, archivo, fecha, nitavuSube, dptoSube, dptoEnviar, numOficio,hora) 
                VALUES ('', '$numDocumento', '$idDocumento', '$doc', '$fecha', '$nitavu', '$midpto','$midpto','$nombreOficio','$hora')";
                if ($conexion->query($sql) == TRUE){ 
                  //$sql3 = "UPDATE cp_controlcorrespondencia SET utilizado=1 WHERE numdocumento='".$nombreOficio."'";
                  //if ($conexion->query($sql3) == TRUE){
                    historia($nitavu,'cp_Subi un archivo al historial del caso: '.$idDocumento.' archivo:'. $doc);
                    numdeDocumento(FALSE); 

                    notificarParticipantes($id,$nitavu,'El '.$nombreOficio.' se ha agregado al caso','');

                    mensaje('Se ha subido el archivo con éxito.','cp_nuevos_oficios.php?id='.$id.'');  
                  //}else{
                    //mensaje('Hubo un error al momento de subir el archivo, por favor vuelva a intentarlo.','cp_nuevos_oficios.php?id='.$id.'');
                  //}      
                }else{
                  mensaje('Hubo un error al momento de subir el archivo, por favor vuelva a intentarlo.','cp_nuevos_oficios.php?id='.$id.'');
                }
              }else{
                mensaje('Ocurrio un error al momento de subir el archivo.','cp_nuevos_oficios.php?id='.$id.'');   
              }
            }else{
              mensaje('No ha seleccionado ningun archivo.','cp_nuevos_oficios.php?id='.$id.'');
            }
          }
          //ELIMINAR UN ARCHIVO DEL HISTORIAL DE DOCUMENTOS
          if(isset($_POST['idDoc'])){
            $idDoc = $_POST['idDoc'];
            $id = $_POST['id'];
            $numDoc = $_POST['numDoc'];
            $sql = "UPDATE cp_historialdocumentos SET activo=1 WHERE idDoc=".$idDoc."";
            if ($conexion->query($sql) == TRUE){
              historia($nitavu,'cp_Elimine (marco como eliminado) el archivo con id: '.$idDoc.' del caso: '.$id);

              mensaje('Se ha eliminado con éxito el archivo.','cp_nuevos_oficios.php?id='.$id.''); 
              //CAMBIO EL ESTADO DEL OFICIO 
              $sql3 = "UPDATE cp_controlcorrespondencia SET Utilizado=0 WHERE NumDocumento='".$numDoc."'";
              if ($conexion->query($sql3) == TRUE){
                return TRUE;
              }else{
                return FALSE;
              }
            }else{
              mensaje('Ocurrio un error al momento de eliminar, por favor intentelo de nuevo.','cp_nuevos_oficios.php?id='.$id.''); 
            }
          }
          
          //SUBIR ANEXOS
          if(isset($_POST['Newanexos'])){
            
            $midpto = nitavu_dpto($nitavu);
            //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
            foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name){
                //Validamos que el archivo exista
                if($_FILES["archivo"]["name"][$key]){
                  $numDocumento = numdeDocumento(TRUE);
                  $doc = $_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo
                  $tmp = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                  
                  //$directorio = 'docs/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                  $archivo1 = "peticiones/".$numDocumento.'_'.$id.'_'.$doc."";
                  $subida1 = FTP_subir($tmp,$archivo1);
                
                  if ($subida1 == "TRUE"){
                    $sql = "INSERT INTO cp_historialdocumentos(idinc, iddoc, numcaso, archivo, fecha, nitavusube, dptosube, dptoenviar, numoficio,activo, tipo,hora) 
                    VALUES ('', '$numDocumento', '$id', '$doc', '$fecha', '$nitavu', '$midpto','','Anexo',0,1,'$hora')";
                    if ($conexion->query($sql) == TRUE){ 
                      historia($nitavu,'cp_Subi archivos a los anexos del caso: '.$id .' archivo: '.$doc);
                      numdeDocumento(FALSE);
                      notificarParticipantes($id,$nitavu,'El '.$doc.' se ha agregado como anexo al caso','');
                      mensaje('Se ha subido el archivo con éxito.','cp_nuevos_oficios.php?id='.$id.'');  
                    }else{
                      mensaje('Hubo un error al momento de subir los archivos, por favor vuelva a intentarlo.','cp_nuevos_oficios.php?id='.$id.'');
                    }      
                  }else{
                    mensaje('Hubo un error al momento de subir los archivos, por favor vuelva a intentarlo.','cp_nuevos_oficios.php?id='.$id.'');
                  }
                }
                  
              }
              
          }

        //MODAL SOLICITAR NUEVO NÚMERO
        echo "<div id='myModalaAgregar' class='modal' >";  
        echo '<form action="cp_numNuevoDocumento_db.php" method="POST">';
          
        // echo "<label class='tituloModal' id='tituloModal'> NUEVO NÚMERO DE DOCUMENTO";         
        // echo "</label>";        
        echo "<h3>Nuevo Número De Documento </h3>"; 

        echo "<div >";
          echo "<label for='tipoDocumento' class='label'>Tipo del Documento:";
          echo "<select name='tipoDocumento'     style='margin-left: 0px;'>";	
          echo '<option value="0" selected="selected">Seleccione</option>';		
          $sql = "select * from cat_tipo_documento";			
            $r = $conexion -> query($sql);		 
            while($f = $r -> fetch_array())
            { 
              echo "<option value='".$f['IdTipoDocumento']."'>".$f['TipoDocumento']. " </option>";
            }				
          echo "</select>";
          echo "</label>";
        echo "</div>";
          
        echo "<div>";
          echo "<label for='departamento' class='label'>Departamento:";
          echo "<select name='departamento'   id='departamento'   style='margin-left: 0px;'>";	
          echo '<option value="0" selected="selected">Seleccione </option>';		
          echo '<option value="100" >Fuera del Instituto </option>';
          $sql="SELECT	cat_gerarquia.id ,	cat_gerarquia.titular ,	cat_gerarquia.nombre,	cat_gerarquia.dependencia
                  FROM	cat_gerarquia where (id <>".nitavu_dpto($nitavu).") ORDER BY cat_gerarquia.nombre ";
            $r = $conexion -> query($sql);		 
            while($f = $r -> fetch_array())
            { 
              echo "<option value='".$f['id']."'>".$f['nombre']. " </option>";
            }	
                  
          echo "</select>";
        
          echo "</label>";
        echo "</div>";
        echo "<span id='spanDestinatario' style='Width=100%'>";
          echo "<label for='destinatario'>Destinatario</label>";
          echo "<input type='text' id=destinatario' name='destinatario' placeholder='Nombre a quien va dirigido el documento'   required>";
          echo "<label for='puesto'>Puesto</label>";
          echo "<input type='text' id=puesto' name='puesto' placeholder='Puesto de la persona a quien va dirigido el documento'   required>"; 
        echo "</span>";			
        
        echo "<label for='asunto'>Asunto</label>";
        echo "<input type='text' id=asunto' placeholder='Asunto'  name='asunto'  required  >";
          
        echo "<label for='observaciones'>Observaciones</b>:";
        echo "<textarea name='observaciones'style='border-width:1px; height:20%' ></textarea>";
        echo "<input type='submit' value='Solicitar' class='btn btn-default btnAlta' name='btnSolicitar'>";

        echo "</form>";
        echo " </div>";    
        echo "</div>";
          
  } else {mensaje("ERROR: no tienes permiso o no has participado en este Ticket.","cp_controldocumental.php");}
} else

{
  echo "<br><br>";
  mensaje("ERROR: No tiene acceso al Módulo para Control Documental (".$id_aplicacion.")", "./index.php");
}

?>
<script>


function AgregarColaboradores(numcaso,usuario){   
  $("#preloaderbloque").css({'display':'inline-block',});
  $("#bloque1").css({'display':'none'});
  $.ajax({
    async:true,    
    cache:false,   
    dataType:"html",
    url: "cp_colaboradores.php",
    type: "post",   
    data: { numcaso: numcaso,nitavu: usuario },
    success: function(data){
    $("#preloaderbloque").css({'display':'none'});
    $("#bloque1").css({'display':'inline-block'});
    $('#bloque1').html(data+"\n");
    location.reload();
      
    }
  });
}
function QuitarColaboradores(numcaso,usuario){   

   
$("#preloaderbloque").css({'display':'inline-block',});
$("#bloque1").css({'display':'none'});
$.ajax({
 
  url: "cp_empleados.php",
 type: "post", 

 data: { numcaso: numcaso,nitavu: usuario },
 success: function(data){
  $("#preloaderbloque").css({'display':'none'});
  $("#bloque1").css({'display':'inline-block'});

  $('#bloque1').html(data+"\n");
 
  

 }
});}
//lo que va hacer cuando se de click sobre empleados
/*
function AgregarColaboradores(numcaso,usuario){   
  $("#preloaderCol").css({'display':'inline-block',});
  $("#divColaboradores").css({'display':'none'});
  $.ajax({
    async:true,    
    cache:false,   
    dataType:"html",
    url: "cp_colaboradores.php",
    type: "post",   
    data: { numcaso: numcaso,nitavu: usuario },
    success: function(data){
    $("#preloaderCol").css({'display':'none'});
    $("#divColaboradores").css({'display':'inline-block'});
    $('#divColaboradores').html(data+"\n");
      
    }
  });

  $("#preloaderEmp").css({'display':'inline-block',});
  $("#divEmpleados").css({'display':'none'});
  $.ajax({
    async:true,    
    cache:false,   
    dataType:"html",
    url: "cp_empleados.php",
    type: "post",   
    data: { numcaso: numcaso,nitavu: '' },
    success: function(data){
      $("#preloaderEmp").css({'display':'none'});
      $("#divEmpleados").css({'display':'inline-block'});
      $('#divEmpleados').html(data+"\n");
    }
  });
}



function QuitarColaboradores(numcaso,usuario){   

   
$("#preloaderEmp").css({'display':'inline-block',});
$("#divEmpleados").css({'display':'none'});
$.ajax({
 
  url: "cp_empleados.php",
 type: "post", 

 data: { numcaso: numcaso,nitavu: usuario },
 success: function(data){
  $("#preloaderEmp").css({'display':'none'});
  $("#divEmpleados").css({'display':'inline-block'});

  $('#divEmpleados').html(data+"\n");
 
  

 }
});
$("#preloaderCol").css({'display':'inline-block',});
   $("#divColaboradores").css({'display':'none'});
   $.ajax({
    
	   url: "cp_colaboradores.php",
	  type: "post",     
	  data: { numcaso: numcaso,nitavu: '' },
	  success: function(data){
	   $("#preloaderCol").css({'display':'none'});
     $("#divColaboradores").css({'display':'inline-block'});

	   $('#divColaboradores').html(data+"\n");
     
	  }
   });
 console.log("ejecutando");
}*/

 var id=0;
function ModalSolicitar()
{
     // Obtenemos el modal 
     modal = document.getElementById("myModalaAgregar"); 
      
      //Agregamos al divconetenedor el un input que almacena el Id que seleccionó
    // document.getElementById("contenedor").innerHTML = ["<input type=hidden id=idconcepto   name=idconcepto value="+id+">"]; 
      
     // Get the <span> element that closes the modal  
      span = document.getElementsByClassName("close")[0];        
     
    
     //Hacer visible el modal
      modal.style.display = "block";
     
     // When the user clicks on <span> (x), close the modal
     span.onclick = function() 
     {
      
       modal.style.display = "none";
     }
}
        $(document).on("change", "#departamento", function(event) {
     
		//alert($("#departamento option:selected").val());
		ShowDestinatario($("#departamento option:selected").val());
        });              
function ShowDestinatario(id) 
{
 
  if (id=="") {
    document.getElementById("spanDestinatario").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("spanDestinatario").innerHTML=this.responseText;
     
    }
  }
  xmlhttp.open("GET","cp_consultaDestinatario.php?id="+id,true);
  xmlhttp.send();
}





  </script>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<?php include ("./unica/body_footer.php"); ?>