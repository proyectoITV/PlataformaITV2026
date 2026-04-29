<?php
ob_start() ;
require("config.php");
//require_once('/seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');
require('lib/yes_funciones.php');




$sql="Select * From catformapago";
///	echo $sql;
    $rc= $Vivienda -> query($sql);
    $row_cnt = $rc->num_rows;
    
    $cantidad='100';
    $fecharecibo='20210219';
    $nitavu='2269';
        if($row_cnt>0)
        {
          while($datos = $rc -> fetch_array())
          {
            echo 'etnro';
            $folioRecibo=$datos['IdFormaPago'];
            GenerarQRrecibo($folioRecibo,$cantidad,$fecharecibo,$nitavu);
        }        
      }

       
       
  
      ?>
