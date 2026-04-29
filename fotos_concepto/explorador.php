<?php
//include ("./unica/seguridad.php");
include ("./unica/body_head.php");
include ("./unica/body_menu.php");
// contenido:




// $id_aplicacion ="ap68"; //ap06=Permisos de Aplicacion
// if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	// xd_update('ap26',$nitavu);//guarda la experiencia del usuario
	// historia($nitavu, "Entro a la aplicacion para Configurar la asistencia y ver el reporte [ap26]");
	// echo "<h5>".app_detalle($id_aplicacion)."</h5>";

	echo "<br>";
	echo buscar("explorador.php","IdLote,...","");

	// echo "<div id='censo_mapa'>";
  
    // echo "</div>";


    //colonias------------------------------------------------------
    if (isset($_GET['m'])){
        $sql="select * from catcolonia where IdMunicipio='".$_GET['m']."'";
        $r= $conexion -> query($sql);
        echo "<section id='contenido_colonias'>";
        echo "<h3>Colonias de <b class='ejecutandose'>".municipio_nombre($_GET['m'])."</b></h3>";
        echo "<table class='tabla'>";
        while($f = $r -> fetch_array()) {
            
            echo "<tr title='"."ID: ".$_GET['m']."|".$f['IdColonia'].""."'>";
            echo "<td>";
            echo "<a href='?m=".$_GET['m']."&col=".$f['IdColonia']."'>";
            echo $f['Colonia']."";
            
            
            echo "<label>".$f['Observaciones']."</label></a></td>";



            echo "</tr>";
        }
        echo "</table>";

        echo "</section>";
    }

    //-lotes-------------------------------------
    if (isset($_GET['col']) and isset($_GET['m'])){

        $sql="
        SELECT
            idLote as QidLote,
            IdMunicipio as QIdMunicipio,
            IdDelegacion as QIdDelegacion,
            IdColonia as QIdColonia,
            Manzana as QManzana,
            Lote as QLote,
            Version_Plano as Version,
            (
                select count(*) from Lotes where 
                    Lotes.IdMunicipio = QIdMunicipio AND
                    Lotes.IdColonia = QIdColonia AND
                    Lotes.manzana = QManzana AND
                    Lotes.lote = QLote
            ) as VersionesPlano
            
        FROM
            Lotes
            
        WHERE
            Lotes.idLote = LoteAlto(IdMunicipio, Lotes.IdColonia, Lotes.manzana, Lotes.lote)
            AND IdMunicipio = '".$_GET['m']."' AND IdColonia='".$_GET['col']."'
            
            


        
        ";
        echo $sql;
        $r2= $conexion -> query($sql);
        echo "<section id='contenido_colonias'>";
        echo "<h3>Lotes de la Col <b class='ejecutandose'>".municipio_nombre($_GET['m'])."</b></h3>";
        echo "<table class='tabla'><th>IdLote</th><th>Manzana</th><th>Lote</th><th>Ver. Plano</th><th>Versiones</th>";
        while($f2 = $r2 -> fetch_array()) {
            
            echo "<tr title='"."ID: ".$_GET['m']."|".$f2['IdColonia'].""."'>";
            echo "<td>";
            // echo "<a href='?m=".$_GET['m']."&col=".$f['IdColonia']."'>";
            echo $f2['QidLote']."";
            echo "</td>";

            echo "<td>".$f2['QManzana']."</td>";
            echo "<td>".$f2['QLote']."</td>";
            echo "<td>".$f2['Version']."</td>";
            echo "<td>".$f2['VersionesPlano']."</td>";
            
            



            echo "</tr>";
        }
        echo "</table>";

        echo "</section>";

    }




// else { mensaje ("ERROR: no tiene acceso a esta aplicacion",'');}
insertar_mapa();

    ?>



<?php include ("./unica/body_footer.php"); ?>
