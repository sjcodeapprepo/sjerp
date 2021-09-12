<?php
include(APPPATH.'/controllers/auth/authcontroller'.EXT);
/**
* @property Groupmodel $groupmodel
*/
class Group extends Authcontroller {
    var $isusermodify;
	function __construct(){
        parent::__construct();
        define("MENU_ID", "2");		
		$userid		= $this->session->userdata('UserID');
        $this->isusermodify = $this->isUserAuthModify($userid,MENU_ID);
        $this->redirectNoAuthRead($userid,MENU_ID);
		$this->load->model('utility/groupmodel');
	}

	function index()
	{
	 	$data['menumst'] = $this->groupmodel->view_menumst();
	 	$data['usergroupmst'] = $this->groupmodel->view_usergroupmst();
	 	$data['modifyflag'] = $this->isusermodify; // kirim modify flag ke view
		$this->load->view('utility/usergroup/group_form', $data);
	}

	function insert()
	{
	 	 $kirim = $this->input->post('kirim');

          if ($kirim==1) {
           	 $total = $this->input->post('total');
             $UserGroupID = $this->input->post('UserGroupID');
             $MenuID = $this->input->post('MenuID');
           	 $ReadFlg = $this->input->post('ReadFlg');
		 	 $ModifyFlg = $this->input->post('ModifyFlg');

			 $data1 = array(
					'UserGroupID' => $UserGroupID,
					'UserGroupName' => $this->input->post('UserGroupName'),
			 );
			 $this->groupmodel->insert1($data1);

			 $sql="INSERT INTO usergroupdtlmst (UserGroupID, MenuID, ReadFlg, ModifyFlg) Select '$UserGroupID', MenuID, '0', '0' From menumst";
			 $query = $this->db->query($sql);

             $strUbah = "";
			 for ($i=0; $i<count($ModifyFlg); $i++){
	            $strUbah = $strUbah . "'" . $ModifyFlg[$i] . "',";
             }
             $ModifyFlg = substr($strUbah, 1, strlen($strUbah)-3);
			 $sql2="Update usergroupdtlmst set ModifyFlg=1 where UserGroupID = '$UserGroupID' and MenuId in('$ModifyFlg')";
			 $query = $this->db->query($sql2);
		     $strBaca = "";
             for ($i=0;$i<count($ReadFlg);$i++){
                 $strBaca = $strBaca . "'" . $ReadFlg[$i] . "',";
		     }
		     $ReadFlg = substr($strBaca, 1, strlen($strBaca)-3);
		     $sql3="Update usergroupdtlmst set ReadFlg=1 where UserGroupID = '$UserGroupID' and MenuId in('$ReadFlg')";
		   	 $this->db->query($sql3);

			 echo "<script>location.href='../group'</script>";
		}
	}

	function edit(){
	 	$kirim = $this->input->post('kirim');
	 	$UserGroupID = $this->uri->segment(4);

		if (isset($_POST['kirim'])) {
		  $total = $this->input->post('total');
          $UserGroupID = $this->input->post('UserGroupID');
          $UserGroupName = $this->input->post('UserGroupName');
          $MenuID = $this->input->post('MenuID');
          $ReadFlg = $this->input->post('ReadFlg');
		  $ModifyFlg = $this->input->post('ModifyFlg');

		  $sql = "Update usergroupmst set UserGroupName = '$UserGroupName' where UserGroupID = '$UserGroupID'";
		  $query = $this->db->query($sql);
		  //echo $sql."<br>";

		  $sql1 = "Update usergroupdtlmst set ReadFlg=0, ModifyFlg=0 where UserGroupID = '$UserGroupID'";
		  $query = $this->db->query($sql1);
		  //echo $sql1."<br>";

          $strUbah = "";
		  for ($i=0; $i<count($ModifyFlg); $i++){
	          $strUbah = $strUbah . "'" . $ModifyFlg[$i] . "',";
          }
          $ModifyFlg = substr($strUbah, 1, strlen($strUbah)-3);
		  $sql2="Update usergroupdtlmst set ModifyFlg=1 where UserGroupID = '$UserGroupID' and MenuId in('$ModifyFlg')";
		  $query = $this->db->query($sql2);
		  //echo $sql2."<br>";

		  $strBaca = "";
          for ($i=0;$i<count($ReadFlg);$i++){
              $strBaca = $strBaca . "'" . $ReadFlg[$i] . "',";
		  }
		  $ReadFlg = substr($strBaca, 1, strlen($strBaca)-3);
		  $sql3="Update usergroupdtlmst set ReadFlg=1 where UserGroupID = '$UserGroupID' and MenuId in('$ReadFlg')";
		  $this->db->query($sql3);
		  //echo $sql3."<br>";

		  echo "<script>location.href='../group'</script>";
		}

	 	$data['menumst'] = $this->groupmodel->view_usergroupdtlmst_edit($UserGroupID);
	 	$data['view_usergroupmst_edit'] = $this->groupmodel->view_usergroupmst_edit($UserGroupID);
	 	$data['view_usergroupdtlmst_edit'] = $this->groupmodel->view_usergroupdtlmst_edit($UserGroupID);
	 	$data['modifyflag'] = $this->isusermodify; // kirim modify flag ke view
		$this->load->view('utility/usergroup/edit_group', $data);
	}
}
?>