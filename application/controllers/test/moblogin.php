<?php
include(APPPATH.'/controllers/auth/authcontroller'.EXT);
class MobLogin extends Authcontroller { //testpurpose

	function __construct() 
    {
		parent::__construct();
    }

	function index() 
    {
		$this->load->view('_test/loginsecond');		
	}

    function menu() 
    {
		$this->load->view('_test/menusa');		
	}
	
}
?>