<?php 	require("unica/funciones.php"); ?>
<?php 	require("unica/config.php"); ?>
<?php // error_reporting(E_ALL ^ E_NOTICE);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>PLATAFORMA DE ADMINISTRACION ITAVU</title>
		
		<meta charset="utf-8" />		
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<meta name="description" content="<?php echo Clt_description; ?>">
		<meta name="keywords" content="<?php echo Clt_name.", ".Clt_description; ?>">
		<meta name="robots" content="index,follow">
		<meta name="googlebot" content="index,follow">
		<meta name="geo.region" content="MX-TAM">
		
		<script src="unica/jquery-3.3.1.min.js"></script>	
		<script src="unica/pdz_functions.js"></script>
		<link rel="stylesheet" href="unica/css_estructura.css">
		<link rel="stylesheet" href="unica/css_color.css">
	
		<style>
			#body_div {
               

                
            }
            body{
                margin:0px;
               

                /* background-image: url('https://source.unsplash.com/random/1920x1080/?nature,trees,green'); */
                /* background-image: url('https://source.unsplash.com/random/1920x1080/?nature,mexico'); */
                background-color: #e3e3e3;;
                
                /* height: 246px;     */
                margin-top: 25px;    
                /* width: 100%;     */
                vertical-align: middle;    
                text-align: center;
                padding: 0px; margin: 0px;
                /* background-size:  100% 100%; */
               margin-top:25px;
                
               

            }
			h1 {color:#333333; font-size:11pt;}
			
            form {
                border-width:0px;
            }

           .ventana_login{
            width: 50%;
            display: inline-block;
            border: 1px #CCD8DB solid;
            border-radius: 5px;
            margin: 4px;
            padding: 5px;
            vertical-align: top;
            background-color:white;
            padding: 10px;
           }

           @media only screen and (max-width:800px) {
            .ventana_login{
                width: 90%;
            }
           }
		</style>
		

</head>


<body>

<!-- <h1>PLATAFORMA DE ADMINISTRACION ITAVU</h1> -->

<?php

// if (isset($_GET['comentario'])){
//     $Comentario = $_GET['comentario'];
// } else {$Comentario = "";}

// echo "<div style='width:100%; background-color:'>";
// echo $Comentario;
// echo "</div>";

    echo "<div class='ventana_login' id='ventana_login'>";
    
    echo "<script>
    
    function HorarioUser(){
        Usuario = $(login_username).val();
        Pass = $(login_nip).val();
        $(IndicacionesPreloader).show();
        $.ajax({
            url: 'horario_user.php',
        type: 'post',        
        data: {nitavu: Usuario, nip: Pass},
        success: function(data){            
            $('#Indicaciones').html(data);      
            $(IndicacionesPreloader).hide();
            
        }
        });
    }
    
    
    

    
    </script>";
    echo "<form id='login' class='login' method='post'> ";
    echo "
    <table width=100%><tr>
        <td><img src='img/logo_copia.png' class='logo' style=''></td>
        <td class='pc tenue'>Plataforma ITAVU</td>

    </tr>
    </table>
    
    ";
    // echo "<span><h3 class='tchico'>Identificacion de Empleado: </h3></span>";
    $usuario = "";
    
    echo "<input id='ip' name='ip' type='hidden' value='' readonly/ style='text-align:center; border: 0px; color:gray;'>";
    echo "<textarea id='pcdescripcion' name='pcdescripcion' type='hidden' value='' style='display:none;'></textarea>";

            session_start();     
            if (isset($_SESSION['nitavu']))
            {
             $usuario =    $_SESSION['nitavu'];
             echo "<div><label>Nitavu:</label>
             <input type='text' name='login_username' id='login_username' value ='".$usuario."' onkeyup ='HorarioUser();' required
             readonly='readonly'
             > <label><a href='logout.php' title='Cerrar Session' class='alerta'>No soy ".$usuario."</a></label></div>";

            }
            else {
                echo "<div><label>Username: </label>
                <input type='text' name='login_username' id='login_username' value ='' onkeyup ='HorarioUser();' required></div>";

            }
    
    
    
    echo "<div><label>NIP</label><input type='password' name='login_nip' id='login_nip' onkeyup ='HorarioUser();' required></div>";
    echo "<div><input type='submit' name='login_btn' id='login_btn' value='Entrar' class='btn btn-default'></div>";

    echo "<hr><label style='' class='tchico'>* Si experimenta problemas en esta aplicacion favor de contactar con el Dpto. de Informatica</label><br>";
    echo "</form>";

    echo "<div id='IndicacionesContenedor' style='opacity:1; color:gray;    margin-bottom: 38px; background-color: #E8F0FE;
    border: 1px dashed #CDCDCD;
    border-radius: 5px;'>

    <div id='IndicacionesPreloader' style='width:100%;'>
    <img src='img\loader_bar.gif' style='display:inline-block;'>

    </div>
    
    <div id='Indicaciones'>
    </div>
    
    </div>";
	


    echo "<div id='label_ip' style='margin-bottom:-25px; opacity:0; color:gray;'></div>";
	echo "</div>";








    if (isset($_POST['login_btn'])){ // clic Acceder    

            if ($_POST['ip']==''){  //si hay ip       
                $infoequipo=detectar();
                $nitavu = $_POST['login_username']; $nip = $_POST['login_nip'];    
                $JefeInformatica = titular('55');
                $JefedeSoporte = titular('3');
                $contenido = "
                <p><b> AUTOMATIZADO DE LA PLATAFORMA ITAVU: </b> como resultado de un intento de acceso desde un equipo que no detecta la ip
                </p>
                
                <p> 
                    Usuario: ".$nitavu." ".nitavu_nombre($nitavu)."<br>
                    ".nitavu_dpto_nombre($nitavu)."<br>
                <p> Esta es la información recolectada del equipo:<br><br><pre>".$infoequipo."</pre></p>
                <p style=color:red> Tome las medidas necesarias </p>
                ";
                // notificacion_add($JefeInformatica, 'ALTERTA: No detecta la ip, '.$nitavu, $fecha, $nitavu, $contenido);
                // notificacion_add($JefedeSoporte, 'ALTERTA: No detecta la ip, '.$nitavu, $fecha, $nitavu, $contenido);
                // mensaje ("ERROR al iniciar session, no se ha detectado su ip; vuelva a intentarlo",'./login.php');
    
            }

            $nitavu = $_POST['login_username']; $nip = $_POST['login_nip'];                
            $sql="SELECT * FROM empleados WHERE (nitavu='".$nitavu."' and nip='".$nip."' and estado='')";
            $r = $conexion -> query($sql); if($f = $r -> fetch_array())	
            {     if ($f['nip']== $nip){//:)                            
                    $nitavu = $f['nitavu'];	// variable de entorno      

                    $_SESSION['nitavu']=$f['nitavu']; //session		
                    $_SESSION['myip']=$_POST['ip']; //session		

                    global $nitavu; //generalize                            
                    $infoequipo=detectar().'IP Cliente: '.$_POST['ip'].'\n Descripcion Local: '.$_POST['pcdescripcion'];
                    historia($nitavu,'Acceso <br>'.$infoequipo.'','LOGIN');			    
                    SESSION_init(session_id(), $nitavu, session_name(), $infoequipo, $_POST['ip']);    
                    echo '<script>window.location.replace("index.php?home=")</script>'; 
                    }
                    else {
                        $infoequipo=detectar().'IP Cliente: '.$_POST['ip'].'\n Descripcion Local: '.$_POST['pcdescripcion'];
                        historia('','ERROR al loguearse del usuario '.$nitavu.' con el nip '.$nip.'<hr> desde: <br>'.$infoequipo,'LOGIN');
                        mensaje("ERROR: No coincide tu NIP con tu usuario",'./login.php');
                    }
            }else {historia('','Intento fallido del usuario '.$nitavu.' con el nip '.$nip,'LOGIN'); mensaje("ERROR: Usuario ".$nitavu." incorrecto",'login.php');}




        
        
             
    }//clic

    if (isset($_GET['user'])){
        //solicitar acceso
        $quien = $_GET['user'];        
        $cuando = $fecha;
        
        if (ValidaVAR($quien)==TRUE){
            $quien = LimpiarVAR($quien);
            $dpto = nitavu_dpto($quien);
            

            $sql = "INSERT INTO HorariosExcepcion (nitavu, fecha, dpto,hora) VALUES('$quien','$cuando','$dpto','$hora')";
            // echo $sql;
            if ($conexion->query($sql) == TRUE)
            {	$infoequipo=detectar();
                historia($quien,'Solicito acceso al sistema'.$infoequipo.'','LOGIN');		
                mensaje("Solicitud de acceso creada correctamente; espere autorización.",'login.php');
            } else {

                $solicitudesdehoy = HorariosExcepcion($quien);
                if ($solicitudesdehoy == 0){
                    mensaje("ERROR, no hemos podido procesar tu solicitud, comunicate con el dpto de Informatica".$sql,'login.php');
                } else {
                    mensaje("ERROR, no hemos podido procesar tu solicitud, ya que tienes una solicitud pendiente para hoy",'login.php');
                }
                
            }
        } else {

        }
        
    }

    echo "
    <script> 


        getLocalIPs(function(ips) {             
            myip = ips;
            // console.log('Mi IP es '+myip);
            $('#ip').val(myip);  
        });

        

      </script>

        

      ";

?>


</body>
</html>