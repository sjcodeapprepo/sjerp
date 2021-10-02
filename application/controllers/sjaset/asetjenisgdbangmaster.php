<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetJenisGdbangMaster extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "116");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid, MENU_ID);
		$this->isusermodify = $this->isUserAuthModify($userid, MENU_ID);
	}

	function index()
	{
		$submit	= $this->input->post('submit');
		if ($submit == 'TAMBAH') {
            $jenisgdbangname	= $this->input->post('JenisGdgBangunanName');
			$id		    = $this->input->post('JenisGdgBangunanID');

			$datamaster	= array(
							'JenisGdgBangunanID'	 => $id,
                            'JenisGdgBangunanName'	=> $jenisgdbangname
						);
			$this->db->insert('itemjenisbangunanmaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$this->load->view('sjasetview/asetgdbangview/jenisgdbang_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  JenisGdgBangunanID, JenisGdgBangunanName FROM  itemjenisbangunanmaster ORDER BY JenisGdgBangunanID DESC";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
