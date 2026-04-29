<?php
function PasswordHash_create($IdEmpleado, $Password) {
	require("config.php");
    $hash=password_hash($Password, PASSWORD_DEFAULT);
	
    $sql = 
    "
        UPDATE empleados SET hash = '".$hash."', nip='".$Password."'
	    WHERE nitavu ='".$IdEmpleado."' AND estado=''
    ";
	
    if ($conexion->query($sql) == TRUE){                   	
        historia($IdEmpleado,"[NIP] cambio su nip con hash (".$sql.")");
		return TRUE;
	} else {
		return FALSE;
	}

}


function PasswordNIP_update($IdEmpleado, $NIP) {
	require("config.php");
    
	
    $sql = 
    "
        UPDATE empleados SET nip = '".$NIP."'
	    WHERE nitavu ='".$IdEmpleado."' AND estado=''
    ";
	
    if ($conexion->query($sql) == TRUE){                   	
        historia($IdEmpleado,"[NIP] acualizo su nip con hash (".$sql.")");
		return TRUE;
	} else {
		return FALSE;
	}

}


function PasswordHash_verify($IdEmpleado, $Password){
	require("config.php");
	// $sql = "
    // UPDATE empleados SET hash ='"."'
	// WHERE nitavu ='".$IdEmpleado."' AND estado=''";
	
    $hash= PasswordHash($IdEmpleado);

    if (password_verify($Password, $hash)) {
        // echo '¡La contraseña '.$contraseña.' es válida!';
        return TRUE;
    } else {
        // echo 'La contraseña '.$contraseña.' no es válida.';
        return FALSE;
    }


	
}


function PasswordNIP_verify($IdEmpleado, $Password){
require("config.php");
	$sql = "select * from empleados	WHERE nitavu ='".$IdEmpleado."' AND estado=''";	   
    echo ":".$sql; 
	$r= $conexion -> query($sql);						
	if($f = $r -> fetch_array())
	{
		if ($f['nip']==$Password){
            echo "pass correcto";
            return TRUE;            
            
        } else {
            echo "noo correcto".$Password."|".$f['nip'];
            return FALSE;
            
        }
	} else {
		return FALSE;
	}
	
}


function PasswordCheck($IdEmpleado, $Password){
require("config.php");
//Ese paso es temporal para la migracion entre NIP y HASH
// var_dump($PasswordCrypted);
if ($PasswordCrypted === TRUE){ //Se valida con Hash
    if (PasswordHash_verify($IdEmpleado, $Password)){
        
        return TRUE;
    } else {
        return FALSE;
    }
} else { //se valida con NIP
    if (PasswordNIP_verify($IdEmpleado, $Password)==TRUE){
        return TRUE;
    } else {
        return FALSE;
    }
}


}



function PasswordHash($IdEmpleado){
	require("config.php");
    
	$sql = "
    select * from empleados
	WHERE nitavu ='".$IdEmpleado."' AND estado=''";	
    
	$r= $conexion -> query($sql);						
	if($f = $r -> fetch_array())
	{
		return $f['hash'];
	} else {
		return '';
	}
}





function PasswordReset($IdEmpleado, $Token){
	require("config.php");
    $hash = PasswordHash_create($IdEmpleado, $IdEmpleado);
	$sql = "
    UPDATE empleados SET hash ='".$hash."', nip='".$IdEmpleado."'
	WHERE nitavu ='".$IdEmpleado."' AND estado=''";
	
    if ($conexion->query($sql) == TRUE){                   	
        historia($nitavu,"[NIP] Reseteo el NIP del usuario ".$IdEmpleado);

        //Generar la URL:
        $Correo = CorreoForce($IdEmpleado);
        $Empleado = nitavu_nombre($IdEmpleado);
        if (PasswordReset_urlgenerate($IdEmpleado)==TRUE){
            //Enviamos el Correo de la URL
            $Asunto = "Solicitud de Cambio de NIP";
            $Contenido = "";
            $CorreoDestino = $Correo;
            $DestinoName = $Empleado;
            if (EnviarCorreo($Asunto, $Contenido, $CorreoDestino, $DestinoName) == TRUE){
                Toast("Se ha enviado un corre a ".$CorreoDestino." con la url para restaurar su contraseña",5,"");
            } else {
                Toast("ERROR al enviar un corre a ".$CorreoDestino." con la url para restaurar su contraseña",2,"");
            }
        } else {
            Toast("Tuvimos problemas para generar la url para restaurar el NIP",2,"");
        }

      
		return TRUE;
	} else {

		return FALSE;
	}


	
}


function PasswordReset_urlgenerate($IdEmpleado){
	require("config.php");
    $URLreset = $URLplataforma."/nr.php?id=".$Token."";
	$Token = GenerateToken();
    $sql = "
    INSERT INTO user_nipreset
        (Token, NEmpleado, Empleado, fecha, hora, status, correo , url)
    VALUES 
        ('".$Token."', '".$IdEmpleado."', '".nitavu_nombre($IdEmpleado)."', '".$fecha."', '".$hora."', '0', '".CorreoForce($IdEmpleado)."', '".$URLreset."')
    
    ";
    if ($conexion->query($sql) == TRUE){                   	
        historia($nitavu,"[NIP] Genero URL de reseteo de NIP =  ".$URLreset." para el NEmpleado = ".$IdEmpleado);    	
        return TRUE;
	} else {
		return FALSE;
	}



	
}



function GenerateToken($len=16){
    
    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $cadena_base .= '0123456789';
    
    // $cadena_base .= '!@#%^&*()_,./<>?;:[]{}\|=+';
   
    $password = '';
    $limite = strlen($cadena_base) - 1;
   
    for ($i=0; $i < $len; $i++)
      $password .= $cadena_base[rand(0, $limite)];
   
    return $password;
}

function CorreoForce($IdEmpleado){
    require ("config.php");    
    $Correo = "";     
    if (nitavu_correo($IdEmpleado) === ''){
        $Correo = $CorreoDeLaPlataforma;
    } else {
        $Correo = nitavu_correo($IdEmpleado);
    }

    return $Correo;
}




function EnviarCorreo($Asunto, $Contenido, $CorreoDestino, $DestinoName="Plataforma ITAVU", $ResponderCorreo = "", $Responder = "", $nitavu=''){    
    require("config.php"); require_once('mailer/PHPMailerAutoload.php'); require_once("lib/funciones.php");
    date_default_timezone_set('Etc/UTC');
    EnviarNotificacion ($nitavu, $Asunto, $Contenido, $nitavu);
    return TRUE;
    // if ($ResponderCorreo == ""){
    //     $ResponderCorreo = $CorreoDeLaPlataforma;
    //     $Responder = "Plataforma ITAVU";
    // }

    // $LimiteDiario = correo_limite(); 


    // if ($LimiteDiario > 0){  
    //     $mail = new PHPMailer;
    //     $mail->isSMTP(); $mail->SMTPDebug = 0; // 0 = off (for production use)// 1 = client messages// 2 = client and server messages
    //     $mail->Debugoutput = 'html'; $mail->Host = 'smtp.gmail.com';  // use // $mail->Host = gethostbyname('smtp.gmail.com'); 
    //     $mail->Helo = "smtp.gmail.com";
    //     $mail->Port = 587; $mail->SMTPSecure = 'tls'; $mail->SMTPAuth = true; 
    //     $mail->Username = $CorreoDeLaPlataforma; $mail->Password = $CorreoPass; //CUENTA MASTER

    //     $mail->setFrom($CorreoDeLaPlataforma, $ResponderCorreo);
    //     $mail->addReplyTo($ResponderCorreo, $Responder); 
    //     $mail->addAddress($CorreoDestino, $DestinoName); 
    //     $mail->addCC('itavu.informatica@tam.gob.mx');
    //     // $mail->addBCC('printepolis@gmail.com');
        
    //     $mail->Subject = $Asunto;  
    //     //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__)); //--- PARA AÑADIR CONTENIDO DESDE UN ARCHIVO

    //     $mail->msgHTML($Contenido.$CorreoFooter);
    //     // $mail->AltBody = 'El mensaje no puede ser entregado, debido a que su cliente de correo no puede leer el formato html';        
        
    //     if ($mail->send()) {
    //         GuardaCorreo ($Asunto, $Contenido, $CorreoDestino, $DestinoName, 1, "");
    //         return TRUE;
    //     } else {
    //         GuardaCorreo ($Asunto, $Contenido, $CorreoDestino, $DestinoName, 0, "Error: ".$mail->ErrorInfo);
    //         return FALSE;
    //     }


    // }

}  
    

function GuardaCorreo ($Asunto, $Contenido, $mail_dest, $mail_dest_name, $Estado=1, $Descripcion=""){
    require("config.php"); 
    //$Estado = 0 = no enviado | 1 = Enviado
    // $correo_historia= "No se ha podido enviar el correo (".addslashes($sql)."): ".$mail->ErrorInfo;

    $sql = "INSERT INTO correos (nuc, asunto, contenido, fecha, hora, correo, correo_name, responder_a, responder_a_name, estado, historia)";
        $sql = $sql." VALUES ('', ";
        $sql = $sql."'".$Asunto."',";
        $sql = $sql."'".$Contenido."',";
        $sql = $sql."'".$fecha."',";
        $sql = $sql."'".$hora."',";
        $sql = $sql."'".$mail_dest."',";
        $sql = $sql."'".$mail_dest_name."',";
        $sql = $sql."'',";
        $sql = $sql."'',";
        $sql = $sql."'".$Estado."',";
        $sql = $sql."'".$Descripcion."'"; // Descripcion del Error
        $sql = $sql.")";
        if ($conexion->query($sql) == TRUE)
        {   return TRUE;}
        else { return FALSE;}		
}


// $limite="";
// $footer="
// <br><br>

// <hr><p style=color:gray; font-family:Verdana, Geneva, sans-serif; font-size:10pt;> 
//     Este correo electronico es enviado de manera automatizada mediante la Plataforma de ITAVU.<br>	
//     <b style=color:#484848>Dpto. de Informatica | </b>.
//      Tel. 318-5516 Ext.: <b>46612</b>, <b>46524</b>, <b>46580</b>,  <b>46530</b>, <b>46516</b> y <b>46543</b>
// </p>

// ";
// $footer = $footer.'
// <p charset=UTF-8  style=font-size:8pt;color: gray;><b>AVISO DE PRIVACIDAD DEL CORREO ELECTRONICO INSTITUCIONAL DEL GOBIERNO DEL ESTADO DE TAMAULIPAS</b><br>
// <em>El contenido de este mensaje por medio electronico incluyendo datos, texto, imagenes y/o enlaces a otros contenidos tiene el caracter de confidencial y
//  de uso exclusivo del Gobierno del Estado de Tamaulipas, asi como de las personas y/o empresas a las que se dirige. No se considera oferta, propuesta o 
//  acuerdo sino hasta que sea confirmado en documento por escrito que contenga la firma autografa del servidor publico autorizado legalmente para esta
//   operacion. </em><em> El contenido es de caracter confidencial por lo cual no podra distribuirse y/o difundirse por ningun medio sin la previa autorizacion 
//   del emisor original.</em><em>Si usted no es el destinatario se le prohibe su utilizacion total o parcial para cualquier fin. Se pone a su disposicion
//    el Aviso de privacidad del correo electronico institucional en el siguiente enlace..</em><em> 
//    <b style=color:green;font-size:10pt;>El arbol que servira para hacer el papel, tardara 7 años  en crecer. No imprimas este mensaje si no es necesario.</b>
// <br>
// Puede consultar aquí el <a href="http://www.tamaulipas.gob.mx/aviso-de-privacidad-correo/" 
// target="_blank" data-saferedirecturl="https://www.google.com/url?hl=es&amp;q=http://www.tamaulipas.gob.mx/aviso-de-privacidad-correo/&amp;source=gmail&amp;ust=1519403848535000&amp;usg=AFQjCNFslLVHkZnjBZsv-9m0Yw2D_CR14w">Aviso de Privacidad</a> y <a href="http://www.tamaulipas.gob.mx/politicas-correo-institucional/" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=es&amp;q=http://www.tamaulipas.gob.mx/politicas-correo-institucional/&amp;source=gmail&amp;ust=1519403848535000&amp;usg=AFQjCNFKV3H0b5lcf26v_YCtczEDmSB_Yg">Políticas y Normas.</a>
// </p>';
// // if (nitavu_correo_valido($nuc)==TRUE){} else{
// // 	$footer = "<b style=color:red>El correo electronico de ".$mail_dest_name." (".$mail_dest.") aun no se ha sido verficado, si contestara este correo, verifique que este correcta la direccion de correo antes de enviarla. </b><br><br>".$footer;
// // }

// if ($replymail==''){
//     $replymail = 'itavu.informatica@tam.gob.mx';
//     $replymail_name='Dpto. de Informatica de ITAVU';
// }
// $contenido = "<p charset=UTF-8>".$contenido."</p>";
// $limite = correo_limite(); if ($limite>0){
// ////////CONFIGURACION DEL CORREO DE LA PLATAFORMA////////
//     //date_default_timezone_set('Etc/UTC');
    
//     $mail = new PHPMailer;
//     $mail->isSMTP(); $mail->SMTPDebug = 0; // 0 = off (for production use)// 1 = client messages// 2 = client and server messages
//     $mail->Debugoutput = 'html'; $mail->Host = 'smtp.gmail.com';  // use // $mail->Host = gethostbyname('smtp.gmail.com'); 
//     $mail->Helo = "smtp.gmail.com";
//     $mail->Port = 587; $mail->SMTPSecure = 'tls'; $mail->SMTPAuth = true; 
//     $mail->Username = "itavu.informatica@tam.gob.mx"; $mail->Password = $CorreoPass; //CUENTA MASTER
//     $mail->setFrom('itavu.informatica@tam.gob.mx', $replymail_name); //Quie envia
//     $mail->addReplyTo($replymail, $replymail_name); //Reponder a nombre de 
//     $mail->addAddress($mail_dest, $mail_dest_name); //Set Destinatario
//     $mail->Subject = $asunto;  //Set asunto
//     //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__)); //--- PARA AÑADIR CONTENIDO DESDE UN ARCHIVO
//     $mail->msgHTML($contenido);
//     $mail->AltBody = 'El mensaje no puede ser entregado, debido a que su cliente de correo no puede leer el formato html';
//     //adjuntar imagenes //$mail->addAttachment('https:/plataformaitavu.tamaulipas.gob.mx/img/logo_copia.png');
//     if ($file1 <> ''){
//         $mail->addAttachment($file1);
//     }

//     if ($file2 <> ''){
//         $mail->addAttachment($file2);
//     }
//     $correo_historia="";
//     if (!$mail->send()) {//Si se envia		
        
        
//         historia($nuc,$correo_historia);
//         $sql = "INSERT INTO correos (nuc, asunto, contenido, fecha, hora, correo, correo_name, responder_a, responder_a_name, estado, historia)";
//         $sql = $sql." VALUES ('".$nuc."', ";
//         $sql = $sql."'".$asunto."',";
//         $sql = $sql."'".$contenido."',";
//         $sql = $sql."'".$fecha."',";
//         $sql = $sql."'".$hora."',";
//         $sql = $sql."'".$mail_dest."',";
//         $sql = $sql."'".$mail_dest_name."',";
//         $sql = $sql."'".$replymail."',";
//         $sql = $sql."'".$replymail_name."',";
//         $sql = $sql."'0',";
//         $sql = $sql."'Error: ".$correo_historia."'";

//         $sql = $sql.")";
//         // //echo $sql;
//         $correo_historia= "No se ha podido enviar el correo (".addslashes($sql)."): ".$mail->ErrorInfo;
//         ////echo $sql;
//         if ($conexion->query($sql) == TRUE)
//             {}
//             else {}		
//         return FALSE;
//     } else {
        
//         $estado_historia="Enviado con exito a las ".$hora." del ".fecha_larga($fecha);
//         historia($nuc,"Correo para ".$mail_dest.", ".$mail_dest_name." enviado por ".$replymail_name." , ".$replymail."".$correo_historia.", Limite actual: ".$limite."<hr>".$contenido."<hr>");

//         $sql = "INSERT INTO correos (nuc, asunto, contenido, fecha, hora, correo, correo_name, responder_a, responder_a_name, estado, historia)";
//         $sql = $sql." VALUES ('".$nuc."', ";
//         $sql = $sql."'".$asunto."',";
//         $sql = $sql."'".$contenido."',";
//         $sql = $sql."'".$fecha."',";
//         $sql = $sql."'".$hora."',";
//         $sql = $sql."'".$mail_dest."',";
//         $sql = $sql."'".$mail_dest_name."',";
//         $sql = $sql."'".$replymail."',";
//         $sql = $sql."'".$replymail_name."',";
//         $sql = $sql."'1',";
//         $sql = $sql."'".$estado_historia."'";
        
//         $sql = $sql.")";
//         ////echo $sql;
//         if ($conexion->query($sql) == TRUE)
//             {}
//             else {}

//         return TRUE;
//     }
//     //notificacion_add ('119460', 'chat', $fecha, $nuc, "Informandote se  utilizo el correo: Correo para ".$mail_dest.", ".$mail_dest_name." enviado por ".$replymail_name." , ".$replymail."".$correo_historia.", Limite actual: ".$limite."");
// }else{
//         return FALSE;

//         $correo_historia= "No se envio el correo electronico, Se termino el limite de envio (".$mail_dest.")";
//         historia($nuc,$correo_historia);
//         $sql = "INSERT INTO correos (nuc, asunto, contenido, fecha, hora, correo, correo_name, responder_a, responder_a_name, estado, historia)";
//         $sql = $sql." VALUES ('".$nuc."', ";
//         $sql = $sql."'".$asunto."',";
//         $sql = $sql."'".$contenido."',";
//         $sql = $sql."'".$fecha."',";
//         $sql = $sql."'".$hora."',";
//         $sql = $sql."'".$mail_dest."',";
//         $sql = $sql."'".$mail_dest_name."',";
//         $sql = $sql."'".$replymail."',";
//         $sql = $sql."'".$replymail_name."',";
//         $sql = $sql."'0',";
//         $sql = $sql."'Error: ".$correo_historia."'";

//         $sql = $sql.")";
//         ////echo $sql;
//         if ($conexion->query($sql) == TRUE)
//             {}
//             else {}			
//         //mensaje("No se envio el correo ya que se ha excedido el limite de envio diario (".$limite.")",'');s

// }//limite
// }
// else {
//     //no dio permiso para enviarle
//     $contenido2="<p>Se le intento enviar un correo a ".nitavu_nombre($nuc).", pero no se pudo ya que desactivo la opcion para recibir correos</p>";
//     $contenido2 = $contenido2."<p>Contenido del correo: <br><br>".$contenido."</p>";
//     notificacion_add (quienesmijefe($nuc), "chat", $fecha, $nuc, $contenido2);
// }

// }

function Alert($Mensaje){
    echo "<script>alert('".$Mensaje."');</script>";
}
    
?>