<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("vehiculos_fun.php");
// require_once("lib/flor_funciones.php");

$IdVehiculo = VarClean($_POST['IdVehiculo']);
$VInfo = Vehiculo_Info($IdVehiculo);
$sql="select * from vehiculosbitacoras_html where Num_economico='".$IdVehiculo."'";
// echo $sql;
//TablaDinamica_MySQL($tbCont, $sql, $IdDiv, $IdTabla, $Clase, $Tipo, $ClaseTabla='tabla', $titulo='',$Orientacion='P',$nombrearchivo='pdf')
//TablaDinamica_MySQL("",$sql, "MiIdDivTabla2", "IdTabla2", "", 2);
TablaDinamica_MySQL("",$sql, "MiIdDivTabla2", "IdTabla2", "", 2,"",'BITACORA DE SERVICIOS','Landscape','Bitacora_'.$IdVehiculo); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal

    $sqlB="
    select 
    vb.*,
    IFNULL((select cat_tiposdemantenimiento.Tipo_Mantenimiento from cat_tiposdemantenimiento where clave_tipo_mant = vb.clave_tipo_mant),'Correctivo') as TipoServicio,
    ifnull((select cat_proveedoresvehiculos.Nombre_proveedor from cat_proveedoresvehiculos where clave_proveedor = vb.clave_proveedor),'') as Proveedor
    from vehiculos_bitacora vb";
    // echo $sqlB;
    $r2= $conexion -> query($sqlB);
    while($f2 = $r2 -> fetch_array()) {
        // echo '<a href="#Modal_'.$f2['Clave_servicio'].'" class="btn btn-link" rel="MyModal:open">'.$f2['Clave_servicio'].'</a>';

        echo "<div class='MyModal' id='Modal_".$f2['Clave_servicio']."'>";
        echo "<h3 style='
        font-size: 10pt;
        color: black;
        '>Bitacora <b>".$f2['Clave_servicio']."</b> - ".$VInfo."</h3>";

        echo "<table width=100%><tr>";
        echo "<td width=30%;>";
        $archivo = 'fotos_vehiculos/'.$IdVehiculo.'_'.$f2['Clave_servicio'].'.jpg';
        if (file_exists($archivo)){
            echo '<a href="'.$archivo.'" target=_blank><img name="fotoB" id="foto" src="'.$archivo.'" style="width:100%; border-radius:10px;"></a>';
        } else {
            echo '<img name="" id="foto" src="icon/vnofoto2.jpg" style="width:100%; border-radius:10px;">';
        }
        echo '<br><br><a  style="font-size:8pt;" href="formatoServicioIndividual.php?clave_servicio='.$f2['Clave_servicio'].'&id='.$IdVehiculo.'" target=_blank><img name="" id="" src="icon/pdf.png" style="width:18px;">Imprimir Servicio</a>';
        echo "</td>";
        echo "<td>";
        FormElement_input("Clave de Servicio ",$f2['Clave_servicio'],"", "","text","", TRUE);
        FormElement_input("Fecha de Solicitud",date_format( date_create($f2['Fecha_solicitud']), 'd-m-Y'),"", "","text","", TRUE);
        FormElement_input("Fecha de ejecucion",date_format( date_create($f2['Fecha_ejecucion']), 'd-m-Y'),"", "","text","", TRUE);
        FormElement_input("Km_prog",$f2['Km_prog'],"", "","number","", TRUE);
        FormElement_input("Km_real",$f2['Km_real'],"", "","number","", TRUE);
        FormElement_input("Num. de solicitud",$f2['num_solicitud'],"", "","text","", TRUE);
        FormElement_input("Num. de Factura",$f2['num_factura'],"", "","text","", TRUE);
        FormElement_input("Proveedor",$f2['Proveedor'],"", "","text","", TRUE);    
        FormElement_input("Costo de mano de obra",Pesos($f2['Costo_mano_obra']),"", "","text","", TRUE);
        FormElement_input("Costo de refaccion",Pesos($f2['Costo_refaccion']),"", "","text","", TRUE);
        FormElement_input("Importe Total Factura",Pesos($f2['Importe_factura']),"", "","text","", TRUE);
        FormElement_input("TipoServicio",$f2['TipoServicio'],"", "","text","", TRUE);
        FormElement_textarea("Descripcion",$f2['Descripcion'],"", "","text","", TRUE);
        echo "</td>";
        echo "</tr>";
        echo "</table>";

        $archivo = 'fotos_vehiculos/'.$IdVehiculo.'_'.$f2['Clave_servicio'].'.pdf';
        if (file_exists($archivo)){
            echo '<a href="'.$archivo.'" target=_blank><img name="" id="" src="icon/pdf.png" style="width:18px;">Documento de apoyo</a>';
        } else {
            // echo '<img name="fotoB" id="foto" src="icon/vnofoto2.png" style="width:100%; border-radius:10px;">';
        }
        

        // echo "<button class='btn btn-warning' onclick='CancelarBitacora(".$f2['Clave_servicio'].");'>Cancelar esta Bitacora</button>";

        echo "</div>";
    }
    unset($r2, $f2,$sqlB);














//Bitacora nueva:

//echo '<div style="width:100%; text-align:center;"></div>';
// echo '<div style="width:100%; text-align:center;"></div>';


echo '<br><div id="Botones" style="text-align:center;">';
echo '<a href="?newb=&id='.$IdVehiculo.'" class="btn btn-danger" style="margin-top: -1pt;">Nueva Bitacora</a>';
echo '<a style="color: white;text-decoration: unset; margin:10pt;" href="formatoServicioIndividual.php?clave_servicio=0&id='.$IdVehiculo.'" class="Mbtn btn-Gray" >Formato en Blanco</a>';
echo '</div>';

?>