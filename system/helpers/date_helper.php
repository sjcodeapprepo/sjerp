<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Date Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/date_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Get "now" time
 *
 * Returns time() or its GMT equivalent based on the config file preference
 *
 * @access	public
 * @return	integer
 */
if ( ! function_exists('now'))
{
	function now()
	{
		$CI =& get_instance();

		if (strtolower($CI->config->item('time_reference')) == 'gmt')
		{
			$now = time();
			$system_time = mktime(gmdate("H", $now), gmdate("i", $now), gmdate("s", $now), gmdate("m", $now), gmdate("d", $now), gmdate("Y", $now));

			if (strlen($system_time) < 10)
			{
				$system_time = time();
				log_message('error', 'The Date class could not set a proper GMT timestamp so the local time() value was used.');
			}

			return $system_time;
		}
		else
		{
			return time();
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Convert MySQL Style Datecodes
 *
 * This function is identical to PHPs date() function,
 * except that it allows date codes to be formatted using
 * the MySQL style, where each code letter is preceded
 * with a percent sign:  %Y %m %d etc...
 *
 * The benefit of doing dates this way is that you don't
 * have to worry about escaping your text letters that
 * match the date codes.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @return	integer
 */
if ( ! function_exists('mdate'))
{
	function mdate($datestr = '', $time = '')
	{
		if ($datestr == '')
			return '';

		if ($time == '')
			$time = now();

		$datestr = str_replace('%\\', '', preg_replace("/([a-z]+?){1}/i", "\\\\\\1", $datestr));
		return date($datestr, $time);
	}
}

// ------------------------------------------------------------------------

/**
 * Standard Date
 *
 * Returns a date formatted according to the submitted standard.
 *
 * @access	public
 * @param	string	the chosen format
 * @param	integer	Unix timestamp
 * @return	string
 */
if ( ! function_exists('standard_date'))
{
	function standard_date($fmt = 'DATE_RFC822', $time = '')
	{
		$formats = array(
						'DATE_ATOM'		=>	'%Y-%m-%dT%H:%i:%s%Q',
						'DATE_COOKIE'	=>	'%l, %d-%M-%y %H:%i:%s UTC',
						'DATE_ISO8601'	=>	'%Y-%m-%dT%H:%i:%s%Q',
						'DATE_RFC822'	=>	'%D, %d %M %y %H:%i:%s %O',
						'DATE_RFC850'	=>	'%l, %d-%M-%y %H:%i:%s UTC',
						'DATE_RFC1036'	=>	'%D, %d %M %y %H:%i:%s %O',
						'DATE_RFC1123'	=>	'%D, %d %M %Y %H:%i:%s %O',
						'DATE_RSS'		=>	'%D, %d %M %Y %H:%i:%s %O',
						'DATE_W3C'		=>	'%Y-%m-%dT%H:%i:%s%Q',
						'DATE_SATU'		=>	'%Y-%m-%d',
						'DATETIME'		=>	'%Y-%m-%d %H:%i:%s'
						);

		if ( ! isset($formats[$fmt]))
		{
			return FALSE;
		}

		return mdate($formats[$fmt], $time);
	}
}

// ------------------------------------------------------------------------

/**
 * Timespan
 *
 * Returns a span of seconds in this format:
 *	10 days 14 hours 36 minutes 47 seconds
 *
 * @access	public
 * @param	integer	a number of seconds
 * @param	integer	Unix timestamp
 * @return	integer
 */
if ( ! function_exists('timespan'))
{
	function timespan($seconds = 1, $time = '')
	{
		$CI =& get_instance();
		$CI->lang->load('date');

		if ( ! is_numeric($seconds))
		{
			$seconds = 1;
		}

		if ( ! is_numeric($time))
		{
			$time = time();
		}

		if ($time <= $seconds)
		{
			$seconds = 1;
		}
		else
		{
			$seconds = $time - $seconds;
		}

		$str = '';
		$years = floor($seconds / 31536000);

		if ($years > 0)
		{
			$str .= $years.' '.$CI->lang->line((($years	> 1) ? 'date_years' : 'date_year')).', ';
		}

		$seconds -= $years * 31536000;
		$months = floor($seconds / 2628000);

		if ($years > 0 OR $months > 0)
		{
			if ($months > 0)
			{
				$str .= $months.' '.$CI->lang->line((($months	> 1) ? 'date_months' : 'date_month')).', ';
			}

			$seconds -= $months * 2628000;
		}

		$weeks = floor($seconds / 604800);

		if ($years > 0 OR $months > 0 OR $weeks > 0)
		{
			if ($weeks > 0)
			{
				$str .= $weeks.' '.$CI->lang->line((($weeks	> 1) ? 'date_weeks' : 'date_week')).', ';
			}

			$seconds -= $weeks * 604800;
		}

		$days = floor($seconds / 86400);

		if ($months > 0 OR $weeks > 0 OR $days > 0)
		{
			if ($days > 0)
			{
				$str .= $days.' '.$CI->lang->line((($days	> 1) ? 'date_days' : 'date_day')).', ';
			}

			$seconds -= $days * 86400;
		}

		$hours = floor($seconds / 3600);

		if ($days > 0 OR $hours > 0)
		{
			if ($hours > 0)
			{
				$str .= $hours.' '.$CI->lang->line((($hours	> 1) ? 'date_hours' : 'date_hour')).', ';
			}

			$seconds -= $hours * 3600;
		}

		$minutes = floor($seconds / 60);

		if ($days > 0 OR $hours > 0 OR $minutes > 0)
		{
			if ($minutes > 0)
			{
				$str .= $minutes.' '.$CI->lang->line((($minutes	> 1) ? 'date_minutes' : 'date_minute')).', ';
			}

			$seconds -= $minutes * 60;
		}

		if ($str == '')
		{
			$str .= $seconds.' '.$CI->lang->line((($seconds	> 1) ? 'date_seconds' : 'date_second')).', ';
		}

		return substr(trim($str), 0, -1);
	}
}

// ------------------------------------------------------------------------

/**
 * Number of days in a month
 *
 * Takes a month/year as input and returns the number of days
 * for the given month/year. Takes leap years into consideration.
 *
 * @access	public
 * @param	integer a numeric month
 * @param	integer	a numeric year
 * @return	integer
 */
if ( ! function_exists('days_in_month'))
{
	function days_in_month($month = 0, $year = '')
	{
		if ($month < 1 OR $month > 12)
		{
			return 0;
		}

		if ( ! is_numeric($year) OR strlen($year) != 4)
		{
			$year = date('Y');
		}

		if ($month == 2)
		{
			if ($year % 400 == 0 OR ($year % 4 == 0 AND $year % 100 != 0))
			{
				return 29;
			}
		}

		$days_in_month	= array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		return $days_in_month[$month - 1];
	}
}

// ------------------------------------------------------------------------

/**
 * Converts a local Unix timestamp to GMT
 *
 * @access	public
 * @param	integer Unix timestamp
 * @return	integer
 */
if ( ! function_exists('local_to_gmt'))
{
	function local_to_gmt($time = '')
	{
		if ($time == '')
			$time = time();

		return mktime( gmdate("H", $time), gmdate("i", $time), gmdate("s", $time), gmdate("m", $time), gmdate("d", $time), gmdate("Y", $time));
	}
}

// ------------------------------------------------------------------------

/**
 * Converts GMT time to a localized value
 *
 * Takes a Unix timestamp (in GMT) as input, and returns
 * at the local value based on the timezone and DST setting
 * submitted
 *
 * @access	public
 * @param	integer Unix timestamp
 * @param	string	timezone
 * @param	bool	whether DST is active
 * @return	integer
 */
if ( ! function_exists('gmt_to_local'))
{
	function gmt_to_local($time = '', $timezone = 'UTC', $dst = FALSE)
	{
		if ($time == '')
		{
			return now();
		}

		$time += timezones($timezone) * 3600;

		if ($dst == TRUE)
		{
			$time += 3600;
		}

		return $time;
	}
}

// ------------------------------------------------------------------------

/**
 * Converts a MySQL Timestamp to Unix
 *
 * @access	public
 * @param	integer Unix timestamp
 * @return	integer
 */
if ( ! function_exists('mysql_to_unix'))
{
	function mysql_to_unix($time = '')
	{
		// We'll remove certain characters for backward compatibility
		// since the formatting changed with MySQL 4.1
		// YYYY-MM-DD HH:MM:SS

		$time = str_replace('-', '', $time);
		$time = str_replace(':', '', $time);
		$time = str_replace(' ', '', $time);

		// YYYYMMDDHHMMSS
		return  mktime(
						substr($time, 8, 2),
						substr($time, 10, 2),
						substr($time, 12, 2),
						substr($time, 4, 2),
						substr($time, 6, 2),
						substr($time, 0, 4)
						);
	}
}

// ------------------------------------------------------------------------

/**
 * Unix to "Human"
 *
 * Formats Unix timestamp to the following prototype: 2006-08-21 11:35 PM
 *
 * @access	public
 * @param	integer Unix timestamp
 * @param	bool	whether to show seconds
 * @param	string	format: us or euro
 * @return	string
 */
if ( ! function_exists('unix_to_human'))
{
	function unix_to_human($time = '', $seconds = FALSE, $fmt = 'us')
	{
		$r  = date('Y', $time).'-'.date('m', $time).'-'.date('d', $time).' ';

		if ($fmt == 'us')
		{
			$r .= date('h', $time).':'.date('i', $time);
		}
		else
		{
			$r .= date('H', $time).':'.date('i', $time);
		}

		if ($seconds)
		{
			$r .= ':'.date('s', $time);
		}

		if ($fmt == 'us')
		{
			$r .= ' '.date('A', $time);
		}

		return $r;
	}
}

// ------------------------------------------------------------------------

/**
 * Convert "human" date to GMT
 *
 * Reverses the above process
 *
 * @access	public
 * @param	string	format: us or euro
 * @return	integer
 */
if ( ! function_exists('human_to_unix'))
{
	function human_to_unix($datestr = '')
	{
		if ($datestr == '')
		{
			return FALSE;
		}

		$datestr = trim($datestr);
		$datestr = preg_replace("/\040+/", ' ', $datestr);

		if ( ! preg_match('/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}\s[0-9]{1,2}:[0-9]{1,2}(?::[0-9]{1,2})?(?:\s[AP]M)?$/i', $datestr))
		{
			return FALSE;
		}

		$split = explode(' ', $datestr);

		$ex = explode("-", $split['0']);

		$year  = (strlen($ex['0']) == 2) ? '20'.$ex['0'] : $ex['0'];
		$month = (strlen($ex['1']) == 1) ? '0'.$ex['1']  : $ex['1'];
		$day   = (strlen($ex['2']) == 1) ? '0'.$ex['2']  : $ex['2'];

		$ex = explode(":", $split['1']);

		$hour = (strlen($ex['0']) == 1) ? '0'.$ex['0'] : $ex['0'];
		$min  = (strlen($ex['1']) == 1) ? '0'.$ex['1'] : $ex['1'];

		if (isset($ex['2']) && preg_match('/[0-9]{1,2}/', $ex['2']))
		{
			$sec  = (strlen($ex['2']) == 1) ? '0'.$ex['2'] : $ex['2'];
		}
		else
		{
			// Unless specified, seconds get set to zero.
			$sec = '00';
		}

		if (isset($split['2']))
		{
			$ampm = strtolower($split['2']);

			if (substr($ampm, 0, 1) == 'p' AND $hour < 12)
				$hour = $hour + 12;

			if (substr($ampm, 0, 1) == 'a' AND $hour == 12)
				$hour =  '00';

			if (strlen($hour) == 1)
				$hour = '0'.$hour;
		}

		return mktime($hour, $min, $sec, $month, $day, $year);
	}
}

// ------------------------------------------------------------------------

/**
 * Timezone Menu
 *
 * Generates a drop-down menu of timezones.
 *
 * @access	public
 * @param	string	timezone
 * @param	string	classname
 * @param	string	menu name
 * @return	string
 */
if ( ! function_exists('timezone_menu'))
{
	function timezone_menu($default = 'UTC', $class = "", $name = 'timezones')
	{
		$CI =& get_instance();
		$CI->lang->load('date');

		if ($default == 'GMT')
			$default = 'UTC';

		$menu = '<select name="'.$name.'"';

		if ($class != '')
		{
			$menu .= ' class="'.$class.'"';
		}

		$menu .= ">\n";

		foreach (timezones() as $key => $val)
		{
			$selected = ($default == $key) ? " selected='selected'" : '';
			$menu .= "<option value='{$key}'{$selected}>".$CI->lang->line($key)."</option>\n";
		}

		$menu .= "</select>";

		return $menu;
	}
}

// ------------------------------------------------------------------------

/**
 * Timezones
 *
 * Returns an array of timezones.  This is a helper function
 * for various other ones in this library
 *
 * @access	public
 * @param	string	timezone
 * @return	string
 */
if ( ! function_exists('timezones'))
{
	function timezones($tz = '')
	{
		// Note: Don't change the order of these even though
		// some items appear to be in the wrong order

		$zones = array(
						'UM12'		=> -12,
						'UM11'		=> -11,
						'UM10'		=> -10,
						'UM95'		=> -9.5,
						'UM9'		=> -9,
						'UM8'		=> -8,
						'UM7'		=> -7,
						'UM6'		=> -6,
						'UM5'		=> -5,
						'UM45'		=> -4.5,
						'UM4'		=> -4,
						'UM35'		=> -3.5,
						'UM3'		=> -3,
						'UM2'		=> -2,
						'UM1'		=> -1,
						'UTC'		=> 0,
						'UP1'		=> +1,
						'UP2'		=> +2,
						'UP3'		=> +3,
						'UP35'		=> +3.5,
						'UP4'		=> +4,
						'UP45'		=> +4.5,
						'UP5'		=> +5,
						'UP55'		=> +5.5,
						'UP575'		=> +5.75,
						'UP6'		=> +6,
						'UP65'		=> +6.5,
						'UP7'		=> +7,
						'UP8'		=> +8,
						'UP875'		=> +8.75,
						'UP9'		=> +9,
						'UP95'		=> +9.5,
						'UP10'		=> +10,
						'UP105'		=> +10.5,
						'UP11'		=> +11,
						'UP115'		=> +11.5,
						'UP12'		=> +12,
						'UP1275'	=> +12.75,
						'UP13'		=> +13,
						'UP14'		=> +14
					);

		if ($tz == '')
		{
			return $zones;
		}

		if ($tz == 'GMT')
			$tz = 'UTC';

		return ( ! isset($zones[$tz])) ? 0 : $zones[$tz];
	}
}

if ( ! function_exists('localDate'))
{
	function localDate($mysqldate, $isShortmonth=FALSE){
		if(is_null($mysqldate) || ($mysqldate=='0000-00-00')){
			return "__-__-____";
		}
		else {
			$datepiece = explode("-", $mysqldate);
			$retval = $datepiece[2]." ".indMonthName($datepiece[1],$isShortmonth)." ".$datepiece[0];
			return $retval;
		}
	}
}

if ( ! function_exists('indMonthName'))
{	
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
}

if ( ! function_exists('indMonthList'))
{
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
}

if ( ! function_exists('getMonthName'))
{
	function getMonthName($month,$countryformat='US',$shortmonthname=FALSE){
		$month += 0;
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
		else if($countryformat=='ROMAWI'){
			$monthname = array('I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII');
			if($shortmonthname){
				$monthname = array('i','ii','iii','iv','v','vi','vii','viii','ix','x','xi','xii');
			}
		}
		return $monthname[$month-1];
	}
}

if ( ! function_exists('dateAddDays'))
{
	function dateAddDays($mulai, $daycount){
		list($mulaiyear, $mulaimonth, $mulaiday) = explode("-", $mulai);
		return $tglselanjutnya  = date("Y-m-d", mktime(0, 0, 0, $mulaimonth , $mulaiday+$daycount, $mulaiyear));
	}
}

if ( ! function_exists('dateMinusDays'))
{
	function dateMinusDays($mulai, $daycount){
		list($mulaiyear, $mulaimonth, $mulaiday) = explode("-", $mulai);
		return $tglselanjutnya  = date("Y-m-d", mktime(0, 0, 0, $mulaimonth , $mulaiday-$daycount, $mulaiyear));
	}
}

if ( ! function_exists('diffDate'))
{
	function diffDate($mulai,$akhir){
		list($mulaiyear, $mulaimonth, $mulaiday) = explode("-", $mulai);
		list($akhiryear,$akhirmonth, $akhirday) = explode("-", $akhir);
		$a = gregoriantojd($mulaimonth, $mulaiday, $mulaiyear);
		$b = gregoriantojd($akhirmonth, $akhirday, $akhiryear);
		$c = $b - $a;
		return $c;
	}
}

/*
 * untuk ngeluarin array yg isinya beberapa bulan terkahir.
 * hari nya bisa dipilih untuk tgl terakhir atau tgl 1
 */
if ( ! function_exists('getLastNMonths'))
{
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
}
/*
 * untuk ngitung berapa bulan antara dua tanggal
 */
/* End of file date_helper.php */
/* Location: ./system/helpers/date_helper.php */