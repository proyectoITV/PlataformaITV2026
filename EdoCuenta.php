
<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>

<?php
$id_aplicacion ="v002"; 
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
error_reporting(0);
echo "<script>$('body').css('background-color','rgb(231, 231, 232)');</script>";

// echo "<script>$('body').css('background-image','url(img/wall_ayuda3.jpg)');</script>";
echo "<script>$('body').css('background-position','top');</script>";
if (sanpedro($id_aplicacion, $nitavu)==TRUE){   
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
    // echo "<script>$('#AppDetalle').css('background-color','rgb(82, 84, 85)');</script>";

    echo "
    <div id='EdoPDFLoader' 
    style='
    position: fixed;
    background-color: rgba(66, 73, 76, 0.76);
    width: 70%;
    height: 100%;
    color: white;
    display:none;
    
    '>
    <div id='LoaderPDF' style='
        width:40%;
        text-align:center;
        position: fixed;
        top:30%;
        left:16%;
        background-color:white;
        border-radius:12px;
        color:gray;
        
     
    '>
    
    <br>Construyendo el Edo. de Cuenta, espere por favor
    <img src='img/loader_.gif' style='width:150px;'>
    <br>
    <br>
    </div>
    </div>
    ";
    echo "<div id='EdoPDF' style='
    background-color:rgb(231, 231, 232);
    
    width: 70%;
    display: inline-block
    '>";
    echo "</div>";



    echo "<div id='EdoPanel' style='
    background-color: white;
    
    width: 30%; height: 100%;
    vertical-align: top;
    display: inline-block
    '>";

    echo "<div id='PanelBarra' style='
    padding: 5px;
    background-color: #93d026;
    '><table width=100%><tr><td >";

    if (isset($_GET['NumContrato'])){
        $ElContrato = VarClean($_GET['NumContrato']);
    } else {
        $ElContrato = "";
    }

        echo "
        <input type='text' style='
        height: 50px;
        width: 100%;
        font-face: 14pt;
        background-color: transparent;
        font-size: 16pt;
        text-align: center;
        
        border: none;
        
        ' id='_NumContrato' placeholder='Num de Contrato' value='".$ElContrato."'>";
   
   

    echo "</td>
    <td width=10px align=right valign=top>";
    echo "<button class='btn btn-success' onclick='AnalizaContrato();' style='
    height: 48px;
    background-color: #50993c;
    border-width: 0px;
    margin-top: 0px;
    '><img src='icon/busqueda.png' style='width:20px; '></button>";
    echo "</td></tr></table></div>";

    echo "
    <div id='PanelLoader' style='width: 100%;
    text-align: center;
    font-size: 9pt;
    color: white;
    background: #10750d;'>
        
    </div>
    ";
    
    echo "<div id='R_panel_lista' style='font-size: 9pt;
    color: gray;
    padding: 5px;
    text-align: left;'>";
    echo "</div>";
    
    echo "<div id='R_panel' style='font-size: 9pt;
    color: gray;
    padding: 5px;
    text-align: left;'>";

    echo "</div>";

    echo "</div>";
} else {mensaje("Error: No esta autorizado para ver Estados de Cuenta.","index.php");}


?>
<script>

function AnalizaContrato(){
    _NumContrato = $('#_NumContrato').val();
    nitavu = '<?php echo $nitavu; ?>'
    if (_NumContrato ==''){
        $.toast({
            heading: 'Error',
            text: 'Captura primero el Numero de Contrato',
            showHideTransition: 'slide',
            icon: 'error'
        })
        $('#AudioError')[0].play();
    } else {
        // $.toast('Listo para analizar '+_NumContrato);
        PanelLoader('Analizando el contrato '+_NumContrato+'. <b> espere por favor</b> ')
        $.ajax({
        url: 'edo_dat_analizacontrato.php',
        type: 'post',			
        data: {_NumContrato:_NumContrato, nitavu:nitavu},
        success: function(data){
            $('#R_panel_lista').html(data);          
            PanelLoader('');
        
            }
        });

        // $('#AudioSuccess')[0].play();
    }
}


function PanelLoader(Texto='', ){
    if (Texto == ''){
        $('#PanelLoader').hide();
    } else {
        $('#PanelLoader').show();
        $('#PanelLoader').html(' '+Texto+' <img src="img/loader_bar.gif" >');
    }
    
}

function CargaContrato_PDF(OriginData, Mode){
    $('#EdoPDFLoader').show();
    $('#R_panel').html('');
    _NumContrato = $('#_NumContrato').val();
    if (Mode == 1){
        $('#EdoPDF').html('<iframe id="FrameCPDF" src="v002.php?numcontrato='+_NumContrato+'&origindata='+OriginData+'&full" border=0></iframe>');
    } else 
    {
        $('#EdoPDF').html('<iframe id="FrameCPDF" src="v002.php?numcontrato='+_NumContrato+'&origindata='+OriginData+'" border=0></iframe>');
    }
    
    
    $(document).ready(function () {
        $('#FrameCPDF').on('load', function () {
            

            //Chequeo de Errores
            IdProblema = 1;
            AnalizarProblema(OriginData, IdProblema);

            //$('#EdoPDFLoader').hide();
            $('#AudioSuccess')[0].play();

        });
    });

}

function AnalizarProblema(OriginData, IdProblema=1, ejecuta=0){
    _NumContrato = $('#_NumContrato').val();
   nitavu = '<?php echo $nitavu; ?>' ;
    // PanelLoader(Texto='', )
    $('#EdoPDFLoader').show();
    Problema = '';   
    
    PanelLoader('Detectando posibles problemas: ');
    
    if (IdProblema == 1){
        $('#R_panel').append('<h6>Deteccion de Posibles problemas (Origen='+OriginData+'):</h6>');  
    }
    $.ajax({
    url: 'edo_dat_problemas.php',
    type: 'post',			
    data: {_NumContrato:_NumContrato, IdProblema:IdProblema, OriginData:OriginData, nitavu:nitavu, ejecuta:ejecuta},
    success: function(data){
        $('#R_panel').html(data);          
        PanelLoader('');
        $('#EdoPDFLoader').hide();
        // if (IdProblema <= 22){
        //     AnalizarProblema(OriginData, IdProblema+1);
        // }
        }
    });

    
}


// function Analizarproblemas(OriginData){
//     _NumContrato = $('#_NumContrato').val();
//     for (let i = 0; i < 22; i++) { 
        
//     }
// }


function VoBo(VoBo, OriginData){
    $('#EdoPDFLoader').show();
    _NumContrato = $('#_NumContrato').val();
    nitavu = '<?php echo $nitavu; ?>' ;
    $('#preloader').show();
    $.ajax({
    url: 'edo_dat_vobo.php',
    type: 'post',			
    data: {_NumContrato:_NumContrato, VoBo:VoBo, OriginData:OriginData, nitavu:nitavu},
    success: function(data){
        $('#R_panel').append(data);          
        PanelLoader('');
        $('#EdoPDFLoader').hide();
        $('#preloader').hide();
        }
    });
}

</script> 

<?php
     if ($ElContrato <> ''){
        echo "<script>AnalizaContrato();</script>";
    }

?>
<?php include ("./lib/body_footer.php"); ?>