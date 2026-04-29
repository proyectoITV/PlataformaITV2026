<?php
// include ("seguridad.php"); 
include ("lib/body_head.php");
include ("lib/body_menu.php");


$id_aplicacion ="cont"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos
xd_update($id_aplicacion,$nitavu);//guarda la experiencia del usuario
historia($nitavu, "[".$id_aplicacion."]"." Entro a la app");

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
// MiToken_Init($nitavu, 'Contratos'); 
    echo "<div style='height:40px;  '></div>";
    
    //Variables para los Parametros
    $sql=" select Delegacion, OriginDelegacion as Origen,
    HTML_NumContrato as NumContrato,
    Programa, Folio, Beneficiario, FechaEmision,  Observaciones, Empleado from busqueda_infocontratos WHERE Cancelado=0 ";


    if (isset($_GET['IdDelegacion'])){
        $IdDelegacion = $_GET['IdDelegacion']; if (ValidaVAR($IdDelegacion)==TRUE){$IdDelegacion = LimpiarVAR($IdDelegacion);} else {$IdDelegacion = "";}
            
        $sql = $sql."and IdDelegacion='".$IdDelegacion."'";

        if (isset($_GET['IdPrograma'])){
            echo "
            <div class='EtiquetaInteractiva' title='IdDelegacion=".$IdDelegacion."'>
              ".DelegacionNombre($IdDelegacion)."

            </div>

        ";

        } else {

            echo "
            <div class='EtiquetaInteractiva' title='IdDelegacion=".$IdDelegacion."'>
              ".DelegacionNombre($IdDelegacion)."

            </div>
            <hr>
        ";

            $rP= $Vivienda -> query("
            select DISTINCT IdPrograma, Programa from busqueda_infocontratos WHERE IdDelegacion=".$IdDelegacion);
            $P = ""; $select = "";
            $c = 0;
            while($fP = $rP -> fetch_array()) {
                if  ($c >=12){
                    $select = $select."<option value='".$fP['IdPrograma']."'>".$fP['Programa']."</option>";

                } else {
                    $P = $P."
                    <div class='EtiquetaInteractiva' title='IdPrograma=".$fP['IdPrograma']."' style='
                    background-color: #e1b0d7;
                    '>
                      ".$fP['Programa']."
        
                    </div>
        
                    ";
                }
            
                $c = $c +1;
            }

            if ($select == ''){
                echo $P;
            } else {
                echo $P;
                echo "<form action='' method='GET' class='EtiquetaInteractiva'>";
                echo "<input type='hidden' value='".$IdDelegacion."' name='IdDelegacion'>";
                echo "<select name='IdPrograma'>";
                echo $select;
                echo "</select>";

                echo "<input type='submit' class='btn btn-Primary' value='Ver Programa'>";
                echo "</form>";
            }
        }

        
    }
    if (isset($_GET['IdPrograma'])){
        $IdPrograma = $_GET['IdPrograma']; if (ValidaVAR($IdPrograma)==TRUE){$IdPrograma = LimpiarVAR($IdPrograma);} else {$IdPrograma = "";}
        $sql = $sql."and IdPrograma='".$IdPrograma."'";

        if (isset($_GET['IdDelegacion'])){
            echo "
            <div class='EtiquetaInteractiva' title='IdDelegacion=".$IdPrograma."' style='background-color:#bec891;'>
            <table width=100% border=0><tr><td style='color:white;'>  
            ".NombrePrograma($IdPrograma)."
            </td><td align=right>
              <a href='?IdDelegacion=".$IdDelegacion."&IdPrograma=".$IdPrograma."&limit=all' 
              title='Haga clic para Mostrar todos los contratos de este programa en esta delegación'
              >
              <img src='icon/all.png' style='width:13px;'>
              </a>
              </td></tr>
              </table>
    
            </div>
    
        ";

        } else {
            echo "
            <div class='EtiquetaInteractiva' title='IdPrograma=".$IdPrograma."' style='background-color:#bec891;'>
            <table width=100% border=0><tr><td style='color:white;'>  
            ".NombrePrograma($IdPrograma)."
            </td><td align=right>
             
              </td></tr>
              </table>
    
            </div>
    
        ";
        }

       
    }
    if (isset($_GET['q'])){
        $Q = $_GET['q']; if (ValidaVAR($Q)==TRUE){$Q = LimpiarVAR($Q);} else {$Q = "";}

        

                echo "
                <div class='EtiquetaInteractiva'
                style='
                background-color:#e1b187; 
                '
                >
                <table width=100% border=0><tr><td style='color:white;'>
                ".$Q."
                </td><td align=right>
              <a href='?q=".$Q."&limit=all' 
              title='Haga clic para Mostrar todos los contratos de esta busqueda'
              >
              <img src='icon/all.png' style='width:13px;'>
              </a>
              </td></tr>
              </table>
        
                </div>
        
            ";    
            $sql = $sql."and  Beneficiario like '%".$Q."%'";
    }


    if (isset($_GET['limit'])){
        $limit = $_GET['limit']; if (ValidaVAR($limit)==TRUE){$limit = LimpiarVAR($limit);} else {$limit = "";}
        if ($limit == 'all'){
            echo "
            <div class='EtiquetaInteractiva' 
            style='
            background-color:#c8c3ca;
            '
            >Mostrando todos los registros            
            </div>

            ";    

            $sql = $sql." ";

        } else {
            if ($limit<=0){ //default 100
                $limit = 100;
            }

            echo "
            <div 
            style='
            background-color:#c8c3ca;
            '
            class='EtiquetaInteractiva'>Mostrando ".$limit."
            
            </div>

            ";    
            $sql = $sql."   limit ".$limit;

        }

        
        

    } else {
        $sql = $sql."   limit 100";
        if (!isset($_GET['limit']) and !isset($_GET['q'])  and !isset($_GET['IdDelegacion'])  and !isset($_GET['IdPrograma'])    ) {
        
        } else {

        echo "
        <div class='EtiquetaInteractiva'
        style='
            background-color:#c8c3ca;
            '
        
        >Mostrando 100 contratos
        
        </div>

        ";    
        }
    }



    

    
    // echo $sql;
    echo "<br><br>";
    if (!isset($_GET['limit']) and !isset($_GET['q'])  and !isset($_GET['IdDelegacion'])  and !isset($_GET['IdPrograma'])    ) {
        echo "<form action='' method='GET'>";
        echo "<label>Nombre del Beneficiario a buscar <input type='text' class='form-control' name='q'
        style='
        width: 500px;
height: 50px;
font-size: 18pt;
        '
        
        ></label>";

        echo "<br><label><input type='submit' value='Buscar' class='btn btn-Primary'></label>";
        echo "</form>";

    } else {    
        TablaDinamica_MySQL("Vivienda",$sql, "MiIdDivTabla2", "IdTabla2", "container", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
        
    echo "<br><cite class='Container'>NOTA: Cuando se migro la información de las Delegaciones a la Plataforma, se detectaron contratos que no fueron creados en dicha delegacion. A eso hace
    referencia la columna <b>ORIGEN</b>. Puede solicitar su cancelación";
    
    }
    




} else{mensaje("ERROR: no tiene acceso a esta aplicación","");}






?>

<script>
    $(document).ready(function() {
        $('#contratoslist').DataTable();
    } );
</script>

<?php
include ("./lib/body_footer.php");
?>