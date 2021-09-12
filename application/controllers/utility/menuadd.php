<?php
include(APPPATH.'controllers/auth/authcontroller.php');
class MenuAdd extends Authcontroller {
	
	var $isusermodify;
	
    function __construct(){
        parent::__construct();
        define("MENU_ID", "4");
        $userid = $this->session->userdata('UserID');
        $this->redirectNoAuthRead($userid,MENU_ID);
        $this->isusermodify = $this->isUserAuthModify($userid,MENU_ID);	
    }
	
	function index() {		
		$group	= $this->_getGroupMst();
		$submit	= $this->input->post('submit');
		if($submit) {
			$groupmenu	= $this->input->post('grupmenu');
			$parentmenu	= $this->input->post('parentmenu');
			$urlsite	= $this->input->post('urlsite');
			$menuname	= $this->input->post('menuname');
			
			$menumst	= array(
				'MenuName'			=> $menuname, 
				'GroupName'			=> $groupmenu,
				'UrlSiteUrl'		=> $urlsite,
				'ParentGroupName'	=> $parentmenu
				);
			$this->db->insert('menumst', $menumst);
			
			$menuid	= $this->_lastinsertedid();
			
			for ($i = 0; $i < count($group); $i++) {
				$usergroupid	= $group[$i]['UserGroupID'];
				$usergroupdtl	= array('UserGroupID'=> $usergroupid, 'MenuID'	=> $menuid, 'ReadFlg'	=> 0,	'ModifyFlg'	=>0);
				$this->db->insert('usergroupdtlmst', $usergroupdtl);
			}
		}
		$data['menumstarr']	= $this->_getMenuMst();
		$this->load->view('utility/menuadd/menuaddindex',$data);
	}
	
	function _getGroupMst() {
		$sql	= "SELECT UserGroupID FROM usergroupmst";
		$qry = $this->db->query($sql);
		$row = $qry->result_array();
        return $row;
	}
	
	function _lastinsertedid() {
		$sql	= "SELECT LAST_INSERT_ID() AS menuid";
		$qry = $this->db->query($sql);
		$row = $qry->result_array();
        return $row[0]['menuid'];
	}
	
	function _getMenuMst() {
		$sql	= "SELECT MenuID, MenuName, ParentGroupName, GroupName, UrlSiteUrl FROM menumst ORDER BY ParentGroupName, GroupName";
		$qry = $this->db->query($sql);
		$row = $qry->result_array();
        return $row;
	}
}
?>
