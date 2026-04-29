<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>
<?php

    // $mail = new PHPMailer;
	// $mail->isSMTP(); $mail->SMTPDebug = 0; // 0 = off (for production use)// 1 = client messages// 2 = client and server messages
	// $mail->Debugoutput = 'html'; $mail->Host = 'smtp.gmail.com';  // use // $mail->Host = gethostbyname('smtp.gmail.com'); 
	// $mail->Helo = "smtp.gmail.com";
	// $mail->Port = 587; $mail->SMTPSecure = 'tls'; $mail->SMTPAuth = true; 
	// $mail->Username = "itavu.informatica@tam.gob.mx"; $mail->Password = "plataforma"; //CUENTA MASTER
	// $mail->setFrom('itavu.informatica@tam.gob.mx', $replymail_name); //Quie envia
	// $mail->addReplyTo($replymail, $replymail_name); //Reponder a nombre de 
	// $mail->addAddress($mail_dest, $mail_dest_name); //Set Destinatario
	// $mail->Subject = $asunto;  //Set asunto
	// //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__)); //--- PARA AÑADIR CONTENIDO DESDE UN ARCHIVO
	// $mail->msgHTML($contenido);
	// $mail->AltBody = 'El mensaje no puede ser entregado, debido a que su cliente de correo no puede leer el formato html';
	// //adjuntar imagenes //$mail->addAttachment('https:/plataformaitavu.tamaulipas.gob.mx/img/logo_copia.png');
	// $correo_historia="";
    // if (!$mail->send()) {//Si se envia		
        
class ObtieneMails{
 
    //usuario de gmail, email a donde deseamos conectarnos
    var $user="itavu.informatica@tam.gob.mx";
    //password de nuestro email
    var $password="plataforma";
    //inforrmación necesaria para conectarnos al INBOX de gmail,
    //incluye el servidor, el puerto 993 que es para imap, e indicamos que no valide con ssl
    var $mailbox="{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";
 
    var $fecha="01-MAR-2015"; //desde que fecha sincronizara
 
    //metodo que realiza todo el trabajo
    function obtenerAsuntosDelMails(){
 
        //realizamos la conexión por medio de nuestras credenciales
         $inbox = imap_open($this->mailbox,$this->user,$this->password) or die('Cannot connect to Gmail: ' . imap_last_error());
 
          //con la instrucción SINCE mas la fecha entre apostrofes ('')
          //indicamos que deseamos los mails desde una fecha en especifico
          //imap_search sirve para realizar un filtrado de los mails.
         $emails=imap_search($inbox,'SINCE "'.$this->fecha.'"');
 
         //comprbamos si existen mails con el la busqueda otorgada
            if($emails) {
                 //ahora recorremos los mails
                 foreach($emails as $email_number)
                {
                     //leemos las cabeceras de mail por mail enviando el inbox de nuestra conexión
                     //enviando el identificdor del mail
                    $overview=imap_fetch_overview($inbox,$email_number);
 
                    //ahora recorremos las cabeceras para obtener el asunto
                    foreach($overview as $over){
 
                        //comprobamos que exista el asunto (subject) en la cabecera
                        //y si es asi continuamos
                        if(isset($over->subject)){
 
                            //aqui pasa algo curioso
                            //el asunto vendra con caracteres raros
                            //para ello anexo una función que lo limpia y lo muestra ya legible
                            //en lenguaje mortal
                            $asunto=$this->fix_text_subject($over->subject);
 
                            //y aqui simplemente hacemos un echo para mostrar el asunto
                            echo utf8_decode($asunto)."n";
                        }
                    }
 
                }
            }
 
    }
 
    //arregla texto de asunto
    function fix_text_subject($str)
    {
        $subject = '';
        $subject_array = imap_mime_header_decode($str);
 
        foreach ($subject_array AS $obj)
            $subject .= utf8_encode(rtrim($obj->text, "t"));
 
        return $subject;
    }
 
}

//creamos el objeto
$oObtieneMails= new ObtieneMails();
 
//ejecutamos el metodo
$oObtieneMails->obtenerAsuntosDelMails();


?>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php
include ("./lib/body_footer.php");
?>