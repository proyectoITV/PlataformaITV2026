<html>
<head>
<title>Prueba</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
$( function(){   
    //Muestro el primer div
    $("#div").show();
    //cada 1 segundo ejecuto la función mostrar()
    setInterval("mostrar()",3000);
});
mostrar = function(){
    //Oculto el div que se encuentra vivisble
    var div = $("#div").hide();
    //Selecciono el siguiente div que oculte en el paso anterior
  // divNext = div.next();
    //Si existe otro div después lo muestro, si no existe quiere decir que es el último, entonces muestro el primero para que la próxima vez que se ejecute la función continue con el segundo
    //if(divNext.length){
       //divNext.show();
   // } else {
    //   $("#dos").show();
   //}
};
</script>

</head>
<body>

    <div id="div">¡Tienes una nueva notificación!</div>
</body>
</html>


