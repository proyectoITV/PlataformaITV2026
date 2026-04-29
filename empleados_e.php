<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
?>
<?php
$id_aplicacion = 'ap03';
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
// $nivel=1;
$id_aplicacion ="ap03"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    $n = VarClean($_GET['n']);
    historia($nitavu, "Vio el Perfil a travez de la aplicacion de busqueda de personal de ".$n." - ".nitavu_nombre($n));
    if (isset($_GET['edit'])){
        if ($nivel <> 1 ){
            Toast("No tienes permiso para editar",2,"");
        }
    }
    if ($nivel==1){
        
        // echo "<form method='POST' enctype='multipart/form-data' id='EmpleadoEditar'>";
        echo "<span style='
            width: 100%;
            text-align: right;
            display: block;
            background-color: #28a7453d;
            margin-top: -8px;
            padding-bottom: 7px;
            padding-ritght:10px;'
        >";
        if (isset($_GET['edit'])){
            echo "<a class='btn btn-warning' href='empleados_e.php?n=".$n."'>Salir de Edición</a>";
        } else {
            echo "<a class='btn btn-success' href='empleados_e.php?n=".$n."&edit'>Editar</a>";
        }
        echo "</span>";
    }
   
    echo "<script>$('body').css('background-color','#3C3C3C');</script>";    

    echo '<div  class="wf-container">';
	$sql = "select a.*,
        ifnull((select EstadoCivil from cat_edocivil where IdEstadoCivil = a.estadocivil),'') as MiEstadoCivil    
        from empleados a WHERE nitavu='".$n."'";
	$rc= $conexion -> query($sql);
	if($Empleado = $rc -> fetch_array()){
        echo "<div class='wf-box'>";        
        if ($Empleado['estado']=='') {
            echo ponerfoto("fotos/".$Empleado['nitavu'].".jpg",'FotoE');
        } else {
            echo ponerfoto("fotos/".$Empleado['nitavu'].".jpg",'FotoE2');
        }
        // MisFotos($Empleado['nitavu']);
        echo "<b style='
            font-size:11pt; 
            
            text-align: center;
            width: 100%;
            display: inherit;
            background-color: #d9ead9;
        '        
        >";
        
        if ($Empleado['fecha_nacimiento']=='0000-00-00'){
            echo "<b style='color:red; font-size:8pt'> * No tiene fecha nacimiento registrada</b> <br>";
        }else {
            echo "Edad: ".CalcularEdad($Empleado['fecha_nacimiento'])." años<br>";
        }

        if ($Empleado['iniciolaboral']=='0000-00-00'){
            echo "<b style='color:red; font-size:8pt'> * No tiene registro de fecha de relacion laboral</b> <br>";
        }else {
            echo "<b style='color:gray; font-size:9pt;font-weight:normal'>Personal de ITAVU desde  ".CalcularEdad($Empleado['iniciolaboral'])." años</b><br>";
        }
        echo "<b style='color:gray; font-size:9pt;font-weight:normal'>N° Empleado: ".$Empleado['nitavu']." </b><br>";

        echo "</b>";

        if (isset($_GET['edit']) and $nivel==1){

            echo "<form method='POST' enctype='multipart/form-data' id='EmpleadosEditar' >";   


            echo '<div class=" ">         Actualizar Foto: <input class="form-control" type="file"   accept="image/jpeg"   id="foto" name="foto" style="
            border-radius:5px;
            font-size:8pt;

        "></div>';  

        }

        echo "</div>";

        echo '<div class="wf-box" style="
            border: 2px solid #ffffff17;
            border-radius: 4px;
            background-color: orange;
            text-align: center;
            color: white;
        " >';
            if (isset($_GET['edit']) and $nivel==1){
                //value="('.$Empleado['nitavu'].')-'.$Empleado['nombre'].'"
                echo '<div class=" ">         Nombre: <input class="form-control" type="text" value="'.$Empleado['nombre'].'"  id="nombre_empleado" style="
                    border-radius:5px;
                    font-size:8pt;

                "></div>';            
            } else {
                echo '<div class=" "><span style="font-family:Compacta">Nombre:</span><br>('.$Empleado['nitavu'].')-'.$Empleado['nombre']."</div>";
            }
        echo '</div>';


        echo '<div class="wf-box" style="
            border: 2px solid #ffffff17;
            border-radius: 4px;
            background-color: orange;
            text-align: center;
            color: white;
        " >';
        if (isset($_GET['edit']) and $nivel==1){
            echo '<div class=" ">Puesto: <input  id="puesto" class="form-control" type="text" value="'.$Empleado['puesto'].'" style="
                border-radius:5px;
                font-size:8pt;
            "></div>';            
        } else {
            echo '<div class=" "><span style="font-family:Compacta">Puesto:</span><br>'.$Empleado['puesto']."</div>";
        }
            
        
    echo '</div>';




    echo '<div class="wf-box" style="
    border: 2px solid #ffffff17;
    border-radius: 4px;
    background-color: orange;
    text-align: center;
    color: white;
    " >';
        if (isset($_GET['edit']) and $nivel==1){
            echo '<div class=" ">Departamento: ';
            $sqlDpto='select * from cat_gerarquia where id<>0';
            $rd= $conexion -> query($sqlDpto);
            echo '<select id="dpto" class="form-control">';
            while($dpto = $rd -> fetch_array()) {
                echo "<option value='".$dpto['id']."'>".$dpto['nombre']."</option>";
                if ($Empleado['dpto']==$dpto['id']){
                    echo "<option value='".$dpto['id']."' selected>".$dpto['nombre']."</option>";
                }
            }   
            echo "</select>";
            echo '</div>';         
            
            
        } else {
            echo '<div class=" "><span style="font-family:Compacta">Departamento:</span><br>'.nitavu_dpto_nombre($Empleado['nitavu'])."</div>";
        }
            
        
    echo '</div>';




    echo '<div class="wf-box" style="
    border: 2px solid #ffffff17;
    border-radius: 4px;
    background-color: orange;
    text-align: center;
    color: white;
    " >';
        if (isset($_GET['edit']) and $nivel==1){
            echo '<div class=" "><span style="font-family:Compacta">Titularidad:</span><br> ';
            $sqlTitular='select count(*) as nt from cat_gerarquia where id="'.$Empleado['dpto'].'" and titular="'.$Empleado['nitavu'].'"';
            // echo $sqlTitular;
            $rt= $conexion -> query($sqlTitular);	
            echo '<select id="Titular" class="form-control">';				 
            if($Tit = $rt -> fetch_array())
            {
                // var_dump($Tit);
                if ($Tit['nt']==0){
                    echo "<option value='0' selected>No es Titular</option>";
                    echo "<option value='1'>Es Titular</option>";


                } else {
                    echo "<option value='0' >No es Titular</option>";
                    echo "<option value='1' selected>Es Titular</option>";
                }
            } else {
                if ($Tit['nt']==0){
                    


                } else {
                    echo "Titular del Departamento";
                }
                
            }
            
          
            echo "</select>";
            echo '</div>';         
            
            
        } else {
            echo '<div class=" "><span style="font-family:Compacta">Titularidad:</span><br>';
            $sqlTitular='select count(*) as nt from cat_gerarquia where id="'.$Empleado['dpto'].'" and titular="'.$Empleado['nitavu'].'"';
            // echo $sqlTitular;
            $rt= $conexion -> query($sqlTitular);	
           		 
            if($Tit = $rt -> fetch_array())
            {
                // var_dump($Tit);
                if ($Tit['nt']==0){
                   echo "No es Titular de este departamento";


                } else {
                   echo "Es Titular de este Departamento";
                }
            } else {
               
                
            }
            
          
           
            echo '</div>';        
        }



        echo '<div class="wf-box" style="
        border: 2px solid #ffffff17;
        border-radius: 4px;
        background-color: #ffffff57;
        text-align: center;
        color: white;
        " >';
    
            if (isset($_GET['edit']) and $nivel==1){
                echo '<div class=" "><span style="font-family:Compacta">Nivel:</span><br> <input id="nivel" class="form-control" type="text" value="'.$Empleado['nivel'].'" style="
                    border-radius:5px;
                   
    
                "></div>';            
            } else {
            echo '<div class=" "><span style="font-family:Compacta">Nivel:</span><br>'.$Empleado['nivel']."</div>";
                
            }
            echo '</div>';        
            
        
    



        

    echo '<div class="wf-box" style="
    border: 2px solid #ffffff17;
    border-radius: 4px;
    background-color: #ffffff57;
    text-align: center;
    color: white;
    " >';

        if (isset($_GET['edit']) and $nivel==1){
            echo '<div class=" "><span style="font-family:Compacta">Extension Telefonica:</span><br> <input id="telefono_extension" class="form-control" type="text" value="'.$Empleado['telefono_extension'].'" style="
                border-radius:5px;
               

            "></div>';            
        } else {
        echo '<div class=" "><span style="font-family:Compacta">Extension Telefonica:</span><br>'.$Empleado['telefono_extension']."</div>";
            
        }
        echo '</div>';        
        
    echo '</div>';

    



    echo '<div class="wf-box" style="
    border: 2px solid #ffffff17;
    border-radius: 4px;
    background-color: #ffffff57;
    text-align: center;
    color: white;
    " >';

        if (isset($_GET['edit']) and $nivel==1){
            echo '<div class=" "><span style="font-family:Compacta">Telefono Personal:</span><br> <input id="telefono_movil" class="form-control" type="text" value="'.$Empleado['telefono_movil'].'" style="
                border-radius:5px;
               

            "></div>';            
        } else {
        echo '<div class=" "><span style="font-family:Compacta">Telefono Personal:</span><br>'.$Empleado['telefono_movil']."</div>";
            
        }
        echo '</div>';        
        





        echo '<div class="wf-box" style="
        border: 2px solid #ffffff17;
        border-radius: 4px;
        background-color: #ffffff57;
        text-align: center;
        color: white;
        " >';
    
            if (isset($_GET['edit']) and $nivel==1){
                echo '<div class=" "><span style="font-family:Compacta">Telefono Oficina:</span><br> <input id="telefono2" class="form-control" type="text" value="'.$Empleado['telefono2'].'" style="
                    border-radius:5px;
                   
    
                "></div>';            
            } else {
            echo '<div class=" "><span style="font-family:Compacta">Telefono Oficina:</span><br>'.$Empleado['telefono2']."</div>";
                
            }
            echo '</div>';        
            




            echo '<div class="wf-box" style="
            border: 2px solid #ffffff17;
            border-radius: 4px;
            background-color: #ffffff57;
            text-align: center;
            color: white;
            " >';
        
                if (isset($_GET['edit']) and $nivel==1){
                    echo '<div class=" "><span style="font-family:Compacta">Profesion (Primero abreviatura):</span><br> 
                    <input placeholder="Abreviatura" title="Aqui escriba la Abreviatura" id="profesion_abr" class="form-control" type="text" value="'.$Empleado['profesion_abr'].'" style="
                    border-radius:5px;
                ">
                
                    <input placeholder="Profesion" id="profesion" class="form-control" type="text" value="'.$Empleado['profesion'].'" style="
                        border-radius:5px;
                    ">
                    
                    
                    </div>';            
                } else {
                echo '<div class=" "><span style="font-family:Compacta">Profesion:</span><br>'.$Empleado['profesion']." (".$Empleado['profesion_abr'].")</div>";
                    
                }
                echo '</div>';      


        echo '<div class="wf-box" style="
        border: 2px solid #ffffff17;
        border-radius: 4px;
        background-color: #29cadb9c;
        text-align: center;
        color: white;
        " >';
    
            if (isset($_GET['edit']) and $nivel==1){
                echo '<div class=" "><span style="font-family:Compacta">Correo Electronico:</span><br> <input id="correoelectronico" class="form-control" type="text" value="'.$Empleado['correoelectronico'].'" style="
                    border-radius:5px;
                    
    
                "></div>';            
            } else {
            echo '<div class=" "><span style="font-family:Compacta">Correo Electronico:</span><br>'.$Empleado['correoelectronico']."</div>";
                
            }
            echo '</div>';    






   





    if ($Empleado['estado']=='') {
        echo '<div class="wf-box" style="
        border: 2px solid #ffffff17;
        border-radius: 4px;
        background-color: green;
        text-align: center;
        color: white;
        " >';
    }  else {
        echo '<div class="wf-box" style="
        border: 2px solid #ffffff17;
        border-radius: 4px;
        background-color: red;
        text-align: center;
        color: white;
        " >';
    }
        if (isset($_GET['edit']) and $nivel==1){
            echo '<div class=" "><span style="font-family:Compacta">Estado Laboral:</span><br> ';
           
            echo '<select id="estado" class="form-control">';				            
                echo '<option value="Baja permanente">Baja Permanente</option>';
                echo '<option value="comisionado">Comisionado</option>';
                echo '<option value="Baja RH">Bara RH</option>';
                echo '<option value="Baja temporal ">Baja temporal</option>';
                echo '<option value="">Activo</option>';
                echo '<option value="'.$Empleado['estado'].'" selected>Activo</option>';
                
          
            echo "</select>";
            echo '</div>';         
            
            
        } else {
            echo '<div class=" "><span style="font-family:Compacta">Estado Laboral:</span><br>';
            if ($Empleado['estado']==''){
                echo "ACTIVO";
            }
            else {
                echo $Empleado['estado'];
            }
            
            echo '</div>';        
        }


        echo '</div>';







        
    echo '<div class="wf-box" style="
    border: 2px solid #ffffff17;
    border-radius: 4px;
    background-color: gray;
    text-align: center;
    color: white;
    " >';
        if (isset($_GET['edit']) and $nivel==1){
            echo '<div class=" "><span style="font-family:Compacta">Estado Civil:</span><br> ';
           
            echo '<select id="estadocivil" class="form-control">';				            
            $sql = "SELECT * FROM cat_edocivil ";
            $tmp="";
            $r2 = $conexion -> query($sql);
            while($fx = $r2 -> fetch_array())
                {//Categorias de Aplicaciones
                
                    echo '<option value="'.$fx['IdEstadoCivil'].'">'.$fx['EstadoCivil'].'</option>';
                if ($Empleado['estadocivil']==$fx['IdEstadoCivil']){
                    echo '<option value="'.$fx['IdEstadoCivil'].'" selected>'.$fx['EstadoCivil'].'</option>';
                }
                

            }
            
               
            
            
          
            echo "</select>";
            echo '</div>';         
            
            
        } else {
            echo '<div class=" "><span style="font-family:Compacta">Estado Civil:</span><br>';
            
            echo ''.$Empleado['MiEstadoCivil'];
            echo '</div>';        
        }


        echo '</div>';

  
    // echo '</div>';




    //DCOMICILIO
    // echo '<div  class="wf-container" id="domi">';
        
            echo '<hr><div class="wf-box" style="
            border: 2px solid #ffffff17;
            border-radius: 4px;
            background-color: #a89465;
            text-align: center;
            color: white;
            " >';
                if (isset($_GET['edit']) and $nivel==1){           
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - Calle:</span><br> 
                    <input id="domicilio_calle" class="form-control" type="text" value="'.$Empleado['domicilio_calle'].'" style="
                    border-radius:5px;"></div>';  
                } else {
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - Calle:</span><br>';
                    echo ''.$Empleado['domicilio_calle'];
                    echo '</div>';        
                }
                echo '</div>';






            echo '<div class="wf-box" style="
            border: 2px solid #ffffff17;
            border-radius: 4px;
            background-color: #a89465;
            text-align: center;
            color: white;
            " >';
                if (isset($_GET['edit']) and $nivel==1){           
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - No. Ext:</span><br> 
                    <input id="domicilio_num_ext" class="form-control" type="text" value="'.$Empleado['domicilio_num_ext'].'" style="
                    border-radius:5px;"></div>';  
                } else {
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - No. Ext:</span><br>';
                    echo ''.$Empleado['domicilio_num_ext'];
                    echo '</div>';        
                }
            echo '</div>';


            echo '<div class="wf-box" style="
            border: 2px solid #ffffff17;
            border-radius: 4px;
            background-color: #a89465;
            text-align: center;
            color: white;
            " >';
                if (isset($_GET['edit']) and $nivel==1){           
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - No. Int:</span><br> 
                    <input id="domicilio_num_int" class="form-control" type="text" value="'.$Empleado['domicilio_num_int'].'" style="
                    border-radius:5px;"></div>';  
                } else {
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - No. Int:</span><br>';
                    echo ''.$Empleado['domicilio_num_int'];
                    echo '</div>';        
                }
            echo '</div>';


            echo '<div class="wf-box" style="
            border: 2px solid #ffffff17;
            border-radius: 4px;
            background-color: #a89465;
            text-align: center;
            color: white;
            " >';
                if (isset($_GET['edit']) and $nivel==1){           
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - Entre calles:</span><br> 
                    <input id="domicilio_entrecalles" class="form-control" type="text" value="'.$Empleado['domicilio_entrecalles'].'" style="
                    border-radius:5px;"></div>';  
                } else {
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - Entre calles:</span><br>';
                    echo ''.$Empleado['domicilio_entrecalles'];
                    echo '</div>';        
                }
            echo '</div>';



            echo '<div class="wf-box" style="
            border: 2px solid #ffffff17;
            border-radius: 4px;
            background-color: #a89465;
            text-align: center;
            color: white;
            " >';
                if (isset($_GET['edit']) and $nivel==1){           
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - Ciudad:</span><br> 
                    <input id="domicilio_ciudad" class="form-control" type="text" value="'.$Empleado['domicilio_ciudad'].'" style="
                    border-radius:5px;"></div>';  
                } else {
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - Ciudad:</span><br>';
                    echo ''.$Empleado['domicilio_ciudad'];
                    echo '</div>';        
                }
            echo '</div>';


            echo '<div class="wf-box" style="
            border: 2px solid #ffffff17;
            border-radius: 4px;
            background-color: #a89465;
            text-align: center;
            color: white;
            " >';
                if (isset($_GET['edit']) and $nivel==1){           
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - Colonia:</span><br> 
                    <input id="domicilio_colonia" class="form-control" type="text" value="'.$Empleado['domicilio_colonia'].'" style="
                    border-radius:5px;"></div>';  

                } else {
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - Colonia:</span><br>';
                    echo ''.$Empleado['domicilio_colonia'];
                    echo '</div>';        
                }
            echo '</div>';



            echo '<div class="wf-box" style="
            border: 2px solid #ffffff17;
            border-radius: 4px;
            background-color: #a89465;
            text-align: center;
            color: white;
            " >';
                if (isset($_GET['edit']) and $nivel==1){           
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - CP:</span><br> 
                    <input id="domicilio_cp" class="form-control" type="text" value="'.$Empleado['domicilio_cp'].'" style="
                    border-radius:5px;"></div>';  

                    echo "</form>";
                } else {
                    echo '<div class=" "><span style="font-family:Compacta">Domicilio - CP:</span><br>';
                    echo ''.$Empleado['domicilio_cp'];
                    echo '</div>';        
                }
            echo '</div>';
            


            echo '<div class="wf-box" style="
            border: 2px solid #ffffff17;
            border-radius: 4px;
            background-color: #ffffff57;
            text-align: center;
            color: white;
            " >';
        
                if (isset($_GET['edit']) and $nivel==1){
                    echo '<div class=" "><span style="font-family:Compacta">Fecha de Nacimiento:</span><br> <input id="fecha_nacimiento" class="form-control" type="text" value="'.$Empleado['fecha_nacimiento'].'" style="
                        border-radius:5px;
                       
        
                    "></div>';            
                } else {
                echo '<div class=" "><span style="font-family:Compacta">Fecha de Nacimiento:</span><br>'.$Empleado['fecha_nacimiento']."</div>";
                    
                }
                echo '</div>';        
                
            
            


                echo '<div class="wf-box" style="
                border: 2px solid #ffffff17;
                border-radius: 4px;
                background-color: #ffffff57;
                text-align: center;
                color: white;
                " >';
            
                    if (isset($_GET['edit']) and $nivel==1){
                        echo '<div class=" "><span style="font-family:Compacta">Curp:</span><br> <input id="curp" class="form-control" type="text" value="'.$Empleado['curp'].'" style="
                            border-radius:5px;
                           
            
                        "></div>';            
                    } else {
                    echo '<div class=" "><span style="font-family:Compacta">CURP:</span><br>'.$Empleado['curp']."</div>";
                        
                    }
                    echo '</div>';     


                    echo '<div class="wf-box" style="
                    border: 2px solid #ffffff17;
                    border-radius: 4px;
                    background-color: #ffffff57;
                    text-align: center;
                    color: white;
                    " >';
                
                        if (isset($_GET['edit']) and $nivel==1){
                            echo '<div class=" "><span style="font-family:Compacta">RFC:</span><br> <input id="rfc" class="form-control" type="text" value="'.$Empleado['rfc'].'" style="
                                border-radius:5px;
                               
                
                            "></div>';            
                        } else {
                        echo '<div class=" "><span style="font-family:Compacta">RFC:</span><br>'.$Empleado['rfc']."</div>";
                            
                        }
                        echo '</div>';     
            echo '<div class="wf-box" style="
            border: 2px solid #ffffff17;
            border-radius: 4px;
            background-color: #ffffff57;
            text-align: center;
            color: white;
            " >';
        
                if (isset($_GET['edit']) and $nivel==1){
                    echo '<div class=" "><span style="font-family:Compacta">Lugar de Adscripcion</span><br> <input id="adscripcion" class="form-control" type="text" value="'.$Empleado['adscripcion'].'" style="
                        border-radius:5px;
                       
        
                    "></div>';            
                } else {
                echo '<div class=" "><span style="font-family:Compacta">Lugar de Adscripcion</span><br>'.$Empleado['adscripcion']."</div>";
                    
                }
                echo '</div>';        
                
            echo '</div>';

            



            
    
    echo '</div>';

    


    

    if (isset($_GET['edit']) and $nivel==1){
        echo '<div class="wf-box" style="background-color:transparent; text-align:center;" >';
         echo '<button class="btn btn-primary" onclick="Guardar();">Guardar</button>';            
        echo '</div>';
    } else {
        
    }


    // echo "<div id='ActividadReciente' style='
    //     background-color: #ffffff2b;
    // padding: 20px;
    // '>";
    // echo  "<h1 style='font-size:15pt;'>Actividad reciente en la Plataforma:</h1>";

    // $sql="select 
    // NEmpleado,
    // CONCAT (fecha,':',hora) as Fecha,
    // Descripcion
    
    // from actividad 
    // where NEmpleado='".$n."'
    // order by fecha DESC
    // limit 1000";
    // TablaDinamica_MySQL("",$sql, "MiIdDivTabla2", "IdTabla2", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal



    // echo "</div>";



    // MisFotos($nitavu);

    if ($nivel==1){

        echo "
        <script>
        function Guardar(){
                var formData = new FormData(document.getElementById('EmpleadosEditar'));
                formData.append('n', '".$n."');
                

                nombre_empleado = $('#nombre_empleado').val();
                puesto = $('#puesto').val();
                dpto = $('#dpto').val();
                Titular = $('#Titular').val();
                telefono_extension = $('#telefono_extension').val();
                telefono_movil = $('#telefono_movil').val();
                telefono2 = $('#telefono2').val();
                profesion_abr = $('#profesion_abr').val();
                profesion = $('#profesion').val();
                correoelectronico = $('#correoelectronico').val();
                estado = $('#estado').val();
                estadocivil = $('#estadocivil').val();
                domicilio_calle = $('#domicilio_calle').val();
                domicilio_num_ext = $('#domicilio_num_ext').val();
                domicilio_num_int = $('#domicilio_num_int').val();
                domicilio_entrecalles = $('#domicilio_entrecalles').val();
                domicilio_ciudad = $('#domicilio_ciudad').val();
                domicilio_colonia = $('#domicilio_colonia').val();
                domicilio_cp = $('#domicilio_cp').val();
                nivel = $('#nivel').val();
                adscripcion = $('#adscripcion').val();


                fecha_nacimiento = $('#fecha_nacimiento').val();
                curp = $('#curp').val();
                rfc = $('#rfc').val();
       
                formData.append('nombre_empleado',nombre_empleado);                
                formData.append('fecha_nacimiento',fecha_nacimiento);                
                formData.append('puesto',puesto);
                formData.append('dpto',dpto);
                formData.append('Titular',Titular);
                formData.append('telefono_extension',telefono_extension);
                formData.append('telefono_movil',telefono_movil);
                formData.append('telefono2',telefono2);
                formData.append('profesion_abr',profesion_abr);
                formData.append('profesion',profesion);
                formData.append('correoelectronico',correoelectronico);
                formData.append('estado',estado);
                formData.append('estadocivil',estadocivil);
                formData.append('domicilio_calle',domicilio_calle);
                formData.append('domicilio_num_ext',domicilio_num_ext);
                formData.append('domicilio_num_int',domicilio_num_int);
                formData.append('domicilio_entrecalles',domicilio_entrecalles);
                formData.append('domicilio_ciudad',domicilio_ciudad);
                formData.append('domicilio_colonia',domicilio_colonia);
                formData.append('domicilio_cp',domicilio_cp);
                formData.append('nivel',nivel);
                formData.append('adscripcion',adscripcion);
                formData.append('curp',curp);
                formData.append('rfc',rfc);
            $('#progressbar').show();       
            $.ajax({
                url: 'empleados_e_dat1.php',
                type: 'post',
                dataType: 'html',
                data: formData,             
                cache: false,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    // $('#R').html(`<img src='img/loader_chat.gif' style='width:80%;'>`);
                },
                success:function(data){  
                                    
                    $('#R').html(data);
                    $('#progressbar').hide();
                }
            });
        }
        </script>";
    }

}
}
else{
	mensaje("No tiene acceso a esta aplicacion","");
}





function MisFotos($nitavu){
    
    $ruta="fotos/";
    if (is_dir($ruta)){
        
        $gestor = opendir($ruta);

    
        while (($archivo = readdir($gestor)) !== false)  {
    
            if (is_file($ruta."/".$archivo)) {
                $Len_nitavu = strlen($nitavu);
                $nitavu_archivo = substr($archivo, 0, $Len_nitavu);

                if ($nitavu == $nitavu_archivo){
                    echo "<img src='".$ruta."/".$archivo."' class='FotoE' width='120px' alt='".$archivo."' title='".$archivo."'>";
                    // echo "<img id='MiFoto_".$archivo."' src='".$ruta."/".$archivo."' class='MyModal' width='80%'>";
                }

                
            }            
        }

        // Cierra el gestor de directorios
        closedir($gestor);
    } else {
        echo "No es una ruta de directorio valida<br/>";
    }
}

?>




<script src="lib/fluid/responsive_waterfall.js"></script>
<script src="lib/fluid/app.js"></script>

<br>
<?php




include ("lib/body_footer.php");
?>