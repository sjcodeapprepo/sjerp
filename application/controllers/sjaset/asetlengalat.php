<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class Asetlengalat extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "104");
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
		$data['kondisikodesi']				= array(
												array(
													'KondisiKodeSi'	=> 'B',
													'KondisiKodeSiName'	=> 'Baik'
												),
												array(
													'KondisiKodeSi'	=> 'RR',
													'KondisiKodeSiName'	=> 'Rusak Ringan'),
												array(
													'KondisiKodeSi'	=> 'RB',
													'KondisiKodeSiName'	=> 'Rusak Berat')
											);
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

	function _getLastInsertID() 
	{
		$sql	= "SELECT LAST_INSERT_ID() AS lii";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result[0]['lii'];
	}

	function _getLastAsetOrderPlusOne() 
	{
		$sql	= "SELECT LPAD(AssetOrder+1, 3, 0) AS AO FROM itemelkmesindetail ORDER BY AssetOrder DESC";
		$query	= $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]['AO'])?$result[0]['AO']:'001';
		return $retval;
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
		$submit				= $this->input->post('submit');
		$katid				= $this->input->post('katid');
		$jeniselkmesinkatid	= $this->input->post('jeniselkmesinkatid');
		$tglpr				= $this->input->post('tglpr');
		$thnpr				= substr($tglpr, 0, 4);
		$nodokumenpr		= $this->input->post('nodokumenpr');
		$lokasiidpr			= $this->input->post('lokasiidpr');
		$nilaipr			= $this->input->post('nilaipr');
		$penyusutanpr		= $this->input->post('penyusutanpr');
		$divisionidps		= $this->input->post('divisionidps');
		$penanggungjawabps	= $this->input->post('penanggungjawabps');
		$kondisikodesi		= $this->input->post('kondisikodesi');
		$hargasi			= $this->input->post('hargasi');
		$keterangansi		= $this->input->post('keterangansi');
		$urlsegment			= $this->input->post('urlsegment');

		if ($submit == 'SIMPAN') {
			$assetorder	= $this->_getLastAsetOrderPlusOne();
			$assetno	= '04'.$katid.$jeniselkmesinkatid.$assetorder.$thnpr.$lokasiidpr.$divisionidps;

			$config['upload_path']		= FCPATH . 'publicfolder/asetpic/';
			$config['file_name']		= 'aset' . $assetno.rand(5, 16);
			$config['overwrite']		= TRUE;
			$config['allowed_types']	= 'gif|jpg|png|jpeg';
			$config['max_size']			= 5000;
			$config['max_width']		= 1500;
			$config['max_height']		= 1500;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('piclocationsi')) {
				$error					= array('error_info' => $this->upload->display_errors());
				print_array($error);
			} else {
				$data			= $this->upload->data();				
				$filelocation	= $data['full_path'];

				$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI 

				$datamaster	= array(
								'GolID'			=> '04',
								'KatID'			=> $katid,
								'AssetNo'		=> $assetno,
								'TglPr'			=> $tglpr
							);
				$this->db->insert('itemmaster', $datamaster);

				$itemid		= $this->_getLastInsertID();

				$datadetail	= array(
								'ItemID'				=> $itemid,
								'AssetOrder'			=> $assetorder,
								'JenisElkmesinKatID'	=> $jeniselkmesinkatid,
								'NoDokumenPr'			=> $nodokumenpr,
								'NilaiPr'				=> $nilaipr,
								'PenyusutanPr'			=> $penyusutanpr,
								'LokasiIDPr'			=> $lokasiidpr,
								'DivisionIDPs'			=> $divisionidps,
								'PenanggungJawabPs'		=> $penanggungjawabps,
								'KondisiKodeSi'			=> $kondisikodesi,
								'HargaSi'				=> $hargasi,
								'KeteranganSi'			=> $keterangansi,
								'PicLocationSi'			=> $filelocation
							);
				$this->db->insert('itemelkmesindetail', $datadetail);

				$this->db->trans_complete(); //----------------------------------------------------END TRANSAKSI
			}
		}
		redirect('sjaset/asetgelmes', 'refresh');
	}

	function edit($id)
	{
		$this->load->helper('text');
		$datas								= $this->_getData($id);
		$data['data']						= $datas;
		$url	= explode('/',$datas['PicLocationSi'],6);
		$data['imgsrc']						= base_url().$url[5];
		$data['itemjeniselkmesinmaster']	= $this->_getItemjeniselkmesinmasterData();
		$data['itemkatmaster']				= $this->_getItemKatMasterData();
		$data['itemlokasimaster']			= $this->_getItemLokasiMasterData();
		$data['itemdivisionmaster']			= $this->_getItemDivisionMasterData();

		$data['kondisikodesi']				= array(
													array(
														'KondisiKodeSi'	=> 'B',
														'KondisiKodeSiName'	=> 'Baik'
													),
													array(
														'KondisiKodeSi'	=> 'RR',
														'KondisiKodeSiName'	=> 'Rusak Ringan'),
													array(
														'KondisiKodeSi'	=> 'RB',
														'KondisiKodeSiName'	=> 'Rusak Berat')
												);

		$data['urlsegment']	= $this->uri->uri_string();
		$this->load->view('sjasetview/asetgelmesview/asetgelmesmaster_edit', $data);
	}

	function _editproc($itemid)
	{
		$submit				= $this->input->post('submit');

		$katid				= $this->input->post('katid');
		$jeniselkmesinkatid	= $this->input->post('jeniselkmesinkatid');
		$assetorder			= $this->input->post('assetorder');
		$tglpr				= $this->input->post('tglpr');
		$thnpr				= substr($tglpr, 0, 4);
		$nodokumenpr		= $this->input->post('nodokumenpr');
		$lokasiidpr			= $this->input->post('lokasiidpr');
		$nilaipr			= $this->input->post('nilaipr');
		$penyusutanpr		= $this->input->post('penyusutanpr');
		$divisionidps		= $this->input->post('divisionidps');
		$penanggungjawabps	= $this->input->post('penanggungjawabps');
		$kondisikodesi		= $this->input->post('kondisikodesi');
		$hargasi			= $this->input->post('hargasi');
		$keterangansi		= $this->input->post('keterangansi');

		if ($submit == 'SIMPAN') {
			$assetno					= '04'.$katid.$jeniselkmesinkatid.$assetorder.$thnpr.$lokasiidpr.$divisionidps;

			$config['upload_path']		= FCPATH . 'publicfolder/asetpic/';
			$config['file_name']		= 'em' . $assetno.rand(5, 16);
			$config['overwrite']		= TRUE;
			$config['allowed_types']	= 'gif|jpg|png|jpeg';
			$config['max_size']			= 5000;
			$config['max_width']		= 1500;
			$config['max_height']		= 1500;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('piclocationsi')) {
				$error					= array('error_info' => $this->upload->display_errors());
				print_array($error);
			} else {
				$data			= $this->upload->data();
				$filelocation	= $data['full_path'];

				$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI 

				$datamaster	= array(
								'KatID'			=> $katid,
								'AssetNo'		=> $assetno,
								'TglPr'			=> $tglpr
							);
				$this->db->update('itemmaster', $datamaster, array('ItemID'	=> $itemid));

				$datadetail	= array(
								'JenisElkmesinKatID'	=> $jeniselkmesinkatid,
								'NoDokumenPr'			=> $nodokumenpr,
								'NilaiPr'				=> $nilaipr,
								'PenyusutanPr'			=> $penyusutanpr,
								'LokasiIDPr'			=> $lokasiidpr,
								'DivisionIDPs'			=> $divisionidps,
								'PenanggungJawabPs'		=> $penanggungjawabps,
								'KondisiKodeSi'			=> $kondisikodesi,
								'HargaSi'				=> $hargasi,
								'KeteranganSi'			=> $keterangansi,
								'PicLocationSi'			=> $filelocation
							);
				$this->db->update('itemelkmesindetail', $datadetail, array('ItemID'	=> $itemid));

				$this->db->trans_complete(); //----------------------------------------------------END TRANSAKSI
			}
		}
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
		// redirect('sjaset/asetgelmes' . $url, 'refresh');
	}

	function testqrcode()
	{
        $nim='test_pertama_qrcode';
 
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './publicfolder/qrcode/'; //string, the default is application/cache/
        $config['errorlog']     = './publicfolder/qrcode/'; //string, the default is application/logs/
        $config['imagedir']     = './publicfolder/qrcode/images/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name='test_pertama_qrcode.png';
        $params['data'] = $nim; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 4;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder publicfolder/qrcode/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
		echo'ok';
    }

	function barcode()
	{
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');

		$id='ahmadmirza210173';

		$barcodeOptions = array('text' => $id);
		$rendererOptions = array(
								'imageType'          => 'png', 
								'horizontalPosition' => 'center', 
								'verticalPosition'   => 'middle'
							);
			
		// $imageResource=Zend_Barcode::factory('code128', 'image', $barcodeOptions, $rendererOptions)->render();
		// return $imageResource;

		// $imageResource = Zend_Barcode::factory('code128', 'image', $barcodeOptions, $rendererOptions)->draw();
		// imagepng($imageResource, 'publicfolder/qrcode/images/barcode.png');
	}
	
	function viewbarcode() 
	{
		// echo "<img src='".site_url()."/sjaset/asetgelmes/barcode'  alt='not show' /></div>";
		echo "<img src='".base_url()."/publicfolder/qrcode/images/barcode.png'  alt='not show' /></div>";
	}

	function test()
	{
		print_array('asdf');
	}
}
