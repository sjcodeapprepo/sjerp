<?php
include(APPPATH.'/controllers/auth/authcontroller'.EXT);
class BlokRegister extends Authcontroller {

	function __construct() {
		parent::__construct();
		define("MENU_ID", "550");
		$userid = $this->session->userdata('UserID');
		$this->redirectNoAuthRead($userid,MENU_ID);
	}

	function index() {
		$this->load->view('akuntingaus/lapkebun/blokregister_index');
	}
	
	function getestdivblok() {
		$datasearch	= $this->input->post('keyword');
		list($tgldari, $tglsampai, $searchkey)	= explode("|", $datasearch);

        $sql	 = "SELECT 
					v.DivisionName, v.DivisionEstID, b.BlockID,
					CONCAT(d.DetailFlgID,' - ',YEAR(b.PlantDate)) AS BlockTT	
				FROM flddisttrn f, flddistdtlaccttrn d, blockmst b, divisionestmst v
				WHERE v.DivisionEstID=b.DivisionEstID AND d.DetailFlgID=b.BlockID AND f.FldDistID=d.FldDistID 
					AND f.StatusFlg=1
					AND CONCAT(v.DivisionName,' ',b.BlockID) LIKE '%$searchkey%'
					AND f.DistDate BETWEEN '$tgldari' AND '$tglsampai'
				GROUP BY b.BlockID
				ORDER BY v.DivisionName, b.BlockID";
		
        $query	 = $this->db->query($sql);
        $details = $query->result_array();
		foreach ($details as $row) {
			
			$estdivblok			= $row['DivisionName'].' - '.$row['BlockTT'];
			$valueid_implode	= $row['BlockID'].'|'.$row['DivisionEstID'];
			$retval['results'][]	= array(
										'text'	=> $estdivblok,
										'id'	=> $valueid_implode
									);
		}
		echo json_encode ($retval);
	}

	function proses() {
		$dari		= $this->input->post('daritgl');
		$sampai		= $this->input->post('sampaitgl');
		$estdivblok	= $this->input->post('estdivblok');
		$format		= $this->input->post('submit');
		list($blockid, $divestid)	= explode("|", $estdivblok);
		
		if($format=='XL') {
			$this->_blockregisterinxl($blockid, $divestid, $dari, $sampai);
		} else {
			$this->_blockregisterinhtml($blockid, $divestid, $dari, $sampai);
		}
	}
	
	function _blockregisterinxl($blockid, $divestid, $dari, $sampai) {
		$this->load->library('excel');
		$laporan	= $this->excel;
		$this->load->model('general_model');
		
		$blockdata	= $this->_getblock($blockid);
		$blockidtt	= $blockid.' - '.$blockdata['thntnm'];
		$tt			= $blockdata['thntnm'];
		$divest		= $blockdata['DivisionName'];
		$ltnm		= $blockdata['LuasTanam'];
		$brutto		= $blockdata['TotalHA'];
		$sph		= $blockdata['PokokPerHa'];
		$data		= $this->_getdatadist($blockid, $dari, $sampai);
				
		$companyname	= $this->general_model->companyname();
		$laporan->getActiveSheet()->setCellValue('A1', $companyname);
		$laporan->getActiveSheet()->setCellValue('A2', 'Blok Register');
		
		$laporan->getActiveSheet()->setCellValue('A3', 'Blok');
		$laporan->getActiveSheet()->setCellValue('B3', $blockid);
		$laporan->getActiveSheet()->setCellValue('A4', 'Tahun Tanam');
		$laporan->getActiveSheet()->setCellValue('B4', $tt);
		$laporan->getActiveSheet()->setCellValue('A5', 'Divisi');
		$laporan->getActiveSheet()->setCellValue('B5', $divest);
		$laporan->getActiveSheet()->setCellValue('A6', 'Luas Tanam');
		$laporan->getActiveSheet()->setCellValue('B6', $ltnm);
		$laporan->getActiveSheet()->setCellValue('A7', 'Luas Brutto');
		$laporan->getActiveSheet()->setCellValue('B7', $brutto);
		$laporan->getActiveSheet()->setCellValue('A8', 'Pokok/Ha ');
		$laporan->getActiveSheet()->setCellValue('B8', $sph);
		
		$laporan->getActiveSheet()->setCellValue('A10', 'Kegiatan');
		$laporan->getActiveSheet()->setCellValue('B10', 'Tanggal');
		$laporan->getActiveSheet()->setCellValue('C10', 'Qty');
		$laporan->getActiveSheet()->setCellValue('D10', 'Sat');
		$laporan->getActiveSheet()->setCellValue('E10', 'HK (Rp)');
		$laporan->getActiveSheet()->setCellValue('F10', 'Bahan (Rp)');
		$laporan->getActiveSheet()->setCellValue('G10', 'Total (Rp)');
		
		$acctid_before	= '000';
		$row			= 11;
		$firstrow		= $row;
		$stfirstrow		= $row;
		$sameacct		= 1;
		for($a=0 ; $a<count($data); $a++) { 
			$issubtotal	= false;
			
			$acctid		= $data[$a]['AcctID'];
			$kegiatan	= $acctid. ' - '.$data[$a]['AcctName'];
			$tgl		= $data[$a]['Tgl'];
			$qty		= $data[$a]['Qty'];
			$sat		= $data[$a]['UOMID'];
			$hkrp		= $data[$a]['HKAmt'];
			$bhnrp		= $data[$a]['BhnAmt'];
			
			if($acctid_before == $acctid) {
				$kegiatan	= '';
				$sameacct++;
			} else {
				$stfirstrow		= $row;
			}
			
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $kegiatan);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $tgl);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $qty);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $sat);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $hkrp);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $bhnrp);
			$laporan->getActiveSheet()->setCellValueByColumnAndRow(6, $row, '=E'.$row.'+F'.$row);
			
			$acctid_before	= $acctid;
			$row++;
			
			$nextind	= $a+1;
			$nextacctid	= (isset($data[$nextind]['AcctID']))?$data[$nextind]['AcctID']:'000';
			if($acctid != $nextacctid AND ($sameacct>1)) {
				$issubtotal = true;
			}
			
			if($issubtotal) {
				$stlastrow		= $row-1;
				$subtotformula	= '=SUBTOTAL(9,G'.$stfirstrow.':G'.$stlastrow.')';
				$laporan->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 'Sub Total');
				$laporan->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $subtotformula);
				$laporan->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFont()->setBold(true);
				$row++;
				$sameacct		= 1;
			}
			
		}
		$lastrow		= $row-1;
		$totrpformula	= '=SUBTOTAL(9,G'.$firstrow.':G'.$lastrow.')';
		$laporan->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 'Total');
		$laporan->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $totrpformula);
		
		$this->_formatsheet($laporan, $lastrow);
		
		$filename = 'lap_blockregister.xls';	
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($laporan, 'Excel5'); 
		$objWriter->save('php://output');
	}
	
	function _blockregisterinhtml($blockid, $divestid, $dari, $sampai) {
		$this->load->helper('text');
		$blockdata			= $this->_getblock($blockid);
		$data['dari']		= $dari;
		$data['sampai']		= $sampai;
		$data['blockid']		= $blockid;
		$data['tt']			= $blockdata['thntnm'];
		$data['divest']		= $blockdata['DivisionName'];
		$data['ltnm']		= $blockdata['LuasTanam'];
		$data['brutto']		= $blockdata['TotalHA'];
		$data['sph']		= $blockdata['PokokPerHa'];
		$data['data']		= $this->_getdatadist($blockid, $dari, $sampai);
		$this->load->view('akuntingaus/lapkebun/blokregister_viewhtml',$data);
	}
	
	function _getdatadist($blockid, $dari, $sampai) {
		/* unused
		$sql	= "SELECT 
						d.AcctID, coa.AcctName, f.DistDate, SUM(d.UnitQty+d.LabUnitQty) AS qty, coa.UOMID, 
						SUM(d.AllDedAmt+d.LabContractAmt+d.MandaysAmt+d.OTAmt) AS amt
					FROM flddisttrn f, flddistdtlaccttrn d, blockmst b, coamst coa
					WHERE d.DetailFlgID=b.BlockID AND f.FldDistID=d.FldDistID 
						AND f.DistDate BETWEEN '$dari' AND '$sampai' AND f.StatusFlg=1
						AND coa.AcctID=d.AcctID
						AND d.DetailFlgID='$blockid'
					GROUP BY d.AcctID, f.DistDate
					ORDER BY d.AcctID, f.DistDate";
		
		$sql2	= "SELECT 
						d.AcctID, coa.AcctName, 
						i.InvTransDate,
						SUM(d.ItemCost) AS totcost
					FROM invtransaction i, invtransactiondetail d, blockmst b, coamst coa
					WHERE i.InvTransID=d.InvTransID AND i.StatusFlg=1 
						AND d.DetailFlgID=b.BlockID AND coa.AcctID=d.AcctID
						AND d.DetailFlgID='B01'
						AND i.InvTransDate BETWEEN '2018-01-01' AND '2018-12-31'
					GROUP BY d.AcctID, i.InvTransDate, d.DetailFlgID
					ORDER BY d.AcctID, i.InvTransDate, d.DetailFlgID";
		*/
		$sql3	= "SELECT coa.AcctID, coa.AcctName, t.Tgl, 
						SUM(t.Qty) AS Qty, coa.UOMID, SUM(t.HKamt) AS HKAmt,
						SUM(t.BhnAmt) AS BhnAmt
					FROM (
						SELECT 
							fd.AcctID, fd.DetailFlgID, f.DistDate AS Tgl, 
							(fd.UnitQty) AS Qty, (fd.AllDedAmt+fd.LabContractAmt+fd.MandaysAmt+fd.OTAmt) AS HKamt, 
							0 AS BhnAmt
						FROM flddisttrn f, flddistdtlaccttrn fd
						WHERE f.FldDistID=fd.FldDistID AND f.StatusFlg=1 
							AND fd.DetailFlgID='$blockid' 
							AND f.DistDate BETWEEN '$dari' AND '$sampai'
											UNION ALL
						SELECT 
							id.AcctID, id.DetailFlgID, i.InvTransDate AS Tgl, 
							0 AS Qty, 0 AS HKamt, 
							id.ItemCost AS BhnAmt
						FROM invtransaction i, invtransactiondetail id
						WHERE i.InvTransID=id.InvTransID AND i.StatusFlg=1 
							AND id.DetailFlgID='$blockid'
							AND i.InvTransDate BETWEEN '$dari' AND '$sampai'
					) t, blockmst b, ( SELECT cl.AcctID, cl.AcctName, cl.UOMID  FROM coamst cl UNION ALL SELECT cn.AcctID, cn.AcctName, cn.UOMID FROM coanewmst cn) coa
					WHERE coa.AcctID=t.AcctID AND t.DetailFlgID=b.BlockID
					GROUP BY t.AcctID, t.Tgl
					ORDER BY t.AcctID, t.Tgl";	
		$query	 = $this->db->query($sql3);
        $details = $query->result_array();
		return $details;
	}
	
	function _getblock($blockid) {
		$sql	= "SELECT b.BlockID, Year(b.PlantDate) as thntnm, b.PokokPerHa, b.LuasTanam, b.TotalHA, d.DivisionName from blockmst b, divisionestmst d "
			. "where b.blockid='$blockid' and b.DivisionEstID=d.DivisionEstID";
		$query	 = $this->db->query($sql);
        $details = $query->result_array();
		return $details[0];
	}
	
	function _formatsheet($laporan, $lastrow) {
		$lastrow++;
		$lcol			= array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P'
			,'Q','R','S','T','U','V','W','X','Y','Z',
			'AA','AB','AC','AD','AE','AF','AG','AH');
		$numberFormat		= '_(* #,##0.00_);_(* (#,##0.00);_(* "-"_);_(@_)';
		$numberFormat2		= '_(* #,##_);_(* (#,##);_(* "-"_);_(@_)';
		$laporan->getActiveSheet()->getStyle('C11:C'.$lastrow)->getNumberFormat()->setFormatCode($numberFormat);
		$laporan->getActiveSheet()->getStyle('E11:G'.$lastrow)->getNumberFormat()->setFormatCode($numberFormat2);
		
		$laporan->getActiveSheet()->getColumnDimension('A')->setWidth(48);
		$laporan->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$laporan->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$laporan->getActiveSheet()->getColumnDimension('D')->setWidth(6);
		$laporan->getActiveSheet()->getColumnDimension('E')->setWidth(12);
		$laporan->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		$laporan->getActiveSheet()->getColumnDimension('G')->setWidth(12);
		
		$laporan->getActiveSheet()->getStyle('A1:G10')->getFont()->setBold(true);
		$laporan->getActiveSheet()->getStyle('A10:G10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$laporan->getActiveSheet()->getStyle('A10:G10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);		
		$laporan->getActiveSheet()->getStyle('A10:G10')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
		
		$laporan->getActiveSheet()->getStyle('A'.$lastrow.':G'.$lastrow)->getFont()->setBold(true);
	}
	
	function _process_inhtml($tahunkerja, $estid='A') {
		$data['datarea']	= $this->_getdataarea($tahunkerja, $estid);
		$data['tahunkerja']	= $tahunkerja;
		$this->load->view('budget/laparealstatement_html', $data);
	}
	
	function getCompanyDetail() {
		$sql = "SELECT c.CompanyName, c.MillName FROM companymst c";
        $qry = $this->db->query($sql);
		$row = $qry->result_array();
		return $row[0];
	}
	
	public function testing($accttanam, $tahun, $bulanawal, $bulanakhir) {
		$a	= $this->_getSetDataBiaya($accttanam, $tahun, $bulanawal, $bulanakhir);
		print_array($a);
	}
}