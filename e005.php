<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php"); include ("./lib/body_menu.php");


?>
<?php
$id_aplicacion ="ap111"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);


if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
   echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
   xd_update($id_aplicacion,$nitavu);//guarda la experiencia del usuario
   historia($nitavu, "Entro a la aplicacion [ap111], para consultar las escrituras.");

   
   echo "<br>"; 
   $accion=5;// IMPRESION DE ESCRITURA
   $direccion=quienEsmiDireccion(nitavu_dpto($nitavu));   
  
  if($direccion!=10)
  {  
    mensaje('Esta seccion no esta permitida para su dpto.','index.php');
  }else{
  
    $paso = ObtenerPaso($direccion,$accion);
    $llenos= ObtenerQueCamposDeberiaEstarLlenos($paso);
    
    echo '<form action="e005.php?impresion" method="post">';
    echo '<section>'; 
    echo ' <div class="container">
    <div>
        <div class="col-md-8 col-md-offset-2">
            <div >
                <div class="card-body d-flex justify-content-between align-items-center">
                <select  name="area" style="margin-left: 0px; width:100%" id="area" onchange="ShowSelected()" >  
                    <option value="1">Impresion</option>
                    <option value="2">Reimpresion</option>
                </select>
                <button style=" margin-top: -5px; margin-left: 10px;" name="multiple_impresion" id="multiple_impresion" class="btn btn-primary" type="submit" >Imprimir</button>
                </div>
            </div>
        </div>
    </div>
    </div>';


    echo '<br>'; 
    
    if($llenos!=null)
    {
            $sql="select CONCAT('<input type=\"checkbox\" id= \"',NumContrato,'\" name=\"imprimir[]\"  class=\"check_box\"  value= \"',NumContrato,'\"/>') AS '',
            NumContrato,     Delegacion,     Municipio,     Colonia,     Seccion,     Fila,     Manzana,     Lote,     NombreBeneficiario as Beneficiario ,
            NOMBRE_OFICIAL,PlantilladeEscritura as Plantilla   
            from      vivienda_tramitesdeescritura where IFNULL(".$paso. ",0)=0 and ". substr($llenos,0,  strrpos($llenos, "and"))." and FechaImpresion is null";

            $sql2="select CONCAT('<input type=\"checkbox\" id= \"',NumContrato,'\" name=\"reimprimir[]\"  class=\"check_box\"  value= \"',NumContrato,'\" />') AS '',
            NumContrato,     Delegacion,     Municipio,     Colonia,     Seccion,     Fila,     Manzana,     Lote,     NombreBeneficiario as Beneficiario ,
            NOMBRE_OFICIAL,PlantilladeEscritura as Plantilla   
            from      vivienda_tramitesdeescritura where  IFNULL(".$paso. ",0)=0 and ". substr($llenos,0,  strrpos($llenos, "and"))." and FechaImpresion is not null";
    }
        

    
        echo "<div style='background-color:#EEEEEE; width:95%; display:inline-block;
        border-radius:5px; padding:10px; margin-top:20px;' id= 'impresion'>";
        echo "<h2>tramites de Escritura para Impresión</h2>";
        echo "<input type='hidden' name='gridImpresion' id='gridImpresion' value='Impresion' >" ;  
        TablaDinamica_MySQLVivienda("",$sql, "tramitesImpresion", "TablaImpresion", "divAncho", 2); 
        echo "</div>";
        
        echo "<div  style='background-color:#EEEEEE; width:95%; display:none;
        border-radius:5px; padding:10px; margin-top:20px;' id= 'reimpresion'>";
        echo "<h2>tramites de Escritura para Reimpresión</h2>";  
        echo "<input type='hidden' name='gridReimpresion' id='gridReimpresion' value='Reimpresion' >" ;   
        TablaDinamica_MySQLVivienda("",$sql2, "tramitesReImpresion", "TablaReImpresion", "divAncho", 2); 
        echo "</div>"; 
        echo '<section>'; 
        echo '</form>';



        if (isset($_GET['impresion']))
        { // si hay seleccionado un municipio
            if(isset($_POST['imprimir']))
                {
                    echo 'grid   '.$_POST['gridImpresion'];
                    $numero=$_POST["imprimir"];
                    $count = count($numero);
                    for ($i = 0; $i < $count; $i++) {
                    // echo $numero[$i]."<br>";
                    
                    $idaccionseg=ObtenerIdAccionSeguimiento($direccion,$accion);           
                    $numescritura= ObtenerNumEscrituraConContrato($numero[$i]);
                    $campo= ObtenerCampomovescrituras ($direccion,$accion); 
                    $soporte=NULL;
                    $observaciones=NULL;
            
                    $asunto="Escritura Impresa";
                    $msg="El tramite de escritura con número:  ".$numescritura." fue impresa";
                    
                    
                    if(InsertSeguimientoEscritura($numescritura,$idaccionseg,$nitavu,$soporte,$observaciones)=='TRUE')
                        {                           
                            $sql=" -- esc 
                            UPDATE movescrituras SET FechaUltimaMod=NOW(), IdEmpModifica=".$nitavu.", ".$campo."=1, FechaImpresion=NOW() WHERE NumEscritura='".$numescritura."'";                    
                            //echo $sql;
                            if ($Vivienda->query($sql) == TRUE)
                            {
                                historia($nitavu,'Esc_'.$msg);                       
                            }                
                            else
                            {
                                $msg="Error inesperado ".$sql; //<-- Descripcion de error
                            }
                        }
                        else{echo 'no entro a impresion de escritura';}
                    }
                    mensaje("Escritura(s) Impresa(s) con exito" ,"e005.php");
                }
                else  if(isset($_POST['reimprimir']))
                {
                    echo 'grid   '.$_POST['gridReimpresion'];
                    $numero=$_POST["reimprimir"];
                    $count = count($numero);
                    for ($i = 0; $i < $count; $i++) {
                    // echo $numero[$i]."<br>";
                    
                    $idaccionseg=ObtenerIdAccionSeguimiento($direccion,6);           
                    $numescritura= ObtenerNumEscrituraConContrato($numero[$i]);
                    $campo= ObtenerCampomovescrituras ($direccion,$accion); 
                    $soporte=NULL;
                    $observaciones=NULL;

                    $asunto="Escritura Reimpresa";
                    $msg="El tramite de escritura con número:  ".$numescritura." fue reimpresa";
                    
                    
                    if(InsertSeguimientoEscritura($numescritura,$idaccionseg,$nitavu,$soporte,$observaciones)=='TRUE')
                        {             
                            $sql=" -- esc 
                            UPDATE movescrituras SET FechaUltimaMod=NOW(), IdEmpModifica=".$nitavu.", ".$campo."=1  WHERE NumEscritura='".$numescritura."'";         
                            //echo $sql;
                            if ($Vivienda->query($sql) == TRUE)
                            {
                                historia($nitavu,'Esc_'.$msg);             
                            }
                            else
                            {
                                $msg="Error inesperado ".$sql; //<-- Descripcion de error
                            }   
                        }else{echo 'no entro a escritura trámite';}
                    }
                    mensaje("Escritura(s) Reimpresa(s) con exito" ,"e005.php");
                }          
                else
                {
                    mensaje("No ha seleeccionado ningun registro", 'e005.php');
                }
        }

  }

}
else 
{
    mensaje("No tiene acceso a esta aplicacion",'');
}

?>
<script type="text/javascript">

function enviarDatos(id){
        $.ajax({
            url: 'e005.php?prueba',
            type: 'POST',
            data: {"idInmuebles":id},
            datatype: 'json',
            success: function (data) { alert("success"); },
            error: function (jqXHR, textStatus, errorThrown) { alert("error"); }
        });
    }

/*MOSTRAR/OCULTAR TABLA DE TRAMITES LISTOS PARA IMPRIMIR */
  function ShowSelected()
  {  
   /* Para obtener el valor */
  var valor = document.getElementById("area").value;

  if(valor==1)
  {  
    $("#impresion").css({'display':'inline-block'});
    $("#reimpresion").css({'display':'none'});
  
  }
  else
  {
    $("#reimpresion").css({'display':'inline-block'});
    $("#impresion").css({'display':'none'});
  }
  }


</script>




<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>
