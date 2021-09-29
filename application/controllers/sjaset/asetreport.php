<?php
include(APPPATH.'/controllers/auth/authcontroller'.EXT);
class AsetReport extends Authcontroller {

	function __construct() {
		parent::__construct();
		define("MENU_ID", "579");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid,MENU_ID);
	}

	function index() {
		$this->load->view('asetreport/aset_index');
	}
	
	function generatexls() {
		$submit		= $this->input->post('submit');
		$drtgl		= $this->input->post('drtgl');
		$smptgl		= $this->input->post('smptgl');
		
		if($submit=='XLS') {
			$this->load->library('excel');
			$laporan	= $this->excel;			
			
			$this->_allemp($laporan, $drtgl, $smptgl);			
			
			$filename = 'absenwfh.xls';	
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($laporan, 'Excel5'); 
			$objWriter->save('php://output');
		}
	}

    function _allemp($laporan, $drtgl, $smptgl) {
		$myWorkSheet	= new PHPExcel_Worksheet($laporan, 'Absen WFH');
		$laporan->addSheet($myWorkSheet, 0);
		$laporan->setActiveSheetIndex(0);
		
		$data		= $this->_getAllEmpData($drtgl, $smptgl);
		$tgldata	= $this->_getTglData($data, $drtgl, $smptgl);
		$emparr		= $this->_getListEmp($drtgl, $smptgl);
		$lastcol	= (count($tgldata) * 3) + 1;
		//-------JUDUL
		$laporan->getActiveSheet()->setCellValue('A1','PT Arjuna Utama Sawit');
		$laporan->getActiveSheet()->setCellValue('A2','Absen WFH');
		$laporan->getActiveSheet()->setCellValue('A3',$this->_getperiode($drtgl, $smptgl));
		//-------------TABEL HEADER
		$laporan->getActiveSheet()->mergeCells('A5:A7');
		$laporan->getActiveSheet()->setCellValue('A5','No');
		$laporan->getActiveSheet()->mergeCells('B5:B7');
		$laporan->getActiveSheet()->setCellValue('B5','Nama Karyawan');
		$laporan->getActiveSheet()->mergeCellsByColumnAndRow(2, 5, $lastcol, 5);
		$laporan->getActiveSheet()->setCellValue('C5','Jam Absen');
		$laporan->getActiveSheet()->freezePane('C8');
		for ($c = 0; $c < count($tgldata); $c++) {
			$colpg	= $tgldata[$c]['colpg'];
			$colsg	= $tgldata[$c]['colsg'];
			$colsr	= $tgldata[$c]['colsr'];
			$tglidn	= $tgldata[$c]['TglIndo'];
			
			$laporan->getActiveSheet()->mergeCellsByColumnAndRow($colpg, 6, $colsr, 6);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow($colpg, 6, $tglidn);

			$laporan->getActiveSheet()->setCellValueByColumnAndRow($colpg, 7, 'Pagi');
			$laporan->getActiveSheet()->setCellValueByColumnAndRow($colsg, 7, 'Siang');
			$laporan->getActiveSheet()->setCellValueByColumnAndRow($colsr, 7, 'Sore');			
		}
		//--------------eo TABLE HEADER		
		
		//--------TABEL DATA
		$startrow	= 8;
		$row		= $startrow;
		for ($a = 0; $a < count($emparr); $a++) {
			$no		= $a+1;
			$idemp	= $emparr[$a]['EmpEmailID'];
			$nama	= $emparr[$a]['NamaKaryawan'];
			
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $no);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $nama);
			
			for ($b = 0; $b < count($tgldata); $b++) {
				$colpg	= $tgldata[$b]['colpg'];
				$colsg	= $tgldata[$b]['colsg'];
				$colsr	= $tgldata[$b]['colsr'];
				$bln	= $tgldata[$b]['Bln'];
				$tgl	= $tgldata[$b]['Tgl'];
				
				$pg		= isset($data[$bln][$tgl][$idemp]['pg'])?$data[$bln][$tgl][$idemp]['pg']:'-';
				$sg		= isset($data[$bln][$tgl][$idemp]['sg'])?$data[$bln][$tgl][$idemp]['sg']:'-';
				$sr		= isset($data[$bln][$tgl][$idemp]['sr'])?$data[$bln][$tgl][$idemp]['sr']:'-';
				
				$wpg	= isset($data[$bln][$tgl][$idemp]['wpg'])?$data[$bln][$tgl][$idemp]['wpg']:'FF0000';
				$wsg	= isset($data[$bln][$tgl][$idemp]['wsg'])?$data[$bln][$tgl][$idemp]['wsg']:'FF0000';
				$wsr	= isset($data[$bln][$tgl][$idemp]['wsr'])?$data[$bln][$tgl][$idemp]['wsr']:'FF0000';
				
				$laporan->getActiveSheet()->setCellValueByColumnAndRow($colpg, $row, $pg);
				$laporan->getActiveSheet()->setCellValueByColumnAndRow($colsg, $row, $sg);
				$laporan->getActiveSheet()->setCellValueByColumnAndRow($colsr, $row, $sr);
				
				$this->cellColor($laporan, $row, $colpg, $wpg);
				$this->cellColor($laporan, $row, $colsg, $wsg);
				$this->cellColor($laporan, $row, $colsr, $wsr);
			}
			
			$row++;
		}
		
		$this->formatSheetemp($laporan, $lastcol);
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
