<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class AsetTanah extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "106");
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
		$config['base_url']         = site_url() . "/sjaset/asettanah/index/$keywordurl/$keywordurl2/";
		$config['uri_segment']      = $urisegment;
		$config['total_rows']       = $this->_view_data(false, 0, 0, $keyword, $keywordurl2);

		$this->pagination->initialize($config);
		$fromurisegment				= $this->uri->segment($urisegment);
		$data['view_data']			= $this->_view_data(true, $dataperpage, $fromurisegment, $keyword, $keywordurl2);
		$this->load->view('sjasetview/asettanahview/asettanah_index', $data);
	}

	function _view_data($isviewdata, $num, $offset, $key, $category)
	{
		if ($offset != '')
			$offset = $offset . ',';

		$sql = "SELECT 
					m.ItemID, m.AssetNo, mk.KatName, mj.JenisDokumenTanahName, d.LokasiPs, d.LuasSi, 
					d.PenanggungJawabSi, mp.PeruntukanName, (SELECT n.Notes FROM tanahnotes n WHERE m.ItemID=n.TanahID) AS Notes
				FROM 
					itemmaster m, itemtanahdetail d, itemkatmaster mk, itemjenisdokumentanahmaster mj, itemperuntukanmaster mp
				WHERE 
					m.ItemID=d.ItemID AND d.JenisDokumenTanahIDSi=mj.JenisDokumenTanahID AND d.PeruntukanIDSi=mp.PeruntukanID
					AND m.GolID=mk.GolID AND m.KatID=mk.KatID AND m.GolID='01'";
		if ($key !== '')
		{
			if($category=='Notes') {
				$sql .= " HAVING Notes LIKE '%$key%'";
			}
			else {
				$sql .= " AND $category LIKE '%$key%'";
			}

		}
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
		$data['itemjenisdokumentanahmaster']		= $this->_getItemJenisDoktanahmasterData();
		$data['itemstatuspenguasaanmaster']			= $this->_getStatusPenguasaanmaster();
		$data['itemperuntukanmaster']				= $this->_getItemPeruntukanMasterData();
		$data['itemkatmaster']						= $this->_getItemKatMasterData();

		$data['urlsegment']							= $this->uri->uri_string();
		$this->load->view('sjasetview/asettanahview/asettanah_input', $data);
	}

	function _getDataNotes($id)
	{
		$datakosong	= array(
			'Notes'		=> '',
			'RefNo'		=> '',
			'TanahID'	=> ''
		);

		$sql = "SELECT 
					Notes, 	RefNo, TanahID
				FROM
					tanahnotes
				WHERE
					TanahID='$id'";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]) ? $result[0] : $datakosong;

		return $retval;

	}

	function _getData($id)
	{
		$datakosong	= array(
			'ItemID'				=> null,
			'KatID'					=> '',
			'TglPr'					=> '',
			'AssetOrder'			=> '',
			'JenisDokumenTanahIDPr'	=> '',
			'TglDokumenPr'			=> '',
			'NomorDokumenPr'		=> '', 
			'LuasPr'				=> '',
			'NilaiPr'				=> '',
			'ApresiasiPr'			=> '',
			'LokasiPs'				=> '',
			'LatPs'					=> '',
			'LongPs'				=> '',
			'PenanggungJawabSi'		=> '',
			'StatusIDSi'			=> '',
			'JenisDokumenTanahIDSi'	=> '',
			'NoDokumenSi'			=> '', 
			'TglDokumenSi'			=> '',
			'PeruntukanIDSi'		=> '',
			'LuasSi'				=> '',
			'NilaiSi'				=> '',
			'KeteranganSi'			=> '',
			'PicLocationSi'			=> ''
		);

		$sql = "SELECT 
					m.ItemID, m.KatID, m.AssetNo, m.TglPr, d.AssetOrder, d.JenisDokumenTanahIDPr, d.TglDokumenPr,
					d.NomorDokumenPr, d.LuasPr, d.NilaiPr, d.ApresiasiPr, d.LokasiPs,
					d.LatPs, d.LongPs, d.PenanggungJawabSi, d.StatusIDSi, d.JenisDokumenTanahIDSi, d.NoDokumenSi, 
					d.TglDokumenSi, d.PeruntukanIDSi, d.LuasSi, d.NilaiSi, d.KeteranganSi, d.PicLocationSi
				FROM
					itemmaster m, itemtanahdetail d
				WHERE
					m.ItemID=d.ItemID AND m.ItemID='$id' AND m.GolID='01'";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]) ? $result[0] : $datakosong;

		return $retval;
	}

	function _getItemJenisDoktanahmasterData()
	{
		$sql = "SELECT JenisDokumenTanahID, JenisDokumenTanahName FROM itemjenisdokumentanahmaster";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function _getStatusPenguasaanmaster() 
	{
		$sql = "SELECT StatusID, StatusName FROM itemstatuspenguasaanmaster";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function _getItemPeruntukanMasterData()
	{
		$sql = "SELECT PeruntukanID, PeruntukanName FROM itemperuntukanmaster";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function _getItemKatMasterData()
	{
		$sql = "SELECT KatID, KatName FROM itemkatmaster WHERE GolID='01'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function _getItemJenisdokumentanah()
	{
		$sql = "SELECT JenisDokumenTanahID, JenisDokumenTanahName FROM itemjenisdokumentanahmaster";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}	//

	function _getLastInsertID() 
	{
		$sql	= "SELECT LAST_INSERT_ID() AS lii";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result[0]['lii'];
	}

	function _getLastAsetOrderPlusOne($katid) 
	{
		$sql	= "SELECT LPAD(d.AssetOrder+1, 3, 0) AS AO 
					FROM itemtanahdetail d, itemmaster i 
					WHERE i.ItemID=d.ItemID AND i.KatID='$katid' 
					ORDER BY d.AssetOrder DESC
					LIMIT 1";
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
		$submit						= $this->input->post('submit');
		$katid						= $this->input->post('katid');
		$tglpr						= ($this->input->post('tglpr')=='')?'0000-00-00':$this->input->post('tglpr');
		$thnpr						= substr($tglpr, 0, 4);

		$jenisdokumentanahidpr		= $this->input->post('jenisdokumentanahidpr');
		$tgldokumenpr				= ($this->input->post('tgldokumenpr')=='')?'0000-00-00':$this->input->post('tgldokumenpr');
		$nomordokumenpr				= $this->input->post('nomordokumenpr');
		$luaspr						= $this->input->post('luaspr');
		$nilaipr					= $this->input->post('nilaipr');
		$apresiasipr				= $this->input->post('apresiasipr');
		$lokasips					= $this->input->post('lokasips');
		$latps						= $this->input->post('latps');
		$longps						= $this->input->post('longps');
		$penanggungjawabsi			= $this->input->post('penanggungjawabsi');
		$statusidsi					= $this->input->post('statusidsi');
		$jenisdokumentanahidsi		= $this->input->post('jenisdokumentanahidsi');
		$peruntukanidsi				= $this->input->post('peruntukanidsi');
		$tgldokumensi				= ($this->input->post('tgldokumensi')=='')?'0000-00-00':$this->input->post('tgldokumensi');		
		$nodokumensi				= $this->input->post('nodokumensi');
		$luassi						= $this->input->post('luassi');
		$nilaisi					= $this->input->post('nilaisi');
		$keterangansi				= $this->input->post('keterangansi');
		$piclocationsi				= $this->input->post('piclocationsi');
		$userid = $this->session->userdata('UserID');

		if ($submit == 'SIMPAN') {
			// $assetorder	= $this->_getLastAsetOrderPlusOne($katid);
			// $assetno	= '01'.$katid.$assetorder.$thnpr.$jenisdokumentanahidpr.$statusidsi.$jenisdokumentanahidsi.$peruntukanidsi;
			$assetorder	= $this->_getLastAsetOrderPlusOneV3_tanah($katid, $thnpr);
			$assetno	= '01.'.$katid.'.'.$thnpr.'-'.$assetorder;
			
			$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI 

			$datamaster	= array(
							'GolID'			=> '01',
							'KatID'			=> $katid,
							'AssetNo'		=> $assetno,
							'UserID'		=> $userid,
							'TglPr'			=> $tglpr
						);
			$this->db->insert('itemmaster', $datamaster);

			$itemid		= $this->_getLastInsertID();

			$datadetail	= array(
							'ItemID'				=> $itemid,
							'AssetOrder'			=> $assetorder,
							'JenisDokumenTanahIDPr'	=> $jenisdokumentanahidpr,
							'TglDokumenPr'			=> $tgldokumenpr,
							'NomorDokumenPr'		=> $nomordokumenpr,
							'LuasPr'				=> $luaspr,
							'NilaiPr'				=> $nilaipr,
							'ApresiasiPr'			=> $apresiasipr,
							'LokasiPs'				=> $lokasips,
							'LatPs'					=> $latps,
							'LongPs'				=> $longps,
							'PenanggungJawabSi'		=> $penanggungjawabsi,
							'StatusIDSi'			=> $statusidsi,
							'JenisDokumenTanahIDSi'	=> $jenisdokumentanahidsi,
							'PeruntukanIDSi'		=> $peruntukanidsi,
							'TglDokumenSi'			=> $tgldokumensi,
							'NoDokumenSi'			=> $nodokumensi,
							'LuasSi'				=> $luassi,
							'NilaiSi'				=> $nilaisi,
							'KeteranganSi'			=> $keterangansi
						);
			$this->db->insert('itemtanahdetail', $datadetail);

			$addnotes	= $this->input->post('addnotesinput');
			if($addnotes !== "") {
				$datatanahnotes	= array(
					'TanahID'	=> $itemid,
					'Notes'		=> $addnotes
				);
				$this->db->insert('tanahnotes', $datatanahnotes);
			}

			$this->db->trans_complete(); //----------------------------------------------------END TRANSAKSI

			//========================================FILE GAMBAR=====================
			$config['upload_path']		= $this->getfolder() . 'publicfolder/asetpic/tanah/';
			$config['file_name']		= 'tnh' . '_'.$itemid;
			$config['overwrite']		= TRUE;
			$config['allowed_types']	= 'jpg|png|jpeg|pdf';
			$config['max_size']			= 5000;
			$config['max_width']		= 1500;
			$config['max_height']		= 1500;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('piclocationsi')) {
				$error					= array('error_info' => $this->upload->display_errors());
				// print_array($error);
			} else {
				$data						= $this->upload->data();				
				$datapic['PicLocationSi']	= $data['file_name'];
				$this->db->update('itemtanahdetail', $datapic, array('ItemID'	=> $itemid));
			}
			//========================================eofFILE GAMBAR=====================
			redirect('sjaset/asettanah', 'refresh');
		}
	}

	function edit($id)
	{
		$this->load->helper('text');
		$datas								= $this->_getData($id);
		$data['data']						= $datas;
		$url	= explode('/',$datas['PicLocationSi'],6);
		$data['imgsrc']						= '';//base_url().$url[5];
		$base		= base_url();
		$basearr	= explode('/',$base);
		$data['pic_url']					= 'http://'.$basearr[2].'/sensusapi/';
		$data['data']						= $this->_getData($id);
		$data['datanotes']					= $this->_getDataNotes($id);
		$data['itemkatmaster']				= $this->_getItemKatMasterData();
		$data['itemjenisdokumentanahmaster']= $this->_getItemJenisDoktanahmasterData();
		$data['itemstatuspenguasaanmaster']= $this->_getStatusPenguasaanmaster();
		$data['itemperuntukanmaster']		= $this->_getItemPeruntukanMasterData();
		$data['urlsegment']	= $this->uri->uri_string();
		$this->load->view('sjasetview/asettanahview/asettanah_edit', $data);
	}

	function _editproc($itemid)
	{
		$submit						= $this->input->post('submit');
		$katid						= $this->input->post('katid');
		$assetno_old				= $this->input->post('AssetNo');
		$tglpr						= $this->input->post('tglpr');
		$thnpr						= substr($tglpr, 0, 4);
		$jenisdokumentanahidpr		= $this->input->post('jenisdokumentanahidpr');
		$tgldokumenpr				= $this->input->post('tgldokumenpr');
		$nomordokumenpr				= $this->input->post('nomordokumenpr');
		$luaspr						= $this->input->post('luaspr');
		$nilaipr					= $this->input->post('nilaipr');
		$apresiasipr				= $this->input->post('apresiasipr');
		$lokasips					= $this->input->post('lokasips');
		$latps						= $this->input->post('latps');
		$longps						= $this->input->post('longps');
		$penanggungjawabsi			= $this->input->post('penanggungjawabsi');
		$statusidsi					= $this->input->post('statusidsi');
		$jenisdokumentanahidsi		= $this->input->post('jenisdokumentanahidsi');
		$peruntukanidsi				= $this->input->post('peruntukanidsi');
		$tgldokumensi				= $this->input->post('tgldokumensi');
		$nodokumensi				= $this->input->post('nodokumensi');
		$luassi						= $this->input->post('luassi');
		$nilaisi					= $this->input->post('nilaisi');
		$keterangansi				= $this->input->post('keterangansi');
		$piclocationsi				= $this->input->post('piclocationsi');

		if ($submit == 'SIMPAN') {
			// $assetorder	= $this->_getLastAsetOrderPlusOne($katid);
			// $assetno	= '01'.$katid.$assetorder.$thnpr.$jenisdokumentanahidpr.$statusidsi.$jenisdokumentanahidsi.$peruntukanidsi;
			$assetorder_new	= $this->_getLastAsetOrderPlusOneV3_tanah($katid, $thnpr);
			$assetno_new	= '01.'.$katid.'.'.$thnpr.'-'.$assetorder_new;

			$is_berubah	= $this->isBerubah($assetno_old, $assetno_new);

			$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI 

			$datamaster	= array(
							'KatID'			=> $katid,
							'TglPr'			=> $tglpr
						);			

			$datadetail	= array(
				'JenisDokumenTanahIDPr'	=> $jenisdokumentanahidpr,
				'TglDokumenPr'			=> $tgldokumenpr,
				'NomorDokumenPr'		=> $nomordokumenpr,
				'LuasPr'				=> $luaspr,
				'NilaiPr'				=> $nilaipr,
				'ApresiasiPr'			=> $apresiasipr,
				'LokasiPs'				=> $lokasips,
				'LatPs'					=> $latps,
				'LongPs'				=> $longps,
				'PenanggungJawabSi'		=> $penanggungjawabsi,
				'StatusIDSi'			=> $statusidsi,
				'JenisDokumenTanahIDSi'	=> $jenisdokumentanahidsi,
				'PeruntukanIDSi'		=> $peruntukanidsi,
				'TglDokumenSi'			=> $tgldokumensi,
				'NoDokumenSi'			=> $nodokumensi,
				'LuasSi'				=> $luassi,
				'NilaiSi'				=> $nilaisi,
				'KeteranganSi'			=> $keterangansi

			);
			//========================================FILE GAMBAR=====================
			$config['upload_path']		= $this->getfolder() . 'publicfolder/asetpic/tanah/';
			$config['file_name']		= 'tnh' . '_'.$itemid;
			$config['overwrite']		= TRUE;
			$config['allowed_types']	= 'jpg|png|jpeg';
			$config['max_size']			= 5000;
			$config['max_width']		= 1500;
			$config['max_height']		= 1500;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('piclocationsi')) {
				$error					= array('error_info' => $this->upload->display_errors());
				// print_array($error);
			} else {
				$data						= $this->upload->data();
				$piclocationsi				= $data['file_name'];
				$datadetail['PicLocationSi']= $piclocationsi;					
			}
			//========================================eofFILE GAMBAR=====================
			if($is_berubah) {
				$datadetail['AssetOrder']	= $assetorder_new;
				$datamaster['AssetNo']		= $assetno_new;
			}			
			$this->db->update('itemmaster', $datamaster, array('ItemID'	=> $itemid));
			$this->db->update('itemtanahdetail', $datadetail, array('ItemID'	=> $itemid));

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
		redirect('sjaset/asettanah' . $url, 'refresh');
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

	function pdf($id)
	{
		$datas	= $this->_getBarQrCodeData($id);
		$keterangan_arr	= explode("\n",$datas['KeteranganSi']);
		$keterangan1	= isset($keterangan_arr[0])?$keterangan_arr[0]:'';
		$keterangan2	= isset($keterangan_arr[1])?$keterangan_arr[1]:'';

		$this->load->library('ciqrcode');

        $config['cacheable']    = true;
        $config['cachedir']     = './publicfolder/qrcode/';
        $config['errorlog']     = './publicfolder/qrcode/';
        $config['imagedir']     = './publicfolder/qrcode/images/';
        $config['quality']      = true;
        $config['size']         = '1024';
        $config['black']        = array(224,255,255);
        $config['white']        = array(70,130,180);
        $this->ciqrcode->initialize($config);

		$userid = $this->session->userdata('UserID');
		$image_name			= 'tnh'.$userid.'.png';
        $params['data']		= $datas['AssetNo'];
        $params['level']	= 'H';
        $params['size']		= 4;
        $params['savename']	= FCPATH.$config['imagedir'].$image_name;
        $this->ciqrcode->generate($params);
		
		$imageurl = base_url()."publicfolder/qrcode/images/".$image_name;
		$this->load->library('fpdf');
		$pdf = new FPDF('P', 'mm', 'printerbarcode');
		$pdf->AddPage();		
		$pdf->Image($imageurl, 1, 6, 20, 20);
		$pdf->SetFont('Arial', '', 8);
		$pdf->Text(21, 9,  $datas['AssetNo']);
		$pdf->Text(21, 13,  $datas['NoDokumenSi']);
		$pdf->Text(21, 17, $datas['JenisDokumenTanahName']);
		$pdf->Text(21, 21, $keterangan1);
		// $pdf->Text(21, 25, $keterangan2);
		$logo = base_url()."publicfolder/image/sjlogo_bw2.png";
		$pdf->Image($logo, 49, 6, 26, 12);
		$pdf->Output('test.pdf', 'I');

	}

	function _getBarQrCodeData($id) 
	{
		$sql = "SELECT 
					m.AssetNo, d.LokasiPs, d.NoDokumenSi, d.TglDokumenSi, 
					v.JenisDokumenTanahName, d.PenanggungJawabSi, d.KeteranganSi
				FROM 
					itemmaster m, itemtanahdetail d, itemjenisdokumentanahmaster v
				WHERE 
					m.ItemID=d.ItemID AND d.JenisDokumenTanahIDSi=v.JenisDokumenTanahID 
					AND m.ItemID='$id' AND m.GolID='01'";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= $result[0];
		return $retval;
	}

	function _getLastAsetOrderPlusOneV3_tanah($katid, $thnpr)
    {
        $sql	= "SELECT LPAD(d.AssetOrder+1, 5, 0) AS AO 
					FROM itemtanahdetail d, itemmaster i 
					WHERE i.ItemID=d.ItemID AND i.KatID='$katid' AND YEAR(i.TglPr)='$thnpr'
					ORDER BY d.AssetOrder DESC
					LIMIT 1";
		$query	= $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]['AO'])?$result[0]['AO']:'00001';
		return $retval;
    }

	function isBerubah($assetno_old, $assetno_new)
	{
		$retval		= false;

		$asr_new	= explode(".",$assetno_new);
		$asr_old	= explode(".",$assetno_old);

		if(isset($asr_old[2])) {
			$katthn_old	= $asr_old[1].substr($asr_old[2],0,4);
			$katthn_new	= $asr_new[1].substr($asr_new[2],0,4);
		} else {
			$katthn_old = $assetno_old;
			$katthn_new = $assetno_new;
		}		

		if($katthn_new !== $katthn_old) {
			$retval	= true;
		}
		
		return $retval;
	}

	function test()
	{
		$base	= base_url();
		$asdf	= explode('/',$base);
		print_array($asdf[2]);
	}
}