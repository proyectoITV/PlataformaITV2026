<?php
// session_start();
//AUTORIZACION PARA WEBSITE DEL USUARIO DE REPORTES
require("rintera-config.php");

// header("Set-Cookie: key=value; path=/; domain=example.org; HttpOnly; SameSite=Lax");
// if ($session_auto_start == 0){
// 	session_name($SesionName);
// 	session_start();
// }
// echo "Session ".$_SESSION['nitavu']."<br>";	

if (isset($_SESSION['nitavu'])){
	// echo "Si hay session ".$_SESSION['nitavu'];
	session_regenerate_id();
	$nitavu = $_SESSION['nitavu'];
	$nitavuName = $nitavu;
	// $nitavuName = $_SESSION['nitavuName'];

					
}
else

{	
	// echo "Sin session ";

	$_SESSION = array(); session_destroy();		   
	unset($IdUser);

	if (isset($_GET['IdUser'])){
        $IdUser = VarClean($_GET['IdUser']);
    } else {$IdUser = "";}
    if (isset($_GET['id'])){
        $id_rep = VarClean($_GET['id']);
	} else {$id_rep = "";}
	
	$url = "";
	if ($IdUser <> '') {
		$url.="IdUser=".$IdUser;
	}

	if ($id_rep <> '') {
		$url.="&id_rep=".$id_rep;
	}
	if ($url <> '' ){
		header("location:../login.php?id_rep=".$id_rep);		
	} else {
		header("location:../login.php");		
	}
	
	
}




















function LogOut(){
	$_SESSION = array(); session_destroy();		   
	unset($IdUser);
	header("location:login.php");		

}


function SESSION_Validate($id){ // solo existe en seguridad
	require("rintera-config.php");    
    $sql = "select  count(*) as n  from sessiones 
	where id='".$id."' and cierre_fecha = '0000-00-00'" ;
	// echo $sql;
	// echo "<script>console.log(".$sql.");</script>";
    $r= $db0 -> query($sql); if($f = $r -> fetch_array()){
			if ($f['n']==0)	{
				return FALSE;
			} else {
				return TRUE; //<-- Sesion abierta
			}
		
    }else{
            return FALSE;
    }
        

}



function SESSION_initRegenerate($id, $user, $session_name, $session_comentario){
	require("rintera-config.php");	
	$sql = "INSERT INTO sessiones (id, session_name,  usuario, fecha, hora, comentarios) 
	VALUES ('".$id."', '".$session_name."', '".$user."', '".$fecha."', '".$hora."', '".$session_comentario."')";
	// echo $sql;
	// mensaje($sql,'login.php');
		if ($db0->query($sql) == TRUE)
			{return TRUE;}
		else {return FALSE;}
		
}


function url_origin($s, $use_forwarded_host=false) {

	$ssl = ( ! empty($s['HTTPS']) && $s['HTTPS'] == 'on' ) ? true:false;
	$sp = strtolower( $s['SERVER_PROTOCOL'] );
	$protocol = substr( $sp, 0, strpos( $sp, '/'  )) . ( ( $ssl ) ? 's' : '' );
  
	$port = $s['SERVER_PORT'];
	$port = ( ( ! $ssl && $port == '80' ) || ( $ssl && $port=='443' ) ) ? '' : ':' . $port;
	
	$host = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
	$host = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
  
	return $protocol . '://' . $host;
  
  }
  
  function full_url( $s, $use_forwarded_host=false ) {
	return url_origin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
  }
  
  function URLActual(){
	  $absolute_url = full_url( $_SERVER );
	  return $absolute_url;
  }
  

function SESSION_closeRegenerate($id){
require("rintera-config.php");
	
	$sql="UPDATE sessiones  SET cierre_fecha='".$fecha."', cierre_hora='".$hora."'  WHERE id='".$id."'";
	// //echo $sql;
	if ($db0->query($sql) == TRUE)
		{return TRUE;}
	else {return FALSE;}
}

// ob_end_clean();

?>