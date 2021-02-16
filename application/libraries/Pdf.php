<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

	public function Header() {
        // Logo
        $image_file = 'asset/images/logos/logo.png';
        $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 10);
        // Title
        $this->Cell(0, 10, 'RSUP DR. MOHAMMAD HOESIN', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		// Set Font alamat dsb
		$this->ln(4);
		$this->SetFont('times', '', 5);
		$this->Cell(15,10);
		$this->Cell(0, 10, 'Alamat : Jl. Jend. Sudirman Km 3.5 Telp. (0711) 354088 - Fax. (0711) 351318', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		//$this->Image('asset/images/logos/logosumsell.png', 230, 10, 15, '', 'PNG', '', 'T', true, 300, '', false, false, 0, false, false, false);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */
