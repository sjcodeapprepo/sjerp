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
			$katid		    = $this->input->post('katid');	

			$datamaster	= array(
							'JenisPerlengPeralatKatID'	 => $id,
                            'JenisPerlengPeralatKatName'	=> $jenislenglatname,
							'KatID'	=> $katid
						);
			$this->db->insert('itemjenisperlengperalatkatmaster', $datamaster);
		}
		$data['view_data']		= $this->_getData();
		$data['itemkatmaster']	= $this->_getItemKatMasterData();
		$this->load->view('sjasetview/asetlengalatview/jenislenglat_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  j.JenisPerlengPeralatKatID, j.JenisPerlengPeralatKatName, k.KatName
		FROM  itemjenisperlengperalatkatmaster j, itemkatmaster k
		WHERE k.KatID=j.KatID AND k.GolID='03'
		ORDER BY j.JenisPerlengPeralatKatID DESC";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function _getItemKatMasterData()
	{
		$sql = "SELECT KatID, KatName FROM itemkatmaster WHERE GolID='03' ORDER BY KatName";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
