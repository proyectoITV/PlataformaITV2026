
<?php 	//require("seguridad.php"); ?>
<?php 	require("unica/funciones.php"); ?>
<?php 	require("unica/cano_funciones.php"); ?>
<?php 	require("unica/laura_funciones.php"); ?>
<?php 	require("unica/yes_funciones.php"); ?>
<?php 	require("unica/config.php"); ?>


<?php
//FUNCION PARA RECIBIR NOTIFICACIONES DESDE VB6 MEDIANTE URL
if (isset($_GET['ingreso']) and isset($_GET['del']) and isset($_GET['prog']) and isset($_GET['tipo']) and isset($_GET['nitavu']) and isset($_GET['coment'])){      
    $ingreso= $_GET['ingreso'];
    $IdDelegacion=$_GET['del'];
    $IdPrograma=$_GET['prog'];
    $Tipo = $_GET['tipo'];
    $nitavu = $_GET['nitavu'];
    $comentario = $_GET['coment'];
    
    //URL:
    // https://plataformaitavu.tamaulipas.gob.mx/ingresos_url.php?nitavu=119460&ingreso=1000&del=6&prog=23&tipo=C&comment=desdelaipyenviadodesdevivienda
        $sql = "INSERT INTO ingresos_vivienda (IdDelegacion, IdPrograma, fecha, hora,  ingresos, tipo, nitavu, comentario) VALUES ('$IdDelegacion', 
        '$IdPrograma', '$fecha', '$hora', '$ingreso', '$Tipo', '$nitavu', '$comentario')";	
		
		if ($conexion->query($sql) == TRUE)
		{
            $m="Se registraron ingresos en la Delegacion ".delegacion_id($IdDelegacion)." por $".$ingreso." del Programa ".programa_nombre($IdPrograma)." 
            del tipo ".$Tipo;            
            $m="<p style=background-color:#FFCCFF;color:#6A006A;border:1px solid #FF55FF;border-radius:5px;padding:4px;font-size:8pt;>".$m."</p>";
            historia($nitavu, $m);
            notificacion_add ('119460', 'chat', $fecha, $nitavu, $m);
            notificacion_add ('1733', 'chat', $fecha, $nitavu, $m);
            notificacion_add ('1511', 'chat', $fecha, $nitavu, $m);
            notificacion_add ('1739', 'chat', $fecha, $nitavu, $m);
            notificacion_add ('1308', 'chat', $fecha, $nitavu, $m);
            notificacion_add ('2269', 'chat', $fecha, $nitavu, $m);
            notificacion_add ('1533', 'chat', $fecha, $nitavu, $m);
        //    echo $m;
        }else{//si nos marca error hacemos un update
            $sql="UPDATE ingresos_vivienda SET 
            IdDelegacion='".$IdDelegacion."',
            IdPrograma='".$IdPrograma."',
            fecha='".$fecha."',
            hora='".$hora."',
            IdDelegacion='".$ingreso."',
            IdDelegacion='".$Tipo."',
            nitavu='".$nitavu."',
            comentario='".$comentario."'
            WHERE IdDelegacion='".$IdDelegacion."' AND IdPrograma='".$IdPrograma."' AND fecha='".$fecha."'";
            if ($conexion->query($sql) == TRUE)
            {
                $m="Se actualizaron ingresos en la Delegacion ".delegacion_id($IdDelegacion)." por $".$ingreso." del Programa ".programa_nombre($IdPrograma)." 
                del tipo ".$Tipo;            
                $m="<p style=background-color:#FFCCFF;color:#6A006A;border:1px solid #FF55FF;border-radius:5px;padding:4px;font-size:8pt;>".$m."</p>";
                historia($nitavu, $m);
                notificacion_add ('119460', 'chat', $fecha, $nitavu, $m);
                notificacion_add ('1733', 'chat', $fecha, $nitavu, $m);
                notificacion_add ('1511', 'chat', $fecha, $nitavu, $m);
                notificacion_add ('1739', 'chat', $fecha, $nitavu, $m);
                notificacion_add ('1308', 'chat', $fecha, $nitavu, $m);
                notificacion_add ('2269', 'chat', $fecha, $nitavu, $m);
                notificacion_add ('1533', 'chat', $fecha, $nitavu, $m);
          //      echo $m;

            }else {historia($nitavu,"Error al guardar ingresos ".$sql);
                }      
            
            
            }    
        } else {echo "no esta bien la url";  }
            
            
        
    




?>
