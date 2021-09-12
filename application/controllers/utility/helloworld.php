<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class HelloWorld extends Authcontroller
{

    function __construct()
    {
        parent::__construct();
        define("MENU_ID", "5");
        $userid = $this->session->userdata('UserID');
        $this->redirectNoAuthRead($userid, MENU_ID);
    }

    function index()
    {
        $username = $this->session->userdata('UserName');
        $data['username'] = $username;
        $this->load->view('welcome_message.php', $data);
    }

    function underdevelopment()
    {
        $this->load->view('underdelopment_index.php');
    }
}
