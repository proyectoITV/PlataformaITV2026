<?php
    include ("lib/body_head.php");
    // include ("lib/body_menu.php");
    //No tiene menu vertical
?>
<script>
function BuscaContrato(){
  //alert('entro');
  var search = $('#search').val();
  var nitavu = '<?php echo $nitavu; ?>';
  var mode = 1;

  $('#BusquedaPreLoader').show();
  $.ajax({
    url: "v001_data.php",
    type: "get",
    data: {search:search, nitavu:nitavu, mode:mode},
    success: function(data){    
       // console.log(data);           
      $("#RespuestaCaja").html(data+"\n");  
      $('#BusquedaPreLoader').hide();    
          
    }
  
  });
  
 
}

function btnBuscar(){
    valor  = $('#divBusqueda').css('right');
    if (valor == '0px') {
        $('#divBusqueda').css('right','-750');
    } 
    
    if (valor == '-750px') {
        $('#divBusqueda').css('right','0');
    }
}

function Seleccion(NumContrato, OriginData, IdDelegacion, IdPrograma, Folio){
    window.location.href = window.location.href + "?NumContrato="+NumContrato+"&Folio="+Folio+"&IdPrograma="+IdPrograma+"&OriginData="+IdDelegacion; 
    btnBuscar();
}
</script>

<?php
set_time_limit(72000) ;
error_reporting(0); //<-- para simular produccion
require_once("var_clean.php");
$id_aplicacion ="ap129"; $nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
echo "<script>$('body').css('background-color','rgb(255, 255, 255)');</script>";
// echo "<script>$('body').css('background-image','url(img/wall_ayuda3.jpg)');</script>";
// echo "<script>$('body').css('background-position','top');</script>";

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";      
    // echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    
echo phpversion();
    //codigo de la busqueda
    echo "<div id='divBusqueda' style='   
    background-color: rgba(53, 170, 11, 0.53);
    padding: 11px;
    margin: 10px;
      margin-right: 10px;
    border-radius: 5px;
    margin-right: -7px;
    position:fixed;
    width:800px;
    right:-750px;
    top:40px;'>";

    echo "<table width=100% border=0><tr><td width=30px>";
    echo "<img onclick='btnBuscar();'  src='icon/txtbuscar.png' style='width:30px; cursor:pointer;'></td><td>";
    echo "<input type='hidden' id='nitavu' name='nitavu' value='".$nitavu."'>";
    echo "<div style='
    width: 100%; padding-top: 0px; padding-bottom: 13px; margin-top: 7px;'>
    <table width=100%><tr><td width=90%>";
    echo "<input style=' height: 65px; border-radius: 5px; font-size: 18pt; font-family: Light; margin-left: 12px; padding: 10px; margin-right: 20px;
    'type='text' name='search' id='search' placeholder='Ingrese nombre del beneficiario o número de contrato'>";
    echo "</td><td>
    <button type='submit' onclick='BuscaContrato();' class='Mbtn btn-primary' id='indicaciones2' style='font-size: 8pt;  height: 60px; margin-top: -3px;
    margin-left: 5px;' onclick='v001.php'> <img src='icon/buscar2.png' style='width:40px;'>
    </button></td></tr></table></td>
    </div>"; 

    echo "<tr><td></td><td>";
    
    echo "<div id='BusquedaPreLoader' style='display:none;
    background-color: #ff8f00;
    padding: 10px;
    border-radius: 4px;
    text-align: center;
    color: white;'> Buscando <img src='img/loader_bar.gif'></div>";
    echo "<div class='' id='RespuestaCaja' style='overflow: auto;
    height: 500;'></div>";

    echo "</div></td></tr></table></div>";

    if (isset($_GET['NumContrato'])){
        $NumContrato = $_GET['NumContrato'];
        $Folio = $_GET['Folio'];
        $IdPrograma = $_GET['IdPrograma'];
        $IdDelegacion = $_GET['OriginData'];
       
        /*echo $NumContrato;
        echo $Folio;
        echo $IdPrograma;
        echo $IdDelegacion;*/

        //OPCIONES DE ACCION
        echo "<center>";
        echo "<div>";
         datosBeneficiarioenFormatoCorto($IdPrograma, $IdDelegacion, $Folio, $NumContrato);
        echo "<div><br><br><br>";


        echo '<div class="card" style="text-align: justify; width:70%;">';


        echo '<h1 class="card-header h5">Registro de Búsqueda de Documentos</h1>';
        $sqltc = "SELECT idtipomov,descripcionmovimiento FROM descripcionmovimiento where idtipomov in (51) ORDER BY descripcionmovimiento";
                
           
        
       
            echo '<div class="card-body">';  
                echo "<form action='ajuste_historico7.php' method='GET'>";
                echo "<input type='hidden' name='folio' id='folio' value=".$Folio.">";
                echo "<input type='hidden' name='numcontrato' id='numcontrato' value=".$NumContrato.">";
                echo "<input type='hidden' name='programa' id='programa' value=".$IdPrograma.">";
                echo "<input type='hidden' name='delegacion' id='delegacion' value=".$IdDelegacion.">";

                echo "<center>";

                
                    echo "<br><label>Nombre del beneficiario</label>";
                    echo "<input id='nom' name='nom'>";

                    echo "<br><label>Folio y Programa</label>";
                    echo "<input id='folio' name='folio'>";
                 
                    $r2= $Vivienda -> query($sqltc);
                    echo "<label>Busqueda de documento</label>
                    <select name='cargo' id='cargo'>";
                    while($fx = $r2 -> fetch_array()) {
                        echo "<option value='".$fx['idtipomov']."'>".$fx['descripcionmovimiento']."</option>";
                    }
                    echo "</select>";
                    
                    
                    echo "<br><label>Fecha</label>";
                    echo "<input type='date' id='fecha' name='fecha' value='$fecha'>";


                    echo "<br><label>Importe</label>";
                    echo "<input id='importe' name='importe'>";

                    echo "<br><label>Núm certificado o referencia</label>";
                    echo "<input id='ref' name='ref'>";

                  

                    echo '<button type="submit" name="aprobar" id="aprobar" class="btn btn-primary btn-lg" disabled>Guardar</button>';
                

                echo "</center>";
                echo "</form>";
            echo "</div>";
        echo "</div>";
        echo "</div>";


        echo "</center>";
    }


    //EMPIEZO EJECUCION PARA GAURDAR EL CARGO 
   if(isset($_GET['aprobar'])){
    $NumContrato = $_GET['numcontrato'];
    $Folio = $_GET['folio'];
    $IdPrograma = $_GET['programa'];
    $IdDelegacion = $_GET['delegaciones'];

    $nombre = $_GET['nom'];
    $observaciones = $_GET['observaciones'];
    $cargo = $_GET['cargo'];
    $fecha = $_GET['fecha'];
    $importe = $_GET['importe'];
    $ref = $_GET['ref'];

    //ESTA OPCION NO ESTA PROGRAMADA EN VIVIENDA, NADIE LA USA POR QUE NO SE DEFINIO UN PROCESO 
    
    
   }
    
   


} else {mensaje("ERROR: no tienes acceso a este modulo","");}


?>
<script type="text/javascript">
function ChecaProblemas(){   
    NumContrato = $('#NumContrato').val();
    OriginData = $('#OriginData').val();
    nitavu = '<?php echo $nitavu; ?>';
    $('#preloader').show();
    $.ajax({
        url: "data_problemas.php",
        type: "get",
        data: {NumContrato:NumContrato, OriginData:OriginData},
        success: function(data){               
        $("#RCaja").html(data+"\n");  
        $('#preloader').hide();    
            
        }
    
    });
}



</script>
<?php include ("lib/body_footer.php"); ?>