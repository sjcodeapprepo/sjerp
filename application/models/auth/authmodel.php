<?php
class Authmodel extends CI_Model {
	
    function __construct(){
        parent::__construct();
    }

	function getValidUser($username,$password){
		$retval	= array();
		$mdpassword=md5($password);
		$sql	= "SELECT UserName, UserID, UserGroupID FROM usermst WHERE UserName=? AND UserPwd=? AND ActiveFlg=?";
		$query	= $this->db->query($sql,array($username, $mdpassword,1));
		$result	= $query->result_array();
		if($query->num_rows()>0) {
			$retval	= array(
							array(
								'UserName'		=> $result[0]['UserName'],
								'UserID'		=> $result[0]['UserID'],
								'UserGroupID'	=> $result[0]['UserGroupID'],
								'SjSession'     => TRUE,
								'LogedIn'		=> TRUE
							)
						);
		}
		return $retval;
	}
	
    function getAuthModify($userid,$menuid){
        $sql = "SELECT ug.UserGroupID, ug.MenuID, u.UserName
                FROM usergroupdtlmst AS ug, usermst AS u
                WHERE ug.MenuID = '$menuid'
                AND u.UserID = '$userid'
                AND u.UserGroupID = ug.UserGroupID
                AND ug.ModifyFlg = 1";
        $query = $this->db->query($sql);
        if ( $query->num_rows()>0)
            return TRUE;
        else 
            return FALSE;
    }
	
    function getAuthRead($userid,$menuid){
        $sql = "SELECT ug.UserGroupID, ug.MenuID, u.UserName
                FROM usergroupdtlmst AS ug, usermst AS u
                WHERE ug.MenuID = '$menuid'
                AND u.UserID = '$userid'
                AND u.UserGroupID = ug.UserGroupID
                AND ug.ReadFlg = 1";
        $query = $this->db->query($sql);
        if ($query->num_rows()>0){
            return TRUE;
        }    
        else{
            return FALSE;
        }
    }
		
    function getAktifUserID($username){
        $sql = "SELECT UserID FROM usermst WHERE UserName='$username' AND ActiveFlg=1";
        $query = $this->db->query($sql);
        $result = $query->result_array();
		return $result[0]['UserID'];
    }   
    
    function isUserAktifById($userid){
        $sql = "SELECT UserID FROM usermst WHERE UserID='$userid' AND ActiveFlg=1";
         $query = $this->db->query($sql);
        if ( $query->num_rows()>0)
            return TRUE;
        else 
            return FALSE;   	
    }
	
	function _isPwdExpired($lastpwddate) {	
		$this->load->helper('date');
		$retval		= 0;
		$today		= date("Y-m-d");
		$lastdate	= date("Y-m-d", strtotime($lastpwddate));
		$jumlhari	= __dayDiff($lastdate,$today);
		if($jumlhari > 30) {
			$retval	= 1;
		}
		return $retval;
		
	}
}
