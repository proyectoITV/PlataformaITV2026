<?php
require("seguridad.php");
//*require_once("rintera-config.php");
require("components.php");

require_once("config.php");



$ElToken = VarClean($_POST['Token']);
$IdUser = VarClean($_POST['IdUser']);

$busqueda = VarClean($_POST['busqueda']);

$MiToken = MiToken($IdUser, "Search");
// echo $ElToken."|".$MiToken;
if (MiToken_valida($ElToken, $IdUser, "Search")==TRUE){//Valido

    echo "<h1 style='
        font-size: 16pt;
        text-align: center; 
    '>Resultados de <b>".$busqueda."</b>:</h1>";
    echo "<section id='Reportes'>";

    if ($busqueda == ''){
        $busqueda = UltimaBusqueda($IdUser);
        
        echo "<h3 style='        
        font-size: 12pt;
        text-align: center; 
    
        '>Ultima Busqueda <b>".$busqueda."</b></h3>";
        if ($busqueda == ''){
            $sql = "select * from reportes order by id_rep DESC limit 100";
        } else {
            $sql = "select * from reportes  WHERE
            rep_name like '%".$busqueda."%' or
            rep_description like '%".$busqueda."%' or
            id_rep like '%".$busqueda."%'";
           //* historia_rintera($nitavu, "BUSQUEDAS", "Busco ".$busqueda);
        }

    } else {
        $sql = "select * from reportes  WHERE
        rep_name like '%".$busqueda."%' or
        rep_description like '%".$busqueda."%' or
        id_rep like '%".$busqueda."%'";
    }
    if ($busqueda <> ''){

        GuardaBusqueda($IdUser,$busqueda);
    }
    
    // echo $sql;
   //* $r= $db0 -> query($sql); 
   $r=$conexion -> query($sql);
    $Resultados = 0; $RInfo = "";
    while($f = $r -> fetch_array()) {   
        $Resultados = $Resultados + 1;
        if (PermisoReporte_Ver2($IdUser,$f['id_rep'])==TRUE){
            echo "<article>";
            echo "<table width=100% border=0><tr><td align=center valign=middle>  ";        
            echo "<a href='r.php?id=".$f['id_rep']."'>";
            $RInfo.= "[".$f['rep_name']."=OK] ";
        } else {
            echo "<article style='background-color:#fbeee8;opacity:0.5; cursor: not-allowed;'>";
            echo "<table width=100% border=0><tr><td align=center valign=middle>  ";
            $RInfo.= "[".$f['rep_name']."=X] ";
            
        }

        
        switch ($f['out_type']) {
            case 0: //Pantalla
                if ($f['var1']=='1' || $f['var2']=='1' || $f['var3']=='1'){
                    //PDF Interactivo
                    echo "<img class='icono32' 
                            src='icons/html.png' title='IdReporte=".$f['id_rep']." | "." | Orientacion: ".$f['orientacion']." | Formato: HTML Interactivo. 
                            Este reporte requiere alimentarse con datos proporcionados por el usuario'>";
                } else {//interactivo
                    echo "<img class='icono32' src='icons/html0.png'
                     title='IdReporte=".$f['id_rep']." | "." | Orientacion: ".$f['orientacion'].", Formato:HTML | 
                     '>";
                }
            break;

            
            case 1: //Pantalla
                if ($f['var1']=='1' || $f['var2']=='1' || $f['var3']=='1'){
                    //PDF Interactivo
                    echo "<img class='icono32' 
                            src='icons/datatable.png' title='IdReporte=".$f['id_rep']." | "." | Orientacion: ".$f['orientacion']." | Formato: DataTable Interactivo. 
                            Este reporte requiere alimentarse con datos proporcionados por el usuario'>";
                } else {//interactivo
                    echo "<img class='icono32' src='icons/datatable0.png'
                     title='IdReporte=".$f['id_rep']." | "." | Orientacion: ".$f['orientacion'].", Formato:DataTable | 
                     '>";
                }
            break;
            
            case 2: // PDF
                if ($f['var1']=='1' || $f['var2']=='1' || $f['var3']=='1'){
                    //PDF Interactivo
                    echo "<img class='icono32' 
                            src='icons/pdf2.png' title='IdReporte=".$f['id_rep']." | "." | Orientacion: ".$f['orientacion']." | Formato: PDF Interactivo. 
                            Este reporte requiere alimentarse con datos proporcionados por el usuario'>";
                } else {//interactivo
                    echo "<img class='icono32' src='icons/pdf.png'
                     title='IdReporte=".$f['id_rep']." | "." | Orientacion: ".$f['orientacion'].", Formato:PDF | 
                     '>";
                }
            break;

            case 3:
                if ($f['var1']=='1' || $f['var2']=='1' || $f['var3']=='1'){
                    //PDF Interactivo
                    echo "<img class='icono32' 
                            src='icons/excel2.png' title='IdReporte=".$f['id_rep']." | "." | Orientacion: ".$f['orientacion']." | Formato: Excel Interactivo. 
                            Este reporte requiere alimentarse con datos proporcionados por el usuario'>";
                } else {//interactivo
                    echo "<img class='icono32' src='icons/excel.png'
                     title='IdReporte=".$f['id_rep']." | "." | Orientacion: ".$f['orientacion'].", Formato:Excel | 
                     '>";
                }
            break;

            case 4:
                if ($f['var1']=='1' || $f['var2']=='1' || $f['var3']=='1'){
                    //PDF Interactivo
                    echo "<img class='icono32' 
                            src='icons/word2.png' title='IdReporte=".$f['id_rep']." | "." | Orientacion: ".$f['orientacion']." | Formato: Word Interactivo. 
                            Este reporte requiere alimentarse con datos proporcionados por el usuario'>";
                } else {//interactivo
                    echo "<img class='icono32' src='icons/word.png'
                     title='IdReporte=".$f['id_rep']." | "." | Orientacion: ".$f['orientacion'].", Formato:Word | 
                     '>";
                }
            break;
          
    
        }

        if (PermisoReporte_Ver($IdUser,$f['id_rep'])==TRUE){
        echo "</a>";
        }
        echo "</td><td align=right valign=top width=20px>";
        if (UserAdmin($IdUser)==TRUE){
            echo "<a href='edit.php?id=".$f['id_rep']."' title='Haga clic aquí para editar el Reporte'><img src='icons/mas.png'
            class='iconoMore'
            ></a>";
        }
        
        echo "</td></tr></table>";
        echo "<h4><b>".$f['rep_name']."</b></h4>";
        echo "<cite>".$f['rep_description']."</cite>";


        echo "<table width=100% border=0><tr><td align=left valign=middle>";
        //*if (PermisoReporte_Ver($IdUser,$f['id_rep'])==TRUE){
        if (PermisoReporte_Ver2($IdUser,$f['id_rep'])==TRUE){
            echo "<div style='height:20px;'></div>";
        } else {
            echo "<a target=_blank href='solicita/?id=".$f['id_rep']."' title='Haga clic aqui para imprimir el formato de solicitud'><img src='icons/candado.png' style='width:15px;cursor:pointer;'
            title='Haga clic aquí para solicitar acceso' download> Sin acceso</a>";
        }
        echo "</td><td align=right valign=bottom width=20px>";
        // if (PermisoReporte_Share($IdUser,$f['id_rep'])==TRUE){
        //     echo "<img src='icons/share.png'
        
        // style='
        //     width:13px;
        //     cursor:pointer;
        // '
        // >";
        // } else {
        //     echo "<div  style='
        //         width:13px;
        //         cursor:pointer;
        //     '></div>";
        // }
        echo "</td></tr></table>";
        echo "</article>";
        
    } 
    if ($Resultados <= 0){    
            echo "<p style='
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 10px;
            'class='bg-warning'>Sin Resultados; intentelo con otra palabra </p>";    

            historia_rintera($nitavu, "BUSQUEDAS", "Sin Resultados de ".$busqueda);
    } else {        
        historia_rintera($nitavu, "BUSQUEDAS", "Encontro ".$RInfo." Mientras buscaba ".$busqueda);
    }
    echo "</section>";
} else {    
    
    Toast("Error vuelva a intentarlo",2,"");
}

$sql = "select * from reportes";
//*$rb= $db0 -> query($sql);
$rb= $conexion -> query($sql);
echo '<datalist id="busquedas" class="DataList">';
while($fb = $rb -> fetch_array()) {   
    echo "<option value='".$fb['rep_name']."' class='DataList'>";  

}
echo "</datalist>";


echo "<script> 
$('.InputBusqueda').css('background-color','".Preference("ColorPrincipal", "", "")."');
$('.InputBusqueda').css('color','white');
</script>";

MiToken_Close($IdUser, "Search");             



                  
                 
//Hay que cerrar el Token
?>
