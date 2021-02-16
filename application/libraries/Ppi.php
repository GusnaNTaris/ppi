<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');    
   
class Ppi {  
	public $tb_config;
    public $connection_error;
    public function __construct() {      
        $this->CI =& get_instance();         
        $this->CI->load->helper('url');
        $this->CI->config->item('base_url');     
        $this->CI->load->model('M_config','',TRUE);
        $this->tb_config = $this->CI->M_config->get_config();
        $result_error = array(
            'status' => 'gagal',
            'message' => 'Terjadi Kesalahan, koneksi dengan service gagal.',
            'id_tb_03' => null
        );
        $this->connection_error = json_encode($result_error); 		
    }  

    public function post($data_request) 
    {    	
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();  	
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: application/x-www-form-urlencoded',
		   'X-rs-id: ' . $this->tb_config->X_RS_ID,
           'X-pass: ' . md5($this->tb_config->X_PASS),
		   'X-Timestamp: ' . $timestamp
		);


	  							
		$ch = curl_init($this->tb_config->SERVICE_URL);	
		curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$result = curl_exec($ch);
        if(!$result) return $this->connection_error;
		curl_close($ch);  		
		return $result;
    }

}  
?>