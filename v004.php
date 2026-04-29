<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>
<?php
require("config.php");
$id_aplicacion = 'ap106';
xd_update('ap106',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
historia ($nitavu,"Entre a la aplicacion de Evaluacion");

echo "<input type='hidden' id='nitavu' name='nitavu' value='".$nitavu."'>";

//DATOS PARA NO APROBAR EL CREDITO
if(isset($_POST['_guardar'])){
    $FolioTramite = $_POST['FolioTramite'];
    $IdPrograma = $_POST['IdPrograma'];
    $IdDelegacion = $_POST['IdDelegacion'];
    $Folio = $_POST['Folio'];
    $Observaciones = $_POST['observacion'];

    $sql = "UPDATE datosevaluacion SET Aprobado = 0, CausasInaprob = '".$Observaciones."', FechaEvaluacion = '".$fecha."', FechaUltimaMod='".$fecha."', 
    IdEmpEvaluador='".$nitavu."', IdEmpModifica='".$nitavu."' WHERE IdPrograma = ".$IdPrograma." and IdDelegacion = ".$IdDelegacion." and Folio = ".$Folio."";
    if($Vivienda->query($sql) == TRUE){
        historia ($nitavu,"Desaprobe la evaluación de la solicitud: ".$FolioTramite." con IdPrograma:".$IdPrograma.", IdDelegacion: ".$IdDelegacion.", Folio:".$Folio."");
        $sql = "UPDATE solicitudestemp SET Estado = 4 WHERE IdSolicitud = ".$FolioTramite."";
        if($conexion->query($sql) == TRUE){
            historia ($nitavu,"Cambie el estatus a 4 de la solicitud: ".$FolioTramite." con IdPrograma:".$IdPrograma.", IdDelegacion: ".$IdDelegacion.", Folio:".$Folio."");
            echo "<script>NPush('Se desaprobo la solicitud con éxito.','Plataforma ITAVU');</script>";
        }else{
            historia ($nitavu,"Error al cambiar el estatus a 4 de la solicitud: ".$FolioTramite." con IdPrograma:".$IdPrograma.", IdDelegacion: ".$IdDelegacion.", Folio:".$Folio."");
            echo "<script>NPush('Error al desaprobar la solicitud, intentelo de nuevo.','Plataforma ITAVU');</script>";
        }
    }else{
        historia ($nitavu,"Error al desaprobar la solicitud: ".$FolioTramite." con IdPrograma:".$IdPrograma.", IdDelegacion: ".$IdDelegacion.", Folio:".$Folio."");
        echo "<script>NPush('Error al desaprobar la solicitud, intentelo de nuevo.','Plataforma ITAVU');</script>";
    }

}


echo "<div id='req_menu'>"; 
    echo "<a href='#busquedaporNombre' rel='MyModal:open' class='btn-g2' title='Busqueda por nombre' style='font-family: Compacta;'>";
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
echo "</div>";


echo "<div>";
        //NitavuCaptura = '.$nitavu.' and
    $sql = 'Select * from solicitudestemp WHERE Estado = 1 and Eliminado = 0';
    //echo $sql;
    $r = $conexion -> query($sql);
    if ($r -> num_rows >0){
        echo "<br>";
        echo "<h2>Pendientes por Evaluar</h2>";
        echo "<center>";
        echo "<table class='tabla' style='width:80%;'>";
        echo "<th>ID</th>";
        echo "<th>DESCRIPCIÓN</th>";
        echo "<th>APROBAR</th>";
        
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
                        echo "<br><span>Programa: ".$f['IdPrograma']."-".NombrePrograma($f['IdPrograma'])."     Delegación: ".$f['IdDelegacion']."-".nombreDelegacionVivienda($f['IdDelegacion'])." Folio Vivienda ".$f['FolioVivienda']."</span>";
                        echo "<br><label style='font-size:7pt; margin:0px; padding:0px;'>Capturado por ".nitavu_nombre($f['NitavuCaptura'])." - ".$f['Fecha']." : ".$f['Hora']." en ".DptoNombre($f['DptoCaptura'])." </label>";

                    echo "</div>";
                echo "</td>";
                echo "<td align='center'>";
                
               /*echo '<form action="v004_iniciar.php" method="POST">';
                echo "<input type='hidden' name='_id' id='_id' value=".$f['IdSolicitud'].">";
                echo "<input type='hidden' name='programa' id='programa' value=".$f['IdPrograma'].">";
                echo "<input type='hidden' name='delegacion' id='delegacion' value=".$f['IdDelegacion'].">";
                echo "<input type='hidden' name='folio' id='folio' value=".$f['FolioVivienda'].">";*/
                echo "<button id='editar' name='ediar' class='Mbtn btn-default' onclick='traerCorridaFinanciera(".$f['IdSolicitud'].",".$f['IdPrograma'].",".$f['IdDelegacion'].",".$f['FolioVivienda'].");'><img src='icon/btn_derecha.png' style='width:15px; height:15px;'></button>";
                
              //  echo "</form>";
                echo "</td>";
            echo "</tr>";
          
        }
        echo "</table>";

    
    
        
    
            echo "</center>";
    } else {
        echo "<div>";
        echo "<br>";
            echo '<span style="font-family:verdana; font-size:14pt; color: #D4D9DA;">No hay pendientes que mostrar...</span>';
        echo "</div>";
    }
echo "</div>";

 //--------------------buscar por nombre
 echo "<div id='busquedaporNombre' class='MyModal' style='width:100%;'>";

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
 echo "</center>";
echo "</div>";


   //buscar por folio
echo "<div id='busquedaFolio' class='MyModal' style='height:200px;'>";
   echo "<form action='v004_iniciar.php' method='GET'>";
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

               $sql = "SELECT * FROM programa ORDER by Programa ASC";
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

}else{
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}

?>
<script>
function buscarBeneficiarios(){
    //alert('entre');
    var nom = document.getElementById("nom").value;
    var apaterno = document.getElementById("apaterno").value;
    var amaterno = document.getElementById("amaterno").value;
    var link = 'v004_iniciar.php';
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
function traerCorridaFinanciera(FolioTramite, IdPrograma, IdDelegacion, FolioVivienda){
    //alert('entro');
    $("#preloader").css({'display':'inline-block'});
   var nitavu =  document.getElementById("nitavu").value;
    $.ajax({
        url: "v004_corridaFinanciera.php",
        type: "post",        
        data: {FolioTramite: FolioTramite, nitavu:nitavu, IdPrograma: IdPrograma, IdDelegacion: IdDelegacion, FolioVivienda: FolioVivienda},
        success: function(data){  
            $("#preloader").css({'display':'none'}); 
            console.log(data);
            if(data.includes('No existe corrida financiera para este programa')==true){
                NPush(data + '. Es necesario solicitar el registro al departamento correspondiente.','Plataforma ITAVU');
            }else{
                NPush(data,'Plataforma ITAVU');
                window.location='v004_iniciar.php?_id='+FolioTramite+'&IdPrograma='+IdPrograma+'&IdDelegacion='+IdDelegacion+'&Folio='+FolioVivienda;
            }
        }
    });
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