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
			$katid		    = $this->input->post('katid');			

			$datamaster	= array(
							'JenisKendaraanKatID'	 => $id,
                            'JenisKendaraanKatName'	=> $jeniskendname,
							'KatID'	=> $katid
						);
			$this->db->insert('itemjeniskendaraankatmaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$data['itemkatmaster']	= $this->_getItemKatMasterData();
		$this->load->view('sjasetview/asetkendaraanview/jeniskend_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  j.JenisKendaraanKatID, j.JenisKendaraanKatName, k.KatName
		FROM  itemjeniskendaraankatmaster j, itemkatmaster k
		WHERE k.KatID=j.KatID AND k.GolID='05'
		ORDER BY k.KatName, j.JenisKendaraanKatID";

		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function _getItemKatMasterData()
	{
		$sql = "SELECT KatID, KatName FROM itemkatmaster WHERE GolID='05' ORDER BY KatName";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
