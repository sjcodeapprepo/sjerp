<?php
include(APPPATH.'/controllers/auth/authcontroller'.EXT);
class Pengguna extends Authcontroller {
	
    var $isusermodify;
	
	function __construct()
	{
		parent::__construct();
        define("MENU_ID", "1");
	    $userid=$this->session->userdata('UserID');
        $this->redirectNoAuthRead($userid,MENU_ID);
        $this->isusermodify = $this->isUserAuthModify($userid,MENU_ID);
	}
	
	function index()
	{
	 	$data['group'] = $this->_view_group();
	 	$data['modifyflag'] = $this->isusermodify;
		$this->load->view('utility/pengguna/pengguna_form', $data);
	}
	
	function insert()
	{
	 	  $kirim = $this->input->post('kirim');
	 	  
          if ($kirim==1) {
           	 $UserPwd = $this->input->post('UserPwd');
           	 $UserPwd_confirm = $this->input->post('UserPwd_confirm');
           	 
           	 if($UserPwd != $UserPwd_confirm){
				echo "<script>
					  alert('Konfirmasi password salah!');
					  location.href='../pengguna'
					  </script>";
			 }else{
				 $ActiveFlg = $this->input->post('ActiveFlg');
			 	 if($ActiveFlg==1){
					$ActiveFlg = 1;
				 }
			  	 else{
					$ActiveFlg = 0;
				 }
			 	 $mdUserPwd = md5($UserPwd);
				 $defaultpage = $this->input->post('defaultpage');
				 if($defaultpage=='')$defaultpage = 'auth/login/menu';
				 $data = array(
						'UserName'		=> $this->input->post('UserName'),
						'UserPwd'		=> $mdUserPwd,
						'UserGroupID'	=> $this->input->post('UserGroupID'),
						'DefaultPage'	=> $defaultpage,
						'ActiveFlg'		=> $ActiveFlg,
				 );
	         	
				$this->_insert($data);
				echo "<script>
					  alert('Data berhasil diinput!');
					  location.href='../pengguna'
					  </script>";
			 }
		}
	}

	function _view_group()
	{
        $sql = 'SELECT * FROM usergroupmst';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
	}

	function _insert($data)
	{
		if($this->db->insert('usermst', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
?>