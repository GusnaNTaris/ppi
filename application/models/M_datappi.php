<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_datappi extends CI_Model {   
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }

    function data_pasien($NO_REGISTER, $ID_SENSUS) {
        $this->db->select('PASIEN_IRJ.*,PASIEN_IRI.NO_CM,PASIEN_IRI.NO_IPD, RUANG_IRI.IDRG, RUANG.NMRUANG,RUANG_IRI.TGLMASUKRG,RUANG_IRI.TGLKELUARRG,PASIEN_PPI.*'); 
        $this->db->from('PASIEN_IRI');
		$this->db->JOIN('PASIEN_PPI', 'PASIEN_IRI.NO_IPD = PASIEN_PPI.NO_REGISTER', 'left');
        $this->db->JOIN('PASIEN_IRJ', 'PASIEN_IRJ.NO_MEDREC = PASIEN_IRI.NO_CM', 'left');
        $this->db->JOIN('RUANG_IRI', 'RUANG_IRI.NO_IPD = PASIEN_IRI.NO_IPD', 'left');
        $this->db->JOIN('RUANG', 'RUANG_IRI.IDRG = RUANG.IDRG', 'left');
        $this->db->where('PASIEN_PPI.NO_REGISTER', $NO_REGISTER);
		$this->db->where('PASIEN_PPI.ID_SENSUS', $ID_SENSUS);
        $query = $this->db->get();
        return $query->row();  
    }

	function identitas_pasien($NO_REGISTER) {
        $this->db->select('PASIEN_IRJ.*,PASIEN_IRI.NO_CM,PASIEN_IRI.NO_IPD, RUANG_IRI.IDRG, RUANG.NMRUANG,RUANG_IRI.TGLMASUKRG,RUANG_IRI.TGLKELUARRG,PASIEN_PPI.*'); 
        $this->db->from('PASIEN_IRI');
		$this->db->JOIN('PASIEN_PPI', 'PASIEN_IRI.NO_IPD = PASIEN_PPI.NO_REGISTER', 'left');
        $this->db->JOIN('PASIEN_IRJ', 'PASIEN_IRJ.NO_MEDREC = PASIEN_IRI.NO_CM', 'left');
        $this->db->JOIN('RUANG_IRI', 'RUANG_IRI.NO_IPD = PASIEN_IRI.NO_IPD', 'left');
        $this->db->JOIN('RUANG', 'RUANG_IRI.IDRG = RUANG.IDRG', 'left');
        $this->db->where('PASIEN_PPI.NO_REGISTER', $NO_REGISTER);
        $query = $this->db->get();
        return $query->row();  
    }	

    function getAllAlat(){
        //echo 'masuk';die();
        $this->db->from("MASTER_ALAT_SURVEILANS");
       // $query= $this->db->get();
        return $this->db->get()->result();
    }
}
?>