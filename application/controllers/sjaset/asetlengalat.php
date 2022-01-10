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
		$config['base_url']         = site_url() . "/sjaset/asetlengalat/index/$keywordurl/$keywordurl2/";
		$config['uri_segment']      = $urisegment;
		$config['total_rows']       = $this->_view_data(false, 0, 0, $keyword, $keywordurl2);

		$this->pagination->initialize($config);
		$fromurisegment				= $this->uri->segment($urisegment);
		$data['view_data']			= $this->_view_data(true, $dataperpage, $fromurisegment, $keyword, $keywordurl2);
		$this->load->view('sjasetview/asetlengalatview/asetlengalat_index', $data);
	}

	function _view_data($isviewdata, $num, $offset, $key, $category)
	{
		if ($offset != '')
			$offset = $offset . ',';

		$sql = "SELECT 
					m.ItemID, m.AssetNo, mk.KatName, mj.JenisPerlengPeralatKatName, md.DivisionAbbr, d.PenanggungJawabSi
				FROM 
					itemmaster m, itemperlengperalatdetail d, itemkatmaster mk, itemdivisionmaster md, itemjenisperlengperalatkatmaster mj 
				WHERE 
					m.ItemID=d.ItemID AND d.JenisID=mj.ID AND d.DivisionIDPs=md.DivisionID
					AND m.GolID=mk.GolID AND m.KatID=mk.KatID AND m.GolID='03'";
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
		$id											= null;
		$data['data']								= $this->_getData($id);
		$data['itemkatmaster']						= $this->_getItemKatMasterData();
		$data['itemlokasimaster']					= $this->_getItemLokasiMasterData();
		$data['itemdivisionmaster']					= $this->_getItemDivisionMasterData();
		$data['kondisikodesi']						= array(
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
		$this->load->view('sjasetview/asetlengalatview/asetlengalat_input', $data);
	}

	function _getData($id)
	{
		$datakosong	= array(
			'ItemID'				=> null,
			'KatID'					=> '',
			'AssetNo'				=> '',
			'TglPr'					=> '',
			'AssetOrder'			=> '',
			'JenisPerlengPeralatKatID'	=> '',
			'JenisID'				=> '',
			'jenisidj'=> '',
			'NoDokumenPr'			=> '',
			'NilaiPr'				=> '',
			'PenyusutanPs'			=> '',
			'LokasiIDPs'			=> '',
			'DivisionIDPs'			=> '',
			'PenanggungJawabSi'		=> '',
			'KondisiKodeSi'			=> '',
			'HargaSi'				=> '',
			'KeteranganSi'			=> '',
			'PicLocationSi'			=> ''
		);

		$sql = "SELECT 
					m.ItemID, m.KatID, m.AssetNo, m.TglPr, d.AssetOrder, d.JenisPerlengPeralatKatID, d.JenisID,
					CONCAT(d.JenisID,'|',d.JenisPerlengPeralatKatID) AS jenisidj, 
					d.NoDokumenPr, d.NilaiPr, d.PenyusutanPs, d.LokasiIDPs, d.DivisionIDPs, d.PenanggungJawabSi, 
					d.KondisiKodeSi, d.HargaSi, d.KeteranganSi, d.PicLocationSi
				FROM 
					itemmaster m, itemperlengperalatdetail d
				WHERE 
					m.ItemID=d.ItemID AND m.ItemID='$id' AND m.GolID='03'";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]) ? $result[0] : $datakosong;

		return $retval;
	}

	function _getItemJenisPerlengPeralatkatmasterData($id)
	{
		$sql = "SELECT j.ID, j.JenisPerlengPeralatKatID, CONCAT(j.ID,'|', j.JenisPerlengPeralatKatID) AS IDJ, j.JenisPerlengPeralatKatName 
		FROM itemjenisperlengperalatkatmaster j, itemmaster i
		WHERE i.KatID=j.KatID AND i.ItemID='$id' ORDER BY j.JenisPerlengPeralatKatName";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function getJenis($katid)
	{
		$sql = "SELECT ID, JenisPerlengPeralatKatID, CONCAT(ID, '|', JenisPerlengPeralatKatID) AS IDJ, JenisPerlengPeralatKatName 
		FROM itemjenisperlengperalatkatmaster 
		WHERE KatID='$katid' ORDER BY JenisPerlengPeralatKatName";
		$query = $this->db->query($sql);
		$results = $query->result_array();

		$jenisid			= "<option value=''>--Pilih Jenis--</option>";
		foreach ($results as $result) {
			$jenisid	.= "<option value='".$result['IDJ']."'>".$result['JenisPerlengPeralatKatName']."</option>\n";
		}
		echo $jenisid;
	}

	function _getItemKatMasterData()
	{
		$sql = "SELECT KatID, KatName FROM itemkatmaster WHERE GolID='03' ORDER BY KatName";
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

	function _getLastAsetOrderPlusOne($katid) 
	{
		$sql	= "SELECT LPAD(d.AssetOrder+1, 3, 0) AS AO 
					FROM itemperlengperalatdetail d, itemmaster i 
					WHERE i.ItemID=d.ItemID AND i.KatID='$katid' 
					ORDER BY d.AssetOrder DESC
					LIMIT 1";
		$query	= $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]['AO'])?$result[0]['AO']:'001';
		return $retval;
	}

	function _getLastAsetOrderPlusOneV2($katid, $jenisid) 
	{
		$sql	= "SELECT LPAD(d.AssetOrder+1, 3, 0) AS AO 
					FROM itemperlengperalatdetail d, itemmaster i 
					WHERE i.ItemID=d.ItemID AND i.KatID='$katid' AND d.JenisID='$jenisid'
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
		$submit				= $this->input->post('submit');
		$katid				= $this->input->post('katid');
		$jenisidj			= $this->input->post('jenisidj');
		$tglpr				= $this->input->post('tglpr');
		$thnpr				= substr($tglpr, 0, 4);
		$nodokumenpr		= $this->input->post('nodokumenpr');
		$nilaipr			= $this->input->post('nilaipr');
		$penyusutanps		= $this->input->post('penyusutanps');
		$lokasiidps			= $this->input->post('lokasiidps');
		$divisionidps		= $this->input->post('divisionidps');
		$penanggungjawabps	= $this->input->post('penanggungjawabsi');
		$kondisikodesi		= $this->input->post('kondisikodesi');
		$hargasi			= $this->input->post('hargasi');
		$keterangansi		= $this->input->post('keterangansi');
		$piclocationsi		= $this->input->post('piclocationsi');
		$userid = $this->session->userdata('UserID');

		$jenises					= explode("|", $jenisidj);
		$jenisid					= $jenises[0];
		$jenisperlengperalatkatid	= $jenises[1];
		if ($submit == 'SIMPAN') {
			$assetorder	= $this->_getLastAsetOrderPlusOneV2($katid, $jenisid);
			$assetno	= '03'.$katid.$jenisperlengperalatkatid.$assetorder.$thnpr.$lokasiidps.$divisionidps;
			//========================================FILE GAMBAR=====================
			// if($piclocationsi!='') {
				$config['upload_path']		= $this->getfolder() . 'publicfolder/asetpic/lenglat/';
				$config['file_name']		= 'lat' . $assetno;
				$config['overwrite']		= TRUE;
				$config['allowed_types']	= 'jpg|png|jpeg|pdf';
				$config['max_size']			= 5000;
				$config['max_width']		= 1500;
				$config['max_height']		= 1500;

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('piclocationsi')) {
					$error					= array('error_info' => $this->upload->display_errors());
					$piclocationsi			= "";
					// print_array($error);
				} else {
					$data						= $this->upload->data();				
					// $piclocationsi				= $data['full_path'];
					$piclocationsi				= $data['file_name'];
				}
			// }
			//========================================================================

			$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI 

			$datamaster	= array(
							'GolID'			=> '03',
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
							'JenisPerlengPeralatKatID'	=> $jenisperlengperalatkatid,
							'JenisID'				=> $jenisid,
							'NoDokumenPr'			=> $nodokumenpr,
							'NilaiPr'				=> $nilaipr,
							'PenyusutanPs'			=> $penyusutanps,
							'LokasiIDPs'			=> $lokasiidps,
							'DivisionIDPs'			=> $divisionidps,
							'PenanggungJawabSi'		=> $penanggungjawabps,
							'KondisiKodeSi'			=> $kondisikodesi,
							'HargaSi'				=> $hargasi,
							'KeteranganSi'			=> $keterangansi,
							'PicLocationSi'			=> $piclocationsi						
						);
			$this->db->insert('itemperlengperalatdetail', $datadetail);

			$this->db->trans_complete(); //----------------------------------------------------END TRANSAKSI
		}
		redirect('sjaset/asetlengalat', 'refresh');
	}

	function edit($id)
	{
		$this->load->helper('text');
		$datas								= $this->_getData($id);
		$data['data']						= $datas;
		$url	= explode('/',$datas['PicLocationSi'],6);
		$data['pic_url']					= 'http://36.94.184.77/sensusapi/';
		$data['itemjenisperlengperalatkatmaster']	= $this->_getItemJenisPerlengPeralatkatmasterData($id);
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
		$this->load->view('sjasetview/asetlengalatview/asetlengalat_edit', $data);
	}

	function _editproc($itemid)
	{
		$submit				= $this->input->post('submit');
		$katid				= $this->input->post('katid');
		$jenisidj			= $this->input->post('jenisidj');
		$AssetNo			= $this->input->post('AssetNo');
		$tglpr				= $this->input->post('tglpr');
		$thnpr				= substr($tglpr, 0, 4);
		$nodokumenpr		= $this->input->post('nodokumenpr');
		$lokasiidps			= $this->input->post('lokasiidps');
		$nilaipr			= $this->input->post('nilaipr');
		$penyusutanps		= $this->input->post('penyusutanps');
		$divisionidps		= $this->input->post('divisionidps');
		$penanggungjawabps	= $this->input->post('penanggungjawabsi');
		$kondisikodesi		= $this->input->post('kondisikodesi');
		$hargasi			= $this->input->post('hargasi');
		$keterangansi		= $this->input->post('keterangansi');
		$piclocationsi		= $this->input->post('piclocationsi');

		$jenises					= explode("|", $jenisidj);
		$jenisid					= $jenises[0];
		$jenisperlengperalatkatid	= $jenises[1];
		if ($submit == 'SIMPAN') {
			$assetorder	= $this->_getLastAsetOrderPlusOneV2($katid, $jenisid);
			$assetno	= '03'.$katid.$jenisperlengperalatkatid.$assetorder.$thnpr.$lokasiidps.$divisionidps;

			$is_berubah	= $this->isBerubah($AssetNo, $assetno);			
			$assetno	= ($is_berubah)?$assetno:$AssetNo; 
			
			
			$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI 

			$datamaster	= array(
							'KatID'			=> $katid,
							'AssetNo'		=> $assetno,
							'TglPr'			=> $tglpr
						);
			$this->db->update('itemmaster', $datamaster, array('ItemID'	=> $itemid));

			$datadetail	= array(
								'JenisPerlengPeralatKatID'	=> $jenisperlengperalatkatid,
								'JenisID'				=> $jenisid,
								'NoDokumenPr'			=> $nodokumenpr,
								'NilaiPr'				=> $nilaipr,
								'PenyusutanPs'			=> $penyusutanps,
								'LokasiIDPs'			=> $lokasiidps,
								'DivisionIDPs'			=> $divisionidps,
								'PenanggungJawabSi'		=> $penanggungjawabps,
								'KondisiKodeSi'			=> $kondisikodesi,
								'HargaSi'				=> $hargasi,
								'KeteranganSi'			=> $keterangansi
						);
			//========================================FILE GAMBAR=====================
			// if($piclocationsi!='') {
				$config['upload_path']		= $this->getfolder() . 'publicfolder/asetpic/lenglat/';
				$config['file_name']		= 'lat' . $assetno;
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
			// }
			//========================================F=======================================
			
			$this->db->update('itemperlengperalatdetail', $datadetail, array('ItemID'	=> $itemid));

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
		redirect('sjaset/asetlengalat' . $url, 'refresh');
	}

	function isBerubah($old, $new)
	{
		// 031402 002 20210103
		$ofirst	= substr($old, 0, 6);
		$olast	= substr($old, -8, 8);
		$ofull	= $ofirst.$olast;
		
		$nfirst	= substr($new, 0, 6);
		$nlast	= substr($new, -8, 8);
		$nfull	= $nfirst.$nlast;

		return ($ofull==$nfull)?true:false;
	}

	function _getBarQrCodeData($id) 
	{
		$sql = "SELECT 
					m.AssetNo, k.KatName, d.KeteranganSi ,j.JenisPerlengPeralatKatName  
				FROM 					itemmaster m, itemperlengperalatdetail d, itemkatmaster k, itemjenisperlengperalatkatmaster j
				WHERE 
					m.ItemID=d.ItemID AND m.KatID=k.KatID AND m.GolID=k.GolID 
					AND d.JenisID=j.ID AND m.ItemID='$id' AND m.GolID='03'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= $result[0];
		return $retval;
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
		$image_name			= 'lenglat'.$userid.'.png';
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
		$pdf->Text(21, 13,  $datas['KatName']);
		$pdf->Text(21, 17, $datas['JenisPerlengPeralatKatName']);
		$pdf->Text(21, 21, $keterangan1);
		$pdf->Text(21, 25, $keterangan2);
		$logo = base_url()."publicfolder/image/sjlogo_bw2.png";
		$pdf->Image($logo, 49, 6, 26, 12);
		$pdf->Output('lenglat.pdf', 'I');
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

	function testzpl()
	{
		$port = "9100";
		$host = "localhost";
		$label = "^XA
					^FX =================================QRcode
					^FO10,10^BQN,2,10^FDQA,0123982019001^FS
					^FX =================================Data Aset
					^FO226,20^A0,24^FDKomputer^FS
					^FO226,44^A0,24^FDLaptop^FS
					^FO226,68^A0,24^FDMerk Asus^FS
					^FO226,92^A0,24^FDType-ASN4321DLX^FS
					^FX =================================Gambar Logo sara jaya
					^FO470,80^GFA,1380,1380,20,gI03IF8,gH07JF8,gG07KF8,g03LF8,g0MF8,Y03MF,Y0KFE03,X01JF,X03IF,X0IF8,W01FFC,W03FF,W07FE,W0FF8,V01FF,V03FE00KFC,V03FC007JFC,V07F8043JFC,V0FF00E1JFC,V0FE01F0JF8,U01FE03F8JF8,U01FC07FC007F,U03F81FFE007F,U03F80FFE00FE,U07F807FC00FE,U07FFC3F801FC,U07FFE1F003FC,U0JF1E003F8,U0JF8C007F8,U0JFCI0FF,T01JFE001FE,gH03FC,gH07FC,gG01FF8,gG03FF,gG0FFE,g07FF8,Y03IF,X03IFE,T0301KF8,T07MF,T07LFC,T07KFE,T07KF8,T07JF8,T07IF,,::::::1FC00200FFCK0400EN070043C0782,7FE00600FFE00300600E00CK070041E0703,7FF00700IF00300700E00CK0700E0E0F07,F0600F00E0700780780E01EK0700E0F0E078,EJ0F80E0380F807C0E03EK0701F071C0F8,FI01F80E0380FC07E0E03FK0703F03BC0FC,7F001FC0E0381FC07F8E07FK0703B83F81DC,3FE039C0E0701CE077CE0738J0707B81F81CE,1FF039E0IF03CE073EE0F38J07071C0F03CE,00F078E0FFE0387070FE0E1CJ070F1C0E0387,007870F0FFC07870707E1E1CJ070E1E0E0787,0038IF0E1C07FF8703E1FFEJ071FFE0E07FF87078IF8E0E0IF8701E3FFE0038F1IF0E0IF8IF1C038E0F0E01C700E3807003FE3C070E0E01C3FE1C03CE079E01C70067807003FC38038E1E01C0FC3801CE039C00E7I07003800F838038E1C00E^FS
				^XZ";
		try
		{
			$fp=pfsockopen($host,$port);
			fputs($fp,$label);
			fclose($fp);

			echo 'Successfully Printed';
		}
		catch (Exception $e) 
		{
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
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

	function test()
	{
		print_array('asdf');
	}
}
