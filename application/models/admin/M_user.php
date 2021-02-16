<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_user extends CI_Model{
	function __construct(){
		parent::__construct();
	}
		
	function exist($username){
		$this->db->from('HMIS_USERS');
		$this->db->where('USERNAME',$username);	
		return $this->db->count_all_results();	
	}
	
	function check_pass_match($data){
		$this->db->from('HMIS_USERS');
		$this->db->where('USERID', $this->session->userdata('USERID'));	
		$this->db->where('PASSWORD', $data['currpass']);	
		return $this->db->count_all_results();	
	}
	
	function get_all(){
		return $this->db->query("select *
			from HMIS_USERS
			where deleted = 0
			order by USERNAME asc");
	}
	
	function get_dyn_role(){
		return $this->db->query("SELECT ID, ROLE, IS_ACTIVE FROM DYN_ROLE")->result();
	}
	
	function get_user_id($username) {
			$this->db->select('USERID');
			$this->db->from('HMIS_USERS');
			$this->db->where('USERNAME', $username);
			$query = $this->db->get();
			return $query->row(); 
	}
	
	function get_role($roleid) {
			$this->db->select('ROLE');
			$this->db->from('DYN_ROLE');
			$this->db->where('ID', $roleid);
			$query = $this->db->get();
			return $query->row(); 
	}
	
	function get_role_all($id){
		return $this->db->query("select b.ID, NVL(a.ROLEID,0) as STS, b.ROLE
			from DYN_ROLE_USER a
			RIGHT JOIN 
			DYN_ROLE b
			on a.ROLEID = b.ID
			and a.USERID = $id");
	}
	
	function get_role_gudang($id){
		return $this->db->query("select b.id_gudang, IFNULL(a.id_gudang,0) as sts, b.nama_gudang
			from dyn_gudang_user a
			RIGHT JOIN 
			master_gudang b
			on a.id_gudang = b.id_gudang
			and a.userid = $id");
	}

	function get_role_poli($id){
		return $this->db->query("select b.id_poli, IFNULL(a.id_poli,0) as sts, b.nm_poli
			from dyn_poli_user a
			RIGHT JOIN 
			poliklinik b
			on a.id_poli = b.id_poli
			and a.userid = $id");
	}

	function get_role_ruang($id){
		return $this->db->query("select b.idrg as id_ruang, IFNULL(a.id_ruang,0) as sts, b.nmruang as nm_ruang
			from dyn_ruang_user a
			RIGHT JOIN 
			ruang b
			on a.id_ruang = b.idrg
			and a.userid = $id");
	}
	/*
	Attempts to login employee and set session. Returns boolean based on outcome.
	*/
	function login($username, $password)
	{
		//$query = $this->db->get_where('hmis_users', array('username' => $username,'password'=>md5($password), 'deleted'=>0), 1);
		$query = $this->db->get_where('HMIS_USERS', array('USERNAME' => $username,'PASSWORD'=>$password, 'DELETED'=>0), 1);
		if ($query->num_rows() ==1)
		{
			$row=$query->row();
			$this->session->set_userdata('USERID', $row->USERID);
			return true;
		}
		return false;
	}
	
	/*
	Logs out a user by destorying all session data and redirect to login
	*/
	function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
	
	/*
	Determins if a user is logged in
	*/
	function is_logged_in()
	{
		return $this->session->userdata('USERID')!=false;
	}
	/*
	Gets information about a user loged in
	*/
	function get_logged_in_user_info()
	{
		$userid = $this->session->userdata('USERID');
		if (($userid)){
			return $this->get_info($userid);
		}
	}
	/*
	Gets information about a particular user
	*/
	function get_info($userid)
	{
		$this->db->from('HMIS_USERS');	
		$this->db->where('USERID',$userid);
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
			$fields = $this->db->list_fields('HMIS_USERS');

			foreach ($fields as $field)
			{
				$data_obj->$field='';
			}

			return $data_obj;
		}
	}
	/*
	Determins whether the employee specified employee has access the specific module.
	*/
	function has_permission($url,$userid)
	{
		//if no module_id is null, allow access
		if($url==null or $url=='beranda' or $url=='logout')
		{
			return true;
		}else{
			if ($this->is_menu($url)){
				$query = $this->db->query("select count(*) as JML
					from DYN_ROLE_USER ru, DYN_ROLE_MENU rm, DYN_MENU m
					where ru.USERID = $userid
						and ru.ROLEID = rm.ROLE_ID
					  and rm.MENU_ID = m.PAGE_ID
					  and m.URL = '$url'");
				return ($query->row()->JML > 0);
			}else{
				return true;
			}
		}
		return false;
	}
	
	function is_menu($url){
		$query = $this->db->query("select count(SHOW_MENU) as JML
					from DYN_MENU
					where URL = '$url' and SHOW_MENU = 1");
		return ($query->row()->JML == 1);
	}
	
	function has_gudang_access($userid,$id_gudang)
	{
		$query = $this->db->query("select count(*) as JML
					from dyn_gudang_user
					where userid = $userid and id_gudang = $id_gudang");
		return $query->row()->JML;
	}

	function has_poli_access($userid,$id_poli)
	{
		$query = $this->db->query("select count(*) as JML
					from dyn_poli_user
					where userid = $userid and id_poli = $id_poli");
		return $query->row()->JML;
	}

	function has_ruang_access($userid,$id_ruang)
	{
		$query = $this->db->query("select count(*) as JML
					from dyn_ruang_user
					where userid = $userid and id_ruang = $id_ruang");
		return $query->row()->JML;
	}
	
	function save($duser_insert)
	{	
		$this->db->trans_start();
        $this->db->insert('HMIS_USERS', $duser_insert);
		$this->db->trans_complete();
	}
	
	function save2($role_insert)
	{	
		$this->db->trans_start();
		$this->db->insert('DYN_ROLE_USER', $role_insert);
		$this->db->trans_complete();
	}
	
	function update($data){	
		$this->db->set('PASSWORD', $data["vpassword"]);
		$this->db->where('USERID', $data["vuserid"]);
		return $this->db->update('HMIS_USERS');
	}
	function delete($id)
	{
		$this->db->where('USERID',$id);	
		if ($this->db->delete('HMIS_USERS')){
			return true;
		}else{			
			return false;
		}
	}
	function userRoleSave($id,&$data)
	{	
		$this->db->where('USERID', $id);
		$this->db->delete('DYN_ROLE_USER');
		$temp =count($data);
		for($i=0; $i<$temp; $i++){
			$this->db->insert('DYN_ROLE_USER',$data[$i]);
		}
		return true;
	}
	/*function userGdgSave($id,&$data)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_gudang_user');
		$temp =count($data);
		for($i=0; $i<$temp;$i++){
			$this->db->insert('dyn_gudang_user',$data[$i]);
		}
		return true;
	}
	function userGdgDelete($id)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_gudang_user');		
		return true;
	}
	function userPoliSave($id,&$data)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_poli_user');
		$temp =count($data);
		for($i=0; $i<$temp;$i++){
			$this->db->insert('dyn_poli_user',$data[$i]);
		}
		return true;
	}
	function userPoliDelete($id)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_poli_user');		
		return true;
	}
	function userRuangSave($id,&$data)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_ruang_user');
		$temp =count($data);
		for($i=0; $i<$temp;$i++){
			$this->db->insert('dyn_ruang_user',$data[$i]);
		}
		return true;
	}
	function userRuangDelete($id)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_ruang_user');		
		return true;
	} */

	
	function update_photo($uid, $foto){
		return $this->db->query("update HMIS_USERS set FOTO = '".$foto."' where USERNAMEE = '".$uid."'");
	}
	function update_name($data){
		return $this->db->query("update hmis_users set NAME = '".$data["uname"]."' where USERNAME = '".$data["uid"]."'");
	}
	function change_pass($data){
		return $this->db->query("update hmis_users set PASSWORD = '".$data["newpass"]."' where USERID = '".$this->session->userdata('USERID')."'");
	}
}
?>
