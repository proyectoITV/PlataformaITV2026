<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/laura_funciones.php");
// require_once("lib/flor_funciones.php");

$IdConvenio = VarClean($_POST['IdConvenio']);
$VInfo = Desarrollador_Info($IdConvenio);
$sql="select * from desarrolladoresconvenios_html where IdDesarrollador=".$IdConvenio;
// echo $sql;
//TablaDinamica_MySQL($tbCont, $sql, $IdDiv, $IdTabla, $Clase, $Tipo, $ClaseTabla='tabla', $titulo='',$Orientacion='P',$nombrearchivo='pdf')
TablaDinamica_MySQL2("",$sql, "MiIdDivTabla2", "IdTabla2", "", 2,"","CONVENIOS DE ESTE DESARROLLADOR","Landscape",""); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal

    $sqlB="
    Select * from convdesarrollador    
    ";
   
    /* $sqlB="
    select 
    vb.*,
    IFNULL((select cat_tiposdemantenimiento.Tipo_Mantenimiento from cat_tiposdemantenimiento where clave_tipo_mant = vb.clave_tipo_mant),'Correctivo') as TipoServicio,
    ifnull((select cat_proveedoresvehiculos.Nombre_proveedor from cat_proveedoresvehiculos where clave_proveedor = vb.clave_proveedor),'') as Proveedor
    from vehiculos_bitacora vb"; */
    // echo $sqlB;
    $r2= $Vivienda -> query($sqlB);
    while($f2 = $r2 -> fetch_array()) {
        // echo '<a href="#Modal_'.$f2['Clave_servicio'].'" class="btn btn-link" rel="MyModal:open">'.$f2['Clave_servicio'].'</a>';

        echo "<div class='MyModal' id='Modal_".$f2['Folio']."'>";
        //echo "<div class='MyModal' id='Modal_".$f2['Clave_servicio']."'>";

        echo "<h3 style='
        font-size: 10pt;
        color: black;
        '>Convenio Númerooooooo <b>".$f2['Folio']."</b> - ".$VInfo."</h3>";

        echo "<table width=100%><tr>";
        echo "<td width=30%;>";
       /*  $archivo = 'fotos_vehiculos/'.$IdVehiculo.'_'.$f2['Clave_servicio'].'.jpg';
        if (file_exists($archivo)){
            echo '<a href="'.$archivo.'" target=_blank><img name="fotoB" id="foto" src="'.$archivo.'" style="width:100%; border-radius:10px;"></a>';
        } else {
            echo '<img name="" id="foto" src="icon/vnofoto2.jpg" style="width:100%; border-radius:10px;">';
        }
        echo '<br><br><a  style="font-size:8pt;" href="formatoServicioIndividual.php?clave_servicio='.$f2['Clave_servicio'].'&id='.$IdVehiculo.'" target=_blank><img name="" id="" src="icon/pdf.png" style="width:18px;">Imprimir Servicio</a>'; */
        echo "</td></tr>";
        echo "<tr><td>";
        FormElement_input("Número de Convenio ",$f2['Folio'],"", "","text","", TRUE);
        FormElement_input("Fecha del convenio",$f2['FechaConvenio'],"", "","text","", TRUE);
        FormElement_input("Plazo Convenio (Meses)",$f2['PlazoConvenio'],"", "","number","", TRUE);
        FormElement_input("Monto del Convenio",Pesos($f2['MontoConvenio']),"", "","text","", TRUE);        
        FormElement_input("Anticipo Global",Pesos($f2['AnticipoGlobal']),"", "","text","", TRUE);        
        FormElement_input("Subsidio por Lote",Pesos($f2['SubsidioLote']),"", "","text","", TRUE);
        FormElement_input("Total Lotes",$f2['TotalLotes'],"", "","number","", TRUE);
        // if ($f2['Completo']==1){
        //     $com_incom='Completo';
        // }else{
        //     $com_incom='Incompleto';
        // }
        FormElement_input("Registro Completo",$f2['Completo'],"", "","number","", TRUE);
        //FormElement_input("Registro Completo",$com_incom,"", "","number","", TRUE);
       
        echo "</td></tr>";
        //echo "<tr><td>";
           // $sql3="Select Manzana, Lote,IdLote, NumContrato, MontoCredito from contratos where cancelado=0 and idprograma=165 and folio=".$f2['Folio']." order by numcontrato";
            //TablaDinamica_MySQL2("",$sql3, "MiIdDivTabla3", "IdTabla3", "", 2,"","LOTES EN ESTE CONVENIO","",""); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal Landscape
        //echo "</td></tr>";
        echo "</table>";

        echo "<div id='Form' class='container' style='background-color: #fff;
        border-radius: 5px;
        padding: 15px;
        margin-top:20px;
        '>";
        
        echo "<h3>Lotes Registrados en Convenio: <img src='icon/loading.png' style='width:18px; cursor:pointer;' onclick='VBReload();'></h3>";

        echo "<div id='RBitacoras'>";
        //$sql3="Select Manzana, Lote,IdLote, NumContrato, MontoCredito from contratos where cancelado=0 and idprograma=165 and folio=".$f2['Folio']." order by numcontrato";
        $sql3="Select Manzana, Lote,IdLote,Colonia, NumContrato, MontoCredito
        from contratos
        LEFT JOIN catcolonia on contratos.IdColoniaL=catcolonia.IdColonia and contratos.IdMunicipioL=catcolonia.IdMunicipio
         where contratos.cancelado=0 and idprograma=165 and folio=".$f2['Folio']." order by numcontrato";
        $rc= $Vivienda -> query($sql3);
        $row_cnt = $rc->num_rows;
           $cont=0;
           if($row_cnt>0)
           {
             echo "<table class='Tabla'><th>Manzana</th><th>Lote</th><th>Colonia</th><th>Numcontrato</th><th>Monto Credito</th><th>Clave Lote</th>";  
             while($valor = $rc -> fetch_array())
             {
                echo "<tr>";
            echo "<td>".$valor['Manzana']."</td><td>".$valor['Lote']."</td><td>".$valor['Colonia']."</td><td>".$valor['NumContrato']."</td><td>".$valor['MontoCredito']."</td><td>".$valor['IdLote']."</td>";
            //<td>".$valor['Lote']."</td><td>".$valor['Numcontrato']."</td><td>".$valor['MontoCredito']."</td><td>".$valor['IdLote']."</td>
            echo "</tr>";

                //echo "<li>".$manzana;
           //echo "Nombre<input name='nombre' value='".$valor['Nombre']."' class='form-control mr-sm-2' type='search' placeholder='' aria-label='first' style='width: 100%; height: 25;'>";   
         
         }  
         echo "</table>";
       } 



        //TablaDinamica_MySQL2("",$sql3, "Mi", "Id3", "", 2,"","LOTES EN ESTE CONVENIO","Portrait",""); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal Landscape
        echo "</div>";
        echo "</div>";



       /*  $archivo = 'fotos_vehiculos/'.$IdVehiculo.'_'.$f2['Clave_servicio'].'.pdf';
        if (file_exists($archivo)){
            echo '<a href="'.$archivo.'" target=_blank><img name="" id="" src="icon/pdf.png" style="width:18px;">Documento de apoyo</a>';
        } else {
            // echo '<img name="fotoB" id="foto" src="icon/vnofoto2.png" style="width:100%; border-radius:10px;">';
        } */
        

        // echo "<button class='btn btn-warning' onclick='CancelarBitacora(".$f2['Clave_servicio'].");'>Cancelar esta Bitacora</button>";

        echo "</div>";
    }
    unset($r2, $f2,$sqlB);














//Bitacora nueva:

//echo '<div style="width:100%; text-align:center;"><a href="?newb=&id='.$IdVehiculo.'" class="btn btn-success" >Nueva Bitacora</a></div>';


echo '</div>';

?>