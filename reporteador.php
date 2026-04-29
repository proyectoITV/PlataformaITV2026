<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>
  

<script languaje="javascript"> 
function popup(){ 
  document.getElementById("modalReporte").style.visibility="visible";  
} 
function cerrar(){
  document.getElementById("modalReporte").style.visibility="hidden";
}

</script> 

<?php
require("config.php");
$id_aplicacion = 'ap50';
xd_update('ap50',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap50"; //ap07=Permisos de Aplicacion
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
AhorrePapel(FALSE,3);
  /*--------------- CAMBIAMOS EL ESTADO DEL REPORTE PARA QUE YA NO ESTE EN LA LISTA DE LOS POR SOLICITAR PERMISO--------------*/
  if(isset($_GET['id3'])){
    $id = $_GET['id3'];
    
    $sql = "UPDATE reportes SET estado=2 WHERE id_rep_consulta='".$id."'";
    if ($conexion->query($sql) == TRUE) {
      return mensaje('Permiso solicitado con éxito. ','reporteador.php');
    }else{
      return FALSE;
    }
  }

  //------------------- CAMBIAMOS EL ESTADO DEL REPORTE QUE SE MODIFICO
  if(isset($_POST['RC1'])){
    $id = $_POST['RC1'];
    $solicita = $_POST['solicita'];
    
    $sql = "UPDATE reportes SET modificar=0 WHERE id_rep_consulta='".$id."'";
    if ($conexion->query($sql) == TRUE) {
      repEstado1($id);
      notificacion_add($solicita,'Solicitud de Reporte '.reporte_nombre($id), $fecha,$nitavu,'Existe una previsualización del reporte: '.reporte_nombre($id).'<br> Se solicitará permiso al área correspondiente para que usted pueda hacer uso de dicho reporte.');
      notificacion_add('2809','Nuevo Reporte '.reporte_nombre($id), '',$nitavu,'He realizado el reporte: '.reporte_nombre($id).' solicitado por '.nitavu_nombre($solicita).'.<br> Te notifico para continuar con el proceso.');
      return mensaje('Reporte enviado con éxito.','reporteador.php');
    }else{
      return FALSE;
    }
  }

  /*--------------- CAMBIAMOS EL ESTADO DEL REPORTE PARA QUE SE PUEDA BUSCAR--------------*/
  if(isset($_GET['PR1'])){
    $id = $_GET['PR1'];
    
    $sql = "UPDATE reportes SET estado=4 WHERE id_rep_consulta='".$id."'";
    if ($conexion->query($sql) == TRUE) {
      return mensaje('Reporte publicado con éxito. ','reporteador.php');
    }else{
      return FALSE;
    }
  }

  //---------EN CASO DE QUE SE TENGA QUE MODIFICAR EL REPORTE 
  if(isset($_POST['MR1'])){
    $id = $_POST['MR1'];
    $comentario = $_POST['comentariosModificar'];
    $quiencreo = '';
    $sql = "UPDATE reportes SET modificar=1, comentarioModificar='".$comentario."'  WHERE id_rep_consulta='".$id."'";
    if ($conexion->query($sql) == TRUE){
      $sql2 = "SELECT nitavu FROM reportes WHERE id_rep_consulta=".$id."";
      $r = $conexion -> query($sql2); while($f = $r -> fetch_array()){
        $quiencreo = $f['nitavu'];
      }
      notificacion_add($quiencreo,'Solicitud de modificar reporte: '.reporte_nombre($id), $fecha,$nitavu,'Buen día.<br> Necesito que se modifique el reporte: '.reporte_nombre($id).'. <br>Modificaciones:'.$comentario.'');
      return mensaje('Se modificará el Reporte llamado '.reporte_nombre($id).'. Cuando esté listo, se le enviará una notificación vía chat.','reporteador.php');
    }else{
      return FALSE;
    }
  }

  //-----------CAMBIAMOS EL ESTADO DE LA APOBACION DE PERMISOS PARA PUBLICAR CUANDO ES UN SI
  if(isset($_POST['ap1'])){
    $id= $_POST['ap1'];
    echo 'Entre';
    $sql = "UPDATE reportes_autoriza SET estado=1 WHERE idRep='".$id."'";
    if ($conexion->query($sql) == TRUE) {
      estadoReporte3($id);
      notificacion_add($_POST['solicita'],'Solicitud de publicar Reporte: '.reporte_nombre($id), $fecha,$nitavu,'He aceptado tu petición para publicar el reporte llamado '.reporte_nombre($id).'');
      return mensaje('Se autorizó con éxito la publicación del reporte. ','reporteador.php');
    }else{
      return FALSE;
    }
  }

  //-----------CAMBIAMOS EL ESTADO DE LA APOBACION DE PERMISOS PARA PUBLICAR CUANDO ES UN NO
  if(isset($_POST['ap2'])){
    $id= $_POST['ap2'];
    $sql = "UPDATE reportes_autoriza SET estado=2 WHERE idRep='".$id."'";
    if ($conexion->query($sql) == TRUE) {
      notificacion_add($_POST['solicita'],'Solicitud de publicar Reporte: '.reporte_nombre($id), $fecha,$nitavu,'He declinado tu petición para publicar el reporte llamado '.reporte_nombre($id).' debido a que es información clasificada de mi departamento.');
      return mensaje('Autorización declinada con éxito. ','reporteador.php');
    }else{
      return FALSE;
    }
  }

  //-------------CAMBIAMOS EL ESTADO EN LA TABLA DE REPORTES POR AUTORIZAR
  if(isset($_GET['notificacion'])){
    $id= $_GET['id'];
    $sql = "UPDATE reportes SET estado=2 WHERE id_rep_consulta='".$id."'";
    if ($conexion->query($sql) == TRUE) {
      historia($nitavu, "Se cambio el estado del reporte ".reporte_nombre($id).".Estado=2, que sig. que se solicito permiso con el responsable de área.");
    }else{
      historia($nitavu, "Ocurrio un error al momento de cambiar el estado del reporte ".reporte_nombre($id).". Estado=2, que sig. que se solicito permiso con el responsable de área.");
    }
  }
  
  // ---------- AGREGAMOS EL NUEVO PERMISO A LA TABLA DE PERMISOS
    if(isset($_POST['permiso'])){
      $id=$_POST['permiso'];
      $solicitante=$_POST['solicitante'];
      $estado = estadoEmpleado($solicitante);
      if($estado != ""){ 
        $depen = dependencia($solicitante);
        $titular = quienesmititular($depen);
        mensaje('Se ha solicitado el permiso para que pueda ver el reporte.', 'reporteador.php');
        notificacion_add($titular,'Ver Reporte: '.reporte_nombre($id), $fecha,$nitavu,'Solicito permiso para ver el reporte: '.$id.'-'.reporte_nombre($id));
        nuevo_permiso($id,$nitavu,$titular);
      }else{
        mensaje('Se ha solicitado el permiso para que pueda ver el reporte.', 'reporteador.php');
        notificacion_add($solicitante,'Ver Reporte: '.reporte_nombre($id), $fecha,$nitavu,'Solicito permiso para ver el reporte: '.$id.'-'.reporte_nombre($id));
        nuevo_permiso($id,$nitavu,$solicitante);
      }
    }

    //DIBUJAMOS BOTON DE HISTORIAL DE REPORTE PARA INFORMATICA
    $depInfo = buscarInformatica();
    for($i=0; $i < sizeof($depInfo); $i++){  
      if($nitavu==$depInfo[$i]){
        echo "<a href='./estatus_reporte.php' class='Mbtn btn-default' title='Ver el seguimiento de reportes '>";
          echo "<table  width='100%'><tr><td valign='middle' align='center'>";
          echo "<img src='icon/req2.png'>";
          echo "</td>";
          echo "<td valign='middle' align='center' style='color:white;' class='pc'>";

          echo "Estado de Reportes";

          echo "</td></tr></table>";
        echo "</a>";
      }
    }
    echo "<br><br><br>";


  /*--------------DIBUJAMOS LA VENTANA EMERGENTE PARA HACER LA SOLICITUD DE UN REPORTE NUEVO----------*/
  echo "<div id='ventanaReporte' class='MyModal'>";
  echo "<form action='reporteador.php' method='POST'>";
  echo "<h3 style='color:#575A5D'>Solicitud de Reporte</h3>";
  echo "<label>Nombre de tu Reporte</label>";
  echo "<input placeholder='Nombre' name='nombre' required>";
  echo "<label>Describe sobre que es  y que contendra tu reporte:</label>";
  echo "<textarea id='consultaReporte' name='consultaReporte' style=' height:20%;' required ></textarea>";
  echo "<br><br>";
  echo "<input class='Mbtn btn-default' id='boton' type='submit' value='Enviar'>";
  echo "</form>";
  echo "</div>";

 if (isset($_POST['nombre']) and isset($_POST['consultaReporte'])) {
    $desc = $_POST['consultaReporte'];
    $descripcion =  preg_replace('/<br>/', '.', $desc);    
    historia($nitavu,'He solicitado la creación de un reporte sobre '.$_POST['nombre']);
    $repNew = agregarConsultaRep($_POST['nombre'],$descripcion,$nitavu,$fecha,$hora);
    /*----------Enviamos notificacion al todos los del departamento de informatica si existe un reporte nuevo--------*/
    if($repNew == 'TRUE'){ 
      //InformaticosGo("Solicitud de Reporte ".$_POST['nombre'], "He solicitado la elaboración de un reporte <b>".$_POST['nombre']."</b>: ".$_POST['consultaReporte'], $nitavu);
      mensaje('Se ha solicitado el reporte '.$_POST['nombre'].', con éxito. <br> El Dpto, de informática programará su solicitud, cuando este disponible se le avisará mediante este mismo módulo o vía notificación.', 'reporteador.php');
    } else {
      mensaje('Ocurrio un error, favor de intentarlo de nuevo.: '.$repNew,'reporteador.php');
    }
    
  }
 
  if ( isset($_GET['busqueda'])){} else {echo "<div class='centrar_padreReportes' >"."<div class='centrar_hijoReportes'>";}
  // echo "<img src='img/media_reportes.fw.png' style='width:98%;'>";
  echo "<table id='buscarReporte' style='width:90%'>";
  echo "<td style='width:95%;'>";
  buscar("reporteador.php","¿Que reporte buscas? o escribe el ID",'');
  echo "</td>";
  echo "<td style='width:5%;' align=left>";
  /*--------AGREGAR UN BOTÓN PARA GENERAR REPORTE SOLO SI ERES TITULAR--------*/
  $tit = soytitular($nitavu);
  echo "<div style='width:6%;'>";
  if($tit != 'FALSE'){
    echo "<a type='button' href='#ventanaReporte' rel='MyModal:open' class='btnagregar' title='Haga clic aquí para agregar un reporte' onclick='popup()'> <img src='icon/add.png' style='width:50px; '> </a>";
  }
  echo "</div>";
  echo "</td>";
  echo "</table>";


  //MOSTRAMOS LOS REPORTES QUE ESTAMOS POR HACERLE //
  // $sql=" select * from reportes where reportes.solicitante = '".$nitavu."' and estado=0";
  // //$sql = "SELECT * FROM reportes WHERE estado = 3";
  // $reportestxt="";
  // $r = $conexion -> query($sql); while($f = $r -> fetch_array()){
  //   $reportestxt = $reportestxt. "[".$f['id_rep']."]".$f['nombre'].", ";
  // }
  // if ($reportestxt==''){

  // }
  // else{
  //   echo "<label>Reportes pendientes de elaboracion: ".$reportestxt."</label>";
  // }


    /*------EMPIEZA A BUSCAR----------*/
    $con1=0;
    $flag=0;
    $info = quienpuedeverreportes($nitavu);
    $midpto = nitavu_dpto($nitavu);
    $empleados = quiendependedemi($midpto);
    $repDep = reportesDeMisDependientes($empleados);
    $reps = autorizo($nitavu);
    if ( isset($_GET['busqueda']) ){} else {echo "</div></div>";}
      if ( isset($_GET['busqueda']) )
      {
        $sql="
        SELECT  * FROM reportes  WHERE 
            id_rep_consulta='".$_GET['busqueda']."' AND estado=4 OR nombre like '%".$_GET['busqueda']."%' AND estado=4
        OR  descripcion like'%".$_GET['busqueda']."%' AND estado=4";
        $rc= $conexion -> query($sql);
        if ($rc->num_rows>0)
        {
          historia($nitavu,'Busco un reporte '.$_GET['busqueda']);
          echo "<h3 class=''>Resultados de <b class='normal'>".$_GET['busqueda']."</b></h3>";
          echo "<table class='tabla'>";
          echo "<th width='10%'>id</th>";
          echo "<th width='30%'>Nombre</th>";
          echo "<th>Descripcion</th>";
          echo "<th></th>";
          while($r = $rc -> fetch_array()){//AGREGAMOS QUIEN PODRA VER EL REPORTE
            echo "<tr>";
            for($i=0; $i < sizeof($info); $i++){  
              for ($j=0; $j < sizeof($repDep) ; $j++) {
                for($k=0; $k < sizeof($reps); $k++){
                    if((($info[$i]== $r['id_rep_consulta'])and ($info[$i]!=null)and ($con1!=1)) or (($repDep[$j] == $r['id_rep_consulta']) and ($repDep[$j]!=null) and ($con1!=1))  or (($r['solicitante']==$nitavu) and ($con1!=1)) or (($reps[$k]==$r['id_rep_consulta']) and ($reps[$k]!=null) and($con1!=1))){
                    $flag = $r['id_rep'];
                    echo "<td style='font-family:Compacta;'>".$r['id_rep_consulta']."</td>";
                    echo "<td>".$r['nombre']."</td>";
                    echo "<td style='font-family:Compacta;'>".$r['descripcion']."</td>";
                    echo "<td>";
                    echo "<form action='reporte.php' method='GET'>";
                    echo "<input type='hidden' value='".$r['id_rep_consulta']."' name='id'>";
                    echo "<input type='hidden' value='".$nitavu."' name='nitavu'>";
                    echo "<input type='hidden' value='".nitavu_nombre($nitavu)."' name='autor'>";
                    echo "<button type='submit' class='Mbtn btn-default' title='Haga clic aquí para ver el reporte'> <img src='icon/pdf1.png' style='width:30px; '> </button>";
                    echo "</form>";
                    $con1=1;
                  }
                } 
              }
            }
            $con1=0;
            if($flag != $r['id_rep']){   
              echo "<td style='font-family:Compacta;'>".$r['id_rep_consulta']."</td>";
              echo "<td>".$r['nombre']."</td>";
              echo "<td style='font-family:Compacta;'>".$r['descripcion']."</td>";
              echo "<td>";
              echo "<form action='reporteador.php' method='POST'>";
              echo "<input type='hidden' value='".$r['id_rep_consulta']."' name='id'>";
              echo "<input type='hidden' value='".$r['solicitante']."' name='solicitante'>";
              echo "<input type='hidden' value='".$r['id_rep_consulta']."' name='permiso'>";
              echo "<button type='submit' class='Mbtn btn-default' title='Solicite permiso para ver el reporte'> <img src='icon/solicitarPermiso.png' style='width:30px; '> </button>";
              echo "</form>";  
            }
            echo "</td>";
            echo "</tr>"; 
          }
          echo "</table>";
      }else{
        $msg="No se ha encontrado el reporte <b>".$_GET['busqueda']."</b>. Para solicitarlo comuniquese con el dpto. correspondiente";
        sentimental($msg);
        echo "<hr style='border-style:dashed; opacity:0.1;'>";
      }
    }  

    echo "<br>";
    //------------------------MOSTRAR TABLA CON REPORTES PENDIENTES POR HACER A LOS DE INFORMATICA y MOSTRAR DONDE HACER LAS CONSULTAS
    $informatica2 = buscarInformatica();
    for($i=0; $i < sizeof($informatica2); $i++){  
      if($nitavu==$informatica2[$i]){
        $sql = "SELECT * FROM reportesconsultas WHERE estado = 0 order by fechasol";
        $rc= $conexion -> query($sql);
        if ($rc->num_rows>0){              
        
          echo "<div id='reporteador_pendientes3'>
          <h3 style='color:#575A5D'>Reportes pendientes<b class='normal'></b></h3>";
          echo "<table class='tabla'>";
          // echo "<th width='10%'>id</th>";
          // echo "<th width='30%'>Nombre</th>";
          // echo "<th>Descripcion</th>";
          // echo "<th>Hacer</th>";

          while($r = $rc -> fetch_array())    
          {
            echo "<tr>";
            //echo "<td style='font-family:Compacta;font-size:15px;'>".$r['idConsulta']."</td>";

            echo "<td style='font-family:Compacta;font-size:15px;'>";
            echo "<span style='color:#A8C16D;' title='Esto es el ID unico del reporte'>[".$r['idConsulta']."]</span> <b>".$r['nombre'].": </b>";
            echo "<span style='font-style:italic' >".$r['descripcion'].", solicitado el ".fecha_larga($r['fechasol'])." a las ".hora12($r['horasol'])."</span>";
            echo "<hr>Solicitado por <b>".nitavu_nombre($r['solicitante'])."</b>";
            echo " de <b class='normal'>".nitavu_dpto_nombre($r['solicitante'])."</b>";
            echo "</td>";
            
            echo "<td width='10%'>";
            echo "<form action='reportes_crear.php' method='POST'>";
            echo "<input type='hidden' value='".$r['idConsulta']."' name='id'>";
            echo "<input type='hidden' value='".$r['nombre']."' name='nombre'>";
            echo "<input type='hidden' value='".$r['descripcion']."' name='descripcion'>";
            echo "<input type='hidden' value='".$r['solicitante']."' name='solicitante'>";
            echo "<input type='hidden' value='".$r['idConsulta']."' name='primera'>";
            echo "<button type='submit' class='Mbtn btn-default' title='Escribe las consultas para crear el reporte' onClick='consultas()'> <img src='icon/redactar.png' style='width:30px; '> </button>";
            echo "</form>";
            
            echo "</tr>";
          }
          echo "</table>
          </div>";
        }

        //DIBUJAMOS BOTÓN DE HISTORIAL DE REPORTES
        
      }
    }

  //MOSTRAR REPORTES QUE SE ESTAN HACIENDO Y POR ALGUNA RAZÓN NO SE HAN ENVIADO
  reportesEnConstruccion($nitavu);

  //------MOSTRAR REPORTES PARA MODIFICAR
  $info = buscarInformatica();
  for($i=0; $i < sizeof($info); $i++){  
    if($nitavu==$info[$i]){
      //En caso de que solo se le deba mostrar a la persona que lo  hizo
      //$sql = "SELECT * FROM reportes WHERE modificar = 1 and nitavu=".$nitavu."";
      //Se le muestra a todos los de informática
      $sql = "SELECT * FROM reportes WHERE modificar = 1";
      $rc= $conexion -> query($sql);
      if ($rc->num_rows>0){
      
        echo "<div id='reporteador_pendientes2'>
        <h3 style='color:#575A5D'>Reportes para modificar<b class='normal'></b></h3>";
        echo "<table class='tabla'>";
        // echo "<th>id</th>";
        // echo "<th>Nombre</th>";
        // echo "<th>Descripcion</th>";
        // echo "<th>Comentario</th>";
        // echo "<th>Modificar</th>";

        while($r = $rc -> fetch_array())    
        {
          echo "<tr>";
          echo "<td style='font-family:Compacta;font-size:15px;'>";
          // echo "<td style='font-family:Compacta;font-size:15px;'>".$r['nombre']."</td>";
          // echo "<td style='font-family:Compacta; font-size:15px;'>".$r['descripcion']."<br>";
          // echo "Solicitado por ".nitavu_nombre($r['solicitante'])." <br>";
          // echo "".nitavu_dpto_nombre($r['solicitante']);
          echo "<span style='color:#A8C16D;' title='Esto es el ID unico del reporte'>[".$r['idConsulta']."]</span> <b>".$r['nombre'].": </b>";
          echo "<span style='font-style:italic' >".$r['descripcion']."</span>";
          echo "<hr>Solicitado por <b>".nitavu_nombre($r['solicitante'])."</b>";
          echo " de <b class='normal'>".nitavu_dpto_nombre($r['solicitante'])."</b>";
          echo "</td>";
          echo "<td style='font-family:Compacta; font-size:15px;'>".$r['comentarioModificar']."</td>";
          echo "<td width='10%'>";
          echo "<form action='reportes_crear.php?idReporte=".$r['id_rep_consulta']."&solicita=".$r['solicitante']."' method='POST'>";
          echo "<input type='hidden' value='".$r['id_rep_consulta']."' name='id'>";
          echo "<input type='hidden' value='".$r['solicitante']."' name='solicitante'>";
          echo "<input type='hidden' value='".$r['id_rep_consulta']."' name='id3'>";
          echo "<button type='submit' class='Mbtn btn-default' title='Escribe las consultas para crear el reporte' onClick='consultas()'> <img src='icon/redactar.png' style='width:30px; '> </button>";
          echo "</form>";
          echo "</td>";
          echo "</tr>";
        }
        echo "</table>
        </div>";
        }
      }
    }

    //MOSTRAMOS LOS REPORTES QUE YA ESTAN HECHOS PARA SOLICITAR PERMISO DE PUBLICAR A QUIEN CORRESPONDA



    // if($nitavu == 2809){

    if ($nitavu == JefedeInformatica()){

      $sql = "SELECT * FROM reportes WHERE estado = 1";
      
      $rc= $conexion -> query($sql);
      
      if ($rc->num_rows>0)
      {
        echo "<div id='reporteador_pendientes1'>";
        echo "<h3 style='color:#575A5D'><b>Reportes para solicitar permiso de uso</b></h3>";
        echo "<table class='tabla'>";
        // echo "<th width='10%'>id</th>";
        // echo "<th width='25%'>Nombre</th>";
        // echo "<th width='20%'>Descripcion</th>";
        // echo "<th width='15%'>Solicitar Permiso</th>";
        while($r = $rc -> fetch_array())    
        {
          echo "<tr>";
          echo "<td style='font-family:Compacta;font-size:15px;'>";
          // .$r['id_rep_consulta']."";
          // echo "<td style='font-family:Compacta;font-size:15px;'>".$r['nombre']."</td>";
          // echo "<td style='font-family:Compacta;font-size:15px;'>".$r['descripcion']."  solicitado por ".nitavu_nombre($r['solicitante'])." del departamento de ".nitavu_dpto_nombre($r['solicitante'])."</td>";
          echo "<span style='color:#A8C16D;' title='Esto es el ID unico del reporte'>[".$r['id_rep_consulta']."]</span> <b>".$r['nombre'].": </b>";
          echo "<span style='font-style:italic' >".$r['descripcion']."</span>";
          echo "<hr>Solicitado por <b>".nitavu_nombre($r['solicitante'])."</b>";
          echo " de <b class='normal'>".nitavu_dpto_nombre($r['solicitante'])."</b>";
          
          echo "<td>";
          echo "<form action='reportes_permiso_enviar.php' method='GET'>";
          echo "<input type='hidden' value='".$r['id_rep_consulta']."' name='id'>";
          echo "<input type='hidden' value='".$r['solicitante']."' name='solicita'>";
          echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para ver y publicar el reporte'> <img src='icon/permiso.png' style='width:30px; '> </button>"; 
          echo "</form>";
          echo "</td>";
        }
        echo "</table>";
        echo "</div>";
      }
    }

   //MOSTRAMOS LOS REPORTES QUE EXISTEN PARA PUBLICAR
  publicarReportes($nitavu);
    
  //------------MOSTRAMOS LOS REPORTES QUE ESTAN PENDIENTES DE PERMISO PARA PUBLICAR
  reportesPorPublicar($nitavu);    

  //--------------MOSTRAR REPORTES PARA DAR PERMISOS
  mostrarSolicitudes($nitavu);
  if(isset($_GET['id5'])){
    cambiarEstadoPermiso($_GET['id5'],$_GET['solicita1'], $nitavu);
  }

  //--------------DIBUJAMOS GRAFICA
  $dato = "";
    $titular = soytitular($nitavu);
 if($titular != 'FALSE'){
    $sql = "SELECT reportes.nombre, COUNT(repVisto) AS con from reportes INNER JOIN reporteshistoria WHERE reportes.solicitante=".$nitavu." AND reportes.id_rep_consulta = reporteshistoria.repVisto GROUP BY nombre, repVisto"; 
    $r = $conexion -> query($sql); while($f = $r -> fetch_array()){
      $dato = $dato.'["'.$f['nombre'].'",'.$f['con'].'],';
    }
    $dato= trim($dato, ',');//quita la ultima coma
    $titulo = "Visualización de los Reportes que he solicitado";
    //echo $dato;
  }else{
    $sql1 = "SELECT reportes.nombre, COUNT(repVisto) AS con FROM reportes INNER JOIN reporteshistoria 
    WHERE reportes.id_rep_consulta = reporteshistoria.repVisto AND reporteshistoria.nitavu = ".$nitavu." 
    GROUP BY nombre,repVisto"; 
    $r1 = $conexion -> query($sql1); while($f1 = $r1 -> fetch_array()){
      $dato = $dato.'["'.$f1['nombre'].'",'.$f1['con'].'],';
    }
    $dato= trim($dato, ',');//quita la ultima coma
    $titulo = "Reportes Vistos";
    //echo $dato;
  }

  echo "<div id='graficaReportes' >";
  echo "<h3 style='color:#575A5D'>".$titulo."</h3>";
  echo '
    <script type="text/javascript"> 
    google.charts.load("current", {packages: ["corechart", "bar"]});
    google.charts.setOnLoadCallback(drawBasic);

      function drawBasic() {
        var data = new google.visualization.DataTable();
          data.addColumn("string", "Nombre de Reporte");
          data.addColumn("number", "Visualizaciones");
          data.addRows(['.$dato.']);
        var options = {
            title: "",
            hAxis: {
              title: "Nombre de Reporte",
              viewWindow: {
                min: [0, 30, 0],
                max: [10, 30, 0]
              }
            },
            vAxis: {
            title: "Raiting"
          }
        };

        var chart = new google.visualization.ColumnChart(
          document.getElementById("chart_div"));
          chart.draw(data, options);
        }
      </script>
      <div id="chart_div"></div>
  ';
  echo "</div>";









?>

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