<?php // ENCABEZADO (NO MOVER)
include ("./unica/body_head.php");
include ("./unica/body_menu.php");
?>

<?php // ESPACIO DE TRABAJO












//Uso de funciones basicas
//
// quita el "//"  del inicio de la linea para ver ejecutada

//echo $nitavu; // esta almacena el numero de ITAVU del usuario logeado

//echo nitavu_nombre($nitavu); // nombre del usuario logeado

//echo nombre_corto($nitavu,0); // trae el nombre corto, el ultimo numero, la cantidad de palabras a extraer del nombre, el 0 cuenta, recomiendo usar maximo 3; para que no caiga en error si no se dispone de esa longitud.

//echo nombre_corto($nitavu,0)." ".nombre_corto($nitavu,1)." ".nombre_corto($nitavu,2); // puede utilizar como se nececesite

//echo nitavu_dpto($nitavu); // departamento del usuario logeado, o del que este al alcance del no. de itavu

//echo nitavu_dir($nitavu); // direccion del usuario logeado, o del que este al alcance del no. de itavu

//echo nitavu_puesto($nitavu); // puesto del usuario logeado, o del que este al alcance del no. de itavu

//echo nitavu_tel($nitavu); // Telefono del usuario logeado, o del que este al alcance del no. de itavu

//echo "Ext. ".nitavu_tel_ext($nitavu); // Extencsion de Telefono del usuario logeado, o del que este al alcance del no. de itavu

//echo user_legend($nitavu); // nombre, dpto y puesto con formato RTF, negrita para el nombre y siguiente linea normal

//echo $fecha; // fecha actual en el formato reconocido por MySQL

//echo fecha_larga($fecha); // convierte a formato largo la fecha actual, usarse solo para mostrar al usuario, para guardar en la bd usa $fecha

//echo dia_semana($fecha); // Estrae el dia de la semana de la fecha que le indiques

//echo dia_semana2($fecha); // Extrae el dia de la semana en formato de 3 digitos


//historia($nitavu_, $descripcion) // GUARDA en la bd de datos historial historia($variabledelusuariologeado, "texto o var del contenido")

// echo sugerencia("aqui va una sugerencia"); // suriere algo al usuario

//echo  ceropapel(); // hojas ahorradas

//echo mensaje ("este es un mensaje",''); // utilizalo para enviar un mensaje al usuario, procurar usarlo cuando no haya encabezado y pie, para no darle opcion fuera del aceptar. sintaxis mensaje ("contenido texto",'vinculo') si no se pone vinculo lleva al index.php



$contenido ="
aqui va el texto<br>

<p > este es un parrafo </p>

puedes usar tablas <br>:

<table>
	<tr>
		<td> soy una columna </td>
		<td> soy otra columna </td>
		<td> TR es una linea </td>
	</tr>
</table>


<p> puedes usar <b> negritas </b> y viñetas: </p>
<lu>
	<li> soy un elemento </li>
	<li> soy otro elemento </li>

</lu>
";
$para = "2809";
//notificacion_add ($para,"Estoy probando", $fecha, $nitavu, $contenido); // envia una notificacion: sintaxis notificacion_add(para, asunto, cuando, yo, contenido ), queda a criterio usar variables o string. en el contenido puede ir formato html tan largo coo se necesite. ENVIA TRUE si se envio o FALSE sino. si se requiere validar, sino solo usarlo asi en modo pasivo, se envie sin decir nada.



//echo aplicacion_nivel('ap26',$nitavu); // que nivel de permiso tiene sobre la aplicacion. entrega 1 - Super usuario, 2 Administrador, 3 Operador, 4 Consulta 

$nivel =aplicacion_nivel('ap26',$nitavu); // Extraemos el nivel en $nivel
//echo nivel_que($nivel); // nos da el modo; es decir la descripcion del nivel


//if (sanpedro ('ap26',$nitavu)==TRUE){  //La funcion san pedro te deja entrar si tienes permiso de uso, pero no le importa tu nivel, asi que ese hay 										que validarlo dentro segun se necesite, da un TRUE o FALSE
//	echo "Estoy dentro";			   // sanpedro (idapp, quien)
//}
//else
//{
//	echo "No tengo permiso";
//}




// echo dedondeeres($nitavu); // de donde es el usuario

//echo user_quien($nitavu); // quien es el usuario

//echo detectar(); // almacena detalles del equipo donde se abre la pagina


//$archivo = "fotos/".$nitavu.".jpg";
//echo ponerfoto($archivo,"foto"); // pone una imagen, sino existe pone sinfoto.png, ponerfoto(archivo,"clase")




//echo ponerpdf("ejemplopdf.pdf","completo vertical_completo"); //pone un archivo pdf sino se usa clase se usara la que este incluida en el objeto padre, clases disponible completo, mediano, chico y vertical_completo, vertical_mediano, vertical_chico



//echo nacimiento($nitavu); // extrae fecha de nacimiento, 



//echo "<b class='normal'> Soy un Texto normal</b>"; // ejemplo de clases de uso de color
//echo "<b class='ejecutandose'> Soy un Texto ejecutanse</b>"; // ejemplo de clases de uso de color
//echo "<b class='alerta'> Soy un Texto en alerta</b>"; // ejemplo de clases de uso de color
//echo "<b class='tenue'> Soy un Texto en tenue</b>"; // ejemplo de clases de uso de color


//echo "<b class='normal tgrande'> Soy un Texto normal Grande </b>"; // PUEDE COMBINARSE CON UNA SEGUNDA CLASE
//echo "<b class='ejecutandose tnormal'> Soy un Texto ejecutanse normal</b>"; // ejemplo de clases de uso de color
//echo "<b class='alerta tchico'> Soy un Texto en alerta chico</b>"; // ejemplo de clases de uso de color
//echo "<b class='tenue tchico'> Soy un Texto en tenue</b>"; // ejemplo de clases de uso de color



//USO DE CLASE BOTONES
// SE PUEDE CONVERTIR A BOTONES UN <a>, un <input submit> o un button

//echo "<a href='' class='btn btn-default'> Soy un Boton Vinculo modo Default </a>";
//echo "<input type='submit' class='btn btn-cancel' Value='Soy un Boton input Submit modo ALERTA'>"; // El tamaño esta determinado por el formulario cuando se incluya en un form, dentro de divs tomara la forma y se ajustara al formulario


// USO DEL AJUSTE EN FORM
// <form>
// <div>
//     <input type='submit'>  // <-- asi se adapta en dos columnas y 100% en movil
// </div>
// </form>


//
// <form>
// <span>
//     <input type='submit'>  // <-- Usa span para 100%, ejemplo un select que tenga contenido largo
// </span>
// </form>


//echo "<button class='btn btn-secundario' onclick=location.href=''>";
//echo "Soy un boton con javscript y la clase Seundario"; // aqui puede ir tambien una imagen, checa la carpeta de icon algunos disponibles
//echo "</button>";






// USO DE TABLAS
// la clase tabla va en la etiqueta <table>
// la clase tabla_titulo va en el TR donde van los titulos
//
// Ya esta con estilo unificado

// echo "<table class='tabla'>";
// 	echo "<tr class='tabla_titulo'>";
// 		echo "<td>Titulo 1</td>";
// 		echo "<td>Titulo 2</td>";
// 		echo "<td>Titulo 3</td>";
// 		echo "<td>Titulo 4</td>";
// 	echo "</tr>";

// 	echo "<tr>";
// 		echo "<td>Contenido 1</td>";
// 		echo "<td>Contenido 2</td>";
// 		echo "<td>Contenido 3</td>";
// 		echo "<td>Contenido 4</td>";
// 	echo "</tr>";

// 	echo "<tr>";
// 		echo "<td>Contenido 1</td>";
// 		echo "<td>Contenido 2</td>";
// 		echo "<td>Contenido 3</td>";
// 		echo "<td>Contenido 4</td>";
// 	echo "</tr>";
// echo "</table>";






// uso de titulos H
// usalos para desplegar algun titulo
// echo "<h1> Soy un H1 </h1>";
// echo "<h2> Soy un H2 </h2>";
// echo "<h3> Soy un H3 </h3>";
// echo "<h4> Soy un H4 </h4>";
// echo "<h5> Soy un H5 </h5>";
// echo "<h6> Soy un H6 </h6>";


//USO DE INPUTS EN LOS FORM

// echo "<form>";

// echo "<span>"; //usa span para 100%
// 	echo "<input type='text' id='myid' name='myname'>";
// echo "</span>";

// echo "<div>"; //usa div para doble columna
// 	echo "<input type='text' id='myid' name='myname'>";
// echo "</div>";

// echo "<div>"; //usa div para doble columna
// 	echo "<input type='text' id='myid' name='myname' required='required'>"; // obliga required al usuario a introducir el dato
// echo "</div>";

// echo "<div>"; // para almanecar textos, se hace mediante text area, ya estan puestos los botones para introducir RTF
// 	echo "<textarea name='myname' id='myname'></textarea>";
// echo "</div>";




// echo "<div>";
// 	echo "<input type='submit' class='btn btn-default' value='Guargar'>";
// echo "</div>";

// echo "</form>";

// echo "<a href='test/formas.php'> Ver mas ejemplos de formas </a>";







// INTERACCION CON LA BD

// consulta basica
// $sql = "SELECT * FROM empleados WHERE nitavu='".$nitavu."'";
// $rc= $conexion -> query($sql); // se ejecuta la consulta
// if($f = $rc -> fetch_array()) // almacenamos la consulta en el array
// 	{
// 		echo  $f['nombre']; // acceso al registro que se almaceno en el array
			
// 	}



// recorrido de una tabla de la bd
// $sql = "SELECT * FROM empleados WHERE departamento='Departamento de Informatica'";
// $rc= $conexion -> query($sql); // ejecusion de la consulta
// while($f = $rc -> fetch_array()) // almacenado en el array
// 	{
// 		echo $f['nitavu']." - ".$f['nombre']."<br>";
		
// 	}












?>


<!-- para generar algo de espacios -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>



<?php // PIE DE PAGINA (NO MOVER)
include ("./unica/body_footer.php");
?>