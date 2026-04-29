<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

$id_aplicacion = 'ap98';
xd_update('ap98',$nitavu);//guarda la experiencia del usuario
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    if (isset($_GET['Frac'])){
    //if (isset($_GET['Fracc'])){    
        historia($nitavu,"Dupport: Consulto el Fraccionamiento ".$_GET['Frac']);
        $sql="
        select
        (select dupport_clientes.Nombre from dupport_clientes WHERE ClvCliente = a.ClvCliente) as ClienteNombre,
        (select nomFraccionamiento from dupport_fraccionamientos WHERE Fraccionamiento = a.Fraccionamiento) as NombreFraccionamiento,
        CONCAT('<a href=dupport.php?contrato=',a.NoContrato,'>',a.NoContrato,'</a>') as NoContrato,
        
        a.* from dupport_lotes a 
        WHERE Fraccionamiento='".$_GET['Frac']."'
    ";
    
    echo "<div id='contratos' style='
    width:90%;
    padding:10px;
    display:inline-block;
    background-color:#fef8ed;
    '>";
    echo "<h1 >Lotes de Dupport Frac. ".$_GET['Frac'].":</h1>";
    TablaDinamica_MySQL("",$sql, "Clientes", "IdTabla2", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal


    } else {
    if (isset($_GET['lote'])){
        historia($nitavu,"Dupport: Consulto el Lote ".$_GET['lote']);
        $sql="
                
        select 
        CONCAT('<a href=dupport.php?lote=',a.ID,'>',a.ID,'</a>') as IdLote,
        (select nomFraccionamiento from dupport_fraccionamientos WHERE Fraccionamiento = a.Fraccionamiento) as NombreFraccionamiento,
            a.*
        from dupport_lotes a

    

        WHERE ID = '".$_GET['lote']."' 
        ";
        // echo $sql;
        echo "<hr><div id='contratos' style='
        width:90%;
        padding:10px;
        display:inline-block;
        background-color:#efefefe;
        margin-top:10px;
        '>";
        echo "<h1>Lote: ".$_GET['lote']."</h1>";
        TablaDinamica_MySQL("",$sql, "Clientes2242", "IdTabla24222", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
        echo "</div>";
    } else {
        
            if (isset($_GET['cliente'])){
                historia($nitavu,"Dupport: Consulto al cliente ".$_GET['cliente']);

                $sql="
                select 
                        a.*
                        from dupport_clientes a
                WHERE ClvCliente = '".$_GET['cliente']."' ";

                
                // echo $sql;
                echo "<div id='contratos' style='
                width:90%;
                padding:10px;
                display:inline-block;
                background-color:#fdf8ed;
                '>";
                echo "<h1>Cliente: ".$_GET['cliente']."</h1>";
                TablaDinamica_MySQL("",$sql, "Clientes", "IdTabla2", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                echo "</div>";


                $sql="
                    
                select 
                (select nomFraccionamiento from dupport_fraccionamientos WHERE Fraccionamiento = a.Fraccionamiento) as NombreFraccionamiento,
                a.*
                from dupport_lotes a
                WHERE ClvCliente = '".$_GET['cliente']."' ";


                // echo $sql;
                echo "<div id='contratos' style='
                width:90%;
                padding:10px;
                display:inline-block;
                background-color:#dfeccf;
                margin-top:10px;
                '>";
                echo "<h1>Lotes detectados del cliente con clave: ".$_GET['cliente']."</h1>";
                TablaDinamica_MySQL("",$sql, "Clientes2", "IdTabla22", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                echo "</div>";
            }
            else{
                if (isset($_GET['contrato'])){
                    historia($nitavu,"Dupport: Consulto el contrato ".$_GET['contrato']);


                    $sql="
                        
                    select 
                    CONCAT('<a href=dupport.php?cliente=',a.ClvCliente, '>', a.ClvCliente, '</a>') as ClvCliente, 
                    
                    
                    (select Nombre from dupport_clientes WHERE ClvCliente = a.ClvCliente) as NombreCliente,
                    
                    a.*
                    from dupport_contratos a
                    WHERE NoContrato = '".$_GET['contrato']."' ";
                    // echo $sql;
                    echo "<div id='contratos' style='
                    width:90%;
                    padding:10px;
                    display:inline-block;
                    background-color:#fdf8ed;
                    '>";
                    echo "<h1>Contrato: ".$_GET['contrato']."</h1>";
                    TablaDinamica_MySQL("",$sql, "Clientes", "IdTabla2", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                    echo "</div>";


                    $sql="
                        
                    select 
                        NoPago,
                        a.*
                    from dupport_pagos a
            
                

                    WHERE NoContrato = '".$_GET['contrato']."' 
                    order by FechaCobro";
                    //order by NoPago";
                    // echo $sql;
                    echo "<div id='contratos' style='
                    width:90%;
                    padding:10px;
                    display:inline-block;
                    background-color:#dfeccf;
                    margin-top:10px;
                    '>";
                    echo "<h1>Pagos detectados del Contrato: ".$_GET['contrato']."</h1>";
                    TablaDinamica_MySQL("",$sql, "Clientes2", "IdTabla22", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                    echo "</div><hr>";


                    $sql="
                        
                    select 
                    
                        a.*
                    from dupport_pagostotales a
            
                

                    WHERE NoContrato = '".$_GET['contrato']."' 
                    ";
                    // echo $sql;
                    echo "<hr><div id='contratos' style='
                    width:90%;
                    padding:10px;
                    display:inline-block;
                    background-color:#d3d3f9;
                    margin-top:10px;
                    '>";
                    echo "<h1>Pagos Totales del Contrato: ".$_GET['contrato']."</h1>";
                    TablaDinamica_MySQL("",$sql, "Clientes227642", "IdTabla2674222", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                    echo "</div>";

                    
                    $sql="
                        
                    select 
                    
                        a.*
                    from dupport_contratos_fml a
            
                

                    WHERE NoContrato = '".$_GET['contrato']."' 
                    ";
                    // echo $sql;
                    echo "<hr><div id='contratos' style='
                    width:90%;
                    padding:10px;
                    display:inline-block;
                    background-color:#d3d3d9;
                    margin-top:10px;
                    '>";
                    echo "<h1>Contrato (fml): ".$_GET['contrato']."</h1>";
                    TablaDinamica_MySQL("",$sql, "Clientes2275642", "IdTabla26742522", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                    echo "</div>";

                    $sql="
                        
                    select 
                    
                        a.*
                    from dupport_escrituracion a
            
                

                    WHERE noContrato = '".$_GET['contrato']."' 
                    ";
                    // echo $sql;
                    echo "<div id='contratos' style='
                    width:90%;
                    padding:10px;
                    display:inline-block;
                    background-color:#f9ebfd;
                    margin-top:10px;
                    '>";
                    echo "<h1>Escrituracion: ".$_GET['contrato']."</h1>";
                    TablaDinamica_MySQL("",$sql, "Clientes22", "IdTabla222", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                    echo "</div>";



                    
        $sql="
                        
                    select 
                    
                        a.*
                    from dupport_liberacion a
            
                

                    WHERE noContrato = '".$_GET['contrato']."' 
                    ";
                    // echo $sql;
                    echo "<hr><div id='contratos' style='
                    width:90%;
                    padding:10px;
                    display:inline-block;
                    background-color:#fdfceb;
                    margin-top:10px;
                    '>";
                    echo "<h1>Liberacion: ".$_GET['contrato']."</h1>";
                    TablaDinamica_MySQL("",$sql, "Clientes2252", "IdTabla52222", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                    echo "</div>";

                    $sql="
                        
                    select 
                    CONCAT('<a href=dupport.php?lote=',a.ID,'>',a.ID,'</a>') as IdLote,
        (select nomFraccionamiento from dupport_fraccionamientos WHERE Fraccionamiento = a.Fraccionamiento) as NombreFraccionamiento,
                        a.*
                    from dupport_lotes a
            
                

                    WHERE noContrato = '".$_GET['contrato']."' 
                    ";
                    // echo $sql;
                    echo "<hr><div id='contratos' style='
                    width:90%;
                    padding:10px;
                    display:inline-block;
                    background-color:#efefefe;
                    margin-top:10px;
                    '>";
                    echo "<h1>Lotes del Contrato: ".$_GET['contrato']."</h1>";
                    TablaDinamica_MySQL("",$sql, "Clientes2242", "IdTabla24222", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                    echo "</div>";


                    $sql="
                        
                    select 
                    
                        a.*
                    from dupport_acuerdos a
            
                

                    WHERE NoContrato = '".$_GET['contrato']."' 
                    ";
                    // echo $sql;
                    echo "<hr><div id='contratos' style='
                    width:90%;
                    padding:10px;
                    display:inline-block;
                    background-color:#d3dbf9;
                    margin-top:10px;
                    '>";
                    echo "<h1>Acuerdos del Contrato: ".$_GET['contrato']."</h1>";
                    TablaDinamica_MySQL("",$sql, "Clientes22742", "IdTabla274222", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                    echo "</div>";



                } else {
                // contenido:
                historia($nitavu,"Dupport: Consulto la aplicacion ");
                    $sql="
                    SELECT
	CONCAT( '<a href=dupport.php?contrato=', a.NoContrato, '>', a.NoContrato, '</a>' ) AS NoContrato,
	CONCAT( '<a href=dupport.php?cliente=', a.ClvCliente, '>', a.ClvCliente, '</a>' ) AS ClvCliente,
	( SELECT Nombre FROM dupport_clientes WHERE ClvCliente = a.ClvCliente ) AS NombreCliente,
	( SELECT GROUP_CONCAT( CONCAT('<a href=dupport.php?lote=', dupport_lotes.ID,'>', dupport_lotes.ID,'</a>') ) FROM dupport_lotes WHERE ClvCliente = a.ClvCliente ) AS IdLotes 
FROM
	dupport_contratos a
                    ";
                    echo "<div id='contratos' style='
                    
                    padding:10px;
                    display:inline-block;
                    background-color:#fdf8ed;
                    ' class='modulo'>";
                    echo "<h1>Contratos de Dupport</h1>";
                    TablaDinamica_MySQL("",$sql, "Clientes", "IdTabla2", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                    
                    // echo '<hr><a href="dupport.php?Lotes">Ver Lotes</a>';
                    echo "</div>";

                    

                    $sql="
                    select 

                    a.*,
                    (select count(*) from dupport_lotes WHERE Fraccionamiento = a.Fraccionamiento) as Lotes,
                    (select count(*) from dupport_lotes WHERE Fraccionamiento = a.Fraccionamiento and NoContrato = '') as LotesNoContratados
                    
                    
                    from dupport_fraccionamientos a
                    
                    
                    
                    




                    ";
                    echo "<div class='modulo'>
                    <h1>Fraccionamientos Dupport:</h1>
                    <table class='tabla'>";
                    $r= $conexion -> query($sql);
                    while($f = $r -> fetch_array()) {
                        echo "<tr>";
                        echo "<td><a href='dupport.php?Frac=".$f['Fraccionamiento']."'>".$f['nomFraccionamiento']."</a></td>";
                        echo "<td>".$f['Lotes']."</td>";
                        echo "<td>".$f['LotesNoContratados']."</td>";

                        echo "<tr>";


                    }
                    echo "</table></div>";
                    
                }
            }
    }
}
}
else {
    mensaje("ERROR: no tiene acceso a esta aplicacion",'./index.php?home=');
}

?>



<?php
include ("./lib/body_footer.php");
?>



