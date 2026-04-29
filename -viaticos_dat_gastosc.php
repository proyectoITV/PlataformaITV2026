<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/yes_funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$IdViatico = VarClean($_POST['IdViatico']);
$sql = "select * from  viaticosgastoscomprobables WHERE IdViatico='".$IdViatico."' order by Fecha";
$r= $conexion -> query($sql);
$Dia  = 0;
$IdEstatus = viaticos_Status($IdViatico);
if ($IdEstatus == 1){
    echo "<table class='tabla' style='font-size:12pt;'>";
    echo "<th>Fecha</th>";
    echo "<th>Tipo</th>";
    echo "<th>Cantidad</th>";
    echo "<th>Comprobada</th>";
    echo "<th>Archivos</th>";
    echo "<th>Guardar</th>";
    while($f = $r -> fetch_array()) {
        if ($f['Cantidad']==$f['CantidadComprobada']){
            echo "<tr style='background-color:green;'>";    
        } else {
            
            echo "<tr>";    
            
        }
        
        echo "<td>".$f['Fecha']."</td>";
        echo "<td>".$f['Tipo']."</td>";
        echo "<td style='width:120px;'>".Pesos($f['Cantidad'])."</td>";
        //Cantidad a comprobar
        echo "<td style='width:120px;'>";
        echo "<input id='".$f['IdGastoF']."_comprobada' type='number' class='form-control' value='".$f['CantidadComprobada']."' min=0 max=".$f['Cantidad'].">";
        echo"</td>";

        //archivos
        echo "<td align=center valign=top>";
        
        echo "<form method='POST' enctype='multipart/form-data' id='Form".$f['IdGastoF']."'>";
        echo "<div style='
        width:100px; display:inline-block; margin:3px; border-radius:3px;  background-color:#8080803b; padding:4px;
        '><label>";
        
        if ($f['pdf1']<>''){
            echo "<a title='Haz Clic aqui para descargar' href='".$f['pdf1']."' download='".EasyName("Viatico",4)."'>"."<img src='icon/pdf.png' style='width:32px; cursor:pointer;'>"."</a>";
        } else {
            echo ""."<img src='icon/pdf2.png' style='width:32px;'>"."";
        }

        echo "</label><input  style='width:90px;' type='file' id='FilePDF".$f['IdGastoF']."' name='FilePDF".$f['IdGastoF']."' class='form-control' accept='application/pdf'></div>";
        
        echo "<div style='
        width:100px; display:inline-block; margin:3px; border-radius:3px;  background-color:#8080803b; padding:4px;
        '><label>";
        if ($f['xml']<>''){
            echo "<a title='Haz Clic aqui para descargar' href='".$f['xml']."' download='".EasyName("Viatico",4)."'>"."<img src='icon/xml2.png' style='width:32px; cursor:pointer;'>"."</a>";
        } else {
            echo ""."<img src='icon/xml.png' style='width:32px;'>"."";
        }

        echo "</label><input style='width:90px;'  type='file' id='FileXML".$f['IdGastoF']."' name='FileXML".$f['IdGastoF']."' class='form-control' accept='application/xml'></div>";
        echo "</form>";
        echo"</td>";

        //Guardar
        echo "<td align=right valign=top width=70px>";
        echo "
        <script>
            function fun".$f['IdGastoF']."(){
                IdViatico = '".$IdViatico."';          
                IdGastoF = '".$f['IdGastoF']."';  
                Comprobada = $('#".$f['IdGastoF']."_comprobada').val();
                var formData = new FormData(document.getElementById('Form".$f['IdGastoF']."'));        
                formData.append('IdViatico',  IdViatico);        
                formData.append('IdGastoF',  IdGastoF);        
                formData.append('Comprobada',  Comprobada);   
        
                $('#progressbar').show();
                    $.ajax({
                        url: 'viaticosc_dat_save.php',
                    type: 'post',                
                    dataType: 'html',
                    data: formData,             
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        // $('#progressbar').show();        
                    },                    
                    success: function(data){                
                        $('#R').html(data);                            
                        $('#progressbar').hide();
                    }
                    });
            }
        </script>
        ";
        echo "<button class='btn btn-success'
        onclick='fun".$f['IdGastoF']."();'
        ><img src='icon/saveas_white.png' style='width:32px'></button>";
        echo"</td>";

        echo "</tr>";
    }
    echo "</table>";    

    echo "<br><hr>";

    echo "<div style='
        background-color: #c4c1c1;
        border-radius:5px;
        padding:10px;

    '>";
    $sqlC = "select * from viaticoscomprobaciones  WHERE IdViatico='".$IdViatico."'";		
	$rC= $conexion -> query($sqlC);					
	if($fc = $rC -> fetch_array())
	{
        echo "<table width=100% style='font-size:15pt;'>";
        echo "<tr>";
            echo "<td align=right>Gasto: </td><td align=left><b>".Pesos($fc['Gasto'])."</b></td> <td width=50% rowspan=4 valing=middle align=center style='
            background-color:#4195f9;
            '>";
            echo "
            <label style='color:white;'>Estado de la Comprobacion:</label><br>
            <b style='color:white; font-size:20pt;'>".$fc['Comprobacion']."</b>";

            if ($fc['Comprobacion']=='COMPROBADO'){
                //Documento de Comprobacion de viaticos
                if(actualizarEstatusViatico($IdViatico,6)==TRUE)
                {

                $IdSegViatico=  NextIdSeguimiento($IdViatico);
                $sql2="INSERT INTO viaticosseguimiento(IdViatico,IdSegViatico,IdEstatus,FechaCrea,NitavuCrea,Observaciones)VALUES($IdViatico,($IdSegViatico+1),6,NOW(),$nitavu,'Viático comprobado')";
               //echo $sql2;
                if ($conexion->query($sql2) == TRUE) {

                                 
                    historia($nitavu,"Actualizo el Viatico con IdViatico=".$IdViatico." como comprobado",);               
                    echo "
                    <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'EXITO',
                        text: 'Se registro que el viático ha sido comprobado ',
                        timer: 1500,
                        footer: ''
                    });
                    </script>";    
                }  
                    
                   
                }
            }

            echo "</td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td align=right>Gasto Comprobado: </td><td align=left><b>".Pesos($fc['GastoComprobado'])."</b></td> ";
        echo "</tr>";

        echo "<tr>";
            $Faltante = $fc['Faltante'];
            if ($Faltante <0){$Faltante = 0;}
            echo "<td align=right>Faltante: </td><td align=left><b>".Pesos($Faltante)."</b></td> ";
        echo "</tr>";

        echo "<tr>";
            echo "<td align=right>Reintegro: </td><td align=left><b>".Pesos($fc['Reintegro'])."</b></td> ";
        echo "</tr>";

        

        echo "</table>";
		
	}  else {
        echo "ESTE VIATICO NO ESTA LISTO PARA LA COMPROBACION";
    }  
    unset($sqlC, $rC, $fc);
    echo "</div>";

} else {
    echo "<b>EL PRESENTE VIATICO NO ESTA EN ESTATUS ARCHIVADO</b>";
}

unset($r,$f,$sql);
?>