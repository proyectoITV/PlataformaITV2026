<?php

//Requiere inicializar estas variables
// $PDF_Titulo;
// $PDF_SubTitulo;     
// $FechaDocumento;
// $Persona;
	
AhorrePapel(FALSE,1);

class PDFEDOCUENTA extends TCPDF {
		public $str;
		public $Delegacion;
		public $SubTitulo;
		public $FechaContrato;
		public $Beneficiario;
        public $Titulo;

		public function Header() {
			$image_file = K_PATH_IMAGES.'pdf_logo.png';
			$icono = K_PATH_IMAGES.'user.png';			
			$this->Image($image_file, 15, 6, 70, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			$this->SetFont('helvetica', 'B', 6);
		    $this->Text(90,5, ' I N S T I T U T O  T A M A U L I P E C O   D E   V I V I E N D A    Y  U R B A N I S M O '); 
		    $this->SetFont('helvetica', 'B', 10);
		    $this->Text(90,8, ''.$this->Titulo); 
		    $this->SetFont('courier', 'B', 8); $this->Text(90,13, ''.$this->SubTitulo); 
		    $this->SetFont('courier', 'B', 6); $this->Text(90,17, ''.$this->FechaContrato); 
		    $this->SetFont('helvetica', 'B', 10); $this->SetTextColor(0,0,0);
		    $this->Text(90,19, ''.$this->Beneficiario); 		
		}
	
		public function Footer() {			
			$this->SetY(-15); $this->SetFont('helvetica', 'I', 6);$this->SetTextColor(0,0,0);
			$linea= "______________________________________________________________________________________________________________________________________________________________";		 
		    $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();		 
		    $this->Text(15,263, $linea); 
		    $this->SetFont('helvetica', 'B', 9); $this->Text(15,266, $paginas); 
		    $this->SetFont('helvetica', 'R', 7); 
		    $this->Text(32,266, substr($this->str,0,140)); 
		    $this->Text(32,269, substr($this->str,140,)); 		 
		}
}

	 $pdf = new PDFEDOCUENTA(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	 $pdf->SetCreator(PDF_CREATOR);
	 $pdf->SetKeywords('');	 
     $leyenda = "Impreso por ".$nitavu."-".nitavu_nombre($nitavu)." | ".$fecha.":".$hora;
	 $pdf->SetHeaderData('', '10', '', 'ITAVU  '.$leyenda);
	 //$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
	 $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	 $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));	 
	 $pdf->str = $leyenda;
     $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
     $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	 $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	 $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	 $pdf->SetMargins(15, 25 , 15);
     $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
     $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
     if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
        require(dirname(__FILE__).'pdf/lang/eng.php');
        $pdf->setLanguageArray($l);
    }    
    $pdf->SetFont('helvetica', '', 9);
    $pages = $pdf->getNumPages();
    $style = array(
		'border' => true,
		'padding' => 5,
		'fgcolor' => array(0,0,0),
		'bgcolor' => false
	);
    $pdf->Titulo = $PDF_Titulo;
	$pdf->SubTitulo = $PDF_SubTitulo;     
	$pdf->FechaContrato = $FechaDocumento;
	$pdf->Beneficiario = $Persona;
	 
	
	 
	$pdf->AddPage('P', 'LETTER'); //en la tabla de reporte L o P
	$pag = $pdf->PageNo();

    $styleqr = array(
        'border' => true,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => array(10,7,0),
        'bgcolor' => array(255,255,255),
        'module_width' => 2, // width of a single module in points
        'module_height' => 2 // height of a single module in points
    );
    
	$stylebar = array(
		'position' => '',
		'align' => 'C',
		'stretch' => false,
		'fitwidth' => true,
		'cellfitalign' => '',
		'border' => true,
		'hpadding' => 'auto',
		'vpadding' => 'auto',
		'fgcolor' => array(0,0,0),
		'bgcolor' => false, //array(255,255,255),
		'text' => true,
		'font' => 'helvetica',
		'fontsize' => 8,
		'stretchtext' => 4
	);
	
	

?>