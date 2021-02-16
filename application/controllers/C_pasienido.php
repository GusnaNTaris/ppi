<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class C_pasienido extends Secure_area {
  public $xuser;
	public function __construct() {
			parent::__construct();
      $this->load->helper('tgl_indo');
      $this->load->model('M_pasienido','',TRUE);	
      $this->load->model('rjmregistrasi','',TRUE);
  //    $this->load->library('Ppi'); 
    
      $this->xuser = $this->load->get_var("user_info");  			
	}

  public function index() {        
    $data['title'] = '<i class="fa fa-search"></i> Cari Pasien IDO';
    $data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_isido()->result();
 
    $this->load->view('c_pasienido/views',$data);        
  }

  public function search($ppi='')
  {
    $data['title'] = '<i class="fa fa-search"></i> Cari Pasien IDO';
      
    if($this->input->post('cari')!=''){
		if ($this->input->post('search_per')=='noppi'){      
		  $data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_ppi($this->input->post('cari'))->result();
		}
		if ($this->input->post('search_per')=='cm'){
		  $data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_regido($this->input->post('cari'))->result();
		}
    }
    
    if (empty($data['data_pasien'])) 
    {
      $success =  '<div class="content-header">
          <div class="box box-default">
            <div class="alert alert-danger alert-dismissable">
              <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
              <h4>
              <i class="icon fa fa-ban"></i>
              Data pasien tidak ditemukan !
              </h4>
            </div>
          </div>
        </div>';
      
      $this->session->set_flashdata('success', $success);
      
      redirect('c_pasienido');
    
    } else {
    
      $this->load->view('c_pasienido/views',$data);
    }
    
  }

  public function kirim($ID_SENSUS,$IDO) {        
  
    $data['title'] = '<i class="fa fa-hospital-o"></i> Form Surveilans IDO';

    $this->data['listAlat'] = $this->M_pasienido->getAllAlat();

   //  print_r($this->data['listAlat']);die();

      $data['data_pasien'] = $this->M_pasienido->data_pasien($ID_SENSUS,1);

   //  print_r(  $data['data_pasien']);die();

    $this->load->view('c_pasienido/kirim',$data);        
  }

  public function senddata()  { //update 20/6/2019	
	  $data_insert = array(
			'NO_REGISTER' => $this->input->post('no_register'), 
			'ID_PPI' => $this->input->post('idsensus'),
			'DIAGNOSA_OPERASI' => $this->input->post('diagop'),
			'JENIS_OPERASI' => $this->input->post('jenop'),
			'ASA_SCORE' => $this->input->post('asa'),
			'LAMA_OPERASI' => $this->input->post('lop'),
			'TOTAL_RISK_SCORE' => $this->input->post('rscore'),
			'SIFAT_OPERASI' => $this->input->post('sifop'),
			'TANGGAL_IDO' => $this->input->post('tanggal_ido'),
			'ANTIBIOTIK' => $this->input->post('antib'),
			'HASIL_KULTUR' => $this->input->post('hkultur'),
			'IDX' => $this->input->post('usr'),
			'TGL_ENTRY' => $this->input->post('tgl_entry')
		);
           $this->M_pasienido->insert_ido($data_insert);
      }
	
	public function senddataupdate($ID_IDO)  {
	  $data_update = array(
			'NO_REGISTER' => $this->input->post('no_register'), 
			'ID_PPI' => $this->input->post('idsensus'),
			'DIAGNOSA_OPERASI' => $this->input->post('diagop'),
			'JENIS_OPERASI' => $this->input->post('jenop'),
			'ASA_SCORE' => $this->input->post('asa'),
			'LAMA_OPERASI' => $this->input->post('lop'),
			'TOTAL_RISK_SCORE' => $this->input->post('rscore'),
			'SIFAT_OPERASI' => $this->input->post('sifop'),
			'TANGGAL_IDO' => $this->input->post('tanggal_ido'),
			'ANTIBIOTIK' => $this->input->post('antib'),
			'HASIL_KULTUR' => $this->input->post('hkultur'),
			'IDX' => $this->input->post('usr'),
			'TGL_ENTRY' => $this->input->post('tgl_entry')
		);
		$data['ID_IDO'] = $ID_IDO;
        $this->M_pasienido->update_ido($data_update,$ID_IDO);
      }
}
?>
