<?php
include("./lib/body_head.php");
include("./lib/body_menu.php"); 



$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap87";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
$nivel=1;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    $dpto = nitavu_dpto($nitavu);
    $pags=20;
    historia($nitavu,'['.$id_aplicacion.'] Usando tramites App'); 
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	

    //Definir alcance 
    $DepartamentoAlcance = "";
    if ($nivel > 3) {
        $nivel = 1;
    }

    if ($nivel == 2 or $nivel==3) { //Todos los de mi direccion o Departamento, segun tu gerarquia
        $DepartamentoAlcance = MisDptosIn($nitavu);

    }

    if (isset($_GET['g'])){
        echo "<table style='margin-top:20px;' width=100%><tr><td width=".$_GET['g']."% align=left valign=top>"; // lista de datos
    }
    else {
        echo "<table style='margin-top:20px;' width=100%><tr><td width=80% align=left valign=top>"; // lista de datos
    }
    
    //guardamos la información de ahorro previo 
    if(isset($_POST['ahorro']) and isset($_POST['tiempo'])){
        $ahorro = $_POST['ahorro'];
        $tiempo = $_POST['tiempo'];
        $idTramite = $_POST['IdTramite'];

        $query = "UPDATE tramites SET AhorroPrevio = ".$ahorro.", Tiempo = ".$tiempo." WHERE IdTramite = ".$idTramite."";
        echo $query;
        if ($conexion->query($query) == TRUE)
        {
            mensaje('Se han guardado los datos correctamente.','tramites.php');
        }else{
            mensaje('Ocurrio un error, intentelo de nuevo.','tramites.php');
        }


    }

    //DATOS PARA ELIMINAR DE PENDIENTES 
    if(isset($_POST['eliminar'])){
        $Motivo = $_POST['motivo'];
        $IdTramite = $_POST['IdTramite'];
       

        $sql = 'UPDATE tramites SET Eliminado = 1, RazonEliminado="'.$Motivo.'" WHERE IdTramite='.$IdTramite.'';
        if ($conexion->query($sql) == TRUE){
			historia($nitavu,'Elimine el tramite '.$IdTramite.' por este motivo "'.$Motivo.'"');			
			mensaje('Se ha eliminado con éxito el tramite.','tramites.php');

		}else{
			historia($nitavu,'Error al eliminar el tramite '.$IdTramite.' por este motivo "'.$Motivo.'"');			
			mensaje('ERROR: Ocurrio un error al intentar eliminar, por favor intentelo de nuevo.','tramites.php');
		}
			
    }

    // ===============  BARRA CAPTURAS PENDIENTES DE ENVIAR ===============================
    if ($nivel == 3 or $nivel==2){
        $sql=" 
        select 
        a.*,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=0
        ),FALSE) Captura,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=1
        ),FALSE) VoBo,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=3
        ),FALSE) Aprobar
        
         
        from tramitesitavu a WHERE
        DptoCaptura in(".$DepartamentoAlcance.") AND Estado in(0,4) "; //<-- Filtramos los tramites por Captura y Devueltos
        $sql_count=" 
               
            SELECT 
            (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(".$DepartamentoAlcance.") AND EstadoCaptura='LISTO PARA ENVIAR' 	AND Estado IN ( 0, 4 ) and Eliminado = 0) as Listos,
            (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(".$DepartamentoAlcance.") AND EstadoCaptura='PENDIENTE' 	AND Estado IN ( 0, 4 ) and Eliminado = 0) as Pendientes,
            (
                ( (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(".$DepartamentoAlcance.") AND EstadoCaptura='PENDIENTE' AND Estado IN ( 0, 4 ) and Eliminado = 0 )  * 100 ) / (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(55) AND  Estado IN ( 0, 4 ) and Eliminado = 0 )
            ) as Porcentaje

                    
        
        ";

        //echo $sql;
    } else {
        $sql=" 
        select 
        a.*,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=0
        ),FALSE) Captura,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=1
        ),FALSE) VoBo,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=3
        ),FALSE) Aprobar
        
         
        from tramitesitavu a 
        
        WHERE Estado in(0,4)  "; //<-- Filtramos los tramites por Captura y Devueltos
        $sql_count=" 
        SELECT 
            (select count(*) from tramitesestadodecaptura WHERE EstadoCaptura='LISTO PARA ENVIAR' 	AND Estado IN ( 0, 4 ) and Eliminado = 0 )  as Listos,
            (select count(*) from tramitesestadodecaptura WHERE   EstadoCaptura='PENDIENTE' 	AND Estado IN ( 0, 4 ) and Eliminado = 0 ) as Pendientes,
            (
                ( (select count(*) from tramitesestadodecaptura WHERE EstadoCaptura='PENDIENTE' AND Estado IN ( 0, 4 ) and Eliminado = 0) * 100 ) / (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(55) 	AND Estado IN ( 0, 4 ) and Eliminado = 0 )
            ) as Porcentaje";
            
            
    }
    //echo $sql_count;
    //echo "<hr>".$sql;
    //Cantidad en barra
    $Pendientes= 0;  $rc2= $conexion -> query($sql_count); if($f2 = $rc2 -> fetch_array()) {
        $Pendientes = "Atualmente tienes ".$f2['Pendientes']." por Revisar en esta categoria"; $PorcentajePendientes = $f2['Porcentaje']; 
    } 
    $msg="";

    echo  "<h3 class='accordion ' title='Esta barra muestra el progreso de captura de tu departamento' style='
            color: white;
            background-color: #ccc;
            padding: 5px;
            margin: 0px;
            background-size: ".$PorcentajePendientes."%,100%;
            background-image: url(img/wall10.jpg);
            background-repeat: no-repeat;
            margin-top: 8px;

            '><table width=100% ><tr><td width=30px ><img src='icon/page.png' style='width:20px;'></td><td >
            PENDIENTES POR ENVIAR</td><td width=50px;  style='font-size:7pt; color:white;'><b style='padding:5px; border-radius:50%; background-color:white; color:gray; font-size:12pt; font-weight:bold; padding-left: 8px; padding-right: 8px;'>".$f2['Pendientes']."</b></td></tr></table></h3>
            <div class='panel' style=''>";
            //echo $sql;
            echo "<table class='tabla'><th>% Captura</th><th>Tramite</th><th>Ciudadano</th>";
            $r= $conexion -> query($sql); while($f = $r -> fetch_array()) {
                // VALIDAMOS QUE TENGA PERMISO PARA CAPTURAR Y ENVIAR 
                if ($f['Captura']==1){ //0== no tiene y 1== si tiene                
                        $IdTramite = $f['IdTramite'];
                        $Porcentaje = ProcentajeTramite($f['IdTramite'],$f['IdTipoTramite']);
                        echo "<tr id='Registro".$IdTramite."'>";
                        echo "<td width=150px>";
                        // echo $Porcentaje;
                        // echo "<div id='Timer".$IdTramite."' style='width:80px; height:80px;'></div>";

                        
                        GraficaPorcentaje('g'.$IdTramite,$Porcentaje);

                        echo "</td>";
                        echo "<td>";
                        echo "<b style='font-size:12pt; color:#2DA3DC; font-weight:bold;'>".$f['NombreBeneficiario']."</b>";
                        echo "<br><label style='margin:0px; padding:0px;'>[CURP:".$f['Curp']."] </label>";
                        echo "<br><b style='font-size:12pt;'>".$f['NombreTramite']."</b>";
                        echo "<br><span>Programa: ".$f['IdPrograma']."-".NombrePrograma($f['IdPrograma'])."     Delegación: ".$f['IdDelegacion']."-".nombreDelegacionVivienda($f['IdDelegacion'])." </span>";
                        echo "<br><label style='margin:0px; padding:0px;'><a title='Haga clic aquí para Editar el Tramite' href='tr_iniciar.php?edit=".$f['IdTramite']."'>[".$f['IdTramite']."] - ".$f['Programa']."</a></label>";
                        echo "<br><a style=' padding-left: 0px; ' href='#Observaciones".$f['IdTramite']."' rel='MyModal:open' title='Clic para mostrar las observaciones que se han hecho a este trámite'>Observaciones</a>"; 
                        echo "<div id='Observaciones".$f['IdTramite']."' class='MyModal'>";
                        echo "<h1>Observaciones</h1>";
                        echo "<a type='button' id='btn' value='Print' onclick='printDiv(".$f['IdTramite'].");' ><img src='icon/pdf.png' style='width:25px;'></a>";
                        //				echo "<div style='text-align: right;'><a type='button' id='btn' value='Print' onclick='printDiv(".$r['IdTramite'].");' ><img src='icon/pdf.png' style='width:25px;'></a></div>";

                        $sql1 = "SELECT * FROM tramitesobservaciones WHERE IdTramite = ".$f['IdTramite']." order by Id desc ";
                        $rc1= $conexion -> query($sql1); 
                        if ($rc1->num_rows>0)
                        {
                            echo "<div style='overflow:scroll;	height:400px;'>";
                            echo "<table class='tabla' style='padding: 5px; border-radius: 4px;'>";
                            while($r1 = $rc1 -> fetch_array())    
                            {
                                echo "<tr>";
                            echo "<td width=30px>";
                            echo "<span title='".nitavu_nombre($r1['NitavuCaptura'])." de ".nitavu_dpto_nombre($r1['NitavuCaptura'])."'>";
                            echo ponerfoto("fotos/".$r1['NitavuCaptura'].".jpg",'FotoComentario');
                            echo "</span>";
                            echo "</td>";
                            echo "<td>";
                            if($r1['Estado']==1){
                            echo "<span style='font-size:9pt;' ><b  class='normal menu_font_n'>VoBo</b></span>";
                            }else if ($r1['Estado']==3) {echo "<span style='font-size:9pt;' ><b class='normal menu_font_n'>Rechazdo</b></span>";}
                            else if ($r1['Estado']==4) {echo "<span style='font-size:9pt;' ><b class='normal menu_font_n'>Devuelto</b></span>";}
                            echo "<br><span style='font-size:8pt;' >".$r1['Observacion']."</span>";
                            echo "<br><span style='font-size:7pt;' >".fecha_larga($r1['Fecha'])."|".hora12($r1['Hora'])."</span>";
                            
                            // echo "<span style='font-size:8pt;' title='".fecha_larga($Cm['Fecha'])."|".hora12($Cm['Hora'])."'>".$Cm['Comentario']."</span>";
                            echo "</td>";
                            echo "</tr>";


                            }
                            echo "</table>";
                            echo "</div>";
                        }

                    echo "</div>";

                            //---------------DIV PARA IMPRIMIR OBSERVACIONES
                            echo "<div id='imprimir".$f['IdTramite']."' style='display:none;'>";
                                echo "<center><span style='font-size:12pt;'><b>Observaciones del trámite (".$f['IdTramite'].") ".$f['NombreTramite']." ".$f['Programa']." </b></span>";
                                echo "<span style='font-size:11pt;'><br>Beneficiario:  ".$f['NombreBeneficiario']."</span></center>";
                                $sql1 = "SELECT * FROM tramitesobservaciones WHERE IdTramite = ".$f['IdTramite']." order by Id desc ";
                                $rc1= $conexion -> query($sql1); 
                                if ($rc1->num_rows>0)
                                {
                                    echo "<div><br><br>";
                                    echo "<table class='tabla' style='padding: 5px; border-radius: 4px;'>";
                                    while($r1 = $rc1 -> fetch_array())    
                                    {
                                    echo "<tr>";
                                        echo "<td style='border-top-width:1px; border-bottom-width:2px;'>";
                                                                        
                                            if($r1['Estado']==1){echo "<span style='font-size:12pt;' ><b  class='normal menu_font_n'>VoBo</b></span>";
                                            }else if ($r1['Estado']==3) {echo "<span style='font-size:12pt;' ><b class='normal menu_font_n'>Rechazdo</b></span>";}
                                            else if ($r1['Estado']==4) {echo "<span style='font-size:12pt;' ><b class='normal menu_font_n'>Devuelto</b></span>";}
                                            echo "<span style='font-size:10pt;'><br>Por: ".nitavu_nombre($r1['NitavuCaptura'])." de ".nitavu_dpto_nombre($r1['NitavuCaptura'])."</span>";
                                            echo "<br><span style='font-size:10pt;' >Observación: ".$r1['Observacion']."</span>";
                                            echo "<br><span style='font-size:8pt;' >".fecha_larga($r1['Fecha'])."|".hora12($r1['Hora'])."</span>";
                                        echo "</td>";
                                    echo "</tr>";


                                    }
                                    echo "</table>";
                                    echo "</div>";
                                }
                                
                            echo "</div>";

                        echo "<br><label style='font-size:7pt; margin:0px; padding:0px;'>Capturado por ".nitavu_nombre($f['NitavuCaptura'])." - ".$f['Fecha']." : ".$f['Hora']." en ".DptoNombre($f['DptoCaptura'])." </label>";
                        echo "</td>";

                        if ($f['Estado']==4){
                            echo "<td style='background-color:#FF9122; margin:5px;' valign=middle align=center>";
                        } else {
                            echo "<td style='background-color:#5CB4D1; margin:5px;' valign=middle align=center>";
                        }
                        
                        // echo "<a href='' style='display:block' title='ENVIAR TRAMITE al Departamento Correspondiente' class=''><img src='icon/avion.png' style='width:35px;'></a>";

                        //..-.-.-.-.-.-.-.-.-.-..-.-..-.-.-.-..-.-.-.-.-.-.-.-.-.
                        echo " <a  href='#enviarTramite".$f['IdTramite']."' rel='MyModal:open' class='' title='Clic para Enviar'> <img src='icon/avion.png' style='width:35px; '>"; 
                        echo "</a>";
                        // ************Modal Enviar Tramite*********** Cada modal se escribe con id diferente, asi como cada form, concatene el IdTramite
                        echo "<div id='enviarTramite".$f['IdTramite']."' class='MyModal'><h3>Enviar Tramite </h3>";
                            $NombreDelRequisito='AcuseSolicitud';					
                            $Descripcion='Subir Acuse del Tramite (Firmado por el Beneficiario)';
                            $IdRequisito='AcuseSolicitud';
                            $FolioTramite=$f['IdTramite'];
                            
                            $vinculo='';
                            $TipoTramite=$f['IdTipoTramite'];			
                            echo "<center>";
                            echo "<div id='contenedor' style='width:100%'>";	
                                echo "<div id='mostrararchivo' style='width:50%; display:inline-block;'>";
                                // if ($f['Formato'])
                                // echo "(".$f['Formato'].")";
                                    if($f['Formato']<>''){
                                                echo "<b style='
                                            font-size: 9pt;color: gray;
                                        '>Formato necesario para subir e iniciar el tramite </b>";
                                        echo "<iframe id='frame".$FolioTramite."' name='frame' src='".$f['Formato']."?folio=".$FolioTramite."&nitavu=".$nitavu."'
                                    style='width:100%; height:50%; border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
                                    }else{
                                        echo "<b style='
                                        font-size: 9pt;color: gray;
                                    '>* Tramite sin hoja de formato registrado para iniciarlo; Por favor verifique con el área responsable para confirmar.  </b>";
                                        echo "<iframe id='frame".$FolioTramite."' name='frame' src=''
                                    style='width:100%; height:50%; border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
                                    }
                                    
                                echo "</div>";//cierra mostrar archivo					

                                    echo "<div id='subirarchivo' style='width:45%; display:inline-block; vertical-align: top; margin:5px; padding:10px;'>";	
                                            echo "<table width=100%><tr><td><div  id='subir'>";		
                                            echo "<label>".$Descripcion."</label>";					
                                            echo "<form method='POST' action='' enctype='multipart/form-data' id='Form".$FolioTramite."' name='Form".$FolioTramite."' >";
                                            echo '<input type="file"  name="'.$IdRequisito.$FolioTramite.'" id="'.$IdRequisito.$FolioTramite.'"  onchange=SubirArchivo('.$FolioTramite.','.$TipoTramite.',"'.$IdRequisito.'","botonenviar") >';
                                            echo "</form>";
                                            echo "</div></td><td>";			
                                        $vinculo = "<a href='tramitesFiles/".$IdRequisito.$FolioTramite.".pdf' download='".$IdRequisito.$FolioTramite.".pdf' target=_blank><img src='icon/pdf.png' style='width:36px;'></a>";
                                        echo "<div id='Loader".$IdRequisito.$FolioTramite."' style='display:none;'><img src='img/loader_bar.gif' style='width:18px;'></div>";
                                        echo "<div id='PDF".$IdRequisito.$FolioTramite."' style='display:none;'>".$vinculo."</div></td></tr>";
                                        echo "<tr><td><center><div  id='botonenviar".$FolioTramite."' style='display:none;' >";
                                        echo"<a class='btn btn-primary' onclick='ValidarTramite(".$f['IdTramite'].",".$f['IdTipoTramite'].")' title='Enviar al Dpto Correspondiente'><img src='icon/btn_derecha.png' style='width:20px; height:20px;'> Enviar </a></div></center></td></tr>";
                                        echo "</table>";					
                                        echo sugerencia("Verifique los datos capturados antes de enviar e Integre el expediente físico en su Delegación.");
                                        echo "</div>"; //cierra  subir archivo

                                
                            echo "</div>"; //cierra contenedor
                            echo "<div id='MiniLoader".$FolioTramite."'><img src='img/loader_bar.gif' style='width:12px;'> Cargando...</div>";
                            echo "
                            <script>
                            $(document).ready(function () {
                                $('#frame".$FolioTramite."').on('load', function () {
                                    $('#MiniLoader".$FolioTramite."').hide();
                                });
                            });
                            </script>
                            ";
                            echo "<center>";
                        echo "</div>";










                        //.--.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
                        echo "</td>";
                        //PARA ELIMINAR DE LOS PENDIENTES
                        if($f['NitavuCaptura']==$nitavu){
                            echo "<td style='background-color:#E7243F; margin:5px;' valign=middle align=center>";
                            echo "<a href='#modalEliminar".$f['IdTramite']."' rel='MyModal:open' title='Clic para eliminar esta solicitud de pendientes'><img src='icon/cancel.png' style='widht:30px; height:30px;'></a>";
                            echo "<div id='modalEliminar".$f['IdTramite']."' class='MyModal'><h3>Razón por la cual desea eliminar: </h3>";
                            echo '<form action="tramites.php" method="POST">';
                            echo "<textarea name='motivo'></textarea>";
                            echo "<input type='hidden' name='IdTramite' id='IdTramite' value=".$f['IdTramite'].">";
                            echo "<button id='eliminar' name='eliminar' class='Mbtn btn-default'>Confirmar</button>";
                            echo "</form>";
                            echo "</div>";
                            echo "</td>";
                        }
                        echo "</tr>";
                } else {
                    $msg= $msg."<li>Tramite:[".$f['IdTipoTramite']."][".$f['IdTramite']."] - ".$f['NombreTramite']." de ".$f['NombreBeneficiario']." de ".$f['Departamento']."</li> ";
                }
            }
            echo "</table>";
            if ($msg <> ''){
                echo "<label> * Estos tramites estan pendientes de Captura o Envio, sin embargo no tienes permiso para dichos movimientos sobre el Tipo de Tramite: <lu>".$msg."</lu></label>";
            }
    echo "</div>";
    // =============== [fin] BARRA CAPTURAS PENDIENTES DE ENVIAR ===============================




    
    // ===============  BARRA CAPTURAS PENDIENTES DE VOBO ===============================---------------------------------------------
    if ($nivel == 3 or $nivel==2){
        $sql=" 
        select 
        a.*,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=0
        ),FALSE) Captura,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=1
        ),FALSE) VoBo,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=3
        ),FALSE) Aprobar,
        (SELECT DATEDIFF(CURDATE(), Fecha)) as Dias,
        (select count(*) from tramitesvobos WHERE IdTramite = a.IdTramite and nitavu = '2809') as VoBos
        
         
        from tramitesITAVU a WHERE
        IdDptoEjecucion in(".$DepartamentoAlcance.") AND Estado in(0,1,4) "; //<-- Filtramos los tramites por Captura y Enviados y Devueltos
        
        //consulta para la barra de progreso
        $sql_count=" 
               
            SELECT 
            (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(".$DepartamentoAlcance.") AND EstadoCaptura='LISTO PARA ENVIAR') as Listos,
            (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(".$DepartamentoAlcance.") AND EstadoCaptura='PENDIENTE') as Pendientes,
            (
                ( (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(".$DepartamentoAlcance.") AND EstadoCaptura='PENDIENTE') * 100 ) / (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(55) )
            ) as Porcentaje

                    
        
        ";
    } else {
        $sql=" 
        select 
        a.*,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=0
        ),FALSE) Captura,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=1
        ),FALSE) VoBo,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=3
        ),FALSE) Aprobar,
        (SELECT DATEDIFF(CURDATE(), Fecha)) as Dias,
        (select count(*) from tramitesvobos WHERE IdTramite = a.IdTramite and nitavu = '2809') as VoBos
        
         
        from tramitesitavu a 
        
        WHERE Estado in(0,1,4)  "; //<-- Filtramos los tramites por Captura y Devueltos y Enviados
        
        //consulta par ala barra
        $sql_count=" 
        SELECT 
            (select count(*) from tramitesestadodecaptura WHERE EstadoCaptura='LISTO PARA ENVIAR') as Listos,
            (select count(*) from tramitesestadodecaptura WHERE   EstadoCaptura='PENDIENTE') as Pendientes,
            (
                ( (select count(*) from tramitesestadodecaptura WHERE EstadoCaptura='PENDIENTE') * 100 ) / (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(55) )
            ) as Porcentaje";
            
            
    }
     //echo $sql;
     //echo "<hr>".$sql_count;
    //Cantidad en barra
    $Pendientes= 0;  $rc2= $conexion -> query($sql_count); if($f2 = $rc2 -> fetch_array()) {$Pendientes = "Atualmente tienes ".$f2['Pendientes']." por Revisar en esta categoria"; $PorcentajePendientes = $f2['Porcentaje']; } 
    $msg="";
    $PorcentajePendientes = 100;


    if (isset($_GET['vobo'])){
        $IdTramite = $_GET['vobo']; if (ValidaVAR($IdTramite)==TRUE){$IdTramite = LimpiarVAR($IdTramite);} else {$IdTramite = "";}
        if (TramiteVobo($IdTramite, $nitavu) == TRUE){
            mensaje("Se ha marcado correctamente el Tramite con Id ".$IdTramite." con tu Vobo","tramites.php");
        } else {
            mensaje("ERROR: ha habido un error al intentar marcar el Tramite con Id ".$IdTramite." con tu Vobo","tramites.php");
        }
    }

    echo  "<h3 class='accordion ' title='Esta barra muestra el progreso de captura de tu departamento' style='
            color: white;
            background-color: #ccc;
            padding: 5px;
            margin: 0px;
            background-size: ".$PorcentajePendientes."%,100%;
            background-image: url(img/wall10.jpg);
            background-repeat: no-repeat;
            margin-top: 8px;

            '><table width=100% ><tr><td width=30px ><img src='icon/page.png' style='width:20px;'></td><td >
            PENDIENTES POR VOBO</td><td  width=50px;  style='font-size:7pt; color:white;'><b id='VoBo_Pendientes' style='padding:5px; border-radius:50%; background-color:white; color:gray; font-size:12pt; font-weight:bold; padding-left: 8px; padding-right: 8px;'>0</b></td></tr></table></h3>
            <div class='panel' style=''>";
            // echo $sql;
            echo "<table class='tabla'><th>Dias</th><th>Tramite</th><th>Ciudadano</th>";
            $vobos=0;
           
            $r= $conexion -> query($sql); while($f = $r -> fetch_array()) {
                // VALIDAMOS QUE TENGA PERMISO PARA CAPTURAR Y ENVIAR 
                if ($f['VoBo']==1 AND $f['VoBos']==0){ //Si Tengo permiso para darle vobo y aun no le he dado

                        $vobos = $vobos + 1;      
                        $IdTramite = $f['IdTramite'];
                        $Porcentaje = ProcentajeTramite($f['IdTramite'],$f['IdTipoTramite']);
                        echo "<tr>";
                        echo "<td width=150px valing=middle align=center>";
                        // echo $Porcentaje;
                        // echo "<div id='Timer".$IdTramite."' style='width:80px; height:80px;'></div>";

                        
                        echo "<b title ='".$f['Dias']." dias.' style='
                        color: #30b7f0;                        
                        font-size: 45pt;                        
                        font-weight: bold;
                        display: inline-block;
                        '>".$f['Dias']."</b><br><span style='
                        color:#57b3da;
                        font-size:12pt;
                        '> <b style='color:#B1CC3B; font-weight:bold;'>".DptoNombre($f['DptoCaptura'])."</b></span>";

                        echo "</td>";
                        echo "<td>";
                        echo "<b style='font-size:12pt; color:#2DA3DC; font-weight:bold;'>".$f['NombreBeneficiario']."</b>";
                        echo "<br><label style='margin:0px; padding:0px;'>[CURP:".$f['Curp']."] </label>";
                        

                        echo "<br><b style='font-size:12pt;'>".$f['NombreTramite']."</b>";
                        echo "<br><label style='margin:0px; padding:0px;'><a title='Haga clic aquí para ver el Tramite' href='tr_iniciar.php?edit=".$f['IdTramite']."'>[".$f['IdTramite']."] - ".$f['Programa']."</a></label>";
                        echo "<br><a style=' padding-left: 0px; ' href='#Observaciones".$f['IdTramite']."' rel='MyModal:open' title='Clic para mostrar las observaciones que se han hecho a este trámite'>Observaciones</a>"; 
                        echo "<div id='Observaciones".$f['IdTramite']."' class='MyModal'>";
                        echo "<h1>Observaciones</h1>";
                        echo "<a type='button' id='btn' value='Print' onclick='printDiv(".$f['IdTramite'].");' ><img src='icon/pdf.png' style='width:25px;'></a>";
                        //				echo "<div style='text-align: right;'><a type='button' id='btn' value='Print' onclick='printDiv(".$r['IdTramite'].");' ><img src='icon/pdf.png' style='width:25px;'></a></div>";

                        $sql1 = "SELECT * FROM tramitesobservaciones WHERE IdTramite = ".$f['IdTramite']." order by Id desc ";
                        $rc1= $conexion -> query($sql1); 
                        if ($rc1->num_rows>0)
                        {
                            echo "<div style='overflow:scroll;	height:400px;'>";
                            echo "<table class='tabla' style='padding: 5px; border-radius: 4px;'>";
                            while($r1 = $rc1 -> fetch_array())    
                            {
                                echo "<tr>";
                            echo "<td width=30px>";
                            echo "<span title='".nitavu_nombre($r1['NitavuCaptura'])." de ".nitavu_dpto_nombre($r1['NitavuCaptura'])."'>";
                            echo ponerfoto("fotos/".$r1['NitavuCaptura'].".jpg",'FotoComentario');
                            echo "</span>";
                            echo "</td>";
                            echo "<td>";
                            if($r1['Estado']==1){
                            echo "<span style='font-size:9pt;' ><b  class='normal menu_font_n'>VoBo</b></span>";
                            }else if ($r1['Estado']==3) {echo "<span style='font-size:9pt;' ><b class='normal menu_font_n'>Rechazdo</b></span>";}
                            else if ($r1['Estado']==4) {echo "<span style='font-size:9pt;' ><b class='normal menu_font_n'>Devuelto</b></span>";}
                            echo "<br><span style='font-size:8pt;' >".$r1['Observacion']."</span>";
                            echo "<br><span style='font-size:7pt;' >".fecha_larga($r1['Fecha'])."|".hora12($r1['Hora'])."</span>";
                            
                            // echo "<span style='font-size:8pt;' title='".fecha_larga($Cm['Fecha'])."|".hora12($Cm['Hora'])."'>".$Cm['Comentario']."</span>";
                            echo "</td>";
                            echo "</tr>";


                            }
                            echo "</table>";
                            echo "</div>";
                        }

                    echo "</div>";

                            //---------------DIV PARA IMPRIMIR OBSERVACIONES
                            echo "<div id='imprimir".$f['IdTramite']."' style='display:none;'>";
                                echo "<center><span style='font-size:12pt;'><b>Observaciones del trámite (".$f['IdTramite'].") ".$f['NombreTramite']." ".$f['Programa']." </b></span>";
                                echo "<span style='font-size:11pt;'><br>Beneficiario:  ".$f['NombreBeneficiario']."</span></center>";
                                $sql1 = "SELECT * FROM tramitesobservaciones WHERE IdTramite = ".$f['IdTramite']." order by Id desc ";
                                $rc1= $conexion -> query($sql1); 
                                if ($rc1->num_rows>0)
                                {
                                    echo "<div><br><br>";
                                    echo "<table class='tabla' style='padding: 5px; border-radius: 4px;'>";
                                    while($r1 = $rc1 -> fetch_array())    
                                    {
                                    echo "<tr>";
                                        echo "<td style='border-top-width:1px; border-bottom-width:2px;'>";
                                                                        
                                            if($r1['Estado']==1){echo "<span style='font-size:12pt;' ><b  class='normal menu_font_n'>VoBo</b></span>";
                                            }else if ($r1['Estado']==3) {echo "<span style='font-size:12pt;' ><b class='normal menu_font_n'>Rechazdo</b></span>";}
                                            else if ($r1['Estado']==4) {echo "<span style='font-size:12pt;' ><b class='normal menu_font_n'>Devuelto</b></span>";}
                                            echo "<span style='font-size:10pt;'><br>Por: ".nitavu_nombre($r1['NitavuCaptura'])." de ".nitavu_dpto_nombre($r1['NitavuCaptura'])."</span>";
                                            echo "<br><span style='font-size:10pt;' >Observación: ".$r1['Observacion']."</span>";
                                            echo "<br><span style='font-size:8pt;' >".fecha_larga($r1['Fecha'])."|".hora12($r1['Hora'])."</span>";
                                        echo "</td>";
                                    echo "</tr>";


                                    }
                                    echo "</table>";
                                    echo "</div>";
                                }
                                
                            echo "</div>";

                                         
                        
                        echo "<br><label style='font-size:7pt; margin:0px; padding:0px;'>Capturado por ".nitavu_nombre($f['NitavuCaptura'])." - ".$f['Fecha']." : ".$f['Hora']." en ".DptoNombre($f['DptoCaptura'])." </label>";

                        echo TramiteVobos($f['IdTramite']);

                        // echo "</td>";

                    
                        
                            echo "</td>";

                        if ($f['Estado']==4){
                            echo "<td style='background-color:#FF9122; margin:5px;' valign=middle align=center>";
                        } else {
                            echo "<td style='background-color:#5CB4D1; margin:5px;' valign=middle align=center>";
                        }
                        
                        echo "<a href='?vobo=".$f['IdTramite']."' style='display:block' title='Marcar con VoBo este Tramite' class=''><img src='icon/vobo2.png' style='width:55px;'></a>";

                        echo "</td>";
                        echo "</tr>";
                } else {
                    // $msg= $msg."<li>Tramite:[".$f['IdTipoTramite']."][".$f['IdTramite']."] - ".$f['NombreTramite']." de ".$f['NombreBeneficiario']."</li> ";
                }
            }
            echo "<script> $('#VoBo_Pendientes').html('".$vobos."'); </script>";
            echo "</table>";
            if ($msg <> ''){
                echo "<label> * Estos tramites estan pendientes de Captura o Envio, sin embargo no tienes permiso para dichos movimientos sobre el Tipo de Tramite: <lu>".$msg."</lu></label>";
            }
    echo "</div>";
    // =============== [fin] BARRA CAPTURAS PENDIENTES DE VOBO ===============================



    


    // ===============  BARRA CAPTURAS PENDIENTES DE aprobar ===============================---------------------------------------------
    if ($nivel == 3 or $nivel==2){
        $sql=" 
        select 
        a.*,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=0
        ),FALSE) Captura,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=1
        ),FALSE) VoBo,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=2
        ),FALSE) Aprobar,
        (SELECT DATEDIFF(CURDATE(), Fecha)) as Dias
        
         
        from tramitesitavu a WHERE
        IdDptoEjecucion in(".$DepartamentoAlcance.") AND Estado in(1) "; //<-- Filtramos los tramites por Captura y Enviados y Devueltos
        
        //consulta para la barra de progreso
        $sql_count=" 
               
            SELECT 
            (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(".$DepartamentoAlcance.") AND EstadoCaptura='LISTO PARA ENVIAR') as Listos,
            (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(".$DepartamentoAlcance.") AND EstadoCaptura='PENDIENTE') as Pendientes,
            (
                ( (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(".$DepartamentoAlcance.") AND EstadoCaptura='PENDIENTE') * 100 ) / (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(55) )
            ) as Porcentaje

                    
        
        ";
    } else {
        $sql=" 
        select 
        a.*,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=0
        ),FALSE) Captura,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=1
        ),FALSE) VoBo,
        IFNULL((
           SELECT TRUE from tramitespermisos WHERE IdTipoTramite = a.IdTipoTramite AND nitavu='".$nitavu."' and Permiso=2
        ),FALSE) Aprobar,
        (SELECT DATEDIFF(CURDATE(), Fecha)) as Dias
        
         
        from tramitesitavu a 
        
        WHERE Estado in(1)  "; //<-- Filtramos los tramites por Captura y Devueltos y Enviados
        
        //consulta par ala barra
        $sql_count=" 
        SELECT 
            (select count(*) from tramitesestadodecaptura WHERE EstadoCaptura='LISTO PARA ENVIAR') as Listos,
            (select count(*) from tramitesestadodecaptura WHERE   EstadoCaptura='PENDIENTE') as Pendientes,
            (
                ( (select count(*) from tramitesestadodecaptura WHERE EstadoCaptura='PENDIENTE') * 100 ) / (select count(*) from tramitesestadodecaptura WHERE DptoCaptura in(55) )
            ) as Porcentaje";
            
            
    }
   // echo $sql;
    //Cantidad en barra
    $Pendientes= 0;  $rc2= $conexion -> query($sql_count); if($f2 = $rc2 -> fetch_array()) {$Pendientes = "Atualmente tienes ".$f2['Pendientes']." por Revisar en esta categoria"; $PorcentajePendientes = $f2['Porcentaje']; } 
    $msg="";
    
    $PorcentajePendientes = 0;
    echo  "<h3 class='accordion ' title='Esta barra muestra el progreso de captura de tu departamento' style='
            color: white;
            background-color: #ccc;
            padding: 5px;
            margin: 0px;
            background-size: ".$PorcentajePendientes."%,100%;
            background-image: url(img/wall10.jpg);
            background-repeat: no-repeat;
            margin-top: 8px;

            '><table width=100% ><tr><td width=30px ><img src='icon/page.png' style='width:20px;'></td><td >
            PENDIENTES POR APROBAR</td><td width=50px; style='font-size:7pt; color:white;'><b id='APROBAR_Pendientes' style='padding:5px; border-radius:50%; background-color:white; color:gray; font-size:12pt; font-weight:bold; padding-left: 8px; padding-right: 8px;'>0</b></td></tr></table></h3>
            <div class='panel' style=''>";
            //echo $sql;
            echo "<table class='tabla'><th>Dias</th><th>Tramite</th><th>Ciudadano</th>";
            $aprobas=0;
            //echo $sql;
            $r= $conexion -> query($sql); while($f = $r -> fetch_array()) {
                // VALIDAMOS QUE TENGA PERMISO PARA CAPTURAR Y ENVIAR 
                if ($f['Aprobar']==1){ //0== no tiene y 1== si tiene                
                        $aprobas  = $aprobas +1;
                        $IdTramite = $f['IdTramite'];
                        $Porcentaje = ProcentajeTramite($f['IdTramite'],$f['IdTipoTramite']);
                        
                        echo "<tr id='RegistroAprobar".$f['IdTramite']."'>";

                        echo "<td width=150px valing=middle align=center>";
                        // echo $Porcentaje;
                        // echo "<div id='Timer".$IdTramite."' style='width:80px; height:80px;'></div>";

                        
                        echo "<b title ='".$f['Dias']." dias.' style='
                        color: #30b7f0;                        
                        font-size: 45pt;                        
                        font-weight: bold;
                        display: inline-block;
                        '>".$f['Dias']."</b><br><span style='
                        color:#57b3da;
                        font-size:12pt;
                        '> <b style='color:#B1CC3B; font-weight:bold;'>".DptoNombre($f['DptoCaptura'])."</b></span>";

                        echo "</td>";
                        echo "<td>";
                        echo "<b style='font-size:12pt; color:#2DA3DC; font-weight:bold;'>".$f['NombreBeneficiario']."</b>";
                        echo "<br><label style='margin:0px; padding:0px;'>[CURP:".$f['Curp']."] </label>";
                        echo "<br><b style='font-size:12pt;'>".$f['NombreTramite']."</b>";
                        echo "<br><label style='margin:0px; padding:0px;'><a href='tr_iniciar.php?edit=".$f['IdTramite']."'>[".$f['IdTramite']."] - ".$f['Programa']."</a></label>";
                       
                        echo "<br><a style=' padding-left: 0px; ' href='#Observaciones".$f['IdTramite']."' rel='MyModal:open' title='Clic para mostrar las observaciones que se han hecho a este trámite'>Observaciones</a>"; 
                        echo "<div id='Observaciones".$f['IdTramite']."' class='MyModal'>";
                        echo "<h1>Observaciones</h1>";
                        echo "<a type='button' id='btn' value='Print' onclick='printDiv(".$f['IdTramite'].");' ><img src='icon/pdf.png' style='width:25px;'></a>";
                        //				echo "<div style='text-align: right;'><a type='button' id='btn' value='Print' onclick='printDiv(".$r['IdTramite'].");' ><img src='icon/pdf.png' style='width:25px;'></a></div>";

                        $sql1 = "SELECT * FROM tramitesobservaciones WHERE IdTramite = ".$f['IdTramite']." order by Id desc ";
                        $rc1= $conexion -> query($sql1); 
                        if ($rc1->num_rows>0)
                        {
                            echo "<div style='overflow:scroll;	height:400px;'>";
                            echo "<table class='tabla' style='padding: 5px; border-radius: 4px;'>";
                            while($r1 = $rc1 -> fetch_array())    
                            {
                                echo "<tr>";
                            echo "<td width=30px>";
                            echo "<span title='".nitavu_nombre($r1['NitavuCaptura'])." de ".nitavu_dpto_nombre($r1['NitavuCaptura'])."'>";
                            echo ponerfoto("fotos/".$r1['NitavuCaptura'].".jpg",'FotoComentario');
                            echo "</span>";
                            echo "</td>";
                            echo "<td>";
                            if($r1['Estado']==1){
                            echo "<span style='font-size:9pt;' ><b  class='normal menu_font_n'>VoBo</b></span>";
                            }else if ($r1['Estado']==3) {echo "<span style='font-size:9pt;' ><b class='normal menu_font_n'>Rechazdo</b></span>";}
                            else if ($r1['Estado']==4) {echo "<span style='font-size:9pt;' ><b class='normal menu_font_n'>Devuelto</b></span>";}
                            echo "<br><span style='font-size:8pt;' >".$r1['Observacion']."</span>";
                            echo "<br><span style='font-size:7pt;' >".fecha_larga($r1['Fecha'])."|".hora12($r1['Hora'])."</span>";
                            
                            // echo "<span style='font-size:8pt;' title='".fecha_larga($Cm['Fecha'])."|".hora12($Cm['Hora'])."'>".$Cm['Comentario']."</span>";
                            echo "</td>";
                            echo "</tr>";


                            }
                            echo "</table>";
                            echo "</div>";
                        }

                    echo "</div>";

                            //---------------DIV PARA IMPRIMIR OBSERVACIONES
                            echo "<div id='imprimir".$f['IdTramite']."' style='display:none;'>";
                                echo "<center><span style='font-size:12pt;'><b>Observaciones del trámite (".$f['IdTramite'].") ".$f['NombreTramite']." ".$f['Programa']." </b></span>";
                                echo "<span style='font-size:11pt;'><br>Beneficiario:  ".$f['NombreBeneficiario']."</span></center>";
                                $sql1 = "SELECT * FROM tramitesobservaciones WHERE IdTramite = ".$f['IdTramite']." order by Id desc ";
                                $rc1= $conexion -> query($sql1); 
                                if ($rc1->num_rows>0)
                                {
                                    echo "<div><br><br>";
                                    echo "<table class='tabla' style='padding: 5px; border-radius: 4px;'>";
                                    while($r1 = $rc1 -> fetch_array())    
                                    {
                                    echo "<tr>";
                                        echo "<td style='border-top-width:1px; border-bottom-width:2px;'>";
                                                                        
                                            if($r1['Estado']==1){echo "<span style='font-size:12pt;' ><b  class='normal menu_font_n'>VoBo</b></span>";
                                            }else if ($r1['Estado']==3) {echo "<span style='font-size:12pt;' ><b class='normal menu_font_n'>Rechazdo</b></span>";}
                                            else if ($r1['Estado']==4) {echo "<span style='font-size:12pt;' ><b class='normal menu_font_n'>Devuelto</b></span>";}
                                            echo "<span style='font-size:10pt;'><br>Por: ".nitavu_nombre($r1['NitavuCaptura'])." de ".nitavu_dpto_nombre($r1['NitavuCaptura'])."</span>";
                                            echo "<br><span style='font-size:10pt;' >Observación: ".$r1['Observacion']."</span>";
                                            echo "<br><span style='font-size:8pt;' >".fecha_larga($r1['Fecha'])."|".hora12($r1['Hora'])."</span>";
                                        echo "</td>";
                                    echo "</tr>";


                                    }
                                    echo "</table>";
                                    echo "</div>";
                                }
                                
                            echo "</div>";

                        //SI ES LA PRESOLICITUD PEDIMOS AHORRO PREVIO Y TIEMPO 
                        if(TramitePreSolicitud($f['IdTramite'])==1 and $f['Estado']==1){
                            echo "<br><a style=' padding-left: 0px; ' href='#AhorroPrevio".$f['IdTramite']."' rel='MyModal:open' title='Clic para capturar ahorro previo a trámite'>Ahorro previo</a>"; 
                            echo "<div id='AhorroPrevio".$f['IdTramite']."' class='MyModal'>";
                                echo "<h1>Ahorro previo</h1>";
                                echo '<form action="tramites.php" method="POST">';
                                echo '<input type="hidden" id="IdTramite" name="IdTramite" value="'.$f['IdTramite'].'">';
                                    echo '<div style="width:100%;">';
                                $q = "SELECT * FROM tramites WHERE IdTramite = ".$f['IdTramite']."";
                                $res= $conexion -> query($q); 	
                                while($f1 = $res -> fetch_array()){
                                    echo '<div><label>Ahorro previo</label>';
                                    echo '<input id="ahorro" name="ahorro" value="'.$f1['AhorroPrevio'].'"></div>';
                                    echo '<div><label>Tiempo en meses</label>';
                                    echo '<input id="tiempo" name="tiempo" value="'.$f1['Tiempo'].'"></div>';
                                    echo '</div>';
                                
                                }
                                    echo "<input type='submit' value='Guardar' class='Mbtn btn-default' style='width:100px;'>";
                                echo '</form>';
                            echo "</div>";
                        }
                        echo "<br><label style='font-size:7pt; margin:0px; padding:0px;'>Capturado por ".nitavu_nombre($f['NitavuCaptura'])." - ".$f['Fecha']." : ".$f['Hora']." en ".DptoNombre($f['DptoCaptura'])." </label>";

                        // echo "</td>";

                    
                        echo TramiteVobos($f['IdTramite']);
                            echo "</td>";

                            $NombreDeTarjeta = TramiteAcuse1Name($f['IdTipoTramite']);	 //<-- Documento Para Justificar la APROBACION (FJA)
                            if ($NombreDeTarjeta==''){
                                echo "<td style='background-color:#E9B620; margin:5px;' valign=middle align=center>";
                            } else {
                                echo "<td style='background-color:#B1CC3B; margin:5px;' valign=middle align=center>";
                            }
                            
                

                        
                        
                        $ArchivoDeEjecucion = TramiteEjecucionName($f['IdTipoTramite']);
                        if ($ArchivoDeEjecucion == '') {
                            echo "<a href='#aprobarTramite".$f['IdTramite']."' rel='MyModal:open' style='display:block' title='APROBAR y Ejecutar el este Tramite' class=''><img src='icon/check.png' style='width:55px;'></a>";    
                        } else {
                            // echo "<cite title='".$ArchivoDeEjecucion."' >* </cite>";
                            echo "<a href='#aprobarTramite".$f['IdTramite']."' rel='MyModal:open' style='display:block' title='APROBAR y Ejecutar el este Tramite' class=''><img src='icon/check2.png' style='width:55px;'></a>";
                        }


                        
                        

    					
                            // ************Modal Aprobar Tramite*********** Cada modal se escribe con id diferente, asi como cada form, concatene el IdTramite
                            echo "<div id='aprobarTramite".$f['IdTramite']."' class='MyModal'><h3>Aprobar Tramite </h3>";
                            echo "<div id='preloaderbloque' style='display: none; width:100%'>";
                            echo "<center>";
                            echo "<img src='img/loader4.gif' style='width: 30%; height:30%;' class='cargando_img'>";
                            echo "<label>Cargando...</label>";
                            echo "</center>";
                            echo "</div>"; 
                           
                            echo "<div id='aprobar1' style='display: inline-block; width:100%'>";
                            $NombreDelRequisito='Tarjeta de autorización';					
                            $Descripcion='Subir Tarjeta de autorización';
                            $IdRequisito='TarjetaAutorizacion';
                            $FolioTramite=$f['IdTramite'];                            
                            $vinculo='';
                            $TipoTramite=$f['IdTipoTramite'];			

                            echo "<div id='contenedor' style='width:100%'>";
                                echo "<div id='mostrararchivo' style='width:50%; display:inline-block;'>";
                                    echo "<b style='font-size:10pt;'>Formato de Justificación de Aprobacion (FJA)</b><br>";
                                    if ($NombreDeTarjeta == ''){
                                        echo "<b style='color:orange;'>Para este tramite no es necesario subir un Formato FJA</b>";
                                    } else {
                                        echo "<iframe id='frame' name='frame' src='".$NombreDeTarjeta."?folio=".$FolioTramite."'
                                        style='width:100%; height:50%; border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
                                    }
                                    echo "</div>";//cierra mostrar archivo

                                    if ($NombreDeTarjeta==''){
                                        echo "<div  id='botonaprobar".$FolioTramite."' style='display:inline-block;' >";        
                                        echo 'Programa '.$f['IdPrograma'];                                 
                                        //sin necesidad de subir un archivo
                                        echo"<a class='Mbtn btn-azulTam' onclick='AprobarTramite(".$f['IdTramite'].",".$f['IdTipoTramite'].",".$f['IdPrograma'].")' title='Clic para aprobar'><img src='icon/ok.png' style='width:20px; height:20px;'>  </a>";

                                        
                                        echo " <a id='RechazarTramite".$f['IdTramite']."' href='#rechazarTramite".$f['IdTramite']."' rel='MyModal:open' class='Mbtn btn-azulTam' title='Clic para marcar como rechazdo'> <img src='icon/x.png' style='width:20px; height:20px;'></a>"; 
                                        //------------Modal observaciones para rechazar tramite
                                        echo "<div id='rechazarTramite".$f['IdTramite']."' class='MyModal'>";
                                        echo '<label>Observaciones para rechazar el trámite...</label>';
                                        echo "<textarea id='obsRechazado".$f['IdTramite']."'></textarea>";
                                        echo " <center><a class='Mbtn btn-azulTam' onclick='RechazarTramite(".$f['IdTramite'].",".$f['IdTipoTramite'].")' title='Clic para marcar como rechazdo'> Guardar </a></center>"; 
                                        echo "</div>";


                                        echo " <a id='DevolverTramite".$f['IdTramite']."' href='#devolverTramite".$f['IdTramite']."' rel='MyModal:open' class='Mbtn btn-azulTam' title='Clic para marcar como devuelto'> <img src='icon/devolver.png' style='width:20px; height:20px;'></a>"; 
                                        //------------Modal observaciones para rechazar tramite
                                        echo "<div id='devolverTramite".$f['IdTramite']."' class='MyModal'>";
                                        echo '<label>Observaciones para devolver el trámite...</label>';
                                        echo "<textarea id='obsDevuelto".$f['IdTramite']."'></textarea>";
                                        echo " <center><a class='Mbtn btn-azulTam'  onclick='DevolverTramite(".$f['IdTramite'].",".$f['IdTipoTramite'].")'  title='Clic para marcar como devuelto'> Guardar </a></center>"; 
                                        echo "</div>";

                                        echo "</div>";
                                    } else  { // con formata FJA
                                        echo "<div id='subirarchivo' style='width:45%; display:inline-block; vertical-align: top; margin:5px; padding:10px;'>";	
                                        echo "<table width=100%><tr><td><div  id='subir'>";		
                                        echo "<label>".$Descripcion."</label>";					
                                        echo "<form method='POST' action='' enctype='multipart/form-data' id='Form".$FolioTramite."' name='Form".$FolioTramite."' >";
                                        echo '<input type="file"  name="'.$IdRequisito.$FolioTramite.'" id="'.$IdRequisito.$FolioTramite.'"  onchange=SubirArchivo('.$FolioTramite.','.$TipoTramite.',"'.$IdRequisito.'","botonaprobar") >';
                                        echo "</form>";
                                        echo "</div></td><td>";			
                                        $vinculo = "<a href='tramitesFiles/".$IdRequisito.$FolioTramite.".pdf' download='".$IdRequisito.$FolioTramite.".pdf' target=_blank><img src='icon/pdf.png' style='width:36px;'></a>";
                                        echo "<div id='Loader".$IdRequisito.$FolioTramite."' style='display:none;'><img src='img/loader_bar.gif' style='width:18px;'></div>";
                                        echo "<div id='PDF".$IdRequisito.$FolioTramite."' style='display:none;'>".$vinculo."</div></td></tr>";
                                        echo "<tr><td><center>";
                                        
                                        
                                        
                                            echo "<div  id='botonaprobar".$FolioTramite."' style='display:none;' >";                                        
                                            echo"<a class='Mbtn btn-azulTam' onclick='AprobarTramite(".$f['IdTramite'].",".$f['IdTipoTramite'].",".$f['IdPrograma'].")' title='Clic para aprobar'><img src='icon/ok.png' style='width:20px; height:20px;'>  </a>";

                                        
                                            echo " <a id='RechazarTramite".$f['IdTramite']."' href='#rechazarTramite".$f['IdTramite']."' rel='MyModal:open' class='Mbtn btn-azulTam' title='Clic para marcar como rechazdo'> <img src='icon/x.png' style='width:20px; height:20px;'></a>"; 
                                            //------------Modal observaciones para rechazar tramite
                                            echo "<div id='rechazarTramite".$f['IdTramite']."' class='MyModal'>";
                                            echo '<label>Observaciones para rechazar el trámite...</label>';
                                            echo "<textarea id='obsRechazado".$f['IdTramite']."'></textarea>";
                                            echo " <center><a class='Mbtn btn-azulTam' onclick='RechazarTramite(".$f['IdTramite'].",".$f['IdTipoTramite'].")' title='Clic para marcar como rechazdo'> Guardar </a></center>"; 
                                            echo "</div>";
    
    
                                            echo " <a id='DevolverTramite".$f['IdTramite']."' href='#devolverTramite".$f['IdTramite']."' rel='MyModal:open' class='Mbtn btn-azulTam' title='Clic para marcar como devuelto'> <img src='icon/devolver.png' style='width:20px; height:20px;'></a>"; 
                                            //------------Modal observaciones para rechazar tramite
                                            echo "<div id='devolverTramite".$f['IdTramite']."' class='MyModal'>";
                                            echo '<label>Observaciones para devolver el trámite...</label>';
                                            echo "<textarea id='obsDevuelto".$f['IdTramite']."'></textarea>";
                                            echo " <center><a class='Mbtn btn-azulTam'  onclick='DevolverTramite(".$f['IdTramite'].",".$f['IdTipoTramite'].")'  title='Clic para marcar como devuelto'> Guardar </a></center>"; 
                                            echo "</div>";
    
                                        
                                        
                                        echo "</center></td></tr>";
                                        echo "</table>";
                                    echo "</div>"; //cierra  subir archivo

                                    }
                                   

                                    $Nombres = TramiteNombres($FolioTramite);
                                    $Apellido1 = TramiteApellido1($FolioTramite);
                                    $Apellido2= TramiteApellido2($FolioTramite);
                                    $NombreCompleto = $Nombres." ".$Apellido1." ".$Apellido2;
                    
                                    echo sugerencia("Se recomienda realizar una busqueda en los sistemas de esta persona, antes de aprobar el tramite. Para que conozca el contexto de este ciudadano");
                                
                                
                                
                            echo "</div>"; //cierra contenedor
                            echo "</div>"; //cierra modal aprobar
                        echo "</div>";
				

					 

					// echo " <a id='RechazarTramite".$r['IdTramite']."' href='#rechazarTramite".$r['IdTramite']."' rel='MyModal:open' class='Mbtn btn-azulTam' title='Clic para marcar como rechazdo'> <img src='icon/x.png' style='width:20px; height:20px;'></a>"; 
					// //------------Modal observaciones para rechazar tramite
					// echo "<div id='rechazarTramite".$r['IdTramite']."' class='MyModal'>";
					// echo '<label>Observaciones para rechazar el trámite...</label>';
					// echo "<textarea id='obsRechazado".$r['IdTramite']."'></textarea>";
					// echo " <center><a class='Mbtn btn-azulTam' onclick='RechazarTramite(".$r['IdTramite'].",".$r['IdTipoTramite'].")' title='Clic para marcar como rechazdo'> Guardar </a></center>"; 
					// echo "</div>";

					// echo " <a id='DevolverTramite".$r['IdTramite']."' href='#devolverTramite".$r['IdTramite']."' rel='MyModal:open' class='Mbtn btn-azulTam' title='Clic para marcar como devuelto'> <img src='icon/devolver.png' style='width:20px; height:20px;'></a>"; 
					// //------------Modal observaciones para rechazar tramite
					// echo "<div id='devolverTramite".$r['IdTramite']."' class='MyModal'>";
					// echo '<label>Observaciones para devolver el trámite...</label>';
					// echo "<textarea id='obsDevuelto".$r['IdTramite']."'></textarea>";
					// echo " <center><a class='Mbtn btn-azulTam'  onclick='DevolverTramite(".$r['IdTramite'].",".$r['IdTipoTramite'].")'  title='Clic para marcar como devuelto'> Guardar </a></center>"; 
					// echo "</div>";

                    
                        echo "</td>";
                        echo "</tr>";
                } else {
                    // $msg= $msg."<li>Tramite:[".$f['IdTipoTramite']."][".$f['IdTramite']."] - ".$f['NombreTramite']." de ".$f['NombreBeneficiario']."</li> ";
                }
            }
            echo "<script> $('#APROBAR_Pendientes').html('".$aprobas."');</script>";
            echo "</table>";
            if ($msg <> ''){
                echo "<label> * Estos tramites estan pendientes de Captura o Envio, sin embargo no tienes permiso para dichos movimientos sobre el Tipo de Tramite: <lu>".$msg."</lu></label>";
            }
    echo "</div>";
    // =============== [fin] BARRA CAPTURAS PENDIENTES DE aprobar ===============================





    //buscar
    echo "<div id='BuscarUnTramite' style='
    padding: 6px;

    background-color:
    #eeece6;

    margin-top: 20px;

    margin-left: 0px;

    border-radius: 5px;

    border: 1px solid
    #f0e1c5;
    margin-right: -10px;
    '>";
    echo '<div id="beta_buscar" style="
    
    ">';
	echo '<form action="" method="get">';
	
		echo '<input type="hidden" name="" id="brig" value="">';
	
		echo '<table broder="1" width="100%"><tr>';
			echo '<td>                    <input required="required" type="text" id="beta_buscar_input" name="q" placeholder="Buscar Tramite (persona, IdTramite)" /></td>';
			echo '<td align="right" width="15px">                    
			<button id="beta_buscar_boton">
			<img  src="icon/buscar.png"></button>
			</td>';
		echo '</tr></table>';
	echo '</form>';
    echo '                </div>';

    if (isset($_GET['q'])){
        $busqueda = $_GET['q']; if (ValidaVAR($busqueda)==TRUE){$busqueda = LimpiarVAR($busqueda);} else {$busqueda = "";}
        $sql="select 
        IdTramiteURL,
         NombreTramite,
         Fecha, Departamento
        from 
        tramitesbusqueda_html
        WHERE NombreBeneficiario like '%".$busqueda."%' OR IdTramite like '%".$busqueda."%'";
        TablaDinamica_MySQL("",$sql, "tramitesBusquedaTabla", "tramitesBusquedaTablaid", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
    
    }
    
    echo "</div>";




    //Tramite Nuevo
    echo "<a href='#iniciarTramite' rel='MyModal:open' class=' btn-g' title='Nueva Solicitud'>";
	echo "<table  width='100%'><tr><td valign='middle' align='center'>";
	echo "<img src='icon/mas2.png' >";
	echo "</td>";
	echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
	echo "</td></tr></table>";
echo "</a>";



// ************Modal**************
echo "<div id='iniciarTramite' class='MyModal'><h3>Solicitar un Tramite: </h3>";
echo "<table width=100%><tr><td width=50%>";
echo "<table width=100%><tr><td valign=top>";
    echo "<input required ='required'type='text' style='height:55px; margin:0px; font-size:19pt;' id='_curp' name='_curp' value='' maxlength='18' onkeyup='mayus(this); PortCurp();' placeholder='CURP del Solicitante' required></td>";
    echo "<td valign=top><button onclick='CURP_persona();' style='height:50px; margin:0px;' class='Mbtn btn-CelesteTam'>
    <img src='icon/btn_derecha.png' style='width:30px' id='flecha'>
    <img src='img/loader_bar.gif' style='width:30px; display:none;' id='LoaderCurp'>
        
        </button></td>";
echo "</tr></table>";

echo "<div id='Persona'>";
echo "</div>";


echo "</td><td>";
//Seleccion del Tramit
echo "<form action='tr_iniciar.php' method='POST'>";
    echo "<div>";
        /*$sql="select * from tramitestipo t WHERE Cancelado=0
        AND IdTipoTramite not in (select IdTipoTramite from tramitesBloqueos WHERE IdDpto=55) 
        order by Programa";
        echo "<select id='IdTipoTramite' name='IdTipoTramite' onchange='ValidarTramiteSeleccionar();' required>";
        echo "<option value='' selected>Selecciona un Tramite </option>";
        $r= $conexion -> query($sql);	
        while($f = $r -> fetch_array()) {
            echo "<option value='".$f['IdTipoTramite']."'>[".$f['Programa']."] - ".$f['NombreTramite']."</option>";
        }
    
        echo "</select>";*/
        echo "<select name='programa' id='programa'>";
        //id='programas'
        echo "<option value='' selected>Selecciona un Programa </option>";
        $sql = "SELECT * FROM programa WHERE  Activo=1 AND IdTipoPreSolicitud <> '' or IdTipoPreSolicitud <> null ORDER by Programa ASC";
            $r = $Vivienda -> query($sql);
            while($f = $r -> fetch_array())
            { // resultado de la busqueda.................
                echo "<option value='".$f['IdPrograma']."'>".$f['Programa']. "</option>";
            }

        echo "</select>";
    echo "</div>";
    echo "<div>";
        echo "<select name='delegacion' id='delegacion'>";
        echo "<option value='' selected>Selecciona una delegación </option>";
            $sql = "SELECT * FROM delegaciones where Tipo = 0 ORDER by Delegacion ASC";
            $r = $Vivienda -> query($sql);
            while($f = $r -> fetch_array())
            { // resultado de la busqueda.................
                echo "<option value='".$f['IdDelegacion']."'>".$f['Delegacion']. "</option>";
            }
        echo "</select>";
    echo "</div>";

    echo "<input name='txtCurp' id='txtCurp' type='hidden' value=''>";
    echo "<input class='Mbtn btn-AzulTam' type='submit' value='Tramitar' name='BtnSolicitar' id='BtnSolicitar'>";
echo "</form>";
echo "</td></tr>";
echo "</table>";

echo "</div>";


if ($nivel==1){
     //Resumen
     echo "<div id='PorPrograma' style='
     background-color:
#0c90aa;

padding: 11px;





border-radius: 5px;

margin: 0px;
margin-right: -11px;
margin-top: 10px;
'>";
     echo "<h3>tramites por Programa</h3>";
     $sql="
     select 
        CONCAT(NombreTramite,'(',Programa,')') as Tramite,
        Departamento,
        NCapturas as Capturas,
        NEnviados as Pendientes,
        NAprobados as Aprobados,
        NRechazados as Rechazados,
        NDevueltos as Devueltos
        
     from tramitesestadisticaporprograma a";
     TablaDinamica_MySQL("",$sql, "MiIdDivTabla2", "IdTabla2", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal

    echo "</div>";
}


    echo "</td>";
    echo "<td valign=top align=center >"; // graficas de rendimiento
    if ($nivel == 1){ // El Administrador | Lo ve todo

    
    
    } else {
     //Graficas de tu departamento y los que dependen de ti   
    



    }      


    //Grafica todo
    echo "<div id='Grafos' style='
        
        border-radius:8px;
        padding: 3px;
        background-color:
        #eee;
        margin-left: 22px;
    '>";
    echo "<table width=100%><tr><td align=right>";
    echo "<a title='Minimizar esta seccion' href='?&g=90' style='width:100%; text-align:right; opacity:0.7; margin:5px;'><img src='icon/minimizar.png' style='width:20px;'></a> ";
    echo "<a title='Hacer pequeña esta seccion' href='?&g=50' style='width:100%; text-align:right; opacity:0.7; margin:5px;' ><img src='icon/midle.png' style='width:20px;'></a>" ;
    echo "<a title='Maximizar esta seccion' href='?&g=10' style='width:100%; text-align:right; opacity:0.7; margin:5px;'><img src='icon/maximizar.png' style='width:20px;'></a> " ;
    echo "</td></tr></table>";


    if ($nivel == 1){//Graficas de todo
        echo "<div id='GCapturas1n1' style='width:100%;'></div>";
    $sql = "
    SELECT 
	(select sum(NCaptura) from tramitesestadistica ) as NCapturados,
	(select sum(NEnviados) from tramitesestadistica ) as NPendientes,
	(select sum(NAprobados) from tramitesestadistica ) as NAprobados,
	(select sum(NRechazados) from tramitesestadistica ) as NRechazados,
	(select sum(NDevueltos) from tramitesestadistica ) as NDevueltos
    
    ";    
    $r= $conexion -> query($sql);
    $data = "";
    while($f = $r -> fetch_array()) {
        
        $data = $data."['Aprobados',".$f['NAprobados']."],";
        $data = $data."['Rechazados',".$f['NRechazados']."],";
        $data = $data."['Devueltos',".$f['NDevueltos']."],";
        $data = $data."['En Captura',".$f['NCapturados']."],";
        $data = $data."['Enviados (Pendientes de Aprobar)',".$f['NPendientes']."],";
        

    }
    
    $data = substr($data, 0, -1); //quita la ultima coma.
    $height=400;
    if (isset($_GET['g'])){
        if ($_GET['g']==90){
            $height = 400;
        } else {
            $height = 600;
        }
        
    } else {

    }
    echo "<script>
        GraficaColaboradores();


        function GraficaColaboradores(){
            google.charts.load('current', {packages:['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Colaborador', 'Casos Abiertos'], ".$data."
                
                    
            ]);

            var options = {
                title: 'Conteo Global de tramites',
                pieHole: 0.6,
                
                height:".$height.",
                
                
                legend: {position: 'bottom',textStyle: {color: 'gray', fontSize: 8}}
            };

            var chart = new google.visualization.PieChart(document.getElementById('GCapturas1n1'));
            chart.draw(data, options);
            }
        }
        </script>
        ";

         echo "<div id='GCapturas3_' style='width:100%;'></div>";
        $sql3 = "
        Select DISTINCT Programa, 
            (select SUM(NCapturas) from tramitesestadisticaporprograma WHERE DptoCaptura=55 and Programa = a.Programa) as NCapturas,
            (select SUM(NAprobados) from tramitesestadisticaporprograma WHERE DptoCaptura=55 and Programa = a.Programa) as NAprobados,
            (select SUM(NEnviados) from tramitesestadisticaporprograma WHERE DptoCaptura=55 and Programa = a.Programa) as NEnviados,
            (select SUM(NDevueltos) from tramitesestadisticaporprograma WHERE DptoCaptura=55 and Programa = a.Programa) as NDevueltos,
            (select SUM(NRechazados) from tramitesestadisticaporprograma WHERE DptoCaptura=55 and Programa = a.Programa) as NRechazados


        from tramitesestadisticaporprograma a
        WHERE   
        DptoCaptura=".nitavu_dpto($nitavu)." ";    
        // echo $sql3;
        $r3= $conexion -> query($sql3);
        $data = "";
        while($f3 = $r3 -> fetch_array()) {
            
            $data = $data."['".$f3['Programa']."',".$f3['NCapturas'].", ".$f3['NEnviados'].",".$f3['NAprobados'].",".$f3['NRechazados'].",".$f3['NDevueltos']."],";
            
            
    
        }
        $data = substr($data, 0, -1); //quita la ultima coma.
       
        echo "<script>
        GraficaColaboradores3();


        function GraficaColaboradores3(){
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
              var data = google.visualization.arrayToDataTable([
                ['Programa', 'Capturas', 'Enviados', 'Aprobados', 'Rechazados', 'Devueltos'],
                ".$data."
              ]);
      
              var options = {
                chart: {
                  title: 'Movimientos por Progama',
                  subtitle: 'tramites',
                }
                
              };
      
              var chart = new google.charts.Bar(document.getElementById('GCapturas3_'));
      
              chart.draw(data, google.charts.Bar.convertOptions(options));
            }
      
        }
        </script>
        ";


            //Resumen
            echo "<hr><div id='GCapturas3' style='width:100%;'></div>";
            $sql3 = "
            Select * from tramitesestadistica WHERE NCaptura>0
            ";    
            // echo $sql3;
            $r32= $conexion -> query($sql3);
            $data = "";
            echo "<table class='tabla'><th>Departamento</th><th>Capturados</th><th>Enviados</th><th>Aprobados</th><th>Rechazados</th><th>Devueltos</th>";
            while($fdx1 = $r32 -> fetch_array()) {
                echo "<tr>";
                echo "<td>".$fdx1['Departamento']."</td>";
                echo "<td>".$fdx1['NCaptura']."</td>";
                echo "<td>".$fdx1['NEnviados']."</td>";
                echo "<td>".$fdx1['NAprobados']."</td>";
                echo "<td>".$fdx1['NRechazados']."</td>";
                echo "<td>".$fdx1['NDevueltos']."</td>";

                echo "</tr>";
                $data = $data."['".$fdx1['Departamento']."',".$fdx1['NCaptura'].", ".$fdx1['NEnviados'].",".$fdx1['NAprobados'].",".$fdx1['NRechazados'].",".$fdx1['NDevueltos']."],";
            
           
            }

            $data = substr($data, 0, -1); //quita la ultima coma.
            echo "</table>";


            echo "<script>
            GraficaColaboradores3();
    
    
            function GraficaColaboradores3(){
                google.charts.load('current', {'packages':['bar']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                  var data = google.visualization.arrayToDataTable([
                    ['Programa', 'Capturas', 'Enviados', 'Aprobados', 'Rechazados', 'Devueltos'],
                    ".$data."
                  ]);
          
                  var options = {
                    chart: {
                      title: 'Movimientos por Delegacion o Dpto',
                      subtitle: 'tramites',
                    },
                    bars: 'horizontal' // Required for Material Bar Charts.
                  };
          
                  var chart = new google.charts.Bar(document.getElementById('GCapturas3'));
          
                  chart.draw(data, google.charts.Bar.convertOptions(options));
                }
          
            }
            </script>
            ";






            // Por programas:
            
           
            // echo "<script>
            // GraficaColaboradores3();
    
    
            // function GraficaColaboradores3(){
            //     google.charts.load('current', {'packages':['bar']});
            //     google.charts.setOnLoadCallback(drawChart);
            //     function drawChart() {
            //       var data = google.visualization.arrayToDataTable([
            //         ['Programa', 'Capturas', 'Enviados', 'Aprobados', 'Rechazados', 'Devueltos'],
            //         ".$data."
            //       ]);
          
            //       var options = {
            //         chart: {
            //           title: 'Movimientos por Delegacion o Dpto',
            //           subtitle: 'tramites',
            //         },
            //         bars: 'horizontal' // Required for Material Bar Charts.
            //       };
          
            //       var chart = new google.charts.Bar(document.getElementById('GCapturas3'));
          
            //       chart.draw(data, google.charts.Bar.convertOptions(options));
            //     }
          
            // }
            // </script>
            // ";
    
           
        

    } else 
    {


    echo "<div id='GCapturas1' style='width:100%;'></div>";
    $sql = "select * from tramitesestadistica WHERE IdDpto=".nitavu_dpto($nitavu)." limit 1";    
    $r= $conexion -> query($sql);
    $data = "";
    while($f = $r -> fetch_array()) {
        
        $data = $data."['Aprobados',".$f['NAprobados']."],";
        $data = $data."['Rechazados',".$f['NRechazados']."],";
        $data = $data."['Devueltos',".$f['NDevueltos']."],";
        $data = $data."['En Captura',".$f['NCaptura']."],";
        $data = $data."['Enviados (Pendientes de Aprobar)',".$f['NEnviados']."],";
        

    }
    
    $data = substr($data, 0, -1); //quita la ultima coma.
    $height=400;
    if (isset($_GET['g'])){
        if ($_GET['g']==90){
            $height = 400;
        } else {
            $height = 600;
        }
        
    } else {

    }
    echo "<script>
        GraficaColaboradores();


        function GraficaColaboradores(){
            google.charts.load('current', {packages:['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Colaborador', 'Casos Abiertos'], ".$data."
                
                    
            ]);

            var options = {
                title: 'Mis tramites (".nitavu_dpto_nombre($nitavu).")',
                pieHole: 0.6,
                height:".$height.",
                
                
                legend: {position: 'bottom',textStyle: {color: 'gray', fontSize: 8}}
            };

            var chart = new google.visualization.PieChart(document.getElementById('GCapturas1'));
            chart.draw(data, options);
            }
        }
        </script>
        ";



        echo "<div id='GCapturas3' style='width:100%;'></div>";
        $sql3 = "
        Select DISTINCT Programa, 
            (select SUM(NCapturas) from tramitesestadisticaporprograma WHERE DptoCaptura=55 and Programa = a.Programa) as NCapturas,
            (select SUM(NAprobados) from tramitesestadisticaporprograma WHERE DptoCaptura=55 and Programa = a.Programa) as NAprobados,
            (select SUM(NEnviados) from tramitesestadisticaporprograma WHERE DptoCaptura=55 and Programa = a.Programa) as NEnviados,
            (select SUM(NDevueltos) from tramitesestadisticaporprograma WHERE DptoCaptura=55 and Programa = a.Programa) as NDevueltos,
            (select SUM(NRechazados) from tramitesestadisticaporprograma WHERE DptoCaptura=55 and Programa = a.Programa) as NRechazados


        from tramitesestadisticaporprograma a
        WHERE   
        DptoCaptura=".nitavu_dpto($nitavu)." ";    
        // echo $sql3;
        $r3= $conexion -> query($sql3);
        $data = "";
        while($f3 = $r3 -> fetch_array()) {
            
            $data = $data."['".$f3['Programa']."',".$f3['NCapturas'].", ".$f3['NEnviados'].",".$f3['NAprobados'].",".$f3['NRechazados'].",".$f3['NDevueltos']."],";
            
            
    
        }
        $data = substr($data, 0, -1); //quita la ultima coma.
        echo "<script>
            GraficaColaboradores3();
    
    
            function GraficaColaboradores3(){
                google.charts.load('current', {'packages':['bar']});
                google.charts.setOnLoadCallback(drawChart);
          
                function drawChart() {
                  var data = google.visualization.arrayToDataTable([
                    ['Programa', 'Capturas', 'Enviados', 'Aprobados', 'Rechazados', 'Devueltos'],
                    ".$data."
                  ]);
          
                  var options = {
                    legend: {position: 'top',textStyle: {color: 'gray', fontSize: 12}},
                    chart: {
                      title: 'Actividad por Programas | Clasficiacion ',
                      
                      subtitle: 'tramites',
                    }
                  };
          
                  var chart = new google.charts.Bar(document.getElementById('GCapturas3'));
          
                  chart.draw(data, google.charts.Bar.convertOptions(options));
                }
          
            }
            </script>
            ";
    



    //Lista solo de mis departamentos
    // $DepartamentoAlcance;
    $sqldx ="Select * from tramitesestadistica WHERE IdDpto in(".$DepartamentoAlcance.")";
    //echo $sqldx;
    $rdx= $conexion -> query($sqldx);
    echo "<div id='TEstadistica' style='margin-left:10px;'><b style='color:#484848; font-size:9pt;'>Estadistica de mis tramites: (de los que dependen de mi)</b>";
    echo "<table class='tabla'><th>Departamento</th><th>Capturados</th><th>Enviados</th><th>Aprobados</th><th>Rechazados</th><th>Devueltos</th>";
    while($fdx = $rdx -> fetch_array()) {
        echo "<tr>";
        echo "<td>".$fdx['Departamento']."</td>";
        echo "<td>".$fdx['NCaptura']."</td>";
        echo "<td>".$fdx['NEnviados']."</td>";
        echo "<td>".$fdx['NAprobados']."</td>";
        echo "<td>".$fdx['NRechazados']."</td>";
        echo "<td>".$fdx['NDevueltos']."</td>";

        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";


    
    $sqld2 ="Select * from tramitesestadisticaporprograma WHERE DptoCaptura in(".$DepartamentoAlcance.")";
    $rd2= $conexion -> query($sqld2);
    echo "<div id='TEstadistica2' style='margin-left:10px;'><br><b style='color:#484848; font-size:9pt;'>Estadistica Por Programa:(de los que depeden de mi)</b>";
    echo "<table class='tabla'><th>Departamento</th><th>Programa</th><th>Capturados</th><th>Enviados</th><th>Aprobados</th><th>Rechazados</th><th>Devueltos</th>";
    while($fd2 = $rd2 -> fetch_array()) {
        echo "<tr>";
        echo "<td>".$fd2['Departamento']."</td>";
        echo "<td>".$fd2['NombreTramite'].", ".$fd2['Programa']."</td>";
        echo "<td>".$fd2['NCapturas']."</td>";
        echo "<td>".$fd2['NEnviados']."</td>";
        echo "<td>".$fd2['NAprobados']."</td>";
        echo "<td>".$fd2['NRechazados']."</td>";
        echo "<td>".$fd2['NDevueltos']."</td>";

        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";

}//fin graficas


    echo "</div>";
    echo "<a class='Mbtn btn-tercero' style='color:white; font-weight:bold;' href='tramites_config.php'>Configurar Perfil de Acceso a tramites</a>";


    echo "</td>";
    echo "</tr></table>";

    echo "<div id='respuesta' style='background-color:purple; color:white;'></div>";

} else {mensaje("ERROR: no tiene acceso a esta aplicacion","");}





?>


<script>
function mayus(e) {
    e.value = e.value.toUpperCase();
}






function SubirArchivo(FolioTramite,TipoTramite,campo,boton){
$("#Loader" + FolioTramite).css({'display':'inline-block'});
$("#PDF" + FolioTramite).css({'display':'none'});


var inputFileImage = document.getElementById(campo+FolioTramite);

var file = inputFileImage.files[0];
var data = new FormData();

data.append('campo',campo);
data.append(campo+FolioTramite,file);
data.append("Folio",FolioTramite);
data.append("Tipo",TipoTramite);
// data.append(file,file);
console.log(data);
$.ajax({
        url: "tr_dat22.php",        
        type: "POST",             
        data: data, 			  
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(data)   
        {
			
            $('#PDF' +campo+FolioTramite).html(data);
			$("#PDF"  +campo+FolioTramite).css({'display':'inline-block'});          
		   	$("#Loader"  +campo+ FolioTramite).css({'display':'none'});		  
			//$(boton + FolioTramite).css({'display':'inline-block'});		
			$("#"+boton+FolioTramite).css({'display':'inline-block'});
		//	$("#botonaprobar" + FolioTramite).css({'display':'inline-block'});
        }
    });
    

}

function ValidarTramite(FolioTramite, IdTipoTramite){


	 //$("#Loader" + IdRequisito).show();
	$.ajax({
	url: "tr_dat3.php",
	type: "get",        
	data: {Folio:FolioTramite, IdTipoTramite:IdTipoTramite},
	success: function(data){   
		$('#respuesta').html(data);
		$("#Registro" + FolioTramite).hide();
        
        $("#enviarTramite"+FolioTramite).parent().hide();
        //$("#enviarTramite"+FolioTramite).modal().hide();
		NPush(data,'Plataforma ITAVU');
       /* $('#myModal').modal({
            clck();
            });*/
		
		/*var res=data.trim();
		if(res.includes('COMPLETO')==true){
			$("#Registro" + FolioTramite).hide();
			$(".close-modal").get(0).click();
        	NPush('Se ha enviado el tramite','Plataforma ITAVU');
    
		}else
		{
			NPush(data,'Plataforma ITAVU');
		}
		/*else{
			NPush('ERROR: No puedes continuar con la solicitud ya que el requisito es que personas solteras menores de 30 años no se admiten. A excepciòn de madres y padres solteros que demuestren con acta de nacimiento tener hijos(as).','Plataforma ITAVU');
    
		}*/

		   
	}
	}); 
}
	function AprobarTramite(FolioTramite, IdTipoTramite, IdPrograma){
        $("#preloaderbloque").css({'display':'inline-block'});
        
        $("#aprobar1").css({'display':'none'});

	$.ajax({
	url: "tr_dat5.php",
	type: "get",        
	data: {Folio:FolioTramite, IdTipoTramite:IdTipoTramite, IdPrograma: IdPrograma},
	success: function(data)
	{   
        console.log(data);
		$('#respuesta').html(data);
        $("#aprobar1").css({'display':'inline-block'});
        $("#preloaderbloque").css({'display':'none'});
		var res=data.trim();
		/*mensaje=res.split('_')[1];
		if (res.search('TRUE') != -1) 
		{
			$("#Registro" + FolioTramite).hide();
			NPush(mensaje,'Plataforma ITAVU');
		} */
		
		if(res.includes('TRUE')==true)
		{
            //actualizar contador

            var c = $('#APROBAR_Pendientes').html();
            c = c -1;
            $('#APROBAR_Pendientes').html(c)
			$("#RegistroAprobar" + FolioTramite).hide();		
			NPush('Se ha marcado el trámite como aprobado','Plataforma ITAVU' +  data ); 	
            		
            //$('body').removeClass('modal-open');
            //$('.modal-backdrop').remove();
            $('#aprobarTramite'+FolioTramite).parent().hide();
            //$('#aprobarTramite'+FolioTramite).modal('toggle'); 	
           // $("#aprobarTramite"+FolioTramite+" .close").click();	
			//$(".close-modal").get(0).click();
		}else{
			//alert(data);
			NPush('Ocurrio un error al momento de marcar el trámite, por favor intentelo de nuevo.','Plataforma ITAVU');
		}
	}
	}); 	
	}

	function RechazarTramite(FolioTramite, IdTipoTramite){
	var obs = document.getElementById("obsRechazado"+FolioTramite).value;
	$.ajax({
	url: "tr_dat6.php",
	type: "get",        
	data: {Folio:FolioTramite, IdTipoTramite:IdTipoTramite,obs:obs},
		success: function(data)
		{   
			$('#respuesta').html(data);
			var res=data.trim();
			/*mensaje=res.split('_')[1];
			if (res.search('TRUE') != -1) 
			{
				$("#Registro" + FolioTramite).hide();
				NPush(mensaje,'Plataforma ITAVU');
			} */	
			
			if(res=='TRUE')
			{
				$("#Registro" + FolioTramite).hide();
				$(".close-modal").get(0).click();		
                $("#RegistroAprobar" + FolioTramite).hide();	
				NPush('Se ha marcado el trámite como rechazado','Plataforma ITAVU'); 
			
			
			}else{
			NPush('Ocurrio un error al momento de marcar el trámite, por favor intentelo de nuevo.','Plataforma ITAVU');
		}
		}
	}); 

}
function DevolverTramite(FolioTramite, IdTipoTramite){
	var obs = document.getElementById("obsDevuelto"+FolioTramite).value;
	$.ajax({
	url: "tr_dat7.php",
	type: "get",        
	data: {Folio:FolioTramite, IdTipoTramite:IdTipoTramite,obs:obs},
		success: function(data)
		{   
			$('#respuesta').html(data);
			var res=data.trim();
			/*mensaje=res.split('_')[1];
			if (res.search('TRUE') != -1) 
			{
				$("#Registro" + FolioTramite).hide();
				NPush(mensaje,'Plataforma ITAVU');
			} */
				
			if(res.includes('TRUE')==true){			
				$("#Registro" + FolioTramite).hide();
				$(".close-modal").get(0).click();	
                $("#RegistroAprobar" + FolioTramite).hide();		
				NPush('Se ha marcado el trámite como devuelto','Plataforma ITAVU'); 
			
			
			
			}else{
				NPush('Ocurrio un error al momento de marcar el trámite, por favor intentelo de nuevo.','Plataforma ITAVU');
			}
		}
	}); 

}

function DarVistoBueno(FolioTramite, nitavu, idTipo){
	var obs = document.getElementById("Obs"+FolioTramite).value;
	$.ajax({
	url: "tr_dat4.php",
	type: "post",        
	data: {Folio:FolioTramite, nitavu: nitavu, obs: obs, idTipo: idTipo},
	success: function(data){   
		$('#respuesta').html(data);
		var res=data.trim();
		if(res=='TRUE'){
			$("#Registro" + FolioTramite).hide();
			$(".close-modal").get(0).click();
        	NPush('Se ha marcado con Visto Bueno el trámite.','Plataforma ITAVU');
		}else{
			NPush('Ocurrio un error al momento de marcar el trámite, por favor intentelo de nuevo.','Plataforma ITAVU');
		}   
	}
	});
}

function ValidarTramiteSeleccionar(){
	var CURP = $("#_curp").val();
	var IdTipoTramite = $("#IdTipoTramite").val();
    if (CURP ==''){
        $("#_curp").focus();
    } else {
        console.log("CURP = "+CURP + ", IdTipoTramite="+IdTipoTramite);
        $.ajax({
        url: "tr_datval.php",
        type: "get",        
        data: {Folio:IdTipoTramite, CURP:CURP},
        success: function(data){   
            $('#respuesta').html(data);
        }
	});
		
    }
}

function printDiv(id) 
{

  var divToPrint=document.getElementById('imprimir'+id);

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}

function PortCurp(){
var curp = $('#_curp').val();

$('#txtCurp').val(curp);
}

function CURP_persona(){
var curp = $('#_curp').val();

$('#txtCurp').val(curp);
console.log(curp);

    $("#flecha").hide();
    $("#LoaderCurp").show();

    $.ajax({
    url: "tr_datcurp1.php",
    type: "get",        
    data: {curp:curp},
    success: function(data){   
    $('#Persona').html(data);
    
        $("#flecha").show();
        $("#LoaderCurp").hide();

    
        
    }
    }); 

}

function SeleccionarTramite(){

}

</script>

<?php

include ("./lib/body_footer.php"); ?>
