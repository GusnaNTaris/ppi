<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class C_setorab extends Secure_area {
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
	$data['data_ab'] = $this->rjmregistrasi->table_antibiotik();
    $this->load->view('C_setorab/views',$data);        
  }
  
  public function tambah() {
	$data_insert = array(
	'ID_ANT' => $this->M_dataab->get_id_ant(),
	'NAMA_ANT' => $this->input->post('antibiotik'),
	'IS_ACTIVE' => 1
	);
	$this->M_dataab->insert_tb($data_insert);
  }
  
  public function update() {
	$data_update = array(
		'ID_ANT' => $this->input->post('idantibio'),
		'IS_ACTIVE' => $this->input->post('isactiveab')
	);
	$this->M_dataab->update_tb($data_update);
  }
 
}
?>
