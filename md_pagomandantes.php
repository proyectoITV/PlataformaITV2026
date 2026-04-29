<?php
 include ("./lib/body_head.php"); include ("./lib/body_menu.php");
 $id_aplicacion = 'ap70';
xd_update('ap70',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);


    //historia($nitavu, 'Entre a ver la lista de mandantes con los montos por pagar, y todos los saldos pendientes.');
    echo "<br><br>";
    echo "<div >"; 

  

    echo "<form action='md_pagomandantes.php' method='GET'>";
        echo "<div style='width:100%;'>";
            echo '<div class="card" style="text-align: justify; width:100%;">
                    <h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt;" >Datos para crear oficio</h1>';
                    echo '<div class="card-body" style="width:100%;">'; 
                    echo "<center>";
                    echo "<table style='width:100%;'><td style='width:50%;'>";
                        echo '<label for="numOficio">Número de Oficio (NOTA: Agregar nombre completo desde Memorándum u oficio)</label>';
                        echo '<input  id="numOficio" name="numOficio">';
                    echo "</td><td style='width:50%;'><table style='width:100%;'><td style='width:50%;'>";
                        echo '<label for="fechaRep">Fecha Inicio</label>';
                        echo "<input type='date' id='fechainicio' name='fechainicio'>";
                    echo "</td><td style='width:50%;'>";
                        echo '<label for="fechaRep">Fecha Fin</label>';
                        echo "<input type='date' id='fechafin' name='fechafin'>";
                    echo "</td></table></td></table><br>";   
                        echo "<button  type='submit' class='Mbtn btn-danger' title='Crear Oficio'>Crear Oficio</button>";	
                    
                    echo "</center>";  
                    echo '</div>';

            echo '</div>';
        echo '</div>';  
    echo "</form>";

    if(isset($_GET['numOficio']) or isset($_GET['fechainicio'])){
        
        $numoficio = $_GET['numOficio'];
        $fechainicio = $_GET['fechainicio'];
        $fechafin = $_GET['fechafin'];

       /* echo '<div class="card" >';
            echo "<center><a  class='btn btn-primary' href='md_creaWord.php?numoficio=".$numoficio."&fechainicio=".$fechainicio."&fechafin=".$fechafin."' download='documento.doc' title='Crear Oficio'>Generar Word</a></center>";	
            echo "<br><br>";
        echo "</div>";*/

        echo "<iframe src='md_reportePago1.php?numoficio=".$numoficio."&fechainicio=".$fechainicio."&fechafin=".$fechafin."' 
        style='width:100%; height:150%; border: 0px solid black;' border=0></iframe>";
    }
    


?>

<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<?php include ("./lib/body_footer.php"); ?>