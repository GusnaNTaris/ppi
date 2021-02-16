<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class C_rekap extends Secure_area {
  public $xuser;
	public function __construct() {
			parent::__construct();
      $this->load->helper('tgl_indo');
      $this->load->model('M_rekap','',TRUE);	
      $this->load->model('rjmregistrasi','',TRUE);
  //    $this->load->library('Ppi'); 
    
      $this->xuser = $this->load->get_var("user_info");  			
	}

  public function index() {        
    $data['title'] = '<i class="fa fa-folder"></i> Data Rekap';
	$data['idrg'] = '101';
	$data['nmruang'] = $this->M_rekap->getNamaRuang('101')->NMRUANG;
	$data['tglawal'] = "1970-01-01";
	$data['tglakhir'] = date("Y-m-d");
	$data['data_ruang'] = $this->rjmregistrasi->get_ruang();
	
    $this->load->view('c_rekap/views',$data);        
  }

  
  public function views() {        
  
    $data['title'] = '<i class="fa fa-folder"></i> Data Rekap';

    $data['idrg'] = $this->input->post('idrg');
	$data['nmruang'] = $this->M_rekap->getNamaRuang($this->input->post('idrg'))->NMRUANG;
	$data['tglawal'] = $this->input->post('tglawal');
	$data['tglakhir'] = $this->input->post('tglakhir');
	$data['data_ruang'] = $this->rjmregistrasi->get_ruang();

    $this->load->view('c_rekap/views',$data);        
  }
  
  public function downloadpdfrb($idrg,$tglawal,$tglakhir) {
	$data['idrg'] = $idrg;
	$data['nmruang'] = $this->M_rekap->getNamaRuang($idrg)->NMRUANG;
	$data['tglawal'] = $tglawal;
	$data['tglakhir'] = $tglakhir;
    $this->load->view('c_rekap/downloadpdfrb',$data);        
  }

}
?>
