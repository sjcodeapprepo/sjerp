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

			$datamaster	= array(
							'JenisElkmesinKatID'	=> $id,
							'JenisElkmesinKatName'	=> $jenis
						);
			$this->db->insert('itemjeniselkmesinmaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$this->load->view('sjasetview/asetgelmesmasterview/itemjeniselk_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  JenisElkmesinKatID, JenisElkmesinKatName FROM  itemjeniselkmesinmaster ORDER BY JenisElkmesinKatID DESC";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
