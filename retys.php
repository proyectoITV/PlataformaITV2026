
<script>
// $.post("https://www.tamaulipas.gob.mx/tramites/ciudadano/contenido.php", {sTema:"2", sDependencia:"40"}, function(htmlexterno){$("#m_resultados").html(htmlexterno);});


	function b_contenido () {
		$("#selcombo").val(1);
		var palabras 	= "";

		var tema		=2;
		var depen 		=40;
		var dirigido	=1;
		var impacto		=0;
		var letraABC = "";

		
		var separa =1;
		// mostrar busquedas segun valores de combos
		$.post("contenido.php", { sDependencia: depen, sTema: tema, sBuscarPalabra: palabras, sDirigido: dirigido, sImpacto: impacto, letra: letraABC, separa: separa }, function(data) {

			$("#m_tramites").hide();

			e_searchform (1);

			$("#m_resultados").html(data);
			$("#m_resultados").show();
	    });

		
		return false;
	}
	b_contenido()


</script>


<!-- $.post("contenido.php", { sDependencia: depen, sTema: tema, sBuscarPalabra: palabras, sDirigido: dirigido, sImpacto: impacto, letra: letraABC, separa: separa }, function(data) { -->


<!-- <form action='https://www.tamaulipas.gob.mx/tramites/ciudadano/contenido.php' method='post'>
	<input type='hidden' name='sTema' id='sTema' value='2'>
	<input type='hidden' name='sDependencia' id='sDependencia' value='40'>

	<input type='hidden' name='sDirigido' id='sDirigido' value='1'>
	<input type='hidden' name='sImpacto' id='sImpacto' value='0'>
	<input type='hidden' name='sBuscarPalabra' id='sBuscarPalabra' value=''>
	<input type='hidden' name='letra' id='letra' value='A'>
	<input type='hidden' name='separa' id='separa' value='1'>


	<input type='submit' value='Retys'>

	
</form> -->
<div id='#m_resultados'>

</div>