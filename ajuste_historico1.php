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

function cambiarimporte(){
    var cargo = $('#cargo').val();
    console.log(cargo);
    if (cargo == 51){
        $('#importe').val(90);
    }else if(cargo == 48){
        $('#importe').val(627);
    }else if(cargo == 50){
        $('#importe').val(627);
    }else if(cargo == 65){
        $('#importe').val(90);
    }
}
</script>

<?php
set_time_limit(72000) ;
error_reporting(0); //<-- para simular produccion
require_once("var_clean.php");
$id_aplicacion ="ap122"; $nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
echo "<script>$('body').css('background-color','rgb(255, 255, 255)');</script>";
// echo "<script>$('body').css('background-image','url(img/wall_ayuda3.jpg)');</script>";
// echo "<script>$('body').css('background-position','top');</script>";

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";      
    // echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    

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


        echo '<h1 class="card-header h5">Registro de Cargos de Servicios  Especial (+)</h1>';
        $sqltc = "SELECT idtipomov,descripcionmovimiento FROM descripcionmovimiento where idtipomov in (51,48,50,65)  ORDER BY descripcionmovimiento";
                
           
        
       
            echo '<div class="card-body">';  
                echo "<form action='ajuste_historico1.php' method='GET'>";
                echo "<input type='hidden' name='folio' id='folio' value=".$Folio.">";
                echo "<input type='hidden' name='numcontrato' id='numcontrato' value=".$NumContrato.">";
                echo "<input type='hidden' name='programa' id='programa' value=".$IdPrograma.">";
                echo "<input type='hidden' name='delegacion' id='delegacion' value=".$IdDelegacion.">";

                echo "<center>";

                
                    echo "<br><label>Número de oficio-memo-convenio-recibo</label>";
                    echo "<input id='convenio' name='convenio'>";
                
                    echo "<br><label>Observaciones</label>";
                    echo "<input id='observaciones' name='observaciones'>";
                    
                 
                    $r2= $Vivienda -> query($sqltc);
                    echo "<label>Tipo de Cargo</label>
                    <select name='cargo' id='cargo' onchange='cambiarimporte()'>";
                    while($fx = $r2 -> fetch_array()) {
                        echo "<option value='".$fx['idtipomov']."'>".$fx['descripcionmovimiento']."</option>";
                    }
                    echo "</select>";
                    
                    
                    echo "<br><label>Fecha</label>";
                    echo "<input type='date' id='fecha' name='fecha' value='$fecha'>";


                    echo "<br><label>Importe</label>";
                    echo "<input id='importe' name='importe' readonly>";

                    echo "<br><label>Folio Recibo</label>";
                    echo "<input id='ref' name='ref'>";

                    echo '<button type="submit" name="aprobar" id="aprobar" class="btn btn-primary btn-lg">Guardar</button>';
                

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

        $convenio = $_GET['convenio'];
        $observaciones = $_GET['observaciones'];
        $cargo = $_GET['cargo'];
        $fecha = $_GET['fecha'];
        $importe = $_GET['importe'];
        $ref = $_GET['ref'];

        //localizo el maximo mov. este cancelado o no
        $vNumMov = ultimoPago($NumContrato);
        $maximoactivo = ultimoPagoActivo($NumContrato);

        //TRAER VALORES DEL ULTIMO HISTORICOPAGOS ACTIVO
        $sql = "Select * from historicopagos Where NumContrato='".$NumContrato."' and NumMov='".$maximoactivo."'";
        $r = $Vivienda -> query($sql); 
  
        $vNumMov = 0;
        $RezGts = 0;
        $NuevoRezGts = 0;
        $RezSeg = 0;
        $NuevoRezSeg = 0;
        $NuevoRezOtrosGts = 0;
        $NuevoRezMoratorios = 0;
        $NuevoRezFinanc = 0;
        $NuevoRezCapital = 0;
        $saldoexento = 0;
        $SaldoCapitalCorriente = 0;

        while($f = $r -> fetch_array()){
            $vNumMov = $f['NumMov'];
            $RezGts = $f['RezGts'];
            $NuevoRezGts = $f['NuevoRezGts'];
            $RezSeg = $f['RezSeg'];
            $NuevoRezSeg = $f['NuevoRezSeg'];
            $NuevoRezOtrosGts = $f['NuevoRezOtrosGts'];
            $NuevoRezMoratorios = $f['NuevoRezMoratorios'];
            $NuevoRezFinanc = $f['NuevoRezFinanc'];
            $NuevoRezCapital = $f['NuevoRezCapital'];
            $saldoexento = $f['saldoexento'];
            $SaldoCapitalCorriente = $f['SaldoCapitalCorriente'];
            $FechaCorte = $f['FechaCorte'];
        }


        $Num = $vNumMov + 1 ;

        if($cargo == 51 or $cargo == 48 or $cargo == 50 or $cargo == 65 or $cargo == 69 or $cargo == 70 or $cargo == 91 or $cargo == 137){
            $saldoexento =  $saldoexento + $importe;
        }
        if($cargo == 34 or $cargo == 4 or $cargo == 144){
            $SaldoCapitalCorriente = $SaldoCapitalCorriente + $importe;  
        }


        $nuevo = 'INSERT INTO historicopagos (NumContrato, NumMov, MontoPagoRecibido, FechaOperacion, FechaCorte, FechaInicia , FechaTermina, RezGts, RezGtsCubierto, GtsPeriodo, GtsPeriodoCubiertos, NuevoRezGts, RezSeg, 
        RezSegCubierto, SegPeriodo, SegPeriodoCubierto, NuevoRezSeg, RezOtrosGts, RezOtrosGtsCubierto, OtrosGtsPeriodo, OtrosGtsPeriodoCubierto, NuevoRezOtrosGts, RezMoratorios, RezMoratoriosCubierto, MoratoriosPeriodo, 
        NuevoRezMoratorios, RezFinanc, RezFinancCubierto, FinancPeriodo, FinancPeriodoCubierto, NuevoRezFinanc, RezCapital, RezCapitalCubierto, CapitalPeriodo, CapitalPeriodoCubierto, NuevoRezCapital, AplicadoExcedente, 
        SaldoCapitalCorriente, Origen, TipoMov, Enviar, FechaCaptura, FechaEnvio, FechaUltimaMod, IdEmpCrea, IdEmpModifica, Observaciones, saldoexento, IdMovDesc, ReferenciaOPD, RefBancariaOPD, Observacion2, IdFormaPago, 
        IdSupervisor, ImpSF002, FechaImpSF002, FechaReimSF002, OrigenDeEnvio, Cancelado, NumMovErroneo, OriginData )
        VALUES ("'.$NumContrato.'", "'.$Num.'", 0, now(),"'.$FechaCorte.'","","","'.$NuevoRezGts.'",0,0,0,"","'.$NuevoRezSeg.'",
        0,0,0,"","'.$NuevoRezOtrosGts.'",0,0,0,"","'.$NuevoRezMoratorios.'",0,0,
        "'.$NuevoRezFinanc.'",0,0,0,"'.$NuevoRezCapital.'",0,"",0,"'.$importe.'",0,"",0,
        "'.$SaldoCapitalCorriente.'","","'.$cargo.'",1,now(),"","","'.$nitavu.'","","'.$observaciones.'","'.$saldoexento.'","","","","'.$convenio.'",""
        "","","","","","'.$IdDelegacion.'","","", "'.$IdDelegacion.'")';
        echo $nuevo;
        if ($Vivienda->query($nuevo) == TRUE){   
            $sql2 = "Select numcontrato,Estatuscuenta from controlcontratos where numcontrato='".$NumContrato."'";
            echo $sql2;
            $r2= $Vivienda -> query($sql2);
            while($fx = $r2 -> fetch_array()) {
                if ($fx['Estatuscuenta']== 1){
                    echo $fecha;
                    $ultimodia = ObtenerUltimoDiaMesconFecha($fecha);

                    $sql3 = "update controlcontratos set estatuscuenta=2, enviar = 1,fechaproximocorte='".$ultimodia."'
                    idempmodifica = ".$nitavu.", fechaultimamod = '".$fecha."' 
                    where numcontrato = '".$NumContrato."'";
                    echo $sql3;
                    if ($Vivienda->query($nuevo) == TRUE){   
                        mensaje ("Operación realizada con éxito",'ajuste_historico1.php');
                    }else{
                        mensaje ("ERROR: Ocurrio un error al realizar la operación.",'ajuste_historico1.php');
                    }

                }else{
                    mensaje ("Operación realizada con éxito",'ajuste_historico1.php');
                }
            }
        }else{
            mensaje ("ERROR: Ocurrio un error al realizar la operación.",'ajuste_historico1.php');

        }

        
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