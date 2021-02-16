<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class C_dataab extends Secure_area {
  public $xuser;
	public function __construct() {
			parent::__construct();
      $this->load->helper('tgl_indo');
      $this->load->model('M_dataab','',TRUE);	
      $this->load->model('rjmregistrasi','',TRUE);
  //    $this->load->library('Ppi'); 
    
      $this->xuser = $this->load->get_var("user_info");  			
	}

  public function index() {        
    $data['title'] = '<i class="fa fa-medkit"></i> Data Antibiotik';
	$data['tglawal'] = "1970-01-01";
	$data['tglakhir'] = date("Y-m-d");
	$data['data'] = $this->rjmregistrasi->table_antibiotik();
    $this->load->view('c_dataab/views',$data);        
  }
    

  public function views() {  
	$data['title'] = '<i class="fa fa-medkit"></i> Data Antibiotik';
	$data['tglawal'] = $this->input->post('tglawal');
	$data['tglakhir'] = $this->input->post('tglakhir');
	$data['data'] = $this->rjmregistrasi->table_antibiotik();
    $this->load->view('c_dataab/views',$data);        
  }
  
  public function downloadpdfab($tglawal,$tglakhir) {        
	$data['tglawal'] = $tglawal;
	$data['tglakhir'] = $tglakhir;
	$data['data'] = $this->rjmregistrasi->table_antibiotik();
    $this->load->view('c_dataab/downloadpdfab',$data);        
  }
}
?>
