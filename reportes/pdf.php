<?php
include ("head.php");
include ("header.php");


// if (isset($_GET['file'])){$ArchivoPDF = VarClean($_GET['file']);} else {$ArchivoPDF="";}   
if (isset($_POST['file'])){$ArchivoPDF = VarClean($_POST['file']);} else {$ArchivoPDF="";}   



ob_end_clean();  
echo "<iframe id='pdfPresenter' src='".$ArchivoPDF."'
style='
    width: 100%;
    height: 94%;
    position: absolute;
    border: 0px;
    z-index: 500;
'
>

</iframe>";


?>

<?php include ("footer.php"); ?>