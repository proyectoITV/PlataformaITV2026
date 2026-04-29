<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
require("viaticos_fun.php");
?>
<?php

$id_aplicacion ="viaticos"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos
//Niveles
// 1 = Crear y Editar
// 2 = Consulta

//Ajusta esta variable para ver el comportamiento


if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
   
    echo "<div id=req_contenedor style='background: white;width: 90%;'>" ;
    echo "<form action='viaticos_pdf_reporte.php' method='POST' enctype='multipart/form-data'>";    
    
    echo "<div>";    
        echo "<label for='idTipoReporte'>Seleccione el filtro por el que desea generar el reporte:";
            echo"<select name='idTipoReporte' id='idTipoReporte' required='required'>";		
                echo"<option value='' selected='selected'> Seleccione un tipo de reporte</option>";			
                echo"<option value='1'>Estatus Viaticos</option>
                <option value='2'>Gastados En viaticos</option>       
            </select>";
         echo "</label>";
    echo "</div>";


    echo "<div id='divparametro' name='divparametro' >";
    echo "<label   style='width: 100%;'>Seleccione el tipo de parametro:";
           echo "<select >";               
            echo "</select>";
    echo "</label>";			
echo "</div>";

    echo "<div id='dividestatus' name='dividestatus' style='display:none;'>";
        echo "<label for='idestatus'  style='width: 100%;'>Estatus:";
                echo "<select name='idestatus' id='idestatus'>";
                    echo "<option value='' selected>Seleccione una dirección...</option>";
                    echo"<option value='1'>Generados</option>";	    
                    echo"<option value='6'>Comprobados</option>";
                    echo"<option value='11'>No Comprobados</option>";                   	
                    echo"<option value='9'>Cancelados</option>";	    
                echo "</select>";
        echo "</label>";			
    echo "</div>";


    echo "<div id='divgastado' name='divgastado' style='display:none;'>";
    echo "<label id='gastadolbl' name='gastadolbl' for='gastado'  style='width: 100%;'>Filtro:";
            echo "<select name='gastado' id='gastado'>";
                echo "<option value='' selected>Seleccione una parametro...</option>";
                echo"<option value='1'>Direccion</option>";	    
                echo"<option value='2'>Departamento</option>";	
                echo"<option value='3'>Empleado</option>";	    
            echo "</select>";
    echo "</label>";			
echo "</div>";
   


    echo "<div id='divdireccion' name='divdireccion' style='display:none;'>";
		echo "<label for='iddireccion'  style='width: 100%;'>Direccion:";
		echo "<select name='iddireccion' id='iddireccion'>";
		//echo $iddir;
		$rc= $conexion -> query("select * from cat_gerarquia  where nivel = 'dir' order by nombre ASC");
		while($dir = $rc -> fetch_array()) 
		{
			echo "<option value='".$dir['id']."'>".$dir['nombre']."</option>";			
		}
		echo "<option value='' selected>Seleccione una dirección...</option>";
		echo "</select>";
		echo "</label>";			
	echo "</div>";

    echo "<div id='divdepartamento' name='divdepartamento' style='display:none;'>";
        echo "<label for='iddepartamento'  style='width: 100%;'>Departamento:";
        echo "<select name='iddepartamento' id='iddepartamento'>";
        //echo $iddir;
        $rc= $conexion -> query("select * from cat_gerarquia    order by nombre ASC");
        while($dir = $rc -> fetch_array()) 
        {
            echo "<option value='".$dir['id']."'>".$dir['nombre']."</option>";			
        }
        echo "<option value='' selected>Seleccione un departamento...</option>";
        echo "</select>";
        echo "</label>";			
    echo "</div>";

    echo "<div  id='divempleado' name='divempleado' style='display:none;'>";
        echo "<label for='empleado'  style='width: 100%;' >Empleado:";
        echo "<select name='empleado' id='empleado'>";
        //echo $iddir;
        $rc= $conexion -> query("select * from empleados  where estado not like '%baja%' order by nombre ASC");
        while($dir = $rc -> fetch_array()) 
        {
            echo "<option value='".$dir['nitavu']."'>".$dir['nombre']."</option>";			
        }
        echo "<option value='' selected>Seleccione un empleado...</option>";
        echo "</select>";
        echo "</label>";			
    echo "</div>";

        
    echo "<div>";
            echo "<div>";
            echo "<label>Desde:</label>";
            echo "<input type='date' name='fechaI' id='fechaI' value='".$fecha."'>";				
            echo "</div>";
            echo "<div>";
            echo "<label>Hasta:</label>";
            echo "<input type='date' name='fechaF' id='fechaF' value='".$fecha."'>";
            echo "</div>";
    echo "</div>";


    echo "<div>";
    echo "<label>Haga clic aqui</label>";
    echo "<input type='submit' name='' value='Consultar' class='Mbtn btn-danger'>";
    echo "</div>";
        
echo "</form>";	
echo "</div>";	
 

    }
    
    else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 
        
    ?>


<?php include ("./lib/body_footer.php"); ?>



<script>
    // A $( document ).ready() block.
$( document ).ready(function() {
  
    $("#idTipoReporte").val();
    $(document).on("change", "#idTipoReporte", function(event) 
    { 
        
        document.getElementById('divparametro').style.display = 'none';
       
        if ($("#idTipoReporte option:selected").val()==1)
        {
           
            document.getElementById('dividestatus').style.display = 'inline-block';
            
        }
        else
        {
            document.getElementById('dividestatus').style.display = 'none';
           
        }     
        if ($("#idTipoReporte option:selected").val()==2)
        {
           
            
            document.getElementById('gastadolbl').html('Filtro');
            document.getElementById('divgastado').style.display = 'inline-block';
            
        }else
        {
            document.getElementById('divgastado').style.display = 'none';
        }


        $(document).on("change", "#gastado", function(event) 
        {
            console.log($("#gastado option:selected").val());
            if ($("#gastado option:selected").val()==1)
            {
                document.getElementById('divdireccion').style.display = 'inline-block';
                document.getElementById('divdepartamento').style.display = 'none';
                document.getElementById('divempleado').style.display = 'none';
            }
            if ($("#gastado option:selected").val()==2)
            {
                document.getElementById('divdepartamento').style.display = 'inline-block';
                document.getElementById('divdireccion').style.display = 'none';               
                document.getElementById('divempleado').style.display = 'none';
            }if ($("#gastado option:selected").val()==3)
            {
                document.getElementById('divempleado').style.display = 'inline-block';
                document.getElementById('divdepartamento').style.display = 'none';
                document.getElementById('divdireccion').style.display = 'none';               
             
            }
        });     
    });



    $(document).on("change", "#dividestatus", function(event) 
        {
             
            document.getElementById('divgastado').style.display = 'inline-block';
            if ($("#gastado option:selected").val()==1)
            {
                document.getElementById('divdireccion').style.display = 'inline-block';
                document.getElementById('divdepartamento').style.display = 'none';
                document.getElementById('divempleado').style.display = 'none';
            }
            if ($("#gastado option:selected").val()==2)
            {
                document.getElementById('divdepartamento').style.display = 'inline-block';
                document.getElementById('divdireccion').style.display = 'none';               
                document.getElementById('divempleado').style.display = 'none';
            }if ($("#gastado option:selected").val()==3)
            {
                document.getElementById('divempleado').style.display = 'inline-block';
                document.getElementById('divdepartamento').style.display = 'none';
                document.getElementById('divdireccion').style.display = 'none';               
             
            }
        });     
});
    
$(document).on("change", "#idTipoReporte", function(event) 
    { 
        
        document.getElementById('divparametro').style.display = 'none';
       
        if ($("#idTipoReporte option:selected").val()==1)
        {
           
            document.getElementById('dividestatus').style.display = 'inline-block';
            
        }
        else
        {
            document.getElementById('dividestatus').style.display = 'none';
           
        }     
        if ($("#idTipoReporte option:selected").val()==2)
        {
           
           
            document.getElementById('divgastado').style.display = 'inline-block';
            
        }else
        {
            document.getElementById('divgastado').style.display = 'none';
        }


        $(document).on("change", "#gastado", function(event) 
        {
            console.log($("#gastado option:selected").val());
            if ($("#gastado option:selected").val()==1)
            {
                document.getElementById('divdireccion').style.display = 'inline-block';
                document.getElementById('divdepartamento').style.display = 'none';
                document.getElementById('divempleado').style.display = 'none';
            }
            if ($("#gastado option:selected").val()==2)
            {
                document.getElementById('divdepartamento').style.display = 'inline-block';
                document.getElementById('divdireccion').style.display = 'none';               
                document.getElementById('divempleado').style.display = 'none';
            }if ($("#gastado option:selected").val()==3)
            {
                document.getElementById('divempleado').style.display = 'inline-block';
                document.getElementById('divdepartamento').style.display = 'none';
                document.getElementById('divdireccion').style.display = 'none';               
             
            }
        });     
    });



    $(document).on("change", "#dividestatus", function(event) 
        {
             
            document.getElementById('divgastado').style.display = 'inline-block';
            if ($("#gastado option:selected").val()==1)
            {
                document.getElementById('divdireccion').style.display = 'inline-block';
                document.getElementById('divdepartamento').style.display = 'none';
                document.getElementById('divempleado').style.display = 'none';
            }
            if ($("#gastado option:selected").val()==2)
            {
                document.getElementById('divdepartamento').style.display = 'inline-block';
                document.getElementById('divdireccion').style.display = 'none';               
                document.getElementById('divempleado').style.display = 'none';
            }if ($("#gastado option:selected").val()==3)
            {
                document.getElementById('divempleado').style.display = 'inline-block';
                document.getElementById('divdepartamento').style.display = 'none';
                document.getElementById('divdireccion').style.display = 'none';               
             
            }
        });     
</script>