<?php
define('FPDF_FONTPATH','font/');
require_once("fpdf.php");	 

class PDF_MySQL_Table extends FPDF
{
var $ProcessingTable=false;
var $aCols=array();
var $TableX;
var $HeaderColor;
var $RowColors;
var $ColorIndex;
var $LineNo;
var $aCriteria = array();
var $PrevRow = array();
var $Tx=10;
var $aSubTotal=array();
var $aGrandTotal=array();
var $GrandTotalflg = 1;
var $SubTotalflg = 1;
var $sPageOrientation = 'P';
var $aHeaderX = array();
var $cellHeight = 5;
var $aTopLine = array();
var $aButtomLine = array();
var $aOperator = array('+','-','*','/','(', ')','=','>','<','<=','>=','!=','?',':');
var $mysqli;
var $CI;
var $__subtotaltext = "Sub Total ";
var $__grandtotaltext = "Grand Total : ";

function __construct() {
	parent::FPDF();
	
	$this->CI =& get_instance();

	$gldb		= $this->CI->config->item('gldb');
	$i			= $this->CI->session->userdata('CompanyID');
	$db			= $this->CI->load->database($gldb[$i]['dbglcfg'], TRUE);

	$this->link = mysqli_connect($db->hostname,$db->username,$db->password,$db->database);
	
	$sql = "select MillName from companymst";
	$query = mysqli_query($this->link, $sql);
	$row = mysqli_fetch_array($query);
	$this->CompanyName = $row['MillName'];
}

function setTextForSubTotalAndGrandTotal($st,$gt){
	$this->__subtotaltext =$st;
	$this->__grandtotaltext =$gt;
}

Function PageOrientation($Orientation) {
	$this->sPageOrientation = $Orientation;
	$this->FPDF($Orientation);
}

Function SetTitle($Title) {$this->Title = $Title;}

Function SetCompany($CompanyName) {$this->CompanyName = $CompanyName;}

Function SetPrevRow($data) {$this->PrevRow = $data;}

Function SetSubTotalBy($subtotal) {$this->aSubTotal = $subtotal;}

Function SetGrandTotal($total) {$this->aGrandTotal = $total;}

Function GrandTotalflg($GrandTotalflga) {$this->GrandTotalflg = $GrandTotalflga;}

Function SubTotalflg($SubTotalflga) {$this->SubTotalflg = $SubTotalflga;}

Function AddCriteria($f1,$w1,$f2,$w2){$this->aCriteria[]=array('f1'=>$f1,'w1'=>$w1,'f2'=>$f2,'w2'=>$w2);}

function PageTitle(){
	$this->SetFont('times','B',11);
	$this->SetX($this->Tx);
	if($this->sPageOrientation == 'P'){
		$this->Cell(140,4,$this->CompanyName,0,0,'L');
	}else{
		$this->Cell(230,4,$this->CompanyName,0,0,'L');
	}
	$this->SetFont('times','',9);
	$this->Cell(20,4,"Page    : " . $this->PageNo(),0,1,'L');
	$this->SetX($this->Tx);
	$this->SetFont('times','B',11);
	if($this->sPageOrientation == 'P'){
		$this->Cell(140,4,$this->Title,0,0,'L');
	}else{
		$this->Cell(230,4,$this->Title,0,0,'L');
	}
	$this->SetFont('times','',9);
	$this->Cell(20,4,"Printed : " . Date('Y-m-d / h:i:s'),0,1,'L');
	
	$this->Ln();
	$this->PageCriteria();
}

function PageCriteria(){
	$this->SetFont('times','B',10);
	$this->SetX($this->Tx);
	foreach($this->aCriteria as $i=>$criteria){
		$this->Cell($criteria['w1'], 4,$criteria['f1'],0,0,'L');
		$this->Cell(5, 4, " : " ,0,0,'L');
		$this->Cell($criteria['w2'], 4,$criteria['f2'],0,0,'L');
		$this->Ln();
	}
	$this->Ln();
}

function Header()
{
	//Print the table header if necessary
	if($this->ProcessingTable)
		$this->TableHeader();
}

function TableHeader(){
	$this->PageTitle();
	$this->SetFont('times','B',10);
	$this->SetX($this->TableX);
	$fill=!empty($this->HeaderColor);
	$hdrcnt = count($this->aHeaderX);
	$y = $this->GetY();
	
	if($fill)
		$this->SetFillColor($this->HeaderColor[0],$this->HeaderColor[1],$this->HeaderColor[2]);
	foreach($this->aCols as $i=>$col){
		if ($col['w']>0){
			$x = $this->GetX();
		 	if ($hdrcnt == 0){
				$this->Cell($col['w'],$this->cellHeight,$col['c'],1,0,'C',$fill);
				$this->Cell(1,$this->cellHeight);}
			else{
			 	if ($this->aHeaderX[$i]['c']=='') {
			 	    $this->SetxY($x,$y);
				 	$this->Cell($col['w'],$this->cellHeight * 2,$col['c'],1,0,'C',$fill);
					$this->Cell(1,$this->cellHeight * 2);}	
			 	 else{
			 	  	if ($this->aHeaderX[$i]['c']=='-1' or $this->aHeaderX[$i]['c']=='0'){
			 	  		$this->Cell($col['w'],$this->cellHeight,$col['c'],1,0,'C',$fill);
			 	  		if ($i == $j + $this->aHeaderX[$j]['m']-1) 
							$this->Cell(1,$this->cellHeight);}	
					else{ 
					 	$this->SetxY($x,$y);
			       	    $this->Cell($this->aHeaderX[$i]['w'],$this->cellHeight,$this->aHeaderX[$i]['c'],1,0,'C',$fill);
						$this->Cell(1,$this->cellHeight);
						$this->SetXY($x,$y+$this->cellHeight);
						$this->Cell($col['w'],$this->cellHeight,$col['c'],1,0,'C',$fill);
						$j = $i;
					}
				}
			 }
		}
	}
	$this->Ln();
}

function AddHeader($width=-1,$caption='',$align='C', $mergecol=2)
{
	$this->aHeaderX[]=array('c'=>$caption,'w'=>$width,'a'=>$align, 'm'=>$mergecol);
}

function AddCol($field=-1,$width=-1,$caption='',$align='L', $totalflg=0, $total=-1,$format='NO', $decpoint=0, $pagebreak=0)
{
	//Add a column to the table
	if($field==-1)
		$field=count($this->aCols);
		$this->aCols[]=array('f'=>$field,'c'=>$caption,'w'=>$width,'a'=>$align, 'st'=>$totalflg, 'total'=>$total,'fm'=>$format,'dp'=>$decpoint, 'pb'=>$pagebreak);
}

function Row($data)
{
	$this->SetX($this->TableX);
	$ci=$this->ColorIndex;
	$fill=!empty($this->RowColors[$ci]);
	if($fill)
		$this->SetFillColor($this->RowColors[$ci][0],$this->RowColors[$ci][1],$this->RowColors[$ci][2]);
	
	
	$i = count($this->aCols)-1; 	
	while ($i >= 0) {
		if ($this->aCols[$i]['st'] == 1 and $data[$i] != $this->PrevRow[$i] and $this->PrevRow[$i] != 'XX'){
			
			if($this->SubTotalflg==1)
				$this->SubTotal($i);
						
				if ($i==0) $this->Blank($data);
				if ($this->aCols[$i]['pb'] == 1) $this->AddPage();
		}
		else{
			if ($i>0 and ($this->aCols[$i]['st'] == 1 and $data[$i-1] != $this->PrevRow[$i-1] and $this->PrevRow[$i-1] != 'XX')){
				if($this->SubTotalflg==1)
					$this->SubTotal($i);
						
				if ($i==0) $this->Blank($data);
				if ($this->aCols[$i]['pb'] == 1) $this->AddPage();
			}
		}
			
		$i--;
	}
	$this->SetX($this->TableX);	
	foreach($this->aCols as $i=>$col){
 	 	$rumus = explode(',', $col['f']);
 	 	$strrumus = '';
		   
 	 	if (count($rumus) == 1) $TF = 'T';
 	 	else $TF = 'F';
 	 	
 	 	for ($r=0; $r<count($rumus); $r++){
 	 	 	if (in_array($rumus[$r],$this->aOperator) || is_numeric($rumus[$r]))
	 	 	 	$strrumus .= $rumus[$r]; 
 	 	 	else 
			   $strrumus .= '$data[' . $rumus[$r] . ']'; 
		}
		if ($TF == 'F') {
			eval("\$strrumus = \"$strrumus\";");
			eval("\$strrumus = $strrumus;");
			$nilai = $strrumus;}
		else
			$nilai = $data[$col['f']];

	 	
		if ($col['w'] > 0) {
		 	if ($col['st']==1){
				if ($data[$col['f']] == $this->PrevRow[$col['f']])
					$this->Cell($col['w'],4);
				else
					$this->Cell($col['w'],4,$this->FormatCetak($nilai,$col['fm'],$col['dp'],$col['w']),0,0,$col['a'],$fill);	
			}
		 	else
				$this->Cell($col['w'],4,$this->FormatCetak($nilai,$col['fm'],$col['dp'],$col['w']),0,0,$col['a'],$fill);

			if (count($this->aHeaderX)>0)
			{
				//if ($this->aHeaderX[$i]['c']=='' or $this->aHeaderX[$i]['c']=='-1') 
				if ($this->aHeaderX[$i]['c']=="" or $this->aHeaderX[$i]['c']=="0") 
					$this->Cell(1,4);
				else
					$a = 1;
			}
			else
				$this->Cell(1,4);
		}

		if ($TF == 'T') {
			if ($col['total'] > -1){
			 	for ($j=0; $j<count($this->aSubTotal); $j++){
					$this->aSubTotal[$j][$col['f']] += $nilai;
					}
				$this->aGrandTotal[$col['f']] += $nilai;	 	
			}
		}
	}
	
	$this->Ln();
	$this->ColorIndex=1-$ci;
}

function FormatCetak($value, $formatid='NO', $dp=0, $colw)
{
 	if ($formatid == 'NO') {
		return $this->Truncate($value, $colw);
	}
	else{
	 	if($formatid == 'ID'){
			$ribuan = '.';
			$koma = ',';
		}
	 	else{
	 		$ribuan = ',';
	 		$koma = '.';
		}
	 	
	 	return number_format($value,$dp,$ribuan,$koma);
	}
}
 
 function Truncate($value, $kolw){
	
	$lbr = $this->GetStringWidth($value);
	if ($lbr > $kolw){
		for ($i=1; $i<= strlen($value);$i++){
			$kata = substr($value,0,$i);
			$nlbr = $this->GetStringWidth($kata);
			if ($nlbr >= $kolw){
				$hasil = substr($value,0,$i-1);
				$i = strlen($value)+1;
			}
		}
	}
	else $hasil = $value;
	
	return $hasil;
 }
function SubTotal($kol){
 	$fill=!empty($this->HeaderColor);
	$this->SetX($this->TableX);	 
	$this->SetFont('times','B',9);
	$st = $this->aSubTotal[$kol];
	foreach($this->aCols as $i=>$col){
		$rumus = explode(',', $col['f']);
	 	$strrumus = '';
		   
 	 	if (count($rumus) == 1) $TF = 'T';
 	 	else $TF = 'F';
 	 	
 	 	for ($r=0; $r<count($rumus); $r++){
 	 	 	if (in_array($rumus[$r],$this->aOperator) || is_numeric($rumus[$r]))
	 	 	 	$strrumus .= $rumus[$r]; 
 	 	 	else 
			   $strrumus .= '$st[' . $rumus[$r] . ']'; 
		}
 	 	if ($TF == 'F') {
			//echo $strrumus;
			eval("\$strrumus = \"$strrumus\";");
			//echo "<br> 2-" . $strrumus;
			eval("\$strrumus = $strrumus;");
			//echo "<br> 3-" . $strrumus;
			$nilai = $strrumus;		}
		else
			$nilai = $this->aSubTotal[$kol][$col['f']];
			
	 	if ($col['w'] > 0){
		 	if ($col['total'] == -1){
		 	 	if (count($this->PrevRow) == 0) $JdlSubTotal = '';
		 	 	else $JdlSubTotal = $this->PrevRow[$col['f']];
		 	 	if ($i == $kol) $this->Cell($col['w'],5, $this->__subtotaltext . $JdlSubTotal,0,0,'L',$fill);
	   			else $this->Cell($col['w'],5);
			}
		 	else{
				$this->Cell($col['w'],5,$this->FormatCetak($nilai,$col['fm'],$col['dp'],$col['w']),1,0,$col['a'],$fill);
				$this->aSubTotal[$kol][$col['f']] = 0;
			}
			
			if (count($this->aHeaderX)>0) 
			{
				//if ($this->aHeaderX[$i]['c']=='' or $this->aHeaderX[$i]['c']=='-1') 
				if ($this->aHeaderX[$i]['c']=="" or $this->aHeaderX[$i]['c']=="0") 
					$this->Cell(1,4);
				else
					$a = 1;
			}
			else
				$this->Cell(1,5);
		}
		else{
			$this->aSubTotal[$kol][$col['f']] = 0;
		}
	}
		$this->Ln();
		$this->Cell(10,2);
		$this->Ln();	
		$this->SetFont('times','',9);
}

function GrandTotal($kol=0){
 	$fill=!empty($this->HeaderColor);
	$this->SetX($this->TableX);	 
	$this->SetFont('times','B',9);
	$st = $this->aGrandTotal;

	foreach($this->aCols as $i=>$col){
	 	$rumus = explode(',', $col['f']);
	 	$strrumus = '';
		   
 	 	if (count($rumus) == 1) $TF = 'T';
 	 	else $TF = 'F';
 	 	
 	 	for ($r=0; $r<count($rumus); $r++){
 	 	 	if (in_array($rumus[$r],$this->aOperator) || is_numeric($rumus[$r]))
	 	 	 	$strrumus .= $rumus[$r]; 
 	 	 	else 
			   $strrumus .= '$st[' . $rumus[$r] . ']'; 
		}
 	 	if ($TF == 'F') {
			eval("\$strrumus = \"$strrumus\";");
			eval("\$strrumus = $strrumus;");
			$nilai = $strrumus;}
		else {
		 	$nilai = $this->aGrandTotal[$col['f']];}
		
		if ($col['w'] > 0){	 
		 	if ($col['total'] == -1){
		 	 	if ($i == $kol) $this->Cell($col['w'],5, $this->__grandtotaltext,0,0,'L',$fill);
	   			else $this->Cell($col['w'],5);
			}
		 	else{
				$this->Cell($col['w'],5,$this->FormatCetak($nilai,$col['fm'],$col['dp'],$col['w']),1,0,$col['a'],$fill);
			}
			
			if (count($this->aHeaderX)>0)
			{
				//if ($this->aHeaderX[$i]['c']=='' or $this->aHeaderX[$i]['c']=='-1') 
				if ($this->aHeaderX[$i]['c']=="" or $this->aHeaderX[$i]['c']=="0") 
					$this->Cell(1,4);
				else
					$a = 1;
			}
			else
				$this->Cell(1,5);
		}
	}
	$this->Ln();		
	$this->SetFont('times','',9);
}

function AddTopLine($caption,$width,$align='L',$format='NO', $decpoint=0)
{
	$this->aTopLine[]=array('c'=>$caption,'w'=>$width,'a'=>$align, 'fm'=>$format,'dp'=>$decpoint);
}

function AddButtomLine($caption,$width,$align='L', $format='NO', $decpoint=0)
{
	$this->aButtomLine[]=array('c'=>$caption,'w'=>$width,'a'=>$align, 'fm'=>$format,'dp'=>$decpoint);
}

function PrintTopLine()
{
	$this->SetX($this->TableX);	
	foreach ($this->aTopLine as $i=>$tl)
	{
		$this->Cell($tl['w'],5, $this->FormatCetak($tl['c'],$tl['fm'],$tl['dp'],$tl['w']),0,0,$tl['a']);
	};
	$this->Ln();
	
}

function PrintButtomLine()
{
	$this->SetX($this->TableX);	
	foreach ($this->aButtomLine as $i=>$tl)
	{
		if ($tl['c']=='{CR}') 
			$this->Ln();
		elseif ($tl['c']=='{CRW}')
			$this->Ln('1');
		else
			$this->Cell($tl['w'],5, $this->FormatCetak($tl['c'],$tl['fm'],$tl['dp'],$tl['w']),0,0,$tl['a']);
	};
	$this->Ln();
}

function CalcWidths($width,$align)
{
	//Compute the widths of the columns
	$TableWidth=0;
	foreach($this->aCols as $i=>$col)
	{
		$w=$col['w'];
		if($w==-1)
			$w=$width/count($this->aCols);
		elseif(substr($w,-1)=='%')
			$w=$w/100*$width;
		$this->aCols[$i]['w']=$w;
		$TableWidth+=$w+1;
	}
	//Compute the abscissa of the tabletot
	if($align=='C')
		$this->TableX=max(($this->w-$TableWidth)/2,0);
	elseif($align=='R')
		$this->TableX=max($this->w-$this->rMargin-$TableWidth,0);
	else
		$this->TableX=$this->lMargin;
}

Function Blank($row){
	foreach($row as $i=>$r){
		$this->PrevRow[$i] = 'XX';
	}
 }

function Table($query, $prop=array())
{
	//Issue query
	$res = mysqli_query($this->link, $query) or die('Error: '.mysqli_error($this->link)."<BR>Query: $query");
	//Add all columns if none was specified
	if(count($this->aCols)==0)
	{
		$nb = mysqli_num_fields($res);
		for($i=0;$i<$nb;$i++)
			$this->AddCol();
	}
	//Retrieve column names when not specified
	foreach($this->aCols as $i=>$col)
	{
		if($col['c']=='')
		{
			if(is_string($col['f']))
				$this->aCols[$i]['c']=ucfirst($col['f']);
			else
				$this->aCols[$i]['c']=ucfirst(mysqli_field_name($res,$col['f']));
		}
	}
	//Handle properties
	if(!isset($prop['width']))
		$prop['width']=0;
	if($prop['width']==0)
		$prop['width']=$this->w-$this->lMargin-$this->rMargin;
	if(!isset($prop['align']))
		$prop['align']='C';
	if(!isset($prop['padding']))
		$prop['padding']=$this->cMargin;
		$cMargin=$this->cMargin;
		$this->cMargin=$prop['padding'];
	if(!isset($prop['HeaderColor']))
		$prop['HeaderColor']=array();
		$this->HeaderColor=$prop['HeaderColor'];
	if(!isset($prop['color1']))
		$prop['color1']=array();
	if(!isset($prop['color2']))
		$prop['color2']=array();
		$this->RowColors=array($prop['color1'],$prop['color2']);
	//Compute column widths
	$this->CalcWidths($prop['width'],$prop['align']);
	//Print header
	$this->TableHeader();
	//Print rows
	$this->SetFont('times','',9);
	$this->ColorIndex=0;
	$this->ProcessingTable=true;
	$first = 1 ;
	if (count($this->aTopLine) > 0) $this->PrintTopLine();
	while($row=mysqli_fetch_array($res)){
	 	if ($first == 1){
	 	    $this->Blank($row);
	 	 	$first = 0;
	 	 }
		$this->Row($row);
		$this->SetPrevRow($row);
	}
	
	$i = count($this->aCols)-1;
	while ($i >= 0) {
		if ($this->aCols[$i]['st'] == 1) {
			if($this->SubTotalflg==1) $this->SubTotal($i);
		}
		$i--;
	}
	
	if($this->GrandTotalflg==1){
		$this->GrandTotal();
	}	
	
	if (count($this->aButtomLine) > 0) $this->PrintButtomLine();
	$this->ProcessingTable=false;
	$this->cMargin=$cMargin;
	$this->aCols=array();
	mysqli_close($this->link);
}

function TableTemp($query, $prop=array())//function khusus, sama dengan table(), 
{//bedanya pake mysql biasa bukan mysqli biar bisa akses ke temporary table
	//Issue query
	mysqli_close($this->link);//tutup dulu koneksi yg pake mysqli yg ada di construct, biar bisa pake mysql_*
	$res = mysql_query($query);
	
	//Add all columns if none was specified
	if(count($this->aCols)==0)
	{
		$nb = mysql_num_fields($res);
		for($i=0;$i<$nb;$i++)
			$this->AddCol();
	}
	//Retrieve column names when not specified
	foreach($this->aCols as $i=>$col)
	{
		if($col['c']=='')
		{
			if(is_string($col['f']))
				$this->aCols[$i]['c']=ucfirst($col['f']);
			else
				$this->aCols[$i]['c']=ucfirst(mysql_field_name($res,$col['f']));
		}
	}
	//Handle properties
	if(!isset($prop['width']))
		$prop['width']=0;
	if($prop['width']==0)
		$prop['width']=$this->w-$this->lMargin-$this->rMargin;
	if(!isset($prop['align']))
		$prop['align']='C';
	if(!isset($prop['padding']))
		$prop['padding']=$this->cMargin;
		$cMargin=$this->cMargin;
		$this->cMargin=$prop['padding'];
	if(!isset($prop['HeaderColor']))
		$prop['HeaderColor']=array();
		$this->HeaderColor=$prop['HeaderColor'];
	if(!isset($prop['color1']))
		$prop['color1']=array();
	if(!isset($prop['color2']))
		$prop['color2']=array();
		$this->RowColors=array($prop['color1'],$prop['color2']);
	//Compute column widths
	$this->CalcWidths($prop['width'],$prop['align']);
	//Print header
	$this->TableHeader();
	//Print rows
	$this->SetFont('times','',9);
	$this->ColorIndex=0;
	$this->ProcessingTable=true;
	$first = 1 ;
	if (count($this->aTopLine) > 0) $this->PrintTopLine();
	while($row=mysql_fetch_array($res)){
	 	if ($first == 1){
	 	    $this->Blank($row);
	 	 	$first = 0;
	 	 }
		$this->Row($row);
		$this->SetPrevRow($row);
	}
	
	$i = count($this->aCols)-1;
	while ($i >= 0) {
		if ($this->aCols[$i]['st'] == 1) {
			if($this->SubTotalflg==1) $this->SubTotal($i);
		}
		$i--;
	}
	
	if($this->GrandTotalflg==1){
		$this->GrandTotal();
	}	
	
	if (count($this->aButtomLine) > 0) $this->PrintButtomLine();
	$this->ProcessingTable=false;
	$this->cMargin=$cMargin;
	$this->aCols=array();
}
}
?>