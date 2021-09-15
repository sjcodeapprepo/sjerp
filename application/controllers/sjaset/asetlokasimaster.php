<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetLokasimaster extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "109");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid, MENU_ID);
		$this->isusermodify = $this->isUserAuthModify($userid, MENU_ID);
	}

	function index()
	{
		$submit	= $this->input->post('submit');
		if ($submit == 'TAMBAH') {
			$lokasi	= $this->input->post('lokasiname');
			$id		= $this->input->post('lokasiid');

			$datamaster	= array(
							'LokasiID'	    => $id,
							'LokasiName'	=> $lokasi
						);
			$this->db->insert('itemlokasimaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$this->load->view('sjasetview/asetgelmesmasterview/lokasi_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  LokasiID, LokasiName FROM  itemlokasimaster ORDER BY LokasiID DESC";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
