<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_role extends CI_Model{
	function __construct(){
		parent::__construct();
	}
		
	function exist($role){
		$this->db->from('DYN_ROLE');
		$this->db->where('ROLE',$role);	
		return $this->db->count_all_results();	
	}
	
	function get_all(){
		return $this->db->query("select *
			from DYN_ROLE
			where IS_ACTIVE = 1
			order by ROLE asc");
	}
	function get_info($id)
	{
		$this->db->from('DYN_ROLE');	
		$this->db->where('ID',$id);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_id is NOT an item
			$data_obj=new stdClass();

			//Get all the fields from items table
			$fields = $this->db->list_fields('DYN_ROLE');

			foreach ($fields as $field)
			{
				$data_obj->$field='';
			}

			return $data_obj;
		}
	}
	
	function save($data)
	{	
		if ($data["ID"] == ''){
			$this->db->set('IS_ACTIVE', '1');
			$role = $data["ROLE"];
			$deskripsi = $data["DESKRIPSI"];
			// if($this->db->insert('DYN_ROLE',$data))
			$query = $this->db->query("INSERT INTO DYN_ROLE (IS_ACTIVE, ROLE, DESKRIPSI) VALUES ('1', '$role','$deskripsi')");
			if($query)
			{
				return true;
			}
			return false;
		}else{			
			$this->db->set('IS_ACTIVE', $data["IS_ACTIVE"]);
			$this->db->where('ID', $data["ID"]);
			return $this->db->update('DYN_ROLE');
		}
	}
	
	function delete($id)
	{
		$this->db->where('ID',$id);	
		if ($this->db->delete('DYN_ROLE')){
			return true;
		}else{			
			return false;
		}
	}
	
	function get_menu_all($id){
		return $this->db->query("select b.PAGE_ID,
			CASE WHEN b.IS_PARENT = 1 THEN CONCAT(LPAD(b.PAGE_ID,2,'0'),'00')
									ELSE CONCAT(LPAD(b.PARENT_ID,2,'0'),LPAD(b.POSITION,2,'0'))
			END AS URUTAN,
			CASE WHEN (b.IS_PARENT = 1 or b.PARENT_ID = 0) THEN b.TITLE
									ELSE CONCAT('<i class=\"fa fa-angle-double-right fa-fw\"></i>',b.TITLE)
			END AS TITLE, NVL(a.ROLE_ID,0) AS STS
			from DYN_ROLE_MENU a
			RIGHT JOIN 
			DYN_MENU b
			on a.MENU_ID = b.PAGE_ID
			and a.ROLE_ID = $id
			order by URUTAN asc");
	}
	
	function roleMenuSave($id,&$data)
	{	
		$this->db->where('ROLE_ID', $id);
		$this->db->delete('DYN_ROLE_MENU');
		$temp =count($data);
		for($i=0; $i<$temp;$i++){
			$this->db->insert('DYN_ROLE_MENU',$data[$i]);
		}
		return true;
	}
}
?>