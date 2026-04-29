<?php
//require("var_clean.php");
//require("tokens.php");
require_once("preference.php");
require("config.php");

define("Version","1.0"); 

function Init(){
    if (VersionCheck() == TRUE){
    } else {
        if (VersionMaster_required() == "TRUE"){
            echo "<div id='Version' class='alert alert-danger' role='alert' style='
            height: 100%;
            display: block;
            position: fixed;
            z-index: 5000;
            width: 100%;
            text-align: center;
            '>
            <h1>Requiere Actualizacion</h1>
            <p>Por cuestiones de seguridad, se requiere una actualizacion del codigo del proyecto. Favor de comunicarse con su <b>Departamento de Informática</b> para realizar el proceso</p>
            <p>Version actual: ".Version."<br>"."Version nueva: ".VersionMaster()."
            <br>NOTA de la version: <cite>".getData()->label."</cite>
            <br><a href='".VersionMaster_url()."'>Descargala aqui</a> <hr>
            <br>
            Desarrollador por ".getData()->contact."

            </div>";

           
        } else {
            echo "<div id='Version' class='alert alert-warning' role='alert'>
            <h1>Se Recomienda actualizar Rintera</h1>
            <p>Hay nueva versión disponible, se requiere actualizacion para seguir operando </p>
            <p>Version actual: ".Version."<br>"."Version nueva: ".VersionMaster()."
            <br><a href='".VersionMaster_url()."'>Descarga aqui</a>
            </div>";
        }
       
    }
}
function VersionCheck(){
    if (Version < VersionMaster()){
        return  FALSE;
    } else {
        return TRUE;
    }
}
function VersionMaster_url(){
    return getData()-> download;
}


function VersionMaster_required(){
    return getData()-> required;
}

function VersionMaster(){
    return getData()-> version;
}
/*-- function SESSION_init($id, $user, $session_name, $session_comentario, $ip){
    require("config.php");	
    $sql = "INSERT INTO sessiones (id, session_name,  usuario, fecha, hora, comentarios,ipcliente) 
    VALUES ('".$id."', '".$session_name."', '".$user."', '".$fecha."', '".$hora."', '".$session_comentario."', '".$ip."')";
    // mensaje($sql,'login.php');
        if ($conexion->query($sql) == TRUE)
            {return TRUE;}
        else {return FALSE;}
} 


function SESSION_close($id){
    require("config.php");
    $sql="UPDATE sessiones  SET cierre_fecha='".$fecha."', cierre_hora='".$hora."'  WHERE id='".$id."'";
    // //echo $sql;
    if ($conexion->query($sql) == TRUE)
        {return TRUE;}
    else {return FALSE;}
}*/




function historia_rintera($IdUser, $IdApp, $Descripcion){
    require("config.php");
    $fecha = date('Y-m-d');
    $hora =  date ("H:i:s");
    $Descripcion = addslashes($Descripcion);    

    $sql = "INSERT INTO historia_rintera
    (IdUser, fecha, hora, Descripcion, IdApp)
        VALUES
        ('$IdUser', '$fecha', '$hora','$Descripcion','$IdApp')";
    
    if ($conexion->query($sql) == TRUE)
    {	//echo "ok";
        return 'TRUE';
    }
        else
    {	////echo $sql;
        return 'FALSE';
    }
    }
    
    
    
    /* function Refresh($page){
        //header('location:$page');
        echo "<script> 
        
        window.location.replace('$page'); 
        
        </script>";
            
  
    }
 

    
function InfoEquipo()
{
    $browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
    $os=array("WIN","MAC","LINUX");
    # definimos unos valores por defecto para el navegador y el sistema operativo
    $info['browser'] = "OTHER";
    $info['os'] = "OTHER";
    # buscamos el navegador con su sistema operativo
    foreach($browser as $parent)
    {
    $s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
    $f = $s + strlen($parent);
    $version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
    $version = preg_replace('/[^0-9,.]/','',$version);
    if ($s)
    {
    $info['browser'] = $parent;
    $info['version'] = $version;
    
    }
    }
    # obtenemos el sistema operativo
    foreach($os as $val)
    {
    if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
    $info['os'] = $val;
    }
    # devolvemos el array de valores
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
        $ip = getenv('HTTP_FORWARDED');
        } else {
        // Método por defecto de obtener la IP del usuario
        // Si se utiliza un proxy, esto nos daría la IP del proxy
        // y no la IP real del usuario.
        $ip = $_SERVER['REMOTE_ADDR'];
        }
    //echo getenv('HTTP_CLIENT_IP');
    //echo getenv('HTTP_X_FORWADED_FOR');
    //echo getenv('REMOTE_ADDR');
    $infofull="";
    //$infofull = $infofull. "Usuario: ".gethostname()."<br>";
    $infofull = $infofull. "SO:".$info['os'].",";
    $infofull = $infofull. "Navegador: ".$info['browser'].",";
    $infofull = $infofull. "Version:".$info['version']."";
    // $infofull = $infofull. "".$_SERVER['HTTP_USER_AGENT']."<br>";
    
    $red = "";
    // if ($ip <> '' ){$red = $red."ip:".$ip;	}
    if (strlen(getenv('HTTP_CLIENT_IP')) > 3 ){$red = $red." ".getenv('HTTP_CLIENT_IP');}
    if (strlen(getenv('HTTP_X_FORWADED_FOR')) > 3 ){$red = $red.", ".getenv('HTTP_X_FORWADED_FOR');}
    if (strlen(getenv('REMOTE_ADDR')) > 3 ){$red = $red.", ".getenv('REMOTE_ADDR');}

    if ($red <> ''){
        $infofull = $infofull.", Red: (".$red.")";
    }
    
    
    
    
    return $infofull;
}



function Toast($Texto,$Tipo,$img){
    switch ($Tipo) {
        case 0:
            echo "<script>";
                echo "$.toast('".$Texto."');   ";
            echo "</script>";
            break;
        case 1: //Informativo
            echo "<script>";
            echo "
            $.toast({
                heading: 'Information',
                text: '".$Texto."',
                showHideTransition: 'slide',
                icon: 'info'
            })
            ";
            echo "</script>";
            break;
       
        case 2: //Error
            echo "<script>";
            echo "
            $.toast({
                heading: 'Error',
                text: '".$Texto."',
                showHideTransition: 'slide',
                icon: 'error'
            })
            ";
            echo "</script>";
            break;

        case 3: //Warning
                echo "<script>";
                echo "
                $.toast({
                    heading: 'Warning',
                    text: '".$Texto."',
                    showHideTransition: 'slide',
                    icon: 'warning'
                })
                ";
                echo "</script>";
                break;

                

        case 4: //Success
            echo "<script>";
            echo "
            $.toast({
                heading: 'Success',
                text: '".$Texto."',
                showHideTransition: 'slide',
                icon: 'success'
            })
            ";
            echo "</script>";
            break;
    

        case 5: //fijo
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."',                
                hideAfter: false
                
            })
            ";
            echo "</script>";
            break;
        
        case 6: //imagen normal
                echo "<script>";
                echo "
                $.toast({
                    heading: '',
                    text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                    hideAfter: false
                    
                })
                ";
                echo "</script>";
        break;                


        case 7: //imagen sucess
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                hideAfter: false,
                icon:'success'
                
            })
            ";
            echo "</script>";
        break;                


        case 8: //imagen warning
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                hideAfter: false,
                icon:'warning'
                
            })
            ";
            echo "</script>";
        break;                

        case 9: //imagen error
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                hideAfter: false,
                icon:'error'
                
            })
            ";
            echo "</script>";
        break;                

        case 10: //imagen normal auto
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                showHideTransition: 'slide'
                
            })
            ";
            echo "</script>";
    break;                


    case 11: //imagen sucess auto
        echo "<script>";
        echo "
        $.toast({
            heading: '',
            text: '".$Texto."<img style=width:100% src=".$img.">"."',                
            
            icon:'success',
            showHideTransition: 'slide'
            
        })
        ";
        echo "</script>";
    break;                


    case 12: //imagen warning auto
        echo "<script>";
        echo "
        $.toast({
            heading: '',
            text: '".$Texto."<img style=width:100% src=".$img.">"."',                
           
            icon:'warning',
            showHideTransition: 'slide'
            
        })
        ";
        echo "</script>";
    break;                

    case 13: //imagen error auto
        echo "<script>";
        echo "
        $.toast({
            heading: '',
            text: '".$Texto."<img style=width:100% src=".$img.">"."',                
            
            icon:'error',
            showHideTransition: 'slide'
            
        })
        ";
        echo "</script>";
    break;                


        default:
           echo "<script>";
               echo "$.toast('".$Texto."');   ";
           echo "</script>";
    }
}
*/
function UserAdmin($IdUser){
    require("config.php");   
    // var_dump($dbUser);  
    $sql = "select * from useradmin WHERE IdUser ='".$IdUser."'";        
  
    $rc= $dbUser -> query($sql);
    if($f = $rc -> fetch_array())
    {            return TRUE; // es admin
    } else {
            return FALSE; // no es admin
    }
    
        
}


function QueryReporte($id_rep){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    // echo $sql;    
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['sql1'];
    } else {
        return "FALSE";
    }
        
}

function ConName($IdCon){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from dbs WHERE Idcon ='".$IdCon."'";        
    
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['ConName'];
    } else {
        return "";
    }
        
}

function IdConReporte($id_rep){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['IdCon'];
    } else {
        return "FALSE";
    }
        
}

function QueryVar($id_rep, $IdVar){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {

        switch ($IdVar) {
            case 1:
                return $f['var1_sql'];                
                break;

            case 2:
                return $f['var2_sql'];                
                break;

                    
            case 3:
                return $f['var3_sql'];                
                break;
        
        }
        
        
    } else {
        return "FALSE";
    }
        
}



function IdConVar($id_rep, $IdVar){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {

        switch ($IdVar) {
            case 1:
                return $f['var1_IdCon'];                
                break;

            case 2:
                return $f['var2_IdCon'];                
                break;

                    
            case 3:
                return $f['var3_IdCon'];                
                break;
        
        }
        
        
    } else {
        return "FALSE";
    }
        
}

function TituloReporte($id_rep){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['rep_name'];
    } else {
        return "FALSE";
    }
        
}


function ReporteFixedColLeft($id_rep){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['FixedColLeft'];
    } else {
        return 0;
    }
        
}


function ReporteFixedColRight($id_rep){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['FixedColRight'];
    } else {
        return 0;
    }
        
}

function ReporteFooter($id_rep){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    $Footer = "";
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        $Footer = "<p clasS='ReporteFooter'>
        Reporte realizado el ".$f['fecha']." a las ".$f['hora']." por ".UserName($f['IdUser']).", el usuario <b>Administrador de este reporte es ".UserName($f['admin']).".<br>
        * Información extraida desde ".IdConInfo($f['IdCon'])."</p>
        ";

        return $Footer;
    } else {
        return "";
    }
        
}

function ReporteFooter2($id_rep){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    $Footer = "";
    // echo $sql;
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        // $Footer = "Reporte creado el ".$f['fecha']." a las ".$f['hora']." por ".UserName($f['IdUser']).", el usuario Administrador es ".UserName($f['admin']).".
    //    DATA desde ".IdConInfo($f['IdCon'])." | ".InfoEquipo();

       $Footer =  InfPC()." | ".ConName($f['IdCon'])." | ";

        return $Footer;
    } else {
        return "";
    }
        
}

function DescripcionReporte($id_rep){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    $LaDescripcion="";
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        $LaDescripcion = $f['rep_description'].". ";
        if (isset($_GET['var1'])){
            if (isset($_GET['var1'])){
                $LaDescripcion.= "".$f['var1_label']."=".$_GET['var1'].". ";
                
            }
    
            if (isset($_GET['var2'])){
                $LaDescripcion.= "".$f['var2_label']."=".$_GET['var2']."." ;
                
            }
    
    
            if (isset($_GET['var3'])){
                $LaDescripcion.= "".$f['var3_label']."=".$_POST['var3'].". ";
                
            }

        } else {
            if (isset($_POST['var1_str'])){
                $LaDescripcion.= "".$f['var1_label']."=".$_POST['var1_str'].". ";
                
            }
    
            if (isset($_POST['var2_str'])){
                $LaDescripcion.= "".$f['var2_label']."=".$_POST['var2_str']."." ;
                
            }
    
    
            if (isset($_POST['var3_str'])){
                $LaDescripcion.= "".$f['var3_label']."=".$_POST['var3_str'].". ";
                
            }
    
        }
        
        return " ".$LaDescripcion."";
    } else {
        return "FALSE";
    }
        
}



function ReporteTipo($id_rep){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['out_type'];
    } else {
        return "FALSE";
    }
        
}

//*duplico funcion
/* function ReporteTipo2($id_rep){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['out_type'];
    } else {
        return "FALSE";
    }
        
} */


function getData()
{    
    $url = 'https://v3nt4s.store/ws/rintera.html'; 
    $context = stream_context_create(
        array(
            "http" => array(
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
            )
        )
    );
    
    $archivo_web = file_get_contents($url, false, $context);
    $archivo = json_decode($archivo_web);    
    return $archivo;

}

/* function LocationFull($page){
	echo ' <script type="text/javascript">top.location.href="'.$page.'"</script>';
}

function PermisoReporte_Ver($IdUser,$IdRep){
    require("config.php");   
    $sql = "select count(*) as n
    
    from reportes_permisos WHERE IdUser ='".$IdUser."' and id_rep='".$IdRep."'";
    $rc= $conexion -> query($sql);
    
    
    if($f = $rc -> fetch_array())
    {
        if ($f['n']==1)  {
            return TRUE; // es admin
        } else {
            return FALSE; // no es admin
        }
    } else {
        return FALSE;
    }

} */

//*duplico funcion para itavu_produccion
/* function PermisoReporte_Ver2($IdUser,$IdRep){
    require("config.php");   
    $sql = "select count(*) as n
    
    from reportes_permisos WHERE IdUser ='".$IdUser."' and id_rep='".$IdRep."'";
    $rc= $conexion -> query($sql);
    
    
    if($f = $rc -> fetch_array())
    {
        if ($f['n']==1)  {
            return TRUE; // es admin
        } else {
            return FALSE; // no es admin
        }
    } else {
        return FALSE;
    }

} */



function PermisoReporte_Share($IdUser,$IdRep){
    require("config.php");   
    $sql = "select count(*) as n
    
    from reportes_permisos WHERE IdUser ='".$IdUser."' and id_rep='".$IdRep."' and CompartirVer=1";
    $rc= $conexion -> query($sql);
    
    
    if($f = $rc -> fetch_array())
    {
        if ($f['n']==1)  {
            return TRUE; // es admin
        } else {
            return FALSE; // no es admin
        }
    } else {
        return FALSE;
    }

}



function DynamicTable_MySQL($QueryD, $IdDiv, $IdTabla, $Clase, $Tipo, $db){
	//Tipo == 0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
	//$sql = "select * from Colorines limit 20";
	//DynamicTable_MySQL($sql, "Colorines", "Colorines_Tabla", "Colorines_ClaseCSS", 0, 0);

    require("config.php");	
        $sql = $QueryD;
        // echo $sql;
        $r= $conexion -> query($sql);
        $tbCont = '<div id="'.$IdDiv.'" class="'.$Clase.'">
        <table id="'.$IdTabla.'" class="display" style="width:100%" class="tabla" style="font-size:8pt;">';

        $tabla_titulos = ""; $cuantas_columnas = 0;
        $r2 = $conexion -> query($sql); while($finfo = $r2->fetch_field())
        {//OBTENER LAS COLUMNAS

                /* obtener posición del puntero de campo */
                $currentfield = $r2->current_field;       
                $tabla_titulos=$tabla_titulos."<th style='text-transform:uppercase; font-size:9pt;'>".$finfo->name."</th>";
                $cuantas_columnas = $cuantas_columnas + 1;        
        }

        $tbCont = $tbCont."  
        <thead>
        <tr>
            ".$tabla_titulos."  
        </tr>
        </thead>"; //Encabezados
        $tbCont = $tbCont."<tbody class='tabla'>";
        $cuantas_filas=0;
        $r = $conexion -> query($sql); while($f = $r-> fetch_row())
        {//LISTAR COLUMNAS

            $tbCont = $tbCont."<tr>";        
            for ($i = 1; $i <= $cuantas_columnas; $i++) {      
                $tbCont = $tbCont."<td style='font-size:10pt;'>".$f[$i-1]."</td>";       
                }

            $tbCont = $tbCont."</tr>";
            $cuantas_filas = $cuantas_filas + 1;        
        }

        $tbCont = $tbCont."</tbody>";
        $tbCont = $tbCont."</table></div>";
	

    






    
	echo  $tbCont;
		switch ($Tipo) {
			case 1: //Scroll Vertical
					echo '<script>
					$(document).ready(function() {
						$("#'.$IdTabla.'").DataTable( {
							"scrollY":        "200px",
							"scrollCollapse": true,
							"paging":         false,
							"language": {
								"decimal": ",",
								"thousands": "."
							}
						} );
					} );
					</script>';
				break;

			case 2: //Scroll Horizontal
					echo '<script>
					$(document).ready(function() {
						$("#'.$IdTabla.'").DataTable( {
							"scrollX": true,
							"scrollCollapse": true,
							"paging":         true,
							"language": {
								"decimal": ",",
								"thousands": "."
							}
						} );
					} );
					</script>';
				break;
			
			default:
				echo '<script>
				$(document).ready(function() {
					$("#'.$IdTabla.'").DataTable( {
						"language": {
							"decimal": ",",
							"thousands": "."
						}
					} );
				} );
				</script>';
		}
    

}



//Acordeon

function AcordionCard($IdCard, $btnText, $IdCollapsed, $Color){
        echo '
            <div class="card">
                <div class="card-header" id="'.$IdCard.'" style="
                background-color:'.$Color.'

                ">
                    <h5 class="mb-0">
                        <button class="btn " data-toggle="collapse" data-target="#'.$IdCollapsed.'" aria-expanded="true" aria-controls="'.$IdCollapsed.'"
                        style="width:100%;"
                        
                        >';
        echo $btnText;                            
        echo '          </button>
                    </h5>
                </div>';
}

function AcordionCard_Data($IdCard, $Text, $IdCollapsed, $Color){
    echo '
        <div id="'.$IdCollapsed.'" class="collapse " aria-labelledby="'.$IdCard.'" data-parent="#accordion" style="opacity:0.8; background-color:'.$Color.';
        -webkit-box-shadow: inset 2px 25px 31px -25px rgba(0,0,0,0.75);
        -moz-box-shadow: inset 2px 25px 31px -25px rgba(0,0,0,0.75);
        box-shadow: inset 2px 25px 31px -25px rgba(0,0,0,0.75);
        
        ">
            <div class="card-body">';
    echo $Text;
    echo '  </div>
        </div>
    
    </div>
    ';
}


function TestConectionDB($IdCon){
require_once("config.php");   
$sql = "select * from dbs where IdCon='".$IdCon."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
    if ($f['dbhost']<>'' &&  $f['dbname']<>'' && $f['dbuser']<>'' && $f['dbpassword']<>'')    {
        $Tdb_host = $f['dbhost'];
        $Tdb_user = $f['dbuser'];
        $Tdb_pass = $f['dbpassword'];
        $Tdb_name = $f['dbname'];

        
            $Tdb = new mysqli($Tdb_host,$Tdb_user,$Tdb_pass,$Tdb_name);
            if ($Tdb->connect_error) {
                // die("Connection failed: " . $Tdb->connect_error);
                Toast("Error al conectarse, revise los datos. ".$Tdb->connect_error,2,"");
            }
            $sql = "select @@version as Version";
            $rT= $Tdb -> query($sql);
            if($T = $rT -> fetch_array()){
                Toast("Conección Existosa a ".$f['dbname']."@".$f['dbhost'].": <b>".$T['Version'],4,"")."</b>";
            } else {
                Toast("Error al conectase, revise los datos en su conección",3,"");
            }
        
        
         
           





    } else {
        Toast("Sin datos para la coneccion",2,"");
    }


} else {
    return "FALSE";
}

}

function ConType($IdCon){
    require("config.php");   
    
    $sql = "select * from dbs WHERE Idcon='".$IdCon."'";
    $rc= $conexion -> query($sql);
    if($f = $rc -> fetch_array())
    {
        return $f['ConType'];
    } else{
        return "";
    }
        
}


function IdConInfo($IdCon){
    require("config.php");   
    
    $sql = "select * from dbs WHERE Idcon='".$IdCon."'";
    $rc= $conexion -> query($sql);
    if($f = $rc -> fetch_array())
    {
        return " ".$f['ConName'] ;
    } else{
        return "";
    }
        
}


function TestConectionWS($IdCon){
    require("config.php");   
    $sql = "select * from dbs where IdCon='".$IdCon."'";
    $rc= $conexion -> query($sql);
    if($f = $rc -> fetch_array())
    {
        if ($f['ConType']==2) //SQLSERVERTOJON 
        {

            $wsmethod ='POST';
            $wsjson = '1';
            $wsurl = $f['wsurl'];
            
            $wsP1_id = 'token';
            $wsP1_value = $f['wsP1_value'];
    
            $wsP2_id = 'method';
            $wsP2_value = $f['wsP2_value'];
    
            //Estos no se utilizan para este Webservice
            // $wsP3_id = $f['wsP3_id'];
            // $wsP3_value = $f['wsP3_value'];
    
            // $wsP4_id = $f['wsP4_id'];
            // $wsP4_value = $f['wsP4_value'];


            $url = $wsurl;            
            $sql = "select 'OK' as Exito";
            $token = $wsP1_value;

            //Peticion
            $myObj = new stdClass;
            $myObj->token = $token;
            $myObj->sql = $sql;
            $myJSON = json_encode($myObj,JSON_UNESCAPED_SLASHES);
            
            $datos_post = http_build_query(
                $myObj
            );

            $opciones = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $datos_post
                )
            );
            
            $context = stream_context_create($opciones);            
            $archivo_web = file_get_contents($url, false, $context);            
            $data = json_decode($archivo_web);
        

            var_dump($data);
            // echo "<hr>";

            //Recorrido
            $jsonIterator = new RecursiveIteratorIterator(
                new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
                RecursiveIteratorIterator::SELF_FIRST
            );
         
            $Exito = FALSE;
            foreach ($jsonIterator as $key => $val) {
                    if(is_array($val)) {
                        // echo $key.":<br>";
                        // $Exito = TRUE;
                    } else {
                        // echo $key.":".$val."<br>";
                        if ($key=='Exito' and $val == 'OK'){
                            $Exito = TRUE;
                        }
                    }
            }
              
            if ($Exito == TRUE){
                Toast("Conección exitosa",4,"");
                return TRUE;
            } else {
                Toast("Conección fallida",2,"");
                return FALSE;
            }
            
        } else {

        }
            
            
             
               
    
    
    
    
    } else {
        return "FALSE";
    }
    
    }


    function PingtoDb($IdCon){
        require("config.php");   
        $sql = "select * from dbs where IdCon='".$IdCon."'";    
        
        $rc= $conexion -> query($sql);    
        if($f = $rc -> fetch_array())
        {    
            if ($f['dbhost']<>'' &&  $f['dbname']<>'' && $f['dbuser']<>'' && $f['dbpassword']<>'')    {
                $Tdb_host = $f['dbhost'];
                $Tdb_user = $f['dbuser'];
                $Tdb_pass = $f['dbpassword'];
                $Tdb_name = $f['dbname'];
                    $Tdb = new mysqli($Tdb_host,$Tdb_user,$Tdb_pass,$Tdb_name);
                    if ($Tdb->connect_error) {
                        // die("Connection failed: " . $Tdb->connect_error);
                            Toast("Error al conectarse, revise los datos. ".$Tdb->connect_error,2,"");
                            return FALSE;
                    }
                    $sql = "select @@version as Version";
                    $rT= $Tdb -> query($sql);
                    if($T = $rT -> fetch_array()){
                        
                        return TRUE;
                    } else {
                        
                        return FALSE;
                    }
                
            } else {
               
                return FALSE;
            }
        
        
        } else {
            return FALSE;
        }
        
    }
        




function TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion, $id_rep, $info_leyenda ){	
    require("config.php");

    require('lib/pdf/tcpdf.php');
    error_reporting(0);

    $info_leyenda =  $info_leyenda. " IdUser: ".$IdUser." | ".$fecha.":".$hora;        
    $LogoFile = "Logo.png";
    $t1 = $TablaHTML;
    $t2="";
    $t3="";

    // ob_end_clean();  
    
    class PDFReporteUniversal extends TCPDF {
        public $str;
        public $titulo;
        public $descripcion;
        public $id_rep;
        public $info_leyenda;
        public $orientacion;
        public $PageSize;
    
        public function Header() {
            if ($this->PageSize == "0"){ //Configuracion CARTA
                if ($this->orientacion == 'L') { //horizontal CARTA						
                    $image_file = K_PATH_IMAGES.'Logo.png';
                    $icono = K_PATH_IMAGES.'user.png';
                    $widthLogo = Preference("LogoPDFWidth", "", "");		
                    $this->Image($image_file, 15, 7, 60, '', 'PNG', '', 'T', false, 500, '', false, false, 0, false, false, false);
                    
                    $this->SetFont('helvetica', 'B', 10);
                    $LogitudTitulo=150;
                    $this->Text(75, 7, ''.substr($this->titulo,0,$LogitudTitulo).""); 
                    $this->Text(75, 9.5, ''.substr($this->titulo,$LogitudTitulo + 1 , $LogitudTitulo ).""); 			
                    $this->SetFont('helvetica', 'I', 6);
                    $LogitudTitulo=200;
                    $this->Text(75, 12, ''.substr($this->descripcion,0,$LogitudTitulo).""); 
                    $this->Text(75, 13.5, ''.substr($this->descripcion,$LogitudTitulo + 1 , $LogitudTitulo).""); 
                    $this->Text(75, 15.5, ''.substr($this->descripcion,($LogitudTitulo * 2) + 1 , $LogitudTitulo).""); 
    
                } else { //VERTICAL CARTA
                    $image_file = K_PATH_IMAGES.'Logo.png';
                    $icono = K_PATH_IMAGES.'user.png';	
                    $widthLogo = Preference("LogoPDFWidth", "", "");			
                    $this->Image($image_file, 15, 7, 60, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                    $this->SetFont('helvetica', 'B', 10);
                    $LogitudTitulo=100;
                    $this->Text(75, 7, ''.substr($this->titulo,0,$LogitudTitulo).""); 
                    $this->Text(75, 9.5, ''.substr($this->titulo,$LogitudTitulo + 1 , $LogitudTitulo ).""); 			
                    $this->SetFont('helvetica', 'I', 6);
                    $LogitudTitulo=140;
                    $this->Text(75, 12, ''.substr($this->descripcion,0,$LogitudTitulo).""); 
                    $this->Text(75, 13.5, ''.substr($this->descripcion,$LogitudTitulo + 1 , $LogitudTitulo).""); 
                    $this->Text(75, 15.5, ''.substr($this->descripcion,($LogitudTitulo * 2) + 1 , $LogitudTitulo).""); 
                    
                }
            } else {//OFICIO
                if ($this->orientacion == 'L') { //horizontal OFICIO.
                    $image_file = K_PATH_IMAGES.'Logo.png';
                    $icono = K_PATH_IMAGES.'user.png';		
                    $widthLogo = Preference("LogoPDFWidth", "", "");			
                    $this->Image($image_file, 15, 7,60, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                    $this->SetFont('helvetica', 'B', 10);
                    $LogitudTitulo=220;
                    $this->Text(75, 7, ''.substr($this->titulo,0,$LogitudTitulo).""); 
                    $this->Text(75, 9.5, ''.substr($this->titulo,$LogitudTitulo + 1 , $LogitudTitulo ).""); 			
                    $this->SetFont('helvetica', 'I', 6);
                    $LogitudTitulo=280;
                    $this->Text(75, 12, ''.substr($this->descripcion,0,$LogitudTitulo).""); 
                    $this->Text(75, 13.5, ''.substr($this->descripcion,$LogitudTitulo + 1 , $LogitudTitulo).""); 
                    $this->Text(75, 15.5, ''.substr($this->descripcion,($LogitudTitulo * 2) + 1 , $LogitudTitulo).""); 
    
                } else { //VERTICAL OFICIO
                    $image_file = K_PATH_IMAGES.'Logo.png';
                    $icono = K_PATH_IMAGES.'user.png';		
                    $widthLogo = Preference("LogoPDFWidth", "", "");			
                    $this->Image($image_file, 15, 7, 60, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                    $this->SetFont('helvetica', 'B', 10);
                    $LogitudTitulo=100;
                    $this->Text(75, 7, ''.substr($this->titulo,0,$LogitudTitulo).""); 
                    $this->Text(75, 9.5, ''.substr($this->titulo,$LogitudTitulo + 1 , $LogitudTitulo ).""); 			
                    $this->SetFont('helvetica', 'I', 6);
                    $LogitudTitulo=140;
                    $this->Text(75, 12, ''.substr($this->descripcion,0,$LogitudTitulo).""); 
                    $this->Text(75, 13.5, ''.substr($this->descripcion,$LogitudTitulo + 1 , $LogitudTitulo).""); 
                    $this->Text(75, 15.5, ''.substr($this->descripcion,($LogitudTitulo * 2) + 1 , $LogitudTitulo).""); 
    
                }
            }
    
    
 }    


 public function Footer() {
    if ($this->PageSize == "0"){ //Configuracion CARTA
        if ($this->orientacion == 'L') { //horizontal CARTA						
            $this->SetY(-15);		
            $this->SetFont('helvetica', 'I', 6);	 
            $this->SetTextColor(0,0,0);
            $linea= "_______________________________________________________________________________________________________________________________________________________________________________________________________________________________________";
            $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();	
            $this->Text(14.5,199, $linea); 	 
            $LogitudTitulo=205;
            $this->SetFont('helvetica', 'B', 9); $this->Text(15,201.5, $paginas); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,201.5, "[".$this->id_rep."] ".substr($this->info_leyenda,0,$LogitudTitulo).""); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,203.5, "".substr($this->info_leyenda,$LogitudTitulo + 1,$LogitudTitulo ).""); 	 
    

        } else { //VERTICAL CARTA
            $this->SetY(-15);		
            $this->SetFont('helvetica', 'I', 6);	 
            $this->SetTextColor(0,0,0);
            $linea= "_______________________________________________________________________________________________________________________________________________________________________________________________________________________________________";
            $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();	
            $this->Text(14.5,262.5, $linea); 	 
            $LogitudTitulo=150;
            $this->SetFont('helvetica', 'B', 9); $this->Text(15,265, $paginas); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,265, "[".$this->id_rep."] ".substr($this->info_leyenda,0,$LogitudTitulo).""); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,267, "".substr($this->info_leyenda,$LogitudTitulo + 1,$LogitudTitulo ).""); 	 
            
        }
    } else {//OFICIO
        if ($this->orientacion == 'L') { //horizontal OFICIO
            $this->SetY(-15);		
            $this->SetFont('helvetica', 'I', 6);	 
            $this->SetTextColor(0,0,0);
            $linea= "______________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________";
            $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();	
            $this->Text(14.5,199, $linea); 	 
            $LogitudTitulo=205;
            $this->SetFont('helvetica', 'B', 9); $this->Text(15,201.5, $paginas); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,201.5, "[".$this->id_rep."] ".substr($this->info_leyenda,0,$LogitudTitulo).""); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,203.5, "".substr($this->info_leyenda,$LogitudTitulo + 1,$LogitudTitulo ).""); 	 


        } else { //VERTICAL OFICIO
            // $this->SetY(-15);		
            $this->SetFont('helvetica', 'I', 6);	 
            $this->SetTextColor(0,0,0);
            $linea= "_______________________________________________________________________________________________________________________________________________________________";
            $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();	
            $this->Text(14.5,325, $linea); 	 
            $LogitudTitulo=150;
            $this->SetFont('helvetica', 'B', 9); $this->Text(15,327, $paginas); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,327.5, "[".$this->id_rep."] ".substr($this->info_leyenda,0,$LogitudTitulo).""); 	 
            $this->SetFont('helvetica', 'I', 6); $this->Text(40,329.8, "".substr($this->info_leyenda,$LogitudTitulo + 1,$LogitudTitulo ).""); 	 

        }
    }


}
}
$pdf = new PDFReporteUniversal(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor($autor);
// $pdf->SetTitle("d".strtoupper($titulo));
// $pdf->SetSubject("x".$titulo);
// $pdf->SetKeywords('Reporte ITAVU');
// $pdf->SetHeaderData('pdf_logo.jpg', '30', strtoupper("".$titulo).'', $descripcion."\nImpreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu)."(".$nitavu.")");

//   $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 6));
//   $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//   $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);    
$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
//   $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetHeaderMargin(20);
// $pdf->SetFooterMargin(50);

//   $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);  
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  
if (@file_exists(dirname(__FILE__).'lib/pdf/lang/eng.php')) {require_once(dirname(__FILE__).'lib/pdf/lang/eng.php'); $pdf->setLanguageArray($l); }

$pdf->titulo = $titulo;
$pdf->descripcion = $descripcion;
$pdf->orientacion = $orientacion;
$pdf->PageSize = $PageSize;
$pdf->info_leyenda = $info_leyenda;
$pdf->id_rep = $id_rep;

$pdf->SetFont('helvetica', '', 7);  

//   $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
if ($PageSize == "LEGAL")  {
    if ($orientacion == "P"){
        $pdf->SetAutoPageBreak(TRUE, 30);
    } else {
        $pdf->SetAutoPageBreak(TRUE, 15);
    }
    
} else {

}


$pdf->AddPage($orientacion,$PageSize);     

$pdf->writeHTML($t1, true, false, true, 0, '');

//Est apartado se acomoda sin importar si es vertical o horizontal, asi como el tamaño de la hoja
if($t2<>'' or $t3<>'') {	//Agregamos una nueva hoja para los anexos
$pdf->AddPage($orientacion, $PageSize);
$pdf->writeHTML($t2, true, false, true, 0, ''); //Anexo1
$pdf->writeHTML($t3, true, false, true, 0, ''); //Anexo2

}



//Finalizamos el reporte
$pdf->lastPage();	  

//   $pdf->Output('reporte_'.$id_rep.'.pdf', 'I');
$directorio = __DIR__;
// $directorio = str_replace("unica", "tmp", $directorio);
// $archivo = $directorio."\\tmp\\".$StringFecha."_".$id_rep."_".$IdUser.".pdf";  

$archivo = $directorio."/tmp/".$StringFecha."_".$id_rep."_".$IdUser.".pdf";  

$archivoWeb = "tmp/".$StringFecha."_".$id_rep."_".$IdUser.".pdf";  
$pdf->Output($archivo, 'F');   
// echo $archivo;
return $archivoWeb;



}




function DataFromSQLSERVERTOJSON($id_rep, $Tipo, $ClaseTabla, $ClaseDiv, $IdUser)
{

//SQLSERVERTOJSON = https://github.com/prymecode/sqlservertojson
require("config.php");	
$Query = QueryReporte($id_rep);
    // echo "Query = ".$Query."<br>";
    if (isset($_GET['var1'])){
        if (isset($_GET['var1'])){
            $var1_str = VarClean($_GET['var1']);
            $Query = str_replace("{var1}", $var1_str, $Query); //actualizamos la consulta
        }

        if (isset($_GET['var2'])){
            $var2_str = VarClean($_GET['var2']);
            $Query = str_replace("{var2}", $var2_str, $Query); //actualizamos la consulta
        }

        if (isset($_GET['var3'])){
            $var3_str = VarClean($_GET['var3']);
            $Query = str_replace("{var3}", $var3_str, $Query); //actualizamos la consulta
        }
    }

    if (isset($_POST['var1_str'])){    
        
        if (isset($_POST['var1_str'])){
            $var1_str = VarClean($_POST['var1_str']);
            $Query = str_replace("{var1}", $var1_str, $Query); //actualizamos la consulta
        }

        if (isset($_POST['var2_str'])){
            $var2_str = VarClean($_POST['var2_str']);
            $Query = str_replace("{var2}", $var2_str, $Query); //actualizamos la consulta
        }

        if (isset($_POST['var3_str'])){
            $var3_str = VarClean($_POST['var3_str']);
            $Query = str_replace("{var3}", $var3_str, $Query); //actualizamos la consulta
        }
    }
// echo $Query;
$IdCon = IdConReporte($id_rep); 
    // echo "IdCon=".$IdCon."<br>";


// $Tipo = 1; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
$len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
$STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
$STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdTabla = $STR;
//1.- Obtener datos de conección
$WS_Val = FALSE;
$WS_Msg = "";
$WSSQL = "select * from dbs where IdCon='".$IdCon."' AND Active=1 AND ConType =2"; //SQLSERVERTOJSON
// echo $WSSQL;
// var_dump($conexion);
$WSCon = $conexion -> query($WSSQL);

if($WSConF = $WSCon -> fetch_array())
{
    // var_dump($RConF);
    // 1. Validacion de Datos necesarios
    if ($WSConF['wsurl'] <>'' &&  $WSConF['wsmethod']<>'' && $WSConF['wsjson']<>'' 
        // &&  $WSConF['wsP1_id'] && $WSConF['wsP1_value'] &&
        //     $WSConF['wsP2_id'] && $WSConF['wsP2_value'] &&
        //     $WSConF['wsP3_id'] && $WSConF['wsP3_value'] &&
        //     $WSConF['wsP4_id'] && $WSConF['wsP4_value']
        )    
    {
        $WSurl = $WSConF['wsurl'];
        $WSmethod = $WSConF['wsmethod'];
        $WSjson = $WSConF['wsjson'];
        $WSparametros = $WSConF['parametros'];

        $wsP1_id = $WSConF['wsP1_id'];  $wsP1_value = $WSConF['wsP1_value'];
        $wsP2_id = $WSConF['wsP2_id'];  $wsP2_value = $WSConF['wsP2_value'];
        $wsP3_id = $WSConF['wsP3_id'];  $wsP3_value = $WSConF['wsP3_value'];
        $wsP4_id = $WSConF['wsP4_id'];  $wsP4_value = $WSConF['wsP4_value'];

        $WS_Val = TRUE;
        // echo "OK";

                
        $url = $WSurl;            
        $sql = $Query;
        $token = $wsP1_value;

        $FixedColLeft = ReporteFixedColLeft($id_rep);
        $FixedColRight = ReporteFixedColRight($id_rep);

        //Peticion
        $myObj = new stdClass;
        $myObj->token = $token;
        $myObj->sql = $sql;
        $myJSON = json_encode($myObj,JSON_UNESCAPED_SLASHES);
        
        $datos_post = http_build_query(
            $myObj
        );

        $opciones = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $datos_post
            )
        );
        ini_set('max_execution_time', 7000);
        ini_set('max_execution_time', 0);
        $context = stream_context_create($opciones);            
        $archivo_web = file_get_contents($url, false, $context);            
        // var_dump($archivo_web);
        $data = json_decode($archivo_web);
        
        switch ($Tipo) {
            // case 0:
            //     return $archivo_web;
            // break;

            case 0: //HTML         
                $tabla = "";                  
                // //Recorrido del contenido
                $jsonIterator = new RecursiveIteratorIterator(
                    new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
                    RecursiveIteratorIterator::SELF_FIRST
                );
            
                // var_dump( $jsonIterator);
                $tabla= "<table id='".$IdTabla."'  width=100% border=0 class=' ".$ClaseTabla."' >";          
                $tabla_content = ""; $tabla_th = "";  
                $row=0; $rowC = 0;
                $limit = 0 ; foreach ($jsonIterator as $key => $val) {
                    if (is_numeric($key)){ //rows
                    // echo $limit."=".$key."=".$val."<br>";
                     $limit = 0;
                    }
                    else {
                        // echo "*".$limit."=".$key."=".$val."<br>";
                        $limit = $limit  + 1;
                    }
                    
                }
                // echo "limit=".$limit;

                //Construccion de <th>
                foreach ($jsonIterator as $key => $val) {
                    if (is_numeric($key)){ //rows                        
                        $rowC = 0;
                    } else {
                        if ($row < $limit){
                            if ($rowC == 0){$tabla_th.="<tr>";}                            
                            $tabla_th.="<th>".$key."</th>";
                        }                        
                    $rowC = $rowC + 1;
                    $row = $row + 1;
                    }
                }
                $tabla_th.="</tr>";
                $row =0; $rowC = 0;
                
                // echo "limit=".$limit;
                foreach ($jsonIterator as $key => $val) {
                    if (is_numeric($key)){ //rows                        
                        $rowC = 0;
                    }
                    else {                    
                        if ($rowC == 0){$tabla_content.="<tr>";}
                        if ($rowC == $limit){$tabla_content.="</tr>"; }                             
                        $tabla_content.="<td >".$val."</td>";                       
                    $rowC = $rowC + 1;
                    $row = $row + 1;
                    }
                
                
                }
                
                
                $tabla.=$tabla_th.$tabla_content."</table>";     
                $Titulo = TituloReporte($id_rep);
                $Descripcion = DescripcionReporte($id_rep);           
                // var_dump($Descripcion);
                return "<h1>".$Titulo."</h1><cite>".$Descripcion."</cite>".$tabla." ".ReporteFooter($id_rep);
                break;
        
                case 1: // Interactivo
                    $tabla = "";
                    // //Recorrido del contenido
                    $jsonIterator = new RecursiveIteratorIterator(
                        new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
                        RecursiveIteratorIterator::SELF_FIRST
                    );
                
                    // var_dump( $jsonIterator);
                    $tabla= "<table  id='".$IdTabla."' width=100% border=0 class=' ".$ClaseTabla."'>";          
                    $tabla_content = ""; $tabla_th = "";  
                    $row=0; $rowC = 0;
                    $limit = 0 ; foreach ($jsonIterator as $key => $val) {
                        if (is_numeric($key)){ //rows
                        // echo $limit."=".$key."=".$val."<br>";
                        $limit = 0;
                        }
                        else {
                            // echo "*".$limit."=".$key."=".$val."<br>";
                            $limit = $limit  + 1;
                        }
                        
                    }
                    // echo "limit=".$limit;

                    //Construccion de <th>
                    foreach ($jsonIterator as $key => $val) {
                        if (is_numeric($key)){ //rows                        
                            $rowC = 0;
                        } else {
                            if ($row < $limit){
                                if ($rowC == 0){$tabla_th.="<tr>";}                            
           
                                
                            $tabla_th.="<td";
                            if ($FixedColLeft>0 and ($rowC+1)<=$FixedColLeft){
                                $tabla_th.= " style='background-color:".Preference("ColorResaltado", "", "")."; opacity:0.7;' ";
                            } 

                            if ($FixedColRight>0 and $rowC==($limit - ($FixedColRight) ) ){
                                $tabla_th.= " style='background-color:".Preference("ColorSecundario", "", "")."; opacity:0.7;' ";
                            }
                            
                            $tabla_th.=">";
                            $tabla_th.=$key.""; 
                            $tabla_th.="</td>";
                                
                            }                        
                        $rowC = $rowC + 1;
                        $row = $row + 1;
                        }
                    }
                    $tabla_th =  "<thead>".$tabla_th."</tr></thead>";
                    // echo "<table border=1>".$tabla_th."</table>";
                    $row =1; $rowC = 1;
                    
                    // echo "limit=".$limit."<hr>";
                    foreach ($jsonIterator as $key => $val) {
                        
                        if (is_numeric($key)){ //rows                        
                            // $rowC = 1;
                        }
                        else {           
                            
                            if ($rowC == 1){
                                $tabla_content.="<tr>"; 
                                // echo "---".$limit."<br>";
                            }
                            // echo "rowC=".$rowC."(".$row.")<br>";
                            // $tabla_content.="<td>".$row."(".$rowC.")".$val."</td>";    
                           

                            $tabla_content.="<td";
                            if ($FixedColLeft>0 and $rowC<=$FixedColLeft){
                                $tabla_content.= " style='background-color:".Preference("ColorResaltado", "", "")."; opacity:0.7;' ";
                            } 

                            if ($FixedColRight>0 and $rowC==($limit - ($FixedColRight-1) ) ){
                                $tabla_content.= " style='background-color:".Preference("ColorSecundario", "", "")."; opacity:0.7;' ";
                            }
                            

                            $tabla_content.=">";
                            $tabla_content.=$val.""; 
                            $tabla_content.="</td>";
                            
                             
                            // if (ReporteFixedColRight($id_rep)>0){
                            //         if ($rowC == ($limit)){
                            //             $tabla_content.="<td style='background-color:".Preference("ColorPrincipal", "", "")."; opacity:0.7;'>".$val."</td>"; //cambiar th por td para datatable
                            //         } else {
                            //             $tabla_content.="<td>".$val."</td>"; //cambiar th por td para datatable
                            //         }
                            //     } else {
                            //         $tabla_content.="<td>".$val."</td>"; //cambiar th por td para datatable
                            //     }
                                
                                
                            // }

                            // $tabla_content.="<td>".$val."</td>";                  
                            if ($rowC == $limit){
                                $tabla_content.="</tr>";
                                $rowC = 1;
                                //  echo "===".$limit."<br>"; 
                            
                            }  else {
                                $rowC = $rowC + 1;       
                            }  
                            
                               
                            
                            $row = $row + 1;
                        
                        }
                        
                    
                    
                    }                                       
                    $tabla.=$tabla_th."<tbody class=' ".$ClaseTabla."'>".$tabla_content."</tbody></table>";     // tabla constuida a partir del ws
                    // echo $tabla;
                    //Escribimos en el dom
                    
                    echo "<div id='".$IdDiv."' class='".$ClaseDiv."'>".ReporteEncabezado($id_rep).                    
                    $tabla.ReporteFooter($id_rep)."</div>";
                    
                    



                    echo '<script>
                            $(document).ready(function() {
                                $("#'.$IdTabla.'").DataTable( {
                                    "scrollX":        true,
                                    "scrollY":        true,                                                                  
                                    "scrollCollapse": true,
                                    "paging":         true,
                                    "language": {
                                        "decimal": ",",
                                        "thousands": "."
                                    }
                                    ';

                                    if ($FixedColLeft >0 || $FixedColRight > 0){
                                        echo ',fixedColumns:   {';
                                            if ($FixedColLeft >0 ){
                                                echo 'leftColumns: '.$FixedColLeft.'';
                                            } 
                                            
                                            if ($FixedColLeft >0  and $FixedColRight > 0){
                                                echo ',';
                                            }
                                            

                                            if ($FixedColRight >0 ){
                                                echo 'rightColumns: '.$FixedColRight.'';
                                            }

                                    }

                                    if ($FixedColLeft >0 || $FixedColRight > 0){
                                        echo '}';

                                    }

                                    
                                $Botones = "
                                dom: 'Bfrtip',
                                buttons: [
                                    {
                                        extend:    'copyHtml5',
                                        text:      '<i class=\"fa fa-files-o\"></i>',
                                        titleAttr: 'Copy'
                                    },
                                    {
                                        extend:    'excelHtml5',
                                        text:      '<i class=\"fa fa-file-excel-o\"></i>',
                                        titleAttr: 'Excel'
                                    },
                                    // {
                                    //     extend:    'csvHtml5',
                                    //     text:      '<i class=\"fa fa-file-text-o\"></i>',
                                    //     titleAttr: 'CSV'
                                    // },
                                    // {
                                    //     extend:    'pdfHtml5',
                                    //     text:      '<i class=\"fa fa-file-pdf-o\"></i>',
                                    //     titleAttr: 'PDF'
                                    // }
                                ]
                                ";
                 
                                echo '
                                    
                                    ,responsive: true
                                   
                                    
                                    ,'.$Botones.'
                                    
                                 

                                } );
                            } );
                            </script>';
                break;
        

                case 2: //PDF
                    
                        $tabla = "";
                        // //Recorrido del contenido
                        $jsonIterator = new RecursiveIteratorIterator(
                            new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
                            RecursiveIteratorIterator::SELF_FIRST
                        );
                    
                        // var_dump( $jsonIterator);
                        $tabla= "<table  id='".$IdTabla."' width=100% border=0 class='".$ClaseTabla."'>";          
                        $tabla_content = ""; $tabla_th = "";  
                        $row=0; $rowC = 0;
                        $limit = 0 ; foreach ($jsonIterator as $key => $val) {
                            if (is_numeric($key)){ //rows
                            // echo $limit."=".$key."=".$val."<br>";
                            $limit = 0;
                            }
                            else {
                                // echo "*".$limit."=".$key."=".$val."<br>";
                                $limit = $limit  + 1;
                            }
                            
                        }
                        // echo "limit=".$limit;
    
                        //Construccion de <th>
                        foreach ($jsonIterator as $key => $val) {
                            if (is_numeric($key)){ //rows                        
                                $rowC = 0;
                            } else {
                                if ($row < $limit){
                                    if ($rowC == 0){$tabla_th.="<tr>";}                            
                                    
                                    $tabla_th.='<td  bgcolor="#555555" color="white">'.strtoupper($key)."</td>"; //cambiar th por td para datatable
                                }                        
                            $rowC = $rowC + 1;
                            $row = $row + 1;
                            }
                        }
                        $tabla_th =  "<thead>".$tabla_th."</tr></thead>";
                        // echo "<table border=1>".$tabla_th."</table>";
                        $row =1; $rowC = 1; $L = 0;
                        
                        // echo "limit=".$limit."<hr>";
                        foreach ($jsonIterator as $key => $val) {
                            
                            if (is_numeric($key)){ //rows                        
                                // $rowC = 1;
                            }
                            else {           
                                
                                if ($rowC == 1){
                                    $tabla_content.="<tr>"; 
                                    $L = $L+1;
                                    
                                    // echo "---".$limit."<br>";
                                }
                                // echo "rowC=".$rowC."(".$row.")<br>";
                                // $tabla_content.="<td>".$row."(".$rowC.")".$val."</td>";                  
                                // $tabla_content.="<td>".$val."</td>";     
                               

                                if ($L%2==0){
                                    $tabla_content = $tabla_content.'<td bgcolor="white" >'.$val."</td>";    
                                    
                                    
                                }else{
                                    $tabla_content = $tabla_content.'<td  bgcolor="#F0F0E1" >'.$val."</td>";       
                                    
                                }
                                
                                if ($rowC == $limit){
                                    $tabla_content.="</tr>";
                                    $rowC = 1;
                                    //  echo "===".$limit."<br>"; 
                                
                                }  else {
                                    $rowC = $rowC + 1;       
                                }  
                                
                                   
                                
                                $row = $row + 1;
                            
                            }
                            
                        
                        
                        }                                       
                        $tabla.=$tabla_th."<tbody class='".$ClaseTabla."'>".$tabla_content."</tbody></table>";     // tabla constuida a partir del ws
                        $TablaHTML = $tabla;

                        $titulo = TituloReporte($id_rep);
                        $descripcion = DescripcionReporte($id_rep);
                        $PageSize = "0"; // 0= carta y 1 == oficio
                        $orientacion = "L";
                        // $id_rep = 0;
                        $info_leyenda =  InfPC()." | ".ConName($IdCon)." | ";
                        // var_dump($info_leyenda);
                        $ArchivoDelReporte = TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion,$id_rep,$info_leyenda);
                        echo "<iframe id='pdfPresenter' src='".$ArchivoDelReporte."'
                        style='
                        width: 100%;
                        height: 94%;
                        position: fixed;
                        border: 0px;
                        z-index: 500;
                        '
                        >
                        
                        </iframe>";


                break;


                case 3: //Excel
                    
                    $tabla = "";
                    // //Recorrido del contenido
                    $jsonIterator = new RecursiveIteratorIterator(
                        new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
                        RecursiveIteratorIterator::SELF_FIRST
                    );
                
                    // var_dump( $jsonIterator);
                    $tabla= "<table  id='".$IdTabla."' width=100% border=0 class='".$ClaseTabla."'>";          
                    $tabla_content = ""; $tabla_th = "";  
                    $row=0; $rowC = 0;
                    $limit = 0 ; foreach ($jsonIterator as $key => $val) {
                        if (is_numeric($key)){ //rows
                        // echo $limit."=".$key."=".$val."<br>";
                        $limit = 0;
                        }
                        else {
                            // echo "*".$limit."=".$key."=".$val."<br>";
                            $limit = $limit  + 1;
                        }
                        
                    }
                    // echo "limit=".$limit;

                    //Construccion de <th>
                    foreach ($jsonIterator as $key => $val) {
                        if (is_numeric($key)){ //rows                        
                            $rowC = 0;
                        } else {
                            if ($row < $limit){
                                if ($rowC == 0){$tabla_th.="<tr>";}                            
                                
                                $tabla_th.='<td  bgcolor="#555555" color="white">'.strtoupper($key)."</td>"; //cambiar th por td para datatable
                            }                        
                        $rowC = $rowC + 1;
                        $row = $row + 1;
                        }
                    }
                    $tabla_th =  "<thead>".$tabla_th."</tr></thead>";
                    // echo "<table border=1>".$tabla_th."</table>";
                    $row =1; $rowC = 1; $L = 0;
                    
                    // echo "limit=".$limit."<hr>";
                    foreach ($jsonIterator as $key => $val) {
                        
                        if (is_numeric($key)){ //rows                        
                            // $rowC = 1;
                        }
                        else {           
                            
                            if ($rowC == 1){
                                $tabla_content.="<tr>"; 
                                $L = $L+1;
                                // echo "---".$limit."<br>";
                            }
                            // echo "rowC=".$rowC."(".$row.")<br>";
                            // $tabla_content.="<td>".$row."(".$rowC.")".$val."</td>";                  
                            // $tabla_content.="<td>".$val."</td>";     

                            if ($L%2==0){
                                $tabla_content = $tabla_content.'<td bgcolor="white"  style="background-color:white;">'.$val."</td>";       
                                
                            }else{
                                $tabla_content = $tabla_content.'<td  bgcolor="#F0F0E1" style="background-color:#F0F0E1;" >'.$val."</td>";       
                                
                            }
                            
                            if ($rowC == $limit){
                                $tabla_content.="</tr>";
                                $rowC = 1;
                                //  echo "===".$limit."<br>"; 
                            
                            }  else {
                                $rowC = $rowC + 1;       
                            }  
                            
                               
                            
                            $row = $row + 1;
                        
                        }
                        
                    
                    
                    }                                       
                    $tabla.=$tabla_th."<tbody class='".$ClaseTabla."'>".$tabla_content."</tbody></table>";     // tabla constuida a partir del ws
                    $TablaHTML = $tabla;

                    $titulo = TituloReporte($id_rep);
                    $descripcion = DescripcionReporte($id_rep);
                    $PageSize = "0"; // 0= carta y 1 == oficio
                    $orientacion = "L";
                    // $id_rep = 0;
                    $info_leyenda = "x";
                    // $ArchivoDelReporte = TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion,$id_rep,$info_leyenda);
                    $ArchivoDelReporte = "excel.php?IdUser=".$IdUser."&id_rep=".$id_rep;
                    
                    echo "<p>El Archivo del reporte se descargara automaticamente, si no es así 
                    por favor da clic <a href='".$ArchivoDelReporte."' download>aquí<a/>";
                    echo "<iframe id='wordPresenter' src='".$ArchivoDelReporte."'
                    style='
                        width: 10px;
                        height: 10px;
                        border: 0px solid white;
                       
                    '
                    >
                    
                    </iframe>";


            break;

            case 4: //Word
                    
                $tabla = "";
                // //Recorrido del contenido
                $jsonIterator = new RecursiveIteratorIterator(
                    new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
                    RecursiveIteratorIterator::SELF_FIRST
                );
            
                // var_dump( $jsonIterator);
                $tabla= "<table  id='".$IdTabla."' width=100% border=0 class='".$ClaseTabla."'>";          
                $tabla_content = ""; $tabla_th = "";  
                $row=0; $rowC = 0;
                $limit = 0 ; foreach ($jsonIterator as $key => $val) {
                    if (is_numeric($key)){ //rows
                    // echo $limit."=".$key."=".$val."<br>";
                    $limit = 0;
                    }
                    else {
                        // echo "*".$limit."=".$key."=".$val."<br>";
                        $limit = $limit  + 1;
                    }
                    
                }
                // echo "limit=".$limit;

                //Construccion de <th>
                foreach ($jsonIterator as $key => $val) {
                    if (is_numeric($key)){ //rows                        
                        $rowC = 0;
                    } else {
                        if ($row < $limit){
                            if ($rowC == 0){$tabla_th.="<tr>";}                            
                            
                            $tabla_th.='<td  bgcolor="#555555" color="white">'.strtoupper($key)."</td>"; //cambiar th por td para datatable
                        }                        
                    $rowC = $rowC + 1;
                    $row = $row + 1;
                    }
                }
                $tabla_th =  "<thead>".$tabla_th."</tr></thead>";
                // echo "<table border=1>".$tabla_th."</table>";
                $row =1; $rowC = 1;
                
                // echo "limit=".$limit."<hr>";
                foreach ($jsonIterator as $key => $val) {
                    
                    if (is_numeric($key)){ //rows                        
                        // $rowC = 1;
                    }
                    else {           
                        
                        if ($rowC == 1){
                            $tabla_content.="<tr>"; 
                            // echo "---".$limit."<br>";
                        }
                        // echo "rowC=".$rowC."(".$row.")<br>";
                        // $tabla_content.="<td>".$row."(".$rowC.")".$val."</td>";                  
                        // $tabla_content.="<td>".$val."</td>";     

                        if ($row%2==0){
                            $tabla_content = $tabla_content.'<td bgcolor="white" >'.$val."</td>";       
                            
                        }else{
                            $tabla_content = $tabla_content.'<td  bgcolor="#F0F0E1" >'.$val."</td>";       
                            
                        }
                        
                        if ($rowC == $limit){
                            $tabla_content.="</tr>";
                            $rowC = 1;
                            //  echo "===".$limit."<br>"; 
                        
                        }  else {
                            $rowC = $rowC + 1;       
                        }  
                        
                           
                        
                        $row = $row + 1;
                    
                    }
                    
                
                
                }                                       
                $tabla.=$tabla_th."<tbody class='".$ClaseTabla."'>".$tabla_content."</tbody></table>";     // tabla constuida a partir del ws
                $TablaHTML = $tabla;

                $titulo = TituloReporte($id_rep);
                $descripcion = DescripcionReporte($id_rep);
                $PageSize = "0"; // 0= carta y 1 == oficio
                $orientacion = "L";
                // $id_rep = 0;
                $info_leyenda = "x";
                // $ArchivoDelReporte = TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion,$id_rep,$info_leyenda);
                $ArchivoDelReporte = "word.php?IdUser=".$IdUser."&id_rep=".$id_rep;
                echo "<p>El Archivo del reporte se descargara automaticamente, si no es así 
                por favor da clic <a href='".$ArchivoDelReporte."' download>aquí<a/>";
                echo "<iframe id='wordPresenter' src='".$ArchivoDelReporte."'
                style='
                    width: 10px;
                    height: 10px;
                    border: 0px solid white;
                   
                '
                >
                
                </iframe>";


        break;















                default:
        }             
                
        
        
    } else {
        $WS_Msg.="Parametros insuficientes";
        return $WS_Msg;

    }
} else {
    $WS_Msg.="Error de consulta a la base de datos";
    return $WS_Msg;
}
// echo $WS_Msg;
// return $WS_Val;
    
}
















function DataFromMySQL($ClaseDiv, $ClaseTabla, $Tipo, $IdUser,$id_rep){
    require("config.php");	
    var_dump($conexion);
    
    $Query = QueryReporte($id_rep); 
    $FixedColLeft = ReporteFixedColLeft($id_rep);
    $FixedColRight = ReporteFixedColRight($id_rep);
    
    if (isset($_GET['var1'])){
        if (isset($_GET['var1'])){
            $var1_str = VarClean($_GET['var1']);
            $Query = str_replace("{var1}", $var1_str, $Query); //actualizamos la consulta
        }

        if (isset($_GET['var2'])){
            $var2_str = VarClean($_GET['var2']);
            $Query = str_replace("{var2}", $var2_str, $Query); //actualizamos la consulta
        }

        if (isset($_GET['var3'])){
            $var3_str = VarClean($_GET['var3']);
            $Query = str_replace("{var3}", $var3_str, $Query); //actualizamos la consulta
        }
    }

    if (isset($_POST['var1_str'])){
    
        
        if (isset($_POST['var1_str'])){
            $var1_str = VarClean($_POST['var1_str']);
            $Query = str_replace("{var1}", $var1_str, $Query); //actualizamos la consulta
        }

        if (isset($_POST['var2_str'])){
            $var2_str = VarClean($_POST['var2_str']);
            $Query = str_replace("{var2}", $var2_str, $Query); //actualizamos la consulta
        }

        if (isset($_POST['var3_str'])){
            $var3_str = VarClean($_POST['var3_str']);
            $Query = str_replace("{var3}", $var3_str, $Query); //actualizamos la consulta
        }
    }

    // echo $Query;
    echo "<script>$('#FormVar').hide();</script>";
    // echo "Query = ".$Query."<br>";
    $IdCon = IdConReporte($id_rep); 
        // echo "IdCon=".$IdCon."<br>";

    if ($Query == "FALSE") {
        return "ERROR: Datos insuficientes en el reporte (Query).";
        exit();
    } 
    
    if ($IdCon == "FALSE") {
        return "ERROR: Datos insuficientes en el reporte (IdCon).";
        exit();
    } 

    
    $TablaHTML = "";


    $len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdTabla = $STR;
    
    echo "IdDiv=".$IdDiv."<br>"."IdTabla=".$IdTabla."<br>";

    
    $Con_IdCon = IdConReporte($id_rep);

    include("con_init.php");

// if ($Con_Val == TRUE){    
//     // echo $Query;
//     // var_dump($Con_Msg);
//     if ($r = $LaConeccion -> query($Query)){
        
//         // var_dump($Query);
//         if($f = $r -> fetch_array()){
        
//             // var_dump($f);

//             $tbCont = '<div id="'.$IdDiv.'" class="'.$ClaseDiv.'">
//             <table  id="'.$IdTabla.'"  style="width:100%; " class="'.$ClaseTabla.'" style="font-size:8pt;">';
//             $tabla_titulos = ""; $cuantas_columnas = 0;
//             $r2 = $LaConeccion -> query($Query); while($finfo = $r2->fetch_field())
//             {//OBTENER LAS COLUMNAS

//                     /* obtener posición del puntero de campo */
//                     $currentfield = $r2->current_field;       
//                     $tabla_titulos=$tabla_titulos.'<th bgcolor="#A5A5A5" color="white">'.strtoupper($finfo->name)."</th>";
//                     $cuantas_columnas = $cuantas_columnas + 1;        
//             }
//             unset($r2);

//             $tbCont = $tbCont."  
//             <thead>
//             <tr>
//                 ".$tabla_titulos."  
//             </tr>
//             </thead>"; //Encabezados
//             $tbCont = $tbCont."<tbody class='".$ClaseTabla."'>";
//             $cuantas_filas=0;
//             $r = $LaConeccion -> query($Query); while($f = $r-> fetch_row())
//             {//LISTAR COLUMNAS

//                 $tbCont = $tbCont."<tr>";        
//                 for ($i = 1; $i <= $cuantas_columnas; $i++) {      
//                     if ($cuantas_filas%2==0){
//                         $tbCont = $tbCont.'<td bgcolor="white" >'.$f[$i-1]."</td>";       
                        
//                     }else{
//                         $tbCont = $tbCont.'<td  bgcolor="#F0F0E1" >'.$f[$i-1]."</td>";       
                        
//                     }

                    
//                     }

//                 $tbCont = $tbCont."</tr>";
//                 $cuantas_filas = $cuantas_filas + 1;        
//             }
//             unset($r);
//             $tbCont = $tbCont."</tbody>";
//             $tbCont = $tbCont."</table></div>";
//             $TablaHTML = $tbCont;

//             switch ($Tipo) {
//                 case 0:  //HTML                 
//                     return ReporteEncabezado($id_rep).$TablaHTML.ReporteFooter($id_rep);    
//                 break;
               
//                 case 1: // Interactivo
//                     echo  ReporteEncabezado($id_rep).$TablaHTML.ReporteFooter($id_rep);   
//                     echo '<script>
//                             $(document).ready(function() {
//                                 $("#'.$IdTabla.'").DataTable( {
//                                     "scrollX":        false,
//                                     "scrollY":        false,                                                                  
//                                     "scrollCollapse": true,
//                                     "paging":         true,
//                                     "language": {
//                                         "decimal": ",",
//                                         "thousands": "."
//                                     }
//                                     ';

//                                     if ($FixedColLeft >0 || $FixedColRight > 0){
//                                         echo ',fixedColumns:   {';
//                                             if ($FixedColLeft >0 ){
//                                                 echo 'leftColumns: '.$FixedColLeft.'';
//                                             } 
                                            
//                                             if ($FixedColLeft >0  and $FixedColRight > 0){
//                                                 echo ',';
//                                             }
                                            

//                                             if ($FixedColRight >0 ){
//                                                 echo 'rightColumns: '.$FixedColRight.'';
//                                             }

//                                     }

//                                     if ($FixedColLeft >0 || $FixedColRight > 0){
//                                         echo '}';

//                                     }

                                    
//                                 $Botones = "
//                                 dom: 'Bfrtip',
//                                 buttons: [
//                                     {
//                                         extend:    'copyHtml5',
//                                         text:      '<i class=\"fa fa-files-o\"></i>',
//                                         titleAttr: 'Copy'
//                                     },
//                                     {
//                                         extend:    'excelHtml5',
//                                         text:      '<i class=\"fa fa-file-excel-o\"></i>',
//                                         titleAttr: 'Excel'
//                                     },
//                                     // {
//                                     //     extend:    'csvHtml5',
//                                     //     text:      '<i class=\"fa fa-file-text-o\"></i>',
//                                     //     titleAttr: 'CSV'
//                                     // },
//                                     // {
//                                     //     extend:    'pdfHtml5',
//                                     //     text:      '<i class=\"fa fa-file-pdf-o\"></i>',
//                                     //     titleAttr: 'PDF'
//                                     // }
//                                 ]
//                                 ";
                 
//                                 echo '
                                    
//                                     ,responsive: true
                                   
                                    
//                                     ,'.$Botones.'
                                    
                                 

//                                 } );
//                             } );
//                             </script>';
//                 break;

//                 case 2: // PDF
//                     // $IdUser = $nitavu;
//                     $titulo = TituloReporte($id_rep);
//                     $descripcion = DescripcionReporte($id_rep);
//                     $PageSize = "0"; // 0= carta y 1 == oficio
//                     $orientacion = "L";
//                     // $id_rep = 0;
//                     $IdCon = IdConReporte($id_rep);
//                     $info_leyenda =  InfPC()." | ".ConName($IdCon)." | ";
//                     $ArchivoDelReporte = TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion,$id_rep,$info_leyenda);
//                     historia_rintera($IdUser, "REPORTE PDF", "Utilizo el reporte ".$id_rep." - ".$titulo.". Genero el archivo <a href='".$ArchivoDelReporte."'>".$ArchivoDelReporte."</a>");

//                     echo "<iframe id='pdfPresenter' src='".$ArchivoDelReporte."'
//                     style='
//                         width: 100%;
//                         height: 94%;
//                         position: fixed;
//                         border: 0px;
//                         z-index: 500;
//                     '
//                     >
                    
//                     </iframe>";

//                     // echo "<script>pdf('".$ArchivoDelReporte."');</script>";

//                 break;

//                 case 3: // EXCEL
//                     // $IdUser = $nitavu;
                    
//                     $titulo = TituloReporte($id_rep);
//                     $descripcion = DescripcionReporte($id_rep);
//                     $PageSize = "0"; // 0= carta y 1 == oficio
//                     $orientacion = "L";
//                     // $id_rep = 0;
//                     $IdCon = IdConReporte($id_rep);
//                     $info_leyenda =  InfPC()." | ".ConName($IdCon)." | ";
//                     // $ArchivoDelReporte = TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion,$id_rep,$info_leyenda);
//                     $ArchivoDelReporte = "excel.php?IdUser=".$IdUser."&id_rep=".$id_rep;
//                     echo "<p>El Archivo del reporte se descargara automaticamente, si no es así 
//                     por favor da clic <a href='".$ArchivoDelReporte."' download>aquí<a/>";
//                     echo "<iframe id='wordPresenter' src='".$ArchivoDelReporte."'
//                     style='
//                         width: 10px;
//                         height: 10px;
//                         border: 0px solid white;
                       
//                     '
//                     >
                    
//                     </iframe>";
//                     // echo "<script>pdf('".$ArchivoDelReporte."');</script>";

//                 break;
                
                
//                 case 4: // Word
//                     // $IdUser = $nitavu;
                    
//                     $titulo = TituloReporte($id_rep);
//                     $descripcion = DescripcionReporte($id_rep);
//                     $PageSize = "0"; // 0= carta y 1 == oficio
//                     $orientacion = "L";
//                     // $id_rep = 0;
//                     $IdCon = IdConReporte($id_rep);
//                     $info_leyenda =  InfPC()." | ".ConName($IdCon)." | ";
//                     // $ArchivoDelReporte = TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion,$id_rep,$info_leyenda);
//                     $ArchivoDelReporte = "word.php?IdUser=".$IdUser."&id_rep=".$id_rep;
//                     echo "<p>El Archivo del reporte se descargara automaticamente, si no es así 
//                     por favor da clic <a href='".$ArchivoDelReporte."' download>aquí<a/>";
//                     echo "<iframe id='wordPresenter' src='".$ArchivoDelReporte."'
//                     style='
//                         width: 10px;
//                         height: 10px;
//                         border: 0px solid white;

                       
//                     '
//                     >
                    
//                     </iframe>";
                    
                    
//                     // echo "<script>pdf('".$ArchivoDelReporte."');</script>";

//                 break;
                
                
            

//             default:

                
//             }
            
            
//             // return $tbCont;
        

        

//         } else {
//             $Con_Msg .= "<br><br><br><p>No se han encontrado resultados!. Intentelo nuevamente con otro criterio</p>";
//             $Parametros = "";
         
//             if (isset($_POST['var1_str'])){$Parametros.= "".$_POST['var1_str'];}
//             if (isset($_POST['var2_str'])){$Parametros.= ", ".$_POST['var2_str'];}
//             if (isset($_POST['var3_str'])){$Parametros.= ", ".$_POST['var3_str'];}

//             if (isset($_GET['var1_str'])){$Parametros.= "".$_GET['var1_str'];}
//             if (isset($_GET['var2_str'])){$Parametros.= ", ".$_GET['var2_str'];}
//             if (isset($_GET['var3_str'])){$Parametros.= ", ".$_GET['var3_str'];}

//             if ($Parametros == ''){
//                 historia_rintera($IdUser, "Reporte", "No encontro informacion del reporte ".$id_rep."");
//             } else {
//                 historia_rintera($IdUser, "Reporte", "No encontro informacion del reporte ".$id_rep." con los parametros: ".$Parametros);
//             }
//             // return FALSE;
//             return $Con_Msg;
//         }
//     } else {
//         // return FALSE;
//         return "Error al consultar. ".$Con_Msg;
//         // echo "Error en la base de datos";
//     }
    
    
// } else {
//     return $Con_Msg;
//     // echo "ERROR: ".$Con_Msg;
// }



include("con_close.php");


}





function Reporte($id_rep, $Tipo, $ClaseDiv, $ClaseTabla, $IdUser ){
    require("config.php");	

    $ClaseTabla = "tabla table-striped table-hover";
    $IdCon = IdConReporte($id_rep);
    $ConType = ConType($IdCon);

    // $Tipo = 1; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
    $Data = "";
        switch ($ConType) {
            case 0:  //rintera
                $Data = DataFromMySQL($ClaseDiv,$ClaseTabla, $Tipo, $IdUser, $id_rep);
                break;
            case 1:  //MySQL        
                $Data = DataFromMySQL($ClaseDiv,$ClaseTabla, $Tipo, $IdUser,$id_rep);
                break;
            case 2:  //MSQLSERVERTOJSON      
                $Data =  DataFromSQLSERVERTOJSON($id_rep, $Tipo, $ClaseTabla, $ClaseDiv, $IdUser );
                break;
        }

        return $Data;
}

function Error($Mensaje){
    require("config.php");	
    echo "<div id='Error'

    style='
    background-color:red;
    color:white;
    width:90%;
    display:inline-block;
    border-radius:10px;
    margin:20px;
    padding:20px;
    '
    ><table width=100%><tr><td
    style='color:white;'
    >".$Mensaje."</td><td width=50px><a href='index.php' class='btn btn-Warning'>Reintentar</a></td></tr></table></div>";
    
    historia_rintera("","ERROR",$Mensaje);
    $CorreoDestino = "printepolis@gmail.com";
    $Asunto = "Error: ".$fecha;
    $ContenidoDelCorreo = "<p>".$fecha.":".$hora.". Rintera: Ha habido un error <b>".$Error."</b> </p>";
    EnviarCorreo($CorreoDestino, $Asunto, $ContenidoDelCorreo);


}



/* function EnviarCorreo($mail_dest, $asunto, $contenido){
    //sleep(3);//retraso programado
    if (Preference("MailSend", "", "") == "TRUE") {
        $mail_dest_name= "";
        $replymail = 'itavu.informatica@tam.gob.mx';
        $replymail_name='Dpto. de Informatica de ITAVU';

        require("config.php");    
        require_once('lib/mailer/PHPMailerAutoload.php');
        
        $footer="
        <br><br>    
        <hr><p style=color:gray; font-family:Verdana, Geneva, sans-serif; font-size:10pt;> 
            Este correo electronico es enviado de manera automatizada mendiante Rintera.<br>	
            ".Preference("Mail-Footer", "", "")."       
        </p>";

        
        $footer = $footer.'';
        $contenido = "<p charset=UTF-8>".$contenido."</p><hr>Desde:".InfPC().$footer;
        
        $MailHost = Preference("Mail-Host", "", ""); // var_dump($MailHost);
        $MailPort = Preference("Mail-Port", "", ""); //var_dump($MailPort);
        $MailSMTPSecure = Preference("Mail-SMTPSecure", "", ""); //var_dump($MailSMTPSecure);
        $MailUsername = Preference("Mail-Username", "", ""); //var_dump($MailUsername);
        $MailPassword = Preference("Mail-Password", "", ""); //var_dump($MailPassword);

        ////////CONFIGURACION DEL CORREO DE LA PLATAFORMA////////
            //date_default_timezone_set('Etc/UTC');        
            $mail = new PHPMailer;
            $mail->isSMTP(); $mail->SMTPDebug = 0; // 0 = off (for production use)// 1 = client messages// 2 = client and server messages
            $mail->Debugoutput = 'html'; $mail->Host = $MailHost;  // use // $mail->Host = gethostbyname('smtp.gmail.com'); 
            $mail->Helo = $MailHost;
            $mail->Port = $MailPort; $mail->SMTPSecure = $MailSMTPSecure; $mail->SMTPAuth = true; 
            $mail->Username = $MailUsername; $mail->Password = $MailPassword; //CUENTA MASTER
            $mail->setFrom($MailUsername, $replymail_name); //Quie envia
            $mail->addReplyTo($replymail, $replymail_name); //Reponder a nombre de 
            $mail->addAddress($mail_dest, $mail_dest_name); //Set Destinatario
            $mail->Subject = $asunto;  //Set asunto
            //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__)); //--- PARA AÑADIR CONTENIDO DESDE UN ARCHIVO
            $mail->msgHTML($contenido);
            $mail->AltBody = 'El mensaje no puede ser entregado, debido a que su cliente de correo no puede leer el formato html';
            //adjuntar imagenes //$mail->addAttachment('https:/plataformaitavu.tamaulipas.gob.mx/img/logo_copia.png');
            $correo_historia_rintera="";
            if (!$mail->send()) {//ERROR
                // echo "Error al envia a ".$mail_dest;
                return FALSE;
            } else {
                // echo "Envio con exito a ".$mail_dest;
                return TRUE;

            }
        

} else {
    return FALSE;
}
 
}
 */


    
function InfPC()
{
    $browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
    $os=array("WIN","MAC","LINUX");
    # definimos unos valores por defecto para el navegador y el sistema operativo
    $info['browser'] = "OTHER";
    $info['os'] = "OTHER";
    # buscamos el navegador con su sistema operativo
    foreach($browser as $parent)
    {
    $s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
    $f = $s + strlen($parent);
    $version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
    $version = preg_replace('/[^0-9,.]/','',$version);
    if ($s)
    {
    $info['browser'] = $parent;
    $info['version'] = $version;
    
    }
    }
    # obtenemos el sistema operativo
    foreach($os as $val)
    {
    if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
    $info['os'] = $val;
    }
    # devolvemos el array de valores
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
        $ip = getenv('HTTP_FORWARDED');
        } else {
        // Método por defecto de obtener la IP del usuario
        // Si se utiliza un proxy, esto nos daría la IP del proxy
        // y no la IP real del usuario.
        $ip = $_SERVER['REMOTE_ADDR'];
        }
    //echo getenv('HTTP_CLIENT_IP');
    //echo getenv('HTTP_X_FORWADED_FOR');
    //echo getenv('REMOTE_ADDR');
    $infofull="";
    //$infofull = $infofull. "Usuario: ".gethostname()."<br>";
    $infofull = $infofull. "SO:".$info['os'].",";
    $infofull = $infofull. "Navegador: ".$info['browser'].",";
    $infofull = $infofull. "Version:".$info['version']."";
    // $infofull = $infofull. "".$_SERVER['HTTP_USER_AGENT']."<br>";
    
    $red = "";
    // if ($ip <> '' ){$red = $red."ip:".$ip;	}
    if (strlen(getenv('HTTP_CLIENT_IP')) > 3 ){$red = $red." ".getenv('HTTP_CLIENT_IP');}
    if (strlen(getenv('HTTP_X_FORWADED_FOR')) > 3 ){$red = $red.", ".getenv('HTTP_X_FORWADED_FOR');}
    if (strlen(getenv('REMOTE_ADDR')) > 3 ){$red = $red.", ".getenv('REMOTE_ADDR');}

    if ($red <> ''){
        $infofull = $infofull.", Red: (".$red.")";
    }
    
    
    
    
    return $infofull;
}


function UserName($IdUser){
    require("config.php");	
    $UsuariosForaneaos = Preference("UsuariosForaneaos", "", "");   

    
    $sql = "select * from users WHERE IdUser='".$IdUser."'";
    
    $rc = $dbUser->query($sql);    
    if ($dbUser->query($sql) == TRUE){
        if($f = $rc -> fetch_array())
        {
            return $f['UserName'];
        } else {
            return $IdUser;
        }
        

    } else {
        
    }

}

function ReporteEncabezado($id_rep){
    return $ReporteEncabezado = "<div class='EncabezadoReporte'><h4>".TituloReporte($id_rep)."</h4><cite style='font-size:10pt;'>".DescripcionReporte($id_rep)."</cite></div>";
}

function GuardaBusqueda($IdUser, $Search){      
    require("config.php");    
    if ($Search == ''|| $Search == ' ' || $Search == '  '){ return FALSE;} else {
        $sql = "INSERT INTO search 
        (IdUser, Search) 
        VALUES ('".$IdUser."', '".$Search."')";
        // echo $sql;
        if ($conexion->query($sql) == TRUE)
        {return TRUE;}
        else {return FALSE;}
    }
    
    

}

function UltimaBusqueda($IdUser){
    require("config.php");	    
    $sql = "select * from search where IdUser = '".$IdUser."' order by IdSearch DESC limit 1";
    // echo $sql;
    $rc = $conexion->query($sql);    
    if ($conexion->query($sql) == TRUE){
        if($f = $rc -> fetch_array())
        {
            return $f['Search'];
        } else {
            return "";
        }
        

    } else {
        
    }

}


function UltimasBusquedas($IdUser){
    require("config.php");	    
    $sql = "select * from search where IdUser = '".$IdUser."' order by IdSearch DESC limit 10";
    // echo $sql;
    $rx = $conexion->query($sql);    
    if ($conexion->query($sql) == TRUE){
        echo "<div id='UltimasBusquedas'  style='
        margin: 10px;
            margin-top: 10px;
        background-color: ".Preference("ColorSecundario", "", "").";
        padding: 10px;
        border-radius: 10px;
        margin-top: 74px;
        '>";
        echo "<h4 style='font-size:11pt; color:white;'>Mis Ultimas busquedas: </h4>";
        echo "<table class='tabla'>";
    
        while($fx= $rx -> fetch_array()) {  
            echo "<tr>";
            echo "<td><a style='
            display:block;
            
            
            'href='index.php?q=".$fx['Search']."' title='haga clic aqui para realizar esta busqueda'>".$fx['Search']."</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
        

    } else {
        
    }

}

function UltimasBusquedas_buble($IdUser){
    require("config.php");	    
    $sql = "select DISTINCT Search from search where IdUser = '".$IdUser."' order by IdSearch DESC limit 10";
    // echo $sql;
    $rx = $conexion->query($sql);    
    if ($conexion->query($sql) == TRUE){
        echo "<div id='UltimasBusquedas_buble'>";
        
        while($fx= $rx -> fetch_array()) {  
           
            echo "<a class='Buble'  style='background-color:".Preference("ColorSecundario", "", "").";'           
            href='index.php?q=".$fx['Search']."' title='haga clic aqui para realizar esta busqueda'>".$fx['Search']."</a>";
            
        }
        
        echo "</div>";
        

    } else {
        
    }

}

//duplico para itavu_produccion
/* function UltimasBusquedas_buble2($IdUser){
    require("config.php");	    
    $sql = "select DISTINCT Search from search where IdUser = '".$IdUser."' order by IdSearch DESC limit 10";
    // echo $sql;
    $rx = $conexion->query($sql);    
    if ($conexion->query($sql) == TRUE){
        echo "<div id='UltimasBusquedas_buble'>";
        
        while($fx= $rx -> fetch_array()) {  
           
            echo "<a class='Buble'  style='background-color:".Preference("ColorSecundario", "", "").";'           
            href='index.php?q=".$fx['Search']."' title='haga clic aqui para realizar esta busqueda'>".$fx['Search']."</a>";
            
        }
        
        echo "</div>";
        

    } else {
        
    }

}
 */



function var_select($id_rep, $IdVar)
{

//SQLSERVERTOJSON = https://github.com/prymecode/sqlservertojson
require("config.php");	
$Query =  QueryVar($id_rep, $IdVar);
$IdCon = IdConVar($id_rep, $IdVar);
$ConType = ConType($IdCon);
// var_dump($Query);
if ($ConType <=1 ){    
    // include("con_close.php");
    $Con_IdCon = $IdCon; include("con_init.php");    
    if ($Con_Val == TRUE){    
        if ($rS = $LaConeccion -> query($Query)){            

            while($finfo = $rS -> fetch_array()) {   
                echo "<option value='".$finfo['Value']."'>".$finfo['Data']."</opion>";
            }
              
        
        } else {
            echo "ERROR al conectarse";
        }
        // var_dump($LaConeccion);
    }
    include("con_close.php");
 
} else {
//1.- Obtener datos de conección
$WS_Val = FALSE;
$WS_Msg = "";
$WSSQL = "select * from dbs where IdCon='".$IdCon."' AND Active=1 AND ConType =2"; //SQLSERVERTOJSON
echo $WSSQL;
$WSCon = $conexion -> query($WSSQL);
var_dump($WSCon);
if($WSConF = $WSCon -> fetch_array())
{
     
        $WSurl = $WSConF['wsurl'];
        $WSmethod = $WSConF['wsmethod'];
        $WSjson = $WSConF['wsjson'];
        $WSparametros = $WSConF['parametros'];

        $wsP1_id = $WSConF['wsP1_id'];  $wsP1_value = $WSConF['wsP1_value'];
        $wsP2_id = $WSConF['wsP2_id'];  $wsP2_value = $WSConF['wsP2_value'];
        $wsP3_id = $WSConF['wsP3_id'];  $wsP3_value = $WSConF['wsP3_value'];
        $wsP4_id = $WSConF['wsP4_id'];  $wsP4_value = $WSConF['wsP4_value'];

        $WS_Val = TRUE;
        // echo "OK";

                
        $url = $WSurl;            
        $sql = $Query;
        $token = $wsP1_value;

        //Peticion
        $myObj = new stdClass;
        $myObj->token = $token;
        $myObj->sql = $sql;
        $myJSON = json_encode($myObj,JSON_UNESCAPED_SLASHES);
        
        $datos_post = http_build_query(
            $myObj
        );

        $opciones = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $datos_post
            )
        );
        
        $context = stream_context_create($opciones);            
        $archivo_web = file_get_contents($url, false, $context);            
        $data = json_decode($archivo_web);
        // var_dump($opciones);
       
                $tabla = "";                  
                // //Recorrido del contenido
                $jsonIterator = new RecursiveIteratorIterator(
                    new RecursiveArrayIterator(json_decode($archivo_web, TRUE)),
                    RecursiveIteratorIterator::SELF_FIRST
                );
            
                // var_dump( $jsonIterator);
                $tabla= "<table id='".$IdTabla."'  width=100% border=0 class='".$ClaseTabla."'>";          
                $tabla_content = ""; $tabla_th = "";  
                $row=0; $rowC = 0;
                $limit = 0 ; foreach ($jsonIterator as $key => $val) {
                    if (is_numeric($key)){ //rows
                    // echo $limit."=".$key."=".$val."<br>";
                     $limit = 0;
                    }
                    else {
                        // echo "*".$limit."=".$key."=".$val."<br>";
                        $limit = $limit  + 1;
                    }
                    
                }
                // echo "limit=".$limit;

                //Construccion de <th>
                foreach ($jsonIterator as $key => $val) {
                    if (is_numeric($key)){ //rows                        
                        $rowC = 0;
                    } else {
                        if ($row < $limit){
                            if ($rowC == 0){$tabla_th.="<tr>";}                            
                            $tabla_th.="<th>".$key."</th>";
                        }                        
                    $rowC = $rowC + 1;
                    $row = $row + 1;
                    }
                }
                $tabla_th.="</tr>";
                $row =0; $rowC = 0;
                
                // echo "limit=".$limit;
                foreach ($jsonIterator as $key => $val) {
                    if (is_numeric($key)){ //rows                        
                        $rowC = 0;
                    }
                    else {                    
                        if ($rowC == 0){$tabla_content.="<tr>";}
                        if ($rowC == $limit){$tabla_content.="</tr>"; }                             
                        $tabla_content.="<td >".$val."</td>";                       
                    $rowC = $rowC + 1;
                    $row = $row + 1;
                    }
                
                
                }
                
                
                $tabla.=$tabla_th.$tabla_content."</table>";     
                $Titulo = TituloReporte($id_rep);
                $Descripcion = DescripcionReporte($id_rep);           
                // var_dump($Descripcion);
            
                var_dump($tabla);
               
    
    } else {
        echo "ERROR";
    }

}

}







/* function GraficaPorcentaje($Div, $Valor){


	echo '
	<div id="'.$Div.'" class="GraficaPorcentaje" >
		<canvas id="'.$Div.'canvas" class="GraficaPorcentajeCanvas"></canvas>    
		<div  id="'.$Div.'CanvasGLabel"  class="GraficaPorcentajeLabel">18%</div>
		<div  id="CanvasGLabelSigno"  class="GraficaPorcentajeSigno">%</div>
	</div>
	';
	
	echo "
	<script>
	function GraficaPorcentaje".$Div."(){
		var opts = {
			lines: 12, 
			angle: 0.22,
			lineWidth: 0.1, 
			pointer: {
				length: 0.5, strokeWidth: 0.035, color: '#000000' 
			},
			limitMax: 'false', 
			colorStart: '#A1C30D', 
			colorStop: '#2DA3DC',
			strokeColor: '#A1C30D', 
			generateGradient: true
		};
		var target = document.getElementById('".$Div."canvas'); 
		var gauge = new Donut(target).setOptions(opts);
		gauge.maxValue = 100; 
		gauge.animationSpeed = 20; 
		gauge.set(".$Valor."); 
		gauge.setTextField(document.getElementById('".$Div."CanvasGLabel'));
		
		textRenderer.render = function(gauge){
			//percentage = gauge.displayedValue / gauge.maxValue
			//this.el.innerHTML = (percentage * 100).toFixed(2) + '%'
			this.el.innerHTML = gauge.displayedValue + '%'
	
		};
		
	
	}  
	GraficaPorcentaje".$Div."();
	</script>
	
	";
	 


}*/

function UserNIP($IdUser){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from users WHERE IdUser='".$IdUser."'";        
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return "".$f['NIP'];
    } else {
        return "";
    }
        
}



function infoPermiso($id_rep,$IdUser){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes_permisos WHERE id_rep ='".$id_rep."' and '".$IdUser."'";        
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return "".$f['fecha']." a las ".$f['fecha']." - ".$f['QuienAutorizo'];
    } else {
        return "";
    }
        
}

function DarPermiso($id_rep, $IdUser, $IdUserAdmin){
    require("config.php");	
    $sql = "INSERT INTO reportes_permisos (id_rep, IdUser,  fecha, hora, QuienAutorizo) 
    VALUES ('".$id_rep."', '".$IdUser."', '".$fecha."', '".$hora."', '".$IdUserAdmin."')";    
    // echo $sql;
    if (UserAdmin($IdUserAdmin) == TRUE){
    if ($conexion->query($sql) == TRUE)
        {
            historia_rintera($IdUserAdmin, "Permisos", "(".$IdUserAdmin.") - ".UserName($IdUserAdmin)." dio permiso a (".$IdUser.") - ".UserName($IdUser)." para usar el reporte con id ".$id_rep);
            return TRUE;
        
            
        }


    else {return FALSE;}

    } else {

        Toast("ERROR: no tiene autorizacion para gestionar los permisos".$id_rep,2,"");

    }
}


function QuitarPermiso($id_rep, $IdUser, $IdUserAdmin){
    require("config.php");	
    $sql = "DELETE  FROM  reportes_permisos WHERE id_rep='".$id_rep."' and IdUser='".$IdUser."'";    
    // echo $sql;
    if (UserAdmin($IdUserAdmin) == TRUE){
        if ($conexion->query($sql) == TRUE)
            {
                historia_rintera($IdUserAdmin, "Permisos", "(".$IdUserAdmin.") - ".UserName($IdUserAdmin)." retiro el permiso a (".$IdUser.") - ".UserName($IdUser)." para usar el reporte con id ".$id_rep);
                return TRUE;
            
            }
        else {return FALSE;}
    }
    else {

        Toast("ERROR: no tiene autorizacion para gestionar los permisos".$id_rep,2,"");

    }
}

/* 

function fecha_larga($fecha_){
    //return  dia_semana($fecha_)." ".date('d/m/Y', strtotime($fecha_));
    $mes = date('m', strtotime($fecha_));
    $mes = (int)$mes -1;
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $mes_largo = $meses[$mes];
    $fecha_salida = dia_semana($fecha_)." ".date('d', strtotime($fecha_))." de ".$mes_largo." de ".date('Y', strtotime($fecha_));;
    
    return $fecha_salida;
    } 
    
    function fecha_larga_cumple($fecha_){
    //return  dia_semana($fecha_)." ".date('d/m/Y', strtotime($fecha_));
    $mes = date('m', strtotime($fecha_));
    $mes = (int)$mes -1;
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $mes_largo = $meses[$mes];
    $fecha_salida = dia_semana($fecha_)." ".date('d', strtotime($fecha_))." de ".$mes_largo;
    
    return $fecha_salida;
    }
    function hora12($hora_){
    return date("g:ia",strtotime($hora_));
    }    


    function dia_semana($fecha_){
        $dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
        $n= date('N', strtotime($fecha_));
        $fecha = $dias[$n-1];
        return $fecha;
        //return $fecha_;
        //return date('N', strtotime($fecha_));
    }        

*/

    

function GraficaDona($Labels, $Datas, $Titulo){

    $len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
    
    echo '<div style="width:92%; text-align:right;"><a href="#'.$IdDiv.'_modal" rel=MyModal:open><img src="icons/max.png" style="" class="btnMaximizar"></a></div>
    <canvas id="'.$IdDiv.'" width="100%" height="100%"></canvas>';
    echo '<canvas id="'.$IdDiv.'_modal" class="modal" style="display:none;" width="100%" height="100%"></canvas>';

    echo "

    <script>
    var ctx = document.getElementById('".$IdDiv."');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [".$Labels."],
            datasets: [{
               
                data: [".$Datas."],
                ".GraficaInserColores()."
                
            }]
        },
        options: {
            title: {
                display: true,
                text: '".$Titulo."'
            },
            legend: {
                display: false,
                labels: {
                    fontColor: 'rgb(255, 99, 132)'
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });



    var ctx = document.getElementById('".$IdDiv."_modal');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            title: {
                display: true,
                text: '".$Titulo."'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    
    </script>
    ";
    
}


function GraficaPie($Labels, $Datas, $Titulo){

    $len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
    
    echo '<div style="width:92%; text-align:right;"><a href="#'.$IdDiv.'_modal" rel=MyModal:open><img src="icons/max.png" style="" class="btnMaximizar"></a></div>
    <canvas id="'.$IdDiv.'" width="100%" height="100%"></canvas>';
    echo '<canvas id="'.$IdDiv.'_modal" class="modal" style="display:none;" width="100%" height="100%"></canvas>';

    echo "

    <script>
    var ctx = document.getElementById('".$IdDiv."');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [".$Labels."],
            datasets: [{
               
                data: [".$Datas."],
                ".GraficaInserColores()."
                
            }]
        },
        options: {
            title: {
                display: true,
                text: '".$Titulo."'
            },
            legend: {
                display: false,
                labels: {
                    fontColor: 'rgb(255, 99, 132)'
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });



    var ctx = document.getElementById('".$IdDiv."_modal');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            title: {
                display: true,
                text: '".$Titulo."'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    
    </script>
    ";
    
}






function GraficaBarHorizontal($Labels, $Datas, $Titulo){

    $len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
    
    echo '<div style="width:92%; text-align:right;"><a href="#'.$IdDiv.'_modal" rel=MyModal:open><img src="icons/max.png" style="" class="btnMaximizar"></a></div>
    <canvas id="'.$IdDiv.'" width="100%" height="100%"></canvas>';
    echo '<canvas id="'.$IdDiv.'_modal" class="modal" style="display:none;" width="100%" height="100%"></canvas>';

    echo "

    <script>
    var ctx = document.getElementById('".$IdDiv."');
    var myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });



    var ctx = document.getElementById('".$IdDiv."_modal');
    var myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    
    </script>
    ";
    
}




function GraficaBarLine($Labels, $Datas, $Titulo,$Fill){

    $len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
    
    echo '<div style="width:92%; text-align:right;"><a href="#'.$IdDiv.'_modal" rel=MyModal:open><img src="icons/max.png" style="" class="btnMaximizar"></a></div>
    <canvas id="'.$IdDiv.'" width="100%" height="100%"></canvas>';
    echo '<canvas id="'.$IdDiv.'_modal" class="modal" style="display:none;" width="100%" height="100%"></canvas>';

    $FillString = "";
    if ($Fill == 1) {
        $FillString = "true";
    } else {
        $FillString = "false";
    }
    echo "

    <script>
    var ctx = document.getElementById('".$IdDiv."');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {

            labels: [".$Labels."],

            datasets: [
                {
                    label: '".$Titulo."',
                    data: [".$Datas."],
                    ".GraficaInserColores()."
                    borderWidth: 1,
                    fill: ".$FillString."                
                }
            ]
        },
        options: {
          
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });



    var ctx = document.getElementById('".$IdDiv."_modal');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1,
                fill: ".$FillString."   
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    
    </script>
    ";
    
}



function GraficaBar($Labels, $Datas, $Titulo){

    $len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
    
    echo '<div style="width:92%; text-align:right;"><a href="#'.$IdDiv.'_modal" rel=MyModal:open><img src="icons/max.png" style="" class="btnMaximizar"></a></div>
    <canvas id="'.$IdDiv.'" width="100%" height="100%"></canvas>';
    echo '<canvas id="'.$IdDiv.'_modal" class="modal" style="display:none;" width="100%" height="100%"></canvas>';

    echo "

    <script>
    var ctx = document.getElementById('".$IdDiv."');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });


    var ctx2 = document.getElementById('".$IdDiv."_modal');
    var myChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    
    </script>
    ";
    
}

function GraficaInserColores(){
require("config.php");
$sql = "select 
CONCAT(rgb,',0.9') as BorderColor,
CONCAT(rgb,',0.5') as BackgroundColor
from colorines
order by rgb DESC
";
$BorderColor = "borderColor: [";
$BackgroundColor = "backgroundColor: [";
    $r= $conexion -> query($sql);
    while($f = $r -> fetch_array()) {               
        $BorderColor.="'rgba(".$f['BorderColor'].")',";
        $BackgroundColor.="'rgba(".$f['BackgroundColor'].")',";

    }
    $BorderColor = substr($BorderColor, 0, -1); //quita la ultima coma.
    $BackgroundColor = substr($BackgroundColor, 0, -1); //quita la ultima coma.
    
$BorderColor.= "],";
$BackgroundColor.= "],";
return $BorderColor.$BackgroundColor;
    // backgroundColor: [
    //     'rgba(255, 99, 132, 0.2)',
    //     'rgba(54, 162, 235, 0.2)',
    //     'rgba(255, 206, 86, 0.2)',
    //     'rgba(75, 192, 192, 0.2)',
    //     'rgba(153, 102, 255, 0.2)',
    //     'rgba(255, 159, 64, 0.2)'
    // ],
    // borderColor: [
    //     'rgba(255, 99, 132, 1)',
    //     'rgba(54, 162, 235, 1)',
    //     'rgba(255, 206, 86, 1)',
    //     'rgba(75, 192, 192, 1)',
    //     'rgba(153, 102, 255, 1)',
    //     'rgba(255, 159, 64, 1)'
    // ],



}

// function ReporteTipo($id_rep){
//     require("config.php");   
//     // var_dump($dbUser);
//     $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
//     $r= $conexion -> query($sql);
//     if($f = $r -> fetch_array())
//     {
//         return $f['out_type'];
//     } else {
//         return "FALSE";
//     }
        
// }

function Procimart_ClaveProducto($Producto){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from cat_idproducto WHERE Tipo ='".$Producto."'";            
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['IdProducto'];
    } else {
        return "";
    }
        
}

function ClaveDelProducto_id_rep($IdProducto){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from cat_idproducto WHERE IdProducto ='".$IdProducto."'";            
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['id_rep'];
    } else {
        return "";
    }
        
}





/* function Google_images($palabra, $clase, $img){
$palabra= str_replace(" ", "+", $palabra);	
// $url="http://www.google.com.mx/search?q=$palabra&source=lnms&tbm=isch&sa=X&ved=0ahUKEwiJs5L4hcPWAhXBLSYKHR9qDGAQ_AUICigB&biw=1680&bih=941";
$url ="https://www.google.com.mx/search?q=$palabra&tbm=isch&tbs=isz:l&hl=es-419&sa=X&ved=0CAEQpwVqFwoTCPCI39iCt-wCFQAAAAAdAAAAABAC&biw=1663&bih=936";
$html = file_get_contents($url);
$doc = new DOMDocument();
@$doc->loadHTML($html);
$tags = $doc->getElementsByTagName('href');
$n= 1;

foreach ($tags as $tag) {
			$img = $tag->getAttribute('src'); //echo "<img src='$img'>"."<br>";	
			if (strlen($img)>4){
				$ext = substr($img,-3);
				//if (($ext <> 'gif') and ($ext <> 'png')){
					$srcs[$n]=$img;

					$n= $n+1;
				//	}
			}
	
}
$imgs_encontradas = $n;
$n_rnd =  rand(1, $imgs_encontradas);//seleccionar una en las que se encontro

if ($img=="TRUE"){
	return "<img title='$n_rnd' value='".$srcs[$n_rnd]."' class='$clase'>"; // la enviamos armada con la clase seleccionada
	//return "<img src='".$srcs[0]."' class='$clase'>"; // la enviamos armada con la clase seleccionada
}else{
	return "".$srcs[$n_rnd].""; 
}

}

 */

function Bakcground($Tema){
    $urlImg = PixaBay($Tema); 
    echo '
    <script>
    $("body").css("background-image", "url('.$urlImg.')"); 
    $("body").css("backgroundcolor", "#919191"); 
    $("body").css("background-blend-mode", "screen"); 
    
    </script>';
}
function PixaBay($busqueda){        
    $URL = "https://pixabay.com/api/?key=18722653-1de879e03170d4ad7cefea90b&q=$busqueda&image_type=photo&pretty=true&min_width=1024&image_type=foto&page=1";
    // {
    //     "total": 4692,
    //     "totalHits": 500,
    //     "hits": [
    //         {
    //             "id": 195893,
    //             "pageURL": "https://pixabay.com/en/blossom-bloom-flower-195893/",
    //             "type": "photo",
    //             "tags": "blossom, bloom, flower",
    //             "previewURL": "https://cdn.pixabay.com/photo/2013/10/15/09/12/flower-195893_150.jpg"
    //             "previewWidth": 150,
    //             "previewHeight": 84,
    //             "webformatURL": "https://pixabay.com/get/35bbf209e13e39d2_640.jpg",
    //             "webformatWidth": 640,
    //             "webformatHeight": 360,
    //             "largeImageURL": "https://pixabay.com/get/ed6a99fd0a76647_1280.jpg",
    //             "fullHDURL": "https://pixabay.com/get/ed6a9369fd0a76647_1920.jpg",
    //             "imageURL": "https://pixabay.com/get/ed6a9364a9fd0a76647.jpg",
    //             "imageWidth": 4000,
    //             "imageHeight": 2250,
    //             "imageSize": 4731420,
    //             "views": 7671,
    //             "downloads": 6439,
    //             "favorites": 1,
    //             "likes": 5,
    //             "comments": 2,
    //             "user_id": 48777,
    //             "user": "Josch13",
    //             "userImageURL": "https://cdn.pixabay.com/user/2013/11/05/02-10-23-764_250x250.jpg",
    //         },
    //         {
    //             "id": 73424,
    //             ...
    //         },
    //         ...
    //     ]
    //     }
    ini_set('max_execution_time', 7000);
    ini_set('max_execution_time', 0);        
    $data = file_get_contents($URL);
    $Response = json_decode($data);
    $UrlFinal = "";
    $Imagenes = array();
    foreach ($Response -> hits as $key => $value) {            
            $UrlFinal = $value-> largeImageURL."<br>";
            array_push($Imagenes, $UrlFinal);
    }

    // var_dump($Imagenes);
    return $Imagenes[array_rand($Imagenes, 1)];
}