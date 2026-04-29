<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<?php

/* if(isset($_GET['ID']))
{

   echo "<br>";
   echo "<br>";
   $sql ="    select   *
   from    catdesarrolladores
   WHERE IdDesarrollador ".$_GET['ID'];
   echo "<a href='#Registro'></a>";
   $rc= $Vivienda -> query($sql);
	 $row_cnt = $rc->num_rows;
		$cont=0;
		if($row_cnt>0)
		{
		  while($valor = $rc -> fetch_array())
		  {
        $nombre=$valor['NumContrato'];
        echo "Nombre<input name='nombre' value='".$valor['Nombre']."' class='form-control mr-sm-2' type='search' placeholder='' aria-label='first' style='width: 100%; height: 25;'>";   
      
      }  
    } 
}else{   */

   echo "<h1>MODULO DE DESARROLLADORES</h1>";

echo "<div class='row'>";
  // menú
  echo "<div class='col-sm-2 admin-sidebar'>";
    echo "<div class='nav flex-column nav-pills text-center text-uppercase admin-nav' id='sidebar-admin' role='tablist' aria-orientation='vertical'>";
    echo "<a class='nav-link active show admin-nav-item admin-sidebar-item'  data-toggle='pill' href='#Catalogo' role='tab' aria-controls='admin-communicate' aria-selected='true' id='Cat'>Catalogo</a>";
    //echo "<a class='nav-link active show admin-nav-item admin-sidebar-item'  data-toggle='pill' href='#admin-communicate' role='tab' aria-controls='admin-communicate' aria-selected='true'>Catálogo</a>";
    echo "<a class='nav-link admin-nav-item admin-sidebar-item' data-toggle='pill' href='#Registro' role='tab' aria-controls='admin-requests' aria-selected='false' id='Reg'>Registro</a>";
    echo "<a class='nav-link admin-nav-item admin-sidebar-item' data-toggle='pill' href='#admin-users' role='tab' aria-controls='admin-users' aria-selected='false'>Users</a>";
    echo "<a class='nav-link admin-nav-item admin-sidebar-item' data-toggle='pill' href='#admin-groups' role='tab' aria-controls='admin-groups' aria-selected='false'>Groups</a>";
    echo "<a class='nav-link admin-nav-item admin-sidebar-item' data-toggle='pill' href='#admin-analytics' role='tab' aria-controls='admin-analytics' aria-selected='false'>Analytics</a>";
    echo "<a class='nav-link admin-nav-item admin-sidebar-item' data-toggle='pill' href='#admin-messages' role='tab' aria-controls='admin-messages' aria-selected='false'>Messages</a>";
    echo "<a class='nav-link admin-nav-item admin-sidebar-item' data-toggle='pill' href='#admin-sessions' role='tab' aria-controls='admin-sessions' aria-selected='false'>Sessions</a>";
    echo "<a class='nav-link admin-nav-item admin-sidebar-item' data-toggle='pill' href='#admin-testimonials' role='tab' aria-controls='admin-testimonials' aria-selected='false'>Testimonials</a>";
    echo "<a class='nav-link admin-nav-item admin-sidebar-item' data-toggle='pill' href='#admin-changelog' role='tab' aria-controls='admin-changelog' aria-selected='false'>Changelog</a>";
    echo "</div>";
  echo "</div>";

  /* echo "<div class='col-sm-12 admin-tabs'>";
    echo "<ul class='nav nav-tabs admin-nav text-uppercase' role='tablist'>";
      echo "<li class='nav-item'>";
        echo "<a class='nav-link admin-nav-item active' data-toggle='tab' href='#admin-communicate' role='tab' aria-controls='admin-communicate' aria-selected='true'>Communicate</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
        echo "<a class='nav-link admin-nav-item' data-toggle='tab' href='#admin-requests' role='tab' aria-controls='admin-requests' aria-selected='false'>Requests</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
        echo "<a class='nav-link admin-nav-item' data-toggle='tab' href='#admin-users' role='tab' aria-controls='admin-users' aria-selected='false'>Users</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
        echo "<a class='nav-link admin-nav-item' data-toggle='tab' href='#admin-groups' role='tab' aria-controls='admin-groups' aria-selected='false'>Groups</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
        echo "<a class='nav-link admin-nav-item' data-toggle='tab' href='#admin-analytics' role='tab' aria-controls='admin-analytics' aria-selected='false'>Analytics</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
        echo "<a class='nav-link admin-nav-item' data-toggle='tab' href='#admin-messages' role='tab' aria-controls='admin-messages' aria-selected='false'>Messages</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
        echo "<a class='nav-link admin-nav-item' data-toggle='tab' href='#admin-sessions' role='tab' aria-controls='admin-sessions' aria-selected='false'>Sessions</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
        echo "<a class='nav-link admin-nav-item' data-toggle='tab' href='#admin-testimonials' role='tab' aria-controls='admin-testimonials' aria-selected='false'>Testimonials</a>";
      echo "</li>";
      echo "<li class='nav-item'>";
        echo "<a class='nav-link admin-nav-item' data-toggle='tab' href='#admin-changelog' role='tab' aria-controls='admin-changelog' aria-selected='false'>Changelog</a>";
      echo "</li>";
    echo "</ul>";
  echo "</div>"; */
  echo "<div class='col-sm-10'>";
    echo "<div class='tab-content'>";

    //Catalogo
    echo "<div class='tab-pane fade active show' id='Catalogo' role='tabpanel' aria-labelledby='admin-communicate-tab'>";
    //echo "<div class='tab-pane fade' id='Catalogo' role='tabpanel' aria-labelledby='admin-requests-tab'>";
    echo "<ul class='nav nav-pills nav-fill'>";
      echo "<li class='nav-item'>";
        echo "<h4><a class='nav-link admin-header-block'>Catálogo de Desarrolladores</a></h4>";
             // echo "<h1>aqui va la tabla</h1>";
             $sql="SELECT IdDesarrollador as ID, Nombre, Representante_Legal,  DomicilioFiscal, Telefono, 
             CONCAT(' <button onclick=\"funciondes(',IdDesarrollador,'); \"><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar trámiete\"><center></button>')     as ''
           from catdesarrolladores ORDER BY Nombre";
              
              //CONCAT(' <button onclick=\"funciondes(',IdDesarrollador,'); muestraDatos();\"><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar trámiete\"><center></button>')     as ''

              //TablaDinamica_MySQLVivienda("",$sql, "tramitesBusquedaTabla", "tramitesBusquedaTablaid", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
              TablaDinamica_MySQLVivienda("",$sql, "DesarrolladoresTabla", "DesarrolladoresTablaid", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
      echo "</li>";
    echo "</ul>";
    echo "<p>Catálogo de Desarrolladores</p>";
    echo "</div>";



     //Registro
      echo "<div class='tab-pane fade ' id='Registro' role='tabpanel' aria-labelledby='admin-requests-tab'>";
      //echo "<div class='tab-pane fade active show' id='Registro' role='tabpanel' aria-labelledby='admin-communicate-tab'>";
       //echo "<div class='tab-pane fade active show' id='admin-communicate' role='tabpanel' aria-labelledby='admin-communicate-tab'>";
        echo "<ul class='nav nav-pills nav-fill'>";
         echo " <li class='nav-item'>";
            echo "<h4><a class='nav-link admin-header-block'>Registro/Información de Desarrolladores</a></h4>";
          echo "</li>";
        echo "</ul>";
        echo "<nav class='navbar'>";
          echo "<form class='form-inline col-sm-12'>";           
              echo "<div class='container'>";   
                  echo "<div class='row' style='width:100%; display:contents;'>";
                      echo "<div class='col'>RFC<input  type='search' placeholder='RFC' aria-label='first' style=' height: 25;'></div>";
                      echo "<div class='col'>CURP<input   type='search' placeholder='CURP' aria-label='last' style=' height: 25;'></div>";
                      echo "<div class='col'>Teléfono<input  type='search' placeholder='Sólo números' aria-label='last' style=' height: 25;'></div>";
                  echo "</div>";
                  echo "<div class='row' style='width:100%;'>";
                    echo "Nombre<input name='nombre' id='nombre' class='form-control mr-sm-2' type='search' placeholder='' aria-label='first' style='width: 100%; height: 25;'>";              
                  echo "</div>";
                  echo "<div class='row' style='width:100%;'>";
                    echo "Representante legal<input name='representante' class='form-control mr-sm-2' type='search' placeholder='' aria-label='first' style='width: 100%; height: 25;'>";
                  echo "</div>";
                  echo "<div class='row' style='width:100%;'>";
                    echo "Domicilio Fiscal<input name='domicilio' class='form-control mr-sm-2' type='search' placeholder='' aria-label='first' style='width: 100%; height: 25;'>";
                  echo "</div>";
                  echo "<div class='row' style='width:100%;'>";
                    echo "Correo Electrónico<input name='correo' class='form-control mr-sm-2' type='search' placeholder='' aria-label='first' style='width: 100%; height: 25;'>";
                  echo "</div>";
                  echo "<div class='row' style='width:100%;'>";
                    echo "Nombre del contacto<input name='nombrecontac' class='form-control mr-sm-2' type='search' placeholder='' aria-label='first' style='width: 100%; height: 25;'>";
                  echo "</div>";
                  echo "<div class='row' style='width:70%;'>";
                    echo "Teléfono del contacto  <input name='telcontac' class='form-control mr-sm-2' type='search' placeholder='Solo números' aria-label='first' style='width: 50%; height: 25;'>";
                  echo "</div>";
                  echo "<div class='row' style='width:20%;'>";
                    echo "<div class='col'>ID<input  name='ID' type='search' id='ID' aria-label='last' style=' height: 25;' disabled></div>";
                  echo "</div>";
                  echo "<div class='row' style='width:100%;'>";
                    echo "<div  style='width:50%; background: border-box; display: block;  margin-left: auto;'><button  type='submit' id='guardarDesarr' name='guardarDesarr'  class='btn btn-primary' style='font-size:13px;' disabled >Guardar Desarrollador</button></div>"; 
                  echo "</div>";          
              echo "</div>"; 
          echo "</form>";
        echo "</nav>";
        echo "<p>Registro de Desarroladores</p>";
      echo "</div>";
      
      /* //Catalogo
      echo "<div class='tab-pane fade' id='Catalogo' role='tabpanel' aria-labelledby='admin-requests-tab'>";
        echo "<ul class='nav nav-pills nav-fill'>";
          echo "<li class='nav-item'>";
            echo "<h4><a class='nav-link admin-header-block'>Catálogo de Desarrolladores</a></h4>";
                 // echo "<h1>aqui va la tabla</h1>";
                  $sql="";
                  //$sql="SELECT IdDesarrollador as Clave, Nombre, RFC, Representante_Legal, CURP, DomicilioFiscal, Telefono, CorreoElectronico,Contacto_Empresa, TelContacto from catdesarrolladores ORDER BY Nombre";
                  $sql="SELECT IdDesarrollador as ID, Nombre, Representante_Legal,  DomicilioFiscal, Telefono, 
                  CONCAT(' <a  href=#Registro?ID=',IdDesarrollador,'><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar trámiete\"><center></a>')     as ''
                  from catdesarrolladores ORDER BY Nombre";
                  
                  //TablaDinamica_MySQLVivienda("",$sql, "tramitesBusquedaTabla", "tramitesBusquedaTablaid", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
                  TablaDinamica_MySQLVivienda("",$sql, "DesarrolladoresTabla", "DesarrolladoresTablaid", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
          echo "</li>";
        echo "</ul>";
        echo "<p>Requests</p>";
      echo "</div>";
 */
      echo "<div class='tab-pane fade' id='admin-users' role='tabpanel' aria-labelledby='admin-users-tab'>";
        echo "<ul class='nav nav-pills nav-fill'>";
          echo "<li class='nav-item'>";
            echo "<h4><a class='nav-link admin-header-block'>Admin Portal - Users (TOTAL TODO)</a></h4>";
          echo "</li>";
        echo "</ul>";
        echo "<div class='container mt-4 mb-5'>";
            echo "<div class='row'>";
                echo "<div class='col-md-4'>";
                    echo "<div class='card text-center admin-user-card'>";
                        echo "<div class='card-header'>Account Type</div>";
                        echo "<div class='card-block p-3'>";
                            echo "<h4 class='card-title'>Name</h4>";
                            echo "<p class='card-text'>Information</p>";
                            echo "<a href='#' class='btn btn-primary rounded-0 mb-2'>Enable / Disabled</a>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                echo "<div class='col-md-4'>";
                    echo "<div class='card text-center admin-user-card'>";
                        echo "<div class='card-header'>Account Type</div>";
                        echo "<div class='card-block p-3'>";
                            echo "<h4 class='card-title'>Name</h4>";
                            echo "<p class='card-text'>Information</p>";
                            echo "<a href='#' class='btn btn-primary rounded-0 mb-2'>Enable / Disabled</a>";
                        echo "</div>";
                   echo " </div>";
                echo "</div>";
                echo "<div class='col-md-4'>";
                    echo "<div class='card text-center admin-user-card'>";
                        echo "<div class='card-header'>Account Type</div>";
                        echo "<div class='card-block p-3'>";
                            echo "<h4 class='card-title'>Name</h4>";
                            echo "<p class='card-text'>Information</p>";
                            echo "<a href='#' class='btn btn-primary rounded-0 mb-2'>Enable / Disabled</a>";
                        echo "</div>";
                    echo "</div>";
               echo "</div>";
                echo "<div class='col-md-4'>";
                    echo "<div class='card text-center admin-user-card'>";
                        echo "<div class='card-header'>Account Type</div>";
                        echo "<div class='card-block p-3'>";
                           echo "<h4 class='card-title'>Name</h4>";
                            echo "<p class='card-text'>Information</p>";
                            echo "<a href='#' class='btn btn-primary rounded-0 mb-2'>Enable / Disabled</a>";
                        echo "</div>";
                   echo " </div>";
                echo "</div>";
                echo "<div class='col-md-4'>";
                    echo "<div class='card text-center admin-user-card'>";
                        echo "<div class='card-header'>Account Type</div>";
                        echo "<div class='card-block p-3'>";
                            echo "<h4 class='card-title'>Name</h4>";
                            echo "<p class='card-text'>Information</p>";
                            echo "<a href='#' class='btn btn-primary rounded-0 mb-2'>Enable / Disabled</a>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
        //<!-- Card -->
      echo "</div>";


      echo "<div class='tab-pane fade' id='admin-groups' role='tabpanel' aria-labelledby='admin-groups-tab'>";
        echo "<ul class='nav nav-pills nav-fill'>";
          echo "<li class='nav-item'>";
            echo "<h4><a class='nav-link admin-header-block'>Admin Portal - Groups (TOTAL TODO)</a></h4>";
          echo "</li>";
        echo "</ul>";
        echo "<p>Groups</p>";
      echo "</div>";


      echo "<div class='tab-pane fade' id='admin-analytics' role='tabpanel' aria-labelledby='admin-analytics-tab'>";
        echo "<ul class='nav nav-pills nav-fill'>";
          echo "<li class='nav-item'>";
            echo "<h4><a class='nav-link admin-header-block'>Admin Portal - Analytics</a></h4>";
          echo "</li>";
        echo "</ul>";
        echo "<p>Analytics</p>";
      echo "</div>";


      echo "<div class='tab-pane fade' id='admin-messages' role='tabpanel' aria-labelledby='admin-messages-tab'>";
        echo "<ul class='nav nav-pills nav-fill'>";
          echo "<li class='nav-item'>";
            echo "<h4><a class='nav-link admin-header-block'>Admin Portal - Messages (TOTAL TODO)</a></h4>";
          echo "</li>";
        echo "</ul>";
        echo "<p>Messages</p>";
      echo "</div>";


      echo "<div class='tab-pane fade' id='admin-sessions' role='tabpanel' aria-labelledby='admin-sessions-tab'>";
        echo "<ul class='nav nav-pills nav-fill'>";
          echo "<li class='nav-item'>";
           echo " <h4><a class='nav-link admin-header-block'>Admin Portal - Sessions (TOTAL TODO)</a></h4>";
          echo "</li>";
       echo " </ul>";
        echo "<p>Sessions</p>";
      echo "</div>";


      echo "<div class='tab-pane fade' id='admin-testimonials' role='tabpanel' aria-labelledby='admin-testimonials-tab'>";
        echo "<ul class='nav nav-pills nav-fill'>";
          echo "<li class='nav-item'>";
            echo "<h4><a class='nav-link admin-header-block'>Admin Portal - Sessions (TOTAL WRITTEN TODO)</a></h4>";
          echo "</li>";
        echo "</ul>";
        echo "<p>Testimonials</p>";
      echo "</div>";


      echo "<div class='tab-pane fade' id='admin-changelog' role='tabpanel' aria-labelledby='admin-changelog-tab'>";
        echo "<ul class='nav nav-pills nav-fill'>";
          echo "<li class='nav-item'>";
            echo "<h4><a class='nav-link admin-header-block'>Admin Portal - Changelog</a></h4>";
          echo "</li>";
        echo "</ul>";
        echo "<p>Changelog</p>";
      echo "</div>";

      
    echo "</div>";
  echo "</div>";


echo "</div>";
//};
?>

<script>
  function funciondes(id)
  {
    //console.log(id);
    $("#Cat").removeClass("active");
    $("#Reg").addClass("active");

    var cat = document.querySelector("#Cat");
        cat.setAttribute("aria-selected", "false");

    var reg = document.querySelector("#Reg");
    reg.setAttribute("aria-selected", "true");

    
    $("#ID").val(id);
    
    // var tabla= 'catdesarrolladores'
    
    $("#Catalogo").removeClass("active");
    $("#Registro").addClass("active");
    $("#Registro").addClass("show");    
    datos(id);
   
  }

   function datos(id){
     //var id=$("#ID").val();
     //alert("el id es : "+id);

      $.ajax({
             url: 'desarrExtraerRegistroId.php',
             type: 'post',	
            // dataType: 'json',		
             data: {id:id},             
             //success: function(data){
              success: function(data){  
               console.log('escribi:'+data); 
               //var js=JSON.parse(data); 
               //var js=json_decode(data); 
             //$('#nombre').val()=data[0];

           //  $('#resultado').html(data);  
          // var separa = data.split(",");             
         document.getElementById("nombre").value=data.nombre;
         //document.getElementById("MontoPago").value=separa[0];
         //$("#MontoPago").val()=separa[0];
         // alert(data);
             //console.log(js);
           
             
             }  
            // alert('regrese de funcion');    
         });   
   }

   /*function datos(id){
     alert("el id es : "+id);
   }*/
  </script>


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include ("./lib/body_footer.php"); ?>