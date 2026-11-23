<?php
// Endpoint legado deshabilitado por seguridad. Usar nip_update.php / nip_update_dat_save.php
require("seguridad.php");
if (!headers_sent()) {
    header("Location: nip_update.php");
}
echo '<script>top.location.replace("nip_update.php");</script>';
exit;
