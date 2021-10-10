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
			$katid		    = $this->input->post('katid');

			$datamaster	= array(
							'JenisGdgBangunanID'	 => $id,
                            'JenisGdgBangunanName'	=> $jenisgdbangname,
							'KatID'	=> $katid
						);
			$this->db->insert('itemjenisbangunanmaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$data['itemkatmaster']	= $this->_getItemKatMasterData();
		$this->load->view('sjasetview/asetgdbangview/jenisgdbang_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  j.JenisGdgBangunanID, j.JenisGdgBangunanName, k.KatName
		FROM  itemjenisbangunanmaster j, itemkatmaster k
		WHERE k.KatID=j.KatID AND k.GolID='02'
		ORDER BY k.KatName,j.JenisGdgBangunanID";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function _getItemKatMasterData()
	{
		$sql = "SELECT KatID, KatName FROM itemkatmaster WHERE GolID='02' ORDER BY KatName";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
