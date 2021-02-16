<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class C_datappi extends Secure_area {
  public $xuser;
	public function __construct() {
			parent::__construct();
      $this->load->helper('tgl_indo');
      $this->load->model('M_datappi','',TRUE);	
      $this->load->model('rjmregistrasi','',TRUE);
  //    $this->load->library('Ppi'); 
    
      $this->xuser = $this->load->get_var("user_info");  			
	}

  public function index() {        
    $data['title'] = '<i class="fa fa-search"></i> Cari Data PPI';
    $data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_pasienppi()->result();
 
    $this->load->view('c_datappi/views',$data);        
  }

  public function search($ppi='')
  {
    $data['title'] = '<i class="fa fa-search"></i> Cari Data PPI';
      
    if($this->input->post('cari')!=''){
		if ($this->input->post('search_per')=='noregister'){     
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_register($this->input->post('cari'))->result();
		}
		if ($this->input->post('search_per')=='noppi'){     
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_ppi2($this->input->post('cari'))->result();
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
      
      redirect('c_datappi');
    
    } else {
    
      $this->load->view('c_datappi/views',$data);
    }
    
  }

  public function cetak($NO_REGISTER,$TGL_SENSUS) {        
  
    $data['title'] = '<i class="fa fa-print"></i> Cetak Data PPI';
	$data['identitas_pasien'] = $this->M_datappi->identitas_pasien($NO_REGISTER);
	$data['data'] = $this->rjmregistrasi->get_data_cetak_ppi($NO_REGISTER,$TGL_SENSUS)->result();
	
	if (empty($data['identitas_pasien'])==1) 
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
      
      $this->session->set_flashdata('success_msg', $success);
      
      redirect('c_datappi');
    
    } else { 
		
    $this->load->view('c_datappi/cetak',$data);     
	}
	
  }
  
  public function downloadpdfppi($NO_REGISTER,$TGL_SENSUS){
	  
	$data['identitas_pasien'] = $this->M_datappi->identitas_pasien($NO_REGISTER);
	$data['data'] = $this->rjmregistrasi->get_data_cetak_ppi($NO_REGISTER,$TGL_SENSUS)->result();
	
	if (empty($data['identitas_pasien'])==1) 
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
      
      $this->session->set_flashdata('success_msg', $success);
      
      redirect('c_datappi/cetak');
    
    } else { 
		
    $this->load->view('c_datappi/downloadpdfppi',$data);     
	}
  }
  
  public function insert($no_register,$ID_SENSUS) {        
  
    $data['title'] = '<i class="fa fa-hospital-o"></i>Insert Form Surveilans PPI';

      $data['data_pasien'] = $this->M_datappi->data_pasien($no_register,$ID_SENSUS);
	  $data['data_ab'] = $this->rjmregistrasi->table_antibiotik();
	  $data['data_ruang'] = $this->rjmregistrasi->get_ruang();
	  $data['list_alat'] = $this->rjmregistrasi->get_alat();

    //  print_r(  $data['data_pasien']);die();

    $this->load->view('C_pasienppi/kirim',$data);        
  }
  
   public function update($no_register,$ID_SENSUS) {        
  
    $data['title'] = '<i class="fa fa-hospital-o"></i>Update Form Surveilans PPI';

      $data['data_pasien'] = $this->M_datappi->data_pasien($no_register,$ID_SENSUS);
	  $data['data_ab'] = $this->rjmregistrasi->table_antibiotik();
	  $data['data_ruang'] = $this->rjmregistrasi->get_ruang();
	  $data['list_alat'] = $this->rjmregistrasi->get_alat();

    //  print_r(  $data['data_pasien']);die();

    $this->load->view('C_pasienppi/kirim',$data);        
  }

}
?>
