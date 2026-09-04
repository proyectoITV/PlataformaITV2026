<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php");?>
<link rel="stylesheet" href="lib/plataforma_modern.css" />

<script>
  $(document).on("change", "#asunto", function(event) {
  //$("#numeroSeleccionado").val($("#asunto option:selected").text());
  $("#numeroSeleccionado").val($("#asunto option:selected").val());
  //document.getElementById("contenedor").innerHTML = ["<input type=hidden id=numeroOficio   name=numeroOficio value="+num+">"]; 
  });   

</script>

<?php
require("config.php");
$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap66";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if(isset($_GET['enproceso'])){
    
  $idcaso = $_GET['enproceso'];           

  $sql = "Update cp_nuevosdocumentos set 
      Estado=2
      where id = ".$idcaso;
      if ($conexion->query($sql) == TRUE){ 
          mensaje('Se marco este caso EN PROCESO DE ATENCION','cp_nuevos_oficios.php?id='.$idcaso);    
      }else{
          mensaje('Ocurrio un error al intentar esta acción, favor de intentarlo nuevamente.','cp_nuevos_oficios.php?id='.$idcaso);
      }           
}




if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{ //PARA DAR ACCESO CUANDO ESTE REGISTRADA
  echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
 
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
            echo "<div id='modalTurnar' class='MyModal'>";
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
                    echo "<td style='width:10%;'><a href='#myModalaAgregar' rel='MyModal:open' class='Mbtn btn-default' title='Nuevo Número'>
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
                echo '<label><input type="checkbox" id="compartir" name="compartir" value="Compartir">Seguir compartiendo <br><i>(Al marcar esta opción permites que las personas con las que esta compartido el caso, lo sigan viendo)</i></label>';
              echo "</div>";
              
              echo '<input name="contestacion" type="file" accept=".pdf">';
              echo "<button type='submit' class='Mbtn btn-danger' title='Haga clic para subir el archivo'> Turnar caso </button>";
            echo "<br><br>";
            echo "</form>";
            echo "</div>";

            //PARA FINALIZAR EL CASO
            echo "<div id='modalFinalizar' class='MyModal'>";
              echo "<form action='cp_controldocumental.php' method='POST'>";
                echo "<h3 style='color:#575A5D'>Finalizar Caso</h3>";
                echo "<input type='hidden' name='id' value=".$id.">";
                echo "<label style='color: brown;'><b>Descripción del caso:</b></label><br>";
                echo "<label>".traerDescripcionCaso($id)."</label><div style='width:80%;' center><hr ></div>";
               // echo "<textarea style='height:20%;' name='desc' readonly>".traerDescripcionCaso($id)."</textarea>";
                echo "<br><label style='color: brown;'><b>Comentario Final</b></label><br>";
                echo "<label ><b>Puede agregar información sobre la atención del caso en caso de considerarlo necesario</b></label><br>";
                echo "<textarea style='height:20%;  width:85%; font-size: 14;' name='comSolucionar' required>Atendido</textarea>";
                echo "<br><br>";
                echo "<button type='submit' class='Mbtn btn-danger' title='Haga clic para terminar el caso'>Registrar</button>";
              echo "</form>";
            echo "</div>";

        //PARA COMPARTIR EL CASO
        echo "<div id='modalCompartir' class='MyModal'>";
        echo "<form action='cp_controldocumental.php' method='POST'>";
          echo "<h3 style='color:#575A5D'>Compartir Caso</h3>";
            echo "<div id='preloaderbloque' style='display: none; width:100%'>";
            echo "<img src='img/cargando2.gif' style='width: 50%; height:10%;' class='cargando_img'>";
            echo "</div>"; 
            echo "<div id='bloque1' style='width:100%'>"; 
            echo "<div id='bloque' style='height:60px;'>";   
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
              and empleados.nitavu <> ".$nitavu." and empleados.estado = ''
        UNION
              SELECT empleados.nombre, empleados.departamento, empleados.puesto, empleados.nitavu, 'no'
              FROM empleados 
              WHERE empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$id." and activo = 0)
              and empleados.nitavu not in(SELECT titular from cat_gerarquia)  
              and empleados.dpto in (".misdptos(directorJuridico()).")
              and empleados.nitavu <> ".$nitavu." and empleados.estado = ''
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
                and  empleados.nitavu<>".$nitavu." and empleados.nitavu<>".titular(nitavu_dpto($nitavu))." and permisos.idapp='ap66' and empleados.estado = ''
                union select empleados.nombre, empleados.departamento, empleados.puesto, empleados.nitavu, 'no'
                from empleados inner join aplicaciones_permisos as permisos on permisos.nitavu=empleados.nitavu
                where empleados.dpto=".nitavu_dpto($nitavu)." and empleados.nitavu<>".titular(nitavu_dpto($nitavu))."
                and  empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$id." and activo=0) 
                and  empleados.nitavu<>".$nitavu." and permisos.idapp='ap66' and empleados.estado = '' order by nombre asc";
                }else
                {$query="-- cp
                  SELECT DISTINCT empleados.nombre, cat_gerarquia.nombre as departamento, empleados.puesto, empleados.nitavu, cat_gerarquia.titular FROM empleados 
                  inner join cat_gerarquia on empleados.nitavu=cat_gerarquia.titular
                  inner join aplicaciones_permisos as permisos on permisos.nitavu=empleados.nitavu
                  and  empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$id.") 
                  and  empleados.nitavu<>".$nitavu." and permisos.idapp='ap66' and empleados.estado = ''
                  union select empleados.nombre, empleados.departamento, empleados.puesto, empleados.nitavu, 'no'
                  from empleados inner join aplicaciones_permisos as permisos on permisos.nitavu=empleados.nitavu
                  where empleados.dpto=".nitavu_dpto($nitavu)."
                  and  empleados.nitavu not in (SELECT nitavu from cp_colaboradores where numcaso=".$id." and activo=0) 
                  and  empleados.nitavu<>".$nitavu." and permisos.idapp='ap66' and empleados.estado = '' order by nombre asc";

                }
              }
              
                //echo $query;
                  $descripcion = '';
                  $r = $conexion -> query($query);
                //echo $query;
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
                          // INICIO CONTENEDOR PRINCIPAL MODERNO
            echo "<div class='cd-wrapper'>";

            // HERO BANNER DEL CASO
            echo "<div class='cd-case-hero'>";
              echo "<div class='cd-case-hero-content'>";
                echo "<span class='cd-case-oficio-badge'><i class='fa-solid fa-file-signature'></i> Oficio: " . oficioCaso($id) . "</span>";
                echo "<h1 class='cd-case-title'><i class='fa-solid fa-folder-open'></i> Petición #" . $id . " — " . asuntoCaso($id) . "</h1>";

                echo "<div class='cd-case-status-bar'>";
                if (estaFinalizadoCaso($_GET['id']) == 2) {
                  echo "<span class='cd-status-pill in-progress'><i class='fa-solid fa-spinner fa-spin'></i> En proceso de atención</span>";
                } else if (estaFinalizadoCaso($_GET['id']) == 1) {
                  echo "<span class='cd-status-pill finished'><i class='fa-solid fa-circle-check'></i> Caso Finalizado</span>";
                  $query = "SELECT * FROM cp_nuevosdocumentos WHERE id=" . $_GET['id'] . "";
                  $rs = $conexion->query($query);
                  while ($f = $rs->fetch_array()) {
                    echo "<span style='font-size:0.82rem; color:#fca5a5; margin-left:8px;'>Solo " . nitavu_nombre($f['nitavuCaptura']) . " puede reactivarlo.</span>";
                    if ($f['nitavuCaptura'] == $nitavu) {
                      echo " <a href='?reactivar=" . $_GET['id'] . "&id=" . $_GET['id'] . "' class='cd-btn cd-btn-light' style='padding:4px 10px; font-size:0.78rem;'><i class='fa-solid fa-power-off'></i> Reactivar</a>";
                    }
                    if (isset($_GET['reactivar'])) {
                      $sql = "UPDATE cp_nuevosdocumentos SET Estado='0', Turnadoa=IdDptoCrea WHERE id='" . $_GET['reactivar'] . "'";
                      if ($conexion->query($sql) == TRUE) {
                        historia($nitavu, "Reactivo el caso " . $_GET['id'] . "");
                        mensaje("Caso reactivado con exito", 'cp_nuevos_oficios.php?id=' . $_GET['id']);
                      } else {
                        mensaje("ERROR al activar el caso. " . $sql, 'cp_controldocumental.php');
                      }
                    }
                  }
                } else {
                  echo "<span class='cd-status-pill pending'><i class='fa-solid fa-clock'></i> Pendiente / Activo</span>";
                }

                echo "<span class='cd-status-pill dept-holder'><i class='fa-solid fa-building-columns'></i> Actualmente en: <b>" . dpto_id($turnadoami) . "</b></span>";
                echo "</div>"; // .cd-case-status-bar
              echo "</div>"; // .cd-case-hero-content
              echo "<img src='img/doc_header_banner.png' alt='Banner' class='cd-case-hero-gfx' />";
            echo "</div>"; // .cd-case-hero

            // BARRA DE HERRAMIENTAS Y ACCIONES
            echo "<div class='cd-toolbar-card'>";
              echo "<div class='cd-toolbar-group'>";
                echo "<a href='cp_controldocumental.php' class='cd-btn cd-btn-light' title='Volver al Control Documental'><i class='fa-solid fa-arrow-left'></i> Regresar</a>";
                if ($nivel == 1 || soytitular($nitavu) != 'FALSE' || ($nivel == 3 and estaActivalaColaboracion($nitavu, $id) == 0)) {
                  if (($finalizado == 0 and $turnadoami == $dpto) or ($finalizado == 2 and $turnadoami == $dpto)) {
                    echo "<a href='#modalTurnar' rel='MyModal:open' class='cd-btn cd-btn-primary' title='Turnar Caso'><i class='fa-solid fa-share'></i> Turnar Caso</a>";
                    echo "<a href='cp_nuevos_oficios.php?enproceso=" . $id . "' class='cd-btn cd-btn-gold' title='Marcar en proceso de atención'><i class='fa-solid fa-spinner'></i> En proceso</a>";
                    echo "<a href='#modalFinalizar' rel='MyModal:open' class='cd-btn cd-btn-danger' title='Finalizar el caso'><i class='fa-solid fa-circle-check'></i> Finalizar Caso</a>";
                  }
                }
                if ($nivel == 1 || soytitular($nitavu) != 'FALSE') {
                  if ($finalizado == 0 and $turnadoami == $dpto) {
                    echo "<a href='#modalCompartir' rel='MyModal:open' class='cd-btn cd-btn-dark' title='Compartir el caso'><i class='fa-solid fa-users-gear'></i> Compartir Caso</a>";
                  }
                }
              echo "</div>"; // .cd-toolbar-group
            echo "</div>"; // .cd-toolbar-card

            // TARJETA DE DESCRIPCIÓN Y COMENTARIOS
            $query = "SELECT * FROM cp_nuevosdocumentos WHERE id=" . $id . "";
            $descripcion = '';
            $r = $conexion->query($query);
            while ($f = $r->fetch_array()) {
              $descripcion = $f['descripcion'];
            }

            // Sanitizar y limpiar saltos de línea excesivos en la descripción
            $descripcion_clean = trim($descripcion);
            $descripcion_clean = preg_replace("/(\r?\n){3,}/", "\n\n", $descripcion_clean);

            // Contar comentarios del caso
            $sqlc_total = "SELECT COUNT(*) as total FROM cp_comentarios WHERE CasoId='" . $id . "'";
            $r_tot = $conexion->query($sqlc_total);
            $total_comentarios = 0;
            if ($r_tot && $f_tot = $r_tot->fetch_array()) {
              $total_comentarios = (int)$f_tot['total'];
            }

            echo "<div class='cd-comments-card'>";
              echo "<div class='cd-comments-card-header'>";
                echo "<h3 class='cd-comments-card-title'><i class='fa-solid fa-align-left' style='color:var(--cd-gold-dark);'></i> Descripción y Comentarios del Caso</h3>";
                if (estaFinalizadoCaso($_GET['id']) == 0) {
                  echo "<a href='#AgregarComentario' rel='MyModal:open' class='cd-btn cd-btn-primary' style='padding:6px 14px; font-size:0.82rem;'><i class='fa-solid fa-comment-plus'></i> Agregar Comentario</a>";
                }
              echo "</div>";

              if (!empty($descripcion_clean)) {
                $margin_bottom = ($total_comentarios > 0) ? '16px' : '0px';
                echo "<div style='background:#f8fafc; border:1px solid var(--cd-border); border-radius:var(--cd-radius-sm); padding:14px 16px; margin-bottom:" . $margin_bottom . "; font-size:0.9rem; color:var(--cd-dark); line-height:1.5;'>";
                  echo "<b style='color:var(--cd-primary);'><i class='fa-solid fa-file-lines'></i> Descripción Inicial:</b><br>" . nl2br(htmlspecialchars($descripcion_clean));
                echo "</div>";
              }

              if ($total_comentarios > 0) {
                if (isset($_GET['comentall'])) {
                  $sqlc = "SELECT * FROM cp_comentarios WHERE CasoId='" . $id . "' ORDER BY fecha DESC, Hora DESC";
                } else {
                  $sqlc = "SELECT * FROM cp_comentarios WHERE CasoId='" . $id . "' ORDER BY fecha DESC, Hora DESC LIMIT 3";
                }

                $rco = $conexion->query($sqlc);
                echo "<div class='cd-comments-list'>";
                while ($Cm = $rco->fetch_array()) {
                  echo "<div class='cd-comment-item'>";
                    echo "<img src='fotos/" . $Cm['Nuser'] . ".jpg' class='cd-comment-avatar' onerror=\"this.src='icon/default-avatar.png'\" alt='Foto' />";
                    echo "<div class='cd-comment-body'>";
                      echo "<div class='cd-comment-meta'>";
                        echo "<span class='cd-comment-author'>" . nitavu_nombre($Cm['Nuser']) . " <span style='font-weight:normal; color:var(--cd-gray-mid);'>(" . nitavu_dpto_nombre($Cm['Nuser']) . ")</span></span>";
                        echo "<span class='cd-comment-date'><i class='fa-regular fa-clock'></i> " . fecha_larga($Cm['Fecha']) . " | " . hora12($Cm['Hora']) . "</span>";
                      echo "</div>";
                      echo "<div class='cd-comment-text'>" . htmlspecialchars($Cm['Comentario']) . "</div>";
                    echo "</div>";
                  echo "</div>";
                }
                echo "</div>";

                if (!isset($_GET['comentall']) && $total_comentarios > 3) {
                  echo "<div style='margin-top:14px; text-align:right;'><a href='?comentall=&id=" . $_GET['id'] . "' class='cd-btn cd-btn-outline-gold' style='padding:6px 12px; font-size:0.82rem;'><i class='fa-solid fa-comments'></i> Ver todos los comentarios (" . $total_comentarios . ")...</a></div>";
                }
              } else if (empty($descripcion_clean)) {
                echo "<div style='text-align:center; padding:16px; color:var(--cd-gray-mid); font-style:italic; font-size:0.88rem;'><i class='fa-regular fa-comment-dots'></i> Este caso no tiene descripción inicial ni comentarios guardados.</div>";
              }
            echo "</div>"; // .cd-comments-card

            // MODAL AGREGAR COMENTARIO
            echo "<div id='AgregarComentario' class='MyModal'>";
              echo "<form action='cp_nuevos_oficios.php?id=" . $id . "' method='POST' enctype='multipart/form-data'>";
                echo "<h3><i class='fa-solid fa-comment-dots'></i> Agregar Comentario al Caso</h3>";
                echo "<div class='cd-form-group'>";
                  echo "<label class='cd-form-label'>Comentario o Nota:</label>";
                  echo "<textarea class='cd-form-control' style='height:120px;' name='comentario' placeholder='Escriba aquí su comentario...' required></textarea>";
                echo "</div>";
                echo "<button type='submit' name='Comentar' class='cd-btn cd-btn-primary'><i class='fa-solid fa-paper-plane'></i> Publicar Comentario</button>";
              echo "</form>";
            echo "</div>";

            if (isset($_POST['Comentar'])) {
              $sql = "INSERT INTO cp_comentarios (CasoId, Comentario, Nuser, Fecha, Hora) 
              VALUES ('" . $id . "', '" . $_POST['comentario'] . "', '" . $nitavu . "', '" . $fecha . "', '" . $hora . "')";
              if ($conexion->query($sql) == TRUE) {
                historia($nitavu, 'cp_Comentar caso: ' . $id . ' Agrego el comentario: ' . $_POST['comentario'] . ' ');
                notificarParticipantes($id, $nitavu, 'Se agrego un nuevo comentario al caso ' . $id . '', 'Nuevos comentarios al caso ' . $id);
                unset($_POST['comentario'], $_POST['Comentar']);
              } else {
                mensaje('ERROR al guardar el comentario', 'cp_nuevos_oficios.php?id=' . $_GET['id']);
              }
            }

            // TIMELINE / SEGUIMIENTO DE DOCUMENTOS
            echo "<div class='cd-timeline-container'>";
              echo "<h3 class='cd-timeline-title'><i class='fa-solid fa-route' style='color:var(--cd-primary);'></i> Seguimiento de Documentos</h3>";

              $grafica = "SELECT count(*) as n from cp_historialdocumentos where numcaso = " . $id . " and activo=0 ";
              $fechas = fechas($id);
              $rc = $conexion->query($grafica);
              $count = ($f = $rc->fetch_array()) ? $f['n'] : 0;
              $tope = $count;

              if ($count > 0) {
                $grafica = "SELECT * from cp_historialdocumentos where NumCaso = " . $id . " and activo=0 ORDER BY idinc DESC";
                $rc2 = $conexion->query($grafica);
                $vuelta = $tope;

                echo "<div class='cd-timeline-track'>";
                while ($r = $rc2->fetch_array()) {
                  $is_latest = ($vuelta == $tope);

                  if ($is_latest) {
                    echo "<div class='cd-timeline-step'>";
                      echo "<div class='cd-timeline-card active-dept'>";
                        echo "<div class='cd-step-header'>";
                          echo "<span class='cd-step-num'><i class='fa-solid fa-location-dot'></i></span>";
                          echo "<span class='cd-step-oficio' style='color:#ffffff;'>Ubicación Actual</span>";
                        echo "</div>";
                        echo "<div class='cd-step-dept'>" . dpto_id($turnadoami) . "</div>";

                        $sqlTiempo = "SELECT fecha as FechaDesde, (SELECT DATEDIFF(CURDATE(),FechaDesde)) as Retraso FROM cp_historialdocumentos WHERE NumCaso=" . $id . " order by idinc Desc limit 1";
                        $rcT = $conexion->query($sqlTiempo);
                        if ($rT = $rcT->fetch_array()) {
                          echo "<div class='cd-step-sub'><i class='fa-regular fa-clock'></i> " . $rT['Retraso'] . " días en esta área</div>";
                        }
                        $colab = ultimoColaborador($id);
                        if ($colab != 'FALSE') {
                          echo "<div class='cd-step-sub'><i class='fa-solid fa-user-gear'></i> Colaborador: " . nitavu_nombre($colab) . "</div>";
                        } else if (buscoalTitulardelCaso($id) != 'FALSE') {
                          echo "<div class='cd-step-sub'><i class='fa-solid fa-user'></i> Titular: " . nitavu_nombre(buscoalTitulardelCaso($id)) . "</div>";
                        } else {
                          echo "<div class='cd-step-sub'><i class='fa-solid fa-user'></i> Sin colaborador</div>";
                        }
                      echo "</div>"; // .cd-timeline-card
                      echo "<div class='cd-timeline-arrow'><i class='fa-solid fa-chevron-right'></i></div>";
                    echo "</div>"; // .cd-timeline-step
                  }

                  echo "<div class='cd-timeline-step'>";
                    echo "<div class='cd-timeline-card'>";
                      echo "<div class='cd-step-header'>";
                        echo "<span class='cd-step-num'>" . $vuelta . "</span>";
                        echo "<span class='cd-step-oficio'>" . htmlspecialchars($r['numOficio']) . "</span>";
                      echo "</div>";
                      echo "<div class='cd-step-dept'>" . nombreDepartamento($r['dptoSube']) . "</div>";
                      echo "<div class='cd-step-sub'><i class='fa-regular fa-calendar'></i> " . fecha_larga($r['fecha']) . "</div>";
                      echo "<div class='cd-step-sub'><i class='fa-solid fa-user'></i> por " . nitavu_nombre($r['nitavuSube']) . "</div>";
                      if ($r['activo'] == '1') {
                        echo "<div class='cd-step-sub' style='color:#dc2626;'><i class='fa-solid fa-trash'></i> Archivo eliminado</div>";
                      }
                    echo "</div>"; // .cd-timeline-card

                    if ($vuelta > 1) {
                      echo "<div class='cd-timeline-arrow'><i class='fa-solid fa-chevron-right'></i></div>";
                    }
                  echo "</div>"; // .cd-timeline-step

                  $vuelta--;
                }
                echo "</div>"; // .cd-timeline-track
              } else {
                echo "<p style='color:var(--cd-gray-mid); font-style:italic; margin:0;'>No hay registro de movimientos para este caso.</p>";
              }
            echo "</div>"; // .cd-timeline-container

            // HISTORIAL DE ARCHIVOS PRINCIPALES
            $sql = "SELECT * FROM cp_historialdocumentos WHERE numcaso=" . $id . " and tipo=0";
            $rc = $conexion->query($sql);
            echo "<div class='cd-card-section'>";
              echo "<div class='cd-card-header cd-card-header-primary'>";
                echo "<h3 class='cd-card-title'><i class='fa-solid fa-folder-closed'></i> Historial de Archivos del Caso</h3>";
              echo "</div>";
              echo "<div class='cd-card-body' style='padding:0;'>";

              if ($rc->num_rows > 0) {
                echo "<div class='cd-table-container'>";
                  echo "<table class='cd-table'>";
                    echo "<thead><tr>";
                      echo "<th style='width:160px;'>Oficio Número</th>";
                      echo "<th>Nombre del Archivo</th>";
                      echo "<th style='width:180px;'>Fecha y Hora</th>";
                      echo "<th style='width:80px; text-align:center;'>Acción</th>";
                    echo "</tr></thead>";
                    echo "<tbody>";
                    while ($r = $rc->fetch_array()) {
                      echo "<tr>";
                        echo "<td><b>" . htmlspecialchars($r['numOficio']) . "</b>";
                        if ($r['activo'] == '1') {
                          echo "<br><span class='cd-badge cd-badge-danger'><i class='fa-solid fa-trash'></i> Eliminado</span>";
                        }
                        echo "</td>";

                        $archivo = "peticiones/" . $r['idDoc'] . '_' . $r['NumCaso'] . '_' . $r['archivo'] . "";
                        $link = "<a id=" . $r['idDoc'] . " name='$archivo' href='cp_descargar.php?nombre=" . $archivo . "' target='_self' style='font-weight:700; color:var(--cd-primary); text-decoration:none;' title='Clic para descargar'><i class='fa-solid fa-file-pdf' style='color:#dc2626; margin-right:6px;'></i>" . htmlspecialchars($r['archivo']) . "</a>";
                        echo "<td>" . $link;
                          echo "<br><span style='font-size:0.78rem; color:var(--cd-gray-mid);'>por " . nitavu_nombre($r['nitavuSube']) . " (" . nitavu_dpto_nombre($r['nitavuSube']) . ")</span>";
                        echo "</td>";

                        echo "<td>" . fecha_larga($r['fecha']) . "<br><span style='font-size:0.78rem; color:var(--cd-gray-mid);'>" . hora12($r['hora']) . "</span></td>";

                        echo "<td style='text-align:center;'>";
                        if (($r['nitavuSube'] == $nitavu) and (estaFinalizadoCaso($r['NumCaso']) == 0) and $r['activo'] <> '1' and $r['archivo'] <> "") {
                          echo "<form action='cp_nuevos_oficios.php?id=" . $id . "' method='POST' style='margin:0;'>";
                            echo '<input type="hidden" name="id" value=' . $id . '>';
                            echo '<input type="hidden" name="idDoc" value=' . $r['idDoc'] . '>';
                            echo '<input type="hidden" name="numDoc" value=' . $r['numOficio'] . '>';
                            echo "<button type='submit' class='cd-icon-btn delete' title='Eliminar este archivo'><i class='fa-solid fa-trash-can'></i></button>";
                          echo "</form>";
                        }
                        echo "</td>";
                      echo "</tr>";
                    }
                    echo "</tbody>";
                  echo "</table>";
                echo "</div>"; // .cd-table-container
              }

              // FORMULARIO PARA AGREGAR NUEVO DOCUMENTO AL HISTORIAL
              $arr = revisarMisColaboraciones($nitavu);
              $dibuje = 0;
              for ($i = 0; $i < count($arr); $i++) {
                if (($nivel == 3 and estaActivalaColaboracion($nitavu, $id) == 0 and $dibuje == 0) || ((soyColaborador($nitavu) == 'TRUE') and (soyDptoturnado($arr[$i], $dpto) == 'FALSE') and $dibuje == 0) || (soyDptoturnado($id, $dpto) == 'TRUE') and $dibuje == 0) {
                  if ($finalizado == 0) {
                    $dibuje = 1;
                    echo "<div style='padding:16px 20px; background:#f8fafc; border-top:1px solid var(--cd-border);'>";
                      echo "<h4 style='margin:0 0 10px 0; font-size:0.92rem; color:var(--cd-dark);'><i class='fa-solid fa-cloud-arrow-up' style='color:var(--cd-gold-dark);'></i> Agregar Documento al Historial</h4>";
                      echo "<form action='cp_nuevos_oficios.php?id=" . $id . "' method='POST' enctype='multipart/form-data' class='cd-form-grid' style='margin:0;'>";
                        echo '<input type="hidden" name="id" value=' . $id . '>';
                        echo '<input type="hidden" name="subirHistorial" value="1">';
                        echo '<input type="hidden" name="idCaso" value= ' . $id . '>';
                        echo "<div class='cd-form-group'>";
                          echo "<label class='cd-form-label'>Referencia / Nombre Oficio:</label>";
                          echo "<input type='text' id='oficioNombre' name='oficioNombre' class='cd-form-control' placeholder='Ej. OFICIO-2026-001' required>";
                        echo "</div>";
                        echo "<div class='cd-form-group'>";
                          echo "<label class='cd-form-label'>Archivo PDF (*):</label>";
                          echo "<input name='nuevoDoc' type='file' accept='.pdf' class='cd-form-control' required>";
                        echo "</div>";
                        echo "<div class='cd-form-group'>";
                          echo "<label class='cd-form-label'>Fecha:</label>";
                          echo '<input type="date" id="fechaOficio" name="fechaOficio" class="cd-form-control" value=' . $fecha . ' required>';
                        echo "</div>";
                        echo "<div class='cd-form-group' style='justify-content:flex-end;'>";
                          echo "<label class='cd-form-label'>&nbsp;</label>";
                          echo "<button type='submit' class='cd-btn cd-btn-primary'><i class='fa-solid fa-upload'></i> Subir Documento</button>";
                        echo "</div>";
                      echo "</form>";
                    echo "</div>";
                  }
                }
              }
            echo "</div>"; // .cd-card-section (Historial de archivos)

            // ANEXOS
            $anexos = "SELECT * FROM cp_historialdocumentos WHERE numcaso=" . $id . " and tipo=1";
            $rc = $conexion->query($anexos);
            echo "<div class='cd-card-section'>";
              echo "<div class='cd-card-header cd-card-header-gold'>";
                echo "<h3 class='cd-card-title'><i class='fa-solid fa-paperclip'></i> Anexos Adjuntos al Caso</h3>";
                if (estaFinalizadoCaso($_GET['id']) == 0) {
                  if (($nivel == 3 and estaActivalaColaboracion($nitavu, $id) == 0) || ((soyColaborador($nitavu) == 'TRUE') and (soyDptoturnado($id, $dpto) == 'FALSE')) || (soyDptoturnado($id, $dpto) == 'TRUE')) {
                    echo "<a href='#agregar_anexos' rel='MyModal:open' class='cd-btn cd-btn-gold' style='padding:6px 14px; font-size:0.82rem;'><i class='fa-solid fa-plus'></i> Agregar Anexos</a>";
                  }
                }
              echo "</div>";
              echo "<div class='cd-card-body' style='padding:0;'>";

              if ($rc->num_rows > 0) {
                echo "<div class='cd-table-container'>";
                  echo "<table class='cd-table'>";
                    echo "<thead><tr>";
                      echo "<th>Nombre del Anexo</th>";
                      echo "<th style='width:160px;'>Fecha</th>";
                      echo "<th style='width:80px; text-align:center;'>Acción</th>";
                    echo "</tr></thead>";
                    echo "<tbody>";
                    while ($r = $rc->fetch_array()) {
                      echo "<tr>";
                        $archivo = "peticiones/" . $r['idDoc'] . '_' . $r['NumCaso'] . '_' . $r['archivo'] . "";
                        $link = "<a id=" . $r['idDoc'] . " name='$archivo' href='cp_descargar.php?nombre=" . $archivo . "' target='_self' style='font-weight:700; color:var(--cd-dark); text-decoration:none;' title='Clic para descargar'><i class='fa-solid fa-file-pdf' style='color:#2563eb; margin-right:6px;'></i>" . htmlspecialchars($r['archivo']) . "</a>";
                        echo "<td>" . $link;
                          echo "<br><span style='font-size:0.78rem; color:var(--cd-gray-mid);'>por " . nitavu_nombre($r['nitavuSube']) . " (" . nitavu_dpto_nombre($r['nitavuSube']) . ")</span>";
                        echo "</td>";

                        echo "<td>" . fecha_larga($r['fecha']) . "</td>";

                        echo "<td style='text-align:center;'>";
                        if (($r['nitavuSube'] == $nitavu) and (estaFinalizadoCaso($r['NumCaso']) == 0) and $r['activo'] <> '1' and $r['archivo'] <> "") {
                          echo "<form action='cp_nuevos_oficios.php?id=" . $id . "' method='POST' style='margin:0;'>";
                            echo '<input type="hidden" name="id" value=' . $id . '>';
                            echo '<input type="hidden" name="idDoc" value=' . $r['idDoc'] . '>';
                            echo '<input type="hidden" name="numDoc" value=' . $r['numOficio'] . '>';
                            echo "<button type='submit' class='cd-icon-btn delete' title='Eliminar anexo'><i class='fa-solid fa-trash-can'></i></button>";
                          echo "</form>";
                        }
                        echo "</td>";
                      echo "</tr>";
                    }
                    echo "</tbody>";
                  echo "</table>";
                echo "</div>";
              } else {
                echo "<div style='padding:20px; text-align:center; color:var(--cd-gray-mid); font-style:italic;'>No hay anexos registrados para este caso.</div>";
              }
              echo "</div>";
            echo "</div>"; // .cd-card-section (Anexos)

            // HISTORIAL DE ACCESOS
            echo "<div class='cd-card-section'>";
              echo "<div class='cd-card-header cd-card-header-info'>";
                echo "<h3 class='cd-card-title'><i class='fa-solid fa-user-clock'></i> Historial de Accesos al Caso</h3>";
                if (!isset($_GET['histoall'])) {
                  echo "<a href='?histoall=&id=" . $_GET['id'] . "' class='cd-btn cd-btn-light' style='padding:6px 12px; font-size:0.82rem;'><i class='fa-solid fa-list-ul'></i> Ver todo el historial...</a>";
                }
              echo "</div>";

              if (isset($_GET['histoall'])) {
                $sql = "select nitavu as Nuser, (select nombre from empleados where nitavu=Nuser) as nombre, descripcion as actividad, historia.* from historia where descripcion like 'cp%' and descripcion like '%caso: " . $id . "%' ";
              } else {
                $sql = "select nitavu as Nuser, (select nombre from empleados where nitavu=Nuser) as nombre, descripcion as actividad, historia.* from historia where descripcion like 'cp%' and descripcion like '%caso: " . $id . "%' limit 5";
              }

              $r = $conexion->query($sql);
              echo "<div class='cd-card-body'>";
                if ($r->num_rows > 0) {
                  echo "<div class='cd-comments-list'>";
                  while ($f = $r->fetch_array()) {
                    echo "<div class='cd-comment-item' style='background:#f8fafc;'>";
                      echo "<div class='cd-comment-body'>";
                        echo "<div class='cd-comment-meta'>";
                          echo "<span class='cd-comment-author'>" . htmlspecialchars($f['nombre']) . "</span>";
                          echo "<span class='cd-comment-date'><i class='fa-regular fa-clock'></i> " . fecha_larga(date_format(date_create($f['fecha']), 'Y-m-d')) . "</span>";
                        echo "</div>";
                        echo "<div class='cd-comment-text' style='color:var(--cd-gray-dark); font-size:0.82rem;'>" . htmlspecialchars($f['actividad']) . "</div>";
                      echo "</div>";
                    echo "</div>";
                  }
                  echo "</div>";
                } else {
                  echo "<p style='color:var(--cd-gray-mid); font-style:italic; margin:0;'>Sin registros recientes de acceso.</p>";
                }
              echo "</div>";
            echo "</div>"; // .cd-card-section (Historial accesos)

            echo "</div>"; // CIERRA .cd-wrapper PRINCIPAL         
        echo "</div>";

          //MODAL PARA AGREGAR ANEXOS
          echo "<div id='agregar_anexos' class='MyModal'>";
          echo "<form action='cp_nuevos_oficios.php?id=".$id."' method='POST'  enctype='multipart/form-data'>";
          echo "<label>Seleccione los archivos que se van a agregar como anexos</label>";
          echo '<input type="hidden" name="Newanexos" value="1">';
          echo '<input id="archivo[]" name="archivo[]" type="file" accept=".pdf" multiple="" required>';
          echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para subir el archivo'> Subir archivos </button>";
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
        echo "<div id='myModalaAgregar' class='MyModal' >";  
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
        echo "<input type='submit' value='Solicitar' class='Mbtn btn-default btnAlta' name='btnSolicitar'>";

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
    data: { numcaso: numcaso,nitavu: usuario ,nitavu1: <?php echo $nitavu; ?>},
    success: function(data){
      //console.log(data);
      console.log("entro");
    $("#preloaderbloque").css({'display':'none'});
     $("#bloque1").css({'display':'inline-block'});    
     $('#bloque1').html(data+"\n");

    console.log("entro2");
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

 data: { numcaso: numcaso,nitavu: usuario,nitavu1: <?php echo $nitavu; ?> },
 success: function(data){
  console.log("entroquitae");
  $("#preloaderbloque").css({'display':'none'});
  $("#bloque1").css({'display':'inline-block'});
  $('#bloque1').html(data+"\n");
  location.reload();
  

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
<?php include ("./lib/body_footer.php"); ?>