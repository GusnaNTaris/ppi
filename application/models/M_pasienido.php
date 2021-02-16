<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pasienido extends CI_Model {   
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }

    function data_pasien($ID_SENSUS,$IDO) {
        $this->db->select('PASIEN_IRJ.*,PASIEN_IRI.NO_CM,PASIEN_IRI.NO_IPD, RUANG_IRI.IDRG, RUANG.NMRUANG,PASIEN_PPI.*'); 
        $this->db->from('PASIEN_IRI');
		$this->db->JOIN('PASIEN_PPI', 'PASIEN_IRI.NO_IPD = PASIEN_PPI.NO_REGISTER', 'left');
        $this->db->JOIN('PASIEN_IRJ', 'PASIEN_IRJ.NO_MEDREC = PASIEN_IRI.NO_CM', 'left');
        $this->db->JOIN('RUANG_IRI', 'RUANG_IRI.NO_IPD = PASIEN_IRI.NO_IPD', 'left');
        $this->db->JOIN('RUANG', 'RUANG_IRI.IDRG = RUANG.IDRG', 'left');
        $this->db->where('PASIEN_PPI.ID_SENSUS', $ID_SENSUS);
		$this->db->where('PASIEN_PPI.IDO', $IDO);
        $query = $this->db->get();
        return $query->row();  
    }	

    function getAllAlat(){
        //echo 'masuk';die();
        $this->db->from("MASTER_ALAT_SURVEILANS");
       // $query= $this->db->get();
        return $this->db->get()->result();
    }

    function insert_ido($data_insert)
    {
		$this->db->trans_start();
        $this->db->insert('PASIEN_IDO', $data_insert);
		$this->db->trans_complete();
        return true;
    }

    function update_ido($data_update,$ID_IDO)
    {
		$this->db->query("UPDATE PASIEN_IDO
						  SET 	DIAGNOSA_OPERASI = '$data_update[DIAGNOSA_OPERASI]',
								JENIS_OPERASI = '$data_update[JENIS_OPERASI]',
								ASA_SCORE = '$data_update[ASA_SCORE]',
								LAMA_OPERASI = '$data_update[LAMA_OPERASI]',
								TOTAL_RISK_SCORE = '$data_update[TOTAL_RISK_SCORE]',
								SIFAT_OPERASI = '$data_update[SIFAT_OPERASI]',
								TANGGAL_IDO = '$data_update[TANGGAL_IDO]',
								ANTIBIOTIK = '$data_update[ANTIBIOTIK]',
								HASIL_KULTUR = '$data_update[HASIL_KULTUR]',
								IDX = '$data_update[IDX]',
								TGL_ENTRY = '$data_update[TGL_ENTRY]'
						  WHERE ID_IDO = '$ID_IDO'");
        return true;
    }
                                                                     
}
?>