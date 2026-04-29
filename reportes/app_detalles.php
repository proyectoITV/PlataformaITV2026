<?php
include("head.php");
include("header.php");
$IdAceiteLote = VarClean($_GET['id']);
$IdRegreso = VarClean($_GET['back']);
$Tipo = VarClean($_GET['tipo']);
$ClaveDelProducto = Procimart_ClaveProducto($Tipo);
$ClaveDelProducto_id_rep = ClaveDelProducto_id_rep($ClaveDelProducto);
$id_rep = $ClaveDelProducto_id_rep; //Consulta para esa clave de producto



$QueryEncabezado = "
    Select 
    ISNULL(Aldehidos,'') as Aldehidos
    ,ISNULL(Fruta, '') as Fruta
    ,ISNULL(CONVERT(varchar(50), IdAceiteLote), 0) as IdAceiteLote
    ,ISNULL(Tipo, '') as Tipo    
    ,ISNULL(Fecha, '') as Fecha
    ,ISNULL(Lote,'') as Lote
    ,ISNULL(Aldehidos,'') as Aldehidos
    ,ISNULL(Envasado,'') as Envasado
    ,ISNULL(CONVERT(varchar(50), Produccion),'') as Produccion
    ,ISNULL(CONVERT(varchar(50), Utilizados),'') as Utilizados
    ,ISNULL(InventarioFinal,'') as InventarioFinal
    ,ISNULL(Estatus, '') as Estatus
    ,ISNULL(TiempoAlmacen,'') as TiempoAlmacen
    ,ISNULL(KgMezcla,'') as KgMezcla
    ,ISNULL(ValorDeUnidad,'') as ValorDeUnidad
    ,ISNULL(UnidadDeMedida,0) as UnidadDeMedida
    from InventarioDeAceites('Kilogramos',1) 

    WHERE IdAceitelote='".$IdAceiteLote."' and Tipo='".$Tipo."'
";

$IdCon = 2;
$WSSQL = "select * from dbs where IdCon='".$IdCon."' AND Active=1 AND ConType =2"; //SQLSERVERTOJSON
$WSCon = $db0 -> query($WSSQL);

if($WSConF = $WSCon -> fetch_array())
{
    if ($WSConF['wsurl'] <>'' &&  $WSConF['wsmethod']<>'' && $WSConF['wsjson']<>'' )    
    {
        $WSurl = $WSConF['wsurl'];
        $WSmethod = $WSConF['wsmethod'];
        $WSjson = $WSConF['wsjson'];
        $WSparametros = $WSConF['parametros'];

        $wsP1_id = $WSConF['wsP1_id'];  $wsP1_value = $WSConF['wsP1_value'];
        $wsP2_id = $WSConF['wsP2_id'];  $wsP2_value = $WSConF['wsP2_value'];
        $wsP3_id = $WSConF['wsP3_id'];  $wsP3_value = $WSConF['wsP3_value'];
        $wsP4_id = $WSConF['wsP4_id'];  $wsP4_value = $WSConF['wsP4_value'];
        $WS_Val = TRUE;        
        $url = $WSurl;            
        $sql = $QueryEncabezado;
        $token = $wsP1_value;

        //Peticion
        $myObj = new stdClass;
        $myObj->token = $token;
        $myObj->sql = $QueryEncabezado;
        $myJSON = json_encode($myObj,JSON_UNESCAPED_SLASHES);
        
        $datos_post = http_build_query(
            $myObj
        );

        $opciones = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $datos_post
            )
        );
        ini_set('max_execution_time', 7000);
        ini_set('max_execution_time', 0);
        $context = stream_context_create($opciones);            
        $archivo_web = file_get_contents($url, false, $context);                    
        $data = json_decode($archivo_web);

        $jsonIterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
            RecursiveIteratorIterator::SELF_FIRST
        );
    
        $Der = "";
        // var_dump( $jsonIterator);    
        $TablaDeta = "";
        $row = 0;    
        foreach ($jsonIterator as $key => $val) {
            if (is_numeric($key)){ //rows                        
                $rowC = 0;
            } else {
                switch ($row) {                    
                    case 0:
                        $Der.= "<article class='Tit'>";
                        $Der.= "<b>".$val."</b> ".$key."";
                        $Der.= "</article>";
                        break;
                    case 1:
                        $Der.= "<article class='Sub'>";                        
                        $Der.= "<b title='".$key."'>".$val."</b> ".$Tipo;
                        if ($key =='Fruta'){
                            
                            // Bakcground(" ".$val);
		                    
                        }
                        $Der.= "</article>";
                        break;
                    default:
                        
                        $TablaDeta.= "<tr><td>".$key."</td><td>".$val."</td></tr>";
                        
                        break;
                }
                
                   
                    
                $row = $row + 1;    
            }
             
        }
        $TablaDetaT="<table class='tabla' border=1>".$TablaDeta."</table>";
        
       
           
            
       
        
        
        
        
    }

}
echo "<div style='margin-top:5px; text-align:right; margin-right:5px;'>
<a href='r.php?id=".$IdRegreso."' class='btn btn-secondary' style='font-size:8pt;'><img src='icons/btn_izquierda.png' style='width:18px;'> Regresar</a><br></div>";
echo "<div id='DetallesTitulo'>";

echo $Der."<br>";

echo "<div  id='DetallesTabla' class='row'style='background-color:white; margin:5px; border-radius:4px; margin-top:15px;
width:97%;
display:inline-block;

'>
        <div class='col-sm'>";
        $TipoReporte = 1; $ClaseTabla ="table-striped table-hover"; $ClaseDiv="table container";         
        $Data =  DataFromSQLSERVERTOJSON($id_rep, $TipoReporte, $ClaseTabla, $ClaseDiv, $nitavu);
        echo $Data;
        echo "</div>";
echo "</div>";

echo "</div>";

echo "<div id='DetallesInfo'>";


echo $TablaDetaT;
echo "</div>";

echo "<div style='font-size:7pt; color:gray;'>Id=".$IdAceiteLote.", Tipo=".$Tipo.", ClaveDelProducto=".$ClaveDelProducto.", idReporte=".$id_rep."</div>";



include("footer.php");
?>