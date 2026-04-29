<?php
include ("./lib/body_head.php");
?>
<?php
$id_aplicacion ="ap103";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
   
    if (isset($_GET['idm'])){
        $idMunicipio=$_GET['idm'];
       }
       if (isset($_GET['idc'])){
           $idColonia=$_GET['idc'];
          }
echo "<div  style='border: 0px;'>";
echo "<center>";      
echo "<br>";
echo "<br>";

$sql =  "SELECT * from catcolonia where idmunicipio= ".$idMunicipio." and idcolonia=" .$idColonia;
$tmp="";

$l = $Vivienda -> query($sql);
while($valor = $l -> fetch_array())
   {

    if (isset($_GET['c']))
        {
        /* ****************************CONSULTA DE LA COLONIA ***************************** */
        echo "<div class='sombra' style='width: 60%; background-color:white;'>";


        echo "<br><h1>Información General  de la Colonia</h1><br>";

        echo "<table >";
     


        echo "<tr>";      
        echo "<td valign='middle'><b class='normal'>Municipio</b></td>";
        echo "<td valign='middle'  colspan='3'>";
        echo "<span class='tenue' >".NombreMunicipioVivienda($valor['IdMunicipio'])."</span>";
        echo "</td>";
        echo "</tr>"; 

        echo "<tr>";      
        echo "<td valign='middle'><b class='normal '>Colonia</b>";
        echo "<td valign='middle' colspan='3'>";        
        echo "<span class='tenue' >".NombreColoniaVivienda($valor['IdMunicipio'],$valor['IdColonia'])."</span>";
        echo "<div";
        echo "</td>";
        echo "</tr>";  
        echo "<tr>";
        echo "</tr>";

        echo "<tr>";      
        echo "<td valign='middle'><b class='normal '>Nombre Oficial</b>";
        echo "<td valign='middle' colspan='3'>";       
        echo "<span class='tenue' >".$valor['NOMBRE_OFICIAL']."</span>";
        echo "<div";
        echo "</td>";
        echo "</tr>";  
        echo "<tr>";
        echo "</tr>";

        echo "<tr>";      
        echo "<td valign='middle'><b class='normal '>Tipo Adquisicion</b>";
        echo "<td valign='middle' colspan='3'>";
        echo "<span class='tenue' >".NombreTipoAdquiscion($valor['Idtipoadquisicioncol'])."</span>";
        echo "<div";
        echo "</td>";
        echo "</tr>";  
        echo "<tr>";
        echo "</tr>";

        echo "<tr>";      
        echo "<td valign='middle'><b class='normal'>Observaciones</b>";
        echo "<td valign='middle' colspan='3'>";
        echo "<span class='tenue' >".$valor['Observaciones']."</span>";
        echo "<div";
        echo "</td>";
        echo "</tr>";  
        echo "<tr>";
        echo "</tr>";

        echo "<tr>";      
        echo "<td valign='middle'><b class='normal'></b>";
        echo "<td valign='middle' colspan='3'>";
        if($valor['Solo_Escrituracion']=='1')
        echo "<span style='color:red;' >***  SOLO ESCRITURACION  ***</span>";
        echo "<div";
        echo "</td>";
        echo "</tr>";  
        echo "<tr>";
        echo "</tr>";
        

        echo "</table> "; 
        echo "<br>";
        echo "<br>";
        echo "</div>";
        echo "<br>";
        echo "<br>";



        /* **************************** OTROS ***************************** */
        echo "<div class='sombra' style='width: 60%; background-color: #cde6d8;'><br><h1>Otros</h1><br>";
        echo "<table  >";
        echo "<tr>";      
        echo "<td valign='middle'><b class='normal '>Total de Lotes</b>";
        echo "<td valign='middle' colspan='3'>";        
        echo "<span class='tenue' >".CantidadLotesPorColonia($valor['IdMunicipio'],$valor['IdColonia'])."</span>";
        echo "<div";
        echo "</td>";
        echo "</tr>";  
       
        
        echo "<tr>";      
        echo "<td valign='middle'><b class='normal '>Contratados</b>";
        echo "<td valign='middle' colspan='3'>";        
        echo "<span class='tenue' >".CantidadLotesPorColoniaContratados($valor['IdMunicipio'],$valor['IdColonia'])."</span>";
        echo "<div";
        echo "</td>";
        echo "</tr>";  
 

        echo "<tr>";      
        echo "<td valign='middle'><b class='normal '>Libres</b>";
        echo "<td valign='middle' colspan='3'>";        
        echo "<span class='tenue' >".CantidadLotesPorColoniaLibres($valor['IdMunicipio'],$valor['IdColonia'])."</span>";
        echo "<div";
        echo "</td>";
        echo "</tr>";  
     

        echo "</table> "; 
        echo "<br>";
        echo "</div>";
        echo "</table> "; 

        echo "<br>";

        }
        else
        {
         if ($nivel==1) 
         {


            /* ****************************EDIFICION DE LA COLONIA ***************************** */
            echo "<div class='sombra' style='width: 60%; background-color:white;'>";
            echo "<br>";
            //echo 'nknks'.ValidarColoniaCompleto($valor['IdMunicipio'],$valor['IdColonia']);
            if(ValidarColoniaCompleto($valor['IdMunicipio'],$valor['IdColonia'])=='TRUE')
            {
               echo "<div id='msgdatosrequeridos' class='sombra' style='display:none; width: 95%; color:red; background:#F8E0E0; font-size: small;'  ><span><br>** Faltan algunos datos requeridos **<br></span><br></div><br>";
            }else {
               echo "<div id='msgdatosrequeridos' class='sombra' style='display:inline-block; width: 95%; color:red; background:#F8E0E0; font-size: small;' ><span><br>** Faltan algunos datos requeridos **<br></span><br></div><br>";
            }
              

            echo "<br><h1>Edicion de la Colonia</h1><br>";

            echo "<table style='width: 90%;'  >";
         
            echo "<tr style='display:none'>";      
            echo "<td valign='middle'><b class='normal'>IdMunicipio:</b></td>";
            echo "<td valign='middle' align='center'>";
            echo "<input type='hiiden' name='IdMunicipio' id='IdMunicipio' value=".$valor['IdMunicipio']." disabled>" ; 
            echo "</td>";
            echo "<td valign='middle' align='center' ></td>";
            echo "<td valign='middle' align='center' ></td>"; 
            echo "</tr>";
    
    
             echo "<tr style='display:none'>";      
            echo "<td valign='middle'><b class='normal '>IdColonia:</b></td>";
            echo "<td valign='middle' align='center'>";
            echo "<input type='hiiden' name='IdColonia' id='IdColonia' value=".$valor['IdColonia']." disabled>" ; 
            echo "</td>";
            echo "<td valign='middle' align='center' ></td>";
            echo "<td valign='middle' align='center' ></td>"; 
            echo "</tr>";

            echo "<tr>";      
            echo "<td valign='middle'><b class='normal '>Municipio</b></td>";
            echo "<td valign='middle'  colspan='3'>";
            echo "<span class='tenue' >".NombreMunicipioVivienda($valor['IdMunicipio'])."</span>";
            echo "</td>";
            echo "</tr>"; 

            echo "<tr>";    
            echo "<td valign='middle'><b class='normal '>Colonia:</b>";
            echo "<td valign='middle' align='center'>";            
            echo "<div  ><table width=100%><tr><td >";
            echo "<tr><td><input  type='text' onkeyup='GuardarDato(this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='Colonia' id='Colonia' value='".trim($valor['Colonia'])."'></td>";
            echo "<td width=13px><div style='display:none;' id='LoaderColonia'><img src='img/loader_bar.gif' style='width:13px;'></div>";
            echo "<div style='display:none;' id='RColonia'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
            echo "</td>";           
            echo "</tr>";
            
            echo "<tr>";    
            echo "<td valign='middle'><b class='normal'>Nombre Oficial:</b>";
            echo "<td valign='middle' align='center'>";           
            echo "<div  ><table width=100%><tr><td >";
            echo "<tr><td><input  type='text' onkeyup='GuardarDato(this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='NOMBRE_OFICIAL' id='NOMBRE_OFICIAL' value='".trim($valor['NOMBRE_OFICIAL'])."'></td>";
            echo "<td width=13px><div style='display:none;' id='LoaderNOMBRE_OFICIAL'><img src='img/loader_bar.gif' style='width:13px;'></div>";
            echo "<div style='display:none;' id='RNOMBRE_OFICIAL'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
            echo "</td>";           
            echo "</tr>";
           


            echo "<tr>";      
            echo "<td valign='middle'><b class='normal'>Tipo de Adquisción: *</b>";
            echo "<td valign='middle' align='center'  colspan='3'>";
            echo "<div'><table width=100%><tr><td>";
            echo "<select  name='Idtipoadquisicioncol' style='margin-left: 0px;' id='Idtipoadquisicioncol' onchange='GuardarDato(this.id,\"".$nitavu."\",this.value)'  name='IdEstatus' >";
                $r2x = $conexion -> query($sql);
                $sql2="SELECT * FROM tipoadquisicioncol";
            $r2 = $Vivienda -> query($sql2);
            //echo '<option value="100">SELECCIONE UNA OPCION...</option>';
            while($f = $r2 -> fetch_array())
                {
                    if ($valor['Idtipoadquisicioncol'] ==$f['Idtipoadquisicioncol'])
                    {         
                        echo "<option value='".$f['Idtipoadquisicioncol']."' selected>".$f['tipoadquisicioncol']."</option>";
                        }
                        else
                        {
                        echo "<option value='".$f['Idtipoadquisicioncol']."'>".$f['tipoadquisicioncol']."</option>";
                        
                        }	
                
                } 
            echo "</select></td><td width=13px><div style='display:none;' id='LoaderIdtipoadquisicioncol'><img src='img/loader_bar.gif' style='width:13px;'></div>
            <div style='display:none;' id='LoaderOKIdtipoadquisicioncol'> <img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
            echo "</div>";
            echo "</td>";
            echo "</tr>"; 

            echo "<tr>";      
            echo "<td></td>";
            echo "<td>";
            echo "<div class='elemento' id='divSoloEscritura'>";                          
            echo "<label>";                            
            //  $dato= $valor['SoloEscritura'];
            if($valor['Solo_Escrituracion'] == '1')
            
            {
            echo "<input  type='radio' name='Solo_Escrituracion' id='Solo_Escrituracion' onclick= 'GuardarDato(this.id,\"".$nitavu."\",1)' checked >\"SOLO ES ESCRITURACIÓN\"";
            }
            else
            {
                echo "<input  type='radio' name='Solo_Escrituracion' id='Solo_Escrituracion' onclick='GuardarDato(this.id,\"".$nitavu."\",1)' > \"SOLO ES ESCRITURACIÓN\"";
            }                          
            echo "</label>";
            echo "</div>";
            echo "</td>";           
            echo "</td>";
            echo "</tr>";

            echo "<tr>";      
            echo "<td valign='middle'><b class='normal' >Observaciones: </b></td>";
            echo "<td valign='middle' align='center' colspan='3' >";
            //echo "<input type='text' name='Superficie' id='Superficie' value=".$valor['superficie'].">" ; 
            echo "<div ><table width=100%><tr><td >";
            echo "<tr><td><textarea  type='text' onkeyup='GuardarDato(this.id,\"".$nitavu."\",this.value)'   mayus(this);'  name='Observaciones' id='Observaciones' >".trim($valor['Observaciones'])."</textarea></td>";
            echo "<td width=13px><div style='display:none;' id='LoaderObservaciones'><img src='img/loader_bar.gif' style='width:13px;'></div>";
            echo "<div style='display:none;' id='RObservaciones'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>";
            echo "</td>";
            echo "</tr>" ;

            echo "</table> "; 
            echo "<br>";
            echo "<br>";
            echo "</div>";
            echo "<br>";
            echo "<br>";
            
            }else {
                mensaje("No tiene acceso a esta aplicacion",'');
            }
        }

   }
   
echo "</center>";
echo "</div>"; 






    
}
else{mensaje("No tiene acceso a esta aplicacion",'');}

    ?>
    <script>


$(document).ready(function(){ 
    //validar que los radiobutton esten selecionados   
   if(( document.getElementById("Solo_Escrituracion").checked!==true))
      {
          
         $("#divSoloEscritura").css({"border-color": "red", "border-style":"solid","border-width": "thin"});       
      }      
      else   
      {      
         $("#divSoloEscritura").css({"border-color": "#CCCCCC", "border-style":"solid","border-width": "0"});   
       }


    idmunicipio = document.getElementById("IdMunicipio").value;
    idcolonia = document.getElementById("IdColonia").value;



    //*******validar inputs 
    var inputs, index, len,campo; 
    inputs = document.getElementsByTagName('input');
    len = inputs.length;
    for (index = 0; index < len; ++index) {        
    campo=inputs[index].name;   
    
   $.ajax({
   ajaxcampo: campo,
   url: "lot_col_bd2.php",
   type: "post",        
   data: {IdMunicipio:idmunicipio, IdColonia:idcolonia, Campo:campo,Funcion:'ColoniaDato'},
    success: function(data){ 
         campo1 = this.ajaxcampo;  
         $("#" + campo1).html(data+"\n");    
         if(data.includes('FALSE')==true)                            
            {              
               $("#" + campo1).css("border-color", "red");              
               $("#msgdatosrequeridos").css({'display':'inline-block'});  
            }
            else
            { 
  
               $("#" + campo1).css("border-color", "#CCCCCC");                
               $("#msgdatosrequeridos").css({'display':'none'});
            }
         
    }
   });
   
   }

   //validar select
   var selects, index2, len2,campo2; 
   selects = document.getElementsByTagName('select');    
   len2 = selects.length;

   for (index2 = 0; index2 < len2; ++index2) {  
   campo2=selects[index2].name;    
   $.ajax({
   ajaxcampo2: campo2,
   url: "lot_col_bd2.php",
   type: "post",        
   data: {IdMunicipio:idmunicipio, IdColonia:idcolonia, Campo:campo2,Funcion:'ColoniaDato'},
    success: function(data){ 
         campo2 = this.ajaxcampo2;                             
        //$("#" + campo2).html(data+"\n");     
        console.log(campo2);
         if(data.includes('FALSE')==true)                            
            {                          
               $("#" + campo2).css("border-color", "red");              
               $("#msgdatosrequeridos").css({'display':'inline-block'});  
            }
            else
            { 
               $("#" + campo2).css("border-color", "#CCCCCC");
               $("#msgdatosrequeridos").css({'display':'none'});
            }         
    }
    });
   }
});
    

function GuardarDato(  campo, nitavu,valor){       
  
    idmunicipio = document.getElementById("IdMunicipio").value;
    idcolonia = document.getElementById("IdColonia").value;

    console.log("#" + campo.type);
   $("#Loader" + campo ).show();
    $.ajax({
    url: "lot_col_bd.php",
    type: "post",        
    data: {IdMunicipio:idmunicipio, IdColonia:idcolonia, Campo:campo, Valor:valor, NitavuMod:nitavu},
    success: function(data){         
                      
       // $("#" + campo).html(data+"\n");  
          if(data.includes('FALSE')==true)                            
            {             
               $("#" + campo).css("border-color", "red");              
              $("#msgdatosrequeridos").css({'display':'inline-block'});  
            }
            else
            { 
                if(campo=='Solo_Escrituracion')
                {
                    $("#divSoloEscritura").css({"border-color": "#CCCCCC", "border-style":"solid","border-width": "0"});   
                }else
                {
                    $("#" + campo).css("border-color", "#CCCCCC");
                }
                
                 $("#msgdatosrequeridos").css({'display':'none'});
            }
        // console.log("Guardando " + IdRequisito + "_" + IdCategoria + ":" + data);
        $("#Loader" + campo).hide();  
    }
    });

}


    </script>