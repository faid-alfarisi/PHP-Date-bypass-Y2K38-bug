# PHP-Date-bypass-Y2K38-bug
This class is for bypass the 32-bit PHP Y2K38 bug
	
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
