<?php
include(APPPATH.'/controllers/auth/authcontroller'.EXT);
class GenAsetNo extends Authcontroller { //testpurpose

	function __construct() {
		parent::__construct();
    }

	function index(){
		$this->load->view('_test/testone');		
	}
		
	function goex() {
        
        $dataGdBang         = $this->_getDataGdBang();
        $dataPerlengLat     = $this->_getDataPerlengLat();
        $dataElmes          = $this->_getDataElmes();
        //DebugTest

        //-- Tanah
        $dataTanah          = $this->_getDataTanah();
        foreach ($dataTanah as $tanah) 
        {
            $itemid     = $tanah[''];
            $katid      = $tanah[''];
            $thnpr      = $tanah[''];

            // $assetorder	= $this->_getLastAsetOrderPlusOneV2($katid, $jenisid);
            $assetorder	= $this->_getLastAsetOrderPlusOneV3($katid, $thnpr);
			$assetno	= '01'.$katid.$thnpr.$assetorder;

            $this->db->update('itemmaster', array('AssetNo'=> $assetno), array('ItemID'	=> $itemid));
            $this->db->update('itemtanahdetail', array('AssetOrder'=> $assetorder), array('ItemID'	=> $itemid));
        }
    }
}
?>