<?php
class Groupmodel extends CI_Model {
	
    function __construct(){
        parent::__construct();
    }

	function insert1($data1)
	{
		if($this->db->insert('usergroupmst', $data1)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function view_menumst()
	{
        $sql = 'SELECT * FROM menumst order by GroupName, MenuName ASC';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
	}

	function view_usergroupmst()
	{
        $sql = 'SELECT * FROM usergroupmst order by UserGroupID ASC';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
	}

	function view_usergroupmst_edit($UserGroupID)
	{
        $sql = "SELECT * FROM usergroupmst where UserGroupID='$UserGroupID'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
	}

	function view_usergroupdtlmst_edit($UserGroupID)
	{
        $sql = "SELECT u.UserGroupID, u.MenuID, u.ReadFlg, u.ModifyFlg, m.MenuName, m.GroupName
                FROM usergroupdtlmst AS u, menumst AS m WHERE u.MenuID=m.MenuID AND u.UserGroupID='$UserGroupID'
				order by m.GroupName, m.MenuName ASC";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
	}

	function edit($data, $AreaID){
		$this->db->where('AreaID', $AreaID);
		$this->db->update('areamst', $data);
	}
}
?>
