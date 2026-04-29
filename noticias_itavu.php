<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Notificas ITAVU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
		
    <link rel="stylesheet" href="lib/css_estructura.css?" />
	<link rel="stylesheet" href="lib/animated.css?" />

    <style>
        body{
            background-color: white; color: gray;
        }

       video {
            position: fixed;
            top:0px; left:0px;
            height:100%;
            width:100%;
        }
        /* #noticias {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color:#484848;
        }
        #noticias  video {
        position: fixed;
        left: 0%;
        top: 0%;
        height: 100%;
        width: 100%;
        margin:0px;
      
        } */
        /* @media only screen and (max-width:1000px) {
            #noticias  video {
            position: fixed;
            left: -20%;
            top: -50%;
            height: 150%;
            width: 150%;
      
        }


        @media only screen and (max-width:800px) {
            #noticias  video {
            position: fixed;
            left: -40%;
            top: -50%;
            height: 150%;
            width: 150%;
      
        }

        @media only screen and (max-width:500px) {
            #noticias  video {
            position: fixed;
            left: -50%;
            top: -90%;
            height: 200%;
            width: 200%;
      
        } */

        }



    </style>

    <script src="lib/jquery-3.4.1.js"></script>
	<script type="text/javascript">//<![CDATA[
		$(function(){
		    $('#noticias div:gt(0)').hide();
		    setInterval(function(){
		      $('#noticias div:first-child').fadeOut(0)
		         .next('div').fadeIn(1000)
		         .end().appendTo('#noticias');}, 20000);
		});
		//]]>
    </script>
    
</head>
<body>
    

<?php
function primera_imagen($texto) {
    $foto = '';
    ob_start();
    ob_end_clean();
    preg_match_all("/<img[\s]+[^>]*?src[\s]?=[\s\"\']+(.*\.([gif|jpg|png|jpeg]{3,4}))[\"\']+.*?>/", $texto, $array);
    $foto = $array [1][0];
    if(empty($foto)){
        $foto = '';
    }
    return $foto;
}


    // echo "<section id='noticias'>";
    
    echo "<video autoplay loop zoom ><source src='media/videotam1.mp4' type='video/mp4'></video> ";
    

    
    echo "<video autoplay loop zoom ><source src='media/videotam2.mp4' type='video/mp4'></video> ";
    

    
    echo "<video autoplay loop zoom ><source src='media/videotam3.mp4' type='video/mp4'></video> ";
    

    
    echo "<video autoplay loop zoom ><source src='media/videotam4.mp4' type='video/mp4'></video> ";
    

    
    echo "<video autoplay loop zoom width='100%'><source src='media/videotam5.mp4' type='video/mp4'></video> ";
    

    
    echo "<video autoplay loop zoom width='100%'><source src='media/videotam6.mp4' type='video/mp4'></video> ";
    


    /* $url = "https://www.tamaulipas.gob.mx/itavu/rss";
    $rss = new DOMDocument();
    $rss->load($url);
    $feed = array();
    foreach ($rss->getElementsByTagName('item') as $node) {
                $title = $node->getElementsByTagName('title')->item(0)->nodeValue;
                $link = $node->getElementsByTagName('link')->item(0)->nodeValue;
                $pubDate = $node->getElementsByTagName('pubDate')->item(0)->nodeValue;
                $description = $node->getElementsByTagName('description')->item(0)->nodeValue;
                $content = $node->getElementsByTagName('encoded')->item(0)->nodeValue;
        
                // echo "<article>";
                // echo "<h1>".$title."</h1>";
                // echo "".$description.$content."";
                // echo "<a href='".$link."'>Ver mas</a>";
                // echo "</article>";
                // echo $content;
                echo "<div>";
                $src = primera_imagen($content);
                echo "<a href='".$link."' title='".$title."'>";
                echo "<img src='".$src."'>";
               

                echo "<p>";
                echo $title.":".$description;
                echo "</p>";

                 echo "</a>";
                echo "</div>";

        
    }
  */
    // echo "</section>";


    

?>

</body>
</html>
