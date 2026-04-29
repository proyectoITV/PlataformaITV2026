<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php"); include ("./lib/body_menu.php");


?>
<?php
$id_aplicacion ="ap112"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);


if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
   echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
   xd_update($id_aplicacion,$nitavu);//guarda la experiencia del usuario
   historia($nitavu, "Entro a la aplicacion [ap112], para el envio de escrituras.");

   
   echo "<br>"; 
   $accion=5;// IMPRESION DE ESCRITURA
   $direccion=quienEsmiDireccion(nitavu_dpto($nitavu));   
   $paso = ObtenerPaso($direccion,$accion);
  // $llenos= ObtenerQueCamposDeberiaEstarLlenos($paso);


  
   echo '<center>
   <form id="myformopciones" name="myformopciones">
    <div class="form-check form-check-inline" style="width: auto;">
        <input class="form-check-input" type="radio" name="opciones" id="enviodeescrituras"style="width: 15px;height: 15px;"   onclick="checkRadio(id)" value="enviar" >
        <label class="form-check-label" for="inlineRadio1">Envio</label>
    </div>
    <div class="form-check form-check-inline" style="width: auto;">
        <input class="form-check-input" type="radio"  name="opciones" id="recepciondeescrituras"  style="width: 15px;height: 15px;"  onclick="checkRadio(id)"   value="recepcion" >
        <label class="form-check-label" for="inlineRadio2">Recepción</label>
    </div></form>';

    echo '<div class="col-md-4" >'; 
    echo "<select  name='envio' style='margin-left: 0px;' id='envio' onchange='mostrarinfo(this.value)' style='display:inline-block'  >";
    $sql2="select * from esc_confseguimiento where opcion like '%envio%'";
    $r2 = $Vivienda -> query($sql2);
    echo '<option value="0" >Seleccione una opcion...</option>';
    while($f = $r2 -> fetch_array())
    {
            echo "<option value='".$f['idaccion']."'>".$f['Opcion']."</option>";
    } 
    echo "</select>";  
    
    
    echo "<select  name='recepcion' style='margin-left: 0px;' id='recepcion' onchange='mostrarinfo(this.value)'   style='display:none;' >";
    $sql2="select * from esc_confseguimiento where opcion like '%Recepcion %' and opcion not like '%error%'";
    $r2 = $Vivienda -> query($sql2);
    echo '<option value="0" selected >Seleccione una opcion...</option>';
    while($f = $r2 -> fetch_array())
    {
         echo "<option value='".$f['idaccion']."'>".$f['Opcion']."</option>";                
    } 
    echo "</select>";  

echo '</div>';
echo '</center>';;
echo '<div class="col-md-4">  <button style="display:none;" name="multiple_impresion" id="multiple_impresion" class="btn btn-primary" type="submit" >Enviar</button></div>';
echo '<form action="e006.php" method="post">';
echo '<section>'; 

echo '<br>';   
echo "<div style='background-color:#EEEEEE; width:95%; display:none; 
border-radius:5px; padding:10px; margin-top:20px;' id= 'contendidoenvios'>";
        // echo "<h2>tramites de Escritura para Impresión</h2>";
        // echo "<input type='hidden' name='gridImpresion' id='gridImpresion' value='Impresion' >" ;  
        // TablaDinamica_MySQLVivienda("",$sql, "tramitesImpresion", "TablaImpresion", "divAncho", 2); 

        
echo "</div>";             
echo '<section>'; 
echo '</form>';



///RECIBIR LAS VARIABLES PARA GUARDAR EN LA BD
if(isset($_POST['notario'])){
    $notario = $_POST['notario'];
    $observaciones = $_POST['observaciones'];
    $oficio = $_POST['oficio'];

    $seleccion = $_POST['selected'];

    $res = '';
    echo $notario.'<br>';
    echo $observaciones.'<br>';
    echo $oficio.'<br>';

    if(isset($_POST['municipio'])){
        $municipio = $_POST['municipio'];
    }else{
        $municipio = "";
    }


    if(isset($_POST['op'])){
        echo 'entro';
        $op = $_POST['op'];
       for($i = 0; $i < sizeof($op); $i++){
        echo $op[$i].'<br>';

        //hacemos la actualizacion 
        $sql = "update movescrituras  set FechaUltimaMod=now(), enviar=1, paqenv = 1 , IdEmpModifica= '".$nitavu."' where cancelado=0 and numescritura = '".$op[$i]."' ";
       // echo $sql.'<br>';
        if ($Vivienda->query($sql) == TRUE)
        {
            $res = 'TRUE';
            //INSERTAMOS EN SEGUIMIENTO 
            if ($seleccion == 6){
                $observaciones = "NOTARIO: ".$notario." ".$observaciones;
            }else if ($seleccion == 7 || $seleccion == 8 || $seleccion == 9)
            {
                $observaciones = $observaciones;
            }else if ($seleccion == 10 ){
                $observaciones = "NOTARIO: ".$notario."; ".$observaciones;
            }
            else if ($seleccion == 11 )
            {
                $observaciones = "MUNICIPIO: ".$municipio."; ".$observaciones;
            } else if ($seleccion == 12 )
            {
                
                if ($notario != "COORDINACIÓN DE DELEGACIONES")
                {
                    $observaciones = "DELEGACION: " .$notario."; " . $observaciones;
                }else
                {
                    $observaciones = "ENVIADO A: " .$notario. "; ".$observaciones;
                }
            }

            $i_cons = obtener_nuevo_id($op[$i]);
            $i_consecutivo = obtener_idConsecutivo($op[$i], $nitavu);
            $del = midelegacionconid($nitavu);
            if($del == ''){
                $i_origen = 'E';
            }else{
                $i_origen = 'D';
            }

            $iddel = substr($op[$i],0,2);

            //hacemos el insert en seguimiento
            $sql1 = "INSERT INTO seguimiento (Consecutivo,Idconsecutivo ,Origen, iddelegacion, idelemento, idaccion, idoperador, fechaoperacion, fecharegistro, cantidadoperacion,soporte_sustento, observaciones,Enviar,FechaUltimaMod, OrigendeEnvio, OriginData) values (
            ".$i_cons.",".$i_consecutivo.", '".$i_origen."',".$iddel.", '".$op[$i]."', ".$seleccion.", ".$nitavu.", now(), now(), 1, '', UPPER('".$observaciones."'), 1, now(), '".$del."', '".$del."') ";
            //echo $sql1.'<br>';
            if ($Vivienda->query($sql1) == TRUE){   
                
                $signum = siguienteNumHistorialEscritura($op[$i]);

                $sql2 = "INSERT INTO historialmovescrituras
                (NumEscritura,IdConsecutivo,Estatus,IdDelegacion,IdPrograma,idlote,FechaEmision,MontoEscrituracion,Plazos,AtendidoPor,Cancelado
                ,Enviar,FechaCaptura,FechaEnvio,FechaUltimaMod,IdEmpModifica,Persona1,Persona2,NomDirectorTecnico,ResponsableTecnico,NomDirectorFinanzas
                ,ResponsableFinanzas,AprobadoPor,Observaciones,aprobDel,aprobTec,aprobFin,aprobJur,Doc_OK,EscImp,CerNot,FirmasInt,FirmasDirJur,FirmasDirGral,SelloNot
                ,IRPP,EscEnt,paqEnv ,FechaImpresion ,FechaEntrega,RF,PersonaRecibe ,NumElectorRecibe,TipoSolicitud,FechaInsert ,FechaReinicioESC ,Gestor,NomDirJuridico
                ,PersonalidadJuridica,OrigenDeEnvio ,MotivoDeCancelacion,FechaDeCancelacion ,NumEmpCancelo ,SecuenciaDeCancelacion,TipoCancelacion)
                SELECT  NumEscritura,'".$signum."','A',IdDelegacion ,IdPrograma,idlote,FechaEmision,MontoEscrituracion,Plazos,AtendidoPor,Cancelado,Enviar
                ,FechaCaptura,FechaEnvio,FechaUltimaMod,IdEmpModifica,Persona1,Persona2,NomDirectorTecnico,ResponsableTecnico,NomDirectorFinanzas,ResponsableFinanzas,AprobadoPor
                ,Observaciones,aprobDel,aprobTec,aprobFin,aprobJur,Doc_OK,EscImp,CerNot,FirmasInt,FirmasDirJur,FirmasDirGral,SelloNot,IRPP,EscEnt,paqEnv,FechaImpresion
                ,FechaEntrega,RF,PersonaRecibe,NumElectorRecibe,TipoSolicitud, now(),FechaReinicioESC,Gestor,NomDirJuridico,PersonalidadJuridica,OrigenDeEnvio,MotivoDeCancelacion
                ,FechaDeCancelacion,NumEmpCancelo,SecuenciaDeCancelacion,TipoCancelacion FROM movescrituras WHERE  movescrituras.NumEscritura= '".$op[$i]."' and movescrituras.Cancelado=0";

               // echo $sql2.'<br>';
                if ($Vivienda->query($sql2) == TRUE){   
                    mensaje('Se registro el paquete de documentos a enviar', 'e006.php' );
                }else{
                    $res = 'FALSE';
                }

            }else{
                $res = 'FALSE';
            }
        }
        else
        {
            $res = 'FALSE'; 
        }
       }
    }

    if($res == 'FALSE'){
        mensaje('ERROR: ocurrio un error, favor de intentarlo nuevamente.', 'e006.php' );

    }

}

//si es recepcion 
if(isset($_POST['numoficio'])){
    echo 'entro recepcion';

    $accion = $_POST['accion'];
    $seleccion = $_POST['seleccion'];
    $op = $_POST['opcion'];

    $direccion=quienEsmiDireccion(nitavu_dpto($nitavu));   
    $paso = ObtenerPaso($direccion,$accion);
    $llenos= ObtenerQueCamposDeberiaEstarLlenos($paso,$op);


    $sql = 'SELECT " 1" as elegido, movescrituras.NumEscritura, delegaciones.Delegacion,municipios.Municipio, catcolonia.NOMBRE_OFICIAL as Colonia, REPLACE(lotes.manzana, @ ," ") AS Manzana, lotes.Lote,CONCAT ( if(ISNULL(solicitantes.Nombre), "", solicitantes.Nombre), " ",
    if(ISNULL(solicitantes.Paterno), " " ,solicitantes.Paterno), " ", if(isnull(solicitantes.Materno)," ",solicitantes.Materno)) AS Persona, if(ISNULL(lotes.seccion),lotes.seccion,"0")as seccion, if(ISNULL( lotes.Fila),lotes.Fila,"0") as Fila , municipios.Municipio , contratos.NumContrato,catcolonia.Colonia, catcolonia.NOMBRE_OFICIAL 
    FROM solicitudes INNER JOIN  contratos ON solicitudes.IdDelegacion = contratos.IdDelegacion 
    AND solicitudes.IdPrograma = contratos.IdPrograma    AND solicitudes.Folio = contratos.Folio  
    INNER JOIN   solicitantes ON solicitudes.IdSolicitante = solicitantes.IdSolicitante
    INNER JOIN delegaciones ON solicitudes.IdDelegacion = delegaciones.IdDelegacion
    AND contratos.IdDelegacion = delegaciones.IdDelegacion        
    INNER JOIN   lotes ON  contratos.IdLote = lotes.idLote AND contratos.NumContrato = lotes.NumContrato 
    INNER JOIN movescrituras ON lotes.idLote = movescrituras.idlote and lotes.NumEscritura=movescrituras.NumEscritura  and contratos.idlote=movescrituras.idlote   
    INNER JOIN catcolonia   ON lotes.IdMunicipio = catcolonia.IdMunicipio AND lotes.IdColonia = catcolonia.IdColonia
    INNER JOIN municipios ON catcolonia.IdMunicipio = municipios.IdMunicipio';

    $sql = $sql . ' WHERE '.$llenos;



    echo "<div id='Lista' style='background-color:#EEEEEE; width:95%; display:inline-block;
    border-radius:5px; padding:10px; margin-top:20px;'>";
    echo "<h2>".strtoupper ("Lista de escrituras para ".$accion)."</h2>";
    TablaDinamica_MySQLVivienda("",$sql, "EscriturasDiv", "TablaEscrituras", "", 2); 

}
 
}
else 
{
    mensaje("No tiene acceso a esta aplicacion",'');
}

?>
<script type="text/javascript">

var operacion="";


	
$(document).ready(function(){


    if($("#enviodeescrituras").is(':checked')) 
    {  
            document.getElementById("enviodeescrituras").checked = true;
            document.getElementById("recepciondeescrituras").checked = false;
            $("#envio").css({'display':'inline-block'});
            $("#recepcion").css({'display':'none'}); 
          
     } else 
    {  
            document.getElementById("recepciondeescrituras").checked = true;
            document.getElementById("enviodeescrituras").checked = false;
            $("#recepcion").css({'display':'inline-block'});
            $("#envio").css({'display':'none'});
            
    }  

   
       
   
});
// ******************************************************************** */
function checkRadio(id) {

      
    $("#contenidoenvios").css({'display':'none'});
    if(id == "enviodeescrituras"){
      
        document.getElementById("enviodeescrituras").checked = true;
        document.getElementById("recepciondeescrituras").checked = false;
        $("#envio").css({'display':'inline-block'});
        $("#recepcion").css({'display':'none'});       
        $('#recepcion').val('');

    } else if (id == "recepciondeescrituras"){        
      
        document.getElementById("recepciondeescrituras").checked = true;
        document.getElementById("enviodeescrituras").checked = false;
        $("#recepcion").css({'display':'inline-block'});
        $("#envio").css({'display':'none'});
        $('#envio').val('0');
       
    }

}

 
/*MOSTRAR/OCULTAR TABLA DE TRAMITES LISTOS PARA IMPRIMIR */
//, direccion, paso, llenos
  function mostrarinfo(idaccion)
  {       
        //console.log('Buscando  lotes con IdMunicipio ' +m+' IdColonia ' + idColonia + ' Seccion '+seccion+' Fila '+fila+' Manzana '+ manzana+' Lote '+lote );
      op=  $('input[name=opciones]:checked', '#myformopciones').val();

    var  combo="";
    selected="";
    console.log(op);
//, direccion : direccion, paso: paso, llenos: llenos
    if(op=="enviar"){
        //alert("entro enviar");
    /* Para obtener el texto */
        combo = document.getElementById("envio");
        //selected = combo.options[combo.selectedIndex].text;
        selected = $('#envio').val();
        console.log(selected);
    }else{
        //alert("entro recepecion");
        combo = document.getElementById("recepcion");
        //selected = combo.options[combo.selectedIndex].text;
        selected = $('#recepcion').val();
        console.log(selected);
    }
    

        $("#preloader_col").show();
        $.ajax({
            url: "e006_bd.php",
            type: "post",        
            data: {nitavu: <?php echo $nitavu; ?>,Accion: idaccion, Opcion:op,Selected:selected},
            success: function(data){
                console.log(data);
                //alert(data);
                $("#contendidoenvios").css({'display':'inline-block'});
                $('#contendidoenvios').html(data+"\n");
                $("#preloader_col").hide();
            }
        });
 
  
  
  }
  
  


</script>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>
