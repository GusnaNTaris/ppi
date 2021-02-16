<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once("Secure_area.php");

class Beranda extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->helper('pdf_helper');
		$this->load->model('M_pasienppi');
		// $this->load->model('indikatorrs/m_indikator','',TRUE);

	}
	
	public function index()
	{
		$data['title'] = 'Beranda Pusat Penanganan Infeksi';
	
		$this->load->view('beranda',$data);
		
	}



	
}

?>