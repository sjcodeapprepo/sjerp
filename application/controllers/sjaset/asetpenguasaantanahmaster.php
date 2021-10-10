<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetPenguasaanTanahMaster extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "113");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid, MENU_ID);
		$this->isusermodify = $this->isUserAuthModify($userid, MENU_ID);
	}

    function _index() 
    {
        echo "asdfasdf";
    }

	function index()
	{
		$submit	= $this->input->post('submit');
		if ($submit == 'TAMBAH') {
            $statusname	= $this->input->post('StatusName');
			$id		    = $this->input->post('StatusID');

			$datamaster	= array(
							'StatusID'	 => $id,
                            'StatusName'	=> $statusname
						);
			$this->db->insert('itemstatuspenguasaanmaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$this->load->view('sjasetview/asettanahview/penguasaantanah_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  StatusID, StatusName FROM  itemstatuspenguasaanmaster ORDER BY StatusID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
