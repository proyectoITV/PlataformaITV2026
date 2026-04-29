<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   
    <!-- <script src="node_modules/jquery/dist/jquery.min.js"></script> -->
</head>
<body>
<!-- <div id="box">

  <div>Card1</div>

  <div>Card2</div>

  <div>Card3</div>

  <div>Card4</div>

  <div>Card5</div>

</div> -->

<div id="box"></div>
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
     <!-- <script src="node_modules/jquery/dist/jquery.min.js"></script> -->
    <script src="lib/fluid/responsive_waterfall.js"></script>

<!-- <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="waterfall-light.js"></script> -->
<script>

    $(function(){
        var box = $('#box');
        for(var i=0;i<50;i++){
            var card = $('<div>').addClass('card').css({
                height: Math.floor((Math.random() * 100) + 100)+"px",
                background: '#ace'
            }); box.append(card);
        }




        // useage: fallow below

        $('#box').waterfall();

        //eoiwefoiwef


    });
</script>
</body>
</html>