<?php
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .autoriza-body {
        font-family: 'Inter', sans-serif !important;
        background-color: #f8fafc !important;
        padding: 24px !important;
        box-sizing: border-box !important;
        width: 100% !important;
        min-height: 100vh !important;
    }
    
    /* Headers styling */
    .autoriza-body h1 {
        font-size: 16px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        margin: 28px 0 16px 0 !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        font-family: 'Inter', sans-serif !important;
    }
    .autoriza-body h1::before {
        content: "" !important;
        display: inline-block !important;
        width: 4px !important;
        height: 18px !important;
        background-color: #7c121d !important; /* Guinda */
        border-radius: 2px !important;
    }
    
    /* Horizontal lines */
    .autoriza-body hr {
        border: 0 !important;
        border-top: 1.5px solid #e2e8f0 !important;
        margin: 32px 0 !important;
    }

    /* Cards container */
    .autoriza-grid {
        display: grid !important;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)) !important;
        gap: 20px !important;
        width: 100% !important;
        box-sizing: border-box !important;
        margin-bottom: 24px !important;
    }

    /* Card Layout */
    .autoriza-card {
        background-color: #ffffff !important;
        border-radius: 16px !important;
        border: 1.5px solid #bc955c !important; /* Elegant gold border */
        box-shadow: 0 10px 25px -5px rgba(188, 149, 92, 0.04) !important;
        padding: 20px !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 16px !important;
        box-sizing: border-box !important;
        width: 100% !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        position: relative !important;
        overflow: hidden !important;
    }
    .autoriza-card:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 15px 30px -5px rgba(124, 18, 29, 0.1) !important;
        border-color: #7c121d !important; /* Highlights in guinda on hover */
    }

    /* Card Top: Photo & Info & Actions */
    .autoriza-card-top {
        display: flex !important;
        align-items: flex-start !important;
        justify-content: space-between !important;
        gap: 14px !important;
        width: 100% !important;
    }
    .autoriza-employee-info {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        flex-grow: 1 !important;
    }
    .autoriza-photo {
        width: 52px !important;
        height: 52px !important;
        border-radius: 50% !important;
        object-fit: cover !important;
        border: 2px solid #e2e8f0 !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;
        flex-shrink: 0 !important;
    }
    .autoriza-details {
        display: flex !important;
        flex-direction: column !important;
        gap: 2px !important;
    }
    .autoriza-name {
        font-size: 13.5px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        line-height: 1.3 !important;
    }
    .autoriza-puesto {
        font-size: 11px !important;
        font-weight: 500 !important;
        color: #64748b !important;
        line-height: 1.35 !important;
    }

    /* Actions block */
    .autoriza-actions {
        display: flex !important;
        flex-direction: column !important;
        gap: 8px !important;
        flex-shrink: 0 !important;
    }
    
    /* Action Buttons styling */
    .autoriza-btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        padding: 8px 14px !important;
        border: none !important;
        border-radius: 8px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        font-family: 'Inter', sans-serif !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
    }
    
    .autoriza-btn-ok {
        background-color: #e6f4ea !important;
        color: #137333 !important;
        border: 1px solid #ceead6 !important;
    }
    .autoriza-btn-ok:hover {
        background-color: #137333 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(19, 115, 51, 0.2) !important;
    }

    .autoriza-btn-cancel {
        background-color: #fce8e6 !important;
        color: #c5221f !important;
        border: 1px solid #fad2cf !important;
    }
    .autoriza-btn-cancel:hover {
        background-color: #c5221f !important;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(197, 34, 31, 0.2) !important;
    }

    /* Card Bottom: Permiso details */
    .autoriza-card-bottom {
        background-color: #f8fafc !important;
        border-radius: 10px !important;
        padding: 12px 14px !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 8px !important;
        border: 1px solid #e2e8f0 !important;
    }
    .autoriza-info-row {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        font-size: 11.5px !important;
        color: #64748b !important;
    }
    .autoriza-info-row span {
        font-weight: 500 !important;
    }
    .autoriza-info-row strong {
        color: #334155 !important;
        font-weight: 600 !important;
    }
    .autoriza-justificacion {
        font-size: 12px !important;
        color: #334155 !important;
        line-height: 1.45 !important;
        border-top: 1px dashed #cbd5e1 !important;
        padding-top: 8px !important;
        margin-top: 2px !important;
    }
    
    /* Preloader styling inside card */
    .autoriza-preloader {
        padding: 30px !important;
        text-align: center !important;
        width: 100% !important;
        box-sizing: border-box !important;
        background-color: #ffffff !important;
        border-radius: 16px !important;
        border: 1.5px solid #bc955c !important;
        margin-bottom: 20px !important;
    }
    .autoriza-preloader img {
        width: 48px !important;
        height: auto !important;
    }

    /* AJAX Result Alert Boxes */
    .autoriza-card-result-ok {
        background-color: #e6f4ea !important;
        border: 1.5px solid #ceead6 !important;
        color: #137333 !important;
        border-radius: 12px !important;
        padding: 16px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        text-align: center !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    .autoriza-card-result-error {
        background-color: #fce8e6 !important;
        border: 1.5px solid #fad2cf !important;
        color: #c5221f !important;
        border-radius: 12px !important;
        padding: 16px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        text-align: center !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    
    /* Empty State styling */
    .autoriza-empty-state {
        grid-column: 1 / -1 !important;
        background-color: #ffffff !important;
        border-radius: 16px !important;
        border: 1px dashed #cbd5e1 !important;
        padding: 32px !important;
        text-align: center !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 12px !important;
        color: #64748b !important;
    }
    .autoriza-empty-state i {
        font-size: 32px !important;
        color: #cbd5e1 !important;
    }
    .autoriza-empty-state span {
        font-size: 13px !important;
        font-weight: 500 !important;
    }
</style>

<script>
function OK_pase(IdPase, Nitavu){   
	$("#preloader_"+IdPase).css({'display':'block'});
	$("#Pase_"+IdPase).css({'display':'none'});
	$.ajax({
		url: "auscencia_temporal_autoriza_ok.php",
	   type: "post",
	   data: {id: IdPase, nitavu: Nitavu },
	   success: function(data){
		$("#Pase_"+IdPase).css({'display':'block'});
		$('#Pase_'+IdPase).html(data+"\n");
		$("#preloader_"+IdPase).css({'display':'none'});
	   }
	});
}

function X_pase(IdPase, Nitavu){   
   $("#preloader_"+IdPase).css({'display':'block'});
   $("#Pase_"+IdPase).css({'display':'none'});
   $.ajax({
	   url: "auscencia_temporal_autoriza_x.php",
	  type: "post",
	  data: {id: IdPase, nitavu: Nitavu },
	  success: function(data){
	   $("#Pase_"+IdPase).css({'display':'block'});
	   $('#Pase_'+IdPase).html(data+"\n");
	   $("#preloader_"+IdPase).css({'display':'none'});
	  }
   });
}
</script>

<?php
$id_aplicacion ="ap12";
$nivel = aplicacion_nivel($id_aplicacion,$nitavu);

if (sanpedro($id_aplicacion, $nitavu) == TRUE) {
	echo "<div id='AppDetalle'>" . app_detalle($id_aplicacion, $nitavu) . "</div>";
    echo "<div class='autoriza-body'>";
	
	if($nivel == 1) { // ADMINISTRADOR GENERAL: Aprueba todo
		echo "<h1>Puede aprobar cualquier pase en el Instituto:</h1>";
		echo "<div class='autoriza-grid'>";

		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' )";	
		$rc = $conexion->query($sql);
        $count = 0;
		while($f = $rc -> fetch_array()) {
            $count++;
			echo "<div id='preloader_".$f['id']."' class='autoriza-preloader' style='display:none;'><img src='img/cargando4.gif' alt='Cargando...'></div>";

			echo "<div id='Pase_".$f['id']."' class='autoriza-card'>";
			echo "<div class='autoriza-card-top'>";
			echo "<div class='autoriza-employee-info'>";
			echo ponerfoto("fotos/".$f['nitavu'].".jpg", 'autoriza-photo');
			echo "<div class='autoriza-details'>";
			echo "<span class='autoriza-name'>".strtoupper(nitavu_nombre($f['nitavu']))."</span>";
			echo "<span class='autoriza-puesto'>".nitavu_puesto($f['nitavu'])." de <br><strong>".nitavu_dpto_nombre($f['nitavu'])."</strong></span>";
			echo "</div>";
			echo "</div>";
			
			echo "<div class='autoriza-actions'>";
			echo "<button class='autoriza-btn autoriza-btn-ok' onclick=\"OK_pase('".$f['id']."','".$nitavu."');\"><i class='fa-solid fa-circle-check'></i> Autorizar</button>";
			echo "<button class='autoriza-btn autoriza-btn-cancel' onclick=\"X_pase('".$f['id']."','".$nitavu."');\"><i class='fa-solid fa-circle-xmark'></i> Rechazar</button>";
			echo "</div>";
			echo "</div>";
			
			echo "<div class='autoriza-card-bottom'>";
			echo "<div class='autoriza-info-row'><span>Fecha de salida:</span><strong>".fecha_larga($f['fecha'])."</strong></div>";
			echo "<div class='autoriza-info-row'><span>Hora programada:</span><strong>".hora12($f['hora_desde'])."</strong></div>";
			echo "<div class='autoriza-info-row'><span>ID Pase:</span><strong>#".$f['id']."</strong></div>";
			echo "<div class='autoriza-info-row'><span>Asunto:</span><strong>".$f['asunto']."</strong></div>";
			echo "<div class='autoriza-justificacion'><strong>Motivo:</strong> ".$f['justificacion']."</div>";
			echo "</div>";

			echo "</div>";
		}
        if ($count == 0) {
            echo "<div class='autoriza-empty-state'>";
            echo "<i class='fa-regular fa-folder-open'></i>";
            echo "<span>No hay pases de salida pendientes de autorizar.</span>";
            echo "</div>";
        }
		echo "</div>"; // .autoriza-grid
	}

	if($nivel == 2) { // ADMINISTRADOR: Aprueba todos los titulares que dependan de el
		echo "<h1>Puede aprobar pases de los titulares que dependan de ud.:</h1>";
		echo "<div class='autoriza-grid'>";

		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' AND dpto in(".misdptos($nitavu).") )";	
		$rc = $conexion->query($sql);
        $count1 = 0;
		while($f = $rc -> fetch_array()) {
			$tit = soytitular($f['nitavu']);
			if ($tit == 'FALSE') {} // filtra solo titulares
			else {
                $count1++;
                echo "<div id='preloader_".$f['id']."' class='autoriza-preloader' style='display:none;'><img src='img/cargando4.gif' alt='Cargando...'></div>";

                echo "<div id='Pase_".$f['id']."' class='autoriza-card'>";
                echo "<div class='autoriza-card-top'>";
                echo "<div class='autoriza-employee-info'>";
                echo ponerfoto("fotos/".$f['nitavu'].".jpg", 'autoriza-photo');
                echo "<div class='autoriza-details'>";
                echo "<span class='autoriza-name'>".strtoupper(nitavu_nombre($f['nitavu']))."</span>";
                echo "<span class='autoriza-puesto'>".nitavu_puesto($f['nitavu'])." de <br><strong>".nitavu_dpto_nombre($f['nitavu'])."</strong></span>";
                echo "</div>";
                echo "</div>";
                
                echo "<div class='autoriza-actions'>";
                echo "<button class='autoriza-btn autoriza-btn-ok' onclick=\"OK_pase('".$f['id']."','".$nitavu."');\"><i class='fa-solid fa-circle-check'></i> Autorizar</button>";
                echo "<button class='autoriza-btn autoriza-btn-cancel' onclick=\"X_pase('".$f['id']."','".$nitavu."');\"><i class='fa-solid fa-circle-xmark'></i> Rechazar</button>";
                echo "</div>";
                echo "</div>";
                
                echo "<div class='autoriza-card-bottom'>";
                echo "<div class='autoriza-info-row'><span>Fecha de salida:</span><strong>".fecha_larga($f['fecha'])."</strong></div>";
                echo "<div class='autoriza-info-row'><span>Hora programada:</span><strong>".hora12($f['hora_desde'])."</strong></div>";
                echo "<div class='autoriza-info-row'><span>ID Pase:</span><strong>#".$f['id']."</strong></div>";
                echo "<div class='autoriza-info-row'><span>Asunto:</span><strong>".$f['asunto']."</strong></div>";
                echo "<div class='autoriza-justificacion'><strong>Motivo:</strong> ".$f['justificacion']."</div>";
                echo "</div>";

                echo "</div>";
			}
		}
        if ($count1 == 0) {
            echo "<div class='autoriza-empty-state'>";
            echo "<i class='fa-regular fa-folder-open'></i>";
            echo "<span>No hay pases de titulares pendientes de autorizar.</span>";
            echo "</div>";
        }
		echo "</div>"; // .autoriza-grid

		// para el resto del personal
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' AND dpto in(".misdptos($nitavu).") )";	
		$rc = $conexion->query($sql);
		echo "<h1>Personal que depende de ud:</h1>";
        echo "<div class='autoriza-grid'>";
        $count2 = 0;
		while($f = $rc -> fetch_array()) {
			$tit = soytitular($f['nitavu']);
			if ($tit <> 'FALSE') {} // filtra solo titulares
			else {
                $count2++;
                echo "<div id='preloader_".$f['id']."' class='autoriza-preloader' style='display:none;'><img src='img/cargando4.gif' alt='Cargando...'></div>";

                echo "<div id='Pase_".$f['id']."' class='autoriza-card'>";
                echo "<div class='autoriza-card-top'>";
                echo "<div class='autoriza-employee-info'>";
                echo ponerfoto("fotos/".$f['nitavu'].".jpg", 'autoriza-photo');
                echo "<div class='autoriza-details'>";
                echo "<span class='autoriza-name'>".strtoupper(nitavu_nombre($f['nitavu']))."</span>";
                echo "<span class='autoriza-puesto'>".nitavu_puesto($f['nitavu'])." de <br><strong>".nitavu_dpto_nombre($f['nitavu'])."</strong></span>";
                echo "</div>";
                echo "</div>";
                
                echo "<div class='autoriza-actions'>";
                echo "<button class='autoriza-btn autoriza-btn-ok' onclick=\"OK_pase('".$f['id']."','".$nitavu."');\"><i class='fa-solid fa-circle-check'></i> Autorizar</button>";
                echo "<button class='autoriza-btn autoriza-btn-cancel' onclick=\"X_pase('".$f['id']."','".$nitavu."');\"><i class='fa-solid fa-circle-xmark'></i> Rechazar</button>";
                echo "</div>";
                echo "</div>";
                
                echo "<div class='autoriza-card-bottom'>";
                echo "<div class='autoriza-info-row'><span>Fecha de salida:</span><strong>".fecha_larga($f['fecha'])."</strong></div>";
                echo "<div class='autoriza-info-row'><span>Hora programada:</span><strong>".hora12($f['hora_desde'])."</strong></div>";
                echo "<div class='autoriza-info-row'><span>ID Pase:</span><strong>#".$f['id']."</strong></div>";
                echo "<div class='autoriza-info-row'><span>Asunto:</span><strong>".$f['asunto']."</strong></div>";
                echo "<div class='autoriza-justificacion'><strong>Motivo:</strong> ".$f['justificacion']."</div>";
                echo "</div>";

                echo "</div>";
			}
		}
        if ($count2 == 0) {
            echo "<div class='autoriza-empty-state'>";
            echo "<i class='fa-regular fa-folder-open'></i>";
            echo "<span>No hay pases de personal subordinado pendientes de autorizar.</span>";
            echo "</div>";
        }
		echo "</div>"; // .autoriza-grid
	}

	if($nivel == 3) { // OPERADOR: Aprueba a los que dependen de el, a nivel dpto
	    echo "<h1>Puede aprobar solo a tu dpto.</h1>";
		echo "<div class='autoriza-grid'>";
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' AND dpto='".nitavu_dpto($nitavu)."')";	
		$rc = $conexion->query($sql);
        $count3 = 0;
		while($f = $rc -> fetch_array()) {
            $count3++;
            echo "<div id='preloader_".$f['id']."' class='autoriza-preloader' style='display:none;'><img src='img/cargando4.gif' alt='Cargando...'></div>";

            echo "<div id='Pase_".$f['id']."' class='autoriza-card'>";
            echo "<div class='autoriza-card-top'>";
            echo "<div class='autoriza-employee-info'>";
            echo ponerfoto("fotos/".$f['nitavu'].".jpg", 'autoriza-photo');
            echo "<div class='autoriza-details'>";
            echo "<span class='autoriza-name'>".strtoupper(nitavu_nombre($f['nitavu']))."</span>";
            echo "<span class='autoriza-puesto'>".nitavu_puesto($f['nitavu'])." de <br><strong>".nitavu_dpto_nombre($f['nitavu'])."</strong></span>";
            echo "</div>";
            echo "</div>";
            
            echo "<div class='autoriza-actions'>";
            echo "<button class='autoriza-btn autoriza-btn-ok' onclick=\"OK_pase('".$f['id']."','".$nitavu."');\"><i class='fa-solid fa-circle-check'></i> Autorizar</button>";
            echo "<button class='autoriza-btn autoriza-btn-cancel' onclick=\"X_pase('".$f['id']."','".$nitavu."');\"><i class='fa-solid fa-circle-xmark'></i> Rechazar</button>";
            echo "</div>";
            echo "</div>";
            
            echo "<div class='autoriza-card-bottom'>";
            echo "<div class='autoriza-info-row'><span>Fecha de salida:</span><strong>".fecha_larga($f['fecha'])."</strong></div>";
            echo "<div class='autoriza-info-row'><span>Hora programada:</span><strong>".hora12($f['hora_desde'])."</strong></div>";
            echo "<div class='autoriza-info-row'><span>ID Pase:</span><strong>#".$f['id']."</strong></div>";
            echo "<div class='autoriza-info-row'><span>Asunto:</span><strong>".$f['asunto']."</strong></div>";
            echo "<div class='autoriza-justificacion'><strong>Motivo:</strong> ".$f['justificacion']."</div>";
            echo "</div>";

            echo "</div>";
		}
        if ($count3 == 0) {
            echo "<div class='autoriza-empty-state'>";
            echo "<i class='fa-regular fa-folder-open'></i>";
            echo "<span>No hay pases de salida pendientes en tu departamento.</span>";
            echo "</div>";
        }
		echo "</div>"; // .autoriza-grid

		// SI TIENE DPTOS QUE DEPENDAN DE EL, TAMBIEN PODRA APROBARLOS TANTO A LOS JEFES COMO A TODOS LOS QUE DEPENDAN
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' AND dpto in(".misdptos_sinmi($nitavu).") )";	
		$rc = $conexion->query($sql);
		if ($conexion->query($sql) == TRUE) {
            echo "<hr><h1>Personal de los dptos que dependen ti: </h1>";
            echo "<div class='autoriza-grid'>";
            $count4 = 0;
            while($f = $rc -> fetch_array()) {
                $count4++;
                echo "<div id='preloader_".$f['id']."' class='autoriza-preloader' style='display:none;'><img src='img/cargando4.gif' alt='Cargando...'></div>";

                echo "<div id='Pase_".$f['id']."' class='autoriza-card'>";
                echo "<div class='autoriza-card-top'>";
                echo "<div class='autoriza-employee-info'>";
                echo ponerfoto("fotos/".$f['nitavu'].".jpg", 'autoriza-photo');
                echo "<div class='autoriza-details'>";
                echo "<span class='autoriza-name'>".strtoupper(nitavu_nombre($f['nitavu']))."</span>";
                echo "<span class='autoriza-puesto'>".nitavu_puesto($f['nitavu'])." de <br><strong>".nitavu_dpto_nombre($f['nitavu'])."</strong></span>";
                echo "</div>";
                echo "</div>";
                
                echo "<div class='autoriza-actions'>";
                echo "<button class='autoriza-btn autoriza-btn-ok' onclick=\"OK_pase('".$f['id']."','".$nitavu."');\"><i class='fa-solid fa-circle-check'></i> Autorizar</button>";
                echo "<button class='autoriza-btn autoriza-btn-cancel' onclick=\"X_pase('".$f['id']."','".$nitavu."');\"><i class='fa-solid fa-circle-xmark'></i> Rechazar</button>";
                echo "</div>";
                echo "</div>";
                
                echo "<div class='autoriza-card-bottom'>";
                echo "<div class='autoriza-info-row'><span>Fecha de salida:</span><strong>".fecha_larga($f['fecha'])."</strong></div>";
                echo "<div class='autoriza-info-row'><span>Hora programada:</span><strong>".hora12($f['hora_desde'])."</strong></div>";
                echo "<div class='autoriza-info-row'><span>ID Pase:</span><strong>#".$f['id']."</strong></div>";
                echo "<div class='autoriza-info-row'><span>Asunto:</span><strong>".$f['asunto']."</strong></div>";
                echo "<div class='autoriza-justificacion'><strong>Motivo:</strong> ".$f['justificacion']."</div>";
                echo "</div>";

                echo "</div>";
            }
            if ($count4 == 0) {
                echo "<div class='autoriza-empty-state'>";
                echo "<i class='fa-regular fa-folder-open'></i>";
                echo "<span>No hay pases de departamentos subordinados pendientes de autorizar.</span>";
                echo "</div>";
            }
            echo "</div>"; // .autoriza-grid
		}
	}

	// Alterarlo y ponerle si tienen dptos autorizados agregarlos aut	
	if (pases_dptosaut_n($nitavu)>0){
		echo "<hr><h1 style='font-size: 13.5px !important;'>Aut. Extraordinaria para aprobar <b>".pases_dptosaut_nombre($nitavu)."</b></h1>";
		echo "<div class='autoriza-grid'>";
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND fecha>='".$fecha."' AND dpto in(".pases_dptosaut($nitavu).") and nitavu<>'".$nitavu."')";	
		
		if ($conexion->query($sql) == TRUE) {
		    $rc = $conexion->query($sql);
            $count5 = 0;
            while($f = $rc -> fetch_array()) {
                $count5++;
                echo "<div id='preloader_".$f['id']."' class='autoriza-preloader' style='display:none;'><img src='img/cargando4.gif' alt='Cargando...'></div>";

                echo "<div id='Pase_".$f['id']."' class='autoriza-card'>";
                echo "<div class='autoriza-card-top'>";
                echo "<div class='autoriza-employee-info'>";
                echo ponerfoto("fotos/".$f['nitavu'].".jpg", 'autoriza-photo');
                echo "<div class='autoriza-details'>";
                echo "<span class='autoriza-name'>".strtoupper(nitavu_nombre($f['nitavu']))."</span>";
                echo "<span class='autoriza-puesto'>".nitavu_puesto($f['nitavu'])." de <br><strong>".nitavu_dpto_nombre($f['nitavu'])."</strong></span>";
                echo "</div>";
                echo "</div>";
                
                echo "<div class='autoriza-actions'>";
                echo "<button class='autoriza-btn autoriza-btn-ok' onclick=\"OK_pase('".$f['id']."','".$nitavu."');\"><i class='fa-solid fa-circle-check'></i> Autorizar</button>";
                echo "<button class='autoriza-btn autoriza-btn-cancel' onclick=\"X_pase('".$f['id']."','".$nitavu."');\"><i class='fa-solid fa-circle-xmark'></i> Rechazar</button>";
                echo "</div>";
                echo "</div>";
                
                echo "<div class='autoriza-card-bottom'>";
                echo "<div class='autoriza-info-row'><span>Fecha de salida:</span><strong>".fecha_larga($f['fecha'])."</strong></div>";
                echo "<div class='autoriza-info-row'><span>Hora programada:</span><strong>".hora12($f['hora_desde'])."</strong></div>";
                echo "<div class='autoriza-info-row'><span>ID Pase:</span><strong>#".$f['id']."</strong></div>";
                echo "<div class='autoriza-info-row'><span>Asunto:</span><strong>".$f['asunto']."</strong></div>";
                echo "<div class='autoriza-justificacion'><strong>Motivo:</strong> ".$f['justificacion']."</div>";
                echo "</div>";

                echo "</div>";
            }
            if ($count5 == 0) {
                echo "<div class='autoriza-empty-state'>";
                echo "<i class='fa-regular fa-folder-open'></i>";
                echo "<span>No hay pases extraordinarios pendientes de autorizar.</span>";
                echo "</div>";
            }
		}
		if (pases_dptosaut($nitavu)==''){
			sentimental("Por el momento no tiene ningun departamento autorizado");
		}
		echo "</div>"; // .autoriza-grid
	}

    echo "</div>"; // .autoriza-body
}
else {
    echo "<div class='autoriza-body'>";
    echo "<div class='autoriza-card-result-error'><i class='fa-solid fa-circle-xmark'></i> No tiene acceso a la aplicación ".$id_aplicacion."</div>";
    echo "</div>";
}

include ("./lib/body_footer.php");
?>