<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_rekap extends CI_Model {   
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }
	
	function getNamaRuang($idrg) {
		$this->db->select('NMRUANG');
		$this->db->from('RUANG');
		$this->db->where('IDRG', $idrg);
		$query = $this->db->get();
        return $query->row(); 
	}
	
	function count_jenisoperasi($jenop,$idrg,$tglawal,$tglakhir){
	$query = $this->db->query("SELECT COUNT(A.JENIS_OPERASI) COJP
								FROM
									PASIEN_IDO A,
									PASIEN_PPI B
								WHERE
									A.ID_PPI = B.ID_SENSUS
									AND A.JENIS_OPERASI = '$jenop' 
									AND B.RUANG = '$idrg'
									AND B.TGL_SENSUS >= '$tglawal' 
									AND B.TGL_SENSUS <= '$tglakhir'");
	$row = $query->row();
	return $row->COJP;
	}
	
	function count_lamaoperasi($lop,$idrg,$tglawal,$tglakhir){
	$query = $this->db->query("SELECT COUNT(A.JENIS_OPERASI) COLP
								FROM
									PASIEN_IDO A,
									PASIEN_PPI B
								WHERE
									A.ID_PPI = B.ID_SENSUS
									AND A.LAMA_OPERASI = '$lop' 
									AND B.RUANG = '$idrg'
									AND B.TGL_SENSUS >= '$tglawal' 
									AND B.TGL_SENSUS <= '$tglakhir'");
	$row = $query->row();
	return $row->COLP;
	}
	
	function count_asascore($asa,$idrg,$tglawal,$tglakhir){
	$query = $this->db->query("SELECT COUNT(A.ASA_SCORE) COAS
								FROM
									PASIEN_IDO A,
									PASIEN_PPI B
								WHERE
									A.ID_PPI = B.ID_SENSUS
									AND A.ASA_SCORE = '$asa'
									AND B.RUANG = '$idrg'
									AND B.TGL_SENSUS >= '$tglawal' 
									AND B.TGL_SENSUS <= '$tglakhir'");
	$row = $query->row();
	return $row->COAS;
	}
	
	function count_riskscore($rscore,$idrg,$tglawal,$tglakhir){
	$query = $this->db->query("SELECT COUNT(A.JENIS_OPERASI) CORS
								FROM
									PASIEN_IDO A,
									PASIEN_PPI B
								WHERE
									A.ID_PPI = B.ID_SENSUS
									AND A.TOTAL_RISK_SCORE = '$rscore' 
									AND B.RUANG = '$idrg'
									AND B.TGL_SENSUS >= '$tglawal' 
									AND B.TGL_SENSUS <= '$tglakhir'");
	$row = $query->row();
	return $row->CORS;
	}
	
	function count_pasienalat($alt,$idrg,$tglawal,$tglakhir){
	$query = $this->db->query("SELECT COUNT(DISTINCT NO_REGISTER) COAL
								FROM
									PASIEN_PPI A
								WHERE
									A.ALAT = '$alt'
									AND A.RUANG = '$idrg'
									AND A.TGL_SENSUS >= '$tglawal' 
									AND A.TGL_SENSUS <= '$tglakhir'");
	$row = $query->row();
	return $row->COAL;
	}
	
	function count_haripasien($alt,$idrg,$tglawal,$tglakhir) {
	$query = $this->db->query("	SELECT
									DISTINCT B.NO_REGISTER,
									A .TGLMASUKRG,
									A .TGLKELUARRG
								FROM
									RUANG_IRI A,
									PASIEN_PPI B
								WHERE
									B.ALAT = '$alt'
									AND B.RUANG = '$idrg'
									AND B.NO_REGISTER = A.NO_IPD
									AND A.IDRG = B.RUANG
									AND B.TGL_SENSUS >= '$tglawal' 
									AND B.TGL_SENSUS <= '$tglakhir'");
	$sum = 0;
	if ($query->result() != "") {
        foreach($query->result() as $row){
			$start = strtotime($row->TGLMASUKRG);
			$end   = strtotime($row->TGLKELUARRG);
			$diff  = $end - $start;
			$hari  = ceil($diff / (60 * 60 * 24));
			if ($hari == 0)$hari = 1;
			$sum   = $sum + $hari; 
		}
	}
	return $sum;
	}

	function count_ab($ab,$idrg,$tglawal,$tglakhir){
	$query = $this->db->query("SELECT COUNT(A.ANTIBIOTIK) COAB
								FROM
									PASIEN_IDO A,
									PASIEN_PPI B
								WHERE
									A.ID_PPI = B.ID_SENSUS
									AND A.ANTIBIOTIK = '$ab'
									AND B.RUANG = '$idrg'
									AND B.TGL_SENSUS >= '$tglawal' 
									AND B.TGL_SENSUS <= '$tglakhir'");
	$row = $query->row();
	return $row->COAB;
	}
	
	function count_darah($idrg,$tglawal,$tglakhir) {
	$query = $this->db->query("SELECT COUNT(DISTINCT NO_REGISTER) CD
								FROM PASIEN_PPI
								WHERE DARAH = '1'
								AND RUANG ='$idrg'
								AND TGL_SENSUS >= '$tglawal' 
								AND TGL_SENSUS <= '$tglakhir'");
	$row = $query->row();
	return $row->CD;
    }
	
	function count_sputum($idrg,$tglawal,$tglakhir) {
	$query = $this->db->query("SELECT COUNT(DISTINCT NO_REGISTER) CS
								FROM PASIEN_PPI
								WHERE SPUTUM = '1'
								AND RUANG ='$idrg'
								AND TGL_SENSUS >= '$tglawal' 
								AND TGL_SENSUS <= '$tglakhir'");
	$row = $query->row();
	return $row->CS;
    }
	
	function count_swabluka($idrg,$tglawal,$tglakhir) {
	$query = $this->db->query("SELECT COUNT(DISTINCT NO_REGISTER) CSL
								FROM PASIEN_PPI
								WHERE SWAB_LUKA = '1'
								AND RUANG ='$idrg'
								AND TGL_SENSUS >= '$tglawal' 
								AND TGL_SENSUS <= '$tglakhir'");
	$row = $query->row();
	return $row->CSL;
    }
	
	function count_urine($idrg,$tglawal,$tglakhir) {
	$query = $this->db->query("SELECT COUNT(DISTINCT NO_REGISTER) CU
								FROM PASIEN_PPI
								WHERE URINE = '1'
								AND RUANG ='$idrg'
								AND TGL_SENSUS >= '$tglawal' 
								AND TGL_SENSUS <= '$tglakhir'");
	$row = $query->row();
	return $row->CU;
    }
	
	function count_vap($idrg,$tglawal,$tglakhir) {
	$query = $this->db->query("SELECT COUNT(*) CVAP
								FROM(
								SELECT DISTINCT NO_REGISTER,TGL_VAP
								FROM PASIEN_PPI
								WHERE VAP = '1'
								AND RUANG ='$idrg'
								AND TGL_SENSUS >= '$tglawal' 
								AND TGL_SENSUS <= '$tglakhir')");
	$row = $query->row();
	return $row->CVAP;
    }
	
	function count_hap($idrg,$tglawal,$tglakhir) {
	$query = $this->db->query("SELECT COUNT(*) CHAP
								FROM(
								SELECT DISTINCT NO_REGISTER,TGL_HAP
								FROM PASIEN_PPI
								WHERE HAP = '1'
								AND RUANG ='$idrg'
								AND TGL_SENSUS >= '$tglawal' 
								AND TGL_SENSUS <= '$tglakhir')");
	$row = $query->row();
	return $row->CHAP;
    }
	
	function count_ido($idrg,$tglawal,$tglakhir) {
	$query = $this->db->query("SELECT COUNT(*) CIDO
								FROM(
								SELECT DISTINCT NO_REGISTER,TGL_IDO
								FROM PASIEN_PPI
								WHERE IDO = '1'
								AND RUANG ='$idrg'
								AND TGL_SENSUS >= '$tglawal' 
								AND TGL_SENSUS <= '$tglakhir')");
	$row = $query->row();
	return $row->CIDO;
    }
	
	function count_isk($idrg,$tglawal,$tglakhir) {
	$query = $this->db->query("SELECT COUNT(*) CISK
								FROM(
								SELECT DISTINCT NO_REGISTER,TGL_ISK
								FROM PASIEN_PPI
								WHERE ISK = '1'
								AND RUANG ='$idrg'
								AND TGL_SENSUS >= '$tglawal' 
								AND TGL_SENSUS <= '$tglakhir')");
	$row = $query->row();
	return $row->CISK;
    }
	
	function count_iadp($idrg,$tglawal,$tglakhir) {
	$query = $this->db->query("SELECT COUNT(*) CIADP
								FROM(
								SELECT DISTINCT NO_REGISTER,TGL_IADP
								FROM PASIEN_PPI
								WHERE IADP = '1'
								AND RUANG ='$idrg'
								AND TGL_SENSUS >= '$tglawal' 
								AND TGL_SENSUS <= '$tglakhir')");
	$row = $query->row();
	return $row->CIADP;
    }
	
	function count_dekub($idrg,$tglawal,$tglakhir) {
	$query = $this->db->query("SELECT COUNT(*) CDEKUB
								FROM(
								SELECT DISTINCT NO_REGISTER,TGL_DEKUB
								FROM PASIEN_PPI
								WHERE DEKUB = '1'
								AND RUANG ='$idrg'
								AND TGL_SENSUS >= '$tglawal' 
								AND TGL_SENSUS <= '$tglakhir')");
	$row = $query->row();
	return $row->CDEKUB;
    }
	
	function count_pleb($idrg,$tglawal,$tglakhir) {
	$query = $this->db->query("SELECT COUNT(*) CPLEB
								FROM(
								SELECT DISTINCT NO_REGISTER,TGL_PLEB
								FROM PASIEN_PPI
								WHERE PLEB = '1'
								AND RUANG ='$idrg'
								AND TGL_SENSUS >= '$tglawal' 
								AND TGL_SENSUS <= '$tglakhir')");
	$row = $query->row();
	return $row->CPLEB;
    }
}
?>