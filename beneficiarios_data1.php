<?php
require("lib/seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion


$q = "";
if (isset($_POST['q']) and isset($_POST['user'])){
    $nitavu = $_POST['user'];
    $busqueda = $_POST['q'];
    $del =$_POST['del'];
        /* $sql="    
    select * from solicitantes WHERE (UPPER(isnull(solicitantes.Nombre,'')) +' '+ UPPER(isnull(solicitantes.Paterno,''))+' '+ UPPER(isnull(solicitantes.Materno,'')))
    like '%'+(UPPER('".$busqueda."')+'%') "; */

$sql="select isnull(IdDelegacion,0)as IdDelegacion,isnull(Delegacion,'')as Delegacion,isnull(IdPrograma,'')as IdPrograma,isnull(Programa,'') as Programa,
isnull(Folio,'')as Folio,isnull(NumContrato,'') as NumContrato,
isnull(Paterno,'') as Paterno ,isnull(Materno,'')as Materno, isnull(Nombre,'')as Nombre,isnull(NombreCompleto,'')as NombreCompleto,
isnull(Colonia,'') as Colonia ,isnull(manzana,'') as manzana ,isnull(lote,0) as lote, Cancelado
from busqueda_vivienda_informacioncontratos 
WHERE (UPPER(isnull(Nombre,'')) +' '+ UPPER(isnull(Paterno,''))+' '+ UPPER(isnull(Materno,''))) like '%'+(UPPER('".$busqueda."')+'%')
or NumContrato = '".$busqueda."'
"; 

// echo $del.'-'.$sql.'<br>';
    
    historia($_POST['user'],"Beneficiarios: busco a ".$busqueda);  
    
    $ConsultaDATA = DatosViviendaLarge( $del, "WS", "Test1",  $sql);  
   			
    $array = json_decode($ConsultaDATA, true);


if(is_array($array))
                {
                    
                  //  echo "<center><div id='peticiones' style='border: 0px; width:90%;'>";
                    foreach ($array as $f) 
                    {
                       
                    if($f['r']<>'Sin resultados'  or $f['r']<>'Sin conexion')
                    {
                         
                       if($f['Nombre']<>'')
                       {
                        $cont=0;
                        // resultado de la busqueda.................
                        $cont=$cont+1;
                        echo "<center>";
                        echo "<div id='resultado_elemento'  >";			 
                        echo "<table border='0'>";
                        echo "<tr>";							  
                                echo "<td style=' width:10px; text-align: left;' class='tipo_menu'>";                              
                                echo " </td>";
                                echo "<td width='90%' class='tipo_nitavu'>";								
                                echo "<table border='0'>";
                                echo "<tr>";							
                                echo "<td>";
                                echo "<span class='normal tmediano'>".$f['Nombre']." ".$f['Paterno']." ".$f['Materno']."</span>";                                
                                echo "<span class='pc tchico'><br>".$f['NumContrato']."</span>";
                                echo "<span class='pc tchico'><br>".$f['Delegacion']." - ".$f['Programa']." </span>";  
                                if($f['Colonia']<>''){
                                echo "<span class='pc tchico'><br>COLONIA:".$f['Colonia']." M: ".$f['manzana']." L: ".$f['lote']." </span>";  
                                }
                                if($f['Cancelado']!='False')
                                {
                                  echo "<span class='pc tchico'  style='color:red;'><br><b>CANCELADO </b></span>";
                                }
                                echo "</td>";
                                echo "</tr>";
                                echo "</table>";                                
                                echo "</td>";	
                                echo "<td style='text-align: right; width='10px;'  class='tipo_menu'>";         
                                echo "<a title='Haz clic aqui para ver el Estado de Cuenta' target=_blank href='estadodecuenta.php?contrato=".$f['NumContrato']."&del=".$f['IdDelegacion']."'><img src='icon/entrar.png' class='icono' title='Ver estado de cuenta'></a>";
                                echo " </td>";                              
                                echo " </td>";			
                        echo "</tr></table>";
                        echo "</div>";
                        echo "</center>";
                       }				
                      }else
                      {
                        echo $f['r']." en la delegación ".DelegacionNombre($del);



                        
                      }
                    }
                                    
                        //echo "</div>";
            






    
    //}
}
else
{ 
    //echo DelegacionNombre($del);
     //echo "No hay resultados!!".$del;
     echo "<script>
      NPush('No fue posible acceder ".DelegacionNombre($del)."','Plataforma ITAVU');
      $.toast({
        heading: 'Error',
        text: 'No fue posible acceder a ".DelegacionNombre($del).", intente mas tarde o reportelo al Dpto. de Informatica',
        showHideTransition: 'fade',
        icon: 'error'
      });

      habla('".nombre_corto($nitavu,0)."!, No fue posible acceder a ".DelegacionNombre($del).".');
     </script>";
     
}


        
        
} else {echo "ERROR";}
       
    




















?>

