<?php
include(APPPATH.'/controllers/auth/authcontroller'.EXT);
class GantiExpiredPass extends Authcontroller {
	
	function __construct() {
        parent::__construct();
	}
	
	function index() {
		$userid				= $this->session->userdata('UserID');
	 	$data['userid']		= $userid;
	 	$data['username']	= $this->session->userdata('UserName');
		$data['md5oldpass']	= $this->_getMD5Passwd($userid);
		$this->load->view('utility/gantipass/gantiexpiredpassword_form', $data);
	}
	
	function updatePass() {
	 	$userid		= $this->input->post('userid');
	 	$password	= $this->input->post('passwordbaru');
		$md5pass	= md5($password);
		$oldmd5pass	= $this->input->post('oldmd5pass');
		if($md5pass!=$oldmd5pass) {
			if($this->_updatePassword($userid,$password)) {
				$ar	= array('IsPwdExpired'	=> 0);
				$this->session->set_userdata($ar);
				$this->_insertLastLogin($userid);
				$defaultpage = $this->_getDefaultPage($userid);
				redirect($defaultpage);
			}
			else
				$this->index();
		}
		else
			$this->index();
	}

	function _updatePassword($userid='0',$password) {
		$mdpassword = md5($password);
		$today		= date("Y-m-d");
        $this->db->where('UserID',$userid);
        if($this->db->update('usermst',array('UserPwd' => $mdpassword, 'LastPwdDate' => $today)))
            return TRUE;
        else
            return FALSE;

	}
			
	function _getMD5Passwd($userid) {
		$sql	= "SELECT UserPwd FROM usermst WHERE UserID=?";
		$query	= $this->db->query($sql,array($userid));
        if ($query->num_rows()>0){
			$result	= $query->result_array();
            return $result[0]['UserPwd'];
        }
		else return FALSE;
	}
	
	function _insertLastLogin($userid){
		$this->load->helper('date');
		$now = standard_date($fmt = 'MySQL_DATETIME', now());
		$this->db->where('UserID',$userid);
		$this->db->update('usermst',array('LastLogin' => $now));
	}

	function _getDefaultPage($userid){
		$sql = "SELECT DefaultPage FROM usermst WHERE UserID=?";
		$query = $this->db->query($sql,array($userid));
		$result = $query->result_array();
		return $result[0]['DefaultPage'];
	}
}