<?php include ("./lib/body_head.php");
include ("./lib/body_menu.php"); 
?>
<br><br>
<?php


//Tabla de requisitos agregados
echo "<div style='width:100%;'>";
    echo "<BR>";
    echo "<h1>Requisitos</h1>"; 
    echo " <a id='Vobo' href='#agregarRequisto' rel='MyModal:open' class='Mbtn btn-azulTam' title='Clic para marcar con Visto Bueno'>"; 
        echo "<table  width='100%'><tr><td valign='middle' align='center'>";
        echo "<img src='icon/ok2.png'> ";
        echo "</td>";
        echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
        echo "Agregar Requisito";
        echo "</td></tr></table>";    
    echo "</a>";  
    echo "<center>"; 
	echo "<table class=tabla>";
	echo "<th>Requisito</th><th>Tipo</th><th>Descricpión</th><th></th>";
    $sql = "SELECT * FROM tramitesrequisitos INNER JOIN tramitesrequisitoscat 
    ON tramitesrequisitos.IdCatRequisitos=tramitesrequisitoscat.IdCatRequisitos
    WHERE Cancelado='0'";
    
    $r2 = $conexion -> query($sql);
     while($f = $r2 -> fetch_array())
	{
        echo "<tr>";
     
        echo "<td>".$f['NombreRequisito']."</td>";
        echo "<td>".$f['TipoRequisito']."</td>";
        echo "<td>".$f['Descripcion']."</td>";
          echo "<td width=20px><a href='#EditatRequisto".$f['IdRequisito']."' rel='MyModal:open' >
                <img src='icon/edit.png' style='width:18px; height:18px;'></a>";
              
                //------------Modal editar requisito
            echo "<div id='EditatRequisto".$f['IdRequisito']."' class='MyModal'>";
            echo "<center>";
            echo "<h1>Editar requisito</h1>"; 
            echo "<form action='tr_requisitos.php?editar' method='POST'>";
            $sql = "SELECT * FROM tramitesrequisitos where Cancelado='0' and IdRequisito=".$f['IdRequisito'];          
            $r3 = $conexion -> query($sql);
             while($fx = $r3 -> fetch_array())
            {
            echo "<div>";
            echo '<label>Nombre del requisito</label>';
            echo "<input type='hidden' id='idrequisito' name='idrequisito' value='".$fx['IdRequisito']."'>";
            echo "<input type='text' id='requisito' name='requisito' value='".$fx['NombreRequisito']."'>";
            echo "</div>";

            echo "<div>";
            echo '<label>Tipo de requisito</label>';
                echo "<select name='tipo' id='tipo' style='margin-left: 0px; '>";	
             
                if($fx['TipoRequisito']=='text'){                 
                    echo "<option value='text' selected>Texto</option>";
                    echo "<option value='select'>Seleccion</option>";
                    echo "<option value='date'>Fecha</option>";	
                    echo "<option value='file'>Archivo</option>";
                }	
                else if ($fx['TipoRequisito']=='select')
                {   echo "<option value='text'>Texto</option>";
                    echo "<option value='select' selected>Seleccion</option>";
                    echo "<option value='date'>Fecha</option>";	
                    echo "<option value='file'>Archivo</option>";
                }
                else  if ($fx['TipoRequisito']=='date')
                {   echo "<option value='text' >Texto</option>";
                    echo "<option value='select'>Seleccion</option>";
                    echo "<option value='date' selectedFecha</option>";	
                    echo "<option value='file'>Archivo</option>";
                }
                else  if ($fx['TipoRequisito']=='file')  
                  { echo "<option value='text' >Texto</option>";
                    echo "<option value='select'>Seleccion</option>";
                    echo "<option value='date'>Fecha</option>";	
                    echo "<option value='file' selected>Archivo</option>";
                }
                else
               {
                echo "<option value='text'>Texto</option>";
                echo "<option value='select'>Seleccion</option>";
                echo "<option value='date'>Fecha</option>";	
                echo "<option value='file'>Archivo</option>";
               }
                        			
                echo "</select>";
            echo "</div>";

            echo "<div>";
            echo '<label>Descripción</label>';
            echo "<input type='text' id='descripcion' name='descripcion' value='".$fx['Descripcion']."'>";
            echo "</div>";

            echo "<div>";
            echo '<label>Categoria</label>';
                echo "<select name='categoria' id='categoria' >";
                $sql = "SELECT * FROM tramitesrequisitoscat ";
                $tmp="";
                $r4 = $conexion -> query($sql);
                while($r1 = $r4 -> fetch_array())
                    {
                        if($fx['IdCatRequisitos']==$r1['IdCatRequisitos']){
                            echo '<option value="'.$r1['IdCatRequisitos'].'" selected>'.$r1['Nombre'].'</option>';		
                            }else{
                                echo '<option value="'.$r1['IdCatRequisitos'].'">'.$r1['Nombre'].'</option>';		
                            }                 
                    }

                echo "</select>";
            echo "</div>";
           
            echo "<br>";
            echo "<button id='btnEditar'  class='Mbtn btn-default'  type='submit'>"; 
            echo "<table  width='100%'><tr><td valign='middle' align='center'>";
            echo "<img src='icon/ok2.png'> ";
            echo "</td>";
            echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
            echo "Guardar";
            echo "</td></tr></table></button>"; 
            }
            echo "</form>";
            echo "</center>";
            echo "</div>";
            echo "</td>";         
        echo "</tr>";
	}
    echo "</table>";
    echo "</center>";
    echo "</div>";
    






//------------Modal agregar observaciones para visto bueno
echo "<div id='agregarRequisto' class='MyModal'>";
echo "<center>";
echo "<h1>Agregar requisito</h1>"; 
echo "<form action='tr_requisitos.php?agregar' method='POST'>";

echo "<div>";
echo '<label>Nombre del requisito</label>';
echo "<input type='text' id='requisito' name='requisito' value=''>";
echo "</div>";

echo "<div>";
echo '<label>Tipo de requisito</label>';
    echo "<select name='tipo' id='tipo' style='margin-left: 0px; '>";					
			echo "<option value='text'>Texto</option>";
            echo "<option value='select'>Seleccion</option>";
            echo "<option value='date'>Fecha</option>";	
            echo "<option value='file'>Archivo</option>";				
	echo "</select>";
echo "</div>";

echo "<div>";
echo '<label>Descripción</label>';
echo "<input type='text' id='descripcion' name='descripcion' value=''>";
echo "</div>";

echo "<div>";
echo '<label>Categoria</label>';
    echo "<select name='categoria' id='categoria' >";
    $sql = "SELECT * FROM tramitesrequisitoscat ";
    $tmp="";
    $r2 = $conexion -> query($sql);
    while($fx = $r2 -> fetch_array())
        {
        echo '<option value="'.$fx['IdCatRequisitos'].'">'.$fx['Nombre'].'</option>';	
        }

    echo "</select>";
echo "</div>";

echo "<br>";
echo "<button id='btnAgregar'  class='Mbtn btn-default'  type='submit'>"; 
echo "<table  width='100%'><tr><td valign='middle' align='center'>";
   echo "<img src='icon/ok2.png'> ";
   echo "</td>";
   echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
   echo "Agregar";
   echo "</td></tr></table></button>"; 

echo "</form>";
echo "</center>";
echo "</div>";



//Agregar requisitos
if(isset($_GET['agregar'])){
$requisito=$_POST['requisito'];
$tipo=$_POST['tipo'];
$opcional=$_POST['opcional'];
$descripcion=$_POST['descripcion'];
$categoria=$_POST['categoria'];
$clase=$_POST['clase'];
$sql = "INSERT INTO tramitesrequisitos (NombreRequisito, TipoRequisito, NitavuCaptura, fecha, hora, descripcion,IdCatRequisitos)
VALUES  ('$requisito', '$tipo', '$nitavu', '$fecha', '$hora','$descripcion',$categoria)";

//echo $sql;
if ($conexion->query($sql) == TRUE)
{     
    mensaje('Requisito agregado correctamente','tr_requisitos.php');
}
else 
{
    mensaje('Hubo un error al agregar el requisito','tr_requisitos.php'); 
}


}

//Agregar requisitos
if(isset($_GET['editar'])){
    $idrequisito=$_POST['idrequisito'];
    $requisito=$_POST['requisito'];
    $tipo=$_POST['tipo'];    
    $descripcion=$_POST['descripcion'];
    $categoria=$_POST['categoria'];
   
 
    $sql = "Update  tramitesrequisitos set
    NombreRequisito='".$requisito."', TipoRequisito='".$tipo."' ,NitavuCaptura='".$nitavu."'
    , fecha='".$fecha."', hora='".$hora."',  descripcion='".$descripcion."',IdCatRequisitos=".$categoria." where IdRequisito=".$idrequisito;
    //echo $sql;
    echo 'cat'.$categoria;
    if ($conexion->query($sql) == TRUE)
    {     
        mensaje('Requisito modificado correctamente','tr_requisitos.php');
    }
    else 
    {
        mensaje('Hubo un error al agregar el requisito'.$sql,'tr_requisitos.php'); 
    }
    
    
    }


?>
<?php include ("./lib/body_footer.php"); ?>