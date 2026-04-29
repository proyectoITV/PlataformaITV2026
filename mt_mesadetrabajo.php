<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>
<?php

docdigital_no(FALSE, 1); //ahorra 1 hoja





if (isset($_GET['IdMunicipio'])) {
    $idmunicipio=$_GET['IdMunicipio']; }
 else
 {    $idmunicipio=0; }

 if (isset($_GET['IdColonia'])) {
    $idcolonia=$_GET['IdColonia']; }
 else
 {    $idcolonia=0; }

 if (isset($_GET['IdMandante'])) {
    $idmandante=$_GET['IdMandante']; }
 else
 {    $idmandante=0; }

 if (isset($_GET['IdPrograma'])) {
    $idprograma=$_GET['IdPrograma']; }
 else
 {    $idprograma=0; }

 if (isset($_GET['IdDesarrollador'])) {
    $iddesarrollador=$_GET['IdDesarrollador']; }
 else
 {    $iddesarrollador=0; }



$idpestaña=0;
$id_aplicacion ="ap71"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//historia ($nitavu,"Entro a ver mesa de trabajo (app: ".$id_aplicacion.")");

$actual=  $_SERVER["REQUEST_URI"];
$seleccion='COLONIAS';
$anterior=$_SERVER['HTTP_REFERER'];

$tipo=obtenertipo($idmunicipio, $idcolonia, $idmandante, $iddesarrollador,$idprograma);
$titulo=obtenerdatoconsultado($idmunicipio, $idcolonia, $idmandante, $iddesarrollador,$idprograma,$tipo);
$titulo=explode('_',$titulo);
echo "<section id='wrapper' class='wrapper'>";


echo "<section id='aplicacionesReq' style='width:100% ;background: #E8FFD9;'><label class='menu_font_n'><b>Información General</b></label><br> ";
if($tipo=='C')
{
echo "<article style='background: #E8FFD9;'><table border='0'><tbody><tr><td></td>
<td><b class='normal menu_font_n'>MUNICIPIO:</b> <cite class='tenue menu_font_d '>".$titulo[0]."</cite></td><td width='10px'></td>

</tr></tbody></table></article>";

echo "<article style='background: #E8FFD9;'><table border='0'><tbody><tr><td></td>
<td><b class='normal menu_font_n'>COLONIA:</b> <cite class='tenue menu_font_d '>".$titulo[1]."</cite></td><td width='10px'></td>

</tr></tbody></table></article>";
}
if($tipo=='P')
{
echo "<article style='background: #E8FFD9;'><table border='0'><tbody><tr><td></td>
<td><b class='normal menu_font_n'>programa:</b> <cite class='tenue menu_font_d '>".$titulo[1]."</cite></td><td width='10px'></td>
</tr></tbody></table></article>";
}
if($tipo=='M')
{
echo "<article style='background: #E8FFD9;'><table border='0'><tbody><tr><td></td>
<td><b class='normal menu_font_n'>MANDANTE:</b> <cite class='tenue menu_font_d '>". $titulo[0]."</cite></td><td width='10px'></td>
</tr></tbody></table></article>";

echo "<article style='background: #E8FFD9;'><table border='0'><tbody><tr><td></td>
<td><b class='normal menu_font_n'>MUNICIPIO:</b> <cite class='tenue menu_font_d '>".$titulo[1]."</cite></td><td width='10px'></td>
</tr></tbody></table></article>";


echo "<article><table border='0'><tbody><tr><td></td>
<td><b class='normal menu_font_n'>COLONIA:</b> <cite class='tenue menu_font_d '>".$titulo[2]."</cite></td><td width='10px'></td>
</tr></tbody></table></article>";
}
if($tipo=='D')
{
echo "<article style='background: #E8FFD9;'><table border='0'><tbody><tr><td></td>
<td><b class='normal menu_font_n'>DESARROLLADOR:</b> <cite class='tenue menu_font_d '>". $titulo[0]."</cite></td><td width='10px'></td>
</tr></tbody></table></article>";

echo "<article style='background: #E8FFD9;'><table border='0'><tbody><tr><td></td>
<td><b class='normal menu_font_n'>MUNICIPIO:</b> <cite class='tenue menu_font_d '>".$titulo[1]."</cite></td><td width='10px'></td>
</tr></tbody></table></article>";


echo "<article style='background: #E8FFD9;'><table border='0'><tbody><tr><td></td>
<td><b class='normal menu_font_n'>ID CONVENIO:</b> <cite class='tenue menu_font_d '>".$titulo[2]."</cite></td><td width='10px'></td>
</tr></tbody></table></article>";
}

echo "</section>";
echo "<BR>";
echo "<BR>";
echo "<div id='v-nav'>";
echo "<div id='pestaña' style='width: 20%;height: auto;display: inline-block;'>";
// echo ":)".$descargado;

$descargado=false;

if (isset($_GET['pes'])) 
			{
				if ($_GET['pes']=='ficha')
				{
                        $tab1='current';
                        $tab2='';
                        $tab3='';
                        $tab4='';
                        $tab5='';
                        $tab6='last ';
                        $idpestaña=1; 
                        
                }
                else if ($_GET['pes']=='plano')
                {
                        $tab1='';
                        $tab2='current';
                        $tab3='';
                        $tab4='';
                        $tab5='';
                        $tab6='last ';
                        $idpestaña=2;                        
                }
                else if ($_GET['pes']=='docJuridicos')
                {
                        $tab1='';
                        $tab2='';
                        $tab3='current';
                        $tab4='';
                        $tab5='';
                        $tab6='last ';
                        $idpestaña=3;                        
                }
                else if($_GET['pes']=='tabla')
                {
                        $tab1='';
                        $tab2='';
                        $tab3='';
                        $tab4='current';
                        $tab5='';
                        $tab6='last';
                        $idpestaña=4;                         
                }
                else if($_GET['pes']=='historial')
                {
                        $tab1='';
                        $tab2='';
                        $tab3='';
                        $tab4='';
                        $tab5='current';
                        $tab6='last';
                        $idpestaña=5;                         
                }
                else if($_GET['pes']=='lotes')
                {
                        $tab1='';
                        $tab2='';
                        $tab3='';
                        $tab4='';
                        $tab5=' ';
                        $tab6='current';
                        $idpestaña=6;                         
                }
                 /*else
                {
                        $tab1=' ';
                        $tab2='';
                        $tab3='';
                        $tab4='';
                        $tab5='';
                        $tab6=' current';
                        $idpestaña=6;                        
                }*/
             
                $ultimoarchivo=obtenerultimodoc($idpestaña,$idmunicipio,$idcolonia,$idmandante,$iddesarrollador,$idprograma,$tipo);
                if(isset($_GET['archivo']))
                {
                    $ultimoarchivo=$_GET['archivo'];
                   
                }
                else
                {
                  
                    $ultimoarchivo=obtenerultimodoc($idpestaña,$idmunicipio,$idcolonia,$idmandante,$iddesarrollador,$idprograma,$tipo);
                  
                }
                    if ($ultimoarchivo==FALSE)
                    {
                        
                        $ultimoarchivo='prueba.pdf';
                    }else
                    {
                        if (file_exists($ultimoarchivo))
                        {
                            
                        }
                        else
                            {  
                                                           
                                if (FTP_existe_archivo($ultimoarchivo)=="TRUE")
                                {
                                    if (FTP_descargar($ultimoarchivo)=="TRUE")
                                    {
                                        
                                        $descargado=true;                                        
                                    }
                                    else
                                    {
                                     
                                         $descargado=False;
                                    }
                                }
                                else
                                {				
                                         $descargado=False;
                                }
                            }
                    }
                                 
            }
            else
            {
                $tab1=' current';
                $tab2='';
                $tab3='';
                $tab4='';
                $tab5='';
                $tab6='last ';
                $idpestaña=1; 
                
            }
			
    echo "<ul>"; 
        echo "<li tab='tab1' class='first".$tab1."'>";
            echo "<a href='?pes=ficha&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."'>";
            echo "<table style='width:100%'><tr><td valign='middle' align='center'  width='20%'>";
            echo "<img src='icon/reportes.png' >";
            echo "</td>";
            echo "<td valign='middle' align='center' class='pc tenue menu_font_n' width='80%'>";
            echo "<b>Ficha Técnica</b>";
            echo "</td></tr></table>";
            echo "</a>";
        echo "</li>"; 
        echo "<li tab='tab2' class='".$tab2."'>";
            echo "<a href='?pes=plano&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."'>";
            echo "<table style='width:100%'><tr><td valign='middle' align='center'  width='20%'>";
            echo "<img src='icon/kmz.png' >";
            echo "</td>";
            echo "<td valign='middle' align='center'  class='pc tenue menu_font_n'  width='80%'>";
            echo "<b>Plano</b>";
            echo "</td></tr></table>";
            echo "</a>";
        echo "</li>"; 
        echo "<li tab='tab3' class='".$tab3."'>";
            echo "<a href='?pes=docJuridicos&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."'>";
            echo "<table style='width:100%'  ><tr><td valign='middle' align='center'  width='20%'>";
            echo "<img src='icon/mail_all2.png' >";
            echo "</td>";
            echo "<td valign='middle' align='center' class='pc tenue menu_font_n'  width='80%'>";
            echo "<b>Documentos<br>Juridicos</b>";
            echo "</td></tr></table>";
            echo "</a>";
        echo "</li>"; 
        echo "<li tab='tab4' class='".$tab4."'>";
            echo "<a href='?pes=tabla&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."'>";
            echo "<table  style='width:100%'><tr><td valign='middle' align='center'  width='20%'>";
            echo "<img src='icon/aprobados.png' >";
            echo "</td>";
            echo "<td valign='middle' align='center'  class='pc tenue menu_font_n' width='80%'>";
            echo "<b>Tabla de<br>Comercialización</b>";
            echo "</td></tr></table>";
            echo "</a>";
            echo "</li>"; 
         echo "<li tab='tab5' class='last".$tab5."'>";
            echo "<a href='?pes=historial&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."'>";
            echo "<table style='width:100%' ><tr><td valign='middle' align='center'  width='20%'>";
            echo "<img src='icon/embarques_print2.png' >";
            echo "</td>";
            echo "<td valign='middle' align='center' class='pc tenue menu_font_n'  width='80%'>";
            echo "<b>Historial y<br>Observaciones</b>";
            echo "</td></tr></table>";
            echo "</a>";
         echo "</li>"; 
        echo "<li tab='tab6' class='last".$tab6."'>";
            echo "<a href='?pes=lotes&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."'>";
            echo "<table style='width:100%' ><tr><td valign='middle' align='center'  width='20%'>";
            echo "<img src='icon/lotes.png' >";
            echo "</td>";
            echo "<td valign='middle' align='center' class='pc tenue menu_font_n'  width='80%'>";
            echo "<b>Lotes</b>";
            echo "</td></tr></table>";
            echo "</a>";
        echo "</li>"; 
    echo "</ul>";
    echo "</div >";


    echo "<div id='contenidopestaña'style='width: 80%;height: auto;display: inline-block; vertical-align: top; ' >";
    if (isset($_GET['pes'])) 
		{
            

           
            $sql = "SELECT * FROM mt_documentos 
            inner join documentos on mt_documentos.ndocumento=documentos.ndocumento where documentos.cancelado=0 and mt_documentos.pestaña=".$idpestaña." and mt_documentos.idmunicipio=".$idmunicipio            
            ." and mt_documentos.idcolonia=".$idcolonia." and mt_documentos.idmandante=".$idmandante.
            " and mt_documentos. iddesarrollador=".$iddesarrollador." and mt_documentos.idprograma=".$idprograma. " order by mt_documentos.idinc desc";    
            
			if ($_GET['pes']=='ficha')
			{       
                 
                
                echo "<div class='tab-content'>";  
                echo " <h4>Ficha Técnica</h4>";          
                echo "<div style='width: 100%'>";
                echo "<div class='divdoc pc'>";
                echo "<article>";  
                echo " <br>"; 
                echo " <h4>Vista previa</h4>";         
                echo ponerpdf("tmp/".$ultimoarchivo,'mt_doc');	           
                echo "</article>";
                echo "</div>";
                $rc= $conexion -> query($sql); 
                echo "<div class='divdoc' style='overflow: auto; height:60%'>";
                echo "<div class='divtablahis'>";
                echo "<table id='ficha' class='tabla'>";
                echo "<th class='pc'>Id</th>";
                echo "<th >Nombre Archivo</th>";            
                echo "<th >Descripción</th>";
                echo "<th class='pc'>Fecha</th>";
                echo "<th ></th>";
                echo "<th ></th>";
            if ($rc->num_rows>0)
            {
    
                $c=0;
                while($r = $rc -> fetch_array())    
                {
                    $c=$c+1;
                    echo "<tr>";
                    echo "<td class='pc'>".$c."</td>";    
                    $archivo= "documentos/".$r['ndocumento'].'_'.$tipo.$idpestaña.'-'.$r['nombre']."";               
                    $link = "<a id=".$r['ndocumento']." name='$archivo' href='mt_mesadetrabajo.php?pes=ficha&archivo=".$archivo."&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."'". " title='Haga click aqui para descargar'>".$r['nombre']."</a>";
                    echo "<td >".$link."</td>";//archivo            
                    echo "<td style='font-family:Compacta;font-size:15px;'>".$r['descripcion']."</td>";
                    echo "<td style='font-family:Compacta;font-size:15px;' class='pc'>".$r['fecha']."<span style='font-size:7pt;'><br> por ".nitavu_nombre($r['nitavusube'])."</span></td>";
                    $link2 = "<a id=".$r['ndocumento']." name='$archivo' href='cp_descargar.php?nombre=".$archivo."' target='_self'  class='Mbtn btn-default' onclick =''  title='Haga click aqui para descargar'><img src='icon/des.png' style='width:20px; '></a>";

                    echo "<td class='movil'>". $link2 ."</td>";
                
                        echo "<td class='centrar'>";
                        if ($nivel==1 and $r['nitavusube'] == $nitavu){
                       echo "<form action='mt_mesadetrabajo.php?id=".$r['ndocumento']."&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."' method='POST' enctype='multipart/form-data'>";
                        echo '<input type="hidden" name="id" value='.$r['ndocumento'].'>';
                        echo '<input type="hidden" name="idDoc" value='.$r['ndocumento'].'>';
                        echo '<input type="hidden" name="nomDoc" value='.$r['ndocumento'].'>';
                                echo "<button type='submit' class='Mbtn btn-cancel' title='Haga clic para eliminar el archivo'> <img src='icon/delete.png' style='width:20px; '> </button>";
                            echo "</form>";
                        }
                        echo "</td>";
                    echo '</tr>';
                }
                
            }        
                echo '<tr>';
                if ($nivel==1){
                echo "<form action='mt_subirarchivo.php' method='POST' enctype='multipart/form-data'>";             
                    echo '<input type="hidden" name="idmunicipio" value='.$idmunicipio.'>';
                    echo '<input type="hidden" name="idcolonia" value='.$idcolonia.'>';
                    echo '<input type="hidden" name="idmandante" value='.$idmandante.'>';
                    echo '<input type="hidden" name="iddesarrollador" value='.$iddesarrollador.'>';
                    echo '<input type="hidden" name="idprograma" value='.$idprograma.'>';
                    echo '<input type="hidden" name="idpestaña" value='.$idpestaña.'>';
                    echo '<td class="pc">';              
                    echo '</td>';
                    echo '<td>';
                    echo '<input name="nuevoDoc" type="file" accept=".pdf">';
                    echo '</td>';
                    echo '<td>';
                    echo '<input type="text" id="descripcion" name="descripcion"  required >';
                    echo '</td>';
                    echo '<td class="pc">'.$fecha.'</td>';
                    echo "<td class='centrar'><button type='submit' class='Mbtn btn-default' title='Haga clic para subir el archivo'> <img src='icon/subirDoc.png' style='width:20px; '> </button></td>";
                echo "</form>";
                }
                echo '</tr>';  
                echo "</table>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                //echo $tipo;
                if( $tipo=='P')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Ficha Técnica\" del idprograma:'.$idprograma);
                }else if( $tipo=='D')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Ficha Técnica\" del desarrollador:'.$iddesarrollador.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
                }
                else if( $tipo=='M')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Ficha Técnica\" del mandante:'.$idmandante.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
                }
                else if( $tipo=='C')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Ficha Técnica\" de la colonia:'.$idcolonia.' del idmunicipio:'.$idmunicipio);
                }
            }
            else if ($_GET['pes']=='plano')  
            {
            
            echo "<div class='tab-content'>";  
            echo " <h4>Plano</h4>";          
            echo "<div style='width: 100%'>";
            echo "<div class='divdoc pc'>";
            echo "<article>";  
            echo " <br>"; 
            echo " <h4>Vista previa</h4>";  
             

             if(obtenerextarchivo($ultimoarchivo)[1]=="kmz" || obtenerextarchivo($ultimoarchivo)[1]=="kml" )
             {
                $intento="";
                $archivo = "tmp/".$ultimoarchivo;
                //echo $archivo;

                if (file_exists($archivo))
                {
                    $intento="SI";
                }else
                {  
                    $intento="No";
                }  

                
                if ($intento == "SI")
                {
                   
                   $archivo=$ultimoarchivo;
                    echo "<div id='mapa_kmz'></div>";	
                    echo "
                    <script>
                    function initMap() {
                    var map = new google.maps.Map(document.getElementById('mapa_kmz'), {	
                        zoom: 11,

                        center: {lat: 41.876, lng: -87.624
                        }
                    });
                    var ctaLayer = new google.maps.KmlLayer({url:'https://plataformaitavu.tamaulipas.gob.mx/tmp/".$archivo."',map: map});
                    }
                    </script>
                    <script src='https://maps.googleapis.com/maps/api/js?key=".$key_mapkmz."&callback=initMap'
                    async defer></script>
                    <br><br>	
                    ";
               
               //echo "https://plataformaitavu.tamaulipas.gob.mx/".$archivo;
        
            
            
		
                } 
                else
                {
                    
                    echo "<b class='alerta'>Aun no cuenta con reserva o no se ha actualizado la informacion</b>";
                }
                

            }
        
            else{      
             echo ponerpdf("tmp/".$ultimoarchivo,'mt_doc');
            }	 
                   
            echo "</article>";
            echo "</div>";
            $rc= $conexion -> query($sql); 
            echo "<div class='divdoc' style='overflow: auto; height:60%'>";
            echo "<div class='divtablahis'>";
            echo "<table id='plano' class='tabla'>";
             echo "<th class='pc'>Id</th>";
             echo "<th >Nombre Archivo</th>";            
             echo "<th >Descripción</th>";
             echo "<th class='pc'>Fecha</th>";
             echo "<th >-</th>";
           if ($rc->num_rows>0)
           {
 
            $c=0;
            while($r = $rc -> fetch_array())    
            {
                $c=$c+1;
                echo "<tr>";
                echo "<td class='pc'>".$c."</td>";    
                $archivo= "documentos/".$r['ndocumento'].'_'.$tipo.$idpestaña.'-'.$r['nombre']."";               
                $link = "<a id=".$r['ndocumento']." name='$archivo' href='mt_mesadetrabajo.php?pes=plano&archivo=".$archivo."&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."'". "    title='Haga click aqui para descargar'>".$r['nombre']."</a>";
                echo "<td >".$link."</td>";//archivo            
                echo "<td style='font-family:Compacta;font-size:15px;'>".$r['descripcion']."</td>";
                
                echo "<td style='font-family:Compacta;font-size:15px;' class='pc'>".$r['fecha']."<span style='font-size:7pt;'><br> por ".nitavu_nombre($r['nitavusube'])."</span></td>";
                    echo "<td class='centrar'>";
                    if ($nivel==1 and $r['nitavusube'] == $nitavu){
                   echo "<form action='mt_mesadetrabajo.php?id=".$r['ndocumento']."&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."' method='POST' enctype='multipart/form-data'>";
                    echo '<input type="hidden" name="id" value='.$r['ndocumento'].'>';
                    echo '<input type="hidden" name="idDoc" value='.$r['ndocumento'].'>';
                    echo '<input type="hidden" name="nomDoc" value='.$r['nombre'].'>';
                            echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para eliminar el archivo'> <img src='icon/delete.png' style='width:20px; '> </button>";
                        echo "</form>";}
                    echo "</td>";
                echo '</tr>';
            }
             
           }        
            echo '<tr>';
            if ($nivel==1){
              echo "<form action='mt_subirarchivo.php' method='POST' enctype='multipart/form-data'>";             
                echo '<input type="hidden" name="idmunicipio" value='.$idmunicipio.'>';
                echo '<input type="hidden" name="idcolonia" value='.$idcolonia.'>';
                echo '<input type="hidden" name="idmandante" value='.$idmandante.'>';
                echo '<input type="hidden" name="iddesarrollador" value='.$iddesarrollador.'>';
                echo '<input type="hidden" name="idprograma" value='.$idprograma.'>';
                echo '<input type="hidden" name="idpestaña" value='.$idpestaña.'>';
                echo '<td class="pc">';              
                echo '</td>';
                echo '<td>';
                echo '<input name="nuevoDoc" type="file" accept=".pdf,.kmz,.kml">';
                echo '</td>';
                echo '<td>';
                echo '<input type="text" id="descripcion" name="descripcion"  required >';
                echo '</td>';
                echo '<td class="pc">'.$fecha.'</td>';
                echo "<td class='centrar'><button type='submit' class='Mbtn btn-default' title='Haga clic para subir el archivo'> <img src='icon/subirDoc.png' style='width:20px; '> </button></td>";
               echo "</form>";
            }
            echo '</tr>';  
            echo "</table>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

                    if( $tipo=='P')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Plano\" del idprograma:'.$idprograma);
                }else if( $tipo=='D')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Plano\" del desarrollador:'.$iddesarrollador.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
                }
                else if( $tipo=='M')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Plano\" del mandante:'.$idmandante.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
                }
                else if( $tipo=='C')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Plano\" de la colonia:'.$idcolonia.' del idmunicipio:'.$idmunicipio);
                }

            }
            else if ($_GET['pes']=='docJuridicos')
			{  
                           
                echo "<div class='tab-content'>";  
                echo " <h4>Documentos Juridicos</h4>";          
                echo "<div style='width: 100%'>";
                echo "<div class='divdoc pc'>";
                echo "<article>";  
                echo " <br>"; 
                echo " <h4>Vista previa</h4>";         
                echo ponerpdf("tmp/".$ultimoarchivo,'mt_doc');	           
                echo "</article>";
                echo "</div>";
                $rc= $conexion -> query($sql); 
                echo "<div class='divdoc' style='overflow: auto; height:60%'>";
                echo "<div class='divtablahis'>";
                echo "<table id='docJuridicos' class='tabla'>";
                echo "<th class='pc'>Id</th>";
                echo "<th >Nombre Archivo</th>";            
                echo "<th >Descripción</th>";
                echo "<th class='pc'>Fecha</th>";
                echo "<th ></th>";
                echo "<th ></th>";
            if ($rc->num_rows>0)
            {
    
                $c=0;
                while($r = $rc -> fetch_array())    
                {
                    $c=$c+1;
                    echo "<tr>";
                    echo "<td class='pc'>".$c."</td>";    
                    $archivo= "documentos/".$r['ndocumento'].'_'.$tipo.$idpestaña.'-'.$r['nombre']."";               
                    $link = "<a id=".$r['ndocumento']." name='$archivo' href='mt_mesadetrabajo.php?pes=docJuridicos&archivo=".$archivo."&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."'". "    title='Haga click aqui para descargar'>".$r['nombre']."</a>";
                    echo "<td >".$link."</td>";//archivo            
                    echo "<td style='font-family:Compacta;font-size:15px;'>".$r['descripcion']."</td>";
                    echo "<td style='font-family:Compacta;font-size:15px;' class='pc'>".$r['fecha']."<span style='font-size:7pt;'><br> por ".nitavu_nombre($r['nitavusube'])."</span></td>";
                    $link2 = "<a id=".$r['ndocumento']." name='$archivo' href='cp_descargar.php?nombre=".$archivo."' target='_self'  class='Mbtn btn-default' onclick =''  title='Haga click aqui para descargar'><img src='icon/des.png' style='width:20px; '></a>";
                    echo "<td class='movil'>". $link2 ."</td>";
                
                        echo "<td class='centrar'>";
                        if ($nivel==1 and $r['nitavusube'] == $nitavu){
                      echo "<form action='mt_mesadetrabajo.php?id=".$r['ndocumento']."&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."' method='POST' enctype='multipart/form-data'>";
                        echo '<input type="hidden" name="id" value='.$r['ndocumento'].'>';
                        echo '<input type="hidden" name="idDoc" value='.$r['ndocumento'].'>';
                        echo '<input type="hidden" name="nomDoc" value='.$r['nombre'].'>';
                                echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para eliminar el archivo'> <img src='icon/delete.png' style='width:20px; '> </button>";
                            echo "</form>";}
                        echo "</td>";
                    echo '</tr>';
                }
                
            }        
                echo '<tr>';
                if ($nivel==1){
                echo "<form action='mt_subirarchivo.php' method='POST' enctype='multipart/form-data'>";             
                    echo '<input type="hidden" name="idmunicipio" value='.$idmunicipio.'>';
                    echo '<input type="hidden" name="idcolonia" value='.$idcolonia.'>';
                    echo '<input type="hidden" name="idmandante" value='.$idmandante.'>';
                    echo '<input type="hidden" name="iddesarrollador" value='.$iddesarrollador.'>';
                    echo '<input type="hidden" name="idprograma" value='.$idprograma.'>';
                    echo '<input type="hidden" name="idpestaña" value='.$idpestaña.'>';
                    echo '<td class="pc">';              
                    echo '</td>';
                    echo '<td>';
                    echo '<input name="nuevoDoc" type="file" accept=".pdf">';
                    echo '</td>';
                    echo '<td>';
                    echo '<input type="text" id="descripcion" name="descripcion"  required >';
                    echo '</td>';
                    echo '<td class="pc">'.$fecha.'</td>';
                    echo "<td class='centrar'><button type='submit' class='Mbtn btn-default' title='Haga clic para subir el archivo'> <img src='icon/subirDoc.png' style='width:20px; '> </button></td>";
                echo "</form>";
                }
                echo '</tr>';  
                echo "</table>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                if( $tipo=='P')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Documentos Juridicos\" del idprograma:'.$idprograma);
                }else if( $tipo=='D')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Documentos Juridicos\" del desarrollador:'.$iddesarrollador.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
                }
                else if( $tipo=='M')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Documentos Juridicos\" del mandante:'.$idmandante.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
                }
                else if( $tipo=='C')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Documentos Juridicos\" de la colonia:'.$idcolonia.' del idmunicipio:'.$idmunicipio);
                }
            }
            else if ($_GET['pes']=='tabla')
			{               
                echo "<div class='tab-content'>";  
                echo " <h4>Tabla de comercialización</h4>";          
                echo "<div style='width: 100%'>";
                echo "<div class='divdoc pc'>";
                echo "<article>";  
                echo " <br>"; 
                echo " <h4>Vista previa</h4>";         
                echo ponerpdf("tmp/".$ultimoarchivo,'mt_doc');	           
                echo "</article>";
                echo "</div>";
                $rc= $conexion -> query($sql); 
                echo "<div class='divdoc' style='overflow: auto; height:60%'>";
                echo "<div class='divtablahis'>";
                echo "<table id='tabla' class='tabla'>";
                echo "<th class='pc'>Id</th>";
                echo "<th >Nombre Archivo</th>";            
                echo "<th >Descripción</th>";
                echo "<th class='pc'>Fecha</th>";
                echo "<th ></th>";
                echo "<th ></th>";
            if ($rc->num_rows>0)
            {
    
                $c=0;
                while($r = $rc -> fetch_array())    
                {
                    $c=$c+1;
                    echo "<tr>";
                    echo "<td class='pc'>".$c."</td>";    
                    $archivo= "documentos/".$r['ndocumento'].'_'.$tipo.$idpestaña.'-'.$r['nombre']."";               
                    $link = "<a id=".$r['ndocumento']." name='$archivo' href='mt_mesadetrabajo.php?pes=tabla&archivo=".$archivo."&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."'". "    title='Haga click aqui para descargar'>".$r['nombre']."</a>";
                    echo "<td >".$link."</td>";//archivo            
                    echo "<td style='font-family:Compacta;font-size:15px;'>".$r['descripcion']."</td>";
                    echo "<td style='font-family:Compacta;font-size:15px;' class='pc'>".$r['fecha']."<span style='font-size:7pt;'><br> por ".nitavu_nombre($r['nitavusube'])."</span></td>";
                    $link2 = "<a id=".$r['ndocumento']." name='$archivo' href='cp_descargar.php?nombre=".$archivo."' target='_self'  class='Mbtn btn-default' onclick =''  title='Haga click aqui para descargar'><img src='icon/des.png' style='width:20px; '></a>";
                    echo "<td class='movil'>". $link2 ."</td>";
                
                        echo "<td class='centrar'>";
                        if ($nivel==1 and $r['nitavusube'] == $nitavu){
                         echo "<form action='mt_mesadetrabajo.php?id=".$r['ndocumento']."&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."' method='POST' enctype='multipart/form-data'>";
                        echo '<input type="hidden" name="id" value='.$r['ndocumento'].'>';
                        echo '<input type="hidden" name="idDoc" value='.$r['ndocumento'].'>';
                        echo '<input type="hidden" name="nomDoc" value='.$r['nombre'].'>';
                                echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para eliminar el archivo'> <img src='icon/delete.png' style='width:20px; '> </button>";
                            echo "</form>";}
                        echo "</td>";
                    echo '</tr>';
                }
                
            }        
                echo '<tr>';
                if ($nivel==1){
                echo "<form action='mt_subirarchivo.php' method='POST' enctype='multipart/form-data'>";             
                    echo '<input type="hidden" name="idmunicipio" value='.$idmunicipio.'>';
                    echo '<input type="hidden" name="idcolonia" value='.$idcolonia.'>';
                    echo '<input type="hidden" name="idmandante" value='.$idmandante.'>';
                    echo '<input type="hidden" name="iddesarrollador" value='.$iddesarrollador.'>';
                    echo '<input type="hidden" name="idprograma" value='.$idprograma.'>';
                    echo '<input type="hidden" name="idpestaña" value='.$idpestaña.'>';
                    echo '<td class="pc">';              
                    echo '</td>';
                    echo '<td>';
                    echo '<input name="nuevoDoc" type="file" accept=".pdf">';
                    echo '</td>';
                    echo '<td>';
                    echo '<input type="text" id="descripcion" name="descripcion"  required >';
                    echo '</td>';
                    echo '<td class="pc">'.$fecha.'</td>';
                    echo "<td class='centrar'><button type='submit' class='Mbtn btn-default' title='Haga clic para subir el archivo'> <img src='icon/subirDoc.png' style='width:20px; '> </button></td>";
                echo "</form>";
                }
                echo '</tr>';  
                echo "</table>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                if( $tipo=='P')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Tabla de comercialización\" del idprograma:'.$idprograma);
                }else if( $tipo=='D')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Tabla de comercialización\" del desarrollador:'.$iddesarrollador.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
                }
                else if( $tipo=='M')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Tabla de comercialización\" del mandante:'.$idmandante.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
                }
                else if( $tipo=='C')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Tabla de comercialización\" de la colonia:'.$idcolonia.' del idmunicipio:'.$idmunicipio);
                }
            }
            else if ($_GET['pes']=='historial')
			{               
                echo "<div class='tab-content'>";  
                echo " <h4>Historial y Observaciones</h4>";          
                echo "<div style='width: 100%'>";
                echo "<div class='divdoc pc'>";
                echo "<article>";  
                echo " <br>"; 
                echo " <h4>Vista previa</h4>";         
                echo ponerpdf("tmp/".$ultimoarchivo,'mt_doc');	           
                echo "</article>";
                echo "</div>";
                $rc= $conexion -> query($sql); 
                echo "<div class='divdoc' style='overflow: auto; height:60%'>";
                echo "<div class='divtablahis'>";
                echo "<table id='historial' class='tabla'>";
                echo "<th class='pc'>Id</th>";
                echo "<th >Nombre Archivo</th>";            
                echo "<th >Descripción</th>";
                echo "<th class='pc'>Fecha</th>";
                echo "<th ></th>";
                echo "<th ></th>";
            if ($rc->num_rows>0)
            {
    
                $c=0;
                while($r = $rc -> fetch_array())    
                {
                    $c=$c+1;
                    echo "<tr>";
                    echo "<td class='pc'>".$c."</td>";    
                    $archivo= "documentos/".$r['ndocumento'].'_'.$tipo.$idpestaña.'-'.$r['nombre']."";               
                    $link = "<a id=".$r['ndocumento']." name='$archivo' href='mt_mesadetrabajo.php?pes=historial&archivo=".$archivo."&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."'". "     title='Haga click aqui para descargar'>".$r['nombre']."</a>";
                    echo "<td >".$link."</td>";//archivo            
                    echo "<td style='font-family:Compacta;font-size:15px;'>".$r['descripcion']."</td>";
                    echo "<td style='font-family:Compacta;font-size:15px;' class='pc'>".$r['fecha']."<span style='font-size:7pt;'><br> por ".nitavu_nombre($r['nitavusube'])."</span></td>";
                    $link2 = "<a id=".$r['ndocumento']." name='$archivo' href='cp_descargar.php?nombre=".$archivo."' target='_self'  class='Mbtn btn-default' onclick =''  title='Haga click aqui para descargar'><img src='icon/des.png' style='width:20px; '></a>";
                    echo "<td class='movil'>". $link2 ."</td>";
                
                        echo "<td class='centrar'>";
                        if ($nivel==1 and $r['nitavusube'] == $nitavu){
                         echo "<form action='mt_mesadetrabajo.php?id=".$r['ndocumento']."&IdMunicipio=". $idmunicipio."&IdColonia=".$idcolonia."&IdPrograma=". $idprograma."&IdMandante=".$idmandante."&IdDesarrollador=".$iddesarrollador."' method='POST' enctype='multipart/form-data'>";
                        echo '<input type="hidden" name="id" value='.$r['ndocumento'].'>';
                        echo '<input type="hidden" name="idDoc" value='.$r['ndocumento'].'>';
                        echo '<input type="hidden" name="nomDoc" value='.$r['nombre'].'>';
                                echo "<button type='submit' class='Mbtn btn-default' title='Haga clic para eliminar el archivo'> <img src='icon/delete.png' style='width:20px; '> </button>";
                            echo "</form>";}
                        echo "</td>";
                    echo '</tr>';
                }
                
            }        
                echo '<tr>';
                if ($nivel==1){
                echo "<form action='mt_subirarchivo.php' method='POST' enctype='multipart/form-data'>";             
                    echo '<input type="hidden" name="idmunicipio" value='.$idmunicipio.'>';
                    echo '<input type="hidden" name="idcolonia" value='.$idcolonia.'>';
                    echo '<input type="hidden" name="idmandante" value='.$idmandante.'>';
                    echo '<input type="hidden" name="iddesarrollador" value='.$iddesarrollador.'>';
                    echo '<input type="hidden" name="idprograma" value='.$idprograma.'>';
                    echo '<input type="hidden" name="idpestaña" value='.$idpestaña.'>';
                    echo '<td class="pc">';              
                    echo '</td>';
                    echo '<td>';
                    echo '<input name="nuevoDoc" type="file" >';
                    echo '</td>';
                    echo '<td>';
                    echo '<input type="text" id="descripcion" name="descripcion"  required >';
                    echo '</td>';
                    echo '<td class="pc">'.$fecha.'</td>';
                    echo "<td class='centrar'><button type='submit' class='Mbtn btn-default' title='Haga clic para subir el archivo'> <img src='icon/subirDoc.png' style='width:20px; '> </button></td>";
                echo "</form>";
                }
                echo '</tr>';  
                echo "</table>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                if( $tipo=='P')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Historial\" del idprograma:'.$idprograma);
                }else if( $tipo=='D')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Historial\" del desarrollador:'.$iddesarrollador.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
                }
                else if( $tipo=='M')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Historial\" del mandante:'.$idmandante.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
                }
                else if( $tipo=='C')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Historial\" de la colonia:'.$idcolonia.' del idmunicipio:'.$idmunicipio);
                }
            }

            else if ($_GET['pes']=='lotes')
			{               
                echo "<div class='tab-content'>";  
                   
                              
                echo " <h4>Lista de lotes</h4>";          
               // echo "<div style='width: 100%'>";
                

                $sql = "SELECT * FROM lotes  where idmunicipio=".$idmunicipio." and idcolonia=".$idcolonia;
              //  $sql = "SELECT * FROM relaciones  where itavuIdMunicipio=".$idmunicipio." and itavuIdColonia=".$idcolonia;
                 
                      if($tipo=='M')
                    {                    
                     $sql=$sql." and idmandante=".$idmandante;
                    }
                    else if($tipo=='P')
                    {
                          $sql=$sql." and idprograma=".$idprograma;
                    }
                    else if($tipo=='D')
                    
                     {
                         $sql=$sql." and iddesarrollador=".$iddesarrollador;
                        
                    }
                
               
               
                
                 $sql=$sql." order by manzana,lote asc"; 
                 //$sql=$sql." order by itavuManzana,itavuLote asc";
            
         

                $rc= $conexion -> query($sql); 
                echo "<div  style='overflow: auto; height:60%'>";
                echo "<div class='divtablahis'>";
                echo "<table id='historial' class='tabla'>";
                echo "<th style=' width:10%;' >#</th>";
                echo "<th >Colonia</th>";            
                echo "<th >Manzana</th>";
                echo "<th >Lote</th>";
                echo "<th ></th>";

                // echo $sql;

            
            if ($rc->num_rows>0) //errorsote
            {
    
                $c=0;
                while($r = $rc -> fetch_array())    
                {
                    $c=$c+1;
                    echo "<tr>";
                    echo "<td style=' width:5px; text-align:center'>".$c."</td>";    
                    echo "<td style='display:none;'>".$r['idlote']."</td>";   
                    echo "<td >".$r['colonia']."</td>";//archivo            
                    echo "<td style=' width:10%; text-align:center'>".$r['manzana']."</td>";
                    echo "<td style=' width:10%; text-align:center'>".$r['lote']."</td>";
                
                    echo "<td class='movil'>". $r['idlote'] ."</td>";
                    
                echo "<td width='5px;'>";
                echo '<a href="#modallotes'.$r['idlote'].'"  rel="modal:open" title="ver" onclick=ejecutarhistoria("'.$tipo.'");>
                 <img src="icon/ver.png" style="width: 20px;height: 20px;"  ></a>';
                    echo "<div id='modallotes".$r['idlote']."' class='MyModal'>";
                   
                    $idlote=$r['idlote'];
                        echo "<section id='aplicacionesReq' style='width:97% ;background: white;'> ";
                            $adj = "SELECT * FROM lotes as lot
                                    left join catestatuslote as clotes on lot.idestatus=clotes.idestatus
                                    left join cat_municipios as mun on lot.idmunicipio=mun.idmunicipio
                                    left join cat_colonias as col on lot.idcolonia=col.idcolonia and lot.idmunicipio=col.idmunicipio
                                    where idlote = ".$r['idlote']."";
                          
                            $rc1 = $conexion -> query($adj);
                            if ($rc1->num_rows>0){
                               
                                    while($r1 = $rc1 -> fetch_array())
                                    {

                                        echo "<article ><table border='0'  width='100%'><tbody><tr><td></td>
                                        <td width='25%'><b class='normal menu_font_n'>MUNICIPIO:</b> <cite class='tenue menu_font_d '>".$r1['municipio']."</cite></td>
                                        <td  width='25%'><b class='normal menu_font_n'>COLONIA:</b> <cite class='tenue menu_font_d '>".$r1['colonia']."</cite></td>
                                         <td width='25%'><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d '>"."</cite></td>
                                        <td  width='25%'><b class='normal menu_font_n'>ESTATUS:</b> <cite class='tenue menu_font_d '>".$r1['estatuslote']."</cite></td>
                                        </tr></tbody></table></article>";

                                        echo "<article ><table border='0'  width='100%'><tbody><tr><td></td>
                                         
                                        <td width='25%'><b class='normal menu_font_n'>MANZANA:</b> <cite class='tenue menu_font_d '>".$r1['manzana']."</cite></td>
                                        <td  width='25%'><b class='normal menu_font_n'>LOTE:</b> <cite class='tenue menu_font_d '>".$r1['lote']."</cite></td>
                                        <td width='25%'><b class='normal menu_font_n'>SECTOR:</b> <cite class='tenue menu_font_d '>".$r1['seccion']."</cite></td>
                                        <td  width='25%'><b class='normal menu_font_n'>FILA:</b> <cite class='tenue menu_font_d '>".$r1['fila']."</cite></td>

                                        </tr></tbody></table></article>";                                                                            
                                        echo "<article ><table border='0'  width='100%'><tbody><tr><td></td>
                                        
                                        <td width='25%'><b class='normal menu_font_n'>CONTRATO:</b> <cite class='tenue menu_font_d '>".$r1['numcontrato']."</cite></td>
                                        <td  width='25%'><b class='normal menu_font_n'>NUM ESCRITURA :</b> <cite class='tenue menu_font_d '>".$r1['numescritura']."</cite></td> 
                                        <td width='25%'><b class='normal menu_font_n'>FINCA:</b> <cite class='tenue menu_font_d '>".$r1['finca']."</cite></td>
                                        <td  width='25%'><b class='normal menu_font_n'>CLAVE CATASTRAL:</b> <cite class='tenue menu_font_d '>".$r1['cve_catastral']."</cite></td>
                                        </tr></tbody></table></article>";

                                        echo "<br>";
                                        echo "<br>";

                                         echo "<article  ><table border='0'><tbody><tr><td></td>
                                        <td><b class='normal menu_font_n'> COLINDANCIAS: </b> <cite class='tenue menu_font_d '></cite></td><td width='10px'></td>
                                        </tr></tbody></table></article>";
                                

                                        echo "<article ><table border='0'><tbody><tr><td></td>
                                        <td><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d '>".$r1['colin1'].' '.$r1['con_quien1']."</cite></td><td width='10px'></td>
                                        </tr></tbody></table></article>";
                                         
                                               echo "<article ><table border='0'><tbody><tr><td></td>
                                        <td><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d '>".$r1['colin2'].' '.$r1['con_quien2']."</cite></td><td width='10px'></td>
                                        </tr></tbody></table></article>";

                                                echo "<article><table border='0'><tbody><tr><td></td>
                                        <td><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d '>".$r1['colin3'].' '.$r1['con_quien3']."</cite></td><td width='10px'></td>
                                        </tr></tbody></table></article>";

                                                echo "<article ><table border='0'><tbody><tr><td></td>
                                        <td><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d '>".$r1['colin4'].' '.$r1['con_quien4']."</cite></td><td width='10px'></td>
                                        </tr></tbody></table></article>";


                                         echo "<br>";
                                        echo "<br>";
                                         
                                         echo "<article ><table border='0'><tbody><tr><td></td>
                                        <td><b class='normal menu_font_n'> OBSERVACIONES: </b> <cite class='tenue menu_font_d '></cite></td><td width='10px'></td>
                                        </tr></tbody></table></article>";
                                

                                        echo "<article ><table border='0'><tbody><tr><td></td>
                                        <td><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d '>".$r1['observaciones']."</cite></td><td width='10px'></td>
                                        </tr></tbody></table></article>";

                                         echo "<article ><table border='0'><tbody><tr><td></td>
                                        <td><b class='normal menu_font_n'></b> <cite class='tenue menu_font_d '>".$r1['observaciones']."</cite></td><td width='10px'></td>
                                        </tr></tbody></table></article>";
                                      
                                    }
                              
                            }
                        echo "</section>";  
                     
                        echo "</div>";
             
            echo "</td>";
                   


                    
                    // echo "<td width='5px;' align='right' class='tipo_menu'>";
                    //             echo "<a  href='#modallotes' rel='MyModal:open' title='ver'>
                    //             <img src='icon/ver.png' style='width: 20px;height: 20px;' ></a>";
					// 			echo " </td>";
                    echo '</tr>';
                }
                
            }        
              
                echo "</table>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

                if( $tipo=='P')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Lotes\" del idprograma:'.$idprograma);
                }else if( $tipo=='D')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Lotes\" del desarrollador:'.$iddesarrollador.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
                }
                else if( $tipo=='M')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Lotes\" del mandante:'.$idmandante.' del idmunicipio:'.$idmunicipio.' de la idcolonia:'.$idcolonia);
                }
                else if( $tipo=='C')
                {
                historia($nitavu,'mt_Entró  a ver la pestaña \"Lotes\" de la colonia:'.$idcolonia.' del idmunicipio:'.$idmunicipio);
                }
            }
           
           
        }
    echo "</div >";


echo "</div>";
echo "</section>";

 
  

 //ELIMINAR UN ARCHIVO DEL HISTORIAL DE DOCUMENTOS
 if(isset($_POST['id'])){
     
    $idDoc = $_POST['idDoc'];
    $id = $_POST['id'];
    $nomDoc = $_POST['nomDoc'];
     $sql = "UPDATE mt_documentos join documentos on mt_documentos.ndocumento =documentos.ndocumento SET documentos.cancelado=1 
     WHERE documentos.ndocumento=".$id;
    if ($conexion->query($sql) == TRUE)
    {
        echo $anterior;
        $posicion = strrpos($anterior ,"&archivo");
        $resultado = substr($anterior, 0, $posicion);
        historia($nitavu,'mt_Elimino el archivo '.$nomDoc.' con id: '.$idDoc);
       mensaje('Se ha eliminado con éxito el archivo.',$resultado); 
      
     }
     else
     {
      mensaje('Ocurrio un error al momento de eliminar, por favor intentelo de nuevo.',$resultado); 
     }
  }
  
}
else
{
	mensaje("No tiene acceso a esta aplicacion",'');
}

?>
<?php
	include ("./lib/body_footer.php");
	?>


    <script>
    function ejecutarhistoria(tipo)
    {    
    
        
  
   
                 


        


      

    }                    
 
    </script>

