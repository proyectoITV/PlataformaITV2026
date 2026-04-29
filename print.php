<?php
include ("lib/body_head.php");

error_reporting(0); //<-- para simular produccion

if (isset($_POST['data'])){
    echo stripslashes($_POST['data']);

}

echo "
<script>
    window.print(); 
</script>
";












include ("lib/body_footer.php");
?>

