<?php	
	function menulist() {		
		$CI =& get_instance();
		$CI->load->model('auth/menumodel');		
		$userid				= $CI->session->userdata('UserID');
		$menu_arr			= $CI->menumodel->getUserGroupDataMenu($userid);
		$data['menuarr']	= $menu_arr;
		$CI->load->view('menu',$data);
	}
?>
