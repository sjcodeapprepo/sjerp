<?php
include(APPPATH.'/controllers/auth/authcontroller'.EXT);
class ListAset extends Authcontroller {

	function __construct() {
		parent::__construct();
		define("MENU_ID", "100");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid,MENU_ID);
	}

	function index() {
		$this->load->view('sjasetview/asetreport/listaset_index');
	}
	
	function xlslist() {
		$submit		= $this->input->post('submit');
		$gol		= $this->input->post('golaset');
		
		if($submit=='.XLS') {
			$this->load->library('excel');
			$laporan	= $this->excel;			
			
			if($gol=='03') {
				$golstr	= '_perlengkapan_peralatan';
				$this->_lenglat($laporan);
			} else if($gol=='04') {
				$golstr	= '_elektrn_mesin';
				$this->_lenglat($laporan);
			}
			
			$filename = 'listaset'.$golstr.'.xls';	
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($laporan, 'Excel5'); 
			$objWriter->save('php://output');
		}
	}

	function _getDataPerlengkapanperalatan() {
		$sql = "SELECT 
					m.ItemID, m.AssetNo, mk.KatName, mj.JenisPerlengPeralatKatName, md.DivisionAbbr, d.PenanggungJawabSi
				FROM 
					itemmaster m, itemperlengperalatdetail d, itemkatmaster mk, itemdivisionmaster md, itemjenisperlengperalatkatmaster mj 
				WHERE 
					m.ItemID=d.ItemID AND d.JenisPerlengPeralatKatID=mj.JenisPerlengPeralatKatID AND d.DivisionIDPs=md.DivisionID
					AND m.GolID=mk.GolID AND m.KatID=mk.KatID AND m.GolID='03'
				ORDER BY m.ItemID DESC, m.AssetNo DESC";		

		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

    function _lenglat($laporan) {
		$myWorkSheet	= new PHPExcel_Worksheet($laporan, 'Perlengkapan dan Peralatan');
		$laporan->addSheet($myWorkSheet, 0);
		$laporan->setActiveSheetIndex(0);
		
		$data= $this->_getDataPerlengkapanperalatan();
		
		//-------JUDUL
		$laporan->getActiveSheet()->setCellValue('A1','Perumda Sarana Jaya');
		$laporan->getActiveSheet()->setCellValue('A2','List Aset Golongan Perlengkapan dan Peralatan');
		//-------------TABEL HEADER
		$laporan->getActiveSheet()->mergeCells('A5:A7');
		$laporan->getActiveSheet()->setCellValue('A5','No');
		$laporan->getActiveSheet()->mergeCells('B5:B7');
		$laporan->getActiveSheet()->setCellValue('B5','Nama Karyawan');
		$laporan->getActiveSheet()->setCellValue('C5','Jam Absen');
		$laporan->getActiveSheet()->freezePane('C8');
		//--------------eo TABLE HEADER		
		
		//--------TABEL DATA
		$startrow	= 8;
		$row		= $startrow;
		for ($a = 0; $a < count($data); $a++) {
			$no		= $a+1;
			$noaset	= $data[$a]['AssetNo'];
			// $nama	= $data[$a]['KatName'];
			
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $no);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $noaset);
			
				
			// $this->cellColor($laporan, $row, $colpg, $wpg);
			$row++;
		}
		
		// $this->formatSheetemp($laporan, $lastcol);
	}
	
	function formatSheetemp($laporan, $lastcol) {
		$letterarr	= array('','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
			'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
			'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ');
		$lastrow = $laporan->getActiveSheet()->getHighestRow();
		$laporan->getActiveSheet()->getColumnDimension('A')->setWidth(6);;
		$laporan->getActiveSheet()->getColumnDimension('B')->setWidth(34);
		$stcol	= 3;
		for ($i = 0; $i < ($lastcol-1); $i++) {			
			$stcollt	= $letterarr[$stcol];
			$laporan->getActiveSheet()->getColumnDimension($stcollt)->setWidth(8);
			$stcol++;
		}
		$laporan->getActiveSheet()->getStyle('A1:'.$stcollt.'7')->getFont()->setBold(true);
		$laporan->getActiveSheet()->getStyle('A5:'.$stcollt.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$laporan->getActiveSheet()->getStyle('A5:'.$stcollt.'7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
		$laporan->getActiveSheet()->getStyle('A5:'.$stcollt.'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $laporan->getActiveSheet()->getStyle('C8:'.$stcollt.$lastrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$laporan->getActiveSheet()->getStyle('A8:'.$stcollt.$lastrow)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	}
	

}
