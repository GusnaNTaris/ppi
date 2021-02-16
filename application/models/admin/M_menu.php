<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_menu extends CI_Model{
	function __construct(){
		parent::__construct();
	}	
	
	function get_child($PARENT_ID){
		$this->db->from('DYN_MENU');
		$this->db->where('SHOW_MENU',1);			
		$this->db->where('PARENT_ID',$PARENT_ID);			
		$this->db->order_by("POSITION", "asc");
		return $this->db->get();	
	}
	
	function get_allowed_menu($PARENT_ID){
		$userid = $this->session->userdata('USERID');
		return $this->db->query("select distinct m.*
			from DYN_ROLE_USER ru, DYN_ROLE_MENU rm, DYN_MENU m
			where ru.USERID = $userid	
			and ru.ROLEID = rm.ROLE_ID 
			and rm.MENU_ID = m.PAGE_ID
			and m.PARENT_ID = $PARENT_ID
			and m.SHOW_MENU = 1
			order by POSITION asc");
	}
	
	function get_breadcrumb($url){
		return $this->db->query("select c.TITLE, c.URL, c.PARENT_ID, p.TITLE as ptitle
			from DYN_MENU p, DYN_MENU c
			where c.URL = '$url'
			and p.PAGE_ID = c.PARENT_ID");
	}
	/*
	function get_all_menu()
	{
		$this->db->select("id,
			CASE WHEN IS_PARENT = 1 THEN CONCAT(id,'00')
									ELSE CONCAT(PARENT_ID,POSITION)
			END AS urutan,
			CASE WHEN (IS_PARENT = 1 or PARENT_ID = 0) THEN title
									ELSE CONCAT('&nbsp;&nbsp;&nbsp;',title)
			END AS title",FALSE);
		$this->db->where('PARENT_ID','0');	
		$this->db->from('menu');
		$this->db->order_by("urutan", "asc");
		$query=$this->db->get();
		//return $query->result_array();	
		$data[0] = "-- Root --";
		foreach($query->result() as $row)
		{
			$data[$row->id] = $row->title;
		}
		return $data;	
	}
	*/
	function get_all_menu()
	{
		$this->db->select("PAGE_ID, TITLE",FALSE);
		$this->db->where('PARENT_ID','0');	
		$this->db->from('DYN_MENU');
		$this->db->order_by("POSITION", "asc");
		$query=$this->db->get();
		//return $query->result_array();	
		$data[0] = "-- Root --";
		foreach($query->result() as $row)
		{
			$data[$row->PAGE_ID] = $row->TITLE;
		}
		return $data;	
	}
	
	function save(&$data)
	{	
		if ($data["PAGE_ID"] == ''){
			$POSITION = $this->get_max_POSITION($data["PARENT_ID"]) + 1;
			$this->db->set('SHOW_MENU', '1');
			$this->db->set('IS_PARENT', '0');
			$this->db->set('POSITION', $POSITION);
			$this->db->set('TITLE', $data['TITLE']);
			$this->db->set('PAGE_ID', NULL);
			$this->db->set('URL', $data['URL']);
			$this->db->set('PARENT_ID', $data['PARENT_ID']);
			if ($this->db->insert('DYN_MENU')){
				$this->updateIsParent($data["PARENT_ID"]);
				return true;
			}else{			
				return false;
			}
		}else{			
			$this->db->set('TITLE', $data["TITLE"]);
			$this->db->set('URL', $data["URL"]);
			$this->db->set('PARENT_ID', $data["PARENT_ID"]);
			$this->db->where('PAGE_ID',$data["PAGE_ID"]);	
			if ($this->db->update('DYN_MENU')){
				$this->updateIsParent($data["PARENT_ID"]);
				return true;
			}else{			
				return false;
			}
		}
	}
	
	function delete($id)
	{
		$this->db->where('PAGE_ID',$id);	
		if ($this->db->delete('DYN_MENU')){
			return true;
		}else{			
			return false;
		}
	}
	
	function updatePOSITION(&$data)
	{
		$true = 0;
		$false = 0;
		foreach ($data as $key => $value) {
			$POSITION = $key + 1;
			$id = str_replace("ID_","",$value);
			$this->db->set('POSITION', $POSITION);
			$this->db->where('PAGE_ID',$id);	
			if ($this->db->update('DYN_MENU'))
				$true += 1;
			else
				$false += 1;
		}
		$out = "True:".$true." - False:".$false;
		return true;
	}
	
	function updateIsParent($id)
	{
		$this->db->set('IS_PARENT', 1);
		$this->db->where('PAGE_ID',$id);	
		$this->db->update('DYN_MENU');
		return true;
	}
	function get_max_POSITION($parent_id){
		$this->db->select_max('POSITION');
		$this->db->where('PARENT_ID',$parent_id);	
		return $this->db->get('DYN_MENU')->row()->POSITION;
	}
	
	function get_info($id)
	{
		$query = $this->db->get_where('DYN_MENU', array('PAGE_ID' => $id), 1);
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//create object with empty properties.
			$fields = $this->db->list_fields('DYN_MENU');
			$obj = new stdClass;
			
			foreach ($fields as $field)
			{
				$obj->$field='';
			}
			
			return $obj;
		}
	}
	
	function has_child($PARENT_ID){
		$this->db->from('DYN_MENU');
		$this->db->where('PARENT_ID',$PARENT_ID);	
		return $this->db->count_all_results();	
	}
	
	function has_parent($id){
		$this->db->from('DYN_MENU');
		$this->db->where('PAGE_ID',$id);	
		$this->db->where('PARENT_ID','>0');	
		return $this->db->count_all_results();	
	}
}
?>