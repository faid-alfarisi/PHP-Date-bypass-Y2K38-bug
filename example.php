<?php
	require_once("PHPdate.php");
	
	date_default_timezone_set("UTC");
	$dt = new PHPdate("UTC");
	
	$today = $dt->createDate("Y-m-d H:i:s");
	
	$y2k38 = "2038-01-19 03:14:07";
	$y2k39 = "2039-12-31 23:59:59";
	
	$y1901 = "1901-12-13 20:45:52";
	$y1900 = "1900-01-01 00:00:00";
?>
<table cellspacing='4' cellpadding='0' border='0'>
	<tr>
		<td style='width:80px;'>strtotime</td>
		<td style='width:60px;'>[Today]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo strtotime($today); ?></td>
	</tr>
	<tr>
		<td style='width:80px;'>getStamp</td>
		<td style='width:60px;'>[Today]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo $dt->getStamp($today); ?></td>
	</tr>
	<tr>
		<td style='width:80px;'>date</td>
		<td style='width:60px;'>[Today]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo date("Y-m-d H:i:s"); ?></td>
	</tr>
	<tr>
		<td style='width:80px;'>createDate</td>
		<td style='width:60px;'>[Today]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo $dt->createDate("Y-m-d H:i:s"); ?></td>
	</tr>
	<tr>
		<td colspan='4' style='border:1px solid #000000'></td>
	</tr>
	<tr>
		<td style='width:80px;'>strtotime</td>
		<td style='width:60px;'>[2038]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo strtotime($y2k38); ?></td>
	</tr>
	<tr>
		<td style='width:80px;'>getStamp</td>
		<td style='width:60px;'>[2038]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo $dt->getStamp($y2k38); ?></td>
	</tr>
	<tr>
		<td style='width:80px;'>date</td>
		<td style='width:60px;'>[2038]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo date("Y-m-d H:i:s", strtotime($y2k38)); ?></td>
	</tr>
	<tr>
		<td style='width:80px;'>createDate</td>
		<td style='width:60px;'>[2038]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo $dt->createDate("Y-m-d H:i:s", $dt->getStamp($y2k38)); ?></td>
	</tr>
	<tr>
		<td colspan='4' style='border:1px solid #000000'></td>
	</tr>
	<tr>
		<td style='width:80px;'>strtotime</td>
		<td style='width:60px;'>[1901]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo strtotime($y1901); ?></td>
	</tr>
	<tr>
		<td style='width:80px;'>getStamp</td>
		<td style='width:60px;'>[1901]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo $dt->getStamp($y1901); ?></td>
	</tr>
		<tr>
		<td style='width:80px;'>date</td>
		<td style='width:60px;'>[1901]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo date("Y-m-d H:i:s", strtotime($y1901)); ?></td>
	</tr>
	<tr>
		<td style='width:80px;'>createDate</td>
		<td style='width:60px;'>[1901]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo $dt->createDate("Y-m-d H:i:s", $dt->getStamp($y1901)); ?></td>
	</tr>
	<tr>
		<td colspan='4' style='border:1px solid #000000'></td>
	</tr>
	<tr>
		<td style='width:80px;'>getStamp</td>
		<td style='width:60px;'>[1900]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo $dt->getStamp($y1900); ?></td>
	</tr>
	<tr>
		<td style='width:80px;'>getStamp</td>
		<td style='width:60px;'>[2039]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo $dt->getStamp($y2k39); ?></td>
	</tr>
	<tr>
		<td style='width:80px;'>createDate</td>
		<td style='width:60px;'>[1900]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo $dt->createDate("Y-m-d H:i:s", $dt->getStamp($y1900)); ?></td>
	</tr>
	<tr>
		<td style='width:80px;'>createDate</td>
		<td style='width:60px;'>[2039]</td>
		<td style='width:14px;'>:</td>
		<td><?php echo $dt->createDate("Y-m-d H:i:s", $dt->getStamp($y2k39)); ?></td>
	</tr>
</table>