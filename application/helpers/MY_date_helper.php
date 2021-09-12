<?php

function indDate_to_mysqldate ($indDate){
	$datepiece = explode("-", $indDate);
	return $datepiece[2]."-".$datepiece[1]."-".$datepiece[0];
}

function mysql_to_indDate($mysqldate){
	if(($mysqldate == '0000-00-00') || ($mysqldate == '0')) return '';
	elseif(($mysqldate == '') || ($mysqldate == ' ')) return '';
	else{
		$datepiece = explode("-", $mysqldate);
		return $datepiece[2]."-".$datepiece[1]."-".$datepiece[0];
	}
}

function localDate($mysqldate,$shortmonthname=FALSE){
	if(is_null($mysqldate) || ($mysqldate=='0000-00-00')){
		return " ";
	}
	else {
		$datepiece = explode("-", $mysqldate);
		if($datepiece[1]=='01'){
			$namabulan = 'Januari';
			if($shortmonthname) $namabulan = 'Jan';
		}elseif($datepiece[1]=='02'){
			$namabulan = 'Februari';
			if($shortmonthname) $namabulan = 'Feb';
		}elseif($datepiece[1]=='03'){
			$namabulan = 'Maret';
			if($shortmonthname) $namabulan = 'Mar';
		}elseif($datepiece[1]=='04'){
			$namabulan = 'April';
			if($shortmonthname) $namabulan = 'Apr';
		}elseif($datepiece[1]=='05'){
			$namabulan = 'Mei';
		}elseif($datepiece[1]=='06'){
			$namabulan = 'Juni';
			if($shortmonthname) $namabulan = 'Jun';
		}elseif($datepiece[1]=='07'){
			$namabulan = 'Juli';
			if($shortmonthname) $namabulan = 'Jul';
		}elseif($datepiece[1]=='08'){
			$namabulan = 'Agustus';
			if($shortmonthname) $namabulan = 'Agt';
		}elseif($datepiece[1]=='09'){
			$namabulan = 'September';
			if($shortmonthname) $namabulan = 'Sep';
		}elseif($datepiece[1]=='10'){
			$namabulan = 'Oktober';
			if($shortmonthname) $namabulan = 'Okt';
		}elseif($datepiece[1]=='11'){
			$namabulan = 'November';
			if($shortmonthname) $namabulan = 'Nov';
		}elseif($datepiece[1]=='12'){
			$namabulan = 'Desember';
			if($shortmonthname) $namabulan = 'Des';
		}
		return $datepiece[2]." ".$namabulan." ".$datepiece[0];
	}
}

function timeForm($mysqltime){
    $datepiece = explode(":", $mysqltime);
    return $datepiece[0].":".$datepiece[1];
}

function indMonthName($month,$shortmonthname=FALSE){
	if($month=="01" || $month=="1"){
		$monthname = "Januari";
		if($shortmonthname) $monthname = 'Jan';
	}
	elseif($month=="02" || $month=="2"){
		$monthname = "Februari";
		if($shortmonthname) $monthname = 'Feb';
	}
	elseif($month=="03" || $month=="3"){
		$monthname = "Maret";
		if($shortmonthname) $monthname = 'Mar';
	}
	elseif($month=="04" || $month=="4"){
		$monthname = "April";
		if($shortmonthname) $monthname = 'Apr';
	}
	elseif($month=="05" || $month=="5"){
		$monthname = "Mei";
		if($shortmonthname) $monthname = 'Mei';
	}
	elseif($month=="06" || $month=="6"){
		$monthname = "Juni";
		if($shortmonthname) $monthname = 'Jun';
	}
	elseif($month=="07" || $month=="7"){
		$monthname = "Juli";
		if($shortmonthname) $monthname = 'Jul';
	}
	elseif($month=="08" || $month=="8"){
		$monthname = "Agustus";
		if($shortmonthname) $monthname = 'Agt';
	}
	elseif($month=="09" || $month=="9"){
		$monthname = "September";
		if($shortmonthname) $monthname = 'Sep';
	}
	elseif($month=="10"){
		$monthname = "Oktober";
		if($shortmonthname) $monthname = 'Okt';
	}
	elseif($month=="11"){
		$monthname = "November";
		if($shortmonthname) $monthname = 'Nov';
	}	
	elseif($month=="12"){
		$monthname = "Desember";
		if($shortmonthname) $monthname = 'Des';
	}
	else $monthname = "WRONG MONTH FORMAT";
	
	return $monthname;
}

function getMonthName($month,$countryformat='US',$shortmonthname=FALSE){
	$monthname = array('January','February','March','April','May','June','July','August','September','October','November','December');
	if($shortmonthname){
		$monthname = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Agt','Sept','Okt','Nov','Dec');
	}
	if($countryformat=='ID'){
		$monthname = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		if($shortmonthname){
			$monthname = array('Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sept','Okt','Nov','Des');
		}
	}
	return $monthname[$month-1];
}

/*
 * untuk tau tgl berpa setelah hari ke n dari tgl mulai.
 *
 */
function dateAfterDay($mulai, $daycount){
	list($mulaiyear, $mulaimonth, $mulaiday) = explode("-", $mulai);
	return $tglselanjutnya  = date("Y-m-d", mktime(0, 0, 0, $mulaimonth , $mulaiday+$daycount, $mulaiyear));
}
/*
 * untuk ngitung berapa hari antara dua tanggal
 *
 */
function __dayDiff($mulai,$akhir){
	list($mulaiyear, $mulaimonth, $mulaiday) = explode("-", $mulai);
	list($akhiryear,$akhirmonth, $akhirday) = explode("-", $akhir);
	$a = gregoriantojd($mulaimonth, $mulaiday, $mulaiyear);
	$b = gregoriantojd($akhirmonth, $akhirday, $akhiryear);
	$c = $b - $a;
	return $c;
}
/*
 * untuk ngeluarin array yg isinya beberapa bulan terkahir.
 * hari nya bisa dipilih untuk tgl terakhir atau tgl 1
 */
function getLastNMonths($start_or_end_day='s', $n=4){
	$today  = mktime(0, 0, 0, date("m")+1,0, date("Y"));
	if($startorend=='s')
		$today  = mktime(0, 0, 0, date("m"),1, date("Y"));
	$arraydate[0]['mthval']	= date("Y-m-d",$today);
	$arraydate[0]['mthname']=date("M Y",$today);
	for($i=1;$i<=$n;$i++){
		$today  = mktime(0, 0, 0, date("m")+1-$i,0, date("Y"));
		if($startorend=='start')
			$today  = mktime(0, 0, 0, date("m")-$i,1, date("Y"));
		$arraydate[$i]['mthval']	= date("Y-m-d",$today);
		$arraydate[$i]['mthname']	= date("M Y",$today);
	}
	return $arraydate;
}
/*
 * untuk ngitung berapa bulan antara dua tanggal
 */
function monthdiff($firstdate, $seconddate){
	list($firstyear, $firstmonth, $firstday) = explode("-", $firstdate);
	list($secondyear, $secondmonth, $secondday) = explode("-", $seconddate);
	$diff = ((($secondyear - $firstyear) * 12) + $secondmonth) - $firstmonth;
	return $diff;
}

function indMonthList(){
	$monthnames = array (
						array(
								'MthID' => '1',
								'MthwzeroID' => '01',
								'MthName'=>'January',
								'MthIndName'=>'Januari'
						),
						array(
								'MthID' => '2',
								'MthwzeroID' => '02',
								'MthName'=>'February',
								'MthIndName'=>'Februari'
						),
						array(
								'MthID' => '3',
								'MthwzeroID' => '03',
								'MthName'=>'March',
								'MthIndName'=>'Maret'
						),
						array(
								'MthID' => '4',
								'MthwzeroID' => '04',
								'MthName'=>'April',
								'MthIndName'=>'April'
						),
						array(
								'MthID' => '5',
								'MthwzeroID' => '05',
								'MthName'=>'May',
								'MthIndName'=>'Mei'
						),
						array(
								'MthID' => '6',
								'MthwzeroID' => '06',
								'MthName'=>'June',
								'MthIndName'=>'Juni'
						),
						array(
								'MthID' => '7',
								'MthwzeroID' => '07',
								'MthName'=>'July',
								'MthIndName'=>'Juli'
						),
						array(
								'MthID' => '8',
								'MthwzeroID' => '08',
								'MthName'=>'August',
								'MthIndName'=>'Agustus'
						),
						array(
								'MthID' => '9',
								'MthwzeroID' => '09',
								'MthName'=>'September',
								'MthIndName'=>'September'
						),
						array(
								'MthID' => '10',
								'MthwzeroID' => '10',
								'MthName'=>'October',
								'MthIndName'=>'Oktober'
						),
						array(
								'MthID' => '11',
								'MthwzeroID' => '11',
								'MthName'=>'November',
								'MthIndName'=>'November'
						),
						array(
								'MthID' => '12',
								'MthwzeroID' => '12',
								'MthName'=>'December',
								'MthIndName'=>'Desember'
						)
	);
	return $monthnames;
}

?>
