var nuevoId;
var db;
db=openDatabase("itemDB", "1.0", "ItemDB",65535);
//'use strict'


//window.addEventListener('load',()=>{
//var xl

 function limpiar(){
    //console.log('Entre a LIMPIAR');        
    document.getElementById("precio").value="";
    document.getElementById("precio2").value="";
}

//lista paquetes


$(function(){    
    $("#todospaq").click(function(){
    let val = $(this).val();
      //Revisa en que status está el checkbox y controlalo según lo //desees
      if( $( this ).is( ':checked' ) ){          
        seleccionarTodo('listaPaquetes');
         $("#listaPaquetes").prop('disabled', true);
      }
      
      else{
        var idpaq = document.getElementById('listaPaquetes').value;
        //console.log('op2'+idpaq);
        $('#listapaq').val(idpaq);    
        $("#listaPaquetes").prop('disabled', false);    
      };
    });
    
    });

    function seleccionarTodo(id)
    {
        //alert('entre a marcar todo');
        var lis='';
        // Recorremos todos los valores
        $("#"+id+" option").each(function(){
            lis=lis+','+(this.value);
            console.log(lis);
            let str2 = lis.substr(1);
            console.log(str2);
            $('#listapaq').val(str2);          

        });
    }

    $("MontoPagoInicial").focusout(function(){
        $(this).css("background-color", "#FFFFFF");
    });


 $("#crearApertura").click(function(e){
     e.preventDefault();   
    // alert('entro apertura');
    console.log('apertura');  
    document.getElementById("listaPaquetes").disabled = true;  
    document.getElementById("todospaq").disabled = true;  
    creaTabla();
    // db.transaction(function(transaction){  
    //     var sql=`CREATE TABLE productos (id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, item VARCHAR(100) NOT NULL, precio DECIMAL(5,2) NOT NULL,idConcepto integer,idTipoConcepto integer)`; 
    //     transaction.executeSql(sql,undefined ,function(){
    //         alert("Se aperturó la corrida financiera");
    //     }, function(transaction, err){
    //         alert(err.message);
    //     })
       
    // })    
    return 0;
}); 

function creaTabla(){
    db.transaction(function(transaction){  
        var sql=`CREATE TABLE productos (id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, item VARCHAR(100) NOT NULL, precio DECIMAL(5,2) NOT NULL,idConcepto integer,idTipoConcepto integer, paqs varchar(50))`; 
        //var sql=`CREATE TABLE productos (id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, item VARCHAR(100) NOT NULL, precio DECIMAL(5,2) NOT NULL,idConcepto integer,idTipoConcepto integer)`; 
        transaction.executeSql(sql,undefined ,function(){
            alert("Se aperturó la corrida financiera");
        }, function(transaction, err){
            alert(err.message);
        })
    })     
}

  
 $("#insertar").click(function(e){
     e.preventDefault();
    
    var idconcepto = document.getElementById('ConceptoApertura').value;
    var combo= document.getElementById('ConceptoApertura');
    var item = combo.options[combo.selectedIndex].text;
    var precio=$("#precio").val();

    var paquetes=document.getElementById('listapaq').value;
    if(paquetes==''){       
        paquetes=document.getElementById('listaPaquetes').value;
        document.getElementById("listapaq").value=paquetes;
        //alert('paquetes-' +paquetes);        
    }else{

        alert('valor'+paquetes);
    }
 
    var idTipoConcepto=1; 
    //alert(item);
    //alert(idconcepto);    
    if (precio>0){
       guardaCambio(item,precio,idconcepto, idTipoConcepto,paquetes);
       //guardaCambio(item,precio,idconcepto, idTipoConcepto);
    }else{
        alert('No puedes registrar un concepto por $ 0.00');
    }
    /*  db.transaction(function(transaction){
         var sql="INSERT INTO productos(item, precio,idconcepto) VALUES(?,?,?)";
         transaction.executeSql(sql,[item, precio,idconcepto], function(){    
         }, function(transaction, err){
             alert(err.message);
         })
     })  */
    
    // limpiar();
    // cargarDatos();     
     return 0;
 })

 $("#insertar2").click(function(e){
    e.preventDefault();
   
   var idconcepto = document.getElementById('ConceptoApertura2').value;
   var combo= document.getElementById('ConceptoApertura2');
   var item = combo.options[combo.selectedIndex].text;
   var precio=$("#precio2").val();   
   //var paquetes=$("#listapaq").val();

   var paquetes=document.getElementById('listapaq').value;
    if(paquetes==''){       
        paquetes=document.getElementById('listaPaquetes').value;
        //alert('paquetes-' +paquetes);        
    }else{

       // alert('valor'+paquetes);
    }

   var idTipoConcepto=2; 
    console.log(precio);
    console.log(item);
    if (precio>0){
        guardaCambio(item,precio,idconcepto,idTipoConcepto,paquetes);   
     }else{
         alert('No puedes registrar un concepto por $ 0.00');
     }
   
    
});

function guardaCambio(item,precio,idconcepto,idTipoConcepto,paquetes){
    db.transaction(function(transaction){
        var sql="INSERT INTO productos(item, precio,idconcepto, idTipoConcepto,paqs) VALUES(?,?,?,?,?)";
        transaction.executeSql(sql,[item, precio,idconcepto, idTipoConcepto,paquetes], function(){ 
            limpiar();
            cargarDatos();        
        }, function(transaction, err){
            alert('Ocurrió un Error, asegúrese de haber presionado el botón INICIAR');
               
            //alert(err.message);
        })
    })
}

$('#eliminarCorrida').click(function(e){
    e.preventDefault();
    console.log('entre a borrar');
    //alert('entre a borrar');
    if(!confirm("¿Esta seguro de borrar esta corrida financiera?",""))
        return;
        document.getElementById("listaPaquetes").disabled = false;  
        document.getElementById("todospaq").disabled = false;  
        /* db.transaction(function(transaction){
          //var  sql="Delete * from productos";
          var  sql="Drop table productos";
          transaction.executeSql(sql,undefined,function(){
              alert('Corrida financiera borrada satisfacoriamente')
              //cuerpo.innerHTML = "";
              document.querySelector('#listaProductos').innerHTML="";
              document.getElementById("cargoinicial").innerHTML="0.00";
              document.getElementById("subsidios").innerHTML="0.00";
              document.getElementById("porpagar").innerHTML="0.00";              
          }, function(transaction,err){
                alert(err.message);
          }           
          );
        }) ; */
        eliminarTabla();
        return 0;
});

function eliminarTabla(){
    db.transaction(function(transaction){
        //var  sql="Delete * from productos";
        var  sql="Drop table productos";
        transaction.executeSql(sql,undefined,function(){
            //alert('Corrida financiera borrada satisfacoriamente')
            //cuerpo.innerHTML = "";
            document.querySelector('#listaProductos').innerHTML="";
            document.getElementById("cargoinicial").innerHTML="0.00";
            document.getElementById("subsidios").innerHTML="0.00";
            document.getElementById("porpagar").innerHTML="0.00";              
        }, function(transaction,err){
              alert(err.message);
        }           
        );
      }) ;  
}

function eliminarRegistro(){
   // alert('entre eliminar reg');
    //barre el documento buscando el boton
    $(document).one('click','button[type="button"]', function(event) {
        let id=this.id;
        var lista=[];
        $('#listaProductos').each(function(){            
            //busca  que tenga tr 
            var celdas=$(this).find(`tr${id}`);           
            //console.log(celdas);
            //alert(id);                   
        });              
       
        db.transaction(function(transaction){
            var sql= "DELETE from productos Where id="+id+";"
            transaction.executeSql(sql,undefined,function(){
                alert("Registro eliminado satisfactoriamente")                
            },function(transaction, err){
                alert(err.message);
            })
        })
        cargarDatos();
        limpiar();
    })
}

function activaBotones(){
    alert('activa botones');
    console.log('activa botones');
    document.querySelector("#insertar").style.display='inline-block';
    document.querySelector("#modificar").style.display='inline-block';
    document.querySelector("#insertar2").style.display='inline-block';
    document.querySelector("#modificar2").style.display='inline-block';
}
function inactivaBotones(){
    alert('desactiva botones');
    console.log('desactiva botones');
    document.querySelector("#insertar").style.display='none';
    document.querySelector("#modificar").style.display='none';
    document.querySelector("#insertar2").style.display='none';
    document.querySelector("#modificar2").style.display='none';

    //document.querySelector("#insertar").style.display='none';
}

function editarRegistro(){
    $(document).one('click','button[type="button"]', function(event) {
        let id=this.id;
        var lista=[];
        
             $("#listaProductos tr td").find('span.mid:eq(0)').each(function () {  
                //obtenemos el codigo de la celda
                 codigo = $(this).html();
                  //comparamos para ver si el código es igual a la busqueda
                  if(codigo==id){              
                       //aqui ya que tenemos el td que contiene el codigo utilizaremos parent para obtener el tr.
                       trDelResultado=$(this).parent().parent();
                       console.log(trDelResultado) ; 
                       
                       //ya que tenemos el tr seleccionado ahora podemos navegar a las otras celdas con find
                       campo0=trDelResultado.find("span.mid:eq(0)").html();
                       idselec=campo0;
                       console.log("campo 0:"+campo0);                      
                       campo1=trDelResultado.find("span:eq(1)").html();

                       //console.log("campo1"+campo1);                        
                       campo2=trDelResultado.find("span:eq(2)").html();
                       console.log("campo2: "+campo2);
                      // document.getElementById("precio").value=campo2;
                                              
                       campo3=trDelResultado.find("span:eq(3)").html();
                       //campo3=trDelResultado.find(":eq(5)").html();
                       console.log("campo 3:"+campo3);
                       

                        campo4=trDelResultado.find("span:eq(4)").html();
                        console.log("campo 4:"+campo4);

        
                       campotipo=trDelResultado.find(":eq(13)").html();
                       console.log("campo eq13:"+campotipo);

                      if  (campo4==1){
                       document.getElementById("ConceptoApertura").value=campo3;
                       document.getElementById("precio").value=campo2;
                       //inactivaBotones();
                       
                       document.querySelector("#insertar").style.display='none';
                       document.querySelector("#insertar2").style.display='none';
                       
                       document.querySelector("#modificar").style.display='inline-block';
                       document.querySelector("#modificar2").style.display='none';
                       
                      
                    }else{
                        document.getElementById("ConceptoApertura2").value=campo3;
                        document.getElementById("precio2").value=campo2;       
                        document.querySelector("#insertar").style.display='none';
                        document.querySelector("#modificar").style.display='none';
                        document.querySelector("#insertar2").style.display='none';   
                        //inactivaBotones();      
                       document.querySelector("#modificar2").style.display='inline-block';    
                    }                     
                       //mostramos el resultado en el div
                       //$("#mostrarResultado").html("El nombre es: "+nombre+", la edad es: "+edad)                       
                        
                       //encontradoResultado=true;
                  };
                });
                //  alert('fuera');  
    });
};
//modificar registro
$('#modificar').click(function(e){
    e.preventDefault();    
    var nidconcepto = document.getElementById('ConceptoApertura').value;
    var combom= document.getElementById('ConceptoApertura');
    var nitem = combom.options[combom.selectedIndex].text;
    var nprecio=$("#precio").val();
    console.log(idselec);
    db.transaction(function(transaction){
        
        var sql="UPDATE productos SET item='"+nitem+"', precio='"+nprecio+"' , idconcepto='"+nidconcepto+"' WHERE id="+idselec+";"        
         console.log(sql);
        transaction.executeSql(sql,undefined,function(){
            cargarDatos();
            document.querySelector("#insertar").style.display='inline-block';
            document.querySelector("#insertar2").style.display='inline-block';
            document.querySelector("#modificar").style.display='none';
            limpiar();
        },function(transaction,err){
            alert(err.message);
        });
        });
        
       return 0; 
});

$('#modificar2').click(function(e){
    e.preventDefault();
        //alert('entre a modificar 2');       
        var nidconcepto = document.getElementById('ConceptoApertura2').value;
        var combom= document.getElementById('ConceptoApertura2');
        var nitem = combom.options[combom.selectedIndex].text;
        var nprecio=$("#precio2").val();
        console.log(idselec);
        db.transaction(function(transaction){            
            var sql="UPDATE productos SET item='"+nitem+"', precio='"+nprecio+"' , idconcepto='"+nidconcepto+"' WHERE id="+idselec+";"        
             console.log(sql);
            transaction.executeSql(sql,undefined,function(){
                cargarDatos();
                document.querySelector("#insertar").style.display='inline-block';
                document.querySelector("#insertar2").style.display='inline-block';
                document.querySelector("#modificar2").style.display='none';
                limpiar();
            },function(transaction,err){
                alert(err.message);
            });
            });
});    

$('#guardacredito').click(function(e){
    //alert('guardacredito');
   // debugger;
    var concargos=document.getElementById('cargosiniciales').value;
    if (concargos==1){
        document.getElementById("guardarFinal").disabled = false;
       // alert('guarda final');
    }else{    
        document.getElementById("guardarFinalSinConc").disabled = false;
        //alert('guarda final sin ');
    }  

    document.querySelector('#checkgeo3').style.display='inline-block';

        document.querySelector("#insertar").style.display='none';
        document.querySelector("#insertar2").style.display='none';
        document.querySelector("#modificar").style.display='none';
        document.querySelector("#modificar2").style.display='none';
                
    //$("#collapseThree").toggle(); 
    
    //$("#guardarCorrida").prop('disabled', false); 
})

$('#guardarCorrida').click(function(e){
    document.querySelector('#checkgeo2').style.display='inline-block';

        document.querySelector("#insertar").style.display='none';
        document.querySelector("#insertar2").style.display='none';
        document.querySelector("#modificar").style.display='none';
        document.querySelector("#modificar2").style.display='none';
                
    $("#collapseTwo").toggle(); 
    var adeudo=document.getElementById('porpagar').innerHTML;
    console.log('adeudo:'+parseFloat(adeudo));
    //if (adeudo>0){
        
        $("#collapseThree").toggle(); 
        document.getElementById("TasaAnualFin").select();
    //}
})



function cargarDatos(){    
    
    $("#listaProductos").children().remove();   
    var tcargos=0;
    var tabonos=0;
    var tcredito=0;
    var cargacorrida=[];
    db.transaction(function(transaction) {
       // alert('entre a carga datos');
       // console.log('entre a carga datos');
        var sql="SELECT * FROM productos ";
        transaction.executeSql(sql,undefined ,function(transaction,result){
            if (result.rows.length){                
                $("#listaProductos").append('<tr style="background:lightskyblue; height: 30px; font-size: 14px;"><th>Codigo</th><th>Concepto</th><th >Monto</th><th style="display:none">idConcepto</th><th style="display:none">idTipoConcepto</th><th>paq</th><th></th><th></th>');
                //$("#listaProductos").append('<tr style="background:lightskyblue; height: 30px; font-size: 14px;"><th>Codigo</th><th>Concepto</th><th >Monto</th><th style="display:none">idConcepto</th><th style="display:none">idTipoConcepto</th><th></th><th></th>');
                //$("#listaProductos").append('<tr><th>Codigo</th><th>Concepto</th><th>Monto</th><th style="visibility: hidden">idConcepto</th><th></th><th></th>');
                for (var i=0; i<result.rows.length; i++){
                    var row=result.rows.item(i);
                    var item=row.item;
                    var id=row.id;
                    var precio=row.precio;
                    var idconcepto=row.idConcepto;                    
                    var idtipoconcepto=row.idTipoConcepto;
                    var paqs=row.paqs;
                    console.log("paqs: "+ paqs);    
                    //
                    var fila = {
                        id,
                        item,
                        idconcepto,
                        precio,
                        idtipoconcepto,
                        paqs    
                    };
                    cargacorrida.push(row);
                    console.log('la fila dice' +fila);
                   
                    //    

                        console.log('idconcepto='+idtipoconcepto);
                        if (idtipoconcepto==1){
                            tcargos= parseFloat(tcargos)+parseFloat(precio);
                            //alert('cargos:'+tcargos);
                            document.getElementById("cargoinicial").innerHTML=parseFloat(tcargos).toFixed(2);                            
                        }
                        if (idtipoconcepto==2){
                            tabonos= parseFloat(tabonos)+parseFloat(precio);
                            //alert('abonos:'+tabonos);
                            console.log('credito :'+tcredito);                           
                            document.getElementById("subsidios").innerHTML=parseFloat(tabonos).toFixed(2);                           
                        }    
                        tcredito=parseFloat(tcargos)-parseFloat(tabonos);
                        document.getElementById("porpagar").innerHTML=parseFloat(tcredito).toFixed(2);
                        

                        document.getElementById("montocredito").value=parseFloat(tcargos).toFixed(2);
                        document.getElementById("montocredito2").value=parseFloat(tcargos);
                        
                        document.getElementById("TotSubs").value=parseFloat(tabonos).toFixed(2);
                        document.getElementById("TotFinan").value=parseFloat(tcredito).toFixed(2);
                        if (parseFloat(tcredito)<0){
                            document.getElementById("porpagar").style.color = "red";                            
                        }else{
                            document.getElementById("porpagar").style.color = "black";                            
                        }
                    $("#listaProductos").append(`<tr id="${id}" style="height: 30px; font-size: 14px; vertical-align: top;"><td><span class="mid">${id}</span></td><td><span>${item}</span></td><td style="text-align: end;"><span>${precio}</span></td><td style="display:none"><span>${idconcepto}</span></td><td style="display:none"><span>${idtipoconcepto}</span></td> <td ><span>${paqs}</span></td><td style="text-align:center; vertical-align: top;"><button type='button' id="${id}" class='btn btn-success' onclick='editarRegistro()' style="height: 25px; font-size: 13px; ">Editar</button></td><td style="text-align:center; vertical-align: top;"><button type='button' id="${id}" class='btn btn-danger' onclick='eliminarRegistro()' style="height: 25px; font-size: 13px;">Eliminar</button></td>`);   
                    //$("#listaProductos").append(`<tr id="${id}" style="height: 30px; font-size: 14px; vertical-align: top;"><td><span class="mid">${id}</span></td><td><span>${item}</span></td><td style="text-align: end;"><span>${precio}</span></td><td style="display:none"><span>${idconcepto}</span></td><td style="display:none"><span>${idtipoconcepto}</span></td> <td style="text-align:center; vertical-align: top;"><button type='button' id="${id}" class='btn btn-success' onclick='editarRegistro()' style="height: 25px; font-size: 13px; ">Editar</button></td><td style="text-align:center; vertical-align: top;"><button type='button' id="${id}" class='btn btn-danger' onclick='eliminarRegistro()' style="height: 25px; font-size: 13px;">Eliminar</button></td>`);
                    
                    //class="Reg_A${id}"  button--Reg_A
                        // $("#listaProductos").append('<tr id="fila'+id+'" class="Reg_A'+id+'"><td><span class=mid">A'+
                        // id+'</span></td><td><span>'+item+'</span></td><td><span>'+
                        // precio+'</span></td>Editar<td></td><td>Eliminar</td>');
                        document.getElementById("listaPaquetes").disabled = true;  
                        document.getElementById("todospaq").disabled = true;     
                }            
              
               result = JSON.stringify(cargacorrida);             
               document.getElementById('tablacorrida').value = result;
               //traearray(cargacorrida);

            }else{
                $("#listaProductos").append('<tr><td colspan="5" aling="center">No hay registros</td><tr>');
            }
        }, function(transaction, err){
           // alert('No se pudo cargar información, no existe u ocurrió un error');
            //alert(err.message);
        });

    }); 
   // return 0;
};

//Acordeon

$('#acordgeo').click(function(){
    $("#collapseOne").toggle();  
    //cargarDatos();  
})

$('#acordcorrida').click(function(){
    $("#collapseTwo").toggle();    
   // document.querySelector('#mont').style.background='red';
    cargarDatos();
})

$('#acordfinan').click(function(){
    $("#collapseThree").toggle();      
    cargarDatos();
})

//seccion seleccion geografica

$('#atodos').click(function(e){
    //$('#atodos').click(function(e){    
    e.preventDefault();
   // alert ('recibi click');
       document.querySelector('#geo1').style.display='inline-block';
       document.querySelector('#geo2').style.display='none';
       document.querySelector('#geo3').style.display='none';         
       return 0; 
})

$('#adelegaciones').click(function(e){
    //$('#atodos').click(function(e){    
    e.preventDefault();
    //alert ('recibi click');
       document.querySelector('#geo1').style.display='none';
       document.querySelector('#geo2').style.display='inline-block';
       document.querySelector('#geo3').style.display='none';   
       return 0; 
})

$('#amunicipios').click(function(e){
    //$('#atodos').click(function(e){    
    e.preventDefault();
    //alert ('recibi click');
       document.querySelector('#geo1').style.display='none';
       document.querySelector('#geo2').style.display='none';
       document.querySelector('#geo3').style.display='inline-block';   
       return 0; 
})


$('#btngeo1').click(function(e){
    e.preventDefault();
    //alert('dio aceptar 1');   
    var tipoasig=document.getElementById('tipoasignacion').value;
    //console.log('tipo='+tipoasig);
    document.querySelector('#checkgeo').style.display='inline-block';   


    $('#areaaplicacion').val('T');    
    $('#ch1').val('1');
    //if 
    //$('#listaaplicaciongeo').val('');
    
    //deseleccionar_municipios();
    //deselecciona_dos();    
    //deseleccionar_municipios();     
    
    $("#collapseOne").toggle(); 
    
    if (tipoasig==0){
        //alert('aqui cero');
        $("#collapseTwo").toggle();    
    }else{
        alert('no entro a cero');
    }
    //window.addEventListener('load',deseleccionar_delegaciones,false);
    deseleccionar_delegaciones(); 
    
})

$('#btngeo2').click(function(e){
    e.preventDefault();  
    document.querySelector('#checkgeo').style.display='inline-block';  
    $('#areaaplicacion').val('D'); 
    $('#ch1').val('1');
    $("#collapseOne").toggle(); 
    deseleccionar_municipios();
    
       
})
$('#btngeo3').click(function(e){
    console.log('presiono boton');
    
    e.preventDefault();   
    document.querySelector('#checkgeo').style.display='inline-block';
    //var listapx=$("#listaPaquetes").val();

    //var listapx = document.getElementById('listaPaquetes').value;
        //console.log('op2'+idpaq);
      //  $('#listapaq').val(listapx);    


    //console.log(listapx);
    //document.getElementById('listaPaquetes').value;

    //document.getElementById("listapaq").value=listapx;
//alert('listapaq'+listapx);
   // $('#listapaq').val(listapx);
    $('#areaaplicacion').val('M');
    $('#ch1').val('1');
    $("#collapseOne").toggle();  
   // deseleccionar_delegaciones();     
      
})

function deselecciona_dos(){    
    deseleccionar_municipios();     
   // deseleccionar_delegaciones(); 
};

function deseleccionar_delegaciones(){
    //e.preventDefault();
    // alert('entre a deseleccionar');      
     var geo2=document.querySelector('#geo2');     
      console.log(geo2);
      var hijos=geo2.childNodes;
      for(i=0;i<geo2.childElementCount;i++){
          console.log(hijos[i].innerHTML);
         // hijos[i].style.color='red';
          if (hijos[i].firstChild.type=="checkbox" ){
            var chek=hijos[i].firstChild.checked;
            if (chek){
              //  hijos[i].style.color='green';
                hijos[i].firstChild.click();
            }else{
                console.log('no esta check');
            }
          }else{
              console.log(hijos[i].firstChild.type);
              console.log(hijos[i].firstChild.select);            
          }
      }
    }

function  deseleccionar_municipios(){
//    function  dx_municipios(){    
   // e.preventDefault();
   //  alert('entre a deseleccionar municipios');      
     var geo3=document.querySelector('#geo3');     
     console.log(geo3);
     var hijos=geo3.childNodes;
     for(i=0;i<geo3.childElementCount;i++){
         console.log(hijos[i].innerHTML);
        // hijos[i].style.color='red';
         if (hijos[i].firstChild.type=="checkbox" ){
           var chek=hijos[i].firstChild.checked;
           if (chek){
             //  hijos[i].style.color='green';
               hijos[i].firstChild.click();
           }else{
               console.log('no esta check');
           }
         }else{
             console.log(hijos[i].firstChild.type);
             console.log(hijos[i].firstChild.select);            
         }

}; 
}

//seccion datos financieros
 function seleccionasigTIM() {
    document.getElementById("TasaIntMora").select();     
 }
/* document.getElementById("TipoIntMoratorio").onchange = function()  {   
    document.getElementById("TasaIntMora").select();    
   
   } */

//    document.getElementById('TipoIntMoratorio').addEventListener('change', function () {
//     document.getElementById("TasaIntMora").select(); 
// }, false);


//document.getElementById("IdPagoInicial").onchange = function()  {   
function seleccionasigIDPI(){    
 var idpagoinicial = document.getElementById('IdPagoInicial').value;
 //alert('selecciono algo'+ idpagoinicial);
 if (idpagoinicial==0){
   // alert('desahabilite');     
     document.getElementById("MontoPagoInicial").value=0;
     document.getElementById("MontoPagoInicial2").value=0;
     document.getElementById("MontoPagoInicial").disabled = true;
     document.getElementById("TotalPagos").select();
     //focus();
 }else{
    document.getElementById("MontoPagoInicial").disabled = false;
    document.getElementById("MontoPagoInicial").select();
    //alert('lo volvi a habilitar');
 }

}
 

  //document.getElementById("MontoPagoInicial").onchange= function()  {   
 function dejacampoMPI(){   
    //alert('entre a pagoini');
    //var totalCredito=$("#mont").val();
    var montopagoinicial=$("#MontoPagoInicial").val();
    var totalCredito=$("#montocredito").val();
    var descuentos=$("#TotSubs").val(); 
    console.log('credito='+totalCredito);
    console.log('subs='+descuentos);
    var saldo=totalCredito=totalCredito-descuentos;
    console.log('saldo='+saldo);
    var enganche=$("#MontoPagoInicial").val();
    saldo=saldo-enganche;
    console.log('saldofin:'+saldo);
    document.getElementById("TotFinan").value=parseFloat(saldo).toFixed(2);
    $("#montopagoinicial2").val(montopagoinicial);
    console.log('montopagoinicial2:'+montopagoinicial);
  }

/* document.getElementById("TotalPagos").onchange = function() {  
    alert('entre a totalpagos');
    var montofinanciar=$("#TotFinan").val();
    var pagoinicial=$("#MontoPagoInicial").val();
    var totalpagos= $("#TotalPagos").val(); 
    var tasafin= $("#TasaAnualFin").val();
    alert(montofinanciar+','+pagoinicial+','+totalpagos)
    $.ajax({
        url: 'prog_recibedatos.php',
                            type: 'post',			
                            data: { montofinanciar:montofinanciar, 
                                    totalpagos:totalpagos,tasafin:tasafin},
        success: function(data){
        $('#resultado').html(data);
        var separa = data.split(",");
        document.getElementById("MontoPago").value=separa[0];
        document.getElementById("MontoUltimoPago").value=separa[1];      
        console.log(data);
        }
    });
} */

  $('#calccorrida').click(function(e){
       e.preventDefault(); 
      //alert('entre a totalpagos');
      var montofinanciar=$("#TotFinan").val();
      var pagoinicial=$("#MontoPagoInicial").val();
      var totalpagos= $("#TotalPagos").val(); 
      var tasafin= $("#TasaAnualFin").val();
      //alert(montofinanciar+','+pagoinicial+','+totalpagos)
      $.ajax({
          url: 'prog_recibedatos.php',
                              type: 'post',			
                              data: { montofinanciar:montofinanciar, 
                                      totalpagos:totalpagos,tasafin:tasafin},
          success: function(data){
          $('#resultado').html(data);
          var separa = data.split(",");
          document.getElementById("MontoPago").value=separa[0];
          document.getElementById("MontoUltimoPago").value=separa[1];
         
          console.log(data);
          }
      });
  })


/* document.getElementById("MontoPago").onchange = function() {
     alert('entre a Montopago');
     var montofinanciar=$("#TotFinan").val();    
     var totalpagos=0; 
     var tasafin= $("#TasaAnualFin").val();
     var montopago= $("#MontoPago").val();
     var view_data;
     alert(montofinanciar+','+montopago+','+totalpagos)
     $.ajax({
         url: 'lib/fnv_corridaxMontoMens.php',
                            //dataType: 'json',
                             type: 'post',		                             	
                             data: { montofinanciar:montofinanciar, 
                                     totalpagos:totalpagos,tasafin:tasafin,montopago:montopago},
                    // success:function(response_data_json) {
                    // view_data = response_data_json.view_data;
                    // console.log(view_data);    
          success: function(data){
             console.log(data[1]);
         $('#resultado').html(data);               
         document.getElementById("TotalPagos").value=data[3];
         //$("#MontoPago").val()=separa[0];
         //$("#MontoUltimoPago").val()=separa[1];   
         //$('#TotalPagos').html(data[1]);     
         }
     });
 } */

 /* $('#guardarFinal').click(function(e){
     e.preventDefault();
     var prob=0;
    if (document.querySelector('#checkgeo').style.display=='none'){
        alert('No ha elegido la Aplicación Geográfica');
        prob=1;
    }
    if (document.querySelector('#checkgeo2').style.display=='none'){
        alert('No ha registrado los conceptos para la Corrida Financiera');
        prob=1;
    }
    if (prob==1){
        alert('COMPLETE EL REGISTRO ANTES DE GUARDAR');
    }else{
        alert('GUARDADO CON EXITO');
    }
 })
 */
 

  $(document).ready(function() {

     $('[name="delegaciones[]"]').click(function() {
        
       var arr = $('[name="delegaciones[]"]:checked').map(function(){
        return this.value;
       }).get();
      
       var str = arr.join(',');
      
       $('#listaaplicaciongeo').text(JSON.stringify(arr));
      
       $('#listaaplicaciongeo').text(str);
      
       $('#listaaplicaciongeo').val(str);
       //localStorage.setItem('lista', str);
     
      console.log('str:'+str);
     });
    
     });
    
     $(document).ready(function() {

        $('[name="municipios[]"]').click(function() {
           
          var arr = $('[name="municipios[]"]:checked').map(function(){
           return this.value;
          }).get();
         
          var str = arr.join(',');
         
          $('#listaaplicaciongeo').text(JSON.stringify(arr));
         
          $('#listaaplicaciongeo').text(str);
         
          $('#listaaplicaciongeo').val(str);
          //localStorage.setItem('lista', str);
        
         console.log('str:'+str);
        });
       
        });

  function traearray(){
  
    alert("entre a traearray");    
   console.log("entre a traearray");    
    var prob=0;
   
    //if (document.querySelector('#checkgeo').style.display=='none'){
    if ( $("#areaaplicacion").val()==""){    
        alert('No ha elegido la Aplicación Geográfica');
        prob=1;
    }
    // var tipoprog=$("#idtipoprograma").val(); 
    // alert(tipoprog);
    
    //if (tipoprog!=2){
    if (cargosiniciales==1){
         if (document.querySelector('#checkgeo2').style.display=='none'){
            alert('No ha registrado los conceptos para la Corrida Financiera');
            prob=1;
        } 
    }    
    
    if (prob==1){
        alert('COMPLETE EL REGISTRO ANTES DE GUARDAR');

    }else{
    //
        console.log('entre al else');
      var arrayFinal=document.getElementById('tablacorrida').value;
      var idprograma=document.getElementById('idprograma').value;
      var usuario=document.getElementById('usuario').value;
      var areaap=document.getElementById('listaaplicaciongeo').value;
      alert(areaap);
     //console.log('area'+areaap);
     // document.getElementById('area2').value=areaap;
      //var area=document.getElementById('areaaplicacion').value;
      document.getElementById('correcto').value=0;

     // console.log('llegue aqui usuario'+usuario+ 'y area:'+areaap);
     // alert(arrayFinal);
        $.ajax({
            url: 'programasinsert.php',
            type: 'post',			
            data: {areaap:areaap, arrayFinal: arrayFinal, idprograma: idprograma, usuario: usuario},
            //, tipoprog:tipoprog
            success: function(data){
            //$('#respuesta').html(data);
        // alert(data);
            console.log(data);
            
            alert('conceptos iniciales registrados');
            }            
        }); 

        eliminarTabla();
    };
  //};
}     
//data: { montofinanciar:montofinanciar, pagoinicial:pagoinicial,
//document.getElementById("MontoPagoInicial").onchange = function() {calculatotfinanciar()}



//if (typeof foo == 'undefined') {
   // console.log('undefined');
    
   
   
//    var formul=document.querySelector("#FormApertura");
//    // var formul=document.querySelector("#formgral");
//     formul.addEventListener('submit',() => {
//             alert(' presiono RegistraApertura');
//             console.log('presiono');

            // var tabla = document.querySelector("#tablaconcepto");
            // var concepto = document.querySelector("#ConceptoApertura").value;
            // var texto=document.querySelector("#section3");
            // texto.innerHTML="texto que escribi";
            // console. log(texto);
            //var nuevoconcepto = document.createElement('td');
            //console.log(concepto);
            //nuevoconcepto.append(concepto);
            //tabla.append(nuevoconcepto);
       // });
  //  }else {
    //    console.log('definido');
    //}
    //nuevoconcepto.append("monto");
    //nuevoconcepto.append("edita");
    //nuevoconcepto.append("elimina");
    
   // })