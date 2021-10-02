<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetJenisLengLatMaster extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "118");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid, MENU_ID);
		$this->isusermodify = $this->isUserAuthModify($userid, MENU_ID);
	}

	function index()
	{
		$submit	= $this->input->post('submit');
		if ($submit == 'TAMBAH') {
            $id		    = $this->input->post('JenisPerlengPeralatKatID');
            $jenislenglatname	= $this->input->post('JenisPerlengPeralatKatName');			

			$datamaster	= array(
							'JenisPerlengPeralatKatID'	 => $id,
                            'JenisPerlengPeralatKatName'	=> $jenislenglatname
						);
			$this->db->insert('itemjenisperlengperalatkatmaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$this->load->view('sjasetview/asetlengalatview/jenislenglat_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  JenisPerlengPeralatKatID, JenisPerlengPeralatKatName FROM  itemjenisperlengperalatkatmaster ORDER BY JenisPerlengPeralatKatID DESC";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
