<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
require("viaticos_fun.php");
echo 	'<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>';

?>

<script>
    
$(document ).ready(function() {
   
    if ($("#checkTipoTransporte_ninguno").prop("checked")==true){
        $("#checkTipoTransporte_aereo").prop("checked",false);
        $("#checkTipoTransporte_terrestre").prop("checked",false);       
        $("#terrestre").css("display", "none");
        $("#aereo").css("display", "none");
        $("#idtipotransporte").val(0);
      
    }
    else if ($("#checkTipoTransporte_aereo").prop("checked")==true){
        $("#checkTipoTransporte_ninguno").prop("checked",false);
        $("#checkTipoTransporte_terrestre").prop("checked",false);
        $("#terrestre").css("display", "none");
         $("#aereo").css("display", "block");
         $("#idtipotransporte").val(1);
    }
    else if ($("#checkTipoTransporte_terrestre").prop("checked")==true){
        $("#checkTipoTransporte_ninguno").prop("checked",false)
        $("#checkTipoTransporte_aereo").prop("checked",false);
        $("#terrestre").css("display", "block");
        $("#aereo").css("display", "none");
        $("#idtipotransporte").val(2);
        
    }





    if ($("#checkTipoTransporte_ningunoR").prop("checked")==true){
        $("#checkTipoTransporte_aereoR").prop("checked",false);
        $("#checkTipoTransporte_terrestreR").prop("checked",false);       
        $("#terrestreR").css("display", "none");
        $("#aereoR").css("display", "none");
        $("#idtipotransporteR").val(0);
      //  alert(  "Entro1");
      
    }
    else if ($("#checkTipoTransporte_aereoR").prop("checked")==true){
        $("#checkTipoTransporte_ningunoR").prop("checked",false);
        $("#checkTipoTransporte_terrestreR").prop("checked",false);
        $("#terrestreR").css("display", "none");
         $("#aereoR").css("display", "block");
         $("#idtipotransporte").val(1);
      //   alert(  "Entro2");
    }
    else if ($("#checkTipoTransporte_terrestreR").prop("checked")==true){
        $("#checkTipoTransporte_ningunoR").prop("checked",false)
        $("#checkTipoTransporte_aereoR").prop("checked",false);
        $("#terrestreR").css("display", "block");
        $("#aereoR").css("display", "none");
        $("#idtipotransporteR").val(2);
       
        
    }
  
    
});


</script>
<?php

$id_aplicacion ="viaticos"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos
//Niveles
// 1 = Crear y Editar
// 2 = VoBo Viaticos
// 3 = VoBo Admon
// 4 = VoBo Recursos Fincieros
// 5 = VoBo Comisaria

//Ajusta esta variable para ver el comportamiento


if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
   // echo $nivel;
   
    // if($nivel==2)
    // {
    //     echo "<a style='right: 10px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px; color: white;text-decoration: unset;'  href='viaticos_presupuesto.php'  class='Mbtn btn-Gray' title='Administrar el prosupuesto de viaticos' class='btn btn-link'>     
    //     Presupuesto Viáticos</a>";
    // }

    // echo "<a style='right: 150px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px; color: white;text-decoration: unset;'  href='viaticos_preliminares.php'  class='Mbtn btn-Gray' title='Viáticos Preliminares' class='btn btn-link'>     
    // Viáticos Preliminares</a>";

    // echo "<a style='right: 300px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px; color: white;text-decoration: unset;'  href='viaticos_archibadps.php'  class='Mbtn btn-Gray' title='Viáticos Preliminares' class='btn btn-link'>     
    // Viáticos Archivados</a>";



   

    // echo "<script>$('body').css('background-color','rgb(108, 116, 119)');</script>";
    // echo "<script>$('body').css('background-image','url(img/wallviaticos.png)');</script>";
    // echo "<script>$('body').css('background-position','top');</script>";
    // echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    
    // // echo "<script>$('body').css('background-size','120%');</script>";
    echo "<script>$('body').css('background-color','white');</script>";
    echo "<script>$('body').css('background-image','url(img/fondoviaticos.png)');</script>";
    echo "<script>$('body').css('background-size','100% 100%');</script>";
    echo "<script>$('body').css('background-repeat','repeat');</script>";
    echo "<script>$('body').css('background-position','left top');</script>";
    echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    
    if (isset($_GET['IdViatico'])){
        $IdViatico = VarClean($_GET['IdViatico']);

    } else {
        $IdViatico = "";
        viaticosMenu();
        

        if($nivel==2)
        {
            echo "<a style='background-color: #ddc9a3; right:500px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px; color: black; text-decoration: unset;'  href='viaticos_reportes.php'  class='Mbtn btn-Gray' title='Viáticos Reportes' class='btn btn-link'>     
           Reportes</a>";

            echo "<a style='background-color: #ddc9a3; right: 410px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px; color: black; text-decoration: unset;'  href='viaticos_admonrecorridos.php'  class='Mbtn btn-Gray' title='Administrar los recorridos de viaticos' class='btn btn-link'>     
            Recorridos</a>";
        }

        echo "<a style='background-color: #ddc9a3; right:320px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px; color: black; text-decoration: unset;'  href='viaticos_preliminares.php'  class='Mbtn btn-Gray' title='Viáticos Preliminares' class='btn btn-link'>     
        Preliminares</a>";

        echo "<a style='background-color: #ddc9a3;right: 230px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px; color: black; text-decoration: unset;'  href='viaticos_cancelados.php'  class='Mbtn btn-Gray' title='Viáticos Cancelados' class='btn btn-link'>     
        Cancelados</a>";

        echo "<a style='background-color: #ddc9a3; right: 140px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px; color: black; text-decoration: unset;'  href='viaticos_archivados.php'  class='Mbtn btn-Gray' title='Viáticos Archivados' class='btn btn-link'>     
        Archivados</a>";

        if($nivel==4 or $nivel==2)
        {
            echo "<a style='background-color: #ddc9a3; right: 0px; position: absolute; top: 50px; margin-top: 10px;font-size: 12px; color: black; text-decoration: unset;'  href='viaticos_presupuesto.php'  class='Mbtn btn-Gray' title='Administrar el presupuesto de viaticos' class='btn btn-link'>     
            Presupuesto Viáticos</a>";
        
        }
   

    }


    $nitavu_dir=quienEsmiDireccion(nitavu_dpto($nitavu));
    
        echo "<br><br><div id='Resultado' style='margin-top:60px; z-index: 10;'>";

        echo "</div>";
    if (isset($_GET['new'])){//Viaticar



        echo "<div id='DivViaticar' class='' style='margin-top:80px;'>";
        $NEmpleado = VarClean($_GET['new']);
        $Nombre = nitavu_nombre($NEmpleado);
        $EmpleadoNivel = nitavu_nivel($NEmpleado);

        
        $sqlE="SELECT
        * 
        FROM
        empleadosfull_noactivity WHERE nitavu='".$NEmpleado."'";
        $rc= $conexion -> query($sqlE);
	    if($Empleado = $rc -> fetch_array()){

            //Crear IdViatico
            if (isset($_GET['IdViatico'])){
                $IdViatico = VarClean($_GET['IdViatico']);
                //Validar Viatico
                if (viaticos_Valida($IdViatico,$NEmpleado)==TRUE){

                } else {
                    MsgBox_Lite("ERROR; Viatico no valido","viaticos.php");
                    
                }


            } 
            else {
                $IdViatico = NIdViatico(FALSE);
                if (viaticosIn($IdViatico, $NEmpleado, $nitavu) == TRUE){

                    //Toast("Se Registro el Viatico con Id ".$IdViatico,4,"");

                     echo "
                    <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'EXITO',
                        text: 'Se Registro el Viatico con Id ".$IdViatico,4," ',
                        timer: 1500,
                        footer: ''
                    });
                    </script>
                    ";
                } else {
                    //Toast("Error al registrar el IdViatico",2,"");
                    echo "
                    <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR',
                        text: 'Error al registrar el IdViatico',
                        timer: 1500,
                        footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
                    });
                    </script>  ";
                }
    
            }

            
                    echo "<h1 style='background-color: #ab0033; border-radius: 5px; font-size: 18pt; color: white; padding: 5px; margin-top: -30px; margin-bottom: -5px;'>
                    <i class='fa-solid fa-clipboard-list'></i>   ".$IdViatico." | <i class='fa-solid fa-id-card-clip'></i>   ".strtoupper(nitavu_nombre($NEmpleado))."</h1>";
                    echo '<div  class="wf-container">';
                    
                        echo "<div class='wf-box'>";                        
                            echo ponerfoto("fotos/".$NEmpleado.".jpg",'FotoE');
                        echo "</div>";

                        echo '<div class="wf-box" style="border-radius: 4px; background-color: #ddc9a3; text-align: center; border: #ddc9a3 solid 2px;" >';
                            echo '<div class=" "><span style="font-family:Compacta">NUMERO DE EMPLEADO</span><br> ';
                                echo '<b>'.strtoupper($Empleado['nitavu']).'</b>';
                            echo '</div>';      
                        echo '</div>';

                        echo '<div class="wf-box" style="border-radius: 4px; background-color: #ddc9a3; text-align: center; border: #ddc9a3 solid 2px;" >';
                            echo '<div class=" "><span style="font-family:Compacta">RFC</span><br> ';
                                echo '<b>'.strtoupper($Empleado['rfc']).'</b>';
                            echo '</div>';      
                        echo '</div>';

                        echo '<div class="wf-box" style="border-radius: 4px; background-color: #ddc9a3; text-align: center; border: #ddc9a3 solid 2px;">';
                            echo '<div class=" "><span style="font-family:Compacta">NIVEL DE SUELDO</span><br> ';
                                echo '<b>'.$Empleado['nivel'].'</b>';
                            echo '</div>';      
                        echo '</div>';

                        echo '<div class="wf-box" style="border-radius: 4px; background-color: #ddc9a3; text-align: center; border: #ddc9a3 solid 2px;" >';
                            echo '<div class=" "></i><span style="font-family:Compacta">DIRECCION</span><br> ';
                                echo '<b>'.strtoupper($Empleado['Direccion']).'</b>';
                            echo '</div>';      
                        echo '</div>';

                        echo '<div class="wf-box" style="border-radius: 4px; background-color: #ddc9a3; text-align: center; border: #ddc9a3 solid 2px;" >';
                            echo '<div class=" "><span style="font-family:Compacta">DEPARTAMENTO</span><br> ';
                                echo '<b>'.strtoupper($Empleado['DepartamentoNombre']).'</b>';
                            echo '</div>';      
                        echo '</div>';

                        echo '<div class="wf-box" style="border-radius: 4px; background-color: #ddc9a3; text-align: center; border: #ddc9a3 solid 2px;" >';
                            echo '<div class=" "><span style="font-family:Compacta">  PUESTO</span><br> ';
                                echo '<b>'.strtoupper($Empleado['puesto']).'</b>';
                            echo '</div>';      
                        echo '</div>';

                        echo '<div class="wf-box" style="border-radius: 4px; background-color: #ddc9a3; text-align: center; border: #ddc9a3 solid 2px;" >';
                            echo '<div class=" "><span style="font-family:Compacta">  LUGAR DE ADSCRIPCION</span><br> ';
                                echo '<b>'.strtoupper($Empleado['adscripcion']).'</b>';
                            echo '</div>';      
                        echo '</div>';

                        echo '<br>';
                        echo '<br>';
                        echo '<br>';
                        echo '<br>';

                        // echo '<div class="wf-box" style="
                        // border-radius: 4px;
                        // background-color: #f7efb3;
                        // text-align: center;                
                        // border: #ead875 solid 2px; 
                        // " >';
                        //         // background-color:transparent;
                        //         // border: 0px;
                        //         // height:300px;
                        //         // font-size:8pt;
                        //         echo '<div class=" "><span style="font-family:Compacta">Comision:<br> ';
                        //         echo '<textarea style="
                               
                                
                        //  border: 2px solid #ffffff17;
                        //  border-radius: 4px;
                        //  background-color: white;
                        //  text-align: center;                
                        //  border: #d2d2d2 solid 1px;
                        //         "
                        //         class="form-control" 
                        //         id="Comision">'.viaticos_Comision($IdViatico).'</textarea>';

                               
                           
                        //         echo '</div>';      
                               
                        
                        // echo '</div>';

                        
                        // echo '<div class="wf-box" style="                    
                        // border-radius: 4px;
                        // background-color: #f7efb3;
                        // text-align: center;                
                        // border: #ead875 solid 2px;
                        // " >';
                        //         echo '<div class=" "><span style="font-family:Compacta">No. de Oficio de Comisión:</span><br> ';
                        //         echo '<input style="                              
                        //         border: 2px solid #ffffff17;
                        //         border-radius: 4px;
                        //         background-color: white;
                        //         text-align: center;                
                        //         border: #d2d2d2 solid 1px;
                        //         class="form-control" id="NOficio" type="text" value="'.viaticos_Oficio($IdViatico).'">';
                        //         echo '</div>';      
                                
                        
                        // echo '</div>';



                        
                            // echo '<div class="wf-box" style="                            
                            // border-radius: 4px;
                            // background-color: #f7efb3;
                            // text-align: center;                
                            // border: #ead875 solid 2px;
                            // " >';
                            // // background-color:transparent;
                            // // border: 0px;"
                            
                            //         echo '<div class=" "><span style="font-family:Compacta">Fecha y Hora de <b>Salida:</b></span><br> ';
                            //         echo '<input style="
                            //         border: 2px solid #ffffff17;
                            //         border-radius: 4px;
                            //         background-color: white;
                            //         text-align: center;                
                            //         border: #d2d2d2 solid 1px;
                            //         class="form-control" id="FechaSalida" type="date" value="'.viaticos_SalidaFecha($IdViatico).'" required>';

                            //         // $HoraSalida = date("H:i" , strtotime(viaticos_SalidaHora($IdViatico)))
                            //         // background-color:transparent;
                            //         // border: 0px;
                            //         echo '<input title="escriba en Formato 12" style="                                  
                            //         border: 2px solid #ffffff17;
                            //         border-radius: 4px;
                            //         background-color: white;
                            //         text-align: center;                
                            //         border: #d2d2d2 solid 1px;
                            //         "
                            //         class="form-control" id="HoraSalida" type="time" value="'.date("H:i" , strtotime(viaticos_SalidaHora($IdViatico))).'" required>';

                            //         echo '</div>';      
                                    
                            
                            // echo '</div>';

                        //     echo '<div class="wf-box" style="                                
                        //     border-radius: 4px;
                        //     background-color: #f7efb3;
                        //     text-align: center;                
                        //     border: #ead875 solid 2px;
                        //     " >'; 
                        //             // background-color:transparent;
                        //             // border: 0px;
                        //             echo '<div class=" "><span style="font-family:Compacta">Fecha y Hora de <b>Salida</b>:</span><br> ';
                        //             echo '<input style="                                   
                        //             border: 2px solid #ffffff17;
                        //             border-radius: 4px;
                        //             background-color: white;
                        //             text-align: center;                
                        //             border: #d2d2d2 solid 1px;
                        //             class="form-control" id="FechaRegreso" type="date"  value="'.viaticos_SalidaFecha($IdViatico).'">';

                        //             // background-color:transparent;
                        //             // border: 0px;"
                        //             echo '<input title="escriba en Formato 12" style="
                        //             border: 2px solid #ffffff17;
                        //             border-radius: 4px;
                        //             background-color: white;
                        //             text-align: center;                
                        //             border: #d2d2d2 solid 1px;
                        //             class="form-control" id="HoraRegreso" type="time"  value="'.date("H:i" , strtotime(viaticos_SalidaHora($IdViatico))).'" >';
                        //             echo '</div>';      
                                    
                            
                        //     echo '</div>';
                       
                        //     echo '<div class="wf-box" style="                                
                        //         border-radius: 4px;
                        //         background-color: #f7efb3;
                        //         text-align: center;                
                        //         border: #ead875 solid 2px;
                        //         " >'; 
                        //                 // background-color:transparent;
                        //                 // border: 0px;
                        //                 echo '<div class=" "><span style="font-family:Compacta">Fecha y Hora de <b>Regreso</b>:</span><br> ';
                        //                 echo '<input style="                                   
                        //                 border: 2px solid #ffffff17;
                        //                 border-radius: 4px;
                        //                 background-color: white;
                        //                 text-align: center;                
                        //                 border: #d2d2d2 solid 1px;
                        //                 class="form-control" id="FechaRegreso" type="date"  value="'.viaticos_RegresoFecha($IdViatico).'">';

                        //                 // background-color:transparent;
                        //                 // border: 0px;"
                        //                 echo '<input title="escriba en Formato 12" style="
                        //                 border: 2px solid #ffffff17;
                        //                 border-radius: 4px;
                        //                 background-color: white;
                        //                 text-align: center;                
                        //                 border: #d2d2d2 solid 1px;
                        //                 class="form-control" id="HoraRegreso" type="time"  value="'.date("H:i" , strtotime(viaticos_RegresoHora($IdViatico))).'" >';
                        //                 echo '</div>';      
                                        
                                
                        //         echo '</div>';
                       
                        // echo '<div class="wf-box" style="
                        // border-radius: 4px;
                        // background-color: #f7efb3;
                        // text-align: center;                
                        // border: #ead875 solid 2px;
                        // " >';
                        // background-color:transparent;
                        // border: 0px;"
                        //         echo '<div class=" "><span style="font-family:Compacta">Total de Kilometros:</span><br> ';
                        //         echo '<input style="
                        //         border: 2px solid #ffffff17;
                        //         border-radius: 4px;
                        //         background-color: white;
                        //         text-align: center;                
                        //         border: #d2d2d2 solid 1px;
                        //         class="form-control readonly" id="KilometrosTotal" type="text"  value="'.viaticos_KilometrosTotal($IdViatico).'" readonly>';


                                
                        //         echo '</div>';      
                               
                        
                        // echo '</div>';


                        
                        // echo '<div class="wf-box" style="                        
                        // border-radius: 4px;
                        // background-color: #f7efb3;
                        // text-align: center;                
                        // border: #ead875 solid 2px;
                        // " >';
                        //         echo '<div class=" "><span style="font-family:Compacta">Tarifa de Hospedaje: <b title="Nivel de Contratacion del Empleado" style="cursor:pointer;">('.$EmpleadoNivel.')</b></span><br> ';
                        //         // echo '<input style="
                        //         // background-color:transparent;
                        //         // border: 0px;"
                        //         // class="form-control" id="KilometrosTotal" type="text"  value="'.viaticos_KilometrosTotal($IdViatico).'">';

                        //         $EmpleadoNivel = nitavu_nivel($NEmpleado);
                        //         $sqlx= "select * from viaticoshospedaje WHERE
                        //         NivelMax >= '".$EmpleadoNivel."' and 
                        //         NivelMin <= '".$EmpleadoNivel."'";	                                
                        //         $rx= $conexion -> query($sqlx);   
                        //         //background-color:transparent; border:0px;font-size:8pt;"              
                        //         echo '<select id="IdHospedaje" class="form-control" style="
                          

                        //         border: 2px solid #ffffff17;
                        //         border-radius: 4px;
                        //         background-color: white;
                        //         text-align: center;                
                        //         border: #d2d2d2 solid 1px;
                        //         >';
                        //         $selected = "";
                        //         $selected_one = 0;
                        //         $IdHospedaje = viaticos_IdHospedaje($IdViatico);
                        //         while($fx = $rx -> fetch_array()) {         
                        //             if ($fx['IdHospedaje'] == $IdHospedaje){
                        //                 $selected = "selected";
                        //                 $selected_one = 1;
                        //             }  else {
                        //                 $selected = "";
                        //             }                   

                        //             echo '<option value="'.$fx['IdHospedaje'].'" '.$selected.' >';
                        //                 echo "$".$fx['Cantidad']." (".$fx['Tipo'].") ".$fx['Descripcion'];
                        //             echo "</option>";

                        //         }
                        //         if ($selected_one == 0){
                        //             echo "<option value='0' selected>Sin Hospedaje</option>";
                        //         } else {
                        //             echo "<option value='0' >Sin Hospedaje</option>";
                        //         }
                                    
                                
                        //         unset($rx, $fx, $sqlx);
                        //         echo "</select>";
                        //         echo '</div>';      
                               
                        
                        // echo '</div>';

                  
                    echo "</div>";

                    echo "</div>";

/*****************************************************/   
// CONFIGURACION DEL VIATICO

/*****************************************************/ 

echo "<div id='ConfigViatico' style='margin-top:60px; z-index: 10;                       
background-color: #d7d7d7;
margin: 10px;
border-radius: 10px;
padding: 10px;
border: solid #c1c1c1  1px;'>";
echo "<h3 style='background-color:#ab0033; color:white; font-size:13pt;'><i class='fa-solid fa-gear'></i>   Configuración del Viático</h3>";
echo "<hr>";
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col" style="text-align:center;">';
echo '<span style="font-family:Compacta;">No. de Oficio de Comisión:</b></span><br>';
                                echo '<input style="                              
                                border: 2px solid #ffffff17;
                                border-radius: 4px;
                                background-color: white;
                                text-align: center;                
                                border: #d2d2d2 solid 1px;
                                class="form-control" id="NOficio" type="text" value="'.viaticos_Oficio($IdViatico).'">';



                                
                                echo '<div class="col">';
                                echo '<span style="font-family:Compacta;">Fecha y Hora de <b>Salida:</b></span><br>';
                                echo '<input style="                                   
                                border: 2px solid #ffffff17;
                                border-radius: 4px;
                                background-color: white;
                                text-align: center;                
                                border: #d2d2d2 solid 1px;
                                class="form-control" id="FechaSalida" type="date"  value="'.viaticos_SalidaFecha($IdViatico).'">';
                                echo '<input title="escriba en Formato 12" style="
                                border: 2px solid #ffffff17;
                                border-radius: 4px;
                                background-color: white;
                                text-align: center;                
                                border: #d2d2d2 solid 1px;
                                class="form-control" id="HoraSalida" type="time"  value="'.date("H:i" , strtotime(viaticos_SalidaHora($IdViatico))).'" >';  


                                echo ' <div class="col">';
                                echo '<span style="font-family:Compacta;">Fecha y Hora de <b>Regreso:</b></span><br>'; 
                                echo '<input style="                                   
                                border: 2px solid #ffffff17;
                                border-radius: 4px;
                                background-color: white;
                                text-align: center;                
                                border: #d2d2d2 solid 1px;
                                class="form-control" id="FechaRegreso" type="date"  value="'.viaticos_RegresoFecha($IdViatico).'">';
                                
                                // background-color:transparent;
                                // border: 0px;"
                                echo '<input title="escriba en Formato 12" style="
                                border: 2px solid #ffffff17;
                                border-radius: 4px;
                                background-color: white;
                                text-align: center;                
                                border: #d2d2d2 solid 1px;
                                class="form-control" id="HoraRegreso" type="time"  value="'.date("H:i" , strtotime(viaticos_RegresoHora($IdViatico))).'" >';
                                echo ' </div>';

                                echo ' <div class="col">';
                                echo '<span style="font-family:Compacta;">Total de Kilometros:</b></span><br>'; 
                                echo '<input style="
                                border: 2px solid #ffffff17;
                                border-radius: 4px;
                                background-color: white;
                                text-align: center;                
                                border: #d2d2d2 solid 1px;
                                class="form-control readonly" id="KilometrosTotal" type="text"  value="'.viaticos_KilometrosTotal($IdViatico).'" readonly>';
                                echo ' </div>';



                                $jefeInmediato=viaticos_JefeInmediato($IdViatico);
                                // ECHO  nitavu_nombre(quienesmijefe(viaticos_NEmpleado($IdViatico)));
                                if( strlen($jefeInmediato)==0)
                                { 
                                    $jefeInmediato=nitavu_nombre(quienesmijefe(viaticos_NEmpleado($IdViatico)));
                                   
                                }else{
                                  
                                    $jefeInmediato=viaticos_JefeInmediato($IdViatico);
                                }
                                echo ' <div class="col">';
                                echo '<span style="font-family:Compacta;">Jefe inmediato</b></span><br>'; 
                                echo '<input style="
                                border: 2px solid #ffffff17;
                                border-radius: 4px;
                                background-color: white;
                                text-align: center;                
                                border: #d2d2d2 solid 1px;
                                class="form-control " id="jefeinmediato" type="text"  value="'.$jefeInmediato.'" >';
                                echo ' </div>';

                                // echo ' <div class="col">';
                                // echo '<div class=" "><span style="font-family:Compacta">Tarifa de Hospedaje: <b title="Nivel de Contratacion del Empleado" style="cursor:pointer;">('.$EmpleadoNivel.')</b></span><br> ';
                                
                                
                                // $EmpleadoNivel = nitavu_nivel($NEmpleado);
                                // $sqlx= "select * from viaticoshospedaje WHERE
                                // NivelMax >= '".$EmpleadoNivel."' and 
                                // NivelMin <= '".$EmpleadoNivel."'";	                                
                                // $rx= $conexion -> query($sqlx);   
                                // //background-color:transparent; border:0px;font-size:8pt;"              
                                // echo '<select id="IdHospedaje" class="form-control" style="
                                
                                
                                // border: 2px solid #ffffff17;
                                // border-radius: 4px;
                                // background-color: white;
                                // text-align: center;                
                                // border: #d2d2d2 solid 1px;
                                // >';
                                // $selected = "";
                                // $selected_one = 0;
                                // $IdHospedaje = viaticos_IdHospedaje($IdViatico);
                                // while($fx = $rx -> fetch_array()) {         
                                //     if ($fx['IdHospedaje'] == $IdHospedaje){
                                //         $selected = "selected";
                                //         $selected_one = 1;
                                //     }  else {
                                //         $selected = "";
                                //     }                   
                                
                                //     echo '<option value="'.$fx['IdHospedaje'].'" '.$selected.' >';
                                //         echo "$".$fx['Cantidad']." (".$fx['Tipo'].") ".$fx['Descripcion'];
                                //     echo "</option>";
                                
                                // }
                                // if ($selected_one == 0){
                                //     echo "<option value='0' selected>Sin Hospedaje</option>";
                                // } else {
                                //     echo "<option value='0' >Sin Hospedaje</option>";
                                // }
                                    
                                
                                // unset($rx, $fx, $sqlx);
                                // echo "</select>";
                                // echo '</div>'; 

                                // echo ' </div>';
                                echo ' </div>';



echo ' </div>';


echo '<div class="col">';
echo '<span style="font-family:Compacta;"> Descripción de la comisión:</b></span><br>';
echo '<textarea style="                                        
border: 2px solid #ffffff17;
border-radius: 4px;
background-color: white;
text-align: Justify;                
border: #d2d2d2 solid 1px;
height: 341px;       "
       class="form-control" 
       id="Comision">'.viaticos_Comision($IdViatico).'</textarea>';

       echo ' </div>';
echo ' </div>';

echo '</div>';
echo "</div>";
                  
echo "</div>";

                 
                 


/*****************************************************/   
// CONFIGURACION DEL RECORRIDO

/*****************************************************/ 

// if ($ServiciosGoogle == TRUE){
//     if (CheckServiciosGoogle()==FALSE) {
//     echo "<div id='ErrorGoogle' style='margin-top:60px; z-index: 10;                       

//         background-color: #f20606;
//         margin: 10px;
//         border-radius: 10px;
//         padding: 10px;
//         border: solid #eaded0  1px;
//         color:white;
    
    
//     '>
//     <table width='100%'>
//     <tr><td><img src='icon/alerta.png' style='width:50px;'></td>
//     <td style='color:white; text-align:center;'>
//     No se ha podido conectar con los Servicios de Google Directions y Maps; sin estos servicios no se 
//     podra relizar calculos automaticos basados en direcciones.
//     </td></tr></table>
//     </div>";
//     }
// }


   
                    echo "<div id='DivGastos' style='background-color: #d7d7d7; margin: 10px; border-radius: 10px; padding: 10px; border: solid #c1c1c1 1px;";
                    if(viaticos_estatus($IdViatico)!=0  and viaticos_estatus($IdViatico)!=10 )
                    {
                        echo "    pointer-events: none;";
                    }
                
                    echo "'>";
                    echo "<h3 style='background-color: #ab0033; color: white; font-size:13pt;'><i class='fa-solid fa-gear'></i>   Configuracion de los Gastos de Alimentacion   <button type='button' class='btn btn-warning' style='background-color: #dddddd; box-shadow: 0 3px #ddc9a3;' onclick='CrearGastos();'> <i class='fa-solid fa-file-invoice-dollar'></i>
                    Calcular gastos </button></h3>";

                    //echo "<h3 style='background-color: #ab0033; color: white; font-size:13pt;'>Configuracion de los Gastos de Alimentacion<img onclick='CrearGastos();' title='Recalcular' src='icon/nomina.png' style='width:33px; margin-top:-5px; cursor:pointer;'></h3>";

                    // echo "<button title='Atencion: Esto borra la tabla actual, y la creara nuevamente.' onclick='CrearGastos();' class='btn btn-DefaultGray' style='background-color:#a6a3a6; font-size:8pt; font-family:Light; width:100%;'>Crear</button>";

                    echo "<table width=100%>";
                    echo "<tr><td algin=center>";
                        echo "<div id='RGastos' style='
                        background-color: #ffffff5e;
                        width: 98%;
                        padding: 5px;
                        '>";
                        echo "Resultados";
                        echo "</div>";
                    echo "</td></tr>";
                    echo "</table>";



                    echo "</div>";



echo "<div id='ConfigRecorrido' style='margin-top:60px; z-index: 10;                       
    background-color: #d7d7d7;
    margin: 10px;
    border-radius: 10px;
    padding: 10px;
    border: solid #c1c1c1  1px;";
    if(viaticos_estatus($IdViatico)!=0  and viaticos_estatus($IdViatico)!=10)
    {
        echo "    pointer-events: none;";
    }

echo "'>";

echo "<h3 style='background-color: #ab0033; color: white; font-size:13pt;'><i class='fa-solid fa-gear'></i>   Configuración del Recorrido</h3>";
 echo '<div class="container">';
    echo '<div class="row">';
    
    echo '<div class="col" >';
        echo '<span style="font-family:Compacta;">Origen:</b></span><br>';
        echo '<select style="border: 2px solid #ffffff17;
        border-radius: 4px;
        background-color: white;               
        border: #d2d2d2 solid 1px;"  onchange="LlenarDestinos();" name="LugarOrigen" id="LugarOrigen">';

        echo "<option value='0'>SELECCIONE</option>";
        $sql = "SELECT distinct origen FROM cat_recorridosviaticos ORDER by origen ASC";
        //echo $sql;
        $r = $conexion -> query($sql);
         while($f = $r -> fetch_array())
         { // resultado de la busqueda.................
                echo "<option value='".$f['origen']."'>".$f['origen']. "</option>";	
              
        }
        echo '</select>';
    echo '</div>';
    echo '<div class="col" >';
        echo '<span style="font-family:Compacta;">Destino:</b></span><br>';
        echo '<select style="border: 2px solid #ffffff17;
        border-radius: 4px;
        background-color: white;                 
        border: #d2d2d2 solid 1px;" name="LugarDestino" id="LugarDestino" onchange="MostrarDistancia();">';
        //echo  "<option>Seleccione un origen antes para cargar destinos...</option>";    
        echo '</select>';
    echo '</div>';
    echo '<div class="col" >';
    echo '<span style="font-family:Compacta;">Distancia (km):</b></span><br>';
    echo '<input style="                                   
    border: 2px solid #ffffff17;
    border-radius: 4px;
    background-color: white;
    text-align: center;                
    border: #d2d2d2 solid 1px;
    class="form-control" id="Distancia" name="Distancia" type="text"  value="'.'" readonly>';
    echo '<input style="                                   
    border: 2px solid #ffffff17;
    border-radius: 4px;
    background-color: white;
    text-align: center;                
    border: #d2d2d2 solid 1px;
    class="form-control" id="id" name=id" type="hidden"  value="'.'" readonly>';
    echo '</div>';

    echo '<div class="col" >';
    echo '<span style="font-family:Compacta;">Recorrido Interno (km):</b></span><br>';
    echo '<input style="                                   
    border: 2px solid #ffffff17;
    border-radius: 4px;
    background-color: white;
    text-align: center;                
    border: #d2d2d2 solid 1px;"
    class="form-control" id="RecorridoInterno" name="RecorridoInterno" type="text"  value="" >';
    echo '</div>';


    echo '<div class="col" style="text-align:center">';
    echo '<span style="font-family:Compacta;">Viaje Redondo</b></span><br>';
    echo " <input style='height:35px;                               
    border: 2px solid #ffffff17;
    border-radius: 4px;
    background-color: white;
    text-align: center;                
    border: #d2d2d2 solid 1px;'   type='checkbox' id='viajeredondo' name='viajeredondo'>";
    echo '</div>';


    echo '<div  style=" align-self: end; width: 10%;">'; 
    echo "<button style='margin-left: 5px; align-self: end; border-color:#ddc9a3;background-color:#ddc9a3;color: black; box-shadow:0 3px #bc955c' onclick='Agregar();' title='Agregar un nuevo recorrido al viatico' class='btn btn-primary'>+</button> ";   
    echo '</div>';
    echo '</div>';
echo '</div>';


echo "<div id='RecorridosList' style='
width: 100%;
margin-top: 10px;
background-color: #d7d7d7;
padding: 5px;
border-radius: 5px;
font-size: 9pt;
;'>";

// $sql="select Origen, Destino, Distancia from viaticosrecorridos WHERE IdViatico='".$IdViatico."'";
// TablaDinamica_MySQL("",$sql, "RecorridosDiv", "RecorridosTable", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal

$sql="select  * from viaticosrecorridos WHERE IdViatico='".$IdViatico."'";
//echo $sql;
$r= $conexion -> query($sql);   
echo "<table class='tabla'>";
echo "<th style = 'background-color:#ddc9a3; color:black;'>Punto</th>";
echo "<th style = 'background-color:#ddc9a3; color:black;'>Recorrido</th>";
echo "<th style = 'background-color:#ddc9a3; color:black;'>Distancia</th>"; 
echo "<th style = 'background-color:#ddc9a3; color:black;'>Recorrido Interno</th>"; 
echo "<th style = 'background-color:#ddc9a3; color:black; padding: 10px;'>#Dias</th>";      
echo "<th style = 'background-color:#ddc9a3; color:black; padding: 10px;text-align: center;'>¿Dormirá en el lugar?</th>";
echo "<th style = 'background-color:#ddc9a3; color:black; padding: 10px;text-align: center;'>¿Pagar combustible?</th>";
echo "<th style = 'background-color:#ddc9a3; color:black;'>Acción</th>";
$Lin = 1;
$kms = 0;
$checked="";
$checked1="";
$numrecorridos=viaticos_NReccorridos($IdViatico);
while($V = $r -> fetch_array())
{
    if($V['duerme_en_lugar']=="1")
{
    $checked="checked";
}else
{
    $checked="";  
}
 
if($V['pagarcombustible']=="1")
{
    $checked1="checked";
}else{
    $checked1="";
}


    echo "<tr>";
    echo "<td><b title='IdRecorrido=".$V['IdRecorrido']."'>".$Lin."</b></td>";
    echo "<td><b title='IdRecorrido=".$V['IdRecorrido']."'>".$V['Origen']." ~ ".$V['Destino']."</b></td>";
    echo "<td>".$V['Distancia']." km</td>";    
    echo "<td width=100>".$V['RecorridoInterno']." km</td>"; 
    
    if($numrecorridos!=$Lin)
    {
        echo "<td width=10 align=center> <input  style='text-align: center;' type='text' id='dias".$V['IdRecorrido']."' name='dias".$V['IdRecorrido']."' onkeyup='CalculoxDias(".$V['IdRecorrido'].")' value='".$V['dias']."'>  </td>";
        echo "<td width=100 align=center> <input style='text-align: center;' type='checkbox' id='check".$V['IdRecorrido']."' name='check".$V['IdRecorrido']."' onclick='duermeLugar(".$V['IdRecorrido'].")' ". $checked. "> Si </td>";    
      
    }else{
        echo "<td width=10 align=center> 1 </td>";
        echo "<td width=100 align=center>  </td>";    
      
    }
    echo "<td width=100 align=center> <input style='text-align: center;' type='checkbox' id='checkCombustible".$V['IdRecorrido']."' name='checkCombustible".$V['IdRecorrido']."'  onclick='pagarcombustible(".$V['IdRecorrido'].")' ". $checked1. "> Si </td>";  
   echo "<td width=50 align=right><button onclick='del(".$V['IdRecorrido'].");' class='btn btn-danger'>X</button></td>";

    echo "</tr>";
    $kms = $kms + floatval($V['Distancia'])+floatval($V['RecorridoInterno']);
    $Lin = $Lin + 1;
}
echo "<tr style='background-color: white;'>";
echo "<td></td>";
echo "<td align=right><b>TOTAL</b></td>";
echo "<td align=left>".$kms." km</td>";    
echo "<td width=50 align=right></td>";

echo "</tr>";

echo "</table>";
// echo "<script>$('#KilometrosTotal').val(".$kms.");</script>";
unset($sql, $V, $r);

//echo "</div>";

echo "</td>";

echo "</tr>";
echo "</table>";


echo "</div>";
echo '<div class="col" >';
echo '<span style="font-family:Compacta;">Descripción del recorrido excedente:</b></span><br>';
echo '<textarea style="                                        
border: 2px solid #ffffff17;
border-radius: 4px;
background-color: white;
text-align: Justify;                
border: #d2d2d2 solid 1px;
height: 100px; width:100%"
class="form-control" 
id="recorridoExcedente">'.viaticos_RecorridoExcedente($IdViatico).'</textarea>';

       echo ' </div>';

echo "</div>";


   



                   echo "<div id='DivTraslado' style='
                    background-color: #D7D7D7;
                    margin: 10px;
                    border-radius: 10px;
                    padding: 10px;
                    border: solid #c1c1c1  1px;
                    height:40%;";
                    if(viaticos_estatus($IdViatico)!=0 and viaticos_estatus($IdViatico)!=10)
                    {
                        echo "    pointer-events: none;";
                    }
                
                    echo "'>";
                    echo "<h3 style='background-color: #ab0033; color: white; font-size:13pt;'><i class='fa-solid fa-gear'></i>   Configuracion Traslado</h3>";

                    echo "<div style='float:left; padding:20px;width:50%; lightcyan'>  ";

                    echo "<center>";
                    echo "<i class='fa-solid fa-road-circle-check'></i>";
                    echo '<h7><b>   VEHICULO DE IDA</b></h7><br>';
                    echo "</center>";
                    // background-color: #ffffff70;
                    // border-radius: 5px;
                    // width: 135px;">';
                    // echo "<tr>";
                    // echo '<td width="20%" align="center">  <input class=""  onclick="checkTipoTransporte();" type="radio" name="checkTipoTransporte" id="checkTipoTransporte_ninguno" >  <span>Ninguno</span> </td>';
                    // echo '<td width="20%" align="center">  <input class=""  onclick="checkTipoTransporte();" type="radio" name="checkTipoTransporte" id="checkTipoTransporte_aereo" >  <span>Aéreo</span> </td>';
                    // echo '<td width="20%" align="center">  <input class=""  onclick="checkTipoTransporte();" type="radio" name="checkTipoTransporte" id="checkTipoTransporte_terrestre" > <span>Terrestre</span>  </td>';
                    // echo "</tr>";
                    //<legend style="font-family:Compacta; font-size:medium;">Transportación:</legend>
                    $IdTipoTransporte = viaticos_IdTipoTransporte($IdViatico);
                    if($IdTipoTransporte==0)
                    {
                        $ninguno="checked"; 
                        $aereo=""; 
                        $terrestre=""; 
                        $valorIdTipoTransporte=0;

                    } else if($IdTipoTransporte==1)
                    {
                        $ninguno=""; 
                        $aereo="checked"; 
                        $terrestre=""; 
                        $valorIdTipoTransporte=1;
                    }
                    else{
                        $ninguno=""; 
                        $aereo=""; 
                        $terrestre="checked"; 
                        $valorIdTipoTransporte=2;
                    }
                    echo'  <fieldset data-role="controlgroup" data-theme="b" data-type="horizontal" >                           
                            <input type="radio" onclick="checkTipoTransporte();"   name="checkTipoTransporte" id="checkTipoTransporte_ninguno"  '.$ninguno.'>
                            <label for="radio-choice-t-6a" style="font-family:Compacta; font-size:medium;"><i class="fa-solid fa-mug-hot"></i>  Ninguno</label>
                            <input type="radio"  onclick="checkTipoTransporte();"  name="checkTipoTransporte" id="checkTipoTransporte_aereo"  '.$aereo.'>
                            <label for="radio-choice-t-6b" style="font-family:Compacta; font-size:medium;"><i class="fa-solid fa-plane"></i>  Aereo</label>
                            <input type="radio" onclick="checkTipoTransporte();"   name="checkTipoTransporte" id="checkTipoTransporte_terrestre"   '.$terrestre.'>
                            <label for="radio-choice-t-6c" style="font-family:Compacta; font-size:medium;"><i class="fa-solid fa-car-side"></i>  Terrestre</label>
                            <input type="hidden"   name="idtipotransporte" id="idtipotransporte" value="'.$valorIdTipoTransporte.'" >
                        </fieldset>';


                    
                    echo "<BR>";

                    echo '<div id="aereo" style="display:none;">';
                    echo '<table style="width:100%"><tr><td>';
                                echo '<span style="font-family:Compacta;">Información:</b></span><br>'; 
                                echo '<input style="
                                border: 2px solid #ffffff17;
                                border-radius: 4px;
                                background-color: white;
                                text-align: center;                
                                border: #d2d2d2 solid 1px;"
                                class="form-control" id="infaereo" name="infaereo" type="text"  value="'.viaticos_Veh_Transporte($IdViatico).'" >';
                                echo "</td>";
                                echo "<td>";
                                echo '<span style="font-family:Compacta;">Costo:</b></span><br>'; 
                                echo '<input style="
                                border: 2px solid #ffffff17;
                                border-radius: 4px;
                                background-color: white;
                                text-align: center;                
                                border: #d2d2d2 solid 1px;"
                                class="form-control" id="infgasto" name="infgasto" type="text"  value="'.viaticos_Veh_TransporteGasto($IdViatico).'" >';
                                echo "</td></tr></table>";
                      echo ' </div>'; //cierra div aerero



                    echo '<table width=100% id="terrestre" style="display:none;"><tr><td style="
                            background-color: #D7D7D7;
                            border-radius: 5px;
                            width: 135px;font-family:Compacta;">';

                    $TipoTransporte = viaticos_TipoTransporte($IdViatico);
                    if ($TipoTransporte=='PARTICULAR'){
                        echo '
                        Medio de Transporte:<br>                        
                        <input class="" onclick="checkVehiculo();" type="radio" name="checkTipoVehiculo" id="checkTipoVehiculo_particular" checked>                        
                        <label>Particular</label><br>                        
                        <input class="" onclick="checkVehiculo();" type="radio" name="checkTipoVehiculo" id="checkTipoVehiculo_oficial" >                        
                        <label>Ofical</label><br>
                        
                        <input class="" onclick="checkVehiculo();" type="radio" name="checkTipoVehiculo" id="checkTipoVehiculo_publico" >                        
                        <label>T. Publico</label>
                        
                        
                        ';

                    } else {
                        if ($TipoTransporte=='OFICIAL'){
                            echo '
                            Medio de Transporte:<br>                            
                            <input class="" onclick="checkVehiculo();" type="radio" name="checkTipoVehiculo" id="checkTipoVehiculo_particular" >                        
                            <label>Particular</label><br>                        
                            <input class="" onclick="checkVehiculo();" type="radio" name="checkTipoVehiculo" id="checkTipoVehiculo_oficial" checked >                        
                            <label>Ofical</label><br>
                            
                            <input class="" onclick="checkVehiculo();" type="radio" name="checkTipoVehiculo" id="checkTipoVehiculo_publico" >                        
                            <label>T. Publico</label>';

                        } else {
                            if ($TipoTransporte=='PUBLICO'){
                                echo '
                                Medio de Transporte:<br>                                
                                <input class="" onclick="checkVehiculo();" type="radio" name="checkTipoVehiculo" id="checkTipoVehiculo_particular" >                        
                                <label>Particular</label><br>                        
                                <input class="" onclick="checkVehiculo();" type="radio" name="checkTipoVehiculo" id="checkTipoVehiculo_oficial"  >                        
                                <label>Ofical</label><br>
                                
                                <input class="" onclick="checkVehiculo();" type="radio" name="checkTipoVehiculo" id="checkTipoVehiculo_publico" checked >                        
                                <label>T. Publico</label>
                                
                                
                                ';  

                            } else {
                                echo '
                                Medio de Transporte:<br>
                                <input class="" onclick="checkVehiculo();" type="radio" name="checkTipoVehiculo" id="checkTipoVehiculo_particular" >                        
                                <label>Particular</label><br>                        
                                <input class="" onclick="checkVehiculo();" type="radio" name="checkTipoVehiculo" id="checkTipoVehiculo_oficial"  checked >                        
                                <label>Ofical</label><br>
                                
                                <input class="" onclick="checkVehiculo();" type="radio" name="checkTipoVehiculo" id="checkTipoVehiculo_publico"  >                        
                                <label>T. Publico</label>
                                
                                
                                ';  
                            }
                        }
                    }
                    
                    echo '</td>';

                    echo '<td valing=top>';
                    echo "<div id='RTraslado' style='
                    background-color: White; width: 98%;  padding: 10px;'>";
                    // echo "Resultados";
                    echo "</div>";
                    echo "<script></script>";

                    // FormElement_input("No. de Vehiculo Ofical:", "", "", "No. Economico", "text", "IdVehiculoOficial", TRUE);
                    // FormElement_input("Marca:", "", "", "", "text", "Veh_Marca", FALSE);

                       
                    echo '</td></tr></table>';

                    echo "</div>"; //cierre del primer div

                    echo "<div style='float:left; padding:20px; width:50%;'>";
                    echo "<center>";
                    echo "<i class='fa-solid fa-house'></i>";
                    echo '<h7><b>   VEHICULO DE RETORNO</b></h7><br>';
                    echo "</center>";





                    $IdTipoTransporteR = viaticos_IdTipoTransporteR($IdViatico);
                   
                    if($IdTipoTransporteR==0)
                    {
                        $ningunoR="checked"; 
                        $aereoR=""; 
                        $terrestreR=""; 
                    $valorIdTipoTransporteR=0;

                    } else if($IdTipoTransporteR==1)
                    {
                        $ningunoR=""; 
                        $aereoR="checked"; 
                        $terrestreR=""; 
                        $valorIdTipoTransporteR=1;
                    }
                    else{
                        $ningunoR=""; 
                        $aereoR=""; 
                        $terrestreR="checked"; 
                        $valorIdTipoTransporteR=2;
                    }
                    echo'  <fieldset data-role="controlgroup" data-theme="b" data-type="horizontal" >                           
                            <input type="radio" onclick="checkTipoTransporteR();"   name="checkTipoTransporteR" id="checkTipoTransporte_ningunoR"  '.$ningunoR.'>
                            <label for="radio-choice-t-6a" style="font-family:Compacta; font-size:medium;"><i class="fa-solid fa-mug-hot"></i>  Ninguno</label>
                            <input type="radio"  onclick="checkTipoTransporteR();"  name="checkTipoTransporteR" id="checkTipoTransporte_aereoR"  '.$aereoR.'>
                            <label for="radio-choice-t-6b" style="font-family:Compacta; font-size:medium;"><i class="fa-solid fa-plane"></i>  Aereo</label>
                            <input type="radio" onclick="checkTipoTransporteR();"   name="checkTipoTransporteR" id="checkTipoTransporte_terrestreR"   '.$terrestreR.'>
                            <label for="radio-choice-t-6c" style="font-family:Compacta; font-size:medium;"><i class="fa-solid fa-car-side"></i>  Terrestre</label>
                            <input type="hidden"   name="idtipotransporteR" id="idtipotransporteR" value="'.$valorIdTipoTransporteR.'" >
                        </fieldset>';


                    
                    echo "<BR>";

                    echo '<div id="aereoR" style="display:none;">';
                    echo '<table style="width:100%"><tr><td>';
                                echo '<span style="font-family:Compacta;">Información:</b></span><br>'; 
                                echo '<input style="
                                border: 2px solid #ffffff17;
                                border-radius: 4px;
                                background-color: white;
                                text-align: center;                
                                border: #d2d2d2 solid 1px;"
                                class="form-control" id="infaereoR" name="infaereoR" type="text"  value="'.viaticos_Veh_TransporteR($IdViatico).'" >';
                                echo "</td>";
                                echo "<td>";
                                echo '<span style="font-family:Compacta;">Costo:</b></span><br>'; 
                                echo '<input style="
                                border: 2px solid #ffffff17;
                                border-radius: 4px;
                                background-color: white;
                                text-align: center;                
                                border: #d2d2d2 solid 1px;"
                                class="form-control" id="infgastoR" name="infgastoR" type="text"  value="'.viaticos_Veh_TransporteGastoR($IdViatico).'" >';
                                echo "</td></tr></table>";
                      echo ' </div>'; //cierra div aerero



                    echo '<table width=100% id="terrestreR" style="display:none;"><tr><td style="
                            background-color: #D7D7D7;
                            border-radius: 5px;
                            width: 135px;font-family:Compacta;">';

                    $TipoTransporteR = viaticos_TipoTransporteR($IdViatico);
                    if ($TipoTransporteR=='PARTICULAR'){
                        echo '
                        Medio de Transporte:<br>
                        
                        <input class="" onclick="checkVehiculoR();" type="radio" name="checkTipoVehiculoR" id="checkTipoVehiculo_particularR" checked>                        
                        <label>Particular</label><br>                        
                        <input class="" onclick="checkVehiculoR();" type="radio" name="checkTipoVehiculoR" id="checkTipoVehiculo_oficialR" >                        
                        <label>Ofical</label><br>
                        
                        <input class="" onclick="checkVehiculoR();" type="radio" name="checkTipoVehiculoR" id="checkTipoVehiculo_publicoR" >                        
                        <label>T. Publico</label>
                        
                        
                        ';

                    } else {
                        if ($TipoTransporteR=='OFICIAL'){
                            echo '
                            Medio de Transporte:<br>
                            
                            <input class="" onclick="checkVehiculoR();" type="radio" name="checkTipoVehiculoR" id="checkTipoVehiculo_particularR" >                        
                            <label>Particular</label><br>                        
                            <input class="" onclick="checkVehiculoR();" type="radio" name="checkTipoVehiculoR" id="checkTipoVehiculo_oficialR" checked >                        
                            <label>Ofical</label><br>
                            
                            <input class="" onclick="checkVehiculoR();" type="radio" name="checkTipoVehiculoR" id="checkTipoVehiculo_publicoR" >                        
                            <label>T. Publico</label>';

                        } else {
                            if ($TipoTransporteR=='PUBLICO'){
                                echo '
                                Medio de Transporte:<br>
                                
                                <input class="" onclick="checkVehiculoR();" type="radio" name="checkTipoVehiculoR" id="checkTipoVehiculo_particularR" >                        
                                <label>Particular</label><br>                        
                                <input class="" onclick="checkVehiculoR();" type="radio" name="checkTipoVehiculoR" id="checkTipoVehiculo_oficialR"  >                        
                                <label>Ofical</label><br>
                                
                                <input class="" onclick="checkVehiculoR();" type="radio" name="checkTipoVehiculoR" id="checkTipoVehiculo_publicoR" checked >                        
                                <label>T. Publico</label>
                                
                                
                                ';  

                            } else {
                                echo '
                                Medio de Transporte:<br>
                                
                                <input class="" onclick="checkVehiculoR();" type="radio" name="checkTipoVehiculoR" id="checkTipoVehiculo_particularR" >                        
                                <label>Particular</label><br>                        
                                <input class="" onclick="checkVehiculoR();" type="radio" name="checkTipoVehiculoR" id="checkTipoVehiculo_oficialR"  checked >                        
                                <label>Ofical</label><br>
                                
                                <input class="" onclick="checkVehiculoR();" type="radio" name="checkTipoVehiculoR" id="checkTipoVehiculo_publicoR"  >                        
                                <label>T. Publico</label>
                                
                                
                                ';  
                            }
                        }
                    }
                    
                    echo '</td>';

                    echo '<td valing=top>';
                    echo "<div id='RTrasladoR' style='
                    background-color: White; width: 98%;  padding: 10px;'>";
                    // echo "Resultados";
                    echo "</div>";
                    echo "<script></script>";

                    // FormElement_input("No. de Vehiculo Ofical:", "", "", "No. Economico", "text", "IdVehiculoOficial", TRUE);
                    // FormElement_input("Marca:", "", "", "", "text", "Veh_Marca", FALSE);

                       
                    echo '</td></tr></table>';


                    echo "</div>"; //cierre del segundo div
                
                    // echo "<button title='Atencion: Esto borra la tabla actual, y la creara nuevamente.' onclick='CrearGastos();' class='btn btn-DefaultGray' style='background-color:#a6a3a6; font-size:8pt; font-family:Light; width:100%;'>Crear</button>";

                    
                    echo "</div>";


                   echo "<div id='DivStatus' style=' 
                   background-color: #d7d7d7;
                   margin: 10px;
                   border-radius: 10px;
                   padding: 10px;
                   border: solid #c1c1c1  1px;";
                   echo viaticos_estatus($IdViatico);
                   if(viaticos_estatus($IdViatico)!=0 or viaticos_estatus($IdViatico)!=10)
                   {
                       echo "    pointer-events: none;";
                   }
               
                   echo "'>";
                   
                   echo "<table width=100%>";
                   echo "<tr><td width=40% valign=top>";



                   echo "<div>";

                   echo "<center>";
                   echo '<h7><b><i class="fa-solid fa-file-invoice-dollar"></i>   GASTOS EXTRAS</b></h7><br>';
                   echo "</center>";

                   FormElement_input("Concepto:", 0, "Gasto Extra", "Gasto Extra", "text", "VGextra_concepto");
                   FormElement_input("Cantidad:", 0, "Cuanto Extra", "Gasto Extra", "number", "VGextra_cantidad");

                   echo "<button class='btn btn-primary' onclick='AgregarVGextra();' style='margin-top: 29px; border-color:#ddc9a3;background-color:#ddc9a3;color: black; box-shadow:0 3px #bc955c'>Agregar</button>";




                   echo "<hr>";
                   echo "<div style='
                   background-color: #e3e3e3;
                   margin: 10px;
                   padding: 5px;
                   border-radius: 5px;
                   font-size: 9pt;
                   
                   '
                   id='GastoExtra_lista'
                   >";
                       $sql="
                       select 
                       GastoExtra, Cantidad, Cancelar
                       from viaticosgastosextras_html
                       where IdViatico='".$IdViatico."'
                       ";
                       TablaDinamica_MySQL("",$sql, "DivGastosExtras", "TablaGastosExtras", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                   echo "</div>";



                       echo "</div>";
                   

                   echo "</td><td valing=top >";
                   echo "<div style='
                   
                   background-color: #e3e2e3;
                   padding: 7px;
                   border: solid #c1c1c1  1px;
                   '>
                   <table width=100%><tr><td width=80%>
                   <h7><i class='fa-solid fa-file-invoice-dollar'></i><b>   RESUMEN GASTOS DEL VIATICO</b></h7><br>
                   </<td><td align=right><img  src='icon/actualizar.png' style='width:20px; cursor:pointer;' onclick='viaticosResumen();' title='Haz clic aqui para actualizar el resumen'></td></tr></table>";
                   echo "<div id='ResumenGastos' style='
                   
                   
                   '></div></div>";

                   echo "</td></tr></table>";
                   echo "</div>";



                    echo "<div id='botones' style='
                    
                    padding: 10px;
                    margin-top: 20px;
                    text-align: center;
                    '>";
                     //echo viaticos_estatus($IdViatico);
                   // echo  $nivel;
                   // GUARDAR VIATICO
                    if((viaticos_estatus($IdViatico)==0 and ($nivel==1 or $nivel==2 or $nivel==3 or $nivel==4 or $nivel==6) )or (viaticos_estatus($IdViatico)==10 and  $nivel==1))
                    {
                    echo "
                    <button class='Mbtn btn-danger' style='width:130px' onclick='Guardar(0)'>
                        <table width=100%><tr><td><img src='icon/guardar_blanco.png' style='width:24px;'></td>
                        <td style='color:white;'>Guardar</td></tr></table>
                    </button>
                    ";

                   
                    }     
                    
                    //ENVIAR VIATICO A VOBO
                    if((viaticos_estatus($IdViatico)==0 and ($nivel==1 or $nivel==2 or $nivel==3 or $nivel==4 or $nivel==6) )or (viaticos_estatus($IdViatico)==10 and  $nivel==1))
                    {
                    echo "
                    <button class='Mbtn btn-danger' style='width:130px' onclick='Guardar(1)'>
                        <table width=100%><tr><td><img src='icon/guardar_blanco.png' style='width:24px;'></td>
                        <td style='color:white;'>Enviar</td></tr></table>
                    </button>
                    ";

                   
                    }     
                    

                   //VOBO
                    if(viaticos_estatus($IdViatico)==10 and  $nivel==6)
                    {
                        $titulo="VoBo";
                        $direccion=quienEsmiDireccion(nitavu_dpto($nitavu));    
                        $nombreDpto = DptoNombre($direccion);//DptoNombreCorto($f['IdDepartamento']);
                        $mensaje="Está apunto de marcar que el viático tiene el VoBo por parte de la ".$nombreDpto;
                        $opcion=1; 
                                      
                        echo "<a  href='#modalObservaciones' rel='MyModal:open' class='Mbtn btn-danger'  style='color: white;text-decoration: unset;'>VoBo</a>"; 
                
                    }

                    //or viaticos_estatus($IdViatico)==11
                    if((viaticos_estatus($IdViatico)==1  )and  $nivel==2)
                    {
                    //     echo "<button class='Mbtn btn-danger' onclick='Guardar2(2);'>
                    //     <table width=100%><tr><td><img src='icon/guardar_blanco.png' style='width:24px;'></td>
                    //     <td style='color:white;'>VoBo Viaticos</td></tr></table>
                    // </button>";

                    $titulo="VoBo Viaticos";
                    $mensaje="Está apunto de marcar con VoBo el viático, ¿Que desea hacer?";
                    $opcion=2;                   
                    echo "<a  href='#modalObservaciones' rel='MyModal:open' class='Mbtn btn-danger'  style='color: white;text-decoration: unset;'> VoBo Viaticos</a>"; 
                    
                    echo "<a style='display:none;'  href='oficio_viaticos.php?id=".$IdViatico."' download='OficioComsion.pdf'  id='oficioformato' name='oficioformato' target='_blank'><img src='icon/pdf.png' style='width:15px;'></a>
                    ";
                    echo "<a style='display:none;' href='Viaticos_Formato.php?id=".$IdViatico."' download='ViaticosFormato.pdf'  id='viaticosformato' name='viaticosformato' target='_blank'><img src='icon/pdf.png' style='width:15px;'></a>
                    ";

                    echo "<button class='Mbtn btn-danger' onclick='MostrarFormatos();'>
                    <table width=100%><tr><td></td>
                    <td style='color:white;'>Imprimir Formato</td></tr></table>
                    </button>";
                
                    }
                    if($nivel==2 and viaticos_estatus($IdViatico)==2 )
                    {
                        //echo "<a  href='#modalObservaciones' rel='MyModal:open' class='Mbtn btn-danger'  style='color: white;text-decoration: unset;'> VoBo Viaticos</a>"; 
                    
                        echo "<a style='display:none;'  href='oficio_viaticos.php?id=".$IdViatico."' download='OficioComsion.pdf'  id='oficioformato' name='oficioformato' target='_blank'><img src='icon/pdf.png' style='width:15px;'></a>
                        ";
                        echo "<a style='display:none;' href='Viaticos_Formato.php?id=".$IdViatico."' download='ViaticosFormato.pdf'  id='viaticosformato' name='viaticosformato' target='_blank'><img src='icon/pdf.png' style='width:15px;'></a>
                        ";
    
                        echo "<button class='Mbtn btn-danger' onclick='MostrarFormatos();'>
                        <table width=100%><tr><td></td>
                        <td style='color:white;'>Imprimir Formato</td></tr></table>
                        </button>";
                    }

                      // VOBO COMISARIA 
                    if(viaticos_estatus($IdViatico)==2 and ($nivel==5))
                    {
                        $titulo="VoBo Comisaria";
                        $mensaje="Está apunto de marcar que el viático ha recibido el VoBo por parte de Comisaría, ¿Que desea hacer?";
                        $opcion=7; 
                        echo "<a  href='#modalObservaciones' rel='MyModal:open' class='Mbtn btn-danger'  style='color: white;text-decoration: unset;'>VoBo Comisaría</a>";
                        // echo "<button class='Mbtn btn-danger' onclick='Guardar2(7);'>
                        // <table width=100%><tr><td><img src='icon/guardar_blanco.png' style='width:24px;'></td>
                        // <td style='color:white;'>VoBo Comisaria</td></tr></table>
                        // </button>";
                    }
                    echo "</div>";

                  
                    //IMPRIMIR FORMATO
                    if(viaticos_estatus($IdViatico)==7 and ($nivel==1 or $nivel==2))
                    {
                    //     echo "
                    // <a target=_blank  href='oficio_viaticos.php?id=".$IdViatico."' id='oficioformato' name='oficioformato' class='btn btn-secondary' style='display:none;' >
                    //     <table width=100%><tr><td><img src='icon/vobo.png' style='width:24px; margin-right:10px'></td>
                    //     <td style='color:white;' align=right>Imprimir Formato</td></tr></table>
                    // </a>
                    echo "<center>";
                    echo "<a style='display:none;'  href='oficio_viaticos.php?id=".$IdViatico."' download='OficioComsion.pdf'  id='oficioformato' name='oficioformato' target='_blank'><img src='icon/pdf.png' style='width:15px;'></a>
                     ";
                     echo "<a style='display:none;' href='Viaticos_Formato.php?id=".$IdViatico."' download='ViaticosFormato.pdf'  id='viaticosformato' name='viaticosformato' target='_blank'><img src='icon/pdf.png' style='width:15px;'></a>
                     ";

                    
                    echo "<button class='Mbtn btn-danger' onclick='Guardar2(3);'>
                    <table width=100%><tr><td><img src='icon/guardar_blanco.png' style='width:24px;'></td>
                    <td style='color:white;'>Imprimir Formato</td></tr></table>
                    </button>";
                    echo "</center>";
                    }

                    // VOBO DE LA DIR ADMINISTRATICA
                    if(viaticos_estatus($IdViatico)==3 and ($nivel==3 or $nivel==2))
                    {
                        $titulo="VoBo de la Dir. Administrativa";
                        $mensaje="Está apunto de marcar que el viático tiene el VoBo de la Dir. Administrativa, ¿Que desea hacer?";
                        $opcion=4;   
                        echo "<center>";  
                        echo "<a  href='#modalObservaciones' rel='MyModal:open' class='Mbtn btn-danger'  style='color: white;text-decoration: unset;'>VoBo Dir. Administrativa</a>"; 
                    //     echo "<button class='Mbtn btn-danger' onclick='Guardar2(4);'>
                    //     <table width=100%><tr><td><img src='icon/guardar_blanco.png' style='width:24px;'></td>
                    //     <td style='color:white;'>Firmas</td></tr></table>
                    // </button>";
                    echo "</center><br>";                   
                    }

                    //MARCAR COMO VIATICO PAGADO
                    if(viaticos_estatus($IdViatico)==4 and ($nivel==4  or $nivel==2))
                    {
                        $titulo="Viatico Pagado";
                        $mensaje="Está apunto de marcar que el viático ha sido pagado por el Dpto. De Rec. Financieros, ¿Que desea hacer?";
                        $opcion=5; 
                    //     echo "<button class='Mbtn btn-danger' onclick='Guardar2(5);'>
                    //     <table width=100%><tr><td><img src='icon/guardar_blanco.png' style='width:24px;'></td>
                    //     <td style='color:white;'>Pagar Viatico</td></tr></table>
                    //    </button>";
                    echo "<center>"; 
                    echo "<a  href='#modalObservaciones' rel='MyModal:open' class='Mbtn btn-danger'  style='color: white;text-decoration: unset;'>Viatico Pagado</a>"; 
                    echo "</center>";     
                }


                //     if(viaticos_estatus($IdViatico)==5 and $nivel==2)
                //     {
                //         $titulo="Viático Comprobado";
                //         $mensaje="Está apunto de marcar que el viático se realizó y ah sido comprobado exitosamente por el empleado, ¿Que desea hacer?";
                //         $opcion=6; 
                //          echo "<center>
                //         <table width=40%><tr>
                //         <td>
                //         <a  href='#modalObservaciones' rel='MyModal:open' class='Mbtn btn-danger'  style='color: white;text-decoration: unset;'>Viático Comprobado</a>
                //       </td>
                       
                        
                //          </tr>
                //         </table> </center>";
                //         // echo "<a  href='#modalObservaciones' rel='MyModal:open' class='Mbtn btn-danger'  style='color: white;text-decoration: unset;'>Viático Comprobado</a>";
                //         // echo "<a  href='#modalObservaciones2' rel='MyModal:open' class='Mbtn btn-danger'  style='color: white;text-decoration: unset;'>Viático Comprobado-Cancelado</a>";
            
                   
                //    //  <td>
                //         //  <a  href='#modalObservaciones2' rel='MyModal:open' class='Mbtn btn-danger'  style='color: white;text-decoration: unset;'>Viático Comprobado-Cancelado</a>
                //         //  </td>
                        
                //     }

                

                     // COMISARIA VOBO FINAL
                    if(viaticos_estatus($IdViatico)==6 and ($nivel==5 or $nivel==2))
                    {
                        $titulo="VoBo Comisaria-Comprobacion";
                        $mensaje="Viático comprobado exitosamente";
                        $opcion=7; 
                        echo "<a  href='#modalObservaciones' rel='MyModal:open' class='Mbtn btn-danger'  style='color: white;text-decoration: unset;'>VoBo Comisaría- Comprobación</a>";
                        // echo "<button class='Mbtn btn-danger' onclick='Guardar2(7);'>
                        // <table width=100%><tr><td><img src='icon/guardar_blanco.png' style='width:24px;'></td>
                        // <td style='color:white;'>VoBo Comisaria</td></tr></table>
                        // </button>";
                    }

                    echo "</div>";


               


                    echo "
                    <script>
                    function Calcular(){
                        Origen = $('#LugarOrigen').val();
                        Destino = $('#LugarDestino').val();
                        $('#RecorridoInterno').val('');
                        Distance();
                        
                        
                
                    }
                    function Limpiar(){
                        $('#LugarOrigen').val('');
                        $('#LugarDestino').val('');
                        $('#Distancia').val('');
                        $('#RecorridoInterno').val('');
                    }
                    function Agregar(){
                        Origen = $('#LugarOrigen').val();
                        Destino = $('#LugarDestino').val();                                           
                        Distancia =   $('#Distancia').val();
                        RecorridoInterno = $('#RecorridoInterno').val();
                        checkBox = document.getElementById('viajeredondo');
                        
                        if (Distancia == 0) {
                            $.toast('Debe calcularse primero la distancia');
                        } else {
                            Lats();";

                    if ($ServiciosGoogle == TRUE){
                        echo "  Mapping();";
                    }
                    
                    echo "
                            Limpiar();
                        }
                     
                
                    }
                    
                    </script>
                    
                    ";
                
                    
                if ($ServiciosGoogle == TRUE){
                echo "
                <script>
                function initMap() {
                var map = new google.maps.Map(document.getElementById('gmap'), {	
                    zoom: 5,
                    center: {lat: 41.876, lng: -87.624
                    }
                });
                
                
                
                //Begin Routing
                // const directionsService = new google.maps.DirectionsService();
                // const directionsRenderer = new google.maps.DirectionsRenderer();
                // directionsRenderer.setMap(map);
                // const request = {
                //    origin: new google.maps.LatLng(40.350637, -3.693359),
                //    destination: new google.maps.LatLng(40.348336, -3.696776),
                //    travelMode: 'DRIVING'
                // };
                
                // directionsService.route(request, response => {
                //    directionsRenderer.setDirections(response);
                // });
                
                
                }
                
                
                </script>
                <script src='https://maps.googleapis.com/maps/api/js?key=".$key_directions."&callback=initMap'
                async defer></script>
                ";
                }
                
            
    

        } else {
            echo "
                   <script>
                   Swal.fire({
                       icon: 'error',
                       title: 'Error',
                       text: 'Error en el numero de empleado ',
                       timer: 1500,
                       footer: ''
                   });
                   </script>
                   ";
            
            //Toast("Error en el numero de empleado",2,"");
        }



        echo "</div>";



    } 
    
    
    else{
       // echo "<br><br><br>";
        echo "<div id='VPendientes' style='
            background-color: #ffffffb0;
            padding: 10px;
            margin: 10px;
            margin-top: 10px;
            margin-top: 70px;
            border-radius: 6px;
            border: solid #c1c1c1 1px;
        '>";

   

        echo "<h3 style='color: Black;'>Viaticos en Tramite</h3>";
        echo "<hr>";
        //captura 
        if($nivel==1 )
        {
        // $sql = "SELECT
        // a.IdViatico,
        // a.NEmpleado,
        // (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
        // IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
        // a.SalidaFecha,
        // a.RegresoFecha,
        // a.estatus
        
        // FROM
        //     viaticos a
        // WHERE
        //     Activa=1 and (estatus!= 0 and a.NEmpleado='".$nitavu."')
        // ORDER BY
        //     NEmpleado,
        //     CapturaFecha,  a.estatus desc";

        $sql = "SELECT
        a.IdViatico,
        a.NEmpleado,
        (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
        IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
        a.SalidaFecha,
        a.RegresoFecha,
        a.estatus,
        e.dpto,
				cg.IdDireccion
        FROM
            viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
						inner join cat_gerarquia as cg on cg.id=e.dpto
        WHERE
            Activa=1 and ((estatus!= 0  and estatus!= 9 ) and (cg.IdDireccion='".$nitavu_dir."' or cg.id='".$nitavu_dir."'))
        ORDER BY
        a.IdViatico desc";
        
            //PERSONAL DE LA DELEGACION
     if ( EstoyenDelegacion($nitavu) =='del'){
        $sql = "SELECT
        a.IdViatico,
        a.NEmpleado,
        (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
        IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
        a.SalidaFecha,
        a.RegresoFecha,
        a.estatus,
        e.dpto,
				cg.IdDireccion
        FROM
            viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
						inner join cat_gerarquia as cg on cg.id=e.dpto
        WHERE
      
            Activa=1 and (estatus!= 0  and estatus!= 9 ) and e.dpto='". nitavu_dpto($nitavu)."'
        ORDER BY
        a.IdViatico desc";
        }  
     }


     //PERSONAL DE VIATICOS
         if( $nivel==2)
         {
            $sql = "SELECT
            a.IdViatico,
            a.NEmpleado,
            (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
            IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
            a.SalidaFecha,
            a.RegresoFecha,
            a.estatus,
            e.dpto,
                    cg.IdDireccion
            FROM
                viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
                            inner join cat_gerarquia as cg on cg.id=e.dpto
            WHERE
                Activa=1 and (estatus!= 0  and estatus!= 9 and estatus!= 10) 
            ORDER BY
            a.IdViatico  desc";
       
         } 
        //VOBO ADMON
        else if($nivel==3 )
        { 
        $sql = "SELECT
        a.IdViatico,
        a.NEmpleado,
        (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
        IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
        a.SalidaFecha,
        a.RegresoFecha,
        a.estatus,
        e.dpto,
				cg.IdDireccion
        FROM
            viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
						inner join cat_gerarquia as cg on cg.id=e.dpto
        WHERE
            Activa=1 and (estatus=3 OR ((estatus!= 0  and estatus!= 9 )and (cg.IdDireccion='".$nitavu_dir."' or cg.id='".$nitavu_dir."')) )  
        ORDER BY
        a.IdViatico desc";
         }//VOBO RECURSOS FINANCIEROS
        else if($nivel==4 )
        {
            $sql = "SELECT
            a.IdViatico,
            a.NEmpleado,
            (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
            IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
            a.SalidaFecha,
            a.RegresoFecha,
            a.estatus,
            e.dpto,
                    cg.IdDireccion
            FROM
                viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
                            inner join cat_gerarquia as cg on cg.id=e.dpto
            WHERE
                Activa=1 and (estatus=4 or( (estatus!= 0  and estatus!= 9 )and (cg.IdDireccion='".$nitavu_dir."' or cg.id='".$nitavu_dir."')))
            ORDER BY
            a.IdViatico desc";
        }
 

        //VOBO COMISARIA
       else if($nivel==5 )
        {
            $sql = "SELECT
            a.IdViatico,
            a.NEmpleado,
            (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
            IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
            a.SalidaFecha,
            a.RegresoFecha,
            a.estatus,
            e.dpto,
                    cg.IdDireccion
            FROM
                viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
                            inner join cat_gerarquia as cg on cg.id=e.dpto
            WHERE
                Activa=1 and ((estatus=2 or estatus=6) )
            ORDER BY
            a.IdViatico desc";
        }


// VOBO COORDINACION

        if( $nivel==6)
         {
            $sql = "SELECT
            a.IdViatico,
            a.NEmpleado,
            (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
            IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
            a.SalidaFecha,
            a.RegresoFecha,
            a.estatus,
            e.dpto,
                    cg.IdDireccion
            FROM
                viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
                            inner join cat_gerarquia as cg on cg.id=e.dpto
            WHERE
                Activa=1 -- and ((estatus= 10 or estatus= 1)  and cg.IdDireccion='".$nitavu_dir."') 
              and (estatus= 1 or estatus=10) and (cg.IdDireccion=19 and  cg.IdDireccion=1) or (cg.IdDireccion=19 )
            ORDER BY
            a.IdViatico";
       
         } 

       //echo $nivel;
       // echo $sql;

        $r= $conexion -> query($sql); 

           
        echo '<table class="tabla" style="font-size:9pt;"">';
        echo "<th style='color: black; background-color: #ddc9a3; height:30px;text-align: center;'>Num.Viático</center></th>";
        echo "<th style='color: black; background-color: #ddc9a3; height:30px;text-align: center;'>Empleado</th>";
        echo "<th style='color: black; background-color: #ddc9a3; height:30px;text-align: center;'>Ruta</center></th>";
        echo "<th style='color: black; background-color: #ddc9a3; height:30px;text-align: center;'>Fechas</center></th>";  
        echo "<th style='color: black; background-color: #ddc9a3; height:30px;text-align: center;'>Estatus</center></th>";  
        echo "<th style='color: black; background-color: #ddc9a3; height:30px;text-align: center;'>Seguimiento</center></th>";  
        echo "<th style='color: black; background-color: #ddc9a3; height:30px;text-align: center;'>Acciones</center></th>";  
        
        while($f = $r -> fetch_array()) {
            echo "<tr>";
            echo "<td><center>";
            echo "<a class='btn btn-danger' style='border-color: #c1c1c1;background-color: #ab0033;color: white; box-shadow:0 3px  #c1c1c1; width:80%;' href='?new=".$f['NEmpleado']."&IdViatico=".$f['IdViatico']."'>";
            echo $f['IdViatico']."</center></a>";
            echo "</td>";
            echo "<td width=50%>".$f['Empleado']."</td>";
            echo "<td >".$f['Ruta']."</td>";
            if ($f['SalidaFecha']=='0000-00-00'){
                echo "<td>Sin definir</td>";
            } else {
                //echo "<td><center>Salida:".$f['SalidaFecha']." - ".$f['RegresoFecha']."</center></td>";
                echo "<td><center>Salida:".date_format(date_create($f['SalidaFecha']), 'd-M-y')." - ".date_format(date_create($f['RegresoFecha']), 'd-M-y')."</center></td>";
                //date_format(date_create($f['FechaInicio']), 'd-m-y')
            }
            //if ($f['estatus']=='1' or $f['estatus']=='11'){
            if ($f['estatus']=='1'){
                echo "<td>En Tramite";
                if( $nivel=='2')
                {
                    echo '<img src="icon/alerta_roja.png" style="width:18px" title="Viatico que requiere VoBO.">';
                }
                echo "</td>";
            } else if ($f['estatus']=='2'){
                echo "<td>VoBo Viáticos</td>";
            } else if ($f['estatus']=='3'){
                echo "<td>Impreso";
                if( $nivel=='3')
                {
                    echo '<img src="icon/alerta_roja.png" style="width:18px" title="Viatico que requiere VoBO.">';
                }
                echo "</td>";
            }else if ($f['estatus']=='4'){
                echo "<td>Firmado";
                if( $nivel=='4')
                {
                    echo '<img src="icon/alerta_roja.png" style="width:18px" title="Viatico que requiere ser pagado.">';
                }
                echo "</td>";
            }else if ($f['estatus']=='5'){
                echo "<td>Viatico Pagado</td>";
            }else if ($f['estatus']=='6'){
                echo "<td>Comprobado</td>";
            }else if ($f['estatus']=='7'){
                echo "<td>VoBo Comisaría</td>";
            }else if ($f['estatus']=='8'){
                echo "<td style=' color: #f50202; font-weight: bold;'> Sin Presupuesto</td>";
            }else if ($f['estatus']=='9'){
                echo "<td style=' color: #f50202; font-weight: bold;'> Cancelado</td>";
            }
           else if ($f['estatus']=='10'){
                echo "<td style=' color: blue; font-weight: bold;'> En Espera de VoBo</td>";
            }
            else if ($f['estatus']=='11'){
                echo "<td style=' color: #f50202; font-weight: bold;'> No Comprobado</td>";
            }

        

                 // //7.- Se valida que exista un presupuesto para crear el viatico
                 $iddireccion=quienEsmiDireccion(nitavu_dpto($f['NEmpleado']));
                // echo $iddireccion,"echoo";
                  $presupuestodispible=ExistePresupuestoViatico(  $iddireccion);
                  $Total= totalGastosFull($f['IdViatico']);
                //  echo $Total."total";
                 //echo $presupuestodispible."presupuesto";
                  if($Total>$presupuestodispible and ($f['estatus']==0 or $f['estatus']==1 ))             
                 {     $Go = FALSE;
                    
                     $sql3="UPDATE viaticos SET estatus=8 WHERE IdViatico='".$f['IdViatico']."'";
                     //echo $sql3;
                 
                     if ($conexion->query($sql3) == TRUE) {
                     //    Toast("No Existe Presupuesto ",5,"");
                         ///return;
                        // echo "No Existe Presupuesto ";
                     }
                 
                 }
                // echo "<td> ".$Total."--".$presupuestodispible ."</td>";
             echo "<td><center>";
       
             echo "<a href='#modalHistorial".$f['IdViatico']."' rel='MyModal:open' style='font-size:11px;'>";
             echo "<img src='icon/seguimiento.png' style='width:35px; padding:5px; '> </center>";
             echo "</a>";
            //              /*MODAL   HISTORIAL*/
                          echo "<div id='modalHistorial".$f['IdViatico']."' class='MyModal' >"; 
                          echo '<h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt; color: #ab0033;"><i class="fa-solid fa-clipboard-list"></i>   '.$f['IdViatico'].' | <i class="fa-solid fa-id-card-clip"></i>   '.$f['Empleado'].' '.$f['Ruta'].'</h1><br>';
                            echo '<table class="tabla_punteada tabla"  align="center" style="font-size: 12; vertical-align: middle; ">
                         <thead>
                         <tr  align="center" style=" bacKground:#E75F54; color:black;">                   
                             <th style="width:10%; background: #ddc9a3; color:black; height:30px;" >Id</th>
                             <th  style=" vertical-align: middle; width:10%; background: #ddc9a3; color:black; height:30px;">Fecha</th>
                             <th style = "background: #ddc9a3; color:black; height:30px;">Empleado</th>   
                             <th style = "background: #ddc9a3; color:black; height:30px;" colspan="2">Estatus</th>   
                            
                             <th style = "background: #ddc9a3; color:black; height:30px; height:30px;">Comentario</th>          
                        </tr>
                         </thead>
                         <tbody>';
                         $sql2=" Select * from viaticosseguimiento where IdViatico=".$f['IdViatico']."";
                    //echo $sql2;
                         $r2= $conexion -> query($sql2);                         
                          while($fx = $r2 -> fetch_array()) 
                         {
                             echo ' <tr>';    
                             echo ' <td><center>'.$fx["IdSegViatico"] .'</center></td>';                           
                             echo ' <td><center>'.date_format(date_create($fx["FechaCrea"]), 'd/m/Y').'</center></td>';
                             echo ' <td>'.nitavu_nombre($fx["NitavuCrea"]) .'</td>';
                            if ($fx['IdEstatus']=='0'){
                                echo "<td>Creado</td><td ></td> ";                            }
                            else if ($fx['IdEstatus']=='1'){
                                echo "<td>En Tramite</td><td ></td> ";
                            } else if ($fx['IdEstatus']=='2'){
                                echo "<td>VoBo Viáticos</td><td ></td> ";
                            } 
                            else if ($fx['IdEstatus']=='3'){
                                echo "<td>Impreso </td>";
                                echo '<td style="width: 120px;"><a  style ="margin-right: 5px;" class="btn btn-secondary" href=Viaticos_Formato.php?id='.$f['IdViatico'].' title="Formato Viaticos"><img src="icon/pdf.png" style="width:18px;>"</a>';
                                echo '<a  class="btn btn-secondary" href=oficio_viaticos.php?id='.$f['IdViatico'].' title="Oficio Viaticos"><img src="icon/pdf.png" style="width:18px;>"</a></td>';
                            }else if ($fx['IdEstatus']=='4'){
                                echo "<td>Firmado</td> <td ></td> ";
                            }else if ($fx['IdEstatus']=='5'){
                                echo "<td>Pagar Viactico</td><td ></td> ";
                            }else if ($fx['IdEstatus']=='6'){
                                echo "<td>Comprobado</td> ";
                                echo '<td style="width: 10px;"><a  class="btn btn-success" href=viaticos_exp.php?id='. $f['IdViatico']. '><img src="icon/folder-1.png" style="width:18px"></a></td>';
                            }else if ($fx['IdEstatus']=='7'){
                                echo "<td>VoBo Comisaría</td><td ></td> ";
                            }else if ($fx['IdEstatus']=='9'){
                                echo "<td>Cancelado</td> ";
                                echo '<td style="width: 10px;"><a  class="btn btn-success" href=viaticos_exp.php?id='. $f['IdViatico']. '><img src="icon/folder-1.png" style="width:18px"></a></td>';
                            }
                
                            else if ($fx['IdEstatus']=='10'){
                                // echo "<td>Rechazado</td> ";
                                echo '<td >En Espera de VoBo</td>';
                                echo '<td ></td>';
                            } else if ($fx['IdEstatus']=='11'){
                                // echo "<td>Rechazado</td> ";
                            
                                 echo '<td >VoBo Jefe Inmediato</td>';
                                echo '<td ></td>';
                            }
                             echo ' <td>'.$fx["Observaciones"] .'</td>';        
                         
                             echo ' </tr>';
                         }
            //              echo '</td>';
            //              echo '</tr>';
                           
                            echo '</tbody>
                            </table>';
                            echo "</div>"; 
              
            echo "</td>";
            
            if ($f['estatus']==11 or $f['estatus']==9 or   $f['estatus']==6){
                echo "<td style='vertical-align: middle;text-align:center; '><a class='pc'  href='viaticos.php?ArchivarId=".$f['IdViatico']."'   title='Archivar la viatico'>";
                 echo "<img src='icon/ci.png' style='width:35px; padding:5px;'></a></td>";
            }
            if (  $f['estatus']==5){
                echo "<td style='vertical-align: middle; text-align:center;'><a class='pc'  href='viaticosevidencia.php?id=".$f['IdViatico']."'   title='Subir Evidencia'>";
                 echo "<img src='icon/upload-to-cloud.png' style='width:35px; padding:5px;'></a></td>";
            }
            else  if ($f['estatus']==8 ){
           
            echo "<td style='vertical-align: middle; text-align:center;'><a class='pc'  href='viaticos.php?ReactivarId=".$f['IdViatico']."'   title='Reactivar viatico'>";
            echo "<img src='icon/renovar.png' style='width:35px; padding:5px;'></a></td>";

            // echo ' <td style="text-align:center;">';
            // echo "<a  title='Cancelar Viatico' href='viaticos_preliminares.php?idviatico=".$f['IdViatico']."&del'>";                    
            // echo "<img src='icon/eliminar.png' style='width:35px; padding:5px; '>";
            // echo "</td>";
               }


              
           
               else  if ($f['estatus']!=6 and  $f['estatus']!=9){   
    
                echo ' <td style="text-align:center;">';
                echo "<a  title='Cancelar Viatico' href='viaticos_preliminares.php?idviatico=".$f['IdViatico']."&del'>";                    
                echo "<img src='icon/eliminar.png' style='width:35px; padding:5px; '>";
                echo "</td>";
            }
            echo "</tr>";
             
        }
        echo "</table>";
        unset($r,$f,$sql);
        echo "</div>";


        
       


    }
// <button type="button" class="close" data-dismiss="modal">
            //     <span aria-hidden="true">×</span>
            //     <span class="sr-only">Close</span>
            // </button>
    echo "<div id='modalObservaciones' class='MyModal' style='height: 50%;'>";
    echo '<div class="modal-header" style="background:#dc3545;">
            <h4 class="modal-title" id="myModalLabel">'.$titulo.'</h4>
        </div>
        
        <!-- Modal Body -->
        <div class="modal-body">           
            <form role="form" >
                <div style="width:80%; font-family:Compacta;">
                    <label for="inputName"><b>'.$mensaje.'</b></label>    <br>  
                    <div style="width:60%;">  
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" style="width: 25px;height: 25px;">
                        <b><label class="form-check-label" for="inlineRadio1">APROBAR </label></b>
                     </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2" style="width: 25px;height: 25px;">
                       <b><label class="form-check-label" for="inlineRadio2" >CANCELAR</label></b>
                    </div>
                    </div>
                  <br>                 
                    <label for="inputMessage">Observaciones:</label>
                    <textarea class="form-control" id="inputMessage" placeholder="" style="height:30%;"></textarea>
                </div>
            </form>
        </div>
        
        <!-- Modal Footer -->
        <div class="modal-footer">           
            <button type="button" class="Mbtn btn-danger" onclick="Guardar2('. $opcion.')">Guardar</button>          
            <a  rel="MyModal:close" class="cerrar-modal Mbtn btn-Gray" style ="text-decoration: unset;height: auto;width: auto;">Cerrar</a>
            
        </div>
    
';

echo "<div id='modalObservaciones2' class='MyModal' style='height: 50%;'>";
echo '<div class="modal-header" style="background:#dc3545;">
        <h4 class="modal-title" id="myModalLabel">Comprobación del viático -Cancelación</h4>
    </div>
    
    <!-- Modal Body -->
    <div class="modal-body">           
        <form role="form" >
            <div style="width:80%; font-family:Compacta;">
                <label for="inputName"><b>Está apunto de marcar que el viático se cancelo y ah sido comprobado exitosamente por el empleado, ¿Que desea hacer?</b></label>    <br>  
                <div style="width:60%;">  
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" style="width: 25px;height: 25px;">
                    <label class="form-check-label" for="inlineRadio1">APROBAR </label>
                 </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2" style="width: 25px;height: 25px;">
                    <label class="form-check-label" for="inlineRadio2" >CANCELAR</label>
                </div>
                </div>
              <br>                 
                <label for="inputMessage">Observaciones:</label>
                <textarea class="form-control" id="inputMessage" placeholder="" style="height:30%;"></textarea>
            </div>
        </form>
    </div>
    
    <!-- Modal Footer -->
    <div class="modal-footer">           
        <button type="button" class="Mbtn btn-danger" onclick="Guardar2(9)">Guardar</button>          
        <a  rel="MyModal:close" class="cerrar-modal Mbtn btn-Gray" style ="text-decoration: unset;height: auto;width: auto;">Cerrar</a>
        
    </div>

';
echo "<div>";
    // //--REVISAR SI YA HAY PRESUPUESTO
    if(isset($_GET['ReactivarId'])){
        $id = $_GET['ReactivarId'];           
    
      // //7.- Se valida que exista un presupuesto para crear el viatico
    $NEmpleado= viaticos_NEmpleado($id);
    $iddireccion=quienEsmiDireccion(nitavu_dpto($NEmpleado));
    //echo $iddireccion,"echoo";
    $presupuestodispible=ExistePresupuestoViatico($iddireccion);
    $Total= totalGastosFull( $id);
      //echo $Total."total";
     //echo $presupuestodispible."presupuesto";
    if($presupuestodispible>$Total)
    {
        $sql3="UPDATE viaticos SET estatus=1 WHERE IdViatico='". $id."'";
       // echo $sql3;
    
        if ($conexion->query($sql3) == TRUE){ 
            mensaje('Se ha verificado el Viatico '.$id.', ¡Existe presupuesto disponible!','viaticos.php');
        }else{
            mensaje('Ocurrio un error al verificar el viatico, favor de intentarlo nuevamente.','viaticos.php');
        } 
    
    }else
    {
        mensaje('Se ha verificado el Viatico '.$id.', ¡Pero no existe presupuesto disponible!','viaticos.php');
    }
    }
    

      // //--Archivar viatico
    if(isset($_GET['ArchivarId'])){
        $id = $_GET['ArchivarId'];           
    
        $sql4="UPDATE viaticos SET Activa=0 WHERE IdViatico='". $id."'";
       // echo $sql3;
    
        if ($conexion->query($sql4) == TRUE){ 
            mensaje('Se ha archivado el Viatico '.$id.', de manera exitosa','viaticos.php');
        }else{
            mensaje('Ocurrio un error al archivar el viatico, favor de intentarlo nuevamente.','viaticos.php');
        } 
    
    
    }
    
    
    
    
       
    
    

}
else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 


?>





<script>
 function BuscarEmpleado(){
		txtq = $("#SearchEmpleado").val();
        
        console.log("buscando " + txtq);
        $('#preloader').show();

            $.ajax({
                url: "viaticos_buscarempleado.php",
            type: "get",        
            data: {q: txtq},
            success: function(data){
                $("#Resultado").html(data+"\n");            
                $('#preloader').hide();
            }
            });
}


function Guardar( Status){

 
    NOficio = $("#NOficio").val();
    FechaSalida = $('#FechaSalida').val();
    HoraSalida = $('#HoraSalida').val();
    FechaRegreso = $('#FechaRegreso').val();
    HoraRegreso = $('#HoraRegreso').val();
    IdHospedaje = $('#IdHospedaje').val();
    Comision = $('#Comision').val();

    Recorrido_Excedente = $('#recorridoExcedente').val();  
    JefeInmediato = $('#jefeinmediato').val();
    IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
    NEmpleado = "<?php if (isset($NEmpleado)){echo $NEmpleado;} else {}?>";
    
    IdTipoTransporteR="";
    TipoTransporteR="";
    MarcaR="";
    PlacasR="";
    ModeloR=""; 
    TipoR="";
    CilindrosR="";
    IdVehiculoOficialR="";
    Veh_TransporteR="";
    Veh_TransporteGastoR="";

       

/*************** RETORNO  **************/
    
    IdTipoTransporteR = $('#idtipotransporteR').val();
      
    if(IdTipoTransporteR==0 || IdTipoTransporteR==1)
    {
        
        $("#checkTipoVehiculo_particularR").prop("checked",false);   
        $("#checkTipoVehiculo_publicoR").prop("checked",false);   
        $("#checkTipoVehiculo_oficialR").prop("checked",false); 
    }

    if ($("#checkTipoVehiculo_particularR").prop("checked")==true){
        
        TipoTransporteR="";
        MarcaR="";
        PlacasR="";
        ModeloR=""; 
        TipoR="";
        CilindrosR="";
        IdVehiculoOficialR="";
        Veh_TransporteR="";
        Veh_TransporteGastoR="";

        TipoTransporteR="PARTICULAR";
        MarcaR = $('#Veh_MarcaR').val();
        PlacasR = $('#Veh_PlacasR').val();
        ModeloR = $('#Veh_ModeloR').val();
        TipoR = $('#Veh_TipoR').val();
        CilindrosR = $('#Veh_CilindrosR').val();
       

    } 

    else if ($("#checkTipoVehiculo_oficialR").prop("checked")==true){      

        TipoTransporteR="";
        MarcaR="";
        PlacasR="";
        ModeloR=""; 
        TipoR="";
        CilindrosR="";
        IdVehiculoOficialR="";
        Veh_TransporteR="";
        Veh_TransporteGastoR="";


        TipoTransporteR="OFICIAL";
        IdVehiculoOficialR = $('#IdVehiculoOficialR').val();

        
    } 

    else if ($("#checkTipoVehiculo_publicoR").prop("checked")==true){      

       TipoTransporteR="";
        MarcaR="";
        PlacasR="";
        ModeloR=""; 
        TipoR="";
        CilindrosR="";
        IdVehiculoOficialR="";
        Veh_TransporteR="";
        Veh_TransporteGastoR="";

        TipoTransporteR="PUBLICO";
        Veh_TransporteR = $('#Veh_TrasporteR').val();
        Veh_TransporteGastoR = $('#Veh_TrasporteGastoR').val();
       
        
      
    }
    else
    {

        TipoTransporteR="";
        MarcaR="";
        PlacasR="";
        ModeloR=""; 
        TipoR="";
        CilindrosR="";
        // IdVehiculoOficialR="";
        // Veh_TransporteR="";
        // Veh_TransporteGastoR="";

        console.log("entro44");       
        TipoTransporteR='AEREO';
        if(IdTipoTransporteR==0)
        {
            TipoTransporteR='NINGUNO';
        }else if(IdTipoTransporteR==1)
        {
            TipoTransporteR='AEREO';
            Veh_TransporteR = $('#infaereoR').val();
            Veh_TransporteGastoR = $('#infgastoR').val();
        }


      
    } 
        ////******************************************************* */
      
    IdTipoTransporte = $('#idtipotransporte').val();   
    if(IdTipoTransporte==0 || IdTipoTransporte==1)
    {
        
        $("#checkTipoVehiculo_particular").prop("checked",false);   
        $("#checkTipoVehiculo_publico").prop("checked",false);   
        $("#checkTipoVehiculo_oficial").prop("checked",false); 
    }

    if ($("#checkTipoVehiculo_particular").prop("checked")==true){
        console.log("entro3");
        TipoTransporte="PARTICULAR";
        Marca = $('#Veh_Marca').val();
        Placas = $('#Veh_Placas').val();
        Modelo = $('#Veh_Modelo').val();
        Tipo = $('#Veh_Tipo').val();
        Cilindros = $('#Veh_Cilindros').val();
        $('#preloader').show();
        $.ajax({
                url: "viaticos_dat_guardar.php",
            type: "post",        
            data: {IdViatico:IdViatico, NEmpleado:NEmpleado,NOficio:NOficio, FechaSalida:FechaSalida, HoraSalida:HoraSalida,FechaRegreso:FechaRegreso, HoraRegreso:HoraRegreso, IdHospedaje:IdHospedaje, Comision:Comision,
            TipoTransporte:TipoTransporte, Status:Status,
            Marca:Marca, Placas:Placas, Modelo:Modelo, Tipo:Tipo,Cilindros:Cilindros,IdTipoTransporte:IdTipoTransporte,         
            IdTipoTransporteR:IdTipoTransporteR,TipoTransporteR:TipoTransporteR,
            MarcaR:MarcaR, PlacasR:PlacasR,ModeloR:ModeloR, TipoR:TipoR,CilindrosR:CilindrosR,
            IdVehiculoOficialR:IdVehiculoOficialR,Veh_TransporteR:Veh_TransporteR,Veh_TransporteGastoR:Veh_TransporteGastoR,JefeInmediato:JefeInmediato,
            RecorridoExcedente : Recorrido_Excedente

        
            },
            success: function(data){
            console.log(data);              
            if(data.includes('exito')==true)                            
            {  CrearGastos();              
                  if(Status==0)
                  {
                    window.location.href = "viaticos.php?new="+NEmpleado+"&IdViatico="+IdViatico;
                  }else{
                    window.location.href = "viaticos.php"; 
                  }
            }
            else
            { console.log('incompleto1'); 

            $("#R").html(data+"\n");            
                $('#preloader').hide();
              window.location.href = "viaticos.php?new="+NEmpleado+"&IdViatico="+IdViatico;
            }
            }
            });

    } 

    else if ($("#checkTipoVehiculo_oficial").prop("checked")==true){
      
        Marca = "";
        Placas = "";
        Modelo = "";
        Tipo = "";
        Cilindros = "";
        console.log("entro2");
        TipoTransporte="OFICIAL";
        IdVehiculoOficial = $('#IdVehiculoOficial').val();
        IdVehiculoOficialR = $('#IdVehiculoOficialR').val();
        $('#preloader').show();
        $.ajax({
                url: "viaticos_dat_guardar.php",
            type: "post",        
            data: {IdViatico:IdViatico, NEmpleado:NEmpleado,NOficio:NOficio, FechaSalida:FechaSalida, HoraSalida:HoraSalida,FechaRegreso:FechaRegreso,
                    HoraRegreso:HoraRegreso, Comision:Comision,
                    TipoTransporte:TipoTransporte,Status:Status,    IdVehiculoOficial:IdVehiculoOficial,IdTipoTransporte:IdTipoTransporte,
                    IdTipoTransporteR:IdTipoTransporteR,TipoTransporteR:TipoTransporteR,
                    MarcaR:MarcaR, PlacasR:PlacasR,ModeloR:ModeloR, TipoR:TipoR,CilindrosR:CilindrosR,
                    IdVehiculoOficialR:IdVehiculoOficialR,Veh_TransporteR:Veh_TransporteR,Veh_TransporteGastoR:Veh_TransporteGastoR,JefeInmediato:JefeInmediato, RecorridoExcedente : Recorrido_Excedente
            },
            success: function(data){
               console.log(data);
            if(data.includes('exito')==true)                            
            {  
                  if(Status==0)
                  {
                    window.location.href = "viaticos.php?new="+NEmpleado+"&IdViatico="+IdViatico;
                  }else{
                    window.location.href = "viaticos.php"; 
                  }
            }
            else
            { console.log('incompleto2');
                $("#R").html(data+"\n");            
                $('#preloader').hide();
                window.location.href = "viaticos.php?new="+NEmpleado+"&IdViatico="+IdViatico;
            } 
            }
            });
    } 

    else if ($("#checkTipoVehiculo_publico").prop("checked")==true){
        console.log("entro3");
       
        TipoTransporte="PUBLICO";
        Veh_Transporte = $('#Veh_Trasporte').val();
        Veh_TransporteGasto = $('#Veh_TrasporteGasto').val();
        $('#preloader').show();
        $.ajax({
                url: "viaticos_dat_guardar.php",
            type: "post",        
            data: {IdViatico:IdViatico, NEmpleado:NEmpleado,NOficio:NOficio, FechaSalida:FechaSalida, HoraSalida:HoraSalida,FechaRegreso:FechaRegreso, HoraRegreso:HoraRegreso, IdHospedaje:IdHospedaje, Comision:Comision,
            TipoTransporte:TipoTransporte,Status:Status,
            Veh_Transporte:Veh_Transporte, Veh_TransporteGasto:Veh_TransporteGasto,IdTipoTransporte:IdTipoTransporte,
            IdTipoTransporteR:IdTipoTransporteR,TipoTransporteR:TipoTransporteR,
            MarcaR:MarcaR, PlacasR:PlacasR,ModeloR:ModeloR, TipoR:TipoR,CilindrosR:CilindrosR,
            IdVehiculoOficialR:IdVehiculoOficialR,Veh_TransporteR:Veh_TransporteR,Veh_TransporteGastoR:Veh_TransporteGastoR,JefeInmediato:JefeInmediato, RecorridoExcedente : Recorrido_Excedente
            },
            success: function(data){
            console.log(data); 
            if(data.includes('exito')==true)                            
            {  CrearGastos();
                //alert(Status);
                  if(Status==0)
                  {
                    window.location.href = "viaticos.php?new="+NEmpleado+"&IdViatico="+IdViatico;
                    window.location.href = "viaticos.php"; 
                  } 
             }
            else
            { console.log('incompleto3');
                $("#R").html(data+"\n");            
                $('#preloader').hide();
                window.location.href = "viaticos.php?new="+NEmpleado+"&IdViatico="+IdViatico;
            }
            }
            });
    }
    else
    {
       
        console.log( Recorrido_Excedente );   
        console.log("entro4");       
        TipoTransporte='AEREO';
        if(IdTipoTransporte==0)
        {
            TipoTransporte='NINGUNO';
        }else if(IdTipoTransporte==1)
        {
            TipoTransporte='AEREO';
        }


        Marca = "";
        Placas = "";
        Modelo = "";
        Tipo = "";
        Cilindros = "";
        Veh_Transporte = $('#infaereo').val();
        Veh_TransporteGasto = $('#infgasto').val();
       
        $('#preloader').show();
        $.ajax({
                url: "viaticos_dat_guardar.php",
            type: "post",        
            data: {IdViatico:IdViatico, NEmpleado:NEmpleado,NOficio:NOficio, FechaSalida:FechaSalida, HoraSalida:HoraSalida,FechaRegreso:FechaRegreso, HoraRegreso:HoraRegreso, IdHospedaje:IdHospedaje, Comision:Comision,
            TipoTransporte:TipoTransporte,Status:Status,
            Veh_Transporte:Veh_Transporte, Veh_TransporteGasto:Veh_TransporteGasto,IdTipoTransporte:IdTipoTransporte,
            IdTipoTransporteR:IdTipoTransporteR,TipoTransporteR:TipoTransporteR,
            MarcaR:MarcaR, PlacasR:PlacasR,ModeloR:ModeloR, TipoR:TipoR,CilindrosR:CilindrosR,
            IdVehiculoOficialR:IdVehiculoOficialR,Veh_TransporteR:Veh_TransporteR,Veh_TransporteGastoR:Veh_TransporteGastoR,JefeInmediato:JefeInmediato, RecorridoExcedente : Recorrido_Excedente
            
            },
            success: function(data){
                console.log(data); 
            if(data.includes('exito')==true)                            
            {  CrearGastos();
               
                  if(Status==0)
                  {
                    window.location.href = "viaticos.php?new="+NEmpleado+"&IdViatico="+IdViatico;
                  }else{
                    window.location.href = "viaticos.php"; 
                  }
             }
            else
            { console.log('incompleto4');
                $("#R").html(data+"\n");            
                $('#preloader').hide();
                window.location.href = "viaticos.php?new="+NEmpleado+"&IdViatico="+IdViatico;
            }
            }
            });
    } 
        
        /****************************************************************************************** */


        

           
}
function MostrarFormatos(){
  
                
                // link='viaticos_Formato.php?id='+IdViatico;
                // link2='oficio_viaticos.php?id='+IdViatico;
                
                // window.open(link, '_blank');
               // window.open(link2, '_blank');
               document.getElementById("viaticosformato").click();
                document.getElementById("oficioformato").click();
              
       
}


function Guardar2(Status){

 

IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
NEmpleado = "<?php if (isset($NEmpleado)){echo $NEmpleado;} else {}?>";
// TipoTransporte="";
// Status = $('#Status').val();
// Status=Status;
var elementos = document.getElementsByName("inlineRadioOptions");


// 0-CREADO,
// 1-GENERADO,
// 2-VOBO VIATICOS
// 3-IMPRESO
// 4-FIRMAS
// 5-PAGADO
// 6-COMPROBACION
// 7-VOBO DE COMISIARIA
// 8-VIATICO SIN PRESUPUESTO
// 9-CANCELADO
EstatusAntes="";

if(Status==2)
{
    EstatusAntes='VoBo Viaticos: Cancelado';
}
else if(Status==4)
{
    EstatusAntes='Firmas: Cancelado';
}
else if(Status==5)
{
    EstatusAntes='Viatico Pagado: Cancelado';
}
else if(Status==7)
{
    EstatusAntes='Comprobacion del Viatico Comisaria: Cancelado';
}
else if(Status==6)
{
    EstatusAntes='Comprobacion del Viatico: Cancelado';
}
else if(Status==9)
{
    EstatusAntes='Viatico Cancelado: Cancelado';
}
observaciones = $('#inputMessage').val();

if (Status!=3)
{
    
        if($("#inlineRadio1").is(':checked') || $("#inlineRadio2").is(':checked')) {  

        } else {  
            Swal.fire({
                                                            icon: 'error',
                                                            title: 'ERROR',
                                                            text: 'No ha seleccionado una opción ',
                                                            timer: 1500,
                                                            footer: '<a>Verifique los datos y vuelva a intentarlo</a>'
                                                        });  
                                                        return;
        }  
}

//alert(Status)
for(var i=0; i<elementos.length; i++) {
    if(elementos[i].checked==true  && elementos[i].value==2 )
    {
        //Status=9;
        if(Status==6)
        {
            Status=11;
        }else{
            Status=9; 
        }
        
        observaciones=EstatusAntes+" - "+observaciones;
    }
  
}



    $('#preloader').show();
    $.ajax({
            url: "viaticos_dat_guardar_seg.php",
        type: "post",        
        data: {IdViatico:IdViatico, NEmpleado:NEmpleado,Estatus:Status, Observaciones:observaciones
    
        },
        success: function(data){
     //     console.log(data);              
        if(data.includes('exito')==true)                            
        {  
           
            if(Status==3)
            {
                
                // link='viaticos_Formato.php?id='+IdViatico;
                // link2='oficio_viaticos.php?id='+IdViatico;
                
                // window.open(link, '_blank');
               // window.open(link2, '_blank');
               document.getElementById("viaticosformato").click();
                document.getElementById("oficioformato").click();
          
              
            }
            window.location.href = "viaticos.php"; 
        }
        else
        { console.log('incompleto');} 

        $("#R").html(data+"\n");            
            $('#preloader').hide();
        }
        });




       
}

function RecorridosList(){
		
    IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_dat_recorridoslist.php",
            type: "get",        
            data: {IdViatico:IdViatico},
            success: function(data){
                $("#RecorridosList").html(data+"");                            
                // $("#Resultado").html(data+"");                            
                $('#progressbar').hide();
            }
            });

           
}


function Distance(){
		
        Origen = $('#LugarOrigen').val();
        Destino = $('#LugarDestino').val();
        
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_dat_distance.php",
            type: "get",        
            data: {Origen:Origen,Destino:Destino},
            success: function(data){
                $("#R").html(data+"");                            
                // $("#Resultado").html(data+"");                            
                $('#progressbar').hide();
                viaticosResumen();
            }
            });

           
	}




function Lats(){
		
        Origen = $('#LugarOrigen').val();
        Destino = $('#LugarDestino').val();

        Destino  = $('#LugarDestino option:selected').text();     

        Distancia = $('#Distancia').val();
        RecorridoInterno= $('#RecorridoInterno').val();
        var checkBox = document.getElementById('viajeredondo');
        viajeredondo=0;
        if (checkBox.checked == true){
            viajeredondo=1;   }
            else{  viajeredondo=0;  }

  
        
        IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
        id= $('#id').val();
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_dat_lats.php",
            type: "post",        
            data: {Origen:Origen,Destino:Destino, IdViatico:IdViatico, Distancia:Distancia,RecorridoInterno:RecorridoInterno,id,viajeredondo:viajeredondo},
            success: function(data){
                console.log(data);
                $("#RecorridosList").html(data+"");       
                Maping();                     
                $('#progressbar').hide();
            }
            });

            Maping();
}



function del(IdRecorrido){
    IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
        
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_dat_recorridodel.php",
            type: "post",        
            data: {IdRecorrido:IdRecorrido, IdViatico:IdViatico},
            success: function(data){                
                $("#R").html(data+"");       
                RecorridosList();
                $('#progressbar').hide();
                viaticosResumen();
            }
            });

            
}

    
function Maping() {

    IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
    NEmpleado = "<?php if (isset($NEmpleado)){echo $NEmpleado;} else {}?>";
    
        
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_maping.php",
            type: "post",        
            data: {IdViatico:IdViatico, NEmpleado:NEmpleado},
            success: function(data){
                
                $("#R").html(data+"");                       
                $('#progressbar').hide();
            }
            });

  


}
Maping();


function UpdateLugar() {
        Origen = $('#LugarOrigen').val();
        Destino = $('#LugarDestino').val();
        // Distancia = $('#Distancia').val();
    
    $('#progressbar').show();

        $.ajax({
            url: "viaticos_datupdatelugar.php",
        type: "post",        
        data: {Destino:Destino, Origen:Origen},
        success: function(data){
            
            $("#R").html(data+"");                       
            $('#progressbar').hide();
            viaticosResumen();
        }
        });






}



function voltear() {
    
    $('#progressbar').show();

        Origen = $('#LugarOrigen').val();
        Destino = $('#LugarDestino').val();
        $('#LugarOrigen').val(Destino);
        $('#LugarDestino').val(Origen);
        
    
    $('#progressbar').hide();


}

function CrearGastos(){		
        IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
        FechaSalida = $('#FechaSalida').val();
        HoraSalida = $('#HoraSalida').val();
        FechaRegreso = $('#FechaRegreso').val();
        HoraRegreso = $('#HoraRegreso').val();
        console.log("Entor a crear el gasto");
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_dat_creargastos.php",
            type: "post",        
            data: {IdViatico:IdViatico, FechaSalida:FechaSalida, FechaRegreso:FechaRegreso},
            success: function(data){
          console.log(data);    
                $("#RGastos").html(data+"");                       
                $('#progressbar').hide();
                viaticosResumen();
            }
            });

            
}




function ReloadGastos(){		
        IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
        
        $('#preloader').show();

            $.ajax({
                url: "viaticos_dat_reloadgastos.php",
            type: "post",        
            data: {IdViatico:IdViatico},
            success: function(data){
                
                $("#RGastos").html(data+"");                       
                $('#preloader').hide();
                viaticosResumen();
            }
            });

            
}


function delGastoAlmuerzo(IdGasto){		    
        IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
        txtComida = 'Almuerzo';
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_dat_delgastos.php",
            type: "post",        
            data: {IdGasto:IdGasto, IdViatico:IdViatico,txtComida:txtComida},
            success: function(data){
                
                $("#R").html(data+"");    
                ReloadGastos();                   
                $('#progressbar').hide();
                viaticosResumen();
            }
            });

            
}

function delGastoComida(IdGasto){		    
        IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
        txtComida = 'Comida';
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_dat_delgastos.php",
            type: "post",        
            data: {IdGasto:IdGasto, IdViatico:IdViatico,txtComida:txtComida},
            success: function(data){
                
                $("#R").html(data+"");    
                ReloadGastos();                   
                $('#progressbar').hide();
                viaticosResumen();
            }
            });

            
}

function delGastoCena(IdGasto){		    
        IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
        txtComida = 'Cena';
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_dat_delgastos.php",
            type: "post",        
            data: {IdGasto:IdGasto, IdViatico:IdViatico,txtComida:txtComida},
            success: function(data){
                
                $("#R").html(data+"");    
                ReloadGastos();                   
                $('#progressbar').hide();
                viaticosResumen();
            }
            });

            
}

function delGastoHospedaje(IdGasto){		    
        IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
        txtComida = 'Hospedaje';
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_dat_delgastos.php",
            type: "post",        
            data: {IdGasto:IdGasto, IdViatico:IdViatico,txtComida:txtComida},
            success: function(data){
                
                $("#R").html(data+"");    
                ReloadGastos();                   
                $('#progressbar').hide();
                viaticosResumen();
            }
            });

            
}

ReloadGastos();



function checkVehiculo(){		    
        IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
        if ($("#checkTipoVehiculo_particular").prop("checked")==true){
            VehMode=2;
        } else {
            if ($("#checkTipoVehiculo_oficial").prop("checked")==true){
                VehMode=1;
            } else {
                if ($("#checkTipoVehiculo_publico").prop("checked")==true){
                    VehMode=3;
                } else {
                    VehMode=1;
                }
            }
        }
        
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_dat_vehiculo.php",
            type: "post",        
            data: {IdViatico:IdViatico,VehMode:VehMode},
            success: function(data){
                //console.log(data);                
                $("#RTraslado").html(data+"");    
                
                $('#progressbar').hide();
                viaticosResumen();
            }
            });

            
}




function checkVehiculoR(){		    
        IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";
        if ($("#checkTipoVehiculo_particularR").prop("checked")==true){
            VehModeR=2;
        } else {
            if ($("#checkTipoVehiculo_oficialR").prop("checked")==true){
                VehModeR=1;
            } else {
                if ($("#checkTipoVehiculo_publicoR").prop("checked")==true){
                    VehModeR=3;
                } else {
                    VehModeR=1;
                }
            }
        }
        
        $('#progressbar').show();

            $.ajax({
                url: "viaticos_dat_vehiculoR.php",
            type: "post",        
            data: {IdViatico:IdViatico,VehModeR:VehModeR},
            success: function(data){
                //console.log(data);                
                $("#RTrasladoR").html(data+"");    
                
                $('#progressbar').hide();
                viaticosResumen();
            }
            });

            
}
checkVehiculo();
checkVehiculoR();

function checkTipoTransporte()
{
   
    if ($("#checkTipoTransporte_ninguno").prop("checked")==true){
        $("#checkTipoTransporte_aereo").prop("checked",false);
        $("#checkTipoTransporte_terrestre").prop("checked",false);       
        $("#terrestre").css("display", "none");
        $("#aereo").css("display", "none");
        $("#idtipotransporte").val(0);
    }
    else if ($("#checkTipoTransporte_aereo").prop("checked")==true){
        $("#checkTipoTransporte_ninguno").prop("checked",false);
        $("#checkTipoTransporte_terrestre").prop("checked",false);
        $("#terrestre").css("display", "none");
         $("#aereo").css("display", "block");
         $("#idtipotransporte").val(1);
    }
    else if ($("#checkTipoTransporte_terrestre").prop("checked")==true){
        $("#checkTipoTransporte_ninguno").prop("checked",false)
        $("#checkTipoTransporte_aereo").prop("checked",false);
        $("#terrestre").css("display", "block");
        $("#aereo").css("display", "none");
        $("#idtipotransporte").val(2);
    }
}


function checkTipoTransporteR()
{
   
    if ($("#checkTipoTransporte_ningunoR").prop("checked")==true){
        $("#checkTipoTransporte_aereoR").prop("checked",false);
        $("#checkTipoTransporte_terrestreR").prop("checked",false);       
        $("#terrestreR").css("display", "none");
        $("#aereoR").css("display", "none");
        $("#idtipotransporteR").val(0);
    
    }
    else if ($("#checkTipoTransporte_aereoR").prop("checked")==true){
        $("#checkTipoTransporte_ningunoR").prop("checked",false);
        $("#checkTipoTransporte_terrestreR").prop("checked",false);
        $("#terrestreR").css("display", "none");
         $("#aereoR").css("display", "block");
         $("#idtipotransporteR").val(1);
         
    }
    else if ($("#checkTipoTransporte_terrestreR").prop("checked")==true){
        $("#checkTipoTransporte_ningunoR").prop("checked",false)
        $("#checkTipoTransporte_aereoR").prop("checked",false);
        $("#terrestreR").css("display", "block");
        $("#aereoR").css("display", "none");
        $("#idtipotransporteR").val(2);
      
    }
}

function viaticosResumen(){		    
        IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";    
          
        $('#progressbar').show();
            $.ajax({
                url: "viaticos_dat_resumengastos.php",
            type: "post",        
            data: {IdViatico:IdViatico},
            success: function(data){                
                $("#ResumenGastos").html(data+"");    
                
                $('#progressbar').hide();
            }
            });

            
}


viaticosResumen();




function AgregarVGextra(){		    
        IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";        
        VGextra_concepto = $('#VGextra_concepto').val();
        VGextra_cantidad = $('#VGextra_cantidad').val();
        $('#progressbar').show();
            $.ajax({
                url: "viaticos_dat_gastoextra_agregar.php",
            type: "post",        
            data: {IdViatico:IdViatico,VGextra_concepto:VGextra_concepto,  VGextra_cantidad:VGextra_cantidad},
            success: function(data){                
                $("#RV").html(data+"");    
                GastosExtrasCargar();
                viaticosResumen();
                $('#progressbar').hide();
            }
            });
            
}



function Cancelar(IdGasto){		    
        IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";        
        
        $('#progressbar').show();
            $.ajax({
                url: "viaticos_dat_gastoextra_cancelar.php",
            type: "post",        
            data: {IdViatico:IdViatico,IdGasto:IdGasto},
            success: function(data){                
                $("#RV").html(data+"");    
                GastosExtrasCargar();
                viaticosResumen();

                $('#progressbar').hide();
            }
            });
            
}



function GastosExtrasCargar(){		    
        IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";        
        
        $('#progressbar').show();
            $.ajax({
                url: "viaticos_dat_gastoextra.php",
            type: "post",        
            data: {IdViatico:IdViatico},
            success: function(data){                
                $("#GastoExtra_lista").html(data+"");    
                
                $('#progressbar').hide();
            }
            });
            
}

function Div_EscaneadoR() {
    IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";        
        
        $('#progressbar').show();
            $.ajax({
                url: "viaticos_dat_escaneado.php",
            type: "post",        
            data: {IdViatico:IdViatico},
            success: function(data){                
                $("#Div_EscaneadoR").html(data+"");                    
                $('#progressbar').hide();
            }
            });

}
Div_EscaneadoR();

function CalculoxDias(idrecorrido)
{
    IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>"; 
        dias = $('#dias'+idrecorrido).val();        
        op="dias";       
        $('#progressbar').show();
            $.ajax({
                url: "viaticos_dat_actualizar.php",
            type: "post",        
            data: {Nodias:dias,Operacion:op,Idrecorrido:idrecorrido, IdViatico: IdViatico},
            success: function(data){                
                $("#RV").html(data+"");    
                
                viaticosResumen();
                $('#progressbar').hide();
            }
            });
            
}



function duermeLugar(idrecorrido) {
  // Get the checkbox
  var checkBox = document.getElementById("check"+idrecorrido);
  // Get the output text

  IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>"; 
  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
    
    dias = 1;   
    op="dormir";   
        $('#progressbar').show();
            $.ajax({
                url: "viaticos_dat_actualizar.php",
            type: "post",        
            data: {Nodias:dias,Operacion:op,Idrecorrido:idrecorrido, IdViatico: IdViatico},          
            success: function(data){    
                console.log(data);            
                $("#RV").html(data+"");    
                
                viaticosResumen();
                $('#progressbar').hide();
            }
            });
            

  } else {
    dias = 0;   
    op="dormir";   
        $('#progressbar').show();
            $.ajax({
                url: "viaticos_dat_actualizar.php",
            type: "post",        
            data: {Nodias:dias,Operacion:op,Idrecorrido:idrecorrido, IdViatico: IdViatico},          
            success: function(data){    
                console.log(data);            
                $("#RV").html(data+"");    
                
                viaticosResumen();
                $('#progressbar').hide();
            }
            });
            
  }
}
function pagarcombustible(idrecorrido) {
  // Get the checkbox
  var checkBox = document.getElementById("checkCombustible"+idrecorrido);
  // Get the output text

  IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>"; 
  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
    
    dias = 1;   
    op="combustible";   
        $('#progressbar').show();
            $.ajax({
                url: "viaticos_dat_actualizar.php",
            type: "post",        
            data: {Nodias:dias,Operacion:op,Idrecorrido:idrecorrido, IdViatico: IdViatico},          
            success: function(data){    
                console.log(data);            
                $("#RV").html(data+"");    
                
                viaticosResumen();
                $('#progressbar').hide();
            }
            });
            

  } else {
    dias = 0;   
    op="combustible";   
        $('#progressbar').show();
            $.ajax({
                url: "viaticos_dat_actualizar.php",
            type: "post",        
            data: {Nodias:dias,Operacion:op,Idrecorrido:idrecorrido, IdViatico: IdViatico},          
            success: function(data){    
                console.log(data);            
                $("#RV").html(data+"");    
                
                viaticosResumen();
                $('#progressbar').hide();
            }
            });
            
  }
}
function SubirEscaneado(){
    IdViatico = "<?php if (isset($IdViatico)){echo $IdViatico;} else {}?>";                        
    var formData = new FormData(document.getElementById('formEscaneado'));        
    formData.append('IdViatico',  IdViatico);        
    
    $('#progressbar').show();
        $.ajax({
            url: 'viaticos_subirescaneado.php',
        type: 'post',                
        dataType: 'html',
        data: formData,             
        cache: false,
        contentType: false,
        processData: false,
        beforeSend:function(){
            // $('#progressbar').show();        
        },                    
        success: function(data){                
            $('#RV').html(data);                            
            $('#progressbar').hide();
        }
        });
}




</script>





<script src="lib/fluid/responsive_waterfall.js"></script>
<script src="lib/fluid/app.js"></script>

<script src="lib/jquery-ui.min.js"></script>
<script src="lib/timedropper.js"></script>
<!-- <script>$( "#HoraSalida" ).timeDropper();</script> -->
<!-- <script>$( "#HoraRegreso" ).timeDropper();</script> -->


<script>
function tiempo(){
	//var txt_tiempo = document.getElementById("txt_tiempo");
	inicio = document.getElementById("HoraSalida").value;
	// fin = document.getElementById("hr_regreso").value;

	// inicioMinutos = parseInt(inicio.substr(3,2));
	// inicioHoras = parseInt(inicio.substr(0,2));

     
}

function LlenarDestinos()
{
   // select_text = $("#origen option:selected").text();
 var id = document.getElementById("LugarOrigen").value;

        $.ajax({
            url: "llenarDestinos.php",
            type: "get",
            data: {idorigen: id},
            success: function(data){              
                $('#LugarDestino').html(data+"\n");
            }
        });

       
}

function MostrarDistancia()
{
   // select_text = $("#origen option:selected").text();
 var id = document.getElementById("LugarDestino").value;

        $.ajax({
            url: "llenarDestinos.php",
            type: "get",
            data: {idrecorrido: id},
            success: function(data){       
                //console.log(data);     
                $('#Distancia').val(data);
                $('#id').val(id);
            }
        });

       
}

function vaciarDescripcion(){
 document.getElementById('lblVehiculoOficial').innerHTML ="";

}
function vaciarDescripcionR(){
 document.getElementById('lblVehiculoOficialR').innerHTML ="";

}
   
function cambioOpciones() {
  placas1=document.getElementById('IdVehiculoOficial').value;

  $.ajax({
            url: "mostrar_info_vehiculo.php",
            type: "get",
            data: {placas: placas1},
            success: function(data){       
                console.log(data);     
                document.getElementById('lblVehiculoOficial').innerHTML =data;
              
            }
        });

  
}

function cambioOpcionesR() {
  
  placasR=document.getElementById('IdVehiculoOficialR').value;
  $.ajax({
            url: "mostrar_info_vehiculo.php",
            type: "get",
            data: {placas: placasR},
            success: function(data){       
              //  console.log(data);     
                document.getElementById('lblVehiculoOficialR').innerHTML =data;
              
            }
        });

  
}
</script>





<!-- Hacer algo de espacio para testear -->



<?php include ("./lib/body_footer.php"); ?>