<?php
include(APPPATH.'/controllers/auth/authcontroller'.EXT);
class ListAset extends Authcontroller {

	function __construct() 
	{
		parent::__construct();
		define("MENU_ID", "100");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid,MENU_ID);
	}

	function index() 
	{
		$this->load->view('sjasetview/asetreport/listaset_index');
	}
	
	function xlslist() 
	{
		$submit		= $this->input->post('submit');
		$gol		= $this->input->post('golaset');
		
		if($submit=='.XLS') {
			$this->load->library('excel');
			$laporan	= $this->excel;			
			
			if($gol=='01') {
				$golstr	= '_tanah';
				$this->_tanah($laporan);
			} else if($gol=='02') {
				$golstr	= '_gedung_dan_bangunan';
				$this->_gedbang($laporan);
			} else if($gol=='03') {
				$golstr	= '_perlengkapan_peralatan';
				$this->_lenglat($laporan);
			} else if($gol=='04') {
				$golstr	= '_elek_dan_mesin';
				$this->_elmes($laporan);
			} else if($gol=='05') {
				$golstr	= '_kendaraan';
				$this->_kendr($laporan);
			}
			
			$filename = 'listaset'.$golstr.'.xls';	
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($laporan, 'Excel5'); 
			$objWriter->save('php://output');
		}
	}

	function _getDataPerlengkapanperalatan() 
	{
		$sql = "SELECT 
					m.ItemID, m.AssetNo, m.TglPr ,mk.KatName, mj.JenisPerlengPeralatKatName, md.DivisionAbbr, 
					d.NoDokumenPr, d.NilaiPr, d.PenyusutanPs, d.LokasiIDPs, l.LokasiName, d.DivisionIDPs,
					d.PenanggungJawabSi, d.KondisiKodeSi, d.HargaSi, d.KeteranganSi
				FROM 
					itemmaster m, itemperlengperalatdetail d, itemkatmaster mk, itemdivisionmaster md, itemjenisperlengperalatkatmaster mj,
					itemlokasimaster l
				WHERE 
					m.ItemID=d.ItemID AND d.JenisID=mj.ID AND d.DivisionIDPs=md.DivisionID AND d.LokasiIDPs=l.LokasiID
					AND m.GolID=mk.GolID AND m.KatID=mk.KatID AND m.GolID='03'
				ORDER BY m.ItemID DESC, m.AssetNo DESC";		

		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

    function _lenglat($laporan) 
	{
		$myWorkSheet	= new PHPExcel_Worksheet($laporan, 'Perlengkapan dan Peralatan');
		$laporan->addSheet($myWorkSheet, 0);
		$laporan->setActiveSheetIndex(0);
		
		$data= $this->_getDataPerlengkapanperalatan();
		
		//-------JUDUL
		$laporan->getActiveSheet()->setCellValue('A1','Perumda Sarana Jaya');
		$laporan->getActiveSheet()->setCellValue('A2','List Aset Golongan Perlengkapan dan Peralatan');
		//-------------TABEL HEADER
		$laporan->getActiveSheet()->mergeCells('A4:A6');
		$laporan->getActiveSheet()->setCellValue('A4','No');
		$laporan->getActiveSheet()->mergeCells('B4:E4');
		$laporan->getActiveSheet()->setCellValue('B4','Identitas Barang');
		$laporan->getActiveSheet()->mergeCells('B5:B6');
		$laporan->getActiveSheet()->setCellValue('B5','Golongan');
		$laporan->getActiveSheet()->mergeCells('C5:C6');
		$laporan->getActiveSheet()->setCellValue('C5','Kategori');
		$laporan->getActiveSheet()->mergeCells('D5:D6');
		$laporan->getActiveSheet()->setCellValue('D5','Jenis');
		$laporan->getActiveSheet()->mergeCells('E5:E6');
		$laporan->getActiveSheet()->setCellValue('E5','No Aset');
		$laporan->getActiveSheet()->mergeCells('F4:H4');
		$laporan->getActiveSheet()->setCellValue('F4','Perolehan');
		$laporan->getActiveSheet()->mergeCells('F5:F6');
		$laporan->getActiveSheet()->setCellValue('F5','Tgl Perolehan');
		$laporan->getActiveSheet()->mergeCells('G5:G6');
		$laporan->getActiveSheet()->setCellValue('G5','No. Dokumen Perolehan');
		$laporan->getActiveSheet()->mergeCells('H5:H6');
		$laporan->getActiveSheet()->setCellValue('H5','Nilai Perolehan');
		$laporan->getActiveSheet()->mergeCells('I4:K4');
		$laporan->getActiveSheet()->setCellValue('I4','Posisi');
		$laporan->getActiveSheet()->mergeCells('I5:I6');
		$laporan->getActiveSheet()->setCellValue('I5','Penyusutan');
		$laporan->getActiveSheet()->mergeCells('J5:J6');
		$laporan->getActiveSheet()->setCellValue('J5','Lokasi');
		$laporan->getActiveSheet()->mergeCells('K5:K6');
		$laporan->getActiveSheet()->setCellValue('K5','Divisi');
		$laporan->getActiveSheet()->mergeCells('L4:O4');
		$laporan->getActiveSheet()->setCellValue('L4','Kondisi Saat Ini');
		$laporan->getActiveSheet()->mergeCells('L5:L6');
		$laporan->getActiveSheet()->setCellValue('L5','Penanggung Jawab');
		$laporan->getActiveSheet()->setCellValue('M5','Kondisi');
		$laporan->getActiveSheet()->setCellValue('M6','B/RR/RB');
		$laporan->getActiveSheet()->mergeCells('N5:N6');
		$laporan->getActiveSheet()->setCellValue('N5','Harga Saat ini');

		$laporan->getActiveSheet()->mergeCells('O5:O6');
		$laporan->getActiveSheet()->setCellValue('O5','Ket');

		// $laporan->getActiveSheet()->mergeCells('P4:P6');
		// $laporan->getActiveSheet()->setCellValue('P4','Label');

		$laporan->getActiveSheet()->freezePane('I7');

		$laporan->getActiveSheet()->setCellValue('B7','Perlengkapan & Peralatan');
		//--------------eo TABLE HEADER		
		
		//--------TABEL DATA
		$startrow	= 7;
		$row		= $startrow;
		for ($a = 0; $a < count($data); $a++) {
			$no			= $a+1;
			$katname	= $data[$a]['KatName'];
			$jns		= $data[$a]['JenisPerlengPeralatKatName'];
			$pejwbsi	= $data[$a]['PenanggungJawabSi'];
			$divps		= $data[$a]['DivisionAbbr'];
			$tglpr		= $data[$a]['TglPr'];
			$asetno		= $data[$a]['AssetNo'];
			$nodokpr	= $data[$a]['NoDokumenPr'];
			$nilaipr	= $data[$a]['NilaiPr'];
			$penyusutanps	= $data[$a]['PenyusutanPs'];
			$lokasi		= $data[$a]['LokasiName'];
			$kondisi	= $data[$a]['KondisiKodeSi'];
			$hargasi	= $data[$a]['HargaSi'];
			$ket		= $data[$a]['KeteranganSi'];
			
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $no);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $katname);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $jns);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $asetno);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $tglpr);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $nodokpr);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $nilaipr);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $penyusutanps);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $lokasi);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $divps);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $pejwbsi);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $kondisi);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $hargasi);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $ket);
			// $laporan->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $katname);				
			// $this->cellColor($laporan, $row, $colpg, $wpg);
			$row++;
		}
		
		$this->formatSheetLenglat($laporan);
	}
	
	function formatSheetLenglat($laporan) 
	{
		$letterarr	= array('','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
			'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
			'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ');
		$lastrow = $laporan->getActiveSheet()->getHighestRow();
		$laporan->getActiveSheet()->getColumnDimension('A')->setWidth(6);;
		$laporan->getActiveSheet()->getColumnDimension('B')->setWidth(34);
		$stcol	= 1;
		for ($i = 0; $i < 15; $i++) {			
			$stcollt	= $letterarr[$stcol];
			$laporan->getActiveSheet()->getColumnDimension($stcollt)->setWidth(12);
			$stcol++;
		}
		$laporan->getActiveSheet()->getStyle('A1:'.$stcollt.'6')->getFont()->setBold(true);
		$laporan->getActiveSheet()->getStyle('A4:'.$stcollt.'6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$laporan->getActiveSheet()->getStyle('A4:'.$stcollt.'6')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
		$laporan->getActiveSheet()->getStyle('A4:'.$stcollt.'6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    // $laporan->getActiveSheet()->getStyle('C8:'.$stcollt.$lastrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$laporan->getActiveSheet()->getStyle('A7:'.$stcollt.$lastrow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	}
	

}
