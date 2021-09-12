<?php

class ExportToCSV
{
 	var $out = '';
	 
 	function __construct() {
		
	}

	Function SetQuery($qry) {$this->Query = $qry;}
	
	
	Function GenerateCSV()
	{
		// Open file export.csv.
		$f = fopen (APPPATH.'cache/export.csv','w');
		if(is_array($this->Query)){
			$list = $this->Query;
			fputcsv($f, $list[count($list)-1]);
			for($i=0; $i < count($list)-1; $i++){
				fputcsv($f, $list[$i]);
			}
			fclose($f);
		}
		else{
			$this->out = '';
			$result=mysql_query($this->Query);
			$columns = mysql_num_fields($result);
		
			// Put the name of all fields to $out.
			for ($i = 0; $i < $columns; $i++) {
				$l=mysql_field_name($result, $i);
				$this->out .= '"'.$l.'",';
				}
			
			$this->out .="\n";
		
			// Add all values in the table to $out.
			while ($l = mysql_fetch_array($result)) {
				for ($i = 0; $i < $columns; $i++) {
					$this->out .='"'.$l["$i"].'",';
				}
				$this->out .="\n";
			}
			// Put all values from $out to export.csv.
			fputs($f, $this->out);
			fclose($f);
		}
	}
	
	Function Export()
	{
		$this->GenerateCSV() ;
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="csvdata.csv"');
		readfile(APPPATH.'cache/export.csv');
	}
}
