<?php include ("./lib/body_head.php");
include ("./lib/body_menu.php"); 
?>
<?php
/*
echo "<div>";
    echo "<h1>Registro de un nuevo trámite</h1>";
    echo "<label>Nombre del trámite</label>";
    echo "<input type='text' name='nombreTramite'>";
    echo "<label>Descripción del trámite</label>";
    echo "<input type='text' name='descTramite'>";

echo "</div>";
*/
//Tabla de requisitos agregados
echo "<div style='width:100%;'>";
    
    echo "<h1>Agregar Requisitos a la solicitud: ---</h1>"; 
    echo " <a id='Vobo' href='#agregarRequisto' rel='MyModal:open' class='Mbtn btn-azulTam' title='Clic para marcar con Visto Bueno'>"; 
        echo "<table  width='100%'><tr><td valign='middle' align='center'>";
        echo "<img src='icon/ok2.png'> ";
        echo "</td>";
        echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
        echo "Agregar Requisito";
        echo "</td></tr></table>";    
    echo "</a>";  

    echo "<br><br>";
    echo "<h4>Lista de requisitos de la solicitud</h4>";
	echo "<table style='width:100%;' class=tabla>";
    echo "<th style='width:34%;'>Requisito</th>
    <th style='width:30%;'>Clase</th>
    <th style='width:30%;'>Opcional</th>
    <th style='width:6%;'></th>";
    $sql = "SELECT tramitestipo.IdTipoTramite, tramitestipo.NombreTramite, tramitesrequisitos.IdRequisito,
     tramitesrequisitos.NombreRequisito, tramitesrequisitosClase.IdRequisitoClase, 
     tramitesrequisitosClase.ClaseNombre, tramiteslistarequisitos.Opcional 
     FROM tramiteslistarequisitos 
    INNER JOIN tramitestipo ON tramitestipo.IdTipoTramite = tramiteslistarequisitos.IdTipoTramite 
    INNER JOIN tramitesrequisitos ON tramitesrequisitos.IdRequisito = tramiteslistarequisitos.IdRequisito 
    INNER JOIN tramitesrequisitosClase ON tramitesrequisitosClase.IdRequisitoClase = tramiteslistarequisitos.Clase 
    WHERE tramiteslistarequisitos.IdTipoTramite=1";
    //echo $sql;
    
    $r2 = $conexion -> query($sql);
     while($f = $r2 -> fetch_array())
	{
        //".$f['IdRequisito']."-
		echo "<tr>";
        echo "<td style='width:34%;'>".$f['NombreRequisito']."</td>";
        echo "<td style='width:30%;'>".$f['ClaseNombre']."</td>";
        echo "<td style='width:30%; text-align: center;'>";
            echo "<form action='tr_requisitosTramite.php?editar' method='POST'>";
                echo "<input type='hidden' id='IdTramite' name='IdTramite' value='".$f['IdTipoTramite']."'>";
                echo "<input type='hidden' id='IdRequisito' name='IdRequisito' value='".$f['IdRequisito']."'>";
                echo "<input type='hidden' id='IdClase' name='IdClase' value='".$f['IdRequisitoClase']."'>";
                echo "<table><td style='width:80%;'>";
                echo "<select name='opcional' id='opcional' style='margin-left: 0px; '>";					
                                    
                    if($f['Opcional']==0){                 
                        echo "<option value='0' selected>NO</option>";
                        echo "<option value='1'>SI</option>";
                    }else{
                        echo "<option value='0'>NO</option>";
                        echo "<option value='1' selected>SI</option>";
                    }
                                    
                echo "</select>";
                echo "</td><td style='width:20%;'>";
                echo "<button id='btnAgregar' class='btn-celesteTam btn' type='submit' title='Guardar el cambio'>"; 
                    echo "<img src='icon/guardar.png' style='width:15px;'>";
                echo "</button>"; 
                echo "</td></table>";
            echo "</form>";
        /*if($f['Opcional']==1){
            echo 'Si';
        }else{
            echo 'No';
        }*/
        echo "</td>";
        echo "<td width=20px style='text-align: center;'>";    
            echo "<form action='tr_requisitosTramite.php?eliminar' method='POST'>";
                echo "<input type='hidden' id='IdTramite' name='IdTramite' value='".$f['IdTipoTramite']."'>";
                echo "<input type='hidden' id='IdRequisito' name='IdRequisito' value='".$f['IdRequisito']."'>";
                echo "<input type='hidden' id='IdClase' name='IdClase' value='".$f['IdRequisitoClase']."'>";
        
                echo "<button id='btnEliminar' class='btn-azulTam btn' type='submit' title='Eliminar el registro'>"; 
                    echo " <img src='icon/x.png' style='width:18px; height:18px;'> ";
                echo "</button>"; 
            echo "</form>";
                //------------Modal editar requisito
          /*  echo "<div id='EditatRequisto".$f['IdRequisito']."' class='MyModal'>";
            echo "<center>";
            echo "<h1>Editar requisito</h1>"; 
            echo "<form action='tr_requisitosTramite.php?editar' method='POST'>";
                echo "<div>";
                echo '<label>Nombre del requisito</label>';
                echo "<input type='hidden' id='idreq' name='idreq' value='".$f['IdRequisito']."'>";
                echo "<input type='text' id='requisito' name='requisito' value='".$f['NombreRequisito']."' readonly>";
                echo "</div>";

                echo "<div>";
                echo '<label>Opcional</label>';           
                    echo "<select name='opcional' id='opcional' style='margin-left: 0px; '>";					
                            
                        if($f['Opcional']==0){                 
                            echo "<option value='0' selected>NO</option>";
                            echo "<option value='1'>SI</option>";
                        }	
                        else 
                        {   echo "<option value='0'>NO</option>";
                            echo "<option value='1' selected>SI</option>";
                        }
                                        
                    echo "</select>";
                echo "</div>";
         
            echo "<div>";
            echo '<label>Clase</label>';            
                echo "<select name='clase' id='clase' >";                   
                    $sql = "SELECT * FROM tramitesrequisitosClase ";
                    $tmp="";
                    $r5 = $conexion -> query($sql);
                    while($f1 = $r5 -> fetch_array())
                    {                    
                        if($f['IdRequisitoClase']==$f1['IdRequisitoClase']){
                            echo '<option value="'.$f1['IdRequisitoClase'].'" selected>'.$f1['ClaseNombre'].'</option>';			
                        }
                        else  {
                             echo '<option value="'.$f1['IdRequisitoClase'].'">'.$f1['ClaseNombre'].'</option>';			
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
            
            echo "</form>";
            echo "</center>";
            echo "</div>";*/
            echo "</td>";         
        echo "</tr>";
	}
	echo "</table>";
    echo "</div>";
    

    $tramite=1;
//MODAL AGREGAR

echo "<div id='agregarRequisto' class='MyModal'>";
echo "<center>";
echo "<h1>Agregar requisito</h1>"; 
echo "<form action='tr_requisitosTramite.php?agregar' method='POST'>";
echo "<input type='hidden' id='IdTramite' name='IdTramite' value='".$tramite."'>";
echo "<div>";
echo '<label>Nombre Requisito</label>';
    echo "<select name='requisito' id='requisito' >";
    $sql = "SELECT * FROM tramitesrequisitos ";
    $tmp="";
    $r2 = $conexion -> query($sql);
    while($fx = $r2 -> fetch_array())
        {
        echo '<option value="'.$fx['IdRequisito'].'">'.$fx['NombreRequisito'].'</option>';	
        }

    echo "</select>";
echo "</div>";


echo "<div>";
echo '<label>Opcional</label>';
    echo "<select name='opcional' id='opcional' style='margin-left: 0px; '>";					
			echo "<option value='0'>NO</option>";
            echo "<option value='1'>SI</option>";
           				
    echo "</select>";
echo "</div>";
echo "<div>";
echo '<label>Clase</label>';
    echo "<select name='clase' id='clase' >";
    $sql = "SELECT * FROM tramitesrequisitosClase ";
    $tmp="";
    $r2 = $conexion -> query($sql);
    while($fx = $r2 -> fetch_array())
        {
        echo '<option value="'.$fx['IdRequisitoClase'].'">'.$fx['ClaseNombre'].'</option>';	
        }

    echo "</select>";
echo "</div>";
echo "<BR>";
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
    $tramite = $_POST['IdTramite'];
    $requisito=$_POST['requisito'];
    $opcional=$_POST['opcional'];
    $clase=$_POST['clase'];
    $sql = "INSERT INTO tramiteslistarequisitos (IdTipoTramite, IdRequisito, Clase, Opcional)
    VALUES  ('$tramite', '$requisito', '$clase', '$opcional')";

    echo $sql;
    if ($conexion->query($sql) == TRUE){     
        mensaje('Requisito agregado correctamente','tr_requisitosTramite.php');
    }else{
        mensaje('Hubo un error al agregar el requisito','tr_requisitosTramite.php'); 
    }
}

//Editar requisitos
if(isset($_GET['editar'])){
    $tramite = $_POST['IdTramite'];
    $requisito=$_POST['IdRequisito'];
    $opcional=$_POST['opcional'];
    $clase=$_POST['IdClase'];
 
    $sql = "UPDATE tramiteslistarequisitos SET Opcional=".$opcional." 
    WHERE IdTipoTramite = ".$tramite." and IdRequisito = ".$requisito." and Clase = ".$clase."";

    echo $sql;
    if ($conexion->query($sql) == TRUE){     
        mensaje('Requisito editado correctamente','tr_requisitosTramite.php');
    }else{
        mensaje('Hubo un error al editar el requisito','tr_requisitosTramite.php'); 
    }
    
    
}


//Eliminar requisitos
if(isset($_GET['eliminar'])){
    $tramite = $_POST['IdTramite'];
    $requisito=$_POST['IdRequisito'];
    $clase=$_POST['IdClase'];
 
    $sql = "DELETE FROM tramiteslistarequisitos
    WHERE IdTipoTramite = ".$tramite." and IdRequisito = ".$requisito." and Clase = ".$clase."";

    echo $sql;
    if ($conexion->query($sql) == TRUE){     
        mensaje('Requisito eliminado correctamente','tr_requisitosTramite.php');
    }else{
        mensaje('Ocurrio un error al momento de eliminar el requisito. Intentelo nuevamente.','tr_requisitosTramite.php'); 
    }
    
    
}

?>
<?php include ("./lib/body_footer.php"); ?>