<?php
include(APPPATH.'/controllers/auth/authcontroller'.EXT);
class Gantipass extends Authcontroller {
    var $isusermodify;
	function __construct(){
        parent::__construct();
        define("MENU_ID", "3");
		$userid		= $this->session->userdata('UserID');
        $this->isusermodify = $this->isUserAuthModify($userid,MENU_ID);
        $this->redirectNoAuthRead($userid,MENU_ID);
	}
	
	function index($messege='')
	{
	 	$data['userid'] = $this->session->userdata('UserID');
	 	$data['username'] = $this->session->userdata('UserName');
	 	$data['messege'] = $messege;
		$this->load->view('utility/gantipass/gantipassword_form', $data);
	}
	
	function updatePass(){
	 	$userid = $this->input->post('userid');
	 	$password = $this->input->post('passwordbaru');
	    if($this->_updatePassword($userid,$password)) {
	        $this->index('Password Telah Di Ganti');
		}
	    else
	        $this->index('Password Tidak Berhasil Di Ganti');
	}

	function _updatePassword($userid='0',$password) {
		$mdpassword = md5($password);
		$today		= date("Y-m-d H:i:s");
        $this->db->where('UserID',$userid);
        if($this->db->update('usermst',array('UserPwd' => $mdpassword, 'LastPwdDate' => $today)))
            return TRUE;
        else
            return FALSE;

	}
}
