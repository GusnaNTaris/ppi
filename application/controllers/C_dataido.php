<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class C_dataido extends Secure_area {
  public $xuser;
	public function __construct() {
			parent::__construct();
      $this->load->helper('tgl_indo');
      $this->load->model('M_dataido','',TRUE);	
      $this->load->model('rjmregistrasi','',TRUE);
  //    $this->load->library('Ppi'); 
    
      $this->xuser = $this->load->get_var("user_info");  			
	}

  public function index() {        
    $data['title'] = '<i class="fa fa-search"></i> Cari Data IDO';
    $data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_pasienido()->result();
 
    $this->load->view('c_dataido/views',$data);        
  }

  public function search($ppi='')
  {
    $data['title'] = '<i class="fa fa-search"></i> Cari Data IDO';
      
    if($this->input->post('cari')!=''){
		if ($this->input->post('search_per')=='cm'){     
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasienido_by_cm($this->input->post('cari'))->result();
		}
		if ($this->input->post('search_per')=='noppi'){     
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasienido_by_ppi($this->input->post('cari'))->result();
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
      
      redirect('c_dataido');
    
    } else {
    
      $this->load->view('c_dataido/views',$data);
    }
    
  }

  public function cetak($ID_IDO) {        
  
    $data['title'] = '<i class="fa fa-print"></i> Cetak Data IDO';

    $this->data['listAlat'] = $this->M_dataido->getAllAlat();

   //  print_r($this->data['listAlat']);die();

      $data['data_pasien'] = $this->M_dataido->data_pasien($ID_IDO);

   //  print_r(  $data['data_pasien']);die();

    $this->load->view('c_dataido/cetak',$data);        
  }
  
  public function update($ID_IDO) {        
  
    $data['title'] = '<i class="fa fa-hospital-o"></i> Form Update Data IDO';
	$this->data['ID_IDO'] = $ID_IDO;
    $data['data_pasien'] = $this->M_dataido->data_pasien($ID_IDO);

   //  print_r(  $data['data_pasien']);die();

    $this->load->view('c_pasienido/kirim',$data,$ID_IDO);        
  }


    public function downloadpdfido($ID_IDO) {        
  
    $data['title'] = 'Form Surveilans PPI';

    $data['data_pasien'] = $this->M_dataido->data_pasien($ID_IDO);
	
	//print_r(  $data['data_pasien']);die();

    $this->load->view('c_dataido/downloadpdfido',$data);    
  }

}
?>
