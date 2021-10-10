<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetKategoriGdBangMaster extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "115");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid, MENU_ID);
		$this->isusermodify = $this->isUserAuthModify($userid, MENU_ID);
	}

	function index()
	{
		$submit	= $this->input->post('submit');
		if ($submit == 'TAMBAH') {
			$kategori	= $this->input->post('katname');
			$id		    = $this->input->post('katid');

			$datamaster	= array(
                            'GolID'     => '02',
							'KatID'	    => $id,
							'KatName'	=> $kategori
						);
			$this->db->insert('itemkatmaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$this->load->view('sjasetview/asetgdbangview/kategorigdbang_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  KatID, KatName FROM  itemkatmaster WHERE GolID='02' ORDER BY KatID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
