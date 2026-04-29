<?php include ("unica/body_head.php");?>

<div id="preloader" style='background-color:white; color:#4E4E4E; opacity: 0.9;'>

    <div id="loader">
			
    		<img src="img/loader.gif" class='cargando_img'><br>
   			<span sytle='color:#4E4E4E;'>Espere por favor</span>
    </div>
</div>
<div id='AtencionCiudadana'>

   
<?php
if ( isset($_POST['search_field']) ){

    $buscar = $_POST['search_field'];
    if (ValidaVAR($buscar)==TRUE){$buscar = LimpiarVAR($buscar);}

    if ( strlen($buscar)>10 ){


            echo "<h1 style='
            background-color: white; 
            padding: 0px;
            margin: 0px;
            padding: 4px;
            font-family: Regular;
            font-size: 13pt;
            
        '> Buscando a <b class='ejecutando'>".$buscar."</b>:</h1>";
        //historia($nitavu, "ATENCION busco a ".$buscar);


        $sql="select * from PersonasDeVivienda Where NombreCompleto like '%".$buscar."%' order by NombreCompleto ASC, Delegacion ASC";
        $r= $conexion -> query($sql);
        echo "<table class='tbl_atencion'>";
        while($f = $r -> fetch_array()) {
            echo "<tr>";
            echo "<td>";
                echo "<b style='font-size: 15pt;

                font-family: ExtraBold;
                
                color: white;'>".$f['NombreCompleto']."</b><br>";
                echo "<span style='font-size:9pt;'>";
                $Domicilio = "Calle ".$f['domicilioCalleNum']."( ".$f['domicilioEntre']." ".$f['domicilioEntreY']."). ".$f['Domicilio_localidad'].", ".$f['domicilioColonia'].", ".$f['Domicilio_Colotra'];
                echo "<b>Domicilio: </b>".$Domicilio."<br>";
                echo "<b>CURP: </b>".$f['CURP'].", IFE: ".$f['IFE']."<br>";
                // echo "Telefonos: ".$f['Telefono'].", ".$f['TelCelular']."<br>";

                echo "<span
                style='
                    background-color:white;
                    padding-left:5px;padding-right:5px;
                    border-radius:2px;
                    color:gray;
                '
                >Del: <b>".$f['Delegacion']. "</b>, Prog: <b>".$f['Programa']."</b></span><br>";
                echo "Folio: ".$f['Folio']. ", Contrato: ".$f['NumContrato']."<br>";

                echo "</span>";

            echo "</td>";

            echo "<td>";
            // echo "<span>Turno:<br></span>";
            echo "<a href='atencion.php?tt=1&id=".$f['id']."' class='btn btn-default' title='Crear un Turno'>Seleccionar</a>  ";
            // echo "<a href='atencion.php?tt=1&id=".$f['id']."&area=2' class='btn btn-default' title='Crear un Turno'>Ejecutivo</a>  ";
            

                


            echo "</td>";

            echo "</tr>";
        }
        echo "</table>";




        echo "<a href='atencion.php?app=atencion' class='btn btn-celesteTam'>Buscar nuevamente </a> ";
        echo "<a href='atencion.php?clinvo=1&name=".$buscar."' class='btn btn-verdeTam' title='Usarse esta opcion si no se encuentra en la busqueda'>Cliente Nuevo </a>";
        echo "<br><br><br>";
    } else {
        mensaje("ERROR: debe escribir mas en el nombre a buscar. Al menos 10 caracteres","atencion.php?app=atencion");
    }

} else {

    if ( isset($_GET['clinvo']) and isset($_GET['name'])){

            //MOSTRAR AREAS
            echo "<div class='centrar_padre'>";
            echo "<div class='centrar_hijo' 
            style='
                background-color: white;
                width: 50%;
                padding: 10px;
                border-radius: 5px;                
                '
            >";        
        $sql="select * from CatAreas";
        $r2= $conexion -> query($sql);
        echo "<form action='atencion.php?clinvo=1&name=".$_GET['name']."' method='POST'>";
        echo "<input type='hidden' value='".$_GET['name']."'>";
        echo "<label>¿En que te podemos ayudar?</label>
        <select name='area' id='area' style='font-size:18pt;'>";
        while($fx = $r2 -> fetch_array()) {
            echo "<option value='".$fx['IdArea']."'>".$fx['Nombre']."</option>";
        }
        echo "</select>";
        echo "<div><a href='atencion.php?app=atencion' class='btn btn-celesteTam'>Regresar </a>  </div>";
        echo "<div><input type='submit' value='Turno' name='btnArea2' class='btn btn-verdeTam' style='  height: 39px;font-size:12pt;'></div>";
        echo "</form>";
        echo "</div></div>";



        if (isset($_POST['btnArea2'])){
                //consultar con esa ID para preparar el guardar el Turno
                //se necesita turno id

                if ( EstoyenDelegacion($nitavu) =='del'){
                    $IdDelegacion_dpto = nitavu_dpto($nitavu);
                    $Turno = Turno($IdDelegacion_dpto,TRUE);
                    $Area = $_POST['area'];

                    //consultar datos
                        $buscar = $_GET['name'];
                        // guardar el turno
                        $sql = "INSERT INTO Turnos(clinvo, Nombres,Paterno,Materno,CURP,DelegacionId,Delegacion,ProgramaId,Programa,NumContrato,Folio,Fecha,Hora,nitavu,comentarios,Turno,Area) 
                        VALUES(
                            '1', '".$buscar."','', '', '', '".$IdDelegacion_dpto."',
                            '".nitavu_dpto_nombre($nitavu)."',  '',  '',  '', 
                            '',  '".$fecha."',  '".$hora."',  '".$nitavu."', '', '".$Turno."' , '".$Area."' 
                        )";
                        if ($conexion->query($sql) == TRUE){
                            // echo "<b>GRACIAS </b> ".$PV['Nombre']."<br> tu Turno es <span style='font-size:20pt;'>".$Turno."</span><br><span 
                            // style='font-size:8pt'>Gracias por la espera <br>".$fecha." - ".$hora." </span><br><br>";

                            // $data=$Turno;
                            echo "<script>window.location='atencion_data.php?data=".$Turno."&area=".$Area."';</script>";
                    

                    }
                    // echo "ya tengo el id = ".$_GET['id']." con el Area ".$_POST['area']."";
                    
                }

        }




                
            echo "</div>";
        echo "</div>";

    }


    if (isset($_GET['tt']) and isset($_GET['id'])){
        $PersonasDeVivienda_ID = $_GET['id']; if (ValidaVAR($PersonasDeVivienda_ID)==TRUE){$PersonasDeVivienda_ID = LimpiarVAR($PersonasDeVivienda_ID);} else {$PersonasDeVivienda_ID="";}
        
            //MOSTRAR AREAS
        echo "<div class='centrar_padre'>";
            echo "<div class='centrar_hijo' 
            style='
                background-color: white;
                width: 50%;
                padding: 10px;
                border-radius: 5px;                
                '
            >";        
        $sql="select * from CatAreas";
        $r2= $conexion -> query($sql);
        echo "<form action='atencion.php?tt=&id=".$_GET['id']."' method='POST'>";

        echo "<label>¿En que te podemos ayudar?</label>
        <select name='area' id='area' style='font-size:18pt;'>";
        while($fx = $r2 -> fetch_array()) {
            echo "<option value='".$fx['IdArea']."'>".$fx['Nombre']."</option>";
        }
        echo "</select>";
        echo "<div><a href='atencion.php?app=atencion' class='btn btn-celesteTam'>Regresar </a>  </div>";
        echo "<div><input type='submit' value='Turno' name='btnArea' class='btn btn-verdeTam' style='  height: 39px;font-size:12pt;'></div>";
        echo "</form>";
        echo "</div></div>";



        if (isset($_POST['btnArea'])){
                //consultar con esa ID para preparar el guardar el Turno
                //se necesita turno id

                if ( EstoyenDelegacion($nitavu) =='del'){
                    $IdDelegacion_dpto = nitavu_dpto($nitavu);
                    $Turno = Turno($IdDelegacion_dpto,TRUE);
                    $Area = $_POST['area'];

                    //consultar datos
                    $sql="select * from PersonasDeVivienda where id='".$PersonasDeVivienda_ID."'";	
                    $rcViv= $conexion -> query($sql);
                    if($PV = $rcViv -> fetch_array())
                    {
                        // guardar el turno
                        $sql = "INSERT INTO Turnos(Nombres,Paterno,Materno,CURP,DelegacionId,Delegacion,ProgramaId,Programa,NumContrato,Folio,Fecha,Hora,nitavu,comentarios,Turno,Area) 
                        VALUES(
                            '".$PV['Nombre']."','".$PV['Paterno']."', '".$PV['Materno']."', '".$PV['CURP']."', '".$IdDelegacion_dpto."',
                            '".nitavu_dpto_nombre($nitavu)."',  '".$PV['IdPrograma']."',  '".$PV['Programa']."',  '".$PV['NumContrato']."', 
                            '".$PV['Folio']."',  '".$fecha."',  '".$hora."',  '".$nitavu."', '', '".$Turno."' , '".$Area."' 
                        )";
                        if ($conexion->query($sql) == TRUE){
                            // echo "<b>GRACIAS </b> ".$PV['Nombre']."<br> tu Turno es <span style='font-size:20pt;'>".$Turno."</span><br><span 
                            // style='font-size:8pt'>Gracias por la espera <br>".$fecha." - ".$hora." </span><br><br>";

                            // $data=$Turno;
                            echo "<script>window.location='atencion_data.php?data=".$Turno."&area=".$Area."';</script>";
                        } else { mensaje("ERROR al guardar ".$sql,"index.php");}

                    }
                    // echo "ya tengo el id = ".$_GET['id']." con el Area ".$_POST['area']."";
                    
                }

        }




                
            echo "</div>";
        echo "</div>";


        


    } else {
    echo "
            <form action='atencion.php?app=atencion' method='post'>
            <table width=100% ><tr>
            <td width=90% valign=top align=left><input type='text' name='search_field' id='search_field' 
                style='    
                    width: 100%;
                    border-radius: 1px;
                    height: 50px;
                    border-width: 0px;
                    font-family:Light;
                    font-size:20pt;
                ' placeholder='Nombre parcial o completo del solicitante o beneficiario'></td>
            <td align=right valign=top>
                <button class='btn btn-default'
                    style='
                        margin-top: 0px;
                        height: 49px;
                        width: 100%;
                        '
                    >
                    <img src='icon/buscar2.png' style='
                        width: 40px;
                        margin-top: -6;'>
                </button>
            </td>
            </tr>
            </table>
        </form>
        <div id='keyboard' class='pc'></div>
            <script src='unica/js/jkeyboard.js'></script>
            <script>
                $('#keyboard').jkeyboard({
                    layout: 'english_capital',
                    input: $('#search_field'),
                    customLayouts: {
                        selectable: ['english_capital'],
                        english_capital: [
                            ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0',],
                            ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',],
                            ['A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L',],
                            ['Z', 'X', 'C', 'V', 'B', 'N', 'Ñ','M', '\'', '.'],
                            ['space', '-', 'backspace']
                            ],
                    }
                });
            </script>


    ";
    }
}
?>
    
</div> 
<?php




?>


<?php include ("unica/body_footer.php");?>