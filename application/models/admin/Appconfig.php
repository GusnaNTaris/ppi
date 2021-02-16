<?php
class Appconfig extends CI_Model 
{
	
	function exists($key)
	{
		$this->db->from('APP_CONFIG');	
		$this->db->where('APP_CONFIG.KEY',$key);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	
	function get_all()
	{
		$this->db->from('APP_CONFIG');
		$this->db->order_by("KEY", "asc");
		return $this->db->get();		
	}
	
	function get($key)
	{
		$query = $this->db->get_where('APP_CONFIG', array('KEY' => $key), 1);
		
		if($query->num_rows()==1)
		{
			return $query->row()->value;
		}
		
		return "";
		
	}
	
	function save($key,$value)
	{
		$config_data=array(
		'KEY'=>$key,
		'VALUE'=>$value
		);
				
		if (!$this->exists($key))
		{
			return $this->db->insert('APP_CONFIG',$config_data);
		}
		
		$this->db->where('KEY', $key);
		return $this->db->update('APP_CONFIG',$config_data);		
	}
	
	function batch_save($data)
	{
		$success=true;
		
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		foreach($data as $key=>$value)
		{
			if(!$this->save($key,$value))
			{
				$success=false;
				break;
			}
		}
		
		$this->db->trans_complete();		
		return $success;		
	}
		
	function delete($key)
	{
		return $this->db->delete('APP_CONFIG', array('key' => $key)); 
	}
	
	function delete_all()
	{
		return $this->db->empty_table('APP_CONFIG'); 
	}
}

?>