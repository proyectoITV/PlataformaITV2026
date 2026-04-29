<?php include ("./lib/body_head.php");
include ("./lib/body_menu.php"); 
?>
<?php

echo "<div>";
    echo "<h1>Registro de un nuevo trámite</h1>";
    echo "<label>Nombre del trámite</label>";
    echo "<input type='text' name='nombreTramite'>";
    echo "<label>Descripción del trámite</label>";
    echo "<input type='text' name='descTramite'>";
    echo "<label>Programa al que pertenece el trámite</label>";
    echo "<select name='programa' id='programa' >";
        $sql = "SELECT * FROM programa WHERE Activo=1";
        $r2 = $Vivienda -> query($sql);
        while($fx = $r2 -> fetch_array()){
            echo '<option value="'.$fx['IdPrograma'].'">'.$fx['Descripcion'].'</option>';	
        }

    echo "</select>";

    echo "<label>Departamento que se encargará del trámite</label>";
    echo "<select name='dpto' id='dpto' >";
        $sql = "SELECT * FROM cat_gerarquia";
        $r2 = $conexion -> query($sql);
        while($fx = $r2 -> fetch_array()){
            echo '<option value="'.$fx['id'].'">'.$fx['nombre'].'</option>';	
        }

    echo "</select>";

    echo"<div>";
        echo "<div>";
            echo "<label>Visto bueno 1</label>";
            echo "<select name='dpto' id='dpto' >";
                $sql = "SELECT * FROM cat_gerarquia";
                $r2 = $conexion -> query($sql);
                while($fx = $r2 -> fetch_array()){
                    echo '<option value="'.$fx['id'].'">'.$fx['nombre'].'</option>';	
                }

            echo "</select>";
        echo "</div>";

        echo "<div>";
            echo "<label>Visto bueno 2</label>";
            echo "<select name='dpto' id='dpto' >";
                $sql = "SELECT * FROM cat_gerarquia";
                $r2 = $conexion -> query($sql);
                while($fx = $r2 -> fetch_array()){
                    echo '<option value="'.$fx['id'].'">'.$fx['nombre'].'</option>';	
                }

            echo "</select>";
        echo "</div>";
    echo "</div>";
    
    echo "<div>";
        echo "<div>";
            echo "<label>Visto bueno 3</label>";
            echo "<select name='dpto' id='dpto' >";
                $sql = "SELECT * FROM cat_gerarquia";
                $r2 = $conexion -> query($sql);
                while($fx = $r2 -> fetch_array()){
                    echo '<option value="'.$fx['id'].'">'.$fx['nombre'].'</option>';	
                }

            echo "</select>";
        echo "</div>";

        echo "<div>";
            echo "<label>Visto bueno 4</label>";
            echo "<select name='dpto' id='dpto' >";
                $sql = "SELECT * FROM cat_gerarquia";
                $r2 = $conexion -> query($sql);
                while($fx = $r2 -> fetch_array()){
                    echo '<option value="'.$fx['id'].'">'.$fx['nombre'].'</option>';	
                }

            echo "</select>";
        echo "</div>";
    echo "</div>";
    
    echo "<div>";
        echo "<div>";
            echo "<label>Visto bueno 5</label>";
            echo "<select name='dpto' id='dpto' >";
                $sql = "SELECT * FROM cat_gerarquia";
                $r2 = $conexion -> query($sql);
                while($fx = $r2 -> fetch_array()){
                    echo '<option value="'.$fx['id'].'">'.$fx['nombre'].'</option>';	
                }

            echo "</select>";
        echo "</div>";
    echo "</div>";
echo "</div>";



?>
<?php include ("./lib/body_footer.php"); ?>