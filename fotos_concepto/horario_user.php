<?php 	
	require("unica/config.php");
    require("unica/funciones.php"); 
    
    //nos aseguramos que las variables estan limpias
    if (ValidaVAR( $_POST['nitavu'])==TRUE){
        $Usuario = LimpiarVAR($_POST['nitavu']);
    } else {$Usuario ="";}


    if (ValidaVAR( $_POST['nip'])==TRUE){
        $NIP = LimpiarVAR($_POST['nip']);
    } else {$NIP ="";}


    // $Usuario = $_POST['nitavu'];    
    // $NIP = $_POST['nip'];    
    $entrar = FALSE;
    $comentario = "<lu>";

    
    //si estas activo en la nomina
    $sql = "SELECT * FROM empleados WHERE nitavu='".$Usuario."' ";
    $rc= $conexion -> query($sql); if($f = $rc -> fetch_array()){ 
        if ($f['estado']==''){
        $entrar = TRUE;     
        
        //sino es domingo
        if ($Domingo == FALSE)	
        {	$entrar= TRUE;
            
            if ( EsInabil()==FALSE){ // si es habil el dia
                    $entrar= TRUE;
                    $HorarioInicio = HorarioInicio(($Usuario));
                    $HorarioFin = HorarioFin(($Usuario));
                    
                    // echo $HorarioInicio."-".$HorarioFin;
                    if ($hora >= $HorarioInicio and $hora <= $HorarioFin){
                        $entrar= TRUE;
                        $comentario = $comentario."<span style='font-size:10pt;'><img src='icon/asistencia.png' style='width:20px;'>"."</span>";
                        if ($f['nip']==$NIP){
                            $comentario = $comentario."<span style='font-size:10pt;'><b></b> ".$f['nombre']."</span>";
                            // $comentario = $comentario."<span style='font-size:7pt; color:#038387;'><br> Tu ultimo movimiento fue <b>".Historia_UltimoMovimiento($f['nitavu'])."</b> y has usado esta plataforma desde ".Historia_PrimerMovimiento($f['nitavu'])."</span>";
                             $comentario = $comentario."<span style='font-size:7pt; color:#038387;'><br> Tu ultimo movimiento fue <b>".Historia_UltimoMovimiento($f['nitavu'])."</b></span>";
                            
                        }
                        
                        // mensaje($HorarioFin.$hora,'');	
                    } else {
                        $comentario = $comentario."<li>En estos momentos te encuentras fuera del horario laboral establecido para  ".nitavu_dpto_nombre($f['nitavu'])." (de ".hora12($HorarioInicio)." hasta las ".hora12($HorarioFin).").";
                        if (soytitular($Usuario)<>'FALSE' ){
                            $entrar = TRUE;
                            $comentario = $comentario."Sin embargo por ser Titular puedes accesar, a las aplicaciones disponibles que no sea indispensable un horario.";
                            
                        }
                        else {
                            
                            $aprobado = HorariosTengoExcepcion($Usuario);
                            // echo $aprobado;
                            if ($aprobado == 1){
                                $entrar = TRUE;
                                $comentario = $comentario."Sin embargo tienes una excepcion autorizada para entrar.";
                            } else {								
                                $entrar = FALSE; 
                                $comentario = $comentario.". Intentalo despues.Ó puedes solicitar una excepcion <a title ='Haz clic aqui para solicitar ' href='?user=".$Usuario."'><b> aqui</b></a>. ";                            
                                
                            }

                    }
                    $comentario = $comentario."</li>";
                }
            } else {
                // dia inabil
                $comentario = $comentario."<li>Hoy esta marcado como un Dia Inábil <b>".DiaInabil($fecha)."</b>";
                
                    if (soytitular($Usuario)<>'FALSE')
                    { //Si es Titular
                        $entrar = TRUE;
                        $comentario = $comentario.".Sin embargo como eres Titular, podras accesar.";

                    } else {
                        $entrar = FALSE;
                        $comentario = $comentario.". Intenta entrar otro dia.";
                        
                    }
                $comentario = $comentario."</li>";
            }
            
        } else {// Cuando sea Domingo

            $comentario = $comentario."<li style=''><b style='color:#1A6600;'>Trabajando? Hoy es Domingo.</b>";
            if (soytitular($Usuario)<>'FALSE')
            { // Si es Titular
                $entrar = TRUE;
                $comentario = $comentario."Sin embargo eres Titular y Puedes Accesar";


            } else {
                $entrar = FALSE;
                $comentario = $comentario.". Intentalo El Lunes.";
            }
            $comentario = $comentario."</li>";
            
        }
        


        // //si tienes un BloqueoMaestro no entras
        $sql = "SELECT * FROM BloqueoMaestro WHERE Nitavu='".$Usuario."'";
        $rc2= $conexion -> query($sql); if($f2 = $rc2 -> fetch_array())
        {
            $comentario = $comentario."<li style='background-color:red; color:white;border-radius:3px;'>Hay un error con tu cuenta</li>";
            $entrar = FALSE;
            //le ponemos error con la cuenta, ya que Bloqueo Maestro esta diseñado para bloqueos de emergencia con autorizacion verbal o ejecutados directamente desde la aplicacion por direcciones.
        } else {


        }
    }
    else {
        $comentario = $comentario."<li style='color:red;'>No puedes accesar, tu estado laboral es ".$f['estado']."</li>";
    }
    } 
    else {
        $entrar = FALSE; 
        $comentario = $comentario."<li style='color:red;'>Usuario no valido "."</li>";
        // historia($Usuario,"Intento entrar  cuando su estado laboral no es activo, a la plataforma desde la ip ".$_SESSION['myip']."<br>".detectar());
        // LogOut();

   }
        

    
    

    //si es dia inabil y eres titular, y estas en la lista autorizada de aplicaciones para dicho dia
    echo "<table>";

    echo "<tr>";
        
        echo "<td>";
        if ($f['nip']==$NIP){            
           echo ponerfoto("fotos/".$Usuario.".jpg",'fotoLogin');
        }
        
        
        echo "</td>";
        
        echo "<td style='font-size: 8pt;

        text-align: left;
        
        margin: 5px;
        
        padding: 2px;'>".$comentario."</td>";
    
    echo "</tr>";
    echo "</table>";












?>


