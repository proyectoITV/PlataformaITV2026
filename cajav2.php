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
    if(NumContrato != ''){
        $('#NumContrato').val(NumContrato);
        $('#OriginData').val(OriginData);
    }else{
        $('#Folio').val(Folio);
        $('#IdPrograma').val(IdPrograma);
        $('#OriginData').val(IdDelegacion);
    }
    
    btnBuscar();
}
</script>

<?php
set_time_limit(72000) ;
error_reporting(0); //<-- para simular produccion
require_once("var_clean.php");
$id_aplicacion ="caja"; $nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
echo "<script>$('body').css('background-color','rgb(255, 255, 255)');</script>";
// echo "<script>$('body').css('background-image','url(img/wall_ayuda3.jpg)');</script>";
// echo "<script>$('body').css('background-position','top');</script>";

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";      
    // echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    

    echo "<div id='InfoEntrada' style='
    background-color: #f0f0f0;
    padding: 10px;'>";

    //por programa y folio
    echo "<table><tr>";
    echo '<td><label>Folio:</label>
    <input id="Folio" class="form-control" style="width:300px;" type="text"  placeholder="Folio"></td>';
    echo "<td><label>Programa:</label>
        <select  style='width:250px;'   class='form-control' id='IdPrograma'>";
    $r= $Vivienda -> query("select  IdPrograma, Programa from programa");
    while($f = $r -> fetch_array()) {
        echo "<option value='".$f['IdPrograma']."'>".$f['Programa']."</option>";
    }
    unset($f, $r);
    echo "</select></td>";
    //<input id="IdPrograma" class="form-control" style="width:300px;" type="text"  placeholder="Programa"></td>';
    echo "</tr></table>";


    echo "<table width=100%>";
    echo "<tr><td width=300px>";
    echo '<label>Contrato:</label>
    <input id="NumContrato"
    class="form-control"
    style="width:300px;" 
    type="text"  placeholder="NumContrato">';
    echo "</td><td width=250px>";
    echo "<label>Delegación de Origen</label><select  style='width:250px;'   class='form-control' id='OriginData'>";
    $r= $conexion -> query("select  a.id as IdDelegacion, a.nombre as Delegacion from cat_delegaciones a where ciudad <> '' ");
    while($f = $r -> fetch_array()) {
        echo "<option value='".$f['IdDelegacion']."'>".$f['Delegacion']."</option>";
    }
    unset($f, $r);
    echo "</select>";
    echo "</td>";
    echo "<td>";
    echo "<button style='margin-top: 26px;
    margin-left: 10px;' class='btn btn-primary' onclick='CargaCaja();'>Seleccionar</button>";
    echo "</td></tr></table>";
    echo "</div>";


    if (isset($_GET['NumContrato']) and isset($_GET['OriginData'])){
        echo "<script>Seleccion(".$_GET['NumContrato'].", ".$_GET['OriginData'].");</script>";
    }



     /*******************DATOS RECIBO***********************************/

     if(isset($_GET['DatosRecibo']))
     {
         $IdDelegacion = $_GET['IdDelegacion'];
         $IdPrograma = $_GET['IdPrograma'];
         $Folio = $_GET['Folio'];
       echo "<div id='contenedorRecibo'  style='margin-top: 50px;'>";  			
         echo "<div>";
           echo "<iframe id='framerecibo' name='framerecibo' src='formatoRecibo2.php?DatosRecibo=".$_GET['DatosRecibo']."&IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&Folio=".$Folio."' style='width:100%; height:100%; border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
         echo "</div>";
       echo "</div>";  
        /*******************************************************************/
     }
     

    echo "<div id='RCaja'>";

    echo "</div>";

    echo "<div id='RCaja2'>";

    echo "</div>";

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
    top:40px;

    '>";
    echo "<table width=100% border=0><tr><td width=30px>";
    echo "<img onclick='btnBuscar();'  src='icon/txtbuscar.png' style='width:30px; cursor:pointer;'></td><td>";
    echo "<input type='hidden' id='nitavu' name='nitavu' value='".$nitavu."'>";
    echo "<div style='
    width: 100%; padding-top: 0px; padding-bottom: 13px; margin-top: 7px;'>
    <table width=100%><tr><td width=90%>";
    echo "<input style=' height: 65px; border-radius: 5px; font-size: 18pt; font-family: Light; margin-left: 12px; padding: 10px; margin-right: 20px;
    'type='text' name='search' id='search' placeholder='Ingrese nombre del beneficiario o número de contrato'>";
    echo "</td><td>
    <button type='submit' onclick='BuscaContrato();' class='Mbtn btn-primary' id='indicaciones2' style='font-size: 8pt;  height: 60px; 
    
    margin-top: -3px;
    margin-left: 5px;

    ' onclick='v001.php'>    <img src='icon/buscar2.png' style='width:40px;'>
    </button></td></tr></table></td>
    </div>"; 

    echo "<tr><td></td><td>";
    
    echo "<div id='BusquedaPreLoader' style='display:none;
    background-color: #ff8f00;
    padding: 10px;
    border-radius: 4px;
    text-align: center;
    color: white;
    
    '> Buscando <img src='img/loader_bar.gif'></div>";
    echo "
    
    <div class='' id='RespuestaCaja' style='overflow: auto;
    height: 500;'></div>";

    echo "</div></td></tr></table></div>";

       



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


function CargaCaja(){   
    NumContrato = $('#NumContrato').val();
    IdPrograma = $('#IdPrograma').val();
    Folio = $('#Folio').val();
    IdDelegacion = $('#OriginData').val();
    //alert(NumContrato);
    OriginData = $('#OriginData').val();
    nitavu = '<?php echo $nitavu; ?>';
    $('#preloader').show();
    $.ajax({
        url: "caja_dat.php",
        type: "get",
        data: {NumContrato:NumContrato, OriginData:OriginData, IdPrograma: IdPrograma, Folio:Folio, IdDelegacion: IdDelegacion, nitavu:nitavu},
        success: function(data){ 
        $("#RCaja2").html(data+"\n");  
        $('#preloader').hide();    
            
        }
    
    });
}

</script>
<?php include ("lib/body_footer.php"); ?>

