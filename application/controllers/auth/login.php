<?php
class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$sawit_session = $this->session->userdata('SjSession');
		if(!$sawit_session) {
			$data['company']	= $this->config->item('dbs');
			$data['msg']		= '';
			$this->load->view('auth/login',$data);
			// echo 'test';
		}
		else { 
			$logedin = $this->session->userdata('LogedIn');
			if($logedin) {
				redirect('auth/authcontroller');
			} else {
				$this->logout();
			}
		}		
	}

	function setJtArjunaSessionDB() {
		$UserName	= $this->input->post('UserName');
		$UserPwd	= $this->input->post('UserPwd');
		$sawit_session	= $this->session->userdata('SjSession');
		if(!$sawit_session) {
			$ar1	= array(
						'SjSession' => TRUE,
						'LogedIn'	=> FALSE,
						'UserName'	=> $UserName,
						'UserPwd'	=> $UserPwd
					);
			$this->session->set_userdata($ar1);			
			
		}
		redirect('auth/authcontroller');
	}
	
	function NoAuth() {
		$this->load->view('auth/redirect');
	}

	function welcome(){
		$data['username']	= $this->session->userdata('UserName');
		$this->load->view('welcome_message',$data);
	}

	function onlyoneplease() {
		echo 'satu aja dong';
	}
	
	function logout(){
		$dataunset = array('SjSession' => FALSE, 'LogedIn' => FALSE, 'UserID' => '');
		$this->session->unset_userdata($dataunset);
		$this->index();
	}
}
?>
