<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion
$q = $_POST['q']; if (ValidaVAR($q)==TRUE){$q = LimpiarVAR($q);} else {$q = "";}
$nitavu = $_POST['nitavu']; if (ValidaVAR($nitavu)==TRUE){$nitavu = LimpiarVAR($nitavu);} else {$nitavu = "";}

$sql="
    select a.*,
    TIMESTAMPDIFF(YEAR,fecha,CURDATE()) as Antiguedad_Años,
    IF(TIMESTAMPDIFF(YEAR,fecha,CURDATE()) <=0,TIMESTAMPDIFF(MONTH,fecha,CURDATE()),0) as Antiguedad_Meses,
    IFNULL((select GROUP_CONCAT(IdEmpleado) from reporteador_permisos WHERE id_rep = a.id_rep and Estatus = 1),'') as Usuarios,
    (select count(*) from reporteador_Visitas where id_rep = a.id_rep) as Visitas,
    (select fecha from reporteador_Visitas where id_rep = a.id_rep order by fecha DESC limit 1) as UltimaVisita
    from 
    Reporteador_Reportes  a
        where  (nombre like '%".$q."%' OR descripcion like '%".$q."%' OR id_rep = '".$q."') 
order by nombre
";

historia($nitavu,"Busco un reporte con <b>".$q."</b>");
$r= $conexion -> query($sql);
// echo $sql; 
$Antiguedad="";
echo "<h3 style='
margin-top:-34px;
'>Reportes encontrados con <b style='color: #8ac549;'>".$q."</b></h3>";
echo "<table class='tabla'>";
$MiToken = MiToken($nitavu, "REPORTE ".$f['id_rep']." - ".$f['nombre']); 
if ($MiToken == '') { $MiToken =  MiToken_init($nitavu, "REPORTE ".$f['id_rep']." - ".$f['nombre']);}
$Estado = "";
while($f = $r -> fetch_array()) {
    $Permiso = Reporte_TengoPermiso($nitavu, $f['id_rep']);
    
    
    switch ($f['estado']) {
        case 0:
            $Estado = "En construccion";
            echo "<tr style='background-color:purple;cursor:not-allowed;' title='Este reporte se encuentra actualmente en construcción, para mayores informes comuniquese al Dpto. de Informatica'>";    
            break;
        case 1:
            $Estado = "Operativo";
            if ($Permiso == TRUE){
                echo "<tr style=''>";    
            } else {
                echo "<tr style='opacity:0.8; cursor:not-allowed;' title='Actualmente no tiene permiso para ver utilizar este reporte'>";
            }
            break;
        case 2:
            $Estado = "Cancelado";
            echo "<tr style='background-color:red;cursor:not-allowed;' title='Este reporte ya no se encuentra activo'>";    
            break;
    }

    echo "<td width=33px>";
        
    switch ($f['out_type']) {
        case 0:
            if ($f['interactivo']=='0'){//PDF
                echo "<img style='cursor:pointer;width:40px;' src='icon/pdf.png' title='IdReporte=".$f['id_rep']." | Estado: ".$Estado." | ".$f['PageSize']." | Orientacion: ".$f['orientacion']." | Formato: PDF'>";
            } else {//interactivo
                echo "<img style='cursor:pointer;width:40px;' src='icon/pdf2.png' title='IdReporte=".$f['id_rep']." | Estado: ".$Estado." | ".$f['PageSize']." | Orientacion: ".$f['orientacion'].",Formato:PDF | Este reporte requiere alimentarse con datos proporcionados por el usuario'>";
            }
        break;
        
        case 1:
            if ($f['interactivo']=='0'){//PDF
                echo "<img style='cursor:pointer;width:40px;' src='icon/excel.png' title='IdReporte=".$f['id_rep']." | Estado: ".$Estado." | ".$f['PageSize']." | Orientacion: ".$f['orientacion']."| Formato: Excel'>";
            } else {//interactivo
                echo "<img style='cursor:pointer;width:40px;' src='icon/excel2.png' title='IdReporte=".$f['id_rep']." | Estado: ".$Estado." | ".$f['PageSize']." | Orientacion: ".$f['orientacion'].",| Formato: Excel| Este reporte requiere alimentarse con datos proporcionados por el usuario'>";
            }
        break;

        case 2:
            if ($f['interactivo']=='0'){//PDF
                echo "<img style='cursor:pointer;width:40px;' src='icon/pantalla.png' title='IdReporte=".$f['id_rep']." | Estado: ".$Estado." | ".$f['PageSize']." | Orientacion: ".$f['orientacion']."| Formato: Pantalla'>";
            } else {//interactivo
                echo "<img style='cursor:pointer;width:40px;' src='icon/pantalla2.png' title='IdReporte=".$f['id_rep']." | Estado: ".$Estado." | ".$f['PageSize']." | Orientacion: ".$f['orientacion'].",| Formato: Pantalla | Este reporte requiere alimentarse con datos proporcionados por el usuario'>";
            }

        break;

    }
    echo "</td>";
    echo "<td><b style='font-weight:bold; font-size:10pt;'>".$f['nombre']."</b><br><cite>".$f['descripcion']."</cite>";
    if ($f['estado'] == 2){
        echo "<b>Reporte Cancelado.</b><br> <cite>".$f['MotivoCancelacion']."</cite>";
    }
    if ($f['Antiguedad_Años']<=0){
        $Antiguedad = "";
        if ($f['Antiguedad_Meses']>0){
            
            $Antiguedad =$Antiguedad."".$f['Antiguedad_Meses']." meses";
        }
    } else {
        $Antiguedad = $f['Antiguedad_Años']." año";
        if ($f['Antiguedad_Meses']>0){
            
            $Antiguedad =$Antiguedad." y ".$f['Antiguedad_Meses']." meses";
        }
    }

    

    echo "<span style='
    font-family:Compacta; font-size:10pt;
    '><br>Antiguedad: <b>".$Antiguedad."</b>, Visitas: <b>".$f['Visitas']."</b>. ";
    if ($f['UltimaVisita'] <> ''){
        echo "Ultima Visita: <b>".fecha_larga($f['UltimaVisita'])."</b></span>";
    }
    echo "</td>";

    echo "<td align=center width=50px>";

    switch ($f['estado'] ) {
        case 0:
            //En Construccion, solos de informatica
            if (nitavu_dpto($nitavu)==55){
                echo "<a class='Mbtn btn-Warning' style='margin-top: 0px;margin-bottom: 2px;' title='Haz clic aqui para ver el reporte' href='ri_view.php?id_rep=".$f['id_rep']."&token=".$MiToken."'
            
                >";
                echo "<img src='icon/view.png' style='width:32px; filter: drop-shadow(2px 2px 2px #04040473);'>";
    
                echo "</a>";
            }
        break;

        case 1:
            //Operativo
            if ($Permiso == TRUE){
                // echo "OK";
                
                echo "<a class='Mbtn btn-Success' style='margin-top: 0px;margin-bottom: 2px;' title='Haz clic aqui para ver el reporte' href='ri_view.php?id_rep=".$f['id_rep']."&token=".$MiToken."'
            
                >";
                echo "<img src='icon/view.png' style='width:32px; filter: drop-shadow(2px 2px 2px #04040473);'>";
    
                echo "</a>";
            } else {
                if ($f['estado']==1){
                    echo "<a class='Mbtn btn-secundario' rel='MyModal:open' href='#Solicita".$f['id_rep']."'><img src='icon/ayuda2.png' style='width:40px;'></a>";
    
                    echo "<div id='Solicita".$f['id_rep']."' class='MyModal'>
                    <h1>Formas de Solicitar acceso a un reporte, o uno nuevo</h1>
                    <lu>
                    <li> Puede solicitarlo mediante oficio dirigido a la Direccion General con Atencion al Departamento de Informatica</li>
                    <li> Via correo electrónico a <b>juan.pedraza@tam.gob.mx</b>.</li>
                    <li> Via Ticket en la plataforma</li>
                    </lu>
    
                    <p> Es importante que si es para acceder a un reporte de esta lista, debe especificar el Id de Reporte. En este caso este reporte es 
                    <b>".$f['id_rep']."</b>.<br>
                    Para uno nuevo incluya todos los detalles necesarios para elaborarlo.
                    </p>
                    </div>
                    ";
                }
                
            }
        break;

        case 2:
            //Cancelado
            if (nitavu_dpto($nitavu)==55){
            echo "<a class='Mbtn btn-Danger' style='margin-top: 0px;margin-bottom: 2px;' title='Haz clic aqui para ver el reporte' href='ri_view.php?id_rep=".$f['id_rep']."&token=".$MiToken."'
            
                >";
                echo "<img src='icon/view.png' style='width:32px; filter: drop-shadow(2px 2px 2px #04040473);'>";
    
                echo "</a>";
            }
        break;
    }

    
    echo "</td>";
    echo "</tr>";
}
echo "</table>";






?>