<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetGElMes extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "102");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid, MENU_ID);
		$this->isusermodify = $this->isUserAuthModify($userid, MENU_ID);
	}

	function _index()
	{
		echo 'test';
	}

	function index()
	{
		$this->load->library('pagination');
		$this->load->helper('text');
		$urisegment	= 6;
		$keyword	= $this->uri->segment($urisegment - 2);
		$keywordurl = $keyword;
		$keywordurl2 = $this->uri->segment($urisegment - 1);

		if (($keyword == '') || ($keyword == 'nokeyword')) {
			$keyword	= '';
			$keywordurl = 'nokeyword';
			$keywordurl2 = 'nokeyword';
		}
		if ($this->input->post('submit') == 'Cari') {
			$keyword    = $this->input->post('optionValue');
			$keywordurl2 = $this->input->post('option');
			if ($keyword == '') {
				$keywordurl = 'nokeyword';
				$keywordurl2 = 'nokeyword';
			} else {
				$keywordurl = $keyword;
			}
		}
		$dataperpage				= 11;
		$config['per_page']         = $dataperpage;
		$config['base_url']         = site_url() . "/sjaset/asetgelmes/index/$keywordurl/$keywordurl2/";
		$config['uri_segment']      = $urisegment;
		$config['total_rows']       = $this->_view_data(false, 0, 0, $keyword, $keywordurl2);

		$this->pagination->initialize($config);
		$fromurisegment				= $this->uri->segment($urisegment);
		$data['view_data']			= $this->_view_data(true, $dataperpage, $fromurisegment, $keyword, $keywordurl2);
		$this->load->view('sjasetview/asetgelmesview/asetgelmesmaster_index', $data);
	}

	function _view_data($isviewdata, $num, $offset, $key, $category)
	{
		if ($offset != '')
			$offset = $offset . ',';

		$sql = "SELECT 
					m.ItemID, m.AssetNo, mk.KatName, mj.JenisElkmesinKatName, md.DivisionAbbr, d.PenanggungJawabPs
				FROM 
					itemmaster m, itemelkmesindetail d, itemkatmaster mk, itemdivisionmaster md, itemjeniselkmesinmaster mj 
				WHERE 
					m.ItemID=d.ItemID AND d.JenisElkmesinKatID=mj.JenisElkmesinKatID AND d.DivisionIDPs=md.DivisionID
					AND m.GolID=mk.GolID AND m.KatID=mk.KatID AND m.GolID='04'";
		if ($key !== '')
			$sql .= " AND $category LIKE '%$key%'";
		if($isviewdata) {
			$sql .= " ORDER BY m.ItemID DESC, m.AssetNo DESC LIMIT $offset $num";
		}
		//---------------------------------------------------
		$query = $this->db->query($sql);

		if($isviewdata) {
			$result = $query->result_array();
		} else {
			$result = $query->num_rows();
		}
		
		return $result;
	}

	function input()
	{
		$this->load->helper('text');
		$id									= null;
		$data['data']						= $this->_getData($id);
		$data['itemjeniselkmesinmaster']	= $this->_getItemjeniselkmesinmasterData();
		$data['itemkatmaster']				= $this->_getItemKatMasterData();
		$data['itemlokasimaster']			= $this->_getItemLokasiMasterData();
		$data['itemdivisionmaster']			= $this->_getItemDivisionMasterData();
		$data['urlsegment']	= $this->uri->uri_string();
		$this->load->view('sjasetview/asetgelmesview/asetgelmesmaster_input', $data);
	}

	function _getData($id)
	{
		$datakosong	= array(
			'ItemID'				=> null,
			'KatID'					=> '',
			'AssetNo'				=> '',
			'TglPr'					=> '',
			'AssetOrder'			=> '',
			'JenisElkmesinKatID'	=> '',
			'NoDokumenPr'			=> '',
			'NilaiPr'				=> '',
			'PenyusutanPr'			=> '',
			'LokasiIDPr'			=> '',
			'DivisionIDPs'			=> '',
			'PenanggungJawabPs'		=> '',
			'KondisiKodeSi'			=> '',
			'HargaSi'				=> '',
			'KeteranganSi'			=> '',
			'PicLocationSi'			=> ''
		);

		$sql = "SELECT 
					m.ItemID, m.KatID, m.AssetNo, m.TglPr, d.AssetOrder, d.JenisElkmesinKatID, 
					d.NoDokumenPr, d.NilaiPr, d.PenyusutanPr, d.LokasiIDPr, d.DivisionIDPs, d.PenanggungJawabPs, 
					d.KondisiKodeSi, d.HargaSi, d.KeteranganSi, d.PicLocationSi
				FROM 
					itemmaster m, itemelkmesindetail d
				WHERE 
					m.ItemID=d.ItemID AND m.ItemID='$id' AND m.GolID='04'";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]) ? $result[0] : $datakosong;

		return $retval;
	}

	function _getItemjeniselkmesinmasterData()
	{
		$sql = "SELECT JenisElkmesinKatID, JenisElkmesinKatName FROM itemjeniselkmesinmaster";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function _getItemKatMasterData()
	{
		$sql = "SELECT KatID, KatName FROM itemkatmaster WHERE GolID='04'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function _getItemLokasiMasterData()
	{
		$sql = "SELECT LokasiID, LokasiName FROM itemlokasimaster";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}	//

	function _getItemDivisionMasterData()
	{
		$sql = "SELECT DivisionID, DivisionAbbr FROM itemdivisionmaster";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function inputeditproc($id = null)
	{
		if (is_null($id)) {
			$this->_inputproc();
		} else {
			$this->_editproc($id);
		}
	}

	function _inputproc()
	{
		$submit		= $this->input->post('submit');
		$nik		= $this->input->post('nik');
		$nama		= $this->input->post('nama');
		$jk			= $this->input->post('jk');
		$tgllahir	= $this->input->post('tgllahir');
		$isactive	= $this->input->post('isactive');

		if ($submit == 'SIMPAN') {
			$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI

			$data	= array(
				'NIK'		=> $nik,
				'Nama'		=> $nama,
				'JK'		=> $jk,
				'TglLahir'	=> $tgllahir,
				'IsActive'	=> $isactive
			);
			$this->db->insert('karyawanmst', $data);

			$this->db->trans_complete(); //----------------------------------------------------END TRANSAKSI
		}
		redirect('hr/karyawanmaster', 'refresh');
	}

	function edit($id)
	{
		$this->load->helper('text');
		$data['data']		= $this->_getData($id);
		$data['urlsegment']	= $this->uri->uri_string();
		$this->load->view('hr/karyawan/karyawanmaster_input', $data);
	}

	function _editproc($id)
	{
		$submit		= $this->input->post('submit');
		$nik		= $this->input->post('nik');
		$nama		= $this->input->post('nama');
		$jk			= $this->input->post('jk');
		$tgllahir	= $this->input->post('tgllahir');
		$isactive	= $this->input->post('isactive');

		if ($submit == 'SIMPAN') {
			$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI

			$data	= array(
				'NIK'		=> $nik,
				'Nama'		=> $nama,
				'JK'		=> $jk,
				'TglLahir'	=> $tgllahir,
				'IsActive'	=> $isactive
			);
			$this->db->update('karyawanmst', $data, array('ID'	=> $id));
			$this->db->trans_complete(); //----------------------------------------------------END TRANSAKSI
		}
		redirect('hr/karyawanmaster', 'refresh');


		// back to page asal	
		$urlstring	= $this->input->post('urlsegment');
		$urlarr = explode("/", $urlstring);
		$url	= '';
		$i	= 0;
		foreach ($urlarr as $uri) {
			if ($i > 5)
				$url	.= '/' . $uri;
			$i++;
		}
		redirect('jt/kontrak' . $url, 'refresh');
	}

	function test()
	{
		print_array('asdf');
	}
}
