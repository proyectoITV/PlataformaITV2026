<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/laura_funciones.php");

$Vcolonia=VarClean($_POST['IdColonia']);
echo "<Label style='padding-left:10px; font-size: 10px;'>El IdColonia es ".$Vcolonia."</Label>";
//echo ('El IdColonia es '.$Vcolonia);
$Mun=VarClean($_POST['MunRec']);
$NC=VarClean($_POST['NC']);


$sql="select idLote,Seccion, Fila, Manzana, Lote, Colonia,Precio, Superficie 
FROM lotes where IdEstatus in (0,5) and Idcolonia=".$Vcolonia." and IdMunicipio=".$Mun." Order by Manzana,Lote ";


$sql2="Select * from convdesarrollador where Folio=".$NC;
$rc2= $Vivienda -> query($sql2);
//echo $sql2;
if($f = $rc2 -> fetch_array())
            {
              //$f['MontoConvenio']
              $monto=number_format($f['MontoConvenio'], 2, '.', '');
              $subsidiolote=$f['SubsidioLote'];
              $totallotes=$f['TotalLotes'];
              $iddelegacion=$f['IdDelegacion']; 
              $idprograma=$f['IdPrograma'];

            } 
$montocontratado=0;
$lotescontratados=0;
 $sqlrevisa="Select sum(MontoCredito) as montocontratado, count(MontoCredito) as lotescont from contratos where cancelado=0 and Idprograma=165 and Folio=".$NC;
  $rc3= $Vivienda->query($sqlrevisa) ;
  if($h = $rc3 -> fetch_array()){
    $montocontratado=$h['montocontratado'];
    $lotescontratados=$h['lotescont'];
 }

 
//echo $monto;

/* $sqlx = "select idLote, '".NombreMunicipioVivienda($m)."' as Municipio, Colonia as Colonia,seccion, fila,manzana, lote,
    CONCAT(' <a  href=lot_lotes_edit.php?id=',idLote,'><center><img src=\"./icon/edit.png\" height=\"20\" width=\"15\" title=\"Editar lote\"><center></a>')
 as '' ,  
CONCAT(' <a id=\"DarBajaLote\" href=\"?m=".$m."&mensaje&idlote=',idLote,'\"  title=\"Dar de baja Lote\"><center><img src=\"icon/eliminar.png\" style=\"width:20px;\"></center> </a>') AS ''
 FROM lotes WHERE IdMunicipio = ".$m." AND  IdColonia In (".$ids.")  and (Cancelado!=1)";  */

// $sql="select idLote,Seccion, Fila, Manzana, Lote, Colonia,Precio, Superficie ,
// CONCAT(' <button onclick=\"funcionadd(',idLote,'); \"><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"AgregaLote\"><center></button>')     as ''
// FROM lotes where IdEstatus in (0,5) and Idcolonia=".$Vcolonia." and IdMunicipio=".$Mun." Order by Manzana,Lote ";

//case when isnumeric(lotes.Manzana) = 1 then convert(float,lotes.Manzana) else 0 end  ,   case when isnumeric(lotes.Lote) = 1 then convert(float,lotes.Lote) else 0 end
//echo $sql;
//TablaDinamica_MySQL2("",$sql, "MiIdDivTabla2", "IdTabla2", "", 2,"",'CONVENIOS DE DESARROLLADORES','Portrait','Desarrolladores'); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal


echo "<div id='Form' class='container' style='background-color: #fff;
border-radius: 5px;
padding: 15px;
margin-top:20px;
'>

<h3 style='color:rgb(70, 130, 180);'>Seleccione los lotes para este convenio</h3>
<input type='hidden' id='listalotes'>
<input type='hidden' id='total' value=$montocontratado>
<input type='hidden' id='montoconv' value=$monto>
<input type='hidden' id='totall' value=$totallotes>

 <table style='width:100%;'>
<tr>
<td style='width:65%;'>
<label style='font-size: 15px; ' >Lotes en convenio y seleccionados :  </label><label id=seleccionados style='color:rgb(70, 130, 180);font-weight: bold;'>$lotescontratados</label></td>
<td style='width:10%;'> </td><td>
<button id='RegistrarLotes' class='btn btn-success' onclick='RegistraLotes($NC,$Mun);' style='margin:10px;'>Registra lotes en convenio</button></td>
</tr>
</table> 
 ";
 //<tr>
 //<td style='width:43%;' >Numero de Convenio: $NC</td><td  style='width:38%;'>Monto del Convenio: $monto</td><td style='width:33%;' right >Total de lotes : $totallotes</td>
 //</tr>

echo "<input type='text' id='RV'>";

$rc= $Vivienda -> query($sql);
$row_cnt = $rc->num_rows;
   //$cont=0;
   if($row_cnt>0)
   {
     echo "<table class='Tabla' id='tabladelotes' name='tabladelotes'><th>IdLote</th><th>Seccion</th><th>Fila</th><th>Manzana</th><th>Lote</th><th>Colonia</th><th>Precio</th><th>Superficie</th><th>Seleccionar</th>";  
     

     while($valor = $rc -> fetch_array())
     {
        echo "<tr>";
    echo "<td>".$valor['idLote']."</td><td>".$valor['Seccion']."</td><td>".$valor['Fila']."</td><td>".$valor['Manzana']."</td><td>".$valor['Lote']."</td><td>".$valor['Colonia']."</td><td id='preciolote'>".$valor['Precio']."</td><td>".$valor['Superficie']."</td><td><input type='checkbox' class='form-check-input'  name='IdLotex' id='IdLotex'  value='".$valor['idLote']."' ></td>";       
    echo "</tr>";         
     }  
      echo "</table>";
   } 

      
    unset($r2, $f2,$sqlB);


echo '</div>';

?>
<script>  


 $(document).ready(function() {

   $('[name="IdLotex"]').click(function() {  
        var valores=0;
        var total=Number($('#total').val());
        var totall=$('#totall').val();
        var totallcont=Number($('#seleccionados').html());
         
            // Obtenemos todos los valores contenidos en los <td> de la fila
            // seleccionada
            //$(this).parents("tr").find("td").each(function(){
             
            $(this).parents("tr").find("#preciolote").each(function(){                             
                valores+=$(this).html()+"\n";  
            });
      if (valores==0){
        alert('Este lote tiene un Precio de cero pesos, verifique si es correcto');
        $(this).prop("checked", false);        
      }      
      else
      {         
        //var checkedelemids = $('input[type=checkbox]:checked').map(function(){
        // var checkedelemids = $(":checkbox:checked").map(function(){      
        //var checkedelemids = $('input[type=checkbox]:checked').map(function(){
        //var checkedelemids = $('.form-check-input:Checked').map(function(){      
        var checkedelemids = $('[name="IdLotex"]:checked').map(function(){  
        return this.value;     
        }).get().join(",")        
        
        $('#listalotes').val(checkedelemids);
        var checked = $(".form-check-input:checked").length;
        
        //  checked=checked+totallcont;
        //$('#seleccionados').html(checked);            
        conveniopesos=$('#montoconv').val();
               
          if ($(this)[0].checked){
            total=Number(total)+Number(valores);       
            $('#total').val(total);
                        
            checked=totallcont+1;            
            $('#seleccionados').html(checked);  
          }
          else{        
            $('#RegistrarLotes').prop('disabled',false);
            total=Number(total)-Number(valores);       
            $('#total').val(total);

            checked=totallcont-1;
            $('#seleccionados').html(checked);  
          }  
          if (total>conveniopesos){
            alert('El precio de los lotes seleccionados sobrepasa el monto del convenio');
            $('#RegistrarLotes').prop('disabled',true);
          }

          var totallotes=Number($('#seleccionados').html());
          if (totallotes>totall){
            alert('El número de lotes seleccionados sobrepasan lo estipulado en convenio');
            $('#RegistrarLotes').prop('disabled',true);
          }
      }  ;
    });

  });
  

//function RegistraLotes(NC,Mun){
function RegistraLotes(nc,Mun){
  var listalotes=$('#listalotes').val();
  var folio=listalotes=$('#listalotes').val();
  //alert(listalotes);
  
  var totallotes=Number($('#seleccionados').html());
  var totall=$('#totall').val();
  if (totallotes<totall){
    var completo =0;
    //alert('incompleto');
  }else{
    var completo =1;
    //alert('completo');
  }
  
  $('#progressbar').show();
            $.ajax({
                url: "desarrolladores_AddLotesConvenio2.php",
            type: "post",        
            data: {listalotes:listalotes,nc:nc, completo:completo},
            success: function(data){                
                console.log('resultado'+data);                
                completoR=$('#RV').val();                 
                $('#progressbar').hide();     
               
                    if(completo == 0){
                      alert("Convenio "+nc+" actualizado con éxito INCOMPLETO");
                      document.location.href='desarrolladores_Convenios.php?AgregaLotes=&IdMunicipio='+Mun+'&nc='+nc;
                    }else{
                        alert("Convenio "+nc+" actualizado con éxito COMPLETO");
                         document.location.href='desarrolladores_Convenios.php?id='+nc;
                      
                    }  
               
            }
  });    


  var arrLotes = listalotes.split(',');  


  /* for (let i = 0; i < arrLotes.length; i++) {   
      var idlote=arrLotes[i];
      $('#progressbar').show();
            $.ajax({
                url: "desarrolladores_AddLotesConvenio2.php",
            type: "post",        
            data: {idlote:idlote,NC:NC, completo:completo},
            success: function(data){                
                $("#RV").html(data+"");                    
                $('#progressbar').hide();               
               
            }
        });    
    }  */

     //if(completo == 1){
     //   alert("Convenio "+NC+" actualizado con éxito COMPLETO");

                  //Toast("Convenio "+$NC+" actualizado con éxito",1,"");
                  //Toast("Convenio ".$NC." actualizado con éxito",1,"");
                //document.location.href='desarrolladores_Convenios.php?id='+NC;

     //   }else{
     //     alert("Convenio "+NC+" actualizado con éxito INCOMPLETO");
                  //toast("Error al guardar lotes en Convenio "+$NC)
          //document.location.href='desarrolladores_Convenios.php?AgregaLotes=&IdMunicipio='+Mun+'&NC='+NC; 
     //   } 
           

};


    //     foreach(explode(",",$ListaAplicacion) as $areaRev)
    // {                            
    //     foreach(explode(",",$IdPaquetes) as $paqRev){
    //         if(RevisaPaquete($paqRev,$areaRev,$IdPrograma)){

    //                         $bandera=1;

    //         }                                   
    //     }
        
    //  }   





 /* 
  crear una tabla desde javascript  
 function funcionadd(Idlote){
   alert('IdLote='+Idlote);
   let table = document.createElement('table');
   let thead = document.createElement('thead');
   let tbody = document.createElement('tbody');

  table.appendChild(thead);
  table.appendChild(tbody);

// Adding the entire table to the body tag
  document.getElementById('Form').appendChild(table);

  let row_1 = document.createElement('tr');
let heading_1 = document.createElement('th');
heading_1.innerHTML = "Sr. No.";
let heading_2 = document.createElement('th');
heading_2.innerHTML = "Name";
let heading_3 = document.createElement('th');
heading_3.innerHTML = "Company";

row_1.appendChild(heading_1);
row_1.appendChild(heading_2);
row_1.appendChild(heading_3);
thead.appendChild(row_1);


// Creating and adding data to second row of the table
let row_2 = document.createElement('tr');
let row_2_data_1 = document.createElement('td');
row_2_data_1.innerHTML = "1.";
let row_2_data_2 = document.createElement('td');
row_2_data_2.innerHTML = "James Clerk";
let row_2_data_3 = document.createElement('td');
row_2_data_3.innerHTML = "Netflix";

row_2.appendChild(row_2_data_1);
row_2.appendChild(row_2_data_2);
row_2.appendChild(row_2_data_3);
tbody.appendChild(row_2);


// Creating and adding data to third row of the table
let row_3 = document.createElement('tr');
let row_3_data_1 = document.createElement('td');
row_3_data_1.innerHTML = "2.";
let row_3_data_2 = document.createElement('td');
row_3_data_2.innerHTML = "Adam White";
let row_3_data_3 = document.createElement('td');
row_3_data_3.innerHTML = "Microsoft";

row_3.appendChild(row_3_data_1);
row_3.appendChild(row_3_data_2);
row_3.appendChild(row_3_data_3);
tbody.appendChild(row_3);
   
 } 
 */


</script>