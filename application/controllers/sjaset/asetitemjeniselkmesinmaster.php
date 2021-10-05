<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetItemJeniselkmesinmaster extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "107");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid, MENU_ID);
		$this->isusermodify = $this->isUserAuthModify($userid, MENU_ID);
	}

	function index()
	{
		$submit	= $this->input->post('submit');
		if ($submit == 'TAMBAH') {
			$jenis	= $this->input->post('jeniselkmesinkatname');
			$id		= $this->input->post('jeniselkmesinkatid');
			$katid		    = $this->input->post('katid');

			$datamaster	= array(
							'JenisElkmesinKatID'	=> $id,
							'JenisElkmesinKatName'	=> $jenis,
							'KatID'	=> $katid
						);
			$this->db->insert('itemjeniselkmesinmaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$data['itemkatmaster']	= $this->_getItemKatMasterData();
		$this->load->view('sjasetview/asetgelmesmasterview/itemjeniselk_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  j.JenisElkmesinKatID, j.JenisElkmesinKatName, k.KatName
		FROM  itemjeniselkmesinmaster j, itemkatmaster k
		WHERE k.KatID=j.KatID AND k.GolID='04'
		ORDER BY j.JenisElkmesinKatID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function _getItemKatMasterData()
	{
		$sql = "SELECT KatID, KatName FROM itemkatmaster WHERE GolID='04' ORDER BY KatName";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
