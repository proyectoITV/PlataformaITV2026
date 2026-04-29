<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
?>
<?php
$id_aplicacion ="ap107"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos
//Niveles
// 1 = Crear y Editar
// 2 = Consulta

//Ajusta esta variable para ver el comportamiento
$nivel=2;

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
         if (isset($_POST['botonguarda'])){
                /* if (isset($_POST['ListaIdPaqueteMat'])){
                        echo "la lista es".$_POST['ListaIdPaqueteMat'];
                }else{
                        echo "no esta declarada";
                } */                        
                $Programa = filter_var($_POST['Programa'],FILTER_SANITIZE_STRING);                                 
                //$Programa = $_POST['Programa']; if (ValidaVAR($Programa)==TRUE){$Programa = LimpiarVAR($Programa);} else {$Programa = "";}
                revisavacio($Programa,'programas_alta.php','Programa');               
                $ProgramaGral = filter_var($_POST['ProgramaGral'],FILTER_SANITIZE_STRING); 
                revisavacio($ProgramaGral,'programas_alta.php','Programa General');                
                $Ejercicio = $_POST['Ejercicio']; if (ValidaVAR($Ejercicio)==TRUE){$Ejercicio = LimpiarVAR($Ejercicio);} else {$Ejercicio = "";}
                $Descripcion = $_POST['Descripcion']; if (ValidaVAR($Descripcion)==TRUE){$Descripcion = LimpiarVAR($Descripcion);} else {$Descripcion = "";}
                $DiasdePago = $_POST['DiasdePago']; if (ValidaVAR($DiasdePago)==TRUE){$DiasdePago = LimpiarVAR($DiasdePago);} else {$DiasdePago = "";}
                $Subsidiado = $_POST['Subsidiado']; if (ValidaVAR($Subsidiado)==TRUE){$Subsidiado = LimpiarVAR($Subsidiado);} else {$Subsidiado = "";}
                $TipoImpVale = $_POST['TipoImpVale']; if (ValidaVAR($TipoImpVale)==TRUE){$TipoImpVale = LimpiarVAR($TipoImpVale);} else {$TipoImpVale = "";}
                $IdTipoTramite = $_POST['IdTipoTramite']; if (ValidaVAR($IdTipoTramite)==TRUE){$IdTipoTramite = LimpiarVAR($IdTipoTramite);} else {$IdTipoTramite = "";}
                $IdTipoPrograma = $_POST['IdTipoPrograma']; if (ValidaVAR($IdTipoPrograma)==TRUE){$IdTipoPrograma = LimpiarVAR($IdTipoPrograma);} else {$IdTipoPrograma = "";}
                $Informacion1 = $_POST['Informacion1']; if (ValidaVAR($Informacion1)==TRUE){$Informacion1 = LimpiarVAR($Informacion1);} else {$Informacion1 = "";}
                $Informacion2 = $_POST['Informacion2']; if (ValidaVAR($Informacion2)==TRUE){$Informacion2 = LimpiarVAR($Informacion2);} else {$Informacion2 = "";}
                $Activo = $_POST['Activo']; if (ValidaVAR($Activo)==TRUE){$Activo = LimpiarVAR($Activo);} else {$Activo = "";}        
                $ListaIdPaqueteMat=$_POST['ListaIdPaqueteMat'];if (ValidaVAR($ListaIdPaqueteMat)==TRUE){$ListaIdPaqueteMat = LimpiarVAR($ListaIdPaqueteMat);} else {$ListaIdPaqueteMat = "";}                   
                $TipoAsignacion=$_POST['TipoAsignacion'];if (ValidaVAR($TipoAsignacion)==TRUE){$TipoAsignacion = LimpiarVAR($TipoAsignacion);} else {$TipoAsignacion = "";}                   
                $AreaAplicacion=$_POST['AreaAplicacion'];if (ValidaVAR($AreaAplicacion)==TRUE){$AreaAplicacion = LimpiarVAR($AreaAplicacion);} else {$AreaAplicacion = "";}                   
                if ($TipoAsignacion==0 ){
                        $CargosIniciales=1;
                }else{
                        $CargosIniciales=0;
                }

                $IdPrograman=IdNuevo('programa','IdPrograma');
                $idTipoMov = $_POST['idTipoMov']; if (ValidaVAR($idTipoMov)==TRUE){$idTipoMov = LimpiarVAR($idTipoMov);} else {$idTipoMov = 0;}
               // ECHO "El programa es ".$IdPrograman;
                //echo "lista".$ListaIdPaqueteMat;
                $sql2=" INSERT INTO programa(IdPrograma, Programa, ProgramaGral,Ejercicio, IdTipoPrograma,
			Descripcion, DiasdePago, Subsidiado,TipoImpVale,IdTipoTramite,
			Informacion1, Informacion2,Activo,ListaIdPaqueteMat,TipoAsignacion,ConceptoParaPago,CargosIniciales,AreaAplicacion,								
			FechaCaptura,IdEmpCrea) 
			VALUES(".IdNuevo('programa','IdPrograma').",'".$Programa."','".$ProgramaGral."',".$Ejercicio.","										
				.$IdTipoPrograma.",'".$Descripcion."',".$DiasdePago.",".$Subsidiado.","
				.$TipoImpVale.",".$IdTipoTramite.",'".$Informacion1."','".$Informacion2."',".$Activo.",'".$ListaIdPaqueteMat."',".$TipoAsignacion.",".$idTipoMov.",".$CargosIniciales. ",'".$AreaAplicacion."','"
                                .$fecha."' ,".$nitavu." )";
                                                        echo $sql2;
                $resultado2 = $Vivienda -> query($sql2); 

                if ($TipoAsignacion==0 ) {                                                
                        mensaje('Registrado con éxito','programas_alta2.php?Id='.$IdPrograman);                        
                        //mensaje('Registrado con éxito','programas_alta2.php?Id='.$IdPrograman.'&Pgr='.$ProgramaGral.'&TA='.$TipoAsignacion);                        
                }elseif($TipoAsignacion==1 ){
                        mensaje('Registrado con éxito, finalizó la alta del programa','programas_alta.php');
                }elseif($TipoAsignacion==2 ){
                        mensaje('Registrado con éxito','programas_alta2.php?Id='.$IdPrograman);
                }else{
                        return 0;
                }
                //mensaje('Regrese','');       
         }else{
                //DIV para Programas Nuevos
        //class='MyModal'        

        echo "<div id='ProgramaNuevo' >";
        echo "<h1>Crear un Programa Nuevo</h1>";
        echo "<form action='programas_alta.php' method='POST' style='width: 70%; padding: 15px;'>";
        echo "<section> ";
        //echo "<form action='data_programas.php' method='POST'>";
        echo "<input type='hidden' name='NuevoProg'>";
            echo "<div id:'tipocredito1'><label>Tipo de programa</label>";
            echo "<select name='IdTipoPrograma' class='custom-select' id='IdTipoPrograma' onchange='ShowSelected();'>";            
            $sql = "SELECT * FROM cattipoprograma  ORDER by IdTipoPrograma ASC";
            $v = $Vivienda -> query($sql);
            while($vv = $v -> fetch_array())
            { // resultado de la busqueda.................
                    echo "<option value='".$vv['IdTipoPrograma']."' >".$vv['TipoPrograma']. "</option>";
            }
            //  echo "<option value='".$f['IdTipoPrograma']."' selected>".buscaidconcepto('TipoPrograma', 'cattipoprograma','IdTipoPrograma', $f['IdTipoPrograma'] ? $f['IdTipoPrograma']  : '0' )."</option>";
            echo "</select>  ";         
            echo "</div>";  

             echo "<div><label>Año de presupuesto</label><input type='number' name='Ejercicio' min='1995' max='2030' value='2020' ></div>";
            echo "<div><label>Nombre oficial del programa</label><input type='text' name='ProgramaGral' style='text-transform:uppercase;' onkeyup='javascript:this.value=this.value.toUpperCase();'></div>";
            echo "<div width:100%><label>Nombre del subprograma</label><input type='text' name='Programa'   style='text-transform:uppercase;' onkeyup='javascript:this.value=this.value.toUpperCase();' ></div>";
            echo "<div><label>Dias de vencimiento</label><select name='DiasdePago' class='custom-select' id='' ><option value='30'>Dias últimos</option><option value='15'>Dias quince</option></select></div> ";    
            echo "<div><label>Estatus del programa</label><select name='Activo' class='custom-select' id='' ><option value='1'>Activo</option><option value='2'>Inactivo</option></select></div> ";    
            echo "<div><label>Subsidiado al 100%:</label><select name='Subsidiado' id='Subsidiado' class='custom-select'  >
                    <option value='1'>Si</option>
                    <option value='0'>No</option></select></div>";                     
                        
            echo " <div><label>Tipo de trámite, define la evaluación:</label> ";
            echo "<select name='IdTipoTramite' id='IdTipoTramite' class='custom-select'>";
            $sql = "SELECT * FROM cattipotramite where IdTipoTramite in (1,2,3,4,5) ORDER by IdTipoTramite ASC";
            $v = $Vivienda -> query($sql);
            while($vv = $v -> fetch_array())
            { // resultado de la busqueda.................
                echo "<option value='".$vv['IdTipoTramite']."' >".$vv['TipoTramite']. "</option>";
            }
                //echo "<option value='".$f['IdTipoTramite']."' selected>".buscaidconcepto('TipoTramite', 'cattipotramite','IdTipoTramite', $f['IdTipoTramite'] ? $f['IdTipoTramite']  : '0' )."</option>";
            echo "</select></div>";        

            echo "<div><label>Tipo de Asignación:</label><select name='TipoAsignacion' Id='TipoAsignacion' class='custom-select'>";
            echo "<option value='0' >Asignación Directa</option>";
            echo "<option value='1' >Asignación Abierta</option>";
            echo "<option value='2' >Asignación Semi-Directa</option>";
            echo "</select></div>";    

            echo " <div><label>Concepto de pago:</label> ";
            echo "<select name='idTipoMov' id='idTipoMov' class='custom-select'>";
            $sql = "SELECT * FROM descripcionmovimiento where IdTipoCuenta=3  ORDER by DescripcionMovimiento ASC";
            $v = $Vivienda -> query($sql);
            while($vv = $v -> fetch_array())
            { // resultado de la busqueda.................
                echo "<option value='".$vv['idTipoMov']."' >".$vv['DescripcionMovimiento']. "</option>";
            }                
            echo "</select></div>"; 

            echo "<div><label>Observación 1:</label><input type='text'  name='Informacion1' class='form-control' value=''></div>";    
            echo "<div><label>Observación 2:</label><input type='text' name='Informacion2' class='form-control' value=''></div>";                        
            echo "<div><label>Breve descripción del programa</label><textarea name='Descripcion' class='form-control' id='Descripcion' rows='3' style='resize:none' placeholder='Escriba una breve explicación del programa' maxlength='300' ></textarea></div>";            
            
            // si es paquete de material  "<input type='text'  name='uno' placeholder='material' >";<input type='text'  name='uno' placeholder='material' >";

             echo "<div id='material' name='material' style='display:none; width:100%;'>";
            
            
                    echo "<div><label>Tipo de vale:</label>";
                                echo "<select name='TipoImpVale' class='custom-select' id='TipoImpVale' >";
                                    $sql = "SELECT * FROM cattipovale  ORDER by Id ASC";
                                    $v = $Vivienda -> query($sql);
                                    while($vv = $v -> fetch_array())
                                    { // resultado de la busqueda.................
                                        echo "<option value='".$vv['Id']."' >".$vv['TipoVale']. "</option>";
                                    }
                                        // echo "<option value='".$f['TipoImpVale']."' selected>".buscaidconcepto('TipoVale', 'cattipovale','Id', $f['TipoImpVale'] ? $f['TipoImpVale']  : '3' )."</option>";                                   
                                echo "</select>  ";    
                    echo "</div>";

                    echo "<div><label>Area de aplicación de los paquetes:</label><select name='AreaAplicacion' Id='AreaAplicacion' class='custom-select'>";
                        echo "<option value='T' >Igual para todas las delegaciones</option>";
                        echo "<option value='D' >Aplicación por Delegación</option>";
                         echo "<option value='M' >Aplicación por municipio</option>";
                    echo "</select></div>";                    

                    echo "<div class='accordionProg' id='accordionExample' >";
                    //echo "<div class='accordionProg' id='accordionExample' style='color:#000000 background-color:white;  '>";
                            echo "<div class='card'>";
                                    echo "<div class='card-header' id='headingOne'>";
                                            echo "<h2 >";
                                            //class='mb-0'
                                            //echo "<button class='btn btn-link btn-block text-left collapsed'  type='button' data-toggle='collapse' data-target='#collapseOne' aria-expanded='false' aria-controls='collapseOne' >";
                                            echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">';
                                            //style='  writing-mode: horizontal-tb; color:red;'
                                            echo "Seleccione el paquete de material para este programa";
                                            echo "</button>";
                                            echo "</h2>";
                                    echo "</div>";
                                    echo "<div id='collapseOne' class='collapse' aria-labelledby='headingOne' data-parent='#accordionExample' style:'text-align: initial;' >";
                                            //style=' transform: rotate(120deg);'
                                            echo "<div class='card-body'>";                        
                                                    echo "<div class='container' >";
                                                            echo "<div class='row row-cols-3'   >";                                                        
                                                                    $sql = "SELECT * FROM paquetematerial  ORDER by IdPaqueteMaterial ASC";
                                                                    $v = $Vivienda -> query($sql);                                                                
                                                                    while($vv = $v -> fetch_array())
                                                                    { 
                                                                    echo "<div class='col'   ><input type='checkbox' class='form-check-input'   name='paquetematerial1[]' id='paquetematerial1[]' value='".$vv['IdPaqueteMaterial']."'>".$vv['PaqueteMaterial']."</div>";
                                                                    //style=' transform: rotate(120deg);' style=' color:red;'style='position: absolute;'
                                                                    }
                                                            echo "</div>";
                                                    echo "</div> ";                          
                                            echo "</div>";
                                              
                                    echo "</div>";
                            echo "</div> "; 
                           
                           //echo " <div >Ids seleccionados <span id='str' name='str'></span></div>";  
                            echo "<div ><input type='hidden'  id='ListaIdPaqueteMat' name='ListaIdPaqueteMat' ></div>";
                    echo "</div>";
            echo "</div>";         
            
           /*  echo "<div id='lotes' name='lotes' style='display:none; width:100%;'><input type='text' name='uno' placeholder='lotes' ></div>";
            echo "<div id='edificacion' name='material' style='display:none; width:100%;'><input type='text' name='uno' placeholder='edificacion' ></div>";
            echo "<div id='lotevivienda' name='lotes' style='display:none; width:100%;'><input type='text' name='uno' placeholder='lotevivienda' ></div>";
            echo  "<div id='vivusada' name='material' style='display:none; width:100%;'><input type='text' name='uno' placeholder='vivusada' ></div>";*/

            //echo "<span><label>Verifique los datos</label><input type='submit' value='Guardar' name='GuardarPrograma' class='Mbtn btn-Primary'></span>";
            //echo "<span><button  class='btn btn-primary btn-lg'>Guardar</button></span>";
            echo "<span><button name='botonguarda'  class='btn btn-primary btn-lg'>Guardar</button></span>";
            //onclick='GuardaPrograma();'
        echo "</section>";  
        echo "</form>";
        echo "</div>";
         }
         
         
}
else {mensaje("No tiene permiso para ver esta aplicacion",'');}	 

?>



<script>


function ShowSelected(){
       //alert ('entro');
       // var valor = document.getElementById("tipocredito").value;
         var valor = document.getElementById("IdTipoPrograma").value;
        
        switch (valor) {
                case '1':
                        $("#material").css({'display':'inline-block'});
                        $("#lotes").css({'display':'none'});
                        $("#edificacion").css({'display':'none'});
                        $("#lotevivienda").css({'display':'none'});
                        $("#vivusada").css({'display':'none'});
                        break;
                case '2':
                        $("#material").css({'display':'none'});
                        $("#lotes").css({'display':'inline-block'});
                        $("#edificacion").css({'display':'none'});
                        $("#lotevivienda").css({'display':'none'});
                        $("#vivusada").css({'display':'none'});
                        break;        
                case '3':
                        $("#material").css({'display':'none'});
                        $("#lotes").css({'display':'none'});
                        $("#edificacion").css({'display':'inline-block'});
                        $("#lotevivienda").css({'display':'none'});
                        $("#vivusada").css({'display':'none'});
                        break;
                case '4':
                        $("#material").css({'display':'none'});
                        $("#lotes").css({'display':'none'});
                        $("#edificacion").css({'display':'none'});
                        $("#lotevivienda").css({'display':'inline-block'});
                        $("#vivusada").css({'display':'none'});
                        break;                
                case '5':
                        $("#material").css({'display':'none'});
                        $("#lotes").css({'display':'none'});
                        $("#edificacion").css({'display':'none'});
                        $("#lotevivienda").css({'display':'none'});
                        $("#vivusada").css({'display':'inline-block'});        
                default:
                        break;
        }
 
}

$(document).ready(function() {

$('[name="paquetematerial1[]"]').click(function() {
    
  var arr = $('[name="paquetematerial1[]"]:checked').map(function(){
    return this.value;
  }).get();
  
  var str = arr.join(',');
  
  $('#ListaIdPaqueteMat').text(JSON.stringify(arr));
  
  $('#ListaIdPaqueteMat').text(str);
  
  $('#ListaIdPaqueteMat').val(str);
  localStorage.setItem('lista', str);
 // var listilla=$('#ListaIdPaqueteMat').val(str);
  console.log('str:'+str);
 
 //$('#str').text(str);
  

});

});



/* function GuardaPrograma(){
        alert ('entro guarda programa');
    Programa=$('#Programa').val();
    ProgramaGral=$('#ProgramaGral').val();
    Ejercicio=$('#Ejercicio').val();
    //FechaCaptura=$('#FechaCaptura').val();
    IdTipoPrograma=$('#IdTipoPrograma').val();
    Descripcion=$('#Descripcion').val();
    DiasdePago=$('#DiasdePago').val();
    Subsidiado=$('#Subsidiado').val();
    TipoImpVale=$('#TipoImpVale').val();
    IdTipoTramite=$('#IdTipoTramite').val();
    Informacion1=$('#Informacion1').val();
    Informacion2=$('#Informacion2').val();
    Activo=$('#Activo').val();
    //console.log(IdTipoPrograma);
    alert ('llego hasta aqui 1');
    //console.log(IdPrograma);
    $('#preloader').show();
				$.ajax({
					url: 'data_programas.php',
                                        type: 'post',			
                                        data: { Programa:Programa, ProgramaGral:ProgramaGral,
                                                Ejercicio:Ejercicio, IdTipoPrograma:IdTipoPrograma,Descripcion:Descripcion,
                                                DiasdePago:DiasdePago,Subsidiado:Subsidiado,IdTipoTramite:IdTipoTramite,
                                                Informacion1:Informacion1,Informacion2:Informacion2,
	                                        TipoImpVale:TipoImpVale,Activo:Activo},
					success: function(data){
					$('#resultado').html(data);
					$('#preloader').hide();
					}
				});
                alert ('llego hasta aqui 2');
} */

/* function compruebaNoVacio(){ 
    //enteroValidado = validarEntero(document.f1.numero.value) 
    enteroValidado = document.f1.numero.value 
    if (enteroValidado == ""){ 
       //si era la cadena vacía es que no era válido. Lo aviso 
       alert ("Debe escribir un dato") 
       //selecciono el texto 
       document.f1.numero.select() 
       //coloco otra vez el foco 
       document.f1.numero.focus() 
    }else 
       document.f1.numero.value = enteroValidado  
} */


/* function ProgramasData(){   
      //  console.log('Hola');        
var Len = $("#txtPrograma").val().length;    
var txtBeneficiaro = $("#txtPrograma").val();

********

if (Len >= 0){
    $("#indicaciones").html("<a href='' style='display:block;'>Iniciar nueva busqueda</a>");
    

    $("#preloader").show()
    $("#Resultado").html("");
    search = $('#txtPrograma').val();
    $.ajax({
        url: "programas_data.php",
        type: "get",   
        data: {nitavu: nitavu, search: search },
        success: function(data){
        $('#Resultado').html(data+"\n");
        $("#preloader").hide()
      }
   });
} else {
    var faltan = 10- Len;
    $.toast({
    heading: 'Warning',
    text: "Escriba <b>"+faltan+"</b> caracteres, para poder iniciar la busqueda.",
    showHideTransition: 'plain',
    icon: 'warning'
})
} 

} */

</script>






<!-- Hacer algo de espacio para testear -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>