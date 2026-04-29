<?php
function RI_SQL1($id_rep){
	require("config.php");    
	$t=""; $TipoDeReporte="";
		$sqlOrigin = "SELECT * FROM Reporteador_Reportes WHERE id_rep='".$id_rep."'";
		$rc= $conexion -> query($sqlOrigin);
		if($f = $rc -> fetch_array()){
			$sql = $f['sql1'];
			$TipoDeReporte = $f['interactivo'];
			$BD = $f['basededatos'];
	
			$var1 = $f['var1'];
			$var1_type = $f['var1_type'];
			$var1_label = $f['var1_label'];
	
	
			$var2 = $f['var2'];
			$var2_type = $f['var2_type'];
			$var2_label = $f['var2_label'];
	
	
			$var3 = $f['var3'];
			$var3_type = $f['var3_type'];
			$var3_label = $f['var3_label'];
			
	
	}
			
			if (isset($_GET['var1'])){ // si detectamos el valor de var1			
				$var1_str = $_GET['var1']; if (ValidaVAR($var1_str)==TRUE){$var1_str = LimpiarVAR($var1_str);} else {$var1_str = "";}
				$sql = str_replace("{var1}", $var1_str, $sql); //actualizamos la consulta
				$SQL_go = TRUE;
				// echo "Calculando";
				Reporteador_repestatus($id_rep, $_GET['token'], FALSE);
	
			}
			
	
			if (isset($_GET['var2'])){ // si detectamos el valor de var1			
				$var2_str = $_GET['var2']; if (ValidaVAR($var2_str)==TRUE){$var2_str = LimpiarVAR($var2_str);} else {$var2_str = "";}
				$sql = str_replace("{var2}", $var2_str, $sql); //actualizamos la consulta
				$SQL_go = TRUE;
				// echo $var2_str;
			}
			
	
			if (isset($_GET['var3'])){ // si detectamos el valor de var1			
				$var3_str = $_GET['var3']; if (ValidaVAR($var3_str)==TRUE){$var3_str = LimpiarVAR($var3_str);} else {$var3_str = "";}
				$sql = str_replace("{var3}", $var3_str, $sql); //actualizamos la consulta
				$SQL_go = TRUE;
			}
			
			// echo "SQL OK = " . $sql1_OK;
		
	
		//2) Llenamos la consulta las variables {var1}
		// echo $sql;
		if ($SQL_go == TRUE){
				//CONSTRUIMOS t1
				$style_td_titulo='background-color:#939699; ';
				$style_td='border: 1px solid gray;';
				$HoraInicio = $hora;
				if(!empty($sql) == true){
					$cuantas_columnas=0;
					$tabla_titulos = "<tr>";
					switch ($BD) {
						case "P": $r2 = $conexion -> query($sql);break;
						case "V": $r2 = $Vivienda -> query($sql);break;		
						default: $r2 = $conexion -> query($sql);break;	
					}
					
					
					
					if($r2){
						$registros = 0;
						while($finfo = $r2->fetch_field()){//OBTENER LAS COLUMNAS
							/* obtener posición del puntero de campo */
							$currentfield = $r2->current_field;
							$tabla_titulos=$tabla_titulos.'<td align=left style="'.$style_td_titulo.'"><b>'.$finfo->name."</b></td>";
							$cuantas_columnas = $cuantas_columnas + 1;
							
						}
						$tabla_titulos = $tabla_titulos."</tr>";
						$tabla_contenido=""; $cuantas_filas=0;
						switch ($BD) {
							case "P": $r = $conexion -> query($sql);break;
							case "V": $r = $Vivienda -> query($sql);break;		
							default: $r = $conexion -> query($sql);break;	
						}
						
						
						while($f = $r-> fetch_row()){//LISTAR COLUMNAS
							$tabla_contenido = $tabla_contenido."<tr>";
								for ($i = 1; $i <= $cuantas_columnas; $i++) {
									if($cuantas_filas%2==0){
										$tabla_contenido= $tabla_contenido.'<td align=left style="right:0;  background-color:white">'.$f[$i-1]."</td>";
									}else{
										$tabla_contenido= $tabla_contenido.'<td align=left style="right:0; background-color:#CACACA;">'.$f[$i-1]."</td>";
									}
								}
							$tabla_contenido = $tabla_contenido."</tr>";
							$cuantas_filas = $cuantas_filas + 1;
							
						}
						$t="";                
						$style_table='
							width:100%;
							text-align: left;
							border: 1px solid gray;
						';
						$HoraFinal = $hora;
						if ($var1 == 1){
							$t = $t.'<br>PARAMETROS USADOS: '.$var1_label.": ".$var1_str;
						}
						if ($var2 == 1){
							$t = $t.', '.$var2_label.":".$var2_str;
						}
						if ($var3 == 1){
							$t = $t.', '.$var3_label.":".$var3_str;
						}
	
						$t = $t.''.'<br><table style="'.$style_table.'">'.$tabla_titulos.$tabla_contenido."</table>";
						$t = $t.'<br><b>Total de Registros consultados: </b>'.$cuantas_filas.', ';
						if ($BD == 'P'){
							$t = $t.' de la Base de Datos de la Plataforma.';
						} else {
							$t = $t.' de la Base de Datos de Vivienda';
	
						}
						
					}else{
						$t="ERROR";
					}
	
					return $t;
				}  else {return "";}
			}
	
	
	
	Reporteador_repestatus($id_rep, $_GET['token'], TRUE);
	
	}
	