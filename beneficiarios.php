<?php include ("./lib/body_head.php");
include ("./lib/body_menu.php"); ?>

<?php

$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap88";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

 if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	
        //PARA DAR ACCESO CUANDO ESTE REGISTRADA
        historia($nitavu,'Req_ Entró a la aplicacion busqueda de beneficiarios'); 
        
        echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
         echo "<br><br>";
         

         $del=midelegacion_id($nitavu);
        // $del=6;
     

        if(isset($_GET['del']))
        {
             $del=$_GET['del'];
             
        } else {
            $del = 0;
        }

         if($del!='OFICINAS CENTRALES')
         {
        
         $sql = "SELECT * FROM cat_delegaciones WHERE id <> ".$del." AND nombre 
         NOT LIKE '%PRES%' AND id<>0 ORDER BY nombre ASC";
         }else {
            $del=0;
             $sql = "SELECT * FROM cat_delegaciones WHERE nombre 
            NOT LIKE '%PRES%' AND id<>0 ORDER BY nombre ASC";
         }


    // echo $sql;
    $r = $conexion -> query($sql);
    $c=0;
    while($f = $r -> fetch_array())
	{ 
        
        if($c==0)
        {           
         $array=$f['id'];  }
        else
        { $array= $array.','.$f['id'];          }
        $c=$c+1;
        
      ;
	}		


///echo $sql;
    echo '  <div id="beta_buscar">';		
		echo '<table border="1" width="100%"><tr>';
            echo '<td>';
            
            if(isset($_GET['search']))
            {
                echo ' <input style="border: none; background: none;" required="required" type="text" name="q" id="q" value="'.$_GET['search'].'"  onkeypress="BuscarBeneficiario(event,'.$del.')"/>';
            }
            else
            {
                echo '<input style="border:  none; background: none;" required="required" type="text" name="q" id="q" value="" placeholder="Nombre del beneficiario" onkeypress="BuscarBeneficiario(event,'.$del.')" />';
            } 
            echo '</td>';
			echo '<td align="right" width="15px">                    
			<button id="beta_buscar_boton" onclick="BuscarBeneficiario2( '.$del.');">
			<img  src="icon/buscar.png"></button>
			</td>';
		echo '</tr></table>';
    echo ' </div>';


    echo "<br><br>";
    echo "<div id='EmpleadosBusquedaCargando'>";
    echo "</div>";
    echo "<br><br>";

    echo "<center>";
    echo "<div id='EmpleadosBusquedaMiDelegacion' style='width:90%;'>";           
    echo "</div>";

    echo "<br><br>";
    
    if($del<>0)
    {
    echo "<div id='boton'>";    
    echo '<a  class="Mbtn btn-default" onclick =BuscarBeneficiarioBDTodo("'.$array.'"); >Extender la busqueda al resto de las delegaciones</a>'; 
    echo "</div>";
    echo "<br><br>";
    }

    echo "<br><br>";
    echo "<div id='EmpleadosBusquedaCargando2'>";
    echo "</div>";
    echo "<br><br>";
   
    echo "<div id='EmpleadosBusquedaTodo' style='width:100%;'>";
    echo "<div id='peticiones' style='border: 0px; width:90%;'>";
    echo "<table style='width: 100%;' id='tablaResultados' name='tablaResultados'>";   
    echo "</table>";
    echo "</div>";
    echo "</div>";
    echo "</center>";
/*
    echo "<div id='EmpleadosBusquedaTodo'>";
    echo "<table style='width: 100%;'>";
    //abasolo
    echo "<tr id='12' name='abasolo'><td>";
    echo "<div id='EmpleadosBusqueda12'>";
            echo "<span class='tenue' style='display:none;font-size: small;' id='span12' >Buscando coincidencias en Delegacion Abasolo.</span>";   
    echo "</div>";
    echo "</td></tr>";
    //aldama
    echo "<tr id='11' name='aldama'><td>";
    echo "<div id='EmpleadosBusqueda11'>";
    echo "</div>";
    echo "</td></tr>";
    //altamira
    echo "<tr id='7' name='altamira'><td>";
    echo "<div id='EmpleadosBusqueda7'>";
    echo "</div>";
    echo "</td></tr>";
    //camargo
    echo "<tr id='19' name='camargo'><td>";
    echo "<div id='EmpleadosBusqueda19'>";
    echo "</div>";
    echo "</td></tr>";
    //diaz ordaz
    echo "<tr id='68' name='diazordaz'><td>";
    echo "<div id='EmpleadosBusqueda68'>";
    echo "</div>";
    echo "</td></tr>";
    //gonzalez
    echo "<tr id='17' name='gonzalez'><td>";
    echo "<div id='EmpleadosBusqueda17'>";
    echo "</div>";
    echo "</td></tr>";
    //jaumave
    echo "<tr id='69' name='jaumave'><td>";
    echo "<div id='EmpleadosBusqueda69'>";
    echo "</div>";
    echo "</td></tr>";
    //jimenez
    echo "<tr id='14' name='jimenez'><td>";
    echo "<div id='EmpleadosBusqueda14'>";
    echo "</div>";
    echo "</td></tr>";
    //llera
    echo "<tr id='18' name='llera'><td>";
    echo "<div id='EmpleadosBusqueda18'>";
    echo "</div>";
    echo "</td></tr>";
    //madero
    echo "<tr id='20' name='madero'><td>";
    echo "<div id='EmpleadosBusqueda20'>";
    echo "</div>";
    echo "</td></tr>";
    //mante
    echo "<tr id='13' name='mante'><td>";
    echo "<div id='EmpleadosBusqueda13'>";
    echo "</div>";
    echo "</td></tr>";
    //matamoros
    echo "<tr id='1' name='matamoros'><td>";
    echo "<div id='EmpleadosBusqueda1'>";
    echo "</div>";
    echo "</td></tr>";
    //miguel aleman
    echo "<tr id='8' name='maleman'><td>";
    echo "<div id='EmpleadosBusqueda8'>";
    echo "</div>";
    echo "</td></tr>";
    //nuevo laredo
    echo "<tr id='2' name='laredo'><td>";
    echo "<div id='EmpleadosBusqueda2'>";
    echo "</div>";
    echo "</td></tr>";
    //nuevo reynosa
    echo "<tr id='3' name='reynosa'><td>";
    echo "<div id='EmpleadosBusqueda3'>";
    echo "</div>";
    echo "</td></tr>";
    //rio bravo
    echo "<tr id='9' name='riobravo'><td>";
    echo "<div id='EmpleadosBusqueda9'>";
    echo "</div>";
    echo "</td></tr>";
    //san fernando
    echo "<tr id='4' name='sanfer'><td>";
    echo "<div id='EmpleadosBusqueda4'>";
    echo "</div>";
    echo "</td></tr>";
    //soto la marina
    echo "<tr id='15' name='lamarina'><td>";
    echo "<div id='EmpleadosBusqueda15'>";
    echo "</div>";
    echo "</td></tr>";
    //tampico
    echo "<tr id='5' name='tampico'><td>";
    echo "<div id='EmpleadosBusqueda5'>";
    echo "</div>";
    echo "</td></tr>";
    //tula
    echo "<tr id='66' name='tula'><td>";
    echo "<div id='EmpleadosBusqueda66'>";
    echo "</div>";
    echo "</td></tr>";
    //vallehermoso
    echo "<tr id='10' name='vallehermoso'><td>";
    echo "<div id='EmpleadosBusqueda10'>";
    echo "</div>";
    echo "</td></tr>";
    //victoria
    echo "<tr id='6' name='victoria'><td>";
    echo "<div id='EmpleadosBusqueda6'>";
    echo "</div>";
     echo "</td></tr>";
    //villa de casas
    echo "<tr id='67' name='casas'><td>";
    echo "<div id='EmpleadosBusqueda67'>";
    echo "</div>";
    echo "</td></tr>";
    //xico
    echo "<tr id='65' name='xico'><td>";
    echo "<div id='EmpleadosBusqueda65'>";
    echo "</div>";
    echo "</td></tr>";
    echo "</table>";
    echo "</div>";
    */

} else {mensaje("ERROR: sin acceso autorizado","");}

?>
<script>


function parametroURL(_par) {
  var _p = null;
  if (location.search) location.search.substr(1).split("&").forEach(function(pllv) {
    var s = pllv.split("="), //separamos llave/valor
      ll = s[0],
      v = s[1] && decodeURIComponent(s[1]); //valor hacemos encode para prevenir url encode
    if (ll == _par) { //solo nos interesa si es el nombre del parametro a buscar
      if(_p==null){
      _p=v; //si es nula, quiere decir que no tiene valor, solo textual
      }else if(Array.isArray(_p)){
      _p.push(v); //si ya es arreglo, agregamos este valor
      }else{
      _p=[_p,v]; //si no es arreglo, lo convertimos y agregamos este valor
      }
    }
  });
  return _p;
}

//Aqui se identifica si existe una varibale en la url
$( document ).ready(function() {
    var busqueda=parametroURL('search');
    var del=parametroURL('del');
      
      if(busqueda!=null && del!=null)
      {   console.log('entro'+del.length);       
        BuscarBeneficiario2(del);
       
      }else if(busqueda!=null && del==null)
      {
        array='12,11,7,19,68,13,17,69,14,18,20,1,8,2,16,3,9,4,15,5,66,10,6,67,65';
        BuscarBeneficiarioBDTodo(array);
      }
});

//funcion para cuando se escribe en el input y se teclea enter
function BuscarBeneficiario(e,del){  
    quien = $("#q").val();
     
       e = e || window.event;
       if (e.keyCode == 13) {
           
           if(del!=0){
               habla('Buscando información sobre ' + quien + ' en la delegación actual');
               BuscarBeneficiario2(del);

           }else{            
                habla('Buscando información sobre ' + quien + ' en todas las delegaciones, te ire informando de mis resultados; ten un poco de pasciencia <?php echo nombre_corto($nitavu,0); ?>, me conectare a cada delegacion.');
               array='12,11,7,19,68,13,17,69,14,18,20,1,8,2,16,3,9,4,15,5,66,10,6,67,65';
               BuscarBeneficiarioBDTodo(array);
           }
       } else {
           
       }
       
     
   }

//Funcion que muestra solo el resultado de la delagacion principal
 function BuscarBeneficiario2(del){          
    
        
		$("#EmpleadosBusquedaCargando").html("<img src='img/loader1.gif' style='height:100px;'><br> <label style='font-size:14pt; color:gray;'>Buscando posibles coincidencias...</label>");
        txtq = $("#q").val();
		console.log("Ejecuanto.." + txtq);
        $("#EmpleadosBusquedaCargando")
            $.ajax({
            url: "beneficiarios_data1.php",
            type: "post",        
            data: {q: txtq, user:"<?php echo $nitavu; ?>", del:del},
            success: function(data){              
				$("#EmpleadosBusquedaCargando").html("");                
                $("#EmpleadosBusquedaMiDelegacion").html(data+"\n");            
            }
            });



     }




 

  
//Funcion que muestra el resultado de todas las delegaciones
    function BuscarBeneficiarioBDTodo(array){
	  
    $("#EmpleadosBusquedaCargando2").html("<img src='img/loader1.gif' style='height:100px;'><br> <label style='font-size:14pt; color:gray;'>Buscando posibles coincidencias en todas de las delegaciones...</label>");
     
    txtq = $("#q").val();
   var res = array.split(","); 
   var x=0;
   
        
        for(var i = 0; i < res.length; i++) {
         
            var counter;
            $.ajax ({
               ajaxcounter: i,
               ajaxtamaño: res.length,
                type: 'post',
                url: "beneficiarios_data1.php",
                data: {q: txtq, user:"<?php echo $nitavu; ?>", del:res[i]},
              
                
                success: function(data) {  
                    counter = this.ajaxcounter;  
                    tam=this.ajaxtamaño; 
                    //verificamos si trae resultados, si no mandamos un push
                    if(data.includes('Sin resultados')==true)                            
                    {		
                        NPush(data,'Plataforma ITAVU');
                        habla(data);
                    }
                    else{    //si trae resultados , dibujamos un tr a la tabla              
                    fila="<tr id="+counter+" name="+counter+"><td> <div id='BeneficariosBusqueda"+counter+"'>   </div></td></tr>";
                    $('#tablaResultados').append(fila); 
                    $("#BeneficariosBusqueda"+counter).html(data+"\n");                                 
                    }//verificamos si esl ultimo elemento del arreglo quitamos el loader
                    if(counter== (tam-1))
                    {
                        $("#EmpleadosBusquedaCargando2").html("");
                    }
                
                } // end success
            }); // end ajax    
        
        } // end for
       
	}
	
</script>
    












 
	
	
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php include ("./lib/body_footer.php"); ?>