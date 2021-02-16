<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_config extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }
    function get_config() 
    {
        $this->db->from('TB_CONFIG');
        $this->db->select('*');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }
    public function update_config($data_bpjs) 
    {
        $this->db->update('TB_CONFIG', $data_bpjs);
        $this->db->limit(1);
        return true;        
    }   
}