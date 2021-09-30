<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetJenisDokTanahMaster extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "111");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid, MENU_ID);
		$this->isusermodify = $this->isUserAuthModify($userid, MENU_ID);
	}

	function index()
	{
		$submit	= $this->input->post('submit');
		if ($submit == 'TAMBAH') {
            $jenisdokumentanahname	= $this->input->post('JenisDokumenTanahName');
			$id		    = $this->input->post('JenisDokumenTanahID');

			$datamaster	= array(
							'JenisDokumenTanahID'	 => $id,
                            'JenisDokumenTanahName'	=> $jenisdokumentanahname
						);
			$this->db->insert('itemjenisdokumentanahmaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$this->load->view('sjasetview/asettanahview/jenisdoktanah_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  JenisDokumenTanahID, JenisDokumenTanahName FROM  itemjenisdokumentanahmaster ORDER BY JenisDokumenTanahID DESC";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
