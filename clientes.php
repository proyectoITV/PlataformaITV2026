<?php 
require_once("config.php");
include("lib/body_head.php"); 
include("lib/body_menu.php"); 
?>

<!-- ================= BANNER DE FONDO: GRADIENT MESH + BOKEH LIGHT PARTICLES ================= -->
<div id="bokeh-container">
  <canvas id="bokehCanvas"></canvas>
</div>

<style>
#bokeh-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  z-index: -1;
  overflow: hidden;
  background: radial-gradient(circle at 15% 15%, #4a0512 0%, #20040a 45%, #0d0205 100%);
}

#bokehCanvas {
  display: block;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  pointer-events: none;
}

.cd-client-wrapper {
  position: relative;
  z-index: 10;
  max-width: 900px;
  margin: 36px auto 60px auto;
  padding: 0 20px;
  box-sizing: border-box;
}

.cd-client-card {
  background: rgba(255, 255, 255, 0.96) !important;
  backdrop-filter: blur(16px) !important;
  -webkit-backdrop-filter: blur(16px) !important;
  border: 1.5px solid rgba(188, 149, 92, 0.4) !important;
  border-radius: 20px !important;
  padding: 32px 36px !important;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35) !important;
  text-align: left !important;
  transition: all 0.3s ease !important;
}

.cd-client-card-header {
  display: flex !important;
  align-items: center !important;
  justify-content: space-between !important;
  border-bottom: 2px solid #f1f5f9 !important;
  padding-bottom: 16px !important;
  margin-bottom: 24px !important;
}

.cd-client-card-title {
  font-size: 20px !important;
  font-weight: 700 !important;
  color: #0f172a !important;
  display: flex !important;
  align-items: center !important;
  gap: 12px !important;
  margin: 0 !important;
}

.cd-client-card-title i {
  color: #7c121d !important;
  font-size: 22px !important;
}

.cd-client-badge {
  background: rgba(188, 149, 92, 0.15) !important;
  color: #7c121d !important;
  border: 1px solid rgba(188, 149, 92, 0.3) !important;
  padding: 4px 12px !important;
  border-radius: 20px !important;
  font-size: 12px !important;
  font-weight: 600 !important;
}

.cd-form-grid-2 {
  display: grid !important;
  grid-template-columns: 1fr 1fr !important;
  gap: 16px !important;
  margin-bottom: 16px !important;
}

@media (max-width: 640px) {
  .cd-form-grid-2 {
    grid-template-columns: 1fr !important;
  }
  .cd-client-card {
    padding: 20px !important;
  }
}

.cd-client-table {
  width: 100% !important;
  border-collapse: separate !important;
  border-spacing: 0 !important;
  margin-top: 16px !important;
  border-radius: 12px !important;
  overflow: hidden !important;
  border: 1px solid #e2e8f0 !important;
}

.cd-client-table th {
  background: #7a0000 !important;
  color: #ffffff !important;
  padding: 12px 16px !important;
  font-size: 12.5px !important;
  font-weight: 700 !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
  border-bottom: 2px solid #bc955c !important;
}

.cd-client-table td {
  padding: 12px 16px !important;
  border-bottom: 1px solid #e2e8f0 !important;
  background: #ffffff !important;
  font-size: 13.5px !important;
  color: #334155 !important;
  vertical-align: middle !important;
}

.cd-client-table tr:hover td {
  background: #fdf8f9 !important;
}
</style>

<div class="cd-client-wrapper">
  <div class="cd-client-card">
    <div class="cd-client-card-header">
      <h2 class="cd-client-card-title">
        <i class="fa-solid fa-users-gear"></i> Gestión de Clientes y Beneficiarios
      </h2>
      <span class="cd-client-badge"><i class="fa-solid fa-shield-halved"></i> Registro ITAVU</span>
    </div>

<?php
$nitavu = (isset($_SESSION['nitavu'])) ? $_SESSION['nitavu'] : (isset($nitavu) ? $nitavu : '');
$nuc = $nitavu;
$id_aplicacion='ap3'; 
$nivel = (function_exists('aplicacion_nivel')) ? aplicacion_nivel($id_aplicacion, $nuc) : 1;	

if (function_exists('sanpedro') && sanpedro($id_aplicacion, $nuc) == TRUE) {

  if (isset($_GET['nuevo'])) { 
    echo "<div class='alert alert-info'><i class='fa-solid fa-user-plus'></i> <b>Nuevo Registro:</b> Ingrese la información del nuevo cliente beneficiario.</div>";
    
    echo "<form action='clientes.php' method='post'>";
    echo "<div class='cd-form-grid-2'>";
    echo "<div class='cd-form-group'><label class='cd-form-label'>CURP:</label><input type='text' name='curp' required class='cd-form-control' placeholder='Ej. ABCD123456HDFR09'></div>";
    echo "<div class='cd-form-group'><label class='cd-form-label'>Nombre del cliente:</label><input type='text' name='nombre' required class='cd-form-control'></div>";
    echo "<div class='cd-form-group'><label class='cd-form-label'>Fecha de Nacimiento:</label><input type='date' name='nacimiento' class='cd-form-control'></div>";
    echo "<div class='cd-form-group'><label class='cd-form-label'>IFE / INE:</label><input type='text' name='IFE' class='cd-form-control'></div>";
    echo "<div class='cd-form-group'><label class='cd-form-label'>Domicilio:</label><input type='text' name='domicilio' class='cd-form-control'></div>";
    echo "<div class='cd-form-group'><label class='cd-form-label'>Teléfono:</label><input type='text' name='telefono' class='cd-form-control'></div>";
    echo "<div class='cd-form-group'><label class='cd-form-label'>Municipio:</label><input type='text' name='municipio' class='cd-form-control'></div>";
    echo "<div class='cd-form-group'><label class='cd-form-label'>Estado:</label><input type='text' name='estado' value='Tamaulipas' class='cd-form-control'></div>";
    echo "</div>";
    echo "<div style='text-align:right; margin-top:16px;'><button type='submit' name='submit_nuevo' class='cd-btn cd-btn-primary'><i class='fa-solid fa-floppy-disk'></i> Guardar Cliente</button></div>";
    echo "</form>";

  } else if (isset($_GET['x'])) { // Cliente seleccionado para editar
    $curp_val = VarClean($_GET['x']);
    echo "<div class='alert alert-warning' style='border-left:4px solid #bc955c;'><i class='fa-solid fa-id-card'></i> Cliente seleccionado: <b>".$curp_val."</b></div>";
    $sql = "SELECT * FROM clientes WHERE curp='".$curp_val."'";
    $rc = $conexion->query($sql);
    
    if($cl = $rc->fetch_array()) {
      echo "<form action='clientes.php?x=".$curp_val."' method='post'>";
      echo "<div class='cd-form-grid-2'>";
      echo "<div class='cd-form-group'><label class='cd-form-label'>CURP:</label><input type='text' name='curp' readonly value='".$cl['curp']."' class='cd-form-control'></div>";
      echo "<div class='cd-form-group'><label class='cd-form-label'>Nombre del cliente:</label><input type='text' name='nombre' value='".htmlspecialchars($cl['nombre'])."' class='cd-form-control'></div>";
      echo "<div class='cd-form-group'><label class='cd-form-label'>Fecha de Nacimiento:</label><input type='date' name='nacimiento' value='".$cl['fechadenacimiento']."' class='cd-form-control'></div>";
      echo "<div class='cd-form-group'><label class='cd-form-label'>IFE / INE:</label><input type='text' name='IFE' value='".htmlspecialchars($cl['IFE'])."' class='cd-form-control'></div>";
      echo "<div class='cd-form-group'><label class='cd-form-label'>Domicilio:</label><input type='text' name='domicilio' value='".htmlspecialchars($cl['domicilio'])."' class='cd-form-control'></div>";
      echo "<div class='cd-form-group'><label class='cd-form-label'>Teléfono:</label><input type='text' name='telefono' value='".htmlspecialchars($cl['telefono'])."' class='cd-form-control'></div>";
      echo "<div class='cd-form-group'><label class='cd-form-label'>Municipio:</label><input type='text' name='municipio' value='".htmlspecialchars($cl['municipio'])."' class='cd-form-control'></div>";
      echo "<div class='cd-form-group'><label class='cd-form-label'>Estado:</label><input type='text' name='estado' value='".htmlspecialchars($cl['estado'])."' class='cd-form-control'></div>";
      echo "</div>";
      echo "<div style='display:flex; justify-content:space-between; align-items:center; margin-top:20px;'>";
      echo "<a href='clientes.php' class='cd-btn cd-btn-light'><i class='fa-solid fa-arrow-left'></i> Regresar a la Búsqueda</a>";
      echo "<button type='submit' name='submit_act' class='cd-btn cd-btn-primary'><i class='fa-solid fa-floppy-disk'></i> Actualizar Datos</button>";
      echo "</div>";
      echo "</form>";

      if (isset($_POST['submit_act'])) {
        $sql_upd = "UPDATE clientes SET 
          nombre='".VarClean($_POST['nombre'])."',
          ife='".VarClean($_POST['IFE'])."',
          domicilio='".VarClean($_POST['domicilio'])."',
          municipio='".VarClean($_POST['municipio'])."',
          estado='".VarClean($_POST['estado'])."',
          telefono='".VarClean($_POST['telefono'])."'
          WHERE curp='".VarClean($_POST['curp'])."'";

        if ($conexion->query($sql_upd) == TRUE) {
          echo "<div class='alert alert-success' style='margin-top:16px;'><i class='fa-solid fa-circle-check'></i> Datos actualizados con éxito.</div>";
        }
      }
    } else {
      if (function_exists('historia')) historia($nuc, "ERROR: ".$sql);
      if (function_exists('mensaje')) mensaje("Ha habido un error, el cliente no se encontró", '', 'error');
    }

  } else if (isset($_GET['q'])) { // Resultados de búsqueda
    $q_search = VarClean($_GET['q']);
    $sql = "SELECT * FROM clientes WHERE nombre like'%".$q_search."%' OR curp like '%".$q_search."%' LIMIT 50";
    if (function_exists('historia')) historia($nuc, "Buscó a ".$q_search);
    $r2 = $conexion->query($sql);
    
    echo "<div style='display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;'>";
    echo "<h3 style='font-size:16px; color:#0f172a; margin:0;'>Resultados para: <b style='color:#7c121d;'>".htmlspecialchars($q_search)."</b></h3>";
    echo "<a href='clientes.php' class='cd-btn cd-btn-light cd-btn-sm'><i class='fa-solid fa-magnifying-glass'></i> Nueva Búsqueda</a>";
    echo "</div>";

    echo "<table class='cd-client-table'>";
    echo "<thead><tr>";
    echo "<th class='pc' style='width:180px;'>CURP</th>";
    echo "<th>Nombre & Domicilio</th>";
    echo "<th style='width:80px; text-align:center;'>Acción</th>";
    echo "</tr></thead><tbody>";
    
    $c = 0;
    while($fr = $r2->fetch_array()) {
      echo "<tr>";
      echo "<td class='pc'><span class='cd-badge-id' style='background:#7c121d; font-size:11px;'>".$fr['curp']."</span></td>";
      echo "<td><b>".mb_strtoupper($fr['nombre'], 'UTF-8')."</b><br><span style='font-size:12px; color:#64748b;'><i class='fa-solid fa-location-dot'></i> ".$fr['domicilio']."</span> <span class='pc' style='font-size:11.5px; color:#7c121d;'> | <i class='fa-solid fa-phone'></i> ".$fr['telefono']."</span></td>";
      echo "<td align='center'>";
      echo "<a class='cd-icon-btn view' title='Ver / Editar Expediente' href='clientes.php?x=".$fr['curp']."'><i class='fa-solid fa-pen-to-square'></i></a>";
      echo "</td>";
      echo "</tr>";
      $c++;
    }
    if ($c == 0) {
      echo "<tr><td colspan='3' align='center' style='padding:24px; color:#64748b;'><i class='fa-solid fa-folder-open' style='font-size:24px; display:block; margin-bottom:8px;'></i> No se encontraron clientes con el criterio especificado.</td></tr>";
    }
    echo "</tbody></table>";

    echo "<div style='margin-top:24px; padding:16px; background:#f8fafc; border-radius:12px; border:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center;'>";
    echo "<span style='font-size:13px; color:#475569;'><i class='fa-solid fa-user-plus' style='color:#7c121d;'></i> ¿No encontró al cliente en la base de datos?</span>";
    echo "<a class='cd-btn cd-btn-gold' href='clientes.php?nuevo=1'><i class='fa-solid fa-plus'></i> Registrar Nuevo Cliente</a>";
    echo "</div>";

  } else { // Formulario principal de búsqueda
    echo "<div style='padding: 20px 0; text-align:center;'>";
    echo "<p style='font-size:14px; color:#64748b; margin-bottom:24px;'>Ingrese el nombre completo o CURP del cliente para consultar su expediente institucional.</p>";
    
    echo "<form action='clientes.php' method='get' class='cd-search-form' style='justify-content:center;'>";
    echo "<div class='cd-input-group' style='max-width:540px;'>";
    echo "<input type='text' name='q' class='cd-input' placeholder='Escriba el nombre o CURP del cliente...' required style='padding:12px 18px; font-size:15px; border-radius:12px;'>";
    echo "<button type='submit' class='cd-btn cd-btn-primary' style='padding:12px 24px; border-radius:12px;'><i class='fa-solid fa-magnifying-glass'></i> Buscar</button>";
    echo "</div>";
    echo "</form>";

    echo "<div style='margin-top:40px; display:flex; justify-content:center; gap:16px;'>";
    echo "<a href='clientes.php?nuevo=1' class='cd-btn cd-btn-outline-gold'><i class='fa-solid fa-user-plus'></i> Registrar Nuevo Cliente</a>";
    echo "</div>";
    echo "</div>";
  }

} else {
  if (function_exists('mensaje')) mensaje("Acceso denegado a esta aplicación", '', 'error');
  else echo "<div class='alert alert-danger'>Acceso denegado a esta aplicación</div>";
}
?>

  </div>
</div>

<!-- ================= SCRIPT PARA ANIMACIÓN DE BOKEH LIGHT CANVAS ================= -->
<script>
(function() {
  const canvas = document.getElementById('bokehCanvas');
  if(!canvas) return;
  const ctx = canvas.getContext('2d');
  let width, height;
  let particles = [];

  function resize() {
    width = canvas.width = window.innerWidth;
    height = canvas.height = window.innerHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  const colors = [
    'rgba(188, 149, 92, ',   // Gold #bc955c
    'rgba(245, 158, 11, ',   // Amber #f59e0b
    'rgba(124, 18, 29, ',    // Guinda #7c121d
    'rgba(255, 220, 175, '   // Light Gold
  ];

  class Particle {
    constructor() {
      this.reset();
    }
    reset() {
      this.x = Math.random() * width;
      this.y = Math.random() * height;
      this.radius = Math.random() * 30 + 12;
      this.colorPrefix = colors[Math.floor(Math.random() * colors.length)];
      this.alpha = Math.random() * 0.3 + 0.08;
      this.speedY = -(Math.random() * 0.35 + 0.1);
      this.speedX = (Math.random() - 0.5) * 0.25;
      this.pulseSpeed = Math.random() * 0.015 + 0.005;
      this.pulseFactor = Math.random() * Math.PI * 2;
    }
    update() {
      this.y += this.speedY;
      this.x += this.speedX;
      this.pulseFactor += this.pulseSpeed;

      if (this.y < -this.radius || this.x < -this.radius || this.x > width + this.radius) {
        this.y = height + this.radius;
        this.x = Math.random() * width;
      }
    }
    draw() {
      ctx.beginPath();
      const currentAlpha = Math.max(0.02, this.alpha + Math.sin(this.pulseFactor) * 0.06);
      const grad = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.radius);
      grad.addColorStop(0, this.colorPrefix + currentAlpha + ')');
      grad.addColorStop(0.6, this.colorPrefix + (currentAlpha * 0.35) + ')');
      grad.addColorStop(1, this.colorPrefix + '0)');
      
      ctx.fillStyle = grad;
      ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
      ctx.fill();
    }
  }

  const particleCount = Math.min(Math.floor((width * height) / 16000), 50);
  for(let i=0; i<particleCount; i++) {
    particles.push(new Particle());
  }

  function animate() {
    ctx.clearRect(0, 0, width, height);
    particles.forEach(p => {
      p.update();
      p.draw();
    });
    requestAnimationFrame(animate);
  }
  animate();
})();
</script>

<?php include("lib/body_footer.php"); ?>
	