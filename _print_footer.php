<?php
$pdf->SetXY(13.5, 25);   
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(15, 15);    

// reset pointer to the last page
$pdf->lastPage();
//Close and output PDF document}
ob_end_clean();

// $FileTemp = "tmp/docsecure_/".EasyName("Doc",6).'.pdf';
$FileName = EasyName("Doc",6).".pdf";
$FileTemp = __DIR__ ."/tmp/docsecure_/".$FileName;
$pdf->Output($FileTemp, 'F');    
$pdf->Output($FileName, 'I');    

// I : send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
// D : send to the browser and force a file download with the name given by name.
// F : save to a local server file with the name given by name.
// S : return the document as a string (name is ignored).
// FI : equivalent to F + I option
// FD : equivalent to F + D option
// E : retu

    //Guarda Impresion
    // $ArchivoOrigen = "ping.png";
    // echo "des = ".$DescripcionDelArchivo."<br>";
    // echo "TAG=".$TAG;
$UpLoad = DocSecure_upload($FileTemp,$DescripcionDelArchivo,$TAG);
    

?>