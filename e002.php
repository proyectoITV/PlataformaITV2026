<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php"); include ("./lib/body_menu.php");


?>
<?php
$id_aplicacion ="ap109"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);


if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
   xd_update('ap109',$nitavu);//guarda la experiencia del usuario
   historia($nitavu, "Entro a la aplicacion [ap109], para consultar las escrituras.");

  
$direccion=quienEsmiDireccion(nitavu_dpto($nitavu));
$accion=1;  //Aprobar Tramite
  /*TRAMITES*/

// 10- Dir. Jurídica y Seguridad Patrimonial
// 19- Coordinacion de Delegaciones
// 46- Dir. de Programas de Suelo y Vivienda
// 54- Direccion de Administracion y Finanzas



/******************BUSCAR TRAMITE DE ESCRITURA************************************************/
echo "<div id='BuscarUnTramite' style=' padding: 6px; background-color: #eeece6;
margin-top: 20px; margin-left: 0px; border-radius: 5px; border: 1px solid #f0e1c5; margin-right: -10px; '>";
echo '<div id="beta_buscar" style=" ">';
echo '<form action="" method="get">'; 
    echo '<input type="hidden" name="" id="brig" value="">';

    echo '<table broder="1" width="100%"><tr>';
        echo '<td> <input required="required" type="text" id="beta_buscar_input" name="q" placeholder="Buscar Tramite de Escritura (Beneficiario, Número de Contrato, Numero de trámite)" /></td>';
        echo '<td align="right" width="15px">                    
        <button id="beta_buscar_boton">
        <img  src="icon/buscar.png"></button>
        </td>';
    echo '</tr></table>';
echo '</form>';
echo '                </div>';

if (isset($_GET['q'])){
    $busqueda = $_GET['q'];
    if (ValidaVAR($busqueda)==TRUE)
    {
         $busqueda = LimpiarVAR($busqueda);
    }
    else
    {
          $busqueda = "";
    }
    if(strlen ($busqueda>6))
    {
    $sql="select 
    NumContrato,     Delegacion,     Municipio,     Colonia,     Seccion,     Fila,     Manzana,     Lote,     NombreBeneficiario,
    CONCAT(' <a  href=e003.php?contrato=',NumContrato,'><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar trámiete\"><center></a>')     as ''
    from    vivienda_tramitesdeescritura
    WHERE NombreBeneficiario like '%".$busqueda."%' OR NumContrato like '%".$busqueda."%' OR NumEscritura like '%".$busqueda."%'";
    //echo $sql;  
   TablaDinamica_MySQLVivienda("",$sql, "tramitesBusquedaTabla", "tramitesBusquedaTablaid", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
    }else
    {
        mensaje("El número de caracteres que introdujo en la búsqueda es muy poco, favor de ser más específico.",'e002.php');
    }
}

echo "</div>";
echo "<br>";
echo "<br>";
echo "<center>";

if ($direccion==10 or $direccion==19 or $direccion==46 or $direccion==54)
 {
     
/*****************PANEL TRAMITES PENDIETES*************************************/
   $PorcentajePendientes=5;
   $pendientes= TotaltramitesPendientes($direccion,$accion);
  
   echo  "<h3 class='accordion ' title='Esta barra muestra el listado de tramites pendientes tu departamento' style='
   color: white;   background-color: #ccc;   padding: 5px;   margin: 0px; background-size: ".$PorcentajePendientes."%,100%;
   background-image: url(img/wall10.jpg);   background-repeat: no-repeat; margin-top: 8px; '>
   <table width=100% ><tr><td width=30px ><img src='icon/page.png' style='width:20px;'></td><td >
   TRAMITES PENDIENTES</td><td  width=50px;  style='font-size:7pt; color:white;'>
   <b id='VoBo_Pendientes' style='padding:5px; border-radius:50%; background-color:white; color:gray; font-size:12pt; font-weight:bold; padding-left: 8px; padding-right: 8px;'>".$pendientes."</b>
   </td></tr></table></h3>
   <div class='panel' style='width:100%'>";
       
    $paso = ObtenerPaso($direccion,$accion);
    $llenos= ObtenerQueCamposDeberiaEstarLlenos($paso);

    if($direccion==10)
    {
        $llenos=null;
        

    }

    if($llenos!=null){
        $sql="select 
    NumContrato,     Delegacion,     Municipio,     Colonia,     Seccion,     Fila,     Manzana,     Lote,     NombreBeneficiario,
    CONCAT(' <a  href=e003.php?contrato=',NumContrato,'><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar trámiete\"><center></a>')     as ''
    from      vivienda_tramitesdeescritura where ".$paso. "=0 and ". substr($llenos,0,  strrpos($llenos, "and"));

    }else{
        $sql="select 
        NumContrato,     Delegacion,     Municipio,     Colonia,     Seccion,     Fila,     Manzana,     Lote,     NombreBeneficiario,
        CONCAT(' <a  href=e003.php?contrato=',NumContrato,'><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar trámiete\"><center></a>')     as ''
        from      vivienda_tramitesdeescritura where ".$paso. "=0 ";
    }
       //echo $sql; 
        TablaDinamica_MySQLVivienda("",$sql, "tramitesPendientes", "tramitesPendientesid", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
    
    /* $msg='';
    if ($msg <> ''){
        echo "<label> * Estos tramites estan pendientes de Captura o Envio, sin embargo no tienes permiso para dichos movimientos sobre el Tipo de Tramite: <lu>".$msg."</lu></label>";
    } */
    echo "</div>";

    
        /*****************PANEL TRAMITES POR APROBAR************************************/
        if ($direccion==10) {
        $PorcentajePendientes=5;
        $pendientes= TotaltramitesPorAprobarJuridico($direccion,$accion);
        echo  "<h3 class='accordion ' title='Esta barra muestra el listado de tramites pendientes tu departamento' style='
        color: white;
        background-color: #ccc;
        padding: 5px;
        margin: 0px;
        background-size: ".$PorcentajePendientes."%,100%;
        background-image: url(img/wall10.jpg);
        background-repeat: no-repeat;
        margin-top: 8px;

        '><table width=100% ><tr><td width=30px ><img src='icon/page.png' style='width:20px;'></td><td >
        TRAMITES POR APROBAR</td><td  width=50px;  style='font-size:7pt; color:white;'>
        <b id='VoBo_Pendientes' style='padding:5px; border-radius:50%; background-color:white; color:gray; font-size:12pt; font-weight:bold; padding-left: 8px; padding-right: 8px;'>".$pendientes."</b>
        </td></tr></table></h3>
        <div class='panel' style='width:100%'>";
            
        $paso = ObtenerPaso($direccion,$accion);
        $llenos= ObtenerQueCamposDeberiaEstarLlenos($paso);


        if($llenos!=null){
            $sql="select 
        NumContrato,     Delegacion,     Municipio,     Colonia,     Seccion,     Fila,     Manzana,     Lote,     NombreBeneficiario,
        CONCAT(' <a  href=e003.php?contrato=',NumContrato,'><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar trámiete\"><center></a>')     as ''
        from      vivienda_tramitesdeescritura where ".$paso. "=0 and ". substr($llenos,0,  strrpos($llenos, "and"));

        }else{
            $sql="select 
            NumContrato,     Delegacion,     Municipio,     Colonia,     Seccion,     Fila,     Manzana,     Lote,     NombreBeneficiario,
            CONCAT(' <a  href=e003.php?contrato=',NumContrato,'><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar trámiete\"><center></a>')     as ''
            from      vivienda_tramitesdeescritura where ".$paso. "=0 ";
        }
         //   echo $sql; 
            TablaDinamica_MySQLVivienda("",$sql, "tramitesPorAprobar", "tramitesPorAprobarid", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
        
        /* $msg='';
        if ($msg <> ''){
            echo "<label> * Estos tramites estan pendientes de Captura o Envio, sin embargo no tienes permiso para dichos movimientos sobre el Tipo de Tramite: <lu>".$msg."</lu></label>";
        } */
        echo "</div>";
        }
      /*****************PANEL TRAMITES EN PAUSA*************************************/

      $PorcentajeDevueltos=0;
      $pausa= TotaltramitesPausa($direccion,$accion);
      echo  "<h3 class='accordion ' title='Esta barra muestra el listado de tramites en pausa' style='
      color: white;
      background-color: #ccc;
      padding: 5px;
      margin: 0px;
      background-size: ".$PorcentajeDevueltos."%,100%;
      background-image: url(img/wall10.jpg);
      background-repeat: no-repeat;
      margin-top: 8px;
  
      '><table width=100% ><tr><td width=30px ><img src='icon/page.png' style='width:20px;'></td><td >
      TRAMITES EN PAUSA</td><td  width=50px;  style='font-size:7pt; color:white;'>
      <b id='Devueltos' style='padding:5px; border-radius:50%; background-color:white; color:gray; font-size:12pt; font-weight:bold; padding-left: 8px; padding-right: 8px;'>".$pausa."</b>
      </td></tr></table></h3>
      <div class='panel' style='width:100%'>";
     
      $paso = ObtenerPaso($direccion,$accion);
  
      $sql="select 
      NumContrato,     Delegacion,     Municipio,     Colonia,     Seccion,     Fila,     Manzana,     Lote,     NombreBeneficiario,
      CONCAT(' <a  href=e003.php?contrato=',NumContrato,'><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar trámiete\"><center></a>')     as ''
      from      vivienda_tramitesdeescritura where ".$paso. "=2 ";
  
      //echo $sql;  
      TablaDinamica_MySQLVivienda("",$sql, "tramitesPausa", "tramitesPausaid", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
  
    //   $msg='';
    //   if ($msg <> ''){
    //       echo "<label> * Estos tramites estan pendientes de Captura o Envio, sin embargo no tienes permiso para dichos movimientos sobre el Tipo de Tramite: <lu>".$msg."</lu></label>";
    //   }
      echo "</div>";

/*****************PANEL TRAMITES DEVUELTOS  O POR REVISAR*************************************/

    $PorcentajeDevueltos=0;
    $devueltos= TotaltramitesDevueltos($direccion,$accion);
    echo  "<h3 class='accordion ' title='Esta barra muestra el listado de tramites devueltos o por revisar en tu departamento' style='
    color: white;
    background-color: #ccc;
    padding: 5px;
    margin: 0px;
    background-size: ".$PorcentajeDevueltos."%,100%;
    background-image: url(img/wall10.jpg);
    background-repeat: no-repeat;
    margin-top: 8px;
    '><table width=100% ><tr><td width=30px ><img src='icon/page.png' style='width:20px;'></td><td >
    TRAMITES DEVUELTOS O PARA REVISION</td><td  width=50px;  style='font-size:7pt; color:white;'>
    <b id='Devueltos' style='padding:5px; border-radius:50%; background-color:white; color:gray; font-size:12pt; font-weight:bold; padding-left: 8px; padding-right: 8px;'>".$devueltos."</b>
    </td></tr></table></h3>
    <div class='panel' style='width:100%'>";
   
    $paso = ObtenerPaso($direccion,$accion);

    $sql="select 
    NumContrato,     Delegacion,     Municipio,     Colonia,     Seccion,     Fila,     Manzana,     Lote,     NombreBeneficiario,
    CONCAT(' <a  href=e003.php?contrato=',NumContrato,'><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar trámiete\"><center></a>')     as ''
    from      vivienda_tramitesdeescritura where ".$paso. "=3 ";

   // echo $sql;  
    TablaDinamica_MySQLVivienda("",$sql, "tramitesDevueltos", "tramitesDevueltosid", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal

    // $msg='';
    // if ($msg <> ''){
    //     echo "<label> * Estos tramites estan pendientes de Captura o Envio, sin embargo no tienes permiso para dichos movimientos sobre el Tipo de Tramite: <lu>".$msg."</lu></label>";
    // }
    echo "</div>";


    echo "</center>";
}


} else {mensaje("No tiene acceso a esta aplicacion",'');}

?>



<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>