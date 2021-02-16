<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pasienppi extends CI_Model {   
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }

    function data_pasien($no_register,$idrg) {
        $this->db->select('PASIEN_IRJ.*,PASIEN_IRI.NO_CM,PASIEN_IRI.NO_IPD AS NO_REGISTER, RUANG_IRI.IDRG, RUANG.NMRUANG,RUANG_IRI.TGLMASUKRG,RUANG_IRI.TGLKELUARRG'); 
        $this->db->from('PASIEN_IRI');   
        $this->db->JOIN('PASIEN_IRJ', 'PASIEN_IRJ.NO_MEDREC = PASIEN_IRI.NO_CM', 'left');
        $this->db->JOIN('RUANG_IRI', 'RUANG_IRI.NO_IPD = PASIEN_IRI.NO_IPD', 'left');
        $this->db->JOIN('RUANG', 'RUANG_IRI.IDRG = RUANG.IDRG', 'left');
        $this->db->where('PASIEN_IRI.NO_IPD', $no_register);
        $this->db->where('RUANG_IRI.IDRG', $idrg);
        $query = $this->db->get();
        return $query->row();  
    }

	function getNamaAntibiotik($idantibio) {
		$this->db->select('NAMA_ANT');
		$this->db->from('ANTIBIOTIK');
		$this->db->where('ID_ANT', $idantibio);
		$query = $this->db->get();
        return $query->row(); 
	}

    function getAllAlat(){
        //echo 'masuk';die();
        $this->db->from("MASTER_ALAT_SURVEILANS");
       // $query= $this->db->get();
        return $this->db->get()->result();
    }


    function insert_tb($data_insert)
    {
		// echo 'masuk';die();
		$this->db->trans_start();
        $this->db->insert('PASIEN_PPI', $data_insert);
		$this->db->trans_complete();
        return true;
    }

    function update_tb($data_update,$ID_SENSUS)
    {
		$this->db->query("UPDATE PASIEN_PPI
						  SET RUANG = '$data_update[RUANG]',
							  DIAGNOSA = '$data_update[DIAGNOSA]',
							  JENIS_KUMAN = '$data_update[JENIS_KUMAN]', 
							  TGL_KUMAN = '$data_update[TGL_KUMAN]',
							  VAP = '$data_update[VAP]',
							  TGL_VAP = '$data_update[TGL_VAP]',
							  HAP = '$data_update[HAP]',
							  TGL_HAP = '$data_update[TGL_HAP]',
							  IDO = '$data_update[IDO]',
							  TGL_IDO = '$data_update[TGL_IDO]',
							  ISK = '$data_update[ISK]',
							  TGL_ISK = '$data_update[TGL_ISK]',
							  IADP = '$data_update[IADP]',
							  TGL_IADP = '$data_update[TGL_IADP]',
							  DEKUB = '$data_update[DEKUB]',
							  TGL_DEKUB = '$data_update[TGL_DEKUB]',
							  PLEB = '$data_update[PLEB]',
							  TGL_PLEB = '$data_update[TGL_PLEB]',
							  DARAH = '$data_update[DARAH]',
							  SPUTUM = '$data_update[SPUTUM]',
							  SWAB_LUKA = '$data_update[SWAB_LUKA]',
							  URINE = '$data_update[URINE]',
							  TIRAH_BARING = '$data_update[TIRAH_BARING]',
							  HASIL_RONTGEN = '$data_update[HASIL_RONTGEN]',
							  TGL_RONTGEN = '$data_update[TGL_RONTGEN]',
							  ID_ANT = '$data_update[ID_ANT]',
							  ANTIBIOTIK = '$data_update[ANTIBIOTIK]',
							  TGL_SENSUS = '$data_update[TGL_SENSUS]',
							  ALAT = '$data_update[ALAT]',
							  KEG_SENSUS = '$data_update[KEG_SENSUS]',
							  TRANSMISI = '$data_update[TRANSMISI]',
							  IDX = '$data_update[IDX]', 
							  TGL_ENTRY = '$data_update[TGL_ENTRY]'
						  WHERE ID_SENSUS = '$ID_SENSUS'");
        return true;
    }
	
	function update_ruang($data_ruang,$no_register)
	{
		$this->db->query("UPDATE RUANG_IRI 
						SET IDRG = '$data_ruang[IDRG]',
								TGLMASUKRG = TO_DATE('$data_ruang[TGLMASUKRG]', 'YYYY-MM-DD'),
								TGLKELUARRG = TO_DATE('$data_ruang[TGLKELUARRG]', 'YYYY-MM-DD')
						WHERE
							NO_IPD = '$no_register'");
		return true;
	}

}
?>