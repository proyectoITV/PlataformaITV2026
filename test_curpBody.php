<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="lib/jquery-3.4.1.js"></script> 
    <title>Test CURP</title>
</head>
<body>
    <div id='preloader'>Cargando...</div>
    <input name='txtCurp' id='txtCurp' placeholder='Escribe el CURP' onkeypress="CURP_onclick()">
    <input name='txtNombre' id='txtNombre'>
    <div id='R'></div>

    <script>
    function CURP_onclick(){
        
        txtCurp = $("#txtCurp").val();
        var n = txtCurp.length;
        console.log(txtCurp + "N=" + n);
        if (n==18){
            // console.log("Ya esta listo el curp: "+ n);
            // CURP_leer(txtCurp);
            CURP_get();
        }
    }

    function CURP_get(){
        
        
        
        txtCurp = $("#txtCurp").val();
        $("#txtCurp").val("cargando...");
        nuser="TEST";
        var urlAPI = "curp_dat1.php?curp="+txtCurp+"&nuser="+nuser;
        console.log(urlAPI);
        
        $.getJSON( urlAPI, function( data ) {
            var items = [];
            $c = 0;
            $.each( data, function( key, val ) {
                // items.push( "<li id='" + key + "'>" + val + "</li>" );
                // console.log(val);
                if ($c == 1){
                    console.log("--------------"+key)
                    console.log(val.nombres + " " + val.apellido1 + " " + val.apellido2 );
                    console.log("Fecha de Nacimiento " + val.fechNac);
                    console.log("Sexo " + val.sexo);
                }
                console.log($c);
                $c = $c + 1;

            });
        });        
        $("#txtCurp").val(txtCurp);
    }
    </script>





 
</body>
</html>