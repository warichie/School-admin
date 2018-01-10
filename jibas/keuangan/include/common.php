<?
/**[N]**
 * JIBAS Education Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 3.0 (January 09, 2013)
 * @notes: JIBAS Education Community will be managed by Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
 * 
 * Copyright (C) 2009 Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 **[N]**/ ?>
<?
require_once("sessionchecker.php");

//$UPLOAD_DIR = "c:\\xampp\\htdocs\\alfakeu\\upload\\";
//$BASE_ADDR  = "http://localhost/alfakeu/";
$bulan = array(1=>'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

function StringIsSelected($value, $comparer) {
	if ($value == $comparer) 
		return "selected";
	else
		return "";
}

function IntIsSelected($value, $comparer) {
	$a = (int)$value;
	$b = (int)$comparer;
	
	if ($a == $b) 
		return "selected";
	else
		return "";
}

function StringIsChecked($value, $comparer) {
	if ($value == $comparer) 
		return "checked";
	else
		return "";
}

function IntIsChecked($value, $comparer) {
	if ($value == $comparer) 
		return "checked";
	else
		return "";
}

function RandStr($length) {
	$charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$s = "";
	while(strlen($s) < $length) 
		$s .= substr($charset, rand(0, 61), 1);
	return $s;		
}

function NamaBulan($bln) {
	if ($bln == 1)
		return "January";
	elseif ($bln == 2)
		return "February";		
	elseif ($bln == 3)
		return "March";		
	elseif ($bln == 4)
		return "April";		
	elseif ($bln == 5)
		return "May";
	elseif ($bln == 6)
		return "June";		
	elseif ($bln == 7)
		return "July";
	elseif ($bln == 8)
		return "August";		
	elseif ($bln == 9)
		return "September";
	elseif ($bln == 10)
		return "October";		
	elseif ($bln == 11)
		return "November";
	elseif ($bln == 12)
		return "December";		
}

function rpad($string, $padchar, $length) {
	$result = trim($string);
	if (strlen($result) < $length) {
		$nzero = $length - strlen($result);
		$zero = "";
		for($i = 0; $i < $nzero; $i++)
			$zero .= "0";
		$result = $zero . $result;
	}
	return $result;
}

function MySqlDateFormat($date) {
	list($d, $m, $y) = split('[/.-]', $date); 
	return "$y-$m-$d";
}

function RegularDateFormat($mysqldate) {
	list($y, $m, $d) = split('[/.-]', $mysqldate); 
	return "$d-$m-$y";
}

function LongDateFormat($mysqldate) {
	list($y, $m, $d) = split('[/.-]', $mysqldate); 
	return "$d ". NamaBulan($m) ." $y";
}

	
function change_urut($a, $b, $c) {	
	$s = "";
	if ($a == $b) {
		if ($c == "ASC") 
			$s = "<img src ='images/ico/descending copy.gif'>";
		else 
			$s = "<img src ='images/ico/ascending copy.gif'>";
	} 	
	return $s;
}

function JmlHari($bln,$th) {
	if ($bln == 4 || $bln == 6|| $bln == 9 || $bln == 11) 
		$n = 30;
	else if ($bln == 2 && $th % 4 <> 0)
		$n = 28;
	else if ($bln == 2 && $th % 4 == 0)
		$n = 29;
	else 
		$n = 31;
	return $n;
}	

function CQ($string){
	$string = trim($string);
	$string = str_replace("'","`",$string);
	$string = str_replace('"','`',$string);
	return $string;
}
?>