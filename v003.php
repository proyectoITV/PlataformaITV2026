<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>


<?php
require("config.php");
$id_aplicacion = 'ap101';
xd_update('ap101',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){


    //RECIBIR DATOS EN PARA GUARDAR EN LAS TABLAS DE VIVIENDA
    /*if(isset($_POST['Guardar'])){
        $FolioTramite = $_POST['FolioTramite'];
        //enviarDatosaVivienda($FolioTramite, $IdPrograma, $IdDelegacion, $Folio, $IdSolicitante, $origenDeEnvio, $tipoInfo, $nitavu, $operacion)
        //EN OPERACION MANDAMOS 1 POR QUE ES UN INSERT 
        enviarDatosaVivienda($FolioTramite,'','','','','',1,$nitavu,1);
    }*/

    //RECIBIR DATOS PARA CANCELAR SOLICITUD
    if(isset($_POST['idprog']) and isset($_POST['iddeleg']) and isset($_POST['folio'])){
        $IdPrograma = $_POST['idprog'];
        $IdDelegacion = $_POST['iddeleg'];
        $Folio = $_POST['folio'];
        $motivo = $_POST['inlineRadioOptions'];

        //BUSCAMOS SI YA ESTA CONTRATADO
        if(buscarSiYaTieneContrato($IdDelegacion, $IdPrograma, $Folio) == ''){
            //BUSCAMOS PAGOS RELALIZADOS
            $sql = 'SELECT * FROM pagos WHERE Cancelado = 0 AND IdDelegacion='.$IdDelegacion.' AND IdPrograma='.$IdPrograma.' AND Folio='.$Folio.' ORDER BY NumPago';
            //echo $sql;
            $r2 = $Vivienda -> query($sql);
			$r_count2 = $r2 -> num_rows;
            if($r_count2 > 0){
                mensaje('No puedes cancelar la solicitud debido a que existe uno o mas pagos realizados', 'v003.php');
            }else{
                //SE CANCELA EN SOLICITUDES
                $cancelado = cancelarSolicitud($IdPrograma,$IdDelegacion,$Folio,$motivo,$nitavu);

                if($cancelado==TRUE){
                    //ACTUALIZAMOS EN LA BD ITAVU SOLICITUDESTEMP PARA QUE PUEDA VOLVER A CREAR UNA SOLICITUD PARA LA MISMA PERSONA EN CASO QUE SE NECESITE
                    $sql = "UPDATE solicitudestemp SET Estado = 5 WHERE IdDelegacion = ".$IdDelegacion." and IdPrograma = ".$IdPrograma." and FolioVivienda = ".$Folio." ";
                   // echo $sql;
                    if ($conexion->query($sql) == TRUE){
                        echo 'Se actualizo el folio en plataforma';
                    }
                    //BUSCAMOS DATOS EVALUACION
                    $sql3 = 'SELECT * FROM datosevaluacion WHERE IdDelegacion='.$IdDelegacion.' AND IdPrograma='.$IdPrograma.' AND  Folio='.$Folio.'';
                    $r3 = $Vivienda -> query($sql3);
                    $r_count3 = $r3 -> num_rows;
                    if($r_count3 > 0){
                        while($f3 = $r3 -> fetch_array()) {
                            if ($f3['Aprobado'] = -1 And $f3['IdEmpEvaluador'] <> 0 And $f3['FechaEvaluacion'] <> ''){
                                $sql4 = "Update Metas Set MontoAutorizado= (MontoAutorizado) - (".$f3['MontoCredito']."), AccionesAutorizadas= (AccionesAutorizadas) - (1) Where IdDelegacion=".$IdDelegacion." and IdPrograma=".$IdPrograma."";
                               // echo $sql4;
                                if ($Vivienda->query($sql4) == TRUE){
                                    echo  'TRUE1';
                                }else{
                                    echo 'FALSE1';
                                } 

                            }
                        }

                    }

                    //ACTUALIZAMOS SOLESTATUS
                    $sql4 = 'SELECT * FROM solestatus WHERE IdDelegacion='.$IdDelegacion.' AND  IdPrograma='.$IdPrograma.' AND Folio='.$Folio.' AND NivelEstatus=1';
                    $r4 = $Vivienda -> query($sql4);
                    $r_count4 = $r4 -> num_rows;
                    if($r_count4 > 0){
                        
                        $sql = "UPDATE solestatus SET IdEstatus = ".$motivo." WHERE IdDelegacion=".$IdDelegacion." AND  IdPrograma=".$IdPrograma." AND Folio=".$Folio."";
                        //echo $sql;
                        if ($Vivienda->query($sql) == TRUE)
                        {
                            echo 'TRUE2';
                        }else{
                            echo 'FALSE2';
                            
                        }

                    }else{
                        $sql = "INSERT INTO solestatus (IdDelegacion, IdPrograma, Folio, NivelEstatus,  Enviar, FechaCaptura, FechaUltimaMod, IdEmpCrea, IdEmpModifica,
                         IdEstatus, OrigenDeEnvio)
                        VALUES(".$IdDelegacion.", ".$IdPrograma.", ".$Folio.", 1, 1, now(), now(), ".$nitavu.", ".$nitavu.", ".$motivo.", ".$IdDelegacion.")";
                        //echo $sql;

                        $rc= $Vivienda -> query($sql);
                        if ($Vivienda->query($sql) == TRUE)
                        {
                            echo 'TRUE3';
                        }else{
                            echo 'FALSE3';
                            
                        }
                    }


                    historia($nitavu,'Cancele la solicutud con Folio '.$Folio.', IdPrograma '.$IdPrograma.' y IdDelegacion '.$IdDelegacion.'');
                    mensaje('Se cancelo exitosamente la solicutd', 'v003.php');
                }else{
                    historia($nitavu,'Intente cancelar pero hubo un error en la solicutud con Folio '.$Folio.', IdPrograma '.$IdPrograma.' y IdDelegacion '.$IdDelegacion.'');
                    mensaje('Ocurrio un problema, por favor intentelo de nuevo', 'v003.php');
                }
            }

			
            

        }else{
            mensaje('Imposible cancelar la solicitud. Debido que existe un contrato o un pago inicial...', 'v003.php');
        }

      
    }

    //CREAR NUEVA SOLICITUD CON UN FOLIO ANTERIOR
    if(isset($_POST['idprog1']) and isset($_POST['iddeleg1']) and isset($_POST['folio1'])){
        $IdPrograma = $_POST['idprog1'];
        $IdDelegacion = $_POST['iddeleg1'];
        $Folio = $_POST['folio1'];
        $programanvo = $_POST['programanvo'];

        //OBTENER FOLIO DE LA SOLICITUD EN LA BD DE ITAVU
        $FolioTramite = folioTramiteDeLaSolicitud($Folio, $IdPrograma, $IdDelegacion);

        if($FolioTramite == ''){
            //si no existe un folioTramite quiere decir que esa solicitud no existe en la base temporal de solicitudes itavu
            //entonces se tendria que hacer una rutina para pasar de la base de vivienda a la misma vivienda
            //how?
            //NECESITO EL IDSOLICITANTE PARA SACAR LOS DATOS DE EL 


            //VALIDAMOS TECHO FINANCIERO
            $recursoActual =  Valida_TechoFinanciero($IdDelegacion, $programanvo);
            if($recursoActual <= 0){
                mensaje('Imposible continuar, no hay recurso para este programa','v003.php');
            }
            $folionvo= IdSiguienteFolio($IdDelegacion, $programanvo);

            $msj = crearSolicitudApartirDeExistente($IdPrograma, $IdDelegacion, $Folio, $programanvo, $folionvo, $nitavu);

            mensaje($msj, 'v003.php');


        }else{
            //VALIDAMOS TECHO FINANCIERO
            $recursoActual =  Valida_TechoFinanciero($IdDelegacion, $programanvo);
            if($recursoActual <= 0){
                mensaje('Imposible continuar, no hay recurso para este programa','v003.php');
            }
            //hay que crear nueva solicitud
            //EN OPERACION MANDAMOS UN 1 POR QUE ES UN INSERT 
            $msj =enviarDatosaVivienda($FolioTramite, '','','','','',1,$nitavu,1,$programanvo);

            mensaje($msj, 'v003.php');
        }
    

        


        
    }
    
    //DATOS PARA ELIMINAR DE PENDIENTES 
    if(isset($_POST['eliminar'])){
        $Motivo = $_POST['motivo'];
        $IdSolicitud = $_POST['IdSolicitud'];
       

        $sql2 = 'UPDATE solicitudestemp SET Eliminado = 1, RazonEliminado="'.$Motivo.'" WHERE IdSolicitud='.$IdSolicitud.'';       
        if ($conexion->query($sql) == TRUE){
			historia($nitavu,'Elimine la solicitud '.$IdSolicitud.' por este motivo "'.$Motivo.'"');			
			mensaje('Se ha eliminado con éxito la solicitud.','v003.php');

		}else{
			historia($nitavu,'Error al eliminar la solicitud '.$IdSolicitud.' por este motivo "'.$Motivo.'"');			
			mensaje('ERROR: Ocurrio un error al intentar eliminar, por favor intentelo de nuevo.','v003.php');
		}
			
    }
    

    echo "<div id='respuestaa'></div>";
    echo '<input type="hidden" id="nitavu" name="nitavu" value="'.$nitavu.'">';
   echo "<br><br>";
   echo "<div>";

    $dpto =  midelegacion_id($nitavu);
   // if($dpto<>''){
    if($dpto<>''){
        $sql = 'Select * from solicitudestemp WHERE IdDelegacion = '.$dpto.' and Estado = 0 and NitavuCaptura = '.$nitavu.' and Eliminado = 0
        union 
        Select * from solicitudestemp WHERE IdDelegacion = '.$dpto.' and Estado = 0 and NitavuCaptura <> '.$nitavu.' and Eliminado = 0 order by Fecha';

    }else{
        $sql = 'Select * from  solicitudestemp WHERE Estado = 0 and NitavuCaptura = '.$nitavu.' and Eliminado = 0 order by Fecha';
    }

       // $sql = 'Select * from solicitudestemp WHERE IdDelegacion = '.$dpto.' and Estado = 0';
     
   // echo $sql;
        $r = $conexion -> query($sql);
        if ($r -> num_rows >0){
            
            echo "<h2>Pendientes por terminar captura</h2>";
            echo "<center>";
            echo "<table class='tabla' style='width:80%;'>";
            echo "<th>ID</th>";
            echo "<th>DESCRIPCIÓN</th>";
            echo "<th>EDITAR</th>";
           
            while($f = $r -> fetch_array())
            { // resultado de la busqueda.................
                echo "<tr>";
                
                    echo "<td width='5%'>";
                    echo $f['IdSolicitud'];
                    echo "</td>";
                    echo "<td >";
                        echo "<div style ='display: table-cell; vertical-align: middle; width: 80%'>";
                            echo '<span style="font-size: 14px; color:#848484; font-family:sans-serif;"><b>'.$f['Curp'].'</b><br>';
                            echo ''.$f['NombreBeneficiario'].'</span>';
                            echo "<br><span>Programa: ".$f['IdPrograma']."-".NombrePrograma($f['IdPrograma'])."     Delegación: ".$f['IdDelegacion']."-".nombreDelegacionVivienda($f['IdDelegacion'])." </span>";
                            //echo '<br><hr><span style="color:blue;">Creado por:   ['.$f['NitavuCaptura'].'] - '.nitavu_nombre($f['NitavuCaptura']).'</span>';
                            echo "<br><label style='font-size:7pt; margin:0px; padding:0px;'>Capturado por ".nitavu_nombre($f['NitavuCaptura'])." - ".$f['Fecha']." : ".$f['Hora']." en ".DptoNombre($f['DptoCaptura'])." </label>";

                            echo "</div>";
                        echo '<div id="por'.$f['IdSolicitud'].'" align="center" style="vertical-align: middle;display: table-cell;" >';                        
                            $Porcentaje = Procentajesolicitudestemp($f['IdSolicitud']); 
                            GraficaPorcentaje2('por'.$f['IdSolicitud'],$Porcentaje);
                        echo "</div>";
                    echo "</td>";
                    echo "<td >";
                    echo '<form action="v003_iniciar.php" method="POST">';
                    echo "<input type='hidden' name='_id' id='_id' value=".$f['IdSolicitud'].">";
                    echo "<input type='hidden' name='programa' id='programa' value=".$f['IdPrograma'].">";
                    echo "<input type='hidden' name='delegacion' id='delegacion' value=".$f['IdDelegacion'].">";
                    echo "<button  id='editar' name='ediar' class='Mbtn btn-default' title='Clic para seguir editando la solicitud'><img src='icon/btn_derecha.png' style='widht:15px; height:15px;'></button>";
                    echo "</form>";
                    echo "</td>";
                    if($f['NitavuCaptura']==$nitavu){
                        echo "<td >";

                        echo "<a href='#modalEliminar".$f['IdSolicitud']."' rel='MyModal:open' class='btn btn-danger' title='Clic para eliminar el registro de pendientes'><img src='icon/delete.png' style='width:16px; height:18px;'></a>";
                        echo "<div id='modalEliminar".$f['IdSolicitud']."' class='MyModal'><h3>Razón por la cual desea eliminar: </h3>";
                        echo '<form action="v003.php" method="POST">';
                        echo "<textarea name='motivo'></textarea>";
                        echo "<input type='hidden' name='IdSolicitud' id='IdSolicitud' value=".$f['IdSolicitud'].">";
                        echo "<button id='eliminar' name='eliminar' class='Mbtn btn-default'>Confirmar</button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</td>";
                    }
                echo "</tr>";
            }
            echo "</table>";
            echo "</center>";
        }else{
            echo "<div>";
                echo '<span style="font-family:verdana; font-size:14pt; color: #D4D9DA;">No hay pendientes que mostrar...</span>';
            echo "</div>";
        }
   // }else{
     /*   echo "<div><center>";
            echo '<span style="font-family:verdana; font-size:14pt; color: #D4D9DA;">No perteneces a una delegación, por esta razón no se muestran pendientes...</span>';
        echo "</center></div>";*/
   // }
   echo "</div>";



echo "<div id='req_menu'>"; 
    echo "<a href='#iniciarTramite' rel='MyModal:open' class=' btn-g' title='Registrar nueva solicitud'>";
        echo "<table  width='100%'><tr><td valign='middle' align='center'>";
        echo "<img src='icon/mas2.png' >";
        echo "</td>";
        echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
        // echo "Registrar Oficio";
        echo "</td></tr></table>";
    echo "</a>";

    echo "<a href='#busquedaporNombre' rel='MyModal:open' class='btn-g4' title='Busqueda por nombre' style='font-family: Compacta;'>";
        echo "<table  width='100%'><tr><td valign='middle' align='center'>";
        echo "<img src='icon/solicitud1.png' >";
        echo "</td>";
        echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
        // echo "Asignar Permisos";
        echo "</td></tr></table>";
    echo "</a>";	

   /* echo "<a href='#busquedaContrato' rel='MyModal:open' class='btn-g3' title='Busqueda por contrato' style='font-family: Compacta;'>";
        echo "<table  width='100%'><tr><td valign='middle' align='center'>";
        echo "<img src='icon/user_add.png' >";
        echo "</td>";
        echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
        // echo "Asignar Permisos";
        echo "</td></tr></table>";
    echo "</a>";*/

    echo "<a href='#busquedaFolio' rel='MyModal:open' class='btn-g3' title='Busqueda por folio' style='font-family: Compacta;'>";
        echo "<table  width='100%'><tr><td valign='middle' align='center'>";
        echo "<img src='icon/folio.png' >";
        echo "</td>";
        echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
        // echo "Asignar Permisos";
        echo "</td></tr></table>";
    echo "</a>";


    echo "<a href='#SolicitudHistorica' rel='MyModal:open' class='btn-g2' title='Solicitud Historica' style='font-family: Compacta;'>";
        echo "<table  width='100%'><tr><td valign='middle' align='center'>";
        echo "<img src='icon/cargo.png' >";
        echo "</td>";
        echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
        // echo "Asignar Permisos";
        echo "</td></tr></table>";
    echo "</a>";	
echo "</div>";

// ---------------------CREAR NUEVA SOLICITUD**************
echo "<div id='iniciarTramite' class='MyModal'>";
echo "<h3>Solicitar un Tramite: </h3>";
echo "<form action='v003_iniciar.php' method='POST'>";
echo "<div style='width:100%;'>";
echo "<div >";
echo "<label for='delegaciones2'>Seleccione una delegación:";
echo "<select name='delegaciones2' id='delegaciones2'>";
    $sql = "SELECT * FROM delegaciones where Tipo = 0 ORDER by Delegacion ASC";
    $r = $Vivienda -> query($sql);
    while($f = $r -> fetch_array())
    { // resultado de la busqueda.................
        echo "<option value='".$f['IdDelegacion']."'>".$f['Delegacion']. "</option>";
    }
echo "</select>";
echo "</div>";
echo "<div>";
echo "<label for='programas2'>Seleccione un programa:";
echo "<select name='programas2' id='programas2'>";
//id='programas'
$sql = "SELECT * FROM programa WHERE Activo=1 ORDER by Programa ASC";
    $r = $Vivienda -> query($sql);
    while($f = $r -> fetch_array())
    { // resultado de la busqueda.................
        echo "<option value='".$f['IdPrograma']."'>".$f['Programa']. "</option>";
    }

echo "</select>";
echo "</div>";
echo "</div>";
echo "<center><table width=60%><tr><td valign=top>";
   echo "<input required ='required' type='text' style='height:55px; margin:0px; font-size:19pt;' id='_curp' name='_curp' value='' maxlength='18' onkeyup='mayus(this); PortCurp();' placeholder='CURP del Solicitante' required></td>";
   echo "<td valign=top><a onclick='CURP_persona();' style='margin:0px;' class='Mbtn btn-CelesteTam' title='Buscar Datos del CURP'>
   <img src='icon/btn_derecha.png' style='width:30px' id='flecha'>
   <img src='img/loader_bar.gif' style='width:30px; display:none;' id='LoaderCurp'>
    </a></td>";
echo "</tr></table></center>";
echo "<div id='Persona' style='width:100%'>";
echo "</div>";
echo "<br><br>";
echo "<input type='submit' value='Crear' class='Mbtn btn-default'>";
echo "</form>";   
echo "</div>";


   /* echo '<form id="opciones">';
    echo '<label>Busqueda por:</label>
    <label><input type="radio" id="nombre" name="opcion" value="nombre">Nombre
    <input type="radio" id="contrato" name="opcion" value="contrato">Contrato
    <input type="radio" id="folio" name="opcion" value="folio">Folio
    <input type="radio" id="nuevo" name="opcion" value="nuevo">Nuevo
    </label>';
    echo '</form>';*/


    //--------------------buscar por nombre
echo "<div id='busquedaporNombre' class='MyModal'>";
    echo "<div id='preloaderbloque' style='display: none; width:100%'>";
    echo "<center>";
    echo "<img src='img/loader4.gif' style='width: 30%; height:30%;' class='cargando_img'>";
    echo "<label>Cargando...</label>";
    echo "</center>";
    echo "</div>"; 
    echo "<center>";
    echo "<div id='elementos' style='width:100%'>";
        echo "<div class='contenedor-tabla'>";
        echo "<div class='contenedor-fila'>";
            echo "<div class='contenedor-columna'>";
                echo "<label>Nombre</label>";
                echo "<input id='nom' name='nom'>";
            echo "</div>";
            echo "<div class='contenedor-columna'>";
                echo "<label>Apellido Paterno</label>";
                echo "<input id='apaterno' name='apaterno'>";
            echo "</div>";
            echo "<div class='contenedor-columna'>";
                echo "<label>Apellido Materno</label>";
                echo "<input id='amaterno' name='amaterno'>";
            echo "</div>";
            echo "<div class='contenedor-columna' style='vertical-align: bottom;'>";
               
                echo "<input type='submit' id='buscaNombre' name='buscaNombre' value='Buscar' onclick='buscarBeneficiarios();' class='Mbtn btn-default'>";
            echo "</div>";
        echo "</div>";
    echo "</div>";        
    echo "<div id='beneficiarios'></div>";
    echo "<div>";
    echo "</center>";
echo "</div>";


//buscar por folio
echo "<div id='busquedaFolio' class='MyModal' style='height:200px;'>";
    echo "<form action='v003_mostrarSolicitud.php' method='GET'>";
        echo "<div style='width:100%;'>";
            echo "<div  style='float:left; width:45%;'>";
            echo "<label for='delegaciones'>Seleccione una delegación:";
            echo "<select name='IdDelegacion' id='IdDelegacion'>";
            
            $sql1 = "SELECT * FROM delegaciones where Tipo = 0 ORDER by Delegacion ASC";

            //$sql = "SELECT * FROM delegaciones ORDER by Delegacion ASC";
            
                $r1 = $Vivienda -> query($sql1);
                while($f1 = $r1 -> fetch_array())
                { // resultado de la busqueda.................
                    echo "<option value='".$f1['IdDelegacion']."'>".$f1['Delegacion']. "</option>";
                }
            
            echo "</select>";
            echo "</div>";
            echo "<div style='float:right; width:45%;'>";
            echo "<label for='IdPrgrama'>Seleccione un programa:";
            echo "<select name='IdPrograma' id='IdPrograma'>";
            
            //$sql = "SELECT * FROM delegaciones where tipo = 0 ORDER by Delegacion ASC";

                $sql = "SELECT * FROM programa WHERE Activo=1 ORDER by Programa ASC";
                $r = $Vivienda -> query($sql);
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................
                    echo "<option value='".$f['IdPrograma']."'>".$f['Programa']. "</option>";
                }
            
            echo "</select>";
            echo "</label>";
            echo "</div>";
        echo "</div>";
        echo "<div style='width:100%;'>";
        echo "<div  style='float:left; width:45%;'>";
        echo "<label>Folio</label>";
        echo "<input id='Folio' name='Folio'>";
        echo "</div>";
        echo "<div style='float:right; width:45%;'>";
        echo "<input type='submit' id='buscaFolio' value='Buscar' class='Mbtn btn-default'>";
        echo "</div>";
    
    echo "</form>";
echo "</div>";

 //solicitud historica
echo "<div id='SolicitudHistorica' class='MyModal' style='height:500px;'>";
echo "<h2>Alta de Solicitud Historica</h2>";	
echo "<form action='v003_solicitudHistorica.php' method='POST'>";
    echo "<div style='width:100%;'>";
    echo "<div style='width: 100%;'>";

    echo '<div class="col-md-4">';
    echo "<label for='IdDelegacion' class='label normal' style='width: 100%; font-weight:bold'>Delegación";   
    echo "<select name='IdDelegacion' id='IdDelegacion'>";
    
    $sql1 = "SELECT * FROM delegaciones where Tipo = 0 ORDER by Delegacion ASC";

    //$sql = "SELECT * FROM delegaciones ORDER by Delegacion ASC";
    
        $r1 = $Vivienda -> query($sql1);
        while($f1 = $r1 -> fetch_array())
        { // resultado de la busqueda.................
            echo "<option value='".$f1['IdDelegacion']."'>".$f1['Delegacion']. "</option>";
        }
    
    echo "</select>";
        echo "</label>";
    echo '</div>';

    echo '<div class="col-md-4">';
        echo "<label for='IdPrograma' class='label normal' style='width: 100%; font-weight:bold'>Programa";       
        echo "<select name='IdPrograma' id='IdPrograma'>";
        
        //$sql = "SELECT * FROM delegaciones where tipo = 0 ORDER by Delegacion ASC";

            $sql = "SELECT * FROM programa WHERE IdPrograma ORDER by Programa ASC";
            $r = $Vivienda -> query($sql);
            while($f = $r -> fetch_array())
            { // resultado de la busqueda.................
                echo "<option value='".$f['IdPrograma']."'>".$f['Programa']. "</option>";
            }
        
        echo "</select>";      
        echo "</label>";
    echo '</div>';


     echo '<div class="col-md-4">';
        echo "<label for='curp' class='label normal' style='width: 100%; font-weight:bold'>Curp";
        echo "<input type='text' id=curp' name='curp'  >"; 
        echo "</label>";
      echo '</div>';
  
      echo '<div class="col-md-4">';
        echo "<label for='nombreSolicitante' class='label normal' style='width: 100%; font-weight:bold'>Nombre";
        echo "<input type='text' id=nombreSolicitante' name='nombreSolicitante'  required >"; 
        echo "</label>";
      echo '</div>';
  
      echo '<div class="col-md-4">';	
        echo "<label for='apellidoPaterno' class='label normal' style='width: 100%; font-weight:bold''>Apellido Paterno";
        echo "<input type='text' id=apellidoPaterno' name='apellidoPaterno'  required>"; 
        echo "</label>"; 
      echo '</div>';
  
      echo '<div class="col-md-4">'; 	
        echo "<label for='apellidoMaterno' class='label normal' style='width: 100%; font-weight:bold'>Apeliido Materno";
        echo "<input type='text' id=apellidoMaterno' name='apellidoMaterno' value=''  required >"; 
        echo "</label>";
      echo '</div>';

      echo '<div class="col-md-4">'; 	
      echo "<label for='FechaNacimiento' class='label normal' style='width: 100%; font-weight:bold'>Fecha de Nacimiento";
      echo "<input type='date' id=FechaNacimiento' name='FechaNacimiento' value='".date('Y-m-d',strtotime(date("Y-m-d H:i:s")))."'   >"; 
      echo "</label>";
    echo '</div>';
 

      echo '<div class="col-md-4">'; 	
      echo "<label for='IdSexo'class='label normal' style='width: 100%; font-weight:bold''>Sexo";  
      
     echo "<select  id='IdSexo'   name='IdSexo' required>";
     $sql="SELECT	* from sexo where IdSexo<3";    
     $r2 = $Vivienda -> query($sql); 
     while($f = $r2 -> fetch_array())
     {
             echo "<option value='".$f['IdSexo']."'>".$f['Sexo']."</option>";   
     }                          
    echo "</select>";      
      echo "</label>";
    echo '</div>';

    
  
      echo '<div class="col-md-4">';
        echo "<label for='FechaCaptura' class='label normal' style='width: 100%; font-weight:bold'>Fecha de Captura";     
        echo "<table width=100% class='menu_font_n10'><tr><td >";
        echo "<tr><td><input  type='date' mayus(this);'  name='FechaCaptura' id='FechaCaptura' required                                                                                                                                                     bbvbvb>
        </td>";      
        echo "<td width=13px><div style='display:none;' id='LoaderFechaCaptura'><img src='img/loader_bar.gif' style='width:13px;'>";
        echo "<div style='display:none;' id='RFechaCaptura'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
        echo "</label>";
      echo '</div>';
  
      
      echo '<div class="col-md-4">';
      echo "<button type='submit' id='guardarSolcicitud' name='guardar' class='btn btn-primary' style='width:65%'>Guardar</button>";
    echo '</div>';
  
  
  
    echo '</div>';
  
    echo '</div>';
echo "</form>";
echo "</div>";





}else{
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}

?>
<script>
var k = 0;
/*$('#opciones input').on('change', function() {
    if(($('input:radio[name=opcion]:checked').val()=='nombre')){
        $("#busquedaNombre").css({'display':'inline-block',});
        $("#busquedaContrato").css({'display':'none',});
        $("#busquedaFolio").css({'display':'none',});
        $("#nuevaSolicitud").css({'display':'none',});
        $("#SolicitudDeDatos").css({'display':'none',});
	}else if(($('input:radio[name=opcion]:checked').val()=='contrato')){
        $("#busquedaNombre").css({'display':'none',});
        $("#busquedaContrato").css({'display':'inline-block',});
        $("#busquedaFolio").css({'display':'none',});
        $("#nuevaSolicitud").css({'display':'none',});
	}else if(($('input:radio[name=opcion]:checked').val()=='folio')){
        $("#busquedaNombre").css({'display':'none',});
        $("#busquedaContrato").css({'display':'none',});
        $("#busquedaFolio").css({'display':'inline-block',});
        $("#nuevaSolicitud").css({'display':'none',});
    }else if(($('input:radio[name=opcion]:checked').val()=='nuevo')){
        $("#busquedaNombre").css({'display':'none',});
        $("#busquedaContrato").css({'display':'none',});
        $("#busquedaFolio").css({'display':'none',});
        $("#nuevaSolicitud").css({'display':'inline-block',});
    }
});*/

function buscarBeneficiarios(){
    //alert('entre');
    var nom = document.getElementById("nom").value;
    var apaterno = document.getElementById("apaterno").value;
    var amaterno = document.getElementById("amaterno").value;
    var link = 'v003_mostrarSolicitud.php';
    $("#elementos").css({'display':'none'});
    $("#preloaderbloque").css({'display':'inline-block'});
    
    
    $.ajax({
        url: "v003_busquedaNombre.php",
        type: "POST",        
        data: {nom:nom, apaterno:apaterno, amaterno:amaterno, link: link},
        success: function(data){  
           
            console.log(data);
            document.getElementById("beneficiarios").innerHTML = data;
            $("#preloaderbloque").css({'display':'none'});
            $("#elementos").css({'display':'inline-block'});
        }
    });
   
}

/*function idTipoSolicitud(){
    var prog = document.getElementById("programas2").value;
    var deleg = document.getElementById("delegaciones2").value;
    
    $.ajax({
       url: "sol_construyeFormulario.php",
      type: "post",
      data: {programa: prog, delegacion:deleg},
      success: function(data){
       $('#Formulario').html(data);
       
      }
   });

}*/

function BuscaCURP(IdRequisito, IdCat, FolioTramite, tipo, IdTipoSolicitud){
   
    var nitavu =  document.getElementById("nitavu").value;
    if(tipo==2){
        var div = IdRequisito + "_curp" + IdCat; 
         
        console.log(div);   
        var txtCURP = $("#"+div).val().toUpperCase();
    }else{
        var div = IdRequisito + "_" + IdCat;    
        var txtCURP = $("#"+div).val().toUpperCase();
    }
    
    //alert(txtCURP);

    //$("#"+div).val(txtCURP);
    var Len = $("#"+div).val().length;
    //console.log("Tamaño del CURP: " + Len);

    
    if (Len == 18){
        $("#Loader" + IdRequisito + "_" + IdCat).show();
        $.ajax({
            url: "sol_curp.php",
            type: "POST",        
            data: {IdCat:IdCat, IdRequisito:IdRequisito, txtCURP: txtCURP, nitavu:nitavu},
            success: function(data){  
                console.log(data);   

                if(data.includes('Error')!=true)                            
                {
                    //console.log('entro');
                    var cadena = data;
                    var variables = cadena.split(",");
                    var Nombre = "";
                if(tipo ==1){
                        for (var i = 0; i < variables.length; i++) {
                       
                            if(i==4){
                                //console.log(i);
                            // $("#"+ i + "_" + IdCat).val(variables[i]);
                                if(variables[i]=='M'){
                                    $("#"+ i + "_" + IdCat+" option[value=1]").attr("selected",true);
                                    
                                }else{
                                    $("#"+ i + "_" + IdCat+" option[value=2]").attr("selected",true);
                                }
                                $("#"+i + "_" + IdCat).attr("readonly","readonly");
                                $("#"+ i + "_" + IdCat+" option:not(:selected)").attr('disabled',true);
                                //console.log(i + IdCat+variables[i]);
                            }else if(i==5){
                                var fecha = variables[i].split("/");
                                var fechanueva = fecha[2]+'-'+fecha[1]+'-'+fecha[0];
                                $("#"+ i + "_" + IdCat).val(fechanueva);
                                $("#"+i + "_" + IdCat).attr("readonly","readonly");
                            }else if(i==7){
                               
                                $("#"+ i + "_" + IdCat+" option[value="+variables[i]+"]").attr("selected",true);
                                $("#"+i + "_" + IdCat).attr("readonly","readonly");
                                $("#"+ i + "_" + IdCat+" option:not(:selected)").attr('disabled',true);
                            }else{
                                console.log(i);
                                $("#"+ i + "_" + IdCat).val(variables[i]);
                                $("#"+i + "_" + IdCat).attr("readonly","readonly");
                                console.log(i + IdCat+variables[i]);
                                if(i==1){
                                    Nombre = variables[i];
                                }else if(i==2){
                                    Nombre = Nombre+' '+variables[i];
                                }else if(i==3){
                                    Nombre = Nombre+' '+variables[i];
                                }

                            }
                        $("#Loader" + IdRequisito + "_" + IdCat).hide(); 
                    }
                    //AGREGAR EL REGISTRO DE UNA NUEVA SOLICITUD
                    //SOLO CUANDO SEA EL BENEFICIARIO VA A ENTRAR AQUI
                    if(IdRequisito == 0 && IdCat == 1){
                        $.ajax({
                            url: "v003_dat3.php",
                            type: "POST",        
                            data: {IdCat:IdCat, IdRequisito:IdRequisito, txtCURP: txtCURP, nitavu:nitavu,FolioTramite:FolioTramite, variables: variables ,IdTipoSolicitud:IdTipoSolicitud, Nombre: Nombre},
                            success: function(data){  
                                document.getElementById('respuestaa').innerHTML = data;
                                NPush(data, 'Plataforma ITAVU');
                            }
                        });
                    }
                    
                    
               }else{
                    console.log('entro al 2');
                    for (var i = 0; i < variables.length; i++) {
                            
                        
                            if(i==1){
                                $("#"+ i + "_nombre"  + IdCat).val(variables[i]);
                                $("#"+i + "_nombre"  + IdCat).attr("readonly","readonly");
                                console.log(i + '_nombre'  + IdCat);
                            }else if(i==2){
                                $("#"+ i + "_ap" + IdCat).val(variables[i]);
                                $("#"+i + "_ap" + IdCat).attr("readonly","readonly");
                                console.log(i + '_ap'  + IdCat);
                            }else if(i==3){
                                $("#"+ i + "_am" + IdCat).val(variables[i]);
                                $("#"+i + "_am" + IdCat).attr("readonly","readonly");
                            }else if(i==4){
                                //console.log(i);
                            // $("#"+ i + "_" + IdCat).val(variables[i]);
                                if(variables[i]=='M'){
                                    $("#"+ i + "_sexo" + IdCat +" option[value=1]").attr("selected",true);
                                    
                                }else{
                                    $("#"+ i + "_sexo" + IdCat+" option[value=2]").attr("selected",true);
                                }
                                $("#"+i + "_sexo" + IdCat).attr("readonly","readonly");
                                $("#"+ i + "_sexo" + IdCat+" option:not(:selected)").attr('disabled',true);
                                //console.log(i + IdCat+variables[i]);
                            }else if(i==5){
                                var fecha = variables[i].split("/");
                                var fechanueva = fecha[2]+'-'+fecha[1]+'-'+fecha[0];
                                $("#"+ i + "_fechan" + IdCat).val(fechanueva);
                                $("#"+i + "_fechan" + IdCat).attr("readonly","readonly");
                            }else if(i==6){
                                //console.log(i);
                                $("#"+ i + "_nacionalidad" + IdCat).val(variables[i]);
                                $("#"+i + "_nacionalidad" + IdCat).attr("readonly","readonly");
                                //console.log(i + IdCat+variables[i]);
                            }else if(i==7){
                                $("#"+ i + "_entidadf" + IdCat).val(variables[i]);
                                $("#"+i + "_entidadf" + IdCat).attr("readonly","readonly");
                            }else if(i==8){
                                $("#"+ i + "_status" + IdCat).val(variables[i]);
                                $("#"+i + "_status" + IdCat).attr("readonly","readonly");
                                
                            }
                        }
                        
                        
                    }
                   // $("#R" + IdRequisito + "_" + IdCat).html(data+"\n");   
                
                   
                // $("#Loader" + IdRequisito + "_" + IdCat).hide();  
              //SI ES EL BENEFICIARIO SE AGREGA EL REGISTRO A SOLICITUDES
              
                    
                }else{
                    NPush('ERROR al obtener el datos del CURP solicitado. '+data, 'Plataforma ITAVU');
                }



                


                //$('#' + IdRequisito + '_' + IdCategoria).hide();
                //location.href="v003.php";
                //location.reload();

                //Agregar require al resto de los input


            }
         });
 
    }

    console.log("->" + txtCURP);

}

var x = 0;
//$('#btn-Add').click(function() {
function agregarDependiente(){
    x = x+1;
    $.ajax({
        url: "sol_dat1.php",
        type: "POST",        
        data: {x:x},
        success: function(data){  
           // console.log(data);   
            $('#Categoria30').append(data);
            var acc = document.getElementsByClassName("accordion1");
            var i;

            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function() {
                    /* Toggle between adding and removing the "active" class,
                    to highlight the button that controls the panel */
                    this.classList.toggle("active");

                    /* Toggle between hiding and showing the active panel */
                    var panel = this.nextElementSibling;
                    if (panel.style.display === "block") {
                        panel.style.display = "none";
                    } else {
                        panel.style.display = "block";
                    }
                });
            }
           
        }
    });

   

    /*console.log(select);
    var item = `
    <h1 class='accordion' style='width:100%; margin: 0px;font-size: 10pt;font-family:Light; text-transform: uppercase;'>Datos Dependientes<img src='icon/flecha_abajo.png' style='width:18px; opacity:0.5;'></h1>
    <div class='panel'>
    <div class='elemento' style='background-color:#ffdea1;'><table width=100%><tr><td style='width:95%;'><label><b>CURP</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>
    <tr><td><input  maxlength='18'  type='text' onkeypress='BuscaCURP(0,30);'  name='0_30' id='0_30' ></td><td width=13px><div style='display:none;' id='Loader0_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='R0_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>
    <div class='elemento'><label>*<b>Nombre</b><br> <cite></cite></label>
    <table width=100%><tr><td><input type='text' name='1_30' id='1_30' required ></td><td width=13px><div style='display:none;' id='Loader1_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK1_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>
    <div class='elemento'><label>*<b>Apellido Paterno</b><br> <cite></cite></label>
    <table width=100%><tr><td><input type='text' name='2_30' id='2_30' required ></td><td width=13px><div style='display:none;' id='Loader1_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK1_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>
    <div class='elemento'><label>*<b>Apellido Materno</b><br> <cite></cite></label>
    <table width=100%><tr><td><input type='text' name='3_30' id='3_30' required ></td><td width=13px><div style='display:none;' id='Loader1_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK1_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>
    ${select}
    </div>
    `;

    $('#Categoria30').append(item);*/
    
    // Añadir caja de <texto class=""></texto>
    /*$('#Categoria30').append("<h1 class='accordion' style='width:100%; margin: 0px;font-size: 10pt;font-family:Light; text-transform: uppercase;'>Datos Dependientes<img src='icon/flecha_abajo.png' style='width:18px; opacity:0.5;'></h1>");
    $('#Categoria30').append("<div class='panel'>");
       
        $('#Categoria30').append("<div class='elemento' style='background-color:#ffdea1;'><table width=100%><tr><td style='width:95%;'><label><b>CURP</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>");
        $('#Categoria30').append("<tr><td><input  maxlength='18'  type='text' onkeypress='BuscaCURP(0,30);'  name='0_30' id='0_30' ></td><td style='width:13px;'><div style='display:none;' id='Loader0_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='R0_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>");																		                        
        $('#Categoria30').append("</div>");

        $('#Categoria30').append("<div class='elemento'><label>*<b>Nombre</b><br> <cite></cite></label>");
        $('#Categoria30').append("<table width=100%><tr><td><input type='text' name='1_30' id='1_30' required ></td><td width=13px><div style='display:none;' id='Loader1_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK1_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>");
        $('#Categoria30').append("</div>");

    $('#Categoria30').append("</div>");*/

    
   
    //$('#Categoria30').append("<div class='panel'><div class='elemento' style='background-color:#ffdea1;'><table width=100%><tr><td style='width:95%;'><label><b>CURP</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr><tr><td><input  maxlength='18'  type='text' onkeypress='BuscaCURP(0,30);'  name='0_30' id='0_30' ></td><td width=13px><div style='display:none;' id='Loader0_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='R0_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table> </div> </div>");																                        
        
    
 
       																		
    
    
//});
}

function mayus(e) {
    e.value = e.value.toUpperCase();
}

function CargaLocalidad(){
    var IdMunicipio =  document.getElementById("39_5").value;
    $.ajax({
        url: "sol_localidades.php",
        type: "POST",        
        data: {IdMunicipio: IdMunicipio},
        success: function(data){  
            document.getElementById('40_5').options.length = 0;
            $("#40_5").append(data);
        }
    });

}

function CargaLocalidad(){
    var IdMunicipio =  document.getElementById("39_5").value;
    $.ajax({
        url: "sol_localidades.php",
        type: "POST",        
        data: {IdMunicipio: IdMunicipio},
        success: function(data){  
            document.getElementById('40_5').options.length = 0;
            $("#40_5").append(data);
        }
    });

}

function CargaColonia(){
    var IdMunicipio =  document.getElementById("39_5").value;
    $.ajax({
        url: "sol_colonias.php",
        type: "POST",        
        data: {IdMunicipio: IdMunicipio},
        success: function(data){  
            document.getElementById('41_5').options.length = 0;
            $("#41_5").append(data);
        }
    });

}
function SubirArchivo(FolioTramite, IdRequisito, IdCategoria,tipoInfo){
$("#Loader" + IdRequisito + "_" + IdCategoria).show();			
var inputFileImage = document.getElementById(""+IdRequisito + "_" + IdCategoria);
var file = inputFileImage.files[0];
var data = new FormData();
data.append(''+IdRequisito,file);
data.append('Folio',FolioTramite);
data.append('IdRequisito',IdRequisito);
data.append('IdCategoria',IdCategoria);
data.append('tipoInfo',tipoInfo);

$.ajax({
        url: "v003_dat2.php",        
        type: "POST",             
        data: data, 			  
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(data)   
        {
            console.log(data);
            $('#PDF' + IdRequisito + "_" + IdCategoria).html(data);
            $("#Loader" + IdRequisito + "_" + IdCategoria).hide(); 
        }
    });
    

} 


function GuardarDato(FolioTramite, IdRequisito, IdCategoria, tipoInfo){
    //alert('entro funcion guardar dato');
    var nitavu =  document.getElementById("nitavu").value;
  
    var Valor = $("#" + IdRequisito + "_" + IdCategoria).val();
    $("#Loader" + IdRequisito + "_" + IdCategoria).show();
    $.ajax({
    url: "v003_dat1.php",
    type: "get",        
    data: {Folio:FolioTramite, IdRequisito:IdRequisito, value:Valor, IdCategoria:IdCategoria, nitavu:nitavu, tipoInfo:tipoInfo},
    success: function(data){                                
        $("#" + IdRequisito + "_" + IdCategoria).html(data+"\n");   
        // console.log("Guardando " + IdRequisito + "_" + IdCategoria + ":" + data);
        $("#Loader" + IdRequisito + "_" + IdCategoria).hide();  
    }
    });

}
function PortCurp(){
var curp = $('#_curp').val();

$('#txtCurp').val(curp);
}

function CURP_persona(){
var curp = $('#_curp').val();

var Len = $("#_curp").val().length;
    //console.log("Tamaño del CURP: " + Len);
    $('#txtCurp').val(curp);
    console.log(curp);
    if (Len == 18){
        $("#flecha").hide();
        $("#LoaderCurp").show();
        $.ajax({
            url: "v003curp.php",
            type: "get",        
            data: {curp:curp},
            success: function(data){   
            $('#Persona').html(data);
                $("#flecha").show();
                $("#LoaderCurp").hide();
            }
        }); 
    }else{
        NPush('Hacen falta caracteres en el CURP para poder buscarlo.','Plataforma ITAVU');
    }

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