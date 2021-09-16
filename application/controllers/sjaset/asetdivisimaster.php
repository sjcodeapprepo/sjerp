<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetDivisimaster extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "110");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid, MENU_ID);
		$this->isusermodify = $this->isUserAuthModify($userid, MENU_ID);
	}

	function index()
	{
		$submit	= $this->input->post('submit');
		if ($submit == 'TAMBAH') {
			$divabbr	= $this->input->post('DivisionAbbr');
            $divname	= $this->input->post('DivisionName');
			$id		    = $this->input->post('DivisionID');

			$datamaster	= array(
							'DivisionID'	 => $id,
                            'DivisionAbbr'	=> $divabbr,
							'DivisionName'	=> $divname
						);
			$this->db->insert('itemdivisionmaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$this->load->view('sjasetview/asetgelmesmasterview/divisi_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  DivisionID, DivisionName, DivisionAbbr FROM  itemdivisionmaster ORDER BY DivisionID DESC";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
