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

$kriteria = array(1 => 'Religion','Past School','Blood Type','Gender','Citizenship','Student Post Code','Student Conditions','Father Occupation','Mother Occupation','Father Education','Mother Education','Parent Income','Status Active','Student Status','Ethnicity','Year of Birth','Age');
$kriteria_judul = array(1 => 'RELIGION','PAST SCHOOL','BLOOD TYPE','GENDER','CITIZENSHIP','STUDENT POST CODE','STUDENT CONDITIONS','FATHER OCCUPATION','MOTHER OCCUPATION','FATHER EDUCATION','MOTHER EDUCATION','PARENT INCOME','STATUS ACTIVE','STUDENT STATUS','ETHNICITY','YEAR OF BIRTH','AGE');
$kriteria_tabel = array(1 => 'agama','asalsekolah','darah','kelamin','warga','kodepossiswa','kondisi','pekerjaanayah','pekerjaanibu','pendidikanayah','pendidikanibu','penghasilanayah','aktif','status','suku','tgllahir');
$kriteria_file = array(1 => 'agama','asalsekolah','darah','kelamin','warga','kodepos','kondisi','pekerjaanayah','pekerjaanibu','pendidikanayah','pendidikanibu','penghasilan','aktif','status','suku','tahunlahir','usia');
$bulan = array(1=>'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
$bulan_pjg = array(1=>'January','February','March','April','May','June','July','August','September','October','November','December');

function StringIsSelected($value, $comparer) 
{
	if ($value == $comparer) 
		return "selected";
	else
		return "";
}

function IntIsSelected($value, $comparer) 
{
	$a = (int)$value;
	$b = (int)$comparer;
	
	if ($a == $b) 
		return "selected";
	else
		return "";
}

function StringIsChecked($value, $comparer) 
{
	if ($value == $comparer) 
		return "checked";
	else
		return "";
}

function IntIsChecked($value, $comparer) 
{
	if ($value == $comparer) 
		return "checked";
	else
		return "";
}

function RandStr($length) 
{
	$charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$s = "";
	while(strlen($s) < $length) 
		$s .= substr($charset, rand(0, 61), 1);
	return $s;		
}

function NamaBulan($bln) 
{
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

function NamaBulanPdk($bln) 
{
	if ($bln == 1)
		return "Jan";
	elseif ($bln == 2)
		return "Feb";		
	elseif ($bln == 3)
		return "Mar";		
	elseif ($bln == 4)
		return "Apr";		
	elseif ($bln == 5)
		return "May";
	elseif ($bln == 6)
		return "Jun";		
	elseif ($bln == 7)
		return "Jul";
	elseif ($bln == 8)
		return "Aug";		
	elseif ($bln == 9)
		return "Sep";
	elseif ($bln == 10)
		return "Oct";		
	elseif ($bln == 11)
		return "Nov";
	elseif ($bln == 12)
		return "Dec";		
}

function NamaHari($hari) 
{
	if ($hari == 1)
		return "Monday";
	elseif ($hari == 2)
		return "Tuesday";		
	elseif ($hari == 3)
		return "Wednesday";		
	elseif ($hari == 4)
		return "Thursday";		
	elseif ($hari == 5)
		return "Friday";
	elseif ($hari == 6)
		return "Saturday";
}

function rpad($string, $padchar, $length) 
{
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

function MySqlDateFormat($date) 
{
	list($d, $m, $y) = split('[/.-]', $date); 
	return "$y-$m-$d";
}

function RegularDateFormat($mysqldate) 
{
	list($y, $m, $d) = split('[/.-]', $mysqldate); 
	return "$d-$m-$y";
}

function LongDateFormat($mysqldate) 
{
	list($y, $m, $d) = split('[/.-]', $mysqldate); 
	return "$d ". NamaBulan($m) ." $y";
}

function ShortDateFormat($mysqldate) 
{
	list($y, $m, $d) = split('[/.-]', $mysqldate); 
	return "$d ". NamaBulanPdk($m) ." $y";
}

function TglDb($value) 
{
	$tanggal = substr($value,0,2);
	$bulan = substr($value,3,2);
	$tahun = substr($value,6,4);
	$tgl=$tahun."-".$bulan."-".$tanggal;
	return $tgl;
}

function TglText($value) 
{
	$tahun = substr($value,0,4);
	$bulan = substr($value,5,2);
	$tanggal = substr($value,8,2);
	$tgl=$tanggal."-".$bulan."-".$tahun;
	return $tgl;
}

function TglTextLong($value) 
{
	$value=trim($value);
	$tahun = substr($value,0,4);
	$bulan = substr($value,5,2);
	$tanggal = substr($value,8,2);
	
	switch ($bulan)
	{
		case 01:
			$nama_bulan="January";
			break;
		case 02:
			$nama_bulan="February";
			break;
		case 03:
			$nama_bulan="March";
			break;
		case 04:
			$nama_bulan="April";
			break;
		case 05:
			$nama_bulan="May";
			break;
		case 06:
			$nama_bulan="June";
			break;
		case 07:
			$nama_bulan="July";
			break;
		case 08:
			$nama_bulan="August";
			break;
		case 09:
			$nama_bulan="September";
			break;
		case 10:
			$nama_bulan="October";
			break;
		case 11:
			$nama_bulan="November";
			break;
		case 12:
			$nama_bulan="December";
			break;
	}
	if ($tanggal<10){
		$tanggal=substr($tanggal,1,1);
	} else {
		$tanggal=$tanggal;
	}
	$tgl=$tanggal." ".$nama_bulan." ".$tahun;
	return $tgl;
}

function TglTextShort($value) 
{
	$xxx = explode("-",$value);
	$tahun = $xxx[0];
	$bulan = $xxx[1];
	$tanggal = $xxx[2];
	switch ($bulan){
		case 01:
			$nama_bulan="Jan";
			break;
		case 02:
			$nama_bulan="Feb";
			break;
		case 03:
			$nama_bulan="Mar";
			break;
		case 04:
			$nama_bulan="Apr";
			break;
		case 05:
			$nama_bulan="May";
			break;
		case 06:
			$nama_bulan="Jun";
			break;
		case 07:
			$nama_bulan="Jul";
			break;
		case 08:
			$nama_bulan="Aug";
			break;
		case 09:
			$nama_bulan="Sep";
			break;
		case 10:
			$nama_bulan="Oct";
			break;
		case 11:
			$nama_bulan="Nov";
			break;
		case 12:
			$nama_bulan="Dec";
			break;
	}
	$tgl=$tanggal." ".$nama_bulan." ".$tahun;
	return $tgl;
}

function format_tgl($tanggal)
{
	$mdy = explode('-',$tanggal);
	$hasil = $mdy[2].' '.NamaBulan($mdy[1]).' '.$mdy[0];
	
	return $hasil;
}

function format_tgl_blnnmr($tanggal)
{
	$mdy = explode('-',$tanggal);
	$hasil = $mdy[2].'-'.$mdy[1].'-'.$mdy[0];
	
	return $hasil;
}

function unformat_tgl($tanggal)
{
	$mdy = explode('-',$tanggal);
	$hasil = $mdy[2].'-'.$mdy[1].'-'.$mdy[0];
	
	return $hasil;
}
	
function change_urut($a, $b, $c) 
{	
	$s = "";
	if ($a == $b) {
		if ($c == "ASC") 
			$s = "<img src ='../images/ico/descending copy.png'>";
		else 
			$s = "<img src ='../images/ico/ascending copy.png'>";
	} 	
	return $s;
}

function removetag($input,$length)
{
	$output = "";
	$ambil = 0;
	$charlength = strLen($input);
	for ($i = 0; $i <= $length; $i++)
	{
		$karakter=substr($input,$i,1);
		if ($ambil==1)
			$ambil=2;
		if ($karakter=="<" || $karakter=="&")
			$ambil=0;
		if ($karakter==">")
			$ambil=1;
		if ($ambil==2 && $karakter != "?")
			$output=$output.$karakter;
	}
	return $output;
}

function JmlHari($bln, $th) 
{
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
function is_empty_dir($dir)
{
    if ($dh = @opendir($dir))
    {
        while ($file = readdir($dh))
        {
            if ($file != '.' && $file != '..') {
                closedir($dh);
                return false;
            }
        }
        closedir($dh);
        return true;
    }
    else return false; // whatever the reason is : no such dir, not a dir, not readable
}
function chg_p_to_div($string){
	$content = str_replace('<p','<div',$string);
	$content = str_replace('</p>','</div>',$content);
	return $content;
}
function GetOSSlash(){
	global $G_OS;
	if ($G_OS=="win")
		return "\\";
	elseif ($G_OS=="lin")
		return "/";
}
function CQ($string){
	$string = trim($string);
	$string = str_replace("'","`",$string);
	$string = str_replace('"','`',$string);
	return $string;
}

function GetDatePart($value, $part)
{
	$inf = split("-", $value);
	$part = strtolower($part);
	
	if (count($inf) == 3)
	{
		if ($part == "d")
			return $inf[2];
		elseif ($part == "m")
			return $inf[1];
		elseif ($part == "y")
			return $inf[0];
	}
	else
	{
		return "";
	}
}

function RandomString($length)
{
    $set = "abcdefghijklmnoprstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ0123456789";
    
    $result = "";
    for($i = 0; $i < $length; $i++)
    {
        $ix = rand(0, strlen($set) - 1);
        $result .= substr($set, $ix, 1);
    }
    
    return $result;
}
?>