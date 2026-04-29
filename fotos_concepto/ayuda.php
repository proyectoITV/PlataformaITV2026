<?php
    include ("./unica/body_head.php");
    include ("./unica/body_menu.php");
?>

<?php

    
$id_aplicacion ="ap62"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
//$nivel='1';

// echo "<div id='ayuda_misapp'>";
// if ($nivel=='1'){
//     //echo "<h1 style='font-size:9pt;'>Apps:</h1>";
//     $sql="
//     SELECT
// 		aplicaciones_permisos.idapp as MiApp,
// 		aplicaciones_permisos.nivel, 
// 		aplicaciones_permisos.quien_autorizo as autorizo,
// 		(select empleados.nombre from empleados where nitavu = autorizo) as autorizo_nombre,
// 		(select aplicaciones.nombre from aplicaciones where idapp = MiApp) as App,
// 		(select aplicaciones.descripcion from aplicaciones where idapp = MiApp),
// 		(select aplicaciones.icono from aplicaciones where idapp = MiApp) as icono,
// 		(select aplicaciones.vinculo from aplicaciones where idapp = MiApp) as url,
// 		(select aplicaciones.idapcat from aplicaciones where idapp = MiApp) as Categoria_id,
// 		(select aplicaciones_categoria.nombre from aplicaciones_categoria where aplicaciones_categoria.idapcat = Categoria_id) as Categoria
		
//     FROM
//         aplicaciones_permisos
//     GROUP BY MiApp
//     ";

// } else {
//     //echo "<h1 style='font-size:9pt;'>Mis Apps:</h1>";
//     $sql="SELECT
// 		aplicaciones_permisos.idapp as MiApp,
// 		aplicaciones_permisos.nivel, 
// 		aplicaciones_permisos.quien_autorizo as autorizo,
// 		(select empleados.nombre from empleados where nitavu = autorizo) as autorizo_nombre,
// 		(select aplicaciones.nombre from aplicaciones where idapp = MiApp) as App,
// 		(select aplicaciones.descripcion from aplicaciones where idapp = MiApp),
// 		(select aplicaciones.icono from aplicaciones where idapp = MiApp) as icono,
// 		(select aplicaciones.vinculo from aplicaciones where idapp = MiApp) as url,
// 		(select aplicaciones.idapcat from aplicaciones where idapp = MiApp) as Categoria_id,
// 		(select aplicaciones_categoria.nombre from aplicaciones_categoria where aplicaciones_categoria.idapcat = Categoria_id) as Categoria
		
// FROM
// 	aplicaciones_permisos
// WHERE
//     nitavu = '".$nitavu."' ORDER by idapp";
// }
// //echo $sql;
// echo "<table class='tabla'>";
// $r2 = $conexion -> query($sql);
// while($f = $r2 -> fetch_array())
// {
//    $url="?idapp=".$f['MiApp'];
//     echo "<article><a class=movil href=$url>"; echo "<img src='icon/".$f['icono']."' class='ayuda_icono'>"; echo "</a></article>";

//     echo "<tr class='pc'>";
 
//     if (isset($_GET['idapp'])){
//         if ($f['MiApp'] == $_GET['idapp']){
//         echo "<td style='background-color:#00192B;'>";
//         } else {echo "<td>";}
//     } else {echo "<td>";}
//     echo "<a href=$url>"; echo "<img src='icon/".$f['icono']."' class='ayuda_icono'>"; echo "</a>";
//     echo "</td>";
    
//     if (isset($_GET['idapp'])){
//         if ($f['MiApp'] == $_GET['idapp']){
//         echo "<td style='background-color: #00192B; color:white;'>";
//         } else {echo "<td>";}
//     } else {echo "<td>";}
    
//     echo "<a href=$url style='font-size:10pt;'>"; echo $f['App']; echo "</a>";
//     echo "</td>";
//     echo "</tr>";
// }    

// $r2 = $conexion -> query('select * from aplicaciones where idapcat in(2,8)');
// while($f = $r2 -> fetch_array())
// {
//    $url="?idapp=".$f['idapp'];
//     echo "<article><a class=movil href=$url>"; echo "<img src='icon/".$f['icono']."' class='ayuda_icono'>"; echo "</a></article>";

//     echo "<tr class='pc'>";
 
//     if (isset($_GET['idapp'])){
//         if ($f['idapp'] == $_GET['idapp']){
//         echo "<td style='background-color:#00192B;'>";
//         } else {echo "<td>";}
//     } else {echo "<td>";}
//     echo "<a href=$url>"; echo "<img src='icon/".$f['icono']."' class='ayuda_icono'>"; echo "</a>";
//     echo "</td>";
    
//     if (isset($_GET['idapp'])){
//         if ($f['idapp'] == $_GET['idapp']){
//         echo "<td style='background-color: #00192B; color:white;'>";
//         } else {echo "<td>";}
//     } else {echo "<td>";}
    
//     echo "<a href=$url style='font-size:10pt;'>"; echo $f['nombre']; echo "</a>";
//     echo "</td>";
//     echo "</tr>";
// }    
// echo "</table>";
// echo "</div>";

echo "<section id='ayuda_contenido'>";
if (isset($_GET['idapp'])){




        
    //listar directorio
    echo "<div>";
    $path="ayuda/";  $app = $_GET['idapp']; $clase='foto';
    $directorio = opendir($path);   $directorio=dir($path);
    //echo "Directorio ".$path.":<br><br>"; 
    $errores=""; $modulo=""; $noayuda=0;
    $mod_imagenes = "<section id='mod_imagenes'><h1>Imagenes</h1>"; $mod_audios="<section id='mod_audios'><h1>Audios</h1>"; $mod_videos="<section id='mod_videos'><h1>Videos</h1>";
    $mod_pdf="<section id='mod_pdf'><h1>Documentos PDF</h1>";
    $c_pdf=0; $c_audios=0; $c_videos=0; $c_imagenes=0;
    while ($archivo = $directorio->read())
    {
        if ($archivo<>"." and $archivo<>".."){
            //echo $path.$archivo;       
            $ext= substr($archivo,strlen($archivo)-3,3);  $ext =strtolower($ext);
            $pre_archivo = substr($archivo,0, strlen($app));
            
            if ($pre_archivo==$_GET['idapp']){
                //filtrado por tipos           
            
                //echo "<b class='ejecutandose'>".$ext."(".$path.$archivo.")</b>";
                if ($ext == 'pdf'){ //echo '<b style=color:purple>es PDF</b>'; 
                        //echo "<b class='alterta'>es pdf</b><br>";
                        $mod_pdf = $mod_pdf.
                        '<div><iframe src="'.$path.$archivo.'" class="'.$clase.'"></iframe><a title="'.$archivo.'" href="'.$path.$archivo.'" target class="btn"><br>Ver completo </a></div>';
                        $c_pdf= $c_pdf+1;
                }else {
                    if ($ext =='png' or $ext=='jpg' or $ext=='gif'){
                        //echo "<b class='alterta'>es imagen</b><br>";
                        $mod_imagenes = $mod_imagenes.'<a title="'.$archivo.'" href="'.$path.$archivo.'" title="Haga clic aqui para abrirla" target=_BLANK><img src="'.$path.$archivo.'" class="'.$clase.'"></a>';
                        $c_imagenes=$c_imagenes+1;

                    } else {
                        if ($ext =='acc' or $ext=='wav' or $ext=='mp3' or $ext=='caf'){
                            //echo "<b class='alterta'>es audio</b><br>";
                            $mod_audios = $mod_audios.'<audio class="'.$clase.'" controls title="'.$archivo.'">';
                            if ($ext=='wav'){$mod_audios = $mod_audios.'<source src="'.$path.$archivo.'" type="audio/wav">';}                        
                            if ($ext=='acc'){$mod_audios = $mod_audios.'<source src="'.$path.$archivo.'" type="audio/acc">';}
                            if ($ext=='mp3'){$mod_audios = $mod_audios.'<source src="'.$path.$archivo.'" type="audio/mpeg">';}
                            if ($ext=='caf'){$mod_audios = $mod_audios.'<source src="'.$path.$archivo.'" type="audio/x-caf">';}                    
                            $mod_audios = $mod_audios.'';
                            $mod_audios = $mod_audios.'Tu navegador no soporta la reproduccion de Audio';                    
                            $mod_audios = $mod_audios.'</audio>';      
                            $c_audios=$c_audios+1;

                        }
                        else {
                            if ( $ext=='mov' or $ext=='mp4' or $ext=='webm' or $ext=='ogg'){
                                //echo "<b class='alterta'>es video</b><br>";
                                    $mod_videos = $mod_videos.'<video class="'.$clase.'" controls fullscreen title="'.$archivo.'">';
                                    //if ($ext=='avi'){$modulo = $modulo.'<source src="'.$path.$archivo.'" type="video/avi">';}
                                    if ($ext=='mp4'){$mod_videos = $mod_videos.'<source src="'.$path.$archivo.'" type="video/mp4">';}
                                    if ($ext=='ogg'){$mod_videos = $mod_videos.'<source src="'.$archivo.'" type="video/ogg">';}
                                    //if ($ext=='mov'){$modulo = $modulo.'<source src="'.$path.$archivo.'" type="video/quicktime">';}
                                    if ($ext=='mov'){$mod_videos = $mod_videos.'<source src="'.$path.$archivo.'" type="video/mp4">';}
                                    //if ($ext=='mpg'){$modulo = $modulo.'<source src="'.$path.$archivo.'" type="video/mpeg">';}
                                    if ($ext=='webm'){$mod_videos = $mod_videos.'<source src="'.$archivo.'" type="video/webm">';}
                                $mod_videos = $mod_videos.'';
                                $mod_videos = $mod_videos.'Tu navegador no soporta la reproduccion de video';                    
                                $mod_videos = $mod_videos.'</video>';  
                                $c_videos=$c_videos+1;
                            
                            }
                            else {
                                $errores= $errores.$path.$archivo.", ";
                            }

                        }
                    }

                    }//end if ext
                }
                else{$noayuda=$noayuda+1;}
        }//fin no dir
    }  //fin recorrido while  
     
    $directorio->close();   

        //if ($errores==''){

        echo "<h5>".app_detalle($_GET['idapp'])."</h5>";
        echo ayuda_ayuda($_GET['idapp'])."<br>";
        if ($c_pdf>0) {echo $mod_pdf.""."</section>";}
        if ($c_imagenes>0) {echo $mod_imagenes.""."</section>";}
        if ($c_audios>0) {echo $mod_audios.""."</section>";}
        if ($c_videos>0){echo $mod_videos."</section>";}

        // echo '<label>* No han sido compatibles: <b> '.$errores."</b></label>";

        if ($noayuda>0){
            //sentimental("Sin ayuda disponible");
        }

    echo "</div>";












if ($nivel=='1' and isset($_GET['idapp'])){
    
    $sql = "
    SELECT * from aplicaciones WHERE idapp='".$_GET['idapp']."'    ";
    //echo $sql;
    $r= $conexion -> query($sql);
    if($app = $r -> fetch_array())
	{
        if (isset($_GET['idapp'])){    
            echo "<br><br><br><hr><form action='ayuda.php?idapp=".$_GET['idapp']."' method='POST' enctype='multipart/form-data' id='ayuda_form'>";
            echo "<div style='color:orange; margin: 5px;' >Tienes permiso para editar el texto de ayuda o subir material multimedia.</div>"; 
            //echo "Aplicacion: <b>".$app['App']."</b> </div >";
            echo "<input type='hidden' name='idapp' value='".$_GET['idapp']."' >";
            echo "<div><label>Material didacto a subir: </label><input type='file' name='material' ><label>Archivos aceptados: <b>Imagenes</b>( .JPG, .GIF y .PNG), <b>Documentos </b> PDF, <b>Videos</b>(.MP4, .WEBM, .OGG, ,MPG y .MOV), <b>Audio</b>(.MP3 y .MP4)</label></div>";
            echo "<span><label>Texto de ayuda</label><textarea name='ayuda'>".ayuda_ayuda($_GET['idapp'])."</textarea></span>";
            echo "<div><input type='submit' value='Guardar' class='btn btn-default' name='subir_ayuda'></div>";

            echo "</form><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";

            if (isset($_POST['subir_ayuda'])){

                $archivo = 'ayuda/'.$_GET['idapp'].'';
                $m = subir_beta('material',$archivo,'');
                if ($m=='Archivo subido con exito.!!'){
                    //informar a usuarios de aplicaciones
                    $contenido='Se ha añadido un elemento multimedia a la ayuda de la aplicacion '.ayuda_nombre($_GET['idapp']).'<br>
                    <a style=background-color:#BBF4EC,border-color:#009999;border-style:solid;border-width:2px;color:#009999;padding:10px;margin:10px;width:50%; href='.$urlsite.'/ayuda.php?idapp='.$_GET['idapp'].'> IR a la AYUDA de la Plataforma</a>
                    ';
                    informar_usuariosapps($_GET['idapp'], $contenido,$nitavu);

                    
                }
                //actualizamos el texto de ayuda
                $sql = "UPDATE aplicaciones SET ayuda='".$_POST['ayuda']."' WHERE idapp='".$_GET['idapp']."'";
                $r = $conexion -> query($sql); if ($conexion->query($sql) == TRUE) {
                    historia($nitavu, "Actualizo el texto de ayuda de la aplicacion ".ayuda_nombre($_GET['idapp'])."");
                    $m = $m.". Se actualizo correctamente.";
                    //informa a usuarios de aplicaciones
                    $contenido = '<p>Se ha actualizado informacion sobre '.ayuda_nombre($_GET['idapp']).'</p><p>'.$_POST['ayuda'].'</p>
                    <a style=background-color:#BBF4EC,border-color:#009999;border-style:solid;border-width:2px;color:#009999;padding:10px;margin:10px;width:50%; href='.$urlsite.'"/ayuda.php?idapp='.$_GET['idapp'].'> IR a la AYUDA de la Plataforma</a>';
                    informar_usuariosapps($_GET['idapp'], $contenido,$nitavu);

                }       
                else {mensaje("ERROR: al intentar guardar ".$sql,'');}

                mensaje($m."(".$archivo.")",'../itavu/ayuda.php?idapp='.$_GET['idapp']);

            }



        } else{
            echo "<p>Bienvenido al area de administración de la ayuda, desde aquí podras subir el material didactico que podra ver cada usuario
            para apoyarse en el manejo correcto de la aplicación.<p><p>Selecciona del panel de tu izquierda la aplicacion para empezar.</p>";



            
        }


    }


}


}//isset idapp get
else{
    echo "<H1>AYUDA DE LA PLATAFORMA</H1>";
    

            echo "<table style='width:100%;'><tr><td align=left>";
            echo "<img src='img/flecha.png' style='width:200px;' class='pc'>";
            echo "<img src='img/flecha2.png' style='width:200px;' class='movil'>";
            echo "<p>Selecciona una aplicacion de la lista de aplicaciones autorizadas para obtener la ayuda multimedia disponible.</p> ";

            echo "</td><td align=left>";
            
            echo "</td></tr>";

            echo "</table>";


            echo "<p>Estamos a tus ordenes: </p>";
            
                $r2 = $conexion -> query("select * from empleados where dpto=55 and estado=''");
                echo "<section id='informaticos'>Departamento de Informatica: <table class='tabla'><th>Nombre</th><th>Extension Tel.</th><th>Correo</th>";
                while($f = $r2 -> fetch_array())
                {
                    if ($f['puesto']=='Jefe'){
                    echo "<tr style='background-color:#A5D178;'>";    
                }else {
                    echo "<tr>";
                }
                    
                    echo "<td>".$f['profesion_abr'].".".$f['nombre']."</td>";
                    echo "<td>".$f['telefono_extension']."</td>";
                    echo "<td>".$f['correoelectronico']."</td>";

                    echo "</tr>";
                }
                echo "</table></section>";

                $r2 = $conexion -> query("select * from empleados where dpto=4 and estado=''");
                echo "<section id='soporte'>Departamento de Soporte Tecnico: <table class='tabla'><th>Nombre</th><th>Extension Tel.</th><th>Correo</th>";
                while($f = $r2 -> fetch_array())
                {
                    if ($f['puesto']=='Jefe'){
                    echo "<tr style='background-color:#A5D178;'>";    
                }else {
                    echo "<tr>";
                }
                    
                    echo "<td>".$f['profesion_abr'].".".$f['nombre']."</td>";
                    echo "<td>".$f['telefono_extension']."</td>";
                    echo "<td>".$f['correoelectronico']."</td>";

                    echo "</tr>";
                }
                echo "</table></section>";



}

echo "</section>";


?>

















<?php //include ("./unica/body_footer.php");?>



<?php
//NUEVA FUNCION PARA SUBIR
function subir_beta($nombredelcontrol, $archivo,$ext) //--------------------------------------------------------------------------
{ $ext =''; $msgE='';
//OBTENTGO LA EXTENSIÓN 
//$ext= substr($_FILES[$nombredelcontrol]['name'],strlen($_FILES[$nombredelcontrol]['name'])-3,3);	
$ext = pathinfo( $_FILES[$nombredelcontrol]['name'], PATHINFO_EXTENSION );

if ( isset( $_FILES ) && isset( $_FILES[$nombredelcontrol] ) && !empty( $_FILES[$nombredelcontrol]['name'] && !empty($_FILES[$nombredelcontrol]['tmp_name']) ) ) 
{
  //  echo "<h1>archivo: ".$_FILES[$nombredelcontrol]['tmp_name']."</h1>";
	//Hemos recibido el fichero
	//Comprobamos que es un fichero subido por PHP, y no hay inyección por otros medios
	if ( ! is_uploaded_file( $_FILES[$nombredelcontrol]['tmp_name'] ) ) 
	{$msgE= "ERROR: El fichero encontrado no fue procesado por la subida correctamente";} 

	// reconocer tipos de formatos: referencia: http://www.htmlquick.com/es/reference/mime-types.html
    if(
        $_FILES[$nombredelcontrol]["type"]=="image/jpg"         ||   $_FILES[$nombredelcontrol]["type"]=="image/jpeg"        ||
        $_FILES[$nombredelcontrol]["type"]=="image/pjpeg"       ||   $_FILES[$nombredelcontrol]["type"]=="image/gif"         ||
        $_FILES[$nombredelcontrol]["type"]=="image/png"         ||   
                                         mime_content_type($_FILES[$nombredelcontrol]['tmp_name']) == 'application/pdf'      ||
       
        $_FILES[$nombredelcontrol]["type"]=="video/mp4"         ||   $_FILES[$nombredelcontrol]["type"]=="audio/mp4"         ||
        $_FILES[$nombredelcontrol]["type"]=="audio/mpeg"        ||   $_FILES[$nombredelcontrol]["type"]=="audio/vnd.wave"    ||
        $_FILES[$nombredelcontrol]["type"]=="audio/x-aac"       ||   $_FILES[$nombredelcontrol]["type"]=="audio/x-caf"       ||
        $_FILES[$nombredelcontrol]["type"]=="video/quicktime"   ||   $_FILES[$nombredelcontrol]["type"]=="video/webm"        ||
        $_FILES[$nombredelcontrol]["type"]=="video/ogg"         ||  $_FILES[$nombredelcontrol]["type"]=="audio/mp3"  
     
    )
	{
		$destino=$archivo.'-'.ndocumento(False).'.'.$ext;			
		if ( is_file($destino ) )
		{
			$msgE= "ERROR: Ya existe almacenado un fichero con ese nombre";
			@unlink(ini_get('upload_tmp_dir').$_FILES[$nombredelcontrol]['tmp_name']);			
		}
			
		if ( ! @move_uploaded_file($_FILES[$nombredelcontrol]['tmp_name'], $destino) ) 
		{
			$msgE= "ERROR: No se ha podido mover el fichero enviado a la carpeta de destino";
			@unlink(ini_get('upload_tmp_dir').$_FILES[$nombredelcontrol]['tmp_name']);
			
		}
		else
		{
			//$msgE= $destino. "";
			$msgE="Archivo subido con exito.!!";
		}
	}
	else
	{
		$msgE= "ERROR: El archivo que intenta subir no tiene un formato correcto.";
		
	}
				
	
	}
	return $msgE;

}//----------------------------------------------------------------------------------------------------------------





function insertar_media($archivo,$clase)
{ 


    
//     if (file_exists($archivo)){
//     //filtrado por tipos
//     $imagenes[0]='png'; $imagenes[1]='jpg'; $imagenes[2]='gif'; 
//     $audio[0]='acc'; $audio[1]='mp4'; $audio[2]='mp3'; $audio[3]='wav'; $audio[4]='caf'; 
//     $video[0]='avi'; $video[1]='mpg'; $video[2]='mov';
//     $ext1 =strtolower($ext1);
//     $modulo="";

//         switch ($ext1) {
//             case 'pdf':
//                 //echo '<b style=color:purple>es PDF</b>'; 
//                 $modulo = $modulo.
//                 '<iframe src="'.$archivo.'" class="'.$clase.'"></iframe><a href="'.$archivo.'" target class="btn"><br>Ver completo</a>';
//                 break;

//             case ($imagenes[0] || $imagenes[1] || $imagenes[2])://imagen
//                 echo '<b style=color:purple>es imagen</b>'; 
//                 $modulo = $modulo.'<img src="'.$archivo.'" class="'.$clase.'">';
//                 break;

//             case ($audio[0] || $audio[1] || $audio[2] || $audio[3] || $audio[4])://audio
//                 echo '<b style=color:purple>es un audio</b>'; 
//                     $modulo='';
//                     $modulo = $modulo.'<audio class="'.$clase.'" controls>';
//                     if ($ext=='wav'){$modulo = $modulo.'<source src="'.$archivo.'" type="audio/wav">';}
//                     if ($ext=='mp4'){$modulo = $modulo.'<source src="'.$archivo.'" type="audio/mp4">';}
//                     if ($ext=='acc'){$modulo = $modulo.'<source src="'.$archivo.'" type="audio/acc">';}
//                     if ($ext=='mp3'){$modulo = $modulo.'<source src="'.$archivo.'" type="audio/mpeg">';}
//                     if ($ext=='caf'){$modulo = $modulo.'<source src="'.$archivo.'" type="audio/x-caf">';}                    
//                     $modulo = $modulo.'';
//                     $modulo = $modulo.'Tu navegador no soporta la reproduccion de Audio';                    
//                     $modulo = $modulo.'</audio>';
                    
//                 break;

//              case ($video[0] || $video[1] || $video[2])://imagen
//                 echo '<b style=color:purple>es video</b>'; 
//                     $modulo=''; echo "es video";
//                     $modulo = $modulo.'<video class="'.$clase.'" controls>';
//                     if ($ext=='avi'){$modulo = $modulo.'<source src="'.$archivo.'" type="video/avi">';}
//                     if ($ext=='mp4'){$modulo = $modulo.'<source src="'.$archivo.'" type="video/mp4">';}
//                     if ($ext=='ogg'){$modulo = $modulo.'<source src="'.$archivo.'" type="video/ogg">';}
//                     if ($ext=='mov'){$modulo = $modulo.'<source src="'.$archivo.'" type="video/quicktime">';}
//                     if ($ext=='mpg'){$modulo = $modulo.'<source src="'.$archivo.'" type="video/mpg">';}
//                     if ($ext=='webm'){$modulo = $modulo.'<source src="'.$archivo.'" type="video/webm">';}
//                     $modulo = $modulo.'';
//                     $modulo = $modulo.'Tu navegador no soporta la reproduccion de video';                    
//                     $modulo = $modulo.'</video>';                    
//                 break;


//             default:
//                 $errores ='Tipo no compatible ('.$ext1.')';
//                 break;




//         }
//     } else { $errores=$errores.'El archivo '.$archivo.' no existe. ';}






// if ($errores==''){
//     return 'ok'.$modulo;

// }
// else{
//     return $errores;
// }

//     //echo "<h1 class=ejecutandose>".var_dump($clave)."</h1>";
//     if (file_exists($archivo)){

//         $imagenes[0]='png'; $imagenes[1]='jpg'; $imagenes[2]='gif'; 
//         $audio[0]='acc'; $audio[1]='mp4'; $audio[2]='mp3'; $audio[3]='wav'; $audio[4]='caf'; 
//         $video[0]='avi'; $video[1]='mpg'; $video[2]='mov';
//         $ext1 =strtolower($ext1);
//         echo "<h1 class=alerta>Ext. ".$ext1."</h1>";
//         if($ext1=='pdf') ////////////////// P D F
//         {
//             return '<iframe src="'.$archivo.'" class="'.$clase.'"></iframe><a href="'.$archivo.'" target class="btn"><br>Ver completo</a>';
//         }
//         else
//         {//sino es un pdf
//             echo $imagenes[1]."=".$ext1.$archivo;
//             if ($ext1 == $imagenes[0] || $ext1==$imagenes[1]|| $ext == $imagenes[2] )//////// I M A G E NE S 
//             {return '<img src="'.$archivo.'" class="'.$clase.'">'; }
//             else {
//                 if ($ext1 == $video[0] or $ext1==$video[1] or $ext == $video[2] )////// V I D E O S 
//                 {   $tmpVideo=''; echo "es video";
//                     $tmpVideo = $tmpVideo.'<video class="'.$clase.'" controls>';
//                     if ($ext=='avi'){$tmpVideo = $tmpVideo.'<source src="'.$archivo.'" type="video/avi">';}
//                     if ($ext=='mp4'){$tmpVideo = $tmpVideo.'<source src="'.$archivo.'" type="video/mp4">';}
//                     if ($ext=='ogg'){$tmpVideo = $tmpVideo.'<source src="'.$archivo.'" type="video/ogg">';}
//                     if ($ext=='mov'){$tmpVideo = $tmpVideo.'<source src="'.$archivo.'" type="video/quicktime">';}
//                     if ($ext=='mpg'){$tmpVideo = $tmpVideo.'<source src="'.$archivo.'" type="video/mpg">';}
//                     if ($ext=='webm'){$tmpVideo = $tmpVideo.'<source src="'.$archivo.'" type="video/webm">';}
//                     $tmpVideo = $tmpVideo.'';
//                     $tmpVideo = $tmpVideo.'Tu navegador no soporta la reproduccion de video';                    
//                     $tmpVideo = $tmpVideo.'</video>';
//                     return $tmpVideo;                            
//                 }else {
//                         if ($ext1 == $audio[0] || $ext1==$audio[1]|| $ext == $audio[2] || $ext == $audio[3] || $ext == $audio[4] )////// A U D I O S 
//                         {
//                         $tmpAudio='';
//                         $tmpAudio = $tmpAudio.'<audio class="'.$clase.'" controls>';
//                         if ($ext=='wav'){$tmpAudio = $tmpAudio.'<source src="'.$archivo.'" type="audio/wav">';}
//                         if ($ext=='mp4'){$tmpAudio = $tmpAudio.'<source src="'.$archivo.'" type="audio/mp4">';}
//                         if ($ext=='acc'){$tmpAudio = $tmpAudio.'<source src="'.$archivo.'" type="audio/acc">';}
//                         if ($ext=='mp3'){$tmpAudio = $tmpAudio.'<source src="'.$archivo.'" type="audio/mpeg">';}
//                         if ($ext=='caf'){$tmpAudio = $tmpAudio.'<source src="'.$archivo.'" type="audio/x-caf">';}                    
//                         $tmpAudio = $tmpAudio.'';
//                         $tmpAudio = $tmpAudio.'Tu navegador no soporta la reproduccion de Audio';                    
//                         $tmpAudio = $tmpAudio.'</audio>';
//                         return $tmpAudio;
//                         }
                    
//                 }
//                 return "No es video";
                    
//             }

                    
//                 return "No es PDF";

//             }




//     }           
            
// } else 
//     {
//     return '<h1>Error en el '.$archivo.'</h1>';
//     //return '<img src="icon/sinfoto.png" class="'.$clase.'">';
//     }

}//fin funcion

	



?>
<script type="text/javascript">

    $('#preloader').hide();
    

</script> 


