<?php
Class Authcontroller extends CI_Controller {
	
	/**
	* @property Authmodel $authmodel
	* 
	*/
		
    function __construct() {
        parent::__construct();
    }
    
    function index(){
		$UserName		= $this->session->userdata('UserName');
		$UserPwd		= $this->session->userdata('UserPwd');
		$datauserlogin	= $this->authmodel->getValidUser($UserName,$UserPwd);
		
        if (!empty($datauserlogin)) {
			$this->session->set_userdata($datauserlogin[0]);
			$userid		= $this->session->userdata('UserID');
			$this->_insertLastLogin($userid);
			$defaultpage = $this->_getDefaultPage($userid);
			redirect($defaultpage);
        }
        else {
			$dataunset = array('SjSession' => FALSE, 'LogedIn' => FALSE);
			$this->session->unset_userdata($dataunset);
			
			$data['msg']		= 'salah username/password !!!';
			$data['company']	= $this->config->item('dbs');
			$this->load->view('auth/login',$data);
        }
	}

	function _insertLastLogin($userid){
		$this->load->helper('date');
		$now = standard_date($fmt = 'DATETIME', now());
		$remote_address	= $_SERVER['REMOTE_ADDR'];
		$this->db->where('UserID',$userid);
		$this->db->update('usermst',array('LastLogin' => $now, 'IPRemote'=>$remote_address));
	}

	function _getDefaultPage($userid){
//		$result[0]['DefaultPage']='auth/login/welcome';
		$sql = "SELECT DefaultPage FROM usermst WHERE UserID=?";
		$query = $this->db->query($sql,array($userid));
		$result = $query->result_array();
		return $result[0]['DefaultPage'];
	}

	function redirectOnlyOneAppOpen() {
		$sessid_flash	= $this->session->flashdata('sessid_flash');
		$sessid_session	= $this->session->userdata('session_id');
		if($sessid_session != $sessid_flash) {
			redirect('auth/login/onlyoneplease');
		}
		else {
			$this->session->set_flashdata('sessid_flash', $sessid_flash);
		}
	}
    
    function redirectNoAuthRead($userid,$menuid){		
        $isauthread = $this->authmodel->getAuthRead($userid,$menuid);
		$logedin	= $this->session->userdata('LogedIn');
		$expiredpasswd	= $this->session->userdata('IsPwdExpired');
        if (!$isauthread OR !$logedin) {
         	redirect('auth/login/NoAuth');
        }
		else if($expiredpasswd==1) {
			redirect('utility/gantiexpiredpass');
		} 
		else {
			$now = standard_date($fmt = 'DATETIME', now());
//			$this->db->where('UserID',$userid);
//			$this->db->update('usermst',array('LastVisitingTime' => $now, 'LastVisitingMenuID'=>$menuid));
			
//			$remote_address	= $_SERVER['REMOTE_ADDR'];
//			$data	= array(
//						'IpRemote'	=> $remote_address,
//						'UserID'	=> $userid,
//						'MenuID'	=> $menuid,
//						'TimeAccess'=> $now
//					);
//			$this->db->insert('accesslog', $data); 			
			
		}
    }
	
	function ischeckcompany($companyurlsegment) {
		$retval	= FALSE;
		$dbarr	= $this->config->item('dbs');
		foreach ($dbarr as $dbval) {
			$companynamedbs	= $dbval['dbscfg'];
			if($companyurlsegment==$companynamedbs) {
				$retval	= TRUE;
			}
		}
		return $retval;
	}
	
   	function authUser($username,$password){
        $data['user'] = $this->authmodel->getValidUser($username,$password);
        //cek kalo ada username dan password ada di database apa ga.. klo ga ada redirect login view
        //klo ada di redirect ke menu
        if (!empty($data['user'])){
            $this->session->set_userdata($data['user'][0]);
            $this->load->view('menu',$data);
        }
        else {
            $data['redirect']=1;
            $this->load->view('auth/login',$data);
        }
    }
    
    function isUserAuthModify($userid,$menuid){
        $isuserauthmodify = $this->authmodel->getAuthModify($userid,$menuid);
        return $isuserauthmodify;
    }

	function getCompanyName() {
		$sql = "SELECT CompanyName FROM companymst";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result[0]['CompanyName'];
	}
}   
?>
