<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetPeruntukanTanahMaster extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "114");
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
            $peruntukanname	= $this->input->post('PeruntukanName');
			$id		    = $this->input->post('PeruntukanID');

			$datamaster	= array(
							'PeruntukanID'	 => $id,
                            'PeruntukanName'	=> $peruntukanname
						);
			$this->db->insert('itemperuntukanmaster', $datamaster);
		}
		$data['view_data']	= $this->_getData();
		$this->load->view('sjasetview/asettanahview/peruntukantanah_index', $data);
	}

	function _getData() 
	{
		$sql = "SELECT  PeruntukanID, PeruntukanName FROM  itemperuntukanmaster ORDER BY PeruntukanID DESC";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function test()
	{
		print_array('asdf');
	}
}
