<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_dataido extends CI_Model {   
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }

    function data_pasien($ID_IDO) {
        $this->db->select('PASIEN_IRJ.*,PASIEN_IRI.NO_CM,PASIEN_IRI.NO_IPD AS NO_REGISTER, RUANG_IRI.IDRG, RUANG.NMRUANG,PASIEN_PPI.ID_SENSUS,PASIEN_IDO.*'); 
        $this->db->from('PASIEN_IRI');
		$this->db->JOIN('PASIEN_PPI', 'PASIEN_IRI.NO_IPD = PASIEN_PPI.NO_REGISTER', 'left');
		$this->db->JOIN('PASIEN_IDO', 'PASIEN_IRI.NO_IPD = PASIEN_IDO.NO_REGISTER', 'left');
        $this->db->JOIN('PASIEN_IRJ', 'PASIEN_IRJ.NO_MEDREC = PASIEN_IRI.NO_CM', 'left');
        $this->db->JOIN('RUANG_IRI', 'RUANG_IRI.NO_IPD = PASIEN_IRI.NO_IPD', 'left');
        $this->db->JOIN('RUANG', 'RUANG_IRI.IDRG = RUANG.IDRG', 'left');
        $this->db->where('PASIEN_IDO.ID_IDO', $ID_IDO);
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