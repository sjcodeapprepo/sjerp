<?php
require_once(APPPATH.'libraries/phpxls/Writer'.EXT);
class Xlswriter extends Spreadsheet_Excel_Writer {
	function __construct(){
	    parent::__construct($filename='');
	}
}
?>