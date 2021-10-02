<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetJenisKendMaster extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "120");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid, MENU_ID);
		$this->isusermodify = $this->isUserAuthModify($userid, MENU_ID);
	}

	function index()
	{
		$submit	= $this->input->post('submit');
		if ($submit == 'TAMBAH') {
            $id		    = $this->input->post('JenisKendaraanKatID');
            $jeniskendname	= $this->input->post('JenisKendaraanKatName');			

			$datamaster	= array(
							'JenisKendaraanKatID'	 => $id,
                            'JenisKendaraanKatName'	=> $jeniskendname
						);
			$this->db->insert('itemjeniskendaraankatmaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$this->load->view('sjasetview/asetkendaraanview/jeniskend_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  JenisKendaraanKatID, JenisKendaraanKatName FROM  itemjeniskendaraankatmaster ORDER BY JenisKendaraanKatID DESC";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
