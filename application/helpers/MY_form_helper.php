<?php
// ------------------------------------------------------------------------
	function form_dropdownDB($name = '',$arrayData,$keydata,$value,$selected='', $extra = ''){
        if ($extra != '') $extra = ' '.$extra;
        $form = '<select name="'.$name.'"'.$extra.">\n";
			for($i=0;$i<count($arrayData);$i++){
				
				$key=$arrayData[$i][$keydata];
				$val=$arrayData [$i][$value];
				
				$sel = ($selected != $key) ? '' : ' selected="selected"';	
				$form .= '<option value="'.$key.'"'.$sel.'>'.$val."</option>\n";			
				
			}
	
		$form .= '</select>';	
		return $form;
	}
//---------------------------------------------------------------------------------------------------	
    function form_dropdownDB_init($name = '',$arrayData,$keydata,$value,$selected='',$initval='0',$initoption='--Silakan Pilih--', $extra = '', $disable=''){
        if ($extra != '') $extra = ' '.$extra;
        $form = '<select name="'.$name.'"'.$extra.">\n";
        $form .= '<option value="'.$initval.'"'.$disable.'>'.$initoption."</option>\n";
            for($i=0;$i<count($arrayData);$i++){
                
                $key=$arrayData[$i][$keydata];
                $val=$arrayData [$i][$value];
                
                $sel = ($selected != $key) ? '' : ' selected="selected"';   
                $form .= '<option value="'.$key.'"'.$sel.'>'.$val."</option>\n";            
                
            }
    
        $form .= '</select>';   
        return $form;
    }
    
    function form_dropdownDB_initJS($name = '',$arrayData,$keydata,$value,$selected='',$initval='0',$initoption='--Silakan Pilih--', $extra = '', $disable=''){
        if ($extra != '') $extra = ' '.$extra;
        $form = '<select name="'.$name.'"'.$extra.">' \n";
        $form .= '+ \'<option value="'.$initval.'"'.$disable.'>'.$initoption."</option>'\n";
            for($i=0;$i<count($arrayData);$i++){
                
                $key=$arrayData[$i][$keydata];
                $val=$arrayData [$i][$value];
                
                $sel = ($selected != $key) ? '' : ' selected="selected"';   
                $form .= '+ \'<option value="'.$key.'"'.$sel.'>'.$val."</option>'\n";            
                
            }
    
        $form .= '+ \'</select>';   
        return $form;
    }

    function dropDownMonth($name='month', $initmonth='---Pilih Bulan---', $extra='', $selectedmonth='0',$format='ID'){
    	$form = "<select name='$name'$extra>\n";
    	$form.= "<option value='0'>$initmonth</option>\n";
		$namabulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		if($format=='US') $namabulan = array('January','February','March','April','May','June','July','August','September','October','November','December');
		for($i=1;$i<=12;$i++){
			$selected = '';
			if($selectedmonth==$i) $selected ='selected';
			$form.= "<option $selected value='$i'>".$namabulan[$i-1]."</option>\n";
		}
    	$form.= "</select>\n";
    	return $form;	
    }

	function getNameFromDropdownDB($arrayData,$keydata,$value,$selected=''){
			$sel = '';
			for($i=0;$i<count($arrayData);$i++){

				$key=$arrayData[$i][$keydata];
				$val=$arrayData [$i][$value];

				$sel .= ($selected != $key) ? '' : $val;

			}
		return $sel;
	}
	
	function testaje() {		
		$CI =& get_instance();
		$data['username']	= $CI->session->userdata('UserName');
		$CI->load->view('welcome_message',$data);
	}
?>
