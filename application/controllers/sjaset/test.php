<?php
Class Test extends CI_Controller {
	
		
    function __construct() 
    {
        parent::__construct();
    }

	function index()
	{
        echo $this->getfolder().'publicfolder/asetpic/kendr/';
	}

    function getfolder() 
    {
        $str = FCPATH;
        $base_arr   = explode('/', $str, -2);
        $folderimg  = '';
        for($i=0;$i<count($base_arr);$i++){            
            $folderimg  .= $base_arr[$i];
            $folderimg  .= '/';
        }
        $folderimg  .= 'sensusapi/';
        return $folderimg;
    }
    
    $this->getfolder()

}
