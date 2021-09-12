<?php 
function spaceadj($word, $length=10){
    $space2 = ' ';
    for($i=0;$i<$length-strlen($word);$i++) {
    	$space2 .= ' ';
    }
    return $space2;
}

function alignleft($word, $length=10){
    $space2 = ' ';
    for($i=0;$i<$length-strlen($word);$i++) {
    	$space2 .= ' ';
    }
    return $word.$space2;
}

function aligncenter($word, $length=10){
	$half = round(($length-strlen($word)) / 2);
    $space2 = ' ';
    for($i=0;$i<$half;$i++) {
    	$space2 .= ' ';
    }
    return $space2.$word.$space2;
}

function alignright($str,$length=20){
	$space2 = ' ';
    for($i=0;$i<$length-strlen($str); $i++) {
    	$space2 .= ' ';
    }
    return $space2.$str;
}

function aschr($ascii, $iteration=1){
	$char = chr($ascii);
	for($i=1; $i<$iteration; $i++) {
    	$char .= chr($ascii);
    }
    return $char;
}

function spc($iteration){
	$char = " ";
	for($i=0; $i<$iteration; $i++) {
    	$char .= " ";
    }
    return $char;
}

function format_satu($value){
	$value = number_format($value, 1, '.', ',');
	if(substr($value,-1)=='0'){
		$value = substr($value,0,-2);
	}
	return $value;
}

function format_dua($value){
	$value = number_format($value, 0, '.', '');
	return $value;
}

function format_tiga($value) {
	$value = number_format($value, 0, ',', '.');
	return $value;
}

function format_empat($value) {
	$value = number_format($value, 0, ',', '');
	return $value;
}
	
function putNewLine($str,$width=55){
	$c	= array();
	$b = explode(" ", $str);
	for($i=0; $i<count($b); $i++) {
		if(!($b[$i]==""))$c[]=$b[$i];
	}
	$text = implode(" ", $c);
	$wraptext = wordwrap($text, $width, "-");
	$d=explode("-", $wraptext);
	return $d;
}

function createTerbilang($total){
	$a = terbilangFormat($total)." rupiah";
	$a = explode("  ", $a);
	$retval='';
	for ($i= 0; $i< count($a); $i++) {
		$retval.=trim($a[$i]).' ';
	}
	return ucfirst($retval);
}

function terbilangFormat($value,$format='IND',$usecurrency=FALSE){
	if($format=='IND'){
		$retval = eja($value);
		if($usecurrency){
			if($value>0)
				$retval = eja($value).' rupiah';
		}
		return $retval;
	} 
	elseif($format=='US'){
		return sayInEnglish($value);
	}
}

function eja($n) {
		$dasar = array(1=>'satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan');

		$angka = array(1000000000,1000000,1000,100,10,1);
		$satuan = array('milyar','juta','ribu','ratus','puluh','');
		$i=0;
		$str='';
		while($n!=0){

			$count = (int)($n/$angka[$i]);

			if($count>=10) $str .= eja($count). " ".$satuan[$i]." ";
			else if($count > 0 && $count < 10)
			$str .= $dasar[$count] . " ".$satuan[$i]." ";

			$n -= $angka[$i] * $count;
			$i++;
		}
		$str = preg_replace("/satu puluh (\w+)/i","\\1 belas",$str);
		$str = preg_replace("/satu (ribu|ratus|puluh|belas)/i","se\\1",$str);

		return $str;
	}
?>