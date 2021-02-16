 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ("Secure_area.php");
class Admin extends Secure_area {
	public function __construct() {
		parent::__construct();
		
		$this->load->model('admin/M_user','',TRUE);
		$this->load->model('admin/M_menu','',TRUE);
		$this->load->model('admin/M_role','',TRUE);
		$this->load->model('admin/Appconfig','',TRUE);
		$this->load->model('admin/Mbpjs','',TRUE);
	}
	
	public function index()
	{
	}
	/*=================================== USER ============================================*/
	public function user()
	{
		$data["title"] = "Data User";
		$data["role"] = $this->M_user->get_dyn_role();
		$this->load->view('admin/user', $data);
	}
	
	
	public function userExist(){			
		$username = $this->input->post('id');
		$exist = $this->M_user->exist($username);
		if ($exist > 0){
			echo json_encode(array('exist'=>true));
		}else{
			echo json_encode(array('exist'=>false));
		}
	}
	
	public function adduser(){
	$this->load->view('admin/user');
	}
	
	public function userInfo(){			
		$userid = $this->input->post('id');
		$data = $this->M_user->get_info($userid);
		echo json_encode($data);
	}
	
	public function userList() {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_user->get_all()->result();
		/*echo json_encode($hasil);*/
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->USERID;
			$row2['username'] = $value->USERNAME;
			$row2['name'] = $value->NAME;
			$row2['role'] = '<center><a href="#" type="button" class="btn btn-primary btn-xs" title="Set Roles" data-toggle="modal" data-target="#myModal" onclick="setUserRole('.$value->USERID.',\''.$value->USERNAME.'\')" ><i class="fa fa-user-secret fa-fw"></i></a></center>';
			$row2['aksi'] = '<center><a href="#" type="button" class="btn btn-success btn-xs" title="Reset Password" data-toggle="modal" data-target="#editModal" data-id="'.$value->USERID.'" data-username="'.$value->USERNAME.'"><i class="fa fa-edit fa-fw"></i></a>&nbsp;<a href="'.base_url().'admin/dropUser/'.$value->USERID.'" type="button" class="btn btn-danger btn-xs delete_user" title="Delete"><i class="fa fa-trash fa-fw"></i></a></center>';
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function userRoleList($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_user->get_role_all($id)->result();
		/*echo json_encode($hasil);*/
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->ID;
			$row2['sts'] = $value->STS;
			$row2['role'] = $value->ROLE;
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function userRoleSave(){
		$data = $this->input->post('vdata');
		$id = $data[0]['USERID'];
		
		if($this->M_user->userRoleSave($id,$data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	}
	/*
	public function userGdgList($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_user->get_role_gudang($id)->result();
		/*echo json_encode($hasil);
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->id_gudang;
			$row2['sts'] = $value->sts;
			$row2['nama'] = $value->nama_gudang;
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	public function userPoliList($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_user->get_role_poli($id)->result();
		/*echo json_encode($hasil);
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->id_poli;
			$row2['sts'] = $value->sts;
			$row2['nama'] = $value->nm_poli;
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	public function userRuangList($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_user->get_role_ruang($id)->result();
		/*echo json_encode($hasil);
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->id_ruang;
			$row2['sts'] = $value->sts;
			$row2['nama'] = $value->nm_ruang;
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}

	public function userGdgDelete(){
		$id = $this->input->post('vdata');
	
		$this->M_user->userGdgelete($id);
			echo json_encode(array('success'=>true));
		
		
	}

	public function userGdgSave(){
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		
		if($this->M_user->userGdgSave($id,$data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	}

	public function userPoliDelete(){
		$id = $this->input->post('vdata');
		
		$this->M_user->userPoliDelete($id);
			echo json_encode(array('success'=>true));
		
		
	}

	public function userPoliSave(){
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		
		if($this->M_user->userPoliSave($id,$data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	}

	public function userRuangDelete(){
		$id = $this->input->post('vdata');
		
		$this->M_user->userRuangDelete($id);
			echo json_encode(array('success'=>true));
		
		
	}

	public function userRuangSave(){
		$data = $this->input->post('vdata');
		$id = $data[0]['userid'];
		
		if($this->M_user->userRuangSave($id,$data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	} */

	function user_insert()
	{
		$duser_insert = array(	
			'NAME' => $this->input->post('name'),
			'USERNAME' => $this->input->post('username'),
			'PASSWORD' => $this->input->post('password'),
			'EMAIL' => $this->input->post('email'),
			'FOTO' => 'diki.jpg',
			'DELETED' => '0'
		);
		$this->M_user->save($duser_insert);
		$role_insert = array(	
			'ROLEID' => $this->input->post('roleid'),
			'ROLE' => $this->M_user->get_role($this->input->post('roleid'))->ROLE,
			'USERID' => $this->M_user->get_user_id($this->input->post('username'))->USERID
		);
		$this->M_user->save2($role_insert);
	}

	public function reset_password(){	
		if($this->M_user->update($this->input->post())){	
			echo json_encode(array('success'=>true));			
			//redirect(site_url("Admin/user"), 'refresh');
		}else{
			echo json_encode(array('success'=>false));			
			//redirect(site_url("Admin/user"), 'refresh');
		}
	}
	public function userSave($data,$foto){	
		if($this->M_user->save($data,$foto)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
	}
	
	public function dropUser($userid){				
		if($this->M_user->delete($userid)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
	}
	
	function update_photo()
	{
		$uid = $this->input->post('uid');
		//upload logo
		$config['upload_path'] = './upload/user/';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		$config['file_name'] = $uid;
		$this->upload->initialize($config);
		
		$userfile = $_FILES['userfile']['name'];
		$data = $this->input->post();
		
		if ($userfile){
			$ext = pathinfo($userfile, PATHINFO_EXTENSION);
			$file = $config['upload_path'].$config['file_name'].'.'.$ext;
			if(is_file($file))
				unlink($file);
				
			if(!$this->upload->do_upload()){
				$error = $this->upload->display_errors();
				echo $error;
			}else{
				$upload = $this->upload->data();
				$foto = $upload['file_name'];
				
				if ($this->M_user->update_photo($uid, $foto)){
					echo json_encode(array('success'=>true,'photo'=>$foto));
				}else{
					echo json_encode(array('success'=>true,'photo'=>'unknown.png'));
				}
			}	
		}			
	}
	function update_name(){
		$name = $this->input->post('uname');
		if ($this->M_user->update_name($this->input->post())){
			echo json_encode(array('success'=>true,'name'=>$name));
		}
	}
	/*======================================== MENU =================================================*/
	public function menu()
	{
		$data["title"] = "Data Menu";
		$data['parents'] = $this->M_menu->get_all_menu();
		$data['sortMenu'] = sortMenu();
		$this->load->view('admin/menu', $data);
	
	}
	
	public function menuInfo(){			
		$page_id = $this->input->post('id');
		$data = $this->M_menu->get_info($page_id);
		echo json_encode($data);
	}
	
	public function hasChildMenu(){			
		$page_id = $this->input->post('id');
		$child = $this->M_menu->has_child($page_id);
		if ($child > 0){
			echo json_encode(array('hasChild'=>true));
		}else{
			echo json_encode(array('hasChild'=>false));
		}
	}
	
	public function menuSave(){						
		$data = array(
			'PAGE_ID'=>$this->input->post('id'),
			'TITLE'=>$this->input->post('title'),
			'URL'=>$this->input->post('url'),
			'PARENT_ID'=>$this->input->post('parent_id')
		);
		if($this->M_menu->save($data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
	}
	
	public function dropMenu(){				
		$page_id = $this->input->post('id');
		if($this->M_menu->delete($page_id)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
	}
	
	public function updateOrderMenu(){						
		$arr = $this->input->post('data');
		echo $this->M_menu->updatePosition($arr);
	}
	/*================================== ROLE ========================================*/
	
	public function role()
	{
		$data["title"] = "Data Role";
		$this->load->view('admin/role', $data);
	}
	
	public function roleExist(){			
		$role = $this->input->post('role');
		$exist = $this->M_role->exist($role);
		if ($exist > 0){
			echo json_encode(array('exist'=>true));
		}else{
			echo json_encode(array('exist'=>false));
		}
	}
	
	public function roleList() {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_role->get_all()->result();
		/*echo json_encode($hasil);*/
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->ID;
			$row2['role'] = $value->ROLE;
			$row2['deskripsi'] = $value->DESKRIPSI;
			$row2['access'] = '<center><a href="#" title="Set Access Menu" data-toggle="modal" data-target="#myModal" onclick="setAccessRole('.$value->ID.',\''.$value->ROLE.'\')" ><i class="fa fa-user-secret fa-fw"></i></a></center>';
			$row2['edit'] = '<center><a href="'.base_url().'admin/setInactive/'.$value->ID./*'/'.$value->IS_ACTIVE.*/'" type="button" class="inactive_role" title="Set Inactive"><i class="fa fa-edit fa-fw"></i></a></center>';
			$row2['drop'] = '<center><a href="'.base_url().'admin/dropRole/'.$value->ID.'" type="button" class="btn btn-danger btn-xs delete_role" title="Delete"><i class="fa fa-trash fa-fw"></i></a></center>';
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function roleSave(){	
		$data = array(
			'ID'=>$this->input->post('id'),
			'ROLE'=>$this->input->post('role'),
			'DESKRIPSI'=>$this->input->post('deskripsi')
		);
		/*echo json_encode($data);*/
		
		if($this->M_role->save($data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	}
	
	public function setInactive($roleid/*,$is_active*/){
		/*if ($is_active == 1){*/
		$data = array(
			'ID'=> $roleid,
			'IS_ACTIVE'=> '0');
		/*} else {
		$data = array(
			'ID'=> $roleid,
			'IS_ACTIVE'=> '1');
		}*/
		if($this->M_role->save($data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
	}
	
	public function dropRole($roleid){				
		if($this->M_role->delete($roleid)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
	}
	
	public function roleMenuList($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_role->get_menu_all($id)->result();
		/*echo json_encode($hasil);*/
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->PAGE_ID;
			$row2['urutan'] = $value->URUTAN;
			$row2['sts'] = $value->STS;
			$row2['menu'] = $value->TITLE;
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function roleMenuSave(){
		$data = $this->input->post('vdata');
		$id = $data[0]['ROLE_ID'];
		/**/
		if($this->M_role->roleMenuSave($id,$data)){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	}

	/*======================================== Konfigurasi BPJS =================================================	

	function konfigurasi_bpjs()
	{
		$data['title'] = 'Konfigurasi BPJS';
		$data['data']=$this->Mbpjs->get_bpjs()->row();
		$this->load->view("admin/bpjs", $data);
	
	}	
	
	public function update_bpjs(){
		$rsid = $this->input->post('rsid');
		$data_bpjs = array(
         'service_url' => $this->input->post('service_url'),
         'consid' => $this->input->post('consid'),
         'secid' => $this->input->post('secid'),
         'rsid' => $this->input->post('rsid')
            );
         $update = $this->Mbpjs->update_bpjs($data_bpjs);
         echo json_encode($update);
	}	

	/*======================================== KASTEM =================================================*/
	function config()
	{
		$data["title"] = "Kastemisasi Aplikasi";
		$this->load->view('admin/config', $data);
	
	}

	function configSave()
	{
		$data=array(
			'web_title'=>$this->input->post('web_title'),
			'header_title'=>$this->input->post('header_title'),
			'logo_url'=>$this->input->post('userfile'),
			'skin'=>$this->input->post('skin'),
			'namars'=>$this->input->post('namars'),
			'namasingkat'=>$this->input->post('namasingkat'),
			'alamat'=>$this->input->post('alamat'),
			'telp'=>$this->input->post('telp'),
			'kota'=>$this->input->post('kota')
		);
		
		//upload logo
		$config['upload_path'] = './asset/images/logos';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		$this->upload->initialize($config);
		
		$old_logo = $this->config->item('logo_url');
		
		if(!$this->upload->do_upload()){
			$data['logo_url']=$old_logo;
			//$error = $this->upload->display_errors();
			//echo $error;
		}else{
			$upload = $this->upload->data();
			$data['logo_url']=$upload['file_name'];
		}
		
		if( $this->Appconfig->batch_save( $data ) )
		{
			//delete old logo
			if ($data['logo_url'] != $old_logo && $old_logo != "logo.png"){
				$file = './asset/images/logos/'.$old_logo;
				if(is_file($file))
					unlink($file);
			}
			redirect(site_url("admin/config"), 'refresh');
		}
		
	}
}

?>
