<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_dataab extends CI_Model {   
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }

 /*   function count_antibiotik($ID_ANT,$tgl1,$tgl2) {
		$this->db->select('ID_ANT');
		$this->db->from('PASIEN_PPI');
		$this->db->where('ID_ANT', $ID_ANT);
		return $this->db->count_all_results();
    }	*/
	
	function count_antibiotik($ID_ANT,$tglawal,$tglakhir){
	$query = $this->db->query("	SELECT COUNT(DISTINCT A.NO_REGISTER) COID
								FROM PASIEN_PPI A
								WHERE A.ID_ANT = '$ID_ANT' 
								AND A.TGL_SENSUS >= '$tglawal' 
								AND A.TGL_SENSUS <= '$tglakhir'");
	$row = $query->row();
	return $row->COID;
	}
	
	function get_id_ant() {
	$query = $this->db->query("	SELECT COUNT(ID_ANT) AS CO 
								FROM ANTIBIOTIK");
	$row = $query->row();
	$ID = $row->CO;
	$ID = $ID+1;
	return $ID;
	}
	
	function insert_tb($data_insert)
    {
		// echo 'masuk';die();
		$this->db->trans_start();
        $this->db->insert('ANTIBIOTIK', $data_insert);
		$this->db->trans_complete();
        return true;
    }
	
	function update_tb($data_update)
	{
		$this->db->query("UPDATE ANTIBIOTIK 
						  SET IS_ACTIVE = '$data_update[IS_ACTIVE]'
						  WHERE ID_ANT = '$data_update[ID_ANT]'");
        return true;
	}
}
?>