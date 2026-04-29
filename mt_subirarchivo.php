
<?php
include ("./lib/body_head.php");
?>
  
<?php
 
$id_aplicacion ="ap71"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){

if(!empty($_FILES['nuevoDoc']['name']) != null){
     
      $descripcion = $_POST['descripcion'];
      $idmunicipio=$_POST['idmunicipio'];
      $idcolonia=$_POST['idcolonia'];
      $idmandante=$_POST['idmandante'];
      $iddesarrollador=$_POST['iddesarrollador'];
      $idprograma=$_POST['idprograma'];
      $idpestaña=$_POST['idpestaña'];
     
      
      $anterior= $_SERVER['HTTP_REFERER'];
      
      $numdocumento = ndocumento(TRUE);
      //$numdocumento=$numdocumento+1;
      $doc = $_FILES["nuevoDoc"]["name"];
      $tmp =$_FILES["nuevoDoc"]["tmp_name"];    
      
      $tipo=obtenertipo($idmunicipio, $idcolonia, $idmandante, $iddesarrollador,$idprograma);
  $url="";
    

  
      //  Le damos un nombre a la pestaña ala que subio el archivo
      if($idpestaña==1)
      {
        $pestaña='Ficha Técnica';
       $url="mt_mesadetrabajo.php?pes=ficha&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador;
      }
      else if($idpestaña==2)
      {
        $pestaña='Plano';
        $url="mt_mesadetrabajo.php?pes=plano&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador;
      }
      else if($idpestaña==3)
      {
        $pestaña='Documento Juridico';
        $url="mt_mesadetrabajo.php?pes=docJuridicos&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador;
      }
      else if($idpestaña==4)
      {
        $pestaña='Tabla';
        $url="mt_mesadetrabajo.php?pes=tabla&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador;
      }
      else if ($idpestaña==5)
      {
        $pestaña='Historial';
        $url="mt_mesadetrabajo.php?pes=historial&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador;
      }
  else if ($idpestaña==6)
      {
        $pestaña='Lotes';
        $url="mt_mesadetrabajo.php?pes=lotes&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador;
      }
     
      $archivo1 = "documentos/".$numdocumento.'_'.$tipo.$idpestaña.'-'.$doc."";
   
      if( ((obtenerextarchivo($doc)[1]=="kmz" || obtenerextarchivo($doc)[1]=="kml"
       || mime_content_type($_FILES["nuevoDoc"]["tmp_name"]) == 'application/pdf'  ) && ($idpestaña==2))   ||
       (( mime_content_type($_FILES["nuevoDoc"]["tmp_name"]) == 'application/pdf'  ) && ($idpestaña==1 || $idpestaña==3 || $idpestaña==4 || $idpestaña==5))   )  
      {
  $subida1 = FTP_subir($tmp,$archivo1);
  
  if ($subida1 == "TRUE")
  {
     
    if(documento_add($numdocumento,$doc,$nitavu,$id_aplicacion)=="TRUE")
    {

      $sql = "INSERT INTO mt_documentos(ndocumento, fecha, nitavu, hora,idmunicipio,idcolonia,idmandante,iddesarrollador,idprograma,pestaña,descripcion)
      VALUES ('$numdocumento',    '$fecha', '$nitavu', '$hora','$idmunicipio','$idcolonia','$idmandante','$iddesarrollador','$idprograma','$idpestaña','$descripcion')";
      if ($conexion->query($sql) == TRUE)
      { 
          if( $tipo=='Programa')
          {
          historia($nitavu,'mt_Subi el archivo: \"'. $doc.'\" a la pestaña \"'. $pestaña.'\" del idprograma:'.$idprograma);
          }else if( $tipo=='Desarrollador')
          {
          historia($nitavu,'mt_Subi el archivo: \"'. $doc.'\" a la pestaña \"'. $pestaña.'\" del desarrollador:'.$iddesarrollador.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
          }
          else if( $tipo=='Mandante')
          {
          historia($nitavu,'mt_Subi el archivo: \"'. $doc.'\" a la pestaña \"'. $pestaña.'\" del mandante:'.$idmandante.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
          }
          else if( $tipo=='Colonia')
          {
          historia($nitavu,'mt_Subi el archivo: \"'. $doc.'\" a la pestaña \"'. $pestaña.'\" de la colonia:'.$idcolonia.' del idmunicipio:'.$idmunicipio);
          }
          ndocumento(FALSE); 
          //notificarParticipantes($id,$nitavu,'El '.$nombreOficio.' se ha agregado al caso','');
          mensaje('Se ha subido el archivo con éxito.',$url."&archivo=".$archivo1);  
      }
      else
      {
      echo $sql;
        //mensaje('Hubo un error al momento de subir el archivo, por favor vuelva a intentarlo.','mt_mesadetrabajo.php');
      }  
    }      
      
  }
  else
  {
    mensaje('Ocurrio un error al momento de subir el archivo.','mt_mesadetrabajo.php');   
  } 


}else
{
  mensaje('Ocurrio un error, el archivo no tiene el formato correcto.',$anterior); 
}
    

      
    
    }
    }
else{mensaje("No tiene acceso a esta aplicacion",'');}
    
  
  ?>