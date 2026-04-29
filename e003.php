<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php"); include ("./lib/body_menu.php");


?>
<?php
$id_aplicacion ="ap109"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);


if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
   xd_update('ap109',$nitavu);//guarda la experiencia del usuario
   historia($nitavu, "Entro a la aplicacion [ap109], para consultar las escrituras.");




/*DIRECCIONES*/
// 10- Dir. Jurídica y Seguridad Patrimonial
// 19- Coordinacion de Delegaciones
// 46- Dir. de Programas de Suelo y Vivienda
// 54- Direccion de Administracion y Finanzas


if(isset($_GET['contrato']))
{

   echo "<br>";
   echo "<br>";
   $sql =" -- esc
   select    NumContrato,   Delegacion,   IdMunicipio,   Municipio,   Colonia,   Seccion,   Fila,   Manzana,   Lote,   NombreBeneficiario,  idLote, NumEscritura
   from    vivienda_tramitesdeescritura
   WHERE NumContrato like '%".$_GET['contrato']."%'";
   //echo $sql;

	$rc= $Vivienda -> query($sql);
	$row_cnt = $rc->num_rows;
		$cont=0;
		if($row_cnt>0)
		{
		  while($valor = $rc -> fetch_array())
		  {
        /*VARIABLES*/
        $numcontrato =$valor['NumContrato'];
        $beneficiario = $valor['NombreBeneficiario']; 
        $numescritura = $valor['NumEscritura'];
        $idlote = $valor['idLote']; 
        
        
        $direccion=quienEsmiDireccion(nitavu_dpto($nitavu));    
           
        $estatus=ObtenerEstatusTramiteEscritura($direccion,$valor['NumEscritura']);

            echo "<section id='aplicacionesReq'>";
            //  echo "<div class='sombra' style='width: 95%; background-color:white;'>";
            echo "<br><h1>Información General</h1><br>";
            echo DivDatosTramiteEscritura($numcontrato,$direccion);
            echo "<br>";
		    echo "</section>";
					
					
         /*
        NIVELES:
         1- OPERADOR(PUEDE REALIZAR ALGUNA ACCION, SEGUN EL PERMISO,  NO MUESTRA COMENTARIOS DE JURIDICO Y TAMPOCO AQUELLAS ACCIONES QUE NO SEAN VISIBLES PARA ESA DIRECCION)
         2.-CONSULTA (NO SE MUESTRAN COMENTARIOS DE JURIDICO Y TAMPOCO AQUELLAS ACCIONES QUE NO SEAN VISIBLES PARA ESA DIRECCION)
         3.-CONSULTA FULL (VISTA TIPO AREA JURIDICA,COMENTARIOS Y TODO EL PROCESO)
        */

          /*IDENTIFICAMOS SI ES UN OPERADOR, SI ES ASI SE MUESTRA EL PANEL DE OPCIONES QUE PUEDE REALIZAR EL USUARIO.
          OJO.- LOS OPCIONES QUE APREZCAN SERÁ DEPENDIENDO SI EL USUARIO TIENE O NO EL PERMISO.(PERMISOS_ACCIONES)*/
         if ($nivel==1 and (DireccionParticipaEnEscritura($direccion)!='NO PARTICIPA') )
			 	  {
            echo "<section id='aplicacionesReq' name='BotonesOp'>";	
            echo "<br><h1>Opciones</h1><br>";          
            echo "<form  action='e004.php' method='POST' >"; 
            echo "<input type='hidden' name='idlote' id='idlote' value='".$idlote."' >" ;        
            echo "<div style='width: 100%' id='opciones'name='opciones'>";     
             
            //PERMISOS          
              $aprobar=SePuedeAprobarTramite($direccion,1,$numescritura);  
              echo $estatus;
              echo $aprobar;
              if(TienePermisoParaAccion(5,$nitavu,$id_aplicacion)!='FALSE' and ($estatus=='PENDIENTE' || $estatus=='EN PAUSA') )
              {	 	   
                echo" <a href='#recepcionTramite' rel='MyModal:open' title='Recepcion de Tramite' class='btn btn-primary'>             												
                <table border='0'><tbody><tr><td width='30px'><img src='icon/recibir.png' ></td>
                <td  valign='middle' align='center'  style='color:white;' class='pc'>Recepción</td></tr></tbody></table></a>"; 
              }

              if(TienePermisoParaAccion(1,$nitavu,$id_aplicacion)!='FALSE' and ($estatus!='APROBADO') and $aprobar==1)
              {	 	   
                echo" <a href='#aprobarTramite' rel='MyModal:open' title='Vobo Tramite' class='btn btn-primary'>              											
                <table border='0'><tbody><tr><td width='30px'><img src='icon/vobo4.png' ></td>
                <td  valign='middle' align='center' style='color:white;' class='pc'>Aprobar</td></tr></tbody></table> </a>"; 
              }
              if(TienePermisoParaAccion(2,$nitavu,$id_aplicacion)!='FALSE' and $estatus!='EN PAUSA' )
              { 
                echo" <a href='#pausarTramite' rel='MyModal:open' title='Pausar Tramite'  class='btn btn-primary'>              			
                <table border='0'><tbody><tr><td width='30px'> <img src='icon/pausar.png'></td>
                <td  valign='middle' align='center' style='color:white;' class='pc'>Pausar</td></tr></tbody></table></a>";
              }
              if(TienePermisoParaAccion(3,$nitavu,$id_aplicacion)!='FALSE' )
              { 
                echo" <a href='#capturaFinca' rel='MyModal:open' title='Captura de Finca y/o Clave Catastral'  class='btn btn-primary'>			
                <table border='0'><tbody><tr><td width='30px'> <img src='icon/capturaFinca.png'></td>
                <td  valign='middle' align='center' style='color:white;' class='pc'>Finca</td></tr></tbody></table></a>";
              }	
              if(TienePermisoParaAccion(4,$nitavu,$id_aplicacion)!='FALSE' )
              { 
                echo" <a href='lot_lotes_edit.php?id=".$idlote."' title='Editar Cartografia'  class='btn btn-primary'>			
                <table border='0'><tbody><tr><td width='30px'> <img src='icon/editarMedidas.png'></td>
                <td  valign='middle' align='center' style='color:white;' class='pc'>Cartografia </td></tr></tbody></table></a>";
              }	
              if(TienePermisoParaAccion(6,$nitavu,$id_aplicacion)!='FALSE'  )
              { 
                echo" <a href='#agregarComentario' rel='MyModal:open' title='Agregar Comentario'  class='btn btn-primary'>              			
                <table border='0'><tbody><tr><td width='30px'> <img src='icon/comentario2.png'></td>
                <td  valign='middle' align='center' style='color:white;' class='pc'>Comentario</td></tr></tbody></table></a>";
              }    
            //echo permisos_acciones($id_aplicacion,$nitavu);                   
            echo "</div>";
            echo "</form>";
            echo "<br>";
            echo "<br>";    
               
              
            echo "</section>";         


          }
                
          echo "<br>";
          echo "<br>";
       
       
      /*IDENTIFICAMOS SI EL TRAMITE ESTA FINALIZADO SI ES PODRA CONSULTAR LA INFORMACION SIN FILTRO*/
       if ($estatus=='FINALIZADO')
       {
          $sql="                
          SELECT -- DATE_FORMAT(FechaOperacion, '%d-%m-%Y') as Fecha, 
          FechaOperacion,                                                            
          CASE WHEN (Estatus='C' AND Actividad !='Sin especificar') THEN CONCAT(Actividad,'--CANCELADA')
          WHEN (Estatus!='C' AND Actividad ='0 SIN ESPECIFICAR' AND Observaciones='Reinicio de ESCRITURA') THEN UPPER('REINICIO DE SOLICITUD' )
          WHEN (Estatus!='C' AND Actividad ='0 SIN ESPECIFICAR' AND Observaciones='Creación de solicitud de escritura') THEN UPPER('Creación de solicitud' )
          WHEN (Estatus!='C' AND Actividad ='0 SIN ESPECIFICAR' 
          AND (Observaciones!='Creación de solicitud de escritura' AND  Observaciones!='Reinicio de ESCRITURA')) THEN UPPER('COMENTARIOS' )
          ELSE UPPER(Actividad) end as Actividad,
          CASE WHEN (IdEmpModifica IS  NULL OR IdEmpModifica='')THEN Operador
          ELSE OperadorModifico END AS Operador,                 
          CASE WHEN (IdAccion =62 OR IdAccion =63 OR IdAccion =64 OR IdAccion =65 OR IdAccion =79 OR IdAccion=80) THEN 
          CONCAT('OFICIO: ',Soporte_sustento)  ELSE Soporte_sustento  END AS '',
          Observaciones AS '',
          Estatus                    
          from 
          vivienda_tramitesescrituraseguimiento
          JOIN    (SELECT @rownum := 0) r
          WHERE NumContrato like '%".$numcontrato."%' 
          AND  ( IdAccion>0 OR  (IdAccion=0 and  Origen='D'))
          ORDER BY FechaOperacion ASC";   
       }     
        else 
        {      
          /*IDENTIFICAMOS SI ES UN OPERADOR O DE CONSULTA (POR AREA), 
          MUESTRA LA CRONOLOGIA RESPATANDO LAS ACCIONES QUE PUEDEN SER VISIBLES O NO POR EL AREA (ESC_SEGUIMIENTOCONF)*/
          if ($nivel==1 OR $nivel==2 )
          {
            $sql="                
            SELECT 
            -- DATE_FORMAT(FechaOperacion, '%d-%m-%Y') as Fecha, 
            FechaOperacion,
            CASE WHEN (Estatus='C' AND Actividad !='Sin especificar') THEN CONCAT(Actividad,'--CANCELADA')
            WHEN (Estatus!='C' AND Actividad ='0 SIN ESPECIFICAR' AND Observaciones='Reinicio de ESCRITURA') THEN UPPER('REINICIO DE SOLICITUD' )
						WHEN (Estatus!='C' AND Actividad ='0 SIN ESPECIFICAR' AND Observaciones='Creación de solicitud de escritura') THEN UPPER('Creación de solicitud' )
						WHEN (Estatus!='C' AND Actividad ='0 SIN ESPECIFICAR' 
						AND (Observaciones!='Creación de solicitud de escritura' AND  Observaciones!='Reinicio de ESCRITURA')) THEN UPPER('COMENTARIOS' )
            ELSE UPPER(Actividad) end as Actividad,
            CASE WHEN (IdEmpModifica IS  NULL OR IdEmpModifica='')THEN Operador
            ELSE OperadorModifico END AS Operador,                 
            CASE WHEN (IdAccion =62 OR IdAccion =63 OR IdAccion =64 OR IdAccion =65 OR IdAccion =79 OR IdAccion=80) THEN 
            CONCAT('OFICIO: ',Soporte_sustento)  ELSE Soporte_sustento  END AS '',
            Observaciones AS '',
            Estatus                    
            from 
            vivienda_tramitesescrituraseguimiento
            JOIN    (SELECT @rownum := 0) r
            WHERE NumContrato like '%".$numcontrato."%' ";
            
            /*  IDENTIFICAMOS SI EL USUARIO TIENE NIEVEL DE CONSULTA   Y ES personal DEL AREA JURIDCA, SOLO PODRÁ CONSULTAR  LA INFORMACIÓN
          COMO SI FUERA UN personal DE OTRA AREÁ.*/
            if(($direccion!=10 ) OR ($direccion==10 AND $nivel==2))
            {
              $sql=$sql." AND (DirVisible LIKE '%".$direccion."%' or DirVisible ='*') ";
              $sql=$sql." AND  ( IdAccion>0 OR  (IdAccion=0 and  Origen='D'))";
            }         
           
           
            $sql=$sql."ORDER BY FechaOperacion ASC";
          }
          /*  IDENTIFICAMOS SI EL USUARIO TIENE NIEVEL DE CONSULTA FULL, ESTE PODRA CONSULTAR TODA LA INFORMACIÓN
          COMO SI FUERA UN personal DEL AREA JURIDICA*/
          else 
          {
            $sql="                
            SELECT -- DATE_FORMAT(FechaOperacion, '%d-%m-%Y') as Fecha, 
            FechaOperacion,                                                            
            CASE WHEN (Estatus='C' AND Actividad !='Sin especificar') THEN CONCAT(Actividad,'--CANCELADA')
            WHEN (Estatus!='C' AND Actividad ='0 SIN ESPECIFICAR' AND Observaciones='Reinicio de ESCRITURA') THEN UPPER('REINICIO DE SOLICITUD' )
						WHEN (Estatus!='C' AND Actividad ='0 SIN ESPECIFICAR' AND Observaciones='Creación de solicitud de escritura') THEN UPPER('Creación de solicitud' )
						WHEN (Estatus!='C' AND Actividad ='0 SIN ESPECIFICAR' 
						AND (Observaciones!='Creación de solicitud de escritura' AND  Observaciones!='Reinicio de ESCRITURA')) THEN UPPER('COMENTARIOS' )
            ELSE UPPER(Actividad) end as Actividad,
            CASE WHEN (IdEmpModifica IS  NULL OR IdEmpModifica='')THEN Operador
            ELSE OperadorModifico END AS Operador,                 
            CASE WHEN (IdAccion =62 OR IdAccion =63 OR IdAccion =64 OR IdAccion =65 OR IdAccion =79 OR IdAccion=80) THEN 
            CONCAT('OFICIO: ',Soporte_sustento)  ELSE Soporte_sustento  END AS '',
            Observaciones AS '',
            Estatus                    
            from 
            vivienda_tramitesescrituraseguimiento
            JOIN    (SELECT @rownum := 0) r
            WHERE NumContrato like '%".$numcontrato."%' 
            ORDER BY FechaOperacion ASC";
          }                     
        }
       
       
        //echo $sql;                	
        echo "<div id='Cronologia' style='background-color:#EEEEEE; width:90%; display:inline-block;
        border-radius:5px; padding:10px; margin-top:20px;'>";
        echo "<h2>Cronología del Trámite</h2>";
        
        TablaDinamica_MySQLVivienda("",$sql, "Cronologia", "CronologiaTablaid", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
        echo "</div>";     
                

      }
                   
                
		}
}



//********************************** Modal Registrar Tramite
echo "<div id='recepcionTramite' class='MyModal'>";
  echo "<center>";
  echo "<h1>Recepción de Trámite</h1>"; 
  echo "<form action='e004.php?Accion=0' method='POST' id='formRecepecion' name='formRecepecion'>";
    echo "<div style='width:100%'>";
      echo "<input type='hidden' name='numescritura' id='numescritura' value='".$numescritura."' >" ;      
      echo "<label for='ObservacionesRecepcion' style='width:80%'>Observaciones</b>:";
      echo "<textarea id='ObservacionesRecepcion' name='ObservacionesRecepcion'style='border-width:1px; height:20% ; width:100%' ></textarea>";    
    echo "</div>";
    echo "<br>";
    echo "<br>";
    echo '<div><input class="Mbtn btn-default" id="boton" type="submit" value="Registrar recepcion"></div>';
    echo "<br>";
  echo "</form>";
  echo "</center>";
echo "</div>";
 //**********************************

//********************************** Modal Aprobar Tramite
echo "<div id='aprobarTramite' class='MyModal'>";
  echo "<center>";  
    echo "<h1>Aprobar Trámite</h1>"; 
  echo "<form action='e004.php?Accion=1' method='POST' id='formAprobar' name='formAprobar'>";
    echo "<div style='width: 100%'>";
      echo "<span class='tenue menu_font_n2'>¿Esta seguro que desea marcar como  <b>APROBADO </b> el trámite de escritura?</span>";
      echo "<input type='hidden' name='numescritura' id='numescritura' value='".$numescritura."' >" ;
           //con número de contrato <b> ".$numcontrato."</b>,  a nombre de <b> ".$beneficiario."</b>
      echo "<label for='ObservacionesAprobar' style='width: 80%'>Observaciones</b>:";
      echo "<textarea id='ObservacionesAprobar' name='ObservacionesAprobar'style='border-width:1px; height:20%' ></textarea>";
      echo "<br>";
      echo "<br>";
    echo "</div>";
    echo '<div><input class="Mbtn btn-default" id="boton" type="submit" value="Aprobar Trámite"></div>';
    echo "<br>";
  echo "</form>";
  echo "</center>";
echo "</div>";
 //**********************************

//********************************** Modal Pausar Tramite
echo "<div id='pausarTramite' class='MyModal'>";
  echo "<center>";
  echo "<h1>Pausar Trámite</h1>"; 
  echo "<form action='e004.php?Accion=2' method='POST' id='formPausar' name='formPausar'>";
    echo "<div>";
      echo "<input type='hidden' name='numescritura' id='numescritura' value='".$numescritura."' >" ;
      echo "<input type='hidden' id='textoArea' name='textoArea' >";
      echo "<label for='ObservacionesNva'>Observaciones</b>:";
      echo "<textarea id='ObservacionesNva' name='ObservacionesNva'style='border-width:1px; height:20%' required></textarea>";
      echo "<span class='tenue menu_font_n2'> Notificar</span>";
      echo "<select  name='area' style='margin-left: 0px; width:100%' id='area' onchange='ShowSelected()' >";	
        $sql2="SELECT id,case when id=19 then 'Delegación' else nombre end as nombre 
        FROM cat_gerarquia where nivel='dir' and  id in (46,54,10,19)  order by nombre asc";
        $r2 = $conexion -> query($sql2);
        echo '<option value="0">SELECCIONE UNA OPCION...</option>';
        
        while($f = $r2 -> fetch_array())
        {
        echo "<option value='".$f['id']."'>".$f['nombre']."</option>";
        }
      echo "</select>"; 
      echo '</span>';
    echo "</div>";
    echo "<br>";
    echo "<br>";
    echo '<div><input class="Mbtn btn-default" id="boton" type="submit" value="Pausar Trámite"></div>';
    echo "<br>";
  echo "</form>";
  echo "</center>";
echo "</div>";
 //**********************************

 //********************************** Captura Finca
echo "<div id='capturaFinca' class='MyModal'>";
  echo "<center>";
  echo "<h1>Captura de Finca y/o Clave Catastral</h1>"; 
  echo "<form action='e004.php?Accion=3' method='POST' id='formFinca' name='formFinca'>";
  $sql="Select * FROM lotes where NumContrato='".$numcontrato. "'";

			//echo $sql; 
			$rc= $Vivienda -> query($sql);
			if($f = $rc -> fetch_array()){		
      echo "<input type='hidden' name='numescritura' id='numescritura' value='".$numescritura."' >" ;
      echo "<input type='hidden' name='idlote' id='idlote' value='".$idlote."' >" ;       
      echo "<div>";    
      echo "<label for='finca'>Finca</b>:";
      echo "<input id='finca' name='finca' value='".$f['FINCA']."' >";
      echo "</div>";
      echo "<div>";
      echo "<label for='clavecatastral'>Clave Catastral</b>:";
      echo "<input id='clavecatastral' name='clavecatastral' value='".$f['CVE_CATASTRAL']."'>";      
      echo "</div>";
      echo "<br>";
      echo "<br>";
      echo '<div><input class="Mbtn btn-default" id="boton" type="submit" value="Guardar"></div>';
      echo "<br>";
    }
  echo "</form>";
  echo "</center>";
echo "</div>";
//**********************************

//********************************** Modal Comentario
echo "<div id='agregarComentario' class='MyModal'>";
  echo "<center>";  
    echo "<h1>Agregar Comentario</h1>"; 
  echo "<form action='e004.php?Accion=6' method='POST' id='formComentario' name='formComentario'>";
    echo "<div style='width: 100%'>";      
      echo "<input type='hidden' name='numescritura' id='numescritura' value='".$numescritura."' >" ;
           //con número de contrato <b> ".$numcontrato."</b>,  a nombre de <b> ".$beneficiario."</b>
      echo "<label for='ObservacionesComentario' style='width: 80%'>Observaciones</b>:";
      echo "<textarea id='ObservacionesComentario' name='ObservacionesComentario'style='border-width:1px; height:20%' ></textarea>";
      echo "<br>";
      echo "<br>";
    echo "</div>";
    echo '<div><input class="Mbtn btn-default" id="boton" type="submit" value="Guardar"></div>';
    echo "<br>";
  echo "</form>";
  echo "</center>";
echo "</div>";
 //**********************************

}


//$(".close-modal").get(0).click();
 else {mensaje("No tiene acceso a esta aplicacion",'');}

?>


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>
<script type="text/javascript">
  function ShowSelected()
  {  
  /* Para obtener el texto */
  var combo = document.getElementById("area");
  var selected = combo.options[combo.selectedIndex].text;
  document.getElementById('textoArea').value=selected;
  }

$( document ).ready(function() {
  if($("#opciones").html()=="")
  {
    document.getElementsByName("BotonesOp")[0].style.display = 'none';
   // alert("Esta vacio");
  }

  
})
</script>