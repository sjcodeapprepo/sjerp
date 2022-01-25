<?php
include(APPPATH.'/controllers/auth/authcontroller'.EXT);
class StatusData extends Authcontroller {

	function __construct() 
	{
		parent::__construct();
		define("MENU_ID", "123");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid,MENU_ID);
	}

	function index() 
	{
        $data['astdata']   = $this->_getData();
		$this->load->view('sjasetview/asetreport/statusdata_index', $data);
        // echo 'ok';
	}
	
    function _getData()
    {
        $tanah      = $this->_getTanah();
        $gdbang     = $this->_getGedungBang();
        $lenglat    = $this->_getLengLat();
        $elmes      = $this->_getElMes();
        $kendaraan  = $this->_getKendaraan();
        $total      = $tanah + $gdbang + $lenglat + $elmes + $kendaraan;

        $data       = array(
                        'Tanah'     => $tanah,
                        'Gdbang'    => $gdbang,
                        'Lenglat'   => $lenglat,
                        'Elmes'     => $elmes,
                        'Kendaraan' => $kendaraan,
                        'Total'     => $total 
                    );
        return  $data;
    }

    function _getTanah() 
    {
        $sql = "SELECT COUNT(i.ItemID) AS Tot
                FROM itemmaster i, itemtanahdetail d
                WHERE i.ItemID=d.ItemID AND i.GolID='01'
                GROUP BY i.GolID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]['Tot']) ? $result[0]['Tot'] : 0;

		return $retval;
    }

    function _getGedungBang() 
    {
        $sql = "SELECT COUNT(i.ItemID) AS Tot
                FROM itemmaster i, itemgdgbangdetail d
                WHERE i.ItemID=d.ItemID AND i.GolID='02'
                GROUP BY i.GolID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]['Tot']) ? $result[0]['Tot'] : 0;

		return $retval;
    }

    function _getLengLat() 
    {
        $sql = "SELECT COUNT(i.ItemID) AS Tot
                FROM itemmaster i, itemperlengperalatdetail d
                WHERE i.ItemID=d.ItemID AND i.GolID='03'
                GROUP BY i.GolID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]['Tot']) ? $result[0]['Tot'] : 0;

		return $retval;
    }

    function _getElMes() 
    {
        $sql = "SELECT COUNT(i.ItemID) AS Tot
                FROM itemmaster i, itemelkmesindetail d
                WHERE i.ItemID=d.ItemID AND i.GolID='04'
                GROUP BY i.GolID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]['Tot']) ? $result[0]['Tot'] : 0;

		return $retval;
    }

    function _getKendaraan() 
    {
        $sql = "SELECT COUNT(i.ItemID) AS Tot
                FROM itemmaster i, itemkendaraandetail d
                WHERE i.ItemID=d.ItemID AND i.GolID='05'
                GROUP BY i.GolID";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]['Tot']) ? $result[0]['Tot'] : 0;

		return $retval;
    }
}
