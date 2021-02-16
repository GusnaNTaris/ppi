<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class C_pasienppi extends Secure_area {
  public $xuser;
	public function __construct() {
			parent::__construct();
      $this->load->helper('tgl_indo');
      $this->load->model('M_pasienppi','',TRUE);	
      $this->load->model('rjmregistrasi','',TRUE);
  //    $this->load->library('Ppi'); 
    
      $this->xuser = $this->load->get_var("user_info");  			
	}

  public function index() {        
    $data['title'] = '<i class="fa fa-search"></i> Cari Pasien';
    $data['data_pasien']="";
 
    $this->load->view('c_pasienppi/views',$data);        
  }

  public function search($cm='')
  {
    $data['title'] = '<i class="fa fa-search"></i> Cari Pasien';
      
    if($this->input->post('cari_no_cm')!=''){
      
      $data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_reg($this->input->post('cari_no_cm'))->result();
  //      $data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm($this->input->post('cari_no_cm'))->result();
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
      
      redirect('c_pasienppi');
    
    } else {
    
      $this->load->view('c_pasienppi/views',$data);
    }
    
  }

  // function diagnosa() {   
  //       if (isset($_GET['q'])) {
  //           $keyword = rawurlencode($_GET['q']);            
  //           $result = $this->M_pasien->get_diagnosa($keyword);        
  //               if ($result) {
  //                   foreach ($result as $row) {
  //                       $new_row['id']=htmlentities(stripslashes($row['KD_DIAGNOSA']));
  //                       $new_row['text']=htmlentities(stripslashes($row['KD_DIAGNOSA'].' - '.$row['NM_DIAGNOSA']));                      
  //                       $row_set[] = $new_row;
  //                   }
  //                   echo json_encode($row_set);                     
  //               } else echo json_encode([]);                                                                             
  //       } else echo json_encode([]);    
  //   }

  public function kirim($no_register,$idrg) {        
  
    $data['title'] = '<i class="fa fa-hospital-o"></i> Form Surveilans PPI';
    $data['data_pasien'] = $this->M_pasienppi->data_pasien($no_register,$idrg);
	$data['data_ab'] = $this->rjmregistrasi->table_antibiotik();
	$data['data_ruang'] = $this->rjmregistrasi->get_ruang();
	$data['list_alat'] = $this->rjmregistrasi->get_alat();

    $this->load->view('C_pasienppi/kirim',$data);        
  }     		

  public function senddata()  {
      $data_insert = array(
          'NO_REGISTER' => $this->input->post('no_register'), 
          'RUANG' => $this->input->post('IDRG'),
          'DIAGNOSA' => $this->input->post('diagnosa'),
          'JENIS_KUMAN' => $this->input->post('jeniskuman'), 
          'TGL_KUMAN' => $this->input->post('tanggal_kuman'),
          'VAP' => $this->input->post('VAP'),
		  'TGL_VAP' => $this->input->post('tanggal_vap'),
		  'HAP' => $this->input->post('HAP'),
		  'TGL_HAP' => $this->input->post('tanggal_hap'),
		  'IDO' => $this->input->post('IDO'),
		  'TGL_IDO' => $this->input->post('tanggal_ido'),
		  'ISK' => $this->input->post('ISK'),
		  'TGL_ISK' => $this->input->post('tanggal_isk'),
		  'IADP' => $this->input->post('IADP'),
		  'TGL_IADP' => $this->input->post('tanggal_iadp'),
		  'DEKUB' => $this->input->post('DEKUB'),
		  'TGL_DEKUB' => $this->input->post('tanggal_dekub'),
		  'PLEB' => $this->input->post('PLEB'),
		  'TGL_PLEB' => $this->input->post('tanggal_pleb'),
		  'DARAH' => $this->input->post('darah'),
		  'SPUTUM' => $this->input->post('sputum'),
		  'SWAB_LUKA' => $this->input->post('sluka'),
		  'URINE' => $this->input->post('urine'),
		  'TIRAH_BARING' => $this->input->post('tirahbaring'),
          'HASIL_RONTGEN' => $this->input->post('rontgen'),
          'TGL_RONTGEN' => $this->input->post('tanggal_rontgen'),
          'ANTIBIOTIK' => $this->M_pasienppi->getNamaAntibiotik($this->input->post('idantibio'))->NAMA_ANT,
		  'ID_ANT' => $this->input->post('idantibio'),
          'TGL_SENSUS' => $this->input->post('tanggal_alat'),
          'ALAT' => $this->input->post('alat'),
          'KEG_SENSUS' => $this->input->post('kegiatan'),
		  'TRANSMISI' => $this->input->post('transmisi'),
          'IDX' => $this->input->post('usr'), 
          'TGL_ENTRY' => $this->input->post('tgl_entry')
        );
	  $this->M_pasienppi->insert_tb($data_insert);
	  $data_ruang = array(
		  'IDRG' => $this->input->post('IDRG'),
		  'TGLMASUKRG' => $this->input->post('tglmasukrg'),
		  'TGLKELUARRG' => $this->input->post('tglkeluarrg')
		);
	  $no_register = $this->input->post('no_register');
	  $this->M_pasienppi->update_ruang($data_ruang,$no_register);
    }
	
	public function senddataupdate($ID_SENSUS)  {
      $data_update = array(
          'RUANG' => $this->input->post('IDRG'),
          'DIAGNOSA' => $this->input->post('diagnosa'),
          'JENIS_KUMAN' => $this->input->post('jeniskuman'), 
          'TGL_KUMAN' => $this->input->post('tanggal_kuman'),
          'VAP' => $this->input->post('VAP'),
		  'TGL_VAP' => $this->input->post('tanggal_vap'),
		  'HAP' => $this->input->post('HAP'),
		  'TGL_HAP' => $this->input->post('tanggal_hap'),
		  'IDO' => $this->input->post('IDO'),
		  'TGL_IDO' => $this->input->post('tanggal_ido'),
		  'ISK' => $this->input->post('ISK'),
		  'TGL_ISK' => $this->input->post('tanggal_isk'),
		  'IADP' => $this->input->post('IADP'),
		  'TGL_IADP' => $this->input->post('tanggal_iadp'),
		  'DEKUB' => $this->input->post('DEKUB'),
		  'TGL_DEKUB' => $this->input->post('tanggal_dekub'),
		  'PLEB' => $this->input->post('PLEB'),
		  'TGL_PLEB' => $this->input->post('tanggal_pleb'),
		  'DARAH' => $this->input->post('darah'),
		  'SPUTUM' => $this->input->post('sputum'),
		  'SWAB_LUKA' => $this->input->post('sluka'),
		  'URINE' => $this->input->post('urine'),
		  'TIRAH_BARING' => $this->input->post('tirahbaring'),
          'HASIL_RONTGEN' => $this->input->post('rontgen'),
          'TGL_RONTGEN' => $this->input->post('tanggal_rontgen'),
          'ANTIBIOTIK' => $this->M_pasienppi->getNamaAntibiotik($this->input->post('idantibio'))->NAMA_ANT,
		  'ID_ANT' => $this->input->post('idantibio'),
          'TGL_SENSUS' => $this->input->post('tanggal_alat'),
          'ALAT' => $this->input->post('alat'),
          'KEG_SENSUS' => $this->input->post('kegiatan'),
		  'TRANSMISI' => $this->input->post('transmisi'),
          'IDX' => $this->input->post('usr'), 
          'TGL_ENTRY' => $this->input->post('tgl_entry')
        );
		$data['ID_SENSUS'] = $ID_SENSUS;
		$this->M_pasienppi->update_tb($data_update,$ID_SENSUS);
		
		$data_ruang = array(
		  'IDRG' => $this->input->post('IDRG'),
		  'TGLMASUKRG' => $this->input->post('tglmasukrg'),
		  'TGLKELUARRG' => $this->input->post('tglkeluarrg')
		);
		$no_register = $this->input->post('no_register');
		$this->M_pasienppi->update_ruang($data_ruang,$no_register);
    }

}
?>
