<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetJenPerolGdbangMaster extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "121");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid, MENU_ID);
		$this->isusermodify = $this->isUserAuthModify($userid, MENU_ID);
	}

	function index()
	{
		$submit	= $this->input->post('submit');
		if ($submit == 'TAMBAH') {
            $id		    = $this->input->post('JenisPerolehanID');
            $jenisperolname	= $this->input->post('JenisPerolehanName');			

			$datamaster	= array(
							'JenisPerolehanID'	 => $id,
                            'JenisPerolehanName'	=> $jenisperolname
						);
			$this->db->insert('itemjenisperolehanmaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$this->load->view('sjasetview/asetgdbangview/jenisperol_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  JenisPerolehanID, JenisPerolehanName FROM  itemjenisperolehanmaster ORDER BY JenisPerolehanID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
