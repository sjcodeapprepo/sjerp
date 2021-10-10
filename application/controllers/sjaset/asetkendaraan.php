<?php
include(APPPATH . '/controllers/auth/authcontroller' . EXT);

class Asetkendaraan extends Authcontroller
{
	var $isusermodify;

	function __construct()
	{
		parent::__construct();
		define("MENU_ID", "103");
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
		$config['base_url']         = site_url() . "/sjaset/asetkendaraan/index/$keywordurl/$keywordurl2/";
		$config['uri_segment']      = $urisegment;
		$config['total_rows']       = $this->_view_data(false, 0, 0, $keyword, $keywordurl2);

		$this->pagination->initialize($config);
		$fromurisegment				= $this->uri->segment($urisegment);
		$data['view_data']			= $this->_view_data(true, $dataperpage, $fromurisegment, $keyword, $keywordurl2);
		$this->load->view('sjasetview/asetkendaraanview/asetkend_index', $data);
	}

	function _view_data($isviewdata, $num, $offset, $key, $category)
	{
		if ($offset != '')
			$offset = $offset . ',';

		$sql = "SELECT 
					m.ItemID, m.AssetNo, mk.KatName, mj.JenisKendaraanKatName, d.MerkPr, d.NoPolPr, d.PenanggungJawabPs
				FROM 
					itemmaster m, itemkendaraandetail d, itemkatmaster mk, itemdivisionmaster md, itemjeniskendaraankatmaster mj 
				WHERE 
					m.ItemID=d.ItemID AND d.JenisID=mj.ID AND d.DivisionIDPs=md.DivisionID
					AND m.GolID=mk.GolID AND m.KatID=mk.KatID AND m.GolID='05'";
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
		$this->load->view('sjasetview/asetkendaraanview/asetkend_input', $data);
	}

	function _getData($id)
	{
		$datakosong	= array(
			'ItemID'				=> null,
			'KatID'					=> '',
			'AssetNo'				=> '',
			'JenisKendaraanKatID'	=> '',
			'JenisID'				=> '',
			'jenisidj'=> '',
			'TglPr'					=> '',
			'NoDokumenPr'			=> '', 
			'NilaiPr'				=> '',
			'PenyusutanPr'			=> '',
			'NoDokumenBPKBPr'		=> '',
			'TglDokumenPr'			=> '',
			'NoSTNKPr'				=> '',
			'TglSTNKPr'				=> '',
			'NoPolPr'				=> '',
			'NoRangkaPr'			=> '',
			'NoMesinPr'				=> '',
			'TahunDibuatPr'			=> '',
			'MerkPr'				=> '',
			'WarnaPr'				=> '',
			'IsiSilinderPr'			=> '',
			'BahanBakarPr'			=> '',
			'LokasiIDPs'			=> '',
			'DivisionIDPs'			=> '',
			'PenanggungJawabPs'		=> '',
			'KondisiKodeSi'			=> '',
			'NilaiSi'				=> '',
			'KeteranganSi'			=> '',
			'PicLocationSi'			=> ''
		);

		$sql = "SELECT 
					m.ItemID, m.KatID, m.AssetNo, m.TglPr, d.AssetOrder, d.JenisKendaraanKatID,
					CONCAT(d.JenisID,'|',d.JenisKendaraanKatID) AS jenisidj, d.JenisID,
					d.NoDokumenPr,d.NilaiPr, d.PenyusutanPr, d.NoDokumenBPKBPr, d.TglDokumenPr,
					d.NoSTNKPr, d.TglSTNKPr, d.NoPolPr, d.NoRangkaPr, d.NoMesinPr, d.TahunDibuatPr, d.MerkPr,
					d.WarnaPr, d.IsiSilinderPr, d.BahanBakarPr, d.LokasiIDPs, d.DivisionIDPs, d.PenanggungJawabPs, 
					d.KondisiKodeSi, d.NilaiSi, d.KeteranganSi, d.PicLocationSi
				FROM
					itemmaster m, itemkendaraandetail d
				WHERE 
					m.ItemID=d.ItemID AND m.ItemID='$id' AND m.GolID='05'";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$retval	= isset($result[0]) ? $result[0] : $datakosong;

		return $retval;
	}

	function _getItemJenisKendmstData($id)
	{
		$sql = "SELECT j.JenisKendaraanKatID , j.JenisKendaraanKatName, CONCAT(j.ID,'|',j.JenisKendaraanKatID) AS IDJ
		FROM itemjeniskendaraankatmaster j, itemmaster i
		WHERE i.KatID=j.KatID AND i.ItemID='$id' ORDER BY j.JenisKendaraanKatName";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	function getJenis($katid)
	{
		$sql = "SELECT  JenisKendaraanKatID,  JenisKendaraanKatName, CONCAT(ID, '|', JenisKendaraanKatID) AS IDJ
		FROM itemjeniskendaraankatmaster
		WHERE KatID='$katid'";
		$query = $this->db->query($sql);
		$results = $query->result_array();

		$jenisid			= "<option value=''>--Pilih Jenis--</option>";
		foreach ($results as $result) {
			$jenisid	.= "<option value='".$result['IDJ']."'>".$result['JenisKendaraanKatName']."</option>\n";
		}
		echo $jenisid;
	}

	function _getItemKatMasterData()
	{
		$sql = "SELECT KatID, KatName FROM itemkatmaster WHERE GolID='05'";
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
					FROM itemkendaraandetail d, itemmaster i 
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
					FROM itemkendaraandetail d, itemmaster i 
					WHERE i.ItemID=d.ItemID AND i.KatID='$katid' AND d.JenisID ='$jenisid'
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
		$jenisidj		= $this->input->post('jenisidj');
		$tglpr						= $this->input->post('tglpr');
		$thnpr						= substr($tglpr, 0, 4);
		$nodokumenpr				= $this->input->post('nodokumenpr');
		$nilaipr					= $this->input->post('nilaipr');
		$penyusutanpr				= $this->input->post('penyusutanpr');
		$nodokumenbpkbpr			= $this->input->post('nodokumenbpkbpr');
		$tgldokumenpr = $this->input->post('tgldokumenpr');
		$nostnkpr					= $this->input->post('nostnkpr');
		$tglstnkpr					= $this->input->post('tglstnkpr');
		$nopolpr					= $this->input->post('nopolpr');
		$norangkapr					= $this->input->post('norangkapr');
		$nomesinpr					= $this->input->post('nomesinpr');
		$warnapr					= $this->input->post('warnapr');
		$tahundibuatpr				= $this->input->post('tahundibuatpr');
		$merkpr						= $this->input->post('merkpr');
		$typepr						= $this->input->post('typepr');
		$isisilinderpr				= $this->input->post('isisilinderpr');
		$bahanbakarpr				= $this->input->post('bahanbakarpr');
		$lokasiidps					= $this->input->post('lokasiidps');
		$divisionidps				= $this->input->post('divisionidps');
		$penanggungjawabps			= $this->input->post('penanggungjawabps');
		$kondisikodesi				= $this->input->post('kondisikodesi');
		$nilaisi					= $this->input->post('nilaisi');
		$keterangansi				= $this->input->post('keterangansi');
		$piclocationsi				= $this->input->post('piclocationsi');

		$jenises			= explode("|", $jenisidj);
		$jenisid			= $jenises[0];
		$jeniskendaraankatid	= $jenises[1];

		if ($submit == 'SIMPAN') {
			$assetorder	= $this->_getLastAsetOrderPlusOneV2($katid, $jenisid);
			$assetno	= '05'.$katid.$jeniskendaraankatid.$assetorder.$thnpr.$lokasiidps.$divisionidps;

			// if($piclocationsi!='') {
			
				$config['upload_path']		= FCPATH . 'publicfolder/asetpic/kendr/';
				$config['file_name']		= 'kdr' . $assetno;
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
					$data			= $this->upload->data();				
					$piclocationsi	= $data['file_name'];
				}
			// }

			$this->db->trans_start(); //-----------------------------------------------------START TRANSAKSI 

			$datamaster	= array(
							'GolID'			=> '05',
							'KatID'			=> $katid,
							'AssetNo'		=> $assetno,
							'TglPr'			=> $tglpr
						);
			$this->db->insert('itemmaster', $datamaster);

			$itemid		= $this->_getLastInsertID();

			$datadetail	= array(
							'ItemID'				=> $itemid,
							'AssetOrder'			=> $assetorder,
							'JenisID'				=> $jenisid,
							'JenisKendaraanKatID'	=> $jeniskendaraankatid,
							'NoDokumenPr'			=> $nodokumenpr,
							'NilaiPr'				=> $nilaipr,
							'PenyusutanPr'			=> $penyusutanpr,
							'NoDokumenBPKBPr'		=> $nodokumenbpkbpr,
							'TglDokumenPr'			=> $tgldokumenpr,
							'NoSTNKPr'				=> $nostnkpr,
							'TglSTNKPr'				=> $tglstnkpr,
							'NoPolPr'				=> $nopolpr,
							'NoRangkaPr'			=> $norangkapr,
							'NoMesinPr'				=> $nomesinpr,
							'WarnaPr'				=> $warnapr,
							'TahunDibuatPr'			=> $tahundibuatpr,
							'MerkPr'				=> $merkpr,
							'TypePr'				=> $typepr,
							'IsiSilinderPr'			=> $isisilinderpr,
							'BahanBakarPr'			=> $bahanbakarpr,
							'LokasiIDPs'			=> $lokasiidps,
							'DivisionIDPs'			=> $divisionidps,
							'PenanggungJawabPs'		=> $penanggungjawabps,
							'KondisiKodeSi'			=> $kondisikodesi,
							'NilaiSi'				=> $nilaisi,
							'KeteranganSi'			=> $keterangansi,
							'PicLocationSi'			=> $piclocationsi
						);
			$this->db->insert('itemkendaraandetail', $datadetail);

			$this->db->trans_complete(); //----------------------------------------------------END TRANSAKSI		
			
			redirect('sjaset/asetkendaraan', 'refresh');
		}
	}

	function _editproc($itemid)
	{
		$submit						= $this->input->post('submit');
		$AssetNo			= $this->input->post('AssetNo');
		$katid						= $this->input->post('katid');
		$jenisidj					= $this->input->post('jenisidj');
		$tglpr						= $this->input->post('tglpr');
		$thnpr						= substr($tglpr, 0, 4);
		$nodokumenpr				= $this->input->post('nodokumenpr');
		$nilaipr					= $this->input->post('nilaipr');
		$penyusutanpr				= $this->input->post('penyusutanpr');

		$nodokumenbpkbpr			= $this->input->post('nodokumenbpkbpr');
		$tgldokumenpr					= $this->input->post('tgldokumenpr');
		$nostnkpr					= $this->input->post('nostnkpr');
		$tglstnkpr					= $this->input->post('tglstnkpr');
		$nopolpr					= $this->input->post('nopolpr');
		$norangkapr					= $this->input->post('norangkapr');
		$warnapr					= $this->input->post('warnapr');
		$nomesinpr					= $this->input->post('nomesinpr');
		$tahundibuatpr				= $this->input->post('tahundibuatpr');
		$merkpr						= $this->input->post('merkpr');
		$typepr						= $this->input->post('typepr');
		$isisilinderpr				= $this->input->post('isisilinderpr');
		$bahanbakarpr				= $this->input->post('bahanbakarpr');
		$lokasiidps					= $this->input->post('lokasiidps');
		$divisionidps				= $this->input->post('divisionidps');
		$penanggungjawabps			= $this->input->post('penanggungjawabps');
		$kondisikodesi				= $this->input->post('kondisikodesi');
		$nilaisi					= $this->input->post('nilaisi');
		$keterangansi				= $this->input->post('keterangansi');
		$piclocationsi				= $this->input->post('piclocationsi');

		$jenises					= explode("|", $jenisidj);
		$jenisid					= $jenises[0];
		$jeniskendaraankatid		= $jenises[1];
		if ($submit == 'SIMPAN') {
			$assetorder	= $this->_getLastAsetOrderPlusOneV2($katid, $jenisid);
			$assetno	= '05'.$katid.$jeniskendaraankatid.$assetorder.$thnpr.$lokasiidps.$divisionidps;

			$is_berubah	= $this->isBerubah($AssetNo, $assetno);			
			$assetno	= ($is_berubah)?$assetno:$AssetNo;

			$datamaster	= array(
							'KatID'			=> $katid,
							'AssetNo'		=> $assetno,
							'TglPr'			=> $tglpr
						);
			$this->db->update('itemmaster', $datamaster, array('ItemID'	=> $itemid));

			$datadetail	= array(
							'JenisKendaraanKatID'	=> $jeniskendaraankatid,
							'JenisID'				=> $jenisid,
							'NoDokumenPr'			=> $nodokumenpr,
							'NilaiPr'				=> $nilaipr,
							'PenyusutanPr'			=> $penyusutanpr,
							'NoDokumenBPKBPr'		=> $nodokumenbpkbpr,
							'NoSTNKPr'				=> $nostnkpr,
							'TglSTNKPr'				=> $tglstnkpr,
							'TglDokumenPr'			=> $tgldokumenpr,
							'NoPolPr'				=> $nopolpr,
							'NoRangkaPr'			=> $norangkapr,
							'NoMesinPr'				=> $nomesinpr,
							'TahunDibuatPr'			=> $tahundibuatpr,
							'WarnaPr'				=> $merkpr,
							'MerkPr'				=> $warnapr,
							'TypePr'				=> $typepr,
							'IsiSilinderPr'			=> $isisilinderpr,
							'BahanBakarPr'			=> $bahanbakarpr,
							'LokasiIDPs'			=> $lokasiidps,
							'DivisionIDPs'			=> $divisionidps,
							'PenanggungJawabPs'		=> $penanggungjawabps,
							'KondisiKodeSi'			=> $kondisikodesi,
							'NilaiSi'				=> $nilaisi,
							'KeteranganSi'			=> $keterangansi
						);
			//========================================FILE GAMBAR=====================
			// if($piclocationsi!='') {
				$config['upload_path']		= FCPATH . 'publicfolder/asetpic/kendr/';
				$config['file_name']		= 'kdr' . $assetno;
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
			//==============================================================================
			$this->db->update('itemkendaraandetail', $datadetail, array('ItemID'	=> $itemid));

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
		redirect('sjaset/asetkendaraan' . $url, 'refresh');
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
					m.AssetNo, d.NoPolPr, d.TypePr, d.DivisionIDPs, v.DivisionAbbr, d.MerkPr, d.PenanggungJawabPs, d.KeteranganSi
				FROM 
					itemmaster m, itemkendaraandetail d, itemdivisionmaster v
				WHERE 
					m.ItemID=d.ItemID AND d.DivisionIDPs=v.DivisionID AND m.ItemID='$id' AND m.GolID='05'";
		
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

		$image_name			= 'bc.png';
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
		$pdf->Text(21, 13,  $datas['MerkPr']);
		$pdf->Text(21, 17, $datas['NoPolPr']);
		$pdf->Text(21, 21, $keterangan1);
		$pdf->Text(21, 25, $keterangan2);
		$logo = base_url()."publicfolder/image/sjlogo.png";
		$pdf->Image($logo, 49, 6, 26, 12);
		$pdf->Output('test.pdf', 'I');

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

	function edit($id)
	{
		$this->load->helper('text');
		$datas								= $this->_getData($id);
		$data['data']						= $datas;
		$url	= explode('/',$datas['PicLocationSi'],6);
		// $data['imgsrc']						= base_url().$url[5];
		$data['data']								= $this->_getData($id);
		$data['itemjeniskendaraankatmaster']				= $this->_getItemJenisKendmstData($id);
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
		$this->load->view('sjasetview/asetkendaraanview/asetkend_edit', $data);
	}

}