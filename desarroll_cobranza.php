<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
//include("./lib/laura.css");
?>
<?php
$id_aplicacion ="ap117"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos

//Niveles
// 1 = Crear y Editar
// 2 = Consulta

//Ajusta esta variable para ver el comportamiento
//$nivel=1;

echo "<script>$('body').css('background-color','rgb(108, 116, 119)');</script>";
// echo "<script>$('body').css('background-size','150%');</script>";

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    if(isset($_GET['id'])){
        $IdConvenio = VarClean($_GET['id']);
        $VInfo = Desarrollador_Info($IdConvenio);
        echo "<div style='
        background: rgb(33,116,166);
        background: linear-gradient(180deg, rgba(33,116,166,1) 0%, rgba(33,116,166,1) 14%, rgba(108,116,119,1) 71%); 
        margin-top:-8px;
        padding:10px;
        
        '
     
        >";
            echo "<table width=100%>";
            echo "<tr>";
            echo "<td style='text-align-last: left';><h3 style='color:white;'>Convenio Num.".$IdConvenio."</h3></td>";
            echo "<td align=right>";
            echo "<a  class='btn btn-primary' href='?='>Regresar</a>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
        echo "</div>";

        echo "<div id='Form' class='container' style='background-color: #fff;
        border-radius: 5px;
        padding: 15px;
        margin-top:20px;
        '>";
        
       // $sql="Select * from convdesarrollador where  Folio=".$IdConvenio;
       $sql="Select Folio, FechaConvenio, PlazoConvenio, TotalLotes, MontoConvenio,
       (select catdesarrolladores.Nombre from catdesarrolladores where catdesarrolladores.IdDesarrollador = convdesarrollador.IdDesarrollador) AS Nombre,
       AnticipoGlobal,SubsidioLote,case when Completo= 1 then 'Completo' else 'incompleto' end AS Completo
       from convdesarrollador where  Folio=".$IdConvenio." Order By Folio" ;
        
        //echo $sql;
        $rc= $Vivienda -> query($sql);
        if($f = $rc -> fetch_array())
            {

                echo "<table width=100%><tr>";
               
                // echo "<form method='POST' enctype='multipart/form-data' id='VForm'>";
               
                //  echo "</form>";                               

                echo "<td valign=top >";
                               
                text_largo('VNombre','Desarrollador','Nombre del Desarrollador','text',$f['Nombre'],'','True');
                FormElement_input("Número de Convenio ",$f['Folio'],"", "","text","", TRUE);
                FormElement_input("Fecha del convenio",$f['FechaConvenio'],"", "","text","", TRUE);
                FormElement_input("Plazo Convenio",$f['PlazoConvenio'],"", "","number","", TRUE);
                FormElement_input("Monto del Convenio",Pesos($f['MontoConvenio']),"", "","text","", TRUE);        
                FormElement_input("Anticipo Global",Pesos($f['AnticipoGlobal']),"", "","text","", TRUE);        
                //FormElement_input("Subsidio por Lote",Pesos($f['SubsidioLote']),"", "","text","", TRUE);
                FormElement_input("Total Lotes",$f['TotalLotes'],"", "","number","", TRUE);
                FormElement_input("Registro Completo",$f['Completo'],"", "","text","", TRUE);
                echo "</td></tr>";

               
                echo "<tr><td>";  
               
               echo "</td></tr>";
               echo "</td></tr></table>";
            }    
    }else{   
            echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
            echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";

            //carga listado de desarrolladores
            echo "<div style='
            background: rgb(33,116,166);
            background: linear-gradient(180deg, rgba(33,116,166,1) 0%, rgba(33,116,166,1) 14%, rgba(108,116,119,1) 71%); 
            margin-top:-8px;
            padding:10px;
            
            '>";

                echo "<h2>Cobranza-Listado de convenios</h2>";
                echo "<table width=100%>";
                echo "<tr>";
                echo "<td align=center><h3 style='color:white;'></h3></td>";
                echo "<td align=right>";
                //echo "<a  class='btn btn-primary' href='?new='>Nuevo</a>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
            
            echo "</div>";

            echo "<div id='Resultado' class='container' style='background-color: #fff;
            border-radius: 5px;
            padding: 15px;
            margin-top:20px;
            '></div>";
    }    

}

else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 



?>
<script>
function VReload(){		            
        search = $('#search').val();
        $('#progressbar').show();
            $.ajax({
                url: "desarroll_buscarDesarrConvs.php",
            type: "post",        
            data: {search:search},
            success: function(data){                
                $("#Resultado").html(data+"");                    
                $('#progressbar').hide();
            }
            }); 
            
}


VReload();
</script>
<?php include ("./lib/body_footer.php"); ?>