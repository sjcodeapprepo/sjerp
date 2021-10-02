<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetGdBang extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "105");
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
		$config['base_url']         = site_url() . "/sjaset/asetgdbang/index/$keywordurl/$keywordurl2/";
		$config['uri_segment']      = $urisegment;
		$config['total_rows']       = $this->_view_data(false, 0, 0, $keyword, $keywordurl2);

		$this->pagination->initialize($config);
		$fromurisegment				= $this->uri->segment($urisegment);
		$data['view_data']			= $this->_view_data(true, $dataperpage, $fromurisegment, $keyword, $keywordurl2);
		$this->load->view('sjasetview/asetgdbangview/asetgdbang_index', $data);
	}

	function _view_data($isviewdata, $num, $offset, $key, $category)
	{
		if ($offset != '')
			$offset = $offset . ',';

		$sql = "SELECT 
					m.ItemID, m.AssetNo, mk.KatName, mj.JenisPerolehanName, mb.JenisGdgBangunanName, 
                    d.NoDokumenSi, d.LokasiPs, d.PenanggungJawabSi, d.MitraKerjasamaSi
				FROM 
					itemmaster m, itemgdgbangdetail d, itemkatmaster mk, itemjenisperolehanmaster mj, itemjenisbangunanmaster mb
				WHERE 
					m.ItemID=d.ItemID AND d.JenisPerolehanIDSi=mj.JenisPerolehanID AND d.JenisGdgBangunanIDSi=mb.JenisGdgBangunanID
					AND m.GolID=mk.GolID AND m.KatID=mk.KatID AND m.GolID='02'";
		if ($key !== '')
			$sql .= " AND $category LIKE '%$key%'";
		if($isviewdata) {
			$sql .= " ORDER BY m.ItemID DESC, m.AssetNo DESC LIMIT $offset $num";
		}

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
		$id											= null;
		$data['data']								= $this->_getData($id);

		$data['itemjenisperolehanmaster']			= $this->_getItemJenisperolehanmasterData();
		$data['itemjenisbangunanmaster']			= $this->_getItemJenisGdBangMaster();
		$data['itemkatmaster']						= $this->_getItemKatMasterData();

		$data['urlsegment']							= $this->uri->uri_string();
		$this->load->view('sjasetview/asetgdbangview/asetgdbang_input', $data);
	}

	function _getData($id)
	{
		$datakosong	= array(
			'ItemID'				=> null,
			'KatID'					=> '',
			'TglPr'					=> '',
			'AssetOrder'			=> '',
			'LuasBangunanPr'		=> '',
			'NilaiPerolehanPr'		=> '',
			'JenisPerolehanIDPr'	=> '',
			'MitraKerjasamaPr'		=> '',
			'NoDokumenPr'			=> '',
			'TglDokumenPr'			=> '',
			'PenyusutanPs'			=> '',
			'LokasiPs'				=> '',
			'LatPs'					=> '',
			'LongPs'				=> '',
			'BerdiriAtasTanahPs'	=> '',
			'PenanggungJawabSi'		=> '',
			'JenisPerolehanIDSi'	=> '',
			'MitraKerjasamaSi'		=> '',
			'NoDokumenSi'			=> '',
			'TglDokumenSi'			=> '',
			'JenisGdgBangunanIDSi'	=> '',
			'NilaiSi'				=> '',
			'KeteranganSi'			=> '',
			'PicLocationSi'			=> ''
		);

		$sql = "SELECT 
					m.ItemID, m.KatID, m.AssetNo, m.TglPr, d.AssetOrder, d.LuasBangunanPr, d.NilaiPerolehanPr,
					d.JenisPerolehanIDPr, d.MitraKerjasamaPr, d.NoDokumenPr, d.TglDokumenPr, d.PenyusutanPs,
					d.LokasiPs, d.LatPs, d.LongPs, d.BerdiriAtasTanahPs, d.PenanggungJawabSi, d.JenisPerolehanIDSi, 
					d.JenisPerolehanIDSi, d.MitraKerjasamaSi, d.NoDokumenSi, d.TglDokumenSi,
					d.JenisGdgBangunanIDSi, d.NilaiSi,d.KeteranganSi, d.PicLocationSi
				FROM
					itemmaster m, itemgdgbangdetail d
				WHERE
					m.ItemID=d.ItemID AND m.ItemID='$id' AND m.GolID='02'";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]) ? $result[0] : $datakosong;

		return $retval;
	}

	function _getItemJenisperolehanmasterData()
	{
		$sql = "SELECT JenisPerolehanID, JenisPerolehanName FROM itemjenisperolehanmaster";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function _getItemJenisGdBangMaster() 
	{
		$sql = "SELECT JenisGdgBangunanID, JenisGdgBangunanName FROM itemjenisbangunanmaster";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function _getItemKatMasterData()
	{
		$sql = "SELECT KatID, KatName FROM itemkatmaster WHERE GolID='02'";
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
		$sql	= "SELECT LPAD(AssetOrder+1, 3, 0) AS AO FROM itemgdgbangdetail ORDER BY AssetOrder DESC";
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
		$submit					= $this->input->post('submit');
		$katid					= $this->input->post('katid');
		$tglpr					= $this->input->post('tglpr');
		$thnpr					= substr($tglpr, 0, 4);

		$luasbangunanpr			= $this->input->post('luasbangunanpr');
		$nilaiperolehanpr		= $this->input->post('nilaiperolehanpr');
		$jenisperolehanidpr		= $this->input->post('jenisperolehanidpr');
		$mitrakerjasamapr		= $this->input->post('mitrakerjasamapr');
		$nodokumenpr			= $this->input->post('nodokumenpr');
		$tgldokumenpr			= $this->input->post('tgldokumenpr');
		$penyusutanps			= $this->input->post('penyusutanps');
		$lokasips				= $this->input->post('lokasips');
		$berdiriatastanahps		= $this->input->post('berdiriatastanahps');
		$latps					= $this->input->post('latps');
		$longps					= $this->input->post('longps');
		$penanggungjawabsi		= $this->input->post('penanggungjawabsi');
		$jenisperolehanidsi		= $this->input->post('jenisperolehanidsi');
		$mitrakerjasamasi		= $this->input->post('mitrakerjasamasi');
		$nodokumensi			= $this->input->post('nodokumensi');
		$tgldokumensi			= $this->input->post('tgldokumensi');
		$jenisgdgbangunanidsi	= $this->input->post('jenisgdgbangunanidsi');
	
		$nilaisi				= $this->input->post('nilaisi');
		$keterangansi			= $this->input->post('keterangansi');
		$piclocationsi			= $this->input->post('piclocationsi');

		if ($submit == 'SIMPAN') {
			$assetorder	= $this->_getLastAsetOrderPlusOne();
			$assetno	= '02'.$katid.$assetorder.$thnpr.$jenisperolehanidpr.$jenisperolehanidsi.$jenisgdgbangunanidsi;

			if($piclocationsi != '') {
				$config['upload_path']		= FCPATH . 'publicfolder/asetpic/';
				$config['file_name']		= 'gdb' . $assetno;
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
					$piclocationsi	= $data['full_path'];
				}
			}
			$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI 

			$datamaster	= array(
							'GolID'			=> '02',
							'KatID'			=> $katid,
							'AssetNo'		=> $assetno,
							'TglPr'			=> $tglpr
						);
			$this->db->insert('itemmaster', $datamaster);

			$itemid		= $this->_getLastInsertID();

			$datadetail	= array(
							'ItemID'				=> $itemid,
							'AssetOrder'			=> $assetorder,
							'LuasBangunanPr'		=> $luasbangunanpr ,
							'NilaiPerolehanPr'		=> $nilaiperolehanpr ,
							'JenisPerolehanIDPr'	=> $jenisperolehanidpr ,
							'MitraKerjasamaPr'		=> $mitrakerjasamapr ,
							'NoDokumenPr'			=> $nodokumenpr ,
							'TglDokumenPr'			=> $tgldokumenpr,
							'PenyusutanPs'			=> $penyusutanps ,
							'LokasiPs'				=> $lokasips ,
							'LatPs'					=> $latps ,
							'LongPs'				=> $longps ,
							'BerdiriAtasTanahPs'	=> $berdiriatastanahps ,
							'PenanggungJawabSi'		=> $penanggungjawabsi ,
							'JenisPerolehanIDSi'	=> $jenisperolehanidsi ,
							'MitraKerjasamaSi'		=> $mitrakerjasamasi ,
							'NoDokumenSi'			=> $nodokumensi ,
							'TglDokumenSi'			=> $tgldokumensi ,
							'JenisGdgBangunanIDSi'	=> $jenisgdgbangunanidsi ,
							'NilaiSi'				=> $nilaisi,
							'KeteranganSi'			=> $keterangansi,
							'PicLocationSi'			=> $piclocationsi
						);
			$this->db->insert('itemgdgbangdetail', $datadetail);

			$this->db->trans_complete(); //----------------------------------------------------END TRANSAKSI			
		}
		redirect('sjaset/asetgdbang', 'refresh');
	}

	function edit($id)
	{
		$this->load->helper('text');
		$datas								= $this->_getData($id);
		$data['data']						= $datas;
		$url	= explode('/',$datas['PicLocationSi'],6);
		$data['imgsrc']						= '';//base_url().$url[5];
		$data['data']						= $this->_getData($id);
		$data['itemjenisperolehanmaster']			= $this->_getItemJenisperolehanmasterData();
		$data['itemjenisbangunanmaster']			= $this->_getItemJenisGdBangMaster();
		$data['itemkatmaster']						= $this->_getItemKatMasterData();
		$data['urlsegment']	= $this->uri->uri_string();
		$this->load->view('sjasetview/asetgdbangview/asetgdbang_edit', $data);
	}

	function _editproc($itemid)
	{
		$submit					= $this->input->post('submit');
		$assetorder				= $this->input->post('assetorder');
		$katid					= $this->input->post('katid');
		$tglpr					= $this->input->post('tglpr');
		$thnpr					= substr($tglpr, 0, 4);
		$luasbangunanpr			= $this->input->post('luasbangunanpr');
		$nilaiperolehanpr		= $this->input->post('nilaiperolehanpr');
		$jenisperolehanidpr		= $this->input->post('jenisperolehanidpr');
		$mitrakerjasamapr		= $this->input->post('mitrakerjasamapr');
		$nodokumenpr			= $this->input->post('nodokumenpr');
		$tgldokumenpr			= $this->input->post('tgldokumenpr');
		$penyusutanps			= $this->input->post('penyusutanps');
		$lokasips				= $this->input->post('lokasips');
		$berdiriatastanahps		= $this->input->post('berdiriatastanahps');
		$latps					= $this->input->post('latps');
		$longps					= $this->input->post('longps');
		$penanggungjawabsi		= $this->input->post('penanggungjawabsi');
		$jenisperolehanidsi		= $this->input->post('jenisperolehanidsi');
		$mitrakerjasamasi		= $this->input->post('mitrakerjasamasi');
		$nodokumensi			= $this->input->post('nodokumensi');
		$tgldokumensi			= $this->input->post('tgldokumensi');
		$jenisgdgbangunanidsi	= $this->input->post('jenisgdgbangunanidsi');
	
		$nilaisi				= $this->input->post('nilaisi');
		$keterangansi			= $this->input->post('keterangansi');
		$piclocationsi			= $this->input->post('piclocationsi');

		if ($submit == 'SIMPAN') {
			$assetno	= '02'.$katid.$assetorder.$thnpr.$jenisperolehanidpr.$jenisperolehanidsi.$jenisgdgbangunanidsi;
			
			$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI 

			$datamaster	= array(
							'KatID'			=> $katid,
							'AssetNo'		=> $assetno,
							'TglPr'			=> $tglpr
						);
			$this->db->update('itemmaster', $datamaster, array('ItemID'	=> $itemid));

			$datadetail	= array(
				'AssetOrder'			=> $assetorder,
				'LuasBangunanPr'		=> $luasbangunanpr ,
				'NilaiPerolehanPr'		=> $nilaiperolehanpr ,
				'JenisPerolehanIDPr'	=> $jenisperolehanidpr ,
				'MitraKerjasamaPr'		=> $mitrakerjasamapr ,
				'NoDokumenPr'			=> $nodokumenpr ,
				'TglDokumenPr'			=> $tgldokumenpr,
				'PenyusutanPs'			=> $penyusutanps ,
				'LokasiPs'				=> $lokasips ,
				'LatPs'					=> $latps ,
				'LongPs'				=> $longps ,
				'BerdiriAtasTanahPs'	=> $berdiriatastanahps ,
				'PenanggungJawabSi'		=> $penanggungjawabsi ,
				'JenisPerolehanIDSi'	=> $jenisperolehanidsi ,
				'MitraKerjasamaSi'		=> $mitrakerjasamasi ,
				'NoDokumenSi'			=> $nodokumensi ,
				'TglDokumenSi'			=> $tgldokumensi ,
				'JenisGdgBangunanIDSi'	=> $jenisgdgbangunanidsi ,
				'NilaiSi'				=> $nilaisi,
				'KeteranganSi'			=> $keterangansi,
				'PicLocationSi'			=> $piclocationsi
			);

			//========================================FILE GAMBAR=====================
			if($piclocationsi!='') {
				$config['upload_path']		= FCPATH . 'publicfolder/asetpic/';
				$config['file_name']		= 'gdb' . $assetno;
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
					$data						= $this->upload->data();				
					$piclocationsi				= $data['full_path'];
					$datadetail['PicLocationSi']= $piclocationsi;
					
				}
			}
			//==============================================================================

			$this->db->update('itemgdgbangdetail', $datadetail, array('ItemID'	=> $itemid));

			$this->db->trans_complete(); //----------------------------------------------------END TRANSAKSI			
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
		redirect('sjaset/asetgdbang' . $url, 'refresh');
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