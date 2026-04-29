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
$nivel=1;

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    if (isset($_GET['IdPrograma'])){
        $IdPrograma = VarClean($_GET['IdPrograma']);
        if (Vivienda_ProgramaExiste($IdPrograma)==TRUE){            
            if (Vivienda_ProgramaActivo($IdPrograma)==TRUE){
                echo "<div id='AppDetalle' 
                style='background-color:green;'
                >".app_detalle($id_aplicacion, $nitavu).
                "</div>";
                echo "<h1
                style='
                font-size: 9pt;
                margin-top: -10px;
                background-color: rgba(0,0,0,0.5);
                padding: 10px;
                position: fixed;
                width: 100%;
                '
                >Perfil del Programa <b style='color:white;'>".Vivienda_ProgramaNombre($IdPrograma)."</b>(Activo)</h1>";





            }  else {mensaje("ERROR: Este programa se encuentra inactivo",'programas.php');}

        } else {mensaje("ERROR: Programa no existe",'programas.php');}
    
    } else {mensaje("ERROR parametros incorrectos",'programas.php');}


}
else {mensaje("No tiene permiso para ver esta aplicacion",'');}	 


?>



<script>


function ShowSelected(){
        //alert ('entro');
        var valor = document.getElementById("tipoprograma").value;
        
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


        /* if(valor==1)
        {  
                 alert(valor);       
                $("#material").css({'display':'inline-block'});
                $("#lotes").css({'display':'none'});
               // $("#edificacion").css({'display':'none'});        
        }
        else {
                if (valor==2){
                alert(valor);
                $("#material").css({'display':'none'});
                $("#lotes").css({'display':'inline-block'});  
               // $("#edificacion").css({'display':'inline-block'});      
                }
        } */
}

$(document).ready(function() {

$('[name="paquetematerial[]"]').click(function() {
    
  var arr = $('[name="paquetematerial[]"]:checked').map(function(){
    return this.value;
  }).get();
  
  var str = arr.join(',');
  
  //$('#arr').text(JSON.stringify(arr));
  
  //$('#arr').text(str);
  $('#arr').val(str);

});

});
function GuardaModPrograma(IdPrograma){
    Programa=$('#Programa').val();
    ProgramaGral=$('#ProgramaGral').val();
    Ejercicio=$('#Ejercicio').val();
    FechaCaptura=$('#FechaCaptura').val();
    IdTipoPrograma=$('#IdTipoPrograma').val();
    Descripcion=$('#Descripcion').val();
    DiasdePago=$('#DiasdePago').val();
    Subsidiado=$('#Subsidiado').val();
    TipoImpVale=$('#TipoImpVale').val();
    IdTipoTramite=$('#IdTipoTramite').val();
    Informacion1=$('#Informacion1').val();
    Informacion2=$('#Informacion2').val();
    Activo=$('#Activo').val();
    ListaIdPaqueteMat=$('#arr').val();  
    TipoAsignacion=$('#TipoAsignacion').val();  
  
  alert(ListaIdPaqueteMat);
    //console.log(IdTipoPrograma);

    //console.log(IdPrograma);
    $('#preloader').show();
				$.ajax({
					url: 'data_programas.php',
                                        type: 'post',			
                                        data: {IdPrograma: IdPrograma, Programa:Programa, ProgramaGral:ProgramaGral,
                                                FechaCaptura:FechaCaptura,        
                                                Ejercicio:Ejercicio, IdTipoPrograma:IdTipoPrograma,Descripcion:Descripcion,
                                                DiasdePago:DiasdePago,Subsidiado:Subsidiado,IdTipoTramite:IdTipoTramite,
                                                Informacion1:Informacion1,Informacion2:Informacion2,
	                                        TipoImpVale:TipoImpVale,Activo:Activo,ListaIdPaqueteMat:ListaIdPaqueteMat,TipoAsignacion:TipoAsignacion},
					success: function(data){
					$('#resultado').html(data);
					$('#preloader').hide();
					}
				});
				

}

/* function GuardaPrograma(){
        alert ('entro guarda programa xxx');
                var selected = '';    
                //$('#formid input[type=checkbox]').each(function(){
                $('#formid input[type=checkbox]').each(function(){
                        
                        if (this.checked) {
                                selected += $(this).val()+', ';
                        }
                        }); 

                        if (selected != '') 
                        alert('Has seleccionado: '+selected);  
                        else
                        alert('Debes seleccionar al menos una opción.');

                        return false; 
                      });         
} */

function Check(){   
   
   $("#preloader").show();

   $("#Pase_"+IdPase).css({'display':'none','color':'gray'});
   $.ajax({
           url: "auscencia_temporal_autoriza_ok.php",
      type: "post",
   //    data: "id="+IdPase, "nitavu=" + Nitavu
      data: {id: IdPase, nitavu: Nitavu },
      success: function(data){
           
           $('#R').html(data+"\n");
           $("#preloader").hide();
   
      }
   });
   
}

function ProgramasData(){   
      //  console.log('Hola');        
        var Len = $("#txtPrograma").val().length;    
        var txtBeneficiaro = $("#txtPrograma").val();

        var nitavu = "<?php echo $nitavu;?>";
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

}


</script>






<!-- Hacer algo de espacio para testear -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>