<?php
/*
	Author	: Muhammad Faid Alfarisi
	
	Version	: 1.0 (2016-12-16)
	
	Usage:
	------
		$your_variable = new PHPdate();			// Using PHP default timezone (you can set this in 'php.ini')
		$your_variable = new PHPdate($GMT);		// Set your timezone
		==========================================================================================
		Note: $GMT means GMT hours in your country, your timezone. Example: Asia/Jakarta is GMT +7
		==========================================================================================
		Example:
		--------
			$date0 = new PHPdate();					// The default is your PHP default timezone
			$date1 = new PHPdate(0);				// GMT/UTC
			$date2 = new PHPdate("Asia/Jakarta");	// GMT +7 [Asia/Jakarta]
			$date3 = new PHPdate(-7);				// GMT -7
	
	Implementation:
	---------------
		$date = new PHPdate(0);										// Create Object and date_timezone_set to GMT (+0 hour)
		$my_timestamp = $date->getStamp("2016-12-16");				// Create timestamp of "2016-12-16 00:00:00"
		$today_date = $date->createDate("Y-m-d H:i:s");				// Get today date and format it to "Y-m-d H:i:s"
		$my_date = $date->createDate("Y-m-d H:i:s", $my_timestamp);	// Create date from timestamp
	
	getStamp only support these format:
	-----------------------------------
		=> Y-m-d H:i:s	||	Y/m/d H:i:s	||	Y.m.d H:i:s
		=> d-m-Y H:i:s	||	d/m/Y H:i:s	||	d.m.Y H:i:s
		=> Y-m-d		||	Y/m/d		||	Y.m.d
		=> d-m-Y		||	d/m/Y		||	d.m.Y
		=================================================================================
		Note: to add/change the format ability go to line getStamp() function on line 389
		=================================================================================
	
	createDate only support these output:
	-------------------------------------
		Y => A full numeric representation of a year, 4 digits
		y => A two digit representation of a year
		m => Numeric representation of a month, with leading zeros
		n => Numeric representation of a month, without leading zeros
		d => Day of the month, 2 digits with leading zeros
		j => Day of the month without leading zeros
		h => 12-hour format of an hour with leading zeros
		H => 24-hour format of an hour with leading zeros
		g => 24-hour format of an hour without leading zeros
		G => 12-hour format of an hour without leading zeros
		i => Minutes with leading zeros
		s => Seconds, with leading zeros
		A => Uppercase Ante meridiem and Post meridiem
		a => Lowercase Ante meridiem and Post meridiem
		===================================================================================
		Note: to add/change the format ability go to line createDate() function on line 220
		===================================================================================
*/


class PHPdate {
	private $GMT;
	private $DOM = array(31, 0, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	private $TZN = array(
		"pacific/midway"		=> -11,
		"us/samoa"				=> -11,
		"us/hawaii"				=> -10,
		"us/alaska"				=> -9,
		"us/pacific"			=> -8,
		"america/tijuana"		=> -8,
		"us/arizona"			=> -7,
		"us/mountain"			=> -7,
		"america/chihuahua"		=> -7,
		"america/mazatlan"		=> -7,
		"america/mexico_city"	=> -6,
		"america/monterrey"		=> -6,
		"canada/saskatchewan"	=> -6,
		"us/central"			=> -6,
		"us/eastern"			=> -5,
		"us/east-indiana"		=> -5,
		"america/bogota"		=> -5,
		"america/lima"			=> -5,
		"america/caracas"		=> -4.5,
		"canada/atlantic"		=> -4,
		"america/la_paz"		=> -4,
		"america/santiago"		=> -4,
		"canada/newfoundland"	=> -3.5,
		"america/buenos_aires"	=> -3,
		"greenland"				=> -3,
		"atlantic/stanley"		=> -2,
		"atlantic/azores"		=> -1,
		"atlantic/cape_verde"	=> -1,
		"africa/casablanca"		=> 0,
		"europe/dublin"			=> 0,
		"europe/lisbon"			=> 0,
		"utc"					=> 0,
		"gmt"					=> 0,
		"europe/london"			=> 0,
		"africa/monrovia"		=> 0,
		"europe/amsterdam"		=> 1,
		"europe/belgrade"		=> 1,
		"europe/berlin"			=> 1,
		"europe/bratislava"		=> 1,
		"europe/brussels"		=> 1,
		"europe/budapest"		=> 1,
		"europe/copenhagen"		=> 1,
		"europe/ljubljana"		=> 1,
		"europe/madrid"			=> 1,
		"europe/paris"			=> 1,
		"europe/prague"			=> 1,
		"europe/rome"			=> 1,
		"europe/sarajevo"		=> 1,
		"europe/skopje"			=> 1,
		"europe/stockholm"		=> 1,
		"europe/vienna"			=> 1,
		"europe/warsaw"			=> 1,
		"europe/zagreb"			=> 1,
		"europe/athens"			=> 2,
		"europe/bucharest"		=> 2,
		"africa/cairo"			=> 2,
		"africa/harare"			=> 2,
		"europe/helsinki"		=> 2,
		"europe/istanbul"		=> 2,
		"asia/jerusalem"		=> 2,
		"europe/kiev"			=> 2,
		"europe/minsk"			=> 2,
		"europe/riga"			=> 2,
		"europe/sofia"			=> 2,
		"europe/tallinn"		=> 2,
		"europe/vilnius"		=> 2,
		"asia/baghdad"			=> 3,
		"asia/kuwait"			=> 3,
		"africa/nairobi"		=> 3,
		"asia/riyadh"			=> 3,
		"europe/moscow"			=> 3,
		"asia/tehran"			=> 3.5,
		"asia/baku"				=> 4,
		"europe/volgograd"		=> 4,
		"asia/muscat"			=> 4,
		"asia/tbilisi"			=> 4,
		"asia/yerevan"			=> 4,
		"asia/kabul"			=> 4.5,
		"asia/karachi"			=> 5,
		"asia/tashkent"			=> 5,
		"asia/kolkata"			=> 5.5,
		"asia/kathmandu"		=> 5.75,
		"asia/yekaterinburg"	=> 6,
		"asia/almaty"			=> 6,
		"asia/dhaka"			=> 6,
		"asia/novosibirsk"		=> 7,
		"asia/bangkok"			=> 7,
		"asia/jakarta"			=> 7,
		"asia/krasnoyarsk"		=> 8,
		"asia/chongqing"		=> 8,
		"asia/hong_kong"		=> 8,
		"asia/kuala_lumpur"		=> 8,
		"australia/perth"		=> 8,
		"asia/singapore"		=> 8,
		"asia/taipei"			=> 8,
		"asia/ulaanbaatar"		=> 8,
		"asia/urumqi"			=> 8,
		"asia/irkutsk"			=> 9,
		"asia/seoul"			=> 9,
		"asia/tokyo"			=> 9,
		"australia/adelaide"	=> 9.5,
		"australia/darwin"		=> 9.5,
		"asia/yakutsk"			=> 10,
		"australia/brisbane"	=> 10,
		"australia/canberra"	=> 10,
		"pacific/guam"			=> 10,
		"australia/hobart"		=> 10,
		"australia/melbourne"	=> 10,
		"pacific/port_moresby"	=> 10,
		"australia/sydney"		=> 10,
		"asia/vladivostok"		=> 11,
		"asia/magadan"			=> 12,
		"pacific/auckland"		=> 12,
		"pacific/fiji"			=> 12
	);
	
	// Set GMT on initialize
	public function PHPdate($gmt = "") {
		if($gmt === "") {
			$gmt = date_default_timezone_get();
		}
		if(is_numeric($gmt)) {
			$this->GMT = $gmt;
		} else {
			$gmt = strtolower($gmt);
			$gmt = str_replace(" ", "", $gmt);
			if(isset($this->TZN[$gmt])) {
				$this->GMT = $this->TZN[$gmt];
			} else {
				$gmt = date_default_timezone_get();
				$gmt = strtolower($gmt);
				$gmt = str_replace(" ", "", $gmt);
				$this->GMT = isset($this->TZN[$gmt]) ? $this->TZN[$gmt] : 0;
			}
		}
	}
	
	// Set GMT for user
	public function setGMT($gmt) {
		if(is_numeric($gmt)) {
			$this->GMT = $gmt;
		} else {
			$gmt = strtolower($gmt);
			$gmt = str_replace(" ", "", $gmt);
			if(isset($this->TZN[$gmt])) {
				$this->GMT = $this->TZN[$gmt];
			} else {
				$gmt = date_default_timezone_get();
				$gmt = strtolower($gmt);
				$gmt = str_replace(" ", "", $gmt);
				$this->GMT = isset($this->TZN[$gmt]) ? $this->TZN[$gmt] : 0;
			}
		}
	}
	
	// createDate
	public function createDate($format, $timestamp="") {
		$arr = str_split($format, 1);
		$minus = false;
		$timestamp = $timestamp === "" ? $this->getStamp() : floatval($timestamp);
		if($timestamp < 0) {
			$timestamp = floatval($timestamp * -1);
			$minus = true;
		}
		$timestamp = floatval($timestamp + ($this->GMT * 3600));
		
		// --- YEAR --- //
		$add = 31536000;
		$y = $minus ? 1969 : 1970;
		$tmp = 0;
		while($timestamp >= ($tmp + $add)) {
			$tmp += $add;
			if($minus) {
				$y--;
			} else {
				$y++;
			}
			$add = $this->isLeap($y) ? 31622400 : 31536000;
		}
		// --- YEAR --- //
		
		$timestamp -= $tmp;
		if($minus && $timestamp <= 0) {
			$y++;
			$timstamp = 0;
			$minus = false;
		}
		
		// --- MONTH --- //
		$add = 2678400;
		$m = $minus ? 12 : 1;
		$tmp = 0;
		while($timestamp >= ($tmp + $add)) {
			$tmp += $add;
			if($minus) {
				$m--;
			} else {
				$m++;
			}
			if($m == 2) {
				if($this->isLeap($y)) {
					$add = 29 * 86400;
				} else {
					$add = 28 * 86400;
				}
			} else {
				$add = $this->DOM[($m - 1)] * 86400;
			}
		}
		// --- MONTH --- //
		
		$timestamp -= $tmp;
		if($minus && $timestamp <= 0) {
			$m++;
			$timstamp = 0;
			$minus = false;
		}
		
		// --- DAY --- //
		if($m === 2) {
			if($this->isLeap($y)) {
				$day_in_month = 29;
			} else {
				$day_in_month = 28;
			}
		} else {
			$day_in_month = $this->DOM[($m - 1)];
		}
		$add = 86400;
		$d = $minus ? $day_in_month : 1;
		$tmp = 0;
		while($timestamp >= ($tmp + $add)) {
			$tmp += $add;
			if($minus) {
				$d--;
			} else {
				$d++;
			}
		}
		// --- DAY --- //
		
		$timestamp -= $tmp;
		if($minus && $timestamp <= 0) {
			$d++;
			$timstamp = 0;
			$minus = false;
		}
		
		// --- HOUR --- //
		$add = 3600;
		$h = $minus ? 23 : 0;
		$tmp = 0;
		while($timestamp >= ($tmp + $add)) {
			$tmp += $add;
			if($minus) {
				$h--;
			} else {
				$h++;
			}
		}
		// --- HOUR --- //
		
		$timestamp -= $tmp;
		
		// --- MINUTE --- //
		$add = 60;
		$i = $minus ? 59 : 0;
		$tmp = 0;
		while($timestamp >= ($tmp + $add)) {
			$tmp += $add;
			if($minus) {
				$i--;
			} else {
				$i++;
			}
		}
		// --- MINUTE --- //
		
		$timestamp -= $tmp;
		
		// --- SECOND --- //
		$s = $minus ? 60 - $timestamp : $timestamp;
		// --- SECOND --- //
		
		// --- LEADING ZEROS --- //
		$m = $m < 10 ? "0{$m}" : $m;
		$d = $d < 10 ? "0{$d}" : $d;
		$h = $h < 10 ? "0{$h}" : $h;
		$s = $s < 10 ? "0{$s}" : $s;
		$i = $i < 10 ? "0{$i}" : $i;
		// --- LEADING ZEROS --- //
		
		$ampm = intval($h) > 12 ? "PM" : "AM";
		$h12 = intval($h) > 12 ? intval($h) - 12 : intval($h);
		
		$replacement = array(
			"Y" => $y,									// A full numeric representation of a year, 4 digits
			"y" => substr("{$y}", -2),					// A two digit representation of a year
			"m" => $m,									// Numeric representation of a month, with leading zeros
			"n" => intval($m),							// Numeric representation of a month, without leading zeros
			"d" => $d,									// Day of the month, 2 digits with leading zeros
			"j" => intval($d),							// Day of the month without leading zeros
			"h" => $h12 < 10 ? "0{$h12}" : $h12,		// 12-hour format of an hour with leading zeros
			"H" => $h,									// 24-hour format of an hour with leading zeros
			"g" => intval($h),							// 24-hour format of an hour without leading zeros
			"G" => $h12,								// 12-hour format of an hour without leading zeros
			"i" => $i,									// Minutes with leading zeros
			"s" => $s,									// Seconds, with leading zeros
			"A" => intval($h) > 12 ? "PM" : "AM",		// Uppercase Ante meridiem and Post meridiem
			"a" => intval($h) > 12 ? "pm" : "am",		// Lowercase Ante meridiem and Post meridiem
		);
		
		$result = "";
		foreach($arr as $str) {
			$result .= isset($replacement[$str]) ? $replacement[$str] : $str;
		}
		return $result;
	}
	
	// Function to check Leap Year
	private function isLeap($year) {
		return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0)));
	}
	
	// Function to get the timestamp
	public function getStamp($string = "") {	// Only support: "Y-m-d H:i:s", "Y-m-d", "d-m-Y H:i:s", "d-m-Y", "Y/m/d H:i:s", "Y/m/d", "d/m/Y H:i:s", "d/m/Y", "Y.m.d H:i:s", "Y.m.d", "d.m.Y H:i:s" and "d.m.Y"
		if($string === "") {
			return floor(floatval($_SERVER["REQUEST_TIME_FLOAT"]));
		} else {
			$string = explode(" ", $string);
			
			// Replace any "/" or "." separator to "-"
			$string[0] = str_replace(array("/", "."), array("-", "-"), $string[0]);
			
			$date = explode("-", $string[0]);
			
			// Check the order (d-m-Y or Y-m-d) and fix it (Year should bigger than day, that's why i'm not support 2-digits year)!!!
			if(intval($date[0]) < intval($date[2])) {
				$day = $date[0];
				$date[0] = $date[2];
				$date[2] = $day;
			}
			
			// Check if clock included (Use 1 space to separate date and time, don't give any space if time not included)!!!
			if(isset($string[1])) {
				$time = explode(":", $string[1]);
			} else {
				$time = array("00", "00", "00");
			}
			
			// Check the year and call a function
			if(intval($date[0]) < 1970) {
				return $this->getStampNegative($date, $time);	// Call get negative timestamp if year <  1970
			} else {
				return $this->getStampPositive($date, $time);	// Call get positive timestamp if year >= 1970
			}
		}
	}
	
	// Function to get microsecond from date string
	public function getMicrosecond($string = "") {
		return floatval($this->getStamp($string) * 1000);
	}
	
	// Called when year >= 1970
	private function getStampPositive($date, $time) {
		$leap = 0;
		$not_leap = 0;
		
		$yr = intval($date[0]);
		$mt = intval($date[1]) - 1;
		$dy = intval($date[2]) - 1;
		
		// --- YEAR --- //
		for($i = 1970; $i < $yr; $i++) {
			if($this->isLeap($i)) {
				$leap++;
			} else {
				$not_leap++;
			}
		}
		$y = floatval(floatval($not_leap * 31536000) + floatval($leap * 31622400));
		// --- YEAR --- //
		
		// --- MONTH --- //
		$m = 0;
		for($i = 0; $i < $mt; $i++) {
			if($i === 1) {
				if($this->isLeap($yr)) {
					$m += 29 * 86400;
				} else {
					$m += 28 * 86400;
				}
			} else {
				$m += $this->DOM[$i] * 86400;
			}
		}
		// --- MONTH --- //
		
		// --- DAY, HOUR, MINUTE, SECOND --- //
		$d = floatval($dy * 86400);
		$h = floatval(intval($time[0]) * 3600);
		$i = floatval(intval($time[1]) * 60);
		$s = floatval($time[2]);
		// --- DAY, HOUR, MINUTE, SECOND --- //
		
		return floatval(($y + $m + $d + $h + $i + $s) - ($this->GMT * 3600));
	}
	
	// Called when year < 1970
	private function getStampNegative($date, $time) {
		$leap = 0;
		$not_leap = 0;
		
		$yr = intval($date[0]);
		$mt = intval($date[1]) - 1;
		$dy = intval($date[2]);
		
		// --- YEAR --- //
		for($i = 1969; $i > $yr; $i--) {
			if($this->isLeap($i)) {
				$leap++;
			} else {
				$not_leap++;
			}
		}
		$y = floatval(floatval($not_leap * 31536000) + floatval($leap * 31622400));
		// --- YEAR --- //
		
		// --- MONTH --- //
		$m = 0;
		for($i = 11; $i > $mt; $i--) {
			if($i === 1) {
				if($this->isLeap($yr)) {
					$m += 29 * 86400;
				} else {
					$m += 28 * 86400;
				}
			} else {
				$m += $this->DOM[$i] * 86400;
			}
		}
		// --- MONTH --- //
		
		// --- DAY --- //
		if($mt === 1) {
			if($this->isLeap($yr)) {
				$day_in_month = 29;
			} else {
				$day_in_month = 28;
			}
		} else {
			$day_in_month = $this->DOM[$mt];
		}
		$d = floatval(($day_in_month - $dy) * 86400);
		// --- DAY --- //
		
		// --- DAY, HOUR, MINUTE, SECOND --- //
		$h = floatval((23 - intval($time[0])) * 3600);
		$i = floatval((59 - intval($time[1])) * 60);
		$s = floatval(60 - intval($time[2]));
		// --- DAY, HOUR, MINUTE, SECOND --- //
		
		return floatval(0 - floatval(($y + $m + $d + $h + $i + $s) - ($this->GMT * 3600)));
	}
}
?>