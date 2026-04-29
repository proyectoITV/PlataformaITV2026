<?php
include ("./lib/body_head.php");
?>
<?php
$id_aplicacion ="ap66";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

//if (sanpedro($id_aplicacion, $nitavu)==TRUE)
//{

 $idcontrol=$_POST['IdControl'];
 $idcrea=$_POST['IdDptoCrea'];

 //identifico si presiono el boton autorizar
  if (isset($_POST['btnAutorizar'])) 
 {
     
        $tipodocumento=consultaIdTipoDocumento($idcontrol,TRUE); //Obtengo que tipo de documento es (Oficio, Memo o Circular)
        $numero=ndocumentoCorrespondencia(true,nitavu_dpto($nitavu),$tipodocumento);  //Consulto el ultimo número de oficio asigando por Departamento.
        $numero=$numero+1; //sumo 1 a la ultimo número de Oficio al que pertenece

        $numeroCompleto=  $tipodocumento.' No. '.consultaInicialesJerarquia(nitavu_dpto($nitavu)).$numero.'/'.date_format( date_create($fecha), 'Y');
                 $sql = " -- cp 
               UPDATE cp_controlcorrespondencia set autorizado=1 ,fechaautorizado=NOW(),numero=".$numero.",numdocumento='".$numeroCompleto."',iddptofirma=".nitavu_dpto($nitavu)." where id=".$idcontrol;
            
                if ($conexion->query($sql) == TRUE) 
                        {
                            //una vez actualizado la tabla cotrol-correspondencia , entonces si actualizo el numero de docuemento en cat_gerarquia          
                            ndocumentoCorrespondencia(false,nitavu_dpto($nitavu),$tipodocumento);  
                            historia ($nitavu,"cp_Asignó y autorizó el uso del ".$tipodocumento." No. ".$numeroCompleto." al ". dpto_id($idcrea));
                            $msgNoti ="<br> Por medio de la presente se le informa que su solicitud fue atendida y se le ha asignado el  número  <b>". $numeroCompleto ."  a su documento</b>.<br>				
                            Para más información favor de revisar la lista de documentos recientes.
                            <br>";
                          //  notificacion_add ($idcrea, "Asignación de número de documento", date('Y-m-d'), $nitavu,$msgNoti);
                            
                            $sql=" -- cp
                            SELECT  empleados.nitavu, empleados.correoelectronico,empleados.nombre
                            ,(select empleados.nitavu from empleados where nitavu= ".$nitavu.") as nitavuenvia
                            ,(select empleados.correoelectronico from empleados where nitavu= ".$nitavu.") as correoelectronicoenvia
                            ,(select empleados.nombre from empleados where nitavu= ".$nitavu.") as nombreenvia
                            from aplicaciones_permisos	INNER JOIN empleados on aplicaciones_permisos.nitavu=empleados.nitavu
                            where empleados.dpto=".$idcrea." and aplicaciones_permisos.idapp='ap66'"; 
                                                            
                           
        
                            $r2 = $conexion -> query($sql);
                                                                                                              
                             while($fx = $r2 -> fetch_array())
                                {
                                notificacion_add ($fx['nitavu'], 'Número de documento otorgado', date('Y-m-d'), $nitavu,$msgNoti);	
                                //correo($fx['correoelectronico'], nitavu_nombre($fx['nitavu']), $fx['correoelectronicoenvia'], $fx['nombreenvia'],$asunto ,$msgNoti, $fx['nitavu']);				
                                }






                            echo '<script type="text/javascript"> window.location.assign("cp_controldocumental.php");</script>';
                            	
                        } 
                    else 
                        {
                        $msg="¡Error inesperado, no se ha podido dar de alta el concepto!".$sql; //<-- Descripcion de error
                        mensaje($msg,'../cp_controldocumental.php');	 		}   

				
		
			
     } 
     //identifico si presiono el boton cancelar
     else if (isset($_POST['btnRechazar'])) 
     {
     	
        $tipodocumento=consultaIdTipoDocumento($idcontrol,TRUE); //Obtengo que tipo de documento es (Oficio, Memo o Circular)
        $numero=ndocumentoCorrespondencia(false,nitavu_dpto($nitavu),$tipodocumento);  //Consulto el ultimo número de oficio asigando por Departamento. 
        
        //Marco como no autorizada el documento en controlcorrespoendencia
                 $sql = " -- cp 
               UPDATE cp_controlcorrespondencia set autorizado=0 where id=".$idcontrol;
             
                if ($conexion->query($sql) == TRUE) 
                        {                                
                           
                            historia ($nitavu,"cp_Se rechazó la solicitud de". dpto_id($idcrea)."para la asignación un número de documento ");
                            $msgNoti ="<br> Por medio de la presente se le informa que su solicitud para la asignación de numéro de documento fue rechazada.<br>				
                            Para más información favor de revisar la lista de documentos recientes o hablar con personal de su dirección..
                            <br><br>";

                            $sql=" -- cp
                            SELECT  empleados.nitavu, empleados.correoelectronico,empleados.nombre
                            ,(select empleados.nitavu from empleados where nitavu= ".$nitavu.") as nitavuenvia
                            ,(select empleados.correoelectronico from empleados where nitavu= ".$nitavu.") as correoelectronicoenvia
                            ,(select empleados.nombre from empleados where nitavu= ".$nitavu.") as nombreenvia
                            from aplicaciones_permisos	INNER JOIN empleados on aplicaciones_permisos.nitavu=empleados.nitavu
                            where empleados.dpto=".$idcrea." and aplicaciones_permisos.idapp='ap66'"; 
                                                            
                           
        
                            $r2 = $conexion -> query($sql);
                                                                                                              
                             while($fx = $r2 -> fetch_array())
                                {
                                notificacion_add ($fx['nitavu'], 'Se rechazó la solicitud de un nuevo número de documento', date('Y-m-d'), $nitavu,$msgNoti);	
                                //correo($fx['correoelectronico'], nitavu_nombre($fx['nitavu']), $fx['correoelectronicoenvia'], $fx['nombreenvia'],$asunto ,$msgNoti, $fx['nitavu']);				
                                }

                            echo '<script type="text/javascript"> window.location.assign("cp_controldocumental.php");</script>';
                            	
                        } 
                    else 
                        {
                        $msg="¡Error inesperado, no se ha podido dar de alta el concepto!".$sql; //<-- Descripcion de error
                        mensaje($msg,'cp_controldocumental.php');	 		}   

          

     }
     else if (isset($_POST['btnCancelar'])) 
     
     	{
        $tipodocumento=consultaIdTipoDocumento($idcontrol,TRUE); //Obtengo que tipo de documento es (Oficio, Memo o Circular)
        $numero=ndocumentoCorrespondencia(false,nitavu_dpto($nitavu),$tipodocumento);  //Consulto el ultimo número de oficio asigando por Departamento. 
        
        //Marco como no autorizada el documento en controlcorrespoendencia
                 $sql = " -- cp 
               UPDATE cp_controlcorrespondencia set utilizado=3 where id=".$idcontrol;
             
                if ($conexion->query($sql) == TRUE) 
                        {                                
                           
                            historia ($nitavu,"cp_Se canceló el número de Oficio ".$numero.".");
                          

                            
                            $msg="¡Número de oficio cancelado correctamente!"; //<-- Descripcion de error
                            mensaje($msg,'cp_controldocumental.php');	 	
                        	}  
                            	
                         
                    else 
                        {
                        $msg="¡Error inesperado, no se ha podido dar de alta el concepto!".$sql; //<-- Descripcion de error
                        mensaje($msg,'cp_controldocumental.php');	 		
                    }   

                

     }
  //  }
     	
//else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;}

    ?>
 