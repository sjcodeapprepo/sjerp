<?php
include(APPPATH.'/controllers/auth/authcontroller'.EXT);
class TestPurpose extends Authcontroller { //testpurpose

	function __construct() {
		parent::__construct();
    }

	function index(){
		$this->load->view('_test/testone');		
	}
		
	function getData($paramsatu) {
		$sql = "SELECT "
			. "e.EmpID AS id, e.EmpName AS data, e.KTPNo AS description "
			. "FROM empmst e WHERE e.EmpName LIKE '%$paramsatu%'";
		$qry = $this->db->query($sql);
		$row = $qry->result_array();
		echo json_encode($row);
    }
}
?>
