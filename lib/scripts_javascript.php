	<!--Load the AJAX API
    <script type="text/javascript" src="lib/gstatic_loader.js"></script>-->    
    	<script type="text/javascript" src="lib/google_charts_loader.js"></script> <!--offline graficos de google -->
		<script language="javascript" src="../txtplus/txtplus.js" type="text/javascript"></script>
		<script language="javascript" src="../lib/aslider.js" type="text/javascript"></script>
		<script
			  src="lib/jquery-3.2.1.slim.min.js"
			  integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g="
			  crossorigin="anonymous"></script>
<!-- 
<script
			  src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
			  integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g="
			  crossorigin="anonymous"></script> -->


  <script src="lib/jquery-1.12.4.js"></script><!--  <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="lib/jquery-ui.js"></script> <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
  <script>
  $( function() {
    $( "#organigrama_flow" ).draggable();
  } );
  </script>





		<!-- PARA EL RELOJ DEL PASE -->
 		<!-- <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
 		ME DIO PROBLEMAS CON JS DE LOS BOTONES DEL TEXTAREA -->
		<link href="lib/timedropper.css" rel="stylesheet" type="text/css"> 


	<script src='lib/jquery.min.js' type='text/javascript'/></script> <!-- <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js' type='text/javascript'/></script> -->

	<script src="lib/jquery.min191.js"></script> 
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
	<script type="text/javascript">//<![CDATA[
		$(function(){
		    $('#slider_ecologico div:gt(0)').hide();
		    setInterval(function(){
		      $('#slider_ecologico div:first-child').fadeOut(0)
		         .next('div').fadeIn(1000)
		         .end().appendTo('#slider_ecologico');}, 5000);
		});
		//]]>
	</script>

<script type="text/javascript">
//SCRIPT PARA BUSCAR
        function searchToggle(obj, evt){
            var container = $(obj).closest('.search-wrapper');

            if(!container.hasClass('active')){
                  container.addClass('active');
                  evt.preventDefault();
            }
            else if(container.hasClass('active') && $(obj).closest('.input-holder').length == 0){
                  container.removeClass('active');
                  // clear input
                  container.find('.search-input').val('');
                  // clear and hide result container when we press close
                  container.find('.result-container').fadeOut(100, function(){$(this).empty();});
            }
        }

        function submitFn(obj, evt){
            value = $(obj).find('.search-input').val().trim();

            _html = "X";
            if(!value.length){
                _html = "XY";
            }
            else{
                _html += "<b>" + value + "</b>";
            }

            $(obj).find('.result-container').html('<span>' + _html + '</span>');
            $(obj).find('.result-container').fadeIn(100);

            evt.preventDefault();
        }
 </script>
