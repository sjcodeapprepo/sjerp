<?php
class Menumodel extends CI_Model {
	
    function __construct(){
        parent::__construct();
    }
	
    function getAktifUserID($username){
        $sql = "SELECT UserID FROM usermst WHERE UserName='$username' AND ActiveFlg=1";
        $query = $this->db->query($sql);
        $result = $query->result_array();
		return $result[0]['UserID'];
    }
	
	function getUserGroupDataMenu($userid){
		$retval	= array();
        $sql	= "SELECT m.MenuID, m.MenuName, m.GroupName, m.ParentGroupName, m.UrlSiteUrl "
				. "FROM menumst m, usergroupdtlmst ug, usermst u "
				. "WHERE ug.MenuID=m.MenuID AND u.UserGroupID=ug.UserGroupID "
				.	"AND ug.ReadFlg='1' AND u.ActiveFlg='1' AND u.UserID='$userid' AND m.ParentGroupName != '' AND m.IsActive=1
				ORDER BY m.SortNo, m.ParentGroupName, m.GroupName, m.MenuName";
        $query	= $this->db->query($sql);
        $result = $query->result_array();
		foreach ($result as $value) {
			$groupparent	= $value['ParentGroupName'];
			$groupname		= $value['GroupName'];
			$menuname		= $value['MenuName'];
			$menuid			= $value['MenuID'];
			$urlsiteurl		= $value['UrlSiteUrl'];
			
			$retval[$groupparent][$groupname]['menuid'][]	= $menuid;
			$retval[$groupparent][$groupname]['menuname'][]	= $menuname;
			$retval[$groupparent][$groupname]['url'][]		= $urlsiteurl;
		}
		return $retval;
    }
}
?>
