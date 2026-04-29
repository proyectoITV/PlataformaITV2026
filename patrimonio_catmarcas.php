<?php 
    include ("./lib/body_head.php");
    include ("./lib/body_menu.php");

    echo "<script src='patrimonio_marcas.js'></script>";

    echo "<div class='container'>";
        include("patrimonio_menu.php");
        echo "<div class='row'>";
            echo "<div class='col-lg-12'>";
                echo "<div class='card card-default rounded-0 shadow'>";
                    echo "<div class='card-header'>";
                        echo "<div class='row'>";
                            echo "<div class='col-md-9'>";
                                echo "<h3 class='card-title'>Catálogo de Marcas</h3>";
                            echo "</div>";
                            echo "<div class='col-md-3 text-end'>";
                                echo "<button type='button' name='add' id='addBrand' class='btn btn-primary bg-gradient btn-sm rounded-0'><i class='far fa-plus-square'></i> Nueva Marca</button>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                    echo "<div class='card-body'>";
                        echo "<table id='catalogodemarcas' class='table table-bordered table-striped'>";
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>Clave</th>";
                                    echo "<th>Categoria</th>";
                                    echo "<th>Marca</th>";
                                    echo "<th>Estatus</th>";
                                    echo "<th>Acción</th>";
                                echo "</tr>";
                            echo "</thead>";
                        echo "</table>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
        echo "<div id='brandModal' class='modal fade'>";
            echo "<div class='modal-dialog modal-dialog-centered'>";
                echo "<div class='modal-content'>";
                    echo "<div class='modal-header'>";
                        echo "<h4 class='modal-title'><i class='fa fa-plus'></i> Nueva marca</h4>";
                        echo "<button type='button' class='btn-close' data-bs-dismiss='modal'></button>";
                    echo "</div>";
                    echo "<div class='modal-body'>";
                        echo "<form method='post' id='brandForm'>";
                            echo "<input type='hidden' name='id' id='id' />";
                            echo "<input type='hidden' name='btn_action' id='btn_action' />";
                            echo "<div class='mb-3'>";
                                echo "<label>Ingrese nombre de la marca</label>";
                                echo "<input type='text' name='bname' id='bname' class='form-control  rounde-0' required />";
                            echo "</div>";
                        echo "</form>";
                    echo "</div>";
                    echo "<div class='modal-footer'>";
                        echo "<input type='submit' name='action' id='action' class='btn btn-primary btn-sm rounded-0' value='Add' form='brandForm'/>";
                        echo "<button type='button' class='btn btn-default btn-sm rounded-0' data-bs-dismiss='modal'>Cerrar</button>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
?>

<?php include ("./lib/body_footer.php"); ?>
